<?php
/**
 * List notifications
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $taskbot_notification;
$linked_profile     = !empty($args['linked_profile']) ? $args['linked_profile'] : 0;
$current_use_id     = !empty($linked_profile) ? taskbot_get_linked_profile_id($linked_profile,'post') : 0; 
$post_limit         =  !empty($taskbot_notification['notification_limit']) ? intval($taskbot_notification['notification_limit']) : 3;
$query_args = array(
	'post_type'			=> 'notification',
	'post_status'		=> 'publish',
	'posts_per_page'	=> intval($post_limit),
	'orderby'			=> array('meta_value_num' => 'ASC','ID' => 'DESC'),
    'meta_key'          => 'status',
	'meta_query'        => array(
        array(
            'key'     => 'linked_profile',
            'value'   => $linked_profile,
            'compare' => '=',
        ),
        array(
            'key'     => 'status',
            'value'   => 0,
            'compare' => '=',
        )
    ),
);
$notify_query   = new WP_Query($query_args);
$count_post     = $notify_query->found_posts;
$meata_keys     = array( 'linked_profile'=>$linked_profile,'status'=>0);
$unread_message = taskbot_post_count('notification','publish',$meata_keys);
?>

<div class="tk-notidropdowns asdasd">
    <a class="tk-nav-icons tb-notifyheader" data-url="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('notifications', $current_use_id, false, 'listing');?>" href="javascript:void(0);">
        <i class="icon-bell"></i>
        <?php if(!empty($unread_message) ){?><em class="tk-remaining-notification tk-notfy-counter"><?php echo intval($unread_message);?></em><?php } ?>
        <span><?php esc_html_e('Notifications','taskbot');?></span>
    </a>
    <div class="tk-noti_wrap">
        <div class="tk-notiwrap_title">
            <h5><?php esc_html_e('Notifications','taskbot');?></h5>
            <?php if( !empty($unread_message) ){?>
                <span class="tk-noti-counter"><?php echo sprintf(_n('%s New','%s New',$unread_message,'taskbot'),$unread_message); ?></span>
            <?php } ?>
        </div>
        <ul class="tb-notify-list" id="tb-notify-list" data-post_id="<?php echo intval($linked_profile);?>">
            <?php 
            if ($notify_query->have_posts()) { 
                while ($notify_query->have_posts()) {
                $notify_query->the_post();
                global $post;
                $msg_read		= get_post_meta( $post->ID, 'status', true );
                $msg_read		= !empty($msg_read) ? $msg_read : 0;
                $msg_class		= !empty($msg_read) ? '' : 'tk-noti-unread';
                ?>
                    <li class="<?php echo esc_attr( $msg_class );?> tb_notify_<?php echo intval($post->ID);?>"><?php do_action( 'taskbot_single_message', $post->ID );?></li>
                <?php
                }
            } else { ?>
                <li class="tk-noti_empty">
                    <span>
                        <i class="icon-bell-off"></i>
                    </span>
                    <em><?php esc_html_e('No notification available','taskbot');?></em>
                </li>
            <?php } ?>
        </ul>
        <div class="tk-noti_showall" >
            <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('notifications', $current_use_id, false, 'listing');?>"><?php esc_html_e('Show all','taskbot');?></a>
        </div>
    </div>
</div>