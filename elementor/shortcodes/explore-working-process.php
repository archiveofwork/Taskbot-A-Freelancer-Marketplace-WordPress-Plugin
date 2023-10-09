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

if (!class_exists('Taskup_working_process')) {
    class Taskup_working_process extends Widget_Base{

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_explore_working_process';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Working process', 'taskbot');
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
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('Sub title', 'taskbot'),
                    'placeholder' => esc_html__('Add sub title here', 'taskbot'),
                    'description' => esc_html__('Add sub title. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
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
                'layout_type',
                [
                    'type'      => Controls_Manager::SELECT2,
                    'label'     => esc_html__('layout type', 'taskbot'),
                    'desc'      => esc_html__('Select layout type', 'taskbot'),
                    'default'   => 'v1',
                    'options'   => [
                        'v1'   => esc_html__('V1', 'taskbot'),
                        'v2'   => esc_html__('V2', 'taskbot'),
                    ],
                ]
            );

            $this->add_control(
                'process',
                [
                    'label'     => esc_html__('Add option', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'          => 'icon',
                            'type'          => Controls_Manager::MEDIA,
                            'label'         => esc_html__('Upload icon image', 'taskbot'),
                            'description'   => esc_html__('Upload icon image. leave it empty to hide.', 'taskbot'),
                            'label_block'   => true,
                        ],  
                        [
                            'name'          => 'start_value',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Start value sign', 'taskbot'),
                            'description'   => esc_html__('Add sign or text. leave it empty to hide.', 'taskbot')
                        ],
                        [
                            'name'          => 'counter_value',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Counter value', 'taskbot'),
                            'description'   => esc_html__('Add counter value. leave it empty to hide.', 'taskbot')
                        ], 
                        [
                            'name'          => 'end_value',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('End text', 'taskbot'),
                            'description'   => esc_html__('Add counter end value or text. leave it empty to hide.', 'taskbot'),
                        ],
                        [
                            'name'          => 'description',
                            'type'          => Controls_Manager::TEXTAREA,
                            'label'         => esc_html__('Description', 'taskbot'),
                            'description'   => esc_html__('Description', 'taskbot'),
                        ]
                        ],
                        'condition' => [
                            'layout_type' => 'v1',
                        ],
                ]
            );
            $this->add_control(
                'steps',
                [
                    'label'     => esc_html__('Add option', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'          => 'icon',
                            'type'          => Controls_Manager::MEDIA,
                            'label'         => esc_html__('Upload icon image', 'taskbot'),
                            'description'   => esc_html__('Upload icon image. leave it empty to hide.', 'taskbot'),
                            'label_block'   => true,
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
                            'name'          => 'link_text',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Link text', 'taskbot'),
                            'description'   => esc_html__('Extra counter text', 'taskbot')
                        ],
                        [
                            'name'          => 'text_link_url',
                            'label'         => esc_html__( 'Add button link', 'taskbot' ),
                            'type'          => \Elementor\Controls_Manager::TEXT
                        ]
                    ],
                    'condition' => [
                        'layout_type' => 'v2',
                    ],
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
            $layout_type    = !empty($settings['layout_type']) ? $settings['layout_type'] : 'v1';
            $process        = !empty($settings['process']) ? $settings['process'] : array();
            $steps          = !empty($settings['steps']) ? $settings['steps'] : array();
            $flag           = rand(9999, 999999);
            ?>
            <div class="tk-process-section">
                <div class="container">
                    <?php if( !empty($title) || !empty($description) || !empty($sub_title) ){?>
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xl-8">
                                <?php if(!empty($title) || !empty($description) || !empty($sub_title) ){?>
                                    <div class="tk-main-title-holder text-center">
                                        <?php if(!empty($title) || !empty($sub_title) ){?>
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
                                        <?php if($description){?>
                                            <div class="tk-main-description">
                                                <p><?php echo esc_html($description) ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php  if( !empty($layout_type) && $layout_type === 'v1' && !empty($process)) {?>
                        <div class="row gy-4" id="tk-counter-two-<?php echo intval($flag);?>">
                            <?php 
                                foreach($process as $platform){
                                    $description    = !empty($platform['description']) ? $platform['description'] : '';
                                    $icon           = !empty($platform['icon']['url']) ? $platform['icon']['url'] : '';
                                    $counter_value  = !empty($platform['counter_value']) ? $platform['counter_value'] : '';
                                    $end_value      = !empty($platform['end_value']) ? $platform['end_value'] : '';
                                    $start_value    = !empty($platform['start_value']) ? $platform['start_value'] : '';
                                    ?>
                                    <div class="col-sm-6 col-xl-3">
                                        <div class="tk-working_process">
                                            <?php if( !empty($icon) ){?>
                                                <div class="tk-start-icon">
                                                    <img src="<?php echo esc_url($icon);?>" alt="<?php echo esc_attr($title);?>">
                                                </div>
                                            <?php } ?>
                                            <?php if( isset($counter_value) && $counter_value > 0 ) {?>
                                                <h3 class="tk-counter-value">
                                                    <?php 
                                                        if( !empty($start_value) ){
                                                            echo esc_html($start_value);
                                                        }
                                                    ?>
                                                    <span class="counter-value" data-count="<?php echo absint($counter_value); ?>"></span>
                                                    <?php 
                                                        if( !empty($end_value) ){
                                                            echo esc_html($end_value);
                                                        }
                                                    ?>
                                                </h3>
                                            <?php } ?>
                                            <?php if(!empty($description)){?>
                                                <strong><?php echo esc_html($description)?></strong>
                                            <?php } ?>
                                        </div>
                                    </div>
                            <?php }   ?>
                        </div>
                    <?php } else  if( !empty($layout_type) && $layout_type === 'v2' && !empty($steps)) { ?>
                        <div class="row gy-4">
                            <?php 
                                foreach($steps as $platform){
                                    $description    = !empty($platform['description']) ? $platform['description'] : '';
                                    $title          = !empty($platform['title']) ? $platform['title'] : '';
                                    $link_text      = !empty($platform['link_text']) ? $platform['link_text'] : '';
                                    $text_link_url  = !empty($platform['text_link_url']) ? $platform['text_link_url'] : '';
                                    $icon           = !empty($platform['icon']['url']) ? $platform['icon']['url'] : '';
                                    if( !empty($icon) || !empty($title) ||  !empty($description) || !empty($link_text) ){
                                    ?>
                                    <div class="col-md-6 col-xl-4">
                                        <div class="tk-working_process tk-wprocessvtwo">
                                            <?php if( !empty($icon) ){?>
                                                <div class="tk-start-icon">
                                                    <img src="<?php echo esc_url($icon);?>" alt="<?php echo esc_attr($title);?>">
                                                </div>
                                            <?php } ?>
                                            <?php if( !empty($title) ){?>
                                                <h4><?php echo esc_html( $title );?></h4>
                                            <?php } ?>
                                            <?php if( !empty($description) ){?>
                                                <p><?php echo esc_html($description);?></p>
                                            <?php } ?>
                                            <?php if( !empty($link_text) ){?>
                                                <a href="<?php echo esc_url($text_link_url);?>"><?php echo esc_html($link_text);?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php }?>
                </div>
            </div>
            <?php
                if( !empty($layout_type) && $layout_type === 'v1' && !empty($process) ) {
                    $script = "
                    jQuery(document).ready(function () {
                        var lo_counter = document.querySelector('#tk-counter-two-".esc_js($flag)."');
                        if( lo_counter !== null){
                            var counted = 0;
                            jQuery(window).scroll(function() {
                                var oTop = jQuery('.tk-counter-value').offset().top - window.innerHeight;
                                    if (counted == 0 && jQuery(window).scrollTop() > oTop) {
                                        jQuery('.counter-value').each(function() {
                                            var _this = jQuery(this),
                                            count_data = _this.attr('data-count');
                                            jQuery({ countNum: _this.text() }).animate({
                                                countNum: count_data
                                                },
                                                {
                                                    duration: 2000,
                                                    easing: 'swing',
                                                    step: function() {
                                                    _this.text(taskup_lo_commanumber(Math.floor(this.countNum)));
                                                },
                                                complete: function() {
                                                _this.text(taskup_lo_commanumber(this.countNum));
                                            }
                                        });
                                    });
                                    counted = 1;
                                }
                                function taskup_lo_commanumber(val) {
                                    while (/(\d+)(\d{3})/.test(val.toString())) {
                                        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
                                    }
                                    return val;
                                }
                            });
                        }
                    });";
                    wp_add_inline_script('taskbot', $script, 'after');
                }
            }
    }
    Plugin::instance()->widgets_manager->register(new Taskup_working_process);
}
