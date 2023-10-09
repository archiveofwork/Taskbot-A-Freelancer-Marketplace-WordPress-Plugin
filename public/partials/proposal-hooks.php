<?php

/**
 * Provide a proposal hooks
 *
 * This file is used to markup the proposal aspects of the plugin.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot/public/partials
 */
if (!class_exists('TaskbotProposalFunctions')) {
    class TaskbotProposalFunctions
    {
        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @param      string    $taskbot      The name of the plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct()
        {
            add_action('wp_ajax_taskbot_submit_proposal', array($this,'taskbot_submit_proposal'));
            add_action('wp_ajax_taskbot_decline_proposal', array($this,'taskbot_decline_proposal'));
            add_action('wp_ajax_taskbot_project_activities', array($this,'taskbot_project_activities'));
            add_action('wp_ajax_taskbot_update_milestone', array($this,'taskbot_update_milestone'));
            add_action('wp_ajax_taskbot_add_milestone',  array($this,'taskbot_add_milestone'));
            add_action('wp_ajax_taskbot_complete_project_order', array($this,'taskbot_complete_project_order'));
            add_action('wp_ajax_taskbot_submit_project_dispute',  array($this,'taskbot_submit_project_dispute'));
            add_action('wp_ajax_taskbot_submit_project_dispute_reply',  array($this,'taskbot_submit_project_dispute_reply'));
        }

        /**
         * Add milestone
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_add_milestone(){
            global $current_user;
            $json               = array();
            if( function_exists('taskbot_is_demo_site') ) { 
                taskbot_is_demo_site();
            }
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            $post_data  = !empty($_POST['data']) ?  $_POST['data'] : array();
            parse_str($post_data,$data);

            taskbotAddMilestone($current_user->ID,$data);
        }

        /**
         * Project dispute reply
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_submit_project_dispute_reply() {
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
    
            taskbotProjectDisputeComments($current_user->ID,$data);
            
        }

        /**
         * Create dispute
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */

        public function taskbot_submit_project_dispute() {
            global $current_user;
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
            taskbotProjectDispute($current_user->ID,$data);
        }

        /**
         * Complete proposal
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_complete_project_order(){
            global $current_user;
            $json               = array();
            if( function_exists('taskbot_is_demo_site') ) { 
                taskbot_is_demo_site();
            }
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            taskbotCompleteProposal($current_user->ID,$_POST);
        }

        /**
         * Update milestone
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_update_milestone(){
            global $current_user;
            $json               = array();
            if( function_exists('taskbot_is_demo_site') ) { 
                taskbot_is_demo_site();
            }
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            taskbotUpdateMilestoneStatus($current_user->ID,$_POST);
        }

        /**
         * Decline proposal
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_project_activities(){
            global $current_user;
            $json               = array();
            if( function_exists('taskbot_is_demo_site') ) { 
                taskbot_is_demo_site();
            }
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            taskbotProjectActivities($current_user->ID,$_POST);
        }

        /**
         * Decline proposal
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_decline_proposal(){
            global $current_user;
            $json               = array();
            if( function_exists('taskbot_is_demo_site') ) { 
                taskbot_is_demo_site();
            }
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            
            $detail         = !empty($_POST['detail']) ? sanitize_textarea_field($_POST['detail']) : '';
            $proposal_id    = !empty($_POST['id']) ? intval($_POST['id']) : 0;
            taskbotDeclineProposal($current_user->ID,$proposal_id,$detail);
        }

        /**
         * Proposal submition
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_submit_proposal(){
            global $current_user;
            $json               = array();
            if( function_exists('taskbot_is_demo_site') ) { 
                taskbot_is_demo_site();
            }
            if( function_exists('taskbot_verify_token') ){
                taskbot_verify_token($_POST['security']);
            }
            $project_id     = !empty($_POST['project_id']) ? intval($_POST['project_id']) : 0;
            $proposal_id    = !empty($_POST['proposal_id']) ? intval($_POST['proposal_id']) : 0;
            $status         = !empty($_POST['status']) ? ($_POST['status']) : '';
            $proposal_data  = !empty($_POST['data']) ? $_POST['data']: array();
            parse_str($proposal_data,$proposal_data);
            taskbotSubmitProposal($current_user->ID,$project_id,$status,$proposal_data,$proposal_id);
            
        }
    }
    new TaskbotProposalFunctions();
}

/**
 * update project dispute comments
 *
*/
if( !function_exists('taskbotProjectDisputeComments') ){
    function taskbotProjectDisputeComments($user_id=0,$request=array(),$type=''){
        global $taskbot_settings, $current_user;
        $get_user_type	    = apply_filters('taskbot_get_user_type', $user_id );
        $dispute_id         = !empty($request['dispute_id'])?intval($request['dispute_id']):'';
        $parent_comment_id  = !empty($request['parent_comment_id'])?intval($request['parent_comment_id']):0;
        $dispute_comment    = !empty($request['dispute_comment'])?esc_textarea($request['dispute_comment']):'';
        $action_type        = !empty($request['action_type'])?esc_textarea($request['action_type']):'reply';
        $field  = array(
            'comment' 			=> $dispute_comment,
            'comment_parent' 	=> $parent_comment_id,
        );
        
        $comment_id         = taskbot_wp_insert_comment($field, $dispute_id, $user_id, $type);
        $seller_id	        = get_post_meta( $dispute_id, '_seller_id', true );
        $buyer_id	        = get_post_meta( $dispute_id, '_buyer_id', true );
        $dispute_order	    = get_post_meta( $dispute_id, '_dispute_order', true );
        $project_id         = get_post_meta( $dispute_id, '_project_id',true );
        $seller_id          = !empty($seller_id) ? intval($seller_id) : 0;
        $buyer_id           = !empty($buyer_id) ? intval($buyer_id) : 0;
        $dispute_order      = !empty($dispute_order) ? intval($dispute_order) : 0;
        $project_id         = !empty($project_id) ? intval($project_id) : 0;

        $seller_profile_id  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id,'','sellers') : 0;
        $buyer_profile_id   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id,'','buyers') : 0;
        $seller_profile_id  = !empty($seller_profile_id) ? intval($seller_profile_id) : 0;
        $buyer_profile_id   = !empty($buyer_profile_id) ? intval($buyer_profile_id) : 0;

        if( !empty($action_type) && $action_type === 'reply' ){
            $sender_id              = $reciver_id = 0;
            $reciver_profile_id     = $sender_profile_id = 0;
            if( !empty($get_user_type) && $get_user_type === 'sellers' ){
                $sender_id              = $seller_id;
                $sender_profile_id      = $seller_profile_id;
                $reciver_id             = $buyer_id;
                $reciver_profile_id     = $buyer_profile_id;
            } else if( !empty($get_user_type) && $get_user_type === 'buyers' ){
                $sender_id              = $buyer_id;
                $sender_profile_id      = $buyer_profile_id;
                $reciver_id             = $seller_id;
                $reciver_profile_id     = $seller_profile_id;
            };
            $json['message_desc']   = esc_html__('You have successfully reply on this dispute.','taskbot');
            // Notification to reciver about reply
            if( !empty($get_user_type) && $get_user_type === 'administrator' ){
                $notifyDetails                      = array();
                $notifyDetails['seller_id']  	    = $seller_profile_id;
                $notifyDetails['buyer_id']  	    = $buyer_profile_id;
                $notifyDetails['user_id']  	        = $user_id;
                $notifyDetails['project_id']  	    = $project_id;
                $notifyDetails['dispute_id']        = $dispute_id;
                $notifyDetails['dispute_comment']   = $dispute_comment;
                $notifyDetails['project_id']        = $project_id;

                $notifyData['receiver_id']		    = $seller_id;
                $notifyData['linked_profile']	    = $seller_profile_id;
                $notifyData['user_type']		    = $get_user_type;
                $notifyData['type']		            = 'project_admin_dispute_comment';
                $notifyData['post_data']		    = $notifyDetails;
                do_action('taskbot_notification_message', $notifyData );
                /* Admin Email to seller on dispute comment */
                $project_dispute_admin_coment_switch    = !empty($taskbot_settings['project_dispute_admin_comment_switch']) ? $taskbot_settings['project_dispute_admin_comment_switch'] : true;
                if(class_exists('Taskbot_Email_helper') && !empty($project_dispute_admin_coment_switch)){
                    $emailData                      = array();
                    $emailData['user_email']        = get_userdata( $seller_id )->user_email;
                    $emailData['user_name']         = taskbot_get_username($seller_profile_id);
                    $emailData['admin_name']        = get_userdata( $current_user->ID )->user_email;
                    $emailData['dispute_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $seller_id, true, 'dispute',$dispute_id);
                    $emailData['dispute_comment']   = $dispute_comment;
                    if (class_exists('TaskbotProjectDisputes')) {
                        $email_helper = new TaskbotProjectDisputes();
                        $email_helper->project_dispute_admin_commnet_to_seller_buyer($emailData);
                    }
                }

                $notifyData['receiver_id']		    = $buyer_id;
                $notifyData['linked_profile']	    = $buyer_profile_id;
                $notifyData['user_type']		    = $get_user_type;
                $notifyData['type']		            = 'project_admin_dispute_comment';
                $notifyData['post_data']		    = $notifyDetails;
                do_action('taskbot_notification_message', $notifyData );
                /* Admin email to buyer on dispute comment */
                $project_dispute_admin_coment_switch    = !empty($taskbot_settings['project_dispute_admin_comment_switch']) ? $taskbot_settings['project_dispute_admin_comment_switch'] : true;
                if(class_exists('Taskbot_Email_helper') && !empty($project_dispute_admin_coment_switch)){
                    $emailData                      = array();
                    $emailData['user_email']        = get_userdata( $buyer_id )->user_email;
                    $emailData['user_name']         = taskbot_get_username($buyer_profile_id);
                    $emailData['admin_name']        = get_userdata( $current_user->ID )->user_email;
                    $emailData['dispute_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $buyer_id, true, 'dispute',$dispute_id);
                    $emailData['dispute_comment']   = $dispute_comment;
                    if (class_exists('TaskbotProjectDisputes')) {
                        $email_helper = new TaskbotProjectDisputes();
                        $email_helper->project_dispute_admin_commnet_to_seller_buyer($emailData);
                    }
                }

            } else {
                $notifyDetails                      = array();
                $notifyDetails['sender_id']  	    = $sender_profile_id;
                $notifyDetails['project_id']  	    = $project_id;
                $notifyDetails['dispute_id']        = $dispute_id;
                $notifyDetails['dispute_comment']   = $dispute_comment;
                $notifyDetails['project_id']        = $project_id;
                $notifyData['receiver_id']		    = $reciver_id;
                $notifyData['linked_profile']	    = $reciver_profile_id;
                $notifyData['user_type']		    = $get_user_type;
                $notifyData['type']		            = 'project_refund_comments';
                $notifyData['post_data']		    = $notifyDetails;
                do_action('taskbot_notification_message', $notifyData );
                /* Email on dispute comments to each other(sender & receiver) */
                $project_dispute_user_coment_switch    = !empty($taskbot_settings['project_dispute_user_comment_switch']) ? $taskbot_settings['project_dispute_user_comment_switch'] : true;
                if(class_exists('Taskbot_Email_helper') && !empty($project_dispute_user_coment_switch)){
                    $emailData                      = array();
                    $emailData['receiver_email']    = get_userdata( $reciver_id )->user_email;
                    $emailData['sender_name']       = taskbot_get_username($sender_profile_id);
                    $emailData['receiver_name']     = taskbot_get_username($reciver_profile_id);
                    $emailData['dispute_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $reciver_id, true, 'dispute',$dispute_id);
                    $emailData['dispute_comment']   = $dispute_comment; 
                    
                    if (class_exists('TaskbotProjectDisputes')) {
                        $email_helper = new TaskbotProjectDisputes();
                        $email_helper->project_dispute_user_commnet_to_eachother($emailData);
                    }
                }

            }
        } else if( !empty($action_type) && $action_type === 'refund' ){
            $project_type	= get_post_meta( $project_id, 'project_type', true );
            $project_type   = !empty($project_type) ? $project_type : '';
            if( !empty($project_type) && $project_type === 'fixed' ){
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
                update_post_meta($dispute_order, '_task_status', 'cancelled');
                if ( class_exists('WooCommerce') ) {
                    global $woocommerce;
                    if( !empty($type) && $type === 'mobile' ){
                        check_prerequisites($user_id);
                    }
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
                    $cart_item_data = apply_filters('taskbot_project_dispute_comment_cart_data',$cart_data);
                    WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
                    $new_order_id	= taskbot_place_order($buyer_id,'wallet',$dispute_id);
                    update_post_meta($new_order_id, '_fund_type', 'seller');
                    update_post_meta($new_order_id, '_task_dispute_type', 'project');
                    update_post_meta($new_order_id, '_task_dispute_order', $dispute_order);

                    update_post_meta($dispute_id, 'dispute_status', 'resolved');
                    update_post_meta($dispute_id, 'winning_party', $buyer_id);
                    update_post_meta($dispute_id, 'resolved_by', 'sellers');
                    
                }
            } else {
                do_action( 'taskbot_after_refund_dispute', $dispute_id,'buyers',$type );
            }
            $args   = array(
                'ID'            => $dispute_id,
                'post_status'   => 'refunded',
            );
            wp_update_post($args);
            $proposal_args   = array(
                'ID'            => $dispute_order,
                'post_status'   => 'refunded',
            );
            wp_update_post($proposal_args);
            $project_id = get_post_meta( $dispute_order, 'project_id',true );
            if( !empty($project_id) ){
                taskbotUpdateProjectStatusOption($project_id,'refunded');
                update_post_meta( $dispute_order, '_hired_status',false );
            }
            $json['message_desc']   = esc_html__('You have successfully refunded this dispute.','taskbot');
            // Notification to buyer for refund
            $notifyDetails                      = array();
            $notifyDetails['seller_id']  	    = $seller_profile_id;
            $notifyDetails['buyer_id']  	    = $buyer_profile_id;
            $notifyDetails['project_id']  	    = $project_id;
            $notifyDetails['dispute_id']        = $dispute_id;
            $notifyDetails['project_id']        = $project_id;
            $notifyData['receiver_id']		    = $buyer_id;
            $notifyData['linked_profile']	    = $buyer_profile_id;
            $notifyData['user_type']		    = $get_user_type;
            $notifyData['type']		            = 'project_refund_approved';
            $notifyData['post_data']		    = $notifyDetails;
            do_action('taskbot_notification_message', $notifyData );
            /* Email on project refund approved */
            $project_refund_approve_switch        = !empty($taskbot_settings['refund_project_request_approved_buyer_switch']) ? $taskbot_settings['refund_project_request_approved_buyer_switch'] : true;
            if(class_exists('Taskbot_Email_helper') && !empty($project_refund_approve_switch)){
                $emailData                      = array();
                $emailData['buyer_email']        = get_userdata( $buyer_id )->user_email;
                $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                $emailData['dispute_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $buyer_id, true, 'dispute',$dispute_id);
                if (class_exists('TaskbotProjectDisputes')) {
                    $email_helper = new TaskbotProjectDisputes();
                    $email_helper->project_dispute_refund_approve_by_seller($emailData);
                }
            }

            
        } else if( !empty($action_type) && $action_type === 'decline' ){    
            $args   = array(
                'ID'            => $dispute_id,
                'post_status'   => 'declined',
            );
            wp_update_post($args);
            $json['message_desc']   = esc_html__('You have successfully decline this dispute.','taskbot');
            // Notification to buyer for decline
            $notifyDetails                      = array();
            $notifyDetails['seller_id']  	    = $seller_profile_id;
            $notifyDetails['buyer_id']  	    = $buyer_profile_id;
            $notifyDetails['project_id']  	    = $project_id;
            $notifyDetails['dispute_id']        = $dispute_id;
            $notifyDetails['project_id']        = $project_id;
            $notifyData['receiver_id']		    = $buyer_id;
            $notifyData['linked_profile']	    = $buyer_profile_id;
            $notifyData['user_type']		    = $get_user_type;
            $notifyData['type']		            = 'project_refund_decline';
            $notifyData['post_data']		    = $notifyDetails;
            do_action('taskbot_notification_message', $notifyData );
            /* Email on project refund decline */
            $project_refund_decline_switch        = !empty($taskbot_settings['refund_project_request_decline_buyer_switch']) ? $taskbot_settings['refund_project_request_decline_buyer_switch'] : true;
            if(class_exists('Taskbot_Email_helper') && !empty($project_refund_decline_switch)){
                $emailData                      = array();
                $emailData['buyer_email']        = get_userdata( $buyer_id )->user_email;
                $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                $emailData['dispute_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $buyer_id, true, 'dispute',$dispute_id);
                if (class_exists('TaskbotProjectDisputes')) {
                    $email_helper = new TaskbotProjectDisputes();
                    $email_helper->project_dispute_refund_decline_by_seller($emailData);
                }
            }

        }
        $json['type']           = 'success';
       
        if( empty($type) ){
            wp_send_json( $json );
        } else {
            return $json;
        }
    }
}

/**
 * create a dispute
 *
 */
if( !function_exists('taskbotProjectDispute') ){
    function taskbotProjectDispute($user_id=0,$request=array(),$type=''){
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');
        if( !empty($user_id) && !empty($request['proposal_id'])){
            $proposal_id        = !empty($request['proposal_id']) ? intval($request['proposal_id']) : 0;
            $dispute_issue      = !empty($request['dispute_issue']) ? esc_html($request['dispute_issue']):'';
            $dispute_details    = !empty($request['dispute-details']) ? sanitize_textarea_field($request['dispute-details']):'';

            $dispute_is         = get_post_meta( $proposal_id, 'dispute', true);
            if( !empty( $dispute_is ) && $dispute_is == 'yes' ){
                $json['type']           = "error";
                $json['message_desc']   = esc_html__("You have already submitted the refund request against this task.", 'taskbot');
                if( empty($type) ){
                    wp_send_json( $json );
                } else {
                    return $json;
                }
            }
            $fields	= array(
                'dispute_issue'     => esc_html__('Please select the dispute reason','taskbot'),
                'dispute-details' 	=> esc_html__('Please add dispute details','taskbot'),
                'dispute_terms' 	=> esc_html__('You must select terms and conditions','taskbot'),
            );
            foreach( $fields as $key => $item ){
                if( empty( $request[$key] ) ){
                    $json['type'] 	        = "error";
                    $json['message_desc']   = $item;
                    if( empty($type) ){
                        wp_send_json( $json );
                    } else {
                        return $json;
                    }
                    
                }
            }
            $proposal_meta          = get_post_meta( $proposal_id, 'proposal_meta', true );
            $proposal_meta          = !empty($proposal_meta) ? $proposal_meta : array();

            $project_id             = get_post_meta( $proposal_id, 'project_id',true );
            $project_id             = !empty($project_id) ? intval($project_id) : 0;

            $buyer_id               = get_post_field( 'post_author', $project_id );
            $buyer_id               = !empty($buyer_id) ? intval($buyer_id) : 0;

            $seller_id               = get_post_field( 'post_author', $proposal_id );
            $seller_id               = !empty($seller_id) ? intval($seller_id) : 0;

            $gmt_time		        = current_time( 'mysql', 1 );
            $user_type              = apply_filters('taskbot_get_user_type', $user_id );
            $linked_profile         = taskbot_get_linked_profile_id($user_id,'',$user_type);
            $username   	        = taskbot_get_username( $linked_profile );
            $dispute_title      	= get_the_title($project_id).' #'. $proposal_id;
            $post_status            = !empty($user_type) && $user_type === 'sellers' ? 'disputed' : 'publish';
            $dispute_post  = array(
                'post_title'    => wp_strip_all_tags( $dispute_title ),
                'post_status'   => $post_status,
                'post_content'  => $dispute_details,
                'post_author'   => $user_id,
                'post_type'     => 'disputes',
            );
            $dispute_id     = wp_insert_post( $dispute_post );
            $post_type      = get_post_type($proposal_id);
            update_post_meta( $dispute_id, '_dispute_type',$post_type );
            update_post_meta( $dispute_id, '_sender_type', $user_type);
            update_post_meta( $dispute_id, '_send_by', $user_id);
            update_post_meta( $dispute_id, '_seller_id', $seller_id);
            update_post_meta( $dispute_id, '_buyer_id', $buyer_id);
            update_post_meta( $dispute_id, '_dispute_key', $dispute_issue);

            update_post_meta( $dispute_id, '_dispute_order', $proposal_id);
            update_post_meta( $dispute_id, '_proposal_id', $proposal_id);
            update_post_meta( $dispute_id, '_project_id', $project_id);
            update_post_meta( $proposal_id, 'dispute', 'yes');
            update_post_meta( $proposal_id, 'dispute_id', $dispute_id);
            $proposal_type          = !empty($proposal_meta['proposal_type']) ? $proposal_meta['proposal_type'] : '';
            $order_ids              = array();
            $total_amount           = 0;
            if( !empty($proposal_type) && $proposal_type === 'fixed'){
                $order_id   = get_post_meta( $proposal_id, 'order_id',true );
                if( !empty($order_id) ){
                    $order_ids[]    = $order_id;
                }
                update_post_meta( $order_id, 'dispute', 'yes');
                update_post_meta( $order_id, 'dispute_id', $dispute_id);
                $wallet_amount  = get_post_meta( $order_id, '_wallet_amount', true );
                $wallet_amount  = !empty($wallet_amount) ? $wallet_amount : 0;
                $order          = wc_get_order($order_id);
                $get_total      = !empty($order) ? $order->get_total() : 0;
                $total_amount   = $wallet_amount + $get_total;
            } else if( !empty($proposal_type) && $proposal_type === 'milestone'){
                $milestone  = !empty($proposal_meta['milestone']) ? $proposal_meta['milestone'] : array();
                if( !empty($milestone) ){
                    foreach( $milestone as $key => $value ){
                        $status     = !empty($value['status']) ? $value['status'] : '';
                        $order_id   = !empty($value['order_id']) ? intval($value['order_id']) : 0;
                        if( !empty($order_id) && !empty($status) && in_array($status, array('hired','decline','requested'))){
                            $order_ids[]    = $order_id;
                            update_post_meta( $order_id, 'dispute', 'yes');
                            update_post_meta( $order_id, 'dispute_id', $dispute_id);
                            $wallet_amount  = get_post_meta( $order_id, '_wallet_amount', true );
                            $wallet_amount  = !empty($wallet_amount) ? $wallet_amount : 0;
                            $order          = wc_get_order($order_id);
                            $get_total      = !empty($order) ? $order->get_total() : 0;
                            $total_amount   = $total_amount+$wallet_amount + $get_total;
                        }
                    }
                }
            } else if( empty($proposal_type) ){
                $order_id   = get_post_meta( $proposal_id, 'order_id',true );
                if( !empty($order_id) ){
                    $order_ids[]    = $order_id;
                }
                update_post_meta( $order_id, 'dispute', 'yes');
                update_post_meta( $order_id, 'dispute_id', $dispute_id);
                $wallet_amount  = get_post_meta( $order_id, '_wallet_amount', true );
                $wallet_amount  = !empty($wallet_amount) ? $wallet_amount : 0;
                $order          = wc_get_order($order_id);
                $get_total      = !empty($order) ? $order->get_total() : 0;
                $total_amount   = $wallet_amount + $get_total;
            } 
            
            update_post_meta( $dispute_id, '_total_amount',$total_amount );
            update_post_meta( $dispute_id, '_order_ids',$order_ids );
            $proposal_post = array(
                'ID'           	=> $proposal_id,
                'post_status'   => 'disputed'
            );
            wp_update_post( $proposal_post );
            $buyer_id                           = get_post_field( 'post_author', $project_id );
            $buyer_profile_id                   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id, '', 'buyers') : '';
            $seller_id                          = get_post_field( 'post_author', $proposal_id );
            $seller_profile_id                  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id, '', 'sellers') : '';
            $notifyDetails                      = array();
            $notifyDetails['buyer_id']  	    = $buyer_profile_id;
            $notifyDetails['seller_id']  	    = $seller_profile_id;
            $notifyDetails['project_id']  	    = $project_id;
            $notifyDetails['proposal_id']  	    = $proposal_id;
            $notifyDetails['dispute_id']        = $dispute_id;
            $notifyDetails['dispute_order_amount']  	    = $total_amount;
            if(!empty($user_type) && $user_type === 'sellers'){
                // seller add dispute
                // $notifyData['receiver_id']		    = $buyer_id;
                // $notifyData['linked_profile']	    = $buyer_profile_id;
                // $notifyData['user_type']		        = 'buyers';
                /// Add admin emial for creating a dispute request

            } else {
                // buyer add dispute
                // Notification to seller on refund request
                $notifyDetails['buyer_comments']    = $dispute_details;
                $notifyData['receiver_id']		    = $seller_id;
                $notifyData['linked_profile']	    = $seller_profile_id;
                $notifyData['user_type']		    = 'sellers';
                $notifyData['type']		            = 'project_refund_request';
                $notifyData['post_data']		    = $notifyDetails;
                do_action('taskbot_notification_message', $notifyData );
                /* Project refund request */
                if(class_exists('Taskbot_Email_helper')){
                    $emailData                      = array();
                    $emailData['seller_email']      = get_userdata( $seller_id )->user_email;
                    $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                    $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                    $emailData['project_title']     = get_the_title($project_id);
                    
                    if (class_exists('TaskbotProjectDisputes')) {
                        $email_helper = new TaskbotProjectDisputes();
                        /* email to seller */
                        $emailData['dispute_link']  = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $seller_id, true, 'dispute',$dispute_id);
                        $email_helper->dispute_project_request_seller_email($emailData);
                    }
                }
            }
            $json['type']           = 'success';
            $json['message_desc']   = esc_html__('You have successfully submite dispute request for this proposal.','taskbot');
            if( empty($type) ){
                wp_send_json( $json );
            } else {
                return $json;
            }
        }
        if( empty($type) ){
            wp_send_json( $json );
        } else {
            return $json;
        }
    }
}

/**
 * Complete project
 *
 */
if( !function_exists('taskbotCompleteProposal') ){
    function taskbotCompleteProposal($user_id=0,$request='',$type=''){
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');
        if( !empty($user_id) && !empty($request['proposal_id'])){
            $gmt_time		= current_time( 'mysql', 1 );
            $proposal_id    = !empty($request['proposal_id']) ? intval($request['proposal_id']) : 0;
            $rating_type    = !empty($request['type']) ? sanitize_text_field($request['type']) : '';
            $rating_details = !empty($request['rating_details']) ? sanitize_textarea_field($request['rating_details']) : '';
            
            $user_details       = get_user_by( 'ID', $user_id );
            $user_email         = !empty($user_details->user_email) ? $user_details->user_email : '';
            $seller_id          = get_post_field( 'post_author', $proposal_id );
            $linked_profile     = taskbot_get_linked_profile_id($user_id, '', 'buyers');
            $user_profiel_name  = taskbot_get_username($linked_profile);
            
            if( !empty($rating_type) && $rating_type == 'rating' ){
                $rating_details = !empty($request['rating_details']) ? sanitize_textarea_field($request['rating_details']) : '';
                $rating_title   = !empty($request['rating_title']) ? sanitize_text_field($request['rating_title']) : '';
                $rating         = !empty($request['rating']) ? sanitize_text_field($request['rating']) : '';
                $comment_id = wp_insert_comment(array(
                    'comment_post_ID'      => $proposal_id,
                    'comment_author'       => $user_profiel_name,
                    'comment_author_email' => $user_email,
                    'comment_author_url'   => '',
                    'comment_content'      => $rating_details,
                    'comment_type'         => 'rating',
                    'comment_parent'       => 0,
                    'user_id'              => $user_id,
                    'comment_date'         => $gmt_time,
                    'comment_approved'     => 1,
                ));
                update_comment_meta($comment_id, 'rating', intval($rating));
                update_comment_meta($comment_id, '_project_order', intval($proposal_id));
                update_comment_meta($comment_id, '_rating_title', ($rating_title));
                update_comment_meta($comment_id, 'seller_id', intval($seller_id));
                update_comment_meta($comment_id, 'verified', 1);
                update_post_meta($proposal_id, '_rating_id', $comment_id);
                update_post_meta($proposal_id, '_rating', intval($rating));
                

            } 
            $proposal_post = array(
                'ID'           	=> $proposal_id,
                'post_status'   => 'completed'
            );
            wp_update_post( $proposal_post );
            if( !empty($rating_type) && $rating_type == 'rating' ){
                taskbot_seller_rating($seller_id);
            }
            $proposal_meta  = get_post_meta( $proposal_id, 'proposal_meta',true);
            $proposal_type  = !empty($proposal_meta['proposal_type']) ? $proposal_meta['proposal_type'] : '';
            if( !empty($proposal_type) && $proposal_type === 'milestone') {
                $allmilestone = !empty($proposal_meta['milestone']) ? $proposal_meta['milestone'] : array();
                foreach($allmilestone as $key => $value ){
                    $status     = !empty($value['status']) ? $value['status']  :'';
                    $order_id   = !empty($value['order_id']) ? intval($value['order_id'])  : 0;
                    if( !empty($order_id) && !empty($status) && $status === 'completed' ){
                        update_post_meta( $order_id, '_task_status' , 'completed');
                        update_post_meta( $order_id, '_task_completed_time', $gmt_time );
                    }
                }
            } else if( !empty($project_type) && $project_type === 'fixed'){
                $order_id   = get_post_meta( $proposal_id, 'order_id',true );
                update_post_meta( $order_id, '_task_status' , 'completed');
                update_post_meta( $order_id, '_task_completed_time', $gmt_time );
            } else if( empty($project_type)){
                $order_id   = get_post_meta( $proposal_id, 'order_id',true );
                update_post_meta( $order_id, '_task_status' , 'completed');
                update_post_meta( $order_id, '_task_completed_time', $gmt_time );
            }
            update_post_meta( $proposal_id, '_task_status' , 'completed');
            update_post_meta( $proposal_id, '_task_completed_time', $gmt_time );
            $project_id = get_post_meta( $proposal_id, 'project_id',true );
            $project_id = !empty($project_id) ? intval($project_id) : 0;
            
            taskbotUpdateProjectStatusOption($project_id,'completed');
            update_post_meta( $proposal_id, '_hired_status',false );
            do_action( 'taskbot_after_complete_proposal', $proposal_id,$type );
            $json['type']           = 'success';
            $json['message_desc']   = esc_html__('You have successfully completed this proposal.','taskbot');
            if( empty($type) ){
                wp_send_json( $json );
            } else {
                return $json;
            }
        }
    }
}

/**
 * Update Milestone status
 *
 */
if( !function_exists('taskbotUpdateMilestoneStatus') ){
    function taskbotUpdateMilestoneStatus($user_id=0,$request='',$type=''){
        global $taskbot_settings;
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');
        if( !empty($user_id) && !empty($request['id']) && !empty($request['status']) && !empty($request['key'])){
            $status             = !empty($request['status']) ? $request['status'] : '';
            $proposal_id        = !empty($request['id']) ? intval($request['id']) : 0;
            $proposal_meta	    = get_post_meta( $proposal_id, 'proposal_meta',true);
            $proposal_meta	    = !empty($proposal_meta) ? $proposal_meta : array();
            $milestone_id       = !empty($request['key']) ? $request['key'] : '';
            $order_id           = !empty($proposal_meta['milestone'][$milestone_id]['order_id']) ? intval($proposal_meta['milestone'][$milestone_id]['order_id']) : 0;
            $project_id         = get_post_meta( $proposal_id, 'project_id',true);
            $project_id         = !empty($project_id) ? intval($project_id) : 0;
            $buyer_id           = get_post_field( 'post_author', $project_id );

            $buyer_profile_id                   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id, '', 'buyers') : '';
            $seller_id                          = get_post_field( 'post_author', $proposal_id );
            $seller_profile_id                  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id, '', 'sellers') : '';
            $notifyDetails                      = array();
            $notifyData                         = array();
            $notifyDetails['buyer_id']  	    = $buyer_profile_id;
            $notifyDetails['seller_id']  	    = $seller_profile_id;
            $notifyDetails['project_id']  	    = $project_id;
            $notifyDetails['proposal_id']  	    = $proposal_id;
            $notifyDetails['milestone_id']  	= $milestone_id;
            $notifyData['post_data']		    = $notifyDetails;
            if(!empty($proposal_meta['milestone'][$milestone_id])){
                $proposal_meta['milestone'][$milestone_id]['status']  = $status;
            }
            $time       = current_time('mysql');
            if( $status === 'completed'){
                if(!empty($proposal_meta['milestone'][$milestone_id])){
                    $proposal_meta['milestone'][$milestone_id]['completed_date']  = $time;
                    update_post_meta( $order_id, '_task_status' , 'completed');
                    update_post_meta( $order_id, '_task_completed_time', $time );
                    $notifyData['receiver_id']		    = $seller_id;
                    $notifyData['linked_profile']	    = $seller_profile_id;
                    $notifyData['user_type']		    = 'sellers';
                    $notifyData['type']		            = 'milestone_completed';
                    do_action('taskbot_notification_message', $notifyData );

                    /* Email to seller on milestone complete */
                    $milestone_complete_switch        = !empty($taskbot_settings['email_milestone_complete_seller']) ? $taskbot_settings['email_milestone_complete_seller'] : true;
                    if(class_exists('Taskbot_Email_helper') && !empty($milestone_complete_switch)){
                        $emailData                      = array();
                        $emailData['seller_email']      = get_userdata( $seller_id )->user_email;
                        $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                        $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                        $emailData['project_title']     = get_the_title($project_id );
                        $emailData['milestone_title']   = !empty($proposal_meta['milestone'][$milestone_id]['title']) ? $proposal_meta['milestone'][$milestone_id]['title'] : '';
                        $emailData['project_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $seller_id, true, 'activity', $proposal_id);
                        
                        if (class_exists('TaskbotMilestones')) {
                            $email_helper = new TaskbotMilestones();
                            $email_helper->milestone_complete_seller_email($emailData);
                        }
                    }
                }
            } else if( $status === 'decline'){
                if(empty($request['decline_reason'])){
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__('Decline reason is required','taskbot');
                    if( empty($type) ){
                        wp_send_json( $json );
                    }
                } else {
                    if(!empty($proposal_meta['milestone'][$milestone_id])){
                        $proposal_meta['milestone'][$milestone_id]['decline_reason']  = $request['decline_reason'];
                        $proposal_meta['milestone'][$milestone_id]['decline_date']    = $time;
                        $notifyData['receiver_id']		    = $seller_id;
                        $notifyData['linked_profile']	    = $seller_profile_id;
                        $notifyData['user_type']		    = 'sellers';
                        $notifyData['type']		            = 'milestone_decline';
                        do_action('taskbot_notification_message', $notifyData );

                        /* milestone decline email */
                        $milestone_decline_switch        = !empty($taskbot_settings['email_milestone_decline_seller']) ? $taskbot_settings['email_milestone_decline_seller'] : true;
                        if(class_exists('Taskbot_Email_helper') && !empty($milestone_decline_switch)){
                            $emailData                      = array();
                            $emailData['seller_email']      = get_userdata( $seller_id )->user_email;
                            $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                            $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                            $emailData['project_title']     = get_the_title($project_id );
                            $emailData['milestone_title']   = !empty($proposal_meta['milestone'][$milestone_id]['title']) ? $proposal_meta['milestone'][$milestone_id]['title'] : '';
                            $emailData['project_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $seller_id, true, 'activity', $proposal_id);
                            
                            if (class_exists('TaskbotMilestones')) {
                                $email_helper = new TaskbotMilestones();
                                $email_helper->milestone_decline_seller_email($emailData);
                            }

                        }
                    }
                }
            } else if( $status === 'requested'){
                $notifyData['receiver_id']		    = $buyer_id;
                $notifyData['linked_profile']	    = $buyer_profile_id;
                $notifyData['user_type']		    = 'buyers';
                $notifyData['type']		            = 'milestone_request';
                do_action('taskbot_notification_message', $notifyData );
                /* Emial to buyer on milestone approval request */
                $milestone_approval_req_switch        = !empty($taskbot_settings['email_req_milestone_approval_buyer']) ? $taskbot_settings['email_req_milestone_approval_buyer'] : true;
                if(class_exists('Taskbot_Email_helper') && !empty($milestone_approval_req_switch)){
                    $emailData                      = array();
                    $emailData['buyer_email']        = get_userdata( $buyer_id )->user_email;
                    $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                    $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                    $emailData['project_title']     = get_the_title($project_id );
                    $emailData['milestone_title']   = !empty($proposal_meta['milestone'][$milestone_id]['title']) ? $proposal_meta['milestone'][$milestone_id]['title'] : '';
                    $emailData['milestone_link']    = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $buyer_id, true, 'activity',$proposal_id);
                    
                    if (class_exists('TaskbotMilestones')) {
                        $email_helper = new TaskbotMilestones();
                        $email_helper->approval_milestone_req_buyer_email($emailData);
                    }
                }

            }
            update_post_meta( $order_id, '_post_project_status', $status );
            update_post_meta( $proposal_id, 'proposal_meta', $proposal_meta );  

            $json['type']           = 'success';
            $json['message_desc']   = esc_html__('You have successfully update milestone','taskbot');
            if( empty($type) ){
                wp_send_json( $json );
            } else {
                return $json;
            }
        }
        if( empty($type) ){
            wp_send_json( $json );
        } else {
            return $json;
        }
    }
}

/**
 * Decline proposal
 *
 */
if( !function_exists('taskbotProjectActivities') ){
    function taskbotProjectActivities($user_id=0,$request='',$type=''){
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');
        if( !empty($user_id) && !empty($request['id'])){
            if( empty($request['details']) ){
                $json['type']           = 'error';
                $json['message_desc']   = esc_html__('Activity detail field is required','taskbot');
                if( empty($type) ){
                    wp_send_json( $json );
                }
            } else {
                $proposal_id 	= !empty( $request['id'] ) ? intval($request['id']) : '';
                $temp_items     = !empty( $request['attachments']) ? ($request['attachments']) : array();
                $content 	    = !empty( $request['details'] ) ? esc_textarea($request['details']) : '';

                $user_type         = apply_filters('taskbot_get_user_type', $user_id);
                $linked_profile_id = taskbot_get_linked_profile_id($user_id, '', $user_type);
                $user_name         = taskbot_get_username($linked_profile_id);
                
                $project_files = array();
                if( !empty( $temp_items ) && empty($type) ) {
                    foreach ( $temp_items as $key => $file_temp_path ) {
                        $project_files[] = taskbot_temp_upload_to_activity_dir($file_temp_path, $order_id,true);
                    }
                } elseif( !empty($type) && $type === 'mobile' ) {
                    $total_documents 		= !empty($request['document_size']) ? $request['document_size'] : 0;
                    if( !empty( $_FILES ) && $total_documents != 0 ){
                        require_once( ABSPATH . 'wp-admin/includes/file.php');
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        require_once( ABSPATH . 'wp-includes/pluggable.php');
                        
                        for ($x = 1; $x <= $total_documents; $x++) {
                            $document_files 	= $_FILES['documents_'.$x];
                            $uploaded_image  	= wp_handle_upload($document_files, array('test_form' => false));
                            $project_files[]    = taskbot_temp_upload_to_activity_dir($uploaded_image['url'], $order_id,true);
                        }
                    }
                }

                $userdata   = !empty($user_id)  ? get_userdata( $user_id ) : array();
                $user_email = !empty($userdata) ? $userdata->user_email : '';
                $project_id = get_post_meta( $proposal_id, 'project_id',true);
                $project_id = !empty($project_id) ? intval($project_id) : 0;

                $time       = current_time('mysql');
                // prepare data array for insertion
                $data = array(
                    'comment_post_ID' 		    => $proposal_id,
                    'comment_author' 		    => $user_name,
                    'comment_author_email' 	    => $user_email,
                    'comment_author_url' 	    => 'http://',
                    'comment_content' 		    => $content,
                    'comment_type' 			    => 'activity_detail',
                    'comment_parent' 		    => 0,
                    'user_id' 				    => $user_id,
                    'comment_date' 			    => $time,
                    'comment_approved' 		    => 1,
                );

                // insert data
                $comment_id = wp_insert_comment(apply_filters('project_proposal_activity_data_filter', $data));
                if( !empty( $project_files )) {
                    add_comment_meta($comment_id, 'message_files', $project_files);
                }
                
                $buyer_id           = get_post_field( 'post_author', $project_id );
                $seller_id          = get_post_field( 'post_author', $proposal_id );
                add_comment_meta($comment_id, 'user_type', $user_type);
                add_comment_meta($comment_id, 'project_id', $project_id);
                add_comment_meta($comment_id, 'buyer_id', $buyer_id);
                add_comment_meta($comment_id, 'seller_id', $seller_id);

                $seller_profile_id      = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id,'','sellers') : 0;
                $buyer_profile_id       = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id,'','buyers') : 0;
                $sender_id              = 0;
                $reciver_id             = 0;
                $reciver_profile_id     = 0;
                $sender_profile_id      = 0;
                if( !empty($user_type) && $user_type === 'sellers' ){
                    $sender_id              = $seller_id;
                    $sender_profile_id      = $seller_profile_id;
                    $reciver_id             = $buyer_id;
                    $reciver_profile_id     = $buyer_profile_id;
                } else if( !empty($user_type) && $user_type === 'buyers' ){
                    $sender_id              = $buyer_id;
                    $sender_profile_id      = $buyer_profile_id;
                    $reciver_id             = $seller_id;
                    $reciver_profile_id     = $seller_profile_id;
                }
                $notifyDetails                      = array();
                $notifyDetails['sender_id']  	    = $sender_profile_id;
                $notifyDetails['activity_comment']  = $content;
                $notifyDetails['project_id']        = $project_id;
                $notifyDetails['proposal_id']       = $proposal_id;
                $notifyData['receiver_id']		    = $reciver_id;
                $notifyData['linked_profile']	    = $reciver_profile_id;
                $notifyData['user_type']		    = $user_type;
                $notifyData['type']		            = 'project_activity_comments';
                $notifyData['post_data']		    = $notifyDetails;
                do_action('taskbot_notification_message', $notifyData );
                /* Email to receiver on project activity */
                $user_comment_switch        = !empty($taskbot_settings['project_dispute_user_comment_switch']) ? $taskbot_settings['project_dispute_user_comment_switch'] : true;
                if(class_exists('Taskbot_Email_helper') && !empty($user_comment_switch)){
                    $emailData                      = array();
                    $emailData['reciever_email']    = get_userdata( $reciver_id )->user_email;
                    $emailData['sender_name']       = taskbot_get_username($sender_profile_id);
                    $emailData['receiver_name']     = taskbot_get_username($reciver_profile_id);
                    $emailData['project_title']     = get_the_title($project_id);
                    $emailData['project_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $reciver_id, true, 'activity',$proposal_id);
                    if (class_exists('TaskbotProjectCreation')) {
                        $email_helper = new TaskbotProjectCreation();
                        $email_helper->project_activity_receiver_email($emailData);
                    }
                }

                
                $json['type']           = 'success';
                $json['message_desc']   = esc_html__('You have successfully add activity','taskbot');
                if( empty($type) ){
                    $json['redirect_url']   = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $user_id, true, 'listing');
                    wp_send_json( $json );
                }
            }
        }
        if( empty($type) ){
            wp_send_json( $json );
        }
    }
}
/**
 * Decline proposal
 *
 */
