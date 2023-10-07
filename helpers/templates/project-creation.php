<?php
/**
 *
 * Class 'TaskbotProjectCreation' defines task status
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if (!class_exists('TaskbotProjectCreation')) {


  class TaskbotProjectCreation extends Taskbot_Email_helper
  {

    public function __construct()
    {
      //do something
    }

    /**
     * Post a Project Buyer Email
     */
    public function post_project_buyer_email($params = '') {
      global  $taskbot_settings;
      extract($params);
      $email_to             = !empty($buyer_email) ? $buyer_email : '';
      $project_title 		    = !empty($project_title) ? $project_title: '';
      $buyer_name 	        = !empty($buyer_name) ? $buyer_name : '';
      $project_link 		    = !empty($project_link) ? $project_link : '';
      $subject_default 	    = esc_html__('Project submission', 'taskbot'); //default email subject
      $contact_default 	    = wp_kses(__('Thank you for submitting the project, we will review and approve the project after the review. <br/>{{signature}},<br/>', 'taskbot'), //default email content
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

      $subject          = !empty( $taskbot_settings['post_project_buyer_email_subject'] ) ? $taskbot_settings['post_project_buyer_email_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['post_project_content'] ) ? $taskbot_settings['post_project_content'] : $contact_default; //getting content
      $project_link     = $this->process_email_links($project_link, $project_title); //project/post link

      $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
      $email_content = str_replace("{{project_title}}", $project_title, $email_content);
      $email_content = str_replace("{{project_link}}", $project_link, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'buyer_name';
      $greeting['greet_value']      = $buyer_name;
      $greeting['greet_option_key'] = 'post_project_buyer_email_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_post_project_email_content', $body);

      wp_mail($email_to, $subject, $body); //send Email

    }


    /**
     * Post a Project need Admin Approval
     */
    public function post_project_approval_admin_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $buyer_name        = !empty($buyer_name) ? $buyer_name : '';
      $project_title     = !empty($project_title) ? $project_title : '';
      $project_link      = !empty($project_link) ? $project_link : '';
      $email_to 		     = !empty( $taskbot_settings['admin_email_project_approval'] ) ? $taskbot_settings['admin_email_project_approval'] : get_option('admin_email', 'info@example.com'); //admin email

      $subject_default 	  = esc_html__('Project approval', 'taskbot'); //default email subject
      $contact_default 	  = wp_kses(__('A new project {{project_title}} approval request received from {{buyer_name}}<br>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'), //default email content
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

      $subject		    = !empty( $taskbot_settings['project_approval_admin_email_subject'] ) ? $taskbot_settings['project_approval_admin_email_subject'] : $subject_default; //getting subject
      $email_content  = !empty( $taskbot_settings['project_approval_admin_mail_content'] ) ? $taskbot_settings['project_approval_admin_mail_content'] : $contact_default; //getting content
      $project_link   = $this->process_email_links($project_link, $project_title); //task/post link

      $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
      $email_content = str_replace("{{project_title}}", $project_title, $email_content);
      $email_content = str_replace("{{project_link}}", $project_link, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = '';
      $greeting['greet_value']      = '';
      $greeting['greet_option_key'] = '';

      $body = $this->taskbot_email_body($email_content, $greeting);

      $body  = apply_filters('taskbot_post_project_admin_email_approval_content', $body);

      wp_mail($email_to, $subject, $body); //send Email

    }


    /**
     * Project approved buyer Email
     */
    public function approved_project_buyer_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $email_to 	        = !empty($buyer_email) ? $buyer_email : '';
      $buyer_name 	      = !empty($buyer_name) ? $buyer_name : '';
      $project_title 	    = !empty($project_title) ? $project_title : '';
      $project_link 	    = !empty($project_link) ? $project_link : '';

      $subject_default 	  = esc_html__('Project approved!', 'taskbot'); //default email subject
      $contact_default 	  = wp_kses(__('Woohoo! Your project {{project_title}} has been approved.<br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'), //default email content
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

      $subject		      = !empty( $taskbot_settings['project_approved_buyer_subject'] ) ? $taskbot_settings['project_approved_buyer_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['project_approved_project_content'] ) ? $taskbot_settings['project_approved_project_content'] : $contact_default; //getting content

      $project_link_      = $this->process_email_links($project_link, $project_title); //task/post link

      $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
      $email_content = str_replace("{{project_title}}", $project_title, $email_content);
      $email_content = str_replace("{{project_link}}", $project_link_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'buyer_name';
      $greeting['greet_value']      = $buyer_name;
      $greeting['greet_option_key'] = 'project_approved_project_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_seller_task_approved_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /**
     * Project rejected Email to buyer
     */
    public function reject_project_buyer_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $email_to             = !empty($buyer_email) ? $buyer_email : '';
      $buyer_name 	        = !empty($buyer_name) ? $buyer_name : '';
      $project_title 	      = !empty($project_title) ? $project_title : '';
      $project_link 	      = !empty($project_link) ? $project_link : '';

      $subject_default 	    = esc_html__('Project rejection', 'taskbot'); //default email subject
      $contact_default 	    = wp_kses(__('Oho! Your project {{project_title}} has been rejected.<br /> Please click on the link below to view the project. {{project_link}}', 'taskbot'), //default email content
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

      $subject		      = !empty( $taskbot_settings['project_rejected_buyer_subject'] ) ? $taskbot_settings['project_rejected_buyer_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['project_rejected_buyer_content'] ) ? $taskbot_settings['project_rejected_buyer_content'] : $contact_default; //getting content

      $project_link      = $this->process_email_links($project_link, $project_title); //task/post link

      $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
      $email_content = str_replace("{{project_title}}", $project_title, $email_content);
      $email_content = str_replace("{{project_link}}", $project_link, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'buyer_name';
      $greeting['greet_value']      = $buyer_name;
      $greeting['greet_option_key'] = 'project_rejected_buyer_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_buyer_project_rejected_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /**
     * Project invitation Email to seller
     */
    public function invitation_project_seller_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $email_to             = !empty($seller_email) ? $seller_email : '';
      $buyer_name 	        = !empty($buyer_name) ? $buyer_name : '';
      $seller_name 	        = !empty($seller_name) ? $seller_name : '';
      $project_title 	      = !empty($project_title) ? $project_title : '';
      $project_link 	      = !empty($project_link) ? $project_link : '';

      $subject_default 	    = esc_html__('Project invitation', 'taskbot'); //default email subject
      $contact_default 	    = wp_kses(__('You have received a project invitation from {{buyer_name}} Please click on the link below to view the project. {{project_link}}', 'taskbot'), //default email content
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

      $subject		      = !empty( $taskbot_settings['project_invitation_email_subject'] ) ? $taskbot_settings['project_invitation_email_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['project_invitation_seller_mail_content'] ) ? $taskbot_settings['project_invitation_seller_mail_content'] : $contact_default; //getting content

      $project_link      = $this->process_email_links($project_link, $project_title); //task/post link

      $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
      $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
      $email_content = str_replace("{{project_title}}", $project_title, $email_content);
      $email_content = str_replace("{{project_link}}", $project_link, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'seller_name';
      $greeting['greet_value']      = $seller_name;
      $greeting['greet_option_key'] = 'project_invitation_seller_email_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_seller_project_invitation_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

    /**
     * Project activity Email to receiver
     * (comments)
     */
    public function project_activity_receiver_email($params = '') {
      global  $taskbot_settings;
      extract($params);

      $email_to             = !empty($reciever_email) ? $reciever_email : '';
      $sender_name 	        = !empty($sender_name) ? $sender_name : '';
      $receiver_name 	      = !empty($receiver_name) ? $receiver_name : '';
      $project_title 	      = !empty($project_title) ? $project_title : '';
      $project_link 	      = !empty($project_link) ? $project_link : '';

      $subject_default 	    = esc_html__('Project activity', 'taskbot'); //default email subject
      $contact_default 	    = wp_kses(__('A new activity performed by {{sender_name}} on a {{project_title}} project<br/>Please click on the button below to view the activity.<br/>{{project_link}}', 'taskbot'), //default email content
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

      $subject		      = !empty( $taskbot_settings['project_activity_receiver_email_subject'] ) ? $taskbot_settings['project_activity_receiver_email_subject'] : $subject_default; //getting subject
      $email_content    = !empty( $taskbot_settings['project_activity_receiver_mail_content'] ) ? $taskbot_settings['project_activity_receiver_mail_content'] : $contact_default; //getting content
      $project_link      = $this->process_email_links($project_link, $project_title); //task/post link

      $email_content = str_replace("{{sender_name}}", $sender_name, $email_content);
      $email_content = str_replace("{{receiver_name}}", $receiver_name, $email_content);
      $email_content = str_replace("{{project_title}}", $project_title, $email_content);
      $email_content = str_replace("{{project_link}}", $project_link, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']    = 'receiver_name';
      $greeting['greet_value']      = $receiver_name;
      $greeting['greet_option_key'] = 'project_activity_receiver_email_greeting';

      $body   = $this->taskbot_email_body($email_content, $greeting);
      $body   = apply_filters('taskbot_receiver_project_activity_content', $body);
      wp_mail($email_to, $subject, $body); //send Email

    }

}
  new TaskbotProjectCreation();
}



