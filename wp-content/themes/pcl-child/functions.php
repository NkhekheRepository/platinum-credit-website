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

// Add scroll progress bar + preloader
function pcl_progress_and_preloader() {
	if ( is_admin() ) {
		return;
	}
	echo '<div id="pcl-progress" role="presentation"></div>';
	echo '<div id="pcl-loader" aria-hidden="true">';
	echo '<svg class="pcl-loader-gem" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="349 163 518 541"><defs><style>.cls-1{fill:currentColor;}</style></defs><path class="cls-1" d="M851.91,330.28l-54.38-103.1L757.28,172.8l-146.89-4.24-221,135.59L354,442.57l47.32,76.27,3.53,77.68L479,699.62H675.36l24-132.76,112.29-60,37.42-27.54,12.72-68.5Zm-18.83,5-190.67,40.6L783.64,243.42ZM620.28,187.4l128.53,4.7,25.89,37.67L620.63,375.83l-24.36-27.89ZM755.51,476.93,631.58,424.21l-5.3-35.67Zm-178.07,109-37.2-8.65,41-94.22,12.24,27.78Zm22-60,6.35,17-18.36,39.9Zm-87,45.66-82.39-13.65L413.6,507.54l3.77-66.39,71.56-58.85-19.78,81.92ZM506,378.07l27.52-29.49,48.66,2.89L605.8,382.3l-55,64.5-61.68,6.59Zm-16.86-43.9,33.72,10.47L500.23,363Zm63.56,124.64,24.78,15.36L528.83,574.8,489.1,465.69ZM522.29,583.1l53,21.54L565,628.47,444.61,567.39Zm63.38-114.17-24.24-19.77,52.26-57L616,422.53Zm0-128.53-51.55-3.29-40.49-14.6L607.92,195.87Zm0-136.53L482.22,313.33l-31.78-29.66ZM440.91,290.38l22.12,21,3.65,6.89-56.14-13.77ZM402.77,494.59l-28.72-45.43,31.9-6.59Zm3.18-60.5-33.9,5.3,25.78-105.22L406,408.32Zm63.91-105.57L485,367l-68.5,60-.35-32.13L406,313.33ZM413.6,539l11.06,28.43-9.53,18.53ZM485,687.85l-64.85-91.8,12.71-24.49L646.76,684.08Zm92.4-53.2,32.25-80,48.25,125.93ZM668.65,665,597.33,489.53l88.27,72.74Zm21.78-112.76L601,476.93l26.36-40L776.58,503.3ZM833.9,467.64l-36.37,23.65L646.76,388.54l191.38-37.07L847,411.85Z"/></svg>';
	echo '<div class="pcl-loader-word">Platinum Credit</div>';
	echo '</div>';
}
add_action( 'wp_body_open', 'pcl_progress_and_preloader', 5 );

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

// ========== SEO: Open Graph + canonical + JSON-LD ==========

function pcl_seo_meta() {
	if ( is_admin() ) {
		return;
	}

	$site_name = 'Platinum Credit Ltd';
	$site_url  = home_url();
	$desc_default = 'Platinum Credit Ltd is a 100% Basotho-owned, Tier 2 CBL-licensed microfinance institution in Maseru, offering competitive interest rates for individuals and MSMEs across Lesotho.';

	if ( is_front_page() ) {
		$title = 'Platinum Credit Ltd — Re Lora Le Uena | Maseru, Lesotho';
		$desc  = $desc_default;
		$url   = $site_url;
	} elseif ( is_singular( 'page' ) ) {
		$title = get_the_title() . ' — ' . $site_name;
		$desc  = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ?: get_the_content() ), 30, '…' );
		$url   = get_permalink();
	} else {
		return;
	}

	$og_image = $site_url . '/wp-content/themes/pcl-child/assets/og-image.png';

	// Canonical
	echo '<link rel="canonical" href="' . esc_url( $url ) . "\" />\n";

	// Meta description
	echo '<meta name="description" content="' . esc_attr( $desc ) . "\" />\n";

	// Open Graph
	echo '<meta property="og:type" content="website" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $og_image ) . '" />' . "\n";
	echo '<meta property="og:locale" content="en_LS" />' . "\n";

	// Twitter Card
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '" />' . "\n";

	// JSON-LD FinancialService
	$jsonld = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'FinancialService',
		'name'        => 'Platinum Credit Ltd',
		'description' => $desc_default,
		'url'         => $site_url,
		'telephone'   => array( '+26622324412', '+26652011000' ),
		'email'       => 'info@pcl.co.ls',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Thulo Building',
			'addressLocality' => 'Maseru',
			'postalCode'      => '100',
			'addressCountry'  => 'LS',
		),
		'areaServed'  => array(
			'@type' => 'Country',
			'name'  => 'Lesotho',
		),
		'founder'     => array(
			'@type' => 'Organization',
			'name'  => 'Platinum Credit Ltd',
		),
		'sameAs'      => array(
			'https://www.facebook.com/profile.php?id=61576228466083',
			'https://wa.me/26669457676',
			'https://www.pcl.co.ls',
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'pcl_seo_meta', 1 );
