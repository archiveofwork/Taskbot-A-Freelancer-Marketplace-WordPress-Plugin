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

    if (!class_exists('Taskbot_about_us_seller')) {
        class Taskbot_about_us_seller extends Widget_Base
        {
            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_sellers';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Our team', 'taskbot');
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
                        'label'       => esc_html__('Our team title', 'taskbot'),
                        'description' => esc_html__('Add text. leave it empty to hide.', 'taskbot'),
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
                    'team_member',
                    [
                        'label'     => esc_html__('Add team member', 'taskbot'),
                        'type'      => Controls_Manager::REPEATER,
                        'fields' => [
                            [
                                'name'          => 'image',
                                'type'          => Controls_Manager::MEDIA,
                                'label'         => esc_html__('Upload image', 'taskbot'),
                                'description'   => esc_html__('Upload image.(306x300)', 'taskbot'),
                                'default' => [
                                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                                ],
                            ],
                            [
                                'name'          => 'name',
                                'type'          => Controls_Manager::TEXT,
                                'label'         => esc_html__('Team member name', 'taskbot'),
                                'description'   => esc_html__('Team member name. leave it empty to hide.', 'taskbot'),
                                'label_block'   => true,
                            ],
                            [
                                'name'          => 'designation',
                                'type'          => Controls_Manager::TEXT,
                                'label'         => esc_html__('Team member designation', 'taskbot'),
                                'description'   => esc_html__('Team member designation. leave it empty to hide.', 'taskbot'),
                                'label_block'   => true,
                            ],
                            [
                                'name'          => 'facebook_link',
                                'label'         => esc_html__( 'Facebook link', 'taskbot' ),
                                'placeholder'   => esc_html__( 'https://example.com', 'taskbot' ),
                                'type'          => \Elementor\Controls_Manager::URL,
                                'default' => [
                                    'url'               => '',
                                    'is_external'       => true,
                                    'nofollow'          => true,
                                    'custom_attributes' => '',
                                ],
                            ],
                            [
                                'name'          => 'twitter_link',
                                'label'         => esc_html__( 'Twitter link', 'taskbot' ),
                                'placeholder'   => esc_html__( 'https://example.com', 'taskbot' ),
                                'type'          => \Elementor\Controls_Manager::URL,
                                'default' => [
                                    'url'               => '',
                                    'is_external'       => true,
                                    'nofollow'          => true,
                                    'custom_attributes' => '',
                                ],
                            ],
                            [
                                'name'          => 'linkedIn_link',
                                'label'         => esc_html__( 'LinkedIn link', 'taskbot' ),
                                'placeholder'   => esc_html__( 'https://example.com', 'taskbot' ),
                                'type'          => \Elementor\Controls_Manager::URL,
                                'default' => [
                                    'url'               => '',
                                    'is_external'       => true,
                                    'nofollow'          => true,
                                    'custom_attributes' => '',
                                ],
                            ],
                            [
                                'name'          => 'twitch_link',
                                'label'         => esc_html__( 'Twitch tv link', 'taskbot' ),
                                'placeholder'   => esc_html__( 'https://example.com', 'taskbot' ),
                                'type'          => \Elementor\Controls_Manager::URL,
                                'default' => [
                                    'url'               => '',
                                    'is_external'       => true,
                                    'nofollow'          => true,
                                    'custom_attributes' => '',
                                ],
                            ],
                            [
                                'name'          => 'dribbble_link',
                                'label'         => esc_html__( 'Dribbble link', 'taskbot' ),
                                'placeholder'   => esc_html__( 'https://example.com', 'taskbot' ),
                                'type'          => \Elementor\Controls_Manager::URL,
                                'default' => [
                                    'url'               => '',
                                    'is_external'       => true,
                                    'nofollow'          => true,
                                    'custom_attributes' => '',
                                ],
                            ],
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
                $settings       = $this->get_settings_for_display();
                $title          = !empty($settings['title']) ? $settings['title'] : '';
                $description    = !empty($settings['description']) ? $settings['description'] : ''; 
                $sub_title      = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
                $team_members   = !empty($settings['team_member']) ? $settings['team_member'] : array();

                $rand_team      = rand(99, 9999);
                if (!empty($team_members[0]['image']['url']) && is_array($team_members)) { ?>
                    <div class="tk-about-seller gr-about-seller">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="tk-main-title-holder">
                                        <?php if (!empty($title) || !empty($sub_title) ) { ?>
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
                                <div class="col-12">
                                    <div id="tk-professionolslider" class="tk-professionolslider tk-professionolslider-<?php echo intval($rand_team); ?> tk-sliderarrow">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                <?php
                                                    foreach ($team_members as $team_member) {
                                                        $team_member_image  = !empty($team_member['image']['url']) ? $team_member['image']['url'] : '';
                                                        $name               = !empty($team_member['name']) ? $team_member['name'] : '';
                                                        $designation        = !empty($team_member['designation']) ? $team_member['designation'] : '';
                                                        $facebook_link      = !empty($team_member['facebook_link']['url']) ? $team_member['facebook_link']['url'] : '';
                                                        $twitter_link       = !empty($team_member['twitter_link']['url']) ? $team_member['twitter_link']['url'] : '';
                                                        $linkedIn_link      = !empty($team_member['linkedIn_link']['url']) ? $team_member['linkedIn_link']['url'] : '';
                                                        $twitch_link        = !empty($team_member['twitch_link']['url']) ? $team_member['twitch_link']['url'] : '';
                                                        $dribbble_link      = !empty($team_member['dribbble_link']['url']) ? $team_member['dribbble_link']['url'] : '';
                                                    
                                                        if (!empty($team_member_image)) {?>
                                                            <li class="splide__slide">
                                                                <div class="tk-profeesonitem">
                                                                    <?php if (!empty($team_member_image)) { ?>
                                                                        <figure><img src="<?php echo esc_url($team_member_image) ?>" alt="<?php echo esc_attr($name) ?>"></figure><?php
                                                                    } ?>
                                                                    <div class="tk-profeesonolinfo text-center">
                                                                        <?php if (!empty($designation)) { ?>
                                                                            <h6><?php echo esc_html($designation); ?></h6>
                                                                        <?php } ?>
                                                                        <?php if (!empty($name)) { ?>
                                                                            <h4><?php echo esc_html($name) ?></h4>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php if(!empty($facebook_link) || !empty($twitter_link) || !empty($linkedIn_link) || !empty($twitch_link) || !empty($dribbble_link)){?>
                                                                        <ul class="tk-socailmedia tk-socialicons-two">
                                                                            <?php if($facebook_link){?>
                                                                                <li><a class="tk-facebook" href="<?php echo esc_url($facebook_link) ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                                            <?php }?>
                                                                            <?php if($twitter_link){?>
                                                                                <li><a class="tk-twitter" href="<?php echo esc_url($twitter_link)?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                                            <?php } ?>
                                                                            <?php if(!empty($linkedIn_link)){?>
                                                                                <li><a class="tk-linkedin" href="<?php echo esc_url($linkedIn_link)?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                                                            <?php } ?>
                                                                            <?php if(!empty($twitch_link)){?>
                                                                                <li><a class="tk-twitch" href="<?php echo esc_url($twitch_link)?>" target="_blank"><i class="fab fa-twitch"></i></a></li>
                                                                            <?php } ?>
                                                                            <?php if(!empty($dribbble_link)){?>
                                                                                <li><a class="tk-dribbble" href="<?php echo esc_url($dribbble_link)?>" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php } ?>
                                                                </div>
                                                            </li>
                                                        <?php }
                                                    } 
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                if( !empty($team_members) ){
                    $is_rtl			= taskbot_splide_rtl_check();
                    $seller_script  = '
                    jQuery(document).ready(function () {
                        let tk_professionolslider = document.querySelector(".tk-professionolslider-'.esc_js($rand_team).'");
                        if (tk_professionolslider !== null) {
                            var splide = new Splide(".tk-professionolslider-'.esc_js($rand_team).'", {
                                type   : "loop",
                                direction   : "'.esc_js($is_rtl).'",
                                perPage: 4,
                                perMove:1,
                                arrows:true,
                                pagination: false,
                                gap:24,
                                breakpoints: {
                                    1400: {
                                        perPage: 3,
                                    },
                                991: {
                                    perPage: 2,
                                    focus  : "center",
                                },
                                575: {
                                    perPage:2,
                                    gap:20,
                                    arrows:false,
                                    pagination: true,
                                    focus  : "center",
                                },
                                480: {
                                    perPage:1,
                                    arrows:false,
                                    pagination: true,
                                    focus  : "center",
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
        Plugin::instance()->widgets_manager->register(new Taskbot_about_us_seller);
    }
