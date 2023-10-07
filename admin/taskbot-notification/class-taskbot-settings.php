<?php

/**
 *
 * Class 'Taskbot_Notifications' defines to remove the product data default tabs
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

class Taskbot_NotificationsSettings
{

    /**
     * Add action hooks
     *
     * @since    1.0.0
     * @access   public
     */
    public function __construct()
    {
        add_filter('taskbot_list_notification', array(&$this, 'taskbot_list_notification'), 10, 2);
    }

    /**
     * Filter to get notification options
     *
     * @since    1.0.0
     */
    public function taskbot_list_notification($type = '', $value = '')
    {
        $list   = array(
            // notification for registration
            'registration'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Registration', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for registration', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('Thank you for joining, an email has been sent to your email for verification', 'taskbot'),
                    'tags'              => __('{{name}}     — To display the name.<br>
                                            {{email}}       — To display the email address.<br>
                                            {{sitename}}    — To display the site name.<br>
                                            '),
                ),

            ),
            // notification for send request
            'approval_request'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Approval user request', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for approval user', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('Thank you for joining, your account will be approved once reviewed by the admin', 'taskbot'),
                    'tags'              => __('
                                            {{name}}  — To display the name.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),
            // notification for approved request from admin
            'approved_account_request'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Account approved', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for account approve user', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('Congratulations! Your account has been approved.', 'taskbot'),
                    'tags'              => __('
                                            {{name}}  — To display the name.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),
            // notification for approved request
            'reject_account_request'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Rejected user account', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for rejected user', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('Unfortunately, your account has not been approved, Please try again.', 'taskbot'),
                    'tags'              => __('
                                            {{name}}  — To display the name.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),

            // notification for send verification request
            'account_verification_request'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Verification request', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for verification request', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('Thank you upload identity information, your account will be verified once reviewed by the admin', 'taskbot'),
                    'tags'              => __('
                                            {{name}}  — To display the name.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),

            // notification for approve verification request
            'approve_verification_request'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Approve verification request', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for verification request', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('Congratulations! Your account Verification  has been approved.', 'taskbot'),
                    'tags'              => __('
                                            {{name}}  — To display the name.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),
            // notification for reject verification request
            'reject_verification_request'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Verification request', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for verification request', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('Unfortunately, your account has not been rejected, Please try again.', 'taskbot'),
                    'tags'              => __('
                                            {{name}}  — To display the name.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),
            // notification for reset password
            'reset_password'   => array(
                'type'      => 'registration',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('name', 'email', 'sitename')
                ),
                'options'   => array(
                    'title'             => esc_html__('Reset password', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for reset password', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => esc_html__('You have successfully restored your password', 'taskbot'),
                    'tags'              => __('
                                            {{name}}  — To display the name.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),

            // notification for submint task
            'submint_task'  => array(
                'type'      => 'task',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('email', 'sitename', 'task_name', 'seller_name', 'task_link'),
                ),
                'options'   => array(
                    'title'             => esc_html__('Task submission', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for task submission', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => false,
                    'content'           => __('Thank you for submitting the task <strong>“{{task_name}}”</strong>, we will review and approve the task soon.', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{task_name}}       — To display the task title.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),

            // notification for approve task
            'task_approved'  => array(
                'type'      => 'task',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('email', 'sitename', 'task_name', 'seller_name', 'task_link'),
                    'btn_settings'  => array('link_type' => 'single_post', 'text' => esc_html__('View task', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Task approved', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for task approve', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => false,
                    'content'           => __('<strong>“{{task_name}}”</strong>has been approved successfully.', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{task_name}}       — To display the task title.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),

            // notification for rejected task
            'task_rejected'  => array(
                'type'      => 'task',
                'settings'  => array(
                    'image_type'        => 'seller_image',
                    'admin_comments'    => 'yes',
                    'tage'              => array('sitename', 'task_name', 'seller_name', 'task_link', 'admin_feedback'),
                ),
                'options'   => array(
                    'title'             => esc_html__('Task rejected', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for task rejected', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => false,
                    'content'           => __('Unfortunately the task <strong>“{{task_name}}”</strong>has been rejected. Please make the required changes and resubmit.<br>
                    {{admin_feedback}}', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{task_name}}       — To display the task title.<br>
                                            {{admin_feedback}}    — To display the admin feedback.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),
            // notification to seller for new order
            'seller_new_order'  => array(
                'type'      => 'order',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('sitename', 'task_name', 'seller_name', 'task_link', 'buyer_name', 'order_id', 'seller_order_amount', 'seller_order_link'),
                    'btn_settings'  => array('link_type' => 'view_seller_order', 'text' => esc_html__('View order', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('New order for seller', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller for new order', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/sisable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('You have received a new order request form <strong>“{{buyer_name}}”</strong> for the task <strong>“{{task_name}}”</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{order_id}}        — To display the order id.<br>
                                            {{seller_order_amount}}     — To display the seller amount.<br>
                                            {{seller_order_link}}       — To display the seller order url.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),

            // notification to buyer for new order
            'buyer_new_order'  => array(
                'type'      => 'order',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('sitename', 'task_name', 'seller_name', 'task_link', 'buyer_name', 'email', 'order_id', 'buyer_order_amount', 'buyer_order_link'),
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer on new order', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to buyer for new order', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Thank you for ordering <strong>{{task_name}}</strong>. I will get in touch with you shortly', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{order_id}}        — To display the order id.<br>
                                            {{buyer_order_amount}}     — To display the buyer amount.<br>
                                            {{buyer_order_link}}       — To display the buyer order url.<br>
                                            {{email}}    — To display the email address.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),
            // notification to buyer for order complete request
            'buyer_order_request'  => array(
                'type'      => 'order',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('buyer_name', 'seller_name', 'task_name', 'task_link', 'order_id', 'buyer_order_link', 'sitename', 'buyer_order_amount'),
                    'btn_settings'  => array('link_type' => 'buyer_order_link', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification buyer final delivery', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification final delivery', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('<strong>“{{seller_name}}”</strong> has sent you the final delivery for the task <strong>{{task_name}}</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{order_id}}        — To display the order id.<br>
                                            {{buyer_order_amount}}     — To display the buyer amount.<br>
                                            {{buyer_order_link}}       — To display the buyer order url.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),

            ),
            // notification for buyer or seller
            'user_activity'  => array(
                'type'      => 'order',
                'settings'  => array(
                    'image_type'    => 'sender_image',
                    'tage'          => array('sender_name', 'receiver_name', 'task_name', 'task_link', 'order_id', 'sender_comments', 'order_link', 'sitename'),
                    'btn_settings'  => array('link_type' => 'order_link', 'text' => esc_html__('View order details', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification user task activity', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification task activity', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => false,
                    'content'           => __('You have received a note from <strong>“{{sender_name}}”</strong> on the task <strong>“{{task_name}}”</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{sender_name}}     — To display the sender name.<br>
                                            {{receiver_name}}   — To display the receiver name.<br>
                                            {{order_id}}        — To display the order id.<br>
                                            {{sender_comments}}     — To display the sender comment.<br>
                                            {{order_link}}       — To display the order url.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),
            // notification to byer for cancel order
            'order_rejected'  => array(
                'type'      => 'order',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('buyer_name', 'seller_name', 'task_name', 'task_link', 'order_id', 'seller_order_link', 'sitename', 'buyer_comments'),
                    'btn_settings'  => array('link_type' => 'view_seller_order', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller for reject order', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller for reject order', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('<strong>“{{buyer_name}}”</strong> has cancelled the order of <strong>{{task_name}}</strong> and has left some comments for you.', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{order_id}}        — To display the order id.<br>
                                            {{seller_order_link}}    — To display the seller order url.<br>
                                            {{buyer_comments}}       — To display the buyer comments.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),
            // notification to byer for complete order
            'order_completed'  => array(
                'type'      => 'order',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('buyer_name', 'seller_name', 'task_name', 'task_link', 'order_id', 'buyer_rating', 'seller_order_link', 'sitename', 'buyer_comments'),
                    'btn_settings'  => array('link_type' => 'view_seller_order', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller complete order', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller to complete order', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Congratulations! <strong>“{{buyer_name}}”</strong> has closed the <strong>{{task_name}}</strong> and has left some comments for you.', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{order_id}}        — To display the order id.<br>
                                            {{seller_order_link}}   — To display the seller order url.<br>
                                            {{buyer_comments}}      — To display the buyer comments.<br>
                                            {{buyer_rating}}        — To display the ratings.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),
            // notification to seller for dispute
            'refund_request'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('buyer_name', 'seller_name', 'task_name', 'task_link', 'order_id', 'seller_order_amount', 'seller_order_link', 'sitename', 'buyer_comments', 'view_seller_refund_request'),
                    'btn_settings'  => array('link_type' => 'view_seller_refund_request', 'text' => esc_html__('View refund request', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller for dispute', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller for dispute', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('<strong>{{buyer_name}}</strong> submitted a refund request against <strong>{{task_name}}</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{task_name}}       — To display the task title.<br>
                                            {{task_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{order_id}}        — To display the order id.<br>
                                            {{seller_order_link}}   — To display the seller order url.<br>
                                            {{buyer_comments}}      — To display the buyer comments.<br>
                                            {{seller_order_amount}} — To display the seller amount.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),
            // notification to buyer for complete order
            'refund_comments'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'sender_image',
                    'tage'          => array('sender_name', 'receiver_name', 'task_name', 'task_link', 'order_id', 'dispute_comment', 'view_comments'),
                    'btn_settings'  => array('link_type' => 'view_comments', 'text' => esc_html__('View comment', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to user to recive dispute comment', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to send user', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('<strong>“{{sender_name}}”</strong> has left some comments on the refund request against <strong>{{task_name}}</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{sender_name}}         — To display the sender name.<br>
                                            {{receiver_name}}       — To display the reciver name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{dispute_comment}}     — To display the sender comments.<br>
                                            {{view_comments}}       — To display the dispute url.<br>
                                            '),
                ),
            ),
            // notification to buyer for complete order
            'admin_refund_comments'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'defult',
                    'tage'          => array('receiver_name', 'task_name', 'task_link', 'order_id', 'dispute_comment', 'view_comments'),
                    'btn_settings'  => array('link_type' => 'view_comments', 'text' => esc_html__('View comment', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to user after admin comment', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to user froma admin', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Hello <strong>“{{receiver_name}}”</strong> Admin has left some comments on the dispute', 'taskbot'),
                    'tags'              => __('
                                            {{receiver_name}}       — To display the reciver name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{dispute_comment}}     — To display the sender comments.<br>
                                            {{view_comments}}       — To display the dispute url.<br>
                                            '),
                ),
            ),
            // notification to buyer for dispute decline
            'refund_decline'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('seller_name', 'buyer_name', 'task_name', 'task_link', 'order_id', 'dispute_comment', 'view_comments'),
                    'btn_settings'  => array('link_type' => 'buyer_order_link', 'text' => esc_html__('Create dispute', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to user to decline refund request', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification decline refund request', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Your refund request has been declined by <strong>{{seller_name}}</strong> against <strong>{{task_name}}</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{seller_name}}         — To display the seller name.<br>
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{dispute_comment}}     — To display the seller comments.<br>
                                            {{view_comments}}       — To display the dispute url.<br>
                                            '),
                ),
            ),
            // notification to buyer for dispute approved
            'refund_approved'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('seller_name', 'buyer_name', 'task_name', 'task_link', 'order_id', 'dispute_comment', 'view_comments')
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to user after approved refund request', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to send user after approved refund request', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Congratulations! Your refund request has been approved by <strong>{{seller_name}}</strong> against <strong>{{task_name}}</strong><br>{{dispute_comment}}', 'taskbot'),
                    'tags'              => __('
                                            {{seller_name}}         — To display the seller name.<br>
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{dispute_comment}}     — To display the seller comments.<br>
                                            {{view_comments}}       — To display the dispute url.<br>
                                            '),
                ),
            ),
            // notification to seller form admin refunded
            'seller_refunded'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'tage'          => array('seller_name', 'buyer_name', 'task_name', 'task_link', 'order_id', 'order_amount')
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller for dispute resolved ', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for dispute resolved', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Congratulations! The dispute has been resolved against <strong>{{task_name}}</strong> in your favor. We have marked the task as completed and credited the amount into your wallet', 'taskbot'),
                    'tags'              => __('
                                            {{seller_name}}         — To display the seller name.<br>
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{order_amount}}        — To display the order amount.<br>
                                            '),
                ),
            ),
            // notification to seller form admin decline dispute
            'seller_cancelled_refunded'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'tage'          => array('seller_name', 'buyer_name', 'task_name', 'task_link', 'order_id', 'order_amount')
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller for dispute in favor of buyer', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for dispute in favor of buyer', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('The dispute for the task <strong>{{task_name}}</strong> has been resolved against your favor.', 'taskbot'),
                    'tags'              => __('
                                            {{seller_name}}         — To display the seller name.<br>
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{order_amount}}        — To display the order amount.<br>
                                            '),
                ),
            ),
            // notification to buyer form admin refunded
            'buyer_refunded'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'tage'          => array('seller_name', 'buyer_name', 'task_name', 'task_link', 'order_id', 'order_amount')
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer for dispute resolved', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to buyer for dispute resolved', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Congratulations! The dispute has been resolved against <strong>{{task_name}}</strong> in your favor. We have marked the task as completed and credited the amount into your wallet. You can now start with new seller', 'taskbot'),
                    'tags'              => __('
                                            {{seller_name}}         — To display the seller name.<br>
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{order_amount}}        — To display the order amount.<br>
                                            '),
                ),
            ),
            // notification to buyer form admin decline dispute
            'buyer_cancelled_refunded'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'tage'          => array('seller_name', 'buyer_name', 'task_name', 'task_link', 'order_id', 'order_amount')
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer for dispute in favor of buyer ', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for dispute in favor of buyer', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('The dispute for the task <strong>{{task_name}}</strong> has been resolved against your favor.', 'taskbot'),
                    'tags'              => __('
                                            {{seller_name}}         — To display the seller name.<br>
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{task_name}}           — To display the task title.<br>
                                            {{task_link}}           — To display the task link.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{order_amount}}        — To display the order amount.<br>
                                            '),
                ),
            ),

            // notification to seller for project dispute
            'project_refund_request'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('buyer_name', 'seller_name', 'project_title', 'project_link', 'dispute_order_amount', 'sitename', 'buyer_comments', 'view_seller_project_refund_request'),
                    'btn_settings'  => array('link_type' => 'view_seller_project_refund_request', 'text' => esc_html__('View refund request', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller for project dispute', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller for project dispute', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Project refund request received from <strong>{{buyer_name}}</strong> of <strong>{{project_title}}</strong> project', 'taskbot'),
                    'tags'              => __('
                                            {{project_title}}       — To display the task title.<br>
                                            {{project_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{dispute_order_amount}}   — To display the dispute amount.<br>
                                            {{buyer_comments}}      — To display the buyer comments.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),
            // notification to reciver on project dispute comments
            'project_refund_comments'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'sender_image',
                    'tage'          => array('sender_name', 'receiver_name', 'project_title', 'project_link', 'dispute_comment'),
                    'btn_settings'  => array('link_type' => 'view_project_dispute_comments', 'text' => esc_html__('View comment', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to user to recive project dispute comment', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to user to recive project dispute comment', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('You have received a new dispute comment from {{sender_name}}', 'taskbot'),
                    'tags'              => __('
                                            {{sender_name}}         — To display the sender name.<br>
                                            {{receiver_name}}       — To display the reciver name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{dispute_comment}}     — To display the sender comments.<br>
                                            '),
                ),
            ),
            // notification to buyer for project refund request decline form seller
            'project_refund_decline'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('buyer_name', 'seller_name', 'project_title', 'project_link', 'sitename', 'buyer_comments'),
                    'btn_settings'  => array('link_type' => 'view_project_dispute_comments', 'text' => esc_html__('View refund request', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer for project refund request decline', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to buyer for project refund request decline', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Oho! A dispute has been declined by <strong>{{seller_name}}</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{project_title}}       — To display the task title.<br>
                                            {{project_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),

            // notification to buyer for project refund request decline form seller
            'project_refund_approved'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('buyer_name', 'seller_name', 'project_title', 'project_link', 'sitename', 'buyer_comments'),
                    'btn_settings'  => array('link_type' => 'view_project_dispute_comments', 'text' => esc_html__('View refund request', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer for project refund request approved from seller', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to buyer for project refund request approved from seller', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Woohoo! <strong>{{seller_name}}</strong> approved the dispute refund request in your favor', 'taskbot'),
                    'tags'              => __('
                                            {{project_title}}       — To display the task title.<br>
                                            {{project_link}}       — To display the task link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),

            // notification to user for admin comment on project dispute
            'project_admin_dispute_comment'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'tage'          => array('buyer_name', 'seller_name', 'project_title', 'project_link', 'sitename', 'dispute_comment', 'admin_name'),
                    'btn_settings'  => array('link_type' => 'view_project_dispute_comments', 'text' => esc_html__('View comment', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to user for project dispute comment', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to user for project dispute comment', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('You have received a new dispute comment from {{admin_name}}', 'taskbot'),
                    'tags'              => __('
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}       — To display the project link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{admin_name}}      — To display the admin name.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),

            // notification to wining user for admin comment on project dispute
            'admin_resolved_project_dispute_winning'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'tage'          => array('buyer_name', 'seller_name', 'project_title', 'project_link', 'sitename', 'dispute_comment', 'admin_name'),
                    'btn_settings'  => array('link_type' => 'view_project_dispute_comments', 'text' => esc_html__('View comment', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to winnig party user for project dispute resolved', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to winnig party user for project dispute resolved', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Woohoo! <strong>{{admin_name}}</strong> approved the dispute refund request in your favor.', 'taskbot'),
                    'tags'              => __('
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}       — To display the project link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{admin_name}}      — To display the admin name.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),
            // notification to losser user for admin comment on project dispute
            'admin_resolved_project_dispute_loser'  => array(
                'type'      => 'dispute',
                'settings'  => array(
                    'tage'          => array('buyer_name', 'seller_name', 'project_title', 'project_link', 'sitename', 'dispute_comment', 'admin_name'),
                    'btn_settings'  => array('link_type' => 'view_project_dispute_comments', 'text' => esc_html__('View comment', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to loseing party user for project dispute resolved', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to loseing party user for project dispute resolved', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('Oho! <strong>{{admin_name}}</strong> did not approve the dispute refund request in your favor.', 'taskbot'),
                    'tags'              => __('
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}       — To display the project link.<br>
                                            {{seller_name}}     — To display the seller name.<br>
                                            {{buyer_name}}      — To display the buyer name.<br>
                                            {{admin_name}}      — To display the admin name.<br>
                                            {{sitename}} — To display the site name.<br>
                                            '),
                ),
            ),



            // notification to seller form admin refunded
            'package_purchases'  => array(
                'type'      => 'packages',
                'settings'  => array(
                    'tage'          => array('seller_name', 'order_id', 'order_amount', 'package_name', 'post_a_task'),
                    'btn_settings'  => array('link_type' => 'single_post', 'text' => esc_html__('Post a task', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller for package purchases ', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for package purchases', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Congratulations! You have successfully purchased the “{{package_name}}” package. You can now post a service and get orders', 'taskbot'),
                    'tags'              => __('
                                            {{seller_name}}         — To display the seller name.<br>
                                            {{package_name}}        — To display the package title.<br>
                                            {{post_a_task}}         — To display the post a task url.<br>
                                            {{order_id}}            — To display the order id.<br>
                                            {{order_amount}}        — To display the order amount.<br>
                                            '),
                ),
            ),
            // notification to buyer on approved project
            'approve_project'  => array(
                'type'      => 'projects',
                'settings'  => array(
                    'tage'          => array('buyer_name', 'project_title', 'project_link', 'project_id')
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer for approved project ', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for approved project', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Woohoo! Your project {{project_title}} has been approved.', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{project_title}}           — To display the project title.<br>
                                            {{project_link}}           — To display the project link.<br>
                                            {{project_id}}            — To display the project id.<br>
                                            '),
                ),
            ),

            // Notification to buyer on project reject
            'rejected_project'  => array(
                'type'      => 'projects',
                'settings'  => array(
                    'admin_comments'    => 'yes',
                    'tage'              => array('buyer_name', 'project_title', 'project_link', 'project_id', 'admin_feedback')
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer for rejected project ', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification for rejected project', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Oho! Your project {{project_title}} has been rejected.<br>{{admin_feedback}}', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{admin_feedback}}      — To display the admin feedback.<br>
                                            '),
                ),
            ),
            // notification to seller on project invitation
            'project_inviation'  => array(
                'type'      => 'projects',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id'),
                    'btn_settings'  => array('link_type' => 'project_link', 'text' => esc_html__('View project', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller on invitation ', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification seller on invitation', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('You have received a project invitation from {{buyer_name}}', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            '),
                ),
            ),
            // notification to buyer on reciving proposal
            'recived_proposal'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'buyer_proposal_link'),
                    'btn_settings'  => array('link_type' => 'buyer_proposal_link', 'text' => esc_html__('View proposal', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer on proposal submitation ', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification buyer on proposal submitation', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('{{seller_name}} submit a new proposal on project {{project_title}}', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            {{buyer_proposal_link}} — To display the buyer proposal detail page.<br>
                                            '),
                ),
            ),
            // notification to seller of rejected proposal
            'rejected_proposal'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'seller_proposals_link'),
                    'btn_settings'  => array('link_type' => 'seller_proposals_link', 'text' => esc_html__('View proposals', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller on the rejection of the proposal', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller on the rejection of the proposal', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Oho! your proposal on {{project_title}} has been rejected by {{buyer_name}}', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            {{seller_proposals_link}} — To display the seller proposals page.<br>
                                            '),
                ),
            ),
            // notification to seller on hire proposal
            'hired_proposal'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'seller_proposal_activity'),
                    'btn_settings'  => array('link_type' => 'seller_proposal_activity', 'text' => esc_html__('View proposals', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller on hired project', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller on hired project', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Woohoo! {{buyer_name}} hired you for {{project_title}} project', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            {{seller_proposal_activity}} — To display the seller proposal activity page.<br>
                                            '),
                ),
            ),
            'hired_proposal_milestone'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'seller_proposal_activity', 'milestone_title'),
                    'btn_settings'  => array('link_type' => 'seller_proposal_activity', 'text' => esc_html__('View proposals', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller on hired project milestone', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller on hired project milestone', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Your milestone {{milestone_title}} of {{project_title}} has been approved', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            {{milestone_title}}      — To display the milestone title.<br>
                                            '),
                ),
            ),
            'project_activity_comments'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'sender_image',
                    'tage'          => array('sender_name', 'receiver_name', 'project_title', 'project_link', 'activity_comment'),
                    'btn_settings'  => array('link_type' => 'project_activity_link', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to user to recive project activity comment', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to user to recive project activity comment', 'taskbot'),
                    'flash_message_title' => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'     => true,
                    'content'           => __('A new activity performed by <strong>{{sender_name}}</strong> on a <strong>{{project_title}}</strong> project', 'taskbot'),
                    'tags'              => __('
                                            {{sender_name}}         — To display the sender name.<br>
                                            {{receiver_name}}       — To display the reciver name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{activity_comment}}     — To display the sender comments.<br>
                                            '),
                ),
            ),
            'milestone_creation'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'buyer_proposal_activity'),
                    'btn_settings'  => array('link_type' => 'buyer_proposal_activity', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer on milestone creation', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to buyer on milestone creation', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('<strong>{{seller_name}}</strong> add new milestone for the project <strong>{{project_title}}</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            '),
                ),
            ),
            'milestone_request'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'seller_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'buyer_proposal_activity', 'milestone_title'),
                    'btn_settings'  => array('link_type' => 'buyer_proposal_activity', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to buyer on milestone completed request', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to buyer on milestone completed request', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('A new milestone <strong>{{milestone_title}}</strong> of <strong>{{project_title}}</strong> approval received from <strong>{{seller_name}}</strong>', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            {{milestone_title}}      — To display the milestone title.<br>
                                            '),
                ),
            ),
            'milestone_completed'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'seller_proposal_activity', 'milestone_title'),
                    'btn_settings'  => array('link_type' => 'seller_proposal_activity', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller after milestone completed', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller after milestone completed', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Your milestone {{milestone_title}} of {{project_title}} marked as completed by {{buyer_name}}', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            {{milestone_title}}      — To display the milestone title.<br>
                                            '),
                ),
            ),
            'milestone_decline'  => array(
                'type'      => 'proposals',
                'settings'  => array(
                    'image_type'    => 'buyer_image',
                    'tage'          => array('seller_name', 'buyer_name', 'project_title', 'project_link', 'project_id', 'proposal_id', 'seller_proposal_activity', 'milestone_title'),
                    'btn_settings'  => array('link_type' => 'seller_proposal_activity', 'text' => esc_html__('View activity', 'taskbot'))
                ),
                'options'   => array(
                    'title'             => esc_html__('Notification to seller after milestone decline', 'taskbot'),
                    'tag_title'         => esc_html__('Notification setting variables', 'taskbot'),
                    'content_title'     => esc_html__('Notification content', 'taskbot'),
                    'enable_title'      => esc_html__('Enable/disable notification to seller after milestone decline', 'taskbot'),
                    'flash_message_title'   => esc_html__('Enable/disable flash message', 'taskbot'),
                    'flash_message_option'  => true,
                    'content'           => __('Your milestone {{milestone_title}} of {{project_title}} has been declined by {{buyer_name}}', 'taskbot'),
                    'tags'              => __('
                                            {{buyer_name}}          — To display the buyer name.<br>
                                            {{seller_name}}         — To display the buyer name.<br>
                                            {{project_title}}       — To display the project title.<br>
                                            {{project_link}}        — To display the project link.<br>
                                            {{project_id}}          — To display the project id.<br>
                                            {{proposal_id}}          — To display the proposal id.<br>
                                            {{milestone_title}}      — To display the milestone title.<br>
                                            '),
                ),
            ),
        );
        $list   = apply_filters('taskbot_filter_list_notification', $list);
        if (!empty($type) && $type == 'type') {
            $new_list   = array();
            foreach ($list as $key => $val) {
                if (!empty($val['type']) && $val['type'] === $value) {
                    $new_list[$key] = !empty($val['options']) ? $val['options'] : array();
                }
            }
            $list   = $new_list;
        } else if (!empty($type) && $type == 'settings') {
            $list   = !empty($list[$value]['settings']) ? $list[$value]['settings'] : array();
        }

        return $list;
    }
}
new Taskbot_NotificationsSettings();
