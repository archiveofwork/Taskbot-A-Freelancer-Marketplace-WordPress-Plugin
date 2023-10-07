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

$reference 		 = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? intval($args['id']) : '';
$user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID);
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
$hide_english_level       = !empty($taskbot_settings['hide_english_level']) ? $taskbot_settings['hide_english_level'] : 'no';
$hide_skills       	  = !empty($taskbot_settings['hide_skills']) ? $taskbot_settings['hide_skills'] : 'no';
$hide_languages       = !empty($taskbot_settings['hide_languages']) ? $taskbot_settings['hide_languages'] : 'no';

$seller_type_term	= wp_get_object_terms($profile_id, 'tb_seller_type');
$seller_type		= !empty($seller_type_term) ? $seller_type_term : array();
$english_level_term	= wp_get_object_terms($profile_id, 'tb_english_level');
$english_level		= !empty($english_level_term) ? $english_level_term : array();
$first_name			= !empty($first_name) ? $first_name : '';
$last_name			= !empty($last_name) ? $last_name : '';
$hourly_rate		= get_post_meta($profile_id, 'tb_hourly_rate', true);
$hourly_rate		= !empty($hourly_rate) ? $hourly_rate : '';
$countries			= array();
$selected_skills	= !empty($profile_id) ? wp_get_post_terms( $profile_id, 'skills', array('fields' =>'ids') ) : array();
$selected_languages = !empty($profile_id) ? wp_get_post_terms( $profile_id, 'languages', array('fields' =>'ids') ) : array();

$states					= array();
$state					= get_post_meta($profile_id, 'state', true);
$state					= !empty($state) ? $state : '';
$enable_state			= !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
$state_country_class	= !empty($enable_state) && empty($country) ? 'd-sm-none' : '';
if (class_exists('WooCommerce')) {
	$countries_obj   	= new WC_Countries();
	$countries   		= $countries_obj->get_allowed_countries('countries');
	if( empty($country) && is_array($countries) && count($countries) == 1 ){
        $country                = array_key_first($countries);
		$state_country_class	= '';
    }
	$states			 	= $countries_obj->get_states( $country );
}

$country_class = "form-group";
if(!empty($taskbot_settings['enable_zipcode']) ){
	$country_class = "form-group-half";
}


