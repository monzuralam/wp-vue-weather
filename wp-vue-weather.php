<?php
/*
Plugin Name: WP Vue Weather
Plugin URI: https://wordpress.org.com/plugins/#
Description: API Based WordPress Weather Plugin with Vue.js
Version: 0.1.0
Author: Monzur Alam
Author URI: https://profile.wordpress.org/monzuralam/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-vue-weather
Domain Path: /languages
*/

// don't call the file directly
if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main Class
 */
final class WP_Vue_Weather {
    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.1.0';

    /**
     * Contructor for the WP_Vue_Weather class
     * 
     * Sets up the appropriate hooks and actions within our plugin.
     */
    public function __construct() {
        $this->define_constants();

        register_activation_hook(__FILE__, array($this, 'wpvueweather_active'));
        register_deactivation_hook(__FILE__, array($this, 'wpvueweather_deactive'));

        add_action('plugins_loaded', array($this, 'wpvueweather_init_plugin'));
    }

    /**
     * Initializes the WP_Vue_Weather() class
     *
     * Checks for an existing WP_Vue_Weather() instance and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if (!$instance) {
            $instance = new WP_Vue_Weather();
        }

        return $instance;
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define('WPVUEWEATHER_VERSION', $this->version);
        define('WPVUEWEATHER_FILE', __FILE__);
        define('WPVUEWEATHER_PATH', dirname(WPVUEWEATHER_FILE));
        define('WPVUEWEATHER_INCLUDES', WPVUEWEATHER_PATH . '/includes');
        define('WPVUEWEATHER_URL', plugins_url('', WPVUEWEATHER_FILE));
        define('WPVUEWEATHER_ASSETS', WPVUEWEATHER_URL . '/assets');
    }

    /**
     * Placeholder for activation functions
     */
    public function wpvueweather_active() {

        $installed = get_option('wpvueweather_installed');

        if (!$installed) {
            update_option('wpvueweather_installed', time());
        }

        update_option('wpvueweather_version', WPVUEWEATHER_VERSION);
    }

    /**
     * Placeholder for deactivation function
     */
    public function wpvueweather_deactive() {
    }

    /**
     * Load the plugin after all plugins are loaded
     *
     * @return void
     */
    public function wpvueweather_init_plugin() {
        if (is_admin()) {
            new \WPVueWeather\Backend();
        }
        new \WPVueWeather\Assets();
    }
} // WP_Vue_Weather

WP_Vue_Weather::init();
