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

if (!class_exists('Taskup_in_touch')) {
    class Taskup_in_touch extends Widget_Base{

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_in_touch';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Get in touch', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon()
        {
            return 'eicon-table-of-contents';
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
                'content_section',
                [
                    'label'     => esc_html__('Content', 'taskbot'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'title',
                [
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('Title', 'taskbot'),
                    'placeholder' => esc_html__('Type your title here', 'taskbot'),
                    'description' => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'sub_title',
                [
                    'label'         => esc_html__('Sub title', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::TEXT,
                    'description'   => esc_html__('Add sub title. leave it empty. to hide it.', 'taskbot'),
                    'label_block'   => true
                ]
            );
            
            $this->add_control(
                'description',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Description', 'taskbot'),
                    'placeholder'   => esc_html__('Type your description here.', 'taskbot'),
                    'rows'          => 5,
                    'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'platforms',
                [
                    'label'     => esc_html__('Add Platforms', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'        => 'image',
                            'type'        => Controls_Manager::MEDIA,
                            'label'       => esc_html__('image', 'taskbot'),
                            'description' => esc_html__('Add an image.', 'taskbot'),
                            'label_block' => true,
                        ], 
                        [
                            'name'          => 'title',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Title', 'taskbot'),
                            'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                            'label_block'   => true,
                        ], 
                        [
                            'name'          => 'description',
                            'type'          => Controls_Manager::TEXTAREA,
                            'label'         => esc_html__('Description', 'taskbot'),
                            'description'   => esc_html__('Description', 'taskbot'),
                        ],
                        [
                            'name'          => 'link_detail',
                            'type'          => \Elementor\Controls_Manager::WYSIWYG,
                            'label'         => esc_html__('Link content', 'taskbot'),
                            'description'   => esc_html__('Add link content. leave it empty to hide', 'taskbot'),
                            'default'       => esc_html__( '' , 'taskbot' ),
				            'show_label'    => false,
                        ]
                    ]
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
            $settings       = $this->get_settings_for_display();
            $title          = !empty($settings['title']) ? $settings['title'] : ''; 
            $sub_title      = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $description    = !empty($settings['description']) ? $settings['description'] : ''; 
            $platforms      = !empty($settings['platforms']) ? $settings['platforms'] : '' ;
            ?>
            <div class="tk-main-section-two">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php if(!empty($title) || !empty($description) || !empty($sub_title) ){?>
                            <div class="col-lg-10 col-xl-8">
                                <div class="tk-main-title-holder text-center">
                                    <?php if(!empty($title) || !empty($sub_title)){?>
                                        <div class="tk-maintitle">
                                            <?php do_action( 'taskbot_section_shaper_html' );?>
                                            <?php if(!empty($sub_title)){?>
                                                <h3><?php echo esc_html($sub_title)?></h3>
                                            <?php } ?>
                                            <?php if(!empty($title)){?>
                                                <h2><?php echo esc_html($title)?></h2>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($description)){?>
                                        <div class="tk-main-description">
                                            <p><?php echo esc_html($description)?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php 
                        if(!empty($platforms)){?>
                            <div class="col-lg-12">
                                <div class="row gy-4">
                                    <?php
                                    foreach($platforms as $platform){
                                        $image          = !empty($platform['image']['url']) ? $platform['image']['url'] : '';
                                        $title          = !empty($platform['title']) ? $platform['title'] : '';
                                        $description    = !empty($platform['description']) ? $platform['description'] : '';
                                        $link_detail    = !empty($platform['link_detail']) ? $platform['link_detail'] : '';
                                        ?>

                                        <div class="col-md-6 col-xl-4">
                                            <div class="tk-contactus_content">
                                                <?php if(!empty($image)){?>
                                                    <img src="<?php echo esc_url($image)?>" alt="<?php echo esc_attr($title)?>">
                                                <?php } ?>
                                                <?php if(!empty($title)){?>
                                                    <h4><?php echo esc_html($title)?></h4>
                                                <?php } ?>
                                                <?php if(!empty($description)){?>
                                                    <p><?php echo esc_html($description) ?></p>
                                                <?php } ?>
                                                <?php if(!empty($link_detail)){?>
                                                    <?php echo do_shortcode($link_detail)?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    Plugin::instance()->widgets_manager->register(new Taskup_in_touch);
}
