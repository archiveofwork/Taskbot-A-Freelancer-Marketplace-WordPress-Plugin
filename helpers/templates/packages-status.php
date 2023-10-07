<?php
/**
 *
 * Class 'TaskbotPackagesStatuses' defines seller package status
 *
 * @package     Taskbot
 * @subpackage  Taskbot/helpers/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

if (!class_exists('TaskbotPackagesStatuses')) {
  class TaskbotPackagesStatuses extends Taskbot_Email_helper
  {
    public function __construct()
    {
      //do something
    }

    /* Package Purchase */
    public function package_purchase_seller_email($params = '')
    {
      global $taskbot_settings;
      extract($params);

      $email_to       = !empty($seller_email) ? $seller_email : '';
      $seller_name_   = !empty($seller_name) ? $seller_name : '';
      $order_id_      = !empty($order_id) ? $order_id : '';
      $order_amount_  = !empty($order_amount) ? $order_amount : '';
      $package_name_  = !empty($package_name) ? $package_name : '';

      $subject_default 	        = esc_html__('Thank you for purchasing the package.', 'taskbot'); //default email subject
      $contact_default 	        = wp_kses(__('Thank you for purchasing the package “{{package_name}}” <br/> You can now post a task and get orders.', 'taskbot'), //default email content
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

      $subject		    = !empty( $taskbot_settings['packages_seller_email_subject'] ) ? $taskbot_settings['packages_seller_email_subject'] : $subject_default; //getting subject
      $email_content  = !empty( $taskbot_settings['package_seller_purchase_mail_content'] ) ? $taskbot_settings['package_seller_purchase_mail_content'] : $contact_default; //getting content

      $email_content = str_replace("{{seller_name}}", $seller_name_, $email_content);
      $email_content = str_replace("{{order_id}}", $order_id_, $email_content);
      $email_content = str_replace("{{order_amount}}", $order_amount_, $email_content);
      $email_content = str_replace("{{package_name}}", $package_name_, $email_content);

      /* data for greeting */
      $greeting['greet_keyword']      = 'seller_name';
      $greeting['greet_value']        = $seller_name_;
      $greeting['greet_option_key']   = 'packages_seller_email_greeting';

      $body = $this->taskbot_email_body($email_content, $greeting);
      $body  = apply_filters('taskbot_seller_package_email_content', $body);

      wp_mail($email_to, $subject, $body); //send Email
    }

  }

  new TaskbotPackagesStatuses();
}
