<?php /**
 * WooCommerce Template Functions.
 *
 * @package jayla
 */

if ( ! function_exists( 'jayla_woo_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function jayla_woo_before_content() {
		$product_single = is_product();

		/* container class */
		ob_start(); do_action('jayla_container_class');
		$container_classes = ob_get_clean();

		/* content class */
		ob_start(); do_action('jayla_content_class');
		$content_classes = ob_get_clean();

		$temp = array(
			'product-single' => implode('', array(
				'<div id="main-content" class="theme-extends-woo-product-single-main-content">',
					'<div id="primary">',
						'<main id="main" class="site-main" role="main">',
			)),
			'#' => implode('', array(
				'<div id="main-content">',
					'<div class="'. $container_classes .'">',
						'<div class="row">',
							'<div id="primary" class="content-area '. $content_classes .'">',
								'<main id="main" class="site-main" role="main">',
			)),
		);

		echo sprintf( '%s', ($product_single == true) ? $temp['product-single'] : $temp['#'] );
	}
}

if ( ! function_exists( 'jayla_woo_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function jayla_woo_after_content() {
		$product_single = is_product();

		/* sidebar */
		ob_start(); do_action( 'jayla_sidebar' );
		$sidebar = ob_get_clean();

		$temp = array(
			'product-single' => implode('', array(
				'</div>', /* close #main-content */
				'</div>', /* close #primary */
				'</main>', /* close #main */
			)),
			'#' => implode('', array(
				'</main>', /* close #main */
				'</div>', /* close #primary */
				$sidebar,
				'</div>', /* close .row */
				'</div>', /* close container */
				'</div>', /* close #main-content */
			)),
		);

		echo sprintf( '%s', ($product_single == 1) ? $temp['product-single'] : $temp['#'] );
	}
}

if(! function_exists('jayla_woo_show_page_title')) {
  /**
   * disable page title
   */
  function jayla_woo_show_page_title() {
    return false;
  }
}

if ( ! function_exists( 'jayla_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function jayla_sorting_wrapper() {
		echo '<div class="jayla-woo-sorting">';
	}
}

