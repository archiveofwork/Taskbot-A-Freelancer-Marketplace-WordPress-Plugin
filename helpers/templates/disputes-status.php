<?php
/**
 *
 * Class 'TaskbotDisputeStatuses' defines dispute email
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if (!class_exists('TaskbotDisputeStatuses')) {
  class TaskbotDisputeStatuses extends Taskbot_Email_helper{
	  
    /* Email Dispute received */
    public function dispute_received_admin_email($params = ''){
        global $taskbot_settings;
        extract($params);
        $email_to 			   = !empty( $taskbot_settings['disputes_admin_email'] ) ? $taskbot_settings['disputes_admin_email'] : get_option('admin_email', 'info@example.com'); //admin email
        $seller_name_          = !empty($seller_name) ? $seller_name : '';
        $buyer_name_           = !empty($buyer_name) ? $buyer_name : '';
        $task_name_            = !empty($task_name) ? $task_name : '';
        $task_link_            = !empty($task_link) ? $task_link : '';
        $order_id_             = !empty($order_id) ? $order_id : '';
        $order_amount_         = !empty($order_amount) ? $order_amount : '';
        $login_url_            = !empty($login_url) ? $login_url : '';

        $subject_default 	        = esc_html__('A new dispute received', 'taskbot'); //default email subject
        $contact_default 	        = wp_kses(__('A new dispute has been created against the order #{{order_id}}', 'taskbot'), //default email content
            array(
                'a' => array(
                    'href' => array(),
                    'title' => array()
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
            )
        );

        $subject		    = !empty( $taskbot_settings['disputes_admin_email_subject'] ) ? $taskbot_settings['disputes_admin_email_subject'] : $subject_default; //getting subject
        $email_content  	= !empty( $taskbot_settings['disputes_admin_mail_content'] ) ? $taskbot_settings['disputes_admin_mail_content'] : $contact_default; //getting content

        $task_link__     = $this->process_email_links($task_link_, $task_name_);
        $login_url__     = $this->process_email_links($login_url_, esc_html__('Login','taskbot'));

        $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']      = '';
        $greeting['greet_value']        = '';
        $greeting['greet_option_key']   = '';

        $body  = $this->taskbot_email_body($email_content, $greeting);
        $body  = apply_filters('taskbot_admin_dispute_email_content', $body);

        wp_mail($email_to, $subject, $body); //send Email

    }

    /* Email Dispute seller resolved */
    public function dispute_seller_resolved($params = ''){
        global $taskbot_settings;
        extract($params);
        $email_to 			 = !empty($seller_email) ? $seller_email : '';
        $seller_name_          = !empty($seller_name) ? $seller_name : '';
        $task_name_            = !empty($task_name) ? $task_name : '';
        $task_link_            = !empty($task_link) ? $task_link : '';
        $order_id_             = !empty($order_id) ? $order_id : '';
        $order_amount_         = !empty($order_amount) ? $order_amount : '';
        $login_url_            = !empty($login_url) ? $login_url : '';

        $subject_default        = esc_html__('Dispute resolved', 'taskbot'); //default email subject
        $contact_default        = wp_kses(__('Congratulations! <br/> We have gone through the refund and dispute and resolved the dispute in your favor. We completed the task and the amount has been added to your wallet.', 'taskbot'), //default email content
            array(
                'a' => array(
                    'href' => array(),
                    'title' => array()
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
            )
        );

        $subject         = !empty( $taskbot_settings['disputes_resolved_seller_email_subject'] ) ? $taskbot_settings['disputes_resolved_seller_email_subject'] : $subject_default;
        $email_content   = !empty( $taskbot_settings['disputes_resolved_seller_mail_content'] ) ? $taskbot_settings['disputes_resolved_seller_mail_content'] : $contact_default; 
        $task_link__     = $this->process_email_links($task_link_, $task_name_);
        $login_url__     = $this->process_email_links($login_url_, esc_html__('Login','taskbot'));

        $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']      = 'seller_name';
        $greeting['greet_value']        = $seller_name_;
        $greeting['greet_option_key']   = 'disputes_resolved_seller_email_greeting';

        $body   = $this->taskbot_email_body($email_content, $greeting);
        $body   = apply_filters('taskbot_seller_dispute_resolved_content', $body);

        wp_mail($email_to, $subject, $body); //send Email

    }

    /* Email Dispute seller canceled or not resolved in your fovour */
    public function dispute_seller_cancelled($params = ''){
        global $taskbot_settings;
        extract($params);
        $email_to 			 = !empty($seller_email) ? $seller_email : '';
        $seller_name_          = !empty($seller_name) ? $seller_name : '';
        $task_name_            = !empty($task_name) ? $task_name : '';
        $task_link_            = !empty($task_link) ? $task_link : '';
        $order_id_             = !empty($order_id) ? $order_id : '';
        $order_amount_         = !empty($order_amount) ? $order_amount : '';
        $login_url_            = !empty($login_url) ? $login_url : '';

        $subject_default        = esc_html__('Dispute canceled', 'taskbot'); //default email subject
        $contact_default        = wp_kses(__('The dispute has been cancelled.', 'taskbot'), //default email content
            array(
                'a' => array(
                    'href' => array(),
                    'title' => array()
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
            )
        );

        $subject         = !empty( $taskbot_settings['disputes_cancelled_seller_email_subject'] ) ? $taskbot_settings['disputes_cancelled_seller_email_subject'] : $subject_default;
        $email_content   = !empty( $taskbot_settings['disputes_cancelled_seller_mail_content'] ) ? $taskbot_settings['disputes_cancelled_seller_mail_content'] : $contact_default; 
        $task_link__     = $this->process_email_links($task_link_, $task_name_);
        $login_url__     = $this->process_email_links($login_url_, esc_html__('Login','taskbot'));

        $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']      = 'seller_name';
        $greeting['greet_value']        = $seller_name_;
        $greeting['greet_option_key']   = 'disputes_cancelled_seller_email_greeting';

        $body   = $this->taskbot_email_body($email_content, $greeting);
        $body   = apply_filters('taskbot_seller_dispute_cancelled_content', $body);

        wp_mail($email_to, $subject, $body); //send Email

    }

    /* Email Dispute buyer resolved */
    public function dispute_buyer_resolved($params = ''){
        global $taskbot_settings;
        extract($params);
        $email_to                 = !empty($buyer_email) ? $buyer_email : '';
        $buyer_name_              = !empty($buyer_name) ? $buyer_name : '';
        $task_name_               = !empty($task_name) ? $task_name : '';
        $task_link_               = !empty($task_link) ? $task_link : '';
        $order_id_                = !empty($order_id) ? $order_id : '';
        $order_amount_            = !empty($order_amount) ? $order_amount : '';
        $login_url_               = !empty($login_url) ? $login_url : '';

        $subject_default 	        = esc_html__('Dispute resolved', 'taskbot'); //default email subject
        $contact_default 	        = wp_kses(__('Congratulations! <br/> We have gone through the dispute and resolved the dispute in your favor. The amount has been added to your wallet, you can try to hire someone else.', 'taskbot'), //default email content
            array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            ));

        $subject		    = !empty( $taskbot_settings['disputes_resolved_buyer_email_subject'] ) ? $taskbot_settings['disputes_resolved_buyer_email_subject'] : $subject_default; //getting subject
        $email_content  = !empty( $taskbot_settings['disputes_resolved_buyer_mail_content'] ) ? $taskbot_settings['disputes_resolved_buyer_mail_content'] : $contact_default; //getting content

        $task_link__     = $this->process_email_links($task_link_, $task_name_);
        $login_url__     = $this->process_email_links($login_url_, esc_html__('Login','taskbot'));

        $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']      = 'buyer_name';
        $greeting['greet_value']        = $buyer_name_;
        $greeting['greet_option_key']   = 'disputes_resolved_buyer_email_greeting';

        $body = $this->taskbot_email_body($email_content, $greeting);
        $body  = apply_filters('taskbot_buyer_dispute_resolved_content', $body);

        wp_mail($email_to, $subject, $body); //send Email
    }

    /* Email Dispute buyer canceled or not resolved in yuor favour */
    public function dispute_buyer_cancelled($params = ''){
        global $taskbot_settings;
        extract($params);
        $email_to                 = !empty($buyer_email) ? $buyer_email : '';
        $buyer_name_              = !empty($buyer_name) ? $buyer_name : '';
        $task_name_               = !empty($task_name) ? $task_name : '';
        $task_link_               = !empty($task_link) ? $task_link : '';
        $order_id_                = !empty($order_id) ? $order_id : '';
        $order_amount_            = !empty($order_amount) ? $order_amount : '';
        $login_url_               = !empty($login_url) ? $login_url : '';
        $subject_default 	        = esc_html__('Dispute canceled', 'taskbot'); //default email subject
        $contact_default 	        = wp_kses(__('The dispute has been cancelled.', 'taskbot'), //default email content
            array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            )
        );

        $subject		    = !empty( $taskbot_settings['disputes_cancelled_buyer_email_subject'] ) ? $taskbot_settings['disputes_cancelled_buyer_email_subject'] : $subject_default; //getting subject
        $email_content  = !empty( $taskbot_settings['disputes_cancelled_buyer_mail_content'] ) ? $taskbot_settings['disputes_cancelled_buyer_mail_content'] : $contact_default; //getting content

        $task_link__     = $this->process_email_links($task_link_, $task_name_);
        $login_url__     = $this->process_email_links($login_url_, esc_html__('Login','taskbot'));

        $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']      = 'buyer_name';
        $greeting['greet_value']        = $buyer_name_;
        $greeting['greet_option_key']   = 'disputes_cancelled_buyer_email_greeting';

        $body = $this->taskbot_email_body($email_content, $greeting);
        $body  = apply_filters('taskbot_buyer_dispute_cancelled_content', $body);

        wp_mail($email_to, $subject, $body); //send Email

    }

  }
  new TaskbotDisputeStatuses();
}