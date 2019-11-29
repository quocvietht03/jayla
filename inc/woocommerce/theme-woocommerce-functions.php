<?php

if(! function_exists('jayla_woo_settings_default')) {
  /**
   * @since 1.0.0
   *
   * @return {array}
   */
  function jayla_woo_settings_default() {
    return apply_filters('jayla_woocommerce_data_settings', array(
      /* shop page */
      'shop_layout' 					  => 'default',
      'shop_page_columns' 					  => 3,
      'shop_page_products_per_page' 	=> 9,

      'shop_archive_ajax_load_more_infinite_scroll' => 'no',

      'shop_archive_filter'           => 'yes',
      'shop_filter_layout'            => 'default', // default, off-canvas
      'shop_filter_default_columns'   => 3, // 3,4

      /* product detail */
      'product_detail_layout'					        => 'product-gallery-button-inline',
      'product_detail_show_related_products' 	=> 'yes',
      'product_detail_related_products_items' => 4,
      'product_detail_related_products_col'   => 4,
      'product_detail_sticky_bar'             => 'no',
      'product_detail_sticky_bar_position'    => 'top', // top, bottom

      /* image sizes */
      'thumbnail_image_width'					    => 350,
      'thumbnail_image_height'				    => 350,
      'thumbnail_image_crop'					    => 'yes',
      'gallery_thumbnail_image_width'			=> 150,
      'gallery_thumbnail_image_height'		=> 150,
      'gallery_thumbnail_image_crop'			=> 'yes',
      'single_image_width'					      => 640,
      'single_image_height'					      => 640,
      'single_image_crop'						      => 'no',
    ) );
  }
}


if(! function_exists('jayla_woo_get_shop_page_id')) {
  /**
   *
   */
  function jayla_woo_get_shop_page_id($postID) {
    if( is_shop() ) {
      $postID = get_option( 'woocommerce_shop_page_id' );
    }

    return $postID;
  }
  add_filter('jayla_get_post_id', 'jayla_woo_get_shop_page_id');
}

if(! function_exists('jayla_woo_custom_loop_add_to_cart_link')) {
  /**
   * custom button add to cart loop product
   */
  function jayla_woo_custom_loop_add_to_cart_link() {
    global $product;

    if ( $product ) {
  		$args_default = array(
  			'quantity' => 1,
  			'class'    => implode( ' ', array_filter( array(
            'theme-extends-woo-custom-button-add-to-cart',
  					'button',
  					'product_type_' . $product->get_type(),
  					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
  					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
  			) ) ),
  		);

      extract($args_default);

      echo apply_filters( 'jayla_woo_custom_loop_add_to_cart_link',
      	sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
      		esc_url( $product->add_to_cart_url() ),
      		esc_attr( isset( $quantity ) ? $quantity : 1 ),
      		esc_attr( $product->get_id() ),
      		esc_attr( $product->get_sku() ),
      		esc_attr( isset( $class ) ? $class : 'button' ),
      		sprintf('<i class="ion-plus"></i> <span>%s</span>', $product->add_to_cart_text())
      	),
      $product );
    }
  }
}

if(! function_exists('jayla_woocommerce_customize_opts')) {
  /**
   * WooCommerce customize opts
   * @since 1.0.0
   */
  function jayla_woocommerce_customize_opts() {
    // return $woo_settings;
    return Jayla_WooCommerce_Customizer::get_settings();
  }
}

if( ! function_exists('jayla_woocommerce_custom_image_size_thumbnail') ) {
  /**
   * WooCommerce custom product image size thubnail
   * @since 1.0.0
   * */
  function jayla_woocommerce_custom_image_size_thumbnail($size) {
    $woo_settings = Jayla_WooCommerce_Customizer::get_settings();

    return array(
      'width'   => (int) $woo_settings['thumbnail_image_width'],
      'height'  => (int) $woo_settings['thumbnail_image_height'],
      'crop'    => ( $woo_settings['thumbnail_image_crop'] == 'yes' ) ? true : false,
    );
  }
}

