<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Product search
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_Product_Categories_Width_Icon extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_product_category_with_icon',
            __('Theme Widget - Product Category width Icon', 'jayla'),
            __('Displays product category width icon', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )
                    ->set_default_value( __('Product categories', 'jayla') ),
                Field::make( 'select', 'layout', __( 'Layout', 'jayla' ) )
                    ->add_options( array(
                        'default' => __( 'Default', 'jayla' ),
                    ) )
                    ->set_default_value( 'default' ),
                Field::make( 'image', 'icon_image_placeholder', __( 'Icon image placeholder', 'jayla' ) )
                    ->set_default_value( get_template_directory_uri() . '/assets/images/svg-icons/folder-2.svg' )
                    ->set_value_type( 'url' ),
                Field::make( 'checkbox', 'hide_empty_cat', __( 'Hide empty categories', 'jayla' ) ),
                Field::make( 'checkbox', 'hide_icon_children_item', __( 'Hide icon children item', 'jayla' ) ),
                Field::make( 'text', 'custom_class', __('Custom classes', 'jayla') )
                    ->set_default_value( '' ),
        ) );
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';
        
        include_once  get_template_directory() . '/inc/class/class-custom-product-cat-list-walker.php';

        $list_args          = array(
            'walker' => new Jayla_Custom_Product_Cat_List_Walker(),
            'title_li' => '',
            'pad_counts' => 1,
            'show_option_none' => __( 'No product categories exist.', 'jayla' ),
            'current_category' => '',
            'current_category_ancestors' => '',
			'show_count'   => true,
			// 'hierarchical' => fase,
			'taxonomy'     => 'product_cat',
            'hide_empty'   => $instance['hide_empty_cat'], // $hide_empty,
            'order' => 'asc',
            'orderby' => 'title',

            'icon_before_name' => true,
            'icon_image_placeholder' => $instance['icon_image_placeholder'],
            'toggle_ui' => true,
        );
        
        $classes = array(
            'jayla-woo-product-categories-width-icon',
            '__layout-' . $instance['layout'],
            $instance['custom_class'],
            ( true == $list_args['toggle_ui'] ) ? '__cat-toggle-ui' : '',
            ( true == $instance['hide_icon_children_item'] ) ? '__hide-icon-chilren-item' : '',
        );

        echo '<ul class="'. implode( ' ', $classes ) .'">';

        wp_list_categories( apply_filters( 'jayla_woo_product_categories_widget_args', $list_args ) );

        echo '</ul>';
    }
}
