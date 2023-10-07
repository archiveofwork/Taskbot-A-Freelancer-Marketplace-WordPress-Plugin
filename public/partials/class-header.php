<?php
/**
 * The override theme header
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */

if (!class_exists('TaskbotHeader')) {

    class TaskbotHeader {

        function __construct() {
			add_action( 'get_header', array(&$this, 'taskbot_do_process_headers'), 5, 2 );
			add_action('taskbot_process_headers', array(&$this, 'taskbot_do_process_headers_v1'));
            add_action('taskbot_process_admin_headers', array(&$this, 'taskbot_do_process_admin_headers'));
        }
		// Method to get the header
		public function taskbot_do_process_headers($name, $args){
			global $taskbot_settings;

			if (is_page_template('templates/dashboard.php') || is_page_template( 'templates/add-offer.php') || is_page_template('templates/add-task.php') || is_page_template('templates/add-project.php') ) {
				include taskbot_load_template( 'templates/headers/user-dashboard-header' );
				$templates      = array();
				$name           = (string) $name;

				if ( '' !== $name ) {
					$templates[] = "header-{$name}.php";
				}

				$templates[]        = 'header.php';
				remove_all_actions( 'wp_head' );

				ob_start();
				// It cause a `require_once` so, in the get_header it self it will not be required again.
				locate_template( $templates, true );
				ob_get_clean();
			} elseif(is_page_template('templates/admin-dashboard.php') ){
                include taskbot_load_template( 'templates/headers/admin-dashboard-header' );
				$templates = array();
				$name = (string) $name;

				if ( '' !== $name ) {
					$templates[] = "header-{$name}.php";
				}
				$templates[] = 'header.php';
				remove_all_actions( 'wp_head' );

				ob_start();
				// It cause a `require_once` so, in the get_header it self it will not be required again.
				locate_template( $templates, true );
				ob_get_clean();
            }
		}

        /**
         * @Prepare headers
         * @return {}
         * @author amentotech
         */
        public function taskbot_do_process_admin_headers() {
            global $current_user;
			$this->taskbot_do_process_admin_header_v1();

        }

		/**
         * @Prepare headers
         * @return {}
         * @author amentotech
         */
        public function taskbot_do_process_headers_v1() {
            global $current_user;
			$this->taskbot_do_process_header_v1();

        }

        /**
         * @Prepare admin header v1
         * @return {}
         * @author amentotech
         */
        public function taskbot_do_process_admin_header_v1() {
            global $taskbot_settings,$current_user;
			$logo   = TASKBOT_DIRECTORY_URI . '/public/images/logo.png';
            $logo   = !empty($taskbot_settings['defaul_site_logo']['url']) ? $taskbot_settings['defaul_site_logo']['url'] : $logo;
            $dashboard_url	    = Taskbot_Profile_Menu::taskbot_admin_profile_menu_link('dashboard', $current_user->ID, true, 'insights');            ?>
            <header class="tb-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="tb-headercontent">                               
                                <div class="tb-frontendsite">
                                    <a href="<?php echo esc_url(get_home_url());?>" target="_blank">
                                        <div class="tb-frontendsite__title">
                                            <h5><?php esc_html_e('Visit frontend site','taskbot');?></h5>
                                        </div>
                                        <i class="icon-external-link"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <?php
        }

		/**
         * @Prepare header v1
         * @return {}
         * @author amentotech
         */
        public function taskbot_do_process_header_v1() {
            global $taskbot_settings;
			$logo   = TASKBOT_DIRECTORY_URI . '/public/images/logo.png';
            $logo   = !empty($taskbot_settings['defaul_site_logo']['url']) ? $taskbot_settings['defaul_site_logo']['url'] : $logo;
            ?>
            <header class="tb-header">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="tb-headerwrap">
								<strong class="tb-logo">
									<a href="<?php echo esc_url(home_url('/')); ?>"><img class="amsvglogo" src="<?php echo esc_url($logo);?>" alt="<?php echo esc_attr(get_bloginfo('name'));?>"></a>
								</strong>
								<?php do_action('taskbot_process_headers_menu'); ?>
							</div>
						</div>
					</div>
				</div>
			</header>
            <?php
        }

        /**
         * @Main Navigation
         * @return {}
         */
        public static function taskbot_prepare_navigation($location = '', $id = 'menus', $class = '', $depth = '0') {

            if (has_nav_menu($location)) {
                $defaults = array(
                    'theme_location'        => "$location",
                    'menu'                  => '',
                    'container'             => 'ul',
                    'container_class'       => '',
                    'container_id'          => '',
                    'menu_class'            => "$class",
                    'menu_id'               => "$id",
                    'echo'                  => false,
                    'fallback_cb'           => 'wp_page_menu',
                    'before'                => '',
                    'after'                 => '',
                    'link_before'           => '',
                    'link_after'            => '',
                    'items_wrap'            => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'                 => "$depth",
                );
                echo do_shortcode(wp_nav_menu($defaults));
            } else {
                $defaults = array(
                    'theme_location'            => "$location",
                    'menu'                      => '',
                    'container'                 => 'ul',
                    'container_class'           => '',
                    'container_id'              => '',
                    'menu_class'                => "$class",
                    'menu_id'                   => "$id",
                    'echo'                      => false,
                    'fallback_cb'               => 'wp_page_menu',
                    'before'                    => '',
                    'after'                     => '',
                    'link_before'               => '',
                    'link_after'                => '',
                    'items_wrap'                => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'                     => "$depth",
                );
                echo do_shortcode(wp_nav_menu($defaults));
            }
        }


	}

	new TaskbotHeader();
}
