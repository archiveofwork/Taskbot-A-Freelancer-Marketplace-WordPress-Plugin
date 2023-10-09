<?php
/**
 * Single task author details
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global $post,$current_user;
$taskbot_args               = array();
$post_id          = !empty($args['post_id']) ?  $args['post_id']: '';
$seller_name      = taskbot_get_username($post_id);
$tb_post_meta     = get_post_meta($post_id, 'tb_post_meta', true);
$seller_tagline   = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
?>
<div class="tk-asideholder">
    <div class="tk-aboutseller">
        <div class="tb-seller_detail">
            <div class="tk-topservicetask__content">
                <div class="tk-freelanlist">
                    <div class="tk-topservicetask__content">
                        <div class="tb-freeprostatus">
                            <?php do_action('taskbot_profile_image', $post_id,'',array('width' => 164, 'height' => 164));?>
                            <?php do_action('taskbot_user_hourly_starting_rate', $post_id,'',true); ?>
                        </div>
                        <div class="tk-title-wrapper">
                            <div class="tk-verified-info">
                                <?php if( !empty($seller_name) ){?>
                                    <strong>
                                        <a href="<?php echo esc_url( get_the_permalink($post_id)); ?>"><?php echo esc_html($seller_name); ?></a>
                                        <?php do_action( 'taskbot_verification_tag_html', $post_id ); ?>
                                    </strong>
                                <?php } ?>
                                <?php if( !empty($seller_tagline) ){?>
                                    <h5><a href="<?php echo esc_url( get_the_permalink($post_id)); ?>"><?php echo esc_html($seller_tagline); ?></a></h5>
                                <?php } ?>
                            </div>
                        </div>
                        <ul class="tk-blogviewdates tk-blogviewdatesmd">
                            <?php do_action('taskbot_get_freelancer_rating_cuont', $post_id); ?>
                            <?php do_action('taskbot_get_freelancer_views', $post_id); ?>
                        </ul>
                        <div class="tk-btnviewpro">
                            <a href="<?php echo esc_url( get_the_permalink($post_id)); ?>" class="tk-btn-solid-lg"><i class="tb-icon-message-square tb-msg-icon"></i>&nbsp;<?php esc_html_e('Contact this seller','taskbot');?></a>
                            <?php do_action('taskbot_save_freelancer_html', $current_user->ID, $post_id, '_saved_sellers', 'v2', 'sellers'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
