<?php

function whh_orders_callback( $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the orders for the current user
    $orders = wc_get_orders( array( 'customer_id' => $user_id ) );

    if ( empty( $orders ) ) {
        $orders = array();
    }

    // Initialize the response array
    $response = array();

    // Loop through the orders and add the order data to the response array
    foreach ( $orders as $order ) {
        $response[] = array(
            'order_id' => $order->get_id(),
            'order_total' => $order->get_total(),
            'line_items' => $order->get_items(),
            'order_date' => $order->get_date_created(),
        );
    }

    // Return the response array
    return $response;
}

function whh_order_callback( $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the order ID from the request
    $order_id = $request['id'];

    // Get the order
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return new WP_Error( 'invalid_order', 'Invalid order', array( 'status' => 404 ) );
    }

    // Make sure the order belongs to the current user
    if ( $order->get_customer_id() !== $user_id ) {
        return new WP_Error( 'unauthorized_order', 'Unauthorized order', array( 'status' => 401 ) );
    }

    $response = array(
        'order_id' => $order->get_id(),
        'order_total' => $order->get_total(),
        'line_items' => $order->get_items(),
        'order_date' => $order->get_date_created(),
    );
    
    return $response;
    
}

function whh_customer_callback( $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the customer data for the current user
    $customer = new WC_Customer( $user_id );

    // Return the customer data in the response
    return array(
        'customer_id' => $customer->get_id(),
        'first_name' => $customer->get_first_name(),
        'last_name' => $customer->get_last_name(),
        'email' => $customer->get_email(),
        'billing_address' => array(
            'first_name' => $customer->get_billing_first_name(),
            'last_name' => $customer->get_billing_last_name(),
            'company' => $customer->get_billing_company(),
            'address_1' => $customer->get_billing_address_1(),
            'address_2' => $customer->get_billing_address_2(),
            'city' => $customer->get_billing_city(),
            'state' => $customer->get_billing_state(),
            'postcode' => $customer->get_billing_postcode(),
            'country' => $customer->get_billing_country(),
            'email' => $customer->get_billing_email(),
            'phone' => $customer->get_billing_phone(),
        ),
        'shipping_address' => array(
            'first_name' => $customer->get_shipping_first_name(),
            'last_name' => $customer->get_shipping_last_name(),
            'company' => $customer->get_shipping_company(),
            'address_1' => $customer->get_shipping_address_1(),
            'address_2' => $customer->get_shipping_address_2(),
            'city' => $customer->get_shipping_city(),
            'state' => $customer->get_shipping_state(),
            'postcode' => $customer->get_shipping_postcode(),
            'country' => $customer->get_shipping_country(),
        ),
    );
}

function whh_customer_authentication( $user, $token, $auth_data ) {
    // Validate the JWT token
    try {
        // Decode the token and get the user data
        $decoded_token = JWT::decode( $token, SECRET_KEY, array( 'HS256' ) );
        $user_id = $decoded_token->data->user->id;
    } catch ( Exception $e ) {
        // Return an error if the token is not valid
        return new WP_Error( 'rest_invalid_token', __( 'Invalid JWT token.' ), array( 'status' => 401 ) );
    }

    // Check if the user exists
    $user = get_user_by( 'id', $user_id );
    if ( ! $user ) {
        return new WP_Error( 'rest_user_invalid', __( 'Invalid user.' ), array( 'status' => 401 ) );
    }

    // Return the user object
    return $user;
}

