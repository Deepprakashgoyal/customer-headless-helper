<?php
/*
* Plugin Name: Customer Headless Helper
* Plugin URI: https://wpexpertdeep.com
* Description: A Custom plugin for headless WooCommerce setups, enabling customers to get orders, account detail, create orders, reset passwords, and registration via the REST API.
* Version: 1.0.0
* Author: Deep P. Goyal
* Author URI: https://wpexpertdeep.com
* License: GPL2
* Text Domain: customer-headless-helper
*/

require_once plugin_dir_path( __FILE__ ) . 'customer-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'customer-rest-endpoints.php';

add_action( 'rest_api_init', 'chh_orders_endpoint' );
add_action( 'rest_api_init', 'chh_order_endpoint' );
add_action( 'rest_api_init', 'chh_customer_endpoint' );
add_action( 'rest_api_init', 'chh_create_order_endpoint' );
add_action('rest_api_init', 'chh_register_customer_endpoint');
add_action('rest_api_init', 'chh_reset_password_endpoint');
add_filter( 'jwt_auth_validate_token', 'chh_customer_authentication', 10, 3 );

