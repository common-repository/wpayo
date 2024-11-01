<?php
/**
 * Cards
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay;

/**
 * Cards
 *
 * @author  Reüel van der Steege
 * @version 2.7.1
 * @since   2.4.0
 */
class Cards {
	/**
	 * Cards.
	 *
	 * @var array
	 */
	private $cards;

	/**
	 * Cards constructor.
	 */
	public function __construct() {
		$this->register_cards();
	}

	/**
	 * Register cards.
	 *
	 * @return void
	 */
	private function register_cards() {
		$this->cards = [
			// Cards.
			[
				'bic'   => null,
				'brand' => 'american-express',
				'title' => __( 'American Express', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'carta-si',
				'title' => __( 'Carta Si', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'carte-bleue',
				'title' => __( 'Carte Bleue', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'dankort',
				'title' => __( 'Dankort', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'diners-club',
				'title' => __( 'Diners Club', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'discover',
				'title' => __( 'Discover', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'jcb',
				'title' => __( 'JCB', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'maestro',
				'title' => __( 'Maestro', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'mastercard',
				'title' => __( 'Mastercard', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'unionpay',
				'title' => __( 'UnionPay', 'wpayo' ),
			],
			[
				'bic'   => null,
				'brand' => 'visa',
				'title' => __( 'Visa', 'wpayo' ),
			],

			// Banks.
			[
				'bic'   => 'abna',
				'brand' => 'abn-amro',
				'title' => __( 'ABN Amro', 'wpayo' ),
			],
			[
				'bic'   => 'asnb',
				'brand' => 'asn-bank',
				'title' => __( 'ASN Bank', 'wpayo' ),
			],
			[
				'bic'   => 'bunq',
				'brand' => 'bunq',
				'title' => __( 'bunq', 'wpayo' ),
			],
			[
				'bic'   => 'hand',
				'brand' => 'handelsbanken',
				'title' => __( 'Handelsbanken', 'wpayo' ),
			],
			[
				'bic'   => 'ingb',
				'brand' => 'ing',
				'title' => __( 'ING Bank', 'wpayo' ),
			],
			[
				'bic'   => 'knab',
				'brand' => 'knab',
				'title' => __( 'Knab', 'wpayo' ),
			],
			[
				'bic'   => 'moyo',
				'brand' => 'moneyou',
				'title' => __( 'Moneyou', 'wpayo' ),
			],
			[
				'bic'   => 'rabo',
				'brand' => 'rabobank',
				'title' => __( 'Rabobank', 'wpayo' ),
			],
			[
				'bic'   => 'rbrb',
				'brand' => 'regiobank',
				'title' => __( 'RegioBank', 'wpayo' ),
			],
			[
				'bic'   => 'snsb',
				'brand' => 'sns',
				'title' => __( 'SNS Bank', 'wpayo' ),
			],
			[
				'bic'   => 'trio',
				'brand' => 'triodos-bank',
				'title' => __( 'Triodos Bank', 'wpayo' ),
			],
			[
				'bic'   => 'fvlb',
				'brand' => 'van-lanschot',
				'title' => __( 'Van Lanschot', 'wpayo' ),
			],
		];
	}

	/**
	 * Get card.
	 *
	 * @param string $bic_or_brand 4-letter ISO 9362 Bank Identifier Code (BIC) or brand name.
	 * @return array|null
	 */
	public function get_card( $bic_or_brand ) {
		// Use lowercase BIC or brand without spaces.
		$bic_or_brand = \strtolower( $bic_or_brand );

		$bic_or_brand = \str_replace( ' ', '-', $bic_or_brand );

		// Try to find card.
		$cards = \wp_list_filter(
			$this->cards,
			[
				'bic'   => $bic_or_brand,
				'brand' => $bic_or_brand,
			],
			'OR'
		);

		$card = \array_shift( $cards );

		// Return card details.
		if ( ! empty( $card ) ) {
			return $card;
		}

		// No matching card.
		return null;
	}

	/**
	 * Get card logo URL.
	 *
	 * @param string $brand Brand.
	 *
	 * @return string|null
	 */
	public function get_card_logo_url( $brand ) {
		return sprintf(
			'',
			$brand
		);
	}
}
