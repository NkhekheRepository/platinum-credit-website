# PCL Website — V2 Growth Map

Saved: 2026-08-25 · Theme at save: v1.6.2 · Scope: full audit results, seven-perspective validation, SWOT, expanded opportunity map, sequencing.

---

## 1. Technical Validation Scorecard

| Check | Result |
|---|---|
| Page status codes | PASS 5/5 core pages 200 · FAIL `/about/`, `/privacy-policy/`, `/terms-of-service/` = 404 |
| Titles | PASS all 60–65 chars, keyworded, unique |
| Meta descriptions | WARN 3 pages run 160–164 chars (truncate ~155–160 in SERP) |
| JSON-LD structured data | PASS valid — FinancialService graph (home); +Service+BreadcrumbList (products); 2 blocks elsewhere |
| robots.txt / sitemap | PASS both serve (localhost URLs — regenerate at deploy) |
| H1 uniqueness | PASS exactly 1 per page |
| Viewport / mobile meta | PASS present everywhere |
| og:image | PASS 1200×630 PNG, 32KB served |
| Favicon | FAIL `/favicon.ico` → 302 to HTML; `favicon.svg` → 404 |
| Placeholder text | PASS none remaining |
| Forms | PASS slider inputs label-associated (`for`/`id`) |
| Reduced-motion support | PASS 5 rules across base/components CSS |
| Touch targets | PASS 44px enforced via responsive.css |
| Security headers | FAIL none on dev http stack — required at deploy |
| Analytics/tracking | FAIL none installed |
| Media elements | FAIL zero video/audio/canvas; site is 100% CSS/SVG |
| Page weight | PASS ~140–150KB HTML, 11 external assets/page |
| Legacy dependencies | WARN jQuery + jquery-migrate + wp-emoji loaded |

### Critical bug: dead conversion CTAs (fixed v1.6.3)

