<?php
/**
 * Home URL Controller
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay;

/**
 * Home URL Controller class
 */
class HomeUrlController {
	/**
	 * Setup.
	 *
	 * @return void
	 */
	public function setup() {
		\add_action( 'init', [ $this, 'init' ] );

		\add_action( 'admin_init', [ $this, 'admin_init' ] );

		\add_action( 'admin_notices', [ $this, 'admin_notices' ] );
	}

	/**
	 * Initialize.
	 *
	 * @return void
	 */
	public function init() {
		$option = \get_option( 'pronamic_pay_home_url', null );

		if ( null === $option ) {
			\update_option( 'pronamic_pay_home_url', \home_url() );
		}

		\register_setting(
			'pronamic_pay',
			'pronamic_pay_home_url',
			[
				'type'              => 'string',
				'description'       => \__( 'Home URL setting to detect changes in the WordPress home URL.', 'wpayo' ),
				'sanitize_callback' => 'sanitize_url',
				'default'           => \home_url(),
			]
		);
	}

	/**
	 * Admin notices.
	 *
	 * @return void
	 */
	public function admin_notices() {
		if ( \home_url() === \get_option( 'pronamic_pay_home_url' ) ) {
			return;
		}

		$dismiss_notification_url = \add_query_arg( 'pronamic_pay_dismiss_home_url_change', true );
		$dismiss_notification_url = \wp_nonce_url( $dismiss_notification_url, 'pronamic_pay_dismiss_home_url_change', 'pronamic_pay_dismiss_home_url_change_nonce' );

		?>
		<div class="error notice is-dismissible">
			<p>
				<strong><?php esc_html_e( 'WPayo', 'wpayo' ); ?></strong> —
				<?php

				echo \esc_html(
					\sprintf(
						/* translators: 1: Pronamic Pay home URL option, 2: home URL */
						__( 'We noticed the WordPress home URL has changed from "%1$s" to "%2$s". Please verify the payment gateway settings. For example, you might want to switch between live and test mode or need to update an URL at the gateway to continue receiving payment status updates. Also keep an eye on pending payments to discover possible configuration issues.', 'wpayo' ),
						\get_option( 'pronamic_pay_home_url' ),
						\home_url()
					)
				);

				?>
			</p>

			<?php

			$modules = \apply_filters( 'pronamic_pay_modules', [] );

			if ( \in_array( 'subscriptions', $modules, true ) ) {

				printf(
					'<p>%s</p>',
					\esc_html__( 'If you use subscriptions, you may want to update processing of recurring payments in the plugin debug settings to prevent duplicate payments being started in a development environment.', 'wpayo' )
				);

			}

			?>

			<p>
				<strong><a href="<?php echo \esc_url( \add_query_arg( 'post_type', 'wpayo_gateway', \get_admin_url( null, 'edit.php' ) ), ); ?>"><?php \esc_html_e( 'Payment Gateway Configurations', 'wpayo' ); ?></a></strong>
			</p>

			<a href="<?php echo \esc_url( $dismiss_notification_url ); ?>" class="notice-dismiss"><span class="screen-reader-text"><?php \esc_html_e( 'Dismiss this notice.', 'wpayo' ); ?></span></a>
		</div>
		<?php
	}

	/**
	 * Maybe dismiss notification.
	 *
	 * @link https://github.com/woocommerce/woocommerce/blob/c3405cf06f7ddea3aad2185dc8541955853c2575/plugins/woocommerce/includes/admin/class-wc-admin-notices.php#L160-L181
	 * @return void
	 */
	public function admin_init() {
		if ( ! \array_key_exists( 'pronamic_pay_dismiss_home_url_change', $_GET ) ) {
			return;
		}

		if ( ! \array_key_exists( 'pronamic_pay_dismiss_home_url_change_nonce', $_GET ) ) {
			return;
		}

		$nonce = \sanitize_text_field( \wp_unslash( $_GET['pronamic_pay_dismiss_home_url_change_nonce'] ) );

		if ( ! \wp_verify_nonce( $nonce, 'pronamic_pay_dismiss_home_url_change' ) ) {
			\wp_die( \esc_html__( 'Action failed. Please refresh the page and retry.', 'wpayo' ) );
		}

		if ( ! \current_user_can( 'manage_options' ) ) {
			\wp_die( \esc_html__( 'You don’t have permission to do this.', 'wpayo' ) );
		}

		$result = \update_option( 'pronamic_pay_home_url', \home_url() );

		if ( false === $result ) {
			\wp_die( \esc_html__( 'Action failed. Please refresh the page and retry.', 'wpayo' ) );
		}

		// Redirect.
		$url = \add_query_arg(
			[
				'pronamic_pay_dismiss_home_url_change'   => false,
				'pronamic_pay_dismiss_home_url_change_nonce' => false,
				'pronamic_pay_dismissed_home_url_change' => true,
			],
			\wp_get_referer()
		);

		\wp_safe_redirect( $url );

		exit;
	}
}
