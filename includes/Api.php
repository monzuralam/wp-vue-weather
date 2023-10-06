<?php

namespace WPVueWeather;

use WP_REST_Controller;
use WPVueWeather\Api\Settings;

/**
 * API Class
 */
class Api extends WP_REST_Controller {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register Routes
     *
     * @return void
     */
    public function register_routes() {
        (new Settings())->register_routes();
    }
}
