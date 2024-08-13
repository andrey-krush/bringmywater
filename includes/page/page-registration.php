<?php

class Page_Registration {

    public static function init_auto() {
        add_action( 'acf/init', [__CLASS__, 'acf_add_local_field_group'] );
        add_action('init', [__CLASS__, 'pll_strings']);

        add_action('wp_ajax_registration', [__CLASS__, 'registration']);
        add_action('wp_ajax_nopriv_registration', [__CLASS__, 'registration']);

        add_action('wp_ajax_resend_email', [__CLASS__, 'resendEmail']);
        add_action('wp_ajax_nopriv_resend_email', [__CLASS__, 'resendEmail']);

        add_action('wp_ajax_login', [__CLASS__, 'login']);
        add_action('wp_ajax_nopriv_login', [__CLASS__, 'login']);
    }

    public static function pll_strings() {

        pll_register_string('registration-1','Personal Info', 'registration');
        pll_register_string('registration-2','First Name', 'registration');
        pll_register_string('registration-3','Last Name', 'registration');
        pll_register_string('registration-4','Email', 'registration');
        pll_register_string('registration-5','Phone Number', 'registration');
        pll_register_string('registration-6','Password', 'registration');
        pll_register_string('registration-7','Delivery Address', 'registration');
        pll_register_string('registration-8','Zip Code', 'registration');
        pll_register_string('registration-9','City', 'registration');
        pll_register_string('registration-10','Street Address', 'registration');
        pll_register_string('registration-11','Apart/Unit Number (Optional)', 'registration');
        pll_register_string('registration-12','Gate Code (Optional)', 'registration');
        pll_register_string('registration-13','Sign Up', 'registration');
        pll_register_string('registration-14','User with this email exists', 'registration');
        pll_register_string('registration-15','I want to receive promotions and discounts to my email', 'registration', true);
        pll_register_string('registration-17','By proceeding to create your account, you’re agreeing to our', 'registration', true);
        pll_register_string('registration-18','Terms & Conditions', 'registration');
        pll_register_string('registration-19','Check Your Email To complete Registration', 'registration');
        pll_register_string('registration-20','Resend Email', 'registration');
        pll_register_string('registration-21','Resended successfully', 'registration');


        pll_register_string('login-1', 'Email Or Phone Number', 'login');
        pll_register_string('login-2', 'Forgot Password?', 'login');
        pll_register_string('login-3', 'Log In', 'login');
        pll_register_string('login-4', 'Don’t Have An Account?', 'login');
        pll_register_string('login-5', 'Sign Up Now', 'login');
        pll_register_string('login-6', 'User not exists', 'login');
        pll_register_string('login-6', 'Wrong password', 'login');

        pll_register_string('reset-pass-1', 'Forgot your Password?', 'Forgot password');
        pll_register_string('reset-pass-2', 'Enter your account email. We’ll send you instructions on how to change your password.', 'Forgot password');
        pll_register_string('reset-pass-3', 'Send Email', 'Forgot password');

    }

    public static function login() {

        $email = $_POST['email_tel'];
        $password = $_POST['password'];

        if( str_contains($email, '@') ) :

            $user = get_user_by('email', $email);

        else:

            $user = get_users([
                'number' => 1,
                'meta_query' => [
                    [
                        'key' => 'billing_phone',
                        'value' => $_POST['email_tel']
                    ]
                ]
            ]);

            $user = $user[0] ?? false;

        endif;

        if( !$user ) :

            wp_send_json_error([ 'errors' => [ 'email_tel' => pll__('User not exists') ] ], 400);
            exit();

        endif;

        $login_data = array();
        $login_data['user_login'] = $user->user_email;
        $login_data['user_password'] = $password;
        $login_data['remember'] = true;

        $login_user = wp_signon( $login_data, true );
        if ( !empty( $login_user->errors ) ) {
            wp_send_json_error( [ 'errors' => [ 'password' => pll__('Wrong password') ] ], 400 );
            exit();
        }

        wp_send_json_success(['redirect_url' => wc_get_page_permalink('myaccount')]);
        exit();
    }

