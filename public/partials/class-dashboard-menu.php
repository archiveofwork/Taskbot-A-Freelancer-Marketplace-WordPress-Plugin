<?php
/**
 * The override theme header
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot/public
 */

if (!class_exists('Taskbot_Profile_Menu')) {

    class Taskbot_Profile_Menu {

        protected static $instance = null;
        
        public function __construct() {

			add_action('taskbot_process_headers_menu', array(__CLASS__, 'taskbot_profile_menu'));
			add_action('taskbot_process_headers_sub_menu', array(__CLASS__, 'taskbot_profile_sub_menu'));
        }

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function getInstance() {
			
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

		public static function taskbot_get_admin_menu() {
			$taskbot_menu_list = array(
				'dashboard'	=> array(
					'title' 	=> esc_html__('Dashboard', 'taskbot'),
					'class'		=> 'tb-dashboard',
					'icon'		=> 'tb-icon-archive',
					'type'		=> 'none',
					'ref'		=> 'earnings',
					'mode'		=> 'insights',
					'sortorder'	=> 1,
				),
				'disputes'	=> array(
					'title' 	=> esc_html__('Disputes', 'taskbot'),
					'class'		=> 'tb-dispute',
					'icon'		=> 'tb-icon-alert-circle',
					'type'		=> 'none',
					'ref'		=> 'disputes',
					'mode'		=> 'listing',
					'sortorder'	=> 3,
				),
				'earings'	=> array(
					'title' 	=> esc_html__('Manage earnings', 'taskbot'),
					'class'		=> 'tb-earnings',
					'icon'		=> 'tb-icon-credit-card',
					'type'		=> 'none',
					'ref'		=> 'earnings',
					'mode'		=> 'manage',
					'sortorder'	=> 4,
				),
				'task'	=> array(
					'title' 	=> esc_html__('Manage task', 'taskbot'),
					'class'		=> 'tb-tasks',
					'icon'		=> 'tb-icon-activity',
					'type'		=> 'none',
					'ref'		=> 'task',
					'mode'		=> 'listing',
					'sortorder'	=> 5,
				),
				'projects'	=> array(
					'title' 	=> esc_html__('Manage projects', 'taskbot'),
					'class'		=> 'tb-tasks',
					'icon'		=> 'tb-icon-grid',
					'type'		=> 'none',
					'ref'		=> 'projects',
					'mode'		=> 'listing',
					'sortorder'	=> 6,
				),
				'logout'	=> array(
					'title' 	=> esc_html__('Logout', 'taskbot'),
					'class'		=> 'tb-notification',
					'icon'		=> 'tb-icon-power',
					'ref'		=> 'logout',
					'mode'		=> '',
					'type'		=> 'none',
					'sortorder'	=> 7,
				)
			);
			if(in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins')))){
				$taskbot_menu_list['inbox']	= array(
					'title' 	=> esc_html__('Inbox', 'taskbot'),
					'class'		=> 'tb-dispute',
					'icon'		=> 'tb-icon-message-square',
					'type'		=> 'none',
					'ref'		=> 'inbox',
					'mode'		=> 'listing',
					'sortorder'	=> 2,
				);
			}
			$taskbot_menu_list 	= apply_filters('taskbot_filter_admin_menu', $taskbot_menu_list);
			return $taskbot_menu_list;
		}

		public static function taskbot_get_dashboard_menu() {
			global $taskbot_settings,$taskbot_notification,$current_user;
			$app_task_base      = taskbot_application_access('task');
			$app_project_base   = taskbot_application_access('project');

			$taskbot_menu_list = array(
				'find-projects'	=> array(
					'title' => esc_html__('Explore all projects', 'taskbot'),
					'class'		=> 'tb-find-projects',
					'icon'		=> '',
					'ref'		=> 'find-project',
					'mode'		=> '',
					'sortorder'	=> 3,
					'type'		=> 'sellers',
				),
			);

			$user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID );
			
			if( !empty($user_type) && $user_type === 'buyers'){
				$taskbot_menu_list['find-task']	= array(
					'title' 	=> esc_html__('Find tasks', 'taskbot'),
					'class'		=> 'tb-search-task',
					'icon'		=> '',
					'sortorder'	=> 0,
					'ref'		=> 'find-task',
					'mode'		=> '',
					'type'		=> 'buyers'
				);

				$taskbot_menu_list['find-sellers']	= array(
					'title' 	=> esc_html__('Find sellers', 'taskbot'),
					'class'		=> 'tb-search-seller',
					'icon'		=> '',
					'sortorder'	=> 0,
					'ref'		=> 'find-sellers',
					'mode'		=> '',
					'type'		=> 'buyers'
				);
			}


			if( empty($app_project_base) ){
				unset($taskbot_menu_list['find-projects']);
			}
			
			if( empty($app_task_base) ){
				unset($taskbot_menu_list['find-task']);
			}

			if(!empty($taskbot_notification['notify_module'])){
				$taskbot_menu_list['notifications']	= array(
					'title' 	=> '',
					'class'		=> 'tb-menu-notifications',
					'icon'		=> '',
					'type'		=> 'none',
					'ref'		=> 'notifications',
					'mode'		=> '',
					'sortorder'	=> 6,
				);
			}

			if((in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins'))))){
				$taskbot_menu_list['inbox']	= array(
					'title' 	=> esc_html__('', 'taskbot'),
					'class'		=> 'tb-inbox',
					'icon'		=> 'tb-icon-message-square',
					'type'		=> 'none',
					'ref'		=> 'inbox',
					'mode'		=> '',
					'sortorder'	=> 7,
				);
			}

			
			$taskbot_menu_list 	= apply_filters('taskbot_filter_dashboard_menu', $taskbot_menu_list);
			return $taskbot_menu_list;
		}

		public static function taskbot_get_dashboard_sub_menu() {
			global $taskbot_settings,$taskbot_notification,$current_user;
			$app_task_base      = taskbot_application_access('task');
			$app_project_base   = taskbot_application_access('project');
			$taskbot_menu_list = array(
				'earnings'	=> array(
					'title' 	=> esc_html__('Insights', 'taskbot'),
					'class'		=> 'tb-earnings',
					'icon'		=> 'tb-icon-layers',
					'type'		=> 'sellers',
					'ref'		=> 'earnings',
					'mode'		=> '',
					'sortorder'	=> 1,
				),
				'manageprojects'	=> array(
					'title' 	=> esc_html__('Manage projects', 'taskbot'),
					'class'		=> 'tb-projectlistings',
					'icon'		=> 'tb-icon-external-link',
					'type'		=> 'buyers',
                    'ref'		=> 'projects',
                    'mode'		=> 'listing',
					'sortorder'	=> 2,
				),
				'manage-projects'	=> array(
					'title' 	=> esc_html__('Manage projects', 'taskbot'),
					'class'		=> 'tb-manageprojects',
					'icon'		=> 'tb-icon-external-link',
					'type'		=> 'sellers',
					'ref'		=> '',
					'mode'		=> '',
					'sortorder'	=> 3,
					'submenu'	=> apply_filters('taskbot_dasboard_projects_menu_filter', array(
							'find-projects'	=> array(
								'title' => esc_html__('Explore all projects', 'taskbot'),
								'class'	=> 'tb-find-projects',
								'icon'	=> '',
								'ref'		=> 'find-project',
								'mode'		=> '',
								'sortorder'	=> 3,
								'type'		=> 'sellers',
							),
							'projectlistings'	=> array(
								'title' => esc_html__('My projects', 'taskbot'),
								'class'	=> 'tb-projectlistings',
								'icon'	=> '',
								'ref'		=> 'projects',
								'mode'		=> 'listing',
								'sortorder'	=> 4,
								'type'		=> 'sellers',
							),
						)
					),
				),
				'managetasks'	=> array(
					'title' 	=> esc_html__('Manage task', 'taskbot'),
					'class'		=> 'tb-managetask',
					'icon'		=> 'tb-icon-file-text',
					'type'		=> 'sellers',
					'ref'		=> '',
					'mode'		=> '',
					'sortorder'	=> 3,
					'submenu'	=> apply_filters('taskbot_dasboard_tasks_menu_filter', array(
							'create_task'	=> array(
								'title' => esc_html__('Create a task', 'taskbot'),
								'class'	=> 'tb-tasklistings',
								'icon'	=> '',
								'ref'		=> 'create-task',
								'mode'		=> 'create',
								'sortorder'	=> 3,
								'type'		=> 'sellers',
							),
							
							'tasklistings'	=> array(
								'title' => esc_html__('Task listings', 'taskbot'),
								'class'	=> 'tb-tasklistings',
								'icon'	=> '',
								'ref'		=> 'task',
								'mode'		=> 'listing',
								'sortorder'	=> 4,
								'type'		=> 'sellers',
							),
							'orders'	=> array(
								'title' 	=> esc_html__('Orders', 'taskbot'),
								'class'		=> 'tb-orders',
								'icon'		=> '',
								'type'		=> 'sellers',
								'ref'		=> 'orders',
								'mode'		=> '',
								'sortorder'	=> 6,
							),
						)
					),
				),
				'myorders'	=> array(
					'title' 	=> esc_html__('Manage task', 'taskbot'),
					'class'		=> 'tb-myorders',
					'icon'		=> 'tb-icon-file-text',
					'type'		=> 'buyers',
					'ref'		=> 'tasks-orders',
					'mode'		=> 'listing',
					'sortorder'	=> 5,
				),
				'disputes'		=> array(
					'title' 	=> esc_html__('Disputes', 'taskbot'),
					'class'		=> 'tb-disputes',
					'icon'		=> 'tb-icon-refresh-ccw',
					'ref'		=> 'disputes',
					'mode'		=> 'listing',
					'sortorder'	=> 5,
					'type'		=> 'none',
				),
				'invoices'	=> array(
					'title' 	=> esc_html__('Invoices', 'taskbot'),
					'class'		=> 'tb-invoices',
					'icon'		=> 'tb-icon-shopping-bag',
					'ref'		=> 'invoices',
					'mode'		=> 'listing',
					'sortorder'	=> 6,
					'type'		=> 'none',
				),
			);

			if( empty($app_project_base) ){
				unset($taskbot_menu_list['manageprojects']);
				unset($taskbot_menu_list['manage-projects']);
			}
			
			if( empty($app_task_base) ){
				unset($taskbot_menu_list['myorders']);
				unset($taskbot_menu_list['managetasks']);
			}

			if( empty($app_task_base) ){
				unset($taskbot_menu_list['find-task']);
			}

			$taskbot_menu_list 	= apply_filters('taskbot_filter_dashboard_menu', $taskbot_menu_list);
			return $taskbot_menu_list;
		}


		public static function taskbot_get_dashboard_profile_menu() {
			global $taskbot_settings,$current_user;
			$user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID );
			$taskbot_menu_list = array(
				'wallet'	=> array(
					'title' 	=> esc_html__('Wallet balance:', 'taskbot'),
					'class'		=> 'tb-wallet',
					'icon'		=> '',
					'sortorder'	=> 0,
					'ref'		=> '',
					'mode'		=> '',
					'type'		=> 'buyers',
				),
				'balance'	=> array(
					'title' 	=> esc_html__('Account balance:', 'taskbot'),
					'class'		=> 'tb-wallet',
					'icon'		=> '',
					'sortorder'	=> 0,
					'ref'		=> 'earnings',
					'mode'		=> '',
					'type'		=> 'sellers',
				),
				'profile'	=> array(
					'title' 	=> esc_html__('View profile', 'taskbot'),
					'class'		=> 'tb-view-profile',
					'icon'		=> 'tb-icon-external-link',
					'data-attr'		=> array('target'=> '_blank'),
					'type'		=> 'sellers',
					'ref'		=> 'profile',
					'mode'		=> 'public',
					'sortorder'	=> 0,
				),
				'dashboard'	=> array(
					'title' 	=> esc_html__('Dashboard', 'taskbot'),
					'class'		=> 'tb-dashboard',
					'icon'		=> 'tb-icon-layers',
					'type'		=> 'none',
					'ref'		=> 'earnings',
					'mode'		=> 'insights',
					'sortorder'	=> 1,
				),
				
				'settings'	=> array(
					'title' 	=> esc_html__('Settings', 'taskbot'),
					'class'		=> 'tb-account-settings',
					'icon'		=> 'tb-icon-settings',
					'sortorder'	=> 4,
					'ref'		=> 'dashboard',
					'mode'		=> 'profile',
					'type'		=> 'none',
				),
				
				'saveditems'	=> array(
					'title' 	=> esc_html__('Saved items', 'taskbot'),
					'class'		=> 'tb-saveditems',
					'icon'		=> 'tb-icon-heart',
					'ref'		=> 'saved',
					'mode'		=> 'listing',
					'sortorder'	=> 7,
					'type'		=> 'none',
				),
				'logout'		=> array(
					'title' 	=> esc_html__('Logout', 'taskbot'),
					'class'		=> 'tb-logout',
					'icon'		=> 'tb-icon-power',
					'ref'		=> 'logout',
					'mode'		=> '',
					'sortorder'	=> 9,
					'type'		=> 'none',
				),
			);
			
			$package_option			= !empty($taskbot_settings['package_option']) && in_array($taskbot_settings['package_option'],array('paid','buyer_free')) ? true : false;
			$buyer_package_option	= !empty($taskbot_settings['package_option']) && in_array($taskbot_settings['package_option'],array('paid','seller_free')) ? true : false;
			$identity_verification	= !empty($taskbot_settings['identity_verification']) ? $taskbot_settings['identity_verification'] : false;
			$switch_user    		= !empty($taskbot_settings['switch_user']) ? $taskbot_settings['switch_user'] : false;

			if( !empty($package_option) && !empty($user_type) && $user_type === 'sellers'){
				$taskbot_menu_list['packages']	= array(
					'title' 	=> esc_html__('Packages', 'taskbot'),
					'class'		=> 'tb-earnings',
					'icon'		=> 'tb-icon-package',
					'ref'		=> 'packages',
					'mode'		=> '',
					'sortorder'	=> 3,
					'type'		=> 'sellers',
				);
			}

			if( !empty($buyer_package_option) && !empty($user_type) && $user_type === 'buyers' ){
				$taskbot_menu_list['packages']	= array(
					'title' 	=> esc_html__('Packages', 'taskbot'),
					'class'		=> 'tb-earnings',
					'icon'		=> 'tb-icon-package',
					'ref'		=> 'packages',
					'mode'		=> '',
					'sortorder'	=> 3,
					'type'		=> 'buyers',
				);
			}

			if( !empty($identity_verification) ){
				$identity_verified  		= get_user_meta($current_user->ID, 'identity_verified', true);
				$identity_verified			= !empty($identity_verified) && $identity_verified === '1' ? 'tb-identity-approved' : '';

				$taskbot_menu_list['verification']	= array(
					'title' 	=> esc_html__('Identity verification', 'taskbot'),
					'class'		=> 'tb-earnings'.' '.$identity_verified,
					'icon'		=> 'tb-icon-user-check',
					'ref'		=> 'dashboard',
					'mode'		=> 'verification',
					'sortorder'	=> 3,
					'type'		=> 'none',
				);
			}

            $user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID );

			if( !empty($switch_user) ){
				$taskbot_menu_list['switch']	= array(
//					'title' 	=> esc_html__('Switch profile', 'taskbot'),
                    'title' 	=> $user_type === 'buyers' ? __('Switch to seller','taskbot') : __('Switch to buyer','taskbot'),
					'class'		=> 'tb-earnings tb_switch_user',
					'icon'		=> 'tb-icon-repeat',
					'data-attr'		=> array('data-id'=> $current_user->ID),
					'ref'		=> '',
					'mode'		=> '',
					'sortorder'	=> 1,
					'type'		=> 'none',
				);
			}
			

			$taskbot_menu_list 	= apply_filters('taskbot_filter_dashboard_profile_menu', $taskbot_menu_list);
			return $taskbot_menu_list;
		}
		
		/**
		 * Profile Menu
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function taskbot_profile_menu() {
            global $current_user, $wp_roles, $userdata, $post;
			$user_identity 	 = intval($current_user->ID);

			$url_identity = $user_identity;
			if (isset($_GET['identity']) && !empty($_GET['identity'])) {
				$url_identity = intval($_GET['identity']);
			}

			$taskbot_user_role = apply_filters('taskbot_get_user_type', $user_identity);
			ob_start();

			if($taskbot_user_role == 'sellers' || $taskbot_user_role == 'buyers'){
				$taskbot_menu_args = array(
					'user_identity'		=> $user_identity,
					'taskbot_user_role'	=> $taskbot_user_role,
				);

				//manage services template
				taskbot_get_template(
					'dashboard/menus/menus.php', $taskbot_menu_args
				);
			} else if(is_admin()){
				//current_user_can('administrator')
			} else {
				taskbot_get_template(
					'dashboard/menus/primary-menu.php'
				);
			}

            $data	= ob_get_clean();
			echo apply_filters( 'taskbot_profile_menu', $data );
        }

		/**
		 * Profile sub menu
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function taskbot_profile_sub_menu() {
            global $current_user, $wp_roles, $userdata, $post;
			$user_identity 	 = intval($current_user->ID);

			$url_identity = $user_identity;
			if (isset($_GET['identity']) && !empty($_GET['identity'])) {
				$url_identity = intval($_GET['identity']);
			}

			$taskbot_user_role = apply_filters('taskbot_get_user_type', $user_identity);
			ob_start();

			if($taskbot_user_role == 'sellers' || $taskbot_user_role == 'buyers'){
				$taskbot_menu_args = array(
					'user_identity'		=> $user_identity,
					'taskbot_user_role'	=> $taskbot_user_role,
				);

				//manage services template
				taskbot_get_template(
					'dashboard/menus/sub-menus.php', $taskbot_menu_args
				);
			}
            $data	= ob_get_clean();
			echo apply_filters( 'taskbot_profile_sub_menus', $data );
        }

		/**
		 * Generate Menu Link
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function taskbot_custom_profile_menu_link($ref = '', $id = '', $key='', $return = true ) {

			//$profile_page = '';
			$profile_page = taskbot_get_page_uri('dashboard');

            if ( empty( $profile_page ) ) {
                $permalink = home_url('/');
            } else {
                $query_arg['ref'] = urlencode($ref);

                //id for edit record
                if (!empty($id)) {
                    $query_arg['id'] = urlencode($id);
                }

				if (!empty($key)) {
                    $query_arg['key'] = urlencode($key);
                }

                $permalink = add_query_arg(
                        $query_arg, esc_url( $profile_page  )
                );

            }

            if ($return) {
                return esc_url_raw($permalink);
            } else {
                echo esc_url_raw($permalink);
            }
        }

		/**
		 * Generate Menu Link
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function taskbot_profile_admin_menu_link($ref = '', $user_identity = '', $return = false, $mode = '', $id = '') {

			$profile_page = taskbot_get_page_uri('admin_dashboard');

            if ( empty( $profile_page ) ) {
                $permalink = home_url('/');
            } else {
                $query_arg['ref'] = urlencode($ref);

                //mode
                if (!empty($mode)) {
                    $query_arg['mode'] = urlencode($mode);
                }

                //id for edit record
                if (!empty($id)) {
                    $query_arg['id'] = urlencode($id);
                }

                $query_arg['identity'] = urlencode($user_identity);

                $permalink = add_query_arg(
                        $query_arg, esc_url( $profile_page  )
                );

            }

            if ($return) {
                return esc_url_raw($permalink);
            } else {
                echo esc_url_raw($permalink);
            }
        }

		/**
		 * Generate Menu Link
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function taskbot_profile_menu_link($ref = '', $user_identity = '', $return = false, $mode = '', $id = '') {

			//$profile_page = '';
			$profile_page = taskbot_get_page_uri('dashboard');

            if ( empty( $profile_page ) ) {
                $permalink = home_url('/');
            } else {
                $query_arg['ref'] = urlencode($ref);

                //mode
                if (!empty($mode)) {
                    $query_arg['mode'] = urlencode($mode);
                }

                //id for edit record
                if (!empty($id)) {
                    $query_arg['id'] = urlencode($id);
                }

                $query_arg['identity'] = urlencode($user_identity);

                $permalink = add_query_arg(
                        $query_arg, esc_url( $profile_page  )
                );

            }

            if ($return) {
                return esc_url_raw($permalink);
            } else {
                echo esc_url_raw($permalink);
            }
        }

		/**
		 * Generate admin Menu Link
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function taskbot_admin_profile_menu_link($ref = '', $user_identity = '', $return = false, $mode = '', $id = '') {

			//$profile_page = '';
			$profile_page = taskbot_get_page_uri('admin_dashboard');

            if ( empty( $profile_page ) ) {
                $permalink = home_url('/');
            } else {
                $query_arg['ref'] = urlencode($ref);

                //mode
                if (!empty($mode)) {
                    $query_arg['mode'] = urlencode($mode);
                }

                //id for edit record
                if (!empty($id)) {
                    $query_arg['id'] = urlencode($id);
                }

                $query_arg['identity'] = urlencode($user_identity);

                $permalink = add_query_arg(
                        $query_arg, esc_url( $profile_page  )
                );

            }

            if ($return) {
                return esc_url_raw($permalink);
            } else {
                echo esc_url_raw($permalink);
            }
        }
		/**
		 * Generate Profile Avatar Image Link
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return
		 */
        public static function taskbot_get_avatar() {
        	global $current_user, $wp_roles, $userdata, $post;
          	$user_identity  = $current_user->ID;
			$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
			$link_id		= taskbot_get_linked_profile_id( $user_identity );
			$avatar = apply_filters(
				'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $link_id), array('width' => 50, 'height' => 50)
			);

			if (empty($avatar)){
				$user_dp = taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/fravatar-50x50.jpg');
				$avatar = !empty($taskbot_settings['taskbot_default_user_image']) ? $taskbot_settings['defaul_sellers_profile'] : $user_dp;
			}

			if( !empty($user_type) && $user_type === 'administrator'){
				$avatar	= get_avatar_url($user_identity,array('size' => 50));
			}
			?>
			<img src="<?php echo esc_url( $avatar );?>" alt="<?php esc_attr_e('User profile', 'taskbot'); ?>">
			<?php
        }
    }

    new Taskbot_Profile_Menu();
}
