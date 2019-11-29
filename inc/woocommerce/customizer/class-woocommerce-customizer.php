<?php
/**
 * Theme Customizer Class
 *
 * @author   Bearsthemes
 * @package  jayla
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Jayla_WooCommerce_Customizer' ) ) :
  class Jayla_WooCommerce_Customizer {

    /**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
    function __construct() {
		add_action( 'customize_register',              array( $this, 'customize_register' ), 11 );
		add_filter( 'jayla_setting_default_values',    array( $this, 'woocommerce_default_settings' ), 11 );
		add_filter( 'jayla_theme_customize_object_localize_script',    array( $this, 'woocommerce_customize_object_localize_script' ), 11 );
	}

	/**
	 * Woo get settings
	 * @since 1.0.0
	 */
	static public function get_settings() {
		return jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
	}

	/**
	 * Woo filter return default setting
	 * @since 1.0.0
	 */
	static public function woocommerce_default_settings($data) {
		// $jayla_woocommerce_settings = jayla_woo_settings_default();
		$data['jayla_woocommerce_settings'] = wp_json_encode(jayla_woo_settings_default());
		return $data;
	}

	/**
	 * Woo return object localize scrip
	 * @since 1.0.0
	 */
	static public function woocommerce_customize_object_localize_script($data) {
		$jayla_woocommerce_settings = Jayla_WooCommerce_Customizer::get_settings();
		$data['jayla_woocommerce_settings'] = $jayla_woocommerce_settings;

		return $data;
	}

	/**
	 * Custom register
	 * @since 1.0.0
	 */
    static public function customize_register( $wp_customize ) {
		require_once dirname( __FILE__ ) . '/class-woocommerce-control.php';

      	{
        /**
         * WooCommerce
         */

		$wp_customize->add_setting( 'jayla_woocommerce_settings', array(
			'default' => '',
			// 'transport' => 'postMessage',
		), array( 'sanitize_callback' => '__return_false' ) );

        /* WooCommerce section */
		$wp_customize->add_section('jayla_woocommerce_shop_section', array(
	        'title'    => __('🛒 WooCommerce', 'jayla'),
	        'description' => __( '', 'jayla' ),
	        'priority' => 28,
		));

		if(class_exists('Jayla_WooCommerce_Control')) {
			$wp_customize->add_control( new Jayla_WooCommerce_Control( $wp_customize, 'jayla_woocommerce_control', array(
				'section'  => 'jayla_woocommerce_shop_section',
				'priority' => 10,
				'settings' => array(
					'woocommerce_settings' => 'jayla_woocommerce_settings',
				),
			) ) );
		}
      }
    }

  }
endif;

return new Jayla_WooCommerce_Customizer();
