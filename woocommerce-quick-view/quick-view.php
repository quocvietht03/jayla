<?php
/**
 * Quick view template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post, $woocommerce;

do_action( 'wc_quick_view_before_single_product' );
?>
<div class="woocommerce quick-view">

	<div class="product">
		<div class="quick-view-image images">
      
			<?php if ( has_post_thumbnail() ) : ?>

				<?php echo get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ) ?>

			<?php else : ?>

				<img src="<?php echo esc_url( wc_placeholder_img_src() ) ; ?>" alt="<?php esc_attr_e( 'Placeholder', 'jayla' ); ?>" />

			<?php endif; ?>

			<a class="quick-view-detail-button button" href="<?php echo esc_url( get_permalink( $product->get_id() ) ) ; ?>"><?php _e( 'View Full Details', 'jayla' ); ?></a>

		</div>

		<div class="quick-view-content entry-summary">

			<?php woocommerce_template_single_title(); ?>
			<?php woocommerce_template_single_price(); ?>
			<?php woocommerce_template_single_excerpt(); ?>
			<?php woocommerce_template_single_add_to_cart(); ?>

		</div>
	</div>
</div>
