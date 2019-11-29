<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Button
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_Button extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_button',
            __('Theme Widget - Button', 'jayla'),
            __('Displays Button', 'jayla'),
            array(
                Field::make( 'text', 'label', __('Label', 'jayla') )
                    ->set_default_value( __('Read more', 'jayla') ),
                Field::make( 'text', 'link', __('Label', 'jayla') )
                    ->set_default_value( __('#', 'jayla') ),
                Field::make( 'select', 'layout', __( 'Layout', 'jayla' ) )
                    ->add_options( apply_filters( 'jayla_widget_button_layout_filter', array(
                        'default' => __('Default', 'jayla'),
                        'icon-left' => __('Icon Left', 'jayla'),
                        'icon-right' => __('Icon Right', 'jayla'),
                    ) ) )
                    ->set_default_value( 'default' ),
                Field::make( 'text', 'icon', __('Icon class', 'jayla') )
                    ->set_default_value( __('fa fa-arrow-right', 'jayla') )
                    ->set_conditional_logic( array(
                        'relation' => 'OR',
                        array(
                            'field' => 'layout',
                            'value' => 'icon-right'
                        ),
                        array(
                            'field' => 'layout',
                            'value' => 'icon-left'
                        ),
                    ) ),
                Field::make( 'text', 'class_custom_design', __('Classes custom design', 'jayla') )
                    ->set_default_value( '' ),
        ) );
    }

    public function _render_layout_default($instance) {
        ob_start(); ?>
        <a class="bt-btn" href="<?php echo esc_url($instance['link']) ?>"><?php echo "{$instance['label']}"; ?></a>
        <?php
        return ob_get_clean();
    }

    public function _render_layout_icon_left($instance) {
        ob_start(); ?>
        <a class="bt-btn" href="<?php echo esc_url($instance['link']) ?>"><i class="<?php echo esc_attr($instance['icon']) ?>"></i> <?php echo "{$instance['label']}"; ?></a>
        <?php
        return ob_get_clean();
    }

    public function _render_layout_icon_right($instance) {
        ob_start(); ?>
        <a class="bt-btn" href="<?php echo esc_url($instance['link']) ?>"><?php echo "{$instance['label']}"; ?> <i class="<?php echo esc_attr($instance['icon']) ?>"></i></a>
        <?php
        return ob_get_clean();
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';
        $classes = implode( ' ', array(
            'theme-extends-widget-button',
            $instance['class_custom_design'],
            '_layout-' . $instance['layout'],
        ) );

        $custom_design_name_attr = '';
        $custom_design_selector_attr = '';
        if(! empty($instance['class_custom_design'])) {
            $_root_classes = '#page .theme-extends-widget-button.' . $instance['class_custom_design'];
            $custom_design_selector = array(
                array(
                    'name' => __('Widget button wrap', 'jayla'),
                    'selector' => $_root_classes
                ),
                array(
                    'name' => __('Button Style', 'jayla'),
                    'selector' => $_root_classes . ' .bt-btn',
                ),
                array(
                    'name' => __('Button Style :hover', 'jayla'),
                    'selector' => $_root_classes . ' .bt-btn:hover',
                )
            );

            if( in_array( $instance['layout'], array( 'icon-left', 'icon-right' ) ) ) {
                array_push( $custom_design_selector, array(
                    'name' => __( 'Icon Button', 'jayla' ),
                    'selector' => $_root_classes . ' i',
                ) );
                array_push( $custom_design_selector, array(
                    'name' => __( 'Icon Button :hover', 'jayla' ),
                    'selector' => $_root_classes . ' .bt-btn:hover i',
                ) );
            }

            $custom_design_name_attr = 'data-design-name="'. __('Widget Button', 'jayla') .'"';
            $custom_design_selector_attr = 'data-design-selector=\''. wp_json_encode( $custom_design_selector ) .'\'';
        }

        $layouts = apply_filters( 'jayla_widget_custom_button_layout_filter', array(
            'default' => $this->_render_layout_default( $instance ),
            'icon-left' => $this->_render_layout_icon_left( $instance ),
            'icon-right' => $this->_render_layout_icon_right( $instance ),
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
