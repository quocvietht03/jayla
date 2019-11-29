<?php

if(! function_exists('jayla_blookbook_remove_heading_bar_single_page') ) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_blookbook_remove_heading_bar_single_page($data) {
        global $post;
        $posttype = get_post_type( $post );

        if( 'lookbook' == $posttype && is_single() ) {
            $data = 'false';
        }

        return $data;
    }
}