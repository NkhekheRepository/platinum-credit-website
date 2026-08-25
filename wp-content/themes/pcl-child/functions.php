<?php
/**
 * PCL Child — Platinum Credit Ltd theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PCL_CHILD_VERSION', '1.6.2' );
define( 'PCL_CHILD_DIR', get_stylesheet_directory() );
define( 'PCL_CHILD_URI', get_stylesheet_directory_uri() );

/* ── Helper: detect PCL Screen template pages ─────────────────────────── */
function is_pcl_screen() {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}
	$template = get_post_meta( get_the_ID(), '_wp_page_template', true );
	return $template === 'template-pcl-screen.php';
}

/* ── Suppress Astra header/footer on front-end ──────────────────────── */
function pcl_suppress_astra_chrome() {
	if ( is_admin() || is_pcl_screen() ) {
		return;
	}
	?>
	<style id="pcl-suppress-astra">
		/* Hide Astra's default header — we inject custom nav via wp_body_open */
		.site-header,
		.main-header-bar-wrap,
		.ast-primary-header-bar {
			display: none !important;
		}
		/* Hide Astra's default footer — we inject custom footer via wp_footer */
		.site-footer-wrap,
		.ast-footer-overlay,
		.footer-widget-area-wrap,
		.ast-footer-widget-area,
		.below-footer-widget-area-wrap,
		footer.site-footer {
			display: none !important;
		}
		/* Ensure body content is flush top */
		#content {
			padding-top: 0 !important;
			margin-top: 0 !important;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'pcl_suppress_astra_chrome', 1 );

