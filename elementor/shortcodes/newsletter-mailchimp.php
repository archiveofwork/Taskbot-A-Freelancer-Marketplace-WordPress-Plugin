<?php
/**
 * Shortcode home banner V2
 *
 *
 * @package    Taskup
 * @subpackage Taskup/admin
 * @author     Amentotech <theamentotech@gmail.com>
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists('Taskup_Mailchimp_Newsletter') ){
	class Taskup_Mailchimp_Newsletter extends Widget_Base {

		public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
            wp_enqueue_script('taskup-particles');
        }
		
		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'taskup_mailchimp';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Mailchimp newsletter', 'taskbot' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-mail';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      category of shortcode
		 */
		public function get_categories() {
			return [ 'taskbot-elements' ];
		}

		/**
		 * Register category controls.
		 * @since    1.0.0
		 * @access   protected
		 */
		protected function register_controls() {
			//Content
			
			$this->start_controls_section(
				'content_section',
				[
					'label' => esc_html__( 'Content', 'taskbot' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Title', 'taskbot' ),
					'description'   => esc_html__( 'Add section title. Leave it empty to hide.', 'taskbot' ),
				]
			);
			$this->add_control(
				'details',
				[
					'type'      	=> Controls_Manager::TEXTAREA,
					'label'     	=> esc_html__( 'Description', 'taskbot' ),
					'description'   => esc_html__( 'Add description. Leave it empty to hide.', 'taskbot' ),
				]
			);
			
			
			$this->add_control(
				'form_text',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Form text', 'taskbot' ),
					'description'   => esc_html__( 'Add form text. Leave it empty to hide.', 'taskbot' ),
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
		protected function render() {
			$settings 		= $this->get_settings_for_display();
			$title			= !empty($settings['title']) ? $settings['title'] : '';
			$form_text		= !empty($settings['form_text']) ? $settings['form_text'] : '';

			$details			= !empty($settings['details']) ? $settings['details'] : '';
			$flag 				= rand(9999, 999999);
			?>
        	<div class="tu-joinnow-section">
				<div class="container">
	                <div class="row">
	                	<div class="col-12">
	                    	<div class="tu-joinnow">
								<div class="tu-joinnow-particles" id="tu-particles-<?php echo intval($flag);?>"></div>
								<?php if( !empty($title) || !empty($sub_title) || !empty($details) ){?>
									<div class="tu-joinnow_title">
										<?php if( !empty($title) || !empty($sub_title) ){?>
											<h3>
												<?php echo esc_html($title) ?>
												<?php if(!empty($sub_title) ){?> 
													<span><?php echo esc_html($sub_title);?></span>
												<?php } ?>
											</h3>
										<?php } ?>
										<?php if( !empty($details) ){?>
											<p><?php echo esc_html( $details );?></p>
										<?php } ?>
									</div>
								<?php } ?>
								<div class="tu-joinnow_field">
									<?php 
										if(class_exists('Taskbot_MailChimp')) {
											$mailchimp = new \Taskbot_MailChimp();
											$mailchimp->taskbot_mailchimp_form();
										}
									?>
									<?php if( !empty($form_text) ){?>
										<p><?php echo esc_html($form_text);?></p>
									<?php } ?>
								</div>
	                        </div>
						</div>
	                </div>
	            </div>
            </div>
		<?php
			$script = '
			function init_paricles(){
				var particle = document.getElementById("tu-particles-'.esc_js($flag).'");
				if (particle !== null) {
					particlesJS("tu-particles-'.esc_js($flag).'",{
						"particles": {
							"number": {
								"value": 100,
							},							
							"opacity": {
								"value": 0.1,
							},
						    "size": {
						      "value": 5,
						      "random": true,
						    },
						}
					})
				}
			}
			jQuery(document).on("ready", function(){
				init_paricles();
				setTimeout(
				  function() 
				  {
					init_paricles();
				  }, 3000);
			});';
			wp_add_inline_script('particles', $script, 'after');
		}

	}

	Plugin::instance()->widgets_manager->register( new Taskup_Mailchimp_Newsletter ); 
}