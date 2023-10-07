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

if (!class_exists('TaskbotFooter')) {

    class TaskbotFooter {

        function __construct() {
            add_action( 'get_footer', array(&$this, 'taskbot_do_process_admin_footer'), 5, 2 );
        }

        /**
         * @Prepare footer for admin
         * @return {}
         * @author amentotech
         */
        public function taskbot_do_process_admin_footer($name, $args){
            global $taskbot_settings;
            if(is_page_template('templates/admin-dashboard.php') ){
                $this->taskbot_admin_dashboard_footer();
                include taskbot_load_template( 'templates/footer/footer-admin-dashboard' );
				$templates = array();
				$name = (string) $name;

				if ( '' !== $name ) {
					$templates[] = "footer-{$name}.php";
				}
				$templates[] = 'footer.php';
				remove_all_actions( 'wp_footer' );

				ob_start();
				// It cause a `require_once` so, in the get_footer it self it will not be required again.
				locate_template( $templates, true );
				ob_get_clean();
            }
        }

        /**
         * @Prepare footer for admin
         * @return {}
         * @author amentotech
         */
        public function taskbot_admin_dashboard_footer(){
            global $taskbot_settings;
            if(is_page_template('templates/admin-dashboard.php') ){
                $footer_copyright   = !empty($taskbot_settings['admin_dashboard_copyright']) ? $taskbot_settings['admin_dashboard_copyright'] : sprintf(esc_html__('Copyright  &copy;%s, All Right Reserved', 'taskbot'),date('Y'));
                ?>
                    </main>
                        <footer class="tb-footer-wrap">
                            <div class="theme-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tb-copyright">
                                            <p><?php echo do_shortcode( $footer_copyright );?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </body>
                </html>
                <?php
            }
        }
	}

	new TaskbotFooter();
}