/* ── Enqueue CSS modules (load order matters) ───────────────────────── */
function pcl_enqueue_styles() {
	$parent_version = wp_get_theme( 'astra' )->get( 'Version' );

	/* Astra parent */
	wp_enqueue_style(
		'astra-theme-css',
		get_template_directory_uri() . '/style.css',
		array(),
		$parent_version
	);

	/* Child base (tokens live in css/base.css now, but keep style.css for compat) */
	wp_enqueue_style(
		'pcl-child-style',
		PCL_CHILD_URI . '/style.css',
		array( 'astra-theme-css' ),
		PCL_CHILD_VERSION
	);

	/* Modular CSS — order: base → buttons → nav → hero → marquee → sections → tools → contact → footer → components → responsive */
	$css_modules = array(
		'base',
		'buttons',
		'nav',
		'hero',
		'marquee',
		'sections',
		'tools',
		'contact',
		'footer',
		'components',
		'responsive',
	);

	foreach ( $css_modules as $mod ) {
		wp_enqueue_style(
			'pcl-' . $mod,
			PCL_CHILD_URI . '/css/' . $mod . '.css',
			array( 'pcl-child-style' ),
			PCL_CHILD_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'pcl_enqueue_styles' );

/* ── Google Fonts ───────────────────────────────────────────────────── */
function pcl_enqueue_google_fonts() {
	wp_enqueue_style(
		'pcl-google-fonts',
		'https://fonts.googleapis.com/css2?family=Marcellus&family=Figtree:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'pcl_enqueue_google_fonts' );

/* ── Resource hints: preconnect Google Fonts (LCP fix) ─────────────── */
function pcl_resource_hints() {
	if ( is_admin() ) {
		return;
	}
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
	echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
}
add_action( 'wp_head', 'pcl_resource_hints', 0 );

/* ── Editor style ───────────────────────────────────────────────────── */
function pcl_editor_assets() {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'pcl_editor_assets' );

/* ── Skip link ──────────────────────────────────────────────────────── */
function pcl_skip_link() {
	echo '<a class="skip-link" href="#content">' . esc_html__( 'Skip to content', 'pcl-child' ) . '</a>';
}
add_action( 'wp_body_open', 'pcl_skip_link' );

/* ── Scroll progress bar + preloader ────────────────────────────────── */
function pcl_progress_and_preloader() {
	if ( is_admin() || is_pcl_screen() ) {
		return;
	}
	echo '<div id="pcl-progress" role="presentation"></div>';
	echo '<div id="pcl-loader" aria-hidden="true">';
	echo '<svg class="pcl-loader-gem" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="349 163 518 541"><defs><style>.cls-1{fill:currentColor;}</style></defs><path class="cls-1" d="M851.91,330.28l-54.38-103.1L757.28,172.8l-146.89-4.24-221,135.59L354,442.57l47.32,76.27,3.53,77.68L479,699.62H675.36l24-132.76,112.29-60,37.42-27.54,12.72-68.5Zm-18.83,5-190.67,40.6L783.64,243.42ZM620.28,187.4l128.53,4.7,25.89,37.67L620.63,375.83l-24.36-27.89ZM755.51,476.93,631.58,424.21l-5.3-35.67Zm-178.07,109-37.2-8.65,41-94.22,12.24,27.78Zm22-60,6.35,17-18.36,39.9Zm-87,45.66-82.39-13.65L413.6,507.54l3.77-66.39,71.56-58.85-19.78,81.92ZM506,378.07l27.52-29.49,48.66,2.89L605.8,382.3l-55,64.5-61.68,6.59Zm-16.86-43.9,33.72,10.47L500.23,363Zm63.56,124.64,24.78,15.36L528.83,574.8,489.1,465.69ZM522.29,583.1l53,21.54L565,628.47,444.61,567.39Zm63.38-114.17-24.24-19.77,52.26-57L616,422.53Zm0-128.53-51.55-3.29-40.49-14.6L607.92,195.87Zm0-136.53L482.22,313.33l-31.78-29.66ZM440.91,290.38l22.12,21,3.65,6.89-56.14-13.77ZM402.77,494.59l-28.72-45.43,31.9-6.59Zm3.18-60.5-33.9,5.3,25.78-105.22L406,408.32Zm63.91-105.57L485,367l-68.5,60-.35-32.13L406,313.33ZM413.6,539l11.06,28.43-9.53,18.53ZM485,687.85l-64.85-91.8,12.71-24.49L646.76,684.08Zm92.4-53.2,32.25-80,48.25,125.93ZM668.65,665,597.33,489.53l88.27,72.74Zm21.78-112.76L601,476.93l26.36-40L776.58,503.3ZM833.9,467.64l-36.37,23.65L646.76,388.54l191.38-37.07L847,411.85Z"/></svg>';
	echo '<div class="pcl-loader-word">Platinum Credit</div>';
	echo '</div>';
}
add_action( 'wp_body_open', 'pcl_progress_and_preloader', 5 );

/* ── Custom navigation (replaces Astra header) ─────────────────────── */
function pcl_custom_nav() {
	if ( is_admin() || is_pcl_screen() ) {
		return;
	}
	$whatsapp = '26669457676';
	$logo     = PCL_CHILD_URI . '/assets/logo-lockup.svg';
	?>
	<nav id="mainNav" class="pcl-site-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'pcl-child' ); ?>">
	  <div class="pcl-nav-in">
	    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pcl-brand" aria-label="<?php esc_attr_e( 'Platinum Credit Ltd home', 'pcl-child' ); ?>">
	      <svg class="pcl-logo-gem" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="349 163 518 541"><defs><style>.cls-1{fill:currentColor;}</style></defs><path class="cls-1" d="M851.91,330.28l-54.38-103.1L757.28,172.8l-146.89-4.24-221,135.59L354,442.57l47.32,76.27,3.53,77.68L479,699.62H675.36l24-132.76,112.29-60,37.42-27.54,12.72-68.5Zm-18.83,5-190.67,40.6L783.64,243.42ZM620.28,187.4l128.53,4.7,25.89,37.67L620.63,375.83l-24.36-27.89ZM755.51,476.93,631.58,424.21l-5.3-35.67Zm-178.07,109-37.2-8.65,41-94.22,12.24,27.78Zm22-60,6.35,17-18.36,39.9Zm-87,45.66-82.39-13.65L413.6,507.54l3.77-66.39,71.56-58.85-19.78,81.92ZM506,378.07l27.52-29.49,48.66,2.89L605.8,382.3l-55,64.5-61.68,6.59Zm-16.86-43.9,33.72,10.47L500.23,363Zm63.56,124.64,24.78,15.36L528.83,574.8,489.1,465.69ZM522.29,583.1l53,21.54L565,628.47,444.61,567.39Zm63.38-114.17-24.24-19.77,52.26-57L616,422.53Zm0-128.53-51.55-3.29-40.49-14.6L607.92,195.87Zm0-136.53L482.22,313.33l-31.78-29.66ZM440.91,290.38l22.12,21,3.65,6.89-56.14-13.77ZM402.77,494.59l-28.72-45.43,31.9-6.59Zm3.18-60.5-33.9,5.3,25.78-105.22L406,408.32Zm63.91-105.57L485,367l-68.5,60-.35-32.13L406,313.33ZM413.6,539l11.06,28.43-9.53,18.53ZM485,687.85l-64.85-91.8,12.71-24.49L646.76,684.08Zm92.4-53.2,32.25-80,48.25,125.93ZM668.65,665,597.33,489.53l88.27,72.74Zm21.78-112.76L601,476.93l26.36-40L776.58,503.3ZM833.9,467.64l-36.37,23.65L646.76,388.54l191.38-37.07L847,411.85Z"/></svg>
	      <span class="pcl-brand-name">Platinum Credit Ltd<small>Re Lora Le Uena</small></span>
	    </a>
	    <button class="pcl-menu-btn" aria-expanded="false" aria-controls="pcl-navlinks" type="button" aria-label="<?php esc_attr_e( 'Toggle menu', 'pcl-child' ); ?>">
	      <span class="pcl-menu-lines" aria-hidden="true"><i></i><i></i><i></i></span>
	      <span class="pcl-menu-label"><?php esc_html_e( 'Menu', 'pcl-child' ); ?></span>
	    </button>
	    <div class="pcl-nav-links" id="pcl-navlinks">
	      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
	      <a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Products</a>
	      <a href="<?php echo esc_url( home_url( '/estimator/' ) ); ?>">Estimator</a>
	      <a href="<?php echo esc_url( home_url( '/affordability/' ) ); ?>">Affordability</a>
	      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
	      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="pcl-btn pcl-btn-brand pcl-nav-cta">Apply Now</a>
	    </div>
	  </div>
	</nav>
	<?php
}
add_action( 'wp_body_open', 'pcl_custom_nav', 10 );

/* ── Custom footer (replaces Astra footer) ──────────────────────────── */
function pcl_custom_footer() {
	if ( is_admin() || is_pcl_screen() ) {
		return;
	}
	$whatsapp = '26669457676';
	$year     = gmdate( 'Y' );
	?>
	<footer class="pcl-site-footer" role="contentinfo">
	  <div class="pcl-footer-in">
	    <div class="pcl-footer-top">
	      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Platinum Credit Ltd', 'pcl-child' ); ?>" class="pcl-footer-logo">
	        <svg class="pcl-logo-lockup" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="66 257 1056 343"><defs><style>.cls-1{fill:currentColor;}</style></defs><path class="cls-1" d="M383.56,362.89,349.33,298,324,263.78l-92.44-2.67L92.44,346.44,70.22,433.56l29.78,48,2.22,48.88,46.67,64.89H272.44l15.12-83.55L358.22,474l23.56-17.33,8-43.11ZM371.7,366l-120,25.56,88.89-83.34ZM237.78,273l80.89,3L335,299.63l-97,91.93L222.67,374Zm85.11,182.23-78-33.19-3.33-22.44ZM210.81,523.78l-23.4-5.45L213.19,459l7.7,17.48ZM224.67,486l4,10.67-11.56,25.11Zm-54.74,28.74-51.86-8.59L107.7,474.44l2.37-41.77,45-37-12.44,51.56ZM165.83,393l17.32-18.55,30.63,1.81,14.89,19.41L194,436.22l-38.82,4.15Zm-10.61-27.63,21.22,6.6-14.22,11.55Zm40,78.45,15.59,9.66-30.59,63.34-25-68.67ZM176.11,522l33.33,13.56-6.44,15-75.78-38.45ZM216,450.15,200.74,437.7l32.89-35.85,1.48,19.09Zm0-80.89-32.44-2.07L158.07,358,230,278.3Zm0-85.93-65.11,68.89-20-18.66Zm-91.11,54.45L138.81,351l2.3,4.33-35.33-8.66Zm-24,128.52L82.81,437.7l20.08-4.14Zm2-38.08-21.33,3.34,16.22-66.23L102.89,412Zm40.22-66.44L152.67,386l-43.11,37.78-.23-20.22-6.44-51.34ZM107.7,494.22l7,17.89-6,11.67Zm45,93.71-40.82-57.78,8-15.41,134.59,70.82Zm58.14-33.49,20.3-50.37,30.37,79.26Zm57.41,19.12L223.33,463.11l55.56,45.78Zm13.71-71-56.3-47.4L242.22,430l93.93,41.78Zm90.29-53.26-22.89,14.89-94.89-64.66,120.45-23.34,5.55,38Z"/><path class="cls-1" d="M435.32,414.83v12.49c0,2.7.29,4.38.87,5a4.42,4.42,0,0,0,3.57,1.39h1.62v1.17H423.33v-1.17h1.59a4.21,4.21,0,0,0,3.82-1.77c.41-.65.62-2.2.62-4.65v-27.7c0-2.7-.28-4.37-.84-5a4.55,4.55,0,0,0-3.6-1.39h-1.59V392h15.44a26.89,26.89,0,0,1,8.91,1.19,12.27,12.27,0,0,1,5.5,4,10.41,10.41,0,0,1,2.23,6.67,11.34,11.34,0,0,1-3.4,8.54q-3.4,3.29-9.61,3.29a28.21,28.21,0,0,1-3.29-.22C437.93,415.35,436.67,415.13,435.32,414.83Zm0-1.8c1.1.21,2.07.37,2.92.47a17.16,17.16,0,0,0,2.17.16,7.36,7.36,0,0,0,5.58-2.54,9.38,9.38,0,0,0,2.34-6.6,12,12,0,0,0-1.12-5.17,7.8,7.8,0,0,0-3.16-3.57,9.15,9.15,0,0,0-4.66-1.19,17.64,17.64,0,0,0-4.43.49v18ZM457.13,392h14.15v48.47H457.13Zm0-24.76h14.15v15.21H457.13ZM503.83,392v1.42c-1.12-1.37-2.62-2.05-4.48-2.05-2.48,0-4.38.87-5.58,2.54-1.2,1.67-1.81,4.07-1.81,7.13v21.63c0,3.06.6,5.46,1.81,7.13,1.2,1.67,3.1,2.51,5.58,2.51,1.86,0,3.36-.68,4.48-2.05v1.74h13.89V392Zm0,35.13c0-3.1-.63-5.51-1.89-7.21-1.26-1.71-3.13-2.56-5.6-2.56-2.44,0-4.29.85-5.55,2.56-1.26,1.7-1.89,4.11-1.89,7.21v1.62c0,3.1.63,5.51,1.89,7.21,1.26,1.7,3.11,2.56,5.55,2.56,2.47,0,4.34-.86,5.6-2.56,1.26-1.7,1.89-4.11,1.89-7.21ZM544.21,417.83c0,5.09-1.59,8.94-4.77,11.54-3.18,2.61-7.27,3.91-12.27,3.91-5,0-9.09-1.3-12.27-3.91-3.18-2.6-4.77-6.45-4.77-11.54v-26c0-5.09,1.59-8.94,4.77-11.54,3.18-2.61,7.27-3.91,12.27-3.91s9.09,1.3,12.27,3.91c3.18,2.6,4.77,6.45,4.77,11.54Zm-14.73-26.07c0-3.1-.63-5.51-1.89-7.21-1.26-1.71-3.13-2.56-5.6-2.56-2.44,0-4.29.85-5.55,2.56-1.26,1.7-1.89,4.11-1.89,7.21v1.62c0,3.1.63,5.51,1.89,7.21,1.26,1.7,3.11,2.56,5.55,2.56,2.47,0,4.34-.86,5.6-2.56,1.26-1.7,1.89-4.11,1.89-7.21ZM597.59,392h15.5v48.47h-15.5V392Zm0-24.76h15.5v15.21h-15.5ZM628.79,416.56c0-3.17.68-5.68,2.05-7.5,1.37-1.83,3.36-2.74,5.98-2.74,2.62,0,4.61.91,5.98,2.74,1.37,1.82,2.05,4.33,2.05,7.5v1.91c0,3.17-.68,5.68-2.05,7.5-1.37,1.83-3.36,2.74-5.98,2.74-2.62,0-4.61-.91-5.98-2.74-1.37-1.82-2.05-4.33-2.05-7.5Zm14.06,0c0-3.1-.63-5.51-1.89-7.21-1.26-1.71-3.13-2.56-5.6-2.56-2.44,0-4.29.85-5.55,2.56-1.26,1.7-1.89,4.11-1.89,7.21v1.62c0,3.1.63,5.51,1.89,7.21,1.26,1.7,3.11,2.56,5.55,2.56,2.47,0,4.34-.86,5.6-2.56,1.26-1.7,1.89-4.11,1.89-7.21ZM675.21,392v48.47h-14.15V392Zm0-24.76h14.15v15.21H675.21ZM710.78,416.56c0-3.17.68-5.68,2.05-7.5,1.37-1.83,3.36-2.74,5.98-2.74,2.62,0,4.61.91,5.98,2.74,1.37,1.82,2.05,4.33,2.05,7.5v1.91c0,3.17-.68,5.68-2.05,7.5-1.37,1.83-3.36,2.74-5.98,2.74-2.62,0-4.61-.91-5.98-2.74-1.37-1.82-2.05-4.33-2.05-7.5Zm14.06,0c0-3.1-.63-5.51-1.89-7.21-1.26-1.71-3.13-2.56-5.6-2.56-2.44,0-4.29.85-5.55,2.56-1.26,1.7-1.89,4.11-1.89,7.21v1.62c0,3.1.63,5.51,1.89,7.21,1.26,1.7,3.11,2.56,5.55,2.56,2.47,0,4.34-.86,5.6-2.56,1.26-1.7,1.89-4.11,1.89-7.21ZM753.13,417.83c0,5.09-1.59,8.94-4.77,11.54-3.18,2.61-7.27,3.91-12.27,3.91-5,0-9.09-1.3-12.27-3.91-3.18-2.6-4.77-6.45-4.77-11.54v-26c0-5.09,1.59-8.94,4.77-11.54,3.18-2.61,7.27-3.91,12.27-3.91s9.09,1.3,12.27,3.91c3.18,2.6,4.77,6.45,4.77,11.54Zm-14.73-26.07c0-3.1-.63-5.51-1.89-7.21-1.26-1.71-3.13-2.56-5.6-2.56-2.44,0-4.29.85-5.55,2.56-1.26,1.7-1.89,4.11-1.89,7.21v1.62c0,3.1.63,5.51,1.89,7.21,1.26,1.7,3.11,2.56,5.55,2.56,2.47,0,4.34-.86,5.6-2.56,1.26-1.7,1.89-4.11,1.89-7.21ZM781.52,392h14.15v48.47h-14.15Zm0-24.76h14.15v15.21h-14.15Z"/></svg>
	      </a>
	      <div class="pcl-footer-links">
	        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
	        <a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Products</a>
	        <a href="<?php echo esc_url( home_url( '/estimator/' ) ); ?>">Estimator</a>
	        <a href="<?php echo esc_url( home_url( '/affordability/' ) ); ?>">Affordability</a>
	        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
	      </div>
	    </div>
	    <p class="pcl-footer-reg">Platinum Credit Ltd is a 100% Basotho-owned microfinance institution and registered credit provider, licensed and supervised by the Central Bank of Lesotho (Tier 2). Every application undergoes an affordability assessment — we will not extend credit an assessment indicates you cannot reasonably repay. A full pre-agreement statement of cost is provided before any funds are advanced, and a statutory cooling-off period and early-settlement options apply in line with the Financial Consumer Protection Act No. 7 of 2022. Interest rates and fees shown on this site are indicative; your binding cost of credit is set out in your personalised quotation. Borrow responsibly.</p>
	    <div class="pcl-footer-bottom">
	      <span>&copy; <?php echo esc_html( $year ); ?> Platinum Credit Ltd. All rights reserved.</span>
	      <span class="pcl-social">
	        <a href="https://www.facebook.com/profile.php?id=61576228466083" target="_blank" rel="noopener" aria-label="Platinum Credit Ltd on Facebook" title="Facebook">
	          <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.52 1.49-3.91 3.77-3.91 1.09 0 2.24.2 2.24.2v2.47H15.2c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.45 2.91h-2.33V22c4.78-.76 8.43-4.92 8.43-9.94z"/></svg>
	        </a>
	        <a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" aria-label="Chat with Platinum Credit Ltd on WhatsApp" title="WhatsApp +266 6945 7676">
	          <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.9-4.45 9.9-9.91a9.85 9.85 0 0 0-2.9-7.01A9.83 9.83 0 0 0 12.04 2zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24a8.2 8.2 0 0 1 5.83 2.42 8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23zm4.52-6.16c-.25-.13-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.78.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.23-.73-.66-1.23-1.47-1.38-1.72-.14-.24-.01-.38.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.13-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.42h-.48c-.17 0-.43.06-.66.31-.22.24-.86.85-.86 2.07 0 1.22.89 2.39 1.01 2.56.13.16 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.06-.1-.23-.16-.48-.29z"/></svg>
	        </a>
	        <a href="https://www.pcl.co.ls" target="_blank" rel="noopener" class="pcl-social-link-text">www.pcl.co.ls</a>
	        <a href="mailto:info@pcl.co.ls" class="pcl-social-link-text">info@pcl.co.ls</a>
	      </span>
	      <span>Maseru &middot; Kingdom of Lesotho</span>
	    </div>
	  </div>
	</footer>
	<?php
}
add_action( 'wp_footer', 'pcl_custom_footer' );

/* ── Disable Astra page title on pages ──────────────────────────────── */
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

/* ── #content id for skip link ──────────────────────────────────────── */
function pcl_add_content_id( $content ) {
	if ( is_singular( 'page' ) && ! is_front_page() ) {
		return '<div id="content">' . $content . '</div>';
	}
	return $content;
}

/* ── Block pattern category ─────────────────────────────────────────── */
function pcl_block_patterns_category() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'pcl',
			array( 'label' => __( 'Platinum Credit Sections', 'pcl-child' ) )
		);
	}
}
add_action( 'init', 'pcl_block_patterns_category' );

/* ── Register block patterns from sections/ ─────────────────────────── */
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

/* ── Enqueue JS modules (deferred, front-end only) ─────────────────── */
function pcl_enqueue_js_modules() {
	if ( is_admin() ) {
		return;
	}

	$js_modules = array(
		'preloader',
		'nav',
		'reveal',
		'spotlight',
		'hero',
		'estimator',
		'affordability',
	);

	foreach ( $js_modules as $mod ) {
		wp_enqueue_script(
			'pcl-' . $mod,
			PCL_CHILD_URI . '/js/' . $mod . '.js',
			array(),
			PCL_CHILD_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'pcl_enqueue_js_modules' );

/* ── Defer non-critical JS (Core Web Vitals) ────────────────────────── */
function pcl_defer_scripts( $tag, $handle ) {
	if ( is_admin() ) {
		return $tag;
	}
	// Keep nav instant; defer everything else (spotlight/reveal/hero/tools are below-fold or progressive)
	$defer_handles = array( 'pcl-preloader', 'pcl-reveal', 'pcl-spotlight', 'pcl-hero', 'pcl-estimator', 'pcl-affordability' );
	if ( in_array( $handle, $defer_handles, true ) ) {
		if ( false === strpos( $tag, ' defer' ) ) {
			$tag = str_replace( ' src', ' defer src', $tag );
		}
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'pcl_defer_scripts', 10, 2 );

/* ── WhatsApp float button ──────────────────────────────────────────── */
function pcl_whatsapp_float() {
	if ( is_admin() || is_pcl_screen() ) {
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

/* ── SEO helpers: keyword-mapped titles + descriptions ─────────────── */
function pcl_seo_map() {
	return array(
		'home' => array(
			'title' => 'Platinum Credit Ltd — Licensed Loans in Lesotho | Re Lora Le Uena',
			'desc'  => 'Platinum Credit Ltd — 100% Basotho-owned, CBL-licensed Tier 2 lender in Maseru. Affordable personal, business & MSME loans across Lesotho. Transparent pricing.',
		),
		'about' => array(
			'title' => 'About Us — Basotho-Owned CBL Lender | Platinum Credit Lesotho',
			'desc'  => 'About Platinum Credit Ltd — 100% Basotho-owned, CBL-licensed Tier 2 microfinance institution. Responsible, affordable credit for Basotho individuals and MSMEs.',
		),
		'products' => array(
			'title' => 'Loan Products — Personal & Business | Platinum Credit Lesotho',
			'desc'  => 'Explore Platinum Credit loan products — personal loans, MSME business loans & asset finance in Lesotho. CBL-regulated, transparent pricing, flexible terms.',
		),
		'estimator' => array(
			'title' => 'Loan Calculator — Estimate Repayments | Platinum Credit Lesotho',
			'desc'  => 'Free loan calculator — estimate monthly repayments, total interest and cost for Platinum Credit loans in Lesotho. Instant, transparent results before you apply.',
		),
		'affordability' => array(
			'title' => 'Affordability Check — Can You Afford a Loan? | Platinum Credit',
			'desc'  => 'Free affordability assessment — check income, expenses and existing debt to confirm you can repay responsibly. Required for every CBL-regulated loan in Lesotho.',
		),
		'contact' => array(
			'title' => 'Contact Us — Thulo Building Maseru | Platinum Credit Lesotho',
			'desc'  => 'Contact Platinum Credit Ltd at Thulo Building, Maseru. Call +266 22324412, WhatsApp +266 69457676 or email info@pcl.co.ls. Directions & opening hours.',
		),
		'privacy-policy' => array(
			'title' => 'Privacy Policy — How We Protect Your Data | Platinum Credit Ltd',
			'desc'  => 'Platinum Credit Ltd privacy policy — how we collect, use and protect your personal data under Lesotho law and the Financial Consumer Protection Act 7 of 2022.',
		),
		'terms-of-service' => array(
			'title' => 'Terms of Service — Loan Terms & Conditions | Platinum Credit Ltd',
			'desc'  => 'Terms and conditions for Platinum Credit Ltd loans — interest, fees, cooling-off, early settlement and borrower rights under Lesotho financial law.',
		),
		'terms' => array(
			'title' => 'Terms of Service — Loan Terms & Conditions | Platinum Credit Ltd',
			'desc'  => 'Terms and conditions for Platinum Credit Ltd loans — interest, fees, cooling-off, early settlement and borrower rights under Lesotho financial law.',
		),
	);
}

function pcl_get_seo_for_current_page() {
	$map  = pcl_seo_map();
	$site = 'Platinum Credit Ltd';

	if ( is_front_page() ) {
		return $map['home'];
	}
	if ( is_singular( 'page' ) ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( isset( $map[ $slug ] ) ) {
			return $map[ $slug ];
		}
		// Fallback: page title + auto description
		$title = get_the_title() . ' | ' . $site . ' Lesotho';
		$raw   = get_the_excerpt() ?: get_the_content();
		$desc  = wp_trim_words( wp_strip_all_tags( $raw ), 28, '' );
		if ( mb_strlen( $desc ) > 160 ) {
			$desc = mb_substr( $desc, 0, 157 ) . '…';
		}
		if ( ! $desc ) {
			$desc = $map['home']['desc'];
		}
		return array( 'title' => $title, 'desc' => $desc );
	}
	return null;
}

/* ── SEO: keyword-optimized document title (<title>) ────────────────── */
function pcl_document_title( $title ) {
	if ( is_admin() ) {
		return $title;
	}
	$seo = pcl_get_seo_for_current_page();
	if ( $seo && isset( $seo['title'] ) ) {
		return $seo['title'];
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'pcl_document_title', 10 );

/* ── SEO: Open Graph + canonical + JSON-LD (enhanced) ───────────────── */
function pcl_seo_meta() {
	if ( is_admin() ) {
		return;
	}

	$seo = pcl_get_seo_for_current_page();
	if ( ! $seo ) {
		return;
	}

	$site_name    = 'Platinum Credit Ltd';
	$site_url     = home_url();
	$desc_default = 'Platinum Credit Ltd — 100% Basotho-owned, CBL-licensed Tier 2 lender in Maseru. Affordable personal, business & MSME loans across Lesotho with transparent pricing.';

	$title = $seo['title'];
	$desc  = $seo['desc'];
	if ( mb_strlen( $desc ) > 160 ) {
		$desc = mb_substr( $desc, 0, 157 ) . '…';
	}

	if ( is_front_page() ) {
		$url = $site_url . '/';
	} elseif ( is_singular( 'page' ) ) {
		$url = get_permalink();
	} else {
		$url = $site_url . '/';
	}

	$og_image = $site_url . '/wp-content/themes/pcl-child/assets/og-image.png';

	echo '<link rel="canonical" href="' . esc_url( $url ) . "\" />\n";
	echo '<meta name="description" content="' . esc_attr( $desc ) . "\" />\n";
	echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />' . "\n";
	echo '<meta name="author" content="' . esc_attr( $site_name ) . '" />' . "\n";
	echo '<meta property="og:type" content="website" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $og_image ) . '" />' . "\n";
	echo '<meta property="og:image:width" content="1200" />' . "\n";
	echo '<meta property="og:image:height" content="630" />' . "\n";
	echo '<meta property="og:image:alt" content="' . esc_attr( $site_name . ' — Re Lora Le Uena | Licensed microloans in Lesotho' ) . '" />' . "\n";
	echo '<meta property="og:image:type" content="image/png" />' . "\n";
	echo '<meta property="og:locale" content="en_GB" />' . "\n";
	echo '<meta property="og:locale:alternate" content="en_US" />' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $og_image ) . '" />' . "\n";
	echo '<meta name="twitter:image:alt" content="' . esc_attr( $site_name . ' — Licensed microloans in Lesotho' ) . '" />' . "\n";

	$jsonld = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'FinancialService',
		'@id'         => $site_url . '/#organization',
		'name'        => 'Platinum Credit Ltd',
		'alternateName' => 'PCL Lesotho',
		'slogan'      => 'Re Lora Le Uena',
		'description' => $desc_default,
		'url'         => $site_url . '/',
		'logo'        => $site_url . '/wp-content/themes/pcl-child/assets/logo-lockup.svg',
		'image'       => $og_image,
		'telephone'   => array( '+26622324412', '+26652011000' ),
		'email'       => 'info@pcl.co.ls',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Thulo Building',
			'addressLocality' => 'Maseru',
			'postalCode'      => '100',
			'addressRegion'   => 'Maseru',
			'addressCountry'  => 'LS',
		),
		'geo'         => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => '-29.3167',
			'longitude' => '27.4833',
		),
		'areaServed'  => array(
			array(
				'@type' => 'Country',
				'name'  => 'Lesotho',
			),
			array(
				'@type' => 'City',
				'name'  => 'Maseru',
			),
		),
		'priceRange'  => '$$',
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
				'opens'     => '08:00',
				'closes'    => '17:00',
			),
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Saturday' ),
				'opens'     => '08:00',
				'closes'    => '13:00',
			),
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

/* ── SEO: BreadcrumbList (inner pages) ───────────────────────────────── */
function pcl_breadcrumb_jsonld() {
	if ( is_admin() || is_front_page() || ! is_singular( 'page' ) ) {
		return;
	}
	$site_url = home_url();
	$crumbs   = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Home',
			'item'     => $site_url . '/',
		),
		array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		),
	);
	$data = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $crumbs,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'pcl_breadcrumb_jsonld', 2 );

