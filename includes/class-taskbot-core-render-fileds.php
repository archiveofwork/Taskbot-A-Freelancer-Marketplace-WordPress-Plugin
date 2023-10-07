<?php
/**
 *
 * This is used to task render fields
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

class Taskbot_Render_Fields {

	/**
	 * Render text field
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function text_field($field){
		global $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name		= '';

		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}
		$value = '';

		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$placeholder = '';
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}
			
		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}

			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$class = '';
		if(!empty($field['class'])){
			$class = ' '.$field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field tb-pricing-input '.esc_attr($class).'">';

			if(!empty($field['label'])){
				$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
			}

			$taskbot_html .= '<input type="text" name="'.esc_attr($field_name).'" value="'.esc_attr($value).'" class="form-control '.esc_attr($class).'" placeholder="'.esc_attr($placeholder).'"  autocomplete="off"'.do_shortcode($disabled_field.$required_field.$field_title).'>';
		$taskbot_html .= '</div>';
		return $taskbot_html;

	}

	/**
	 * Render email field
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function email_field($field){
		global $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name		= '';

		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}
		$value = '';

		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$placeholder = '';
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}
			
		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}

			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$class = '';
		if(!empty($field['class'])){
			$class = ' '.$field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field tb-pricing-input '.esc_attr($class).'">';

			if(!empty($field['label'])){
				$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
			}

			$taskbot_html .= '<input type="email" name="'.esc_attr($field_name).'" value="'.esc_attr($value).'" class="form-control'.$class.'" placeholder="'.esc_attr($placeholder).'"  autocomplete="off"'.$disabled_field.$required_field.$field_title.'>';
		$taskbot_html .= '</div>';
		return $taskbot_html;

	}

	/**
	 * Render number field
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function number_field($field){
		global $current_user;

		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name = '';

		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}

		$value = '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$minvalue = '';
		if(!empty($field['min'])){
			$minvalue = ' min="'.$field['min'].'"';
		}

		$maxvalue = '';
		if(!empty($field['max'])){
			$maxvalue = ' max="'.$field['max'].'"';
		}

		$step = '';
		if(!empty($field['step'])){
			$step = ' step="'.$field['step'].'"';
		}

		$placeholder = '';
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}

		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){
			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}
			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$taskbot_html = '';		
		$taskbot_html .= '<div class="tb-pricingtitle form-field '.esc_attr($class).'">';

			if(!empty($field['label'])){
				$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
			}
			
			$taskbot_html .= '<input type="number" name="'.esc_attr($field_name).'" value="'.esc_attr($value).'" autocomplete="off" class="form-control" placeholder="'.esc_attr($placeholder).'"'.do_shortcode($step.$minvalue.$maxvalue.$disabled_field.$required_field.$field_title).'>';
		$taskbot_html .= '</div>';
		return $taskbot_html;
	}
	
	/**
	 * Render textarea field
	 *
	 * @since    1.0.0
	 * @access   public
	*/
	public function textarea_field($field){
		global $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name = '';

		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}

		$value = !empty($field['default_value']) ? $field['default_value'] : '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$rows = '';
		if(!empty($field['rows'])){
			$rows = ' rows="'.$field['rows'].'"';
		}

		$maxlength = '';
		if(!empty($field['maxlength'])){
			$maxlength = ' maxlength="'.$field['maxlength'].'"';
		}

		$placeholder = '';
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}

		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';

		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}
		
		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}

			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field '.esc_attr($class).'">';

			if(!empty($field['label'])){
				$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
			}
			
			$taskbot_html .= '<textarea class="form-control" name="'.esc_attr($field_name).'" autocomplete="off" placeholder="'.esc_attr($placeholder).'"'.do_shortcode($rows.$maxlength.$disabled_field.$required_field.$field_title).'>'.esc_textarea($value).'</textarea>';
		$taskbot_html .= '</div>';
		return $taskbot_html;
	}

	/**
	 * Render checkbox field
	 *
	 * @since    1.0.0
	 * @access   public
	*/	
	public function checkbox_field($field){
		global $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name = '';

		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}
		
		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}

		$value = '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}
		
		$random_number = rand();
		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
		
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}


		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){
			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}
			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field">';
			if(!empty($field['label'])){
				$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
			}
			$checked_opiton = '';
			if($value == 'yes'){
				$checked_opiton = 'checked="checked"';
			}
			$taskbot_html .= '
				<input type="hidden" name="'.esc_attr($field_name).'" value="no">
				<div class="tb-onoff">
					<input type="checkbox" id="hide-on'.esc_attr($random_number).'" value="yes" autocomplete="off" name="'.esc_attr($field_name).'" '.do_shortcode($checked_opiton.$disabled_field.$required_field.$field_title).'>
					<label for="hide-on'.esc_attr($random_number).'"><span class="tb-enable">'.esc_html__('Yes', 'taskbot').'</span><span class="tb-disable">'.esc_html__('No', 'taskbot').'</span><em><i></i></em></label>
				</div>
			';
			$taskbot_html .= '</div>';
			return $taskbot_html;
	}
	
	/**
	 * Render radio field
	 *
	 * @since    1.0.0
	 * @access   public
	*/		
	public function radio_field($field){
		global $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name = '';
		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}
		
		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}
		
		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}
		
		$value = array();
		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$choices = array();
		if(!empty($field['choices']) && is_array($field['choices']) && count($field['choices'])>1){
			$choices = $field['choices'];
		}
		
		$random_number = rand();
		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}	
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}	
		
		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){
			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}
			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field">';
		
			if(!empty($field['label'])){
				$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
			}
			
			foreach($choices as $key => $item){
				$checked_opiton = '';
				if($value == $key){
					$checked_opiton = 'checked="checked"';
				}

				$taskbot_html .= '
					<div class="tb-radiobox">
						<input type="radio" id="radio-type-'.esc_attr($field['plan']).'-'.esc_attr($key).'" value="'.esc_attr($key).'" autocomplete="off" name="'.esc_attr($field_name).'" '.do_shortcode($checked_opiton.$disabled_field.$required_field.$field_title).'>
						<label for="radio-type-'.esc_attr($field['plan']).'-'.esc_attr($key).'"><span class="tb-enable">'.$item.'</span></label>
					</div>
				';
			}
		
			$taskbot_html .= '</div>';
			return $taskbot_html;
	}
	
	/**
	 * Render subtask field
	 *
	 * @since    1.0.0
	 * @access   public
	*/		
	public function product_subtask_dropdwon($field){
		global $post, $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name = '';

		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}

		$value = '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$placeholder = '';
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}
		
		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		$multiple = '';
		if(!empty($field['multiple'])){
			$multiple = 'multiple';
			$field_name .= '[]';
		}
		$post_type = 'post';
		if(!empty($field['post_type'])){
			$post_type = $field['post_type'];
		}

		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field '.esc_attr($class).'">';

		if(!empty($field['label'])){
			$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
		}

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}

			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$args = array(
			'post_type'			=> $post_type,
			'post_status'		=> 'publish',
			'suppress_filters'	=> false,
			'type'      		=> 'subtasks',
			'posts_per_page'	=>-1
		);
		
		if(!empty($field['user_id'])){
			$args['author']	= $field['user_id'];
		}

		$posts = get_posts($args);

        $taskbot_html .= '<span class="tb-select"><select class="tb-select-feild '.esc_attr($field['class']).'" name="'. esc_attr($field_name).'" autocomplete="off" id="'.esc_attr($field['id']).'" '.do_shortcode($multiple.$disabled_field.$required_field.$field_title).'>';
        $taskbot_html .= '<option value = "" >'.esc_html($placeholder).'</option>';

        foreach ($posts as $subpost) {
			$_product = wc_get_product( $subpost->ID );

			if($_product->get_type() == 'subtasks'){
				$selected_opiton = '';

				if($multiple && is_array($value)){

					if(in_array($subpost->ID, $value)){
						$selected_opiton = 'selected="selected"';
					}

				} else {
					if($value == $subpost->ID){
						$selected_opiton = 'selected="selected"';
					}
				}
				$taskbot_html .= '<option value="'.intval($subpost->ID).'" '.do_shortcode($selected_opiton).'>'.esc_html($subpost->post_title).'</option>';
			}

        }
        $taskbot_html .= '</select>';
        $taskbot_html .= '</span>';
		$taskbot_html .= '</div>';
		wp_reset_postdata();

		return $taskbot_html;
	}
	
	/**
	 * Render select field
	 *
	 * @since    1.0.0
	 * @access   public
	*/		
	public function select_field($field){
		global $post, $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name = '';
		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}
		
		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}


		$value = '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$placeholder = esc_html__('Select an option', 'taskbot');
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}

		$multiple = '';
		if(!empty($field['multiple'])){
			$multiple = 'multiple="multiple" ';
			$field_name .= '[]';
		}

		$post_type = 'post';
		if(!empty($field['post_type'])){
			$post_type = $field['post_type'];
		}

		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$choices = array();
		if(!empty($field['choices']) && is_array($field['choices']) && count($field['choices'])>1){
			$choices = $field['choices'];
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field '.esc_attr($class).'">';

		if(!empty($field['label'])){
			$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
		}

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field	= '';

		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}

			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';

        $taskbot_html .= '<span class="tb-select">';
        $taskbot_html .= '<select class="'.esc_attr($field['class']).'" name="'. esc_attr($field_name).'" autocomplete="off" '.do_shortcode($multiple.$disabled_field.$required_field.$field_title).'>';
        $taskbot_html .= '<option value = "">'.esc_html($placeholder).'</option>';
		
        foreach($choices as $key => $item){
			
				$selected_option = '';
				
				if($multiple && is_array($value)){

					if(in_array($key, $value)){
						$selected_option = 'selected="selected"';
					}
				} else {

					if($value == $key){
						$selected_option = 'selected="selected"';
					}
				}
				
				$taskbot_html .= '<option value="'.esc_attr($key).'" '.do_shortcode($selected_option).'>'.esc_html($item).'</option>';
			
			
        }
		$taskbot_html .= '</span>';
        $taskbot_html .= '</select>';
		$taskbot_html .= '</div>';
		wp_reset_postdata();

		return $taskbot_html;
	}
	
	/**
	 * Render post dropdown
	 *
	 * @since    1.0.0
	 * @access   public
	*/		
	public function post_dropdwon($field){
		global $post, $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		$field_name = '';

		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}
		
		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}

		$value = '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$placeholder = '';
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}

		$multiple = '';
		if(!empty($field['multiple'])){
			$multiple = 'multiple';
			$field_name .= '[]';
		}

		$post_type = 'post';
		if(!empty($field['post_type'])){
			$post_type = $field['post_type'];
		}

		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field '.esc_attr($class).'">';

		if(!empty($field['label'])){
			$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
		}
	
		$args = array(
			'post_type'			=> $post_type,
			'post_status'		=> 'publish',
			'suppress_filters'	=> false,
			'posts_per_page'	=>-1
		);
		
		if(!empty($field['user_id'])){
			$args['author']	= $field['user_id'];
		}

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field	= '';

		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}

			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}

		$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';

		$posts = get_posts($args);

        $taskbot_html .= '<span class="tb-select">';
        $taskbot_html .= '<select class="'.esc_attr($field['class']).'" name="'. esc_attr($field_name).'" autocomplete="off" id="'.esc_attr($field['id']).'" '.do_shortcode($multiple.$disabled_field.$required_field.$field_title).'>';
        $taskbot_html .= '<option value = "" >'.esc_html($placeholder).'</option>';
		
        foreach ($posts as $subpost) {
			$_product = wc_get_product( $subpost->ID );
			
			if($_product->get_type() == 'subtasks'){
				$selected_opiton = '';
				
				if($multiple && is_array($value)){

					if(in_array($subpost->ID, $value)){
						$selected_opiton = 'selected="selected"';
					}
				} else {

					if($value == $subpost->ID){
						$selected_opiton = 'selected="selected"';
					}
				}
				$taskbot_html .= '<option value="'.intval($subpost->ID).'" '.do_shortcode($selected_opiton).'>'.esc_html($subpost->post_title).'</option>';
			}
			
        }
		$taskbot_html .= '</span>';
        $taskbot_html .= '</select>';
		$taskbot_html .= '</div>';
		wp_reset_postdata();

		return $taskbot_html;
	}
	
	/**
	 * Render taxonomy terms dropdown
	 *
	 * @since    1.0.0
	 * @access   public
	*/		
	public function terms_dropdwon($field){
		global $post, $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		
		$field_name = '';
		if(!empty($field['base'])){
			$field_name .= $field['base'];
		}

		if(!empty($field['plan'])){
			$field_name .= '['.$field['plan'].']';
		}
		
		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		if(!empty($field['id']) && !empty($field_name)){
			$field_name .= '['.$field['id'].']';
		} else {
			$field_name = $field['id'];
		}

		$value = '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}

		$placeholder = '';
		if(!empty($field['placeholder'])){
			$placeholder = $field['placeholder'];
		}

		$multiple = '';
		if(!empty($field['multiple'])){
			$multiple = 'multiple';
			$field_name .= '[]';
		}

		$taxonomy = 'category';
		if(!empty($field['taxonomy'])){
			$taxonomy = $field['taxonomy'];
		}
		
		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}
			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}


		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-pricingtitle form-field '.esc_attr($class).'">';
		if(isset($field['label']) && !empty($field['label'])){
			$taskbot_html .= '<label '.do_shortcode($label_class).'>'.esc_html($field['label']).':</label>';
		}

		$args = array(
			'show_option_none' => esc_html($placeholder),
			'show_count'       => false,
			'hide_empty'        => false,
			'name'              => $field_name,
			'class'             => $class,
			'taxonomy'          => "$taxonomy",
			'value_field'       => 'term_id',
			'selected'          => $value,
			'echo'             => false,
			'option_none_value' => '',
		);
		$taskbot_html .= '<span class="tb-select">';
        $taskbot_html .= wp_dropdown_categories( $args );
		$taskbot_html .= '</span>';
		$taskbot_html .= '</div>';
		return $taskbot_html;
	}

	/**
	 * Render taxonomy terms dropdown
	 *
	 * @since    1.0.0
	 * @access   public
	*/		
	public function featured_package($field){
		global $post, $current_user;
		$user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
		
		$field_name = '';
		
		$package_counter = 0;
		if(!empty($field['package_counter'])){
			$package_counter = $field['package_counter'];
		}

		$field_name = $field['id'];

		$value = '';
		if(!empty($field['value'])){
			$value = $field['value'];
		}
		
		$class = '';
		if(!empty($field['class'])){
			$class = $field['class'];
		}
				
		$label_class = '';
		if(!empty($field['label_class'])){
			$label_class = 'class="'.$field['label_class'].'"';
		}
		$selected_value	= !empty($field['value']) && $field['value'] === 'yes' ? 'checked' : '';

		$disabled_field	= '';	
		if( $user_type == 'sellers'){
			$disabled_field	= !empty($field['disabled']) ? ' disabled' : '';
		}

		$required_field = '';
		$field_title = '';
		
		if(empty($disabled_field)){

			if( $user_type == 'sellers' && $package_counter == 1){
				$required_field	= !empty($field['required']) ? ' required' : '';
			}
			$field_title	= !empty($field['title']) ? ' title="'.$field['title'].'"' : '';
		}
		$plan_name	= !empty($field['plan']) ? $field['plan'] : '';

		$taskbot_html = '';
		$taskbot_html .= '<div class="tb-radio tb-pricingtitle form-field '.esc_attr($class).'">';
			$taskbot_html .= '<input type="radio" '.esc_attr($selected_value).' id="tb-featured-'.do_shortcode($field_name.$plan_name).'" name="'.esc_attr($field_name).'" value="'.esc_attr($plan_name).'">';
			if(isset($field['label']) && !empty($field['label'])){
				$taskbot_html .= '<label '.do_shortcode($label_class).' for="tb-featured-'.do_shortcode($field_name.$plan_name).'"><span>'.esc_html($field['label']).'</span></label>';
			}	
		$taskbot_html .= '</div>';
		return $taskbot_html;
	}

}
