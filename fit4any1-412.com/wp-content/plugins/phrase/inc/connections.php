<?php
/**
 * This file is to hold all the functionality for connecting
 * posts with translation data.
 */

namespace Phrase\WP\Connections;

use Phrase\WP\PhraseAPI\PhraseAPI;
use function Phrase\WP\get_supported_post_types;

const LOCALE_TAXONOMY               = 'phrase_locale';
const PROJECT_TAXONOMY              = 'phrase_project';
const TRANSLATION_RELATION_TAXONOMY = 'phrase_translation';
const PROJECT_URL_META_KEY          = 'phrase_project_url';
const LOCALE_CODE_META_KEY          = 'phrase_locale_code';

/**
 * Bootstrap.
 */
function bootstrap(): void {
	add_action( 'init', __NAMESPACE__ . '\register_taxonomies' );
	add_action( 'before_delete_post', __NAMESPACE__ . '\delete_translation_on_post_delete' );
}

/**
 * Register custom taxonomies.
 */
function register_taxonomies() {
	foreach ( [ LOCALE_TAXONOMY, PROJECT_TAXONOMY, TRANSLATION_RELATION_TAXONOMY ] as $taxonomy ) {
		register_taxonomy(
			$taxonomy,
			get_supported_post_types(),
			[
				'public'                => false,
				'query_var'             => false,
				'rewrite'               => false,
				'update_count_callback' => '_update_generic_term_count',
			]
		);
	}
}

/**
 * Retrieves assigned locale ID of a post.
 *
 * @param int $post_id Post ID.
 * @return string Locale ID on success, empty string if not set.
 */
function get_post_locale( int $post_id ): string {
	/** @var \WP_Term[] $terms */
	$terms = wp_get_object_terms( $post_id, LOCALE_TAXONOMY );
	/** @var \WP_Term $term */
	$term = reset( $terms );

	if ( empty( $term ) ) {
		return '';
	}

	return $term->slug;
}

/**
 * Updates assigned locale ID of a post.
 *
 * @param int    $post_id   Post ID.
 * @param string $locale_id Locale ID.
 * @return bool True on success, false otherwise.
 */
function update_post_locale( int $post_id, string $locale_id ) {
	$term = term_exists( $locale_id, LOCALE_TAXONOMY );
	if ( ! $term ) {
		wp_insert_term( $locale_id, LOCALE_TAXONOMY );
	}

	$updated = wp_set_object_terms( $post_id, $locale_id, LOCALE_TAXONOMY );
	return \is_array( $updated );
}

/**
 * Retrieves assigned project ID of a post.
 *
 * @param int $post_id Post ID.
 * @return string Project ID on success, empty string if not set.
 */
function get_post_project( int $post_id ): string {
	/** @var \WP_Term[] $terms */
	$terms = wp_get_object_terms( $post_id, PROJECT_TAXONOMY );
	/** @var \WP_Term $term */
	$term = reset( $terms );

	if ( empty( $term ) ) {
		return '';
	}

	return $term->slug;
}

/**
 * Updates assigned project ID of a post.
 *
 * @param int    $post_id    Post ID.
 * @param string $project_id Project ID.
 * @return bool True on success, false otherwise.
 */
function update_post_project( int $post_id, string $project_id ): bool {
	$term = term_exists( $project_id, PROJECT_TAXONOMY );
	if ( ! $term ) {
		wp_insert_term( $project_id, PROJECT_TAXONOMY );
	}

	$updated = wp_set_object_terms( $post_id, $project_id, PROJECT_TAXONOMY );
	return \is_array( $updated );
}

/**
 * Updates project term meta data based on Phrase API response.
 *
 * @param string $project_id The project ID.
 */
function update_project_term( string $project_id ) {
	$term = term_exists( $project_id, PROJECT_TAXONOMY );
	if ( ! $term ) {
		// Don't create terms we're not using.
		return;
	}

	try {
		$project = PhraseAPI::get_instance()->get_project( $project_id );
	} catch ( \Exception $e ) {
		return;
	}

	$url = sprintf(
		'https://app.phrase.com/accounts/%s/projects/%s',
		$project->getAccount()->getSlug(),
		$project->getSlug()
	);

	update_term_meta( $term['term_id'], PROJECT_URL_META_KEY, esc_url_raw( $url ) );
	wp_update_term( $term['term_id'], PROJECT_TAXONOMY, [ 'name' => $project->getName() ] );
}

/**
 * Retrieves project URL.
 *
 * @param string $project_id The project ID.
 * @return string The project URL or empty string if project doesn't exist.
 */
function get_project_url( string $project_id ): string {
	$term = term_exists( $project_id, PROJECT_TAXONOMY );
	if ( ! $term ) {
		return '';
	}

	return get_term_meta( $term['term_id'], PROJECT_URL_META_KEY, true );
}

/**
 * Retrieves project name.
 *
 * @param string $project_id The project ID.
 * @return string The project name or empty string if project doesn't exist.
 */
function get_project_name( string $project_id ): string {
	$term = get_term_by( 'slug', $project_id, PROJECT_TAXONOMY );
	if ( ! $term ) {
		return '';
	}

	return $term->name;
}

/**
 * Updates locale term meta data based on Phrase API response.
 *
 * @param string $locale_id The locale ID.
 * @param string $project_id The project ID.
 */
function update_locale_term( string $locale_id, string $project_id ) {
	$term = term_exists( $locale_id, LOCALE_TAXONOMY );
	if ( ! $term ) {
		// Don't create terms we're not using.
		return;
	}

	try {
		$locale = PhraseAPI::get_instance()->get_locale( $project_id, $locale_id );
	} catch ( \Exception $e ) {
		return;
	}

	wp_update_term(
		$term['term_id'],
		LOCALE_TAXONOMY,
		[
			'name' => $locale->getName(),
			'slug' => $locale->getId(),
		]
	);
	update_term_meta( $term['term_id'], LOCALE_CODE_META_KEY, $locale->getCode() );
}

