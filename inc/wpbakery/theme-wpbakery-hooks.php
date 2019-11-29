<?php
/**
 * WPBakery Hooks 
 */

{
    /**
     * Bears Visual Composer Element Hooks 
     */
    add_action( 'bevc_element_custom_attr', 'jayla_bevc_element_custom_attr', 20, 2 );
    add_action( 'bevc_element_custom_attr_filter_nav', 'jayla_bevc_element_filter_nav_custom_attr', 20, 2 );

    /**
     * Add custom attr design seletor for bevc element 
     * hooks name: jayla_bevc_element_{element_name}_attr
     * 
     */
    add_filter( 'jayla_bevc_element_bevc_feature_boxes_attr', 'jayla_bevc_element_bevc_feature_boxes_attr_designer', 20, 3 );
    add_filter( 'jayla_bevc_element_bevc_testimonial_slide2_attr', 'jayla_bevc_element_bevc_testimonial_slide2_attr_designer', 20, 3 );
    add_filter( 'jayla_bevc_element_bevc_testimonial_slide_attr', 'jayla_bevc_element_bevc_testimonial_slide_attr_designer', 20, 3 );
    add_filter( 'jayla_bevc_element_bevc_image_box_grid_item_attr', 'jayla_bevc_element_bevc_image_box_grid_item_attr_designer', 20, 3 );

    add_filter( 'jayla_bevc_element_filter_nav_bevc_products_carousel_filter_attr', 'jayla_bevc_element_filter_nav_bevc_products_carousel_filter_attr_designer', 20, 3 );
    add_action( 'bevc_element_block_slide_items__thumbnail_after', 'jayla_bevc_element_block_slide_items__add_layout_image_large', 10, 2 );

    /**
     * Fix issue (empty image after 10h) with fastest cache 
     * 
     */
    add_filter('vc_grid_get_grid_data_access','__return_true');
}