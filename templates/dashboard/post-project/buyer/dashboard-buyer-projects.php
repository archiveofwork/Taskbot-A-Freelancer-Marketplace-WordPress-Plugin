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
global $current_user,$taskbot_settings;

$show_posts		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$paged 			= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$ref		    = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode			= !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity	= intval($current_user->ID);
$id				= !empty($args['id']) ? intval($args['id']) : '';
$user_type		= apply_filters('taskbot_get_user_type', $user_identity);
$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);
$order_type     = !empty($_GET['order_type']) ? $_GET['order_type'] : 'any';
$taskbot_args = array(
    'post_type'         => 'product',
    'post_status'       => 'any',
    'posts_per_page'    => $show_posts,
    'paged'             => $paged,
    'author'            => $current_user->ID,
    // 'orderby'           => 'meta_value_num',
    // 'meta_key'          => '_order_status',
    'order'             => 'DESC',
    'tax_query'         => array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'projects',
        ),
    ),
);

if(!empty($order_type) && $order_type!= 'any' ){
    $update_status  = array('hired','cancelled','rejected','completed');
    if(in_array($order_type,$update_status) ){
        $taskbot_args['meta_query'] = array(
            array(
                'key'       => '_post_project_status',
                'value'     => $order_type,
                'compare'   => '=',
                'type'      => 'CHAR',
            )
        );
    } else {
        $taskbot_args['post_status'] = $order_type;
    }
}
$taskbot_query  = new WP_Query( apply_filters('taskbot_project_dashbaord_listings_args', $taskbot_args) );
$create_project = taskbot_get_page_uri('add_project_page');
$page_url       = Taskbot_Profile_Menu::taskbot_profile_menu_link($ref, $user_identity, true, $mode);
$menu_order     = taskbot_list_projects_status_filter();
$count_post     = $taskbot_query->found_posts;
$buyer_package_option	= !empty($taskbot_settings['package_option']) && in_array($taskbot_settings['package_option'],array('paid','seller_free')) ? true : false;
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
        $product            = wc_get_product( $post->ID );
        $project_price      = taskbot_project_price($post->ID); 
        $post_status        = get_post_status( $post->ID );
        $project_meta       = get_post_meta( $post->ID, 'tb_project_meta',true );
        $project_meta       = !empty($project_meta) ? $project_meta : array();
        $project_type       = !empty($project_meta['project_type']) ? ($project_meta['project_type']) : '';
        $is_featured        = !empty($product) ? $product->get_featured() : false;
        $projecet_status    = get_post_meta($product->get_id(), '_post_project_status', true);
        $projecet_status    = !empty($projecet_status) ? $projecet_status : '';
        $status_array       = array('pending','draft','publish');

        $show_menu          = false;
        if( !empty($post_status) && $post_status != 'draft' && !empty($buyer_package_option) ){
            $show_menu          = true;
        } else if( !empty($post_status) && in_array($post_status,$status_array) && in_array($projecet_status,$status_array) ){
            $show_menu          = true;
        }
        if( !empty($product) ){ ?>
            <div class="tk-project-wrapper-two">
                <div class="tk-project-box">
                    <?php do_action( 'taskbot_featured_item', $product,'featured_project' );?>
                    <div class=" tk-price-holder">
                        <div class="tk-verified-info">
                            <?php do_action( 'taskbot_project_status_tag', $product );?>
                            <?php if( !empty($product->get_name()) ){?>
                                <h5><a href="<?php echo get_the_permalink( $post );?>"><?php echo esc_html($product->get_name());?></a></h5>
                            <?php } ?>
                        </div>
                        <div class="tk-price">
                            <?php if( !empty($project_type) ){?>
                                <?php do_action( 'taskbot_project_type_text', $project_type );?>
                            <?php } ?>
                            <?php if( isset($project_price) ){?>
                                <h4><?php echo do_shortcode($project_price);?></h4>
                            <?php } ?>
                        </div>
                        <?php if( !empty($show_menu) ){?>
                            <div class="tk-projectsstatus_option">
                                <a href="javascript:void(0);" data-id="<?php echo intval($post->ID);?>"><i class="icon-more-horizontal"></i></a>
                                <ul class="tk-contract-list tk-contract-list-<?php echo intval($post->ID);?>">
                                    <?php if( !empty($post_status) && $post_status != 'draft' && !empty($buyer_package_option) ){?>
                                        <?php if( !empty($is_featured) ){?>
                                            <li data-id="<?php echo intval($post->ID);?>" data-value="no" class="tb_project_featured">
                                                <span><?php esc_html_e('Remove featured','taskbot');?></span>
                                            </li>
                                        <?php } else { ?>
                                            <li data-id="<?php echo intval($post->ID);?>" data-value="yes" class="tb_project_featured">
                                                <span><?php esc_html_e('Mark as featured','taskbot');?></span>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if( !empty($post_status) && in_array($post_status,$status_array) && in_array($projecet_status,$status_array)  ){?>
                                        <li>
                                            <span data-id="<?php echo intval($post->ID);?>" class="tb_project_remove" ><?php esc_html_e('Delete project','taskbot');?></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                    <ul class="tk-template-view"> 
                        <?php do_action( 'taskbot_posted_date_html', $product );?>
                        <?php do_action( 'taskbot_location_html', $product );?>
                        <?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','icon-briefcase' );?>
                        <?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
                    </ul>
                    <?php do_action( 'taskbot_list_hiring_freelancer_html', $product->get_id() );?>
                </div>
                <div class="tk-project-box tk-project-box-two">
                    <ul class="tk-proposal-list">
                        <?php do_action( 'taskbot_project_proposal_icons_html', $product->get_id(),3,'yes' );?>
                    </ul>
                    <div class="tk-project-detail">
                        <?php if( !empty($product->get_status()) && in_array($product->get_status(),$status_array) && in_array($projecet_status,$status_array)){
                            $project_creation   = !empty($create_project) && !empty($post->ID) ? $create_project.'?step=2&post_id='.intval($post->ID) : '';?>
                            <a class="tk-edit-project" href="<?php echo esc_url($project_creation);?>"><i class="icon-edit-3"></i><?php esc_html_e('Edit project','taskbot');?></a>
                        <?php } ?>
                        <a href="<?php echo get_the_permalink( $post );?>" class="tk-invite-bidbtn"><?php esc_html_e('View project','taskbot');?></a>
                    </div>
                </div>
            </div>
        <?php }
    endwhile;
    if( !empty($count_post) && $count_post > $show_posts ):?>
        <?php taskbot_paginate($taskbot_query); ?>
    <?php endif;
else:
    ?>
    <div class="tb-submitreview tb-submitreviewv3">
        <figure>
            <img src="<?php echo esc_url(TASKBOT_DIRECTORY_URI.'public/images/empty.png')?>" alt="<?php esc_attr_e('Create project','taskbot');?>">
        </figure>
        <h6><a href="<?php echo esc_url($create_project);?>"> <?php esc_html_e('Create a project', 'taskbot'); ?> </a></h6>
    </div>
<?php
endif;
wp_reset_postdata();
$script = "
jQuery(document).on('ready', function(){
    jQuery('.tk-projectsstatus_option > a').on('click',function() {
        let id = jQuery(this).data('id');
        //jQuery('.tk-contract-list').slideUp();
        jQuery('.tk-contract-list-'+id).slideToggle();
    });
    jQuery(document).on('change', '#tb_order_type', function (e) {
        let _this       = jQuery(this);
        let page_url = _this.find(':selected').data('url');
		window.location.replace(page_url);
    });    
});
";
wp_add_inline_script( 'taskbot', $script, 'after' );