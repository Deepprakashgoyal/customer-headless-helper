<?php

function chh_customer_endpoint() {
    register_rest_route( 'wc/v3', '/customer/mine', array(
        'methods' => 'GET',
        'callback' => 'chh_customer_callback',
    ) );
}

function chh_orders_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine', array(
        'methods' => 'GET',
        'callback' => 'chh_orders_callback',
    ) );
}

function chh_order_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'chh_order_callback',
    ) );
}

function chh_create_order_endpoint() {
    register_rest_route( 'wc/v3', '/orders/create', array(
        'methods' => 'POST',
        'callback' => 'chh_create_order_callback',
    ) );
}

function chh_register_customer_endpoint() {
    register_rest_route('wc/v3', '/customers/register', [
        'methods' => 'POST',
        'callback' => 'chh_register_customer_callback',
        'permission_callback' => '__return_true',
    ]);
}

function chh_reset_password_endpoint() {
    register_rest_route('wc/v3', '/customers/reset-password', [
        'methods' => 'POST',
        'callback' => 'chh_reset_password_callback',
        'permission_callback' => '__return_true',
    ]);
}
