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
            return esc_html__('Popular services', 'taskbot');
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
            $categories = taskbot_elementor_get_taxonomies('product', 'product_cat');
            $categories = !empty($categories) ? $categories : array();
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
                'sub_title',
                [
                    'type'          => Controls_Manager::TEXTAREA,
                    'label'         => esc_html__('Sub title', 'taskbot'),
                    'rows'          => 5,
                    'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
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
            $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $categories         = !empty($settings['product_categories']) ? $settings['product_categories'] : '';
            $task_search_url    = !empty($taskbot_settings['tpl_service_search_page']) ? $taskbot_settings['tpl_service_search_page'] : '';
            $task_search_url    = !empty($task_search_url) ? get_the_permalink($task_search_url) : '';
            $flag 		        = rand(9999, 999999);
            ?>
            <div class="tk-popular-services">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php if (!empty($title) || !empty($sub_title)) { ?>
                            <div class="col-lg-7">
                                <div class="tk-main-title-holder text-center">
                                    <?php if (!empty($title)) { ?>
                                        <div class="tk-maintitle">
                                            <h2><?php echo esc_html($title); ?></h2>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($sub_title)) { ?>
                                        <div class="tk-main-description">
                                            <p><?php echo esc_html($sub_title); ?></p>
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
                                                        $task_cat_search_url = !empty($term_detail->term_id) ? add_query_arg('taskbot_service[category]', intval($term_detail->term_id), $task_search_url) : '';
                                                    }

                                                    $term_name  = !empty($term_detail->name) ? $term_detail->name : '';
                                                    $term_count = !empty($term_detail->count) ? $term_detail->count : 0;
                                                    $image_url  = !empty($image[0]) ? esc_url($image[0]) : taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/cat-placeholder.jpg');
                                                    ?>
                                                    <li class="splide__slide">
                                                        <div class="tk-popularitem">
                                                            <figure>
                                                                <?php if (!empty($image_url)) { ?>
                                                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_name); ?>">
                                                                <?php } ?>
                                                                <?php if (!empty($term_name) || !empty($term_count)) { ?>
                                                                    <figcaption class="tk-servicesdesp">
                                                                        <?php if (!empty($term_name)) { ?>
                                                                            <h4><a href="<?php echo esc_url($task_cat_search_url); ?>"><?php echo esc_html($term_name); ?></a></h4>
                                                                        <?php } ?>
                                                                        <?php if (isset($term_count)) { ?>
                                                                            <h6><?php echo sprintf(esc_html__('%s Listings', 'taskbot'),$term_count); ?></h6>
                                                                        <?php } ?>
                                                                    </figcaption>
                                                                <?php } ?>
                                                            </figure>
                                                        </div>
                                                    </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
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

        Plugin::instance()->widgets_manager->register(new Taskbot_popular_services);
    }
