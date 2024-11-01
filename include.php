<?php

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

function wpayo_dependency_autoload( $class ) {
	if ( preg_match( '/^Wpayo\\\\(.+)?([^\\\\]+)$/U', ltrim( $class, '\\' ), $match ) ) {
		$extension_dir = WPAYO_DIR . strtolower( str_replace( '\\', DIRECTORY_SEPARATOR, preg_replace( '/([a-z])([A-Z])/', '$1-$2', $match[1] ) ) );
		if ( ! is_dir( $extension_dir ) ) {
			$extension_dir = WPAYO_DIR . strtolower( str_replace( '\\', DIRECTORY_SEPARATOR, preg_replace( '/([a-z])([A-Z])/', '$1$2', $match[1] ) ) );
		}

		$file = $extension_dir
		. 'src' . DIRECTORY_SEPARATOR
		. $match[2]
		. '.php';	
		if ( is_readable( $file ) ) {
			require_once $file;
		}
	}
}
spl_autoload_register( 'wpayo_dependency_autoload' );


// // Gateway.
require_once WPAYO_DIR . 'gateways/Integration.php';
require_once WPAYO_DIR . 'gateways/Gateway.php';
require_once WPAYO_DIR . 'gateways/IntegrationModeTrait.php';
require_once WPAYO_DIR . 'gateways/PaymentMethods.php';
?>