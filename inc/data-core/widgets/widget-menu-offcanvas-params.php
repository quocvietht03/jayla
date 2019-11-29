<?php 
include_once get_template_directory() . '/inc/data-core/widgets/widget-base-element.php';

$params = Jayla_Widget_Base_Element(array(
    'groups' => array(
        /* Group General */
        array(
            'title' => __('General', 'jayla'),
            'name' => 'general',
            'fields' => array(
                'menu' => array(
                    'label' => __('Menu', 'jayla'),
                    'description' => __('Select menu.', 'jayla'),
                    'type' => 'select',
                    'value' => '',
                    'options' => jayla_get_wordpress_menus(array(
                        array(
                            'value' => '',
                            'label' => __('No Menu', 'jayla'),
                        )
                    )),
                ),
                'style' => array(
                    'label' => __('Style', 'jayla'),
                    'description' => __('Select style offcanvs menu', 'jayla'),
                    'type' => 'select',
                    'value' => 'fullwidth-fadein-center',
                    'options' => array(
                        array( 'value' => 'slide-from-right-to-left', 'label' => 'Slide from Right to Left' ),
                        array( 'value' => 'slide-from-left-to-right', 'label' => 'Slide from Left to Right' ),
                        array( 'value' => 'fullwidth-fadein-center', 'label' => 'Full Width FadeIn Center' ),
                    )
                ),
                'separator_0' => array(
                    'type' => 'separator',
                ),
                'sidebar_before_nav' => array(
                    'label' => __('Sidebar Before Nav', 'jayla'),
                    'description' => __('Select sidebar before nav', 'jayla'),
                    'type' => 'select',
                    'value' => '',
                    'options' => jayla_wp_get_sidebars_widgets_options(array(
                        array(
                            'value' => '',
                            'label' => __('No Sidebar', 'jayla'),
                        )
                    )),
                ),
                'sidebar_after_nav' => array(
                    'label' => __('Sidebar After Nav', 'jayla'),
                    'description' => __('Select sidebar after nav', 'jayla'),
                    'type' => 'select',
                    'value' => '',
                    'options' => jayla_wp_get_sidebars_widgets_options(array(
                        array(
                            'value' => '',
                            'label' => __('No Sidebar', 'jayla'),
                        )
                    )),
                ),
                'separator_1' => array(
                    'type' => 'separator',
                ),
                'element_inline' => array(
                    'label' => __('Inline', 'jayla'),
                    'description' => __('element inline.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'no',
                    'placeholder' => 'on/off element inline.',
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
    ),
), array( 'Style' ));

return $params;