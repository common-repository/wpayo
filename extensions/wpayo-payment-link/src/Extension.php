<?php

namespace Wpayo\Extensions\WpayoPaymentLink;

use Pronamic\WordPress\Pay\AbstractPluginIntegration;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: WPayo - Payment Link extension
 * Description:
 * Copyright: 2023 WPayo
 * Company: WPayo
 *
 * @author  WPayo
 * @since   4.6.0
 */
class Extension extends AbstractPluginIntegration {
	/**
	 * Slug
	 *
	 * @var string
	 */
	const SLUG = 'wpayo-payment-link';

	/**
	 * Constructs and initialize Lifter LMS extension.
	 */
	public function __construct() {
		parent::__construct(
			[
				'name' => __( 'WPayo - Payment Link', 'wpayo' ),
			]
		);

	}

	/**
	 * Setup plugin integration.
	 *
	 * @return void
	 */
	public function setup() {
		// add_filter( 'wpayo_payment_source_text_' . self::SLUG, [ $this, 'source_text' ], 10, 2 );
		// add_filter( 'wpayo_payment_source_description_' . self::SLUG, [ $this, 'source_description' ], 10, 2 );

		// Create Payment Link Menu.
		// add_action( 'admin_menu', [ $this, 'admin_menu' ] );

		Gateway::instance();
	}

	/**
	 * Create the admin menu.
	 *
	 * @return void
	 */
	// public function admin_menu() {
	// 	\add_submenu_page(
	// 		'wpayo',
	// 		__( 'Payment Link', 'wpayo' ),
	// 		__( 'Create Payment Link', 'wpayo' ),
	// 		'edit_payments',
	// 		'knit_pay_payment_link',
	// 		function() {
	// 			// include 'views/page-payment-link.php';
	// 		},
	// 		2
	// 	);
	// }

	// /**
	//  * Source column
	//  *
	//  * @param string  $text    Source text.
	//  * @param Payment $payment Payment.
	//  *
	//  * @return string $text
	//  */
	// public function source_text( $text, Payment $payment ) {
	// 	if ( ! empty( $payment->source_id ) ) {
	// 		$text = __( 'Knit Pay - Payment Link', 'wpayo' ) . '<br />';

	// 		/* translators: %s: source id */
	// 		$text .= sprintf( __( '<strong>Ref Id:</strong> %s', 'wpayo' ), $payment->source_id );
	// 	}

	// 	return $text;
	// }

	// /**
	//  * Source description.
	//  *
	//  * @param string  $description Description.
	//  * @param Payment $payment     Payment.
	//  *
	//  * @return string
	//  */
	// public function source_description( $description, Payment $payment ) {
	// 	return __( 'Knit Pay - Payment Link', 'wpayo' );
	// }
}
