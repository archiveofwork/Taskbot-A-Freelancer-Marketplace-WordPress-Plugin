<?php
/**
 * Provide a public-facing ajax hooks
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public/partials
 */

 /**
 * Download invoice
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('tasbkot_download_invoice')) {
    function tasbkot_download_invoice()
    {
        global $current_user;
        $json = array();
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }
        $order_id           = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $user_type          = !empty($current_user->ID) ? apply_filters('taskbot_get_user_type', $current_user->ID ) : '';
        $invoice_option     = TaskbotBuyerServicePDF($order_id,$current_user->ID,$user_type);
        $file_path          = !empty($invoice_option['file_path']) ? $invoice_option['file_path'] : '';
        $file_url           = !empty($invoice_option['file_url']) ? $invoice_option['file_url'] : '';
        
        $json['type']           = 'success';
        $json['message']        = esc_html__('Invoice', 'taskbot');
        $json['file_name']      = (base64_encode($file_url));
        $json['file_path']      = (base64_encode($file_path));
        $json['message_desc']   = esc_html__('You have successfully download invoice.', 'taskbot');
        wp_send_json($json);
    }
    add_action( 'wp_ajax_tasbkot_download_invoice', 'tasbkot_download_invoice' );
}


 /**
 * Remove invoice
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_remove_invoice')) {
    function taskbot_remove_invoice(){
       
        $json               = array();
        $invoce_option      = !empty($_POST['file_path']) ? $_POST['file_path'] : '';
        if( !empty($invoce_option) ){
            $file_url   = base64_decode(($invoce_option));
            wp_delete_file( $file_url );
        }
    }

    add_action('wp_ajax_taskbot_remove_invoice', 'taskbot_remove_invoice');
}

/**
 * Redirect page
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_redirect_page')) {
    function taskbot_redirect_page()
    {
        global  $taskbot_settings;
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            $hide_registration  = !empty($taskbot_settings['hide_registration']) ? $taskbot_settings['hide_registration'] : 'no';
            $type               = !empty($_POST['type']) ? $_POST['type'] : '';
            $json['message']    = esc_html__('Hire for a task', 'taskbot');

            if( !empty($type) ){
                $json['message_desc']       = esc_html__('You must logged in to perfom this action.', 'taskbot');
                session_start();
                $json['redirect']           = taskbot_get_page_uri('login');

                if(!empty($type) && $type == 'post_task'){
                    $_SESSION["redirect_type"]  = 'post_task';
                    $_SESSION["redirect_url"]   = taskbot_get_page_uri('registration');
                    $json['redirect']           = taskbot_get_page_uri('registration');
                } else if(!empty($type) && $type == 'task_cart'){
                    $page_url                   = !empty($_POST['page_url']) ? $_POST['page_url'] : '';
                    $_SESSION["redirect_type"]  = 'task_cart';
                    $_SESSION["redirect_url"]   = $page_url;
                } else if(!empty($type) && $type == 'task'){
                    $page_url                   = !empty($_POST['page_url']) ? $_POST['page_url'] : '';
                    $_SESSION["redirect_type"]  = 'task_cart';
                    $_SESSION["redirect_url"]   = $page_url;
                    $json['redirect']           = taskbot_get_page_uri('login');
                    $json['message']            = '';
                    $json['message_desc']       = esc_html__('You must login as a buyer to send a message to this seller.', 'taskbot');
                }
                if( !empty($hide_registration) && $hide_registration == 'yes' ){
                    $json['redirect']           = taskbot_get_page_uri('login');
                }
                $json['type'] 		        = 'success';
            } else {
                $json['type']           = 'error';
                $json['message_desc']   = esc_html__('Oops! you are not allowed to perfom this action', 'taskbot');
            }

            wp_send_json($json);
    }
    add_action( 'wp_ajax_taskbot_redirect_page', 'taskbot_redirect_page' );
    add_action( 'wp_ajax_nopriv_taskbot_redirect_page', 'taskbot_redirect_page' );
}


/**
 * Change password
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_change_password')) {
    function taskbot_change_password()
    {
        if( function_exists('taskbot_is_demo_site') ) { 
          taskbot_is_demo_site();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $profile_data       = !empty($_POST['data']) ? $_POST['data'] : array();
        $validation_fields  = array(
            'password'          => esc_html__('Current password is required.','taskbot'),
            'new_password'      => esc_html__('New password is required.','taskbot'),
            'retype_password'   => esc_html__('Retype password is required.','taskbot'),
        );
        $json               = array();
        $json['type']       = 'error';
        $json['message'] 	  = esc_html__('Change Password', 'taskbot');

        parse_str($profile_data,$profile_data);
        foreach($validation_fields as $key => $validation_field ){
            if( empty($profile_data[$key]) ){
                $json['message_desc'] 		= $validation_field;
                wp_send_json($json);
            }
        }

        $password		    =  !empty($profile_data['password']) ? $profile_data['password'] : '';
        $new_password	    =  !empty($profile_data['new_password']) ? ( $profile_data['new_password'] ) : '';
        $retype_password    =  !empty($profile_data['retype_password']) ? ( $profile_data['retype_password'] ) : '';

        if($retype_password != $new_password ) {
            $json['message_desc']   = esc_html__('Your passwords do not match', 'taskbot');
            wp_send_json($json);
        }

        do_action( 'taskbot_strong_password_validation', $new_password );
        $user           = wp_get_current_user();
        $is_password    = wp_check_password($password, $user->data->user_pass, $user->ID);

        if ($is_password) {
            $notification_title = esc_html__('Password changed.', 'taskbot');
            taskbot_set_notification_data('', $notification_title, 'notifications');
            wp_update_user(array('ID' => $user->ID, 'user_pass' => sanitize_text_field($new_password)));
            $json['type']           = 'success';
            $json['message_desc']   = esc_html__('Your password is updated.', 'taskbot');
            wp_send_json($json);
        }  else {
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('Oops! Looks like your old password is not valid', 'taskbot');
            wp_send_json($json);
        }

    }
    add_action( 'wp_ajax_taskbot_change_password', 'taskbot_change_password' );
}

/**
 * Save account settings
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_send_message')) {
    function taskbot_send_message()
    {
        global $current_user;
        
        if( function_exists('taskbot_is_demo_site') ) { 
          taskbot_is_demo_site();
        }
        
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        $json               = array();
        $user_type          = !empty($current_user->ID) ? apply_filters('taskbot_get_user_type', $current_user->ID ) : '';
        $post_id            = !empty($_POST['post_id']) ? intval($_POST['post_id']): '';
        $user_name          = taskbot_get_username($post_id);
        $user_name          = !empty($user_name) ? $user_name : '';
        $json['message']    = sprintf(esc_html__('Send a message to “%s“', 'taskbot'),$user_name);

        if( !empty($user_type) && $user_type === 'buyers' ){
            $receiverId     = !empty($post_id) ? taskbot_get_linked_profile_id($post_id,'post') : 0;
            $message        = !empty($_POST['message']) ?  sanitize_textarea_field($_POST['message']): '';
           
            if( empty($message)){
                $json['type']           = 'error';
                $json['message_desc']   = esc_html__('Message is required.', 'taskbot');
                wp_send_json( $json );
            } else {

                do_action('wpguppy_send_message_to_user',$current_user->ID,$receiverId,$message);

                $inbox_url	= Taskbot_Profile_Menu::taskbot_profile_menu_link('inbox', $current_user->ID, true, '');

                $inbox_url	= add_query_arg(
                    array(
                        'chat_type'	=> 1,
                        'chat_id'	=> $receiverId.'_'.'1',
                        'type'	    => 'messanger',
                    ),
                    $inbox_url
                );

                $json['type']           = 'success';
                $json['redirect']       = $inbox_url;
                $json['message_desc']   = esc_html__('Woohoo! your message has been sent successfully', 'taskbot');
                wp_send_json( $json );
            }
        } else {
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('We"re sorry, but only buyers can send a message to the seller.', 'taskbot');
            wp_send_json( $json );
        }

    }
    add_action( 'wp_ajax_taskbot_send_message', 'taskbot_send_message' );
}

/**
 * Proposal start chat
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('wp_guppy_start_chat')) {
    function wp_guppy_start_chat()
    {
        global $current_user;
        
        if( function_exists('taskbot_is_demo_site') ) { 
          taskbot_is_demo_site();
        }
        
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        $json               = array();
        $user_type          = !empty($current_user->ID) ? apply_filters('taskbot_get_user_type', $current_user->ID ) : '';
        $receiverId            = !empty($_POST['post_id']) ? intval($_POST['post_id']): '';

        if( !empty($user_type) && $user_type === 'buyers' ){
            do_action('wpguppy_send_message_to_user',$current_user->ID,$receiverId,'');

            $inbox_url	= Taskbot_Profile_Menu::taskbot_profile_menu_link('inbox', $current_user->ID, true, '');

            $inbox_url	= add_query_arg(
                array(
                    'chat_type'	=> 1,
                    'chat_id'	=> $receiverId.'_'.'1',
                    'type'	    => 'messanger',
                ),
                $inbox_url
            );

            $json['type']           = 'success';
            $json['redirect']       = $inbox_url;
            $json['message_desc']   = esc_html__('Woohoo! your message has been sent successfully', 'taskbot');
            wp_send_json( $json );
            
        } else {
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('We"re sorry, but only buyers can send a message to the seller.', 'taskbot');
            wp_send_json( $json );
        }

    }
    add_action( 'wp_ajax_wp_guppy_start_chat', 'wp_guppy_start_chat' );
}

/**
 * Save account settings
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_send_user_msg')) {
    function taskbot_send_user_msg()
    {
        global $current_user;
        
        if( function_exists('taskbot_is_demo_site') ) { 
          taskbot_is_demo_site();
        }
        
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        $json               = array();
        $user_type          = !empty($current_user->ID) ? apply_filters('taskbot_get_user_type', $current_user->ID ) : '';
        $receiverId         = !empty($_POST['reciver_id']) ? intval($_POST['reciver_id']): '';
        $json['message']    = esc_html__('Send a message', 'taskbot');
        $message            = !empty($_POST['message']) ?  sanitize_textarea_field($_POST['message']): '';
        
        if( empty($message)){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('Message is required.', 'taskbot');
            wp_send_json( $json );
        } else {
            do_action('wpguppy_send_message_to_user',$current_user->ID,$receiverId,$message);

            $inbox_url	= Taskbot_Profile_Menu::taskbot_profile_menu_link('inbox', $current_user->ID, true, '');

            $inbox_url	= add_query_arg(
                array(
                    'chat_type'	=> 1,
                    'chat_id'	=> $receiverId.'_'.'1',
                    'type'	    => 'messanger',
                ),
                $inbox_url
            );

            $json['type']           = 'success';
            $json['redirect']       = $inbox_url;
            $json['message_desc']   = esc_html__('Woohoo! your message has been sent successfully', 'taskbot');
            wp_send_json( $json );
        }

    }
    add_action( 'wp_ajax_taskbot_send_user_msg', 'taskbot_send_user_msg' );
}
/**
 * Save account settings
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_save_account_settings')) {
    function taskbot_save_account_settings()
    {
        global $current_user;
        
        if( function_exists('taskbot_is_demo_site') ) { 
          taskbot_is_demo_site();
        }
        
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $profile_data       = !empty($_POST['data']) ? $_POST['data']: array();
        parse_str($profile_data,$profile_data);
        $user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
        $settings       = taskbot_get_account_settings($user_type);
        $linked_profile = taskbot_get_linked_profile_id($current_user->ID,'',$user_type);

        if( !empty( $settings ) ){
            foreach( $settings as $key => $value ){
                $save_val = !empty( $profile_data['settings'][$key] ) ? $profile_data['settings'][$key] : '';
                $db_val 	= !empty( $save_val ) ?  $save_val : 'off';
                update_post_meta($linked_profile, $key, $db_val);
            }
        }

        $json['type']           = 'success';
        $json['message']        = esc_html__('Privacy settings', 'taskbot');
        $json['message_desc']   = esc_html__('Settings are updated successfully.', 'taskbot');
        wp_send_json( $json );

    }
    add_action( 'wp_ajax_taskbot_save_account_settings', 'taskbot_save_account_settings' );
}

/**
 * Switch user account
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_switch_user_settings')) {
    function taskbot_switch_user_settings()
    {
        global $current_user,$taskbot_settings;

        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $json           = array();
        $switch_user    = !empty($taskbot_settings['switch_user']) ? $taskbot_settings['switch_user'] : false;
        
        if( empty($switch_user) ){
            $json['type']           = 'error';
            $json['message']        = esc_html__('Switch user', 'taskbot');
            $json['message_desc']   = esc_html__('Switch user options is disabled.', 'taskbot');
            wp_send_json( $json );
        }

        
        $user_id    = !empty($_POST['id']) ? intval($_POST['id']): 0;
        taskbotSwitchUser($user_id);
        
    }
    add_action( 'wp_ajax_taskbot_switch_user_settings', 'taskbot_switch_user_settings' );
}

/**
 * Save billing settings
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_save_billing_settings')) {
    function taskbot_save_billing_settings()
    {
        global $taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
          taskbot_is_demo_site();
        }
        
        global $current_user;
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $json         = array();
        $user_id      = !empty($_POST['id']) ? intval($_POST['id']): 0;
        $data         = apply_filters( 'taskbot_billing_fields', '' );
        $profile_data = !empty($_POST['data']) ? $_POST['data']: array();
        parse_str($profile_data,$profile_data);
        $enable_state			= !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
        $list = array(
            'billing_first_name'    => esc_html__('First name is required', 'taskbot'),
            'billing_last_name'    	=> esc_html__('Last name is required', 'taskbot'),
            'billing_address_1'    	=> esc_html__('Address is required', 'taskbot'),
            'billing_country'   	=> esc_html__('Country is required', 'taskbot'),
            'billing_city'    		=> esc_html__('City is required', 'taskbot'),
            'billing_postcode'    	=> esc_html__('Postal code is required', 'taskbot'),
            'billing_phone'    		=> esc_html__('Phone number is required', 'taskbot'),
            'billing_email'    		=> esc_html__('Email address is required', 'taskbot'),
        );

        if (!empty($enable_state)) {
            $list['billing_state'] = esc_html__('State is required', 'taskbot');
        }

        $json['message']        = esc_html__('Billing settings', 'taskbot');
        foreach ($list as $meta_key => $meta_value ) {
            if( empty($profile_data['billing'][$meta_key]) ){
                $json['type'] 		    = 'error';
                $json['message_desc'] = esc_html($meta_value);
                wp_send_json( $json );
            }
        }

        foreach ($profile_data['billing'] as $meta_key => $meta_value ) {
            update_user_meta( $current_user->ID, $meta_key, sanitize_text_field( $meta_value ) );
        }

        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Your billing settings have been updated.', 'taskbot');
        wp_send_json( $json );
    }
    add_action( 'wp_ajax_taskbot_save_billing_settings', 'taskbot_save_billing_settings' );
}

/**
 * Save profile settings
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_save_profile_settings')) {
    function taskbot_save_profile_settings()
    {
        global $current_user,$taskbot_settings;
        $shortname_option  =  !empty($taskbot_settings['shortname_option']) ? $taskbot_settings['shortname_option'] : '';
        $hide_languages       = !empty($taskbot_settings['hide_languages']) ? $taskbot_settings['hide_languages'] : 'no';
        $hide_english_level       = !empty($taskbot_settings['hide_english_level']) ? $taskbot_settings['hide_english_level'] : 'no';

        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $json               = array();
        $user_type		    = apply_filters('taskbot_get_user_type', $current_user->ID );
        $user_id            = !empty($_POST['id']) ? intval($_POST['id']): 0;
        $profile_id         = taskbot_get_linked_profile_id($user_id,'',$user_type);
        $profile_data       = !empty($_POST['data']) ? $_POST['data']: array();
        $enable_state       = !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
        parse_str($profile_data,$profile_data);

        $list = array(
            'first_name'      => esc_html__('First name is required', 'taskbot'),
            'last_name'       => esc_html__('Last name is required', 'taskbot'),
            'country'   	  => esc_html__('Country is required', 'taskbot'),
            'zipcode'    	  => esc_html__('Zip code is required', 'taskbot'),
            'seller_type'     => esc_html__('Seller type is required', 'taskbot'),
            'english_level'   => esc_html__('English level is required', 'taskbot'),
            'hourly_rate'     => esc_html__('Hourly rate is required', 'taskbot'),
        );


        if(!empty($hide_english_level ) && $hide_english_level == 'yes'){unset($list['english_level']);}

        $json['message']        = esc_html__('Profile settings', 'taskbot');
        if(empty($taskbot_settings['enable_zipcode']) ){
            unset($list['zipcode']);
        }
        if( !empty($enable_state) ){
            if( !empty($enable_state) && !empty($profile_data['country']) ){
                if (class_exists('WooCommerce')) {
                    $countries_obj   	= new WC_Countries();
                    $states			 	= $countries_obj->get_states( $profile_data['country'] );
                    if( !empty($states) ){
                        $list['state']   =  esc_html__('State field is required', 'taskbot');
                    }
                }
                
            }
            
        }
        $list   = apply_filters('taskbot_filter_profile_settings',$list);
        
        foreach ($list as $meta_key => $meta_value ) {
            if( empty($profile_data[$meta_key]) ){
                $json['type'] 		    = 'error';
                $json['message_desc'] 	= esc_html($meta_value);
                wp_send_json( $json );
            }
        }

        $first_name     = !empty( $profile_data['first_name'] ) ? sanitize_text_field( $profile_data['first_name'] ) : '';
       	$last_name 	    = !empty( $profile_data['last_name'] ) ? sanitize_text_field( $profile_data['last_name'] ) : '';
        $description 	    = !empty( $profile_data['description'] ) ? esc_textarea( $profile_data['description'] ) : '';
        $tagline        = !empty( $profile_data['tagline'] ) ? sanitize_text_field( $profile_data['tagline'] ) : '';
        $country        = !empty( $profile_data['country'] ) ? sanitize_text_field( $profile_data['country'] ) : '';
       	$zipcode 	    = !empty( $profile_data['zipcode'] ) ? sanitize_text_field( $profile_data['zipcode'] ) : 0;
       	$seller_type 	= !empty( $profile_data['seller_type'] ) ? sanitize_text_field( $profile_data['seller_type'] ) : '';
       	$english_level 	= !empty( $profile_data['english_level'] ) ? sanitize_text_field( $profile_data['english_level'] ) : '';
       	$hourly_rate 	= !empty( $profile_data['hourly_rate'] ) ? sanitize_text_field( $profile_data['hourly_rate'] ) : '';
        $state          = !empty( $profile_data['state'] ) ? sanitize_text_field( $profile_data['state'] ) : '';
        $skills         = !empty($profile_data['skills']) ? ($profile_data['skills']) : array();
        $languages      = !empty($profile_data['languages']) ? ($profile_data['languages']) : array();
        $old_zipcode    = get_post_meta( $profile_id, 'zipcode', true );
        $old_country    = get_post_meta( $profile_id, 'country', true );
        $old_location   = get_post_meta( $profile_id, 'location',true );

        if(empty($taskbot_settings['enable_zipcode']) ){
            update_post_meta($post_id,'longitude',0);
            update_post_meta($post_id,'latitude',0);
        } else if(( empty($old_zipcode) || (!empty($old_zipcode) && $old_zipcode != $zipcode)) ){
            $response   = array();
            $response   = taskbot_process_geocode_info($zipcode,$country);
            if( !empty($response) ) {
                update_post_meta($profile_id,'location', $response );
                update_post_meta($profile_id,'_longitude',$response['lng']);
                update_post_meta($profile_id,'_latitude',$response['lat']);
            }
        }

        /* update seller type term */
        if(isset($seller_type) && $seller_type !=''){
            wp_set_object_terms( $profile_id, intval( $seller_type ), 'tb_seller_type' );
        }

        /* update english level term */
        if(isset($english_level) && $english_level !=''){
          wp_set_object_terms( $profile_id, intval( $english_level ), 'tb_english_level' );
        }

        $tb_post_meta   = get_post_meta( $profile_id,'tb_post_meta',true );
        $tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();
        $full_name      = $first_name.' '.$last_name;
        $post_data      = array();

        if (!empty($shortname_option)) {
            $post_name      = explode(' ', $full_name);
            $first_name_    = !empty($post_name[0]) ? ucfirst($post_name[0]) : '';
            $second_name_   = !empty($post_name[1]) ? ' ' . strtoupper($post_name[1][0]) : '';
            $post_name      = $first_name_ . $second_name_;
        }

        $post_data['post_title']    = $full_name;
        $post_data['post_name']     = $post_name;
        $post_data['ID']            = $profile_id;
        $post_data['post_content']            = $description;

        wp_update_post($post_data);

        $tb_post_meta['first_name'] = $first_name;
        $tb_post_meta['last_name']  = $last_name;
        $tb_post_meta['tagline']    = $tagline;
        $tb_post_meta['description']    = $description;


        update_user_meta( $user_id, 'first_name', $first_name );
        update_user_meta( $user_id, 'last_name', $last_name );
        update_user_meta( $user_id, 'description', $description );
        update_post_meta( $profile_id, 'tb_post_meta', $tb_post_meta );
        update_post_meta( $profile_id, 'country', $country );
        update_post_meta( $profile_id, 'zipcode', $zipcode );
        update_post_meta( $profile_id, 'tb_hourly_rate', $hourly_rate );
        wp_set_post_terms($profile_id,$skills,'skills');
        wp_set_post_terms($profile_id,$languages,'languages');

        if( !empty($enable_state) ){
            update_post_meta( $profile_id, 'state', $state );
        }

        $pre_attachment_id  = get_post_thumbnail_id($profile_id);

        if(!empty($pre_attachment_id)){
            update_post_meta($profile_id,'is_avatar', 1 );
        }else{
            update_post_meta($profile_id,'is_avatar', 0 );
        }

        do_action('taskbot_update_profile_fields', $profile_id, $profile_data);

        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Your profile has been updated', 'taskbot');
        wp_send_json( $json );

    }
    add_action( 'wp_ajax_taskbot_save_profile_settings', 'taskbot_save_profile_settings' );
}

