<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="checkout-review">
	<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
	?>
	<div class="review-item-thumbnail">
				<?php $thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key ); 
echo $thumbnail; ?>
	</div>
	<div class="review-item-details">
		<p><?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; ?></p>
		<p><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></p>
		<p><?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', sprintf( 'QTY: %s', $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></p>

		<p><?php echo WC()->cart->get_item_data( $cart_item ); ?></p>
	</div>
	
				<?php
			}
		}
	?>
</div>
<div class="cart-total-summary">
		<!-- <?php _e( 'Subtotal', 'woocommerce' ); ?>
		<?php wc_cart_totals_subtotal_html(); ?> -->
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			
				<?php wc_cart_totals_coupon_label( $coupon ); ?>
				<?php wc_cart_totals_coupon_html( $coupon ); ?>
			
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			
				<?php echo esc_html( $fee->name ); ?>
				<?php wc_cart_totals_fee_html( $fee ); ?>
			
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					
						<?php echo esc_html( $tax->label ); ?>
						<?php echo wp_kses_post( $tax->formatted_amount ); ?>
					
				<?php endforeach; ?>
			<?php else : ?>
				
					<?php echo esc_html( WC()->countries->tax_or_vat() ); ?>
					<?php wc_cart_totals_taxes_total_html(); ?>
				
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
		<p>
		<?php _e( 'Total', 'woocommerce' ); ?>
		<?php wc_cart_totals_order_total_html(); ?>
		</p>
		<p>
		<?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="btn-checkout" name="woocommerce_checkout_place_order" id="place_order" value="' . __( 'PLACE ORDER','optimizer-child' ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>
		</p>
		<small><?php echo __('By clicking on the "Place Order" button you agree to the Terms and Conditions of Laurine Watches','optimizer-child'); ?></small>
	</div>
