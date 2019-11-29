<?php 
include_once get_template_directory() . '/inc/data-core/widgets/widget-base-element.php';

$params = Jayla_Widget_Base_Element(array(
    'groups' => array(
        /* Group General */
        array(
            'title' => __('General', 'jayla'),
            'name' => 'general',
            'fields' => array(
                'search_form_position' => array(
                    'label' => __('Search Form Position', 'jayla'),
                    'description' => __('Select position(left/right) form display (default: Left)', 'jayla'),
                    'type' => 'select',
                    'value' => 'left',
                    'options' => array(
                        array( 'value' => 'left', 'label' => __('Show on the left', 'jayla') ),
                        array( 'value' => 'right', 'label' => __('Show on the right', 'jayla') ),
                    )
                ),
                'search_on_type' => array(
                    'label' => __('Search On Type', 'jayla'),
                    'description' => __('On/off ajax search on your text (default: Disable)', 'jayla'),
                    'type' => 'select',
                    'value' => 'no',
                    'options' => array(
                        array( 'value' => 'no', 'label' => __('Disable', 'jayla') ),
                        array( 'value' => 'yes', 'label' => __('Enable', 'jayla') ),
                    )
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