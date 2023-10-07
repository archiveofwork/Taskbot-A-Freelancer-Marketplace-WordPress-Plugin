<?php
/**
 * Email Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
/* Buyer Emails */
$buyer_email_fields	= array();
if( function_exists('taskbot_buyer_email') ){
	$buyer_email_fields	= taskbot_buyer_email();
}

/* Seller Emails */
$seller_email_fields	= array();
if( function_exists('taskbot_seller_email') ){
	$seller_email_fields	= taskbot_seller_email();
}
// email general setting tab
Redux::setSection( $opt_name, array(
	'title'       => esc_html__( 'Email settings', 'taskbot' ),
	'id'          => 'email_settings',
	'desc'        => '',
	'icon'        => 'el el-inbox',
	'subsection'  => false,
	'fields'      => array(
		array(
			'id'      => 'divider_1',
			'type'    => 'info',
			'title'   => esc_html__( 'General Settings', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'      => 'email_logo',
			'type'    => 'media',
			'compiler'=> 'true',
			'url'     => true,
			'title'   => esc_html__( 'Email logo', 'taskbot' ),
			'desc'    => esc_html__( 'Upload your email logo here.', 'taskbot' ),
		),
		array(
			'id'      => 'email_sender_name',
			'type'    => 'text',
			'title'   => esc_html__( 'Email sender name', 'taskbot' ),
			'desc'    => esc_html__( 'Add email sender name here like: Shawn Biyeam. Default your site name will be used.', 'taskbot' ),
			'default' => esc_html__( '', 'taskbot' ),
		),
		array(
			'id'      => 'email_sender_email',
			'type'    => 'text',
			'title'   => esc_html__( 'Email sender email', 'taskbot' ),
			'desc'    => esc_html__( 'Add email sender email here like: noreply@example.com. Default your site email will be used.', 'taskbot' ),
			'default' => esc_html__( 'noreply@example.com', 'taskbot' ),
		),
		array(
			'id'      => 'email_copyrights',
			'type'    => 'textarea',
			'title'   => esc_html__( 'Footer copyright text', 'taskbot' ),
			'desc'    => esc_html__( 'Add copyright text for the emails in footer', 'taskbot' ),
		),
		array(
			'id'      => 'email_signature',
			'type'    => 'textarea',
			'title'   => esc_html__( 'Email sender signature ', 'taskbot' ),
			'desc'    => esc_html__( 'Add email sender signature here like: team taskbot.', 'taskbot' ),
			'default' => esc_html__( 'Regards,', 'taskbot' ),
		),
		array(
			'id'      => 'email_footer_color',
			'type'    => 'color',
			'title'   => esc_html__( 'Email footer color ', 'taskbot' ),
			'desc'    => esc_html__( 'Add email footer background color here', 'taskbot' ),
			'default' => '#353648',
		),
		array(
			'id'      => 'email_footer_color_text',
			'type'    => 'color',
			'title'   => esc_html__( 'Email footer color ', 'taskbot' ),
			'desc'    => esc_html__( 'Add email footer text color here', 'taskbot' ),
			'default' => '#FFFFFF',
		),
	)
) );

 /* Email template for administrator */

Redux::setSection( $opt_name, array(
	'title'			=> esc_html__( 'Administrator', 'taskbot' ),
	'id'			=> 'administrator_email_templates',
	'desc'			=> 'Administrator email templates',
	'icon'			=> '',
	'subsection'	=> true,
	'fields'		=> array(

    /* Admin Email on Disputes */
		array(
			'id'      => 'divider_disputes_admin_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Dispute', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_admin_new_dispute',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to admin on new dispute created!', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'disputes_admin_email',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
			'default' 	=> get_option('admin_email', 'info@example.com'),
			'required' 	=> array('email_admin_new_dispute','equals','1')
		),
		array(
			'id'      	=> 'disputes_admin_email_subject',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'A new dispute received','taskbot' ),
      		'required' 	=> array('email_admin_new_dispute','equals','1')
		),
		array(
			'id'      => 'divider_admin_disputes_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
						{{buyer_name}} — To display the buyer name.<br>
						{{task_name}} — To display the task name.<br>
						{{task_link}} — To display the task link.<br>
						{{order_id}} — To display the order id.<br>
						{{order_amount}} — To display the order amount.<br>
						{{login_url}} — To display the login url.<br>'
						, 'taskbot'
						),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
      		'required' 	=> array('email_admin_new_dispute','equals','1')
		),
		array(
			'id'        => 'disputes_admin_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'A new dispute has been created against the order #{{order_id}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
      		'required' 	=> array('email_admin_new_dispute','equals','1')
		),

		 /* Admin Email on user deactive active */
		 array(
			'id'      => 'divider_deactive_acc_admin_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Deactive account', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_admin_deactive_account',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email for deactive account', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to admin on deactive account!', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'admin_email_deactive_account',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
			'default' 	=> get_option('admin_email', 'info@example.com'),
			'required' 	=> array('email_admin_deactive_account','equals','1')
		),
		array(
			'id'      	=> 'deactive_acc_admin_email_subject',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Account deactivated','taskbot' ),
      		'required' 	=> array('email_admin_deactive_account','equals','1')
		),
		array(
			'id'      => 'deactive_acc_information',
			'desc'    => wp_kses(__( '{{user_name}} — To display the user name.<br>
						{{user_id}} — To display the user id.<br>
						{{user_type}} — To display the user type.<br>
						{{user_name}} — To display the user name.<br>
						{{user_email}} — To display the user email.<br>'
						, 'taskbot'
						),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
      		'required' 	=> array('email_admin_deactive_account','equals','1')
		),
		array(
			'id'        => 'deactive_acc_admin_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( '{{user_name}} deactivated his/her account for the reason of<br>
			{{reason}}<br>
			{{details}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
      		'required' 	=> array('email_admin_deactive_account','equals','1')
		),

		/* Admin Email for project Approval */
		array(
			'id'      => 'divider_project_approval_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Project approval', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_admin_project_approval',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to admin for project approval', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'admin_email_project_approval',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
			'default' 	=> get_option('admin_email', 'info@example.com'),
			'required' 	=> array('email_admin_project_approval','equals','1')
		),
		array(
			'id'      	=> 'project_approval_admin_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'A new project approval request','taskbot'),
      		'required'	=> array('email_admin_project_approval','equals','1')
		),
		array(
			'id'      => 'divider_project_aprroval_information',
			'desc'    => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
						{{project_title}} — To display the project name.<br>
						{{project_link}} — To display the project link.<br>'
						, 'taskbot'),
			array(
				'a'	=> array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
				)
			),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
    		'required' 	=> array('email_admin_project_approval','equals','1')
		),
		array(
			'id'        => 'project_approval_admin_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'A new project {{project_title}} approval request received from {{buyer_name}}<br>
			Please click on the button below to view the project.<br>
			{{project_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
    		'required'	=> array('email_admin_project_approval','equals','1')
		),

    /* Admin Email for Task Approval */
		array(
			'id'      => 'divider_task_approval_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Task approval', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_admin_task_approval',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to admin for task approval', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'admin_email_task_approval',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
			'default' 	=> get_option('admin_email', 'info@example.com'),
			'required' 	=> array('email_admin_task_approval','equals','1')
		),
		array(
			'id'      	=> 'task_approval_admin_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'A new task approval request','taskbot'),
      		'required'	=> array('email_admin_task_approval','equals','1')
		),
		array(
			'id'      => 'divider_task_aprroval_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
						{{task_name}} — To display the task name.<br>
						{{task_link}} — To display the task link.<br>'
						, 'taskbot'),
			array(
				'a'	=> array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
				)
			),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
    		'required' 	=> array('email_admin_task_approval','equals','1')
		),
		array(
			'id'        => 'task_approval_admin_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'A new task has been posted by the "{{seller_name}}", your approval is required to make it live.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
    		'required'  => array('email_admin_task_approval','equals','1')
		),

    /* admin email on withdraw request */
    array(
      'id'      => 'divider_withdraw_request_templates',
      'type'    => 'info',
      'title'   => esc_html__( 'Withdraw request', 'taskbot' ),
      'style'   => 'info',
    ),
	array(
		'id'      	=> 'withdraw_request_admin_email',
		'type'   	=> 'text',
		'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
		'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
		'default' 	=> get_option('admin_email', 'info@example.com'),
	),
    array(
      'id'      	=> 'withdraw_request_admin_subject',
      'type'    	=> 'text',
      'title'   	=> esc_html__( 'Subject', 'taskbot' ),
      'desc'    	=> esc_html__( 'Please add withdraw request email subject.', 'taskbot' ),
      'default' 	=> esc_html__( 'New withdrawal request has been received','taskbot'),
    ),
    array(
      'id'      => 'divider_withdraw_req_information',
      'desc'    => wp_kses( __( '{{user_name}} — To display the sender name.<br>
						{{user_link}} — To display the user link.<br>
						{{amount}} — To display the amount.<br>
						{{detail}} — To display the withdraw detail link.<br>'
        , 'taskbot'),
        array(
          'a'	=> array(
            'href'  => array(),
            'title' => array()
          ),
          'br'      => array(),
          'em'      => array(),
          'strong'  => array(),
        )
      ),
      'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
      'type'      => 'info',
      'class'     => 'dc-center-content',
      'icon'      => 'el el-info-circle',
    ),
    array(
      'id'        => 'withdraw_request_mail_content',
      'type'      => 'textarea',
      'default'   => wp_kses( __( 'You have received a new withdraw request from the "{{user_name}}" <br/> You can click <a href="{{detail}}">this link</a> to view the withdrawal details <br/>'
        , 'taskbot'),
        array(
          'a'	=> array(
            'href'  => array(),
            'title' => array()
          ),
          'br'      => array(),
          'em'      => array(),
          'strong'  => array(),
        )
      ),
      'title'     => esc_html__( 'Email contents', 'taskbot' ),
    ),

	
    /* User Email on withdraw request approved */
    array(
      'id'      => 'divider_withdraw_approved_templates',
      'type'    => 'info',
      'title'   => esc_html__( 'Withdraw approved', 'taskbot' ),
	  'desc'  	=> esc_html__( 'Email to user on withdraw approved', 'taskbot' ),
      'style'   => 'info',
    ),
    array(
      'id'      	=> 'withdraw_approve_user_subject',
      'type'    	=> 'text',
      'title'   	=> esc_html__( 'Subject', 'taskbot' ),
      'desc'    	=> esc_html__( 'Please add withdraw approved email subject.', 'taskbot' ),
      'default' 	=> esc_html__( 'Your withdrawal request has been approved','taskbot'),
    ),
    array(
      'id'      	=> 'withdraw_approve_user_greeting',
      'type'    	=> 'text',
      'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
      'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
      'default' 	=> esc_html__( 'Hello {{user_name}},','taskbot' ),

    ),
    array(
      'id'      => 'divider_withdraw_approved_information',
      'desc'    => wp_kses( __( '{{user_name}} — To display the sender name.<br>
						{{user_link}} — To display the user link.<br>
						{{amount}} — To display the amount.<br>
						{{detail}} — To display the withdraw detail link.<br>'
        , 'taskbot'),
        array(
          'a'	=> array(
            'href'  => array(),
            'title' => array()
          ),
          'br'      => array(),
          'em'      => array(),
          'strong'  => array(),
        )
      ),
      'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
      'type'      => 'info',
      'class'     => 'dc-center-content',
      'icon'      => 'el el-info-circle',
    ),
    array(
      'id'        => 'withdraw_approved_mail_content',
      'type'      => 'textarea',
      'default'   => wp_kses( __( 'Your withdraw request has been approved. <br/> You can click <a href="{{detail}}">this link</a> to view the withdrawal details.<br/>'
        , 'taskbot'),
        array(
          'a'	=> array(
            'href'  => array(),
            'title' => array()
          ),
          'br'      => array(),
          'em'      => array(),
          'strong'  => array(),
        )
      ),
      'title'     => esc_html__( 'Email contents', 'taskbot' ),
    ),
	/* User Email on Refund Comment */
	array(
		'id'      => 'divider_order_refund_admin_comment_templates',
		'type'    => 'info',
		'title'   => esc_html__( 'Refund comment from admin', 'taskbot' ),
		'style'   => 'info',
	),
	array(
		'id'       => 'email_refund_comment_admin',
		'type'     => 'switch',
		'title'    => esc_html__('Send email', 'taskbot'),
		'subtitle' => esc_html__('Email to user on refund comment from admin', 'taskbot'),
		'default'  => true,
	),
	array(
		'id'      => 'refund_admin_comment_subject',
		'type'    => 'text',
		'title'   => esc_html__( 'Subject', 'taskbot' ),
		'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
		'default' => esc_html__( 'A new comment on refund request','taskbot'),
		'required'  => array('email_refund_comment_admin','equals','1')

	),
	array(
		'id'      => 'divider_declined_order_admin_refund_information',
		'desc'    => wp_kses( __( '
					{{receiver_name}} — To display the reciver name.<br>
					{{task_name}} — To display the task name.<br>
					{{task_link}} — To display the task link.<br>
					{{order_id}} — To display the order id.<br>
					{{order_amount}} — To display the order amount.<br>
					{{login_url}} — To display the login url.<br>
					{{sender_comments}} — To display the sender comment.<br>'
	, 'taskbot' ),
	array(
			'a'       => array(
				'href'  => array(),
				'title' => array()
			),
			'br'      => array(),
			'em'      => array(),
			'strong'  => array(),
		) ),
		'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
		'type'      => 'info',
		'class'     => 'dc-center-content',
		'icon'      => 'el el-info-circle',
		'required'  => array('email_refund_comment_admin','equals','1')
	),
	array(
		'id'      => 'order_refund_admin_comment_email_greeting',
		'type'    => 'text',
		'title'   => esc_html__( 'Greeting', 'taskbot' ),
		'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
		'default' => esc_html__( 'Hello {{receiver_name}},','taskbot'),
		'required'  => array('email_refund_comment_admin','equals','1')
	),
	array(
		'id'        => 'refund_admin_comment_content',
		'type'      => 'textarea',
		'default'   => wp_kses( __( 'The Admin has left some comments on the refund request against the order #{{order_id}}<br/>{{sender_comments}}<br/>{{login_url}}', 'taskbot'),
		array(
			'a'	=> array(
			'href'  => array(),
			'title' => array()
			),
			'br'      => array(),
			'em'      => array(),
			'strong'  => array(),
		)),
		'title'     => esc_html__( 'Email contents', 'taskbot' ),
		'required'  => array('email_refund_comment_admin','equals','1')

	),
	/* Email to admin for identity verification request  */
    array(
		'id'      => 'divider_identification_templates',
		'type'    => 'info',
		'title'   => esc_html__( 'Account identity verify request', 'taskbot' ),
		'style'   => 'info',
	  ),
	  array(
		'id'      	=> 'admin_email_verify_identity',
		'type'   	=> 'text',
		'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
		'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
		'default' 	=> get_option('admin_email', 'info@example.com'),
	),
	  array(
		'id'      	=> 'admin_verified_subject',
		'type'    	=> 'text',
		'title'   	=> esc_html__( 'Subject', 'taskbot' ),
		'desc'    	=> esc_html__( 'You have received a new identity verification request', 'taskbot' ),
		'default' 	=> esc_html__( 'Identity verification','taskbot'),
	  ),
	  array(
		'id'      => 'admin_verified_information',
		'desc'    => wp_kses( __( '{{user_name}} — To display the user name.<br>
						  {{user_link}} — To display the user link who send the identity verification.<br/>
						  {{user_email}} — To display the user email address who send the identity verification request.<br/>
						  '
		  , 'taskbot'),
		  array(
			'a'	=> array(
			  'href'  => array(),
			  'title' => array()
			),
			'br'      => array(),
			'em'      => array(),
			'strong'  => array(),
		  )
		),
		'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
		'type'      => 'info',
		'class'     => 'dc-center-content',
		'icon'      => 'el el-info-circle',
	  ),
	  array(
		'id'        => 'admin_verified_content',
		'type'      => 'textarea',
		'default'   => wp_kses( __( 'You have received a new identity verification from the "{{user_name}}" <br/>You can click <a href="{{user_link}}">this link</a> to verify this user identity', 'taskbot'),
		  array(
			'a'	=> array(
			  'href'  => array(),
			  'title' => array()
			),
			'br'      => array(),
			'em'      => array(),
			'strong'  => array(),
		  )
		),
		'title'     => esc_html__( 'Email contents', 'taskbot' ),
	  ),

	  /* Admin Email to verify new user */
      array(
        'id'      => 'divider_verify_user_admin_registration_templates',
        'type'    => 'info',
        'title'   => esc_html__( 'Admin email verify user', 'taskbot' ),
        'style'   => 'info',
      ),
	  array(
		'id'      	=> 'admin_email_user_registration_verify_request',
		'type'   	=> 'text',
		'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
		'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
		'default' 	=> get_option('admin_email', 'info@example.com'),
		'required' 	=> array('email_admin_registration','equals','1')
	),
      array(
        'id'      => 'admin_verify_register_user_subject',
        'type'    => 'text',
        'title'   => esc_html__( 'Subject', 'taskbot' ),
        'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
        'default' => esc_html__( 'New registration approval request at {{sitename}}', 'taskbot'),
      ),
      array(
        'id'      => 'divider_adminemail_verify_user_confirmation_information',
			  'desc'    =>	wp_kses( __( '{{name}} — To display the user name.<br>
								{{email}} — To display the user email.<br>
								{{sitename}} — To display the sitename.<br>
								{{login_url}} — To display the login url.<br>'
          , 'taskbot' ),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          ) ),
        'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
        'type'      => 'info',
        'class'     => 'dc-center-content',
        'icon'      => 'el el-info-circle'
      ),
      array(
        'id'      	=> 'email_admin_verify_user_registration_greeting',
        'type'    	=> 'text',
        'title'   	=>  esc_html__( 'Greeting', 'taskbot' ),
        'desc'    	=>  esc_html__( 'Please add text.', 'taskbot' ),
        'default' 	=>  esc_html__( 'Hello,', 'taskbot'),
      ),
      array(
        'id'        => 'admin_verify_user_registration_content',
        'type'      => 'textarea',
        'default'   =>  wp_kses( __( 'A new user has been registered on the site with the name "{{name}}" and email address "{{email}}". <br/> The registration is pending for approval, you can login  {{login_url}} to the admin to approve the account.', 'taskbot' ),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          ) ),
        'title'     =>  esc_html__( 'Email contents', 'taskbot' ),
      ),

    /* Admin Email on Register */
		array(
			'id'      => 'divider_email_admin_registration_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Admin email on registration', 'taskbot' ),
			'style'   => 'info',
		),
      array(
        'id'       => 'email_admin_registration',
        'type'     => 'switch',
        'title'    => esc_html__( 'Send email', 'taskbot' ),
        'subtitle' => esc_html__( 'Email to admin on new user register!', 'taskbot' ),
        'default'  => true,
      ),
	  array(
		'id'      	=> 'admin_email_user_registration',
		'type'   	=> 'text',
		'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
		'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
		'default' 	=> get_option('admin_email', 'info@example.com'),
		'required' 	=> array('email_admin_registration','equals','1')
	),
		array(
			'id'      => 'admin_registration_subject',
			'type'    => 'text',
			'title'   => esc_html__( 'Subject', 'taskbot' ),
			'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' => esc_html__( 'New registration at {{sitename}}', 'taskbot'),
      'required' 	=> array('email_admin_registration','equals','1')
		),
		array(
			'id'      => 'divider_adminemail_confirmation_information',
			'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
								{{email}} — To display the user email.<br>
								{{sitename}} — To display the sitename.<br>'
			, 'taskbot' ),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
			'br'      => array(),
			'em'      => array(),
			'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
      'required' 	=> array('email_admin_registration','equals','1'),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle'
		),
		array(
			'id'      	=> 'email_admin_registration_greeting',
			'type'    	=> 'text',
			'title'   	=>  esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=>  esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=>  esc_html__( 'Hello,', 'taskbot'),
			'required' 	=>  array('email_admin_registration','equals','1')
		),
		array(
			'id'        => 'admin_registration_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'A new user has been registered on the site with the name "{{name}}" and email address "{{email}}"', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     =>  esc_html__( 'Email contents', 'taskbot' ),
      'required' 	=> array('email_admin_registration','equals','1')
		),

	  /* Proposal submitted admin email  */
	  array(
		'id'      => 'divider_submited_proposal_admin_templates',
		'type'    => 'info',
		'title'   =>  esc_html__('Submited proposal', 'taskbot'),
		'style'   => 'info',
		),
		array(
			'id'       => 'email_submited_proposal_admin',
			'type'     => 'switch',
			'title'    =>  esc_html__('Send email', 'taskbot'),
			'subtitle' =>  esc_html__('Email to admin on submit proposal.', 'taskbot'),
			'default'  =>  true,
		),
		array(
			'id'      	=> 'submited_proposal_admin_email',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
			'default' 	=> get_option('admin_email', 'info@example.com'),
			'required' 	=> array('email_submited_proposal_admin','equals','1')
		),
		array(
			'id'      	=> 'submited_proposal_admin_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Submited Proposal','taskbot'),
			'required'  => array( 'email_submited_proposal_admin','equals','1')
		),
		array(
			'id'      => 'submited_proposal_admin_information',
			'desc'    => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
						{{seller_name}} — To display the seller name.<br>
						{{project_title}} — To display the project title.<br>
						{{proposal_link}} — To display the proposal link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array( 'email_submited_proposal_admin','equals','1')
		),
		array(
			'id'        => 'submited_proposal_admin_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( '{{seller_name}} submit a new proposal on {{project_title}} Please click on the button below to view the project. {{project_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array( 'email_submited_proposal_admin','equals','1')
		),

		/* Admin Email on project dispute request */
		array(
			'id'      => 'divider_admin_project_dispute_req_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Project dispute request', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'      	=> 'project_dispute_req_email_admin',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Admin email', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email.', 'taskbot'),
			'default' 	=> get_option('admin_email', 'info@example.com'),
		),
		array(
			'id'      	=> 'admin_project_dispute_req_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Project dispute request','taskbot'),
		),
		array(
			'id'      => 'divider_admin_project_dispute_req_information',
			'desc'    => wp_kses(__( '{{user_name}} — To display the sender name.<br>
						{{project_title}} — To display the project title.<br>
						{{admin_dispute_link}} — To display the dispute link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
		),
		array(
			'id'        => 'project_dispute_req_admin_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You have received a new dispute request from {{buyer_name}}<br/>Please click on the button below to view the dispute details.<br/>{{admin_dispute_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
		),

	)
) );

