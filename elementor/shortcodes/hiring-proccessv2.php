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

if (!class_exists('Taskbot_hiring_processv2')) {
    class Taskbot_hiring_processv2 extends Widget_Base
    {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskbot_taskbot_hiring_processv2';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Hiring process v2', 'taskbot');
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

            //Content
            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__('Content', 'taskbot'),
                    'tab'   => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'hiring_steps',
                [
                    'label'     => esc_html__('Add hiring step', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'          => 'title',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Title', 'taskbot'),
                            'description'   => esc_html__('Add title', 'taskbot'),
                        ],
                        [
                            'name'          => 'details',
                            'type'          => Controls_Manager::TEXTAREA,
                            'label'         => esc_html__('Details', 'taskbot'),
                            'description'   => esc_html__('Add details', 'taskbot'),
                        ],
                        [
                            'name'          => 'image',
                            'type'          => Controls_Manager::MEDIA,
                            'label'         => esc_html__('Upload image', 'taskbot'),
                            'description'   => esc_html__('Upload step image.', 'taskbot'),
                            'default' => [
                                'url' => \Elementor\Utils::get_placeholder_image_src(),
                            ],
                        ],
                        [
                            'name'          => 'button_text',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Button text', 'taskbot'),
                            'description'   => esc_html__('Add button text', 'taskbot'),
                        ],
                        [
                            'name'          => 'button_url',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Button URL', 'taskbot'),
                            'description'   => esc_html__('Add button URL', 'taskbot'),
                        ]
                    ]
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
                'description',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Description', 'taskbot'),
                    'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Button text', 'taskbot'),
                    'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                ]
            );
            $this->add_control(
                'button_link',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Button URL', 'taskbot')
                ]
            );

            $this->add_control(
                'button_sub_title',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Button sub title', 'taskbot'),
                    'description'   => esc_html__('Add button sub title text. leave it empty to hide.', 'taskbot'),
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
            $button_link        = !empty($settings['button_link']) ? esc_url($settings['button_link']) : '';
            $button_text        = !empty($settings['button_text']) ? $settings['button_text'] : '';
            $button_sub_title   = !empty($settings['button_sub_title']) ? $settings['button_sub_title'] : '';
            $hiring_steps       = !empty($settings['hiring_steps']) ? $settings['hiring_steps'] : array();

            ?>
            <div class="tk-sectionmid-two sc-hiring-step">
                <div class="tk-section-bg tk-hirring-info">
                    <div class="container">
                        <div class="row align-items-center">
                            <?php if( !empty($hiring_steps) ){?>
                                <div class="col-lg-12 col-xl-6">
                                    <ul class="tk-hirring-img">
                                        <?php
                                            $counter    = 0;
                                            foreach($hiring_steps as $hiring_step){
                                                $counter ++;
                                                $step_title = !empty($hiring_step['title']) ? $hiring_step['title'] : "";
                                                $details    = !empty($hiring_step['details']) ? $hiring_step['details'] : "";
                                                $image      = !empty($hiring_step['image']['url']) ? $hiring_step['image']['url'] : "";

                                                $step_button_link        = !empty($hiring_step['button_link']) ? esc_url($hiring_step['button_link']) : '';
                                                $step_button_text        = !empty($hiring_step['button_text']) ? $hiring_step['button_text'] : '';
                                                $section_class  = '';
                                                if( !empty($counter) && $counter == 2 ){
                                                    $section_class  = 'tk-img-info-two';
                                                }

                                        ?>
                                        <li>
                                            <div class="tk-img-info <?php echo esc_attr($section_class);?>">
                                                <div class="tk-img-content">
                                                    <?php if( !empty($step_title) ){?>
                                                        <h4><?php echo esc_html($step_title);?></h4>
                                                    <?php } ?>
                                                    <?php if( !empty($details) ){?>
                                                        <p><?php echo esc_html($details);?></p>
                                                    <?php } ?>
                                                    <?php if( !empty($step_button_text) ){?>
                                                        <a href="<?php echo esc_url($step_button_link);?>"><?php echo esc_html($step_button_text);?> <i class="icon-chevron-right"></i></a>
                                                    <?php } ?>
                                                </div>
                                                <?php if( !empty($image) ){?>
                                                    <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($step_title);?>">
                                                <?php } ?>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <?php if( !empty($button_sub_title) || !empty($button_text) || !empty($title) || !empty($description) ){?>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="tk-hirring-section tk-hirring-sectionvtwo">
                                        <div class="tk-main-title-holder">
                                            <?php if( !empty($title) ){?>
                                                <div class="tk-maintitle">
                                                    <h2><?php echo esc_html($title);?></h2>
                                                </div>
                                            <?php } ?>
                                            <?php if( !empty($description) ){?>
                                                <div class="tk-main-description">
                                                    <p><?php echo esc_html($description);?></p>
                                                </div>
                                            <?php } ?>
                                            <?php if( !empty($button_sub_title) || !empty($button_text) ){?>
                                                <div class="tk-exploretalent">
                                                    <a href="<?php echo esc_url($button_link);?>" class="tk-btn-solid-lg tk-btnvthree"><?php echo esc_html($button_text);?></a>
                                                    <?php if( !empty($button_sub_title) ){?>
                                                        <span><?php echo nl2br($button_sub_title);?></span>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>	
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        <?php 
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskbot_hiring_processv2);
}
