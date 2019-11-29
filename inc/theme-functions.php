<?php
/**
 * remove emoji script
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);

if(! function_exists('jayla_add_custom_width_container_large')) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_add_custom_width_container_large() {
    $options = jayla_get_option_type_json('jayla_global_settings', 'jayla_global_settings_default');
    
    if( ! empty($options) && isset($options['layout']) && isset($options['layout']['custom_width_container_large']) ) {
      $custom_css = '#page .container-large{ max-width: '. $options['layout']['custom_width_container_large'] .'px; }';
      wp_add_inline_style( 'jayla-style', $custom_css );
    }
  }
}

if ( ! function_exists( 'jayla_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function jayla_is_woocommerce_activated() {
    return class_exists('WooCommerce');
	}
}

if ( ! function_exists( 'jayla_is_wpbakery_activated' ) ) {
	/**
	 * Query WPBakery activation
	 */
	function jayla_is_wpbakery_activated() {
    return class_exists('Vc_Manager');
	}
}

if ( ! function_exists( 'jayla_is_delipress_activated' ) ) {
	/**
	 * Query Delipress activation
	 */
	function jayla_is_delipress_activated() {
    return class_exists('Delipress');
	}
}

if(! function_exists('jayla_is_blog')) {
  /**
   * @since 1.0.0
   * check is blog page
   */
  function jayla_is_blog () {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
  }
}

if(! function_exists('jayla_render_scss')) {
  /**
   * scss compile
   * @since 1.0.0
   *
   * @param $input_file   - scss main file
   * @param $output_file  - css output file
   * @param $import_path  - http://leafo.net/scssphp/docs/#import_paths
   */
  function jayla_render_scss($input_file = null, $output_file = null, $import_path = null) {
    /* work on WP_DEBUG true */
    if(WP_DEBUG != true || class_exists('Leafo\ScssPhp\Compiler') != true) return;

    global $wp_filesystem;
		if( empty( $wp_filesystem ) ) {
      require_once(ABSPATH . 'wp-admin/includes/file.php');
	    WP_Filesystem();
		}

    $scss = new Leafo\ScssPhp\Compiler();
    $scss->setVariables(apply_filters( 'jayla_scss_variables', array() ));
    $scss->setFormatter("Leafo\ScssPhp\Formatter\Compressed");
    $scss->setImportPaths($import_path);

		$chmod_dir = ( 0755 & ~ umask() );
		if ( defined( 'FS_CHMOD_DIR' ) ) {
	  	$chmod_dir = FS_CHMOD_DIR;
		}

    $scss_content = $scss->compile(apply_filters('jayla_scss_content', $wp_filesystem->get_contents( $input_file )));
    $wp_filesystem->put_contents( $output_file, $scss_content, $chmod_dir );
  }
}

if(! function_exists('jayla_array_merge_recursive')) {
  /**
   * @since 1.0.0
   */
  function jayla_array_merge_recursive(array & $array1, array & $array2) {
    $merged = $array1;

    foreach ($array2 as $key => & $value)
    {
      if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
        $merged[$key] = jayla_array_merge_recursive($merged[$key], $value);
      } else if (is_numeric($key)) {
        if (!in_array($value, $merged))
          $merged[] = $value;
      } else
        $merged[$key] = $value;
    }

    return $merged;
  }
}

if(! function_exists('jayla_get_option_type_json')) {
  /**
   * @since 1.0.0
   * Get custumize options
   *
   * @param {string} $name
   * @param {string} $default_fn
   *
   * @return
   */
  function jayla_get_option_type_json($name = '', $default_fn = '') {
    $options = json_decode(get_theme_mod($name), true);

    if( ! empty($default_fn) && function_exists($default_fn) ) {
      $options_default	= call_user_func($default_fn);
			$options = ! empty( $options ) ? $options : $options_default;

      return array_replace_recursive($options_default, $options);
    }

    return $options;
  }
}

if(! function_exists('jayla_header_builder_layout_default')) {
  /**
   * @since 1.0.0
   * Set default header layout
   */
  function jayla_header_builder_layout_default() {
    $header_layouts = include( dirname(__FILE__) . '/data-core/header/header-layout-default.php' );
    return $header_layouts;
  }
}

if(! function_exists('jayla_footer_builder_layout_default')) {
  /**
   * Set default footer layout
   */
  function jayla_footer_builder_layout_default() {
    $footer_layouts = include( dirname(__FILE__) . '/data-core/footer/footer-layout-default.php' );
    return $footer_layouts;
  }
}

if(! function_exists('jayla_global_settings_default')) {
	/**
	 * global settings default
	 */
	function jayla_global_settings_default() {
    return apply_filters('jayla_global_settings', array(
			'layout' => array(
        'container_width' => 'large', /* fluid - large - medium */
        'custom_width_container_large' => 1230,
				'layout' => 'default',
				'nav_toogle' => 'no',
			),
			'sidebar' => array(
				'layout' => 'right-sidebar',
				'sticky' => 'no',
			),
			'pagination' => array(
				'layout' => 'default',
			),
			'scroll_top' => array(
				'show' => 'no',
      ),
      'loading_top_bar' => array(
        'show' => 'no',
        'color' => '#00ffaa',
      )
    ));
	}
}

if(! function_exists('jayla_blog_settings_default')) {
  /**
   * @since 1.0.0
   * Blog customize settings default
   *
   * @return {array}
   */
  function jayla_blog_settings_default() {
    return apply_filters( 'jayla_blog_settings_default_filter', array(
      'archive' => array(
        'layout' => 'clean', // default, grid
        'layout_grid_col' => 3,
        'layout_grid_col_tablet' => 2,
        'layout_grid_col_mobile' => 1,
        'layout_grid_first_post_impressive' => 'yes',
        'layout_grid_category_filter_bar' => 'no',
        'layout_grid_category_filter_bar_style' => 'inline', // inline, select
      ),
      'detail' => array(
        'layout' => 'clean', // default, content center
        'post_headings' => 'no',
        'navigation' => 'yes',
        'post_related' => 'no',
        'post_related_image_placeholder' => 'no',
        'post_related_limit' => 5,
      )
    ) );
  }
}

if(! function_exists('jayla_blog_single_layouts')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_blog_single_layouts() {
    return apply_filters( 'jayla_blog_single_layouts_filter', array(
      'clean' => array(
        'label' => __('Block entry content', 'jayla'),
        'path_template' => 'templates/post/single_clean',
      ),
      'default' => array(
        'label' => __('Sticky entry meta', 'jayla'),
        'path_template' => 'templates/post/single',
      ),
      'content-center' => array(
        'label' => __('Sticky entry meta - no sidebar', 'jayla'),
        'path_template' => 'templates/post/single',
      ),
    ) );
  }
}

if(! function_exists('jayla_blog_archive_layouts')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_blog_archive_layouts() {
    return apply_filters( 'jayla_blog_archive_layouts_filter', array(
      'clean' => array(
        'label' => __('Block entry content', 'jayla'),
        'path_template' => 'templates/post/archive_clean',
      ),
      'default' => array(
        'label' => __('Default', 'jayla'),
        'path_template' => 'templates/post',
      ),
      'grid' => array(
        'label' => __('Grid - Masonry', 'jayla'),
        'path_template' => 'templates/post',
      ),
    ) );
  }
}

if(! function_exists('jayla_header_widget_default')) {
  /**
   * header widget element
   * @since 1.0.0
   */
  function jayla_header_widget_default() {
    return array(
      array(
        'element' => 'widget',
        'name' => 'logo',
        'title' => __('Logo', 'jayla'),
        'icon' => 'ion-android-bookmark',
        'description' => __('brand your representation' ,'jayla'),
      ),
      array(
        'element' => 'widget',
        'name' => 'primary-navigation',
        'title' => __('Primary Navigation', 'jayla'),
        'icon' => 'ion-navicon-round',
        'description' => __('Primary menu' ,'jayla'),
      ),
      array(
        'element' => 'widget',
        'name' => 'secondary-navigation',
        'title' => __('Secondary Navigation', 'jayla'),
        'icon' => 'ion-navicon-round',
        'description' => __('Secondary menu' ,'jayla'),
      ),
      array(
        'element' => 'widget',
        'name' => 'handheld-navigation',
        'title' => __('Handheld Navigation', 'jayla'),
        'icon' => 'ion-navicon-round',
        'description' => __('Mobile menu' ,'jayla'),
      ),
      array(
        'element' => 'widget',
        'name' => 'menu-offcanvas',
        'title' => __('Menu Offcanvas', 'jayla'),
        'icon' => 'ion-navicon-round',
        'description' => __('menu offcanvas style.' ,'jayla'),
      ),
      array(
        'element' => 'widget',
        'name' => 'search',
        'title' => __('Search', 'jayla'),
        'icon' => 'ion-ios-search-strong',
        'description' => __('Search (opt ajax)' ,'jayla'),
      ),
      array(
        'element' => 'widget',
        'name' => 'connect-social',
        'title' => __('Connect Social', 'jayla'),
        'icon' => 'ion-android-share-alt',
        'description' => __('facebook, google, etc.' ,'jayla'),
      ),
      array(
        'element' => 'widget',
        'name' => 'icon-font',
        'title' => __('Icon Font', 'jayla'),
        'icon' => 'ion-ios-information',
        'description' => __('Icon font widget (Ionicon, Fontawesome).' ,'jayla'),
      ),
    );
  }
}

if(! function_exists('jayla_designer_data_default')) {
  /**
   * designer data default
   */
  function jayla_designer_data_default () {
    return array(
      array(
        'name' => 'Body Tag',
        'css_selector' => 'body',
        'group_style' => array(
          array(
            'type' => 'size',
            'properties' => array(
              'width' => '',
              'min-width' => '',
              'max-width' => '',
              'height' => '',
              'min-height' => '',
              'max-height' => '',
            )
          ),
          array(
            'type' => 'space',
            'properties' => array(
              'margin' => '',
              'padding' => '',
            )
          ),
          array(
            'type' => 'typography',
            'properties' => array(
              'typography' => array(
                'font_style' => array(),
                'font_family' => '',
                'font_variant' => '',
                'font_size' => '',
                'line_height' => '',
                'letter_spacing' => '',
                'text_color' => '',
              )
            )
          ),
          array(
            'type' => 'border',
            'properties' => array(
              'border-style' => '',
              'border-width' => '',
              'border-radius' => '',
              'border-color' => '',
            )
          ),
          array(
            'type' => 'background',
            'properties' => array(
              'background-color' => '',
              'background-image' => '',
              'background-size' => '',
              'background-repeat' => '',
              'background-position' => '',
              'background-attachment' => '',
            )
          )
        )
      )
    );
  }
}

if(! function_exists('jayla_advanced_options_data_default')) {
  /**
   * @since 1.0.2
   *  
   */
  function jayla_advanced_options_data_default() {
    return apply_filters( 'jayla_advanced_options_default_filter' , array(
      'load_custom_post_type_team' => 'no',
    ) );
  }
}

if(! function_exists('jayla_load_theme_advanced_options')) {
  /**
   * @since 1.0.2 
   * 
   */
  function jayla_load_theme_advanced_options() {
    $opts_default = jayla_advanced_options_data_default();
    $theme_advanced_options = get_option( 'theme_advanced_options', $opts_default );

    return array_replace_recursive($opts_default, $theme_advanced_options);
  }
}

if(! function_exists('jayla_update_theme_advanced_options')) {
  /**
   * @since 1.0.2 
   * 
   */
  function jayla_update_theme_advanced_options( $new_options ) {
    return update_option( 'theme_advanced_options', apply_filters( 'jayla_update_theme_advanced_options_data_filter' , $new_options ) );
  }
}

