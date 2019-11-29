<?php
/**
 * @package Bears Lookbook
 * Archive template
 *  
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
get_header( 'jayla-team' );

/**
 * @hook jayla_team_before_archive_content. 
 * 
 * @see jayla_team_before_archive_content_open - 10 
 */
do_action( 'jayla_team_before_archive_content' );

while ( have_posts() ) {
    the_post();
    do_action( 'jayla_team_archive_item_entry' );
}

/**
 * @hook jayla_team_after_archive_content. 
 * 
 * @see jayla_team_before_archive_content_close - 90 
 */
do_action( 'jayla_team_after_archive_content' );

get_footer( 'jayla-team' );
