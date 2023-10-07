<?php
/**
 * Custom image size
 *
 */
add_image_size('taskbot_post_thumbnail', 625, 455, true);
add_image_size('taskbot_product_thumbnail', 624, 421, true);
add_image_size('taskbot_task_popular_service', 320, 464, true);
add_image_size('taskbot_task_our_professional', 315, 300, true);
add_image_size('taskbot_task_shortcode_thumbnail', 306, 200, true);
add_image_size('taskbot_buyer_image', 260, 212, true);
add_image_size('taskbot_thum_seller_image', 200, 200, true);
add_image_size('taskbot_seller_image', 164, 164, true);
add_image_size('taskbot_thumbnail', 100, 100, true);
add_image_size('taskbot_icon_thumbnail', 50, 50, true);



/**
 * Application access
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( !function_exists( 'taskbot_application_access' ) ) {
	function taskbot_application_access( $type='') {
		global $taskbot_settings;
		$application_access		= !empty($taskbot_settings['application_access']) ? $taskbot_settings['application_access'] : '';
		$return_type			= true;
		if( !empty($type) && $type === 'project'){
			$return_type	= !empty($application_access) && ($application_access == 'both' || $application_access == 'project_based') ? true : false;
		} else if( !empty($type) && $type === 'task'){
			$return_type	= !empty($application_access) && ($application_access === 'both' || $application_access === 'task_based') ? true : false;
		}
		return $return_type;
	}
}

/**
 * @init users online status
  *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_online_init')) {
	add_action('init', 'taskbot_online_init');
	add_action('admin_init', 'taskbot_online_init');
	function taskbot_online_init(){
		$logged_in_users = get_transient('users_online_status');
		$user = wp_get_current_user(); //Get the current user's data

		if ( !isset($logged_in_users[$user->ID]['last']) || $logged_in_users[$user->ID]['last'] <= time() - 300 ){
			$logged_in_users[$user->ID] = array(
				'id' 		=> $user->ID,
				'username' 	=> $user->user_login,
				'last' 		=> time(),
			);

			set_transient('users_online_status', $logged_in_users, 300);
		}
	}
}

/**
 * @logout users online status update
  *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_logout_init')) {
	add_action('wp_logout', 'taskbot_logout_init');
	function taskbot_logout_init(){
		$logged_in_users = get_transient('users_online_status');
		$user = wp_get_current_user(); //Get the current user's data

		if( !empty( $user->ID ) ){

			if( !empty( $logged_in_users[$user->ID] ) ){
				unset($logged_in_users[$user->ID]);
				set_transient('users_online_status', $logged_in_users, 300);
			}
		}
	}
}

/**
 * @Check if user is online
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_is_user_online')) {
	add_filter('taskbot_is_user_online','taskbot_is_user_online',10,1);
	function taskbot_is_user_online($id){
		$logged_in_users = get_transient('users_online_status');
		return isset($logged_in_users[$id]['last']) && $logged_in_users[$id]['last'] > time() - 300;
	}
}


/**
 * @Online status html
  *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_print_user_status')) {
	add_action('taskbot_print_user_status','taskbot_print_user_status',10,2);
	add_filter('taskbot_print_user_status','taskbot_print_user_status',10,2);
	function taskbot_print_user_status($id, $return='no'){

		$is_online	= apply_filters('taskbot_is_user_online',$id);
		$online		= '';

		if( $is_online === true ){
			$online	= '<figcaption class="tb-usertag tb-online" '.apply_filters('taskbot_tooltip_attributes', 'online_user').'></figcaption>';
		} else {
			$online	= '<figcaption class="tb-usertag tb-offline" '.apply_filters('taskbot_tooltip_attributes', 'offline_user').'></figcaption>';
		}

		$html	= apply_filters('taskbot_fetch_online_status',$online);

		if( $return === 'yes' ){
			return $html;
		} else{
			echo do_shortcode( $html );
		}
	}
}

/**
 * Recursive sanitize array values
 *
 * @return array
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_recursive_sanitize_text_field')) {
	function taskbot_recursive_sanitize_text_field($array) {
		foreach ( $array as $key => &$value ) {

			if ( is_array( $value ) ) {
				$value = taskbot_recursive_sanitize_text_field($value);
			} else {

				if($key == 'post_content'){
					$value = sanitize_textarea_field( $value );
				} elseif ($key == 'answer'){
					$value = sanitize_textarea_field( $value );
				} else {
					$value = sanitize_text_field( $value );
				}
			}

		}

		return $array;
	}
}


/**
 * Get Administrator user ID
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_admin_user_id')) {
    function taskbot_get_admin_user_id()
    {
		$user_id	= 1;
		$admin_users = get_users( 
			array( 
				'fields' => 'ID', 
				'role' => 'administrator' 
			)
		);
		foreach ( $admin_users as $user ) {

			if(!empty($user->ID)){
				$user_id	= $user->ID;
				break;
			}

		}

		return $user_id;

    }
}

/**
 * File uploader
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_temp_file_uploader')) {
    function taskbot_temp_file_uploader()
    {

		if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $json = array();
        /*=================== Wp Nonce Verification =================*/
        if (!wp_verify_nonce($_REQUEST['ajax_nonce'], 'ajax_nonce')) {
            $json['type']               = 'error';
            $json['message'] 		    = esc_html__('Restricted Access', 'taskbot');
            $json['message_desc'] 		= esc_html__('You are not allowed to perform this action.', 'taskbot');
            wp_send_json($json);
        }
		/*=================== End Wp Nonce Verification =================*/
        $response = Taskbot_file_permission::uploadFile($_FILES['file_name']);
        wp_send_json($response);
    }

    add_action('wp_ajax_taskbot_temp_file_uploader', 'taskbot_temp_file_uploader');
    add_action('wp_ajax_nopriv_taskbot_temp_file_uploader', 'taskbot_temp_file_uploader');
}

