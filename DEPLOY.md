# PCL — Deploy to Live WordPress (Production)

> Theme: `pcl-child` v1.6.0 (SEO top-1%, mobile-perfect) + `pcl-core` plugin
> Repo: https://github.com/NkhekheRepository/platinum-credit-website
> Artifacts: `pcl-child.zip` (96K) · `pcl-core.zip` (5.4K) in repo root & `/tmp/pcl-deploy/`
> Domain target: `www.pcl.co.ls` (assets, canonicals & JSON-LD already point here; `home_url()` adapts automatically)

---

## 0) You Have No Hosting Yet — Recommended Path

### Hosting Recommendation (Lesotho / SA latency matters for SEO + UX)

| Provider | Plan | Price (approx) | Data Center near LS | cPanel / 1-click WP | Free SSL | Why for PCL |
|----------|------|----------------|---------------------|---------------------|----------|-------------|
| **Hostinger** — Single Web Hosting | 1 WP site, 10GB | $2.99/mo | Netherlands / UK (CDN included) | Yes | Yes (Let’s Encrypt) | Cheapest, beginner-friendly, 1-click WP, ideal for first year |
| **Hetzner** — Web Hosting Level 1 | 1 WP site, 10GB | €5.08/mo | **Falkenstein/Nuremberg + SA via Cloudflare CDN** | Yes (konsoleH) | Yes | EU reliability, excellent uptime, SA CDN PoP = fast in Maseru |
| **xneelo (SA)** — Starter | 1 WP site, 5GB | R99/mo (~$5.5) | **Johannesburg** (lowest latency to Lesotho) | Yes | Yes | Lowest latency, SA support, ZAR billing — recommended if budget allows |
| **Afrihost (SA)** — Shared | 1 WP site | R99/mo | Johannesburg | Yes | Yes | SA alternative |

**Recommendation for PCL:** **xneelo or Hostinger**. xneelo for best speed in Lesotho (Jo’burg DC, <30ms to Maseru); Hostinger for lowest cost with CDN compensating distance. Avoid US-only hosts (slow TTFB hurts rankings).

Any of the above gives you: domain pointing, 1-click WordPress, cPanel/SFTP, free SSL, daily backups — everything needed for this theme.

### Domain

- If you already own `pcl.co.ls`, skip registration — just point it (step 2).
- If not: register `.co.ls` via **LSNIC (nic.ls)** or international registrar supporting `.ls` (101domain, Marcaria, Namecheap). Cost ~$40-70/yr for `.co.ls`. Also register `www.pcl.co.ls` as alias (host handles).

---

## 1) Purchase Hosting & Create WordPress

1. Buy one of the plans above.
2. Host will email you: **cPanel URL + username + password**, plus **nameservers** (e.g. `ns1.dns-parking.com`) or an **A-record IP**.
3. **Point domain:**
   - Option A (nameservers): at your domain registrar, replace nameservers with host’s (takes 2-24h to propagate).
   - Option B (A-record): keep registrar DNS, add `A  @  ->  HOST_IP` and `A  www  ->  HOST_IP`.
4. In hosting panel, click **Auto Installer → WordPress → Install** (or “1-click WP”). Create admin user (save credentials). Choose HTTPS.

After install, your site will be at `https://www.pcl.co.ls` (empty default theme).

---

## 2) Deploy Theme + Plugin (3 options — pick one you have)

### Option A — WP Admin Upload (no FTP needed, simplest)

1. Login to `https://www.pcl.co.ls/wp-admin` (admin user from step 1).
2. **Appearance → Themes → Add New → Upload Theme** → select `pcl-child.zip` → Install → **Do NOT activate yet**.
3. **Plugins → Add New → Upload Plugin** → select `pcl-core.zip` → Install → Activate.
4. **Appearance → Themes** → Install **Astra** (search “Astra” by Brainstorm Force) → Install.
5. Now activate **PCL Child**.
6. **Appearance → Themes** verifies: PCL Child shows “Template: astra”.

Zips are in this repo root: download them via GitHub → `pcl-child.zip` / `pcl-core.zip` (or `git clone` and zip yourself).

### Option B — SFTP / cPanel File Manager

```bash
# SFTP
sftp u123456@your-host.com
put pcl-child.zip
put pcl-core.zip

# SSH (if host gives SSH)
ssh u123456@your-host.com
unzip -o pcl-child.zip -d ~/public_html/wp-content/themes/
unzip -o pcl-core.zip -d ~/public_html/wp-content/plugins/
# then activate in WP admin
```

Or via **cPanel → File Manager**: upload zips to `wp-content/themes/` and `wp-content/plugins/` → Extract.

