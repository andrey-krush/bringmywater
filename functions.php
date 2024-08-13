<?php

define( 'TEMPLATE_PATH', get_template_directory_uri() );

add_action('init', function () {
    add_theme_support('post-thumbnails');
});

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

add_action('wp_enqueue_scripts', function () {

    global $this_page_scripts;
    global $this_page_styles;

    if (!empty($this_page_scripts)) {

        foreach ($this_page_scripts as $handle => $src) {

            if ($src) {
                wp_enqueue_script($handle, $src, array('jquery'), null, true);
            } else {
                wp_enqueue_script($handle);
            }

        }

    }

    if (!empty($this_page_styles)) {
        foreach ($this_page_styles as $handle => $src) {
            wp_enqueue_style($handle, $src, array(), '', 'all');
        }
    }

});


require_once __DIR__ . '/includes/theme/sheepfish_autoloader.php';
Sheepfish_Theme_AutoLoader::init_auto();

add_filter('gutenberg_use_widgets_block_editor', '__return_false', 100);
add_filter('use_widgets_block_editor', '__return_false');


add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );

function custom_remove_woo_checkout_fields( $fields ) {
    
    // billing fields
//    unset($fields['billing']['billing_first_name']);
//    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
//    unset($fields['billing']['billing_phone']);
//    unset($fields['billing']['billing_email']);
    
    // shipping fields
    unset($fields['shipping']['shipping_first_name']);
    unset($fields['shipping']['shipping_last_name']);
    unset($fields['shipping']['shipping_company']);
//    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
//    unset($fields['shipping']['shipping_city']);
//    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_state']);
    
    // modify fields
    $fields['billing']['billing_phone']['priority'] = 999;
    $fields['billing']['billing_phone']['notice'] = 'Phone must be provided since it’s used only for deliverable purposes.';
    
    $fields['shipping']['shipping_postcode']['priority'] = 10;
    $fields['shipping']['shipping_city']['priority'] = 20;
    $fields['shipping']['shipping_address_1']['priority'] = 21;
    $fields['shipping']['apartment'] = [
        "label" => pll__("Apart/Unit Number"),
        "required" => false,
        "class" => ["apartment-field"],
        "validate" => ["apartment"],
        "autocomplete" => "apartment",
        "priority" => 30,
    ];
    $fields['shipping']['gate_code'] = [
        "label" => pll__("Gate Code"),
        "required" => false,
        "class" => [],
        "validate" => ["gate_code"],
        "autocomplete" => "gate_code",
        "priority" => 30,
    ];

    return $fields;
}

