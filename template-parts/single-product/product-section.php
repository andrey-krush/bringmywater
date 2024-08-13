<?php

class Single_Product_Product_Section {


    private $title;
    private $thumbnail;
    private string $price;
    private string $description;
    private mixed $text_above_title;
    private mixed $advantages;
    private mixed $marquee;

    public function __construct() {

        $this->title = get_the_title();
        $this->thumbnail = get_the_post_thumbnail_url();

        $this->product = wc_get_product(get_the_ID());
        $this->price = $this->product->get_price();
        $this->description = $this->product->get_description();

        $content_section = get_field('content');
        $this->text_above_title = $content_section['text_above_title'];
        $this->advantages = $content_section['advantages'];

        $promo_section = get_field('promo_section', get_option('page_on_front'));
        $this->marquee = $promo_section['marquee'];

        $this->add_additional_products = get_field('add_additional_products', 'option');

    }

    public function sectionStyles(): array
    {

        return array(
            'product' => TEMPLATE_PATH . '/css/sections/product.css',
        );

    }

    public function sectionScripts(): array
    {

        return array(
            'product' => TEMPLATE_PATH . '/js/sections/product.js',
        );

    }

    public function render() : void {
        ?>
            <?php if( !empty( $this->marquee ) ) : ?>
                <div class="marquee">
                    <div class="marquee__content">
                        <div class="marquee__unit">
                            <?php foreach ( $this->marquee as $item ) : ?>
                                <span><?php echo $item['text']; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <section class="product">
                <div class="container container--full">
                    <div class="product__container">
                        <div class="product__info">
                            <?php if( !empty( $this->text_above_title ) ) : ?>
                                <div class="subtitle">
                                    <span><?php echo $this->text_above_title; ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="product__title title-h2">
                                <h1><?php echo $this->title; ?></h1>
                            </div>
                            <div class="product__price">
                                <span>$ <?php echo $this->price; ?></span>
                            </div>
                            <?php if( !empty( $this->description ) ) : ?>
                                <div class="product__text section-text">
                                    <?php echo $this->description; ?>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $this->advantages ) ) : ?>
                                <ul class="product__list">
                                    <?php foreach ( $this->advantages as $item ) : ?>
                                        <li>
                                            <?php if( !empty( $item['icon'] ) ) : ?>
                                                <img src="<?php echo $item['icon']; ?>" alt="sharp" width="24" height="24">
                                            <?php endif; ?>
                                            <?php if( !empty( $item['text'] ) ) : ?>
                                                <span><?php echo $item['text']; ?></span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <form action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $this->product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                              <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                              <?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>
                                <div class="quantity">
                                    <div class="quantity__amount">
                                        <button type="button" class="quantity__btn" data-direction="minus">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 12H12H18" stroke="#A0AAB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <input class="quantity__input" name="quantity" type="text" min="<?php echo apply_filters( 'woocommerce_quantity_input_min', $this->product->get_min_purchase_quantity(), $this->product ); ?>" max="<?php echo $this->product->get_max_purchase_quantity() > -1 ? $this->product->get_max_purchase_quantity() : ''; ?>" value="<?php echo isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $this->product->get_min_purchase_quantity(); ?>" readonly="">
                                        <button type="button" class="quantity__btn" data-direction="plus">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 12H12M12 12H18M12 12V6M12 12V18" stroke="#A0AAB6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <?php do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>

                                <div class="product__btn">
                                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $this->product->get_id() ); ?>" class="btn ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo get_the_ID(); ?>" aria-label="Add “<?php the_title_attribute() ?>” to your cart"><?php echo esc_html( $this->product->single_add_to_cart_text() ); ?></button>
                                </div>
                              <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                            </form>
                        </div>
                        <?php if( !empty( $this->thumbnail ) ) : ?>
                            <div class="product__img">
                                <?php if( $this->add_additional_products ) : ?>
                                    <div class="tag">
                                        <span><?php echo pll__('Buy'); ?> <?php echo get_field('need_to_buy', 'option'); ?>, <?php echo pll__('get'); ?> <?php echo get_field('will_get', 'option'); ?> <?php echo pll__('free!'); ?> </span>
                                    </div>
                                <?php endif; ?>
                                <img src="<?php echo $this->thumbnail; ?>" alt="bottle" width="740" height="740">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

        <?php
    }
}