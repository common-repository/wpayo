<?php
/**
 * Meta Box Payment Info
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 * @var \Pronamic\WordPress\Pay\Plugin $plugin Plugin.
 * @var \Pronamic\WordPress\Pay\Payments\Payment $payment Payment.
 */

use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Gender;
use Pronamic\WordPress\Pay\Payments\PaymentStatus;
use Pronamic\WordPress\Pay\Plugin;
use Pronamic\WordPress\Pay\VatNumbers\VatNumberValidationService;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<table class="form-table">
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Date', 'wpayo' ); ?>
		</th>
		<td>
			<?php echo esc_html( $payment->date->format_i18n() ); ?>
		</td>
	</tr>

	<?php

	$failure_reason = $payment->get_failure_reason();

	if ( PaymentStatus::FAILURE === $payment->get_status() && null !== $failure_reason ) :

		?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Status', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$status_label = $payment->get_status_label();

				echo \esc_html( ( null === $status_label ) ? '—' : $status_label );

				printf(
					' — %s',
					esc_html( $failure_reason )
				);

				?>
			</td>
		</tr>

	<?php endif; ?>

	<tr>
		<th scope="row">
			<?php esc_html_e( 'ID', 'wpayo' ); ?>
		</th>
		<td>
			<?php echo esc_html( (string) $payment->get_id() ); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Order ID', 'wpayo' ); ?>
		</th>
		<td>
			<?php echo esc_html( (string) $payment->get_order_id() ); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Description', 'wpayo' ); ?>
		</th>
		<td>
			<?php echo esc_html( (string) $payment->get_description() ); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Amount', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			echo esc_html( $payment->get_total_amount()->format_i18n() );

			?>
		</td>
	</tr>

	<?php

	$amount_refunded = $payment->get_refunded_amount();

	if ( $amount_refunded->get_value() > 0 ) :

		?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Refunded Amount', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( $amount_refunded->format_i18n() ); ?>
			</td>
		</tr>

	<?php endif; ?>

	<?php

	$charged_back_amount = $payment->get_charged_back_amount();

	if ( null !== $charged_back_amount && $charged_back_amount->get_value() > 0 ) :

		?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Charged Back Amount', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( $charged_back_amount->format_i18n() ); ?>
			</td>
		</tr>

	<?php endif; ?>

	<tr>
		<th scope="row">
			<?php esc_html_e( 'Transaction ID', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			$payments_post_type = \Pronamic\WordPress\Pay\Admin\AdminPaymentPostType::POST_TYPE;

			do_action( 'manage_' . $payments_post_type . '_posts_custom_column', 'wpayo_payment_transaction', $payment->get_id() );

			?>
		</td>
	</tr>

	<?php

	$purchase_id = $payment->get_meta( 'purchase_id' );

	if ( $purchase_id ) :
		?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Purchase ID', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( $purchase_id ); ?>
			</td>
		</tr>

	<?php endif; ?>

	<?php if ( null !== $payment->config_id ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Gateway', 'wpayo' ); ?>
			</th>
			<td>
				<?php edit_post_link( get_the_title( $payment->config_id ), '', '', $payment->config_id ); ?>
			</td>
		</tr>

	<?php endif; ?>

	<tr>
		<th scope="row">
			<?php esc_html_e( 'Payment Method', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			$payment_method = $payment->get_payment_method();

			// Name.
			$name = PaymentMethods::get_name( $payment_method );
			$name = ( null === $name ) ? $payment_method : $name;

			$gateway = Plugin::get_gateway( (int) $payment->get_config_id() );

			if ( null !== $gateway && null !== $payment_method ) {
				$method = $gateway->get_payment_method( $payment_method );

				if ( null !== $method ) {
					$name = $method->get_name();
				}
			}

			// Icon.
			$icon_url = PaymentMethods::get_icon_url( $payment_method );

			if ( null !== $icon_url ) {
				\printf(
					'<span class="pronamic-pay-tip" title="%2$s"><img src="%1$s" alt="%2$s" title="%2$s" width="32" valign="bottom" /></span> ',
					\esc_url( $icon_url ),
					\esc_attr( (string) $name )
				);
			}

			// Name.
			echo esc_html( (string) $name );

			// Issuer.
			$issuer = $payment->get_meta( 'issuer' );

			if ( $issuer ) {
				echo esc_html( sprintf( ' (`%s`)', $issuer ) );
			}

			?>
		</td>
	</tr>

	<?php

	$consumer_bank_details = $payment->get_consumer_bank_details();

	if ( null !== $consumer_bank_details ) :

		$consumer_name = $consumer_bank_details->get_name();

		if ( null !== $consumer_name ) :

			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Account Holder', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo esc_html( $consumer_name ); ?>
				</td>
			</tr>

			<?php

		endif;

		$account_holder_city = $consumer_bank_details->get_city();

		if ( null !== $account_holder_city ) :
			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Account Holder City', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo esc_html( $account_holder_city ); ?>
				</td>
			</tr>

			<?php

		endif;

		$account_holder_country = $consumer_bank_details->get_country();

		if ( null !== $account_holder_country ) :
			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Account Holder Country', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo esc_html( $account_holder_country ); ?>
				</td>
			</tr>

			<?php

		endif;

		$account_number = $consumer_bank_details->get_account_number();

		if ( null !== $account_number ) :

			if ( PaymentMethods::CREDIT_CARD === $payment->get_payment_method() && 4 === strlen( $account_number ) ) {
				$account_number = sprintf( '●●●● ●●●● ●●●● %d', $account_number );
			}

			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Account Number', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo esc_html( $account_number ); ?>
				</td>
			</tr>

			<?php

		endif;

		$iban = $consumer_bank_details->get_iban();

		if ( null !== $iban ) :
			?>

			<tr>
				<th scope="row">
					<?php

					printf(
						'<abbr title="%s">%s</abbr>',
						esc_attr( _x( 'International Bank Account Number', 'IBAN abbreviation title', 'wpayo' ) ),
						esc_html__( 'IBAN', 'wpayo' )
					);

					?>
				</th>
				<td>
					<?php echo esc_html( $iban ); ?>
				</td>
			</tr>

			<?php

		endif;

		$bic = $consumer_bank_details->get_bic();

		if ( null !== $bic ) :
			?>

			<tr>
				<th scope="row">
					<?php

					printf(
						'<abbr title="%s">%s</abbr>',
						esc_attr( _x( 'Bank Identifier Code', 'BIC abbreviation title', 'wpayo' ) ),
						esc_html__( 'BIC', 'wpayo' )
					);

					?>
				</th>
				<td>
					<?php echo esc_html( $bic ); ?>
				</td>
			</tr>

			<?php

		endif;

	endif;

	?>

	<?php

	$bank_transfer_recipient = $payment->get_bank_transfer_recipient_details();

	?>

	<?php if ( null !== $bank_transfer_recipient ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Bank Transfer Recipient', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				echo wp_kses(
					wpautop( $bank_transfer_recipient ),
					[
						'p'  => [],
						'br' => [],
					]
				);

				?>
			</td>
		</tr>

	<?php endif; ?>

	<?php

	$customer = $payment->get_customer();

	if ( null !== $customer ) :

		$text = \strval( $customer->get_name() );

		if ( empty( $text ) ) :

			$text = $customer->get_email();

		endif;

		if ( ! empty( $text ) ) :

			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Customer', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo \esc_html( $text ); ?>
				</td>
			</tr>

			<?php
		endif;

		$company_name = $customer->get_company_name();

		if ( null !== $company_name ) :
			?>

			<tr>
				<th scope="row">
					<?php \esc_html_e( 'Company', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo \esc_html( $company_name ); ?>
				</td>
			</tr>

			<?php
		endif;

		$vat_number = $customer->get_vat_number();

		if ( null !== $vat_number ) :
			$vat_number_validity = $vat_number->get_validity();

			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'VAT Number', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo \esc_html( $vat_number ); ?>
				</td>
			</tr>

			<?php if ( null !== $vat_number_validity ) : ?>

				<tr>
					<th scope="row">
						<?php esc_html_e( 'VAT Number Validity', 'wpayo' ); ?>
					</th>
					<td style="padding-top: 20px">
						<style type="text/css">
							.pronamic-pay-form-sub-table th,
							.pronamic-pay-form-sub-table td {
								padding: 0;
							}
						</style>

						<table class="pronamic-pay-form-sub-table">
							<tr>
								<th scope="row">
									<?php esc_html_e( 'VAT Number', 'wpayo' ); ?>
								</th>
								<td>
									<?php echo esc_html( $vat_number_validity->get_vat_number() ); ?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php esc_html_e( 'Request Date', 'wpayo' ); ?>
								</th>
								<td>
									<?php echo esc_html( $vat_number_validity->get_request_date()->format( 'd-m-Y' ) ); ?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php esc_html_e( 'Valid', 'wpayo' ); ?>
								</th>
								<td>
									<?php echo esc_html( $vat_number_validity->is_valid() ? __( 'Yes', 'wpayo' ) : __( 'No', 'wpayo' ) ); ?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php esc_html_e( 'Name', 'wpayo' ); ?>
								</th>
								<td>
									<?php echo esc_html( (string) $vat_number_validity->get_name() ); ?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php esc_html_e( 'Address', 'wpayo' ); ?>
								</th>
								<td>
									<?php

									echo \wp_kses(
										\nl2br( (string) $vat_number_validity->get_address() ),
										[
											'br' => [],
										]
									);

									?>
								</td>
							</tr>

							<?php

							$service = $vat_number_validity->get_service();

							if ( null !== $service ) :
								?>

								<tr>
									<th scope="row">
										<?php esc_html_e( 'Validation Service', 'wpayo' ); ?>
									</th>
									<td>
										<?php

										switch ( $service ) {
											case VatNumberValidationService::VIES:
												echo esc_html( __( 'VIES', 'wpayo' ) );

												break;
											default:
												echo \esc_html( $service );

												break;
										}

										?>
									</td>
								</tr>

							<?php endif; ?>

						</table>
					</td>
				</tr>

				<?php
			endif;

		endif;

		$birth_date = $customer->get_birth_date();

		if ( null !== $birth_date ) :
			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Date of birth', 'wpayo' ); ?>
				</th>
				<td>
					<?php

					echo esc_html( $birth_date->format_i18n( __( 'D j M Y', 'wpayo' ) ) )

					?>
				</td>
			</tr>

		<?php endif; ?>

		<?php

		$gender = $customer->get_gender();

		if ( null !== $gender ) :
			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Gender', 'wpayo' ); ?>
				</th>
				<td>
					<?php

					switch ( $gender ) {
						case Gender::FEMALE:
							echo esc_html( __( 'Female', 'wpayo' ) );

							break;
						case Gender::MALE:
							echo esc_html( __( 'Male', 'wpayo' ) );

							break;
						case Gender::OTHER:
							echo esc_html( __( 'Other', 'wpayo' ) );

							break;
					}

					?>
				</td>
			</tr>

		<?php endif; ?>

		<?php

		$user_id = $customer->get_user_id();

		if ( null !== $user_id ) :
			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'User', 'wpayo' ); ?>
				</th>
				<td>
					<?php

					$user_text = sprintf( '#%s', $user_id );

					// User display name.
					$user = new WP_User( $user_id );

					$display_name = $user->display_name;

					if ( ! empty( $display_name ) ) {
						$user_text .= sprintf( ' - %s', $display_name );
					}

					printf(
						'<a href="%s">%s</a>',
						esc_url( get_edit_user_link( $user_id ) ),
						esc_html( $user_text )
					);

					?>
				</td>
			</tr>

		<?php endif; ?>

		<?php

		$ip_address = $customer->get_ip_address();

		if ( null !== $ip_address ) :
			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'IP Address', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo esc_html( $ip_address ); ?>
				</td>
			</tr>

		<?php endif; ?>

	<?php endif; ?>

	<?php if ( null !== $payment->get_billing_address() ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Billing Address', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$address = $payment->get_billing_address();

				echo nl2br( esc_html( (string) $address ) );

				?>
			</td>
		</tr>

	<?php endif; ?>

	<?php if ( null !== $payment->get_shipping_address() ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Shipping Address', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$address = $payment->get_shipping_address();

				echo nl2br( esc_html( (string) $address ) );

				?>
			</td>
		</tr>

	<?php endif; ?>

	<tr>
		<th scope="row">
			<?php esc_html_e( 'Source', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $payment->get_source_text();

			?>
		</td>
	</tr>

	<?php

	$analytics_tracked = $payment->get_meta( 'google_analytics_tracked' );

	$ga_property_id = get_option( 'pronamic_pay_google_analytics_property' );

	?>

	<?php if ( true === $analytics_tracked || ! empty( $ga_property_id ) ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Google Analytics', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				if ( true === $analytics_tracked ) :

					esc_html_e( 'Ecommerce conversion tracked', 'wpayo' );

				else :

					esc_html_e( 'Ecommerce conversion not tracked', 'wpayo' );

				endif;

				?>
			</td>
		</tr>

	<?php endif; ?>

	<?php if ( 'membership' === $payment->get_source() ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'User ID', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( (string) $payment->get_meta( 'membership_user_id' ) ); ?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Subscription ID', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( (string) $payment->get_meta( 'membership_subscription_id' ) ); ?>
			</td>
		</tr>

	<?php endif; ?>

	<?php

	$ogone_alias = $payment->get_meta( 'ogone_alias' );

	?>

	<?php if ( ! empty( $ogone_alias ) && \is_string( $ogone_alias ) ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'Ingenico Alias', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( $ogone_alias ); ?>
			</td>
		</tr>

	<?php endif; ?>

	<?php if ( $plugin->is_debug_mode() ) : ?>

		<?php if ( null !== $payment->get_version() ) : ?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Version', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo esc_html( $payment->get_version() ); ?>
				</td>
			</tr>

		<?php endif ?>

		<?php if ( null !== $payment->get_mode() ) : ?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'Mode', 'wpayo' ); ?>
				</th>
				<td>
					<?php

					switch ( $payment->get_mode() ) {
						case 'live':
							esc_html_e( 'Live', 'wpayo' );

							break;
						case 'test':
							esc_html_e( 'Test', 'wpayo' );

							break;
						default:
							echo esc_html( $payment->get_mode() );

							break;
					}

					?>
				</td>
			</tr>

		<?php endif ?>

	<?php endif; ?>

	<?php

	$customer = $payment->get_customer();

	if ( null !== $customer ) :

		$user_agent = $customer->get_user_agent();

		if ( null !== $user_agent ) :
			?>

			<tr>
				<th scope="row">
					<?php esc_html_e( 'User Agent', 'wpayo' ); ?>
				</th>
				<td>
					<?php echo esc_html( $user_agent ); ?>
				</td>
			</tr>

		<?php endif; ?>

	<?php endif; ?>

	<tr>
		<th scope="row">
			<?php esc_html_e( 'Action URL', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			$url = $payment->get_action_url();

			if ( null !== $url ) {
				printf(
					'<a href="%s" target="_blank">%s</a>',
					esc_attr( $url ),
					esc_html( $url )
				);
			}

			?>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Pay Redirect URL', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			$url = $payment->get_pay_redirect_url();

			printf(
				'<a href="%s">%s</a>',
				esc_attr( $url ),
				esc_html( $url )
			);

			?>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Return URL', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			$url = $payment->get_return_url();

			printf(
				'<a href="%s">%s</a>',
				esc_attr( $url ),
				esc_html( $url )
			);

			?>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Return Redirect URL', 'wpayo' ); ?>
		</th>
		<td>
			<?php

			$url = $payment->get_return_redirect_url();

			printf(
				'<a href="%s">%s</a>',
				esc_attr( $url ),
				esc_html( $url )
			);

			?>
		</td>
	</tr>

	<?php if ( $plugin->is_debug_mode() ) : ?>

		<tr>
			<th scope="row">
				<?php esc_html_e( 'REST API URL', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				/**
				 * REST API URL.
				 *
				 * @link https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/#cookie-authentication
				 */
				$rest_api_url = rest_url( 'pronamic-pay/v1/payments/' . $payment->get_id() );

				$rest_api_nonce_url = wp_nonce_url( $rest_api_url, 'wp_rest' );

				printf(
					'<a href="%s">%s</a>',
					esc_url( $rest_api_nonce_url ),
					esc_html( $rest_api_url )
				);

				?>
			</td>
		</tr>

	<?php endif; ?>
</table>
