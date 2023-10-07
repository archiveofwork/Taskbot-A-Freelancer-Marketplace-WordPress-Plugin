<?php

/**
 * Dispute summary
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbot_dispute_summary')) {
    function taskbot_dispute_summary()
    {

        $json   = array();
        ob_start();
        taskbot_get_template('admin-dashboard/dashboard-disputes-summary.php');

        $html   = ob_get_clean();
        $json['type']       = 'success';
        $json['html']       = $html;
        $json['message']    = esc_html__('Woohoo!', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_dispute_summary', 'taskbot_dispute_summary');
}


/**
 * Update earning
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_update_earning')) {
    function taskbot_update_earning()
    {
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $json               = array();
        $json['message']    = esc_html__('Earning request','taskbot');

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }

        $post_id        = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $post_status    = !empty($_POST['status']) ? sanitize_text_field($_POST['status']) : '';

        if( empty($post_id) || empty($post_status) ){
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }

        wp_update_post(array(
            'ID'    	    =>  intval($post_id),
            'post_status'   =>  $post_status
        ));

        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Earning status has been updated successfully', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_update_earning', 'taskbot_update_earning');
}
/**
 * Resolve project dispute
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_resolve_project_dispute')) {
    function  taskbot_resolve_project_dispute(){
        global $current_user,$woocommerce, $taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        //security check
        $do_check       = check_ajax_referer('ajax_nonce', 'security', false);
        $json			= array();
        if ( $do_check == false ) {
            $json['type']           = 'error';
            $json['message']        = esc_html__('Oops!', 'taskbot' );
            $json['message_desc']   = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json( $json );
        }

        $user_id 				= !empty($_POST['user_id']) ? (int)$_POST['user_id'] : '';
        $dispute_id 			= !empty($_POST['dispute_id']) ? (int)$_POST['dispute_id'] : '';
        $dispute_feedback 		= !empty($_POST['dispute-detail']) ? esc_textarea($_POST['dispute-detail']) : '';

        $validation_fields  = array(
            'dispute-detail'    => esc_html__('Dispute feedback is required', 'taskbot'),
            'user_id'           => esc_html__('Choose winning party', 'taskbot'),
        );

        foreach($validation_fields as $key => $validation_field ){
            if( empty($_POST[$key]) ){
                $json['type']           = 'error';
                $json['message']        = esc_html__('Oops!', 'taskbot' );
                $json['message_desc']   = $validation_field;
                wp_send_json($json);
            }
        }

        if (!empty($user_id) && !empty($dispute_feedback)) {

            $dispute_status = get_post_status($dispute_id);

            if($dispute_status == 'resolved' || $dispute_status == 'cancelled' || $dispute_status == 'refunded'){
                $json['type']           = 'error';
                $json['message']        = esc_html__('Oops!', 'taskbot' );
                $json['message_desc']   = esc_html__('Dispute has been resolved already.', 'taskbot');
                wp_send_json($json);
            }

            $linked_profile = taskbot_get_linked_profile_id($user_id);
            $post_type  	= get_post_type($linked_profile);
            $buyer_id		= get_post_meta($dispute_id, '_buyer_id', true);
            $seller_id		= get_post_meta($dispute_id, '_seller_id', true);
            $proposal_id	= get_post_meta($dispute_id, '_dispute_order', true);
            $project_id     = get_post_meta( $dispute_id, '_project_id',true );
            $temp_items     = !empty( $_POST['attachments'])   ? ($_POST['attachments']) : array();

            $project_type	= get_post_meta( $project_id, 'project_type', true );
            $project_type   = !empty($project_type) ? $project_type : '';

            //Upload files from temp folder to uploads
            $project_files = array();
            if( !empty( $temp_items ) ) {
                foreach ( $temp_items as $key => $file_temp_path ) {
                    $project_files[] = taskbot_temp_upload_to_activity_dir($file_temp_path, $proposal_id, true);
                }
            }

            $field  = array(
                'comment' => $dispute_feedback,
                'comment_parent' => 0,
            );

            $comment_id = taskbot_wp_insert_comment($field, $dispute_id);
            add_comment_meta($comment_id, 'message_files', $project_files);
            $order_total        = get_post_meta( $order_id, '_total_amount', true );
            $order_total        = !empty($order_total) ? ($order_total) : 0;
            $notifyData		    = array();
            $notifyDetails		= array();
            $wallet_amount      = 0;
            $notifyDetails      = array();
            $seller_profile_id  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id,'','sellers') : 0;
            $buyer_profile_id   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id,'','buyers') : 0;
            $loser_user_id      = 0;
            $loser_profile_id   = 0;
            $loser_post_type    = '';
            if( !empty($post_type) && $post_type == 'buyers') {
                $loser_user_id      = $seller_id;
                $loser_profile_id   = $seller_profile_id;
                $winner_user_id     = $buyer_id;
                $winner_profile_id  = $buyer_profile_id;
                $loser_post_type    = 'sellers';
                if( !empty($project_type) && $project_type ==='fixed' ){
                    $total_amount   = get_post_meta( $dispute_id, '_total_amount', true );
                    $order_ids      = get_post_meta( $dispute_id, '_order_ids', true );
                    if( !empty($order_ids) ){
                        foreach($order_ids as $order_id ){
                            $order          = wc_get_order($order_id);
                            $order->set_status('refunded');
                            $order->save();
                            update_post_meta($order->get_id(), '_task_status', 'cancelled');
                        }
                    }
                    if ( class_exists('WooCommerce') ) {
                        global $woocommerce;
                        $woocommerce->cart->empty_cart();
                        $wallet_amount              = $total_amount;
                        $product_id                 = taskbot_buyer_wallet_create();
                        $cart_meta                  = array();
                        $cart_meta['task_id']     	= $product_id;
                        $cart_meta['wallet_id']     = $product_id;
                        $cart_meta['product_name']  = get_the_title($product_id);
                        $cart_meta['price']         = $wallet_amount;
                        $cart_meta['payment_type']  = 'wallet';
    
                        $cart_data = array(
                            'wallet_id' 		=> $product_id,
                            'cart_data'     	=> $cart_meta,
                            'price'				=> $wallet_amount,
                            'payment_type'     	=> 'wallet'
                        );
                        $woocommerce->cart->empty_cart();
                        $cart_item_data = apply_filters('taskbot_resolve_project_dispute_cart_data',$cart_data);

                        WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
                        $new_order_id	= taskbot_place_order($buyer_id,'wallet',$dispute_id);
                        update_post_meta($new_order_id, '_fund_type', 'seller');
                        update_post_meta($new_order_id, '_task_dispute_type', 'project');
                        update_post_meta($new_order_id, '_task_dispute_order', $proposal_id);
                    }  
                } else {
                    do_action( 'taskbot_after_refund_dispute', $dispute_id,'buyers' );
                }
                update_post_meta($proposal_id, '_task_status', 'cancelled');
                              
                $notifyData['type']         = 'buyer_refunded';
            } else if( $post_type == 'sellers' ) {
                $loser_user_id      = $buyer_id;
                $loser_profile_id   = $buyer_profile_id;
                $winner_user_id     = $seller_id;
                $winner_profile_id  = $seller_profile_id;
                $loser_post_type    = 'buyers';
                $gmt_time       = current_time( 'mysql', 1 );
                if( !empty($project_type) && $project_type ==='fixed' ){
                    $order_ids      = get_post_meta( $dispute_id, '_order_ids', true );
                    if( !empty($order_ids) ){
                        foreach($order_ids as $order_id ){
                            update_post_meta($order_id, '_task_status', 'completed');
                            update_post_meta( $order_id, '_task_completed_time', $gmt_time );
                        }
                    }
                } else {
                    do_action( 'taskbot_after_refund_dispute', $dispute_id,'sellers' );
                }
                $notifyData['type']		= 'seller_refunded';
            }

            $args   = array(
                'ID'            => $dispute_id,
                'post_status'   => 'refunded',
            );
            wp_update_post($args);

            $proposal_args   = array(
                'ID'            => $proposal_id,
                'post_status'   => 'refunded',
            );
            wp_update_post($proposal_args);
            
            $project_id = get_post_meta( $proposal_id, 'project_id',true );
            if( !empty($project_id) ){
                taskbotUpdateProjectStatusOption($project_id,'refunded');
                update_post_meta( $proposal_id, '_hired_status',false );
            }
           update_post_meta($dispute_id, 'winning_party', $user_id);
           update_post_meta($dispute_id, 'dispute_status', 'resolved');
           update_post_meta($dispute_id, 'resolved_by', 'admin');

           $notifyDetails['seller_id']  	    = $seller_profile_id;
           $notifyDetails['buyer_id']  	        = $buyer_profile_id;
           $notifyDetails['user_id']  	        = $winner_user_id;
           $notifyDetails['project_id']  	    = $project_id;
           $notifyDetails['dispute_id']         = $dispute_id;
           $notifyDetails['dispute_comment']    = $dispute_feedback;

           $notifyData['receiver_id']		    = $user_id;
           $notifyData['linked_profile']	    = $winner_profile_id;
           $notifyData['user_type']		        = $post_type;
           $notifyData['type']		            = 'admin_resolved_project_dispute_winning';
           $notifyData['post_data']		        = $notifyDetails;
           do_action('taskbot_notification_message', $notifyData );
           /* Email to winner */
           $proj_dispu_fav_switch        = !empty($taskbot_settings['project_disputes_favour_winner_switch']) ? $taskbot_settings['project_disputes_favour_winner_switch'] : true;
           if(class_exists('Taskbot_Email_helper') && !empty($proj_dispu_fav_switch)){
                $emailData                      = array();
                $emailData['user_email']        = get_userdata( $user_id )->user_email;
                $emailData['user_name']         = taskbot_get_username($linked_profile);
                $emailData['admin_name']        = get_userdata($current_user->ID)->display_name;
                $emailData['dispute_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $user_id, true, 'dispute',$dispute_id);
                if (class_exists('TaskbotProjectDisputes')) {
                    $email_helper = new TaskbotProjectDisputes();
                    $email_helper->project_dispute_refunded_resolved_in_favour($emailData);
                }
            }

           $notifyData['receiver_id']		    = $loser_user_id;
           $notifyData['linked_profile']	    = $loser_profile_id;
           $notifyData['user_type']		        = $loser_post_type;
           $notifyData['type']		            = 'admin_resolved_project_dispute_loser';
           $notifyData['post_data']		        = $notifyDetails;
           do_action('taskbot_notification_message', $notifyData );
           /* Email to looser */
           $proj_dispu_against_switch        = !empty($taskbot_settings['project_disputes_against_looser_switch']) ? $taskbot_settings['project_disputes_against_looser_switch'] : true;
           if(class_exists('Taskbot_Email_helper') && !empty($proj_dispu_against_switch)){
                $emailData                      = array();
                $emailData['user_email']        = get_userdata( $loser_user_id )->user_email;
                $emailData['user_name']         = taskbot_get_username($loser_profile_id);
                $emailData['admin_name']        = get_userdata($current_user->ID)->display_name;
                $emailData['dispute_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $loser_user_id, true, 'dispute',$dispute_id);
                if (class_exists('TaskbotProjectDisputes')) {
                    $email_helper = new TaskbotProjectDisputes();
                    $email_helper->project_dispute_refunded_resolved_in_against($emailData);
                }
            }

           $json['type']		    = 'success';
           $json['message']         = esc_html__('Woohoo!', 'taskbot' );
           $json['post_status']		= $post_status;
           $json['message_desc']    = esc_html__('Dispute has been resolved', 'taskbot' );
           wp_send_json( $json );
       } else {
           $json['type']		    = 'error';
           $json['message']         = esc_html__('Oops!', 'taskbot' );
           $json['message_desc']    = esc_html__('Something wrong! please try it again.', 'taskbot' );
           wp_send_json( $json );
       }
   }
   add_action('wp_ajax_taskbot_resolve_project_dispute', 'taskbot_resolve_project_dispute');
}


