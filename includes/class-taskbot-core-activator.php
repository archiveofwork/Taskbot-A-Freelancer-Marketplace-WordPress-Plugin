<?php

/**
 *
 * Class 'Taskbot_Activator' fired during plugin activation.
 * 
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

class Taskbot_Activator {

	/**
	 *Plugin activation function
	 *
	 * @since    1.0.0
	 */
	public static function activate() {		

		// Check if WooCommerce is active
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) ); 
		}


	}

	public function plugin_activation_notice(){
		?>
		<div class="error">
			<p><?php esc_html_e('Sorry, but Woocommerce plugin requires the parent plugin to be installed and active.', 'taskbot');?></p>
		</div>
		<?php
	}

}
