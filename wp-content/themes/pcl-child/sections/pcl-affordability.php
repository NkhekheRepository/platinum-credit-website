<?php
/**
 * Title: Affordability
 * Description: Two-column affordability self-assessment with form, bank statement dropzone, and dark output panel.
 * Categories: pcl
 * Keywords: affordability, assessment, income, expenses, bank statement
 */
?>
<!-- wp:group {"className":"pcl-section","id":"affordability","layout":{"type":"default"}} -->
<div class="wp-block-group pcl-section" id="affordability">

<!-- wp:group {"className":"pcl-section-head pcl-reveal","layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group pcl-section-head pcl-reveal">
<!-- wp:paragraph {"className":"pcl-eyebrow"} -->
<p class="pcl-eyebrow">Affordability Self-Assessment</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Check what your paycheck can carry — before you apply.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"pcl-sub lede"} -->
<p class="pcl-sub lede">Responsible lending starts with you. Enter your figures below to see your maximum comfortable instalment and the loan amount it could support. Everything is calculated on your device — nothing is sent or stored.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="pcl-afford pcl-reveal">
  <form class="pcl-afford-form" onsubmit="return false">
    <div class="pcl-af-field">
      <label>Auto-fill from a bank statement (optional)</label>
      <div class="pcl-dropzone" id="pcl-dropzone" role="button" tabindex="0" aria-label="Upload a CSV or TXT bank statement export to auto-fill your figures">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6ABAC3" stroke-width="1.5"><path d="M12 16V4M12 4l-4 4M12 4l4 4"/><path d="M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3"/></svg>
        <p><b style="color:var(--pcl-purple)">Click to upload</b> or drag a .csv / .txt export here.<br>Read on your device only — never uploaded or stored.</p>
        <div class="pcl-fname" id="pcl-fname"></div>
      </div>
      <input type="file" id="pcl-statementInput" accept=".csv,.txt" style="display:none">
    </div>
    <div class="pcl-af-or">or enter manually</div>
    <div class="pcl-af-field">
      <label for="pcl-afBasic">Basic salary (gross, monthly)</label>
      <div class="pcl-af-input"><span>M</span><input type="number" id="pcl-afBasic" min="0" step="0.01" placeholder="0.00" inputmode="decimal"></div>
    </div>
    <div class="pcl-af-field">
      <label for="pcl-afNett">Nett as per payslip</label>
      <div class="pcl-af-input"><span>M</span><input type="number" id="pcl-afNett" min="0" step="0.01" placeholder="0.00" inputmode="decimal"></div>
    </div>
    <div class="pcl-af-field">
      <label for="pcl-afDebits">Monthly loan repayments &amp; bank debit orders</label>
      <div class="pcl-af-input"><span>M</span><input type="number" id="pcl-afDebits" min="0" step="0.01" placeholder="0.00" inputmode="decimal"></div>
    </div>
    <div class="pcl-af-field">
      <label for="pcl-afLiving">Total monthly living expenses</label>
      <div class="pcl-af-input"><span>M</span><input type="number" id="pcl-afLiving" min="0" step="0.01" placeholder="0.00" inputmode="decimal"></div>
    </div>
    <div class="pcl-af-field">
      <label for="pcl-afTerm">Preferred repayment term</label>
      <select id="pcl-afTerm">
        <option value="3">3 months</option><option value="6">6 months</option><option value="9">9 months</option>
        <option value="12" selected>12 months</option><option value="18">18 months</option><option value="24">24 months</option>
        <option value="36">36 months</option><option value="48">48 months</option><option value="60">60 months</option>
        <option value="72">72 months</option><option value="84">84 months</option><option value="96">96 months</option>
        <option value="108">108 months</option><option value="120">120 months</option>
      </select>
    </div>
  </form>
  <div class="pcl-afford-out" aria-live="polite">
    <div class="pcl-afford-badge" id="pcl-afBadge" data-state="idle">Enter your figures</div>
    <ul class="pcl-afford-results">
      <li><span>Maximum instalment available</span><strong id="pcl-afMax">M0.00</strong></li>
      <li><span>Estimated loan you could qualify for</span><strong id="pcl-afLoan">M0.00</strong></li>
      <li><span>New nett after PCL instalment</span><strong id="pcl-afNew">M0.00</strong></li>
      <li><span>Instalment as % of gross salary</span><strong id="pcl-afPct">0.0%</strong></li>
      <li><span>Your estimator instalment</span><strong id="pcl-afReq">M879.16</strong></li>
    </ul>
    <a href="#contact" class="pcl-btn pcl-btn-brand" style="margin-top:26px;width:100%;justify-content:center">Book Your Full Assessment</a>
    <p class="pcl-calc-note">Guide only, using a 30% of gross affordability benchmark and PCL's 10% p.a. rate. Your formal assessment at our offices verifies payslips, bank statements, and existing commitments, and always takes precedence.</p>
  </div>
</div>
<!-- /wp:html -->

</div>
<!-- /wp:group -->
