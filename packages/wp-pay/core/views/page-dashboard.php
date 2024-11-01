<?php
/**
 * Page Dashboard
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$container_index = 1;
?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">

			<?php if ( current_user_can( 'edit_payments' ) ) : ?>

				<div id="postbox-container-<?php echo \esc_attr( (string) $container_index ); ?>" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle"><span><?php esc_html_e( 'WPayo Status', 'wpayo' ); ?></span></h2>
							</div>

							<div class="inside">
								<?php

								pronamic_pay_plugin()->admin->dashboard->status_widget();

								?>
							</div>
						</div>
					</div>

					<div id="normal-sortables" class="meta-box-sortables ui-sortable">

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle"><span><?php esc_html_e( 'Latest Payments', 'wpayo' ); ?></span></h2>
							</div>

							<div class="inside">
								<?php

								$payments_post_type = \Pronamic\WordPress\Pay\Admin\AdminPaymentPostType::POST_TYPE;

								$query = new WP_Query(
									[
										'post_type'      => $payments_post_type,
										'post_status'    => \array_keys( \Pronamic\WordPress\Pay\Payments\PaymentPostType::get_payment_states() ),
										'posts_per_page' => 5,
									]
								);

								$payment_posts = \array_filter(
									$query->posts,
									function( $post ) {
										return ( $post instanceof WP_Post );
									}
								);

								if ( count( $payment_posts ) > 0 ) :

									$columns = [
										'status',
										'subscription',
										'title',
										'amount',
										'date',
									];

									// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
									$column_titles = apply_filters( 'manage_edit-' . $payments_post_type . '_columns', [] );

									?>

									<div id="dashboard_recent_drafts">
										<table class="wp-list-table widefat fixed striped posts">

											<tr class="type-<?php echo esc_attr( $payments_post_type ); ?>">

												<?php

												foreach ( $columns as $column ) :
													$custom_column = sprintf( '%1$s_%2$s', $payments_post_type, $column );

													// Column classes.
													$classes = [
														sprintf( 'column-%s', $custom_column ),
													];

													if ( 'wpayo_payment_title' === $custom_column ) :
														$classes[] = 'column-primary';
													endif;

													printf(
														'<th class="%1$s">%2$s</th>',
														esc_attr( implode( ' ', $classes ) ),
														wp_kses_post( $column_titles[ $custom_column ] )
													);

												endforeach;

												?>

											</tr>

											<?php foreach ( $payment_posts as $payment_post ) : ?>

												<tr class="type-<?php echo esc_attr( $payments_post_type ); ?>">
													<?php

													$payment_id = $payment_post->ID;

													// Loop columns.
													foreach ( $columns as $column ) :

														$custom_column = sprintf( '%1$s_%2$s', $payments_post_type, $column );

														// Column classes.
														$classes = [
															$custom_column,
															'column-' . $custom_column,
														];

														if ( 'wpayo_payment_title' === $custom_column ) {
															$classes[] = 'column-primary';
														}

														printf(
															'<td class="%1$s" data-colname="%2$s">',
															esc_attr( implode( ' ', $classes ) ),
															esc_html( $column_titles[ $custom_column ] )
														);

														// Do custom column action.
														do_action(
															'manage_' . $payments_post_type . '_posts_custom_column',
															$custom_column,
															$payment_id
														);

														if ( 'wpayo_payment_title' === $custom_column ) :

															printf(
																'<button type = "button" class="toggle-row" ><span class="screen-reader-text">%1$s</span ></button>',
																esc_html( __( 'Show more details', 'wpayo' ) )
															);

														endif;

														echo '</td>';

													endforeach;

													?>

												</tr>

											<?php endforeach; ?>

										</table>
									</div>

									<?php wp_reset_postdata(); ?>

								<?php else : ?>

									<p><?php esc_html_e( 'No pending payments found.', 'wpayo' ); ?></p>

								<?php endif; ?>
							</div>
						</div>
					</div>

					<?php

					$subscriptions_post_type = \Pronamic\WordPress\Pay\Admin\AdminSubscriptionPostType::POST_TYPE;

					$query = new WP_Query(
						[
							'post_type'      => $subscriptions_post_type,
							'post_status'    => \array_keys( \Pronamic\WordPress\Pay\Subscriptions\SubscriptionPostType::get_states() ),
							'posts_per_page' => 5,
						]
					);

					$subscriptions_posts = \array_filter(
						$query->posts,
						function( $post ) {
							return ( $post instanceof WP_Post );
						}
					);

					if ( count( $subscriptions_posts ) > 0 ) :
						?>

						<div id="normal-sortables" class="meta-box-sortables ui-sortable">

							<div class="postbox">
								<div class="postbox-header">
									<h2 class="hndle"><span><?php esc_html_e( 'Latest Subscriptions', 'wpayo' ); ?></span></h2>
								</div>

								<div class="inside">
									<?php

										$columns = [
											'status',
											'title',
											'amount',
											'date',
										];

										// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
										$column_titles = apply_filters( 'manage_edit-' . $subscriptions_post_type . '_columns', [] );

										?>

										<div id="dashboard_wpayo_pay_subscriptions">
											<table class="wp-list-table widefat fixed striped posts">

												<tr class="type-<?php echo esc_attr( $subscriptions_post_type ); ?>">

													<?php

													foreach ( $columns as $column ) :
														$custom_column = sprintf( '%1$s_%2$s', 'pronamic_subscription', $column );

														// Column classes.
														$classes = [
															sprintf( 'column-%s', $custom_column ),
														];

														if ( 'pronamic_subscription_title' === $custom_column ) :
															$classes[] = 'column-primary';
														endif;

														printf(
															'<th class="%1$s">%2$s</th>',
															esc_attr( implode( ' ', $classes ) ),
															wp_kses_post( $column_titles[ $custom_column ] )
														);

													endforeach;

													?>

												</tr>

												<?php foreach ( $subscriptions_posts as $subscription_post ) : ?>

													<tr class="type-<?php echo esc_attr( $subscriptions_post_type ); ?>">
														<?php

														$subscription_id = $subscription_post->ID;

														// Loop columns.
														foreach ( $columns as $column ) :

															$custom_column = sprintf( '%1$s_%2$s', 'pronamic_subscription', $column );

															// Column classes.
															$classes = [
																$custom_column,
																'column-' . $custom_column,
															];

															if ( 'pronamic_subscription_title' === $custom_column ) {
																$classes[] = 'column-primary';
															}

															printf(
																'<td class="%1$s" data-colname="%2$s">',
																esc_attr( implode( ' ', $classes ) ),
																esc_html( $column_titles[ $custom_column ] )
															);

															// Do custom column action.
															do_action(
																'manage_' . $subscriptions_post_type . '_posts_custom_column',
																$custom_column,
																$subscription_id
															);

															if ( 'pronamic_subscription_title' === $custom_column ) :

																printf(
																	'<button type = "button" class="toggle-row" ><span class="screen-reader-text">%1$s</span ></button>',
																	esc_html( __( 'Show more details', 'wpayo' ) )
																);

															endif;

															echo '</td>';

														endforeach;

														?>

													</tr>

												<?php endforeach; ?>

											</table>
										</div>

										<?php wp_reset_postdata(); ?>
								</div>
							</div>
						</div>

					<?php endif; ?>
				</div>

				<?php $container_index++; ?>

			<?php endif; ?>

			<div id="postbox-container-<?php echo \esc_attr( (string) $container_index ); ?>" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<?php if ( current_user_can( 'manage_options' ) ) : ?>

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle"><span><?php esc_html_e( 'Getting Started', 'wpayo' ); ?></span></h2>
							</div>

							<div class="inside">
								<p>
									<?php esc_html_e( 'Please follow the tour, and also check the Site Health page for any issues.', 'wpayo' ); ?>
								</p>

								<?php

								printf(
									'<a href="%s" class="button-secondary">%s</a>',
									esc_attr(
										wp_nonce_url(
											add_query_arg(
												[
													'page' => 'wpayo',
													'pronamic_pay_ignore_tour' => '0',
												]
											),
											'pronamic_pay_ignore_tour',
											'pronamic_pay_nonce'
										)
									),
									esc_html__( 'Start tour', 'wpayo' )
								);

								echo ' ';

								if ( isset( $this ) && null !== $this->plugin->get_option( 'about_page_file' ) ) {
									printf(
										'<a href="%s" class="button-secondary">%s</a>',
										esc_attr(
											add_query_arg(
												[
													'page' => 'pronamic-pay-about',
													'tab'  => 'new',
												]
											)
										),
										esc_html__( 'What is new', 'wpayo' )
									);

									echo ' ';

									printf(
										'<a href="%s" class="button-secondary">%s</a>',
										esc_attr(
											add_query_arg(
												[
													'page' => 'pronamic-pay-about',
													'tab'  => 'getting-started',
												]
											)
										),
										esc_html__( 'Getting started', 'wpayo' )
									);

									echo ' ';
								}

								// Site Health button.
								if ( version_compare( get_bloginfo( 'version' ), '5.2', '>=' ) && current_user_can( 'view_site_health_checks' ) ) :

									printf(
										'<a href="%s" class="button-secondary">%s</a>',
										esc_attr( get_admin_url( null, 'site-health.php' ) ),
										esc_html__( 'Site Health', 'wpayo' )
									);

								endif;

								// System Status button.
								if ( version_compare( get_bloginfo( 'version' ), '5.2', '<' ) ) :

									printf(
										'<a href="%s" class="button-secondary">%s</a>',
										esc_attr(
											add_query_arg(
												[
													'page' => 'pronamic_pay_tools',
												]
											)
										),
										esc_html__( 'System Status', 'wpayo' )
									);

								endif;

								?>
							</div>
						</div>

					<?php endif; ?>

				</div>
			</div>

			<div class="clear"></div>
		</div>
	</div>
</div>
