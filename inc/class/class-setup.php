<?php
/**
 * @package Jayla
 * @version 1.0.0
 *
 */

if(! class_exists('Jayla_Setup')) {

    class Jayla_Setup {

        /**
         * @since 1.0.0
         */
        function __construct() {

            $this->hooks();
        }

        /**
         * @since 1.0.0
         */
        public function hooks() {
            add_action('admin_menu', array($this, 'register_submenu_page_setup'));
        }

        /**
         * @since 1.0.0
         */
        public function register_submenu_page_setup() {
            list( $page_title, $menu_title, $capability, $menu_slug, $function ) = apply_filters( 'jayla_submenu_param_theme_setup', array(
                __('Theme Setup', 'jayla'),
                __('Theme Setup', 'jayla'),
                __('edit_theme_options', 'jayla'),
                __('theme___setup', 'jayla'),
                array( $this, 'theme_setup_callback' ),
            ) );

            add_theme_page($page_title, $menu_title, $capability, $menu_slug, $function);
        }

        /**
         * @since 1.0.0
         */
        public function theme_setup_callback() {
            ?>
            <div class="wrap">
                <h2><?php _e('Theme Setup', 'jayla'); ?></h2>
                <?php get_template_part( 'templates/admin/content', 'setup' ); ?>
            </div>
            <?php
        }
    }

    return new Jayla_Setup();
}
