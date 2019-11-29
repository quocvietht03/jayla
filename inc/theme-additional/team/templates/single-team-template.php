<?php
/**
 * The template for displaying all single posts.
 *
 * @package jayla
 */

get_header(); ?>
<div id="main-content">
	<div class="<?php do_action('jayla_container_class') ?>">
		<div class="row">
			<div id="primary" class="content-area <?php do_action('jayla_content_class'); ?>">
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post();

					do_action( 'jayla_team_single_post_before' );

					do_action( 'jayla_team_single_post' );

					do_action( 'jayla_team_single_post_after' );

				endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .row -->
	</div><!-- .container -->
</div>
<?php
get_footer();