/**
 * File uploader
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_filter_payouts')) {
    function taskbot_filter_payouts($status='enable',$type=''){
		global $taskbot_settings;
		$payout_item_hide = !empty($taskbot_settings['payout_item_hide']) ? $taskbot_settings['payout_item_hide'] : array();
		if(!empty($payout_item_hide) && in_array($type,$payout_item_hide) ){
			return 'disable';
		}

		return $status;
    }

    add_filter('taskbot_filter_payouts', 'taskbot_filter_payouts',10,2);
}

/**
 * Payouts List
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbot_get_payouts_lists')) {
	function taskbot_get_payouts_lists(){
		global $taskbot_settings;
		$payout_bank_icon     = !empty($taskbot_settings['payout_bank_icon']['url']) ? $taskbot_settings['payout_bank_icon']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/earning/bank.png';
		$payout_paypal_icon   = !empty($taskbot_settings['payout_paypal_icon']['url']) ? $taskbot_settings['payout_paypal_icon']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/earning/paypal.png';
		$payout_stripe_icon   = !empty($taskbot_settings['payout_stripe_icon']['url']) ? $taskbot_settings['payout_stripe_icon']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/earning/stripe.png';
    	$payout_payoneer_icon = !empty($taskbot_settings['payout_payoneer_icon']['url']) ? $taskbot_settings['payout_payoneer_icon']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/earning/Payoneer.png';


	  	$lists = array(
			/* paypal */
			'paypal' => array(
				'id'                => 'paypal',
				'label'             => esc_html__('Paypal', 'taskbot'),
				'title'             => esc_html__('Setup paypal account', 'taskbot'),
				'img_url'           => esc_url($payout_paypal_icon),
				'status'            => apply_filters('taskbot_filter_payouts','enable','paypal'),
				'desc'              => wp_kses(__('You need to add your PayPal email ID above. For more about <a target="_blank" href="https://www.paypal.com/"> PayPal </a> | <a target="_blank" href="https://www.paypal.com/signup/">Create an account</a>', 'taskbot'), array(
					'a'               => array(
					'href'          => array(),
					'target'        => array(),
					'title'         => array()
					),
					'br'              => array(),
					'em'              => array(),
					'strong'          => array(),
				)),
				'fields'	=> array(
					'paypal_email'    => array(
						'type'          => 'text',
						'classes'       => '',
						'required'      => true,
						'show_this'     => true,
						'title'         => esc_html__('PayPal email address', 'taskbot'),
						'placeholder'   => esc_html__('Enter paypal email here', 'taskbot'),
						'message'       => esc_html__('PayPal Email Address is required', 'taskbot'),
					)
				)
			),
			/* payoneer */
			'payoneer' => array(
				'id'		=> 'payoneer',
				'title'		=> esc_html__('Payoneer', 'taskbot'),
				'img_url'	=> esc_url($payout_payoneer_icon),
				'status'	=> apply_filters('taskbot_filter_payouts','enable','payoneer'),
				'desc'		=> wp_kses( __( 'You need to add your payoneer email ID below in the text field. For more about <a target="_blank" href="https://www.payoneer.com/"> Payoneer </a> | <a target="_blank" href="https://www.payoneer.com/accounts/">Create an account</a>', 'taskbot' ),array(
					'a' => array(
						'href' => array(),
						'target' => array(),
						'title' => array()
					),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
				)),
				'fields'	=> array(
					'payoneer_email' => array(
						'type'			=> 'text',
						'show_this'		=> true,
						'classes'		=> '',
						'required'		=> true,
						'title'			=> esc_html__('Payoneer email address','taskbot'),
						'placeholder'	=> esc_html__('Add Payoneer email address','taskbot'),
						'message'		=> esc_html__('Payoneer email address is required','taskbot'),
					)
				)
			),
			/* bank */
			'bank'                => array(
				'id'                => 'bank',
				'label'             => esc_html__('Bank', 'taskbot'),
				'title'             => esc_html__('Setup bank account', 'taskbot'),
				'img_url'           => esc_url($payout_bank_icon),
				'status'            => apply_filters('taskbot_filter_payouts','enable','bank'),
				'desc'              => wp_kses(__('Add all required settings for the bank transfer', 'taskbot'), array(
					'a'               => array(
					'href'          => array(),
					'target'        => array(),
					'title'         => array()
					),
					'br'              => array(),
					'em'              => array(),
					'strong'          => array(),
				)),
				'fields'	=> array(
					'bank_account_title'	=> array(
						'type'          => 'text',
						'classes'       => '',
						'required'      => true,
						'show_this'     => true,
						'title'         => esc_html__('Bank account title', 'taskbot'),
						'placeholder'   => esc_html__('Bank account title', 'taskbot'),
						'message'       => esc_html__('Bank Account Title is required', 'taskbot'),
					),
					'bank_account_number' => array(
						'type'          => 'text',
						'classes'       => '',
						'required'      => true,
						'show_this'     => true,
						'title'         => esc_html__('Bank account number', 'taskbot'),
						'placeholder'   => esc_html__('Bank account number', 'taskbot'),
						'message'       => esc_html__('Bank Account Number is required', 'taskbot'),
					),
					'bank_account_name' => array(
						'type'          => 'text',
						'classes'       => '',
						'required'      => true,
						'show_this'     => true,
						'title'         => esc_html__('Bank name', 'taskbot'),
						'placeholder'   => esc_html__('Bank name', 'taskbot'),
						'message'       => esc_html__('Bank Name is required', 'taskbot'),
					),
					'bank_routing_number' => array(
						'type'          => 'text',
						'classes'       => '',
						'required'      => true,
						'show_this'     => true,
						'title'         => esc_html__('Bank routing number', 'taskbot'),
						'placeholder'   => esc_html__('Bank routing number', 'taskbot'),
						'message'       => esc_html__('Bank Routing Number is required', 'taskbot'),
					),
					'bank_iban' => array(
						'type'          => 'text',
						'classes'       => '',
						'required'      => true,
						'show_this'     => true,
						'title'         => esc_html__('Bank IBAN', 'taskbot'),
						'placeholder'   => esc_html__('Bank IBAN', 'taskbot'),
						'message'       => esc_html__('Bank IBN is required', 'taskbot'),
					),
					'bank_bic_swift' => array(
						'type'			=> 'text',
						'classes'		=> '',
						'required'		=> false,
						'show_this'		=> true,
						'title'	=> esc_html__('Bank BIC/SWIFT','taskbot'),
						'placeholder'	=> esc_html__('Bank BIC/SWIFT','taskbot'),
						'message'		=> esc_html__('Bank BIC/SWIFT is required','taskbot'),
					)
				)
			),
	  );
	  $lists = apply_filters('taskbot_filter_payouts_lists', $lists);
	  return $lists;
	}
}

