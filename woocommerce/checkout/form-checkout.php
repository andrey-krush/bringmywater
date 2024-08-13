<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>


<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="container container--full">
        <div class="checkout__container">
            <div class="header-notice"></div>
            <?php if ( $checkout->get_checkout_fields() ) : ?>
                <div class="checkout__info" id="customer_details">
                    <div class="checkout__title title-h2 mobile-hide">
                        <h1>place Your order</h1>
                    </div>
                    <div class="checkout__row">
                        <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                    </div>
<!--                    <div class="form__block">-->
<!--                        <div class="form__subtitle">-->
<!--                            <span>--><?php //echo pll__('Do you want to schedule recurring deliveries or is this a one-time purchase?'); ?><!--</span>-->
<!--                        </div>-->
<!--                        <div class="form__row">-->
<!--                            <div class="input input--select">-->
<!--                                <input class="output_text" type="text" value="One-Time Purchase" readonly>-->
<!--                                <input class="output_value" type="hidden" name="recurring" required value="--><?php //echo WC()->session->get('recurring') ?: 'one-time'?><!--">-->
<!--                                <div class="input__dropdown">-->
<!--                                    <ul>-->
<!--                                        <li data-value="one-time">--><?php //echo pll__('One-Time Purchase'); ?><!--</li>-->
<!--                                        <li data-value="week">--><?php //echo pll__('Every Week'); ?><!--</li>-->
<!--                                        <li data-value="two-weeks">--><?php //echo pll__('Every Two Weeks'); ?><!--</li>-->
<!--                                        <li data-value="month">--><?php //echo pll__('Every Month'); ?><!--</li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form__row">-->
<!--                            <div class="input input--date">-->
<!--                                <input type="date" class="picker" name="recurring_date" data-validation="delivery_term_date" value="--><?php //echo WC()->session->get('recurring_date') ?: ''?><!--">-->
<!--                            </div>-->
<!--                            <div class="input input--select">-->
<!--                                <input class="output_text" type="text" value="Select day" readonly>-->
<!--                                <input class="output_value" type="hidden" name="delivery_day" required value="--><?php //echo WC()->session->get('delivery_day') ?: 'Monday'?><!--">-->
<!--                                <div class="input__dropdown">-->
<!--                                    <ul>-->
<!--                                        <li data-value="Monday">Monday</li>-->
<!--                                        <li data-value="Tuesday">Tuesday</li>-->
<!--                                        <li data-value="Wednesday">Wednesday</li>-->
<!--                                        <li data-value="Thursday">Thursday</li>-->
<!--                                        <li data-value="Friday">Friday</li>-->
<!--                                        <li data-value="Saturday">Saturday</li>-->
<!--                                        <li data-value="Sunday">Sunday</li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="js-weeks">-->
<!--                                <div class="input input--date">-->
<!--                                    <label>First week:</label>-->
<!--                                    <input type="date" class="picker" name="first_week" value="--><?php //echo WC()->session->get('first_week') ?: ''?><!--">-->
<!--                                </div>-->
<!--                                <div class="input input--date">-->
<!--                                    <label>Second week:</label>-->
<!--                                    <input type="date" class="picker" name="second_week" value="--><?php //echo WC()->session->get('second_week') ?: ''?><!--">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form__block">-->
<!--                        <div class="form__subtitle">-->
<!--                            <span>--><?php //echo pll__('When do you want your water delivered?'); ?><!--</span>-->
<!--                        </div>-->
<!--                        <div class="form__row">-->
<!--                            <div class="input input--select">-->
<!--                                <input class="output_text" type="text" value="As Soon As Possible" readonly>-->
<!--                                <input class="output_value" type="hidden" name="delivery_term" value="--><?php //echo WC()->session->get('delivery_term') ?: 'asap'?><!--">-->
<!--                                <div class="input__dropdown">-->
<!--                                    <ul>-->
<!--                                        <li data-value="asap">--><?php //echo pll__('As Soon As Possible'); ?><!--</li>-->
<!--                                        <li data-value="date">--><?php //echo pll__('On A Specific Date'); ?><!--</li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form__row">-->
<!--                            <div class="input input--date">-->
<!--                                <input type="date" class="picker" name="delivery_term_date" data-validation="delivery_term_date" data-days-offset="2" value="--><?php //echo WC()->session->get('delivery_term_date') ?: ''?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="form__block woocommerce-additional-fields">
                        <?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>
                            <div class="form__subtitle">
                                <h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>
                            </div>
                        <?php endif; ?>
                        <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
    
                        <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
                            <div class="woocommerce-additional-fields__field-wrapper">
                                <div class="input-notice">
                                    <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                                        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                                    <?php endforeach; ?>
                                    <p><?php echo pll__('Provide details of where the water should be delivered, if necessary.'); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
    
                        <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
                    </div>
                    
                </div>
                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
        
               
        
                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
        
            <?php endif; ?>

            <aside class="checkout__aside">
                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="checkout__aside-inner woocommerce-checkout-review-order">
                    <?php remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 ); ?>
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
    
                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </aside>
        </div>
    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
