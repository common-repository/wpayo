<?php
/**
 * Subscription renew failed.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

		<title><?php esc_html_e( 'Subscription Renewal', 'wpayo' ); ?></title>

		<?php wp_print_styles( 'pronamic-pay-redirect' ); ?>
	</head>

	<body>
		<div class="pronamic-pay-redirect-page">
			<div class="pronamic-pay-redirect-container">
				<h1><?php esc_html_e( 'Subscription Renewal', 'wpayo' ); ?></h1>

				<div class="pp-page-section-container">
					<div class="pp-page-section-wrapper">
						<p>
							<?php esc_html_e( 'The subscription can not be renewed.', 'wpayo' ); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
