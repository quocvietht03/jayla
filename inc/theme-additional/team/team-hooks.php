<?php 
add_filter( 'jayla_metabox_posttype_support_filter' , 'jayla_team_metabox_posttype_support' );

/**
 * Filter team archive page
 *  
 */
add_filter( 'archive_template', 'jayla_team_get_custom_archive_page_template', 20 ) ;

/**
 * Filter team single page
 *  
 */
add_filter( 'single_template', 'jayla_team_get_custom_post_type_template', 20 );
add_filter( 'jayla_content_end_class', 'jayla_team_content_end_class_func', 20 );
add_action( 'jayla_team_single_image_cover', 'jayla_team_single_image_cover_func', 20 );

add_action( 'jayla_team_single_post' , 'jayla_team_single_entry_open', 10 ); #open 
add_action( 'jayla_team_single_post', 'jayla_team_single_avatar_box_html', 22 );
add_action( 'jayla_team_single_post', 'jayla_team_single_content_html', 24 );
add_action( 'jayla_team_single_post' , 'jayla_team_single_entry_close', 60 ); #close

add_action( 'jayla_team_avatar_after_entry', 'jayla_team_qoute_box_html', 10 );
add_action( 'jayla_team_avatar_after_entry', 'jayla_team_follow_me_html', 15 );

add_action( 'jayla_team_after_content', 'jayla_team_features_section_container', 20 );
add_action( 'jayla_team_feature_section_type_skill_progress_bar', 'jayla_team_feature_section_type_skill_progress_bar_func' );
add_action( 'jayla_team_feature_section_type_timeline', 'jayla_team_feature_section_type_timeline_func' );

add_action( 'jayla_team_single_image_cover_inner_entry', 'jayla_team_infomation_inline_html', 20 );

add_action( 'jayla_team_before_archive_content', 'jayla_team_before_archive_content_open', 10 );
add_action( 'jayla_team_after_archive_content', 'jayla_team_before_archive_content_close', 10 );

add_action( 'jayla_team_before_archive_content', 'jayla_team_before_archive_content_masonry_open', 10 );
add_action( 'jayla_team_after_archive_content', 'jayla_team_before_archive_content_masonry_close', 10 );

add_action( 'jayla_team_archive_item_entry', 'jayla_team_archive_item_entry_func', 20 );

add_filter( 'jayla_taxonomy_list_filter', 'jayla_team_add_more_taxonomy_list' );