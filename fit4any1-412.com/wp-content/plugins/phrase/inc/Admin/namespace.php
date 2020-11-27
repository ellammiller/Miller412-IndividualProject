<?php
/**
 * Namespaced functions.
 */

namespace Phrase\WP\Admin;

use function Phrase\WP\Connections\get_locale_code;
use function Phrase\WP\Connections\get_locale_name;
use function Phrase\WP\Connections\get_post_locale;
use function Phrase\WP\Connections\get_post_project;
use function Phrase\WP\Connections\get_post_source;
use function Phrase\WP\Connections\get_post_translation;
use function Phrase\WP\Connections\get_project_name;
use function Phrase\WP\Connections\get_project_url;
use function Phrase\WP\get_supported_post_types;
use const Phrase\WP\PLUGIN_DIR;
use const Phrase\WP\PLUGIN_FILE;

/**
 * Inits administration.
 */
function bootstrap(): void {
	// Register scripts, styles (https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/).
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_editor_assets' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue_scripts' );

	// Register options and settings page (https://developer.wordpress.org/plugins/settings/).
	add_action( 'admin_menu', [ __NAMESPACE__ . '\Settings', 'admin_menu' ] );
	add_action( 'admin_init', [ __NAMESPACE__ . '\Settings', 'init' ] );

	// TODO: Register meta box for classic editor (https://developer.wordpress.org/plugins/metadata/custom-meta-boxes/).

	// Register and render custom admin columns.
	foreach ( get_supported_post_types() as $post_type ) {
		add_action( "manage_{$post_type}_posts_columns", __NAMESPACE__ . '\add_post_columns' );
		add_action( "manage_{$post_type}_posts_custom_column", __NAMESPACE__ . '\render_post_columns', 10, 2 );
	}
}

/**
 * Adds admin columns for translations, status and project links.
 *
 * @param string[] $columns An associative array of column headings.
 * @return string[] An associative array of column headings.
 */
function add_post_columns( array $columns ): array {
	$columns['phrase-language']             = esc_html__( 'Language', 'phrase' );
	$columns['phrase-type']                 = esc_html__( 'Type', 'phrase' );
	$columns['phrase-translation-progress'] = esc_html__( 'Translation progress', 'phrase' );
	$columns['phrase-project']              = esc_html__( 'Phrase project', 'phrase' );

	return $columns;
}

/**
 * Render the contents for custom post columns.
 *
 * @param string $column  The name of the column to display.
 * @param int    $post_id The current post ID.
 */
