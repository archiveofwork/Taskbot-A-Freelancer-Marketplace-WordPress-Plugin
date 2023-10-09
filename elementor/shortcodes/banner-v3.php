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

if (!class_exists('Taskup_right_search_banner')) {
    class Taskup_right_search_banner extends Widget_Base
    {
        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
            wp_enqueue_style('nouislider');
            wp_enqueue_script('nouislider');
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_right_search_banner';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Banner search form right', 'taskbot');
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
            $list_types     = array();

            if( function_exists('taskbot_elementor_get_posts') ){
                $posts = taskbot_elementor_get_posts(array('page'));
            }
            
            if( function_exists('taskbot_search_list_type') ){
                $list_types = taskbot_search_list_type();
            }

            $defult_result  = !empty($taskbot_settings['search_result']) ? $taskbot_settings['search_result'] : 'sellers_search_page';
            $this->start_controls_section(
                'content_section',
                [
                    'label'     => esc_html__('Content', 'taskbot'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
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
                'counter_option',
                [
                    'label'     => esc_html__('Add counter option', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'          => 'heading_text',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Heading', 'taskbot'),
                            'description'   => esc_html__('Add text. leave it empty to hide.', 'taskbot')
                        ],
                        [
                            'name'          => 'heading_content',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Content', 'taskbot'),
                            'description'   => esc_html__('Add content. leave it empty to hide.', 'taskbot')
                        ]
                    ]
                ]
            );
            $this->add_control(
                'form_title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Form title', 'taskbot'),
                    'placeholder'   => esc_html__('Add form title here.', 'taskbot')
                ]
            );
            $this->add_control(
                'form_content',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Form content', 'taskbot'),
                    'placeholder'   => esc_html__('Add form content here.', 'taskbot')
                ]
            );
            $this->add_control(
                'search_option',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Categories search page?', 'taskbot'),
                    'desc'          => esc_html__('Select categories search result page to display.', 'taskbot'),
                    'options'       => $list_types,
                    'default'       => $defult_result,
                    'multiple'      => false,
                    'label_block'   => true,
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
            $button_login_user  = !empty($settings['button_login_user']) ? $settings['button_login_user'] : '';
            $left_btn_text      = !empty($settings['left_btn_text']) ? $settings['left_btn_text'] : '';
            $right_btn_text     = !empty($settings['right_btn_text']) ? $settings['right_btn_text'] : '';
            $left_btn_link      = !empty($settings['left_btn_link']) ? get_the_permalink($settings['left_btn_link']) : '';
            $right_btn_link     = !empty($settings['right_btn_link']) ? get_the_permalink($settings['right_btn_link']) : '';
            $after_btn_text     = !empty($settings['after_btn_text']) ? $settings['after_btn_text'] : '';
            $form_title         = !empty($settings['form_title']) ? $settings['form_title'] : '';
            $form_content       = !empty($settings['form_content']) ? $settings['form_content'] : '';
            $counter_option     = !empty($settings['counter_option']) ? $settings['counter_option'] : array();
            $min_price          = !empty($taskbot_settings['min_search_price']) ? $taskbot_settings['min_search_price'] : 1;
            $max_price          = !empty($taskbot_settings['max_search_price']) ? $taskbot_settings['max_search_price'] : 5000;

            $show_button        = 'yes';
            if( !empty($button_login_user) && is_user_logged_in() && !current_user_can('administrator') ){
                $show_button    = '';
            }
            
            $search_option      = !empty($settings['search_option']) ? $settings['search_option'] : '';
            $flag               = rand(99, 9999);
            
            if( function_exists('taskbot_get_page_uri')){
                $search_result	= !empty($search_option) ? taskbot_get_page_uri($search_option) : '';
            }
            $list_types         = array();
            if( function_exists('taskbot_search_list_type') ){
                $list_types     = taskbot_search_list_type();
            }

            ?>
            <div class="tk-bannerv5 sc-bannerflat">
                <div class="container">
                    <div class="row align-content-center">
                        <div class="col-xl-7">
                            <div class="tk-banner-content">
                                <?php if( !empty($heading_text) ){?>
                                    <div class="tk-bannerv3_title">
                                        <?php echo do_shortcode( $heading_text );?>
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
                                <?php if( !empty($counter_option) ){?>
                                    <ul class="tk-counter">
                                        <?php 
                                            foreach($counter_option as $key => $val ){
                                                $title      = !empty($val['heading_text']) ? $val['heading_text'] : '';
                                                $content    = !empty($val['heading_content']) ? $val['heading_content'] : '';
                                                ?>
                                                <li>
                                                    <?php if( !empty($title) ){?>
                                                        <h4><?php echo esc_html($title);?></h4>
                                                    <?php  } ?>
                                                    <?php if( !empty($content) ){?>
                                                        <h6><?php echo esc_html($content);?></h6>
                                                    <?php } ?>
                                                </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="tk-talents-search">
                                <?php if( !empty($form_title) || !empty($form_content) ){?>
                                    <div class="tk-talents-search_title">
                                        <?php if( !empty($form_title) ){?>
                                            <h4><?php echo esc_html($form_title);?></h4>
                                        <?php } ?>
                                        <?php if( !empty($form_content) ){?>
                                            <p><?php echo esc_html($form_content);?></p>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <div class="tk-talents-search_content">
                                    <form id="tk-index-search-<?php echo intval($flag);?>" action="<?php echo esc_url($search_result);?>" method="GET" class="tk-themeform">
                                        <fieldset>
                                            <div class="tk-themeform__wrap">
                                                <div class="form-group">
                                                    <label class="tk-label"><?php esc_html_e('What are you looking for?','taskbot');?></label>
                                                    <div class="tk-inputicon">
                                                        <i class="tb-icon-search"></i>
                                                        <input type="text" class="form-control" name="keyword" placeholder="<?php esc_attr_e('Search with keyword','taskbot');?>" autocomplete="off">
                                                    </div>
                                                </div>
                                                <?php if( !empty($list_types) ){?>
                                                    <div class="form-group">
                                                        <label class="tk-label"><?php esc_html_e('Select search option','taskbot');?></label>
                                                        <div class="tk-select tk-selecthas-icon">
                                                            <i class="tb-icon-layers"></i>
                                                            <select id="tk-list-type-<?php echo intval($flag);?>" data-placeholderinput="<?php esc_attr_e('Select list','taskbot')?>" data-placeholder="<?php esc_attr_e('Select list type','taskbot')?> " class="form-control">
                                                                <option label="<?php esc_attr_e('Select search type','taskbot');?>"></option>
                                                                <?php 
                                                                    foreach($list_types as $key => $value){
                                                                        if( !empty($value)){
                                                                            $page_url	= '';
                                                                            if( function_exists('taskbot_get_page_uri') ){
                                                                                $page_url	= taskbot_get_page_uri($key);
                                                                            }
                                                                            ?>
                                                                            <option value="<?php echo esc_attr($key);?>" data-url="<?php echo esc_url($page_url);?>" ><?php echo esc_html($value);?></option>
                                                                    <?php }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <label class="tk-label"><?php esc_html_e('Set your budget range','taskbot');?></label>
                                                    <div class="tk-rangeslider-wrapper">
                                                        <div class="tk-distance">
                                                            <div id="tk-rangeslider-<?php echo intval($flag);?>" class="tk-rangeslider-two"></div>
                                                        </div>
                                                        <div class="tk-rangevalue">
                                                            <div class="tk-areasizebox">
                                                                <input type="number" class="form-control" name="min_price" min="<?php echo esc_attr($min_price);?>" max="<?php echo esc_attr($max_price);?>" step="1" placeholder="<?php esc_attr_e('Min price','taskbot');?>" id="tk-min-value-<?php echo intval($flag);?>" />
                                                                <input type="number" class="form-control" name="max_price" step="1" placeholder="<?php esc_attr_e('Max price','taskbot');?>" id="tk-max-value-<?php echo intval($flag);?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="tk-searchbtn">
                                                        <a href="javascript:void(0)" id="tk-btn-<?php echo esc_attr($flag);?>" class="tk-btn-solid-lg tk-btn-yellow"><?php esc_html_e('Search now','taskbot');?> <i class="tb-icon-search"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $scripts	= "
            jQuery(function () {
                jQuery('#tk-list-type-".esc_js($flag)."').select2({
                       theme: 'default tk-select2-dropdown'
                    });
                jQuery(document).on('click','#tk-btn-".esc_js($flag)."',function(e){
                    jQuery('#tk-index-search-" . esc_js($flag) . "').submit();
                });

                jQuery(document).on('change','#tk-list-type-" . esc_js($flag) . "',function(e){
                    e.preventDefault();
                    let url_link    = jQuery(this).find(':selected').attr('data-url');
                    jQuery('#tk-index-search-" . esc_js($flag) . "').attr('action', url_link);            
                });
                // range slider
                var stepsSlider = document.getElementById('tk-rangeslider-" . esc_js($flag) . "');
                if(stepsSlider !== null){
                    var input0 = document.getElementById('tk-min-value-" . esc_js($flag) . "');
                    var input1 = document.getElementById('tk-max-value-" . esc_js($flag) . "');
                    var inputs = [input0, input1];
                    noUiSlider.create(stepsSlider, {
                        start: [200, 400],
                        connect: true,
                        range: {
                        'min': 0,
                        'max': 600
                    },
                        format: {
                        to: (v) => parseFloat(v).toFixed(0),
                        from: (v) => parseFloat(v).toFixed(0),
                        suffix: ' (US $)'
                    },
                    });

                    stepsSlider.noUiSlider.on('update', function (values, handle) {
                        inputs[handle].value = values[handle];
                    });

                    // Listen to keydown events on the input field.
                    inputs.forEach(function (input, handle) {
                    input.addEventListener('change', function () {
                        stepsSlider.noUiSlider.setHandle(handle, this.value);
                    });
                    input.addEventListener('keydown', function (e) {
                        var values = stepsSlider.noUiSlider.get();
                        var value = Number(values[handle]);
                        var steps = stepsSlider.noUiSlider.steps();
                        var step = steps[handle];
                        var position;
                        switch (e.which) {
                        case 13:
                            stepsSlider.noUiSlider.setHandle(handle, this.value);
                            break;
                        case 38:
                            position = step[1];
                            // false = no step is set
                            if (position === false) {
                                position = 1;
                            }
                            if (position !== null) {
                                stepsSlider.noUiSlider.setHandle(handle, value + position);
                            }
                            break;
                        case 40:
                            position = step[0];
                            if (position === false) {
                                position = 1;
                            }
                            if (position !== null) {
                                stepsSlider.noUiSlider.setHandle(handle, value - position);
                            }
                            break;
                        }
                    });
                    });
                }
            });";
            wp_add_inline_script('taskbot', $scripts, 'after');
            
        }
    }
    Plugin::instance()->widgets_manager->register(new Taskup_right_search_banner);
}
