<?php
/**
 *  Task introduction
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/post_services
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $taskbot_settings;
if ( !class_exists('WooCommerce') ) {
	return;
}

$hide_product_cat   = !empty($taskbot_settings['hide_product_cat']) ? $taskbot_settings['hide_product_cat'] : array();

$countries  = array();

$states				    = array();
$state				    = get_post_meta( $post_id, 'state',true );
$enable_state		    = !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
$state_country_class	= !empty($enable_state) && empty($billing_country) ? 'd-sm-none' : '';
if (class_exists('WooCommerce')) {
	$countries_obj   	= new WC_Countries();
	$countries   		= $countries_obj->get_allowed_countries('countries');
    $country            = !empty($billing_country) ? $billing_country : '';
    if( empty($country) && is_array($countries) && count($countries) === 1 ){
        $country                = array_key_first($countries);
        $billing_country        = $country;
        $state_country_class    = '';
    }
	$states			 	= $countries_obj->get_states( $country );
}
$current_page_url   = get_the_permalink();
if(isset($_GET['post']) && !empty($_GET['post'])){
    $post_id = intval($_GET['post']);
    $current_page_url   = add_query_arg('post', $post_id, $current_page_url);
}

if(isset($_GET['step']) && !empty($_GET['step'])){
    $step = intval($_GET['step']);
    $current_page_url   = add_query_arg('step', $step, $current_page_url);
}

$country_class = "form-group-half";

?>
<div id="service-introduction-wrapper">
    <form id="service-introduction-form" class="tb-themeform" action="<?php echo esc_url($current_page_url);?>" method="post" novalidate enctype="multipart/form-data">
        <fieldset>
            <?php do_action('taskbot_service_before_title', $args); ?>
            <div class="form-group form-group_vertical">
                <label class="form-group-title"><?php esc_html_e('Add task title:', 'taskbot'); ?></label>
                <input type="text" value="<?php echo esc_attr($service_title); ?>" class="form-control" name="taskbot_service[post_title]" placeholder="<?php esc_attr_e('Enter your task title', 'taskbot'); ?>" autocomplete="off" required="required">
            </div>
            <div class="form-group form-group-3half form-group_vertical" id="tb-task-category-level1">
                <label class="form-group-title"><?php esc_html_e('Choose category:', 'taskbot'); ?></label>
                <span class="tb-select">
                    <?php 
						$taskbot_args = array(
							'show_option_none'  => esc_html__('Choose category', 'taskbot'),
							'option_none_value' => '',
							'show_count'    => false,
							'hide_empty'    => false,
							'name'          => 'taskbot_service[category]',
							'class'         => 'service-dropdwon tb-top-service',
							'taxonomy'      => 'product_cat',
							'id'            => 'tb-top-service',
							'value_field'   => 'term_id',
							'orderby'       => 'name',
							'selected'      => $service_cat,
							'hide_if_empty' => false,
							'echo'          => true,
							'required'      => false,
							'parent'        => 0,

						);
                        if( !empty($hide_product_cat) ){
                            $taskbot_args['exclude']    = $hide_product_cat;
                        }
						do_action('taskbot_taxonomy_dropdown', $taskbot_args);
                    ?>
                </span>
            </div>

            <div class="form-group form-group-3half form-group_vertical" id="tb_sub_category">
                <?php if (!empty($sub_cat)) { do_action('taskbot_get_terms', $service_cat, $sub_cat); } ?>
            </div>
            <div class="form-group form-group-3half form-group_vertical" id="tb_category_level3" data-type="task">
                <?php if (!empty($sub_cat2)) {do_action('taskbot_get_terms_subcategories', $sub_cat, $sub_cat2);} ?>
            </div>
            <div class="<?php echo esc_attr($country_class);?> form-group_vertical">
                <label class="form-group-title"><?php esc_html_e('Country', 'taskbot'); ?>:</label>
                <span class="tb-select">
                    <select id="tb_country" name="taskbot_service[locations]" data-placeholderinput="<?php esc_attr_e('Search country', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose country', 'taskbot'); ?>" >
                        <option value="" selected hidden disabled><?php esc_html_e('Choose country', 'taskbot'); ?></option>
                        <?php if (!empty($countries)) {
                            foreach ($countries as $key => $item) {
                                $selected = '';
                                
                                if (!empty($billing_country) && $billing_country === $key) {
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
                        <select class="tb-country-state" name="taskbot_service[state]" data-placeholderinput="<?php esc_attr_e('Search states', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose states', 'taskbot'); ?>">
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
                    <label class="form-group-title"><?php esc_html_e('Zipcode', 'taskbot'); ?>:</label>
                    <input type="text" class="form-control" name="zipcode" placeholder="<?php esc_attr_e('Enter zipcode', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($zipcode);?>">
                </div>
            <?php } ?>
            <div class="form-group form-group_vertical">
                <label class="form-group-title"><?php esc_html_e('Task introduction', 'taskbot'); ?></label>
                <textarea class="form-control" name="taskbot_service[post_content]" placeholder="<?php esc_attr_e('Enter description', 'taskbot'); ?>"><?php echo do_shortcode($service_content);?></textarea>
                <span class="form-characters"><?php esc_html_e('max 500 characters', 'taskbot'); ?></span>
            </div>
            <div class="form-group form-group_vertical">
                <label class="form-group-title"><?php esc_html_e('Tags', 'taskbot'); ?>:</label>
                <input name="taskbot_service[product_tag][]" value='<?php echo esc_attr($service_tag); ?>' placeholder="<?php esc_attr_e('Add tags', 'taskbot'); ?>" class="form-control tb-tagscroll">
            </div>
            <?php do_action('taskbot_service_step_1_fields', $args); ?>
            <div class="form-group tb-postservicebtn">
                <div class="tb-savebtn">
                    <span><?php esc_html_e('Click “Save & Continue” to add latest changes made by you', 'taskbot'); ?></span>
                    <button type="submit" class="tb-btn"><?php esc_html_e('Save & Continue', 'taskbot'); ?></button>
                    <input type="hidden" id="service_id" name="post_id" value="<?php echo intval($post_id); ?>">
                </div>
            </div>
        </fieldset>
    </form>
</div>
<?php
$script = "
    jQuery(document).on('ready', function(){
        if ( $.isFunction($.fn.select2) ) {
            jQuery('.tb-service-select2').select2({
                multiple: true,
                placeholder: scripts_vars.service_type
            });
        }
        let input = document.querySelector('.tb-tagscroll');
		if (input !== null) {
			new Tagify(input, {
                enforceWhitelist : scripts_vars.allow_tags,
                whitelist: ".json_encode($product_term_array).",
                maxTags: 20,
                dropdown: {
                    maxItems: 1000,
                    classname: 'tags-look',
                    enabled: 0,
                    
                    closeOnSelect: true
                }
            });
		}
    });
";
wp_add_inline_script( 'taskbot', $script, 'after' );
