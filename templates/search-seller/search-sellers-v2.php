<?php
/**
 * Template part for displaying seller content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package taskup
 */
global $grid_arg,$current_user,$taskbot_settings;

$max_search_price   = !empty($taskbot_settings['max_search_price']) ? $taskbot_settings['max_search_price'] : 5000;
$min_search_price   = !empty($taskbot_settings['min_search_price']) ? $taskbot_settings['min_search_price'] : 0;
$seller_data        = !empty($grid_arg['seller_data']) ? $grid_arg['seller_data'] : array();
$sorting            = !empty($grid_arg['sorting']) ? $grid_arg['sorting'] : '';
$per_page           = !empty($grid_arg['per_page']) ? $grid_arg['per_page'] : '';
$search_keyword     = !empty($grid_arg['search_keyword']) ? $grid_arg['search_keyword'] : '';
$total_posts        = !empty($grid_arg['total_posts']) ? $grid_arg['total_posts'] : 0;
$page_object_id     = !empty($grid_arg['page_object_id']) ? $grid_arg['page_object_id'] : 0;
$seller_type        = !empty($grid_arg['seller_type'][0]) ? $grid_arg['seller_type'][0] : '';
$current_page_url   = !empty($grid_arg['current_page_url']) ? $grid_arg['current_page_url'] : '';
$hourly_rate_start  = !empty($grid_arg['hourly_rate_start']) ? $grid_arg['hourly_rate_start'] : $min_search_price;
$hourly_rate_end    = !empty($grid_arg['hourly_rate_end']) ? $grid_arg['hourly_rate_end'] : $max_search_price;
$english_level      = !empty($grid_arg['english_level']) ? $grid_arg['english_level'] : '';
$seller_location    = !empty($grid_arg['seller_location']) ? $grid_arg['seller_location'] : '';
$flag               = rand(99, 9999);
$seller_type_array  = array();
$seller_type_data   = taskbot_get_term_dropdown('tb_seller_type', false, 0, false);
$selected_seller_type   = '';

if( !empty($seller_type_data) ){
    foreach ($seller_type_data as $value) {
        if( !empty($value->slug) ){
            $seller_type_array[$value->slug]    = $value->name;
        }
    }
}

?>
<div class="tk-main-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form  id="tb_sort_form" class="tk-formsearch tk-formsearchvtwo">
                    <fieldset>
                        <div class="tk-taskform ">
                            <div class="tk-inputicon">
                                <i class="tb-icon-search"></i>
                                <input type="hidden" name="sort_by" id="tb_sort_by_filter" value="<?php echo esc_attr($sorting); ?>">
                                <?php do_action('taskbot_keyword_search',$search_keyword); ?>
                            </div>
                            <div class="tk-select tk-inputicon tb-select">
                                <i class="tb-icon-layers"></i>
                                <?php do_action( 'taskbot_custom_dropdown_html', $seller_type_array,'seller_type[]','seller_type',$seller_type,esc_attr__('Select seller type','taskbot'));?>
                            </div>
                            <div class="tk-inputappend_right">
                                <button class="tk-btn-solid-lg tk-btn-<?php echo esc_attr($flag);?>"><?php esc_html_e('Search now','taskbot');?></button>
                                <a data-bs-toggle="collapse" href="#collapse-search" role="button" aria-expanded="false" aria-controls="collapse-search" class="tk-advancebtn tk-btn-solid-lg">
                                    <span class="tb-icon-sliders"></span>
                                    <?php esc_html_e('Advanced search','taskbot');?>
                                    <span class = "tb-icon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                    </fieldset>
                    <div id="collapse-search" class="collapse tk-advancesearch">
                        <div class="tk-searchbar">
                            <div class="form-group-wrap">
                                <div class="tk-pricerange form-group form-group-half">
                                    <?php do_action( 'taskbot_render_price_filter_htmlv2', esc_html__('Price range','taskbot'),$hourly_rate_start,$hourly_rate_end,$flag );?>
                                </div>
                                <div class="form-group form-group-half">
                                    <h6><?php esc_html_e('Location','taskbot');?></h6>
                                    <div class="tk-select">
                                        <?php do_action('taskbot_country_dropdown', $seller_location,'location');?>
                                    </div>
                                </div>
                            </div>
                            <?php do_action( 'taskbot_render_term_filter_htmlv2', $english_level,'tb_english_level','name="english_level[]"',esc_html__('English level','taskbot') );?>
                        </div>
                        <div class="tk-searchbar">
                            <div class="tk-btnarea">
                                <a href="<?php echo esc_url($current_page_url);?>" class="tk-advancebtn tk-btn-solid-lg"><?php esc_html_e('Clear all filters','taskbot');?></a>
                                <button class="tk-btn-<?php echo esc_attr($flag);?> tk-btn-solid"><?php esc_html_e('Apply filters','taskbot');?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="tk-sort">
                    <h3><?php echo sprintf(esc_html__('%s search result(s)','taskbot'), $total_posts) ?></h3>
                    <?php do_action('taskbot_project_price_sortby_filter_theme', $sorting); ?>
                </div>
            </div>
        </div>
        <div class="row gy-4 tk-searchtalentlist">
            <?php 
                if ($seller_data->have_posts()) {
                    while ($seller_data->have_posts()) {
                        $seller_data->the_post();
                        $seller_id        = get_the_ID();
                        $seller_name      = taskbot_get_username($seller_id);
                        $tb_post_meta     = get_post_meta($seller_id, 'tb_post_meta', true);
                        $seller_tagline   = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
                        ?>
                        <div class="col-sm-12 col-lg-6 col-xl-4">
                            <div class="tk-freelanlist">
                                <div class="tk-topservicetask__content">
                                    <div class="tb-freeprostatus">
                                        <?php do_action('taskbot_profile_image', $seller_id,'',array('width' => 164, 'height' => 164));?>
                                        <?php do_action('taskbot_user_hourly_starting_rate', $seller_id,'',true); ?>
                                    </div>
                                    <div class="tk-title-wrapper">
                                        <div class="tk-verified-info">
                                            <?php if( !empty($seller_name) ){?>
                                                <strong>
                                                    <a href="<?php echo esc_url( get_permalink()); ?>"><?php echo esc_html($seller_name); ?></a>
                                                    <?php do_action( 'taskbot_verification_tag_html', $seller_id ); ?>
                                                </strong>
                                            <?php } ?>
                                            <?php if( !empty($seller_tagline) ){?>
                                                <h5><a href="<?php echo esc_url( get_permalink()); ?>"><?php echo esc_html($seller_tagline); ?></a></h5>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <ul class="tk-blogviewdates tk-blogviewdatesmd">
                                        <?php do_action('taskbot_get_freelancer_rating_cuont', $seller_id); ?>
                                        <?php do_action('taskbot_get_freelancer_views', $seller_id); ?>
                                    </ul>
                                    <div class="tk-btnviewpro">
                                        <a href="<?php echo esc_url( get_permalink()); ?>" class="tk-btn-solid-lg"><?php esc_html_e('View profile','taskbot');?></a>
                                        <?php do_action('taskbot_save_freelancer_html', $current_user->ID, $seller_id, '_saved_sellers', 'v2', 'sellers'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {?>
                    <div class="col-lg-12">
                        <?php do_action( 'taskbot_empty_listing', esc_html__('Oops!! Record not found', 'taskbot') );?>
                    </div>
                <?php }
                if($total_posts > $per_page){
                    taskbot_paginate($seller_data); 
                }
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
            start: [" . esc_js($hourly_rate_start) . ", " . esc_js($hourly_rate_end) . "],
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