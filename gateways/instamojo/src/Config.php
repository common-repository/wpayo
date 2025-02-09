<?php

namespace Wpayo\Gateways\Instamojo;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: Instamojo Config
 * Copyright: 2020-2023 WPayo
 *
 * @author  WPayo
 * @version 1.0.0
 * @since   1.0.0
 */
class Config extends GatewayConfig {
	public $client_id;

	public $client_secret;

	public $email;

	public $get_discount;

	public $expire_old_payments;

	public $send_sms;

	public $send_email;

	public $top_bar_mode;
}
