<?php
/**
 * Title: Loan Estimator
 * Description: Two-column loan estimator with glass panel, range sliders, and amortisation output.
 * Categories: pcl
 * Keywords: estimator, calculator, loan, slider, repayment
 */
?>
<!-- wp:group {"className":"pcl-band-navy pcl-section","id":"estimator","layout":{"type":"default"}} -->
<div class="wp-block-group pcl-band-navy pcl-section" id="estimator">

<!-- wp:html -->
<div class="pcl-calc">
  <div class="pcl-reveal">
    <p class="pcl-eyebrow">Loan Estimator</p>
    <h2>See your instalment before you apply.</h2>
    <p class="pcl-sub lede">Move the sliders to estimate a monthly repayment at our 10% per annum rate. Our team confirms your personalised offer after a full affordability assessment.</p>
    <a href="#contact" class="pcl-btn pcl-btn-brand" style="margin-top:34px;display:inline-flex">Request a Formal Quote</a>
  </div>
  <div class="pcl-calc-panel pcl-reveal">
    <div class="pcl-calc-row">
      <label for="pcl-amt">Loan amount <output id="pcl-amtOut">M10,000.00</output></label>
      <div class="pcl-stepper">
        <button class="pcl-step-btn" id="pcl-amtMinus" type="button" aria-label="Decrease amount">&minus;</button>
        <input type="range" id="pcl-amt" min="500" max="50000" step="500" value="10000" aria-label="Loan amount in Maloti">
        <button class="pcl-step-btn" id="pcl-amtPlus" type="button" aria-label="Increase amount">+</button>
      </div>
    </div>
    <div class="pcl-calc-row">
      <label for="pcl-term">Repayment term <output id="pcl-termOut">12 months</output></label>
      <div class="pcl-stepper">
        <button class="pcl-step-btn" id="pcl-termMinus" type="button" aria-label="Decrease term">&minus;</button>
        <input type="range" id="pcl-term" min="3" max="120" step="3" value="12" aria-label="Repayment term in months">
        <button class="pcl-step-btn" id="pcl-termPlus" type="button" aria-label="Increase term">+</button>
      </div>
    </div>
    <div class="pcl-calc-result">
      <div>
        <div class="pcl-calc-lbl">Estimated monthly repayment</div>
        <div class="pcl-monthly pcl-brand-grad" id="pcl-monthly">M879.16</div>
      </div>
      <div style="text-align:right">
        <div class="pcl-calc-lbl">Total repayable</div>
        <div class="pcl-display" style="font-size:1.3rem" id="pcl-total">M10,549.91</div>
      </div>
    </div>
    <div class="pcl-sum-rows">
      <div class="pcl-sum-row"><span>Principal</span><b id="pcl-sumPrincipal">M10,000.00</b></div>
      <div class="pcl-sum-row"><span>Indicative rate (reducing balance)</span><b>10.0% p.a.</b></div>
      <div class="pcl-sum-row pcl-emph"><span>Cost of credit</span><b id="pcl-sumCost">M549.91</b></div>
    </div>
    <div class="pcl-repay">
      <div class="pcl-repay-lbls"><span>Principal</span><span>Interest</span></div>
      <div class="pcl-repay-bar" id="pcl-repay-bar" role="img" aria-label="Share of total repayment between principal and interest">
        <span class="pcl-rb-princ" aria-valuemin="0" aria-valuemax="100" aria-valuenow="94.8"></span>
        <span class="pcl-rb-int" aria-valuemin="0" aria-valuemax="100" aria-valuenow="5.2"></span>
      </div>
    </div>
    <p class="pcl-calc-note">Figures are indicative, calculated on a reducing-balance basis, and exclude initiation and monthly service fees, which will be disclosed in your pre-agreement quotation. Final terms depend on your affordability assessment.</p>
  </div>
</div>
<!-- /wp:html -->

</div>
<!-- /wp:group -->
