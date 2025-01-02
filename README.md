# Woo Headless Helper

![License](https://img.shields.io/badge/license-GPL--2.0%2B-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-5.6%2B-blue.svg)
![WordPress Version](https://img.shields.io/badge/WordPress-4.7%2B-blue.svg)

A WordPress plugin that extends WooCommerce REST API functionality for headless implementations, enabling customers to access their orders, account data, create orders, and manage their accounts using JWT authentication.

## Description

This plugin allows customers to access their own orders and customer data, create orders, create customer account and reset password using the WooCommerce REST API. This plugin uses JWT tokens which are obtained from the [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/) plugin.

## Features

- **JWT Authentication** integration for secure API access
- **Custom REST API endpoints** for:
  - Customer account details
  - Order listing and individual order details
  - Order creation
  - Customer registration
  - Password reset functionality
- **Secure endpoints** with proper authentication checks
- Built specifically for **headless WooCommerce** implementations

## Requirements

- WordPress 4.7 or higher
- PHP 5.6 or higher
- WooCommerce 6.0 or higher
- [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/) plugin

## Installation

1. Download the plugin files and upload them to your `/wp-content/plugins/customer-headless-helper` directory
2. Activate the plugin through the 'Plugins' menu in WordPress admin dashboard
3. Download and activate the [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/)
4. Configure your JWT secret key in WordPress configuration

## API Endpoints

All endpoints are prefixed with `wc/v3/`. Authentication via JWT token is required for all endpoints.

### Orders Endpoint
```
GET /wp-json/wc/v3/orders/mine
```
Returns an array of objects, each representing an order placed by the customer.

### Create Orders Endpoint
```
POST /wp-json/wc/v3/orders/create
```
Create a new order. Pass order details with JWT token in the request body.

### Customer Endpoint
```
GET /wp-json/wc/v3/customer/mine
```
Returns customer data including billing and shipping addresses.

### Customer Registration Endpoint
```
POST /wp-json/wc/v3/customers/register
```
Register a new customer. Required fields in body:
- email
- password
- JWT token

### Customer Reset Password Endpoint
```
POST /wp-json/wc/v3/customers/reset-password
```
Initiate password reset. Required fields in body:
- email
- JWT token

## Usage

To use the plugin endpoints, you must include a JWT token in the Authorization header of your request. The token must be signed with your configured secret key.

Example request:
```bash
curl -X GET \
  'https://your-site.com/wp-json/wc/v3/orders/mine' \
  -H 'Authorization: Bearer your-jwt-token'
```

## FAQ

### What does this plugin do?
This plugin allows customers to get their order data, account details, create orders, create accounts, and reset passwords via REST API endpoints.

### Is this plugin customizable?
No.

### Is JWT Authentication required?
Yes, JWT Authentication is required for secure API access. Make sure to have it properly configured.

### Does this plugin work with any headless frontend?
Yes, this plugin is framework-agnostic and can work with any frontend implementation that can make HTTP requests.

## Support

If you have any issues with the plugin, please contact us for support at [wpexpertdeep.com](https://wpexpertdeep.com).

## Credits

- Plugin Author: Deep P. Goyal
- Plugin URI: [wpexpertdeep.com](https://wpexpertdeep.com)
- Author URI: [wpexpertdeep.com](https://wpexpertdeep.com)

## License

This project is licensed under the GPL v2 or later.

## Changelog

### 1.0.0
- Initial release