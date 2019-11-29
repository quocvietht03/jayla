<?php
/**
 * Jayla WooCommerce hooks
 *
 * @package jayla
 */

remove_action( 'woocommerce_before_single_product',   'wc_print_notices',    10 );

remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );

remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );

remove_action( 'woocommerce_before_shop_loop_item_title',     'woocommerce_show_product_loop_sale_flash',    10 );

remove_action( 'woocommerce_shop_loop_item_title',     'woocommerce_template_loop_product_title',    10 );
remove_action( 'woocommerce_after_shop_loop_item_title',     'woocommerce_template_loop_rating',     5 );
remove_action( 'woocommerce_after_shop_loop_item_title',     'woocommerce_template_loop_price',      10 );

remove_action( 'woocommerce_after_shop_loop_item',     'woocommerce_template_loop_add_to_cart',      10 );


add_action( 'jayla_woo_after_loop_thumbnail_link',  'jayla_woo_custom_loop_add_to_cart_link',   10 );

add_action( 'woocommerce_before_shop_loop_item',  'jayla_woo_before_link_open',               5 );
add_action( 'woocommerce_after_shop_loop_item',   'jayla_woo_after_link_close',               6 );

add_action( 'woocommerce_before_main_content',    'jayla_woo_before_content',                10 );
add_action( 'woocommerce_after_main_content',     'jayla_woo_after_content',                 10 );

add_filter( 'woocommerce_show_page_title',        'jayla_woo_show_page_title', 10 );

/* woocommerce_before_shop_loop */
add_action( 'woocommerce_before_shop_loop',       'jayla_sorting_wrapper',               9 );
add_action( 'woocommerce_before_shop_loop',       'jayla_woo_filter_button_toggle_offcanvas', 10 );
add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',            12 );
add_action( 'woocommerce_before_shop_loop',       'jayla_woo_archive_header_tool_open',  15 );
add_action( 'woocommerce_before_shop_loop',       'jayla_woo_filter_select',             16 );

add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',        18 );
add_action( 'woocommerce_before_shop_loop',       'jayla_woo_archive_header_tool_close', 25 );
add_action( 'woocommerce_before_shop_loop',       'jayla_sorting_wrapper_close',         30 );
add_action( 'woocommerce_before_shop_loop',       'jayla_woo_archive_filter_tool',       31 );
add_action( 'woocommerce_before_shop_loop',       'jayla_woo_archive_layered_nav_filters',       32 );
add_action( 'woocommerce_before_shop_loop',       'jayla_product_columns_wrapper',       40 );

add_action( 'jayla_woo_archive_filter_tool_action', 'jayla_woo_load_sidebar_filter_tool_archive_shop', 20 );

add_action( 'woocommerce_after_shop_loop',              'jayla_paging_nav',                    20 );

add_action( 'woocommerce_after_shop_loop_item',         'jayla_woo_open_product_list_item_wrap_entry',     7 );
add_action( 'woocommerce_after_shop_loop_item',         'woocommerce_template_loop_product_link_open',               7 );
add_action( 'woocommerce_after_shop_loop_item',         'woocommerce_template_loop_product_title',        7 );
add_action( 'woocommerce_after_shop_loop_item',         'woocommerce_template_loop_product_link_close',               7 );

add_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_rating',                      9 );
add_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_price',                       8 );
add_action( 'woocommerce_after_shop_loop_item',        'jayla_woo_tinvwl',                                15 );
add_action( 'woocommerce_after_shop_loop_item',        'jayla_woo_close_product_list_item_wrap_entry',    20 );

add_filter( 'woocommerce_before_shop_loop_item_title',     'jayla_woo_show_product_loop_sale_flash',    10 );
add_filter( 'woocommerce_before_shop_loop_item_title',     'jayla_woo_show_product_loop_outstock',    10 );
add_filter( 'woocommerce_before_shop_loop_item_title',     'jayla_woo_show_product_loop_featured',    10 );
add_filter( 'woocommerce_before_shop_loop_item_title',     'jayla_woo_thumbnail_secondary', 11 );

add_filter( 'loop_shop_columns',                        'jayla_loop_columns' );
add_filter( 'loop_shop_per_page',                       'jayla_loop_shop_per_page', 20 );
add_filter ( 'woocommerce_product_thumbnails_columns',  'jayla_change_gallery_columns' );

add_filter('jayla_custom_metabox_variable_product_data', 'fintotheme_custom_metabox_customize_data', 10, 2);