/**
 * Resolve Dispute
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_resolve_dispute')) {
    function  taskbot_resolve_dispute(){
        global $current_user,$woocommerce, $taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        //security check
        $do_check = check_ajax_referer('ajax_nonce', 'security', false);
        $json			= array();
        if ( $do_check == false ) {
            $json['type']           = 'error';
            $json['message']        = esc_html__('Oops!', 'taskbot' );
            $json['message_desc']   = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json( $json );
        }

        $user_id 				= !empty($_POST['user_id']) ? (int)$_POST['user_id'] : '';
        $dispute_id 			= !empty($_POST['dispute_id']) ? (int)$_POST['dispute_id'] : '';
        $dispute_feedback 		= !empty($_POST['dispute-detail']) ? esc_textarea($_POST['dispute-detail']) : '';

        $validation_fields  = array(
            'dispute-detail'    => esc_html__('Dispute feedback is required', 'taskbot'),
            'user_id'           => esc_html__('Choose winning party', 'taskbot'),
        );

        foreach($validation_fields as $key => $validation_field ){
            if( empty($_POST[$key]) ){
                $json['type']           = 'error';
                $json['message']        = esc_html__('Oops!', 'taskbot' );
                $json['message_desc']   = $validation_field;
                wp_send_json($json);
            }
        }

        if (!empty($user_id) && !empty($dispute_feedback)) {

            $dispute_status = get_post_status($dispute_id);

            if($dispute_status == 'resolved' || $dispute_status == 'cancelled' || $dispute_status == 'refunded'){
                $json['type']           = 'error';
                $json['message']        = esc_html__('Oops!', 'taskbot' );
                $json['message_desc']   = esc_html__('Dispute has been resolved already.', 'taskbot');
                wp_send_json($json);
            }

            $linked_profile = taskbot_get_linked_profile_id($user_id);
            $post_type  	= get_post_type($linked_profile);
            $buyer_id		= get_post_meta($dispute_id, '_buyer_id', true);
            $seller_id		= get_post_meta($dispute_id, '_seller_id', true);
            $task_id		= get_post_meta($dispute_id, '_task_id', true);
            $order_id		= get_post_meta($dispute_id, '_dispute_order', true);
            $seller_id		= get_post_meta($order_id, '_seller_id', true);
            $temp_items     = !empty( $_POST['attachments'])   ? ($_POST['attachments']) : array();

            //Upload files from temp folder to uploads
            $project_files = array();
            if( !empty( $temp_items ) ) {
                foreach ( $temp_items as $key => $file_temp_path ) {
                    $project_files[] = taskbot_temp_upload_to_activity_dir($file_temp_path, $order_id, true);
                }
            }

            $field  = array(
                'comment' => $dispute_feedback,
                'comment_parent' => 0,
            );

            $comment_id = taskbot_wp_insert_comment($field, $dispute_id);
            add_comment_meta($comment_id, 'message_files', $project_files);
            $order_total        = get_post_meta( $order_id, '_order_total', true );

            $order_data         = get_post_meta( $order_id, 'cus_woo_product_data', true );
            $order_data         = !empty($order_data) ? $order_data : array();
    
            $seller_id          = !empty($order_data['seller_id']) ? intval($order_data['seller_id']) : 0;
            $buyer_id           = !empty($order_data['buyer_id']) ? intval($order_data['buyer_id']) : 0;

            $order_total        = !empty($order_total) ? ($order_total) : 0;
            $notifyData		    = array();
            $notifyDetails		= array();
            $wallet_amount      = 0;
            
            if( !empty($post_type) && $post_type == 'buyers') {

               $dispute_order   = get_post_meta( $dispute_id, '_dispute_order', true );
               $dispute_order   = !empty($dispute_order) ? intval($dispute_order) : 0;
               $send_by         = get_post_meta( $dispute_id, '_send_by', true );
               $send_by         = !empty($send_by) ? intval($send_by) : 0;

                if ( class_exists('WooCommerce') ) {
                   $order = wc_get_order($dispute_order);
                   $order->set_status('cancelled');
                   $order->save();

                   update_post_meta( $dispute_order, '_task_status', 'cancelled' );

                   $woocommerce->cart->empty_cart();
                   $wallet_amount              = $order_total;
                   $product_id                 = taskbot_buyer_wallet_create();
                   $user_id			           = $send_by;
                   $cart_meta                  = array();
                   $cart_meta['wallet_id']     = $product_id;
                   $cart_meta['product_name']  = get_the_title($product_id);
                   $cart_meta['price']         = $wallet_amount;
                   $cart_meta['payment_type']  = 'wallet';
                   $cart_meta['task_id']       = $task_id;

                   $cart_data = array(
                       'wallet_id' 		=> $product_id,
                       'cart_data'     	=> $cart_meta,
                       'price'			=> $wallet_amount,
                       'payment_type'   => 'wallet'
                   );
                   $woocommerce->cart->empty_cart();
                   $cart_item_data = apply_filters('taskbot_resolve_dispute_cart_data',$cart_data);
                   WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
                   $new_order_id    = taskbot_place_order($user_id,'wallet',$dispute_id);
                    update_post_meta($new_order_id, '_fund_type', 'seller');
                    update_post_meta($new_order_id, '_task_dispute_order', $order_id);

                   $post_status    = 'refunded';

                } else {
                    $json['type']            = 'error';
                    $json['message']         = esc_html__('Oops!', 'taskbot' );
                    $json['message_desc']    = esc_html__('Please install WooCommerce plugin to process this order', 'taskbot');
                    wp_send_json($json);
                }

                $notifyData['type']         = 'buyer_refunded';
            } else if( $post_type == 'sellers' ) {
                $gmt_time   = current_time( 'mysql', 1 );
                update_post_meta( $order_id, '_task_status' , 'completed');
                update_post_meta( $order_id, '_task_completed_time', $gmt_time );
                $post_status            = 'refunded';
                $notifyData['type']		= 'seller_refunded';
            }
            $seller_profile_id      = taskbot_get_linked_profile_id($seller_id, '', 'sellers');
            $buyer_profile_id       = taskbot_get_linked_profile_id($buyer_id, '', 'buyers');

            $notifyDetails['task_id']           = $task_id;
            $notifyDetails['post_link_id']  	= $task_id;
            $notifyDetails['dispute_comment']	= $dispute_feedback;
            $notifyDetails['order_amount']  	= !empty($post_type) && $post_type === 'buyers' ? $wallet_amount : $order_total;
            $notifyDetails['order_id']          = $order_id;
            $notifyDetails['dispute_id']        = $dispute_id;
            $notifyDetails['seller_id']         = $seller_profile_id;
            $notifyDetails['buyer_id']          = $buyer_profile_id;

            $notifyData['receiver_id']		    = !empty($post_type) && $post_type === 'sellers' ? $seller_id : $buyer_id;
            $notifyData['linked_profile']	    = !empty($post_type) && $post_type === 'sellers' ? $seller_profile_id : $buyer_profile_id;
            $notifyData['user_type']		    = $post_type;
            $notifyData['post_data']		    = $notifyDetails;
            do_action('taskbot_notification_message', $notifyData );
            if(!empty($post_type) && $post_type === 'sellers'){
                $notifyDetails['order_amount']  	= $wallet_amount;
                $notifyData['post_data']		    = $notifyDetails;
                $notifyData['type']		            = 'buyer_cancelled_refunded';
                $notifyData['receiver_id']		    = $buyer_id;
                $notifyData['linked_profile']	    = $buyer_profile_id;
                $notifyData['user_type']		    = 'buyers';
                do_action('taskbot_notification_message', $notifyData );
            } else if(!empty($post_type) && $post_type === 'buyers'){
                $notifyDetails['order_amount']  	= $order_total;
                $notifyData['post_data']		    = $notifyDetails;
                $notifyData['type']		            = 'seller_cancelled_refunded';
                $notifyData['receiver_id']		    = $seller_id;
                $notifyData['linked_profile']	    = $seller_profile_id;
                $notifyData['user_type']		    = 'sellers';
                do_action('taskbot_notification_message', $notifyData );
            }
            
           wp_update_post(array(
               'ID'    	    =>  intval($dispute_id),
               'post_status'   =>  $post_status
           ));

           update_post_meta($dispute_id, 'winning_party', $user_id);
           update_post_meta($dispute_id, 'dispute_status', 'resolved');
           update_post_meta($dispute_id, 'resolved_by', 'admin');

            /* Send Email on task canceled */
            if(class_exists('Taskbot_Email_helper')){

                if(class_exists('TaskbotDisputeStatuses')){
                    $login_url           = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
                    /* set data for email */
                    $task_name           = get_the_title($task_id);
                    $task_link           = get_permalink( $task_id );
                    /* getting seller name and email */
                    $seller_id           = get_post_field( 'post_author', $task_id );
                    $seller_profile_id   = taskbot_get_linked_profile_id($seller_id);
                    $seller_name 		 = taskbot_get_username($seller_profile_id);
                    $seller_email 	      = get_userdata( $seller_id )->user_email;

                    /* getting buyer name */
                    $buyer_profile_id   = taskbot_get_linked_profile_id($buyer_id);
                    $buyer_name         = taskbot_get_username($buyer_profile_id);
                    $buyer_email        = get_userdata( $buyer_id )->user_email;

                    $emailData = array();
                    $emailData['task_name']            = $task_name;
                    $emailData['task_link']            = $task_link;
                    $emailData['order_id']             = $order_id;
                    $emailData['order_amount']         = $order_total;
                    $emailData['login_url']            = $login_url;
                    $emailData['notification_type']    = 'noty_dispute_resolved';
                    $emailData['sender_id']            = $seller_id; //seller id
                    $emailData['receiver_id']          = $buyer_id; //buyer id
                    $email_helper = new TaskbotDisputeStatuses();
                    
                    if( $user_id == $seller_id ) {
                        $emailData['seller_email']         = $seller_email;
                        $emailData['seller_name']          = $seller_name;
                        $email_helper->dispute_seller_resolved($emailData);
                    } else {
                        $emailData['seller_email']         = $seller_email;
                        $emailData['seller_name']          = $seller_name;
                        $email_helper->dispute_seller_cancelled($emailData);
                    }

                    if( $user_id == $buyer_id ) {
                        $emailData['buyer_email']         = $buyer_email;
                        $emailData['buyer_name']          = $buyer_name;
                        $email_helper->dispute_buyer_resolved($emailData);
                    } else {
                        $emailData['buyer_email']         = $buyer_email;
                        $emailData['buyer_name']          = $buyer_name;
                        $email_helper->dispute_buyer_cancelled($emailData);
                    }

                    do_action('noty_push_notification', $emailData);
                }
            }

           $json['type']		    = 'success';
           $json['message']         = esc_html__('Woohoo!', 'taskbot' );
           $json['post_status']		= $post_status;
           $json['message_desc']    = esc_html__('Dispute has been resolved', 'taskbot' );
           wp_send_json( $json );
       } else {
           $json['type']		    = 'error';
           $json['message']         = esc_html__('Oops!', 'taskbot' );
           $json['message_desc']    = esc_html__('Something wrong! please try it again.', 'taskbot' );
           wp_send_json( $json );
       }

   }
   add_action('wp_ajax_taskbot_resolve_dispute', 'taskbot_resolve_dispute');
}

