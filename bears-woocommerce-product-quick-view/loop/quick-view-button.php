<?php
/**
 * Quick View Button
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product;

echo apply_filters(
  'jayla_woocommerce_loop_product_quick_view_button',
  sprintf( '<a href="%s" title="%s" data-bma-pid=\'%s\' class="bwc-quick-view-button bma-handle button"><i class="ion-eye"></i><span class="bwc-tooltip">%s</span></a>',
  esc_url( $link ), esc_attr( get_the_title() ), $product->get_id(), __('Quick View', 'jayla') )
);
