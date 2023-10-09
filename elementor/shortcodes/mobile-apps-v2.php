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

    if (!class_exists('Taskup_mobileApp_section')) {

        class Taskup_mobileApp_section extends Widget_Base
        {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskup_element_mob';
        }

        /**
        *
        * @since    1.0.0
        * @access   static
        * @var      title
        */
        public function get_title()
        {
            return esc_html__('Mobile apps v2', 'taskbot');
        }

        /**
        *
        * @since    1.0.0
        * @access   public
        * @var      icon
        */
        public function get_icon()
        {
            return 'eicon-device-mobile';
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
            $posts  = array();
            if( function_exists('taskbot_elementor_get_posts') ){
                $posts  = taskbot_elementor_get_posts(array('page'));
            }
            $posts  = !empty($posts) ? $posts : array();

            //Content
            $this->start_controls_section(
                'content_section',
                [
                    'label'   => esc_html__('Content', 'taskbot'),
                    'tab'     => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'sub_title',
                [
                    'type'          => Controls_Manager::TEXT,
                    'label'         => esc_html__('Section sub title', 'taskbot'),
                    'description'   => esc_html__('Add text. leave it empty to hide.', 'taskbot'),
                ]
            );
            
            $this->add_control(
                'title',
                [
                    'type'        => Controls_Manager::TEXTAREA,
                    'label'       => esc_html__('Section title', 'taskbot'),
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
                'description',
                [
                    'type'        => Controls_Manager::TEXTAREA,
                    'label'       => esc_html__('Description', 'taskbot'),
                    'rows'        => 5,
                    'description' => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'palystore_image',
                [
                    'type'        =>  Controls_Manager::MEDIA,
                    'label'       => esc_html__('Upload play store image', 'taskbot'),
                    'description' => esc_html__('Add Upload play store image. leave it empty to hide.', 'taskbot')
                ]
            );

            $this->add_control(
                'palystore_url',
                [
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('Play store URL', 'taskbot'),
                    'desc'        => esc_html__('Add Play store URL', 'taskbot')
                ]
            );

            $this->add_control(
                'appstore_image',
                [
                    'type'        => Controls_Manager::MEDIA,
                    'label'       => esc_html__('Upload App store image', 'taskbot'),
                    'description' => esc_html__('Add Upload App store image. leave it empty to hide.', 'taskbot')
                ]
            );

            $this->add_control(
                'appstore_url',
                [
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('App store URL', 'taskbot'),
                    'desc'        => esc_html__('Add App store URL', 'taskbot')
                ]
            );

            $this->add_control(
                'short_description',
                [
                    'type'        => Controls_Manager::TEXTAREA,
                    'label'       => esc_html__('Short descriptionn', 'taskbot'),
                    'description' => esc_html__('Add short description. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'mobile_image',
                [
                    'type'        => Controls_Manager::MEDIA,
                    'label'       => esc_html__('Mobile image', 'taskbot'),
                    'description' => esc_html__('Add mobile image.', 'taskbot'),
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
            $title              = !empty($settings['title']) ? $settings['title'] : '';
            $description        = !empty($settings['description']) ? $settings['description'] : '';
            $short_description  = !empty($settings['short_description']) ? $settings['short_description'] : '';
            $mobile_image       = !empty($settings['mobile_image']['url']) ? $settings['mobile_image']['url'] : '';
            $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';

            $appstore_url       = !empty($settings['appstore_url']) ? $settings['appstore_url'] : '';
            $palystore_url      = !empty($settings['palystore_url']) ? $settings['palystore_url'] : '';
            $appstore_image     = !empty($settings['appstore_image']['url']) ? $settings['appstore_image']['url'] : '';
            $palystore_image    = !empty($settings['palystore_image']['url']) ? $settings['palystore_image']['url'] : '';
            ?>
            <div class="tk-ourexperience">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-xl-6">
                            <div class="tk-main-title-holder tk-sectionapptitle">
                                <?php if (!empty($title) || !empty($sub_title)) { ?>
                                    <div class="tk-maintitle">
                                        <?php do_action( 'taskbot_section_shaper_html' );?>
                                        <?php if(!empty($sub_title)){?>
                                            <h3><?php echo esc_html($sub_title)?></h3>
                                        <?php } ?>
                                        <h2><?php echo do_shortcode($title) ?></h2>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($description)) { ?>
                                    <div class="tk-main-description">
                                        <p><?php echo esc_html($description) ?></p>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($appstore_image) || !empty($palystore_image) ) { ?>
                                    <div class="tk-store-content">
                                        <?php if (!empty($appstore_image)) { ?>
                                            <a href="<?php echo esc_url($appstore_url); ?>">
                                                <img src="<?php echo esc_url($appstore_image);?>" alt="<?php esc_attr_e('App store','taskbot');?>"/>
                                            </a>
                                        <?php } ?>
                                        <?php if (!empty($palystore_image)) { ?>
                                            <a href="<?php echo esc_url($palystore_url); ?>">
                                                <img src="<?php echo esc_url($palystore_image);?>" alt="<?php esc_attr_e('App store','taskbot');?>"/>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($short_description)) { ?>
                                    <div class="tk-appcompat tk-appcompat-v2">
                                        <h6><i class="tb-icon-bell"></i><?php echo do_shortcode($short_description) ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if (!empty($mobile_image)) { ?>
                            <div class="col-md-6 d-xl-block d-none align-self-end">
                                <figure class="tk-appiamge">
                                    <img src="<?php echo esc_url($mobile_image); ?>" alt=" <?php esc_attr_e('Moile apps', 'taskbot') ?>">
                                </figure>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskup_mobileApp_section);

}
