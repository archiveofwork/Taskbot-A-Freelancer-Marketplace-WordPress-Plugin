<?php

/**
 * Provide a project hooks
 *
 * This file is used to markup the project aspects of the plugin.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot/public/partials
 */
if (!class_exists('TaskbotProjectFunctions')) {
    class TaskbotProjectFunctions
    {
        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @param      string    $taskbot      The name of the plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct()
        {
            add_action('taskbot_project_sidebar', array($this, 'taskbot_project_sidebar'), 10, 2);
            add_action('taskbot_freelancer_invitation', array($this, 'taskbot_freelancer_invitation'), 10, 2);
            add_action('taskbot_custom_taxonomy_dropdown', array($this, 'taskbot_custom_taxonomy_dropdown'), 10, 2);
            add_action('taskbot_country_dropdown', array($this, 'taskbot_country_dropdown_html'), 10, 2);
            add_action('wp_ajax_taskbot_save_project', array($this, 'taskbot_save_project'));
            add_action('wp_ajax_taskbot_project_invitation', array($this, 'taskbot_project_invitation'));
            add_action('wp_ajax_taskbot_project_hiring', array($this, 'taskbot_project_hiring'));
            add_action('wp_ajax_taskbot_project_featured', array($this, 'taskbot_project_featured'));
            add_action('wp_ajax_taskbot_remove_project', array($this, 'taskbot_remove_project'));
        }

        /**
         * Remove project
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_remove_project()
        {
            global $current_user;
            $json               = array();
            if (function_exists('taskbot_is_demo_site')) {
                taskbot_is_demo_site();
            }
            if (function_exists('taskbot_verify_token')) {
                taskbot_verify_token($_POST['security']);
            }

            taskbotRemoveProject($current_user->ID, $_POST);
        }

        /**
         * Project featured
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_project_featured()
        {
            global $current_user;
            $json               = array();
            if (function_exists('taskbot_is_demo_site')) {
                taskbot_is_demo_site();
            }
            if (function_exists('taskbot_verify_token')) {
                taskbot_verify_token($_POST['security']);
            }

            taskbotProjectFeatured($current_user->ID, $_POST);
        }

        /**
         * Project hiring
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_project_hiring()
        {
            global $current_user;
            $json               = array();
            if (function_exists('taskbot_is_demo_site')) {
                taskbot_is_demo_site();
            }
            if (function_exists('taskbot_verify_token')) {
                taskbot_verify_token($_POST['security']);
            }
            $key            = !empty($_POST['key']) ? sanitize_text_field($_POST['key']) : 0;
            $wallet         = !empty($_POST['wallet']) ? sanitize_text_field($_POST['wallet']) : '';
            $proposal_id    = !empty($_POST['id']) ? intval($_POST['id']) : 0;
            taskbotProjectHiring($current_user->ID, $proposal_id, $wallet, $key);
        }



        /**
         * Project invitation
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_project_invitation()
        {
            global $current_user;
            $json               = array();
            if (function_exists('taskbot_is_demo_site')) {
                taskbot_is_demo_site();
            }
            if (function_exists('taskbot_verify_token')) {
                taskbot_verify_token($_POST['security']);
            }
            $profile_id = !empty($_POST['profile_id']) ? intval($_POST['profile_id']) : 0;
            $project_id = !empty($_POST['project_id']) ? intval($_POST['project_id']) : 0;
            taskbotInvitationProject($project_id, $profile_id, $current_user->ID);
        }

        /**
         * Save project
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_save_project()
        {
            global $current_user;
            $json               = array();
            if (function_exists('taskbot_is_demo_site')) {
                taskbot_is_demo_site();
            }
            if (function_exists('taskbot_verify_token')) {
                taskbot_verify_token($_POST['security']);
            }

            $data       = !empty($_POST['data']) ? $_POST['data'] : '';
            parse_str($data, $data);
            $data['step_id']        = !empty($_POST['step_id']) ? intval($_POST['step_id']) : 0;
            $data['project_id']     = !empty($_POST['project_id']) ? intval($_POST['project_id']) : 0;
            taskbotSaveProjectData($data);
        }
        /**
         * Project sidebar
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_country_dropdown_html($selected_country = '', $name = 'country')
        {
            $countries  = array();
            if (class_exists('WooCommerce')) {
                $countries_obj   = new WC_Countries();
                $countries   = $countries_obj->get_allowed_countries('countries');
            }
            ob_start();
?>
            <select id="task_location" class="tb-select-cat" name="<?php echo esc_attr($name); ?>" data-placeholderinput="<?php esc_attr_e('Search country', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose country', 'taskbot'); ?>">
                <option value="" selected hidden disabled><?php esc_html_e('Choose country', 'taskbot'); ?></option>
                <?php if (!empty($countries)) {
                    foreach ($countries as $key => $item) {
                        $selected = '';
                        if (!empty($selected_country) && $selected_country === $key) {
                            $selected = 'selected';
                        }
                ?>
                        <option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
                <?php }
                } ?>
            </select>
        <?php
            echo ob_get_clean();
        }

        /**
         * Project sidebar
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_project_sidebar($step_id = '', $post_id = '')
        {
            global $current_user;
            $tabs           = taskbot_list_project_steps($step_id, $post_id);
            $dashboad_page  = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $current_user->ID, true, 'listing');;
            ob_start();
        ?>
            <div class="col-xl-3 col-lg-4 ">
                <aside class="tk-status-holder">
                    <ul class="tk-status-tabs">
                        <?php
                        foreach ($tabs as $key => $value) {
                            $title          = !empty($value['title']) ? $value['title'] : '';
                            $details        = !empty($value['details']) ? $value['details'] : '';
                            $active_class   = !empty($step_id) && $step_id == $key ? 'tk-current-status' : "";
                            if (!empty($step_id) && $step_id > intval($key)) {
                                $page_link  = taskbot_get_page_uri('add_project_page') . '?step=' . intval($key) . '&post_id=' . intval($post_id);
                                $details    = '<a href="' . esc_url($page_link) . '">' . esc_attr__('Edit details', 'taskbot') . '</a>';
                                $active_class   = $active_class . ' tk-complete-status';
                            }
                        ?>
                            <li class="<?php echo esc_attr($active_class); ?>">
                                <div class="tk-status-tabs_content">
                                    <?php if (!empty($title)) { ?>
                                        <h6><?php echo esc_html($title); ?></h6>
                                    <?php } ?>
                                    <?php if (!empty($details)) { ?>
                                        <p><?php echo do_shortcode($details); ?></p>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php if (!empty($step_id) && $step_id == '4') { ?>
                        <a href="<?php echo esc_url($dashboad_page); ?>" class="tk-btn-solid-lg-lefticon"><?php esc_html_e('Go to project listing', 'taskbot'); ?><i class="tb-icon-chevron-right"></i></a>
                    <?php } ?>
                </aside>
            </div>
        <?php
            echo ob_get_clean();
        }

        /**
         * Tasks user ratings
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return
         */
        public function taskbot_freelancer_invitation($project_id = 0, $profile_id = 0)
        {
            $project_meta           = !empty($project_id) ? get_post_meta($project_id, 'tb_project_meta', true) : array();
            $project_meta           = !empty($project_meta) ? $project_meta : array();
            $invitated_freelancers  = !empty($project_meta['invitation']) ? $project_meta['invitation'] : array();
            $bid_class              = !empty($invitated_freelancers) && is_array($invitated_freelancers) && isset($invitated_freelancers[$profile_id]) ? 'tb-invite-sent' : 'tb-invite-bid tk-invite-bidbtn';
            $bid_text               = !empty($invitated_freelancers) && is_array($invitated_freelancers) && isset($invitated_freelancers[$profile_id]) ? esc_html__('Invitation sent', 'taskbot') : esc_html__('Invite to bid', 'taskbot');
            ob_start();
        ?>
            <div class="tk-bidbtn">
                <a href="<?php echo esc_url(get_permalink($profile_id)); ?>"><?php esc_html_e('View profile', 'taskbot'); ?></a>
                <span class="tb-btn-bit <?php echo esc_attr($bid_class); ?>" data-profile_id="<?php echo intval($profile_id); ?>" data-project_id="<?php echo intval($project_id); ?>"><?php echo esc_html($bid_text); ?></span>
            </div>
        <?php
            echo ob_get_clean();
        }
        /**
         * Project sidebar
         *
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         * @return 
         */
        public function taskbot_custom_taxonomy_dropdown($term_arg = array(), $post_id = '')
        {
            $args       = array(
                'taxonomy'      => !empty($term_arg['taxonomy']) ? $term_arg['taxonomy'] : '',
                'orderby'       => !empty($term_arg['orderby']) ? $term_arg['orderby'] : 'name',
                'hide_empty'    => false
            );
            $taxonomies     = get_terms($args);
            $name           = !empty($term_arg['name']) ? $term_arg['name'] : '';
            $class          = !empty($term_arg['class']) ? $term_arg['class'] : '';
            ob_start();
        ?>
            <select name="<?php echo esc_attr($name); ?>" class="<?php echo esc_attr($class); ?> tb-select2-cat" multiple="multiple">
                <?php foreach ($taxonomies as $key => $taxonomy) {
                    $selected   = '';
                    if (!empty($term_arg['selected']) && is_array($term_arg['selected'])) {
                        $selected   = in_array($taxonomy->term_id, $term_arg['selected']) ? 'selected'  : '';
                    }
                ?>
                    <option value="<?php echo intval($taxonomy->term_id); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($taxonomy->name); ?></option>
                <?php } ?>
            </select>
        <?php
            echo ob_get_clean();
        }
    }
    new TaskbotProjectFunctions();
}