if( ! function_exists('jayla_woocommerce_custom_image_size_single') ) {
  /**
   * WooCommerce custom product image size single
   * @since 1.0.0
   */
  function jayla_woocommerce_custom_image_size_single($size) {
    $woo_settings = Jayla_WooCommerce_Customizer::get_settings();

    return array(
      'width'   => (int) $woo_settings['single_image_width'],
      'height'  => (int) $woo_settings['single_image_height'],
      'crop'    => ( $woo_settings['single_image_crop'] == 'yes' ) ? true : false,
    );
  }
}

if( ! function_exists('jayla_woocommerce_custom_image_size_gallery_thumbnail') ) {
  /**
   * WooCommerce custom product image size gallery thumbnail
   * @since 1.0.0
   */
  function jayla_woocommerce_custom_image_size_gallery_thumbnail($size) {
    $woo_settings = Jayla_WooCommerce_Customizer::get_settings();

    return array(
      'width'   => (int) $woo_settings['gallery_thumbnail_image_width'],
      'height'  => (int) $woo_settings['gallery_thumbnail_image_height'],
      'crop'    => ( $woo_settings['gallery_thumbnail_image_crop'] == 'yes' ) ? true : false,
    );
  }
}

if(! function_exists('jayla_woo_list_taxonomies_by_product')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_list_taxonomies_by_product($taxonomies) {
    return array(
      'product_cat',
      'product_tag'
    );
  }
}

if(! function_exists('jayla_woo_add_shoppage_for_taxonomy')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_add_shoppage_for_taxonomy($data) {
    array_unshift($data, array(
      'label' => __('Shop Page', 'jayla'),
      'name' => 'shop',
      'posttype' => 'woocommerce',
    ));

    return $data;
  }
}

if(! function_exists('jayla_woo_taxonomy_name_is_shoppage')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_taxonomy_name_is_shoppage($taxonomy_name) {
    if( is_shop() ) { $taxonomy_name = 'shop'; }
    return $taxonomy_name;
  }
}

if(! function_exists('jayla_woo_heading_title_shop_page')) {
  /**
   * @since 1.0.0
   * Filter heading title
   * @param {array} $data
   *
   * @return {array}
   */
  function jayla_woo_heading_title_shop_page($data) {
    if(is_shop()) {
      $shop_page_id = wc_get_page_id( 'shop' );
      $title =  get_the_title($shop_page_id);
      $data = array($title);
    }

    return $data;
  }
}

if(! function_exists('jayla_woo_related_products')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_woo_related_products($related_posts) {
    global $post;
    $woo_settings = Jayla_WooCommerce_Customizer::get_settings();
    $product_detail_show_related_products = $woo_settings['product_detail_show_related_products'];

    $metabox_data = jayla_get_custom_metabox($post->ID);
    if(
      isset($metabox_data['custom_product_detail']) &&
      $metabox_data['custom_product_detail'] == 'true' &&
      isset($metabox_data['custom_product_detail_settings']) ) {

        // custom product related
        if(isset($metabox_data['custom_product_detail_settings']['show_related_products']))
          $product_detail_show_related_products = $metabox_data['custom_product_detail_settings']['show_related_products'];
    }

    if($product_detail_show_related_products != 'yes') {
      return array();
    }

    return $related_posts;
  }
}

if(! function_exists('jayla_woo_related_products_args')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_related_products_args($args) {
    $woo_settings = Jayla_WooCommerce_Customizer::get_settings();

    $args['posts_per_page'] = (int) $woo_settings['product_detail_related_products_items']; // 4 related products
    $args['columns'] = (int) $woo_settings['product_detail_related_products_col']; // arranged in 2 columns

    return $args;
  }
}

if(! function_exists('jayla_woo_shop_page_id')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_shop_page_id($pid) {
    if( is_shop() ) {
      return wc_get_page_id( 'shop' );
    }
    return $pid;
  }
}

