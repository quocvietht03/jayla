<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Product Wishlist
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_Wishlist_Products_Counter extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_wishlist_products_counter',
            __('Theme Widget - Wishlist Products Counter', 'jayla'),
            __('Displays the number of products in the wishlist on your site.', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )
                    ->set_default_value( __('Wishlist', 'jayla') ),
                Field::make( 'select', 'layout', __( 'Layout', 'jayla' ) )
                    ->add_options( apply_filters( 'jayla_widget_wishlist_products_counter_layout_filter', array(
                        'default' => __('Default', 'jayla')
                    ) ) )
                    ->set_default_value( 'default' ),
                Field::make( 'text', 'class_custom_design', __('Classes custom design', 'jayla') )
                    ->set_default_value( '' ),
        ) );
    }

    public function _render_layout_default($instance) {
        ob_start();
        $classes = array( 'theme-widget-custom-wishlist-products-counter' );
        $page_wishlist_id = tinv_get_option( 'page', 'wishlist' );
        $page_wishlist_link = '#';

        if( ! empty( $page_wishlist_id ) ) {
            $page_wishlist_link = get_permalink( $page_wishlist_id );
        }
		?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <a href="<?php echo esc_url( $page_wishlist_link ); ?>">
                <div class="icon-entry" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr('My Wishlist', 'jayla'); ?>">
                    <div class="_icon-wishlist">
                        <?php echo jayla_wishlist_icon_svg( 'default' ); ?>
                    </div>
                    <span class="theme_extends_wishlist_products_counter_number __empty" data-design-name="<?php _e( 'Wishlist counter', 'jayla' ); ?>" data-design-selector="#page .theme-extends-widget-wishlist-products-counter .theme_extends_wishlist_products_counter_number">0</span>
                </div>
            </a>
        </div>
		<?php
        return ob_get_clean();
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';
        $classes = implode( ' ', array(
            'theme-extends-widget-wishlist-products-counter',
            $instance['class_custom_design'],
            '_layout-' . $instance['layout'],
        ) );

        $custom_design_name_attr = '';
        $custom_design_selector_attr = '';
        if(! empty($instance['class_custom_design'])) {
            $_root_classes = '#page .theme-extends-widget-wishlist-products-counter.' . $instance['class_custom_design'];
            $custom_design_selector = array(
                array(
                    'name' => __('Widget wishlist counter wrap', 'jayla'),
                    'selector' => $_root_classes
                ),
                // array(
                //     'name' => __('Widget wishlist counter content', 'jayla'),
                //     'selector' => $_root_classes . ' .icon-entry',
                // )
            );

            if( in_array( $instance['layout'], array( 'default' ) ) ) {
                array_push( $custom_design_selector, array(
                    'name' => __( 'SVG Icon Wishlist', 'jayla' ),
                    'selector' => $_root_classes . ' .icon-entry svg',
                ) );
            }

            $custom_design_name_attr = 'data-design-name="'. __('Widget wishlist counter', 'jayla') .'"';
            $custom_design_selector_attr = 'data-design-selector=\''. wp_json_encode( $custom_design_selector ) .'\'';
        }

        $layouts = apply_filters( 'jayla_widget_custom_wishlist_products_counter_filter', array(
            'default' => $this->_render_layout_default( $instance ),
        ), $instance );

        $content = $layouts[$instance['layout']];
        ?>
        <div
            class="<?php echo esc_attr( $classes ); ?>"
            <?php echo "{$custom_design_name_attr}" ?>
            <?php echo "{$custom_design_selector_attr}" ?>>
            <div class="__inner">
                <?php
                    echo "{$content}";
                ?>
            </div>
        </div>
        <?php
    }
}