/**
 * Reject task
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_rejected_task')) {
    function taskbot_rejected_task()
    {
        global $taskbot_settings;

        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        $json               = array();
        $json['message']    = esc_html__('Task rejected','taskbot');

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }

        $post_id        = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $feedback        = !empty($_POST['feedback']) ? $_POST['feedback'] : '';

        $service_status             = !empty( $taskbot_settings['service_status'] ) ? $taskbot_settings['service_status'] : 'publish';
        $resubmit_service_status    = !empty($taskbot_settings['resubmit_service_status']) ? $taskbot_settings['resubmit_service_status'] : 'no';


        if( empty($post_id) || !is_admin() ){
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }

        wp_update_post(array(
            'ID'    	    =>  intval($post_id),
            'post_status'   =>  'rejected'
        ));
        
        if( !empty($service_status) && $service_status === 'pending' && !empty($resubmit_service_status) && $resubmit_service_status === 'yes'){
            update_post_meta( $post_id, '_post_task_status', 'rejected' );
        }

        /* gather email data */
        $seller_id          = get_post_field( 'post_author', $post_id );
        $seller_profile_id  = taskbot_get_linked_profile_id($seller_id);
        $seller_name 		    = taskbot_get_username($seller_profile_id);
        $seller_email 	    = get_userdata( $seller_id )->user_email;

        if (class_exists('Taskbot_Email_helper')) {
            $emailData = array();
            $emailData['seller_name']       = $seller_name;
            $emailData['seller_email']      = $seller_email;
            $emailData['task_name']         = get_the_title($post_id);
            $emailData['task_link']         = get_permalink( $post_id );
            $emailData['admin_feedback']    = $feedback;
            update_post_meta( $post_id, '_rejection_reason', $feedback );

            if($taskbot_settings['email_task_rej_seller'] == true){
                if (class_exists('TaskbotTaskStatuses')) {
                    $email_helper = new TaskbotTaskStatuses();
                    $email_helper->reject_task_seller_email($emailData);
                }
            }
            
            $notifyData						= array();
            $notifyDetails					= array();
            $notifyDetails['task_id']     = $post_id;
            $notifyDetails['post_link_id']= $post_id;
            $notifyDetails['admin_feedback']= $feedback;
            $notifyDetails['seller_id']   = $seller_profile_id;
            $notifyData['receiver_id']		= $seller_id;
            $notifyData['type']			    = 'task_rejected';
            $notifyData['linked_profile']	= $seller_profile_id;
            $notifyData['user_type']		= 'sellers';
            $notifyData['post_data']		= $notifyDetails;
            do_action('taskbot_notification_message', $notifyData );
        }

        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Task has been rejected', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_rejected_task', 'taskbot_rejected_task');
}