// create order endpoint
function whh_create_order_callback( $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the order data from the request
    $order_data = $request->get_json_params();

    if( ! isset( $order_data['line_items'] ) || empty( $order_data['line_items'] ) ) {
        return new WP_Error( 'rest_invalid_order', __( 'Invalid order data.' ), array( 'status' => 400 ) );
    }

    // Create a new order
    $order = wc_create_order();
    
    // Set billing address
    if (isset($order_data['billing'])) {
        $order->set_billing_first_name($order_data['billing']['first_name']);
        $order->set_billing_last_name($order_data['billing']['last_name']);
        $order->set_billing_address_1($order_data['billing']['address_1']);
        $order->set_billing_address_2($order_data['billing']['address_2']);
        $order->set_billing_city($order_data['billing']['city']);
        $order->set_billing_state($order_data['billing']['state']);
        $order->set_billing_postcode($order_data['billing']['postcode']);
        $order->set_billing_country($order_data['billing']['country']);
        $order->set_billing_email($order_data['billing']['email']);
        $order->set_billing_phone($order_data['billing']['phone']);
    }

    // Set shipping address
    if (isset($order_data['shipping'])) {
        $order->set_shipping_first_name($order_data['shipping']['first_name']);
        $order->set_shipping_last_name($order_data['shipping']['last_name']);
        $order->set_shipping_address_1($order_data['shipping']['address_1']);
        $order->set_shipping_address_2($order_data['shipping']['address_2']);
        $order->set_shipping_city($order_data['shipping']['city']);
        $order->set_shipping_state($order_data['shipping']['state']);
        $order->set_shipping_postcode($order_data['shipping']['postcode']);
        $order->set_shipping_country($order_data['shipping']['country']);
    }

    // Add products to the order
    foreach ( $order_data['line_items'] as $item ) {
        $product = wc_get_product( $item['product_id'] );
        if ( $product ) {
            $order->add_product( $product, $item['quantity'] );
        }
    }
    
    // Add shipping lines
    if (isset($order_data['shipping_lines']) && !empty($order_data['shipping_lines'])) {
        foreach ($order_data['shipping_lines'] as $shipping_line) {
            $item = new WC_Order_Item_Shipping();
            $item->set_method_title($shipping_line['method_title']);
            $item->set_method_id($shipping_line['method_id']);
            $item->set_total($shipping_line['total']);
            $order->add_item($item);
        }
    }
    
    // Set payment method
    if (isset($order_data['payment_method'])) {
        $order->set_payment_method($order_data['payment_method']);
        $order->set_payment_method_title($order_data['payment_method_title']);
    }

    // Set customer ID
    $order->set_customer_id( $user_id );

    // Calculate totals
    $order->calculate_totals();
    
    // Set order status to pending
    $order->set_status('pending');

    // Save the order
    $order->save();

    // Return the order data in the response
    return array(
        'order_id' => $order->get_id(),
        'order_total' => $order->get_total(),
        'line_items' => $order->get_items(),
        'order_date' => $order->get_date_created(),
        'shipping_lines' => $order->get_shipping_methods(),
        'billing_address' => $order->get_address('billing'),
        'shipping_address' => $order->get_address('shipping'),
        'payment_method' => $order->get_payment_method(),
        'payment_method_title' => $order->get_payment_method_title(),
        'status' => $order->get_status()
    );
}

// register customer endpoint
function whh_register_customer_callback($request) {
    $params = $request->get_json_params();

    if (!isset($params['email']) || !isset($params['password'])) {
        return new WP_Error('missing_fields', 'Email and password are required.', ['status' => 400]);
    }

    $email = sanitize_email($params['email']);
    $password = sanitize_text_field($params['password']);
    $username = isset($params['username']) ? sanitize_user($params['username']) : $email;

    if (email_exists($email)) {
        return new WP_Error('email_exists', 'Email is already registered.', ['status' => 400]);
    }

    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        return $user_id;
    }

    // Set user role to customer
    $user = new WP_User($user_id);
    $user->set_role('customer');

    return [
        'success' => true,
        'user_id' => $user_id,
        'message' => 'Customer registered successfully.'
    ];
}

// reset password
function whh_reset_password_callback($request) {
    $params = $request->get_json_params();

    if (!isset($params['email'])) {
        return new WP_Error('missing_email', 'Email is required.', ['status' => 400]);
    }

    $email = sanitize_email($params['email']);
    $user = get_user_by('email', $email);

    if (!$user) {
        return new WP_Error('invalid_email', 'No user found with this email.', ['status' => 404]);
    }

    // Generate a reset password link
    $reset_key = get_password_reset_key($user);

    if (is_wp_error($reset_key)) {
        return $reset_key;
    }

    $reset_link = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login));

    // Send reset email
    $subject = 'Password Reset Request';
    $message = "Hi {$user->display_name},\n\n";
    $message .= "Click the link below to reset your password:\n";
    $message .= "$reset_link\n\n";
    $message .= "If you did not request a password reset, please ignore this email.\n";

    $mail_sent = wp_mail($email, $subject, $message);

    if (!$mail_sent) {
        return new WP_Error('email_failed', 'Failed to send the reset email.', ['status' => 500]);
    }

    return [
        'success' => true,
        'message' => 'Password reset email sent successfully.',
    ];
}
