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

    if (!class_exists('Taskbot_search_banner_v2')) {
        class Taskbot_search_banner_v2 extends Widget_Base
        {

            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_search_banner_v2';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Search form v2', 'taskbot');
            }

            /**
            *
            * @since    1.0.0
            * @access   public
            * @var      icon
            */
            public function get_icon()
            {
                return 'eicon-search';
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
                $hide_cat       = !empty($taskbot_settings['hide_product_cat']) ? $taskbot_settings['hide_product_cat'] : array();
                $taskbot_args   = array(
                    'hide_empty'    => false,
                    'parent'        => 0
                );
                if( !empty($hide_cat) ){
                    $taskbot_args['exclude']    = $hide_cat;
                }
                $categories = taskbot_elementor_get_taxonomies('product', 'product_cat',$hide_empty = 0, $dataType = 'input',$taskbot_args);
                $categories = !empty($categories) ? $categories : array();

                //Content
                $this->start_controls_section(
                    'content_section',
                    [
                        'label'   => esc_html__('Content', 'taskbot'),
                        'tab'     => Controls_Manager::TAB_CONTENT,
                    ]
                );

                $this->add_control(
                    'title',
                    [
                        'type'          => Controls_Manager::TEXTAREA,
                        'label'         => esc_html__('Title', 'taskbot'),
                        'description'   => esc_html__('Add figure title. leave it empty to hide.', 'taskbot'), 'label_block' => true,
                    ]
                );

                $this->add_control(
                    'sub_title',
                    [
                        'type'          => Controls_Manager::TEXTAREA,
                        'label'         => esc_html__('Sub title', 'taskbot'),
                        'description'   => esc_html__('Add figure sub title. leave it empty to hide.', 'taskbot'),
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'description',
                    [
                        'type'          => Controls_Manager::TEXTAREA,
                        'label'         => esc_html__('Description', 'taskbot'),
                        'description'   => esc_html__('Add description here. leave it empty to hide.', 'taskbot'),
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'video_url',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Video link', 'taskbot'),
                        'description'   => esc_html__('Add url. leave it empty to hide.', 'taskbot'),
                        'label_block'   => true,
                    ]
                );
                $this->add_control(
                    'video_arrow_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Video arrow text', 'taskbot'),
                        'description'   => esc_html__('leave it empty to hide.', 'taskbot'),
                        'default'        => esc_html__('See how it work', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'product_categories',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Categories?', 'taskbot'),
                        'desc'          => esc_html__('Select categories to display.', 'taskbot'),
                        'options'       => $categories,
                        'multiple'      => true,
                        'label_block'   => true,
                    ]
                );

                $this->end_controls_section();
            }

            protected function render()
            {
                global $taskbot_settings;
                $settings           = $this->get_settings_for_display();
                $title              = !empty($settings['title']) ? $settings['title'] : '';
                $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
                $description        = !empty($settings['description']) ? $settings['description'] : '';
                $video_url          = !empty($settings['video_url']) ? $settings['video_url'] : '';
                $video_arrow_text   = !empty($settings['video_arrow_text']) ? $settings['video_arrow_text'] : '';
                $categories         = !empty($settings['product_categories']) ? $settings['product_categories'] : '';

                $flag               = rand(9999, 999999);

                $list_types		= taskbot_search_list_type();
                $search_result	= !empty($taskbot_settings['search_result']) ? $taskbot_settings['search_result'] : '';
                if( function_exists('taskbot_get_page_uri')){
                    $search_result	= !empty($search_result) ? taskbot_get_page_uri($search_result) : '';
                }

                $search_item	= !empty($taskbot_settings['hide_search_item']) ? $taskbot_settings['hide_search_item'] : '';
                $type_one	    = false;

                if( !empty($search_item) && is_array($search_item) && count($search_item) <= 1  ){
                    if(!empty($search_item[0])){
                        $search_result	= taskbot_get_page_uri($search_item[0]);
                    }else{
                        $search_result	= taskbot_get_page_uri('sellers_search_page');
                    }
                    
                    $type_one	= true;
                }
                ?>
                <div class="tk-bannervthree sc-search-formv2">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-12 col-xl-7">
                                <div class="tk-bannerinfo">
                                    <?php if (!empty($title) || !empty($sub_title) || !empty($description)) { ?>
                                        <div class="tk-bannerinfo_title">
                                            <?php if (!empty($title)) { ?><h4><?php echo esc_html($title); ?></h4><?php } ?>
                                            <?php if (!empty($sub_title)) { ?> <h1><?php echo do_shortcode($sub_title); ?></h1><?php } ?>
                                            <?php if (!empty($description)) { ?><p><?php echo esc_html($description); ?></p><?php } ?>
                                        </div>
                                    <?php } ?>
                                    <div class="tk-bannerinfo_search tk-appendinput">
                                        <form action="<?php echo esc_url($search_result);?>" method="GET" id="tk-header-form-<?php echo intval($flag);?>" class="tk-theme-form">
                                            <div class="tk-searcbar">
                                                <div class="tk-inputicon">
                                                    <span><i class="tb-icon-search"></i></span>
                                                    <input type="text" name="keyword" class="form-control" placeholder="<?php esc_attr_e('What are you looking for?','taskbot');?>">
                                                </div>
                                                <?php if( !empty($search_item) && empty( $type_one ) ){?>
                                                    <div class="tk-select">
                                                        <i class="tb-icon-layers"></i>
                                                        <select id="tk-list-type-<?php echo intval($flag);?>" data-placeholderinput="<?php esc_attr_e('Select list','taskbot');?>" data-placeholder="<?php esc_attr_e('Select list type','taskbot');?>" class="form-control">
                                                            <option label="<?php esc_attr_e('Select search type','taskbot');?>"></option>
                                                            <?php foreach($search_item as $key => $value){
                                                                if( !empty($value) ){
                                                                    $page_url	= '';
                                                                    if( function_exists('taskbot_get_page_uri') ){
                                                                        $page_url	= taskbot_get_page_uri($value);
                                                                    }

                                                                    $item_dsplay = !empty($list_types[$value]) ?  $list_types[$value] : $value;
                                                                    ?>
                                                                    <option value="<?php echo esc_attr($value);?>" data-url="<?php echo esc_url($page_url);?>" ><?php echo esc_html($item_dsplay);?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                <?php }else{?>
                                                    <input type="hidden" value="<?php echo esc_attr($search_result);?>">	
                                                <?php } ?>
                                                <input type="submit" class="tk-btn-solid tk-darkbtn" value="<?php esc_attr_e('Search now','taskbot');?>">
                                            </div>
                                        </form>
                                    </div>
                                    <?php if (is_array($categories) && !empty($categories)) {  ?>
                                        <div class="tk-bannerinfo_tag">
                                            <span><?php esc_html_e('Quick start:','taskbot');?></span>
                                            <ul class="tk-tagvtwo">
                                            <?php
                                                foreach ($categories as $category) {
                                                    $term_detail        = get_term($category);
                                                    if(!empty($term_detail)){
                                                        $task_cat_search_url    = '#';
                                                        if(!empty($search_result)) {
                                                            $task_cat_search_url = !empty($term_detail->term_id) ? add_query_arg('category', intval($term_detail->term_id), $search_result) : '';
                                                        }

                                                        $term_name  = !empty($term_detail->name) ? $term_detail->name : '';
                                                        ?>
                                                        <li><a href="<?php echo esc_url($task_cat_search_url)?>"><?php echo esc_html($term_name)?></a></li>
                                                <?php }} ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if (!empty($video_url)) { ?>
                                <div class="col-12 col-xl-5">
                                    <div class="tk-bannervideo">
                                        <a class="venobox venobox-<?php echo intval($flag); ?>" data-vbtype="video" href="<?php echo esc_html($video_url); ?>" data-autoplay="true">
                                            <i class="fas fa-play tk-playicon"></i>
                                        </a>
                                        <?php if( !empty($video_arrow_text) ){?>
                                        <span><?php echo esc_html($video_arrow_text);?><img src="<?php echo esc_url(TASKBOT_DIRECTORY_URI)?>public/images/arrow-img.png"></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            
                if (!empty($video_url)) {
                    $script_video = '
                        jQuery(document).ready(function () {
                            jQuery("#tk-list-type-' . esc_js($flag) . '").select2({
                                theme: "default tk-select2-dropdown",
                                minimumResultsForSearch: Infinity
                            });
                            jQuery(document).on("change","#tk-list-type-' . esc_js($flag) . '",function(e){
                                e.preventDefault();
                                let url_link    = jQuery(this).find(":selected").attr("data-url");
                                jQuery("#tk-header-form-' . esc_js($flag) . '").attr("action", url_link);
                        
                            });
                            let venobox = document.querySelector(".venobox-' . esc_js($flag) . '");
                            if (venobox !== null) {
                                jQuery(".venobox-' . esc_js($flag) . '").venobox({
                                    spinner : "cube-grid",
                                });
                            }
                        })
                    ';
                    wp_add_inline_script('venobox', $script_video, 'after');
                }
        
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskbot_search_banner_v2);
    }
