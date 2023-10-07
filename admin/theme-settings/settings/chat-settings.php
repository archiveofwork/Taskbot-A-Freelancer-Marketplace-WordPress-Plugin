<?php
if (!defined('ABSPATH')) exit;
/**
 * Chat Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
if((in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins')))) ){
  Redux::set_section($opt_name, array(
      'title' => esc_html__('Chat Settings', 'taskbot'),
      'id' => 'setting_chat_mesages',
      'desc' => '',
      'icon' => 'el el-comment-alt',
      'subsection' => false,
      'fields' => array(
        array(
          'id'       => 'hire_seller_chat_switch',
          'type'     => 'switch',
          'title'    => esc_html__( 'Send Message', 'taskbot' ),
          'subtitle' => esc_html__( 'Set default message for seller on hiring.', 'taskbot' ),
          'default'  => true,
        ),
        array(
          'id'      => 'divider_chat_message_to_seller',
          'desc'    => wp_kses( __( '{{taskname}} — To display the task name.<br>
                            {{tasklink}} — To display the task link.<br>'
            , 'taskbot' ),
            array(
                'a'     => array(
                'href'  => array(),
                'title' => array()
              ),
              'br'      => array(),
              'em'      => array(),
              'strong'  => array(),
            ) ),
          'title'     => esc_html__( 'Message setting variables', 'taskbot' ),
          'type'      => 'info',
          'class'     => 'dc-center-content',
          'icon'      => 'el el-info-circle',
          'required' 	=> array('hire_seller_chat_switch','equals','1')
        ),
        array(
          'id'        => 'hire_seller_chat_mesage',
          'type'      => 'textarea',
          'title'     => esc_html__('Chat Message', 'taskbot'),
          'subtitle'  => esc_html__('Default chat message for seller on hiring', 'taskbot'),
          'required' 	=> array('hire_seller_chat_switch','equals','1'),
          'default'   => wp_kses(__('Congratulations! You have hired for the task "{{taskname}}" {{tasklink}}', 'taskbot'),
            array(
              'a' => array(
                'href' => array(),
                'title' => array()
              ),
              'br'      => array(),
              'em'      => array(),
              'strong'  => array(),
            )
          ),
        ),
      )
    )
  );
}