/**
 * Get user type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_get_linked_profile_id')) {
    function taskbot_get_linked_profile_id($id='', $type='users',$role='') {

		if( $type === 'post') {
			$linked_profile = get_post_meta($id, '_linked_profile', true);
		} else {

			if(empty($role)){
				$role = get_user_meta($id,'_user_type',true);
			}

            if (!empty($role) && $role === 'sellers') {
                $linked_profile = get_user_meta($id, '_linked_profile', true);
            } elseif (!empty($role) && $role === 'buyers') {
               $linked_profile = get_user_meta($id, '_linked_profile_buyer', true);
            }
		}

        $linked_profile	= !empty( $linked_profile ) ? $linked_profile : '';
        return intval( $linked_profile );
    }
	add_filter('taskbot_get_linked_profile_id', 'taskbot_get_linked_profile_id', 10, 3);
}


/**
 * get user type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_get_user_role_type')) {

    function taskbot_get_user_role_type($user_identity) {

        if (!empty($user_identity)) {
            $data = get_userdata($user_identity);
			if ( in_array( 'sellers', (array) $data->roles ) ) {
				return 'sellers';
			} elseif ( in_array( 'buyers', (array) $data->roles ) ) {
				return 'buyers';
			} elseif ( in_array( 'administrator', (array) $data->roles ) ) {
				return 'administrator';
			} elseif ( in_array( 'subscriber', (array) $data->roles ) ) {
				return 'subscriber';
			} else {
                return false;
            }
        }

        return false;
    }

    add_filter('taskbot_get_user_role_type', 'taskbot_get_user_role_type', 10, 1);
}

/**
 * Get template page uri
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_get_page_uri' ) ) {
    function taskbot_get_page_uri( $type = '' ) {
		global $taskbot_settings;
		$tpl_page		= !empty($taskbot_settings['tpl_'.$type]) ? $taskbot_settings['tpl_'.$type] : '';
        $search_page 	= !empty($tpl_page) ? get_permalink((int) $tpl_page) : '';
        return $search_page;
    }
}

/**
 * Get dashbod page uri
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_dashboard_page_uri' ) ) {
    function taskbot_dashboard_page_uri( $user_type = '' ) {
        $redirect_type	= !empty($_SESSION["redirect_type"]) ? $_SESSION["redirect_type"] : '';
		$redirect		= taskbot_get_page_uri('dashboard');
		$redirect		= !empty($redirect) ? esc_url($redirect) : home_url('/');

		if( !empty($redirect_type) && ($redirect_type === 'post_task') && $user_type === 'sellers'){
			$redirect	= !empty($_SESSION["redirect_url"]) ? $_SESSION["redirect_url"] : $redirect;
		} elseif ( !empty($redirect_type) && ($redirect_type === 'dashboard_page')){
			$redirect	= !empty($_SESSION["redirect_url"]) ? $_SESSION["redirect_url"] : $redirect;
		} elseif ( !empty($redirect_type) && ($redirect_type === 'task_cart') && $user_type === 'buyers'){
			$redirect	= !empty($_SESSION["redirect_url"]) ? $_SESSION["redirect_url"] : $redirect;
		} elseif ( !empty($user_type) && $user_type === 'administrator' ){
			$redirect	= taskbot_get_page_uri('admin_dashboard');
		}

        return $redirect;
    }
}

/**
 * Redirect after login and registration
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_auth_redirect_page_uri' ) ) {
    function taskbot_auth_redirect_page_uri( $redirect_type = '', $user_id='' ) {
		global	$taskbot_settings;
		$user_type	= apply_filters('taskbot_get_user_type', $user_id );

		if( !empty($redirect_type) && ($redirect_type === 'login') && $user_type === 'sellers'){
			$login_redirect	= !empty($taskbot_settings['login_redirect_seller']) ? $taskbot_settings['login_redirect_seller'] : 'home';

			if(!empty($login_redirect) && $login_redirect == 'dashboard'){
				$redirect		= taskbot_get_page_uri('dashboard');
			}else if(!empty($login_redirect) && $login_redirect == 'profile'){
				$redirect		= Taskbot_Profile_Menu::taskbot_profile_menu_link('dashboard', $user_id, true, 'profile');
			}else if(!empty($login_redirect) && $login_redirect == 'projects'){
				$redirect		= !empty($taskbot_settings['tpl_project_search_page']) ? get_permalink($taskbot_settings['tpl_project_search_page']) : home_url('/');
			}else{
				$redirect	= home_url('/');
			}

		} elseif( !empty($redirect_type) && ($redirect_type === 'login') && $user_type === 'buyers'){
			$login_redirect	= !empty($taskbot_settings['login_redirect_buyer']) ? $taskbot_settings['login_redirect_buyer'] : 'home';

			if(!empty($login_redirect) && $login_redirect == 'dashboard'){
				$redirect		= taskbot_get_page_uri('dashboard');
			}else if(!empty($login_redirect) && $login_redirect == 'profile'){
				$redirect		= Taskbot_Profile_Menu::taskbot_profile_menu_link('dashboard', $user_id, true, 'profile');
			}else if(!empty($login_redirect) && $login_redirect == 'freelancer'){
				$redirect		= !empty($taskbot_settings['tpl_sellers_search_page']) ? get_permalink($taskbot_settings['tpl_sellers_search_page']) : home_url('/');
			}else if(!empty($login_redirect) && $login_redirect == 'task'){
				$redirect		= !empty($taskbot_settings['tpl_service_search_page']) ? get_permalink($taskbot_settings['tpl_service_search_page']) : home_url('/');
			}else{
				$redirect	= home_url('/');
			}
		}else{
			$redirect	= home_url('/');
		}

        return $redirect;
    }
}
/**
 * Get user role
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_get_user_type')) {

    function taskbot_get_user_type($user_identity) {

        if (!empty($user_identity)) {

            $user_type = get_user_meta($user_identity,'_user_type',true);
			
            if (!empty($user_type) && $user_type === 'sellers') {
                return 'sellers';
            } elseif (!empty($user_type) && $user_type === 'buyers') {
               return 'buyers';
            } elseif (empty($user_type)) {

				$data = get_userdata( $user_identity );
				if ( !empty( $data->roles[0] ) && $data->roles[0] == 'administrator') {
					return 'administrator';
				}
			}
        }

        return 'administrator';
    }

    add_filter('taskbot_get_user_type', 'taskbot_get_user_type', 10);
}

/**
 * Get user role
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_get_profile_type')) {

    function taskbot_get_profile_type($user_identity) {
		global	$taskbot_settings;
        if (!empty($user_identity)) {

            $user_type = get_post_type($user_identity);

            if (!empty($user_type) && $user_type === 'sellers') {
                return 'sellers';
            } else {
               return 'buyers';
            }
        }

        return 'buyers';
    }

    add_filter('taskbot_get_profile_type', 'taskbot_get_profile_type', 10);
}

/**
 * Get user avatar
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( !function_exists( 'taskbot_get_user_avatar' ) ) {
	function taskbot_get_user_avatar( $sizes = array(), $user_identity = '' ) {
		global	$taskbot_settings;
		extract( shortcode_atts( array(
			"width" => '100',
			"height" => '100',
		), $sizes ) );

		$thumb_id = get_post_thumbnail_id( $user_identity );

		if ( !empty( $thumb_id ) ) {
			$thumb_url = wp_get_attachment_image_src( $thumb_id, array( $width, $height ), true );

			if ( $thumb_url[1] == $width and $thumb_url[2] == $height ) {
				return !empty( $thumb_url[0] ) ? $thumb_url[0] : '';
			} else {
				$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );

				if (strpos($thumb_url[0],'media/default.png') !== false) {
					return '';
				} else {
					return !empty( $thumb_url[0] ) ? $thumb_url[0] : '';
				}
			}

		} else {

			$default_avatar = array();
			$user_type		= apply_filters('taskbot_get_profile_type', $user_identity );

			if( !empty($user_type) && $user_type == 'sellers') {
				$default_avatar	= !empty($taskbot_settings['defaul_sellers_profile']) ? $taskbot_settings['defaul_sellers_profile'] : array();
			} elseif ( !empty($user_type) && $user_type == 'buyers') {
				$default_avatar	= !empty($taskbot_settings['defaul_buyers_profile']) ? $taskbot_settings['defaul_buyers_profile'] : array();
			}

			if ( isset($default_avatar['id']) && !empty( $default_avatar['id'] ) ) {
				$thumb_url = wp_get_attachment_image_src( $default_avatar['id'], array( $width, $height ), true );

				if ( $thumb_url[1] == $width and $thumb_url[2] == $height ) {
					return $thumb_url[0];
				} else {
					$thumb_url = wp_get_attachment_image_src( $default_avatar['id'], "full", true );

					if (strpos($thumb_url[0],'media/default.png') !== false) {
						return '';
					} else{

						if ( !empty( $thumb_url[0] ) ) {
							return $thumb_url[0];
						} else {
							return false;
						}
					}

				}

			} else {
				return false;
			}
		}
	}
}


/**
 * Render tippy
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_render_tippy' ) ) {
	add_action('taskbot_render_tippy','taskbot_render_tippy',10,2);
	add_filter('taskbot_render_tippy','taskbot_render_tippy',10,2);
    function taskbot_render_tippy( $key = '', $return='no' ) {
		global $taskbot_settings;
		$tip_page		= !empty($taskbot_settings['tip_'.$key]) ? $taskbot_settings['tip_'.$key] : '';
		ob_start(); ?>
      	<i class="ti-info-alt tippy" data-tippy-content="<?php echo do_shortcode($tip_page);?>"></i>
        <?php
        $tip_data	= ob_get_clean();

		if(!empty($return) && $return === 'yes'){
			return $tip_data;
		}

		echo do_shortcode( $tip_data );
    }
}

/**
 * Upload temp files to WordPress media
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_temp_upload_to_media')) {
    function taskbot_temp_upload_to_media($file_url, $post_id, $encrypt_file=true) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}

        $json   =  array();
        $upload_dir = wp_upload_dir();
		$folderRalativePath = $upload_dir['baseurl']."/taskbot-temp";
		$folderAbsolutePath = $upload_dir['basedir']."/taskbot-temp";

		$args = array(
			'timeout'	=> 15,
			'headers'	=> array('Accept-Encoding' => ''),
			'sslverify'	=> false
		);

		$response   	= wp_remote_get( $file_url, $args );
		$file_data		= wp_remote_retrieve_body($response);

		if(empty($file_data)){
			$json['attachment_id']  = '';
			$json['url']            = '';
			$json['name']			= '';
			return $json;
		}

		$filename 			= basename($file_url);
		$temp_filename 		= $filename;

        if (wp_mkdir_p($upload_dir['path'])){
			$file = $upload_dir['path'] . '/' . $filename;
		}  else {
            $file = $upload_dir['basedir'] . '/' . $filename;
		}

		$file_detail  		= taskbot_file_permission::getEncryptFile($file, $post_id, true, $encrypt_file);
		$new_filename		= $file_detail['name'];
		$new_path 			= $upload_dir['path'] . '/' . $new_filename;
		$file				= $new_path;
		$filename 			= basename($file);
		$actual_filename 	= pathinfo($file, PATHINFO_FILENAME);
		//put content to the file
		file_put_contents($file, $file_data);
        $wp_filetype = wp_check_filetype($filename, null);

		$attachment = array(
            'post_mime_type' 	=> $wp_filetype['type'],
            'post_title' 		=> sanitize_file_name($filename),
            'post_content' 		=> '',
            'post_status' 		=> 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
		wp_update_attachment_metadata($attach_id, $attach_data);
		$post_type = get_post_type($post_id);
		update_post_meta($attach_id,'is_encrypted','1');
        $json['attachment_id']  = $attach_id;
        $json['url']            = $upload_dir['url'] . '/' . basename( $filename );
		$json['name']			= $filename;
		
		$target_path 			= $folderAbsolutePath . "/" . $temp_filename;
        if(file_exists($target_path)){
        	unlink($target_path); //delete file after upload
		}
        return $json;
    }
}

/**
 * Upload files from temp directory to task activity directory
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_temp_upload_to_activity_dir')) {
  function taskbot_temp_upload_to_activity_dir($file_url, $post_id, $encrypt_file=true) {
    global $wp_filesystem;

    if (empty($wp_filesystem)) {
      require_once (ABSPATH . '/wp-admin/includes/file.php');
      WP_Filesystem();
    }

    $json               =  array();
    $upload_dir         = wp_upload_dir();

    // store the temp dir paths in variable
    $folderRalativePath = $upload_dir['baseurl']."/taskbot-temp";
    $folderAbsolutePath = $upload_dir['basedir']."/taskbot-temp";

    // custom path to create directory
    $taskbotActivityRalativePath  = $upload_dir['baseurl']."/taskbot_activity/$post_id";
    $taskbotActivityrAbsolutePath = $upload_dir['basedir']."/taskbot_activity/$post_id";

    $args = array(
      'timeout'   => 15,
      'headers'   => array('Accept-Encoding' => ''),
      'sslverify' => false
    );

    $response  = wp_remote_get( $file_url, $args );
    $file_data = wp_remote_retrieve_body($response);

    if(empty($file_data)){
      $json['attachment_id']  = '';
      $json['url']            = '';
      $json['name']			      = '';
      return $json;
    }

    $filename 		  = basename($file_url);
    $temp_filename 	= $filename;

    // create directory
    if (wp_mkdir_p($taskbotActivityrAbsolutePath)){
    	$file = $taskbotActivityrAbsolutePath . '/' . $filename;
    }  else {
    	$file = $upload_dir['basedir'] . '/' . $filename;
    }

    $file_detail	= taskbot_file_permission::getEncryptFile($file, $post_id, true, $encrypt_file);
    $new_filename	= $file_detail['name'];
    $new_path		= $taskbotActivityrAbsolutePath . '/' . $new_filename;
    $file			= $new_path;
    $filename			= basename($file);
    $actual_filename	= pathinfo($file, PATHINFO_FILENAME);
    //upload file to directory
    file_put_contents($file, $file_data);
    $wp_filetype	= wp_check_filetype($filename, null);
    $json['url']	= $taskbotActivityRalativePath . '/' . basename( $filename );
    $json['name']	= $filename;
    $json['ext']	= $wp_filetype['ext'];
    $target_path	= $folderAbsolutePath . "/" . $temp_filename;
    // delete file from temp directory
    unlink($target_path);
    return $json;
  }
}


if(!function_exists('taskbot_process_geocode_info')) {
    function taskbot_process_geocode_info ($postal_code='',$region_name='',$type='') {
        global $taskbot_settings;
		$geo_data			= array();
        $json				= array();
		$json['message']	= esc_html__('Postal code','taskbot');
        $google_key			= !empty($taskbot_settings['google_map']) ? $taskbot_settings['google_map'] : '';
        
		if(empty($google_key)) {
			$json['type'] 			= 'error';
			$json['message_desc'] 	= esc_html__('You have not set google map API key yet', 'taskbot');
        } else {

			$geo_zip_code   = !empty($postal_code) ? esc_html($postal_code) : '';
			$region  		= !empty($region_name) ? esc_html($region_name) : '';
			$geo_request 	= wp_remote_get( 'https://maps.googleapis.com/maps/api/geocode/json?address='.$geo_zip_code.'&region='.$region.'&key='.$google_key );

			if( is_wp_error( $geo_request ) ) {
				$json['type'] 			= 'error';
				$json['message_desc'] 	= esc_html__('Something went wrong', 'taskbot');
			} else {
				$body = wp_remote_retrieve_body( $geo_request );
				
				if($body) {
					$response	= json_decode($body, true);
					if ($response['status'] == 'OK') {
						$geo_data 		= taskbot_process_geocode_results($response['results'][0]);
						$found_region	= !empty($geo_data['country']['short_name']) ? $geo_data['country']['short_name'] : '';
						
						if(!empty($found_region) && $found_region != $region ){
							$json['type'] 			= 'error';
							$json['message_desc'] 	= esc_html__("Pleae enter the correct zip code", 'taskbot');
						} else {

							$json['type']       = 'success';
							$json['message'] 	= esc_html__("Geo zip code data successfully found", 'taskbot');
							$json['geo_data']   = $geo_data;
						}
					} else {
						$json['type'] 			= 'error';
						$json['message_desc'] 	= !empty($response['error_message']) ? $response['error_message'] : esc_html__("Please add the correct postal code", 'taskbot');
					}
				}
			}
		}

		if( empty($type) ){
			if( !empty($json['type']) && $json['type'] == 'success' && !empty($geo_data) ){
				return $geo_data;
			} else {
				wp_send_json( $json );
			}

		} else {
			return $json;
		}
    }
}

/**
 * Get geocode location
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if(!function_exists('taskbot_process_geocode_results')) {
	function taskbot_process_geocode_results($geo_data = array()) {

		$geo_code_data = array();

		if(!empty($geo_data)) {

			for($i = 0; $i < count($geo_data['address_components']); $i++) {
				$addressType = $geo_data['address_components'][$i]['types'][0];

				if ($addressType == "locality") {
					$geo_code_data['locality']['long_name'] 	= $geo_data['address_components'][$i]['long_name'];
					$geo_code_data['locality']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
				}

				if ($addressType == "country") {
					$geo_code_data['country']['long_name'] 	= $geo_data['address_components'][$i]['long_name'];
					$geo_code_data['country']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
				}

				if($addressType == "administrative_area_level_1") {
					$geo_code_data['administrative_area_level_1']['long_name'] 		= $geo_data['address_components'][$i]['long_name'];
					$geo_code_data['administrative_area_level_1']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
				}

				if ($addressType == "administrative_area_level_2") {
					$geo_code_data['administrative_area_level_1']['long_name'] 		= $geo_data['address_components'][$i]['long_name'];
					$geo_code_data['administrative_area_level_1']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
				}

				$geo_code_data['address'] 	= $geo_data['formatted_address'];
				$geo_code_data['lng'] 		= $geo_data['geometry']['location']['lng'];
				$geo_code_data['lat'] 		= $geo_data['geometry']['location']['lat'];

			}

			return $geo_code_data;
		}
	}
}

/**
 * Get service list
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_service_list' ) ) {
    function taskbot_service_list( $type = '' ) {
		$list	= array(
			'1'	=> array(
				'title' 	=> esc_html__('Task introduction', 'taskbot'),
				'class'		=> 'tb-addservice-step'
			),
			'2'	=> array(
				'title' 	=> esc_html__('Task pricing', 'taskbot'),
				'class'		=> 'tb-addservice-step tb-addservice-step-2'
			),
			'3'	=> array(
				'title' 	=> esc_html__('Media/Attachments', 'taskbot'),
				'class'		=> 'tb-addservice-step tb-addservice-step-3'
			),
			'4'	=> array(
				'title' 	=> esc_html__('Common FAQ’s', 'taskbot'),
				'class'		=> 'tb-addservice-step tb-addservice-step-4'
			),
		);
		$list 	= apply_filters('taskbot_filter_service_list',$list);
		return $list;
    }
}

/**
 * List ACF group
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_acf_groups' ) ) {
    function taskbot_acf_groups( $plan_array = array() ) {
		$list	= array();

		if(function_exists('acf_get_field_groups')){
			$groups = acf_get_field_groups();
			
			if( !empty($groups) ){
				foreach($groups as $group){
					foreach( $group['location'] as $group_locations ) {
						$role_array			= array();
						$count_location		= !empty($group_locations) ? count($group_locations) : 0;
						$count_true			= 0;
						foreach( $group_locations as $rule ) {
							foreach( $plan_array as $plan_k => $plan_value ) {

								if( $rule['param'] == $plan_k && $rule['operator'] == '==' && in_array($rule['value'],$plan_value)){
									$count_true	= $count_true+1;
								} elseif( $rule['param'] == $plan_k && $rule['operator'] == '!=' && !in_array($rule['value'],$plan_value)){
									$count_true	= $count_true+1;
								}

							}
						}

						if( !empty($count_true) && $count_true === $count_location ){
							$fields 		= acf_get_fields($group['ID']);
							
							if( !empty($fields) ){
								foreach($fields as $field ){
									
									if(!empty($field['type']) && $field['type'] == 'group' ){
										foreach($field['sub_fields'] as $sub_fields ){
											$list[]	= $sub_fields;
										}
									} elseif (!empty($field['sub_fields'])){
										$list[]	= !empty($field['sub_fields']) ? $field['sub_fields'] : array();
									} else {
										$list[]	= !empty($field) ? $field : array();
									}
								}
							}

						}

					}
				}
			}

		}
		$list 	= apply_filters('taskbot_filter_acf_groups',$list);
		return $list;
    }
}

/**
 * Update commisssion fee
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( !function_exists( 'taskbot_commission_fee' ) ) {
	function taskbot_commission_fee( $proposed_price='',$post_id='' ) {
		global $taskbot_settings;
		$percentage		= !empty($taskbot_settings['admin_commision']) ? $taskbot_settings['admin_commision'] : 0;
		$admin_shares 	= $proposed_price/100 * $percentage;
		$seller_shares 	= $proposed_price - $admin_shares;

		$settings['admin_shares'] 	= !empty($admin_shares) && $admin_shares > 0 ? number_format($admin_shares,2,'.', '') : 0.0;
		$settings['seller_shares'] 	= !empty($seller_shares) && $seller_shares > 0 ? number_format($seller_shares,2,'.', '') : 0.0;

		return $settings;
	}
}

/**
 * Get order type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_invoice_order_types' ) ) {
    function taskbot_invoice_order_types( $type = '' ) {
		$list	= array(
			'buyers'	=> array(
				'wallet'	=> esc_html__('All','taskbot'),
				'wallet'	=> esc_html__('Wallet','taskbot'),
				'projects'	=> esc_html__('Projects','taskbot'),
				'tasks'		=> esc_html__('Task','taskbot')
			),
			'sellers'	=> array(
				'package'	=> esc_html__('Package','taskbot'),
				'projects'	=> esc_html__('Projects','taskbot'),
				'tasks'		=> esc_html__('Task','taskbot')
			)
		);
		$task		= taskbot_application_access('task');	
		$projects	= taskbot_application_access('projects');
		
		if( empty($task) ){
			unset($list['buyers']['tasks']);
			unset($list['sellers']['tasks']);
		}

		if( empty($task) ){
			unset($list['buyers']['projects']);
			unset($list['sellers']['projects']);
		}
		
		$list 		= apply_filters('taskbot_filter_invoice_order_types',$list);

		if( !empty($type) ){
			$list	= !empty($list[$type]) ? $list[$type] : array();
		}

		return $list;
    }
}


/**
 * Task order status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_post_status')) {
    add_action( 'taskbot_post_status', 'taskbot_post_status');
    function taskbot_post_status($post_id)
    {
        $post_status    = get_post_status( $post_id );
        $post_status    = !empty($post_status) ? $post_status : '';
        $label_link     = '';
        switch($post_status){
            case 'pending':
                $label      = esc_html__('Pending', 'taskbot');
                $label_link = '<span class="tb-tag-bordered">'.esc_html($label).'</span';
                break;
            case 'publish':
                $label      = _x('Completed', 'Title for post status', 'taskbot' );
                $label_link = '<span class="bordr-green">'.esc_html($label).'</span';
                break;
            case 'rejected':
                $label      = esc_html__('Rejected', 'taskbot');
                $label_link = '<span class="bordr-red">'.esc_html($label).'</span';
                break;
            default:
                $label      = esc_html__('New', 'taskbot');
                $label_link = '<span class="tb-tag-bordered bordr-blue">'.esc_html($label).'</span';
        }

        ob_start();
        ?>
            <div class="tb-bordertags"><?php echo do_shortcode( $label_link );?></div>
        <?php
        echo ob_get_clean();

    }
}

/**
 * Task order status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_task_status')) {
    add_action( 'taskbot_task_status', 'taskbot_task_status');
    function taskbot_task_status($post_id)
    {
        $post_status    = get_post_status( $post_id );
        $post_status    = !empty($post_status) ? $post_status : '';
        $label_link     = '';
        switch($post_status){
			case 'draft':
                $label      = esc_html__('Pending', 'taskbot');
                $label_link = '<span class="tb-tag-bordered">'.esc_html($label).'</span>';
                break;
            case 'pending':
                $label      = esc_html__('Pending', 'taskbot');
                $label_link = '<span class="tb-tag-bordered">'.esc_html($label).'</span>';
                break;
            case 'publish':
                $label      = esc_html__('Published', 'taskbot');
                $label_link = '<span class="bordr-green">'.esc_html($label).'</span>';
                break;
            case 'rejected':
                $label      = esc_html__('Rejected', 'taskbot');
                $label_link = '<span class="bordr-red">'.esc_html($label).'</span>';
                break;
            default:
                $label      = esc_html__('New', 'taskbot');
                $label_link = '<span class="tb-tag-bordered bordr-blue">'.esc_html($label).'</span>';
        }

        ob_start();
        ?>
            <div class="tb-bordertags"><?php echo do_shortcode( $label_link );?></div>
        <?php
        echo ob_get_clean();

    }
}

/**
 * Project order status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_project_status')) {
    add_action( 'taskbot_project_status', 'taskbot_project_status');
    function taskbot_project_status($post_id)
    {
        $post_status    = get_post_status( $post_id );
        $post_status    = !empty($post_status) ? $post_status : '';
        $label_link     = '';
        switch($post_status){
			case 'draft':
                $label      = esc_html__('Draft', 'taskbot');
                $label_link = '<span class="tb-tag-bordered">'.esc_html($label).'</span>';
                break;
            case 'pending':
                $label      = esc_html__('Pending', 'taskbot');
                $label_link = '<span class="tb-tag-bordered">'.esc_html($label).'</span>';
                break;
            case 'publish':
                $label      = esc_html__('Published', 'taskbot');
                $label_link = '<span class="bordr-green">'.esc_html($label).'</span>';
                break;
            case 'rejected':
                $label      = esc_html__('Rejected', 'taskbot');
                $label_link = '<span class="bordr-red">'.esc_html($label).'</span>';
                break;
            default:
                $label      = esc_html__('New', 'taskbot');
                $label_link = '<span class="tb-tag-bordered bordr-blue">'.esc_html($label).'</span>';
        }

        ob_start();
        ?>
            <div class="tb-bordertags"><?php echo do_shortcode( $label_link );?></div>
        <?php
        echo ob_get_clean();

    }
}

/**
 * List Months
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_list_month' ) ) {
    function taskbot_list_month( ) {
		$month_names = array(
			'01'	=> esc_html__("January",'taskbot'),
			'02'	=> esc_html__("February",'taskbot'),
			'03' 	=> esc_html__("March",'taskbot'),
			'04'	=> esc_html__("April",'taskbot'),
			'05'	=> esc_html__("May",'taskbot'),
			'06'	=> esc_html__("June",'taskbot'),
			'07'	=> esc_html__("July",'taskbot'),
			'08'	=> esc_html__("August",'taskbot'),
			'09'	=> esc_html__("September",'taskbot'),
			'10'	=> esc_html__("October",'taskbot'),
			'11'	=> esc_html__("November",'taskbot'),
			'12'	=> esc_html__("December",'taskbot')
		);
		return $month_names;

	}
}


/**
 * download activity attachments
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */

