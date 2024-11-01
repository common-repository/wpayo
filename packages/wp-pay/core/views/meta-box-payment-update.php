<?php
/**
 * Meta Box Payment Update
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Payments\PaymentPostType;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! isset( $post ) ) {
	return;
}

$states = PaymentPostType::get_payment_states();

$payment = get_wpayo_payment( get_the_ID() );

if ( null === $payment ) {
	return;
}

ksort( $states );

// WordPress by default doesn't allow `post_author` values of `0`, that's why we use a dash (`-`).
// @link https://github.com/WordPress/WordPress/blob/4.9.5/wp-admin/includes/post.php#L56-L64.
$post_author = get_post_field( 'post_author' );
$post_author = empty( $post_author ) ? '-' : $post_author;

?>
<input type="hidden" name="post_author_override" value="<?php echo esc_attr( $post_author ); ?>" />

<div class="pronamic-pay-inner">
	<div id="minor-publishing-actions">
		<div class="clear"></div>
	</div>

	<div class="pronamic-pay-minor-actions">
		<div class="misc-pub-section misc-pub-post-status">
			<?php echo esc_html( __( 'Status:', 'wpayo' ) ); ?>

			<?php

			$status_object = get_post_status_object( $post->post_status );

			$status_label = isset( $status_object, $status_object->label ) ? $status_object->label : '—';

			?>

			<span id="pronamic-pay-post-status-display"><?php echo esc_html( $status_label ); ?></span>

			<a href="#pronamic-pay-post-status" class="edit-pronamic-pay-post-status hide-if-no-js" role="button">
				<span aria-hidden="true"><?php esc_html_e( 'Edit', 'wpayo' ); ?></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Edit status', 'wpayo' ); ?></span>
			</a>

			<div id="pronamic-pay-post-status-input" class="hide-if-js">
				<input type="hidden" name="hidden_pronamic_pay_post_status" id="hidden_pronamic_pay_post_status" value="<?php echo esc_attr( ( 'auto-draft' === $post->post_status ) ? 'draft' : $post->post_status ); ?>" />
				<label for="pronamic-pay-post-status" class="screen-reader-text"><?php esc_html_e( 'Set status' ); ?></label>
				<select id="pronamic-pay-post-status" name="wpayo_payment_post_status">
					<?php

					foreach ( $states as $payment_status => $label ) {
						printf(
							'<option value="%s" %s>%s</option>',
							esc_attr( $payment_status ),
							selected( $payment_status, $post->post_status, false ),
							esc_html( $label )
						);
					}

					?>
				</select>

				<a href="#pronamic-pay-post-status" class="save-pronamic-pay-post-status hide-if-no-js button"><?php esc_html_e( 'OK' ); ?></a>
				<a href="#pronamic-pay-post-status" class="cancel-pronamic-pay-post-status hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel' ); ?></a>
			</div>
		</div>

		<?php

		$gateway = $payment->get_gateway();

		/**
		 * Check status button.
		 */
		if ( null !== $gateway && $gateway->supports( 'payment_status_request' ) ) {
			// Only show button if gateway exists and status check is supported.
			$action_url = wp_nonce_url(
				add_query_arg(
					[
						'post'                      => $post->ID,
						'action'                    => 'edit',
						'pronamic_pay_check_status' => true,
					],
					admin_url( 'post.php' )
				),
				'wpayo_payment_check_status_' . $post->ID
			);

			printf(
				'<div class="misc-pub-section"><a class="button" href="%s">%s</a></div>',
				esc_url( $action_url ),
				esc_html__( 'Check status', 'wpayo' )
			);
		}

		/**
		 * Send to Google Analytics button.
		 */
		$can_track = pronamic_pay_plugin()->google_analytics_ecommerce->valid_payment( $payment );

		if ( $can_track ) {
			// Only show button for payments that can be tracked.
			$action_url = wp_nonce_url(
				add_query_arg(
					[
						'post'                  => $post->ID,
						'action'                => 'edit',
						'pronamic_pay_ga_track' => true,
					],
					admin_url( 'post.php' )
				),
				'wpayo_payment_ga_track_' . $post->ID
			);

			printf(
				'<div class="misc-pub-section"><a class="button" href="%s">%s</a></div>',
				esc_url( $action_url ),
				esc_html__( 'Send to Google Analytics', 'wpayo' )
			);
		}

		?>
	</div>
</div>

<div class="pronamic-pay-major-actions">
	<div class="pronamic-pay-action">
		<?php

		wp_nonce_field( 'wpayo_payment_update', 'wpayo_payment_nonce' );

		submit_button(
			__( 'Update', 'wpayo' ),
			'primary',
			'wpayo_payment_update',
			false
		);

		?>
	</div>

	<div class="clear"></div>
</div>