if( !function_exists('taskbotDeclineProposal') ){
    function taskbotDeclineProposal($user_id=0, $proposal_id=0, $detail='', $type=''){
        global $taskbot_settings;
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');
        if( !empty($user_id) && !empty($proposal_id)){
            if( empty($detail) ){
                $json['type']           = 'error';
                $json['message_desc']   = esc_html__('Decline detail field is required','taskbot');
                if( empty($type) ){
                    wp_send_json( $json );
                }  else {
                    return $json;
                }
            } else {
                $tb_post_data                   = array();
                $tb_post_data['ID']             = $proposal_id;
                $tb_post_data['post_status']    = 'decline';
                wp_update_post( $tb_post_data );
                update_post_meta( $proposal_id, 'decline_detail',$detail);
                $project_id                         = get_post_meta( $proposal_id, 'project_id',true );
                $buyer_id                           = !empty($project_id) ? get_post_field( 'post_author', $project_id ) : 0;
                $buyer_profile_id                   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id, '', 'buyers') : '';
                $seller_id                          = get_post_field( 'post_author', $proposal_id );
                $seller_profile_id                  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id, '', 'sellers') : '';
                $notifyDetails                      = array();
                $notifyDetails['buyer_id']  	    = $buyer_profile_id;
                $notifyDetails['seller_id']  	    = $seller_profile_id;
                $notifyDetails['project_id']  	    = $project_id;
                $notifyDetails['proposal_id']  	    = $proposal_id;
                $notifyData['post_data']		    = $notifyDetails;
                $notifyData['type']		            = 'rejected_proposal';
                $notifyData['receiver_id']		    = $seller_id;
                $notifyData['linked_profile']	    = $seller_profile_id;
                $notifyData['user_type']		    = 'sellers';
                do_action('taskbot_notification_message', $notifyData );
                /// Add proposal decline email
                $proposal_decline_switch        = !empty($taskbot_settings['email_proposal_decline_seller']) ? $taskbot_settings['email_proposal_decline_seller'] : true;
                if(class_exists('Taskbot_Email_helper') && !empty($proposal_decline_switch)){
                    $emailData                      = array();
                    $emailData['seller_email']      = get_userdata($seller_id)->user_email;
                    $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                    $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                    $emailData['project_title']     = get_the_title($project_id);
                    $emailData['proposal_link']     = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $seller_id, true, 'listing');
                    if (class_exists('TaskbotProposals')) {
                        $email_helper = new TaskbotProposals();
                        $email_helper->decline_proposal_seller_email($emailData);
                    }
                }
                
                $json['type']           = 'success';
                $json['message_desc']   = esc_html__('You have successfully decline this proposal','taskbot');
                if( empty($type) ){
                    $json['redirect_url']   = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $user_id, true, 'listing');
                    wp_send_json( $json );
                } else {
                    return $json;
                }
            }
        }
        if( empty($type) ){
            wp_send_json( $json );
        } else {
            return $json;
        }
    }
}
/**
 * Add Milestone
 *
 */
