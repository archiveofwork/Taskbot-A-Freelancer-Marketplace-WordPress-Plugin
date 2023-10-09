<?php

/**
 * Provide a public-facing hooks
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot/public/partials
 */
if (!class_exists('Taskbot_Template_Functions')) {
    class Taskbot_Template_Functions
    {
        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @param      string    $taskbot      The name of the plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct()
        {
            add_action('taskbot_product_ads_content', array($this, 'taskbot_product_ads_content'));
            add_action('taskbot_saved_item', array($this, 'taskbot_saved_item'), 10, 4);
            add_action('taskbot_saved_item_theme', array($this, 'taskbot_saved_item_theme'), 10, 3);
            add_action('taskbot_package_details', array($this, 'taskbot_package_details'), 10, 2);
            add_action('taskbot_profile_image', array($this, 'taskbot_profile_image'), 10, 3);
            add_action('taskbot_profile_image_theme', array($this, 'taskbot_profile_image_theme'), 10, 1);
            add_action('taskbot_service_item_reviews', array($this, 'taskbot_service_item_reviews'));
            add_action('taskbot_service_item_status', array($this, 'taskbot_service_item_status'));
            add_action('taskbot_service_item_queue', array($this, 'taskbot_service_item_queue'));
            add_action('taskbot_service_item_completed', array($this, 'taskbot_service_item_completed'));
            add_action('taskbot_service_item_cancelled', array($this, 'taskbot_service_item_cancelled'));
            add_action('taskbot_user_hourly_starting_rate', array($this, 'taskbot_user_hourly_starting_rate'), 10, 3);
            add_action('taskbot_service_item_starting_price', array($this, 'taskbot_service_item_starting_price'));
            add_action('taskbot_service_item_starting_price_theme', array($this, 'taskbot_service_item_starting_price_theme'));
            add_action('taskbot_task_price_plans', array($this, 'taskbot_task_price_plans'));
            add_action('taskbot_task_additional_services', array($this, 'taskbot_task_additional_services'));
            add_action('taskbot_task_tags', array($this, 'taskbot_task_tags'));
            add_action('taskbot_task_rating', array($this, 'taskbot_task_rating'));
            add_action('taskbot_service_item_views', array($this, 'taskbot_service_item_views'));
            add_action('taskbot_service_item_views_theme', array($this, 'taskbot_service_item_views_theme'));
            add_action('taskbot_service_download', array($this, 'taskbot_service_download'));
            add_action('taskbot_service_ratings', array($this, 'taskbot_service_ratings'));
            add_action('taskbot_service_delivery_time', array($this, 'taskbot_service_delivery_time'), 5, 2);
            add_action('taskbot_service_sales', array($this, 'taskbot_service_sales'), 5, 2);
            add_action('taskbot_post_views', array($this, 'taskbot_post_views'), 5, 2);
            add_action('taskbot_term_tags', array($this, 'taskbot_term_tags'), 5, 5);
            add_action('taskbot_service_rating_count', array($this, 'taskbot_service_rating_count'));
            add_action('taskbot_service_rating_count_theme', array($this, 'taskbot_service_rating_count_theme'));
            add_action('taskbot_service_rating_count_theme_v2', array($this, 'taskbot_service_rating_count_theme_v2'));
            add_action('taskbot_service_featured_item', array($this, 'taskbot_service_featured_item'));
            add_action('taskbot_featured_item', array($this, 'taskbot_featured_item'),10,2);
            add_action('taskbot_service_featured_item_theme', array($this, 'taskbot_service_featured_item_theme'));
            add_action('taskbot_task_video_theme', array($this, 'taskbot_task_video_theme'));
            add_action('taskbot_service_gallery_count', array($this, 'taskbot_service_gallery_count'));
            add_action('taskbot_task_gallery_theme', array($this, 'taskbot_task_gallery_theme'));
            add_action('taskbot_task_gallery_theme_v2', array($this, 'taskbot_task_gallery_theme_v2'),10,3);
        }

        /**
         * Ads display
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_product_ads_content() {
            global $taskbot_settings;
            $ads_content = !empty($taskbot_settings['ads_content']) ? $taskbot_settings['ads_content'] : '';
            ob_start();
            if($ads_content){
                do_shortcode('<div class="tk-sidebarad">'.$ads_content.'</div>');
            }
            echo ob_get_clean();
        }

        /**
         * Seller package detail
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_package_details($package = '',$show_btn=true) {

            if ( !class_exists('WooCommerce') ||  empty($package)) {
                return;
            }

            $package_id             = $package->get_id();
            
            if($package->get_type() == 'buyer_packages'){

                $package_type    		= get_post_meta( $package_id, 'package_type', true );
                $type					= taskbot_price_plans_duration($package_type);
                $package_duration    	= get_post_meta( $package_id, 'package_duration', true );
                $number_projects_allowed   = get_post_meta( $package_id, 'number_projects_allowed', true );
                $featured_projects_allowed = get_post_meta( $package_id, 'featured_projects_allowed', true );
                $featured_projects_duration    	= get_post_meta( $package_id, 'featured_projects_duration', true );
                $featured_projects_duration = !empty( $featured_projects_duration ) ? intval( $featured_projects_duration ) : 0;
                $featured_projects_allowed = !empty( $featured_projects_allowed ) ? intval( $featured_projects_allowed ) : 0;
                $number_projects_allowed = !empty( $number_projects_allowed ) ? intval( $number_projects_allowed ) : 0;              

                $btn_label  = esc_html__('Buy now', 'taskbot');

                if(empty($package->get_price())){
                    $btn_label  = esc_html__('Subscribe', 'taskbot');
                }

                ob_start();
                ?>
                <div class="tb-pricing__content">
                    <?php echo get_the_post_thumbnail( $package_id, 'thumbnail' );?>
                    <h4><?php echo esc_html($package->get_name());?></h4>
                    <h2><?php taskbot_price_format($package->get_price(),'',true);?></h2>
                    <em><?php esc_html_e('Incl all taxes', 'taskbot'); ?></em>
                    <ul class="tb-pricinglist">
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Package duration', 'taskbot'); ?></span>
                                <span> <?php echo wp_sprintf( _n( '%1$s %2$s', '%1$s %3$s', $package_duration, 'taskbot' ), $package_duration, $type, $type.'s' );?></span>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Number of projects', 'taskbot'); ?></span>
                                <span><?php echo wp_sprintf( _n( '%1$s projects', '%1$s Projects', $number_projects_allowed, 'taskbot' ), $number_projects_allowed );?></span>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Featured projects', 'taskbot'); ?></span>
                                <span><?php echo wp_sprintf( _n( '%1$s Allowed', '%1$s Allowed', $featured_projects_allowed, 'taskbot' ), $featured_projects_allowed );?></span>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Featured projects duration', 'taskbot'); ?></span>
                                <span><?php echo wp_sprintf( esc_html__( '%1$s day(s)', 'taskbot' ), $featured_projects_duration );?></span>
                            </div>
                        </li>
                        <?php do_action('taskbot_package_fields', $package);?>
                    </ul>

                    <?php if( !empty($show_btn) ){?>
                        <a href="javascript:void(0);" class="tb-btn tb-btnv2 tb-buy-package" data-package_id="<?php echo intval($package_id);?>"><?php echo apply_filters('taskbot_package_btn_label', $btn_label, $package_id); ?></a>
                    <?php } ?>
                </div>
                <?php
                echo ob_get_clean();

            } else {

                $package_type    		= get_post_meta( $package_id, 'package_type', true );
                $type					= taskbot_price_plans_duration($package_type);
                $package_duration    	= get_post_meta( $package_id, 'package_duration', true );
                $number_tasks_allowed   = get_post_meta( $package_id, 'number_tasks_allowed', true );
                $featured_tasks_allowed = get_post_meta( $package_id, 'featured_tasks_allowed', true );
                $task_plans_allowed    	= get_post_meta( $package_id, 'task_plans_allowed', true );
                
                $number_project_credits     = get_post_meta( $package_id, 'number_project_credits', true );
                $featured_tasks_duration    = get_post_meta( $package_id, 'featured_tasks_duration', true );
                $featured_tasks_duration    = !empty($featured_tasks_duration) ? $featured_tasks_duration : 0;
                $number_project_credits     = !empty( $number_project_credits ) ? intval( $number_project_credits ) : 0;
                $allowed_plans_class        = "fas fa-times tb-grey";

                if( !empty($task_plans_allowed) && $task_plans_allowed == 'yes'){
                    $allowed_plans_class	= "fas fa-check tb-green";
                }

                $btn_label  = esc_html__('Buy now', 'taskbot');

                if(empty($package->get_price())){
                    $btn_label  = esc_html__('Subscribe', 'taskbot');
                }

                ob_start();
                ?>
                <div class="tb-pricing__content">
                    <?php echo get_the_post_thumbnail( $package_id, 'thumbnail' );?>
                    <h4><?php echo esc_html($package->get_name());?></h4>
                    <h2><?php taskbot_price_format($package->get_price(),'',true);?></h2>
                    <em><?php esc_html_e('Incl all taxes', 'taskbot'); ?></em>
                    <ul class="tb-pricinglist">
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Package duration', 'taskbot'); ?></span>
                                <span> <?php echo wp_sprintf( _n( '%1$s %2$s', '%1$s %3$s', $package_duration, 'taskbot' ), $package_duration, $type, $type.'s' );?></span>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Number of task to post', 'taskbot'); ?></span>
                                <span><?php echo wp_sprintf( _n( '%1$s task', '%1$s tasks', $number_tasks_allowed, 'taskbot' ), $number_tasks_allowed );?></span>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Featured task', 'taskbot'); ?></span>
                                <span><?php echo wp_sprintf( _n( '%1$s Allowed', '%1$s Allowed', $featured_tasks_allowed, 'taskbot' ), $featured_tasks_allowed );?></span>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Task plans allowed', 'taskbot'); ?></span>
                                <i class="<?php echo esc_attr($allowed_plans_class);?>"></i>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Number of credits to apply on projects', 'taskbot'); ?></span>
                                <span><?php echo wp_sprintf( esc_html__( '%1$s credits', 'taskbot' ), $number_project_credits );?></span>
                            </div>
                        </li>
                        <li>
                            <div class="tb-pricinglist__content">
                                <span><?php esc_html_e('Featured task duration', 'taskbot'); ?></span>
                                <span><?php echo wp_sprintf( _n( '%1$s day', '%1$s days', $featured_tasks_duration, 'taskbot' ), $featured_tasks_duration );?></span>
                            </div>
                        </li>
                        <?php do_action('taskbot_package_fields', $package);?>
                    </ul>

                    <?php if( !empty($show_btn) ){?>
                        <a href="javascript:void(0);" class="tb-btn tb-btnv2 tb-buy-package" data-package_id="<?php echo intval($package_id);?>"><?php echo apply_filters('taskbot_package_btn_label', $btn_label, $package_id); ?></a>
                    <?php } ?>
                </div>
                <?php
                echo ob_get_clean();
            }
            
        }

        /**
         * Post views
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_term_tags($post_id = '', $taxonomy='', $heading='', $show_tags = 7,$type='service')
        {
            $categories             = get_the_terms($post_id, $taxonomy);
            $categories             = !empty($categories) ? $categories : array();
            $search_page_link       = '';
            $array_val              = '';
            if( !empty($type) && $type === 'service'){
                $search_page_link    = taskbot_get_page_uri('search_page_link');
            } else if( !empty($type) && $type === 'project'){
                $search_page_link    = taskbot_get_page_uri('project_search_page');
                $array_val              = '[]';
            }
            
            if (!empty($categories)) { ?>
            <div class="tb-singleservice-tile">
                <div class="tb-blogtags">
                    <?php if (!empty($heading)) { ?>
                        <div class="tb-tagtittle">
                            <i class="tb-icon-tag"></i>
                            <span>
                                <?php echo esc_html($heading.":"); ?>
                            </span>
                        </div>
                    <?php } ?>
                    <ul class="tb-tags_links">
                        <?php
                        $counter    = 0;
                        foreach ($categories as $category) {
                            $counter++;
                            $class  = '';

                            if ($counter > $show_tags) {
                                $class  = 'class="d-none"';
                            }

                            if (!empty($category->name)) { 
                                $task_tag_search_url    = '#';

                                if(is_singular('sellers')){
                                    $task_tag_search_url    = taskbot_get_page_uri('sellers_search_page');
                                    if(!empty($task_tag_search_url)) {
                                        $task_tag_search_url = add_query_arg('skills[]', esc_attr($category->slug), $task_tag_search_url);
                                    }
                                }else{
                                    if(!empty($search_page_link)) {
                                        $task_tag_search_url = !empty($category->slug) ? add_query_arg($taxonomy.$array_val, esc_attr($category->slug), $search_page_link) : '';
                                    }
                                }
                                ?>
                                <li <?php echo do_shortcode($class); ?>>
                                    <a href="<?php echo esc_url($task_tag_search_url);?>"><span class="tb-blog-tags"><?php echo esc_html($category->name); ?></span></a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($counter > $show_tags) { ?>
                            <li>
                                <div class="tb-selected__showmore">
                                    <a href="javascript:void(0);"><?php esc_html_e('Show more', 'taskbot'); ?></a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php
            }
        }

        /**
         * Post views
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_profile_image($post_id = '',$show_rates='',$size=array('width' => 300, 'height' => 300))
        {
            $user_name      = taskbot_get_username($post_id);
            $user_name      = !empty($user_name) ? $user_name : '';
            $user_id        = get_post_meta($post_id, '_linked_profile', true);
            $avatar         = apply_filters(
            'taskbot_avatar_fallback',
            taskbot_get_user_avatar($size, $post_id),$size);
            if (!empty($avatar)) {
                ob_start();?>
                <div class="tb-asideprostatus">
                    <figure>
                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($user_name); ?>">
                        <?php do_action('taskbot_print_user_status', $user_id);?>
                    </figure>
                    <?php if( !empty($show_rates) ){?>
                        <div class="tb-seller-details">
                            <?php if( !empty($user_name) ){?>
                                <h4>
                                    <a href="<?php echo esc_url(get_the_permalink($post_id));?>"><?php echo esc_html($user_name);?></a>
                                    <?php do_action( 'taskbot_verification_tag_html', $post_id ); ?>
                                </h4>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php 
                echo ob_get_clean();
            }
        }

    /**
     * Post views
     *
     * @throws error
     * @author Amentotech <theamentotech@gmail.com>
     * @return
     */
        public function taskbot_profile_image_theme($post_id = '')
        {
            $user_name = taskbot_get_username($post_id);
            $user_name = !empty($user_name) ? $user_name : '';
            $avatar = apply_filters(
                'taskbot_avatar_fallback',
                taskbot_get_user_avatar(array('width' => 80, 'height' => 80), $post_id),
                array('width' => 80, 'height' => 80)
            );
            if (!empty($avatar)) {
                ob_start();
                ?>
                <figure>
                    <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($user_name); ?>">
                </figure>
                <?php
                echo ob_get_clean();
            }
        }

        /**
         * Post views
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_post_views($post_id = '', $key = 'set_blog_view')
        {
            if (!is_single())
                return;

            if (empty($post_id)) {
                global $post;
                $post_id = $post->ID;
            }

            if (!isset($_COOKIE[$key . $post_id])) {
                setcookie($key . $post_id, $key, time() + 3600);
                $view_key = $key;
                $count = get_post_meta($post_id, $view_key, true);

                if ($count == '') {
                    $count = 0;
                    delete_post_meta($post_id, $view_key);
                    add_post_meta($post_id, $view_key, '0');
                } else {
                    $count++;
                    update_post_meta($post_id, $view_key, $count);
                }
            }

        }

        /**
         * Favourite tasks
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_saved_item($post_id = '', $user_post_id='', $key='', $type = '')
        {
            global $current_user;
            if (empty($user_post_id)){
                $user_type      = apply_filters('taskbot_get_user_type', $current_user->ID );
                $user_post_id   = taskbot_get_linked_profile_id($current_user->ID,'',$user_type);
            }
            $post_type      = !empty($key) && $key === '_saved_tasks'? 'tasks' : 'projects';
            $saved_items     = get_post_meta($user_post_id, $key, true);
            $saved_class     = !empty($saved_items) && in_array($post_id, $saved_items) ? 'bg-redheart' : 'bg-heart';
            $action          = !empty($saved_items) && in_array($post_id, $saved_items) ? '' : 'saved';
            $text           = !empty($saved_items) && in_array($post_id, $saved_items) ? esc_html__('Saved', 'taskbot') : esc_html__('Save', 'taskbot');
            ob_start();
            if (!empty($type) && $type == 'list') { ?>
                <a href="javascript:void(0);" class="tb_saved_items <?php echo esc_attr($saved_class); ?>" data-action="<?php echo esc_attr($action); ?>" data-post_id="<?php echo intval($post_id); ?>" data-id="<?php echo intval($current_user->ID); ?>" data-type="<?php echo esc_attr($post_type);?>"><span class="tb-icon-heart"></span></a>
            <?php } else { ?>
                <li> <a href="javascript:void(0);" class="tb_saved_items <?php echo esc_attr($saved_class); ?>" data-action="<?php echo esc_attr($action); ?>" data-post_id="<?php echo intval($post_id); ?>" data-id="<?php echo intval($current_user->ID); ?>" data-type="<?php echo esc_attr($post_type);?>"><span class="tb-icon-heart"></span><?php echo esc_html($text);?> </a> </li>
            <?php
            }
            echo ob_get_clean();
        }

        /**
         * Favourite tasks
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_saved_item_theme($post_id = '', $user_post_id = '', $key = '')
        {
            global $current_user;
            if (empty($user_post_id)) {
                $user_type = apply_filters('taskbot_get_user_type', $current_user->ID);
                $user_post_id = taskbot_get_linked_profile_id($current_user->ID, '', $user_type);
            }
            $saved_items = get_post_meta($user_post_id, $key, true);
            $saved_class = !empty($saved_items) && in_array($post_id, $saved_items) ? 'bg-redheart' : 'bg-heart';
            $action = !empty($saved_items) && in_array($post_id, $saved_items) ? '' : 'saved';
            ob_start();
            ?>
            <div class="tk-like">
                <a href="javascript:void(0);" class="tb_saved_items <?php echo esc_attr($saved_class); ?>"
                data-action="<?php echo esc_attr($action); ?>" data-post_id="<?php echo intval($post_id); ?>"
                data-id="<?php echo intval($current_user->ID); ?>" data-type="tasks"><i class="tb-icon-heart"></i>
                </a>
            </div>
            <?php
            echo ob_get_clean();
        }

        /**
         * Featured tasks
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_featured_item($product)
        {
            if(empty($product)){return;}
            
            $taskbot_featured = $product->get_featured();
            ob_start();
            if ($taskbot_featured) {
            ?>
                <em class="tb-featuretag__shadow">
                    <span class="tb-featuretag"><?php esc_html_e('Featured', 'taskbot'); ?> <i class="fa fa-bolt"></i> </span>
                </em>
            <?php
            }
            echo ob_get_clean();
        }

        /**
         * Featured item
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_featured_item($product,$type='featured_task')
        {
            if(empty($product)){return;}

            $taskbot_featured = $product->get_featured();
            ob_start();
            if ($taskbot_featured) {
            ?>
                <span class="tk-featureditem" <?php echo apply_filters('taskbot_tooltip_attributes', $type);?>><i class="tb-icon-zap"></i></span>
            <?php
            }
            echo ob_get_clean();
        }

        /**
         * Featured tasks
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_featured_item_theme($product)
        {
            if(empty($product)){return;}

            $taskbot_featured = $product->get_featured();
            ob_start();
            if ($taskbot_featured) {
                ?>
                <span class="tk-featuretag"><?php esc_html_e('Featured', 'taskbot'); ?></span>
                <?php
            }
            echo ob_get_clean();
        }

        /**
         * Tasks video
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_task_video_theme($product)
        {
            if(empty($product)){return;}

            $video_url = get_post_meta($product->get_id(), '_product_video', true);
            $video_url = !empty($video_url) ? $video_url : '';
            $product_url = get_permalink($product->get_id());
            $url = parse_url($video_url);
            ob_start();
            if ($video_url) {

                $unique_id = 'venobox-' . $product->get_id();
                if (!empty($url) && ( $url['host'] == 'www.youtube.com' || $url['host'] == 'vimeo.com' )) {
                    ?>
                    <a class="venobox tk-servicesvideo <?php echo esc_attr($unique_id); ?>" data-vbtype="video"
                    data-gall="gall" href="<?php echo esc_url($video_url); ?>" data-autoplay="true"></a>
                    <?php
                } else {
                    ?>
                    <a class="venobox tk-servicesvideo <?php echo esc_attr($unique_id); ?>" data-vbtype="iframe"
                    data-gall="gall" href="<?php echo esc_url($video_url); ?>" data-autoplay="true"></a>
                    <?php
                }

                $script_video = 'jQuery(document).ready(function () {
            let venobox = document.querySelector(".venobox-' . esc_js($product->get_id()) . '");
                if (venobox !== null) {
                jQuery(".venobox-' . esc_js($product->get_id()) . '").venobox({
                    spinner : "cube-grid",
                });
                }
            })';
                wp_add_inline_script('venobox', $script_video, 'after');
            }
            echo ob_get_clean();
        }

        /**
         * Tasks gallery count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_gallery_count($product)
        {
            if(empty($product)){return;}

            $gallery_count = 0;
            $gallery_ids_arr = $product->get_gallery_image_ids();
            $video_url = get_post_meta($product->get_id(), '_product_video', true);
            $video_url = !empty($video_url) ? $video_url : '';

            if (!empty($gallery_ids_arr)) {
                $gallery_count = count($gallery_ids_arr);
            }
            if ($gallery_count > 1 && empty($video_url)) {
                ob_start();
                ?>
                    <span class="tk-noofslides"><i class="tb-icon-image"></i><?php echo esc_html($gallery_count); ?></span>
                <?php
                echo ob_get_clean();
            }
            
        }

        /**
         * Tasks gallery
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_task_gallery_theme($product)
        {
            if(empty($product)){return;}

            $gallery_ids      = $product->get_gallery_image_ids();
            $gallery_count    = !empty($gallery_ids) && is_array($gallery_ids) ? count($gallery_ids) : 0;
            $video_url        = get_post_meta($product->get_id(), '_product_video', true);
            $video_url        = !empty($video_url) ? $video_url : '';
            ob_start();
            if (!empty($gallery_count) && $gallery_count > 1 ){ ?>
                <div class="tk-tasksearch-slider owl-carousel tk-tasks-slider tk-cards__img">
                    <?php
                        foreach( $gallery_ids as $attachment_id ) {
                            $woocommerce_thumbnail  = wp_get_attachment_image_src( $attachment_id,'woocommerce_thumbnail' );
                            $post_title             = get_the_title($attachment_id);
                            $attachment_image_url   = !empty($woocommerce_thumbnail[0]) ? $woocommerce_thumbnail[0] : '';
                            if( !empty($attachment_image_url) ){ ?>
                                <div class="item">
                                    <?php do_action('taskbot_task_video_theme', $product);?>
                                    <figure class="tk-cards__img">
                                        <img src="<?php echo esc_url($attachment_image_url); ?>" alt="<?php echo esc_attr($post_title) ?>" />
                                    </figure>
                            </div>
                            <?php } ?>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <figure class="tk-cards__img">
                    <?php 
                        do_action('taskbot_task_video_theme', $product);
                        echo woocommerce_get_product_thumbnail('taskbot_task_shortcode_thumbnail');
                    ?>
                </figure>
            <?php
            }
            echo ob_get_clean();
        }

        /**
         * Tasks gallery v2
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_task_gallery_theme_v2($product,$thum_size='woocommerce_thumbnail',$full_size='taskbot_task_shortcode_thumbnail')
        {
            if(empty($product)){return;}

            $gallery_ids      = $product->get_gallery_image_ids();
            $gallery_count    = !empty($gallery_ids) && is_array($gallery_ids) ? count($gallery_ids) : 0; 
            if (!empty($gallery_count) && $gallery_count > 1 ){ ?>
                <figure>
                    <?php
                        $counter        = 0;
                        $thumbnail      = '';
                        $gallery        = '';
                        foreach( $gallery_ids as $attachment_id ) {
                            $counter++;
                            
                            if($counter === 1){
                                $woocommerce_thumbnail  = wp_get_attachment_image_src( $attachment_id,$full_size );
                            } else {
                                $woocommerce_thumbnail  = wp_get_attachment_image_src( $attachment_id,$thum_size );
                            }

                            $post_title             = get_the_title($attachment_id);
                            $attachment_image_url   = !empty($woocommerce_thumbnail[0]) ? $woocommerce_thumbnail[0] : '';
                            if( !empty($attachment_image_url) && $counter === 1 ){
                                $thumbnail  .= '<img src="'.esc_url($attachment_image_url).'" alt="'.esc_attr($post_title) .'">';
                            } else{
                                $gallery    .= '<img src="'.esc_url($attachment_image_url).'" alt="'.esc_attr($post_title) .'">';
                            } 
                     } ?>
                    <?php echo do_shortcode( $thumbnail );?>
                    <?php if(!empty($gallery)){?><figcaption><?php echo do_shortcode( $gallery );?></figcaption><?php }?>
                </figure>
            <?php } else { ?>
                <figure> <?php echo woocommerce_get_product_thumbnail($full_size);?></figure>
            <?php
            }
        }

        /**
         * Tasks rating count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_rating_count($product)
        {
            if(empty($product)){return;}

            $taskbot_product_rating         = !empty($product) ? $product->get_average_rating() : 0;
            $taskbot_product_rating_count   = !empty($product) ? $product->get_rating_count() : 0;
            ob_start();
            ?>
                <li><i class="fa fa-star tk-yellow"></i> <em> <?php echo esc_html($taskbot_product_rating); ?> </em> <span>(<?php echo esc_html(number_format($taskbot_product_rating_count)); ?>)</span></li>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks rating count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_rating_count_theme($product)
        {
            if(empty($product)){return;}

            $taskbot_product_rating = !empty($product) ? $product->get_average_rating() : 0;
            $taskbot_product_rating_count = !empty($product) ? $product->get_rating_count() : 0;
            ob_start();
            ?>
            <li>
                <i class="fa fa-star tk-yellow"></i>
                <em> <?php echo esc_html($taskbot_product_rating); ?> </em>
                <span>(<?php echo esc_html(number_format($taskbot_product_rating_count)); ?>)</span>
            </li>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks rating count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_rating_count_theme_v2($product)
        {
            if(empty($product)){return;}

            $rating     = $product->get_average_rating();
            $count		= $product->get_rating_count();
            $rating_avg 	= !empty($rating) && !empty($count) ? ($rating/5) * 100 : 0;
            $rating_avg     = !empty($rating_avg) ? 'style="width:'.$rating_avg.'%;"' : 'style="width:0%;"';
            ?>
           <div class="tk-featureRating tk-featureRatingv2">
                <span class="tk-featureRating__stars"><span <?php echo do_shortcode($rating_avg );?>></span></span>
                <h6><?php echo esc_attr($rating);?> <em><?php esc_html_e('/5.0','taskbot');?></em></h6>
                <em><?php esc_html_e('User review','taskbot');?></em>
            </div>
            <?php
        }

        /**
         * Tasks detail views
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_item_views($product)
        {
            if(empty($product)){return;}

            $product_id             = !empty($product) ? $product->get_id() : '';
            
            $taskbot_service_views  = get_post_meta($product_id, 'taskbot_service_views', TRUE);
            $taskbot_service_views  = !empty($taskbot_service_views) ? intval($taskbot_service_views) : 0;
            ob_start();
            ?>
                <li>
                    <i class="tb-icon-eye"></i> <span><?php echo wp_sprintf( _n( '%s view', '%s views', $taskbot_service_views, 'taskbot' ), $taskbot_service_views );?></span>
                </li>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks views
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_item_views_theme($product)
        {
            if(empty($product)){return;}

            $product_id = $product->get_id();
            $taskbot_service_views = get_post_meta($product_id, 'taskbot_service_views', TRUE);
            $taskbot_service_views = !empty($taskbot_service_views) ? sprintf("%02d", intval($taskbot_service_views))  : 0;
            ob_start();
            ?>
                <li>
                    <span> <i class="tb-icon-eye"></i> <em><?php echo wp_sprintf( _n( '%s view', '%s views', $taskbot_service_views, 'taskbot' ), $taskbot_service_views );?></em> </span>
                </li>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks reviews count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_item_reviews($product)
        {
            if(empty($product)){return;}

            if ($product->get_reviews_allowed()) {
                $units_sold = $product->get_total_sales();
                $units_sold = !empty($units_sold) ? sprintf("%02d", $units_sold) : 0;
                ob_start();
            ?>
                <li><i class="tb-icon-shopping-bag text-grey"></i><span><?php echo wp_sprintf( _n( '%s sale', '%s sales', $units_sold, 'taskbot' ), $units_sold );?></span></li>   
            <?php
                echo ob_get_clean();
            }
        }

        /**
         * Tasks reviews count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_item_status($product_id)
        {
            global $taskbot_settings;
            $service_status = !empty($taskbot_settings['service_status']) ? $taskbot_settings['service_status'] : '';
            $task_status    = get_post_status( $product_id );
            $status_class   = !empty($task_status) ? 'class="tb_'.$task_status.'"'    : "";
            $label          = "";
            switch($task_status){
                case 'pending':
                  $label      = esc_html__('Pending', 'taskbot');
                  break;
                case 'draft':
                  $label      = esc_html__('Drafted', 'taskbot');
                  break;
                case 'rejected':
                    $reason         = get_post_meta( $product_id, '_rejection_reason', true );
                    $reason         = !empty($reason) ? $reason : '';
                    $label          = esc_html__('Rejected', 'taskbot');
                    $status_class   = 'class="tb_'.esc_attr($task_status).' tb-rejected-reason" data-reason="'.esc_attr($reason).'"';
                    break;
                case 'publish':
                    if( !empty($service_status) && $service_status === 'pending'){
                        $label      = esc_html__('Approved', 'taskbot');
                    } else {
                        $label      = esc_html__('Published', 'taskbot');
                    }
                  break;
                default:
                  $label      = esc_html__('New', 'taskbot');
            }
            
            if ($task_status) {
                ob_start();
            ?>
                <li <?php echo do_shortcode($status_class);?>><i class="tb-icon-clock"></i><span><?php echo esc_attr($label);?></span></li>   
            <?php
                echo ob_get_clean();
            }
        }

        /**
         * Tasks queue count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_item_queue($product)
        {
            $product_id             = $product->get_id();
            $taskbot_total_sales    = $product->get_total_sales();
            $meta_array = array(
                array(
                    'key' => 'task_product_id',
                    'value' => $product_id,
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => '_task_status',
                    'value' => 'hired',
                    'compare' => '=',
                )
            );
            
            $taskbot_order_queues = taskbot_get_post_count_by_meta('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed'), $meta_array);
            $taskbot_queued_order_percentage = 0;
            if ($taskbot_total_sales > 0 && $taskbot_order_queues > 0) {
                $taskbot_queued_order_percentage = ($taskbot_order_queues / $taskbot_total_sales) * 100;
            }
            ob_start();
            ?>
            <li>
                <div class="tb-profiletime">
                    <span><?php esc_html_e('In Queue', 'taskbot'); ?> (<?php echo esc_html(number_format($taskbot_order_queues)); ?>)</span>
                    <div class="progress tb-profileprogress">
                        <div class="progress-bar" role="progressbar"
                            style="width: <?php echo intval($taskbot_queued_order_percentage); ?>%;"
                            aria-valuenow="<?php echo intval($taskbot_order_queues); ?>" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </li>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks completed count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_service_item_completed($product)
        {
            $product_id = $product->get_id();
            $taskbot_total_sales = $product->get_total_sales();
            $meta_array = array(
                array(
                    'key' => 'task_product_id',
                    'value' => $product_id,
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => '_task_status',
                    'value' => 'completed',
                    'compare' => '=',
                )
            );
            $taskbot_order_completed = taskbot_get_post_count_by_meta('shop_order', array('wc-completed'), $meta_array);
            $taskbot_completed_order_percentage = 0;
            if ($taskbot_total_sales > 0 && ($taskbot_order_completed) > 0) {
                $taskbot_completed_order_percentage = ($taskbot_order_completed / $taskbot_total_sales) * 100;
            }
            ob_start();
            ?>
            <li>
                <div class="tb-profiletime">
                    <span><?php echo _x('Completed', 'Title for service completed', 'taskbot' ); ?> (<?php echo esc_html(number_format($taskbot_order_completed)); ?>)</span>
                    <div class="progress tb-profileprogress">
                        <div class="progress-bar" role="progressbar"
                            style="width: <?php echo intval($taskbot_completed_order_percentage); ?>%;"
                            aria-valuenow="<?php echo intval($taskbot_order_completed); ?>" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </li>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks cancelled count
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_service_item_cancelled($product)
        {
            $product_id = $product->get_id();
            $taskbot_total_sales = $product->get_total_sales();
            $meta_array = array(
                array(
                    'key' => 'task_product_id',
                    'value' => $product_id,
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => '_task_status',
                    'value' => 'cancelled',
                    'compare' => '=',
                )
            );
            $taskbot_order_cancelled = taskbot_get_post_count_by_meta('shop_order', array('wc-cancelled', 'wc-refunded', 'wc-failed','wc-completed'), $meta_array);
            $taskbot_cancelled_order_percentage = 0;
            if ($taskbot_total_sales > 0 && ($taskbot_order_cancelled) > 0) {
                $taskbot_cancelled_order_percentage = ($taskbot_order_cancelled / $taskbot_total_sales) * 100;
            }
            ob_start();
            ?>
            <li>
                <div class="tb-profiletime">
                    <span><?php esc_html_e('Cancelled', 'taskbot'); ?> (<?php echo esc_html(number_format($taskbot_order_cancelled)); ?>)</span>
                    <div class="progress tb-profileprogress">
                        <div class="progress-bar" role="progressbar"
                            style="width: <?php echo intval($taskbot_cancelled_order_percentage); ?>%;"
                            aria-valuenow="<?php echo intval($taskbot_order_cancelled); ?>" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </li>
            <?php
            echo ob_get_clean();
        }

    /**
     * Seller hourly price starting from
     *
     * @throws error
     * @author Amentotech <theamentotech@gmail.com>
     * @return
     */
        public function taskbot_user_hourly_starting_rate($seller_id = '', $tb_hourly_rate = 'tb_hourly_rate', $display_button = '')
        {
            if (!empty($seller_id)) {
                $tb_hourly_rate = get_post_meta($seller_id, 'tb_hourly_rate', true);
                if (!empty($tb_hourly_rate) || !empty($display_button)) {
                    ob_start();
                    ?>
                    <div class="tb-startingprice">
                        <i><?php esc_html_e('Starting from', 'taskbot'); ?></i>
                        <em>
                            <span><?php echo sprintf(esc_html__('%s /hr', 'taskbot'), taskbot_price_format($tb_hourly_rate, 'return')); ?></span>
                        </em>
                        <?php if(!$display_button):?>
                            <a class="tk-btn-solid-lg" href="<?php echo esc_url( get_permalink($seller_id)); ?>"><?php esc_html_e('View profile', 'taskbot'); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php
                    echo ob_get_clean();
                }
            }
        }

        /**
         * Tasks price starting from
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_service_item_starting_price($product)
        {
            $taskbot_total_price = $product->get_price();
            if(!empty($taskbot_total_price)){
                ob_start();
                ?>
                <div class="tb-startingprice">
                    <i><?php esc_html_e('Starting from:', 'taskbot'); ?></i>
                    <span>
                        <?php 
                            if(function_exists('wmc_revert_price')){
                                taskbot_price_format(wmc_revert_price($taskbot_total_price));
                            } else {
                                taskbot_price_format($taskbot_total_price);   
                            }
                        ?>
                    </span>
                </div>
                <?php
                echo ob_get_clean();
            }
        }

        /**
         * Tasks price starting from
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_service_item_starting_price_theme($product)
        {
            $taskbot_total_price = $product->get_price();
            ob_start();
            ?>
            <div class="tk-startingprice">
                <i><?php esc_html_e('Starting from', 'taskbot'); ?></i>
                <span>
                    <?php 
                        if( function_exists('wmc_revert_price') ){
                            taskbot_price_format(wmc_revert_price($taskbot_total_price));
                        } else {
                            taskbot_price_format($taskbot_total_price);   
                        }?>
                    </span>
            </div>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks no of sales
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_service_sales($product, $version = 'v1')
        {
            if(!empty($product)){
                $product_id = $product->get_id();
                $meta_array = array(
                    array(
                        'key' => 'task_product_id',
                        'value' => $product_id,
                        'compare' => '=',
                        'type' => 'NUMERIC'
                    )
                );            
                $sales = $product->get_total_sales();
            }
            $sales = !empty($sales) ? sprintf("%02d", intval($sales)) : 0;
            ob_start();
            if (!empty($version) && $version == 'v1') { ?>
                <li>
                    <span class="tb-pinkbox"><i class="tb-icon-shopping-cart"></i></span>
                    <div class="tb-sales__title">
                        <em><?php esc_html_e('No. of sales', 'taskbot'); ?></em>
                        <h6><?php echo intval($sales); ?></h6>
                    </div>
                </li>
            <?php } else if (!empty($version) && $version == 'v2') { ?>
                <li>
                    <div class="tb-pkgresponse__content tb-purple">
                        <i class="tb-icon-shopping-cart"></i>
                        <h6><?php echo intval($sales); ?></h6>
                        <span><?php esc_html_e('No. of sales', 'taskbot'); ?></span>
                    </div>
                </li>
            <?php }else if (!empty($version) && $version == 'v3') { ?>
                <li>
                    <div class="tb-pkgresponse__content tb-purple">
                        <i class="tb-icon-shopping-cart"></i>
                        <h6><?php echo intval($sales); ?>&nbsp;<?php esc_html_e('sales', 'taskbot'); ?></h6>
                    </div>
                </li>
            <?php }
            echo ob_get_clean();
        }

        /**
         * Tasks delievery time
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_service_delivery_time($product, $version = 'v1')
        {
            $days   = 0;

            if(!empty($product)){
                $db_delivery_time   = get_post_meta( $product->get_id(), '_delivery_time',true );
                if( !empty($db_delivery_time) ){
                    $delivery_time = 'delivery_time_' . $db_delivery_time;
                    if (function_exists('get_field')) {
                        $days = get_field('days', $delivery_time);
                    } 
                } else {
                    $delivery_terms     = wp_get_post_terms($product->get_id(), 'delivery_time', array('fields' => 'ids'));
                    $days = array();
                    foreach ($delivery_terms as $delivery_id) {
                        $delivery_time = 'delivery_time_' . $delivery_id;

                        if (function_exists('get_field')) {
                            $days[] = get_field('days', $delivery_time);
                        } else {
                            $days[] = 0;
                        }
                    }
                    $days = !empty($days) && is_array($days) ? min($days) : 0;
                }
            }
            
            ob_start();
            if (!empty($version) && $version == 'v1' && !empty($days)) { ?>
                <li>
                    <span class="tb-greenbox"><i class="fas fa-calendar-check"></i></span>
                    <div class="tb-sales__title">
                        <em><?php esc_html_e('Delivery time', 'taskbot'); ?></em>
                        <h6><?php echo sprintf(_n( '%s Day', '%s Days', $days, 'taskbot' ), $days); ?></h6>
                    </div>
                </li>
            <?php } elseif (!empty($version) && $version == 'v2' && !empty($days)) { ?>
                <li>
                    <div class="tb-pkgresponse__content tb-greenbox tb-change-timedays">
                        <i class="tb-icon-gift"></i>
                        <h6><?php echo sprintf(_n( '%s Day', '%s Days', $days, 'taskbot' ), $days); ?></h6>
                        <span><?php esc_html_e('Delivery', 'taskbot'); ?></span>
                    </div>
                </li>
            <?php }
            echo ob_get_clean();
        }

        /**
         * Tasks downloadable
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_service_download($product)
        {
            $download_able = esc_html__('No', 'taskbot');
            
            if(!empty($product)){
                if ($product->is_downloadable('yes')) {
                    $download_able = esc_html__('Yes', 'taskbot');
                }
            }
            ob_start();
            ?>
            <li>
                <span class="bg-lightorange"><i class="tb-icon-download-cloud"></i></span>
                <div class="tb-sales__title">
                    <em><?php esc_html_e('Downloadable', 'taskbot'); ?></em>
                    <h6><?php echo esc_html($download_able); ?></h6>
                </div>
            </li>
            <?php
            echo ob_get_clean();
        }

        /**
         * Tasks user ratings
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
        */
        public function taskbot_service_ratings($product)
        {
            $rating = $product->get_average_rating();
            $count = $product->get_rating_count();
            $average_rating = !empty($rating) && !empty($count) ? ($rating / 5) * 100 : 0;
            ob_start();
            ?>
            <li>
                <div class="tb-pkgresponse__content tb-orange">
                    <i class="tb-icon-trending-up"></i>
                    <h6><?php echo intval($average_rating); ?>%</h6>
                    <span><?php esc_html_e('User rating', 'taskbot'); ?></span>
                </div>
            </li>
            <?php
            echo ob_get_clean();
        }
    }
    new Taskbot_Template_Functions();
}

