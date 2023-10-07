<?php
/**
 *
 * The template used for displaying cart detail
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

global $current_user,$taskbot_settings;
$custom_field_option    =  !empty($taskbot_settings['custom_field_option']) ? $taskbot_settings['custom_field_option'] : false;
$admin_commision_buyers     =  !empty($taskbot_settings['admin_commision_buyers']) ? $taskbot_settings['admin_commision_buyers'] : 0;
$commission_text            =  !empty($taskbot_settings['commission_text']) ? $taskbot_settings['commission_text'] : esc_html__('Processing fee', 'taskbot');

$product_id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;
$post_author	  = get_post_field( 'post_author', $product_id );
$post_author      = !empty($post_author) ? intval($post_author) : 0;

if( !empty($current_user->ID) && intval($post_author) == $current_user->ID ){
	do_action( 'taskbot_notification', esc_html__('Restricted access','taskbot'), esc_html__('Oops! you are not allowed to perfom this action','taskbot') );
} else {

    $key              = !empty($_GET['key']) ? $_GET['key'] : '';
    $sub_tasks        = !empty($_GET['sub_tasks']) ? $_GET['sub_tasks'] : array();

    $user_balance     = !empty($current_user->ID) ? get_user_meta($current_user->ID, '_buyer_balance', true) : '';
    $user_balance     = !empty($user_balance) ? $user_balance : 0;

    $wallet_checked   = !empty($user_balance) ? 'checked' : '';
    $product          = wc_get_product($product_id);
    $image            = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), array(100, 100));
    $product_name     = $product->get_name();

    $list_html = '';
    /* product related categories */
    $prod_cate_html     = '';
    $product_cate_ids   = wc_get_product_term_ids($product_id, 'product_cat');

    foreach ($product_cate_ids as $cat_id) {
        $term           = get_term_by('id', $cat_id, 'product_cat');
        $prod_cate_html .= '<a href="' . esc_url(get_category_link($cat_id)) . '">' . esc_html($term->name) . '</a>, ';
    }
    /* getting features */
    $product_cat  = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));
    $plan_array   = array(
        'product_tabs'            => array('plan'),
        'product_plans_category'  => $product_cat
    );

    /* getting acf fields */
    $acf_fields             = taskbot_acf_groups($plan_array);
    /* taskbot plan Values */
    $taskbot_plans_values   = get_post_meta($product_id, 'taskbot_product_plans', TRUE);
    $taskbot_plans_values   = !empty($taskbot_plans_values) ? $taskbot_plans_values : array();
    /* getting subtasks */
    $taskbot_subtask        = get_post_meta($product_id, 'taskbot_product_subtasks', TRUE);
    $taskbot_subtask        = !empty($taskbot_subtask) ? $taskbot_subtask : array();

    $tb_custom_fields       = get_post_meta( $product_id, 'tb_custom_fields',true );
    $tb_custom_fields       = !empty($tb_custom_fields) ? $tb_custom_fields : array();
    ?>
    <div class="tk-main-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="tk-servicedetail">
                        <div class="tk-checkoutinfo">
                            <?php if (!empty($image[0])) { ?>
                                <figure>
                                    <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($product_name); ?>">
                                </figure>
                            <?php } ?>
                            <div class="tk-checkoutdetail">
                                <h6><?php echo do_shortcode($prod_cate_html); ?></h6>
                                <h5><?php echo esc_html($product_name); ?></h5>
                                <ul class="tk-blogviewdates tk-blogviewdatessm">
                                    <?php do_action('taskbot_service_rating_count', $product); ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-box">
                            <h4><?php esc_html_e('Features included', 'taskbot'); ?>:</h4>
                            <?php
                            $counter_checked      = 0;
                            $price_package        = 0;
                            $package_title        = '';
                            $package_key          = '';
                            $pkg_image            = '';
                            foreach ($taskbot_plans_values as $plan_key => $plan_val) {
                                $counter_checked++;
                                if (!empty($key) && $key == $plan_key) {
                                    $price_package    = !empty($plan_val['price']) ? $plan_val['price'] : 0;
                                    $package_title    = !empty($plan_val['title']) ? $plan_val['title'] : '';
                                    $pkg_image	      = !empty($taskbot_settings['task_plan_icon_'.$plan_key]['url']) ? $taskbot_settings['task_plan_icon_'.$plan_key]['url'] : '';
                                    $package_price    = $price_package;
                                    $package_key      = $plan_key;
                                }
                                
                                $feature_class = 'd-none';
                                if ($key === $plan_key) {
                                    $feature_class = '';
                                }
                                ?>
                                <ul class="tk-mainlist tk-mainlistvtwo tb-pkg-<?php echo esc_attr($plan_key) . ' ' . esc_attr($feature_class); ?>"
                                    id="tb-pkg-<?php echo esc_attr($plan_key); ?>">
                                    <?php
                                    foreach ($acf_fields as $acf_key => $acf_field) {
                                        $plan_value = !empty($acf_field['key']) && !empty($plan_val[$acf_field['key']]) ? $plan_val[$acf_field['key']] : '';
                                        
										if (!empty($acf_field['label'])) {
                                            if (!empty($acf_field['type']) && in_array($acf_field['type'], array('text', 'textarea', 'number'))) {
                                                echo do_shortcode('<li><span>' . esc_html($acf_field['label']) . '</span><em> (' . esc_html($plan_value) . ')</em></li>');
                                            } else if (!empty($acf_field['type']) && $acf_field['type'] === 'url' && !empty($plan_value)) {
                                                echo do_shortcode('<li><span>' . esc_html($acf_field['label']) . '</span><em><a href="' . esc_url($plan_value) . '" target="_blank"> (' . esc_html($plan_value) . ')</a></em></li>');
                                            } else if (!empty($acf_field['type']) && $acf_field['type'] === 'email' && !empty($plan_value)) {
                                                echo do_shortcode('<li><span>' . esc_html($acf_field['label']) . '</span><em><a href="mailto:' . esc_attr($plan_value) . '" target="_blank"> (' . esc_html($plan_value) . ')</a></em></li>');
                                            } else if (!empty($acf_field['type']) && in_array($acf_field['type'], array('checkbox'))) {
                                                $class = !empty($plan_value) && $plan_value === 'yes' ? 'tb-available' : 'tb-unavailable';
                                                echo do_shortcode('<li class="' . esc_attr($class) . '"><span>' . esc_html($acf_field['label']) . '</span></li>');
                                            }
                                        }
                                    }
                                    ?>
                                    <?php 
                                        if( !empty($tb_custom_fields) && !empty($custom_field_option) ){
                                            foreach($tb_custom_fields as $field_value){
                                                if( !empty($field_value['title']) ){?>
                                                <li>
                                                    <span><?php echo esc_html($field_value['title']); ?></span>
                                                    <em> (<?php echo esc_html($field_value[$plan_key]); ?>)</em>
                                                </li>
                                    <?php   }
                                        }
                                    } 
                                    ?>
                                </ul>
                            <?php } ?>
                        </div>
                        <?php if( !empty($taskbot_subtask) ){?>
                            <div class="tk-box">
                                <div class="tk-boxtittle">
                                    <h4><?php esc_html_e('Additional services', 'taskbot'); ?></h4>
                                    <div class="tk-inputiconbtn"></div>
                                </div>
                                <ul class="tk-additionalservices tk-additionalservicesvtwo" id="tk-show_more">
                                    <?php
                                    foreach ($taskbot_subtask as $taskbot_subtask_id) {
                                        $price_subtask  = get_post_meta($taskbot_subtask_id, '_regular_price', true);
                                        $subtask_title  = get_the_title($taskbot_subtask_id);
                                        $checked        = '';
                                        if (!empty($sub_tasks) && is_array($sub_tasks) && in_array($taskbot_subtask_id, $sub_tasks)) {
                                            $checked      = 'checked';
                                            $price_package = $price_package + $price_subtask;
                                            $list_html .= '<li><span>' . esc_html($subtask_title) . '</span><em>' . taskbot_price_format($price_subtask, 'return') . '</em></li>';
                                        }
                                        /* implement active class */
                                        $active_class = in_array($taskbot_subtask_id, $sub_tasks) ? 'class=tk-services-checked' : '';
                                        ?>
                                        <li <?php echo esc_attr($active_class); ?>>
                                            <div class="tk-form-checkbox tb-additionalpackage">
                                                <input class="form-check-input tk-form-check-input-sm tb_subtask_check"
                                                    type="checkbox"
                                                    id="additionalservice-list-<?php echo intval($taskbot_subtask_id); ?>"
                                                    name="task-additional-serives[]"
                                                    data-title="<?php echo esc_attr($subtask_title); ?>"
                                                    data-price="<?php echo taskbot_price_format($price_subtask, 'return'); ?>"
                                                    data-id="<?php echo intval($taskbot_subtask_id); ?>"
                                                    value="<?php echo intval($taskbot_subtask_id); ?>"
                                                    <?php echo esc_attr($checked); ?>>
                                                <label class="tk-additionolinfo"
                                                    for="additionalservice-list-<?php echo intval($taskbot_subtask_id); ?>">
                                                    <span><?php echo esc_html($subtask_title); ?></span>
                                                    <em><?php echo apply_filters('the_content', get_the_content(null, false, $taskbot_subtask_id)); ?></em>
                                                </label>
                                                <div class="tk-addcartinfoprice">
                                                    <h6><?php taskbot_price_format($price_subtask); ?></h6>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xl-4">
                    <aside>
                        <form id="tb_cart_form" class="tb-orderdetailswrap">
                            <div class="tk-asideholder">
                                <div class='tk-asideboxsm'>
                                    <h5><?php esc_html_e('Order details', 'taskbot'); ?></h5>
                                </div>
                                <div class="tk-pakagedetail tb-additonoltitleholder collapsed" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#tk-pakagedetail" aria-expanded="false">
                                    <?php if( !empty($pkg_image) ){?>
                                        <figure>
                                        <img id="tb_pkg_image" src="<?php echo esc_url($pkg_image);?>" alt="<?php echo esc_attr($package_title); ?>">
                                    </figure>
                                    <?php } ?>
                                    <div class='tk-pakageinfo'>
                                        <h6><?php echo esc_html($package_title); ?></h6>
                                        <?php if( !empty($package_price) ) {?>
                                            <h4 id="tb_package_price"><?php taskbot_price_format($package_price); ?></h4>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="tk-collapsepanel">
                                    <div class="collapse" id="tk-pakagedetail">
                                        <ul class="tk-pakagelist">
                                            <?php
                                            foreach ($taskbot_plans_values as $plan_key => $plan_val) {
                                                $price_plan   = !empty($plan_val['price']) ? $plan_val['price'] : 0;
                                                if (!empty($plan_val['title'])) {
                                                    $selected   = '';
                                                    if (!empty($key) && $key == $plan_key) {
                                                        $selected     = 'selected';
                                                        $list_html    = '<li><span>' . esc_html($plan_val['title']) . '</span><em>' . taskbot_price_format($price_plan, 'return') . '</em></li>' . $list_html;
                                                    }

                                                /* implement active class */
                                                $active_clas        = !empty($key) && $key == $plan_key ? 'active' : '';
                                                $task_plan_icon_url	= !empty($taskbot_settings['task_plan_icon_'.$plan_key]['url']) ? $taskbot_settings['task_plan_icon_'.$plan_key]['url'] : '';
                                                ?>
                                                <li class="tb-pakagelist-item <?php echo esc_attr($active_clas); ?>"
                                                    data-task_id="<?php echo intval($product_id); ?>"
                                                    data-package_key="<?php echo do_shortcode($plan_key); ?>" data-img="<?php echo esc_url($task_plan_icon_url);?>">
                                                    <a href="javascript:void(0);">
                                                        <?php if( !empty($task_plan_icon_url) ){ ?>
                                                            <img src="<?php echo esc_url($task_plan_icon_url);?>" alt="<?php echo esc_attr($plan_val['title']);?>" />
                                                        <?php } ?>
                                                        <span><?php echo esc_html($plan_val['title']); ?></span>
                                                        <em>
                                                            <?php taskbot_price_format($price_plan); ?>
                                                            <i class="fas fa-check"></i>
                                                        </em>
                                                    </a>
                                                </li>
                                            <?php } }?>
                                        </ul>
                                        <input type="hidden" id="tb_task_cart" data-task_id="<?php echo intval($product_id); ?>">
                                        <input type="hidden" name="product_task" id="tb_project_task_key" value="<?php echo do_shortcode($package_key); ?>" data-task_key="<?php echo do_shortcode($package_key); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php
                                if(!empty($admin_commision_buyers )){
                                    $processing_fee =  $price_package/$admin_commision_buyers;
                                    $price_package    = $price_package + $processing_fee;
                                    $list_html    = $list_html.'<li><span>' . $commission_text . '</span><em>' . taskbot_price_format($processing_fee, 'return') . '</em></li>';
                                }
                            ?>

                            <div class="tk-asideholder mt-0 border-top-0">
                                <div class="tk-asideboxv2">
                                    <div class="tk-sidetitle">
                                        <h5><?php esc_html_e('Selected additional features', 'taskbot'); ?></h5>
                                    </div>
                                    <ul class="tk-exploremore" id="tb-planlist">
                                        <?php echo do_shortcode( $list_html );?>
                                    </ul>
                                </div>
                                
                                <ul class="tk-featuredlisted">
                                    <li><?php esc_html_e('Subtotal','taskbot');?> <span id="tb_task_total"><?php taskbot_price_format($price_package); ?></span></li>
                                </ul>
                                <div class="tk-walletsystem">
                                    <div class="tk-form-checkbox">
                                        <input class="form-check-input tk-form-check-input-sm" type="checkbox"
                                            id="tb_wallet_option" name="wallet" <?php echo esc_attr($wallet_checked);?>>
                                        <label class="tk-additionolinfo" for="tb_wallet_option">
                                            <span><?php esc_html_e('Use my wallet credit', 'taskbot'); ?></span>
                                            <em><?php esc_html_e('Wallet credit will be used during the checkout process', 'taskbot'); ?></em>
                                        </label>
                                        <span class="tk-walletamount">
                                            <span>( <?php taskbot_price_format($user_balance); ?>)</span>
                                        </span>
                                    </div>
                                    <div class="tk-btnwalletfund">
                                        <a href="javascript:void(0);" class="tk-btn-solid-lg tk-btnsfund" data-bs-toggle="modal" data-bs-target="#tbcreditwallet">
                                            <?php esc_html_e('Add funds to wallet', 'taskbot'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="tk-btnwallet">
                                    <a href="javascript:void(0);" class="tk-btn-solid-lg-lefticon" data-id="<?php echo intval($product_id); ?>" id="tb_btn_cart">
                                        <i class="icon-lock"></i>
                                        <?php esc_html_e('Proceed to secure checkout', 'taskbot'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
<?php }
