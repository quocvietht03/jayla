<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}
/*
 *
 */
if ( !is_admin() || !current_user_can('switch_themes') ) return;

require get_template_directory() . '/inc/class/class-setup.php';
require get_template_directory() . '/inc/class/class-plugin-install-helper.php';

if(! function_exists('jayla_ajax_install_plugin_handle')) {
    /**
     * @since 1.0.0
     */
    function jayla_ajax_install_plugin_handle() {
        extract($_POST);
        $response = Jayla_Plugin_Installer_Helper::install( $data );
        wp_send_json( $response ); exit();
    }
    add_action( 'wp_ajax_jayla_ajax_install_plugin_handle', 'jayla_ajax_install_plugin_handle' );
    add_action( 'wp_ajax_nopriv_jayla_ajax_install_plugin_handle', 'jayla_ajax_install_plugin_handle' );
}

if(! function_exists('jayla_ajax_active_plugin_handle')) {
    /**
     * @since 1.0.0
     */
    function jayla_ajax_active_plugin_handle() {
        extract($_POST);
        $response = Jayla_Plugin_Installer_Helper::activate( $data );
        wp_send_json( $response ); exit();
    }
    add_action( 'wp_ajax_jayla_ajax_active_plugin_handle', 'jayla_ajax_active_plugin_handle' );
    add_action( 'wp_ajax_nopriv_jayla_ajax_active_plugin_handle', 'jayla_ajax_active_plugin_handle' );
}

if(! function_exists('jayla_button_action_install_plugin')) {
    /**
     * @since 1.0.0
     */
    function jayla_button_action_install_plugin($plugin) {
        $install_st = Jayla_Plugin_Installer_Helper::is_installed($plugin);
        $json_plg = wp_json_encode( $plugin );
        if( $install_st == true ) {
            $active_st = Jayla_Plugin_Installer_Helper::is_active($plugin);
            if( $active_st == true ) {
                // button is activated
                return implode('', array(
                    '<a href="'. esc_url( '#' ) .'" class="__btn btn-activated">',
                        __('Activated', 'jayla'),
                    '</a>'
                ));
            } else {
                // button active
                return implode('', array(
                    '<a href="'. esc_url( '#' ) .'" class="__btn btn-active" @click=\'ActivePlugin($event, '. $json_plg .')\'>',
                        __('+ Active Now', 'jayla'),
                    '</a>'
                ));
            }
        } else {
            // button install
            return implode('', array(
                '<a href="'. esc_url( '#' ) .'" class="__btn btn-install" @click=\'InstallPlugin($event, '. $json_plg .')\'>',
                    __('+ Install Now', 'jayla'),
                '</a>'
            ));
        }
    }
}

if(! function_exists('jayla_ajax_get_plugin_install_type')) {
    /**
     * @since 1.0.0
     */
    function jayla_ajax_get_plugin_install_type() {
        extract($_POST);
        
        $installationlegit = ( ! function_exists('jayla_check_license_code' ) ) ? false : jayla_check_license_code();
        $installationlegit = is_array( $installationlegit ) ? false : true;

        $premium_plugins = array(
          'revslider',
          'js_composer',
          'essential-grid',
          'prdctfltr',
        );
        $install_st = Jayla_Plugin_Installer_Helper::is_installed($plugin);
        if( in_array($plugin['slug'],$premium_plugins) && $installationlegit == false ){
          wp_send_json_success( array(
              'type' => 'is_locked'
          ) );
        }
        $json_plg = wp_json_encode( $plugin );
        if( $install_st == true ) {
            $active_st = Jayla_Plugin_Installer_Helper::is_active($plugin);
            if( $active_st == true ) {
                // is_activated
                wp_send_json_success( array(
                    'type' => 'is_activated'
                ) );
            } else {
                // is_installed
                wp_send_json_success( array(
                    'type' => 'is_installed'
                ) );
            }
        } else {
            // not_installed
            wp_send_json_success( array(
                'type' => 'not_installed'
            ) );
        }
    }
    add_action( 'wp_ajax_jayla_ajax_get_plugin_install_type', 'jayla_ajax_get_plugin_install_type' );
    add_action( 'wp_ajax_nopriv_jayla_ajax_get_plugin_install_type', 'jayla_ajax_get_plugin_install_type' );
}

