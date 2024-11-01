<?php
/**
 * Plugin Name: WPayo - WordPress Payment Gateways
 * Description: Accept payments directly on WordPress e-commerce websites.Seamless WordPress integration for major payment Gateways such as Authorize.Net and Instamojo with popular plugins like WooCommerce, Easy Digital Downloads, and Ninja Forms.
 * Version: 1.0.0
 * Author URI:  https://wpayo.com
 * Plugin URI:  https://wpayo.com
 * Requires at least: 5.9
 * Requires PHP: 7.4
 * Author: WPayo Payment Gateways
 * Text Domain: wpayo
 * Domain Path: /languages
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! defined( 'PRONAMIC_PAY_DEBUG' ) ) {
	define( 'PRONAMIC_PAY_DEBUG', false );
}
define( 'WPAYO_DIR', plugin_dir_path( __FILE__ ) );

if (PHP_MAJOR_VERSION >= 7) {
	set_error_handler(function ($errno, $errstr) {
	   return strpos($errstr, 'Declaration of') === 0;
	}, E_WARNING);
}	

/**
 * Autoload.
 */
require_once __DIR__ . '/vendor/autoload_packages.php';

require WPAYO_DIR . 'include.php';

//before v1.1
//require_once WPAYO_DIR . '/wpayo-admin/options.php';
/**
 * Bootstrap.
 */
\Pronamic\WordPress\Pay\Plugin::instance(
	[
		'file'                 => __FILE__,
		'action_scheduler'     => __DIR__ . '/packages/woocommerce/action-scheduler/action-scheduler.php',
		'pronamic_service_url' => 'https://api.wp-pay.org/wp-json/pronamic-pay/v1/payments',
	]
);

//\Pronamic\WordPress\Pay\LicenseManager::instance();

\Pronamic\WordPress\Pay\Updater::instance(
	function ( $plugin ) {
		return \in_array(
			$plugin['Name'],
			[
				'Pronamic Pay Adyen Add-On',
				'Pronamic Pay Contact Form 7 Add-On',
				'Pronamic Pay DigiWallet Add-On',
				'Pronamic Pay Fundraising Add-On',
				'Pronamic Pay PayPal Add-On',
				'Pronamic Pay Payvision Add-On',
			],
			true
		);
	}
);

add_filter(
	'pronamic_pay_modules',
	function( $modules ) {
		// $modules[] = 'forms';
		$modules[] = 'reports';
		$modules[] = 'subscriptions';

		return $modules;
	}
);

add_filter(
	'pronamic_pay_removed_extension_notifications',
	function( $notifications ) {
		$notifications[] = new \Pronamic\WordPress\Pay\Admin\AdminNotification(
			'removed-extension-active-event-espresso-legacy',
			\__( 'Event Espresso 3', 'wpayo' ),
			\defined( '\EVENT_ESPRESSO_VERSION' ) && \version_compare( \EVENT_ESPRESSO_VERSION, '4.0.0', '<' ),
			'8'
		);

		$notifications[] = new \Pronamic\WordPress\Pay\Admin\AdminNotification(
			'removed-extension-active-s2member',
			\__( 's2Member', 'wpayo' ),
			\defined( '\WS_PLUGIN__S2MEMBER_VERSION' ),
			'8'
		);

		$notifications[] = new \Pronamic\WordPress\Pay\Admin\AdminNotification(
			'removed-extension-active-wp-e-commerce',
			\__( 'WP eCommerce', 'wpayo' ),
			\class_exists( '\WP_eCommerce' ),
			'8'
		);

		return $notifications;
	}
);

add_filter(
	'pronamic_pay_plugin_integrations',
	function( $integrations ) {
		$classes = [
			\Pronamic\WordPress\Pay\Extensions\EasyDigitalDownloads\Extension::class,
			\Pronamic\WordPress\Pay\Extensions\WooCommerce\Extension::class,
			\Pronamic\WordPress\Pay\Extensions\NinjaForms\Extension::class,
			\Wpayo\Extensions\WpayoPaymentLink\Extension::class,
		];

		foreach ( $classes as $class ) {
			if ( ! array_key_exists( $class, $integrations ) ) {
				$integrations[ $class ] = new $class();
			}
		}

		return $integrations;
	}
);

