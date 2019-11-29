<?php 

if(! function_exists('jayla_blookbook_wrap_single_content_open')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_blookbook_wrap_single_content_open() {
        ?>
        <div id="main-content"> <!-- open #main-content -->
        <?php
    }
}

if(! function_exists('jayla_blookbook_wrap_single_content_close')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_blookbook_wrap_single_content_close() {
        ?>
        </div> <!-- close #main-content -->
        <?php
    }
}

if(! function_exists('jayla_blookbook_custom_classes_open')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_blookbook_custom_classes_open($classes) {

        ob_start(); do_action('jayla_container_class');
        $container_class = ob_get_clean();
        $key = array_search('container', $classes);

        if( isset( $classes[$key] ) ) {
            $classes[$key] = $container_class;
        } 

        return $classes;
    }
}