if(! function_exists('jayla_woo_sidebar_archive_page_false')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_sidebar_archive_page_false() {
    if( is_shop() ) { return false; }
  }
}

if(! function_exists('jayla_woo_product_detail_layout')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_product_detail_layout() {
    return apply_filters( 'jayla_woo_product_detail_layout_filter', array(
      'default' => __('Default', 'jayla'),
      'product-gallery-button-inline' => __( 'Gallery Slide Button Inline', 'jayla' ),
      'product-sticky-content' => __('Sticky Content', 'jayla'),
      'product-gallery-grid' => __('Gallery Grid', 'jayla'),
      'product-entry-accordion' => __('Tabs to Accordion', 'jayla'),
    ) );
  }
}

if(! function_exists('jayla_woo_shop_layout')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_shop_layout() {
    return apply_filters( 'jayla_woo_shop_layout', array(
      'default' => __('Default', 'jayla'),
      'icons-hover' => __( 'Icons on hover', 'jayla' ),
      'icons-hover-horizontal' => __( 'Icons horizontal on hover', 'jayla' ),
    ) );
  }
}

if(! function_exists('jayla_woo_metabox_product_default_data')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_metabox_product_default_data($data, $post) {
    $woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
    
    $data['settings']['custom_product_detail'] = 'false';
    $data['settings']['custom_product_detail_settings'] = array(
      'layout' => $woo_settings['product_detail_layout'],
      'show_related_products' => $woo_settings['product_detail_show_related_products'],
      'product_detail_sticky_bar' => $woo_settings['product_detail_sticky_bar'],
      'product_detail_sticky_bar_position' => $woo_settings['product_detail_sticky_bar_position'], // top, bottom
    );

    return $data;
  }
}

if(! function_exists('jayla_woo_single_product_gallery_custom_layout')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_single_product_gallery_custom_layout($classes) {

    if ( !is_product() || !is_single() ) return;
    global $post;

		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
    $product_detail_layout = $woo_settings['product_detail_layout'];

    $metabox_data = jayla_get_custom_metabox($post->ID);
    if(
      isset($metabox_data['custom_product_detail']) &&
      $metabox_data['custom_product_detail'] == 'true' &&
      isset($metabox_data['custom_product_detail_settings']) ) {

        // custom product detaiol layout
        if(isset($metabox_data['custom_product_detail_settings']['layout']))
          $product_detail_layout = $metabox_data['custom_product_detail_settings']['layout'];
    }

    if( ! empty( $product_detail_layout ) ) {
      array_push( $classes, '__woo-product-gallery-custom-layout-' . $product_detail_layout );
    }

    return $classes;
  }
}

if(! function_exists('jayla_woo_single_product_custom_hook_by_layout')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_single_product_custom_hook_by_layout() {
    if ( !is_product() || !is_single() ) return;
    global $post;

		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
    $product_detail_layout = $woo_settings['product_detail_layout'];

    $metabox_data = jayla_get_custom_metabox($post->ID);
    if(
      isset($metabox_data['custom_product_detail']) &&
      $metabox_data['custom_product_detail'] == 'true' &&
      isset($metabox_data['custom_product_detail_settings']) ) {

        // custom product detail layout
        if(isset($metabox_data['custom_product_detail_settings']['layout']))
          $product_detail_layout = $metabox_data['custom_product_detail_settings']['layout'];
    }

		switch($product_detail_layout) {
      case 'product-sticky-content':
        // remove gallery
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        add_action('woocommerce_before_single_product_summary', 'jayla_woo_show_product_images', 20);

				// remove product data tabs
				// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        break;

      case 'product-gallery-grid':
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        add_action('woocommerce_before_single_product_summary', 'jayla_woo_show_product_gallery_grid_images', 20);

        break;

      case 'product-gallery-button-inline':
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        add_action('woocommerce_before_single_product_summary', 'jayla_woo_show_product_images_layout_gallery_slide_button_inline', 20);
        break;

      case 'product-entry-accordion':
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        add_action('woocommerce_before_single_product_summary', 'jayla_woo_show_product_images_layout_gallery_slide_button_inline', 20);
        
        
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 35 );

        remove_action( 'jayla_woo_product_tabs', 'jayla_woo_product_tabs_default', 20 );
        add_action( 'jayla_woo_product_tabs', 'jayla_woo_product_accordion_ui', 20 );
        break;

      default:
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        add_action('woocommerce_before_single_product_summary', 'jayla_woo_show_product_images_layout_default', 20);
        break;
		}
	}
}

