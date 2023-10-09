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

    if (!class_exists('Taskbot_about_us_opportunity')) {
        class Taskbot_about_us_opportunity extends Widget_Base
        {

            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_about_us_opportunity';
            }

            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      title
             */
            public function get_title()
            {
                return esc_html__('Opportunity', 'taskbot');
            }

            /**
             *
             * @since    1.0.0
             * @access   public
             * @var      icon
             */
            public function get_icon()
            {
                return 'eicon-nerd';
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
                $posts = taskbot_elementor_get_posts(array('page'));
                $posts = !empty($posts) ? $posts : array();

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
                        'type'        => Controls_Manager::TEXT,
                        'label'       => esc_html__('Section title', 'taskbot'),
                        'description' => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                        'label_block' => true,
                    ]
                );

                $this->add_control(
                    'sub_title',
                    [
                        'type'        => Controls_Manager::TEXT,
                        'label'       => esc_html__('Tagline title', 'taskbot'),
                        'description' => esc_html__('Add tagline title. leave it empty to hide.', 'taskbot'),
                        'label_block' => true,
                    ]
                );

                $this->add_control(
                    'display_image',
                    [
                        'type'        => Controls_Manager::MEDIA,
                        'label'       => esc_html__('Display image', 'taskbot'),
                        'description' => esc_html__('Add display image.', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'description',
                    [
                        'type'        => Controls_Manager::TEXTAREA,
                        'label'       => esc_html__('Description', 'taskbot'),
                        'rows'        => 5,
                        'description' => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'points',
                    [
                        'label'   => esc_html__('Add points', 'taskbot'),
                        'type'    => Controls_Manager::REPEATER,
                        'fields' => [
                            [
                                'name'        => 'point',
                                'type'        => Controls_Manager::TEXT,
                                'label'       => esc_html__('Point which is display ', 'taskbot'),
                                'description' => esc_html__('Add points.', 'taskbot'),
                                'label_block' => true,
                            ]
                        ]
                    ]
                );

                $this->add_control(
                    'btn_text',
                    [
                        'type'        => Controls_Manager::TEXT,
                        'label'       => esc_html__('Button text', 'taskbot'),
                        'description' => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                        'label_block' => true,
                    ]
                );

                $this->add_control(
                    'page',
                    [
                        'type'        => Controls_Manager::SELECT2,
                        'label'       => esc_html__('Select page', 'taskbot'),
                        'desc'        => esc_html__('Select page to button navigation.', 'taskbot'),
                        'options'     => $posts,
                        'multiple'    => false,
                        'label_block' => true,
                    ]
                );


                $this->end_controls_section();
            }

            protected function render(){
                $settings         = $this->get_settings_for_display();
                $display_image    = !empty($settings['display_image']['url']) ? $settings['display_image']['url'] : '';
                $title            = !empty($settings['title']) ? $settings['title'] : '';
                $sub_title        = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
                $description      = !empty($settings['description']) ? $settings['description'] : '';
                $points           = !empty($settings['points']) ? $settings['points'] : '';
                $btn_text         = !empty($settings['btn_text']) ? $settings['btn_text'] : '';
                $page_ids         = !empty($settings['page']) ? $settings['page'] : array();
                $button_link      = !empty(get_the_permalink($page_ids)) ? get_the_permalink($page_ids) : '';
                ?>
                <div class="tk-about-us-opportunity">
                    <div class="container">
                        <div class="row align-items-center gy-4">
                            <?php if (!empty($display_image)) { ?>
                                <div class="col-xl-6">
                                    <figure class="tk-aboutusimg">
                                        <img src="<?php echo esc_url($display_image); ?>" alt="<?php esc_attr_e('Banner', 'taskbot'); ?>">
                                    </figure>
                                </div>
                            <?php } ?>
                            <div class="col-xl-6">
                                <div class="tk-main-title-holder pb-0">
                                    <?php if (!empty($sub_title) || !empty($title)) { ?>
                                        <div class="tk-maintitle">
                                            <?php do_action( 'taskbot_section_shaper_html' );?>
                                            <?php if (!empty($sub_title)) {?><h5><?php echo esc_html($sub_title); ?></h5><?php } ?>
                                            <?php if (!empty($title)) { ?><h2><?php echo esc_html($title); ?></h2><?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($description)) { ?>
                                        <div class="tk-main-description">
                                            <p><?php echo esc_html($description); ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($points)) { ?>
                                        <ul class="tk-mainlist">
                                            <?php foreach ($points as $point) {
                                                $opportunity_point = !empty($point['point']) ? $point['point'] : ''; ?>
                                                <li><?php echo esc_html($opportunity_point) ?></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                    <?php if (!empty($btn_text) && ( is_admin() || !is_user_logged_in() )) { ?>
                                        <a href="<?php echo esc_url($button_link); ?>" class="tk-btn-solid-lg"><?php echo esc_html($btn_text) ?> <i class="tb-icon-user-check"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskbot_about_us_opportunity);
    }
