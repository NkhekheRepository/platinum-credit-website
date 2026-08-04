<?php
/**
 * PCL Child — page template override.
 * Removes the Astra entry-header (page title) since hero patterns contain their own H1.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

error_log("PCL Child: Using custom content-page.php");

?>
<?php astra_entry_before(); ?>
<article <?php post_class(); ?>>
	<?php
	/**
	 * Skip astra_entry_top() — this removes the entry-header (page title).
	 * The hero pattern in page content provides the H1.
	 */
	?>

	<?php astra_entry_content_single_page(); ?>

	<?php
	astra_edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'astra' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<footer class="entry-footer"><span class="edit-link">',
		'</span></footer><!-- .entry-footer -->'
	);
	?>

	<?php astra_entry_bottom(); ?>
</article><!-- #post-## -->
<?php astra_entry_after(); ?>
