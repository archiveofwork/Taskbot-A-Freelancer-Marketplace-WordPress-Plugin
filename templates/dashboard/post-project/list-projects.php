<?php
/**
*  Project list
*
* @package     Taskbot
* @author      Amentotech <info@amentotech.com>
* @link        https://codecanyon.net/user/amentotech/portfolio
* @version     1.0
* @since       1.0
*/
global $taskbot_settings,$current_user;
$post_url       = !empty($post_url) ? esc_url($post_url) : "";
$paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$search	        = !empty($_GET['search']) ? esc_html($_GET['search']) : '';
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
            'terms'    => 'projects',
        ),
    ),
);
if(!empty($search)){
	$taskbot_args['s'] = esc_html($search);
}
$taskbot_query = new WP_Query( apply_filters('taskbot_project_listings_args', $taskbot_args) );

?>
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <div class="tk-postproject-title">
            <h3><?php esc_html_e('Choose template from your posted projects','taskbot');?></h3>
            <p><?php esc_html_e('Using previously posted project help you not to add all data again from scratch','taskbot');?></p>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="tk-template-serach">
            <a href="<?php echo esc_url($post_url);?>" class="tk-btnline"><i class=" tb-icon-chevron-left"></i><?php esc_html_e('Go back','taskbot');?></a>
            <form method="get">
                <div class="tk-inputicon">
                    <input type="hidden" name="page_temp" value="projects">
                    <input type="text" name="search" class="form-control" value="<?php echo esc_attr($search);?>" placeholder="<?php esc_attr_e('Search project here', 'taskbot');?>">
                    <i class="tb-icon-search"></i>
                </div>
            </form>
        </div>
        <?php if ( $taskbot_query->have_posts() ) : ?>
        <ul class="tk-template-list">
        <?php
        while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
            global $post;
            $product = wc_get_product( $post->ID );
            ?>
            <li>
                <div class="tk-template-list_content">
                    <div class="tk-template-info">
                        <?php do_action( 'taskbot_project_type_tag', $product->get_id() );?>
                        <h5><?php echo esc_html($product->get_name());?></h5>
                        <ul class="tk-template-view"> 
                            <?php do_action( 'taskbot_posted_date_html', $product );?>
                            <?php do_action( 'taskbot_location_html', $product );?>
                            <?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','tb-icon-briefcase' );?>
                            <?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
                        </ul>
                    </div>
                    <span class="tk-btn-solid-lg-lefticon tb-duplicate-project" data-id="<?php echo intval($product->get_id());?>"><?php esc_html_e('Use this template','taskbot');?></span>
                </div>
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
                    <img src="<?php echo esc_url($image_url)?>" alt="<?php esc_attr_e('add project','taskbot');?>">
                </figure>
                <h4><?php esc_html_e( 'No projects found', 'taskbot'); ?></h4>
                <h6><a href="<?php echo esc_url($post_url);?>"> <?php esc_html_e('Add new project', 'taskbot'); ?> </a></h6>
            </div>
            <?php
        endif;?>
    </div>
</div>