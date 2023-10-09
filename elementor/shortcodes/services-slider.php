<?php
    /**
     * Services sliders
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

    if (!class_exists('Taskbot_Services_Slider')) {
        class Taskbot_Services_Slider extends Widget_Base
        {
            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_services_slider';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Services slider | Taskbot', 'taskbot');
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

            public function get_style_depends() {
                return [ 'splide'];
            }

            public function get_script_depends() {
                return [ 'splide'];
            }

            /**
            * Register category controls.
            * @since    1.0.0
            * @access   protected
            */
            protected function register_controls()
            {
                $categories = taskbot_elementor_get_taxonomies('product', 'product_cat');
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
                    'sub_title',
                    [
                        'type'          => Controls_Manager::TEXTAREA,
                        'label'         => esc_html__('Sub title', 'taskbot'),
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
                                'min' => 1,
                                'max' => 100,
                                'step' => 1,
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
                $this->add_control(
                    'layout_type',
                    [
                        'type'      => Controls_Manager::SELECT2,
                        'label'     => esc_html__('layout type', 'taskbot'),
                        'desc'      => esc_html__('Select layout type', 'taskbot'),
                        'default'   => 'v1',
                        'options'   => [
                            'v1'   => esc_html__('V1', 'taskbot'),
                            'v2'  => esc_html__('V2', 'taskbot'),
                        ],
                    ]
                );
                $this->add_control(
                    'button_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Button text', 'taskbot'),
                        'description'   => esc_html__('Add Button text. leave it empty to hide.', 'taskbot'),
                        'condition' => [
                            'layout_type' => 'v2',
                        ],
                    ]
                );
                $this->add_control(
                    'button_link',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Select page', 'taskbot'),
                        'desc'          => esc_html__('Select page for button URL.', 'taskbot'),
                        'options'       => $pages,
                        'multiple'      => false,
                        'label_block'   => true,
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
                
                $settings            = $this->get_settings_for_display();
                $title               = !empty($settings['title']) ? $settings['title'] : '';
                $sub_title           = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
                $show_posts          = !empty($settings['show_posts']['size']) ? $settings['show_posts']['size'] : -1;
                $listing_type        = !empty($settings['listing_type']) ? $settings['listing_type'] : '';
                $service_by          = !empty($settings['service_by']) ? $settings['service_by'] : '';
                $categories          = !empty($settings['product_categories']) ? $settings['product_categories'] : '';
                $layout_type        = !empty($settings['layout_type']) ? $settings['layout_type'] : 'v1';
                $button_text        = !empty($settings['button_text']) ? $settings['button_text'] : '';
                $button_link        = !empty($settings['button_link']) ? get_the_permalink($settings['button_link']) : '';

                $rand_team               = rand(99, 9999);
                $tax_queries             = array();

                $product_cat_tax_args       = array();
                $product_cat_tax_args[]     = array(
                    'taxonomy' 	=> 'product_type',
                    'field' 	=> 'slug', 
                    'terms' 	=> 'tasks'
                );

                $query_relation = array('relation' => 'AND',);
                
                if (class_exists('WooCommerce')) {
                    if(!empty($categories ) 
                        && empty($service_by) 
                        && ( $listing_type == 'categories_random' || $listing_type == 'categories_recent' )
                    ){
                        
                        $product_cat_tax_args[] = array(
                            'taxonomy'  => 'product_cat',
                            'terms'     => $categories,
                            'field'     => 'term_id',
                            'operator'  => 'IN',
                        );
    
                    }

                    $tax_queries = array_merge($query_relation, $product_cat_tax_args);

                    // prepared query args
                    $taskbot_args = array(
                        'post_type'         => 'product',
                        'post_status'       => 'publish',
                        'tax_query'         => $tax_queries,
                    );

                    //order by
                    if(!empty($listing_type) && ( $listing_type == 'random' ||  $listing_type == 'categories_random' )){
                        $taskbot_args['orderby'] = 'rand';
                    }

                    if(!empty($listing_type) && ( $listing_type == 'recent' ||  $listing_type == 'categories_recent' )){
                        $taskbot_args['orderby']    = 'ID';
                        $taskbot_args['order']      = 'DESC';
                    }

                    //specific posts
                    if(!empty($service_by)){
                        $taskbot_args['post__in'] = explode(',',$service_by);
                    }

                    $taskbot_query      = new \WP_Query(apply_filters('taskbot_service_listings_args', $taskbot_args));
                    $result_count       = $taskbot_query->found_posts;
                    $ul_class           = !empty($layout_type) && $layout_type === 'v2' ? 'tk-trendingslider tk-sliderarrow-two' : 'tk-trendingserviceslider tk-sliderarrow';
                    ?>
                    <div class="sc-services-slider container">
                        <div class="row justify-content-center">
                            <?php if (!empty($title) || !empty($sub_title)) { ?>
                                <div class="col-lg-7 col-md-8">
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
                            <?php if( !empty($taskbot_query->have_posts()) ){ ?>
                                <div class="col-12">
                                    <div id="tk-trendingserviceslider-<?php echo esc_attr($rand_team);?>" class="splide <?php echo esc_attr($ul_class);?>">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                            <?php
                                                while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
                                                    $product            = wc_get_product();
                                                    $product_author_id  = get_post_field ('post_author', $product->get_id());
                                                    $linked_profile_id  = get_user_meta($product_author_id, '_linked_profile', true);
                                                    $post_country       = get_post_meta( $product->get_id(), '_country', true );
                                                    $user_name          = taskbot_get_username($linked_profile_id);
                                                    $verified_user      = get_post_meta( $linked_profile_id, '_is_verified', true);
                                                    $verified_user      = !empty($verified_user) ? $verified_user : '';
                                                    $image              = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'taskbot_task_shortcode_thumbnail' );
                                                    ?>
                                                    <li class="splide__slide">
                                                        <?php if( !empty($layout_type) && $layout_type === 'v2'){?>
                                                            <div class="tk-bestservice">
                                                                <?php if( !empty($image[0])){ ?>
                                                                    <figure class="tk-cards__img">
                                                                        <?php do_action('taskbot_task_video_theme', $product);?>
                                                                        <img src="<?php  echo esc_url($image[0]); ?>">
                                                                    </figure>
                                                                <?php } ?>
                                                                <?php
                                                                    do_action('taskbot_service_featured_item_theme', $product);
                                                                    do_action('taskbot_service_gallery_count', $product);
                                                                ?>
                                                                <div class="tk-sevicesinfo">
                                                                    <div class="tk-bestservice__content">
                                                                        <?php do_action( 'taskbot_profile_image_theme', $linked_profile_id );?>
                                                                        <div class="tk-cardtitle">
                                                                            <?php
                                                                                do_action( 'taskbot_saved_item_theme', $product->get_id(),'','_saved_tasks' );

                                                                                if( !empty($user_name) ){?>
                                                                                <a href="<?php echo get_the_permalink($linked_profile_id); ?>"><?php echo esc_html($user_name); ?></a>
                                                                            <?php } ?>
                                                                            <h5><a href="<?php the_permalink();?>"><?php echo esc_html($product->get_name()); ?></a></h5>
                                                                        </div>
                                                                        <ul class="tk-blogviewdates tk-blogviewdatessm">
                                                                            <?php
                                                                                do_action('taskbot_service_rating_count_theme', $product);
                                                                                do_action('taskbot_service_item_views_theme', $product);
                                                                            ?>
                                                                        </ul>
                                                                        <?php do_action('taskbot_service_item_starting_price_theme', $product); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else if( !empty($layout_type) && $layout_type === 'v1'){ ?>
                                                            <div class="tk-trendingserviceslider_content">
                                                                <?php do_action('taskbot_task_gallery_theme_v2', $product, 'taskbot_thumbnail','taskbot_product_thumbnail');?>
                                                                <div class="tk-trendingserviceslider_title">
                                                                    <?php  if( !empty($user_name) ){?>
                                                                        <h5>
                                                                            <a href="<?php echo get_the_permalink($linked_profile_id); ?>"><?php echo esc_html($user_name); ?></a>
                                                                            <?php if( !empty($verified_user) && $verified_user === 'yes' ){?>
                                                                                <i class="tb-icon-check-circle tk-green"></i>
                                                                            <?php } ?>
                                                                        </h5>
                                                                    <?php } ?>
                                                                    <h4><a href="<?php the_permalink();?>"><?php echo esc_html($product->get_name()); ?></a></h4>
                                                                    <?php do_action('taskbot_service_rating_count_theme_v2', $product); ?>
                                                                    <?php do_action('taskbot_service_item_starting_price_theme', $product); ?>
                                                                    <?php do_action( 'taskbot_saved_item_theme', $product->get_id(),'','_saved_tasks' );?>
                                                                    <a href="<?php the_permalink();?>" class="tk-btn-solid-lg"><?php esc_html_e('Hire me for your task','taskbot');?>&nbsp;<i class="tb-icon-arrow-right"></i></a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </li>
                                                    <?php endwhile;
                                                wp_reset_postdata(); ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if( !empty($layout_type) && $layout_type === 'v2' && !empty($button_text)){?>
                                    <div class="tk-btn-wrapper">
                                        <a href="<?php echo esc_url($button_link);?>" class="tk-btn-line-lg tk-btn-plain"><?php echo esc_html($button_text);?><i class="tb-icon-chevron-right"></i></a>
                                    </div>
                                <?php } ?>
                            <?php }?>
                        </div>
                    </div>
                    <?php
                    $is_rtl			= taskbot_splide_rtl_check();
                    if( !empty($layout_type) && $layout_type === 'v2'){
                        $seller_script = '
                            jQuery(document).ready(function () {
                                let tk_services_slider = document.querySelector("#tk-trendingserviceslider-'.esc_js($rand_team).'");
                                if (tk_services_slider !== null) {
                                    var splide = new Splide("#tk-trendingserviceslider-'.esc_js($rand_team).'", {
                                        type   : "loop",
                                        direction: "'.esc_js($is_rtl).'",
                                        perPage: 4,
                                        perMove: 1,
                                        arrows:true,
                                        pagination: false,
                                        gap: 24,
                                        breakpoints: {
                                            1199: {
                                                perPage: 3,
                                            },
                                            991: {
                                                perPage: 2,
                                            },
                                            600: {
                                                perPage: 1,
                                                gap:0,
                                            },
                                        }
                                    });
                                    splide.mount();
                                }
                            });
                        ';
                        wp_add_inline_script('splide', $seller_script, 'after');
                    } else if( !empty($layout_type) && $layout_type === 'v1'){
                        $seller_script = '
                            jQuery(document).ready(function () {
                                let tk_services_slider = document.querySelector("#tk-trendingserviceslider-'.esc_js($rand_team).'");
                                if (tk_services_slider !== null) {
                                    var splide = new Splide("#tk-trendingserviceslider-'.esc_js($rand_team).'", {
                                        type   : "loop",
                                        direction: "'.esc_js($is_rtl).'",
                                        perPage: 3,
                                        perMove: 1,
                                        arrows:true,
                                        pagination: false,
                                        gap: 24,
                                        breakpoints: {
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
                            });
                        ';
                        wp_add_inline_script('splide', $seller_script, 'after');
                    }
                }
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskbot_Services_Slider);
    }
