<?php

class Type_User {

    public static function init_auto() {

        add_action('wp_ajax_reset_password_mail', [ __CLASS__, 'sendNewPass' ] );
        add_action('wp_ajax_nopriv_reset_password_mail', [ __CLASS__, 'sendNewPass' ] );

    }

    public static function sendNewPass() {

        if( !empty( $_POST['email'] ) ) :

            $user = get_user_by('email', $_POST['email']);

            if( empty( $user ) ) :
                wp_send_json_error( [ 'errors' => [ 'email' => 'user_not_exists' ] ], 400 );
            endif;

            $pass = wp_generate_password();

            wp_set_password($pass, $user->ID);

            $message = 'Your new password : ' . $pass;

            $headers = [
                'From: bringMyWater <wordpress@bringmywater.sheep.fish>',
                'content-type: text/html'
            ];

            wp_mail($_POST['email'], 'Password reset', $message, $headers);

            wp_send_json_success();

            die;

        endif;

    }

}

