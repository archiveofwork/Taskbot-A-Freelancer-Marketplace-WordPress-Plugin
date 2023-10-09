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

if (!class_exists('Taskup_search_talent')) {
    class Taskup_search_talent extends Widget_Base
    {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_search_talent';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Search talent', 'taskbot');
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
                'title',
                [
                    'type'        => Controls_Manager::TEXTAREA,
                    'label'       => esc_html__('Section title', 'taskbot'),
                    'placeholder' => esc_html__('Type your title here', 'taskbot'),
                    'description' => esc_html__('Add title text. leave it empty to hide.', 'taskbot'),
                 ]
            );
            $this->add_control(
                'sub_title',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Sub title', 'taskbot'),
                    'placeholder'   => esc_html__('Type your sub title here', 'taskbot'),
                    'description'   => esc_html__('Add title text. leave it empty to hide.', 'taskbot'),
                 ]
            );

            $this->add_control(
                'description',
                [
                    'label'         => esc_html__('Heading', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::WYSIWYG,
                    'placeholder'   => esc_html__('Type your description here', 'taskbot'),
                    'description'   => esc_html__('Leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Button text', 'taskbot'),
                    'placeholder'   => esc_html__('Add button text here.', 'taskbot'),
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
                'image',
                [
                    'type'        => Controls_Manager::MEDIA,
                    'label'       => esc_html__('image', 'taskbot'),
                    'description' => esc_html__('Add an image.', 'taskbot'),
                ]
            );
            $this->add_control(
                'card_image',
                [
                    'type'        => Controls_Manager::MEDIA,
                    'label'       => esc_html__('Card image', 'taskbot'),
                    'description' => esc_html__('Add an image.', 'taskbot'),
                ]
            );

            $this->end_controls_section();
        }

        protected function render()
        {
            $settings      = $this->get_settings_for_display();
            $title         = !empty($settings['title']) ? $settings['title'] : '';
            $sub_title     = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $description   = !empty($settings['description']) ? $settings['description'] : '';
            $button_text   = !empty($settings['button_text']) ? $settings['button_text'] : '';
            $image         = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
            $card_image    = !empty($settings['card_image']['url']) ? $settings['card_image']['url'] : '';
            $button_link   = !empty($settings['button_link']) ? get_the_permalink($settings['button_link']) : ''; ?>

            <div class="tk-ouraim-section">
                <div class="container">
                    <div class="row gy-4 align-items-center">
                        <div class="col-12 col-xl-5">
                            <?php if(!empty($title) || !empty($sub_title) || !empty($description) || !empty($button_text)){?>
                                <div class="tk-main-title-holder">
                                    <?php if(!empty($title) || !empty($sub_title)){?>
                                        <div class="tk-maintitle">
                                            <?php do_action( 'taskbot_section_shaper_html' );?>
                                            <?php if(!empty($sub_title)){?>
                                                <h5><?php echo esc_html($sub_title)?></h5>
                                            <?php } 
                                            if(!empty($title)){?>
                                                <h2><?php echo esc_html($title)?></h2>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($description)){?>
                                        <div class="tk-main-description">
                                            <?php echo do_shortcode($description, false); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($button_text)){?>
                                        <div class="tk-btn-holder">
                                            <a href="<?php echo esc_url($button_link);?>" class="tk-btn-yellow-lg"><?php echo esc_html($button_text)?><i class="tb-icon-user-check"></i></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-xl-7">
                            <?php if(!empty($image) || !empty($card_image)){?>
                                <div class="tk-about-image">          
                                    <figure>
                                        <?php if(!empty($image)){?>
                                            <img src="<?php echo esc_url($image)?>" alt="<?php echo esc_attr($title)?>">
                                        <?php } ?>
                                        <?php if(!empty($card_image)){?>
                                            <figcaption>
                                                <img src="<?php echo esc_url($card_image)?>" alt="<?php echo esc_attr($sub_title)?>">
                                            </figcaption>
                                        <?php } ?>
                                    </figure>
                                </div>   
                            <?php } ?> 
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskup_search_talent);
}
