<?php

class Header_Widget extends WP_Widget
{

    public static function init_auto()
    {
        add_action('widgets_init', [__CLASS__, 'widgets_init']);
        add_action('acf/init', [__CLASS__, 'acf_add_local_field_group']);
        add_action('init', [__CLASS__, 'polylang_translate']);
    }

    public static function polylang_translate()
    {
        pll_register_string('header', 'Profile Settings', 'Header');
        pll_register_string('header-2', 'Log Out', 'Header');
    }

    public static function widgets_init()
    {
        register_sidebar([
            'name' => 'Header',
            'id' => 'header',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ]);
        register_widget(__CLASS__);
    }

    function __construct()
    {
        parent::__construct('header-widget', 'Section header', []);
    }

    function widget($args, $instance)
    {

        $menu = get_field('menu', 'widget_' . $args['widget_id']);
        $logo = get_field('logo', 'widget_' . $args['widget_id']);
        $phone_number = get_field('phone_number', 'widget_' . $args['widget_id']);
        $mail = get_field('mail', 'widget_' . $args['widget_id']);
        $schedule = get_field('schedule', 'widget_' . $args['widget_id']);
        $facebook_link = get_field('facebook_link', 'widget_' . $args['widget_id']);
        $instagram_link = get_field('instagram_link', 'widget_' . $args['widget_id']);

        ?>

        <header class="header">
            <div class="container">
                <div class="header__container">
                    <div class="header__item">
                        <?php if (!empty($logo)) : ?>
                            <a href="<?php echo home_url(); ?>" class="logo" aria-label="go to main page">
                                <img src="<?php echo $logo; ?>" alt="logo" width="97" height="76">
                            </a>
                        <?php endif; ?>
                        <div class="header__row mobile-hide">
                            <?php if (!empty($phone_number)) : ?>
                                <a href="tel:<?= preg_replace('/\D/', '', $phone_number); ?>" class="page-phone">
                                    <div class="page-phone__ico">
                                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.6053 10.3067L11.092 9.9L9.41201 11.58C7.51947 10.6175 5.9812 9.07921 5.01868 7.18667L6.70534 5.5L6.29868 2H2.62534C2.23868 8.78667 7.81868 14.3667 14.6053 13.98V10.3067Z"
                                                  fill="white"/>
                                        </svg>
                                    </div>
                                    <span><?php echo $phone_number; ?></span>
                                </a>
                            <?php endif; ?>

                            <?php $languages = pll_the_languages(['raw' => 1]); ?>
                            <?php unset($languages[pll_current_language()]); ?>
                            <div class="header__dropdown dropdown">
                                <span><?php echo strtoupper(pll_current_language()); ?></span>
                                <div class="dropdown__list">
                                    <ul>
                                        <?php foreach ( $languages as $key => $item ) : ?>
                                            <li>
                                                <a href="<?php echo $item['url']; ?>"><?php echo strtoupper($key) ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header__item">
                        <?php if (!empty($menu)) : ?>
                            <nav class="header__nav mobile-hide">
                                <ul>
                                    <?php foreach ($menu as $item) : ?>
                                        <?php if (strstr($item['link']['url'], $_SERVER['REQUEST_URI']) and !is_front_page()) : ?>
                                            <li class="active">
                                        <?php elseif (is_front_page() and ($item['link']['url'] == home_url() . '/')) : ?>
                                            <li class="active">
                                        <?php else : ?>
                                            <li>
                                        <?php endif; ?>
                                            <?php if( $item['open_popup'] ) : ?>
                                                <a href="#popup-zip" data-fancybox="" ><?php echo $item['link']['title']; ?></a>
                                            <?php else : ?>
                                                <a href="<?php echo $item['link']['url']; ?>"><?php echo $item['link']['title']; ?></a>
                                        <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                        <div class="header__dropdown dropdown mobile-show">
                            <span><?php echo strtoupper(pll_current_language()); ?></span>
                            <div class="dropdown__list">
                                <ul>
                                    <?php foreach ( $languages as $key => $item ) : ?>
                                        <li>
                                            <a href="<?php echo $item['url']; ?>"><?php echo strtoupper($key) ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="header__btns">
                            <button type="button" class="header__btn header__btn--white js-toggle-account <?php echo !is_user_logged_in() ? 'not-logged' : '' ?>" aria-label="open login form">
                                <div class="header__btn-ico">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M6.66667 5.83333C6.66667 4.94928 7.01786 4.10143 7.64298 3.47631C8.2681 2.85119 9.11594 2.5 10 2.5C10.8841 2.5 11.7319 2.85119 12.357 3.47631C12.9821 4.10143 13.3333 4.94928 13.3333 5.83333C13.3333 6.71739 12.9821 7.56523 12.357 8.19036C11.7319 8.81548 10.8841 9.16667 10 9.16667C9.11594 9.16667 8.2681 8.81548 7.64298 8.19036C7.01786 7.56523 6.66667 6.71739 6.66667 5.83333ZM6.66667 10.8333C5.5616 10.8333 4.50179 11.2723 3.72039 12.0537C2.93899 12.8351 2.5 13.8949 2.5 15C2.5 15.663 2.76339 16.2989 3.23223 16.7678C3.70107 17.2366 4.33696 17.5 5 17.5H15C15.663 17.5 16.2989 17.2366 16.7678 16.7678C17.2366 16.2989 17.5 15.663 17.5 15C17.5 13.8949 17.061 12.8351 16.2796 12.0537C15.4982 11.2723 14.4384 10.8333 13.3333 10.8333H6.66667Z"
                                              fill="white"/>
                                    </svg>
                                </div>
                                <div class="header__modal">
                                    <?php if (is_user_logged_in()) : ?>
                                        <?php $user = wp_get_current_user();?>
                                       <div class="header__modal-inner">
                                           <div class="header__modal-name">
                                               <span><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
                                           </div>
                                           <div class="header__modal-email">
                                               <span><?php echo $user->user_email; ?></span>
                                           </div>
                                           <div class="header__modal-btns">
                                               <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="btn"><?php echo pll__('Profile Settings'); ?></a>
                                               <a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn--light"><?php echo pll__('Log Out'); ?></a>
                                           </div>
                                       </div>
                                    <?php else : ?>
                                        <div class="header__modal-inner">
                                            <div class="header__modal-btns">
                                                <a href="#popup-login" data-fancybox="" class="btn"><?php echo pll__('Log In'); ?></a>
                                                <a href="<?php echo Page_Registration::get_url(); ?>" class="btn btn--light"><?php echo pll__('Sign Up'); ?></a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </button>
                            <button type="button" class="header__btn js-open-cart" aria-label="open cart">
                                <div class="header__btn-ico">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.1666 15C13.2416 15 12.5 15.7417 12.5 16.6667C12.5 17.1087 12.6756 17.5326 12.9881 17.8452C13.3007 18.1578 13.7246 18.3334 14.1666 18.3334C14.6087 18.3334 15.0326 18.1578 15.3452 17.8452C15.6577 17.5326 15.8333 17.1087 15.8333 16.6667C15.8333 16.2247 15.6577 15.8007 15.3452 15.4882C15.0326 15.1756 14.6087 15 14.1666 15ZM0.833313 1.66669V3.33335H2.49998L5.49998 9.65835L4.36665 11.7C4.24165 11.9334 4.16665 12.2084 4.16665 12.5C4.16665 12.942 4.34224 13.366 4.6548 13.6785C4.96736 13.9911 5.39129 14.1667 5.83331 14.1667H15.8333V12.5H6.18331C6.12806 12.5 6.07507 12.4781 6.036 12.439C5.99693 12.3999 5.97498 12.3469 5.97498 12.2917C5.97498 12.25 5.98331 12.2167 5.99998 12.1917L6.74998 10.8334H12.9583C13.5833 10.8334 14.1333 10.4834 14.4166 9.97502L17.4 4.58335C17.4583 4.45002 17.5 4.30835 17.5 4.16669C17.5 3.94567 17.4122 3.73371 17.2559 3.57743C17.0996 3.42115 16.8877 3.33335 16.6666 3.33335H4.34165L3.55831 1.66669M5.83331 15C4.90831 15 4.16665 15.7417 4.16665 16.6667C4.16665 17.1087 4.34224 17.5326 4.6548 17.8452C4.96736 18.1578 5.39129 18.3334 5.83331 18.3334C6.27534 18.3334 6.69926 18.1578 7.01182 17.8452C7.32438 17.5326 7.49998 17.1087 7.49998 16.6667C7.49998 16.2247 7.32438 15.8007 7.01182 15.4882C6.69926 15.1756 6.27534 15 5.83331 15Z"
                                              fill="#036BCD"/>
                                    </svg>
                                    <div class="header__btn-num">
                                        <span><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="header__btn header__burger mobile-show"
                                        aria-label="open menu">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 16V14.8615H19V16H1ZM1 10.5693V9.43074H19V10.5693H1ZM1 5.13852V4H19V5.13852H1Z"
                                              fill="#036BCD"/>
                                    </svg>
                                </button>
                        </div>
                    </div>
                    <div class="header-notice">
                    </div>
                </div>
            </div>
        </header>
        <div class="menu mobile-show">
            <div class="menu__inner">
                <?php if (!empty($menu)) : ?>
                    <nav class="menu__nav">
                        <ul>
                            <?php foreach ($menu as $item) : ?>
                                <?php if (strstr($item['link']['url'], $_SERVER['REQUEST_URI']) and !is_front_page()) : ?>
                                    <li class="is_active">
                                <?php elseif (is_front_page() and (strstr($item['link']['url'], home_url()))) : ?>
                                    <li class="is_active">
                                <?php else : ?>
                                    <li>
                                <?php endif; ?>

                                <a href="<?php echo $item['link']['url']; ?>"><?php echo $item['link']['title']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
                <div class="menu__info">
                    <?php if (!empty($mail)) : ?>
                        <a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a>
                    <?php endif; ?>
                    <?php if (!empty($phone_number)) : ?>
                        <a href="tel:<?= preg_replace('/\D/', '', $phone_number); ?>" class="page-phone">
                            <div class="page-phone__ico">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.6053 10.3067L11.092 9.9L9.41201 11.58C7.51947 10.6175 5.9812 9.07921 5.01868 7.18667L6.70534 5.5L6.29868 2H2.62534C2.23868 8.78667 7.81868 14.3667 14.6053 13.98V10.3067Z"
                                          fill="white"></path>
                                </svg>
                            </div>
                            <span><?php echo $phone_number; ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($schedule)) : ?>
                        <div class="page-date">
                            <?php foreach ($schedule as $item) : ?>
                                <span><?php echo $item['text']; ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <ul class="socials">
                        <?php if (!empty($facebook_link)) : ?>
                            <li>
                                <a href="<?php echo $facebook_link; ?>" aria-label="go to facebook">
                                    <svg width="34" height="35" viewBox="0 0 34 35" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M33.6668 17.5063C33.6668 8.24531 26.205 0.737793 17.0002 0.737793C7.79541 0.737793 0.333496 8.24531 0.333496 17.5063C0.333496 25.8758 6.42823 32.8131 14.396 34.0711V22.3535H10.1642V17.5063H14.396V13.812C14.396 9.60939 16.8843 7.28799 20.6912 7.28799C22.5148 7.28799 24.422 7.61551 24.422 7.61551V11.7421H22.3205C20.2502 11.7421 19.6043 13.0348 19.6043 14.361V17.5063H24.2267L23.4878 22.3535H19.6043V34.0711C27.5722 32.8131 33.6668 25.8761 33.6668 17.5063Z"
                                              fill="#036bcd"></path>
                                    </svg>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($instagram_link)) : ?>
                            <li>
                                <a href="<?php echo $instagram_link ?>" aria-label="go to instagram">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.7135 3.3335C23.5885 3.3385 24.5401 3.3485 25.3618 3.37183L25.6852 3.3835C26.0585 3.39683 26.4268 3.4135 26.8718 3.4335C28.6451 3.51683 29.8552 3.79683 30.9168 4.2085C32.0168 4.63183 32.9435 5.20516 33.8702 6.13016C34.7176 6.96332 35.3734 7.97114 35.7918 9.0835C36.2035 10.1452 36.4835 11.3552 36.5668 13.1302C36.5868 13.5735 36.6035 13.9418 36.6168 14.3168L36.6268 14.6402C36.6518 15.4602 36.6618 16.4118 36.6652 18.2868L36.6668 19.5302V21.7135C36.6709 22.9292 36.6581 24.1448 36.6285 25.3602L36.6185 25.6835C36.6052 26.0585 36.5885 26.4268 36.5685 26.8702C36.4851 28.6452 36.2018 29.8535 35.7918 30.9168C35.3746 32.0298 34.7187 33.0379 33.8702 33.8702C33.0368 34.7174 32.029 35.3731 30.9168 35.7918C29.8552 36.2035 28.6451 36.4835 26.8718 36.5668C26.4763 36.5854 26.0808 36.6021 25.6852 36.6168L25.3618 36.6268C24.5401 36.6502 23.5885 36.6618 21.7135 36.6652L20.4701 36.6668H18.2885C17.0723 36.671 15.856 36.6582 14.6401 36.6285L14.3168 36.6185C13.9212 36.6035 13.5256 36.5863 13.1301 36.5668C11.3568 36.4835 10.1468 36.2035 9.08348 35.7918C7.97126 35.3741 6.96384 34.7182 6.13181 33.8702C5.28356 33.0373 4.62719 32.0294 4.20848 30.9168C3.79681 29.8552 3.51681 28.6452 3.43348 26.8702C3.41491 26.4747 3.39825 26.0791 3.38348 25.6835L3.37515 25.3602C3.34443 24.1449 3.33054 22.9292 3.33348 21.7135V18.2868C3.32883 17.0712 3.34105 15.8555 3.37015 14.6402L3.38181 14.3168C3.39515 13.9418 3.41181 13.5735 3.43181 13.1302C3.51515 11.3552 3.79515 10.1468 4.20681 9.0835C4.62534 7.97 5.28302 6.96187 6.13348 6.13016C6.9653 5.28262 7.97205 4.62681 9.08348 4.2085C10.1468 3.79683 11.3551 3.51683 13.1301 3.4335C13.5735 3.4135 13.9435 3.39683 14.3168 3.3835L14.6401 3.3735C15.8555 3.34388 17.0711 3.3311 18.2868 3.33516L21.7135 3.3335ZM20.0001 11.6668C17.79 11.6668 15.6704 12.5448 14.1076 14.1076C12.5448 15.6704 11.6668 17.79 11.6668 20.0002C11.6668 22.2103 12.5448 24.3299 14.1076 25.8927C15.6704 27.4555 17.79 28.3335 20.0001 28.3335C22.2103 28.3335 24.3299 27.4555 25.8927 25.8927C27.4555 24.3299 28.3335 22.2103 28.3335 20.0002C28.3335 17.79 27.4555 15.6704 25.8927 14.1076C24.3299 12.5448 22.2103 11.6668 20.0001 11.6668ZM20.0001 15.0002C20.6568 15.0001 21.307 15.1293 21.9136 15.3804C22.5203 15.6316 23.0716 15.9998 23.5359 16.464C24.0003 16.9283 24.3687 17.4794 24.6201 18.086C24.8714 18.6926 25.0009 19.3427 25.001 19.9993C25.0011 20.6559 24.8719 21.3061 24.6207 21.9128C24.3695 22.5195 24.0013 23.0707 23.5371 23.5351C23.0729 23.9995 22.5218 24.3679 21.9152 24.6192C21.3086 24.8706 20.6584 25.0001 20.0018 25.0002C18.6757 25.0002 17.404 24.4734 16.4663 23.5357C15.5286 22.598 15.0018 21.3262 15.0018 20.0002C15.0018 18.6741 15.5286 17.4023 16.4663 16.4646C17.404 15.5269 18.6757 15.0002 20.0018 15.0002M28.7518 9.16683C28.1993 9.16683 27.6694 9.38632 27.2787 9.77702C26.888 10.1677 26.6685 10.6976 26.6685 11.2502C26.6685 11.8027 26.888 12.3326 27.2787 12.7233C27.6694 13.114 28.1993 13.3335 28.7518 13.3335C29.3043 13.3335 29.8343 13.114 30.225 12.7233C30.6157 12.3326 30.8351 11.8027 30.8351 11.2502C30.8351 10.6976 30.6157 10.1677 30.225 9.77702C29.8343 9.38632 29.3043 9.16683 28.7518 9.16683Z"
                                              fill="#036bcd"></path>
                                    </svg>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <?php
    }

    function form($instance)
    {
        /** do nothing */
    }

    private function get_menu($args)
    {
    }

    public static function acf_add_local_field_group()
    {

        if (function_exists('acf_add_local_field_group')):


        endif;

    }
}
