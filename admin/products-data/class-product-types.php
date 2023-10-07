<?php
namespace ProductTypes;
/**
 * 
 * Class 'Taskbot_Admin_CPT_Product_Types' defines the product post type custom types
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/products_data
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
class Taskbot_Admin_Products_Data_Product_Types {

	/**
	 * Add woocommerce filter 'product_type_selector' to define custom product types.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		add_filter( 'product_type_selector', array($this, 'taskbot_add_custom_product_type'),999 );
	}

	/**
	* Add to product type drop down.
	*/
	function taskbot_add_custom_product_type( $product_types ){
		$product_types[ 'tasks' ]		= apply_filters('taskbot_product_type_task_title', esc_html__('Task listing', 'taskbot'));
		$product_types[ 'subtasks' ]	= apply_filters('taskbot_product_type_subtask_title', esc_html__('Sub task listing', 'taskbot'));
		$product_types[ 'packages' ]	= apply_filters('taskbot_product_type_package_title', esc_html__('Seller packages', 'taskbot'));
		$product_types[ 'buyer_packages' ]	= apply_filters('taskbot_product_type_package_title', esc_html__('Buyer packages', 'taskbot'));
		$product_types[ 'funds' ]		= apply_filters('taskbot_product_type_funds_title', esc_html__('Funds', 'taskbot'));
		$product_types[ 'projects' ]	= apply_filters('taskbot_product_type_projects_title', esc_html__('Projects', 'taskbot'));
		return $product_types;
	}
}

new Taskbot_Admin_Products_Data_Product_Types();
