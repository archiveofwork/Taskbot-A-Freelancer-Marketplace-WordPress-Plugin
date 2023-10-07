<?php
/**
 *
 * Class 'TaskbotProposals' defines task status
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if (!class_exists('TaskbotProposals')) {
    class TaskbotProposals extends Taskbot_Email_helper
  {
    public function __construct()
    {
      //do something
    }

    /**
     * Submit a proposal buyer email
     */
    public function submit_proposal_buyer_email($params = '') {
        global  $taskbot_settings;
        extract($params);

        $email_to           = !empty($buyer_email) ? $buyer_email : '';
        $buyer_name 	    = !empty($buyer_name) ? $buyer_name: '';
        $seller_name 	    = !empty($seller_name) ? $seller_name : '';
        $project_title 	    = !empty($project_title) ? $project_title : '';
        $proposal_link 	    = !empty($proposal_link) ? $proposal_link : '';

        $subject_default    = esc_html__('Submit Proposal', 'taskbot'); //default email subject
        $contact_default    = wp_kses(__('{{seller_name}} submit a new proposal on {{project_title}} Please click on the button below to view the proposal. {{proposal_link}}', 'taskbot'), //default email content
            array(
            'a'       => array(
            'href'  => array(),
            'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
            ));

            $subject          = !empty( $taskbot_settings['submit_proposal_buyer_email_subject'] ) ? $taskbot_settings['submit_proposal_buyer_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty( $taskbot_settings['submit_proposal_buyer_mail_content'] ) ? $taskbot_settings['submit_proposal_buyer_mail_content'] : $contact_default; //getting content
            $proposal_link     = $this->process_email_links($proposal_link, esc_html__('Proposal link', 'taskbot')); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{proposal_link}}", $proposal_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'buyer_name';
            $greeting['greet_value']      = $buyer_name;
            $greeting['greet_option_key'] = 'submit_proposal_buyer_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_buyer_proposal_submission_content', $body);
            wp_mail($email_to, $subject, $body); //send Email
    }

    /**
     * Submited proposal admin email
     */
    public function submited_proposal_admin_email($params = '') {
        global  $taskbot_settings;
        extract($params);

        $email_to         = !empty( $taskbot_settings['submited_proposal_admin_email'] ) ? $taskbot_settings['submited_proposal_admin_email'] : get_option('admin_email', 'info@example.com');
        $buyer_name 	    = !empty($buyer_name) ? $buyer_name: '';
        $seller_name 	    = !empty($seller_name) ? $seller_name : '';
        $project_title 	  = !empty($project_title) ? $project_title : '';
        $proposal_link     = !empty($proposal_link) ? $proposal_link : '';

        $subject_default    = esc_html__('Submited Proposal', 'taskbot'); //default email subject
        $contact_default    = wp_kses(__('{{seller_name}} submit a new proposal on {{project_title}} Please click on the button below to view the project. {{proposal_link}}', 'taskbot'), //default email content
            array(
            'a'       => array(
            'href'  => array(),
            'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
            ));

            $subject          = !empty( $taskbot_settings['submited_proposal_admin_email_subject'] ) ? $taskbot_settings['submited_proposal_admin_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty( $taskbot_settings['submited_proposal_admin_mail_content'] ) ? $taskbot_settings['submited_proposal_admin_mail_content'] : $contact_default; //getting content
            $proposal_link     = $this->process_email_links($proposal_link, esc_html__('Proposal link', 'taskbot')); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{proposal_link}}", $proposal_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = '';
            $greeting['greet_value']      = '';
            $greeting['greet_option_key'] = '';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_admin_proposal_submission_content', $body);
            wp_mail($email_to, $subject, $body); //send Email
        
    }

    /**
     * Decline proposal seller email
     */
    public function decline_proposal_seller_email($params = '') {
        global  $taskbot_settings;
        extract($params);

        $email_to           = !empty($seller_email) ? $seller_email: '';
        $buyer_name 	    = !empty($buyer_name) ? $buyer_name: '';
        $seller_name 	    = !empty($seller_name) ? $seller_name : '';
        $project_title 	    = !empty($project_title) ? $project_title : '';
        $proposal_link 	    = !empty($proposal_link) ? $proposal_link : '';

        $subject_default    = esc_html__('Proposal decline', 'taskbot'); //default email subject
        $contact_default    = wp_kses(__('Oho! your proposal on {{project_title}} has been rejected by {{buyer_name}}<br/>Please click on the button below to view the rejection reason.<br/>{{proposal_link}}', 'taskbot'), //default email content
            array(
            'a'       => array(
            'href'  => array(),
            'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
            ));

            $subject          = !empty( $taskbot_settings['proposal_decline_email_subject'] ) ? $taskbot_settings['proposal_decline_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty( $taskbot_settings['proposal_decline_seller_mail_content'] ) ? $taskbot_settings['proposal_decline_seller_mail_content'] : $contact_default; //getting content
            $proposal_link     = $this->process_email_links($proposal_link, esc_html__('Proposal link', 'taskbot')); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{proposal_link}}", $proposal_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'seller_name';
            $greeting['greet_value']      = $seller_name;
            $greeting['greet_option_key'] = 'proposal_decline_seller_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_seller_proposal_decline_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

    }

    /**
     * Hired proposal seller email
     */
    public function hired_proposal_seller_email($params = '') {
        global  $taskbot_settings;
        extract($params);

        $email_to           = !empty($seller_email) ? $seller_email: '';
        $buyer_name 	    = !empty($buyer_name) ? $buyer_name: '';
        $seller_name 	    = !empty($seller_name) ? $seller_name : '';
        $project_title 	    = !empty($project_title) ? $project_title : '';
        $project_link 	    = !empty($project_link) ? $project_link : '';

        $subject_default    = esc_html__('Hired proposal', 'taskbot'); //default email subject
        $contact_default    = wp_kses(__('Woohoo! {{buyer_name}} hired you for {{project_title}} project <br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'), //default email content
            array(
            'a'       => array(
            'href'  => array(),
            'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
            ));

            $subject          = !empty( $taskbot_settings['proposal_hired_email_subject'] ) ? $taskbot_settings['proposal_hired_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty( $taskbot_settings['proposal_hired_seller_mail_content'] ) ? $taskbot_settings['proposal_hired_seller_mail_content'] : $contact_default; //getting content
            $project_link     = $this->process_email_links($project_link, $project_title); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{project_link}}", $project_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'seller_name';
            $greeting['greet_value']      = $seller_name;
            $greeting['greet_option_key'] = 'proposal_hired_seller_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_seller_proposal_hired_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

    }

  }
}