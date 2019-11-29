<?php
/**
 * @package Jayla
 * 
 * ThemeFix - Envato Theme Check & Theme Check
 * remote this file before submit Themeforest
 */

// require get_template_directory() . '/inc/theme-additional/VerifyTheme.php';
require get_template_directory() . '/inc/theme-additional/license-helpers.php';

/*============ Filters ==============*/
/**
 * Fix message notice on php 7.0 
 * Cache (issue blank page if not login admin)
 * remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
 */

/**
 * @since 1.0.0
 * Jayla 
 */ 
add_action( 'add_meta_boxes', 'jayla_custom_metabox_func' );
add_action( 'admin_bar_menu', 'flitnotheme_add_designer_toolbar_link' );

/**
 * @since 1.0.0
 * WooCommerce Hooks 
 */
if( class_exists('WooCommerce') ){
    add_action( 'add_meta_boxes', 'jayla_woo_add_meta_boxes_hooks' );
}

define( 'JAYLA_DOMAIN_AUTO_PASS', array( 'localhost', '127.0.0.1' ) );
function jayla_check_domain_local() {

    $is_active = false;
    $domain_auto_pass = JAYLA_DOMAIN_AUTO_PASS;

    foreach( $domain_auto_pass as $index => $item ) {
        if( strpos( $my_domain, $item ) >= 0 ) {
            $is_active = true;
            break;
        }
    }

    return $is_active;
}

/*============ Functions ==============*/

if(! function_exists('jayla_custom_metabox_func')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_custom_metabox_func($post_type) {
        global $jayla;
        $list_metabox = $jayla->metabox->get_list_metabox();

        if( ! in_array( $post_type . '.php', $list_metabox ) ) return;

        $metabox_title = sprintf( '%1$s %2$s', $post_type, __('Options', 'jayla') );
        add_meta_box(
            'fintotheme_custom_metabox_' . $post_type,
            apply_filters('fintotheme_custom_metabox_' . $post_type, $metabox_title, $post_type ),
            array( 'Jayla_Custom_Meta_Box', 'render_metabox' ),
            $post_type,
            'advanced',
            'high'
        );
    }
}

if(! function_exists('jayla_woo_add_meta_boxes_hooks')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_woo_add_meta_boxes_hooks() {
        global $post;
        $shoppage_id = wc_get_page_id( 'shop' );

        // remove settings header bar & sidebar page shop + product
        if($post && $post->ID && $post->ID == $shoppage_id || get_post_type($post) == 'product') {
            remove_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_heading_bar', 20 );
            remove_action( 'jayla_metabox_customize_settings_after_general', 'jayla_metabox_customize_heading_bar_settings_panel', 20 );
        }
        
        if( get_post_type($post) == 'product' ) {
            remove_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_sidebar', 36 );
            add_action( 'jayla_metabox_customize_settings_after_general', 'jayla_metabox_customize_product_detail_settings_panel', 20 );
        }
    }
}

if(! function_exists('jayla_check_plugin_is_active')) {
    /**
     * @since 1.0.0
     * is_plugin_active
     */
    function jayla_check_plugin_is_active($plugin) {
        return is_plugin_active( $plugin );
    }
}

if(! function_exists('jayla_return_server_software')) {
    /**
     * @since 1.0.0 
     */
    function jayla_return_server_software() {
        return $_SERVER['SERVER_SOFTWARE'];
    }
}

if(! function_exists('Jayla_Jetpack_Portfolio_Add_Meta_Boxed')) {
    /**
     * @since 1.0.0
     *  
     */
    function Jayla_Jetpack_Portfolio_Add_Meta_Boxed() {
        add_action( 'add_meta_boxes', 'Jayla_Jetpack_Portfolio_Metabox_Hooks_Manager' );
    }
}

add_action( 'add_meta_boxes', 'jayla_remove_heading_bar_setting_is_blog_page', 20, 2 );

