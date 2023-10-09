<?php
/**
 * Template part for displaying seller content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package taskup
 */
global $grid_arg,$current_user,$taskbot_settings;

$sort_by                    = !empty($grid_arg['sort_by']) ? $grid_arg['sort_by'] : '';
$show_posts                 = !empty($grid_arg['show_posts']) ? $grid_arg['show_posts'] : '';
$taskbot_query              = !empty($grid_arg['taskbot_query']) ? $grid_arg['taskbot_query'] : array();
$result_count               = !empty($grid_arg['result_count']) ? $grid_arg['result_count'] : '';
$search_task_page           = !empty($grid_arg['search_task_page']) ? $grid_arg['search_task_page'] : '';
$hide_product_cat           = !empty($grid_arg['hide_product_cat']) ? $grid_arg['hide_product_cat'] : '';
$task_listing_type          = !empty($grid_arg['task_listing_type']) ? $grid_arg['task_listing_type'] : '';
$keyword                    = !empty($grid_arg['keyword']) ? $grid_arg['keyword'] : '';
$location                   = !empty($grid_arg['location']) ? $grid_arg['location'] : '';
$category                   = !empty($grid_arg['category']) ? $grid_arg['category'] : '';
$sub_category               = !empty($grid_arg['sub_category']) ? $grid_arg['sub_category'] : '';
$service_array              = !empty($grid_arg['service_array']) ? $grid_arg['service_array'] : '';
$min_product_price          = !empty($grid_arg['min_product_price']) ? $grid_arg['min_product_price'] : 0;
$max_product_price          = !empty($grid_arg['max_product_price']) ? $grid_arg['max_product_price'] : 5000;
$flag                       = rand(99, 9999);
?>
<div class="tk-main-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form class="tk-formsearch tk-formsearchvtwo" id="tb_sort_form">
                    <fieldset>
                        <div class="tk-taskform">
                            <div class="tk-inputicon">
                                <i class="tb-icon-search"></i>
                                <input type="hidden" name="sort_by" id="tb_sort_by_filter" value="<?php echo esc_attr($sort_by); ?>">
                                <?php do_action('taskbot_keyword_search',$keyword); ?>
                            </div>
                            <div class="tk-select tk-inputicon">
                                <i class="tb-icon-layers"></i>
                                <?php
                                    $taskbot_args = array(
                                        'show_option_none'  => esc_html__('Select category', 'taskbot'),
                                        'show_count'        => false,
                                        'hide_empty'        => false,
                                        'name'              => 'category',
                                        'class'             => 'form-control tb-top-service-task-option',
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
                            <div class="tk-inputappend_right">
                                <button class="d-flex tk-btn-solid-lg tk-btn-<?php echo intval($flag);?>"><?php esc_html_e('Search now','taskbot');?></button>
                                <a data-bs-toggle="collapse" href="#tk-search-tags" role="button" aria-expanded="false" aria-controls="tk-search-tags" class="tk-advancebtn tk-btn-solid-lg">
                                    <span class="tb-icon-sliders"></span>
                                    <?php esc_html_e('Advanced search','taskbot');?>
                                    <span class = "tb-icon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                    </fieldset>
                    <div id="tk-search-tags" class="collapse tk-advancesearch">
                        <div class="tk-searchbar">
                            <div class="form-group-wrap">
                                <div class="tk-pricerange form-group form-group-half">
                                    <?php do_action( 'taskbot_render_price_filter_htmlv2', esc_html__('Price range','taskbot'),$min_product_price,$max_product_price,$flag );?>
                                </div>
                                <div class="form-group form-group-half">
                                    <h6><?php esc_html_e('Location','taskbot');?></h6>
                                    <div class="tk-select">
                                        <?php do_action('taskbot_country_dropdown', $location,'location');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-wrap-two">
                                <div class="tk-advancecheck tk-make-fullwidth">
                                    <div class="tk-filterselect" id="task_search_tb_sub_category">
                                        <?php
                                            if (!empty($category)) {
                                                do_action('taskbot_task_search_get_terms', $category, $sub_category, 'tk-select','title');
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="tk-advancecheck tk-make-fullwidth">
                                    <div class="tk-filterselect" id="task_search_tb_category_level3">
                                        <?php
                                            if (!empty($sub_category)) {
                                                do_action('taskbot_task_search_get_terms_subcategories', $sub_category, $service_array,'title');
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tk-searchbar">
                            <div class="tk-btnarea">
                                <a href="<?php echo esc_url($search_task_page);?>" class="tk-advancebtn tk-btn-solid-lg"><?php esc_html_e('Clear all filters','taskbot');?></a>
                                <button class="d-flex tk-btn-solid-lg tk-btn-<?php echo intval($flag);?>"><?php esc_html_e('Apply filters','taskbot');?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="tk-sort">
                    <?php if ($keyword){ ?>
                        <h3><?php echo sprintf( esc_html__('%d search result(s) "%s" found','taskbot'), $result_count,$keyword); ?></h3>
                    <?php } else { ?>
                        <h3><?php echo sprintf(esc_html__('%d search result(s) found','taskbot'), $result_count); ?></h3>
                    <?php } ?>
                    <?php do_action('taskbot_price_sortby_filter_theme', $sort_by); ?>
                </div>
            </div>
        </div>
        <div class="row gy-4 tk-tasks-list<?php echo esc_attr($task_listing_type);?>">
            <?php
                if ( $taskbot_query->have_posts() ) :?>
                        <?php while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
                            global $post;
                            ?>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
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
                        <?php if( !empty($result_count) && $result_count > $show_posts ): ?>
                            <div class="col-sm-12">
                                <?php taskbot_paginate($taskbot_query); ?>
                            </div>
                        <?php
                        endif;
                    else:?>
                    <div class="col-lg-12">
                        <?php do_action( 'taskbot_empty_listing', esc_html__('Oops!! Record not found', 'taskbot') );?>
                    </div>
                <?php 
                endif;
                wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
<?php
$scripts	= "
jQuery(function () {
    jQuery(document).on('click','.tk-btn-".esc_js($flag)."',function(e){
        jQuery('#tb_sort_form').submit();
    });

    // range slider
    var stepsSlider = document.getElementById('tk-rangeslider-" . esc_js($flag) . "');
    if(stepsSlider !== null){
        var input0 = document.getElementById('tk-min-value-" . esc_js($flag) . "');
        var input1 = document.getElementById('tk-max-value-" . esc_js($flag) . "');
        var inputs = [input0, input1];
        noUiSlider.create(stepsSlider, {
            start: [" . esc_js($min_product_price) . ", " . esc_js($max_product_price) . "],
            connect: true,
            range: {
            'min': 1,
            'max': 600
        },
            format: {
            to: (v) => parseFloat(v).toFixed(0),
            from: (v) => parseFloat(v).toFixed(0),
            suffix: ' (US $)'
        },
        });

        stepsSlider.noUiSlider.on('update', function (values, handle) {
            inputs[handle].value = values[handle];
        });

        // Listen to keydown events on the input field.
        inputs.forEach(function (input, handle) {
        input.addEventListener('change', function () {
            stepsSlider.noUiSlider.setHandle(handle, this.value);
        });
        input.addEventListener('keydown', function (e) {
            var values = stepsSlider.noUiSlider.get();
            var value = Number(values[handle]);
            var steps = stepsSlider.noUiSlider.steps();
            var step = steps[handle];
            var position;
            switch (e.which) {
            case 13:
                stepsSlider.noUiSlider.setHandle(handle, this.value);
                break;
            case 38:
                position = step[1];
                // false = no step is set
                if (position === false) {
                    position = 1;
                }
                if (position !== null) {
                    stepsSlider.noUiSlider.setHandle(handle, value + position);
                }
                break;
            case 40:
                position = step[0];
                if (position === false) {
                    position = 1;
                }
                if (position !== null) {
                    stepsSlider.noUiSlider.setHandle(handle, value - position);
                }
                break;
            }
        });
        });
    }
});";
wp_add_inline_script('taskup-callbacks', $scripts, 'after');