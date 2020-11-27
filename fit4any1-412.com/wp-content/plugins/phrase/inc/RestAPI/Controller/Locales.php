<?php
/**
 * REST API: Locales class
 */

namespace Phrase\WP\RestAPI\Controller;

use Phrase\WP\PhraseAPI\PhraseAPI;
use WP_REST_Controller;
use WP_REST_Server;
use const Phrase\WP\RestAPI\API_NAMESPACE;

/**
 * Class used to provide the locales route.
 */
class Locales extends WP_REST_Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = API_NAMESPACE;
		$this->rest_base = 'locales';
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
	 * Permissions check for getting locales.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has read access, otherwise WP_Error object.
	 */
	public function get_items_permissions_check( $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		if ( ! current_user_can( 'edit_posts' ) ) {
			return new \WP_Error(
				'rest_cannot_read',
				__( 'Sorry, you are not allowed to view locales.', 'phrase' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Retrieves the locales.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_items( $request ) {
		$results = PhraseAPI::get_instance()->get_locales( $request->get_param( 'project_id' ) );
		if ( is_wp_error( $results ) ) {
			return $results;
		}

		$locales = [];
		foreach ( $results as $locale ) {
			$data      = $this->prepare_item_for_response( $locale, $request );
			$locales[] = $this->prepare_response_for_collection( $data );
		}

		return rest_ensure_response( $locales );
	}

	/**
	 * Prepares the item for the REST response.
	 *
	 * @param \Phrase\Model\Locale $item    Locale object.
	 * @param \WP_REST_Request     $request Request object.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function prepare_item_for_response( $item, $request ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$data = [
			'id'      => $item->getId(),
			'name'    => $item->getName(),
			'code'    => $item->getCode(),
			'default' => $item->getDefault(),
			'main'    => $item->getMain(),
		];
		return rest_ensure_response( $data );
	}

	/**
	 * Retrieves the query params for the collections.
	 *
	 * @return array Query parameters for the collection.
	 */
	public function get_collection_params() {
		return [
			'project_id' => [
				'description' => __( 'The project ID to get locales from.', 'phrase' ),
				'type'        => 'string',
				'pattern'     => '^[a-f0-9]{32}$',
				'required'    => true,
			],
		];
	}
}
