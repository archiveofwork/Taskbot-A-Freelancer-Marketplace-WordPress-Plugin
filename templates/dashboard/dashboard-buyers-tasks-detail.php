<?php
/**
 *  Buyer task detail
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global  $current_user, $taskbot_settings;
$order_id                   = !empty($_GET['id']) ? intval($_GET['id']) : 0;
$user_identity              = !empty($_GET['identity']) ? intval($_GET['identity']) : 0;
$taskbot_refund_title       = !empty($taskbot_settings['buyer_refund_req_title']) ? $taskbot_settings['buyer_refund_req_title'] : esc_html__('Create Refund Request', 'taskbot');
$taskbot_refund_subheading  = !empty($taskbot_settings['buyer_refund_req_subheading']) ? $taskbot_settings['buyer_refund_req_subheading'] : '';
$hide_deadline  = !empty($taskbot_settings['hide_deadline']) ? $taskbot_settings['hide_deadline'] : 'no';
$buyer_dispute_issues       = !empty($taskbot_settings['buyer_dispute_issues']) ? $taskbot_settings['buyer_dispute_issues'] : array();

$tpl_terms_conditions   = !empty( $taskbot_settings['tpl_terms_conditions'] ) ? $taskbot_settings['tpl_terms_conditions'] : '';
$tpl_privacy            = !empty( $taskbot_settings['tpl_privacy'] ) ? $taskbot_settings['tpl_privacy'] : '';
$term_link              = !empty($tpl_terms_conditions) ? '<a target="_blank" href="'.get_the_permalink($tpl_terms_conditions).'">'.get_the_title($tpl_terms_conditions).'</a>' : '';
$privacy_link           = !empty($tpl_privacy) ? '<a target="_blank" href="'.get_the_permalink($tpl_privacy).'">'.get_the_title($tpl_privacy).'</a>' : '';


if (!class_exists('WooCommerce')) {
    return;
}

$task_id            = get_post_meta($order_id, 'task_product_id', true);
$task_id            = !empty($task_id) ? $task_id : 0;
$order              = wc_get_order($order_id);
$user_type          = apply_filters('taskbot_get_user_type', $order->get_user_id());
$wallet_amount      = get_post_meta($order_id, '_wallet_amount', true);
$wallet_amount      = !empty($wallet_amount) ? $wallet_amount : 0;
$order_price        = $order->get_total();
$order_price        = !empty($order_price) ? ($order_price + $wallet_amount) : 0;
$seller_id          = get_post_meta($order_id, 'seller_id', true);
$seller_id          = !empty($seller_id) ? intval($seller_id) : 0;
$product_data       = get_post_meta($order_id, 'cus_woo_product_data', true);
$product_data       = !empty($product_data) ? $product_data : array();
$order_details      = get_post_meta($order_id, 'order_details', true);
$order_details      = !empty($order_details) ? $order_details : array();
$items              = $order->get_items();
$get_taxes          = $order->get_taxes();
$tb_order_gmt       = get_post_meta($order_id, 'delivery_date', true);
$tb_order_gmt       = !empty($tb_order_gmt) ? intval($tb_order_gmt) : 0;
$tb_order_date      = !empty($tb_order_gmt) ? date('m/d/Y H:i:s', $tb_order_gmt) : '';
$gmt_offset         = get_option('gmt_offset');
if($gmt_offset > 0 ){
    $gmt_offset = '+'.$gmt_offset;
} else {
    $gmt_offset = '-'.$gmt_offset;
}
$task_status        = get_post_meta($order_id, '_task_status', true);
$task_status        = !empty($task_status) ? $task_status : '';
$gmt_time           = current_time('mysql', 1);
$menu_order         = taskbot_list_tasks_status();
$order_type         = $task_status;
$task_title         = get_the_title($task_id);
unset($menu_order['any']);
// check in query string if we have activity_id, it appears when buyers access page using link from "Order Complete Request" email
$activity_id        = (isset($_GET['activity_id']) && !empty($_GET['activity_id']) ? $_GET['activity_id'] : 0);
$taskbot_subtask_id = !empty($taskbot_subtask_id) ? $taskbot_subtask_id : 0;
?>
<div class="tb-main-section">
    <div class="container">
        <div class="row gy-4">
            <?php taskbot_get_template_part('dashboard/dashboard', 'sellers-dispute-notificaton'); ?>
            <div class="col-lg-12">
                <?php if (!empty($activity_id) && !empty($task_status) && $task_status === 'hired') { ?>
                    <div class="tb-orderrequest tb-finaldelivery-alert">
                        <div class="tb-ordertitle">
                            <h5><?php esc_html_e('Final revision approval request', 'taskbot'); ?></h5>
                            <p><?php esc_html_e('You have received a final revision request from the seller, you can accept or reject', 'taskbot'); ?></p>
                        </div>
                        <div class="tb-orderbtn">
                            <a class="tb-btnlink" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModalv2"><?php esc_html_e('Reject request', 'taskbot'); ?></a>
                            <a class="tb-btn tb_approval_task_action" href="javascript:void(0);" data-title="<?php echo esc_attr($task_title); ?>" data-order_id="<?php echo intval($order_id); ?>" data-task_id="<?php echo intval($task_id); ?>"><?php esc_html_e('Approve request', 'taskbot'); ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-12 col-lg-8 col-md-12">
                <div class="tb-requestarea">
                    <div class="tb-profile-steps buyer-task-detail">
                        <div class="tb-tabbitem__list">
                            <div class="tb-deatlswithimg">
                                <div class="tb-icondetails">
                                    <?php do_action('taskbot_task_order_status', $order_id); ?>
                                    <?php if (!empty($task_id)) {
                                        echo do_action('taskbot_task_categories', $task_id, 'product_cat');                                       
                                    }?>
                                    <span></span>
                                    <h6><a href="<?php echo get_the_permalink($task_id); ?>"><?php echo esc_html($task_title); ?></a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="tb-extras tb-extrascompleted">
                            <?php do_action('taskbot_task_author', $seller_id); ?>
                            <?php do_action('taskbot_delivery_date', $order_id); ?>
                            <?php do_action('taskbot_price_plan', $order_id); ?>
                            <?php do_action('taskbot_order_linked', $order_id); ?>
                        </div>
                    </div>
                    <?php taskbot_get_template_part('dashboard/dashboard', 'task-feature'); ?>
                    <?php if (!empty($order_details['subtasks']) && is_array($order_details['subtasks'])) { ?>
                        <div class="tb-additonolservices">
                            <div class="tb-additonoltitle" data-bs-toggle="collapse" data-bs-target="#tb-additionolinfo" aria-expanded="true" role="button">
                                <h5><?php esc_html_e('Additional add-ons:', 'taskbot'); ?> <span>
                                <?php echo wp_sprintf( _n( '%s Addon requested', '%s Add-ons requested', count($product_data['subtasks']), 'taskbot' ), count($product_data['subtasks']) );?>    
                               <i class="tb-icon-chevron-down"></i>
                            </div>
                            <div id="tb-additionolinfo" class="tb-addservices_details collapse show">
                                <div class="tb-additionolinfo">
                                    <ul class="tb-additionollist">
                                        <?php
                                        foreach ($order_details['subtasks'] as $subtask) {
                                            $subtask_title  = !empty($subtask['title']) ? $subtask['title'] : '';
                                            $price          = !empty($subtask['price']) ? $subtask['price'] : 0;
                                            ?>
                                            <li>
                                                <h6><?php echo esc_html($subtask_title); ?><span>( +<?php taskbot_price_format($price); ?> )</span></h6>
                                                <?php echo wpautop( apply_filters('the_content', get_the_content(null, false, $taskbot_subtask_id))); ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php taskbot_get_template_part('dashboard/dashboard', 'tasks-activity-history'); ?>
                </div>
            </div>
            <?php if (!empty($order_id)) { ?>
                <div class="col-sm-12 col-lg-4 col-md-12">
                    <aside>
                        <div class="tb-asideholder tb-taskdeadline">
                            <?php if (!empty($order_details)) { ?>
                                <?php do_action('taskbot_order_budget_details', $order_id, $user_type); ?>
                            <?php } ?>
                            <div class="tb-taskdeadline">
                                <?php if (!empty($task_status) && $task_status === 'hired') { ?>

                                    <div class="tb-taskcountdown">
                                        <?php if (!empty($hide_deadline) && $hide_deadline === 'no' && !empty($tb_order_date) && strtotime($tb_order_date) > strtotime($gmt_time)) { ?>
                                            <h6><?php esc_html_e('Task deadline', 'taskbot'); ?></h6>
                                            <ul class="tb-countdownno">
                                                <li><?php esc_html_e('D:', 'taskbot'); ?><span class="days"></span></li>
                                                <li><?php esc_html_e('H:', 'taskbot'); ?><span class="hours"></span></li>
                                                <li><?php esc_html_e('M:', 'taskbot'); ?><span class="minutes"></span></li>
                                                <li><?php esc_html_e('S:', 'taskbot'); ?><span class="seconds"></span></li>
                                            </ul>
                                        <?php } ?>
                                        <div class="tb-actionselect">
                                            <div class="tb-select">
                                                <select id="tb_order_status" class="form-control">
                                                    <?php foreach ($menu_order as $key => $val) {
                                                        $selected   = '';
                                                        if (!empty($order_type) && $order_type == $key) {
                                                            $selected   = 'selected';
                                                        } ?>
                                                        <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($val); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="tb-deadlinebtn">
                                                <button type="submit" data-title="<?php echo esc_attr($task_title); ?>" data-order_id="<?php echo intval($order_id); ?>" data-task_id="<?php echo intval($task_id); ?>" class="tb-btnvtwo tb_task_action"><i class="tb-icon-check"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($task_status) && $task_status === 'hired' || $task_status === 'cancelled') { ?>
                                    <div class="tb-raisedispute">
                                        <?php $dispute_args = array(
                                            'posts_per_page'    => -1,
                                            'post_type'         => array('disputes'),
                                            'orderby'           => 'ID',
                                            'order'             => 'DESC',
                                            'post_status'       => 'any',
                                            'suppress_filters'  => false,
                                            'meta_query'    => array(
                                                'relation'  => 'AND',
                                                array(
                                                    'key'       => '_dispute_order',
                                                    'value'     => $order_id,
                                                    'compare'   => '='
                                                )
                                            )
                                        );
                                        $dispute_is         = get_posts($dispute_args);
                                        $dispute            = !empty($dispute_is['0']) ? $dispute_is['0'] : 0;
                                       
                                        if (!empty($dispute->ID) && in_array(get_post_status($dispute->ID), array('publish', 'processing', 'pending'))) { ?>
                                            <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('disputes', $current_user->ID, false, 'detail',$dispute->ID);?>" class="tb-btn"><?php esc_html_e('Refund requested', 'taskbot'); ?></a>
                                        <?php } elseif (!empty($dispute->ID) && get_post_status($dispute->ID) == 'refunded') { ?>
                                            <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('disputes', $current_user->ID, false, 'detail',$dispute->ID);?>" class="tb-btn"><?php esc_html_e('Refunded', 'taskbot'); ?></a>
                                        <?php } elseif (!empty($dispute->ID) && get_post_status($dispute->ID) == 'resolved') { ?>
                                            <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('disputes', $current_user->ID, false, 'detail',$dispute->ID);?>" class="tb-btn"><?php esc_html_e('Resolved', 'taskbot'); ?></a>
                                        <?php } elseif (!empty($dispute->ID) && !in_array(get_post_status($dispute->ID), array('publish', 'processing', 'pending', 'disputed', 'cancelled'))) { ?>
                                            <span id="taskdisputerequest" data-dispute_id="<?php echo intval($dispute->ID); ?>" class="tb-btn"><?php esc_html_e('Create dispute request', 'taskbot'); ?></span>
                                        <?php } elseif (!empty($dispute->ID) && get_post_status($dispute->ID) == 'disputed') { ?>
                                            <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('disputes', $current_user->ID, false, 'detail',$dispute->ID);?>" class="tb-btn"><?php esc_html_e('Dispute created', 'taskbot'); ?></a>
                                        <?php } elseif (!empty($dispute->ID) && get_post_status($dispute->ID) == 'cancelled') { ?>
                                            <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('disputes', $current_user->ID, false, 'detail',$dispute->ID);?>" class="tb-btn"><?php esc_html_e('Dispute cancelled', 'taskbot'); ?></a>
                                        <?php } else { ?>
                                            <span id="taskrefundrequest" class="tb-btn"><?php esc_html_e('Create refund request', 'taskbot'); ?></span>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </aside>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php if (!empty($activity_id) && !empty($task_status) && $task_status === 'hired' || $task_status === 'cancelled') { ?>
    <!-- Request Modal End-->
    <div class="modal fade" id="exampleModalv2" tabindex="-1" role="dialog" aria-hidden="true">
        <form class="tb-themeform tb-activity-reject-chat-form">
            <div class="modal-dialog tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h4><?php esc_html_e('Reject revision request', 'taskbot'); ?></h4>
                        <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" name="rejection_reason" placeholder="<?php esc_attr_e('Enter description', 'taskbot'); ?>"></textarea>
                        <div class="tb-popupbtnarea">
                            <a href="javascript:void(0)" class="tb-btn tb-submit-revision-reject-request" data-id="<?php echo esc_attr($order_id); ?>" data-activity_id="<?php echo esc_attr($activity_id); ?>"><?php esc_html_e('Submit', 'taskbot'); ?><span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Request Modal End-->
<?php } ?>
<?php
if (!empty($task_status) && $task_status === 'hired' || $task_status === 'cancelled') {
    $script = "
    jQuery(document).on('ready', function($){
        taskbot_countdown_by_date('" . esc_js($tb_order_date) . "'," . esc_js($gmt_offset) . ");
        jQuery('#tb_order_status').select2({
           theme: 'default tk-select2-dropdown'
        });
    });
    ";
    wp_add_inline_script('taskbot', $script, 'after');
    ?>
    <script type="text/template" id="tmpl-load-task-refund-request">
        <div class="modal-dialog tb-modaldialog" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4><?php echo esc_html($taskbot_refund_title); ?></h4>
                    <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <div class="tb-popupbodytitle">
                        <?php echo html_entity_decode($taskbot_refund_subheading); ?>
                    </div>
                   <form name="refund-request" id="task-refund-request">
                       <input type="hidden" name="order_id" value="<?php echo intval($order_id); ?>">
                       <input type="hidden" name="seller_id" value="<?php echo intval($seller_id); ?>">
                       <input type="hidden" name="task_id" value="<?php echo intval($task_id); ?>">
                        <div class="tb-disputelist">
                            <ul class="tb-radiolist">
                                <?php if (!empty($buyer_dispute_issues)) {
                                    foreach ($buyer_dispute_issues as $key => $issue) { ?>
                                        <li>
                                            <div class="tb-radio">
                                                <input type="radio" id="f-option-<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($issue); ?>" name="dispute_issue">
                                                <label for="f-option-<?php echo esc_attr($key); ?>"><?php echo esc_html($issue); ?></label>
                                            </div>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        </div>
                        <div class="tb-popupbodytitle">
                            <h5><?php esc_html_e('Add dispute details', 'taskbot'); ?></h5>
                        </div>
                        <textarea class="form-control" placeholder="<?php esc_attr_e('Enter dispute details', 'taskbot'); ?>" id="dispute-details" name="dispute-details"></textarea>
                        <div class="tb-popupbtnarea">
                            <div class="tb-checkterm">
                                <div class="tb-checkbox">
                                    <input id="check3" type="checkbox" name="dispute_terms">
                                    <label for="check3">
                                        <span>
                                            <?php echo sprintf(esc_html__('By clicking you agree with our %s and %s', 'taskbot'), $term_link, $privacy_link); ?>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <a href="javascript:void(0);" id="taskrefundrequest-submit" class="tb-btn"><?php esc_html_e('Submit', 'taskbot'); ?> <span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </script>
<?php
}
