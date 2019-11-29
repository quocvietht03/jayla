<?php 
global $jayla;
$jayla_config = $jayla->conf_required;

$jayla_memory = jayla_return_memory_size( WP_MEMORY_LIMIT );
$jayla_requirements_wp_memory_limit = jayla_return_memory_size($jayla_config['memory_limit']);
$jayla_memory_st = ($jayla_memory >= $jayla_requirements_wp_memory_limit) ? 'pass' : 'no_pass';

$jayla_server_software = ( function_exists('jayla_return_server_software') ) ? jayla_return_server_software() : '????????????';

// php version
if ( function_exists( 'phpversion' ) ) {
    $jayla_phpversion_st = ( version_compare(phpversion(), $jayla_config['php_version'], '<=') ) ? 'no_pass' : 'pass';
} else{
	$jayla_phpversion_st = 'no_php_installed';
}

// php post max size
$jayla_requirements_post_max_size = jayla_return_memory_size($jayla_config['php_post_max_size']);
if ( jayla_return_memory_size( ini_get('post_max_size') ) < $jayla_requirements_post_max_size ) {
	$jayla_php_post_max_size_st = 'no_pass';
} else{ 
    $jayla_php_post_max_size_st = 'pass';
}

// php time limit
$jayla_time_limit = ini_get('max_execution_time');
$jayla_required_php_time_limit = (int)$jayla_config['php_time_limit'];
if ( $jayla_time_limit < $jayla_required_php_time_limit && $jayla_time_limit != 0 ) {
	$jayla_required_php_time_limit_st = 'no_pass';
} else {
	$jayla_required_php_time_limit_st = 'pass';
}

// php max input vars
$jayla_max_input_vars = ini_get('max_input_vars');
$jayla_required_input_vars = $jayla_config['php_max_input_vars'];
if ( $jayla_max_input_vars < $jayla_required_input_vars ) {
	$jayla_required_input_vars_st = 'no_pass';
} else {
	$jayla_required_input_vars_st = 'pass';
}

// suhosin
if( extension_loaded( 'suhosin' ) ) {
	$jayla_suhosin_install_st = 'yes';
} else {
	$jayla_suhosin_install_st = 'no';
}

// ZipArchive
if( class_exists( 'ZipArchive' ) ) {
    $jayla_zip_archive_install_st = 'yes';
} else {
    $jayla_zip_archive_install_st = 'no';
}

// mysql version
global $wpdb;
if( version_compare($wpdb->db_version(), $jayla_config['mysql_version'], '<=') ){
	$jayla_required_mysql_version_st = 'no_pass';
} else{
	$jayla_required_mysql_version_st = 'pass';
}

// max upload size
$jayla_requirements_max_upload_size = jayla_return_memory_size($jayla_config['max_upload_size']);
if ( wp_max_upload_size() < $jayla_requirements_max_upload_size ) {
    $jayla_requirements_max_upload_size_st = 'no_pass';
} else{
    $jayla_requirements_max_upload_size_st = 'pass';
}

// fsockopen
if( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
	$jayla_requirements_fsockopen_curl_init = 'yes';
}
else{
	$jayla_requirements_fsockopen_curl_init = 'no';
}

