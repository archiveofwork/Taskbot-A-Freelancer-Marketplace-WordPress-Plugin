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

    if (!class_exists('Taskbot_banner_v6')) {
        class Taskbot_banner_v6 extends Widget_Base
        {

            /**
             *
             * @since    1.0.0
             * @access   static
             * @var      base
             */
            public function get_name()
            {
                return 'taskbot_element_banner_v6';
            }

            /**
            *
            * @since    1.0.0
            * @access   static
            * @var      title
            */
            public function get_title()
            {
                return esc_html__('Main banner', 'taskbot');
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
                $posts = taskbot_elementor_get_posts(array('page'));
                $posts = !empty($posts) ? $posts : array();

                $list_menu  = taskbot_elementor_get_menus();
                $list_menu  = !empty($list_menu) ? $list_menu : array();

                //Content
                $this->start_controls_section(
                    'content_section',
                    [
                        'label'   => esc_html__('Content', 'taskbot'),
                        'tab'     => Controls_Manager::TAB_CONTENT,
                    ]
                );
                $this->add_control(
                    'top_menu',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Select menu', 'taskbot'),
                        'desc'          => esc_html__('Select menu or leave it empty to hide.', 'taskbot'),
                        'options'       => $list_menu,
                        'multiple'      => false
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
                    'description',
                    [
                        'type'          => Controls_Manager::TEXTAREA,
                        'label'         => esc_html__('Description', 'taskbot'),
                        'description'   => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'button_login_user',
                    [
                        'type'          => Controls_Manager::SWITCHER,
                        'label'         => esc_html__('Hide button for login user', 'taskbot'),
                        'label_on'      => esc_html__( 'Show', 'taskbot' ),
                        'label_off'     => esc_html__( 'Hide', 'taskbot' ),
                        'return_value'  => 'yes',
                        'default'       => 'yes',
                    ]
                );
    
                $this->add_control(
                    'button_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Talent button text', 'taskbot'),
                        'description'   => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                    ]
                );
                $this->add_control(
                    'button_link',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Select page', 'taskbot'),
                        'desc'          => esc_html__('Select page for talent button URL.', 'taskbot'),
                        'options'       => $posts,
                        'multiple'      => false,
                        'label_block'   => true,
                    ]
                );
    
                $this->add_control(
                    'reg_button_text',
                    [
                        'type'          => Controls_Manager::TEXT,
                        'label'         => esc_html__('Work button text', 'taskbot'),
                        'description'   => esc_html__('Add Button text. leave it empty to hide.', 'taskbot'),
                    ]
                );
                $this->add_control(
                    'reg_button_link',
                    [
                        'type'          => Controls_Manager::SELECT2,
                        'label'         => esc_html__('Select page', 'taskbot'),
                        'desc'          => esc_html__('Select page for registration button URL.', 'taskbot'),
                        'options'       => $posts,
                        'multiple'      => false,
                        'label_block'   => true,
                    ]
                );

                $this->add_control(
                    'image',
                    [
                        'type'          => Controls_Manager::MEDIA,
                        'label'         => esc_html__('Upload banner image', 'taskbot'),
                        'description'   => esc_html__('leave it empty to hide.', 'taskbot'),
                    ]
                );

                $this->end_controls_section();
            }

            protected function render()
            {
                global $taskbot_settings;
                $settings           = $this->get_settings_for_display();
                $title              = !empty($settings['title']) ? $settings['title'] : '';
                $description        = !empty($settings['description']) ? $settings['description'] : '';
                $top_menu           = !empty($settings['top_menu']) ? $settings['top_menu'] : '';
                $button_link        = !empty($settings['button_link']) ? get_the_permalink($settings['button_link']) : '';
                $reg_button_link    = !empty($settings['reg_button_link']) ? get_the_permalink($settings['reg_button_link']) : '';

                $button_text        = !empty($settings['button_text']) ? $settings['button_text'] : '';
                $reg_button_text    = !empty($settings['reg_button_text']) ? $settings['reg_button_text'] : '';
                $button_login_user  = !empty($settings['button_login_user']) ? $settings['button_login_user'] : '';
                $image              = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
                $menu_html          = "";
                if( !empty($top_menu) ){
                    $defaults = array(
                        'menu'                  => $top_menu,
                        'container'             => 'ul',
                        'container_class'       => '',
                        'container_id'          => '',
                        'menu_class'            => 'tk-navbarbottom tk-menulist',
                        'menu_id'               => "",
                        'echo'                  => false,
                        'fallback_cb'           => 'wp_page_menu',
                        'before'                => '',
                        'after'                 => '',
                        'link_before'           => '',
                        'link_after'            => '',
                        'items_wrap'            => '<a class="tk-togglebtmmenu"><span class="tb-icon-menu"></span></a><ul id="%1$s" class="%2$s">%3$s</ul>',
                    );
                    $defaults['menu']   = $top_menu;
                    $menu_html  = wp_nav_menu($defaults);
                }
                ?>
                <div class="tk-sectionmid-two">
                    <?php 
                        if( !empty($menu_html) ){
                            echo do_shortcode( $menu_html );
                        }
                    ?>
                    <div class="tk-bannerthree">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-12 col-xl-6">
                                    <div class="tk-bannerinfo tk-bannerinfothree">
                                        <div class="tk-bannerinfo_title">
                                            <?php if( !empty($title) ){?>
                                                <h1> <?php echo do_shortcode($title);?></h1>
                                            <?php } ?>
                                            <?php if( !empty($description) ){?>
                                                <p><?php echo do_shortcode($description);?></p>
                                            <?php } ?>
                                        </div>
                                        <?php if( is_admin() || !is_user_logged_in() || ($button_login_user != 'yes')){?>
                                            <ul class="tk-mainbtnlist">
                                                <?php if(!empty($button_text)){?>
                                                    <li><a href="<?php echo esc_url($button_link);?>" class="tk-btn-solid-lg tk-btn-vsix"><?php echo esc_html($button_text);?></a></li>
                                                <?php } ?>
                                                <?php if(!empty($reg_button_text) ){?>
                                                    <li><a href="<?php echo esc_url($reg_button_link);?>" class="tk-btn-solid-lg  tk-btn-vsixplain"><?php echo esc_html($reg_button_text);?></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if( !empty($image) ){?>
                                    <div class="col-12 col-xl-6">
                                        <figure class="tk-banner-img">
                                            <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($title);?>">
                                        </figure>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        Plugin::instance()->widgets_manager->register(new Taskbot_banner_v6);
    }