if ( ! function_exists( 'jayla_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function jayla_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'jayla_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper
	 *
	 * @since   2.2.0
	 * @return  void
	 */
	function jayla_product_columns_wrapper() {
		// $columns = jayla_loop_columns();
		// echo '<div class="woocommerce columns-' . intval( $columns ) . '">';

		// $columns = jayla_loop_columns();
		echo '<div class="woocommerce themeextends-products-wrapper">';
	}
}

if (! function_exists( 'jayla_loop_columns' )) {
	/**
	 * loop columns on product archives
	 *
	 * @return integer products per row
	 * @since  1.0.0
	 */
	function jayla_loop_columns() {
		$woo_settings = jayla_woocommerce_customize_opts();
		$columns = (int) $woo_settings['shop_page_columns'];

		return apply_filters( 'jayla_loop_columns', $columns ); // 3 products per row
	}
}

if(! function_exists('jayla_loop_shop_per_page')) {
	/**
	 * loop products on product archives
	 * @since 1.0.0
	 */
	function jayla_loop_shop_per_page($cols) {
		$woo_settings = jayla_woocommerce_customize_opts();
		$new_cols = (int) $woo_settings['shop_page_products_per_page'];

		return $new_cols;
	}
}

if(! function_exists('jayla_woo_before_link_open')) {
	/**
	 * Open <div> wrap thumbnail link
	 */
	function jayla_woo_before_link_open() {
		?>
		<div class="theme-extends-woo-loop-item-wrap-thumbnail">
			<div class="theme-extends-woo-before-loop-thumbnail-link"><?php do_action('jayla_woo_before_loop_thumbnail_link'); ?></div>
		<?php
	}
}


if(! function_exists('jayla_woo_after_link_close')) {
	/**
	 * Close <div> wrap thumbnail link
	 */
	function jayla_woo_after_link_close() {
		?>
			<div class="theme-extends-woo-after-loop-thumbnail-link"><?php do_action('jayla_woo_after_loop_thumbnail_link'); ?></div>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_thumbnail_secondary')) {
  /**
   * get thumbnail secondary product loop
   */
  function jayla_woo_thumbnail_secondary() {
    global $product;
    $gallery_ids = $product->get_gallery_image_ids();
    if(empty($gallery_ids) && count($gallery_ids) <= 0) return;

    $first_gallery_id = $gallery_ids[0];
    list($img_url, $img_width, $img_height) = wp_get_attachment_image_src($first_gallery_id, 'woocommerce_thumbnail');

    if(empty($img_url)) return;
    ?>
    <span
	  class="theme-extends-woo-product-thumbnail-background"
	  data-background-image-lazyload-onload="<?php echo esc_attr($img_url); ?>"
      style=""></span>
    <?php
  }
}

if(! function_exists('jayla_woo_show_product_loop_sale_flash')) {
	/**
	 * custom sale flash
	 */
	function jayla_woo_show_product_loop_sale_flash() {
		global $product;
		if ( ! $product->is_on_sale() ) return;
		echo '<span class="theme-extends-woo-sale-flash">'. apply_filters('jayla_woo_loop_product_sale_text', 'Sale') .'</span>';
	}
}

if(! function_exists('jayla_woo_show_product_loop_outstock')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_show_product_loop_outstock() {
		global $product;
		if( ! function_exists('wc_get_stock_html') ) return;

		echo wc_get_stock_html($product);
	}
}

if(! function_exists('jayla_woo_show_product_loop_featured')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_show_product_loop_featured() {
		global $product;
		$classes = array('theme-extends-woo-featured');
		if ( $product->is_on_sale() ) {
			array_push($classes, '__has-on-sale');
		}

		if( $product->is_featured() ) {
			?>
			<span class="<?php echo implode(' ', $classes) ?>"><?php _e('New', 'jayla') ?></span>
			<?php
		}
	}
}

if(! function_exists('jayla_woo_tinvwl')) {
	/**
	 * Woo WISHLIST
	 *
	 */
	function jayla_woo_tinvwl() {
		if (! class_exists('TInvWL')) return;
		$pos = tinv_get_option('add_to_wishlist_catalog', 'position');

		if('shortcode' == $pos) echo implode('', array(
			'<div class="theme-extends-woo-ti_wishlists">',
				do_shortcode("[ti_wishlists_addtowishlist loop=yes]"),
			'</div>',
		));
	}
}

if(! function_exists('jayla_woo_open_product_list_item_wrap_entry')) {
	/**
	 * Open product list item wrap entry (title, price)
	 */
	function jayla_woo_open_product_list_item_wrap_entry() {
		do_action('jayla_woo_before_loop_item_wrap_entry');
		echo '<div class="theme-extends-woo-loop-item-wrap-entry">';
	}
}

if(! function_exists('jayla_woo_close_product_list_item_wrap_entry')) {
	/**
	 * Close product list item wrap entry (title, price)
	 */
	function jayla_woo_close_product_list_item_wrap_entry() {
		echo '</div>';
		do_action('jayla_woo_after_loop_item_wrap_entry');
	}
}

if(! function_exists('jayla_change_gallery_columns')) {
	/**
	 * change gallery 1 col
	 * @since 1.0.0
	 */
	function jayla_change_gallery_columns() {
	     return 1;
	}
}

if(! function_exists('jayla_woo_product_detail_wrap_open')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_product_detail_wrap_open() {
		?>
		<div class="jayla-woo-single-wrap">
		<?php
	}
}

if(! function_exists('jayla_woo_product_detail_wrap_close')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_product_detail_wrap_close() {
		?>
		</div> <!-- Close jayla-woo-single-wrap -->
		<?php
	}
}

if(! function_exists('jayla_woo_product_detail_summary_wrap_open')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_product_detail_summary_wrap_open() {
		$classes_inner = apply_filters( 'jayla_woo_product_detail_summary_wrap_open_classes_inner_filter', array( '__inner' ) );
		?>
		<div class="jayla-woo-single-summary-wrap" data-design-name="<?php echo esc_attr('Product summary wrap', 'jayla'); ?>" data-design-selector="#page .jayla-woo-single-summary-wrap">
			<div class="<?php do_action('jayla_container_class') ?>">
				<div class="jayla-woo-single-summary-container">
					<?php
					/**
					 * @see jayla_woo_product_nav()
					 */
					do_action('jayla_woo_product_before_summary_container'); ?>
					<div id="themeextends-woo-product-inner-container" class="<?php echo esc_attr( implode( ' ', $classes_inner ) ); ?>">
		<?php
	}
}

if(! function_exists('jayla_woo_product_detail_summary_wrap_close')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_product_detail_summary_wrap_close() {
		?>
					</div> <!-- Close .__inner -->
					<?php do_action('jayla_woo_product_after_summary_container'); ?>
				</div> <!-- Close .jayla-woo-single-summary-container -->
			</div> <!-- Close container -->
		</div> <!-- Close jayla-woo-single-summary-wrap -->
		<?php
	}
}

if(! function_exists('jayla_woo_product_before_summary_open_container')) {
	/**
	 * summary open container
	 */
	function jayla_woo_product_before_summary_open_container() {
		echo '<div class="theme-extends-woo-summary-top-open-container">';
	}
}

if(! function_exists('jayla_woo_product_before_summary_close_container')) {
	/**
	 * summary close container
	 */
	function jayla_woo_product_before_summary_close_container() {
		echo '</div> <!-- Close .theme-extends-woo-summary-top-open-container -->';
	}
}

if(! function_exists('jayla_woo_product_nav')) {
	/**
	 * product navicon
	 * @since 1.0.0
	 */
	function jayla_woo_product_nav() {
		global $product;
		$next_post		= get_next_post();
		$previous_post 	= get_previous_post();
		?>
		<nav class="theme-extends-woo-product-nav">
			<?php if(! empty($previous_post)) { 
				$previous_product = new WC_Product( $previous_post );
				$previous_post_mousetip_html = implode( '', array(
					"<div class='__woo-product-mousetip-wrapper'>",
						"<div class='__p-thumbnail'>". $previous_product->get_image( 'thumbnail' ) ."</div>",
						"<div class='__p-entry'>",
							"<div class='__title'>". esc_attr( $previous_post->post_title ) ."</div>",
							"<div class='__price'>". $previous_product->get_price_html() ."</div>",
						"</div>",
					"</div>",
				) );
				?>
			<a href="<?php echo get_permalink($previous_post->ID); ?>" class="nav-item" mousetip mousetip-pos="bottom left" mousetip-css-padding="10px" mousetip-css-borderradius="1px" mousetip-css-background="#FFF" mousetip-css-color="#222" mousetip-msg="<?php echo esc_attr( $previous_post_mousetip_html ); // esc_attr($previous_post->post_title); ?>" mousetip-enable-html><i class="ion-android-arrow-back"></i></a>
			<?php } ?>
			<a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" class="nav-item" mousetip mousetip-pos="bottom left" mousetip-css-padding="5px 15px" mousetip-css-borderradius="1px" mousetip-css-background="#FFF" mousetip-css-color="#222" mousetip-msg="<?php _e('Return to Shop', 'jayla'); ?>"><i class="ion-grid"></i></a>
			<?php if(! empty($next_post)) { 
				$next_product = new WC_Product( $next_post );
				$next_post_mousetip_html = implode( '', array(
					"<div class='__woo-product-mousetip-wrapper'>",
						"<div class='__p-thumbnail'>". $next_product->get_image( 'thumbnail' ) ."</div>",
						"<div class='__p-entry'>",
							"<div class='__title'>". esc_attr( $next_post->post_title ) ."</div>",
							"<div class='__price'>". $next_product->get_price_html() ."</div>",
						"</div>",
					"</div>",
				) );
				?>
			<a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-item" mousetip mousetip-pos="bottom left" mousetip-css-padding="10px" mousetip-css-borderradius="1px" mousetip-css-background="#FFF" mousetip-css-color="#222" mousetip-msg="<?php echo esc_attr( $next_post_mousetip_html ); ?>" mousetip-enable-html><i class="ion-android-arrow-forward"></i></a>
			<?php } ?>
		</nav>
		<?php
	}
}

if(! function_exists('jayla_woo_breadcrumbs')) {
	/**
	 * change breadcrumbs
	 */
	function jayla_woo_breadcrumbs() {
		$design_selector = json_encode(array(
			array(
				'name' => __('Breadcrumb Wrap', 'jayla'),
				'selector' => '#page .theme-extends-woo-breadcrumb',
			),
			array(
				'name' => __('Breadcrumb Link', 'jayla'),
				'selector' => '#page .theme-extends-woo-breadcrumb a',
			),
			array(
				'name' => __('Breadcrumb Link (:hover)', 'jayla'),
				'selector' => '#page .theme-extends-woo-breadcrumb a:hover',
			),
		));

    return array(
      'delimiter'   => ' <i class="fa fa-angle-right"></i> ',
      'wrap_before' => '<nav class="woocommerce-breadcrumb theme-extends-woo-breadcrumb" itemprop="breadcrumb" data-design-name="'. __('Breadcrumb', 'jayla') .'" data-design-selector=\''. $design_selector .'\'> <i class="fa fa-home"></i>',
      'wrap_after'  => '</nav>',
      'before'      => '<span class="theme-extends-breadcrumb-segment">',
      'after'       => '</span>',
      'home'        => __( 'Home', 'jayla' ),
    );
	}
}

if(! function_exists('jayla_woo_after_single_product_summary_wrap_open')) {
	function jayla_woo_after_single_product_summary_wrap_open() {

		/* container class */
		ob_start(); do_action('jayla_container_class');
		$container_classes = ob_get_clean();

		echo implode('', array(
			'<div class="jayla-woo-single-summary-bottom-wrap">',
				'<div class="'. $container_classes .'">',
					'<div class="jayla-woo-single-summary-bottom-container">',
						'<div class="__inner">',
		));
	}
}

if(! function_exists('jayla_woo_after_single_product_summary_wrap_close')) {
	function jayla_woo_after_single_product_summary_wrap_close() {
		echo implode('', array(
						'</div> <!-- close .__inner -->',
					'</div> <!-- close .jayla-woo-single-summary-bottom-container -->',
				'</div> <!-- close container -->',
			'</div> <!-- close .jayla-woo-single-summary-bottom-wrap -->',
		));
	}
}

if(! function_exists('jayla_woo_product_tabs')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_product_tabs($tabs) {
		// global $product;
    //
		// if(isset($tabs['reviews'])) {
		// 	$review_count = $product->get_review_count();
		// 	$tabs['reviews']['title'] = sprintf('%s <span class="badge badge-primary">%s</span>', __('Reviews', 'jayla'), $review_count);
		// }

		return $tabs;
	}
}

if(! function_exists('jayla_woo_product_reviews_title_tabs')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_product_reviews_title_tabs($key) {
		global $product;

		$review_count = $product->get_review_count();
		return sprintf('%s <span class="theme-extends-badge">%s</span>', __('Reviews', 'jayla'), $review_count);
	}
}

if(! function_exists('jayla_woo_attr_designer_wc_tabs')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_attr_designer_wc_tabs() {
		$design_selector = json_encode(array(
			array('name' => __('Tabs wrap', 'jayla'), 'selector' => '#page .theme-extends-wc-tabs-wrap ul.wc-tabs'),
			array('name' => __('Tab item', 'jayla'), 'selector' => '#page .theme-extends-wc-tabs-wrap ul.wc-tabs li a'),
			array('name' => __('Tab item active', 'jayla'), 'selector' => '#page .theme-extends-wc-tabs-wrap ul.wc-tabs li.active a'),
		));
		?>
		data-design-name="<?php esc_attr_e('Tabs', 'jayla'); ?>"
		data-design-selector="<?php echo esc_attr($design_selector); ?>"
		<?php
	}
}

if(! function_exists('jayla_woo_cross_sells_total')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_cross_sells_total() {
		$limit = apply_filters('jayla_woo_cross_sells_limit', 2);
		return $limit;
	}
}

if(! function_exists('jayla_woo_return_shopping')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_return_shopping() {
		$shop_url = wc_get_page_permalink( 'shop' );
		?>
		<a href="<?php echo esc_url($shop_url); ?>" class="theme-extends-woo-continue-shopping" data-design-name="<?php esc_attr_e('Continue shop link', 'jayla'); ?>" data-design-selector=".woocommerce-cart #page .theme-extends-woo-cart-sidebar a.theme-extends-woo-continue-shopping" href="<?php echo esc_url($shop_url); ?>"><?php _e('Continue Shopping', 'jayla') ?> <i class="ion-android-arrow-forward"></i></a>
		<?php
	}
}

if(! function_exists('jayla_woo_designer_cart_form_attr')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_designer_cart_form_attr() {
		$design_selector = wp_json_encode(array(
			array('name' => __('Cart table wrap', 'jayla'), 'selector' => '.woocommerce-cart #page .woocommerce-cart-form table.woocommerce-cart-form__contents'),
			array('name' => __('Cart table heading (thead > th)', 'jayla'), 'selector' => '.woocommerce-cart #page .woocommerce-cart-form table.woocommerce-cart-form__contents thead th'),
			array('name' => __('Cart table product name', 'jayla'), 'selector' => '.woocommerce-cart #page .woocommerce-cart-form table.woocommerce-cart-form__contents .product-name a'),
			array('name' => __('Cart table product name (:hover)', 'jayla'), 'selector' => '.woocommerce-cart #page .woocommerce-cart-form table.woocommerce-cart-form__contents .product-name > a:hover'),
			array('name' => __('Cart table product price', 'jayla'), 'selector' => '.woocommerce-cart #page .woocommerce-cart-form table.woocommerce-cart-form__contents .amount'),
		));
		?>
		 data-design-name="<?php _e('Cart table', 'jayla'); ?>"
		 data-design-selector='<?php echo esc_attr($design_selector); ?>'
		<?php
	}
}

if(! function_exists('jayla_woo_designer_cart_sidebar_attr')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_designer_cart_sidebar_attr() {
		$design_selector = wp_json_encode(array(
			array('name' => __('Cart total wrap', 'jayla'), 'selector' => '.woocommerce-cart #page .theme-extends-woo-cart-sidebar .cart_totals'),
			array('name' => __('Cart total heading', 'jayla'), 'selector' => '.woocommerce-cart #page .theme-extends-woo-cart-sidebar .cart_totals h2'),
			array('name' => __('Cart total price', 'jayla'), 'selector' => '.woocommerce-cart #page .theme-extends-woo-cart-sidebar .cart_totals .order-total .amount'),
		));
		?>
		 data-design-name="<?php _e('Cart sidebar', 'jayla'); ?>"
		 data-design-selector='<?php echo esc_attr($design_selector); ?>'
		<?php
	}
}

if(! function_exists('jayla_woo_designer_checkout_customer_details')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_designer_checkout_customer_details() {
		$design_selector = wp_json_encode(array(
			array('name' => __('Checkout billing details wrap', 'jayla'), 'selector' => '.woocommerce-checkout #customer_details'),
			array('name' => __('Checkout billing details heading', 'jayla'), 'selector' => '.woocommerce-checkout #customer_details h3:not(#ship-to-different-address)'),
			array('name' => __('Checkout billing details field label', 'jayla'), 'selector' => '.woocommerce-checkout #customer_details .form-row > label'),
		));
		?>
		 data-design-name="<?php _e('Checkout billing details', 'jayla'); ?>"
		 data-design-selector='<?php echo esc_attr($design_selector); ?>'
		<?php
	}
}

if(! function_exists('jayla_woo_designer_checkout_order_review')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_designer_checkout_order_review() {
		$design_selector = wp_json_encode(array(
			array('name' => __('Checkout order review wrap', 'jayla'), 'selector' => '.woocommerce-checkout .theme-extends-woo-your-order #order_review'),
			array('name' => __('Checkout order review product name', 'jayla'), 'selector' => '.woocommerce-checkout .theme-extends-woo-your-order #order_review td.product-name'),
			array('name' => __('Checkout order review total price', 'jayla'), 'selector' => '.woocommerce-checkout .theme-extends-woo-your-order #order_review td.order-total .amount'),
			array('name' => __('Checkout order button submit', 'jayla'), 'selector' => '.woocommerce-checkout .theme-extends-woo-your-order #order_review input[type="submit"]'),
			array('name' => __('Checkout order button submit (:hover)', 'jayla'), 'selector' => '.woocommerce-checkout .theme-extends-woo-your-order #order_review input[type="submit"]:hover'),
		));
		?>
		 data-design-name="<?php _e('Checkout order review', 'jayla'); ?>"
		 data-design-selector='<?php echo esc_attr($design_selector); ?>'
		<?php
	}
}

if(! function_exists('jayla_woo_search_form_loop_result_item_html')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_search_form_loop_result_item_html($content) {
		$posttype = get_post_type();
		if('product' != $posttype) return $content;

		ob_start();
		global $product;
		?>
		<div class="post-item result-item woocommerce product-item">
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
					<div class="p-price">
						<?php echo sprintf('%s', $product->get_price_html()); ?>
					</div>
					<?php
					$category_list = get_the_term_list($product->get_id(), 'product_cat', '', ', ');
					if(! empty($category_list)) {
					?>
					<div class="p-cat-links">
						<?php echo sprintf('%s %s', __('Product in', 'jayla'), $category_list); ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

if(! function_exists('jayla_woo_header_widget')) {
	/**
	 * @since 1.0.0
	 * 	- add widget mini cart
	 */
	function jayla_woo_header_widget($widgets) {
		array_push($widgets, array(
		  	'element' => 'widget',
			'name' => 'cart',
			'title' => __('Cart', 'jayla'),
			'icon' => 'ion-ios-cart',
			'description' => __('WooCommerce mini cart' ,'jayla'),
		));

		return $widgets;
	}
}

if(! function_exists('jayla_woo_header_widget_options')) {
	/**
	 * @since 1.0.0
	 * - add mini cart options
	 */
	function jayla_woo_header_widget_options($opts) {

		/* widget cart */
	  $opts['widget-cart'] = array(
	    'groups' => array(
	      /* Group General */
	      array(
	        'title' => __('General', 'jayla'),
	        'name' => 'general',
	        'fields' => array(
				'cart_position' => array(
					'label' => __('Cart Position', 'jayla'),
					'description' => __('Select position(left/right) cart display (default: Left)', 'jayla'),
					'type' => 'select',
					'value' => 'left',
					'options' => array(
					array( 'value' => 'left', 'label' => __('Show on the left', 'jayla') ),
					array( 'value' => 'right', 'label' => __('Show on the right', 'jayla') ),
					)
				),
			  	'element_inline' => array(
					'label' => __('Inline', 'jayla'),
					'description' => __('element inline.', 'jayla'),
					'type' => 'switch',
					'value' => 'no',
					'placeholder' => 'on/off element inline.',
				),
				'id' => array(
					'label' => __('ID', 'jayla'),
					'description' => __('Enter ID for element.', 'jayla'),
					'type' => 'input',
					'value' => '',
					'placeholder' => '',
				),
				'extra_class' => array(
					'label' => __('Extra Class', 'jayla'),
					'description' => __('Enter custom class for element.', 'jayla'),
					'type' => 'input',
					'value' => '',
					'placeholder' => '',
				),
	        ),
	      ),
	      /* Group Style */
	      array(
	        'title' => __('Style', 'jayla'),
	        'name' => 'style',
	        'fields' => array(
	          'padding' => array(
	            'label' => __('Padding', 'jayla'),
	            'description' => __('Add padding for element', 'jayla'),
	            'type' => 'input',
	            'value' => '',
	            'placeholder' => '0px 0px 0px 0px',
	          ),
	          'margin' => array(
	            'label' => __('Margin', 'jayla'),
	            'description' => __('Add margin for element', 'jayla'),
	            'type' => 'input',
	            'value' => '',
	            'placeholder' => '0px 0px 0px 0px',
	          ),
	        ),
	      ),
	    )
	  );

		return $opts;
	}
}

if(! function_exists('jayla_widget_cart_element')) {
  /**
   * widget cart
   * @since 1.0.0
   */
  function jayla_widget_cart_element($data) {
    $params = array_merge(array(
		'cart_position'		=> 'left',
		'element_inline'	=> 'off',
      	'extra_class'   	=> '',
      	'id'            	=> '',
    ), $data['params'] );

    $classes = implode(' ', array( $params['extra_class'] ));
	$id_attr = (! empty($params['id'])) ? 'id="'. $params['id'] .'"' : '';

    $design_selector = sprintf('#page .element-%s a.__cart-icon', $data['key']);
	$classes_icon_cart = apply_filters('jayla-woo-classes-widget-icon-cart', 'fi flaticon-market');

    return implode('', array(
      '<div '. $id_attr .' class="'. esc_attr( $classes ) .'" data-design-name="'. esc_attr( $data['title'] ) .'" data-design-selector="'. $design_selector .'">',
        '<a
			href="javascript:"
			class="__cart-icon"
			data-theme-open-widget-cart-form=""
			data-cart-pos="'. esc_attr( $params['cart_position'] ) .'">
				<span class="'. esc_attr( $classes_icon_cart ) .'"></span>
				<div class="woo-shopping-bag-items-number">
					<span class="count __empty">0</span>
				</div>
		</a>',
      '</div>',
    ));
  }
}

if ( ! function_exists( 'jayla_woo_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function jayla_woo_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		jayla_woo_cart_contents_count();
		$fragments['.woo-shopping-bag-items-number > .count'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'jayla_woo_cart_contents_count' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function jayla_woo_cart_contents_count() {
		$count = WC()->cart->get_cart_contents_count();
		$classes_empty = (int) $count == 0 ? '__empty' : '';
		?>
		<span class="count <?php echo esc_attr($classes_empty); ?>">
			<?php echo sprintf('%d', WC()->cart->get_cart_contents_count()); ?>
		</span>
		<?php
	}
}


if(! function_exists('jayla_woo_shopping_mini_cart')) {
	/**
	 * @since 1.0.0
	 * shopping cart
	 */
	function jayla_woo_shopping_mini_cart() {
		$design_selector = wp_json_encode(array(
			array('name' => __('Mini-cart wrap', 'jayla'), 'selector' => 'body #theme-extends-widget-mini-cart'),
			array('name' => __('Mini-cart product title', 'jayla'), 'selector' => 'body .widget_shopping_cart_content .woocommerce-mini-cart-item a:not(.remove_from_cart_button)'),
			array('name' => __('Mini-cart product title (:hover)', 'jayla'), 'selector' => 'body .widget_shopping_cart_content .woocommerce-mini-cart-item a:not(.remove_from_cart_button):hover'),
			array('name' => __('Mini-cart button checkout', 'jayla'), 'selector' => 'body .widget_shopping_cart_content .woocommerce-mini-cart__buttons .button.checkout'),
			array('name' => __('Mini-cart button checkout (:hover)', 'jayla'), 'selector' => 'body .widget_shopping_cart_content .woocommerce-mini-cart__buttons .button.checkout:hover'),
			array('name' => __('Mini-cart background layout', 'jayla'), 'selector' => 'body #theme-extends-widget-mini-cart .__background-layout'),
		));

		$classes = apply_filters('jayla_woo_mini_cart_classes', array('theme-extends-widget-mimi-cart'));
		?>
		<div
			id="theme-extends-widget-mini-cart"
			class="<?php echo esc_attr( implode(' ', $classes) ); ?>"
			data-anim-box
			data-design-name="<?php esc_attr_e('Mini cart', 'jayla') ?>"
			data-design-selector="<?php echo esc_attr($design_selector); ?>">
			<div class="__background-layout"></div>
			<div class="__inner">
				<div class="widget_shopping_cart_content"></div>
			</div>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_add_script_scrollreveal')) {
	/**
	 * @since 1.0.0
	 * Script inline  scrollreveal
	 *
	 */
	function jayla_woo_add_script_scrollreveal($script) {
		if( is_shop() || is_product_category() || is_product_tag() ) {
			$script .= 'jQuery(function() { 
				sr.reveal( document.querySelectorAll(".woocommerce.themeextends-products-wrapper ul.products li.product") ); 
			})';

			return $script;
		}

		return $script;
	}
}

if(! function_exists('jayla_woo_breakline_sale_flash')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_breakline_sale_flash() {
		?>
		<div class="clear" style="margin-top: 10px;"></div>
		<?php
	}
}

if(! function_exists('jayla_woo_single_product_summary_wrap_open')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_single_product_summary_wrap_open() {
		$design_selector = apply_filters( 'jayla_woo_single_product_summary_design_selector', array(
			array(
				'name' => __('Product entry summary wrap', 'jayla'),
				'selector' => '#page .product-entry-summary__inner',
			),
			array(
				'name' => __('Product entry summary - title', 'jayla'),
				'selector' => '#page .product-entry-summary__inner .product_title',
			),
			array(
				'name' => __('Product - add to cart', 'jayla'),
				'selector' => '#page .product-entry-summary__inner .button.single_add_to_cart_button',
			),
			array(
				'name' => __('Product - add to cart (:hover)', 'jayla'),
				'selector' => '#page .product-entry-summary__inner .button.single_add_to_cart_button:hover',
			)
		) );
		?>
		<div class="product-entry-summary__inner" data-design-name="<?php echo esc_attr('Product entry summary', 'jayla') ?>" data-design-selector='<?php echo esc_attr( wp_json_encode( $design_selector ) ); ?>'>
		<?php
	}
}

if(! function_exists('jayla_woo_single_product_summary_wrap_close')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_single_product_summary_wrap_close() {
		?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_single_product_add_custom_layout_classes')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_single_product_add_custom_layout_classes($classes) {
		if ( !is_product() || !is_single() ) return $classes;
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

		array_push($classes, sprintf('woo-product-custom-single__layout-%s', $product_detail_layout));
		return $classes;
	}
}

if(! function_exists('jayla_woo_shop_add_custom_layout_classes')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_shop_add_custom_layout_classes($classes) {
		global $post;

		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
		$shop_layout = $woo_settings['shop_layout'];
		$classes[] = 'woocommerce-shop-'.$shop_layout;
		return $classes;
	}
}

if(! function_exists('woocommerce_output_product_toggle_data_tabs')) {
	/**
	 * @since 1.0.0
	 */
	function woocommerce_output_product_toggle_data_tabs() {
		?>
		<div class="woo-single-product-toogle-data-tabs">
			<a id="product-toogle-data-tabs-button" href="#" title="<?php echo esc_attr('More detail', 'jayla'); ?>">
				<img src="<?php echo get_template_directory_uri() . '/assets/images/svg-icons/down-arrow.svg' ?>" alt="<?php esc_attr_e('more', 'jayla'); ?>">
			</a>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_get_gallery_html')) {
	/**
	 * @since 1.0.0
	 * @param {array} $post_gallery_ids
	 *
	 * @return {html}
	 */
	function jayla_woo_get_gallery_html( $post_gallery_ids ) {
		if( empty($post_gallery_ids) || count($post_gallery_ids) <= 0 ) return;

		ob_start();
		foreach($post_gallery_ids as $gid) {
			$image_ful_data = wp_get_attachment_image_src($gid, 'full');
			if($image_ful_data == false) continue;
			?>
			<div class="product-g-item" data-themeextends-lazyload-wrap="true">
				<?php
				$img_tag = wp_get_attachment_image($gid, 'medium', false, array(
					'data-themeextends-lazyload-url' => $image_ful_data[0],
					'data-themeextends-mediumzoom' => true,
				));

				// remove attr width/height
				echo jayla_remove_thumbnail_dimensions($img_tag);
				?>
			</div>
			<?php
		}
		return implode('', array(
			'<div class="themeextends-product-gallery-wrap themeextends-product-gallery-desktop">',
				apply_filters('jayla_woo_product_main_gallery_one_col_before', ''),
				'<div class="">',
					ob_get_clean(),
				'</div>',
				apply_filters('jayla_woo_product_main_gallery_one_col_after', ''),
			'</div>'
		));
	}
}

if(! function_exists('jayla_woo_get_gallery_on_mobile_html')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_get_gallery_on_mobile_html($post_gallery_ids) {
		if( empty($post_gallery_ids) || count($post_gallery_ids) <= 0 ) return;

		ob_start();
		foreach($post_gallery_ids as $gid) {
			$image_ful_data = wp_get_attachment_image_src($gid, 'full');
			if($image_ful_data == false) continue;
			?>
			<div class="product-g-item swiper-slide" data-themeextends-lazyload-wrap="true">
				<?php
				$img_tag = wp_get_attachment_image($gid, 'medium', false, array(
					'data-themeextends-lazyload-url' => $image_ful_data[0],
				));

				// remove attr width/height
				echo jayla_remove_thumbnail_dimensions($img_tag);
				?>
			</div>
			<?php
		}

		$opts_slide_swiper = wp_json_encode( array(
			'spaceBetween' => 10,
		) );

		$opts_gallery_swiper = wp_json_encode( array(
			'spaceBetween' => 10,
			'centeredSlides' => true,
			'slidesPerView' => 'auto',
			'touchRatio' => 0.2,
			'slideToClickedSlide' => true,
		) );

		$items = ob_get_clean();

		return implode('', array(
			'<div class="themeextends-product-gallery-mobile" data-themeextends-swiper-custom-control>',
				apply_filters('jayla_woo_product_main_gallery_one_col_before', ''),
				'<div class="themeextends-product-gallery-mobile-wrap swiper-container" data-themeextends-swiper=\''. $opts_slide_swiper .'\' data-themeextends-swiper-slide>',
					'<div class="swiper-wrapper">',
						$items,
					'</div>',
				'</div>',
				'<div class="themeextends-product-gallery-thumbs-mobile-wrap swiper-container gallery-thumbs" data-themeextends-swiper=\''. $opts_gallery_swiper .'\' data-themeextends-swiper-slide-nav>',
					'<div class="swiper-wrapper">',
						$items,
					'</div>',
				'</div>',
				apply_filters('jayla_woo_product_main_gallery_one_col_after', ''),
			'</div>',
		));
	}
}

if(! function_exists('jayla_woo_get_gallery_default_html')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_get_gallery_default_html($post_gallery_ids) {
		if( empty($post_gallery_ids) || count($post_gallery_ids) <= 0 ) return;

		$itemsMainSlide = '';
		$itemsNavSlide = '';
		$slide_vertical_height = 500;
		foreach($post_gallery_ids as $index => $gid) {
			$image_ful_data = wp_get_attachment_image_src($gid, 'full');
			$image_medium_data = wp_get_attachment_image_src($gid, 'medium');

			if($image_ful_data == false) continue;

			if( 0 === $index ) { $slide_vertical_height = $image_ful_data[2]; }

			$itemsMainSlide .= implode('', array(
				'<div
				class="product-g-item"
				data-img-id="'. $gid .'"
				data-themeextends-lazyload-wrap="true"
				data-themeextends-zoomove="true"
				data-zoo-image="'. $image_ful_data[0] .'"
				data-lightgallery-item
				data-thumb="'. $image_medium_data[0] .'"
				data-src="'. $image_ful_data[0] .'">',
					// '<a href="'. $image_ful_data[0] .'" data-src="'. $image_ful_data[0] .'">',
						wp_get_attachment_image($gid, 'medium', false, array(
							'data-themeextends-lazyload-url' => $image_ful_data[0]
							)
						),
					// '</a>',
				'</div>',
			));

			$itemsNavSlide .= implode('', array(
				'<div class="product-g-item swiper-slide" data-img-id="'. $gid .'">',
					wp_get_attachment_image($gid, 'medium', false, array( 'data-themeextends-lazyload-url' => $image_ful_data[0])),
				'</div>'
			));
		}

		$opts_slide = apply_filters( 'jayla_woo_gallery_default_slide_options' , array(
			'item' => 1,
			// 'mode' => 'fade',
			'gallery' => true,
			'vertical' => true,
			'vThumbWidth' => 85,
			'thumbItem' => 7,
			'verticalHeight' => 'auto',
			'galleryMargin' => 10,
			'thumbMargin' => 10,
			'easing' => 'ease',
			'responsive' => array(
				array(
					'breakpoint' => 1450,
					'settings' => array(
						'thumbItem' => 6,
					),
				),
				array(
					'breakpoint' => 1170,
					'settings' => array(
						'vThumbWidth' => 45,
						// 'thumbItem' => 8,
					),
				)
			)
		) );

		$opts_slide = wp_json_encode( $opts_slide );

		return implode('', array(
			'<div class="themeextends-product-gallery-default" data-woo-product-gallery-trigger2>',
				'<div class="themeextends-product-gallery-default-wrap" >',
					apply_filters('jayla_woo_product_main_gallery_items_before', ''),
					'<div id="theme-extends-woo-product-gallery-main" class="themesextends-lightslider" data-themesextends-lightslider=\''. $opts_slide .'\' data-theme-extends-lightgallery>',
						$itemsMainSlide,
					'</div>',
					apply_filters('jayla_woo_product_main_gallery_items_after', ''),
				'</div>',
			'</div>',
		));
	}
}

if(! function_exists('jayla_woo_product_main_gallery_button_trigger_open_fullscreen') ) {
	function jayla_woo_product_main_gallery_button_trigger_open_fullscreen($output) {
		$output .= '<a href="javascript:" class="icon-handle-inner-gallery theme-extends-expand-product-lightgallery" data-theme-extends-lightgallery-open="#theme-extends-woo-product-gallery-main" mousetip mousetip-pos="bottom left" mousetip-css-padding="5px 15px" mousetip-css-borderradius="1px" mousetip-css-background="#fff" mousetip-css-color="#222" mousetip-msg="'. __('Full screen', 'jayla') .'"><span class="ion-android-expand"></span></a>';
		return $output;
	}
}

if(! function_exists('jayla_woo_product_button_trigger_open_video')) {
	function jayla_woo_product_button_trigger_open_video($output) {
		// check Carbon_Fields exist
		if(! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) return $output;

		$video_url = carbon_get_post_meta( get_the_ID(), 'jayla_product_video' );
		if( ! empty( $video_url ) ) {
			$output .= '<div class="icon-handle-inner-gallery theme-extends-open-product-video" data-theme-extends-lightgallery><a href="'. $video_url .'" data-lightgallery-item mousetip mousetip-pos="bottom left" mousetip-css-padding="5px 15px" mousetip-css-borderradius="1px" mousetip-css-background="#fff" mousetip-css-color="#222" mousetip-msg="'. __('Product video', 'jayla') .'"><span class="ion-ios-play"></span></a></div>';
		}

		return $output;
	}
}

if(! function_exists('jayla_woo_show_product_images_layout_default')) {
	function jayla_woo_show_product_images_layout_default() {
		global $product;

		$columns           	= apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$gallery_ids 		= array();

		$post_thumbnail_id 	= $product->get_image_id();
		if( !empty($post_thumbnail_id) ) array_push($gallery_ids, $post_thumbnail_id);

		$post_gallery_ids 	= $product->get_gallery_image_ids();
		if(! empty($post_gallery_ids) && count($post_gallery_ids) > 0) {
			foreach($post_gallery_ids as $g_id) {
				array_push($gallery_ids, $g_id);
			}
		}

		$wrapper_classes   	= apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );
		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
			<figure class="woocommerce-product-gallery__wrapper">
				<?php
				if ( has_post_thumbnail() ) {
					$html  = jayla_woo_get_gallery_default_html( $gallery_ids ) ;
				} else {
					$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'jayla' ) );
					$html .= '</div>';
				}

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
				// do_action( 'woocommerce_product_thumbnails' );
				?>
			</figure>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_get_gallery_slide_button_inline_html')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_get_gallery_slide_button_inline_html($post_gallery_ids) {
		if( empty($post_gallery_ids) || count($post_gallery_ids) <= 0 ) return;

		$itemsMainSlide = '';
		$itemsNavSlide = '';
		$slide_vertical_height = 500;
		foreach($post_gallery_ids as $index => $gid) {
			$image_ful_data = wp_get_attachment_image_src($gid, 'full');
			$image_medium_data = wp_get_attachment_image_src($gid, 'medium');

			if($image_ful_data == false) continue;

			if( 0 === $index ) { $slide_vertical_height = $image_ful_data[2]; }

			$itemsMainSlide .= implode('', array(
				'<div
				class="product-g-item"
				data-img-id="'. $gid .'"
				data-themeextends-lazyload-wrap="true"
				data-themeextends-zoomove="true"
				data-zoo-image="'. $image_ful_data[0] .'"
				data-lightgallery-item
				data-thumb="'. $image_medium_data[0] .'"
				data-src="'. $image_ful_data[0] .'">',
					// '<a href="'. $image_ful_data[0] .'" data-src="'. $image_ful_data[0] .'">',
						wp_get_attachment_image($gid, 'medium', false, array(
							'data-themeextends-lazyload-url' => $image_ful_data[0]
							)
						),
					// '</a>',
				'</div>',
			));

			$itemsNavSlide .= implode('', array(
				'<div class="product-g-item swiper-slide" data-img-id="'. $gid .'">',
					wp_get_attachment_image($gid, 'medium', false, array( 'data-themeextends-lazyload-url' => $image_ful_data[0])),
				'</div>'
			));
		}

		$opts_slide = apply_filters( 'jayla_woo_gallery_slide_button_inline_slide_options' , array(
			'item' => 1,
			// 'mode' => 'fade',
			'gallery' => true,
			// 'vertical' => true,
			// 'vThumbWidth' => 85,
			'thumbItem' => 7,
			'verticalHeight' => 'auto',
			'galleryMargin' => 10,
			'thumbMargin' => 10,
			'easing' => 'ease',
			'responsive' => array(
				array(
					'breakpoint' => 1450,
					'settings' => array(
						'thumbItem' => 6,
					),
				),
				array(
					'breakpoint' => 1170,
					'settings' => array(
						// 'vThumbWidth' => 45,
						'thumbItem' => 5,
					),
				)
			)
		) );

		$opts_slide = wp_json_encode( $opts_slide );

		return implode('', array(
			'<div class="themeextends-product-gallery-slide-button-inline" data-woo-product-gallery-trigger2>',
				'<div class="themeextends-product-gallery-slide-button-inline-wrap" >',
					apply_filters('jayla_woo_product_main_gallery_items_before', ''),
					'<div id="theme-extends-woo-product-gallery-main" class="themesextends-lightslider" data-themesextends-lightslider=\''. $opts_slide .'\' data-theme-extends-lightgallery>',
						$itemsMainSlide,
					'</div>',
					apply_filters('jayla_woo_product_main_gallery_items_after', ''),
				'</div>',
			'</div>',
		));
	}
}

if(! function_exists('jayla_woo_show_product_images_layout_gallery_slide_button_inline') ) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_woo_show_product_images_layout_gallery_slide_button_inline() {
		global $product;

		$columns           	= apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$gallery_ids 		= array();

		$post_thumbnail_id 	= $product->get_image_id();
		if( !empty($post_thumbnail_id) ) array_push($gallery_ids, $post_thumbnail_id);

		$post_gallery_ids 	= $product->get_gallery_image_ids();
		if(! empty($post_gallery_ids) && count($post_gallery_ids) > 0) {
			foreach($post_gallery_ids as $g_id) {
				array_push($gallery_ids, $g_id);
			}
		}

		$wrapper_classes   	= apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );
		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
			<figure class="woocommerce-product-gallery__wrapper">
				<?php
				if ( has_post_thumbnail() ) {
					$html  = jayla_woo_get_gallery_slide_button_inline_html( $gallery_ids ) ;
				} else {
					$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'jayla' ) );
					$html .= '</div>';
				}

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
				// do_action( 'woocommerce_product_thumbnails' );
				?>
			</figure>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_show_product_images')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_show_product_images() {
		global $product;

		$columns           	= apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$gallery_ids 		= array();

		$post_thumbnail_id 	= $product->get_image_id();
		if( !empty($post_thumbnail_id) ) array_push($gallery_ids, $post_thumbnail_id);

		$post_gallery_ids 	= $product->get_gallery_image_ids();
		if(! empty($post_gallery_ids) && count($post_gallery_ids) > 0) {
			foreach($post_gallery_ids as $g_id) {
				array_push($gallery_ids, $g_id);
			}
		}

		$wrapper_classes   	= apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );
		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
			<figure class="woocommerce-product-gallery__wrapper">
				<?php
				if ( has_post_thumbnail() ) {
					$html  = jayla_woo_get_gallery_html( $gallery_ids ) ;
					$html .= jayla_woo_get_gallery_on_mobile_html( $gallery_ids ) ;
				} else {
					$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'jayla' ) );
					$html .= '</div>';
				}

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
				?>
			</figure>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_get_gallery_grid_html')) {
	function jayla_woo_get_gallery_grid_html($gallery_ids = array()) {
		// echo '<pre>'; print_r($gallery_ids); echo '</pre>';
		if( count( $gallery_ids ) <= 0 ) return;
		$gallery_image_items = '';

		foreach( $gallery_ids as $gid ) {
			$image_ful_data = wp_get_attachment_image_src($gid, 'full');
			$post_image = get_post( $gid );
			if($image_ful_data == false) continue;
			$inner_classes = array('p-gallery-item-inner', 'product-gallery-grid-item');

			$image_content = '';
			if( !empty( $post_image->post_content ) ) {
				array_push( $inner_classes, '__has-desc' );
				$image_content = '<div class="p-image-des">'. $post_image->post_content .'</div>';
			}

			$gallery_image_items .= implode('', array(
				'<div class="furygrid-item">',
					'<div
					class="'. implode(' ', $inner_classes) .'"
					data-img-id="'. $gid .'"
					data-themeextends-lazyload-wrap="true"
					data-themeextends-zoomove="true"
					data-zoo-image="'. $image_ful_data[0] .'"
					data-zoo-scale="1.35"
					data-lightgallery-item
					data-src="'. $image_ful_data[0] .'">',
						wp_get_attachment_image($gid, 'medium', false, array(
							'data-themeextends-lazyload-url' => $image_ful_data[0]
							)
						),
					'</div>',
					$image_content,
				'</div>',
			));
		}

		$fury_grid_opts = wp_json_encode( array(
			'Responsive' => array(
				'800' => array(
					'Col' => '1',
					'Space' => 30,
				)
			)
		) );

		return implode( '', array(
			'<div class="woo-product-gallery-grid-container">',
				apply_filters('jayla_woo_product_main_gallery_one_col_before', ''),
				'<div data-theme-furygrid-options=\''. $fury_grid_opts .'\' data-custom-furygrid-col="2" data-custom-furygrid-space="30" data-theme-extends-lightgallery>',
					'<div class="furygrid-sizer"></div>',
					'<div class="furygrid-gutter-sizer"></div>',
					$gallery_image_items,
				'</div>',
			'</div>',
		) );
	}
}