/* product detain */
add_action('woocommerce_before_single_product_summary', 'jayla_woo_product_detail_wrap_open', 4);
add_action('woocommerce_after_single_product_summary', 'jayla_woo_product_detail_wrap_close', 30);

add_action('woocommerce_before_single_product_summary', 'jayla_woo_product_detail_summary_wrap_open', 5);
add_action('woocommerce_after_single_product_summary', 'jayla_woo_product_detail_summary_wrap_close', 5);

add_action('jayla_woo_product_before_summary_container', 'jayla_woo_product_before_summary_open_container', 5);
add_action('jayla_woo_product_before_summary_container', 'jayla_woo_product_before_summary_close_container', 30);

add_action('jayla_woo_product_before_summary_container', 'wc_print_notices',            8);
add_action('jayla_woo_product_before_summary_container', 'woocommerce_breadcrumb',      10);
add_action('jayla_woo_product_before_summary_container', 'jayla_woo_product_nav', 15);

add_filter( 'woocommerce_breadcrumb_defaults', 'jayla_woo_breadcrumbs' );

add_action('woocommerce_after_single_product_summary', 'jayla_woo_after_single_product_summary_wrap_open', 5);
add_action('woocommerce_after_single_product_summary', 'jayla_woo_after_single_product_summary_wrap_close', 30);

add_filter('woocommerce_product_tabs',                'jayla_woo_product_tabs');
add_filter('woocommerce_product_reviews_tab_title',   'jayla_woo_product_reviews_title_tabs');

add_action('jayla_woo_custom_attr_wc_tabs',     'jayla_woo_attr_designer_wc_tabs', 10);

add_filter('woocommerce_cross_sells_total', 'jayla_woo_cross_sells_total');

remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);
add_action('jayla_woo_cart_pos_right', 'woocommerce_cart_totals', 10);
add_action('jayla_woo_cart_pos_right', 'jayla_woo_return_shopping', 15);

add_action('jayla_woo_custom_attr_cart_form_wrap', 'jayla_woo_designer_cart_form_attr', 10);
add_action('jayla_woo_custom_attr_cart_sidebar', 'jayla_woo_designer_cart_sidebar_attr', 10);

add_action('jayla_woo_custom_attr_customer_details', 'jayla_woo_designer_checkout_customer_details', 10);
add_action('jayla_woo_custom_attr_order_review', 'jayla_woo_designer_checkout_order_review', 10);

add_filter('jayla_search_form_loop_result_item_html', 'jayla_woo_search_form_loop_result_item_html', 10);

add_filter('jayla_header_widget', 'jayla_woo_header_widget', 20);
add_filter('jayla_header_widget_options', 'jayla_woo_header_widget_options', 20);

add_filter( 'woocommerce_add_to_cart_fragments', 'jayla_woo_cart_link_fragment' );
add_filter( 'woocommerce_add_to_cart_fragments', 'jayla_woo_widget_minicart_custom_fragment' );
add_filter( 'woocommerce_add_to_cart_fragments', 'jayla_woo_widget_wishlist_products_counter_custom_fragment' );
add_filter( 'wp_footer', 'jayla_woo_shopping_mini_cart' );

add_action( 'jayla_widget_mini_cart_entry', 'jayla_widget_mini_cart_template', 20);

/**
 * Cart widget
 */
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

add_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 10 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 20 );

add_filter( 'jayla_taxonomies_by_post_type_product', 'jayla_woo_list_taxonomies_by_product' );
add_filter( 'jayla_taxonomy_list_filter', 'jayla_woo_add_shoppage_for_taxonomy' );
add_filter( 'jayla_taxonomy_name_filter', 'jayla_woo_taxonomy_name_is_shoppage' );

/**
 * Shop page heading title
 */
add_filter( 'jayla_heading_title_filter', 'jayla_woo_heading_title_shop_page', 20 );

add_filter( 'woocommerce_related_products', 'jayla_woo_related_products', 20, 3 );
add_filter( 'woocommerce_output_related_products_args', 'jayla_woo_related_products_args' );

/**
 * Add scrollreveal
 */
add_filter( 'jayla_custom_script_inline', 'jayla_woo_add_script_scrollreveal' );

add_filter( 'jayla_get_post_id', 'jayla_woo_shop_page_id' );
add_filter( 'jayla_sidebar_is_archive_page_filter', 'jayla_woo_sidebar_archive_page_false' );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 6 );
add_action( 'woocommerce_single_product_summary', 'jayla_woo_breakline_sale_flash', 6 );

