<?php
/**
*  Project basic
*
* @package     Taskbot
* @author      Amentotech <info@amentotech.com>
* @link        https://codecanyon.net/user/amentotech/portfolio
* @version     1.0
* @since       1.0
*/
global $taskbot_settings,$current_user;
if ( !class_exists('WooCommerce') ) {
	return;
}
$post_id            = !empty($post_id) ? intval($post_id) : "";
$step_id            = !empty($step) ? intval($step) : "";
$pg_page            = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged           = get_query_var('paged') ? get_query_var('paged') : 1; 
$per_page           = !empty($per_page) ? $per_page : 10;
$options            = !empty($taskbot_settings['project_recomended_freelancers']) ? $taskbot_settings['project_recomended_freelancers'] : array();
$tax_query_args     = array();
if( !empty($options) ){
    foreach($options as $option ){
        $term_obj           = get_the_terms( $post_id, $option );
        $term_slug          = !empty($term_obj) ? wp_list_pluck($term_obj, 'slug') : array();
       
        $tax_query_args[]   = array(
            'taxonomy' => $option,
            'field'    => 'slug',
            'terms'    => $term_slug,
            'operator' => 'IN',
        );
    }
}

$query_args = array(
    'posts_per_page'        => $per_page,
    'paged'                 => $pg_paged,
    'post_type'             => 'sellers',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1
);

if (!empty($tax_query_args)) {
    $query_relation           = array('relation' => 'OR',);
    $tax_query_args           = array_merge($query_relation, $tax_query_args);
    $query_args['tax_query']  = $tax_query_args;
}
$seller_data = new WP_Query(apply_filters('taskbot_recomended_freelancer_filter', $query_args));
$total_posts = $seller_data->found_posts;
?>
<div class="row">
    <?php do_action( 'taskbot_project_sidebar', $step_id,$post_id );?>
    <div class="col-xl-9 col-lg-8">
        <div class="tk-maintitle">
            <h4><?php esc_html_e('Recommended freelancers','taskbot');?></h4>
        </div>
        <div class="tk-freelancers-list">
            <?php 
                if ($seller_data->have_posts()) {
                    while ($seller_data->have_posts()) {
                        $seller_data->the_post();
                        $seller_id        = get_the_ID();
                        $seller_name      = taskbot_get_username($seller_id);
                        $tb_post_meta     = get_post_meta($seller_id, 'tb_post_meta', true);
                        $seller_tagline   = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
                        ?>
                        <div class="tb-bestservice">
                            <div class="tb-bestservice__content tb-bestservicedetail">
                                <div class="tb-bestservicedetail__user">
                                    <div class="tb-asideprostatus">
                                        <?php do_action('taskbot_profile_image', $seller_id);?>
                                        <div class="tb-bestservicedetail__title">
                                            <?php if( !empty($seller_name) ){?>
                                                <h6><a href="<?php echo esc_url( get_permalink()); ?>"><?php echo esc_html($seller_name); ?></a></h6>
                                            <?php } ?>
                                            <?php if( !empty($seller_tagline) ){?>
                                                <h5><?php echo esc_html($seller_tagline); ?></h5>
                                            <?php } ?>
                                            <ul class="tb-rateviews">
                                                <?php do_action('taskbot_get_freelancer_rating_cuont', $seller_id); ?>
                                                <?php do_action('taskbot_get_freelancer_views', $seller_id); ?>
                                                <?php do_action('taskbot_save_freelancer_html', $current_user->ID, $seller_id, '_saved_sellers', '', 'sellers'); ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php do_action('taskbot_freelancer_invitation',$post_id,$seller_id); ?>
                                </div>
                            </div>
                        </div>
                        <?php 
                    }
                } else {
                    do_action('taskbot_empty_records_html', 'tb-empty-saved-items', esc_html__('No recommended freelancers found.', 'taskbot'));
                }
                ?>
            <?php if($total_posts > $per_page){?>
                <?php taskbot_paginate($seller_data); ?>
            <?php }?>
            <?php wp_reset_postdata();?>
        </div>
    </div>
</div>