if(! function_exists('jayla_load_theme_advanced_options_ajax')) {
  /**
   * @since 1.0.2 
   */
  function jayla_load_theme_advanced_options_ajax() {
    wp_send_json( jayla_load_theme_advanced_options() ); exit();
  }

  add_action( 'wp_ajax_jayla_load_theme_advanced_options_ajax', 'jayla_load_theme_advanced_options_ajax' );
  add_action( 'wp_ajax_nopriv_jayla_load_theme_advanced_options_ajax', 'jayla_load_theme_advanced_options_ajax' );
}

if(! function_exists('jayla_update_theme_advanced_options_ajax')) {
  /**
   * @since 1.0.2 
   */
  function jayla_update_theme_advanced_options_ajax() {
    $new_options = $_POST['theme_advanced_options'];
    $result = jayla_update_theme_advanced_options( $new_options );
    
    wp_send_json( $result ); exit();
  }

  add_action( 'wp_ajax_jayla_update_theme_advanced_options_ajax', 'jayla_update_theme_advanced_options_ajax' );
  add_action( 'wp_ajax_nopriv_jayla_update_theme_advanced_options_ajax', 'jayla_update_theme_advanced_options_ajax' );
}

if(! function_exists('jayla_heading_bar_background_data_default')) {
  /**
   * @since 1.0.0
   */
  function jayla_heading_bar_background_data_default() {
    $default_options = include( dirname(__FILE__) . '/data-core/heading-bar/background.php' );
    return $default_options;
  }
}

if(! function_exists('jayla_taxonomy_heading_bar_data_default')) {
  /**
   * @since 1.0.0
   */
  function jayla_taxonomy_heading_bar_data_default() {
    $default_options = include( dirname(__FILE__) . '/data-core/taxonomy-heading-bar/default.php' );
    return apply_filters( 'jayla_taxonomy_heading_bar_data_default', $default_options );
  }
}


if(! function_exists('jayla_header_widget_options')) {
  /**
   * header widget options
   * @since 1.0.0
   */
  function jayla_header_widget_options () {
    $widget_options = include( dirname(__FILE__) . '/data-core/widgets/widgets.php' );
    return $widget_options;
  }
}

if(! function_exists('jayla_container_class')) {
	/**
	 * container class
	 */
	function jayla_container_class($type = 'large', $extra_class = array(), $echo = true) {

		$container_type = array(
			'fluid' 	=> 'container-fluid',
			'large' 	=> 'container-large',
			'medium' 	=> 'container',
		);

		array_push($extra_class, $container_type[$type]);

		if($echo == true) echo implode(' ', $extra_class);
		else return implode(' ', $extra_class);
	}
}

if(! function_exists('fintotheme_global_layout_options')) {
	/**
	 * Global layout opts
	 */
	function fintotheme_global_layout_options() {
		global $post;

		$global_settings_json 	= get_theme_mod('jayla_global_settings');
		$global_settings 				= json_decode($global_settings_json, true);

		return $global_settings['layout'];
	}
}

if(! function_exists('fintotheme_sidebar_options')) {
	/**
	 * sidebar options
	 */
	function fintotheme_sidebar_options () {
		global $post;

		$global_settings_json 	= get_theme_mod('jayla_global_settings');
		$global_settings 				= json_decode($global_settings_json, true);
		return $global_settings['sidebar'];
	}
}

if(! class_exists('jayla_control_class')) {
	/**
	 * Col class
	 * @since 1.0.0
	 * @param $type [string] container/sidebar
	 * @param $echo [boolean] true/false
	 *
	 * @return [string]
	 */
	function jayla_control_sidebar_class($type = 'content', $echo = true) {
		$post_id = jayla_get_post_id();

		$classes = array();
		$sidebar_opts						= fintotheme_sidebar_options();
		$layout_default 				= $sidebar_opts['layout'];

		$custom_metabox_data = jayla_get_custom_metabox($post_id);
		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_sidebar'] == 'yes') {
			$layout_default = $custom_metabox_data['sidebar_layout'];
		}

    $layout_default = apply_filters( 'jayla_control_sidebar_class_filter', $layout_default );

		$scheme_class = apply_filters('jayla_scheme_container_class', array(
			'content' => array(
				'right-sidebar' 	=> 'col-lg-9 col-sm-12',
				'left-sidebar' 		=> 'col-lg-9 col-sm-12 push-lg-3',
				'no-sidebar' 			=> 'col-lg-12 col-sm-12',
			),
			'sidebar' => array(
				'right-sidebar' 	=> 'col-lg-3 col-sm-12',
				'left-sidebar' 		=> 'col-lg-3 col-sm-12 pull-lg-9',
				'no-sidebar' 			=> '',
			),
		));

		switch ($type) {
			case 'content':
				array_push($classes, $scheme_class[$type][$layout_default]);
				break;

			case 'sidebar':
				array_push($classes, $scheme_class[$type][$layout_default]);
				break;
		}

		if($echo == true) echo implode(' ', $classes);
		else return implode(' ', $classes);
	}
}

if(! function_exists('jayla_get_list_wp_widget_element')) {
  /**
   * get WP Widget
   * @since 1.0.0
   */
  function jayla_get_list_wp_widget_element() {
    global $wp_widget_factory;
    $widgets = $wp_widget_factory->widgets;
    $result = array();

    foreach($widgets as $key => $item) {
      array_push($result, array(
        'element'       => 'wp-widget',
        'widget_key'    => $key,
        'id_base'       => $item->id_base,
        'name'          => $item->id_base,
        'option_name'   => $item->option_name,
        'title'         => sprintf('%s', $item->name),
        'icon'          => 'ion-social-wordpress',
      ));
    }

    return $result;
  }
}

if(! function_exists('jayla_load_wp_widget_form')) {
  /**
   * get wp widget form
   * @since 1.0.0
   */
  function jayla_load_wp_widget_form() {
    global $jayla_global, $wp_widget_factory;
    $widgets = $wp_widget_factory->widgets;
    extract($_POST['data']);

    if(! isset($widgets[$widget_key])) exit();
    $widget_obj = $widgets[$widget_key];
    $data = isset($params) ? $params : array();
    $widget_id = 'widget-' . $widget_obj->id_base . '-' . date('YmdHis');

    $data = jayla_get_wp_widget_param($key);
    ob_start();
    ?>
    <form method="POST" id="<?php echo esc_attr($widget_id); ?>" data-theme-extends-widget-id="<?php echo esc_attr($widget_id); ?>" class="open">
      <div class="widget-inside media-widget-control" style="display: block;">
        <div class="form wp-core-ui">
      		<input type="hidden" class="id_base" name="id_base" value="<?php echo esc_attr( $widget_obj->id_base ); ?>" />
      		<input type="hidden" class="widget-id" value="<?php echo esc_attr($widget_id); ?>" />
      		<div class="widget-content">
        		<?php $widget_obj->form( $data ); ?>
  		    </div>
        </div>
      </div>
    </form>
    <?php
		$form = ob_get_clean();

    wp_send_json_success(array('form' => $form));
  }
  add_action( 'wp_ajax_jayla_load_wp_widget_form', 'jayla_load_wp_widget_form' );
  add_action( 'wp_ajax_nopriv_jayla_load_wp_widget_form', 'jayla_load_wp_widget_form' );
}

if(! function_exists('jayla_save_wp_widget_data')) {
  function jayla_save_wp_widget_data() {
    global $jayla_global, $wp_widget_factory;

    $widgets = $wp_widget_factory->widgets;
    $widget_obj = $widgets[$_POST['widget_key']];

    $widget_data = $_POST[sprintf('widget-%s', $_POST['id_base'])];
    $data = $widget_obj->update( reset($widget_data), reset($widget_data) );

    update_option( sprintf('%s__%s', strtolower($jayla_global), $_POST['key']) , stripslashes_deep($data));
    wp_send_json_success(array(
      'update_date' => date('l jS \of F Y h:i:s A'),
    ));
  }
  add_action( 'wp_ajax_jayla_save_wp_widget_data', 'jayla_save_wp_widget_data' );
  add_action( 'wp_ajax_nopriv_jayla_save_wp_widget_data', 'jayla_save_wp_widget_data' );
}

if(! function_exists('jayla_save_design_frontend_data')) {
  /**
   * save design frontend
   * @since 1.0.0
   */
  function jayla_save_design_frontend_data() {
    if(! empty($_POST['post_id']))
      update_post_meta( $_POST['post_id'], '_design_frontend_data', $_POST['data'], $prev_value );

    exit();
  }
  add_action( 'wp_ajax_jayla_save_design_frontend_data', 'jayla_save_design_frontend_data' );
  add_action( 'wp_ajax_nopriv_jayla_save_design_frontend_data', 'jayla_save_design_frontend_data' );
}

if(! function_exists('jayla_add_designer_frontend_data')) {
  /**
   * Add data designer fronend localize_script
   */
  function jayla_add_designer_frontend_data ($data) {
    $post_id = jayla_get_post_id();
    $design_frontend_data = get_post_meta($post_id, '_design_frontend_data', true);

    $data['designer_frontend'] = (! empty($design_frontend_data)) ? json_decode($design_frontend_data) : (object) array();
    return $data;
  }
  add_filter('jayla_theme_extends_designer_frontend_script_object', 'jayla_add_designer_frontend_data');
}

if(! function_exists('jayla_header_builder_custom_style')) {
  /**
   * header builder custom style inline
   * @since 1.0.0
   */
  function jayla_header_builder_custom_style($style) {
		$post_id = jayla_get_post_id();

    $header_builder_data = json_decode(get_theme_mod( 'jayla_header_builder_data' ), true);
		$custom_metabox_data = jayla_get_custom_metabox($post_id);

		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_header'] == 'yes') {
			$header_builder_layout = json_decode(get_theme_mod( 'jayla_header_builder_layout' ), true);
			$found_key = array_search($custom_metabox_data['custom_header_layout'], array_column($header_builder_layout, 'key'));

			if(! empty($found_key)) {
				$header_builder_data = $header_builder_layout[$found_key];
			}
		}

    $header_class = new Jayla_Header_Render($header_builder_data);

    $style .= $header_class->render_css_inline();
    return $style;
  }
	add_filter('jayla_custom_style_inline', 'jayla_header_builder_custom_style');
}



if(! function_exists('jayla_footer_builder_custom_style')) {
  /**
   * footer builder custom style inline
   * @since 1.0.0
   */
  function jayla_footer_builder_custom_style($style) {
		$post_id = jayla_get_post_id();

    $footer_builder_data = json_decode(get_theme_mod( 'jayla_footer_builder_data' ), true);
		$custom_metabox_data = jayla_get_custom_metabox($post_id);

		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_footer'] == 'yes') {
			$footer_builder_layout = json_decode(get_theme_mod( 'jayla_footer_builder_layout' ), true);
			$found_key = array_search($custom_metabox_data['custom_footer_layout'], array_column($footer_builder_layout, 'key'));

			if(! empty($found_key)) { $footer_builder_data = $footer_builder_layout[$found_key]; }
		}

		$footer_class = new Jayla_Footer_Render($footer_builder_data);

    $style .= $footer_class->render_css_inline();
    return $style;
  }
  add_filter('jayla_custom_style_inline', 'jayla_footer_builder_custom_style');
}

