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

if (!class_exists('Taskup_talk_with_professional')) {
    class Taskup_talk_with_professional extends Widget_Base{

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_professional_talk';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Talk with professional', 'taskbot');
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
            $posts  = array();
            if( function_exists('taskbot_elementor_get_posts') ){
                $posts  = taskbot_elementor_get_posts(array('wpcf7_contact_form'));
            }
            $posts  = !empty($posts) ? $posts : array();
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
                    'description' => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'description',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Description', 'taskbot'),
                    'rows'          => 5,
                    'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'location_link',
                [
                    'label'         => esc_html__( 'Google Map code', 'taskbot' ),
                    'type'          => Controls_Manager::TEXTAREA,
                    'description'   => esc_html__('Add Google Map code to show map. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'question_form',
                [
                    'label'       => esc_html__('Form', 'taskbot'),
                    'description' => esc_html__('Choose form', 'taskbot'),
                    'type'        => \Elementor\Controls_Manager::SELECT2,
                    'options'     => $posts,
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
            $settings    = $this->get_settings_for_display();
            $title       = !empty($settings['title']) ? $settings['title'] : ''; 
            $location    = !empty($settings['location_link']) ? $settings['location_link'] : ''; 
            $description = !empty($settings['description']) ? $settings['description'] : ''; 
            $question_form_id = !empty($settings['question_form']) ? $settings['question_form'] : '';
            if(!empty($title) || !empty($description) || !empty($question_form_id) || !empty($location) ){ ?>
            <div class="tk-main-section-two">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="tk-talkwith-professional">
                                <?php if( !empty($title) || !empty($description) || !empty($question_form_id) ){ ?>
                                    <li class="tk-talkwith-professional_content">
                                        <?php if( !empty($title) ){?>
                                            <h4><?php echo esc_html($title)?></h4>
                                        <?php } ?>
                                        <?php if( !empty($description) ){?>
                                            <p><?php echo esc_html($description)?></p>
                                        <?php } ?>
                                        <?php if( !empty($question_form_id) ){?>
                                            <?php echo do_shortcode('[contact-form-7 id="' . $question_form_id . '"]'); ?>
                                        <?php } ?>
                                    </li> 
                                <?php } ?> 
                                <?php if( !empty($location) ){ ?>
                                    <li class="tk-talkwith-professional_map">
                                        <div class="tk-map">
                                            <?php echo do_shortcode( $location );?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
        }
    }
    Plugin::instance()->widgets_manager->register(new Taskup_talk_with_professional);
}
