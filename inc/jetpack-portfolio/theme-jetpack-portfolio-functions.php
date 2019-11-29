<?php

if(! function_exists('Jayla_Jetpack_Portfolio_Metabox_Hooks_Manager')) {
    /**
     * @since 1.0.0
     *  
     */
    function Jayla_Jetpack_Portfolio_Metabox_Hooks_Manager($post_type) {
        if( 'jetpack-portfolio' == $post_type ) {
            remove_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_heading_bar', 20 );
            remove_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_sidebar', 36 );
            remove_action( 'jayla_metabox_customize_settings_after_general', 'jayla_metabox_customize_heading_bar_settings_panel', 20 );
            add_action( 'jayla_metabox_customize_settings_after_general', 'jayla_metabox_customize_portfolio_detail_settings_panel', 20 );
        }
    }
}

if( ! function_exists('jayla_jetpack_portfolio_settings_default') ) {
    /**
     * @since 1.0.0 
     */
    function jayla_jetpack_portfolio_settings_default() {
        return apply_filters('jayla_jetpack_portfolio_data_settings', array(
            // archive 
            'archive_layout' => 'default',
            'grid_columns' => 4,
            'grid_columns_on_tablet' => 2,
            'grid_columns_on_mobile' => 1,
            'archive_items_per_page' => 9,
            'archive_sidebar' => 'off',

            // detail
            'single_layout' => 'default',
            'single_comment' => 'off',
        ));
    }
}

if(! function_exists('jayla_jetpack_portfolio_archive_layout')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_jetpack_portfolio_archive_layout() {
        return apply_filters( 'jayla_jetpack_portfolio_archive_layout_filter', array(
            'default' => array(
                'label' => __('Default (Grid)', 'jayla'),
                'path_template' => 'templates/jetpack-portfolio',
            ),
            'layout_2' => array(
                'label' => __('Layout 2', 'jayla'),
                'path_template' => 'templates/jetpack-portfolio',
            ),
        ) );
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_layout')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_jetpack_portfolio_single_layout() {
        return apply_filters( 'jayla_jetpack_portfolio_single_layout_filter', array(
            'default' => array(
                'label' => __('Default', 'jayla'),
                'path_template' => 'templates/jetpack-portfolio/single',
            ),
            'blank' => array(
                'label' => __('Blank', 'jayla'),
                'path_template' => 'templates/jetpack-portfolio/single-blank',
            ),
        ) );
    }
}

if(! function_exists('jayla_scheme_container_class_custom_jetpack_porfolio_archive')) {
    /**
     * @since 1.0.0
     * 
     */
    function jayla_scheme_container_class_custom_jetpack_porfolio_archive( $data ) {
        $post_type = get_post_type(); 
        if ( $post_type  == 'jetpack-portfolio' && is_archive() ) {
            $settings = jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
            if( 'off' == $settings['archive_sidebar'] ) {

                // entry content full 12 col
                $data['content']['right-sidebar'] = 'col-lg-12 col-sm-12';
                $data['content']['left-sidebar'] = 'col-lg-12 col-sm-12';
                $data['sidebar']['right-sidebar'] = 'col-lg-12 col-sm-12';
                $data['sidebar']['left-sidebar'] = 'col-lg-12 col-sm-12';

                // remove sidebar
                remove_action( 'jayla_sidebar', 'jayla_get_sidebar', 10 );
            }
        }
        return $data;
    }
}

if(! function_exists('jayla_scheme_container_class_custom_jetpack_porfolio_single')) {
    function jayla_scheme_container_class_custom_jetpack_porfolio_single( $data ) {
        $post_type = get_post_type(); 
        if ( $post_type  == 'jetpack-portfolio' && is_single() ) {
            $data['content']['right-sidebar'] = 'col-lg-12 col-sm-12';
            $data['content']['left-sidebar'] = 'col-lg-12 col-sm-12';
            $data['sidebar']['right-sidebar'] = 'col-lg-12 col-sm-12';
            $data['sidebar']['left-sidebar'] = 'col-lg-12 col-sm-12';

            // remove sidebar
            remove_action( 'jayla_sidebar', 'jayla_get_sidebar', 10 );
        }
        return $data;
    }
}

if(! function_exists('jayla_jetpack_portfolio_archive_layout_allow_furygrid')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_jetpack_portfolio_archive_layout_allow_furygrid() {
        return apply_filters( 'jayla_jetpack_portfolio_archive_layout_allow_furygrid_filter', array( 'default', 'layout_2' ) );
    }
}

if(! function_exists('jayla_jetpack_portfolio_custom_posts_per_page')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_jetpack_portfolio_custom_posts_per_page( $query ) {
        if ( $query->is_main_query() && $query->is_post_type_archive('jetpack-portfolio') ) {
            $settings = jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
            $query->set( 'posts_per_page', (int) $settings['archive_items_per_page'] );
        }

        return $query;
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_heading_bar_disable')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_jetpack_portfolio_single_heading_bar_disable($data) {
        $post_type = get_post_type(); 
        if ( $post_type  == 'jetpack-portfolio' && is_single() ) {
            $data = 'false';
        }
        return $data;
    }
}

if(! function_exists('jayla_jetpack_portfolio_single_display_comment')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_jetpack_portfolio_single_display_comment($data) {
        $settings = jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
        $single_comment_status = array(
            'on' => true,
            'off' => false,
        );

        return $single_comment_status[$settings['single_comment']];
    }
}

if(! function_exists('jayla_jetpack_portfolio_custom_metabox_data')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_jetpack_portfolio_custom_metabox_data($data, $post) {
        
        $data['settings']['custom_jetpack_portfolio_single'] = 'no';
        $data['settings']['jetpack_portfolio_single_settings'] = array(
            'single_layout' => 'default'
        );

        return $data;
    }
}