<?php
/**
 * Widget Payment Status List
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$counts = \wp_count_posts( 'wpayo_payment' );

$states = [
	/* translators: %s: posts count value */
	'payment_completed' => __( '%s completed', 'wpayo' ),
	/* translators: %s: posts count value */
	'payment_pending'   => __( '%s pending', 'wpayo' ),
	/* translators: %s: posts count value */
	'payment_cancelled' => __( '%s cancelled', 'wpayo' ),
	/* translators: %s: posts count value */
	'payment_failed'    => __( '%s failed', 'wpayo' ),
	/* translators: %s: posts count value */
	'payment_expired'   => __( '%s expired', 'wpayo' ),
];

$url = \add_query_arg(
	[
		'post_type' => 'wpayo_payment',
	],
	\admin_url( 'edit.php' )
);

?>
<div class="pronamic-pay-status-widget">
	<ul class="pronamic-pay-status-list">

		<?php foreach ( $states as $payment_status => $label ) : ?>

			<li class="<?php echo \esc_attr( 'payment_status-' . $payment_status ); ?>">
				<a href="<?php echo \esc_url( \add_query_arg( 'post_status', $payment_status, $url ) ); ?>">
					<?php

					$count = isset( $counts->$payment_status ) ? $counts->$payment_status : 0;

					\printf(
                        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						$label,
						'<strong>' . \sprintf(
							/* translators: %s: Number payments */
							\esc_html( \_n( '%s payment', '%s payments', $count, 'wpayo' ) ),
							\esc_html( \number_format_i18n( $count ) )
						) . '</strong>'
					);

					?>
				</a>
			</li>

		<?php endforeach; ?>

	</ul>
</div>
