<?php
/**
 * Meta Box Gateway Test
 *
 * @author Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license GPL-3.0-or-later
 * @package Pronamic\WordPress\Pay
 * @var \WP_Post $post WordPress post.
 */

use Pronamic\WordPress\Money\Currencies;
use Pronamic\WordPress\Money\Currency;
use Pronamic\WordPress\Pay\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$gateway = Plugin::get_gateway( $post->ID );

if ( null === $gateway ) {
	printf(
		'<em>%s</em>',
		esc_html( __( 'Please save the entered account details of your payment provider, to make a test payment.', 'wpayo' ) )
	);

	return;
}

wp_nonce_field( 'test_pay_gateway', 'pronamic_pay_test_nonce' );

$currency_default = Currency::get_instance( 'USD' );

$payment_methods = $gateway->get_payment_methods(
	[
		'status' => [
			'',
			'active',
		],
	]
);

?>
<table class="form-table">
	<tr>
		<th scope="row">
			<label for="pronamic-pay-test-payment-methods">
				<?php esc_html_e( 'Payment Method', 'wpayo' ); ?>
			</label>
		</th>
		<td>
			<select id="pronamic-pay-test-payment-methods" name="pronamic_pay_test_payment_method">
				<?php if ( count( $payment_methods ) > 1 ) : ?>

					<option value=""><?php esc_html_e( '— Choose payment method —', 'wpayo' ); ?></option>

				<?php endif; ?>

				<?php

				foreach ( $payment_methods as $payment_method ) {
					printf(
						'<option value="%s" data-is-recurring="%d">%s</option>',
						esc_attr( $payment_method->get_id() ),
						esc_attr( $payment_method->supports( 'recurring' ) ? '1' : ' 0' ),
						esc_html( $payment_method->get_name() )
					);
				}

				?>
			</select>
		</td>
	</tr>

	<?php foreach ( $payment_methods as $payment_method ) : ?>

		<?php foreach ( $payment_method->get_fields() as $field ) : ?>

			<tr class="pronamic-pay-cloack pronamic-pay-test-payment-method <?php echo esc_attr( $payment_method->get_id() ); ?>">
				<th scope="row">
					<?php echo esc_html( $field->get_label() ); ?>
				</th>
				<td>
					<?php

					try {
						$field->output();
					} catch ( \Exception $exception ) {
						echo '<em>';

						printf(
							/* translators: %s: Exception message. */
							esc_html__( 'This field could not be displayed due to the following error message: "%s".', 'wpayo' ),
							esc_html( $exception->getMessage() )
						);

						echo '</em>';

						?>
						<div class="error">
							<p>
								<?php

								echo wp_kses(
									sprintf(
										/* translators: 1: Field label, 2: Payment method name */
										__( '<strong>Pronamic Pay</strong> — An error occurred within the "%1$s" field of the "%2$s" payment method.', 'wpayo' ),
										esc_html( $field->get_label() ),
										esc_html( $payment_method->get_name() )
									),
									[
										'strong' => [],
									]
								);

								?>
							</p>

							<dl>
								<dt><?php esc_html_e( 'Message', 'wpayo' ); ?></dt>
								<dd><?php echo esc_html( $exception->getMessage() ); ?></dd>

								<?php if ( 0 !== $exception->getCode() ) : ?>

									<dt><?php esc_html_e( 'Code', 'wpayo' ); ?></dt>
									<dd><?php echo esc_html( $exception->getCode() ); ?></dd>

								<?php endif; ?>
							</dl>
						</div>
						<?php
					}

					?>
				</td>
			</tr>

		<?php endforeach; ?>

	<?php endforeach; ?>

	<tr>
		<th scope="row">
			<?php esc_html_e( 'Amount', 'wpayo' ); ?>
		</th>
		<td>
			<select name="test_currency_code">
				<?php

				foreach ( Currencies::get_currencies() as $currency ) {
					$label = $currency->get_alphabetic_code();

					$symbol = $currency->get_symbol();

					if ( null !== $symbol ) {
						$label = sprintf( '%s (%s)', $label, $symbol );
					}

					printf(
						'<option value="%s" %s>%s</option>',
						esc_attr( $currency->get_alphabetic_code() ),
						selected( $currency->get_alphabetic_code(), $currency_default->get_alphabetic_code(), false ),
						esc_html( $label )
					);
				}

				?>
			</select>

			<input name="test_amount" id="test_amount" class="regular-text code pronamic-pay-form-control" value="" type="number" step="any" size="6" autocomplete="off" />
		</td>
	</tr>

	<?php if ( $gateway->supports( 'recurring' ) ) : ?>

		<?php

		$options = [
			''  => __( '— Select Repeat —', 'wpayo' ),
			'D' => __( 'Daily', 'wpayo' ),
			'W' => __( 'Weekly', 'wpayo' ),
			'M' => __( 'Monthly', 'wpayo' ),
			'Y' => __( 'Annually', 'wpayo' ),
		];

		$options_interval_suffix = [
			'D' => __( 'days', 'wpayo' ),
			'W' => __( 'weeks', 'wpayo' ),
			'M' => __( 'months', 'wpayo' ),
			'Y' => __( 'year', 'wpayo' ),
		];

		?>
		<tr>
			<th scope="row">
				<label for="pronamic-pay-test-subscription">
					<?php esc_html_e( 'Subscription', 'wpayo' ); ?>
				</label>
			</th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_html_e( 'Test Subscription', 'wpayo' ); ?></span></legend>

					<label for="pronamic-pay-test-subscription">
						<input name="pronamic_pay_test_subscription" id="pronamic-pay-test-subscription" value="1" type="checkbox" />
						<?php esc_html_e( 'Start a subscription for this payment.', 'wpayo' ); ?>
					</label>
				</fieldset>

				<script type="text/javascript">
					jQuery( document ).ready( function( $ ) {
						$( '#pronamic-pay-test-subscription' ).change( function() {
							$( '.pronamic-pay-test-subscription' ).toggle( $( this ).prop( 'checked' ) );
						} );
					} );
				</script>
			</td>
		</tr>
		<tr class="pronamic-pay-cloack pronamic-pay-test-subscription">
			<th scope="row">
				<label for="pronamic_pay_test_repeat_frequency"><?php esc_html_e( 'Frequency', 'wpayo' ); ?></label>
			</th>
			<td>
				<select id="pronamic_pay_test_repeat_frequency" name="pronamic_pay_test_repeat_frequency">
					<?php

					foreach ( $options as $key => $label ) {
						$interval_suffix = '';

						if ( isset( $options_interval_suffix[ $key ] ) ) {
							$interval_suffix = $options_interval_suffix[ $key ];
						}

						printf(
							'<option value="%s" data-interval-suffix="%s">%s</option>',
							esc_attr( $key ),
							esc_attr( $interval_suffix ),
							esc_html( $label )
						);
					}

					?>
				</select>
			</td>
		</tr>
		<tr class="pronamic-pay-cloack pronamic-pay-test-subscription">
			<th scope="row">
				<label for="pronamic_pay_test_repeat_interval"><?php esc_html_e( 'Repeat every', 'wpayo' ); ?></label>
			</th>
			<td>
				<select id="pronamic_pay_test_repeat_interval" name="pronamic_pay_test_repeat_interval">
					<?php

					foreach ( range( 1, 30 ) as $value ) {
						printf(
							'<option value="%s">%s</option>',
							esc_attr( (string) $value ),
							esc_html( (string) $value )
						);
					}

					?>
				</select>

				<span id="pronamic_pay_test_repeat_interval_suffix"><?php esc_html_e( 'days/weeks/months/year', 'wpayo' ); ?></span>
			</td>
		</tr>
		<tr class="pronamic-pay-cloack pronamic-pay-test-subscription">
			<th scope="row">
				<?php esc_html_e( 'Ends On', 'wpayo' ); ?>
			</th>
			<td>
				<div>
					<input type="radio" id="pronamic_pay_ends_never" name="pronamic_pay_ends_on" value="never" checked="checked" />

					<label for="pronamic_pay_ends_never">
						<?php esc_html_e( 'Never', 'wpayo' ); ?>
					</label>
				</div>
				<div>
					<input type="radio" id="pronamic_pay_ends_count" name="pronamic_pay_ends_on" value="count" />

					<label for="pronamic_pay_ends_count">
						<?php

						$allowed_html = [
							'input' => [
								'id'    => true,
								'name'  => true,
								'type'  => true,
								'value' => true,
								'size'  => true,
								'class' => true,
							],
						];

						echo wp_kses(
							sprintf(
								/* translators: %s: Input field for number times */
								__( 'After %s times', 'wpayo' ),
								sprintf( '<input type="number" name="pronamic_pay_ends_on_count" value="%s" min="1" />', esc_attr( '' ) )
							),
							$allowed_html
						);

						?>
					</label>
				</div>

				<div>
					<input type="radio" id="pronamic_pay_ends_date" name="pronamic_pay_ends_on" value="date" />

					<label for="pronamic_pay_ends_date">
						<?php

						echo wp_kses(
							sprintf(
								/* translators: %s: input HTML */
								__( 'On %s', 'wpayo' ),
								sprintf( '<input type="date" id="pronamic_pay_ends_on_date" name="pronamic_pay_ends_on_date" value="%s" />', esc_attr( '' ) )
							),
							$allowed_html
						);

						?>
					</label>
				</div>
			</td>
		</tr>

	<?php endif; ?>

	<tr>
		<td>

		</td>
		<td>
			<?php submit_button( __( 'Test', 'wpayo' ), 'secondary', 'test_pay_gateway', false ); ?>
		</td>
	</tr>

</table>

<script type="text/javascript">
	jQuery( document ).ready( function( $ ) {
		// Interval label.
		function set_interval_label() {
			var text = $( '#pronamic_pay_test_repeat_frequency :selected' ).data( 'interval-suffix' );

			$( '#pronamic_pay_test_repeat_interval_suffix' ).text( text );
		}

		$( '#pronamic_pay_test_repeat_frequency' ).change( function() { set_interval_label(); } );

		set_interval_label();

		// Ends on value.
		$( 'label[for^="pronamic_pay_ends_"] input' ).focus( function () {
			var radio_id = $( this ).parents( 'label' ).attr( 'for' );

			$( '#' + radio_id ).prop( 'checked', true );
		} );
	} );
</script>
