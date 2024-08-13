<?php

class Page_Password_Reset {

    public static function init_auto() {

    }


    public static function get_url() {
        $page = get_pages( [
            'meta_key' => '_wp_page_template',
            'meta_value' => 'password-reset-page.php',
        ]);

        return ( $page && 'publish' === $page[ 0 ]->post_status ) ? get_the_permalink( $page[ 0 ]->ID ) : false;
    }

    public static function get_ID() {
        $page = get_pages( [
            'meta_key' => '_wp_page_template',
            'meta_value' => 'password-reset-page.php',
        ]);

        return ( $page && 'publish' === $page[ 0 ]->post_status ) ? $page[ 0 ]->ID : false;
    }

}