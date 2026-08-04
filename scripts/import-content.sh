#!/usr/bin/env bash
# PCL content import — pages, posts, menus, footer widgets, options.
# Idempotent: re-running updates existing items where possible.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

wp() { docker exec -u www-data pcl-wordpress php /opt/tools/wp-cli.phar "$@"; }

echo ">> Importing pages..."
import_page() {
	local file="$1" title="$2" slug="$3"
	local id
	id=$(wp post list --post_type=page --name="$slug" --field=ID --format=ids 2>/dev/null || true)
	if [ -z "$id" ]; then
		if [ -n "$file" ]; then
			id=$(wp post create "/opt/seed/pages/$file" --post_type=page --post_title="$title" --post_name="$slug" --post_status=publish --porcelain)
		else
			id=$(wp post create --post_type=page --post_title="$title" --post_name="$slug" --post_status=publish --post_content="" --porcelain)
		fi
		printf '  + page %s (%s)\n' "$slug" "$id" >&2
	else
		if [ -n "$file" ]; then
			wp post update "$id" "/opt/seed/pages/$file" --post_title="$title" >/dev/null
		fi
		printf '  = page %s updated (%s)\n' "$slug" "$id" >&2
	fi
	printf '%s' "$id"
}

HOME_ID=$(import_page "home.html" "Home" "home")
import_page "services.html" "Services" "services" >/dev/null
import_page "service-business-consulting.html" "Business Consulting" "business-consulting" >/dev/null
import_page "service-digital-implementation.html" "Digital Implementation" "digital-implementation" >/dev/null
import_page "service-managed-support.html" "Managed Support" "managed-support" >/dev/null
import_page "service-training-enablement.html" "Training & Enablement" "training-enablement" >/dev/null
import_page "about.html" "About" "about" >/dev/null
import_page "contact.html" "Contact" "contact" >/dev/null
import_page "privacy-policy.html" "Privacy Policy" "privacy-policy" >/dev/null
import_page "terms-of-service.html" "Terms of Service" "terms-of-service" >/dev/null
import_page "" "Insights" "insights" >/dev/null

echo ">> Configuring front page..."
wp option update show_on_front page >/dev/null
wp option update page_on_front "$HOME_ID" >/dev/null
echo "  front page = $HOME_ID"

echo ">> Importing posts..."
docker exec -u www-data pcl-wordpress bash -c '
WPC() { php /opt/tools/wp-cli.phar "$@"; }
for f in /opt/seed/posts/*.html; do
	slug=$(basename "$f" .html)
	title=$(grep -oP "(?<=<h2 class=\"wp-block-heading\">)[^<]+" "$f" | head -1)
	title=${title:-$slug}
	id=$(WPC post list --post_type=post --name="$slug" --field=ID --format=ids 2>/dev/null)
	if [ -z "$id" ]; then
		id=$(WPC post create "$f" --post_type=post --post_title="$title" --post_name="$slug" --post_status=publish --porcelain)
		echo "  + post $slug ($id)"
	else
		WPC post update "$id" "$f" --post_title="$title" --post_status=publish >/dev/null
		echo "  = post $slug updated ($id)"
	fi
done
WPC post delete 1 --force >/dev/null 2>&1 || true
' | grep -E "^  [+=]"

echo ">> Posts index page..."
BLOG_ID=$(wp post list --post_type=page --name=insights --field=ID 2>/dev/null | head -1)
[ -n "$BLOG_ID" ] && wp option update page_for_posts "$BLOG_ID" >/dev/null
echo "  page_for_posts = $BLOG_ID"

echo ">> Menu setup..."
menu_id() {
	docker exec -u www-data pcl-wordpress php /opt/tools/wp-cli.phar eval 'echo get_term_by( "name", "'"$1"'", "nav_menu" ) ? get_term_by( "name", "'"$1"'", "nav_menu" )->term_id : "";' 2>/dev/null
}

PRIMARY=$(menu_id "Primary")
if [ -z "$PRIMARY" ]; then
	PRIMARY=$(wp menu create "Primary" --porcelain)
fi
echo "  primary menu id=$PRIMARY"

pgid() { wp post list --post_type=page --name="$1" --field=ID 2>/dev/null | head -1; }

wp menu item add-post "$PRIMARY" "$(pgid home)" --title="Home" >/dev/null 2>&1 || true

SERVICES_PAGE_ID=$(pgid services)
SERVICES_ITEM=$(wp menu item add-post "$PRIMARY" "$SERVICES_PAGE_ID" --title="Services" --porcelain 2>/dev/null || true)
for slug in business-consulting digital-implementation managed-support training-enablement; do
	pid=$(pgid "$slug")
	[ -n "$pid" ] && wp menu item add-post "$PRIMARY" "$pid" --title="$slug" --parent-id="$SERVICES_ITEM" >/dev/null 2>&1 || true
done
wp menu item add-post "$PRIMARY" "$(pgid about)" --title="About" >/dev/null 2>&1 || true
wp menu item add-post "$PRIMARY" "$(pgid insights)" --title="Insights" >/dev/null 2>&1 || true
wp menu item add-post "$PRIMARY" "$(pgid contact)" --title="Contact" >/dev/null 2>&1 || true
wp menu item add-custom "$PRIMARY" "Get a Quote" "/contact/" --classes="pcl-cta" --position=99 >/dev/null 2>&1 || true

wp menu location assign "$PRIMARY" primary 2>&1 | tail -1 || true

echo ">> Footer..."
wp menu create "Footer" >/dev/null 2>&1 || true
FOOTER=$(menu_id "Footer")
for slug in services about insights contact privacy-policy terms-of-service; do
	pid=$(pgid "$slug")
	[ -n "$pid" ] && wp menu item add-post "$FOOTER" "$pid" --title="$slug" >/dev/null 2>&1 || true
done
wp menu location assign "$FOOTER" footer_menu 2>&1 | tail -1 || true

echo ">> Footer widgets..."
wp widget add nav_menu footer-widget-1 1 --title="Quick links" --nav_menu="$FOOTER" >/dev/null 2>&1 || true
wp widget add text footer-widget-2 2 --title="Contact" --text='<p>200 Market Street, Suite 400<br>San Francisco, CA 94105</p><p><a href="mailto:hello@pcl.example">hello@pcl.example</a><br><a href="tel:+15550001234">+1 (555) 000-1234</a></p>' >/dev/null 2>&1 || true
wp widget add text footer-widget-1 3 --title="© 2026 PCL. All rights reserved." --text='PCL — Professional Services &amp; Consulting.' >/dev/null 2>&1 || true

echo ">> Footer bar layout (Astra settings)..."
docker exec -u www-data pcl-wordpress php /opt/tools/wp-cli.phar eval '
$s = get_option( "astra-settings", array() );
$s = array_merge( $s, array(
	"footer-sml-layout" => "ast-footer-sml-layout-1",
	"footer-sml-section-1" => "widget",
	"footer-sml-section-2" => "none",
) );
update_option( "astra-settings", $s );
echo "  footer settings applied" . PHP_EOL;
' 2>&1

echo ">> Flushing permalinks..."
wp rewrite flush --hard >/dev/null 2>&1 || true
echo ">> Import complete."