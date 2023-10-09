<?php
/**
 * Dashboard Notifications
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user;
$user_id 	 				= intval($current_user->ID);
$user_verification			= get_user_meta( $user_id, 'user_verification', true );
$identity_verified			= !empty($user_verification) ? $user_verification : '';

$verification_attachments  	= get_user_meta($user_id, 'verification_attachments', true);
$verification_attachments	= !empty($verification_attachments) ? $verification_attachments : array();

$identity_verified  	= get_user_meta($user_id, 'identity_verified', true);
$identity_verified		= !empty($identity_verified) ? $identity_verified : 0;
?>
<div class="tb-dhb-profile-settings">
	<div class="tb-dhb-mainheading">
		<h2><?php esc_html_e('Upload Identity Information', 'taskbot'); ?></h2>
	</div>
	
	<?php if(empty($identity_verified) && !empty($verification_attachments) ){?>
		<div class="tb-refunddetailswrap tb-alert-information">
			<div class="tb-orderrequest">
				<div class="tb-ordertitle">
					<h5><?php esc_html_e('Woohoo!', 'taskbot'); ?></h5>
					<p><?php esc_html_e('You have successfully submitted your documents. buckle up, we will verify and respond to your request very soon', 'taskbot'); ?></p>
				</div>
				<div class="tb-orderbtn">
					<a class="tb-btn btn-orange tb-cancel-identity" href="javascript:;"><?php esc_html_e("Cancel & Re-Upload", 'taskbot'); ?></a>
				</div>
			</div>
		</div>
	<?php }else if(!empty($identity_verified) && $identity_verified === '1'){?>
		<div class="tb-orderrequest tb-alert-success">
			<div class="tb-ordertitle">
				<h5><?php esc_html_e('Hurray!', 'taskbot'); ?></h5>
				<p><?php esc_html_e('We have successfully completed your identity verification. you’re now ready to use site features', 'taskbot');?></p>
			</div>
		</div>
	<?php }else{?>
		<div class="tb-dhb-box-wrapper">
			<div class="tb-tabtasktitle">
				<h5><?php esc_html_e('Upload identity documents', 'taskbot'); ?></h5>
			</div>
			<form class="tb-themeform tb-profileform" id="tb_identity_settings">
				<fieldset>
					<div class="tb-profileform__holder">
						<div class="tb-profileform__detail tb-billinginfo">
							<div class="form-group-half form-group_vertical">
								<label class="form-group-title"><?php esc_html_e('Your name:', 'taskbot'); ?></label>
								<input type="text" value="" name="name" class="form-control" placeholder="<?php esc_attr_e('Your name', 'taskbot'); ?>">
							</div>
							<div class="form-group-half form-group_vertical">
								<label class="form-group-title"><?php esc_html_e('Contact number:', 'taskbot'); ?></label>
								<input type="text" value="" name="contact_number" class="form-control" placeholder="<?php esc_attr_e('Contact number', 'taskbot'); ?>">
							</div>
							<div class="form-group form-group_vertical">
								<label class="form-group-title"><?php esc_html_e('National identity card, passport or driving license number:', 'taskbot'); ?></label>
								<input type="text" value="" name="verification_number" class="form-control" placeholder="<?php esc_attr_e('National identity card, passport or driving license number', 'taskbot'); ?>">
							</div>
							<div class="form-group form-group_vertical">
								<label class="form-group-title"><?php esc_html_e('Add address:', 'taskbot'); ?></label>
								<textarea class="form-control" name="address" placeholder="<?php esc_attr_e('Add address', 'taskbot'); ?>"></textarea>
							</div>
							<div class="form-group">
								<div id="taskbot-upload-verification" class="taskbot-fileuploader tb-uploadarea">
									<div class="tb-uploadbox taskbot-dragdroparea" id="taskbot-verification-droparea">
										<svg>
											<rect width="100%" height="100%"/>
										</svg>
										<i class="tb-icon-upload"></i>
										<em>
											<?php echo wp_sprintf( '%1$s <br/> %2$s', esc_html__( 'You can upload media file format only.', 'taskbot'), esc_html__( 'make sure your file size does not exceed 15mb.', 'taskbot') );?>
											<label for="file1">
												<span id="taskbot-verification-btn">
													<input id="file1" type="file" name="file">
													<?php esc_html_e('Click here to upload', 'taskbot');?>
												</span>
											</label>
										</em>
									</div>
									<ul class="tb-uploadbar tb-bars taskbot-fileprocessing" id="taskbot-fileprocessing"></ul>
								</div>
							</div>
						</div>
					</div>
					<div class="tb-profileform__holder">
						<div class="tb-dhbbtnarea tb-dhbbtnareav2">
							<em><?php esc_html_e('Click “Save & Update” to update the latest changes', 'taskbot'); ?></em>
							<a href="javascript:void(0);" data-id="<?php echo intval($user_id); ?>" class="tb-btn tb_profile_verification"><?php esc_html_e('Save & Update', 'taskbot'); ?></a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	<?php } ?>
	
</div>
<script type="text/template" id="tmpl-load-verification-attachments">
	<li id="thumb-{{data.id}}" class="taskbot-list tb-uploading">
		<div class="tb-filedesciption">
			<span>{{data.name}}</span>
			<input type="hidden" class="attachment_url" name="attachments[{{data.attachment_id}}]" value="{{data.url}}">
			<em class="tb-remove"><a href="javascript:void(0)" class="taskbot-remove-attachment tb-remove-attachment"><?php esc_html_e('remove', 'taskbot');?></a></em>
		</div>
		<div class="progress">
			<div class="progress-bar uploadprogressbar" style="width:0%"></div>
		</div>
	</li>
</script>
