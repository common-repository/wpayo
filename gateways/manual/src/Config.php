<?php

namespace Wpayo\Gateways\Manual;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: Manual Gateway Config
 * Copyright: 2020-2023 WPayo
 *
 * @author  WPayo
 * @version 1.0.0
 * @since   4.5.0
 */
class Config extends GatewayConfig {
	public $payment_page_title;
	public $payment_page_description;
	public $account_details_page;
}
