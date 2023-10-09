<?php

/**
 * Get Buyer package option
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbotCheckBuyerPackage')) {
    function taskbotCheckBuyerPackage($user_id=0, $key='',$post_id=0,$type='')
    {
        global $taskbot_settings;
        $buyer_package_option   = !empty($taskbot_settings['package_option']) && in_array($taskbot_settings['package_option'],array('paid','seller_free')) ? true : false;
        if( empty($buyer_package_option) ){
            return true;
        } else {
            switch($key){
                case 'number_projects_allowed':
                    $package_option = get_post_meta( $post_id, 'package_option',true );
                    if( !empty($package_option) && $package_option === 'yes' ){
                        return true;
                    }
                break;
            }
        }

        $remaining_option       = get_user_meta( $user_id, 'remaining_buyer_package_details',true );    
        $package_details  		= get_user_meta($user_id, 'buyer_package_details', true);
        $remaining_option       = !empty($remaining_option) ? $remaining_option : array();
        $expriy_time            = !empty($remaining_option['package_expriy_date']) ? strtotime($remaining_option['package_expriy_date']) : 0;
        $current_time           = strtotime("now");
        if(!empty($current_time) && !empty($expriy_time) && $current_time > $expriy_time){
            $json['type']               = 'error';
            $json['message'] 		    = esc_html__('Oops!', 'taskbot');
            $json['message_desc'] 		= esc_html__('You are not allowed to update this. Please upgrade your package to continue.', 'taskbot');
            if( empty($type) ){
                wp_send_json($json);
            } else {
                return $json;
            }
        }

        switch($key){
            case 'number_projects_allowed':
                $number_projects_allowed    = !empty($remaining_option['number_projects_allowed']) ? ($remaining_option['number_projects_allowed']) : 0;
                if( !empty($number_projects_allowed) ){
                    return true;
                } else {
                    $json['type']               = 'error';
                    $json['message'] 		    = esc_html__('Oops!', 'taskbot');
                    $json['message_desc'] 		= esc_html__('You are not allowed to update project. Please upgrade your package to continue.', 'taskbot');
                    if( empty($type) ){
                        wp_send_json($json);
                    } else {
                        return $json;
                    }  
                }
                
            break;
            case 'featured_projects_allowed':
                $taskbot_args = array(
                    'post_type'         => 'product',
                    'post_status'       => 'publish',
                    'posts_per_page'    => -1,            
                    'author'            => $user_id,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                        ),
                        array(
                            'taxonomy' => 'product_type',
                            'field'    => 'slug',
                            'terms'    => 'projects',
                        ),
                    ),
                );
        
                $featured_task                  = get_posts($taskbot_args);
                $featured_task                  = !empty($featured_task) && is_array($featured_task) ? count($featured_task) : 0;
                $featured_projects_allowed      = !empty($package_details['featured_projects_allowed']) ? intval($package_details['featured_projects_allowed']) : 0;
                if( empty($featured_projects_allowed) || $featured_task >= $featured_projects_allowed ){
                    $json['type']               = 'error';
                    $json['message'] 		    = esc_html__('Oops!', 'taskbot');
                    $json['message_desc'] 		= esc_html__('Please upgrade your package to make this project into featured listing.', 'taskbot');
                    if( empty($type) ){
                        wp_send_json($json);
                    } else {
                        return $json;
                    } 
                } else {
                    return true;
                }
                break;
            default:
           
            break;
        }
    }
}

/**
 * Update package option
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbotUpdateBuyerPackage')) {
    function taskbotUpdateBuyerPackage($user_id = '', $key='',$post_id=0)
    {
        global $taskbot_settings;
        $buyer_package_option   = !empty($taskbot_settings['package_option']) && in_array($taskbot_settings['package_option'],array('paid','seller_free')) ? true : false;
        $remaining_option       = get_user_meta( $user_id, 'remaining_buyer_package_details',true );    
        $remaining_option       = !empty($remaining_option) ? $remaining_option : array();
        if( !empty($buyer_package_option) ){
            if( !empty($post_id) ){
                switch($key){
                    case 'number_projects_allowed':
                        $package_option = get_post_meta( $post_id, 'package_option',true );
                        if( !empty($package_option) && $package_option === 'yes' ){
                        } else {
                            update_post_meta( $post_id, 'package_option','yes' );
                            
                            $projects_allowed       = !empty($remaining_option['number_projects_allowed']) ? intval($remaining_option['number_projects_allowed']) : 0;
                            $remaining_option['number_projects_allowed']    = !empty($projects_allowed) ? ($projects_allowed)-1 : 0 ;
                            update_user_meta( $user_id, 'remaining_buyer_package_details', $remaining_option );
                        }
                        
                    break;
                    case 'featured_projects_allowed':
                        $current_date           = current_time('mysql');
                        $featured_date          = date('Y-m-d H:i:s');
                        $duration               = !empty($remaining_option['featured_projects_duration']) ? ($remaining_option['featured_projects_duration']) : 0;
                        if ( !empty( $duration ) ) {
                            $featured_date = strtotime("+" . $duration . " days", strtotime($current_date));
                            $featured_date = date('Y-m-d H:i:s', $featured_date);
                        }
                        $featured_string	= !empty( $featured_date ) ?  strtotime( $featured_date ) : 0;
                        update_post_meta($post_id, '_featured_till',$featured_string );
                        $taskbot_project_data       = array();
                        $taskbot_project_data['ID'] = $post_id;
                        wp_update_post( $taskbot_project_data );
                        break;
                    default:
                   
                    break;
                }
                
            }
        }
    }
}
/**
 * Get user projects
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbotUpdateProjectStatusOption')) {
    function taskbotUpdateProjectStatusOption($project_id = '', $status='')
    {
        $gmt_time		        = current_time( 'mysql', 1 );
        $no_of_freelancers	    = get_post_meta( $project_id, 'no_of_freelancers',true);
        $no_of_freelancers	    = !empty($no_of_freelancers) ? intval($no_of_freelancers) : 0;
        switch($status){
            case 'hired':
                update_post_meta( $project_id, '_order_status',true );
                if( !empty($no_of_freelancers) && $no_of_freelancers > 1 ){
                    update_post_meta( $project_id, '_post_project_status', 'hired' );
                    $taskbot_post_count	= taskbot_post_count('proposals',array('hired','completed','refunded','disputed'),array('project_id' => $project_id));
                    if(!empty($taskbot_post_count) && intval($taskbot_post_count) >= intval($no_of_freelancers) ){
                        $project_post = array(
                            'ID'           	=> $project_id,
                            'post_status'   => 'hired'
                        );
                        wp_update_post( $project_post );
                        update_post_meta( $project_id, 'hiring_date',$gmt_time );
                    }
                } else if( !empty($no_of_freelancers)){
                    $project_post = array(
                        'ID'           	=> $project_id,
                        'post_status'   => 'hired'
                    );
                    wp_update_post( $project_post );
                    update_post_meta( $project_id, '_post_project_status', 'hired' );
                    update_post_meta( $project_id, 'hiring_date',$gmt_time );
                }
            break;
            case 'completed':
                if( !empty($no_of_freelancers) && $no_of_freelancers > 1 ){
                    $taskbot_post_count	= taskbot_post_count('proposals',array('completed','refunded','disputed'),array('project_id' => $project_id));
                    if(!empty($taskbot_post_count) && $taskbot_post_count == $no_of_freelancers ){
                        $project_post = array(
                            'ID'           	=> $project_id,
                            'post_status'   => 'completed'
                        );
                        wp_update_post( $project_post );
                        update_post_meta( $project_id, '_post_project_status', 'completed' );
                        update_post_meta( $project_id, 'completed_date',$gmt_time );
                        update_post_meta( $project_id, '_order_status',false );
                    }
                } else if( !empty($no_of_freelancers)){
                    $project_post = array(
                        'ID'           	=> $project_id,
                        'post_status'   => 'completed'
                    );
                    wp_update_post( $project_post );
                    update_post_meta( $project_id, '_post_project_status', 'completed' );
                    update_post_meta( $project_id, 'completed_date',$gmt_time );
                    update_post_meta( $project_id, '_order_status',false );
                }
                break;
            case 'refunded':
                if( !empty($no_of_freelancers) && $no_of_freelancers > 1 ){
                    $taskbot_post_count	    = taskbot_post_count('proposals',array('completed','refunded','disputed'),array('project_id' => $project_id));
                    $refunded_post_count	= taskbot_post_count('proposals',array('refunded'),array('project_id' => $project_id));
                    if(!empty($refunded_post_count) && $refunded_post_count == $no_of_freelancers ){
                        $project_post = array(
                            'ID'           	=> $project_id,
                            'post_status'   => 'refunded'
                        );
                        wp_update_post( $project_post );
                        update_post_meta( $project_id, '_post_project_status', 'refunded' );
                        update_post_meta( $project_id, 'refunded_date',$gmt_time );
                        update_post_meta( $project_id, '_order_status',false );
                    } else if(!empty($taskbot_post_count) && $taskbot_post_count == $no_of_freelancers ){
                        $project_post = array(
                            'ID'           	=> $project_id,
                            'post_status'   => 'completed'
                        );
                        wp_update_post( $project_post );
                        update_post_meta( $project_id, '_post_project_status', 'completed' );
                        update_post_meta( $project_id, 'completed_date',$gmt_time );
                        update_post_meta( $project_id, '_order_status',false );
                    }
                } else if( !empty($no_of_freelancers) && $no_of_freelancers == 1){
                    $project_post = array(
                        'ID'           	=> $project_id,
                        'post_status'   => 'refunded'
                    );
                    wp_update_post( $project_post );
                    update_post_meta( $project_id, '_post_project_status', 'refunded' );
                    update_post_meta( $project_id, 'refunded_date',$gmt_time );
                    update_post_meta( $project_id, '_order_status',false );
                }
                break;
            case 'cancelled':
                update_post_meta( $project_id, '_order_status',false );
                if( !empty($no_of_freelancers) && $no_of_freelancers > 1 ){
                    $taskbot_post_count	    = taskbot_post_count('proposals',array('completed','cancelled','disputed'),array('project_id' => $project_id));
                    $cancelled_post_count	= taskbot_post_count('proposals',array('cancelled'),array('project_id' => $project_id));
                    if(!empty($cancelled_post_count) && $cancelled_post_count == $no_of_freelancers ){
                        $project_post = array(
                            'ID'           	=> $project_id,
                            'post_status'   => 'cancelled'
                        );
                        wp_update_post( $project_post );
                        update_post_meta( $project_id, '_post_project_status', 'cancelled' );
                        update_post_meta( $project_id, 'cancelled_date',$gmt_time );
                    } else if(!empty($taskbot_post_count) && $taskbot_post_count == $no_of_freelancers ){
                        $project_post = array(
                            'ID'           	=> $project_id,
                            'post_status'   => 'completed'
                        );
                        wp_update_post( $project_post );
                        update_post_meta( $project_id, '_post_project_status', 'completed' );
                        update_post_meta( $project_id, 'completed_date',$gmt_time );
                    }
                } else if( !empty($no_of_freelancers) && $no_of_freelancers == 1){
                    $project_post = array(
                        'ID'           	=> $project_id,
                        'post_status'   => 'cancelled'
                    );
                    wp_update_post( $project_post );
                    update_post_meta( $project_id, '_post_project_status', 'cancelled' );
                    update_post_meta( $project_id, 'cancelled_date',$gmt_time );
                }
                break;
            default:
           
            break;
        }
    }
}
/**
 * Get user projects
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbot_get_user_projects')) {
    function taskbot_get_user_projects($user_id = '', $post_status='any',$featured='')
    {
        $taskbot_args = array(
            'post_type'         => 'product',
            'post_status'       => $post_status,
            'numberposts'       => -1,
            'paged'             => 1,
            'author'            => $user_id,
            'orderby'           => 'date',
            'order'             => 'DESC',
            'tax_query'         => array(
                array(
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'projects',
                ),
            ),
        );
        $meta_queries   = array();
        if( !empty($featured) && $featured === 'hired' ){
            $project_meta_args[] = array(
                'key'       => '_post_project_status',
                'value'     => $featured,
                'compare'   => '='
            );
            $meta_queries = array_merge($meta_queries, $project_meta_args);
        }

        if( !empty($meta_queries) ){
            $taskbot_args['meta_query'] = $meta_queries;
        }

        $task_listings  = get_posts($taskbot_args);
        if( !empty($featured) && $featured === 'featured' ){
            $count_task = 0;
            if( !empty($task_listings) ){
                foreach($task_listings as $task){
                    $product = wc_get_product( $task->ID );
                    if($product->is_featured()){
                        $count_task++;
                    }
                }
            }
        } else {
            $count_task = !empty($task_listings) && is_array($task_listings) ? count($task_listings) : 0;
        }
        return $count_task;
    }
}

/**
 * Project posted_date
 *
 */
