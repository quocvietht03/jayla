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
                'full_width' => array(
                    'label' => __('Full Width', 'jayla'),
                    'description' => __('On/Off Row full width no padding.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                    'condition' => array(
                        'content_width' => 'fluid',
                    ),
                ),
                'align' => array(
                    'label' => __('Content Alignment', 'jayla'),
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
                'columns_vertical_align' => array(
                    'label' => __('Columns Vertical Alignment', 'jayla'),
                    'description' => __('Select alignment', 'jayla'),
                    'type' => 'radio-group',
                    'value' => '',
                    'options' => array(
                        array( 'label' => '', 'text' => __('Default', 'jayla') ),
                        array( 'label' => 'theme-extends-col-vertical-align-top', 'text' => __('Top', 'jayla') ),
                        array( 'label' => 'theme-extends-col-vertical-align-middle', 'text' => __('Middle', 'jayla') ),
                        array( 'label' => 'theme-extends-col-vertical-align-bottom', 'text' => __('Bottom', 'jayla') ),
                    ),
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