<?php
/**
 *
 * The template used for displaying buyer post style
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $post;
do_action('taskbot_post_views', $post->ID,'taskbot_profile_views');
get_header();
while (have_posts()) : the_post();
    global $post;
    $taskbot_args               = array();
    $taskbot_args['post_id']    = $post->ID;
    ?>
    <div class="tb-main-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <aside class="tb-tabasidebar">
                        <div class="tb-asideholder"> </div>
                    </aside>
                </div>
                <div class="col-lg-8">
                    <div class="tb-sort">
                        <h3><?php esc_html_e('Offered tasks','taskbot');?></h3>                           
                    </div>                        
                </div>
            </div>
        </div>
    </div>
    <?php 
endwhile;
get_footer();