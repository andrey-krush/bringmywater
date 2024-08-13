<?php

class Page_Checkout
{

    public static function init_auto()
    {
        add_action('woocommerce_checkout_order_processed', [__CLASS__, 'sendCoupon']);
        add_action('woocommerce_checkout_order_processed', [__CLASS__, 'addAdditionalData']);
        add_action('woocommerce_checkout_order_processed', [__CLASS__, 'sendShipStationOrder'], 123, 1);
        add_action('init', [__CLASS__, 'registerStrings']);
        add_action('woocommerce_checkout_create_order', [__CLASS__, 'addAdditionalProducts'], 10, 2);
    }

    public static function registerStrings()
    {

        pll_register_string('mail-1', 'Thank you for your order. Your water is on its way to you!', 'Mail', true);
        pll_register_string('mail-2', 'Thank you for your first order. Your water is on its way to you! Here is your promo code for a free package of water: ', 'Mail', true);
        pll_register_string('mail-3', 'Apply this promo code during your next order.', 'Mail', true);

        pll_register_string('checkout-1', 'Gate Code', 'Checkout');
        pll_register_string('checkout-2', 'Apart/Unit Number', 'Checkout');
        pll_register_string('checkout-3', 'Provide details of where the water should be delivered, if necessary.', 'Checkout');
        pll_register_string('checkout-4', 'Every Month', 'Checkout');
        pll_register_string('checkout-5', 'Every Two Weeks', 'Checkout');
        pll_register_string('checkout-6', 'Every Week', 'Checkout');
        pll_register_string('checkout-7', 'One-Time Purchase', 'Checkout');
        pll_register_string('checkout-8', 'Do you want to schedule recurring deliveries or is this a one-time purchase?', 'Checkout');
        pll_register_string('checkout-9', 'When do you want your water delivered?', 'Checkout');
        pll_register_string('checkout-10', 'As Soon As Possible', 'Checkout');
        pll_register_string('checkout-11', 'On A Specific Date', 'Checkout');
        pll_register_string('checkout-12', 'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our', 'Checkout');
        pll_register_string('checkout-13', 'privacy policy', 'Checkout');

        pll_register_string('thankyou-1', 'Back To Main Page', 'Thankyou Page');
        pll_register_string('thankyou-2', 'Thank You for your order!', 'Thankyou Page');
        pll_register_string('thankyou-3', 'Your water bottles you’ve chosen will soon at your door step whenever you want, without lifting a finger.', 'Thankyou Page', true);
        pll_register_string('thankyou-4', 'Your Order', 'Thankyou Page');
        pll_register_string('thankyou-5', 'will be delivered', 'Thankyou Page');
        pll_register_string('thankyou-6', 'soon', 'Thankyou Page');
        pll_register_string('thankyou-7', 'Your water will soon be at your door, your back can thank us later', 'Thankyou Page');
        pll_register_string('thankyou-8', 'Order', 'Thankyou Page');



    }

    public static function addAdditionalData( $order_id ) {


        if( $_POST['recurring'] == 'one-time' ) :

            update_post_meta($order_id, 'recurring', 'One time');

            if( $_POST['delivery_term'] == 'asap' ) :
                update_post_meta($order_id, 'delivery_date', 'As soon as possible');
            else :
                update_post_meta($order_id, 'delivery_date', $_POST['delivery_term_date']);
            endif;

        else :

            if( $_POST['recurring'] == 'week' ) :
                update_post_meta($order_id, 'recurring_date', $_POST['delivery_day']);
            elseif( $_POST['recurring'] == 'two-weeks' ) :
                update_post_meta($order_id, 'recurring_date', $_POST['first_week'] . ' and ' . $_POST['second_week']);
            else :
                update_post_meta($order_id, 'recurring_date', $_POST['recurring_date']);
            endif;
            $recurring = 'Every ' . str_replace('-', ' ', $_POST['recurring']);
            update_post_meta($order_id, 'recurring', $recurring);


        endif;

    }

