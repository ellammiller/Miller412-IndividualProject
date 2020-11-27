<?php
/**
 * Namespaced functions.
 */

namespace Phrase\WP\RestAPI;

use function Phrase\WP\Connections\get_locale_code;
use function Phrase\WP\Connections\get_locale_name;
use function Phrase\WP\Connections\get_post_locale;
use function Phrase\WP\Connections\get_post_project;
use function Phrase\WP\Connections\get_post_source;
use function Phrase\WP\Connections\get_post_translation;
use function Phrase\WP\Connections\update_post_locale;
use function Phrase\WP\Connections\update_post_project;
use function Phrase\WP\get_supported_post_types;

const API_VENDOR    = 'phrase';
const API_VERSION   = '1';
const API_NAMESPACE = API_VENDOR . '/v' . API_VERSION;

/**
 * Inits REST API.
 */
function bootstrap(): void {
	add_action( 'rest_api_init', __NAMESPACE__ . '\register_rest_routes' );
	add_action( 'rest_api_init', __NAMESPACE__ . '\register_rest_fields' );

	add_filter( 'block_editor_preload_paths', __NAMESPACE__ . '\block_editor_preload_paths', 10, 2 );
}

/**
 * Registers the routes.
 */
function register_rest_routes() {
	// Status.
	$controller = new Controller\Status();
	$controller->register_routes();

	// Projects.
	$controller = new Controller\Projects();
	$controller->register_routes();

	// Project locales.
	$controller = new Controller\Locales();
	$controller->register_routes();

	// Push content.
	$controller = new Controller\PushContent();
	$controller->register_routes();

	// Translations.
	$controller = new Controller\Translations();
	$controller->register_routes();

	// Push translation.
	$controller = new Controller\PushTranslation();
	$controller->register_routes();
}

/**
 * Registers REST fields.
 */
function register_rest_fields() {
	register_rest_field(
		get_supported_post_types(),
		'phrase_locale',
		[
			'get_callback'    => function( $post ) {
				return get_post_locale( $post['id'] );
			},
			'update_callback' => function( $value, $post ) {
				update_post_locale( $post->ID, $value );
			},
			'schema'          => [
				'type'        => 'string',
				'context'     => [ 'edit' ],
				'arg_options' => [
					'sanitize_callback' => 'sanitize_key',
				],
			],
		]
	);

	register_rest_field(
		get_supported_post_types(),
		'phrase_last_updated',
		[
			'get_callback'    => function( $post ) {
				$locale_id   = get_post_locale( $post['id'] );
				$translation = get_post_translation( $post['id'], $locale_id );
				return $translation['last_update'] ?? '';
			},
			'update_callback' => null,
			'schema'          => [
				'type'    => 'string',
				'context' => [ 'edit' ],
			],
		]
	);

	register_rest_field(
		get_supported_post_types(),
		'phrase_source_post',
		[
			'get_callback'    => function( $post ) {
				$source = get_post_source( $post['id'] );
				if ( ! $source || $source['post_id'] === $post['id'] ) {
					return null;
				}

				$source_locale_id = get_post_locale( $source['post_id'] );

				return [
					'title'              => html_entity_decode( wp_trim_words( get_the_title( $source['post_id'] ), 4, '&hellip;' ), ENT_QUOTES, 'UTF-8' ),
					'percent_translated' => $source['percent'],
					'last_updated'       => $source['last_update'],
					'post_edit_url'      => get_edit_post_link( $source['post_id'], 'raw' ),
					'locale_name'        => get_locale_name( $source_locale_id ) ?: __( 'Unknown', 'phrase' ),
					'locale_code'        => get_locale_code( $source_locale_id ),
				];
			},
			'update_callback' => null,
			'schema'          => [
				'type'    => 'object',
				'context' => [ 'edit' ],
			],
		]
	);

	register_rest_field(
		get_supported_post_types(),
		'phrase_project',
		[
			'get_callback'    => function( $post ) {
				return get_post_project( $post['id'] );
			},
			'update_callback' => function( $value, $post ) {
				update_post_project( $post->ID, $value );
			},
			'schema'          => [
				'type'        => 'string',
				'context'     => [ 'edit' ],
				'arg_options' => [
					'sanitize_callback' => 'sanitize_key',
				],
			],
		]
	);
}

/**
 * Registers REST API paths that will be preloaded.
 *
 * @param string[] $paths Array of paths to preload.
 * @param \WP_Post $post  Post being edited.
 * @return string[]
 */
function block_editor_preload_paths( $paths, $post ): array {
	if ( ! \in_array( $post->post_type, get_supported_post_types(), true ) ) {
		return $paths;
	}

	$paths[] = '/' . API_NAMESPACE . '/status';
	$paths[] = '/' . API_NAMESPACE . '/projects';

	$project_id = get_post_project( $post->ID );
	$locale_id  = get_post_locale( $post->ID );
	if ( $project_id ) {
		$paths[] = '/' . API_NAMESPACE . '/locales?project_id=' . $project_id;
	}
	if ( $project_id && $locale_id ) {
		$paths[] = '/' . API_NAMESPACE . '/translations/' . $post->ID;
	}

	return $paths;
}
