<?php
/**
 * User profile avatar
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user;
?>
<script type="text/template" id="tmpl-load-profile-avatar">
    <div class="tb-popuptitle">
        <h4><?php esc_html_e('Upload profile photo', 'taskbot'); ?></h4>
        <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
    </div>
    <div class="modal-body">
        <form class="tb-dhb-orders-listing">
            <div id="crop_img_area"></div>
        </form>
        <div class="tb-dhb-mainheading__rightarea">
            <em> <?php esc_html_e('Click “Save” to update profile photo', 'taskbot'); ?></em>
            <a href="javascript:void(0);" class="tb-btn"><?php esc_html_e('Save', 'taskbot'); ?>
                <span class="rippleholder tb-jsripple" id="save-profile-img" ><em class="ripplecircle"></em></span>
            </a>
        </div>
    </div>
</script>
<script type="text/template" id="tmpl-load-profile-image">
	<img class="attachment_url" src="{{data.url}}" alt="{{data.name}}">
	<input type="hidden" name="basic[profile_image]" value="{{data.url}}">
</script>
<script type="text/template" id="tmpl-load-default-image">
	<figure id="thumb-{{data.id}}" >
		<img class="attachment_url" alt="<?php esc_attr_e('Profile avatar', 'taskbot' ); ?>">
		<div class="progress tb-upload-progressbar"><div style="width:{{data.percentage}}%" class="progress-bar"></div></div>
	</figure>
</script>