if(! function_exists('jayla_woo_term_meta_background_fields_support_category_product_cat')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_term_meta_background_fields_support_category_product_cat($data = array()) {
    array_push($data, 'product_cat');
    return $data;
  }
}

if(! function_exists('jayla_woo_product_meta_field_video')) {
  /**
   * @since 1.0.0
   * Product add meta field video
   */
  function jayla_woo_product_meta_field_video() {
    // check Carbon_Fields exist
    if(! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) return;

    Carbon_Fields\Container::make( 'post_meta', __( 'Product video', 'jayla' ) )
      ->where( 'post_type', '=', 'product' )
      ->set_context( 'side' )
      ->set_priority( 'low' )
      ->add_fields( array(
        Carbon_Fields\Field::make( 'text', 'jayla_product_video', __('Video Url', 'jayla') )
          ->set_attribute('placeholder', __('product video url', 'jayla'))
          ->set_help_text(__('You can use url Youtube or Vimeo for this field.', 'jayla')),
      ) );
  }
}

if(! function_exists('jayla_woo_widgets_include')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_widgets_include($widgets) {
    $root_path = get_template_directory() . '/inc/widgets';

    $widgets['Jayla_Widget_Product_Custom_Search'] = $root_path . '/class-widget-product-search.php';
    $widgets['Jayla_Widget_Mini_Cart'] = $root_path . '/class-widget-minicart.php';
    $widgets['Jayla_Widget_Product_Categories_Width_Icon'] = $root_path . '/class-widget-product-category-width-icon.php';

    return $widgets;
  }
}

if(! function_exists('jayla_woo_widget_get_product_options')) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_widget_get_product_options($default = array()) {
    $args = array(
      'posts_per_page'   => -1,
      'offset'           => 0,
      'post_type'        => 'product',
      'post_status'      => 'publish',
    );
    $result = $default;
    $_query = get_posts($args);
    if($_query) {
      foreach($_query as $p) {
        $result[$p->ID] = $p->post_title;
      }

    }

    return $result;
  }
}

if(! function_exists('jayla_woo_product_item_widget_search_temp')) {
  function jayla_woo_product_item_widget_search_temp($product) {
    $output = array();

    $sale = ($product->is_on_sale() == true) ? '<span class="__p-on-sale">'. __('Sale', 'jayla') .'</span>' : '';
    array_push($output, implode('', array(
        '<div class="p-result-item">',
            '<a href="'. esc_url( $product->get_permalink() ) .'">',
                '<div class="thumbnail">',
                    $product->get_image('thumbnail'),
                '</div>',
                '<div class="p-entry">',
                    '<div class="p-title">'. $sale . $product->get_title() .'</div>',
                    '<div class="p-price">'. $product->get_price_html() .'</div>',
                '</div>',
            '</a>',
        '</div>',
    )));

    return implode($output);
  }
}

