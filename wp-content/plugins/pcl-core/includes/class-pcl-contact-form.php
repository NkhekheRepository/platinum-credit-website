<?php
/**
 * PCL contact form — shortcode rendering + REST API submission.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PCL_Contact_Form {

	const REST_ROUTE  = 'pcl/v1/contact';
	const NONCE_ACTION = 'pcl_contact_form';
	const RATE_LIMIT   = 3;
	const RATE_WINDOW  = 900;

	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_shortcode( 'pcl_contact_form', array( $this, 'render_shortcode' ) );
		add_action( 'rest_api_init', array( $this, 'register_rest_route' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function enqueue_assets() {
		if ( ! is_singular() || false === strpos( get_post_field( 'post_content', get_queried_object_id() ), '[pcl_contact_form]' ) ) {
			return;
		}

		wp_enqueue_style( 'pcl-form', PCL_CORE_URI . 'assets/form.css', array(), PCL_CORE_VERSION );
		wp_enqueue_script( 'pcl-form', PCL_CORE_URI . 'assets/form.js', array(), PCL_CORE_VERSION, true );

		wp_localize_script(
			'pcl-form',
			'pclForm',
			array(
				'restUrl' => esc_url_raw( rest_url( self::REST_ROUTE ) ),
				'nonce'   => wp_create_nonce( self::NONCE_ACTION ),
			)
		);
	}

	public function render_shortcode() {
		ob_start();
		?>
		<form class="pcl-form" method="post" action="<?php echo esc_url( rest_url( self::REST_ROUTE ) ); ?>" novalidate>
			<div class="pcl-form-status" role="status" aria-live="polite"></div>

			<div class="pcl-field">
				<label for="pcl-name"><?php esc_html_e( 'Full name', 'pcl-core' ); ?> <span class="pcl-required" aria-hidden="true">*</span></label>
				<input type="text" id="pcl-name" name="name" autocomplete="name" required maxlength="120" />
			</div>

			<div class="pcl-field">
				<label for="pcl-email"><?php esc_html_e( 'Email address', 'pcl-core' ); ?> <span class="pcl-required" aria-hidden="true">*</span></label>
				<input type="email" id="pcl-email" name="email" autocomplete="email" required maxlength="254" />
			</div>

			<div class="pcl-field">
				<label for="pcl-phone"><?php esc_html_e( 'Phone (optional)', 'pcl-core' ); ?></label>
				<input type="tel" id="pcl-phone" name="phone" autocomplete="tel" maxlength="40" />
			</div>

			<div class="pcl-field">
				<label for="pcl-service"><?php esc_html_e( 'Service of interest', 'pcl-core' ); ?></label>
				<select id="pcl-service" name="service">
					<option value=""><?php esc_html_e( 'General enquiry', 'pcl-core' ); ?></option>
					<option value="business-consulting"><?php esc_html_e( 'Business Consulting', 'pcl-core' ); ?></option>
					<option value="digital-implementation"><?php esc_html_e( 'Digital Implementation', 'pcl-core' ); ?></option>
					<option value="managed-support"><?php esc_html_e( 'Managed Support', 'pcl-core' ); ?></option>
					<option value="training-enablement"><?php esc_html_e( 'Training &amp; Enablement', 'pcl-core' ); ?></option>
				</select>
			</div>

			<div class="pcl-field">
				<label for="pcl-message"><?php esc_html_e( 'Message', 'pcl-core' ); ?> <span class="pcl-required" aria-hidden="true">*</span></label>
				<textarea id="pcl-message" name="message" rows="6" required maxlength="3000"></textarea>
			</div>

			<div class="pcl-field pcl-honeypot" aria-hidden="true">
				<label for="pcl-company"><?php esc_html_e( 'Company', 'pcl-core' ); ?></label>
				<input type="text" id="pcl-company" name="company" tabindex="-1" autocomplete="off" />
			</div>

			<p>
				<button type="submit" class="wp-block-button__link wp-element-button has-pcl-white-color has-pcl-teal-background-color">
					<?php esc_html_e( 'Send message', 'pcl-core' ); ?>
				</button>
			</p>
		</form>
		<?php
		return ob_get_clean();
	}

	public function register_rest_route() {
		register_rest_route(
			'pcl/v1',
			'/contact',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'handle_submission' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	public function handle_submission( WP_REST_Request $request ) {
		$nonce = sanitize_text_field( $request->get_header( 'X-WP-Nonce' ) );

		if ( ! wp_verify_nonce( $nonce, self::NONCE_ACTION ) ) {
			return new WP_REST_Response(
				array( 'success' => false, 'message' => esc_html__( 'Your session expired. Please reload the page and try again.', 'pcl-core' ) ),
				403
			);
		}

		if ( $this->is_rate_limited() ) {
			return new WP_REST_Response(
				array( 'success' => false, 'message' => esc_html__( 'Too many attempts. Please wait a few minutes and try again.', 'pcl-core' ) ),
				429
			);
		}

		$honeypot = sanitize_text_field( $request->get_param( 'company' ) );
		if ( '' !== $honeypot ) {
			$this->record_attempt();
			return new WP_REST_Response( array( 'success' => true, 'message' => esc_html__( 'Thank you for your message.', 'pcl-core' ) ), 200 );
		}

		$errors = $this->validate( $request );
		if ( ! empty( $errors ) ) {
			return new WP_REST_Response(
				array( 'success' => false, 'message' => esc_html__( 'Please correct the highlighted fields and try again.', 'pcl-core' ), 'fields' => $errors ),
				400
			);
		}

		$this->record_attempt();
		$this->send_email( $request );

		return new WP_REST_Response(
			array( 'success' => true, 'message' => esc_html__( 'Thank you for your message. We will reply within one business day.', 'pcl-core' ) ),
			200
		);
	}

	private function validate( WP_REST_Request $request ) {
		$errors = array();
		$name   = sanitize_text_field( $request->get_param( 'name' ) );
		$email  = sanitize_email( $request->get_param( 'email' ) );
		$message = sanitize_textarea_field( $request->get_param( 'message' ) );

		if ( '' === $name || mb_strlen( $name ) < 2 || mb_strlen( $name ) > 120 ) {
			$errors['name'] = esc_html__( 'Please enter your name (2–120 characters).', 'pcl-core' );
		}

		if ( ! is_email( $email ) ) {
			$errors['email'] = esc_html__( 'Please enter a valid email address.', 'pcl-core' );
		}

		if ( '' === $message || mb_strlen( $message ) < 10 || mb_strlen( $message ) > 3000 ) {
			$errors['message'] = esc_html__( 'Please enter a message between 10 and 3000 characters.', 'pcl-core' );
		}

		$phone = sanitize_text_field( $request->get_param( 'phone' ) );
		if ( '' !== $phone && ! preg_match( '/^[0-9+\-().\s]{7,40}$/', $phone ) ) {
			$errors['phone'] = esc_html__( 'Please enter a valid phone number.', 'pcl-core' );
		}

		$allowed_services = array( '', 'business-consulting', 'digital-implementation', 'managed-support', 'training-enablement' );
		if ( ! in_array( sanitize_key( $request->get_param( 'service' ) ), $allowed_services, true ) ) {
			$errors['service'] = esc_html__( 'Please choose a valid option.', 'pcl-core' );
		}

		return $errors;
	}

	private function send_email( WP_REST_Request $request ) {
		$name     = sanitize_text_field( $request->get_param( 'name' ) );
		$email    = sanitize_email( $request->get_param( 'email' ) );
		$phone    = sanitize_text_field( $request->get_param( 'phone' ) );
		$service  = sanitize_key( $request->get_param( 'service' ) );
		$message  = sanitize_textarea_field( $request->get_param( 'message' ) );

		$service_labels = array(
			'business-consulting'    => __( 'Business Consulting', 'pcl-core' ),
			'digital-implementation' => __( 'Digital Implementation', 'pcl-core' ),
			'managed-support'        => __( 'Managed Support', 'pcl-core' ),
			'training-enablement'    => __( 'Training & Enablement', 'pcl-core' ),
		);

		$body  = sprintf( __( "Name: %s\nEmail: %s\n", 'pcl-core' ), $name, $email );
		$body .= '' !== $phone ? sprintf( __( "Phone: %s\n", 'pcl-core' ), $phone ) : '';
		$body .= '' !== $service ? sprintf( __( "Service: %s\n", 'pcl-core' ), $service_labels[ $service ] ) : '';
		$body .= sprintf( __( "\nMessage:\n%s\n", 'pcl-core' ), $message );

		$to      = get_option( 'pcl_contact_recipient', get_option( 'admin_email' ) );
		$subject = sprintf( __( '[PCL] New enquiry from %s', 'pcl-core' ), $name );
		$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

		wp_mail( $to, $subject, $body, $headers );
	}

	private function rate_limit_key() {
		return 'pcl_cf_' . wp_hash( self::REST_ROUTE . '|' . $this->client_ip() );
	}

	private function client_ip() {
		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		return $ip;
	}

	private function is_rate_limited() {
		$count = (int) get_transient( $this->rate_limit_key() );
		return $count >= self::RATE_LIMIT;
	}

	private function record_attempt() {
		$key   = $this->rate_limit_key();
		$count = (int) get_transient( $key );
		set_transient( $key, $count + 1, self::RATE_WINDOW );
	}
}