/**
 * Keyword search
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_keyword_search' ) ) {
    add_action( 'taskbot_keyword_search', 'taskbot_keyword_search', 10, 1);
    function taskbot_keyword_search($search_keyword = '') {
	?>
        <div class="tk-aside-content">
            <div class="tk-inputiconbtn">
                <div class="tk-placeholderholder">
                    <input type="text" name="keyword" value="<?php echo esc_attr($search_keyword); ?>" class="form-control" placeholder="<?php esc_attr_e('Start your search','taskbot');?>">
                </div>
                <a href="javascript:void(0);" class="tk-search-icon"><i class="tb-icon-search"></i></a>
            </div>
        </div>

    <?php
  }
}

/**
 * Price range
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_price_range_dropdown' ) ) {
    add_action( 'taskbot_price_range_dropdown', 'taskbot_price_range_dropdown');
    function taskbot_price_range_dropdown() {
        $min_product_price = (isset($_GET['min_product_price']) && !empty($_GET['min_product_price']) ? $_GET['min_product_price'] : "");
        $max_product_price = (isset($_GET['max_product_price']) && !empty($_GET['max_product_price']) ? $_GET['max_product_price'] : "");
    ?>
        <div class="tk-aside-holder">
            <div class="tb-sidebartitle">
                <h5><?php esc_html_e('Price range','taskbot');?></h5>
            </div>
            <div class="tb-sidebarcontent">
                <div class="tb-appendinput">
                    <input type="number" name="min_product_price" value="<?php echo intval($min_product_price)?>" class="form-control" placeholder="<?php esc_attr_e('Min price','taskbot');?>">
                    <input type="number" name="max_product_price" value="<?php echo intval($max_product_price)?>" class="form-control" placeholder="<?php esc_attr_e('Max price','taskbot');?>">
                </div>
            </div>
        </div>
	  <?php
  }
}


/**
 * Seller status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if ( ! function_exists( 'taskbot_seller_status_filter' ) ) {
	add_action( 'taskbot_seller_status_filter', 'taskbot_seller_status_filter');
    function taskbot_seller_status_filter() {
        $online_seller  = (isset($_GET['online_seller'])  && $_GET['online_seller']  == 'on' ? "checked" : "");
        $offline_seller = (isset($_GET['offline_seller']) && $_GET['offline_seller'] == 'on' ? "checked" : "");
        ?>
            <div class="tk-aside-holder">
                <div class="tb-sidebartitle">
                    <h5><i class="tb-icon-minus"></i> <?php esc_html_e('Seller type','taskbot');?></h5>
                </div>
                <div class="tb-sidebarcontent">
                    <div class="tb-checkboxholder">
                        <div class="tb-checkbox">
                            <input name="online_seller" id="onlineseller" type="checkbox" <?php echo esc_attr($online_seller) ?> >
                            <label for="onlineseller"><span><?php esc_html_e('Online seller', 'taskbot');?></span></label>
                        </div>
                        <div class="tb-checkbox">
                            <input name="offline_seller" id="offlineseller" type="checkbox" <?php echo esc_attr($offline_seller) ?>>
                            <label for="offlineseller"><span><?php esc_html_e('Offline seller', 'taskbot');?></span></label>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}

/**
 * Set notification data
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_set_notification_data')) {
    add_action('taskbot_set_notification_data', 'taskbot_set_notification_data', 10, 3);
    function taskbot_set_notification_data($trigger_params='', $post_title = '', $type='')
    {
        global $current_user;
        $post_title = !empty($post_title) ? $post_title : esc_html__('Default notification', 'taskbot');
        $notification_post = array(
            'post_title' => wp_strip_all_tags($post_title),
            'post_type' => $type,
            'post_status' => 'publish',
            'post_content' => '',
            'post_author' => $current_user->ID
        );
        $last_insert_id = wp_insert_post($notification_post);

        if (!empty($trigger_params)) {
            foreach ($trigger_params as $key => $param) {
                update_post_meta($last_insert_id, $key, $param);
            }
        }
    }
}

/**
 * Search and Clear Buttons
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_search_clear_button')) {
    add_action('taskbot_search_clear_button', 'taskbot_search_clear_button', 10, 2);
    function taskbot_search_clear_button($title = 'Search', $page_url = '')
    {
        ?>
        <div class="tk-aside-holder">
            <div class="tb-filderbtns">
                <button type="submit" class="tb-btn btn-group-lg"><?php echo esc_html($title); ?></button>
                <a href="<?php echo esc_url($page_url); ?>"
                   class="tb-clearfilter"><?php esc_html_e('Clear filter', 'taskbot'); ?></a>
            </div>
        </div>
        <?php
    }
}

/**
 * Price plans template heading
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_price_plans_content')) {
    add_action('taskbot_packages_listing', 'taskbot_price_plans_content');
    function taskbot_price_plans_content()
    {
        ob_start();
        taskbot_get_template(
            'packages.php',
            array()
        );
        echo ob_get_clean();
    }
}

/**
 * Price plans packages
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_price_plans_duration')) {
  function taskbot_price_plans_duration($package_type)
  {
    $label  = '';
    switch($package_type){
        case 'year':
            $label  = esc_html__('Year', 'taskbot');
            break;
        case 'month':
            $label  = esc_html__('Month', 'taskbot');
            break;
        case 'days':
            $label  = esc_html__('Day', 'taskbot');
            break;
        default:
            $label  = esc_html__('Day', 'taskbot');
    }

    return $label;

  }
}

/**
 * Task order status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_task_order_status')) {
    add_action( 'taskbot_task_order_status', 'taskbot_task_order_status');
    function taskbot_task_order_status($order_id)
    {
      $post_status    = get_post_meta( $order_id, '_task_status', true );
      $post_status    = !empty($post_status) ? $post_status : '';

      $label_link     = '';
      switch($post_status){
        case 'hired':
          $label      = esc_html__('Ongoing', 'taskbot');
          $label_link = '<span class="tb-tag-ongoing">'.esc_html($label).'</span>';
          break;
        case 'completed':
          $label      = _x('Completed', 'Title for order status', 'taskbot' );
          $label_link = '<span class="tb-tag-ongoing bg-complete">'.esc_html($label).'</span>';
          break;
        case 'cancelled':
          $label      = esc_html__('Cancelled', 'taskbot');
          $label_link = '<span class="tb-tag-ongoing bg-cancel">'.esc_html($label).'</span>';
          break;
        default:
          $label      = esc_html__('New', 'taskbot');
          $label_link = '<span class="tb-tag-ongoing bg-new">'.esc_html($label).'</span>';
      }

      ob_start(); ?>
        <div class="tb-tags"><?php echo do_shortcode( $label_link );?></div>
      <?php echo ob_get_clean();

    }
}

/**
 * Task order author details
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_task_author')) {
    add_action( 'taskbot_task_author', 'taskbot_task_author', 10, 2);
    function taskbot_task_author($user_id,$type='sellers')
    {

        $link_id    = taskbot_get_linked_profile_id( $user_id,'',$type );
        $task_by    = !empty($type) && $type === 'sellers' ? esc_html__('Task from','taskbot') : esc_html__('Task by','taskbot');
        $user_name  = taskbot_get_username($link_id);
        $avatar     = apply_filters(
                        'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 40, 'height' => 40), $link_id), array('width' => 40, 'height' => 40)
                    );
        ob_start();
        ?>
        <div class="tb-tabitemextras">
            <div class="tb-tabitemextrasinfo">
                <?php if( !empty($avatar) ){?>
                    <figure>
                        <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
                    </figure>
                <?php } ?>
                <?php if( !empty($user_name) ){?>
                    <div class="tb-taskinfo">
                        <?php if( !empty($task_by) ){?>
                            <span><?php echo esc_html($task_by);?></span>
                        <?php } ?>
                        <h6><?php echo esc_html($user_name);?></h6>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
        echo ob_get_clean();
    }
}

/**
 * Task order delivery date
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_delivery_date')) {
    add_action( 'taskbot_delivery_date', 'taskbot_delivery_date');
    function taskbot_delivery_date($order_id)
    {
        $delivery_date  = get_post_meta( $order_id, 'delivery_date', true);
        $delivery_date  = !empty($delivery_date) ? date_i18n(get_option('date_format'), $delivery_date) : '';
        ob_start();
        if( !empty($delivery_date) ){?>
            <div class="tb-tabitemextras">
                <div class="tb-tabitemextrasinfo">

                    <div class="tb-taskinfo">
                        <span><?php esc_html_e('Task deadline','taskbot');?></span>
                        <h6><?php echo esc_html($delivery_date);?></h6>
                    </div>
                </div>
            </div>
        <?php }
        echo ob_get_clean();
    }
}

/**
 * Task order delivery date
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_order_date')) {
    add_action( 'taskbot_order_date', 'taskbot_order_date');
    function taskbot_order_date($order_id)
    {
        $order          = wc_get_order($order_id);
        $data_created   = $order->get_date_created();
        $date_format    = get_option( 'date_format' );
        $data_created   = date_i18n($date_format, strtotime($data_created));
        ob_start();
        if( !empty($data_created) ){?>
            <div class="tb-tabitemextras">
                <div class="tb-tabitemextrasinfo">

                    <div class="tb-taskinfo">
                        <span><?php esc_html_e('Task order date','taskbot');?></span>
                        <h6><?php echo esc_html($data_created);?></h6>
                    </div>
                </div>
            </div>
        <?php }
        echo ob_get_clean();
    }
}

/**
 * Task price plan
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_price_plan')) {
    add_action( 'taskbot_price_plan', 'taskbot_price_plan');
    function taskbot_price_plan($order_id)
    {
        $order_details   = get_post_meta( $order_id, 'order_details', true);
        $order_details   = !empty($order_details) ? $order_details : array();
        ob_start();
        if( !empty($order_details['title']) ){
            $plan_title = apply_filters( 'taskbot_plan_conetnet', $order_details['title'],$order_id );
            ?>
            <div class="tb-tabitemextras">
                <div class="tb-tabitemextrasinfo">

                    <div class="tb-taskinfo">
                        <span><?php esc_html_e('Pricing plan','taskbot');?></span>
                        <h6><?php echo do_shortcode($plan_title);?></h6>
                    </div>
                </div>
            </div>
        <?php }
        echo ob_get_clean();
    }
}

/**
 * Task order linked
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_order_linked')) {
    add_action( 'taskbot_order_linked', 'taskbot_order_linked');
    function taskbot_order_linked($order_id='')
    {
        global $current_user;
        $invoice_url  = !empty($order_id) && $current_user->ID ? Taskbot_Profile_Menu::taskbot_profile_menu_link('invoices', $current_user->ID, true, 'detail', intval($order_id)) : '';
        ob_start();
        if( !empty($order_id) ){?>
            <div class="tb-tabitemextras">
                <div class="tb-tabitemextrasinfo">

                    <div class="tb-taskinfo">
                        <span><?php esc_html_e('Order ID','taskbot');?></span>
                        <h6>#<a href="<?php echo esc_url($invoice_url);?>" target="_blank"><?php echo intval($order_id);?></a></h6>
                    </div>
                </div>
            </div>
        <?php }
        echo ob_get_clean();
    }
}
/**
 * Task order author details
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_subtasks_count')) {
    add_action( 'taskbot_subtasks_count', 'taskbot_subtasks_count');
    function taskbot_subtasks_count($product_data)
    {
        ob_start();
        if( !empty($product_data['subtasks']) && is_array($product_data['subtasks']) ){?>
            <div class="tb-tabitemextras">
                <div class="tb-tabitemextrasinfo">
                    <div class="tb-taskinfo">
                        <span><?php esc_html_e('Additional services','taskbot');?></span>
                        <h6><?php echo wp_sprintf( _n( '%s Addon requested', '%s Add-ons requested', count($product_data['subtasks']), 'taskbot' ), count($product_data['subtasks']) );?></h6>
                    </div>
                </div>
            </div>
        <?php }
        echo ob_get_clean();
    }
}

/**
 * Task order author details
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_task_download_file')) {
    add_action( 'taskbot_task_download_file', 'taskbot_task_download_file', 10, 2);
    function taskbot_task_download_file($product_id,$order_id)
    {
        $image_url          = TASKBOT_DIRECTORY_URI . '/public/images/downlaod.jpg';
        $post_title         = get_the_title($product_id);
        $task_status        = get_post_meta( $order_id, '_task_status',true );
        $task_status        = !empty($task_status) ? $task_status : '';
        $attachments_files  = get_post_meta( $product_id, '_downloadable_files',true );
        if( !empty($task_status) && $task_status!= 'cancelled' && !empty($attachments_files)){
            ob_start();
            ?>
            <div class="tb-tabitemextras">
                <div class="tb-tabitemextrasinfo tb-tabitemcrad">
                    <figure>
                        <a href="javascript:void(0);" data-id="<?php echo intval($product_id);?>" data-order_id="<?php echo intval($order_id);?>" class="tb_download_files">
                            <img class="tippy" data-tippy-content="<?php esc_attr_e('Attachments','taskbot');?>" src="<?php echo esc_url($image_url);?>" alt="<?php echo esc_attr($post_title);?>">
                        </a>
                    </figure>
                </div>
            </div>
            <?php
            echo ob_get_clean();
        }
    }
}

/**
 * Task order author details
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_task_complete_html')) {
    add_action( 'taskbot_task_complete_html', 'taskbot_task_complete_html', 10, 2);
    function taskbot_task_complete_html($order_id,$type='buyers')
    {
        $task_status    = get_post_meta( $order_id, '_task_status', true );
        $task_status    = !empty($task_status) ? $task_status : '';
        $rating_id  = get_post_meta( $order_id, '_rating_id', true );
        $rating_id  = !empty($rating_id) ? intval($rating_id) : 0;

        if( !empty($task_status) && $task_status == 'completed' && !empty($rating_id) || ($type =='buyers' && $task_status == 'completed') ){
            $buyer_id   = get_post_meta( $order_id, 'buyer_id', true);
            $buyer_id   = !empty($buyer_id) ? intval($buyer_id) : 0;
            $link_id    = taskbot_get_linked_profile_id( $buyer_id,'','buyers' );
            $avatar     = apply_filters(
                'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 40, 'height' => 40), $link_id), array('width' => 40, 'height' => 40)
            );
            $user_name      = !empty($link_id) ? taskbot_get_username($link_id) : '';
            $rating_class   = !empty($rating_id) ? 'tb_view_rating' : 'tb_add_rating';
            $rating_feature = !empty($rating_id) ? '' : 'tb-featureRating-nostar';
            $rating_title   = !empty($rating_id) ? esc_html__('View feedback','taskbot') : esc_html__('Add your feedback','taskbot');
            $rating         = !empty($rating_id) ? get_comment_meta($rating_id, 'rating', true) : 0;
            $rating_avg     = !empty($rating) ? ($rating/5)*100 : 0;
            $rating_avg     = !empty($rating_avg) ? 'style="width:'.$rating_avg.'%;"' : '';
            $task_id    = get_post_meta( $order_id, 'task_product_id', true);
            $task_id    = !empty($task_id) ? intval($task_id) : 0;
            $task_title = !empty($task_id) ? get_the_title( $task_id ) : '';
            ob_start();
            ?>
            <div class="tb-userfeedback">
                <?php if( !empty($avatar) ){?>
                    <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
                <?php } ?>
                <div class="tb-userfeedback__title">
                    <div class="tb-featureRating tb-featureRatingv2">
                        <span class="tb-featureRating__stars <?php echo esc_attr($rating_feature);?>"><span <?php echo do_shortcode( $rating_avg );?>></span></span>
                        <h6><?php echo number_format((float)$rating, 1, '.', '');?></h6>
                        <a href="javascript:void(0);" data-task_id="<?php echo esc_attr($task_id);?>"  data-title="<?php echo esc_attr($task_title);?>" data-rating_id="<?php echo esc_attr($rating_id);?>" data-order_id="<?php echo intval($order_id);?>" class="<?php echo esc_attr($rating_class);?>">(<?php echo esc_html($rating_title);?>)</a>
                    </div>
                    <?php if( !empty($user_name) ){?>
                        <h6><?php echo esc_html($user_name);?></h6>
                    <?php } ?>
                </div>
            </div>
            <?php
            echo ob_get_clean();
        } else if( !empty($task_status) && $task_status == 'cancelled') {
            $buyer_id   = get_post_meta( $order_id, 'buyer_id', true);
            $buyer_id   = !empty($buyer_id) ? intval($buyer_id) : 0;
            $link_id    = taskbot_get_linked_profile_id( $buyer_id,'','buyers' );
            $avatar     = apply_filters(
                'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 40, 'height' => 40), $link_id), array('width' => 40, 'height' => 40)
            );

            $user_name      = !empty($link_id) ? taskbot_get_username($link_id) : '';

            $task_id    = get_post_meta( $order_id, 'task_product_id', true);
            $task_id    = !empty($task_id) ? intval($task_id) : 0;
            $task_title = !empty($task_id) ? get_the_title( $task_id ) : '';
            ob_start();
            ?>
            <div class="tb-userfeedback">
                <?php if( !empty($avatar) ){?>
                    <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
                <?php } ?>
                <div class="tb-userfeedback__title">                    
                    <?php if( !empty($user_name) ){?>
                        <h6><?php echo esc_html($user_name);?></h6>
                    <?php } ?>
                </div>
            </div>
            <?php
            echo ob_get_clean();
        }
    }
}

/**
 * @Init Pagination Code Start
 * @return
 */