if( !function_exists('taskbotAddMilestone') ){
    function taskbotAddMilestone($user_id=0,$data=array(),$type=''){
        $json           = array();
        $proposal_id    = !empty($data['proposal_id']) ? intval($data['proposal_id']) : 0;
        
        if( empty($proposal_id) ){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');
            if( empty($type) ){
                wp_send_json( $json );
            } else {
                return $json;
            }
        }

        $proposal_meta	= get_post_meta( $proposal_id, 'proposal_meta',true);
        $proposal_meta	= !empty($proposal_meta) ? $proposal_meta : array();
        $old_milestone  = !empty($proposal_meta['milestone']) ? $proposal_meta['milestone'] : array();
        $milestones     = !empty($data['milestone']) ? array_merge($old_milestone,$data['milestone']) : array();
        $milestone_price= 0;
        $proposal_price = isset($proposal_meta['price'])? $proposal_meta['price'] : 0;
        if( empty($milestones) ){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__( 'Please add atleaset one milestone', 'taskbot' );
            if( empty($type) ){
                wp_send_json( $json );
            } else {
                return $json;
            }
        } else {
            foreach($milestones as $key => $value ){
                if( empty($value['price']) || $value['price'] < 0 ){
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__( 'Milestone price must be greater then 0', 'taskbot' );
                    if( empty($type) ){
                        wp_send_json( $json );
                    } else {
                        return $json;
                    }
                } else {
                    $milestone_price    = $milestone_price+$value['price'];
                }
                if( empty($value['title']) ){
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__( 'Milestone title is required', 'taskbot' );
                    if( empty($type) ){
                        wp_send_json( $json );
                    } else {
                        return $json;
                    }
                }
                
            }
        }
        
        if( !empty($milestone_price) && $milestone_price > $proposal_price ){
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__( 'Milestone total price is greater the proposal price', 'taskbot' );
            if( empty($type) ){
                wp_send_json( $json );
            } else {
                return $json;
            }
        } else {
            $proposal_meta['milestone'] = $milestones;
            update_post_meta( $proposal_id, 'proposal_meta',$proposal_meta );
            // Notification and email to buyer
            $project_id         = get_post_meta( $proposal_id, 'project_id',true);
            $project_id         = !empty($project_id) ? intval($project_id) : 0;
            $buyer_id           = get_post_field( 'post_author', $project_id );
            $seller_id          = get_post_field( 'post_author', $proposal_id );
            
            $seller_profile_id  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id,'','sellers') : 0;
            $buyer_profile_id   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id,'','buyers') : 0;
            
            $notifyDetails                      = array();
            $notifyDetails['seller_id']  	    = $seller_profile_id;
            $notifyDetails['buyer_id']  	    = $buyer_profile_id;
            $notifyDetails['project_id']  	    = $project_id;
            $notifyDetails['project_id']        = $project_id;
            $notifyData['receiver_id']		    = $buyer_id;
            $notifyData['linked_profile']	    = $buyer_profile_id;
            $notifyData['user_type']		    = 'buyers';
            $notifyData['type']		            = 'milestone_creation';
            $notifyData['post_data']		    = $notifyDetails;
            do_action('taskbot_notification_message', $notifyData );
            /* Email to buyer on new milestone */
            $project_new_milestone_switch        = !empty($taskbot_settings['email_new_project_milestone_buyer_switch']) ? $taskbot_settings['email_new_project_milestone_buyer_switch'] : true;
            if(class_exists('Taskbot_Email_helper') && !empty($project_new_milestone_switch)){
                $emailData                      = array();
                $emailData['buyer_email']       = get_userdata( $buyer_id )->user_email;
                $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                $emailData['project_title']     = get_the_title($project_id);
                $emailData['project_link']      = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $buyer_id, true, 'activity',$proposal_id);
                if (class_exists('TaskbotMilestones')) {
                    $email_helper = new TaskbotMilestones();
                    $email_helper->project_new_milestone_buyer_email($emailData);
                }
            }

            $json['type']           = 'success';
            $json['message_desc']   = esc_html__( 'Milestone added successfully', 'taskbot' );
            if( empty($type) ){
                wp_send_json( $json );
            } else {
                return $json;
            }
        }
    }
}

