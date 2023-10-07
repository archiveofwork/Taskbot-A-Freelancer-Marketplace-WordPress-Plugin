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

    if (!class_exists('Taskbot_Hero_CTA')) {
        class Taskbot_Hero_CTA extends Widget_Base
        {
            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_hero_cta';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Hero CTA', 'taskbot');
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
                        'label'       => esc_html__('Heading', 'taskbot'),
                        'description' => esc_html__('Add heading text, leave it empty to hide.', 'taskbot'),
                    ]
                );
                $this->add_control(
                    'title2',
                    [
                        'type'        => Controls_Manager::TEXTAREA,
                        'label'       => esc_html__('Description', 'taskbot'),
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
                    'banner',
                    [
                        'type'        => Controls_Manager::MEDIA,
                        'label'       => esc_html__('Banner image', 'taskbot'),
                        'description' => esc_html__('Add banner image.', 'taskbot'),
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'label_block' => true,
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
                $button_link        = !empty($settings['button_link']) ? get_the_permalink($settings['button_link']) : '';

                $reg_button_text    = !empty($settings['reg_button_text']) ? $settings['reg_button_text'] : '';
                $reg_button_link    = !empty($settings['reg_button_link']) ? get_the_permalink($settings['reg_button_link']) : '';
                $banner             = !empty($settings['banner']['url']) ? $settings['banner']['url'] : '';

                
                ?>
                <div class="tk-sectionmid-two sc-cta-banner">
                    <div class="tk-bannervfive">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-7 col-xl-6">
                                    <div class="tk-bannerinfo tk-banner-content">
                                        <div class="tk-bannerinfo_title">
                                            <?php if( !empty($title1) ){?><h1><?php echo esc_html($title1);?></h1><?php } ?>
                                            <?php if( !empty($title2) ){?><p><?php echo esc_html($title2);?></p><?php } ?>
                                        </div>
                                        <?php if( !empty($button_link) || !empty($reg_button_link)){?>
                                            <ul class="tk-mainbtnlist">
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
                                <?php if( !empty($banner) ){?>
                                    <div class="col-12 col-lg-5 col-xl-6">
                                        <figure class="tk-banner-img">
                                            <img src="<?php echo esc_url($banner);?>" alt="<?php esc_attr_e('Banner','taskbot');?>">
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
        Plugin::instance()->widgets_manager->register(new Taskbot_Hero_CTA);
    }
