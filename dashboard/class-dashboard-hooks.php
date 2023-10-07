<?php
use Taskbot_Render_Fields\Taskbot_Render_Fields as Taskbot_Render_Fields;
/**
 *
 * Class 'Taskbot_Dashboard_Hooks' defines to remove the product data default tabs
 *
 * @package     Taskbot
 * @subpackage  Taskbot/Dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

class Taskbot_Dashboard_Hooks {

	/**
	 * Add action hooks
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		add_action( 'taskbot_taxonomy_dropdown', array($this, 'taskbot_taxonomy_dropdown_html'));
		add_filter( 'taskbot_taxonomy_dropdown', array($this, 'taskbot_taxonomy_dropdown_html'));
		add_action( 'taskbot_task_search_taxonomy_dropdown', array($this, 'taskbot_task_search_taxonomy_dropdown_html'));
		add_action( 'taskbot_service_additional_fields', array($this, 'taskbot_service_additional_fields_html'));
	}

    /**
	 * Task additional field
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function taskbot_service_additional_fields_html($taskbot_args = array()){
	    //add task introduction
        taskbot_get_template(
            'dashboard/post-service/add-service-acf-additional-fields.php',
            $taskbot_args
        );
    }

    /**
	 * Taxonomy dropdown
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function taskbot_taxonomy_dropdown_html($taskbot_args = array()){
		$defaults = array(
			'show_option_all'   => '',
			'show_option_none'  => '',
			'orderby'           => 'id',
			'order'             => 'ASC',
			'show_count'        => 0,
			'hide_empty'        => 1,
			'child_of'          => 0,
			'exclude'           => '',
			'echo'              => 1,
			'selected'          => 0,
			'hierarchical'      => 0,
			'name'              => 'cat',
			'id'                => '',
			'class'             => 'postform',
			'depth'             => 0,
			'tab_index'         => 0,
			'taxonomy'          => 'product_cat',
			'hide_if_empty'     => false,
			'option_none_value' => -1,
			'value_field'       => 'term_id',
			'required'          => false,
		);

		$taskbot_args = wp_parse_args( $taskbot_args, $defaults );
		wp_dropdown_categories( $taskbot_args );
	}

    /**
	 * Taxonomy dropdown
	 *
	 * @since    1.0.0
	 * @access   public
	*/
  	public function taskbot_task_search_taxonomy_dropdown_html($taskbot_args = array()){
		$defaults = array(
			'show_option_all'   => '',
			'show_option_none'  => '',
			'orderby'           => 'id',
			'order'             => 'ASC',
			'show_count'        => 0,
			'hide_empty'        => 1,
			'child_of'          => 0,
			'exclude'           => '',
			'echo'              => 1,
			'selected'          => 0,
			'hierarchical'      => 0,
			'name'              => 'cat',
			'id'                => '',
			'class'             => 'postform',
			'depth'             => 0,
			'tab_index'         => 0,
			'taxonomy'          => 'product_cat',
			'hide_if_empty'     => false,
			'option_none_value' => -1,
			'value_field'       => 'slug',
			'required'          => false,
		);
		if (class_exists('WooCommerce')) {
			$taskbot_args = wp_parse_args( $taskbot_args, $defaults );
			wp_dropdown_categories( $taskbot_args );
		}
	}

	/**
	 * Render user registration ACF dynamic fields hook
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function taskbot_render_acf_user_registration_fields_html($groups=array()){
		$render_fields = new Taskbot_Render_Fields();
		foreach($groups as $group){
			$group_ID		= $group['ID'];
			$group_name 	= $group['name'];
			$group_key 		= $group['key'];
			$product_plans_category	= '';
			$html_render_fields 	= '';

			if(!empty($group['sub_fields']) && is_array($group['sub_fields']) && count($group['sub_fields'])>0){
				foreach($group['sub_fields'] as $pkg_field){
					$html_render_fields .= '<li id="'.esc_attr($group_key).'" class="'.esc_attr($product_plans_category).' '.esc_attr($group_name).'">';
					$field = $pkg_field;
					$type = $pkg_field['type'];
					$field['label'] = '';

					if(!empty($field['wrapper']['class'])){
						$field['wrapper']['class'] .= ' '.$product_plans_category;
					} else {
						$field['wrapper'] = array('class'=>$product_plans_category);
					}

					$field['id'] = $id = $pkg_field['key'];
					$field['choices'] = !empty($pkg_field['choices']) ? $pkg_field['choices'] : array();
					$field['value'] = $pkg_field['default_value'];
					 $html_render_fields .= ' <div class="tb-pricingtitle"><h6>'.esc_html($pkg_field['label']).':</h6></div>';

					foreach($pkg_field as $key=>$pkgs){
						$field['base'] = 'plans';
						$field['plan'] = $key;

						if(isset($taskbot_plans_values[$key][$id])){
							$field['value'] = $taskbot_plans_values[$key][$id];
						}

						switch ($type) {
							case "text":
								$html_render_fields .= $render_fields->text_field($field);
								break;
							case "number":
								$html_render_fields .= $render_fields->number_field($field);
								break;
							case "textarea":
								$html_render_fields .= $render_fields->textarea_field($field);
								break;
							case "checkbox":
								$html_render_fields .= $render_fields->checkbox_field($field);
								break;
							case "radio":
								$html_render_fields .= $render_fields->radio_field($field);
								break;
							default:
								$html_render_fields .= $this->acf_render_field($field);
						}

						$html_render_fields .= do_action('plan_packages_acf_extra_fields', $field, $groups);
					}

					$html_render_fields .= '</li>';
				}

			}
		}

		echo do_shortcode($html_render_fields);
	}

    /**
	 * ACF render field
	 * Overrides the html tag
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function acf_render_field($field){
		$field = apply_filters( "acf/prepare_field", $field );
		add_filter( "acf/prepare_field", array($this, 'prepare_field') );
		acf_render_field_wrap( $field, $el='div', $instruction='label' );
		remove_filter( "acf/prepare_field", array($this, 'prepare_field') );
	}

    /**
	 * ACF prepare field for dynamic name
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function prepare_field($field){
		$field_name = '';

		if(!empty($field['base'])){

			if(!empty($field['base'])){
				$field_name .= $field['base'];
			}

			if(!empty($field['plan'])){
				$field_name .= '['.$field['plan'].']';
			}

			if(!empty($field['key']) && !empty($field_name)){
				$field_name .= '['.$field['key'].']';
			} else {
				$field_name = $field['id'];
			}

			$field['name'] = $field_name;
		}
		
		return $field;
	}

}

new Taskbot_Dashboard_Hooks();