add_action( 'woocommerce_single_product_summary', 'jayla_woo_single_product_summary_wrap_open', 4 );
add_action( 'woocommerce_single_product_summary', 'jayla_woo_single_product_summary_wrap_close', 70 );

add_filter( 'body_class', 'jayla_woo_single_product_add_custom_layout_classes' );
add_filter( 'body_class', 'jayla_woo_shop_add_custom_layout_classes' );

add_action( 'wp_head', 'jayla_woo_single_product_custom_hook_by_layout' );

add_filter( 'jayla_custom_metabox_variable_product_data', 'jayla_woo_metabox_product_default_data', 20, 2 );

add_filter( 'jayla_term_meta_background_fields_support_category', 'jayla_woo_term_meta_background_fields_support_category_product_cat' );

add_filter( 'jayla_woo_product_main_gallery_items_before', 'jayla_woo_product_main_gallery_button_trigger_open_fullscreen' );
add_filter( 'jayla_woo_product_main_gallery_items_before', 'jayla_woo_product_button_trigger_open_video' );
add_filter( 'jayla_woo_product_main_gallery_one_col_before', 'jayla_woo_product_button_trigger_open_video' );

add_action( 'carbon_fields_register_fields', 'jayla_woo_product_meta_field_video' );

add_filter( 'jayla_register_wp_widgets_filter', 'jayla_woo_widgets_include' );
add_filter( 'comment_form_fields', 'jayla_woo_move_comment_and_rating_field_to_top' );
add_filter( 'jayla_woo_product_detail_summary_wrap_open_classes_inner_filter', 'jayla_woo_single_product_gallery_custom_layout' );

add_filter( 'bevc_Products_Listing_templates', 'jayla_bevc_Products_Listing_templates_layout_default', 20, 2 );

add_action( 'wp_footer', 'jayla_woo_shopping_content_cart_offcanvas' );

add_filter( 'jayla_item_search_result_template_filter', 'jayla_item_search_result_product_template' );

add_filter( 'jayla_register_wp_widgets_filter', 'jayla_ti_woocommerce_wishlist_counter_widget', 30 );

$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
$shop_layout = $woo_settings['shop_layout'];
if( $shop_layout == 'icons-hover-horizontal' || $shop_layout == 'icons-hover' ){
  remove_action( 'woocommerce_after_shop_loop_item', 'jayla_woo_tinvwl', 15 );
  add_action( 'jayla_woo_after_loop_thumbnail_link', 'jayla_woo_tinvwl', 25 );
}

add_filter( 'jayla_content_end_class' , 'jayla_woo_custom_main_columns_on_page_cart_checkout' );
add_filter( 'jayla_show_sidebar_filter' , 'jayla_woo_remove_sidebar_on_page_cart_checkout' );

add_filter( 'jayla_sidebar_args', 'jayla_woo_register_shop_sidebar' );
add_filter( 'woocommerce_layered_nav_count', 'jayla_woo_custom_layered_nav_count', 20, 3 );

add_action( 'carbon_fields_register_fields', 'jayla_woo_add_custom_meta_field_icon_for_product_cat', 0 );

add_filter( 'jayla_list_product_cats', 'jayla_woo_add_icon_nav_cat', 20, 3 );
add_filter( 'jayla_control_sidebar_class_filter', 'jayla_woo_custom_sidebar_class_shop_archive_page' );

add_filter( 'post_class', 'jayla_woo_post_class_custom', 20, 3 );
add_filter( 'product_cat_class', 'jayla_woo_post_class_custom', 20, 3 );
// 'related', 'up-sells', 'cross-sells'
add_filter( 'jayla_woo_post_class_custom_in_loop', 'jayla_woo_post_class_custom_in_loop_related_upsells', 20, 2 );
add_filter( 'jayla_woo_post_class_custom_in_loop', 'jayla_woo_post_class_custom_in_loop_crosssells', 22, 2 );
add_filter( 'jayla_paging_nav_html', 'jayla_woo_shop_archive_loadmore_ajax_infinite_scroll' );
add_filter( 'woocommerce_subcategory_count_html', 'jayla_woo_custom_subcategory_count_html', 20, 2 );
add_filter( 'jayla_woo_custom_classes_loop_start', 'jayla_woo_custom_classes_shop_archive_loop_start', 20 );

add_action( 'jayla_woo_product_tabs', 'jayla_woo_product_tabs_default', 20 );

add_action( 'jayla_content_top', 'jayla_woo_sticky_product_bar_html', 30 );