if(! function_exists('jayla_woo_widget_product_search_func')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_woo_widget_product_search_func() {
    extract($_POST);
    $args = array(
      'posts_per_page'   => 5,
      'offset'           => 0,
      'post_type'        => 'product',
      'post_status'      => 'publish',
      's'                => $s,
    );

    if( !empty($term) ) {
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'product_cat',
          'field'    => 'slug',
          'terms'    => $term,
        ),
      );
    }

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) {
      $product_items = array();
      while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $product = wc_get_product(get_the_ID());
        array_push($product_items, jayla_woo_product_item_widget_search_temp($product));
      }

      wp_send_json_success( array(
        's' => $s,
        'total_posts' => sprintf('%d result(s) found for: %s', (int) $the_query->found_posts, $s),
        'html_content' => implode('', $product_items),
      ) );

      /* Restore original Post Data */
      wp_reset_postdata();
    } else {
      wp_send_json_success( array(
        's' => $s,
        'total_posts' => __('Did not find any result for: ' . $s, 'jayla'),
        'html_content' => __('Empty, please try again with another keyword!', 'jayla'),
      ) );
    }

    exit();
  }

  add_action( 'wp_ajax_jayla_woo_widget_product_search_func', 'jayla_woo_widget_product_search_func' );
  add_action( 'wp_ajax_nopriv_jayla_woo_widget_product_search_func', 'jayla_woo_widget_product_search_func' );
}

if( ! function_exists('jayla_woo_move_comment_and_rating_field_to_top') ) {
  /**
   * @since 1.0.0
   */
  function jayla_woo_move_comment_and_rating_field_to_top( $fields ) {
    if ( is_product() && is_single() ){
      $comment_field = $fields['comment'];

      unset( $fields['comment'] );
      $fields = array('comment' => $comment_field) + $fields;
    }

    return $fields;
  }
}

if(! function_exists('jayla_woo_ajax_get_image_by_id')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_woo_ajax_get_image_by_id() {
    extract( $_POST );

    $image_large_data = wp_get_attachment_image_src( (int) $att_id, 'large' );
    $image_medium_data = wp_get_attachment_image_src( (int) $att_id, 'medium' );
    $image_thumbnail_data = wp_get_attachment_image_src( (int) $att_id, 'thumbnail' );

    wp_send_json_success( array(
      'id' => $att_id,
      'thumbnail_src' => ( false == $image_thumbnail_data ) ? '' : $image_thumbnail_data[0],
      'medium_src' => ( false == $image_medium_data ) ? '' : $image_medium_data[0],
      'large_src' => ( false == $image_large_data ) ? '' : $image_large_data[0],
    ) );
    exit();
  }

  add_action( 'wp_ajax_jayla_woo_ajax_get_image_by_id', 'jayla_woo_ajax_get_image_by_id' );
  add_action( 'wp_ajax_nopriv_jayla_woo_ajax_get_image_by_id', 'jayla_woo_ajax_get_image_by_id' );
}

if(! function_exists('jayla_woo_widget_custom_minicart_layout_data')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_woo_widget_custom_minicart_layout_data() {
    return apply_filters( 'jayla_woo_widget_custom_minicart_layout_data_filter', array(
      array(
        'name' => 'default',
        'label' => __('Default — My Shopping Bag', 'jayla'),
        'selector' => '.theme-extends-widget-mini-cart._layout-default .theme-widget-woo-mini-cart-container',
        'callback_content' => 'jayla_woo_widget_minicart_layout_default',
      ),
      array(
        'name' => 'bag_only_icon',
        'label' => __('Bag — Only Icon', 'jayla'),
        'selector' => '.theme-extends-widget-mini-cart._layout-bag_only_icon .theme-widget-woo-mini-cart-container',
        'callback_content' => 'jayla_woo_widget_minicart_layout_bag_only_icon',
      ),
      array(
        'name' => 'cart_only_icon',
        'label' => __('Cart — Only Icon', 'jayla'),
        'selector' => '.theme-extends-widget-mini-cart._layout-cart_only_icon .theme-widget-woo-mini-cart-container',
        'callback_content' => 'jayla_woo_widget_minicart_layout_cart_only_icon',
      ),
    ) );
  }
}

if(! function_exists('jayla_widget_mini_cart_layout_options')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_widget_mini_cart_layout_options() {
    $opts = array();
    $widget_minicart_data = jayla_woo_widget_custom_minicart_layout_data();

    if( count( $widget_minicart_data ) > 0 ) {
      foreach( $widget_minicart_data as $item ) {
        $opts[$item['name']] = $item['label'];
      }
    }

    return $opts;
  }
}