function woocommerce_form_field( $key, $args, $value = null ) {
    $defaults = array(
        'type'              => 'text',
        'label'             => '',
        'description'       => '',
        'placeholder'       => '',
        'maxlength'         => false,
        'required'          => false,
        'autocomplete'      => false,
        'id'                => $key,
        'class'             => array(),
        'label_class'       => array(),
        'input_class'       => array(),
        'return'            => false,
        'options'           => array(),
        'custom_attributes' => array(),
        'validate'          => array(),
        'default'           => '',
        'autofocus'         => '',
        'priority'          => '',
    );
    
    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );
    
    if ( is_string( $args['class'] ) ) {
        $args['class'] = array( $args['class'] );
    }
    
    if ( $args['required'] ) {
        $args['class'][] = 'validate-required';
        $required = '';
    } else {
        $required = ' (' . esc_html__( 'optional', 'woocommerce' ) . ')';
    }
    
    if ( is_string( $args['label_class'] ) ) {
        $args['label_class'] = array( $args['label_class'] );
    }
    
    if ( is_null( $value ) ) {
        $value = $args['default'];
    }
    
    // Custom attribute handling.
    $custom_attributes         = array();
    $args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );
    
    if ( $args['maxlength'] ) {
        $args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
    }
    
    if ( ! empty( $args['autocomplete'] ) ) {
        $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
    }
    
    if ( true === $args['autofocus'] ) {
        $args['custom_attributes']['autofocus'] = 'autofocus';
    }
    
    if ( $args['description'] ) {
        $args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
    }
    
    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
        }
    }
    
    if ( ! empty( $args['validate'] ) ) {
        foreach ( $args['validate'] as $validate ) {
            $args['class'][] = 'validate-' . $validate;
        }
    }
    
    $field           = '';
    $label_id        = $args['id'];
    $sort            = '';
    $field_container = '<div class="input %1$s" id="%2$s">%3$s</div>';
    
    if ( $args['label'] && 'checkbox' !== $args['type'] ) {
        $args['placeholder'] = wp_kses_post( $args['label'] ) . $required;
    }
    
    switch ( $args['type'] ) {
        case 'country':
            $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();
            
            if ( 1 === count( $countries ) ) {
                
                $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';
                
                $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';
                
            } else {
                $data_label = ! empty( $args['label'] ) ? 'data-label="' . esc_attr( $args['label'] ) . '"' : '';
                
                $field = '<select '.($args['required'] ? 'required' : '').' name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_attr__( 'Select a country / region&hellip;', 'woocommerce' ) ) . '" ' . $data_label . '><option value="">' . esc_html__( 'Select a country / region&hellip;', 'woocommerce' ) . '</option>';
                
                foreach ( $countries as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
                }
                
                $field .= '</select>';
                
                $field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country / region', 'woocommerce' ) . '">' . esc_html__( 'Update country / region', 'woocommerce' ) . '</button></noscript>';
                
                $args['class'][] = 'input--select';
            }
            
            break;
        case 'state':
            /* Get country this state field is representing */
            $for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
            $states      = WC()->countries->get_states( $for_country );
            
            if ( is_array( $states ) && empty( $states ) ) {
                
                $field_container = '<div class="input %1$s" id="%2$s" style="display: none">%3$s</div>';
                
                $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';
                
            } elseif ( ! is_null( $for_country ) && is_array( $states ) ) {
                $data_label = ! empty( $args['label'] ) ? 'data-label="' . esc_attr( $args['label'] ) . '"' : '';
                
                $field .= '<select '.($args['required'] ? 'required' : '').' name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_html__( 'Select an option&hellip;', 'woocommerce' ) ) . '"  data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . $data_label . '>
                    <option value="">' . esc_html__( 'Select an option&hellip;', 'woocommerce' ) . '</option>';
                
                foreach ( $states as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
                }
                
                $field .= '</select>';
    
                $args['class'][] = 'input--select';
            } else {
                
                $field .= '<input '.($args['required'] ? 'required' : '').' type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';
                
            }
//            $field = implode(' ', $args['class']);
            break;
        case 'textarea':
            $field .= '<textarea '.($args['required'] ? 'required' : '').' name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';
            
            break;
        case 'checkbox':
            $field_container = '<label class="input input--checkbox %1$s ' . implode( ' ', $args['label_class'] ) . '" id="%2$s">%3$s</label>';
            $field = '<input '.($args['required'] ? 'required' : '').' type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /><span>' . $args['label'] . $required . '</span>';
            break;
        case 'text':
        case 'password':
        case 'datetime':
        case 'datetime-local':
        case 'date':
        case 'month':
        case 'time':
        case 'week':
        case 'number':
        case 'email':
        case 'url':
        case 'tel':
            $field .= '<input '.($args['required'] ? 'required' : '').' type="' . esc_attr( $args['type'] ) . '" data-validation="' . esc_attr( $args['type'] === 'email' ? 'email_username' : $args['type']) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
            
            break;
        case 'hidden':
            $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-hidden ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
            
            break;
        case 'select':
            $field   = '';
            $options = '';
            
            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    if ( '' === $option_key ) {
                        // If we have a blank option, select2 needs a placeholder.
                        if ( empty( $args['placeholder'] ) ) {
                            $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
                        }
                        $custom_attributes[] = 'data-allow_clear="true"';
                    }
                    $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_html( $option_text ) . '</option>';
                }
                
                $field .= '<select '.($args['required'] ? 'required' : '').' name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
                        ' . $options . '
                    </select>';
    
                $args['class'][] = 'input--select';
            }
            
            break;
        case 'radio':
            
            if ( ! empty( $args['options'] ) ) {
                $field_container = '%3$s';
                foreach ( $args['options'] as $option_key => $option_text ) {
                    $field = '<label class="input input--checkbox input--radio %1$s ' . implode( ' ', $args['label_class'] ) . '" id="%2$s">';
                    $field .= '<input '.($args['required'] ? 'required' : '').' type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
                    $field .= '<span>' . esc_html( $option_text ) . '</span>';
                    $field .= '</label>';
                }
            }
            
            break;
    }
    
    $banned_classes = ['form-row', 'form-row-first', 'form-row-last', 'form-row-wide'];
    
    foreach ($banned_classes as $banned_class) {
        $item_index = array_search($banned_class, $args['class']);
        
        if ($item_index !== false) {
            unset($args['class'][$item_index]);
        }
    }
    
    if ( ! empty( $field ) ) {
        $field_html = $field;
        $container_class = esc_attr( implode( ' ', $args['class'] ) );
        $container_id    = esc_attr( $args['id'] ) . '_field';
        $field           = sprintf( $field_container, $container_class, $container_id, $field_html );
    }
    
    
    if ( $args['return'] ) {
        return $field;
    } else {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $field;
    }
}
function get_woocommerce_fields_html( $fields, $checkout ){
    $index = 0;
    $fields_keys = array_keys($fields);
    $div_is_open = false;
    
    foreach ( $fields as $key => $field ) { ?>

        <?php
        if(!$div_is_open){
            echo '<div class="form__row">';
            $div_is_open = true;
        }
        ?>
        <?php if(isset($field['notice']) && $field['notice']){ ?>
            <div class="input-notice">
                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ?: WC()->session->get( $key ) ); ?>
                <p><?php echo $field['notice']; ?></p>
            </div>
        <?php } else { ?>
            <?php if( is_user_logged_in() ) : ?>
                <?php $user_id = get_current_user_id(); ?>
                <?php if( $key == 'shipping_postcode' ) : ?>
                    <?php $value = get_user_meta($user_id, 'billing_postcode', true) ?? ''; ?>
                <?php elseif( $key == 'shipping_city' ) : ?>
                    <?php $value = get_user_meta($user_id, 'billing_city', true) ?? ''; ?>
                <?php elseif( $key == 'apartment' ) : ?>
                    <?php $value = get_user_meta($user_id, 'shipping_address_2', true) ?? '';; ?>
                <?php elseif( $key == 'gate_code' ) : ?>
                    <?php $value = get_user_meta($user_id, 'gatecode', true) ?? '';; ?>
                <?php else : ?>
                    <?php $value = $checkout->get_value( $key ) ?: WC()->session->get( $key ); ?>
                <?php endif; ?>
            <?php else :
                $value = $checkout->get_value($key) ?: WC()->session->get($key);
            endif; ?>
            <?php woocommerce_form_field( $key, $field, $value ); ?>
        <?php } ?>
        <?php
        $next_priority = isset($fields_keys[$index+1]) ? $fields[$fields_keys[$index+1]] : false;
        
        if($next_priority === false || (str_split((string)$next_priority['priority'])[0] !== str_split((string)$field['priority'])[0] && $div_is_open)){
            echo '</div>';
            $div_is_open = false;
        }
        $index++;
        ?>
    <?php }
}


