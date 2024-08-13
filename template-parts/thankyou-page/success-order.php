<?php

class Thankyou_Page_Success_Order {

    private $main_page;

    public function __construct() {

        $this->main_page = home_url();

        global $wp;

        $this->current_order_id =  intval( str_replace( 'checkout/order-received/', '', $wp->request ) );

    }

    public function render() {
        ?>

        <section class="success-order">
            <div class="container">
                <div class="success-order__container">
                    <div class="success-order__title title-h2">
                        <h1><?php echo pll__('Thank You for your order!'); ?></h1>
                    </div>
                    <div class="success-order__text section-text">
                        <p><?php echo pll__('Your water bottles you’ve chosen will soon at your door step whenever you want, without lifting a finger.'); ?></p>
                    </div>
                    <div class="success-order__img">
                        <img style="height: 100%!important;" src="<?=TEMPLATE_PATH?>/img/success-order.webp" alt="" role="presentation" width="700" height="600">
                    </div>
                    <div class="success-order__text section-text">
<!--                        <p>--><?php //echo pll__('Your Order'); ?><!-- <span>№ --><?php //echo $this->current_order_id; ?><!--</span> --><?php //echo pll__('will be delivered'); ?><!-- <span>--><?php //echo pll__('soon'); ?><!--</span></p>-->
                        <p><span><?php echo pll__('Order') . ' #' . $this->current_order_id; ?></span></p>
                        <p><?php echo pll__('Your water will soon be at your door, your back can thank us later'); ?></p>
                    </div>
                    <a href="<?php echo $this->main_page; ?>" class="success-order__btn btn"><?php echo pll__('Back To Main Page'); ?></a>
                </div>
            </div>
        </section>

        <?php
    }

}