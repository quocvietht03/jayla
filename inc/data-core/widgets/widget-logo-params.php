<?php 
include_once get_template_directory() . '/inc/data-core/widgets/widget-base-element.php';

$params = Jayla_Widget_Base_Element(array(
    'groups' => array(
        /* Group General */
        array(
            'title' => __('General', 'jayla'),
            'name' => 'general',
            'fields' => array(
                'custom_logo' => array(
                    'label' => __('Custom Logo', 'jayla'),
                    'description' => __('Enable custom logo.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'no',
                    'placeholder' => 'on/off custom logo.',
                ),
                'branding_url' => array(
                    'label' => false, //__('Branding Image', 'jayla'),
                    'description' => __('Select branding image.', 'jayla'),
                    'type' => 'wp-media',
                    'condition' => array(
                        'custom_logo' => 'on',
                    ),
                ),
                'element_inline' => array(
                    'label' => __('Inline', 'jayla'),
                    'description' => __('element inline.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'no',
                    'placeholder' => 'on/off element inline.',
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
    ),
), array( 'Style' ));

return $params;