<?php
/**
 * Shortcode
 *
 *
 * @package    Taskup
 * @subpackage Taskup/admin
 * @author     Amentotech <theamentotech@gmail.com>
 */

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Taskup_lastest_post')) {
    class Taskup_lastest_post extends Widget_Base
    {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskbot_element_latest_post';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Latest post', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon()
        {
            return 'eicon-posts-grid';
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      category of shortcode
         */
        public function get_categories()
        {
            return ['taskbot-elements'];
        }

        /**
         * Register category controls.
         * @since    1.0.0
         * @access   protected
         */
        protected function register_controls()
        {
            $post_categories = array();
            if( function_exists('taskbot_elementor_get_taxonomies') ){
                $post_categories = taskbot_elementor_get_taxonomies();
            }
            $post_categories = !empty($post_categories) ? $post_categories : array();

            //Content
            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__('Content', 'taskbot'),
                    'tab'   => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'layout',
                [
                    'type'      => Controls_Manager::SELECT,
                    'label'     => esc_html__('Layout', 'taskbot'),
                    'desc'      => esc_html__('Select layout', 'taskbot'),
                    'default'   => 'v2',
                    'options'   => [
                        'v1'   => esc_html__('Layout v1', 'taskbot'),
                        'v2'  => esc_html__('Layout v2', 'taskbot'),
                    ],
                ]
            );

            $this->add_control(
                'sub_title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Section sub title', 'taskbot'),
                    'description'   => esc_html__('Add text. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Section title', 'taskbot'),
                    'description'   => esc_html__('Add text. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'separator',
                [
                    'type'          => Controls_Manager::SWITCHER,
                    'label'         => esc_html__('Separator', 'taskbot'),
                    'label_on'      => esc_html__( 'Show', 'taskbot' ),
                    'label_off'     => esc_html__( 'Hide', 'taskbot' ),
                    'return_value'  => 'yes',
                    'selectors' => [
                        '{{WRAPPER}} .tk-maintitle:after' => 'content: "";',
                    ],
                    'prefix_class' => 'tk-title-separator-',
                    'condition' => [
                        'title!' => ' ',
                    ],
                ]
            );

            $this->add_control(
                'details',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Add details', 'taskbot'),
                    'description'   => esc_html__('Add text. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'post_categories',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Categories', 'taskbot'),
                    'desc'          => esc_html__('Select categories.', 'taskbot'),
                    'options'       => $post_categories,
                    'multiple'      => true,
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'no_post_show',
                [
                    'type'      => Controls_Manager::NUMBER,
                    'label'     => esc_html__('No. of post', 'taskbot'),
                    'desc'      => esc_html__('Select no of posts to display.', 'taskbot'),
                    'min'       => 1,
                    'max'       => 500,
                    'step'      => 1,
                    'default'   => 3,
                ]
            );

            $this->add_control(
                'order_by',
                [
                    'type'      => Controls_Manager::SELECT,
                    'label'     => esc_html__('Order by', 'taskbot'),
                    'desc'      => esc_html__('Show latest posts', 'taskbot'),
                    'default'   => 'ASC',
                    'options'   => [
                        'ASC'   => esc_html__('Assending', 'taskbot'),
                        'DESC'  => esc_html__('Decending', 'taskbot'),
                        'rand'  => esc_html__('Random', 'taskbot'),
                    ],
                ]
            );


            $this->add_control(
                'column',
                [
                    'type'      => Controls_Manager::SELECT,
                    'label'     => esc_html__('Columns', 'taskbot'),
                    'desc'      => esc_html__('Select column', 'taskbot'),
                    'default'   => '4',
                    'options'   => [
                        '4'   => esc_html__('3 column', 'taskbot'),
                        '6'   => esc_html__('2 column', 'taskbot'),
                    ],
                ]
            );

            $this->end_controls_section();
        }

        /**
         * Render shortcode
         *
         * @since 1.0.0
         * @access protected
         */
        protected function render()
        {
            global $paged;
            $settings           = $this->get_settings_for_display();
            $title              = !empty($settings['title']) ? $settings['title'] : '';
            $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $details            = !empty($settings['details']) ? $settings['details'] : '';
            $no_post_show       = !empty($settings['no_post_show']) ? $settings['no_post_show'] : 3;
            $order_by           = !empty($settings['order_by']) ? $settings['order_by'] : '';
            $layout             = !empty($settings['layout']) ? $settings['layout'] : 'v2';
            $column             = !empty($settings['column']) ? $settings['column'] : '4';

            $post_category_ids  = !empty($settings['post_categories']) ? $settings['post_categories'] : array();
            $show_pagination    = !empty($settings['show_pagination']) ? $settings['show_pagination'] : '';
            $pg_page            = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged           = get_query_var('paged') ? get_query_var('paged') : 1;
            $paged              = max($pg_page, $pg_paged);
            $args               = array();

            if (is_array($post_category_ids) && !empty($post_category_ids)) {
                $args = array(
                    'post_type'         => 'post',
                    'paged'             => $paged,
                    'posts_per_page'    => $no_post_show,
                    'order'             => $order_by,
                    'orderby'           => 'title',
                    'category__in'      => $post_category_ids
                );
            } else {
                $args = array(
                    'post_type'         => 'post',
                    'paged'             => $paged,
                    'posts_per_page'    => $no_post_show,
                    'order'             => $order_by,
                    'orderby'           => 'title'
                );
            }

            $all_posts      = new \WP_Query(apply_filters('taskup_latest_post_args', $args));
            $total_posts    = $all_posts->found_posts;
            if ( !empty($title) || !empty($all_posts) ) {?>
                <div class="tk-articles-posts tk-layout-<?php echo esc_html($layout)?>">
                    <div class="container">
                        <?php if (!empty($title) || !empty($sub_title) || !empty($details) ) { ?>
                            <div class="row">
                                <div class="col-lg-10 col-xl-8">
                                    <div class="tk-main-title-holder">
                                        <?php if(!empty($title) || !empty($sub_title) ){?>
                                            <div class="tk-maintitle">
                                                <?php do_action( 'taskbot_section_shaper_html' );?>
                                                <?php if(!empty($sub_title)){?>
                                                    <h3><?php echo esc_html($sub_title)?></h3>
                                                <?php } ?>
                                                <?php if($title){?>
                                                    <h2><?php echo esc_html($title)?></h2>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <?php if( !empty($details) ){?>
                                            <div class="tk-main-description">
                                                <p><?php echo esc_html( $details );?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($all_posts) && !empty($layout) && $layout == 'v1' ) { ?>
                            <div class="row gy-4">
                                <?php
                                    if ($all_posts->have_posts()) {
                                        while ($all_posts->have_posts()) {
                                            $all_posts->the_post();
                                            global $post;
                                            $post_title         = get_the_title($post->ID);
                                            $image_id           = get_post_thumbnail_id($post->ID);
                                            $post_img_url       = array();
                                            if( function_exists('taskbot_prepare_image_source') ){
                                                $post_img_url   = taskbot_prepare_image_source($image_id, 625, 455);
                                            }
                                            $post_url           = !empty($post->ID) ? get_the_permalink($post->ID) : '';
                                            $post_date_month    = date_i18n('M', strtotime(get_the_date()));
                                            $post_date_date     = date_i18n('d', strtotime(get_the_date()));
                                            $comments_count     = !empty($post->comment_count) ? intval($post->comment_count) : 0;
                                            $avatar	            = !empty($post->post_author) ? get_avatar_url($post->post_author,array('size' => 50)) : '';
                                            $author_name        = !empty($post->post_author) ? get_the_author_meta( 'nickname', $post->post_author ) : '';
                                            $author_url         = !empty($post->post_author) ? get_author_posts_url($post->post_author) : '';
                                            ?>
                                            
                                            <?php if (!empty($post_title) || !empty($post_img_url) || !empty($post_url) || !empty($contents)) { ?>
                                                <div class="col-md-6 col-xl-<?php echo esc_attr($column);?>">
                                                    <div class="tk-blog-main">
                                                        <?php if (!empty($post_img_url) && !empty($post_title)) { ?>
                                                            <figure class="tk-blog-image">
                                                                <a href="<?php echo esc_url($post_url); ?>">
                                                                    <img src="<?php echo esc_url($post_img_url); ?>" alt="<?php echo esc_attr($post_title); ?> ">
                                                                </a>
                                                                <span class="date-and-month">
                                                                    <?php echo esc_attr($post_date_month)?><em><?php echo esc_attr($post_date_date)?></em></span>
                                                            </figure>
                                                        <?php } ?>
                                                        <div class="tk-blogs-section">
                                                            <?php echo get_the_term_list($post->ID, 'category', '<ul class="tk-tags"><li>', '</li><li>', '</li></ul>'); ?>
                                                            <?php if (!empty($post_title)) { ?>
                                                                <h4>
                                                                    <a href="<?php echo esc_url($post_url); ?>"><?php echo esc_html($post_title); ?></a>
                                                                </h4>
                                                            <?php } ?>
                                                            <?php if( !empty($avatar) || !empty($author_name) ){?>
                                                                <div class="tk-author">
                                                                    <?php if( !empty($avatar) ){?>
                                                                        <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($author_name);?>">
                                                                    <?php } ?>
                                                                    <?php if(!empty($author_name) ){?>
                                                                        <a href="<?php echo esc_url($author_url);?>"><?php echo esc_html($author_name);?></a>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php 
                                            }
                                        }
                                        if( !empty($total_posts) && !empty($no_post_show) && $total_posts > $no_post_show && !empty($show_pagination) && $show_pagination === 'yes' && function_exists('taskbot_paginate')){
                                            taskbot_paginate($all_posts); 
                                        }
                                        wp_reset_postdata();
                                    } 
                                ?>
                            </div>
                        <?php }else{?>
                            <div class="row gy-4">
                                <?php
                                    if ($all_posts->have_posts()) {
                                        while ($all_posts->have_posts()) {
                                            $all_posts->the_post();
                                            global $post;
                                            $post_title         = get_the_title($post->ID);
                                            $image_id           = get_post_thumbnail_id($post->ID);
                                            $post_img_url       = array();
                                            if( function_exists('taskbot_prepare_image_source') ){
                                                $post_img_url   = taskbot_prepare_image_source($image_id, 625, 455);
                                            }

                                            $post_url           = !empty($post->ID) ? get_the_permalink($post->ID) : '';
                                            $contents           = !empty($post) ? get_the_excerpt($post) : '';
                                            $comments_count     = !empty($post->comment_count) ? intval($post->comment_count) : 0;
                                            ?>
                                            
                                            <?php if (!empty($post_title) || !empty($post_img_url) || !empty($post_url) || !empty($contents)) { ?>
                                                <div class="col-md-6 col-xl-<?php echo esc_attr($column);?>">
                                                    <div class="tk-blog-main">
                                                        <?php if (!empty($post_img_url) && !empty($post_title)) { ?>
                                                            <figure class="tk-blog-image">
                                                                <a href="<?php echo esc_url($post_url); ?>">
                                                                    <img src="<?php echo esc_url($post_img_url); ?>" alt="<?php echo esc_attr($post_title); ?> ">
                                                                </a>
                                                            </figure>
                                                        <?php } ?>
                                                        <div class="tk-blogs-section">
                                                            <?php echo get_the_term_list($post->ID, 'category', '<ul class="tk-tags"><li>', '</li><li>', '</li></ul>'); ?>
                                                            <?php if (!empty($post_title)) { ?>
                                                                <h4>
                                                                    <a href="<?php echo esc_url($post_url); ?>"><?php echo esc_html($post_title); ?></a>
                                                                </h4>
                                                            <?php } ?>
                                                            <?php if (!empty($contents)) { ?>
                                                                <p> <?php echo esc_html($contents); ?></p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php 
                                            }
                                        }
                                        if( !empty($total_posts) && !empty($no_post_show) && $total_posts > $no_post_show && !empty($show_pagination) && $show_pagination === 'yes' && function_exists('taskbot_paginate')){
                                            taskbot_paginate($all_posts); 
                                        }
                                        wp_reset_postdata();
                                    } 
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php 
            }
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskup_lastest_post);
}
