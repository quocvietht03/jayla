<?php
/**
 * Jayla Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(! class_exists( 'Jayla' ) ) :

/**
 * The main Jayla class
 */
class Jayla {

    /**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
    function __construct() {
      	add_action( 'after_setup_theme',          array( $this, 'setup' ) );
		add_action( 'widgets_init',               array( $this, 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts',         array( $this, 'scripts' ),       10 );
		add_action( 'wp_enqueue_scripts',         array( $this, 'child_scripts' ), 30 ); // After WooCommerce.
		add_action( 'admin_enqueue_scripts', 	  array( $this, 'admin_scripts' ), 10 );
		add_filter( 'body_class',                 array( $this, 'body_classes' ) );
		add_filter( 'navigation_markup_template', array( $this, 'navigation_markup_template' ) );
	}

    /**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
    public function setup() {
		/*
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 */

		// Carbon_Fields boot
		if( class_exists( 'Carbon_Fields\Carbon_Fields' ) )
			\Carbon_Fields\Carbon_Fields::boot();

      	// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
		load_theme_textdomain( 'jayla', get_stylesheet_directory() . '/languages' );

      	// Loads wp-content/themes/jayla/languages/it_IT.mo.
		load_theme_textdomain( 'jayla', get_template_directory() . '/languages' );

      	/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

