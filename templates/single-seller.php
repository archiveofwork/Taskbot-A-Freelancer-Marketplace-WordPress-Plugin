<?php
/**
 *
 * The template used for displaying seller post style
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
    $taskbot_args                   = array();
    $taskbot_args['post_id']        = $post->ID;
    $taskbot_args['user_id']        = taskbot_get_linked_profile_id( $post->ID,'post');
    $taskbot_args['post_status']    = array('publish'); 
    $skills                         = get_the_terms($post->ID, 'skills');
    $app_task_base      		    = taskbot_application_access('task');
    $skills_base                    = 'project';
    if( !empty($app_task_base) ){
        $skills_base    = 'service';
    }
   
    ?>
    <div class="tb-main-section tb-main-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-xl-4">
                    <aside class="tb-tabasidebar tb-single-seller">
                        <div class="tb-asideholder">
                            <?php taskbot_get_template( 'single-seller/profile-basic.php',$taskbot_args);?>
                            <?php if( !empty($skills) ){ ?>
                                <div class="tb-asidebox tb-freelancerinfo tb-seller-skills">
                                    <div class="tb-freesingletitle">
                                        <h4><?php esc_html_e('Skills','taskbot');?></h4>
                                    </div>
                                    <?php do_action( 'taskbot_term_tags', $post->ID,'skills','',5,$skills_base );?>
                                </div>
                            <?php } ?>
                            <?php taskbot_get_template( 'single-seller/profile-education.php',$taskbot_args);?>
                        </div>
                    </aside>
                </div>
                <?php if( !empty($app_task_base) ){?>
                    <div class="col-lg-7 col-xl-8">
                        <div class="tb-sort tb-sellersort">
                            <h3><?php esc_html_e('Offered tasks','taskbot');?></h3>
                        </div>
                        <?php taskbot_get_template( 'single-seller/profile-services.php',$taskbot_args);?>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-8">
                        <div class="tb-sort">
                            <h3><?php esc_html_e('Completed projects','taskbot');?></h3>
                        </div>
                        <?php taskbot_get_template( 'single-seller/profile-completed-projects.php',$taskbot_args);?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php     
endwhile;
get_footer();