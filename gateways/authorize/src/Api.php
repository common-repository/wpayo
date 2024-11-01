<?php
/**
 * Authorize.net Integration
 *
 * @author    WPayo
 * @copyright 2023 WPayo
 * @license   GPL-3.0-or-later
 * @package   WPayo\gateways
 */

namespace Wpayo\Gateways\Authorize;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Api class
 */
class Api {

	/**
	 * Config.
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Initialize Api communication.
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		require_once __DIR__ . '/../vendor/autoload.php';

		$this->config = $config;
	}


	/**
	 * Redirect via HTML.
	 *
	 * @param Payment $payment Payment.
	 *
	 * @return Array response.
	 */
	public function get_an_accept_payment_page( Payment $payment ) {
		/*
		Create a merchantAuthenticationType object with authentication details
		retrieved from the constants file
		*/
		$merchant_authentication = new AnetAPI\MerchantAuthenticationType();
		$merchant_authentication->setName( $this->config->get_api_key() );
		$merchant_authentication->setTransactionKey( $this->config->get_transaction_key() );

		// Set the transaction's refId.
		$ref_id = 'ref' . time();

		// Get the customer's Bill To information from Payment object.
		$address     = $payment->get_billing_address();
		$name        = $address->get_name();
		$first_name  = $name->get_first_name();
		$last_name   = $name->get_last_name();
		$country     = $address->get_country_name();
		$zip         = $address->get_postal_code();
		$city        = $address->get_city();
		$phone       = $address->get_phone();
		$line1       = $address->get_line_1();
		$line2       = $address->get_line_2();
		$full_adress = substr( trim( $line1 . ' ' . $line2 ), 0, 60 );
		$state       = $address->get_region();

		// Set the customer's Bill To address.
		$customer_address = new AnetAPI\CustomerAddressType();
		$customer_address->setFirstName( $first_name );
		$customer_address->setLastName( $last_name );
		$customer_address->setCountry( $country );
		$customer_address->setZip( $zip );
		$customer_address->setState( $state );
		$customer_address->setCity( $city );
		$customer_address->setPhoneNumber( $phone );
		$customer_address->setAddress( $full_adress );

		// Create a transaction.
		$transaction_request_type = new AnetAPI\TransactionRequestType();
		$transaction_request_type->setTransactionType( 'authCaptureTransaction' );
		$transaction_request_type->setAmount( $payment->get_total_amount()->number_format( null, '.', '' ) );
		$transaction_request_type->setBillTo( $customer_address );

		// Set Hosted Form options.
		$setting1   = new AnetAPI\SettingType();
		$setting1->setSettingName( 'hostedPaymentReturnOptions' );
		$canceled_url = home_url( '/payment-status/payment-cancelled' );
		$setting1_arg = sprintf(
			'{"url": "%s", "cancelUrl": "%s", "showReceipt": true}',
			$this->get_return_url( $payment ),
			$canceled_url
		);
		$setting1->setSettingValue( $setting1_arg );

		$setting2 = new AnetAPI\SettingType();
		$setting2->setSettingName( 'hostedPaymentBillingAddressOptions' );
		$setting2->setSettingValue( '{"show": true, "required": false}' );

		$setting3 = new AnetAPI\SettingType();
		$setting3->setSettingName( 'hostedPaymentPaymentOptions' );
		$setting3->setSettingValue( '{"showBankAccount": false}' );

		// Build transaction request.
		$request = new AnetAPI\GetHostedPaymentPageRequest();
		$request->setMerchantAuthentication( $merchant_authentication );
		$request->setRefId( $ref_id );
		$request->setTransactionRequest( $transaction_request_type );

		$request->addToHostedPaymentSettings( $setting1 );
		$request->addToHostedPaymentSettings( $setting2 );
		$request->addToHostedPaymentSettings( $setting3 );

		// Execute request.
		$controller = new AnetController\GetHostedPaymentPageController( $request );
		$response   = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX );
		return $response;
	}

	/**
	 * Get the return URL for this payment. This URL is passed to the payment providers / gateways
	 * so they know where they should return users to.
	 * Slightly modified to be compatible with authorize gateway.
	 *
	 * @param Payment $payment Payment.
	 *
	 * @return string
	 */
	public function get_return_url( $payment ) {
		$home_url = home_url( '/' );

		/**
		 * Polylang compatibility.
		 *	
		 * @link https://github.com/polylang/polylang/blob/2.6.8/include/api.php#L97-L111
		 */
		if ( \function_exists( '\pll_home_url' ) ) {
			$home_url = \pll_home_url();
		}

		$url = add_query_arg(
			array(
				'payment' => $payment->get_id(),
				'key'     => $payment->key,
			),
			''
		);

		$url = $home_url . rawurlencode( $url );

		return $url;
	}
}