if( !function_exists( 'taskbot_download_chat_attachments' ) ){
	function taskbot_download_chat_attachments(){
		global $current_user;
		$json = array();

		//security check
		if (!wp_verify_nonce($_POST['security'], 'ajax_nonce')) {
			$json['type']		= 'error';
			$json['message']	= esc_html__('Oops', 'taskbot');
			$json['message']	= esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
			wp_send_json($json);
		}

		$attachment_id	=  !empty( $_POST['comments_id'] ) ? intval($_POST['comments_id']) : '';

		if( empty( $attachment_id ) ){
			$json['type']			= 'error';
			$json['message']		= esc_html__('Oops!', 'taskbot');
			$json['message_desc']	= esc_html__('Attachment is missing', 'taskbot');
			wp_send_json($json);

		} else {

			$project_files = get_comment_meta( $attachment_id, 'message_files', true);

			if( !empty( $project_files ) ){

				if( class_exists('ZipArchive') ){
					$zip                  = new ZipArchive();
					$uploadspath	      = wp_upload_dir();
					$folderRalativePath   = $uploadspath['baseurl']."/downloads";
					$folderAbsolutePath   = $uploadspath['basedir']."/downloads";

					wp_mkdir_p($folderAbsolutePath);

					$rand	        = taskbot_unique_increment(5);
					$filename	    = $rand.round(microtime(true)).'.zip';
					$zip_name     	= $folderAbsolutePath.'/'.$filename;
					$download_url	= $folderRalativePath.'/'.$filename;
					$zip->open($zip_name,  ZipArchive::CREATE);

					foreach($project_files as $key => $value) {
						$file_url	= taskbot_add_http_protcol($value['url']);
						$response	= wp_remote_get( $file_url );
						$filedata = wp_remote_retrieve_body( $response );
						$zip->addFromString(basename( $file_url ), $filedata);
					}

					$zip->close();

				} else {
					$json['type'] 			= 'error';
					$json['message'] 		= esc_html__('Oops!', 'taskbot');
					$json['message_desc'] 	= esc_html__('Zip library is not installed on the server, please contact to hosting provider', 'taskbot');
					wp_send_json($json);
				}
			}

		$json['type'] 		= 'success';
		$json['attachment'] = taskbot_add_http_protcol($download_url);
		$json['message'] 	= esc_html__('File has been downloaded', 'taskbot');
		wp_send_json($json);
	  }
	}
	add_action('wp_ajax_taskbot_download_chat_attachments', 'taskbot_download_chat_attachments');
  }

  /**
 * @Init Pagination Code Start
 * @return
 */
