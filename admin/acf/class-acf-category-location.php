<?php
/**
 * 
 * Class 'Taskbot_ACF_Product_Plans_Category_Location' defines to remove the product data default tabs
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/acf
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

 if(class_exists('ACF_Location')){

		
	class Taskbot_ACF_Product_Plans_Category_Location extends ACF_Location {

		function initialize() {
			$this->name = 'product_plans_category';
			$this->label = esc_html__( 'Product plan category','taskbot' );
		}
		
		/**
		 * Matches the provided rule against the screen args returning a bool result.
		 *
		 * @param	array $rule The location rule.
		 * @param	array $screen The screen args.
		 * @param	array $field_group The field group settings.
		 * @return	bool
		 */
		public function match( $rule, $screen, $field_group ) {

			if(!empty($screen['product_tabs']) && ($screen['product_tabs'] == 'additional' || $screen['product_tabs'] == 'plan' ||  $screen['product_tabs'] == 'subtasks' )){
				$choices = array('plan'=>'plan', 'subtasks'=>'subtasks');
				$is_choice = in_array( $rule['value'], $choices );
				
				if ( '==' == $rule['operator'] ) { 
					$match = $is_choice;
				} elseif ( '!=' == $rule['operator'] ) {
					$match = ! $is_choice;
				}
				
				return $match;
			} else {
				return false;
			}

			if(!empty($screen['post_type']) && $screen['post_type'] == 'product'){
				return false;
			}
			
			if(!empty($screen['post_type']) && $screen['post_type'] !== 'product'){
				return false;
			}

			$choices = array('plan'	=> 'plan', 'general'	=> 'general', 'subtasks'=> 'subtasks');
			$is_choice = in_array( $rule['value'], $choices );
			
			if ( !empty($rule['operator']) && '==' == $rule['operator'] ) { 
				$match = $is_choice;
			} elseif ( !empty($rule['operator']) &&  '!=' == $rule['operator'] ) {
				$match = ! $is_choice;
			}
			
			return $match;

		}
	}

	acf_register_location_type( 'Taskbot_ACF_Product_Plans_Category_Location' );

	/**
	 * ACF Rule Values: product_plans_category
	 *
	 * @param array $choices, available rule values for this type
	 * @return array
	 */
	function taskbot_acf_rule_values_product_plan_categories( $choices ) {
		$choices = taskbot_get_product_taxonomy_child_terms_list();
		return $choices;
	}
	add_filter( 'acf/location/rule_values/product_plans_category', 'taskbot_acf_rule_values_product_plan_categories' );

	 
	/**
	 * Product taxonomy list
	 *
	 * @param array $choices, available rule values for this type
	 * @return array
	 */ 
	function taskbot_get_product_taxonomy_list(){

		$args = array(
			'orderby'  		=> 'title',
			'order'    		=> 'ASC',
			'hide_empty'	=> false,
			'taxonomy' 		=> 'product_cat',
			'parent'   		=> 0,
		);

		$args	= apply_filters('taskbot_product_terms_list_args', $args);
		$terms = get_terms( $args );
		$categories = array();
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$categories[$term->term_id]	= $term->name;
			}
		}
		
		return $categories;
	}
	
	/**
	 * Get product 3rd level categories
	 *
	 * @param array $choices, available rule values for this type
	 * @return array
	 */
	function taskbot_get_product_taxonomy_child_terms_list() {
		$taxonomy = "product_cat";
		$defaults = array(
			'taxonomy' 		=> $taxonomy,
			'orderby' 		=> 'name',
			'order' 		=> 'ASC',
			'hide_empty' 	=> 0,
			'exclude' 		=> array(),
			'exclude_tree'  => array(),
			'number' 		=> '',
			'offset' 		=> '',
			'fields' 		=> 'all',
			'name' 			=> '',
			'slug' 			=> '',
			'hierarchical'  => true,
			'search' 		=> '',
			'name__like' 	=> '',
			'description__like' 	=> '',
			'pad_counts' 			=> false,
			'get' 			=> '',
			'childless' 	=> false
		);
		 
		$categories = array();
		$terms = get_terms( $defaults );
		foreach($terms as $term) {
			$ancestors = get_ancestors($term->term_id, $taxonomy);
			if( count($ancestors) > 1) {
				$categories[$term->term_id]	= $term->name;
			}
		}
		return $categories;
	}

}