function render_post_columns( string $column, int $post_id ) {
	if ( ! \in_array( $column, [ 'phrase-language', 'phrase-type', 'phrase-translation-progress', 'phrase-project' ], true ) ) {
		return;
	}

	$locale_id = get_post_locale( $post_id );
	if ( ! $locale_id ) {
		return;
	}

	$translation = get_post_translation( $post_id, $locale_id );
	if ( ! $translation ) {
		return;
	}

	$project_id = get_post_project( $post_id );

	switch ( $column ) {
		case 'phrase-language':
			$locale_name = get_locale_name( $locale_id );

			if ( preg_match( '#^(\w+)-([^-]+)-?(\w+)?$#', get_locale_code( $locale_id ), $matches ) ) {
				$image_src = plugins_url( '/assets/images/flags/' . $matches[2] . '.png', PLUGIN_FILE );
				$image_alt = sprintf(
					/* translators: The flag icons image alt tag. %s is the locale */
					__( 'Flag: %s', 'phrase' ),
					get_locale_name( $locale_id )
				);
				?>
				<img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="phrase-flag-icon" width="16" height="16" />
				<span class="phrase-locale-code">
					<?php echo esc_html( $locale_name ); ?>
				</span>
				<?php
			} else {
				?>
				<span class="phrase-locale-code">
					<?php echo esc_html( $locale_name ); ?>
				</span>
				<?php
			}

			break;

		case 'phrase-type':
			if ( $translation['is_source'] ) {
				_e( 'Source content', 'phrase' );
			} else {
				$source = get_post_source( $post_id );
				printf(
					/* translators: %s: Edit link to the source content post */
					__( 'Translation of %s', 'phrase' ),
					sprintf(
						'<a href="%s">%s</a>',
						esc_url( get_edit_post_link( $source['post_id'], 'raw' ) ),
						esc_html( wp_trim_words( get_the_title( $source['post_id'] ), 4, '&hellip;' ) )
					)
				);
			}
			break;

		case 'phrase-translation-progress':
			?>
			<div class="phrase-translation-state">
				<?php
				if ( 100 === $translation['percent'] ) {
					?>
					<span class="phrase-translation-state__complete">
						<span class="dashicons dashicons-yes-alt" aria-hidden="true"></span>
						<?php echo esc_html_x( 'Completed', 'translation progress', 'phrase' ); ?>
					</span>
					<?php
				} else {
					?>
					<div class="phrase-translation-state__progress">
						<div class="phrase-translation-state__progress-inner" style="width: <?php echo esc_attr( $translation['percent'] ); ?>%"></div>
					</div>
					<span class="phrase-translation-state__percent"><?php echo esc_html( $translation['percent'] ); ?>%</span>
					<?php
				}
				?>
				</div>
			<?php
			break;

		case 'phrase-project':
			$phrase_project_url = get_project_url( $project_id );
			?>
			<a href="<?php echo esc_url( $phrase_project_url ); ?>" target="_blank" rel="external noreferrer noopener">
				<?php echo esc_html( get_project_name( $project_id ) ); ?>
				<span class="screen-reader-text"><?php _e( '(opens in a new tab)', 'phrase' ); ?></span>
				<span class="dashicons dashicons-external" aria-hidden="true"></span>
			</a>
			<?php
			break;
	}
}

/**
 * Enqueue scripts and styles used by the block editor.
 */
function enqueue_editor_assets() {
	$block_editor_script_asset = require PLUGIN_DIR . '/assets/js/dist/block-editor.asset.php';

	wp_enqueue_script(
		'phrase-block-editor',
		plugins_url( 'assets/js/dist/block-editor.js', PLUGIN_FILE ),
		$block_editor_script_asset['dependencies'],
		$block_editor_script_asset['version'],
		true
	);

	wp_set_script_translations( 'phrase-block-editor', 'phrase' );

	wp_add_inline_script(
		'phrase-block-editor',
		sprintf(
			'window.PHRASE_ASSETS_URL = "%s";',
			esc_js( plugins_url( 'assets', PLUGIN_FILE ) )
		),
		'before'
	);

	wp_enqueue_style(
		'phrase-block-editor',
		plugins_url( 'assets/js/dist/block-editor.css', PLUGIN_FILE ),
		[],
		filemtime( PLUGIN_DIR . '/assets/js/dist/block-editor.css' )
	);
}

/**
 * Enqueue general admin scripts for settings/option pages.
 *
 * @param string $hook The current hook.
 */
function admin_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_phrase' === $hook ) {
		$admin_script_asset = require PLUGIN_DIR . '/assets/js/dist/admin.asset.php';

		wp_enqueue_script(
			'phrase-admin-scripts',
			plugins_url( 'assets/js/dist/admin.js', PLUGIN_FILE ),
			$admin_script_asset['dependencies'],
			$admin_script_asset['version'],
			true
		);
	} elseif ( 'edit.php' === $hook ) {
		$screen_id       = get_current_screen()->id;
		$enabled_screens = array_map(
			function ( $post_type ) {
				return 'edit-' . $post_type;
			},
			get_supported_post_types()
		);

		if ( \in_array( $screen_id, $enabled_screens, true ) ) {
			wp_enqueue_style(
				'phrase-styles',
				plugins_url( 'assets/js/dist/admin.css', PLUGIN_FILE ),
				[],
				filemtime( PLUGIN_DIR . '/assets/js/dist/admin.css' )
			);
		}
	}
}