if (!function_exists('taskbot_order_budget_details')) {
    add_action( 'taskbot_order_budget_details', 'taskbot_order_budget_details', 10, 2);
    function taskbot_order_budget_details($order_id, $user_type = 'sellers') {
		global $taskbot_settings;
		if ( !class_exists('WooCommerce') ) {
			return;
		}

		$commission_text            =  !empty($taskbot_settings['commission_text']) ? $taskbot_settings['commission_text'] : esc_html__('Processing fee', 'taskbot');

		$order              = !empty($order_id) ? wc_get_order( $order_id ) : array();
		$order_price		= !empty($order_id) ? taskbot_order_price($order_id) : 0;

		$order_meta         = get_post_meta( $order_id, 'cus_woo_product_data', true );
		$order_meta         = !empty($order_meta) ? $order_meta : array();
		$processing_fee		= !empty($order_meta['processing_fee']) ? $order_meta['processing_fee'] : 0.0;

		ob_start();?>
			<div class="tb-asideholder tb-taskdeadline">
				<?php if(!empty($order_price)){?>
				<div class="tb-asidebox tb-additonoltitleholder">
					<div data-bs-toggle="collapse" data-bs-target="#tb-additionolinfov2" aria-expanded="true" role="button">
						<div class="tb-additonoltitle">
							<div class="tb-startingprice">
								<i><?php esc_html_e('Total task budget', 'taskbot');?></i>
								<span>
									<?php 
										if(function_exists('wmc_revert_price')){
											taskbot_price_format(wmc_revert_price($order_price,$order->get_currency()));
										} else {
											taskbot_price_format($order_price);   
										}
									?>
							</span>
							</div>
							<i class="icon-chevron-down"></i>
						</div>
					</div>
				</div>
				<?php }?>
				<div id="tb-additionolinfov2" class="show">
					<div class="tb-budgetlist">
						<?php if(!empty($order)){?>
							<ul class="tb-planslist">
								<?php
								// Get and Loop Over Order Items
								foreach ( $order->get_items() as $item_id => $item ) { ?>
									<li>
										<h6>
											<?php echo esc_html($item->get_name());?>
											<span>
												(<?php 
													if(function_exists('wmc_revert_price')){
														taskbot_price_format(wmc_revert_price($item->get_subtotal(),$order->get_currency()));
													} else {
														taskbot_price_format($item->get_subtotal());   
													}
												?>)  
											</span>
										</h6>
									</li>
								<?php }?>
							</ul>
						<?php }?>
						<?php if(!empty($user_type) && $user_type == 'buyers' &&( !empty($order->get_total_tax()) || !empty($processing_fee) )){?>
							<ul class="tb-planslist tb-texesfee">
								<?php if(!empty($order->get_total_tax())){?>
									<li>
										<a href="javascript:void(0);">
											<h6><?php esc_html_e('Taxes & fees', 'taskbot');?> <span>(<?php echo esc_html(taskbot_price_format($order->get_total_tax()));?>) </span></h6>
										</a>
									</li>
								<?php }?>
								<?php if(!empty($processing_fee)){?>
									<li>
										<a href="javascript:void(0);">
											<h6><?php echo esc_attr($commission_text);?> <span>(<?php echo esc_html(taskbot_price_format($processing_fee));?>) </span></h6>
										</a>
									</li>
								<?php }?>
							</ul>
						<?php }?>
						<ul class="tb-planslist tb-totalfee">
							<li>
								<a href="javascript:void(0);">
									<h6>
										<?php esc_html_e('Total task budget', 'taskbot');?>:&nbsp;
										<span>
											(<?php 
												if(function_exists('wmc_revert_price')){
													taskbot_price_format(wmc_revert_price(taskbot_order_price($order_id),$order->get_currency()));
												} else {
													taskbot_price_format(taskbot_order_price($order_id));   
												}
											?>) 
										</span>
									</h6>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<?php
		echo ob_get_clean();
    }

}


