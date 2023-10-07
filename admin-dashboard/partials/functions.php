<?php

/**
 * Count custom post type status
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */

if (!function_exists('taskbot_disppute_date_query_count')) {
    function taskbot_disppute_date_query_count($post_type = '', $status='any',$meta_array=array())
    {

        $current_date       = date('F 01, Y');
        $previous_1_month   = date('F 01, Y', strtotime($current_date. ' - 1 months')); 
        $previous_2_month   = date('F 01, Y', strtotime($current_date. ' - 2 months')); 
        
        $args = array(
            'post_type'         => $post_type,
            'posts_per_page'    => -1,
            'post_status'       => $status,
            'date_query' => array(
                array(
                    'after'     => $previous_2_month,
                    'before'    => $previous_1_month,
                    'inclusive' => true,
                ),
            ),
        );
      
        if (!empty($meta_array)) {
            foreach ($meta_array as $meta) {
                $args['meta_query'][]  = $meta;
            }
        }

        $taskbot_posts = get_posts( $args );
        $prev_month_count   = count($taskbot_posts);
        $args = array(
            'post_type'         => $post_type,
            'post_status'       => $status,
            'posts_per_page'    => -1,
            'date_query' => array(
                array(
                    'after'     => $current_date,
                ),
            ),
        );

        if (!empty($meta_array)) {
            foreach ($meta_array as $meta) {
                $args['meta_query'][]  = $meta;
            }
        }

        $taskbot_posts      = get_posts( $args );
        $curr_month_count   = count($taskbot_posts);
        $oprate_val         = !empty($curr_month_count) ? (int)($prev_month_count - $curr_month_count) : 0;
        $oprate_val         = !empty($oprate_val) ? preg_replace('/[^0-9]/i', '',$oprate_val) : 0;
        $percentChange      = !empty($prev_month_count) && !empty($oprate_val) ? ($oprate_val/$prev_month_count) * 100 : 0;
        $variation  = 'decrease';
        if($curr_month_count > $prev_month_count){
            $variation  = 'increase';
        }

        return array(
            'current_month'     => $curr_month_count,
            'previous_month'    => $prev_month_count,
            'percentChange'     => intval($percentChange),
            'change'            => $variation
        );

      
    }
}
