<?php
/**
 * Namespaced functions.
 */

namespace Phrase\WP;

use Phrase\WP\CLI\UpdateTermMetaCommand;
use WP_CLI;

/**
 * Inits plugin.
 */
function bootstrap(): void {
	Connections\bootstrap();

	add_action( 'init', __NAMESPACE__ . '\register_meta' );
	add_action( 'init', __NAMESPACE__ . '\register_cronjobs' );

	RestAPI\bootstrap();

	if ( is_admin() ) {
		Admin\bootstrap();
	}

	if ( \defined( 'WP_CLI' ) && WP_CLI ) {
		WP_CLI::add_command( 'phrase update meta', UpdateTermMetaCommand::class );
	}
}

/**
 * Registers custom meta.
 */
function register_meta() {
	register_post_meta(
		'',
		'phrase_has_initial_content_push',
		[
			'type'              => 'boolean',
			'default'           => false,
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		]
	);
}

/**
 * Registers cron jobs.
 */
function register_cronjobs() {
	if ( ! wp_next_scheduled( Cron\UpdateTermMetaData::ACTION ) ) {
		wp_schedule_event( time(), 'daily', Cron\UpdateTermMetaData::ACTION );
	}

	add_action( Cron\UpdateTermMetaData::ACTION, [ Cron\UpdateTermMetaData::class, 'callback' ] );
}

/**
 * Returns supported post types for translation.
 *
 * TODO: Add filter or post type support.
 *
 * @return string[] List of post types.
 */
function get_supported_post_types() {
	return [ 'post', 'page' ];
}

/**
 * Filters `wp_insert_post()` to respect the data for the post_modified fields.
 *
 * @param array $data    An array of slashed, sanitized, and processed post data.
 * @param array $postarr An array of sanitized (and slashed) but otherwise unmodified post data.
 * @return array The data to insert into the database.
 */
function insert_custom_post_modified_data( $data, $postarr ) {
	if ( ! empty( $postarr['post_modified'] ) ) {
		$data['post_modified'] = $postarr['post_modified'];
	}
	if ( ! empty( $postarr['post_modified_gmt'] ) ) {
		$data['post_modified_gmt'] = $postarr['post_modified_gmt'];
	}
	return $data;
}
