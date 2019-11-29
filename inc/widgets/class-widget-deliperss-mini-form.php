<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * Delipress custom form
 *
 * @author   Bearsthemes
 * @category Widgets
 * @version  1.0.0
 * @extends  Jayla_Widget_Abstract
 */
class Jayla_Widget_Delipress_Custom_Mini_Form extends Jayla_Widget_Abstract {

	// Register widget function. Must have the same name as the class
    function __construct() {
        $this->setup(
            'theme_widget_delipress_custom_mini_form',
            __('Theme Widget - Delipress Custom Mini Form', 'jayla'),
            __('Displays Delipress Mini Form - Short descriptions & E-mail field', 'jayla'),
            array(
                Field::make( 'text', 'title', __('Title', 'jayla') )
                    ->set_default_value( __('Newsletter sign-up', 'jayla') ),
                Field::make( 'select', 'dp_list_id', __('Delipress List', 'jayla') )
                    ->set_required(true)
                    ->add_options( jayla_get_delipress_list_opts( array( '' => __('- Select delipress list -', 'jayla') ) ) ),
                Field::make( 'rich_text', 'form_des_text', __('Form Descriptions Text', 'jayla') )
                    ->set_default_value( __('Amazing deals, updates & freebies in your inbox', 'jayla') ),
                Field::make( 'textarea', 'form_success_message', __('Success Message', 'jayla') )
                    ->set_rows( 4 )
                    ->set_default_value( __('You Have Successfully Subscribed to the Newsletter', 'jayla') ),
                Field::make( 'textarea', 'form_error_message', __('Error Message', 'jayla') )
                    ->set_rows( 4 )
                    ->set_default_value( __('Unsuccessful, please try again another time!', 'jayla') ),
                Field::make( 'text', 'class_custom_design', __('Classes custom design', 'jayla') )
                    ->set_default_value(''),
        ) );
    }

    /**
     * @since 1.0.0 
     */
    public function _template($temp = 'mini') {
        $template = array(
            'mini' => implode('', array(
                '<div class="delipress-custom-form">',
                    '<div class="delipress-entry">',
                        '<div class="dp-des">{{descriptions}}</div>',
                        '<form class="dp-custom-form" method="POST" data-theme-extends-delipress-custom-form>',
                            '<label class="email-field"><input type="email" name="dp_email" placeholder="'. esc_attr__('Your email', 'jayla') .'" required /></label>',
                            '<input type="hidden" name="dp_list_id" value="{{dp_list_id}}">',
                            '<button type="submit" class="btn-submit"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>',
                        '</form>',
                        '<div class="delipress-message-success">',
                            '<div class="message-entry">
                                <span class="__message-icon"><i class="fa fa-check" aria-hidden="true"></i></span>
                                <span class="__message-text">{{message_subscribed_success}}</span>
                            </div>',
                        '</div>',
                        '<div class="delipress-message-error">',
                            '<div class="message-entry">
                                <span class="__message-icon"><i class="fa fa-frown-o" aria-hidden="true"></i></span>
                                <span class="__message-text">{{message_subscribed_error}}</span>
                            </div>',
                        '</div>',
                    '</div>',
                '</div>',
            ))
        );

        return $template[$temp];
    }

    // Called when rendering the widget in the front-end
    function front_end( $args, $instance ) {
        echo ! empty($instance['title']) ? implode('', array($args['before_title'], $instance['title'], $args['after_title'])) : '';

        $layout = 'mini';
        $replace_variables = array(
            '{{descriptions}}' => $instance['form_des_text'],
            '{{message_subscribed_success}}' => $instance['form_success_message'],
            '{{dp_list_id}}' => $instance['dp_list_id'],
            '{{message_subscribed_error}}' => $instance['form_error_message'],
        );

        $custom_design_name_attr = '';
        $custom_design_selector_attr = '';
        if(! empty($instance['class_custom_design'])) {
            $_root_classes = '#page .theme-extends-widget-delipress-custom-form.' . $instance['class_custom_design'];
            $custom_design_selector = wp_json_encode( array(
                array(
                    'name' => __('Delipress custom form wrap', 'jayla'),
                    'selector' => $_root_classes . ' .__inner',
                ),
                array(
                    'name' => __('Delipress custom form - Descriptions', 'jayla'),
                    'selector' => $_root_classes . ' .__inner .delipress-entry .dp-des',
                ),
                array(
                    'name' => __('Delipress custom form - Button submit', 'jayla'),
                    'selector' => $_root_classes . ' .__inner .delipress-entry .btn-submit',
                ),
                array(
                    'name' => __('Delipress custom form - Button submit (:hover)', 'jayla'),
                    'selector' => $_root_classes . ' .__inner .delipress-entry .btn-submit:hover',
                ),
            ) );

            $custom_design_name_attr = 'data-design-name="'. __('Delipress Custom Form', 'jayla') .'"';
            $custom_design_selector_attr = 'data-design-selector=\''. $custom_design_selector .'\'';
        }
        ?>
        <div 
            class="theme-extends-widget-delipress-custom-form <?php echo esc_attr($instance['class_custom_design']); ?> _layout-<?php echo esc_attr($layout); ?>"
            <?php echo apply_filters( 'jayla_widget_delipress_custom_mini_form_design_name_attr', $custom_design_name_attr ); ?> 
            <?php echo apply_filters( 'jayla_widget_delipress_custom_mini_form_design_selector_attr', $custom_design_selector_attr ); ?>>
            <div class="__inner">
                <?php echo str_replace( array_keys($replace_variables), array_values($replace_variables), $this->_template( $layout ) ); ?>
            </div>
        </div>
        <?php
    }
}
