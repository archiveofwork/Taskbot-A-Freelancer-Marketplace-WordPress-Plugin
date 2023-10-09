<?php
/**
 *
 * Template Name: Search task
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $post, $taskbot_settings;
$days   = 2;
$gmt_time		= date('Y-d-m h:i',current_time( 'timestamp' ));
$gmt_strtotime	= date('Y-d-m h:i',strtotime($gmt_time . " +".$days." days"));

$tax_queries            = array();
$meta_queries           = array();
$query_args             = array();
$user_meta_queries      = array();
$user_ids               = array();
$product_type_tax_args  = array();
$min_price_meta_args 	= array();
$sorting                = !empty($_GET['sort_by']) ? esc_attr($_GET['sort_by']) : '';

$hide_task_filter_price         = !empty($taskbot_settings['hide_task_filter_price']) ? $taskbot_settings['hide_task_filter_price'] : false;
$hide_task_filter_location      = !empty($taskbot_settings['hide_task_filter_location']) ? $taskbot_settings['hide_task_filter_location'] : false;
$hide_task_filter_categories    = !empty($taskbot_settings['hide_task_filter_categories']) ? $taskbot_settings['hide_task_filter_categories'] : false;

$product_type_tax_args[] = array(
  'taxonomy' => 'product_type',
  'field'    => 'slug',
  'terms'    => 'tasks',
);

$tax_queries = array_merge($tax_queries,$product_type_tax_args);

if (!empty($sorting)) {
    $filtered_args = array();
    // filter latest product
    if ($sorting == 'date_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'date',
            'order' 	=> 'DESC',
        );
    } elseif ($sorting == 'price_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> '_price',
            'order' 	=> 'desc',
        );
    } elseif ($sorting == 'price_asc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> '_price',
            'order' 	=> 'asc',
        );
    } elseif ($sorting == 'views_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> 'taskbot_service_views',
            'order' 	=> 'desc',
        );
    } elseif ($sorting == 'orders_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> 'total_sales',
            'order' 	=> 'desc',
        );
    } elseif ($sorting == 'reviews_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> '_wc_average_rating',
            'order' 	=> 'desc',
        );
    }
	
    $query_args = array_merge($query_args, $filtered_args['sort_by']);
}

// handled category filter in query args
$category         = '';
$category_id      = 0;
$sub_category     = '';
$sub_category_id  = 0;
$service_array    = array();
$service_ids      = array();

if (!empty($_GET['category']) && $_GET['category'] != -1) {

    // check and get parent category info
    $category = esc_html($_GET['category']);
    $category_obj = get_term_by('slug', $category, 'product_cat');
    if (!empty($category_obj)) {
        $category_id = $category_obj->term_id;
        $service_ids = $category_id;
    }

    // check and get sub category info
    if (!empty($_GET['sub_category'])) {
        $service_ids = array();
        $sub_category = esc_html($_GET['sub_category']);
        $sub_category_obj = get_term_by('slug', $sub_category, 'product_cat');
        if (!empty($sub_category_obj)) {
            $sub_category_id = $sub_category_obj->term_id;
            $service_ids = $sub_category_id;
        }
    }

    
    // check and get third level category info, on this level we have service array
    if (!empty($_GET['service'])) {
        $service_ids = array();
        $service_array = array_map('esc_attr', $_GET['service']);
        foreach ($service_array as $service) {

            $service_obj = get_term_by('slug', $service, 'product_cat');
            if (!empty($service_obj)) {
                $service_id = $service_obj->term_id;
                array_push($service_ids, $service_id);
            }

        }

    }

    // here we are having another taxonomy so let define the relation
    $query_relation = array('relation' => 'AND',);
    $tax_queries = array_merge($query_relation, $tax_queries);

    // handled searched by product cat taxonomy
    $product_cat_tax_args[] = array(
        'taxonomy'  => 'product_cat',
        'terms'     => $service_ids,
        'field'     => 'term_id',
        'operator'  => 'IN',
    );

    // append product_cat taxonomy args in $tax_queries array
    $tax_queries = array_merge($tax_queries, $product_cat_tax_args);
}

// check and store filter variable data
$keyword            = !empty($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : "";
$location           = !empty($_GET['location']) ? sanitize_text_field($_GET['location']) : "";
$min_product_price  = !empty($_GET['min_price']) ? ($_GET['min_price']) : 0;
$max_product_price  = !empty($_GET['max_price']) ? ($_GET['max_price']) : 0;
$product_tags             = !empty($_GET['product_tag']) ? $_GET['product_tag'] : array();

$state              = !empty($_GET['state']) ? $_GET['state'] : '';
if (class_exists('WooCommerce')) {
	$countries_obj   	= new WC_Countries();
	$countries   		= $countries_obj->get_allowed_countries('countries');
    if( is_array($countries) && count($countries) === 1 ){
        $country                = array_key_first($countries);
        $location               = $country;
    }
}
// if keyword field is set in search then append its args in $query_args
if (!empty($keyword)) {
    $filtered_args['keyword'] = array( 's' => $keyword,);
    $query_args = array_merge($query_args, $filtered_args['keyword']);
}

// if min price field is set in search then append it in meta query
if (!empty($min_product_price)) {
    $min_price_meta_args[] = array(
        'key'       => '_regular_price',
        'value'     => $min_product_price,
        'compare'   => '>=',
        'type'      => 'NUMERIC',
    );

    // store basic taxonomy in $tax_queries array
    $meta_queries = array_merge($meta_queries, $min_price_meta_args);
}

// if max price field is set in search then append it in meta query
if (!empty($max_product_price)) {

    if (count($meta_queries) == 1) {
        $query_relation = array('relation' => 'AND',);
        $meta_queries = array_merge($query_relation, $meta_queries);
    }

    $max_price_meta_args[] = array(
        'key'       => '_max_price',
        'value'     => $max_product_price,
        'compare'   => '<=',
        'type'      => 'NUMERIC',
    );
    $meta_queries = array_merge($meta_queries, $max_price_meta_args);
}

// if location field is set in search then append it in meta query
if (!empty($location)) {

    if (count($meta_queries) == 1) {
        $query_relation = array('relation' => 'AND',);
        $meta_queries = array_merge($query_relation, $meta_queries);
    }

    $product_country_meta_args[] = array(
        'key'       => '_country',
        'value'     => $location,
        'compare'   => '=',
        'type'      => 'CHAR',
    );

    $meta_queries = array_merge($meta_queries, $product_country_meta_args);

    if( !empty($state) ){
        $countries_obj  = new WC_Countries();
        $countries      = $countries_obj->get_allowed_countries('countries');
        $states_list    = $countries_obj->get_states( $location );
        if( !empty($states_list[$state]) ){
            $product_state_meta_args[] = array(
                'key'       => 'state',
                'value'     => $state,
                'compare'   => '=',
                'type'      => 'CHAR',
            );
        
            $meta_queries = array_merge($meta_queries, $product_state_meta_args);
        }
    }
}

$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$show_posts = !empty(get_option('posts_per_page')) ? get_option('posts_per_page') : 10;

if (!empty($_GET['product_tag'])) {
    foreach ($_GET['product_tag'] as $tag) {
        $product_tag_args[] = array(
            'taxonomy' => 'product_tag',
            'field'    => 'slug',
            'terms'    => esc_html($tag),
        );
    }
    $tax_queries = array_merge($tax_queries,$product_tag_args);
}

// prepared query args
$taskbot_args = array(
  'post_type'         => 'product',
  'post_status'       => 'publish',
  'posts_per_page'    => $show_posts,
  'paged'             => $paged,
  'tax_query'         => $tax_queries,
  'meta_query'        => $meta_queries,
);

$taskbot_args       = array_merge($taskbot_args, $query_args);
$taskbot_query      = new WP_Query(apply_filters('taskbot_service_listings_args', $taskbot_args));
$result_count       = $taskbot_query->found_posts;
$search_task_page   = !empty($taskbot_settings['tpl_service_search_page']) ? get_permalink($taskbot_settings['tpl_service_search_page']) : '';
$hide_product_cat   = !empty($taskbot_settings['hide_product_cat']) ? $taskbot_settings['hide_product_cat'] : array();
$sort_by            = !empty($sorting) ? sanitize_text_field($sorting) : "";
$task_listing_type  = !empty($taskbot_settings['task_listing_type']) ? $taskbot_settings['task_listing_type'] : 'v1';
$listing_type       = !empty($taskbot_settings['task_listing_view']) ? $taskbot_settings['task_listing_view'] : 'left';

$listing_param = isset($_GET['view_style']) ? $_GET['view_style'] : '';
if(isset($listing_param) && $listing_param == 'v2'){
    $listing_type = 'top';
}elseif (isset($listing_param) && $listing_param == 'v1'){
    $listing_type = 'left';
}

get_header();
if( !empty($listing_type) && $listing_type === 'top' ){
    $theme_version 	                = wp_get_theme();
    $grid_arg                       = array();
    $grid_arg['sort_by']            = $sort_by;
    $grid_arg['show_posts']         = $show_posts;
    $grid_arg['location']           = $location;
    $grid_arg['taskbot_query']      = $taskbot_query;
    $grid_arg['result_count']       = $result_count;
    $grid_arg['search_task_page']   = $search_task_page;
    $grid_arg['hide_product_cat']   = $hide_product_cat;
    $grid_arg['task_listing_type']  = $task_listing_type;
    $grid_arg['keyword']            = $keyword;
    $grid_arg['category']           = $category;
    $grid_arg['sub_category']       = $sub_category;
    $grid_arg['service_array']      = $service_array;
    $grid_arg['min_product_price']  = $min_product_price;
    $grid_arg['max_product_price']  = $max_product_price;
    
    include taskbot_load_template( 'templates/search-task/search-tasks-v2' ); 
} else {
?>
    <section class="tk-main-section tk-searchresult">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-12">
                    <div class="tk-sort">
                        <?php if ($keyword){ ?>
                            <h3><?php echo sprintf( esc_html__('%d search result(s) "%s" found','taskbot'), $result_count,$keyword); ?></h3>
                        <?php } else { ?>
                            <h3><?php echo sprintf(esc_html__('%d search result(s) found','taskbot'), $result_count); ?></h3>
                        <?php } ?>
                        <?php do_action('taskbot_price_sortby_filter_theme', $sort_by); ?>
                        <div class="tk-filtermenu">
                            <a href="javascript:();" class="tk-filtericon"><i class="tb-icon-sliders"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xxl-3 tk-mt0">
                    <aside>
                        <form id="tb_sort_form" action="<?php echo esc_url( $search_task_page ); ?>" method="GET" class="tk-searchlist">
                            <input type="hidden" name="sort_by" id="tb_sort_by_filter" value="<?php echo esc_attr($sort_by); ?>">
                            <div class="tk-aside-holder">
                                <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#side1" role="button" aria-expanded="true">
                                    <h5><?php esc_html_e('Search','taskbot'); ?></h5>
                                </div>
                                <div id="side1" class="collapse show">
                                    <?php do_action('taskbot_keyword_search_filter_theme', $keyword); ?>
                                </div>
                            </div>
                            <?php if( !empty($hide_task_filter_categories) ) {
                                $cat_expanded           = !empty($category) ? 'true' : 'false';
                                $cat_collapse           = !empty($category) ? '' : 'collapsed';
                                $cat_collapse_content   = !empty($category) ? 'show' : '';
                                ?>
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle <?php echo esc_attr($cat_collapse);?>" data-bs-toggle="collapse" data-bs-target="#side2" role="button" aria-expanded="<?php echo esc_attr($cat_expanded);?>">
                                        <h5><?php esc_html_e('Categories','taskbot'); ?></h5>
                                    </div>
                                    <div id="side2" class="collapse <?php echo esc_attr($cat_collapse_content);?>">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect">
                                                <div class="tk-select" id="task_search_tb_parent_category">
                                                    <?php
                                                        $taskbot_args = array(
                                                            'show_option_none'  => esc_html__('Select category', 'taskbot'),
                                                            'show_count'        => false,
                                                            'hide_empty'        => false,
                                                            'name'              => 'category',
                                                            'class'             => 'form-control tb-top-service-task-search',
                                                            'taxonomy'          => 'product_cat',
                                                            'id'                => 'task_category',
                                                            'value_field'       => 'slug',
                                                            'orderby'           => 'name',
                                                            'selected'          => $category,
                                                            'hide_if_empty'     => false,
                                                            'echo'              => true,
                                                            'required'          => false,
                                                            'parent'            => 0,
                                                        );
                                                        if( !empty($hide_product_cat) ){
                                                            $taskbot_args['exclude']    = $hide_product_cat;
                                                        }
                                                        do_action('taskbot_task_search_taxonomy_dropdown', $taskbot_args);
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="tk-filterselect" id="task_search_tb_sub_category">
                                                <?php
                                                    if (!empty($category)) {
                                                        do_action('taskbot_task_search_get_terms', $category, $sub_category, 'tk-select');
                                                    }
                                                ?>
                                            </div>
                                            <div class="tk-filterselect" id="task_search_tb_category_level3">
                                                <?php
                                                    if (!empty($sub_category)) {
                                                        do_action('taskbot_task_search_get_terms_subcategories', $sub_category, $service_array);
                                                    }
                                                ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php do_action('taskbot_product_tags_filter_theme', $product_tags);?>
                            <?php 
                                if( !empty($hide_task_filter_price) ){
                                    do_action('taskbot_render_price_range_filter_html', esc_html__('Price range','taskbot'), $min_product_price,  $max_product_price); 
                                }
                            ?>
                            <?php 
                                if( !empty($hide_task_filter_location) ) {
                                    do_action('taskbot_location_search_field', $location); 
                                }
                            ?>
                            <?php do_action('taskbot_task_search_filters'); ?>
                            <?php do_action('taskbot_search_clear_button_theme', esc_html__('Apply filters','taskbot'),$search_task_page); ?>

                        </form>
                    </aside>
                </div>
                <div class="col-lg-8 col-xxl-9 tk-tasks-list<?php echo esc_attr($task_listing_type);?>">
                    <?php if ( $taskbot_query->have_posts() ) {?>
                        <div class="row gy-4">
                            <?php while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
                                global $post;
                                ?>
                                <div class="col-md-6 col-xxl-4">
                                    <?php
                                        if( !empty($task_listing_type) && $task_listing_type === 'v2'){
                                            do_action( 'taskbot_listing_task_html_v2', $post->ID );
                                        } else {
                                            do_action( 'taskbot_listing_task_html_v1', $post->ID );
                                        }
                                    ?>
                                </div>
                                <?php endwhile; ?>
                            </div>
                            <?php if( !empty($result_count) && $result_count > $show_posts ){?>
                                <div class="col-sm-12">
                                    <?php taskbot_paginate($taskbot_query); ?>
                                </div>
                            <?php }
                        }else{
                            do_action( 'taskbot_empty_listing', esc_html__('Oops!! Record not found', 'taskbot') );
                        }
                    wp_reset_postdata();
                ?>
                </div>
            </div>
        </div>
    </section>
<?php }
if( !empty($task_listing_type) && $task_listing_type === 'v1' ){
    $is_rtl = 'false';
    if( is_rtl() ){
        $is_rtl = 'true';
    }
    $script	= "
    var owl_task	= jQuery('.tk-tasks-slider').owlCarousel({
        rtl:".esc_js($is_rtl).",
        items: 1,
        loop:false,
        nav:true,
        margin: 0,
        autoplay:false,
        lazyLoad:false,
        navClass: ['tk-prev', 'tk-next'],
        navContainerClass: 'tk-search-slider-nav',
        navText: ['<i class=\"tb-icon-chevron-left\"></i>', '<i class=\"tb-icon-chevron-right\"></i>'],
    });

    setTimeout(function(){owl_task.trigger('refresh.owl.carousel');}, 3000);
    jQuery(window).load(function() {
        owl_task.trigger('refresh.owl.carousel');
        setTimeout(function(){owl_task.trigger('refresh.owl.carousel');}, 2000);
    });";
    wp_add_inline_script( 'owl.carousel', $script, 'after' );
}
get_footer();