$jayla_config_temp = array(
    'memory_limit' => array(
        'no_pass' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('WordPress Memory Limit', 'jayla') . ': ' . size_format($jayla_memory) .'</div>',
                    '<div class="__desc">', 
                        __('The maximum amount of memory (RAM) that your site can use at one time.', 'jayla'),
                        ' ',
                        '<hr />',
                        __('We recommend setting memory to at least', 'jayla'),
                        ' ',
                        size_format($jayla_requirements_wp_memory_limit),
                        __('. Please define memory limit in "wp-config.php" file.', 'jayla'),
                        ' ',
                        '<a href="'. esc_url( 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) .'" target="_blank">'.esc_html__('Learn how to do it', 'jayla' ).'</a>',
                    '</div>',
                '</div>',
            '</li>',
        )),
        'pass' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('WordPress Memory Limit', 'jayla') . ': ' . size_format($jayla_memory) .'</div>',
                    '<div class="__desc">', 
                        __('The maximum amount of memory (RAM) that your site can use at one time.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'phpversion' => array(
        'no_pass' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Version', 'jayla') . ': ' . esc_html( phpversion() ) .'</div>',
                    '<div class="__desc">', 
                        __('The version of PHP installed on your hosting server.', 'jayla'),
                        '<hr />',
                        __('We recommend you update PHP to the latest version. The minimum required version for this theme is:', 'jayla'),
                        ' ', 
                        $jayla_config['php_version'],
                        ' .',
                        __('Contact your hosting provider, they can install it for you.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
        'pass' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Version', 'jayla') . ': ' . esc_html( phpversion() ) .'</div>',
                    '<div class="__desc">', 
                        __('The version of PHP installed on your hosting server', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
        'no_php_installed' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Version', 'jayla') . ': ' . __('No PHP Installed', 'jayla') .'</div>',
                    '<div class="__desc">', 
                        '...',
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'php_post_max_size' => array(
        'no_pass' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Post Max Size', 'jayla') . ': ' . size_format(jayla_return_memory_size( ini_get('post_max_size') ) ) .'</div>',
                    '<div class="__desc">', 
                        __('The largest file size that can be contained in one post.', 'jayla'),
                        '<hr />',
                        __('We recommend setting the post maximum size to at least:', 'jayla'),
                        ' ', 
                        size_format($jayla_requirements_post_max_size),
                        '. ',
                        '<a href="'. esc_url( '#' ) .'" target="_blank">'.__('Learn how to do it', 'jayla').'</a>',
                    '</div>',
                '</div>',
            '</li>',
        )),
        'pass' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Post Max Size', 'jayla') . ': ' . size_format( jayla_return_memory_size( ini_get('post_max_size') ) ) .'</div>',
                    '<div class="__desc">', 
                        __('The largest file size that can be contained in one post.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        ))
    ),
    'php_time_limit' => array(
        'no_pass' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Time Limit', 'jayla') . ': ' . $jayla_time_limit .'</div>',
                    '<div class="__desc">', 
                        __('The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).', 'jayla'),
                        '<hr />',
                        __('We recommend setting the maximum execution time to at least', 'jayla'),
                        ' ', 
                        $jayla_required_php_time_limit,
                        '. ',
                        '<a href="'. esc_url( 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) .'" target="_blank">'.__('Learn how to do it','jayla').'</a>',
                    '</div>',
                '</div>',
            '</li>',
        )),
        'pass' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Time Limit', 'jayla') . ': ' . $jayla_time_limit .'</div>',
                    '<div class="__desc">', 
                        __('The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'php_max_input_vars' => array(
        'no_pass' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Max Input Vars', 'jayla') . ': ' . $jayla_max_input_vars .'</div>',
                    '<div class="__desc">', 
                        __('The maximum number of variables your server can use for a single function to avoid overloads.', 'jayla'),
                        '<hr />',
                        __('Please increase the maximum input variables limit to:', 'jayla'),
                        ' ', 
                        $jayla_required_input_vars,
                        '. ',
                        '<a href="'. esc_url( '#' ) .'" target="_blank">'.__('Learn how to do it','jayla').'</a>',
                    '</div>',
                '</div>',
            '</li>',
        )),
        'pass' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('PHP Max Input Vars', 'jayla') . ': ' . $jayla_max_input_vars .'</div>',
                    '<div class="__desc">', 
                        __('The maximum number of variables your server can use for a single function to avoid overloads.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'SUHOSIN_installed' => array(
        'yes' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('SUHOSIN Installed', 'jayla') . ': ' . __('Yes', 'jayla') .'</div>',
                    '<div class="__desc">', 
                        __('Suhosin is an advanced protection system for PHP installations and may need to be configured to increase its data submission limits.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
        'no' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('SUHOSIN Installed', 'jayla') . ': ' . __('No', 'jayla') .'</div>',
                    '<div class="__desc">', 
                        __('Suhosin is an advanced protection system for PHP installations.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'zip_archive' => array(
        'yes' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('ZipArchive', 'jayla') . ': ' . __('Yes', 'jayla') .'</div>',
                    '<div class="__desc">', 
                        __('ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
        'no' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('ZipArchive', 'jayla') . ': ' . __('No', 'jayla') .'</div>',
                    '<div class="__desc">', 
                        __('ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'jayla'),
                        '<hr />',
                        __('Contact your hosting provider, they can install it for you.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'mysql_version' => array(
        'no_pass' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('MySQL Version', 'jayla') . ': ' . $wpdb->db_version() .'</div>',
                    '<div class="__desc">', 
                        __('The version of MySQL installed on your hosting server.', 'jayla'),
                        '<hr />',
                        __('We recommend you update MySQL to the latest version. The minimum required version for this theme is:', 'jayla'),
                        ' ', 
                        $jayla_config['mysql_version'],
                        '. ',
                        __('Contact your hosting provider, they can install it for you.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
        'pass' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('MySQL Version', 'jayla') . ': ' . $wpdb->db_version() .'</div>',
                    '<div class="__desc">', 
                        __('The version of MySQL installed on your hosting server.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'max_upload_size' => array(
        'no_pass' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('Max Upload Size', 'jayla') . ': ' . size_format(wp_max_upload_size()) .'</div>',
                    '<div class="__desc">', 
                        __('The largest file size that can be uploaded to your WordPress installation.', 'jayla'),
                        '<hr />',
                        __('We recommend setting the maximum upload file size to at least:', 'jayla'),
                        ' ', 
                        size_format($jayla_requirements_max_upload_size),
                        '. ',
                        '<a href="'. esc_url('#', 'jayla') .'" target="_blank">'.__('Learn how to do it', 'jayla').'</a>',
                    '</div>',
                '</div>',
            '</li>',
        )),
        'pass' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('Max Upload Size', 'jayla') . ': ' . size_format(wp_max_upload_size()) .'</div>',
                    '<div class="__desc">', 
                        __('The largest file size that can be uploaded to your WordPress installation.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
    ),
    'fsockopen_cURL' => array(
        'no' => implode('', array(
            '<li class="__item __bg-error">',
                '<span class="__icon"><div class="__icon-ui i-multiply"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('fsockopen/cURL', 'jayla') . ': ' . __('No', 'jayla') .'</div>',
                    '<div class="__desc">', 
                        __('Payment gateways can use cURL to communicate with remote servers to authorize payments, other plugins may also use it when communicating with remote services. Your server does not have fsockopen or cURL enabled thus PayPal IPN and other scripts which communicate with other servers will not work. Contact your hosting provider, they can install it for you.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        )),
        'yes' => implode('', array(
            '<li class="__item">',
                '<span class="__icon"><div class="__icon-ui i-checked"></div></span>',
                '<div class="__inner">',
                    '<div class="__title">'. __('fsockopen/cURL', 'jayla') . ': ' . __('Yes', 'jayla') .'</div>',
                    '<div class="__desc">', 
                        __('ayment gateways can use cURL to communicate with remote servers to authorize payments, other plugins may also use it when communicating with remote services.', 'jayla'),
                    '</div>',
                '</div>',
            '</li>',
        ))
    )
);
?>
<el-row :gutter="30">
    <el-col :sm="24" :md="12">
        <div class="theme__list-requirement">

            <?php 
                /**
                 * hook jayla_verify_purchase_code_form.
                 * 
                 * @see jayla_verify_purchase_code_form_html - 10, in theme-fix.php
                 */
                do_action( 'jayla_verify_purchase_code_form' ); 
            ?>

            <h3><?php _e('WordPress Environment', 'jayla'); ?></h3>
            <ul class="theme__check-list">
                <li class="__item">
                    <span class="__icon">
                        <div class="__icon-ui i-checked"></div>
                    </span>
                    <div class="__inner">
                        <div class="__title"><?php echo implode(': ', array(__('Home URL', 'jayla'), get_home_url())); ?></div>
                        <div class="__desc"><?php _e('The URL of your site\'s homepage', 'jayla'); ?></div>
                    </div>
                </li>
                <li class="__item">
                    <span class="__icon">   
                        <div class="__icon-ui i-checked"></div>
                    </span>
                    <div class="__inner">
                        <div class="__title"><?php echo implode(': ', array(__('Site URL', 'jayla'), get_site_url())); ?></div>
                        <div class="__desc"><?php _e('The root URL of your site', 'jayla'); ?></div>
                    </div>
                </li>
                <li class="__item">
                    <span class="__icon">   
                        <div class="__icon-ui i-checked"></div>
                    </span>
                    <div class="__inner">
                        <div class="__title"><?php echo implode(': ', array(__('WordPress Version', 'jayla'), get_bloginfo('version'))); ?></div>
                        <div class="__desc"><?php _e('The version of WordPress installed on your site', 'jayla'); ?></div>
                    </div>
                </li>
                <li class="__item">
                    <span class="__icon">   
                        <div class="__icon-ui <?php echo ( ! is_multisite() ) ? 'i-checked' : 'i-multiply' ?>"></div>
                    </span>
                    <div class="__inner">
                        <div class="__title"><?php echo implode(': ', 
                            array(
                                __('WordPress Multisite', 'jayla'), 
                                ( is_multisite() ) ? 'Yes' : 'No'
                            )); ?></div>
                        <div class="__desc"><?php _e('Whether or not you have WordPress Multisite enabled', 'jayla'); ?></div>
                    </div>
                </li>
                <li class="__item <?php echo ( WP_DEBUG ) ? '__bg-error' : '' ?>">
                    <span class="__icon">   
                        <div class="__icon-ui <?php echo ( ! WP_DEBUG ) ? 'i-checked' : 'i-multiply' ?>"></div>
                    </span>
                    <div class="__inner">
                        <div class="__title"><?php echo implode(': ', 
                            array(
                                __('WordPress Debug Mode', 'jayla'), 
                                ( WP_DEBUG ) ? 'Yes' : 'No',
                            )); ?></div>
                        <div class="__desc"><?php _e('Displays whether or not WordPress is in Debug Mode', 'jayla'); ?></div>
                    </div>
                </li>
                <?php echo implode('', array( $jayla_config_temp['memory_limit'][$jayla_memory_st] )); ?>
            </ul>
        </div>
    </el-col>
    <el-col :sm="24" :md="12">
        <div class="theme__list-requirement">
            <h3><?php _e('Server Environment', 'jayla'); ?></h3>
            <ul class="theme__check-list">
                <li class="__item">
                    <span class="__icon">
                        <div class="__icon-ui i-checked"></div>
                    </span>
                    <div class="__inner">
                        <div class="__title"><?php echo implode(': ', array(__('Server Info', 'jayla'), esc_html( $jayla_server_software     ))); ?></div>
                        <div class="__desc"><?php _e('Information about the web server that is currently hosting your site', 'jayla'); ?></div>
                    </div>
                </li>
                <?php echo implode('', array( $jayla_config_temp['phpversion'][$jayla_phpversion_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['php_post_max_size'][$jayla_php_post_max_size_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['php_time_limit'][$jayla_required_php_time_limit_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['php_max_input_vars'][$jayla_required_input_vars_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['SUHOSIN_installed'][$jayla_suhosin_install_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['zip_archive'][$jayla_zip_archive_install_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['mysql_version'][$jayla_required_mysql_version_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['max_upload_size'][$jayla_requirements_max_upload_size_st] )); ?>
                <?php echo implode('', array( $jayla_config_temp['fsockopen_cURL'][$jayla_requirements_fsockopen_curl_init] )); ?>
            </ul>
        </div>
    </el-col>
</el-row>