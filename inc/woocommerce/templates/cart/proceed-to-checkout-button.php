<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$button_checkout_design_selector = json_encode(array(
  array('name' => 'Button checkout', 'selector' => '#page .cart_totals a.checkout-button'),
  array('name' => 'Button checkout (:hover)', 'selector' => '#page .cart_totals a.checkout-button:hover'),
));
?>

<a data-design-name="<?php esc_attr_e('Button checkout', 'jayla'); ?>" data-design-selector='<?php echo esc_attr($button_checkout_design_selector); ?>' href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button button alt wc-forward">
	<?php esc_html_e( 'Proceed to checkout', 'jayla' ); ?>
</a>
