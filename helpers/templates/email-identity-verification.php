<?php
/**
 * Email Helper To Send Email
 * @since    1.0.0
 */
if (!class_exists('TaskbotIdentityVerification')) {

    class TaskbotIdentityVerification extends Taskbot_Email_helper{

        public function __construct() {
			//do stuff here
        }

		/**
		 * @Send identity verification to admin
		 *
		 * @since 1.0.0
		 */
		public function send_verification_to_admin($params = '') {
			global  $taskbot_settings;
			extract($params);
			
			$subject		    = !empty( $taskbot_settings['admin_verified_subject'] ) ? $taskbot_settings['admin_verified_subject'] : ''; 
			$email_content		= !empty( $taskbot_settings['admin_verified_content'] ) ? $taskbot_settings['admin_verified_content'] : ''; 
			$email_to       	= !empty( $taskbot_settings['admin_email_verify_identity'] ) ? $taskbot_settings['admin_email_verify_identity'] : get_option('admin_email', 'info@example.com');
			
			$email_content = str_replace("{{user_name}}", $user_name, $email_content);
			$email_content = str_replace("{{user_link}}", $user_link , $email_content);
			$email_content = str_replace("{{user_email}}", $user_email , $email_content);
			/* data for greeting */
			$greeting						= array();
			$greeting['greet_keyword']      = '';
            $greeting['greet_value']        = '';
            $greeting['greet_option_key']   = '';

			$body = $this->taskbot_email_body($email_content, $greeting);

			$body  = apply_filters('taskbot_send_verification_to_admin_email_content', $body);

			wp_mail($email_to, $subject, $body); //send Email
		}
		
		/**
		 * @Verification email to Freelancer
		 *
		 * @since 1.0.0
		 */
		public function approve_identity_verification($params = '') {
			global  $taskbot_settings;
			extract($params);
			$subject		    = !empty( $taskbot_settings['approved_verify_subject'] ) ? $taskbot_settings['approved_verify_subject'] : ''; 
			$email_content		= !empty( $taskbot_settings['approved_verify_content'] ) ? $taskbot_settings['approved_verify_content'] : ''; 
			$email_to       	= !empty( $user_email ) ? $user_email : '';
			
			$email_content = str_replace("{{user_name}}", $user_name, $email_content);
			$email_content = str_replace("{{user_link}}", $user_link , $email_content);
			$email_content = str_replace("{{user_email}}", $user_email , $email_content);
			/* data for greeting */
			$greeting						= array();
			$greeting['greet_keyword']      = 'user_name';
			$greeting['greet_value']        = $user_name;
			$greeting['greet_option_key']   = 'approved_verify_email_greeting';

			$body = $this->taskbot_email_body($email_content, $greeting);

			$body  = apply_filters('taskbot_approve_identity_verification_email_content', $body);

			wp_mail($email_to, $subject, $body);
		}
		
		/**
		 * @Rejection email to Freelancer
		 *
		 * @since 1.0.0
		 */
		public function reject_identity_verification($params = '') {
			global  $taskbot_settings;
			extract($params);
			
			$subject		    = !empty( $taskbot_settings['rejected_verify_subject'] ) ? $taskbot_settings['rejected_verify_subject'] : ''; 
			$email_content		= !empty( $taskbot_settings['rejected_verify_content'] ) ? $taskbot_settings['rejected_verify_content'] : ''; 
			$email_to       	= !empty( $user_email ) ? $user_email : '';
			
			$email_content = str_replace("{{user_name}}", $user_name, $email_content);
			$email_content = str_replace("{{user_link}}", $user_link , $email_content);
			$email_content = str_replace("{{user_email}}", $user_email , $email_content);
			$email_content = str_replace("{{admin_message}}", $admin_message , $email_content);
			/* data for greeting */
			$greeting						= array();
			$greeting['greet_keyword']      = 'user_name';
			$greeting['greet_value']        = $user_name;
			$greeting['greet_option_key']   = 'rejected_verify_email_greeting';
			$body = $this->taskbot_email_body($email_content, $greeting);

			$body  = apply_filters('taskbot_reject_identity_verification_email_content', $body);

			wp_mail($email_to, $subject, $body); //send Email
		}

	}

	new TaskbotIdentityVerification();
}