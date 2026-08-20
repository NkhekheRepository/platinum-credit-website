<?php
/**
 * PCL Form Handler — AJAX submission and validation for PCL contact forms.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PCL_Form_Handler {

	/**
	 * Submit the contact form via AJAX.
	 */
	public static function submit_form() {
		check_ajax_referer( 'pcl_core_nonce', 'nonce' );

		$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$amount  = isset( $_POST['amount'] ) ? floatval( wp_unslash( $_POST['amount'] ) ) : 0;
		$term    = isset( $_POST['term'] ) ? intval( wp_unslash( $_POST['term'] ) ) : 0;
		$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
		$form_id = isset( $_POST['form_id'] ) ? sanitize_text_field( wp_unslash( $_POST['form_id'] ) ) : '';

		$errors = array();

		if ( empty( $name ) ) {
			$errors[] = __( 'Please enter your name.', 'pcl-core' );
		}
		if ( empty( $email ) || ! is_email( $email ) ) {
			$errors[] = __( 'Please enter a valid email address.', 'pcl-core' );
		}
		if ( empty( $phone ) ) {
			$errors[] = __( 'Please enter your phone number.', 'pcl-core' );
		}

		if ( ! empty( $errors ) ) {
			wp_send_json_error( array(
				'messages' => $errors,
			) );
		}

		$admin_email = get_option( 'admin_email' );
		$subject     = sprintf(
			__( 'PCL Contact Form Submission — %s', 'pcl-core' ),
			is_admin() ? 'admin' : 'front'
		);

		$body = sprintf(
			__( "Name: %s\nEmail: %s\nPhone: %s\nAmount: %s\nTerm: %s\nMessage: %s\nForm ID: %s", 'pcl-core' ),
			$name,
			$email,
			$phone,
			$amount,
			$term,
			$message,
			$form_id
		);

		$headers = array(
			'From: ' . $name . ' <' . $email . '>',
			'Reply-To: ' . $email,
		);

		$sent = wp_mail( $admin_email, $subject, $body, $headers );

		if ( $sent ) {
			wp_send_json_success( array(
				'messages' => array( __( 'Your message has been sent. We will contact you shortly.', 'pcl-core' ) ),
			) );
		} else {
			wp_send_json_error( array(
				'messages' => array( __( 'There was a problem sending your message. Please try again or call us directly.', 'pcl-core' ) ),
			) );
		}
	}
}
