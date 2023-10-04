<?php

namespace WPVueWeather;

/**
 * Assets Class
 */
class Assets {
    public function __construct() {
        if( is_admin() ){
            add_action( 'admin_enqueue_scripts', [ $this, 'register'], 5 );
        }else{
            add_action( 'wp_enqueue_scripts', [ $this, 'register'], 5 );
        }
    }

    /**
     * register scripts & styles
     *
     * @return void
     */
    public function register(){
        $this->register_scripts( $this->get_scripts() );
        $this->register_styles( $this->get_styles() );
    }

    /**
     * Register Styles
     *
     * @param [type] $styles
     * @return void
     */
    public function register_styles( $styles ){
        foreach( $styles as $handle => $style ){
            wp_register_style( $handle, $style['src'], false, $style['version'], 'all' );
        }
    }

    /**
     * Register Scripts
     *
     * @return void
     */
    public function register_scripts( $scripts ){
        foreach( $scripts as $handle => $script ){
            $deps      = isset( $script[ 'deps' ] ) ? $script[ 'deps' ] : false;
            $in_footer = isset( $script[ 'in_footer' ] ) ? $script[ 'in_footer' ] : false;
            $version   = isset( $script[ 'version' ] ) ? $script[ 'version' ] : WPVUEWEATHER_VERSION;

            wp_register_script( $handle, $script[ 'src' ], $deps, $version, $in_footer );
        }
    }

    /**
     * Get all register styles
     *
     * since 1.0
     */
    public function get_styles(){
        $styles = [
            'wpvue-style' => [
                'src'       =>  WPVUEWEATHER_URL . '/assets/css/style.css',
                'version'   =>  \filemtime( WPVUEWEATHER_PATH . '/assets/css/style.css' )
            ],
        ];

        return $styles;
    }

    /**
     * Get all register scripts
     *
     * since 1.0
     */
    public function get_scripts(){
        $scripts = [
            'wpvue-main' => [
                'src'       => WPVUEWEATHER_URL . '/assets/js/bundle.js',
                'deps'      => [],
                'version'   => \filemtime( WPVUEWEATHER_PATH . '/assets/js/bundle.js' ),
                'in_footer' => true
            ],
        ];

        return $scripts;
    }
}
