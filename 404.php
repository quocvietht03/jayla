<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package jayla
 */

get_header(); ?>
<div id="main-content">
	<div class="<?php do_action('jayla_container_class') ?>">
		<div class="row">
			<div id="primary" class="content-area col-md-12">

				<main id="main" class="site-main" role="main">

					<div class="error-404 not-found">

						<div class="page-content">

							<header class="page-header">
								<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'jayla' ); ?></h1>
							</header><!-- .page-header -->

							<p><?php esc_html_e( 'Nothing was found at this location. Try searching, or check out the links below.', 'jayla' ); ?></p>

							<?php
							echo '<section aria-label="' . esc_html__( 'Search', 'jayla' ) . '">';

							get_search_form();

							echo '</section>';

							?>

						</div><!-- .page-content -->
					</div><!-- .error-404 -->

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
</div>

<?php get_footer();