add_filter(
	'get_post_metadata',
	function( $value, $post_id, $meta_key, $single ) {
		static $filter = true;

		if ( false === $filter ) {
			return $value;
		}

		if ( '_wpayo_gateway_id' !== $meta_key ) {
			return $value;
		}

		$filter = false;

		$value = get_post_meta( $post_id, $meta_key, $single );

		$filter = true;

		$mode = get_post_meta( $post_id, '_wpayo_gateway_mode', true );

		switch ( $value ) {
			case 'abnamro-ideal-zelfbouw-v3':
				return ( 'test' === $mode ) ? 'abnamro-ideal-zelfbouw-test' : 'abnamro-ideal-zelfbouw';
			case 'adyen':
				return ( 'test' === $mode ) ? 'adyen-test' : 'adyen';
			case 'buckaroo':
				return ( 'test' === $mode ) ? 'buckaroo-test' : 'buckaroo';
			case 'deutschebank-ideal-expert-v3':
				return ( 'test' === $mode ) ? 'deutschebank-ideal-expert-test' : 'deutschebank-ideal-expert';
			case 'ems-ecommerce':
				return ( 'test' === $mode ) ? 'ems-ecommerce-test' : 'ems-ecommerce';
			case 'ing-ideal-advanced-v3':
				return ( 'test' === $mode ) ? 'ing-ideal-advanced-test' : 'ing-ideal-advanced';
			case 'ing-ideal-advanced-2022':
				return ( 'test' === $mode ) ? 'ing-ideal-advanced-2022-sandbox' : 'ing-ideal-advanced-2022-production';
			case 'ing-ideal-basic':
				return ( 'test' === $mode ) ? 'ing-ideal-basic-test' : 'ing-ideal-basic';
			case 'multisafepay-connect':
				return ( 'test' === $mode ) ? 'multisafepay-connect-test' : 'multisafepay-connect';
			case 'ogone-directlink':
				return ( 'test' === $mode ) ? 'ingenico-directlink-test' : 'ingenico-directlink';
			case 'ogone-orderstandard':
				return ( 'test' === $mode ) ? 'ingenico-orderstandard-test' : 'ingenico-orderstandard';
			case 'paypal':
				return ( 'test' === $mode ) ? 'paypal-sandbox' : 'paypal';
			case 'payvision':
				return ( 'test' === $mode ) ? 'payvision-staging' : 'payvision';
			case 'rabobank-ideal-professional-v3':
				return ( 'test' === $mode ) ? 'rabobank-ideal-professional-test' : 'rabobank-ideal-professional';
			case 'rabobank-omnikassa-2':
				return ( 'test' === $mode ) ? 'rabobank-omnikassa-2-sandbox' : 'rabobank-omnikassa-2';
			case 'sisow-ideal':
				$sisow_test_mode = get_post_meta( $post_id, '_wpayo_gateway_sisow_test_mode', true );

				return ( 'test' === $mode || '' !== $sisow_test_mode ) ? 'sisow-buckaroo-test' : 'sisow-buckaroo';
			case 'sisow-ideal-basic':
				return ( 'test' === $mode ) ? 'sisow-ideal-basic-test' : 'sisow-ideal-basic';
		}

		return $value;
	},
	10,
	4
);

add_filter(
	'pronamic_pay_gateways',
	function( $gateways ) {

		$gateways[] = new \Wpayo\Gateways\Instamojo\Integration();
		$gateways[] = new \Wpayo\Gateways\Manual\Integration();

		$gateways[] = new \Wpayo\Gateways\Authorize\Integration(
			[
				'id'   => 'authorize',
				'name' => 'Authorize.net',
				'mode' => 'live',
				'host' => 'https://accept.authorize.net/payment/payment',
			]
		);

		$gateways[] = new \Wpayo\Gateways\Authorize\Integration(
			[
				'id'   => 'authorize-test',
				'name' => 'Authorize.net - Test',
				'mode' => 'test',
				'host' => 'https://test.authorize.net/payment/payment',
			]
		);

		// Return gateways.
		return $gateways;
	}
);

/**
 * Backward compatibility.
 */
global $pronamic_ideal;

$pronamic_ideal = pronamic_pay_plugin();