/**
 * Save profile settings
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_save_buyer_settings')) {
    function taskbot_save_buyer_settings()
    {
        global $current_user,$taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
          
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $json               = array();
        $user_type		    = apply_filters('taskbot_get_user_type', $current_user->ID );
        $enable_state		= !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
        $user_id            = !empty($_POST['id']) ? intval($_POST['id']): 0;
        $profile_id         = taskbot_get_linked_profile_id($user_id,'',$user_type);
        $profile_data       = !empty($_POST['data']) ? $_POST['data']: array();
        parse_str($profile_data,$profile_data);
        $list = array(
            'first_name'    => esc_html__('First name is required', 'taskbot'),
            'last_name'    	=> esc_html__('Last name is required', 'taskbot'),
            'country'   	=> esc_html__('Country is required', 'taskbot'),
            'zipcode'    	=> esc_html__('Zip code is required', 'taskbot')
        );

        if(empty($taskbot_settings['enable_zipcode']) ){
            unset($list['zipcode']);
        }
        
        if( !empty($enable_state) ){
            if( !empty($enable_state) && !empty($profile_data['country']) ){
                if (class_exists('WooCommerce')) {
                    $countries_obj   	= new WC_Countries();
                    $states			 	= $countries_obj->get_states( $profile_data['country'] );
                    if( !empty($states) ){
                        $list['state']   =  esc_html__('State field is required', 'taskbot');
                    }
                }
                
            }
            
        }
        $json['message']        = esc_html__('Profile settings', 'taskbot');
        foreach ($list as $meta_key => $meta_value ) {

          if( empty($profile_data[$meta_key]) ){
                $json['type'] 		    = 'error';
                $json['message_desc'] 	= esc_html($meta_value);
                wp_send_json( $json );
          }

        }

        $first_name     = !empty( $profile_data['first_name'] ) ? sanitize_text_field( $profile_data['first_name'] ) : '';
       	$last_name 	    = !empty( $profile_data['last_name'] ) ? sanitize_text_field( $profile_data['last_name'] ) : '';
        $tagline        = !empty( $profile_data['tagline'] ) ? sanitize_text_field( $profile_data['tagline'] ) : '';
        $description    = !empty( $profile_data['description'] ) ? esc_textarea( $profile_data['description'] ) : '';
        $country        = !empty( $profile_data['country'] ) ? sanitize_text_field( $profile_data['country'] ) : '';
       	$zipcode 	    = !empty( $profile_data['zipcode'] ) ? sanitize_text_field( $profile_data['zipcode'] ) : '';
        $state          = !empty( $profile_data['state'] ) ? sanitize_text_field( $profile_data['state'] ) : '';
        $old_zipcode    = get_post_meta( $profile_id, 'zipcode', true );
        $old_country    = get_post_meta( $profile_id, 'country', true );
        $old_location   = get_post_meta( $profile_id, 'location',true );
        

        if(empty($taskbot_settings['enable_zipcode']) ){
            update_post_meta($post_id,'longitude',0);
            update_post_meta($post_id,'latitude',0);
        } else if(( empty($old_zipcode) || (!empty($old_zipcode) && $old_zipcode != $zipcode)) ){
            $response   = array();
            $response   = taskbot_process_geocode_info($zipcode,$country);
            if( !empty($response) ) {
                update_post_meta($profile_id,'location', $response );
                update_post_meta($profile_id,'_longitude',$response['lng']);
                update_post_meta($profile_id,'_latitude',$response['lat']);
            }
        }

        $tb_post_meta             = get_post_meta( $profile_id,'tb_post_meta',true );
        $tb_post_meta             = !empty($tb_post_meta) ? $tb_post_meta : array();
        $full_name 		            = $first_name.' '.$last_name;
        $post_data                = array();
        $post_data['post_title']  = $full_name;
        $post_data['ID']          = $profile_id;
        wp_update_post($post_data);
        $tb_post_meta['first_name'] = $first_name;
        $tb_post_meta['last_name']  = $last_name;
        $tb_post_meta['tagline']    = $tagline;
        $tb_post_meta['description']    = $description;
        update_user_meta( $user_id, 'first_name', $first_name );
        update_user_meta( $user_id, 'last_name', $last_name );
        update_post_meta( $profile_id, 'tb_post_meta', $tb_post_meta );
        update_post_meta( $profile_id, 'country', $country );
        update_post_meta( $profile_id, 'zipcode', $zipcode );
        if( !empty($enable_state) ){
            update_post_meta( $profile_id, 'state', $state );
        }
        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Your profile has been updated', 'taskbot');
        wp_send_json( $json );

    }
    add_action( 'wp_ajax_taskbot_save_buyer_settings', 'taskbot_save_buyer_settings' );
}
/**
 * Deactive account
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_deactive_account')) {
    function taskbot_deactive_account()
    {
        global $current_user,$taskbot_settings;

        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
          
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $profile_data = !empty($_POST['data']) ? $_POST['data']: array();
        parse_str($profile_data,$profile_data);
        $validation_fields  = array(
            'reason'  => esc_html__('Please select deactive account reason.','taskbot'),
            'details' => esc_html__('Please add deactive account setails.','taskbot')
        );
        $json               = array();
        $json['type']       = 'error';
        $json['message'] 	= esc_html__('Deactivate Account','taskbot');
        foreach($validation_fields as $key => $validation_field ){
            if( empty($profile_data[$key]) ){
                $json['message_desc'] 		= $validation_field;
                wp_send_json($json);
            }

            if( !empty($profile_data[$key]) && $profile_data[$key] === 'select_option' ){
                $json['message_desc'] 		= $validation_field;
                wp_send_json($json);
            }

        }  

        $reason             = !empty($profile_data['reason']) ? sanitize_text_field($profile_data['reason']) : '';
        $details             = !empty($profile_data['details']) ? sanitize_textarea_field( $profile_data['details'] ): '';
        
        $user_type		    = apply_filters('taskbot_get_user_type', $current_user->ID );
        $linked_profile	    = taskbot_get_linked_profile_id($current_user->ID,'',$user_type);
        $user_name          = taskbot_get_username($linked_profile);
        update_post_meta( $linked_profile, '_deactive_account',1 );

        if(class_exists('Taskbot_Email_helper')){
            if(class_exists('DeactiveUserAcoount')){
                if( !empty($taskbot_settings['email_admin_deactive_account']) ){
                    $emailData                 = array();
                    $emailData['user_id']      = $current_user->ID;
                    $emailData['user_type']    = $user_type;
                    $emailData['reason']       = $reason;
                    $emailData['details']      = $details;
                    $emailData['user_name']    = $user_name;
                    $emailData['user_email']   = $current_user->user_email;
                    $email_helper              = new DeactiveUserAcoount();
                    $email_helper->deactive_account_email_to_admin($emailData);
                    
                } 
            }
        }
        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Your account is deactivated successfully.', 'taskbot');
        wp_send_json( $json );
    }
    add_action( 'wp_ajax_taskbot_deactive_account', 'taskbot_deactive_account' );
}

/**
 * Active account
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_active_account')) {
    function taskbot_active_account()
    {
        global $current_user;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
          
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }
        
        $user_type		        = apply_filters('taskbot_get_user_type', $current_user->ID );
        $linked_profile	        = taskbot_get_linked_profile_id($current_user->ID,'',$user_type);
        update_post_meta( $linked_profile, '_deactive_account',0 );

        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Your account have been activited successfully.', 'taskbot');
        wp_send_json( $json );
    }
    add_action( 'wp_ajax_taskbot_active_account', 'taskbot_active_account' );
}


/**
 * Profile avatar update
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_update_avatar')) {
    function taskbot_update_avatar()
    {
        global $current_user,$wp_filesystem;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        
        $user_identity    = $current_user->ID;
        $linked_profile	  = taskbot_get_linked_profile_id($current_user->ID);
        $uploadspath	  = wp_upload_dir();
        $upload_dir       = $uploadspath['basedir'].'/taskbot-temp/';
        $base64Url         = !empty($_POST['image_url']) ? $_POST['image_url'] : '';
        $json             = array();

        if ( !empty( $base64Url ) ) {
            // if user upload new image
            $bse64 = explode(',', $base64Url);
            $bse64 = trim($bse64[1]);

            if(empty($bse64)) {
                $json['type']           = 'error';
                $json['message']        = esc_html__('OH', 'taskbot');
                $json['message_desc']   = esc_html__('Image is not in correct format', 'taskbot');
                wp_send_json($json);
            }

            $timestamp    = time(); // create new timestamp
            $file_name    = $user_identity.'-'.$timestamp.'.jpg';
            $image_url    = $upload_dir.$file_name;

            // if (empty($wp_filesystem)) {
            //     require_once (ABSPATH . '/wp-admin/includes/file.php');
            //     WP_Filesystem();
            // }

            $base64Url = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Url));
            file_put_contents( $image_url, $base64Url );
            //$wp_filesystem->put_contents($image_url, $base64Url,0777  );

            if( file_exists( $image_url ) ) {
                $pre_attachment_id  = get_post_thumbnail_id($linked_profile);
                $new_image          = $uploadspath['baseurl'].'/taskbot-temp/'.$file_name;

                if ( ! empty( $pre_attachment_id ) ) {
                    wp_delete_attachment($pre_attachment_id, true);
                }

                $profile_avatar     = taskbot_temp_upload_to_media($new_image, $linked_profile);
                set_post_thumbnail($linked_profile, $profile_avatar['attachment_id']);

                update_post_meta( $linked_profile, 'is_avatar', 1 );

                $avatar_150_x_150           = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 150, 'height' => 150), $linked_profile), array('width' => 150, 'height' => 150) );
                $avatar_50_x_50             = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $linked_profile), array('width' => 50, 'height' => 50) );
                $json['avatar_150_x_150']   = ! empty( $avatar_150_x_150 )  ? $avatar_150_x_150 : '' ;
                $json['avatar_50_x_50']     = ! empty( $avatar_50_x_50 )    ? $avatar_50_x_50   : '';
                $json['type']               = 'success';
                $json['message_desc']       = esc_html__('Settings have been updated successfully.', 'taskbot');

                
            } else {
                $json['type']               = 'error';
                $json['message']            = esc_html__('OH', 'taskbot');
                $json['message_desc']       = esc_html__('Something went wrong.', 'taskbot');
            }

        } else {
            $json['type']               = 'error';
            $json['message']            = esc_html__('OH', 'taskbot');
            $json['message_desc']       = esc_html__('Something went wrong.', 'taskbot');
        }

      wp_send_json( $json );
    }
    add_action( 'wp_ajax_taskbot_update_avatar', 'taskbot_update_avatar' );
}

/**
 * Saved item
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_saved_items')) {
    function taskbot_saved_items()
    {
      global $current_user;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if (empty($_POST['id']) || !is_user_logged_in(  ) ){
            $json['type']       = 'error';
            $json['message'] 	  = esc_html__('Please login to mark task as favorite','taskbot');
            wp_send_json( $json );
        }

        taskbotUpdateSavedItems($current_user->ID,$_POST);

    }
    add_action( 'wp_ajax_taskbot_saved_items', 'taskbot_saved_items' );
    add_action( 'wp_ajax_nopriv_taskbot_saved_items', 'taskbot_saved_items' );
}

/**
 * Saved education
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_save_education')) {
    function taskbot_save_education()
    {
        global $current_user;        
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $profile_data   = !empty($_POST['data']) ? $_POST['data']: array();
        $index_key      = isset($_POST['key']) ? $_POST['key']: '';
        $mode           = !empty($_POST['mode']) ? $_POST['mode']: '';
       
        $validation_fields  = array(
            'title'     => esc_html__('Degree title is required','taskbot'),
            'start_date' => esc_html__('Start date is required','taskbot')
        );

        $validation_fields  = apply_filters('taskbot_filter_education_fields',$validation_fields);

        $json               = array();
        $json['type']       = 'error';
        $json['message'] 	= esc_html__('Education','taskbot');
        parse_str($profile_data,$profile_data);

        foreach($profile_data['education'] as $key => $value ){
            foreach($validation_fields as $edu_key => $validation_field ){

                if( empty($value[$edu_key]) ){
                    $json['message_desc'] 		= $validation_field;
                    wp_send_json($json);
                }

            }
        }
        
        $user_type		  = apply_filters('taskbot_get_user_type', $current_user->ID );
        $profile_id	    = taskbot_get_linked_profile_id($current_user->ID,'',$user_type);
        $tb_post_meta   = get_post_meta( $profile_id,'tb_post_meta',true );
        $tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();
        $education      = !empty($tb_post_meta['education']) ? $tb_post_meta['education'] : array();
        $add_education  = !empty($profile_data['education']) ? $profile_data['education'] : array();
        
        if( empty($mode) ){

            if( !empty($education) ){
                $education  = array_merge($education,$add_education);
            } else {
                $education  = $add_education;
            }

        } else {
            $array_key              = array_keys($add_education);
            $array_key              = !empty($array_key[0]) ? intval($array_key[0]) : '';
            $education[$index_key]  = !empty($array_key) ? $add_education[$array_key] : $add_education;
        }

        $tb_post_meta['education']  = $education;
        update_post_meta( $profile_id, 'tb_post_meta', $tb_post_meta );

        $json['type'] 		    = 'success';
        $json['message'] 		= esc_html__('Woohoo!', 'taskbot');
        $json['message_desc'] 	= esc_html__('Your education have been updated', 'taskbot');
        wp_send_json( $json );

    }
    add_action( 'wp_ajax_taskbot_save_education', 'taskbot_save_education' );
}

/**
 * Saved education
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_remove_education')) {
    function taskbot_remove_education()
    {
        global $current_user;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }

        $index_key          = isset($_POST['key']) ? $_POST['key']: '';
        $json               = array();
        $json['type']       = 'error';
        $json['message'] 	= esc_html__('Education','taskbot');

        if( !isset($index_key) ){
            $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');
            wp_send_json($json);
        }

        $user_type		= apply_filters('taskbot_get_user_type', $current_user->ID );
        $profile_id	    = taskbot_get_linked_profile_id($current_user->ID,'',$user_type);
        $tb_post_meta   = get_post_meta( $profile_id,'tb_post_meta',true );
        $tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();
        $education      = !empty($tb_post_meta['education']) ? $tb_post_meta['education'] : array();

        unset($education[$index_key]);
        $tb_post_meta['education']  = $education;
        update_post_meta( $profile_id, 'tb_post_meta', $tb_post_meta );

        $json['type']           = 'success';
        $json['message']        = esc_html__('Woohoo!', 'taskbot');
        $json['message_desc']   = esc_html__('Your education have been updated', 'taskbot');
        wp_send_json( $json );

    }
    add_action( 'wp_ajax_taskbot_remove_education', 'taskbot_remove_education' );
}

/**
 * Get categories
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_terms_dropdown')) {
  function taskbot_get_terms_dropdown($parent_id='', $term_id='')
  {
        if( !empty($parent_id) ){
            $taskbot_args   = array(
                'show_option_none'  => esc_html__('Choose sub category', 'taskbot'),
                'show_count'    => false,
                'hide_empty'    => false,
                'name'          => 'taskbot_service[category_level2]',
                'class'         => 'service-dropdwon',
                'taxonomy'      => 'product_cat',
                'id'            => 'tb-service-level2',
                'value_field'   => 'term_id',
                'orderby'       => 'name',
                'option_none_value' => '',
                'parent'        => $parent_id,
                'hide_if_empty' => false,
                'echo'          => false,
                'required'      => false,
            );
            
            if(!empty($term_id)) {
                $taskbot_args['selected']   = $term_id;
            }
            $child_categories        = '<label class="form-group-title">'.esc_html__('Sub-category:','taskbot').'</label><span class="tb-select">';
            $child_categories       .= wp_dropdown_categories( $taskbot_args );
            $child_categories       .= '</span></label>';
            echo do_shortcode( $child_categories );
        }

  }

  add_action( 'taskbot_get_terms', 'taskbot_get_terms_dropdown', 10, 2 );
}

/**
 * Get categories
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_terms')) {
    function taskbot_get_terms($parent_id='', $term_id='')
    {
        if(isset($parent_id) && !empty($parent_id) ){
            $parent_id  = $parent_id;
        } else {
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            $parent_id  = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        }

        if( !empty($parent_id) ){
            $taskbot_args   = array(
                'show_option_none'  => esc_html__('Choose sub category', 'taskbot'),
                'show_count'    => false,
                'hide_empty'    => 0,
                'name'          => 'taskbot_service[category_level2]',
                'class'         => 'service-dropdwon',
                'taxonomy'      => 'product_cat',
                'id'            => 'tb-service-level2',
                'value_field'   => 'term_id',
                'orderby'       => 'name',
                'option_none_value' => '',
                'parent'        => $parent_id,
                'hide_if_empty' => 0,
                'echo'          => 0,
                'required'      => 0,
            );

            if(!empty($term_id)) {
                $taskbot_args['selected']   = $term_id;
            }
            $child_categories        = '<label class="form-group-title">'.esc_html__('Sub-category:','taskbot').'</label><span class="tb-select">';
            $child_categories       .= wp_dropdown_categories( $taskbot_args );
            $child_categories       .= '</span></label>';

            if(isset($term_id) && !empty($term_id) ){
                echo do_shortcode( $child_categories );
            } else {
                $json['type'] 		    = 'success';
                $json['categories']		= $child_categories;
                wp_send_json( $json );
            }
        } else {
            $json['type']     = 'error';
            $json['message']  = esc_html__('Oops!', 'taskbot');
            $json['message_desc']  = esc_html__('Please select category', 'taskbot');
            wp_send_json( $json );
        }
  }
  add_action( 'wp_ajax_taskbot_get_terms', 'taskbot_get_terms' );
}

/**
 * Get categories
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_terms_subcategories_dropdown')) {
    function taskbot_get_terms_subcategories_dropdown($parent_id, $term_ids=array(),$type='')
    {
        
        if( !empty($parent_id) ){

            if(!empty($term_ids) && is_array($term_ids)){
                $term_ids = implode(',', $term_ids);
            }

            add_filter( 'wp_dropdown_cats', 'taskbot_dropdown_cats_multiple', 10, 2 );
            $type_text      = esc_html__('Task type', 'taskbot');
            if( !empty($type) && $type === 'project' ){
                $type_text      = esc_html__('Project type', 'taskbot');
            }
            $taskbot_args   = array(
                'show_option_none'  => $type_text,
                'show_count'    => 0,
                'hide_empty'    => 0,
                'name'          => 'taskbot_service[category_level3][]',
                'class'         => 'service-dropdwon tb-service-select2',
                'multiple'      => true,
                'taxonomy'      => 'product_cat',
                'id'            => 'tb-service-'.$parent_id,
                'value_field'   => 'term_id',
                'orderby'       => 'name',
                'parent'        => $parent_id,
                'hide_if_empty' => 0,
                'echo'          => 0,
                'required'      => 0,
                'option_none_value' => '',
            );
            
            if(!empty($term_ids)) {
                $taskbot_args['selected']   = $term_ids;
            }

            $child_categories        = '<label class="form-group-title">'.$type_text.':</label><span class="tb-select">';
            $child_categories       .= wp_dropdown_categories( $taskbot_args );
            $child_categories       .= '</span></label>';
            echo do_shortcode( $child_categories );
            remove_filter( 'wp_dropdown_cats', 'taskbot_dropdown_cats_multiple', 10, 2 );
        }
    }
    add_action( 'taskbot_get_terms_subcategories', 'taskbot_get_terms_subcategories_dropdown', 10, 3 );
}

/**
 * Get categories
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_terms_subcategories')) {
    function taskbot_get_terms_subcategories($parent_id, $term_ids=array())
    {
        if(isset($term_id) && !empty($term_id) ){
            $parent_id  = $term_id;
        } else {

            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }

            $parent_id  = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        }



        if( !empty($parent_id) ){

            if(!empty($term_ids) && !is_array($term_ids)){
                $term_ids = array($term_ids);
            } 

            $type_text      = esc_html__('Task type', 'taskbot');
            if( !empty($_POST['type']) && $_POST['type'] === 'project' ){
                $type_text      = esc_html__('Project type', 'taskbot');
            }
            $taskbot_args   = array(
                'show_option_none'  => $type_text,
                'show_count'    => 0,
                'hide_empty'    => 0,
                'name'          => 'taskbot_service[category_level3][]',
                'class'         => 'service-dropdwon tb-service-select2',
                'multiple'      => 'multiple',
                'taxonomy'      => 'product_cat',
                'id'            => 'tb-service-'.$parent_id,
                'value_field'   => 'term_id',
                'orderby'       => 'name',
                'parent'        => $parent_id,
                'hide_if_empty' => 0,
                'echo'          => 0,
                'required'      => 0,
                'option_none_value' => '',
            );

            if(!empty($term_ids)) {
                $taskbot_args['selected']   = $term_ids;
            }
            
            $child_categories        = '<label class="form-group-title">'.$type_text.':</label><span class="tb-select">';
            $child_categories       .= wp_dropdown_categories( $taskbot_args );
            $child_categories       .= '</span></label>';

            if(isset($term_id) && !empty($term_id) ){
                echo do_shortcode( $child_categories );
            } else {
                $json['type'] 		    = 'success';
                $json['categories']		= $child_categories;
                wp_send_json( $json );
            }

        }
    }
    add_action( 'wp_ajax_taskbot_get_terms_subcategories', 'taskbot_get_terms_subcategories' );
}

/**
 * Tasks checkout
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_service_checkout')) {
    function taskbot_service_checkout()
    {
        global $current_user,$woocommerce,$taskbot_settings;
        $admin_commision_buyers     =  !empty($taskbot_settings['admin_commision_buyers']) ? $taskbot_settings['admin_commision_buyers'] : 0;
        $commission_text            =  !empty($taskbot_settings['commission_text']) ? $taskbot_settings['commission_text'] : esc_html__('Processing fee', 'taskbot');

        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        if( function_exists('taskbot_verified_user') ) { 
            taskbot_verified_user();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if ( !class_exists('WooCommerce') ) {
            return;
        }

        $data           = !empty($_POST['data']) ? $_POST['data'] : array();
        parse_str($data,$data);

        $wallet         = !empty($data['wallet']) ? esc_html($data['wallet']) : 0;
        $product_id     = !empty($data['id']) ? intval($data['id']) : 0;
        $task           = !empty($data['product_task']) ? $data['product_task'] : '';
        $subtasks       = !empty($data['subtasks']) ? explode(',',$data['subtasks']) : array();
        $seller_id      = get_post_field( 'post_author', $product_id );
        $plans 	        = get_post_meta($product_id, 'taskbot_product_plans', TRUE);
        $plans	        = !empty($plans) ? $plans : array();
        $user_balance   = !empty($current_user->ID) ? get_user_meta( $current_user->ID, '_buyer_balance',true ) : '';
        $plan_price     = !empty($plans[$task]['price']) ? $plans[$task]['price'] : 0;
        $total_price    = $plan_price;

        foreach($subtasks as $key => $subtask_id){
            $single_price   = get_post_meta( $subtask_id, '_regular_price',true );
            $single_price   = !empty($single_price) ? $single_price : 0;
            $total_price    = $total_price + $single_price;
        }

        if ( class_exists('WooCommerce') ) {
            $woocommerce->cart->empty_cart(); //empty cart before update cart
            $user_id        = $current_user->ID;
            $service_fee    = taskbot_commission_fee($total_price);
            $admin_shares   = !empty($service_fee['admin_shares']) ? $service_fee['admin_shares'] : 0.0;
            $seller_shares  = !empty($service_fee['seller_shares']) ? $service_fee['seller_shares'] : $total_price;

            if( !empty($wallet) && !empty($user_balance) && $user_balance < $total_price ){
                $cart_meta['wallet_price']		    = $user_balance;
            }

            $buyer_service_fee		= taskbot_processing_fee_calculation('tasks',$total_price);

            $cart_meta['task_id']		    = $product_id;
            $cart_meta['total_amount']		= $total_price;
            $cart_meta['task']		        = $task;
            $cart_meta['price']		        = $plan_price;
            $cart_meta['subtasks']		    = $subtasks;
            $cart_meta['buyer_id']		    = $user_id;
            $cart_meta['seller_id']		    = $seller_id;
            $cart_meta['admin_shares']		= $admin_shares;
            $cart_meta['seller_shares']		= $seller_shares;
            $cart_meta['payment_type']      = 'tasks';
            $cart_meta['processing_fee']	= !empty( $buyer_service_fee['commission_amount'] ) ? $buyer_service_fee['commission_amount'] : 0.0;


            $cart_data = array(
                'product_id'        => $product_id,
                'cart_data'         => $cart_meta,
                'price'             => $plan_price,
                'payment_type'      => 'tasks',
                'admin_shares'      => $admin_shares,
                'seller_shares'     => $seller_shares,
                'buyer_id'          => $user_id,
                'seller_id'         => $seller_id,
            );

            $woocommerce->cart->empty_cart();
            $cart_item_data = apply_filters('taskbot_service_checkout_cart_data',$cart_data);
            WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);

            if( !empty($subtasks) ){
                foreach($subtasks as $subtasks_id){
                    WC()->cart->add_to_cart( $subtasks_id, 1 );
                }
            }

            if( !empty($wallet) && !empty($user_balance) && $user_balance >= $total_price ){
                taskbot_place_order($current_user->ID,'task-wallet');
                $json['checkout_url']	= Taskbot_Profile_Menu::taskbot_profile_menu_link('tasks-orders', $current_user->ID, true);
            } else {
                $json['checkout_url']	= wc_get_checkout_url();
            }

            $json['type'] 		        = 'success';
            wp_send_json( $json );
        }
    }
    add_action( 'wp_ajax_taskbot_service_checkout', 'taskbot_service_checkout' );
}

/**
 * Hiring payment setting
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if ( !function_exists( 'taskbot_processing_fee_calculation' ) ) {
	function taskbot_processing_fee_calculation($type='',$price=0) {
        global $current_user,$taskbot_settings;
        $admin_commision_buyers     =  !empty($taskbot_settings['admin_commision_buyers']) ? $taskbot_settings['admin_commision_buyers'] : 0;

		$settings	        = array();
        $commision_type     = 'percentage';

		if(!empty($commision_type) && $commision_type == 'percentage' ){
			$percentage		= !empty($admin_commision_buyers) ? $admin_commision_buyers : 0;
			$commission 	= $price/100 * $percentage;
			$price 			= $price + $commission;
		}else{
			$price 	= $price;
		}
		
		$settings['commission_amount']	= !empty( $commission )  ? $commission : 0.0;
		$settings['total_amount']		= $price;

		return $settings;
	}
}

///**
// * Package checkout
// *
// * @throws error
// * @author Amentotech <theamentotech@gmail.com>
// * @return
// */
//if ( !function_exists( 'taskbot_processing_fee_calculation' ) ) {
//	function taskbot_processing_fee_calculation($type='',$price=0) {
//        global $current_user,$taskbot_settings;
//        $admin_commision_buyers     =  !empty($taskbot_settings['admin_commision_buyers']) ? $taskbot_settings['admin_commision_buyers'] : 0;
//
//		$settings	        = array();
//        $commision_type     = 'percentage';
//
//		if(!empty($commision_type) && $commision_type == 'percentage' ){
//			$percentage		= !empty($admin_commision_buyers) ? $admin_commision_buyers : 0;
//			$commission 	= $price/100 * $percentage;
//			$price 			= $price + $commission;
//		}else{
//			$price 	= $price;
//		}
//
//		$settings['commission_amount']	= !empty( $commission )  ? $commission : 0.0;
//		$settings['total_amount']		= $price;
//
//		return $settings;
//	}
//}

