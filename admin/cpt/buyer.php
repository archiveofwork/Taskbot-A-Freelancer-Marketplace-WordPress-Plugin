<?php
/**
 * 
 * Class 'Taskbot_Admin_CPT_Buyer' defines the custom post type Buyers
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
class Taskbot_Admin_CPT_Buyer {

	/**
	 * Buyers post type
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		add_action('init', array(&$this, 'init_post_type'));		
	}

	/**
	 * @Init post type
	*/
	public function init_post_type() {
		$this->register_posttype();
	}

	/**
	 *Regirster buyer post type
	*/ 
	public function register_posttype() {
		$labels = array(
			'name'                  => esc_html__( 'Buyers', 'taskbot' ),
			'singular_name'         => esc_html__( 'Buyer', 'taskbot' ),
			'menu_name'             => esc_html__( 'Buyers', 'taskbot' ),
			'name_admin_bar'        => esc_html__( 'Buyers', 'taskbot' ),
			'parent_item_colon'     => esc_html__( 'Parent buyer:', 'taskbot' ),
			'all_items'             => esc_html__( 'All buyers', 'taskbot' ),
			'add_new_item'          => esc_html__( 'Add new buyer', 'taskbot' ),
			'add_new'               => esc_html__( 'Add new buyer', 'taskbot' ),
			'new_item'              => esc_html__( 'New buyer', 'taskbot' ),
			'edit_item'             => esc_html__( 'Edit buyer', 'taskbot' ),
			'update_item'           => esc_html__( 'Update buyer', 'taskbot' ),
			'view_item'             => esc_html__( 'View buyers', 'taskbot' ),
			'view_items'            => esc_html__( 'View buyers', 'taskbot' ),
			'search_items'          => esc_html__( 'Search buyers', 'taskbot' ),
		);
		
		$args = array(
			'label'                 => esc_html__( 'Buyer', 'taskbot' ),
			'description'           => esc_html__( 'All buyer.', 'taskbot' ),
			'labels'                => apply_filters('taskbot_product_taxonomy_duration_labels', $labels),
			'taxonomies'            => array( 'product_cat'),
			'public' 				=> true,
			'supports' 				=> array('title','editor','author','excerpt','thumbnail'),
			'show_ui' 				=> true,
			'capability_type' 		=> 'post',
			'map_meta_cap' 			=> true,
			'publicly_queryable' 	=> false,
			'exclude_from_search' 	=> true,
			'hierarchical' 			=> false,
			'menu_position' 		=> 10,
			'rewrite' 				=> array('slug' => 'buyer', 'with_front' => true),
			'query_var' 			=> false,
			'has_archive' 			=> false,
			'show_in_menu' 			=> 'edit.php?post_type=sellers',
			'capabilities' 			=> array(
										'create_posts' => false
									),	
			'rest_base'             => 'buyer',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		);
		
		register_post_type( apply_filters('taskbot_buyer_post_type_name', 'buyers'), $args );

	}  
}

new Taskbot_Admin_CPT_Buyer();