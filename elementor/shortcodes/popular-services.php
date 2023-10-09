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

if (!class_exists('Taskbot_popular_services')) {
    class Taskbot_popular_services extends Widget_Base
    {
        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
            wp_enqueue_style('splide');
            wp_enqueue_script('splide');
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name(){
            return 'taskbot_element_popular_services';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title(){
            return esc_html__('Popular services v2', 'taskbot');
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
            $pages      = array();
            $categories = array();
            $list_types = array();

            if( function_exists('taskbot_search_list_type') ){
                $list_types	= taskbot_search_list_type();
            }

            if( function_exists('taskbot_elementor_get_taxonomies') ){
                $categories = taskbot_elementor_get_taxonomies('product', 'product_cat');
            }
            if( function_exists('taskbot_elementor_get_posts') ){
                $pages      = taskbot_elementor_get_posts(array('page'));
            }

            $pages      = !empty($pages) ? $pages : array();
            $categories = !empty($categories) ? $categories : array();


            if( isset($list_types['sellers_search_page']) ){
                unset($list_types['sellers_search_page']);
            }

            $defult_result  = !empty($taskbot_settings['search_result']) ? $taskbot_settings['search_result'] : 'sellers_search_page';
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
                'sub_title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Sub title', 'taskbot'),
                    'rows'          => 5,
                    'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'details',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Add details', 'taskbot'),
                    'rows'          => 5,
                    'description'   => esc_html__('Add details. leave it empty to hide.', 'taskbot'),
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

            $this->add_control(
                'btn_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Add button text', 'taskbot'),
                    'rows'          => 5,
                    'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'btn_link',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Select page', 'taskbot'),
                    'desc'          => esc_html__('Select page for button link.', 'taskbot'),
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
            $settings           = $this->get_settings_for_display();
            $flag 		        = rand(9999, 999999);
            $title              = !empty($settings['title']) ? $settings['title'] : '';
            $details            = !empty($settings['details']) ? $settings['details'] : '';
            $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $btn_text           = !empty($settings['btn_text']) ? $settings['btn_text'] : '';
            $btn_link           = !empty($settings['btn_link']) ? $settings['btn_link'] : '';
            $btn_link           = !empty($btn_link) ? get_page_link( $btn_link ) : '';
            $categories         = !empty($settings['product_categories']) ? $settings['product_categories'] : '';
            $search_result      = !empty($settings['search_option']) ? $settings['search_option'] : 'service_search_page';

            if( function_exists('taskbot_get_page_uri') ){
                $task_search_url    = !empty($search_result) ? taskbot_get_page_uri($search_result) : '';
            }
            ?>
            <div class="tk-popular-services tk-new-varient">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php if (!empty($title) || !empty($sub_title) || !empty($details) ) { ?>
                            <div class="col-lg-10 col-xl-8">
                                <div class="tk-main-title-holder text-center">
                                    <?php if(!empty($title) || !empty($sub_title) ){?>
                                        <div class="tk-maintitle">
                                            <?php do_action( 'taskbot_section_shaper_html' );?>
                                            <?php if(!empty($sub_title)){?>
                                                <h3><?php echo esc_html($sub_title)?></h3>
                                            <?php } ?>
                                            <?php if($title){?>
                                                <h2><?php echo esc_html($title)?></h2>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if( !empty($details) ){?>
                                        <div class="tk-main-details">
                                            <p><?php echo esc_html($details); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (is_array($categories) && !empty($categories)) { ?>
                            <div class="col-12">
                                <div id="tk-popularservices-<?php echo intval($flag);?>" class="splide tk-popularservices tk-sliderarrow">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <?php
                                            foreach ($categories as $category) {
                                                $term_detail        = get_term($category);
                                                $term_url           = get_term_link($term_detail);
                                                $thumbnail_id       = get_term_meta($category, 'thumbnail_id', true);
                                                $image              = !empty($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'full') : '';

                                                $task_cat_search_url    = '#';
                                                if(!empty($task_search_url)) {
                                                    $task_cat_search_url = !empty($term_detail->slug) ? add_query_arg('category', esc_attr($term_detail->slug), $task_search_url) : '';
                                                }

                                                $term_name  = !empty($term_detail->name) ? $term_detail->name : '';
                                                $term_count = !empty($term_detail->count) ? $term_detail->count : 0;
                                                $image_url  = !empty($image[0]) ? esc_url($image[0]) : taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/cat-placeholder.jpg');
                                                ?>
                                                <li class="splide__slide">
                                                    <div class="tk-popularitem">
                                                        <a href="<?php echo esc_url($task_cat_search_url); ?>">
                                                            <figure>
                                                                <?php if (!empty($image_url)) { ?>
                                                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_name); ?>">
                                                                <?php } ?>
                                                                <?php if (!empty($term_name) || !empty($term_count)) { ?>
                                                                    <figcaption class="tk-servicesdesp">
                                                                        <div class="tk-categories_icon">
                                                                            <i class="tb-icon-plus"></i>
                                                                        </div>
                                                                        <div class="tk-categories_title">
                                                                            <?php if (!empty($term_name)) { ?>
                                                                                <h4><?php echo esc_html($term_name); ?></h4>
                                                                            <?php } ?>
                                                                            <?php if (isset($term_count)) { ?>
                                                                                <h6><?php echo sprintf(esc_html__('%s Listings', 'taskbot'),$term_count); ?></h6>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </figcaption>
                                                                <?php } ?>
                                                            </figure>
                                                        </a>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if( !empty($btn_text) ){?>
                            <div class="col-12">
                                <div class="tk-btn2-wrapper">
                                    <a href="<?php echo esc_url($btn_link);?>" class="tk-sectionbtn"><?php echo esc_html($btn_text);?> <i class="tb-icon-grid"></i></a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
            if( !empty($categories) ){
                $script = '
                    jQuery(document).ready(function () {
                        var tk_popularservices = document.getElementById("tk-popularservices-'.esc_js($flag).'");
                        if (tk_popularservices != null) {
                            var splide = new Splide("#tk-popularservices-'.esc_js($flag).'", {
                                type   : "loop",
                                perPage: 5,
                                perMove: 1,
                                arrows:true,
                                pagination: false,
                                gap: 24,
                                breakpoints: {
                                    1399: {
                                        perPage: 4,
                                    },
                                    1199: {
                                        perPage: 3,
                                    },
                                    991: {
                                        perPage: 3,
                                    },
                                    767: {
                                        perPage: 2,
                                    },
                                    480: {
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

    Plugin::instance()->widgets_manager->register(new Taskbot_popular_services);
}