/**
 * List project steps
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('taskbot_list_project_steps')) {
    function taskbot_list_project_steps($step_id = '', $post_id = '')
    {
        $lists  = array(
            '2' => array(
                'title'     => esc_html__('About project', 'taskbot'),
                'details'   => esc_html__('Add details to your project that explain well to all freealncers', 'taskbot')
            ),
            '3' => array(
                'title'     => esc_html__('Freelancer preferences', 'taskbot'),
                'details'   => esc_html__('Select which skills you want in your freelancer', 'taskbot')
            ),
            '4' => array(
                'title'     => esc_html__('Recommended freelancers', 'taskbot'),
                'details'   => esc_html__('Hire best match for your project', 'taskbot')
            )
        );
        $lists  = apply_filters('taskbot_filter_list_project_steps', $lists);
        return $lists;
    }
}

/**
 * List project type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('taskbot_project_type')) {
    function taskbot_project_type($type = '')
    {
        $lists  = array(
            'fixed' => array(
                'title'     => esc_html__('Fixed', 'taskbot'),
                'details'   => esc_html__('Pay freelancer on fixed milestone rate', 'taskbot'),
                'icon'      => 'tb-icon-copy tk-red-icon'
            )
        );

        $lists  = apply_filters('taskbot_filter_project_type', $lists);
        if (!empty($type)) {
            $lists   = !empty($lists[$type]) ? $lists[$type] : array();
        }
        return $lists;
    }
}

/**
 * List project location type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('taskbot_project_location_type')) {
    function taskbot_project_location_type($key = '')
    {
        global $taskbot_settings;
        $lists  = array(
            'remote'                    => esc_html__('Remote', 'taskbot'),
            'partially_remote'          => esc_html__('Partially remote', 'taskbot'),
            'location'                  => esc_html__('Onsite', 'taskbot'),
        );

        $lists  = apply_filters('taskbot_filter_project_location_type', $lists);
        if (!empty($key)) {
            $lists  = !empty($lists[$key]) ? $lists[$key] : '';
        }
        return $lists;
    }
}

/**
 * List project type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('taskbot_project_recomended_freelancers')) {
    function taskbot_project_recomended_freelancers($step_id = '', $post_id = '')
    {
        $lists  = array(
            'skills'                => esc_html__('Skills', 'taskbot'),
            'languages'             => esc_html__('Languages', 'taskbot'),
        );
        $lists  = apply_filters('taskbot_filter_project_recomended_freelancers', $lists);
        return $lists;
    }
}

/**
 * List project type
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if (!function_exists('taskbotProjectValidations')) {
    function taskbotProjectValidations($step_number = '', $key = '')
    {
        $lists  = array(
            2 => array(
                'title'     => esc_html__('Project creation step 2 validation', 'taskbot'),
                'details'   => esc_html__('Please select required fields for project step2', 'taskbot'),
                'fields'    => array(
                    'duration'      => esc_html__('Please select duration', 'taskbot'),
                    'categories'    => esc_html__('Please select category', 'taskbot'),
                    'details'       => esc_html__('Project details is required', 'taskbot'),
                ),
                'default'    => array('details', 'categories')
            ),
            3 => array(
                'title'     => esc_html__('Project creation step 3 validation', 'taskbot'),
                'details'   => esc_html__('Please select required fields for project step 3', 'taskbot'),
                'fields'    => array(
                    'expertise_level'       => esc_html__('Please select expertise level', 'taskbot'),
                    'skills'                => esc_html__('Please select skills', 'taskbot'),
                    'languages'             => esc_html__('Please select languages', 'taskbot'),
                ),
                'default'    => array('skills', 'expertise_level')
            )
        );
        $lists  = apply_filters('taskbot_filter_projectValidations', $lists);
        if (!empty($step_number) && !empty($key)) {
            $lists  = !empty($lists[$step_number]['fields'][$key]) ? $lists[$step_number]['fields'][$key] : '';
        }
        return $lists;
    }
}

/**
 * Remove project
 *
 */
if (!function_exists('taskbotRemoveProject')) {
    function taskbotRemoveProject($user_id = 0, $data = array(), $option_type = '')
    {
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action', 'taskbot');

        if (!empty($data['id'])) {
            $project_id     = !empty($data['id']) ? intval($data['id']) : 0;
            $post_status    = !empty($project_id) ? get_post_status($project_id) : "";
            $post_author    = get_post_field('post_author', $project_id);

            if (!empty($post_author) && $post_author == $user_id && in_array($post_status, array('draft', 'pending', 'publish'))) {
                wp_delete_post($project_id, true);

                //Delete Proposals
                $taskbot_args = array(
                    'post_type'         => 'proposals',
                    'post_status'       => array('publish','hired','cancelled','rejected','completed','disputed','refunded'),
                    'posts_per_page'    => -1,
                );
                
                $taskbot_args['meta_query'] = array(
                    array(
                        'key'       => 'project_id',
                        'value'     => $project_id,
                        'compare'   => '=',
                        'type'      => 'NUMERIC',
                    )
                );
                
                $taskbot_query      = get_posts($taskbot_args);
                if(!empty($taskbot_query)){
                    foreach($taskbot_query as $key => $proposal){
                        wp_delete_post($proposal->ID, true);
                    }
                }
                
                $json['type']           = 'success';
                $json['message_desc']   = esc_html__('Project has been deleted successfully', 'taskbot');

                if (empty($option_type)) {
                    wp_send_json($json);
                } else {
                    return $json;
                }
            } else {
                if (empty($option_type)) {
                    wp_send_json($json);
                } else {
                    return $json;
                }
            }
        } else {
            if (empty($option_type)) {
                wp_send_json($json);
            } else {
                return $json;
            }
        }
    }
}

/**
 * Project Invitation
 *
 */
if (!function_exists('taskbotProjectFeatured')) {
    function taskbotProjectFeatured($user_id = 0, $data = array(), $option_type = '')
    {
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action', 'taskbot');
        if (!empty($data['id']) && !empty($data['value'])) {
            $value      = !empty($data['value']) ? $data['value'] : '';
            $id         = !empty($data['id']) ? intval($data['id']) : '';
            $product    = wc_get_product(absint($id));
            $is_featured    = false;
            if (!empty($value) && $value === 'no') {
                $product->set_featured(false);
                $product->save();
            } else if (!empty($value) && $value === 'yes') {
                $featured_option    = taskbotCheckBuyerPackage($user_id, 'featured_projects_allowed', $option_type);
                if (!empty($featured_option)) {
                    $product->set_featured(true);
                    $product->save();
                    taskbotUpdateBuyerPackage($user_id, 'featured_projects_allowed', $id);
                    $is_featured    = true;
                }
            }
            update_post_meta($id, '_featured_task', $value);
            update_post_meta($id, 'is_featured', $is_featured);
            $json                   = array();
            $json['type']           = 'success';
            $json['message_desc']   = esc_html__('You have successfully update featured option for this project', 'taskbot');
            if (empty($option_type)) {
                wp_send_json($json);
            } else {
                return $json;
            }
        } else {
            if (empty($option_type)) {
                wp_send_json($json);
            } else {
                return $json;
            }
        }
    }
}

/**
 * Project Invitation
 *
 */
