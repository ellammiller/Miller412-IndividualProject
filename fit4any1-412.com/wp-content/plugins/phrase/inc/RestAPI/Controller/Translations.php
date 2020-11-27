<?php
/**
 * REST API: Translations class
 */

namespace Phrase\WP\RestAPI\Controller;

use DateTime;
use DateTimeZone;
use Phrase\WP\PhraseAPI\PhraseAPI;
use WP_REST_Controller;
use WP_REST_Server;
use function Phrase\WP\Connections\get_post_locale;
use function Phrase\WP\Connections\get_post_project;
use function Phrase\WP\Connections\get_post_source;
use function Phrase\WP\Connections\get_post_translation;
use function Phrase\WP\Connections\get_post_translations;
use function Phrase\WP\Connections\save_post_translation;
use function Phrase\WP\Connections\update_locale_term;
use function Phrase\WP\Connections\update_post_locale;
use function Phrase\WP\Connections\update_post_project;
use const Phrase\WP\RestAPI\API_NAMESPACE;

/**
 * Class used to provide the translations route.
 */
class Translations extends WP_REST_Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = API_NAMESPACE;
		$this->rest_base = 'translations';
	}

	/**
	 * Registers the routes for the objects of the controller.
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<id>[\d]+)',
			[
				'args' => [
					'id' => [
						'description' => __( 'The ID of the post.', 'phrase' ),
						'type'        => 'integer',
					],
				],
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_item' ],
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
				],
			]
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<id>[\d]+)',
			[
				'args' => [
					'id' => [
						'description' => __( 'The ID of the post.', 'phrase' ),
						'type'        => 'integer',
					],
				],
				[
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'update_item' ],
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
					'args'                => [
						'locales' => [
							'description' => __( 'The locales to fetch translations for.', 'phrase' ),
							'type'        => 'array',
							'items'       => [
								'type'    => 'string',
								'pattern' => '^[a-f0-9]{32}$',
							],
							'minItems'    => 1,
							'uniqueItems' => true,
							'required'    => true,
						],
						'force'   => [
							'description' => __( 'Whether to skip pre-condition checks.', 'phrase' ),
							'type'        => 'boolean',
							'default'     => false,
						],
					],
				],
			]
		);
	}

	/**
	 * Permissions check for getting translation status.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has read access, otherwise WP_Error object.
	 */
	public function get_item_permissions_check( $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		if ( ! current_user_can( 'edit_posts' ) ) { // TODO: Use post specific permissions?
			return new \WP_Error(
				'rest_cannot_read',
				__( 'Sorry, you are not allowed to pull content.', 'phrase' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Get all keys for current post and pull translations.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_item( $request ) {
		$post_id               = $request->get_param( 'id' );
		$project_id            = get_post_project( $post_id );
		$locale_id             = get_post_locale( $post_id );
		$existing_translations = get_post_translations( $post_id );

		if ( ! $project_id ) {
			return rest_ensure_response(
				new \WP_Error(
					'missing_project',
					__( 'No project assigned to post.', 'phrase' ),
					[ 'status' => 412 ]
				)
			);
		}

		if ( ! $locale_id ) {
			return rest_ensure_response(
				new \WP_Error(
					'missing_locale',
					__( 'No locale assigned to post.', 'phrase' ),
					[ 'status' => 412 ]
				)
			);
		}

		// Response array.
		$translations = [];

		// Get locales for given project and fill it with translation details.
		$locales = PhraseAPI::get_instance()->get_locales( $project_id );
		if ( is_wp_error( $locales ) ) {
			return $locales;
		}

		foreach ( $locales as $locale ) {
			$translation = [
				'id'                 => $locale->getId(),
				'code'               => $locale->getCode(),
				'name'               => $locale->getName(),
				'percent_translated' => 0,
				'last_updated'       => null,
				'post_edit_url'      => '',
			];

			// Extend with data for existing translations.
			if ( isset( $existing_translations[ $locale->getId() ] ) ) {
				$translation['percent_translated'] = $existing_translations[ $locale->getId() ]['percent'] ?? 0;
				$translation['last_updated']       = $existing_translations[ $locale->getId() ]['last_update'] ?? null;
				$translation['post_edit_url']      = get_edit_post_link(
					$existing_translations[ $locale->getId() ]['post_id'],
					'raw'
				);
			}

			$translations[] = $translation;
		}

		return rest_ensure_response( $translations );
	}

	/**
	 * Permissions check for getting translations (pull content and state from phrase).
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has read access, otherwise WP_Error object.
	 */
	public function update_item_permissions_check( $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		if ( ! current_user_can( 'edit_posts' ) ) { // TODO: Use post specific permissions?
			return new \WP_Error(
				'rest_cannot_read',
				__( 'Sorry, you are not allowed to pull content.', 'phrase' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Update post translations from phrase and return status.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function update_item( $request ) {
		$post_id         = $request->get_param( 'id' );
		$request_locales = $request->get_param( 'locales' );
		$project_id      = get_post_project( $post_id );
		$post_locale_id  = get_post_locale( $post_id );
		$source_post     = get_post_source( $post_id );

		if ( ! $project_id ) {
			return new \WP_Error(
				'missing_project',
				__( 'No project assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		if ( ! $post_locale_id ) {
			return new \WP_Error(
				'missing_locale',
				__( 'No locale assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		if ( ! $source_post ) {
			return new \WP_Error(
				'missing_source_post',
				__( 'No source assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		$source_post_id       = $source_post['post_id'];
		$locales_to_update    = [];
		$locale_ids_to_update = [];

		// Get existing locales for given project to match locales we get via param.
		$locales_result = PhraseAPI::get_instance()->get_locales( $project_id );
		if ( is_wp_error( $locales_result ) ) {
			return $locales_result;
		}

		foreach ( $locales_result as $locale ) {
			// Ignore locales the user didn't request.
			if ( ! \in_array( $locale->getId(), $request_locales, true ) ) {
				continue;
			}

			$locales_to_update[]    = $locale;
			$locale_ids_to_update[] = $locale->getId();
		}

		if ( ! $locales_to_update ) {
			return new \WP_Error(
				'no_locales',
				__( 'No locales available to update.', 'phrase' ),
				[ 'status' => 400 ]
			);
		}

		// Pre-condition.
		if ( ! $request->get_param( 'force' ) ) {
			$checks       = [];
			$checks_count = 0;
			$translations = get_post_translations( $post_id );
			foreach ( $translations as $locale_id => $translation ) {
				if ( ! \in_array( $locale_id, $locale_ids_to_update, true ) ) {
					continue;
				}

				$translation_post = get_post( $translation['post_id'] );
				if ( 'publish' === $translation_post->post_status ) {
					$checks[ $locale_id ][] = 'published';
					$checks_count++;
				}

				$translation_last_update = new DateTime( $translation['last_update'] );
				$post_last_update        = new DateTime( $translation_post->post_modified_gmt );

				if ( $post_last_update > $translation_last_update ) {
					$checks[ $locale_id ][] = 'modified';
					$checks_count++;
				}
			}

			if ( ! empty( $checks ) ) {
				return new \WP_Error(
					'pre_conditions_failed',
					__( 'One or more pre-conditions need verification.', 'phrase' ),
					[
						'status' => 409,
						'checks' => $checks,
						'count'  => $checks_count,
					]
				);
			}
		}

		// Get all keys related to given post.
		// Key names starting with `post_id.`.
		$keys_result = PhraseAPI::get_instance()->get_post_keys(
			$project_id,
			$source_post_id
		);
		if ( is_wp_error( $keys_result ) ) {
			return $keys_result;
		}

		$keys = array_map(
			function( $translation_key ) {
				return $translation_key->getId();
			},
			$keys_result
		);

		// Get all translations for the keys we've fetched.
		$translations_result = PhraseAPI::get_instance()->get_translations(
			$project_id,
			$keys
		);
		if ( is_wp_error( $translations_result ) ) {
			return $keys_result;
		}

		// Group results by locale.
		$translations_grouped = [];
		foreach ( $translations_result as $item ) {
			$locale_id = $item->getLocale()->getId();
			if ( ! \array_key_exists( $locale_id, $translations_grouped ) ) {
				$translations_grouped[ $locale_id ] = [];
			}
			$translations_grouped[ $locale_id ][] = $item;
		}

		$post             = get_post( $source_post_id );
		$timestamp        = time();
		$current_date     = new DateTime( '@' . $timestamp, wp_timezone() );
		$current_date_gmt = new DateTime( '@' . $timestamp, new DateTimeZone( 'UTC' ) );

		// Calculate percentage of translated keys.
		foreach ( $locales_to_update as $locale ) {
			$locale_id = $locale->getId();

			if ( $locale_id !== $source_post['locale'] ) {
				if ( ! \array_key_exists( $locale_id, $translations_grouped ) ) {
					$percent = 0;
				} else {
					$percent = (int) ( 100 / \count( $keys ) * \count( $translations_grouped[ $locale_id ] ) );
				}

				// Check for existing translation, create one of none exist.
				$related_post_id = get_post_translation( $source_post_id, $locale_id )['post_id'] ?? 0;
				if ( ! $related_post_id ) {
					// Create initial post.
					add_filter( 'wp_insert_post_data', 'Phrase\WP\insert_custom_post_modified_data', 10, 2 );
					$related_post_id = wp_insert_post(
						[
							'post_title'        => sprintf(
								'%s [%s]',
								$post->post_title,
								sprintf(
									/* translators: %s: Locale name. */
									__( 'In translation to %s', 'phrase' ),
									$locale->getName()
								)
							),
							'post_content'      => $post->post_content,
							'post_type'         => $post->post_type,
							'post_status'       => 'draft',
							'post_modified'     => $current_date_gmt->format( 'Y-m-d H:i:s' ),
							'post_modified_gmt' => $current_date_gmt->format( 'Y-m-d H:i:s' ),
						]
					);
					remove_filter( 'wp_insert_post_data', 'Phrase\WP\insert_custom_post_modified_data' );
				}

				update_post_locale( $related_post_id, $locale_id );
				update_post_project( $related_post_id, $project_id );
			} else {
				$related_post_id = $source_post_id;
				$percent         = 100;
			}

			update_locale_term( $locale_id, $project_id );
			save_post_translation(
				$source_post_id,
				$related_post_id,
				$locale_id,
				$percent,
				$current_date->format( 'Y-m-d\TH:i:s' )
			);

			// Update the related post with keys content from Phrase.
			$target_post = get_post( $related_post_id );
			$this->update_translated_post(
				$post,
				$target_post,
				$translations_grouped[ $locale_id ] ?? [],
				[
					'post_modified'     => $current_date->format( 'Y-m-d H:i:s' ),
					'post_modified_gmt' => $current_date_gmt->format( 'Y-m-d H:i:s' ),
				]
			);
		}

		$translations = [];
		foreach ( $locales_result as $locale ) {
			$translation = [
				'id'                 => $locale->getId(),
				'code'               => $locale->getCode(),
				'name'               => $locale->getName(),
				'percent_translated' => 0,
				'last_updated'       => null,
				'post_edit_url'      => '',
			];

			// Try to get translation state for this language.
			$translation_details = get_post_translation( $post_id, $locale->getId() );

			if ( $translation_details ) {
				$translation['percent_translated'] = $translation_details['percent'] ?? 0;
				$translation['last_updated']       = $translation_details['last_update'];
				$translation['post_edit_url']      = get_edit_post_link( $translation_details['post_id'], 'raw' );
			}

			$translations[] = $translation;
		}

		return rest_ensure_response( $translations );
	}

	/**
	 * Update a target posts title, slug and contents based on translation keys.
	 *
	 * @param \WP_Post                    $source_post  The source post object.
	 * @param \WP_Post                    $target_post  The target post object (translation).
	 * @param \Phrase\Model\Translation[] $translations The translation keys.
	 * @param array                       $post_data    Optional. Additional post data to update.
	 */
	private function update_translated_post( \WP_Post $source_post, \WP_Post $target_post, array $translations, array $post_data = [] ) {
		$post_arr = array_merge(
			[
				'ID'           => $target_post->ID,
				'post_content' => $source_post->post_content,
			],
			$post_data
		);

		foreach ( $translations as $translation ) {
			if ( $source_post->ID . '.title' === $translation->getKey()->getName() ) {
				$post_arr['post_title'] = $translation->getContent();
			} elseif ( $source_post->ID . '.slug' === $translation->getKey()->getName() ) {
				$post_arr['post_name'] = $translation->getContent();
			} elseif ( false !== strpos( $translation->getKey()->getName(), $source_post->ID . '.content' ) ) {
				// @todo add content translations (either block by block or single post content for classic editor).
				$post_arr['post_content'] = $this->replace_block_content( $post_arr['post_content'], $source_post->ID, $translation );
			}
		}

		add_filter( 'wp_insert_post_data', 'Phrase\WP\insert_custom_post_modified_data', 10, 2 );
		wp_update_post( $post_arr );
		remove_filter( 'wp_insert_post_data', 'Phrase\WP\insert_custom_post_modified_data' );
	}

	/**
	 * Replace a translation in post_content of target post.
	 *
	 * @param string                    $post_content The post content to replace blocks in.
	 * @param int                       $source_post_id The post ID of the source post.
	 * @param \Phrase\Model\Translation $translation The translation key.
	 * @return string The replaced post content.
	 */
	private function replace_block_content( string $post_content, int $source_post_id, \Phrase\Model\Translation $translation ): string {
		$key_name = str_replace( $source_post_id . '.content.', '', $translation->getKey()->getName() );
		$key_name = preg_quote( $key_name, '#' );

		$post_content = preg_replace(
			'#(?P<tagopen><!--\s(?P<blocktype>[a-z:]+)\s{[\s\S]*?"phraseKeyName":"' . $key_name . '"[\s\S]*?}\s-->)(?P<blockcontent>(?:(?!<!--).)*)(?P<tagclose><!--\s/(?P=blocktype)\s-->)#ms',
			'$1' . $translation->getContent() . '$4',
			$post_content
		);

		return $post_content;
	}
}
