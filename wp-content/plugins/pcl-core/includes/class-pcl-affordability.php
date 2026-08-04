<?php
/**
 * PCL Affordability Self-Assessment — browser-only, never uploaded.
 * [pcl_affordability]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PCL_Affordability {

	public function __construct() {
		add_shortcode( 'pcl_affordability', array( $this, 'render' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function enqueue_assets() {
		if ( is_admin() ) {
			return;
		}
		global $post;
		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'pcl_affordability' ) ) {
			wp_enqueue_style(
				'pcl-afford-css',
				PCL_PLUGIN_URI . '/assets/affordability.css',
				array(),
				PCL_PLUGIN_VERSION
			);
			wp_enqueue_script(
				'pcl-afford-js',
				PCL_PLUGIN_URI . '/assets/affordability.js',
				array(),
				PCL_PLUGIN_VERSION,
				true
			);
		}
	}

	public function render( $atts ) {
		$atts = shortcode_atts( array(
			'benchmark' => '0.30',
			'rate'      => '0.10',
		), $atts, 'pcl_affordability' );

		ob_start();
		?>
		<div class="pcl-afford pcl-reveal" id="pcl-afford-wrap" role="region" aria-label="Affordability Self-Assessment">
			<p class="pcl-eyebrow">Affordability Self-Assessment</p>
			<h2 class="wp-block-heading">Check what your paycheck can carry — before you apply.</h2>
			<p class="pcl-sub">This is a guide only. Our team will run a full affordability assessment. We will never extend credit that an assessment indicates you cannot reasonably repay.</p>

			<div class="pcl-afford-grid">
				<div class="pcl-afford-form">
					<!-- Auto-fill from bank statement (browser-only, never uploaded) -->
					<div class="pcl-afford-field">
						<label>Auto-fill from a bank statement (optional)</label>
						<div class="pcl-dropzone" id="pcl-dropzone" role="button" tabindex="0" aria-label="Upload a CSV or TXT bank statement export to auto-fill your figures">
							<span id="pcl-fname">Drop a .csv or .txt here, or click to browse</span>
							<input type="file" id="pcl-statement-input" accept=".csv,.txt" style="display:none">
						</div>
					</div>

					<div class="pcl-afford-field">
						<label for="pcl-af-basic">Basic salary (gross, monthly) <span class="pcl-required">*</span></label>
						<div class="pcl-af-input"><span>M</span><input type="number" id="pcl-af-basic" min="0" step="0.01" placeholder="0.00" inputmode="decimal" required></div>
					</div>

					<div class="pcl-afford-field">
						<label for="pcl-af-nett">Nett as per payslip <span class="pcl-required">*</span></label>
						<div class="pcl-af-input"><span>M</span><input type="number" id="pcl-af-nett" min="0" step="0.01" placeholder="0.00" inputmode="decimal" required></div>
					</div>

					<div class="pcl-afford-field">
						<label for="pcl-af-debits">Monthly loan repayments &amp; bank debit orders</label>
						<div class="pcl-af-input"><span>M</span><input type="number" id="pcl-af-debits" min="0" step="0.01" placeholder="0.00" inputmode="decimal"></div>
					</div>

					<div class="pcl-afford-field">
						<label for="pcl-af-living">Total monthly living expenses</label>
						<div class="pcl-af-input"><span>M</span><input type="number" id="pcl-af-living" min="0" step="0.01" placeholder="0.00" inputmode="decimal"></div>
					</div>

					<div class="pcl-afford-field">
						<label for="pcl-af-term">Preferred repayment term</label>
						<select id="pcl-af-term">
							<option value="3">3 months</option>
							<option value="6">6 months</option>
							<option value="12" selected>12 months</option>
							<option value="24">24 months</option>
							<option value="36">36 months</option>
						</select>
					</div>
				</div>

				<div class="pcl-afford-output" aria-live="polite">
					<div class="pcl-afford-badge" id="pcl-af-badge" data-state="idle">Enter your figures</div>

					<div class="pcl-afford-results">
						<div class="pcl-afford-row">
							<span>Estimated loan instalment</span>
							<strong id="pcl-af-req" class="pcl-tabular">M0.00</strong>
						</div>
						<div class="pcl-afford-row">
							<span>Max affordable instalment</span>
							<strong id="pcl-af-max" class="pcl-tabular">M0.00</strong>
						</div>
					 <div class="pcl-afford-row">
							<span>Max loan amount you could afford</span>
							<strong id="pcl-af-loan" class="pcl-tabular">M0.00</strong>
						</div>
						<div class="pcl-afford-row">
							<span>Instalment as % of basic salary</span>
							<strong id="pcl-af-pct" class="pcl-tabular">0.0%</strong>
						</div>
						<div class="pcl-afford-row">
							<span>Nett after max instalment</span>
							<strong id="pcl-af-new" class="pcl-tabular">M0.00</strong>
						</div>
					</div>
				</div>
			</div>

			<p class="pcl-afford-note">This self-assessment uses a 30% of gross salary benchmark and indicative 10% p.a. rate. Your actual affordability will be assessed by our team in line with CBL regulations and the Financial Consumer Protection Act No. 7 of 2022.</p>
		</div>
		<?php
		return ob_get_clean();
	}
}

new PCL_Affordability();
