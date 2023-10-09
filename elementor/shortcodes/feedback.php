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

if (!class_exists('Taskbot_about_us_feedback')) {
    class Taskbot_about_us_feedback extends Widget_Base
    {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskbot_element_feedback';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Feedback', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon()
        {
            return 'eicon-navigator';
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
                    'label'     => esc_html__('Content', 'taskbot'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Section title', 'taskbot'),
                    'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'description',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Description', 'taskbot'),
                    'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'btn_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Button text', 'taskbot'),
                    'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'page',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Select page', 'taskbot'),
                    'desc'          => esc_html__('Select page to button navigation.', 'taskbot'),
                    'options'       => $posts,
                    'multiple'      => false,
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'feedback',
                [
                    'label'     => esc_html__('Add feedback', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'          => 'user_image',
                            'type'          => Controls_Manager::MEDIA,
                            'label'         => esc_html__('Upload image', 'taskbot'),
                            'description'   => esc_html__('Upload image.(60x60)', 'taskbot'),
                        ],
                        [
                            'name'          => 'user_name',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Name', 'taskbot'),
                            'description'   => esc_html__('Add name content', 'taskbot'),
                            'label_block'   => true,
                        ],
                        [
                            'name'          => 'user_info',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Designation & Company name', 'taskbot'),
                            'description'   => esc_html__('Add designation content', 'taskbot'),
                            'label_block'   => true,
                        ],
                        [
                            'name'          => 'user_url',
                            'type'          => Controls_Manager::URL,
                            'placeholder'   => esc_html__('https://your-link.com', 'taskbot'),
                            'label'         => esc_html__('Link', 'taskbot'),
                            'description'   => esc_html__('Add link', 'taskbot'),
                            'show_external' => true,
                            'default'       => [
                                'url'       => '',
                                'is_external'   => true,
                                'nofollow'      => false,
                            ],
                        ],
                        [
                            'name'          => 'user_feedback_content',
                            'type'          => Controls_Manager::TEXTAREA,
                            'label'         => esc_html__('Feedback Content', 'taskbot'),
                            'description'   => esc_html__('Add feedback content', 'taskbot'),
                        ]
                    ]
                ]

            );

            $this->end_controls_section();
        }

        protected function render()
        {
            $settings       = $this->get_settings_for_display();
            $title          = !empty($settings['title']) ? $settings['title'] : '';
            $btn_text       = !empty($settings['btn_text']) ? $settings['btn_text'] : '';
            $feedback       = !empty($settings['feedback']) ? $settings['feedback'] : '';
            $description    = !empty($settings['description']) ? $settings['description'] : '';
            $page_id        = !empty($settings['page']) ? $settings['page'] : array();
            $button_link    = !empty($page_id) ? get_permalink($page_id) : '';
            $flag           = rand(9999, 999999);
            ?>
            <div class="tk-howitwork-wrapper gr-feedback">
                <div class="tk-sectionmid">
                    <div class="tk-feedbacksection">
                        <?php if (!empty($title) || !empty($description) || !empty($btn_text)) { ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tk-feedbackwrap">
                                            <?php if (!empty($title) || !empty($description)) { ?>
                                                <div class="tk-main-title-holder">
                                                    <?php if (!empty($title)) { ?>
                                                        <div class="tk-maintitle">
                                                            <h2><?php echo esc_html($title); ?></h2>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (!empty($description)) { ?>
                                                        <div class="tk-main-description">
                                                            <p><?php echo esc_html($description); ?></p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($btn_text)) { ?>
                                                <a href="<?php echo esc_url($button_link); ?>" class="tk-btn-solid-lg"><?php echo esc_html($btn_text); ?><i class="tb-icon-user-check"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($feedback) && is_array($feedback) && !empty($feedback[0]['user_image']['url'])) { ?>
                            <div id="tk-feedbackslider-<?php echo intval($flag); ?>" class="tk-feedbackslider tk-feedbackslider-<?php echo intval($flag); ?>">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php
                                        foreach ($feedback as $count) {
                                            $user_image             = !empty($count['user_image']['url']) ? $count['user_image']['url'] : '';
                                            $user_name              = !empty($count['user_name']) ? $count['user_name'] : '';
                                            $user_info              = !empty($count['user_info']) ? $count['user_info'] : '';
                                            $user_url               = !empty($count['user_url']) ? $count['user_url'] : '';
                                            $url                    = !empty($user_url['url']) ? $user_url['url'] : '';
                                            $target                 = !empty($user_url['is_external']) ? ' target="_blank"' : '';
                                            $nofollow               = !empty($user_url['nofollow']) ? ' rel="nofollow"' : '';
                                            $user_feedback_content  = !empty($count['user_feedback_content']) ? $count['user_feedback_content'] : '';
                                            $user_company_link      = '<h6><a href="' . esc_url($url) . '"' . do_shortcode($target) . do_shortcode($nofollow) . '>' . esc_html($user_info) . '</a></h6>';
                                            ?>
                                            <li class="splide__slide">
                                                <div class="tk-feedbackitem">
                                                    <?php if (!empty($user_image)) { ?>
                                                        <figure><img src="<?php echo esc_url($user_image); ?>" alt="<?php echo esc_attr($user_name); ?>"></figure>
                                                    <?php } ?>
                                                    <?php if (!empty($user_name) || !empty($user_info) || !empty($user_url) || !empty($user_feedback_content)) { ?>
                                                        <div class="tk-feedbackinfo">
                                                            <?php if (!empty($user_name)) { ?>
                                                                <h4><?php echo esc_html($user_name); ?></h4>
                                                            <?php } ?>
                                                            <?php if (!empty($user_info) || !empty($user_url)) { ?>
                                                                <?php echo do_shortcode($user_company_link); ?>
                                                            <?php } ?>
                                                            <?php if (!empty($user_feedback_content)) { ?>
                                                                <p><?php echo esc_html($user_feedback_content); ?></p>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php 
                if (!empty($feedback) && is_array($feedback) && !empty($feedback[0]['user_image']['url'])) {
                    $is_rtl			= taskbot_splide_rtl_check();
                    $scripts = ' jQuery(function () {
                    let tk_feedbackslider = document.querySelector("#tk-feedbackslider-' . esc_js($flag) . '");
                    
                    if (tk_feedbackslider !== null) {
                    var splide = new Splide(".tk-feedbackslider-' . esc_js($flag) . '", {
                        type   : "loop",
                        perPage: 3,
                        direction:"'.esc_js($is_rtl).'",
                        perMove: 1,
                        // autoplay: true,
                        arrows: false,
                        pagination: false,
                        gap: 24,
                        interval: 3000,
                        autoWidth: true,
                        breakpoints: {
                          1199: {
                            perPage: 2,
                          },
                          991: {
                            perPage:2,
                          },
                          767: {
                            perPage:1,
                          },
                          480: {
                            perPage:1,
                            autoWidth: false,
                            focus  : "center",
                            gap: 12,
                          },
                        }
                    });
                    splide.mount();
                    }
                });';
                wp_add_inline_script('splide', $scripts, 'after');
            }
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskbot_about_us_feedback);

}
