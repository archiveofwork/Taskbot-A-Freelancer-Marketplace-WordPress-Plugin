<?php
/**
 * Single price plans
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global $product,$current_user,$taskbot_settings;
$custom_field_option    =  !empty($taskbot_settings['custom_field_option']) ? $taskbot_settings['custom_field_option'] : false;
if(empty($taskbot_plans_values) && !is_array($taskbot_plans_values) || count($taskbot_plans_values)<2){
    return;
}

$post_id        = $product->get_id();
$post_author	  = get_post_field( 'post_author', $post_id );
$post_author    = !empty($post_author) ? intval($post_author) : 0;
$checkout_class	= 'tb_btn_checkout';
if( !empty($current_user->ID) && intval($post_author) == $current_user->ID ){
	$checkout_class	= 'tb_btn_author';
}
$tb_custom_fields       = get_post_meta( $post_id, 'tb_custom_fields',true );
$tb_custom_fields       = !empty($tb_custom_fields) ? $tb_custom_fields : array();
?>
<div class="tb-singleservice-tile" id="taskbot-price-plans">
    <div class="tb-packagewrap">
        <div id="tk-offered-plans" class="tb-packagewraptitle">
            <h4><?php esc_html_e('Affordable price plans', 'taskbot'); ?></h4>
        </div>
        <ul class="tb-packages">
            <li>
                <div class="tb-packages__content">
                    <div class="tb-packages__maintitle">
                        <h6><?php esc_html_e('Pricing plans', 'taskbot'); ?></h6>
                    </div>
                    <?php if( !empty($acf_fields) || !empty($tb_custom_fields) ){ ?>
                        <div class="tb-packages__title">
                            <?php
                                $duplicate_key		= array();
                                foreach ($acf_fields as $acf_field) {
                                    if(!empty($duplicate_key[$acf_field['key']]) && !empty($duplicate_key) && in_array($acf_field['key'],$duplicate_key)){
                                        //do nothing
                                    }else{
                                        if (!empty($acf_field['label'])) { ?>
                                            <span><?php echo esc_html($acf_field['label']); ?>:</span>
                                        <?php } ?>
                                    <?php $duplicate_key[$acf_field['key']]	= $acf_field['key'];} ?>
                            <?php } ?>
                            <?php 
                                if( !empty($tb_custom_fields) && !empty($custom_field_option) ){
                                    foreach($tb_custom_fields as $field_value){
                                        if( !empty($field_value['title']) ){?>
                                            <span><?php echo esc_html($field_value['title']); ?></span>
                                    <?php }
                                    }
                                } 
                            ?>
                            <span><?php esc_html_e('Delivery time', 'taskbot'); ?>:</span>
                            <span class="tb-totelprice"></span>
                        </div>
                    <?php } ?>
                </div>
            </li>
            <?php
            $counter      = 0;
            $shadow_class = '';
            foreach ($taskbot_plans_values as $key => $plans_value) {
                $counter++;
                $title            = !empty($plans_value['title']) ? $plans_value['title'] : '';
                $description      = !empty($plans_value['description']) ? $plans_value['description'] : '';
                $featured_package = !empty($plans_value['featured_package']) ? $plans_value['featured_package'] : '';
                $price            = !empty($plans_value['price']) ? $plans_value['price'] : 0;
                $delivery_time    = !empty($plans_value['delivery_time']) ? $plans_value['delivery_time'] : '';
                $delivery_time    = !empty($delivery_time) ? get_term_by('id', $delivery_time, 'delivery_time')->name : '';
                $cart_url         = Taskbot_Profile_Menu::taskbot_custom_profile_menu_link('cart', $post_id, $key);

                if ($counter == 2) {
                    $shadow_class   = 'tb-shadow';
                }

                $duplicate_key		= array();

                if (!empty($title) && !empty($price)) { ?>
                    <li>
                        <div class="tb-packages__content">
                            <?php if (!empty($featured_package) && $featured_package === 'yes'){ ?><div class="tb-popular tb_tippy"><?php } ?>
                                <div class="tb-packages__plan">
                                    <div class="tb-packages__maintitle">
                                        <h6><?php esc_html_e('Pricing plans', 'taskbot'); ?></h6>
                                    </div>
                                    <?php if (!empty($title)) { ?>
                                        <h6><?php echo esc_html($title); ?></h6>
                                    <?php } ?> 
                                    <?php if (!empty($price)) { ?>
                                        <h4><?php taskbot_price_format($price) ?></h4>
                                    <?php } ?>
                                    <?php if (!empty($description)) { ?>
                                        <p><?php echo esc_html($description); ?></p>
                                    <?php } ?>
                                    <?php if (!empty($description)) { ?>
                                        <p><?php echo esc_html($description); ?></p>
                                    <?php } ?>
                                </div>
                                <?php if (!empty($featured_package) && $featured_package === 'yes'){ ?>
                                    <div class="tb-populartag"  <?php echo apply_filters('taskbot_tooltip_attributes', 'featured_package');?>>
                                        <i class="fas fa-bolt"></i>
                                    </div>
                                </div>
                                <?php if (!empty($featured_package) && $featured_package === 'yes'){ ?>
                                    <div class="tb-populartag"  <?php echo apply_filters('taskbot_tooltip_attributes', 'featured_package');?>>
                                        <i class="fas fa-bolt"></i>
                                    </div>
                                </div>
                            <?php }
                            foreach ($acf_fields as $acf_field) {
                                $plan_value =  !empty($acf_field['key']) && !empty($plans_value[$acf_field['key']]) ? $plans_value[$acf_field['key']] : '--';
                                if(!empty($duplicate_key[$acf_field['key']]) && !empty($duplicate_key) && in_array($acf_field['key'],$duplicate_key)){
                                    //do nothing
                                }else{
                                    if (!empty($acf_field['label'])) { ?>
                                        <div class="tb-packages__text">
                                            <div class="tb-packages__title">
                                                <span><?php echo esc_html($acf_field['label']); ?></span>
                                                <?php if (!empty($acf_field['type']) && in_array($acf_field['type'], array('text', 'textarea', 'number', 'radio'))) { ?>
                                                    <span><?php echo esc_html($plan_value); ?></span>
                                                <?php } else if (!empty($acf_field['type']) && $acf_field['type'] === 'url') { ?>
                                                    <span><a href="<?php echo esc_url($plan_value); ?>" target="_blank"><?php echo esc_html($plan_value); ?></a></span>
                                                <?php } else if (!empty($acf_field['type']) && $acf_field['type'] === 'select') { ?>
                                                    <?php if(!empty($plan_value) && is_array($plan_value) && count($plan_value)>0){?>
                                                        <span><?php echo implode(', ', $plan_value); ?></span>
                                                    <?php } else {?>
                                                        <span><?php echo esc_html($plan_value); ?></span>
                                                    <?php }?>
                                                <?php } else if (!empty($acf_field['type']) && $acf_field['type'] === 'email') { ?>
                                                    <span><a href="mailto:<?php echo esc_attr($plan_value); ?>"><?php echo esc_html($plan_value); ?></a></span>
                                                <?php } ?>
                                            </div>
                                            <?php 
                                            if (!empty($acf_field['type']) && in_array($acf_field['type'], array('checkbox'))) {
                                                $class = !empty($plan_value) && $plan_value === 'yes' ? 'tb-available' : '';
                                            ?>
                                                <span class="tb-packages__check <?php echo esc_attr($class); ?>"><i class="fa fa-check"></i></span>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                <?php $duplicate_key[$acf_field['key']]	= $acf_field['key']; } ?>
                            <?php } ?>
                            <?php 
                                if( !empty($tb_custom_fields) && !empty($custom_field_option) ){
                                    foreach($tb_custom_fields as $field_value){
                                        if( !empty($field_value['title']) ){?>
                                    <div class="tb-packages__text">
                                        <div class="tb-packages__title">
                                            <span><?php echo esc_html($field_value['title']); ?></span>
                                            <span><?php echo esc_html($field_value[$key]); ?></span>
                                        </div>
                                    </div>
                            <?php   }
                                }
                            } 
                            ?>
                            <div class="tb-packages__text">
                                <div class="tb-packages__title">
                                    <span><?php esc_html_e('Delivery time', 'taskbot'); ?></span>
                                    <span><?php echo esc_html($delivery_time); ?></span>
                                </div>
                            </div>
                            <div class="tb-packages__buy">                                    
                                <a href="javascript:void(0);" data-url="<?php echo esc_url( $cart_url );?>" data-type="task_cart" class="tb-btn <?php echo esc_attr($checkout_class);?>"><?php esc_html_e('Buy now', 'taskbot'); ?></a>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>