/* Email template for seller */

Redux::setSection( $opt_name, array(
	'title'			  	=> esc_html__( 'Seller', 'taskbot' ),
	'id'			  	=> 'seller_email_templates',
	'desc'			  	=> 'Seller email templates',
	'icon'			  	=> '',
	'subsection'		=> true,
	'fields'		  	=> $seller_email_fields,
) );

 /* Email template for buyer */

Redux::setSection( $opt_name, array(
	'title'			=> esc_html__( 'Buyer', 'taskbot' ),
	'id'			=> 'buyer_email_templates',
	'desc'			=> 'Buyer email templtes',
	'icon'			=> '',
	'subsection'	=> true,
	'fields'		=> $buyer_email_fields
) );

/* Email template for disputes */
Redux::setSection( $opt_name, array(
	'title'			=> esc_html__( 'Disputes', 'taskbot' ),
	'id'			=> 'disputes_email_templates',
	'desc'			=> 'Dsiputes email templates',
	'icon'			=> '',
	'subsection'	=> true,
	'fields'		=> array(
		/* Project dispute refunded to winner */
		array(
			'id'      => 'divider_disputes_winner_proj_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Project dispute in winner favour', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'project_disputes_favour_winner_switch',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to winner on dispute refunded', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'email_project_disputes_favour_winner_subject',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Project dispute refunded in favour','taskbot' ),
      		'required' 	=> array('project_disputes_favour_winner_switch','equals','1')
		),
		array(
			'id'      => 'divider_project_disputes_favour_winner_info',
			'desc'    => wp_kses(__( '{{user_name}} — To display the user name.<br>
						{{admin_name}} — To display the admin name.<br>
						{{dispute_link}} — To display the dispute link.<br>'
						, 'taskbot'
						),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
      		'required' 	=> array('project_disputes_favour_winner_switch','equals','1')
		),
		array(
			'id'      	=> 'project_disputes_favour_winner_greeting',
			'type'    	=> 'text',
			'title'   	=> 	esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> 	esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> 	esc_html__( 'Hello {{user_name}},','taskbot' ),
			'required'  => 	array('email_project_rej_buyer','equals','1')
		),
		array(
			'id'        => 'project_disputes_favour_winner_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Woohoo! {{admin_name}} approved dispute refund request in your favor.<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
      		'required' 	=> array('project_disputes_favour_winner_switch','equals','1')
		),

		/* Dispute refunded against looser */
		array(
			'id'      => 'divider_disputes_looser_proj_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Project dispute not in favour', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'project_disputes_against_looser_switch',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to looser on dispute refunded', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'email_project_disputes_against_looser_subject',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Project dispute not in favour','taskbot' ),
      		'required' 	=> array('project_disputes_against_looser_switch','equals','1')
		),
		array(
			'id'      => 'divider_project_disputes_against_looser_info',
			'desc'    => wp_kses(__( '{{user_name}} — To display the user name.<br>
						{{admin_name}} — To display the admin name.<br>
						{{dispute_link}} — To display the dispute link.<br>'
						, 'taskbot'
						),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
      		'required' 	=> array('project_disputes_against_looser_switch','equals','1')
		),
		array(
			'id'      	=> 'project_disputes_against_looser_greeting',
			'type'    	=> 'text',
			'title'   	=> 	esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> 	esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> 	esc_html__( 'Hello {{user_name}},','taskbot' ),
			'required'  => 	array('project_disputes_against_looser_switch','equals','1')
		),
		array(
			'id'        => 'project_disputes_against_looser_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Oho! {{admin_name}} did not approve the dispute refund request in your favor.<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
      		'required' 	=> array('project_disputes_against_looser_switch','equals','1')
		),

		/* Project dispute comment by admin to seller & buyer */
		array(
			'id'      => 'divider_project_dispute_admin_comment_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Admin comment on disputes', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'project_dispute_admin_comment_switch',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to users on dispute admin comment', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'email_project_dispute_admin_comment_subject',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Admin comment on dispute','taskbot' ),
      		'required' 	=> array('project_dispute_admin_comment_switch','equals','1')
		),
		array(
			'id'      => 'divider_project_dispute_admin_comment_info',
			'desc'    => wp_kses(__( '{{user_name}} — To display the user name.<br>
						{{admin_name}} — To display the admin name.<br>
						{{dispute_link}} — To display the dispute link.<br>'
						, 'taskbot'
						),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
      		'required' 	=> array('project_dispute_admin_comment_switch','equals','1')
		),
		array(
			'id'      	=> 'project_dispute_admin_comment_greeting',
			'type'    	=> 'text',
			'title'   	=> 	esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> 	esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> 	esc_html__( 'Hello {{user_name}},','taskbot' ),
			'required'  => 	array('project_dispute_admin_comment_switch','equals','1')
		),
		array(
			'id'        => 'project_dispute_admin_comment_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You have received a new dispute comment from {{admin_name}}<br/>Please click on the button below to view the dispute comment.<br/>{{dispute_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
      		'required' 	=> array('project_dispute_admin_comment_switch','equals','1')
		),

		/* Project dispute comment by user's to each other */
		array(
			'id'      => 'divider_project_dispute_user_comment_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'User comment on disputes', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'project_dispute_user_comment_switch',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to user on dispute comment', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'email_project_dispute_user_comment_subject',
			'type'   	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'User comment on dispute','taskbot' ),
      		'required' 	=> array('project_dispute_user_comment_switch','equals','1')
		),
		array(
			'id'      => 'divider_project_dispute_user_comment_info',
			'desc'    => wp_kses(__( '{{sender_name}} — To display the sender name.<br>
						{{receiver_name}} — To display the receiver name.<br>
						{{dispute_link}} — To display the dispute link.<br>'
						, 'taskbot'
						),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
      		'required' 	=> array('project_dispute_user_comment_switch','equals','1')
		),
		array(
			'id'      	=> 'project_dispute_user_comment_greeting',
			'type'    	=> 'text',
			'title'   	=> 	esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> 	esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> 	esc_html__( 'Hello {{receiver_name}},','taskbot' ),
			'required'  => 	array('project_dispute_user_comment_switch','equals','1')
		),
		array(
			'id'        => 'project_dispute_user_comment_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You have received a new dispute comment from {{sender_name}}<br/>Please click on the button below to view the dispute comment.<br/>{{dispute_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
      		'required' 	=> array('project_dispute_admin_comment_switch','equals','1')
		),

	)
));