Anchor targets (`#contact`, `#estimator`) exist only on home. Dead clicks on:
- `/products/` — See What You Qualify For (#estimator), Contact (#contact)
- `/estimator/` — Request a Formal Quote (#contact) ×2
- `/affordability/` — Book Your Full Assessment (#contact) ×2

Fix mechanism: hash-rescue handler in `js/nav.js` — missing target id redirects to its page via explicit slug map (`loans → products/`). Home keeps native smooth-scroll; DB-inlined copies fixed without rewrites.

---

## 2. Seven-Perspective Validation

1. **Multimedia Engineer** — Motion system clean (marquee, reveals, sheen, preloader) with reduced-motion respected. Site is media-silent: no photography/video/audio. A lending brand sells trust; current build cannot produce emotional trust at any scroll depth.
2. **Software Architect** — Sound skeleton: child theme + pcl-core plugin + file-driven patterns, versioned assets, lint gates, git-tracked zips. Architectural flaw: dual source of truth (pattern files AND inlined DB copies) caused two drift bugs (CBL placeholder, purple CTA). No staging/prod separation, no CI, untested Astra upgrade path.
3. **Graphics Engineer** — Coherent identity (gem/shard motif, purple-cyan system, tuned font fallbacks). Defects: broken favicon, gradient-banding risk on cheap panels, zero raster art direction.
4. **UX/UI Engineer** — Fundamentals solid post-1.6.2 (44px targets, focus rings, labeled controls, single-H1, AAA CTA contrast). Killer flaw was dead CTAs. lang="en-US" vs Lesotho en-GB convention. 7/10 → 9/10 with anchors fixed and forms added.
5. **Blender Engineer** — Greenfield: no 3D exists. Shard motif begs for a pre-rendered Blender hero loop (6–8s WebM + poster, reduced-motion off-switch, capped weight). Upside play, never blocking.
6. **Chief Marketing Officer** — Differentiated positioning (100% Basotho-owned, CBL Tier-2, FCPA-compliant copy, Re Lora Le Uena). Missing: About/story page, social proof entirely, content engine, measurement, legal pages (credibility poison for a lender).
7. **Lead Generator** — Best assets: client-side calculators + always-visible WhatsApp float. Broken funnel: primary CTAs were dead on 3/5 pages; no lead-capture form anywhere; calculators leak full results without asking contact details; zero pixels/attribution.

---

## 3. SWOT

**Strengths** — Distinctive branded design system; fast light pages; valid rich schema; compliant lending copy; privacy-first working calculators; accessibility fundamentals; disciplined repo/versioned deploys; ubiquitous WhatsApp.

**Weaknesses** — Dead CTAs on 3 pages (now fixed); missing about/legal pages; broken favicon; no lead capture; no analytics; DB↔file duplication risk; legacy jQuery/emoji ballast; zero imagery/social proof; localhost URLs until deploy.

**Opportunities** — In-calculator lead capture; GBP local dominance; segment landing pages; content engine; Sesotho variants; testimonial/proof layer; Blender hero; micro-tool suite; measurement flywheel with A/B cadence.

**Threats** — Domain still unpointed (market-invisible while competitors compound); fresh domain vs rivals' review moats; credit-marketing compliance misstep risk; untested WP/Astra updates; single-admin bus factor; SEO map linking 404s damages crawl quality.

---

## 4. Expanded Opportunity Map

### A. Conversion layer (highest ROI)
| # | Opportunity | Impact | Cost |
|---|---|---|---|
| A1 | In-calculator lead capture ("WhatsApp me these figures" after results) | Converts existing intent into callable leads; highest revenue-per-effort | S |
| A2 | Context-prefilled WhatsApp deep links (`?text=` prefix per CTA) | Reduces friction + free attribution via message prefix | S |
| A3 | Callback booking strip (pick a time → PCL calls) | Converts fence-sitters; payroll lending is won on follow-up speed | S |
| A4 | Sticky mobile action bar (Call · WhatsApp · Apply at thumb zone) | Mobile-first market; removes scroll-back friction at peak interest | S |

### B. Discoverability layer
| # | Opportunity | Impact | Cost |
|---|---|---|---|
| B1 | Google Business Profile (reviews, map pack "loans Maseru") | Map pack outranks websites for local lending; free compounding | S |
| B2 | Segment landing pages (teachers, police/LDF, health workers, civil servants*) | Near-zero competition keywords; message-match lifts rank+conversion | M |
| B3 | Financial-literacy content engine (10% p/a real cost, FCPA rights, cooling-off) | Low-competition queries; regulator-aligned positioning as transparent lender | M |
| B4 | Sesotho content variant on key pages | Trust multiplier; rivals are English-only; widens keyword surface | M |

### C. Proof layer
| # | Opportunity | Impact | Cost |
|---|---|---|---|
| C1 | Testimonial system (written → 30–60s video upgrade path) | Fixes single weakest asset; lifts conversion site-wide | S→M |
| C2 | Trust badge strip at decision points (CBL Licensed · Since 2020 · Basotho-Owned · FCPA) | Credentials exist but buried in footer prose | S |
| C3 | Team & office photography (faces, Thulo Building) | Scam-fear antidote; cheapest authenticity lever | S |

### D. Experience layer
| # | Opportunity | Impact | Cost |
|---|---|---|---|
| D1 | Blender gem/shard hero loop (WebM + poster, reduced-motion fallback) | Premium fintech perception, memorability, shares | L |
| D2 | Micro-tool suite (debt-consolidation checker, early-settlement saver) | New entry keywords + new capture points; reuses calc engine | M |
| D3 | Shareable branded result card from calculators | Turns users into distributors | M |

### E. Measurement flywheel
| # | Opportunity | Impact | Cost |
|---|---|---|---|
| E1 | GA4 + Clarity + events (`calculator_completed`, `whatsapp_click`, `tel_click`, `form_submit`) | Makes every A-item provable | S |
| E2 | Monthly 1-variable A/B on money buttons | Compounds conversion rate permanently | M |

*assumed core payroll segments given payslip-verification model

---

## 5. Sequencing Roadmap

```
Week 1 (with launch):  P0 fixes + A1 A2 A4 + E1 + C2   ← capture + measure from day 1
Week 2–3:              B1 GBP + C1 C3 proof layer + A3
Month 2:               B2 segments + B3 content engine + D2
Quarter 2:             D1 Blender hero + D3 sharing + B4 Sesotho
```

**The three bets:** A1 in-calculator capture (monetizes existing traffic immediately) · B1 GBP (owns local search for free) · C1+C3 proof (fixes the deficit design cannot).

---

## Changelog

| Version | Date | Change |
|---------|------|--------|
| V2 | 2026-08-25 | Full audit saved; dead CTAs fixed v1.6.3; opportunity map expanded |
