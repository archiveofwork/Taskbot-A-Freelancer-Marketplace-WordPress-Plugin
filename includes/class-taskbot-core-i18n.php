<?php

/**
 *
 * Class 'Taskbot_Deactivator' define the internationalization functionality
 * 
 * Loads and defines the internationalization files for this plugin so that it is ready for translation.
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

class Taskbot_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'taskbot',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
