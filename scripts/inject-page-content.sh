#!/bin/bash
# Inject block content into all 9 Platinum Credit pages
set -euo pipefail

WPCLI="docker exec -u www-data pcl-wordpress php /opt/tools/wp-cli.phar"
TMPDIR="/tmp/pcl-content"
mkdir -p "$TMPDIR"

echo "=== Phase 1: Populating page content ==="

# ---------- HOME (ID 81) ----------
echo ">> Home (81)"
cat > "$TMPDIR/home.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-hero","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-hero">
<!-- wp:group {"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">100% Basotho-Owned · Tier 2 Licensed by the Central Bank of Lesotho</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"className":"pcl-brand-grad"} -->
<h1 class="wp-block-heading pcl-brand-grad">Re lora le uena.<br>We dream with you.</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Platinum Credit Ltd bridges the financial gap for Basotho — practical, affordable loans for salaried employees, entrepreneurs, and communities often excluded from traditional banking. At competitive rates.</p>
<!-- /wp:paragraph -->
<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left","gap":"16px"}} -->
<div class="wp-block-group">
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#estimator">Estimate Your Loan</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#loans">Explore Products</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"pcl-hero-meta","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left","gap":"32px"}} -->
<div class="wp-block-group pcl-hero-meta">
<!-- wp:paragraph -->
<p><strong>10% p/a</strong><br><span>Competitive rates</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><strong>2020</strong><br><span>Founded in Maseru</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><strong>Tier 2</strong><br><span>CBL licensed &amp; supervised</span></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-band-navy pcl-section-tight","data-count-target":"true","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section-tight" data-count-target="true">
<!-- wp:columns {"verticalAlignment":"center","className":"pcl-stagger"} -->
<div class="wp-block-columns are-vertically-aligned-center pcl-stagger">
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column are-vertically-aligned-center">
<!-- wp:paragraph {"className":"pcl-stat"} -->
<p class="pcl-stat"><span class="pcl-count pcl-tabular" data-to="10">0</span>% p/a<br><span class="pcl-stat-label">Competitive market rate</span></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column are-vertically-aligned-center">
<!-- wp:paragraph {"className":"pcl-stat"} -->
<p class="pcl-stat"><span class="pcl-count pcl-tabular" data-to="120">0</span> months<br><span class="pcl-stat-label">Terms from 3 months</span></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column are-vertically-aligned-center">
<!-- wp:paragraph {"className":"pcl-stat"} -->
<p class="pcl-stat"><span class="pcl-count pcl-tabular" data-to="100">0</span>%<br><span class="pcl-stat-label">Basotho-owned</span></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column are-vertically-aligned-center">
<!-- wp:paragraph {"className":"pcl-stat"} -->
<p class="pcl-stat"><span class="pcl-count pcl-tabular" data-to="6">0</span> products<br><span class="pcl-stat-label">For every ambition</span></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section","id":"loans","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section" id="loans">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Our Products</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Loans built for every Mosotho ambition.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Short-term loans for civil and private sector employees as well as micro, small and medium entrepreneurs — priced to be genuinely affordable.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">01</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Salary-Based Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Accessible short-term micro-credit for salaried individuals, with manageable repayment terms deducted conveniently from payroll.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">02</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Emergency Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Small, quick-disbursing loans for unexpected needs — medical costs, urgent repairs — when time matters most.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">03</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Individual Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>For education fees, home improvements, or essential asset purchases — investments in your family's future.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">04</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Microenterprise Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Short-term working capital for inventory, equipment, or business expansion — fuel for Lesotho's traders and artisans.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">05</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Agri-Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Seasonal input loans for seeds and fertiliser, equipment financing, and post-harvest storage loans tailored to farming cycles.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">06</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Group Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Solidarity lending to registered savings groups like mekhatlo (stokvels), based on mutual guarantee and community trust.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:group {"className":"pcl-rate-band pcl-reveal","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-rate-band pcl-reveal">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Competitive interest rates — 10% p/a.</h3>
<!-- /wp:heading -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#estimator">See What You Qualify For</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-band-navy pcl-section","id":"how","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section" id="how">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">How It Works</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Simple processes. Responsible lending.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Minimal documentation, fast turnaround, and rigorous affordability assessments to prevent over-indebtedness.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">I</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Apply</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Visit us at Thulo Building or the BNP Center branch in Maseru with your ID, latest payslip or business records, and bank statements.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">II</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Affordability Check</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>A rigorous, documented assessment of your income and commitments — protecting you from over-indebtedness.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">III</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Sign With Clarity</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Clear terms, conditions, and pricing with no hidden fees. You see the full cost of credit before you commit.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">IV</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Receive &amp; Grow</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Fast disbursement to your account — then flexible, manageable repayments while you build your business, home, or future.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section","id":"estimator","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section" id="estimator">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Loan Estimator</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">See your instalment before you apply.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Move the sliders to estimate a monthly repayment at our 10% per annum rate. Our team confirms your personalised offer after a full affordability assessment.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:shortcode -->
[pcl_estimator]
<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section","id":"affordability","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section" id="affordability">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Affordability Self-Assessment</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Check what your paycheck can carry — before you apply.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Responsible lending starts with you. Enter your figures below to see your maximum comfortable instalment. Everything is calculated on your device — nothing is sent or stored.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:shortcode -->
[pcl_affordability]
<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section","id":"values","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section" id="values">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Why Choose Us</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Community rooted. Regionally bold.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">We don't just serve communities — we're part of them. Our success is measured by their prosperity.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Deep Lesotho Expertise</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We understand the local market, culture, and challenges intimately — products designed with and for the people of Lesotho.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Inclusive Empowerment</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Levelling the financial playing field so women, youth, entrepreneurs, and marginalised communities get the tools they need to thrive.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Integrity &amp; Trust</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Relationships built on transparency, ethical lending, and accountability — with clear pricing and no hidden fees.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Innovation for Impact</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Embracing technology and creative solutions to make finance faster, simpler, and more accessible across Lesotho.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Resilience &amp; Hustle</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We champion the grit of small business owners and adapt alongside them — turning challenges into opportunities for growth.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Strong Governance</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Robust risk management and full adherence to Central Bank of Lesotho regulations, led by an experienced Board of Directors.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-band-navy pcl-section","id":"contact","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section" id="contact">
<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%">
<!-- wp:group {"className":"pcl-reveal","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Contact Us</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Let's start dreaming together.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Walk in, call, or write — our team will guide you from first question to final payout.</p>
<!-- /wp:paragraph -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Head Office</strong><br>Thulo Building, Maseru 100, Lesotho</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Maseru Branch</strong><br>Room 11, BNP Center, Maseru 100, Lesotho</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Office Lines</strong><br><a href="tel:+26622324412">+266 2232 4412</a> · <a href="tel:+26652011000">+266 5201 1000</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>WhatsApp</strong><br><a href="https://wa.me/26669457676" target="_blank" rel="noopener">+266 6945 7676</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Email</strong><br><a href="mailto:info@pcl.co.ls">info@pcl.co.ls</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Web</strong><br><a href="https://www.pcl.co.ls" target="_blank" rel="noopener">www.pcl.co.ls</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%">
<!-- wp:group {"className":"pcl-reveal","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-reveal">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Office Hours</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Monday — Friday: 08:00 — 17:00<br>Saturday: 08:30 — 13:00<br>Sunday &amp; Public Holidays: Closed</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"width":100,"className":"is-style-fill"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-fill"><a class="wp-block-button__link wp-element-button" href="mailto:info@pcl.co.ls">Start Your Application</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<!-- wp:paragraph {"className":"pcl-sub","fontSize":"small"} -->
<p class="pcl-sub has-small-font-size" style="font-size:0.85rem;opacity:0.8">Bring your ID, latest payslip or business records, and recent bank statements to speed up your assessment.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-cta pcl-section-tight pcl-reveal","layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group pcl-cta pcl-section-tight pcl-reveal">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Ready to start dreaming?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textAlign":"center"} -->
<p class="has-text-align-center">Use our estimator to see what your loan could look like — then talk to us.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","gap":"16px"}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#estimator">Try the Estimator</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#contact">Contact Us</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section-tight","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section-tight">
<!-- wp:separator {"className":"pcl-divider-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity pcl-divider-wide"/>
<!-- /wp:separator -->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Platinum Credit Ltd is a 100% Basotho-owned microfinance institution and registered credit provider, licensed and supervised by the Central Bank of Lesotho (Tier 2). Every application undergoes an affordability assessment — we will not extend credit an assessment indicates you cannot reasonably repay. A full pre-agreement statement of cost is provided before any funds are advanced, and a statutory cooling-off period and early-settlement options apply in line with the Financial Consumer Protection Act No. 7 of 2022. Interest rates and fees shown on this site are indicative; your binding cost of credit is set out in your personalised quotation. Borrow responsibly.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6A5F78"}}} -->
<p class="has-small-font-size" style="color:#6A5F78">CBL Registration No.: [insert once verified against the CBL listing]</p>
<!-- /wp:paragraph -->
<!-- wp:separator {"className":"pcl-divider-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity pcl-divider-wide"/>
<!-- /wp:separator -->
<!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column are-vertically-aligned-center" style="flex-basis:50%">
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">© 2026 Platinum Credit Ltd. All rights reserved.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column are-vertically-aligned-center" style="flex-basis:50%">
<!-- wp:paragraph {"align":"right","fontSize":"small"} -->
<p class="has-text-align-right has-small-font-size">Thulo Building, Maseru 100, Lesotho · <a href="tel:+26622324412">+266 2232 4412</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 81 --post_content="$(cat "$TMPDIR/home.html")" 2>/dev/null
echo "  Home updated."

# ---------- ABOUT (ID 82) ----------
echo ">> About (82)"
cat > "$TMPDIR/about.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-band-navy pcl-section","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Who We Are</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Financial inclusion, cut like a gem.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Founded in September 2020 and headquartered in Maseru, Platinum Credit Ltd is a dedicated 100% Basotho-owned, Tier 2 licensed microfinance and registered credit provider with the Central Bank of Lesotho. We serve individuals in the public and private sectors, as well as micro, small and medium businesses — empowering clients to start or grow businesses, manage household cash flow, invest in education, build assets, and weather financial shocks.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Our Journey</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">From a single idea to a national mission.</h2>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">2020</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Licensed &amp; Established</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Officially licensed as a microfinance institution, committed to responsible, accessible credit for every Mosotho.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">2021</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Tier 2 Elevation</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Elevated to Tier 2 status in just one year, reflecting rapid growth, operational soundness, and regulatory adherence.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column -->
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">2025</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Operations Resumed</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Following the settlement of a protracted legal matter, PCL resumed full operations, stronger and recommitted to Basotho.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Our Mission</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Empowering Basotho to build prosperous lives.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">We believe every person in Lesotho deserves access to fair, transparent financial services. Our mission is to bridge the gap between ambition and opportunity through responsible lending, community partnerships, and innovative solutions tailored to the real needs of our clients.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 82 --post_content="$(cat "$TMPDIR/about.html")" 2>/dev/null
echo "  About updated."

# ---------- PRODUCTS (ID 83) ----------
echo ">> Products (83)"
cat > "$TMPDIR/products.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-band-navy pcl-section","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Products &amp; Services</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Loans built for every Mosotho ambition.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Short-term loans for civil and private sector employees as well as micro, small and medium entrepreneurs — priced to be genuinely affordable for our target market.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"pcl-section","id":"loans","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section" id="loans">
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">01</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Salary-Based Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Accessible short-term micro-credit for salaried individuals, with manageable repayment terms deducted conveniently from payroll. Quick approval, flexible terms from 3–36 months, and rates designed to protect your take-home pay.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">02</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Emergency Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Life doesn't wait. Small, quick-disbursing loans for unexpected needs — medical costs, urgent repairs — when time matters most. Disbursed within hours of approval.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column -->
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">03</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Individual Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>For education fees, home improvements, or essential asset purchases — investments in your family's future. Personalised lending tailored to your repayment capacity.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">04</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Microenterprise Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Working capital for traders, artisans, and small businesses. Short-term financing for inventory, equipment, or business expansion — growth-focused with repayment aligned to your business cycle.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">05</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Agri-Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Seasonal input loans for seeds and fertiliser, equipment financing, and post-harvest storage loans tailored to farming cycles. Harvest-aligned repayment schedules.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-card-num"} -->
<p class="pcl-card-num">06</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Group Loans</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Solidarity lending to registered savings groups like mekhatlo (stokvels), cooperatives, and community groups. Based on mutual guarantee and community trust.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:group {"className":"pcl-rate-band pcl-reveal","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-rate-band pcl-reveal">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Competitive interest rates — 10% p/a.</h3>
<!-- /wp:heading -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#estimator">See What You Qualify For</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 83 --post_content="$(cat "$TMPDIR/products.html")" 2>/dev/null
echo "  Products updated."

# ---------- HOW IT WORKS (ID 84) ----------
echo ">> How It Works (84)"
cat > "$TMPDIR/how.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-band-navy pcl-section","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Our Approach</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Simple processes. Responsible lending.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Minimal documentation, fast turnaround, and rigorous affordability assessments to prevent over-indebtedness — because our clients' trust is the foundation of everything we do.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">I</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Apply</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Visit us at Thulo Building or the BNP Center branch in Maseru with your ID, latest payslip or business records, and bank statements.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">II</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Affordability Check</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>A rigorous, documented assessment of your income and commitments — protecting you from over-indebtedness, not just qualifying you.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">III</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Sign With Clarity</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Clear terms, conditions, and pricing with no hidden fees. You see the full cost of credit before you commit.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph {"className":"pcl-step-key"} -->
<p class="pcl-step-key">IV</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Receive &amp; Grow</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Fast disbursement to your account — then flexible, manageable repayments while you build your business, home, or future. You can settle early at any time.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 84 --post_content="$(cat "$TMPDIR/how.html")" 2>/dev/null
echo "  How It Works updated."

# ---------- ESTIMATOR (ID 85) ----------
echo ">> Estimator (85)"
cat > "$TMPDIR/estimator.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-band-navy pcl-section","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Loan Estimator</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">See your instalment before you apply.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Move the sliders to estimate a monthly repayment at our 10% per annum rate. Our team confirms your personalised offer after a full affordability assessment.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#contact">Request a Formal Quote</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
<!-- wp:shortcode -->
[pcl_estimator]
<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 85 --post_content="$(cat "$TMPDIR/estimator.html")" 2>/dev/null
echo "  Estimator updated."

# ---------- AFFORDABILITY (ID 86) ----------
echo ">> Affordability (86)"
cat > "$TMPDIR/affordability.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-section","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-section">
<!-- wp:group {"className":"section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Affordability Self-Assessment</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Check what your paycheck can carry — before you apply.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Responsible lending starts with you. Enter your figures below to see your maximum comfortable instalment and the loan amount it could support. Everything is calculated on your device — nothing is sent or stored.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:shortcode -->
[pcl_affordability]
<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 86 --post_content="$(cat "$TMPDIR/affordability.html")" 2>/dev/null
echo "  Affordability updated."

# ---------- CONTACT (ID 87) ----------
echo ">> Contact (87)"
cat > "$TMPDIR/contact.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-band-navy pcl-section","id":"contact","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section" id="contact">
<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%">
<!-- wp:group {"className":"pcl-reveal","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Contact Us</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Let's start dreaming together.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Walk in, call, or write — our team will guide you from first question to final payout.</p>
<!-- /wp:paragraph -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Head Office</strong><br>Thulo Building, Maseru 100, Lesotho</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Maseru Branch</strong><br>Room 11, BNP Center, Maseru 100, Lesotho</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Office Lines</strong><br><a href="tel:+26622324412">+266 2232 4412</a> · <a href="tel:+26652011000">+266 5201 1000</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>WhatsApp</strong><br><a href="https://wa.me/26669457676" target="_blank" rel="noopener">+266 6945 7676</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"className":"pcl-stagger"} -->
<div class="wp-block-columns pcl-stagger">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Email</strong><br><a href="mailto:info@pcl.co.ls">info@pcl.co.ls</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pcl-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-card">
<!-- wp:paragraph -->
<p><strong>Web</strong><br><a href="https://www.pcl.co.ls" target="_blank" rel="noopener">www.pcl.co.ls</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%">
<!-- wp:group {"className":"pcl-reveal","layout":{"type":"constrained"}} -->
<div class="wp-block-group pcl-reveal">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Office Hours</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Monday — Friday: 08:00 — 17:00<br>Saturday: 08:30 — 13:00<br>Sunday &amp; Public Holidays: Closed</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"width":100,"className":"is-style-fill"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-fill"><a class="wp-block-button__link wp-element-button" href="mailto:info@pcl.co.ls">Start Your Application</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<!-- wp:paragraph {"className":"pcl-sub","fontSize":"small"} -->
<p class="pcl-sub has-small-font-size" style="font-size:0.85rem;opacity:0.8">Bring your ID, latest payslip or business records, and recent bank statements to speed up your assessment.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 87 --post_content="$(cat "$TMPDIR/contact.html")" 2>/dev/null
echo "  Contact updated."

# ---------- PRIVACY POLICY (ID 88) ----------
echo ">> Privacy Policy (88)"
cat > "$TMPDIR/privacy.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-band-navy pcl-section","layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Privacy</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Privacy Policy</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Your privacy matters to us. This policy explains how Platinum Credit Ltd collects, uses, and protects your personal information.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"760px"},"style":{"spacing":{"padding":{"top":"clamp(3rem, 7vw, 5rem)","bottom":"clamp(3rem, 7vw, 5rem)","blockGap":"clamp(1.5rem, 3vw, 2rem)"}}}} -->
<div class="wp-block-group" style="padding-top:clamp(3rem, 7vw, 5rem);padding-bottom:clamp(3rem, 7vw, 5rem)">
<!-- wp:paragraph -->
<p><em>Last updated: August 2026. This is placeholder legal copy to be reviewed by counsel before launch.</em></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">What we collect</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>When you contact us or apply for a loan, we collect the information you provide — including name, contact details, identification documents, payslips, bank statements, and business records — in order to process your application and conduct affordability assessments.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">How we use it</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We use your details solely to process loan applications, conduct affordability assessments, manage your account, and comply with regulatory requirements imposed by the Central Bank of Lesotho. We do not sell, rent, or share personal data with third parties for marketing purposes.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">How long we keep it</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Client records are retained for the duration of the lending relationship and for the period required by applicable regulations. You may request deletion of your data by contacting us at <a href="mailto:info@pcl.co.ls">info@pcl.co.ls</a>.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Your rights</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Depending on applicable law, you may have rights to access, correct, or delete your personal data. Contact us at any time to exercise these rights. We respond to all data requests within the timeframes required by law.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Contact us</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>For privacy-related enquiries, email <a href="mailto:info@pcl.co.ls">info@pcl.co.ls</a> or visit our offices at Thulo Building, Maseru 100, Lesotho.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 88 --post_content="$(cat "$TMPDIR/privacy.html")" 2>/dev/null
echo "  Privacy Policy updated."

# ---------- LEGAL DISCLOSURES (ID 89) ----------
echo ">> Legal Disclosures (89)"
cat > "$TMPDIR/legal.html" << 'BLOCKS'
<!-- wp:group {"className":"pcl-band-navy pcl-section","layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group pcl-band-navy pcl-section">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Legal</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Legal Disclosures</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub"} -->
<p class="pcl-sub">Important regulatory and legal information about Platinum Credit Ltd and our lending practices.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"760px"},"style":{"spacing":{"padding":{"top":"clamp(3rem, 7vw, 5rem)","bottom":"clamp(3rem, 7vw, 5rem)","blockGap":"clamp(1.5rem, 3vw, 2rem)"}}}} -->
<div class="wp-block-group" style="padding-top:clamp(3rem, 7vw, 5rem);padding-bottom:clamp(3rem, 7vw, 5rem)">
<!-- wp:paragraph -->
<p><em>Last updated: August 2026. This is placeholder legal copy to be reviewed by counsel before launch.</em></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Regulatory status</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Platinum Credit Ltd is a 100% Basotho-owned microfinance institution and registered credit provider, licensed and supervised by the Central Bank of Lesotho (CBL) as a Tier 2 institution. Every application undergoes an affordability assessment — we will not extend credit an assessment indicates you cannot reasonably repay.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Cost of credit</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>A full pre-agreement statement of cost is provided before any funds are advanced. Interest rates and fees shown on this site are indicative; your binding cost of credit is set out in your personalised quotation. The indicative rate is 10% per annum on a reducing balance basis.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Consumer protection</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>In line with the Financial Consumer Protection Act No. 7 of 2022, a statutory cooling-off period and early-settlement options apply to all loans. You have the right to settle your loan early, and any early-settlement charges will be disclosed in your loan agreement.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Complaints and dispute resolution</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>If you have a complaint about our services, please contact us at <a href="mailto:info@pcl.co.ls">info@pcl.co.ls</a> or visit our offices. If your complaint is not resolved to your satisfaction, you may escalate it to the Central Bank of Lesotho.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Responsible lending</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We are committed to responsible lending practices. We assess every application against your verified income and existing commitments to ensure the loan is affordable. Borrow responsibly.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#6A5F78"}}} -->
<p class="has-small-font-size" style="color:#6A5F78">CBL Registration No.: [insert once verified against the CBL listing]</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
BLOCKS

$WPCLI post update 89 --post_content="$(cat "$TMPDIR/legal.html")" 2>/dev/null
echo "  Legal Disclosures updated."

echo ""
echo "=== All 9 pages populated ==="
