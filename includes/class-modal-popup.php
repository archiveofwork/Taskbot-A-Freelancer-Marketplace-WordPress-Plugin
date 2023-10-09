<?php
namespace thickboxmodel;
// die if accessed directly
if (!defined('ABSPATH')) {
  die('no kiddies please!');
}

/**
 *
 * Class 'Taskbot_Modal_Popup' defines the bootstrap modal
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

if (!class_exists('Taskbot_Modal_Popup')) {

    class Taskbot_Modal_Popup
    {

        public function __construct()
        {
            add_action('wp_footer', array($this, 'taskbot_prepare_modal_popup'));
            add_action('wp_footer', array($this, 'taskbot_faq_modal_popup'));
            add_action('wp_footer', array($this, 'taskbot_reject_task'));
        }

        /**
         * Task add-ons popup
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
        */
        public function taskbot_prepare_modal_popup()
        {
            ob_start();
            ?>
            <div class="modal hidden fade taskbot-profilepopup tb-addonspopup" tabindex="-1" role="dialog" id="taskbot-modal-popup">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="taskbot-modalcontent modal-content">
                        <div id="taskbot-model-body"></div>
                    </div>
                </div>
            </div>
            
            <div class="modal hidden fade taskbot-profilepopup tb-addonspopup" tabindex="-1" role="dialog" id="taskbot-taskaddon-popup">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="taskbot-modalcontent modal-content">
                        <div class="tb-popuptitle">
                            <h4></h4>
                            <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
                        </div>
                        <div id="taskbot-model-body" class="modal-body"></div>
                    </div>
                </div>
            </div>

            <div class="modal fade tb-creditwallet" id="tbcreditwallet" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="tb-popuptitle">
                        <h4><?php esc_html_e('Add credit to your wallet', 'taskbot'); ?></h4>
                        <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
                        </div>
                        <div class="modal-body">
                        <form class="tb-themeform">
                            <fieldset>
                            <div class="form-group">
                                <input type="text" id="tb_wallet_amount" class="form-control" placeholder="<?php esc_attr_e('Enter amount', 'taskbot'); ?>" name="amount" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <span class="tb-btn"
                                id="tb_submit_fund"><?php esc_html_e('Add funds now', 'taskbot'); ?><i
                                    class="tb-icon-arrow-right"></i></span>
                            </div>
                            </fieldset>
                        </form>
                        <div class="tb-checkoutbox">
                            <em>*</em>
                            <span><?php esc_html_e('You will be redirected to the checkout page to add your billing details.', 'taskbot'); ?></span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade tb-modal" id="taskbot-popup" tabindex="-1" role="dialog" aria-hidden="true"></div>
            <?php
            echo ob_get_clean();
        }

        /**
         * Task FAQ's popup
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
        */
        public static function taskbot_faq_modal_popup()
        {
            global $taskbot_settings;
            $view_type          = !empty($taskbot_settings['registration_view_type']) ? $taskbot_settings['registration_view_type'] : 'pages';
            ob_start();
            if ( !is_user_logged_in() && !empty($view_type) && $view_type === 'popup' ) { 
                $logo               = !empty($taskbot_settings['popup_logo']['url']) ? $taskbot_settings['popup_logo']['url'] : '';
                $bg_image           = '';
                $tagline            = esc_html__('We love to see you joining us','taskbot');
                $logintagline       = esc_html__('Welcome! Nice to see you again','taskbot');
                $reset_pass_tagline = esc_html__('Lost password? No need to worry, we’ll send you the password reset link','taskbot');
                $after_reset_pass_tagline = esc_html__('Reset your password','taskbot');
                if ( isset($_GET['action']) && $_GET['action'] == 'reset_pwd' ) {
                    $script = "
                    jQuery(document).on('ready', function(){
                        jQuery('#tk-pass-model').modal('show');
                        jQuery('#tk-pass-model').removeClass('hidden');
                    });
                    ";
                    wp_add_inline_script( 'taskbot', $script, 'after' );
                }
                ?>
                <div class="modal fade tk-reg-popups" id="tk-login-model" tabindex="-1" aria-labelledby="tk-login-modelLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content tk-login-popup-content">
                            <div class="modal-body">
                                <a href="javascript:void(0)" class="tk-loginclose-tag" data-bs-dismiss="modal"><i class="tb-icon-x"></i></a>
                                <?php echo do_shortcode('[taskbot_signin background="'.$bg_image.'" logo="'.$logo.'" tagline="'.$logintagline.'" ]');?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade tk-reg-popups" id="tk-signup-model" tabindex="-1" aria-labelledby="tk-signup-modelLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content tk-signup-popup-content">
                            <div class="modal-body">
                                <a href="javascript:void(0)" class="tk-loginclose-tag" data-bs-dismiss="modal"><i class="tb-icon-x"></i></a>
                                <?php echo do_shortcode('[taskbot_registration background="'.$bg_image.'" logo="'.$logo.'" tagline="'.$tagline.'" ]');?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade tk-reg-popups" id="tk-pass-model" tabindex="-1" aria-labelledby="tk-pass-modelLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content tk-pass-popup-content">
                            <div class="modal-body">
                                <a href="javascript:void(0)" class="tk-loginclose-tag" data-bs-dismiss="modal"><i class="tb-icon-x"></i></a>
                                <?php echo do_shortcode('[taskbot_forgot background="'.$bg_image.'" logo="'.$logo.'" tagline="'.$reset_pass_tagline.'" reset_pass_tagline="'.$after_reset_pass_tagline.'" ]');?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
            <!-- Add New Faq Popup Start-->
            <div class="modal fade tb-addonpopup" id="addnewfaq" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog tb-modaldialog" role="document">
                    <div class="modal-content">

                        <div class="tb-popuptitle">
                            <h4><?php esc_html_e('Add new FAQ', 'taskbot'); ?></h4>
                            <span class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></span>
                        </div>            
                        <div class="modal-body">
                            <form class="tb-themeform tb-formlogin">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="form-group-title"><?php esc_html_e('Add faq title', 'taskbot'); ?>:</label>
                                        <input type="text" id="service-question" class="form-control" placeholder="<?php esc_attr_e('Enter question here', 'taskbot'); ?>" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-group-title"><?php esc_html_e('Add faq description', 'taskbot'); ?>:</label>
                                        <textarea class="form-control" id="service-answer" placeholder="<?php esc_attr_e('Enter brief answer', 'taskbot'); ?>"></textarea>
                                    </div>
                                    <div class="form-group tb-form-btn">
                                        <div class="tb-savebtn">
                                        <span><?php esc_html_e('Click “Save & Update” to update your faq', 'taskbot'); ?></span>
                                        <span class="tb-btn"
                                            id="tb-faqs-addlist"><?php esc_html_e('Save & Update', 'taskbot'); ?></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            echo ob_get_clean();
        }

        /**
         * Reject task popup
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
        */
        public function taskbot_reject_task()
        {
            ?>
            <div class="modal fade tb-taskreject" id="tb-reject-task" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                    <h4><?php esc_html_e('Reject task approval request', 'taskbot'); ?></h4>
                    <span class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></span>
                    </div>
                    <div class="modal-body">
                    <form class="tb-themeform">
                        <fieldset>
                        <div class="form-group">
                            <textarea class="form-control" rows="6" cols="80" id="tb_reject_task_reason" name="tb_reject_task_reason" placeholder="<?php esc_attr_e('Add rejection reason', 'taskbot'); ?>"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="tb-btn tb_rejected_task" data-tb_task_id="" id="tb_submit_reject_task"><?php esc_html_e('Send', 'taskbot'); ?></span>
                        </div>
                        </fieldset>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            <?php
        }

    }

}

new Taskbot_Modal_Popup();