/**
 * Package checkout
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_package_checkout')) {
    function taskbot_package_checkout()
    {
        global $current_user,$woocommerce;
        $json = array();
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        $json['message']           = esc_html__('Package','taskbot');
        if (!empty($current_user->ID)){
            $get_user_type	= apply_filters('taskbot_get_user_type', $current_user->ID );
            if (!empty($get_user_type) && ($get_user_type == 'sellers' || $get_user_type == 'buyers')){
                $seller_profile_id  = taskbot_get_linked_profile_id($current_user->ID);
                do_action('taskbot_check_user_account_status', $seller_profile_id); //check if user is not blocked or deactive
            } else {
                $json['type']           = 'error';
                $json['message_desc']   = esc_html__('You are not allowed to perfom this action', 'taskbot');
                wp_send_json($json);
            }
        }

        $product_id     = !empty($_POST['package_id']) ? intval($_POST['package_id']) : 0;

        if ( class_exists('WooCommerce') ) {
            $woocommerce->cart->empty_cart();
            $product                    = wc_get_product( $product_id );
            $cart_meta                  = array();
            $cart_meta['package_id']    = $product_id;
            $cart_meta['product_name']  = $product->get_name();
            $cart_meta['price']         = $product->get_price();
            $cart_meta['payment_type']  = 'package';
            $cart_meta['user_type']     = $get_user_type;
            $cart_data  = array(
                'package_id'    => $product_id,
                'cart_data'     => $cart_meta,
                'payment_type'  => 'package',
                'user_type'     => $get_user_type,
            );
            $woocommerce->cart->empty_cart();
            $cart_item_data = apply_filters('taskbot_package_update_cart_data',$cart_data);
            WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
            $json['type'] 		        = 'success';
            $json['cart_item_data'] 		        = $cart_item_data;
            $json['checkout_url']		= wc_get_checkout_url();
            wp_send_json( $json );
        } else {
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('Please install WooCommerce plugin to process this order', 'taskbot');
            wp_send_json($json);
        }
    }
    add_action( 'wp_ajax_taskbot_package_checkout', 'taskbot_package_checkout' );
}

/**
 * Package checkout
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_wallet_checkout')) {
    function taskbot_wallet_checkout()
    {
        global $current_user,$woocommerce,$taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        if( function_exists('taskbot_verified_user') ) { 
            taskbot_verified_user();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }
        $wallet_amount  = !empty($_POST['wallet_amount']) ? ($_POST['wallet_amount']) : 0;
        $min_amount     = !empty($taskbot_settings['min_wallet_amount']) ? $taskbot_settings['min_wallet_amount'] : 0;
        $json             = array();
        $json['message']  = esc_html__('Wallet amount','taskbot');

        if(empty($wallet_amount) ){
            $json['type']         = 'error';
            $json['message_desc'] = esc_html__('Please add amount', 'taskbot');
            wp_send_json($json);
        } else if($wallet_amount < $min_amount ){
            $json['type']         = 'error';
            $json['message_desc'] = sprintf(esc_html__('Please add minimum amount %s to add in your wallet', 'taskbot'),taskbot_price_format($min_amount,'return'));
            wp_send_json($json);
        }
        
        if ( class_exists('WooCommerce') ) {
            $woocommerce->cart->empty_cart();
            $product_id                 = taskbot_buyer_wallet_create();
            $user_id                    = $current_user->ID;
            $cart_meta                  = array();
            $cart_meta['wallet_id']     = $product_id;
            $cart_meta['product_name']  = get_the_title($product_id);
            $cart_meta['price']         = $wallet_amount;
            $cart_meta['payment_type']  = 'wallet';
            $cart_data  = array(
                'wallet_id' => $product_id,
                'cart_data' => $cart_meta,
                'price'     => $wallet_amount,
                'payment_type'  => 'wallet'
            );
            $woocommerce->cart->empty_cart();
            $cart_item_data = apply_filters('taskbot_update_wallet_cart_data',$cart_data);
            WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
            session_start();
            $_SESSION["redirect_type"]  = 'wallet_checkout';
            $_SESSION["redirect_url"]   = !empty($_POST['url']) ? esc_url_raw($_POST['url']): '';
            $json['type'] 		          = 'success';
            $json['checkout_url']       = wc_get_checkout_url();
            wp_send_json( $json );

        } else {
            $json['type']         = 'error';
            $json['message_desc'] = esc_html__('Please install WooCommerce plugin to process this order', 'taskbot');
            wp_send_json($json);
        }

    }
    add_action( 'wp_ajax_taskbot_wallet_checkout', 'taskbot_wallet_checkout' );
}


/**
 * categories multiple dropdown name filter
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_dropdown_cats_multiple')) {
    function taskbot_dropdown_cats_multiple( $output, $r ) {

        if( !empty($r['multiple'] )) {
            $output = preg_replace( '/^<select/i', '<select multiple', $output );
            $output = str_replace( "name='{$r['name']}'", "name='{$r['name']}'", $output );
            
            $selected_array = array();
            if(!empty($r['selected'])){
                $selected_array = $r['selected'];
        
                if(!is_array($r['selected']) ){
                    $selected_array = explode( ",", $selected_array);
                }

                foreach ( $selected_array as $value ){
                    $output = str_replace( "value=\"{$value}\"", "value=\"{$value}\" selected", $output );
                }
            }            
            
        }

        return $output;

    }
}

/**
 * Get categories
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_tasks_total')) {
    function taskbot_get_tasks_total()
    {
        global $current_user,$taskbot_settings;

        $admin_commision_buyers     =  !empty($taskbot_settings['admin_commision_buyers']) ? $taskbot_settings['admin_commision_buyers'] : 0;
        $commission_text            =  !empty($taskbot_settings['commission_text']) ? $taskbot_settings['commission_text'] : esc_html__('Processing fee', 'taskbot');
        $task_id      = !empty($_POST['task_id']) ? intval($_POST['task_id']) : 0;
        $task_key     = !empty($_POST['task_key']) ? sanitize_text_field($_POST['task_key']) : 0;
        $sub_tasks    = !empty($_POST['sub_tasks']) ? ($_POST['sub_tasks']) : array();
        $task_price   = 0;
        $task_title   = '';

        if( !empty($task_id) && !empty($task_key) ){
            $plans_values 	= get_post_meta($task_id, 'taskbot_product_plans', TRUE);
            $plans_values	= !empty($plans_values) ? $plans_values : array();
            $total_price    = 0;

            if( !empty($plans_values[$task_key]['price'])){
                $total_price    = !empty($plans_values[$task_key]['price']) ? $plans_values[$task_key]['price'] : 0;
                $task_title     = !empty($plans_values[$task_key]['title']) ? $plans_values[$task_key]['title'] : '';
                
                if(function_exists('wmc_get_price')){
                   $total_price     = wmc_get_price( $total_price );
                }
                $task_price     = $total_price;
            }
            if( !empty($sub_tasks) ){
                foreach($sub_tasks as $sub_task ){
                    $subtask_price 	= wc_get_product( $sub_task );
                    $subtask_price	= !empty($subtask_price) ? $subtask_price->get_regular_price() : 0;
                    $total_price    = $total_price + $subtask_price;
                }
            }

            $json['processing_fee'] 		    = 0;
            $json['processing_fee_val'] 		= 0;
            $json['processing_fee_title'] 		= $commission_text;
            if(!empty($admin_commision_buyers )){
                $processing_fee = ( $total_price/100 ) * $admin_commision_buyers;
                $total_price    = $total_price + $processing_fee;

                $json['processing_fee_val'] = $processing_fee;
                $json['processing_fee']     = taskbot_price_format($processing_fee,'return','true');
            }

            $json['type'] 		    = 'success';
            $json['task_title'] 	= $task_title;
            $json['totalPrice']		= taskbot_price_format($total_price,'return','true');
            $json['task_price']		= taskbot_price_format($task_price,'return','true');
            wp_send_json( $json );

        }

    }
    add_action('wp_ajax_taskbot_get_tasks_total', 'taskbot_get_tasks_total');
    add_action('wp_ajax_nopriv_taskbot_get_tasks_total', 'taskbot_get_tasks_total');
}

/**
 * Download product
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_download_zip_file')) {
    function taskbot_download_zip_file()
    {
        global $current_user;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        $json             = array();
        $product_id       = !empty($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $order_id         = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $json['message']  = esc_html__('Download files','taskbot');

        if( !empty($product_id)){
            $attachments_files  = get_post_meta( $product_id, '_downloadable_files',true );
            if( !empty( $attachments_files ) ){

                if( class_exists('ZipArchive') ){
                    $zip                = new ZipArchive();
                    $uploadspath	    = wp_upload_dir();
                    $folderRalativePath = $uploadspath['baseurl']."/downloads";
                    $folderAbsolutePath = $uploadspath['basedir']."/downloads";
                    wp_mkdir_p($folderAbsolutePath);
                    $rand	    = taskbot_unique_increment(5);
                    $filename	= $rand.round(microtime(true)).'.zip';
                    $zip_name   = $folderAbsolutePath.'/'.$filename;
                    $zip->open($zip_name,  ZipArchive::CREATE);
                    $download_url	= $folderRalativePath.'/'.$filename;

                    foreach($attachments_files as $key => $value) {
                        $file_url	= $value['file'];
                        $response	= wp_remote_get( $file_url );
                        $filedata   = wp_remote_retrieve_body( $response );
                        $zip->addFromString(basename( $file_url ), $filedata);
                    }

                    $zip->close();
                } else {
                    $json['type']           = 'error';
                    $json['message']        = esc_html__('Oops', 'taskbot');
                    $json['message_desc']   = esc_html__('Zip library is not installed on the server, please contact to hosting provider', 'taskbot');
                    wp_send_json($json);
                }
            }

            $json['type']           = 'success';
            $json['attachment']     = taskbot_add_http_protcol( $download_url );
            $json['message_desc']   = esc_html__('Your files have been donwloaded', 'taskbot');
            wp_send_json($json);
        }
    }
    add_action( 'wp_ajax_taskbot_download_zip_file', 'taskbot_download_zip_file' );
}

/**
 * Complete task
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_complete_task_order')) {
    function taskbot_complete_task_order()
    {
        global $taskbot_settings, $current_user;
        
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
    
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }
        
        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['user_id'],'both');
        }

        $json           = array();
        $task_id        = !empty($_POST['task_id']) ? intval($_POST['task_id']) : 0;
        $order_id       = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $type           = !empty($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
        $post_author    = get_post_meta( $order_id, 'buyer_id',true );

        $json['message']        = esc_html__('Complete Task','taskbot');
        $gmt_time		        = current_time( 'mysql', 1 );

        $validation_fields  = array(
            'task_id'   => esc_html__('You are not allowed to perform this action', 'taskbot'),
            'order_id'  => esc_html__('You are not allowed to perform this action', 'taskbot')
        );

        if( !empty($type) && $type == 'rating' ){
            $validation_fields['rating']          = esc_html__('You need to add rating', 'taskbot');
            $validation_fields['rating_title']    = esc_html__('You need to add rating title', 'taskbot');
            $validation_fields['rating_details']  = esc_html__('You need to add rating details', 'taskbot');
        }

        foreach($validation_fields as $key => $validation_field ){

            if( empty($_POST[$key]) ){
                $json['type']               = 'error';
                $json['message_desc'] 		= $validation_field;
                wp_send_json($json);
            }
        }

        if( empty($post_author) || $post_author != $current_user->ID ){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('You are not allowed to perform this action', 'taskbot');
            wp_send_json($json);
        }
        taskbotTaskComplete($current_user->ID,$_POST);
    }
    add_action( 'wp_ajax_taskbot_complete_task_order', 'taskbot_complete_task_order' );
}

/**
 * Task rating
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_task_order_rating')) {
    function taskbot_task_order_rating()
    {
        global $current_user;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }
        $json               = array();
        $json['message']    = esc_html__('Complete Task','taskbot');
        $validation_fields  = array(
            'task_id'       => esc_html__('You are not allowed to perform this action', 'taskbot'),
            'order_id'      => esc_html__('You are not allowed to perform this action', 'taskbot'),
            'rating'        => esc_html__('You need to add rating', 'taskbot'),
            'rating_title'  => esc_html__('You need to add rating title', 'taskbot'),
            'rating_details'=> esc_html__('You need to add rating details', 'taskbot')
        );

        foreach($validation_fields as $key => $validation_field ){

            if( empty($_POST[$key]) ){
                $json['message_desc'] 		= $validation_field;
                wp_send_json($json);
            }
        }
        $task_id        = !empty($_POST['task_id']) ? intval($_POST['task_id']) : 0;
        $order_id       = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $rating_details = !empty($_POST['rating_details']) ? sanitize_textarea_field($_POST['rating_details']) : '';
        $rating_title   = !empty($_POST['rating_title']) ? sanitize_text_field($_POST['rating_title']) : '';
        $rating         = !empty($_POST['rating']) ? sanitize_text_field($_POST['rating']) : '';
        $post_author    = get_post_meta( $order_id, 'buyer_id',true );

        if($post_author != $current_user->ID ){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('You are not allowed to perform this action', 'taskbot');
            wp_send_json($json);
        }

        if( !empty($task_id) && !empty($order_id) ){
            taskbot_complete_task_ratings($order_id,$task_id,$rating,$rating_title,$rating_details,$current_user->ID);
            $json['type']           = 'success';
            $json['message_desc']   = esc_html__('You have successfully completed this task.', 'taskbot');
            wp_send_json($json);
        }
    }
    add_action( 'wp_ajax_taskbot_task_order_rating', 'taskbot_task_order_rating' );
}

/**
 * Task cancellation
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_task_cancellation')) {
    function taskbot_task_cancellation()
    {
        global $current_user, $taskbot_settings,$woocommerce;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['user_id'],'both');
        }

        $json               = array();
        $json['message']    = esc_html__('Cancellation Task','taskbot');
        $validation_fields  = array(
            'task_id'   => esc_html__('You are not allowed to perform this action', 'taskbot'),
            'order_id'  => esc_html__('You are not allowed to perform this action', 'taskbot'),
            'details'   => esc_html__('You need to cancellation reason', 'taskbot')
        );

        foreach($validation_fields as $key => $validation_field ){
            if( empty($_POST[$key]) ){
                $json['message_desc'] 		= $validation_field;
                wp_send_json($json);
            }
        }
        $task_id        = !empty($_POST['task_id']) ? intval($_POST['task_id']) : 0;
        $order_id       = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $details        = !empty($_POST['details']) ? sanitize_textarea_field($_POST['details']) : '';
        $post_author    = get_post_meta( $order_id, 'buyer_id',true );

        if($post_author != $current_user->ID ){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('You are not allowed to perform this action', 'taskbot');
            wp_send_json($json);
        }

        if( !empty($task_id) && !empty($order_id) ){
            taskbotCancelledTask($user_id,$_POST);
        }

    }
    add_action( 'wp_ajax_taskbot_task_cancellation', 'taskbot_task_cancellation' );
}
/**
 * Complete task
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_tk_rating_view')) {
    function taskbot_tk_rating_view()
    {
        $json           = array();
        $rating_id      = !empty($_POST['rating_id']) ? intval($_POST['rating_id']) : 0;
        $comment_detail = !empty($rating_id) ? get_comment($rating_id) : array();
        $user_id        = !empty($comment_detail->user_id) ? $comment_detail->user_id : 0;
        $content        = !empty($comment_detail->comment_content) ? $comment_detail->comment_content : '';
        $post_ID        = !empty($comment_detail->comment_post_ID) ? $comment_detail->comment_post_ID : 0;
        $post_title     = !empty($post_ID) ? get_the_title($post_ID) : '';
        $link_id        = taskbot_get_linked_profile_id( $user_id,'','buyers' );
        $user_name      = !empty($link_id) ? taskbot_get_username($link_id) : '';
        $rating         = !empty($rating_id) ? get_comment_meta($rating_id, 'rating', true) : 0;
        $title          = !empty($rating_id) ? get_comment_meta($rating_id, '_rating_title', true) : '';
        $rating_avg     = !empty($rating) ? ($rating/5)*100 : 0;
        $rating_avg     = !empty($rating_avg) ? 'style="width:'.$rating_avg.'%;"' : '';
        $avatar         = apply_filters(
            'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 350, 'height' => 250), $link_id), array('width' => 350, 'height' => 250)
        );
        ob_start();?>
        <div class="tb-popuptitle">
            <?php if( !empty($post_title) ){?>
                <h4><?php echo esc_html($post_title);?></h4>
            <?php } ?>
            <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
        </div>
        <div class="modal-body">
            <div class="tb-excfreelancerpopup__content">

                <?php if( !empty($avatar) ){?>
                    <figure class="tb-ratinguserimg"><img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>"></figure>
                <?php } ?>
                <?php if( !empty($title) ){?>
                    <h2><?php echo esc_html($title);?></h2>
                <?php } ?>
                <div class="tb-featureRating tb-featureRatingv2">
                    <span class="tb-featureRating__stars"><span <?php echo do_shortcode( $rating_avg );?>></span></span>
                    <h6><?php echo number_format((float)$rating, 1, '.', ''); ?></h6>
                </div>
                <?php if( !empty($content) ){?>
                    <p><?php echo esc_html($content);?></p>
                <?php } ?>
            </div>
        </div>
        <?php
        $json['type']    = 'success';
        $json['html']    = ob_get_clean();
        wp_send_json($json);

    }
    add_action( 'wp_ajax_taskbot_tk_rating_view', 'taskbot_tk_rating_view' );
}

/**
 * Cancelled details
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_tk_cancelled_view')) {
    function taskbot_tk_cancelled_view()
    {
        $json           = array();
        $order_id       = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $user_id        = get_post_meta( $order_id, 'buyer_id', true );
        $link_id        = taskbot_get_linked_profile_id( $user_id,'','buyers' );
        $user_name      = !empty($link_id) ? taskbot_get_username($link_id) : '';
        $task_id        = get_post_meta( $order_id, 'task_product_id', true);
        $task_id        = !empty($task_id) ? $task_id : 0;
        $post_title     = !empty($task_id) ? get_the_title($task_id) : 0;
        $avatar         = apply_filters(
            'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 350, 'height' => 250), $link_id), array('width' => 350, 'height' => 250)
        );
        $content    = get_post_meta( $order_id, '_task_cancellation_reason',true );
        $content    = !empty($content) ? $content : '';
        ob_start();?>
        <div class="tb-popuptitle">
            <?php if( !empty($post_title) ){?>
                <h4><?php echo esc_html($post_title);?></h4>
            <?php } ?>
            <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
        </div>
        <div class="modal-body">
            <div class="tb-excfreelancerpopup__content">
                <?php if( !empty($avatar) ){?>
                    <figure class="tb-ratinguserimg"><img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>"></figure>
                <?php } ?>
                <?php if( !empty($user_name) ){?>
                    <h2><?php echo esc_html($user_name);?></h2>
                <?php } ?>
                <?php if( !empty($content) ){?>
                    <p><?php echo esc_html($content);?></p>
                <?php } ?>
            </div>
        </div>
        <?php
        $json['type']    = 'success';
        $json['html']    = ob_get_clean();
        wp_send_json($json);
    }
    add_action( 'wp_ajax_taskbot_tk_cancelled_view', 'taskbot_tk_cancelled_view' );
}

/**
 * -------------------------------------------------------
 * functions related to task search start
 * -------------------------------------------------------
 */

