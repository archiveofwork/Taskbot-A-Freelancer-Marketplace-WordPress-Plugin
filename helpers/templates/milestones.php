<?php

/**
 *
 * Class 'TaskbotMilestones' defines task status
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

if (!class_exists('TaskbotMilestones')) {
    class TaskbotMilestones extends Taskbot_Email_helper
    {
        public function __construct()
        {
            //do something
        }

        /**
         * Hire milestone seller email
         */
        public function hire_milestone_seller_email($params = '')
        {
            global  $taskbot_settings;
            extract($params);

            $email_to           = !empty($seller_email) ? $seller_email : '';
            $buyer_name         = !empty($buyer_name) ? $buyer_name : '';
            $seller_name        = !empty($seller_name) ? $seller_name : '';
            $project_title      = !empty($project_title) ? $project_title : '';
            $project_link       = !empty($project_link) ? $project_link : '';
            $milestone_title    = !empty($milestone_title) ? $milestone_title : '';

            $subject_default    = esc_html__('Milestone hired', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('Your milestone {{milestone_title}} of {{project_title}} has been approved <br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'), //default email content
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

            $subject          = !empty($taskbot_settings['milestone_hired_email_subject']) ? $taskbot_settings['milestone_hired_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty($taskbot_settings['milestone_hire_seller_mail_content']) ? $taskbot_settings['milestone_hire_seller_mail_content'] : $contact_default; //getting content
            $project_link     = $this->process_email_links($project_link, $project_title); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{milestone_title}}", $milestone_title, $email_content);
            $email_content = str_replace("{{project_link}}", $project_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'seller_name';
            $greeting['greet_value']      = $seller_name;
            $greeting['greet_option_key'] = 'milestone_hire_seller_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_seller_milestone_hired_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /**
         * Milestone approval request
         */
        public function approval_milestone_req_buyer_email($params = '')
        {
            global  $taskbot_settings;
            extract($params);

            $email_to           = !empty($buyer_email) ? $buyer_email : '';
            $buyer_name         = !empty($buyer_name) ? $buyer_name : '';
            $seller_name        = !empty($seller_name) ? $seller_name : '';
            $project_title      = !empty($project_title) ? $project_title : '';
            $milestone_link     = !empty($milestone_link) ? $milestone_link : '';
            $milestone_title    = !empty($milestone_title) ? $milestone_title : '';

            $subject_default    = esc_html__('Milestone approval request', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('A new milestone {{milestone_title}} of {{project_title}} approval received from {{seller_name}}<br/>Please click on the button below to view the milestone.<br/>{{milestone_link}}', 'taskbot'), //default email content
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

            $subject          = !empty($taskbot_settings['req_milestone_approval_buyer_email_subject']) ? $taskbot_settings['req_milestone_approval_buyer_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty($taskbot_settings['req_milestone_approval_buyer_mail_content']) ? $taskbot_settings['req_milestone_approval_buyer_mail_content'] : $contact_default; //getting content
            $milestone_link     = $this->process_email_links($milestone_link, $milestone_title); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{milestone_title}}", $milestone_title, $email_content);
            $email_content = str_replace("{{milestone_link}}", $milestone_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'buyer_name';
            $greeting['greet_value']      = $buyer_name;
            $greeting['greet_option_key'] = 'req_milestone_approval_buyer_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_buyer_milestone_approval_request_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /**
         * Milestone complete
         */
        public function milestone_complete_seller_email($params = '')
        {
            global  $taskbot_settings;
            extract($params);

            $email_to           = !empty($seller_email) ? $seller_email : '';
            $buyer_name         = !empty($buyer_name) ? $buyer_name : '';
            $seller_name         = !empty($seller_name) ? $seller_name : '';
            $project_title         = !empty($project_title) ? $project_title : '';
            $project_link       = !empty($project_link) ? $project_link : '';
            $milestone_title    = !empty($milestone_title) ? $milestone_title : '';

            $subject_default    = esc_html__('Milestone completed', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('You milestone {{milestone_title}} of {{project_title}} marked as completed by {{buyer_name}}<br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'), //default email content
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

            $subject          = !empty($taskbot_settings['milestone_complete_email_subject']) ? $taskbot_settings['milestone_complete_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty($taskbot_settings['milestone_complete_seller_mail_content']) ? $taskbot_settings['milestone_complete_seller_mail_content'] : $contact_default; //getting content
            $project_link     = $this->process_email_links($project_link, $project_title); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{milestone_title}}", $milestone_title, $email_content);
            $email_content = str_replace("{{project_link}}", $project_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'seller_name';
            $greeting['greet_value']      = $seller_name;
            $greeting['greet_option_key'] = 'milestone_complete_seller_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_seller_milestone_complete_content', $body);
            wp_mail($email_to, $subject, $body); //send Email
        }

        /**
         * Milestone decline
         */
        public function milestone_decline_seller_email($params = '')
        {
            global  $taskbot_settings;
            extract($params);

            $email_to           = !empty($seller_email) ? $seller_email : '';
            $buyer_name         = !empty($buyer_name) ? $buyer_name : '';
            $seller_name        = !empty($seller_name) ? $seller_name : '';
            $project_title      = !empty($project_title) ? $project_title : '';
            $project_link       = !empty($project_link) ? $project_link : '';
            $milestone_title    = !empty($milestone_title) ? $milestone_title : '';

            $subject_default    = esc_html__('Milestone decline', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('Your milestone {{milestone_title}} of {{project_title}} has been declined by {{buyer_name}}<br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'), //default email content
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

            $subject          = !empty($taskbot_settings['milestone_decline_email_subject']) ? $taskbot_settings['milestone_decline_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty($taskbot_settings['milestone_decline_seller_mail_content']) ? $taskbot_settings['milestone_decline_seller_mail_content'] : $contact_default; //getting content
            $project_link     = $this->process_email_links($project_link, $project_title); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{milestone_title}}", $milestone_title, $email_content);
            $email_content = str_replace("{{project_link}}", $project_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'seller_name';
            $greeting['greet_value']      = $seller_name;
            $greeting['greet_option_key'] = 'milestone_decline_seller_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_seller_milestone_decline_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }

        /**
         * Milestone decline
         */
        public function project_new_milestone_buyer_email($params = '')
        {
            global  $taskbot_settings;
            extract($params);

            $email_to           = !empty($buyer_email) ? $buyer_email : '';
            $buyer_name         = !empty($buyer_name) ? $buyer_name : '';
            $seller_name        = !empty($seller_name) ? $seller_name : '';
            $project_title      = !empty($project_title) ? $project_title : '';
            $project_link       = !empty($project_link) ? $project_link : '';

            $subject_default    = esc_html__('Project new milestone', 'taskbot'); //default email subject
            $contact_default    = wp_kses(__('{{seller_name}} add new milestone for the project {{project_title}}<br/>Please click on the button below to view the project history.<br/>{{project_link}}', 'taskbot'), //default email content
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

            $subject          = !empty($taskbot_settings['new_project_milestone_buyer_email_subject']) ? $taskbot_settings['new_project_milestone_buyer_email_subject'] : $subject_default; //getting subject
            $email_content    = !empty($taskbot_settings['new_project_milestone_buyer_mail_content']) ? $taskbot_settings['new_project_milestone_buyer_mail_content'] : $contact_default; //getting content
            $project_link     = $this->process_email_links($project_link, $project_title); //project/post link

            $email_content = str_replace("{{buyer_name}}", $buyer_name, $email_content);
            $email_content = str_replace("{{seller_name}}", $seller_name, $email_content);
            $email_content = str_replace("{{project_title}}", $project_title, $email_content);
            $email_content = str_replace("{{project_link}}", $project_link, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']    = 'buyer_name';
            $greeting['greet_value']      = $buyer_name;
            $greeting['greet_option_key'] = 'new_project_milestone_buyer_email_greeting';

            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_buyer_new_project_milestone_content', $body);
            wp_mail($email_to, $subject, $body); //send Email


        }

    }
}
