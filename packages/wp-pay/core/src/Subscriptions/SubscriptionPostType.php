<?php
/**
 * Subscription Post Type
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Subscriptions
 */

namespace Pronamic\WordPress\Pay\Subscriptions;

use Pronamic\WordPress\Pay\Payments\PaymentPostType;

/**
 * Title: WordPress iDEAL post types
 *
 * @author  Remco Tolsma
 * @version 2.2.6
 * @since   1.0.0
 */
class SubscriptionPostType {
	/**
	 * Constructs and initializes an post types object
	 */
	public function __construct() {
		/**
		 * Priority of the initial post types function should be set to < 10.
		 *
		 * @link https://core.trac.wordpress.org/ticket/28488
		 * @link https://core.trac.wordpress.org/changeset/29318
		 *
		 * @link https://github.com/WordPress/WordPress/blob/4.0/wp-includes/post.php#L167
		 */
		add_action( 'init', [ $this, 'register_subscription_post_type' ], 0 ); // Highest priority.
		add_action( 'init', [ $this, 'register_post_status' ], 9 );
	}

	/**
	 * Register post types.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.6.1/wp-includes/post.php#L1277-L1300
	 * @return void
	 */
	public function register_subscription_post_type() {
		register_post_type(
			'wpayo_pay_subscr',
			[
				'label'              => __( 'Subscriptions', 'wpayo' ),
				'labels'             => [
					'name'                     => __( 'Subscriptions', 'wpayo' ),
					'singular_name'            => __( 'Subscription', 'wpayo' ),
					'add_new'                  => __( 'Add New', 'wpayo' ),
					'add_new_item'             => __( 'Add New Subscription', 'wpayo' ),
					'edit_item'                => __( 'Edit Subscription', 'wpayo' ),
					'new_item'                 => __( 'New Subscription', 'wpayo' ),
					'all_items'                => __( 'All Subscriptions', 'wpayo' ),
					'view_item'                => __( 'View Subscription', 'wpayo' ),
					'search_items'             => __( 'Search Subscriptions', 'wpayo' ),
					'not_found'                => __( 'No subscriptions found.', 'wpayo' ),
					'not_found_in_trash'       => __( 'No subscriptions found in Trash.', 'wpayo' ),
					'menu_name'                => __( 'Subscriptions', 'wpayo' ),
					'filter_items_list'        => __( 'Filter subscriptions list', 'wpayo' ),
					'items_list_navigation'    => __( 'Subscriptions list navigation', 'wpayo' ),
					'items_list'               => __( 'Subscriptions list', 'wpayo' ),

					/*
					 * New Post Type Labels in 5.0.
					 * @link https://make.wordpress.org/core/2018/12/05/new-post-type-labels-in-5-0/
					 */
					'item_published'           => __( 'Subscription published.', 'wpayo' ),
					'item_published_privately' => __( 'Subscription published privately.', 'wpayo' ),
					'item_reverted_to_draft'   => __( 'Subscription reverted to draft.', 'wpayo' ),
					'item_scheduled'           => __( 'Subscription scheduled.', 'wpayo' ),
					'item_updated'             => __( 'Subscription updated.', 'wpayo' ),
				],
				'public'             => false,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'show_in_nav_menus'  => false,
				'show_in_menu'       => false,
				'show_in_admin_bar'  => false,
				'show_in_rest'       => true,
				'rest_base'          => 'pronamic-subscriptions',
				'supports'           => [
					'wpayo_pay_subscription',
				],
				'rewrite'            => false,
				'query_var'          => false,
				'capabilities'       => PaymentPostType::get_capabilities(),
				'map_meta_cap'       => true,
			]
		);
	}

	/**
	 * Get subscription states.
	 *
	 * @return array
	 */
	public static function get_states() {
		return [
			'subscr_pending'   => _x( 'Pending', 'Subscription status', 'wpayo' ),
			'subscr_cancelled' => _x( 'Cancelled', 'Subscription status', 'wpayo' ),
			'subscr_expired'   => _x( 'Expired', 'Subscription status', 'wpayo' ),
			'subscr_failed'    => _x( 'Failed', 'Subscription status', 'wpayo' ),
			'subscr_on_hold'   => _x( 'On Hold', 'Subscription status', 'wpayo' ),
			'subscr_active'    => _x( 'Active', 'Subscription status', 'wpayo' ),
			'subscr_completed' => _x( 'Completed', 'Subscription status', 'wpayo' ),
		];
	}

	/**
	 * Register our custom post statuses, used for order status.
	 *
	 * @return void
	 */
	public function register_post_status() {
		/**
		 * Subscription post statuses.
		 */
		register_post_status(
			'subscr_pending',
			[
				'label'                     => _x( 'Pending', 'Subscription status', 'wpayo' ),
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: %s: count value */
				'label_count'               => _n_noop( 'Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>', 'wpayo' ),
			]
		);

		register_post_status(
			'subscr_cancelled',
			[
				'label'                     => _x( 'Cancelled', 'Subscription status', 'wpayo' ),
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: %s: count value */
				'label_count'               => _n_noop( 'Cancelled <span class="count">(%s)</span>', 'Cancelled <span class="count">(%s)</span>', 'wpayo' ),
			]
		);

		register_post_status(
			'subscr_expired',
			[
				'label'                     => _x( 'Expired', 'Subscription status', 'wpayo' ),
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: %s: count value */
				'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>', 'wpayo' ),
			]
		);

		register_post_status(
			'subscr_failed',
			[
				'label'                     => _x( 'Failed', 'Subscription status', 'wpayo' ),
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: %s: count value */
				'label_count'               => _n_noop( 'Failed <span class="count">(%s)</span>', 'Failed <span class="count">(%s)</span>', 'wpayo' ),
			]
		);

		register_post_status(
			'subscr_on_hold',
			[
				'label'                     => _x( 'On Hold', 'Subscription status', 'wpayo' ),
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: %s: count value */
				'label_count'               => _n_noop( 'On Hold <span class="count">(%s)</span>', 'On Hold <span class="count">(%s)</span>', 'wpayo' ),
			]
		);

		register_post_status(
			'subscr_active',
			[
				'label'                     => _x( 'Active', 'Subscription status', 'wpayo' ),
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: %s: count value */
				'label_count'               => _n_noop( 'Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>', 'wpayo' ),
			]
		);

		register_post_status(
			'subscr_completed',
			[
				'label'                     => _x( 'Completed', 'Subscription status', 'wpayo' ),
				'public'                    => false,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				/* translators: %s: count value */
				'label_count'               => _n_noop( 'Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>', 'wpayo' ),
			]
		);
	}
}