/**
 * Retrieves locale code.
 *
 * @param string $locale_id The locale ID.
 * @return string The locale code or empty string.
 */
function get_locale_code( string $locale_id ): string {
	$term = term_exists( $locale_id, LOCALE_TAXONOMY );
	if ( ! $term ) {
		return '';
	}

	return get_term_meta( $term['term_id'], LOCALE_CODE_META_KEY, true );
}

/**
 * Retrieves locale name.
 *
 * @param string $locale_id The locale ID.
 * @return string The locale name or empty string.
 */
function get_locale_name( string $locale_id ): string {
	$term = get_term_by( 'slug', $locale_id, LOCALE_TAXONOMY );
	if ( ! $term ) {
		return '';
	}

	return $term->name;
}

/**
 * Retrieves all translations of a post.
 *
 * @param int $post_id Post ID.
 * @return array List of translations, keyed by locale ID.
 */
function get_post_translations( int $post_id ): array {
	$translation_group_terms = wp_get_object_terms( $post_id, TRANSLATION_RELATION_TAXONOMY );
	$translation_group_term  = reset( $translation_group_terms );

	if ( empty( $translation_group_term ) ) {
		return [];
	}

	$translations = json_decode( $translation_group_term->description, true );
	if ( ! $translations ) {
		return [];
	}

	return $translations;
}

/**
 * Retrieves translation relation of a post.
 *
 * @param int    $post_id   Post ID.
 * @param string $locale_id Locale ID.
 * @return array Translation data on success, null if not exists.
 */
function get_post_translation( int $post_id, string $locale_id ): ?array {
	$translations = get_post_translations( $post_id );
	return $translations[ $locale_id ] ?? null;
}

/**
 * Retrieves source relation of a post.
 *
 * @param int $post_id Post ID.
 * @return array Translation data on success, null if not exists.
 */
function get_post_source( int $post_id ): ?array {
	$translations = get_post_translations( $post_id );

	foreach ( $translations as $locale_id => $translation ) {
		if ( $translation['is_source'] ) {
			$translation['locale'] = $locale_id;
			return $translation;
		}
	}

	return null;
}

/**
 * Saves a translation relation.
 *
 * @param int         $post_id            Post ID.
 * @param int         $translated_post_id Post ID.
 * @param string      $locale_id          Locale ID.
 * @param int         $percent_completed  Translation progress ins percent.
 * @param string|null $last_updated       Date of last update.
 */
function save_post_translation( int $post_id, int $translated_post_id, string $locale_id, int $percent_completed = 0, ?string $last_updated = null ) {
	$translation_group_terms = wp_get_object_terms( [ $post_id, $translated_post_id ], TRANSLATION_RELATION_TAXONOMY );
	$translation_group_term  = reset( $translation_group_terms );

	$translations = [
		$locale_id => [
			'post_id'     => $translated_post_id,
			'percent'     => $percent_completed,
			'last_update' => $last_updated,
			'is_source'   => $post_id === $translated_post_id,
		],
	];

	if ( empty( $translation_group_term ) ) {
		// Create a new group term.
		$translation_group_name = uniqid( 'phrase_translation_group_' );
		$translation_group_term = wp_insert_term(
			$translation_group_name,
			TRANSLATION_RELATION_TAXONOMY,
			[
				'description' => json_encode( $translations ),
			]
		);
	} else {
		// Merge new and existing translations.
		$existing_translations = json_decode( $translation_group_term->description, true );
		$translations          = array_merge( $existing_translations, $translations );
		wp_update_term(
			$translation_group_term->term_id,
			TRANSLATION_RELATION_TAXONOMY,
			[
				'description' => json_encode( $translations ),
			]
		);

		$translation_group_name = $translation_group_term->term_id;
	}

	// Assign the term to the source and translation.
	wp_set_object_terms( $post_id, $translation_group_name, TRANSLATION_RELATION_TAXONOMY );
	wp_set_object_terms( $translated_post_id, $translation_group_name, TRANSLATION_RELATION_TAXONOMY );
}

/**
 * Removes a translation relation when a post is deleted.
 *
 * @param int $post_id Post ID.
 */
function delete_translation_on_post_delete( $post_id ) {
	$post_id   = (int) $post_id;
	$locale_id = get_post_locale( $post_id );
	if ( ! $locale_id ) {
		return;
	}

	remove_post_translation( $post_id, $locale_id );
}

/**
 * Removes a translation relation.
 *
 * @param int    $post_id   Post ID.
 * @param string $locale_id Locale ID.
 */
function remove_post_translation( int $post_id, string $locale_id ) {
	$translation_group_terms = wp_get_object_terms( $post_id, TRANSLATION_RELATION_TAXONOMY );
	$translation_group_term  = reset( $translation_group_terms );

	if ( empty( $translation_group_term ) ) {
		return;
	}

	$translations = json_decode( $translation_group_term->description, true );
	unset( $translations[ $locale_id ] );

	wp_update_term(
		$translation_group_term->term_id,
		TRANSLATION_RELATION_TAXONOMY,
		[
			'description' => json_encode( $translations ),
		]
	);

	wp_remove_object_terms( $post_id, $translation_group_term->term_id, TRANSLATION_RELATION_TAXONOMY );

	// Remove term group if all translations are removed.
	$term = get_term( $translation_group_term->term_id, TRANSLATION_RELATION_TAXONOMY );
	if ( empty( $term->count ) ) {
		wp_delete_term( $term->term_id, TRANSLATION_RELATION_TAXONOMY );
	}
}
