<?php
/**
 * Meta Box Payment Refunds
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( empty( $payment->refunds ) ) : ?>

	<p>
		<?php \esc_html_e( 'No refunds found for this payment.', 'wpayo' ); ?>
	</p>

<?php else : ?>

	<div class="pronamic-pay-table-responsive">
		<table class="pronamic-pay-table widefat">
			<thead>
				<tr>
					<th scope="col"><?php \esc_html_e( 'Date', 'wpayo' ); ?></th>
					<th scope="col"><?php \esc_html_e( 'Amount', 'wpayo' ); ?></th>
					<th scope="col"><?php \esc_html_e( 'PSP ID', 'wpayo' ); ?></th>
					<th scope="col"><?php \esc_html_e( 'Description', 'wpayo' ); ?></th>
					<th scope="col"><?php \esc_html_e( 'User', 'wpayo' ); ?></th>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>

			<tbody>

				<?php foreach ( $payment->refunds as $refund ) : ?>

					<tr>
						<td><?php echo \esc_html( $refund->created_at->format_i18n() ); ?></td>
						<td><?php echo \esc_html( $refund->get_amount()->format_i18n() ); ?></td>
						<td><?php echo \esc_html( $refund->psp_id ); ?></td>
						<td><?php echo \esc_html( $refund->get_description() ); ?></td>
						<td>
							<?php

							$name = __( 'Unknown', 'wpayo' );

							if ( $refund->created_by->ID > 0 ) {
								$name = $refund->created_by->display_name;
							}

							echo \esc_html( $name );

							?>
						</td>
					</tr>

				<?php endforeach; ?>

			</tbody>
		</table>
	</div>

<?php endif; ?>
