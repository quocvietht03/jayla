<?php
/**
 * The template for displaying gutenberg template pages.
 *
 * Template Name: Gutenberg Template
 *
 * @since 1.0.2
 * @package jayla
 */

get_header(); ?>
<div id="main-content">
	<!-- <div class="<?php do_action('jayla_container_class') ?>"> -->
		<div id="primary" class="content-area">
			<main id="main" class="site-main gutenberg-entry-container" role="main">

				<?php while ( have_posts() ) : the_post();
					the_content();
				endwhile; // End of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	<!-- </div> -->
</div>
<?php
get_footer();