if (!function_exists('taskbotProjectHiring')) {
    function taskbotProjectHiring($user_id = 0, $proposal_id = 0, $wallet = '', $key = '', $option_type = ''){
        global $current_user,$woocommerce,$taskbot_settings;
        $admin_commision_buyers     =  !empty($taskbot_settings['admin_commision_buyers']) ? $taskbot_settings['admin_commision_buyers'] : 0;
        $commission_text            =  !empty($taskbot_settings['commission_text']) ? $taskbot_settings['commission_text'] : esc_html__('Processing fee', 'taskbot');

        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are redirecting to the checkout page', 'taskbot');

        if (!empty($user_id) && !empty($proposal_id)) {
            $project_id = get_post_meta($proposal_id, 'project_id', true);
            $project_id = !empty($project_id) ? intval($project_id) : 0;
            $post_author = get_post_field('post_author', $project_id);

            if (!empty($post_author) && $post_author != $user_id) {
                if (empty($type)) {
                    wp_send_json($json);
                }
            }

            $project_meta   = get_post_meta($project_id, 'tb_project_meta', true);
            $project_meta   = !empty($project_meta) ? $project_meta : array();
            $project_type   = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
            $proposal_meta  = get_post_meta($proposal_id, 'proposal_meta', true);
            $proposal_meta  = !empty($proposal_meta) ? $proposal_meta : array();
            $price          = 0;
            $cart_meta                          = array();

            if (!empty($project_type) && $project_type === 'fixed') {

                if (!empty($proposal_meta['proposal_type']) && $proposal_meta['proposal_type'] === 'milestone') {
                    if (empty($key)) {
                        $json['message_desc']   = esc_html__('You are not allowed to perform this action', 'taskbot');
                        if (empty($type)) {
                            wp_send_json($json);
                        }
                    } else {
                        $price                      = isset($proposal_meta['milestone'][$key]['price']) ? $proposal_meta['milestone'][$key]['price'] : 0;
                        $cart_meta['milestone_id']    = $key;
                    }
                } else if (!empty($proposal_meta['proposal_type']) && $proposal_meta['proposal_type'] === 'fixed') {
                    $price  = isset($proposal_meta['price']) ? $proposal_meta['price'] : 0;
                } else {
                    $price  = isset($proposal_meta['price']) ? $proposal_meta['price'] : 0;
                }

                if (class_exists('WooCommerce')) {
                    global $woocommerce;

                    if (!empty($option_type) && $option_type === 'mobile') {
                        check_prerequisites($user_id);
                    }

                    $woocommerce->cart->empty_cart();
                    $service_fee    = taskbot_commission_fee($price);
                    $admin_shares   = !empty($service_fee['admin_shares']) ? $service_fee['admin_shares'] : 0.0;
                    $seller_shares  = !empty($service_fee['seller_shares']) ? $service_fee['seller_shares'] : $price;
                    $seller_id      = get_post_field('post_author', $proposal_id);
                    $user_balance   = !empty($user_id) ? get_user_meta($user_id, '_buyer_balance', true) : '';
                    $product_id                         = taskbot_buyer_wallet_create();
                    
                    if (!empty($wallet) && !empty($user_balance) && $user_balance < $price) {
                        $cart_meta['wallet_price']            = $user_balance;
                    }

                    $buyer_service_fee		= taskbot_processing_fee_calculation('projects',$price);

                    $cart_meta['hiring_product_id']     = $product_id;
                    $cart_meta['product_name']          = esc_html__('Hiring project', 'taskbot');
                    $cart_meta['price']                 = $price;
                    $cart_meta['payment_type']          = 'projects';
                    $cart_meta['project_type']          = $project_type;
                    $cart_meta['buyer_id']              = $user_id;
                    $cart_meta['seller_id']             = $seller_id;
                    $cart_meta['admin_shares']          = $admin_shares;
                    $cart_meta['seller_shares']         = $seller_shares;
                    $cart_meta['project_id']            = $project_id;
                    $cart_meta['proposal_id']           = $proposal_id;
                    $cart_meta['proposal_meta']         = $proposal_meta;
                    $cart_meta['processing_fee']	    = !empty( $buyer_service_fee['commission_amount'] ) ? $buyer_service_fee['commission_amount'] : 0.0;

                    $cart_data  = array(
                        'hiring_product_id'     => $product_id,
                        'cart_data'             => $cart_meta,
                        'project_type'          => $project_type,
                        'price'                 => $price,
                        'payment_type'          => 'projects',
                        'admin_shares'          => $admin_shares,
                        'seller_shares'         => $seller_shares,
                        'project_id'            => $project_id,
                        'proposal_id'           => $proposal_id,
                        'buyer_id'              => $user_id,
                        'seller_id'             => $seller_id,
                    );

                    $woocommerce->cart->empty_cart();
                    $cart_item_data = apply_filters('taskbot_project_hiring_cart_data', $cart_data);

                    WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
                    if (!empty($wallet) && !empty($user_balance) && $user_balance >= $price) {
                        $order_id               = taskbot_place_order($user_id, 'project-wallet');

                        if (!empty($option_type) && $option_type === 'mobile') {
                            $order_details  = !empty($order_id) ? get_post_meta($order_id, 'cus_woo_product_data', true) : array();
                            taskbot_update_project_data($order_id, $order_details);
                            taskbot_complete_order($order_id);
                        }

                        $json['checkout_url']    = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $user_id, true, 'activity', $proposal_id);
                        $json['order_id']       = $order_id;
                        $json['type']           = 'success';
                        $json['message_desc']   = esc_html__('You have successfully completed this order', 'taskbot');

                        if (empty($option_type)) {
                            wp_send_json($json);
                        } else {
                            return $json;
                        }
                    } else if (!empty($option_type) && $option_type === 'mobile') {
                        $linked_profile_id  = taskbot_get_linked_profile_id($user_id);
                        if (!empty($linked_profile_id) && !empty($cart_data)) {
                            update_post_meta($linked_profile_id, 'mobile_checkout_data', $cart_data);
                            $mobile_checkout    = taskbot_get_page_uri('mobile_checkout');
                            if (!empty($mobile_checkout)) {
                                $json['type']           = 'success';
                                $json['message_desc']   = esc_html__('You have successfully completed this order', 'taskbot');
                                $json['checkout_url']    = $mobile_checkout . '?post_id=' . $linked_profile_id;
                                return $json;
                            }
                        }
                    } else {
                        $json['checkout_url']       = wc_get_checkout_url();
                        $json['type']               = 'success';
                        if (empty($type)) {
                            wp_send_json($json);
                        }
                    }
                }
            } else {
                do_action('taskbot_project_hiring_options', $user_id, $proposal_id, $wallet, $key, $option_type);
            }
        } else {
            if (empty($type)) {
                wp_send_json($json);
            }
        }
    }
}
/**
 * Project Invitation
 *
 */
if (!function_exists('taskbotInvitationProject')) {
    function taskbotInvitationProject($project_id = 0, $profile_id = 0, $user_id = 0, $type = '')
    {
        $json                   = array();
        $json['type']           = 'error';
        $json['message_desc']   = esc_html__('You are not allowed to perform this action', 'taskbot');
        if (!empty($profile_id) && !empty($project_id) && !empty($user_id)) {
            $post_author    = !empty($project_id) ? intval($project_id) : 0;
            if (!empty($post_author) && $project_id == $post_author) {
                $gmt_time                = current_time('mysql', 1);
                $project_status         = get_post_status($project_id);
                $post_status            = get_post_meta($project_id, '_post_project_status', true);
                $project_meta           = !empty($project_id) ? get_post_meta($project_id, 'tb_project_meta', true) : array();
                $update_invitation      = array(
                    'invitated_date'    => '',
                    'created_date'      => $gmt_time
                );
                $json['message_desc']   = esc_html__('Invitation sent', 'taskbot');
                if (!empty($post_status) && in_array($post_status, array('requested', 'rejected', 'pending', 'publish')) && !empty($project_status) && in_array($project_status, array('draft', 'pending', 'rejected'))) {
                    $update_invitation['status']        = 'pending';
                    $json['type']                       = 'success';
                } else if (!empty($post_status) && $post_status === 'publish' && !empty($project_status) && $project_status === 'publish') {
                    $update_invitation['status']            = 'publish';
                    $update_invitation['invitated_date']    = $gmt_time;
                    $json['type']                           = 'success';
                    taskbotSellerProjectInvitation($project_id, $profile_id);
                }
                $project_meta['invitation'][$profile_id] = $update_invitation;
                update_post_meta($project_id, 'tb_project_meta', $project_meta);
            }
        }
        if (empty($type)) {
            wp_send_json($json);
        } else {
            return $json;
        }
    }
}

/**
 * Seller notification for project invitation
 *
 */
function taskbotSellerProjectInvitation($project_id = 0, $profile_id = 0)
{
    global $taskbot_settings;
    $invitation_email_switch        = !empty($taskbot_settings['email_project_invitation_seller']) ? $taskbot_settings['email_project_invitation_seller'] : true;
    // Notification and email to buyer for task publish
    $seller_id                          = get_post_field('post_author', $profile_id);
    $buyer_id                           = get_post_field('post_author', $project_id);
    $buyer_profile_id                   = !empty($buyer_id) ? taskbot_get_linked_profile_id($buyer_id, '', 'buyers') : '';
    $seller_profile_id                  = !empty($seller_id) ? taskbot_get_linked_profile_id($seller_id, '', 'sellers') : '';
    $notifyDetails                      = array();
    $notifyDetails['project_id']          = $project_id;
    $notifyDetails['buyer_id']          = $buyer_profile_id;
    $notifyData['post_data']            = $notifyDetails;
    $notifyData['type']                    = 'project_inviation';
    $notifyData['receiver_id']            = $seller_id;
    $notifyData['linked_profile']        = $profile_id;
    $notifyData['user_type']            = 'buyers';
    do_action('taskbot_notification_message', $notifyData);
    // Add project invitation Email
    if (class_exists('Taskbot_Email_helper') && !empty($invitation_email_switch)) {
        $emailData                      = array();
        $emailData['seller_email']      = get_userdata($seller_id)->user_email;
        $emailData['buyer_name']        = taskbot_get_username($buyer_profile_id);
        $emailData['seller_name']       = taskbot_get_username($seller_profile_id);
        $emailData['project_title']     = get_the_title($project_id);
        $emailData['project_link']      = get_the_permalink($project_id);
        if (class_exists('TaskbotProjectCreation')) {
            $email_helper = new TaskbotProjectCreation();
            $email_helper->invitation_project_seller_email($emailData);
        }
    }
}

/**
 * Project update
 *
 */
