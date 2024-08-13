<?php

class Myaccount_Profile_Section {

    public function __construct() {

        $this->action_url = admin_url('admin-ajax.php');
        $user_id = get_current_user_id();
        $this->billing_phone = get_user_meta( $user_id, 'billing_phone', true ) ?? '';
        $this->billing_email = get_user_meta( $user_id, 'billing_email', true ) ?? '';
        $this->billing_first_name = get_user_meta( $user_id, 'billing_first_name', true ) ?? '';
        $this->billing_last_name = get_user_meta( $user_id, 'billing_last_name', true ) ?? '';
        $this->billing_postcode = get_user_meta( $user_id, 'billing_postcode', true ) ?? '';
        $this->billing_city = get_user_meta( $user_id, 'billing_city', true ) ?? '';
        $this->shipping_address_2 = get_user_meta( $user_id, 'shipping_address_2', true ) ?? '';
        $this->shipping_address_1 = get_user_meta( $user_id, 'shipping_address_1', true ) ?? '';
        $this->gatecode = get_field('gatecode', 'user_' . $user_id) ?? '';

        $this->password_reset_page = Page_Password_Reset::get_url();

    }


    public function render() {
        ?>

            <main class="main">
                <section class="personal">
                    <div class="container">
                        <div class="personal__container">
                            <aside class="personal__aside">
                                <ul>
                                    <li class="active">
                                        <a href=""><?php echo pll__('Personal Settings'); ?></a>
                                    </li>
<!--                                    <li>-->
<!--                                        <a href="./../personal-deliveries.html">--><?php //echo pll__('Recurring deliveries'); ?><!--</a>-->
<!--                                    </li>-->
                                    <li>
                                        <a href="<?php echo $this->password_reset_page; ?>"><?php echo pll__('Password'); ?></a>
                                    </li>
                                </ul>
                            </aside>
                            <div class="personal__wrapper">
                                <form action="<?php echo $this->action_url; ?>" method="post" class="personal__form form">
                                    <input type="hidden" name="action" value="edit_user">
                                    <div class="form__block">
                                        <div class="form__subtitle">
                                            <span><?php echo pll__('Personal Info'); ?></span>
                                        </div>
                                        <div class="form__row">
                                            <div class="input">
                                                <input type="text" name="billing_first_name" value="<?php echo $this->billing_first_name; ?>" placeholder="<?php echo pll__('First Name'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form__row">
                                            <div class="input">
                                                <input type="text" name="billing_last_name" value="<?php echo $this->billing_last_name; ?>" placeholder="<?php echo pll__('Last Name'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form__row">
                                            <div class="input">
                                                <input type="email" name="billing_email" value="<?php echo $this->billing_email; ?>" placeholder="<?php echo pll__('Email'); ?>" data-validation="email"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form__row">
                                            <div class="input-notice">
                                                <div class="input">
                                                    <input type="tel" name="billing_phone" value="<?php echo $this->billing_phone; ?>" placeholder="<?php echo pll__('Phone Number'); ?>"
                                                           data-validation="phone" required>
                                                </div>
                                                <p class="mobile-hide"><?php echo pll__('Phone must be provided since it’s used only for deliverable purposes.'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__block">
                                        <div class="form__subtitle">
                                            <span><?php echo pll__('Delivery Address'); ?></span>
                                        </div>
                                        <div class="form__row">
                                            <div class="input">
                                                <input type="text" name="billing_postcode" value="<?php echo $this->billing_postcode; ?>" placeholder="<?php echo pll__('Zip Code'); ?>" data-validation="zipcode"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form__row">
                                            <div class="input">
                                                <input type="text" name="billing_city" value="<?php echo $this->billing_city; ?>" placeholder="<?php echo pll__('City'); ?>" data-validation="city"
                                                       required>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="shipping_address_1" value="<?php echo $this->shipping_address_1; ?>" placeholder="<?php echo pll__('Street Address'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form__row">
                                            <div class="input">
                                                <input type="text" name="shipping_address_2" value="<?php echo $this->shipping_address_2;?>" placeholder="<?php echo pll__('Apart/Unit Number (Optional)'); ?>"
                                                       required>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="gatecode" value="<?php echo $this->gatecode; ?>" placeholder="<?php echo pll__('Gate Code (Optional)'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__btn">
                                        <button type="submit" class="btn"><?php echo pll__('Save'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

        <?php
    }

}