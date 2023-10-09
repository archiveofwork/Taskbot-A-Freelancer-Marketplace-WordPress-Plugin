<?php

/**
 * Profile settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

global $current_user, $taskbot_settings, $userdata, $post;

$reference 		 = !empty($_GET['ref']) ? $_GET['ref'] : '';
$mode 			 = !empty($_GET['mode']) ? $_GET['mode'] : '';
$user_identity 	 = intval($current_user->ID);
$user_data_set   = get_userdata($user_identity);
$id 			 = !empty($args['id']) ? $args['id'] : '';
$user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID);
$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);
$user_name		= taskbot_get_username($linked_profile);
$profile_id      = taskbot_get_linked_profile_id($user_identity, '', $user_type);
$tb_post_meta   = get_post_meta($profile_id, 'tb_post_meta', true);
$tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();
$country		= get_post_meta($profile_id, 'country', true);
$zipcode		= get_post_meta($profile_id, 'zipcode', true);
$country		= !empty($country) ? $country : '';
$zipcode		= !empty($zipcode) ? $zipcode : '';
$tag_line		= !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
$first_name		= !empty($tb_post_meta['first_name']) ? $tb_post_meta['first_name'] : '';
$last_name		= !empty($tb_post_meta['last_name']) ? $tb_post_meta['last_name'] : '';
$description	= !empty($tb_post_meta['description']) ? $tb_post_meta['description'] : '';

$first_name			= !empty($first_name) ? $first_name : $user_data_set->first_name;
$last_name			= !empty($last_name) ? $last_name : $user_data_set->last_name;
$countries			= array();

$states					= array();
$state					= get_post_meta($profile_id, 'state', true);
$state					= !empty($state) ? $state : '';
$enable_state			= !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
$state_country_class	= !empty($enable_state) && empty($country) ? 'd-sm-none' : '';
if (class_exists('WooCommerce')) {
	$countries_obj   = new WC_Countries();
	$countries  	 = $countries_obj->get_allowed_countries('countries');
	if( empty($country) && is_array($countries) && count($countries) == 1 ){
        $country                = array_key_first($countries);
		$state_country_class	= '';
    }
	$states			 = $countries_obj->get_states( $country );
}

$country_class = "form-group";
if(!empty($taskbot_settings['enable_zipcode']) ){
	$country_class = "form-group-half";
}

$width			= 300;
$height			= 300;
$avatar	= apply_filters(
    'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => $width, 'height' => $height), $linked_profile), array('width' => $width, 'height' => $height)
);

?>
<div class="tb-dhb-profile-settings">
	<div class="tb-dhb-mainheading">
		<h2><?php esc_html_e('Profile settings', 'taskbot'); ?></h2>
	</div>
	<div class="tb-dhb-box-wrapper">
        <!--Profile Image-->
        <div class="tb-asidebox tb-profile-area-wrapper" id="taskbot-droparea">
            <div id="tb-asideprostatusv2" class="tb-asideprostatusv2">
                <?php if( !empty($avatar) ){?>
                    <a id="profile-avatar" href="javascript:void(0);" data-target="#cropimgpopup" data-toggle="modal">
                        <figure>
                            <img id="user_profile_avatar" src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
                        </figure>
                    </a>
                <?php } ?>
                <div class="tb-profile-content-area">
                    <h4 class="tb-profile-content-title"><?php esc_html_e('Upload profile photo'); ?></h4>
                    <p class="tb-profile-content-desc"><?php esc_html_e('Profile image should have jpg, jpeg, gif, png extension and size should not be more than 5MB'); ?></p>
                    <div class="tb-profilebtnarea-wrapper">
                        <a id="profile-avatar-btn" class="tb-btn" href="javascript:void(0);"><?php esc_html_e('Upload Photo','taskbot');?></a>
                    </div>
                </div>
            </div>
        </div>
		<form class="tb-themeform tb-profileform" id="tb_save_settings">
			<fieldset>
				<div class="tb-profileform__holder">
					<div class="tb-profileform__detail tb-billinginfo">
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('First name:', 'taskbot'); ?></label>
							<input type="text" class="form-control" name="first_name" placeholder="<?php esc_attr_e('Enter first name', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($first_name); ?>">
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Last name:', 'taskbot'); ?></label>
							<input type="text" class="form-control" name="last_name" placeholder="<?php esc_attr_e('Enter last name', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($last_name); ?>">
						</div>
						<div class="form-group form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Your tagline:', 'taskbot'); ?></label>
							<input type="text" class="form-control" name="tagline" placeholder="<?php esc_attr_e('Add tagline', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($tag_line); ?>">
						</div>
						<div class="form-group form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Description:', 'taskbot'); ?></label>
							<textarea class="form-control" name="description" placeholder="<?php esc_attr_e('Add description', 'taskbot'); ?>"><?php echo do_shortcode($description); ?></textarea>
						</div>
						<div class="<?php echo esc_attr($country_class);?> form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Country', 'taskbot'); ?></label>
							<span class="tb-select tb-select-country">
								<select id="tb-category" name="country" data-placeholderinput="<?php esc_attr_e('Search country', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose country', 'taskbot'); ?>">
									<option selected hidden disabled value=""><?php esc_html_e('Country', 'taskbot'); ?></option>
									<?php if (!empty($countries)) {
										foreach ($countries as $key => $item) {
											$selected = '';
											if (!empty($country) && $country === $key) {
												$selected = 'selected';
											} ?>
											<option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
									<?php }
									} ?>
								</select>
							</span>
						</div>
						<?php if( !empty($enable_state) ){?>
							<div class="form-group-half form-group_vertical tb-state-parent <?php echo esc_attr($state_country_class);?>">
								<label class="form-group-title"><?php esc_html_e('States', 'taskbot'); ?></label>
								<span class="tb-select tb-select-country">
									<select class="tb-country-state" name="state" data-placeholderinput="<?php esc_attr_e('Search states', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose states', 'taskbot'); ?>">
										<option selected hidden disabled value=""><?php esc_html_e('States', 'taskbot'); ?></option>
										<?php if (!empty($states)) {
											foreach ($states as $key => $item) {
												$selected = '';
												if (!empty($state) && $state === $key) {
													$selected = 'selected';
												} ?>
												<option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
										<?php }
										} ?>
									</select>
								</span>
							</div>	
						<?php } ?>
						<?php if(!empty($taskbot_settings['enable_zipcode']) ){?>
							<div class="form-group-half form-group_vertical">
								<label class="form-group-title"><?php esc_html_e('Zip code:', 'taskbot'); ?></label>
								<input type="text" class="form-control" name="zipcode" placeholder="<?php esc_attr_e('Add zip code', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($zipcode); ?>">
							</div>	
						<?php } ?>	
									
					</div>
				</div>
				<div class="tb-profileform__holder">
					<div class="tb-dhbbtnarea tb-dhbbtnareav2">
						<em><?php esc_html_e('Click “Save & Update” to update the latest changes', 'taskbot'); ?></em>
						<a href="javascript:void(0);" data-id="<?php echo intval($user_identity); ?>" class="tb-btn tb_buyer_settings"><?php esc_html_e('Save & Update', 'taskbot'); ?></a>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<?php taskbot_get_template_part('profile', 'avatar-popup');