if(! function_exists('jayla_designer_custom_style')) {

  function jayla_render_css_by_block_style($type = '', $properties = array()) {
    if($type == '' || count($properties) == 0) return;
    $output = '';

    switch ($type) {

      case 'typography' :
        $typography = $properties['typography'];
        $typography_temp = array(
          'font_family'     => 'font-family: {value};',
          'font_size'       => 'font-size: {value};',
          'font_variant'    => 'font-weight: {value};',
          'letter_spacing'  => 'letter-spacing: {value};',
          'text_color'      => 'color: {value};',
          'fill_color'      => 'fill: {value};',
          'line_height'     => 'line-height: {value};',
        );

        $font_style = array(
          'bold' => 'font-weight: bold;',
          'italic' => 'font-style: italic;',
          'underline' => 'text-decoration: underline;',
          'strikethrough' => 'text-decoration: line-through;',
        );

        foreach($typography as $p => $v) {
          if(! empty($v)) {
            if('font_style' == $p && count($v) > 0) {
              foreach($v as $item) {
                $output .= $font_style[$item];
              }
            } else {
              $v = ('regular' == $v) ? 'normal' : $v;
              $output .= str_replace('{value}', $v, $typography_temp[$p]);
            }
          }
        }
        break;

      case 'background' :
        foreach($properties as $p => $v) {
          if(! empty($v)) {
            if('background-image' == $p) $output .= $p . ': url(' . $v . ');';
            else $output .= $p . ':' . $v . ';';
          }
        }
        break;

			default:
				foreach($properties as $p => $v) {
					if(! empty($v)) { $output .= $p . ':' . $v . ';'; }
				}
				break;
    }

    return $output;
  }

  function jayla_designer_render_style($group_style = array()) {
    $output = '';
    if(count($group_style) <= 0) return $output;

    foreach($group_style as $item) {
      $output .= jayla_render_css_by_block_style($item['type'], $item['properties']);
    }

    return $output;
  }

  /**
   * designer custom current page style inline render
   * @since 1.0.0
   */
  function jayla_designer_frontend_custom_style ($style) {

    // global $post;
    $post_id = jayla_get_post_id();

    $design_data = get_post_meta($post_id, '_design_frontend_data', true);
    if(empty($design_data)) return $style;

    $output = '';
    $designer = json_decode($design_data, true);
    list($design_data, $css_inline) = array($designer['design_data'], $designer['css_inline']);

    if(count($design_data) > 0) {
      foreach($design_data as $item) {
        $output .= implode('', array(
          $item['css_selector'], '{', jayla_designer_render_style($item['group_style']), '}',
        ));
      }
    }

    return implode(' ', array($style, $output, $css_inline));
  }
  add_filter('jayla_custom_style_theme_designer_current_page_inline', 'jayla_designer_frontend_custom_style');

  /**
   * designer style inline render
   * @since 1.0.0
   */
  function jayla_designer_custom_style($style) {
    $designer_data = json_decode(get_theme_mod( 'jayla_designer_settings' ), true);
    if(count($designer_data) <= 0) return;
    $output = '';
    foreach($designer_data as $item) {
      $output .= implode('', array(
        $item['css_selector'], '{', jayla_designer_render_style($item['group_style']), '}',
      ));
    }

    return $style . $output;
  }
  add_filter('jayla_custom_style_theme_designer_inline', 'jayla_designer_custom_style');
}

if(! function_exists('jayla_theme_script_push_designer_google_fonts')) {
  /**
   * push google fonts data to theme script object
   * @since 1.0.0
   */
  function jayla_theme_script_push_designer_google_fonts($data) {
    $google_fonts_data = json_decode(get_theme_mod( 'jayla_designer_google_fonts' ), true);
    if( empty($google_fonts_data) || !is_array($google_fonts_data) || count($google_fonts_data) <= 0 ) return $data;

    $font_families = array();
    foreach($google_fonts_data as $key => $val) {
      $item = $key;
      if(count($val) > 0) { $item .= ':' . implode(',', $val); }
      array_push($font_families, $item);
    }

    $data['designer_google_font_families'] = $font_families;
    return $data;
  }
  add_filter('jayla_theme_script_object', 'jayla_theme_script_push_designer_google_fonts');
}

if(! function_exists('jayla_theme_script_push_designer_frontend_google_fonts')) {
  /**
   * push google fonts data to theme script object
   * @since 1.0.0
   */
  function jayla_theme_script_push_designer_frontend_google_fonts($data) {
    $post_id = jayla_get_post_id();
    $google_fonts_data = get_post_meta($post_id, '_design_frontend_data', true);
    if(empty($google_fonts_data)) return $data;

    $desiner = json_decode($google_fonts_data, true);
    $google_fonts_data = json_decode($desiner['google_fonts'], true);
    if( empty($google_fonts_data) || !is_array($google_fonts_data) || count($google_fonts_data) <= 0 ) return $data;

    $font_families = array();
    foreach($google_fonts_data as $key => $val) {
      $item = $key;
      if(count($val) > 0) { $item .= ':' . implode(',', $val); }
      array_push($font_families, $item);
    }

    $data['designer_frontend_google_font_families'] = $font_families;
    return $data;
  }
  add_filter('jayla_theme_script_object', 'jayla_theme_script_push_designer_frontend_google_fonts');
}

if(! function_exists('jayla_rs_row_element')) {
	/**
	 * header builder rs-row element
	 * @since 1.0.0
	 */
  function jayla_rs_row_element($data) {
    $params = array_merge(array(
      'content_width'           => 'large',
      'full_width'              => 'off',
      'align'                   => '',
      'columns_vertical_align'  => '',
      'padding'                 => '',
      'margin'                  => '',
      'hidden_on_device'        => array(),
      'extra_class'             => '',
      'id'                      => '',
    ), (isset($data['params']) && is_array($data['params'])) ? $data['params'] : array());

    $container_class = jayla_container_class($params['content_width'], $params['hidden_on_device'], false);
    if( $params['content_width'] == 'fluid' && $params['full_width'] == 'on' ) {
      $container_class .= ' container-fullwidth-no-padding';
    }

    $element_class = implode(' ', array( 'rs-row', 'element-' . $data['key'], $params['align'], $params['columns_vertical_align'], $params['extra_class'] ));
    $id_attr = (! empty($params['id'])) ? 'id="'. $params['id'] .'"' : '';

    $section_design = wp_json_encode( array(
      array(
        'name' => 'Section - ' . $data['key'],
        'selector' => '.section-wrap-' . $data['key'],
      )
    ) );

    return array(
      'start'   				=> '<section class="rs-section section-wrap-'. $data['key'] .'" data-design-name="'. __('Section Wrap', 'jayla') . ' - ' . $data['key'] .'" data-design-selector=".section-wrap-'. $data['key'] .'"><div class="'. $container_class .'"><div '. $id_attr .' class="'. $element_class .'">',
			'content_before' 	=> '',
			'content_after'		=> '',
      'end'     				=> '</div></div></section>',
    );
  }
}

if(! function_exists('jayla_rs_col_element')) {
	/**
	 * header builder rs-col element
	 * @since 1.0.0
	 */
  function jayla_rs_col_element($data) {
    $params = array_merge(array(
      'width'         => '',
      'align'         => '',
      'widget_inline' => 'off',
      'widget_vertical_align' => '',
      'padding'       => '',
      'margin'        => '',
      'hidden_on_device' => array(),
      'extra_class'   => '',
      'id'            => '',
    ), $data['params']);

    $widget_inner_inline_classes = ($params['widget_inline'] == 'on') ? 'theme-extends-widget-inner-inline-on' : '';
    $widget_vertical_align_classes = ($params['widget_inline'] == 'on') ? $params['widget_vertical_align']  : '';

    $element_class = implode(' ', array(
      'rs-col',
      'element-' . $data['key'],
      $params['align'],
      $widget_inner_inline_classes,
      $widget_vertical_align_classes,
      $params['extra_class'],
      implode(' ', $params['hidden_on_device'])
    ));
    $id_attr = (! empty($params['id'])) ? 'id="'. $params['id'] .'"' : '';

    return array(
      'start'   				=> '<div '. $id_attr .' class="'. $element_class .'">',
			'content_before' 	=> '<div class="rs-col-inner">',
			'content_after'		=> '</div>',
      'end'     				=> '</div>',
    );
  }
}

if(! function_exists('jayla_widget_element')) {
	/**
	 * header builder widget element
	 * @since 1.0.0
	 */
  function jayla_widget_element($data) {
    $_fn = sprintf('jayla_widget_%s_element', str_replace('-', '_', $data['name']));
    if(! function_exists( $_fn ) ) return;

    $result = call_user_func_array($_fn, [$data]);
    $element_class = implode(' ', apply_filters('jayla_widget_element_class_filter', array('widget-element', 'widget-element-' . $data['name'], 'element-' . $data['key']), $data));
    return array(
      'start'   				=> apply_filters( 'jayla_widget_element_start_filter', '<div class="' . $element_class . '">', $data ),
			'content_before' 	=> $result,
			'content_after'		=> '',
      'end'     				=> apply_filters( 'jayla_widget_element_end_filter', '</div>', $data ),
    );
  }
}

if(! function_exists('jayla_get_wp_widget_param')) {
  /**
   * @since 1.0.0
   * @param {string} $element_key
   */
  function jayla_get_wp_widget_param($element_key = '', $default = array()) {
    global $jayla_global;
    $params = get_option( sprintf( '%s__%s', $jayla_global, $element_key ), $default );

    return apply_filters( 'jayla_get_wp_widget_param_filter', $params, $element_key );
  }
}

if(! function_exists('jayla_wp_widget_param_default')) {
  /**
   * since 1.0.0
   * @param {array | empty} $params
   * @param {string} $element_key
   *
   * @return {array}
   */
  function jayla_wp_widget_param_default($params, $element_key) {
    if( ! empty($params) ) return $params;

    $widget_default_params = include( dirname(__FILE__) . '/data-core/core-widget-params.php' );
    return (isset($widget_default_params[$element_key])) ? $widget_default_params[$element_key] : $params;
  }
}

if(! function_exists('jayla_wp_widget_element')) {
  /**
   * header builder WordPress widget element
   * @since 1.0.0
   */
  function jayla_wp_widget_element($data) {
    $params = jayla_get_wp_widget_param($data['key']);

    ob_start();
    the_widget($data['widget_key'], $params);
    $result = ob_get_clean();

    $element_class = implode(' ', array('wp-widget-element', 'wp-widget-element-' .$data['name'], 'element-' . $data['key']));

    $design_selector = array(
			array(
				'name' => __('Widget Wrap','jayla'),
				'selector' => '#page .wp-widget-element.element-'.$data['key']
			),
      array(
        'name' => __('Widget Title','jayla'),
        'selector' => '#page .wp-widget-element.element-'.$data['key'].' .widgettitle'
      ),
      array(
        'name' => __('Widget Link','jayla'),
        'selector' => '#page .wp-widget-element.element-'.$data['key'].' a'
      ),
      array(
        'name' => __('Widget Link:Hover','jayla'),
        'selector' => '#page .wp-widget-element.element-'.$data['key'].' a:hover'
      ),
      array(
        'name' => __('Widget Nav Item','jayla'),
        'selector' => '#page .wp-widget-element.element-'.$data['key'].' .theme-extends-widget-custom-menu .menu.widget-custom-menu ul.menu li.menu-item a'
      ),
      array(
        'name' => __('Widget Nav Item:Hover','jayla'),
        'selector' => '#page .wp-widget-element.element-'.$data['key'].' .theme-extends-widget-custom-menu .menu.widget-custom-menu ul.menu li.menu-item a:hover'
      ),
    );
    return array(
      'start'   				=> "<div class='{$element_class}' data-design-name='". esc_attr__('Widget','jayla') ."' data-design-selector='".esc_attr(wp_json_encode($design_selector))."'>",
			'content_before' 	=> $result,
			'content_after'		=> '',
      'end'     				=> '</div>',
    );
  }
}

