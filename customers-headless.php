<?php
/*
* Plugin Name: Woo Headless Helper
* Plugin URI: https://wpexpertdeep.com
* Description: A Custom plugin for headless WooCommerce setups, enabling customers to get orders, account detail, create orders, reset passwords, and registration via the REST API.
* Version: 1.0.0
* Author: Deep P. Goyal
* Author URI: https://wpexpertdeep.com
* License: GPL2
*/

require_once plugin_dir_path( __FILE__ ) . 'customer-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'customer-rest-endpoints.php';

add_action( 'rest_api_init', 'whh_orders_endpoint' );
add_action( 'rest_api_init', 'whh_order_endpoint' );
add_action( 'rest_api_init', 'whh_customer_endpoint' );
add_action( 'rest_api_init', 'whh_create_order_endpoint' );
add_action('rest_api_init', 'whh_register_customer_endpoint');
add_action('rest_api_init', 'whh_reset_password_endpoint');
add_filter( 'jwt_auth_validate_token', 'whh_customer_authentication', 10, 3 );

