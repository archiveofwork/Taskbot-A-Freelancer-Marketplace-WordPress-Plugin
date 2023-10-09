<?php

/**
 *  Billing settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

global $current_user, $taskbot_settings, $userdata, $post;

$reference 		 	= !empty($_GET['ref']) ? $_GET['ref'] : '';
$mode 			 	= !empty($_GET['mode']) ? $_GET['mode'] : '';
$user_identity 	 	= intval($current_user->ID);
$user_data_set   = get_userdata($user_identity);
$id 			 	= !empty($args['id']) ? $args['id'] : '';
$user_type		 	= apply_filters('taskbot_get_user_type', $user_identity);
$post_id 		 	= taskbot_get_linked_profile_id($user_identity, '', $user_type);
$billing_first_name	= get_user_meta($user_identity, 'billing_first_name', true);
$billing_last_name	= get_user_meta($user_identity, 'billing_last_name', true);

$billing_company	= get_user_meta($user_identity, 'billing_company', true);
$billing_address_1	= get_user_meta($user_identity, 'billing_address_1', true);
$billing_country	= get_user_meta($user_identity, 'billing_country', true);
$billing_city		= get_user_meta($user_identity, 'billing_city', true);

$billing_state		= get_user_meta($user_identity, 'billing_state', true);
$billing_phone		= get_user_meta($user_identity, 'billing_phone', true);
$billing_postcode	= get_user_meta($user_identity, 'billing_postcode', true);
$billing_email		= get_user_meta($user_identity, 'billing_email', true);
$phone_country		= get_user_meta($user_identity, 'billing_telephone_country', true);

$billing_first_name	= !empty($billing_first_name) ? $billing_first_name : $user_data_set->first_name;
$billing_last_name	= !empty($billing_last_name) ? $billing_last_name : $user_data_set->last_name;

$billing_company	= !empty($billing_company) ? $billing_company : '';
$billing_address_1	= !empty($billing_address_1) ? $billing_address_1 : '';
$billing_country	= !empty($billing_country) ? $billing_country : '';
$billing_city		= !empty($billing_city) ? $billing_city : '';

$billing_state		= !empty($billing_state) ? $billing_state : '';
$billing_phone		= !empty($billing_phone) ? $billing_phone : '';
$billing_postcode	= !empty($billing_postcode) ? $billing_postcode : '';
$phone_country		= !empty($phone_country) ? $phone_country : 'us';
$billing_email		= !empty($billing_email) ? $billing_email : '';

if (class_exists('WooCommerce')) {
	$countries_obj   = new WC_Countries();
	$countries   = $countries_obj->get_allowed_countries('countries');
}

$enable_state			= !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
$state_country_class	= !empty($enable_state) && empty($billing_country) ? 'd-sm-none' : '';

$states					= array();
if (class_exists('WooCommerce')) {
	$countries_obj   	= new WC_Countries();
	$countries   		= $countries_obj->get_allowed_countries('countries');
	if( empty($billing_country) && is_array($countries) && count($countries) == 1 ){
        $billing_country                = array_key_first($countries);
		$state_country_class	= '';
    }
	$states			 	= $countries_obj->get_states( $billing_country );
}

?>
<div class="tb-dhb-profile-settings">
	<div class="tb-dhb-mainheading">
		<h2><?php esc_html_e('Billing information', 'taskbot'); ?></h2>
	</div>
	<div class="tb-dhb-box-wrapper">
		<form class="tb-billing-user-form tb-themeform tb-profileform">
			<fieldset>
				<div class="tb-profileform__holder">
					<div class="tb-profileform__detail tb-billinginfo">
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('First name: ', 'taskbot'); ?></label>
							<input type="text" value="<?php echo esc_attr($billing_first_name); ?>" class="form-control" name="billing[billing_first_name]" placeholder="<?php esc_attr_e('Enter first name', 'taskbot'); ?>" autocomplete="off">
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Last name: ', 'taskbot'); ?></label>
							<input type="text" value="<?php echo esc_attr($billing_last_name); ?>" class="form-control" name="billing[billing_last_name]" placeholder="<?php esc_attr_e('Enter last name', 'taskbot'); ?>" autocomplete="off">
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Company title: ', 'taskbot'); ?></label>
							<input type="text" value="<?php echo esc_attr($billing_company); ?>" class="form-control" name="billing[billing_company]" placeholder="<?php esc_attr_e('Enter your company title', 'taskbot'); ?>" autocomplete="off">
						</div>
						<?php if (class_exists('WooCommerce')) { ?>
							<div class="form-group-half form-group_vertical">
								<label class="form-group-title"><?php esc_html_e('Country: ', 'taskbot'); ?></label>
								<span class="tb-select">
									<select id="billing_country category" name="billing[billing_country]" data-placeholderinput="<?php esc_attr_e('Search country', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose country', 'taskbot'); ?>">
										<option selected hidden disabled value=""><?php esc_html_e('Country', 'taskbot'); ?></option>
										<?php if (!empty($countries)) {
											foreach ($countries as $key => $item) {
												$selected = '';
												if (!empty($billing_country) && $billing_country === $key) {
													$selected = 'selected';
												}
										?>
												<option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
										<?php }
										} ?>
									</select>
								</span>
							</div>
							<?php if (!empty($enable_state)) { ?>
								<div class="form-group-half form-group_vertical tb-state-parent <?php echo esc_attr($state_country_class); ?>">
									<label class="form-group-title"><?php esc_html_e('States', 'taskbot'); ?></label>
									<span class="tb-select tb-select-country">
										<select class="tb-country-state" name="billing[billing_state]" data-placeholderinput="<?php esc_attr_e('Search states', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose states', 'taskbot'); ?>">
											<option selected hidden disabled value=""><?php esc_html_e('States', 'taskbot'); ?></option>
											<?php if (!empty($states)) {
												foreach ($states as $key => $item) {
													$selected = '';
													if (!empty($billing_state) && $billing_state === $key) {
														$selected = 'selected';
													} ?>
													<option class="tb-state-option" <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
											<?php }
											} ?>
										</select>
									</span>
								</div>
						<?php }
						} ?>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('City:', 'taskbot'); ?></label>
							<input type="text" class="form-control" value="<?php echo esc_attr($billing_city); ?>" name="billing[billing_city]" placeholder="<?php esc_attr_e('Enter city', 'taskbot'); ?>" autocomplete="off">
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Address:', 'taskbot'); ?></label>
							<input type="text" class="form-control" value="<?php echo esc_attr($billing_address_1); ?>" name="billing[billing_address_1]" placeholder="<?php esc_attr_e('Enter address', 'taskbot'); ?>" autocomplete="off">
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Postal code:', 'taskbot'); ?></label>
							<input type="text" class="form-control" value="<?php echo esc_attr($billing_postcode); ?>" name="billing[billing_postcode]" placeholder="<?php esc_attr_e('Enter postal code', 'taskbot'); ?>" autocomplete="off">
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Email:', 'taskbot'); ?> </label>
							<input type="text" class="form-control" value="<?php echo esc_attr($billing_email); ?>" name="billing[billing_email]" placeholder="<?php esc_attr_e('Enter email address', 'taskbot'); ?>" autocomplete="off">
						</div>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Phone:', 'taskbot'); ?> </label>
							<input type="text" class="form-control" value="<?php echo esc_attr($billing_phone); ?>" name="billing[billing_phone]" placeholder="<?php esc_attr_e('Enter phone', 'taskbot'); ?>" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="tb-profileform__holder">
					<div class="tb-dhbbtnarea tb-dhbbtnareav2">
						<em><?php esc_html_e('Click “Save &amp; Update” to update the latest changes', 'taskbot'); ?></em>
						<a href="javascript:void(0);" data-id="<?php echo intval($user_identity); ?>" class="tb-btn tb_update-billing"><?php esc_html_e('Update settings', 'taskbot'); ?></a>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>