if(! function_exists('jayla_widget_logo_element')) {
  /**
   * widget logo
   * @since 1.0.0
   */
  function jayla_widget_logo_element($data) {
		/* set params default */
		$params = array_merge(array(
			'custom_logo' 	=> 'off',
			'branding_url' 	=> '#',
			'id' 						=> '',
			'extra_class' 	=> '',
		), $data['params']);

    $output = '';

    $custom_logo_id     = get_theme_mod( 'custom_logo' );
    $image              = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $image_url          = ($image) ? $image[0] : '#';

    $blogname           = get_bloginfo( 'name' );
    $blogdescription    = get_bloginfo( 'description' );

    $image_design_selector = implode('', array('#page', ' .element-' . $data['key'], ' .branding-image'));
    $text_design_selector = json_encode(array(
			array(
				'name' => __('Side name', 'jayla'),
				'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .type-text .site-title')),
			),
			array(
				'name' => __('Side description', 'jayla'),
				'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .type-text .site-description')),
			),
		));

		if($params['custom_logo'] == 'on') {
			$custom_logo_id = true;
			$image_url = $params['branding_url'];
		}

		$id_attr = empty( $params['id'] ) ? '' : 'id="'. $params['id'] .'"';
    $logo_template = array(
      'image' => implode('', array(
        '<div '. $id_attr .' class="site-branding type-image '. esc_attr( $params['extra_class'] ) .'" data-design-name="'. __('Branding image', 'jayla') .'" data-design-selector="'. $image_design_selector .'">',
          '<a href="'. esc_url( get_home_url() ) .'" rel="home">',
            '<img class="branding-image" src="'. esc_url($image_url) .'" alt="'. esc_attr( $blogname ) .'">',
          '</a>',
        '</div>',
      )),
      'text'  => implode('', array(
        '<div '. $id_attr .' class="site-branding type-text '. esc_attr( $params['extra_class'] ) .'" data-design-name="'. __('Site title / logo', 'jayla') .'" data-design-selector=\''. $text_design_selector .'\'>',
          '<a class="site-title" href="'. esc_url( get_home_url() ) .'" rel="home">'. $blogname .'</a>',
          '<p class="site-description">'. $blogdescription .'</p>',
        '</div>',
      )),
    );

    return ! empty($custom_logo_id) ? $logo_template['image'] : $logo_template['text'];
  }
}