if(! function_exists('jayla_ti_woocommerce_wishlist_counter_widget')) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_ti_woocommerce_wishlist_counter_widget($widgets) {

    if( class_exists('TInvWL') ) {
      $root_path = get_template_directory() . '/inc/widgets';
      $widgets['Jayla_Widget_Wishlist_Products_Counter'] = $root_path . '/class-widget-wishlist-products-counter.php';
    }

    return $widgets;
  }
}

if( ! function_exists('jayla_woo_widget_wishlist_products_counter_custom_fragment') ) {
  /**
   * @since 1.0.0
   *
   */
  function jayla_woo_widget_wishlist_products_counter_custom_fragment( $fragments ) {

    if( class_exists('TInvWL') && class_exists('TInvWL_Public_TopWishlist') ) {
      $count = TInvWL_Public_TopWishlist::counter();
      $classes = array( 'theme_extends_wishlist_products_counter_number' );
      if( empty( $count ) || $count <= 0 ) { array_push( $classes, '__empty' ); }

      $fragments['span.theme_extends_wishlist_products_counter_number'] = sprintf( '<span class="%s" data-design-name="'. esc_attr__( 'Wishlist counter', 'jayla' ) .'" data-design-selector="#page .theme-extends-widget-wishlist-products-counter .theme_extends_wishlist_products_counter_number">%s</span>', implode(' ', $classes), apply_filters( 'tinvwl_wishlist_products_counter', $count ) );
    }

    return $fragments;
  }
}

if( ! function_exists('jayla_woo_widget_minicart_custom_fragment') ) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_woo_widget_minicart_custom_fragment( $fragments ) {
		$widget_minicart_data = jayla_woo_widget_custom_minicart_layout_data();

		foreach( $widget_minicart_data as $item ) {
			$content = ( function_exists( $item['callback_content'] ) ) ? call_user_func($item['callback_content']) : '';
			$fragments[$item['selector']] = $content;
		}

		$count = WC()->cart->get_cart_contents_count();
		$fragments['sup.theme-extends-woo-minicart-count'] = ! empty( $count ) ? '<sup class="theme-extends-woo-minicart-count">'. WC()->cart->get_cart_contents_count() .'</sup>' : '';

		return $fragments;
	}
}

if( ! function_exists('jayla_woo_remove_sidebar_on_page_cart_checkout') ) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_woo_remove_sidebar_on_page_cart_checkout( $data ) {
    if (is_cart() || is_checkout() ) {
      return false;
    }

    return $data;
  }
}

if(! function_exists('jayla_woo_custom_main_columns_on_page_cart_checkout')) {
  function jayla_woo_custom_main_columns_on_page_cart_checkout( $data ) {
    if (is_cart() || is_checkout() ) {
      return 'col-lg-12 col-sm-12';
    }
    
    return $data;
  }
}

if(! function_exists('jayla_woo_register_shop_sidebar')) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_woo_register_shop_sidebar( $data ) {
    $data['shop-archive-filter-sidebar'] = array(
			'name'          => __( 'Shop Archive Filter Sidebar', 'jayla' ),
			'id'            => 'shop-archive-filter-sidebar',
			'description'   => 'WooCommerce - Shop archive filter sidebar.'
    );
    
    return $data;
  }
}

if(! function_exists('jayla_woo_add_custom_meta_field_icon_for_product_cat')) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_woo_add_custom_meta_field_icon_for_product_cat() {
    // check Carbon_Fields exist
    if(! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) return;

    Carbon_Fields\Container::make( 'term_meta', __( 'Category Properties', 'jayla' ) )
      ->where( 'term_taxonomy', '=', 'product_cat' )
      ->add_fields( array(
          Carbon_Fields\Field::make( 'image', 'p_cat_icon', __( 'Icon Image', 'jayla' ) )
            ->set_value_type( 'url' ),
      ) );
  }
}