/**
 * Submit proposal
 *
 */
if( !function_exists('taskbotSubmitProposal') ){
    function taskbotSubmitProposal($user_id=0,$project_id=0,$status='',$data=array(),$proposal_id=0,$type=''){
        global $taskbot_settings,$current_user;
        $package_option	        = !empty($taskbot_settings['package_option']) ? $taskbot_settings['package_option'] : '';
        $paid_proposal   = false;

        if(!empty($package_option) && ( $package_option == 'buyer_free' || $package_option == 'paid' )){
            $paid_proposal   = true;
            $package_details  		= get_user_meta($current_user->ID, 'seller_package_details', true);
            $number_project_credits	= !empty($package_details['number_project_credits']) ? $package_details['number_project_credits'] : 0;

            if(empty($number_project_credits) ){
                $json['type']           = 'error';
                $json['message_desc']   = esc_html__( 'You have consumed all the credits to apply on the project. Please renew your package to apply on this project', 'taskbot' );
                wp_send_json( $json );
            }
        }

        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action','taskbot');

        if( !empty($project_id) && !empty($user_id) && !empty($status) ){
            $taskbot_user_proposal  = 0;
            if( empty($proposal_id) ){
                $proposal_args = array(
                    'post_type' 	    => 'proposals',
                    // 'post_status'       => 'any',
                    'post_status'       => array('pending','completed','cancelled','hired', 'disputed'), 
                    'posts_per_page'    => -1,
                    'author'            => $user_id,
                    'meta_query'        => array(
                        array(
                            'key'       => 'project_id',
                            'value'     => intval($project_id),
                            'compare'   => '=',
                            'type'      => 'NUMERIC'
                        )
                    )
                );
                $proposals                  = get_posts( $proposal_args );
                $taskbot_user_proposal      = !empty($proposals) && is_array($proposals) ? count($proposals) : 0;
            } else {
                $proposal_status    = get_post_status( $proposal_id );
                if(!empty($proposal_status) && in_array($proposal_status,array('hired','completed','cancelled'))){
                    $taskbot_user_proposal  = 1;
                }
            }
            
            if( !empty($taskbot_user_proposal) ){
                $json['type']           = 'error';
                $json['message_desc']   = esc_html__('You have already submitted a proposal for this project.','taskbot');
                if( empty($type) ){
                    wp_send_json( $json );
                }else {
                    return $json;
                }
            }

            $project_meta	= get_post_meta( $project_id, 'tb_project_meta',true);
            $project_type	= !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
            $is_milestone	= !empty($project_meta['is_milestone']) ? $project_meta['is_milestone'] : '';
            $required_fields    = array(
                'price'             => esc_html__( 'Proposal price is required', 'taskbot' ),
                'description'       => esc_html__( 'Proposal description is required', 'taskbot' ),
            );

            if( !empty($project_type) && $project_type === 'fixed' && !empty($is_milestone) && $is_milestone === 'yes' ){
                $required_fields['proposal_type']   = esc_html__( 'Please select working type', 'taskbot' );
            }

            if( !empty($required_fields) && $status !='draft' ){
                foreach($required_fields as $key=> $value){
                    if(empty($data[$key])){
                        $json['type']           = 'error';
                        $json['message_desc']   = $value;
                        if( empty($type) ){
                            wp_send_json( $json );
                        }else {
                            return $json;
                        }
                    } else if( $key === 'price' && $data[$key] < 0){
                        $json['type']           = 'error';
                        $json['message_desc']   = esc_html__( 'Proposal price must be greater then 0', 'taskbot' );
                        if( empty($type) ){
                            wp_send_json( $json );
                        }else {
                            return $json;
                        }
                    }
                }
            }
            do_action( 'taskbot_proposal_validation', $proposal_id,$data );
            $milestone          = array();
            $milestone_price    = 0; 
            $proposal_price     = !empty($data['price']) ? $data['price'] : 0;
            $milestone_option   = !empty($taskbot_settings['milestone_option']) ? $taskbot_settings['milestone_option'] : 'allow';
            


            if( !empty($is_milestone) && $is_milestone === 'yes' && !empty($data['proposal_type']) && $data['proposal_type'] === 'milestone'  && $status !='draft' ){
                $milestones     = !empty($data['milestone']) ? $data['milestone'] : array();

                if( empty($milestones) ){
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__( 'Please add atleaset one milestone', 'taskbot' );
                    if( empty($type) ){
                        wp_send_json( $json );
                    }else {
                        return $json;
                    }
                } else {
                    foreach($milestones as $key => $value ){
                        if( empty($value['price']) || $value['price'] < 0 ){
                            $json['type']           = 'error';
                            $json['message_desc']   = esc_html__( 'Milestone price must be greater then 0', 'taskbot' );
                            if( empty($type) ){
                                wp_send_json( $json );
                            }else {
                                return $json;
                            }
                        } else {
                            $milestone_price    = $milestone_price+$value['price'];
                        }
                        if( empty($value['title']) ){
                            $json['type']           = 'error';
                            $json['message_desc']   = esc_html__( 'Milestone title is required', 'taskbot' );
                            if( empty($type) ){
                                wp_send_json( $json );
                            }else {
                                return $json;
                            }
                        }
                        
                    }
                }
                
                if( !empty($milestone_price) && $milestone_price > $proposal_price ){
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__( 'Milestone total price is greater the proposal price', 'taskbot' );
                    if( empty($type) ){
                        wp_send_json( $json );
                    }else {
                        return $json;
                    }
                } else if( !empty($milestone_option) && $milestone_option === 'restrict' && !empty($milestone_price) && $milestone_price < $proposal_price ){
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__( 'Milestone total price must be equal to proposal price', 'taskbot' );
                    if( empty($type) ){
                        wp_send_json( $json );
                    } else {
                        return $json;
                    }
                }
            } else if( empty($data['proposal_type']) ){
                $data['proposal_type']  = 'fixed';
            }
            
            $profile_id     = taskbot_get_linked_profile_id($user_id,'','sellers');
            $seller_name    = taskbot_get_username($profile_id);
            $project_name   = get_the_title($project_id);
            $porposal_details   = !empty($data['description']) ? $data['description'] : '';
            $proposal_meta      = $data;
            $proposal_name      = $seller_name.'-'.$project_name;
            $proposal_status    = $status;
            $buyer_id           = get_post_field( 'post_author', $project_id );
            $buyer_id           = !empty($buyer_id) ? intval($buyer_id) : 0;

            if( !empty($status) && $status === 'publish' ){
                $proposal_status    = !empty($taskbot_settings['proposal_status']) ? $taskbot_settings['proposal_status'] : 'publish';
            }

            if( empty($proposal_id)){
                $tb_post_data = array(
                    'post_title'    => wp_strip_all_tags($proposal_name),
                    'post_content' => $porposal_details,
                    'post_type'    => 'proposals',
                    'post_author'  => $user_id,
                    'post_status'  => $proposal_status
                );

                $proposal_id = wp_insert_post( $tb_post_data );

                if(!empty($package_option) && ( $package_option == 'buyer_free' || $package_option == 'paid' )){
                    $paid_proposal   = true;
                    $credits_required	    = !empty($taskbot_settings['credits_required']) ? $taskbot_settings['credits_required'] : 0;
                    $package_credit_details      = intval($package_details['number_project_credits'] ) - intval($credits_required);
                    $package_details['number_project_credits']  = $package_credit_details;
        
                    update_user_meta( $user_id, 'seller_package_details', $package_details );
                } 

            } else {
                $tb_post_data['ID']             = $proposal_id;
                $tb_post_data['post_status']    = $proposal_status;
                $tb_post_data['post_content']   = ($porposal_details);
                wp_update_post( $tb_post_data );
            }

            update_post_meta( $proposal_id, 'proposal_meta',$data );
            update_post_meta( $proposal_id, 'project_id',$project_id );
            update_post_meta( $proposal_id, 'buyer_id',$buyer_id );
            update_post_meta( $proposal_id, 'proposal_type',$project_type );
            update_post_meta( $proposal_id, '_hired_status',false );
            do_action( 'taskbot_update_proposal', $proposal_id,$data );
            $json['type']           = 'success';
            $json['redirect']       = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $user_id, true, 'listing');

            if( !empty($proposal_status) && $proposal_status === 'publish'){
                // Email to employer and admin for proposal
                // Notification to employer and admin for proposal
                $buyer_id                           = get_post_field( 'post_author', $project_id );
                $buyer_profile_id                   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id, '', 'buyers') : '';
                $seller_id                          = get_post_field( 'post_author', $proposal_id );
                $seller_profile_id                  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id, '', 'sellers') : '';
                $notifyDetails                      = array();
                $notifyDetails['buyer_id']  	    = $buyer_profile_id;
                $notifyDetails['seller_id']  	    = $seller_profile_id;
                $notifyDetails['project_id']  	    = $project_id;
                $notifyDetails['proposal_id']  	    = $proposal_id;
                $notifyData['post_data']		    = $notifyDetails;
                $notifyData['type']		            = 'recived_proposal';
                $notifyData['receiver_id']		    = $buyer_id;
                $notifyData['linked_profile']	    = $buyer_profile_id;
                $notifyData['user_type']		    = 'buyers';
                do_action('taskbot_notification_message', $notifyData );

                /* Email to buyer and admin */
                $submit_proposal_buyer_switch = !empty($taskbot_settings['email_submit_proposal_buyer']) ? $taskbot_settings['email_submit_proposal_buyer'] : true;
                $submit_proposal_admin_switch = !empty($taskbot_settings['email_submited_proposal_admin']) ? $taskbot_settings['email_submited_proposal_admin'] : true;
                if(class_exists('Taskbot_Email_helper')){
                    $emailData                      = array();
                    $emailData['buyer_email']       = get_userdata($buyer_id)->user_email;
                    $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
                    $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
                    $emailData['project_title']     = get_the_title($project_id);
                    
                    if (class_exists('TaskbotProposals')) {
                        $email_helper = new TaskbotProposals();
                        if(!empty($submit_proposal_buyer_switch)){
                            $emailData['proposal_link']     = Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $buyer_id, true, 'detail', $proposal_id);
                            $email_helper->submit_proposal_buyer_email($emailData);
                        }

                        if(!empty($submit_proposal_admin_switch)){
                            $emailData['proposal_link']     = admin_url( 'post.php?post=' . $proposal_id ) . '&action=edit';
                            $email_helper->submited_proposal_admin_email($emailData);
                        }
                    }
                }

                $json['message_desc']   = esc_html__( 'Your proposal has sent successfully', 'taskbot' );
            } else if( !empty($proposal_status) && $proposal_status === 'pending'){
                $json['type']           = 'success';
                // Email to admin for proposal
                $json['message_desc']   = esc_html__( 'Your proposal has sent successfully', 'taskbot' );
            } else if( !empty($proposal_status) && $proposal_status === 'draft'){
                $json['type']           = 'success';
                $json['message_desc']   = esc_html__( 'Your proposal has saved successfully', 'taskbot' );
            }
            
            if( empty($type) ){
                wp_send_json( $json );
            }else {
                return $json;
            }
        } else {
            if( empty($type) ){
                wp_send_json( $json );
            }else {
                return $json;
            }
        }
        
    }
}

