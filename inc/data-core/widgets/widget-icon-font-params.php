<?php 
include_once get_template_directory() . '/inc/data-core/widgets/widget-base-element.php';

$params = Jayla_Widget_Base_Element(array(
    'groups' => array(
        /* Group General */
        array(
            'title' => __('General', 'jayla'),
            'name' => 'general',
            'fields' => array(
                'icon_class' => array(
                    'label' => __('Icon Class', 'jayla'),
                    'description' => __('Enter icon class (Ionicons, Fontawesome, Dashion).', 'jayla'),
                    'type' => 'input',
                    'value' => 'ion-ios-heart',
                    'placeholder' => 'Ex: ion-ios-heart',
                ),
                'tooltip' => array(
                    'label' => __('Tooltip', 'jayla'),
                    'description' => __('Enter tooltip text.', 'jayla'),
                    'type' => 'input',
                    'value' => '',
                    'placeholder' => '',
                ),
                'direct_link' => array(
                    'label' => __('Direct Link', 'jayla'),
                    'description' => __('Enter direct link.', 'jayla'),
                    'type' => 'input',
                    'value' => '#',
                    'placeholder' => 'direct link',
                ),
                'target_blank' => array(
                    'label' => __('Open on New Window', 'jayla'),
                    'description' => __('On/Off open direct link on new window.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'no',
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