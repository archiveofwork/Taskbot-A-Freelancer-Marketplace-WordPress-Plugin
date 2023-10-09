<?php
/**
*  Project preferences
*
* @package     Taskbot
* @author      Amentotech <info@amentotech.com>
* @link        https://codecanyon.net/user/amentotech/portfolio
* @version     1.0
* @since       1.0
*/
global $taskbot_settings,$current_user;
if ( !class_exists('WooCommerce') ) {
	return;
}

$post_id            = !empty($post_id) ? intval($post_id) : "";
$step_id            = !empty($step) ? intval($step) : "";

$no_of_freelancers  = !empty($taskbot_settings['no_of_freelancers']) ? $taskbot_settings['no_of_freelancers'] : array();
$remove_languages  = !empty($taskbot_settings['remove_languages']) ? $taskbot_settings['remove_languages'] : 'no';

$list_freelancers   = array();
if( !empty($no_of_freelancers) && $no_of_freelancers > 0 ){
    for ($x = 1; $x <= $no_of_freelancers; $x++) {
        $list_freelancers[$x]   = sprintf(_n('%s freelancer','%s freelancers',$x,'taskbot'),$x);
    }
}

$selected_expertise = !empty($product) ? wp_get_post_terms( $product->get_id(), 'expertise_level', array('fields' =>'ids') ) : array();
$selected_expertise = !empty($selected_expertise[0]) ? intval($selected_expertise[0]) : '';
$selected_languages = !empty($product) ? wp_get_post_terms( $product->get_id(), 'languages', array('fields' =>'ids') ) : array();

$selected_skills        = !empty($product) ? wp_get_post_terms( $product->get_id(), 'skills', array('fields' =>'ids') ) : array();
$selected_freelancers   = !empty($product) ? get_post_meta( $product->get_id(), 'no_of_freelancers', true ) : '';
$selected_freelancers   = !empty($selected_freelancers) ? intval($selected_freelancers) : '';
?>
<div class="row">
    <?php do_action( 'taskbot_project_sidebar', $step_id,$post_id );?>
    <div class="col-xl-9 col-lg-8">
        <div class="tk-project-wrapper">
            <div class="tk-project-box">
                <div class="tk-maintitle">
                    <h4><?php esc_html_e('Which skills your freelancer should have?','taskbot');?></h4>
                </div>
                <form class="tk-themeform tb-project-form">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div class="form-group form-group-half">
                                <label class="tk-label"><?php esc_html_e('No. of freelancers','taskbot');?></label>
                                <div class="tk-select"> 
                                    <?php do_action( 'taskbot_custom_dropdown_html', $list_freelancers,'no_of_freelancers','tb-num-freelancer',$selected_freelancers );?>
                                </div>
                            </div>
                            <div class="form-group form-group-half">
                                <label class="tk-label"><?php esc_html_e('Expertise level','taskbot');?></label>
                                <div class="tk-select"> 
                                    <?php 
                                        $expertise_args = array(
                                            'show_option_none'  => esc_html__('Choose experties level', 'taskbot'),
                                            'option_none_value' => '',
                                            'show_count'    => false,
                                            'hide_empty'    => false,
                                            'name'          => 'expertise_level',
                                            'class'         => 'tb-select-cat tb-expertise-level',
                                            'taxonomy'      => 'expertise_level',
                                            'value_field'   => 'term_id',
                                            //'multiple'      => 'multiple',
                                            'orderby'       => 'name',
                                            'hide_if_empty' => false,
                                            'echo'          => true,
                                            'required'      => false,
                                            'selected'      => $selected_expertise,
                                        );
                                        do_action('taskbot_taxonomy_dropdown', $expertise_args);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="tk-label"><?php esc_html_e('Skills required','taskbot');?></label>
                                <div class="tk-select"> 
                                    <?php 
                                        $skills_args = array(
                                            'class'         => 'tb-select2-cat tb-select2-skills',
                                            'taxonomy'      => 'skills',
                                            'value_field'   => 'term_id',
                                            'orderby'       => 'name',
                                            'name'          => 'skills[]',
                                            'selected'      => $selected_skills,
                                        );
                                        do_action('taskbot_custom_taxonomy_dropdown', $skills_args);
                                    ?>
                                </div>
                            </div>
                            <?php if(!empty($remove_languages) && $remove_languages === 'no'){?>
                                <div class="form-group">
                                    <label class="tk-label"><?php esc_html_e('languages','taskbot');?></label>
                                    <div class="tk-select"> 
                                        <?php 
                                            $languages_args = array(
                                                'class'         => 'tb-select2-languages',
                                                'taxonomy'      => 'languages',
                                                'value_field'   => 'term_id',
                                                'orderby'       => 'name',
                                                'name'          => 'languages[]',
                                                'selected'      => $selected_languages,
                                            );
                                            do_action('taskbot_custom_taxonomy_dropdown', $languages_args);
                                        ?>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:void(0)" class="tk-btn-solid-lg-lefticon tb-save-project" data-step_id="3" data-project_id="<?php echo intval($post_id);?>">
                        <?php esc_html_e('Save & continue','taskbot');?>
                        <i class="tb-icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$scripts	= "
jQuery(document).ready(function($){
    'use strict';
    // Make category drop-down select2 on add service

    jQuery('.tb-num-freelancer').select2({
        theme: 'default tk-select2-dropdown',
        allowClear: true,
        placeholder: scripts_vars.num_freelancer_option
    });
    jQuery('.tb-expertise-level').select2({
        theme: 'default tk-select2-dropdown',
        allowClear: true,
        placeholder: scripts_vars.expertise_level_option
    });

    

    // Make category drop-down select2 on add service
    jQuery('.tb-select2-languages').select2({
        theme: 'default tk-select2-dropdown',
        allowClear: true,
        multiple: true,
    });

    if ( $.isFunction($.fn.select2) ) {
        jQuery('.tb-select2-languages').select2({
            theme: 'default tk-select2-dropdown',
            multiple: true,
            placeholder: scripts_vars.languages_option
        });
    }
    jQuery('.tb-select2-languages').trigger('change');
    // Make category drop-down select2 on add service
    jQuery('.tb-select2-skills').select2({
        theme: 'default tk-select2-dropdown',
        allowClear: true,
        multiple: true,
    });
    if ( $.isFunction($.fn.select2) ) {
        jQuery('.tb-select2-skills').select2({
            theme: 'default tk-select2-dropdown',
            multiple: true,
            placeholder: scripts_vars.skills_option
        });
    }
    jQuery('.tb-select2-skills').trigger('change');

    });";
    wp_add_inline_script('taskbot', $scripts, 'after');