/**
 * Project proposal html
 *
 */
if( !function_exists('taskbot_project_proposal_icons_html') ){
    function taskbot_project_proposal_icons_html($post_id=0,$limit=4,$show_link='') {
        global $current_user;
        $args = array(
            'post_type' 	    => 'proposals',
            'post_status'       => array('publish','hired','completed','cancelled','disputed','refunded'),
            'posts_per_page'    => $limit,
            'meta_query'        => array(
                array(
                    'key'       => 'project_id',
                    'value'     => intval($post_id),
                    'compare'   => '=',
                    'type'      => 'NUMERIC'
                )
            )
        );
        $proposals  = get_posts( $args );
        ob_start();
        if( !empty($proposals) ){
            foreach($proposals as $proposal){
                $linked_profile     = !empty($proposal->post_author) ? taskbot_get_linked_profile_id($proposal->post_author,'','sellers') : 0;
                $image_src          = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $linked_profile), array('width' => 50, 'height' => 50));
                $username           = taskbot_get_username($linked_profile);
                if( !empty($image_src) ){ ?>
                    <li><img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($username);?>"></li>
            <?php }
            } 
            if( !empty($show_link) && is_user_logged_in() && $show_link === 'yes' ){ ?>
                <li><a class="tk-view-proposal" href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $current_user->ID, '', 'listing',$post_id);?>"><?php esc_html_e('View all proposals','taskbot');?><i class="tb-icon-chevron-right"></i></a></li>
        <?php }
        } else { ?>
            <li><span><?php esc_html_e('No proposals received','taskbot');?></span></li>
        <?php }
        echo ob_get_clean();
    }
    add_action('taskbot_project_proposal_icons_html', 'taskbot_project_proposal_icons_html',10,3);
}

