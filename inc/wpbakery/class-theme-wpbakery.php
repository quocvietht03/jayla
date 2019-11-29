<?php 
/**
 * @since 1.0.0 
 * 
 */

if( ! class_exists('Jayla_WPBakery') ) {
    class Jayla_WPBakery {
        
        public function __construct() {
            $this->hooks();
        }

        public function hooks() {

        }


    }

    return new Jayla_WPBakery();
}
