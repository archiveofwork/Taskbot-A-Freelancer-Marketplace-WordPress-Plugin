<?php
/**
 * Elementor Page builder config
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://themeforest.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Taskbot
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die('No kiddies please!');
}

if( !class_exists( 'Taskbot_Elementor' ) ) {

	final class Taskbot_Elementor{
		private static $_instance = null;
		
		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      string    taskbot
		 */
        public function __construct() {
            add_action( 'elementor/elements/categories_registered', array( &$this, 'taskbot_init_elementor_widgets' ) );
			add_action( 'elementor/widgets/register', array( $this, 'taskbot_elementor_shortcodes' ) );
        }
		
	
		/**
		 * class init
         * @since 1.1.0
         * @static
         * @var      string    taskbot
         */
        public static function instance () {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
		
		/**
		 * Add category
		 * @since    1.0.0
		 * @access   static
		 * @var      string    taskbot
		 */
        public function taskbot_init_elementor_widgets( $elements_manager ) {
            $elements_manager->add_category(
                'taskbot-elements',
                [
                    'title' => esc_html__( 'Taskbot Elements', 'taskbot' ),
                    'icon'  => 'fa fa-plug',
                ]
            );
        }

        /**
		 * Add widgets
		 * @since    1.0.0
		 * @access   static
		 * @var      string    taskbot
		 */
        public function taskbot_elementor_shortcodes() {
			$dir = TASKBOT_DIRECTORY;
			$scan_shortcodes = glob("$dir/elementor/shortcodes/*");
			foreach ($scan_shortcodes as $filename) {
				$file = pathinfo($filename);
				
				if( !empty( $file['filename'] ) ){
					@include_once taskbot_load_template( '/elementor/shortcodes/'.$file['filename'] );
				} 
			}

			//Theme
			$dir = TASKBOT_ACTIVE_THEME_DIRECTORY;
			$scan_shortcodes = glob("$dir/extend/elementor/shortcodes/*");

			foreach ($scan_shortcodes as $filename) {
				if( !empty( $file['filename'] ) ){
					@include_once $filename;
				} 
			}
        }
		 
	}
}

//Init class
if ( did_action( 'elementor/loaded' ) ) {
    Taskbot_Elementor::instance();
}