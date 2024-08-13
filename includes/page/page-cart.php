<?php

class Page_Cart
{

    public static function init_auto()
    {
        add_action('wp_ajax_nopriv_change_cart_quantity', [__CLASS__, 'changeQuantity']);
        add_action('wp_ajax_change_cart_quantity', [__CLASS__, 'changeQuantity']);

        add_action('wp_ajax_nopriv_apply_coupon', [__CLASS__, 'applyCoupon']);
        add_action('wp_ajax_apply_coupon', [__CLASS__, 'applyCoupon']);

        add_action('wp_ajax_nopriv_update_cart', [__CLASS__, 'updateCart']);
        add_action('wp_ajax_update_cart', [__CLASS__, 'updateCart']);
    }


    public static function updateCart()
    {
        $cart_contents = WC()->cart->get_cart_contents();
        ?>
        <?php if (!empty($cart_contents)) : ?>
        <div class="cart__checkout">
            <div class="checkout__aside-info">
                <?php foreach ($cart_contents as $item) : ?>
                    <div class="cart-item" data-product-id="<?php echo $item['key']; ?>">
                        <?php $post_thumbnail = get_the_post_thumbnail_url($item['product_id']); ?>
                        <?php if (!empty($post_thumbnail)) : ?>
                            <div class="cart-item__img">
                                <img src="<?php echo $post_thumbnail; ?>" alt="product" width="156" height="208">
                            </div>
                        <?php endif; ?>
                        <div class="cart-item__wrapper">
                            <div class="cart-item__title">
                                <h2><?php echo get_the_title($item['product_id']); ?></h2>
                            </div>
                            <div class="cart-item__price">
                                <span> $ <?php echo $item['line_total']; ?></span>
                            </div>
                            <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="quantity">
                                <input type="hidden" name="action" value="change_quantity">
                                <div class="quantity__amount">
                                    <button type="button" class="quantity__btn" data-direction="minus">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 12H12H18" stroke="#A0AAB6" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <input class="quantity__input" type="text" min="1" max=""
                                           value="<?php echo $item['quantity']; ?>" readonly="" name="quantity">
                                    <button type="button" class="quantity__btn" data-direction="plus">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 12H12M12 12H18M12 12V6M12 12V18" stroke="#A0AAB6"
                                                  stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php $add_additional_products = get_field('add_additional_products', 'option'); ?>

                    <?php if ($add_additional_products) : ?>
                        <?php $quantity = $item['quantity']; ?>
                        <?php $need_to_buy = get_field('need_to_buy', 'option'); ?>
                        <?php $will_get = get_field('will_get', 'option'); ?>
                        <?php if ($quantity >= $need_to_buy) : ?>
                            <?php $additional_quantity = floor($item['quantity'] / $need_to_buy); ?>
                            <?php $additional_quantity = $additional_quantity * $will_get; ?>
                            <div class="cart-item">
                                <?php $post_thumbnail = get_the_post_thumbnail_url($item['product_id']); ?>
                                <?php if (!empty($post_thumbnail)) : ?>
                                    <div class="cart-item__img">
                                        <img src="<?php echo $post_thumbnail; ?>" alt="product" width="156"
                                             height="208">
                                    </div>
                                <?php endif; ?>
                                <div class="cart-item__wrapper">
                                    <div class="cart-item__title">
                                        <h2><?php echo get_the_title($item['product_id']); ?></h2>
                                    </div>
                                    <div class="cart-item__price">
                                        <span><?php echo $additional_quantity; ?> x $0</span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="checkout__code">
                <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="checkout__code-form">
                    <div class="checkout__code-input">
                        <input type="text" name="coupon" placeholder="<?php echo pll__('Enter code'); ?>" required>
                    </div>
                    <button type="submit" class="btn" disabled><?php echo pll__('Apply'); ?></button>
                </form>
            </div>
            <ul class="checkout__total">
                <li>
                    <span><?php echo pll__('Subtotal'); ?></span>
                    <span>$ <?php echo WC()->cart->get_subtotal(); ?></span>
                </li>
                <li>
                    <span><?php echo pll__('Delivery'); ?></span>
                    <span><?php echo pll__('Free'); ?></span>
                </li>
                <li>
                    <span><?php echo pll__('Total'); ?></span>
                    <span>$ <?php echo WC()->cart->get_cart_contents_total(); ?></span>
                </li>
            </ul>
            <div class="checkout__btn">
                <a href="<?php echo wc_get_page_permalink('checkout'); ?>"
                   class="btn"><?php echo pll__('Proceed To Pay'); ?></a>
            </div>
        </div>
        <?php else : ?>
            <div class="cart__empty">
                <div class="cart__empty-img">
                    <img src="<?= TEMPLATE_PATH ?>/img/cart-empty.svg" alt="" role="presentation" width="260" height="260">
                </div>
                <div class="cart__title title-h3">
                    <span><?php echo pll__('cart is empty'); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <?php die;
    }

    public static function changeQuantity()
    {
        WC()->cart->set_quantity($_POST['product_id'], $_POST['quantity_value']);
        (new Page_Cart)->updateCart();
    }

    public static function applyCoupon()
    {
        $applied_coupons = WC()->cart->get_applied_coupons();

        if (empty($applied_coupons)) :
            $coupon = WC()->cart->apply_coupon($_POST['coupon']);

            if ($coupon) :
                (new Page_Cart)->updateCart();
            else :
                wp_send_json_error('coupon_error', 400);
            endif;
        else :
            wp_send_json_error('coupon_applied', 400);
        endif;
    }

}