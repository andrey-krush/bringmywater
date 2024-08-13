<?php

class Type_Unverified_User {

    public static function init_auto() {

        add_action('init', [__CLASS__, 'registerPostType']);
        add_action('init', [__CLASS__, 'verification']);

    }

    public static function verification() {

        if( isset( $_GET['verification'] ) and !empty( $_GET['verification'] )) :

            $code = base64_decode($_GET['verification']);

            $unverified_user = get_posts([
                'post_type' => 'unverified_user',
                'numberposts' => 1,
                'post_status' => 'publish',
                'meta_query' => [
                    [
                        'key' => 'verification_code',
                        'value' => $code
                    ]
                ]
            ]);

            $unverified_user = $unverified_user[0] ?? false;

            if( $unverified_user ) :

                $email = get_field('email', $unverified_user->ID);
                $firstname = get_field('firstname', $unverified_user->ID);
                $lastname = get_field('lastname', $unverified_user->ID);

                $encrypted_pass = get_post_meta($unverified_user->ID, 'encrypted_pass', true);
                $password = Page_Registration::decryptString($encrypted_pass, $code);

                $userdata = [
                    'user_pass'  => $password,
                    'user_login' => $email,
                    'user_email' => $email,
                    'first_name' => $firstname,
                    'last_name'  => $lastname
                ];

                $user_id = wp_insert_user( $userdata );

                $promotions = get_post_meta($unverified_user->ID, 'promotions', true);

                if( !empty( $promotions ) ) :

                    update_user_meta($user_id, 'promotions', 1);

                endif;

                update_user_meta( $user_id, 'billing_phone', get_field('phone', $unverified_user->ID) );
                update_user_meta( $user_id, 'billing_email', get_field('email', $unverified_user->ID) );
                update_user_meta( $user_id, 'billing_first_name', get_field('firstname', $unverified_user->ID) );
                update_user_meta( $user_id, 'billing_last_name', get_field('lastname', $unverified_user->ID) );
                update_user_meta( $user_id, 'billing_postcode', get_field('zip', $unverified_user->ID) );
                update_user_meta( $user_id, 'billing_city', get_field('city', $unverified_user->ID) );
                update_user_meta( $user_id, 'shipping_address_2', get_field('apart', $unverified_user->ID) );
                update_user_meta( $user_id, 'shipping_address_1', get_field('street', $unverified_user->ID) );
                update_user_meta( $user_id, 'shipping_country', 'US' );
                update_field( 'gatecode', get_field('gatecode', $unverified_user->ID), 'user_' . $user_id );


                $login_data = array();
                $login_data['user_login'] = $email;
                $login_data['user_password'] = $password;
                $login_data['remember'] = true;

                $login_user = wp_signon( $login_data, true );
                ?>

                <script>
                    window.location.href = "<?php echo wc_get_page_permalink('myaccount'); ?>"
                </script>

                <?php

            endif;


        endif;

    }

    public static function registerPostType() {


        register_post_type( 'unverified_user', [
            'label'  => null,
            'labels' => [
                'name'               => 'Unverified users',
                'singular_name'      => 'Unverified user',
                'add_new'            => 'Add Unverified user',
                'add_new_item'       => 'Adding Unverified user',
                'edit_item'          => 'Edit Unverified user',
                'new_item'           => 'New Unverified user',
                'view_item'          => 'View Unverified user',
                'search_items'       => 'Find Unverified user',
                'not_found'          => 'Not found',
                'not_found_in_trash' => 'Not found in trash',
                'parent_item_colon'  => '',
                'menu_name'          => 'Unverified users',
            ],
            'public'              => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => false,
            'show_ui'             => true,
            'show_in_nav_menus'   => false,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'hierarchical'        => false,
            'supports'            => [ 'title' ],
        ] );

    }

}