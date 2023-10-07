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

    if (!class_exists('Taskbot_mobileApp_section')) {

        class Taskbot_mobileApp_section extends Widget_Base
        {
        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskbot_element_mob';
        }

        /**
        *
        * @since    1.0.0
        * @access   static
        * @var      title
        */
        public function get_title()
        {
            return esc_html__('Mobile apps', 'taskbot');
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
            $posts  = taskbot_elementor_get_posts(array('page'));
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
                'title',
                [
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('Section title', 'taskbot'),
                    'description' => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
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
                'btn_text',
                [
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('Button text', 'taskbot'),
                    'description' => esc_html__('Add button text. leave it empty to hide.', 'taskbot'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'app_store_link',
                [
                    'type'        => Controls_Manager::TEXT,
                    'label'       => esc_html__('App Download link', 'taskbot'),
                    'desc'        => esc_html__('Add app download link', 'taskbot')
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
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
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
        protected function render(){
            $settings             = $this->get_settings_for_display();
            $title                = !empty($settings['title']) ? $settings['title'] : '';
            $btn_text             = !empty($settings['btn_text']) ? $settings['btn_text'] : '';
            $description          = !empty($settings['description']) ? $settings['description'] : '';
            $short_description    = !empty($settings['short_description']) ? $settings['short_description'] : '';
            $mobile_image         = !empty($settings['mobile_image']['url']) ? $settings['mobile_image']['url'] : '';
            $button_link          = !empty($settings['app_store_link']) ? $settings['app_store_link'] : '';
            ?>
            <div class="tk-mobile-wrapper">
                <div class="tk-sectionmid">
                    <div class="tk-sectionapp container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="tk-main-title-holder tk-sectionapptitle">
                                    <?php if (!empty($title)) { ?>
                                        <div class="tk-maintitle"><h2><?php echo esc_html($title) ?></h2></div>
                                    <?php } ?>
                                    <?php if (!empty($description)) { ?>
                                        <div class="tk-main-description">
                                            <p><?php echo esc_html($description) ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($btn_text) && !empty($button_link)) { ?>
                                        <a href="<?php echo esc_url($button_link); ?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo esc_html($btn_text) ?><i class="icon-download"></i></a>
                                    <?php } ?>
                                    <?php if (!empty($short_description)) { ?>
                                        <div class="tk-appcompat">
                                            <h6><i class="icon-bell"></i><?php echo do_shortcode($short_description) ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if (!empty($mobile_image)) { ?>
                                <div class="align-self-lg-end col-md-6 d-lg-block d-md-none d-none">
                                    <figure class="tk-appiamge">
                                        <img src="<?php echo esc_url($mobile_image); ?>" alt=" <?php esc_attr_e('Moile apps', 'taskbot') ?>">
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

    Plugin::instance()->widgets_manager->register(new Taskbot_mobileApp_section);

}
