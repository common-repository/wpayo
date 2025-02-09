<?php
/**
 * Plugin Name: Pronamic Pay Ninja Forms Add-On
 * Plugin URI: https://www.pronamic.eu/plugins/pronamic-pay-ninja-forms/
 * Description: Extend the Pronamic Pay plugin with Ninja Forms support to receive payments through a variety of payment providers.
 *
 * Version: 3.2.2
 * Requires at least: 4.7
 * Requires PHP: 7.4
 *
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 *
 * Text Domain: pronamic-pay-ninja-forms
 * Domain Path: /languages/
 *
 * License: GPL-3.0-or-later
 *
 * Requires Plugins: pronamic-ideal, ninja-forms
 * Depends: wp-pay/core
 *
 * GitHub URI: https://github.com/pronamic/wp-pronamic-pay-ninja-forms
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Extensions\NinjaForms
 */


/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();


add_filter(
	'pronamic_pay_plugin_integrations',
	function ( $integrations ) {
		foreach ( $integrations as $integration ) {
			if ( $integration instanceof \Pronamic\WordPress\Pay\Extensions\NinjaForms\Extension ) {
				return $integrations;
			}
		}

		$integrations[] = new \Pronamic\WordPress\Pay\Extensions\NinjaForms\Extension();

		return $integrations;
	}
);