/**
 * Approved task
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_publish_task')) {
    function taskbot_publish_task()
    {
        global $taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        
        $json               = array();
        $json['message']    = esc_html__('Task approved','taskbot');

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }

        $post_id        = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        if( empty($post_id) || !is_admin() ){
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }

        wp_update_post(array(
            'ID'    	    =>  intval($post_id),
            'post_status'   =>  'publish'
        ));

      /* gather email data */
      $seller_id          = get_post_field( 'post_author', $post_id );
      $seller_profile_id  = taskbot_get_linked_profile_id($seller_id);
      $seller_name 		    = taskbot_get_username($seller_profile_id);
      $seller_email 	    = get_userdata( $seller_id )->user_email;

      if (class_exists('Taskbot_Email_helper')) {
        $blogname = get_option( 'blogname' );
        $emailData = array();
        $emailData['seller_name']       = $seller_name;
        $emailData['seller_email']      = $seller_email;
        $emailData['task_name']         = get_the_title($post_id);
        $emailData['task_link']         = get_permalink( $post_id );

        if($taskbot_settings['email_task_rej_seller'] == true){

          if (class_exists('TaskbotTaskStatuses')) {
            $email_helper = new TaskbotTaskStatuses();
            $email_helper->approved_task_seller_email($emailData);
            do_action('notification_message', $emailData );
          }
          $notifyData					= array();
          $notifyDetails				= array();
          $notifyDetails['task_id']     = $post_id;
          $notifyDetails['post_link_id']= $post_id;
          $notifyDetails['seller_id']   = $seller_profile_id;
          $notifyData['receiver_id']	= $seller_id;
          $notifyData['type']			= 'task_approved';
          $notifyData['linked_profile']	= $seller_profile_id;
          $notifyData['user_type']		= 'sellers';
          $notifyData['post_data']		= $notifyDetails;
          do_action('taskbot_notification_message', $notifyData );
        }

      }

        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Task has been approved', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_publish_task', 'taskbot_publish_task');
}

