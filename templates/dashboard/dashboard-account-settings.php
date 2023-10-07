<?php
/**
 *  Account settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $taskbot_settings, $userdata, $post;

$reference 		  	= !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode 			    = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 		= intval($current_user->ID);
$id 			    = !empty($args['id']) ? intval($args['id']) : '';
$user_type		  	= apply_filters('taskbot_get_user_type', $user_identity );
$linked_profile 	= '';
$user_type		  	= apply_filters('taskbot_get_user_type', $current_user->ID );
$login_type     	= get_user_meta( $user_identity, 'login_type', true );
$login_type     	= !empty($login_type) ? $login_type : '';
if( function_exists('taskbot_get_account_settings') ){
	$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);
}

$settings		 = array();

if( function_exists('taskbot_get_account_settings') ){
	$settings		 = taskbot_get_account_settings($user_type);
}

$remove_account_reasons	= !empty($taskbot_settings['remove_account_reasons']) ? $taskbot_settings['remove_account_reasons'] : array();
?>
<div class="tb-dhb-account-settings">
	<div class="tb-dhb-mainheading">
		<h2><?php esc_html_e('Account Settings','taskbot');?></h2>
	</div>
	<?php if( empty($login_type) ){ ?>
	<div class="tb-profile-settings-box tb-chnage-password-wrapper">
		<div class="tb-tabtasktitle">
			<h5><?php esc_html_e('Change password','taskbot');?></h5>
		</div>
		<div class="tb-dhb-box-wrapper">
			<div class="tb-themeform tb-profileform">
				<form id="tb_cp_form">
					<div class="tb-profileform__holder">
						<div class="tb-profileform__detail">
							<div class="tb-profileform__content">
								<label class="tb-titleinput"><?php esc_html_e('Current password:','taskbot');?></label>
								<input type="password" name="password" class="form-control" placeholder="<?php esc_attr_e('Enter password*','taskbot');?>">
							</div>
							<div class="tb-profileform__content">
								<label class="tb-titleinput"><?php esc_html_e('New password:','taskbot');?></label>
								<input type="password" name="new_password" class="form-control" placeholder="<?php esc_attr_e('Enter new password*','taskbot');?>">
							</div>
							<div class="tb-profileform__content">
								<label class="tb-titleinput"><?php esc_html_e('Retype password:','taskbot');?></label>
								<input type="password" name="retype_password" class="form-control" placeholder="<?php esc_attr_e('Retype Password:','taskbot');?>">
							</div>
						</div>
					</div>
					<div class="tb-profileform__holder">
						<div class="tb-dhbbtnarea tb-dhbbtnareav2">
							<em><?php esc_html_e('Click “update now” to update latest changes made by you','taskbot');?></em>
							<a href="javascript:void(0);" data-id="<?php echo intval($user_identity);?>" id="tb_change_password" class="tb-btn"><?php esc_html_e('Update now ','taskbot');?></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<div class="tb-profile-settings-box tb-privacy-wrapper">
	<?php if( !empty($settings) ){?>
		<div class="tb-tabtasktitle">
			<h5><?php esc_html_e('Privacy &amp; notification','taskbot');?></h5>
		</div>
		<div class="tb-dhb-box-wrapper">
			<form id="tb_privacy_form">
				<div class="tb-profileform__holder">
					<div class="tb-profileform__detail">
						<?php foreach( $settings as $key => $value ){
							$db_val 	= get_post_meta($linked_profile, $key, true);
							$db_val 	= !empty( $db_val ) ?  $db_val : 'off';
							?>
							<div class="tb-profileform__content tb-formcheckbox">
								<label class="tb-titleinput"><?php echo esc_html( $value );?></label>
								<div class="tb-onoff">
									<input type="hidden" name="settings[<?php echo esc_attr($key); ?>]" value="off">
									<input type="checkbox" <?php checked( $db_val, 'on' ); ?>  value="on" id="<?php echo esc_attr( $key );?>" name="settings[<?php echo esc_attr( $key );?>]">
									<label for="<?php echo esc_attr( $key );?>"><em><i></i></em><span class="tb-enable"><?php esc_html_e('Enabled','taskbot');?></span><span class="tb-disable"><?php esc_html_e('Disabled','taskbot');?></span></label>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
				<div class="tb-profileform__holder">
					<div class="tb-dhbbtnarea tb-dhbbtnareav2">
						<em><?php esc_html_e('Click “update now” to update latest changes made by you','taskbot');?></em>
						<a href="javascript:void(0);" data-id="<?php echo intval($user_identity);?>" id="tb_update_profile" class="tb-btn"><?php esc_html_e('Update now','taskbot');?> </a>
					</div>
				</div>
			</form>
		</div>
	<?php } ?>
</div>
<div class="tb-profile-settings-box tb-deactivate-wrapper">
	<?php if( !empty($remove_account_reasons) ){?>
		<div class="tb-tabtasktitle">
			<h5><?php esc_html_e('Deactivate account','taskbot');?></h5>
		</div>
		<div class="tb-dhb-box-wrapper">
			<form id="tb_deactive_form">
				<div class="tb-profileform__holder">
					<div class="tb-profileform__detail">
						<div class="tb-profileform__content">
							<label class="tb-titleinput"><?php esc_html_e('Choose reason:','taskbot');?></label>
							<div class="tb-select">
								<select name="reason" id="tb-selection2" class="form-control">
									<option value="select_option"><?php esc_html_e('Why you want to leave?','taskbot');?></option>
									<?php foreach($remove_account_reasons as $remove_account_reasons){
										$key =  !empty($remove_account_reasons) ? sanitize_title($remove_account_reasons) : '';?>
										<option value="<?php echo esc_attr($remove_account_reasons);?> "><?php echo esc_html($remove_account_reasons);?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="tb-profileform__content">
							<label class="tb-titleinput"><?php esc_html_e('Add description:','taskbot');?></label>
							<textarea class="form-control" name="details" placeholder="<?php esc_attr_e('Description','taskbot');?>"></textarea>
						</div>
					</div>
				</div>
				<div class="tb-profileform__holder">
					<div class="tb-dhbbtnarea tb-dhbbtnareav2">
						<em><?php esc_html_e('Click “deactivate now” to disable your account permanently','taskbot');?></em>
						<a href="javascript:void(0);" data-id="<?php echo intval($user_identity);?>" id="tb_deactive_profile" class="tb-btn tb-deactivate"><?php esc_html_e('Deactivate now','taskbot');?></a>
					</div>
				</div>
			</form>
		</div>
	<?php } ?>
</div>
	