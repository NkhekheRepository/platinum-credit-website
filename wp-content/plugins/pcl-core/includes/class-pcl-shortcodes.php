<?php
/**
 * PCL Shortcodes — renders contact form and CAB call blocks.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PCL_Shortcodes {

	/**
	 * Render the contact form shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML output.
	 */
	public static function render_contact_form( $atts ) {
		$atts = shortcode_atts( array(
			'title'       => __( 'Request a Quick Quote', 'pcl-core' ),
			'subtitle'    => '',
			'show_amount' => 'true',
			'form_id'     => 'pcl-contact-' . uniqid(),
		), $atts, 'pcl_contact_form' );

		ob_start();
		?>
		<div class="pcl-form-wrapper pcl-reveal" id="<?php echo esc_attr( $atts['form_id'] ); ?>">
			<?php if ( ! empty( $atts['title'] ) ) : ?>
				<h3 class="pcl-form-title"><?php echo esc_html( $atts['title'] ); ?></h3>
			<?php endif; ?>
			<?php if ( ! empty( $atts['subtitle'] ) ) : ?>
				<p class="pcl-form-subtitle"><?php echo esc_html( $atts['subtitle'] ); ?></p>
			<?php endif; ?>

			<form class="pcl-form" method="post" action="" data-pcl-form>
				<input type="hidden" name="action" value="pcl_submit_form">
				<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'pcl_core_nonce' ) ); ?>">
				<input type="hidden" name="form_id" value="<?php echo esc_attr( $atts['form_id'] ); ?>">

				<div class="pcl-field">
					<label for="<?php echo esc_attr( $atts['form_id'] ); ?>-name">
						<?php esc_html_e( 'Full Name', 'pcl-core' ); ?> <span class="pcl-required">*</span>
					</label>
					<input type="text" id="<?php echo esc_attr( $atts['form_id'] ); ?>-name" name="name" required>
				</div>

				<div class="pcl-field">
					<label for="<?php echo esc_attr( $atts['form_id'] ); ?>-email">
						<?php esc_html_e( 'Email Address', 'pcl-core' ); ?> <span class="pcl-required">*</span>
					</label>
					<input type="email" id="<?php echo esc_attr( $atts['form_id'] ); ?>-email" name="email" required>
				</div>

				<div class="pcl-field">
					<label for="<?php echo esc_attr( $atts['form_id'] ); ?>-phone">
						<?php esc_html_e( 'Phone Number', 'pcl-core' ); ?> <span class="pcl-required">*</span>
					</label>
					<input type="tel" id="<?php echo esc_attr( $atts['form_id'] ); ?>-phone" name="phone" required>
				</div>

				<?php if ( $atts['show_amount'] === 'true' ) : ?>
					<div class="pcl-field">
						<label for="<?php echo esc_attr( $atts['form_id'] ); ?>-amount">
							<?php esc_html_e( 'Loan Amount (M)', 'pcl-core' ); ?>
						</label>
						<input type="number" id="<?php echo esc_attr( $atts['form_id'] ); ?>-amount" name="amount" min="500" max="50000" step="500" value="10000">
					</div>

					<div class="pcl-field">
						<label for="<?php echo esc_attr( $atts['form_id'] ); ?>-term">
							<?php esc_html_e( 'Preferred Term', 'pcl-core' ); ?>
						</label>
						<select id="<?php echo esc_attr( $atts['form_id'] ); ?>-term" name="term">
							<option value="3">3 months</option>
							<option value="6">6 months</option>
							<option value="12" selected>12 months</option>
							<option value="24">24 months</option>
							<option value="60">60 months</option>
							<option value="120">120 months</option>
						</select>
					</div>
				<?php endif; ?>

				<div class="pcl-field">
					<label for="<?php echo esc_attr( $atts['form_id'] ); ?>-message">
						<?php esc_html_e( 'Your Message', 'pcl-core' ); ?>
					</label>
					<textarea id="<?php echo esc_attr( $atts['form_id'] ); ?>-message" name="message" rows="4"></textarea>
				</div>

				<div class="pcl-form-status" aria-live="polite"></div>

				<button type="submit" class="pcl-btn pcl-btn-brand">
					<?php esc_html_e( 'Submit', 'pcl-core' ); ?>
				</button>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render the CAB call shortcode (Contact us / Apply Now CTA).
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML output.
	 */
	public static function render_cab_call( $atts ) {
		$atts = shortcode_atts( array(
			'phone'   => '26669457676',
			'text'    => __( 'Call Now: +266 694 57676', 'pcl-core' ),
			'style'   => 'brand',
		), $atts, 'pcl_cab_call' );

		$class = 'pcl-btn pcl-btn-' . sanitize_html_class( $atts['style'] );
		$href  = 'tel:' . preg_replace( '/[^0-9]/', '', $atts['phone'] );

		$html  = '<a href="' . esc_url( $href ) . '" class="' . esc_attr( $class ) . '">';
		$html .= esc_html( $atts['text'] );
		$html .= '</a>';

		return $html;
	}
}

add_shortcode( 'pcl_contact_form', array( 'PCL_Shortcodes', 'render_contact_form' ) );
add_shortcode( 'pcl_cab_call', array( 'PCL_Shortcodes', 'render_cab_call' ) );
