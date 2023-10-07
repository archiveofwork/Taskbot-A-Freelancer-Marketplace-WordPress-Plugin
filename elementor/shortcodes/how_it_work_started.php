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

if (!class_exists('Taskbot_how_it_work_get_started')) {
    class Taskbot_how_it_work_get_started extends Widget_Base
    {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskbot_element_how_work_get_started';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('How it work get started', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon()
        {
            return 'eicon-kit-details';
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
                'sub_title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Section tagline', 'taskbot'),
                    'description'   => esc_html__('Add tagline text. leave it empty to hide.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Section title', 'taskbot'),
                    'description'   => esc_html__('Add title text. leave it empty to hide.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'description',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Description', 'taskbot'),
                    'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'text_signin_btn',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Text sign in button', 'taskbot'),
                    'description'   => esc_html__('Add sign in button text.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'signin_page',
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
                'text_signup_btn',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Text sign up button', 'taskbot'),
                    'description'   => esc_html__('Add sign up button text.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'signup_page',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Select page', 'taskbot'),
                    'desc'          => esc_html__('Select page to button navigation.', 'taskbot'),
                    'options'       => $posts,
                    'multiple'      => false,
                    'label_block'   => true,
                ]
            );

            $this->end_controls_section();
        }

        protected function render()
        {

            $settings           = $this->get_settings_for_display();
            $title              = !empty($settings['title']) ? $settings['title'] : '';
            $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $description        = !empty($settings['description']) ? $settings['description'] : '';
            $text_signin_btn    = !empty($settings['text_signin_btn']) ? $settings['text_signin_btn'] : '';
            $text_signup_btn    = !empty($settings['text_signup_btn']) ? $settings['text_signup_btn'] : '';
            $signin_page        = !empty($settings['signin_page']) ? $settings['signin_page'] : array();
            $signin_page_link   = !empty(get_permalink($signin_page)) ? get_permalink($signin_page) : '';
            $signup_page        = !empty($settings['signup_page']) ? $settings['signup_page'] : array();
            $signup_page_link   = !empty(get_permalink($signup_page)) ? get_permalink($signup_page) : '';
            ?>
            <div class="tk-startedtoday-section tk-howitworks-v3">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <div class="tk-main-title-holder text-center">
                                <?php if (!empty($title) || !empty($sub_title)) { ?>
                                    <div class="tk-maintitle">
                                        <?php if (!empty($sub_title)) { ?>
                                            <h5><?php echo esc_html($sub_title); ?> </h5>
                                        <?php } ?>
                                        <?php if (!empty($title)) { ?>
                                            <h2><?php echo esc_html($title); ?></h2>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($description)) { ?>
                                    <div class="tk-main-description">
                                        <p><?php echo esc_html($description); ?></p>
                                    </div>
                                <?php } ?>
                                <?php if ((!is_user_logged_in(  ) || current_user_can('administrator') ) && (!empty($text_signin_btn) || !empty($text_signup_btn)) ) { ?>
                                    <ul class="tk-mainbtnlist">
                                        <?php if (!empty($text_signup_btn)) { ?>
                                            <li><a href="<?php echo esc_url($signup_page_link); ?>" class="tk-btn-solid-lg"><?php echo esc_html($text_signup_btn); ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($text_signin_btn)) { ?>
                                            <li><a href="<?php echo esc_url($signin_page_link); ?>" class="tk-btn-solid-lg tk-btnsolid-white"><?php echo esc_html($text_signin_btn); ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskbot_how_it_work_get_started);
}
