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

if ( ! class_exists( 'Jayla_Jetpack_Portfolio_Customizer' ) ) :
  class Jayla_Jetpack_Portfolio_Customizer {

    /**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
    function __construct() {
		add_action( 'customize_register',              array( $this, 'customize_register' ), 11 );
		add_filter( 'jayla_setting_default_values',    array( $this, 'jetpack_portfolio_default_settings' ), 11 );
		add_filter( 'jayla_theme_customize_object_localize_script',    array( $this, 'jetpack_portfolio_customize_object_localize_script' ), 11 );
	}

	/**
	 * Woo get settings
	 * @since 1.0.0
	 */
	static public function get_settings() {
		return jayla_get_option_type_json('jayla_jetpack_portfolio_settings', 'jayla_jetpack_portfolio_settings_default');
	}

	/**
	 * Woo filter return default setting
	 * @since 1.0.0
	 */
	static public function jetpack_portfolio_default_settings($data) {
		$data['jayla_jetpack_portfolio_settings'] = wp_json_encode(jayla_jetpack_portfolio_settings_default());
		return $data;
	}

	/**
	 * Woo return object localize scrip
	 * @since 1.0.0
	 */
	static public function jetpack_portfolio_customize_object_localize_script($data) {
		$jayla_jetpack_portfolio_settings = Jayla_Jetpack_Portfolio_Customizer::get_settings();
		$jayla_jetpack_portfolio_settings['archive_layou_allow_grid_col_settings'] = jayla_jetpack_portfolio_archive_layout_allow_furygrid();
		$data['jayla_jetpack_portfolio_settings'] = $jayla_jetpack_portfolio_settings;

		return $data;
	}

	/**
	 * Custom register
	 * @since 1.0.0
	 */
    static public function customize_register( $wp_customize ) {
		require_once dirname( __FILE__ ) . '/class-jetpack-portfolio-control.php';

      	{
        /**
         * WooCommerce
         */

		$wp_customize->add_setting( 'jayla_jetpack_portfolio_settings', array(
			'default' => '',
			// 'transport' => 'postMessage',
		), array( 'sanitize_callback' => '__return_false' ) );

        /* WooCommerce section */
		$wp_customize->add_section('jayla_jetpack_portfolio_section', array(
	        'title'    => __('Portfolio', 'jayla'),
	        'description' => __( '', 'jayla' ),
	        'priority' => 29,
		));

		if(class_exists('Jayla_jetpack_portfolio_Control')) {
			$wp_customize->add_control( new Jayla_Jetpack_Portfolio_Control( $wp_customize, 'jayla_jetpack_portfolio_control', array(
				'section'  => 'jayla_jetpack_portfolio_section',
				'priority' => 10,
				'settings' => array(
					'jetpack_portfolio_settings' => 'jayla_jetpack_portfolio_settings',
				),
			) ) );
		}
      }
    }

  }
endif;

return new Jayla_Jetpack_Portfolio_Customizer();
