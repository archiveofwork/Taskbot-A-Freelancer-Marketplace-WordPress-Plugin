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

    if (!class_exists('Taskbot_Search_Shortcode')) {
        class Taskbot_Search_Shortcode extends Widget_Base
        {
            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_search';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Search form banner', 'taskbot');
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
                //Content
                $this->start_controls_section(
                    'content_section',
                    [
                        'label'     => esc_html__('Content', 'taskbot'),
                        'tab'       => Controls_Manager::TEXTAREA,
                    ]
                );

                $this->add_control(
                    'title',
                    [
                        'type'        => Controls_Manager::TEXTAREA,
                        'label'       => esc_html__('Section title', 'taskbot'),
                        'description' => esc_html__('Add text. leave it empty to hide.', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'placeholder_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Placeholder text', 'taskbot'),
                        'description'   => esc_html__('Add placeholder text. leave it empty to hide.', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'button_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Button text', 'taskbot'),
                        'description'   => esc_html__('Add Button text. leave it empty to hide.', 'taskbot'),
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
                $title              = !empty($settings['title']) ? $settings['title'] : '';
                $button_text        = !empty($settings['button_text']) ? $settings['button_text'] : '';
                $placeholder_text   = !empty($settings['placeholder_text']) ? $settings['placeholder_text'] : '';
                $flag               = rand(9999, 999999);

                $list_types		= taskbot_search_list_type();
                $search_result	= !empty($taskbot_settings['search_result']) ? $taskbot_settings['search_result'] : '';
                if( function_exists('taskbot_get_page_uri')){
                    $search_result	= !empty($search_result) ? taskbot_get_page_uri($search_result) : '';
                }

                $search_item	= !empty($taskbot_settings['hide_search_item']) ? $taskbot_settings['hide_search_item'] : '';
                $type_one	    = false;

                if( !empty($search_item) && count($search_item) <= 1  ){
                    if(!empty($search_item[0])){
                        $search_result	= taskbot_get_page_uri($search_item[0]);
                    }else{
                        $search_result	= taskbot_get_page_uri('sellers_search_page');
                    }
                    
                    $type_one	= true;
                }

                ?>
                <div class="tk-banner tk-search-wrapper">
                    <div class="tk-banner_contenttwo">
                        <div class="row">
                            <div class="col-md-12 col-lg-8">
                                <div class="tk-banner_title">
                                    <?php if( !empty($title) ){?>
                                        <h1><?php echo do_shortcode($title); ?></h1>
                                    <?php } ?>
                                    <div class = "tk-bannerinfo_search tk-appendinput">
                                        <form name="search_form" method="get" action="<?php echo esc_url($search_result); ?>" id="tk-header-form-<?php echo intval($flag);?>">
                                            <div class="tk-inputappend">
                                                <i class="icon-search"></i>
                                                <input type="text" name="keyword" class="form-control" placeholder="<?php echo esc_attr($placeholder_text); ?>">
                                                <?php if( !empty($search_item) && empty( $type_one ) ){?>
                                                    <div class="tk-select">
                                                        <i class="icon-layers"></i>
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
                                                <?php if( !empty($button_text) ){?>
                                                    <div class="tk-inputappend_right">
                                                        <button type="submit" class="tk-btn-solid-lg"><?php echo esc_html($button_text); ?></button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div
            <?php
            $script = '
                    jQuery(document).ready(function () {
                        jQuery("#tk-list-type-' . esc_js($flag) . '").select2({
                            minimumResultsForSearch: Infinity
                        });
                        jQuery(document).on("change","#tk-list-type-' . esc_js($flag) . '",function(e){
                            e.preventDefault();
                            let url_link    = jQuery(this).find(":selected").attr("data-url");
                            jQuery("#tk-header-form-' . esc_js($flag) . '").attr("action", url_link);
                    
                        });
                    })
                ';
                wp_add_inline_script('taskbot', $script, 'after');
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskbot_Search_Shortcode);
    }
