<?php

/**
 * Shortcode
 *
 *
 * @package    Taskup
 * @subpackage Taskup/elementor/
 * @author     Amentotech <theamentotech@gmail.com>
 */

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Taskup_customer_review')) {
    class Taskup_customer_review extends Widget_Base
    {

        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
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
            return 'taskup_customer_review';
        }
        
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Customer review', 'taskbot');
        }

        /**
         *
         * @since    1.0.0
         * @access   public
         * @var      icon
         */
        public function get_icon()
        {
            return 'eicon-product-categories';
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
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'title',
                [
                    'label'         => esc_html__('Heading', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::TEXT,
                    'placeholder'   => esc_html__('Type your Heading here', 'taskbot'),
                    'description'   => esc_html__('leave it empty. to hide it.', 'taskbot'),
                    'label_block'   => true
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
                    'label'         => esc_html__('Sub title', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::TEXT,
                    'description'   => esc_html__('Add sub title. leave it empty. to hide it.', 'taskbot'),
                    'label_block'   => true
                ]
            );
            $this->add_control(
                'description',
                [
                    'label'         => esc_html__('Description', 'taskbot'),
                    'type'          => \Elementor\Controls_Manager::TEXTAREA,
                    'placeholder'   => esc_html__('Type your Sub Heading here', 'taskbot'),
                    'description'   => esc_html__('leave it empty. to hide it.', 'taskbot'),
                    'label_block'   => true
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
                        'v2'   => esc_html__('V2', 'taskbot'),
                    ],
                ]
            );
            $this->add_control(
                'customers',
                [
                    'label'     => esc_html__('Add customer', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'          => 'image',
                            'type'          => Controls_Manager::MEDIA,
                            'label'         => esc_html__('Upload customer image', 'taskbot'),
                            'description'   => esc_html__('Upload customer image. leave it empty to hide.', 'taskbot'),
                            'label_block'   => true,
                        ], 
                        [
                            'name'          => 'name',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Name', 'taskbot'),
                            'description'   => esc_html__('Add name. leave it empty to hide.', 'taskbot'),
                            'label_block'   => true,
                        ],
                        [
                            'name'          => 'address',
                            'type'          => Controls_Manager::TEXT,
                            'label'         => esc_html__('Adress', 'taskbot'),
                            'description'   => esc_html__('Add address. leave it empty to hide.', 'taskbot'),
                        ],
                        [
                            'name'          => 'details',
                            'type'          => Controls_Manager::TEXTAREA,
                            'label'         => esc_html__('Description', 'taskbot'),
                            'description'   => esc_html__('Add customer content. leave it empty to hide.', 'taskbot')
                        ],
                        [
                            'name'          => 'rating',
                            'type'          => Controls_Manager::SLIDER,
                            'size_units'    => [ 'rating_number' ],
                            'range'         => [
                                                'rating_number' => [
                                                    'min' => 1,
                                                    'max' => 5,
                                                    'step' => 1,
                                                ]
                                            ],
                            'default' => [
                                'unit' => 'rating_number',
                                'size' => 5,
                            ],
                            'label'         => esc_html__('Rating', 'taskbot'),
                            'description'   => esc_html__('Add rating. leave it empty to hide.', 'taskbot')
                        ]
                    ]
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
            $settings           = $this->get_settings_for_display();
            $title              = !empty($settings['title']) ? $settings['title'] : '';
            $description        = !empty($settings['description']) ? $settings['description'] : ''; 
            $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $layout_type        = !empty($settings['layout_type']) ? $settings['layout_type'] : 'v1';
            $customers          = !empty($settings['customers']) ? $settings['customers'] : array();
            $rand_flag          = rand(99, 9999);
            
            ?>
            <div class="tk-testimonial">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php if(!empty($title) ||  !empty($description) || !empty($sub_title) ){?>
                            <div class="col-lg-10 col-xl-8">
                                <div class="tk-main-title-holder text-center">
                                    <?php if( !empty($title) || !empty($sub_title) ){?>
                                        <div class="tk-maintitle">
                                            <?php  do_action( 'taskbot_section_shaper_html' );?>
                                            <?php if(!empty($sub_title)){?>
                                                <h3><?php echo esc_html($sub_title)?></h3>
                                            <?php } ?>
                                            <?php if(!empty($title)){?>
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
                        <?php if(!empty($customers)){?>
                            <div class="col-sm-12">
                                <div id="tureviwslider<?php echo esc_attr($rand_flag);?>" class="swiper tk-feedback tk-feedback-two tk-swiperdots">
                                    <div class="swiper-wrapper">
                                        <?php
                                            foreach($customers as $customer){
                                                $avatar     = !empty($customer['image']['url']) ? $customer['image']['url'] : '';
                                                $user_name  = !empty($customer['name']) ? $customer['name'] : '';
                                                $location   = !empty($customer['address']) ? $customer['address'] : '';
                                                $details    = !empty($customer['details']) ? $customer['details'] : '';
                                                $rating     = !empty($customer['rating']) ? $customer['rating'] : array();
                                                $rating_num = !empty($rating['size']) ? intval($rating['size']) : 0;
                                            ?>
                                            <div class="swiper-slide">
                                                <div class="tk-slider-content">
                                                    <?php if(!empty($avatar) || !empty($user_name) || !empty($location)) {?>
                                                        <div class="tk-slider-user">
                                                            <?php if(!empty($avatar)){?>
                                                                <img src="<?php echo esc_url($avatar)?>" alt="<?php echo esc_attr($user_name)?>">
                                                            <?php } ?>
                                                            <?php if(!empty($user_name) || !empty($location)){?>
                                                                <div class="tk-slideruser-info">
                                                                    <?php if(!empty($user_name)){?>
                                                                        <h5><?php echo esc_html($user_name)?></h5>
                                                                    <?php } ?>
                                                                    <?php if($location){?>
                                                                        <h6><?php echo esc_html($location)?></h6>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if(!empty($details)){?>
                                                        <p><?php echo esc_html($details)?></p>
                                                    <?php } ?>
                                                    <?php if(!empty($rating_num)){?>
                                                        <div class="tk-ratting">
                                                            <strong>
                                                                <?php echo sprintf( esc_html__('Excellent %s','taskbot'),$rating_num);?>
                                                                <span><?php esc_html_e('out of 5','taskbot')?> </span>
                                                            </strong>
                                                            <?php if( !empty($rating_num) ){?>
                                                                <ul class="tk-ratingstars">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { 
                                                                        $li_class   = $rating_num >= $i ? 'tk-starfill' : 'tk-star';
                                                                        ?>
                                                                        <li class="<?php echo esc_attr($li_class);?>">
                                                                            <i class="fa fa-star"></i>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php
            if(!empty($customers)){
                $customer_script         = '
                jQuery(document).ready(function () {
                    var tk_swiper = document.querySelector("#tureviwslider'.esc_js($rand_flag).'")
                    if(tk_swiper !== null){
                    var swiper = new Swiper("#tureviwslider'.esc_js($rand_flag).'", {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        freeMode: true,
                        pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        },
                        breakpoints: {
                        
                        480: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        991: {
                            slidesPerView: 2,
                        },
                        1200: {
                            slidesPerView: 3,
                            spaceBetween: 24
                        },
                    }
                    });
                    }
                });
                ';
                wp_add_inline_script('swiper', $customer_script, 'after');
            }
        }
    }
    Plugin::instance()->widgets_manager->register(new Taskup_customer_review);
}