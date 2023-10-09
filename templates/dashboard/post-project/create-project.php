<?php
/**
 *  Create project basic
 *
 * @package     Taskbot
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
$post_id        = !empty($post_id) ? intval($post_id) : "";
$post_url       = !empty($post_url) ? esc_url($post_url) : "";
$new_job_url    = !empty($post_id) ? $post_url.'?step=2&post_id='.intval($post_id) : $post_url.'?step=2';
$duplicate_job  = !empty($post_url) ? $post_url.'?page_temp=projects' : '';
?>
<div class="row justify-content-center">
    <div class="col-xl-8 text-center">
        <div class="tk-postproject-title">
            <h3><?php esc_html_e('Choose where to start your project','taskbot');?></h3>
            <p><?php esc_html_e('You can start a new project from scratch or you can use your previous posted job template','taskbot');?></p>
        </div>
        <ul class="tk-newproject-list">
            <li>
                <a href="<?php echo esc_url($new_job_url);?>" class="tk-postproject-new">
                    <i class="tb-icon-file-text tk-purple-icon"></i>
                    <span><?php esc_html_e('Start a new project','taskbot');?></span>
                    <p><?php esc_html_e('Create a new project from scratch','taskbot');?></p>
                </a>
            </li>
            <li>
                <a href="<?php echo esc_url($duplicate_job);?>
                " class="tk-postproject-new">
                    <i class="tb-icon-copy tk-red-icon"></i>
                    <span><?php esc_html_e('Use template instead','taskbot');?></span>
                    <p><?php esc_html_e('Create a new project using previous project','taskbot');?></p>
                </a>
            </li>
        </ul>
    </div>
</div>