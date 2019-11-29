<?php
add_action( 'wp_enqueue_scripts', 'jayla_add_custom_width_container_large', 20 );

add_filter( 'jayla_post_title_layout_default_before', 'jayla_title_sticky_post', 10, 2 );

/**
 * General
 *
 * @see  jayla_get_sidebar()
 */
add_action( 'jayla_sidebar', 'jayla_get_sidebar', 10 );

/**
 * Scss variables 
 */
add_filter( 'jayla_scss_variables', 'jayla_scss_variables_add_page_loading_color' );

/**
 * 
 */
add_filter( 'jayla_custom_style_inline', 'jayla_style_inline_page_loading_color' );

add_action('jayla_container_class', 'jayla_container_class_func', 10);
add_action('jayla_content_class', 'jayla_content_class_func');

/**
 * Header
 *
 * @see jayla_header_attributes()
 * @see jayla_header()
 */
add_action( 'jayla_header_attributes',    'jayla_header_attributes',    10 );
add_action( 'jayla_header',               'jayla_header_button_toggle', 5 );
add_action( 'jayla_header',               'jayla_header_builder',       10 );

add_action( 'jayla_before_header_builder', 'jayla_header_strip', 20 );

/**
 * Posts
 *
 * @see  jayla_load_loop_post_template()
 */
add_action( 'jayla_loop_post',           'jayla_load_loop_post_template',     20 );
add_action( 'jayla_loop_after',          'jayla_paging_nav',                  25 );

add_action( 'jayla_post_single_entry',    'jayla_post_single_entry_default',   20 );
add_action( 'jayla_no_post_single_entry', 'jayla_no_post_single_entry_default',   20 );

add_action( 'jayla_single_post',         'jayla_load_single_post_template',   10 );
add_action( 'jayla_post_content_before', 'jayla_post_thumbnail',              20 );
add_action( 'jayla_single_post_bottom',  'jayla_post_nav',                    10 );
add_action( 'jayla_single_post_bottom',  'jayla_display_comments',            20 );

/**
 * Pages
 *
 * @see  jayla_page_header()
 * @see  jayla_page_content()
 * @see  jayla_display_comments()
 */
add_action( 'jayla_page',       'jayla_page_header',          10 );
add_action( 'jayla_page',       'jayla_page_content',         20 );
add_action( 'jayla_page_after', 'jayla_display_comments',     10 );

/**
 * Sidebar
 *
 * @see jayla_sidebar_sticky_attr_func()
 */
add_action('jayla_sidebar_sticky_attr', 'jayla_sidebar_sticky_attr_func', 10);


/**
 * Content
 *
 * @see  jayla_heading_bar()
 */
add_action( 'jayla_content_top',          'jayla_heading_bar_func', 10 );
add_filter( 'jayla_heading_bar_options',  'jayla_heading_bar_filter_options', 10 );
add_action( 'jayla_after_heading_bar',    'jayla_breadcrumbs', 20 );

/**
 * Footer
 *
 * @see  jayla_footer_widgets()
 * @see  jayla_credit()
 */
add_action( 'jayla_footer', 'jayla_footer_builder', 10 );
add_action( 'jayla_footer', 'jayla_credit',         20 );

add_action( 'wp_footer', 'jayla_widget_search_form',      15 );

/**
 *
 */
add_action ( 'jayla_search_form_loop_result_item', 'jayla_search_form_loop_result_item_func', 15);
add_filter ( 'jayla_list_taxonomies_by_post_type', 'jayla_filter_list_taxonomies_by_post_type' );
add_filter ( 'jayla_taxonomies_by_post_type_post', 'jayla_list_taxonomies_by_post' );

add_action( 'jayla_loop_before', 'jayla_furygrid_blog_category_filter_bar', 18 );
add_action( 'jayla_loop_before', 'jayla_furygrid_html_open', 20 );
add_action( 'jayla_loop_after', 'jayla_furygrid_html_close', 20 );
add_filter( 'jayla_blog_archive_layout_grid', 'jayla_archive_post_grid_template', 20 );

/**
 * Metabox customize settings post type support 
 */
add_filter( 'jayla_metabox_posttype_support_filter', 'jayla_metabox_support_jetpack_posttype' );

/**
 * Metabox Settings Template
 */
add_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_heading_bar', 20 );
add_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_header', 24 );
add_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_footer', 28 );
add_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_layout', 32 );
add_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_sidebar', 36 );