/**
 * Get second level categories in task search using do_action
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_task_search_get_terms_dropdown')) {
    function taskbot_task_search_get_terms_dropdown($parent_cat_slug='', $sub_cat_slug='', $container_class='tk-select',$option='')
    {
        $parent_id = 0;
        $attr_id    = 'tb-top-service-task-search-level-2';
        // if called using action hook
        if(isset($parent_cat_slug) && !empty($parent_cat_slug) ){
            $parent_id_obj = get_term_by('slug', $parent_cat_slug, 'product_cat');
            if (!empty($parent_id_obj)){
                $parent_id = $parent_id_obj->term_id;
            }
        }
        if( !empty($option) && $option === 'title' ){
            $attr_id    = 'tb-top-service-task-option-level-2';
        }

        if( !empty($parent_id) ){
            $taskbot_args = array(
                'show_option_none'  => esc_html__('Select sub category', 'taskbot'),
                'show_count'    => false,
                'hide_empty'    => false,
                'name'          => 'sub_category',
                'class'         => 'form-control service-dropdwon',
                'taxonomy'      => 'product_cat',
                'id'            => $attr_id,
                'value_field'   => 'slug',
                'orderby'       => 'name',
                'option_none_value' => '',
                'selected'      => $sub_cat_slug,
                'hide_if_empty' => false,
                'echo'          => false,
                'required'      => false,
                'parent'        => $parent_id,
            );
            $child_categories        = '<div class="'.$container_class.'" id="sub_category_container">';
            if( !empty($option) && $option === 'title' ){
                $child_categories        .= '<h6>'.esc_html__('Sub categories','taskbot').'</h6>';
            }
            $child_categories       .= wp_dropdown_categories( $taskbot_args );
            $child_categories       .= '</div>';
            echo do_shortcode( $child_categories );
        }
    }
    add_action( 'taskbot_task_search_get_terms', 'taskbot_task_search_get_terms_dropdown', 10, 4 );
}

/**
 * Get second level categories in task search using Ajax on change first level category drop-down
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_task_search_get_terms')) {
    function taskbot_task_search_get_terms($parent_cat_slug='', $sub_cat_slug='',$option='')
    {
        $parent_id  = 0;
        $title      = '';
        $attr_id    = 'tb-top-service-task-search-level-2';
        // if called using action hook
        if(isset($parent_cat_slug) && !empty($parent_cat_slug) ){
            $parent_id_obj = get_term_by('slug', $parent_cat_slug, 'product_cat');
            if (!empty($parent_id_obj)){
                $parent_id = $parent_id_obj->term_id;
            }
        } else {
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            $parent_cat_slug    = !empty($_POST['id']) ? esc_html($_POST['id']) : '';
            $option             = !empty($_POST['option']) ? esc_html($_POST['option']) : '';
            if (isset($parent_cat_slug) && !empty($parent_cat_slug)){
                $parent_id_obj = get_term_by('slug', $parent_cat_slug, 'product_cat');
                if (!empty($parent_id_obj)){
                    $parent_id = $parent_id_obj->term_id;
                }
            }
        }
        if( !empty($option) && $option === 'title' ){
            $attr_id    = 'tb-top-service-task-option-level-2';
        }

        if( !empty($parent_id) ){
            $taskbot_args = array(
                'show_option_none'  => esc_html__('Select sub category', 'taskbot'),
                'show_count'    => false,
                'hide_empty'    => false,
                'name'          => 'sub_category',
                'class'         => 'form-control service-dropdwon',
                'taxonomy'      => 'product_cat',
                'id'            => $attr_id,
                'value_field'   => 'slug',
                'orderby'       => 'name',
                'option_none_value' => '',
                'selected'      => $sub_cat_slug,
                'hide_if_empty' => false,
                'echo'          => false,
                'required'      => false,
                'parent'        => $parent_id,
            );
            $child_categories        = '<div class="tk-select" id="sub_category_container">';
            if( !empty($option) && $option === 'title' ){
                $child_categories        .= '<h6>'.esc_html__('Sub categories','taskbot').'</h6>';
            }
            $child_categories       .= wp_dropdown_categories( $taskbot_args );
            $child_categories       .= '</div>';

            if(isset($sub_cat_slug) && !empty($sub_cat_slug) ){
                echo do_shortcode( $child_categories );
            } else {
                $json['type'] 		    = 'success';
                $json['categories']		= $child_categories;
                wp_send_json( $json );
            }
        }
    }
    add_action( 'wp_ajax_taskbot_task_search_get_terms', 'taskbot_task_search_get_terms' );
    add_action( 'wp_ajax_nopriv_taskbot_task_search_get_terms', 'taskbot_task_search_get_terms' );
}

/**
 * Get third/last level categories in task search using do_action
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_task_search_get_terms_subcategories_dropdown')) {
    function taskbot_task_search_get_terms_subcategories_dropdown($parent_cat_slug, $terms_slug  = array(),$option='')
    {
        $parent_id  = 0;
        $terms_html = '';
        // if called using action hook
        if(isset($parent_cat_slug) && !empty($parent_cat_slug) ){
            $parent_id_obj = get_term_by('slug', $parent_cat_slug, 'product_cat');
            if (!empty($parent_id_obj)){
                $parent_id = $parent_id_obj->term_id;
            }
        }
        if( !empty($parent_id) ){
            if( !empty($option) && $option === 'title' ){
                $terms_html        = '<h6>'.esc_html__('Task type','taskbot').'</h6>';
            }

            $terms_html        .= taskbot_get_product_terms( $parent_id, $terms_slug );
            echo do_shortcode( $terms_html );
        }
    }
    add_action( 'taskbot_task_search_get_terms_subcategories', 'taskbot_task_search_get_terms_subcategories_dropdown', 10, 3 );
}

/**
 * Get third/last level categories in task search using Ajax on change second level category drop-down
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_task_search_get_terms_subcategories')) {
    function taskbot_task_search_get_terms_subcategories( $parent_cat_slug, $terms_slug  = array(),$option='')
    {
        $parent_id  = 0;
        // if called using action hook
        if(isset($parent_cat_slug) && !empty($parent_cat_slug) ){
            $parent_id_obj = get_term_by('slug', $parent_cat_slug, 'product_cat');
            if (!empty($parent_id_obj)){
                $parent_id = $parent_id_obj->term_id;
            }
        } else {
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            $parent_cat_slug    = !empty($_POST['id']) ? esc_html($_POST['id']) : '';
            $option             = !empty($_POST['option']) ? esc_html($_POST['option']) : '';
            if (isset($parent_cat_slug) && !empty($parent_cat_slug)){
                $parent_id_obj = get_term_by('slug', $parent_cat_slug, 'product_cat');
                if (!empty($parent_id_obj)){
                    $parent_id = $parent_id_obj->term_id;
                }
            }
        }

        if( !empty($parent_id) ){
            if( !empty($option) && $option === 'title' ){
                $terms_html        .= '<h6>'.esc_html__('Task type','taskbot').'</h6>';
            }
            $terms_html         .= taskbot_get_product_terms( $parent_id, $terms_slug );
            if(isset($term_id) && !empty($term_id) ){
                echo do_shortcode( $terms_html );
            } else {
                $json['type'] 		    = 'success';
                $json['terms_html']		= $terms_html;
                wp_send_json( $json );
            }
        }
    }
    add_action( 'wp_ajax_taskbot_task_search_get_terms_subcategories', 'taskbot_task_search_get_terms_subcategories' );
    add_action( 'wp_ajax_nopriv_taskbot_task_search_get_terms_subcategories', 'taskbot_task_search_get_terms_subcategories' );
}

/**
 * Get product terms, method used by other search task related methods
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_product_terms')) {
    function taskbot_get_product_terms($parent_id, $selected_terms_arr)
    {
        $terms_html = '';
        $terms = get_terms( 'product_cat', array( 'parent' => $parent_id, 'orderby' => 'slug', 'hide_empty' => false ) );

        if (isset($terms) && !empty($terms)){
            $terms_html .= '<ul class="tk-categoriesfilter">';
            foreach ($terms as $term){
                $checked = false;
                
                if (isset($selected_terms_arr) && !empty($selected_terms_arr)){
                    $checked = in_array($term->slug, $selected_terms_arr);
                }
                $terms_html .=  '<li>';
                $terms_html .=    '<div class="tk-form-checkbox">';
                $terms_html .=      '<input class="form-check-input tk-form-check-input-sm" id="term_'.$term->term_id.'" type="checkbox" name="service[]" value="'.$term->slug.'" '.($checked ? 'checked' : '').'>';
                $terms_html .=      '<label class="form-check-label" for="term_'.$term->term_id.'"><span>'.$term->name.'</span></label>';
                $terms_html .=    '</div>';
                $terms_html .= '</li>';
            }
            $terms_html .= '</ul>';
        }
        return $terms_html;
    }
}

/**
 * Create dispute
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_dispute_request_submit')) {
    function taskbot_dispute_request_submit() {
        $json = array();
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $do_check = check_ajax_referer('ajax_nonce', 'security', false);

        if ( $do_check == false ) {
            $json['type'] = 'error';
            $json['message'] = 'Oops!';
            $json['message_desc'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json( $json );
        }

        $dispute_id  = !empty($_POST['dispute_id']) ?  $_POST['dispute_id'] : '';

        if(empty($dispute_id)){
            $json['type'] = 'error';
            $json['message'] = 'Oops!';
            $json['message_desc'] = esc_html__('Something wrong! please try again', 'taskbot');
            wp_send_json( $json );
        }

        taskbotUpdateDisputeStatus($dispute_id,'disputed');
    }
    add_action('wp_ajax_taskbot_dispute_request_submit', 'taskbot_dispute_request_submit');
}

/**
 * Create dispute
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_submit_dispute')) {

    function taskbot_submit_dispute() {
        global $current_user,$post,$taskbot_settings;
        $json = array();
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $do_check = check_ajax_referer('ajax_nonce', 'security', false);

        if ( $do_check == false ) {
            $json['type']           = 'error';
            $json['message']        = 'Oops!';
            $json['message_desc']   = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json( $json );
        }

        $post_data  = !empty($_POST['data']) ?  $_POST['data'] : '';
        parse_str($post_data,$data);
        $get_user_type	= apply_filters('taskbot_get_user_type', $current_user->ID );
        $fields	= array(
            'dispute_issue'     => esc_html__('Please select the dispute reason','taskbot'),
            'dispute-details' 	=> esc_html__('Please add dispute details','taskbot'),
            'dispute_terms' 	=> esc_html__('You must select terms and conditions','taskbot'),
        );
        foreach( $fields as $key => $item ){
            if( empty( $data[$key] ) ){
                $json['type'] 	        = "error";
                $json['message']        = 'Oops!';
                $json['message_desc']   = $item;
                wp_send_json( $json );
            }
        }
        $order_id       = !empty($data['order_id']) ? intval($data['order_id']):'';
        $dispute_is     = get_post_meta( $order_id, 'dispute', true);

        if( !empty( $dispute_is ) && $dispute_is == 'yes' ){
            $json['type']           = "error";
            $json['message']        = 'Oops!';
            $json['message_desc']   = esc_html__("You have already submitted the refund request against this task.", 'taskbot');
            wp_send_json( $json );
        }
        taskbotBuyerCreateDispute($current_user->ID,$data);
        
    }
    add_action('wp_ajax_taskbot_submit_dispute', 'taskbot_submit_dispute');
}

/**
 * Create dispute
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_seller_submit_dispute')) {

    function taskbot_seller_submit_dispute() {
        global $current_user,$post,$taskbot_settings;
        $json = array();
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $do_check = check_ajax_referer('ajax_nonce', 'security', false);

        if ( $do_check == false ) {
            $json['type'] = 'error';
            $json['message'] = 'Oops!';
            $json['message_desc'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json( $json );
        }

        $post_data  = !empty($_POST['data']) ?  $_POST['data'] : '';
        parse_str($post_data,$data);
        $fields	= array(
            'dispute_issue'     => esc_html__('Please select the dispute reason','taskbot'),
            'dispute-details' 	=> esc_html__('Please add dispute details','taskbot'),
            'dispute_terms' 	  => esc_html__('You must select terms and conditions','taskbot'),
        );
        foreach( $fields as $key => $item ){
            if( empty( $data[$key] ) ){
                $json['type'] 	 = "error";
                $json['message'] = 'Oops!';
                $json['message_desc'] = $item;
                wp_send_json( $json );
            }
        }
        
        taskbotSellerCreateDispute($current_user->ID,$data);
    }
    add_action('wp_ajax_taskbot_seller_submit_dispute', 'taskbot_seller_submit_dispute');
}

/*
* Add/Update payout settings
*
* @throws error
* @author Amentotech <theamentotech@gmail.com>
* @return
*/
if (!function_exists('taskbot_payout_settings')) {
    function taskbot_payout_settings()
    {
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $user_id = (isset($_POST['user_id']) && $_POST['user_id'] != '') ? $_POST['user_id'] : '';
        /* verify security token */
        if (function_exists('taskbot_verify_token')) {
            taskbot_verify_token($_POST['security']);
        }

        /* check user logged-in or not */
        if (function_exists('taskbot_authenticate_user_validation')) {
            taskbot_authenticate_user_validation($user_id, 'both');
        }
        $json = array();
        $payout_list = taskbot_get_payouts_lists();
       // $fields = !empty($payout_list[$_POST['payout_settings']['type']]['fields']) ? $payout_list[$_POST['payout_settings']['type']]['fields'] : array();

        /* creating associative array */
        $payout_setings     = !empty($_POST['payout_settings']) ? $_POST['payout_settings'] : array();
        $payout_method_arr  = get_user_meta($user_id, 'taskbot_payout_method',true);
        $payout_method_arr  = !empty($payout_method_arr) ? $payout_method_arr : array();
        if (!empty($payout_setings)) {
            foreach ($payout_setings as $type_key => $val) {
                $fields = !empty($payout_list[$type_key]['fields']) ? $payout_list[$type_key]['fields'] : array();
                if (!empty($fields)) {
                    foreach ($fields as $key => $field) {
        
                        if ($field['required'] === true && empty($payout_setings[$type_key][$key])) {
                            $json['type']         = 'error';
                            $json['message']      = esc_html__('Opps!', 'taskbot');
                            $json['message_desc'] = $field['message'];
                            wp_send_json($json);
                        }
                    }
                }
                $payout_method_arr[$type_key] = $val;
            }
        }

        
        update_user_meta($user_id, 'taskbot_payout_method', $payout_method_arr);
        $json['type'] = 'success';
        $json['message'] = esc_html__('Woohoo!', 'taskbot');
        $json['message_desc'] = esc_html__('Payout settings have been updated.', 'taskbot');
        wp_send_json($json);
    }
    add_action('wp_ajax_taskbot_payout_settings', 'taskbot_payout_settings');
}

