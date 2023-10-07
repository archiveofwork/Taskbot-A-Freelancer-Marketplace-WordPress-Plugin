<?php
/**
 * Invoice listings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $wp_roles, $userdata, $post;

$reference      = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode           = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$sort_by        = !empty($_GET['sort_by']) ? esc_html($_GET['sort_by']) : '';
if( !empty($sort_by) && $sort_by == 'All' ){
    $sort_by    = '';
}
$user_identity  = intval($current_user->ID);
$id             = !empty($args['identity']) ? intval($args['identity']) : '';
$user_type      = apply_filters('taskbot_get_user_type', $user_identity);
$filter_types   = taskbot_invoice_order_types($user_type);
$date_format    = get_option( 'date_format' );
$pg_page        = get_query_var('page') ? get_query_var('page') : 1;
$pg_paged       = get_query_var('paged') ? get_query_var('paged') : 1;
$paged          = max($pg_page, $pg_paged);
$current_page   = $paged;
$per_page_itme  = get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$current_page_link  = Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, $mode);
$current_page_link  = !empty($current_page_link) ? $current_page_link : '';
?>
<section class="tb-main-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tb-dhb-mainheading">
                    <h2><?php esc_html_e('Invoices & bills', 'taskbot'); ?></h2>
                    <div class="tb-sortby">
                        <form class="tb-themeform tb-displistform" id="invoice-search-form" action="<?php echo esc_url( $current_page_link ); ?>">
                            <input type="hidden" name="ref" value="<?php echo esc_attr($reference); ?>">
                            <input type="hidden" name="identity" value="<?php echo esc_attr($user_identity); ?>">
                            <input type="hidden" name="mode" value="<?php echo esc_attr($mode); ?>">
                            <fieldset>
                                <div class="tb-themeform__wrap">
                                    <div class="wo-inputicon">
                                        <div class="tb-actionselect tb-actionselect2">
                                            <span><?php esc_html_e('Filter invoices', 'taskbot'); ?>: </span>
                                            <div class="tb-select">
                                                <select id="tb-invoice-sort" name="sort_by" class="form-control  tk-selectv tb-sorting-invoice invoice-sort-by" data-placeholder="<?php esc_attr_e('Select', 'taskbot'); ?>">
                                                    <option selected hidden><?php esc_html_e('All', 'taskbot'); ?></option>
                                                    <?php foreach($filter_types as $key => $val ){
                                                        $selected_filter  = '';
                                                        if( !empty($sort_by) && $sort_by == $key ){
                                                            $selected_filter  = 'selected';
                                                        } ?>
                                                        <option value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected_filter);?>><?php echo esc_html($val);?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <?php
                if (class_exists('WooCommerce')) {
                    if( !empty($sort_by) && $sort_by === 'projects' ){
                        $sort_by    = array('projects','hourly');
                    }
                    if (!empty($user_type) && $user_type === 'buyers') {
                        $order_arg  = array(
                        'page'          => $current_page,
                        'paginate'      => true,
                        'limit'         => $per_page_itme,
                        'buyer_id'     => $current_user->ID
                        );

                        if( !empty($sort_by) ){
                            $order_arg['payment_type']  = $sort_by;
                        }

                        $customer_orders = wc_get_orders( $order_arg );

                    } elseif (!empty($user_type) && $user_type === 'sellers') {

                        $order_arg  = array(
                            'page'          => $current_page,
                            'paginate'      => true,
                            'limit'         => $per_page_itme,
                            'seller_id'     => $current_user->ID,
                        );

                        if( !empty($sort_by) ){
                            $order_arg['payment_type']  = $sort_by;
                        }

                        $customer_orders = wc_get_orders( $order_arg );

                    }
                    ?>
                    <table class="table tb-table tb-invoicestable">
                        <thead>
                            <tr>
                                <th> <span> <?php esc_html_e('Invoice', 'taskbot'); ?> #  </span></th>
                                <th><?php esc_html_e('Payment type', 'taskbot'); ?></th>
                                <th><?php esc_html_e('Invoice date', 'taskbot'); ?></th>
                                <th><?php esc_html_e('Amount', 'taskbot'); ?></th>
                                <th><?php esc_html_e('Action', 'taskbot'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($customer_orders->orders)) {
                                $count_post = count($customer_orders->orders);
                                foreach ($customer_orders->orders as $order) {
                                    $payemnt_type_text  = '';
                                    $data_created = $order->get_date_created();
                                    $order_status  = $order->get_status();
                                    $payment_type = get_post_meta( $order->get_id(), 'payment_type',true );
                                    $order_total  = 0;

                                    if(!empty($payment_type) ){
                                        if($payment_type === 'package'){
                                            $payemnt_type_text  = esc_html__('Package subscription','taskbot');
                                        } else if($payment_type === 'wallet'){
                                            $payemnt_type_text  = esc_html__('Wallet amount','taskbot');
                                        } else if($payment_type === 'tasks'){
                                            if(!empty($order_status) && $order_status === 'refunded'){
                                                $payemnt_type_text  = esc_html__('Refunded','taskbot');
                                            }else{
                                                $payemnt_type_text  = esc_html__('Task hiring','taskbot');
                                            }
                                            $payemnt_type_text  = esc_html__('Task hiring','taskbot');
                                        }else if($payment_type === 'projects'){
                                            $payemnt_type_text  = esc_html__('Project hiring','taskbot');
                                        } else {
                                            $payemnt_type_text  = apply_filters( 'taskbot_filter_invoice_title', $order->get_id() );
                                        }
                                    }
                                    if(!empty($user_type) && $user_type === 'sellers'){
                                         $order_total   = get_post_meta($order->get_id(),'seller_shares',true  );
                                         $user_name     = $order->get_formatted_billing_full_name();
                                     } else {
                                         $task_product_id   = get_post_meta( $order->get_id(), 'task_product_id', true );
                                         $seller_id         = get_post_field( 'post_author', $task_product_id );
                                         $seller_id         = taskbot_get_linked_profile_id($seller_id, '', 'sellers');
                                         $user_name         = !empty($seller_id) ? taskbot_get_username($seller_id) : '';
                                         $order_total       = $order->get_total();
                                        if(function_exists('wmc_revert_price')){
                                            $order_total  = wmc_revert_price($order->get_total(),$order->get_currency());
                                        } 
                                     }
                                    
                                     if(!empty($payment_type) && ($payment_type === 'package' || $payment_type === 'wallet' )){
                                        $user_name      = $order->get_formatted_billing_full_name();
                                     }
                                    if(!empty($user_type) && $user_type === 'sellers' && !empty($payment_type) && $payment_type === 'package'){
                                        
                                        $order_total    = $order->get_total();
                                        if(function_exists('wmc_revert_price')){
                                            $get_total  = wmc_revert_price($order_total,$order->get_currency());
                                        }
                                    }

                                    $order_total        = !empty($order_total) ? $order_total : 0;
                                    $invoice_url        = Taskbot_Profile_Menu::taskbot_profile_menu_link('invoices', $user_identity, true, 'detail', intval($order->get_id()));
                                    $invoice_url        = apply_filters( 'taskbot_filter_invoice_url', $invoice_url, $order->get_id() );
                                    ?>
                                    <tr class="order-status-<?php echo esc_attr($order_status);?>">
                                        <td data-label="<?php esc_attr_e('Invoice  #','taskbot') ?>"><span><?php echo intval($order->get_id()); ?></span></td>
                                        <td data-label="<?php esc_attr_e('Name','taskbot') ?>"><a href="javascript:void(0);"><?php echo esc_html($payemnt_type_text); ?></a></td>
                                        <td data-label="<?php esc_attr_e('Invoice date','taskbot') ?>"><?php echo  date_i18n($date_format,strtotime($order->get_date_created())); ?></td>
                                        <td data-label="<?php esc_attr_e('Amount','taskbot') ?>">
                                            <span><?php taskbot_price_format($order_total); ?></span>
                                        </td>
                                        <td data-label="<?php esc_attr_e('Action','taskbot');?>">
                                            <ul class="tb-tabicon tb-invoicecon">
                                                <li><a target="_blank" href="<?php echo esc_url($invoice_url); ?>"><span class="icon-eye tb-blue"></span>&nbsp;<?php esc_html_e('View','taskbot') ?></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    taskbot_paginate($customer_orders);
                }

                if (empty($customer_orders->orders)) {
                    do_action( 'taskbot_empty_listing', esc_html__('No invoices & bills found', 'taskbot'));
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
$script = "
jQuery(document).on('ready', function(){
    jQuery(document).on('change', '.invoice-sort-by', function (e) {
        jQuery('#invoice-search-form').submit();
    });
});
";
wp_add_inline_script( 'taskbot', $script, 'after' );