if (!function_exists('taskbotSaveProjectData')) {
    function taskbotSaveProjectData($data = array(), $type = '')
    {
        global $taskbot_settings;
        $project_id                 = !empty($data['project_id']) ? intval($data['project_id']) : 0;
        $step_id                    = !empty($data['step_id']) ? intval($data['step_id']) : 0;
        $enable_state			    = !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
        $user_id                    = !empty($type) && $type === 'mobile' ? $data['user_id'] : get_current_user_id();
        $json                       = array();
        $json['step_id']            = $step_id;

        if (!empty($step_id) && $step_id == 2) {
            $enable_zipcode     = !empty($taskbot_settings['enable_zipcode']) ? $taskbot_settings['enable_zipcode'] : "";
            $required_fields    = array(
                'title'             => esc_html__('Project title is required', 'taskbot'),
                'location'          => esc_html__('Please select location', 'taskbot'),
                'project_type'      => esc_html__('Please select project type', 'taskbot'),
            );

            $project_type   = !empty($data['project_type']) ? $data['project_type'] : '';
            if (!empty($project_type) && $project_type === 'fixed') {
                $required_fields['min_price']   = esc_html__('Minimum price is required', 'taskbot');
                $required_fields['max_price']   = esc_html__('Maximum price is required', 'taskbot');
            }

            $required_fields        = apply_filters('taskbot_project_validation_step2', $required_fields, $data);
            $taskbot_validation     = !empty($taskbot_settings['project_val_step2']) ? $taskbot_settings['project_val_step2'] : array();

            if (!empty($taskbot_validation)) {
                foreach ($taskbot_validation as $value) {
                    $required_fields[$value]   = taskbotProjectValidations($step_id, $value);
                }
            }

            if (!empty($data['location']) && $data['location'] === 'location') {
                if (!empty($enable_zipcode)) {
                    $required_fields['zipcode']   = esc_html__('Please add the zipcode', 'taskbot');
                }
                $required_fields['country']   = esc_html__('Country field is required', 'taskbot');
                if( !empty($enable_state) && !empty($data['country']) ){
                    if (class_exists('WooCommerce')) {
                        $countries_obj   	= new WC_Countries();
                        $states			 	= $countries_obj->get_states( $data['country'] );
                        if( !empty($states) ){
                            $required_fields['state']   = esc_html__('State field is required', 'taskbot');
                        }
                    }
                    
                }   
            }

            $json['message']        = esc_html__('Project step1', 'taskbot');
            if (!empty($required_fields)) {
                foreach ($required_fields as $key => $value) {
                    if (empty($data[$key])) {
                        $json['type']           = 'error';
                        $json['message_desc']   = $value;
                        if (empty($type)) {
                            wp_send_json($json);
                        } else {
                            return $json;
                        }
                    } else if (!empty($project_type) && $project_type === 'fixed' && !empty($key) && $key === 'max_price') {
                        if ($data['max_price'] <= $data['min_price']) {
                            $json['type']           = 'error';
                            $json['message_desc']   = esc_html__('Please add valid maximum price value', 'taskbot');
                            if (empty($type)) {
                                wp_send_json($json);
                            } else {
                                return $json;
                            }
                        }
                    } else if (!empty($project_type) && $project_type === 'fixed' && !empty($key) && $key === 'min_price') {
                        $projectmin_price = !empty($taskbot_settings['fixed_projectmin_price']) ? $taskbot_settings['fixed_projectmin_price'] : 5;
                        if ($data['min_price'] <= $projectmin_price) {
                            $json['type']           = 'error';
                            $json['message_desc']   = sprintf(esc_html__('Please add minimum price is greater then %s', 'taskbot'), taskbot_price_format($projectmin_price, 'return'));
                            if (empty($type)) {
                                wp_send_json($json);
                            } else {
                                return $json;
                            }
                        }
                    }
                }
            }

            $default_attribs = array(
                'id' => array(),
                'class' => array(),
                'title' => array(),
                'style' => array(),
                'data' => array(),
            );

            $allowed_tags   = array(
                'a' => array_merge($default_attribs, array(
                    'href' => array(),
                    'title' => array()
                )),
                'br'        => array(),
                'h1'        => array(),
                'h2'        => array(),
                'h3'        => array(),
                'h4'        => array(),
                'h5'        => array(),
                'h6'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'u'             =>  $default_attribs,
                'i'             =>  $default_attribs,
                'q'             =>  $default_attribs,
                'b'             =>  $default_attribs,
                'ul'            => $default_attribs,
                'ol'            => $default_attribs,
                'li'            => $default_attribs,
                'br'            => $default_attribs,
                'hr'            => $default_attribs,
                'strong'        => $default_attribs,
                'blockquote'    => $default_attribs,
                'del'           => $default_attribs,
                'strike'        => $default_attribs,
                'em'            => $default_attribs,
                'code'          => $default_attribs,
            );
            
            $project_title      = !empty($data['title']) ? sanitize_text_field($data['title']) : "";
            $details            = !empty($data['details']) ? wp_kses($data['details'], $default_attribs) : "";

            $project_type       = !empty($data['project_type']) ? sanitize_text_field($data['project_type']) : "";
            $min_price          = !empty($data['min_price']) ? sanitize_text_field($data['min_price']) : "";
            $max_price          = !empty($data['max_price']) ? sanitize_text_field($data['max_price']) : "";

            $categories         = !empty($data['categories']) ? intval($data['categories']) : "";
            $duration           = !empty($data['duration']) ? intval($data['duration']) : "";
            $zipcode            = !empty($data['zipcode']) ? sanitize_text_field($data['zipcode']) : "";
            $country            = !empty($data['country']) ? sanitize_text_field($data['country']) : "";
            $state              = !empty($data['state']) ? sanitize_text_field($data['state']) : "";
            $project_id         = !empty($data['project_id']) ? intval($data['project_id']) : "";
            $is_milestone       = !empty($data['is_milestone']) ? sanitize_text_field($data['is_milestone']) : "no";

            
            $project_location           = !empty($data['location']) ? sanitize_text_field($data['location']) : "";
            if ($type === 'mobile') {
                $files                  = !empty($data['attachments']) ? json_decode(stripslashes($data['attachments']), true) : array(); //old attachments
                $attachment_size        = !empty($data['attachment_size']) ? $data['attachment_size'] : 0;
            } else {
                $downloads                  = !empty($data['attachments']) ? ($data['attachments']) : "";
            }

            $video_url                  = !empty($data['video_url']) ? ($data['video_url']) : '';

            $product_data               = array();

            if (!empty($project_id)) {
                $product_data   = get_post_meta($project_id, 'tb_project_meta', true);
                $product_data   = !empty($product_data) ? $product_data : array();
                $old_zipcode    = get_post_meta($project_id, 'zipcode', true);
                $old_country    = get_post_meta($project_id, '_country', true);
                $old_location   = get_post_meta($project_id, 'location', true);
            }

            $product_data['project_type']  = $project_type;
            if (!empty($project_type) && $project_type === 'fixed') {
                $product_data['min_price']  = $min_price;
                $product_data['max_price']  = $max_price;
            }

            $tb_post_data = array(
                'post_title' => wp_strip_all_tags($project_title),
                'post_content' => $details,
                'post_type'    => 'product',
                'post_author'  => $user_id,
            );

            if (empty($project_id)) {
                $tb_post_data['post_status'] = 'draft';
                // insert the post into the database
                $project_id = wp_insert_post($tb_post_data);
                update_post_meta($project_id, 'tb_product_type', 'projects');
                wp_set_object_terms($project_id, 'projects', 'product_type', true);
                update_post_meta($project_id, '_featured_task', 'no');
                update_post_meta($project_id, 'is_featured', false);
            } else {
                $tb_post_data['ID']         = $project_id;
                $tb_post_data['post_name']  = sanitize_title(get_the_title($project_id));
                wp_update_post($tb_post_data);
            }


            $product_data['name']   = wp_strip_all_tags($project_title);
            if (!empty($project_location) && $project_location === 'location') {
                $response   = array();
                if (!empty($enable_zipcode)) {
                    if ((!empty($old_zipcode) && $old_zipcode != $zipcode && $old_country != $country) || empty($old_zipcode)) {
                        $response   = array();
                        $response   = taskbot_process_geocode_info($zipcode, $country);
                    }
                }

                if (empty($enable_zipcode)) {
                    update_post_meta($project_id, 'zipcode', 0);
                    update_post_meta($project_id, 'longitude', 0);
                    update_post_meta($project_id, 'latitude', 0);
                    update_post_meta($project_id, 'country', $country);
                    $product_data['country']        = $country;
                } else if (!empty($response)) {
                    update_post_meta($project_id, 'location', $response);
                    update_post_meta($project_id, 'zipcode', $zipcode);
                    update_post_meta($project_id, 'country', $country);
                    update_post_meta($project_id, 'longitude', $response['lng']);
                    update_post_meta($project_id, 'latitude', $response['lat']);
                    $product_data['country']        = $country;
                    $product_data['latitude']       = $response['lat'];
                    $product_data['longitude']      = $response['lng'];
                    $product_data['zipcode']        = $zipcode;
                }
            }
            
            if( !empty($enable_state) && !empty($country) ){
                $product_data['state']        = $state;
                update_post_meta($project_id, 'state', $state);
            }

            $product_data['is_milestone']       = $is_milestone;
            $product_data['video_url']          = $video_url;
            update_post_meta($project_id, 'tb_project_meta', $product_data);
            update_post_meta($project_id, '_project_location', $project_location);
            update_post_meta($project_id, 'is_milestone', $is_milestone);
            update_post_meta($project_id, '_order_status', false);
            $project_multilevel_cat         = !empty($taskbot_settings['project_multilevel_cat']) ? $taskbot_settings['project_multilevel_cat'] : 'disbale';
            
            if( !empty($project_multilevel_cat) && $project_multilevel_cat === 'enable' ){
                update_post_meta($project_id, '_cat', $categories);
                $categories         = array($categories);
                $subcats            = array();
                $category_level2    = '';
                
                if( !empty($data['taskbot_service']['category_level2'])){
                    $categories[]   = $data['taskbot_service']['category_level2'];
                    $category_level2    = $data['taskbot_service']['category_level2'];
                }
                
                if( !empty($data['taskbot_service']['category_level3'])){
                    if( is_array($data['taskbot_service']['category_level3']) ){
                        foreach($data['taskbot_service']['category_level3'] as $subcat){
                            $categories[]       = intval($subcat);
                            $subcats[]          = intval($subcat);
                        }
                    } else {
                        $categories[]   = $data['taskbot_service']['category_level3'];
                    }
                }
                $subcats_data       = !empty($subcats) && is_array($subcats) ? $subcats : '';
                $category_level2    = !empty($category_level2) ? intval($category_level2) : '';
                update_post_meta($project_id, '_sub_cat', $category_level2);
                update_post_meta($project_id, '_cat_type', $subcats_data);
            }

            wp_set_post_terms($project_id, $categories, 'product_cat');
            wp_set_post_terms($project_id, $duration, 'duration');
            update_post_meta($project_id, 'project_type', $project_type);

            if (!empty($project_type) && $project_type === 'fixed') {
                update_post_meta($project_id, 'min_price', $min_price);
                update_post_meta($project_id, 'max_price', $max_price);
            }

            if (empty($type) && $type != 'mobile') {
                if (!empty($downloads)) {
                    $download_data  = array();
                    foreach ($downloads as $key => $value) {
                        if (!empty($value['id'])) {
                            $uploaded_media                 = array();
                            $uploaded_media['id']           = intval($value['id']);
                            $uploaded_media['file']         = esc_url($value['file']);
                            $uploaded_media['name']         = esc_html($value['name']);
                            $uploaded_media['download_id']  = esc_html($value['id']);
                            $download_data[]                = $uploaded_media;
                        } else {
                            $file_url       = !empty($value) ? esc_url($value) : '';
                            $new_attachemt  = taskbot_temp_upload_to_media($file_url, $project_id);
                            $attachment_id  = !empty($new_attachemt['attachment_id']) ? $new_attachemt['attachment_id'] : '';
                            $file           = !empty($new_attachemt['url']) ? $new_attachemt['url'] : '';
                            $name           = !empty($new_attachemt['name']) ? $new_attachemt['name'] : '';
                            $download_data[]    = array(
                                'id'            => $new_attachemt['attachment_id'],
                                'name'          => $name,
                                'file'          => $file,
                                'download_id'   => $attachment_id,
                            );
                        }
                    }

                    update_post_meta($project_id, '_downloadable_files', $download_data);
                    update_post_meta($project_id, '_downloadable', 'yes');
                } else {
                    update_post_meta($project_id, '_downloadable', 'no');
                }
            } else {
                update_post_meta($project_id, '_downloadable', 'no');
                /* media attachemtns for mobile */
                $total_new_project_images = $attachment_size;
                $old_project_images = $files;

                $attachments_files  = $attachment_ids = array();
                if (!empty($_FILES) && $total_new_project_images > 0) {
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    require_once(ABSPATH . 'wp-includes/pluggable.php');
                    require_once(ABSPATH . 'wp-admin/includes/media.php');

                    /* already attached images array from api's */
                    $old_attachments = !empty($old_project_images) ? $old_project_images : array();

                    /* attached gallery images from DB */
                    $db_gallery_attachment_arr      = get_post_meta($project_id, '_downloadable_files', true);
                    $db_gallery_attachment_arr      = !empty($db_gallery_attachment_arr) ? $db_gallery_attachment_arr : array();

                    /* create array of gallery attachment id's that srote in DB */
                    $db_gallery_attachment = array();
                    if (!empty($db_gallery_attachment_arr)) {
                        $db_gallery_attachment     = wp_list_pluck($db_gallery_attachment_arr, 'attachment_id');
                    }

                    /* delete all images if empty array received from api's */
                    if (empty($old_attachments) && !empty($db_gallery_attachment)) {
                        foreach ($db_gallery_attachment as $delete_media) {
                            if (!empty($delete_media)) {
                                wp_delete_attachment($project_id, $delete_media, true);
                            }
                        }
                        delete_post_meta($project_id, '_downloadable_files');
                    }

                    /* upload new docs if exist */
                    $newyUploadGallery = array();
                    if (!empty($total_new_project_images) && $total_new_project_images > 0) {
                        /* count saved data form db for indexing */
                        $new_index    = !empty($db_gallery_attachment_arr) ?  max(array_keys($db_gallery_attachment_arr)) : 0;
                        for ($x = 0; $x < $total_new_project_images; $x++) {
                            $new_index                 = $new_index + 1;
                            $gallery_image_files     = $_FILES['project_image_' . $x];

                            $uploaded_image          = wp_handle_upload($gallery_image_files, array('test_form' => false));
                            $file_name                 = basename($gallery_image_files['name']);
                            $file_type                  = wp_check_filetype($uploaded_image['file']);

                            /* Prepare an array of post data for the attachment. */
                            $attachment_details = array(
                                'guid'                 => $uploaded_image['url'],
                                'post_mime_type'     => $file_type['type'],
                                'post_title'         => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                                'post_content'         => '',
                                'post_status'         => 'inherit'
                            );

                            $attach_id          = wp_insert_attachment($attachment_details, $uploaded_image['file']);
                            $attach_data        = wp_generate_attachment_metadata($attach_id, $uploaded_image['file']);
                            wp_update_attachment_metadata($attach_id, $attach_data);

                            $newyUploadGallery[]    = array(
                                'id'            => $attach_id,
                                'name'          => get_the_title($attach_id),
                                'file'          => wp_get_attachment_url($attach_id),
                                'download_id'   => $attachment_id,
                            );
                        }
                    }

                    /* delete some images that not send in request */
                    if (!empty($old_attachments) && !empty($db_gallery_attachment)) {
                        $updateGalleryArr = $newAttachment_ids = array();
                        $db_saved_gallery = !empty($db_gallery_attachment_arr) ? $db_gallery_attachment_arr : array();

                        if (!empty($db_saved_gallery) && !empty($old_attachments)) {
                            foreach ($db_saved_gallery as $galleryVal) {
                                foreach ($old_attachments as $oldAttachmentVal) {
                                    if ($galleryVal['id'] == $oldAttachmentVal['id']) {
                                        $updateGalleryArr[] = array(
                                            'id'                => (int)$galleryVal['id'],
                                            'name'              => $galleryVal['name'],
                                            'file'              => $galleryVal['file'],
                                            'download_id'       => (int)$galleryVal['download_id']
                                        );
                                    }
                                }
                            }
                        }
                        $galleryNew_arr = array_merge($newyUploadGallery, $updateGalleryArr);
                        update_post_meta($project_id, '_downloadable_files', $galleryNew_arr);
                    } else {
                        update_post_meta($project_id, '_downloadable_files', $newyUploadGallery);
                    }
                    update_post_meta($project_id, '_downloadable', 'yes');
                } else {
                    //here deal with old data
                    /* already attached downloads array from api's */
                    $old_attachments = !empty($old_attachments) ? $old_attachments : array();

                    /* attached doc from DB */
                    $db_gallery_attachment_arr      = get_post_meta($project_id, '_downloadable_files', true);
                    $db_gallery_attachment_arr      = !empty($db_gallery_attachment_arr) ? $db_gallery_attachment_arr : array();

                    /* create array of gallery attachment id's that srote in DB */
                    $db_gallery_attachment = array();
                    if (!empty($db_gallery_attachment_arr)) {
                        $db_gallery_attachment     = wp_list_pluck($db_gallery_attachment_arr, 'attachment_id');
                    }

                    /* delete all images if empty array received from api's */
                    if (empty($old_attachments) && !empty($db_gallery_attachment)) {
                        foreach ($db_gallery_attachment as $delete_media) {
                            if (!empty($delete_media)) {
                                wp_delete_attachment($project_id, $delete_media, true);
                            }
                        }
                        delete_post_meta($project_id, '_downloadable_files');
                        update_post_meta($project_id, '_downloadable', 'no');
                    } else {
                        $newDownloadsArr = array();

                        /* delete some attachments that not send in request */
                        if (!empty($old_attachments) && !empty($db_gallery_attachment)) {
                            $db_saved_downloads_ = !empty($db_gallery_attachment_arr) ? $db_gallery_attachment_arr : array();
                            if (!empty($db_saved_downloads_)) {
                                foreach ($db_saved_downloads_ as $downloadVals) {
                                    foreach ($old_attachments as $oldVal) {
                                        if ($downloadVals['id'] == $oldVal['id']) {
                                            $newDownloadsArr[] = array(
                                                'id'                => (int)$downloadVals['id'],
                                                'name'              => $downloadVals['name'],
                                                'file'              => $downloadVals['file'],
                                                'download_id'       =>     (int)$downloadVals['download_id']
                                            );
                                        }
                                    }
                                }
                            }
                        }

                        update_post_meta($project_id, '_downloadable_files', $newDownloadsArr);
                        update_post_meta($project_id, '_downloadable', 'yes');
                    }
                }
            }

            update_post_meta($project_id, '_project_status_type', 'public');
            do_action('taskbot_save_project_step2', $project_id, $data);
            taskbotUpdateProjectStatus($project_id);
            do_action('taskbot_project_step2', $project_id, $data, $type);
            $json['type']               = 'success';
            $json['post_id']            = (int)$project_id;
            $json['step']               = 3;
            $json['redirect']           = taskbot_get_page_uri('add_project_page') . '?step=3&post_id=' . $project_id;
            $json['message']             = esc_html__('Woohoo!', 'taskbot');
            $json['message_desc']         = esc_html__('Project has been updated', 'taskbot');

            if (empty($type)) {
                wp_send_json($json);
            } else {
                return $json;
            }
        } else if (!empty($step_id) && $step_id == 3) {
            $package_option     = taskbotCheckBuyerPackage($user_id, 'number_projects_allowed', $project_id);
            $required_fields    = array(
                'no_of_freelancers'     => esc_html__('Select No. of freelancers', 'taskbot'),
                'project_id'            => esc_html__('You are not allowed to perform this action', 'taskbot')
            );
            $required_fields        = apply_filters('taskbot_project_validation_step3', $required_fields);
            $taskbot_validation     = !empty($taskbot_settings['project_val_step3']) ? $taskbot_settings['project_val_step3'] : array();

            if (!empty($taskbot_validation)) {
                foreach ($taskbot_validation as $value) {
                    $required_fields[$value]   = taskbotProjectValidations($step_id, $value);
                }
            }

            $required_fields        = apply_filters('taskbot_project_validation_step2', $required_fields);
            if (!empty($required_fields)) {
                foreach ($required_fields as $key => $value) {
                    if (empty($data[$key])) {
                        $json['type']           = 'error';
                        $json['message_desc']   = $value;
                        if (empty($type)) {
                            wp_send_json($json);
                        }
                    }
                }
            }
            
            $skills                     = !empty($data['skills']) ? ($data['skills']) : array();
            $languages                  = !empty($data['languages']) ? ($data['languages']) : array();
            $expertise_level            = !empty($data['expertise_level']) ? intval($data['expertise_level']) : "";
            $no_of_freelancers          = !empty($data['no_of_freelancers']) ? sanitize_text_field($data['no_of_freelancers']) : "";
            wp_set_post_terms($project_id, $skills, 'skills');
            wp_set_post_terms($project_id, $languages, 'languages');
            wp_set_post_terms($project_id, $expertise_level, 'expertise_level');
            update_post_meta($project_id, 'no_of_freelancers', $no_of_freelancers);
            taskbotUpdateProjectStatus($project_id);
            // update project publish or requested

            $service_status             = !empty($taskbot_settings['project_status']) ? $taskbot_settings['project_status'] : '';
            $resubmit_project_status    = !empty($taskbot_settings['resubmit_project_status']) ? $taskbot_settings['resubmit_project_status'] : 'no';

            $project_status            = get_post_meta($project_id, '_post_project_status', true);
            $project_status            = !empty($project_status) ? $project_status : '';
            $gmt_time                   = current_time('mysql', 1);
            $post_status               = get_post_status($project_id);
            $post_status               = !empty($post_status) ? $post_status : '';
            if (class_exists('Taskbot_Email_helper') && !empty($project_id)) {
                $emailData        = array();
                $profile_id     = taskbot_get_linked_profile_id($user_id, '', 'buyers');
                if (class_exists('TaskbotProjectCreation')) {
                    $emailData['buyer_name']                = taskbot_get_username($profile_id);
                    $emailData['buyer_email']                = get_userdata($user_id)->user_email;
                    $emailData['project_title']                = get_the_title($project_id);
                    $emailData['project_link']                = taskbot_get_page_uri('add_project_page') . '?step=4&post_id=' . $project_id;
                    $emailData['sender_id']                 = $user_id; //seller id
                    $emailData['receiver_id']               = taskbot_get_admin_user_id(); //admin id
                    $email_helper                           = new TaskbotProjectCreation();
                    if (!empty($taskbot_settings['email_admin_project_approval']) && $service_status == 'pending') {
                        //$emailData['project_link'] = get_the_permalink($project_id);
                        $emailData['project_link'] = Taskbot_Profile_Menu::taskbot_profile_admin_menu_link('projects', taskbot_get_admin_user_id(), true, 'listing');
                        $email_helper->post_project_approval_admin_email($emailData);
                    }
                }
            }
            $json['message_desc']         = esc_html__('Project has been updated', 'taskbot');
            if (!empty($post_status) && $post_status === 'draft' && !empty($service_status) && $service_status === 'publish') {
                // admin email for task creation
                $project_post = array(
                    'ID'            => $project_id,
                    'post_status'   => 'publish',
                );
                wp_update_post($project_post);
                update_post_meta($project_id, '_post_project_status', 'publish');
                update_post_meta($project_id, '_publish_datetime', $gmt_time);
                if (!empty($taskbot_settings['email_post_project'])) {
                    $emailData['project_link']  = taskbot_get_page_uri('add_project_page') . '?step=4&post_id=' . $project_id;
                    $email_helper->post_project_buyer_email($emailData);
                }
                if (!empty($taskbot_settings['email_project_approve'])) {
                    $emailData['project_link'] = get_the_permalink($project_id);
                    $email_helper->approved_project_buyer_email($emailData);
                }

                // Aproved task notification & email
            } else  if (!empty($post_status) && $post_status === 'draft' && !empty($service_status) && $service_status === 'pending') {
                // admin email for approved task
                $project_post = array(
                    'ID'            => $project_id,
                    'post_status'   => 'pending',
                );
                wp_update_post($project_post);
                update_post_meta($project_id, '_post_project_status', 'requested');
                if (!empty($taskbot_settings['email_post_project'])) {
                    $emailData['project_link']  = taskbot_get_page_uri('add_project_page') . '?step=4&post_id=' . $project_id;
                    $email_helper->post_project_buyer_email($emailData);
                }
                update_post_meta($project_id, '_requested_datetime', $gmt_time);
                $json['message_desc']         = esc_html__('Project has been submitted.', 'taskbot');
            } else if (!empty($post_status) && $post_status != 'draft' && !empty($service_status) && $service_status === 'pending') {
                // admin email for resubmit request
                $project_post = array(
                    'ID'            => $project_id,
                    'post_status'   => 'pending',
                );
                wp_update_post($project_post);
                update_post_meta($project_id, '_post_project_status', 'requested');
                update_post_meta($project_id, '_requested_datetime', $gmt_time);
                if (!empty($taskbot_settings['email_post_project'])) {
                    $emailData['project_link']  = taskbot_get_page_uri('add_project_page') . '?step=4&post_id=' . $project_id;
                    $email_helper->post_project_buyer_email($emailData);
                }
            }
            taskbotUpdateBuyerPackage($user_id, 'number_projects_allowed', $project_id);
            do_action('taskbot_project_step3', $project_id, $data, $type);
            $json['type']               = 'success';
            $json['post_id']            = (int)$project_id;
            $json['step']               = 4;
            $json['redirect']           = taskbot_get_page_uri('add_project_page') . '?step=4&post_id=' . $project_id;
            $json['message']             = esc_html__('Woohoo!', 'taskbot');

            if (empty($type)) {
                wp_send_json($json);
            } else {
                return $json;
            }
        }
    }
}
/**
 * Duplicate project
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbotDuplicateProject')) {
    function taskbotDuplicateProject($post_id = 0, $user_id = 0, $type = '')
    {
        $post_url        = taskbot_get_page_uri('add_project_page');
        $post_author    = !empty($post_id) ? get_post_field('post_author', $post_id,) : 0;
        //if( empty($post_id) || empty($post_author) || $post_author != $user_id ){
        if (empty($post_id)) {
            $json['type']           = 'error';
            $json['message_desc']   = esc_html__('You are not allowd to perfom this action', 'taskbot');
            if (empty($type)) {
                wp_send_json($json);
            }
        } else if (!empty($post_id)) {
            $meta_keys  = array();
            $meta_keys  = array(
                '_downloadable', 'location', 'zipcode', 'country', 'longitude', 'latitude', 'tb_project_meta', 'project_type', '_downloadable',
                'no_of_freelancers', '_downloadable_files', '_product_video', '_project_status_type', 'is_milestone', '_project_location', 'name'
            );
            $meta_keys      = apply_filters('taskbot_duplicate_job_filter', $meta_keys, $post_id);
            $project_type   = get_post_meta($post_id, 'project_type', true);
            $project_type   = !empty($project_type) ? $project_type : '';
            if (!empty($project_type) && $project_type === 'fixed') {
                if (!empty($meta_keys)) {
                    array_merge($meta_keys, array("min_price", "max_price"));
                } else {
                    $meta_keys  = array("min_price", "max_price");
                }
            }
            $project_title  = get_the_title($post_id);
            $details        = get_post_field('post_content', $post_id);
            $tb_post_data   = array(
                'post_title' => wp_strip_all_tags($project_title),
                'post_content' => $details,
                'post_type'    => 'product',
                'post_author'  => $user_id,
                'post_status'  => 'draft'
            );
            $project_id = wp_insert_post($tb_post_data);
            update_post_meta($project_id, 'tb_product_type', 'projects');
            update_post_meta($project_id, '_post_project_status', 'draft');
            wp_set_object_terms($project_id, 'projects', 'product_type', true);
            $categories = wp_get_post_terms($post_id, 'product_cat', array('fields' => 'ids'));
            $duration   = wp_get_post_terms($post_id, 'duration', array('fields' => 'ids'));
            $skills     = wp_get_post_terms($post_id, 'skills', array('fields' => 'ids'));
            $languages  = wp_get_post_terms($post_id, 'languages', array('fields' => 'ids'));

            $expertise_level  = wp_get_post_terms($post_id, 'expertise_level', array('fields' => 'ids'));

            wp_set_post_terms($project_id, $categories, 'product_cat');
            wp_set_post_terms($project_id, $duration, 'duration');
            wp_set_post_terms($project_id, $skills, 'skills');
            wp_set_post_terms($project_id, $languages, 'languages');
            wp_set_post_terms($project_id, $expertise_level, 'expertise_level');

            foreach ($meta_keys as $meta_key) {
                $key_val    = get_post_meta($post_id, $meta_key, true);
                if ($meta_key === 'tb_project_meta') {
                    $key_val['name']            = '';
                    $key_val['invitation']      = array();
                }
                update_post_meta($project_id, $meta_key, $key_val);
            }
            update_post_meta($project_id, '_featured_task', 'no');
            update_post_meta($project_id, 'is_featured', false);
            if (empty($type)) {
                $json['type']           = 'success';
                $json['redirect_url']   = !empty($post_url) ? $post_url . '?step=2&post_id=' . intval($project_id) : '';
                wp_send_json($json);
            } else if (!empty($type) && $type === 'migration') {
                return $project_id;
            } elseif (!empty($type) && $type === 'mobile') {
                $json['type']               = 'success';
                $json['project_id']         = $project_id;
                $json['message_desc']       = esc_html__('New project created', 'taskbot');
                return $json;
            }
        }
    }
}

/**
 * Price calcuation
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbotPriceCalcuation')) {
    function taskbotPriceCalcuation($post_id = 0, $price = 0, $type = '')
    {
        $price_calcuations  = taskbot_commission_fee($price);
        $json                               = array();
        $json['type']                       = 'success';
        $json['price']                      = taskbot_price_format($price, 'return');
        $json['admin_shares']               = isset($price_calcuations['admin_shares']) ? taskbot_price_format($price_calcuations['admin_shares'], 'return') : '';
        $json['user_shares']                = isset($price_calcuations['seller_shares']) ? taskbot_price_format($price_calcuations['seller_shares'], 'return') : '';
        if (empty($type)) {
            wp_send_json($json);
        }
    }
}
/**
 * Task update status
 *
 */
