<?php
/**
 * Shortcode
 *
 *
 * @package    Taskbot
 * @subpackage Taskbot/admin
 * @author     Amentotech <theamentotech@gmail.com>
 */

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Taskbot_lastest_post')) {
    class Taskbot_lastest_post extends Widget_Base
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
            $post_categories = taskbot_elementor_get_taxonomies();
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
                'title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Section title', 'taskbot'),
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
                    'type'      => Controls_Manager::SELECT2,
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
                'show_pagination',
                [
                    'type'      => Controls_Manager::SELECT2,
                    'label'     => esc_html__('Show pagination', 'taskbot'),
                    'desc'      => esc_html__('Show pagination', 'taskbot'),
                    'default'   => 'no',
                    'options'   => [
                        'yes'   => esc_html__('Yes', 'taskbot'),
                        'no'  => esc_html__('No', 'taskbot'),
                    ],
                ]
            );

            $this->add_control(
                'column',
                [
                    'type'      => Controls_Manager::SELECT2,
                    'label'     => esc_html__('Columns', 'taskbot'),
                    'desc'      => esc_html__('Select column', 'taskbot'),
                    'default'   => 'no',
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
            $no_post_show       = !empty($settings['no_post_show']) ? $settings['no_post_show'] : 3;
            $order_by           = !empty($settings['order_by']) ? $settings['order_by'] : '';
            $post_category_ids  = !empty($settings['post_categories']) ? $settings['post_categories'] : array();
            $show_pagination    = !empty($settings['show_pagination']) ? $settings['show_pagination'] : '';
            $column             = !empty($settings['column']) ? $settings['column'] : 4;
            $pg_page            = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged           = get_query_var('paged') ? get_query_var('paged') : 1;
            $paged              = max($pg_page, $pg_paged);
            $args = array();
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

            $all_posts      = new \WP_Query(apply_filters('taskbot_latest_post_args', $args));
            $total_posts    = $all_posts->found_posts;
            if (!empty($title) || !empty($all_posts)) { ?>
                <div class="tk-latest-posts">
                    <div class="container">
                        <?php if (!empty($title)) { ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="tk-maintitle">
                                        <h2><?php echo esc_html($title); ?></h2>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($all_posts)) { ?>
                            <div class="row tk-blogs-main">
                                <?php
                                    if ($all_posts->have_posts()) {
                                        while ($all_posts->have_posts()) {
                                            $all_posts->the_post();
                                            global $post;
                                            $post_title         = get_the_title($post->ID);
                                            $image_id           = get_post_thumbnail_id($post->ID);
                                            $post_img_url       = taskbot_prepare_image_source($image_id, 625, 455);
                                            $post_url           = !empty($post->ID) ? get_the_permalink($post->ID) : '';
                                            $contents           = !empty($post) ? get_the_excerpt($post) : '';
                                            $term_list          = wp_get_post_terms($post->ID, 'category', array("fields" => "all"));

                                            if (strpos($post_img_url,'media/default.png') != false) {
                                                $post_img_url = '';
                                            }
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
                                                            <?php if (!empty($term_list)) { ?>
                                                                <ul class="tk-tags">
                                                                    <?php 
                                                                        foreach ($term_list as $term) {
                                                                            if (!empty($term->term_id)) {
                                                                                $category_link = get_category_link($term->term_id);
                                                                                ?>
                                                                                <li>
                                                                                    <h6>
                                                                                        <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($term->name); ?></a>
                                                                                    </h6>
                                                                                </li>
                                                                            <?php 
                                                                            }
                                                                        } 
                                                                    ?>
                                                                </ul>
                                                            <?php } ?>
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
                                        if( !empty($total_posts) && !empty($no_post_show) && $total_posts > $no_post_show && !empty($show_pagination) && $show_pagination === 'yes'){
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

    Plugin::instance()->widgets_manager->register(new Taskbot_lastest_post);
}
