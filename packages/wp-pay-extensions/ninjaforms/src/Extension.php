<?php
/**
 * Extension
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Extensions\NinjaForms
 */

namespace Pronamic\WordPress\Pay\Extensions\NinjaForms;

use Pronamic\WordPress\Pay\AbstractPluginIntegration;
use Pronamic\WordPress\Pay\Payments\Payment;
use Pronamic\WordPress\Pay\Payments\PaymentStatus;
use ReflectionClass;

/**
 * Extension
 *
 * @version 1.5.1
 * @since   1.0.0
 */
class Extension extends AbstractPluginIntegration {
	/**
	 * Slug
	 *
	 * @var string
	 */
	const SLUG = 'ninja-forms';

	/**
	 * Construct Ninja Forms plugin integration.
	 */
	public function __construct() {
		parent::__construct(
			[
				'name' => __( 'Ninja Forms', 'wpayo' ),
			]
		);

		// Dependencies.
		$dependencies = $this->get_dependencies();

		$dependencies->add( new NinjaFormsDependency() );
	}

	/**
	 * Setup.
	 */
	public function setup() {
		\add_filter( 'wpayo_payment_source_description_' . self::SLUG, [ $this, 'source_description' ], 10, 2 );
		\add_filter( 'wpayo_payment_source_text_' . self::SLUG, [ $this, 'source_text' ], 10, 2 );

		// Check if dependencies are met and integration is active.
		if ( ! $this->is_active() ) {
			return;
		}

		\add_filter( 'wpayo_payment_source_url_' . self::SLUG, [ $this, 'source_url' ], 10, 2 );
		\add_filter( 'wpayo_payment_redirect_url_' . self::SLUG, [ $this, 'redirect_url' ], 10, 2 );
		\add_action( 'wpayo_payment_status_update_' . self::SLUG, [ $this, 'update_status' ] );

		\add_filter( 'ninja_forms_field_type_sections', [ $this, 'field_type_sections' ] );
		\add_filter( 'ninja_forms_register_fields', [ $this, 'register_fields' ], 10, 3 );
		\add_filter( 'ninja_forms_register_payment_gateways', [ $this, 'register_payment_gateways' ], 10, 1 );
		\add_filter( 'ninja_forms_field_settings_groups', [ $this, 'register_settings_groups' ] );

		// Delayed actions.
		\add_filter( 'ninja_forms_submission_actions', [ $this, 'submission_actions' ], 10, 3 );
		\add_action( 'ninja_forms_before_response', [ $this, 'maybe_update_session_before_response' ], 10, 1 );
	}

	/**
	 * Filter field type sections.
	 *
	 * @param array $sections Field type sections.
	 *
	 * @return array
	 */
	public function field_type_sections( $sections ) {
		$sections['pronamic_pay'] = [
			'id'         => 'pronamic_pay',
			'nicename'   => __( 'Pronamic Pay', 'wpayo' ),
			'fieldTypes' => [],
		];

		return $sections;
	}

	/**
	 * Register custom fields
	 *
	 * @param array $fields Fields from Ninja Forms.
	 * @return array $fields
	 */
	public function register_fields( $fields ) {
		$fields['pronamic_pay_payment_method'] = new PaymentMethodsField();
		$fields['pronamic_pay_issuer']         = new IssuersField();

		return $fields;
	}

	/**
	 * Register payment gateways.
	 *
	 * @param array $gateways Payment gateways.
	 *
	 * @return array
	 */
	public function register_payment_gateways( $gateways ) {
		$gateways['pronamic_pay'] = new PaymentGateway();

		return $gateways;
	}

	/**
	 * Register settings groups.
	 *
	 * @param array $groups Settings groups.
	 *
	 * @return array
	 */
	public function register_settings_groups( $groups ) {
		$groups['pronamic_pay'] = [
			'id'       => 'pronamic_pay',
			'label'    => __( 'Pronamic Pay', 'wpayo' ),
			'priority' => 200,
		];

		return $groups;
	}