    public static function sendShipStationOrder($order_id) {

        $order = wc_get_order($order_id);

        $orderData = $order->get_data();

        $date = $order->get_date_created()->format('Y-m-d G:i:s');

        $shipstationData = [
            'orderNumber' => $order_id,
            'orderDate' => $date,
            'orderStatus' => 'awaiting_shipment',
            'customerUsername' => $orderData['billing']['email'],
            'customerEmail' => $orderData['billing']['email'],
            'billTo' => [
                'name' => $orderData['billing']['first_name'] . ' ' . $orderData['billing']['last_name'],
                'company' => $orderData['billing']['company'],
                'street1' => $orderData['billing']['address_1'],
                'street2' => $orderData['billing']['address_2'],
                'street3' => null,
                'city' => $orderData['billing']['city'],
                'state' => $orderData['billing']['state'],
                'postalCode' => $orderData['billing']['postcode'],
                'country' => $orderData['billing']['country'],
                'phone' => $orderData['billing']['phone'],
            ],
            'shipTo' => [
                'name' => $orderData['billing']['first_name'] . ' ' . $orderData['billing']['last_name'],
                'company' => $orderData['shipping']['company'],
                'street1' => $orderData['shipping']['address_1'],
                'street2' => $_POST['apartment'],
                'street3' => $_POST['gate_code'],
                'city' => $orderData['shipping']['city'],
                'state' => $orderData['shipping']['state'],
                'postalCode' => $orderData['shipping']['postcode'],
                'country' => $orderData['shipping']['country'],
                'phone' => $orderData['billing']['phone'],
            ],
            'customerNotes' => $order->get_customer_note()
        ];

        $order_type = get_post_meta($order_id, 'recurring', true);

        if( $order_type == 'One time' ) :

            $shipstationData['internalNotes'] = 'One time purchase on : ' . get_post_meta($order_id, 'delivery_date', true);

        else :

            $shipstationData['internalNotes'] = $order_type . ' on : ' . get_post_meta($order_id, 'recurring_date', true) . '.';

        endif;

        $order_coupons = $order->get_coupons();

        if( $order_coupons ) :

            $free_water_by_coupon = true;
            $shipstationData['internalNotes'] .= ' One time free water by coupon';

        endif;

        $order_items = $order->get_items();

        if( !empty( $order_items ) ) :

            foreach ( $order_items as $item ) :

                $product_id = $item->get_product_id();
                $product = wc_get_product($product_id);
                $product_date_created = $product->get_date_created()->format('Y-m-d G:i:s');
                $product_date_modified = $product->get_date_modified()->format('Y-m-d G:i:s');

                $shipstationData['items'][] =  [
                    "orderItemId" => $item->get_order_id() . $product_id,
                    "lineItemKey" => null,
                    "sku" => null,
                    "name" => get_the_title($product_id),
                    "imageUrl" => get_the_post_thumbnail_url($product_id),
                    "weight" => null,
                    "quantity" => $free_water_by_coupon ? $item->get_quantity() - 1 : $item->get_quantity(),
                    "unitPrice" => $item->get_total() / $item->get_quantity(),
                    "taxAmount" => 0,
                    "shippingAmount" => 0,
                    "warehouseLocation" => null,
                    "options" => null,
                    "productId" => null,
                    "fulfillmentSku" => null,
                    "adjustment" => false,
                    "upc" => null,
                    "createDate" => $product_date_created,
                    "modifyDate" => $product_date_modified
                ];

            endforeach;

        endif;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ssapi.shipstation.com/orders/createorder",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($shipstationData),
            CURLOPT_HTTPHEADER => array(
                "Host: ssapi.shipstation.com",
                "Authorization: Basic " . base64_encode('1ca9403f6d7e433b8ce244bc62e7dc91:dbd383a565d443d696c7eff8644c67f9'),
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }

    public static function addAdditionalProducts( $order, $data )
    {

        $add_additional_products = get_field('add_additional_products', 'option');

        if ( $add_additional_products ) :
            $items = $order->get_items();

            foreach ( $items as $item_id => $item_data ) :

                $item_quantity = $item_data->get_quantity();
                $need_to_buy = get_field('need_to_buy', 'option');
                $will_get = get_field('will_get', 'option');

                if ($item_quantity >= $need_to_buy) :

                    $additional_quantity = floor($item_quantity / $need_to_buy);
                    $additional_quantity = $additional_quantity * $will_get;
                    $new_quantity = $item_quantity + $additional_quantity;

                    $item_data->set_quantity($new_quantity);

                endif;

            endforeach;

        endif;


    }

    public static function sendCoupon()
    {

        $email = $_POST['billing_email'];

        $mail_coupon = get_posts([
            'post_type' => 'shop_coupon',
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => 'coupon_email',
                    'value' => $email
                ]
            ]
        ]);

        if (empty($mail_coupon)) :

            include_once(WC()->plugin_path() . '/includes/admin/wc-admin-functions.php');
            $coupon_code = uniqid();

            $coupon = new WC_Coupon();
            $coupon->set_code($coupon_code);
            $coupon->set_discount_type('percent');
            $coupon->set_amount(100);

            $product = get_posts([
                'post_type' => 'product',
                'post_status' => 'publish'
            ])[0];

            $coupon->set_product_ids(array($product->ID));
            $coupon->set_usage_limit(1);
            $coupon->set_limit_usage_to_x_items(1);
            $coupon->save();

            update_post_meta($coupon->get_id(), 'coupon_email', $email);

            $headers = array(
                'From: BringMyWater <wordpress@bringmywater.sheep.fish>',
                'content-type: text/html',
            );

            wp_mail($email, 'coupon', $coupon_code, $headers);

            $mails_with_coupon[] = $email;
            update_option('mails_with_coupon', $mails_with_coupon);

        endif;

        $email_orders_count = get_option('count_' . $email);
        if (empty($email_orders_count)) :
            $email_orders_count = 0;
        endif;

        update_option('count_' . $email, $email_orders_count + 1);
    }


}