### Option C — Git Clone (if host gives SSH + Git)

```bash
ssh u123456@your-host.com
cd ~/public_html/wp-content/themes
git clone https://github.com/NkhekheRepository/platinum-credit-website.git pcl-child-tmp
cp -r pcl-child-tmp/wp-content/themes/pcl-child ./pcl-child
cp -r pcl-child-tmp/wp-content/plugins/pcl-core ../plugins/pcl-core
# Astra from wp.org
wp theme install astra --activate   # if WP-CLI available
wp theme activate pcl-child
wp plugin activate pcl-core
```

---

## 3) WordPress Configuration (5 min)

In `wp-admin`:

1. **Settings → General**: Site Title `Platinum Credit Ltd`, Tagline `Re Lora Le Uena`, Site URL `https://www.pcl.co.ls`.
2. **Settings → Permalinks**: select **Post name** → Save (enables `/%postname%/` — required for SEO canonicals).
3. **Settings → Reading**: set **Your homepage displays → A static page → Homepage: Home** (you’ll create it next). Leave Posts page empty.
4. **Settings → Discussion**: uncheck “Allow link notifications” if not needed.
5. **Plugins**: confirm `PCL Core` is Active.

---

## 4) Create Pages (using block patterns — no import needed)

The theme registers **Platinum Credit Sections** patterns under **Patterns → Platinum Credit Sections**.

1. **Pages → Add New** for each slug:

| Title | Slug | Pattern(s) to insert |
|-------|------|----------------------|
| Home | `home` (set as front page) | Hero + Marquee + Counters + Why/Values + Products grid + Rate band + CTA |
| Products | `products` | Products 6-card grid (Service schema auto on this slug) |
| Estimator | `estimator` | Estimator tool (glass panel, range sliders) |
| Affordability | `affordability` | Affordability checker (2-col glass) |
| Contact | `contact` | Contact strip + form (pcl-core shortcode) |
| About | `about` | About / Values |
| Privacy Policy | `privacy-policy` | Text |
| Terms of Service | `terms-of-service` | Text |

2. For each page: **Insert pattern → Publish**. Front page will automatically use keyword-optimized title/description from `pcl_seo_map()`.

> Alternative (WP-CLI on SSH hosts): `bash scripts/import-content.sh` inside a docker checkout imports all `seed/pages/*.html` idempotently. On shared hosts without SSH, use the manual pattern method above.

---

## 5) SSL & Security

- Host’s **SSL → Free Let’s Encrypt → Enable** → Force HTTPS (host does this automatically on 1-click installs).
- Verify padlock at `https://www.pcl.co.ls` and `https://www.pcl.co.ls/wp-sitemap.xml` loads.
- `robots.txt` is dynamic; theme filter ensures `Sitemap: https://www.pcl.co.ls/wp-sitemap.xml` is present.

---

## 6) Verification Checklist (post-deploy)

Run these in browser / curl:

```bash
curl -s https://www.pcl.co.ls/ | grep -i "canonical\|og:image\|FinancialService\|BreadcrumbList" | head -20
curl -s https://www.pcl.co.ls/wp-sitemap.xml | head -20
curl -s https://www.pcl.co.ls/robots.txt
```

Manual:

- [ ] All 8 pages load, nav/footer interlink, no 404s
- [ ] Contact form submits (pcl-core), estimator/affordability sliders calculate
- [ ] Mobile: 0 horizontal scroll at 390px, hamburger works, 44px touch targets
- [ ] Social share preview shows `og-image.png` (1200×630)
- [ ] Rich Results Test (https://search.google.com/test/rich-results) → FinancialService + BreadcrumbList valid
- [ ] PageSpeed Insights mobile ≥90 (preconnect, defer, font size-adjust already optimized)

---

## 7) What’s Already Done for SEO (v1.6.0)

- Keyword-mapped `<title>` + meta descriptions (147-160 chars)
- Canonical per page, `og:` + `twitter:` with image dims, `en_GB` locale
- JSON-LD: `FinancialService` (NAP, geo Maseru, hours), `BreadcrumbList`, `Service` graph, `Organization` logo
- `robots.txt` sitemap declaration, WP core sitemap enabled
- Preconnect fonts, defer non-critical JS, font fallback size-adjust (CLS≈0)

---

## Need Help?

If you share **host choice + cPanel/SFTP credentials** (after purchase), I can execute sections 2-6 for you directly. Alternatively, share **WP admin** login and I’ll upload via admin.

Zips ready at: `https://github.com/NkhekheRepository/platinum-credit-website` (root) or `/tmp/pcl-deploy/` locally.

