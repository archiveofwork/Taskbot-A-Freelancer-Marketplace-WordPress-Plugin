<?php
/**
 *
 * Class 'TaskbotRefundsStatuses' defines refund
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

if (!class_exists('TaskbotRefundsStatuses')) {

  class TaskbotRefundsStatuses extends Taskbot_Email_helper
  {
    public function __construct()
    {
      //do something
    }

    /* Refund seller comments Email */
    public function refund_admin_comments_email($params = ''){
      global $taskbot_settings;
      extract($params);

      $email_to           = !empty($receiver_email) ? $receiver_email : '';
      $sender_name_       = !empty($sender_name) ? $sender_name : '';
      $receiver_name_     = !empty($receiver_name) ? $receiver_name : '';
      $task_name_         = !empty($task_name) ? $task_name : '';
      $task_link_         = !empty($task_link) ? $task_link : '';
      $order_id_          = !empty($order_id) ? $order_id : '';
      $order_amount_      = !empty($order_amount) ? $order_amount : 0;
      $login_url_         = !empty($login_url) ? $login_url : '';
      $sender_comments_   = !empty($sender_comments) ? $sender_comments : '';

      $subject_default 	        = esc_html__('A new comment on refund request', 'taskbot'); //default email subject
      $contact_default 	        = wp_kses(__('The Admin has left some comments on the refund request against the order #{{order_id}} <br/>{{sender_comments}} <br/> {login_url}}', 'taskbot'),
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

      $subject		            = !empty( $taskbot_settings['refund_admin_comment_subject'] ) ? $taskbot_settings['refund_admin_comment_subject'] : $subject_default; //getting subject
      $email_content          = !empty( $taskbot_settings['refund_admin_comment_content'] ) ? $taskbot_settings['refund_admin_comment_content'] : $contact_default; //getting content

      $task_link__            = $this->process_email_links($task_link_, $task_name_ );
      $login_url__            = $this->process_email_links($login_url_, esc_html__('Login','taskbot') );

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
      $greeting['greet_option_key'] = 'order_refund_admin_comment_email_greeting';

      $body = $this->taskbot_email_body($email_content, $greeting);
      $body  = apply_filters('taskbot_admin_refund_comments_email_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /* Email Refund for seller */
    public function refund_seller_email($params = ''){
      global $taskbot_settings;
      extract($params);

      $email_to         = !empty($seller_email) ? $seller_email : '';
      $seller_name_     = !empty($seller_name) ? $seller_name : '';
      $buyer_name_      = !empty($buyer_name) ? $buyer_name : '';
      $task_name_       = !empty($task_name) ? $task_name : '';
      $task_link_       = !empty($task_link) ? $task_link : '';
      $order_id_        = !empty($order_id) ? $order_id : '';
      $order_amount_    = !empty($order_amount) ? $order_amount : 0;
      $login_url_       = !empty($login_url) ? $login_url : '';
      $buyer_comments_  = !empty($buyer_comments) ? $buyer_comments : '';

      $subject_default 	        = esc_html__('A new refund request received', 'taskbot'); //default email subject
      $contact_default 	        = wp_kses(__('You have received a refund request from {{buyer_name}} against the order #{{order_id}} <br/> {{buyer_comments}} <br/> You can approve or decline the refund request.<br/>{{login_url}}', 'taskbot'),
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

      $subject		            = !empty( $taskbot_settings['new_seller_refund_subject'] ) ? $taskbot_settings['new_seller_refund_subject'] : $subject_default; //getting subject
      $email_content          = !empty( $taskbot_settings['new_seller_refund_content'] ) ? $taskbot_settings['new_seller_refund_content'] : $contact_default; //getting content

      $task_link__            = $this->process_email_links($task_link_, $task_name_);
      $login_url__            = $this->process_email_links($login_url_, esc_html__('Login','taskbot'));

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
      $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
      $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
      $email_content = str_replace("{{login_url}}", $login_url__, $email_content);
      $email_content = str_replace("{{buyer_comments}}", $buyer_comments_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword'] = 'seller_name';
      $greeting['greet_value'] = $seller_name_;
      $greeting['greet_option_key'] = 'new_seller_refund_email_greeting';

      $body = $this->taskbot_email_body($email_content, $greeting);
      $body  = apply_filters('taskbot_seller_refund_email_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /* Refund Approved */
    public function refund_approved_buyer_email($params = ''){
      global $taskbot_settings;
      extract($params);

      $email_to           = !empty($buyer_email) ? $buyer_email : '';
      $seller_name_       = !empty($seller_name) ? $seller_name : '';
      $buyer_name_        = !empty($buyer_name) ? $buyer_name : '';
      $task_name_         = !empty($task_name) ? $task_name : '';
      $task_link_         = !empty($task_link) ? $task_link : '';
      $order_id_          = !empty($order_id) ? $order_id : '';
      $order_amount_      = !empty($order_amount) ? $order_amount : 0;
      $login_url_         = !empty($login_url) ? $login_url : '';

      $subject_default 	        = esc_html__('Refund approved', 'taskbot'); //default email subject
      $contact_default 	        = wp_kses(__('Congratulations! <br/> Your refund request has been approved by the {{seller_name}} against the order #{{order_id}}', 'taskbot'),
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

      $subject		            = !empty( $taskbot_settings['buyer_approved_refund_subject'] ) ? $taskbot_settings['buyer_approved_refund_subject'] : $subject_default; //getting subject
      $email_content          = !empty( $taskbot_settings['approved_buyer_refund_content'] ) ? $taskbot_settings['approved_buyer_refund_content'] : $contact_default; //getting content

      $task_link__            = $this->process_email_links($task_link_, $task_name_ );

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
      $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
      $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
      $email_content = str_replace("{{login_url}}", $login_url_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword'] = 'buyer_name';
      $greeting['greet_value'] = $buyer_name_;
      $greeting['greet_option_key'] = 'buyer_approved_refund_email_greeting';

      $body = $this->taskbot_email_body($email_content, $greeting);
      $body  = apply_filters('taskbot_buyer_refund_approved_email_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /* Refund Decline */
    public function refund_declined_buyer_email($params = ''){
      global $taskbot_settings;
      extract($params);

      $email_to       = !empty($buyer_email) ? $buyer_email : '';
      $seller_name_   = !empty($seller_name) ? $seller_name : '';
      $buyer_name_    = !empty($buyer_name) ? $buyer_name : '';
      $task_name_     = !empty($task_name) ? $task_name : '';
      $task_link_     = !empty($task_link) ? $task_link : '';
      $order_id_      = !empty($order_id) ? $order_id : '';
      $order_amount_  = !empty($order_amount) ? $order_amount : 0;
      $login_url_     = !empty($login_url) ? $login_url : '';

      $subject_default 	        = esc_html__('Refund declined', 'taskbot'); //default email subject
      $contact_default 	        = wp_kses(__('Your refund request has been declined by the {{seller_name}} against the order #{{order_id}} <br/> If you think that this was a valid request then you can raise a dispute from the ongoing task page. <br/> {login_url}}', 'taskbot'),
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

      $subject		            = !empty( $taskbot_settings['buyer_declined_refund_subject'] ) ? $taskbot_settings['buyer_declined_refund_subject'] : $subject_default; //getting subject
      $email_content          = !empty( $taskbot_settings['declined_buyer_refund_content'] ) ? $taskbot_settings['declined_buyer_refund_content'] : $contact_default; //getting content

      $task_link__            = $this->process_email_links($task_link_, $task_name_ );
      $login_url__            = $this->process_email_links($login_url_, esc_html__("Login","taskbot"));

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{buyer_name}}", $buyer_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
      $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
      $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
      $email_content = str_replace("{{login_url}}", $login_url__, $email_content);

      /* data for greeting */
      $greeting['greet_keyword'] = 'buyer_name';
      $greeting['greet_value'] = $buyer_name_;
      $greeting['greet_option_key'] = 'buyer_declined_refund_email_greeting';

      $body = $this->taskbot_email_body($email_content, $greeting);
      $body  = apply_filters('taskbot_buyer_refund_declined_email_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /* Refund seller comments Email */
    public function refund_seller_comments_email($params = ''){
      global $taskbot_settings;
      extract($params);

      $email_to           = !empty($receiver_email) ? $receiver_email : '';
      $sender_name_       = !empty($sender_name) ? $sender_name : '';
      $receiver_name_     = !empty($receiver_name) ? $receiver_name : '';
      $task_name_         = !empty($task_name) ? $task_name : '';
      $task_link_         = !empty($task_link) ? $task_link : '';
      $order_id_          = !empty($order_id) ? $order_id : '';
      $order_amount_      = !empty($order_amount) ? $order_amount : 0;
      $login_url_         = !empty($login_url) ? $login_url : '';
      $sender_comments_   = !empty($sender_comments) ? $sender_comments : '';

      $subject_default 	        = esc_html__('A new comment on refund request', 'taskbot'); //default email subject
      $contact_default 	        = wp_kses(__('The “{{sender_name}}” has left some comments on the refund request against the order #{{order_id}} <br/>{{sender_comments}} <br/> {login_url}}', 'taskbot'),
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

      $subject		            = !empty( $taskbot_settings['refund_seller_comment_subject'] ) ? $taskbot_settings['refund_seller_comment_subject'] : $subject_default; //getting subject
      $email_content          = !empty( $taskbot_settings['refund_seller_comment_content'] ) ? $taskbot_settings['refund_seller_comment_content'] : $contact_default; //getting content

      $task_link__            = $this->process_email_links($task_link_, $task_name_ );
      $login_url__            = $this->process_email_links($login_url_, esc_html__('Login','taskbot') );

      $email_content = str_replace("{{sender_name}}", $sender_name_, $email_content);
      $email_content = str_replace("{{receiver_name}}", $receiver_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
      $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
      $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
      $email_content = str_replace("{{login_url}}", $login_url__, $email_content);
      $email_content = str_replace("{{sender_comments}}", $sender_comments_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword'] = 'receiver_name';
      $greeting['greet_value'] = $receiver_name_;
      $greeting['greet_option_key'] = 'order_refund_seller_comment_email_greeting';

      $body = $this->taskbot_email_body($email_content, $greeting);
      $body  = apply_filters('taskbot_seller_refund_comments_email_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /* Refund buyer comments Email */
    public function refund_buyer_comments_email($params = ''){
      global $taskbot_settings;
      extract($params);

      $email_to           = !empty($receiver_email) ? $receiver_email : '';
      $sender_name_       = !empty($sender_name) ? $sender_name : '';
      $receiver_name_     = !empty($receiver_name) ? $receiver_name : '';
      $task_name_         = !empty($task_name) ? $task_name : '';
      $task_link_         = !empty($task_link) ? $task_link : '';
      $order_id_          = !empty($order_id) ? $order_id : '';
      $order_amount_      = !empty($order_amount) ? $order_amount : 0;
      $login_url_         = !empty($login_url) ? $login_url : '';
      $sender_comments_   = !empty($sender_comments) ? $sender_comments : '';

      $subject_default 	        = esc_html__('A new comment on refund request', 'taskbot'); //default email subject
      $contact_default 	        = wp_kses(__('The “{{sender_name}}” has left some comments on the refund request against the order #{{order_id}} <br/>{{sender_comments}} <br/> {login_url}}', 'taskbot'),
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

      $subject		            = !empty( $taskbot_settings['refund_buyer_comment_subject'] ) ? $taskbot_settings['refund_buyer_comment_subject'] : $subject_default; //getting subject
      $email_content          = !empty( $taskbot_settings['refund_buyer_comment_content'] ) ? $taskbot_settings['refund_buyer_comment_content'] : $contact_default; //getting content

      $task_link__ = $this->process_email_links($task_link_, $task_name_ );
      $login_url__ = $this->process_email_links($login_url_, esc_html__('Login','taskbot') );

      $email_content = str_replace("{{sender_name}}", $sender_name_, $email_content);
      $email_content = str_replace("{{receiver_name}}", $receiver_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
      $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
      $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
      $email_content = str_replace("{{login_url}}", $login_url__, $email_content);
      $email_content = str_replace("{{sender_comments}}", $sender_comments_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword'] = 'receiver_name';
      $greeting['greet_value'] = $receiver_name_;
      $greeting['greet_option_key'] = 'refund_buyer_comment_greeting';

      $body = $this->taskbot_email_body($email_content, $greeting);
      $body  = apply_filters('taskbot_buyer_refund_comments_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }


  }

  new TaskbotRefundsStatuses();
}
