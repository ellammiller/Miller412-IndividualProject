<?php
/**
 * REST API: Projects class
 */

namespace Phrase\WP\RestAPI\Controller;

use Phrase\WP\PhraseAPI\PhraseAPI;
use WP_REST_Controller;
use WP_REST_Server;
use const Phrase\WP\RestAPI\API_NAMESPACE;

/**
 * Class used to provide the projects route.
 */
class Projects extends WP_REST_Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = API_NAMESPACE;
		$this->rest_base = 'projects';
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
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items' ],
					'permission_callback' => [ $this, 'get_items_permissions_check' ],
					'args'                => $this->get_collection_params(),
				],
			]
		);
	}

	/**
	 * Permissions check for getting projects.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has read access, otherwise WP_Error object.
	 */
	public function get_items_permissions_check( $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		if ( ! current_user_can( 'edit_posts' ) ) {
			return new \WP_Error(
				'rest_cannot_read',
				__( 'Sorry, you are not allowed to view projects.', 'phrase' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Retrieves the projects.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_items( $request ) {
		$results = PhraseAPI::get_instance()->get_projects();
		if ( is_wp_error( $results ) ) {
			return $results;
		}

		$projects = [];
		foreach ( $results as $project ) {
			$data       = $this->prepare_item_for_response( $project, $request );
			$projects[] = $this->prepare_response_for_collection( $data );
		}

		return rest_ensure_response( $projects );
	}

	/**
	 * Prepares the item for the REST response.
	 *
	 * @param \Phrase\Model\Project $item    Project object.
	 * @param \WP_REST_Request      $request Request object.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function prepare_item_for_response( $item, $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$data = [
			'id'     => $item->getId(),
			'name'   => $item->getName(),
			'format' => $item->getMainFormat(),
			'url'    => sprintf(
				'https://app.phrase.com/accounts/%s/projects/%s',
				$item->getAccount()->getSlug(),
				$item->getSlug()
			),
		];
		return rest_ensure_response( $data );
	}

	/**
	 * Retrieves the query params for the collections.
	 *
	 * @return array Query parameters for the collection.
	 */
	public function get_collection_params() {
		return [];
	}
}
