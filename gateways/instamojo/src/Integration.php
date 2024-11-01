<?php
/**
 * Title: Instamojo Integration
 * Copyright: 2020-2023 WPayo
 *
 * @author  WPayo
 * @version 1.0.0
 * @since   1.0.0
 */

namespace Wpayo\Gateways\Instamojo;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;
use Pronamic\WordPress\Pay\Payments\Payment;
use WP_Query;

class Integration extends AbstractGatewayIntegration {
	/**
	 * Construct Instamojo integration.
	 *
	 * @param array $args Arguments.
	 */
	public function __construct( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'id'            => 'instamojo',
				'name'          => 'Instamojo',
				'url'           => 'https://www.instamojo.com/accounts/register/',
				'product_url'   => 'https://www.instamojo.com/accounts/register',
				'dashboard_url' => 'https://www.instamojo.com/accounts/register/',
				'provider'      => 'instamojo',
				'supports'      => [
					'webhook',
					'webhook_log',
					'webhook_no_config',
				],
			]
		);

		parent::__construct( $args );

		// TODO \add_filter( 'wpayo_gateway_configuration_display_value_' . $this->get_id(), array( $this, 'gateway_configuration_display_value' ), 10, 2 );
		
		// Webhook Listener.
		$function = [ __NAMESPACE__ . '\Listener', 'listen' ];
		
		if ( ! has_action( 'wp_loaded', $function ) ) {
			add_action( 'wp_loaded', $function );
		}

		// Show notice if registered email is not configured.
		add_action( 'admin_notices', [ $this, 'admin_notices' ] );
	}

	/**
	 * Admin notices.
	 *
	 * @return void
	 */
	public function admin_notices() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$config_ids = get_transient( 'wpayo_instamojo_with_missing_email' );

		if ( empty( $config_ids ) ) {

			// Get gateways for which a webhook log exists.
			$query = new WP_Query(
				[
					'post_type'  => 'wpayo_gateway',
					'orderby'    => 'post_title',
					'order'      => 'ASC',
					'fields'     => 'ids',
					'nopaging'   => true,
					'meta_query' => [
						[
							'key'   => '_wpayo_gateway_id',
							'value' => 'instamojo',
						],
						[
							'key'     => '_wpayo_gateway_instamojo_email',
							'compare' => 'NOT EXISTS',
						],
						[
							'key'     => '_wpayo_gateway_instamojo_client_id',
							'compare' => 'EXISTS',
						],
						[
							'key'     => '_wpayo_gateway_instamojo_client_secret',
							'compare' => 'EXISTS',
						],
					],
				]
			);

			$config_ids = $query->posts;
			if ( empty( $config_ids ) ) {
				$config_ids = true;
			}

			set_transient( 'wpayo_instamojo_with_missing_email', $config_ids, MONTH_IN_SECONDS );
		}

		if ( ! empty( $config_ids ) ) {
			require_once __DIR__ . '/views/notice-missing-instamojo-email.php';
		}
	}

	/**
	 * Setup gateway integration.
	 *
	 * @return void
	 */
	public function setup() {
		// Display ID on Configurations page.
		\add_filter(
			'wpayo_gateway_configuration_display_value_' . $this->get_id(),
			[ $this, 'gateway_configuration_display_value' ],
			10,
			2
		);
	}

	/**
	 * Gateway configuration display value.
	 *
	 * @param string $display_value Display value.
	 * @param int    $post_id       Gateway configuration post ID.
	 * @return string
	 */
	public function gateway_configuration_display_value( $display_value, $post_id ) {
		$config = $this->get_config( $post_id );

		return $config->client_id;
	}

	/**
	 * Get settings fields.
	 *
	 * @return array
	 */
	public function get_settings_fields() {
		$fields = [];

		// Intro.
		$fields[] = [
			'section' => 'general',
			'type'    => 'html',
			'html'    => '<p>' . __(
				'Instamojo is a free Payment Gateway for 12,00,000+ Businesses in India. There is no setup or annual fee. Just pay a transaction fee of 2% + ₹3 for the transactions. Instamojo accepts Debit Cards, Credit Cards, Net Banking, UPI, Wallets, and EMI.'
			) . '</p>' . '<p>' . __( '<strong>Steps to Integrate Instamojo</strong>' ) . '</p>' .

			'<ol>' . '<li>Some features may not work with the old Instamojo account! We
                    recommend you create a new account. Sign up process will hardly
                    take 10-15 minutes.<br />
                    <br /> <a class="button button-primary" target="_blank" href="' . $this->get_url() . 'help-signup"
                     role="button"><strong>Sign Up on Instamojo Live</strong></a>
                    <a class="button button-primary" target="_blank" href="https://test.instamojo.com"
                     role="button"><strong>Sign Up on Instamojo Test</strong></a>
                    </li>
                    <br />
		    
                    <li>During signup, Instamojo will ask your PAN and Bank
                    account details, after filling these details, you will reach
                    Instamojo Dashboard.</li>
		    
                    <li>On the left-hand side menu, you will see the option "API &
						Plugins" click on this button.</li>
		    
                    <li>This plugin is based on Instamojo API v2.0, So it will not
                    work with API Key and Auth Token. For this plugin to work, you
                    will have to generate a Client ID and Client Secret. On the bottom
                    of the "API & Plugins" page, you will see Generate Credentials /
                    Create new Credentials button. Click on this button.</li>
		    
                    <li>Now choose a platform from the drop-down
                    menu. You can choose any of them, but we will recommend choosing
                    option "WooCommerce/WordPress"</li>
		    
                    <li>Copy "Client ID" & "Client Secret" and paste it in the
                    Wpayo Configuration Page.</li>

                    <li>You don\'t need to select configuration mode in the Instamojo configuration. Wpayo will automatically detect configuration mode (Test or Live).</li>
		    
                    <li>Fill "Instamojo Account Email Address" field.</li>
		    
					<li>Save the settings using the "Publish" or "Update" button on the configuration page.</li>

                    <li>After saving the settings, test the settings using the Test block on the bottom of the configuration page. If you are getting an error while test the payment, kindly re-check Keys and Mode and save them again before retry.</li>

                    <li>Visit the <strong>Advanced</strong> tab above to configure advance options.</li>

                    </ol>' .
					 'For more details about Instamojo service and details about transactions, you need to access Instamojo dashboard. <br />
                     <a target="_blank" href="' . $this->get_url() . 'know-more">Access Instamojo</a>',
		];

		// Client ID
		$fields[] = [
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_wpayo_gateway_instamojo_client_id',
			'title'    => 'Client ID',
			'type'     => 'text',
			'classes'  => [ 'regular-text', 'code' ],
			'tooltip'  => 'Client ID as mentioned in the Instamojo dashboard at the "API & Plugins" page.',
			'required' => true,
		];

		// Client Secret
		$fields[] = [
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_wpayo_gateway_instamojo_client_secret',
			'title'    => 'Client Secret',
			'type'     => 'text',
			'classes'  => [ 'regular-text', 'code' ],
			'tooltip'  => __( 'Client Secret as mentioned in the Instamojo dashboard at the "API & Plugins" page.', 'wpayo' ),
			'required' => true,
		];

		// Registered Email Address.
		$fields[] = [
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_EMAIL,
			'meta_key' => '_wpayo_gateway_instamojo_email',
			'title'    => __( 'Instamojo Account Email Address', 'wpayo' ),
			'type'     => 'text',
			'classes'  => [ 'regular-text', 'code' ],
			'tooltip'  => __( 'Email Address used for Instamojo Account.', 'wpayo' ),
			'required' => true,
		];

		// Get Discounted Price.
		$fields[] = [
			'section'     => 'general',
			'filter'      => FILTER_VALIDATE_BOOLEAN,
			'meta_key'    => '_wpayo_gateway_instamojo_get_discount',
			'title'       => __( 'Get Discounted Fees', 'wpayo' ),
			'type'        => 'checkbox',
			'description' => 'Wpayo will try to activate discounted transaction fees on your Instamojo account. Discounts are available on a case-to-case basis.<br>Discounted transaction fees will get activated before the 10th of next month on eligible accounts.',
			'tooltip'     => __( 'Tick to show your interested in discounted transaction fees.', 'wpayo' ),
			'label'       => __( 'I am interested in discounted Instamojo transaction fees.', 'wpayo' ),
		];

		// Expire Old Pending Payments.
		$fields[] = [
			'section'     => 'advanced',
			'filter'      => FILTER_VALIDATE_BOOLEAN,
			'meta_key'    => '_wpayo_gateway_instamojo_expire_old_payments',
			'title'       => __( 'Expire Old Pending Payments', 'wpayo' ),
			'type'        => 'checkbox',
			'description' => 'If this option is enabled, 24 hours old pending payments will be marked as expired in Wpayo.',
			'label'       => __( 'Mark old pending Payments as expired in Wpayo.', 'wpayo' ),
			'default'     => true,
		];

		// Send SMS.
		$fields[] = [
			'section'  => 'advanced',
			'filter'   => FILTER_VALIDATE_BOOLEAN,
			'meta_key' => '_wpayo_gateway_instamojo_send_sms',
			'title'    => __( 'Send SMS', 'wpayo' ),
			'type'     => 'checkbox',
			'label'    => __( 'Send payment request link via sms.', 'wpayo' ),
		];

		// Send Email.
		$fields[] = [
			'section'  => 'advanced',
			'filter'   => FILTER_VALIDATE_BOOLEAN,
			'meta_key' => '_wpayo_gateway_instamojo_send_email',
			'title'    => __( 'Send Email', 'wpayo' ),
			'type'     => 'checkbox',
			'label'    => __( 'Send payment request link via email.', 'wpayo' ),
		];

		// Top Bar Mode.
		$top_bar_mode_options = [
			[
				'options' => [
					'show' => 'Show',
					'hide' =>  'Hide',
				],
			],
		];
		$fields[]             = [
			'section'     => 'advanced',
			'filter'      => FILTER_SANITIZE_STRING,
			'meta_key'    => '_wpayo_gateway_instamojo_top_bar_mode',
			'title'       => 'Top Bar Mode',
			'type'        => 'select',
			'classes'     => [ 'regular-text', 'code' ],
			'description' => 'Show/Hide the "Top Bar" and "Cancel Button" on the payment page. In many plugins, this option helps customers to go back and review the cart. We recommend choosing the "Show" option.',
			'options'     => $top_bar_mode_options,
			'default'     => 'show',
		];

		// Return fields.
		return $fields;
	}

	public function get_config( $post_id ) {
		$config = new Config();

		$config->client_id           = $this->get_meta( $post_id, 'instamojo_client_id' );
		$config->client_secret       = $this->get_meta( $post_id, 'instamojo_client_secret' );
		$config->email               = $this->get_meta( $post_id, 'instamojo_email' );
		$config->get_discount        = $this->get_meta( $post_id, 'instamojo_get_discount' );
		$config->expire_old_payments = $this->get_meta( $post_id, 'instamojo_expire_old_payments' );
		$config->send_sms            = $this->get_meta( $post_id, 'instamojo_send_sms' );
		$config->send_email          = $this->get_meta( $post_id, 'instamojo_send_email' );
		$config->top_bar_mode        = $this->get_meta( $post_id, 'instamojo_top_bar_mode' );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $config_id ) {
		$config  = $this->get_config( $config_id );
		$gateway = new Gateway( $config );
		
		$mode = Gateway::MODE_LIVE;
		if ( 0 === strpos( $config->client_id, 'test' ) ) {
			$mode = Gateway::MODE_TEST;
		}
		
		$this->set_mode( $mode );
		$gateway->set_mode( $mode );
		$gateway->init( $config );
		
		return $gateway;
	}

	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 * @return void
	 */
	public function save_post( $post_id ) {
		// Delete and recheck missing email in instamojo configurations.
		delete_transient( 'wpayo_instamojo_with_missing_email' );

		$config = $this->get_config( $post_id );

		if ( ! empty( $config->email ) ) {

			if ( empty( $config->get_discount ) ) {
				$config->get_discount = 0;
			}

			// Update Get Discount Preference.
			$data                     = [];
			$data['emailAddress']     = $config->email;
			$data['entry.1021922804'] = home_url( '/' );
			$data['entry.497676257']  = $config->get_discount;
			wp_remote_post(
				'https://docs.google.com/forms/d/1MF6TvteapGP8-_u6lrNjNy2rf4dmlHB3mF2_DMDg_EE/',
				[
					'body' => $data,
				]
			);
		}

	}
}
