<?php

class Page_Contact
{

    public static function init_auto()
    {
        add_action('acf/init', [__CLASS__, 'acf_add_local_field_group']);
        add_action('init', [__CLASS__, 'pll_strings']);

        add_action('wp_ajax_contact_form', [__CLASS__, 'contactFormHandler']);
        add_action('wp_ajax_nopriv_contact_form', [__CLASS__, 'contactFormHandler']);
    }

    public static function contactFormHandler(): void
    {

        $token = $_POST['token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => '6Lf1YwcqAAAAAK6MFXaFEfhDl6QWHisU2PtZ0Bck', 'response' => $token)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);


        if ($arrResponse['success'] == '1' && $arrResponse['score'] >= 0.6) {
            // if recaptcha success

            $firstname = $_POST['firstname'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $post_id = wp_insert_post([
                'post_type' => 'application',
                'post_status' => 'publish',
                'post_title' => 'New application from : ' . date('d/m/Y')
            ]);

            update_field('first_name', $firstname, $post_id);
            update_field('email', $email, $post_id);
            update_field('message', $message, $post_id);

            $mails = get_field('mails', 'option');

            if (!empty($mails)) :

                $mailsToSend = [];

                foreach ($mails as $item) :

                    $mailsToSend[] = $item['mail'];

                endforeach;

                $message = "
                First name :  " . $firstname . "<br>                                 
                Email :  " . $email . "<br>                                 
                Message :  " . $message . "<br>                                 
            ";

                remove_all_filters('wp_mail_from');
                remove_all_filters('wp_mail_from_name');

                $headers = array(
                    'From: BringMyWater <wordpress@bringmywater.sheep.fish>',
                    'Content-type: text/html;',
                );

                mail(implode(', ', $mailsToSend), 'New application from Contact Form', $message, implode("\r\n", $headers));

            endif;

            wp_send_json_success();
        } else {
            wp_send_json_error('recaptcha_error '.$arrResponse['score']);
        }





    }

    public static function pll_strings(): void
    {

        pll_register_string('contact-1', 'First Name', 'Contact page');
        pll_register_string('contact-2', 'Email', 'Contact page');
        pll_register_string('contact-3', 'Message', 'Contact page');
        pll_register_string('contact-4', 'Send Message', 'Contact page');
        pll_register_string('contact-5', 'Send Other Message', 'Contact page');

    }

    public static function get_url()
    {
        $page = get_pages([
            'meta_key' => '_wp_page_template',
            'meta_value' => 'contact-page.php',
        ]);

        return ($page && 'publish' === $page[0]->post_status) ? get_the_permalink($page[0]->ID) : false;
    }

    public static function get_ID()
    {
        $page = get_pages([
            'meta_key' => '_wp_page_template',
            'meta_value' => 'contact-page.php',
        ]);

        return ($page && 'publish' === $page[0]->post_status) ? $page[0]->ID : false;
    }

    public static function acf_add_local_field_group()
    {

        if (function_exists('acf_add_local_field_group')):


        endif;

    }


}