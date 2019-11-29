<?php
/**
 * The template for displaying search results pages.
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
					global $wp_query;
					$posts_per_page = $wp_query->posts_per_page;
					$posts_found    = ! empty($wp_query->found_posts) ? $wp_query->found_posts : 0;	
				?>

					<div class="search-page-result-content">
						<strong class="result-text"><?php printf( esc_attr__( 'Found %s result(s)', 'jayla' ), '<span>' . $posts_found . '</span>' ); ?></strong>
					</div><!-- .search-page-result-content -->

					<?php  

					while ( have_posts() ) : the_post();
						/**
						 * Hooks
						 *
						 * @hooked jayla_post_loop_search_temp          - 20
						 */
						do_action( 'jayla_loop_search' );
					
					endwhile;

					jayla_paging_nav();

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
