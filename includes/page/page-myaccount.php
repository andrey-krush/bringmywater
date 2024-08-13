<?php

class Page_Myaccount {

    public static function init_auto() {
        add_action('init', [__CLASS__, 'pll_strings']);
        add_action('wp_ajax_edit_user', [__CLASS__, 'editUserHandler'] );
        add_action('wp_ajax_nopriv_edit_user', [__CLASS__, 'editUserHandler'] );

        add_action('wp_ajax_change_password', [__CLASS__, 'changePasswordHandler'] );
        add_action('wp_ajax_nopriv_change_password', [__CLASS__, 'changePasswordHandler'] );
    }


    public static function pll_strings() : void {

        pll_register_string('myaccount-1', 'Personal Settings', 'Myaccount' );
        pll_register_string('myaccount-2', 'Recurring deliveries', 'Myaccount' );
        pll_register_string('myaccount-3', 'Password', 'Myaccount' );
        pll_register_string('myaccount-4', 'Personal Info', 'Myaccount' );
        pll_register_string('myaccount-5', 'Phone must be provided since it’s used only for deliverable purposes.', 'Myaccount' );
        pll_register_string('myaccount-6', 'Personal Settings', 'Myaccount' );
        pll_register_string('myaccount-7', 'Recurring deliveries', 'Myaccount' );
        pll_register_string('myaccount-8', 'Current Password', 'Myaccount' );
        pll_register_string('myaccount-9', 'New Password', 'Myaccount' );
        pll_register_string('myaccount-10', 'Confirm New Password', 'Myaccount' );
        pll_register_string('myaccount-11', 'Password Settings', 'Myaccount' );

    }

    public static function editUserHandler() {

        unset($_POST['action']);

        $user_id = get_current_user_id();

        update_field('gatecode', $_POST['gatecode'], 'user_' . $user_id);
        unset($_POST['gatecode']);

        $zip_code = $_POST['billing_postcode'];
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

            update_user_meta( $user_id, $key, $item );

        endforeach;

        wp_send_json_success();

    }

    public static function changePasswordHandler() {

        $currentPassword = $_POST['currentpassword'];
        $newPassword = $_POST['newpassword'];
        $repeatPassword = $_POST['repeatpassword'];

        $user = wp_get_current_user();

        if( wp_check_password($currentPassword, $user->user_pass, $user->ID) ) :

            if( $newPassword == $repeatPassword ) :

                wp_set_password( $newPassword , $user->ID );
                wp_send_json_success();

            else :
                wp_send_json_error(['errors' => [ 'newpassword' => 'new pass', 'repeatpassword' => 'repeat pass' ] ], 400);
            endif;

        else :
            wp_send_json_error(['errors' => ['currentpassword' => 'Wrong current pass'] ], 400);
        endif;

    }

}