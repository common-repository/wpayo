<?php
/**
 * Gateway config
 *
 * @author    WPayo
 * @copyright 2023 WPayo
 * @license   GPL-3.0-or-later
 * @package   WPayo\gateways
 */

namespace Wpayo\Gateways\Authorize;

use JsonSerializable;
use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Config class
 */
class Config extends GatewayConfig implements JsonSerializable {

	/**
	 * Host.
	 *
	 * @var string
	 */
	private $host;

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
	 * Construct config.
	 */
	public function __construct() {
		$this->host = 'https://accept.authorize.net/payment/payment';
	}

	/**
	 * Get host.
	 *
	 * @return string
	 */
	public function get_host() {
		return $this->host;
	}

	/**
	 * Set host.
	 *
	 * @param string $host Host.
	 */
	public function set_host( $host ) {
		$this->host = $host;
	}

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
			'@type'           => __CLASS__,
			'api_key'         => (string) $this->api_key,
			'transaction_key' => (string) $this->transaction_key,
		);
	}

}