if(! function_exists('jayla_woo_show_product_gallery_grid_images')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_woo_show_product_gallery_grid_images() {
		global $product;

		$columns           	= apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$gallery_ids 		= array();

		$post_thumbnail_id 	= $product->get_image_id();
		if( !empty($post_thumbnail_id) ) array_push($gallery_ids, $post_thumbnail_id);

		$post_gallery_ids 	= $product->get_gallery_image_ids();
		if(! empty($post_gallery_ids) && count($post_gallery_ids) > 0) {
			foreach($post_gallery_ids as $g_id) {
				array_push($gallery_ids, $g_id);
			}
		}

		$wrapper_classes   	= apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );
		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>">
			<figure class="woocommerce-product-gallery__wrapper">
				<?php
				if ( has_post_thumbnail() ) {
					$html  = jayla_woo_get_gallery_grid_html( $gallery_ids ) ;
					$html  .= jayla_woo_get_gallery_on_mobile_html( $gallery_ids ) ;
				} else {
					$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'jayla' ) );
					$html .= '</div>';
				}

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
				// do_action( 'woocommerce_product_thumbnails' );
				?>
			</figure>
		</div>
		<?php
	}
}

if(! function_exists('jayla_metabox_customize_product_detail_settings_panel')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_metabox_customize_product_detail_settings_panel() {
		?>
		<el-tab-pane>
			<span slot="label"><i class="fi flaticon-bars"></i> <?php _e('Product Detail', 'jayla') ?></span>
			<el-form-item label="<?php esc_attr_e('Custom Product Detail', 'jayla'); ?>">
				<el-switch
				v-model="form.custom_product_detail"
				on-text="" off-text=""
				on-value="true"
				off-value="false"></el-switch>
				<small><?php _e('on/off custom product detail.', 'jayla') ?></small>
			</el-form-item>

			<hr /> <br />

			<transition name="theme-extends-fade">
				<div v-show="(form.custom_product_detail == 'true')">
					<el-form-item label="<?php esc_attr_e('Layout Product Detail', 'jayla'); ?>">
						<el-select v-model="form.custom_product_detail_settings.layout" placeholder="<?php esc_attr_e( 'Select', 'jayla' ); ?>">
							<?php
								$product_detail_layout = jayla_woo_product_detail_layout();
								foreach($product_detail_layout as $value => $label) {
									echo sprintf('<el-option label="%s" value="%s"></el-option>', $label, $value);
								}
							?>
						</el-select>
					</el-form-item>

					<hr class="theme-extends-margin" />

					<el-form-item class="theme-extends-margin" label="<?php _e('Product Sticky Bar') ?>">
						<el-switch
							on-text="" off-text=""
							on-value="yes" off-value="no"
							v-model="form.custom_product_detail_settings.product_detail_sticky_bar"></el-switch>
					</el-form-item>

					<div v-show="form.custom_product_detail_settings.product_detail_sticky_bar == 'yes'">
						<el-form-item class="theme-extends-margin" label="<?php _e('Product Sticky Bar Position') ?>">
							<el-select v-model="form.custom_product_detail_settings.product_detail_sticky_bar_position" popper-class="theme-extends-customize-zindex">
								<el-option label="<?php _e('Top', 'jayla') ?>" value="top"></el-option>
								<el-option label="<?php _e('Bottom', 'jayla') ?>" value="bottom"></el-option>
							</el-select>
						</el-form-item>
					</div>

					<hr class="theme-extends-margin" />

					<el-form-item class="theme-extends-margin" label="<?php esc_attr_e( 'Related Products', 'jayla' ) ?>">
						<el-switch
						on-text="" off-text=""
						on-value="yes" off-value="no"
						v-model="form.custom_product_detail_settings.show_related_products"></el-switch>
						<small><?php _e('on/off related products.', 'jayla') ?></small>
					</el-form-item>

				</div>
			</transition>
		</el-tab-pane>
		<?php
	}
}