/* getting seller types */
$seller_type_data         = taskbot_get_term_dropdown('tb_seller_type', false, 0, false);
/* getting seller types */
$english_level_data       = taskbot_get_term_dropdown('tb_english_level', false, 0, false);
?>
<div class="tb-dhb-profile-settings">
	<div class="tb-dhb-mainheading">
		<h2><?php esc_html_e('Profile settings', 'taskbot'); ?></h2>
	</div>
	<div class="tb-dhb-box-wrapper">
		<div class="tb-tabtasktitle">
			<h5><?php esc_html_e('Personal details', 'taskbot'); ?></h5>
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
								<select id="tb-country" class="tb-country" name="country" data-placeholderinput="<?php esc_attr_e('Search country', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose country', 'taskbot'); ?>">
									<option selected hidden disabled value=""><?php esc_html_e('Country', 'taskbot'); ?></option>
									<?php if (!empty($countries)) {
										foreach ($countries as $key => $item) {
											$selected = '';
											
											if (!empty($country) && $country === $key) {
												$selected = 'selected';
											}?>
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
												<option class="tb-state-option" <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
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
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Seller type', 'taskbot'); ?></label>
							<span class="tb-select">
								<select id="seller_type" name="seller_type" data-placeholderinput="<?php esc_attr_e('Search seller type', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose seller type', 'taskbot'); ?>">
									<option selected hidden disabled><?php esc_html_e('Seller type', 'taskbot'); ?></option>
									<?php if (is_array($seller_type_data) && !empty($seller_type_data)) {
										foreach ($seller_type_data as $item) {
											$selected = (isset($item->term_id) && ($item->term_id == $seller_type[0]->term_id)) ? 'selected' : '';
											?>
											<option value="<?php echo esc_attr($item->term_id); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($item->name); ?></option>
									<?php }
									} ?>
								</select>
							</span>
						</div>
						<?php if(!empty($hide_english_level ) && $hide_english_level == 'no'){?>
							<div class="form-group-half form-group_vertical">
								<label class="form-group-title"><?php esc_html_e('English level', 'taskbot'); ?></label>
								<span class="tb-select">
									<select id="english_level" name="english_level" data-placeholderinput="<?php esc_html_e('Search English level', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose English level', 'taskbot'); ?>">
										<option selected hidden disabled value=""><?php esc_html_e('English level', 'taskbot'); ?></option>
										<?php if (is_array($english_level_data) && !empty($english_level_data)) {
										$eng_level_term_id = isset($english_level[0]->term_id) ? $english_level[0]->term_id : '';
											foreach ($english_level_data as $item) {
												$selected = (isset($item->term_id) && ($item->term_id == $eng_level_term_id)) ? 'selected' : '';
												?>
												<option value="<?php echo esc_attr($item->term_id); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($item->name); ?></option>
										<?php }
										} ?>
									</select>
								</span>
							</div>
						<?php } ?>
						<?php if(!empty($hide_skills ) && $hide_skills == 'no'){?>
							<div class="form-group form-group_vertical">
								<label class="tk-label"><?php esc_html_e('Skills','taskbot');?></label>
								<div class="tk-select"> 
									<?php 
										$skills_args = array(
											'class'         => 'tb-select2-cat tb-select2-skills',
											'taxonomy'      => 'skills',
											'value_field'   => 'term_id',
											'orderby'       => 'name',
											'name'          => 'skills[]',
											'selected'      => $selected_skills,
										);
										do_action('taskbot_custom_taxonomy_dropdown', $skills_args);
									?>
								</div>
							</div>
						<?php } ?>
						<?php if(!empty($hide_languages ) && $hide_languages == 'no'){?>
							<div class="form-group form-group_vertical">
								<label class="tk-label"><?php esc_html_e('languages','taskbot');?></label>
								<div class="tk-select"> 
									<?php 
										$languages_args = array(
											'class'         => 'tb-select2-languages',
											'taxonomy'      => 'languages',
											'value_field'   => 'term_id',
											'orderby'       => 'name',
											'name'          => 'languages[]',
											'selected'      => $selected_languages,
										);
										do_action('taskbot_custom_taxonomy_dropdown', $languages_args);
									?>
								</div>
							</div>
						<?php } ?>
						<div class="form-group-half form-group_vertical">
							<label class="form-group-title"><?php esc_html_e('Hourly rate', 'taskbot'); ?></label>
							<input type="number" class="form-control" name="hourly_rate" placeholder="<?php esc_attr_e('Enter hourly rate', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($hourly_rate); ?>">
						</div>
						<?php do_action('taskbot_add_seller_profile_fields', $profile_id); ?>
					</div>
				</div>
				<div class="tb-profileform__holder">
					<div class="tb-dhbbtnarea tb-dhbbtnareav2">
						<em><?php esc_html_e('Click “Save & Update” to update the latest changes', 'taskbot'); ?></em>
						<a href="javascript:void(0);" data-id="<?php echo intval($user_identity); ?>" class="tb-btn tb_profile_settings"><?php esc_html_e('Save & Update', 'taskbot'); ?></a>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<?php
$scripts	= "
jQuery(document).ready(function($){
    'use strict';
	// Make category drop-down select2 
    jQuery('.tb-select2-languages').select2({
        allowClear: true,
        multiple: true,
    });
    if ( $.isFunction($.fn.select2) ) {
        jQuery('.tb-select2-languages').select2({
            multiple: true,
            placeholder: scripts_vars.languages_option
        });
    }
    jQuery('.tb-select2-languages').trigger('change');
    jQuery('.tb-select2-skills').select2({
        allowClear: true,
        multiple: true,
    });
    if ( $.isFunction($.fn.select2) ) {
        jQuery('.tb-select2-skills').select2({
            multiple: true,
            placeholder: scripts_vars.skills_option
        });
    }
    jQuery('.tb-select2-skills').trigger('change');

    });";
    wp_add_inline_script('taskbot', $scripts, 'after');