	/**
	 * Update lead status of the specified payment
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	public function update_status( Payment $payment ) {
		switch ( $payment->status ) {
			case PaymentStatus::SUCCESS:
				// Fulfill order.
				$this->fulfill_order( $payment );

				break;
		}
	}

	/**
	 * Fulfill order.
	 *
	 * @param Payment $payment Payment.
	 */
	public function fulfill_order( $payment ) {
		// Check if already fulfilled.
		$is_fulfilled = (int) $payment->get_meta( 'ninjaforms_fulfilled' );

		if ( 1 === $is_fulfilled ) {
			return;
		}

		// Check session cookie.
		$session_cookie = $payment->get_meta( 'ninjaforms_session_cookie' );

		if ( empty( $session_cookie ) ) {
			return;
		}

		$session_cookie = \urldecode( $session_cookie );

		// Check form ID.
		$form_id = $payment->get_meta( 'ninjaforms_payment_form_id' );

		if ( empty( $form_id ) ) {
			return;
		}

		// Init Ninja Forms session.
		$wp_session_cookie = 'nf_wp_session';

		if ( defined( '\WP_SESSION_COOKIE' ) ) {
			$wp_session_cookie = \WP_SESSION_COOKIE;
		}

		$session_cookie_temp = null;

		if ( \array_key_exists( $wp_session_cookie, $_COOKIE ) ) {
			$session_cookie_temp = \sanitize_text_field( \wp_unslash( $_COOKIE[ $wp_session_cookie ] ) );
		}

		$_COOKIE[ $wp_session_cookie ] = $session_cookie;

		\Ninja_Forms()->session();

		// Set up fields merge tags to prevent empty default email.
		try {
			$fields = \Ninja_Forms()->merge_tags['fields'];

			$fields_reflection = new ReflectionClass( $fields );

			$merge_tags_prop = $fields_reflection->getProperty( 'merge_tags' );
			$merge_tags_prop->setAccessible( true );

			$merge_tags = array_merge(
				$merge_tags_prop->getValue( $fields ),
				\Ninja_Forms()->config( 'MergeTagsFieldsAJAX' )
			);

			$merge_tags_prop->setValue( $fields, $merge_tags );
		} catch ( \Exception $e ) {
			// Nothing to do.
		}

		// Set `nf_resume` for Ninja Forms to continue processing form actions.
		$_POST['nf_resume'] = $form_id;

		define( 'PRONAMIC_PAY_NINJA_FORMS_RESUME', true );

		// Prevent `wp_die()` in Ninja Forms response to exit script execution.
		\add_filter(
			'wp_die_handler',
			function( $handler ) {
				return '__return_true';
			}
		);

		// Resume processing form actions.
		ob_start();

		\Ninja_Forms()->controllers['submission']->resume();

		\ob_end_clean();

		// Delete session.
		\Ninja_Forms()->session()->delete();

		// Unset/restore session cookie.
		unset( $_COOKIE[ $wp_session_cookie ] );

		if ( null !== $session_cookie_temp ) {
			$_COOKIE[ $wp_session_cookie ] = $session_cookie_temp;
		}

		$payment->set_meta( 'ninjaforms_fulfilled', true );
	}

	/**
	 * Maybe delay actions.
	 *
	 * @param array $actions    Actions.
	 * @param array $form_cache Form cache.
	 * @param array $form_data  Form data.
	 * @return array
	 */
	public function submission_actions( $actions, $form_cache, $form_data ) {
		// Find active 'Collect payment' actions with our gateway.
		$collect_settings = null;

		foreach ( $actions as $action ) {
			$action_settings = $action['settings'];

			// Check if action is active.
			if ( 0 === (int) $action_settings['active'] ) {
				continue;
			}

			// Check 'Collect Payment' action type.
			if ( 'collectpayment' !== $action_settings['type'] ) {
				continue;
			}

			// Check Pronamic Pay gateway.
			if ( 'pronamic_pay' !== $action_settings['payment_gateways'] ) {
				continue;
			}

			$delayed_action_ids = NinjaFormsHelper::get_delayed_action_ids_from_settings( $action['settings'] );

			if ( empty( $delayed_action_ids ) ) {
				continue;
			}

			// Set collect payment settings.
			// @todo consider conditional logic when getting the 'Collect payment' action.
			$collect_settings = $action['settings'];

			break;
		}

		// Check 'Collect Payment' action with delayed actions.
		if ( null === $collect_settings ) {
			return $actions;
		}

		$is_resuming = \defined( 'PRONAMIC_PAY_NINJA_FORMS_RESUME' ) && PRONAMIC_PAY_NINJA_FORMS_RESUME;

		// Update session with data for later processing of delayed actions.
		if ( ! $is_resuming ) {
			\Ninja_Forms()->session()->set( 'nf_processing_form_cache', $form_cache );
			\Ninja_Forms()->session()->set( 'nf_processing_form_data', $form_data );
		}

		// Update action activation status for delayed actions.
		$delayed_action_ids = NinjaFormsHelper::get_delayed_action_ids_from_settings( $collect_settings );

		foreach ( $actions as &$action ) {
			// Ignore inactive actions.
			if ( 0 === (int) $action['settings']['active'] ) {
				continue;
			}

			// Check if action should be delayed.
			if ( ! \in_array( $action['id'], $delayed_action_ids, true ) ) {
				continue;
			}

			// Set active status based on whether we're resuming.
			$action['settings']['active'] = $is_resuming;
		}

		return $actions;
	}

