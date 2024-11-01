<?php

namespace Wpayo\Gateways\Manual;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;

/**
 * Title: Manual Gateway Integration
 * Copyright: 2020-2023 WPayo
 *
 * @author  WPayo
 * @version 1.0.0
 * @since   4.5.0
 */
class Integration extends AbstractGatewayIntegration {
	/**
	 * Construct Manual Gateway integration.
	 *
	 * @param array $args Arguments.
	 */
	public function __construct( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'id'       => 'manual',
				'name'     => 'Manual',
				'provider' => 'manual',
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
		$pages  = [];
		foreach ( get_pages() as $page ) {
			$pages[]['options'][ $page->ID ] = $page->post_title;
		}

		$fields[] = [
			'section' => 'general',
			'type'    => 'html',
			'html'    => 'Use this payment method to receive payment using manual payment modes like Bank Transfer, Cash Payment, Cheque payment, etc.',
		];

		// Payment Page Title.
		$fields[] = [
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_wpayo_gateway_manual_payment_page_title',
			'title'    => 'Payment Page Title',
			'type'     => 'text',
			'classes'  => [ 'regular-text', 'code' ],
			'default'  => 'Payment Page',
		];

		// Payment Page Description.
		$fields[] = [
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_wpayo_gateway_manual_payment_page_description',
			'title'    => 'Payment Page Description',
			'type'     => 'text',
			'classes'  => [ 'regular-text', 'code' ],
		];

		$fields[] = [
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_NUMBER_INT,
			'meta_key' => '_wpayo_gateway_manual_account_details_page',
			'title'    => __( 'Account Details Page', 'wpayo' ),
			'type'     => 'select',
			'tooltip'  => 'Create a page with other details you want to display on the payment page. Example bank account details, Office Address, etc.',
			'options'  => $pages,
		];

		// Return fields.
		return $fields;
	}

	public function get_config( $post_id ) {
		$config = new Config();

		$config->payment_page_title       = $this->get_meta( $post_id, 'manual_payment_page_title' );
		$config->payment_page_description = $this->get_meta( $post_id, 'manual_payment_page_description' );
		$config->account_details_page     = $this->get_meta( $post_id, 'manual_account_details_page' );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $config_id ) {
		return new Gateway( $this->get_config( $config_id ) );
	}
}
