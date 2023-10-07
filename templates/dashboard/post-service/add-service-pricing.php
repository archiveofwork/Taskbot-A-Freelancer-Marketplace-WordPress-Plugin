<?php
/**
 *  Task plans
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/post_services
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global  $taskbot_settings;
$package_option         =  !empty($taskbot_settings['package_option']) && in_array($taskbot_settings['package_option'],array('paid','buyer_free')) ? true : false;
$custom_field_option    =  !empty($taskbot_settings['custom_field_option']) ? $taskbot_settings['custom_field_option'] : false;
$packages_listing_page  = 'javascript:void(0);';
if (!empty($package_option)) {
    $packages_listing_page  = !empty($taskbot_settings['tpl_package_page']) ? get_the_permalink($taskbot_settings['tpl_package_page']) : 'javascript:void(0);';
}

if(!empty($_GET['postid'])){
    $post_id = $_GET['postid'];
}

if ( !class_exists('WooCommerce') ) {
	return;
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
if( !empty($custom_field_option) ){
    $tb_custom_fields       = get_post_meta( $post_id, 'tb_custom_fields',true );
    $tb_custom_fields       = !empty($tb_custom_fields) ? $tb_custom_fields : array();
}
$taskbot_plans_values       = get_post_meta($post_id, 'taskbot_product_plans', TRUE);
$taskbot_subtasks_selected  = get_post_meta($post_id, 'taskbot_product_subtasks', TRUE);
$taskbot_service_plans  = Taskbot_Service_Plans::service_plans();
$taskbot_service_keys   = !empty($taskbot_service_plans) && is_array($taskbot_service_plans) ? array_keys($taskbot_service_plans) : array();
$taskbot_overlay_class  = 'tb-active-pricing';
if($task_plans_allowed == 'no'){
    $taskbot_overlay_class  = 'tb-overley-pricing';
}

$user_id = get_current_user_id();
$args = array(
    'limit'     => -1, // All products
    'status'    => 'publish',
    'type'      => 'subtasks',
    'orderby'   => 'date',
    'order'     => 'DESC',
    'author'    => $user_id
);
$taskbot_subtasks = wc_get_products( $args );?>
<div id="service-pricing-wrapper">
    <form id="service-plans-form" class="tb-themeform service-plans-form" name="service-plans-form" action="<?php echo esc_url($current_page_url);?>" method="post" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <?php do_action('taskbot_plans_fields_before', $taskbot_service_plans); ?>
                <div class="tb-pricingcontainer tb-pricingcontainertwo">
                    <div class="tb-pricing-items">
                        <ul class="tb-pricingitems <?php echo esc_attr($taskbot_overlay_class);?>">
                            <li class="tb-pricingplan">
                                <div class="tb-pricingitems__content">
                                    <div class="tb-pricingtitle"></div>
                                    <?php do_action('taskbot_render_plans_fields', $taskbot_service_plans, $taskbot_plans_values, $task_plans_allowed);?>
                                </div>
                            </li>
                            <?php
                            if( class_exists('ACF') ) :
                               $groups = acf_get_field_groups();
                                foreach($groups as $group){ 
                                    foreach( $group['location'] as $group_locations ) {
                                        $taskbot_plan_category = '';
                                        $product_plans_category = 'am-plans-category';
                                        $found_key = array_search('product_plans_category', array_column($group_locations, 'param'));

                                        if($found_key){
                                            $group_location_category = $group_locations[$found_key];

                                            if(isset($group_location_category['param']) && $group_location_category['param'] == 'product_plans_category'
                                                && !empty($group_location_category['value']) ){
                                                $product_plans_category .= ' am-category-'.$group_location_category['value'];
                                                $taskbot_plan_category = $group_location_category['value'];
                                            }

                                        }

                                        $product_plans_category = apply_filters('taskbot_product_plans_category', $product_plans_category);
                                        $found_key = '';

                                        if(!empty($service_categories) && is_array($service_categories) && !in_array($taskbot_plan_category, $service_categories)){
                                            continue;
                                        }
                                        
                                        foreach( $group_locations as $rule ) {
                                            if( $rule['param'] == 'product_tabs' && $rule['operator'] == '==' && $rule['value'] == 'plan' ) {
                                                do_action('taskbot_plan_group_fields_before', $group, $taskbot_service_plans, $taskbot_plans_values, $product_plans_category);
                                                do_action('taskbot_acf_dynamically_render_fields', acf_get_fields( $group ), $taskbot_service_plans, $taskbot_plans_values, $product_plans_category);
                                                do_action('taskbot_plan_group_fields_after', $group, $taskbot_service_plans, $taskbot_plans_values, $product_plans_category);
                                                break 2;
                                            }

                                        }
                                    }
                                }
                            endif;
                            ?>
                        </ul>
                        <?php if($task_plans_allowed == 'no'){?>
                            <div class="tb-overleymodel">
                                <span class="icon-bookmark"></span>
                                <h5><?php esc_html_e('Need more slots?', 'taskbot');?></h5>
                                <p><?php esc_html_e('Unlock to add more package option to your buyers and get hired instantly', 'taskbot');?></p>
                                <div class="tb-lockbtn">
                                    <a href="<?php echo esc_url($packages_listing_page);?>" class="btn-lock"><?php esc_html_e('Unlock', 'taskbot');?> <span class="icon-unlock"></span></a>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <?php do_action('taskbot_plans_fields_after', $taskbot_service_plans, $taskbot_plans_values); ?>
            </div>
            <?php if( !empty($custom_field_option) ){?>
                <div class="form-group">
                    <div class="tb-postserviceholder">
                        <div class="tb-postservicetitle">
                            <h4><?php esc_html_e('Add custom fields','taskbot');?></h4>
                            <a href="javascript:void(0);" id="tb_add_customfields" data-heading="<?php esc_attr_e('Add more','taskbot');?>" title="<?php esc_attr_e('Add more','taskbot');?>"><?php esc_html_e('Add more','taskbot');?></a>
                        </div>
                        <div class="tb-pricing-items">
                            <ul class="tb-custom-fields" id="tb-customfields-ul">
                                <?php if( !empty($tb_custom_fields) ){
                                    foreach($tb_custom_fields as $key => $tb_custom_field){ 
                                        $title  = !empty($tb_custom_field['title']) ? $tb_custom_field['title'] : '';
                                    ?>
                                    <li id="fields-<?php echo esc_attr($key);?>" class="am-plans-category am-category-33 content_upload_to_zip_file">
                                        <div class="tb-pricingitems__content">
                                            <div class="form-field tb-remove-field">
                                                <div class="tb-trashlink">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </div>
                                            <div class="tb-pricingtitle form-field tb-pricing-input">
                                                <input type="text" name="custom_fields[<?php echo esc_attr($key);?>][title]" value="<?php echo esc_attr($title);?>" class="form-control tb-cf-title-input" placeholder="<?php esc_attr_e('Add title','taskbot');?>" autocomplete="off">
                                            </div>
                                            <?php foreach($taskbot_service_keys as $taskbot_keys){
                                                $package_value  = !empty($tb_custom_field[$taskbot_keys]) ? $tb_custom_field[$taskbot_keys] : '';
                                                ?>
                                                <div class="form-field tb-pricing-input">
                                                    <input type="text" name="custom_fields[<?php echo esc_attr($key);?>][<?php echo esc_attr($taskbot_keys);?>]" value="<?php echo esc_attr($package_value);?>" class="form-control " placeholder="<?php esc_attr_e('Add value','taskbot');?>" autocomplete="off">
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <?php }
                                }?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="tb-postserviceholder">
                    <div class="tb-postservicetitle">
                        <h4><?php esc_html_e('Add add-ons', 'taskbot');?></h4>
                        <a href="javascript:void(0);" data-target="#addon" data-toggle="modal" id="tb_add_new_task" data-heading="<?php esc_attr_e('Add task add-on', 'taskbot');?>" title="<?php esc_attr_e('Add more', 'taskbot');?>"><?php esc_html_e('Add more', 'taskbot');?></a>
                    </div>
                    <?php do_action('taskbot_subtask_before', $post_id); ?>
                    <ul id="tbslothandle" class="tb-addon">

                        <?php if(!empty($taskbot_subtasks) && is_array($taskbot_subtasks) && count($taskbot_subtasks)>0){
                            foreach($taskbot_subtasks as $subtask){
                                $checked    = '';
                                
                                if(!empty($taskbot_subtasks_selected) && is_array($taskbot_subtasks_selected) && in_array($subtask->get_id(), $taskbot_subtasks_selected)){
                                    $checked    = 'checked="checked"';
                                }?>
                                <li id="subtask-<?php echo (int)$subtask->get_id()?>" class="taskbot-subtasklist">
                                    <input Type="hidden" name="subtasks_ids[]" value="<?php echo (int)$subtask->get_id()?>" />
                                    <div class="tb-addon__content">
                                        <div class="tb-checkbox">
                                            <input class="tb-service-subtask" id="subtask<?php echo (int)$subtask->get_id()?>" name="subtasks_ids[]" value="<?php echo (int)$subtask->get_id()?>" type="checkbox" <?php echo do_shortcode($checked);?>>
                                            <label for="subtask<?php echo (int)$subtask->get_id()?>"><span><?php echo esc_html($subtask->get_name());?></span></label>
                                        </div>
                                        <h5><?php taskbot_price_format($subtask->get_price(),'',true); ?></h5>
                                    </div>
                                    <a href="javascript:void(0);" class="tb-addon__right tb-subtask-edit" data-subtask_id="<?php echo (int)$subtask->get_id()?>" data-heading="<?php esc_attr_e('Edit task add-on', 'taskbot');?>"><i class="icon-edit-2"></i></a>
                                </li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>
            <div class="form-group tb-postserviceformbtn">
                <div class="tb-savebtn">
                    <span><?php esc_html_e('Click “Save & Update” to update pricings', 'taskbot'); ?></span>
                    <button type="submit" class="tb-btn"><?php esc_html_e('Save & Update', 'taskbot'); ?></button>
                    <input type="hidden" id="service_id" name="post_id" value="<?php echo (int)$post_id; ?>">
                    <input type="hidden" id="add_service_step" name="step" value="<?php echo (int)$step; ?>">
                </div>
            </div>
        </fieldset>

    </form>
    <script type="text/template" id="tmpl-load-service-subtask">
        <li id="subtask-{{data.id}}" class="taskbot-subtasklist">
            <input Type="hidden" name="subtasks_ids[]" value="{{data.id}}" />
            <div class="tb-addon__content">
                <div class="tb-checkbox">
                    <input id="subtask{{data.id}}" class="tb-service-subtask" name="subtasks_ids[]" value="{{data.id}}" type="checkbox" checked="checked">
                    <label for="subtask{{data.id}}"><span>{{data.title}}</span></label>
                </div>
                <h5>{{data.price}}</h5>
            </div>
            <a href="javascript:void(0);" class="tb-addon__right tb-subtask-edit"  data-heading="<?php esc_attr_e('Edit task add-on', 'taskbot');?>" data-subtask_id="{{data.id}}"><i class="icon-edit-2"></i></a>
        </li>
    </script>
    <script type="text/template" id="tmpl-load-service-add-subtask">
        <fieldset id="tb-subtask-form">
            <div class="form-group">
                <label class="form-group-title"><?php esc_html_e('Add add-on title', 'taskbot');?>:</label>
                <input type="text" id="subtask-title" value="{{data.title}}" class="form-control" placeholder="<?php esc_attr_e('Enter title here', 'taskbot');?>" autocomplete="off">
            </div>
            <div class="form-group">
                <label class="form-group-title"><?php esc_html_e('Add add-on price', 'taskbot');?>:</label>
                <input type="number" min="0" id="subtask-price" value="{{data.price}}" class="form-control" autocomplete="off" placeholder="<?php esc_attr_e('Enter price', 'taskbot');?>">
            </div>
            <div class="form-group">
                <label class="form-group-title"><?php esc_html_e('Add add-on description', 'taskbot');?>:</label>
                <textarea class="form-control" id="subtask-description" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>">{{data.content}}</textarea>
            </div>
            <div class="form-group tb-form-btn">
                <div class="tb-savebtn">
                    <span><?php esc_html_e('Click “Save & Update” to update your add-ons', 'taskbot');?></span>
                    <a href="javascript:void(0);" class="tb-btn" id="tb-add-subtask-service"><?php esc_html_e('Save & Update', 'taskbot');?></a>
                </div>
            </div>
            <input type="hidden" name="subtask_id" id="subtask_id" value="{{data.id}}">
        </fieldset>
    </script>
    <?php if( !empty($custom_field_option) ){?>
        <script type="text/template" id="tmpl-load-service-custom_fields">
            <li id="fields-{{data.id}}" class="tb-pricing-input am-plans-category am-category-33 content_upload_to_zip_file">
                <div class="tb-pricingitems__content">
                    <div class="form-field tb-remove-field">
                        <div class="tb-trashlink">
                            <i class="icon-trash-2"></i>
                        </div>
                    </div>
                    <div class="tb-pricingtitle form-field tb-pricing-input">
                            <input type="text" name="custom_fields[{{data.id}}][title]" value="" class="form-control tb-cf-title-input" placeholder="<?php esc_attr_e('Add title','taskbot');?>" autocomplete="off">
                        </div>
                    <?php foreach($taskbot_service_keys as $taskbot_keys){?>
                        <div class="form-field tb-pricing-input">
                            <input type="text" name="custom_fields[{{data.id}}][<?php echo esc_attr($taskbot_keys);?>]" value="" class="form-control " placeholder="<?php esc_attr_e('Add value','taskbot');?>" autocomplete="off">
                        </div>
                    <?php } ?>
                </div>
            </li>
        </script>
    <?php } ?>
</div>