if(! function_exists('jayla_woo_product_ul_listing_temp')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_product_ul_listing_temp($atts) {
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
				global $product;
				$product_title = $product->get_title();
				$product_thumbnail_url = get_the_post_thumbnail_url($product->get_id(), 'medium');
				$product_price_html = $product->get_price_html();
				ob_start();
				?>
				<li>
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
						<img
							src="<?php echo get_template_directory_uri() . '/assets/images/core/placeholder-image-150x150.jpg'; ?>"
							data-themeextends-lazyload-url="<?php echo esc_attr( $product_thumbnail_url ); ?>"
							alt="<?php echo esc_attr( $product_title ); ?>" />
						<span class="product-title"><?php echo "{$product_title}"; ?></span>
					</a>
					<?php echo "{$product_price_html}"; ?>
				</li>
				<?php
                $html_item = ob_get_clean();
                array_push($items_output, $html_item);
            }
        }
        wp_reset_postdata();

        return implode('', array(
            '<div class="woocommerce">',
                ( ! empty($atts['title']) ) ? '<div class="product-listing-title">'. $atts['title'] .'</div>' : '',
                '<ul class="product-listing">',
                    implode('', $items_output),
                '</ul>',
            '</div>'
		));
	}
}

if(! function_exists('jayla_bevc_Products_Listing_templates_layout_default')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_bevc_Products_Listing_templates_layout_default($layouts, $atts) {
		$layouts['default'] = jayla_woo_product_ul_listing_temp($atts);
		return $layouts;
	}
}

