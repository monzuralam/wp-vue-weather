<?php

namespace WPVueWeather\Api;

use WP_REST_Controller;

class Settings extends WP_REST_Controller {
    protected $namespace;
    protected $rest_base;

    /**
     * Construct
     */
    public function __construct() {
        $this->namespace = 'wvw/v1';
        $this->rest_base = 'settings';
    }

    /**
     * Register Routes
     *
     * @return void
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'               =>  \WP_REST_Server::READABLE,
                    'callback'              =>  [$this, 'get_items'],
                    'permission_callback'   =>  [$this, 'get_items_permission_check'],
                    'args'                  =>  $this->get_collection_params()
                ],
                [
                    'methods'               =>  \WP_REST_Server::CREATABLE,
                    'callback'              =>  [$this, 'create_items'],
                    'permission_callback'   =>  [$this, 'create_items_permission_check'],
                    'args'                  =>  $this->get_endpoint_args_for_item_schema(true)
                ]
            ]
        );
    }

    /**
     * Get items
     *
     * @param [type] $request
     * @return void
     */
    public function get_items($request) {
        $api_key = get_option('wpvueweather_api_key');
        $location = get_option('wpvueweather_location');

        $items = [
            'api_key'   =>  $api_key,
            'location'  =>  $location
        ];

        $response = rest_ensure_response($items);

        return $response;
    }

    /**
     * Permision check
     *
     * @return void
     */
    public function get_items_permission_check() {
        return true;
    }

    /**
     * Retrives the query params for the items collection
     *
     * @return void
     */
    public function get_collection_params() {
        return [];
    }

    /**
     * Create item
     */
    public function create_items($request) {
        // get data
        $api_key = get_option('wpvueweather_api_key');
        $location = get_option('wpvueweather_location');

        // data validation
        $api_key    = isset($request['api_key']) ? sanitize_text_field($request['api_key']) : $api_key;
        $location   = isset($request['location']) ? sanitize_text_field($request['location']) : $location;

        // update option
        update_option('wpvueweather_api_key', $api_key);
        update_option('wpvueweather_location', $location);

        $response = [
            'api_key'   =>  $api_key,
            'location'  =>  $location
        ];

        return rest_ensure_response($response);
    }

    /**
     * Create item permission check
     *
     * @param [type] $request
     * @return true
     */
    public function create_items_permission_check($request) {
        return true;
    }
}