if (!function_exists('taskbot_prepare_pagination')) {
    add_action('taskbot_prepare_pagination', 'taskbot_prepare_pagination', 10, 2);
    function taskbot_prepare_pagination($pages = '', $range = 4)
    {
        $max_num_pages = !empty($pages) && !empty($range) ? ceil($pages / $range) : 1;
        $big = 999999999;
        $pagination = paginate_links(array(
            'base' => str_replace($big, '%#%', get_pagenum_link($big, false)),
            'format' => '?paged=%#%',
            'type' => 'array',
            'current' => max(1, get_query_var('paged')),
            'total' => $max_num_pages,
            'prev_text' => '<i class="lnr lnr-chevron-left">' . esc_html__('Pre', 'taskbot') . '</i>',
            'next_text' => '<i class="lnr lnr-chevron-right">' . esc_html__('Nex', 'taskbot') . '</i>',
        ));

        ob_start();
        if (!empty($pagination)) { ?>
            <div class='tb-pagination'>
                <ul>
                    <?php
                    foreach ($pagination as $key => $page_link) {
                        $link = htmlspecialchars($page_link);
                        $link = str_replace(' current', '', $link);
                        $activ_class = '';

                        if (strpos($page_link, 'current') !== false) {
                            $activ_class = 'class="active"';
                        } else if (strpos($page_link, 'next') !== false) {
                            $activ_class = 'class="tb-nextpage"';
                        } else if (strpos($page_link, 'prev') !== false) {
                            $activ_class = 'class="tb-prevpage"';
                        }
                        ?>
                        <li <?php echo do_shortcode($activ_class); ?> > <?php echo wp_specialchars_decode($link, ENT_QUOTES); ?> </li>
                    <?php } ?>
                </ul>
            </div>
            <?php
        }
        echo ob_get_clean();
    }
}