/**
 * Approved project
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_publish_project')) {
    function taskbot_publish_project()
    {
        global $taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        $json               = array();
        $json['message']    = esc_html__('Project published','taskbot');

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }

        $post_id        = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        if( empty($post_id) || !is_admin() ){
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }

        wp_update_post(array(
            'ID'    	    =>  intval($post_id),
            'post_status'   =>  'publish'
        ));

        $gmt_time		           = current_time( 'mysql', 1 );
        update_post_meta( $post_id, '_post_project_status','publish' );
        update_post_meta( $post_id, '_publish_datetime', $gmt_time );

        // Notification to buyer for task publish
        $buyer_id                           = get_post_field( 'post_author', $post_id );
        $buyer_profile_id                   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id, '', 'buyers') : '';
        $notifyDetails                      = array();
        $notifyDetails['project_id']  	    = $post_id;
        $notifyData['post_data']		    = $notifyDetails;
        $notifyData['type']		            = 'approve_project';
        $notifyData['receiver_id']		    = $buyer_id;
        $notifyData['linked_profile']	    = $buyer_profile_id;
        $notifyData['user_type']		    = 'buyers';
        do_action('taskbot_notification_message', $notifyData );
        
        /* Email on project approved */
        $project_approve_switch        = !empty($taskbot_settings['email_project_approve']) ? $taskbot_settings['email_project_approve'] : true;
        if(class_exists('Taskbot_Email_helper') && !empty($project_approve_switch)){
            $emailData                      = array();
			$emailData['buyer_email']        = get_userdata($buyer_id)->user_email;
            $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
            $emailData['project_title']     = get_the_title($post_id);
            $emailData['project_link']      = get_the_permalink($post_id);
            if (class_exists('TaskbotProjectCreation')) {
				$email_helper = new TaskbotProjectCreation();
				$email_helper->approved_project_buyer_email($emailData);
			}
        }

        $project_meta       = get_post_meta( $post_id, 'tb_project_meta',true );
        $invitation         = !empty($project_meta['invitation']) ? $project_meta['invitation'] : array();
        if( !empty($invitation) ){
            foreach($invitation as $profile_id => $value ){
                $status = !empty($status) ? $status : '';
                if( empty($status) || $status === 'pending'){
                    taskbotSellerProjectInvitation($post_id,$profile_id);
                }
            }
        }
        
        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Project has been approved and public for the seller', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_publish_project', 'taskbot_publish_project');
}

