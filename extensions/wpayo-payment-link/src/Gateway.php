<?php

namespace Wpayo\Extensions\WpayoPaymentLink;

use Pronamic\WordPress\Html\Element;
use Pronamic\WordPress\Money\Currency;
use Pronamic\WordPress\Money\Money;
use Pronamic\WordPress\Pay\Plugin;
use Pronamic\WordPress\Pay\Util;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: WPayo - Payment Link Gateway
 * Description:
 * Copyright: 2020-2023 WPayo
 * Company: WPayo
 *
 * @author  WPayo
 * @since   4.6.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

class Gateway {

	/**
	 * Bootstrap
	 */
	public function __construct() {

		// Actions.
		// add_action( 'admin_init', [ $this, 'admin_init' ] );

		add_action( 'wp_ajax_wpayo_create_payment_link', [ $this, 'ajax_create_payment_link' ] );
		//before v1.1
		//require_once("views/section-payment-link.php");
	}

	// /**
	//  * Admin initialize.
	//  *
	//  * @return void
	//  */
	// public function admin_init() {

	// 	// Settings - General.
	// 	add_settings_section(
	// 		'knit_pay_create_payment_link',
	// 		__( 'Create Payment Link', 'wpayo' ),
	// 		function () {
	// 			// TODO remove it after few months.
	// 			echo '<p>';
	// 			esc_html_e( 'Payment Link is a new feature of Knit Pay developed to help you generate branded payment links directly from WordPress Dashboard without using Payment Gateway Dashboard. If you have suggestions to improve it, feel free to contact us.', 'wpayo' );
	// 			echo '</p>';
	// 		},
	// 		'knit_pay_payment_link'
	// 	);

	// 	// Amount.
	// 	add_settings_field(
	// 		'wpayo_payment_link_amount',
	// 		__( 'Amount (in INR) *', 'knit-pay' ),
	// 		[ $this, 'input_field' ],
	// 		'knit_pay_payment_link',
	// 		'knit_pay_create_payment_link',
	// 		[
	// 			'label_for' => 'wpayo_payment_link_amount',
	// 			'type'      => 'number',
	// 			'required'  => '',
	// 			'min'       => 1,
	// 			'class'     => 'regular-text',
	// 		]
	// 	);

	// 	// Payment For.
	// 	add_settings_field(
	// 		'wpayo_payment_link_payment_description',
	// 		__( 'Payment For', 'knit-pay' ),
	// 		[ $this, 'input_field' ],
	// 		'knit_pay_payment_link',
	// 		'knit_pay_create_payment_link',
	// 		[
	// 			'description' => __( 'Payment Purpose/Description', 'wpayo' ),
	// 			'label_for'   => 'wpayo_payment_link_payment_description',
	// 			'type'        => 'text',
	// 			'class'       => 'regular-text',
	// 		]
	// 	);

	// 	// Ref Id.
	// 	add_settings_field(
	// 		'wpayo_payment_link_payment_ref_id',
	// 		__( 'Reference Id', 'knit-pay' ),
	// 		[ $this, 'input_field' ],
	// 		'knit_pay_payment_link',
	// 		'knit_pay_create_payment_link',
	// 		[
	// 			'label_for' => 'wpayo_payment_link_payment_ref_id',
	// 			'type'      => 'text',
	// 			'class'     => 'regular-text',
	// 		]
	// 	);

	// 	// Customer Name.
	// 	add_settings_field(
	// 		'wpayo_payment_link_customer_name',
	// 		__( 'Customer Name', 'knit-pay' ),
	// 		[ $this, 'input_field' ],
	// 		'knit_pay_payment_link',
	// 		'knit_pay_create_payment_link',
	// 		[
	// 			'description' => __( 'For some payment gateways, Customer Name is a mandatory field.', 'wpayo' ),
	// 			'label_for'   => 'wpayo_payment_link_customer_name',
	// 			'type'        => 'text',
	// 			'class'       => 'regular-text',
	// 		]
	// 	);

	// 	// Customer Email.
	// 	add_settings_field(
	// 		'wpayo_payment_link_customer_email',
	// 		__( 'Customer Email', 'knit-pay' ),
	// 		[ $this, 'input_field' ],
	// 		'knit_pay_payment_link',
	// 		'knit_pay_create_payment_link',
	// 		[
	// 			'description' => __( 'For some payment gateways, Customer Email is a mandatory field.', 'wpayo' ),
	// 			'label_for'   => 'wpayo_payment_link_customer_email',
	// 			'type'        => 'email',
	// 			'class'       => 'regular-text',
	// 		]
	// 	);

	// 	// Customer Phone.
	// 	add_settings_field(
	// 		'wpayo_payment_link_customer_phone',
	// 		__( 'Customer Phone', 'knit-pay' ),
	// 		[ $this, 'input_field' ],
	// 		'knit_pay_payment_link',
	// 		'knit_pay_create_payment_link',
	// 		[
	// 			'description' => __( 'For some payment gateways, Customer Phone is a mandatory field.', 'wpayo' ),
	// 			'label_for'   => 'wpayo_payment_link_customer_phone',
	// 			'type'        => 'tel',
	// 			'class'       => 'regular-text',
	// 		]
	// 	);

