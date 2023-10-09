<?php
/**
 * Template part for displaying projects content
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
$search_project_page        = !empty($grid_arg['search_project_page']) ? $grid_arg['search_project_page'] : '';
$hide_product_cat           = !empty($grid_arg['hide_product_cat']) ? $grid_arg['hide_product_cat'] : '';
$keyword                    = !empty($grid_arg['keyword']) ? $grid_arg['keyword'] : '';
$location                   = !empty($grid_arg['location']) ? $grid_arg['location'] : '';
$category                   = !empty($grid_arg['category']) ? $grid_arg['category'] : '';
$skills                     = !empty($grid_arg['skills']) ? $grid_arg['skills'] : array();
$expertise_level            = !empty($grid_arg['expertise_level']) ? $grid_arg['expertise_level'] : array();
$languages                  = !empty($grid_arg['languages']) ? $grid_arg['languages'] : array();
$min_product_price          = !empty($grid_arg['min_product_price']) ? $grid_arg['min_product_price'] : 0;
$max_product_price          = !empty($grid_arg['max_product_price']) ? $grid_arg['max_product_price'] : 5000;
$flag                       = rand(99, 9999);
$project_types_array    = array();
$project_types          = taskbot_project_type();
$selected_type          = !empty($_GET['project_type']) ? $_GET['project_type'] : 'all';
if( !empty($project_types) ){
    $project_types_array['all'] = esc_html__('All','taskbot-hourly-addon');
    foreach( $project_types as $key => $val ){
        $project_types_array[$key]  = !empty($val['title']) ? $val['title'] : "";
    }
}
?>
<div class="tk-main-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form id="tb_sort_form" class="tk-formsearch tk-formsearchvtwo">
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
                                    'class'             => 'form-control',
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
                                <button class="d-flex tk-btn-solid-lg tk-btn-<?php echo esc_attr($flag);?>"><?php esc_html_e('Search now','taskbot');?></button>
                                <a data-bs-toggle="collapse" href="#collapse-project-search" role="button" aria-expanded="false" aria-controls="collapse-project-search" class="tk-advancebtn tk-btn-solid-lg">
                                    <span class="tb-icon-sliders"></span>
                                    <?php esc_html_e('Advanced search','taskbot');?>
                                    <span class = "tb-icon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                    </fieldset>
                    <div id="collapse-project-search" class="collapse tk-advancesearch">
                        <div class="tk-searchbar">
                            <div class="tk-advancecheck">
                                <?php do_action( 'taskbot_render_term_filter_htmlv2', $skills,'skills','name="skills[]"',esc_html__('Skills','taskbot') );?>
                            </div>
                            <div class="tk-advancecheck">
                                <?php do_action( 'taskbot_render_term_filter_htmlv2', $expertise_level,'expertise_level','name="expertise_level[]"',esc_html__('Expertise level','taskbot') );?>
                            </div>
                            <div class="tk-advancecheck">
                                <?php do_action( 'taskbot_render_term_filter_htmlv2', $languages,'languages','name="languages[]"',esc_html__('Languages','taskbot') );?>
                            </div>
                            <div class="form-group-wrap">
                                <div class="form-group form-group-3half">
                                    <h6><?php esc_html_e('Project type','taskbot');?></h6>
                                    <div class="tk-select">
                                        <?php do_action( 'taskbot_custom_dropdown_html', $project_types_array,'project_type','tb-project-type',$selected_type );?>
                                    </div>
                                </div>
                                <div class="form-group form-group-3half">
                                    <h6><?php esc_html_e('Location','taskbot');?></h6>
                                    <div class="tk-select">
                                        <?php do_action('taskbot_country_dropdown', $location,'location');?>
                                    </div>
                                </div>
                                <div class="tk-pricerange form-group form-group-3half">
                                    <?php do_action( 'taskbot_render_price_filter_htmlv2', esc_html__('Price range','taskbot'),$min_product_price,$max_product_price,$flag );?>
                                </div>
                            </div>
                        </div>
                        <div class="tk-searchbar">
                            <div class="tk-btnarea">
                                <a href="<?php echo esc_url($search_project_page);?>" class="tk-advancebtn tk-btn-solid-lg"><?php esc_html_e('Clear all filters','taskbot');?></a>
                                <button class="d-flex tk-btn-solid-lg tk-btn-<?php echo esc_attr($flag);?>"><?php esc_html_e('Apply filters','taskbot');?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="tk-sort">
                    <?php if ($keyword){ ?>
                        <h3><?php echo sprintf( esc_html__('%d search result(s) "%s" found','taskbot'), $result_count,$keyword);?></h3>
                    <?php } else { ?>
                        <h3><?php echo sprintf(esc_html__('%d search result(s) found','taskbot'), $result_count);?></h3>
                    <?php } ?>
                    <div class="tk-sortby">
                        <?php do_action('taskbot_project_price_sortby_filter_theme', $sort_by); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 tk-searchprojectlist">
            <?php  
                if ( $taskbot_query->have_posts() ) : 
                    while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
                        $product            = wc_get_product();
                        ?>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <?php do_action( 'taskbot_project_grid_view', $product );?>
                        </div>
                        <?php
                    endwhile;
                    if( !empty($result_count) && $result_count > $show_posts ):
                        ?>
                        <div class="col-sm-12">
                            <?php taskbot_paginate($taskbot_query); ?>
                        </div>
                    <?php
                    endif;
                else:?>
                    <div class="col-lg-12">
                        <?php do_action( 'taskbot_empty_listing', esc_html__('No projects found', 'taskbot') );?>
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
    jQuery('.tb-project-type').select2({
        theme: 'default tk-select2-dropdown',
        minimumResultsForSearch: Infinity,
    });
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