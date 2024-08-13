<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
<div class="form__block woocommerce-shipping-fields">
    <div class="form__subtitle mobile-hide">
        <span>Deliver to</span>
    </div>
    
    <div class="form__row" id="ship-to-different-address" style="position: absolute!important; left: -99999px!important;">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox input input--checkbox">
            <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" checked type="checkbox" name="ship_to_different_address" value="1" />
            <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
        </label>
    </div>
    <div class="shipping_address">

        <?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

        <div class="woocommerce-shipping-fields__field-wrapper">
            <?php
            $fields = $checkout->get_checkout_fields( 'shipping' );
            get_woocommerce_fields_html($fields, $checkout);
            ?>
        </div>

        <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

    </div>

</div>
<?php endif; ?>
