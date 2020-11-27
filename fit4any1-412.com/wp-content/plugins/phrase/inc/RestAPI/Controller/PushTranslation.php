<?php
/**
 * REST API: PushTranslation class
 */

namespace Phrase\WP\RestAPI\Controller;

use Phrase\WP\PhraseAPI\PhraseAPI;
use WP_REST_Controller;
use WP_REST_Server;
use function Phrase\WP\Connections\get_post_locale;
use function Phrase\WP\Connections\get_post_project;
use function Phrase\WP\Connections\get_post_source;
use const Phrase\WP\RestAPI\API_NAMESPACE;

/**
 * Class used to provide the translation push route.
 */
class PushTranslation extends WP_REST_Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = API_NAMESPACE;
		$this->rest_base = 'push-translation';
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
						'post_id' => [
							'description' => __( 'The ID of the post object.', 'phrase' ),
							'type'        => 'integer',
							'required'    => true,
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
						'post_id' => [
							'description' => __( 'The ID of the post object.', 'phrase' ),
							'type'        => 'integer',
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
		$post_id    = $request->get_param( 'post_id' );
		$project_id = get_post_project( $post_id );
		$locale_id  = get_post_locale( $post_id );

		if ( ! $project_id ) {
			return new \WP_Error(
				'missing_project',
				__( 'No project assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		if ( ! $locale_id ) {
			return new \WP_Error(
				'missing_locale',
				__( 'No locale assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		$source = get_post_source( $post_id );
		if ( ! $source ) {
			return new \WP_Error(
				'missing_source',
				__( 'No source assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		if ( $post_id === $source['post_id'] ) {
			return new \WP_Error(
				'cannot_push_source',
				__( 'You cannot push the source.', 'phrase' ),
				[ 'status' => 400 ]
			);
		}

		$upload = PhraseAPI::get_instance()->push_translation(
			$post_id,
			$project_id,
			$locale_id,
			$source['post_id']
		);
		if ( is_wp_error( $upload ) ) {
			return $upload;
		}

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
		$post_id    = $request->get_param( 'post_id' );
		$project_id = get_post_project( $post_id );
		$locale_id  = get_post_locale( $post_id );

		if ( ! $project_id ) {
			return new \WP_Error(
				'missing_project',
				__( 'No project assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		if ( ! $locale_id ) {
			return new \WP_Error(
				'missing_locale',
				__( 'No locale assigned to post.', 'phrase' ),
				[ 'status' => 412 ]
			);
		}

		$request->set_param( 'project_id', $project_id );
		$request->set_param( 'locale_id', $locale_id );

		$upload = PhraseAPI::get_instance()->get_upload_status(
			$project_id,
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
	public function prepare_item_for_response( $upload, $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$data = [
			'id'                  => $upload->getId(),
			'state'               => $upload->getState(),
			'translation_created' => $upload->getSummary()->getTranslationsCreated(),
			'translation_updated' => $upload->getSummary()->getTranslationsUpdated(),
			'app_editor_url'      => null,
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
			}
		}

		return rest_ensure_response( $data );
	}
}
