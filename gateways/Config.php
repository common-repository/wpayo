<?php
/**
 * Gateway config
 *
 * @author    WPayo
 * @copyright 2023 WPayo
 * @license   GPL-3.0-or-later
 * @package   WPayo\gateways
 */

namespace WPayo\Gateways\Authorize;

use JsonSerializable;
use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Config class
 */
class Config extends GatewayConfig implements JsonSerializable {

	/**
	 * API Login ID.
	 *
	 * @var string
	 */
	public $api_key;

	/**
	 * Public Client Key.
	 *
	 * @var string
	 */
	public $client_key;

	/**
	 * Transaction Key.
	 *
	 * @var string
	 */
	public $transaction_key;

	/**
	 * Get API Login ID.
	 *
	 * @return string|null
	 */
	public function get_api_key() {
		return $this->api_key;
	}

	/**
	 * Get Public Client Key.
	 *
	 * @return string|null
	 */
	public function get_client_key() {
		return $this->client_key;
	}

	/**
	 * Get Transaction Key.
	 *
	 * @return string|null
	 */
	public function get_transaction_key() {
		return $this->transaction_key;
	}

	/**
	 * Serialize to JSON.
	 *
	 * @link https://www.w3.org/TR/json-ld11/#specifying-the-type
	 * @return object
	 */
	public function jsonSerialize(): object {
		return (object) array(
			'@type'      => __CLASS__,
			'api_key'    => (string) $this->api_key,
			'client_key' => (string) $this->client_key,
			'client_key' => (string) $this->client_key,
		);
	}

}

