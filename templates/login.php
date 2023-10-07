<?php

/**
 * login form
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */
global  $taskbot_settings;
$google_connect     = !empty($taskbot_settings['enable_social_connect']) ? $taskbot_settings['enable_social_connect'] : '';
$view_type          = !empty($taskbot_settings['registration_view_type']) ? $taskbot_settings['registration_view_type'] : 'pages';
$hide_registration  = !empty($taskbot_settings['hide_registration']) ? $taskbot_settings['hide_registration'] : 'no';
$redirect           = !empty($_GET['redirect']) ? $_GET['redirect'] : '';
$reg_class          = '';
$lost_pass          = '';

if( !empty($view_type) && $view_type === 'popup' ){
    $reg_class          = 'tk-signup-poup-btn';
    $lost_pass          = 'tk-pass-poup-btn';
    $registration_page  = 'javascript:;';
    $forgot_pass_page   = 'javascript:;';
}
?>
<div class="tk-loginconatiner">
    <?php if (!empty($background_banner)) { ?>
        <figure><img src="<?php echo esc_attr($background_banner); ?>" alt="<?php esc_attr_e('Sign In', 'taskbot'); ?>"></figure>
    <?php } ?>
    <div class="tk-popupcontainer">
        <div class="tk-login_title">
            <?php if (!empty($logo)) { ?>
                <a href="<?php echo site_url(); ?>">
                    <img src="<?php echo esc_attr($logo); ?>" alt="<?php esc_attr_e('Sign In', 'taskbot'); ?>">
                </a>
            <?php } ?>
            <?php if (!empty($tagline)) { ?>
                <h5><?php echo do_shortcode(nl2br($tagline)); ?></h5>
            <?php } ?>
        </div>
        <div class="tk-login-content tk-popup-content">
            <form class="tk-themeform tb-formlogin">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <?php do_action('taskbot_render_fields_before');  ?>
                        <div class="form-group">
                            <div class="tk-placeholderholder">
                                <input type="hidden" name="redirect" value="<?php echo esc_attr($redirect);?>">
                                <input name="signin[email]" type="text" class="form-control" required="required" placeholder="<?php esc_attr_e('Add email or username', 'taskbot'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="tk-placeholderholder">
                                <input type="password" name="signin[user_password]" class="form-control" required="required" placeholder="<?php esc_attr_e('Enter password', 'taskbot'); ?>">
                            </div>
                        </div>
                        <?php do_action('taskbot_render_fields_after'); ?>
                        <div class="form-group tb-form-btn ">
                            <div class="tb-checkterm">
                                <button type="submit" class="tb-btn tb-signin-now"><?php esc_html_e('Login now', 'taskbot'); ?></button>
                            </div>
                            <?php if (!empty($google_connect)) { ?>
                                <div class="tk-optioanl-or">
                                    <span><?php esc_html_e('OR', 'taskbot') ?></span>
                                </div>
                                <div class="tk-sginup-btn">
                                    <div id="google_signin"></div>
                                </div>
                            <?php } ?>
                            <div class="tk-lost-password">
                                <?php if( !empty($hide_registration) && $hide_registration != 'yes' ){?>
                                    <a href="<?php echo do_shortcode($registration_page); ?>" class="tk-reg <?php echo esc_attr($reg_class);?>"><?php esc_html_e('Join us today', 'taskbot'); ?></a>
                                <?php }?>
                                <a href="<?php echo do_shortcode($forgot_pass_page); ?>" class="tk-password-clr_light <?php echo esc_attr($lost_pass);?>"><?php esc_html_e('Lost password?', 'taskbot'); ?></a>
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
wp_add_inline_script('taskbot', $script, 'after');
