<?php
$jayla_host_plugin_install      = 'http://beplusthemes.com/install/plugin/';
$jayla_host_package_install     = 'http://beplusthemes.com/install/demo/jayla/';
$jayla_host_live_preview        = 'https://jayla.beplusthemes.com/';
$plugin_demo_general_inc        = array(
    array(
        'name' => __('WP Bakery (Visual Composer page builder)', 'jayla'),
        'slug' => 'js_composer',
        'source' => $jayla_host_plugin_install . 'js_composer.zip',
    ),
    array(
        'name' => __('Revolution Slider', 'jayla'),
        'slug' => 'revslider',
        'source' => $jayla_host_plugin_install . 'revslider.zip',
    ),
    array(
        'name' => __('Bears Element (Visual Composer)', 'jayla'),
        'slug' => 'bears-elements-vc',
        'source' => $jayla_host_plugin_install . 'bears-elements-vc.zip',
    ),
    array(
        'name' => __('Bears Lookbook', 'jayla'),
        'slug' => 'bears-lookbook',
        'source' => $jayla_host_plugin_install . 'bears-lookbook.zip',
    ),
    array(
        'name' => __('WooCommerce', 'jayla'),
        'slug' => 'woocommerce',
    ),
    array(
        'name' => __('WooCommerce PayPal Express Checkout Payment Gateway', 'jayla'),
        'slug' => 'woocommerce-gateway-paypal-express-checkout',
    ),
    array(
        'name' => __('WooCommerce Stripe Payment Gateway', 'jayla'),
        'slug' => 'woocommerce-gateway-stripe',
    ),
    array(
        'name' => __('WooCommerce Wishlist Plugin', 'jayla'),
        'slug' => 'ti-woocommerce-wishlist',
    ),
    array(
        'name' => __('Contact Form 7', 'jayla'),
        'slug' => 'contact-form-7',
    ),
    array(
        'name' => __('Custom Sidebars – Dynamic Widget Area Manager', 'jayla'),
        'slug' => 'custom-sidebars',
    ),
    array(
        'name' => __('DeliPress – Newsletters and Opt-In forms', 'jayla'),
        'slug' => 'delipress',
        'source' => $jayla_host_plugin_install . 'delipress.zip',
    ),
);

