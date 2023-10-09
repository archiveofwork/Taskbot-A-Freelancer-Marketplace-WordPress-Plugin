<?php
/**
 * The template part for displaying the dashboard Task graph summary for seller
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/earning_template
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user;
$user_identity    = intval($current_user->ID);

if ( !class_exists('WooCommerce') ) {
	return;
}

$meta_array	= array(
    array(
      'key'         => 'seller_id',
      'value'   	=> $user_identity,
      'compare' 	=> '=',
      'type' 		=> 'NUMERIC'
    ),
    array(
      'key'		    => '_task_status',
      'value'   	=> 'completed',
      'compare' 	=> '=',
    ),
    array(
      'key'         => 'payment_type',
      'value'   	=> 'tasks',
      'compare' 	=> '=',
    )
);

$completed_tasks  = taskbot_tasks_earnings('shop_order',array('wc-completed'),$meta_array);
$graph_keys       = !empty($completed_tasks['key']) ? $completed_tasks['key'] : '';
$graph_values     = !empty($completed_tasks['values']) ? $completed_tasks['values'] : '';

wp_enqueue_script('chart');
wp_enqueue_script('utils-chart');

$currency_symbol  = get_woocommerce_currency_symbol();

//Projects Area
$completed_projects = 0;
$ongoing_projects = 0;
$cancelled_projects = 0;

$taskbot_projects_args = array(
    'post_type'         => 'proposals',
    'post_status'       => array('completed','hired','rejected'),
    'posts_per_page'    => -1,
    'author'            => $current_user->ID,
    'order'             => 'DESC'
);

$taskbot_projects_query  = new WP_Query( apply_filters('taskbot_project_dashbaord_listings_args', $taskbot_projects_args) );

if ( $taskbot_projects_query->have_posts() ){
    while ( $taskbot_projects_query->have_posts() ){
        $taskbot_projects_query->the_post();
        global $post;

        if($post->post_status === 'completed'){
            $completed_projects++;
        } elseif($post->post_status === 'hired'){
            $ongoing_projects++;
        } elseif($post->post_status === 'rejected'){
            $cancelled_projects++;
        }

    }
}

$taskbot_project_url = Taskbot_Profile_Menu::taskbot_profile_menu_link('projects', $user_identity,true,'listing');

//Gigs Area
$gig_completed = 0;
$gig_queues = 0;
$gig_cancelled = 0;

$taskbot_gigs_args   = array(
    'post_type'         => 'product',
    'post_status'       => 'any',
    'posts_per_page'    => -1,
    'author'            => $current_user->ID,
    'order'             => 'DESC',
    'tax_query'         => array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'tasks',
        ),
    ),
);

$taskbot_gigs_query  = new WP_Query( apply_filters('taskbot_admin_service_listings_args', $taskbot_gigs_args) );

if ( $taskbot_gigs_query->have_posts() ){
    while ( $taskbot_gigs_query->have_posts() ){
        $taskbot_gigs_query->the_post();
        global $product;

        $product_id             = $product->get_id();
        $taskbot_total_sales    = $product->get_total_sales();

        //Gigs Queues
        $meta_task_queues_array = array(
            array(
                'key' => 'task_product_id',
                'value' => $product_id,
                'compare' => '=',
                'type' => 'NUMERIC'
            ),
            array(
                'key' => '_task_status',
                'value' => 'hired',
                'compare' => '=',
            )
        );
        $taskbot_task_queues = taskbot_get_post_count_by_meta('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed'), $meta_task_queues_array);
        $gig_queues = $gig_queues + $taskbot_task_queues;

        //Gigs Completed
        $meta_task_completed_array = array(
            array(
                'key' => 'task_product_id',
                'value' => $product_id,
                'compare' => '=',
                'type' => 'NUMERIC'
            ),
            array(
                'key' => '_task_status',
                'value' => 'completed',
                'compare' => '=',
            )
        );
        $taskbot_task_completed = taskbot_get_post_count_by_meta('shop_order', array('wc-completed'), $meta_task_completed_array);
        $gig_completed = $gig_completed + $taskbot_task_completed;

        //Gigs Cancelled
        $meta_task_cancelled_array = array(
            array(
                'key' => 'task_product_id',
                'value' => $product_id,
                'compare' => '=',
                'type' => 'NUMERIC'
            ),
            array(
                'key' => '_task_status',
                'value' => 'cancelled',
                'compare' => '=',
            )
        );
        $taskbot_task_cancelled = taskbot_get_post_count_by_meta('shop_order', array('wc-cancelled', 'wc-refunded', 'wc-failed','wc-completed'), $meta_task_cancelled_array);
        $gig_cancelled = $gig_cancelled + $taskbot_task_cancelled;

    }
}

$taskbot_task_url = Taskbot_Profile_Menu::taskbot_profile_menu_link('orders', $user_identity,true,'listing');

?>
<div class="col-lg-8">
  <div class="tb-seller-counter">
      <ul class="tb-seller-counter-list" id="tb-counter-two">                  
          <li>
              <div class="tb-counter-content">
                  <div class="tb-counter-icon-button">
                      <div class="tb-icon-green">
                          <i class="tb-icon-check-square"></i>
                      </div>
                      <div class="tb-counter-button">
                          <a href="<?php echo esc_url($taskbot_project_url . '&order_type=completed') ?>" class="tb-counter-button-active"><?php esc_html_e('View','taskbot'); ?></a>
                      </div>
                  </div>
                  <h3 class="tb-counter-value"><span class="counter-value" data-count="<?php esc_html_e($completed_projects); ?>"><?php esc_html_e($completed_projects); ?></span></h3>
                  <strong><?php esc_html_e('Completed projects','taskbot'); ?></strong>
                  <div class="tb-icon-watermark">
                      <i class="tb-icon-check-square"></i>
                  </div>
              </div>
          </li>
          <li>
              <div class="tb-counter-content">
                  <div class="tb-counter-icon-button">
                      <div class="tb-icon-yellow">
                          <i class="tb-icon-watch"></i>
                      </div>
                      <div class="tb-counter-button">
                          <a class="tb-counter-button-active" href="<?php echo esc_url($taskbot_project_url . '&order_type=hired') ?>"><?php esc_html_e('View','taskbot'); ?></a>
                      </div>
                  </div>
                  <h3 class="tb-counter-value"><span class="counter-value" data-count="<?php esc_html_e($ongoing_projects); ?>"><?php esc_html_e($ongoing_projects); ?></span></h3>
                  <strong><?php esc_html_e('Ongoing projects','taskbot'); ?></strong>
                  <div class="tb-icon-watermark">
                      <i class="tb-icon-watch"></i>
                  </div>
              </div>
          </li>
          <li>
              <div class="tb-counter-content">
                  <div class="tb-counter-icon-button">
                      <div class="tb-icon-red">
                          <i class="tb-icon-x-square"></i>
                      </div>
                      <div class="tb-counter-button">
                          <a class="tb-counter-button-active" href="<?php echo esc_url($taskbot_project_url . '&order_type=refunded') ?>"><?php esc_html_e('View','taskbot'); ?></a>
                      </div>
                  </div>
                  <h3 class="tb-counter-value"><span class="counter-value" data-count="<?php esc_html_e($cancelled_projects); ?>"><?php esc_html_e($cancelled_projects); ?></span></h3>
                  <strong><?php esc_html_e('Cancelled projects','taskbot'); ?></strong>
                  <div class="tb-icon-watermark">
                      <i class="tb-icon-x-square"></i>
                  </div>
              </div>
          </li>
          <li>
              <div class="tb-counter-content">
                  <div class="tb-counter-icon-button">
                      <div class="tb-icon-purple">
                          <i class="tb-icon-briefcase"></i>
                      </div>
                      <div class="tb-counter-button">
                          <a class="tb-counter-button-active" href="<?php echo esc_url($taskbot_task_url . '&order_type=completed'); ?>"><?php esc_html_e('View','taskbot'); ?></a>
                      </div>
                  </div>
                  <h3 class="tb-counter-value"><span class="counter-value" data-count="<?php esc_html_e($gig_completed); ?>"><?php esc_html_e($gig_completed); ?></span></h3>
                  <strong><?php esc_html_e('Task sold','taskbot'); ?></strong>
                  <div class="tb-icon-watermark">
                      <i class="tb-icon-briefcase"></i>
                  </div>
              </div>
          </li>
                                      
          <li>
              <div class="tb-counter-content">
                  <div class="tb-counter-icon-button">
                      <div class="tb-icon-orange">
                          <i class="tb-icon-clock"></i>
                      </div>
                      <div class="tb-counter-button">
                          <a class="tb-counter-button-active" href="<?php echo esc_url($taskbot_task_url . '&order_type=hired'); ?>"><?php esc_html_e('View','taskbot'); ?></a>
                      </div>
                  </div>
                  <h3 class="tb-counter-value"><span class="counter-value" data-count="<?php esc_html_e($gig_queues); ?>"><?php esc_html_e($gig_queues); ?></span></h3>
                  <strong><?php esc_html_e('Ongoing tasks','taskbot'); ?></strong>
                  <div class="tb-icon-watermark">
                      <i class="tb-icon-clock"></i>
                  </div>
              </div>
          </li>
                                                                      
          <li>
              <div class="tb-counter-content">
                  <div class="tb-counter-icon-button">
                      <div class="tb-icon-red">
                          <i class="tb-icon-x-octagon"></i>
                      </div>
                      <div class="tb-counter-button">
                          <a class="tb-counter-button-active" href="<?php echo esc_url($taskbot_task_url . '&order_type=cancelled'); ?>"><?php esc_html_e('View','taskbot'); ?></a>
                      </div>
                  </div>
                  <h3 class="tb-counter-value"><span class="counter-value" data-count="<?php esc_html_e($gig_cancelled); ?>"><?php esc_html_e($gig_cancelled); ?></span></h3>
                  <strong><?php esc_html_e('Cancelled tasks','taskbot'); ?></strong>
                  <div class="tb-icon-watermark">
                      <i class="tb-icon-x-octagon"></i>
                  </div>
              </div>
          </li>
      </ul>
  </div>
    <div class="tb-buyercontainer">
        <div class="tb-tabfilter">
            <div class="tb-tabfiltertitle">
                <h5><?php esc_html_e('Earning history', 'taskbot'); ?></h5>
            </div>
        </div>
        <div class="tb-tabfilteritem">
            <canvas id="canvaschart" class="tb-linechart"></canvas>
        </div>
    </div>
</div>
<?php
$script = "
window.addEventListener('load', (event) =>{
  var activity = document.getElementById('canvaschart');
  if (activity !== null) {
  activity.height = 100;
  var config = {
    type: 'line',
    data: {
      labels: [".do_shortcode( $graph_keys )."],
      datasets: [{
        pointBackgroundColor: window.chartColors.dark_blue,
        backgroundColor: 'rgba(0,117,214,0.03)',
        borderColor: window.chartColors.dark_blue,
        borderWidth: 1,
        fill: true,
        pointBorderColor: '#ffffff',
        pointHoverBackgroundColor: '#fad85a',
        data: [".do_shortcode( $graph_values )."],
      }]
    },
    options: {
      responsive: true,
      title:false,

      position: 'nearest',
      animation:{
        duration:1000,
        easing:'linear',
        delay: 1500,
      },
      interaction: {
        intersect: false,
        mode: 'point',
        },
      font: {
        family: 'Nunito'
      },
      plugins: {
        filler: {
        propagate: false,
        },
        tooltip: {
          yAlign: 'bottom',
          displayColors:false,
          padding:{
            x:15,
            top:15,
            bottom:9,
          },
          borderColor:'#eee',
          borderWidth:1,
          titleColor: '#353648',
          bodyColor: '#353648',
          bodySpacing: 6,
          titleMarginBottom: 9,
          backgroundColor:'rgba(255, 255, 255)',
          callbacks: {
            title: function(context){
              return '".esc_html__('Earning:','taskbot')."'
            },
            label: function(context){
              return '".html_entity_decode($currency_symbol)."' + context.dataset.data[context.dataIndex]
            }
          }
        },
        legend:{
          display:false,
        },
      },
      elements: {
        line: {
        tension: 0.000001
        },
      },
      scales: {
        y:{
          ticks: {
          fontSize: 12, fontFamily: '', fontColor: '#000', fontStyle: '500',
          beginAtZero: true,
          callback: function(value, index, values) {
          if(parseInt(value) >= 1000){
            return '".html_entity_decode($currency_symbol)."' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
          } else {
            return '".html_entity_decode($currency_symbol)."' + value;
              }
            }
          }
        },
        x:{
        ticks: {fontSize: 12, fontFamily: '', fontColor: '#000', fontStyle: '500'},
        grid:{
            display : false
          }
        }
      },
      },
    }
    var ctx = document.getElementById('canvaschart').getContext('2d');

    var myLine = new Chart(ctx, config);
  };
})";
wp_add_inline_script( 'utils-chart', $script, 'after' );
