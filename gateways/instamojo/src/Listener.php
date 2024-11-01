<?php
namespace Wpayo\Gateways\Instamojo;

use Pronamic\WordPress\Pay\Plugin;

/**
 * Title: Instamojo Webhook Listner
 * Copyright: 2020-2023 Wpayo
 *
 * @author Wpayo
 * @version 5.9.1.0
 * @since 5.9.1.0
 */
class Listener {

	public static function listen() {
		if ( ! filter_has_var( INPUT_GET, 'kp_instamojo_webhook' ) || ! filter_has_var( INPUT_POST, 'mac' ) ) {
			return;
		}

		$payment_request_id = filter_input( INPUT_POST, 'payment_request_id', FILTER_SANITIZE_STRING );
		$payment            = get_wpayo_payment_by_transaction_id( $payment_request_id );

		if ( null === $payment ) {
			exit;
		}

		// Add note.
		$note = sprintf(
		/* translators: %s: Instamojo */
			'Webhook requested by %s.',
			'Instamojo',
		);

		$payment->add_note( $note );

		// Log webhook request.
		do_action( 'pronamic_pay_webhook_log_payment', $payment );

		// Update payment.
		Plugin::update_payment( $payment, false );
		exit;
	}
}
