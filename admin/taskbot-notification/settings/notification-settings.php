<?php
/**
 * Notification Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
// notification general setting tab
Redux::setSection( $notify_op_name, array(
	'title'       => esc_html__( 'Notification settings', 'taskbot' ),
	'id'          => 'notification_settings',
	'desc'        => '',
	'icon'        => 'el el-bell',
	'subsection'  => false,
	'fields'      => array(
			array(
				'id'      => 'notification_divider',
				'type'    => 'info',
				'title'   => esc_html__( 'Notification settings', 'taskbot' ),
				'style'   => 'info',
			),
			array(
				'id'       => 'notify_module',
				'type'     => 'switch',
				'title'    => esc_html__( 'Notification module', 'taskbot' ),
				'subtitle' => esc_html__( 'Enable/disable notification module', 'taskbot' ),
				'default'  => true,
			),
			array(
				'id'       => 'pusher_notification',
				'type'     => 'switch',
				'title'    => esc_html__( 'Pusher notification', 'taskbot' ),
				'subtitle' => esc_html__( 'Enable/disable Pusher module', 'taskbot' ),
				'desc'	   => wp_kses( __( 'Enter pusher notification you need to get App ID, App Key, App secret key and Pusher cluster<a href="https://dashboard.pusher.com/" target="_blank"> Get API KEY </a>', 'taskbot' ), array(
					'a' => array(
					  'href' => array(),
					  'class' => array(),
					  'title' => array()
					  ),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
				  ) ),
				'required' 	=> array('notify_module','equals','1'),
				'default'  => false,
			),
			array(
				'id'      	=> 'pusher_app_id',
				'type'    	=> 'text',
				'title'   	=> esc_html__( 'Pusher app id', 'taskbot' ),
				'required' 	=> array('pusher_notification','equals','1')
			),
			array(
				'id'      	=> 'pusher_app_key',
				'type'    	=> 'text',
				'title'   	=> esc_html__( 'Pusher app key', 'taskbot' ),
				'required' 	=> array('pusher_notification','equals','1')
			),
			array(
				'id'      	=> 'pusher_app_secret',
				'type'    	=> 'text',
				'title'   	=> esc_html__( 'Pusher app secret key', 'taskbot' ),
				'required' 	=> array('pusher_notification','equals','1')
			),
			array(
				'id'      	=> 'pusher_app_cluster',
				'type'    	=> 'text',
				'title'   	=> esc_html__( 'Pusher cluster', 'taskbot' ),
				'required' 	=> array('pusher_notification','equals','1')
			),
			array(
				'id'      	=> 'notify_logo',
				'type'    	=> 'media',
				'compiler'	=> 'true',
				'url'     	=> true,
				'title'   	=> esc_html__( 'Notification bell icon', 'taskbot' ),
				'desc'    	=> esc_html__( 'Upload notification bell icon here', 'taskbot' ),
				'required' 	=> array('notify_module','equals','1')
			),
			array(
				'id'      	=> 'notification_limit',
				'type'    	=> 'text',
				'default'  	=> '6',
				'title'   	=> esc_html__( 'Notification limit', 'taskbot' ),
				'desc'    	=> esc_html__( 'Show notification limit on menu', 'taskbot' ),
				'required' 	=> array('notify_module','equals','1')
			),
		)
	) 
);
$registration_list	= taskbot_get_notif_option('registration');

Redux::setSection( $notify_op_name, array(
	'title'			=> esc_html__( 'Registration', 'taskbot' ),
	'id'			=> 'registration_notification_temp',
	'desc'			=> 'Registration templates',
	'icon'        	=> 'el el-user',
	'subsection'	=> true,
	'required' 		=> array('notify_module','equals','1'),
	'fields'		=>  $registration_list,
	
));

$task_list	= taskbot_get_notif_option('task');

Redux::setSection( $notify_op_name, array(
	'title'			=> esc_html__( 'Task', 'taskbot' ),
	'id'			=> 'task_notification_temp',
	'desc'			=> 'Task templates',
	'icon'			=> 'el el-tasks',
	'subsection'	=> true,
	'required' 		=> array('notify_module','equals','1'),
	'fields'		=>  $task_list,
	
));

$order_list	= taskbot_get_notif_option('order');

Redux::setSection( $notify_op_name, array(
	'title'			=> esc_html__( 'Order', 'taskbot' ),
	'id'			=> 'order_notification_temp',
	'desc'			=> 'order templates',
	'icon'			=> 'el el-th-list',
	'subsection'	=> true,
	'required' 		=> array('notify_module','equals','1'),
	'fields'		=>  $order_list,
	
));

$dispute_list	= taskbot_get_notif_option('dispute');

Redux::setSection( $notify_op_name, array(
	'title'			=> esc_html__( 'Dispute', 'taskbot' ),
	'id'			=> 'dispute_notification_temp',
	'desc'			=> 'Dispute templates',
	'icon'			=> 'el el-hearing-impaired',
	'subsection'	=> true,
	'required' 		=> array('notify_module','equals','1'),
	'fields'		=>  $dispute_list,
	
));

$packages_list	= taskbot_get_notif_option('packages');

Redux::setSection( $notify_op_name, array(
	'title'			=> esc_html__( 'Packages', 'taskbot' ),
	'id'			=> 'packages_notification_temp',
	'desc'			=> 'Packages templates',
	'icon'			=> 'el el-check',
	'subsection'	=> true,
	'required' 		=> array('notify_module','equals','1'),
	'fields'		=>  $packages_list,
	
));

$projects_list	= taskbot_get_notif_option('projects');

Redux::setSection( $notify_op_name, array(
	'title'			=> esc_html__( 'Projects', 'taskbot' ),
	'id'			=> 'projects_notification_temp',
	'desc'			=> 'Projects templates',
	'icon'			=> 'el el-check',
	'subsection'	=> true,
	'required' 		=> array('notify_module','equals','1'),
	'fields'		=>  $projects_list,
	
));

$proposals_list	= taskbot_get_notif_option('proposals');

Redux::setSection( $notify_op_name, array(
	'title'			=> esc_html__( 'Proposals', 'taskbot' ),
	'id'			=> 'proposals_notification_temp',
	'desc'			=> 'Proposals templates',
	'icon'			=> 'el el-check',
	'subsection'	=> true,
	'required' 		=> array('notify_module','equals','1'),
	'fields'		=>  $proposals_list,
	
));


