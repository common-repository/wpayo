<?php
/**
 * Authorize.net Integration
 *
 * @author    WPayo
 * @copyright 2023 WPayo
 * @license   GPL-3.0-or-later
 * @package   WPayo\gateways
 */

namespace Wpayo\Gateways\Authorize;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;


/**
 * Integraion class
 */
class Integration extends AbstractGatewayIntegration {

	/**
	 * Host.
	 *
	 * @var string
	 */
	private $host;

	/**
	 * Construct Authorize.net integration.
	 *
	 * @param array<string, string[]> $args Arguments.
	 */
	public function __construct( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'id'            => 'authorize',
				'name'          => 'Authorize.net',
				'url'           => 'https://www.authorize.net/',
				'product_url'   => 'https://www.authorize.net/',
				'dashboard_url' => 'https://sandbox.authorize.net/',
				'provider'      => 'Authorize.ne',
				'supports'      => array(
					'recurring',
					'refunds',
				),
			)
		);
		parent::__construct( $args );

		$this->host = $args['host'];
	}

	/**
	 * Get settings fields.
	 *
	 * @return array<int, array<string, callable|int|string|bool|array<int|string,int|string>>>
	 */
	public function get_settings_fields() {
		global $post;

		$config = ( $post instanceof WP_Post ) ? $this->get_config( $post->ID ) : null;

		$fields = array();

		// Website Key.
		$fields[] = array(
			'section'  => 'general',
			'meta_key' => '_wpayo_gateway_authorize_api_key', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'title'    => __( 'API Login ID', 'wpayo' ),
			'type'     => 'text',
			'classes'  => array( 'code' ),
			'tooltip'  => __( 'The merchant API Login ID is provided in the Merchant Interface and must be stored securely.', 'wpayo' ),
			'default'  => null === $config ? '' : $config->get_api_key(),
			'required' => true,
		);

		// Website Key.
		$fields[] = array(
			'section'  => 'general',
			'meta_key' => '_wpayo_gateway_authorize_transaction_key', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'title'    => __( 'Transaction Key', 'wpayo' ),
			'type'     => 'text',
			'classes'  => array( 'code' ),
			'tooltip'  => __( 'The merchant Transaction Key is provided in the Merchant Interface and must be stored securely.', 'wpayo' ),
			'default'  => null === $config ? '' : $config->get_transaction_key(),
			'required' => true,
		);

		return $fields;
	}

	/**
	 * Get configuration by post ID.
	 *
	 * @param int $post_id Post ID.
	 * @return Config
	 */
	public function get_config( $post_id ) {
		$config = new Config();

		$config->set_host( $this->host );

		$config->api_key         = get_post_meta( $post_id, '_wpayo_gateway_authorize_api_key', true );
		$config->transaction_key = get_post_meta( $post_id, '_wpayo_gateway_authorize_transaction_key', true );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $post_id ) {
		$gateway = new Gateway( $this->get_config( $post_id ) );
		$gateway->set_mode( $this->get_mode() );
		return $gateway;
	}
}

