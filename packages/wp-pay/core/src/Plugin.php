<?php
/**
 * Plugin
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay;

use Pronamic\WordPress\Http\Facades\Http;
use Pronamic\WordPress\Money\Money;
use Pronamic\WordPress\Pay\Admin\AdminModule;
use Pronamic\WordPress\Pay\Banks\BankAccountDetails;
use Pronamic\WordPress\Pay\Core\Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethod;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Core\PaymentMethodsCollection;
use Pronamic\WordPress\Pay\Core\Util as Core_Util;
use Pronamic\WordPress\Pay\Gateways\GatewaysDataStoreCPT;
use Pronamic\WordPress\Pay\Payments\Payment;
use Pronamic\WordPress\Pay\Payments\PaymentPostType;
use Pronamic\WordPress\Pay\Payments\PaymentsDataStoreCPT;
use Pronamic\WordPress\Pay\Payments\PaymentStatus;
use Pronamic\WordPress\Pay\Payments\StatusChecker;
use Pronamic\WordPress\Pay\Refunds\Refund;
use Pronamic\WordPress\Pay\Subscriptions\SubscriptionPostType;
use Pronamic\WordPress\Pay\Subscriptions\SubscriptionsDataStoreCPT;
use Pronamic\WordPress\Pay\Webhooks\WebhookLogger;
use WP_Error;
use WP_Query;

/**
 * Plugin
 *
 * @author  Remco Tolsma
 * @version 2.5.1
 * @since   2.0.1
 */
class Plugin {
	/**
	 * Version.
	 *
	 * @var string
	 */
	private $version = '';

	/**
	 * The root file of this WordPress plugin
	 *
	 * @var string
	 */
	public static $file;

	/**
	 * The plugin dirname
	 *
	 * @var string
	 */
	public static $dirname;

	/**
	 * The timezone
	 *
	 * @var string
	 */
	const TIMEZONE = 'UTC';

	/**
	 * Instance.
	 *
	 * @var Plugin|null
	 */
	protected static $instance;