/* ── SEO: Service schema for Products page ────────────────────────────── */
function pcl_service_schema() {
	if ( is_admin() || ! is_page( 'products' ) ) {
		return;
	}
	$site_url = home_url();
	$services = array(
		array( 'name' => 'Personal Loans', 'desc' => 'Affordable personal loans for Basotho individuals — fast approval, transparent pricing, flexible repayment terms.' ),
		array( 'name' => 'Business & MSME Loans', 'desc' => 'Working capital and growth loans for micro, small and medium enterprises across Lesotho.' ),
		array( 'name' => 'Asset Finance', 'desc' => 'Finance for equipment, vehicles and productive assets — build your business with structured repayments.' ),
	);
	$items = array();
	foreach ( $services as $svc ) {
		$items[] = array(
			'@type'       => 'Service',
			'serviceType' => $svc['name'],
			'name'        => $svc['name'],
			'description' => $svc['desc'],
			'provider'    => array( '@id' => $site_url . '/#organization' ),
			'areaServed'  => array( '@type' => 'Country', 'name' => 'Lesotho' ),
		);
	}
	$data = array(
		'@context' => 'https://schema.org',
		'@graph'   => $items,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'pcl_service_schema', 3 );

/* ── SEO: robots.txt — ensure sitemap is declared ────────────────────── */
function pcl_robots_txt( $output, $public ) {
	if ( '0' === (string) $public ) {
		return $output;
	}
	$sitemap = 'Sitemap: ' . esc_url( home_url( '/wp-sitemap.xml' ) );
	if ( false === strpos( $output, 'Sitemap:' ) ) {
		$output .= "\n" . $sitemap . "\n";
	}
	return $output;
}
add_filter( 'robots_txt', 'pcl_robots_txt', 10, 2 );
