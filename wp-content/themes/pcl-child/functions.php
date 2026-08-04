<?php
/**
 * PCL Child — Platinum Credit Ltd theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PCL_CHILD_VERSION', '1.1.0' );
define( 'PCL_CHILD_DIR', get_stylesheet_directory() );
define( 'PCL_CHILD_URI', get_stylesheet_directory_uri() );

function pcl_enqueue_styles() {
	$parent_version = wp_get_theme( 'astra' )->get( 'Version' );

	wp_enqueue_style(
		'astra-theme-css',
		get_template_directory_uri() . '/style.css',
		array(),
		$parent_version
	);

	wp_enqueue_style(
		'pcl-child-style',
		PCL_CHILD_URI . '/style.css',
		array( 'astra-theme-css' ),
		PCL_CHILD_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'pcl_enqueue_styles' );

function pcl_enqueue_google_fonts() {
	wp_enqueue_style(
		'pcl-google-fonts',
		'https://fonts.googleapis.com/css2?family=Marcellus&family=Figtree:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'pcl_enqueue_google_fonts' );

function pcl_editor_assets() {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'pcl_editor_assets' );

// Add skip link for accessibility
function pcl_skip_link() {
	echo '<a class="skip-link" href="#content">' . esc_html__( 'Skip to content', 'pcl-child' ) . '</a>';
}
add_action( 'wp_body_open', 'pcl_skip_link' );

// Disable Astra page title on pages (our hero patterns contain their own H1)
function pcl_disable_page_title( $output ) {
	if ( is_singular( 'page' ) && ! is_front_page() ) {
		return '';
	}
	if ( is_front_page() ) {
		return '';
	}
	return $output;
}
add_filter( 'astra_page_title', 'pcl_disable_page_title' );

// Add #content id to main for skip link target
function pcl_add_content_id( $content ) {
	if ( is_singular( 'page' ) && ! is_front_page() ) {
		return '<div id="content">' . $content . '</div>';
	}
	return $content;
}

// Register block pattern category
function pcl_block_patterns_category() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'pcl',
			array( 'label' => __( 'Platinum Credit Sections', 'pcl-child' ) )
		);
	}
}
add_action( 'init', 'pcl_block_patterns_category' );

// Register block patterns from sections/ directory
function pcl_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	$pattern_files = glob( PCL_CHILD_DIR . '/sections/*.php' );

	foreach ( (array) $pattern_files as $file ) {
		$source = file_get_contents( $file );
		$slug   = basename( $file, '.php' );

		$meta = array();
		if ( preg_match_all( '/^\/\* (Title|Description|Categories|Keywords): (.+?) \*\/$/mi', $source, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$meta[ strtolower( $match[1] ) ] = $match[2];
			}
		}

		$content = trim( preg_replace( '/<\?php.*?\?>/s', '', $source ) );

		register_block_pattern(
			'pcl/' . $slug,
			array(
				'title'         => isset( $meta['title'] ) ? $meta['title'] : $slug,
				'description'   => isset( $meta['description'] ) ? $meta['description'] : '',
				'categories'    => array( 'pcl' ),
				'keywords'      => isset( $meta['keywords'] ) ? array_map( 'trim', explode( ',', $meta['keywords'] ) ) : array(),
				'content'       => $content,
				'viewportWidth' => 1200,
			)
		);
	}
}
add_action( 'init', 'pcl_register_patterns' );

// Enqueue the motion/reveal JS (deferred, only on front-end)
function pcl_enqueue_motion_js() {
	if ( is_admin() ) {
		return;
	}
	wp_enqueue_script(
		'pcl-motion',
		PCL_CHILD_URI . '/js/motion.js',
		array(),
		PCL_CHILD_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'pcl_enqueue_motion_js' );

// WhatsApp float button via wp_footer
function pcl_whatsapp_float() {
	if ( is_admin() ) {
		return;
	}
	$whatsapp_number = '26669457676';
	?>
	<a class="pcl-whatsapp-float"
	   href="https://wa.me/<?php echo esc_attr( $whatsapp_number ); ?>"
	   target="_blank"
	   rel="noopener"
	   aria-label="Chat with us on WhatsApp: +266 6945 7676"
	   title="WhatsApp us: +266 6945 7676">
		<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.9-4.45 9.9-9.91a9.85 9.85 0 0 0-2.9-7.01A9.83 9.83 0 0 0 12.04 2zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24a8.2 8.2 0 0 1 5.83 2.42 8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23zm4.52-6.16c-.25-.13-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.78.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.23-.73-.66-1.23-1.47-1.38-1.72-.14-.24-.01-.38.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.13-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.42h-.48c-.17 0-.43.06-.66.31-.22.24-.86.85-.86 2.07 0 1.22.89 2.39 1.01 2.56.13.16 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.06-.1-.23-.16-.48-.29z"/></svg>
	</a>
	<?php
}
add_action( 'wp_footer', 'pcl_whatsapp_float' );
