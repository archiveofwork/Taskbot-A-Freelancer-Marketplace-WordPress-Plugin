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

if (!class_exists('Taskbot_popular_categories')) {
    class Taskbot_popular_categories extends Widget_Base
    {

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name(){
            return 'taskbot_element_popular_categories';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title(){
            return esc_html__('Popular categories', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon(){
            return 'eicon-theme-builder';
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      category of shortcode
         */
        public function get_categories(){
            return ['taskbot-elements'];
        }

        /**
         * Register category controls.
         * @since    1.0.0
         * @access   protected
         */
        protected function register_controls(){
            global $taskbot_settings;
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
            $pages      = taskbot_elementor_get_posts(array('page'));
            $pages      = !empty($pages) ? $pages : array();
            //Content
            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__('Content', 'taskbot'),
                    'tab'   => Controls_Manager::TAB_CONTENT,
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
                'separator',
                [
                    'type'          => Controls_Manager::SWITCHER,
                    'label'         => esc_html__('Separator', 'taskbot'),
                    'label_on'      => esc_html__( 'Show', 'taskbot' ),
                    'label_off'     => esc_html__( 'Hide', 'taskbot' ),
                    'return_value'  => 'yes',
                    'selectors' => [
                        '{{WRAPPER}} .tk-maintitle:after' => 'content: "";',
                    ],
                    'prefix_class' => 'tk-title-separator-',
                    'condition' => [
                        'title!' => ' ',
                    ],
                ]
            );

            $this->add_control(
                'subtitle',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Sub title', 'taskbot'),
                    'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
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

            $this->add_control(
                'template',
                [
                    'label' => esc_html__( 'Select view', 'taskbot' ),
                    'type'  => Controls_Manager::SELECT,
                    'default' => 'slider',
                    'options' => [
                        'slider' 	=> esc_html__('Slider', 'taskbot'),
                        'listing' 	=> esc_html__('Listing', 'taskbot'),
                        'listingv2' => esc_html__('Listing V2', 'taskbot'),
                    ],
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Categories  button text', 'taskbot'),
                    'description'   => esc_html__('Add Button text. leave it empty to hide.', 'taskbot'),
                ]
            );
            $this->add_control(
                'button_link',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Select page', 'taskbot'),
                    'desc'          => esc_html__('Select page for categories button URL.', 'taskbot'),
                    'options'       => $pages,
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
            $title              = !empty($settings['title']) ? $settings['title'] : '';
            $sub_title          = !empty($settings['subtitle']) ? $settings['subtitle'] : '';
            $description          = !empty($settings['description']) ? $settings['description'] : '';
            $button_text        = !empty($settings['button_text']) ? $settings['button_text'] : '';
            $button_link        = !empty($settings['button_link']) ? get_the_permalink($settings['button_link']) : '';
            $template           = !empty($settings['template']) ? $settings['template'] : 'slider';
            $categories         = !empty($settings['product_categories']) ? $settings['product_categories'] : '';
            $task_search_url    = !empty($taskbot_settings['tpl_service_search_page']) ? $taskbot_settings['tpl_service_search_page'] : '';
            $task_search_url    = !empty($task_search_url) ? get_the_permalink($task_search_url) : '';
            $flag 		        = rand(9999, 999999);
            $search_opt   = !empty($settings['search_option']) ? $settings['search_option'] : '';
            $search_result= '';
            if( function_exists('taskbot_get_page_uri')){
                $search_result	= !empty($search_opt) ? taskbot_get_page_uri($search_opt) : '';
            }

            ?>
            <div class="tk-popular-categories">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php if (!empty($title) || !empty($sub_title) || !empty($description)) { ?>
                            <div class="col-lg-7">
                                <div class="tk-main-title-holder text-center">
                                    <?php if (!empty($sub_title)) { ?>
                                        <div class="tk-subtitle">
                                            <h4><?php echo esc_html($sub_title); ?></h4>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($title)) { ?>
                                        <div class="tk-maintitle">
                                            <h2><?php echo esc_html($title); ?></h2>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($description)) { ?>
                                        <div class="tk-main-description">
                                            <p><?php echo esc_html($description); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (is_array($categories) && !empty($categories) && !empty($template) && $template == 'slider') {?>
                            <div class="col-12">
                                <div id="tk-popularservices-<?php echo intval($flag);?>" class="splide tk-exploreslidervtwo tk-sliderarrow">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <?php
                                            foreach ($categories as $category) {
                                                $term_detail        = get_term($category);
                                                $term_url           = get_term_link($term_detail);
                                                $thumbnail_id       = get_term_meta($category, 'thumbnail_id', true);
                                                $image              = !empty($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'taskbot_task_shortcode_thumbnail') : '';

                                                $task_cat_search_url    = '#';
                                                if(!empty($task_search_url)) {
                                                    $task_cat_search_url = !empty($term_detail->slug) ? add_query_arg('category', esc_attr($term_detail->slug), $task_search_url) : '';
                                                }

                                                $term_name  = !empty($term_detail->name) ? $term_detail->name : '';
                                                $term_count = !empty($term_detail->count) ? $term_detail->count : 0;
                                                $image_url  = !empty($image[0]) ? esc_url($image[0]) : taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/cat-placeholder.jpg');
                                                ?>
                                                <li class="splide__slide">
                                                    <div class="tk-bestservice tk-bestservicevtwo">
                                                        <?php if (!empty($image_url)) { ?>
                                                            <figure class="tk-cards__img">
                                                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_name); ?>">
                                                            </figure>
                                                        <?php } ?>
                                                        <?php if (!empty($term_name) || !empty($term_count)) { ?>
                                                            <div class="tk-servicesabout text-center">
                                                                <?php if (!empty($term_name)) { ?>
                                                                    <h5><a href="<?php echo esc_url($task_cat_search_url); ?>"><?php echo esc_html($term_name); ?></a></h5>
                                                                <?php } ?>
                                                                <?php if (isset($term_count)) { ?>
                                                                    <span><?php echo sprintf(esc_html__('%s Listings', 'taskbot'),$term_count); ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php if( !empty($button_text) ){?>
                                    <div class="tk-btn-wrapper">
                                        <a href="<?php echo esc_url($button_link);?>" class="tk-btn-line-lg tk-btn-plain"><?php echo esc_html($button_text);?> <i class="tb-icon-chevron-right"></i></a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }else if (is_array($categories) && !empty($categories) && !empty($template) && $template == 'listingv2') {?>
                            <div class="col-12">
                                <div class="tk-category_list">
                                    <ul>
                                        <?php
                                        foreach ($categories as $category) {
                                            $term_detail        = get_term($category);
                                            $term_url           = get_term_link($term_detail);
                                            $thumbnail_id       = get_term_meta($category, 'thumbnail_id', true);
                                            $image              = !empty($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'taskbot_task_shortcode_thumbnail') : '';

                                            $task_cat_search_url    = '#';
                                            if(!empty($task_search_url)) {
                                                $task_cat_search_url = !empty($term_detail->slug) ? add_query_arg('category', esc_attr($term_detail->slug), $task_search_url) : '';
                                            }

                                            $term_name  = !empty($term_detail->name) ? $term_detail->name : '';
                                            $term_count = !empty($term_detail->count) ? $term_detail->count : 0;
                                            $image_url  = !empty($image[0]) ? esc_url($image[0]) : taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/cat-placeholder.jpg');
                                            ?>
                                            <li class="tk-category_item">
                                                <div class="tk-bestservice tk-bestservicevtwo">
                                                    <?php if (!empty($image_url)) { ?>
                                                        <figure class="tk-cards__img">
                                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_name); ?>">
                                                        </figure>
                                                    <?php } ?>
                                                    <?php if (!empty($term_name) || !empty($term_count)) { ?>
                                                        <div class="tk-servicesabout text-center">
                                                            <?php if (!empty($term_name)) { ?>
                                                                <h5><a href="<?php echo esc_url($task_cat_search_url); ?>"><?php echo esc_html($term_name); ?></a></h5>
                                                            <?php } ?>
                                                            <?php if (isset($term_count)) { ?>
                                                                <span><?php echo sprintf(esc_html__('%s Listings', 'taskbot'),$term_count); ?></span>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <?php if( !empty($button_text) ){?>
                                            <div class="tk-btn-wrapper">
                                                <a href="<?php echo esc_url($button_link);?>" class="tk-btn-line-lg tk-btn-plain"><?php echo esc_html($button_text);?> <i class="tb-icon-chevron-right"></i></a>
                                            </div>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php }elseif (is_array($categories) && !empty($categories) ){?>
                            <div class="col-lg-12">
                                <div class="tk-category_list">
                                    <ul>
                                        <?php
                                        foreach($categories as $category ){
                                            $parent_cat     = get_term( $category , 'product_cat' );
                                            $name           = !empty($parent_cat->name) ? $parent_cat->name : '';
                                            $thumbnail_id   = get_term_meta($category, 'thumbnail_id', true);
                                            $image          = !empty($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'taskbot_task_our_professional') : '';
                                            $image          = !empty($image[0]) ? $image[0] : '';
                                            $cat_search_url = '#';
                                            if(!empty($search_result)) {
                                                $cat_search_url = !empty($parent_cat->slug) ? add_query_arg('category', esc_attr($parent_cat->slug), $search_result) : '';
                                            }
                                            $child_arg              = array();
                                            $child_arg['child_of']  = $category;
                                            $child_arg['number']    = 3;
                                            $child_categories       = taskbot_elementor_get_taxonomies($post_type = 'product', $taxonomy = 'product_cat', $hide_empty = 0, $dataType = 'array',$child_arg);

                                            ?>
                                            <li class="tk-category_item">
                                                <?php if( !empty($image) ){?>
                                                    <figure class="tk-category_img">
                                                        <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($name);?>">
                                                    </figure>
                                                <?php } ?>
                                                <?php if( !empty($name) ){?>
                                                    <div class="tk-category_info">
                                                        <h5><a href="<?php echo esc_url($cat_search_url);?>"><?php echo esc_html($name);?></a></h5>
                                                    </div>
                                                <?php } ?>
                                                <?php if( !empty($child_categories) ){ ?>
                                                    <ul class="tk-category_childlist">
                                                        <?php
                                                        foreach($child_categories as $child_cat){
                                                            $count_items    = !empty($child_cat->count) ? intval($child_cat->count) : 0;
                                                            $child_name     = !empty($child_cat->name) ? esc_attr($child_cat->name) : '';
                                                            $sub_cat_url    = '';
                                                            if( !empty($cat_search_url) && $search_opt === 'service_search_page' ){
                                                                $sub_cat_url = !empty($child_cat->slug) ? add_query_arg('sub_category', esc_attr($child_cat->slug), $cat_search_url) : '';
                                                            } else {
                                                                $sub_cat_url = !empty($child_cat->slug) ? add_query_arg('category', esc_attr($child_cat->slug), $search_result) : '';
                                                            }

                                                            if( !empty($child_cat) ){ ?>
                                                                <li>
                                                                    <a href="<?php echo esc_url($sub_cat_url);?>">
                                                                        <?php if( !empty($child_name) ){?>
                                                                            <span><?php echo esc_html($child_name);?></span>
                                                                        <?php } ?>
                                                                        <?php if( !empty($count_items) ){?>
                                                                            <em>(<?php echo intval($count_items);?>)</em>
                                                                        <?php } ?>
                                                                        <i class="tb-icon-chevron-right"></i>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <li class="tk-explore-features">
                                                            <strong>
                                                                <a href="<?php echo esc_url($cat_search_url);?>">
                                                                    <?php esc_html_e('Explore all','taskbot');?>
                                                                </a>
                                                            </strong>
                                                        </li>
                                                    </ul>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <?php if( !empty($button_text) ){?>
                                        <div class="tk-btn2-wrapper">
                                            <a href="<?php echo esc_url($button_link);?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo esc_html($button_text);?><i class="tb-icon-grid"></i></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php if( !empty($categories) && !empty($template) && $template == 'slider' ){
                $script = '
                    jQuery(document).ready(function () {
                        var tk_popularservices = document.getElementById("tk-popularservices-'.esc_js($flag).'");
                        if (tk_popularservices != null) {
                            var splide = new Splide("#tk-popularservices-'.esc_js($flag).'", {
                                type   : "loop",
                                perPage: 4,
                                perMove: 1,
                                arrows:true,
                                pagination: false,
                                gap: 24,
                                breakpoints: {
                                    1399: {
                                        perPage: 3,
                                    },
                                    1199: {
                                        perPage: 3,
                                    },
                                    991: {
                                        perPage: 2,
                                    },
                                    767: {
                                        perPage: 1,
                                        gap:0,
                                    },
                                }
                            });
                            splide.mount();
                        }
                    });';
                wp_add_inline_script('splide', $script, 'after');
            }
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskbot_popular_categories);
}
