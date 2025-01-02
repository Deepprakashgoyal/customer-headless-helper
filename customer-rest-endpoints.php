<?php

function whh_customer_endpoint() {
    register_rest_route( 'wc/v3', '/customer/mine', array(
        'methods' => 'GET',
        'callback' => 'whh_customer_callback',
    ) );
}

function whh_orders_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine', array(
        'methods' => 'GET',
        'callback' => 'whh_orders_callback',
    ) );
}

function whh_order_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'whh_order_callback',
    ) );
}

function whh_create_order_endpoint() {
    register_rest_route( 'wc/v3', '/orders/create', array(
        'methods' => 'POST',
        'callback' => 'whh_create_order_callback',
    ) );
}

function whh_register_customer_endpoint() {
    register_rest_route('wc/v3', '/customers/register', [
        'methods' => 'POST',
        'callback' => 'whh_register_customer_callback',
        'permission_callback' => '__return_true',
    ]);
}

function whh_reset_password_endpoint() {
    register_rest_route('wc/v3', '/customers/reset-password', [
        'methods' => 'POST',
        'callback' => 'whh_reset_password_callback',
        'permission_callback' => '__return_true',
    ]);
}
