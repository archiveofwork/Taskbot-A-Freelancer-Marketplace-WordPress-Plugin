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

if (!class_exists('Taskbot_hiring_process')) {
    class Taskbot_hiring_process extends Widget_Base
    {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskbot_taskbot_hiring_process';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Hiring process', 'taskbot');
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
                'title',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Section title', 'taskbot'),
                    'description'   => esc_html__('Add title text. leave it empty to hide.', 'taskbot'),
                    'label_block'   => true,
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
                'description',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Description', 'taskbot'),
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
                    'options'       => $posts,
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
                    'options'       => $posts,
                    'multiple'      => false,
                    'label_block'   => true,
                ]
            );

            $this->add_control(
                'top_border_img',
                [
                    'type'          => Controls_Manager::MEDIA,
                    'label'         => esc_html__('Upload top border image', 'taskbot'),
                    'description'   => esc_html__('Upload top border image. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'bottom_border_img',
                [
                    'type'          => Controls_Manager::MEDIA,
                    'label'         => esc_html__('Upload bottom border image', 'taskbot'),
                    'description'   => esc_html__('Upload bottom border image. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->end_controls_section();
        }

        protected function render()
        {

            $settings           = $this->get_settings_for_display();
            $title              = !empty($settings['title']) ? $settings['title'] : '';
            $description        = !empty($settings['description']) ? $settings['description'] : '';

            $button_link        = !empty($settings['button_link']) ? get_the_permalink($settings['button_link']) : '';
            $reg_button_link    = !empty($settings['reg_button_link']) ? get_the_permalink($settings['reg_button_link']) : '';

            $button_text        = !empty($settings['button_text']) ? $settings['button_text'] : '';
            $reg_button_text    = !empty($settings['reg_button_text']) ? $settings['reg_button_text'] : '';
            $button_login_user  = !empty($settings['button_login_user']) ? $settings['button_login_user'] : '';
            $top_border_img     = !empty($settings['top_border_img']['url']) ? $settings['top_border_img']['url'] : '';
            $bottom_border_img  = !empty($settings['bottom_border_img']['url']) ? $settings['bottom_border_img']['url'] : '';

            ?>
            <div class="tk-sectionmid-two sc-hiring-proces-call">
                <div class="tk-section-bg">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="tk-hirring-section">
                                    <?php if(!empty($title) || !empty($description)) {?>
                                        <div class="tk-main-title-holder text-center">
                                            <?php if(!empty($title)){?>
                                                <div class="tk-maintitle">
                                                    <h2><?php echo do_shortcode(nl2br($title));?></h2>
                                                </div>
                                            <?php } ?>
                                            <?php if(!empty($description)){ ?>
                                                <div class="tk-main-description">
                                                    <p><?php echo do_shortcode(nl2br($description));?></p>
                                                </div>
                                            <?php } ?>
                                        </div>	
                                    <?php } ?>
                                    <?php if( is_admin() || !is_user_logged_in() || ($button_login_user != 'yes')){?>
                                        <ul class="tk-mainbtnlist tk-mainlist-two">
                                            <?php if(!empty($button_text)){?>
                                                <li><a href="<?php echo esc_url($button_link);?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo esc_html($button_text);?></a></li>
                                            <?php } ?>
                                            <?php if(!empty($reg_button_text) ){?>
                                                <li><a href="<?php echo esc_url($reg_button_link);?>" class="tk-btn-line-lg tk-btn-plain"><?php echo esc_html($reg_button_text);?></a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <?php if( !empty($top_border_img) || !empty($bottom_border_img) ){?>
                        <?php if( !empty($bottom_border_img) ){?>
                            <img class="tk-shapes_one" src="<?php echo esc_url($bottom_border_img);?>" alt="<?php echo esc_attr($title);?>">
                        <?php } ?>
                        <?php if( !empty($top_border_img) ){?>
                            <img class="tk-shapes_two" src="<?php echo esc_url($top_border_img);?>" alt="<?php echo esc_attr($button_text);?>">
                        <?php } ?>
                    <?php } ?>
                </div>
		    </div>
        <?php 
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskbot_hiring_process);
}
