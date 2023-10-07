<?php
/**
 * Dashboard seller insights
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user, $taskbot_settings;

$hide_languages       = !empty($taskbot_settings['hide_languages']) ? $taskbot_settings['hide_languages'] : 'no';
$reference		= !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode			= !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	= intval($current_user->ID);
$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);
$user_name		= taskbot_get_username($linked_profile);
$profile_link	= get_the_permalink( $linked_profile );
$switch_user    = !empty($taskbot_settings['switch_user']) ? $taskbot_settings['switch_user'] : false;
$width			= 300;
$height			= 300;
$avatar	= apply_filters(
	'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => $width, 'height' => $height), $linked_profile), array('width' => $width, 'height' => $height)
);

$tb_total_rating        = get_post_meta( $linked_profile, 'tb_total_rating', true );
$tb_total_rating		= !empty($tb_total_rating) ? $tb_total_rating : 0;
$tb_review_users		= get_post_meta( $linked_profile, 'tb_review_users', true );
$tb_review_users		= !empty($tb_review_users) ? $tb_review_users : 0;
$taskbot_profile_views	= get_post_meta( $linked_profile, 'taskbot_profile_views', true );
$taskbot_profile_views	= !empty($taskbot_profile_views) ? $taskbot_profile_views : 0;

$meta_array	= array(
	array(
		'key'		=> 'seller_id',
		'value'		=> $user_identity,
		'compare'	=> '=',
		'type'		=> 'NUMERIC'
	),
	array(
		'key'		=> '_task_status',
		'value'		=> 'completed',
		'compare'	=> '=',
	),
	array(
		'key'		=> 'payment_type',
		'value'		=> 'tasks',
		'compare'	=> '=',
	)
);
$taskbot_order_completed  = taskbot_get_post_count_by_meta('shop_order',array('wc-completed'),$meta_array);
$meta_array	= array(
	array(
		'key'		=> 'seller_id',
		'value'		=> $user_identity,
		'compare'	=> '=',
		'type'		=> 'NUMERIC'
	),
	array(
		'key'		=> '_task_status',
		'value'		=> 'hired',
		'compare'	=> '=',
	),
	array(
		'key'		=> 'payment_type',
		'value'		=> 'tasks',
		'compare'	=> '=',
	)
);
$taskbot_order_hired    	= taskbot_get_post_count_by_meta('shop_order',array('wc-completed'),$meta_array);
$taskbot_order_completed	= !empty($taskbot_order_completed) ? intval($taskbot_order_completed) : 0;
$taskbot_order_hired		= !empty($taskbot_order_hired) ? intval($taskbot_order_hired) : 0;
$taskbot_order_hired		= !empty($taskbot_order_hired) ? (($taskbot_order_completed + $taskbot_order_hired)/$taskbot_order_hired)*100 : 100;
$app_task_base      		= taskbot_application_access('task');
$tb_post_meta   			= get_post_meta( $linked_profile,'tb_post_meta',true );
$tb_post_meta   			= !empty($tb_post_meta) ? $tb_post_meta : array();
$tagline        			= !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
$address        			= apply_filters( 'taskbot_user_address', $linked_profile );
if(empty($taskbot_order_completed) ){
	$taskbot_order_hired = 0;
}?>
<div class="tb-insightcontainerv2 tb-seller-insights tk-dashboard-left">
	<div class="row">
		<div class="col-lg-4">
			<aside class="tb-tabasidebar">
				<div class="tb-asideholder tb-seller-profile-two">
					<div class="tb-asidebox" id="taskbot-droparea">
						<div id="tb-asideprostatusv2" class="tb-asideprostatusv2">
							<?php if( !empty($avatar) ){?>
								<a id="profile-avatar" href="javascript:void(0);" data-target="#cropimgpopup" data-toggle="modal">
									<figure>
										<img id="user_profile_avatar" src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
									</figure>
								</a>
							<?php } ?>
							<div class="tb-profilebtnarea-wrapper">
								<a id="profile-avatar-btn" class="tb-btn" href="javascript:void(0);"><span class="icon-edit-2"></span><?php esc_html_e('Change avatar','taskbot');?></a>
							</div>
						</div>
						<div class="tb-icondetails">
							<?php if( !empty($user_name) ){?>
								<div class="tb-seller-details">
									<h4>
										<a href="<?php echo esc_url(get_the_permalink($linked_profile));?>"><?php echo esc_html($user_name);?></a>
										<?php do_action( 'taskbot_verification_tag_html', $linked_profile ); ?>
									</h4>
								</div>
							<?php } ?>
							<?php if( !empty($tagline) ){?>
								<h5><?php echo esc_html($tagline);?></h5>
							<?php } ?>
							<ul class="tb-rateviews">
							<?php do_action('taskbot_get_freelancer_rating_cuont', $linked_profile); ?>
								<?php do_action('taskbot_get_freelancer_views', $linked_profile); ?>
							
							</ul>
							<?php do_action( 'taskbot_seller_hourly_rate_html', $linked_profile );?>
							<?php if( !empty($address) ){?>
								<div class="tb-sidebarcontent">
									<div class="tb-sidebarinnertitle">
										<h6><?php esc_html_e('Location:','taskbot');?></h6>
										<h5><?php echo esc_html($address);?></h5>
									</div>
								</div>
							<?php } ?>
							<?php do_action( 'taskbot_texnomies_static_html', $linked_profile,'tb_seller_type',esc_html__('Seller type','taskbot') );?>
							<?php do_action( 'taskbot_texnomies_static_html', $linked_profile,'languages',esc_html__('Languages','taskbot') );?>
							<?php if(!empty($hide_languages ) && $hide_languages == 'no'){ do_action( 'taskbot_texnomies_static_html', $linked_profile,'tb_english_level',esc_html__('English level','taskbot') );}?>
							<div class="tb-profilebtnarea">
								<a href="<?php echo get_the_permalink($linked_profile);?>"  class="tb-btn" ><?php esc_html_e('Public profile preview','taskbot');?></a>
							</div>
						</div>
					</div>
					<?php if( !empty($switch_user) ){?>
						<div class="tb-switchaccount">
							<div class="tb-accouttitle">
								<h5><?php esc_html_e('Login to buyer account','taskbot');?></h5>
								<h6><?php esc_html_e('Switching to Buyer account will take you to your Buyer account where you can hire sellers','taskbot');?></h6>
							</div>
							<div class="tb-btnarea">
								<a href="javascript:void(0);" class="tb-btn btn-orange tb_switch_user" data-id="<?php echo intval($user_identity);?>"><?php esc_html_e('Switch to buyer account','taskbot');?></a>
							</div>
						</div>
					<?php } ?>
				</div>
			</aside>
		</div>
		<?php if( !empty($app_task_base) ){?>
			<div class="col-lg-8">
				<?php taskbot_get_template_part('dashboard/dashboard', 'ongoing-tasks');?>
			</div>
		<?php } else { ?>
			<div class="col-lg-8">
				<?php taskbot_get_template_part('dashboard/post-project/seller/dashboard', 'seller-projects');?>
			</div>
		<?php } ?>
	</div>
</div>
<?php taskbot_get_template_part('profile', 'avatar-popup');