/**
 * @Empty listing
 * @return
 */
if (!function_exists('taskbot_empty_listing')) {
    add_action('taskbot_empty_listing', 'taskbot_empty_listing', 10, 2);
    function taskbot_empty_listing($text = '', $class = '')
    {
        global $taskbot_settings;
        $text = !empty($text) ? $text : esc_html__('No details to show here', 'taskbot');
        $image_url = !empty($taskbot_settings['empty_listing_image']['url']) ? $taskbot_settings['empty_listing_image']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/empty.png';
        ob_start();
        ?>
        <div class="tb-submitreview <?php echo esc_attr($class); ?>">
            <figure>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($text); ?>">
            </figure>
            <h4><?php echo esc_html($text); ?></h4>
        </div>
        <?php
        echo ob_get_clean();
    }
}

/**
 * // User authorization
 * @return
 */
if (!function_exists('taskbot_user_not_authorized')) {
    add_action('taskbot_user_not_authorized', 'taskbot_user_not_authorized');
    function taskbot_user_not_authorized()
    {
        ob_start();
        taskbot_get_template(
            'dashboard/user-not-authorized.php'
        );
        echo ob_get_clean();
    }
}

/**
* // Task categories link
* @return
*/
if (!function_exists('taskbot_task_categories')) {
    add_action('taskbot_task_categories', 'taskbot_task_categories', 10, 2);
    function taskbot_task_categories($post_id, $taxonomy = 'product_cat')
    {
        global $taskbot_settings;
        $task_search_url    = !empty($taskbot_settings['tpl_service_search_page']) ? $taskbot_settings['tpl_service_search_page'] : '';
        $task_search_url    = get_the_permalink($task_search_url);
        $product_data       = get_post_meta($post_id, 'tb_service_meta', true);
        $product_category_links = '';
        $task_cat_search_url    = '';
        if (!empty($product_data['category'])) {
            $categories = $product_data['category'];
            foreach ($categories as $term_key => $term_name) {
                $term                   = get_term_by('slug', $term_key, $taxonomy);
                $term_name              = !empty($term->name) ? $term->name : '';
                if( !empty($term_name) ){
                    $task_cat_search_url    = add_query_arg('category', esc_attr($term->slug), $task_search_url);
                    $product_category_links .= '<li>';
                        $product_category_links .= '<h5><a href="' . esc_url($task_cat_search_url) . '" rel="tag">' . esc_html($term_name) . '</a></h5>';
                    $product_category_links .= '</li>';
                }
            }
        }

        if (!empty($product_data['subcategory'])) {
            $categories = $product_data['subcategory'];
            foreach ($categories as $term_key => $term_name) {
                $term                   = get_term_by('slug', $term_key, $taxonomy);
                $term_name              = !empty($term->name) ? $term->name : '';
                if( !empty($term_name) ){
                    $task_cat_search_url    = add_query_arg('sub_category', esc_attr($term->slug), $task_cat_search_url);
                    $product_category_links .= '<li>';
                        $product_category_links .= '<h5><a href="' . esc_url($task_cat_search_url) . '" rel="tag">' . esc_html($term_name) . '</a></h5>';
                    $product_category_links .= '</li>';
                }
            }
        }

        if (!empty($product_data['service_type'])) {
            $categories = $product_data['service_type'];
            foreach ($categories as $term_key => $term_name) {
                $term       = get_term_by('slug', $term_key, $taxonomy);
                $term_name  = !empty($term->name) ? $term->name : '';
                if( !empty($term_name) ){
                    $task_service_type_search_url = add_query_arg('service[]', esc_attr($term->slug), $task_cat_search_url);
                    $product_category_links .= '<li>';
                        $product_category_links .= '<h5><a href="' . esc_url($task_service_type_search_url) . '" rel="tag">' . esc_html($term_name) . '</a></h5>';
                    $product_category_links .= '</li>';
                }
            }
        }

        if (!empty($product_category_links)) {
            $product_categories = '<ul class="tb-desclinks">';
                $product_categories .= $product_category_links;
            $product_categories .= '</ul>';
            echo do_shortcode($product_categories);
        }
    }
}

/**
 * // Get user menu details
 * @return
 */
