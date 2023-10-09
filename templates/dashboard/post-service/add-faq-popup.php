<?php
/**
 * FAQ form fields
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/post_services
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */
?>
<div class="modal fade tb-addonpopup" id="addnewfaq" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog tb-modaldialog" role="document">
        <div class="modal-content">
            <div class="tb-popuptitle">
                <h4><?php esc_html_e('Add new FAQ', 'taskbot'); ?></h4>
                <span class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></span>
            </div>
            <div class="modal-body">
                <form class="tb-themeform tb-formlogin" id="tb-faq-form">
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
                                <span" class="tb-btn" id="tb-faqs-addlist"><?php esc_html_e('Save & Update', 'taskbot'); ?></span>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>