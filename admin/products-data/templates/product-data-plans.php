<?php

/**
 * 
 * Template to display product data plan tabs fields
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/products_data
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $woocommerce, $post;
$taskbot_plans_values   = get_post_meta($post->ID, 'taskbot_product_plans', TRUE);
$taskbot_service_plans  = Taskbot_Service_Plans::service_plans();
do_action('taskbot_plans_fields_before', $taskbot_service_plans);
$author_id              = get_post_field ('post_author', $post->ID);
$package_detail	        = taskbot_get_package($author_id);
$task_plans_allowed	    = 'yes';
$package_type	        = !empty($package_detail['type']) ? $package_detail['type'] : '';

if($package_type == 'paid'){
    $task_plans_allowed	= !empty($package_detail['package']['task_plans_allowed']) ? $package_detail['package']['task_plans_allowed'] : 'no';
}

$taskbot_overlay_class  = 'tb-active-pricing';

if($task_plans_allowed == 'no'){
    $taskbot_overlay_class  = 'tb-overley-pricing';
}

?>
<div class="tb-pricingcontainer">
  <div class="tb-pricing-items">
    <ul class="tb-pricingitems <?php echo esc_attr($taskbot_overlay_class);?>">
        <li class="tb-emptyprice">
            <div class="tb-pricingitems__content">
                <div class="tb-pricingtitle"></div>
                <?php do_action('taskbot_render_plans_fields', $taskbot_service_plans, $taskbot_plans_values, $task_plans_allowed);?>
            </div>
        </li>
        <?php
        if( class_exists('ACF') ) :
            $groups = acf_get_field_groups(array('product_tabs' => 'plan' ));
            $groups = acf_get_field_groups();
            foreach($groups as $group){
                foreach( $group['location'] as $group_locations ) {
                    $product_plans_category = 'am-plans-category';
                    $found_key = array_search('product_plans_category', array_column($group_locations, 'param'));
                    
                    if($found_key){
                        $group_location_category = $group_locations[$found_key];
                        
                        if(!empty($group_location_category['param']) && $group_location_category['param'] == 'product_plans_category'
                            && !empty($group_location_category['value']) ){
                            $product_plans_category .= ' am-category-'.$group_location_category['value'];
                        }
                    }

                    $product_plans_category = apply_filters('taskbot_product_plans_category', $product_plans_category);
                    $found_key = '';
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
  </div>
</div>
<?php
do_action('taskbot_plans_fields_after', $taskbot_service_plans, $taskbot_plans_values);
