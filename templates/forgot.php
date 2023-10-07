<?php
/**
 * forgot password form
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global  $taskbot_settings;
$google_logo        = taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/google.png');
$google_logo        = !empty($google_logo) ? $google_logo : '';
$view_type          = !empty($taskbot_settings['registration_view_type']) ? $taskbot_settings['registration_view_type'] : 'pages';
$hide_registration          = !empty($taskbot_settings['hide_registration']) ? $taskbot_settings['hide_registration'] : 'no';

$reg_class          = '';
$login_class        = '';

if( !empty($view_type) && $view_type === 'popup' ){
    $reg_class          = 'tk-signup-poup-btn';
    $login_class        = 'tk-login-poup';
    $registration_page  = 'javascript:;';
    $login_page         = 'javascript:;';
}
?>
<div class="tk-loginconatiner">
    <?php if(!empty($background_banner)){?>
        <figure> <img src="<?php echo esc_url($background_banner);?>" alt="<?php esc_attr_e('Site banner', 'taskbot');?>"></figure>
    <?php }?>
    <div class="tk-popupcontainer">
        <div class="tk-login_title">
            <?php if(!empty($logo)){?>
                <a href="<?php echo esc_url( site_url('/')); ?>">
                    <img src="<?php echo esc_url($logo);?>" alt="<?php esc_attr_e('Site logo', 'taskbot');?>">
                </a>
            <?php }?>
            <?php if(!empty($tagline)){?>
                <h5><?php echo do_shortcode(nl2br($tagline));?></h5>
            <?php }?>
        </div>
        <div class="tk-login-content tk-popup-content">
            <form class="tk-themeform tb-forgot-password-form">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <?php if ( !empty($reset_key) && !empty($reset_action) && !empty($user_email)) { ?>
                            <input type="hidden" name="key" value="<?php echo esc_attr($reset_key); ?>" />
                            <input type="hidden" name="reset_action" value="<?php echo esc_attr($reset_action); ?>" />
                            <input type="hidden" name="login" value="<?php echo esc_attr($user_email); ?>" />
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <input type="password" name="fotgot[password]" class="form-control" required="required" placeholder="<?php esc_attr_e('Type password','taskbot');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <input type="password" name="fotgot[re_password]" class="form-control" required="required" placeholder="<?php esc_attr_e('Re-type password','taskbot');?>">
                                </div>
                            </div>
                            <div class="tk-popup-terms">
                                <button type="submit" name="submit" class="tk-btn-solid-lg btn-reset-pass"><?php esc_html_e('Reset Password','taskbot');?><i class="icon-arrow-right"></i></button>
                            </div>
                        <?php } else {?>
                            <?php do_action('taskbot_forgot_password_fields_before');?>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <input type="text" name="fotgot[email]" class="form-control" required="required" placeholder="<?php esc_attr_e('Add email or username','taskbot');?>">
                                </div>
                            </div>
                            <div class="tk-popup-terms">
                                <button type="submit" name="submit" class="tk-btn-solid-lg btn-forget-pass"><?php esc_html_e('Send reset link','taskbot');?><i class="icon-arrow-right"></i></button>
                            </div>
                        <?php } ?>
                        <div class="tk-lost-password">
                            <?php if( !empty($hide_registration) && $hide_registration != 'yes' ){?>
                                <a href="<?php echo do_shortcode($registration_page);?>" class="tk-reg <?php echo esc_attr($reg_class);?>"><?php esc_html_e('Join us today', 'taskbot');?></a>
                            <?php }?>
                            <a href="<?php echo do_shortcode($login_page);?>" class="tk-login-btn <?php echo esc_attr($login_class);?>"><?php esc_html_e('Sign In', 'taskbot');?></a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
$script = "
jQuery(document).on('ready', function(){
    jQuery('.form-control').on('input', function () {
        jQuery(this).siblings('.tk-placeholder').hide();
        if (jQuery(this).val().length == 0)
        jQuery(this).siblings('.tk-placeholder').show();
    });
    jQuery('.form-control').blur();
});
";
wp_add_inline_script( 'taskbot', $script, 'after' );