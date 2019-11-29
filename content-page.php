<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package jayla
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to jayla_page add_action
	 *
	 * @hooked jayla_page_header          - 10
	 * @hooked jayla_page_content         - 20
	 */
	do_action( 'jayla_page' );
	?>
</div><!-- #post-## -->