/*
* Remove payment method
*
* @throws error
* @author Amentotech <theamentotech@gmail.com>
* @return
*/
if (!function_exists('taskbot_remove_paymentmethod')) {
    function taskbot_remove_paymentmethod()
    {
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        /* verify security token */
        if (function_exists('taskbot_verify_token')) {
            taskbot_verify_token($_POST['security']);
        }
        global $current_user;
        
        $json = array();
        
        if( empty($_POST['key'])){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('Oops! you are not allowed to perfom this action', 'taskbot');
        } else {
            $key                = !empty($_POST['key']) ? sanitize_text_field($_POST['key']) : "";
            $payout_method_arr  = get_user_meta($current_user->ID, 'taskbot_payout_method',true);
            if(!empty($payout_method_arr) && !empty($payout_method_arr[$key])){
                unset($payout_method_arr[$key]);
            }

            update_user_meta($current_user->ID, 'taskbot_payout_method', $payout_method_arr);
            $json['type']           = 'success';
            $json['message']        = esc_html__('Woohoo!', 'taskbot');
            $json['message_desc']   = esc_html__('Payout settings have been updated.', 'taskbot');
            wp_send_json($json);
        }
        
        
    }
    add_action('wp_ajax_taskbot_remove_paymentmethod', 'taskbot_remove_paymentmethod');
}

