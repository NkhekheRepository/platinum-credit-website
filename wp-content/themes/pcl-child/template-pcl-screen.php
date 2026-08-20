<?php
/**
 * Template Name: PCL Screen
 * Description: Loads a standalone PCL HTML screen from the pcl-screens directory.
 *              Extracts only the <body> content, suppresses all WordPress/Astra
 *              chrome, and renders the screen edge-to-edge at full viewport.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug          = get_post_field( 'post_name', get_post() );
$screens_url   = home_url( '/pcl-screens/' );
$site_url      = home_url( '/' );
$screens_path  = ABSPATH . 'pcl-screens/';

$screen_map = array(
	'home'          => 'home.html',
	'home-2'        => 'home.html',
	'estimator'     => 'estimator.html',
	'affordability' => 'affordability.html',
	'products'      => 'products.html',
	'contact'       => 'contact.html',
	'contact-2'     => 'contact.html',
);

$html_file = isset( $screen_map[ $slug ] ) ? $screen_map[ $slug ] : $slug . '.html';
$full_path = $screens_path . $html_file;

if ( ! file_exists( $full_path ) ) {
	?><!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Screen not found</title></head><body style="padding:2rem;text-align:center;font-family:sans-serif"><h1>Screen not found</h1><p><code><?php echo esc_html( $html_file ); ?></code> not found.</p></body></html><?php
	return;
}

$html = file_get_contents( $full_path );

/* Extract only the inner <body> content */
if ( preg_match( '/<body[^>]*>(.*)<\/body>/s', $html, $m ) ) {
	$body = $m[1];
} else {
	$body = $html;
}

/* Extract <head> content (title, meta, etc.) from the HTML file */
$head_content = '';
if ( preg_match( '/<head[^>]*>(.*)<\/head>/is', $html, $m ) ) {
	$head_content = $m[1];
}

/* Clean extracted head: remove duplicate meta charset, viewport, title (we add our own) */
$head_content = preg_replace( '/<meta\s+charset=["\'][^"\']+["\'][^>]*>/i', '', $head_content );
$head_content = preg_replace( '/<meta\s+name=["\']viewport["\'][^>]*>/i', '', $head_content );
$head_content = preg_replace( '/<title[^>]*>.*<\/title>/i', '', $head_content );
// Remove empty lines from cleanup
$head_content = preg_replace( '/^\s+$/m', '', $head_content );

/* Extract lang attribute from <html> tag */
$lang = 'en';
if ( preg_match( '/<html[^>]+lang="([^"]+)"/i', $html, $m ) ) {
	$lang = $m[1];
}

/* Inject base.css link into head (replace relative path) */
$base_css_url = esc_url( $screens_url . 'base.css' );
$head_content = str_replace( 'href="base.css"', 'href="' . $base_css_url . '"', $head_content );

/* Fix internal nav/footer links: relative .html → WordPress page URLs */
$link_map = array(
	'href="home.html"'      => 'href="' . $site_url . '"',
	'href="products.html"'  => 'href="' . $site_url . 'products/"',
	'href="estimator.html"' => 'href="' . $site_url . 'estimator/"',
	'href="affordability.html"' => 'href="' . $site_url . 'affordability/"',
	'href="contact.html"'   => 'href="' . $site_url . 'contact/"',
);
$body = str_replace( array_keys( $link_map ), array_values( $link_map ), $body );

/* Fix footer logo: add required CSS classes for proper rendering + brand name text */
$body = str_replace(
	'<div class="footer-logo">',
	'<a href="' . $site_url . '" aria-label="Platinum Credit Ltd" class="pcl-footer-logo">',
	$body
);
$body = str_replace(
	'<svg xmlns="http://www.w3.org/2000/svg" viewBox="66 257 1056 343" aria-hidden="true">',
	'<svg class="pcl-logo-lockup" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="66 257 1056 343">',
	$body
);
/* Close the footer-logo anchor and add brand name text */
$body = str_replace(
	'</svg>
      </div>
      <div class="footer-links">',
	'</svg>
      <span class="pcl-brand-name">Platinum Credit Ltd<small>Re Lora Le Uena</small></span>
      </a>
      <div class="footer-links">',
	$body
);
?>
<!DOCTYPE html>
<html lang="<?php echo esc_attr( $lang ); ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $head_content; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'pcl-screen-page' ); ?>>
	<?php wp_body_open(); ?>
	<?php echo $body; ?>
	<?php wp_footer(); ?>
</body>
</html>