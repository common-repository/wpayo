<?php
/**
 * Meta Box Payment Notes
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay;

use Pronamic\WordPress\DateTime\DateTime;
use Pronamic\WordPress\DateTime\DateTimeZone;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! isset( $notes ) ) {
	return;
}

if ( ! is_array( $notes ) ) {
	return;
}

if ( empty( $notes ) ) : ?>

	<?php esc_html_e( 'No notes found.', 'wpayo' ); ?>

<?php else : ?>

	<table class="pronamic-pay-table widefat">
		<thead>
			<tr>
				<th scope="col"><?php esc_html_e( 'Date', 'wpayo' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Note', 'wpayo' ); ?></th>
				<th scope="col"><?php esc_html_e( 'User', 'wpayo' ); ?></th>
			</tr>
		</thead>

		<tbody>

			<?php foreach ( $notes as $note ) : ?>

				<tr>
					<td>
						<?php

						$date = new DateTime( $note->comment_date_gmt, new DateTimeZone( 'UTC' ) );

						echo esc_html( $date->format_i18n() );

						?>
					</td>
					<td>
						<?php comment_text( $note ); ?>
					</td>
					<td>
						<?php comment_author( $note ); ?>
					</td>
				</tr>

			<?php endforeach; ?>

		</tbody>
	</table>

<?php endif; ?>
