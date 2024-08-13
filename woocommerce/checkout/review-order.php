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
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-checkout-review-order-table">
    <div class="checkout__aside-info">
        <?php
            do_action( 'woocommerce_review_order_before_cart_contents' );
            
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                
                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    ?>
                    <div class="cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-product-id="<?php echo $cart_item['key']; ?>">
                        <div class="cart-item__img">
                            <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' )[0]; ?>" alt="product" width="156" height="208">
                        </div>
                        <div class="cart-item__wrapper">
                            <div class="cart-item__title">
                                <h2><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?></h2>
                            </div>
                            <div class="cart-item__price">
                                <span><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                            </div>
                            <div class="quantity">
                                <input type="hidden" name="action" value="change_quantity">
                                <div class="quantity__amount">
                                    <button type="button" class="quantity__btn" data-direction="minus">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 12H12H18" stroke="#A0AAB6" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <input class="quantity__input" type="text" min="1" max="" value="<?php echo $cart_item['quantity']; ?>"
                                           readonly="" name="quantity">
                                    <button type="button" class="quantity__btn" data-direction="plus">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 12H12M12 12H18M12 12V6M12 12V18" stroke="#A0AAB6"
                                                  stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <?php $add_additional_products = get_field('add_additional_products', 'option'); ?>

                    <?php if ($add_additional_products) : ?>
                        <?php $quantity = $cart_item['quantity']; ?>
                        <?php $need_to_buy = get_field('need_to_buy', 'option'); ?>
                        <?php $will_get = get_field('will_get', 'option'); ?>
                        <?php if ($quantity >= $need_to_buy) : ?>
                            <?php $additional_quantity = floor($cart_item['quantity'] / $need_to_buy); ?>
                            <?php $additional_quantity = $additional_quantity * $will_get; ?>
                            <div class="cart-item">
                                <?php $post_thumbnail = get_the_post_thumbnail_url($cart_item['product_id']); ?>
                                <?php if (!empty($post_thumbnail)) : ?>
                                    <div class="cart-item__img">
                                        <img src="<?php echo $post_thumbnail; ?>" alt="product" width="156"
                                             height="208">
                                    </div>
                                <?php endif; ?>
                                <div class="cart-item__wrapper">
                                    <div class="cart-item__title">
                                        <h2><?php echo get_the_title($cart_item['product_id']); ?></h2>
                                    </div>
                                    <div class="cart-item__price">
                                        <span><?php echo $additional_quantity; ?> x $0</span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif;
                }
            }
            
            do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </div>
    <div class="checkout__code mobile-hide">
        <div class="checkout__aside-title">
            <span>Promocode</span>
        </div>
        <div class="checkout__code-form">
            <div class="checkout__code-input">
                <input type="text" name="coupon_code" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>">
            </div>
            <button type="button" class="btn" disabled="disabled">Apply</button>
        </div>
    </div>
    <?php woocommerce_checkout_payment() ?>
    <div class="checkout__block js-float-btn">
        <ul class="checkout__total">
            <li class="cart-subtotal">
                <span><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
                <span><?php wc_cart_totals_subtotal_html(); ?></span>
            </li>

            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

                <?php wc_cart_totals_shipping_html(); ?>

                <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
            <?php endif; ?>

            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                <li class="fee">
                    <span><?php echo esc_html( $fee->name ); ?></span>
                    <span><?php wc_cart_totals_fee_html( $fee ); ?></span>
                </li>
            <?php endforeach; ?>

            <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                        <li class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                            <span><?php echo esc_html( $tax->label ); ?></span>
                            <span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li class="tax-total">
                        <span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
                        <span><?php wc_cart_totals_taxes_total_html(); ?></span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <li class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                    <span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
                    <span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
                </li>
            <?php endforeach; ?>

            <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
            <li class="order-total">
                <span><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
                <span><?php wc_cart_totals_order_total_html(); ?></span>
            </li>
            <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
        </ul>
        <?php wc_get_template( 'checkout/terms.php' ); ?>
        <div class="checkout__btn">
            <a href="#popup-promocode" data-fancybox class="btn btn--transparent mobile-show">Add Promocode </a>
            <button type="button" class="btn js-place-order">Proceed to Pay</button>
            <div class="checkout__btn-error"></div>
        </div>
        <div class="checkout__aside-text section-text mobile-show">
            <?php do_action( 'woocommerce_checkout_before_terms_and_conditions' ); ?>
            <div class="woocommerce-terms-and-conditions-wrapper">
                <?php
                /**
                 * Terms and conditions hook used to inject content.
                 *
                 * @since 3.4.0.
                 * @hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
                 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
                 */
                //            do_action( 'woocommerce_checkout_terms_and_conditions' );

                ?>
                <div class="woocommerce-privacy-policy-text">
                    <p>
                        <?php echo pll__('Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our'); ?> <a href="<?php echo Page_Text::get_url(); ?>" class="woocommerce-privacy-policy-link" target="_blank"><?php echo pll__('privacy policy'); ?></a>.
                    </p>
                </div>
                <?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
                    <label class="input input--checkbox validate-required">
                        <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?> id="terms" />
                        <span class="woocommerce-terms-and-conditions-checkbox-text"><?php wc_terms_and_conditions_checkbox_text(); ?>&nbsp;<abbr class="required" title="<?php esc_attr_e( 'required', 'woocommerce' ); ?>">*</abbr></span>
                        <input type="hidden" name="terms-field" value="1" />
                    </label>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
