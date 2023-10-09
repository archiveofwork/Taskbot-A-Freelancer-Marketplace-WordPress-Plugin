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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Taskbot_Vertical_Menu' ) ) {
	class Taskbot_Vertical_Menu extends Widget_Base {



		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 */
		public function get_name() {
			return 'taskbot_vertical_menu';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 */
		public function get_title() {
			return esc_html__( 'Vertical Menu', 'taskbot' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 */
		public function get_icon() {
			return 'eicon-nav-menu';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 */
		public function get_categories() {
			return array( 'taskbot-elements' );
		}

		/**
		 * Register category controls.
		 * @since    1.0.0
		 * @access   protected
		 */
		protected function register_controls() {
			//Content
			$this->start_controls_section(
				'content_menu',
				array(
					'label' => esc_html__( 'Menu', 'taskbot' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);

			$list  = array();
			$menus = wp_get_nav_menus();
			foreach ( $menus as $menu ) {
				$list[ $menu->slug ] = $menu->name;
			}

			if ( ! empty( $list ) ) {
				$this->add_control(
					'nav_menu',
					array(
						'label'        => __( 'Menu', 'taskbot' ),
						'type'         => Controls_Manager::SELECT,
						'options'      => $list,
						'default'      => array_keys( $list )[0],
						'save_default' => true,
						'description'  => sprintf(
						/* translators: %s: Link */
							__( 'Go to the <a href="%s" target="_blank">Menu screen</a> to manage your menus.', 'taskbot' ),
							admin_url( 'nav-menus.php' )
						),
					)
				);
			} else {
				$this->add_control(
					'nav_menu_notice',
					array(
						'type'            => Controls_Manager::RAW_HTML,
						'raw'             => '<strong>' . __( 'There are no menus in your site.', 'taskbot' ) . '</strong><br>' . sprintf(
							/* translators: %s: Title */
							__( 'Go to the <a href="%s" target="_blank">Menu screen</a> to create one.', 'taskbot' ),
							admin_url( 'nav-menus.php?action=edit&menu=0' )
						),
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					)
				);
			}

			$this->end_controls_section();

			//Styling
			$this->start_controls_section(
				'section_menu_style',
				array(
					'label' => __( 'Menu', 'taskbot' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_responsive_control(
				'alignment',
				array(
					'label'     => esc_html__( 'Alignment', 'taskbot' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'taskbot' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'taskbot' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'taskbot' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'default'   => 'left',
					'toggle'    => true,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav li a' => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'menu_typography',
					'selector' => '{{WRAPPER}} .tb-vertical-menu-nav > li > a',
				)
			);

			$this->add_control(
				'menu_width',
				array(
					'label'      => esc_html__( 'Width', 'taskbot' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 1000,
							'step' => 5,
						),
						'%'  => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .tb-vertical-menu-nav li a' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs(
				'style_tabs'
			);

			$this->start_controls_tab(
				'style_normal_tab',
				array(
					'label' => esc_html__( 'Normal', 'taskbot' ),
				)
			);

			$this->add_control(
				'menu_text_color',
				array(
					'label'     => esc_html__( 'Text Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li > a' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'menu_text_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li > a' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => 'border',
					'selector' => '{{WRAPPER}} .tb-vertical-menu-nav > li > a',
				)
			);

			$this->add_responsive_control(
				'padding',
				array(
					'label'      => esc_html__( 'Padding', 'taskbot' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'separator'  => 'before',
					'selectors'  => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'margin',
				array(
					'label'      => esc_html__( 'Spacing', 'taskbot' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'style_hover_tab',
				array(
					'label' => esc_html__( 'Hover', 'taskbot' ),
				)
			);

			$this->add_control(
				'menu_text_hover_color',
				array(
					'label'     => esc_html__( 'Text Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li > a:hover' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'menu_text_hover_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li > a:hover' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'menu_text_hover_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li > a:hover' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'style_active_tab',
				array(
					'label' => esc_html__( 'Active', 'taskbot' ),
				)
			);

			$this->add_control(
				'menu_text_active_color',
				array(
					'label'     => esc_html__( 'Text Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li.current-menu-item > a' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'menu_text_active_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li.current-menu-item > a' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'menu_text_active_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav > li.current-menu-item > a' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();

			$this->start_controls_section(
				'section_submenu_style',
				array(
					'label' => __( 'Sub Menu', 'taskbot' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sub_menu_typography',
					'selector' => '{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a',
				)
			);

			$this->start_controls_tabs(
				'sub_style_tabs'
			);

			$this->start_controls_tab(
				'sub_style_normal_tab',
				array(
					'label' => esc_html__( 'Normal', 'taskbot' ),
				)
			);

			$this->add_control(
				'sub_menu_text_color',
				array(
					'label'     => esc_html__( 'Text Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sub_menu_text_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => 'sub_menu_border',
					'selector' => '{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a',
				)
			);

			$this->add_responsive_control(
				'sub_menu_padding',
				array(
					'label'      => esc_html__( 'Padding', 'taskbot' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'separator'  => 'before',
					'selectors'  => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'sub_menu_margin',
				array(
					'label'      => esc_html__( 'Spacing', 'taskbot' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
					'selectors'  => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'sub_menu_style_hover_tab',
				array(
					'label' => esc_html__( 'Hover', 'taskbot' ),
				)
			);

			$this->add_control(
				'sub_menu_text_hover_color',
				array(
					'label'     => esc_html__( 'Text Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a:hover' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sub_menu_text_hover_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a:hover' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sub_menu_text_hover_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu > li a:hover' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'sub_menu_style_active_tab',
				array(
					'label' => esc_html__( 'Active', 'taskbot' ),
				)
			);

			$this->add_control(
				'sub_menu_text_active_color',
				array(
					'label'     => esc_html__( 'Text Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu li.current-menu-item > a' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sub_menu_text_active_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu li.current-menu-item > a' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sub_menu_text_active_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'taskbot' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .tb-vertical-menu-nav .sub-menu li.current-menu-item > a' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( ! empty( $settings['nav_menu'] ) ) {
				wp_nav_menu(
					array(
						'menu'            => $settings['nav_menu'],
						'container_class' => 'tb-vertical-menu-wrapper',
						'menu_class'      => 'tb-vertical-menu-nav',
						'fallback_cb'     => 'wp_page_menu',
						'depth'           => 2,
						'echo'            => true,
					)
				);
			}
		}
	}

	Plugin::instance()->widgets_manager->register( new Taskbot_Vertical_Menu() );
}
