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
$proposal_id    = !empty($args['proposal_id']) ? intval($args['proposal_id']) : 0;
$user_identity  = !empty($args['user_identity']) ? intval($args['user_identity']) : 0;

if (!class_exists('WooCommerce')) {
    return;
}

$dispute_id     = get_post_meta( $proposal_id, 'dispute_id', true);
$dispute_id     = !empty($dispute_id) ? $dispute_id : 0;

$buyer_id       = get_post_meta( $dispute_id, '_buyer_id',true );
$buyer_id       = !empty($buyer_id) ? intval($buyer_id) : 0;

$seller_id       = get_post_meta( $dispute_id, '_seller_id',true );
$seller_id       = !empty($seller_id) ? intval($seller_id) : 0;

$order 		    = wc_get_order($proposal_id);
$order_status   = get_post_status($proposal_id);
$task_status    = get_post_meta( $proposal_id, '_task_status', true);
$task_status    = !empty($task_status) ? $task_status : '';


$dispute_detail_url	= Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $user_identity, true, 'dispute');
$dispute_detail_url	= !empty($dispute_id) ? add_query_arg('id', $dispute_id, $dispute_detail_url) : '';	
$post_author        = !empty($dispute_id) ? get_post_field( 'post_author', $dispute_id ) : 0;
$dispute_status     = !empty($dispute_id) ? get_post_status( $dispute_id ) : '';
if( !empty($seller_id) && $seller_id == $user_identity ){
    if(!empty($dispute_id) && $order_status == 'disputed' && !empty($dispute_status) && in_array($dispute_status,array('disputed','publish')) ){
        
        ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <?php if( !empty($post_author) && $post_author == $user_identity){?>
                        <h5><?php esc_html_e('Dispute created', 'taskbot');?></h5>
                        <p><?php esc_html_e('You have created a dispute for this order. You can check the status by clicking the link below.', 'taskbot');?></p>
                    <?php } else {?>
                        <h5><?php esc_html_e('Refund requested', 'taskbot');?></h5>
                        <p><?php esc_html_e('The buyer has created a refund request for this order, you can process or decline this refund request', 'taskbot');?></p>
                    <?php } ?>
                </div>
                <div class="tb-orderbtn">
                    <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
    <?php } elseif (!empty($dispute_id) && ($order_status == 'refunded' || $order_status == 'cancelled')) { ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refunded/Cancelled', 'taskbot');?></h5>
                    <p><?php esc_html_e('This order was refunded, you can check more detail on the refund and dispute page', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                    <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View Details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
    <?php } elseif (empty($dispute_id) && !empty($order_status)  && $order_status == 'cancelled') {?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Order cancelled', 'taskbot');?></h5>
                    <p><?php esc_html_e('Buyer has cancelled this order, if you think this is not good then you can create a dispute for this order', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                    <span id="taskrefundrequest" class="tb-btn btn-orange"><?php esc_html_e('Create dispute', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
        
    <?php } elseif ( !empty($dispute_id) && !empty($dispute_status) && $dispute_status === 'declined' ) {?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund declined', 'taskbot');?></h5>
                    <p><?php esc_html_e('You have declined the refund request for this order. You may create the dispute for this order', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                    <span class="tb-btn btn-orange" id="taskdisputerequest" data-dispute_id="<?php echo intval($dispute_id); ?>"><?php esc_html_e('Create dispute', 'taskbot');?></span>
                </div>
            </div>                   
        </div>
    <?php } elseif ( !empty($dispute_id) && !empty($dispute_status) && $dispute_status === 'declined' ) {?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund declined', 'taskbot');?></h5>
                    <p><?php esc_html_e('You have declined the refund request for this order. You may create the dispute for this order', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                    <span class="tb-btn btn-orange" id="taskdisputerequest" data-dispute_id="<?php echo intval($dispute_id); ?>"><?php esc_html_e('Create dispute', 'taskbot');?></span>
                </div>
            </div>                   
        </div>
    <?php } else if(!empty($dispute_status) && $dispute_status === 'refunded'){ 
         $winning_party = get_post_meta( $dispute_id, 'winning_party',true );
         $resolved_by   = get_post_meta( $dispute_id, 'resolved_by',true );
         $resolved_by   = !empty($resolved_by) && $resolved_by === 'sellers' ? esc_html__('Seller','taskbot') : esc_html__('Admin','taskbot');
         if( !empty($winning_party) && intval($winning_party) === intval($user_identity) ){  ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-alert-success">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund approved', 'taskbot');?></h5>
                    <p><?php echo sprintf(esc_html__('The %s has approved your refund request, the amount has been added to your wallet. You can use this amount for your next order', 'taskbot'),$resolved_by);?></p>
                </div>
                <div class="tb-orderbtn">
                    <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View Details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
    <?php } else { ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund', 'taskbot');?></h5>
                    <p><?php esc_html_e('This order was refunded, you can check more detail on the refund and dispute page.', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View Details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
    <?php } }
} elseif( !empty($buyer_id) && $buyer_id === $user_identity && !empty($dispute_id)){ 
    if(!empty($dispute_status) && $dispute_status === 'disputed'){ ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <?php if( !empty($post_author) && intval($post_author) == intval($user_identity) ){?>
                        <h5><?php esc_html_e('Dispute created', 'taskbot');?></h5>
                        <p><?php esc_html_e('You have created a dispute for this order. You can check the status by clicking the link below.', 'taskbot');?></p>
                    <?php } else {?>
                        <h5><?php esc_html_e('Dispute created', 'taskbot');?></h5>
                        <p><?php esc_html_e('The seller has created a dispute against that order, admin will review the history of this order and make the final decision', 'taskbot');?></p>
                    <?php } ?>
                </div>
                <div class="tb-orderbtn">
                    <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
    <?php } else if(!empty($dispute_status) && $dispute_status === 'publish'){ 
         $buyer_dispute_days	= !empty($taskbot_settings['buyer_dispute_option'])	? intval($taskbot_settings['buyer_dispute_option']) : 5;
         $post_date             = !empty($dispute_id) ? get_post_field( 'post_date', $dispute_id ) : 0;
         $disbuted_time         = !empty($post_date) ? strtotime($post_date. ' + '.intval($buyer_dispute_days).' days') : 0;
         $current_time          = current_time( 'mysql', 1 );
        ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund  request', 'taskbot');?></h5>
                    <p><?php esc_html_e('You have created a refund request for this order. You can check the status by clicking the link below.', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                    <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View Details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
        <?php if( !empty($disbuted_time) && $disbuted_time < $current_time ){ ?>
            <div class="col-lg-12">
                <div class="tb-orderrequest tb-orderrequestv2">
                    <div class="tb-ordertitle">
                        <h5><?php esc_html_e('Create dispute', 'taskbot');?></h5>
                        <p><?php esc_html_e('The seller has not replied to your refund request, you can now raise a dispute to acknowledge the admin', 'taskbot');?></p>
                    </div>
                    <div class="tb-orderbtn">
                        <span class="tb-btn btn-orange"  id="taskdisputerequest" data-dispute_id="<?php echo intval($dispute_id); ?>" ><?php esc_html_e('Create dispute', 'taskbot');?></span>
                    </div>
                </div>                   
            </div>
        <?php } ?>
    <?php } else if(!empty($dispute_status) && $dispute_status === 'declined'){ ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund declined', 'taskbot');?></h5>
                    <p><?php esc_html_e('The seller has declined your refund request, you can now create the dispute for this order.', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                    <span class="tb-btn btn-orange"  id="taskdisputerequest" data-dispute_id="<?php echo intval($dispute_id); ?>" ><?php esc_html_e('Create dispute', 'taskbot');?></span>
                </div>
            </div>                   
        </div>
    <?php } else if(!empty($dispute_status) && $dispute_status === 'refunded'){ 
        $winning_party  = get_post_meta( $dispute_id, 'winning_party',true );
        if( !empty($winning_party) && intval($winning_party) === intval($user_identity) ){
            $resolved_by    = get_post_meta( $dispute_id, 'resolved_by',true );
            $resolved_by    = !empty($resolved_by) && $resolved_by === 'sellers' ? esc_html__('seller','taskbot') : esc_html__('admin','taskbot');
        ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-alert-success">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund approved', 'taskbot');?></h5>
                    <p><?php echo sprintf(esc_html__('The %s has approved your refund request, the amount has been added to your wallet. You can use this amount for your next order', 'taskbot'),$resolved_by);?></p>
                </div>
                <div class="tb-orderbtn">
                    <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View Details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
    <?php } else { ?>
        <div class="col-lg-12">
            <div class="tb-orderrequest tb-orderrequestv2">
                <div class="tb-ordertitle">
                    <h5><?php esc_html_e('Refund', 'taskbot');?></h5>
                    <p><?php esc_html_e('This order was refunded, you can check more detail on the refund and dispute page.', 'taskbot');?></p>
                </div>
                <div class="tb-orderbtn">
                <a class="tb-btn btn-orange" href="<?php echo esc_url($dispute_detail_url);?>"><?php esc_html_e('View Details', 'taskbot');?></a>
                </div>
            </div>                   
        </div>
    <?php } ?>
<?php } ?>

<?php }
