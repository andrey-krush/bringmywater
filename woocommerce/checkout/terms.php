<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) { ?>
    <div class="checkout__aside-text section-text mobile-hide">
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
	<?php

	do_action( 'woocommerce_checkout_after_terms_and_conditions' );
}
