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

if (!class_exists('Taskup_home_banner_v4')) {
    class Taskup_home_banner_v4 extends Widget_Base
    {
        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
            wp_enqueue_style('swiper');
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_home_banner_v2';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Search banner v2', 'taskbot');
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
            $this->start_controls_section(
                'content_section',
                [
                    'label'     => esc_html__('Content', 'taskbot'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'image',
                [
                    'type'        => Controls_Manager::MEDIA,
                    'label'       => esc_html__('image', 'taskbot'),
                    'description' => esc_html__('Add an image or leave it empty to hide.', 'taskbot'),
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
                'search_input',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Search placeholder', 'taskbot'),
                    'placeholder'   => esc_html__('Add search placeholder here.', 'taskbot'),
                    'description'   => esc_html__('Add search input placeholder or leave it empty to hide.', 'taskbot'),
                ]
            );
            $this->add_control(
                'search_button_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Search button text', 'taskbot'),
                    'placeholder'   => esc_html__('Add search button text here.', 'taskbot'),
                    'description'   => esc_html__('leave it empty. to hide it.', 'taskbot'),
                ]
            );
            $this->add_control(
                'video_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Video description', 'taskbot'),
                    'placeholder'   => esc_html__('Add video description here.', 'taskbot'),
                    'description'   => esc_html__('leave it empty. to hide it.', 'taskbot'),
                ]
            );
            $this->add_control(
                'video_link',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Video URL', 'taskbot'),
                    'placeholder'   => esc_html__('Add video URL here.', 'taskbot'),
                    'description'   => esc_html__('leave it empty. to hide it.', 'taskbot'),
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
            $settings                   = $this->get_settings_for_display();
            $heading_text               = !empty($settings['heading_text']) ? $settings['heading_text'] : '';
            $search_input               = !empty($settings['search_input']) ? $settings['search_input'] : '';
            $image                      = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
            $search_button_text         = !empty($settings['search_button_text']) ? $settings['search_button_text'] : '';
            $video_text                 = !empty($settings['video_text']) ? $settings['video_text'] : '';
            $video_link                 = !empty($settings['video_link']) ? $settings['video_link'] : '';
            
            $flag                       = rand(99, 9999);
            $list_types                 = array();
            if( function_exists('taskbot_search_list_type') ){
                $list_types		            = taskbot_search_list_type();
            }
            $search_result	            = !empty($taskbot_settings['search_result']) ? $taskbot_settings['search_result'] : 0;
            if( function_exists('taskbot_get_page_uri')){
                $search_result	= !empty($search_result) ? taskbot_get_page_uri($search_result) : '';
            }
            
            ?>
        	<div class="tk-bannerv3 tk-bannerv4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-9 col-xxl-7">
                            <div class="tk-bannercontent">
                                <?php if(!empty($heading_text)){?>
                                    <div class="tk-bannerv3_title">
                                        <?php if(!empty($heading_text)){?>
                                             <?php echo do_shortcode($heading_text); ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if( !empty($list_types) && !empty($search_button_text) ){ ?>
                                    <div class="tk-bannerform">
                                        <form id="tk-index-search-<?php echo intval($flag);?>" action="<?php echo esc_url($search_result);?>" method="GET" class="tk-formsearch">
                                            <fieldset>
                                                <div class="tk-fc-wrap">
                                                    <div class="tk-inputicon">
                                                        <i class="tb-icon-search"></i>
                                                        <input type="text" class="form-control" name="keyword" placeholder="<?php echo esc_attr($search_input)?>" autocomplete="off">
                                                    </div>
                                                </div>
                                                <?php if( !empty($list_types) ){ ?>
                                                    <div class="tk-fc-wrap">
                                                        <div class=" tk-inputicon">
                                                            <div class="tk-select">
                                                                <i class="tb-icon-layers"></i>
                                                                <select id="tk-list-type-<?php echo intval($flag);?>" data-placeholderinput="<?php esc_attr_e('Select list','taskbot');?>" data-placeholder="<?php esc_attr_e('Select list type','taskbot');?>" class="form-control tk-input-field select2-hidden-accessible tk-select-category">
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
                                                                    }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if( !empty($search_button_text) ){?>
                                                    <div class="form-group tk-search-btn">
                                                        <a href="javascript:void(0);" id="tk-btn-<?php echo intval($flag);?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo esc_html($search_button_text)?><i class="tb-icon-search"></i></a>
                                                    </div>
                                                <?php } ?>
                                            </fieldset>
                                        </form>
                                    </div>
                                <?php } ?>
                                <?php if(!empty($video_text) || !empty($video_link)){?>
                                    <div class="tk-playbtn">
                                        <?php if(!empty($video_link)){ ?>
                                            <a class="tk-themegallery vbox-item tb-venobox-<?php echo intval($flag);?>" data-vbtype="video" href="<?php echo esc_url($video_link)?>" data-autoplay="true">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        <?php } ?>
                                        <?php if(!empty($video_text)){?>
                                            <h6><?php echo esc_html($video_text)?></h6>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if(!empty($image)){?>
                            <div class="col-xxl-5 d-none d-xxl-block">
                                <figure class="tk-banner-img">
                                    <img src="<?php echo esc_url($image)?>" alt="<?php esc_attr_e('Search banner','taskbot')?> ">
                                </figure>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="tk-overlay"></div>
            <?php
            if( !empty($list_types) ){
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
                
                    })              
                });";
                wp_add_inline_script('taskbot', $scripts, 'after');
            }

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
    Plugin::instance()->widgets_manager->register(new Taskup_home_banner_v4);
}
