<?php
/**
 * Jayla WooCommerce Class
 *
 * @package  jayla
 * @author   Bearsthemes
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Jayla_WooCommerce' ) ) :

/**
 * The Jayla WooCommerce Integration class
 */
class Jayla_WooCommerce {

	/**
	 * Setup class.
	 *
	 * @since 1.0
	 */
	public function __construct() {
      	add_filter('jayla_navigation_class', array($this, 'add_class_posts_navigation'));
		add_filter('woocommerce_locate_template', array($this, 'custom_woocommerce_locate_template'), 10, 3);
		add_filter('jayla_heading_bar_display_data', array($this, 'heading_bar_display_data'), 10, 3);
		add_filter('jayla_ordering_comment_field', array($this, 'ordering_comment_field'), 10);

		// product image size
		add_filter( 'woocommerce_get_image_size_thumbnail', 'jayla_woocommerce_custom_image_size_thumbnail' );
		add_filter( 'woocommerce_get_image_size_single', 'jayla_woocommerce_custom_image_size_single' );
		add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'jayla_woocommerce_custom_image_size_gallery_thumbnail' );

		if(class_exists('WC_Quick_View')){
			add_action('wp_head', array($this, 'move_quickview_button_in_loop_product'));
		}

		if(class_exists('BWC_Product_Quick_View')){
			add_action('wp_head', array($this, 'remove_bwc_product_quickview_button_in_loop_product'));
			$this->add_bwc_product_quickview_button_in_loop_product();
		}

		if(class_exists('PrdctfltrInit')) {
			add_filter('prdctfltr_before_ajax_json_send', array($this, 'prdctfltr_before_ajax_json_send'));
		}

		if(function_exists('wc_gateway_ppec')) {
			add_filter('body_class', array($this, 'wc_gateway_ppec_mini_cart_classes'));
		}
	}

    /**
     * Pagination
     */
    public function prdctfltr_before_ajax_json_send($data) {
		$args = apply_filters('jayla_woo_pagination_args', array(
			'type' 	    => 'list',
			'next_text' => sprintf( '%s <i class="ion-android-arrow-forward"></i>', __('Next', 'jayla') ),
			'prev_text' => sprintf( '<i class="ion-android-arrow-back"></i> %s', __('Previous', 'jayla') ),
		));

		ob_start(); the_posts_pagination($args);
		$data['pagination'] = ob_get_clean();

		return $data;
    }

    /**
  	 * add Woo class for navigation
  	 * @since 1.0.0
  	 */
  	function add_class_posts_navigation ($class) {
  		array_push($class, 'woocommerce-pagination');
  		return $class;
  	}

	/**
	 * @since 1.0.0
	 */
	function custom_woocommerce_locate_template($template, $template_name, $template_path) {

		$path = __DIR__ . '/templates';
		$template = (file_exists($path . '/' . $template_name)) ? $path . '/' . $template_name : $template;

		return $template;
	}

	function heading_bar_display_data($data) {
		if(is_product()) { $data = 'false'; }
		return $data;
	}

	function ordering_comment_field($data) {
		if(is_product()) { $data = false; };
		return $data;
	}

	function move_quickview_button_in_loop_product() {
		global $WC_Quick_View;

		remove_action('woocommerce_after_shop_loop_item', array($WC_Quick_View, 'quick_view_button'), 5);
		add_action('jayla_woo_after_loop_thumbnail_link', array($WC_Quick_View, 'quick_view_button'), 15);
	}

	function remove_bwc_product_quickview_button_in_loop_product() {
		global $BWC_Product_Quick_View;
		remove_action('woocommerce_after_shop_loop_item', array($BWC_Product_Quick_View, 'quick_view_button'), 5);
	}

	function add_bwc_product_quickview_button_in_loop_product() {
		global $BWC_Product_Quick_View;
		add_action('jayla_woo_after_loop_thumbnail_link', array($BWC_Product_Quick_View, 'quick_view_button'), 15);
	}

	function wc_gateway_ppec_mini_cart_classes($classes) {
		array_push($classes, 'wc-gateway-ppec-class-style');
		return $classes;
	}
}

endif;

return new Jayla_WooCommerce();
