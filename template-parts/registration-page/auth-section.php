<?php

class Registration_Page_Auth_Section
{


    public function __construct()
    {


    }

    public function sectionStyles(): array
    {

        return array(
            'auth' => TEMPLATE_PATH . '/css/sections/auth.css',
        );

    }

    public function sectionScripts(): array
    {

        return array(
            'auth' => TEMPLATE_PATH . '/js/sections/sign-up.js',
        );

    }

    public function render(): void
    {
        ?>

        <section class="auth">
            <div class="auth__container">
                <div class="auth__form show-hide-on-success">
                    <form action="<?php echo admin_url('admin-ajax.php');?>" method="post" class="form hide-on-success">
                        <input type="hidden" name="action" value="registration">
                        <div class="auth__title title-h2">
                            <h1><?php echo pll__('Sign Up'); ?></h1>
                        </div>
                        <div class="form__block">
                            <div class="form__subtitle">
                                <span><?php echo pll__('Personal Info'); ?></span>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="text" name="firstname" maxlength="25" minlength="2" placeholder="<?php echo pll__('First Name'); ?>" required>
                                </div>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="text" name="lastname" maxlength="25" minlength="2" placeholder="<?php echo pll__('Last Name'); ?>" required>
                                </div>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="email" name="email" maxlength="100" placeholder="<?php echo pll__('Email'); ?>" data-validation="email" required>
                                </div>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="tel" name="phone" placeholder="<?php echo pll__('Phone Number'); ?>" data-validation="phone" required>
                                </div>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="password" name="password" placeholder="<?php echo pll__('Password'); ?>" data-validation="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="form__block">
                            <div class="form__subtitle">
                                <span><?php echo pll__('Delivery Address'); ?></span>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="text" name="zip" placeholder="<?php echo pll__('Zip Code'); ?>" data-validation="zipcode" required>
                                </div>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="text" name="city" placeholder="<?php echo pll__('City'); ?>" data-validation="city" required>
                                </div>
                                <div class="input">
                                    <input type="text" name="street" placeholder="<?php echo pll__('Street Address'); ?>" required>
                                </div>
                            </div>
                            <div class="form__row">
                                <div class="input">
                                    <input type="text" name="apart" placeholder="<?php echo pll__('Apart/Unit Number (Optional)'); ?>">
                                </div>
                                <div class="input">
                                    <input type="text" name="gatecode" placeholder="<?php echo pll__('Gate Code (Optional)'); ?>">
                                </div>
                            </div>
                            <label class="input input--checkbox">
                                <input type="checkbox" name="agree" required>
                                <span><?php echo pll__('By proceeding to create your account, you’re agreeing to our'); ?> <a href="<?php echo Page_Text::get_url(); ?>"><?php echo pll__('Terms & Conditions'); ?></a></span>
                            </label>
                            <label class="input input--checkbox">
                                <input type="checkbox" name="promotions">
                                <span><?php echo pll__('I want to receive promotions and discounts to my email'); ?></span>
                            </label>
                        </div>
                        <div class="form__btn">
                            <button type="submit" class="btn"><?php echo pll__('Sign Up'); ?></button>
                        </div>
                    </form>
                    <div class="auth__form-success show-on-success">
                        <div class="auth__form-success__img">
                            <img src="<?=TEMPLATE_PATH?>/img/success-letter.webp" alt="" role="presentation" width="355" height="355">
                        </div>
                        <div class="section-text section-text--small">
                            <p><?php echo pll__('Check Your Email To complete Registration'); ?></p>
                        </div>
                        <div class="auth__form-success__btn">
                            <form action="<?php echo admin_url('admin-ajax.php');?>" method="post" class="form">
                                <input type="hidden" value="resend_email" name="action">
                                <input type="hidden" name="unverified_user_id">
                                <button type="submit" class="btn" data-text-success="<?php echo pll__('Resended successfully'); ?>" data-text-error="Error"><span><?php echo pll__('Resend Email'); ?></span></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="auth__img mobile-hide">
                    <img src="<?=TEMPLATE_PATH?>/img/sign-img.webp" alt="" role="presentation" width="945" height="954">
                </div>
            </div>
        </section>

        <?php
    }
}