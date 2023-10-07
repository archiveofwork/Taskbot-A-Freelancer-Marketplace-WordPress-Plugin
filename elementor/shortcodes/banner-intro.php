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

if (!class_exists('Taskbot_about_us_intro')) {
  class Taskbot_about_us_intro extends Widget_Base{

    /**
     *
     * @since    1.0.0
     * @access   static
     * @var      base
     */
    public function get_name()
    {
        return 'taskbot_element_about_us_intro';
    }

    /**
     *
     * @since    1.0.0
     * @access   static
     * @var      title
     */
    public function get_title()
    {
        return esc_html__('About us intro', 'taskbot');
    }

    /**
     *
     * @since    1.0.0
     * @access   public
     * @var      icon
     */
    public function get_icon()
    {
        return 'eicon-banner';
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
            'sub_title',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Tagline', 'taskbot'),
                'description' => esc_html__('Add sub title. leave it empty to hide.', 'taskbot'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'introduction',
            [
                'type'        => Controls_Manager::WYSIWYG,
                'label'       => esc_html__('Description', 'taskbot'),
                'description' => esc_html__('Add description. leave it empty to hide.', 'taskbot'),
            ]
        );

        $this->add_control(
            'author_image',
            [
                'type'        => Controls_Manager::MEDIA,
                'label'       => esc_html__('Author image', 'taskbot'),
                'description' => esc_html__('Add image.(60x60)', 'taskbot'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'author_name',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Author name', 'taskbot'),
                'description' => esc_html__('Add author name. leave it empty to hide.', 'taskbot'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'author_designation',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Author designation', 'taskbot'),
                'description' => esc_html__('Add author designation. leave it empty to hide.', 'taskbot'),
                'label_block' => true,
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
        $author_image       = !empty($settings['author_image']['url']) ? $settings['author_image']['url'] : '';
        $title              = !empty($settings['title']) ? $settings['title'] : '';
        $sub_title          = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
        $introduction       = !empty($settings['introduction']) ? $settings['introduction'] : '';
        $author_name        = !empty($settings['author_name']) ? $settings['author_name'] : '';
        $author_designation = !empty($settings['author_designation']) ? $settings['author_designation'] : '';
        ?>
        <div class="tk-intro-wrapper">
            <div class="tk-banner">
                <div class="tk-about_content tk-banner-intro">
                    <div class="row">
                        <div class="col-lg-10 col-xl-9 col-xxl-8">
                            <?php if (!empty($sub_title) || !empty($introduction) || !empty($title)) { ?>
                                <div class="tk-main-title-holder text-center">
                                    <?php if (!empty($sub_title) || !empty($title)) { ?>
                                        <div class="tk-maintitle">
                                            <?php if (!empty($sub_title)) { ?><h5><?php echo esc_html($sub_title); ?></h5><?php } ?>
                                            <?php if (!empty($title)) { ?><h2><?php echo esc_html($title); ?></h2><?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($introduction)) { ?>
                                        <div class="tk-main-description">
                                            <?php echo wpautop($introduction);?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if ( !empty($author_image) || !empty($author_name) || !empty($author_designation)) { ?>
                                <div class="tk-aboutusauthor">
                                    <?php if (!empty($author_image)) { ?>
                                        <figure><img src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>"> </figure>
                                    <?php } ?>
                                    <?php if (!empty($author_name) || !empty($author_designation)) { ?>
                                        <div class="tk-authorinfo">
                                            <?php if (!empty($author_name)) { ?><h4><?php echo esc_html($author_name); ?></h4><?php } ?>
                                            <?php if (!empty($author_designation)) { ?><h6><?php echo esc_html($author_designation); ?></h6><?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <?php
    }
  }

  Plugin::instance()->widgets_manager->register(new Taskbot_about_us_intro);
}
