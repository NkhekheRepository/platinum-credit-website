#!/usr/bin/env bash
# PCL local setup bootstrap.
# Installs WP-CLI (if missing), starts the stack, and runs a one-shot WP install.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

# 0. Copy env if missing
[ -f .env ] || cp .env.example .env

# 1. WP-CLI
if [ ! -f tools/wp-cli.phar ]; then
  echo ">> Downloading WP-CLI..."
  curl -sSL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -o tools/wp-cli.phar
fi

# 2. Start stack
echo ">> Starting Docker stack..."
docker compose up -d

# 3. Wait for DB + WP readiness
echo ">> Waiting for WordPress..."
until docker exec pcl-wordpress curl -s -o /dev/null http://localhost:80/wp-admin/install.php; do sleep 2; done
echo ">> WordPress container responding."

wp() { docker exec -u www-data pcl-wordpress php /opt/tools/wp-cli.phar "$@"; }

# 4. Install core (idempotent)
if wp core is-installed >/dev/null 2>&1; then
  echo ">> WordPress already installed; skipping core install."
else
  echo ">> Installing WordPress..."
  wp core install \
    --url="http://localhost:8080" \
    --title="PCL — Professional Services & Consulting" \
    --admin_user="${WP_ADMIN_USER:-admin}" \
    --admin_password="${WP_ADMIN_PASSWORD:-pcl-admin-2026!}" \
    --admin_email="admin@pcl.local" \
    --skip-email
fi

# 5. Baseline configuration
wp rewrite structure '/%postname%/' --hard
wp option update timezone_string 'UTC' --format=plain 2>/dev/null || true
wp option update blogdescription 'Clarity, capability, and results for growing businesses.' 2>/dev/null || true

echo ">> Setup complete. Site: http://localhost:8080  (admin user: ${WP_ADMIN_USER:-admin})"