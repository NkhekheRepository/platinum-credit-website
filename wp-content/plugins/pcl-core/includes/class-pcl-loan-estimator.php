<?php
/**
 * PCL Loan Estimator — interactive loan calculator.
 * [pcl_estimator]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PCL_Loan_Estimator {

	public function __construct() {
		add_shortcode( 'pcl_estimator', array( $this, 'render' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function enqueue_assets() {
		if ( is_admin() ) {
			return;
		}
		global $post;
		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'pcl_estimator' ) ) {
			wp_enqueue_style(
				'pcl-estimator-css',
				PCL_PLUGIN_URI . '/assets/estimator.css',
				array(),
				PCL_PLUGIN_VERSION
			);
			wp_enqueue_script(
				'pcl-estimator-js',
				PCL_PLUGIN_URI . '/assets/estimator.js',
				array(),
				PCL_PLUGIN_VERSION,
				true
			);
		}
	}

	public function render( $atts ) {
		$atts = shortcode_atts( array(
			'rate'     => '10',
			'min_amt'  => '500',
			'max_amt'  => '50000',
			'step_amt' => '500',
			'min_term' => '3',
			'max_term' => '120',
			'step_term'=> '3',
			'default_amt'  => '10000',
			'default_term' => '12',
		), $atts, 'pcl_estimator' );

		ob_start();
		?>
		<div class="pcl-estimator pcl-reveal" id="pcl-estimator-wrap" role="region" aria-label="Loan Estimator">
			<p class="pcl-eyebrow">Loan Estimator</p>
			<h2 class="wp-block-heading">See your instalment before you apply.</h2>
			<p class="pcl-sub">Adjust the sliders to explore what works for you. Rates shown are indicative — your binding quote will reflect your personal assessment.</p>

			<div class="pcl-estimator-controls">
				<div class="pcl-estimator-field">
					<label for="pcl-amt">Loan amount <output id="pcl-amt-out">M<?php echo number_format( (float) $atts['default_amt'], 2 ); ?></output></label>
					<div class="pcl-estimator-slider">
						<button class="pcl-step-btn" id="pcl-amt-minus" type="button" aria-label="Decrease amount">&minus;</button>
						<input type="range" id="pcl-amt" min="<?php echo esc_attr( $atts['min_amt'] ); ?>" max="<?php echo esc_attr( $atts['max_amt'] ); ?>" step="<?php echo esc_attr( $atts['step_amt'] ); ?>" value="<?php echo esc_attr( $atts['default_amt'] ); ?>" aria-label="Loan amount in Maloti">
						<button class="pcl-step-btn" id="pcl-amt-plus" type="button" aria-label="Increase amount">+</button>
					</div>
				</div>

				<div class="pcl-estimator-field">
					<label for="pcl-term">Repayment term <output id="pcl-term-out"><?php echo esc_html( $atts['default_term'] ); ?> months</output></label>
					<div class="pcl-estimator-slider">
						<button class="pcl-step-btn" id="pcl-term-minus" type="button" aria-label="Decrease term">&minus;</button>
						<input type="range" id="pcl-term" min="<?php echo esc_attr( $atts['min_term'] ); ?>" max="<?php echo esc_attr( $atts['max_term'] ); ?>" step="<?php echo esc_attr( $atts['step_term'] ); ?>" value="<?php echo esc_attr( $atts['default_term'] ); ?>" aria-label="Repayment term in months">
						<button class="pcl-step-btn" id="pcl-term-plus" type="button" aria-label="Increase term">+</button>
					</div>
				</div>
			</div>

			<div class="pcl-estimator-output" aria-live="polite">
				<div class="pcl-monthly pcl-tabular" id="pcl-monthly">M0.00</div>
				<div class="pcl-total pcl-tabular" id="pcl-total">Total: M0.00 over 0 months</div>
				<div class="pcl-estimator-summary">
					<span>Principal: <strong id="pcl-sum-principal" class="pcl-tabular">M0.00</strong></span>
					<span>Total cost of credit: <strong id="pcl-sum-cost" class="pcl-tabular">M0.00</strong></span>
				</div>
			</div>

			<p class="pcl-estimator-note">This is an estimate only. Your actual loan terms will be confirmed after affordability assessment. A pre-agreement statement of cost will be provided before any funds are advanced.</p>
		</div>
		<?php
		return ob_get_clean();
	}
}

new PCL_Loan_Estimator();