if(! function_exists('jayla_woo_icon_minicart_svg')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_woo_icon_minicart_svg( $icon_name ) {
		$svg_icons = apply_filters( 'jayla_woo_icon_minicart_svg_filter', array(
			'bag_basic' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 485 485" style="enable-background:new 0 0 485 485;" xml:space="preserve"> <path d="M331.35,116.05v-27.2C331.35,39.858,291.492,0,242.5,0s-88.85,39.858-88.85,88.85v27.2H64.5V485h356V116.05H331.35z M183.65,88.85c0-32.45,26.4-58.85,58.85-58.85s58.85,26.4,58.85,58.85v27.2h-117.7V88.85z M390.5,455h-296V146.05h59.15v35h30v-35 h117.7v35h30v-35h59.15V455z"/> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',
			'bag_2' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g> <path d="M479.264,108.352c-0.128-0.544-0.128-1.056-0.32-1.568c-0.992-2.784-2.688-5.12-4.928-6.944 c-0.192-0.192-0.224-0.48-0.416-0.64L448,80V16c0-2.56-0.736-4.864-1.792-7.008c-0.096-0.16-0.032-0.352-0.128-0.544 c-0.192-0.352-0.608-0.512-0.8-0.864c-1.12-1.76-2.528-3.232-4.224-4.416c-0.576-0.384-1.056-0.8-1.664-1.12 C437.152,0.864,434.72,0,432,0H80c-2.72,0-5.152,0.864-7.424,2.048c-0.608,0.32-1.088,0.704-1.664,1.12 c-1.664,1.216-3.072,2.656-4.192,4.416c-0.224,0.352-0.608,0.512-0.8,0.864c-0.096,0.16-0.064,0.384-0.128,0.544 C64.736,11.136,64,13.44,64,16v64L38.4,99.2c-0.192,0.16-0.224,0.448-0.416,0.608c-2.24,1.824-3.936,4.16-4.928,6.944 c-0.192,0.544-0.192,1.024-0.32,1.568C32.448,109.568,32,110.688,32,112v336c0,35.296,28.704,64,64,64h320 c35.296,0,64-28.704,64-64V112C480,110.688,479.552,109.568,479.264,108.352z M125.312,55.136L109.92,32h292.16l-15.392,23.136 c-4.704,7.04-3.104,16.576,3.712,21.664L416,96H96l25.6-19.2C128.416,71.712,130.048,62.176,125.312,55.136z M448,448 c0,17.632-14.336,32-32,32H96c-17.664,0-32-14.368-32-32V128h384V448z"/> </g> </g> <g> <g> <path d="M368,192c-8.832,0-16,7.168-16,16v48c0,52.928-43.072,96-96,96c-52.928,0-96-43.072-96-96v-48c0-8.832-7.168-16-16-16 c-8.832,0-16,7.168-16,16v48c0,70.592,57.408,128,128,128s128-57.408,128-128v-48C384,199.168,376.832,192,368,192z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',
			'cart_basic' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 45.456 45.456" style="enable-background:new 0 0 45.456 45.456;" xml:space="preserve"> <g> <g> <path d="M45.456,9.312h-41.3L2.972,3.431C2.809,2.619,2.01,2.1,1.205,2.256 C0.392,2.42-0.133,3.21,0.03,4.023l5.636,28c0.142,0.7,0.757,1.204,1.471,1.204h3.391c-1.158,1.053-1.89,2.565-1.89,4.25 c0,3.171,2.579,5.75,5.75,5.75s5.75-2.579,5.75-5.75c0-1.685-0.732-3.197-1.891-4.25h10.531c-1.158,1.053-1.891,2.565-1.891,4.25 c0,3.171,2.579,5.75,5.75,5.75s5.75-2.579,5.75-5.75c0-1.685-0.732-3.197-1.891-4.25h6.142c0.828,0,1.5-0.672,1.5-1.5 c0-0.828-0.672-1.5-1.5-1.5H8.366l-1.007-5h35.016L45.456,9.312z M14.388,40.227c-1.517,0-2.75-1.233-2.75-2.75 s1.233-2.75,2.75-2.75s2.75,1.233,2.75,2.75S15.905,40.227,14.388,40.227z M32.638,40.227c-1.517,0-2.75-1.233-2.75-2.75 s1.233-2.75,2.75-2.75s2.75,1.233,2.75,2.75S34.155,40.227,32.638,40.227z M39.901,22.227H6.756L4.76,12.312h37.06L39.901,22.227z "/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',
		) );

		return $svg_icons[$icon_name];
	}
}

