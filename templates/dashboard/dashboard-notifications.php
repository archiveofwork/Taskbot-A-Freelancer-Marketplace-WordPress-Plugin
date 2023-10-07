<?php

/**
 * Invoice Notifications
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */
global $current_user, $wp_roles, $userdata, $post;
$show_posts		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$paged 			= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$reference		= !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode			= !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity	= intval($current_user->ID);
$id				= !empty($args['id']) ? intval($args['id']) : '';
$user_type		= apply_filters('taskbot_get_user_type', $user_identity);
$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);

$current_date			= date('Ydm');
$yesterday_date			= date('Ydm',strtotime("-1 days"));

$current_date_count		= 0;
$previous_date_count	= 0;
$yesterday_date_count	= 0;
$args = array(
	'post_type'			=> 'notification',
	'post_status'		=> 'publish',
	'posts_per_page'	=> $show_posts,
	'paged'             => $paged,
	'orderby'			=> 'ID',
	'order'				=> 'DESC',
	'meta_query' => array(
		'relation' => 'AND',
        array(
            'key'     => 'linked_profile',
            'value'   => $linked_profile,
            'compare' => '=',
        ),
		array(
            'key'     => 'linked_profile',
            'value'   => 0,
            'compare' => '!=',
        ),
    ),
);

$query      = new WP_Query($args);
$count_post = $query->found_posts;
?>
<div class="tk-notification-listing-wrap">
	<div class="tk-noti_title">
		<h3><?php esc_html_e('Notifications', 'taskbot'); ?></h3>
	</div>
	<?php if ($query->have_posts()) { ?>
		<ul class="tk-noti_wrap">
			<?php while ($query->have_posts()) {
				$query->the_post();
				global $post;
				$posted_date	= get_the_date('Ydm',$post->ID);
				$msg_read		= get_post_meta( $post->ID, 'status', true );
				$msg_read		= !empty($msg_read) ? $msg_read : 0;
				$msg_class		= !empty($msg_read) ? '' : 'class="tk-noti-unread"';
				if( !empty($posted_date) && $posted_date == $current_date ){
					if (empty($current_date_count)) {
						$current_date_count	= $current_date_count+1; ?>
						<li class="tk-notiwrap_title"><h5><?php esc_html_e('Most recent','taskbot');?></h5></li>
				<?php }
				} else if( !empty($posted_date) && $posted_date == $yesterday_date ){
					if (empty($yesterday_date_count)) {
						$yesterday_date_count	= $yesterday_date_count+1; ?>
						<li class="tk-notiwrap_title"><h5><?php esc_html_e('Yesterday','taskbot');?></h5></li>
				<?php }
				} else {
					if( empty($previous_date_count) ) {
						$previous_date_count	= $previous_date_count+1; ?>
						<li class="tk-notiwrap_title"><h5><?php esc_html_e('Older notifications','taskbot');?></h5></li>
				<?php 
					}
				}
				?>
					<li <?php echo do_shortcode( $msg_class );?>><?php do_action( 'taskbot_single_message', $post->ID,true,'listing' );?></li>
				<?php
				if( empty($msg_read) ){
					update_post_meta( $post->ID, 'status', 1 );
				}
			} ?>
		</ul>
		<?php
		taskbot_paginate($query);
	}else{?>
		<ul class="tk-noti_wrap tk-empty-notifications">
			<li class="tk-noti_empty">
				<span><i class="icon-bell-off"></i></span>
				<em><?php esc_html_e('No notifications available','taskbot');?></em>
			</li>
		</ul>
	<?php
	}
	wp_reset_postdata();?>
</div>