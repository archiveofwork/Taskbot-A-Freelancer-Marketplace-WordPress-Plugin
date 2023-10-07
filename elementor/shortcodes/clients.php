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

if (!class_exists('Taskbot_about_us_clients')) {
    class Taskbot_about_us_clients extends Widget_Base
    {

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name()
        {
            return 'taskbot_element_about_us_client';
        }

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      title
         */
        public function get_title()
        {
            return esc_html__('Clients', 'taskbot');
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
                    'label'     => esc_html__('Content', 'taskbot'),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'clients',
                [
                    'label'     => esc_html__('Add client', 'taskbot'),
                    'type'      => Controls_Manager::REPEATER,
                    'fields' => [
                        [
                            'name'          => 'image',
                            'type'          => Controls_Manager::MEDIA,
                            'label'         => esc_html__('Upload image', 'taskbot'),
                            'description'   => esc_html__('Upload image.(115x40)', 'taskbot'),
                            'default' => [
                                'url' => \Elementor\Utils::get_placeholder_image_src(),
                            ],
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
            $settings = $this->get_settings_for_display();
            $clients = !empty($settings['clients']) ? $settings['clients'] : array();

            if (!empty($clients)) { ?>
                <div class="tk-banner-wrapper">
                    <div class="container">
                        <div class="tk-banner">
                            <div class="tk-sectionmid">
                                <ul class="tk-clients">
                                    <?php
                                    foreach ($clients as $client) {
                                        $client_img = !empty($client['image']['url']) ? $client['image']['url'] : '';
                                        if (!empty($client_img)) { ?>
                                            <li>
                                                <img src="<?php echo esc_url($client_img); ?>" alt="<?php esc_attr_e('Client','taskbot'); ?>">
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            }
        }
    }

    Plugin::instance()->widgets_manager->register(new Taskbot_about_us_clients);
}
