<?php dynamic_sidebar('footer'); ?>
<?php $cart_contents = WC()->cart->get_cart_contents(); ?>
<div class="cart">
    <div class="cart__inner">
        <div class="cart__container">
            <div class="cart__top">
                <div class="cart__title title-h3">
                    <span><?php echo pll__('Cart'); ?></span>
                </div>
                <button type="button" class="cart__close" aria-label="close cart">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.668 11.6667L28.3346 28.3334M11.668 28.3334L28.3346 11.6667" stroke="#6E7175"
                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="cart__body">
                <?php if( !empty( $cart_contents ) ) : ?>
                    <div class="cart__checkout">
                        <div class="checkout__aside-info">
                            <?php foreach ( $cart_contents as $item ) : ?>
                                <?php $quantity = $item['quantity']; ?>
                                <div class="cart-item" data-product-id="<?php echo $item['key']; ?>">
                                    <?php $post_thumbnail = get_the_post_thumbnail_url($item['product_id']); ?>
                                    <?php if( !empty( $post_thumbnail ) ) : ?>
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
                                                <input class="quantity__input" type="text" min="1" max="" value="<?php echo $item['quantity']; ?>"
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
                                        </form>
                                    </div>
                                </div>
                                <?php $add_additional_products = get_field('add_additional_products', 'option'); ?>

                                <?php if( $add_additional_products ) : ?>
                                    <?php $quantity = $item['quantity']; ?>
                                    <?php $need_to_buy = get_field('need_to_buy', 'option'); ?>
                                    <?php $will_get = get_field('will_get', 'option'); ?>
                                    <?php if( $quantity > $need_to_buy ) : ?>
                                        <?php $additional_quantity = floor($item['quantity'] / $need_to_buy); ?>
                                        <?php $additional_quantity = $additional_quantity * $will_get; ?>
                                        <div class="cart-item">
                                            <?php $post_thumbnail = get_the_post_thumbnail_url($item['product_id']); ?>
                                            <?php if( !empty( $post_thumbnail ) ) : ?>
                                                <div class="cart-item__img">
                                                    <img src="<?php echo $post_thumbnail; ?>" alt="product" width="156" height="208">
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
                                <input type="hidden" name="action" value="apply_coupon">
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
                            <a href="<?php echo wc_get_page_permalink('checkout'); ?>" class="btn"><?php echo pll__('Proceed To Pay'); ?></a>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="cart__empty">
                        <div class="cart__empty-img">
                            <img src="<?=TEMPLATE_PATH?>/img/cart-empty.svg" alt="" role="presentation" width="260" height="260">
                        </div>
                        <div class="cart__title title-h3">
                            <span><?php echo pll__('cart is empty'); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    <div class="popup" id="popup-login">
        <button type="button" class="popup__close" aria-label="popup close" data-fancybox-close>
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.668 11.6667L28.3346 28.3334M11.668 28.3334L28.3346 11.6667" stroke="#6E7175"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="popup__inner">
            <a href="" class="logo">
                <img src="<?=TEMPLATE_PATH?>/img/header-logo.svg" alt="" width="180" height="140">
            </a>
            <form action="" method="post" class="popup__form form">
                <input type="hidden" name="action" value="login">
                <div class="form__block">
                    <div class="form__row">
                        <div class="input">
                            <input type="text" name="email_tel" placeholder="<?php echo pll__('Email Or Phone Number'); ?>" required>
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="input">
                            <input type="password" name="password" placeholder="<?php echo pll__('Password'); ?>" required>
                        </div>
                    </div>
                    <div class="form__text form__text--small">
                        <a href="#popup-password"><?php echo pll__('Forgot Password?'); ?></a>
                    </div>
                </div>
                <div class="form__btn popup__btn">
                    <button type="submit" class="btn"><?php echo pll__('Log In'); ?></button>
                </div>
                <div class="form__text">
                    <p><?php echo pll__('Don’t Have An Account?');?> <a href="<?php echo Page_Registration::get_url(); ?>"><?php echo pll__('Sign Up Now'); ?></a></p>
                </div>
            </form>
        </div>
    </div>
    <div class="popup" id="popup-password">
        <button type="button" class="popup__close" aria-label="popup close" data-fancybox-close>
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.668 11.6667L28.3346 28.3334M11.668 28.3334L28.3346 11.6667" stroke="#6E7175"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="popup__inner">
            <div class="popup__title title-h3">
                <span><?php echo pll__('Forgot your Password?'); ?></span>
            </div>
            <form action="" method="post" class="popup__form form">
                <input type="hidden" name="action" value="reset_password_mail">
                <div class="form__block">
                    <div class="form__row">
                        <div class="input-notice">
                            <div class="input">
                                <input type="email" name="email" placeholder="<?php echo pll__('Email'); ?>" data-validation="email" required>
                            </div>
                            <p><?php echo pll__('Enter your account email. We’ll send you instructions on how to change your password.'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="form__btn popup__btn">
                    <button type="submit" class="btn"><?php echo pll__('Send Email'); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="popup" id="popup-zip">
        <button type="button" class="popup__close" aria-label="popup close" data-fancybox-close>
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.668 11.6667L28.3346 28.3334M11.668 28.3334L28.3346 11.6667" stroke="#6E7175"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="popup__inner">
            <a href="" class="logo">
                <img src="<?=TEMPLATE_PATH?>/img/header-logo.svg" alt="" width="180" height="140">
            </a>
            <div class="popup__title popup__title--small title-h3">
                <span><?php echo pll__('Let’s verify if we service your area'); ?></span>
            </div>
            <form action="" method="post" class="popup__form" data-error-popup="#popup-zip-incorrect">
                <input type="hidden" name="action" value="check_zip">
                <div class="form__block">
                    <div class="form__row">
                        <div class="input">
                            <input type="text" name="zipcode" placeholder="<?php echo pll__('Your ZIP Code'); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form__btn popup__btn">
                    <button type="submit" class="btn"><?php echo pll__('Check'); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="popup popup-code-incorrect" id="popup-zip-incorrect">
        <button type="button" class="popup__close" aria-label="popup close" data-fancybox-close>
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.668 11.6667L28.3346 28.3334M11.668 28.3334L28.3346 11.6667" stroke="#6E7175"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="popup__inner">
            <div class="popup__img">
                <img src="<?=TEMPLATE_PATH?>/img/img-location.webp" alt="" role="presentation" width="265" height="280">
            </div>
            <div class="popup__title title-h3">
                <span><?php echo pll__('Sorry!'); ?></span>
            </div>
            <div class="popup__title popup__title--small title-h3">
                <span><?php echo pll__('Currently you are not in our delivery zone.'); ?></span>
            </div>
            <div class="popup__btn">
                <button type="button" class="btn" data-fancybox-close=""><?php echo pll__('OK'); ?></button>
            </div>
        </div>
    </div>
    <div class="popup popup-promocode" id="popup-promocode">
        <button type="button" class="popup__close" aria-label="popup close" data-fancybox-close>
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.668 11.6667L28.3346 28.3334M11.668 28.3334L28.3346 11.6667" stroke="#6E7175"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="popup__inner">
            <div class="checkout__code-form">
                <div class="checkout__code-text">
                    <span>Promocode</span>
                </div>
                <div class="checkout__code-input">
                    <input type="text" name="coupon" placeholder="Enter code" required="">
                </div>
                <button type="button" class="btn">Apply</button>
            </div>
        </div>
    </div>
</div>

<script>
    const TEMPLATE_PATH = ''
    let messages = {
        "added_to_cart": "Item added to the cart",
        "added_promocode": "Promocode applied",
    }
    let validationErrors = {
        "required": "This field is required",
        "invalid": "This field is invalid",
        "allowed_ext": "Allowed extensions: &1",
        "max_size": "Maximum file size is &1",
        "max_files": "Maximum files you can upload is &1",
        "minlength": "Minimum number of characters is &1",
        "maxlength": "Maximum number of characters is &1",

        "firstname": {
            "required": "First Name is required."
        },
        "delivery_term_date": {
            "delivery_term_date": "The nearest delivery date is from &1"
        },
        "lastname": {
            "required": "Last Name is required."
        },
        "name": {
            "regex": "Only letters and white space allowed"
        },
        "email": {
            "regex": "The field is filled in incorrectly",
            "required": "E-mail is required."
        },
        "zipcode": {
            "required": "Zip Code is required."
        },
        "language": {
            "required": "Language is required."
        },
        "city": {
            "required": "City is required."
        },
        "phone": {
            "required": "Phone is required."
        },
        "password": {
            "minlength": "Minimum number of characters is &1",
            "regex": "The password must contain numbers and Latin letters",
        },
        "password_repeat": {
            "password_repeat": "Passwords don't match"
        },
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="<?=TEMPLATE_PATH?>/js/common.js"></script>
<script src="<?=TEMPLATE_PATH?>/js/main.js"></script>
<script src="<?=TEMPLATE_PATH?>/js/sections/checkout.js"></script>
<?php if( is_account_page() ) : ?>
    <script src="<?=TEMPLATE_PATH?>/js/sections/personal.js"></script>
<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>

</html>