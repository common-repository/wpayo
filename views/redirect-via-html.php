<?php
/**
 * Redirect via HTML
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! isset( $payment ) ) {
	return;
}

?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

		<title><?php esc_html_e( 'Redirecting…', 'wpayo' ); ?></title>

		<?php wp_print_styles( 'pronamic-pay-redirect' ); ?>

		<script>
		// Break out of iframe.
		if ( window.top.location !== window.location ) {
			window.top.location = window.location;
		}
		</script>
	</head>

	<?php

	$auto_submit = true;

	if ( defined( '\PRONAMIC_PAY_DEBUG' ) && \PRONAMIC_PAY_DEBUG ) {
		$auto_submit = false;
	}

	$onload = $auto_submit ? 'document.forms[0].submit();' : '';

	?>

	<body onload="<?php esc_attr( $onload ); ?>">
		<div class="pronamic-pay-redirect-page">
			<div class="pronamic-pay-redirect-container">
				<h1><?php esc_html_e( 'Redirecting…', 'wpayo' ); ?></h1>

				<p>
					<?php esc_html_e( 'You will be automatically redirected to the online payment environment.', 'wpayo' ); ?>
				</p>

				<div class="pp-page-section-container">
					<div class="pp-page-section-wrapper">
						<p>
							<?php esc_html_e( 'Please click the button below if you are not automatically redirected.', 'wpayo' ); ?>
						</p>

						<?php

						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $this->get_form_html( $payment, $auto_submit );

						?>
					</div>
				</div>

				<div class="pp-page-section-container">
					<div class="pp-page-section-wrapper alignleft">
						<h2><?php esc_html_e( 'Payment', 'wpayo' ); ?></h2>

						<dl>
							<dt><?php esc_html_e( 'Date', 'wpayo' ); ?></dt>
							<dd><?php echo esc_html( $payment->get_date()->format_i18n() ); ?></dd>

							<?php $transaction_id = $payment->get_transaction_id(); ?>

							<?php if ( ! empty( $transaction_id ) ) : ?>

								<dt><?php esc_html_e( 'Transaction ID', 'wpayo' ); ?></dt>
								<dd><?php echo esc_html( $transaction_id ); ?></dd>

							<?php endif; ?>

							<dt><?php esc_html_e( 'Description', 'wpayo' ); ?></dt>
							<dd><?php echo esc_html( $payment->get_description() ); ?></dd>

							<dt><?php esc_html_e( 'Amount', 'wpayo' ); ?></dt>
							<dd><?php echo esc_html( $payment->get_total_amount()->format_i18n() ); ?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
