<?php

namespace WPVueWeather;

/**
 * Backend Class
 */
class Backend {
    public function __construct() {
        $this->register_menu();
    }

    /**
     * Register Menu
     *
     * @return void
     */
    public function register_menu() {
        new \WPVueWeather\Backend\Menu();
    }
}
