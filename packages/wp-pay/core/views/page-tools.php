<?php
/**
 * Page Tools
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$nav_tabs = [
	'system_status' => __( 'System Status', 'wpayo' ),
	'gateways'      => __( 'Payment Gateways', 'wpayo' ),
	'extensions'    => __( 'Extensions', 'wpayo' ),
];

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$current_tab = array_key_exists( 'tab', $_GET ) ? \sanitize_text_field( \wp_unslash( $_GET['tab'] ) ) : '';
$current_tab = empty( $current_tab ) ? key( $nav_tabs ) : $current_tab;

?>

<div class="wrap">
	<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'wpayo' ); ?>">
		<?php

		foreach ( $nav_tabs as $tab_id => $tab_title ) {
			$classes = [ 'nav-tab' ];

			if ( $current_tab === $tab_id ) {
				$classes[] = 'nav-tab-active';
			}

			$url = add_query_arg(
				[
					'page' => 'pronamic_pay_tools',
					'tab'  => $tab_id,
				],
				admin_url( 'admin.php' )
			);

			printf(
				'<a class="nav-tab %s" href="%s">%s</a>',
				esc_attr( implode( ' ', $classes ) ),
				esc_attr( $url ),
				esc_html( $tab_title )
			);
		}

		?>
	</nav>

	<hr class="wp-header-end">

	<?php

	$file = __DIR__ . '/tab-' . $current_tab . '.php';

	if ( is_readable( $file ) ) {
		include $file;
	}

	?>

	
</div>
