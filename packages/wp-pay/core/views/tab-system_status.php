<?php
/**
 * Tab System Status
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
?>
<table class="pronamic-pay-table pronamic-pay-status-table widefat">
	<thead>
		<tr>
			<th colspan="3"><?php esc_html_e( 'License', 'wpayo' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'License Status', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$license_status = get_option( 'pronamic_pay_license_status' );

				switch ( $license_status ) {
					case 'valid':
						esc_html_e( 'Valid', 'wpayo' );

						break;
					case 'invalid':
						esc_html_e( 'Invalid', 'wpayo' );

						break;
					case 'site_inactive':
						esc_html_e( 'Site Inactive', 'wpayo' );

						break;
					default:
						if ( \is_string( $license_status ) ) {
							echo \esc_html( $license_status );
						}

						break;
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Next License Check', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$timestamp = wp_next_scheduled( 'pronamic_pay_license_check' );

				if ( false !== $timestamp ) {
					$date = new DateTime( '@' . $timestamp, new DateTimeZone( 'UTC' ) );

					echo esc_html( $date->format_i18n() );
				} else {
					esc_html_e( 'Not scheduled', 'wpayo' );
				}

				?>
			</td>
		</tr>
	</tbody>
</table>

<table class="pronamic-pay-table pronamic-pay-status-table widefat striped">
	<thead>
		<tr>
			<th colspan="3"><?php esc_html_e( 'WordPress Environment', 'wpayo' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Site URL', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( site_url() ); ?>
			</td>
			<td>
				✓
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Home URL', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( home_url() ); ?>
			</td>
			<td>
				✓
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php \esc_html_e( 'PHP Version', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo \esc_html( (string) \phpversion() ); ?>
			</td>
			<td>
				<?php

				$php_version = \phpversion();

				if ( false !== $php_version ) {
					if ( \version_compare( $php_version, '5.2', '>' ) ) {
						echo '✓';
					} else {
						esc_html_e( 'Pronamic Pay requires PHP 5.2 or above.', 'wpayo' );
					}
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'MySQL Version', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				global $wpdb;

				echo esc_html( $wpdb->db_version() );

				?>
			</td>
			<td>
				<?php

				if ( version_compare( $wpdb->db_version(), '5', '>' ) ) {
					echo '✓';
				} else {
					esc_html_e( 'Pronamic Pay requires MySQL 5 or above.', 'wpayo' );
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'WordPress Version', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( get_bloginfo( 'version' ) ); ?>
			</td>
			<td>
				<?php

				if ( version_compare( get_bloginfo( 'version' ), '3.2', '>' ) ) {
					echo '✓';
				} else {
					esc_html_e( 'Pronamic Pay requires WordPress 3.2 or above.', 'wpayo' );
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'WP Memory Limit', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$memory = pronamic_pay_let_to_num( WP_MEMORY_LIMIT );

				$memory_formatted = size_format( $memory );

				if ( false === $memory_formatted ) {
					echo \esc_html( (string) $memory );
				}

				if ( false !== $memory_formatted ) {
					echo \esc_html( $memory_formatted );
				}

				?>
			</td>
			<td>
				<?php

				if ( $memory >= 67108864 ) { // 64 MB
					echo '✓';
				} else {
					echo wp_kses(
						sprintf(
							/* translators: %s: WordPress Codex link */
							__( 'We recommend setting memory to at least 64MB. See: <a href="%s" target="_blank">Increasing memory allocated to PHP</a>', 'wpayo' ),
							esc_attr( 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' )
						),
						[
							'a' => [
								'href'   => true,
								'target' => true,
							],
						]
					);
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Character Set', 'wpayo' ); ?>
			</th>
			<td>
				<?php bloginfo( 'charset' ); ?>
			</td>
			<td>
				<?php

				// @link http://codex.wordpress.org/Function_Reference/bloginfo#Show_Character_Set
				if ( 0 === strcasecmp( get_bloginfo( 'charset' ), 'UTF-8' ) ) {
					echo '✓';
				} else {
					esc_html_e( 'Pronamic Pay advices to set the character encoding to UTF-8.', 'wpayo' );
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Time (UTC)', 'wpayo' ); ?>
			</th>
			<td>
				<?php echo esc_html( gmdate( __( 'Y/m/d g:i:s A', 'wpayo' ) ) ); ?>
			</td>
			<td>
				✓
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'cURL', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				if ( \function_exists( 'curl_version' ) ) {
					/**
					 * Using cURL functions is highly discouraged within VIP context.
					 * We only use this cURL function for on the system status page.
					 */
					$curl_version = curl_version();

					if ( false === $curl_version ) {
						\esc_html_e( 'Unable to get the current cURL version.', 'wpayo' );
					}

					if ( \is_array( $curl_version ) && \array_key_exists( 'version', $curl_version ) ) {
						echo \esc_html( $curl_version['version'] );
					}
				}

				?>
			</td>
			<td>
				✓
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'OpenSSL', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				if ( \defined( 'OPENSSL_VERSION_TEXT' ) ) {
					echo \esc_html( OPENSSL_VERSION_TEXT );
				}

				// @link https://www.openssl.org/docs/crypto/OPENSSL_VERSION_NUMBER.html
				$version_current  = (string) OPENSSL_VERSION_NUMBER;
				$version_required = (string) 0x000908000;

				?>
			</td>
			<td>
				<?php

				if ( \version_compare( $version_current, $version_required, '>' ) ) {
					echo '✓';
				} else {
					esc_html_e( 'Pronamic Pay requires OpenSSL 0.9.8 or above.', 'wpayo' );
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Registered Hashing Algorithms', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$algorithms = hash_algos();

				echo esc_html( implode( ', ', $algorithms ) );

				?>
			</td>
			<td>
				<?php

				if ( in_array( 'sha1', $algorithms, true ) ) {
					echo '✓';
				} else {
					esc_html_e( 'Pronamic Pay requires the "sha1" hashing algorithm.', 'wpayo' );
				}

				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php esc_html_e( 'Travis CI build status', 'wpayo' ); ?>
			</th>
			<td>
				<?php

				$url = add_query_arg( 'branch', pronamic_pay_plugin()->get_version(), '' );

				?>
				
			</td>
			<td>

			</td>
		</tr>
	</tbody>
</table>