	/**
	 * Maybe update Ninja Forms session before response.
	 *
	 * @param array $data Data.
	 * @return void
	 */
	public function maybe_update_session_before_response( $data ) {
		// Check if there are delayed actions.
		if ( false === \Ninja_Forms()->session()->get( 'pronamic_pay_has_delayed_actions' ) ) {
			return;
		}

		// Check if resuming, because we don't want to update the session then.
		$is_resuming = \defined( 'PRONAMIC_PAY_NINJA_FORMS_RESUME' ) && PRONAMIC_PAY_NINJA_FORMS_RESUME;

		if ( $is_resuming ) {
			return;
		}

		// Update Ninja Forms session to be able to fulfill delayed actions later.
		Ninja_Forms()->session()->set( 'nf_processing_data', $data );
	}

	/**
	 * Payment redirect URL filter.
	 *
	 * @param string  $url     Redirect URL.
	 * @param Payment $payment Payment.
	 *
	 * @return string
	 * @since 1.1.1
	 */
	public function redirect_url( $url, $payment ) {
		$form_id   = $payment->get_meta( 'ninjaforms_payment_form_id' );
		$action_id = $payment->get_meta( 'ninjaforms_payment_action_id' );

		if ( empty( $form_id ) || empty( $action_id ) ) {
			return $url;
		}

		$action_settings = Ninja_Forms()->form( $form_id )->get_action( $action_id )->get_settings();

		$status_url = null;

		switch ( $payment->status ) {
			case PaymentStatus::CANCELLED:
				$status_url = NinjaFormsHelper::get_page_link_from_action_settings( $action_settings, 'pronamic_pay_cancel_page_id' );

				break;
			case PaymentStatus::EXPIRED:
				$status_url = NinjaFormsHelper::get_page_link_from_action_settings( $action_settings, 'pronamic_pay_expired_page_id' );

				break;
			case PaymentStatus::FAILURE:
				$status_url = NinjaFormsHelper::get_page_link_from_action_settings( $action_settings, 'pronamic_pay_error_page_id' );

				break;
			case PaymentStatus::SUCCESS:
				$status_url = NinjaFormsHelper::get_page_link_from_action_settings( $action_settings, 'pronamic_pay_completed_page_id' );

				break;
			case PaymentStatus::OPEN:
			default:
				$status_url = NinjaFormsHelper::get_page_link_from_action_settings( $action_settings, 'pronamic_pay_unknown_page_id' );

				break;
		}

		if ( ! empty( $status_url ) ) {
			return $status_url;
		}

		return $url;
	}

	/**
	 * Source URL.
	 *
	 * @param string  $url     Source URL.
	 * @param Payment $payment Payment.
	 *
	 * @return string
	 */
	public function source_url( $url, Payment $payment ) {
		$source_id = $payment->get_source_id();

		if ( empty( $source_id ) ) {
			return $url;
		}

		$source_id = intval( $source_id );

		// Source ID could be a submission ID.
		if ( 'nf_sub' === get_post_type( $source_id ) ) {
			$url = add_query_arg(
				[
					'post'   => $source_id,
					'action' => 'edit',
				],
				admin_url( 'post.php' )
			);
		}

		return $url;
	}

	/**
	 * Source text.
	 *
	 * @param string  $text    Source text.
	 * @param Payment $payment Payment.
	 *
	 * @return string
	 */
	public function source_text( $text, Payment $payment ) {
		$text = __( 'Ninja Forms', 'wpayo' ) . '<br />';

		$source_id = $payment->get_source_id();

		if ( empty( $source_id ) ) {
			return $text;
		}

		$source_id = intval( $source_id );

		if ( 'nf_sub' === get_post_type( $source_id ) ) {
			$text .= sprintf(
				'<a href="%s">%s</a>',
				add_query_arg(
					[
						'post'   => $source_id,
						'action' => 'edit',
					],
					admin_url( 'post.php' )
				),
				/* translators: %s: source id */
				sprintf( __( 'Entry #%s', 'wpayo' ), $source_id )
			);
		} else {
			/* translators: %s: payment source id */
			$text .= sprintf( __( '#%s', 'wpayo' ), $source_id );
		}

		return $text;
	}

	/**
	 * Source description.
	 *
	 * @param string  $description Description.
	 * @param Payment $payment     Payment.
	 *
	 * @return string
	 */
	public function source_description( $description, Payment $payment ) {
		$description = __( 'Ninja Forms', 'wpayo' );

		$source_id = $payment->get_source_id();

		if ( empty( $source_id ) ) {
			return $description;
		}

		$source_id = intval( $source_id );

		if ( 'nf_sub' === get_post_type( $source_id ) ) {
			$description = __( 'Ninja Forms Entry', 'wpayo' );
		}

		return $description;
	}
}
