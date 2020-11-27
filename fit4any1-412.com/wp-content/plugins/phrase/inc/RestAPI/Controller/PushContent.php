<?php
/**
 * REST API: PushContent class
 */

namespace Phrase\WP\RestAPI\Controller;

use Phrase\WP\PhraseAPI\PhraseAPI;
use WP_REST_Controller;
use WP_REST_Server;
use function Phrase\WP\Connections\save_post_translation;
use function Phrase\WP\Connections\update_locale_term;
use function Phrase\WP\Connections\update_project_term;
use const Phrase\WP\RestAPI\API_NAMESPACE;

/**
 * Class used to provide the content push route.
 */
class PushContent extends WP_REST_Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = API_NAMESPACE;
		$this->rest_base = 'push-content';
	}

	/**
	 * Registers the routes for the objects of the controller.
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			[
				[
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => [ $this, 'create_item' ],
					'permission_callback' => [ $this, 'create_item_permissions_check' ],
					'args'                => [
						'post_id'             => [
							'description' => __( 'The ID of the post object.', 'phrase' ),
							'type'        => 'integer',
							'required'    => true,
						],
						'project_id'          => [
							'description' => __( 'The ID of the Phrase project.', 'phrase' ),
							'type'        => 'string',
							'pattern'     => '^[a-f0-9]{32}$',
							'required'    => true,
						],
						'locale_id'           => [
							'description' => __( 'The ID of the locale.', 'phrase' ),
							'type'        => 'string',
							'pattern'     => '^[a-f0-9]{32}$',
							'required'    => true,
						],
						'skip_unverification' => [
							'description' => __( 'Whether the upload should unverify updated translations.', 'phrase' ),
							'type'        => 'boolean',
							'default'     => false,
						],
					],
				],
			]
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<upload_id>[a-z0-9]+)',
			[
				'args' => [
					'upload_id' => [
						'description' => __( 'The ID of the upload.', 'phrase' ),
						'type'        => 'string',
					],
				],
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_item' ],
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
					'args'                => [
						'project_id' => [
							'description' => __( 'The ID of the Phrase project.', 'phrase' ),
							'type'        => 'string',
							'required'    => true,
						],
					],
				],
			]
		);
	}

	/**
	 * Permissions check for pushing content.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has read access, otherwise WP_Error object.
	 */
	public function create_item_permissions_check( $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		if ( ! current_user_can( 'edit_posts' ) ) { // TODO: Use post specific permissions?
			return new \WP_Error(
				'rest_cannot_read',
				__( 'Sorry, you are not allowed to push content.', 'phrase' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Creates a new upload to push the content.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function create_item( $request ) {
		$post_id             = $request->get_param( 'post_id' );
		$project_id          = $request->get_param( 'project_id' );
		$locale_id           = $request->get_param( 'locale_id' );
		$skip_unverification = $request->get_param( 'skip_unverification' );

		$upload = PhraseAPI::get_instance()->push_content(
			$post_id,
			$project_id,
			$locale_id,
			$skip_unverification
		);
		if ( is_wp_error( $upload ) ) {
			return $upload;
		}

		update_locale_term( $locale_id, $project_id );
		update_project_term( $project_id );
		save_post_translation( $post_id, $post_id, $locale_id, 100, gmdate( 'Y-m-d\TH:i:s' ) );

		$data = $this->prepare_item_for_response( $upload, $request );

		return rest_ensure_response( $data );
	}

	/**
	 * Permissions check for pushing content.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has read access, otherwise WP_Error object.
	 */
	public function get_item_permissions_check( $request ) {
		return $this->create_item_permissions_check( $request );
	}

	/**
	 * Creates a new upload to push the content.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_item( $request ) {
		$upload = PhraseAPI::get_instance()->get_upload_status(
			$request->get_param( 'project_id' ),
			$request->get_param( 'upload_id' )
		);
		if ( is_wp_error( $upload ) ) {
			return $upload;
		}

		$data = $this->prepare_item_for_response( $upload, $request );

		return rest_ensure_response( $data );
	}

	/**
	 * Prepares the upload item for the REST response.
	 *
	 * @param \Phrase\Model\Upload $upload  Upload item.
	 * @param \WP_REST_Request     $request Request object.
	 * @return \WP_REST_Response Response object.
	 */
	public function prepare_item_for_response( $upload, $request ) {
		$data = [
			'id'                  => $upload->getId(),
			'state'               => $upload->getState(),
			'translation_created' => $upload->getSummary()->getTranslationsCreated(),
			'translation_updated' => $upload->getSummary()->getTranslationsUpdated(),
			'app_editor_url'      => null,
			'app_upload_url'      => null,
		];

		if ( 'success' === $upload->getState() ) {
			// Append the URLs to view/translate in web app.
			$project = PhraseAPI::get_instance()->get_project(
				$request->get_param( 'project_id' )
			);

			if ( ! is_wp_error( $project ) ) {
				$data['app_editor_url'] = add_query_arg(
					[
						'editor_search'    => [
							'query' => 'tag:' . $upload->getTag(),
						],
						'target_locale_id' => $request->get_param( 'locale_id' ),
					],
					sprintf(
						'https://app.phrase.com/accounts/%s/projects/%s/editor',
						$project->getAccount()->getSlug(),
						$project->getSlug()
					)
				);

				$data['app_upload_url'] = sprintf(
					'https://app.phrase.com/accounts/%s/projects/%s/uploads/%s',
					$project->getAccount()->getSlug(),
					$project->getSlug(),
					$upload->getId()
				);
			}
		}

		return rest_ensure_response( $data );
	}
}
