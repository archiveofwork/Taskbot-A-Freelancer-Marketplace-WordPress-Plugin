<?php
/**
 * The template part for displaying the dashboard Payouts History for seller
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/earning_template
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user;
$user_identity      = intval($current_user->ID);
$ref                = !empty($_GET['ref']) ? esc_html($_GET['ref']) : 'earnings';
$earning_page_link  = Taskbot_Profile_Menu::taskbot_profile_menu_link($ref, $user_identity, true, '');
$earning_page_link  = !empty($earning_page_link) ? $earning_page_link : '';

// variable to store all query args for search
$query_args   	= array();
$post_status  	= array('pending', 'publish');
$withdraw_id  	= (!empty($_GET['withdraw_id']) ? intval($_GET['withdraw_id']) : "");
$qs_ref       	= (!empty($_GET['ref'])      ? esc_html($_GET['ref'])      : '');
$qs_identity  	= (!empty($_GET['identity']) ? intval($_GET['identity']) : 0);
$sort_by_status = (!empty($_GET['sort_by']) ? esc_html($_GET['sort_by']) : "");

if (!empty($withdraw_id)){
    $filtered_args['post_in'] = array(
        'post__in' => array($withdraw_id),
    );
	
    $query_args = array_merge($query_args,$filtered_args['post_in']);
}

// if sort by status exists, then update the $post_status array
if (!empty($sort_by_status)){
    $post_status    = array($sort_by_status);
}

// standard $query_args as $withdraw_args
$paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$show_posts     = get_option('posts_per_page');
$withdraw_args  = array(
    'post_type'       => 'withdraw',
    'author'          => $user_identity,
    'post_status'     => $post_status,
    'posts_per_page'  => $show_posts,
    'paged'           => $paged,
);

$withdraw_args = array_merge_recursive($withdraw_args,$query_args);
$payrols		= taskbot_get_payouts_lists();

?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="tb-payouthistory">
                <div class="tb-dhb-mainheading">
                    <h2><?php esc_html_e('Payouts history','taskbot'); ?></h2>
                    <div class="tb-sortby">
                        <form class="tb-themeform tb-displistform" id="withdraw_search_form" action="<?php echo esc_url( $earning_page_link ); ?>">
                            <input type="hidden" name="ref" value="<?php echo esc_attr($qs_ref); ?>">
                            <input type="hidden" name="identity" value="<?php echo esc_attr($qs_identity); ?>">
                            <input type="hidden" name="sort_by" id="tb_sort_by_filter" value="<?php echo esc_attr($sort_by_status);?>">
                            <fieldset>
                                <div class="tb-themeform__wrap">
                                    <?php do_action('taskbot_withdraw_search', $withdraw_id);?>
                                    <?php do_action('taskbot_withdraw_sortby_filter', $sort_by_status);?>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <table class="table tb-table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Ref#','taskbot'); ?></th>
                            <th><?php esc_html_e('Status','taskbot'); ?></th>
                            <th><?php esc_html_e('Method','taskbot'); ?></th>
                            <th><?php esc_html_e('Date','taskbot'); ?></th>
                            <th><?php esc_html_e('Amount','taskbot'); ?></th>   
                            <th></th>
                        </tr>
                    </thead>
					<tbody>
						<?php
						$withdraw_query     = new WP_Query( apply_filters('taskbot_withdraw_listings_args', $withdraw_args) );
						$count_post 		= $withdraw_query->found_posts;
						if ( $withdraw_query->have_posts() ) :
							while ( $withdraw_query->have_posts() ) : $withdraw_query->the_post();
                                $post_id      = get_the_ID();
                                $date 		  = get_the_date();
                                $status       = get_post_status( $post_id );
                                if( !empty($status) && $status === 'publish' ){
                                    $status_text = esc_attr__( 'Approved', 'taskbot' );
                                }else if( !empty($status) && ( $status === 'pending' || $status === 'draft') ){
                                    $status_text = esc_attr__( 'Pending', 'taskbot' );
                                } else {
                                    $status_text = ucfirst($status);
                                }

                                $post_date    = !empty( $date ) ? date_i18n('F j, Y', strtotime($date)) : '';
                                $post_date    = date_i18n( get_option( 'date_format' ),  strtotime(get_the_date()));

                                $withdraw_amount  = !empty(get_post_meta( $post_id, '_withdraw_amount', true )) ? get_post_meta( $post_id, '_withdraw_amount', true ) : '';
                                $payment_method   = !empty(get_post_meta( $post_id, '_payment_method', true ))  ? get_post_meta( $post_id, '_payment_method', true )  : '';
                                $unique_key       = !empty(get_post_meta( $post_id, '_unique_key', true ))      ? get_post_meta( $post_id, '_unique_key', true )      : '';
						        $payment_method	= !empty($payrols[$payment_method]['label']) ? $payrols[$payment_method]['label'] : $payment_method;
                            ?>
                                <tr>
                                    <td data-label="<?php esc_attr_e('Ref #', 'taskbot');?>">
                                        <div class="tb-checkbox">
                                            <span><?php echo esc_html($unique_key); ?></span>
                                        </div>
                                    </td>
                                    <td data-label="<?php esc_attr_e('Status', 'taskbot');?>"><?php echo esc_attr($status_text);?></td>
                                    <td data-label="<?php esc_attr_e('Method', 'taskbot');?>"><a href="javascript:void(0)"><?php echo ucfirst(esc_html($payment_method)); ?></a></td>
                                    <td data-label="<?php esc_attr_e('Date', 'taskbot');?>"><?php echo esc_html($post_date); ?></td>
                                    <td data-label="<?php esc_attr_e('Amount', 'taskbot');?>"><span><?php taskbot_price_format($withdraw_amount);?></span></td>
                                </tr>
							<?php endwhile;
							wp_reset_postdata();
						endif; ?>
					</tbody>
                </table>
                <?php if ( !empty($count_post) && $count_post > $show_posts ) {?>
                    <div class="tb-tabfilteritem">
                        <?php taskbot_paginate($withdraw_query); ?>
                    </div>
                <?php } ?>

                <?php
					if ( !$withdraw_query->have_posts() ) {
						do_action( 'taskbot_empty_listing', esc_html__('Oops!! record not found', 'taskbot') );
					}
                ?>
            </div>
        </div>
    </div>
</div>