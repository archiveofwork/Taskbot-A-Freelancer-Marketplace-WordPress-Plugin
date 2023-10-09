<?php
/**
 *  Add task basic template
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/post_services
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $taskbot_settings;

if (!class_exists('WooCommerce')) {
    return;
}

$lists      = taskbot_service_list();
$step       = !empty($_GET['step']) ? intval($_GET['step']) : 1;
$post_id    = !empty($_GET['post']) ? intval($_GET['post']) : 0;
$page_url   = !empty($taskbot_settings['tpl_add_service_page']) ? get_permalink($taskbot_settings['tpl_add_service_page']) : '';
$post_status= !empty($post_id) ? get_post_status( $post_id ) : '';
?>
<div class="tb-postservice tb-postservicev2">
    <ul class="tb-addservice-steps">
        <?php foreach($lists as $key => $value ){
            $title  = !empty($value['title']) ? $value['title'] : '';
            $class  = !empty($value['class']) ? $value['class'] : '';
            $active_class   = '';

            if( !empty($step) && $step > $key ){
                $active_class   = 'tb-addservice-step-complete';
            }

            if( !empty($step) && $step == $key ){
                $active_class   = 'tb-addservice-step-fill';
            }

            $step_url   = '#';
            $steps_class    = 'service-steps';

            if( !empty($post_id)){
                if( !empty($step) && $step > $key ) {
                    $step_url = add_query_arg(array(
                        'post' => $post_id,
                        'step' => $key,
                    ), $page_url);
                }
                $steps_class    = 'service-steps service-steps-draft';
            }
            
            if( !empty($post_status) && $post_status == 'publish' ){
                $step_url   = add_query_arg( array(
                    'post' => $post_id,
                    'step' => $key,
                ), $page_url );
                $steps_class    = 'service-steps';
            }?>
            <li>
                <div class="task-step-<?php echo intval($key);?> <?php echo esc_attr($class);?> <?php echo esc_attr($active_class);?>">
                    <a href="<?php echo esc_url($step_url);?>" class="<?php echo esc_attr($steps_class);?>"><span><?php echo esc_html($title);?></span></a>
                </div>
            </li>
        <?php } ?>
    </ul>
    <?php do_action('taskbot_add_services_steps_before'); ?>
    <div class="tb-addservices-steps" id="tb-services-steps">
        <?php do_action('taskbot_add_services_steps', $args);?>
    </div>
    <?php do_action('taskbot_add_services_steps_after'); ?>
</div>
<?php
$script = "
jQuery(document).on('ready', function($){
    jQuery('#service-plans-form').validate();
    // SORTABLE
    if(jQuery('#tbslothandle').length > 0){
        new Sortable(tbslothandle, {
            handle: '.tb-bar-handle',
            animation: 150
        });
    }  
    if(jQuery('#tbslothandle').length > 0){
        new Sortable(tbslothandle, {
            animation: 150
        });
    }
});";
wp_add_inline_script( 'taskbot', $script, 'after' );
