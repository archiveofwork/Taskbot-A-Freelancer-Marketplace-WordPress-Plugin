<?php
/**
 *
 * Class 'DeactiveUserAcoount' defines User active or deactive
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if (!class_exists('DeactiveUserAcoount')) {

    class DeactiveUserAcoount extends Taskbot_Email_helper{

        public function __construct() {
                //do stuff here
        }
        
        /* new order seller email */
        public function deactive_account_email_to_admin($params = '') {
            global  $taskbot_settings;
            extract($params);
            $user_id       = !empty($user_id) ? $user_id : '';
            $user_type     = !empty($user_type) ? $user_type : '';
            $user_name     = !empty($user_name) ? $user_name : '';
            $user_email    = !empty($user_email) ? $user_email: '';

            $email_to 		        = !empty( $taskbot_settings['admin_email_deactive_account'] ) ? $taskbot_settings['admin_email_deactive_account'] : get_option('admin_email', 'info@example.com'); //admin email
            $subject_default 	    = esc_html__('Account deactivated', 'taskbot'); //default email subject
            $contact_default 	    = wp_kses(__('{{user_name}}” deactivated his/her account for the reason of<br>{{reason}}<br>{{details}}', 'taskbot'), //default email content
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

            $subject		    = !empty( $taskbot_settings['deactive_acc_admin_email_subject'] ) ? $taskbot_settings['deactive_acc_admin_email_subject'] : $subject_default; //getting subject
            $content		    = !empty( $taskbot_settings['deactive_acc_admin_mail_content'] ) ? $taskbot_settings['deactive_acc_admin_mail_content'] : $contact_default; //getting conetnt
            $email_content      = $content; //getting content

            $email_content = str_replace("{{user_id}}", $user_id, $email_content);
            $email_content = str_replace("{{user_type}}", $user_type , $email_content);
            $email_content = str_replace("{{reason}}", $reason , $email_content);
            $email_content = str_replace("{{details}}", $details , $email_content);
            $email_content = str_replace("{{user_name}}", $user_name, $email_content);
            $email_content = str_replace("{{user_email}}", $user_email, $email_content);

            /* data for greeting */
            $greeting['greet_keyword']      = '';
            $greeting['greet_value']        = '';
            $greeting['greet_option_key']   = '';

            $body = $this->taskbot_email_body($email_content, $greeting);

            $body  = apply_filters('taskbot_deactive_account_email_content', $body);

            wp_mail($email_to, $subject, $body); //send Email

        }
    }

	new DeactiveUserAcoount();
}
