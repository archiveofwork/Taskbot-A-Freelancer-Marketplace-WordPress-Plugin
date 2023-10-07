<?php
/**
 *
 * Class 'TaskbotRegistrationStatuses' defines task activities
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

if (!class_exists('TaskbotTaskActivityNotify')) {

    class TaskbotTaskActivityNotify extends Taskbot_Email_helper
    {

        public function __construct()
        {
        //do stuff here
        }


        /**
         * @Send activity request
         *
         * @since 1.0.0
         */
        public function send_activity_email($params = '')
        {
            global $taskbot_settings;
            extract($params);
            $email_to               = !empty($receiver_email) ? $receiver_email : '';
            $subject_default        = esc_html__('Seller & buyer activity', 'taskbot');
            $greeting_text_default  = wp_kses(__('Hello {{receiver_name}},', 'taskbot'), array('a' => array('href' => array(), 'title' => array()), 'br' => array(), 'em' => array(), 'strong' => array(),));
            $contact_default        = wp_kses(__('You have received a note from the {{sender_name}} on the ongoing task {{task_name}} against the order #{{order_id}}<br/><br/>
                                                    {{sender_comments}}<br/><br/>
                                                    You can login to take a quick action.
                                                    {{login_url}}', 'taskbot'),
                array(
                'a'         => array(
                    'href'    => array(),
                    'title'   => array()
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                ));

            $subject            = !empty($taskbot_settings['email_order_activity_subject']) ? $taskbot_settings['email_order_activity_subject'] : $subject_default;
            $email_content      = !empty($taskbot_settings['email_order_activity_content']) ? $taskbot_settings['email_order_activity_content'] : $contact_default;

            $login_process_link = $this->process_email_links($login_url, 'Login');

            $email_content  = str_replace("{{sender_name}}", $sender_name, $email_content);
            $email_content  = str_replace("{{receiver_name}}", $receiver_name, $email_content);
            $email_content  = str_replace("{{task_name}}", $task_name, $email_content);
            $email_content  = str_replace("{{task_link}}", $task_link, $email_content);
            $email_content  = str_replace("{{order_id}}", $order_id, $email_content);
            $email_content  = str_replace("{{order_amount}}", $order_amount, $email_content);
            $email_content  = str_replace("{{login_url}}", $login_process_link, $email_content);
            $email_content  = str_replace("{{sender_comments}}", $sender_comments, $email_content);
            
            /* data for greeting */
            $greeting['greet_keyword']    = 'receiver_name';
            $greeting['greet_value']      = $receiver_name;
            $greeting['greet_option_key'] = 'order_activity_seller_gretting';
            $body   = $this->taskbot_email_body($email_content, $greeting);
            $body   = apply_filters('taskbot_order_activity_email_content', $body);
            wp_mail($email_to, $subject, $body); //send Email

        }
    }

  new TaskbotTaskActivityNotify();
}