/**
 * Reject task
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_rejected_project')) {
    function taskbot_rejected_project()
    {
        global $taskbot_settings;

        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $json               = array();
        $json['message']    = esc_html__('Project rejection','taskbot');

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }

        $post_id                    = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $feedback                   = !empty($_POST['feedback']) ? $_POST['feedback'] : '';
        $project_status             = !empty($taskbot_settings['project_status']) ? $taskbot_settings['project_status'] : '';
        $resubmit_project_status    = !empty($taskbot_settings['resubmit_project_status']) ? $taskbot_settings['resubmit_project_status'] : 'no';
        $reject_email_switch        = !empty($taskbot_settings['email_project_rej_buyer']) ? $taskbot_settings['email_project_rej_buyer'] : true;


        if( empty($post_id) || !is_admin() ){
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }

        wp_update_post(array(
            'ID'    	    =>  intval($post_id),
            'post_status'   =>  'rejected'
        ));
        if( !empty($project_status) && $project_status === 'pending' && !empty($resubmit_project_status) && $resubmit_project_status === 'yes'){
            update_post_meta( $post_id, '_post_project_status', 'rejected' );
        }

        $buyer_id                           = get_post_field( 'post_author', $post_id );
        $buyer_profile_id                   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id, '', 'buyers') : '';
        // Notification buyer

        $notifyDetails                      = array();
        $notifyDetails['project_id']  	    = $post_id;
        $notifyDetails['admin_feedback']  	= $feedback;
        $notifyData['post_data']		    = $notifyDetails;
        $notifyData['type']		            = 'rejected_project';
        $notifyData['receiver_id']		    = $buyer_id;
        $notifyData['linked_profile']	    = $buyer_profile_id;
        $notifyData['user_type']		    = 'buyers';
        do_action('taskbot_notification_message', $notifyData );

        /* Email to buyer */
        if(class_exists('Taskbot_Email_helper') && !empty($reject_email_switch)){
            $emailData                      = array();
            $emailData['buyer_email']       = get_userdata($buyer_id)->user_email;
            $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
            $emailData['project_title']     = get_the_title($post_id );
            $emailData['project_link']      = get_the_permalink($post_id);
            if (class_exists('TaskbotProjectCreation')) {
				$email_helper = new TaskbotProjectCreation();
				$email_helper->reject_project_buyer_email($emailData);
			}
        }
        
        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Project has been rejected', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_rejected_project', 'taskbot_rejected_project');
}