add_action('woocommerce_checkout_update_order_review', function ($post_data_string){
    parse_str($post_data_string, $post_data);
    WC()->session->set( 'apartment' , isset( $post_data['apartment'] ) ? wc_clean( wp_unslash( $post_data['apartment'] ) ) : null);
    WC()->session->set( 'gate_code' , isset( $post_data['gate_code'] ) ? wc_clean( wp_unslash( $post_data['gate_code'] ) ) : null);
    WC()->session->set( 'delivery_term' , isset( $post_data['delivery_term'] ) ? wc_clean( wp_unslash( $post_data['delivery_term'] ) ) : null);
    WC()->session->set( 'delivery_term_date' , isset( $post_data['delivery_term_date'] ) ? wc_clean( wp_unslash( $post_data['delivery_term_date'] ) ) : null);
    WC()->session->set( 'recurring' , isset( $post_data['recurring'] ) ? wc_clean( wp_unslash( $post_data['recurring'] ) ) : null);
    WC()->session->set( 'recurring_date' , isset( $post_data['recurring_date'] ) ? wc_clean( wp_unslash( $post_data['recurring_date'] ) ) : null);
});


add_filter('default_checkout_billing_country', '__return_null', 10, 1);
add_filter('default_checkout_shipping_country', '__return_null', 10, 1);

add_filter( 'default_checkout_billing_state', '__return_null' );
add_filter( 'default_checkout_shipping_state', '__return_null' );

add_action('template_redirect', 'redirectFromHttpToHttps');

function redirectFromHttpToHttps() {

//    var_dump($_SERVER);
    if( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http' ) :

        wp_redirect('https://bringmywater.com' . $_SERVER['REQUEST_URI'], 301);

    endif;
}