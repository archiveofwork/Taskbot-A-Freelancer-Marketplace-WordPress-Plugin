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
global $current_user;
$show_posts		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$paged 			= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$ref		    = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode			= !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity	= intval($current_user->ID);
$proposal_id	= !empty($_GET['id']) ? intval($_GET['id']) : 0;
$project_id     = !empty($proposal_id) ? get_post_meta($proposal_id,'project_id',true) : 0;
$project_id     = !empty($project_id) ? $project_id : 0;
$user_type		= apply_filters('taskbot_get_user_type', $user_identity);
$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);
$project_status = get_post_status( $project_id );
$product 	    = wc_get_product( $project_id );
$project_price  = !empty($project_id) ? taskbot_project_price($project_id) : '';
$proposal_status= !empty($proposal_id) ? get_post_status( $proposal_id ) : '';
$activity_url   = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $user_identity, true, 'activity',$proposal_id);

$product_author_id  = get_post_field ('post_author', $proposal_id);
$linked_profile_id  = taskbot_get_linked_profile_id($product_author_id, '','sellers');
$user_name          = taskbot_get_username($linked_profile_id);
$avatar             = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $linked_profile_id), array('width' => 50, 'height' => 50));

$tb_total_rating    = get_post_meta( $linked_profile_id, 'tb_total_rating', true );
$tb_total_rating	= !empty($tb_total_rating) ? $tb_total_rating : 0;
$tb_review_users	= get_post_meta( $linked_profile_id, 'tb_review_users', true );
$tb_review_users	= !empty($tb_review_users) ? $tb_review_users : 0;
$proposal_meta      = get_post_meta( $proposal_id, 'proposal_meta',true );
$proposal_meta      = !empty($proposal_meta) ? $proposal_meta : array();
$proposal_type      = !empty($proposal_meta['proposal_type']) ? $proposal_meta['proposal_type'] : '';
$project_type       = get_post_meta( $proposal_id, 'proposal_type',true );
$project_type       = !empty($project_type) ? $project_type : '';
$milestone          = !empty($proposal_meta['milestone']) ? $proposal_meta['milestone'] : array();
$project_meta	    = get_post_meta( $project_id, 'tb_project_meta',true);
$is_milestone	    = !empty($project_meta['is_milestone']) ? $project_meta['is_milestone'] : '';
$user_balance       = get_user_meta( $user_identity, '_buyer_balance', true );
$user_balance       = !empty($user_balance) ? $user_balance : 0;
if( empty($project_type) ||$project_type === 'fixed') {
    if( !empty($user_balance) ){
        $checkout_class         = 'tb_proposal_hiring';
    } else {
        $checkout_class     = 'tb_hire_proposal';
    }
} else {
    $checkout_class     = 'tb_hire_job_proposal';
}

