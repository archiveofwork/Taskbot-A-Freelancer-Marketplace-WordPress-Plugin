<?php
/**
 * Notification settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/

/**
 * Get notification options
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists('taskbot_get_notif_option')){
    function taskbot_get_notif_option($type='') {
        $notify_list    = array();
        $lists          = apply_filters( 'taskbot_list_notification', 'type', $type );
        if( !empty($lists) ){
            foreach($lists as $key => $list){
                $notify_list[]  = array(
                                    'id'      => $key.'_divider',
                                    'type'    => 'info',
                                    'title'   => !empty($list['title']) ? $list['title'] : '',
                                    'style'   => 'info'
                );

                $notify_list[]  = array(
                    'id'      => $key.'_notify_module',
                    'type'    => 'switch',
                    'title'   => !empty($list['enable_title']) ? $list['enable_title'] : '',
                    'default'  => true,
                    'required' 	=> array('notify_module','equals','1')
                );
                $notify_list[]  = array(
                    'id'      => $key.'_flash_message',
                    'type'    => 'switch',
                    'title'   => !empty($list['flash_message_title']) ? $list['flash_message_title'] : '',
                    'default'  => !empty($list['flash_message_option']) ? $list['flash_message_option'] : false,
                    'required' 	=> array(
                        array('notify_module','equals','1'),
                        array($key.'_notify_module','equals','1')
                    )
                );
                $notify_list[]  = array(
                    'id'        => $key.'_notify_info',
                    'type'      => 'info',
                    'class'     => 'dc-center-content',
			        'icon'      => 'el el-info-circle',
                    'desc'     => wp_kses(
                                    $list['tags'],
                                    array(
                                    'a'       => array(
                                        'href'  => array(),
                                        'title' => array()
                                    ),
                                    'br'      => array(),
                                    'em'      => array(),
                                    'strong'  => array(),
                                )),
                    'title'     => !empty($list['tag_title']) ? $list['tag_title'] : '',
                    'required' 	=> array(
                        array('notify_module','equals','1'),
                        array($key.'_notify_module','equals','1')
                    )
                );
                $notify_list[]  = array(
                    'id'        => $key.'_notify_content',
                    'type'      => 'editor',
                    'title'     => !empty($list['content_title']) ? $list['content_title'] : '',
                    'default'   => !empty($list['content']) ? $list['content'] : '',
                    'required' 	=> array($key.'_notify_module','equals','1')
                );

            }
        }
        return $notify_list;
    }
}


if ( ! class_exists( 'Redux' ) ) { return;}
$notify_op_name 	= "taskbot_notification";
$args = array(
    'opt_name'    		=> $notify_op_name,
    'display_name' 		=> esc_html__('Notification templates','taskbot') ,
    'display_version' 	=> TASKBOT_VERSION,
    'menu_type' 		=> 'menu',
    'allow_sub_menu' 	=> true,
    'menu_title' 		=> esc_html__('Notification templates', 'taskbot'),
	'page_title'        => esc_html__('Notification templates', 'taskbot') ,
    'google_api_key' 	=> '',
    'google_update_weekly' => false,
    'async_typography' 	   => true,
    'admin_bar' 		=> true,
    'admin_bar_icon' 	=> 'dashicons-bell',
    'admin_bar_priority'=> 50,
    'global_variable' 	=> $notify_op_name,
    'dev_mode' 			=> false,
    'update_notice' 	=> false,
    'customizer' 		=> false,
    'page_priority' 	=> null,
    'page_parent' 		=> 'themes.php',
    'page_permissions'  => 'manage_options',
    'menu_icon' 		=> 'dashicons-bell',
    'last_tab' 			=> '',
    'page_slug' 		=> 'taskbot_notification',
    'save_defaults' 	=> true,
    'default_show' 		=> false,
    'default_mark' 		=> '',
    'show_import_export' => true
);
 
Redux::setArgs ($notify_op_name, $args);
include taskbot_load_template( 'admin/taskbot-notification/class-taskbot-settings' );
$scanfiles = glob(TASKBOT_DIRECTORY."/admin/taskbot-notification/settings/*");
foreach ( $scanfiles as $file_path ) {
	include $file_path;
}

include taskbot_load_template( 'admin/taskbot-notification/class-taskbot-notification' );
require_once(TASKBOT_DIRECTORY . "admin/taskbot-notification/pusher_auth.php");
