<?php

class Footer_Widget extends WP_Widget {

    public static function init_auto() {
        add_action('widgets_init', [__CLASS__, 'widgets_init']);
        add_action('acf/init', [__CLASS__, 'acf_add_local_field_group']);
        add_action('init', [__CLASS__, 'polylang_translate']);
    }

    public static function polylang_translate() {

    }

    public static function widgets_init() {
        register_sidebar( [
            'name'          => 'Footer',
            'id'            => 'footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ] );
        register_widget(__CLASS__);
    }

    function __construct() {
        parent::__construct('footer-widget', 'Section footer', []);
    }

    function widget($args, $instance) {

        $menu = get_field('menu', 'widget_' . $args['widget_id']);
        $logo = get_field('logo', 'widget_' . $args['widget_id']);
        $phone_number = get_field('phone_number', 'widget_' . $args['widget_id']);
        $mail = get_field('mail', 'widget_' . $args['widget_id']);
        $schedule = get_field('schedule', 'widget_' . $args['widget_id']);
        $facebook_link = get_field('facebook_link', 'widget_' . $args['widget_id']);
        $instagram_link = get_field('instagram_link', 'widget_' . $args['widget_id']);
        $copyright_text = get_field('copyright_text', 'widget_' . $args['widget_id']);

        ?>

        <footer class="footer">
            <div class="container">
                <div class="footer__container">
                    <?php if( !empty( $logo ) ) : ?>
                        <a href="<?php echo home_url(); ?>" class="logo">
                            <img src="<?php echo $logo; ?>" alt="logo" width="227" height="200">
                        </a>
                    <?php endif; ?>
                    <div class="footer__item">
                        <?php if( !empty( $menu ) ) : ?>
                            <nav class="footer__nav">
                                <ul>
                                    <?php foreach ( $menu as $item ) : ?>
                                        <li>
                                            <a href="<?php echo $item['link']['url']; ?>"><?php echo $item['link']['title']; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                        <div class="footer__info">
                            <?php if ( !empty( $phone_number ) ) : ?>
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
                            <?php if( !empty( $schedule ) ) : ?>
                                <div class="footer__date page-date">
                                    <?php foreach ( $schedule as $item ) : ?>
                                        <span><?php echo $item['text']; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $mail ) ) : ?>
                                <a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a>
                            <?php endif; ?>
                            <ul class="socials">
                                <?php if( !empty( $facebook_link ) ) : ?>
                                    <li>
                                        <a href="<?php echo $facebook_link; ?>" aria-label="go to facebook">
                                            <svg width="34" height="35" viewBox="0 0 34 35" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M33.6668 17.5063C33.6668 8.24531 26.205 0.737793 17.0002 0.737793C7.79541 0.737793 0.333496 8.24531 0.333496 17.5063C0.333496 25.8758 6.42823 32.8131 14.396 34.0711V22.3535H10.1642V17.5063H14.396V13.812C14.396 9.60939 16.8843 7.28799 20.6912 7.28799C22.5148 7.28799 24.422 7.61551 24.422 7.61551V11.7421H22.3205C20.2502 11.7421 19.6043 13.0348 19.6043 14.361V17.5063H24.2267L23.4878 22.3535H19.6043V34.0711C27.5722 32.8131 33.6668 25.8761 33.6668 17.5063Z"
                                                      fill="white"/>
                                            </svg>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if( !empty( $instagram_link ) ) : ?>
                                    <li>
                                        <a href="<?php echo $instagram_link?>" aria-label="go to instagram">
                                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21.7135 3.3335C23.5885 3.3385 24.5401 3.3485 25.3618 3.37183L25.6852 3.3835C26.0585 3.39683 26.4268 3.4135 26.8718 3.4335C28.6451 3.51683 29.8552 3.79683 30.9168 4.2085C32.0168 4.63183 32.9435 5.20516 33.8702 6.13016C34.7176 6.96332 35.3734 7.97114 35.7918 9.0835C36.2035 10.1452 36.4835 11.3552 36.5668 13.1302C36.5868 13.5735 36.6035 13.9418 36.6168 14.3168L36.6268 14.6402C36.6518 15.4602 36.6618 16.4118 36.6652 18.2868L36.6668 19.5302V21.7135C36.6709 22.9292 36.6581 24.1448 36.6285 25.3602L36.6185 25.6835C36.6052 26.0585 36.5885 26.4268 36.5685 26.8702C36.4851 28.6452 36.2018 29.8535 35.7918 30.9168C35.3746 32.0298 34.7187 33.0379 33.8702 33.8702C33.0368 34.7174 32.029 35.3731 30.9168 35.7918C29.8552 36.2035 28.6451 36.4835 26.8718 36.5668C26.4763 36.5854 26.0808 36.6021 25.6852 36.6168L25.3618 36.6268C24.5401 36.6502 23.5885 36.6618 21.7135 36.6652L20.4701 36.6668H18.2885C17.0723 36.671 15.856 36.6582 14.6401 36.6285L14.3168 36.6185C13.9212 36.6035 13.5256 36.5863 13.1301 36.5668C11.3568 36.4835 10.1468 36.2035 9.08348 35.7918C7.97126 35.3741 6.96384 34.7182 6.13181 33.8702C5.28356 33.0373 4.62719 32.0294 4.20848 30.9168C3.79681 29.8552 3.51681 28.6452 3.43348 26.8702C3.41491 26.4747 3.39825 26.0791 3.38348 25.6835L3.37515 25.3602C3.34443 24.1449 3.33054 22.9292 3.33348 21.7135V18.2868C3.32883 17.0712 3.34105 15.8555 3.37015 14.6402L3.38181 14.3168C3.39515 13.9418 3.41181 13.5735 3.43181 13.1302C3.51515 11.3552 3.79515 10.1468 4.20681 9.0835C4.62534 7.97 5.28302 6.96187 6.13348 6.13016C6.9653 5.28262 7.97205 4.62681 9.08348 4.2085C10.1468 3.79683 11.3551 3.51683 13.1301 3.4335C13.5735 3.4135 13.9435 3.39683 14.3168 3.3835L14.6401 3.3735C15.8555 3.34388 17.0711 3.3311 18.2868 3.33516L21.7135 3.3335ZM20.0001 11.6668C17.79 11.6668 15.6704 12.5448 14.1076 14.1076C12.5448 15.6704 11.6668 17.79 11.6668 20.0002C11.6668 22.2103 12.5448 24.3299 14.1076 25.8927C15.6704 27.4555 17.79 28.3335 20.0001 28.3335C22.2103 28.3335 24.3299 27.4555 25.8927 25.8927C27.4555 24.3299 28.3335 22.2103 28.3335 20.0002C28.3335 17.79 27.4555 15.6704 25.8927 14.1076C24.3299 12.5448 22.2103 11.6668 20.0001 11.6668ZM20.0001 15.0002C20.6568 15.0001 21.307 15.1293 21.9136 15.3804C22.5203 15.6316 23.0716 15.9998 23.5359 16.464C24.0003 16.9283 24.3687 17.4794 24.6201 18.086C24.8714 18.6926 25.0009 19.3427 25.001 19.9993C25.0011 20.6559 24.8719 21.3061 24.6207 21.9128C24.3695 22.5195 24.0013 23.0707 23.5371 23.5351C23.0729 23.9995 22.5218 24.3679 21.9152 24.6192C21.3086 24.8706 20.6584 25.0001 20.0018 25.0002C18.6757 25.0002 17.404 24.4734 16.4663 23.5357C15.5286 22.598 15.0018 21.3262 15.0018 20.0002C15.0018 18.6741 15.5286 17.4023 16.4663 16.4646C17.404 15.5269 18.6757 15.0002 20.0018 15.0002M28.7518 9.16683C28.1993 9.16683 27.6694 9.38632 27.2787 9.77702C26.888 10.1677 26.6685 10.6976 26.6685 11.2502C26.6685 11.8027 26.888 12.3326 27.2787 12.7233C27.6694 13.114 28.1993 13.3335 28.7518 13.3335C29.3043 13.3335 29.8343 13.114 30.225 12.7233C30.6157 12.3326 30.8351 11.8027 30.8351 11.2502C30.8351 10.6976 30.6157 10.1677 30.225 9.77702C29.8343 9.38632 29.3043 9.16683 28.7518 9.16683Z"
                                                      fill="white"/>
                                            </svg>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if( !empty( $copyright_text ) ) : ?>
                    <div class="footer__bottom">
                        <span><?php echo $copyright_text; ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </footer>

        <?php
    }

    function form($instance) {
        /** do nothing */
    }

    private function get_menu($args) {
    }

    public static function acf_add_local_field_group() {

        if ( function_exists('acf_add_local_field_group') ):



        endif;

    }
}