if (!function_exists('taskbotUpdateProjectStatus')) {
    function taskbotUpdateProjectStatus($project_id = 0)
    {
        global $taskbot_settings;
        $service_status             = !empty($taskbot_settings['project_status']) ? $taskbot_settings['project_status'] : '';
        $resubmit_project_status    = !empty($taskbot_settings['resubmit_project_status']) ? $taskbot_settings['resubmit_project_status'] : 'no';

        $project_status            = get_post_meta($project_id, '_post_project_status', true);
        $project_status            = !empty($project_status) ? $project_status : '';

        $post_status               = get_post_status($project_id);
        $post_status               = !empty($post_status) ? $post_status : '';

        if (!empty($project_status) && $project_status === 'pending' && !empty($resubmit_project_status) && $resubmit_project_status === 'yes') {
            if (empty($project_status) || $project_status != 'rejected') {
                update_post_meta($project_id, '_post_project_status', 'pending');
                if (!empty($post_status) && $post_status != 'draft') {
                    $project_post = array(
                        'ID'            => $project_id,
                        'post_status'   => $project_status,
                    );
                    wp_update_post($project_post);
                }
            }
        } else if (!empty($project_status) && $project_status === 'publish' && !empty($resubmit_project_status) && $resubmit_project_status === 'no') {
            update_post_meta($project_id, '_post_project_status', 'publish');
        } else if (empty($project_status) && $post_status === 'draft') {
            update_post_meta($project_id, '_post_project_status', 'draft');
        }
    }
}

