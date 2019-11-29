<?php 
include_once get_template_directory() . '/inc/data-core/widgets/widget-base-element.php';

$params = Jayla_Widget_Base_Element(array(
    'groups' => array(
        'General' => array(
            'title' => __('General', 'jayla'),
            'name' => 'general',
            'fields' => array(
                'content_width' => array(
                    'label' => __('Content Width', 'jayla'),
                    'description' => __('Select content width boxed / full-width', 'jayla'),
                    'type' => 'select',
                    'value' => '',
                    'options' => array(
                        array( 'value' => 'fluid', 'label' => 'Container Fluid' ),
                        array( 'value' => 'large', 'label' => 'Container Large' ),
                        array( 'value' => 'medium', 'label' => 'Container Medium' ),
                    )
                ),
                'align' => array(
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
                ),
                'separator_1' => array(
                    'type' => 'separator',
                ),
                'widget_inline' => array(
                    'label' => __('Widget Inner Inline', 'jayla'),
                    'description' => __('On/Off inline widget(s) element on columns.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                ),
                'widget_vertical_align' => array(
                    'label' => __('Widget Vertical Align', 'jayla'),
                    'description' => __('Select widget vertical align', 'jayla'),
                    'type' => 'radio-group',
                    'value' => '',
                    'options' => array(
                        array( 'label' => '', 'text' => __('Default', 'jayla') ),
                        array( 'label' => 'theme-extends-widget-inner-vertical-align-top', 'text' => __('Top', 'jayla') ),
                        array( 'label' => 'theme-extends-widget-inner-vertical-align-middle', 'text' => __('Middle', 'jayla') ),
                        array( 'label' => 'theme-extends-widget-inner-vertical-align-bottom', 'text' => __('Bottom', 'jayla') ),
                    ),
                    'condition' => array(
                        'widget_inline' => 'on',
                    ),
                ),
                'separator_2' => array(
                    'type' => 'separator',
                ),
                'id' => array(
                    'label' => __('ID', 'jayla'),
                    'description' => __('Enter ID for element.', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => '',
                ),
                'extra_class' => array(
                    'label' => __('Extra Class', 'jayla'),
                    'description' => __('Enter custom class for element.', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => '',
                ),
            ),
        ),
    )
), array( 'Style', 'Responsive' ));

return $params;