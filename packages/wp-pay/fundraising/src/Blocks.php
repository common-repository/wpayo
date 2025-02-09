<?php
/**
 * Editor Blocks.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Fundraising;

/**
 * Blocks
 *
 * @author  Reüel van der Steege
 * @since   2.2.6
 * @version 2.1.7
 */
class Blocks {
	/**
	 * Add-on plugin.
	 *
	 * @var Addon
	 */
	private $plugin;

	/**
	 * Constructor.
	 *
	 * @param Addon $plugin Add-on plugin.
	 */
	public function __construct( Addon $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Setup.
	 *
	 * @return void
	 */
	public function setup() {
		// Initialize.
		add_action( 'init', [ $this, 'register_scripts' ] );
		add_action( 'init', [ $this, 'register_styles' ] );
		add_action( 'init', [ $this, 'register_block_types' ] );

		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_styles' ] );
	}

	/**
	 * Register blocks.
	 *
	 * @return void
	 */
	public function register_scripts() {
		$asset_file = include __DIR__ . '/../js/dist/index.asset.php';

		\wp_register_script(
			'pronamic-pay-fundraising-blocks',
			\plugins_url( '../js/dist/index.js', __FILE__ ),
			$asset_file['dependencies'],
			$asset_file['version'],
			false
		);

		// Script translations.
		\wp_set_script_translations(
			'pronamic-pay-fundraising-blocks',
			'pronamic-pay-fundraising',
			__DIR__ . '/../languages'
		);
	}

	/**
	 * Register styles.
	 *
	 * @return void
	 */
	public function register_styles() {
		$min = SCRIPT_DEBUG ? '' : '.min';

		\wp_register_style(
			'pronamic-pay-fundraising',
			\plugins_url( '../css/fundraising' . $min . '.css', __FILE__ ),
			[],
			\hash_file( 'crc32b', __DIR__ . '/../css/fundraising' . $min . '.css' )
		);
	}

	/**
	 * Register block types.
	 *
	 * @return void
	 */
	public function register_block_types() {
		// Fundraising Progress Circle block.
		register_block_type_from_metadata(
			__DIR__ . '/../js/dist/blocks/progress-circle',
			[
				'render_callback' => function( $attributes, $content ) {
					ob_start();

					include __DIR__ . '/../templates/block-fundraising-progress-circle.php';

					return ob_get_clean();
				},
			]
		);

		// Fundraising Progress Bar block.
		register_block_type_from_metadata(
			__DIR__ . '/../js/dist/blocks/progress-bar',
			[
				'render_callback' => function( $attributes, $content ) {
					ob_start();

					include __DIR__ . '/../templates/block-fundraising-progress-bar.php';

					return ob_get_clean();
				},
			]
		);

		// Fundraising Progress Text block.
		register_block_type_from_metadata(
			__DIR__ . '/../js/dist/blocks/progress-text',
			[
				'render_callback' => function ( $attributes, $content ) {
					ob_start();

					include __DIR__ . '/../templates/block-fundraising-progress-text.php';

					return ob_get_clean();
				},
			]
		);
	}

	/**
	 * Enqueue styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		\wp_enqueue_style( 'pronamic-pay-fundraising' );
	}
}
