<?php
/**
 * Communication with the phrase api.
 */

namespace Phrase\WP\PhraseAPI;

use GuzzleHttp\Client;
use Phrase\Configuration;
use Phrase\WP\Admin\Settings;
use const Phrase\WP\VERSION;

/**
 * The PhraseAPI class.
 */
class PhraseAPI {

	/**
	 * The PhraseAPI instance.
	 *
	 * @var \Phrase\WP\PhraseAPI\PhraseAPI
	 */
	private static $instance = null;

	/**
	 * The HTTP client.
	 *
	 * @var \GuzzleHttp\ClientInterface|null The HTTP client.
	 */
	private $client = null;

	/**
	 * The API configuration.
	 *
	 * @var \Phrase\Configuration|null The config object.
	 */
	private $config = null;

	/**
	 * Array of accounts.
	 *
	 * @var \Phrase\Model\AccountDetails[] The accounts details models.
	 */
	private $account_details = [];

	/**
	 * Internal store of loaded projects.
	 *
	 * @var \Phrase\Model\Project[] The projects.
	 */
	private $projects = [];

	/**
	 * The constructor.
	 */
	private function __construct() {
		$this->client = new Client(
			[
				'connect_timeout' => 5,
				'timeout'         => 5,
			]
		);
		$this->config = Configuration::getDefaultConfiguration()
				->setApiKey( 'Authorization', Settings::get_access_token() )
				->setApiKeyPrefix( 'Authorization', 'token' );
		$this->config->setUserAgent( 'Phrase WordPress Plugin/' . VERSION . ';' . $this->config->getUserAgent() );
	}

	/**
	 * Get PhraseAPI instance.
	 *
	 * @return \Phrase\WP\PhraseAPI\PhraseAPI The PhraseAPI instance.
	 */
	public static function get_instance(): PhraseAPI {
		if ( null === static::$instance ) {
			static::$instance = new PhraseAPI();
		}

		return static::$instance;
	}