?>
<div class="tk-project-wrapper">
    <div class="tk-project-box tk-employerproject">
        <div class="tk-employerproject-title">
            <?php do_action( 'taskbot_project_type_tag', $product->get_id() );?>
            <?php if($product->get_name()){?>
                <h3><?php echo esc_html($product->get_name());?></h3>
            <?php }?>
            <ul class="tk-blogviewdates">
                <?php do_action( 'taskbot_posted_date_html', $product );?>
                <?php do_action( 'taskbot_location_html', $product );?>
                <?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','icon-briefcase' );?>
                <?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
            </ul>
        </div>
        <div class="tk-price">
            <?php if( !empty($project_price) ){?>
                <h4><?php echo do_shortcode( $project_price );?></h4>
            <?php } ?>
            <?php if( !empty($proposal_status) && in_array($proposal_status,array('hired','completed','cancelled'))){?>
                <div class="tk-project-detail">
                    <a href="<?php echo esc_url($activity_url);?>" class="tk-btn-solid-lg"><?php esc_html_e('Project activity','taskbot');?></a>
                </div>
            <?php } else if( !empty($proposal_status) && $proposal_status === 'publish'){?>
                <div class="tk-project-detail">
                    <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $user_identity, '', 'listing',$product->get_id());?>" class="tk-btn-solid-lg"><?php esc_html_e('View all proposals','taskbot');?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="tk-project-box tk-profile-view">
        <div class="tk-project-table-content">
            <?php if( !empty($avatar) ){?>
                <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
            <?php } ?>
            <div class="tk-project-table-info">
                <?php if( !empty($user_name) ){?>
                    <h4><?php echo esc_html($user_name);?></h4>
                <?php } ?>
                <?php if( !empty($tb_review_users)){ ?>
                    <ul class="tk-blogviewdates">
                        <li>
                            <i class="fas fa-star tk-yellow"></i>
                            <em> <?php echo number_format($tb_total_rating,1,'.', '');?> </em>
                            <span>(<?php echo intval($tb_review_users);?>)</span>
                        </li>
                    </ul>
                <?php } ?>
            </div>
            <a href="<?php echo esc_url(get_the_permalink($linked_profile_id));?>" class="tk-btn-solid tk-success-tag"><?php esc_html_e('View profile','taskbot');?></a>
        </div>
    </div>
    <?php if( isset($proposal_meta['price'])){?>
        <div class="tk-project-box tk-working-rate">
            <div class="tk-project-price">
                <h5><?php echo sprintf(esc_html__('%s budget working rate','taskbot'),$user_name);?></h5>
                <span>
                    <?php 
                        if( empty($project_type) ||$project_type === 'fixed') {
                            taskbot_price_format($proposal_meta['price']);
                        } else {
                            do_action( 'taskbot_proposal_listing_price', $proposal_id );
                        }
                    ?>    
                </span>
            </div>
        </div>
    <?php } ?>
    <div class="tk-projectsinfo tk-project-box">
        <div class="tk-offer-milestone">
            <?php if( !empty($proposal_type) && $proposal_type === 'milestone' && !empty($milestone)){?>
                <div class="tk-projectsinfo_title">
                    <h4><?php esc_html_e('Offered milestones','taskbot');?></h4>
                    <p><?php esc_html_e('To start the project, You must click the“Hire & escrow milestone” button later you can escrow other milestones as well from the project activity.','taskbot');?></p>
                </div>
                <ul class="tk-projectsinfo_list">
                    <?php 
                        foreach($milestone as $key => $value){ 
                            $title  = !empty($value['title']) ? $value['title'] : '';
                            $price  = isset($value['price']) ? $value['price'] : '';
                            $detail = !empty($value['detail']) ? $value['detail'] : '';
                    ?>  
                        <li>
                            <div class="tk-statusview">
                                <div class="tk-statusview_head">
                                    <div class="tk-statusview_title">
                                        <?php if( !empty($title) ){?>
                                            <h5><?php echo esc_html($title);?></h5>
                                        <?php } ?>
                                        <?php if( isset($price) ){?>
                                            <span><?php taskbot_price_format($price);?></span>
                                        <?php } ?>
                                    </div>
                                    <?php if( !empty($detail) ){?>
                                        <p><?php echo do_shortcode($detail);?></p>
                                    <?php } ?>
                                </div>
                                <?php if( !empty($project_status) && $project_status === 'publish' && !empty($proposal_status) && $proposal_status === 'publish' ){?>
                                    <div class="tk-statusview_btns">
                                        <button class="tk-btnline <?php echo esc_attr($checkout_class);?>" data-key="<?php echo esc_attr($key);?>" data-id="<?php echo intval($proposal_id);?>"><?php echo sprintf(esc_html__('Pay and hire','taskbot'),$user_name);?></button>
                                    </div>
                                <?php } ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <?php if( !empty($proposal_meta['description'])) {?>
                <div class="tk-milestones-content">
                    <h6><?php esc_html_e('Special comments to employer','taskbot');?></h6>
                    <p><?php echo do_shortcode($proposal_meta['description']);?></p>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="tk-project-box">
        <?php  do_action( 'taskbot_before_hire_proposal_button', $proposal_id ); ?>
        <div class="tk-bidbtn tk-proposals-btn">
            <?php if( !empty($project_status) && $project_status === 'publish' && !empty($proposal_status) && $proposal_status === 'publish' ) {?>
                <button class="tk-decline" data-bs-target="#tb_decline_proposal" data-bs-toggle="modal" ><?php esc_html_e('Decline proposal','taskbot');?></button>
            <?php } ?>

            <?php if((in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins')))) ){?>
                <button class="tk-btnline tb_proposal_chat" data-reciver_id="<?php echo intval($product_author_id);?>"><i class="icon-message-square"></i><?php esc_html_e('Start chat','taskbot');?></button>
            <?php } ?>

            <?php if( 
                    (!empty($proposal_type) && $proposal_type === 'fixed' && !empty($project_status) && $project_status === 'publish' && !empty($proposal_status) && $proposal_status === 'publish' ) || 
                    (!empty($project_type) && $project_type === 'fixed' && !empty($is_milestone) && $is_milestone === 'no' && !empty($project_status) && $project_status === 'publish' && !empty($proposal_status) && $proposal_status === 'publish' )){?>
                        <button class="tk-btn-solid-lg-lefticon <?php echo esc_attr($checkout_class);?>" data-key="" data-id="<?php echo intval($proposal_id);?>"><?php echo sprintf(esc_html__('Hire “%s”','taskbot'),$user_name);?></button>
            <?php } else {
                do_action( 'taskbot_hire_proposal_button', $proposal_id );
            } ?>
        </div>
    </div>
</div>
<div class="modal fade tk-declinereason" id="tb_decline_proposal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="tk-popup_title">
            <h5><?php esc_html_e('Add decline reason below','taskbot');?></h5>
            <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                <i class="icon-x"></i>
            </a>
        </div>
        <div class="modal-body tk-popup-content">
            <form class="tk-themeform">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <div class="tk-placeholderholder">
                                <textarea name="detail" id="tb_decline_detail" class="form-control tk-themeinput" placeholder="<?php esc_attr_e('Enter description','taskbot');?>"></textarea>
                            </div>
                        </div>
                        <div class="tk-popup-terms form-group">
                            <button type="button" class="tk-btn-solid-lg tb_decline_proposal" data-id="<?php echo intval($proposal_id);?>"><?php esc_html_e('Submit question now','taskbot');?><i class="icon-arrow-right"></i></button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        </div>
    </div>
</div>
<?php 
do_action('wpguppy_start_post_widget_chat', $proposal_id);
