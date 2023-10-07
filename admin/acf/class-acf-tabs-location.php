<?php
/**
 * 
 * Class 'Taskbot_ACF_Product_Plans_Tabs_Location' defines to remove the product data default tabs
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/acf
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

if(class_exists('ACF_Location')){

	class Taskbot_ACF_Product_Plans_Tabs_Location extends ACF_Location {


		function initialize() {
			$this->name 	= 'product_tabs';
			$this->label 	= esc_html__( 'Product Tabs','taskbot' );
		}
		
		/**
		 * ACF rule matches the provided rule against the screen args.
		 * @param	array $rule The location rule.
		 * @param	array $screen The screen args.
		 * @param	array $field_group The field group settings.
		 * @return	bool
		 */
		public function match( $rule, $screen, $field_group ) {
			$choices = array('plan'=>'plan', 'subtasks'=>'subtasks');
			
			if(isset($screen['product_tabs']) && ($screen['product_tabs'] == 'plan' ||  $screen['product_tabs'] == 'subtasks' )){
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

			if(isset($screen['post_type']) && $screen['post_type'] == 'product'){
				return false;
			}

			if(isset($screen['post_type']) && $screen['post_type'] !== 'product'){
				return false;
			}

			$is_choice = in_array( $rule['value'], $choices );

			if ( '==' == $rule['operator'] ) { 
				$match = $is_choice;
			} elseif ( '!=' == $rule['operator'] ) {
				$match = ! $is_choice;
			}
			
			return $match;

		}
	}

	acf_register_location_type( 'Taskbot_ACF_Product_Plans_Tabs_Location' );

	/**
	 * ACF Rule Values: product_tabs
	 *
	 * @param array $choices, available rule values for this type
	 * @return array
	 */
	function taskbot_acf_rule_values_product_plan_tabs( $choices ) {
		$choices = array('plan'=> esc_html__('Plan', 'taskbot'), 'subtasks'=> esc_html__('Subtasks', 'taskbot'));
		return $choices;
	}
	add_filter( 'acf/location/rule_values/product_tabs', 'taskbot_acf_rule_values_product_plan_tabs' );

}

