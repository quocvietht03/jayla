<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: http://codex.wordpress.org/The_Loop
 *
 * @package jayla
 */

/**
 * Hooks
 * @see jayla_furygrid_blog_category_filter_bar - 18
 * @see jayla_furygrid_html_open - 20
 */
do_action( 'jayla_loop_before' );

while ( have_posts() ) : the_post();

	/**
	 * Functions hooked in to jayla_loop_post action.
	 *
	 * @hooked jayla_load_loop_post_template          - 20
	 */
	do_action( 'jayla_loop_post' );

endwhile;

/**
 * Functions hooked in to jayla_paging_nav action
 * @see jayla_furygrid_html_close - 20
 * @see jayla_paging_nav - 25
 */
do_action( 'jayla_loop_after' );