/**
 * List proposal filter status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_list_proposal_status_filter')) {
    function taskbot_list_proposal_status_filter($type = '')
    {
        global $taskbot_settings;
        $list = array(
            'any'       => esc_html__('All proposal', 'taskbot'),
            'publish'   => esc_html__('Published', 'taskbot'),
            'rejected'  => esc_html__('Rejected', 'taskbot'),
            'disputed'     => esc_html__('Disputed', 'taskbot'),
            'refunded'     => esc_html__('Refunded', 'taskbot'),
            'hired'         => esc_html__('Ongoing', 'taskbot'),
        );
        $proposal_status             = !empty($taskbot_settings['proposal_status']) ? $taskbot_settings['proposal_status'] : '';
        if( !empty($proposal_status) && $proposal_status === 'pending'){
            $list['publish']    = esc_html__('Approved', 'taskbot');
        }
        $list = apply_filters('taskbot_filters_list_proposal_status_filter_by', $list);
        return $list;
    }
    add_filter('taskbot_list_proposal_status_filter', 'taskbot_list_proposal_status_filter', 10, 1);
}

/**
 * Proposal status html
 *
 */
if( !function_exists('taskbot_proposal_status_tag') ){
    function taskbot_proposal_status_tag($post_id = '') {
        $proposal_status    = get_post_status( $post_id);
        $proposal_status    = !empty($proposal_status) ? $proposal_status : '';
        $lable              = "";
        $status_class       = "";
        switch($proposal_status){
            case 'pending':
                $label          = esc_html__('Pending', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'draft':
                $label          = esc_html__('Drafted', 'taskbot');
                $status_class   = 'tk-project-tag';
                break;
            case 'publish':
                $label          = esc_html__('In queue', 'taskbot');
                $status_class   = 'tk-project-tag tk-new';
                break;
            case 'completed':
                $label          = _x('Completed', 'Title for proposal status', 'taskbot' );
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'refunded':
                $label          = esc_html__('Refunded', 'taskbot');
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'cancelled':
                $label          = esc_html__('Cancelled', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'hired':
                $label          = esc_html__('Ongoing', 'taskbot');
                $status_class   = 'tk-project-tag tk-ongoing';
                break;
            case 'disputed':
                $label          = esc_html__('Disputed', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            default:
                $label          = esc_html__('New', 'taskbot');
                $status_class   = 'tk-project-tag';
                break;
        }
        if( !empty($label) ){
            ob_start();
            ?>
                <span class="<?php echo esc_attr($status_class);?>"><?php echo esc_html($label);?></span>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_proposal_status_tag', 'taskbot_proposal_status_tag',10,1);
}

/**
 * Seller proposal status html
 *
 */
if( !function_exists('taskbot_seller_proposal_status_tag') ){
    function taskbot_seller_proposal_status_tag($post_id = '') {
        $proposal_status    = get_post_status( $post_id);
        $proposal_status    = !empty($proposal_status) ? $proposal_status : '';
        $lable              = "";
        $status_class       = "";
        switch($proposal_status){
            case 'pending':
                $label          = esc_html__('In queue', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'draft':
                $label          = esc_html__('Drafted', 'taskbot');
                $status_class   = 'tk-project-tag tk-drafted';
                break;
            case 'publish':
                $label          = esc_html__('In queue', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'completed':
                $label          = _x('Completed', 'Title for proposal status', 'taskbot' );
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'refunded':
                $label          = esc_html__('Refunded', 'taskbot');
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'cancelled':
                $label          = esc_html__('Cancelled', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'hired':
                $label          = esc_html__('Ongoing', 'taskbot');
                $status_class   = 'tk-project-tag tk-ongoing';
                break;
            case 'decline':
                $label          = esc_html__('Decline', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'disputed':
                $label          = esc_html__('Disputed', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            default:
                $label          = esc_html__('New', 'taskbot');
                $status_class   = 'tk-project-tag';
                break;
        }
        if( !empty($label) ){
            ob_start();
            ?>
                <span class="<?php echo esc_attr($status_class);?>"><?php echo esc_html($label);?></span>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_seller_proposal_status_tag', 'taskbot_seller_proposal_status_tag',10,1);
}

/**
 * Milestone status html
 *
 */
if( !function_exists('taskbot_milestone_proposal_status_tag') ){
    function taskbot_milestone_proposal_status_tag($status = '') {
        $label          = '';
        $status_class   = '';
        switch($status){
            case 'hired':
                $label          = esc_html__('Ongoing', 'taskbot');
                $status_class   = 'tk-project-tag tk-ongoing';
                break;
            case 'completed':
                $label          = esc_html__('Approved', 'taskbot');
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'cancelled':
                $label          = esc_html__('Cancelled', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'requested':
                $label          = esc_html__('Awaiting for approval', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'decline':
                $label          = esc_html__('Decline', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            default:
                $label          = '';
                $status_class   = '';
                break;
        }
        if( !empty($label) ){
            ob_start();
            ?>
                <div class="tk-statusview_tag">
                    <span class="<?php echo esc_attr($status_class);?>"><?php echo esc_html($label);?></span>
                </div>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_milestone_proposal_status_tag', 'taskbot_milestone_proposal_status_tag',10,1);
}


/**
 * Project invoice status html
 *
 */
if( !function_exists('taskbot_proposal_invoice_status_tag') ){
    function taskbot_proposal_invoice_status_tag($status = '',$return='') {
        $label          = '';
        $status_class   = '';
        switch($status){
            case 'hired':
                $label          = esc_html__('Pending', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'completed':
                $label          = _x('Completed', 'Title for invoice status', 'taskbot' );
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'cancelled':
                $label          = esc_html__('Cancelled', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'pending':
                $label          = esc_html__('Pending', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'decline':
                $label          = esc_html__('Decline', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            default:
                $label          = '';
                $status_class   = '';
                break;
        }
        if( !empty($return) ){
            return $label;
        } else {
            if( !empty($label) ){
                ob_start();
                ?>
                    <div class="tk-statusview_tag">
                        <span class="<?php echo esc_attr($status_class);?>"><?php echo esc_html($label);?></span>
                    </div>
                <?php
                echo ob_get_clean();
            }
        }
    }
    add_action('taskbot_proposal_invoice_status_tag', 'taskbot_proposal_invoice_status_tag',10,2);
    add_filter('taskbot_proposal_invoice_status_tag', 'taskbot_proposal_invoice_status_tag',10,2);
}
/**
 * Get activity chat history
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_project_comments_history')) {
    function taskbot_project_comments_history($value = array())
    {
        $date           = !empty($value->comment_date) ? $value->comment_date : '';
        $author_id      = !empty($value->user_id) ? $value->user_id : '';
        $comments_id    = !empty($value->comment_ID) ? $value->comment_ID : '';
        $author         = !empty($value->comment_author) ? $value->comment_author : '';
        $message        = !empty($value->comment_content) ? $value->comment_content : '';
        $message_files  = get_comment_meta($value->comment_ID, 'message_files', true);
        $message_type   = get_comment_meta($value->comment_ID, '_message_type', true);
        $date           = !empty($date) ? date_i18n('F j, Y', strtotime($date)) : '';
        $user_type      = get_comment_meta($value->comment_ID, 'user_type', true);

        $author_user_type   = !empty($user_type) ? $user_type : apply_filters('taskbot_get_user_type', $author_id);
        $author_profile_id  = taskbot_get_linked_profile_id($author_id, '', $author_user_type);
        $auther_url         = !empty($author_user_type) && $author_user_type === 'sellers' ? get_the_permalink($author_profile_id) : '#';
        $author_name        = taskbot_get_username($author_profile_id);
        $avatar             = apply_filters(
            'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $author_profile_id), array('width' => 50, 'height' => 50)
        );
        $src                = TASKBOT_DIRECTORY_URI . 'public/images/doc.jpg';
        $count_fiels        = !empty($message_files) && is_array($message_files) ? count($message_files) : 0;
        ob_start();
        ?>
        <li>
            <figure class="tk-proactivity_img">
                <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
            </figure>
            <div class="tk-proactivity_info">
                <?php if( !empty($author_name) || !empty($date) ){?>
                    <h6>
                        <?php echo esc_attr($author_name); ?>
                        <?php if (!empty($date)) { ?><span><?php echo esc_html($date); ?></span><?php } ?>
                    </h6>
                <?php } ?>
                <?php if( !empty($message) ){?>
                    <p><?php echo esc_html(wp_strip_all_tags($message)); ?></p>
                <?php } ?>
                <?php if( !empty($message_files) ){?>
                    <div class="tk-proactivity_file">
                        <img src="<?php echo esc_url($src);?>" alt="<?php esc_attr_e('Download files','taskbot');?>">
                        <span><?php echo sprintf(esc_html__('%s Attachments to download','taskbot'),$count_fiels);?></span>
                        <span class="tb-download-attachment" data-id="<?php echo esc_attr($comments_id); ?>"><?php esc_html_e('Download file(s)','taskbot');?></span>
                    </div>
                <?php } ?>
            </div>
        </li>
        <?php
        echo ob_get_clean();
    }
    add_action('taskbot_project_comments_history', 'taskbot_project_comments_history');
}

  /**
 * @Init Pagination Code Start
 * @return
 */
if (!function_exists('taskbot_proposal_order_budget_details')) {
    add_action( 'taskbot_proposal_order_budget_details', 'taskbot_proposal_order_budget_details', 10, 2);
    function taskbot_proposal_order_budget_details($proposal_id =0, $user_type = 'sellers') {
		if ( !class_exists('WooCommerce') ) {
			return;
		}
        $dispute_id         = get_post_meta( $proposal_id, 'dispute_id',true );
        $dispute_id         = !empty($dispute_id) ? intval($dispute_id) : 0;

        $order_price        = get_post_meta( $dispute_id, '_total_amount',true );
        $proposal_meta      = get_post_meta( $proposal_id, 'proposal_meta',true );
        $proposal_meta      = !empty($proposal_meta) ? $proposal_meta : array();
        $order_ids          = get_post_meta( $dispute_id, '_order_ids',true );
        $order_ids          = !empty($order_ids) ? $order_ids : array();
        $total_tax          = 0;
		ob_start();?>
			<div class="tb-asideholder tb-taskdeadline">
				<?php if(isset($order_price)){?>
				<div class="tb-asidebox tb-additonoltitleholder">
					<div data-bs-toggle="collapse" data-bs-target="#tb-additionolinfov2" aria-expanded="true" role="button">
						<div class="tb-additonoltitle">
							<div class="tb-startingprice">
								<i><?php esc_html_e('Total project budget', 'taskbot');?></i>
								<span><?php taskbot_price_format($order_price);  ?></span>
							</div>
							<i class="tb-icon-chevron-down"></i>
						</div>
					</div>
				</div>
				<?php }?>
				<div id="tb-additionolinfov2" class="show">
					<div class="tb-budgetlist">
						<?php if(!empty($order_ids)){?>
							<ul class="tb-planslist">
								<?php
								// Get and Loop Over Order Items
								foreach ($order_ids as $order_id) {
                                    $order          = wc_get_order($order_id);

                                    $product_data   = get_post_meta( $order->get_id(),'cus_woo_product_data', true );
                                    $project_type   = !empty($product_data['project_type']) ? $product_data['project_type'] : '';
                                    $get_total      = $order->get_total();
                                    if(function_exists('wmc_revert_price')){
                                        $get_total =  wmc_revert_price($order->get_total(),$order->get_currency());
                                    }
                                    $invoice_title  = "";
                                    $milestone_id   = '';
                                    if( !empty($project_type) && $project_type === 'fixed' ){
                                        $milestone_id   = !empty($product_data['milestone_id']) ? $product_data['milestone_id'] : "";
                                        if( !empty($milestone_id)){
                                            $invoice_title  = !empty($proposal_meta['milestone'][$milestone_id]['title']) ? $proposal_meta['milestone'][$milestone_id]['title'] : "";
                                        } else if( empty($milestone_id) ){
                                            $project_id   = !empty($product_data['project_id']) ? $product_data['project_id'] : "";
                                            if( !empty($project_id) ){
                                                $invoice_title  = get_the_title( $project_id );
                                            }
                                        }
                                    }
                                    ?>
									<li>
										<h6>
											<?php echo esc_html($invoice_title);?>
											<span>(<?php taskbot_price_format($get_total); ?>) </span>
										</h6>
									</li>
								<?php }?>
							</ul>
						<?php }?>
						<ul class="tb-planslist tb-totalfee">
							<li>
								<a href="javascript:void(0);">
									<h6>
										<?php esc_html_e('Total project budget', 'taskbot');?>:&nbsp;
										<span>(<?php taskbot_price_format($order_price);?>) </span>
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