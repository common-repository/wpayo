<?php
/**
 * Authorize Gateway
 *
 * @author    WPayo
 * @copyright 2023 WPayo
 * @license   GPL-3.0-or-later
 * @package   WPayo\gateways
 */

namespace Wpayo\Gateways\Authorize;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Payments\Payment;
use Pronamic\WordPress\Pay\Core\PaymentMethods as Core_PaymentMethods;
use Pronamic\WordPress\Pay\Core\PaymentMethod;
use Pronamic\WordPress\Pay\Core\Util as Core_Util;
use Pronamic\WordPress\Pay\Plugin;


/**
 * Gateway class
 */
class Gateway extends Core_Gateway {

	/**
	 * Config.
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Construct and initialize an gateway
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->config = $config;

		$this->set_method( self::METHOD_HTML_FORM );

		// Supported features.
		$this->supports = array();

		$this->register_payment_method( new PaymentMethod( Core_PaymentMethods::CREDIT_CARD ) );
		$this->register_payment_method( new PaymentMethod( Core_PaymentMethods::BANK_TRANSFER ) );
		$this->register_payment_method( new PaymentMethod( 'authorize_net' ) );
	}

	/**
	 * Start an transaction with the specified data
	 *
	 * @param Payment $payment Payment.
	 */
	public function start( Payment $payment ) {
		$payment->set_action_url( $this->config->get_host() );
	}

	/**
	 * Redirect via HTML.
	 *
	 * @param Payment $payment The payment to redirect for.
	 * @return void
	 */
	public function redirect_via_html( Payment $payment ) {
		if ( headers_sent() ) {
			/* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
			echo $this->get_form_html( $payment, true );
		} else {
			Core_Util::no_cache();

			include Plugin::$dirname . '/views/redirect-via-html.php';
		}

		exit;
	}

	/**
	 * Get form HTML.
	 *
	 * @param Payment $payment     Payment to get form HTML for.
	 * @return string
	 * @throws \Exception When payment action URL is empty.
	 */
	public function get_form_html( Payment $payment , $auto_submit = false) {
		$form_inner = $this->get_output_html( $payment );

		$form_inner .= sprintf(
			'<input class="pronamic-pay-btn" type="submit" name="pay" value="%s" />',
			__( 'Pay', 'wpayo' )
		);

		$action_url = $payment->get_action_url();

		if ( empty( $action_url ) ) {
			throw new \Exception( 'Action URL is empty, can not get form HTML.' );
		}

		$html = sprintf(
			'<form id="pronamic_ideal_form" name="pronamic_ideal_form" method="post" action="%s">%s</form>',
			esc_attr( $action_url ),
			$form_inner
		);

		return $html;
	}

	/**
	 * Get output HTML
	 *
	 * @param Payment $payment Payment.
	 *
	 * @return array
	 * @since   1.1.1
	 * @version 2.0.5
	 */
	public function get_output_fields( Payment $payment ) {
		$api     = new Api( $this->config );
		$response = $api->get_an_accept_payment_page( $payment );
		// echo $response;
		$data = array(
			'token' => $response->getToken(),
		);

		return $data;
	}
}