if( !function_exists('taskbot_posted_date_html') ){
    function taskbot_posted_date_html($product = array()) {
        if(empty($product)){return;}

        $publish_date	= get_post_meta( $product->get_id(), '_publish_datetime',true );
        if(empty($publish_date)){return;}
        
	    $publish_date	= !empty($publish_date) ? strtotime($publish_date) : 0;
        $offset 			= get_option('gmt_offset') * intval(60) * intval(60);
        $publish_date       = $publish_date + $offset;
        if( !empty($publish_date) ){
            ob_start();
            ?>
                <li><i class="tb-icon-calendar"></i><?php echo sprintf( _x( 'Posted %s ago', '%s = human-readable time difference', 'taskbot' ), human_time_diff( $publish_date, current_time( 'timestamp' ) ) ); ?></li>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_posted_date_html', 'taskbot_posted_date_html',10,1);
}

/**
 * Project location
 *
 */
if( !function_exists('taskbot_location_html') ){
    function taskbot_location_html($product = array()) {
        if(empty($product)){return;}

        $location	= get_post_meta( $product->get_id(), '_project_location',true );
	    $location	= !empty($location) ? ($location) : '';
        $location_text  = '';
        if( !empty($location) && $location === 'location' ){
            $location_text        = apply_filters( 'taskbot_user_address', $product->get_id() );
        } else {
            $location_text  = taskbot_project_location_type($location);
        }
        if( !empty($location_text) ){
            ob_start();
            ?>
                <li><i class="tb-icon-map-pin"></i><?php echo esc_html($location_text); ?></li>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_location_html', 'taskbot_location_html',10,1);
}

/**
 * Project texnonimies html v2
 *
 */
if( !function_exists('taskbot_texnomies_html_v2') ){
    function taskbot_texnomies_html_v2($post_id = '',$term_name='',$icon_classes='') {
        $product_terms      = !empty($post_id) && !empty($term_name) ? wp_get_post_terms( $post_id, $term_name) : array();
        $tag_text           = '';
        if ( ! empty( $product_terms ) && ! is_wp_error( $product_terms ) ) {
            $terms = array();
            foreach( $product_terms as $term ) {
                $terms[] = esc_html( $term->name );
            }
            $tag_text   =  join( ', ', $terms );
        
            ob_start();
            ?>
            <li>
                <i class="<?php echo esc_attr($icon_classes);?>"></i>
                <span><?php echo esc_html($tag_text);?></span>
            </li>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_texnomies_html_v2', 'taskbot_texnomies_html_v2',10,3);
}

/**
 * Project location
 *
 */
if( !function_exists('taskbot_hiring_freelancer_html') ){
    function taskbot_hiring_freelancer_html($product = array()) {
        if(empty($product)){return;}
        
        $no_of_freelancers	= get_post_meta( $product->get_id(), 'no_of_freelancers',true );
	    $no_of_freelancers	= !empty($no_of_freelancers) ? intval($no_of_freelancers) : '';
        
        if( !empty($no_of_freelancers) ){
            ob_start();
            ?>
                <li><i class="tb-icon-users"></i><?php echo sprintf(_n('%s freelancer','%s freelancers',$no_of_freelancers,'taskbot'),$no_of_freelancers); ?></li>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_hiring_freelancer_html', 'taskbot_hiring_freelancer_html',10,1);
}

/**
 * Project location
 *
 */
if( !function_exists('taskbot_list_hiring_freelancer_html') ){
    function taskbot_list_hiring_freelancer_html($project_id=0) {
        $proposal_args = array(
            'post_type' 	    => 'proposals',
            'post_status'       => array('hired','cancelled','completed','refunded','disputed'),
            'posts_per_page'    => -1,
            'meta_query'        => array(
                array(
                    'key'       => 'project_id',
                    'value'     => intval($project_id),
                    'compare'   => '=',
                    'type'      => 'NUMERIC'
                )
            )
        );
        $proposals  = get_posts( $proposal_args );
        $buyer_id   = get_post_field( 'post_author', $project_id );
        $buyer_id   = !empty($buyer_id) ? intval($buyer_id) : 0;
        $project_title  = get_the_title( $project_id );
        if( !empty($proposals) ){
            ob_start();
            ?>
            <div class="tk-freelancer-holder">
                <div class="tk-tagtittle">
                    <span><?php esc_html_e('Hired freelancers','taskbot');?></span>
                </div>
                <ul class="tk-hire-freelancer">
                    <?php 
                    foreach($proposals as $proposal){
                        $proposal_id        = $proposal->ID;
                        $post_author        = get_post_field( 'post_author', $proposal_id );
                        $linked_profile_id  = taskbot_get_linked_profile_id($post_author, '','sellers');
                        $user_name          = taskbot_get_username($linked_profile_id);
                        $avatar             = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $linked_profile_id), array('width' => 50, 'height' => 50));
                        $post_status        = get_post_status( $proposal );
                        ?>
                        <li>
                            <div class="tk-hire-freelancer_content">
                                <?php if( !empty($avatar) ){?>
                                    <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
                                <?php } ?>
                                <?php if( !empty($user_name) ){?>
                                    <div class="tk-hire-freelancer-info">
                                        <h6>
                                            <?php echo esc_html($user_name);?>
                                            <?php 
                                            if( !empty($post_status) && $post_status === 'completed' ){
                                                $rating_id      = get_post_meta( $proposal_id, '_rating_id', true );
                                                $rating_feature = !empty($rating_id) ? '' : 'tb-featureRating-nostar';
                                                $rating         = !empty($rating_id) ? get_comment_meta($rating_id, 'rating', true) : 0;
                                                $rating_avg     = !empty($rating) ? ($rating/5)*100 : 0;
                                                $rating_avg     = !empty($rating_avg) ? 'style="width:'.$rating_avg.'%;"' : '';
                                                ?>
                                                <?php if( !empty($rating_avg) ){?>
                                                    <span class="tk-blogviewdates <?php echo esc_attr($rating_feature);?>">
                                                        <i class="fas fa-star tk-yellow" <?php echo do_shortcode( $rating_avg );?>></i>
                                                        <em> <?php echo number_format((float)$rating, 1, '.', '');?> </em>
                                                    </span>
                                                <?php } ?>
                                        <?php }?>
                                        </h6>
                                    <?php if( !empty($post_status) && in_array($post_status,array('hired','refunded','disputed','cancelled','completed') ) ){?>
                                        <a href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $buyer_id, true, 'activity',$proposal_id));?>"><?php esc_html_e('View activity','taskbot');?></a>
                                    <?php }?>
                                    <?php if( !empty($post_status) && $post_status === 'completed' ){
                                            $rating_class   = !empty($rating_id) ? 'tb_view_rating' : 'tb_add_project_rating';
                                            $rating_feature = !empty($rating_id) ? '' : 'tb-featureRating-nostar';
                                            $rating_title   = !empty($rating_id) ? esc_html__('Read review','taskbot') : esc_html__('Add review','taskbot');
                                            ?>
                                            <a href="javascript:;" data-title="<?php echo esc_attr($project_title);?>" data-rating_id="<?php echo esc_attr($rating_id);?>" data-proposal_id="<?php echo intval($proposal_id);?>" class="<?php echo esc_attr($rating_class);?>" ><?php echo esc_html($rating_title);?></a>
                                    <?php } ?>
                                    </div>
                                <?php } ?>
                                
                                <?php do_action( 'taskbot_proposal_status_tag', $proposal_id );?>
                            </div>
                        </li>
                    <?php } ?>
                    
                </ul>
            </div>
            <?php
            echo ob_get_clean();
        }
    }
    add_action('taskbot_list_hiring_freelancer_html', 'taskbot_list_hiring_freelancer_html',10,1);
}