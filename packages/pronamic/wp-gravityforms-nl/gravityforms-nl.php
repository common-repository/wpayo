<?php
/**
 * Plugin Name: Gravity Forms (nl)
 * Plugin URI: https://www.pronamic.eu/plugins/gravityforms-nl/
 * Description: Extend the Gravity Forms plugin with Dutch address and Euro sign notation.
 *
 * Version: 3.0.4
 * Requires at least: 3.0
 *
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 *
 * Text Domain: gravityforms-nl
 * Domain Path: /languages/
 *
 * License: GPL
 *
 * GitHub URI: https://github.com/pronamic/wp-gravityforms-nl
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */



/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();


/**
 * Bootstrap.
 */
 
require __DIR__ . '/vendor/autoload.php';

add_action(
	'plugins_loaded',
	function() {
		if ( ! \class_exists( '\GFCommon' ) ) {
			return;
		}

		// Initialize.
		\Pronamic\WordPress\GravityFormsNL\Plugin::instance(
			[
				'file' => __FILE__,
			]
		);
	}
);
