<?php
/**
 * Seller task listings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $post, $current_user,$taskbot_settings;
$ref                = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode               = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity      = !empty($_GET['identity']) ? intval($_GET['identity']) : 0;

$user_type         = apply_filters('taskbot_get_user_type', $current_user->ID );
$task_allowed      = taskbot_task_create_allowed($current_user->ID);
$package_detail    = taskbot_get_package($current_user->ID);

$order_type     = !empty($_GET['order_type']) ? $_GET['order_type'] : 'any';
$menu_order     = taskbot_list_tasks_status_filter();
$page_url       = Taskbot_Profile_Menu::taskbot_profile_menu_link($ref, $user_identity, true, $mode);

$package_option               = !empty($taskbot_settings['package_option']) && in_array($taskbot_settings['package_option'],array('paid','buyer_free')) ? true : false;
$taskbot_add_service_page_url = '';
$taskbot_add_service_page_url = !empty($taskbot_settings['tpl_add_service_page']) ? get_permalink($taskbot_settings['tpl_add_service_page']) : '';
?>
<div class="tb-dhb-mainheading">
    <div class="tb-dhb-mainheading__rightarea">
        <em><?php esc_html_e('Add task for each service you offer to increase chances of getting hired', 'taskbot');?></em>
        <a href="<?php echo esc_url($taskbot_add_service_page_url);?>" class="tb-btn">
            <?php esc_html_e('Add new', 'taskbot');?>
            <span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span>
        </a>
    </div>
</div>
<div class="tb-dhb-mainheading">
    <h2><?php esc_html_e('Manage task', 'taskbot');?></h2>
    <?php do_action('taskbot_service_listing_notice');?>
    <div class="tb-sortby">
        <div class="tb-actionselect tb-actionselect2">
            <span><?php esc_html_e('Filter by:','taskbot');?></span>
            <div class="tb-select">
                <select id="tb_order_type" name="order_type" class="form-control tk-selectv">
                    <?php foreach($menu_order as $key => $val ){
                        $selected   = '';

                        if( !empty($order_type) && $order_type == $key ){
                            $selected   = 'selected';
                        }
                        ?>
                        <option data-url="<?php echo esc_url($page_url);?>&order_type=<?php echo esc_attr($key);?>" value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected);?>>
                            <?php echo esc_html($val);?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$taskbot_args = array(
    'post_type'         => 'product',
    'post_status'       => 'any',
    'posts_per_page'    => get_option('posts_per_page'),
    'paged'             => $paged,
    'author'            => $current_user->ID,
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
if(!empty($order_type) && $order_type!= 'any' ){

    $taskbot_args['post_status'] = $order_type;
}

$taskbot_query = new WP_Query( apply_filters('taskbot_service_listings_args', $taskbot_args) );

if ( $taskbot_query->have_posts() ) :   
    ?>
    <ul class="tb-savelisting">
        <?php do_action('taskbot_service_listing_before');?>
        <?php
        while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
            $product = wc_get_product( $post->ID );
            $taskbot_add_service_page_edit_url = 'javascript:void(0);';
            
            if($taskbot_add_service_page_url){
                $taskbot_add_service_page_edit_url = add_query_arg( array(
                    'post'    => $post->ID,
                    'step'    => 1,
                ), $taskbot_add_service_page_url );
            }

            $taskbot_featured   = $product->get_featured();
            $task_order_url     = get_the_permalink($post->ID);
            ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class('tb-tabbitem'); ?>>
                <?php do_action('taskbot_service_item_before', $product);?>
                <div class="tb-tabbitem__list tb-tabbitem__listtwo">
                    <div class="tb-deatlswithimg">
                        <figure>
                            <?php
                                echo woocommerce_get_product_thumbnail('woocommerce_thumbnail');
                                do_action('taskbot_service_featured_item', $product);
                            ?>
                        </figure>
                        <div class="tb-icondetails">
                            <?php echo do_action('taskbot_task_categories', $post->ID, 'product_cat');?>
                            <h6><a href="<?php the_permalink();?>"><?php the_title();?></a></h6>
                            <ul class="tb-rateviews tb-rateviews2">
                                <?php
                                    do_action('taskbot_service_rating_count', $product);
                                    do_action('taskbot_service_item_views', $product);
                                    do_action('taskbot_service_item_reviews', $product);
                                    do_action('taskbot_service_item_status', $post->ID);
                                ?>
                            </ul>
                            <ul class="tb-profilestatus">
                                <?php
                                    do_action('taskbot_service_item_queue', $product);
                                    do_action('taskbot_service_item_completed', $product);
                                    do_action('taskbot_service_item_cancelled', $product);
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tb-itemlinks">
                        <?php do_action('taskbot_service_item_starting_price', $product);?>
                        <?php if($product->get_status() == 'publish' || $product->get_status() == 'private' ){?>
                            <div class="tb-switchservice">
                                <span><?php esc_html_e('Task on / off', 'taskbot');?></span>
                                <div class="tb-onoff">
                                    <input type="checkbox" id="service-enable-switch-<?php echo intval($post->ID);?>" data-id="<?php echo (int)$post->ID;?>" name="service-enable-disable" <?php if($product->get_status() == 'publish'){echo do_shortcode('checked="checked"');}?>>
                                    <label for="service-enable-switch-<?php echo intval($post->ID);?>"><em><i></i></em><span class="tb-enable"></span><span class="tb-disable"></span></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(!empty($package_option) ){?>
                            <div class="tb-switchservice">
                                <span><?php esc_html_e('Featured Task', 'taskbot');?></span>
                                <div class="tb-onoff">
                                    <input type="checkbox" id="service-featured-switch-<?php echo intval($post->ID);?>" data-id="<?php echo (int)$post->ID;?>" name="service-featured-disable" <?php if(!empty($taskbot_featured)){echo do_shortcode('checked="checked"');}?>>
                                    <label for="service-featured-switch-<?php echo intval($post->ID);?>"><em><i></i></em><span class="tb-enable"></span><span class="tb-disable"></span></label>
                                </div>
                            </div>
                        <?php } ?>
                        <ul class="tb-tabicon">
                            <li data-class="tb-tooltip-data" id="tb-tooltip-10<?php echo esc_attr($post->ID) ?>" data-tippy-interactive="true" data-tippy-placement="top" data-tippy-content="<?php esc_html_e('Edit','taskbot'); ?>"><a href="<?php echo esc_url($taskbot_add_service_page_edit_url);?>"><span class="tb-icon-edit-2"></span></a> </li>
                            <li data-class="tb-tooltip-data" id="tb-tooltip-20<?php echo esc_attr($post->ID) ?>" data-tippy-interactive="true" data-tippy-placement="top" data-tippy-content="<?php esc_html_e('Delete','taskbot'); ?>" class="tb-delete"> <a href="javascript:void(0);"  class="taskbot-service-delete" data-id="<?php echo (int)$post->ID;?>"><span class="tb-icon-trash-2 bg-redheart"></span></a> </li>
                            <li data-class="tb-tooltip-data" id="tb-tooltip-30<?php echo esc_attr($post->ID) ?>" data-tippy-interactive="true" data-tippy-placement="top" data-tippy-content="<?php esc_html_e('View','taskbot'); ?>"><a href="<?php echo esc_url( $task_order_url );?>"><span class="tb-icon-external-link bg-gray"></span></a></li>
                        </ul>
                    </div>
                </div>
                <?php do_action('taskbot_service_item_after', $product);?>
            </li>
            <?php
        endwhile;
        do_action('taskbot_service_listing_after');
        ?>
    </ul>
    <?php
    taskbot_paginate($taskbot_query);
else:
    $image_url = !empty($taskbot_settings['empty_listing_image']['url']) ? $taskbot_settings['empty_listing_image']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/empty.png';
    ?>
    <div class="tb-submitreview tb-submitreviewv3">
        <figure>
            <img src="<?php echo esc_url($image_url)?>" alt="<?php esc_attr_e('add task','taskbot');?>">
        </figure>
        <h4><?php esc_html_e( 'Add your new Task and start getting orders', 'taskbot'); ?></h4>
        <h6><a href="<?php echo esc_url($taskbot_add_service_page_url);?>"> <?php esc_html_e('Add new task', 'taskbot'); ?> </a></h6>
    </div>
    <?php
endif;
wp_reset_postdata();
$script = "
jQuery(document).on('ready', function(){
    jQuery(document).on('change', '#tb_order_type', function (e) {
        let _this       = jQuery(this);
        let page_url = _this.find(':selected').data('url');
		window.location.replace(page_url);
    });
});
";
wp_add_inline_script( 'taskbot', $script, 'after' );