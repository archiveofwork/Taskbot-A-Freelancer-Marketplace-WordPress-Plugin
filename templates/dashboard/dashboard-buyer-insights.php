<?php
/**
 *  Buyer ongoing tasks
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/


global $current_user, $taskbot_settings;

$reference 		  	= !empty($_GET['ref'] ) ? $_GET['ref'] : '';
$mode 			    = !empty($_GET['mode']) ? $_GET['mode'] : '';
$user_identity 		= intval($current_user->ID);
$user_type		  	= apply_filters('taskbot_get_user_type', $user_identity );
$linked_profile 	= taskbot_get_linked_profile_id($user_identity,'',$user_type);
$user_name		  	= taskbot_get_username($linked_profile);
$profile_link	  	= get_the_permalink( $linked_profile );
$app_task_base      = taskbot_application_access('task');
$switch_user    	= !empty($taskbot_settings['switch_user']) ? $taskbot_settings['switch_user'] : false;
$tb_post_meta   	= get_post_meta( $linked_profile,'tb_post_meta',true );
$tb_post_meta   	= !empty($tb_post_meta) ? $tb_post_meta : array();
$tagline        	= !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
$address        	= apply_filters( 'taskbot_user_address', $linked_profile );
$width			= 150;
$height			= 150;
$avatar	= apply_filters(
	'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => $width, 'height' => $height), $linked_profile), array('width' => $width, 'height' => $height)
); ?>
<div class="tb-insightcontainerv2 tb-buyer-insights">
	<div class="row">
		<div class="col-lg-4">
			<aside class="tb-tabasidebar">
				<div class="tb-asideholder tb-seller-profile-two">
					<div class="tb-asidebox" id="taskbot-droparea">
						<div id="tb-asideprostatusv2" class="tb-asideprostatusv2">
							<?php if( !empty($avatar) ){?>
								<a href="javascript:void(0);" id="profile-avatar" data-target="#cropimgpopup" data-toggle="modal">
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
										<a><?php echo esc_html($user_name);?></a>
										<?php do_action( 'taskbot_verification_tag_html', $linked_profile ); ?>
									</h4>
								</div>
							<?php } ?>
							<?php if( !empty($tagline) ){?>
								<h5><?php echo esc_html($tagline);?></h5>
							<?php } ?>
							<?php if( !empty($address) ){?>
								<div class="tb-sidebarcontent">
									<div class="tb-sidebarinnertitle">
										<h6><?php esc_html_e('Location:','taskbot');?></h6>
										<h5><?php echo esc_html($address);?></h5>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php if( !empty($switch_user) ){?>
						<div class="tb-switchaccount tb-buyeraccount">
							<div class="tb-accouttitle">
								<h5><?php esc_html_e('Switch account','taskbot');?></h5>
								<h6><?php esc_html_e('Switching to seller account will take you to your seller account','taskbot');?></h6>
							</div>
							<div class="tb-btnarea">
								<a href="javascript:void(0);" class="tb-btn btn-purple tb_switch_user" data-id="<?php echo intval($user_identity);?>"><?php esc_html_e('Switch to seller account','taskbot');?></a>
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
		<?php } else {?>
			<div class="col-lg-8">
				<?php taskbot_get_template_part('dashboard/post-project/buyer/dashboard', 'buyer-projects');?>
			</div>
		<?php } ?>
	</div>
</div>
<?php taskbot_get_template_part('profile', 'avatar-popup');
