<?php
/**
 * @package Widget Element
 * Widget header & footer builder
 * 
 * @author Bearsthemes
 * @version 1.0.0 
 */

if(! function_exists('Jayla_Widget_Base_Element')) {
    /**
     * @since 1.0.0 
     */
    function Jayla_Widget_Base_Element($params = array(), $support = array('Style')) {
        if( ! empty($support) && count($support) > 0 ) {
            foreach($support as $s) {
                if( function_exists( sprintf('Jayla_Widget_Base_Element__Group_%s', $s) ) )
                    $params['groups'][$s] = call_user_func( sprintf('Jayla_Widget_Base_Element__Group_%s', $s) );
            }
        }
        
        return $params;
    }   
}


if(! function_exists('Jayla_Widget_Base_Element__Group_Style')) {
    /**
     * @since 1.0.0 
     */
    function Jayla_Widget_Base_Element__Group_Style() {
        return array(
            'title' => __('Style', 'jayla'),
            'name' => 'style',
            'fields' => array(
                'padding' => array(
                    'label' => __('Padding', 'jayla'),
                    'description' => __('Add padding for element', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => '0px 0px 0px 0px',
                ),
                'margin' => array(
                    'label' => __('Margin', 'jayla'),
                    'description' => __('Add margin for element', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => '0px 0px 0px 0px',
                ),
            ),
        );
    }
}

if(! function_exists('Jayla_Widget_Base_Element__Group_Responsive')) {
    /**
     * @since 1.0.0 
     */
    function Jayla_Widget_Base_Element__Group_Responsive() {
        return array(
            'title' => __('Responsive', 'jayla'),
            'name' => 'responsive',
            'fields' => array(
                'hidden_on_device' => array(
                    'label' => __('Hidden On Device', 'jayla'),
                    'description' => __('Select for hidden on device.', 'jayla'),
                    'type' => 'checkbox-group',
                    'size' => 'small',
                    'value' => array(),
                    'options' => array(
                        array( 'label' => 'theme-extends-hidden-on-mobile', 'text' => __('Mobile', 'jayla') ),
                        array( 'label' => 'theme-extends-hidden-on-tablet', 'text' => __('Tablet', 'jayla') ),
                        array( 'label' => 'theme-extends-hidden-on-desktop', 'text' => __('Desktop', 'jayla') ),
                        array( 'label' => 'theme-extends-hidden-on-large_screen', 'text' => __('Large Screen', 'jayla') ),
                    ),
                ),
                'separator_1' => array(
                    'type' => 'separator',
                ),
                'medium_device' => array(
                    'label' => __('Medium Device', 'jayla'),
                    'description' => __('On/off responsive on medium device.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                ),
                'medium_device_width' => array(
                    'label' => __('Width', 'jayla'),
                    'description' => __('Enter width on medium device (unit %)', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => 'Ex: 100',
                    'condition' => array(
                        'medium_device' => 'on',
                    ),
                ),
                'medium_device_align' => array(
                    'label' => __('Alignment', 'jayla'),
                    'description' => __('Select alignment', 'jayla'),
                    'type' => 'radio-group',
                    'value' => '',
                    'options' => array(
                        array( 'label' => '', 'text' => __('Default', 'jayla') ),
                        array( 'label' => 'theme-extends-align-left', 'text' => __('Left', 'jayla') ),
                        array( 'label' => 'theme-extends-align-center', 'text' => __('Center', 'jayla') ),
                        array( 'label' => 'theme-extends-align-right', 'text' => __('Right', 'jayla') ),
                    ),
                    'condition' => array(
                        'medium_device' => 'on',
                    ),
                ),

                'separator_2' => array(
                    'type' => 'separator',
                ),

                'small_device' => array(
                    'label' => __('Small Device', 'jayla'),
                    'description' => __('On/off responsive on small device.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                ),
                'small_device_width' => array(
                    'label' => __('Width', 'jayla'),
                    'description' => __('Enter width on small device (unit %)', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => 'Ex: 100',
                    'condition' => array(
                        'small_device' => 'on',
                    ),
                ),
                'small_device_align' => array(
                    'label' => __('Alignment', 'jayla'),
                    'description' => __('Select alignment', 'jayla'),
                    'type' => 'radio-group',
                    'value' => '',
                    'options' => array(
                        array( 'label' => '', 'text' => __('Default', 'jayla') ),
                        array( 'label' => 'theme-extends-align-left', 'text' => __('Left', 'jayla') ),
                        array( 'label' => 'theme-extends-align-center', 'text' => __('Center', 'jayla') ),
                        array( 'label' => 'theme-extends-align-right', 'text' => __('Right', 'jayla') ),
                    ),
                    'condition' => array(
                        'small_device' => 'on',
                    ),
                ),

                'separator_3' => array(
                    'type' => 'separator',
                ),

                'extra_small_device' => array(
                    'label' => __('Extra Small', 'jayla'),
                    'description' => __('On/off responsive on extra small device.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                ),
                'extra_small_device_width' => array(
                    'label' => __('Width', 'jayla'),
                    'description' => __('Enter width on extra small device (unit %)', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => 'Ex: 100',
                    'condition' => array(
                        'extra_small_device' => 'on',
                    ),
                ),
                'extra_small_device_align' => array(
                    'label' => __('Alignment', 'jayla'),
                    'description' => __('Select alignment', 'jayla'),
                    'type' => 'radio-group',
                    'value' => '',
                    'options' => array(
                        array( 'label' => '', 'text' => __('Default', 'jayla') ),
                        array( 'label' => 'theme-extends-align-left', 'text' => __('Left', 'jayla') ),
                        array( 'label' => 'theme-extends-align-center', 'text' => __('Center', 'jayla') ),
                        array( 'label' => 'theme-extends-align-right', 'text' => __('Right', 'jayla') ),
                    ),
                    'condition' => array(
                        'extra_small_device' => 'on',
                    ),
                ),

            ),
        );
    }
}
