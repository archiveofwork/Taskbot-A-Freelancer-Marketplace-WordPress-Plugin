<?php
/**
 * Project listing
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */
global $current_user, $taskbot_settings;

$show_posts		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$paged 			= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$ref		    = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode			= !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity	= intval($current_user->ID);
$id				= !empty($args['id']) ? intval($args['id']) : '';
$user_type		= apply_filters('taskbot_get_user_type', $user_identity);
$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);
$order_type     = !empty($_GET['order_type']) ? $_GET['order_type'] : 'any';
$find_project   = taskbot_get_page_uri('project_search_page');
$taskbot_args = array(
    'post_type'         => 'proposals',
    'post_status'       => array('completed','refunded','pending','publish','draft','hired','disputed','rejected'),
    'posts_per_page'    => $show_posts,
    'paged'             => $paged,
    'author'            => $current_user->ID,
    'orderby'           => 'meta_value_num',
    'meta_key'          => '_hired_status',
    'order'             => 'DESC'
);
if(!empty($order_type) && $order_type!= 'any' ){
    $taskbot_args['post_status'] = $order_type;
}
$taskbot_query  = new WP_Query( apply_filters('taskbot_project_dashbaord_listings_args', $taskbot_args) );
$create_project = taskbot_get_page_uri('add_project_page');
$page_url       = Taskbot_Profile_Menu::taskbot_profile_menu_link($ref, $user_identity, true, $mode);
$menu_order     = taskbot_list_proposal_status_filter();
$count_post     = $taskbot_query->found_posts;
?>
<div class="tb-dhb-mainheading">
    <h2><?php esc_html_e('My projects', 'taskbot');?></h2>
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
if ( $taskbot_query->have_posts() ) :
    ?>
    <?php 
    while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
        global $post; 
        $post_status        = get_post_status( $post );
        $project_id         = get_post_meta( $post->ID, 'project_id',true );
        $project_id         = !empty($project_id) ? intval($project_id) : 0;
        $product            = wc_get_product( $project_id );
        $project_price      = taskbot_project_price($project_id); 
        $project_meta       = get_post_meta( $project_id, 'tb_project_meta',true );
        $project_meta       = !empty($project_meta) ? $project_meta : array();
        $project_type       = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
        $seller_id          = get_post_field( 'post_author', $post );
        $seller_profile_id  = taskbot_get_linked_profile_id($seller_id, '','sellers');
        $seller_name        = taskbot_get_username($seller_profile_id);
        
        $buyer_id           = get_post_field( 'post_author', $project_id );
        $linked_profile_id  = taskbot_get_linked_profile_id($buyer_id, '','buyers');
        $user_name          = taskbot_get_username($linked_profile_id);
        $is_verified    	= !empty($linked_profile_id) ? get_post_meta( $linked_profile_id, '_is_verified',true) : '';
        $buyer_avatar       = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $linked_profile_id), array('width' => 50, 'height' => 50));

        
        if( !empty($product) ){ ?>
            <div class="tk-project-wrapper-two">
                <div class="tk-project-box">
                    <?php do_action('taskbot_featured_item', $product,'featured_project');?>
                    <div class="tk-employerproject">
                        <div class="tk-employerproject-title">
                            <?php do_action( 'taskbot_seller_proposal_status_tag', $post->ID );?>
                            
                            <div class="tk-verified-info">
                                <?php if( !empty($user_name) ){?>
                                    <strong>
                                        <?php echo esc_html($user_name);?>
                                        <?php do_action( 'taskbot_verification_tag_html', $linked_profile_id ); ?>
                                    </strong>
                                <?php } ?>
                                <?php if( !empty($product->get_name()) ){?>
                                    <h5><a href="<?php echo esc_url(get_the_permalink( $project_id ));?>"><?php echo esc_html($product->get_name());?></a></h5>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if( isset($project_price) ){?>
                            <div class="tk-price">
                                <?php if( !empty($project_type['title']) ){?>
                                    <?php do_action( 'taskbot_project_type_text', $project_type['title'] );?>
                                <?php } ?>
                                <h4><?php echo do_shortcode($project_price);?></h4>
                                <?php if( !empty($post_status) && in_array($post_status,array('publish','draft','pending')) ){ 
                                    $proposal_edit_link = !empty($post) ? taskbot_get_page_uri('submit_proposal_page').'?id='.intval($post->ID) : '';?>
                                    <div class="tk-project-detail">
                                        <a class="tk-edit-project" href="<?php echo esc_url($proposal_edit_link);?>"><?php esc_html_e('Edit proposal','taskbot');?></a>
                                        <a class="tk-invite-bidbtn" href="<?php echo esc_url(get_the_permalink($project_id));?>"><?php esc_html_e('View project','taskbot');?></a>
                                    </div>
                                <?php } elseif( !empty($post_status) && in_array($post_status,array('hired','cancelled','completed','disputed')) ){ ?>
                                    <div class="tk-project-detail">
                                        <a class="tk-btn-solid" href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $seller_id, true, 'activity',$post->ID));?>"><?php esc_html_e('Project activity','taskbot');?></a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <ul class="tk-template-view"> 
                        <?php do_action( 'taskbot_posted_date_html', $product );?>
                        <?php do_action( 'taskbot_location_html', $product );?>
                        <?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','tb-icon-briefcase' );?>
                        <?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
                    </ul>
                    <?php if( !empty($post_status) && $post_status === 'completed' ){ ?>
                        <div class="tk-freelancer-holder">
                            <div class="tk-tagtittle">
                                <span><?php esc_html_e('Project author & review','taskbot');?></span>
                            </div>
                            <ul class="tk-hire-freelancer">
                                <li>
                                    <div class="tk-hire-freelancer_content tk-completed-proposal">
                                        <?php if( !empty($buyer_avatar) ){?>
                                            <img src="<?php echo esc_url($buyer_avatar);?>" alt="<?php echo esc_attr($user_name);?>">
                                        <?php } ?>
                                        <div class="tk-hire-freelancer-info">
                                            <h6>
                                                <?php echo esc_html($user_name);
                                                $rating_id      = get_post_meta( $post->ID, '_rating_id', true );
                                                $rating_feature = !empty($rating_id) ? '' : 'tb-featureRating-nostar';
                                                $rating         = !empty($rating_id) ? get_comment_meta($rating_id, 'rating', true) : 0;
                                                $rating_avg     = !empty($rating) ? ($rating/5)*100 : 0;
                                                $rating_avg     = !empty($rating_avg) ? 'style="width:'.$rating_avg.'%;"' : '';

                                                $rating_class   = !empty($rating_id) ? 'tb_view_rating' : 'tb_add_project_rating';
                                                $rating_feature = !empty($rating_id) ? '' : 'tb-featureRating-nostar';
                                                $rating_title   = !empty($rating_id) ? esc_html__('Read review','taskbot') : esc_html__('No rating added','taskbot');
                                                ?>
                                                <?php if( !empty($rating_avg) ){?>
                                                    <span class="tk-blogviewdates <?php echo esc_attr($rating_feature);?>">
                                                        <i class="fas fa-star tk-yellow" <?php echo do_shortcode( $rating_avg );?>></i>
                                                        <em> <?php echo number_format((float)$rating, 1, '.', '');?> </em>
                                                    </span>
                                                <?php } ?>
                                            </h6>
                                            <?php if(!empty($rating_id)){?>
                                                <a href="javascript:;"  data-rating_id="<?php echo esc_attr($rating_id);?>" class="<?php echo esc_attr($rating_class);?>" ><?php echo esc_html($rating_title);?></a>
                                            <?php }else{?>
                                                <span><?php echo esc_html($rating_title);?></span>
                                            <?php }?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    <?php 
                        if( !empty($post_status) && $post_status === 'decline' ){
                            $decline_detail = get_post_meta( $post->ID, 'decline_detail',true );
                            $decline_detail = !empty($decline_detail) ? $decline_detail : '';
                        ?>
                        <div class="tk-statusview_alert tk-employerproject">
                            <span>
                                <i class="tb-icon-info"></i>
                                <?php esc_html_e("We’re sorry, but the employer has declined your proposal and left a comment for you.","taskbot");?>
                            </span>
                            <button class="tk-alert-readbtn" data-bs-target="#tb-decline-content-<?php echo intval($post->ID);?>" data-bs-toggle="modal"><?php esc_html_e('Read comment','taskbot');?> <i class="tb-icon-chevron-right"></i></button>
                        </div>
                        <div class="modal fade" id="tb-decline-content-<?php echo intval($post->ID);?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog tk-modal-dialog-sm">
                                <div class="modal-content">
                                    <div class="tk-popup_title">
                                        <h5><?php esc_html_e('Comment from employer','taskbot');?></h5>
                                        <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                                            <i class="tb-icon-x"></i>
                                        </a>
                                    </div>
                                    <div class="modal-body tk-popup-content">
                                        <div class="tk-statusview_alert">
                                            <span><i class="tb-icon-info"></i><?php esc_html_e("We’re sorry, but the employer has declined your proposal","taskbot");?></span>
                                        </div>
                                        <div class="tk-popup-info">
                                            <div class="tk-user-content">
                                                <?php if( !empty($buyer_avatar) ){?>
                                                    <img src="<?php echo esc_url($buyer_avatar);?>" alt="<?php echo esc_attr($user_name);?>">
                                                <?php } ?>
                                                <?php if( !empty($user_name) ){?>
                                                    <div class="tk-user-info">
                                                        <h6><?php echo esc_html($user_name);?></h6>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="tk-popup-info">
                                            <?php if( !empty($seller_name) ){?>
                                                <h6><?php sprintf(esc_html__('Hi %s,','taskbot'),$seller_name);?></h6>
                                            <?php } ?>
                                            <?php if( !empty($decline_detail) ){?>
                                                <p><?php echo esc_html($decline_detail);?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    endwhile;
    if( !empty($count_post) && $count_post > $show_posts ):?>
        <?php taskbot_paginate($taskbot_query); ?>
    <?php endif;
else:
    $image_url = !empty($taskbot_settings['empty_listing_image']['url']) ? $taskbot_settings['empty_listing_image']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/empty.png';
    ?>
    <div class="tb-submitreview tb-submitreviewv3">
        <figure>
            <img src="<?php echo esc_url($image_url)?>" alt="<?php esc_attr_e('Explore all projects','taskbot');?>">
        </figure>
        <h6><a href="<?php echo esc_url($find_project);?>"> <?php esc_html_e('Explore all projects', 'taskbot'); ?> </a></h6>
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