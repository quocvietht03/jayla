<?php 
global $jayla;
$jayla_plugins_compatible = $jayla->conf_required['plugins_compatible'];

// jayla_button_action_install_plugin(array(
//     'name' => __('WooCommerce', 'jayla'),
//     'slug' => 'woocommerce',
// ));
?>
<div class="__plugin-compatible-listing" v-loading="ShareStore.DisablePluginCompatibleUi">
    <?php  
    if( empty($jayla_plugins_compatible) || count($jayla_plugins_compatible) <= 0 ) return;
    echo implode( '', array(
        '<el-row :gutter="30">',
    ) );
    foreach($jayla_plugins_compatible as $item) {
        $thumb_src = get_template_directory_uri() . '/assets/images/core/placeholder-plugin-support.jpg';
        if( isset($item['thumbnail']) && ! empty($item['thumbnail']) ) { $thumb_src = $item['thumbnail']; }
        $plugin_data = wp_json_encode( $item );
        echo implode('', array(
            '<el-col :xs="12" :sm="8" :md="6" :lg="6">',
                '<div class="__plugin-compatible-item plg-'. $item['slug'] .'">',
                    '<div class="__inner">',
                        '<div class="thumbnail" style="background: url('. $thumb_src .') no-repeat center center / cover, #222">',
                            '<div class="label">'. $item['name'] .'</div>',
                        '</div>',
                        '<div class="__entry">',
                            '<theme-extends-button-plugin-install plugin=\''. $plugin_data .'\'></theme-extends-button-plugin-install>',
                        '</div>',
                    '</div>',
                '</div>',
            '</el-col>'
        ));
    }
    echo implode( '</el-row>', array(
        ''
    ) );
    ?>
</div>