/**
 * Refund request reply
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_submit_dispute_reply')) {

    function taskbot_submit_dispute_reply() {
        global $current_user,$woocommerce,$taskbot_settings;

        $json 		= array();
		$do_check	= check_ajax_referer('ajax_nonce', 'security', false);
		if( function_exists('taskbot_is_demo_site') ) { 
			taskbot_is_demo_site();
		}
		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Oops!', 'taskbot');
			$json['message_desc'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
			wp_send_json( $json );
		}

		if ( !class_exists('WooCommerce') ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Uh!', 'taskbot');
			$json['message_desc'] = esc_html__('WooCommerce plugin needs to be installed.', 'taskbot');
			wp_send_json( $json );
		}

        $post_data  = !empty($_POST['data']) ?  $_POST['data'] : '';
		parse_str($post_data,$data);
		//$get_user_type	= apply_filters('taskbot_get_user_type', $current_user->ID );
		$fields	= array(
			'dispute_comment'	=> esc_html__('Please add reply comment','taskbot'),
		);

		foreach( $fields as $key => $item ){

			if( empty( $data[$key] ) ){
				$json['type'] 	 = "error";
				$json['message'] = esc_html__('Oops!', 'taskbot');
				$json['message_desc'] = $item;
				wp_send_json( $json );
			}
		}

		taskbot_update_dispute_comments($current_user->ID,$data);
		
    }

    add_action('wp_ajax_taskbot_submit_dispute_reply', 'taskbot_submit_dispute_reply');
}

/**
 * Count custom earning array
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbot_tasks_earnings')) {
    function taskbot_tasks_earnings($post_type = '', $status='any',$meta_array=array())
    {
        $previous_1_month   = date('F 01, Y');
        $previous_2_month   = date('F d, Y');
        $end_day    = date('d');
        $day_keys   = '';
        $day_values = array();
        for($i=1;$i<=$end_day;$i++){
            $day_keys       = !empty($day_keys) ? $day_keys.','.$i : $i;

            $day_values[$i]	= 0;
        }

		$args = array(
			'post_type'         => $post_type,
			'posts_per_page'    => -1,
			'post_status'       => $status,
			'date_query' => array(
				array(
					'after'     => $previous_1_month,
					'before'    => $previous_2_month,
					'inclusive' => true,
				),
			),
		);

		if (!empty($meta_array)) {
			foreach ($meta_array as $meta) {
				$args['meta_query'][]  = $meta;
			}
		}

		$day_amount     = 0;
		$taskbot_posts = get_posts( $args );
		if( !empty($taskbot_posts) ){
			foreach($taskbot_posts as $post ){
				$date_completed = get_post_meta( $post->ID, '_date_completed', true );
				$date_completed = !empty($date_completed) ? intval($date_completed) : 0;
				$date_val		= !empty($date_completed) ? date('j',$date_completed) : 0;

				if( !empty($date_val) ){
					$day_amount		= $day_values[$date_val];
					$seller_shares 	= get_post_meta( $post->ID, 'seller_shares', true );
					$seller_shares 	= !empty($seller_shares) ? ($seller_shares) : 0;
					$day_amount		= $day_amount+$seller_shares;
					$day_values[$date_val]	= $day_amount;
				}

			}
		}

		$day_values = implode(",", $day_values);
		return array(
			'key'		=> $day_keys,
			'values'	=> $day_values
		);

    }
}

/**
 * @init            Bulk import Users
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 */
if (!function_exists('taskbot_import_users_template')) {
	function  taskbot_import_users_template(){
		$permalink = add_query_arg(
			array(
				'&type=file',
			)
		);

		//Import users via file
		if ( !empty( $_FILES['users_csv']['tmp_name'] ) ) {
			$import_user	= new TaskbotImportUser();
			$import_user->taskbot_import_user();
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e('User imported successfully','taskbot');?></p>
			</div>
			<?php
		}
	   ?>
       <h3 class="theme-name"><?php esc_html_e('Import sellers/buyers','taskbot');?></h3>
       <div id="import-users" class="import-users">
            <div class="theme-screenshot">
                <img alt="<?php esc_attr_e('Import Users','taskbot');?>" src="<?php echo esc_url(taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/users.jpg'));?>">
            </div>
			<h3 class="theme-name"><?php esc_html_e('Import users','taskbot');?></h3>
            <div class="user-actions">
                <a href="javascript:void(0);"  class="button button-primary doc-import-users"><?php esc_html_e('Import dummy','taskbot');?></a>
            </div>
	   </div>
       <div id="import-users" class="import-users custom-import" style="display:none;">
            <form method="post" action="<?php echo taskbot_prepare_final_url('file','import_users'); ?>"  enctype="multipart/form-data">
				<div class="theme-screenshot">
					<img alt="<?php esc_attr_e('Import users','taskbot');?>" src="<?php echo esc_url(taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/excel.jpg'));?>">
				</div>
				<h3 class="theme-name">
					<input id="upload-dummy-csv" type="file" name="users_csv" >
					<label for="upload-dummy-csv" class="button button-primary upload-dummy-csv"><?php esc_html_e('Choose file','taskbot');?></lable>
				</h3>
				<div class="user-actions">
					<input type="submit" class="button button-primary" value="<?php esc_attr_e('Import from file','taskbot');?>">
				</div>
            </form>
		</div>
        <?php
	}
}