/**
 * Remove task
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_remove_task')) {
    function taskbot_remove_task()
    {
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        $json               = array();
        $json['message']    = esc_html__('Remove task','taskbot');

        if (function_exists('taskbot_verify_admin_token')) {
            taskbot_verify_admin_token($_POST['security']);
        }

        $post_id        = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        if( empty($post_id) || !is_admin() ){
            $json['type']           = 'error';
			$json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
			wp_send_json( $json );
        }

        wp_trash_post($post_id);

        $json['type']           = 'success';
        $json['message_desc']   = esc_html__('Task has been removed successfully', 'taskbot');
        wp_send_json($json);

    }
    add_action('wp_ajax_taskbot_remove_task', 'taskbot_remove_task');
}

/**
 * Change color
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
require_once(TASKBOT_DIRECTORY . '/libraries/scssphp/scss.inc.php');
if (!function_exists('taskbot_change_colors')) {
    function  taskbot_change_colors(){
        global $taskbot_settings;
        $primary_color      =  !empty($taskbot_settings['tb_primary_color']) ? $taskbot_settings['tb_primary_color'] : '';
        $secondary_color    =  !empty($taskbot_settings['tb_secondary_color']) ? $taskbot_settings['tb_secondary_color'] : '';
        $tertiary_color     =  !empty($taskbot_settings['tb_tertiary_color']) ? $taskbot_settings['tb_tertiary_color'] : '';
        
        $compiler = new ScssPhp\ScssPhp\Compiler();
        $source_scss    = TASKBOT_DIRECTORY . '/public/scss/style.scss';
        $scssContents   = file_get_contents($source_scss);
        $import_path    = TASKBOT_DIRECTORY . '/public/scss';
        $compiler->addImportPath($import_path);
        $target_css = TASKBOT_DIRECTORY . '/public/css/style.css';
        $variables = [
            '$theme-color'          => $primary_color,
            '$theme-color-dark'     => $tertiary_color,
            '$secondary-color'      => $secondary_color,
        ];
        $compiler->setVariables($variables);

        $css = $compiler->compile($scssContents);
        if (!empty($css) && is_string($css)) {
            file_put_contents($target_css, $css);
        }
        $json                   = array();
        $json['type']           = 'success';
        $json['message']        = esc_html__('Taskbot colors', 'taskbot');
        $json['message_desc']   = esc_html__('Your site is successfully update taskbot colors', 'taskbot');
        wp_send_json($json);
    }
    add_action('wp_ajax_taskbot_change_colors', 'taskbot_change_colors');
}