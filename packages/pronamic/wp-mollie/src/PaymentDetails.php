<?php
/**
 * Payment Details
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Mollie
 */

namespace Pronamic\WordPress\Mollie;

/**
 * Payment details class
 */
class PaymentDetails {
	/**
	 * Create payment detailsfrom JSON.
	 *
	 * @link https://docs.mollie.com/reference/v2/payments-api/get-payment
	 * @param string      $method Payment method.
	 * @param object|null $json   JSON object.
	 * @return PaymentDetails|null
	 * @throws \JsonSchema\Exception\ValidationException Throws JSON schema validation exception when JSON is invalid.
	 */
	public static function from_json( $method, $json ) {
		if ( null === $json ) {
			return null;
		}

		$validator = new \JsonSchema\Validator();

		$validator->validate(
			$json,
			(object) [
				'$ref' => 'file://' . realpath( __DIR__ . '/../json-schemas/payment-details.json' ),
			],
			\JsonSchema\Constraints\Constraint::CHECK_MODE_EXCEPTIONS
		);

		$details = new PaymentDetails();

		foreach ( $json as $key => $value ) {
			$details->{$key} = $value;
		}

		return $details;
	}
}