if(! function_exists('jayla_select_menu_message_fallback_template')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_select_menu_message_fallback_template() {
        echo '<div class="theme-extends-message-menu-fallback"><div class="theme-extends-menu-message">' . esc_html__( 'Please go to the', 'jayla' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Menu', 'jayla' ) . ' <i class="fa fa-external-link" aria-hidden="true"></i></a> ' . esc_html__( 'section, create a  menu and then select the newly created menu from the Theme Locations box from the left.', 'jayla' ) . '</div></div>';
    }
}
add_action( 'jayla_select_menu_message_fallback_action', 'jayla_select_menu_message_fallback_template', 20 );

if(! function_exists('jayla_verify_purchase_code_form_activate_html')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_verify_purchase_code_form_activate_html( $echo = true ) {
        ob_start();
        ?>
        <div class="__status_theme_activate __not-activate">
            <div class="__icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="" xml:space="preserve"> <g> <g> <path d="M375.71,356.744c-1.79-2.27-44.687-55.622-119.71-55.622s-117.92,53.351-119.71,55.622l31.42,24.756 c0.318-0.404,32.458-40.378,88.29-40.378c55.147,0,87.024,38.807,88.354,40.458l-0.064-0.08L375.71,356.744z"/> </g> </g> <g> <g> <path d="M437.02,74.98C388.667,26.629,324.38,0,256,0S123.333,26.629,74.98,74.98C26.629,123.333,0,187.62,0,256 s26.629,132.668,74.98,181.02C123.333,485.371,187.62,512,256,512s132.667-26.629,181.02-74.98 C485.371,388.668,512,324.38,512,256S485.371,123.333,437.02,74.98z M256,472c-119.103,0-216-96.897-216-216S136.897,40,256,40 s216,96.897,216,216S375.103,472,256,472z"/> </g> </g> <g> <g> <circle cx="168" cy="180.12" r="32"/> </g> </g> <g> <g> <circle cx="344" cy="180.12" r="32"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
            </div>
            <div class="__text">Not Activated</div>
        </div>
        <div class="themeextends-content-width-icon">
            <div class="__icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="" xml:space="preserve"> <g> <g> <path d="M480.452,16.032H31.548C14.152,16.032,0,30.185,0,47.581V400.29c0,17.396,14.152,31.549,31.548,31.549h104.21 c4.142,0,7.5-3.358,7.5-7.5c0-4.143-3.358-7.5-7.5-7.5H31.548c-9.125,0-16.548-7.424-16.548-16.549V111.193h482V400.29 c0,9.125-7.423,16.549-16.548,16.549h-104.21c-4.142,0-7.5,3.357-7.5,7.5c0,4.142,3.358,7.5,7.5,7.5h104.21 c17.396,0,31.548-14.153,31.548-31.549V47.581C512,30.185,497.848,16.032,480.452,16.032z M496.999,96.194H15v-0.001V47.581 c0-9.125,7.423-16.548,16.548-16.548h448.903c9.125,0,16.548,7.424,16.548,16.548V96.194z"/> </g> </g> <g> <g> <path d="M39.645,56.113h-0.08c-4.142,0-7.46,3.358-7.46,7.5c0,4.142,3.398,7.5,7.54,7.5c4.142,0,7.5-3.358,7.5-7.5 C47.145,59.472,43.787,56.113,39.645,56.113z"/> </g> </g> <g> <g> <path d="M87.661,56.113h-0.08c-4.142,0-7.46,3.358-7.46,7.5c0,4.142,3.398,7.5,7.54,7.5c4.142,0,7.5-3.358,7.5-7.5 C95.161,59.472,91.803,56.113,87.661,56.113z"/> </g> </g> <g> <g> <path d="M63.613,56.113h-0.08c-4.142,0-7.46,3.358-7.46,7.5c0,4.142,3.398,7.5,7.54,7.5c4.142,0,7.5-3.358,7.5-7.5 C71.113,59.472,67.755,56.113,63.613,56.113z"/> </g> </g> <g> <g> <path d="M472.436,56.113h-352.71c-4.142,0-7.5,3.358-7.5,7.5c0,4.142,3.358,7.5,7.5,7.5h352.71c4.142,0,7.5-3.358,7.5-7.5 C479.936,59.472,476.578,56.113,472.436,56.113z"/> </g> </g> <g> <g> <path d="M418.8,208.842l-160.323-56.113c-1.604-0.562-3.352-0.562-4.955,0L93.2,208.842c-3.062,1.071-5.087,3.989-5.021,7.232 c0.037,1.813,1.147,45.033,21.827,101.201c12.139,32.97,28.547,63.543,48.771,90.87c25.298,34.183,56.651,63.335,93.19,86.646 c1.23,0.785,2.632,1.177,4.034,1.177c1.402,0,2.804-0.393,4.034-1.177c36.539-23.311,67.892-52.463,93.19-86.646 c20.224-27.327,36.632-57.9,48.771-90.87c20.678-56.168,21.788-99.388,21.825-101.201 C423.887,212.831,421.862,209.912,418.8,208.842z M387.918,312.091c-11.646,31.634-27.376,60.949-46.752,87.131 c-23.267,31.439-51.902,58.438-85.166,80.311c-33.161-21.804-61.724-48.706-84.951-80.021 c-19.364-26.106-35.1-55.339-46.77-86.885c-14.285-38.615-19.648-73.986-20.847-91.476L256,167.753l152.523,53.383 C407.562,234.144,403.626,269.425,387.918,312.091z"/> </g> </g> <g> <g> <path d="M318.652,282.763c-2.929-2.929-7.678-2.929-10.606,0l-62.66,62.66l-37.946-37.946c-2.929-2.929-7.678-2.929-10.606,0 c-2.929,2.929-2.929,7.677,0,10.606l43.249,43.249c1.464,1.464,3.384,2.197,5.303,2.197c1.919,0,3.839-0.732,5.303-2.197 l67.963-67.963C321.581,290.44,321.581,285.691,318.652,282.763z"/> </g> </g> <g> <g> <path d="M354.713,220.381l-96.178-33.662c-0.751-0.271-1.549-0.423-2.362-0.441h-0.001c-0.006,0-0.011-0.001-0.02-0.001 c-0.007,0-0.012,0.001-0.02,0c-0.006,0-0.014,0-0.019,0c-0.006,0-0.013,0-0.019,0c-0.008,0-0.013,0-0.019,0 c-0.007,0-0.013,0-0.019,0c-0.007,0-0.013,0-0.019,0c-0.005,0-0.012,0-0.019,0c-0.012,0-0.013,0-0.018,0c0,0-0.001,0-0.001,0 c-0.005,0-0.01,0-0.015,0c-0.002,0-0.011,0-0.017,0c-0.005,0-0.012,0-0.018,0c-0.008,0-0.013,0-0.018,0c-0.006,0-0.012,0-0.018,0 c-0.004,0-0.01,0-0.014,0c-0.005,0.001-0.007,0.001-0.017,0c-0.006,0-0.013,0-0.018,0c-0.823,0.015-1.63,0.166-2.391,0.439 L127.49,230.811c-3.39,1.187-5.462,4.609-4.944,8.162c2.999,20.552,9.869,52.479,25.565,87.861 c18.711,42.178,45.238,78.825,78.846,108.922c1.432,1.282,3.219,1.913,5.001,1.913c2.058,0,4.108-0.842,5.589-2.496 c2.765-3.086,2.503-7.827-0.583-10.591c-32.016-28.672-57.297-63.605-75.142-103.831c-13.531-30.502-20.198-58.292-23.477-77.848 L256,201.725l93.758,32.815c3.91,1.37,8.188-0.692,9.557-4.601C360.683,226.029,358.623,221.751,354.713,220.381z"/> </g> </g> <g> <g> <path d="M383.035,230.433c-4.097-0.618-7.917,2.203-8.534,6.299c-3.363,22.313-11.201,56.783-29.441,94.291 c-22.06,45.361-53.519,83.234-93.505,112.568c-3.34,2.45-4.062,7.144-1.611,10.483c1.47,2.003,3.746,3.064,6.053,3.064 c1.54,0,3.094-0.473,4.43-1.453c41.972-30.791,74.985-70.526,98.123-118.103c19.068-39.21,27.265-75.27,30.783-98.615 C389.951,234.871,387.131,231.05,383.035,230.433z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
            </div>
            <div class="__entry">
                <div class="__strong-content">Purchase Code</div>
                <div style="color: #777; font-weight: 300;">You can learn how to find your purchase key <a href="<?php echo esc_url( 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-' ); ?>" target="_blank">here</a></div>
            </div>
        </div>
        <form class="theme-verify-purchase-code-form" method="POST">
            <input class="__text-field bearstheme_purchase_code_field" id="verifytheme_settings_purchase_code" name="purchase_code" type="text" required/>
            <button type="submit" class="__button-submit">Activate Now</button>
            <div class="__theme-verify-message-container"></div>
            <p class="__text_note">
                In order to receive all benefits of Jayla, you need to activate your copy of the theme. By activating Jayla license you will unlock premium options - direct theme <u>updates</u>, access to <u>premium plugin library</u> and one click <u>install package demo</u>.
            </p>
            <p class="__text_note">
                Reminder! One registration per Website. If registered elsewhere please deactivate that registration first.
            </p>
        </form>
        <?php
        if( true == $echo ) echo ob_get_clean();
        else return ob_get_clean();
    }
}

if(! function_exists('jayla_verify_purchase_code_form_deactivate_html')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_verify_purchase_code_form_deactivate_html( $echo = true ) {
        ob_start();
        ?>
        <div class="__status_theme_activate __is-activate">
            <div class="__icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="" xml:space="preserve"> <g> <g> <path d="M479.057,206.509c-5.988-4.845-15.953-12.927-17.201-16.757c-1.269-3.978,2.01-16.778,3.978-24.395 c4.718-18.386,10.6-41.258-2.581-59.263c-13.118-17.878-36.709-19.444-55.666-20.714c-7.85-0.55-21.01-1.418-24.332-3.83 c-3.364-2.433-8.421-14.895-11.446-22.364c-7.469-18.513-15.974-39.502-36.73-46.188c-20.65-6.749-39.523,5.205-56.132,15.72 c-7.321,4.612-18.344,11.595-22.956,11.595c-4.422,0-15.318-7.088-22.554-11.785c-15.974-10.389-35.947-23.253-56.999-16.101 c-20.714,7.046-29.134,27.907-36.603,46.272c-3.004,7.405-7.998,19.761-11.425,22.279c-3.343,2.475-16.736,3.364-24.734,3.893 c-19.994,1.354-42.654,2.878-55.391,20.904c-12.504,17.709-6.898,39.544-1.947,58.819c1.947,7.659,5.247,20.481,4.062,24.31 c-1.269,3.66-11.129,11.764-17.011,16.609C18.513,217.787,0,233.041,0,255.892c0,22.702,18.154,37.788,32.731,49.89 c6.326,5.247,15.868,13.181,17.159,17.117c1.269,3.893-2.031,16.545-4.02,24.099c-4.824,18.555-10.854,41.66,2.835,59.813 c13.351,17.646,36.836,19.211,55.73,20.481c7.85,0.55,20.989,1.396,24.332,3.83s8.379,14.874,11.404,22.343 c7.49,18.513,15.974,39.502,36.751,46.209c4.168,1.375,8.294,1.968,12.314,1.968c15.911,0,30.594-9.309,43.839-17.646 c7.299-4.612,18.302-11.595,22.914-11.595c4.507,0,15.339,6.898,22.491,11.468c15.868,10.092,35.672,22.745,56.682,15.551 c20.692-7.046,29.113-27.886,36.582-46.293c3.004-7.384,7.998-19.761,11.425-22.279c3.364-2.475,16.672-3.364,24.628-3.893 c19.846-1.354,42.358-2.856,55.286-20.608c13.012-17.836,7.426-39.904,2.497-59.348c-1.925-7.596-5.141-20.269-3.978-24.078 c1.269-3.66,11.129-11.764,16.99-16.609C493.487,294.04,512,278.764,512,255.913C512,233.253,493.72,218.421,479.057,206.509z M451.7,273.686c-12.377,10.177-25.178,20.735-30.214,35.863c-5.141,15.403-0.952,31.906,3.089,47.859 c1.968,7.786,5.268,20.798,4.824,23.485c-3.216,2.412-16.482,3.322-24.416,3.83c-15.72,1.058-33.535,2.243-46.801,11.975 c-13.139,9.627-19.508,25.347-25.665,40.539c-3.004,7.49-8.082,20.036-10.177,21.941c-3.851,0-14.62-6.919-21.073-11.023 c-13.308-8.463-28.394-18.09-45.257-18.09c-16.884,0-32.097,9.648-45.553,18.154c-6.517,4.105-17.434,11.044-19.761,11.552 c-3.279-2.349-8.273-14.747-11.277-22.152c-6.22-15.382-12.652-31.271-25.918-40.814c-13.181-9.5-29.981-10.621-46.251-11.7 c-7.638-0.508-21.877-1.46-24.459-3.216c-1.312-3.745,2.01-16.545,4.02-24.162c3.914-15.086,8.379-32.181,3.343-47.796 c-5.057-15.593-18.492-26.786-30.362-36.646c-5.797-4.824-16.609-13.816-17.519-17.074c0.952-3.978,12.06-13.139,18.026-18.026 c12.377-10.198,25.178-20.756,30.214-35.884c5.184-15.509,0.91-32.139-3.195-48.219c-1.989-7.765-5.332-20.756-5.078-23.231 c3.237-2.327,16.397-3.216,24.268-3.745c16.524-1.1,33.641-2.264,46.907-11.975c13.139-9.627,19.508-25.326,25.665-40.517 c3.004-7.511,8.104-20.037,10.05-21.92c3.914,0.063,14.789,7.13,21.285,11.341c13.414,8.717,28.648,18.598,45.595,18.598 c16.863,0,32.118-9.648,45.532-18.132c6.517-4.126,17.434-11.044,19.762-11.552c3.258,2.349,8.273,14.747,11.277,22.152 c6.22,15.361,12.652,31.25,25.918,40.792c13.181,9.521,30.002,10.642,46.294,11.721c8.04,0.55,21.518,1.46,24.035,2.983 c1.291,3.724-1.989,16.588-3.978,24.247c-3.872,15.149-8.273,32.308-3.216,47.965c5.099,15.763,18.746,26.828,30.785,36.582 c5.501,4.485,15.636,12.674,17.201,16.609C468.119,260.124,457.476,268.904,451.7,273.686z"/> </g> </g> <g> <g> <path d="M350.608,176.19c-9.013-7.532-22.322-6.305-29.79,2.645l-94.343,112.793l-40.137-40.115 c-8.273-8.273-21.645-8.273-29.917,0c-8.273,8.273-8.273,21.645,0,29.917l56.492,56.492c3.956,3.999,9.352,6.199,14.959,6.199 c0.296,0,0.614,0,0.91-0.042c5.966-0.254,11.489-3.004,15.297-7.553L353.252,205.98C360.742,197.01,359.579,183.68,350.608,176.19 z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
            </div>
            <div class="__text">Activated</div>
        </div>
        <div class="themeextends-content-width-icon">
            <div class="__icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="fill: green;" xml:space="preserve"> <g> <g> <path d="M480.452,16.032H31.548C14.152,16.032,0,30.185,0,47.581V400.29c0,17.396,14.152,31.549,31.548,31.549h104.21 c4.142,0,7.5-3.358,7.5-7.5c0-4.143-3.358-7.5-7.5-7.5H31.548c-9.125,0-16.548-7.424-16.548-16.549V111.193h482V400.29 c0,9.125-7.423,16.549-16.548,16.549h-104.21c-4.142,0-7.5,3.357-7.5,7.5c0,4.142,3.358,7.5,7.5,7.5h104.21 c17.396,0,31.548-14.153,31.548-31.549V47.581C512,30.185,497.848,16.032,480.452,16.032z M496.999,96.194H15v-0.001V47.581 c0-9.125,7.423-16.548,16.548-16.548h448.903c9.125,0,16.548,7.424,16.548,16.548V96.194z"/> </g> </g> <g> <g> <path d="M39.645,56.113h-0.08c-4.142,0-7.46,3.358-7.46,7.5c0,4.142,3.398,7.5,7.54,7.5c4.142,0,7.5-3.358,7.5-7.5 C47.145,59.472,43.787,56.113,39.645,56.113z"/> </g> </g> <g> <g> <path d="M87.661,56.113h-0.08c-4.142,0-7.46,3.358-7.46,7.5c0,4.142,3.398,7.5,7.54,7.5c4.142,0,7.5-3.358,7.5-7.5 C95.161,59.472,91.803,56.113,87.661,56.113z"/> </g> </g> <g> <g> <path d="M63.613,56.113h-0.08c-4.142,0-7.46,3.358-7.46,7.5c0,4.142,3.398,7.5,7.54,7.5c4.142,0,7.5-3.358,7.5-7.5 C71.113,59.472,67.755,56.113,63.613,56.113z"/> </g> </g> <g> <g> <path d="M472.436,56.113h-352.71c-4.142,0-7.5,3.358-7.5,7.5c0,4.142,3.358,7.5,7.5,7.5h352.71c4.142,0,7.5-3.358,7.5-7.5 C479.936,59.472,476.578,56.113,472.436,56.113z"/> </g> </g> <g> <g> <path d="M418.8,208.842l-160.323-56.113c-1.604-0.562-3.352-0.562-4.955,0L93.2,208.842c-3.062,1.071-5.087,3.989-5.021,7.232 c0.037,1.813,1.147,45.033,21.827,101.201c12.139,32.97,28.547,63.543,48.771,90.87c25.298,34.183,56.651,63.335,93.19,86.646 c1.23,0.785,2.632,1.177,4.034,1.177c1.402,0,2.804-0.393,4.034-1.177c36.539-23.311,67.892-52.463,93.19-86.646 c20.224-27.327,36.632-57.9,48.771-90.87c20.678-56.168,21.788-99.388,21.825-101.201 C423.887,212.831,421.862,209.912,418.8,208.842z M387.918,312.091c-11.646,31.634-27.376,60.949-46.752,87.131 c-23.267,31.439-51.902,58.438-85.166,80.311c-33.161-21.804-61.724-48.706-84.951-80.021 c-19.364-26.106-35.1-55.339-46.77-86.885c-14.285-38.615-19.648-73.986-20.847-91.476L256,167.753l152.523,53.383 C407.562,234.144,403.626,269.425,387.918,312.091z"/> </g> </g> <g> <g> <path d="M318.652,282.763c-2.929-2.929-7.678-2.929-10.606,0l-62.66,62.66l-37.946-37.946c-2.929-2.929-7.678-2.929-10.606,0 c-2.929,2.929-2.929,7.677,0,10.606l43.249,43.249c1.464,1.464,3.384,2.197,5.303,2.197c1.919,0,3.839-0.732,5.303-2.197 l67.963-67.963C321.581,290.44,321.581,285.691,318.652,282.763z"/> </g> </g> <g> <g> <path d="M354.713,220.381l-96.178-33.662c-0.751-0.271-1.549-0.423-2.362-0.441h-0.001c-0.006,0-0.011-0.001-0.02-0.001 c-0.007,0-0.012,0.001-0.02,0c-0.006,0-0.014,0-0.019,0c-0.006,0-0.013,0-0.019,0c-0.008,0-0.013,0-0.019,0 c-0.007,0-0.013,0-0.019,0c-0.007,0-0.013,0-0.019,0c-0.005,0-0.012,0-0.019,0c-0.012,0-0.013,0-0.018,0c0,0-0.001,0-0.001,0 c-0.005,0-0.01,0-0.015,0c-0.002,0-0.011,0-0.017,0c-0.005,0-0.012,0-0.018,0c-0.008,0-0.013,0-0.018,0c-0.006,0-0.012,0-0.018,0 c-0.004,0-0.01,0-0.014,0c-0.005,0.001-0.007,0.001-0.017,0c-0.006,0-0.013,0-0.018,0c-0.823,0.015-1.63,0.166-2.391,0.439 L127.49,230.811c-3.39,1.187-5.462,4.609-4.944,8.162c2.999,20.552,9.869,52.479,25.565,87.861 c18.711,42.178,45.238,78.825,78.846,108.922c1.432,1.282,3.219,1.913,5.001,1.913c2.058,0,4.108-0.842,5.589-2.496 c2.765-3.086,2.503-7.827-0.583-10.591c-32.016-28.672-57.297-63.605-75.142-103.831c-13.531-30.502-20.198-58.292-23.477-77.848 L256,201.725l93.758,32.815c3.91,1.37,8.188-0.692,9.557-4.601C360.683,226.029,358.623,221.751,354.713,220.381z"/> </g> </g> <g> <g> <path d="M383.035,230.433c-4.097-0.618-7.917,2.203-8.534,6.299c-3.363,22.313-11.201,56.783-29.441,94.291 c-22.06,45.361-53.519,83.234-93.505,112.568c-3.34,2.45-4.062,7.144-1.611,10.483c1.47,2.003,3.746,3.064,6.053,3.064 c1.54,0,3.094-0.473,4.43-1.453c41.972-30.791,74.985-70.526,98.123-118.103c19.068-39.21,27.265-75.27,30.783-98.615 C389.951,234.871,387.131,231.05,383.035,230.433z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
            </div>
            <div class="__entry">
                <div class="__strong-content">Purchase Code Verified Successfully!</div>
                <div style="color: #777; font-weight: 300;">Unlock premium options. Thank you so much! ☘</div>
            </div>
        </div>
        <form class="theme-deactivate-form" method="POST">
            <button type="submit" class="__button-submit">Deactivate</button>
            <div class="__theme-verify-message-container"></div>
            <p class="__text_note">
                Reminder! One registration per Website. If registered elsewhere please deactivate that registration first.
            </p>
        </form>
        <?php
        if( true == $echo ) echo ob_get_clean();
        else return ob_get_clean();
    }
}

if(! function_exists('jayla_verify_purchase_code_form_html')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_verify_purchase_code_form_html() {
        $tf_license_code = get_option( 'tf_license_code' );
        ?>
        <h3><?php _e('Theme Activation License', 'jayla'); ?></h3>
        <div id="theme-purchase-code-validate-js" class="theme-purchase-code-validate">
            <?php 
            if( true == $tf_license_code ) {
                jayla_verify_purchase_code_form_deactivate_html();
            } else {
                jayla_verify_purchase_code_form_activate_html();
            }
            ?>
        </div>
        <?php
    }
}
add_action( 'jayla_verify_purchase_code_form' , 'jayla_verify_purchase_code_form_html', 10 );

if( ! function_exists( 'jayla_check_license_code' ) ) {
    function jayla_check_license_code( $_purchase_code = null ) {
        global $jayla_license_helpers;

        $tf_license_code = get_option( 'tf_license_code', '' );
        $purchase_code = ! empty( $_purchase_code ) ? $_purchase_code : $tf_license_code;

        if( empty( $purchase_code ) ) return false;

        $jayla_license_helpers->set_license_code( trim( $purchase_code ) );
        $info_license = $jayla_license_helpers->validate_license();
        $my_domain = str_replace( array( 'http://', 'https://' ), '', get_site_url() );
       
        if( isset( $info_license->success ) && false == $info_license->success ) {
            return array(
                'message' => __( 'Invalid purchase code, please try again! (1)', 'jayla' ),
                'st' => 'error'
            );
        }
        
        if( TF_THEME_ID != $info_license->item->id ) {
            return array(
                'message' => __( 'Invalid purchase code, please try again! (2)', 'jayla' ),
                'st' => 'error'
            );
        }

        $domain_auto_pass = JAYLA_DOMAIN_AUTO_PASS;
        $is_active = false;
        foreach( $domain_auto_pass as $index => $item ) {
            if( strpos( $my_domain, $item ) >= 0 ) {
                $is_active = true;
                break;
            }
        }

        if( true == $is_active ) {
            if( ! $tf_license_code ) {
                update_option( 'tf_license_code', $purchase_code );
                return array(
                    'message' => __( 'Verify purchase code successful! (3)', 'jayla' ),
                    'content' => jayla_verify_purchase_code_form_deactivate_html( false ),
                    'st' => 'success'
                );
            }
        }

        return $jayla_license_helpers;
    }
}

if( ! function_exists('jayla_ajax_purchase_code_validate') ) {
    /**
     * @since 10.0
     *  
     */
    function jayla_ajax_purchase_code_validate() {
      
        $result = jayla_check_license_code( trim( $_POST['purchase_code'] ) );
        if( is_array( $result ) ) {
            wp_send_json_success( $result );
        } else {
            $jayla_license_helpers = $result;
        }

        $jayla_license_helpers->set_license_code( trim( $_POST['purchase_code'] ) );
        $info_license = $jayla_license_helpers->validate_license();
        $my_domain = str_replace( array( 'http://', 'https://' ), '', get_site_url() );
       
        $registed_data = $jayla_license_helpers->get_domain_registed();
        // wp_send_json( $registed_data );
        if( $registed_data->count > 0 ) {
            $is_active = false;
            foreach( $registed_data->result as $index => $item ) {
                if( $my_domain == $item->server_name && $item->status ) {
                    $is_active = true;
                    break;
                }
            }

            if( true == $is_active ) {
                update_option( 'tf_license_code', $_POST['purchase_code'] );

                wp_send_json_success( array(
                    'message' => __( 'Domain registed successful!', 'jayla' ),
                    'content' => jayla_verify_purchase_code_form_deactivate_html( false ),
                    'st' => 'success'
                ) );
            } else {
                wp_send_json_success( array(
                    'message' => __( 'Purchase code has used. you’ll need to “deactivate” the purchase code registration from the previous site first (3)', 'jayla' ),
                    'st' => 'error'
                ) );
            }
        }

        $register_data = $jayla_license_helpers->register_domain();
        if( isset( $register_data ) && true == $register_data->success ) {
            update_option( 'tf_license_code', $_POST['purchase_code'] );

            wp_send_json_success( array(
                'message' => $register_data->message,
                'content' => jayla_verify_purchase_code_form_deactivate_html( false ),
                'st' => 'success'
            ) );
        } else {
            wp_send_json_success( array(
                'message' => __( 'Error! Please contact with our <a href="https://bearsthemes.ticksy.com/" target="_blank">support</a>.', 'jayla' ),
                'st' => 'error'
            ) );
        }
        
        exit();
    }

    add_action( 'wp_ajax_jayla_ajax_purchase_code_validate', 'jayla_ajax_purchase_code_validate' );
    add_action( 'wp_ajax_nopriv_jayla_ajax_purchase_code_validate', 'jayla_ajax_purchase_code_validate' );
}

if( ! function_exists('jayla_ajax_deactive_license_theme') ) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_ajax_deactive_license_theme() {
        
        global $jayla_license_helpers;
        $tf_license_code = get_option( 'tf_license_code', '' );

        $jayla_license_helpers->set_license_code( trim( $tf_license_code ) );
        $jayla_license_helpers->deactive_domain();

        delete_option( 'tf_license_code' );

        wp_send_json_success( array(
            'message' => 'Deactivate license successfull!',
            'content' => jayla_verify_purchase_code_form_activate_html( false ),
            'st' => 'success',
        ) );
        exit();
    }

    add_action( 'wp_ajax_jayla_ajax_deactive_license_theme', 'jayla_ajax_deactive_license_theme' );
    add_action( 'wp_ajax_nopriv_jayla_ajax_deactive_license_theme', 'jayla_ajax_deactive_license_theme' );
}