{
    /**
     * Ajax install package demo
     * @since 1.0.0
     *
     */
    if(! function_exists('jayla_ajax_install_demo_content')) {
      /**
       * @since 1.0.0
       */
      function jayla_ajax_install_demo_content() {
        extract( $_POST );
        $params = array( $package_data, $on_action );
        if( isset($extra_params) ) { array_push($params, $extra_params); }

        $function_name = "jayla_install_demo__step_{$on_action}";
        if( function_exists( $function_name ) ) {
            $result = call_user_func_array( "jayla_install_demo__step_{$on_action}", $params );
            wp_send_json_success( $result );
        } else {
            wp_send_json_success( array(
                'message' => '...'
            ) );
        }

        exit();
      }
      add_action( 'wp_ajax_jayla_ajax_install_demo_content', 'jayla_ajax_install_demo_content' );
      add_action( 'wp_ajax_nopriv_jayla_ajax_install_demo_content', 'jayla_ajax_install_demo_content' );
    }

    if(! function_exists('jayla_install_demo__step_backup_site')) {
      /**
       * Backup site before install demo
       * @since 1.0.0
       *
       */
      function jayla_install_demo__step_backup_site($package_data, $on_action, $extra_params = array()) {
        // Check plugin bears_backup install & active
        if( ! class_exists('Bears_Backup') ) {

            $backup_plugin_data = array(
                'name' => __('Bears Backup', 'jayla'),
                'slug' => 'bears-backup',
                'source' => 'http://beplusthemes.com/install/plugin/bears-backup.zip',
            );
            if(! Jayla_Plugin_Installer_Helper::is_installed( $backup_plugin_data )) {
                // Install...
                $install_response = Jayla_Plugin_Installer_Helper::install( $backup_plugin_data );
                if( $install_response['success'] == true ) {
                    // Active...
                    $active_response = Jayla_Plugin_Installer_Helper::activate( $backup_plugin_data );
                    if( $active_response['success'] == true ) {
                        // Active success
                        $message = sprintf( __('Install & active plugin %s successful.', 'jayla'), $backup_plugin_data['name'] );
                    } else {
                        // Active fail
                        $message = sprintf( __('Install & active plugin %s fail.', 'jayla'), $backup_plugin_data['name'] );
                    }
                } else {
                    // Install fail
                    $message = sprintf( __('Install plugin %s fail.', 'jayla'), $backup_plugin_data['name'] );
                }
            } else {
                // Active...
                $active_response = Jayla_Plugin_Installer_Helper::activate( $backup_plugin_data );
                if( $active_response['success'] == true ) {
                    // Active success
                    $message = sprintf( __('Active plugin %s successful.', 'jayla'), $backup_plugin_data['name'] );
                } else {
                    // Active fail
                    $message = sprintf( __('Active plugin %s fail.', 'jayla'), $backup_plugin_data['name'] );
                }
            }

            return array(
                'message' => $message,
                'on_action' => array(
                    'name' => $on_action,
                    'status' => false,
                ),
            );
        }

        $process_child = isset( $extra_params['process_child'] ) ? $extra_params['process_child'] : 'bbackup_backup_database';
        $_extra_params = array();
        $status = false;
        $message = '';

        switch( $process_child ) {

            case 'bbackup_create_file_config':
                $_extra_params = BBACKUP_Create_File_Config($extra_params, '');
                if( $_extra_params['success'] == true ) {
                    $message = sprintf( __( 'Backup — %s', 'jayla' ),  $_extra_params['message'] );
                    $_extra_params['process_child'] = 'bbackup_backup_folder_upload';
                } else {
                    $message = sprintf( __( 'Backup — %s', 'jayla' ),  $_extra_params['message'] );
                }
                break;

            case 'bbackup_backup_folder_upload':
                $_extra_params = BBACKUP_Backup_Folder_Upload($extra_params, '');
                if( $_extra_params['success'] == true ) {
                    $status = true;
                    $message = '<div>' . sprintf( __( 'Backup — %s', 'jayla' ),  $_extra_params['message'] ) . '</div>';
                    $message .= '-------------------------------------------';
                    $message .= '<div>' . __('Backup database and media successful 📦', 'jayla') . '</div>';
                } else {
                    $message = sprintf( __( 'Backup — %s', 'jayla' ),  $_extra_params['message'] );
                }
                break;

            default:
                // bbackup_backup_database
                $_extra_params = BBACKUP_Backup_Database( array(), '' );

                if( $_extra_params['success'] == true ) {
                    $message = sprintf( __( 'Backup — %s', 'jayla' ),  $_extra_params['message'] );
                    $_extra_params['process_child'] = 'bbackup_create_file_config';
                } else {
                    $message = sprintf( __( 'Backup — %s', 'jayla' ),  $_extra_params['message'] );
                }
                break;

        }

        return array(
          'message' => $message,
          'on_action' => array(
            'name' => $on_action,
            'status' => $status,
          ),
          'extra_params' => $_extra_params,
        );
      }
    }

    if(! function_exists('jayla_install_demo__step_install_plugin_include')) {
      /**
       * Install plugin include package demo
       * @since 1.0.0
       *
       */
      function jayla_install_demo__step_install_plugin_include($package_data, $on_action) {
        if( ! isset( $package_data['plugins'] ) || count( $package_data['plugins'] ) <= 0 ) {
          return array(
            'message' => __('Install plugins include successful.', 'jayla'),
            'on_action' => array(
              'name' => $on_action,
              'status' => true,
            )
          );
        } else {
            $count_plugin_include = count( $package_data['plugins'] );
            $number_active_plugin = 0;
            $message = '';
            do_action( 'jayla_install_demo_one_click_before_install_plugin' );

            foreach($package_data['plugins'] as $plugin) {

                if(! Jayla_Plugin_Installer_Helper::is_installed( $plugin )) {
                    // Install...
                    $install_response = Jayla_Plugin_Installer_Helper::install( $plugin );
                    if( $install_response['success'] == true ) {
                        $message = sprintf( __('Install plugin %s successful.', 'jayla'), $plugin['name'] );
                        /*
                        // Active...
                        $active_response = Jayla_Plugin_Installer_Helper::activate( $plugin );

                        if( $active_response['success'] == true ) {
                            // Active success
                            $message = sprintf( __('Install & active plugin %s successful.', 'jayla'), $plugin['name'] );
                        } else {
                            // Active fail
                            $message = sprintf( __('Install & active plugin %s fail.', 'jayla'), $plugin['name'] );
                        }
                        */
                    } else {
                        // Install fail
                        $message = sprintf( __('Install plugin %s fail.', 'jayla'), $plugin['name'] );
                    }

                    break;
                } else {
                    // Active...
                    if( ! Jayla_Plugin_Installer_Helper::is_active($plugin) ) {
                        $active_response = Jayla_Plugin_Installer_Helper::activate( $plugin );
                        if( $active_response['success'] == true ) {
                            // Active success
                            $message = sprintf( __('Active plugin %s successful.', 'jayla'), $plugin['name'] );
                        } else {
                            // Active fail
                            $message = sprintf( __('Active plugin %s fail.', 'jayla'), $plugin['name'] );
                        }

                        break;
                    }
                }

                $number_active_plugin += 1;
            }

            if($number_active_plugin == $count_plugin_include) {
                return array(
                    'message' => sprintf( '-------------------------------------------<div>%s</div>', __('Install all plugins include successful.', 'jayla') ),
                    'on_action' => array(
                    'name' => $on_action,
                    'status' => true,
                    )
                );
            } else {
                return array(
                    'message' => sprintf( '-------------------------------------------<div>%s</div>', $message ),
                    'on_action' => array(
                    'name' => $on_action,
                    'status' => false,
                    )
                );
            }
        }
      }
    }

    if(! function_exists('jayla_install_demo__step_download_package_demo')) {
        /**
         * Download package demo
         * @since 1.0.0
         *
         */
        function jayla_install_demo__step_download_package_demo($package_data, $on_action, $extra_params = array()) {
            extract($package_data);
            $position_download = 0;
            $path_file_package = '';
            $download_package_success = false;

            if( isset( $extra_params['x_position'] ) ) {
                $position_download = $extra_params['x_position'];
                $path_file_package = $extra_params['path_file_package'];
            }

            $result = jayla_download_package_demo__step_package_download_step($package_name, $position_download, $path_file_package);

            if( isset( $result['download_package_success'] ) && $result['download_package_success'] == true ) {
                $download_package_success = true;
            }

            wp_send_json_success( array(
                'message' => $result['message'], // __('Download package...', 'jayla'),
                'extra_params' => $result,
                'on_action' => array(
                    'name' => $on_action,
                    'status' => $download_package_success,
                ),
            ) );
            exit();
        }
    }

    if(! function_exists('jayla_install_demo__step_extract_package_demo')) {
        /**
         * @since 1.0.0
         * Extract package demo
         *
         */
        function jayla_install_demo__step_extract_package_demo($package_data, $on_action, $extra_params = array()) {
            global $Bears_Backup;
            $backup_path = $Bears_Backup->upload_path();
            $extract_to = $backup_path . '/' . sprintf( 'package-install__%s', $package_data['package_name'] );

            if ( ! wp_mkdir_p( $extract_to ) ) {
                return array(
                    'message' => __('Extract package demo fail.', 'jayla'),
                    'on_action' => array(
                        'name' => $on_action,
                        'status' => false,
                    ),
                );
            }

            if( isset( $extra_params['path_file_package'] ) ) {
                $zipFile = new \PhpZip\ZipFile();
                $zipFile
                ->openFile( $extra_params['path_file_package'] )
                ->extractTo( $extract_to )
                ->close();

                // remove zip file
                wp_delete_file( $extra_params['path_file_package'] );

                return array(
                    'message' => sprintf( '-------------------------------------------<div>%s</div>', __('Extract package demo successful.', 'jayla') ),
                    'on_action' => array(
                        'name' => $on_action,
                        'status' => true,
                    ),
                    'extra_params' => array(
                        'package_demo_path' => $extract_to,
                    ),
                );
            } else {
                return array(
                    'message' => sprintf( '-------------------------------------------<div>%s</div>', __('Not found package demo ⚠️, please reload browser and try install again. Thank you!', 'jayla') ),
                    'on_action' => array(
                        'name' => $on_action,
                        'status' => false,
                        'root_status' => false,
                    ),
                );
            }
        }
    }

    if(! function_exists('jayla_install_demo__step_import_package_demo')) {
        /**
         * @since 1.0.0
         * Import demo
         *
         */
        function jayla_install_demo__step_import_package_demo($package_data, $on_action, $extra_params = array()) {

            $args = array(
                'name' => basename($extra_params['package_demo_path']),
                'backup_path_file' => $extra_params['package_demo_path'],
            );
            $result = BBACKUP_Restore_Data( $args, '' );

            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            // delete package folder
            $wp_filesystem->delete( $extra_params['package_demo_path'] , true );

            if( isset($result['success']) && $result['success'] == true ) {
                return array(
                    'message' => sprintf( '-------------------------------------------<div>%s</div>', __('Install package demo successful. 👌', 'jayla') ),
                    'on_action' => array(
                        'name' => $on_action,
                        'status' => true,
                    ),
                    'extra_params' => $result,
                );
            } else {
                return array(
                    'message' => sprintf( '-------------------------------------------<div>%s</div>', __('Install package demo false 😢! Please try again in a few minutes or contact our support team. Thank you!', 'jayla') ),
                    'on_action' => array(
                        'name' => $on_action,
                        'status' => false,
                    ),
                    'extra_params' => $result,
                );
            }
        }
    }

    if(! function_exists('jayla_download_package_demo__step_get_url_package_download'))
    {
        /**
         * Build url download package demo
         * @since 1.0.0
         *
         */
        function jayla_download_package_demo__step_get_url_package_download($package_name = null, $position = 0, $size = 0)
        {
            global $jayla;
            $remote_url = $jayla->conf_required['download_package_url'];

            $size = ( $size ) ? '&size=' . $size : '';
            return sprintf( '%s?id=%s&position=%d' . $size, $remote_url, $package_name, $position );
        }
    }

    if(! function_exists('jayla_download_package_demo__step_get_remote_file_head'))
    {
        /**
         * Get head request url
         * @since 1.0.0
         *
         */
        function jayla_download_package_demo__step_get_remote_file_head($remote_url)
        {
            $head = array_change_key_case(get_headers($remote_url, TRUE));
            return $head;
        }
    }

    if(! function_exists('jayla_download_package_demo__step_package_download_step'))
    {
        /**
         *
         * @since 1.0.0
         */
        function jayla_download_package_demo__step_package_download_step($package_name, $position = 0, $path_file_package = '')
        {
            $remote_url = jayla_download_package_demo__step_get_url_package_download( $package_name, $position );
            if( !$position ) {
                // step 0 create zip file
                $response = jayla_download_package_demo__step_package_download_step_init( $remote_url, 'package-demo.zip' );
            } else {
                // any step push data
                $response = jayla_download_package_demo__step_push_data( $remote_url, $position, $path_file_package );
            }
            return $response;
        }
    }

    if(! function_exists('jayla_download_package_demo__step_package_download_step_init'))
    {
        /**
         * @since 1.0.0
         * Create package file (.zip)
         *
         */
        function jayla_download_package_demo__step_package_download_step_init( $remote_url, $file_name )
        {
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            $upload_dir = wp_upload_dir();
            $path = $upload_dir['path'];
            $path_file = $path . '/' . $file_name;

            $head = jayla_download_package_demo__step_get_remote_file_head( $remote_url );
            $content = $wp_filesystem->get_contents($remote_url);

            $mb = 1000 * 1000;
            $download = number_format($head['x-position'] / $mb, 1);
            $total = number_format($head['x-filesize'] / $mb, 1);

            if( $wp_filesystem->put_contents( $path_file, $content ) ) {

                return array(
                    'message' => '-------------------------------------------<div>' . sprintf( __( 'Downloading package — %s Mb / %s Mb (total)', 'jayla' ) , $download, $total ) . '</div>',
                    'path_file_package' => $path_file,
                    'x_position' => $head['x-position'],
                );
            }
        }
    }

    if(! function_exists('jayla_download_package_demo__step_push_data'))
    {
        /**
         * @since 1.0.0
         * Push data download package
         */
        function jayla_download_package_demo__step_push_data( $remote_url, $position, $path_file_package ) {
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            $head = jayla_download_package_demo__step_get_remote_file_head( $remote_url );
            $content = $wp_filesystem->get_contents($remote_url);

            // if( isset( $head['content-length'] ) && $head['content-length'] == 0 ) {
            if( isset( $head['x-position'] ) && $head['x-position'] == -1 ) {
                return array(
                    'download_package_success' => true,
                    'message' => sprintf( '-------------------------------------------<div>%s</div>', __('Download package successful.', 'jayla') ),
                    'remote_url' => $remote_url,
                    'path_file_package' => $path_file_package,
                );
            }

            $mb = 1000 * 1000;
            $download = number_format($head['x-position'] / $mb, 1);

            if( BBACKUP_Helper_Function_File_Appent_Content($path_file_package, $content) ) {
                return array(
                    'message' => sprintf( __( 'Downloading package — %s Mb', 'jayla' ), $download ),
                    'path_file_package' => $path_file_package,
                    'remote_url' => $remote_url,
                    'x_position' => $head['x-position'],
                );
            }
        }
    }

    if(! function_exists('jayla_install_package_one_click_active_multi_plugin_helpers')) {
        function jayla_install_package_one_click_active_multi_plugin_helpers() {
            $_GET['activate-multi'] = true;
            add_filter( 'tinvwl_prevent_automatic_wizard_redirect', 'jayla_tinvwl_prevent_automatic_wizard_redirect_disable' );
        }
    }

    if(! function_exists('jayla_tinvwl_prevent_automatic_wizard_redirect_disable')) {
        function jayla_tinvwl_prevent_automatic_wizard_redirect_disable() {
            return true;
        }
    }
}
