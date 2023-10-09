<?php
/**
 * Provide basic profile inofrmation
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public/partials
 */
global  $post,$current_user,$taskbot_settings;
$hide_languages       = !empty($taskbot_settings['hide_languages']) ? $taskbot_settings['hide_languages'] : 'no';
$currentuser_id  = !empty($current_user->ID) ? intval($current_user->ID) : 0;
$user_type      = !empty($currentuser_id) ? apply_filters('taskbot_get_user_type', $currentuser_id ) : '';
$post_id        = !empty($args['post_id']) ? intval($args['post_id']) : $post->ID;
$post_author    = get_post_field( 'post_author', $post_id );
$user_name      = taskbot_get_username($post_id);
$tb_post_meta   = get_post_meta( $post_id,'tb_post_meta',true );
$tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();
$tagline        = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';

$tb_location    = get_post_meta( $post_id,'location',true );
$tb_location    = !empty($tb_location) ? $tb_location : array();
$profile_views  = get_post_meta( $post_id,'taskbot_profile_views',true );
$profile_views  = !empty($profile_views) ? intval($profile_views) : 0;
$address        = apply_filters( 'taskbot_user_address', $post_id );
$user_rating    = get_post_meta( $post_id, 'tb_total_rating', true );
$user_rating    = !empty($user_rating) ? $user_rating : 0;
$review_users   = get_post_meta( $post_id, 'tb_review_users', true );
$review_users   = !empty($review_users) ? intval($review_users) : 0;
$user_id        = taskbot_get_linked_profile_id($post_id,'post');
$description	= !empty($tb_post_meta['description']) ? $tb_post_meta['description'] : '';

$completed_rate         = taskbot_complete_task_count($user_id);

$login_user_class   = 'tb_btn_checkout';
$tb_msgform         = 'data-type="task" data-url="'.get_the_permalink( $post ).'"';
if(!empty($currentuser_id)){
    $login_user_class   = '';
    $tb_msgform         = 'data-bs-toggle="modal" data-bs-target="#tb_msgform"';
}
?>
<div class="tb-asideholder tb-seller-profile-two">
    <div class="tb-asidebox">
        <?php do_action( 'taskbot_profile_image', $post_id,true,array('width' => 200, 'height' => 200));?>
        <div class="tb-icondetails">
            <?php if( !empty($tagline) ){?>
                <h5><?php echo esc_html($tagline);?></h5>
            <?php } ?>
            <ul class="tb-rateviews">
            <?php do_action('taskbot_get_freelancer_rating_cuont', $post_id); ?>
                <?php do_action('taskbot_get_freelancer_views', $post_id); ?>
                <?php do_action('taskbot_save_freelancer_html', $currentuser_id, $post_id, '_saved_sellers', '', 'sellers'); ?>
            </ul>
            <?php if( !empty($description) ){?>
                <div class="tb-description-area description-with-more"><p><?php echo do_shortcode(nl2br($description));?></p></div>
            <?php } ?>
            <?php do_action( 'taskbot_seller_hourly_rate_html', $post_id );?>
            <?php if( !empty($address) ){?>
                <div class="tb-sidebarcontent">
                    <div class="tb-sidebarinnertitle">
                        <h6><?php esc_html_e('Location:','taskbot');?></h6>
                        <h5><?php echo esc_html($address);?></h5>
                    </div>
                </div>
            <?php } ?>
            <?php do_action( 'taskbot_texnomies_static_html', $post_id,'tb_seller_type',esc_html__('Seller type','taskbot') );?>
            <?php do_action( 'taskbot_texnomies_static_html', $post_id,'languages',esc_html__('Languages','taskbot') );?>
            <?php  if(!empty($hide_languages ) && $hide_languages == 'no'){do_action( 'taskbot_texnomies_static_html', $post_id,'tb_english_level',esc_html__('English level','taskbot') );}?>
            <?php if( (!empty($user_type) && $user_type === 'buyers' || !is_user_logged_in()) && !empty($post_author) && $post_author != $currentuser_id && (in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins'))))){?>
                <div class="tb-sidebarcontent">
                    <div class="tb-sidebarinnertitle">
                    <a href="javascript:;" class="tb-btn <?php echo esc_attr($login_user_class);?>" <?php echo do_shortcode( $tb_msgform );?>><i class="tb-icon-message-square"></i><?php esc_html_e('Contact to this seller','taskbot');?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="modal fade tb-startchat" id="tb_msgform" role="dialog">
    <div class="modal-dialog tb-modaldialog" role="document">
        <div class="modal-content">
            <div class="tb-popuptitle">
                <h4 id="tb_ratingtitle"><?php echo sprintf(esc_html__('Send a message to “%s“','taskbot'),$user_name);?></h4>
                <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
            </div>
            <div class="modal-body" id="tb_startcaht_form">
                <div class="tb-startchat-field">
                    <textarea class="form-control" id="tb_message" name="message" placeholder="<?php esc_attr_e('Type your message','taskbot');?>"></textarea>
                    <a href="javascript:void(0);" data-post_id="<?php echo intval($post_id);?>"  class="tb-btn tb_sentmsg_task"><?php esc_html_e('Send message','taskbot');?></a>               
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$script = "TaskbotShowMore();";
wp_add_inline_script( 'taskbot', $script, 'after' );