/**
 * Project type html
 *
 */
if (!function_exists('taskbot_project_type_tag')) {
    function taskbot_project_type_tag($post_id = '')
    {
        $project_type    = get_post_meta($post_id, 'project_type', true);
        $project_type    = !empty($project_type) ? $project_type : '';
        $type_text       = !empty($project_type) && $project_type === 'fixed' ? esc_html__('Fixed price project', 'taskbot') : apply_filters('taskbot_filter_project_type_text', $project_type);
        $class           = !empty($project_type) && $project_type === 'fixed' ? 'tk-ongoing' : apply_filters('taskbot_filter_project_type_class', $project_type);
        ob_start();
        ?>
        <span class="tk-project-tag <?php echo esc_attr($class); ?>"><?php echo esc_html($type_text); ?></span>
    <?php
        echo ob_get_clean();
    }
    add_action('taskbot_project_type_tag', 'taskbot_project_type_tag', 10, 1);
}


/**
 * Project type html
 *
 */
if (!function_exists('taskbot_project_type_text')) {
    function taskbot_project_type_text($project_type = '')
    {
        $type_text  = '';
        if (!empty($project_type) && $project_type === 'fixed') {
            $type_text    = esc_html__('Fixed price project', 'taskbot');
        } else {
            $type_text =  apply_filters('taskbot_filter_project_type_text', $project_type);
        }
        ob_start();
    ?>
        <span><?php echo esc_html($type_text); ?></span>
        <?php
        echo ob_get_clean();
    }
    add_action('taskbot_project_type_text', 'taskbot_project_type_text', 10, 1);
}
/**
 * Project type html
 *
 */
