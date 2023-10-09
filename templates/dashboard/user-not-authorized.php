<?php
global $taskbot_settings
?>

<div class="tb-submitreview tb-submitreviewv3">
    <figure>
        <img src="<?php echo esc_url(!empty($taskbot_settings['empty_listing_image']['url']) ? $taskbot_settings['empty_listing_image']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/empty.png') ?>" alt="<?php esc_attr_e('task', 'taskbot'); ?>">
    </figure>
    <h4><?php esc_html_e('You are not authorized to access this page.', 'taskbot'); ?></h4>
</div>