if (!function_exists('taskbot_login_user_menu_details')) {
    function taskbot_login_user_menu_details()
    {
        global $current_user,$taskbot_notification;
        ob_start();
        $notification		        = !empty($taskbot_notification['notify_module']) ? $taskbot_notification['notify_module'] : '';
        $taskbot_profile_menu_list  = Taskbot_Profile_Menu::taskbot_get_dashboard_profile_menu();
        $sortorder                  = array_column($taskbot_profile_menu_list, 'sortorder');
        array_multisort($sortorder, SORT_ASC, $taskbot_profile_menu_list);
        $user_identity              = intval($current_user->ID);
        $taskbot_user_role          = apply_filters('taskbot_get_user_type', $user_identity);
        $user_profile_id            = taskbot_get_linked_profile_id($current_user->ID, '', $taskbot_user_role);
        $user_name                  = taskbot_get_username($user_profile_id);
        $args['linked_profile']    = $user_profile_id;
        if( current_user_can('administrator') || ( !empty($taskbot_user_role) && ($taskbot_user_role == 'sellers' || $taskbot_user_role == 'buyers') )){

            $messages_count = apply_filters('wpguppy_count_all_unread_messages', $user_identity );
        ?>
        <div class="tk-main-notiwrap">
            <?php if( !current_user_can('administrator') && ( !empty($notification) || (in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins'))))) ){?>
                <ul class="tk-notidropdowns">
                    <?php if( !empty($notification) ){?>
                        <li class="tb-menu-notifications"><?php taskbot_get_template_part('dashboard/dashboard', 'list-notification', $args);?></li>
                    <?php } ?>
                    <?php if( (in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins')))) ){ ?>
                        <li class="tk-headerchatbtn">
                            <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('inbox', $user_identity, false);?>">
                                <i class="tb-icon-message-square"></i>
                                <?php if(!empty($messages_count) ){?><em class="tk-remaining-notification"><?php echo esc_html($messages_count);?></em><?php }?>
                                <span><?php esc_html_e('Messages','taskbot');?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <div class="tk-navbarbtn sub-menu-holder">
                <a href="javascript:void(0);" id="profile-avatar-menue-icon" class="tk-nav-signin">
                    <?php Taskbot_Profile_Menu::taskbot_get_avatar(); ?>
                </a>
                <ul class="sub-menu">
                    <?php
                    if (!empty($taskbot_user_role) && $taskbot_user_role === 'administrator') {
                        taskbot_get_template_part('dashboard/menus/admin/menu', 'list-items');
                    } else { 
                        if (!empty($taskbot_profile_menu_list)) {
                            foreach ($taskbot_profile_menu_list as $key => $menu_item) {
                                if (!empty($menu_item['type']) && ($menu_item['type'] == $taskbot_user_role || $menu_item['type'] == 'none')) {
                                    $menu_item['id'] = $key;
                                    taskbot_get_template_part('dashboard/menus/menu', 'avatar-items', $menu_item);
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php }
        return ob_get_clean();
    }
}

/**
 * Custom user menu
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_custom_user_menu')) {
    add_filter('wp_nav_menu_items', 'taskbot_custom_user_menu', 10, 2);
    function taskbot_custom_user_menu($items, $args)
    {
        global $taskbot_settings;
        $term_id = !empty($args->menu->term_id) ? intval($args->menu->term_id) : 0;
        if(empty($term_id) && !empty($args->menu)){
            $menudata = wp_get_nav_menu_object( $args->menu  );
            if(!empty($menudata->term_id)){
                $term_id = $menudata->term_id;
            }
        }

        if (class_exists('ACF') && function_exists('get_field')) {
            $term           = get_term($term_id);
            $user_details   = get_field('login_user_details', $term);

            if (!empty($user_details) && $user_details == 'yes') {
                if (is_user_logged_in()) {
                    $items .= '<li class="tk-user-menu-wrapper">';
                    $items .= taskbot_login_user_menu_details();
                    $items .= '</li>';
                } else {
                    $view_type  = !empty($taskbot_settings['registration_view_type']) ? $taskbot_settings['registration_view_type'] : 'pages';
                    $login      = taskbot_get_page_uri('login');
                    $login_class= '';
                    if( !empty($view_type) && $view_type === 'popup' ){
                       $login       = 'javascript:;';
                       $login_class = 'tk-login-poup'; 
                    }
                    $items      .= '<li class="tk-user-menu-wrapper"><div class="tk-navbarbtn"><a href="'.do_shortcode($login).'" class="tk-btn tk-login '.esc_attr($login_class).'">'.esc_html__('Sign in','taskbot').'</a><span data-type="post_task" id="tk_post_task" class="tk-btn-solid-lg">' . esc_html__('Post a task', 'taskbot') . '<i class="tb-icon-plus"></i></span></div></li>';
                }
            }
        }
        return $items;
    }
}

/**
 * Custom footer menu
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_footer_custom_user_menu')) {
    function taskbot_footer_custom_user_menu() {
        if (is_user_logged_in()) {
            ob_start();?>
                <div class="tb-user-menu d-xl-none d-xxl-none"><a href="javascript:;" class="tb-dbmenu tb_user_profile"><?php Taskbot_Profile_Menu::taskbot_get_avatar(); ?><i class="tb-icon-x"></i></a><?php echo do_shortcode(taskbot_login_user_menu_details());?></div>
            <?php
            echo ob_get_clean();
        }
    }
    add_action( 'wp_footer', 'taskbot_footer_custom_user_menu' );
}

/**
 * // Get freelancer views
 */
if (!function_exists('taskbot_get_freelancer_views')) {
    function taskbot_get_freelancer_views($freelancer_id = '')
    {
        if (empty($freelancer_id)) {
            return;
        }

        $taskbot_freelancer_views = get_post_meta($freelancer_id, 'taskbot_profile_views', TRUE);
        $taskbot_freelancer_views = !empty($taskbot_freelancer_views) ? intval($taskbot_freelancer_views) : 0;
        ob_start();
        ?>
        <li>
            <i class="tb-icon-eye"></i> 
            <span> 
                <?php  
                    if( !empty($taskbot_freelancer_views) ) {
                        echo wp_sprintf( _n( '%s view', '%s views', $taskbot_freelancer_views, 'taskbot' ), number_format_i18n($taskbot_freelancer_views) );
                    } else {
                        esc_html_e('0 view','taskbot');
                    }
                ?>
            </span>
        </li>
        <?php
        echo ob_get_clean();
    }
    add_action('taskbot_get_freelancer_views', 'taskbot_get_freelancer_views');
}

/**
 * getting freelancer rating and count
 */
if (!function_exists('taskbot_get_freelancer_rating_cuont')) {
    function taskbot_get_freelancer_rating_cuont($freelancer_id = '')
    {
        $user_rating                = get_post_meta( $freelancer_id, 'tb_total_rating', true );
        $user_rating                = !empty($user_rating) ? $user_rating : 0;
        $review_users               = get_post_meta( $freelancer_id, 'tb_review_users', true );
        $review_users               = !empty($review_users) ? intval($review_users) : 0;
        ob_start();
        ?>
        <li>
            <i class="fas fa-star tb-icon-yellow"></i>
            <em> <?php echo number_format($user_rating, 1, '.', ''); ?> </em>
            <span>
                (
                    <?php  if( !empty($review_users) ) {
                            echo wp_sprintf( _n( '%s review', '%s reviews', $review_users, 'taskbot' ), number_format_i18n($review_users) );
                    } else {
                        esc_html_e('0 review','taskbot');
                    }?>
                )
        </span>
        </li>
        <?php
        echo ob_get_clean();
    }
    add_action('taskbot_get_freelancer_rating_cuont', 'taskbot_get_freelancer_rating_cuont');
}

/**
 * Mark freelancer as fav list
 * freelancers
 */
if (!function_exists('taskbot_save_freelancer_html')) {
    function taskbot_save_freelancer_html($current_user_id = '', $seller_id = '', $key = '', $type = '', $saved_type = '')
    {
        $user_id            = !empty($current_user_id) ? $current_user_id : 0;
        $user_type          = apply_filters('taskbot_get_user_type', $current_user_id);
        $linked_profile_id  = taskbot_get_linked_profile_id($user_id, '', $user_type);
        $saved_items        = get_post_meta($linked_profile_id, $key, true);
        $saved_class        = !empty($saved_items) && in_array($seller_id, $saved_items) ? 'bg-redheart' : 'bg-heart';
        $action             = !empty($saved_items) && in_array($seller_id, $saved_items) ? '' : 'saved';
        ob_start();
        if (!empty($type) && $type == 'list') { ?>
            <li>
                <a href="javascript:void(0);" class="tb-heart" data-action="<?php echo esc_attr($action); ?>"
                   data-post_id="<?php echo intval($seller_id); ?>" data-id="<?php echo intval($user_id); ?>"
                   data-type="<?php echo esc_attr($user_type); ?>">
                    <span class="<?php echo esc_attr($saved_class); ?> tb-icon-heart"></span><?php esc_html_e('Save', 'taskbot'); ?>
                </a>
            </li>
        <?php } else if (!empty($type) && $type == 'v2') { ?>
                <a href="javascript:void(0);" class="tb_saved_items tk-save-item <?php echo esc_attr($saved_class); ?>"
                   data-action="<?php echo esc_attr($action); ?>"
                   data-post_id="<?php echo intval($seller_id); ?>" data-id="<?php echo intval($user_id); ?>"
                   data-type="<?php echo esc_attr($saved_type); ?>">
                    <span class="<?php echo esc_attr($saved_class); ?> tb-icon-heart"></span>
                </a>
        <?php }else { ?>
            <li>
                <a href="javascript:void(0);" class="tb_saved_items <?php echo esc_attr($saved_class); ?>"
                   data-action="<?php echo esc_attr($action); ?>"
                   data-post_id="<?php echo intval($seller_id); ?>" data-id="<?php echo intval($user_id); ?>"
                   data-type="<?php echo esc_attr($saved_type); ?>">
                    <span class="<?php echo esc_attr($saved_class); ?> tb-icon-heart"></span><?php esc_html_e('Save', 'taskbot'); ?>
                </a>
            </li>
        <?php }
        echo ob_get_clean();
    }
    add_action('taskbot_save_freelancer_html', 'taskbot_save_freelancer_html', 10, 5);
}

/**
 * Render Seller type html
 */
if (!function_exists('taskbot_render_price_filter_htmlv2')) {
    function taskbot_render_price_filter_htmlv2($price_text ='',$min_price='',$max_price='',$flag='')
    {
        if( !empty($price_text) ){?>
            <h6><?php echo esc_html($price_text);?></h6>
        <?php } ?>
        <div class="tk-areasizebox">
            <div class="form-group-wrap" id="tk-range-wrapper" data-bs-target="#rangecollapse">
                <div class="form-group form-group-half" >
                    <input type="number" class="form-control" value="<?php echo esc_attr($min_price); ?>" name="min_price" min="<?php echo esc_attr($min_price);?>" max="<?php echo esc_attr($max_price);?>" step="1" placeholder="<?php esc_attr_e('Min price','taskbot');?>" id="tb_amount_min">
                </div>
                <div class="form-group form-group-half">
                    <input type="number" class="form-control" value="<?php echo esc_attr($max_price); ?>" name="max_price" step="1" placeholder="<?php esc_attr_e('Max price','taskbot');?>" id="tb_amount_max">
                </div>
            </div>
            <div class="tb-distanceholder tb-distanceholder-v2">
            <div class="collapse tk-distance" id="rangecollapse">
                <div id="slider-range" class="tk-tooltiparrow tk-rangeslider"></div>
            </div>
            </div>
        </div>
        <?php
        $script = "jQuery(document).on('ready', function ($) {
                jQuery('#slider-range').slider({
                    range: true,
                    min: " . esc_attr($min_price) . ",
                    max: " . esc_attr($max_price) . ",
                    values: ['" . esc_attr($min_price) . "', '" .esc_attr( $max_price) . "'],
                    slide: function(event, ui) {
                    jQuery('#tb_amount_min').val(ui.values[0]);
                    jQuery('#tb_amount_max').val(ui.values[1]);
                    }
                });

                jQuery('#tb_amount_min').val(jQuery('#slider-range').slider('values', 0));
                jQuery('#tb_amount_max').val(jQuery('#slider-range').slider('values', 1));
                jQuery('#tb_amount_min').change(function() {
                    jQuery('#slider-range').slider('values', 0, jQuery(this).val());
                });

                jQuery('#tb_amount_max').change(function() {
                    jQuery('#slider-range').slider('values', 1, jQuery(this).val());
                });

                jQuery(document).on('click', '.tb-reset-price-range', function (e) {
                    e.preventDefault();
                    jQuery('#tb_amount_min').val(" . esc_attr($min_price) . ");
                    jQuery('#tb_amount_max').val(" . esc_attr($max_price) . ");
                });

                jQuery(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
            });";
        wp_add_inline_script('taskbot', $script, 'after');
    }
    add_action('taskbot_render_price_filter_htmlv2', 'taskbot_render_price_filter_htmlv2', 10, 4);
}

/**
 * Render term html
 */
if (!function_exists('taskbot_render_term_filter_htmlv2')) {
    function taskbot_render_term_filter_htmlv2($selected_type   = array(),$type='',$attribute='',$text='')
    {
        $term_data = taskbot_get_term_dropdown($type, false, 0, false);
        ob_start();
        if (is_array($term_data) && !empty($term_data)) {
            ?>
            <div class="tk-advancecheck">
                <?php if( !empty($text) ){?>
                    <h6><?php echo esc_html($text);?></h6>
                <?php } ?>
                <ul class="tk-advancefilter">
                    <?php 
                    foreach ($term_data as $value) {
                        $checked = !empty($value->slug) && !empty($selected_type) && in_array($value->slug, $selected_type) ? 'checked' : '';
                        ?>
                        <li>
                            <div class="tk-form-checkbox">
                                <input class="form-check-input tk-form-check-input-sm" id="<?php echo esc_html($value->term_id); ?>" value="<?php echo esc_html($value->slug); ?>" type="checkbox" <?php echo do_shortcode( $attribute )?> <?php echo esc_attr($checked); ?>>
                                <label for="<?php echo esc_html($value->term_id); ?>" class="form-check-label">
                                    <span><?php echo esc_html($value->name); ?></span>
                                </label>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        echo ob_get_clean();
    }
    add_action('taskbot_render_term_filter_htmlv2', 'taskbot_render_term_filter_htmlv2', 10, 4);
}

/**
 * Render Seller type html
 */
if (!function_exists('taskbot_render_seller_type_filter_html')) {
    function taskbot_render_seller_type_filter_html($selected_seller_type   = array())
    {
        $seller_type_data = taskbot_get_term_dropdown('tb_seller_type', false, 0, false);
        ob_start();
        if (is_array($seller_type_data) && !empty($seller_type_data)) {
            ?>
            <div class="tk-aside-holder">
                <div class="tb-sidebartitle collapsed" data-bs-toggle="collapse" data-bs-target="#seller-type" role="button" aria-expanded="false">
                    <h5><i class="tb-icon-minus"></i> <?php esc_html_e('Seller Type', 'taskbot'); ?></h5>
                </div>
                <div class="tb-sidebarcontent collapse" id="seller-type">
                    <ul class="tb-categoriesfilter">
                        <?php 
                        foreach ($seller_type_data as $value) {
                            $checked = !empty($value->slug) && !empty($selected_seller_type) && in_array($value->slug, $selected_seller_type) ? 'checked' : '';
                            ?>
                            <li>
                                <div class="tb-checkbox">
                                    <input id="<?php echo esc_html($value->term_id); ?>" value="<?php echo esc_html($value->slug); ?>" type="checkbox" name="seller_type[]" <?php echo esc_attr($checked); ?>>
                                    <label for="<?php echo esc_html($value->term_id); ?>">
                                        <span><?php echo esc_html($value->name); ?></span>
                                    </label>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        echo ob_get_clean();
    }
    add_action('taskbot_render_seller_type_filter_html', 'taskbot_render_seller_type_filter_html', 10, 1);
}

/**
 * Render Seller English Level html
 */
if (!function_exists('taskbot_render_english_level_filter_html')) {
    function taskbot_render_english_level_filter_html($selected_english_level   = array())
    {
        global $taskbot_settings;
        $hide_languages       = !empty($taskbot_settings['hide_languages']) ? $taskbot_settings['hide_languages'] : 'no';
        $english_level_data = taskbot_get_term_dropdown('tb_english_level', false, 0, false);
        ob_start();
        if ( !empty($english_level_data) && is_array($english_level_data)) {
            ?>
            <div class="tk-aside-holder">
                <div class="tb-sidebartitle collapsed" data-bs-toggle="collapse" data-bs-target="#eng-level" role="button" aria-expanded="false">
                    <h5><i class="tb-icon-minus"></i> <?php esc_html_e('English Level', 'taskbot'); ?></h5>
                </div>
                <div class="tb-sidebarcontent collapse" id="eng-level">
                    <ul class="tb-categoriesfilter">
                        <?php
                        foreach ($english_level_data as $value) {
                            $checked = !empty($value->slug) && !empty($selected_english_level) && in_array($value->slug, $selected_english_level) ? 'checked' : '';
                            ?>
                            <li>
                                <div class="tb-checkbox">
                                    <input id="<?php echo esc_html($value->term_id); ?>"
                                           value="<?php echo esc_html($value->slug); ?>" type="checkbox" name="english_level[]" <?php echo esc_attr($checked); ?>>
                                    <label for="<?php echo esc_html($value->term_id); ?>"><span><?php echo esc_html($value->name); ?></span></label>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        echo ob_get_clean();
    }
    add_action('taskbot_render_english_level_filter_html', 'taskbot_render_english_level_filter_html', 10, 1);
}

/**
 * Render price range html
 */
if (!function_exists('taskbot_render_price_range_filter_html')) {
    function taskbot_render_price_range_filter_html($title = '', $min_price = 0, $max_price = 0){
        global $taskbot_settings;
        $min_search_price       = !empty($taskbot_settings['min_search_price']) ? $taskbot_settings['min_search_price'] : 1;
        $max_search_price       = !empty($taskbot_settings['max_search_price']) ? $taskbot_settings['max_search_price'] : 5000;
        $disable_range_slider   = !empty($taskbot_settings['disable_range_slider']) ? $taskbot_settings['disable_range_slider'] : false;

        if( empty($min_price) ){
            $min_price  = $min_search_price;
        }

        if( empty($max_price) ){
            $max_price  = $max_search_price; 
        }

        ob_start();
        ?>
        <div class="tk-aside-holder">
            <div class="tb-sidebartitle collapsed" data-bs-toggle="collapse" data-bs-target="#price" role="button" aria-expanded="false">
                <h5><?php echo esc_html($title); ?></h5>
            </div>
            <div class="tb-areasizebox collapse" id="price">
                <div class="tb-rangevalue" data-bs-target="#tb-rangecollapse" role="list" aria-expanded="false">
                    <input type="number" value="<?php echo esc_attr($min_price);?>" name="min_price" id="tb_amount_min" class="form-control" autocomplete="off">
                    <input type="number" value="<?php echo esc_attr($max_price);?>" name="max_price" id="tb_amount_max" class="form-control" autocomplete="off">
                </div>
            </div>
            <?php  if(!empty($disable_range_slider)){?>
                <div class="tb-distanceholder">
                    <div id="tb-rangecollapse" class="collapse">
                        <div class="tb-distance">
                            <div id="slider-range"></div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
        <?php
        if(!empty($disable_range_slider)){
            $script = "jQuery(document).on('ready', function ($) {
                jQuery('#slider-range').slider({
                    range: true,
                    min: " . esc_attr($min_search_price) . ",
                    max: " . esc_attr($max_search_price) . ",
                    values: ['" . esc_attr($min_price) . "', '" .esc_attr( $max_price) . "'],
                    slide: function(event, ui) {
                    jQuery('#tb_amount_min').val(ui.values[0]);
                    jQuery('#tb_amount_max').val(ui.values[1]);
                    }
                });

                jQuery('#tb_amount_min').val(jQuery('#slider-range').slider('values', 0));
                jQuery('#tb_amount_max').val(jQuery('#slider-range').slider('values', 1));
                jQuery('#tb_amount_min').change(function() {
                    jQuery('#slider-range').slider('values', 0, jQuery(this).val());
                });

                jQuery('#tb_amount_max').change(function() {
                    jQuery('#slider-range').slider('values', 1, jQuery(this).val());
                });

                jQuery(document).on('click', '.tb-reset-price-range', function (e) {
                    e.preventDefault();
                    let lower_value_ = jQuery('#priceMin').val();
                    let upper_value_ = jQuery('#priceMax').val();
                    jQuery('#tb_amount_min').val(1);
                    jQuery('#tb_amount_max').val(10000);
                });

                jQuery(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
            });";
            wp_add_inline_script('taskbot', $script, 'after');
        }
        echo ob_get_clean();
    }

    add_action('taskbot_render_price_range_filter_html', 'taskbot_render_price_range_filter_html', 10, 3);
}

/**
 * Render Location html
 */
if (!function_exists('taskbot_render_location_filter_html')) {
    function taskbot_render_location_filter_html($tb_location = '')
    {
        if (class_exists('WooCommerce')) {
            $countries_obj = new WC_Countries();
            $countries = $countries_obj->get_allowed_countries('countries');
        }
        ob_start();
        if (is_array($countries) && !empty($countries)) {
            ?>
            <div class="tk-aside-holder">
                <div class="tb-sidebartitle collapsed" data-bs-toggle="collapse" data-bs-target="#location" role="button" aria-expanded="false">
                    <h5><i class="tb-icon-minus"></i> <?php esc_html_e('Location', 'taskbot'); ?></h5>
                </div>
                <div class="tb-select collapse" id="location">
                    <select id="tb_country" name="location" class="form-control" data-placeholderinput="<?php esc_attr_e('Search country', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose country', 'taskbot'); ?>">
                        <option selected hidden disabled value=""><?php esc_html_e('Select location...', 'taskbot'); ?></option>

                        <?php
                        foreach ($countries as $key => $item) {
                            $selected = (!empty($tb_location) && $tb_location === $key) ? 'selected' : '';
                            ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($item); ?> </option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
            </div>
            <?php
        }
        echo ob_get_clean();
    }
    add_action('taskbot_render_location_filter_html', 'taskbot_render_location_filter_html', 10, 1);
}

/**
 * Set Terms Dropdown
 */
if (!function_exists('taskbot_get_term_dropdown')) {
    function taskbot_get_term_dropdown($taxonomy_name = 'category', $hierarical = false, $parent = 0, $hide_empty = false)
    {
        $term_data = array(
            'taxonomy' => $taxonomy_name,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => $hide_empty,
            'parent' => $parent,
            'number' => false, //can be 0, '0', '' too
            'offset' => '',
            'fields' => 'all',
            'name' => '',
            'slug' => '',
            'hierarchical' => $hierarical, //can be 1, '1' too
            'search' => '',
            'name__like' => '',
            'description__like' => '',
            'pad_counts' => false, //can be 0, '0', '' too
            'get' => '',
            'child_of' => false, //can be 0, '0', '' too
            'childless' => false,
            'cache_domain' => 'core',
            'update_term_meta_cache' => true, //can be 1, '1' too
            'meta_query' => '',
            'meta_key' => array(),
            'meta_value' => '',
        );
        return get_terms($term_data);
    }
}

/**
 * withdraw sort by
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_withdraw_sortby_filter')) {
    add_action('taskbot_withdraw_sortby_filter', 'taskbot_withdraw_sortby_filter', 10, 1);
    function taskbot_withdraw_sortby_filter($sorted_val = '')
    {
        ?>
        <div class="wo-inputicon">
            <div class="tb-actionselect tb-actionselect2">
                <span><?php esc_html_e('Filter by withdraw', 'taskbot'); ?>: </span>
                <div class="tb-select">
                    <select name="sort_by" id="tb-withdraw-sort" class="form-control" data-placeholder="<?php esc_attr_e('Select', 'taskbot'); ?>" onchange="submit_withdraw_search()">
                        <option selected hidden disabled><?php esc_html_e('Select', 'taskbot'); ?></option>
                        <option value="any"  <?php if (!empty($sorted_val) && $sorted_val == "any")  { echo esc_attr("selected"); } ?> > <?php esc_html_e('All', 'taskbot');   ?> </option>
                        <option value="pending"  <?php if (!empty($sorted_val) && $sorted_val == "pending")  { echo esc_attr("selected"); } ?> > <?php esc_html_e('Pending', 'taskbot');   ?> </option>
                        <option value="publish"  <?php if (!empty($sorted_val)  && $sorted_val == "publish")  { echo esc_attr("selected"); } ?> > <?php esc_html_e('Approved', 'taskbot'); ?> </option>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
 * withdraw post id search
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_withdraw_search')) {
    add_action('taskbot_withdraw_search', 'taskbot_withdraw_search', 10, 1);
    function taskbot_withdraw_search($withdraw_id   = '')
    {
        ?>
        <div class="form-group wo-inputicon wo-inputheight">
            <i class="tb-icon-search"></i>
            <input type="text" class="form-control" name="withdraw_id" value="<?php echo esc_attr($withdraw_id) ?>" placeholder="<?php esc_attr_e('Search withdrawn records here', 'taskbot'); ?>">
        </div>
        <?php
    }
}

/**
 * Get activity chat history
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_activity_chat_history')) {
    function taskbot_activity_chat_history($value = array(), $type = 'parent', $user_id = 0)
    {
        $date           = !empty($value->comment_date) ? $value->comment_date : '';
        $author_id      = !empty($value->user_id) ? $value->user_id : '';
        $comments_id    = !empty($value->comment_ID) ? $value->comment_ID : '';
        $author         = !empty($value->comment_author) ? $value->comment_author : '';
        $message        = !empty($value->comment_content) ? $value->comment_content : '';
        $message_files  = get_comment_meta($value->comment_ID, 'message_files', true);
        $message_type   = get_comment_meta($value->comment_ID, '_message_type', true);
        $child_class    = !empty($type) && $type == 'child' ? 'tb-addcomment-child' : '';
        $date           = !empty($date) ? date_i18n('F j, Y', strtotime($date)) : '';
        $author_user_type   = apply_filters('taskbot_get_user_type', $author_id);
        $author_profile_id  = taskbot_get_linked_profile_id($author_id, '', $author_user_type);
        $auther_url         = !empty($author_user_type) && $author_user_type === 'sellers' ? get_the_permalink($author_profile_id) : '#';
        $author_name        = taskbot_get_username($author_profile_id);
        $avatar             = apply_filters(
            'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $author_profile_id), array('width' => 50, 'height' => 50)
        );
        ob_start();
        ?>
        <div class="tb-addcomment <?php echo esc_attr($child_class) ?>">
            <div class="tb-comentinfo">
                <figure>
                    <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
                </figure>
                <div class="tb-comentinfodetail">
                    <?php if (!empty($message_type) && $message_type == 'rejected') { ?>
                        <div class="tb-statustag">
                            <span class="tb-rejected">
                                <i class="fas fa-exclamation-circle"></i><?php esc_html_e('Rejected', 'taskbot'); ?>
                            </span>
                        </div>
                    <?php } ?>
                    <?php if (!empty($message_type) && $message_type == 'final') { ?>
                        <div class="tb-statustag">
                            <span>
                                <i class="far fa-bell"></i><?php esc_html_e('Final package', 'taskbot'); ?>
                            </span>
                        </div>
                    <?php } ?>
                    <a href="<?php echo esc_url($auther_url);?>">
                        <h5><span><?php echo esc_html($author_name); ?></span></h5>
                    </a>
                    <span><?php if (!empty($date)) { echo esc_html($date); } ?></span>
                </div>
            </div>
            <div class="tb-description">
                <p><?php echo esc_html(wp_strip_all_tags($message)); ?></p>
            </div>

            <!-- message attachments -->
            <?php if (isset($message_files) && !empty($message_files)) { ?>
                <div class="tb-documentlist">
                    <ul class="tb-doclist">
                        <?php foreach ($message_files as $message_file) {
                            $src = TASKBOT_DIRECTORY_URI . 'public/images/doc.jpg';
                            $file_url = $message_file['url'];
                            $file_uname = $message_file['name'];
                            if (isset($message_file['ext']) && !empty($message_file['ext'])) {
                                if ($message_file['ext'] == 'pdf') {
                                    $src = TASKBOT_DIRECTORY_URI . 'public/images/pdf.jpg';
                                } elseif ($message_file['ext'] == 'png') {
                                    $src = TASKBOT_DIRECTORY_URI . 'public/images/png.jpg';
                                } elseif ($message_file['ext'] == 'ppt') {
                                    $src = TASKBOT_DIRECTORY_URI . 'public/images/ppt.jpg';
                                } elseif ($message_file['ext'] == 'psd') {
                                    $src = TASKBOT_DIRECTORY_URI . 'public/images/psd.jpg';
                                } elseif ($message_file['ext'] == 'php') {
                                    $src = TASKBOT_DIRECTORY_URI . 'public/images/php.jpg';
                                }
                            } ?>
                            <li>
                                <a href="<?php echo esc_url($file_url); ?>" class="tb-download-attachment" data-id="<?php echo esc_attr($comments_id); ?>">
                                    <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($file_uname); ?>">
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <a href="javascript:void(0);" class="tb-download-attachment" data-id="<?php echo esc_attr($comments_id); ?>"><?php esc_html_e('Download file(s)', 'taskbot'); ?></a>
                </div>
            <?php } ?>
        </div>
        <?php
        echo ob_get_clean();
    }
    add_action('taskbot_activity_chat_history', 'taskbot_activity_chat_history', 10, 3);
}

/**
 * Load footer contents
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_load_footer_contents')) {
    add_action('init', 'taskbot_load_footer_contents');
    function taskbot_load_footer_contents()
    {
        if (!empty($_GET['key']) && !empty($_GET['verifyemail'])) {
            do_action('taskbot_verify_user_account');
        }
    }
}

/**
 * // Account verification
 * @return
 */
if (!function_exists('taskbot_verify_user_account')) {
    function taskbot_verify_user_account()
    {
        if (!empty($_GET['key']) && !empty($_GET['verifyemail'])) {
            $verify_key = esc_html($_GET['key']);
            $user_email = esc_html($_GET['verifyemail']);
            $user_email = !empty($user_email) ? str_replace(' ', '+', $user_email) : '';
            $user_data = get_user_by('email', $user_email);
            $user_identity = !empty($user_data) ? $user_data->ID : 0;
            $user_type = apply_filters('taskbot_get_user_type', $user_identity);
            if (!empty($user_identity)) {
                $confirmation_key = get_user_meta(intval($user_identity), 'confirmation_key', true);
                if ($confirmation_key === $verify_key) {
                    update_user_meta(intval($user_identity), 'confirmation_key', '');
                    update_user_meta(intval($user_identity), '_is_verified', 'yes');

                    // upon verification verify both profiles
                    $linked_seller_id = get_user_meta($user_identity, '_linked_profile', true);
                    $linked_buyer_id = get_user_meta($user_identity, '_linked_profile_buyer', true);
                    update_post_meta(intval($linked_seller_id), '_is_verified', 'yes');
                    update_post_meta(intval($linked_buyer_id), '_is_verified', 'yes');

                    if (!empty($user_type) && ($user_type == 'sellers' || $user_type == 'buyers')) {
                        $redirect = taskbot_get_page_uri('dashboard');
                    } else {
                        $redirect = home_url('/');
                    }
                    if (!is_user_logged_in()) {
                        if (!is_wp_error($user_data) && isset($user_data->ID) && !empty($user_data->ID)) {
                            wp_clear_auth_cookie();
                            wp_set_current_user($user_data->ID, $user_data->user_login);
                            wp_set_auth_cookie($user_data->ID, true);
                            update_user_caches($user_data);
                            do_action('wp_login', $user_data->user_login, $user_data);
                            wp_redirect($redirect);
                            exit();
                        }
                    } else {
                        wp_redirect($redirect);
                        exit();
                    }
                }
            }
        }
    }
    add_action('taskbot_verify_user_account', 'taskbot_verify_user_account');
}

/**
 * Check user account status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_check_user_account_status')) {
    add_action('taskbot_check_user_account_status', 'taskbot_check_user_account_status', 10, 1);
    function taskbot_check_user_account_status($postid)
    {
        $is_verified = get_post_meta($postid, '_is_verified', true);
        if (empty($is_verified) || $is_verified === 'no') {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Your account is not verified, so you cannot process further.', 'taskbot');
            wp_send_json($json);
        }
    }
}

/**
 * taskbot login/register with google
 * @return
 */
if (!function_exists('taskbot_social_login')) {
    function taskbot_social_login()
    {
        global $taskbot_settings;
        $json = array();
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        $register_type       = !empty($taskbot_settings['defult_register_type']) ? $taskbot_settings['defult_register_type'] : 'buyers';
        
        $json['message']    = esc_html__('Woohoo!','taskbot');
        if (!wp_verify_nonce($_POST['security'], 'ajax_nonce')) {
            $json['type']           = 'error';
            $json['message_desc']    = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json($json);
        }

        if (!empty($_POST['email'])) {
            $name       = sanitize_text_field($_POST['name']);
            $last_name  = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));
            $user_type  = $register_type;
            $user_email = !empty($_POST['email']) && is_email($_POST['email']) ? sanitize_email($_POST['email']) : '';
            $login_type = !empty($_POST['login_type']) ? sanitize_text_field($_POST['login_type']) : '';
            $ID         = email_exists($user_email);

            // User exists do login
            if (!empty($ID)) {
                $user_data      = get_user_by('email', $user_email);
                $user_identity  = !empty($user_data) ? $user_data->ID : 0;
                $user_type      = apply_filters('taskbot_get_user_type', $user_identity);

                if (!empty($user_type) && ($user_type == 'sellers' || $user_type == 'buyers')) {
                    $redirect = taskbot_get_page_uri('dashboard');
                } else {
                    $redirect = home_url('/');
                }

                if (!is_user_logged_in()) {
                    update_user_meta($user_data->ID, 'show_admin_bar_front', false);
                    
                    if (!is_wp_error($user_data) && isset($user_data->ID) && !empty($user_data->ID)) {
                        wp_clear_auth_cookie();
                        wp_set_current_user($user_data->ID, $user_data->user_login);
                        wp_set_auth_cookie($user_data->ID, true);
                        update_user_caches($user_data);
                        do_action('wp_login', $user_data->user_login, $user_data);
                    }
                }

                $json['type']           = 'success';
                $json['redirect']       = $redirect;
                $json['message_desc']    = esc_html__('You have successfully logged in', 'taskbot');
            } else {
                $user_nicename = sanitize_title($name);
                $userdata = array(
                    'user_login'    => $user_email,
                    'user_pass'     => '',
                    'user_email'    => $user_email,
                    'user_nicename' => $user_nicename,
                    'display_name'  => $name,
                );

                $user_identity = wp_insert_user($userdata);
                wp_update_user(array('ID' => esc_sql($user_identity), 'role' => 'subscriber', 'user_status' => 0));

                update_user_meta($user_identity, 'first_name', $first_name);
                update_user_meta($user_identity, 'last_name', $last_name);
                update_user_meta($user_identity, 'login_type', $login_type);
                update_user_meta($user_identity, 'show_admin_bar_front', false);

                if ($taskbot_settings['email_user_registration'] == 'verify_by_link') {
                    update_user_meta($user_identity, '_is_verified', 'yes');
                } else {
                    update_user_meta($user_identity, '_is_verified', 'no');
                }


                $verify_new_user    = !empty($taskbot_settings['verify_new_user']) ? $taskbot_settings['verify_new_user'] : 'verify_by_link';

                if (!empty($verify_new_user) && $verify_new_user == 'verify_by_admin') {
                    $json_message = esc_html__("Your account have been created. Please wait while your account is verified by the admin.", 'taskbot');
                } else {
                    $json_message = esc_html__("Your account have been created. Please verify your account, an email have been sent your email address.", 'taskbot');
                }
                
                if (!empty($user_identity)) {
                    $user_data	= get_userdata($user_identity);
                    wp_clear_auth_cookie();
                    wp_set_current_user($user_data->ID, $user_data->user_login);
                    wp_set_auth_cookie($user_data->ID, true);
                    update_user_caches($user_data);
                    do_action('wp_login', $user_data->user_login, $user_data);
                }

                $dashboard            = taskbot_auth_redirect_page_uri('login',$user_identity);
                $json['type']         = 'success';
                $json['message']      = $json_message;
                $json['redirect']     = wp_specialchars_decode($dashboard);

            }
        }
        wp_send_json($json);
    }
    add_action('wp_ajax_taskbot_social_login', 'taskbot_social_login');
    add_action('wp_ajax_nopriv_taskbot_social_login', 'taskbot_social_login');
}

/**
 * Account verification notice
 */
if (!function_exists('taskbot_notification')) {
    function taskbot_notification($title = '', $content = '')
    { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="tb-orderrequest tb-orderrequestv2">
                    <div class="tb-ordertitle">
                        <?php if (!empty($title)) { ?>
                            <h5><?php echo esc_html($title); ?></h5>
                        <?php } ?>
                        <?php if (!empty($content)) { ?>
                            <p><?php echo esc_html($content); ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    add_action('taskbot_notification', 'taskbot_notification', 10, 2);
}

/**
 * Account verification notice
 */
if (!function_exists('taskbot_verify_account_notice')) {
    function taskbot_verify_account_notice($is_verified = 'yes') {
        global $current_user, $taskbot_settings;
        $identity_verification	= !empty($taskbot_settings['identity_verification']) ? $taskbot_settings['identity_verification'] : false;
        if (empty($is_verified) || $is_verified === 'no') {
            if (!empty($taskbot_settings['email_user_registration']) && $taskbot_settings['email_user_registration'] == 'verify_by_link') {
                ob_start();
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tb-orderrequest tb-orderrequestv2 tk-email-verification tb-alert-information">
                            <div class="tb-ordertitle">
                                <h5><?php esc_html_e('Email verification required', 'taskbot') ?></h5>
                                <p><?php esc_html_e('Your email is not verified, please verify your email to perform any action on the site. You can click button to get a verification link', 'taskbot') ?></p>
                            </div>
                            <div class="tb-orderbtn">
                                <a class="tb-btn btn-orange re-send-email" href="javascript:void(0);"><?php esc_html_e('Resend email', 'taskbot'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo ob_get_clean();
            } else {
                ob_start();
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tb-orderrequest tb-orderrequestv2 tk-email-verification tb-alert-information">
                            <div class="tb-ordertitle">
                                <h5><?php esc_html_e('Email verification required', 'taskbot') ?></h5>
                                <p><?php esc_html_e('Your email is not verified, please contact to administrator for the verification.', 'taskbot') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo ob_get_clean();
            }
        }
        
        if( !empty($identity_verification) ){
            $verification_attachments  	= get_user_meta($current_user->ID, 'verification_attachments', true);
            $verification_attachments	= !empty($verification_attachments) ? $verification_attachments : array();
            $identity_verified  	    = get_user_meta($current_user->ID, 'identity_verified', true);
            $identity_verified		    = !empty($identity_verified) ? $identity_verified : 0;
            ?>
            <?php if(empty($identity_verified) && !empty($verification_attachments) ){?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tb-orderrequest tk-id-verification tb-alert-information">
                            <div class="tb-ordertitle">
                                <h5><?php esc_html_e('Woohoo!', 'taskbot') ?></h5>
                                <p><?php esc_html_e('You have successfully submitted your documents. buckle up, we will verify and respond to your request very soon.', 'taskbot') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else if(empty($identity_verified) ){ ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tb-orderrequest tb-orderrequestv2 tk-id-verification tb-alert-danger">
                            <div class="tb-ordertitle">
                                <h5><?php esc_html_e('Verification required', 'taskbot') ?></h5>
                                <p><?php esc_html_e('You must verify your identity, please submit the required documents to get verified. As soon as you will be verified then you will be able to get online orders', 'taskbot') ?></p>
                            </div>
                            <div class="tb-orderbtn">
                                <a class="tb-btn btn-green" href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link('dashboard', $current_user->ID, false, 'verification') ?>"><?php esc_html_e("let's verify account", 'taskbot'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }

    }
    add_action('taskbot_verify_account_notice', 'taskbot_verify_account_notice');
}

/**
 * Resend Account verification link
 */
if (!function_exists('taskbot_resend_verification')) {
    add_action('wp_ajax_taskbot_resend_verification', 'taskbot_resend_verification');
    add_action('wp_ajax_nopriv_taskbot_resend_verification', 'taskbot_resend_verification');
    function taskbot_resend_verification()
    {
        global $current_user, $taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }
        //security check
        if (!wp_verify_nonce($_POST['security'], 'ajax_nonce')) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Oops!', 'taskbot');
            $json['message_desc'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
            wp_send_json($json);
        }

        $user_identity      = $current_user->ID;
        $user_data          = get_user_by('email', $current_user->user_email);
        $user_email         = $user_data->user_email;
        $user_profile_id    = taskbot_get_linked_profile_id($user_identity);
        $username           = taskbot_get_username($user_profile_id);
        $username           = !empty($username) ? $username : $user_data->display_name;
        $verify_new_user    = !empty($taskbot_settings['verify_new_user']) ? $taskbot_settings['verify_new_user'] : 'verify_by_link';

        if (!empty($verify_new_user) && $verify_new_user == 'verify_by_link') {
            //verification link
            $key_hash   = md5(uniqid(openssl_random_pseudo_bytes(32)));
            update_user_meta($user_identity, 'confirmation_key', $key_hash);
            $protocol       = is_ssl() ? 'https' : 'http';
            $verify_link    = esc_url(add_query_arg(array('key' => $key_hash . '&verifyemail=' . $user_email), home_url('/', $protocol)));

            if (class_exists('Taskbot_Email_helper')) {
                $blogname               = get_option('blogname');
                $emailData              = array();
                $emailData['name']      = $username;
                $emailData['password']  = '';
                $emailData['email']     = $user_email;
                $emailData['site']      = $blogname;
                $emailData['verification_link'] = $verify_link;
                

                if (class_exists('TaskbotRegistrationStatuses')) {
                    $email_helper = new TaskbotRegistrationStatuses();
                    $email_helper->registration_user_email($emailData);
                }

                $json_message = esc_html__("An email has been sent to your email address.", 'taskbot');
                $json['type'] = 'success';
                $json['message'] = esc_html__('Woohoo!', 'taskbot');
                $json['message_desc'] = $json_message;
                wp_send_json($json);
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Oops!', 'taskbot');
            $json['message_desc'] = esc_html__('Some error occurs, please contact administrator to process verification', 'taskbot');
            wp_send_json($json);
        }
    }
}

/**
 * theme sort by hook
 */
if (!function_exists('taskbot_price_sortby_filter_theme')) {
    function taskbot_price_sortby_filter_theme($sorted_val = '')
    {
        ?>
        <div class="tk-sortby">
            <div class="tk-actionselect">
                <span><?php esc_html_e('Sort by:', 'taskbot'); ?></span>
                <div class="tk-select">
                    <select class="form-control tb-select-country tk-selectv" id="tb-sort" onchange="merge_search_field()">
                        <option value="date_desc"    <?php if (isset($sorted_val) && $sorted_val == "date_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Recent listings', 'taskbot'); ?>            </option>
                        <option value="price_asc"    <?php if (isset($sorted_val) && $sorted_val == "price_asc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Price low to high', 'taskbot'); ?> </option>
                        <option value="price_desc"   <?php if (isset($sorted_val) && $sorted_val == "price_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Price high to low', 'taskbot'); ?> </option>
                        <option value="views_desc"   <?php if (isset($sorted_val) && $sorted_val == "views_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Listing views', 'taskbot'); ?>             </option>
                        <option value="orders_desc"  <?php if (isset($sorted_val) && $sorted_val == "orders_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Listing popularity', 'taskbot'); ?>           </option>
                        <option value="reviews_desc" <?php if (isset($sorted_val) && $sorted_val == "reviews_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Listing reviews', 'taskbot'); ?>           </option>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
    add_action('taskbot_price_sortby_filter_theme', 'taskbot_price_sortby_filter_theme', 10, 1);
}

/**
 * theme sort by hook
 */
if (!function_exists('taskbot_project_price_sortby_filter_theme')) {
    function taskbot_project_price_sortby_filter_theme($sorted_val = '')
    {
        ?>
        <div class="tk-sortby">
            <div class="tk-actionselect">
                <span><?php esc_html_e('Sort by:', 'taskbot'); ?></span>
                <div class="tk-select">
                    <select class="form-control tb-select-country tk-selectv" id="tb-sort" onchange="merge_search_field()">
                        <option value="date_desc"    <?php if (isset($sorted_val) && $sorted_val == "date_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Recent listings', 'taskbot'); ?>            </option>
                        <option value="price_asc"    <?php if (isset($sorted_val) && $sorted_val == "price_asc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Price low to high', 'taskbot'); ?> </option>
                        <option value="price_desc"   <?php if (isset($sorted_val) && $sorted_val == "price_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Price high to low', 'taskbot'); ?> </option>
                        <option value="views_desc"   <?php if (isset($sorted_val) && $sorted_val == "views_desc") { echo esc_attr("selected"); } ?> > <?php esc_html_e('Listing views', 'taskbot'); ?>             </option>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
    add_action('taskbot_project_price_sortby_filter_theme', 'taskbot_project_price_sortby_filter_theme', 10, 1);
}
/**
 * theme keyword search hook
 */
if (!function_exists('taskbot_keyword_search_filter_theme')) {
    function taskbot_keyword_search_filter_theme($search_keyword = '')
    {
        ?>
        <div class="tk-aside-content">
            <div class="tk-inputiconbtn">
                <div class="tk-placeholderholder">
                    <input type="text" name="keyword" placeholder="<?php esc_attr_e('Search with keyword', 'taskbot'); ?>" value="<?php echo esc_attr($search_keyword); ?>" class="form-control">
                </div>
                <a href="javascript:void(0);" class="tk-search-icon"><i class="tb-icon-search"></i></a>
            </div>
        </div>
        <?php
    }
    add_action('taskbot_keyword_search_filter_theme', 'taskbot_keyword_search_filter_theme', 10, 1);
}

/**
 * theme location hook
 */
if (!function_exists('taskbot_location_filter_theme')) {
    function taskbot_location_filter_theme($location)
    {
        $countries  = array();
        if (class_exists('WooCommerce')) {
            $countries_obj = new WC_Countries();
            $countries = $countries_obj->get_allowed_countries('countries');
        }
        ob_start();
        if (is_array($countries) && !empty($countries)) {
            ?>
            <div class="tk-aside-holder">
                <div class="tk-asidetitle collapsed" data-bs-toggle="collapse" data-bs-target="#Location" role="button" aria-expanded="false">
                    <h5><?php esc_html_e('Location', 'taskbot'); ?></h5>
                </div>
                <div id="Location" class="collapse">
                    <div class="tk-aside-content">
                        <div class="tk-filterselect">
                            <div class="tb-select-country tk-select">
                                <select id="tb_country" name="location" data-placeholderinput="<?php esc_attr_e('Search location', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Select location', 'taskbot'); ?>" class="form-control">
                                    <option selected hidden disabled><?php esc_html_e('Select location...', 'taskbot'); ?></option>
                                    <?php foreach ($countries as $key => $item) {
                                        $selected = (!empty($location) && $location === $key) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($item); ?></option>
                                        <?php
                                    }?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        echo ob_get_clean();
    }
    add_action('taskbot_location_filter_theme', 'taskbot_location_filter_theme', 10, 1);
}

/**
 * theme location hook
 */
if (!function_exists('taskbot_location_search_field')) {
    function taskbot_location_search_field($location='')
    {
        global $taskbot_settings;
        $countries  = array();
        if (class_exists('WooCommerce')) {
            $countries_obj = new WC_Countries();
            $countries = $countries_obj->get_allowed_countries('countries');
        }
        $enable_state		    = !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
        ob_start();
        if (is_array($countries) && !empty($countries)) {
            $cat_expanded           = !empty($location) ? 'true' : 'false';
            $cat_collapse           = !empty($location) ? '' : 'collapsed';
            $cat_collapse_content   = !empty($location) ? 'show' : '';
            ?>
            <div class="tk-aside-holder">
                <div class="tk-asidetitle <?php echo esc_attr($cat_collapse);?>" data-bs-toggle="collapse" data-bs-target="#tklocation" role="button" aria-expanded="<?php echo esc_attr($cat_expanded);?>">
                    <h5><?php esc_html_e('Location', 'taskbot'); ?></h5>
                </div>
                <div id="tklocation" class="collapse <?php echo esc_attr($cat_collapse_content);?>">
                    <div class="tk-aside-content">
                        <div class="tk-filterselect tk-select">
                            <select id="task_location" name="location" data-placeholderinput="<?php esc_attr_e('Search location', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Select location', 'taskbot'); ?>" class="form-control">
                                <option value=""><?php esc_html_e('Search location','taskbot');?></option>
                                <?php foreach ($countries as $key => $item) {
                                    $selected = (!empty($location) && $location === $key) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($item); ?></option>
                                    <?php
                                }?>
                            </select>
                        </div>
                    
                        <?php if( !empty($enable_state) ){ 
                            $states			 	= !empty($location) ? $countries_obj->get_states( $location ) : array();
                            $state              = !empty($_GET['state']) ? $_GET['state'] : '';
                            $state_country_class    = empty($location) || empty($states) ? 'd-sm-none' : '';
                            ?>
                                <div class="tk-filterselect tb-state-parent <?php echo esc_attr($state_country_class);?>">
                                    <div class="tk-select">
                                        <select id="tk-search-state" class="tb-country-state" name="state" data-placeholderinput="<?php esc_attr_e('Search states', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose states', 'taskbot'); ?>">
                                            <option selected hidden disabled value=""><?php esc_html_e('Select States', 'taskbot'); ?></option>
                                            <?php if (!empty($states)) {
                                                foreach ($states as $key => $item) {
                                                    $selected = '';
                                                    if (!empty($state) && $state === $key) {
                                                        $selected = 'selected';
                                                    } ?>
                                                    <option class="tb-state-option" <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
                                            <?php }
                                            } ?>
                                    </select>
                                    </div>
                                </div>
                            
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
        }
        echo ob_get_clean();
    }
    add_action('taskbot_location_search_field', 'taskbot_location_search_field', 10, 1);
}
/**
 * Theme search and clear buttons hook
 */
if (!function_exists('taskbot_search_clear_button_theme')) {
    function taskbot_search_clear_button_theme($title = 'Search', $page_url = '')
    {
        ?>
        <div class="tk-filterbtns">
            <button type="submit" class="tk-btn-solid-lg" id="taskbot_apply_filter"><?php echo esc_html($title); ?></button>
            <a href="<?php echo esc_url($page_url); ?>" class="tk-btn-solid tk-btn-plain"><?php esc_html_e('Clear all filters', 'taskbot'); ?></a>
        </div>
        <?php
    }
    add_action('taskbot_search_clear_button_theme', 'taskbot_search_clear_button_theme', 10, 2);
}

/**
 * No record found
 */
if (!function_exists('taskbot_empty_records_html')) {
    function taskbot_empty_records_html($class = '', $text = '')
    {
        global $taskbot_settings;
        ob_start();
        $image_url = !empty($taskbot_settings['empty_listing_image']['url']) ? $taskbot_settings['empty_listing_image']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/empty.png';
        ?>
        <div class="tb-submitreview tb-submitreviewv3">
            <figure>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('add task', 'taskbot'); ?>">
            </figure>
            <h4><?php echo esc_html($text); ?></h4>
        </div>
        <?php
        echo ob_get_clean();
    }
    add_action('taskbot_empty_records_html', 'taskbot_empty_records_html', 10, 2);
}

/**
 * @Show user post type on add user
 * @type create
 */
if (!function_exists('taskbot_custom_user_profile_fields')) {
	function taskbot_custom_user_profile_fields($user){
        ob_start();?>
		<h3><?php esc_html_e('Extra profile information','taskbot');?></h3>
		<table class="form-table">
			<tr>
				<th><label for="company"><?php esc_html_e('User type','taskbot');?></label></th>
				<td>
					<select name="type" id="taskbot-type">
						<option value="buyers"><?php esc_html_e('Buyer','taskbot');?></option>		
						<option value="sellers"><?php esc_html_e('Seller','taskbot');?></option>
				   </select><br>
					<span class="description"><?php esc_html_e('User role should be subscriber to create user type post','taskbot');?></span>
				</td>
			</tr>
		</table>
	  <?php echo ob_get_clean();
	}
	add_action( "user_new_form", "taskbot_custom_user_profile_fields" );
}

/**
 * @Create profile from admin create user
 * @type create
 */
if (!function_exists('taskbot_create_wp_user')) {
	add_action( 'user_register', 'taskbot_create_wp_user',5,2 );
    function taskbot_create_wp_user($user_id=array(),$user_array=array()) {
        global $taskbot_settings;
        $user_name_option   = !empty($taskbot_settings['user_name_option']) ? $taskbot_settings['user_name_option'] : false;
		$shortname_option  =  !empty($taskbot_settings['shortname_option']) ? $taskbot_settings['shortname_option'] : '';

        $first_name_post	= '';
        $last_name_post	    = '';

        if( !empty( $user_id )  ) {
            $user_data_set	= get_userdata($user_id);
            $roles		    = !empty($user_data_set->roles) ? $user_data_set->roles : '';
            $email		    = !empty($user_data_set->user_email) ? $user_data_set->user_email : '';

            if( !empty($roles) && in_array('subscriber',$roles)){
                $user_type          = !empty($_POST['type']) ? $_POST['type'] : '';
                $post_data          = !empty($_POST['data']) ? $_POST['data'] : '';

                if(empty($user_type) && !empty($post_data) ){
                    parse_str($post_data, $output);
                    $user_type   = !empty($output['user_registration']['user_type']) ? $output['user_registration']['user_type'] : 'buyers';
                    $first_name_post   = !empty($output['user_registration']['first_name']) ? $output['user_registration']['first_name'] : '';
                    $last_name_post    = !empty($output['user_registration']['last_name']) ? $output['user_registration']['last_name'] : '';
                }

                //If no role is assigned then assign default role
                if(empty($user_type )){
                    $user_type       = !empty($taskbot_settings['defult_register_type']) ? $taskbot_settings['defult_register_type'] : 'buyers';
                }

                $first_name     = get_user_meta($user_id, 'first_name', true);
                $last_name      = get_user_meta($user_id, 'last_name', true);
                $first_name     = !empty($first_name) ? $first_name : $first_name_post;
                $last_name      = !empty($last_name) ? $last_name : $last_name_post;

                $display_name   =  $first_name .  " " . $last_name;
                $display_name   = !empty($user_array['display_name']) ? $user_array['display_name'] : $display_name;

                update_user_meta($user_id, 'first_name', $first_name);
                update_user_meta($user_id, 'last_name', $last_name);
                update_user_meta($user_id, 'termsconditions', true);
                update_user_meta($user_id, 'show_admin_bar_front', false);
                update_user_meta($user_id, '_is_verified', 'no');

                $verify_link            = '';
                $verify_new_user        = !empty($taskbot_settings['email_user_registration']) ? $taskbot_settings['email_user_registration'] : 'verify_by_link';
                $identity_verification	= !empty($taskbot_settings['identity_verification']) ? $taskbot_settings['identity_verification'] : false;
                
                if (!empty($verify_new_user) && $verify_new_user == 'verify_by_link') {
                    //verification link
                    $key_hash     = md5(uniqid(openssl_random_pseudo_bytes(32)));
                    update_user_meta($user_id, 'confirmation_key', $key_hash);
                    $protocol     = is_ssl() ? 'https' : 'http';
                    $verify_link  = esc_url(add_query_arg(array('key' => $key_hash . '&verifyemail=' . $email), home_url('/', $protocol)));
                }

                //Short names
                $post_name      = $display_name;
                if (!empty($shortname_option)) {
                    $post_name      = explode(' ', $display_name);
                    $first_name_    = !empty($post_name[0]) ? ucfirst($post_name[0]) : '';
                    $second_name_   = !empty($post_name[1]) ? ' ' . strtoupper($post_name[1][0]) : '';
                    $post_name      = $first_name_ . $second_name_;
                }
                
                //Create Post
                $user_post = array(
                    'post_title'    => wp_strip_all_tags($display_name),
                    'post_name'    	=> $post_name,
                    'post_status'   => 'publish',
                    'post_author'   => $user_id,
                    'post_type'     => apply_filters('taskbot_profiles_user_post_type_name', $user_type),
                );

                $post_id = wp_insert_post($user_post);

                if (!is_wp_error($post_id)) {
                    $notifyDetails	  = array();
                    $dir_latitude     = !empty($taskbot_settings['dir_latitude']) ? $taskbot_settings['dir_latitude'] : 0.0;
                    $dir_longitude    = !empty($taskbot_settings['dir_longitude']) ? $taskbot_settings['dir_longitude'] : 0.0;

                    //add extra fields as a null
                    update_post_meta($post_id, '_address', '');
                    update_post_meta($post_id, '_latitude', $dir_latitude);
                    update_post_meta($post_id, '_longitude', $dir_longitude);
                    update_post_meta($post_id, '_linked_profile', $user_id);
                    update_post_meta($post_id, '_is_verified', 'no');
                    update_post_meta($post_id, 'zipcode', '');
                    update_post_meta($post_id, 'country', '');
                    update_user_meta($user_id, '_notification_email', $email);
                    update_post_meta( $post_id, 'is_avatar', 0 );
                    
                    if (!empty($user_type) && $user_type === 'buyers') {
                        update_user_meta($user_id, '_linked_profile_buyer', $post_id);
                        update_user_meta($user_id, '_user_type', 'buyers');
                        $notifyData['user_type']		= 'buyers';
                    } else if (!empty($user_type) && $user_type === 'sellers') {
                        update_post_meta($post_id, 'tb_hourly_rate', '');
                        update_user_meta($user_id, '_linked_profile', $post_id);
                        update_user_meta($user_id, '_user_type', 'sellers');
                        $notifyData['user_type']		= 'sellers';
                    }

                    if (!empty($identity_verification) ){
                        update_user_meta($user_id, 'identity_verified', 0);
                    } else {
                        update_user_meta($user_id, 'identity_verified', 1);
                    }

                    $notifyData['receiver_id']		= $user_id;
                    $notifyData['type']				= 'registration';
                    $notifyData['post_data']		= $notifyDetails;
                    $notifyData['linked_profile']	= $post_id;

                    do_action('taskbot_notification_message', $notifyData );

                    $tb_post_meta                 = array();
                    $tb_post_meta['first_name']   = $first_name;
                    $tb_post_meta['last_name']    = $last_name;
                    update_post_meta($post_id, 'tb_post_meta', $tb_post_meta);

                }

                $login_url    = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();

                //Send email to users & admin
                if (class_exists('Taskbot_Email_helper')) {
                    $blogname                       = get_option('blogname');
                    $emailData                      = array();
                    $emailData['name']              = $display_name;
                    $emailData['email']             = $email;
                    $emailData['verification_link'] = $verify_link;
                    $emailData['site']              = $blogname;
                    $emailData['login_url']         = $login_url;

                    //Welcome Email
                    if (class_exists('TaskbotRegistrationStatuses')) {
                        $email_helper = new TaskbotRegistrationStatuses();

                        if (!empty($verify_new_user) && $verify_new_user == 'verify_by_link') {
                            $email_helper->registration_user_email($emailData);
                        }else{
                            // to user
                            $email_helper->registration_account_approval_request($emailData);
                            // to admin
                            $email_helper->registration_verify_by_admin_email($emailData);
                        }

                        if ($taskbot_settings['email_admin_registration'] == true) {
                            $email_helper->registration_admin_email($emailData);
                        }
                    }
                }
            }
        }
	}
}

/**
 * @Rename Menu
 * @return {}
 */
if (!function_exists('taskbot_rename_admin_menus')) {
	add_action( 'admin_menu', 'taskbot_rename_admin_menus');
	function taskbot_rename_admin_menus() {
		global $menu,$submenu;
		foreach( $menu as $key => $menu_item ) {
			if( $menu_item[2] == 'edit.php?post_type=sellers' ){
				$menu[$key][0] = esc_html__('Taskbot','taskbot');
			}
		}
        
        $fw_active_extensions   = get_option( 'fw_active_extensions' );
        $backups_demo           = !empty($fw_active_extensions) && isset($fw_active_extensions['backups-demo']) ? true : false;
        
        if( !empty($backups_demo) ){
            add_submenu_page(
                'edit.php?post_type=sellers', 
                esc_html__('Demo content install','taskbot'), 
                esc_html__('Demo content install','taskbot'), 
                'manage_options', 
                'tools.php?page=fw-backups-demo-content'
            );
        }

        add_submenu_page(
            'edit.php?post_type=sellers', 
            esc_html__('Import user','taskbot'), 
            esc_html__('Import user','taskbot'), 
            'manage_options', 
            'import_users',
            'taskbot_import_users_template'
        );
        
    }
}

/**
 * @Show product adds
 * @type create
 */
if (!function_exists('taskbot_product_ads_content')) {
	function taskbot_product_ads_content(){
        global $taskbot_settings;
        $adds_contents  = !empty($taskbot_settings['ads_content']) ? $taskbot_settings['ads_content'] : '';
        if( !empty($adds_contents) ){ 
            ob_start();
        ?>
            <div class="tk-sidebarad"><?php echo do_shortcode( $adds_contents );?></div>
       <?php 
            echo ob_get_clean();
        }
	}
	add_action( "taskbot_product_ads_content", "taskbot_product_ads_content" );
}
/**
 * View verification details
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'taskbot_view_identity_detail' ) ) {
	function taskbot_view_identity_detail(){
		$json       = array();  
		$user_id    = !empty($_POST['user_id']) ? intval( $_POST['user_id'] ) : '';
		
		//security check
		$do_check = check_ajax_referer('ajax_nonce', 'security', false);
		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it again', 'taskbot');
			wp_send_json( $json );
		}
		
		$verification  = get_user_meta($user_id, 'verification_attachments', true);
		
		if(empty($verification)){
			$json['type']	= 'error';
			$json['message']	= esc_html__('No verification user details found','taskbot' );
			wp_send_json($json);
		}
		
		$user_info	= !empty($verification['info']) ? $verification['info'] : array();
		$required = array(
			'name'   				=> esc_html__('Name', 'taskbot'),
			'contact_number'  		=> esc_html__('Contact number', 'taskbot'),
			'verification_number'   => esc_html__('Verification number', 'taskbot'),
			'address'   			=> esc_html__('Address', 'taskbot'),
		);

		if( !empty($verification['info'] ) ) {
			unset( $verification['info'] );
		}

		ob_start();
		?>
		<div class="cus-modal-bodywrap">
			<div class="cus-form cus-form-change-settings">
				<div class="edit-type-wrap">
					<?php if(!empty($user_info)){
						foreach($user_info as $key => $item){
							if(!empty($required[$key])){
						?>
						<div class="cus-options-data">
							<label><span><strong><?php echo esc_html( $required[$key] );?></strong></span></label>
							<div class="step-value">
								<span><?php echo esc_html( $item );?></span>
							</div>
						</div>
					<?php }}}?>
					
					<?php if(!empty($verification)){
						foreach($verification as $key => $item){
						?>
						<div class="cus-options-data cus-options-files">
							<div class="step-value">
								<span><a target="_blank" href="<?php echo esc_attr( $item['url'] );?>"><?php echo esc_attr( $item['name'] );?></a></span>
							</div>
						</div>
					<?php }}?>
				</div>
			</div>
		</div>
		<?php
		
		$data	= ob_get_clean();
		$json['type']	= 'success';
		$json['html']	= $data;
		$json['message']	= esc_html__('Verification user details','taskbot' );
		wp_send_json($json);
	}
	add_action('wp_ajax_taskbot_view_identity_detail', 'taskbot_view_identity_detail');	
}

/**
 * Author social accounts
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists('taskbot_user_social_fields')){
	function taskbot_user_social_fields($user_fields) {
		$user_fields['twitter'] 	= esc_html__('Twitter', 'taskbot');
		$user_fields['facebook'] 	= esc_html__('Facebook', 'taskbot');
		$user_fields['instagram'] 	= esc_html__('Instagram', 'taskbot');
		$user_fields['pinterest'] 	= esc_html__('Pinterest', 'taskbot');
		$user_fields['linkedin'] 	= esc_html__('Linkedin', 'taskbot');

		return $user_fields;
	}
	add_filter('user_contactmethods', 'taskbot_user_social_fields');
}

/**
 * custom select list
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists('taskbot_custom_dropdown_html')){
    function taskbot_custom_dropdown_html($list=array(),$name='',$class_name="",$selected_item='',$placeholderinput='') {
        ob_start();
        ?>
        <select id="tk_project_type" class="tb-select-cat <?php echo esc_attr($class_name);?>" name="<?php echo esc_attr($name);?>" >
            <option value="" selected hidden disabled><?php echo esc_attr($placeholderinput); ?></option>
            <?php if (!empty($list)) {
                foreach ($list as $key => $item) {
                    $selected = '';                        
                    if (!empty($selected_item) && $selected_item === $key) {
                        $selected = 'selected';
                    } 
                ?>
                    <option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
                <?php }
            } ?>
        </select>
        <?php
        echo ob_get_clean();
    }
    add_action( "taskbot_custom_dropdown_html", "taskbot_custom_dropdown_html",10,5);
}

/**
 * custom term tags
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists('taskbot_term_tags_html')){
    function taskbot_term_tags_html($post_id=0,$taxnomy_name='',$title='',$type='') {
        global $product;
        if( !empty($post_id) ){
            $terms = !empty($post_id) ? wp_get_post_terms( $post_id, $taxnomy_name ) : array();
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                ob_start();
                ?>
                <div class="tk-project-holder">
                    <?php if( !empty($title) ){?>
                        <div class="tk-project-title">
                            <h4><?php echo esc_html($title);?></h4>
                        </div>
                    <?php } ?>
                    <div class="tk-blogtags tk-skillstags">
                        <ul class="tk-tags_links">
                            <?php foreach ( $terms as $term ) {
                                
                                $task_search_url    = '#';
                                if(is_singular('product')){
                                    $type   = !empty( $product->get_type() ) ? $product->get_type() : '';

                                    if( !empty($type) && $type == 'projects' ){
                                        $task_search_url    = taskbot_get_page_uri('project_search_page');
                                    }
                                    
                                    if(!empty($task_search_url)) {
                                        $task_search_url = add_query_arg('skills[]', esc_attr($term->slug), $task_search_url);
                                    }
                                }
                                ?>
                                <li>
                                    <a href="<?php echo esc_attr($task_search_url);?>"><span class="tk-blog-tags"><?php echo esc_html($term->name);?></span></a>
                                </li>		
                            <?php } ?>									
                        </ul>
                    </div>
                </div>
                <?php
                echo ob_get_clean();
            }
        }
    }
    add_action( "taskbot_term_tags_html", "taskbot_term_tags_html",10,4);
}

/**
 * user verification tag
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists('taskbot_verification_tag_html')){
    function taskbot_verification_tag_html($post_id=0) {
        if( !empty($post_id) ){
            $is_verified    	= !empty($post_id) ? get_post_meta( $post_id, '_is_verified',true) : '';
            if ( ! empty( $is_verified ) && $is_verified === 'yes'  ) {
                ob_start();
                ?>
                <i class="tb-icon-check-circle" <?php echo apply_filters('taskbot_tooltip_attributes', 'verified_user');?>></i>
                <?php
                echo ob_get_clean();
            }
        }
    }
    add_action( "taskbot_verification_tag_html", "taskbot_verification_tag_html",10,4);
}


/**
 * Skills
 */
if (!function_exists('taskbot_skills_filter_theme')) {
    function taskbot_skills_filter_theme($skills = array())
    {
        $taxonomies = get_terms( array(
            'taxonomy' => 'skills',
            'hide_empty' => false
        ) );
         
        if ( !empty($taxonomies) ) :            
            $output = '<div class="tk-aside-holder">';
                $output .= '<div class="tk-asidetitle collapsed" data-bs-toggle="collapse" data-bs-target="#skills-search" role="button" aria-expanded="false">';
                    $output .= '<h5>'.esc_html__('Skills', 'taskbot').'</h5>';
                $output .= '</div>';
                $output .= '<div id="skills-search" class="collapse">';
                    $output .= '<div class="tk-filterselect" id="project_skill_search">';
                        $output .= '<ul class="tk-categoriesfilter tk-skillstermsfilter">';
                        foreach( $taxonomies as $category ) {
                            if( $category->parent == 0 ) {
                                $checked    = '';
                                if(!empty($skills) && is_array($skills) && in_array($category->slug, $skills)){
                                    $checked    = 'checked';
                                }
                                $output.= '<li><div class="tk-form-checkbox">';
                                    $output.= '<input class="form-check-input tk-form-check-input-sm" id="term_'. intval( $category->term_id ) .'" type="checkbox" name="skills[]" value="'. esc_attr( $category->slug ) .'" '.do_shortcode($checked).'><label class="form-check-label" for="term_'. intval( $category->term_id ) .'"><span>'. esc_html( $category->name ) .'</span></label>';
                                $output.='</div></li>';
                            }
                        }
                        $output.='</ul>';

                        if(count($taxonomies)>5){
                            $output.='<div class="show-more"> <a href="javascript:void(0);" class="tb-readmorebtn tb-show_more" data-show_more="'.esc_attr__('Show More', 'taskbot').'" data-show_less="'.esc_attr__('Show less', 'taskbot').'">'.esc_attr__('Show More', 'taskbot').'</a></div>';
                        }
                    $output.='</div>';
                $output.='</div>';
            $output.='</div>';
            echo do_shortcode($output);
        endif;
    }
    add_action('taskbot_skills_filter_theme', 'taskbot_skills_filter_theme', 10, 1);
}

/**
 * Product tags
 */
if (!function_exists('taskbot_product_tags_filter_theme')) {
    function taskbot_product_tags_filter_theme($product_tag = array())
    {
        $taxonomies = get_terms( array(
            'taxonomy'      => 'product_tag',
            'hide_empty'    => false
        ) );
        
        if ( !empty($taxonomies) ) :            
            $output = '<div class="tk-aside-holder">';
                $output .= '<div class="tk-asidetitle collapsed" data-bs-toggle="collapse" data-bs-target="#product_tag-search" role="button" aria-expanded="false">';
                    $output .= '<h5>'.esc_html__('Tags', 'taskbot').'</h5>';
                $output .= '</div>';
                $output .= '<div id="product_tag-search" class="collapse">';
                    $output .= '<div class="tk-filterselect" id="project_skill_search">';
                        $output .= '<ul class="tk-categoriesfilter tk-skillstermsfilter">';
                        foreach( $taxonomies as $category ) {
                            if( $category->parent == 0 ) {
                                $checked    = '';
                                if(!empty($product_tag) && is_array($product_tag) && in_array($category->slug, $product_tag)){
                                    $checked    = 'checked';
                                }
                                $output.= '<li><div class="tk-form-checkbox">';
                                    $output.= '<input class="form-check-input tk-form-check-input-sm" id="term_'. intval( $category->term_id ) .'" type="checkbox" name="product_tag[]" value="'. esc_attr( $category->slug ) .'" '.do_shortcode($checked).'><label class="form-check-label" for="term_'. intval( $category->term_id ) .'"><span>'. esc_html( $category->name ) .'</span></label>';
                                $output.='</div></li>';
                            }
                        }
                        $output.='</ul>';

                        if(count($taxonomies)>5){
                            $output.='<div class="show-more"> <a href="javascript:void(0);" class="tb-readmorebtn tb-show_more" data-show_more="'.esc_attr__('Show More', 'taskbot').'" data-show_less="'.esc_attr__('Show less', 'taskbot').'">'.esc_attr__('Show More', 'taskbot').'</a></div>';
                        }
                    $output.='</div>';
                $output.='</div>';
            $output.='</div>';
            echo do_shortcode($output);
        endif;
    }
    add_action('taskbot_product_tags_filter_theme', 'taskbot_product_tags_filter_theme', 10, 1);
}

/**
 * Expertise level
 */
if (!function_exists('taskbot_expertise_level_filter_theme')) {
    function taskbot_expertise_level_filter_theme($expertise_level = array())
    {
        $taxonomies = get_terms( array(
            'taxonomy' => 'expertise_level',
            'hide_empty' => false
        ) );
         
        if ( !empty($taxonomies) ) :            
            $output = '<div class="tk-aside-holder">';
                $output .= '<div class="tk-asidetitle collapsed" data-bs-toggle="collapse" data-bs-target="#expertise-search" role="button" aria-expanded="false">';
                    $output .= '<h5>'.esc_html__('Expertise level', 'taskbot').'</h5>';
                $output .= '</div>';
                $output .= '<div id="expertise-search" class="collapse">';
                    $output .= '<div class="tk-filterselect" id="project_expertise_level_search">';
                        $output .= '<ul class="tk-categoriesfilter tk-expertisetermsfilter">';
                        foreach( $taxonomies as $category ) {
                            if( $category->parent == 0 ) {
                                $checked    = '';
                                if(!empty($expertise_level) && is_array($expertise_level) && in_array($category->slug, $expertise_level)){
                                    $checked    = 'checked';
                                }
                                $output.= '<li><div class="tk-form-checkbox">';
                                $output.= '<input class="form-check-input tk-form-check-input-sm" id="term_'. intval( $category->term_id ) .'" type="checkbox" name="expertise_level[]" value="'. esc_attr( $category->slug ) .'" '.do_shortcode($checked).'><label class="form-check-label" for="term_'. intval( $category->term_id ) .'"><span>'. esc_html( $category->name ) .'</span></label>';
                                $output.='</div></li>';
                            }
                        }
                        $output.='</ul>';
                        
                        if(count($taxonomies)>5){
                            $output.='<div class="show-more"> <a href="javascript:void(0);" class="tb-readmorebtn tb-show_more" data-show_more="'.esc_html__('Show More', 'taskbot').'" data-show_less="'.esc_html__('Show less', 'taskbot').'">'.esc_html__('Show More', 'taskbot').'</a></div>';
                        }
                    $output.='</div>';
                $output.='</div>';
            $output.='</div>';
            echo do_shortcode($output);
        endif;
    }
    add_action('taskbot_expertise_level_filter_theme', 'taskbot_expertise_level_filter_theme', 10, 1);
}

/**
 * Languages
 */
if (!function_exists('taskbot_languages_filter_theme')) {
    function taskbot_languages_filter_theme($languages = array())
    {
        $taxonomies = get_terms( array(
            'taxonomy' => 'languages',
            'hide_empty' => false
        ) );
         
        if ( !empty($taxonomies) ) :            
            $output = '<div class="tk-aside-holder">';
                $output .= '<div class="tk-asidetitle collapsed" data-bs-toggle="collapse" data-bs-target="#languages-search" role="button" aria-expanded="false">';
                    $output .= '<h5>'.esc_html__('Languages', 'taskbot').'</h5>';
                $output .= '</div>';
                $output .= '<div id="languages-search" class="collapse">';
                    $output .= '<div class="tk-filterselect" id="project_languages_search">';
                        $output .= '<ul class="tk-categoriesfilter tk-languagetermsfilter">';
                        foreach( $taxonomies as $category ) {
                            if( $category->parent == 0 ) {
                                $checked    = '';
                                if(!empty($languages) && is_array($languages) && in_array($category->slug, $languages)){
                                    $checked    = 'checked';
                                }
                                $output.= '<li><div class="tk-form-checkbox">';
                                $output.= '<input class="form-check-input tk-form-check-input-sm" id="term_'. intval( $category->term_id ) .'" type="checkbox" name="languages[]" value="'. esc_attr( $category->slug ) .'" '.do_shortcode($checked).'><label class="form-check-label" for="term_'. intval( $category->term_id ) .'"><span>'. esc_html( $category->name ) .'</span></label>';
                                $output.='</div></li>';
                            }
                        }                        
                        $output.='</ul>';
                        
                        if(count($taxonomies)>5){
                            $output.='<div class="show-more"> <a href="javascript:void(0);" class="tb-readmorebtn tb-show_more" data-show_more="'.esc_html__('Show More', 'taskbot').'" data-show_less="'.esc_html__('Show less', 'taskbot').'">'.esc_html__('Show More', 'taskbot').'</a></div>';
                        }
                    $output.='</div>';
                $output.='</div>';
            $output.='</div>';
            echo do_shortcode($output);
        endif;
    }
    add_action('taskbot_languages_filter_theme', 'taskbot_languages_filter_theme', 10, 1);
}

/**
 * Tooltip tags
 */
if (!function_exists('taskbot_tooltip_tags')) {
    function taskbot_tooltip_tags($title='', $content="")
    {
        $timestamp  = mt_rand();
        ob_start();
        if(!empty($title)){
            ?>
            <a id="tb-tooltip<?php echo esc_attr($timestamp);?>" href="javascript:void(0);"  data-tippy-trigger="click" data-template="tb-services_content<?php echo esc_attr($timestamp);?>" data-tippy-interactive="true" data-tippy-placement="top-start"> <?php echo do_shortcode($title);?></a>
            <?php
        }

        if(!empty($content)){
            ?>
            <div id="tb-services_content<?php echo esc_attr($timestamp);?>" class="tb-tippytooltip d-none">
                <div class="tb-selecttagtippy tb-tooltip ">
                    <?php if(is_array($content) && count($content)>0){
                        ?>
                        <ul class="tb-posttag tb-posttagv2">
                            <?php foreach($content as $content_item){?>
                                <li>
                                    <a href="javascript:void(0);"><?php echo do_shortcode($content_item);?></a>
                                </li>
                            <?php }?>
                        </ul>
                        <?php
                    } else {
                        echo do_shortcode($content);
                    }?>
                   
                </div>
            </div>
            <?php
            $script = 'tooltipTagsInit("#tb-tooltip'.esc_attr($timestamp).'")';
            wp_add_inline_script( 'taskbot', $script, 'after' );
        }
        echo ob_get_clean();

    }
    add_action('taskbot_tooltip_tags', 'taskbot_tooltip_tags', 10, 2);
}

/**
 * Tooltip
 */
if (!function_exists('taskbot_tooltip')) {
    function taskbot_tooltip($title='', $key="",$content='')
    {
        if(!empty($key) || !empty($content)){
            $timestamp      = mt_rand();
            $content        = !empty($key) ? taskbot_tooltip_array($key) : $content;
            if(!empty($title)){
                ob_start();
                ?>
                <span class="tb-tooltip-data" id="tb-tooltip<?php echo esc_attr($key.$timestamp);?>"  href="javascript:void(0);"  data-template="tb-services_content<?php echo esc_attr($timestamp);?>" data-tippy-interactive="true" data-tippy-placement="top-start" data-tippy-content="<?php echo do_shortcode($content);?>"> <?php echo do_shortcode($title);?></span>
                <?php
                echo ob_get_clean();
            }
        }
    }
    add_action('taskbot_tooltip', 'taskbot_tooltip', 10, 3);
}


/**
 * search type
 * @return slug
 */
if (!function_exists('taskbot_tooltip_array')) {
	function taskbot_tooltip_array($key=''){
		$list	= array(
			'verified_user'		=> esc_html__('Verified user','taskbot'),
            'online_user'		=> esc_html__('Online','taskbot'),
            'offline_user'		=> esc_html__('Offline','taskbot'),
            'featured_package'	=> esc_html__('Featured package','taskbot'),
            'featured_project'	=> esc_html__('Featured project','taskbot'),
            'featured_task'	    => esc_html__('Featured task','taskbot'),
		);
		$list	= apply_filters('taskbot_filter_tooltip_array', $list );
		if(!empty($key)){
			$list	= !empty($list[$key]) ? $list[$key] : '';
		}
		return $list;
	}    
}

/**
 * Safe logout
 * @return slug
 */
if (!function_exists('taskbot_logout_redirect')) {
    add_action('wp_logout','taskbot_logout_redirect',5);
    function taskbot_logout_redirect(){
        wp_safe_redirect( home_url() );
        exit();
    }
}

/**
 * search type
 * @return slug
 */
if (!function_exists('taskbot_tooltip_html')) {
	function taskbot_tooltip_html($key=''){
        if(!empty($key)){
            $label			= taskbot_tooltip_array($key);
            if(!empty($key)){
                $timestamp      = mt_rand();
                $datattribute	= 'data-class="tb-tooltip-data" id="tb-tooltip'.$timestamp.'" data-tippy-interactive="true" data-tippy-placement="top-start" data-tippy-content="'.esc_attr($label).'"';
                return $datattribute;
            }
        }
	} 
    
    add_filter('taskbot_tooltip_attributes', 'taskbot_tooltip_html');
}


/**
 * List task v2
 */
if (!function_exists('taskbot_listing_task_html_v2')) {
    function taskbot_listing_task_html_v2($product_id=0)
    {
        if(!empty($product_id)){
            $product            = wc_get_product($product_id);
            $product_author_id  = get_post_field ('post_author', $product->get_id());
            $linked_profile_id  = get_user_meta($product_author_id, '_linked_profile', true);
            $post_country       = get_post_meta( $product->get_id(), '_country', true );
            $user_name          = taskbot_get_username($linked_profile_id);
            $verified_user      = get_post_meta( $linked_profile_id, '_is_verified', true);
            $verified_user      = !empty($verified_user) ? $verified_user : '';
            $image              = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'taskbot_task_shortcode_thumbnail' );
            $product_rating     = !empty($product) ? $product->get_average_rating() : 0;
            $address            = apply_filters( 'taskbot_user_address', $linked_profile_id );
            ob_start();
            ?>
            <div class="tk-topservice">
                <?php if(!empty($image[0])){?>
                    <figure class="tk-card__img">
                        <a href="<?php the_permalink();?>">
                            <img src="<?php echo esc_url($image[0])?>" alt="<?php echo esc_attr($product->get_name()); ?>">
                            <i class="tb-icon-plus"></i>
                        </a>
                    </figure>
                    <?php do_action('taskbot_service_featured_item_theme', $product);?>
                <?php } ?>
                <div class="tk-sevicesinfo">
                    <div class="tk-topservice__content">
                        <div class="tk-title-wrapper">
                            <div class="tk-card-title">
                                <?php if(!empty($user_name)) {?>
                                    <a href="<?php echo get_the_permalink($linked_profile_id); ?>"><?php echo esc_html($user_name);?></a>
                                    <?php } ?>
                                    <?php do_action( 'taskbot_verification_tag_html', $linked_profile_id ); ?>
                                    <?php do_action( 'taskbot_saved_item_theme', $product->get_id(),'','_saved_tasks' ); ?>
                            </div>
                            <?php if( $product->get_name() ){?>
                                <h5><a href="<?php the_permalink();?>"><?php echo esc_html($product->get_name()); ?></a></h5>
                            <?php } ?>
                        </div>
                        <div class="tk-featureRating">
                            <?php do_action('taskbot_service_rating_count_theme_v2', $product); ?>
                            <?php if( !empty($address) ){?>
                                <address>
                                    <i class="tb-icon-map-pin"></i><?php echo esc_html($address) ?>
                                </address>
                            <?php } ?>
                        </div>
                        <?php do_action('taskbot_service_item_starting_price_theme', $product); ?>
                    </div>
                </div>
            </div>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_listing_task_html_v2', 'taskbot_listing_task_html_v2');
}

/**
 * List task v2
 */
if (!function_exists('taskbot_listing_task_html_v1')) {
    function taskbot_listing_task_html_v1($product_id=0)
    {
        if(!empty($product_id)){
            $product            = wc_get_product($product_id);
            $product_author_id  = get_post_field ('post_author', $product->get_id());
            $linked_profile_id  = taskbot_get_linked_profile_id($product_author_id, '','sellers');
            $user_name          = taskbot_get_username($linked_profile_id);
            ob_start();
            ?>
                <div class="tk-bestservice">
                    <?php
                        do_action('taskbot_task_gallery_theme', $product);
                        do_action('taskbot_service_featured_item_theme', $product);
                        do_action('taskbot_service_gallery_count', $product);
                    ?>
                    <div class="tk-sevicesinfo">
                        <div class="tk-bestservice__content">
                            <?php do_action( 'taskbot_profile_image_theme', $linked_profile_id );?>
                            <div class="tk-cardtitle">
                                <?php
                                    do_action( 'taskbot_saved_item_theme', $product->get_id(),'','_saved_tasks' );

                                    if( !empty($user_name) ){?>
                                    <a href="<?php echo get_the_permalink($linked_profile_id); ?>"><?php echo esc_html($user_name); ?></a>
                                <?php } ?>
                                <h5><a href="<?php the_permalink();?>"><?php echo esc_html($product->get_name()); ?></a></h5>
                            </div>
                            <ul class="tk-blogviewdates tk-blogviewdatessm">
                                <?php
                                    do_action('taskbot_service_rating_count_theme', $product);
                                    do_action('taskbot_service_item_views_theme', $product);
                                ?>
                            </ul>
                            <?php do_action('taskbot_service_item_starting_price_theme', $product); ?>
                        </div>
                    </div>
                </div>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_listing_task_html_v1', 'taskbot_listing_task_html_v1');
}

/**
 * Seller hourly rate
 */
if (!function_exists('taskbot_seller_hourly_rate_html')) {
    function taskbot_seller_hourly_rate_html($post_id=0)
    {
        if(!empty($post_id)){
            $tb_hourly_rate     = get_post_meta($post_id, 'tb_hourly_rate', true);
            $tb_hourly_rate     = isset($tb_hourly_rate) ? $tb_hourly_rate : 0;
            ob_start();
            ?>
                <div class="tb-sidebarcontent">
                    <div class="tb-sidebarinnertitle">
                        <h6><?php esc_html_e('Starting from:','taskbot');?></h6>
                        <h5><?php echo sprintf(esc_html__('%s /hr','taskbot'),taskbot_price_format($tb_hourly_rate,'return'));?></h5>
                    </div>
                </div>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_seller_hourly_rate_html', 'taskbot_seller_hourly_rate_html');
}


/**
 * Project grid view
 */
if (!function_exists('taskbot_project_grid_view')) {
    function taskbot_project_grid_view($product=array())
    {
        if( !empty($product) ){
            $product_author_id  = get_post_field ('post_author', $product->get_id());
            $linked_profile_id  = taskbot_get_linked_profile_id($product_author_id, '','buyers');
            $user_name          = taskbot_get_username($linked_profile_id);
            $is_verified    	= !empty($linked_profile_id) ? get_post_meta( $linked_profile_id, '_is_verified',true) : '';
            $project_price      = taskbot_project_price($product->get_id());
            $project_meta       = get_post_meta( $product->get_id(), 'tb_project_meta',true );
            $project_meta       = !empty($project_meta) ? $project_meta : array();
            $project_type       = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
            ob_start();
            ?>
                <div class="tk-project-wrapper tk-otherproject">
                    <?php do_action( 'taskbot_featured_item', $product,'featured_project' );?>
                    <div class="tk-project-box">
                        <div class="tk-verified-info">
                            <strong>
                                <?php echo esc_html($user_name);?>
                                <?php do_action( 'taskbot_verification_tag_html', $linked_profile_id ); ?>
                            </strong>
                            <?php if($product->get_name()){?>
                                <h5><a href="<?php the_permalink();?>"><?php echo esc_html($product->get_name());?></a></h5>
                            <?php } ?>
                        </div>
                        <ul class="tk-blogviewdates tk-projectinfo-list">
                            <?php do_action( 'taskbot_posted_date_html', $product );?>
    						<?php do_action( 'taskbot_location_html', $product );?>
                            <?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','tb-icon-briefcase' );?>
                            <?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
                        </ul>
                        <div class="tk-project-price tk-project-price-two">
                            <?php if( !empty($project_type) ){?>
                                <?php do_action( 'taskbot_project_type_text', $project_type );?>
                            <?php } ?>
                            <?php if( isset($project_price) ){?>
                                <h4><?php echo do_shortcode($project_price);?></h4>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_project_grid_view', 'taskbot_project_grid_view');
}