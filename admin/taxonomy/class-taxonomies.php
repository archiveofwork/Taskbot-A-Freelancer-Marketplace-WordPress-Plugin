<?php
/**
 * 
 * Class 'Taskbot_Admin_Taxonomies' defines the product post type custom taxonomy languages
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Taxonomy
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
class Taskbot_Admin_Taxonomies {

	/**
	 * Language Taxonomy
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		add_action('init', array(&$this, 'init_taxonomy'));
		
	}
	/**
	 * @Init taxonomy
	*/
	public function init_taxonomy() {
		$this->register_custom_taxonomy();
	}

	/**
	 * Regirster location Taxonomy
	*/
	public function register_custom_taxonomy() {
		$languages_labels = array(
			'name' 				=> esc_html__('Languages', 'taskbot'),
			'singular_name' 	=> esc_html__('Language','taskbot'),
			'search_items' 		=> esc_html__('Search language', 'taskbot'),
			'all_items' 		=> esc_html__('All languages', 'taskbot'),
			'parent_item' 		=> esc_html__('Parent language', 'taskbot'),
			'parent_item_colon' => esc_html__('Parent language:', 'taskbot'),
			'edit_item' 		=> esc_html__('Edit language', 'taskbot'),
			'update_item' 		=> esc_html__('Update language', 'taskbot'),
			'add_new_item' 		=> esc_html__('Add new language', 'taskbot'),
			'new_item_name' 	=> esc_html__('New language name', 'taskbot'),
			'menu_name' 		=> esc_html__('Languages', 'taskbot'),
		);

		$language_args = array(
			'hierarchical'          => true,
			'labels'                => apply_filters('taskbot_product_taxonomy_languages_labels', $languages_labels),
			'show_ui'               => true,
			'show_in_nav_menus' 	=> false,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'languages'),			
			'show_in_rest'              => true,
			'rest_base'                 => 'languages',
			'rest_controller_class'     => 'WP_REST_Terms_Controller',
			
		);
		register_taxonomy(apply_filters('taskbot_product_taxonomy_languages_name', 'languages'), array('product','sellers', apply_filters('taskbot_profiles_post_type_name', 'profiles')), apply_filters('taskbot_product_taxonomy_languages', $language_args));
		
		$duration_labels = array(
			'name' 				=> esc_html__('Duration', 'taskbot'),
			'singular_name' 	=> esc_html__('Duration','taskbot'),
			'search_items' 		=> esc_html__('Search duration', 'taskbot'),
			'all_items' 		=> esc_html__('All Duration', 'taskbot'),
			'parent_item' 		=> esc_html__('Parent duration', 'taskbot'),
			'parent_item_colon' => esc_html__('Parent duration:', 'taskbot'),
			'edit_item' 		=> esc_html__('Edit duration', 'taskbot'),
			'update_item' 		=> esc_html__('Update duration', 'taskbot'),
			'add_new_item' 		=> esc_html__('Add new duration', 'taskbot'),
			'new_item_name' 	=> esc_html__('New duration name', 'taskbot'),
			'menu_name' 		=> esc_html__('Duration', 'taskbot'),
		);

		$duration_args = array(
			'hierarchical'          => true,
			'labels'                => apply_filters('taskbot_product_taxonomy_durations_labels', $duration_labels),
			'show_ui'               => true,
			'show_in_nav_menus' 	=> false,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'duration'),			
			'show_in_rest'              => true,
			'rest_base'                 => 'duration',
			'rest_controller_class'     => 'WP_REST_Terms_Controller',
			
		);

		register_taxonomy(apply_filters('taskbot_product_taxonomy_durations_name', 'duration'), array('product', apply_filters('taskbot_profiles_post_type_name', 'profiles')), apply_filters('taskbot_product_taxonomy_duration', $duration_args));
		
		$expertise_labels = array(
			'name' 				=> esc_html__('Expertise level', 'taskbot'),
			'singular_name' 	=> esc_html__('Experty level','taskbot'),
			'search_items' 		=> esc_html__('Search Experty level', 'taskbot'),
			'all_items' 		=> esc_html__('All Experty level', 'taskbot'),
			'parent_item' 		=> esc_html__('Parent Experty level', 'taskbot'),
			'parent_item_colon' => esc_html__('Parent Experty level:', 'taskbot'),
			'edit_item' 		=> esc_html__('Edit Experty level', 'taskbot'),
			'update_item' 		=> esc_html__('Update Experty level', 'taskbot'),
			'add_new_item' 		=> esc_html__('Add new Experty level', 'taskbot'),
			'new_item_name' 	=> esc_html__('New Experty level name', 'taskbot'),
			'menu_name' 		=> esc_html__('Expertise level', 'taskbot'),
		);

		$expertise_args = array(
			'hierarchical'          => true,
			'labels'                => apply_filters('taskbot_product_taxonomy_skills_labels', $expertise_labels),
			'show_ui'               => true,
			'show_in_nav_menus' 	=> false,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'expertise_level'),			
			'show_in_rest'              => true,
			'rest_base'                 => 'expertise_level',
			'rest_controller_class'     => 'WP_REST_Terms_Controller',
			
		);

		register_taxonomy(apply_filters('taskbot_product_taxonomy_expertises_name', 'expertise_level'), array('product', apply_filters('taskbot_profiles_post_type_name', 'profiles')), apply_filters('taskbot_product_taxonomy_expertise', $expertise_args));
		$skills_labels = array(
			'name' 				=> esc_html__('Skills', 'taskbot'),
			'singular_name' 	=> esc_html__('Skill','taskbot'),
			'search_items' 		=> esc_html__('Search skill', 'taskbot'),
			'all_items' 		=> esc_html__('All skill', 'taskbot'),
			'parent_item' 		=> esc_html__('Parent skill', 'taskbot'),
			'parent_item_colon' => esc_html__('Parent skill:', 'taskbot'),
			'edit_item' 		=> esc_html__('Edit skill', 'taskbot'),
			'update_item' 		=> esc_html__('Update skill', 'taskbot'),
			'add_new_item' 		=> esc_html__('Add new skill', 'taskbot'),
			'new_item_name' 	=> esc_html__('New skill name', 'taskbot'),
			'menu_name' 		=> esc_html__('Skills', 'taskbot'),
		);

		$skills_arg = array(
			'hierarchical'          => true,
			'labels'                => apply_filters('taskbot_product_taxonomy_skills_labels', $skills_labels),
			'show_ui'               => true,
			'show_in_nav_menus' 	=> false,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'skills'),			
			'show_in_rest'              => true,
			'rest_base'                 => 'skills',
			'rest_controller_class'     => 'WP_REST_Terms_Controller',
			
		);

		register_taxonomy(apply_filters('taskbot_product_taxonomy_skills_name', 'skills'), array('product','sellers', apply_filters('taskbot_profiles_post_type_name', 'profiles')), apply_filters('taskbot_product_taxonomy_skills', $skills_arg));
		

		$delivery_time = array(
			'name' 				=> esc_html__('Delivery time', 'taskbot'),
			'singular_name' 	=> esc_html__('Delivery time','taskbot'),
			'search_items' 		=> esc_html__('Search delivery time', 'taskbot'),
			'all_items' 		=> esc_html__('All delivery time', 'taskbot'),
			'parent_item' 		=> esc_html__('Parent delivery time', 'taskbot'),
			'parent_item_colon' => esc_html__('Parent delivery time:', 'taskbot'),
			'edit_item' 		=> esc_html__('Edit delivery time', 'taskbot'),
			'update_item' 		=> esc_html__('Update delivery time', 'taskbot'),
			'add_new_item' 		=> esc_html__('Add New delivery time', 'taskbot'),
			'new_item_name' 	=> esc_html__('New delivery time name', 'taskbot'),
			'menu_name' 		=> esc_html__('Delivery time', 'taskbot'),
		);

		$delivery_time_args = array(
			'hierarchical'          => true,
			'labels'                => apply_filters('taskbot_product_taxonomy_delivery_time_labels', $delivery_time),
			'show_ui'               => true,
			'show_in_nav_menus' 	=> false,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'delivery_time'),			
			'show_in_rest'              => true,
			'rest_base'                 => 'delivery_time',
			'rest_controller_class'     => 'WP_REST_Terms_Controller',
			
		);	
		
		register_taxonomy(apply_filters('taskbot_product_taxonomy_delivery_time_name', 'delivery_time'), array('product', apply_filters('taskbot_profiles_post_type_name', 'profiles')), apply_filters('taskbot_product_taxonomy_delivery_time', $delivery_time_args));

	}

}

new Taskbot_Admin_Taxonomies();