/*
 * Submit Withdraw Amount Request
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_money_withdraw')) {
    function taskbot_money_withdraw()
    {
        global $current_user,$taskbot_settings;
        $json           = array();
        $insert_payouts = '';
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        // check user logged-in
        if (function_exists('taskbot_authenticate_user_validation')) {
            taskbot_authenticate_user_validation($_POST['id'], 'both');
        }

        // verify security token
        if (function_exists('taskbot_verify_token')) {
            taskbot_verify_token($_POST['security']);
        }

        taskbotWithdraqRequest($current_user->ID,$_POST);

    }
    add_action('wp_ajax_taskbot_money_withdraw', 'taskbot_money_withdraw');
}

/** 
 * Get formated user billing address
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_user_billing_address')) {
    function taskbot_user_billing_address($user_id) {
        $billing_first_name = get_user_meta( $user_id, 'billing_first_name', true );
        $billing_last_name  = get_user_meta( $user_id, 'billing_last_name', true );
        $billing_company    = get_user_meta( $user_id, 'billing_company', true );
        $billing_address_1  = get_user_meta( $user_id, 'billing_address_1', true );
        $billing_city       = get_user_meta( $user_id, 'billing_city', true );
        $billing_state      = get_user_meta( $user_id, 'billing_state', true );
        $billing_postcode   = get_user_meta( $user_id, 'billing_postcode', true );
        $billing_country    = get_user_meta( $user_id, 'billing_country', true );

        $billing_first_name = !empty($billing_first_name) ? $billing_first_name : '';
        $billing_last_name  = !empty($billing_last_name) ? $billing_last_name : '';
        $billing_company    = !empty($billing_company) ? $billing_company : '';
        $billing_address_1  = !empty($billing_address_1) ? $billing_address_1 : '';
        $billing_city       = !empty($billing_city) ? $billing_city : '';
        $billing_state      = !empty($billing_state) ? $billing_state : '';
        $billing_postcode   = !empty($billing_postcode) ? $billing_postcode : '';
        $billing_country    = !empty($billing_country) ? $billing_country : '';
        
        $address  = '';
        $address .= $billing_first_name.' '.$billing_last_name;
        if( !empty($billing_company) ){
            $address .= "\n";
            $address .= $billing_company;
        }
        if( !empty($billing_address_1) ){
            $address .= "\n";
            $address .= $billing_address_1;
        }
        if( !empty($billing_city) || !empty($billing_state) || !empty($billing_postcode) ){
            $address .= "\n";
            $address .= $billing_city;
            if( !empty($billing_city) && !empty($billing_state) ){
                $address .= ",";
            }
            if(!empty($billing_state) ){
                $address .= $billing_state;
            }
            if( !empty($billing_city) || !empty($billing_state) && !empty($billing_postcode) ){
                $address .= ",";
                $address .= $billing_postcode;
            }
        }
        if( !empty($billing_country) ){
            $address .= "\n";
            $address .= $billing_country;
        }
                
        return $address;
    }
}

/**
 * submit task activity/comment
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if( !function_exists( 'taskbot_task_activity' ) ){
    function taskbot_task_activity(){
        global $current_user, $taskbot_settings;
        $json = array();

        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        //security check
        if (!wp_verify_nonce($_POST['security'], 'ajax_nonce')) {
            $json['type']            = 'error';
            $json['message'] 		 = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json($json);
        }

        $message_type = !empty( $_POST['message_type'] ) ? esc_html($_POST['message_type']) : '';
        //form validation
        if ( empty( $_POST['id'] ) || empty( $_POST['activity_detail'] ) ){
            $json['type']     = 'error';
            
            if($message_type == 'final'){
                $json['message']        = esc_html__('Submit final delivery', 'taskbot');
                $json['message_desc']   = esc_html__('Please add message to send the final delivery', 'taskbot');
            } else {
                $json['message']        = esc_html__('Submit revision', 'taskbot');
                $json['message_desc']   = esc_html__('Please add message to send the revision', 'taskbot');
            }

            wp_send_json($json);
        }

        $user_id 		   = $current_user->ID;
        taskbot_update_comments($user_id,$_POST);
    }
    add_action('wp_ajax_taskbot_task_activity', 'taskbot_task_activity');
}

/**
 * submit task rejection comment
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if( !function_exists( 'taskbot_submit_task_rejection_chat' ) ){
    function taskbot_submit_task_rejection_chat(){
        global $current_user, $taskbot_settings;
        $json = array();

        if ( !class_exists('WooCommerce') ) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Oops', 'taskbot');
            $json['message_desc'] = esc_html__('WooCommerce plugin needs to be installed.', 'taskbot');
            wp_send_json( $json );
        }
        //security check
        if (!wp_verify_nonce($_POST['security'], 'ajax_nonce')) {
            $json['type']       = 'error';
            $json['message']    = esc_html__('Oops', 'taskbot');
            $json['message_desc']    = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json($json);
        }
        //form validation
        if ( empty( $_POST['id'] ) || empty( $_POST['rejection_reason'] ) || empty( $_POST['activity_id']) ){
            $json['type'] = 'error';
            $json['message'] = esc_html__('Oops', 'taskbot');
            $json['message_desc'] = esc_html__('Description is required.', 'taskbot');
            wp_send_json($json);
        }
        // gather data
        $user_id            = $current_user->ID;
        $user_email         = $current_user->user_email;
        $user_type          = apply_filters('taskbot_get_user_type', $current_user->ID);
        $linked_profile_id  = taskbot_get_linked_profile_id($current_user->ID, '', $user_type);
        $user_name          = taskbot_get_username($linked_profile_id);
        $avatar             = apply_filters(
            'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $linked_profile_id), array('width' => 50, 'height' => 50)
        );
        $order_id       = !empty( $_POST['id'] ) ? intval($_POST['id']) : '';
        $activity_id    = !empty( $_POST['activity_id'] ) ? intval($_POST['activity_id'])      : '';
        $content        = !empty( $_POST['rejection_reason'] ) ? esc_textarea($_POST['rejection_reason']) : '';
        $time           = current_time('mysql');
        // prepare data array for insertion
        $data = array(
            'comment_post_ID' 		    => $order_id,
            'comment_author' 		    => $user_name,
            'comment_author_email' 	    => $user_email,
            'comment_author_url' 	    => 'http://',
            'comment_content' 		    => $content,
            'comment_type' 			    => 'activity_detail',
            'comment_parent' 		    => $activity_id,
            'user_id' 				      => $user_id,
            'comment_date' 			    => $time,
            'comment_approved' 		    => 1,
        );
        // insert data
        $comment_id = wp_insert_comment($data);
        if( !empty( $comment_id ) ) {
            update_comment_meta($comment_id, '_message_type', 'rejected');
            /* gather receiver's info
            *  get the receiver id, if buyer is posting a message then we call seller as receiver person or vise versa
            */
            $seller_id                  = get_post_meta( $order_id, 'seller_id', true);
            $receiver_id                = !empty($seller_id) ? intval($seller_id) : 0;
            $receiver_user_type         = 'sellers';
            $receiver_linked_profile_id = taskbot_get_linked_profile_id($receiver_id, '', $receiver_user_type);
            $receiver_name              = taskbot_get_username($receiver_linked_profile_id);
            $receiver_email 	          = get_userdata( $receiver_id )->user_email;
            /* gather receiver's info end */
            /* gather product/task info */
            $task_id      = get_post_meta( $order_id, 'task_product_id', true);
            $task_id      = !empty($task_id) ? $task_id : 0;
            $task_title   = get_the_title($task_id);
            $task_link    = get_permalink( $task_id );
            $order 		    = wc_get_order($order_id);
            $order_amount = $order->get_total();
            $order_amount = !empty($order_amount) ? $order_amount : 0;
            $login_url    = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
            /* gather product/task info end */
            /* prepare data and send email */
            $is_email_send = 'no';
            if (class_exists('Taskbot_Email_helper')) {
                if (class_exists('TaskbotTaskActivityNotify')) {
                    $email_helper = new TaskbotOrderStatuses();
                    $emailData    = array();
                    $emailData['buyer_name']      = $user_name;
                    $emailData['seller_name']     = $receiver_name;
                    $emailData['seller_email']    = $receiver_email;
                    $emailData['task_name']       = $task_title;
                    $emailData['task_link']       = $task_link;
                    $emailData['order_id']        = $order_id;
                    $emailData['order_amount']    = $order_amount;
                    $emailData['login_url']       = $login_url;
                    $emailData['buyer_comments']  = $content;
                    // send rejection email to seller
                    $email_helper->order_complete_request_decline_seller_email($emailData);
                    $is_email_send = 'yes';
                }
            }
            /* prepare data and send email end */
            /* prepare success response */
            $activity_page_link = Taskbot_Profile_Menu::taskbot_profile_menu_link('tasks-orders', $user_id, true, 'detail',$order_id);
            $activity_page_link = !empty($activity_page_link) ? $activity_page_link : '';
            $json['comment_id'] = $comment_id;
            $json['user_id']    = intval( $user_id );
            $json['type']       = 'success';
            $json['message']    = esc_html__('', 'taskbot');
            $json['message_desc']       = esc_html__('Your message has been sent.', 'taskbot');
            $json['content_message']    = esc_html( wp_strip_all_tags( $content ) );
            $json['user_name']          = $user_name;
            $json['date']               = date_i18n(get_option('date_format'), strtotime($time));
            $json['img']                = $avatar;
            $json['is_email_send'] 		= $is_email_send;
            $json['redirect_url'] 		= $activity_page_link;

            do_action('taskbot_submit_task_rejection_comments', $json);
            wp_send_json($json);
        }
        /* prepare error response */
        $json['type']           = 'error';
        $json['message']        = esc_html__('Oops', 'taskbot');
        $json['message_desc']   = esc_html__('Something went wrong please try again', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_submit_task_rejection_chat', 'taskbot_submit_task_rejection_chat');
}