/**
 * @init            tab url
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_prepare_final_url')) {
    function taskbot_prepare_final_url($tab='',$page='import_users') {
		$permalink = '';
		$permalink = add_query_arg(
			array(
				'?page'	=>   urlencode( $page ) ,
				'tab'	=>   urlencode( $tab ) ,
			)
		);
		return esc_url( $permalink );
	}
}

/**
 * @init            Import user
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 */
if (!function_exists('taskbot_import_users')) {
	function  taskbot_import_users(){
		$import_user	= new TaskbotImportUser();
		$import_user->taskbot_import_user();
		//security check
		$do_check = check_ajax_referer('ajax_nonce', 'security', false);

		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
			wp_send_json( $json );
		}
		if (function_exists('taskbot_migration_buyer')) {
			taskbot_migration_buyer();
		}
		if (function_exists('taskbot_migration_seller_packages')) {
			taskbot_migration_seller_packages();
		}
		
		if (function_exists('taskbot_migration_projects')) {
			taskbot_migration_projects();
		}

		if (function_exists('taskbot_migration_proposals')) {
			taskbot_migration_proposals();
		}
		
		$json				= array();
		$json['type']		= 'success';
		$json['message']	= esc_html__('Users have been imported successfully','taskbot' );
		echo json_encode( $json );
		die;
	}
	add_action('wp_ajax_taskbot_import_users', 'taskbot_import_users');
}

/**
 * @init            Import user
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 */
if (!function_exists('taskbot_generate_profile')) {
	function  taskbot_generate_profile(){
		//security check
		$do_check 	= check_ajax_referer('ajax_nonce', 'security', false);
		$user_id	= !empty($_POST['user_id'] ) ? $_POST['user_id'] : 0;
		$type		= !empty($_POST['type'] ) ? $_POST['type'] : 0;

		if ( empty($user_id) ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('User ID is required', 'taskbot');
			wp_send_json( $json );
		}

		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
			wp_send_json( $json );
		}

		$user_meta	= get_userdata($user_id);
		
		$display_name	= $user_meta->first_name.' '.$user_meta->last_name;

		if( empty( $user_meta->first_name ) && empty($user_meta->last_name) ){
			$display_name   = $user_meta->display_name;
		}

		if( empty( $display_name ) ){
			$display_name   = $user_meta->user_login;
		}

		$tb_post_meta                   = array();
		$tb_post_meta['tagline']	    = '';
		$tb_post_meta['first_name']	    = !empty( $user_meta->first_name ) ? $user_meta->first_name : '';
		$tb_post_meta['last_name']	    = !empty( $user_meta->last_name ) ? $user_meta->last_name : '';
		
		if(!empty($type) && $type == 'sellers'){
			$user_post = array(
				'post_title'    => wp_strip_all_tags($display_name),
				'post_status'   => 'publish',
				'post_author'   => $user_id,
				'post_type'     => 'sellers',
			);

			$profile_sellers = wp_insert_post($user_post);

			update_user_meta($user_id, '_linked_profile', $profile_sellers);
			update_post_meta($profile_sellers, '_linked_profile', $user_id);
			update_post_meta($profile_sellers, 'tb_post_meta', $tb_post_meta);
			update_post_meta($profile_sellers, '_is_verified', 'yes');
		}else if(!empty($type) && $type == 'buyers'){
			$buyer_post = array(
				'post_title'    => wp_strip_all_tags($display_name),
				'post_status'   => 'publish',
				'post_author'   =>  $user_id,
				'post_type'     => 'buyers',
			);

			$buyers_id = wp_insert_post($buyer_post);
			update_user_meta($user_id, '_linked_profile_buyer', $buyers_id);
			update_post_meta($buyers_id, 'tb_post_meta', $tb_post_meta);
			update_post_meta($buyers_id, '_linked_profile', $user_id);
			update_post_meta($buyers_id, '_is_verified', 'yes');
		}

		$json				= array();
		$json['type']		= 'success';
		$json['message']	= esc_html__('Profile has been created and links to that user','taskbot' );
		wp_send_json( $json );
	}
	add_action('wp_ajax_taskbot_generate_profile', 'taskbot_generate_profile');
}

/**
 * @init            Add class on body
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_custom_body_classes')) {
	add_filter( 'body_class', 'taskbot_custom_body_classes',5,1 );
	function taskbot_custom_body_classes( $classes ) {
		global $current_user,$taskbot_settings;
		
		if( is_page_template( 'templates/dashboard.php') || is_page_template( 'templates/add-task.php') || is_page_template( 'templates/add-project.php') || is_page_template( 'templates/add-offer.php') ) {
			$classes[] = 'et-offsidebar';
		}

		if (is_user_logged_in()) {
			$classes[] = 'tb-user-logged-in';
			$user_type	= taskbot_get_user_type($current_user->ID);
				if( !empty($user_type) && $user_type === 'sellers' ){
					$classes[] = 'tb-user-logged-sellers';
				} else if( !empty($user_type) && $user_type === 'buyers' ){
					$classes[] = 'tb-user-logged-buyers';
				}
		}else{
			$classes[] = 'tb-user-logged-off';
		}

		return $classes;
	}
}

/**
 * @init            retunr user avatar
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('wpguppy_user_profile_avatar')) {
	add_filter('get_avatar_url','wpguppy_user_profile_avatar',10,3);
	function wpguppy_user_profile_avatar($avatar = '', $id_or_email='', $args=array()){
		if(!empty($id_or_email) && is_numeric($id_or_email)){
			$user_type		= taskbot_get_user_type($id_or_email);
			$link_id		= taskbot_get_linked_profile_id( $id_or_email );
			if( !empty($user_type) &&( $user_type ==='sellers' || $user_type === 'buyers' ) ){
				$avatar  = apply_filters(
					'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $link_id), array('width' => 100, 'height' => 100)
				);
			}
		}

		return $avatar;
	}
}

/**
 * @init            Get user avatar
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_user_profile_avatar')) {
	add_filter('get_avatar','taskbot_user_profile_avatar',10,5);
	function taskbot_user_profile_avatar($avatar = '', $id_or_email='', $size = 60, $default = '', $alt = false ){
		if ( is_numeric( $id_or_email ) ) {
			$user_id = (int) $id_or_email;
		}elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ){
			$user_id = $user->ID;
		}elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ){
			$user_id = (int) $id_or_email->user_id;
		}

		if ( empty( $user_id ) ){return $avatar;}

		$user_type	= taskbot_get_user_type($user_id);

		if( !empty($user_type) &&( $user_type ==='sellers' || $user_type === 'buyers' ) ){
			$profile_id	= taskbot_get_linked_profile_id($user_id);
			$height		= $size;
			$width		= $size;
			$local_avatars    	= apply_filters(
				'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => $width, 'height' => $height), $profile_id), array('width' => $width, 'height' => $height)
			);
		}

		if ( empty( $local_avatars ) ){
			return $avatar;
		}

		$size = (int) $size;

		if ( empty( $alt ) ){
			$alt = get_the_author_meta( 'display_name', $user_id );
		}

		$avatar       = "<img alt='" . esc_attr( $alt ) . "' src='" . esc_url( $local_avatars ) . "' class='avatar photo' width='".esc_attr( $size )."' height='".esc_attr( $size )."'  />";

		return $avatar;
		
	}
}

/**
 * @init            Site demo content
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_is_demo_site')) {
	function taskbot_is_demo_site($message=''){
		$json = array();
		$message	= !empty( $message ) ? $message : esc_html__("Sorry! you are restricted to perform this action on demo site.",'taskbot' );

		if( isset( $_SERVER["SERVER_NAME"] ) 
			&& $_SERVER["SERVER_NAME"] == 'wp-guppy.com' ){
				$json['type']	    	= "error";
				$json['message']		= esc_html__('Restricted access','taskbot');
				$json['message_desc'] 	= $message;
				wp_send_json( $json );
		}
	}
}

/**
 * @init            Verification
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_verified_user')) {
	function taskbot_verified_user(){
		global $current_user,$taskbot_settings;
		$json 					= array();
		$user_update_option		= !empty($taskbot_settings['user_update_option']) ? $taskbot_settings['user_update_option'] : false;
		$identity_verification	= !empty($taskbot_settings['identity_verification']) ? $taskbot_settings['identity_verification'] : false;

		if( empty($user_update_option) ){
			$identity_verified		= get_user_meta($current_user->ID,'_is_verified',true);
			$identity_verified		= !empty($identity_verified) ? $identity_verified : '';
			
			if( empty($identity_verified) || $identity_verified !='yes' ){
				$json['type']	    	= "error";
				$json['message']		= esc_html__('Email verification required','taskbot');
				$json['message_desc'] 	= esc_html__('Your email is not verified, please contact to administrator for the verification.','taskbot');

				if (!empty($taskbot_settings['email_user_registration']) && $taskbot_settings['email_user_registration'] == 'verify_by_link') {
					$button					= array();
					$button['option']	    = "yes";
					$button['buttonclass']	= "re-send-email btn-orange";
					$button['btntext']	    = esc_html__("Resend email",'taskbot');
					$button['redirect']	    = 'javascript:;';
					$json['button'] 		= $button;
					$json['message_desc'] 	= esc_html__('Your email is not verified, please verify your email to perform any action on the site. You can click button to get a verification link','taskbot');
				}

				wp_send_json( $json );
			}
		}

		if( !empty($identity_verification) && empty($user_update_option) ){
			$identity_verified			= get_user_meta($current_user->ID,'identity_verified',true);
			$identity_verified			= !empty($identity_verified) ? $identity_verified : 0;
			$verification_attachments  	= get_user_meta($current_user->ID, 'verification_attachments', true);
			$verification_attachments	= !empty($verification_attachments) ? $verification_attachments : array();
			if( empty($identity_verified) ){
				$json['type']	    		= "error";
				if(!empty($verification_attachments) ){
					$json['message_desc'] 	= esc_html__('You have successfully submitted your documents. buckle up, we will verify and respond to your request very soon.','taskbot');
				} else {
					$button					= array();
					$button['button']	    = "yes";
					$button['buttonclass']	= "btn-green";
					$button['btntext']	    = esc_html__("Let's verify account",'taskbot');
					$button['redirect']	    = Taskbot_Profile_Menu::taskbot_profile_menu_link('dashboard', $current_user->ID, true, 'verification');
					$json['button'] 		= $button;
					$json['message_desc'] 	= esc_html__('You must verify your identity, please submit the required documents to get verified.','taskbot');
				}
				
				$json['message']		= esc_html__('Verification required','taskbot');
				wp_send_json( $json );
			}
		}
	}
}

/**
 * return pending listings
 *
 * @return
 * @throws error
 */