if(! function_exists('jayla_woo_widget_minicart_layout_default')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_woo_widget_minicart_layout_default() {
		ob_start();
		$count = WC()->cart->get_cart_contents_count();
		$entry_text = __( 'My Shopping Bag', 'jayla' );
		$classes = array( 'theme-widget-woo-mini-cart-container' );

		if( ! empty( $count ) && $count > 0 ) {
			array_push( $classes, '__has-product' );
			$entry_text = implode( ' ', array(
				$count,
				sprintf( _n( 'Item — %s', 'Items — %s', $count, 'jayla' ), WC()->cart->get_cart_subtotal() ),
			) );
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <div class="icon-entry" data-theme-extends-trigger-shopping-content-cart-offcanvas>
                <div class="_icon-minicart"><?php echo jayla_woo_icon_minicart_svg( 'bag_basic' ); ?></div>
                <div class="_minicart-entry-text">
					<?php echo "{$entry_text}"; ?>
                </div>
			</div>
        </div>
		<?php
		return ob_get_clean();
	}
}

if(! function_exists('jayla_woo_widget_minicart_layout_bag_only_icon')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_widget_minicart_layout_bag_only_icon() {
		ob_start();
		$count = WC()->cart->get_cart_contents_count();
		$count_html = ! empty( $count ) ? '<small class="badge-woo-minicart-count" data-design-name="'. esc_attr__( 'Mini cart badge', 'jayla' ) .'" data-design-selector="#page .theme-extends-widget-mini-cart._layout-bag_only_icon .badge-woo-minicart-count" >'. $count .'</small>' : '';
		$classes = array( 'theme-widget-woo-mini-cart-container' );
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <div class="icon-entry" data-theme-extends-trigger-shopping-content-cart-offcanvas data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr('My Shopping Bag', 'jayla'); ?>">
                <div class="_icon-minicart"><?php echo jayla_woo_icon_minicart_svg( 'bag_2' ); ?></div>
				<?php echo "{$count_html}"; ?>
			</div>
        </div>
		<?php
		return ob_get_clean();
	}
}

if(! function_exists('jayla_woo_widget_minicart_layout_cart_only_icon')) {
	/**
	 * @since 1.0.0
	 */
	function jayla_woo_widget_minicart_layout_cart_only_icon() {
		ob_start();
		$count = WC()->cart->get_cart_contents_count();
		$count_html = ! empty( $count ) ? '<span class="badge-woo-minicart-count" data-design-name="'. esc_attr__( 'Mini cart badge', 'jayla' ) .'" data-design-selector="#page .theme-extends-widget-mini-cart._layout-cart_only_icon .badge-woo-minicart-count">'. $count .'</span>' : '';
		$classes = array( 'theme-widget-woo-mini-cart-container' );
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <div class="icon-entry" data-theme-extends-trigger-shopping-content-cart-offcanvas data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr('My Shopping Bag', 'jayla'); ?>">
                <div class="_icon-minicart"><?php echo jayla_woo_icon_minicart_svg( 'cart_basic' ); ?></div>
				<?php echo "{$count_html}"; ?>
			</div>
        </div>
		<?php
		return ob_get_clean();
	}
}

if(! function_exists('jayla_woo_shopping_content_cart_offcanvas')) {
	/**
	 * @since 1.0.0
	 *
	 */
	function jayla_woo_shopping_content_cart_offcanvas() {
		?>
		<div class="theme-extends-shopping-content-cart-offcanvas">
			<a href="javascript:" class="__close" title="<?php esc_attr_e('close', 'jayla'); ?>"><span class="ion-close"></span></a>
			<div class="entry-container widget_shopping_cart">
				<h5 class="title">— <?php _e( 'My Shopping Cart', 'jayla' ); ?> <sup class="theme-extends-woo-minicart-count"></sup></h5>
				<div class="shopping-cart-content">
					<?php do_action( 'jayla_woo_widget_minicart_offcanvas_before_content' ); ?>
					<div class="widget_shopping_cart_content"></div>
					<?php do_action( 'jayla_woo_widget_minicart_offcanvas_after_content' ); ?>
				</div>
			</div>
		</div>
		<?php
	}
}

if(! function_exists('jayla_item_search_result_product_template')) {
	/**
	 *
	 */
	function jayla_item_search_result_product_template( $content ) {
		global $post;
		$posttype = get_post_type( $post );

		if( 'product' == $posttype ) {
			global $product;

			$thumbnail_html = '';
			$on_sale_html = '';
			if( has_post_thumbnail( $post ) ) {
				$thumbnail_html = '<a href="'. $product->get_permalink() .'" class="p-thumbnail">'. $product->get_image( 'thumbnail', array( 'class' => 'p-thumbnail-image' ) ) .'</a>';
			}

			if( $product->is_on_sale() ) {
				$on_sale_html = '<span class="p-on-sale">'. __( 'Sale', 'jayla' ) .'</span>';
			}
			ob_start();
			?>
			<?php echo "{$thumbnail_html}"; ?>
			<div class="entry-content">
				<a href="<?php the_permalink() ?>" class="title-link">
					<h4 class="title"><?php echo "{$on_sale_html}"; ?><?php the_title(); ?> <?php echo "{$posttype_html}"; ?></h4>
				</a>
				<div class="extra-entry-meta">
					<div class="price"><?php echo "{$product->get_price_html()}"; ?></div>
				</div>
			</div>
			<?php
			$content = ob_get_clean();
		}

		return $content;
	}
}

if(! function_exists('jayla_woo_archive_header_tool_open')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_woo_archive_header_tool_open() {
		?>
		<div class="jayla-woo-archive-header-tools">
		<?php	
	}
}

if(! function_exists('jayla_woo_archive_header_tool_close')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_woo_archive_header_tool_close() {
		?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_filter_select')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_woo_filter_select() {
		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
		if( 'yes' == $woo_settings['shop_archive_filter'] && 'default' == $woo_settings['shop_filter_layout'] ){
		?>
		<div class="jayla-woo-archive-filter-select" data-shop-archive-filter-toggle-button="default">
			<div class="filter-tile"><?php _e( 'Filter', 'jayla' ) ?></div>
		</div>
		<?php
		}
	}
}

if(! function_exists('jayla_woo_filter_button_toggle_offcanvas')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_woo_filter_button_toggle_offcanvas() {
		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
		if( 'yes' == $woo_settings['shop_archive_filter'] && 'off-canvas' == $woo_settings['shop_filter_layout'] ){
		?>
		<div class="jayla-woo-archive-filter-offcanvas-toggle" data-shop-archive-filter-toggle-button="off-canvas">
			<div class="filter-icon">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 344.339 344.339" style="" xml:space="preserve"> <g> <g> <g> <rect y="46.06" width="344.339" height="29.52"/> </g> <g> <rect y="156.506" width="344.339" height="29.52"/> </g> <g> <rect y="268.748" width="344.339" height="29.531"/> </g> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
			</div>
			<div class="filter-tile"><?php _e( 'Filter', 'jayla' ) ?></div>	
		</div>
		<?php
		}
	}
}

if(! function_exists('jayla_woo_archive_filter_tool')) {
	/**
	 * @since 1.0.0 
	 */
	function jayla_woo_archive_filter_tool() {
		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
		if( 'yes' != $woo_settings['shop_archive_filter'] ) return;
		$classes = array(
			'jayla-archive-filter-tool-bar',
			'__layout-' . $woo_settings['shop_filter_layout'],
			( 'default' == $woo_settings['shop_filter_layout'] ) ? '__filter-columns-' . $woo_settings['shop_filter_default_columns'] : '',
		);

		$smooth_scrollbar_attr = ( 'off-canvas' == $woo_settings['shop_filter_layout'] ) ? 'data-themeextends-smooth-scrollbar' : '';
		?>
		<div class="<?php esc_attr_e( implode( ' ', $classes ) ); ?>">
			<div class="__inner" <?php esc_attr_e( $smooth_scrollbar_attr ); ?>>
				<?php 
				/**
				 * hook jayla_woo_archive_filter_tool_action.
				 * 
				 */
				do_action( 'jayla_woo_archive_filter_tool_action' ); 
				?>
			</div>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_archive_layered_nav_filters')) {
	function jayla_woo_archive_layered_nav_filters() {
		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
		if( 'yes' != $woo_settings['shop_archive_filter'] ) return;
		?>
		<div class="jayla-woo-widget-layered-nav-filters">
			<?php 
			if( class_exists( 'WC_Widget_Layered_Nav_Filters' ) ) the_widget( 'WC_Widget_Layered_Nav_Filters' ); 
			?>
		</div>
		<?php
	}
}

if( ! function_exists('jayla_woo_load_sidebar_filter_tool_archive_shop') ) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_woo_load_sidebar_filter_tool_archive_shop() {
		if ( ! is_active_sidebar( 'shop-archive-filter-sidebar' ) ) {
			return;
		}
		dynamic_sidebar( 'shop-archive-filter-sidebar' );
	}
}

if(! function_exists('jayla_woo_custom_layered_nav_count') ) {
	/**
	 * @since 1.0.0 
	 * 
	 */
	function jayla_woo_custom_layered_nav_count( $output, $count, $term ) {
		return '<sup class="count">' . absint( $count ) . '</sup>';
	}
}

if(! function_exists('jayla_woo_add_icon_nav_cat')) {
	/**
	 * @since 1.0.0
	 * 
	 */
	function jayla_woo_add_icon_nav_cat( $cat_name, $cat_data, $args ) {
		
		if( function_exists( 'carbon_get_term_meta' ) && isset( $args['icon_before_name'] ) && true == $args['icon_before_name'] ) {
			$p_cat_icon = carbon_get_term_meta( $cat_data->term_id, 'p_cat_icon' );
			$img_src = ! empty( $p_cat_icon ) ? $p_cat_icon : $args['icon_image_placeholder'];
			$icon_img = '<img src="'. esc_url( $img_src ) .'" alt="'. esc_attr( $cat_name ) .'"/>';
			$cat_name = '<span class="__cat-icon">'. $icon_img .'</span> <span class="__cat-name">' . $cat_name . '</span>';
		}

		return $cat_name;
	}
}

if(! function_exists('jayla_woo_shop_archive_loadmore_ajax_infinite_scroll')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_woo_shop_archive_loadmore_ajax_infinite_scroll( $output ) {
		$woo_settings = Jayla_WooCommerce_Customizer::get_settings();
		$ajax_load_more_infinite_scroll = $woo_settings['shop_archive_ajax_load_more_infinite_scroll'];

		if( 'yes' == $ajax_load_more_infinite_scroll ) {
			if( is_shop() || is_product_category() || is_product_tag() ) {
				ob_start();
				?>
				<div
					class="themeextends-scroll-loadmore-post-by-ajax" 
					data-themeextends-ajax-push-to-element=".woocommerce.themeextends-products-wrapper ul.products" 
					data-themeextends-scroll-ajax-element-selector=".woocommerce.themeextends-products-wrapper ul.products > li"
					data-themeextends-scroll-reveal-content-ajax=".woocommerce.themeextends-products-wrapper ul.products > li" >
					<div class="__ajax-loading"></div>
				</div>
				<?php
				$output = ob_get_clean() . $output;
			}
		}
		
		return $output;
	}
}

if(! function_exists('jayla_woo_custom_subcategory_count_html')) {
	/**
	 * @since 1.0.0
	 *  
	 */
	function jayla_woo_custom_subcategory_count_html( $output, $category ) {
		return implode( '', array(
			' <sup>',
				'<mark class="count">' . esc_html( $category->count ) . '</mark>',
			'<sup>',
		) );
	}
}

if(! function_exists('jayla_woo_product_tabs_default')) {
	/**
	 * @since 1.0.1
	 *  
	 */
	function jayla_woo_product_tabs_default( $tabs ) {
		?>
		<div class="woocommerce-tabs wc-tabs-wrapper">
			<div class="theme-extends-wc-tabs-wrap" <?php do_action('jayla_woo_custom_attr_wc_tabs'); ?>>
				<ul class="tabs wc-tabs" role="tablist" data-nav-slide data-nav-slide-selector="li">
					<?php foreach ( $tabs as $key => $tab ) : ?>
						<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
							<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
					<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_product_accordion_ui')) {
	/**
	 * @since 1.0.1
	 *  
	 */
	function jayla_woo_product_accordion_ui( $tabs ) {
		?>
		<div class="themeextends-accordion-ui woocommerce-accordion-ui wc-accordion-ui-wrapper">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="themeextends-accordion-ui-item woocommerce-accordion-ui-item woocommerce-accordion-ui-item--<?php echo esc_attr( $key ); ?> entry-content wc-accordion-ui" id="accordion-item-<?php echo esc_attr( $key ); ?>" role="accordionpanel" aria-labelledby="accordion-title-<?php echo esc_attr( $key ); ?>">
					<div class="themeextends-accordion-ui-title <?php echo esc_attr( $key ); ?>_accordion wc-accordion-title" id="tab-title-<?php echo esc_attr( $key ); ?>" role="accordion" aria-controls="accordion-<?php echo esc_attr( $key ); ?>">
						<div><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></div>
					</div>
					<div class="themeextends-accordion-ui-container wc-accordion-container">
						<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if(! function_exists('jayla_woo_sticky_product_bar')) {
	/**
	 * @since 1.1.2
	 *  
	 */
	function jayla_woo_sticky_product_bar_html() {
		global $post;
		if( ! is_product() ) return;

		$woo_settings = jayla_get_option_type_json('jayla_woocommerce_settings', 'jayla_woo_settings_default');
		$product_sticky_bar = $woo_settings['product_detail_sticky_bar'];
		$position = $woo_settings['product_detail_sticky_bar_position'];

		$metabox_data = jayla_get_custom_metabox($post->ID);
		$custom_product_detail_settings = isset( $metabox_data['custom_product_detail_settings'] ) ? $metabox_data['custom_product_detail_settings'] : array();
		if( isset( $metabox_data['custom_product_detail'] ) && $metabox_data['custom_product_detail'] == 'true' ) {
			if( isset( $custom_product_detail_settings['product_detail_sticky_bar'] ) ) {
				$product_sticky_bar = $custom_product_detail_settings['product_detail_sticky_bar'];
			}
			if( isset( $custom_product_detail_settings['product_detail_sticky_bar_position'] ) ) {
				$position = $custom_product_detail_settings['product_detail_sticky_bar_position'];
			}
		}
		// echo '<pre>'; print_r($metabox_data); echo '</pre>';
		if( 'no' == $product_sticky_bar ) return;

		$product = new WC_product( $post->ID );
		$product_image = $product->get_image( 'thumbnail', array(
			'class' => 'product-thumbnail-img',
		));
		$review_count = $product->get_review_count();
		$review_star_html = ! empty( $review_count ) ? sprintf( '<div class="product-rating-star">%s <span>(%s '. __( 'customer review', 'jayla' ) .')</span></div>', wc_get_rating_html( $product->get_average_rating() ), $review_count ) : '';
		?>
		<div class="themeextend-sticky-product-bar sticky-position-<?php echo esc_attr( $position ); ?>"> <!-- open .themeextend-sticky-product-bar -->
			<div class="<?php do_action('jayla_container_class') ?>">
				<div class="__inner">
					<?php do_action( 'jayla_sticky_product_bar_meta_before' ); ?>
					<div class="sticky-product-image">
						<?php echo "{$product_image}"; ?>
					</div>
					<div class="sticky-product-title">
						<p><?php echo "{$product->get_title()}"; ?></p>
						<?php echo "{$review_star_html}"; ?>
					</div>
					<div class="sticky-product-add-to-cart">
						<?php echo do_shortcode( sprintf( '[add_to_cart id="%s" style="" class="sticky-product-add-to-cart-shortcode-custom-class"]', $post->ID ) ); ?>
					</div>
					<!-- <div class="sticky-product-extra-meta"></div> -->
					<?php do_action( 'jayla_sticky_product_bar_meta_after' ); ?>
				</div>
			</div>
		</div> <!-- close .themeextend-sticky-product-bar -->
		<?php
	}
}