/**
 * Saved user identity verification
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_save_verification')) {
    function taskbot_save_verification()
    {
        global $current_user;        
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }

        if( function_exists('taskbot_authenticate_user_validation') ){
            taskbot_authenticate_user_validation($_POST['id'],'both');
        }
        $profile_data   = !empty($_POST['data']) ? $_POST['data']: array();
        $validation_fields  = array(
            'name'                  => esc_html__('Name is required','taskbot'),
            'contact_number'        => esc_html__('Contact number is required','taskbot'),
            'verification_number'   => esc_html__('Verification number is required','taskbot'),
            'attachments'           => esc_html__('Please upload a document','taskbot'),
            'address'   			=> esc_html__('Address is required', 'taskbot'),
        );
        $json               = array();
        $json['type']       = 'error';
        $json['message'] 	= esc_html__('Identity information','taskbot');
        parse_str($profile_data,$profile_data);
        foreach($profile_data as $key => $value ){
            foreach($validation_fields as $data_key => $validation_field ){

                if( empty($profile_data[$data_key]) ){
                    $json['message_desc'] 		= $validation_field;
                    wp_send_json($json);
                }

            }
        }
       
        $identity_array			                        = array();
        $files          		                        = !empty($profile_data['attachments'] ) ? $profile_data['attachments'] : array();
		$identity_array['info']['name'] 				= !empty($profile_data['name']) ? sanitize_text_field($profile_data['name']) : '';
        $identity_array['info']['contact_number']  		= !empty($profile_data['contact_number']) ? sanitize_text_field($profile_data['contact_number']) : '';
		$identity_array['info']['verification_number']  = !empty($profile_data['verification_number'] ) ? sanitize_text_field($profile_data['verification_number']) : '';
		$identity_array['info']['address'] 				= !empty($profile_data['address'] ) ? sanitize_textarea_field($profile_data['address']) : '';
        
        if( !empty( $files ) ) {
			foreach ( $files as $key => $value ) {
				$identity_array[] = taskbot_temp_upload_to_media($value, 0);	
			}                
		}

        update_user_meta($current_user->ID,'verification_attachments',$identity_array);
		update_user_meta($current_user->ID,'identity_verified',0);
        $user_type		                = apply_filters('taskbot_get_user_type', $current_user->ID);
        $linked_profile                 = taskbot_get_linked_profile_id($current_user->ID, '', $user_type);
        $notifyData						= array();
		$notifyDetails					= array();
		$notifyData['receiver_id']		= $current_user->ID;
		$notifyData['type']				= 'account_verification_request';
		$notifyData['post_data']		= $notifyDetails;
        $notifyData['user_type']		= $user_type;
        $notifyData['linked_profile']	= $linked_profile;
        do_action('taskbot_notification_message', $notifyData );

        if (class_exists('Taskbot_Email_helper')) {
            if (class_exists('TaskbotIdentityVerification')) {
                $email_helper               = new TaskbotIdentityVerification();
				$username   	            = taskbot_get_username( $linked_profile );
                $emailData                  = array();
                $emailData['user_name']  	= $username;
				$emailData['user_link']  	= admin_url('users.php').'?s='.$current_user->user_email;
				$emailData['user_email']  	= $current_user->user_email;
				
                $email_helper->send_verification_to_admin($emailData);

            }
        }

        $json['type'] 		    = 'success';
        $json['message'] 		= esc_html__('Woohoo!', 'taskbot');
        $json['message_desc'] 	= esc_html__('Your identity documents have been updated', 'taskbot');
        wp_send_json( $json );

    }
    add_action( 'wp_ajax_taskbot_save_verification', 'taskbot_save_verification' );
}

/**
 * Cancelled user identity verification
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_cancel_verification_request')) {
    function taskbot_cancel_verification_request()
    {
        global $current_user;        
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        if( function_exists('taskbot_verify_token') ){
            taskbot_verify_token($_POST['security']);
        }
        
        update_user_meta($current_user->ID,'identity_verified',0);
		update_user_meta($current_user->ID,'verification_attachments','');
        $json['type'] 		    = 'success';
        $json['message'] 		= esc_html__('Woohoo!', 'taskbot');
        $json['message_desc'] 	= esc_html__('Your identity documents have been cancelled', 'taskbot');
        wp_send_json( $json );

    }
    add_action( 'wp_ajax_taskbot_cancel_verification_request', 'taskbot_cancel_verification_request' );
}
/**
 * @Import Users
 * @return {}
 */
