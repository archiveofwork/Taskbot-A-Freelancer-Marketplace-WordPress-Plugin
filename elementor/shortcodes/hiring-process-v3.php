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

if (!class_exists('Taskup_hiring')) {
    class Taskup_hiring extends Widget_Base
    {
        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
            wp_enqueue_style('venobox');
            wp_enqueue_script('venobox');
        }
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_hiring_process';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Hiring process v3', 'taskbot');
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
            $posts = array();
            if( function_exists('taskbot_elementor_get_posts') ){
                $posts = taskbot_elementor_get_posts(array('page'));
            }
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
                'video_link',
                [
                    'label' => esc_html__( 'Add video link', 'taskbot' ),
                    'type'  => \Elementor\Controls_Manager::TEXT
                ]
            );

            $this->add_control(
                'title',
                [
                    'type'          => \Elementor\Controls_Manager::WYSIWYG,
                    'label'         => esc_html__('Section title', 'taskbot'),
                    'placeholder'   => esc_html__('Type title here.', 'taskbot'),
                    'description'   => esc_html__('Add title text. leave it empty to hide.', 'taskbot'),
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'description',
                [
                    'label'         => esc_html__('Description', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::TEXTAREA,
                    'placeholder'   => esc_html__('Type your description here.', 'taskbot'),
                    'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'button_login_user',
                [
                    'type'          => Controls_Manager::SWITCHER,
                    'label'         => esc_html__('Hide button for login user', 'taskbot'),
                    'label_on'      => esc_html__( 'Show', 'taskbot' ),
                    'label_off'     => esc_html__( 'Hide', 'taskbot' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                ]
            );

            $this->add_control(
                'right_btn_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Talent button text', 'taskbot'),
                    'placeholder'   => esc_html__('Add button text here.', 'taskbot'),
                    'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                ]
            );
            $this->add_control(
                'right_btn_link',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Select page', 'taskbot'),
                    'desc'          => esc_html__('Select page for talent button URL.', 'taskbot'),
                    'options'       => $posts,
                    'multiple'      => false,
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'left_btn_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Work button text', 'taskbot'),
                    'placeholder'   => esc_html__('Add button text here.', 'taskbot'),
                    'description'   => esc_html__('Add Button text. leave it empty to hide.', 'taskbot'),
                ]
            );
            $this->add_control(
                'left_btn_link',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Select page', 'taskbot'),
                    'desc'          => esc_html__('Select page for registration button URL.', 'taskbot'),
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
            $description        = !empty($settings['description']) ? $settings['description'] : '';
            $video_link         = !empty($settings['video_link']) ? $settings['video_link'] : '';
            $button_login_user  = !empty($settings['button_login_user']) ? $settings['button_login_user'] : '';
            $left_btn_text      = !empty($settings['left_btn_text']) ? $settings['left_btn_text'] : '';
            $right_btn_text     = !empty($settings['right_btn_text']) ? $settings['right_btn_text'] : '';
            $left_btn_link      = !empty($settings['left_btn_link']) ? get_the_permalink($settings['left_btn_link']) : '';
            $right_btn_link     = !empty($settings['right_btn_link']) ? get_the_permalink($settings['right_btn_link']) : '';
            $show_button        = 'yes';
            $flag               = rand(99, 9999);
            if( !empty($button_login_user) && is_user_logged_in() && !current_user_can('administrator') ){
                $show_button    = '';
            }
            
            ?>
            <div class="tk-hiring-process">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-8">
                            <?php if(!empty($video_link) || !empty($title) || !empty($description)){?>
                                <div class="tk-main-title-holder text-center">
                                    <?php if(!empty($video_link) || !empty($title)){?>
                                        <div class="tk-maintitle">
                                            <?php if(!empty($video_link)){?>
                                                <a class="tk-hiring-vidobtn tk-themegallery tb-venobox-<?php echo intval($flag);?>" data-vbtype="video" href="<?php echo esc_url($video_link)?>" data-autoplay="true">
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            <?php } ?>
                                            <?php if(!empty($title)){?>
                                                <?php echo do_shortcode($title)?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($description)){?>
                                        <div class="tk-main-description">
                                            <p><?php echo do_shortcode($description); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if( !empty($show_button) && $show_button === 'yes' ){?>
                                <ul class="tk-mainbtnlist tk-mainlist-two pt-0">
                                    <?php if(!empty($right_btn_text)){?>
                                        <li><a href="<?php echo esc_url($right_btn_link)?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo esc_html($right_btn_text)?></a></li>
                                    <?php } ?>
                                    <?php if(!empty($left_btn_text)){?>
                                        <li><a href="<?php echo esc_url($left_btn_link)?>" class="tk-btn-line-lg tk-btn-plain"><?php echo esc_html($left_btn_text)?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            if (!empty($video_link)) {
                $script_video = '
                    jQuery(document).ready(function () {
                        let venobox = document.querySelector(".tb-venobox-' . esc_js($flag) . '");
                        if (venobox !== null) {
                            jQuery(".tb-venobox-' . esc_js($flag) . '").venobox({
                                spinner : "cube-grid",
                            });
                        }
                    })
                ';
                wp_add_inline_script('venobox', $script_video, 'after');
            }
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskup_hiring);
}
