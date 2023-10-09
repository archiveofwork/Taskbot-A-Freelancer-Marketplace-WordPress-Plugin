<?php
/**
 * Seller task detail
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global  $current_user,$taskbot_settings;
$order_id                   = !empty($_GET['id']) ? intval($_GET['id']) : 0;
$user_identity 	            = !empty($_GET['identity']) ? intval($_GET['identity']) : 0;
$seller_dispute_issues      = !empty($taskbot_settings['seller_dispute_issues']) ? $taskbot_settings['seller_dispute_issues'] : array();
$hide_deadline  = !empty($taskbot_settings['hide_deadline']) ? $taskbot_settings['hide_deadline'] : 'no';

$tpl_terms_conditions   = !empty( $taskbot_settings['tpl_terms_conditions'] ) ? $taskbot_settings['tpl_terms_conditions'] : '';
$tpl_privacy            = !empty( $taskbot_settings['tpl_privacy'] ) ? $taskbot_settings['tpl_privacy'] : '';
$term_link              = !empty($tpl_terms_conditions) ? '<a target="_blank" href="'.get_the_permalink($tpl_terms_conditions).'">'.get_the_title($tpl_terms_conditions).'</a>' : '';
$privacy_link           = !empty($tpl_privacy) ? '<a target="_blank" href="'.get_the_permalink($tpl_privacy).'">'.get_the_title($tpl_privacy).'</a>' : '';

$task_id    = get_post_meta( $order_id, 'task_product_id', true);
$task_id    = !empty($task_id) ? $task_id : 0;

if (!class_exists('WooCommerce')) {
    return;
}

$order 		    = wc_get_order($order_id);
$order_price    = $order->get_total();
$order_price    = !empty($order_price) ? $order_price : 0;
$seller_id      = get_post_meta( $order_id, 'seller_id', true);
$seller_id      = !empty($seller_id) ? intval($seller_id) : 0;

$buyer_id       = get_post_meta( $order_id, 'buyer_id', true);
$buyer_id       = !empty($buyer_id) ? intval($buyer_id) : 0;

$admin_shares   = get_post_meta( $order_id, 'admin_shares', true);
$admin_shares   = !empty($admin_shares) ? ($admin_shares) : 0;
$seller_shares  = get_post_meta( $order_id, 'seller_shares', true);
$seller_shares  = !empty($seller_shares) ? ($seller_shares) : 0;
$product_data   = get_post_meta( $order_id, 'cus_woo_product_data', true);
$product_data   = !empty($product_data) ? $product_data : array();
$order_details  = get_post_meta( $order_id, 'order_details', true);
$order_details  = !empty($order_details) ? $order_details : array();
$items 		    = $order->get_items();
$get_taxes		= $order->get_taxes();
$tb_order_gmt   = get_post_meta( $order_id, 'delivery_date', true);
$tb_order_gmt   = !empty($tb_order_gmt) ? intval($tb_order_gmt) : 0;
$tb_order_date  = !empty($tb_order_gmt) ? date('Y/m/d H:i:s',$tb_order_gmt) : '';
$gmt_offset         = get_option('gmt_offset');
if($gmt_offset > 0 ){
    $gmt_offset = '+'.$gmt_offset;
} else {
    $gmt_offset = '-'.$gmt_offset;
}
$task_status    = get_post_meta( $order_id, '_task_status', true);
$task_status    = !empty($task_status) ? $task_status : '';
$gmt_time		= current_time( 'mysql', 1 );
$order_type     = $task_status;
$order_status   = $order->get_status();
$dispute_id     = get_post_meta( $order_id, 'dispute_id', true);
$dispute_id     = !empty($dispute_id) ? $dispute_id : 0;


?>
<section class="tb-main-section">
    <div class="container">
        <div class="row">
            <?php taskbot_get_template_part('dashboard/dashboard', 'sellers-dispute-notificaton'); ?>
            <div class="col-sm-12 col-lg-8 col-md-12">
                <div class="tb-requestarea">
                    <div class="tb-profile-steps seller-task-detail">
                        <div class="tb-tabbitem__list">
                            <div class="tb-deatlswithimg">
                                <div class="tb-icondetails">
                                    <?php do_action( 'taskbot_task_order_status', $order_id );?>
                                    <?php if( !empty($task_id) ){ echo do_action('taskbot_task_categories', $task_id, 'product_cat'); } ?>
                                    <span></span>
                                    <h6><a href="<?php echo get_the_permalink( $task_id );?>"><?php echo get_the_title($task_id);?></a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="tb-extras tb-extrascompleted">
                            <?php do_action( 'taskbot_task_author', $buyer_id,'buyers');?>
                            <?php do_action( 'taskbot_delivery_date', $order_id );?>
                            <?php do_action( 'taskbot_price_plan', $order_id );?>
                            <?php do_action('taskbot_order_linked', $order_id); ?>
                        </div>
                    </div>
                    <?php taskbot_get_template_part('dashboard/dashboard', 'task-feature'); ?>
                    <?php if( !empty($order_details['subtasks']) && is_array($order_details['subtasks']) ){?>
                        <div class="tb-additonolservices">
                            <div class="tb-additonoltitle" data-bs-toggle="collapse" data-bs-target="#tb-additionolinfo"
                                aria-expanded="true" role="button">
                                <h5><?php esc_html_e('Additional services','taskbot');?>
                                    <span><?php echo wp_sprintf( _n( '%s Addon requested', '%s Add-ons requested', count($product_data['subtasks']), 'taskbot' ), count($product_data['subtasks']) );?></span>
                                </h5>
                                <i class="tb-icon-chevron-down"></i>
                            </div>
                            <div id="tb-additionolinfo" class="tb-addservices_details collapse show">
                                <div class="tb-additionolinfo">
                                    <ul class="tb-additionollist">
                                        <?php
                                        foreach($order_details['subtasks'] as $subtask ){
                                            $subtask_title      = !empty($subtask['title']) ? $subtask['title'] : '';
                                            $price              = !empty($subtask['price']) ? $subtask['price'] : 0;
                                            $taskbot_subtask_id = !empty($subtask['id']) ? $subtask['id'] : 0;
                                        ?>
                                        <li>
                                            <h6><?php echo esc_html($subtask_title);?><span>(+<?php taskbot_price_format($price);?> )</span></h6>
                                            <?php echo wpautop( apply_filters( 'the_content', get_the_content(null, false, $taskbot_subtask_id)) );?>
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
            <?php if( !empty($seller_shares) ){?>
                <div class="col-sm-12 col-lg-4 col-md-12">
                    <aside>
                        <div class="tb-asideholder tb-taskdeadline">
                            <div class="tb-asidebox tb-additonoltitleholder">
                                <div data-bs-toggle="collapse" data-bs-target="#tb-additionolinfov2" aria-expanded="true"
                                    role="button">
                                    <div class="tb-additonoltitle">
                                        <div class="tb-startingprice">
                                            <i><?php esc_html_e('Total task budget','taskbot');?></i>
                                            <span><?php taskbot_price_format($seller_shares); ?></span>
                                        </div>
                                        <?php if( !empty($order_details['subtasks']) || !empty($admin_shares) ){?>
                                            <i class="tb-icon-chevron-down"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if( !empty($order_details['subtasks']) || !empty($admin_shares) ){?>
                                <div id="tb-additionolinfov2" class="show">
                                    <div class="tb-budgetlist">
                                        <ul class="tb-planslist">
                                            
                                        <?php if( !empty($order_details['title']) && !empty($order_details['price'])){ ?>
                                            <li>
                                                <h6><?php echo esc_html($order_details['title']);?>
                                                <span>(<?php taskbot_price_format($order_details['price']);?>)</span></h6>
                                            </li>
                                            <?php }?>

                                            <?php 
                                                if( !empty($order_details['subtasks']) ){
                                                    foreach($order_details['subtasks'] as $subtask ){
                                                        $subtask_title  = !empty($subtask['title']) ? $subtask['title'] : '';
                                                        $price          = !empty($subtask['price']) ? $subtask['price'] : 0;
                                                        if(function_exists('wmc_revert_price')){
                                                            $price  = wmc_revert_price($price,$order->get_currency());
                                                        } 
                                                    ?>
                                                        <li>
                                                            <h6><?php echo esc_html($subtask_title);?><span>(<?php taskbot_price_format($price);?>)</span></h6>
                                                        </li>
                                                <?php } 
                                                }?>
                                        </ul>

                                        <?php if(!empty($admin_shares)){?>
                                            <ul class="tb-planslist tb-texesfee">
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <h6>
                                                            <?php esc_html_e('Admin commission','taskbot');?>&nbsp;<span>(<?php taskbot_price_format($admin_shares);?>)</span>
                                                        </h6>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php }?>
                                        <ul class="tb-planslist tb-totalfee">
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <h6><?php esc_html_e('You will get','taskbot');?><span>(<?php taskbot_price_format($seller_shares); ?>)</span></h6>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if( !empty($task_status) && $task_status === 'hired'){?>
                                <div class="tb-taskdeadline">
                                    <?php if(!empty($hide_deadline) && $hide_deadline === 'no' && !empty($tb_order_date) && strtotime($tb_order_date) > strtotime($gmt_time)){?>
                                        <div class="tb-taskcountdown">
                                            <h6><?php esc_html_e('Task deadline','taskbot');?></h6>
                                            <ul class="tb-countdownno">
                                                <li>
                                                    <?php esc_html_e('D:','taskbot');?>
                                                    <span class="days"></span>
                                                </li>
                                                <li>
                                                    <?php esc_html_e('H:','taskbot');?>
                                                    <span class="hours"></span>
                                                </li>
                                                <li>
                                                    <?php esc_html_e('M:','taskbot');?>
                                                    <span class="minutes"></span>
                                                </li>
                                                <li>
                                                    <?php esc_html_e('S:','taskbot');?>
                                                    <span class="seconds"></span>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    <?php if(empty($dispute_id) ){?>
                                        <div class="tb-raisedispute">
                                            <span class="tb-btn" id="taskrefundrequest"><?php esc_html_e('Create dispute','taskbot');?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                          <?php } ?>
                        </div>
                    </aside>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<script type="text/template" id="tmpl-load-task-refund-request">
    <div class="modal-dialog tb-modaldialog" role="document">
        <div class="modal-content">
            <div class="tb-popuptitle">
                <h4><?php esc_html_e('Create refund request', 'taskbot') ?></h4>
                <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
            </div>
            <div class="modal-body">
                <div class="tb-popupbodytitle">
                    <?php esc_html_e('Choose issue you want to highlight', 'taskbot') ?>
                </div>
            <form name="refund-request" id="task-refund-request">
                <input type="hidden" name="order_id" value="<?php echo intval($order_id); ?>">
                <input type="hidden" name="task_id" value="<?php echo intval($task_id); ?>">
                    <div class="tb-disputelist">
                        <ul class="tb-radiolist">
                            <?php if (!empty($seller_dispute_issues)) {
                                foreach ($seller_dispute_issues as $key => $issue) { ?>
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
                        <a href="javascript:void(0);" id="seller-request-submit" class="tb-btn"><?php esc_html_e('Submit', 'taskbot'); ?> <span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</script>
<?php
if( !empty($task_status) && $task_status === 'hired' ){
    $script = "
        jQuery(document).on('ready', function(){
            taskbot_countdown_by_date('" . esc_js($tb_order_date) . "'," . esc_js($gmt_offset) . ");
        });
    ";
    wp_add_inline_script( 'taskbot', $script, 'after' );
}