if (!function_exists('taskbot_identity_verification')) {
	function  taskbot_identity_verification(){
		//security check
		$do_check = check_ajax_referer('ajax_nonce', 'security', false);
		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
			wp_send_json( $json );
		}
		$json		= array();
		$type		= !empty($_POST['type']) ? $_POST['type'] : '';
		$user_id	= !empty($_POST['user_id']) ? $_POST['user_id'] : '';
		if(!empty($type) && $type === 'approve'){
			update_user_meta($user_id,'identity_verified',1);
			
		} else{
			update_user_meta($user_id,'identity_verified',0);
			update_user_meta($user_id,'verification_attachments','');
			
		}
        $this_user		            = get_userdata($user_id);
        $user_type                  = apply_filters('taskbot_get_user_type', $user_id );
        $linked_profile             = taskbot_get_linked_profile_id($user_id, '', $user_type);
        $username   	            = taskbot_get_username( $linked_profile );
        if (class_exists('Taskbot_Email_helper')) {
            if (class_exists('TaskbotIdentityVerification')) {
                $email_helper               = new TaskbotIdentityVerification();
                $emailData                  = array();
                $notifyData					= array();
                $notifyDetails				= array();
                $emailData['user_name']  	= $username;
                $emailData['user_link']  	= get_the_permalink($linked_profile);
                $emailData['user_email']  	= $this_user->user_email;

                if(!empty($type) && $type === 'approve'){
                    $email_helper->approve_identity_verification($emailData);
                } else {
                    $reason	                    = !empty( $_POST['reason'] ) ? $_POST['reason'] : '';
                    $emailData['admin_message'] = $reason;
                    $email_helper->reject_identity_verification($emailData);
                }
            }
        }

        if(!empty($type) && $type === 'approve'){
            $notifyData['type']				= 'approve_verification_request';
        } else {
            $notifyData['type']			= 'reject_verification_request';
        }
        
        $notifyData['receiver_id']		= $user_id;
        $notifyData['post_data']		= $notifyDetails;
        $notifyData['user_type']		= $user_type;
        $notifyData['linked_profile']	= $linked_profile;
        do_action('taskbot_notification_message', $notifyData );

		$json['type']		= 'success';	
		$json['message']	= esc_html__('Settings have been updated','taskbot' );
		wp_send_json( $json );	
	}
	add_action('wp_ajax_taskbot_identity_verification', 'taskbot_identity_verification');	
}

/**
 * Duplicate project
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_duplicate_project')) {
    function taskbot_duplicate_project() {
        global $current_user;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }

        $post_id    = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $json       = array();
        
        if( !empty($post_id) ){
            taskbotDuplicateProject($post_id,$current_user->ID);
        } else {
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }
    }
    add_action('wp_ajax_taskbot_duplicate_project', 'taskbot_duplicate_project');
}

/**
 * Price calcuation
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_calculate_price')) {
    function taskbot_calculate_price() {
        global $current_user;

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }
        $post_id    = !empty($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $price      = !empty($_POST['price']) ? ($_POST['price']) : 0;
        $json       = array();
        if( !empty($post_id) ){
            taskbotPriceCalcuation($post_id,$price);
        } else {
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }
    }
    add_action('wp_ajax_taskbot_calculate_price', 'taskbot_calculate_price');
}

/**
 * Get third/last level categories in task search using Ajax on change second level category drop-down
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_get_states')) {
    function taskbot_get_states( )
    {
        if (class_exists('WooCommerce')) {
            $country            = !empty($_POST['country_val']) ? $_POST['country_val'] : '';
            $countries_obj   	= new WC_Countries();
            $states			 	= $countries_obj->get_states( $country );
            $states_html        = '';

            if( !empty($states) ){
                $states_html    .= '<option class="tb-state-option" value="">'.esc_html__('Select state','taskbot').'</option>';
                foreach($states as $key => $val ){
                    $states_html    .= '<option class="tb-state-option" value="'.esc_attr( $key ).'">'.esc_html($val).'</option>';
                }
            }
            $json['states']         = !empty($states) && is_array($states) ? count($states) : 0;
            $json['states_html']    = $states_html;
            $json['type']		    = 'success';	
            wp_send_json( $json );	
        }
    }
    add_action( 'wp_ajax_taskbot_get_states', 'taskbot_get_states' );
    add_action( 'wp_ajax_nopriv_taskbot_get_states', 'taskbot_get_states' );
}