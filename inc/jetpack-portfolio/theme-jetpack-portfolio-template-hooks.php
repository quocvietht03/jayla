<?php
/**
 * @package Jayla 
 * Jetpack Portfolio hooks
 * 
 */

add_filter( 'jayla_scheme_container_class', 'jayla_scheme_container_class_custom_jetpack_porfolio_archive' );
add_filter( 'jayla_scheme_container_class', 'jayla_scheme_container_class_custom_jetpack_porfolio_single' );

add_filter( 'jayla_blog_archive_layout_path_filter', 'jayla_portfolio_archive_layout_path_filter' );
add_filter( 'jayla_blog_single_layout_path_filter', 'jayla_portfolio_single_layout_path_filter' );

add_action( 'jayla_loop_before', 'jayla_jetpack_portfolio_archive_add_furygrid_open' );
add_action( 'jayla_loop_after', 'jayla_jetpack_portfolio_archive_add_furygrid_close' );
add_action( 'jayla_jetpack_portfolio_archive_entry_hooks', 'jayla_jetpack_portfolio_archive_entry_content', 20 );
add_action( 'jayla_jetpack_portfolio_archive_entry_content_thumbnail_after', 'jayla_post_added_likes_button', 20 );

add_action( 'pre_get_posts', 'jayla_jetpack_portfolio_custom_posts_per_page', 30 );

add_filter( 'jayla_heading_bar_display_data', 'jayla_jetpack_portfolio_single_heading_bar_disable' );
add_action( 'jayla_single_jetpack_portfolio_bottom', 'jayla_post_nav', 10 );
add_action( 'jayla_single_jetpack_portfolio_bottom', 'jayla_display_comments', 20 );

add_action( 'jayla_jetpack_portfolio_single_entry', 'jayla_jetpack_portfolio_single_entry_content' );
add_action( 'jayla_jetpack_portfolio_single_entry', 'jayla_jetpack_portfolio_single_entry_section' );

add_action( 'jayla_jetpack_portfolio_info_item', 'jayla_jetpack_portfolio_info_item_client', 10 );
add_action( 'jayla_jetpack_portfolio_info_item', 'jayla_jetpack_portfolio_info_date_work', 15 );
add_action( 'jayla_jetpack_portfolio_info_item', 'jayla_jetpack_portfolio_info_tags', 18 );
add_action( 'jayla_jetpack_portfolio_single_after_entry_content', 'jayla_post_added_likes_button', 20 );
add_filter( 'jayla_display_comment_filter', 'jayla_jetpack_portfolio_single_display_comment' );
add_filter( 'jayla_custom_metabox_variable_jetpack-portfolio_data', 'jayla_jetpack_portfolio_custom_metabox_data', 20, 2 );