      	/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'gutenberg' );
		add_theme_support( 'align-wide' );

      	/**
	 	 * Enable support for site logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 110,
			'width'       => 470,
			'flex-width'  => true,
		) );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => esc_html__( 'Primary Menu', 'jayla' ),
			'secondary' => esc_html__( 'Secondary Menu', 'jayla' ),
			'handheld'  => esc_html__( 'Handheld Menu', 'jayla' ),
		) );

      	/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'widgets',
		) );

      	// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'jayla_custom_background_args', array(
			'default-color' => apply_filters( 'jayla_default_background_color', 'ffffff' ),
			'default-image' => '',
		) ) );

      	/**
		 *  Add support for the Site Logo plugin and the site logo functionality in JetPack
		 *  https://github.com/automattic/site-logo
		 *  http://jetpack.me/
		 */
		add_theme_support( 'site-logo', array( 'size' => 'full' ) );

      	// Declare WooCommerce support.
		add_theme_support( 'woocommerce');
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

      	// Declare support for title theme feature.
		add_theme_support( 'title-tag' );

		// Declare support for selective refreshing of widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
    }

	/**
	 * Register widget area.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	public function widgets_init() {
		$sidebar_args['sidebar'] = array(
			'name'          => __( 'Sidebar', 'jayla' ),
			'id'            => 'sidebar-1',
			'description'   => ''
		);

		$sidebar_args = apply_filters( 'jayla_sidebar_args', $sidebar_args );
		$sidebar_design_selector = json_encode(array(
			array( 'name' => __('Widget container', 'jayla'), 'selector' => '#page .widget-area .widget' ),
			array( 'name' => __('Widget link', 'jayla'), 'selector' => '#page .widget-area .widget a' ),
			array( 'name' => __('Widget link on :hover', 'jayla'), 'selector' => '#page .widget-area .widget a:hover' ),
		));

		foreach ( $sidebar_args as $sidebar => $args ) {

			$widget_tags = array(
				'before_widget' => '<div id="%1$s" class="widget %2$s" data-design-name="'. esc_attr__('Sidebar widget', 'jayla') .'" data-design-selector=\''. $sidebar_design_selector .'\'><div class="__widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3 class="gamma widget-title" data-design-name="'. esc_attr__('Widget title', 'jayla') .'" data-design-selector="#page .widget-area .widget-title">',
				'after_title'   => '</h3>',
			);

			$filter_hook = sprintf( 'jayla_%s_widget_tags', $sidebar );
			$widget_tags = apply_filters( $filter_hook, $widget_tags );

			if ( is_array( $widget_tags ) ) {
				register_sidebar( $args + $widget_tags );
			}
		}
	}

	/**
	 * Custom navigation markup template hooked into `navigation_markup_template` filter hook.
	 */
	public function navigation_markup_template() {
		$navigation_classes = apply_filters('jayla_navigation_class', array(
			'navigation', '%1$s',
		));

		$template  = '<nav id="post-navigation" class="'. esc_attr( implode(' ', $navigation_classes) ) .'" role="navigation" aria-label="' . esc_html__( 'Post Navigation', 'jayla' ) . '">';
		$template .= '<span class="screen-reader-text">%2$s</span>';
		$template .= '<div class="nav-links">%3$s</div>';
		$template .= '</nav>';

		return apply_filters( 'jayla_navigation_markup_template', $template );
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since  1.0.0
	 */
	public function scripts() {
		global $jayla_version, $post;

		/* styles */
		wp_enqueue_style( 'jayla-style', get_template_directory_uri() . '/style.css', '', $jayla_version );

		/* bootstrap 4.0.0 beta */
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/css/bootstrap.min.css', '', '4.0.0' );
		wp_enqueue_script( 'tether', get_template_directory_uri() . '/assets/vendors/tether/tether.min.js', array(), '1.3.3', true );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/js/bootstrap.min.js', array('jquery', 'tether'), '4.0.0', true );

		/* waypoints */
		wp_enqueue_script( 'waypoints', get_template_directory_uri().'/assets/vendors/waypoints.min.js', array('jquery'), '', true);
		
		/* fontawesome && ionicons */
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/vendors/font-awesome/css/font-awesome.min.css', '', '4.7.0' );
		wp_enqueue_style( 'ionicons', get_template_directory_uri() . '/assets/vendors/ionicons/css/ionicons.min.css', '', '2.0.1' );

		/* Slick carousel */
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/vendors/slick/slick.min.js', array('jquery'), '1.8.0', true );

		/* swiper */
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/assets/vendors/swiper/swiper.min.css', array(), '4.2.2' );

		/* theme style */
		wp_enqueue_style( 'jayla-frontend-style', get_template_directory_uri() . '/assets/css/jayla-frontend.bundle.css', '', $jayla_version );
		wp_add_inline_style( 'jayla-frontend-style', apply_filters('jayla_custom_style_inline', '') );

		/* theme designer */
		wp_enqueue_style( 'jayla-designer', get_template_directory_uri() . '/assets/css/designer.css', '', $jayla_version );
		wp_add_inline_style( 'jayla-designer', apply_filters('jayla_custom_style_theme_designer_inline', '') );

		wp_enqueue_style( 'jayla-designer-current-page', get_template_directory_uri() . '/assets/css/designer-current-page.css', '', $jayla_version );
		wp_add_inline_style( 'jayla-designer-current-page', apply_filters('jayla_custom_style_theme_designer_current_page_inline', '') );

		/* theme script */
		wp_enqueue_script( 'jayla-script', get_template_directory_uri() . '/assets/dist/jayla-frontend.bundle.js', array('jquery'), $jayla_version, true );
		wp_add_inline_script( 'jayla-script', apply_filters('jayla_custom_script_inline', '') );

		wp_localize_script( 'jayla-script', 'theme_script_object', apply_filters('jayla_theme_script_object', array(
			'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
			'site_url'		=> get_home_url(),
			'images' => array(
                'arrow_next' => get_template_directory_uri() . '/assets/images/svg-icons/arrow-next.svg',
                'arrow_prev' => get_template_directory_uri() . '/assets/images/svg-icons/arrow-prev.svg',
			),
			'language' => array(
				'TEXT_NEXT' => esc_html__('Next', 'jayla'),
				'TEXT_PREV' => esc_html__('Prev', 'jayla'),
				'TEXT_MORE' => esc_html__('More', 'jayla'),
				'TEXT_FILTER' => esc_html__('Filter', 'jayla'),
			),
		))) ;

		/* user logged in */
		if( is_user_logged_in() ) {

			/* wp media */
			wp_enqueue_media();

			/* vue & vuex */
			wp_enqueue_script( 'vue', get_template_directory_uri() . '/assets/vendors/vue/vue.min.js', array(), '2.4.4', true );
			wp_enqueue_script( 'vuex', get_template_directory_uri() . '/assets/vendors/vue/vuex.min.js', array('vue'), '2.4.0', true );

			/* element-ui */
			wp_enqueue_style( 'element-ui', get_template_directory_uri() . '/assets/vendors/element-ui/element-ui.css', array(), '1.4.6', 'all' );
			wp_enqueue_script( 'element-ui', get_template_directory_uri() . '/assets/vendors/element-ui/element-ui.js', array('vue'), '1.4.6', true );
			wp_enqueue_script( 'element-ui-en', get_template_directory_uri() . '/assets/vendors/element-ui/element-ui-en.js', array('element-ui'), '1.4.6', true );

			/* theme designer frontend */
			wp_enqueue_script(
				'jayla-extends-designer-frontend', get_template_directory_uri() . '/assets/dist/jayla-extends-designer-frontend.bundle.js',
				array(
					'jquery',
					'jquery-ui-draggable',
					'jayla-script',
				),
				$jayla_version,
				true
			);

			wp_localize_script(
				'jayla-extends-designer-frontend',
				'theme_extends_designer_frontend_object',
				apply_filters('jayla_theme_extends_designer_frontend_script_object', array(
					'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
					'post_id'		=> jayla_get_post_id(),
					'language' 		=> array(),
				)));

		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Enqueue child theme stylesheet.
	 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
	 * primary css and the separate WooCommerce css.
	 *
	 * @since  1.0.0
	 */
	public function child_scripts() {
		if ( is_child_theme() ) {
			wp_enqueue_style( 'jayla-child-style', get_stylesheet_uri(), '' );
		}
	}

	/**
	 * admin include scripts
	 * @since 1.0.0
	 *
	 *
	 */
	public function admin_scripts() {
		global $jayla_version;

		/* theme backend style */
		wp_enqueue_style( 'jayla-backend-style', get_template_directory_uri() . '/assets/css/jayla-backend.bundle.css', '', $jayla_version );

		/* vue & vuex */
		wp_enqueue_script( 'vue', get_template_directory_uri() . '/assets/vendors/vue/vue.min.js', array(), '2.4.4', true );
		wp_enqueue_script( 'vuex', get_template_directory_uri() . '/assets/vendors/vue/vuex.min.js', array('vue'), '2.4.0', true );

		/* theme script */
		wp_enqueue_script( 'jayla-backend-script', get_template_directory_uri() . '/assets/dist/jayla-backend.bundle.js', array('jquery', 'vue', 'vuex'), $jayla_version, true );

		wp_localize_script( 'jayla-backend-script', 'theme_backend_script_object', apply_filters( 'jayla_theme_backend_script_object', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'metabox_posttype_support' => jayla_metabox_posttype_support(),
			'site_url' => get_site_url(),
			'language' => array(),
		) ) );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {

		}

		// If our main sidebar doesn't contain widgets, adjust the layout to be full-width.
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'jayla-full-width-content';
		}

		return $classes;
	}
}

endif;

return new Jayla();
