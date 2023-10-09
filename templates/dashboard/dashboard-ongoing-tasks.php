<?php
/**
 * Ongoing Tasks
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user,$taskbot_settings;
$task_downloadable    =  !empty($taskbot_settings['task_downloadable']) ? $taskbot_settings['task_downloadable'] : '';
$show_posts 	      = get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$user_identity 	    = !empty($_GET['identity']) ? intval($_GET['identity']) : intval($current_user->ID);
$user_type		      = apply_filters('taskbot_get_user_type', $user_identity );
$user_type_key      =  ($user_type === 'buyers') ? 'seller_id' : 'buyer_id';
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

if (!class_exists('WooCommerce')) {
    return;
}

$meta_query_args  = array();

$order 			      = 'DESC';
$sorting 		      = 'date';
$order_status     = array('wc-completed', 'wc-pending', 'wc-on-hold', 'wc-cancelled', 'wc-refunded', 'wc-processing');

$taskbot_args = array(
  'post_type'       => 'shop_order',
  'post_status' 		=> $order_status,
  'posts_per_page'  => $show_posts,
  'paged'           => $paged,
  'orderby'         => $sorting,
  'order'           => $order,
);

if($user_type === 'buyers'){
  $meta_query_args[] = array(
    'key' 		      => 'buyer_id',
    'value' 	      => $user_identity,
    'compare' 	    => '='
  );
} else{
  $meta_query_args[] = array(
    'key' 		      => 'seller_id',
    'value' 	      => $user_identity,
    'compare' 	    => '='
  );
}
$meta_query_args[] = array(
  'key' 		     => 'payment_type',
  'value' 	     => 'tasks',
  'compare' 	   => '='
);

$meta_query_args[] = array(
  'key' 		     => '_task_status',
  'value' 	     => 'hired',
  'compare' 	   => '='
);

$query_relation = array('relation' => 'AND',);
$taskbot_args['meta_query'] = array_merge($query_relation, $meta_query_args);

$tasks_result       = new WP_Query( apply_filters('taskbot_service_ongoing_listings_args', $taskbot_args) );
$found_tasks        = $tasks_result->found_posts;
?>
<div class="tb-sort">
    <h3><?php esc_html_e('Ongoing tasks','taskbot'); ?></h3>
</div>
<?php
if( $tasks_result->have_posts() ){
    while ($tasks_result->have_posts()) {
        $tasks_result->the_post();
        global $post;
        $order_id       = $post->ID;
        $task_id        = get_post_meta( $order_id, 'task_product_id', true);
        $task_id        = !empty($task_id) ? $task_id : 0;
        $task_title     = !empty($task_id) ? get_the_title( $task_id ) : '';

        $order 		      = wc_get_order($order_id);
        $order_price    = $order->get_total();
        if(function_exists('wmc_revert_price')){
          $order_price  = wmc_revert_price($order->get_total(),$order->get_currency());
        } 

        $order_price    = !empty($order_price) ? $order_price : 0;

        $buyer_id       = get_post_meta( $order_id, $user_type_key, true);
        $buyer_id       = !empty($buyer_id) ? intval($buyer_id) : 0;
        $link_id        = taskbot_get_linked_profile_id( $buyer_id,'',$user_type );
        $is_verified    = !empty($link_id) ? get_post_meta( $link_id, '_is_verified',true) : '';
        $user_name      = taskbot_get_username($link_id);

        $product_data   = get_post_meta( $order_id, 'cus_woo_product_data', true);
        $product_data   = !empty($product_data) ? $product_data : array();
        $task_type      = get_post_meta( $order_id, '_task_type', true);
        
        if( !empty($user_type) && ($user_type === 'sellers') ) {
          $order_price    = get_post_meta( $order_id, 'seller_shares', true);
          $order_price    = !empty($order_price) ? ($order_price) : 0;
        }
        
        $downloadable   = get_post_meta( $task_id, '_downloadable', true);
        $downloadable   = !empty($downloadable) ? ucfirst($downloadable) : 0;
       
        $product        = !empty($task_id) ? wc_get_product( $task_id ) : array();

        $order_url              = Taskbot_Profile_Menu::taskbot_profile_menu_link('tasks-orders', $user_identity, true, 'detail',$order_id);
        $taskbot_service_views  = get_post_meta( $task_id, 'taskbot_service_views', TRUE );
        $taskbot_service_views  = !empty($taskbot_service_views) ? intval($taskbot_service_views) : 0;
        ?>
        <div class="tb-tasksitem">
            <div class="tb-tasksitem_head">
                <div class="tb-cards__title">
                    <span class="tk-username">
                        <?php echo esc_html($user_name); ?>
                        <?php if( !empty($is_verified) && $is_verified === 'yes'){?>
                            <i class="tb-icon-check-circle" <?php echo apply_filters('taskbot_tooltip_attributes', 'verified_user');?>></i>
                        <?php } ?>
                    </span>
                    <h5><a href="<?php echo esc_url($order_url);?>"><?php echo esc_html($task_title); ?></a></h5>
                    <ul class="tb-rateviews">
                        <?php 
                            do_action('taskbot_service_rating_count', $product); 
                            do_action('taskbot_service_item_views', $product);
                        ?>
                        <li>
                            <div class="tk-likev2"><?php do_action( 'taskbot_project_saved_item', $task_id,'','_saved_tasks','list' );?></div>
                        </li>
                    </ul>
                </div>
                <div class="tb-startingprice">
                    <i><?php esc_html_e('Total task budget','taskbot'); ?>:</i>
                    <span><?php taskbot_price_format($order_price);?></span>
                </div>
            </div>
            <div class="tb-tasksitem__footer">
                <ul class="tb-sales">
                    <?php do_action( 'taskbot_service_sales', $product );?>
                    <?php do_action( 'taskbot_service_delivery_time', $product ); ?>
                    <?php 
                      if( !empty($task_downloadable) ){
                          do_action( 'taskbot_service_download', $product );
                      }
                    ?>
                </ul>
                <div class="tb-tasksitem__btn">
                    <a href="<?php echo esc_url($order_url);?>"
                        class="tb-btn tb-btnv2"><?php esc_html_e('View details','taskbot'); ?></a>
                </div>
            </div>
        </div>
    <?php }
    
    taskbot_paginate($tasks_result);
} else {
    do_action( 'taskbot_empty_listing', esc_html__('No ongoing task', 'taskbot'));
}

wp_reset_postdata();
