=== Woo Headless Helper ===
Contributors: deepprakashgoyal
Tags: headless-cms, jwt-woocommerce, jwt-authentication, woocommerce, rest-api
Requires at least: 4.7
Tested up to: 6.7.1
Stable tag: 1.0.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Access WooCommerce customer data, manage orders, and handle customer authentication via REST API with JWT token support.

== Description ==

This plugin allows customers to access their own orders and customer data, create orders, create customer account and reset password using the WooCommerce REST API. This plugin also uses JWT tokens which are often obtained from the [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/) plugin.

= Features =

* JWT Authentication integration for secure API access
* Custom REST API endpoints for:
  * Customer account details
  * Order listing and individual order details
  * Order creation
  * Customer registration
  * Password reset functionality
* Secure endpoints with proper authentication checks
* Built specifically for headless WooCommerce implementations

= API Endpoints =

All endpoints are prefixed with `wc/v3/`:

* `GET /customer/mine` - Get current customer details
* `GET /orders/mine` - List all orders for current customer
* `GET /orders/mine/{id}` - Get specific order details
* `POST /orders/create` - Create a new order
* `POST /customers/register` - Register a new customer
* `POST /customers/reset-password` - Initiate password reset

= Usage =

To use the plugin, you must send a JWT token in the Authorization header of your request. The token must be signed with the secret key that you have configured in the plugin settings.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/woo-headless-helper` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Download and activate the [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/)
4. Configure your JWT secret key in WordPress configuration

== Frequently Asked Questions ==

= What does this plugin do? =

This plugin allow customer to get their order data, their account details, create orders, create account, and send reset password link.

= Is this plugin customizable? =

No.

= Is JWT Authentication required? =

Yes, JWT Authentication is required for secure API access. Make sure to have it properly configured.

= Does this plugin work with any headless frontend? =

Yes, this plugin is framework-agnostic and can work with any frontend implementation that can make HTTP requests.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif).

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of Woo Headless Helper.

== Credits ==

Plugin Author: Deep P. Goyal
Plugin URI: https://wpexpertdeep.com
Author URI: https://wpexpertdeep.com