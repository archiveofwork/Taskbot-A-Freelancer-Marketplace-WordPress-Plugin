    <?php
    /**
     * User registration
     *
     * @package     Taskbot
     * @subpackage  Taskbot/templates
     * @author      Amentotech <info@amentotech.com>
     * @link        https://wp-guppy.com/taskbot
     * @version     1.0
     * @since       1.0
     */
    global  $taskbot_settings;
    $view_type          = !empty($taskbot_settings['registration_view_type']) ? $taskbot_settings['registration_view_type'] : 'pages';
    $hide_registration  = !empty($taskbot_settings['hide_registration']) ? $taskbot_settings['hide_registration'] : 'no';
    $redirect           = !empty($_GET['redirect']) ? $_GET['redirect'] : '';
    $login_class        = '';

    if( !empty($hide_registration) && $hide_registration == 'yes' ){

        echo wp_sprintf(__('Registration is disabled by the admin, <a href="%s">click here</a> to go back to the site ', 'taskbot'), home_url('/'));
        return;
    }

    if( !empty($view_type) && $view_type === 'popup' ){
        $login_class        = 'tk-login-poup';
        $login_page         = 'javascript:;';
    }
    ?>
    <div class="tk-loginconatiner">
        <?php if (!empty($background_banner)) { ?>
            <figure> <img src="<?php echo esc_attr($background_banner); ?>" alt="<?php esc_attr_e('Registration', 'taskbot'); ?>"></figure>
        <?php } ?>
        <div class="tk-popupcontainer">
            <div class="tk-login_title">
                <?php if (!empty($logo)) { ?>
                    <a href="<?php echo site_url(); ?>">
                        <img src="<?php echo esc_attr($logo); ?>" alt="<?php esc_attr_e('Registration', 'taskbot'); ?>">
                    </a>
                <?php } ?>
                <?php if (!empty($tagline)) { ?>
                    <h5><?php echo do_shortcode(nl2br($tagline)); ?></h5>
                <?php } ?>
            </div>
            <div class="tk-login-content tk-popup-content">
                <form class="tk-themeform user-registration-form" id="userregistration-from">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <?php do_action('taskbot_user_registration_fields_before'); ?>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <input type="hidden" name="redirect" value="<?php echo esc_attr($redirect);?>">
                                    <input type="text" name="user_registration[first_name]" class="form-control" required="required" placeholder="<?php esc_attr_e('First name*', 'taskbot'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <input type="text" name="user_registration[last_name]" class="form-control" required="required" placeholder="<?php esc_attr_e('Last name*', 'taskbot'); ?>">
                                </div>
                            </div>
                            <?php if (!empty($user_name_option)) { ?>
                                <div class="form-group">
                                    <div class="tk-placeholderholder">
                                        <input type="text" name="user_registration[user_name]" class="form-control" required="required" placeholder="<?php esc_attr_e('User name*', 'taskbot'); ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <input type="email" name="user_registration[user_email]" class="form-control" required="required" placeholder="<?php esc_attr_e('Your email address*', 'taskbot'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <input type="password" id="user_password" name="user_registration[user_password]" class="tb-password form-control" required="required" placeholder="<?php esc_attr_e('Enter password*', 'taskbot'); ?>">
                                </div>
                            </div>
                            <?php if (!empty($user_types)) { ?>
                                <div class="form-group tb-reg-option">
                                    <?php foreach ($user_types as $key => $value) {
                                        $checked    = '';
                                        if (!empty($defult_register_type) && $defult_register_type === $key) {
                                            $checked    = 'checked';
                                        }
                                    ?>
                                        <div class="tb-radio">
                                            <input <?php echo esc_attr($checked); ?> id="tb_<?php echo esc_attr($key); ?>" type="radio" value="<?php echo esc_attr($key); ?>" name="user_registration[user_type]">
                                            <label for="tb_<?php echo esc_attr($key); ?>">
                                                <span><?php echo esc_html($value); ?> </span>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="form-group tb-form-btn am-registration-terms">
                                <div class="tb-checkterm">
                                    <div class="tb-checkbox">
                                        <input type="checkbox" value="" name="user_registration[user_agree_terms]">
                                        <input id="user_agree_terms" value="yes" type="checkbox" name="user_registration[user_agree_terms]">
                                        <label for="user_agree_terms">
                                            <span><?php echo sprintf(esc_html__('I have read and agree to all %s and %s', 'taskbot'), $term_link, $privacy_link); ?> </span>
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="tb-btn tb-signup-now"><?php esc_html_e('Join Now', 'taskbot'); ?></button>
                            </div>
                            <?php
                            do_action('taskbot_user_registration_fields_after');
                            if (!empty($google_connect)) {?>
                                <div class="tk-optioanl-or">
                                    <span><?php esc_html_e('OR', 'taskbot') ?></span>
                                </div>
                                <div class="form-group tk-sginup-btn">
                                    <div id="google_signup"></div>
                                </div>
                            <?php } ?>
                            <div class="form-group tk-lost-password">
                                <a href="<?php echo do_shortcode($login_page); ?>" class="tk-login-btn <?php echo esc_attr($login_class);?>"><?php esc_html_e('Sign In today', 'taskbot'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <?php
