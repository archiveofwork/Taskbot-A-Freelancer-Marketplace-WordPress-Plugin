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

    if (!class_exists('Taskbot_Search_Banner')) {
        class Taskbot_Search_Banner extends Widget_Base
        {
            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_search_banner';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Search form v1', 'taskbot');
            }

            /**
            *
            * @since    1.0.0
            * @access   public
            * @var      icon
            */
            public function get_icon()
            {
                return 'eicon-search-results';
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
                $pages      = taskbot_elementor_get_posts(array('page'));
                $pages      = !empty($pages) ? $pages : array();
                $categories = taskbot_elementor_get_taxonomies('product', 'product_cat');
                $categories = !empty($categories) ? $categories : array();

                //Content
                $this->start_controls_section(
                    'content_section',
                    [
                        'label'     => esc_html__('Content', 'taskbot'),
                        'tab'       => Controls_Manager::TAB_CONTENT,
                    ]
                );
                
                $this->add_control(
                    'title1',
                    [
                        'type'        => Controls_Manager::TEXTAREA,
                        'label'       => esc_html__('Title', 'taskbot'),
                        'description' => esc_html__('Add text, leave it empty to hide.', 'taskbot'),
                    ]
                );
                $this->add_control(
                    'title2',
                    [
                        'type'        => Controls_Manager::TEXTAREA,
                        'label'       => esc_html__('Sub title', 'taskbot'),
                        'description' => esc_html__('Add text, leave it empty to hide.', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'button_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Talent button text', 'taskbot'),
                        'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                    ]
                );
                $this->add_control(
                    'button_link',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Select page', 'taskbot'),
                        'desc'          => esc_html__('Select page for talent button URL.', 'taskbot'),
                        'options'       => $pages,
                        'multiple'      => false,
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'reg_button_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Work button text', 'taskbot'),
                        'description'   => esc_html__('Add Button text. leave it empty to hide.', 'taskbot'),
                    ]
                );
                $this->add_control(
                    'reg_button_link',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Select page', 'taskbot'),
                        'desc'          => esc_html__('Select page for registration button URL.', 'taskbot'),
                        'options'       => $pages,
                        'multiple'      => false,
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'product_categories',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Categories?', 'taskbot'),
                        'desc'          => esc_html__('Select categories to display.', 'taskbot'),
                        'options'       => $categories,
                        'multiple'      => true,
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'explore_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Explore box title', 'taskbot'),
                        'description'   => esc_html__('Add box title, leave it empty to hide.', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'explore_btn_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Explore button text', 'taskbot'),
                        'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                    ]
                );
                $this->add_control(
                    'explore_btn_link',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Select page', 'taskbot'),
                        'desc'          => esc_html__('Select page for explore button URL.', 'taskbot'),
                        'options'       => $pages,
                        'multiple'      => false,
                        'label_block'   => true,
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
                global $taskbot_settings;
                $settings           = $this->get_settings_for_display();
                $title1             = !empty($settings['title1']) ? $settings['title1'] : '';
                $title2             = !empty($settings['title2']) ? $settings['title2'] : '';
                $button_text        = !empty($settings['button_text']) ? $settings['button_text'] : '';
                $explore_text       = !empty($settings['explore_text']) ? $settings['explore_text'] : '';
                $reg_button_text    = !empty($settings['reg_button_text']) ? $settings['reg_button_text'] : '';
                $explore_btn_text   = !empty($settings['explore_btn_text']) ? $settings['explore_btn_text'] : '';
                $explore_btn_link   = !empty($settings['explore_btn_link']) ? get_the_permalink($settings['explore_btn_link']) : '';
                $button_link        = !empty($settings['button_link']) ? get_the_permalink($settings['button_link']) : '';
                $reg_button_link    = !empty($settings['reg_button_link']) ? get_the_permalink($settings['reg_button_link']) : '';
                $categories         = !empty($settings['product_categories']) ? $settings['product_categories'] : array();
                $task_search_url    = taskbot_get_page_uri('service_search_page');
                $default_cat_image  = taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/cat-placeholder55-55.jpg');
                
                ?>
                <div class="tk-bannerv2">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-md-12">
                                <?php if( !empty($title1) || !empty($title2) ){?>
                                    <div class="tk-bannerv2_title">
                                        <?php if( !empty($title1) ){?><h1><?php echo esc_html($title1);?></h1><?php } ?>
                                        <?php if( !empty($title2) ){?><h2><?php echo esc_html($title2);?></h2><?php } ?>
                                    </div>
                                <?php } ?>
                                <ul class="tk-mainbtnlist tk-mainlist-two">
                                    <?php if(!empty($button_text)){?>
                                        <li><a href="<?php echo esc_url($button_link);?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo esc_html($button_text);?></a></li>
                                    <?php } ?>
                                    <?php if(!empty($reg_button_text) ){?>
                                        <li><a href="<?php echo esc_url($reg_button_link);?>" class="tk-btn-line-lg tk-btn-plain"><?php echo esc_html($reg_button_text);?></a></li>
                                    <?php } ?>
                                </ul>
                                <?php if (is_array($categories) && !empty($categories)) { ?>
                                    <ul class="tk-explore-categories">
                                        <?php
                                         foreach ($categories as $category) {
                                            $term_detail        = get_term($category);
                                            $term_url           = get_term_link($term_detail);
                                            $thumbnail_id       = get_term_meta($category, 'thumbnail_id', true);
                                            $image              = !empty($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'taskbot_thumbnail') : '';
                                            $image              = !empty($image[0]) ? $image[0] : $default_cat_image;

                                            $task_cat_search_url    = '#';
                                            if(!empty($task_search_url)) {
                                                $task_cat_search_url = !empty($term_detail->slug) ? add_query_arg('category', esc_attr($term_detail->slug), $task_search_url) : '#';
                                            }

                                            $term_name  = !empty($term_detail->name) ? $term_detail->name : '';
                                            $term_count = !empty($term_detail->count) ? $term_detail->count : 0;
                                             ?>
                                                <li>
                                                    <div class="tk-explore-content">
                                                        <?php if( !empty($image) ){?>
                                                            <figure>
                                                                <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($term_name);?>">
                                                            </figure>
                                                        <?php } ?>
                                                        <?php if( !empty($term_name) || isset($term_count) ){?>
                                                            <div class="tk-explore-info">
                                                                <?php if( !empty($term_name) ){?>
                                                                    <a href="<?php echo esc_url($task_cat_search_url);?>"><h6><?php echo esc_html($term_name);?></h6></a>
                                                                <?php } ?>
                                                                <?php if (isset($term_count)) { ?>
                                                                    <span><?php echo sprintf(esc_html__('%s Listings', 'taskbot'),$term_count); ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </li>
                                        <?php } ?>
                                        <?php if( !empty($explore_text) || !empty($explore_btn_text)){?>
                                            <li>
                                                <div class="tk-explore-content tk-exploremore-two">
                                                    <div class="tk-explore-info">
                                                        <?php if( !empty($explore_text) ){?>
                                                            <h5><?php echo esc_html($explore_text);?></h5>
                                                        <?php } ?>
                                                        <?php if( !empty($explore_btn_text) ){?>
                                                            <a href="<?php echo esc_url($explore_btn_link);?>" class="tk-btn-solid-sm tk-btn-yellow"><?php echo esc_html($explore_btn_text);?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskbot_Search_Banner);
    }
