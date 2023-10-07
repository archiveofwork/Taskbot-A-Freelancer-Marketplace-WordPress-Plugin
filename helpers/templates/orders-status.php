<?php
/**
 *
 * Class 'TaskbotOrderStatuses' defines order activities
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if (!class_exists('TaskbotOrderStatuses')) {

    class TaskbotOrderStatuses extends Taskbot_Email_helper{

      public function __construct() {
			  //do stuff here
      }

      /* new order seller email */
      public function new_order_seller_email($params = '') {
        global  $taskbot_settings;
        extract($params);
        $seller_name_       = !empty($seller_name) ? $seller_name : '';
        $buyer_name_        = !empty($buyer_name) ? $buyer_name : '';
        $task_name_         = !empty($task_name) ? $task_name : '';
        $task_link          = !empty($task_link) ? $task_link: '';
        $order_id           = !empty($order_id) ? $order_id: '';
        $order_amount       = !empty($order_amount) ? $order_amount : '';
        $seller_email_      = !empty($seller_email) ? $seller_email : '';
        $email_to 			    = !empty( $seller_email_ ) ? $seller_email_ : ''; //admin email
        $subject_default 	  = esc_html__('A new task order', 'taskbot'); //default email subject
        $contact_default 	  = wp_kses(__('You have received a new order for the task “{{task_name}}”', 'taskbot'), //default email content
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

        $subject		    = !empty( $taskbot_settings['new_order_seller_email_subject'] ) ? $taskbot_settings['new_order_seller_email_subject'] : $subject_default; //getting subject
        $content		    = !empty( $taskbot_settings['new_order_seller_mail_content'] ) ? $taskbot_settings['new_order_seller_mail_content'] : $contact_default; //getting conetnt
        $email_content  = $content; //getting content
        $task_link_     = $this->process_email_links($task_link, $task_name_); //task/post link

        $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content = str_replace("{{buyer_name}}", $buyer_name_ , $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link_, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount, $email_content);

        /* data for greeting */
        $greeting['greet_keyword'] = 'seller_name';
        $greeting['greet_value'] = $seller_name_;
        $greeting['greet_option_key'] = 'new_order_seller_email_greeting';

        $body = $this->taskbot_email_body($email_content, $greeting);

        $body  = apply_filters('taskbot_new_order_seller_email_content', $body);

        wp_mail($email_to, $subject, $body); //send Email

      }

      /* new order buyer email */
      public function new_order_buyer_email($params = '') {
        global  $taskbot_settings;
        extract($params);

        $seller_name_       = !empty($seller_name) ? $seller_name : '';
        $buyer_name_        = !empty($buyer_name) ? $buyer_name : '';
        $task_name_         = !empty($task_name) ? $task_name : '';
        $task_link          = !empty($task_link) ? $task_link : '';
        $order_id           = !empty($order_id) ? $order_id : '';
        $order_amount       = !empty($order_amount) ? $order_amount : '';
        $seller_email_      = !empty($seller_email) ? $seller_email : '';
        $buyer_email_       = !empty($buyer_email) ? $buyer_email : '';
        $email_to 			    = !empty( $buyer_email_ ) ? $buyer_email_ : get_option('admin_email', 'info@example.com'); //admin email
        $subject_default 	  = esc_html__('New order', 'taskbot'); //default email subject
        $contact_default 	  = wp_kses(__('Thank you so much for ordering my task. I will get in touch with you shortly.<br/>', 'taskbot'), //default email content
          array(
            'a' => array(
              'href'    => array(),
              'title'   => array()
            ),
            'br'        => array(),
            'em'        => array(),
            'strong'    => array(),
          )
        );

        $subject		    = !empty( $taskbot_settings['new_order_buyer_email_subject'] ) ? $taskbot_settings['new_order_buyer_email_subject'] : $subject_default; //getting subject
        $content		    = !empty( $taskbot_settings['new_order_buyer_mail_content'] ) ? $taskbot_settings['new_order_buyer_mail_content'] : $contact_default; //getting content
        $email_content  = $content; //getting content
        $task_link_     = $this->process_email_links($task_link, $task_name_); //task/post link

        $email_content  = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content  = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content  = str_replace("{{task_link}}", $task_link_, $email_content);
        $email_content  = str_replace("{{order_id}}", $order_id, $email_content);
        $email_content  = str_replace("{{order_amount}}", $order_amount, $email_content);
        $email_content  = str_replace("{{buyer_name}}", $buyer_name_, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']    = 'buyer_name';
        $greeting['greet_value']      = $buyer_name_;
        $greeting['greet_option_key'] = 'new_order_buyer_email_greeting';

        $body = $this->taskbot_email_body($email_content, $greeting);

        $body  = apply_filters('taskbot_new_order_buyer_email_content', $body);

        wp_mail($email_to, $subject, $body); //send Email

      }

      /* Order complete request */
      public function order_complete_request_buyer_email($params = '') {
        global  $taskbot_settings;
        extract($params);

        $email_to             = !empty($buyer_email)  ? $buyer_email    : '';
        $seller_name_         = !empty($seller_name)  ? $seller_name    : '';
        $buyer_name_          = !empty($buyer_name)   ? $buyer_name     : '';
        $task_name_           = !empty($task_name)    ? $task_name      : '';
        $task_link_           = !empty($task_link)    ? $task_link      : '';
        $order_id_            = !empty($order_id)     ? $order_id       : '';
        $login_url_           = !empty($login_url)    ? $login_url      : '';
        $order_amount_        = !empty($order_amount) ? $order_amount   : 0;
        $activity_page_link_  = !empty($activity_link) ? $activity_link : '';

        $subject_default 	 = esc_html__('Task completed request', 'taskbot'); //default email subject
        $contact_default 	 = wp_kses(__('The seller “{{seller_name}}” has sent you the final delivery for the order #{{order_id}} <br/> You can accept or decline this. Please login to the site {{login_url}} and take a quick action on this activity {{activity_link}}', 'taskbot'),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          )
        );

        $subject		          = !empty( $taskbot_settings['order_complete_request_subject'] ) ? $taskbot_settings['order_complete_request_subject'] : $subject_default; //getting subject
        $email_content        = !empty( $taskbot_settings['order_complete_request_content'] ) ? $taskbot_settings['order_complete_request_content'] : $contact_default; //getting content
        $task_link__          = $this->process_email_links( $task_link_, $task_name_ );
        $login_url__          = $this->process_email_links( $login_url_, esc_html__('Login', 'taskbot') );
        $activity_page_link__ = $this->process_email_links( $activity_page_link_,esc_html__('Activity page', 'taskbot')  );

        $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{activity_link}}", $activity_page_link__, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']    = 'buyer_name';
        $greeting['greet_value']      = $buyer_name_;
        $greeting['greet_option_key'] = 'order_complete_request_greeting';

        $body   = $this->taskbot_email_body($email_content, $greeting);
        $body   = apply_filters('taskbot_order_complete_request_email_content', $body);
        wp_mail($email_to, $subject, $body); //send Email

      }

      /* Order complete request Decline */
      public function order_complete_request_decline_seller_email($params = ''){
        global  $taskbot_settings;
        extract($params);

        $email_to         = !empty($seller_email) ? $seller_email : '';
        $seller_name_     = !empty($seller_name) ? $seller_name : '';
        $buyer_name_      = !empty($buyer_name) ? $buyer_name : '';
        $task_name_       = !empty($task_name)  ? $task_name : '';
        $task_link_       = !empty($task_link) ? $task_link : '';
        $order_id_        = !empty($order_id) ? $order_id : '';
        $order_amount_    = !empty($order_amount) ? $order_amount : 0;
        $login_url_       = !empty($login_url) ? $login_url : '';
        $buyer_comments_  = !empty($buyer_comments) ? $buyer_comments : '';

        $subject_default 	 = esc_html__('Task completed request declined', 'taskbot'); //default email subject
        $contact_default 	 = wp_kses(__('The buyer “{{buyer_name}}” has declined the final revision and has left some comments against the order #{{order_id}} <br/> "{{buyer_comments}}" <br/>', 'taskbot'),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          )
        );

        $subject		     = !empty( $taskbot_settings['order_complete_request_declined_subject'] ) ? $taskbot_settings['order_complete_request_declined_subject'] : $subject_default; //getting subject
        $email_content   = !empty( $taskbot_settings['order_complete_request_declined_content'] ) ? $taskbot_settings['order_complete_request_declined_content'] : $contact_default; //getting content
        $task_link__     = $this->process_email_links( $task_link_, $task_name_ );
        $login_url__     = $this->process_email_links( $login_url_, esc_html__('Login', 'taskbot') );

        $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);
        $email_content = str_replace("{{buyer_comments}}", $buyer_comments_, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']    = 'seller_name';
        $greeting['greet_value']      = $seller_name_;
        $greeting['greet_option_key'] = 'order_complete_request_declined_greeting';

        $body   = $this->taskbot_email_body($email_content, $greeting);
        $body   = apply_filters('taskbot_order_complete_request_declined_email_content', $body);
        wp_mail($email_to, $subject, $body); //send Email

      }

      /* Order Completed */
      public function order_completed_seller_email($params = ''){
        global  $taskbot_settings;
        extract($params);

        $email_to         = !empty($seller_email) ? $seller_email : '';
        $seller_name_     = !empty($seller_name) ? $seller_name : '';
        $buyer_name_      = !empty($buyer_name) ? $buyer_name : '';
        $task_name_       = !empty($task_name) ? $task_name : '';
        $task_link_       = !empty($task_link) ? $task_link : '';
        $order_id_        = !empty($order_id) ? $order_id : '';
        $login_url_       = !empty($login_url) ? $login_url : '';
        $order_amount_    = !empty($order_amount) ? $order_amount : '';
        $buyer_comments_  = !empty($buyer_comments) ? $buyer_comments : '';
        $buyer_rating_    = !empty($buyer_rating) ? $buyer_rating : '';

        $subject_default 	 = esc_html__('Task completed', 'taskbot'); //default email subject
        $contact_default 	 = wp_kses(__('Congratulations! <br/> The buyer “{{buyer_name}}” has closed the ongoing task with the order #{{order_id}} and has left some comments <br/> "{{buyer_comments}}" <br/> Buyer rating: {{buyer_rating}} <br/> ', 'taskbot'),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          )
        );

        $subject		     = !empty( $taskbot_settings['order_completed_seller_subject'] ) ? $taskbot_settings['order_completed_seller_subject'] : $subject_default; //getting subject
        $email_content   = !empty( $taskbot_settings['order_completed_seller_content'] ) ? $taskbot_settings['order_completed_seller_content'] : $contact_default; //getting content
        $task_link__     = $this->process_email_links( $task_link_, $task_name_ );
        $login_link__     = $this->process_email_links( $login_url_, esc_html__('Login','taskbot') );

        $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
        $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_link__, $email_content);
        $email_content = str_replace("{{buyer_comments}}", $buyer_comments_, $email_content);
        $email_content = str_replace("{{buyer_rating}}", $buyer_rating_, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']    = 'seller_name';
        $greeting['greet_value']      = $seller_name_;
        $greeting['greet_option_key'] = 'order_completed_seller_greeting';

        $body   = $this->taskbot_email_body($email_content, $greeting);
        $body   = apply_filters('taskbot_order_completed_seller_email_content', $body);
        wp_mail($email_to, $subject, $body); //send Email

      }

      /* Order seller Activities */
      public function order_activities_seller_email($params = ''){
        global  $taskbot_settings;
        extract($params);

        $email_to           = !empty($receiver_email) ? $receiver_email : '';
        $sender_name_       = !empty($sender_name) ? $sender_name : '';
        $receiver_name_     = !empty($receiver_name) ? $receiver_name : '';
        $task_name_         = !empty($task_name) ? $task_name : '';
        $task_link_         = !empty($task_link) ? $task_link : '';
        $order_id_          = !empty($order_id) ? $order_id : '';
        $order_amount_      = !empty($order_amount) ? $order_amount : '';
        $login_url_         = !empty($login_url) ? $login_url : '';
        $sender_comments_   = !empty($sender_comments) ? $sender_comments : '';

        $subject_default 	 = esc_html__('Order activity', 'taskbot'); //default email subject
        $contact_default 	 = wp_kses(__('You have received a note from the “{{sender_name}}” on the ongoing task “{{task_name}}” against the order #{{order_id}} <br/> {{sender_comments}} <br/> You can login to take a quick action. <br/> {{login_url}} <br/> ', 'taskbot'),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          )
        );

        $subject		     = !empty( $taskbot_settings['order_activity_seller_subject'] ) ? $taskbot_settings['order_activity_seller_subject'] : $subject_default; //getting subject
        $email_content   = !empty( $taskbot_settings['order_activity_seller_content'] ) ? $taskbot_settings['order_activity_seller_content'] : $contact_default; //getting content
        $task_link__     = $this->process_email_links( $task_link_, $task_name_ );
        $login_url__     = $this->process_email_links( $login_url_, esc_html__('Login', 'taskbot') );

        $email_content = str_replace("{{sender_name}}", $sender_name_, $email_content);
        $email_content = str_replace("{{receiver_name}}", $receiver_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);
        $email_content = str_replace("{{sender_comments}}", $sender_comments_, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']    = 'receiver_name';
        $greeting['greet_value']      = $receiver_name_;
        $greeting['greet_option_key'] = 'order_activity_seller_gretting';

        $body   = $this->taskbot_email_body($email_content, $greeting);
        $body   = apply_filters('taskbot_order_activity_seller_email_content', $body);
        wp_mail($email_to, $subject, $body); //send Email


      }

      /* Order Buyer Activities */
      public function order_activities_buyer_email($params = ''){
        global  $taskbot_settings;
        extract($params);

        $email_to           = !empty($receiver_email) ? $receiver_email : '';
        $sender_name_       = !empty($sender_name) ? $sender_name : '';
        $receiver_name_     = !empty($receiver_name) ? $receiver_name : '';
        $task_name_         = !empty($task_name) ? $task_name : '';
        $task_link_         = !empty($task_link) ? $task_link : '';
        $order_id_          = !empty($order_id) ? $order_id : '';
        $order_amount_      = !empty($order_amount) ? $order_amount : '';
        $login_url_         = !empty($login_url) ? $login_url : '';
        $sender_comments_   = !empty($sender_comments) ? $sender_comments : '';

        $subject_default 	 = esc_html__('Order activity', 'taskbot'); //default email subject
        $contact_default 	 = wp_kses(__('You have received a note from the “{{sender_name}}” on the ongoing task “{{task_name}}” against the order #{{order_id}} <br/> {{sender_comments}} <br/> You can login to take a quick action. <br/> {{login_url}} <br/> ', 'taskbot'),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          )
        );

        $subject		     = !empty( $taskbot_settings['order_activity_buyer_subject'] ) ? $taskbot_settings['order_activity_buyer_subject'] : $subject_default; //getting subject
        $email_content   = !empty( $taskbot_settings['order_activity_buyer_content'] ) ? $taskbot_settings['order_activity_buyer_content'] : $contact_default; //getting content
        $task_link__     = $this->process_email_links( $task_link_, $task_name_ );
        $login_url__     = $this->process_email_links( $login_url_, esc_html__('Login', 'taskbot') );

        $email_content = str_replace("{{sender_name}}", $sender_name_, $email_content);
        $email_content = str_replace("{{receiver_name}}", $receiver_name_, $email_content);
        $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
        $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
        $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
        $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
        $email_content = str_replace("{{login_url}}", $login_url__, $email_content);
        $email_content = str_replace("{{sender_comments}}", $sender_comments_, $email_content);

        /* data for greeting */
        $greeting['greet_keyword']    = 'receiver_name';
        $greeting['greet_value']      = $receiver_name_;
        $greeting['greet_option_key'] = 'order_activity_buyer_gretting';

        $body   = $this->taskbot_email_body($email_content, $greeting);
        $body   = apply_filters('taskbot_order_activity_buyer_email_content', $body);
        wp_mail($email_to, $subject, $body); //send Email

      }

	}

	new TaskbotOrderStatuses();
}