/* Email template for Registration */
Redux::setSection( $opt_name, array(
  	'title'		=> esc_html__( 'Registration', 'taskbot' ),
  	'id'			=> 'user_register_email_templates',
  	'desc'	  	=> 'User register email templates',
  	'icon'	  	=> '',
  	'subsection'	=> true,
  	'fields'		  => array(
      array(
        'id'      => 'divider_email_social_registration_templates',
        'type'    => 'info',
        'title'   => esc_html__( 'Google registration email', 'taskbot' ),
        'style'   => 'info',
      ),
      array(
        'id'      => 'subject_social_registration_user_email',
        'type'    => 'text',
        'title'   => esc_html__( 'Subject', 'taskbot' ),
        'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
        'default' => esc_html__( 'Registration at {{sitename}} via google account', 'taskbot'),
      ),
      array(
        'id'      => 'information_social_registration_user_email',
        'desc'    =>	wp_kses( __( '{{name}} — To display the user name.<br>
								{{email}} — To display the user email.<br>
								{{sitename}} — To display the sitename.<br>'
          , 'taskbot' ),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          ) ),
        'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
        'type'      => 'info',
        'class'     => 'dc-center-content',
        'icon'      => 'el el-info-circle'
      ),
      array(
        'id'      	=> 'greeting_social_registration_user_email',
        'type'    	=> 'text',
        'title'   	=>  esc_html__( 'Greeting', 'taskbot' ),
        'desc'    	=>  esc_html__( 'Please add text.', 'taskbot' ),
        'default' 	=>  esc_html__( 'Hello {{name}},', 'taskbot'),
      ),
      array(
        'id'        => 'content_social_registration_user_email',
        'type'      => 'textarea',
        'default'   =>  wp_kses( __( 'Thank you for the registration at "{{sitename}}" Your account has been created. ', 'taskbot' ),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          ) ),
        'title'     =>  esc_html__( 'Email contents', 'taskbot' ),
      ),
	/* Social account approve after verification */
      array(
        'id'      => 'divider_email_social_registration_approval_templates',
        'type'    => 'info',
        'title'   => 	esc_html__( 'Google registered account approve after verification', 'taskbot' ),
        'style'   => 'info',
      ),
      array(
        'id'      => 'social_user_account_approval_subject',
        'type'    => 'text',
        'title'   =>  esc_html__( 'Subject', 'taskbot' ),
        'desc'    =>  esc_html__( 'Please add email subject.', 'taskbot' ),
        'default' =>  esc_html__( 'Registration at {{sitename}} via google account', 'taskbot'),
      ),

      array(
        'id'      => 'divider_social_user_account_request_approval_information',
        'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
							{{email}} — To display the user email.<br>
							{{sitename}} — To display the sitename.<br>'
          , 'taskbot' ),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          ) ),
        'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
        'type'      => 'info',
        'class'     => 'dc-center-content',
        'icon'      => 'el el-info-circle'
      ),
      array(
        'id'      => 'user_social_account_approval_request_greeting',
        'type'    => 'text',
        'title'   =>  esc_html__( 'Greeting', 'taskbot' ),
        'desc'    =>  esc_html__( 'Please add text.', 'taskbot' ),
        'default' =>  esc_html__( 'Hello {{name}},', 'taskbot'),
      ),
      array(
        'id'        => 'user_social_account_approval_content',
        'type'      => 'textarea',
		'default'   => wp_kses( __( 'Thank you for the registration at "{{sitename}}".<br/>Your account will be approved  after the verification.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
        'title'     =>  esc_html__( 'Email contents', 'taskbot' )
      ),

    /* Email to user on Account Approve Request */
		array(
			'id'      => 'divider_approval_request_user_account_templates',
			'type'    => 'info',
			'title'   => 	esc_html__( 'Account approve after verification', 'taskbot' ),
			'style'   => 'info',
		),

		array(
			'id'      => 'user_account_approval_subject',
			'type'    => 'text',
			'title'   =>  esc_html__( 'Subject', 'taskbot' ),
			'desc'    =>  esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' =>  esc_html__( 'Thank you for registration at {{sitename}}', 'taskbot'),
		),

		array(
			'id'      => 'divider_user_account_request_approval_information',
			'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
							{{email}} — To display the user email.<br>
							{{password}} — To display the user password.<br>
							{{sitename}} — To display the sitename.<br>'
			, 'taskbot' ),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
			),
			'br'      => array(),
			'em'      => array(),
			'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle'
		),
		array(
			'id'      => 'user_account_approval_request_greeting',
			'type'    => 'text',
			'title'   =>  esc_html__( 'Greeting', 'taskbot' ),
			'desc'    =>  esc_html__( 'Please add text.', 'taskbot' ),
			'default' =>  esc_html__( 'Hello {{name}},', 'taskbot'),
		),
		array(
			'id'        => 'user_account_approval_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Thank you for the registration at {{sitename}}. Your account will be approved  after the verification.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     =>  esc_html__( 'Email contents', 'taskbot' )
		),

    /* Email on Account Approved */
		array(
			'id'      => 'divider_approved_user_account_templates',
			'type'    => 'info',
			'title'   =>  esc_html__( 'Account approved', 'taskbot' ),
			'style'   => 'info',
		),

		array(
			'id'      => 'user_approved_account_subject',
			'type'    => 'text',
			'title'   => esc_html__( 'Subject', 'taskbot' ),
			'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' => esc_html__( 'Account approved.','taskbot'),
		),
		array(
		'id'      => 'divider_user_approved_account_information',
		'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
								{{email}} — To display the user email.<br>
								{{sitename}} — To display the sitename.<br>'
			, 'taskbot' ),
			array(
			'a'       => array(
				'href'  => array(),
				'title' => array()
			),
			'br'      => array(),
			'em'      => array(),
			'strong'  => array(),
			) ),
		'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
		'type'      => 'info',
		'class'     => 'dc-center-content',
		'icon'      => 'el el-info-circle'
		),
		array(
		'id'      => 'user_email_request_approved_account_greeting',
		'type'    => 'text',
		'title'   => esc_html__( 'Greeting', 'taskbot' ),
		'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
		'default' => esc_html__( 'Hello {{name}},','taskbot'),
		),
		array(
		'id'        => 'approved_user_account_content',
		'type'      => 'textarea',
		'default'   => wp_kses( __( 'Congratulations! Your account has been approved by the admin.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
		'title'     => esc_html__( 'Email contents', 'taskbot' )
		),
      /* Email on Password reset */
      array(
        'id'      => 'divider_password_reset_templates',
        'type'    => 'info',
        'title'   =>  esc_html__( 'Password reset', 'taskbot' ),
        'style'   => 'info',
      ),
      array(
        'id'      => 'user_password_reset_subject',
        'type'    => 'text',
        'title'   => esc_html__( 'Subject', 'taskbot' ),
        'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
        'default' => esc_html__( 'Reset Password.','taskbot'),
      ),
      array(
        'id'      => 'divider_user_reset_password_information',
        'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
								{{email}} — To display the user email.<br>
								{{sitename}} — To display the sitename.<br>
								{{reset_link}} — To display the sitename.<br>'
          , 'taskbot' ),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          ) ),
        'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
        'type'      => 'info',
        'class'     => 'dc-center-content',
        'icon'      => 'el el-info-circle'
      ),
      array(
        'id'      => 'user_reset_password_greeting',
        'type'    => 'text',
        'title'   => esc_html__( 'Greeting', 'taskbot' ),
        'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
        'default' => esc_html__( 'Hello {{name}},','taskbot'),
      ),
      array(
        'id'        => 'user_reset_password_content',
        'type'      => 'textarea',
        'default'   => wp_kses( __( 'Someone requested to reset the password of following account: <br/> Email Address: {{account_email}} <br/>If this was a mistake, just ignore this email and nothing will happen.<br/>To reset your password, click reset link below:<br/>{{reset_link}}', 'taskbot' ),
          array(
            'a'       => array(
              'href'  => array(),
              'title' => array()
            ),
            'br'      => array(),
            'em'      => array(),
            'strong'  => array(),
          ) ),
        'title'     => esc_html__( 'Email Contents', 'taskbot' ),
      ),
	  /* User identification email  */
		array(
			'id'      => 'divider_user_identification_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Account identity rejection', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'      	=> 'rejected_verify_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add subject for identity verification.', 'taskbot' ),
			'default' 	=> esc_html__( 'Your request for identity verification has been rejected','taskbot'),
		),
		array(
			'id'      => 'rejected_verify_verified_information',
			'desc'    => wp_kses( __( '{{user_name}} — To display the user name.<br>
							{{user_link}} — To display the user link who send the identity verification.<br/>
							{{admin_message}} — To display the admin message for rejection.<br/>
							{{user_email}} — To display the user email address who send the identity verification request.<br/>
							'
			, 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)
			),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
		),
		array(
			'id'      	=> 'rejected_verify_email_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{user_name}},','taskbot' ),
	  
		),
		array(
			'id'        => 'rejected_verify_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You uploaded document for identity verification has been rejected.<br/>{{admin_message}}'
			, 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)
			),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
		),
		/* User identification email */
		array(
			'id'      => 'divider_approved_identification_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Account identity approved', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'      	=> 'approved_verify_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add subject for identity verification.', 'taskbot' ),
			'default' 	=> esc_html__( 'Identity approved','taskbot'),
		),
		array(
			'id'      => 'approved_verify_verified_information',
			'desc'    => wp_kses( __( '{{user_name}} — To display the user name.<br>
							{{user_link}} — To display the user link who send the identity verification.<br/>
							{{user_email}} — To display the user email address who send the identity verification request.<br/>
							'
			, 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)
			),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
		),
		array(
			'id'      	=> 'approved_verify_email_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{user_name}},','taskbot' ),
	  
		),
		array(
			'id'        => 'approved_verify_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Congratulations!<br/>Your submitted documents for the identity verification has been approved.'
			, 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)
			),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
		),

		/* User registration email */
		array(
			'id'      => 'divider_user_register_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'User register', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'      	=> 'user_registration_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add subject for user registration.', 'taskbot' ),
			'default' 	=> esc_html__( 'Thank you for registration at {{sitename}}','taskbot'),
		),
		array(
			'id'      => 'register_user_new_information',
			'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
							{{email}} — To display the email<br/>
							{{sitename}} — To display the sitename<br/>
							{{password}} — To display the password<br/>
							{{verification_link}} — To display the verification link<br/>', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
		),
		array(
			'id'      	=> 'email_user_registration_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text for greeting.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{name}},','taskbot' ),
	  
		),
		array(
			'id'        => 'user_registration_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Thank you for the registration at "{{sitename}}". Please click below to verify your account<br/> {{verification_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
		),




  )));
