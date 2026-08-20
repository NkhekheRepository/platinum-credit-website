<?php
/**
 * Plugin Name: PCL Core
 * Description: Core shortcodes and utilities for Platinum Credit Ltd — contact forms, CAB calculator, and form validation.
 * Version: 1.0.0
 * Author: Platinum Credit Ltd
 * Text Domain: pcl-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PCL_CORE_VERSION', '1.0.0' );
define( 'PCL_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'PCL_CORE_URI', plugin_dir_url( __FILE__ ) );

require_once PCL_CORE_DIR . 'includes/class-pcl-form-handler.php';
require_once PCL_CORE_DIR . 'includes/class-pcl-shortcodes.php';

function pcl_core_load_textdomain() {
	load_plugin_textdomain( 'pcl-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'pcl_core_load_textdomain' );

function pcl_core_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}

	wp_enqueue_style(
		'pcl-core-css',
		PCL_CORE_URI . 'assets/form.css',
		array(),
		PCL_CORE_VERSION
	);

	wp_enqueue_script(
		'pcl-core-js',
		PCL_CORE_URI . 'assets/form.js',
		array( 'jquery' ),
		PCL_CORE_VERSION,
		true
	);

	wp_localize_script( 'pcl-core-js', 'pclCoreAjax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'pcl_core_nonce' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'pcl_core_enqueue_assets' );

add_action( 'wp_ajax_nopriv_pcl_submit_form', array( 'PCL_Form_Handler', 'submit_form' ) );
add_action( 'wp_ajax_pcl_submit_form', array( 'PCL_Form_Handler', 'submit_form' ) );
