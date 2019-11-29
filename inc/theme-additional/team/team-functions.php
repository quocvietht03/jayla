<?php 
/**
 * Team functions
 * @since 1.0.2
 *  
 */

if( ! function_exists('jayla_team_metabox_posttype_support') ) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_metabox_posttype_support( $data  ) {
        $data['team'] = 'customizeOverride';

        return $data;
    }
}

if( ! function_exists( 'jayla_team_content_end_class_func' ) ) {
    /**
     * @since 1.0.2
     * Use bootstrap col 12 / template no sitebar
     */
    function jayla_team_content_end_class_func( $classes ) {
        global $post;

        if ( is_post_type_archive ( 'team' ) || is_singular( 'team' ) ) {
            $classes = 'col-lg-12 col-sm-12';
        }

        return $classes;
    }
}

if(! function_exists('jayla_team_get_all_item_array_options')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_get_all_item_array_options() {
        $args = array(
            'post_type' => 'team',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $query = new WP_Query( $args );
        $result = array();

        // The Loop
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $result[get_the_id()] = get_the_title();
            }
            /* Restore original Post Data */
            wp_reset_postdata();
        }
        wp_reset_postdata();
        return $result;
    }
}

if(! function_exists('jayla_team_single_content_add_custom_class_switching')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_single_content_add_custom_class_switching( $classes ) {
        $classes[] = 'themeextends-team-project-switching';
        return $classes;
    }
}

if(! function_exists('jayla_team_add_more_taxonomy_list')) {
    /**
     * @since 1.0.2
     *  
     */
    function jayla_team_add_more_taxonomy_list( $data ) {

        array_push( $data, array(
            'label' => __( 'Team Archive', 'jayla' ),
            'name' => 'team',
            'posttype' => 'team',
        ) );

        return $data;
    }
}