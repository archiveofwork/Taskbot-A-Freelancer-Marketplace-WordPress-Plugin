<?php
/**
 * Dashboard task listings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/admin_dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user,$taskbot_settings;

$ref                = !empty($_GET['ref'])  ? esc_html($_GET['ref'])  : '';
$mode 			    = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity      = !empty($_GET['identity']) ? intval($_GET['identity']) : 0;
$user_type		    = apply_filters('taskbot_get_user_type', $user_identity );
$status_list        = taskbot_tasks_status_list();
$post_status        = array('any');
$current_page_link  = Taskbot_Profile_Menu::taskbot_profile_admin_menu_link($ref, $user_identity, true, $mode);
$current_page_link  = !empty($current_page_link) ? $current_page_link : '';
// check and get values from search form
$search_keyword  = (isset($_GET['search_keyword'])  && !empty($_GET['search_keyword'])   ? esc_html($_GET['search_keyword'])   : "");

$service_status             = !empty($taskbot_settings['service_status']) ? $taskbot_settings['service_status'] : '';
$resubmit_service_status    = !empty($taskbot_settings['resubmit_service_status']) ? $taskbot_settings['resubmit_service_status'] : 'no';


// sort by status
$sort_by_status = (isset($_GET['sort_by']) && !empty($_GET['sort_by']) ? $_GET['sort_by'] : "");

// if sort by status exists, then update the $post_status array
if (!empty($sort_by_status)){
  $post_status  = array($sort_by_status);
}

// basic query args
$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$per_page   = get_option('posts_per_page');
$taskbot_args   = array(
  'post_type'         => 'product',
  'post_status'       => $post_status,
  'posts_per_page'    => $per_page,
  'paged'             => $paged,
  'orderby'           => 'date',
  'order'             => 'DESC',
  'tax_query'         => array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'tasks',
        ),
  ),
);

// if keyword field is set in search then append its args in $query_args
if (!empty($search_keyword)){

  $filtered_args = array(
    's' => $search_keyword,
  );

  $taskbot_args = array_merge($taskbot_args,$filtered_args);
}

if( !empty($service_status) && $service_status === 'pending' && !empty($resubmit_service_status) && $resubmit_service_status === 'yes'){
    $meta_query_args    = array();
    if( !empty($sort_by_status) && $sort_by_status === 'pending'){
        $meta_query_args[] = array(
            'key' 		     => '_post_task_status',
            'value' 	     => 'requested',
            'compare' 	   => '='
          );
    } else if( !empty($sort_by_status) && $sort_by_status === 'rejected'){
        $meta_query_args[] = array(
            'key' 		     => '_post_task_status',
            'value' 	     => 'rejected',
            'compare' 	   => '='
          );
    } 
    if( !empty($meta_query_args) ){
        $query_relation = array('relation' => 'AND',);
        $taskbot_args['meta_query'] = array_merge($query_relation, $meta_query_args);
    }
    
}

$taskbot_query  = new WP_Query( apply_filters('taskbot_admin_service_listings_args', $taskbot_args) );
$date_format    = get_option( 'date_format' );
?>
<div class="col-xl-12">
    <div class="tb-dhb-mainheading">
        <h2><?php esc_html_e('Manage task','taskbot');?></h2>
        <div class="tb-sortby">
            <form class="tb-themeform tb-displistform" id="tb-search-task-form" action="<?php echo esc_url( $current_page_link ); ?>">
                <input type="hidden" name="ref"             value="<?php echo esc_attr($ref); ?>">
                <input type="hidden" name="identity"        value="<?php echo esc_attr($user_identity); ?>">
                <input type="hidden" name="mode"            value="<?php echo esc_attr($mode); ?>">
                <fieldset>
                    <div class="tb-themeform__wrap">
                        <div class="form-group tb-inputicon tb-inputheight tb-dbholder border-0">
                            <i class="icon-search"></i>
                            <input type="text" name="search_keyword" class="form-control" value="<?php echo esc_attr($search_keyword) ?>"  placeholder="<?php esc_attr_e('Search service listing','taskbot');?>">
                        </div>
                        <div class="tb-actionselect">
                            <span><?php esc_html_e('By urgency:','taskbot');?></span>
                            <div class="tb-select tb-dbholder border-0">
                                <select id="tb_admin_order_type" name="sort_by" class="form-control " data-select2-id="tb-selection1" tabindex="-1" aria-hidden="true">
                                    <?php
										foreach($status_list as $key => $val ){
										$selected   = '';
										if( !empty($sort_by_status) && $sort_by_status == $key ){
											$selected   = 'selected';
										}
                                    ?>
                                    <option value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($val);?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="tb-dbholder border-0 tb-todolist">
        <?php if ( $taskbot_query->have_posts() ) :?>
        <table class="table tb-table tb-dbholder">
            <thead>
                <tr>
                    <th><?php esc_html_e('Title','taskbot');?></th>
                    <th><?php esc_html_e('Date','taskbot');?></th>
                    <th><?php esc_html_e('Featured','taskbot');?></th>
                    <th><?php esc_html_e('Task author','taskbot');?></th>
                    <th><?php esc_html_e('Status','taskbot');?></th>
                    <th><?php esc_html_e('Action','taskbot');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
                        $product    = wc_get_product( $post->ID );
                        $user_id    = get_post_field( 'post_author', $post->ID );
                        $link_id    = taskbot_get_linked_profile_id( $user_id,'','sellers' );
                        $user_link  = get_the_permalink( $link_id );
                        $user_name  = taskbot_get_username($link_id);
                        $post_status= get_post_status( $post );

                        $taskbot_featured = $product->get_featured();?>
                        <tr>
                            <td data-label="<?php esc_attr_e('Title','taskbot');?>">
                                <div class="tb-checkboxwithimg">
                                    <div class="tb-tasks-image">
                                        <figure><?php echo woocommerce_get_product_thumbnail('taskbot_thumbnail');?></figure>
                                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                    </div>
                                </div>
                            </td>
                            <td data-label="<?php esc_attr_e('Date','taskbot');?>">
                                <?php echo date_i18n( $date_format,  strtotime(get_the_date()));?>
                            </td>
                            <td data-label="<?php esc_attr_e('Featured','taskbot');?>">
                                <?php 
                                    if( !empty($taskbot_featured) ){
                                        esc_html_e('Yes','taskbot');
                                    } else {
                                        esc_html_e('No','taskbot');
                                    }
                                ?>
                            </td>
                            <td data-label="<?php esc_attr_e('Task author','taskbot');?>">
                                <a href="<?php echo esc_url($user_link);?>" target="_balnk"><?php echo esc_html($user_name);?></a>
                            </td>
                            <td class="tb-task-status" data-label="<?php esc_attr_e('Status','taskbot');?>">
                                <?php do_action( 'taskbot_task_status', $post->ID );?>
                            </td>
                            <td data-label="<?php esc_attr_e('Action','taskbot');?>">
                                <ul class="tb-tabicon tb-invoicecon">
                                    <li>
                                        <?php if( !empty($post_status) && in_array($post_status,array('pending','publish'))){ ?>
                                            <a href="javascript:void(0)" class="tb-canceled tb_rejected_task_model" data-id="<?php echo esc_attr(intval($post->ID)); ?>"><span class="icon-x"></span>&nbsp;<?php esc_attr_e('Reject task','taskbot');?></a>
                                        <?php } if( !empty($post_status) && in_array($post_status,array('pending','rejected'))){ ?>
                                            <a href="javascript:void(0);" class="tb-publish tb_publish_task" data-id="<?php echo intval($post->ID);?>"><span class="icon-check"></span>&nbsp;<?php esc_attr_e('Approve task','taskbot');?></a>
                                        <?php } ?>
                                    </li>
                                    <li class="tb-delete"><div href="javascript:void(0);" class="tb-red tb_remove_task" data-id="<?php echo intval($post->ID);?>"><span class="icon-trash"></span></div> </li>
                                    <li> <a href="<?php echo get_the_permalink( $post );?>" target="_blank"><span class="icon-eye tb-gray"></span></a> </li>
                                </ul>
                            </td>
                        </tr>
                <?php  endwhile;?>
                
            </tbody>
        </table>
        <?php else: ?>
            <?php do_action( 'taskbot_empty_listing', esc_html__('No tasks found', 'taskbot')); ?>
        <?php endif; ?>
        <?php taskbot_paginate($taskbot_query,'tb-tabfilteritem');?>
        <?php wp_reset_postdata();?>
    </div>
</div>