<?php

/**
 * Shortcode
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

if (!class_exists('Taskup_feature_project')) {
    class Taskup_feature_project extends Widget_Base{

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_feature_project';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Featured projects', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon()
        {
            return 'eicon-table-of-contents';
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

            if( function_exists('taskbot_elementor_get_posts') ){
                $pages  = taskbot_elementor_get_posts(array('page'));
            }
            $pages      = !empty($pages) ? $pages : array();
            $categories = !empty($categories) ? $categories : array();
            //Content
            $this->start_controls_section(
                'content_section',
                [
                    'label'     => esc_html__('Content', 'taskbot'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'sub_title',
                [
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('Add sub title', 'taskbot'),
                    'description' => esc_html__('Add sub title. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Add title', 'taskbot'),
                    'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
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
                'listing_type',
                [
                    'type'      	=> Controls_Manager::SELECT,
                    'label' 		=> esc_html__('Show project by', 'taskbot'),
                    'description' 	=> esc_html__('Select type to list project by categories or specific', 'taskbot'),
                    'default' 		=> '',
                    'options' 		=> [
                                            '' 			=> esc_html__('Select project listing type', 'taskbot'),
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
                    'label' => esc_html__( 'Number of projects', 'taskbot' ),
                    'type'  => Controls_Manager::SLIDER,
                    'size_units'    => [ 'posts' ],
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
                        'size' => 4,
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
                'project_ids',
                [
                    'type'      	=> Controls_Manager::TEXTAREA,
                    'condition'		=> ['listing_type'=> 'ids'],
                    'label' 		=> esc_html__('Services by ID', 'taskbot'),
                    'description' 	=> esc_html__('You can add comma separated ID\'s for the services to show specific services. Leave it empty to use above settings', 'taskbot'),
                ]
            );

            $this->add_control(
                'btn_text',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Add button text', 'taskbot'),
                    'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                ]
            );

            $this->add_control(
                'btn_link',
                [
                    'type'          => Controls_Manager::SELECT2,
                    'label'         => esc_html__('Select page', 'taskbot'),
                    'desc'          => esc_html__('Select page for button URL.', 'taskbot'),
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
        protected function render()
        {
            global $current_user;         
            $settings        = $this->get_settings_for_display();
            $title           = !empty($settings['title']) ? $settings['title'] : '';
            $sub_title      = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $show_posts      = !empty($settings['show_posts']['size']) ? $settings['show_posts']['size'] : 4;
            $listing_type    = !empty($settings['listing_type']) ? $settings['listing_type'] : '';
            $project_ids     = !empty($settings['project_ids']) ? explode(',',$settings['project_ids']) : array();
            $categories      = !empty($settings['product_categories']) ? $settings['product_categories'] : '';
            
            $btn_text       = !empty($settings['btn_text']) ? $settings['btn_text'] : '';
            $btn_link       = !empty($settings['btn_link']) ? get_the_permalink($settings['btn_link']) : '';
            
            $rand_team              = rand(99, 9999);
            $tax_queries            = array();
            $meta_queries           = array();   
            $product_cat_tax_args   = array();
            
            if (class_exists('WooCommerce')) {
                $product_cat_tax_args[] = array(
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'projects',
                  );
                  
                  $tax_queries = array_merge($tax_queries,$product_cat_tax_args);

                if(!empty($categories ) 
                    && empty($project_ids) 
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

                $query_args = array(
                 
                    'post_type'             => 'product',
                    'post_status'           => 'publish',
                    'ignore_sticky_posts'   => 1
                );
                if( !empty($listing_type) && $listing_type == 'ids' && !empty($project_ids) ){
                    $query_args['post__in']  = $project_ids;
                }
                if(!empty($tax_queries)){
                    $query_args['tax_query']   = $tax_queries;
                }
                
                if(!empty($meta_queries)){
                    $query_args['meta_query']   = $meta_queries;
                }
                
                if(!empty($show_posts)){
                    $query_args['posts_per_page'] = $show_posts;
                }
                $project_data      = new \WP_Query(apply_filters('taskup_freelancer_search_filter', $query_args));
                $total_posts     = $project_data->found_posts;
                ?>
            	<div class="tk-main-section-three">
                    <div class="container">
                        <div class="row justify-content-center">
                            <?php if(!empty($title) || !empty($description)){?>
                                <div class="col-12">
                                    <div class="tk-main-title-holder">
                                        <?php if(!empty($title) || !empty($sub_title) ){?>
                                            <div class="tk-maintitle">
                                                <?php do_action( 'taskbot_section_shaper_html' ); ?>
                                                <?php if(!empty($sub_title)){?>
                                                    <h3><?php echo esc_html($sub_title)?></h3>
                                                <?php } ?>
                                                <?php if($title){?>
                                                    <h2><?php echo esc_html($title)?></h2>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <?php if( !empty($btn_text) ){?>
                                            <div class="tk-btn2-wrapper">
                                                <a href="<?php echo esc_url($btn_link);?>" class="tk-sectionbtn"><?php echo esc_html($btn_text);?><i class="tb-icon-grid"></i></a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row gy-4">
                            <?php if(!empty($project_data->have_posts())){?>
                                <div class="col-12">
                                    <ul class="tk-featured-listing"> 
                                        <?php
                                        while ( $project_data->have_posts() ) : $project_data->the_post();
                                            $product            = wc_get_product();
                                            $post_status		= get_post_status( $product->get_id() );
                                            $product_author_id  = get_post_field ('post_author', $product->get_id());
                                            //check if proposal is submitted
                                            $taskbot_user_proposal  = 0;
                                            if( is_user_logged_in() ){
                                                $proposal_args = array(
                                                    'post_type' 	    => 'proposals',
                                                    'post_status'       => 'any',
                                                    'posts_per_page'    => -1,
                                                    'author'            => $current_user->ID,
                                                    'meta_query'        => array(
                                                        array(
                                                            'key'       => 'project_id',
                                                            'value'     => intval($product->get_id()),
                                                            'compare'   => '=',
                                                            'type'      => 'NUMERIC'
                                                        )
                                                    )
                                                );

                                                $proposals                  = get_posts( $proposal_args );
                                                $taskbot_user_proposal      = !empty($proposals) && is_array($proposals) ? count($proposals) : 0; 
                                                $proposal_edit_link         = !empty($proposals) ? taskbot_get_page_uri('submit_proposal_page').'?id='.intval($proposals[0]->ID) : '';
                                            }

                                            $submint_class	= '';
                                            $page_url		= '';
                                            if( !is_user_logged_in( ) ){
                                                $submint_class	= 'tb-login-seller';
                                            } else {
                                                if( is_user_logged_in() && (current_user_can('administrator') || $current_user->ID == $product_author_id) ){
                                                    $submint_class	= 'tb-login-seller';
                                                } else {
                                                    $user_type  		= apply_filters('taskbot_get_user_type', $current_user->ID );
                                                    $linked_profile     = taskbot_get_linked_profile_id($current_user->ID, '', $user_type);
                                                    if( !empty($user_type) && $user_type === 'sellers' ){
                                                        $submint_class	= 'tb-page-link';
                                                        $page_url		= !empty($product->get_id()) ?taskbot_get_page_uri('submit_proposal_page').'?post_id='.intval($product->get_id()) : '';
                                                    } else if( !empty($user_type) && $user_type === 'buyers' ){
                                                        $submint_class	= 'tb-redirect-url';
                                                    }
                                                }
                                            }
                                            
                                            $linked_profile_id  = taskbot_get_linked_profile_id($product_author_id, '','buyers');
                                            $user_name          = taskbot_get_username($linked_profile_id);
                                            $is_verified        = !empty($linked_profile_id) ? get_post_meta( $linked_profile_id, '_is_verified',true) : '';
                                            $project_price      = taskbot_project_price($product->get_id());
                                            $project_meta       = get_post_meta( $product->get_id(), 'tb_project_meta',true );
                                            $project_meta       = !empty($project_meta) ? $project_meta : array();
                                            $project_type       = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
                                            $avatar             = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 260, 'height' => 212), $linked_profile_id), array('width' => 260, 'height' => 212));
                                            ?>
                                            <li>
                                                <div class="tk-price-holder">
                                                    <?php do_action( 'taskbot_featured_item', $product,'featured_project' );?>
                                                    <?php if( !empty($avatar) ){?>
                                                        <div class="tk-project-img">
                                                            <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>" />
                                                        </div>
                                                    <?php } ?>
                                                    <div class="tk-verified-info">
                                                        <strong>
                                                            <?php echo esc_html($user_name);?>
                                                            <?php do_action( 'taskbot_verification_tag_html', $linked_profile_id ); ?>
                                                        </strong>
                                                        <?php if(!empty($product->get_name())){?>
                                                            <h5><a href="<?php echo esc_url(get_the_permalink( $product->get_id() ));?>"><?php echo esc_html($product->get_name());?></a></h5>
                                                        <?php } ?>
                                                         <ul class="tk-template-view"> 
                                                            <?php do_action( 'taskbot_posted_date_html', $product );?>
                                                            <?php do_action( 'taskbot_location_html', $product );?>
                                                            <?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','tb-icon-briefcase' );?>
                                                            <?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
                                                        </ul>
                                                    </div>
                                                    <?php if( isset($project_price) ){?>
                                                        <div class="tk-price">
                                                            <?php if( !empty($project_type) ){?>
                                                                <?php do_action( 'taskbot_project_type_text', $project_type );?>
                                                            <?php } ?>
                                                            <h4><?php echo do_shortcode($project_price);?></h4>
                                                            <?php 
                                                                if( is_user_logged_in() &&  intval($current_user->ID) === intval( $product_author_id ) ){ ?>
                                                                    <span class="tk-btn-solid-lg-lefticon"><a href="<?php echo get_the_permalink($product->get_id());?>"><?php esc_html_e('View detail','taskbot');?></a></span>
                                                                <?php }else if( is_user_logged_in() && !empty($taskbot_user_proposal) ){?>
                                                                    <span class="tk-btn-solid-lg-lefticon"><a href="<?php echo esc_url($proposal_edit_link);?>"><?php esc_html_e('Edit proposal','taskbot');?></a></span>
                                                                <?php 
                                                                }else{
                                                                    if( !empty($post_status) && $post_status === 'publish') {?>
                                                                        <span class="tk-btn-solid-lg-lefticon <?php echo esc_attr($submint_class);?>" data-url="<?php echo esc_url($page_url);?>"><?php esc_html_e('Apply now','taskbot');?></span>
                                                                    <?php }
                                                                } ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        <?php endwhile;
                                        wp_reset_postdata(); ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            
            <?php
            }           
        }
    }
    Plugin::instance()->widgets_manager->register(new Taskup_feature_project);
}
