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

if (!class_exists('Taskbot_sort_faqs')) {
  class Taskbot_sort_faqs extends Widget_Base
  {

    /**
     *
     * @since    1.0.0
     * @access   static
     * @var      base
     */
    public function get_name()
    {
      return 'taskbot_element_sort_faqs';
    }

    /**
     *
     * @since    1.0.0
     * @access   static
     * @var      title
     */
    public function get_title()
    {
      return esc_html__('FAQ', 'taskbot');
    }

    /**
     *
     * @since    1.0.0
     * @access   public
     * @var      icon
     */
    public function get_icon()
    {
      return 'eicon-skill-bar';
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
		$faq_categories   = taskbot_elementor_get_taxonomies('faq', 'faq_categories');
		$faq_categories   = !empty($faq_categories) ? $faq_categories : array();

		$this->start_controls_section(
			'content_section',
			[
				'label'   => esc_html__('Category section', 'taskbot'),
				'tab'     => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cat_sec_title',
			[
				'type'          => Controls_Manager::TEXT,
				'label'         => esc_html__('Title', 'taskbot'),
				'description'   => esc_html__('Add title. leave it empty to hide.', 'taskbot'),
			]
		);

		$this->add_control(
			'faq_categories',
			[
				'label'     => esc_html__('Categories', 'taskbot'),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => true,
				'options'   => $faq_categories,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'search_field_section',
			[
				'label'     => esc_html__('Search section', 'taskbot'),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_search',
			[
				'label'         => esc_html__('Show search', 'taskbot'),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => esc_html__('Show', 'taskbot'),
				'label_off'     => esc_html__('Hide', 'taskbot'),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'search_tagline',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__('Search field sub title', 'taskbot'),
				'description' => esc_html__('Add search field sub title.', 'taskbot'),
				'default'     => esc_html__('Have question in mind?', 'taskbot'),
			]
		);

		$this->add_control(
			'search_title',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__('Search field title', 'taskbot'),
				'description' => esc_html__('Add search field title.', 'taskbot'),
				'default'     => esc_html__('Search from our common FAQs', 'taskbot'),
			]
		);
		$this->add_control(
			'search_details',
			[
				'type'        => Controls_Manager::TEXTAREA,
				'label'       => esc_html__('Search field details', 'taskbot'),
				'description' => esc_html__('Add search field details.', 'taskbot')
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__('Search field placeholder', 'taskbot'),
				'description' => esc_html__('Add search field placeholder.', 'taskbot'),
				'default'     => esc_html__('Search what’s frequently asked', 'taskbot'),
			]
		);

		$this->add_control(
			'search_btn_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__('Search button text', 'taskbot'),
				'description' => esc_html__('Add search button text.', 'taskbot'),
				'default'     => esc_html__('Search', 'taskbot'),
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
		$settings             = $this->get_settings_for_display();
		$cat_sec_title        = !empty($settings['cat_sec_title']) ? $settings['cat_sec_title'] : '';
		$categories           = !empty($settings['faq_categories']) ? $settings['faq_categories'] : array();
		$show_search_field    = !empty($settings['show_search']) ? $settings['show_search'] : false;
		$search_tagline       = !empty($settings['search_tagline']) ? $settings['search_tagline'] : '';
		$search_title         = !empty($settings['search_title']) ? $settings['search_title'] : '';
		$search_details       = !empty($settings['search_details']) ? $settings['search_details'] : '';
		$search_placeholder   = !empty($settings['search_placeholder']) ? $settings['search_placeholder'] : '';
		$search_btn_text      = !empty($settings['search_btn_text']) ? $settings['search_btn_text'] : '';
		$faq_first_category   = !empty($categories) ? $categories[0] : 0;
		$faq_category         = !empty($_GET['faq_category']) ? $_GET['faq_category'] : $faq_first_category;
		$faq_search           = !empty($_GET['faq_search']) ? esc_html($_GET['faq_search']) : '';
		$rand_faq             = rand(99,9999);

		$args = array(
			'post_type' 	=> 'faq',
			'numberposts' 	=> -1,
		);

		if (!empty($faq_search)) {
			$args['s'] 		= $faq_search;
			$faq_category 	= $faq_category;
		} else if (!empty($faq_category)) {
			$faq_category_page_url = add_query_arg(
				array(
					'faq_category' => $faq_category
				),
				get_permalink()
			);

			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'faq_categories',
					'field'     => 'term_id',
					'terms'     => $faq_category
				)
			);
		}

		$the_query = new \WP_Query( apply_filters('taskbot_faq_args', $args) );
		if (!empty($categories)) {?>
			<div class="tk-slider-section">
				<div class="container">
					<div class="row justify-content-center">
						<?php if (!empty($cat_sec_title)) { ?>
							<div class="col-12">
								<div class="tk-maintitle text-center">
									<h2><?php echo esc_html($cat_sec_title); ?></h2>
								</div>
							</div>
						<?php } ?>
						<div class="col-lg-10">
							<div id="tk-faqsslider-<?php echo intval($rand_faq); ?> tk-faqsslider" class="tk-faqsslider-<?php echo intval($rand_faq); ?> tk-faqsslider tk-sliderarrow">
								<div class="splide__track">
									<ul class="splide__list">
										<?php
										$count = 0;
										foreach ($categories as $cat_id) {
											$count++;
											$term                   = get_term_by('id', $cat_id, 'faq_categories');
											$image_id               = get_term_meta($term->term_id, 'faq_category_image', true);
											$thumbnail_url          = taskbot_prepare_image_source($image_id, 80, 80);
											$term_post_count        = get_term($cat_id, 'faq_categories');
											$term_post_count        = !empty($term_post_count) ? $term_post_count->count : 0;
											$faq_category_page_url  = add_query_arg(
												array('faq_category' => $term->term_id),
												get_permalink()
											);

											$active_class     = "tk-faq-category";
											if ($faq_category == $term->term_id) {
												$active_class = "tk-faq-category tk-faq-category-active";
											} else if ($count === 1 && $faq_category == 0) {
												$active_class = "tk-faq-category tk-faq-category-active";
											}
											if ($term_post_count > 0) {?>
												<li class="splide__slide">
													<a href="<?php echo esc_url($faq_category_page_url); ?>">
														<div class="tk-faq-holder">
															<div class="<?php echo esc_attr($active_class); ?>">
																<figure>
																	<?php if (!empty($thumbnail_url)) { ?>
																		<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php esc_attr_e('Faq', 'taskbot'); ?>">
																	<?php } ?>
																	<figcaption class="tk-faq_desp">
																		<?php if (!empty($term->name)) { ?>
																			<h5><?php echo esc_html($term->name); ?></h5>
																		<?php } ?>
																		<?php if (!empty($term_post_count)) { ?>
																			<span><?php echo wp_sprintf( esc_html__( '%d FAQ\'s','taskbot' ), $term_post_count); ?></span>
																		<?php } ?>
																	</figcaption>
																</figure>
															</div>
														</div>
													</a>
												</li>
											<?php } ?>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tk-main-section tb-faq-section">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-10">
							<?php if ( !empty($show_search_field) && $show_search_field === 'yes') { ?>
								<div class="tk-faq-search text-center">
									<?php if (!empty($search_tagline) || !empty($search_title) || !empty($search_details) ) { ?>
										<div class="tk-maintitle text-center">
											<?php do_action( 'taskbot_section_shaper_html' );?>
											<?php if (!empty($search_tagline)) { ?>
												<h5><?php echo esc_html($search_tagline); ?></h5>
											<?php
											}
											if ( !empty($search_title) ) { ?>
												<h2><?php echo esc_html($search_title); ?></h2>
											<?php } ?>
											<?php if( !empty($search_details) ){?>
												<p><?php echo esc_html($search_details);?></p>
											<?php } ?>
										</div>
									<?php } ?>
									<div class="tk-faq_input">
										<form method="get" action="">
											<div class="tk-inputappend">
												<i class="tb-icon-search"></i>
												<div class="tk-placeholderholder">
													<input type="text" name="faq_search" placeholder="<?php echo esc_attr($search_placeholder); ?>" value="<?php echo esc_attr($faq_search); ?>" class="form-control">
												</div>
												<div class="tk-inputappend_right">
													<input type="hidden" name="faq_category" value="<?php echo intval($faq_category); ?>"/>
													<?php if( !empty($search_btn_text) ){?>
														<button type="submit" class="tk-btn-solid-lg"><?php echo esc_html($search_btn_text); ?></button>
													<?php } ?>
												</div>
											</div>
										</form>
									</div>
								</div>
							<?php } ?>
							<div class="tk-faq-acordian">
								<?php
									$term       = get_term_by('id', $faq_category, 'faq_categories');
									$term_name  = !empty($term->name) ? sprintf(esc_html__('%s FAQ\'s','taskbot' ),$term->name) : esc_html__('FAQ\'s', 'taskbot');
								?>
								<div class="tk-acoridan_title">
									<h3><?php echo do_shortcode($term_name); ?></h3>
								</div>
								<div class="tk-acordian">
									<?php if ($the_query->have_posts()) { ?>
										<ul id="tk-accordion" class="tk-accordion">
											<?php
												$count_post = 0;
												while ($the_query->have_posts()) {
													$count_post++;
													$the_query->the_post();
													$post_id  		= get_the_ID();
													$collapse 		= ($count_post === 1) ? 'show' : '';
													$aria_expand 	= ($count_post === 1) ? 'true' : 'false';
													if(!empty($post_id)){ ?>
														<li>
															<div class="tk-accordion_title" data-bs-toggle="collapse" role="button" data-bs-target="#collapseLi<?php echo esc_attr($post_id); ?>" aria-expanded="<?php echo esc_attr($aria_expand); ?>">
																<h5><?php the_title(); ?></h5>
															</div>
															<?php if (get_the_content()) { ?>
																<div class="collapse <?php echo esc_attr($collapse); ?>" id="collapseLi<?php echo esc_attr($post_id); ?>" data-bs-parent="#tk-accordion">
																	<div class="tk-accordion_info">
																		<?php the_content(); ?>
																	</div>
																</div>
															<?php } ?>
														</li>
													<?php }
												} 
											?>
											<?php wp_reset_postdata(); ?>
										</ul>
									<?php } else { ?>
										<p><?php esc_html_e('Sorry, no FAQ\'S matched your criteria.', 'taskbot'); ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
				$is_rtl			= taskbot_splide_rtl_check();
				$scripts_faq 	= 'jQuery(document).ready(function () {
				var tk_faqsslider = document.querySelector(".tk-faqsslider-'.esc_js($rand_faq).'");
				if (tk_faqsslider != null) {
				var splide = new Splide(".tk-faqsslider-'.esc_js($rand_faq).'", {
				type: "loop",
				direction: "'.esc_js($is_rtl).'",
				perPage: 4,
				perMove: 1,
				arrows: true,
				pagination: false,
				gap: 20,
				breakpoints: {
				1400: {
				perPage: 3,
				},
				991: {
				perPage: 2,
				},
				575: {
				perPage: 2,
				gap: 20,
				arrows: false,
				pagination: true,
				focus: "center",
				},
				480: {
				perPage: 1,
				arrows: false,
				pagination: true,
				focus: "center",
				},
				}
				});
				splide.mount();
				}
				});';
				wp_add_inline_script('splide', $scripts_faq, 'after');
		}
	}
  }

  Plugin::instance()->widgets_manager->register(new Taskbot_sort_faqs);
}