if(! function_exists('jayla_woo_custom_sidebar_class_shop_archive_page')) {
  /**
   * @since 1.0.0 
   * 
   */
  function jayla_woo_custom_sidebar_class_shop_archive_page( $data ) {

    if( is_tax( 'product_cat' ) ) {
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );
      if( ! empty( $shop_page_id ) ) {
        $metabox_data = jayla_get_custom_metabox($shop_page_id);
        if( ! empty( $metabox_data ) && 'yes' == $metabox_data['custom_sidebar'] ) {
          $data = $metabox_data['sidebar_layout'];
          if( 'no-sidebar' == $data ) {
            add_filter( 'jayla_show_sidebar_filter', '__return_false' );
          }
        }
      }
    }

    return $data;
  }
}

if(! function_exists('jayla_woo_get_product_column_classes')) {
  /**
   * @since 1.0.0
   * 
   */
  function jayla_woo_get_product_column_classes( $columns ) {
  
    $preset_columns = array(
      2 => 'col-md-6 col-sm-6 col-6',
      3 => 'col-lg-4 col-md-6 col-sm-6 col-6',
      4 => 'col-lg-3 col-md-6 col-sm-6 col-6',
      6 => 'col-lg-2 col-md-4 col-sm-6 col-6',
      'slide-col-2' => 'col-2',
      'slide-col-3' => 'col-4',
      'slide-col-4' => 'col-3',
      'slide-col-6' => 'col-2',
    );
  
    return apply_filters( 'jayla_woo_get_product_column_classes_filter', $preset_columns[ $columns ], $columns );
  }
}

if(! function_exists('jayla_woo_post_class_custom') ) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_woo_post_class_custom( $classes, $class, $post_id ) {
    global $woocommerce_loop;

    if( is_shop() || is_product_category() || is_product_tag() || in_array( $woocommerce_loop['name'], array( 'related', 'up-sells', 'cross-sells' ) ) ) {
      $post_type = get_post_type( $post_id );
      if( 'product' == $post_type ) {
        $classes_remove = array( 'first', 'last' );
        foreach( $classes_remove as $class_item ) {
          $key = array_search( $class_item, $classes, true );
          if ( false !== $key ) {
            unset( $classes[ $key ] );
          }
        }
      }

      $columns = jayla_loop_columns();
      $col_classes = jayla_woo_get_product_column_classes( $columns );
      array_push( $classes, apply_filters( 'jayla_woo_post_class_custom_in_loop', $col_classes, $woocommerce_loop['name'] ), 'themeextends-product-column-custom-classes' );
    }

    return $classes;
  }
}

if(! function_exists('jayla_woo_post_class_custom_in_loop_related_upsells')) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_woo_post_class_custom_in_loop_related_upsells( $classes, $loop_name ) {
    if(! in_array( $loop_name, array( 'related', 'up-sells' ) ) ) return $classes;

    $woo_settings = Jayla_WooCommerce_Customizer::get_settings();
    $args['columns'] = (int) $woo_settings['product_detail_related_products_col']; // arranged in 2 columns

    // return jayla_woo_get_product_column_classes( 'slide-col-' . $args['columns'] );
    return jayla_woo_get_product_column_classes( $args['columns'] );
  }
}

if(! function_exists('jayla_woo_post_class_custom_in_loop_crosssells')) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_woo_post_class_custom_in_loop_crosssells( $classes, $loop_name ) {
    if( 'cross-sells' != $loop_name ) return $classes; 
    return jayla_woo_get_product_column_classes( 3 );
  }
}

if(! function_exists('jayla_woo_custom_classes_shop_archive_loop_start')) {
  /**
   * @since 1.0.0
   *  
   */
  function jayla_woo_custom_classes_shop_archive_loop_start( $classes ) {
    global $woocommerce_loop;
    $is_shortcode = $woocommerce_loop['is_shortcode'];

    if( empty( $is_shortcode ) ) {
      $classes .= 'row themeextends-product-custom-row-classes';
    } else {
      $classes .= 'columns-' .  $woocommerce_loop['columns'];
    }

    return $classes;
  }
}