    public static function resendEmail() : void {

        unset($_POST['action']);

        if( !empty( $_POST['unverified_user_id'] ) )  :

            $user_code = get_post_meta($_POST['unverified_user_id'], 'verification_code', true);
            $email = get_field('email', $_POST['unverified_user_id']);

            $link = home_url() . '?verification=' . base64_encode($user_code);

            $message = 'Please click the link below to confirm your email and complete the registration process.<br>' . $link;

            $headers = [
                'From: bringMyWater <wordpress@bringmywater.sheep.fish>',
                'content-type: text/html'
            ];

            $to = $email;
            $subject = 'Verify your account';

            wp_mail($to, $subject, $message, $headers);

            wp_send_json_success();

        endif;

    }

    public static function registration() : void {

        unset($_POST['action']);

        $email = $_POST['email'];

        if ( get_user_by_email( $email ) ) {
            $error = pll__('User with this email exists');
            wp_send_json_error( ['name' => 'Email', 'error' => $error], 400 );
        }

        $unverified_user = wp_insert_post([
            'post_type' => 'unverified_user',
            'post_status' => 'publish'
        ]);

        $zip_code = $_POST['zip'] ?? '';
        $available_zip_codes = get_field('available_zip_codes', 'option') ?? [];

        if( !empty( $zip_code ) ) :

            if( !empty( $available_zip_codes ) and in_array( ['code' => $zip_code], $available_zip_codes)  ) :

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

        else :
            wp_send_json_error(['available'=>false], 400);
        endif;

        foreach ( $_POST as $key => $item ) :

            if( $key != 'password' ) :

                update_field($key, $item, $unverified_user);

            endif;

        endforeach;
        
        if( $_POST['promotions'] == 'on' ) : 

            update_post_meta($unverified_user, 'promotions', 1);
            
        endif;    
            
        $user_code = self::generateRandomString();

        update_post_meta($unverified_user, 'verification_code', $user_code);
        $encrypt_password = self::encryptString($_POST['password'], $user_code);
        update_post_meta($unverified_user, 'encrypted_pass', $encrypt_password);

        $link = home_url() . '?verification=' . base64_encode($user_code);

        $message = 'Please click the link below to confirm your email and complete the registration process.<br>' . $link;

        $headers = [
            'From: bringMyWater <wordpress@bringmywater.sheep.fish>',
            'content-type: text/html'
        ];

        $to = $email;
        $subject = 'Verify your account';

        wp_mail($to, $subject, $message, $headers);

        wp_send_json_success(['unverified_user_id' => $unverified_user]);

    }

    public static function encryptString($string, $key) : string {

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $encrypted = openssl_encrypt($string, 'aes-256-cbc', $key, 0, $iv);

        return base64_encode($iv . $encrypted);

    }

    public static function decryptString($encryptedData, $key) : string {

        $decodedData = base64_decode($encryptedData);

        $ivSize = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($decodedData, 0, $ivSize);
        $encrypted = substr($decodedData, $ivSize);

        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);

    }

    private static function generateRandomString($length = 6) : string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public static function get_url() {
        $page = get_pages( [
            'meta_key' => '_wp_page_template',
            'meta_value' => 'registration-page.php',
        ]);

        return ( $page && 'publish' === $page[ 0 ]->post_status ) ? get_the_permalink( $page[ 0 ]->ID ) : false;
    }

    public static function get_ID() {
        $page = get_pages( [
            'meta_key' => '_wp_page_template',
            'meta_value' => 'registration-page.php',
        ]);

        return ( $page && 'publish' === $page[ 0 ]->post_status ) ? $page[ 0 ]->ID : false;
    }

    public static function acf_add_local_field_group() {

        if ( function_exists('acf_add_local_field_group') ):


        endif;

    }



}