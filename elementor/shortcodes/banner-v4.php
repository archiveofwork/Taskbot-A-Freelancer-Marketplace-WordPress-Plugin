<?php

/**
 * Shortcode
 *
 *
 * @package    Tasbot
 * @subpackage Tasbot/admin
 * @author     Amentotech <theamentotech@gmail.com>
 */

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Taskup_experts_banner')) {

    class Taskup_experts_banner extends Widget_Base
    {
        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_experts_banner';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Experts banner', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon()
        {
            return 'eicon-banner';
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
            global $taskbot_settings;
            $posts          = array();

            if( function_exists('taskbot_elementor_get_posts') ){
                $posts = taskbot_elementor_get_posts(array('page'));
            }

            $this->start_controls_section(
                'content_section',
                [
                    'label'     => esc_html__('Content', 'taskbot'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'tag_title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Add tag title', 'taskbot'),
                    'placeholder'   => esc_html__('Add tag title here.', 'taskbot'),
                    'description'   => esc_html__('Add tag title. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'heading_text',
                [
                    'label'         => esc_html__('Heading text', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::WYSIWYG,
                    'placeholder'   => esc_html__('Type your heading text here.', 'taskbot'),
                    'description'   => esc_html__('Add your heading text here or leave it empty to hide', 'taskbot'),

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
            $this->add_control(
                'after_btn_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Text after button', 'taskbot'),
                    'placeholder'   => esc_html__('Add text after button here.', 'taskbot')
                ]
            );
            $this->add_control(
                'user_image',
                [
                    'type'          => Controls_Manager::MEDIA,
                    'label'         => esc_html__('Upload user image', 'taskbot')
                ]
            );

            $this->add_control(
                'user_feedback',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Add user feedback content', 'taskbot'),
                    'placeholder'   => esc_html__('Add user feedback content here.', 'taskbot'),
                    'description'   => esc_html__('Add user feedback content. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'rating_content',
                [
                    'type'          => \Elementor\Controls_Manager::WYSIWYG,
                    'label'         => esc_html__('Add user rating content', 'taskbot'),
                    'placeholder'   => esc_html__('Add user rating content here.', 'taskbot'),
                    'description'   => esc_html__('Add user rating content. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'banner_image',
                [
                    'type'          => Controls_Manager::MEDIA,
                    'label'         => esc_html__('Upload right image', 'taskbot')
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
        protected function render(){
            global $taskbot_settings;
            $settings           = $this->get_settings_for_display();
            $heading_text       = !empty($settings['heading_text']) ? $settings['heading_text'] : '';
            $tag_title          = !empty($settings['tag_title']) ? $settings['tag_title'] : '';
            $button_login_user  = !empty($settings['button_login_user']) ? $settings['button_login_user'] : '';
            $left_btn_text      = !empty($settings['left_btn_text']) ? $settings['left_btn_text'] : '';
            $right_btn_text     = !empty($settings['right_btn_text']) ? $settings['right_btn_text'] : '';
            $left_btn_link      = !empty($settings['left_btn_link']) ? get_the_permalink($settings['left_btn_link']) : '';
            $right_btn_link     = !empty($settings['right_btn_link']) ? get_the_permalink($settings['right_btn_link']) : '';
            $after_btn_text     = !empty($settings['after_btn_text']) ? $settings['after_btn_text'] : '';
            $user_feedback      = !empty($settings['user_feedback']) ? $settings['user_feedback'] : '';
            $rating_content     = !empty($settings['rating_content']) ? $settings['rating_content'] : '';
            $banner_image       = !empty($settings['banner_image']['url']) ? $settings['banner_image']['url'] : '';
            $user_image         = !empty($settings['user_image']['url']) ? $settings['user_image']['url'] : '';
            $show_button        = 'yes';
            if( !empty($button_login_user) && is_user_logged_in() && !current_user_can('administrator') ){
                $show_button    = '';
            }
            ?>
            <div class="tk-bannersix">
                <span class="tk-partical-shape"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-xxl-7">
                            <div class="tk-banner-content">
                                <?php if( !empty($heading_text) || !empty($tag_title) ){?>
                                    <div class="tk-bannerv3_title">
                                        <?php if( !empty($tag_title) ){?>
                                            <span class="tk-ranking-tag"><?php echo esc_html($tag_title);?></span>
                                        <?php } ?>
                                        <?php if(!empty($heading_text)){?>
                                            <?php echo do_shortcode( $heading_text );?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if( !empty($show_button) && $show_button === 'yes' ){?>
                                    <?php if(!empty($left_btn_text) || !empty($right_btn_text) || !empty($after_btn_text)){?>
                                        <ul class="tk-themebanner_list">
                                            <?php if( !empty($left_btn_text) ){?>
                                                <li><a href="<?php echo esc_url($left_btn_link);?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo esc_html($left_btn_text);?><i class="tb-icon-briefcase"></i></a></li>
                                            <?php } ?>
                                            <?php if( !empty($right_btn_text) ){?>
                                                <li><a href="<?php echo esc_url($right_btn_link);?>" class="tk-btn-solid-white"><?php echo esc_html($right_btn_text);?><i class="tb-icon-user-check"></i></a></li>
                                            <?php } ?>
                                            <?php if( !empty($after_btn_text) ){?>
                                                <li class="tk-linestyle">
                                                    <img src="<?php echo esc_url(TASKBOT_DIRECTORY_URI . 'public/images/start-shape-two.png');?>" alt="<?php echo esc_attr($after_btn_text);?>">
                                                    <span><?php echo esc_html($after_btn_text);?></span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                <?php } ?>
                                <?php if( !empty($user_image) || !empty($user_feedback) || !empty($rating_content) ){?>
                                    <div class="tk-banneruser-info">
                                        <?php if( !empty($user_image)){?>
                                            <img src="<?php echo esc_url($user_image);?>" alt="<?php echo esc_attr($after_btn_text);?>">
                                        <?php } ?>
                                        <?php if( !empty($user_feedback) || !empty($rating_content) ){?>
                                            <div class="tk-banneruser-info_content">
                                                <?php if( !empty($user_feedback) ){?>
                                                    <p><?php echo do_shortcode( $user_feedback );?></p>
                                                <?php } ?>
                                                <?php if( !empty($rating_content) ){?>
                                                    <div class="tk-ratting">
                                                        <?php echo do_shortcode( $rating_content );?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if( !empty($banner_image) ){?>
                    <div class="tk-epxerts-banner">
                        <span class="tk-exprt-banner-shape"></span>
                        <svg class="radiusshape-holder">
                            <clipPath id="radiusshape" clipPathUnits="objectBoundingBox"><path d="M0.048,0 H1 V1 H0.128 C0.068,1,0.038,1,0.02,0.973 C0.003,0.947,0.005,0.905,0.009,0.82 L0.048,0"></path></clipPath>
                        </svg>
                        <img src="<?php echo esc_url($banner_image);?>" alt="<?php esc_attr_e('expert meetings','taskbot');?>">
                    </div>
                <?php } ?>
            </div>
            <?php            
        }
    }
    Plugin::instance()->widgets_manager->register(new Taskup_experts_banner);
}
