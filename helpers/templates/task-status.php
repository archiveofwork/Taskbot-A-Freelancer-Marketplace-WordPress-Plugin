<?php
/**
 *
 * Class 'TaskbotRegistrationStatuses' defines task status
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if (!class_exists('TaskbotTaskStatuses')) {


  class TaskbotTaskStatuses extends Taskbot_Email_helper
  {

    public function __construct()
    {
      //do something
    }

    /**
     * Post a Task Seller Email
     */
    public function post_task_seller_email($params = '') {
      global  $taskbot_settings;
      extract($params);
      $email_to             = !empty($seller_email) ? $seller_email : '';
      $task_name_ 		      = !empty($task_name) ? $task_name: '';
      $seller_name_ 	      = !empty($seller_name) ? $seller_name : '';
      $task_link 		        = !empty($task_link) ? $task_link : '';
      $subject_default 	    = esc_html__('Task submission', 'taskbot'); //default email subject
      $contact_default 	    = wp_kses(__('Thank you for submitting the task, we will review and approve the task after the review. <br/>{{signature}},<br/>', 'taskbot'), //default email content
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

      $subject          = !empty( $taskbot_settings['post_task_seller_email_subject'] ) ? $taskbot_settings['post_task_seller_email_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['post_task_content'] ) ? $taskbot_settings['post_task_content'] : $contact_default; //getting content
      $task_link_       = $this->process_email_links($task_link, $task_name_); //task/post link

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'seller_name';
      $greeting['greet_value']      = $seller_name_;
      $greeting['greet_option_key'] = 'post_task_seller_email_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_post_task_email_content', $body);

      wp_mail($email_to, $subject, $body); //send Email

    }


    /**
     * Post a Task need Admin Approval
     */
    public function post_task_approval_admin_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $seller_name_        = !empty($seller_name) ? $seller_name : '';
      $task_name_          = !empty($task_name) ? $task_name : '';
      $task_link           = !empty($task_link) ? $task_link : '';
      $email_to 		   = !empty( $taskbot_settings['admin_email_task_approval'] ) ? $taskbot_settings['admin_email_task_approval'] : get_option('admin_email', 'info@example.com'); //admin email

      $subject_default 	  = esc_html__('Task approval', 'taskbot'); //default email subject
      $contact_default 	  = wp_kses(__('A new task has been posted by the {{seller_name}}, your approval is required to make it live.<br/>', 'taskbot'), //default email content
        array(
          'a'         => array(
            'href'    => array(),
            'title'   => array()
          ),
          'br'        => array(),
          'em'        => array(),
          'strong'    => array(),
        )
      );

      $subject		    = !empty( $taskbot_settings['task_approval_admin_email_subject'] ) ? $taskbot_settings['task_approval_admin_email_subject'] : $subject_default; //getting subject
      $email_content  = !empty( $taskbot_settings['task_approval_admin_mail_content'] ) ? $taskbot_settings['task_approval_admin_mail_content'] : $contact_default; //getting content
      $task_link_      = $this->process_email_links($task_link, $task_name_); //task/post link

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword'] = '';
      $greeting['greet_value'] = '';
      $greeting['greet_option_key'] = '';

      $body = $this->taskbot_email_body($email_content, $greeting);

      $body  = apply_filters('taskbot_post_task_admin_email_approval_content', $body);

      wp_mail($email_to, $subject, $body); //send Email

    }


    /**
     * Task approved Seller Email
     */
    public function approved_task_seller_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $email_to 	    = !empty($seller_email) ? $seller_email : '';
      $seller_name_ 	= !empty($seller_name) ? $seller_name : '';
      $task_name_ 	    = !empty($task_name) ? $task_name : '';
      $task_link_ 	    = !empty($task_link) ? $task_link : '';

      $subject_default 	  = esc_html__('Task approved!', 'taskbot'); //default email subject
      $contact_default 	  = wp_kses(__('Your task “{{task_name}}” has been approved. <br/> You can view your task here <br/> {{task_link}} <br/>', 'taskbot'), //default email content
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

      $subject		      = !empty( $taskbot_settings['task_approved_seller_subject'] ) ? $taskbot_settings['task_approved_seller_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['task_approved_seller_content'] ) ? $taskbot_settings['task_approved_seller_content'] : $contact_default; //getting content

      $task_link__      = $this->process_email_links($task_link_, $task_name_); //task/post link

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link__, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'seller_name';
      $greeting['greet_value']      = $seller_name_;
      $greeting['greet_option_key'] = 'task_approved_seller_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_seller_task_approved_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /**
     * Task rejected Email to seller
     */
    public function reject_task_seller_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $email_to             = !empty($seller_email) ? $seller_email : '';
      $seller_name_ 	    = !empty($seller_name) ? $seller_name : '';
      $task_name_ 	        = !empty($task_name) ? $task_name : '';
      $task_link_ 	        = !empty($task_link) ? $task_link : '';
      $admin_feedback_ 	    = !empty($admin_feedback) ? $admin_feedback : '';

      $subject_default 	    = esc_html__('Task rejected', 'taskbot'); //default email subject
      $contact_default 	    = wp_kses(__('Your task “{{task_name}}” has been rejected. <br/> Please make the required changes and submit it again.<br/> {{admin_feedback}} <br/> ', 'taskbot'), //default email content
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

      $subject		      = !empty( $taskbot_settings['task_rejected_seller_subject'] ) ? $taskbot_settings['task_rejected_seller_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['task_rejected_seller_content'] ) ? $taskbot_settings['task_rejected_seller_content'] : $contact_default; //getting content

      $task_link__      = $this->process_email_links($task_link_, $task_name_); //task/post link

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{task_name}}", $task_name_, $email_content);
      $email_content = str_replace("{{task_link}}", $task_link__, $email_content);
      $email_content = str_replace("{{admin_feedback}}", $admin_feedback_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'seller_name';
      $greeting['greet_value']      = $seller_name_;
      $greeting['greet_option_key'] = 'task_rejected_seller_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_seller_task_rejected_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }
}
  new TaskbotTaskStatuses();
}



