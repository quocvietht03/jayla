<?php
/**
 * The template for displaying archive pages.
 *
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

				<?php if ( have_posts() ) :  ?>
					 
					<?php get_template_part( 'loop' ); ?> 

				<?php else :

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
