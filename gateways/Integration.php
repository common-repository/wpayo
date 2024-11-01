<?php

namespace Wpayo\Gateways;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;

/**
 * Title: Other Payment Provider Integration
 * Copyright: 2020-2023 WPayo
 *
 * @author  WPayo
 * @version 8.79.3.0
 * @since   8.79.3.0
 */
class Integration extends AbstractGatewayIntegration {
	/**
	 * Construct Test integration.
	 *
	 * @param array $args Arguments.
	 */
	public function __construct( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'id'          => 'other',
				'name'        => 'Other Payment Providers',
				'product_url' => KNITPAY_GLOBAL_GATEWAY_LIST_URL,
				'provider'    => 'other',
			]
		);

		parent::__construct( $args );
	}

	/**
	 * Get settings fields.
	 *
	 * @return array
	 */
	public function get_settings_fields() {
		$fields = [];

		$fields[] = [
			'section' => 'general',
			'type'    => 'html',
		
		];

		// Return fields.
		return $fields;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $config_id ) {
		return new Gateway();
	}
}
