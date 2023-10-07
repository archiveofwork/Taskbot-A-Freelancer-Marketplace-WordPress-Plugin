<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
class Taskbot_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_filter('add_meta_boxes', array($this, 'remove_product_acf_metaboxes'), 9999999);

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/acf/class-acf-tabs-location.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/acf/class-acf-category-location.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/acf/class-acf-custom-fields.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/products-data/class-product-types.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/products-data/class-product-tabs.php';
		
		/**
		 * The class used to define hooks
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-taskbot-hooks.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/metabox/class-metabox-thickbox-popup.php';

		/**
		 * The classes used to register custom pos types
		*/
		foreach ( glob( plugin_dir_path( __FILE__ ) . "cpt/*.php" ) as $file ) {
			include_once $file;
		}
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings.php';
		/**
		* The classes used to register taxonomies
		*/
		foreach ( glob( plugin_dir_path( __FILE__ ) . "taxonomy/*.php" ) as $file ) {
			include_once $file;
		}

		/**
		 * The class responsible for defining activate license functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-user-purchase-verify.php';
		
	}

	/**
	 * ACF metabox remove
	 *
	 * @since    1.0.0
	*/
	public function remove_product_acf_metaboxes(){
		
		if(function_exists('acf_get_field_groups')){
			$acf_field_groups = acf_get_field_groups();
			foreach($acf_field_groups as $group){
				remove_meta_box('acf-'.$group['key'], 'product', 'normal');
			}
		}
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$protocol = is_ssl() ? 'https' : 'http';

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Taskbot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Taskbot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 //Default theme font famlies
		$font_families	= array();
		$font_families[] = 'Urbanist:400,500,600,700,900';
		$font_families[] = 'Playfair+Display:700';
		$font_families[] = 'Open+Sans:400,600,700';

		$query_args = array (
			'family' => implode('%7C' , $font_families) ,
			'subset' => 'latin,latin-ext' ,
		);

		$theme_fonts = add_query_arg($query_args , $protocol.'://fonts.googleapis.com/css');

		wp_enqueue_style( 'select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
    	wp_enqueue_style( 'jquery-confirm', plugin_dir_url( __FILE__ ) . 'css/jquery-confirm.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/taskbot-core-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Taskbot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Taskbot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery-confirm', plugin_dir_url( __FILE__ ) . 'js/jquery-confirm.min.js', array(), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/taskbot-core-admin.js', array( 'jquery' ), $this->version, false );
		
		$data = array(
			'ajax_nonce'					=> wp_create_nonce('ajax_nonce'),
			'import' 						=> esc_html__('Import users', 'taskbot'),
			'import_message' 				=> esc_html__('Are you sure, you want to import users?', 'taskbot'),
			'ajaxurl'						=> admin_url( 'admin-ajax.php' ),
			'deactivate_account'			=> esc_html__('Uh-Oh!', 'taskbot'),
			'deactivate_account_message'	=> esc_html__('Are you sure, you want to deactivate this account?', 'taskbot'),
			'reject_account'				=> esc_html__('Reject user account', 'taskbot'),
			'reject_account_message'		=> esc_html__('Are you sure, you want to reject this account? After reject, this account will no longer visible in the search listing', 'taskbot'),
			'account_verification'			=> esc_html__('Account verification', 'taskbot'),
			'reason' 						=> esc_html__('Please add reason why you want to reject user uploaded documents?', 'taskbot'),
			'approve_identity'				=> esc_html__('Identity Verify', 'taskbot'),
			'approve_identity_message'		=> esc_html__('Are you sure, you want to verify identity of this user?', 'taskbot'),
			'reject_identity'				=> esc_html__('Identity Reject', 'taskbot'),
			'reject_identity_message'		=> esc_html__('Are you sure, you want to reject identity of this user?', 'taskbot'),
			'reject_reason_text'			=> esc_html__('Please add reason why you want to reject?', 'taskbot'),
			'approve_account'				=> esc_html__('Approve user account', 'taskbot'),
			'approve_account_message'		=> esc_html__('Are you sure, you want to approve this account? An email will be sent to this user.', 'taskbot'),
			'yes'			=> esc_html__('Yes', 'taskbot'),
			'close'			=> esc_html__('Close', 'taskbot'),
			'no' 			=> esc_html__('No', 'taskbot'),
			'accept' 		=> esc_html__('Accept', 'taskbot'),
			'reject' 		=> esc_html__('Reject', 'taskbot'),
			'select_option'	=> esc_html__('Select an option', 'taskbot'),
			'reason'		=> esc_html__('Please add reason why you want to reject user uploaded documents?', 'taskbot'),
		);

		wp_localize_script($this->plugin_name, 'admin_scripts_vars', $data );

	}

}