return apply_filters( 'jayla_configuration_required_filter', array(
    'memory_limit' => '256M',
    'php_version' => '5.6.0',
    'php_post_max_size' => '128M',
    'php_time_limit' => '1500',
    'php_max_input_vars' => '4000',
    'mysql_version' => '5.6.0',
    'max_upload_size' => '128M',
    'download_package_url' => $jayla_host_package_install,
    'package_demos' => array(
        'jayla-furniture' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-furniture-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'furniture/',
            'package_name' => 'jayla-furniture',
            'label' => __('Jayla — Furniture', 'jayla'),
            'descriptions' => __('Include 2 layout home page demo, blog and product, Lookbook, Portfolio. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-wine' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-wine-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'wine/',
            'package_name' => 'jayla-wine',
            'label' => __('Jayla — Wine', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-tech' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-tech-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'tech/',
            'package_name' => 'jayla-tech',
            'label' => __('Jayla — Tech', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-shoe' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-shoe-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'shoe/',
            'package_name' => 'jayla-shoe',
            'label' => __('Jayla — Shoe', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-jewelry' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-jewelry-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'jewelry/',
            'package_name' => 'jayla-jewelry',
            'label' => __('Jayla — Jewelry', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-handmade' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-handmade-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'handmade/',
            'package_name' => 'jayla-handmade',
            'label' => __('Jayla — Handmade', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-glasses' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-glasses-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'sunglasses/',
            'package_name' => 'jayla-glasses',
            'label' => __('Jayla — Glasses', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-cosmetic' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-cosmetic-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'cosmetic/',
            'package_name' => 'jayla-cosmetic',
            'label' => __('Jayla — Cosmetic', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-clothes' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-clothes-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'clothes/',
            'package_name' => 'jayla-clothes',
            'label' => __('Jayla — Clothes', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-babyclothes' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-babyclothes-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'babyclothes/',
            'package_name' => 'jayla-babyclothes',
            'label' => __('Jayla — Baby Clothes', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
        'jayla-clean' => array(
            'image_preview' => get_template_directory_uri() . '/assets/images/preview/jayla-package-clean-preview.jpg',
            'link_preview' => $jayla_host_live_preview . 'clean/',
            'package_name' => 'jayla-clean',
            'label' => __('Jayla — Clean', 'jayla'),
            'descriptions' => __('One layout home page demo, blog and product. Header and Footer demo layouts', 'jayla'),
            'plugins' => $plugin_demo_general_inc,
        ),
    ),
    'plugins_compatible' => array(
        /**
         * Premium Plugins
         */
        array(
            'name' => __('WP Bakery (Visual Composer page builder)', 'jayla'),
            'slug' => 'js_composer',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/wpbakery-plugin-thumbnail.jpg',
            'source' => $jayla_host_plugin_install . 'js_composer.zip',
        ),
        array(
            'name' => __('Revolution Slider', 'jayla'),
            'slug' => 'revslider',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/revolution-slide-plugin-thumbnail.jpg',
            'source' => $jayla_host_plugin_install . 'revslider.zip',
        ),
        array(
            'name' => __('Essential Grid', 'jayla'),
            'slug' => 'essential-grid',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/essential-grid-plugin-thumbnail.jpg',
            'source' => $jayla_host_plugin_install . 'essential-grid.zip',
        ),
        array(
            'name' => __('Woocommerce Product Filter', 'jayla'),
            'slug' => 'prdctfltr',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/woo-product-filter-premium-thumbnail.jpg',
            'source' => $jayla_host_plugin_install . 'prdctfltr.zip',
        ),
        array(
            'name' => __('Bears Element (Visual Composer)', 'jayla'),
            'slug' => 'bears-elements-vc',
            'source' => $jayla_host_plugin_install . 'bears-elements-vc.zip',
        ),
        array(
            'name' => __('Bears Backup', 'jayla'),
            'slug' => 'bears-backup',
            'source' => $jayla_host_plugin_install . 'bears-backup.zip',
        ),
        array(
            'name' => __('Bears Social Sharing', 'jayla'),
            'slug' => 'bears-social-sharing',
            'source' => $jayla_host_plugin_install . 'bears-social-sharing.zip',
        ),
        array(
            'name' => __('Bears Mega Menu', 'jayla'),
            'slug' => 'bears-megamenu',
            'source' => $jayla_host_plugin_install . 'bears-megamenu.zip',
        ),
        array(
            'name' => __('Bears Product Quick View (WooCommerce)', 'jayla'),
            'slug' => 'bears-woocommerce-product-quick-view',
            'source' => $jayla_host_plugin_install . 'bears-woocommerce-product-quick-view.zip',
        ),
        array(
            'name' => __('Bears Lookbook', 'jayla'),
            'slug' => 'bears-lookbook',
            'source' => $jayla_host_plugin_install . 'bears-lookbook.zip',
        ),
        array(
            'name' => __('WooCommerce Variation Swatches & Photos', 'jayla'),
            'slug' => 'woocommerce-variation-swatches-and-photos',
            'source' => $jayla_host_plugin_install . 'woocommerce-variation-swatches-and-photos.zip',
        ),
        array(
            'name' => __('Bears WooCommerce Swatches on Product Listing Page', 'jayla'),
            'slug' => 'bears-woocommerce-swatches-on-product-listing-page',
            'source' => $jayla_host_plugin_install . 'bears-woocommerce-swatches-on-product-listing-page.zip',
        ),
        array(
            'name' => __('WooCommerce Product Bundles', 'jayla'),
            'slug' => 'woocommerce-product-bundles',
            'source' => $jayla_host_plugin_install . 'woocommerce-product-bundles.zip',
        ),

        /**
         * WordPress Plugins
         */
        array(
            'name' => __('Contact Form 7', 'jayla'),
            'slug' => 'contact-form-7',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/contact-form-7-plugin-thumbnail.jpg',
        ),
        array(
            'name' => __('Custom Sidebars – Dynamic Widget Area Manager', 'jayla'),
            'slug' => 'custom-sidebars',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/customsidebars-plugin-thumbnail.jpg',
        ),
        // array(
        //     'name' => __('DeliPress – Newsletters and Opt-In forms', 'jayla'),
        //     'slug' => 'delipress',
        //     'thumbnail' => get_template_directory_uri() . '/assets/images/core/delipress-plugin-thumbnail.jpg',
        // ),
        array(
            'name' => __('Jetpack by WordPress.com', 'jayla'),
            'slug' => 'jetpack',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/jetpack-plugin-thumbnail.jpg',
        ),
        array(
            'name' => __('Yoast SEO', 'jayla'),
            'slug' => 'wordpress-seo',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/yoastseo-plugin-thumbnail.jpg',
        ),
        array(
            'name' => __('TinyMCE Advanced', 'jayla'),
            'slug' => 'tinymce-advanced',
        ),
        array(
            'name' => __('WooCommerce', 'jayla'),
            'slug' => 'woocommerce',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/woocommerce-thumbnail-thumbnail.jpg',
        ),
        array(
            'name' => __('WooCommerce PayPal Express Checkout Payment Gateway', 'jayla'),
            'slug' => 'woocommerce-gateway-paypal-express-checkout',
        ),
        array(
            'name' => __('WooCommerce Stripe Payment Gateway', 'jayla'),
            'slug' => 'woocommerce-gateway-stripe',
        ),
        array(
            'name' => __('WooCommerce Wishlist Plugin', 'jayla'),
            'slug' => 'ti-woocommerce-wishlist',
        ),
        array(
            'name' => __('WP Fastest Cache', 'jayla'),
            'slug' => 'wp-fastest-cache',
            'thumbnail' => get_template_directory_uri() . '/assets/images/core/fastest-cache-plugin-thumbnail.jpg',
        ),
    )
) );
