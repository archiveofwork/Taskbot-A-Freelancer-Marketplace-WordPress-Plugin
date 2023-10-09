<?php
/**
 * Account settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user, $taskbot_settings;
$reference 		 = !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? intval($args['id']) : '';
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );

$identity_verification	= !empty($taskbot_settings['identity_verification']) ? $taskbot_settings['identity_verification'] : false;
?>
<div class="tb-settings-page-wrap">
	<div class="row">
		<div class="col-lg-4 col-xl-3">
			<aside>
				<div class="tb-asideholder">
					<div class="tb-asidebox tb-settingtabholder">
						<ul class="tb-settingtab">
							<li class="<?php echo esc_attr( $reference == 'dashboard' && $mode == 'profile' ? 'active' : '' );?>"><a href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'profile'));?>"><i class="tb-icon-user"></i><?php esc_html_e('Profile settings','taskbot');?></a></li>
							<?php if( !empty($identity_verification) ){?>
								<li class="<?php echo esc_attr( $reference == 'dashboard' && $mode == 'verification' ? 'active' : '' );?>"><a href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'verification'));?>"><i class="tb-icon-check-square"></i><?php esc_html_e('Identity verification','taskbot');?></a></li>
							<?php } ?>
							<li class="<?php echo esc_attr( $reference == 'dashboard' && $mode == 'billing' ? 'active' : '' );?>"><a href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'billing'));?>"><i class="tb-icon-credit-card"></i><?php esc_html_e('Billing information','taskbot');?></a></li>
							<li class="<?php echo esc_attr( $reference == 'dashboard' && $mode == 'account' ? 'active' : '' );?>"><a href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'account'));?>"><i class="tb-icon-settings"></i><?php esc_html_e('Account settings','taskbot');?></a></li>
						</ul>
					</div>
				</div>
			</aside>
		</div>
		<div class="col-lg-8 col-xl-9">
			<?php if ( !empty($reference) && !empty($mode) && $reference == 'dashboard' && $mode == 'billing') {
				taskbot_get_template_part('dashboard/dashboard', 'billing-settings');
			} else if ( !empty($reference) && !empty($mode) && $reference === 'dashboard' && $mode === 'profile') {
				
				if( !empty($user_type) && $user_type == 'sellers' ){
					taskbot_get_template_part('dashboard/dashboard', 'profile-settings');
					taskbot_get_template_part('dashboard/dashboard', 'education');
				} else {
					taskbot_get_template_part('dashboard/dashboard', 'buyer-setting');
				}

			} else if ( !empty($reference) && !empty($mode) && $reference === 'dashboard' && $mode === 'account') { 
				taskbot_get_template_part('dashboard/dashboard', 'account-settings');
			} else if ( !empty($reference) && !empty($mode) && $reference === 'dashboard' && $mode === 'verification') { 
				taskbot_get_template_part('dashboard/dashboard', 'identity-verification');
			} ?>
		</div>
	</div>
</div>