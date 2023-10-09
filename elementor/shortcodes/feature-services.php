<?php
    /**
     * Services sliders
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

    if (!class_exists('Taskup_Feature_Services_Slider')) {
        class Taskup_Feature_Services_Slider extends Widget_Base
        {
            public function __construct($data = [], $args = null) {
                parent::__construct($data, $args);
                wp_enqueue_style('swiper');
                wp_enqueue_script('swiper');
            }
            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskup_element_feature_services_slider';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Featured services slider', 'taskbot');
            }

            /**
            *
            * @since    1.0.0
            * @access   public
            * @var      icon
            */
            public function get_icon()
            {
                return 'eicon-person';
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
                $pages      = array();
                $categories = array();

                if( function_exists('taskbot_elementor_get_taxonomies') ){
                    $categories = taskbot_elementor_get_taxonomies('product', 'product_cat');
                }
                if( function_exists('taskbot_elementor_get_taxonomies') ){
                    $pages  = taskbot_elementor_get_posts(array('page'));
                }

                $categories = !empty($categories) ? $categories : array();
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
                        'placeholder' => esc_html__('Type your title here', 'taskbot'),
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
                        'type'          => Controls_Manager::TEXTAREA,
                        'label'         => esc_html__('Sub title', 'taskbot'),
                        'placeholder'   => esc_html__('Type your sub title here', 'taskbot'),
                        'rows'          => 5,
                        'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                    ]
                );

                $this->add_control(
                    'description',
                    [
                        'type'          => Controls_Manager::TEXTAREA,
                        'label'         => esc_html__('Description', 'taskbot'),
                        'placeholder'   => esc_html__('Type your description here', 'taskbot'),
                        'rows'          => 5,
                        'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                    ]
                );
    
                $this->add_control(
                    'listing_type',
                    [
                        'type'      	=> Controls_Manager::SELECT,
                        'label' 		=> esc_html__('Show services by', 'taskbot'),
                        'description' 	=> esc_html__('Select type to list services by categories or specific', 'taskbot'),
                        'default' 		=> '',
                        'options' 		=> [
                            '' 			=> esc_html__('Select services listing type', 'taskbot'),
                            'rating' 	=> esc_html__('Order by rating', 'taskbot'),
                            'random' 	=> esc_html__('Random from all categories', 'taskbot'),
                            'recent' 	=> esc_html__('Recent from all categories', 'taskbot'),
                            'categories_random' 	=> esc_html__('Random by categories', 'taskbot'),
                            'categories_recent' 	=> esc_html__('Recent by categories', 'taskbot'),
                            'ids' 	                => esc_html__('By IDs', 'taskbot'),
                        ]
                    ]
                );
                
                $this->add_control(
                    'show_posts',
                    [
                        'label' => esc_html__( 'Number of posts', 'taskbot' ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'posts' ],
                        'condition'		=> ['listing_type!'=> 'ids'],
                        'range' => [
                            'posts' => [
                                'min'   => 1,
                                'max'   => 100,
                                'step'  => 1,
                            ]
                        ],
                        'default' => [
                            'unit' => 'posts',
                            'size' => 6,
                        ]
                    ]
                );
                $this->add_control(
                    'product_categories',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Categories?', 'taskbot'),
                        'desc'          => esc_html__('Select categories to display.', 'taskbot'),
                        'options'       => $categories,
                        'condition'		=> ['listing_type'=> ['categories_random','categories_recent']],
                        'multiple'      => true,
                        'label_block'   => true,
                    ]
                );
                $this->add_control(
                    'service_by',
                    [
                        'type'      	=> Controls_Manager::TEXTAREA,
                        'condition'		=> ['listing_type'=> 'ids'],
                        'label' 		=> esc_html__('Services by ID', 'taskbot'),
                        'description' 	=> esc_html__('You can add comma separated ID\'s for the services to show specific services. Leave it empty to use above settings', 'taskbot'),
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
                
                $settings     = $this->get_settings_for_display();
                $title        = !empty($settings['title']) ? $settings['title'] : '';
                $sub_title    = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
                $description  = !empty($settings['description']) ? $settings['description'] : '';
                $show_posts   = !empty($settings['show_posts']['size']) ? $settings['show_posts']['size'] : -1;
                $listing_type = !empty($settings['listing_type']) ? $settings['listing_type'] : '';
                $service_by   = !empty($settings['service_by']) ? $settings['service_by'] : '';
                $categories   = !empty($settings['product_categories']) ? $settings['product_categories'] : '';
                
                $rand_team               = rand(99, 9999);
                $tax_queries             = array();
                $product_cat_tax_args    = array();
                
                if (class_exists('WooCommerce')) {
                    if(!empty($categories ) 
                        && empty($service_by) 
                        && ( $listing_type == 'categories_random' || $listing_type == 'categories_recent' )
                    ){
                        $query_relation = array('relation' => 'AND',);
                        $product_cat_tax_args[] = array(
                            'taxonomy'  => 'product_cat',
                            'terms'     => $categories,
                            'field'     => 'term_id',
                            'operator'  => 'IN',
                        );
                    
                        // append product_cat taxonomy args in $tax_queries array
                        $tax_queries = array_merge($query_relation, $product_cat_tax_args);
                    }

                    $product_type_tax_args[] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN',
                    );
                    $tax_queries = array_merge($tax_queries,$product_type_tax_args);
                    $product_type_tax_args[] = array(
                        'taxonomy' => 'product_type',
                        'field'    => 'slug',
                        'terms'    => 'tasks',
                    );
                    $tax_queries = array_merge($tax_queries,$product_type_tax_args);
                    
                    // prepared query args
                    $taskbot_args = array(
                        'post_type'         => 'product',
                        'post_status'       => 'publish',
                        'tax_query'         => $tax_queries
                    );

                    //order by
                    if(!empty($listing_type) && ( $listing_type == 'random' ||  $listing_type == 'categories_random' )){
                        $taskbot_args['orderby'] = 'rand';
                    }

                    if(!empty($listing_type) && ( $listing_type == 'recent' ||  $listing_type == 'categories_recent' )){
                        $taskbot_args['orderby']    = 'ID';
                        $taskbot_args['order']      = 'DESC';
                    }
                    if(!empty($listing_type) && ( $listing_type === 'rating' )){
                        $taskbot_args['orderby']    = 'meta_value';
                        $taskbot_args['order']      = 'DESC';
                        $taskbot_args['meta_key']   = '_wc_average_rating';
                    }

                    //specific posts
                    if(!empty($service_by)){
                        $taskbot_args['post__in'] = !empty($service_by) ? explode(',',$service_by) : '';
                    }

                    $taskbot_query  = new \WP_Query(apply_filters('taskup_service_listings_args', $taskbot_args));
                    $result_count   = $taskbot_query->found_posts;
                    ?>
                    <div class="tk-main-section-two">
                        <div class="container">
                            <div class="row justify-content-center">
                                <?php if( !empty($title) || !empty($sub_title) || !empty($description) ){?>
                                    <div class="col-lg-10 col-xl-8">
                                        <div class="tk-main-title-holder text-center">
                                            <?php if(!empty($title) || !empty($sub_title) ){?>
                                                <div class="tk-maintitle">
                                                    <?php do_action( 'taskbot_section_shaper_html' );?>
                                                    <?php if( !empty($sub_title) ){?>
                                                        <h3><?php echo esc_html($sub_title)?></h3>
                                                    <?php } ?>
                                                    <?php if( !empty($title) ){?>
                                                        <h2><?php echo esc_html($title)?></h2>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <?php if(!empty($description)){?>
                                                <div class="tk-main-description">
                                                    <p><?php echo esc_html($description)?></p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if( !empty($taskbot_query->have_posts()) ){?>
                                    <div class="col-sm-12">
                                        <div id="tk-trendingserviceslider-<?php echo esc_attr($rand_team);?>" class="swiper tk-swiper tk-featureslider tk-swiperdots">
                                            <div class="swiper-wrapper">
                                            <?php
                                                while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
                                                    global $post;
                                                    ?>
                                                    <div class="swiper-slide">
                                                        <?php do_action( 'taskbot_listing_task_html_v2', $post->ID );?>
                                                    </div>
                                                 <?php endwhile;
                                                wp_reset_postdata(); ?>
                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                <?php }?>

                            </div>
                        </div>
                    </div>
                    <?php
                    $seller_script  = '
                    jQuery(document).ready(function () {
                        var tk_swiper = document.querySelector("#tk-trendingserviceslider-'.esc_js($rand_team).'")
                        if(tk_swiper !== null){
                        var swiper = new Swiper("#tk-trendingserviceslider-'.esc_js($rand_team).'", {
                            slidesPerView: 1,
                            spaceBetween: 24,
                            pagination: {
                                el: ".swiper-pagination",
                                clickable: true,
                            },
                            breakpoints: {
                            
                            480: {
                                slidesPerView: 1,
                                spaceBetween: 24
                            },
                            767: {
                                slidesPerView: 2,
                                spaceBetween: 24
                            },
                            991: {
                                slidesPerView: 3,
                                spaceBetween: 24
                            },
                            1199: {
                                slidesPerView: 4,
                                spaceBetween: 24
                            },
                        }
                        });
                        }
                    });
                    ';
                    wp_add_inline_script('swiper', $seller_script, 'after');
                }
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskup_Feature_Services_Slider);
    }
