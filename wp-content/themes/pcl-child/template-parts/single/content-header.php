<?php
/**
 * PCL Child — Single Page content-header override.
 * Suppresses the Astra entry-header (page title) on the front page
 * because the hero pattern provides the H1. Keeps header for inner pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Suppress header on front page regardless of Astra option — ensures single H1 from hero
if ( is_front_page() ) {
	// No entry-header — hero pattern in entry-content provides the H1
} else {
	if ( apply_filters( 'astra_single_layout_one_banner_visibility', true ) ) {
		if ( ! ( is_front_page() && 'page' === get_option( 'show_on_front' ) && astra_get_option( 'ast-dynamic-single-page-disable-structure-meta-on-front-page', false ) ) ) {
			?>
			<header class="entry-header <?php astra_entry_header_class(); ?>">
				<?php astra_banner_elements_order(); ?>
			</header> <!-- .entry-header -->
			<?php
		}
	}
}
?>

<div class="entry-content clear"
	<?php
			echo wp_kses_post(
				astra_attr(
					'article-entry-content-page',
					array(
						'class' => '',
					)
				)
			);
			?>
>

	<?php astra_entry_content_before(); ?>

	<?php the_content(); ?>

	<?php astra_entry_content_after(); ?>

	<?php
		wp_link_pages(
			array(
				'before'      => '<div class="page-links">' . esc_html( astra_default_strings( 'string-single-page-links-before', false ) ),
				'after'       => '</div>',
				'link_before' => '<span class="page-link">',
				'link_after'  => '</span>',
			)
		);
		?>

</div><!-- .entry-content .clear -->
