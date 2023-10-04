<?php

namespace WPVueWeather\Backend;

/**
 * Menu Class
 */
class Menu {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    /**
     * Admin Menu
     *
     * @return void
     */
    public function admin_menu() {
        global $submenu;

        $slug = 'wp-vue-weather';
        $capablity = 'manage_options';

        $hook = add_menu_page(__('WP Vue Weather', 'wp-vue-weather'), __('WP Vue Weather', 'wp-vue-weather'), $capablity, $slug, array($this, 'plugin_page'), 'dashicons-cloud', null);

        if (current_user_can($capablity)) {
            $submenu[$slug][] = [__('Weather', 'wp-vue-weather'), $capablity, 'admin.php?page=' . $slug . '#/'];
            $submenu[$slug][] = [__('Settings', 'wp-vue-weather'), $capablity, 'admin.php?page=' . $slug . '#/settings'];
        }

        add_action('load-' . $hook, [$this, 'init_hooks']);
    }

    /**
     * Initialize our hooks for the admin page
     *
     * @return void
     */
    public function init_hooks() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load scripts & style for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style('wpvue-style');
        wp_enqueue_script('wpvue-main');
        wp_localize_script('wpvue-main', 'wpvueAdminLocalizer', [
            'adminUrl'      =>      admin_url('/'),
            'ajaxUrl'       =>      admin_url('/admin-ajax.php'),
            'apiUrl'        =>      home_url('/wp-json')
        ]);
    }

    /**
     * Render our admin page
     *
     * @return void
     */
    public function plugin_page() {
        echo '<div class="wrap"><div id="vue-backend-app"></div></div>';
    }
}