if(!function_exists('taskbot_allow_pending_listings') ) {
	function taskbot_allow_pending_listings($query) {
        $post_type	= $query->get( 'post_type' );
		if( $query->is_main_query() && $query->is_singular() ){
			if( !empty($post_type) && $post_type === 'product' ){
				$query->set('post_status', array('draft','pending','publish','rejected','refunded','completed','hired','cancelled'));
			} else if( !empty($post_type) && $post_type === 'offers' ){
				$query->set('post_status', array('draft','pending','publish','rejected','refunded','completed','hired','cancelled'));
			}
        }
	}
	add_action('pre_get_posts','taskbot_allow_pending_listings');
}


/**
 * Product post author support
 *
 * @return
 * @throws error
 */
if(!function_exists('taskbot_author_support_to_posts') ) {
	function taskbot_author_support_to_posts() {
		if (post_type_exists('product'))
		{
			add_post_type_support( 'product', 'author' ); 
		}
	}
	add_action( 'init', 'taskbot_author_support_to_posts', 999 );
}

/**
 * Count custom post type status
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbot_post_count')) {
	add_filter( 'taskbot_post_count', 'taskbot_post_count',10,3 );
    function taskbot_post_count($post_type = '', $status='any',$meta_data=array())
    {
        $args = array(
            'post_type' 		=> $post_type,
            'post_status' 		=> $status,
            'posts_per_page' 	=> -1,
        );
        if( !empty($meta_data) ){
            foreach($meta_data as $key => $val ){
                $args['meta_query'][] = array(
                    'key'       => $key,
                    'value'     => $val,
                    'compare' 	=> '=',
                );
            }
        }
        $taskbot_posts  = get_posts( $args );
        $taskbot_posts  = !empty($taskbot_posts) && is_array($taskbot_posts) ? count($taskbot_posts) : 0;
        return $taskbot_posts;
      
    }
}

/**
 * Count tatal proposals
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbot_count_proposals')) {
	add_action( 'taskbot_count_proposals', 'taskbot_count_proposals',10,3 );
    function taskbot_count_proposals($post_type = '', $status='any',$meta_data=array())
    {
        $args = array(
            'post_type' 		=> $post_type,
            'post_status' 		=> $status,
            'posts_per_page' 	=> -1,
        );

        if( !empty($meta_data) ){
            foreach($meta_data as $key => $val ){
                $args['meta_query'][] = array(
                    'key'       => $key,
                    'value'     => $val,
                    'compare' 	=> '=',
                );
            }
        }

        $taskbot_posts  = get_posts( $args );
        $taskbot_posts  = !empty($taskbot_posts) && is_array($taskbot_posts) ? count($taskbot_posts) : 0;
		?>
		<li>
			<i class="icon-file-text accountsicon"></i>
			<div class="tk-project-requirement_content">
				<div class="tk-requirement-tags">
					<span><?php echo esc_html(sprintf("%02d", $taskbot_posts));?></span>
				</div>
				<em><?php esc_html_e('Application received', 'taskbot');?></em>
			</div>
		</li>
		<?php
      
    }
}

/**
 * Hide activity comments on admin listing
 *
 * @return
 * @throws error
 */
if(!function_exists('taskbot_hide_comments_by_type') ) {
	function taskbot_hide_comments_by_type($query) {
		if ( is_admin() && ($query->query_vars['type'] !== 'activity_detail' || $query->query_vars['type'] !== 'dispute_activities') ) {
			$query->query_vars['type__not_in'] = array_merge(
				(array) $query->query_vars['type__not_in'],
				array('activity_detail','dispute_activities')
			);
		 }
	}
	add_action( 'pre_get_comments', 'taskbot_hide_comments_by_type' );
}

/**
 * search type
 * @return slug
 */
if (!function_exists('taskbot_search_list_type')) {
	function taskbot_search_list_type(){
		$list	= array(
			'sellers_search_page'		=> esc_html__('Sellers','taskbot'),
			'service_search_page'		=> esc_html__('Services','taskbot'),
			'project_search_page'		=> esc_html__('Projects','taskbot')
		);
		$list	= apply_filters('taskbot_filter_search_list_type', $list );
		return $list;
	}    
}

/**
 * Wp guppy add images
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'wpguppy_get_post_image' ) ) {
	add_filter('wpguppy_get_post_image','wpguppy_get_post_image',10,1);
    function wpguppy_get_post_image( $postId=0 ) {
		global $current_user;
		if( !empty($postId) ){
			$post_type	= get_post_type( $postId );
			if( !empty($post_type) && $post_type === 'proposals'){
				$user_type	= taskbot_get_user_type($current_user->ID);
				if( !empty($user_type) && $user_type === 'sellers' ){
					$project_id		= get_post_meta( $postId, 'project_id', true );
					$post_author	= !empty($project_id) ? get_post_field('post_author', $project_id ) : 0;
					$profile_id		= taskbot_get_linked_profile_id($post_author,'','buyers');
					$avatar         = apply_filters(
						'taskbot_avatar_fallback',
						taskbot_get_user_avatar(array('width' => 80, 'height' => 80), $profile_id),
						array('width' => 80, 'height' => 80)
					);
					return $avatar;
				} else if( !empty($user_type) && $user_type === 'buyers' ){
					$post_author	= get_post_field('post_author', $postId );
					$profile_id		= taskbot_get_linked_profile_id($post_author,'','sellers');
					$avatar         = apply_filters(
						'taskbot_avatar_fallback',
						taskbot_get_user_avatar(array('width' => 80, 'height' => 80), $profile_id),
						array('width' => 80, 'height' => 80)
					);
					return $avatar;
				}
			}
		}
    }
}