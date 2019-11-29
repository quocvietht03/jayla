<?php 
include_once get_template_directory() . '/inc/data-core/widgets/widget-base-element.php';

$params = Jayla_Widget_Base_Element(array(
    'groups' => array(
        /* Group General */
        array(
            'title' => __('General', 'jayla'),
            'name' => 'general',
            'fields' => array(
                'facebook' => array(
                    'label' => __('Facebook', 'jayla'),
                    'description' => __('Enable Facebook.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'on',
                    'placeholder' => 'on/off icon Facebook.',
                ),
                'facebook_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Facebook page url.',
                    'value' => 'https://www.facebook.com/',
                    'condition' => array(
                    'facebook' => 'on',
                    ),
                ),
                'google' => array(
                    'label' => __('Google', 'jayla'),
                    'description' => __('Enable Google.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'on',
                    'placeholder' => 'on/off icon Google.',
                ),
                'google_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Google page url.',
                    'value' => 'https://plus.google.com/',
                    'condition' => array(
                    'google' => 'on',
                    ),
                ),
                'twitter' => array(
                    'label' => __('Twitter', 'jayla'),
                    'description' => __('Enable Twitter.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'on',
                    'placeholder' => 'on/off icon Twitter.',
                ),
                'twitter_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Twitter page url.',
                    'value' => 'https://twitter.com/',
                    'condition' => array(
                    'twitter' => 'on',
                    ),
                ),
                'instagram' => array(
                    'label' => __('Instagram', 'jayla'),
                    'description' => __('Enable Instagram.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                    'placeholder' => 'on/off icon Instagram.',
                ),
                'instagram_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Instagram page url.',
                    // 'value' => 'https://www.instagram.com/',
                    'condition' => array(
                    'instagram' => 'on',
                    ),
                ),
                'pinterest' => array(
                    'label' => __('Pinterest', 'jayla'),
                    'description' => __('Enable Pinterest.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                    'placeholder' => 'on/off icon Pinterest.',
                ),
                'pinterest_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Pinterest page url.',
                    'condition' => array(
                    'pinterest' => 'on',
                    ),
                ),
                'youtube' => array(
                    'label' => __('Youtube', 'jayla'),
                    'description' => __('Enable Youtube.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                    'placeholder' => 'on/off icon Youtube.',
                ),
                'youtube_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Youtube page url.',
                    'condition' => array(
                    'youtube' => 'on',
                    ),
                ),
                'vimeo' => array(
                    'label' => __('Vimeo', 'jayla'),
                    'description' => __('Enable Vimeo.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                    'placeholder' => 'on/off icon Vimeo.',
                ),
                'vimeo_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Vimeo page url.',
                    'condition' => array(
                    'vimeo' => 'on',
                    ),
                ),
                'dribbble' => array(
                    'label' => __('Dribbble', 'jayla'),
                    'description' => __('Enable Dribbble.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                    'placeholder' => 'on/off icon Dribbble.',
                ),
                'dribbble_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Dribbble page url.',
                    'condition' => array(
                    'dribbble' => 'on',
                    ),
                ),
                'behance' => array(
                    'label' => __('Behance', 'jayla'),
                    'description' => __('Enable Behance.', 'jayla'),
                    'type' => 'switch',
                    'value' => 'off',
                    'placeholder' => 'on/off icon Behance.',
                ),
                'behance_url' => array(
                    'label' => false,
                    'type' => 'input',
                    'placeholder' => 'Enter Behance page url.',
                    'condition' => array(
                    'behance' => 'on',
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
    ),
), array( 'Style' ));

return $params;