if (!function_exists('taskbot_project_status_tag')) {
    function taskbot_project_status_tag($product)
    {
        $projecet_status    = get_post_meta($product->get_id(), '_post_project_status', true);
        $projecet_status    = !empty($projecet_status) ? $projecet_status : '';
        $lable              = "";
        $status_class       = "";
        switch ($projecet_status) {
            case 'pending':
                $label          = esc_html__('Pending', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'disputed':
                $label          = esc_html__('Disputed', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'draft':
                $label          = esc_html__('Drafted', 'taskbot');
                $status_class   = 'tk-project-tag tk-drafted';
                break;
            case 'publish':
                $label          = esc_html__('In queue', 'taskbot');
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'refunded':
                $label          = esc_html__('Refunded', 'taskbot');
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'completed':
                $label          = _x('Completed', 'Title for project status', 'taskbot');
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'rejected':
                $label          = esc_html__('Rejected', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'cancelled':
                $label          = esc_html__('Cancelled', 'taskbot');
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'hired':
                $label          = esc_html__('Ongoing', 'taskbot');
                $status_class   = 'tk-project-tag tk-ongoing';
                break;
            case 'requested':
                $label          = esc_html__('Under Review', 'taskbot');
                $status_class   = 'tk-project-tag tk-requested';
                break;
            default:
                $label          = esc_html__('New', 'taskbot');
                $status_class   = 'tk-project-tag';
                break;
        }
        if (!empty($label)) {
            ob_start();
        ?>
            <span class="<?php echo esc_attr($status_class); ?>"><?php echo esc_html($label); ?></span>
        <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_project_status_tag', 'taskbot_project_status_tag', 10, 1);
}
/**
 * Project price html
 *
 */
if (!function_exists('taskbot_project_price_html')) {
    function taskbot_project_price_html($post_id = '')
    {
        $project_meta    = get_post_meta($post_id, 'tb_project_meta', true);
        $project_type    = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
        $project_price   = '';
        if (!empty($project_type) && $project_type === 'fixed') {
            $min_price  = !empty($project_meta['min_price']) ? $project_meta['min_price'] : 0;
            $max_price  = !empty($project_meta['max_price']) ? $project_meta['max_price'] : 0;
            $project_price  = taskbot_price_format($min_price, 'return') . '-' . taskbot_price_format($max_price, 'return');
        } else {
            $project_price  = apply_filters('taskbot_project_price_text', $post_id);
            $project_price  = taskbot_price_format($project_price,'return');
        }

        ob_start();
        ?>
        <h3 class="tk-projec-price tb-tag-<?php echo esc_attr($project_type); ?>"><?php echo do_shortcode($project_price); ?></h3>
    <?php
        echo ob_get_clean();
    }
    add_action('taskbot_project_price_html', 'taskbot_project_price_html', 10, 1);
}

/**
 * Project price html
 *
 */
if (!function_exists('taskbot_project_price')) {
    function taskbot_project_price($post_id = '')
    {
        $project_meta    = get_post_meta($post_id, 'tb_project_meta', true);
        $project_type    = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
        $project_price   = '';

        if (!empty($project_type) && $project_type === 'fixed') {
            $min_price  = !empty($project_meta['min_price']) ? $project_meta['min_price'] : 0;
            $max_price  = !empty($project_meta['max_price']) ? $project_meta['max_price'] : 0;
            $project_price  = taskbot_price_format($min_price, 'return') . '-' . taskbot_price_format($max_price, 'return');
        } else {
            $project_price  = apply_filters('taskbot_project_price_text', $post_id);
            $project_price  = taskbot_price_format($project_price,'return');
        }
        return $project_price;
    }
}
/**
 * No of hiring freelancer
 *
 */
if (!function_exists('taskbot_total_hiring_freelancer_html')) {
    function taskbot_total_hiring_freelancer_html($post_id = '')
    {
        $no_of_freelancers       = get_post_meta($post_id, 'no_of_freelancers', true);
        $no_of_freelancers       = !empty($no_of_freelancers) ? $no_of_freelancers : '';

        ob_start();
    ?>
        <li>
            <i class="tb-icon-users tk-blue-icon"></i>
            <div class="tk-project-requirement_content">
                <div class="tk-requirement-tags">
                    <span><?php echo sprintf(_n('%s freelancer', '%s freelancers', $no_of_freelancers, 'taskbot'), $no_of_freelancers); ?></span>
                </div>
                <em><?php esc_html_e('Hiring capacity', 'taskbot'); ?></em>
            </div>
        </li>
        <?php
        echo ob_get_clean();
    }
    add_action('taskbot_total_hiring_freelancer_html', 'taskbot_total_hiring_freelancer_html', 10, 1);
}

/**
 * Project texnonimies html
 *
 */
if (!function_exists('taskbot_texnomies_html')) {
    function taskbot_texnomies_html($post_id = '', $term_name = '', $lable = '', $icon_classes = '')
    {
        $product_terms      = !empty($post_id) && !empty($term_name) ? wp_get_post_terms($post_id, $term_name) : array();
        $tag_text           = '';
        if (!empty($product_terms) && !is_wp_error($product_terms)) {
            $terms          = array();
            $extra_terms    = array();
            $counter        = 0;
            foreach ($product_terms as $term) {
                if ($counter < 4) {
                    $terms[]        = esc_html($term->name);
                } else {
                    $extra_terms[]  = esc_html($term->name);
                }
                $counter++;
            }
            $tag_text   =  join(', ', $terms);

            ob_start();
        ?>
            <li>
                <i class="<?php echo esc_attr($icon_classes); ?>"></i>
                <div class="tk-project-requirement_content">
                    <div class="tk-requirement-tags">
                        <span><?php echo esc_html($tag_text); ?></span>
                        <?php
                        if (!empty($extra_terms)) {
                            $title  = wp_sprintf(esc_html__('%d more', 'taskbot'), count($extra_terms));
                            do_action('taskbot_tooltip_tags', $title, $extra_terms);
                        } ?>
                    </div>
                    <em><?php echo esc_html($lable); ?></em>
                </div>
            </li>
        <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_texnomies_html', 'taskbot_texnomies_html', 10, 4);
}

/**
 * Texnonimies html
 *
 */
if (!function_exists('taskbot_texnomies_static_html')) {
    function taskbot_texnomies_static_html($post_id = '', $term_name = '', $lable = '')
    {
        $product_terms      = !empty($post_id) && !empty($term_name) ? wp_get_post_terms($post_id, $term_name) : array();
        $tag_text           = '';
        if (!empty($product_terms) && !is_wp_error($product_terms)) {
            $terms          = array();
            $extra_terms    = array();
            $counter        = 0;
            foreach ($product_terms as $term) {
                if ($counter < 4) {
                    $terms[]        = esc_html($term->name);
                } else {
                    $extra_terms[]  = esc_html($term->name);
                }
                $counter++;
            }
            $tag_text   =  join(', ', $terms);

            if (!empty($extra_terms)) {
                $title  = wp_sprintf(esc_html__('%d more', 'taskbot'), count($extra_terms));
                do_action('taskbot_tooltip_tags', $title, $extra_terms);
            }

            ob_start();
        ?>
            <div class="tb-sidebarcontent">
                <div class="tb-sidebarinnertitle">
                    <h6><?php echo esc_html($lable); ?></h6>
                    <h5><?php echo esc_html($tag_text); ?></h5>
                </div>
            </div>
        <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_texnomies_static_html', 'taskbot_texnomies_static_html', 10, 3);
}

/**
 * Project texnonimies html
 *
 */
if (!function_exists('taskbot_project_seller_basic')) {
    function taskbot_project_seller_basic($post_id = '')
    {
        if (!empty($post_id)) {
            $user_id    = get_post_field('post_author', $post_id);
            $user_id    = !empty($user_id) ? intval($user_id) : 0;
            $profile_id = !empty($user_id) ? taskbot_get_linked_profile_id($user_id, '', 'buyers') : 0;
            $user_name  = !empty($profile_id) ? taskbot_get_username($profile_id) : '';

            $avatar     = apply_filters(
                'taskbot_avatar_fallback',
                taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $profile_id),
                array('width' => 100, 'height' => 100)
            );

            $userdata       = get_userdata($user_id);
            $registered_on     = !empty($userdata->user_registered) ? $userdata->user_registered : '';

            $posted_date    = !empty($registered_on) ? date_i18n(get_option('date_format'),  strtotime($registered_on)) : '';
            $is_verified    = !empty($profile_id) ? get_post_meta($profile_id, '_is_verified', true) : '';
            $tb_post_meta   = get_post_meta($profile_id, 'tb_post_meta', true);
            $tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();
            $description    = !empty($tb_post_meta['description']) ? $tb_post_meta['description'] : '';
            $tagline        = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
            $address        = apply_filters('taskbot_user_address', $profile_id);

            $posted_project_count   = taskbot_get_user_projects($user_id);
            $hired_project_count    = taskbot_get_user_projects($user_id, 'hired');


            //All author posts
            $page_url    = '';
            if (function_exists('taskbot_get_page_uri')) {
                $page_url    = taskbot_get_page_uri('project_search_page');
            }

            $query_arg['owner'] = $user_id;
            $page_url = add_query_arg(
                $query_arg,
                esc_url($page_url)
            );

            ob_start();
        ?>
            <div class="tk-projectinfo">
                <div class="tk-project-box">
                    <div class="tk-verified-title">
                        <div class="tk-projectinfo_title">
                            <?php if (!empty($avatar)) { ?>
                                <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($user_name); ?>">
                            <?php } ?>
                            <?php if (!empty($user_name) || !empty($posted_date) || !empty($description)) { ?>
                                <div class="tk-verified-info">
                                    <?php if (!empty($user_name)) { ?>
                                        <h5>
                                            <?php echo esc_html($user_name); ?>
                                            <?php if (!empty($is_verified) && $is_verified === 'yes') { ?>
                                                <i class="tb-icon-check-circle" <?php echo apply_filters('taskbot_tooltip_attributes', 'verified_user'); ?>></i>
                                            <?php } ?>
                                        </h5>
                                    <?php } ?>
                                    <?php if (!empty($posted_date)) { ?>
                                        <em><?php echo sprintf(esc_html__('Member since %s', 'taskbot'), $posted_date); ?></em>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (!empty($description) || !empty($description)) { ?>
                            <div class="tk-projectinfo_description">
                                <?php if (!empty($tagline)) { ?><h6><?php echo esc_html($tagline); ?></h6><?php } ?>
                                <?php if (!empty($description)) { ?>
                                    <div class="description-with-more">
                                        <p><?php echo do_shortcode(nl2br($description)); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (isset($address) || isset($posted_project_count) || isset($hired_project_count)) { ?>
                        <ul class="tk-checkout-info">
                            <?php if (isset($address)) { ?>
                                <li>
                                    <div class="tk-total-title">
                                        <i class="tb-icon-map-pin"></i>
                                        <em><?php esc_html_e('Located in', 'taskbot'); ?></em>
                                    </div>
                                    <span><?php echo esc_html($address); ?></span>
                                </li>
                            <?php } ?>
                            <?php if (isset($posted_project_count)) { ?>
                                <li>
                                    <div class="tk-total-title">
                                        <i class="tb-icon-database"></i>
                                        <em><?php esc_html_e('Total posted projects', 'taskbot'); ?></em>
                                    </div>
                                    <span><?php echo intval($posted_project_count); ?></span>
                                </li>
                            <?php } ?>
                            <?php if (isset($hired_project_count)) { ?>
                                <li>
                                    <div class="tk-total-title">
                                        <i class="tb-icon-shopping-bag"></i>
                                        <em><?php esc_html_e('Ongoing projects', 'taskbot'); ?></em>
                                    </div>
                                    <span><?php echo intval($hired_project_count); ?></span>
                                </li>
                            <?php } ?>
                            <li>
                                <div class="tk-total-title">
                                    <a href="<?php echo esc_url($page_url); ?>" class="tb-btn"><?php esc_html_e('See all posted projects', 'taskbot'); ?><i class="tb-icon-arrow-right"></i></a>
                                </div>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_project_seller_basic', 'taskbot_project_seller_basic', 10, 1);
}

/**
 * List project filter status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_list_projects_status_filter')) {
    function taskbot_list_projects_status_filter($type = '')
    {
        global $taskbot_settings;
        $list = array(
            'any'       => esc_html__('All projects', 'taskbot'),
            'draft'     => esc_html__('Drafted', 'taskbot'),
            'pending'   => esc_html__('Pending', 'taskbot'),
            'publish'   => esc_html__('Published', 'taskbot'),
            'rejected'  => esc_html__('Rejected', 'taskbot'),
            'hired'     => esc_html__('Ongoing', 'taskbot'),
            'completed' => _x('Completed', 'Title for project status filter', 'taskbot'),
            'disputed'  => esc_html__('Disputed', 'taskbot'),
            'refunded'  => esc_html__('Refunded', 'taskbot'),
            'cancelled' => esc_html__('Cancelled', 'taskbot'),

        );
        $project_status             = !empty($taskbot_settings['project_status']) ? $taskbot_settings['project_status'] : '';
        if (!empty($project_status) && $project_status === 'pending') {
            $list['publish']    = esc_html__('Approved', 'taskbot');
        } else {
            unset($list['pending']);
            unset($list['rejected']);
        }
        $list = apply_filters('taskbot_filters_list_projects_status_filter_by', $list);
        return $list;
    }
    add_filter('taskbot_list_projects_status_filter', 'taskbot_list_projects_status_filter', 10, 1);
}

/**
 * List project filter status
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_list_proposal_status_filter')) {
    function taskbot_list_proposal_status_filter($type = '')
    {
        global $taskbot_settings;
        $list = array(
            'any'       => esc_html__('All projects', 'taskbot'),
            'draft'     => esc_html__('Drafted', 'taskbot'),
            'pending'   => esc_html__('Pending', 'taskbot'),
            'publish'   => esc_html__('Published', 'taskbot'),
            'disputed'  => esc_html__('Rejected', 'taskbot'),
            'hired'     => esc_html__('Ongoing', 'taskbot'),
            'disputed'  => esc_html__('Disputed', 'taskbot'),
            'refunded'  => esc_html__('Refunded', 'taskbot'),
            'completed' => _x('Completed', 'Title for proposal status filter', 'taskbot'),
        );
        $proposal_status             = !empty($taskbot_settings['proposal_status']) ? $taskbot_settings['proposal_status'] : '';
        if (!empty($proposal_status) && $proposal_status === 'pending') {
            $list['publish']    = esc_html__('Approved', 'taskbot');
        } else {
            unset($list['pending']);
            unset($list['rejected']);
        }
        $list = apply_filters('taskbot_filters_list_proposal_status_filter_by', $list);
        return $list;
    }
    add_filter('taskbot_list_proposal_status_filter', 'taskbot_list_proposal_status_filter', 10, 1);
}

/**
 * List saved projects
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_project_saved_item')) {
    add_action('taskbot_project_saved_item', 'taskbot_project_saved_item', 10, 4);
    function taskbot_project_saved_item($post_id = '', $user_post_id = '', $key = '', $type = '')
    {
        global $current_user;
        if (empty($user_post_id)) {
            $user_type      = apply_filters('taskbot_get_user_type', $current_user->ID);
            $user_post_id   = taskbot_get_linked_profile_id($current_user->ID, '', $user_type);
        }
        $post_type      = !empty($key) && $key === '_saved_tasks' ? 'tasks' : 'projects';
        $saved_items     = get_post_meta($user_post_id, $key, true);
        $saved_class     = !empty($saved_items) && in_array($post_id, $saved_items) ? 'bg-redheart' : 'bg-heart';
        $action          = !empty($saved_items) && in_array($post_id, $saved_items) ? '' : 'saved';

        ob_start();
        if (!empty($type) && $type == 'list') {
            $text           = !empty($saved_items) && in_array($post_id, $saved_items) ? esc_html__('Saved', 'taskbot') : esc_html__('Save', 'taskbot'); ?>
            <span class="tb_saved_items  <?php echo esc_attr($saved_class); ?>" data-action="<?php echo esc_attr($action); ?>" data-post_id="<?php echo intval($post_id); ?>" data-id="<?php echo intval($current_user->ID); ?>" data-type="<?php echo esc_attr($post_type); ?>"><i class="tb-icon-heart"></i><?php echo esc_html($text); ?></span>
        <?php } else {
            $text           = !empty($saved_items) && in_array($post_id, $saved_items) ? esc_html__('Saved', 'taskbot') : esc_html__('Add to saved items', 'taskbot'); ?>
            <span class="tb_saved_items tk-btnline <?php echo esc_attr($saved_class); ?>" data-action="<?php echo esc_attr($action); ?>" data-post_id="<?php echo intval($post_id); ?>" data-id="<?php echo intval($current_user->ID); ?>" data-type="<?php echo esc_attr($post_type); ?>"><i class="tb-icon-heart"></i>&nbsp;<?php echo esc_html($text); ?> </span>
        <?php
        }
        echo ob_get_clean();
    }
}

/**
 * Checkout cart project details
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return
 */
if (!function_exists('taskbot_cart_project_details')) {
    add_action('taskbot_cart_project_details', 'taskbot_cart_project_details', 10, 1);
    function taskbot_cart_project_details($cart_data = array())
    {
        $project_type       = !empty($cart_data['project_type']) ? $cart_data['project_type'] : '';
        $project_id         = !empty($cart_data['project_id']) ? intval($cart_data['project_id']) : '';
        $proposal_meta      = !empty($cart_data['proposal_meta']) ? $cart_data['proposal_meta'] : array();
        ob_start();
        ?>
        <div class="tb-pricing__content">
            <?php if (!empty($project_id)) { ?>
                <h4><?php echo get_the_title($project_id); ?></h4>
            <?php } ?>
            <ul class="tb-pricinglist">
                <?php if (!empty($project_id)) { ?>
                    <li>
                        <div class="tb-pricinglist__content">
                            <span><?php esc_html_e('Project name', 'taskbot'); ?></span>
                            <span> <?php echo get_the_title($project_id); ?></span>
                        </div>
                    </li>
                <?php } ?>
                <?php if (!empty($project_type) && $project_type === 'fixed' && !empty($cart_data['milestone_id']) && !empty($proposal_meta['milestone'][$cart_data['milestone_id']]['title'])) { ?>
                    <li>
                        <div class="tb-pricinglist__content">
                            <span><?php esc_html_e('Milestone title', 'taskbot'); ?></span>
                            <span> <?php echo esc_html($proposal_meta['milestone'][$cart_data['milestone_id']]['title']); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
<?php
        echo ob_get_clean();
    }
}