	/**
	 * Retrieves account details.
	 *
	 * @param string $id The accounts id.
	 * @return \Phrase\Model\AccountDetails|\WP_Error The account details object or WP_Error on error.
	 */
	public function get_account_details( string $id ) {
		if ( \array_key_exists( $id, $this->account_details ) ) {
			return $this->account_details[ $id ];
		}

		$api = new \Phrase\Api\AccountsApi(
			$this->client,
			$this->config
		);

		try {
			$this->account_details[ $id ] = $api->accountShow( $id );
			return $this->account_details[ $id ];
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Retrieves a single project.
	 *
	 * @param string $project_id The project ID.
	 * @return \Phrase\Model\Project|\WP_Error The project object or WP_Error on error.
	 */
	public function get_project( string $project_id ) {
		if ( \array_key_exists( $project_id, $this->projects ) ) {
			return $this->projects[ $project_id ];
		}

		$api = new \Phrase\Api\ProjectsApi(
			$this->client,
			$this->config
		);

		try {
			$this->projects[ $project_id ] = $api->projectShow( $project_id );
			return $this->projects[ $project_id ];
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Retrieves a single locale.
	 *
	 * @param string $project_id The project ID.
	 * @param string $locale_id The locale ID.
	 * @return \Phrase\Model\Locale|\WP_Error The locale object or WP_Error on error.
	 */
	public function get_locale( string $project_id, string $locale_id ) {
		$api = new \Phrase\Api\LocalesApi(
			$this->client,
			$this->config
		);

		try {
			return $api->localeShow( $project_id, $locale_id );
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Retrieves list of projects.
	 *
	 * @return \Phrase\Model\Project[]\WP_Error Array of phrase projects or WP_Error on error.
	 */
	public function get_projects() {
		$api = new \Phrase\Api\ProjectsApi(
			$this->client,
			$this->config
		);

		try {
			$projects = $api->projectsList( null, 1, 100 );
			// The API doesn't provide a sort/order option yet.
			usort(
				$projects,
				static function ( $a, $b ) {
					return strnatcasecmp( $a->getName(), $b->getName() );
				}
			);
			return $projects;
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Retrieves list of locales for a given project.
	 *
	 * @param string $project_id The project ID to fetch locales for.
	 * @return \Phrase\Model\Locale[]|\WP_Error Array of locales or WP_Error on error.
	 */
	public function get_locales( string $project_id ) {
		$api = new \Phrase\Api\LocalesApi(
			$this->client,
			$this->config
		);

		try {
			return $api->localesList( $project_id, null, 1, 100 );
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Extracts translatable block content.
	 *
	 * TODO: Move out of this class.
	 *
	 * @param int       $post_id Post ID of the block.
	 * @param \WP_Block $block   Block object.
	 * @return array List of translatable content.
	 */
	private static function get_translatable_block_contents( $post_id, $block ) {
		$data = [];

		// Ignore blocks without a key name.
		if ( ! empty( $block['attrs']['phraseKeyName'] ) ) {
			// Remove leading and trailing new lines.
			$content              = trim( $block['innerHTML'], "\n" );
			$content_without_html = wp_strip_all_tags( $content, true );

			// Ignore blocks which only have HTML.
			if ( ! empty( $content_without_html ) ) {
				$data[ $post_id . '.content.' . $block['attrs']['phraseKeyName'] ] = $content;
			}
		}

		// TODO: Support attributes.

		if ( ! empty( $block['innerBlocks'] ) ) {
			foreach ( $block['innerBlocks'] as $inner_block ) {
				$data = array_merge( $data, self::get_translatable_block_contents( $post_id, $inner_block ) );
			}
		}

		return $data;
	}

	/**
	 * Uploads JSON data to Phrase.
	 *
	 * @throws \Exception When no locales can be fetched.
	 *
	 * @param string $project_id          The project ID to push the content to.
	 * @param string $locale_id           The locale ID of the content.
	 * @param array  $data                The content to upload.
	 * @param bool   $skip_unverification Optional. Whether the upload should unverify updated translations.
	 * @return \Phrase\Model\Upload|\WP_Error Upload details or WP_Error on error.
	 */
	public function upload( string $project_id, string $locale_id, array $data, bool $skip_unverification = false ) {
		// Include filesystem functions to get access to wp_tempnam().
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$temp_file = wp_tempnam( 'phrase-upload' );
		file_put_contents( $temp_file, wp_json_encode( $data ) );

		// The API requires a valid file extension, not .tmp.
		$file = str_replace( '.tmp', '.json', $temp_file );
		rename( $temp_file, $file );

		$api = new \Phrase\Api\UploadsApi(
			$this->client,
			$this->config
		);

		try {
			return $api->uploadCreate(
				$project_id,
				null,
				null,
				$file,
				'simple_json', // TODO: Use nested_json for block attributes?
				$locale_id,
				null,
				true, // Update translations.
				null,
				null,
				null,
				$skip_unverification
			);
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		} finally {
			// Delete the temp file.
			unlink( $file );
		}
	}

	/**
	 * Pushes content of a post to Phrase.
	 *
	 * @param int    $post_id             The post ID of the content to push.
	 * @param string $project_id          The project ID to push the content to.
	 * @param string $locale_id           The locale ID of the content.
	 * @param bool   $skip_unverification Optional. Whether the upload should unverify updated translations.
	 * @return \Phrase\Model\Upload Upload details.
	 */
	public function push_content( int $post_id, string $project_id, string $locale_id, bool $skip_unverification = false ) {
		$post = get_post( $post_id );

		$data = [];
		if ( $post->post_title ) {
			$data[ $post_id . '.title' ] = $post->post_title;
		}
		if ( $post->post_name ) {
			$data[ $post_id . '.slug' ] = $post->post_name;
		}

		if ( has_blocks( $post ) ) {
			$blocks = parse_blocks( $post->post_content );

			foreach ( $blocks as $block ) {
				$data = array_merge( $data, self::get_translatable_block_contents( $post_id, $block ) );
			}
		} else {
			$data[ $post_id . '.content' ] = $post->post_content;
		}

		return $this->upload( $project_id, $locale_id, $data, $skip_unverification );
	}

	/**
	 * Pushes translation of a post to Phrase.
	 *
	 * @param int    $post_id         The post ID of the content to push.
	 * @param string $project_id      The project ID to push the content to.
	 * @param string $locale_id       The locale ID of the content.
	 * @param int    $source_post_id  The post ID of source of the content to push.
	 * @return \Phrase\Model\Upload Upload details.
	 */
	public function push_translation( int $post_id, string $project_id, string $locale_id, int $source_post_id ) {
		$keys = $this->get_post_keys( $project_id, $source_post_id );
		$post = get_post( $post_id );

		$data = [];
		if ( $post->post_title ) {
			$data[ $source_post_id . '.title' ] = $post->post_title;
		}
		if ( $post->post_name ) {
			$data[ $source_post_id . '.slug' ] = $post->post_name;
		}

		if ( has_blocks( $post ) ) {
			$blocks = parse_blocks( $post->post_content );

			foreach ( $blocks as $block ) {
				$data = array_merge( $data, self::get_translatable_block_contents( $source_post_id, $block ) );
			}
		} else {
			$data[ $source_post_id . '.content' ] = $post->post_content;
		}

		// Only push translations of known keys.
		$data_to_upload = [];
		foreach ( $keys as $key ) {
			if ( isset( $data[ $key->getName() ] ) ) {
				$data_to_upload[ $key->getName() ] = $data[ $key->getName() ];
			}
		}

		return $this->upload( $project_id, $locale_id, $data_to_upload );
	}

	/**
	 * Retrieves status of a previous upload.
	 *
	 * @param string $project_id The ID of the project.
	 * @param string $upload_id  The ID of the upload.
	 * @return \Phrase\Model\Upload|\WP_Error Upload details or WP_Error on error.
	 */
	public function get_upload_status( string $project_id, string $upload_id ) {
		$api = new \Phrase\Api\UploadsApi(
			$this->client,
			$this->config
		);

		try {
			return $api->uploadShow( $project_id, $upload_id );
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Retrieves keys for a given post ID.
	 *
	 * @param string $project_id The ID of the project.
	 * @param int    $post_id The ID of the post.
	 * @return \Phrase\Model\TranslationKey[]|\WP_Error Array of keys or WP_Error on error.
	 */
	public function get_post_keys( string $project_id, int $post_id ) {
		$api = new \Phrase\Api\KeysApi(
			$this->client,
			$this->config
		);

		try {
			return $api->keysList(
				$project_id,
				null,
				null,
				null,
				null,
				null,
				null,
				"{$post_id}."
			);
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Retrieves translations for given keys.
	 *
	 * @param string $project_id The ID of the project.
	 * @param array  $keys       Array of keys we want to fetch translations for.
	 * @return \Phrase\Model\Translation[]|\WP_Error Array of translations or WP_Error on error.
	 */
	public function get_translations( string $project_id, array $keys = [] ) {
		$api = new \Phrase\Api\TranslationsApi(
			$this->client,
			$this->config
		);

		try {
			$q = [];

			if ( $keys ) {
				$q[] = 'key.id:' . implode( ',', $keys );
			}

			return $api->translationsList(
				$project_id,
				null,
				null,
				null,
				null,
				null,
				null,
				implode( ' ', $q )
			);
		} catch ( \InvalidArgumentException $e ) {
			return new \WP_Error( 'argument_error', $e->getMessage() );
		} catch ( \Phrase\ApiException $e ) {
			return $this->parse_api_exception( $e );
		} catch ( \Exception $e ) {
			return new \WP_Error( 'unknown_error', $e->getMessage() );
		}
	}

	/**
	 * Converts an API exception into a WP_Error object.
	 *
	 * @param \Phrase\ApiException $exception The API exception object.
	 * @return \WP_Error The WP error object.
	 */
	private function parse_api_exception( \Phrase\ApiException $exception ) {
		switch ( $exception->getCode() ) {
			case 403:
				return new \WP_Error(
					'insufficient_access',
					__( 'The Phrase API access token has insufficient access.', 'phrase' ),
					[
						'original_message' => $exception->getMessage(),
					]
				);

			case 401:
				return new \WP_Error(
					'invalid_access_token',
					__( 'No valid Phrase API access token provided.', 'phrase' ),
					[
						'original_message' => $exception->getMessage(),
					]
				);

			case 0:
				return new \WP_Error(
					'failed_connection',
					__( 'A connection to the Phrase API server could not be established.', 'phrase' ),
					[
						'original_message' => $exception->getMessage(),
					]
				);

			default:
				return new \WP_Error(
					'api_error',
					__( 'The Phrase API request has failed.', 'phrase' ),
					[
						'original_message' => $exception->getMessage(),
					]
				);
		}
	}

	/**
	 * No cloning.
	 */
	private function __clone() {}

	/**
	 * No unserialization.
	 */
	private function __wakeup() {}
}