	// 	// Payment Gateway Configuration.
	// 	add_settings_field(
	// 		'wpayo_payment_link_config_id',
	// 		__( 'Payment Gateway Configuration', 'wpayo' ),
	// 		[ $this, 'select_configuration' ],
	// 		'knit_pay_payment_link',
	// 		'knit_pay_create_payment_link',
	// 		[
	// 			'description' => __( 'Configurations can be created in Knit Pay gateway configurations page at <a href="' . admin_url() . 'edit.php?post_type=wpayo_gateway">"Knit Pay >> Configurations"</a>.', 'wpayo' ) . '<br>' . __( 'Visit the "Knit Pay >> Settings" page to set Default Gateway Configuration.', 'wpayo' ),
	// 			'label_for'   => 'wpayo_payment_link_config_id',
	// 			'class'       => 'regular-text',
	// 		]
	// 	);
	// }

	// /**
	//  * Input Field.
	//  *
	//  * @param array $args Arguments.
	//  * @return void
	//  */
	// public function input_field( $args ) {
	// 	$args['id']   = $args['label_for'];
	// 	$args['name'] = $args['label_for'];

	// 	$element = new Element( 'input', $args );
	// 	$element->output();

	// 	if ( isset( $args['description'] ) ) {
	// 		printf(
	// 			'<p class="pronamic-pay-description description">%s</p>',
	//             // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	// 			$args['description']
	// 		);
	// 	}
	// }

	// /**
	//  * Input page.
	//  *
	//  * @param array $args Arguments.
	//  * @return void
	//  */
	// public function select_configuration( $args ) {
	// 	$args['id']   = $args['label_for'];
	// 	$args['name'] = $args['label_for'];

	// 	$configurations    = Plugin::get_config_select_options();
	// 	$configurations[0] = __( '— Default Gateway —', 'wpayo' );

	// 	$configuration_options              = [];
	// 	$configuration_options[]['options'] = $configurations;

	// 	printf(
	// 		'<select %s>%s</select>',
	//         // @codingStandardsIgnoreStart
	//         Util::array_to_html_attributes( $args ),
	//         Util::select_options_grouped( $configuration_options, get_option( 'pronamic_pay_config_id' ) )
	//         // @codingStandardsIgnoreEnd
	// 	);

	// 	if ( isset( $args['description'] ) ) {
	// 		printf(
	// 			'<p class="pronamic-pay-description description">%s</p>',
	//             // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	// 			$args['description']
	// 		);
	// 	}
	// }

	public function ajax_create_payment_link() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$rand         = filter_input( INPUT_GET, 'rand', FILTER_SANITIZE_STRING );
		$nonce_action = "wpayo_create_payment_link|{$rand}";

		if ( ! wp_verify_nonce( filter_input( INPUT_GET, 'wpayo_nonce', FILTER_SANITIZE_STRING ), $nonce_action ) ) {
			echo wp_json_encode(
				[
					'status'    => 'error',
					'error_msg' => __( 'Nonce Missmatch!', 'wpayo' ),
				]
			);
			exit;
		}

		$config_id      = filter_input( INPUT_GET, 'config_id', FILTER_SANITIZE_NUMBER_INT );
		$payment_method = 'ideal';
		
		// Use default gateway if no configuration has been set.
		if ( empty( $config_id ) ) {
			$config_id = get_option( 'pronamic_pay_config_id' );
		}
		
		$gateway = Plugin::get_gateway( $config_id );
		
		if ( ! $gateway ) {
			return false;
			exit;
		}
			
		/**
		 * Build payment.
		 */
		$payment = new Payment();
		$payment->source    = 'wpayo-payment-link';
		$payment->source_id = filter_input( INPUT_GET, 'payment_ref_id', FILTER_SANITIZE_STRING );
		$payment->order_id  = uniqid();
		
		$payment->set_description( Helper::get_description( $payment ) );
		
		$payment->title = Helper::get_title( $payment );
		
		// Customer.
		$payment->set_customer( Helper::get_customer() );
		
		// Address.
		$payment->set_billing_address( Helper::get_address() );
		
		// Currency.
		$currency = Currency::get_instance( 'USD' ); // TODO
		
		// Amount.
		$payment->set_total_amount( new Money( filter_input( INPUT_GET, 'amount', FILTER_SANITIZE_NUMBER_FLOAT ), $currency ) );
		
		// Method.
		$payment->set_payment_method( $payment_method );
		// exit;
		
		// Configuration.
		$payment->config_id = $config_id;
		
		try {
			$payment = Plugin::start_payment( $payment );

			// Execute a redirect.
			echo wp_json_encode(
				[
					'status'       => 'success',
					'redirect_url' => $payment->get_pay_redirect_url(),
				]
			);
			exit;
		} catch ( \Exception $e ) {
			echo wp_json_encode(
				[
					'status'    => 'error',
					'error_msg' => $e->getMessage(),
				]
			);
			exit;
		}
	}

	public static function instance() {
		return new self();
	}
}
