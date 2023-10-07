<?php
/**
 * 
 * Class 'Taskbot_Admin_CPT_Proposals' defines the custom post type Proposalss
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
class Taskbot_Admin_CPT_Proposals {

	/**
	 * Proposals post type
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
	 *Regirster proposal post type
	*/ 
	public function register_posttype() {
		$labels = array(
			'name'                  => esc_html__( 'Proposals', 'taskbot' ),
			'singular_name'         => esc_html__( 'Buyer', 'taskbot' ),
			'menu_name'             => esc_html__( 'Proposals', 'taskbot' ),
			'name_admin_bar'        => esc_html__( 'Proposals', 'taskbot' ),
			'parent_item_colon'     => esc_html__( 'Parent proposal:', 'taskbot' ),
			'all_items'             => esc_html__( 'All proposals', 'taskbot' ),
			'add_new_item'          => esc_html__( 'Add new proposal', 'taskbot' ),
			'add_new'               => esc_html__( 'Add new proposal', 'taskbot' ),
			'new_item'              => esc_html__( 'New proposal', 'taskbot' ),
			'edit_item'             => esc_html__( 'Edit proposal', 'taskbot' ),
			'update_item'           => esc_html__( 'Update proposal', 'taskbot' ),
			'view_item'             => esc_html__( 'View proposal', 'taskbot' ),
			'view_items'            => esc_html__( 'View proposal', 'taskbot' ),
			'search_items'          => esc_html__( 'Search proposals', 'taskbot' ),
		);
		
		$args = array(
			'label'                 => esc_html__( 'Proposal', 'taskbot' ),
			'description'           => esc_html__( 'All proposals', 'taskbot' ),
			'supports'              => array( 'title','editor','author','comments' ),
			'public' 				=> true,
			'show_ui' 				=> true,
			'capability_type' 		=> 'post',
			'map_meta_cap' 			=> true,
			'publicly_queryable' 	=> false,
			'exclude_from_search' 	=> true,
			'hierarchical' 			=> false,
			'menu_position' 		=> 10,
			'rewrite' 				=> array('slug' => 'proposal', 'with_front' => true),
			'query_var' 			=> false,
			'has_archive' 			=> false,
			'show_in_menu' 			=> 'edit.php?post_type=sellers',
			'capabilities' 			=> array(
										'create_posts' => false
									),	
			'rest_base'             => 'proposal',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		);
		
		register_post_type( apply_filters('taskbot_proposal_post_type_name', 'proposals'), $args );

	}  
}

new Taskbot_Admin_CPT_Proposals();