if(! function_exists('jayla_widget_primary_navigation_element')) {
  /**
   * widget primary_navigation
   * @since 1.0.0
   */
  function jayla_widget_primary_navigation_element($data) {

    /* set params default */
		$params = array_merge(array(
			'custom_menu' 	=> 'off',
			'menu' 	        => '',
			'id' 						=> '',
			'extra_class' 	=> '',
    ), $data['params']);

    // menu args
    $menu_args = array(
      'theme_location' => 'primary',
      'echo'           => false,
      'designer_class' => 'element-' . $data['key'],
      'walker'         => new Jayla_Nav_Walker(),
      'fallback_cb'    => 'jayla_select_menu_message_fallback',
    );

    // set custom memnu
    if($params['custom_menu'] == 'on') { $menu_args['menu'] = $params['menu']; }

    $menu = wp_nav_menu($menu_args);

    $design_selector = wp_json_encode(apply_filters( 'jayla_widget_menu_primary_design_selector', array(
      array(
        'name' => __('Navigation Wrap', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap')),
      ),
      array(
        'name' => __('Navigation Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item:hover > a')),
      ),
      array(
        'name' => __('Navigation Item Link Current', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item.current-menu-item > a')),
      ),
      array(
        'name' => __('Navigation Item Link Current Parent', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item.current-menu-parent > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Wrap', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu li.menu-item:hover > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link Current', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu li.menu-item.current-menu-item > a')),
      ),
    ) ));

    $id_attr = empty( $params['id'] ) ? '' : 'id="'. $params['id'] .'"';

    return implode('', array(
      '<div '. $id_attr .' class="jayla-nav-wrap '. $params['extra_class'] .'" data-design-name="'. $data['title'] .'" data-design-selector=\''. $design_selector .'\'>',
        $menu,
      '</div>'
    ));
  }
}

if(! function_exists('jayla_widget_secondary_navigation_element')) {
  /**
   * widget secondary_navigation
   * @since 1.0.0
   */
  function jayla_widget_secondary_navigation_element($data) {

    /* set params default */
		$params = array_merge(array(
			'custom_menu' 	=> 'off',
			'menu' 	        => '',
			'id' 						=> '',
			'extra_class' 	=> '',
    ), $data['params']);

    // menu args
    $menu_args = array(
      'theme_location' => 'secondary',
      'echo'           => false,
      'designer_class' => 'element-' . $data['key'],
      'walker'         => new Jayla_Nav_Walker(),
      'fallback_cb'    => 'jayla_select_menu_message_fallback',
    );

    // set custom memnu
    if($params['custom_menu'] == 'on') { $menu_args['menu'] = $params['menu']; }

    $menu = wp_nav_menu($menu_args);

    $design_selector = json_encode(array(
      array(
        'name' => __('Navigation Wrap', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap')),
      ),
      array(
        'name' => __('Navigation Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item:hover > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Wrap', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu li.menu-item:hover > a')),
      ),
    ));

    $id_attr = empty( $params['id'] ) ? '' : 'id="'. $params['id'] .'"';

    return implode('', array(
      '<div '. $id_attr .' class="jayla-nav-wrap '. $params['extra_class'] .'" data-design-name="'. $data['title'] .'" data-design-selector=\''. $design_selector .'\'>',
        $menu,
      '</div>'
    ));
  }
}

if(! function_exists('jayla_widget_handheld_navigation_element')) {
  /**
   * widget handheld_navigation
   * @since 1.0.0
   */
  function jayla_widget_handheld_navigation_element($data) {

    /* set params default */
		$params = array_merge(array(
			'custom_menu' 	=> 'off',
			'menu' 	        => '',
			'id' 						=> '',
			'extra_class' 	=> '',
    ), $data['params']);

    // menu args
    $menu_args = array(
      'theme_location' => 'handheld',
      'echo'           => false,
      'designer_class' => 'element-' . $data['key'],
      'walker'         => new Jayla_Nav_Walker(),
      'fallback_cb'    => 'jayla_select_menu_message_fallback',
      'menu_class'     => 'menu jayla-handheld-menu-container',
    );

    // set custom memnu
    if($params['custom_menu'] == 'on') { $menu_args['menu'] = $params['menu']; }

    $menu = wp_nav_menu($menu_args);

    $design_selector = wp_json_encode(array(
      array(
        'name' => __('Navigation Wrap', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap')),
      ),
      array(
        'name' => __('Navigation Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu li.menu-item:hover > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Wrap', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .jayla-nav-wrap ul.menu ul.sub-menu li.menu-item:hover > a')),
      ),
    ));

    $id_attr = empty( $params['id'] ) ? '' : 'id="'. $params['id'] .'"';

    return implode('', array(
      '<div '. $id_attr .' class="jayla-nav-wrap '. $params['extra_class'] .'" data-design-name="'. $data['title'] .'" data-design-selector=\''. $design_selector .'\'>',
				'<div class="hamburger hamburger--elastic" data-theme-extends-mobi-menu-trigger>
				  <div class="hamburger-box">
				    <div class="hamburger-inner"></div>
				  </div>
				</div>',
				'<div class="menu-container">',
					'<div class="__close text-center">
						<button class="hamburger hamburger--collapse" data-theme-extends-mobi-menu-trigger type="button">
						  <span class="hamburger-box">
						    <span class="hamburger-inner"></span>
						  </span>
						</button>
					</div>',
					$menu,
				'</div>',
      '</div>'
    ));
  }
}


if(! function_exists('jayla_widget_menu_offcanvas_element')) {
  function jayla_widget_menu_offcanvas_element($data) {

    /* set params default */
		$params = array_merge(array(
			'menu' 	              => '',
      'style' 	            => 'fullwidth-fadein-center',
      'sidebar_before_nav'  => '',
      'sidebar_after_nav'   => '',
			'id' 						      => '',
			'extra_class' 	      => '',
    ), $data['params']);

    $menu = '';
    $sidebar_before_nav = '';
    $sidebar_after_nav = '';

    if( ! empty($params['menu']) ) {
      // menu args
      $menu_args = array(
        'menu'           => $params['menu'],
        'echo'           => false,
        'designer_class' => 'element-' . $data['key'],
        'walker'         => new Jayla_Nav_Walker(),
        'fallback_cb'    => 'jayla_select_menu_message_fallback',
        'menu_class'     => 'menu jayla-menu-offcanvas-container',
      );
      $menu = wp_nav_menu($menu_args);
    }

    if( ! empty($params['sidebar_before_nav']) ) {
      ob_start();
      ?>
      <div class="theme-extend-offcanvas-widget theme-extend-offcanvas-sidebar-before-nav">
        <div class="widget-contaner">
          <?php dynamic_sidebar($params['sidebar_before_nav']); ?>
        </div>
      </div>
      <?php
      $sidebar_before_nav = ob_get_clean();
    }

    if( ! empty($params['sidebar_after_nav']) ) {
      ob_start();
      ?>
      <div class="theme-extend-offcanvas-widget theme-extend-offcanvas-sidebar-before-nav">
        <div class="widget-contaner">
          <?php dynamic_sidebar($params['sidebar_after_nav']); ?>
        </div>
      </div>
      <?php
      $sidebar_after_nav = ob_get_clean();
    }

    $design_selector = wp_json_encode(array(
      array(
        'name' => __('Hamburger toggle menu offcanvas', 'jayla'),
        'selector' => '#page ' . '.element-' . $data['key'] . ' .jayla-nav-wrap > .hamburger',
      ),
      array(
        'name' => __('Hamburger toggle menu offcanvas (:hover)', 'jayla'),
        'selector' => '#page ' . '.element-' . $data['key'] . ' .jayla-nav-wrap > .hamburger:hover',
      ),
      array(
        'name' => __('Button hamburger - 3 line', 'jayla'),
        'selector' => '#page ' . '.element-' . $data['key'] . ' .jayla-nav-wrap > .hamburger .hamburger-box .hamburger-inner, #page ' . '.element-' . $data['key'] . ' .jayla-nav-wrap > .hamburger .hamburger-box .hamburger-inner:after, #page ' . '.element-' . $data['key'] . ' .jayla-nav-wrap > .hamburger .hamburger-box .hamburger-inner:before',
      ),
    ));

    $offcanvas_design_selector = wp_json_encode(array(
      array(
        'name' => __('Menu Offcanvas Container', 'jayla'),
        'selector' => '#page .element-' . $data['key'] . ' .menu-container',
      ),
      array(
        'name' => __('Navigation Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' ul.jayla-menu-offcanvas-container li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' ul.jayla-menu-offcanvas-container li.menu-item:hover > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' ul.jayla-menu-offcanvas-container ul.sub-menu li.menu-item > a')),
      ),
      array(
        'name' => __('Navigation Sub-menu Item Link (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' ul.jayla-menu-offcanvas-container ul.sub-menu li.menu-item:hover > a')),
      ),
    ));

    $id_attr = empty( $params['id'] ) ? '' : 'id="'. $params['id'] .'"';
    $classes = implode(' ', array('jayla-nav-wrap jayla-nav-offcanvas-wrap', $params['extra_class'], $params['style']));

    return implode('', array(
      '<div '. $id_attr .' class="'. $classes .'" data-design-name="'. $data['title'] .'" data-design-selector=\''. $design_selector .'\'>',
				'<div class="hamburger hamburger--elastic" data-theme-extends-menu-offcanvas-trigger>
				  <div class="hamburger-box">
				    <div class="hamburger-inner"></div>
				  </div>
				</div>',
				'<div class="menu-container" data-design-name="'. __('Menu Offcanvas Container', 'jayla') .'" data-design-selector=\''. $offcanvas_design_selector .'\'>',
					'<div class="__close text-center">
						<button class="hamburger hamburger--collapse" data-theme-extends-menu-offcanvas-trigger type="button">
						  <span class="hamburger-box">
						    <span class="hamburger-inner"></span>
						  </span>
						</button>
          </div>',
          '<div class="menu-container-area">',
            $sidebar_before_nav,
            $menu,
            $sidebar_after_nav,
          '</div>',
				'</div>',
      '</div>'
    ));
  }
}

if(! function_exists('jayla_select_menu_message_fallback')) {
  function jayla_select_menu_message_fallback() {

    ob_start();
    do_action( 'jayla_select_menu_message_fallback_action' );
    return ob_get_clean();
  }
}

if(! function_exists('jayla_widget_search_element')) {
  /**
   * widget search
   * @since 1.0.0
   */
  function jayla_widget_search_element($data) {
    $params = array_merge(array(
			'search_form_position' 	=> 'left',
      'search_on_type' 				=> 'no',
      'element_inline'        => 'off',
      'extra_class'   				=> '',
      'id'            				=> '',
    ), $data['params'] );

    $classes = implode(' ', array( $params['extra_class'] ));

    $id_attr = (! empty($params['id'])) ? 'id="'. $params['id'] .'"' : '';

    $design_selector = sprintf('#page .element-%s a.__search-icon', $data['key']);

    return implode('', array(
      '<div '. $id_attr .' class="'. $classes .'" data-design-name="'. $data['title'] .'" data-design-selector="'. $design_selector .'">',
        '<a href="javascript:" class="__search-icon" data-theme-open-widget-search-form="" data-search-form-pos="'. $params['search_form_position'] .'" data-search-form-ajax="'. $params['search_on_type'] .'"><span class="fi flaticon-magnifying-glass"></span></a>',
      '</div>',
    ));
  }
}

if(! function_exists('jayla_widget_search_form')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_widget_search_form() {
		$design_selector = wp_json_encode(array(
			array('name' => __('Search wrap', 'jayla'), 'selector' => 'body .theme-extends-widget-search-form'),
			array('name' => __('Search wrap', 'jayla'), 'selector' => 'body .theme-extends-widget-search-form .search-text'),
			array('name' => __('Search field', 'jayla'), 'selector' => 'body .theme-extends-widget-search-form form.search-form input.search-field'),
			array('name' => __('Search background layout', 'jayla'), 'selector' => 'body .theme-extends-widget-search-form .__background-layout'),
		));
	?>
	<div
		id="theme-extends-widget-search-form"
		class="theme-extends-widget-search-form"
		data-anim-box
		data-design-name="<?php esc_attr_e('Search form', 'jayla') ?>"
		data-design-selector="<?php echo esc_attr($design_selector); ?>">
		<div class="__background-layout"></div>
		<div class="__inner">
			<div class="theme-extends-anime-item" style="">
				<div class="search-text"><?php echo apply_filters('jayla_theme_widget_search_text', __('What are you looking for?', 'jayla')); ?></div>
			</div>
			<div class="theme-extends-anime-item" style="transition-delay: .1s; -webkit-transition-delay: .1s;">
				<?php get_search_form( true ); ?>
			</div>
			<div class="theme-extends-anime-item" style="transition-delay: .3s; -webkit-transition-delay: .3s;">
				<a href="javascript:" class="search-form-close" data-anim-box-close><i class="ion-close"></i></a>
			</div>
			<div class="clear"></div>
			<div class="theme-extends-anime-item" style="transition-delay: .2s; -webkit-transition-delay: .2s;">
				<div class="result-content"></div>
			</div>
		</div>
	</div>
	<?php
	}
}

if(! function_exists('jayla_widget_icon_font_element')) {
  /**
   * widget icon font
   * @since 1.0.0
   */
  function jayla_widget_icon_font_element($data) {
    $params = array_merge(array(
      'icon_class' 	          => 'ion-ios-heart',
      'tooltip'               => '',
      'direct_link' 				  => '#',
      'target_blank' 				  => 'no',
      'element_inline'        => 'off',
      'extra_class'   				=> '',
      'id'            				=> '',
    ), $data['params'] );

    $id_attr = empty( $params['id'] ) ? '' : 'id="'. $params['id'] .'"';
    $classes = implode(' ', array( 'widget-element', 'widget-element-icon-font', $params['extra_class']));
    $design_selector = wp_json_encode( array(
      array(
        'name' => __('Icon', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .widget-element-icon-font ._icon-link')),
      ),
      array(
        'name' => __('Icon (:hover)', 'jayla'),
        'selector' => implode('', array('#page', ' .element-' . $data['key'], ' .widget-element-icon-font ._icon-link:hover')),
      ),
    ));

    $target_blank_attr = ( $params['target_blank'] == 'yes' ) ? 'target="_blank"' : '';
    $tooltip_attr = ( ! empty( $params['tooltip'] ) ) ? 'data-toggle="tooltip" data-placement="bottom" title="'. esc_attr( $params['tooltip'] ) .'"' : '';
    return implode('', array(
      '<div '. $id_attr .' class="'. esc_attr( $classes ) .'" data-design-name="'. $data['title'] .'" data-design-selector=\''. $design_selector .'\'>',
        '<a class="_icon-link" '. $target_blank_attr .' '. $tooltip_attr .' href="'. esc_url( $params['direct_link'] ) .'"><span class="'. esc_attr( $params['icon_class'] ) .'"></span></a>',
      '</div>',
    ));
  }
}

if(! function_exists('jayla_widget_connect_social_element')) {
  /**
   * widget connect social
   * @since 1.0.0
   */
  function jayla_widget_connect_social_element($data) {
    $params = array_merge(array(
      'facebook'              => 'on',
      'facebook_url'          => '',
      'google'                => 'on',
      'google_url'            => '',
      'twitter'               => 'on',
      'twitter_url'           => '',
      'instagram'             => 'off',
      'instagram_url'         => '',
      'pinterest'             => 'off',
      'pinterest_url'         => '',
      'youtube'               => 'off',
      'youtube_url'           => '',
      'vimeo'                 => 'off',
      'vimeo_url'             => '',
      'dribbble'              => 'off',
      'dribbble_url'          => '',
      'behance'               => 'off',
      'behance_url'           => '',
      'layout'                => 'default',
      'extra_class'   				=> '',
      'id'            				=> '',
    ), $data['params'] );

    // echo '<pre>'; print_r($params); echo '</pre>';

    $classes = implode(' ', array( 'widget-element', 'widget-element-connect-social', 'we-layout-' . $params['layout'], 'element-' . $data['key'], $params['extra_class'] ));
    $id_attr = (! empty($params['id'])) ? 'id="'. $params['id'] .'"' : '';

    $design_selector = wp_json_encode(array(
      array(
        'name' => __('Connect Social wrap', 'jayla'),
        'selector' => sprintf('#page .element-%s', $data['key']),
      ),
      array(
        'name' => __('Social item', 'jayla'),
        'selector' => sprintf('#page .element-%s a.cs-item', $data['key']),
      ),
      array(
        'name' => __('Social item (:hover)', 'jayla'),
        'selector' => sprintf('#page .element-%s a.cs-item:hover', $data['key']),
      ),
    ));

    $templates = array(
      'default' => implode('', array(
        '<nav class="nav-social-items">',
          ( $params['facebook']   == 'on' )   ? '<a class="cs-item cs-item-facebook" target="_blank" href="'. esc_url( $params['facebook_url'] ) .'"><span class="fa fa-facebook-f"></span></a>'   : '',
          ( $params['google']     == 'on' )   ? '<a class="cs-item cs-item-google" target="_blank" href="'. esc_url($params['google_url']) .'"><span class="fa fa-google"></span></a>'           : '',
          ( $params['twitter']    == 'on' )   ? '<a class="cs-item cs-item-twitter" target="_blank" href="'. esc_url($params['twitter_url']) .'"><span class="fa fa-twitter"></span></a>'        : '',
          ( $params['instagram']  == 'on' )   ? '<a class="cs-item cs-item-instagram" target="_blank" href="'. esc_url($params['instagram_url']) .'"><span class="fa fa-instagram"></span></a>'  : '',
          ( $params['pinterest']  == 'on' )   ? '<a class="cs-item cs-item-pinterest" target="_blank" href="'. esc_url($params['pinterest_url']) .'"><span class="fa fa-pinterest"></span></a>'  : '',
          ( $params['youtube']    == 'on' )   ? '<a class="cs-item cs-item-youtube" target="_blank" href="'. esc_url($params['youtube_url']) .'"><span class="fa fa-youtube"></span></a>'        : '',
          ( $params['vimeo']      == 'on' )   ? '<a class="cs-item cs-item-vimeo" target="_blank" href="'. esc_url($params['vimeo_url']) .'"><span class="fa fa-vimeo"></span></a>'              : '',
          ( $params['dribbble']   == 'on' )   ? '<a class="cs-item cs-item-dribbble" target="_blank" href="'. esc_url($params['dribbble_url']) .'"><span class="fa fa-dribbble"></span></a>'     : '',
          ( $params['behance']    == 'on' )   ? '<a class="cs-item cs-item-behance" target="_blank" href="'. esc_url($params['behance_url']) .'"><span class="fa fa-behance"></span></a>'        : '',
        '</nav>',
      )),

      '' => '',
    );

		// print_r($params);
    return implode('', array(
      '<div '. $id_attr .' class="'. $classes .'" data-design-name="'. $data['title'] .'" data-design-selector=\''. $design_selector .'\'>',
        $templates[$params['layout']],
      '</div>',
    ));
  }
}

if(! function_exists('jayla_filter_function_name')) {
  function jayla_filter_function_name( $atts, $item, $args ) {
    $args = (object) $args;
    $atts['data-design-name'] = __('Menu Item', 'jayla');
    $atts['data-design-selector'] = '#page .' . $args->designer_class . ' ul.menu li.menu-item > a';
    return $atts;
  }
}

if(! function_exists('jayla_excerpt_more')) {
  /**
   * Filter the "read more" excerpt string link to the post.
   *
   * @param string $more "Read more" excerpt string.
   * @return string (Maybe) modified "read more" excerpt string.
   */
  function jayla_excerpt_more( $more ) {
      return sprintf( '... <a class="read-more theme-extends-read-more" href="%1$s">%2$s</a>',
          get_permalink( get_the_ID() ),
          sprintf( '%s <i class="ion-android-arrow-forward"></i>', __( 'Read more', 'jayla' ) )
      );
  }
  add_filter( 'excerpt_more', 'jayla_excerpt_more' );
}

if(! function_exists('jayla_move_comment_and_cookies_field_to_bottom')) {
  /**
   * move comment & cookies field to bottom
   */
  function jayla_move_comment_and_cookies_field_to_bottom( $fields ) {
		$ordering_comment_field = apply_filters('jayla_ordering_comment_cookies_field', true);

		if($ordering_comment_field == true){
	    $comment_field = $fields['comment'];
      $cookies_field = isset($fields['cookies']) ? $fields['cookies'] : '';

	    unset( $fields['comment'] );
      $fields['comment'] = $comment_field;

      if( ! empty($cookies_field) ) {
        unset( $fields['cookies'] );
	      $fields['cookies'] = $cookies_field;
      }
		}

    return $fields;
  }
}

if(! function_exists('jayla_month_label')) {
  /**
	 * Return month label
	 *
	 * @param string $month
	 * @return string
	 */
  function jayla_month_label( $month ) {
    $month = intval($month);

    if( empty( $month ) ) return;
		$monthes = apply_filters( 'jayla_month_label_filter', array(
      1  => __('January', 'jayla'),
      2  => __('February', 'jayla'),
      3  => __('March', 'jayla'),
      4  => __('April', 'jayla'),
      5  => __('May', 'jayla'),
      6  => __('June', 'jayla'),
      7  => __('July', 'jayla'),
      8  => __('August', 'jayla'),
      9  => __('September', 'jayla'),
      10 => __('October', 'jayla'),
      11 => __('November', 'jayla'),
      12 => __('December', 'jayla'),
    ) );
    $month = $monthes[ intval($month) ];

    return $month;
	}
}

if(! function_exists('jayla_heading_title') ) {
  /**
   * @since 1.0.0
   * heading title
   *
   * @return {string}
   */
  function jayla_heading_title() {
    global $post;
    $title_page = array();

    if ( is_404() ) {
			array_push( $title_page, __( 'Page not found', 'jayla' ) );
		} elseif ( is_search() ) {
      array_push(
        $title_page,
  			sprintf(
  				__( 'Search results of "%1$s"', 'jayla' ),
  				get_search_query()
  			)
  		);
		} elseif ( is_tax() ) {
      $taxonomy         = get_query_var( 'taxonomy' );
  		$term             = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
  		array_push( $title_page, $term->name );
		} elseif ( is_attachment() ) {
			array_push( $title_page, get_the_title() );
		} elseif ( is_page() && ! is_front_page() ) {
			array_push( $title_page, get_the_title() );
		} elseif ( is_post_type_archive() ) {
      $post_type = get_post_type($post);
  		if ( $post_type && 'post' !== $post_type ) {
  			$post_type_object = get_post_type_object( $post_type );
  			$label = $post_type_object->label;
  			array_push( $title_page, $label );
  		}
		} elseif ( is_single() ) {
      array_push( $title_page, get_the_title() );
		} elseif ( is_category() ) {
  	  array_push( $title_page, get_the_archive_title() );
		} elseif ( is_tag() ) {
			array_push( $title_page, single_tag_title( '', false ) );
		} elseif ( is_author() ) {
      $author_id = get_query_var( 'author' );
      array_push($title_page, get_the_author_meta( 'display_name', $author_id ));
		} elseif ( is_day() ) {
      $year = get_query_var( 'year' );
  		if ( $year ) {
  			$month = get_query_var( 'monthnum' );
  			$day   = get_query_var( 'day' );
  		} else {
  			$ymd   = get_query_var( 'm' );
  			$year  = substr( $ymd, 0, 4 );
  			$month = substr( $ymd, 4, 2 );
  			$day   = substr( $ymd, -2 );
      }
      array_push($title_page, $year, $month, $day);
		} elseif ( is_month() ) {
      $year = get_query_var( 'year' );
  		if ( $year ) {
  			$month = get_query_var( 'monthnum' );
  		} else {
  			$ymd   = get_query_var( 'm' );
  			$year  = substr( $ymd, 0, 4 );
  			$month = substr( $ymd, -2 );
      }
      array_push($title_page, $year, jayla_month_label($month));
		} elseif ( is_year() ) {
      $year = get_query_var( 'year' );
  		if ( ! $year ) {
  			$ymd  = get_query_var( 'm' );
  			$year = $ymd;
  		}
      array_push($title_page, $year);
		} elseif ( is_home() && ! is_front_page() ) {
      $show_on_front  = get_option( 'show_on_front' );
  		$page_for_posts = get_option( 'page_for_posts' );
  		if ( 'page' === $show_on_front && $page_for_posts ) {
  			$title = get_the_title( $page_for_posts );
        array_push($title_page, $title);
  		}
		} elseif ( is_front_page() ) {
      $page_on_front = get_option( 'page_on_front' );
  		$home_label = __( 'Home', 'jayla' );
  		if ( $page_on_front ) {
  			$home_label = get_the_title( $page_on_front );
  		}
      array_push($title_page, $home_label);
    }

    /**
     * Hooks
     * @see flintotheem_woo_heading_title_shop_page - 20
     */
    return apply_filters( 'jayla_heading_title_filter', $title_page );
  }
}

if(! function_exists('fintotheme_custom_metabox_customize_data')) {
  /**
   * setting custom metabox page serttings
   */
  function fintotheme_custom_metabox_customize_data() {

    $header_layouts = get_theme_mod('jayla_header_builder_layout');
    $footer_layouts = get_theme_mod('jayla_footer_builder_layout');
		$layout_opts 		= fintotheme_global_layout_options();
		$sidebar_opts 	= fintotheme_sidebar_options();

    return array(
      'header_layouts' => json_decode($header_layouts, true),
      'footer_layouts' => json_decode($footer_layouts, true),
      'settings' => array(
        /* general */
        'custom_header' 													=> 'no',
        'custom_heading_bar' 											=> 'no',
        'custom_footer' 													=> 'no',

				'custom_layout'														=> 'no',
				'layout'																	=> $layout_opts['layout'],
				'container_width'													=> $layout_opts['container_width'],

				'custom_sidebar'													=> 'no',
				'sidebar_layout'													=> $sidebar_opts['layout'],
				'sidebar_sticky'													=> $sidebar_opts['sticky'],

        /* header */
        'custom_header_layout' 										=> '',

        /* heading bar */
        'custom_heading_bar_display'							=> get_theme_mod('jayla_heading_bar_display'),
				'custom_heading_bar_page_title_display'	  => get_theme_mod('jayla_heading_bar_page_title_display'),
				'custom_heading_bar_breadcrumb_display'	  => get_theme_mod('jayla_heading_bar_breadcrumb_display'),
				'custom_heading_bar_content_align'				=> get_theme_mod('jayla_heading_bar_content_align'),
        'custom_heading_bar_background_settings'  => array(
          'background_type' => 'color',
          'background_gradient' => 'false',
          'background_color'  => '#fafafa',
          'background_color2'  => '#fafafa',
          'background_image' => '',
          'background_size' => '',
          'background_position' => '',
          'background_repeat' => '',
          'background_attachment' => '',
          'background_image_parallax' => 'false',
          'background_video_url' => '',
          'background_overlay_color_display' => 'false',
          'background_overlay_color' => 'rgba(1,1,1,.5)',
        ),

        /* footer */
        'custom_footer_layout' => '',
      ),
    );
  }
}

if(! function_exists('jayla_get_custom_metabox')) {
  /**
   * get custom metabox data
   *
   */
  function jayla_get_custom_metabox($post_id) {
    $value = get_post_meta( $post_id, '_jayla_metabox_custom_settings', true );
    if( ! empty($value) ) {
      return json_decode($value, true);
    } else {
      return;
    }
  }
}

if(! function_exists('flitnotheme_add_custom_toolbar_link')) {
  /**
   * add button custom designer
   */
  function flitnotheme_add_designer_toolbar_link($wp_admin_bar) {
    global $post;

    if ( ! is_super_admin()
		 || ! is_object( $wp_admin_bar )
		 || ! function_exists( 'is_admin_bar_showing' )
		 || ! is_admin_bar_showing()
     || ( ! is_page() && ! is_single() )
    ) {
  		return;
  	}

    $args = array(
      'id' => 'designer_current_page',
      'title' => __('Design Current Page', 'jayla'),
      'href' => '#',
      'meta' => array(
        'class' => 'theme-extends-button-admin-toolbar',
        'title' => __('Add custom design current page', 'jayla'),
      ),
      'parent' => 'customize',
    );

    $wp_admin_bar->add_node($args);
  }
}

if(! function_exists('jayla_starter_scripts')) {
  /**
   * move starter_scripts to footer
   * @since 1.0.0
   */
  function jayla_starter_scripts() {

  }
  add_action( 'wp_enqueue_scripts', 'jayla_starter_scripts' );
}

if(! function_exists('jayla_content_class_func')) {
	/**
	 * content class
	 */
	function jayla_content_class_func() {
		$classes = jayla_control_sidebar_class('content', false);
		echo apply_filters('jayla_content_end_class', $classes);
	}
}

if(! function_exists('jayla_sidebar_class_func')) {
	/**
	 * sidebar class
	 */
	function jayla_sidebar_class_func() {
		$classes = jayla_control_sidebar_class('sidebar', false);
		echo apply_filters('jayla_sidebar_end_class', $classes);
	}
	add_action('jayla_sidebar_class', 'jayla_sidebar_class_func');
}

if(! function_exists('jayla_attribute_render')) {
	/**
	 * attr render
	 * @since 1.0.0
	 */
	function jayla_attribute_render($attr_name, $attr_value) {
		return "{$attr_name}='{$attr_value}'";
	}
}

if(! function_exists('jayla_sidebar_sticky_attr_func')) {
	function jayla_sidebar_sticky_attr_func() {
		$post_id = jayla_get_post_id();

		$sidebar = fintotheme_sidebar_options();
		$sidebar_sticky = $sidebar['sticky'];

		$custom_metabox_data = jayla_get_custom_metabox($post_id);
		if(! empty($custom_metabox_data) && $custom_metabox_data['custom_sidebar'] == 'yes') {
			$sidebar_sticky = $custom_metabox_data['sidebar_sticky'];
		}

		if($sidebar_sticky == 'no') return;

		$sticky_data_element = json_encode(array(
			'topSpacing' 						=> 20,
		  'bottomSpacing' 				=> 20,
		  'containerSelector' 		=> '#main-content',
		  'innerWrapperSelector' 	=> '.widget-area__inner',
			'minWidth'							=> 991,
		));

		echo "data-sticky-element='{$sticky_data_element}'";
	}
}

if(! function_exists('jayla_search_form_ajax_load_data')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_search_form_ajax_load_data() {
		$content = '';
		$query = new WP_Query( array(
			's' => $_POST['s'],
			'post_status' => 'publish',
			'posts_per_page' => apply_filters('jayla_search_form_ajax_limit_items', 3) ) );

		if ( $query->have_posts() ) {
			ob_start();
			echo sprintf('<div class="result-count">%s %s <u>%s</u></div>', $query->found_posts, __('result(s) found for', 'jayla'), $_POST['s']);
			echo '<div class="result-items">';
			while ( $query->have_posts() ) { $query->the_post();
				do_action('jayla_search_form_loop_result_item');
			}
			echo '</div>';
			$content = ob_get_clean();
			wp_reset_postdata();
		} else {
			ob_start();
			echo sprintf('<div class="result-count">%s %s <u>%s</u></div>', '0', __('result found for', 'jayla'), $_POST['s']);
			$content = ob_get_clean();
		}

		wp_send_json(array( 's' => $_POST['s'], 'content' => $content ));
		exit();
	}
	add_action( 'wp_ajax_jayla_search_form_ajax_load_data', 'jayla_search_form_ajax_load_data' );
	add_action( 'wp_ajax_nopriv_jayla_search_form_ajax_load_data', 'jayla_search_form_ajax_load_data' );
}

if(! function_exists('jayla_search_form_loop_result_item_func')) {
	/**
	 * @since 1.0.0
 	 */
	function jayla_search_form_loop_result_item_func() {
		ob_start();
		?>
		<div class="post-item result-item">
			<div class="post-thumbnail">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('thumbnail'); ?>
					</a>
				<?php else:
					_e('No image...', 'jayla');
				endif; ?>
			</div>
			<div class="post-entry">
				<a href="<?php the_permalink(); ?>" class="post-link">
					<h4 class="post-title"><?php the_title(); ?></h4>
				</a>
				<div class="entry-meta">
					<div class="p-author">
						<?php echo sprintf('%s %s', _e('Written by', 'jayla'), get_the_author_link()); ?>
					</div>
					<?php
					$category_list = get_the_category_list(', ');
					if(! empty($category_list)) {
					?>
					<div class="p-cat-links">
						<?php echo sprintf('%s %s', __('Posted in', 'jayla'), $category_list); ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
		$content = ob_get_clean();

		echo apply_filters('jayla_search_form_loop_result_item_html', $content);
	}
}

if(! function_exists('jayla_get_taxonomy_list')) {
  /**
   * @since 1.0.0
   */
  function jayla_get_taxonomy_list() {
    $post_types = get_post_types( array(), 'names' );
    $results = array();
    foreach($post_types as $post_type) {
      $taxonomies = get_object_taxonomies($post_type, 'names');
      if($taxonomies && count($taxonomies) > 0) {
        $results[$post_type] = apply_filters( 'jayla_taxonomies_by_post_type_' . $post_type, $taxonomies );
      }
    }

    return apply_filters( 'jayla_list_taxonomies_by_post_type', $results );
  }
}

if(! function_exists('jayla_build_data_taxonomy_list')) {
  /**
   * @since 1.0.0
   */
  function jayla_build_data_taxonomy_list() {
    $data = jayla_get_taxonomy_list();
    if(! $data) return array();

    $result = array();
    foreach($data as $posttype => $taxonomies) {
      foreach($taxonomies as $taxonomy) {
        $taxonomy_obj = get_taxonomy( $taxonomy );
        array_push($result, array(
          'label' => $taxonomy_obj->label,
          'name' => $taxonomy_obj->name,
          'posttype' => $posttype,
        ));
      }
    }

    return apply_filters( 'jayla_taxonomy_list_filter', $result );;
  }
}

if(! function_exists('jayla_filter_list_taxonomies_by_post_type')) {
  /**
   * @since 1.0.0
   */
  function jayla_filter_list_taxonomies_by_post_type($data) {
    // unset($data['post']);
    unset($data['nav_menu_item']);
    unset($data['product_variation']);
    unset($data['delipress-campaign']);

    return $data;
  }
}

if(! function_exists('jayla_list_taxonomies_by_post')) {
  /**
   * @since 1.0.0
   */
  function jayla_list_taxonomies_by_post($taxonomies) {
    return array( 'category', 'post_tag' );
  }
}

if(! function_exists('jayla_get_post_id')) {
	/**
	 * get current post id
   * @since 1.0.0
	 */
	function jayla_get_post_id() {
		global $post;
		if(! $post) return;

		$postID = $post->ID;
		return apply_filters('jayla_get_post_id', $postID);
	}
}

if(! function_exists('jayla_filter_post_id_is_special_page')) {
  /**
   * @since 1.0.0
   * 
   */
  function jayla_filter_post_id_is_special_page($pid) {
    
    // check is posts page
    if( is_home() ) {
      $page_for_posts =  get_option( 'page_for_posts' );
      if( ! empty( $page_for_posts ) ) {
        return $page_for_posts;
      }
    }

    // check other page not ID
    if(is_home() || is_archive() || is_category() || is_author() || is_search() || is_404() || is_tag()) return;
    return $pid;
  }
}

if(! function_exists('jayla_heading_bar_filter_options')) {
  /**
   * @since 1.0.0
   * filter options heading bar page, single
   * @param {array} $opts
   *
   * @return {array}
   */
  function jayla_heading_bar_filter_options($opts = array()) {
    if(is_single() || is_page() || is_singular()){
      $post_id = jayla_get_post_id();
     
      $custom_metabox_data = jayla_get_custom_metabox($post_id);
      if(! empty($custom_metabox_data) && $custom_metabox_data['custom_heading_bar'] == 'yes') {
        $opts['display'] = $custom_metabox_data['custom_heading_bar_display'];
        $opts['title_display'] = $custom_metabox_data['custom_heading_bar_page_title_display'];
        $opts['breadcrumb_display'] = $custom_metabox_data['custom_heading_bar_breadcrumb_display'];
        $opts['content_align'] = $custom_metabox_data['custom_heading_bar_content_align'];
        $opts = array_replace_recursive($opts, $custom_metabox_data['custom_heading_bar_background_settings']);
      }
    }
    return $opts;
  }
}

if(! function_exists('jayla_get_taxonomy_name')) {
  /**
   * @since 1.0.0
   */
  function jayla_get_taxonomy_name() {
    $obj = get_queried_object();
    $taxonomy_name = isset($obj->taxonomy) ? $obj->taxonomy : 'default';

    return apply_filters( 'jayla_taxonomy_name_filter', $taxonomy_name );
  }
}

if(! function_exists('jayla_metabox_posttype_support')) {
  /**
   * @since 1.0.0
   * @see jayla_metabox_support_jetpack_posttype - 20
   *
   * @return {array}
   */
  function jayla_metabox_posttype_support() {
    return apply_filters( 'jayla_metabox_posttype_support_filter', array(
      'page' => 'customizeOverride',
      'post' => 'customizeOverride',
      'product' => 'customizeOverride',
    ) );
  }
}

if(! function_exists('jayla_metabox_support_jetpack_posttype')) {
  /**
   * @since 1.0.0
   * Support post type Portfolio & Testimonial
   *
   * @return {array}
   */
  function jayla_metabox_support_jetpack_posttype($data) {
    // check post type 'jetpack-portfolio' exist
    if ( post_type_exists( 'jetpack-portfolio' ) ) {
      $data['jetpack-portfolio'] = 'customizeOverride';
    }

    // check post type 'jetpack-portfolio' exist
    if ( post_type_exists( 'jetpack-testimonial' ) ) {
      $data['jetpack-testimonial'] = 'customizeOverride';
    }

    return $data;
  }
}

if(! function_exists('jayla_add_page_loading_class')) {
  /**
   * @since 1.0.0
   * Add body class page loading
   *
   * @return {array}
   */
  function jayla_add_page_loading_class($classes) {
    $options = jayla_get_option_type_json('jayla_global_settings', 'jayla_global_settings_default');
    $scrollTop = $options['loading_top_bar'];

    if($scrollTop['show'] == 'yes' ) {
      array_push($classes, '_page-loading-active');
    }

    return $classes;
  }
}

if(! function_exists('jayla_scss_variables_add_page_loading_color')) {
  /**
   * @since 1.0.0
   * Add SCSS variables page loading bar color
   *
   * @return {array}
   */
  function jayla_scss_variables_add_page_loading_color($data) {
    $options = jayla_get_option_type_json('jayla_global_settings', 'jayla_global_settings_default');
    $loadingTopBar = $options['loading_top_bar'];

    if(! empty($loadingTopBar['color'])) {
      $data['progress_bar'] = $loadingTopBar['color'];
    }

    return $data;
  }
}

if(! function_exists('jayla_style_inline_page_loading_color')) {
  /**
   * @since 1.0.0
   * Fix cache css file change page loading color
   *
   * @return {string}
   */
  function jayla_style_inline_page_loading_color($output) {
    $options = jayla_get_option_type_json('jayla_global_settings', 'jayla_global_settings_default');
    $loadingTopBar = $options['loading_top_bar'];

    if(! empty($loadingTopBar['color'])) {
      $output .= str_replace( '{{page_loading_color}}', $loadingTopBar['color'], '
      #page #nprogress .bar{ background: {{page_loading_color}}; }
      #page #nprogress .peg{ box-shadow: 0 0 10px {{page_loading_color}}, 0 0 5px {{page_loading_color}}; }
      #page #nprogress .spinner-icon{ border-top-color: {{page_loading_color}}; border-left-color: {{page_loading_color}}; } ' );
    }

    return $output;
  }
}

if(! function_exists('jayla_get_related_articles')) {
  /**
   * @since 1.0.0
   * Get post related
   *
   * @param {int} $limit
   */
  function jayla_get_related_articles($limit = 3) {
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if( empty($tags) ) return;

    $first_tag = $tags[0]->term_id;
		$args = array(
			'posts_per_page'=> $limit,
			'orderby'       => 'date',
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_type' 		=> get_post_type($post->ID),
      'post__not_in'  => array( $post->ID ),
      'tag__in'       => array( $first_tag ),
    );

    return get_posts($args);
  }
}

if(! function_exists('jayla_get_posttype_name')) {
  /**
   * @since 1.0.0
   */
  function jayla_get_posttype_name($posttype_slug, $e = false) {
    $obj = get_post_type_object( $posttype_slug );
    if(empty($obj)) return;

    if($e == true) {
      echo apply_filters('jayla_posttype_'. $posttype_slug .'_search_page_item_name', $obj->label);
    } else {
      return $obj->label;
    }
  }
}

if(! function_exists('jayla_remove_thumbnail_dimensions')) {
  /**
   * @since 1.0.0
   * @param {html} $html
   *
   * @return {html}
   */
  function jayla_remove_thumbnail_dimensions( $html ) {
    return preg_replace( '/(width|height)=\"\d*\"\s/', "", $html ); return $html;
  }
}

if ( ! function_exists( 'jayla_return_memory_size' ) ) {
	/**
	 * print theme requirements page
	 *
	 * @param string $size
	 */
	function jayla_return_memory_size( $size ) {
		$symbol = substr( $size, -1 );
		$return = (int)$size;
		switch ( strtoupper( $symbol ) ) {
			case 'P':
				$return *= 1024;
			case 'T':
				$return *= 1024;
			case 'G':
				$return *= 1024;
			case 'M':
				$return *= 1024;
			case 'K':
				$return *= 1024;
		}
		return $return;
	}
}

if(! function_exists('jayla_taxonomy_heading_bar_options_override')) {
  /**
   * @since 1.0.0
   */
  function jayla_taxonomy_heading_bar_background_options_override($options, $queried_object) {

    if(! class_exists( 'Carbon_Fields\Carbon_Fields' ) || empty( $queried_object->term_id ) ) return $options;
    $term_background_type = carbon_get_term_meta( $queried_object->term_id, 'heading_bar_custom_background_type' );
    $term_background_overlay = carbon_get_term_meta( $queried_object->term_id, 'heading_bar_custom_background_overlay_color_display' );

    if( ! empty($term_background_type) ) {
      $options['background_type'] = $term_background_type;

      switch($term_background_type) {
        case 'image':
          $options['background_image'] = carbon_get_term_meta( $queried_object->term_id, 'heading_bar_custom_background_image' );
          break;

        case 'color':
          $options['background_color'] = carbon_get_term_meta( $queried_object->term_id, 'heading_bar_custom_background_color' );
          break;

        case 'video':
          $options['background_video_url'] = carbon_get_term_meta( $queried_object->term_id, 'heading_bar_custom_background_video' );
          break;
      }
    }

    if( ! empty($term_background_overlay) ) {
      $options['background_overlay_color_display'] = carbon_get_term_meta( $queried_object->term_id, 'heading_bar_custom_background_overlay_color_display' );
      $options['background_overlay_color'] = carbon_get_term_meta( $queried_object->term_id, 'heading_bar_custom_background_overlay_color' );
    }

    return $options;
  }
}

if(! function_exists('jayla_get_wordpress_menus')) {
  /**
   * @since 1.0.0
   */
  function jayla_get_wordpress_menus($default = array()){
    $result = $default;
    $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
    if(! $menus && count($menus) <= 0) return $result;

    foreach($menus as $menu) {
      array_push( $result, array(
        'label' => $menu->name,
        'value' => $menu->slug,
      ) );
    }

    return $result;
  }
}

if(! function_exists('jayla_widget_get_list_menu_options')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_widget_get_list_menu_options() {
    $result = array( '' => __('- Select -', 'jayla') );
    $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
    if(! $menus && count($menus) <= 0) return $result;

    foreach($menus as $menu) {
      $result[$menu->slug] = $menu->name;
    }

    return $result;
  }
}

if(! function_exists('jayla_widget_element_class_display_inline')) {
  /**
   * @since 1.0.0
   */
  function jayla_widget_element_class_display_inline($output, $data) {
    $elements = apply_filters( 'jayla_widget_element_allow_display_inline', array(
      'logo',
      'search',
      'cart',
      'menu-offcanvas',
      'icon-font'
    ) );

    if(in_array($data['name'], $elements)) {
      if( isset( $data['params']['element_inline'] ) && $data['params']['element_inline'] == 'on' ) {
        array_push( $output, 'widget-element-display-inline' );
      }
    }

    return $output;
  }
}

if(! function_exists('jayla_is_blog_page_settings')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_is_blog_page_settings() {
    // check Carbon_Fields exist
    if(! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) return;

    Carbon_Fields\Container::make( 'post_meta', __( 'Blog', 'jayla' ) )
      ->where( 'post_type', '=', 'page' )
      ->set_context( 'side' )
      ->set_priority( 'low' )
      ->add_fields( array(

          Carbon_Fields\Field::make( 'checkbox', 'page_is_blog', __('Enable Current Page is Blog', 'jayla') )
            ->set_default_value( false )
            ->set_help_text( __('checked to set current page is blog.', 'jayla') ),

          Carbon_Fields\Field::make( 'select', 'blog_custom_layout', __('Blog Layout', 'jayla') )
            ->set_conditional_logic( array(
              array( 'field' => 'page_is_blog', 'value' => true )
            ) )
            ->add_options( apply_filters( 'jayla_page_custom_blog_layout', array(
              '' => __('Global', 'jayla'),
              'first-item-full' => __('Blog – First Item Full', 'jayla'),
              'featured-post-slide' => __('Blog – Featured Post Slide', 'jayla'),
            ) ) )
            ->set_help_text( __('Select custom layout for blog.', 'jayla') ),

          Carbon_Fields\Field::make( "multiselect", "featured_post_slide", __('Select Featured Post for Slide', 'jayla') )
            ->set_conditional_logic( array(
              array( 'field' => 'blog_custom_layout', 'value' => 'featured-post-slide' )
            ) )
            ->add_options( 'jayla_posts_computation_heavy_getter_function' )
            ->set_help_text( __('Select posts for top slide.', 'jayla') )
        )
      );
  }
}

if(! function_exists('jayla_posts_computation_heavy_getter_function')) {
  /**
   * @since 1.0.0
   */
  function jayla_posts_computation_heavy_getter_function() {
    $args = array(
      'post_type' => 'post',
      'posts_per_page' => -1,
    );

    $postslist = get_posts( $args );
    $result = array();

    if($postslist && count($postslist) > 0) {
      foreach($postslist as $_post) {
        $result[$_post->ID] = $_post->post_title;
      }
    }

    return $result;
  }
}

if(! function_exists('jayla_get_excerpt')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_get_excerpt($limit, $source = null){
    if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'... <a class="read-more theme-extends-read-more" href="'. esc_url( get_permalink() ) .'">'. __('Read More', 'jayla') .' <i class="ion-android-arrow-forward"></i></a>';
    return $excerpt;
  }
}

if(! function_exists('jayla_wp_get_sidebars_widgets_options')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_wp_get_sidebars_widgets_options($default = array()) {
    global $wp_registered_sidebars;
    $result = $default;

    if( $wp_registered_sidebars && count($wp_registered_sidebars) > 0 ) {
      foreach($wp_registered_sidebars as $s_name => $s_data ) {
        array_push( $result, array(
          'value' => $s_data['id'],
          'label' => $s_data['name'],
        ) );
      }
    }

    return $result;
  }
}

if(! function_exists('jayla_cs_sidebar_custom_params')) {
  /**
   * @since 1.0.0
   */
  function jayla_cs_sidebar_custom_params($sidebar) {
    $sidebar['before_widget'] = '<div id="%1$s" class="widget %2$s">';
    $sidebar['after_widget']  = '</div>';
    $sidebar['before_title']  = '<h3 class="gamma widget-title">';
    $sidebar['after_title']   = '</h3>';
    return $sidebar;
  }
}

if(! function_exists('jayla_mime_svg_type')) {
  /**
   * @since 1.0.0
   */
  function jayla_mime_svg_type($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
}

if(! function_exists('jayla_add_delipress_widgets')) {
  /**
   * @since 1.0.0
   * Add delipress widgets
   *
   * - Delipress custom form
   */
  function jayla_add_delipress_widgets($widgets) {
    if( class_exists('Delipress') ) {
      $root_path = get_template_directory() . '/inc/widgets';
      $widgets['Jayla_Widget_Delipress_Custom_Form'] = $root_path . '/class-widget-delipress-custom-form.php';
      $widgets['Jayla_Widget_Delipress_Custom_Mini_Form'] = $root_path . '/class-widget-deliperss-mini-form.php';
    }
    return $widgets;
  }
}

if(! function_exists('jayla_delipress_submit_custom_form_handle')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_delipress_submit_custom_form_handle() {
    extract( $_POST );
    if( empty($dp_email) || empty($dp_list_id) ) {
      wp_send_json_error( array( 'message' => __('Unsuccessful, please try again another time!', 'jayla') ) );
    } else {
      $result = delipress_create_subscriber_on_list( $dp_email, $dp_list_id );
      wp_send_json_success( $result );
    }
    exit();
  }
  add_action( 'wp_ajax_jayla_delipress_submit_custom_form_handle', 'jayla_delipress_submit_custom_form_handle' );
  add_action( 'wp_ajax_nopriv_jayla_delipress_submit_custom_form_handle', 'jayla_delipress_submit_custom_form_handle' );
}

if(! function_exists('jayla_widget_custom_search_ajax_func')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_widget_custom_search_ajax_func() {
    extract( $_POST['data'] );
    $query = new WP_Query( apply_filters( 'jayla_widget_custom_search_ajax_query_args', array(
      's' => $s,
      'post_status' => 'publish',
    ), $_POST['data'] ) );

    ob_start();
    /**
     * jayla_custom_search_post_before_result hook.
     *
     * @see jayla_custom_search_before_result - 20
     */
    do_action( 'jayla_custom_search_post_before_result', $query, $_POST['data'] );
    while ( $query->have_posts() ) {
      $query->the_post();
      ?>
      <div <?php post_class( 'post-item-search' ); ?>>
        <div class="__inner">
          <?php
            /**
             * jayla_custom_search_post_result_item hook.
             *
             * @see jayla_item_search_result_template - 20
             */
            do_action( 'jayla_custom_search_post_result_item' );
          ?>
        </div>
      </div>
      <?php
    }
    /**
     * jayla_custom_search_post_after_result hook.
     *
     * @see jayla_custom_search_after_result - 20
     */
    do_action( 'jayla_custom_search_post_after_result', $query, $_POST['data'] );
    wp_reset_postdata();
    $content = ob_get_clean();

    wp_send_json_success( array(
      'content' => $content,
    ) );
    exit();
  }
  add_action( 'wp_ajax_jayla_widget_custom_search_ajax_func', 'jayla_widget_custom_search_ajax_func' );
  add_action( 'wp_ajax_nopriv_jayla_widget_custom_search_ajax_func', 'jayla_widget_custom_search_ajax_func' );
}

if(! function_exists('jayla_get_delipress_list_opts')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_get_delipress_list_opts( $delipress_list = array() ) {
    if(! class_exists('Delipress') ) return $default;
    global $delipressPlugin;

    $list = $delipressPlugin->getService("ListServices")->getLists();
    if($list && count($list) > 0) {
      foreach( $list as $item ) {
        $delipress_list[$item->getId()] = $item->getName();
      }
    }

    return $delipress_list;
  }
}

if(! function_exists('jayla_post_single_layout_class')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_post_single_layout_class($classes) {
    global $post;
    $post_type = get_post_type( $post );

    if( is_single() && 'post' == $post_type) {
      $blog_settings = jayla_get_option_type_json('jayla_blog_settings', 'jayla_blog_settings_default');
      $blog_settings_detail = $blog_settings['detail'];
      $blog_layout = $blog_settings_detail['layout'];

      $classes[] = 'themeextends-blog-single-layout-' . $blog_layout;
    }

    return $classes;
  }
}

if(! function_exists('jayla_blog_layout_clean_custom_furygrid_opts') ) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_blog_layout_clean_custom_furygrid_opts( $opts = array() ) {

    $opts['desktop'] = 2;
    $opts['tablet'] = 2;
    $opts['mobile'] = 1;

    return $opts;
  }
}


if(! function_exists('jayla_get_post_likes')) {
  /**
   * @since 1.0.0
   */
  function jayla_get_post_likes($pid) {
    $likes_count = get_post_meta( $pid, 'post_likes', true );
		return ( $likes_count ) ? $likes_count : 0;
  }
}

if(! function_exists('jayla_update_post_likes')) {
  /**
   * @since 1.0.0
   */
  function jayla_update_post_likes($pid, $num) {
    return update_post_meta( $pid, 'post_likes', $num );
  }
}


if(! function_exists('jayla_post_likes_handle')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_post_likes_handle() {
    extract( $_POST['data'] );
    $pid = isset($pid) ? $pid : 0;

    $current_likes_count = jayla_get_post_likes( $pid );
    if( true == $inc ) {
      $new_likes_number = (int) $current_likes_count + 1;
    } else {
      $new_likes_number = (int) $current_likes_count - 1;
      $new_likes_number = ( $new_likes_number <= 0 ) ? 0 : $new_likes_number ;
    }

    $updated = jayla_update_post_likes($pid, $new_likes_number);

    wp_send_json_success( array(
      'success' => $updated,
      'inc' => (bool) $inc,
      'likes' => $new_likes_number,
    ) );
    exit();
  }

  add_action( 'wp_ajax_jayla_post_likes_handle', 'jayla_post_likes_handle' );
  add_action( 'wp_ajax_nopriv_jayla_post_likes_handle', 'jayla_post_likes_handle' );
}

if(! function_exists('jayla_header_strip_data_custom_in_page')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_header_strip_data_custom_in_page($data) {
    global $post;

    if( is_singular() ) {
      $custom_metabox_data = jayla_get_custom_metabox($post->ID);

      if(! empty($custom_metabox_data) && $custom_metabox_data['custom_header'] == 'yes') {

        $header_builder_layout = json_decode(get_theme_mod( 'jayla_header_builder_layout' ), true);
        $found_key = array_search($custom_metabox_data['custom_header_layout'], array_column($header_builder_layout, 'key'));

        $header_builder_data = array();
        if(! empty($found_key)) { $data = $header_builder_layout[$found_key]; }
      }
    }

    return $data;
  }
}

if(! function_exists('jayla_remove_heading_bar_setting_is_blog_page')) {
  /**
   * @since 1.0.0 
   */
  function jayla_remove_heading_bar_setting_is_blog_page($post_type, $post) {
    if( $post && ! empty( $post->ID ) ) {
      $blog_id = get_option( 'page_for_posts' );
      if( ! empty( $blog_id ) && $blog_id == $post->ID ) {
        remove_action( 'jayla_metabox_customize_settings_inner_general', 'jayla_metabox_customize_settings_inner_general_heading_bar', 20 );
      }
    }
  }
}

if(! function_exists('jayla_ajax_get_posts_scroll')) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_ajax_get_posts_scroll() {
    do_action( 'jayla_ajax_get_posts_scroll_action' , $_POST['params'] );
    exit();
  }
  add_action( 'wp_ajax_jayla_ajax_get_posts_scroll', 'jayla_ajax_get_posts_scroll' );
  add_action( 'wp_ajax_nopriv_jayla_ajax_get_posts_scroll', 'jayla_ajax_get_posts_scroll' );
}

if(! function_exists('jayla_get_server_status')) {
  /**
   * @since 1.0.2
   *  
   */
  function jayla_get_server_status($site, $port){
    $headers = @get_headers($site);
    return substr($headers[0], 9, 3);
  }
}

if(! function_exists('jayla_theme_mod_name_by_current_theme')) {
  /**
   * @since 1.0.3
   *  
   */
  function jayla_theme_mod_name_by_current_theme( $opt_name ) {
    $theme_data = wp_get_theme();
    $current_theme_name = $theme_data->name;

    return sprintf( '%s_%s', $current_theme_name, $opt_name );
  }
}
