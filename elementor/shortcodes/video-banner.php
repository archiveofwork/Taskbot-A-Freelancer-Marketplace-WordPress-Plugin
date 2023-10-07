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

    if (!class_exists('Taskbot_index_operate')) {
        class Taskbot_index_operate extends Widget_Base
        {

            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_index_operate';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('How it works video banner', 'taskbot');
            }

            /**
            *
            * @since    1.0.0
            * @access   public
            * @var      icon
            */
            public function get_icon()
            {
                return 'eicon-slider-video';
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
                //Content
                $this->start_controls_section(
                    'video_section',
                    [
                        'label'     => esc_html__('Video section', 'taskbot'),
                        'tab'       => Controls_Manager::TAB_CONTENT,
                    ]
                );

                $this->add_control(
                    'fig_title',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Title', 'taskbot'),
                        'description'   => esc_html__('Add figure title. leave it empty to hide.', 'taskbot'), 'label_block' => true,
                    ]
                );

                $this->add_control(
                    'fig_sub_title',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Sub title', 'taskbot'),
                        'description'   => esc_html__('Add figure sub title. leave it empty to hide.', 'taskbot'),
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'image',
                    [
                        'type'          => Controls_Manager::MEDIA,
                        'label'         => esc_html__('Display image', 'taskbot'),
                        'description'   => esc_html__('Add display image.', 'taskbot'),
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ]
                );

                $this->add_control(
                    'video_url',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Video link', 'taskbot'),
                        'description'   => esc_html__('Add url. leave it empty to hide.', 'taskbot'),
                        'label_block'   => true,
                    ]
                );

                $this->end_controls_section();
                $this->start_controls_section(
                    'content_section',
                    [
                        'label'     => esc_html__('Content section', 'taskbot'),
                        'tab'       => Controls_Manager::TAB_CONTENT,
                    ]
                );
                $this->add_control(
                    'section_title',
                    [
                        'type'        => Controls_Manager::TEXT,
                        'label'       => esc_html__('Title', 'taskbot'),
                        'description' => esc_html__('Add section title or leave it empty to hide.', 'taskbot'),
                        'label_block'   => true,
                    ]
                );
                $this->add_control(
                    'operators',
                    [
                        'label'     => esc_html__('Add operators', 'taskbot'),
                        'type'      => Controls_Manager::REPEATER,
                        'fields'    => [
                            [
                                'name'          => 'icon',
                                'type'          => Controls_Manager::TEXT,
                                'label'         => esc_html__('Icon class', 'taskbot'),
                                'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                                'label_block'   => true,
                            ],
                            [
                                'name'          => 'title',
                                'type'          => Controls_Manager::TEXT,
                                'label'         => esc_html__('Section title', 'taskbot'),
                                'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                                'label_block'   => true,
                            ],
                            [
                                'name'          => 'desc',
                                'type'          => Controls_Manager::TEXTAREA,
                                'label'         => esc_html__('Description', 'taskbot'),
                                'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                            ]
                        ]
                    ]
                );
                $this->end_controls_section();

            }

            protected function render()
            {
                $settings       = $this->get_settings_for_display();
                $section_title  = !empty($settings['section_title']) ? $settings['section_title'] : '';
                $fig_title      = !empty($settings['fig_title']) ? $settings['fig_title'] : '';
                $fig_sub_title  = !empty($settings['fig_sub_title']) ? $settings['fig_sub_title'] : '';
                $image          = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
                $video_url      = !empty($settings['video_url']) ? $settings['video_url'] : '';
                $operators      = !empty($settings['operators']) ? $settings['operators'] : array();
                $flag           = rand(9999, 999999);
                ?>
                <div class="tk-sectionmid">
                    <div class="tk-easyrightarea">
                        <?php if (!empty($fig_title) || !empty($fig_sub_title) || !empty($image) || !empty($play_btn_image) || !empty($video_url)) { ?>
                            <figure>
                                <?php if (!empty($image)) { ?>
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php esc_attr_e('banner', 'taskbot') ?> ">
                                <?php } ?>
                                <?php if (!empty($video_url) || !empty($fig_title) || !empty($fig_sub_title)) { ?>
                                    <figcaption class="tk-imgdescp">
                                        <div class="tk-rightareainfo">
                                            <?php if (!empty($video_url)) { ?>
                                                <a class="venobox-<?php echo intval($flag); ?>" data-vbtype="video" data-gall="gall" href="<?php echo esc_url($video_url); ?>" data-autoplay="true">
                                                    <i class="icon-play tk-playicon"></i>
                                                </a>
                                            <?php } ?>
                                            <?php if (!empty($fig_title)) { ?>
                                                <h3><?php echo esc_html($fig_title); ?></h3>
                                            <?php } ?>
                                            <?php if (!empty($fig_sub_title)) { ?>
                                                <h5><?php echo esc_html($fig_sub_title); ?></h5>
                                            <?php } ?>
                                        </div>
                                    </figcaption>
                                <?php } ?>
                            </figure>
                        <?php } ?>
                        <div class="tk-easyoperate">
                            <?php if (!empty($section_title)) { ?>
                                <div class="tk-maintitle">
                                    <h2><?php echo esc_html($section_title); ?></h2>
                                </div>
                            <?php } ?>
                            <div class="tk-easyinfo">
                                <?php 
                                    if (!empty($operators)) {
                                        foreach ($operators as $value) {
                                            $first_step_title           = !empty($value['title']) ? $value['title'] : '';
                                            $first_step_icon            = !empty($value['icon']) ? $value['icon'] : '';
                                            $first_step_description     = !empty($value['desc']) ? $value['desc'] : '';
                                            ?>
                                            <div class="tk-easyinfotitle">
                                                <?php if (!empty($first_step_icon)) { ?>
                                                        <i class="<?php echo esc_attr($first_step_icon); ?>"></i>
                                                <?php } ?>
                                                <div class="tk-easyitem">
                                                    <?php if (!empty($first_step_title)) { ?>
                                                        <h4><?php echo esc_html($first_step_title); ?></h4>
                                                    <?php } ?>
                                                    <?php if (!empty($first_step_description)) { ?>
                                                        <p><?php echo esc_html($first_step_description); ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if (!empty($video_url)) {
                    $script_video = '
                        jQuery(document).ready(function () {
                            let venobox = document.querySelector(".venobox-' . esc_js($flag) . '");
                            if (venobox !== null) {
                                jQuery(".venobox-' . esc_js($flag) . '").venobox({
                                    spinner : "cube-grid",
                                });
                            }
                        })
                    ';
                    wp_add_inline_script('venobox', $script_video, 'after');
                }
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskbot_index_operate);
    }
