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

if (!class_exists('Taskup_home_banner_v1')) {
    class Taskup_home_banner_v1 extends Widget_Base
    {
        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
            wp_enqueue_style( 'splide' );
            wp_enqueue_style('venobox');
            wp_enqueue_style('select2');
            wp_enqueue_script('venobox');
            wp_enqueue_script('select2');
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_home_banner_v1';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Search banner v1', 'taskbot');
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
                'heading',
                [
                    'label'         => esc_html__('Heading', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::WYSIWYG,
                    'placeholder'   => esc_html__('Type your title here.', 'taskbot'),
                    'description'   => esc_html__('Add title text. leave it empty to hide.', 'taskbot'),

                ]
            );

            $this->add_control(
                'description',
                [
                    'label'         => esc_html__('Description', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::TEXTAREA,
                    'placeholder'   => esc_html__('Add description', 'taskbot'),
                    'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),

                ]
            );   

            $this->add_control(
                'bottom_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Bottom description', 'taskbot'),
                    'description'   => esc_html__('leave it empty. to hide it.', 'taskbot'),
                ]
            );

            $this->add_control(
                'video_link',
                [
                    'label' => esc_html__( 'Video link', 'taskbot' ),
                    'type' => \Elementor\Controls_Manager::TEXT
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
            $flag                       = rand(99, 9999);
            $list_types                 = array();
            $heading                    = !empty($settings['heading']) ? $settings['heading'] : '';
            $description                = !empty($settings['description']) ? $settings['description'] : '';
            $bottom_text                = !empty($settings['bottom_text']) ? $settings['bottom_text'] : '';
            $video_link                 = !empty($settings['video_link']) ? $settings['video_link'] : '';
            $product_categories         = !empty($settings['post_categories']) ? $settings['post_categories'] : array();
            $search_result              = !empty($settings['search_option']) ? $settings['search_option'] : 'service_search_page';
            if( function_exists('taskbot_get_page_uri')){
                $task_search_url            = !empty($search_result) ? taskbot_get_page_uri($search_result) : '';
            }
            
            if( function_exists('taskbot_search_list_type')){
                $list_types		= taskbot_search_list_type();
            }

            $search_result  = !empty($taskbot_settings['search_result']) ? $taskbot_settings['search_result'] : '';
            if( function_exists('taskbot_get_page_uri')){
                $search_result	= !empty($search_result) ? taskbot_get_page_uri($search_result) : '';
            }

            ?>
            <div class="tk-bannerv3">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 col-xxl-8">
                            <?php if(!empty($heading) || !empty($description)){ ?>
                                <div class="tk-bannerv3_title">
                                    <?php echo do_shortcode($heading); ?>
                                    <?php if(!empty($description)){?>
                                        <p><?php echo esc_html($description)?></p>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <form id="tk-index-task-search-form-<?php echo intval($flag);?>" action="<?php echo esc_url($search_result);?>" method="GET" class="tk-themeform tk-formsearch">
                                <fieldset>
                                    <div class="tk-fc-wrap">
                                        <label class="tk-themeform_title"><?php esc_html_e('What are you looking for?','taskbot')?></label>
                                        <div class="tk-inputicon">
                                            <i class="tb-icon-search"></i>
                                            <input type="text" class="form-control" name="keyword" placeholder="<?php esc_attr_e('Search with keyword','taskbot')?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <?php if(!empty($list_types)){?>
                                        <div class="tk-fc-wrap">
                                            <label class="tk-themeform_title"><?php esc_html_e('Search only in')?></label>
                                            <div class=" tk-inputicon">
                                                <div class="tk-select">
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
                                        </div>
                                    <?php } ?>
                                    <div class="form-group tk-search-btn">
                                        <a href="javascript:void(0);"  id="tk-index-task-btn-<?php echo intval($flag);?>"class="tk-btn-solid-lg tk-btn-yellow"><?php esc_html_e('Search now','taskbot')?> <i class="tb-icon-search"></i></a>
                                    </div>
                                </fieldset>
                            </form>
                            <?php if(!empty($bottom_text)){?>
                                <div class="tk-playbtn">
                                    <a class="tk-themegallery vbox-item tb-venobox-<?php echo intval($flag);?>" data-vbtype="video" href="<?php echo esc_url($video_link)?>" data-autoplay="true">
                                        <i class="tb-icon-play"></i></a>
                                    <h6><?php echo esc_html($bottom_text)?></h6>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if(!empty($product_categories)){?>
                            <div class="col-xl-12">
                                <div class="tk-categorys">
                                    <div id="tk-categoryslider-<?php echo intval($flag);?>" class="splide tk-categoryslider tk-splidearrow">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                            <?php if (is_array($product_categories) && !empty($product_categories) && class_exists('WooCommerce')) {
                                                foreach($product_categories as $category){
                                                    $term_detail   = get_term($category);
                                                    if( !empty($term_detail) ){
                                                        $term_name     = !empty($term_detail->name) ? $term_detail->name : '';
                                                        $term_count    = !empty($term_detail->count) ? $term_detail->count : 0;
                                                        $thumbnail_id  = get_term_meta($term_detail->term_id, 'thumbnail_id', true );
                                                        $image         = !empty($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'taskbot_icon_thumbnail') : '';
                                                        $image_url     = !empty($image[0]) ? esc_url($image[0]) : taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/cat-placeholder.jpg');
                                                        
                                                        if(!empty($task_search_url)){
                                                            $task_search_url = add_query_arg('category', esc_attr($term_detail->slug), $task_search_url);
                                                        }
                                                        if(!empty($term_name)){?>
                                                            <li class="splide__slide">
                                                                <div class="tk-categorys_item">
                                                                    <figure class="tk-categorys_img">
                                                                        <img src="<?php echo esc_url($image_url)?>" alt="<?php echo esc_attr($term_name)?>">
                                                                    </figure>
                                                                    <div class="tk-categorys_info">
                                                                        <h6>
                                                                            <a href="<?php echo esc_url($task_search_url)?>"><?php echo esc_html($term_name) ?>
                                                                                <span><?php echo sprintf(esc_html__('%s Listings', 'taskbot'),$term_count); ?></span>
                                                                            </a>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php
                                                        }
                                                    } 
                                                }
                                            }  ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
            if( !empty($list_types) ){
                $scripts	= "
                jQuery(function () {
                    jQuery('#tk-list-type-".esc_js($flag)."').select2({
                       theme: 'default tk-select2-dropdown'
                    });
                    jQuery(document).on('click','#tk-index-task-btn-".esc_js($flag)."',function(e){
                        jQuery('#tk-index-task-search-form-" . esc_js($flag) . "').submit();
                    });

                    jQuery(document).on('change','#tk-list-type-" . esc_js($flag) . "',function(e){
                        e.preventDefault();
                        let url_link    = jQuery(this).find(':selected').attr('data-url');
                        jQuery('#tk-index-task-search-form-" . esc_js($flag) . "').attr('action', url_link);
                
                    });           
                });";
                wp_add_inline_script('taskbot', $scripts, 'after');
            }
            if( !empty($categories) ){
                $is_rtl = false;
                if( function_exists('taskbot_splide_rtl_check') ){
                    $is_rtl = taskbot_splide_rtl_check();
                }
                $script = '
                jQuery(document).ready(function () {
                    var tk_popularservices = document.getElementById("tk-categoryslider-'.esc_js($flag).'");
                    if (tk_popularservices != null) {
                        var splide = new Splide("#tk-categoryslider-'.esc_js($flag).'", {
                            type        : "loop",
                            direction   : "'.esc_js($is_rtl).'",
                            perPage: 6,
                            perMove: 1,
                            updateOnMove: true,
                            pagination: false,
                            breakpoints: {
                              1400: {
                                perPage: 4,
                                gap: 30,
                              },
                              991: {
                                perPage: 3,
                                gap: 30,
                              },
                              767: {
                                perPage: 2,
                                gap: 30,
                              },
                              575: {
                                perPage: 2,
                                gap: 30,
                                arrows: false,
                                pagination: true,
                                
                              },
                              480: {
                                perPage: 1,
                                arrows: false,
                                pagination: true,
                              },
                            },
                        });
                        splide.mount();
                    }
                });';
                wp_add_inline_script('splide', $script, 'after');
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
    Plugin::instance()->widgets_manager->register(new Taskup_home_banner_v1);
}
