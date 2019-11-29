<?php 
include_once get_template_directory() . '/inc/data-core/widgets/widget-base-element.php';

$params = Jayla_Widget_Base_Element(array(
    'groups' => array(
        /* Group General */
        array(
            'title' => __('General', 'jayla'),
            'name' => 'general',
            'fields' => array(
                'custom_menu' => array(
                    'label' => __('Custom Menu', 'jayla'),
                    'description' => __('On/Off custom menu', 'jayla'),
                    'type' => 'switch',
                    'value' => 'no',
                ),
                'menu' => array(
                    'label' => __('Menu', 'jayla'),
                    'description' => __('Select menu.', 'jayla'),
                    'type' => 'select',
                    'condition' => array(
                        'custom_menu' => 'on',
                    ),
                    'options' => jayla_get_wordpress_menus(),
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
        )
    ),
), array( 'Style' ));

return $params;