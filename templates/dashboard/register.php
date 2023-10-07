<div class="lb-loginconatiner" id="userregistration">
   	<?php if(!empty($background_banner)){?>
   	 	<figure> <img src="<?php echo esc_attr($background_banner);?>" alt="<?php esc_attr_e('Registration', 'taskbot');?>"></figure>
    <?php }?>
    <div class="tb-popupcontainer tb-popupcontainervtwo">
        <div class="tb-popuptitle">
            <h4><?php esc_html_e('Join Our Community', 'taskbot');?></h4>
        </div>
        <div class="modal-body">
            <form id="userregistration-from" class="user-registration-form tb-themeform tb-formlogin">
                <fieldset>
                    <?php
                    do_action('taskbot_user_registration_fields_before', $registration_fields);
                    do_action('taskbot_render_user_registration_fields', $registration_fields);
                    do_action('taskbot_render_acf_user_registration_fields', $registration_fields);
                    do_action('taskbot_user_registration_fields_after', $registration_fields);
                    ?>
                </fieldset>
            </form>
        </div>
        <div class="modal-footer tb-loginfooterinfo">
            <a href="<?php echo esc_url($login_page);?>"><em><?php esc_html_e('Already have account?', 'taskbot');?></em>&nbsp;<?php esc_html_e('Sign In Now', 'taskbot');?></a>
        </div>
    </div>
</div>