if(! function_exists('jayla_header_builder_custom_layout_data_default')) {
    /**
     * @since 1.0.0
     *  
     */
    function jayla_header_builder_custom_layout_data_default() {
        return '[{ "key": "__layout-ngjqhnb", "name": "Header Default", "style": "nav-top", "settings": { "header_strip_display": false, "header_strip_text": "", "header_strip_button_display": true, "header_strip_button_text": "Read More", "header_strip_link": "#", "header_strip_button_close_display": true, "header_strip_content": "large", "header_tablet_mobile_transform_width": 979, "header_sticky": false }, "header_sticky_data": [ { "key": "row-element-xqzhlbk", "element": "rs-row", "children": [ { "key": "col-element-xbkzxgrf", "element": "rs-col", "params": { "width": 100 }, "children": [] } ] } ], "header_tablet_mobile_data": [ { "key": "row-element-dmmlhxkpf", "element": "rs-row", "params": { "content_width": "large", "full_width": "off", "hidden_on_device": [], "medium_device": "off", "small_device": "off", "extra_small_device": "off", "padding": "10px 0" }, "children": [ { "key": "col-element-awucddpdex", "element": "rs-col", "params": { "width": 20, "padding": "" }, "children": [ { "element": "widget", "name": "handheld-navigation", "title": "Handheld Navigation", "icon": "ion-navicon-round", "description": "Mobile menu", "key": "widget-element-tayflxk" } ] }, { "key": "col-element-ecctssd", "element": "rs-col", "params": { "width": 60, "padding": "", "widget_inline": "off", "hidden_on_device": [], "medium_device": "off", "small_device": "off", "extra_small_device": "off", "align": "theme-extends-align-center" }, "children": [ { "element": "widget", "name": "logo", "title": "Logo", "icon": "ion-android-bookmark", "description": "brand your representation", "key": "widget-element-yqnxbzmi" } ] }, { "key": "col-element-zdldbpegt", "element": "rs-col", "params": { "width": 20, "padding": "", "widget_inline": "off", "hidden_on_device": [], "medium_device": "off", "small_device": "off", "extra_small_device": "off", "align": "theme-extends-align-right" }, "children": [ { "element": "widget", "name": "search", "title": "Search", "icon": "ion-ios-search-strong", "description": "Search (opt ajax)", "key": "widget-element-napoqrlzci" } ] } ] } ], "header_data": [ { "key": "row-element-urzuucia", "element": "rs-row", "children": [ { "key": "col-element-tgryfm", "element": "rs-col", "params": { "width": "26.091" }, "children": [ { "element": "widget", "name": "logo", "title": "Logo", "icon": "ion-android-bookmark", "description": "brand your representation", "key": "widget-element-oymcggig" } ] }, { "key": "col-element-qncgdexa", "element": "rs-col", "params": { "width": "73.909", "padding": "", "widget_inline": "off", "hidden_on_device": [], "medium_device": "off", "small_device": "off", "extra_small_device": "off", "align": "theme-extends-align-right" }, "children": [ { "element": "widget", "name": "primary-navigation", "title": "Primary Navigation", "icon": "ion-navicon-round", "description": "Primary menu", "key": "widget-element-hfedbktmwr" } ] } ], "params": { "full_width": "off", "hidden_on_device": [], "medium_device": "off", "small_device": "off", "extra_small_device": "off", "padding": "10px 0" } } ] }]';
    }
    add_filter( 'jayla_header_builder_layout_data_default' , 'jayla_header_builder_custom_layout_data_default' );
}