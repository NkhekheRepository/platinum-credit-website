<?php
/**
 * Plugin Name: PCL Core
 * Description: PCL Platinum Credit Ltd — contact form, loan estimator, affordability self-assessment.
 * Version:     1.1.0
 * Author:      PCL
 * Text Domain: pcl-core
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PCL_PLUGIN_VERSION', '1.1.0' );
define( 'PCL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PCL_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

// Backward compatibility aliases for classes that reference old constant names
if ( ! defined( 'PCL_CORE_VERSION' ) ) {
	define( 'PCL_CORE_VERSION', PCL_PLUGIN_VERSION );
}
if ( ! defined( 'PCL_CORE_DIR' ) ) {
	define( 'PCL_CORE_DIR', PCL_PLUGIN_DIR );
}
if ( ! defined( 'PCL_CORE_URI' ) ) {
	define( 'PCL_CORE_URI', PCL_PLUGIN_URI );
}

require_once PCL_PLUGIN_DIR . 'includes/class-pcl-contact-form.php';
require_once PCL_PLUGIN_DIR . 'includes/class-pcl-loan-estimator.php';
require_once PCL_PLUGIN_DIR . 'includes/class-pcl-affordability.php';

function pcl_core_contact_form() {
	return PCL_Contact_Form::get_instance();
}
add_action( 'plugins_loaded', 'pcl_core_contact_form' );

function pcl_core_textdomain() {
	load_plugin_textdomain( 'pcl-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'pcl_core_textdomain' );
