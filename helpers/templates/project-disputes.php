<?php

/**
 *
 * Class 'TaskbotProjectDisputes' defines dispute email
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */
if (!class_exists('TaskbotProjectDisputes')) {
    class TaskbotProjectDisputes extends Taskbot_Email_helper
    {
        public function __construct()
        {
            //do something
        }

        /* Email project dispute request to seller */
        public function dispute_project_request_seller_email($params = '')
        {
            global $taskbot_settings;
            extract($params);

            $email_to           = !empty($seller_email) ? $seller_email: '';
            $buyer_name 	    = !empty($buyer_name) ? $buyer_name: '';
            $seller_name 	    = !empty($seller_name) ? $seller_name : '';
            $project_title 	    = !empty($project_title) ? $project_title : '';
            $dispute_link 	    = !empty($dispute_link) ? $dispute_link : '';

            $subject_default    = esc_html__('Project refund request', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('Project refund request received from {{buyer_name}} of {{project_title}} project <br/>Please click on the button below to view the refund request.<br/>{{dispute_link}}', 'taskbot'), //default email content
            array(
            'a'       => array(
            'href'  => array(),
            'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
            ));

            $subject          = !empty( $taskbot_settings['seller_project_dispute_req_email_subject'] ) ? $taskbot_settings['seller_project_dispute_req_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty( $taskbot_settings['project_dispute_req_seller_mail_content'] ) ? $taskbot_settings['project_dispute_req_seller_mail_content'] : $contact_default; //getting content
            $proj_dispute_link     = $this->process_email_links($dispute_link, esc_html__('Project Dispute', 'taskbot')); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{dispute_link}}", $proj_dispute_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'seller_name';
            $greeting['greet_value']      = $seller_name;
            $greeting['greet_option_key'] = 'project_dispute_req_seller_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_seller_project_dispute_request_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /* Email project dispute request to admin by seller/buyer */
        public function dispute_project_request_admin_email($params = '')
        {
            global $taskbot_settings;
            extract($params);

            $email_to               = !empty( $taskbot_settings['project_dispute_req_email_admin'] ) ? $taskbot_settings['project_dispute_req_email_admin'] : get_option('admin_email', 'info@example.com');
            $user_name 	            = !empty($user_name) ? $user_name : '';
            $project_title          = !empty($project_title) ? $project_title : '';
            $admin_dispute_link     = !empty($admin_dispute_link) ? $admin_dispute_link : '';

            $subject_default    = esc_html__('Project dispute request', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('You have received a new dispute request from {{user_name}}<br/>Please click on the button below to view the dispute details.<br/>{{admin_dispute_link}}', 'taskbot'), //default email content
            array(
            'a'       => array(
            'href'  => array(),
            'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
            ));

            $subject            = !empty( $taskbot_settings['admin_project_dispute_req_email_subject'] ) ? $taskbot_settings['admin_project_dispute_req_email_subject'] : $subject_default; //getting subject
            $email_content      = !empty( $taskbot_settings['project_dispute_req_admin_mail_content'] ) ? $taskbot_settings['project_dispute_req_admin_mail_content'] : $contact_default; //getting content
            $proj_dispute_link  = $this->process_email_links($admin_dispute_link, esc_html__('Project Dispute', 'taskbot')); //project/post link

            $email_content = str_replace("{{user_name}}", $user_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{admin_dispute_link}}", $proj_dispute_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = '';
            $greeting['greet_value']      = '';
            $greeting['greet_option_key'] = '';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_admin_project_dispute_request_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /* Dispute refund in winner favour */
        public function project_dispute_refunded_resolved_in_favour($params = ''){
            global $taskbot_settings;
            extract($params);

            $email_to       = !empty($user_email) ? $user_email : '';
            $user_name 	    = !empty($user_name) ? $user_name: '';
            $admin_name     = !empty($admin_name) ? $admin_name: '';
            $dispute_link   = !empty($dispute_link) ? $dispute_link: '';

            $subject_default    = esc_html__('Project dispute refunded in favour', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('Woohoo! {{admin_name}} approved dispute refund request in your favor.<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'), //default email content
            array(
            'a'       => array(
            'href'  => array(),
            'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
            ));

            $subject            = !empty( $taskbot_settings['email_project_disputes_favour_winner_subject'] ) ? $taskbot_settings['email_project_disputes_favour_winner_subject'] : $subject_default; //getting subject
            $email_content      = !empty( $taskbot_settings['project_disputes_favour_winner_content'] ) ? $taskbot_settings['project_disputes_favour_winner_content'] : $contact_default; //getting content
            $dispute_link  = $this->process_email_links($dispute_link, esc_html__('Dispute link', 'taskbot')); //project/post link

            $email_content = str_replace("{{user_name}}", $user_name, $email_content);
            $email_content = str_replace("{{admin_name}}", $admin_name, $email_content);
            $email_content = str_replace("{{dispute_link}}", $dispute_link, $email_content); 
            
            /* data for greeting */
            $greeting['greet_keyword']    = 'user_name';
            $greeting['greet_value']      = $user_name;
            $greeting['greet_option_key'] = 'project_disputes_favour_winner_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_user_dispute_in_favour_content', $body);
            wp_mail($email_to, $subject, $body); //send Email
        }

        /* Dispute resolved in against looser */
        public function project_dispute_refunded_resolved_in_against($params = ''){
            global $taskbot_settings;
            extract($params);

            $email_to       = !empty($user_email) ? $user_email : '';
            $user_name 	    = !empty($user_name) ? $user_name: '';
            $admin_name     = !empty($admin_name) ? $admin_name: '';
            $dispute_link   = !empty($dispute_link) ? $dispute_link: '';

            $subject_default    = esc_html__('Project dispute not in favour', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('Oho! {{admin_name}} did not approve the dispute refund request in your favor.<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'), //default email content
            array(
                'a'       => array(
                'href'  => array(),
                'title' => array()
                ),
                'br'      => array(),
                'em'      => array(),
                'strong'  => array(),
            ));

            $subject            = !empty( $taskbot_settings['email_project_disputes_against_looser_subject'] ) ? $taskbot_settings['email_project_disputes_against_looser_subject'] : $subject_default; //getting subject
            $email_content      = !empty( $taskbot_settings['project_disputes_against_looser_content'] ) ? $taskbot_settings['project_disputes_against_looser_content'] : $contact_default; //getting content
            $dispute_link       = $this->process_email_links($dispute_link, esc_html__('Dispute link', 'taskbot')); //project/post link

            $email_content = str_replace("{{user_name}}", $user_name, $email_content);
            $email_content = str_replace("{{admin_name}}", $admin_name, $email_content);
            $email_content = str_replace("{{dispute_link}}", $dispute_link, $email_content); 
            
            /* data for greeting */
            $greeting['greet_keyword']    = 'user_name';
            $greeting['greet_value']      = $user_name;
            $greeting['greet_option_key'] = 'project_disputes_against_looser_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_user_dispute_in_against_content', $body);
            wp_mail($email_to, $subject, $body); //send Email
            
        }

        /* Project dispute refund decline by seller */
        public function project_dispute_refund_decline_by_seller($params = ''){
            global $taskbot_settings;
            extract($params);

            $email_to       = !empty($buyer_email) ? $buyer_email : '';
            $buyer_name     = !empty($buyer_name) ? $buyer_name: '';
            $seller_name    = !empty($seller_name) ? $seller_name: '';
            $dispute_link   = !empty($dispute_link) ? $dispute_link: '';

            $subject_default    = esc_html__('Project refund decline', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('Oho! A dispute has been declined by {{seller_name}}<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'), //default email content
            array(
                'a'       => array(
                'href'  => array(),
                'title' => array()
                ),
                'br'      => array(),
                'em'      => array(),
                'strong'  => array(),
            ));

            $subject            = !empty( $taskbot_settings['refund_project_request_decline_buyer_email_subject'] ) ? $taskbot_settings['refund_project_request_decline_buyer_email_subject'] : $subject_default; //getting subject
            $email_content      = !empty( $taskbot_settings['refund_project_request_decline_buyer_mail_content'] ) ? $taskbot_settings['refund_project_request_decline_buyer_mail_content'] : $contact_default; //getting content
            $dispute_link       = $this->process_email_links($dispute_link, esc_html__('Dispute link', 'taskbot')); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{dispute_link}}", $dispute_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'buyer_name';
            $greeting['greet_value']      = $buyer_name;
            $greeting['greet_option_key'] = 'refund_project_request_decline_buyer_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_buyer_project_refund_request_decline_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /* Project dispute refund approved by seller */
        public function project_dispute_refund_approve_by_seller($params = ''){
            global $taskbot_settings;
            extract($params);

            $email_to       = !empty($buyer_email) ? $buyer_email : '';
            $buyer_name     = !empty($buyer_name) ? $buyer_name: '';
            $seller_name    = !empty($seller_name) ? $seller_name: '';
            $dispute_link   = !empty($dispute_link) ? $dispute_link: '';

            $subject_default    = esc_html__('Project refund approved', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('Woohoo! {{seller_name}} approved dispute refund request in your favour.<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'), //default email content
            array(
                'a'       => array(
                'href'  => array(),
                'title' => array()
                ),
                'br'      => array(),
                'em'      => array(),
                'strong'  => array(),
            ));

            $subject            = !empty( $taskbot_settings['refund_project_request_approved_buyer_email_subject'] ) ? $taskbot_settings['refund_project_request_approved_buyer_email_subject'] : $subject_default; //getting subject
            $email_content      = !empty( $taskbot_settings['refund_project_request_approved_buyer_mail_content'] ) ? $taskbot_settings['refund_project_request_approved_buyer_mail_content'] : $contact_default; //getting content
            $dispute_link       = $this->process_email_links($dispute_link, esc_html__('Dispute link', 'taskbot')); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{dispute_link}}", $dispute_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'buyer_name';
            $greeting['greet_value']      = $buyer_name;
            $greeting['greet_option_key'] = 'refund_project_request_approved_buyer_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_buyer_project_refund_request_approved_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /* Project dispute refund approved by seller */
        public function project_dispute_admin_commnet_to_seller_buyer($params = ''){
            global $taskbot_settings;
            extract($params);

            $email_to           = !empty($user_email) ? $user_email : '';
            $user_name          = !empty($user_name) ? $user_name: '';
            $admin_name         = !empty($admin_name) ? $admin_name: '';
            $dispute_link       = !empty($dispute_link) ? $dispute_link: '';
            $dispute_comment    = !empty($dispute_comment) ? $dispute_comment: '';

            $subject_default    = esc_html__('Admin comment on dispute', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('You have received a new dispute comment from {{admin_name}}<br/>Please click on the button below to view the dispute comment.<br/>{{dispute_link}}', 'taskbot'), //default email content
            array(
                'a'       => array(
                'href'  => array(),
                'title' => array()
                ),
                'br'      => array(),
                'em'      => array(),
                'strong'  => array(),
            ));

            $subject            = !empty( $taskbot_settings['email_project_dispute_admin_comment_subject'] ) ? $taskbot_settings['email_project_dispute_admin_comment_subject'] : $subject_default; //getting subject
            $email_content      = !empty( $taskbot_settings['project_dispute_admin_comment_content'] ) ? $taskbot_settings['project_dispute_admin_comment_content'] : $contact_default; //getting content
            $dispute_link       = $this->process_email_links($dispute_link, esc_html__('Dispute link', 'taskbot')); //project/post link

            $email_content = str_replace("{{user_name}}", $user_name, $email_content);
            $email_content = str_replace("{{admin_name}}", $admin_name, $email_content);
            $email_content = str_replace("{{dispute_link}}", $dispute_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'user_name';
            $greeting['greet_value']      = $user_name;
            $greeting['greet_option_key'] = 'project_dispute_admin_comment_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_admin_comment_on_dispute_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /* Project dispute refund approved by seller */
        public function project_dispute_user_commnet_to_eachother($params = ''){
            global $taskbot_settings;
            extract($params);

            $email_to           = !empty($receiver_email) ? $receiver_email : '';
            $sender_name        = !empty($sender_name) ? $sender_name: '';
            $receiver_name      = !empty($receiver_name) ? $receiver_name: '';
            $dispute_link       = !empty($dispute_link) ? $dispute_link: '';
            $dispute_comment    = !empty($dispute_comment) ? $dispute_comment: '';

            $subject_default    = esc_html__('User comment on dispute', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('You have received a new dispute comment from {{sender_name}}<br/>Please click on the button below to view the dispute comment.<br/>{{dispute_link}}', 'taskbot'), //default email content
            array(
                'a'       => array(
                'href'  => array(),
                'title' => array()
                ),
                'br'      => array(),
                'em'      => array(),
                'strong'  => array(),
            ));

            $subject            = !empty( $taskbot_settings['email_project_dispute_user_comment_subject'] ) ? $taskbot_settings['email_project_dispute_user_comment_subject'] : $subject_default; //getting subject
            $email_content      = !empty( $taskbot_settings['project_dispute_user_comment_content'] ) ? $taskbot_settings['project_dispute_user_comment_content'] : $contact_default; //getting content
            $dispute_link       = $this->process_email_links($dispute_link, esc_html__('Dispute link', 'taskbot')); //project/post link

            $email_content = str_replace("{{sender_name}}", $sender_name, $email_content);
            $email_content = str_replace("{{receiver_name}}", $receiver_name, $email_content);
            $email_content = str_replace("{{dispute_link}}", $dispute_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'receiver_name';
            $greeting['greet_value']      = $receiver_name;
            $greeting['greet_option_key'] = 'project_dispute_user_comment_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_admin_comment_on_dispute_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }



    }
}
