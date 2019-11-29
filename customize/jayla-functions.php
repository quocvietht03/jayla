<?php
// Hook title desc on single product
add_filter('woocommerce_product_description_heading', '__return_empty_string');
// Hook add new layout on select
add_filter( 'bevc_Products_Grid_With_Filter_Bar_templates_select', 'jayla_bevc_Products_Grid_With_Filter_Bar_templates_select', 20, 1 );

if(! function_exists('jayla_bevc_Products_Grid_With_Filter_Bar_templates_select') ) {
  function jayla_bevc_Products_Grid_With_Filter_Bar_templates_select($layouts){
    $layouts[__('Jayla' , 'jayla')] = 'jayla';
    $layouts[__('Jayla Layout 2' , 'jayla')] = 'jayla_layout_2';
    return $layouts;
  }
}

// Hook filter bar product categories element
add_filter( 'bevc_element_products_grid_with_filter_bar__template_hook', 'jayla_bevc_element_products_grid_with_filter_bar__template_hook', 20, 2 );

if(! function_exists('jayla_bevc_element_products_grid_with_filter_bar__template_hook') ) {
  /**
   * @since 1.1.0
   *
   */
  function jayla_bevc_element_products_grid_with_filter_bar__template_hook($output, $attrs) {
    $shop_url = wc_get_page_permalink( 'shop' );
    switch ($attrs['layout']) {
      case 'jayla':
        ob_start();
        ?>
        <div class="woo-product-filter-nav-bar">
          <div class="row">
            <div class="col-md-4">
              <h3 class="vc_custom_heading theme_heading"><?php _e('Trending Products' , 'jayla') ?></h3>
            </div>
            <div class="col-md-8 text-md-right">
              <nav class="p-filter-nav bevc-furygrid-filter-nav text-uppercase">
                  <a href="#" class="p-filter-item _is-active" data-furygrid-filter-item="*"><?php _e('All' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.featured"><?php _e('Featured' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.sale"><?php _e('On-sale' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.product_cat-best-selling"><?php _e('Best selling' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.product_cat-top-rate"><?php _e('Top rate' , 'jayla') ?></a>
              </nav>
            </div>
          </div>
        </div>
        <?php
        $output = ob_get_clean();
        break;
      case 'jayla_layout_2':
        ob_start();
        ?>
        <div class="woo-product-filter-nav-bar">
          <div class="row">
            <div class="col-md-12 text-center">
              <nav class="p-filter-nav bevc-furygrid-filter-nav text-uppercase">
                  <a href="#" class="p-filter-item _is-active" data-furygrid-filter-item="*"><?php _e('All' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.featured"><?php _e('Featured' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.sale"><?php _e('On-sale' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.product_cat-best-selling"><?php _e('Best selling' , 'jayla') ?></a>
                  <a href="#" class="p-filter-item" data-furygrid-filter-item="li.product_cat-top-rate"><?php _e('Top rate' , 'jayla') ?></a>
              </nav>
            </div>
          </div>
        </div>
        <?php
        $output = ob_get_clean();
        break;
    }
  	return $output;
  }
}

// hook add new layout
add_filter('bevc_Products_Grid_With_Filter_Bar_templates', 'jayla_bevc_Products_Grid_With_Filter_Bar_templates', 20, 2);
if( !function_exists('jayla_bevc_Products_Grid_With_Filter_Bar_templates') ){
  function jayla_bevc_Products_Grid_With_Filter_Bar_templates($layouts, $attrs){
    $layouts['jayla'] = jayla_products_grid_with_filter_bar_render_template_default($attrs);
    $layouts['jayla_layout_2'] = jayla_products_grid_with_filter_bar_render_template_default($attrs);
    return $layouts;
  }
}

// function render template
if( !function_exists('jayla_products_grid_with_filter_bar_render_template_default') ){
  function jayla_products_grid_with_filter_bar_render_template_default($atts) {
      $layout = $atts['layout']; // default layout: default
      $furygrid_attr = wp_json_encode( array(
          'ItemSelector' => 'li.product',
          'Col' => (int) $atts['columns'],
          'Space' => (int) $atts['gap'],
          'Responsive' => array(
              991 => array(
                  'Col' => (int) $atts['grid_to_show_md'],
                  'Space' => 24,
              ),
              780 => array(
                  'Col' => (int) $atts['grid_to_show_sm'],
                  'Space' => 24,
              ),
              480 => array(
                  'Col' => (int) $atts['grid_to_show_esm'],
                  'Space' => 24,
              )
          )
      ) );
      ob_start();
      ?><div class="woocommerce products-grid-container">
          <ul class="products" data-bevc-furygrid='<?php echo esc_attr( $furygrid_attr ); ?>'>
              <li class="furygrid-sizer"></li>
              <li class="furygrid-gutter-sizer"></li>
              <?php
              /**
               * @hooks bevc_element_product_grid_with_filter_bar__item_layout_<layout>
               *
               * @see bevc_element_product_grid_with_filter_bar__item_layout_<layout>_func - 20
               */
              do_action(
                  'bevc_element_product_grid_with_filter_bar__item_layout_' . $layout,
                  array(
                      'p_number' => $atts['p_number'],
                      'paged' => 1 ),
                  $atts
              );
              ?>
          </ul>
      </div><?php
      return ob_get_clean();
  }
}

// render template
add_action('bevc_element_product_grid_with_filter_bar__item_layout_jayla','bevc_element_product_grid_with_filter_bar__item_layout_jayla_func');
add_action('bevc_element_product_grid_with_filter_bar__item_layout_jayla_layout_2','bevc_element_product_grid_with_filter_bar__item_layout_jayla_func');
if(! function_exists('bevc_element_product_grid_with_filter_bar__item_layout_jayla_func')) {
  /**
   * @since 1.0.0
   *
   */
  function bevc_element_product_grid_with_filter_bar__item_layout_jayla_func( $query = array(), $atts = array(), $echo = true ) {

    $products = BEVC_WooCommerce_Get_Products(array(
      'number'  => $query['p_number'],
      'paged'   => $query['paged'],
    ));

    $items_output = array();
    $template_args = array('show_rating' => true);
    if ( $products && $products->have_posts() ) {
        while ( $products->have_posts() ) {
            $products->the_post();
            ob_start();
            wc_get_template_part( 'content', 'product' );
            $html_item = ob_get_clean();
            array_push($items_output, $html_item);
        }
    }
    wp_reset_postdata();

    if( true == $echo )  echo implode( '',  $items_output );
    else return implode( '',  $items_output );
  }
}
// hook attribute product category item
add_action('bevc_element_custom_attr', 'bevc_product_cat_grid_item_custom_attr', 20, 2);
function bevc_product_cat_grid_item_custom_attr($base_name, $atts){
  if($base_name == 'bevc_product_cat_grid_item'):
    $el_class = $atts['el_class'] ? '.'.$atts['el_class'] : null;
    $design_selector = array(
      array(
        'name' => __('Product category image','jayla'),
        'selector' => '#page .bevc_product_cat_grid_item'.$el_class.' .p-cat-image'
      ),
      array(
        'name' => __('Product category entry wrap','jayla'),
        'selector' => '#page .bevc_product_cat_grid_item'.$el_class.' .cat-entry'
      ),
      array(
        'name' => __('Product category entry title','jayla'),
        'selector' => '#page .bevc_product_cat_grid_item'.$el_class.' .c-name'
      ),
      array(
        'name' => __('Product category entry subtitle','jayla'),
        'selector' => '#page .bevc_product_cat_grid_item'.$el_class.' .c-count'
      )
    );
    echo "data-design-name='". esc_attr__('Product category grid item','jayla') ."' data-design-selector='".esc_attr(wp_json_encode($design_selector))."'";
  endif;
}
// hook add template
add_filter( 'BEVC_Testimonial_Slide_templates_select', 'jayla_BEVC_Testimonial_Slide_templates_select', 20, 1 );

if(! function_exists('jayla_BEVC_Testimonial_Slide_templates_select') ) {
  function jayla_BEVC_Testimonial_Slide_templates_select($layouts){
    $layouts[__('Jayla' , 'jayla')] = 'jayla';
    $layouts[__('Layout 2' , 'jayla')] = 'layout_2';
    $layouts[__('Layout 3' , 'jayla')] = 'layout_3';
    return $layouts;
  }
}
// hook add new layout
add_filter('bevc_Testimonial_Slide_templates', 'jayla_bevc_Testimonial_Slide_templates', 20, 2);
if( !function_exists('jayla_bevc_Testimonial_Slide_templates') ){
  function jayla_bevc_Testimonial_Slide_templates($layouts, $attrs){
    $layouts['jayla'] = bevc_Testimonial_Slide_templates_render($attrs);
    $layouts['layout_2'] = bevc_Testimonial_Slide_templates_render($attrs);
    $layouts['layout_3'] = bevc_Testimonial_Slide_templates_render($attrs);
    return $layouts;
  }
}

// function render template
if( !function_exists('bevc_Testimonial_Slide_templates_render') ){
  function bevc_Testimonial_Slide_templates_render($atts) {
    $values = (array) vc_param_group_parse_atts( $atts['values'] );
    if( ! is_array($values) || count($values) <= 0 ) return;
    $block_items_output = array();

    $block_slick_opts = array(
      'adaptiveHeight'    => ($atts['adaptive_height'] == 'true')   ? true : false,
      'arrows'            => ($atts['arrows'] == 'true')            ? true : false,
      'autoplay'          => ($atts['autoplay'] == 'true')          ? true : false,
      'autoplaySpeed'     => (int) $atts['autoplay_speed'],
      'centerMode'        => ($atts['center_mode'] == 'true')       ? true : false,
      'centerPadding'     => $atts['center_padding'],
      'cssEase'           => $atts['css_ease'],
      'dots'              => ($atts['dots'] == 'true')              ? true : false,
      'draggable'         => ($atts['draggable'] == 'true')         ? true : false,
      'edgeFriction'      => floatval('0.15'),
      'infinite'          => ($atts['infinite'] == 'true')          ? true : false,
      'initialSlide'      => (int) $atts['initial_slide'],
      'slidesToScroll'    => (int) $atts['slides_to_scroll'],
      'slidesToShow'      => (int) $atts['slides_to_show'],
      'speed'             => (int) $atts['speed'],
      'rows'              => (int) $atts['rows'],
      'responsive'        => array(
        array(
          'breakpoint' => 991,
          'settings' => array(
            'slidesToShow' => (int) $atts['slides_to_show_md'],
            'centerPadding' => '0px',
          )
        ),
        array(
          'breakpoint' => 767,
          'settings' => array(
            'slidesToShow' => (int) $atts['slides_to_show_sm'],
            'centerPadding' => '0px',
          )
        ),
        array(
          'breakpoint' => 575,
          'settings' => array(
            'slidesToShow' => (int) $atts['slides_to_show_esm'],
            'centerPadding' => '0px',
          )
        ),
      )
    );

    $qoute_icon_left  = '<img class="__quote-icon-left" src="'. esc_url( BEVC_DIR_URL . '/assets/images/quotes.svg' ) .'" alt="'. esc_attr('quote left', 'jayla') .'">';
    $qoute_icon_right = '<img class="__quote-icon-right" src="'. esc_url( BEVC_DIR_URL . '/assets/images/quotes2.svg' ) .'" alt="'. esc_attr('quote right', 'jayla') .'">';

    foreach($values as $item) {
      array_push($block_items_output, implode('', array(
        '<div class="item">',
          '<div class="__item-inner">',
            '<div class="entry-content">'. $qoute_icon_left . ' ' . $item['message'] . '' . $qoute_icon_right .'</div>',
            '<div class="name">'. $item['name'] .'</div>',
            '<div class="position">'. $item['position'] .'</div>',
            $item['rating'] != '0' ? '<div class="rating">'. BEVC_Rating_Html( (int) $item['rating'], 5, false ) .'</div>' : null,
            '<div class="avatar"><img src="'. esc_url( BEVC_Get_Attachment_Src_By_ID($item['avatar']) ) .'" alt="'. esc_attr('image', 'jayla') .'" /></div>',
          '</div>',
        '</div>',
      )));
    }

    return implode('', array(
      '<div class="slick-carousel block-slide" data-bevc-slick=\''. wp_json_encode($block_slick_opts) .'\'>',
        implode('', $block_items_output),
      '</div>',
    ));
  }
}

// hook add template bevc_Blog_Slide_Item_templates_select
add_filter( 'bevc_Blog_Slide_Item_templates_select', 'jayla_bevc_Blog_Slide_Item_templates_select', 20, 1 );

if(! function_exists('jayla_bevc_Blog_Slide_Item_templates_select') ) {
  function jayla_bevc_Blog_Slide_Item_templates_select($layouts){
    $layouts[__('Jayla' , 'jayla')] = 'jayla';
    return $layouts;
  }
}

// hook add new layout bevc_Blog_Slide_Item_templates
add_filter('bevc_Blog_Slide_Item_templates', 'jayla_bevc_Blog_Slide_Item_templates', 20, 2);
if( !function_exists('jayla_bevc_Blog_Slide_Item_templates') ){
  function jayla_bevc_Blog_Slide_Item_templates($layouts, $attrs){
    $layouts['jayla'] = jayla_bevc_Blog_Slide_Item_templates_render($attrs);
    return $layouts;
  }
}
/* render html thumbnail */
function render_thumbnail($post, $atts) {
        $post_link = get_the_permalink();
        $thumbnail_html = '<img class="hentry wp-post-image placeholder-image" src="'. esc_url( BEVC_DIR_URL . '/assets/images/placeholder-image.jpg' ) .'" alt="'. esc_attr( get_the_title() ) .'">';
        if( has_post_thumbnail() ) {
            $thumbnail_html = get_the_post_thumbnail($post, $atts['thumbnail_size']);
        }
        $output = implode('', array(
            '<a class="p-thumbnail-wrap" href="'. esc_url( $post_link ) .'">',
                $thumbnail_html,
                '<span class="bevc-icon-next-arrow"></span>',
            '</a>',
        ));

        ob_start();
        ?>
        <a class="p-thumbnail-wrap" href="<?php echo esc_attr( $post_link ); ?>">
            <?php do_action( 'bevc_element_block_slide_items__thumbnail_before', $post, $atts ); ?>
            <?php echo "{$thumbnail_html}"; ?>
            <?php do_action( 'bevc_element_block_slide_items__thumbnail_after', $post, $atts ); ?>
            <span class="bevc-icon-next-arrow"></span>
        </a>
        <?php
        $output = ob_get_clean();

        return apply_filters( 'bevc_element_block_slide_items__thumbnail_html_filter', $output, $post, $atts);
    }
// function render template
if( !function_exists('jayla_bevc_Blog_Slide_Item_templates_render') ){
  function jayla_bevc_Blog_Slide_Item_templates_render($atts) {
    global $post;

    $post_link = get_the_permalink();

    return implode('', array(
        render_thumbnail($post, $atts),
        '<div class="p-entry bevc-content-align-'. esc_attr( $atts['l_default_content_alignment'] ) .'">',
            '<h3><a class="p-title" href="'. esc_url( $post_link ) .'">', get_the_title(), '</a></h3>',
            '<div class="p-meta">',
                '<div class="p-date">'. get_the_date() .'</div>',
            '</div>',
        '</div>',
    ));
  }
}

// hook add template bevc_Products_Listing_templates_select
add_filter( 'bevc_Products_Listing_templates_select', 'jayla_bevc_Products_Listing_templates_select', 20, 1 );

if(! function_exists('jayla_bevc_Products_Listing_templates_select') ) {
  function jayla_bevc_Products_Listing_templates_select($layouts){
    $layouts[__('Jayla' , 'jayla')] = 'jayla';
    return $layouts;
  }
}

// hook add new layout bevc_Blog_Slide_Item_templates
add_filter('bevc_Products_Listing_templates', 'jayla_bevc_Products_Listing_templates', 20, 2);
if( !function_exists('jayla_bevc_Products_Listing_templates') ){
  function jayla_bevc_Products_Listing_templates($layouts, $attrs){
    $layouts['jayla'] = jayla_bevc_Products_Listing_templates_render($attrs);
    return $layouts;
  }
}
// function render template
if( !function_exists('jayla_bevc_Products_Listing_templates_render') ){
  function jayla_bevc_Products_Listing_templates_render($atts) {
    $products = BEVC_WooCommerce_Get_Products(array(
      'number'  => $atts['p_number'],
      'show'    => $atts['p_show'],
      'orderby' => ( $atts['p_show'] == 'top_rated' ) ? 'top_rated' : $atts['p_orderby'],
      'order'   => $atts['p_order'],
    ));

    $items_output = array();
    $template_args = array('show_rating' => true);
    if ( $products && $products->have_posts() ) {
        while ( $products->have_posts() ) {
            $products->the_post();
            ob_start();
            wc_get_template( 'content-widget-product.php', $template_args );
            $html_item = ob_get_clean();
            array_push($items_output, $html_item);
        }
    }
    wp_reset_postdata();

    return implode('', array(
      '<div class="woocommerce">',
          ( ! empty($atts['title']) ) ? '<h3 class="product-listing-title">'. $atts['title'] .'</h3>' : '',
          '<ul class="product-listing">',
              implode('', $items_output),
          '</ul>',
      '</div>'
    ));
  }
}

if(! function_exists('bevc_add_param')){
  // Link your VC elements's folder
  function bevc_add_param(){
    /* For Row */
    vc_add_param('vc_row', array(
        'type' => 'textfield',
        'heading' => "Animate Delay",
        'param_name' => 'animate_delay',
        'value' => '0',
        'description' => __("Animate delay (s). Example: 0.5", "jayla")
    ));
    vc_add_param('vc_row', array(
        'type' => 'textfield',
        'heading' => "Animate Duration",
        'param_name' => 'animate_duration',
        'value' => '.6',
        'description' => __("Animate duration (s). Example: 0.6", "jayla")
    ));
    /* For Column */
    vc_add_param('vc_column', array(
        'type' => 'textfield',
        'heading' => "Animate Delay",
        'param_name' => 'animate_delay',
        'value' => '0',
        'description' => __("Animate delay (s). Example: 0.5", "jayla")
    ));
    vc_add_param('vc_column', array(
        'type' => 'textfield',
        'heading' => "Animate Duration",
        'param_name' => 'animate_duration',
        'value' => '.6',
        'description' => __("Animate duration (s). Example: 0.6", "jayla")
    ));
    /* For Text */
    vc_add_param('vc_column_text', array(
        'type' => 'textfield',
        'heading' => "Animate Delay",
        'param_name' => 'animate_delay',
        'value' => '0',
        'description' => __("Animate delay (s). Example: 0.5", "jayla")
    ));
    vc_add_param('vc_column_text', array(
        'type' => 'textfield',
        'heading' => "Animate Duration",
        'param_name' => 'animate_duration',
        'value' => '.6',
        'description' => __("Animate duration (s). Example: 0.6", "jayla")
    ));
    /* For Button */
    vc_add_param('vc_btn', array(
        'type' => 'textfield',
        'heading' => "Animate Delay",
        'param_name' => 'animate_delay',
        'value' => '0',
        'description' => __("Animate delay (s). Example: 0.5", "jayla")
    ));
    vc_add_param('vc_btn', array(
        'type' => 'textfield',
        'heading' => "Animate Duration",
        'param_name' => 'animate_duration',
        'value' => '.6',
        'description' => __("Animate duration (s). Example: 0.6", "jayla")
    ));
    /* For Button */
    vc_add_param('vc_custom_heading', array(
        'type' => 'textfield',
        'heading' => "Animate Delay",
        'param_name' => 'animate_delay',
        'value' => '0',
        'description' => __("Animate delay (s). Example: 0.5", "jayla")
    ));
    vc_add_param('vc_custom_heading', array(
        'type' => 'textfield',
        'heading' => "Animate Duration",
        'param_name' => 'animate_duration',
        'value' => '.6',
        'description' => __("Animate duration (s). Example: 0.6", "jayla")
    ));
    /* For Single Image */
    vc_add_param('vc_single_image', array(
        'type' => 'textfield',
        'heading' => "Animate Delay",
        'param_name' => 'animate_delay',
        'value' => '0',
        'description' => __("Animate delay (s). Example: 0.5", "jayla")
    ));
    vc_add_param('vc_single_image', array(
        'type' => 'textfield',
        'heading' => "Animate Duration",
        'param_name' => 'animate_duration',
        'value' => '.6',
        'description' => __("Animate duration (s). Example: 0.6", "jayla")
    ));
  }
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// check for plugin using plugin name
if ( jayla_is_wpbakery_activated() ) {
  add_action( 'vc_after_init', 'bevc_add_param' );
}