	/**
	 * Instance.
	 *
	 * @param string|array|object $args The plugin arguments.
	 *
	 * @return Plugin
	 */
	public static function instance( $args = [] ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $args );
		}

		return self::$instance;
	}

	/**
	 * Plugin settings.
	 *
	 * @var Settings
	 */
	public $settings;

	/**
	 * Gateway data storing.
	 *
	 * @var GatewaysDataStoreCPT
	 */
	public $gateways_data_store;

	/**
	 * Payment data storing.
	 *
	 * @var PaymentsDataStoreCPT
	 */
	public $payments_data_store;

	/**
	 * Subscription data storing.
	 *
	 * @var SubscriptionsDataStoreCPT
	 */
	public $subscriptions_data_store;

	/**
	 * Gateway post type.
	 *
	 * @var GatewayPostType
	 */
	public $gateway_post_type;

	/**
	 * Payment post type.
	 *
	 * @var PaymentPostType
	 */
	public $payment_post_type;

	/**
	 * Subscription post type.
	 *
	 * @var SubscriptionPostType
	 */
	public $subscription_post_type;

	/**
	 * Privacy manager.
	 *
	 * @var PrivacyManager
	 */
	public $privacy_manager;

	/**
	 * Admin module.
	 *
	 * @var AdminModule
	 */
	public $admin;

	/**
	 * Pages controller.
	 *
	 * @var PagesController
	 */
	private $pages_controller;

	/**
	 * Home URL controller.
	 *
	 * @var HomeUrlController
	 */
	private $home_url_controller;

	/**
	 * Blocks module.
	 *
	 * @var Blocks\BlocksModule
	 */
	public $blocks_module;

	/**
	 * Forms module.
	 *
	 * @var Forms\FormsModule
	 */
	public $forms_module;

	/**
	 * Tracking module.
	 *
	 * @var TrackingModule
	 */
	public $tracking_module;

	/**
	 * Payments module.
	 *
	 * @var Payments\PaymentsModule
	 */
	public $payments_module;

	/**
	 * Subscriptions module.
	 *
	 * @var Subscriptions\SubscriptionsModule
	 */
	public $subscriptions_module;

	/**
	 * Google analytics ecommerce.
	 *
	 * @var GoogleAnalyticsEcommerce
	 */
	public $google_analytics_ecommerce;

	/**
	 * Gateway integrations.
	 *
	 * @var GatewayIntegrations
	 */
	public $gateway_integrations;

	/**
	 * Integrations
	 *
	 * @var AbstractIntegration[]
	 */
	public $integrations;

	/**
	 * Webhook logger.
	 *
	 * @var WebhookLogger
	 */
	private $webhook_logger;

	/**
	 * Options.
	 *
	 * @var array
	 */
	private $options;

	/**
	 * Plugin integrations.
	 *
	 * @var array
	 */
	public $plugin_integrations;

	/**
	 * Pronamic service URL.
	 *
	 * @var string|null
	 */
	private static $pronamic_service_url;

	/**
	 * Payment methods.
	 *
	 * @var PaymentMethodsCollection
	 */
	private $payment_methods;

	/**
	 * Construct and initialize an Pronamic Pay plugin object.
	 *
	 * @param string|array|object $args The plugin arguments.
	 */
	public function __construct( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'file'    => null,
				'options' => [],
			]
		);

		// Version from plugin file header.
		if ( null !== $args['file'] ) {
			$file_data = get_file_data( $args['file'], [ 'Version' => 'Version' ] );

			if ( \array_key_exists( 'Version', $file_data ) ) {
				$this->version = $file_data['Version'];
			}
		}

		// Backward compatibility.
		self::$file    = $args['file'];
		self::$dirname = dirname( self::$file );

		// Options.
		$this->options = $args['options'];

		// Integrations.
		$this->integrations = [];

		/*
		 * Plugins loaded.
		 *
		 * Priority should be at least lower then 8 to support the "WP eCommerce" plugin.
		 *
		 * new WP_eCommerce()
		 * add_action( 'plugins_loaded' , array( $this, 'init' ), 8 );
		 * $this->load();
		 * wpsc_core_load_gateways();
		 *
		 * @link https://github.com/wp-e-commerce/WP-e-Commerce/blob/branch-3.11.2/wp-shopping-cart.php#L342-L343
		 * @link https://github.com/wp-e-commerce/WP-e-Commerce/blob/branch-3.11.2/wp-shopping-cart.php#L26-L35
		 * @link https://github.com/wp-e-commerce/WP-e-Commerce/blob/branch-3.11.2/wp-shopping-cart.php#L54
		 * @link https://github.com/wp-e-commerce/WP-e-Commerce/blob/branch-3.11.2/wp-shopping-cart.php#L296-L297
		 */
		add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ], 0 );

		// Plugin locale.
		add_filter( 'plugin_locale', [ $this, 'plugin_locale' ], 10, 2 );

		// Register styles.
		add_action( 'init', [ $this, 'register_styles' ], 9 );

		// If WordPress is loaded check on returns and maybe redirect requests.
		add_action( 'wp_loaded', [ $this, 'handle_returns' ], 10 );
		add_action( 'wp_loaded', [ $this, 'maybe_redirect' ], 10 );

		// Default date time format.
		add_filter( 'pronamic_datetime_default_format', [ $this, 'datetime_format' ], 10, 1 );

		/**
		 * Pronamic service URL.
		 */
		if ( \array_key_exists( 'pronamic_service_url', $args ) ) {
			self::$pronamic_service_url = $args['pronamic_service_url'];
		}

		/**
		 * Action scheduler.
		 *
		 * @link https://actionscheduler.org/
		 */
		if ( ! \array_key_exists( 'action_scheduler', $args ) ) {
			$args['action_scheduler'] = self::$dirname . '/wp-content/plugins/action-scheduler/action-scheduler.php';
		}

		require_once $args['action_scheduler'];

		/**
		 * Payment methods.
		 */
		$this->payment_methods = new PaymentMethodsCollection();

		$this->payment_methods->add( new PaymentMethod( PaymentMethods::AFTERPAY_NL ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::AFTERPAY_COM ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::ALIPAY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::AMERICAN_EXPRESS ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::APPLE_PAY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::BANCONTACT ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::BANK_TRANSFER ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::BELFIUS ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::BILLINK ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::BITCOIN ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::BLIK ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::BUNQ ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::IN3 ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::CAPAYABLE ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::CREDIT_CARD ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::DIRECT_DEBIT ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::DIRECT_DEBIT_BANCONTACT ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::DIRECT_DEBIT_IDEAL ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::DIRECT_DEBIT_SOFORT ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::EPS ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::FOCUM ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::IDEAL ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::IDEALQR ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::GIROPAY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::GOOGLE_PAY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::KBC ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::KLARNA_PAY_LATER ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::KLARNA_PAY_NOW ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::KLARNA_PAY_OVER_TIME ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::MAESTRO ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::MASTERCARD ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::MB_WAY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::PAYCONIQ ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::PAYPAL ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::PRZELEWY24 ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::RIVERTY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::SANTANDER ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::SOFORT ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::SPRAYPAY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::SWISH ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::TWINT ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::V_PAY ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::VIPPS ) );
		$this->payment_methods->add( new PaymentMethod( PaymentMethods::VISA ) );
	}

	/**
	 * Get payment methods.
	 *
	 * @param array $args Query arguments.
	 * @return PaymentMethodsCollection
	 */
	public function get_payment_methods( $args = [] ) {
		return $this->payment_methods->query( $args );
	}

	/**
	 * Get the version number of this plugin.
	 *
	 * @return string The version number of this plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Get plugin file path.
	 *
	 * @return string
	 */
	public function get_file() {
		return self::$file;
	}

	/**
	 * Get option.
	 *
	 * @param string $option Name of option to retrieve.
	 * @return string|null
	 */
	public function get_option( $option ) {
		if ( array_key_exists( $option, $this->options ) ) {
			return $this->options[ $option ];
		}

		return null;
	}

	/**
	 * Get the plugin dir path.
	 *
	 * @return string
	 */
	public function get_plugin_dir_path() {
		return plugin_dir_path( $this->get_file() );
	}

	/**
	 * Update payment.
	 *
	 * @param Payment $payment      The payment to update.
	 * @param bool    $can_redirect Flag to indicate if redirect is allowed after the payment update.
	 * @return void
	 */
	public static function update_payment( $payment = null, $can_redirect = true ) {
		if ( empty( $payment ) ) {
			return;
		}

		// Gateway.
		$gateway = $payment->get_gateway();

		if ( null === $gateway ) {
			return;
		}

		// Update status.
		try {
			$gateway->update_status( $payment );

			// Update payment in data store.
			$payment->save();
		} catch ( \Exception $error ) {
			$message = $error->getMessage();

			// Maybe include error code in message.
			$code = $error->getCode();

			if ( $code > 0 ) {
				$message = \sprintf( '%s: %s', $code, $message );
			}

			// Add note.
			$payment->add_note( $message );
		}

		// Maybe redirect.
		if ( ! $can_redirect ) {
			return;
		}

		/*
		 * If WordPress is doing cron we can't redirect.
		 *
		 * @link https://github.com/pronamic/wp-pronamic-ideal/commit/bb967a3e7804ecfbd83dea110eb8810cbad097d7
		 * @link https://github.com/pronamic/wp-pronamic-ideal/commit/3ab4a7c1fc2cef0b6f565f8205da42aa1203c3c5
		 */
		if ( \wp_doing_cron() ) {
			return;
		}

		/*
		 * If WordPress CLI is running we can't redirect.
		 *
		 * @link https://basecamp.com/1810084/projects/10966871/todos/346407847
		 * @link https://github.com/woocommerce/woocommerce/blob/3.5.3/includes/class-woocommerce.php#L381-L383
		 */
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			return;
		}

		// Redirect.
		$url = $payment->get_return_redirect_url();

		wp_redirect( $url );

		exit;
	}

	/**
	 * Handle returns.
	 *
	 * @return void
	 */
	public function handle_returns() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if (
			! \array_key_exists( 'payment', $_GET )
				||
			! \array_key_exists( 'key', $_GET )
		) {
			return;
		}

		$payment_id = (int) $_GET['payment'];

		$payment = get_wpayo_payment( $payment_id );

		if ( null === $payment ) {
			return;
		}

		// Check if payment key is valid.
		$key = \sanitize_text_field( \wp_unslash( $_GET['key'] ) );

		if ( $key !== $payment->key ) {
			wp_safe_redirect( home_url() );

			exit;
		}

		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		// Check if we should redirect.
		$should_redirect = true;

		/**
		 * Filter whether or not to allow redirects on payment return.
		 *
		 * @param bool    $should_redirect Flag to indicate if redirect is allowed on handling payment return.
		 * @param Payment $payment         Payment.
		 */
		$should_redirect = apply_filters( 'pronamic_pay_return_should_redirect', $should_redirect, $payment );

		try {
			self::update_payment( $payment, $should_redirect );
		} catch ( \Exception $e ) {
			self::render_exception( $e );

			exit;
		}
	}

	/**
	 * Maybe redirect.
	 *
	 * @return void
	 */
	public function maybe_redirect() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( ! \array_key_exists( 'payment_redirect', $_GET ) || ! \array_key_exists( 'key', $_GET ) ) {
			return;
		}

		// Get payment.
		$payment_id = (int) $_GET['payment_redirect'];

		$payment = get_wpayo_payment( $payment_id );

		if ( null === $payment ) {
			return;
		}

		// Validate key.
		$key = \sanitize_text_field( \wp_unslash( $_GET['key'] ) );

		if ( $key !== $payment->key || empty( $payment->key ) ) {
			return;
		}

		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		// Don't cache.
		Core_Util::no_cache();

		// Switch to user locale.
		Core_Util::switch_to_user_locale();

		// Handle redirect message from payment meta.
		$redirect_message = $payment->get_meta( 'payment_redirect_message' );

		if ( ! empty( $redirect_message ) ) {
			require self::$dirname . '/views/redirect-message.php';

			exit;
		}

		$gateway = $payment->get_gateway();

		if ( null !== $gateway ) {
			// Give gateway a chance to handle redirect.
			$gateway->payment_redirect( $payment );

			// Handle HTML form redirect.
			if ( $gateway->is_html_form() ) {
				$gateway->redirect( $payment );
			}
		}

		// Redirect to payment action URL.
		$action_url = $payment->get_action_url();

		if ( ! empty( $action_url ) ) {
			wp_redirect( $action_url );

			exit;
		}
	}

	/**
	 * Get number payments.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_count_posts/
	 *
	 * @return int|false
	 */
	public static function get_number_payments() {
		$number = false;

		$count = wp_count_posts( 'wpayo_payment' );

		if ( isset( $count->payment_completed ) ) {
			$number = intval( $count->payment_completed );
		}

		return $number;
	}

	/**
	 * Plugins loaded.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/plugins_loaded/
	 * @link https://developer.wordpress.org/reference/functions/load_plugin_textdomain/
	 * @return void
	 */
	public function plugins_loaded() {
		// Load plugin textdomain.
		self::load_plugin_textdomain();

		// Settings.
		$this->settings = new Settings( $this );

		// Data Stores.
		$this->gateways_data_store      = new GatewaysDataStoreCPT();
		$this->payments_data_store      = new PaymentsDataStoreCPT();
		$this->subscriptions_data_store = new SubscriptionsDataStoreCPT();

		$this->payments_data_store->setup();
		$this->subscriptions_data_store->setup();

		// Post Types.
		$this->gateway_post_type      = new GatewayPostType();
		$this->payment_post_type      = new PaymentPostType();
		$this->subscription_post_type = new SubscriptionPostType();

		// Privacy Manager.
		$this->privacy_manager = new PrivacyManager();

		// Webhook Logger.
		$this->webhook_logger = new WebhookLogger();
		$this->webhook_logger->setup();

		// Modules.
		// $this->forms_module         = new Forms\FormsModule();
		$this->payments_module      = new Payments\PaymentsModule( $this );
		$this->subscriptions_module = new Subscriptions\SubscriptionsModule( $this );
		$this->tracking_module      = new TrackingModule();

		// Blocks module.
		if ( function_exists( 'register_block_type' ) ) {
			$this->blocks_module = new Blocks\BlocksModule();
			$this->blocks_module->setup();
		}

		// Google Analytics Ecommerce.
		$this->google_analytics_ecommerce = new GoogleAnalyticsEcommerce();

		// Admin.
		if ( is_admin() ) {
			$this->admin = new Admin\AdminModule( $this );
		}

		$this->pages_controller = new PagesController();
		$this->pages_controller->setup();

		$this->home_url_controller = new HomeUrlController();
		$this->home_url_controller->setup();

		$gateways = [];

		/**
		 * Filters the gateway integrations.
		 *
		 * @param AbstractGatewayIntegration[] $gateways Gateway integrations.
		 */
		$gateways = apply_filters( 'pronamic_pay_gateways', $gateways );

		$this->gateway_integrations = new GatewayIntegrations( $gateways );

		foreach ( $this->gateway_integrations as $integration ) {
			$integration->setup();
		}

		$plugin_integrations = [];

		/**
		 * Filters the plugin integrations.
		 *
		 * @param AbstractPluginIntegration[] $plugin_integrations Plugin integrations.
		 */
		$this->plugin_integrations = apply_filters( 'pronamic_pay_plugin_integrations', $plugin_integrations );

		foreach ( $this->plugin_integrations as $integration ) {
			$integration->setup();
		}

		// Integrations.
		$gateway_integrations = \iterator_to_array( $this->gateway_integrations );

		$this->integrations = array_merge( $gateway_integrations, $this->plugin_integrations );

		// Maybes.
		PaymentMethods::maybe_update_active_payment_methods();

		// Filters.
		\add_filter( 'wpayo_payment_redirect_url', [ $this, 'payment_redirect_url' ], 10, 2 );

		// Actions.
		\add_action( 'pronamic_pay_pre_create_payment', [ __CLASS__, 'complement_payment' ], 10, 1 );
	}

	/**
	 * Load plugin text domain.
	 *
	 * @return void
	 */
	public static function load_plugin_textdomain() {
		$rel_path = \dirname( \plugin_basename( self::$file ) );

		\load_plugin_textdomain( 'wpayo', false, $rel_path . '/languages' );

		\load_plugin_textdomain( 'pronamic-money', false, $rel_path . '/vendor/pronamic/wp-money/languages' );
	}

	/**
	 * Filter plugin locale.
	 *
	 * @param string $locale A WordPress locale identifier.
	 * @param string $domain A WordPress text domain identifier.
	 *
	 * @return string
	 */
	public function plugin_locale( $locale, $domain ) {
		if ( 'wpayo' !== $domain ) {
			return $locale;
		}

		if ( 'nl_NL_formal' === $locale ) {
			return 'nl_NL';
		}

		if ( 'nl_BE' === $locale ) {
			return 'nl_NL';
		}

		return $locale;
	}

	/**
	 * Default date time format.
	 *
	 * @param string $format Format.
	 *
	 * @return string
	 */
	public function datetime_format( $format ) {
		$format = _x( 'D j M Y \a\t H:i', 'default datetime format', 'wpayo' );

		return $format;
	}

	/**
	 * Get default error message.
	 *
	 * @return string
	 */
	public static function get_default_error_message() {
		return __( 'Something went wrong with the payment. Please try again or pay another way.', 'wpayo' );
	}

	/**
	 * Register styles.
	 *
	 * @since 2.1.6
	 * @return void
	 */
	public function register_styles() {
		$min = \SCRIPT_DEBUG ? '' : '.min';

		\wp_register_style(
			'pronamic-pay-redirect',
			\plugins_url( 'css/redirect' . $min . '.css', __DIR__ ),
			[],
			$this->get_version()
		);
	}

	/**
	 * Get config select options.
	 *
	 * @param null|string $payment_method The gateway configuration options for the specified payment method.
	 *
	 * @return array
	 */
	public static function get_config_select_options( $payment_method = null ) {
		$args = [
			'post_type' => 'wpayo_gateway',
			'orderby'   => 'post_title',
			'order'     => 'ASC',
			'nopaging'  => true,
		];

		if ( null !== $payment_method ) {
			$config_ids = PaymentMethods::get_config_ids( $payment_method );

			$args['post__in'] = empty( $config_ids ) ? [ 0 ] : $config_ids;
		}

		$query = new WP_Query( $args );

		$options = [ __( '— Select Configuration —', 'wpayo' ) ];

		foreach ( $query->posts as $post ) {
			if ( ! \is_object( $post ) ) {
				continue;
			}

			$id = $post->ID;

			$options[ $id ] = \get_the_title( $id );
		}

		return $options;
	}

	/**
	 * Render errors.
	 *
	 * @param array|WP_Error $errors An array with errors to render.
	 * @return void
	 */
	public static function render_errors( $errors = [] ) {
		if ( ! is_array( $errors ) ) {
			$errors = [ $errors ];
		}

		foreach ( $errors as $pay_error ) {
			include self::$dirname . '/views/error.php';
		}
	}

	/**
	 * Render exception.
	 *
	 * @param \Exception $exception An exception.
	 * @return void
	 */
	public static function render_exception( \Exception $exception ) {
		include self::$dirname . '/views/exception.php';
	}

	/**
	 * Get gateway.
	 *
	 * @link https://wordpress.org/support/article/post-status/#default-statuses
	 *
	 * @param int   $config_id A gateway configuration ID.
	 * @param array $args      Extra arguments.
	 *
	 * @return null|Gateway
	 */
	public static function get_gateway( $config_id, $args = [] ) {
		// Get gateway from data store.
		$gateway = \pronamic_pay_plugin()->gateways_data_store->get_gateway( $config_id );

		// Use gateway identifier from arguments to get new gateway.
		if ( null === $gateway && ! empty( $args ) ) {
			// Get integration.
			$args = wp_parse_args(
				$args,
				[
					'gateway_id' => \get_post_meta( $config_id, '_wpayo_gateway_id', true ),
				]
			);

			$integration = pronamic_pay_plugin()->gateway_integrations->get_integration( $args['gateway_id'] );

			// Get new gateway.
			if ( null !== $integration ) {
				$gateway = $integration->get_gateway( $config_id );
			}
		}

		return $gateway;
	}

	/**
	 * Complement payment.
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	public static function complement_payment( Payment $payment ) {
		// Key.
		if ( null === $payment->key ) {
			$payment->key = uniqid( 'pay_' );
		}

		$origin_id = $payment->get_origin_id();

		if ( null === $origin_id ) {
			// Queried object.
			$queried_object    = \get_queried_object();
			$queried_object_id = \get_queried_object_id();

			if ( null !== $queried_object && $queried_object_id > 0 ) {
				$origin_id = $queried_object_id;
			}

			// Referer.
			$referer = \wp_get_referer();

			if ( null === $origin_id && false !== $referer ) {
				$post_id = \url_to_postid( $referer );

				if ( $post_id > 0 ) {
					$origin_id = $post_id;
				}
			}

			// Set origin ID.
			$payment->set_origin_id( $origin_id );
		}

		// Google Analytics client ID.
		$google_analytics_client_id = $payment->get_meta( 'google_analytics_client_id' );

		if ( null === $google_analytics_client_id ) {
			$google_analytics_client_id = GoogleAnalyticsEcommerce::get_cookie_client_id();

			if ( null !== $google_analytics_client_id ) {
				$payment->set_meta( 'google_analytics_client_id', $google_analytics_client_id );
			}
		}

		// Customer.
		$customer = $payment->get_customer();

		if ( null === $customer ) {
			$customer = new Customer();

			$payment->set_customer( $customer );
		}

		CustomerHelper::complement_customer( $customer );

		// Billing address.
		$billing_address = $payment->get_billing_address();

		if ( null !== $billing_address ) {
			AddressHelper::complement_address( $billing_address );
		}

		// Shipping address.
		$shipping_address = $payment->get_shipping_address();

		if ( null !== $shipping_address ) {
			AddressHelper::complement_address( $shipping_address );
		}

		// Version.
		if ( null === $payment->get_version() ) {
			$payment->set_version( pronamic_pay_plugin()->get_version() );
		}

		// Post data.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		self::process_payment_input_data( $payment, $_POST );

		// Gender.
		if ( null !== $customer->get_gender() ) {
			$payment->delete_meta( 'gender' );
		}

		// Date of birth.
		if ( null !== $customer->get_birth_date() ) {
			$payment->delete_meta( 'birth_date' );
		}

		/**
		 * If an issuer has been specified and the payment
		 * method is unknown, we set the payment method to
		 * iDEAL. This may not be correct in all cases,
		 * but for now Pronamic Pay works this way.
		 *
		 */
		$issuer = $payment->get_meta( 'issuer' );

		$payment_method = $payment->get_payment_method();

		if ( null !== $issuer && null === $payment_method ) {
			$payment->set_payment_method( PaymentMethods::IDEAL );
		}

		// Consumer bank details.
		$consumer_bank_details_name = $payment->get_meta( 'consumer_bank_details_name' );
		$consumer_bank_details_iban = $payment->get_meta( 'consumer_bank_details_iban' );

		if ( null !== $consumer_bank_details_name || null !== $consumer_bank_details_iban ) {
			$consumer_bank_details = $payment->get_consumer_bank_details();

			if ( null === $consumer_bank_details ) {
				$consumer_bank_details = new BankAccountDetails();
			}

			if ( null === $consumer_bank_details->get_name() ) {
				$consumer_bank_details->set_name( $consumer_bank_details_name );
			}

			if ( null === $consumer_bank_details->get_iban() ) {
				$consumer_bank_details->set_iban( $consumer_bank_details_iban );
			}

			$payment->set_consumer_bank_details( $consumer_bank_details );
		}

		// Payment lines payment.
		$lines = $payment->get_lines();

		if ( null !== $lines ) {
			foreach ( $lines as $line ) {
				$line->set_payment( $payment );
			}
		}
	}

	/**
	 * Process payment input data.
	 *
	 * @param Payment $payment Payment.
	 * @param array   $data    Data.
	 * @return void
	 */
	private static function process_payment_input_data( Payment $payment, $data ) {
		$gateway = $payment->get_gateway();

		if ( null === $gateway ) {
			return;
		}

		$payment_method = $payment->get_payment_method();

		if ( null === $payment_method ) {
			return;
		}

		$payment_method = $gateway->get_payment_method( $payment_method );

		if ( null === $payment_method ) {
			return;
		}

		foreach ( $payment_method->get_fields() as $field ) {
			$id = $field->get_id();

			if ( \array_key_exists( $id, $data ) ) {
				$value = $data[ $id ];

				$value = \sanitize_text_field( \wp_unslash( $value ) );

				if ( '' !== $field->meta_key ) {
					$payment->set_meta( $field->meta_key, $value );
				}
			}
		}
	}

	/**
	 * Get default gateway configuration ID.
	 *
	 * @return int|null
	 */
	private static function get_default_config_id() {
		$value = (int) \get_option( 'pronamic_pay_config_id' );

		if ( 0 === $value ) {
			return null;
		}

		if ( 'publish' !== \get_post_status( $value ) ) {
			return null;
		}

		return $value;
	}

	/**
	 * Start payment.
	 *
	 * @param Payment $payment The payment to start at the specified gateway.
	 * @return Payment
	 * @throws \Exception Throws exception if gateway payment start fails.
	 */
	public static function start_payment( Payment $payment ) {
		// Set default or filtered config ID.
		$config_id = $payment->get_config_id();

		if ( null === $config_id ) {
			$config_id = self::get_default_config_id();
		}

		/**
		 * Filters the payment gateway configuration ID.
		 *
		 * @param null|int $config_id Gateway configuration ID.
		 * @param Payment  $payment   Payment.
		 */
		$config_id = \apply_filters( 'wpayo_payment_gateway_configuration_id', $config_id, $payment );

		if ( null !== $config_id ) {
			$payment->set_config_id( $config_id );
		}

		// Save payment.
		$payment->save();

		// Periods.
		$periods = $payment->get_periods();

		if ( null !== $periods ) {
			foreach ( $periods as $period ) {
				$subscription = $period->get_phase()->get_subscription();

				$subscription->set_next_payment_date( \max( $subscription->get_next_payment_date(), $period->get_end_date() ) );
			}
		}

		// Subscriptions.
		$subscriptions = $payment->get_subscriptions();

		foreach ( $subscriptions as $subscription ) {
			$subscription->save();
		}

		// Gateway.
		$gateway = $payment->get_gateway();

		if ( null === $gateway ) {
			$payment->add_note(
				\sprintf(
					/* translators: %d: Gateway configuration ID */
					__( 'Payment failed because gateway configuration with ID `%d` does not exist.' ),
					$config_id
				)
			);

			$payment->set_status( PaymentStatus::FAILURE );

			$payment->save();

			return $payment;
		}

		// Mode.
		$payment->set_mode( $gateway->get_mode() );

		// Subscriptions.
		$subscriptions = $payment->get_subscriptions();

		// Start payment at the gateway.
		try {
			self::pronamic_service( $payment );

			$gateway->start( $payment );
		} catch ( \Exception $exception ) {
			$message = $exception->getMessage();

			// Maybe include error code in message.
			$code = $exception->getCode();

			if ( $code > 0 ) {
				$message = \sprintf( '%s: %s', $code, $message );
			}

			$payment->add_note( $message );

			$payment->set_status( PaymentStatus::FAILURE );

			throw $exception;
		} finally {
			$payment->save();
		}

		// Schedule payment status check.
		if ( $gateway->supports( 'payment_status_request' ) ) {
			StatusChecker::schedule_event( $payment );
		}

		return $payment;
	}

	/**
	 * The Pronamic Pay service forms an abstraction layer for the various supported
	 * WordPress plugins and Payment Service Providers (PSP. Optionally, a risk analysis
	 * can be performed before payment.
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	private static function pronamic_service( Payment $payment ) {
		if ( null === self::$pronamic_service_url ) {
			return;
		}

		try {
			$body = [
				'license' => \get_option( 'pronamic_pay_license_key' ),
				'payment' => \wp_json_encode( $payment->get_json() ),
			];

			$map = [
				'query'  => 'GET',
				'body'   => 'POST',
				'server' => 'SERVER',
			];

			foreach ( $map as $parameter => $key ) {
				$name = '_' . $key;

				$body[ $parameter ] = $GLOBALS[ $name ];
			}

			$response = Http::post(
				self::$pronamic_service_url,
				[
					'body' => $body,
				]
			);

			$data = $response->json();

			if ( ! \is_object( $data ) ) {
				return;
			}

			if ( \property_exists( $data, 'id' ) ) {
				$payment->set_meta( 'pronamic_pay_service_id', $data->id );
			}

			if ( \property_exists( $data, 'risk_score' ) ) {
				$payment->set_meta( 'pronamic_pay_risk_score', $data->risk_score );
			}
		} catch ( \Exception $e ) {
			return;
		}
	}

	/**
	 * Create refund.
	 *
	 * @param Refund $refund Refund.
	 * @return void
	 * @throws \Exception Throws exception on error.
	 */
	public static function create_refund( Refund $refund ) {
		$payment = $refund->get_payment();

		$gateway = $payment->get_gateway();

		if ( null === $gateway ) {
			throw new \Exception( __( 'Unable to process refund as gateway could not be found.', 'wpayo' ) );
		}

		try {
			$gateway->create_refund( $refund );

			$payment->refunds[] = $refund;

			$refunded_amount = $payment->get_refunded_amount();

			$refunded_amount = $refunded_amount->add( $refund->get_amount() );

			$payment->set_refunded_amount( $refunded_amount );
		} catch ( \Exception $exception ) {
			$payment->add_note( $exception->getMessage() );

			throw $exception;
		} finally {
			$payment->save();
		}
	}

	/**
	 * Payment redirect URL.
	 *
	 * @param string  $url     Redirect URL.
	 * @param Payment $payment Payment.
	 * @return string
	 */
	public function payment_redirect_url( $url, Payment $payment ) {
		$source = $payment->get_source();

		/**
		 * Filters the payment redirect URL by plugin integration source.
		 *
		 * @param string  $url     Redirect URL.
		 * @param Payment $payment Payment.
		 */
		$url = \apply_filters( 'wpayo_payment_redirect_url_' . $source, $url, $payment );

		return $url;
	}

	/**
	 * Is debug mode.
	 *
	 * @link https://github.com/easydigitaldownloads/easy-digital-downloads/blob/2.9.26/includes/misc-functions.php#L26-L38
	 * @return bool True if debug mode is enabled, false otherwise.
	 */
	public function is_debug_mode() {
		$value = \get_option( 'pronamic_pay_debug_mode', false );

		if ( defined( '\PRONAMIC_PAY_DEBUG' ) && PRONAMIC_PAY_DEBUG ) {
			$value = true;
		}

		return (bool) $value;
	}
}
