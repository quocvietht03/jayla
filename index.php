<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package jayla
 */

get_header(); ?>
<div id="main-content">
	<div class="<?php do_action('jayla_container_class') ?>">
		<div class="row">
			<div id="primary" class="content-area <?php do_action('jayla_content_class'); ?>">
				<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) :
				
					get_template_part( 'loop' );

				else :

					get_template_part( 'content', 'none' );

				endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php do_action( 'jayla_sidebar' ); ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div>
<?php
get_footer();