add_action( 'jayla_metabox_customize_settings_after_general', 'jayla_metabox_customize_heading_bar_settings_panel', 20 );

/**
 * Overide footer text 
 * admin_footer_text
 */
add_filter( 'jayla_admin_footer_text', 'jayla_overide_footer_text' );

/**
 * Scroll Top 
 */
add_action( 'wp_footer', 'jayla_scroll_top' );

/**
 * Body class page loading 
 */
add_filter( 'body_class', 'jayla_add_page_loading_class' );
add_filter( 'body_class', 'jayla_post_single_layout_class' );

/**
 * Post grid template hooks 
 */
add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_thumbnail_temp', 20 );
add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_comment_count_temp', 20 );

add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_entry_wrap_open', 21 );
add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_cat_temp', 22 );
add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_title_temp', 24 );
add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_author_temp', 26 );
add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_created_temp', 28 );
add_action( 'jayla_post_grid_item_entry', 'jayla_post_grid_item_entry_wrap_close', 30 );

add_filter( 'jayla_blog_filter_bar_style_inline', 'jayla_blog_filter_bar_style_inline_html', 20, 2 );
add_filter( 'jayla_blog_filter_bar_style_select', 'jayla_blog_filter_bar_style_select_html', 20, 2 );

/**
 * Single post default 
 */
add_action( 'jayla_single_post_top', 'jayla_single_post_header_temp', 20 );
add_action( 'jayla_single_post_bottom', 'jayla_post_related_carousel', 12 );

/**
 * Related post 
 */
add_action( 'jayla_related_post_carousel_item', 'jayla_related_post_carousel_item_entry', 20, 2 );

add_filter( 'jayla_get_post_id', 'jayla_filter_post_id_is_special_page' );

add_action( 'jayla_loop_search', 'jayla_post_loop_search_temp', 20 );

add_filter( 'jayla_get_wp_widget_param_filter', 'jayla_wp_widget_param_default', 20, 2 );

add_filter( 'jayla_taxonomy_heading_bar_options', 'jayla_taxonomy_heading_bar_background_options_override', 20, 2 );

add_filter( 'jayla_widget_element_class_filter', 'jayla_widget_element_class_display_inline', 20, 2 );

add_action( 'carbon_fields_register_fields', 'jayla_is_blog_page_settings' );
add_filter( 'the_content', 'jayla_filter_the_content_is_blog_page' );

add_action( 'jayla_the_content_is_blog_page_layout_first-item-full', 'jayla_blog_layout_first_item_full', 20 );
add_action( 'jayla_the_content_is_blog_page_layout_featured-post-slide', 'jayla_blog_layout_featured_post_slide', 20 );
add_action( 'jayla_custom_blog_after_loop', 'jayla_paging_nav' );

add_filter( 'cs_sidebar_params', 'jayla_cs_sidebar_custom_params' );
add_filter( 'upload_mimes', 'jayla_mime_svg_type' );

add_filter( 'jayla_register_wp_widgets_filter', 'jayla_add_delipress_widgets' );

add_action( 'jayla_install_demo_one_click_before_install_plugin', 'jayla_install_package_one_click_active_multi_plugin_helpers' );
add_filter( 'comment_form_fields', 'jayla_move_comment_and_cookies_field_to_bottom' );

add_action( 'jayla_post_single_clean_meta_entry_top', 'jayla_post_single_clean_meta_entry_template', 10 );
add_action( 'jayla_post_single_clean_entry', 'jayla_post_single_clean_entry_content', 10 );

add_filter( 'jayla_blog_layout_furygrid_opts_filter', 'jayla_blog_layout_clean_custom_furygrid_opts' );

add_filter( 'jayla_header_strip_data_filter', 'jayla_header_strip_data_custom_in_page', 20 );

add_action( 'wp_footer', 'jayla_custom_search_template' );

add_action( 'jayla_custom_search_post_before_result', 'jayla_custom_search_before_result', 20, 2 );
add_action( 'jayla_custom_search_post_after_result', 'jayla_custom_search_after_result', 20, 2 );

add_action( 'jayla_custom_search_post_result_item', 'jayla_item_search_result_template', 20 );

add_action( 'jayla_content_search_item_after_meta_tags', 'jayla_content_search_item_after_meta_tags_post_cat', 20 );
add_action( 'jayla_content_search_item_after_meta_tags', 'jayla_content_search_item_after_meta_tags_post_tag', 22 );
