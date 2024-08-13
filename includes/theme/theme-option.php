<?php

class Theme_Option {

    public static function init_auto()
    {
        add_action('acf/init', [__CLASS__, 'acf_add_options_page']);
        add_action('acf/init', [__CLASS__, 'acf_add_local_field_group']);
        add_action('init', [__CLASS__, 'pll_strings']);

        add_action('wp_ajax_check_zip', [__CLASS__, 'checkZip']);
        add_action('wp_ajax_nopriv_check_zip', [__CLASS__, 'checkZip']);
    }

    public static function pll_strings() {
        pll_register_string('zip-code-1', 'Let’s verify if we service your area', 'zip-code', 'zip-code');
        pll_register_string('zip-code-2', 'Your ZIP Code', 'zip-code', 'zip-code');
        pll_register_string('zip-code-3', 'Check', 'zip-code', 'zip-code');
        pll_register_string('zip-code-4', 'Sorry!', 'zip-code', 'zip-code');
        pll_register_string('zip-code-5', 'Currently you are not in our delivery zone.', 'zip-code', 'zip-code');
        pll_register_string('zip-code-6', 'OK', 'zip-code', 'zip-code');


        pll_register_string('additional_products-1', 'Buy', 'additional_products', );
        pll_register_string('additional_products-1', 'get', 'additional_products', );
        pll_register_string('additional_products-1', 'free!', 'additional_products', );

    }
    public static function acf_add_options_page() {
        if (!function_exists('acf_add_options_page')) return;

        acf_add_options_page([
            'page_title' => 'Options page',
            'menu_title' => 'Options page',
            'menu_slug' => 'theme-options',
            'redirect' => false,
        ]);

    }

    public static function checkZip() {
        $zip_code = $_POST['zipcode'] ?? '';
        $available_zip_codes = get_field('available_zip_codes', 'option') ?? [];
        $token = $_POST['token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => '6Lf1YwcqAAAAAK6MFXaFEfhDl6QWHisU2PtZ0Bck', 'response' => $token)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);


        if (!empty($zip_code) && $arrResponse['success'] == '1' && $arrResponse['score'] > 0.6) {
            if( !empty( $available_zip_codes ) and in_array( ['code' => $zip_code], $available_zip_codes)  ) :

                $products = get_posts([
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'numberposts' => 1
                ]);

                if(  !empty( $products ) ) :

                    wp_send_json_success(['available'=>true, 'redirect_url' => get_the_permalink($products[0]->ID)]);

                endif;

            else :

                global $wpdb;
                $unavailable_zip = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $zip_code, 'unavailable_zip' ) );

                if( empty( $unavailable_zip ) ) :

                    $unavailable_zip_id = wp_insert_post([
                        'post_type' => 'unavailable_zip',
                        'post_status' => 'publish',
                        'post_title' => $zip_code
                    ]);

                    update_field('requests_count', 1, $unavailable_zip_id);

                else :

                    $requests_count = get_field('requests_count', $unavailable_zip);
                    $requests_count++;
                    update_field('requests_count', $requests_count, $unavailable_zip);

                endif;

                wp_send_json_error(['available'=>false], 400);

            endif;

        } else {
            wp_send_json_error(['available'=>false], 400);
        }

    }

    public static function acf_add_local_field_group() {


    }

}