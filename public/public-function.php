<?php
require TASKBOT_DIRECTORY.'libraries/vendor/autoload.php';
use Dompdf\Dompdf;

/**
 * Task PDF
 *
 */
if( !function_exists('TaskbotBuyerServicePDF') ){
    function TaskbotBuyerServicePDF($order_id = '',$user_id='',$type='buyers') {
        if(!empty($order_id)) {
            
            $dompdf             = new Dompdf();
            $args               = array();
            $args['identity']   = $user_id;
            $args['option']     = 'pdf';
            $args['order_id']   = $order_id;
            ob_start();
            ?>
                <style scoped>
                    *, *::after, *::before {
                        margin: 0px;
                        padding: 0px;
                        box-sizing: border-box;
                    }
                    .tb-printable {
                        border: 1px solid #eee;
                        padding: 30px;
                        background: #fff;
                    }
                    body {
                        color: #0A0F26;
                        font-size: 16px;
                        line-height: 26px;
                    }
                    .tb-invoicebill {
                        display: flex;
                        justify-content: space-between;
                        width: 100%;
                    }
                    .tb-invoicebill figure{
                        width: 50%;
                        margin: 0;
                        display: inline-block;
                        vertical-align: middle;
                    }
                    .tb-billno{
                        margin-left: -5px;
                        width: 50%;
                        text-align: right;
                        display: inline-block;
                    }
                    .tb-billno h3 {
                        margin: 0;
                        color: #FCCF14;
                        font-size: 36px;
                        line-height: 37px;
                    }
                    .tb-billno span {
                        font-size: 18px;
                        font-weight: 700;
                        line-height: 22px;
                    }
                    .tb-tasksinfos {
                        margin: 29px 0 0;
                        width: 100%;
                    }
                    
                    .tb-invoicetasks{
                        vertical-align: middle;
                        display: inline-block;
                    }
                    .tb-invoicetasks h5 {
                        margin: 0;
                        font-size: 18px;
                        font-weight: 400;
                        line-height: 26px;
                    }
                    .tb-invoicetasks h3 {
                        font-size: 20px;
                        font-weight: 700;
                        line-height: 28px;
                        margin: 0;
                    }
                    .tb-invoicefromto {
                        padding: 37px 0;
                        margin-top: 32px;
                        border-top: 1px solid #eee;
                    }
                    .tb-fromreceiver {
                        width: 50%;
                        display: inline-block;
                        vertical-align: middle;
                    }
                    .tb-fromreceiver + .tb-fromreceiver{
                        margin-left: -5px;
                        margin-top: -20px;
                    }
                    .tb-fromreceiver h5 {
                        margin: 0 0 10px;
                        font-size: 18px;
                        line-height: 26px;
                    }
                    .tb-fromreceiver span {
                        font-size: 14px;
                        display: block;
                        color: #676767;
                        line-height: 24px;
                    }
                    .tb-tasksdates{
                        float: right;
                        text-align: right;
                        display: inline-block;
                        vertical-align: middle;
                    }
                    .tb-tasksdates span{
                        font-size: 14px;
                        line-height: 22px;
                    }
                    .tb-tasksdates span em {
                        font-style: normal;
                    }
                    .tb-invoice-table.tb-table {
                        margin: 0;
                        border: 0;
                        width: 100%;
                        max-width: 100%;
                        border-collapse: collapse;
                        background-color: #fff;
                    }
                    .tb-invoice-table.tb-table > thead {
                        border-top: 1px solid #eee;
                    }
                    tbody, td, tfoot, th, thead, tr {
                        border-color: inherit;
                        border-style: solid;
                        border-width: 0;
                    }
                    .tb-invoice-table.tb-table > thead > tr {
                        border: 0;
                        border-bottom: 1px solid #eee;
                    }
                    .tb-invoice-table.tb-table > thead > tr > th{
                        border: 0;
                        color: #0A0F26;
                        text-align: left;
                        background: #fff;
                        font-size: 14px;
                        font-weight: 700;
                        line-height: 35px;
                        padding: 17px 28px;
                    }
                    .tb-invoice-table.tb-table > tbody > tr {
                        border: 0;
                    }
                    .tb-invoice-table.tb-table > tbody > tr td {
                        line-height: 21px;
                        text-align: left;
                        background: #fff;
                        color: #676767;
                        font-size: 14px;
                        vertical-align: bottom;
                        padding: 24px 28px 23px 28px;
                    }
                    .tb-tablelistv2{
                        top: 20px;
                        margin-top: 6px;
                        position: relative;
                    }
                    .tb-invoice-table.tb-table > tbody > tr:first-child td {
                        vertical-align: top;
                        padding-bottom: 10px;
                    }
                    .tb-tablelist {
                        padding: 0;
                        margin: 3px 0 0;
                        list-style: none;
                    }
                    .tb-tablelist li {
                        font-size: 14px;
                        line-height: 22px;
                        position: relative;
                        list-style-type: none;
                        padding: 0;
                        color: #353648;
                        margin-top: 3px;
                        padding: 0 0 0 10px;
                    }
                    .tb-tablelist li::after {
                        left: 0;
                        top: -5px;
                        content: ".";
                        color: #676767;
                        font-size: 19px;
                        position: absolute;
                    }
                    .tb-invoice-table.tb-table > tbody > tr td h6 {
                        left: 0;
                        margin: 0;
                        bottom: -22px;
                        color: #0A0F26;
                        position: relative;
                        letter-spacing: 0.5px;
                        font-weight: 700;
                        font-size: 16px;
                        line-height: 26px;
                    }
                    .tb-subtotal {
                        width: 100%;
                        text-align: right;
                        margin: 22px 0 44px;
                        border-top: 1px solid #eee;
                        padding: 25px 0 0;
                    }
                    .tb-subtotalbill {
                        width: 100%;
                        margin: 0;
                        display: inline-block;
                        list-style: none;
                        max-width: 350px;
                        padding: 0 20px 0 30px;
                    }
                    .tb-subtotalbill li {
                        width: 100%;
                        color: #0A0F26;
                        display: block;
                        padding: 0 0 10px;
                        list-style-type: none;
                        font-size: 14px;
                        text-align: left;
                        line-height: 22px;
                    }
                    .tb-subtotalbill li h6 {
                        margin: 0;
                        float: right;
                        color: #0A0F26;
                        letter-spacing: 0.5px;
                        display: inline-block;
                        font-size: 16px;
                        line-height: 26px;
                        font-weight: 700;
                    }
                    .tb-sumtotal {
                        text-align: left;
                        min-width: 350px;
                        padding: 14px 20px 14px 30px;
                        background: #FCCF14;
                        border-radius: 4px;
                        margin-top: 14px;
                        list-style-type: none;
                        display: inline-block;
                        color: #1C1C1C;
                        font-size: 14px;
                        line-height: 22px;
                        font-weight: 700;
                    }
                    .tb-sumtotal h6 {
                        margin: 0;
                        float: right;
                        color: #1C1C1C;
                        font-size: 18px;
                        font-size: 18px;
                        line-height: 22px;
                    }
                    .tb-description{
                        font-size: 16px;
                        line-height: 26px;   
                    }
                    .tb-invoice-table.tb-table > tbody > tr + tr td:first-child{
                        padding-top: 28px;
                        vertical-align: top;
                        padding-bottom: 28px;
                    }
                    .tb-tags span, .tb-tags a {
                        color: #fff;
                        padding: 0 10px;
                        font-size: 12px;
                        line-height: 26px;
                        border-radius: 3px;
                        background: #FF9E2B;
                        letter-spacing: 0.5px;
                        display: inline-block;
                        vertical-align: middle;
                    }
                    .bg-complete {
                       background: #63d594 !important;
                    }
                </style>
            <?php
			$order_type = get_post_meta( $order_id, 'project_type',true );

            if( !empty($type) && $type === 'buyers'){
				if( !empty($order_type) && $order_type === 'hourly' ){
					do_action( 'taskbot_buyer_invoice_details', $args );
				} else {
					taskbot_get_template_part('dashboard/dashboard', 'invoice-detail',$args);
				}
                
            } else if( !empty($type) && $type === 'sellers'){
				if( !empty($order_type) && $order_type === 'hourly' ){
					do_action( 'taskbot_seller_invoice_details', $args );
				} else {
                	taskbot_get_template_part('dashboard/dashboard', 'seller-invoice-detail',$args);
				}
            }
            $output_html   = ob_get_clean();
            $dompdf->loadHtml($output_html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $upload             = wp_upload_dir();
            $upload_dir         = $upload['basedir'];
            $upload_rel_dir     = $upload['baseurl'] . '/invoices/';
            $upload_dir         = $upload_dir . '/invoices/';


            //create directory if not exists
            if (!is_dir($upload_dir)) {
                wp_mkdir_p($upload_dir);
            }

            $filename   = rand(100,2500).$order_id.date('Y-m-d-H-i-s').'.pdf';
            $file_name  = $upload_dir.$filename;
            $file_url   = $upload_rel_dir.$filename;
            ob_end_flush();

            $pdf_gen = $dompdf->output();

            if (!file_put_contents($file_name, $pdf_gen)) {
                return true;
            } else {
                
                return array(
                    'file_path' => $file_name,
                    'file_url'  => $file_url
                );
            }        
        }
    }
}

/**
 * Project proposal basic
 */
if( !function_exists('taskbotGetProposalBasic') ){
    function taskbotGetProposalBasic( $proposal_id=0 ,$type='', $user_id=0){
		global $paged;
		$proposal_details	= array();
		$project_id			= get_post_meta( $proposal_id, 'project_id',true );
		$project_id			= !empty($project_id) ? intval($project_id) : 0;
		$proposal_data		= get_post_meta( $proposal_id, 'proposal_meta',true );
		$proposal_status	= get_post_status( $proposal_id );
		$project_price		= taskbot_project_price($project_id);

		$proposal_price		= isset($proposal_data['price']) ? $proposal_data['price'] : 0;
		$proposal_type      = !empty($proposal_data['proposal_type']) ? $proposal_data['proposal_type'] : '';
		$price_options		= isset($proposal_price) ? taskbot_commission_fee($proposal_price,'return') : array();
		$proposal_meta		= get_post($proposal_id);

		$proposal_details['rating_details']			= array();
		$proposal_details['price_format']  			= isset($proposal_data['price']) ? taskbot_price_format($proposal_data['price'],'return') : '';
		$proposal_details['price']  				= isset($proposal_data['price']) ? $proposal_data['price'] : '';
		$proposal_details['proposal_type']  		= !empty($proposal_data['proposal_type']) ? $proposal_data['proposal_type'] : '';
		if( !empty($proposal_type) && $proposal_type === 'milestone'){
			$milestone              = !empty($proposal_data['milestone']) ? $proposal_data['milestone'] : array(); 
			$mileastone_array       = array();
			$completed_mil_array    = array();
			$hired_milestone        = array();
			$requested_milestone    = array();
		
			$hired_balance      = 0;
			$earned_balance     = 0;
			$remaning_balance   = 0;
			$milestone_total    = 0;
			if( !empty($milestone) ){
				foreach($milestone as $key => $value ){
					$status = !empty($value['status']) ? $value['status'] : '';
					$price  = !empty($value['price']) ? $value['price'] : 0;

					$value['price_format'] 	= taskbot_price_format($price,'return') ;
					$milestone_total    	= $milestone_total  + $price;
					
					if( !empty($status) && $status === 'hired'){
						$hired_balance = $hired_balance + $price;
						$hired_milestone[$key] = $value;
					} else if( !empty($status) && $status === 'completed'){
						$earned_balance = $earned_balance + $price;
						$completed_mil_array[$key] = $value;
		
					} else if( !empty($status) && $status === 'requested'){
						$requested_milestone[$key] = $value;
						$hired_balance       = $hired_balance + $price;
					} else {
						$mileastone_array[$key] = $value;
						$remaning_balance       = $remaning_balance + $price;
					}
		
				}
				if( !empty($milestone_total) && $milestone_total == $earned_balance ){
					$proposal_details['complete_option']         = 'yes';
				}
				$requested_milestone    = array_merge($requested_milestone,$hired_milestone);
				$mileastone_array       = array_merge($requested_milestone,$mileastone_array);
		
				$proposal_details['earned_balance']         = $earned_balance;
				$proposal_details['hired_balance']          = $hired_balance;
				$proposal_details['remaning_balance']       = $remaning_balance;
				$proposal_details['completed_mil_array']    = $completed_mil_array;
				$proposal_details['milestone_total']        = $milestone_total;

				$proposal_details['earned_balance_format']         = taskbot_price_format($earned_balance,'return');
				$proposal_details['hired_balance_format']          = taskbot_price_format($hired_balance,'return');
				$proposal_details['remaning_balance_format']       = taskbot_price_format($remaning_balance,'return');
				$proposal_details['mileastone_array_format']       = taskbot_price_format($mileastone_array,'return');
				$proposal_details['completed_mil_array_format']    = taskbot_price_format($completed_mil_array,'return');
				$proposal_details['milestone_total_format']        = taskbot_price_format($milestone_total,'return');
			}
			$proposal_details['milestone']  		= $mileastone_array;
			
		} else if( empty($proposal_type) || (!empty($proposal_type) && $proposal_type === 'fixed')){
			$proposal_details['complete_option']         = 'yes';
		}
		if( !empty($proposal_status) && $proposal_status === 'completed' ){
			$rating_id      	= get_post_meta( $proposal_id, '_rating_id', true );
			if( !empty($rating_id) ){
				$rating         = !empty($rating_id) ? get_comment_meta($rating_id, 'rating', true) : 0;
				$rating			= !empty($rating) ? number_format((float)$rating, 1, '.', '') : 0;
				$title          = !empty($rating_id) ? get_comment_meta($rating_id, '_rating_title', true) : '';
				$comment_detail = !empty($rating_id) ? get_comment($rating_id) : array();
				$content        = !empty($comment_detail->comment_content) ? $comment_detail->comment_content : '';
				$proposal_details['rating_details']['content']	= $content;
				$proposal_details['rating_details']['rating']	= $rating;
				$proposal_details['rating_details']['title']	= $title;
				
			}
		}
		$format_date      = get_option('date_format') . ' ' . get_option('time_format');
		$proposal_date 							= !empty($proposal_meta->post_date) ? date_i18n( $format_date, strtotime(get_the_date($proposal_meta->post_date)) ) : '';
		$proposal_details['proposal_date']		= esc_html($proposal_date);
		$proposal_details['proposal_meta']		= !empty($proposal_meta) ? $proposal_meta : array();
		$proposal_details['proposal_status']	= $proposal_status;
		$proposal_details['proposal_id']		= intval($proposal_id);
		$proposal_details['seller_id']      	= (int)get_post_field( 'post_author', $proposal_id );
		$proposal_details['buyer_id']       	= (int)get_post_field( 'post_author', $project_id );	

		/* get author of dispute */
		$dispute_id     					= get_post_meta( $proposal_id, 'dispute_id', true);
		$dispute_id     					= !empty($dispute_id) ? $dispute_id : 0;
		$dispute_author_id    				= !empty($dispute_id) ? get_post_field( 'post_author', $dispute_id ) : 0;
		$proposal_details['dispute_id'] 	= $dispute_id;
		$proposal_details['dispute_type'] 	= '';
		$proposal_details['dispute_author'] = '';
		if(!empty($dispute_author_id)){
			$proposal_details['dispute_author'] = (int)$dispute_author_id;
				$proposal_details['dispute_type'] = taskbot_dispute_status($dispute_id);
		}

		/* Dispute messages for buyer */
		$dispute_messages = taskbot_project_dispute_messages( $project_id, $proposal_id, $dispute_id, $user_id );
		$proposal_details['dispute_messages'] = !empty($dispute_messages) ? $dispute_messages : array();

		$proposal_details['proposal_price_formate']		= taskbot_price_format($proposal_price,'return');
		$proposal_details['admin_shares_formate']		= isset($price_options['admin_shares']) ? taskbot_price_format($price_options['admin_shares'],'return') : '';
		$proposal_details['seller_shares_formate']		= isset($price_options['seller_shares']) ? taskbot_price_format($price_options['seller_shares'],'return') : '';
		if( !empty($type) && $type==='detail' ){
			$user_id     							= get_post_field( 'post_author', $proposal_id );
			$linked_profile_id  					= taskbot_get_linked_profile_id($user_id, '','sellers');
			$proposal_details['seller_detail']		= taskbot_get_user_basic($linked_profile_id,$user_id);
			$proposal_details['project_detail']		= taskbotProjectDetails($project_id);

			$user_rating            				= get_post_meta( $linked_profile_id, 'tb_total_rating', true );
			$review_users           				= get_post_meta( $linked_profile_id, 'tb_review_users', true );

			$proposal_details['seller_detail']['user_rating']	= isset($user_rating) ? $user_rating : '';
			$proposal_details['seller_detail']['review_users']	= isset($review_users) ? $review_users : '';

			$args   = array(
				'post_id'       => $proposal_id,
				'orderby'       => 'date',
				'order'         => 'ASC',
				'hierarchical' 	=> 'threaded',
				'type'			=> 'activity_detail'
			);
			$comments 			= get_comments( $args );
			$proposal_comments	= array();
			if (isset($comments) && !empty($comments)){
				foreach ($comments as $key => $value) {
					$comment_children 	= array();
					$comment_children 	= $value->get_children();
					$commentsData		= taskbot_get_chat_history($value,$user_id);

					if (!empty($comment_children)){
						foreach ($comment_children as $comment_child){
							$commentsChildData		= taskbot_get_chat_history($comment_child,$user_id);
							$commentsData['child']	= $commentsChildData;
						}
					}
					$proposal_comments[]	= $commentsData;
				}
			}
			$invoices_list		= array();
			$date_format    	= get_option( 'date_format' );
			$time_format    	= get_option( 'time_format' );
			$current_page   	= $paged;
			$order_arg  = array(
				'paginate'      => true,
				'limit'         => -1,
				'proposal_id'   => $proposal_id
			);
			$customer_orders = wc_get_orders( $order_arg );
			if (!empty($customer_orders->orders)) {
				foreach ($customer_orders->orders as $order) {
					$invoice_data	= array();
					$invoice_title  = "";
					$milestone_id   = '';

					$invoice_status = get_post_meta( $order->get_id(),'_task_status', true );
					$product_data   = get_post_meta( $order->get_id(),'cus_woo_product_data', true );
					$project_type   = !empty($product_data['project_type']) ? $product_data['project_type'] : '';
					$seller_price	= !empty($product_data['seller_shares']) ? $product_data['seller_shares'] : "";
					$invoice_price      = $order->get_total();
					if(function_exists('wmc_revert_price')){
						$invoice_price =  wmc_revert_price($order->get_total(),$order->get_currency());
					}
					if( !empty($project_type) && $project_type === 'fixed' ){
						$milestone_id   = !empty($product_data['milestone_id']) ? $product_data['milestone_id'] : "";
						if( !empty($milestone_id)){
							$invoice_title  = !empty($proposal_details['milestone'][$milestone_id]['title']) ? $proposal_details['milestone'][$milestone_id]['title'] : "";
						} else if( empty($milestone_id) ){
							$project_id   = !empty($product_data['project_id']) ? $product_data['project_id'] : "";
							if( !empty($project_id) ){
								$invoice_title  = get_the_title( $project_id );
							}
						}
					} else {
						$invoice_title  = apply_filters( 'taskbot_filter_invoice_title', $order->get_id() );
					}
					$invoice_data['data_created']	= wc_format_datetime( $order->get_date_created(), $date_format . ', ' . $time_format );
					$invoice_data['invoice_status']	= !empty($invoice_status) ? $invoice_status : '';
					$invoice_data['invoice_status_title']	= !empty($invoice_status) ? apply_filters( 'taskbot_proposal_invoice_status_tag',$invoice_status,true) : '';
					$invoice_data['invoice_title']	= $invoice_title;
					$invoice_data['seller_price']	= $seller_price;
					$invoice_data['order_id']		= $order->get_id();
					$invoice_data['buyer_price']	= $invoice_price;

					$invoice_data['seller_price_format']	= taskbot_price_format($seller_price,'return');
					$invoice_data['buyer_price_format']		= taskbot_price_format($invoice_price,'return');
					$invoices_list[]						= $invoice_data;
				}

			}
			$proposal_details['invoices_list']    		= $invoices_list;
			$proposal_details['proposal_comments']    	= $proposal_comments;
		} else if( !empty($type) && $type==='seller_detail' ){
			$user_id     							= get_post_field( 'post_author', $proposal_id );
			$linked_profile_id  					= taskbot_get_linked_profile_id($user_id, '','sellers');
			$user_rating            				= get_post_meta( $linked_profile_id, 'tb_total_rating', true );
			$review_users           				= get_post_meta( $linked_profile_id, 'tb_review_users', true );

			$proposal_details['seller_detail']					= taskbot_get_user_basic($linked_profile_id,$user_id);
			$proposal_details['seller_detail']['user_rating']	= isset($user_rating) ? $user_rating : '';
			$proposal_details['seller_detail']['review_users']	= isset($review_users) ? $review_users : '';

			$args   = array(
				'post_id'       => $proposal_id,
				'orderby'       => 'date',
				'order'         => 'ASC',
				'hierarchical' 	=> 'threaded',
				'type'			=> 'activity_detail'
			);
			$comments 			= get_comments( $args );
			$proposal_comments	= array();
			if (isset($comments) && !empty($comments)){
				foreach ($comments as $key => $value) {
					$comment_children 	= array();
					$comment_children 	= $value->get_children();
					$commentsData		= taskbot_get_chat_history($value,$user_id);

					if (!empty($comment_children)){
						foreach ($comment_children as $comment_child){
							$commentsChildData		= taskbot_get_chat_history($comment_child,$user_id);
							$commentsData['child']	= $commentsChildData;
						}
					}
					$proposal_comments[]	= $commentsData;
				}
			}
			$invoices_list		= array();
			$date_format    	= get_option( 'date_format' );
			$time_format    	= get_option( 'time_format' );
			$current_page   	= $paged;
			$order_arg  = array(
				'paginate'      => true,
				'limit'         => -1,
				'proposal_id'   => $proposal_id
			);
			$customer_orders = wc_get_orders( $order_arg );
			if (!empty($customer_orders->orders)) {
				foreach ($customer_orders->orders as $order) {
					$invoice_data	= array();
					$invoice_title  = "";
					$milestone_id   = '';

					$invoice_status = get_post_meta( $order->get_id(),'_task_status', true );
					$product_data   = get_post_meta( $order->get_id(),'cus_woo_product_data', true );
					$project_type   = !empty($product_data['project_type']) ? $product_data['project_type'] : '';
					$seller_price	= !empty($product_data['seller_shares']) ? $product_data['seller_shares'] : "";
					$invoice_price      = $order->get_total();
					if(function_exists('wmc_revert_price')){
						$invoice_price =  wmc_revert_price($order->get_total(),$order->get_currency());
					}
					if( !empty($project_type) && $project_type === 'fixed' ){
						$milestone_id   = !empty($product_data['milestone_id']) ? $product_data['milestone_id'] : "";
						if( !empty($milestone_id)){
							$invoice_title  = !empty($proposal_details['milestone'][$milestone_id]['title']) ? $proposal_details['milestone'][$milestone_id]['title'] : "";
						} else if( empty($milestone_id) ){
							$project_id   = !empty($product_data['project_id']) ? $product_data['project_id'] : "";
							if( !empty($project_id) ){
								$invoice_title  = get_the_title( $project_id );
							}
						}
					} else {
						$invoice_title  = apply_filters( 'taskbot_filter_invoice_title', $order->get_id() );
					}
					$invoice_data['data_created']	= wc_format_datetime( $order->get_date_created(), $date_format . ', ' . $time_format );
					$invoice_data['invoice_status']	= !empty($invoice_status) ? $invoice_status : '';
					$invoice_data['invoice_status_title']	= !empty($invoice_status) ? apply_filters( 'taskbot_proposal_invoice_status_tag',$invoice_status,true) : '';
					$invoice_data['invoice_title']	= $invoice_title;
					$invoice_data['seller_price']	= $seller_price;
					$invoice_data['order_id']		= $order->get_id();
					$invoice_data['buyer_price']	= $invoice_price;

					$invoice_data['seller_price_format']	= taskbot_price_format($seller_price,'return');
					$invoice_data['buyer_price_format']		= taskbot_price_format($invoice_price,'return');
					$invoices_list[]						= $invoice_data;
				}

			}
			$proposal_details['invoices_list']    		= $invoices_list;
			$proposal_details['proposal_comments']    	= $proposal_comments;
		} else if( !empty($type) && $type==='projects_activity' ){
			$user_id     							= get_post_field( 'post_author', $proposal_id );
			$linked_profile_id  					= taskbot_get_linked_profile_id($user_id, '','sellers');
			$proposal_details['seller_detail']		= taskbot_get_user_basic($linked_profile_id,$user_id);
			$proposal_details['project_detail']		= taskbotProjectDetails($project_id,$type);

			$args   = array(
				'post_id'       => $proposal_id,
				'orderby'       => 'date',
				'order'         => 'ASC',
				'hierarchical' 	=> 'threaded',
				'type'			=> 'activity_detail'
			);
			$comments 			= get_comments( $args );
			$proposal_comments	= array();
			if (isset($comments) && !empty($comments)){
				foreach ($comments as $key => $value) {
					$comment_children 	= array();
					$comment_children 	= $value->get_children();
					$commentsData		= taskbot_get_chat_history($value,$user_id);

					if (!empty($comment_children)){
						foreach ($comment_children as $comment_child){
							$commentsChildData		= taskbot_get_chat_history($comment_child,$user_id);
							$commentsData['child']	= $commentsChildData;
						}
					}
					$proposal_comments[]	= $commentsData;
				}
			}
			$proposal_details['proposal_comments']    	= $proposal_comments;
		}
		return $proposal_details;
	}
}

/**
 * Project details
 *
 */
if( !function_exists('taskbotProjectDetails') ){
    function taskbotProjectDetails( $project_id=0,$type='', $user_id=0){
		$project_details	= array();
		$product            = wc_get_product($project_id);
		if( !empty($product) ){
			$product_author_id  = get_post_field ('post_author', $product->get_id());
			$linked_profile_id  = taskbot_get_linked_profile_id($product_author_id, '','buyers');
			$user_name          = taskbot_get_username($linked_profile_id);
			$is_verified    	= !empty($linked_profile_id) ? get_post_meta( $linked_profile_id, '_is_verified',true) : '';
			$project_price      = taskbot_project_price($product->get_id());
			$project_meta       = get_post_meta( $product->get_id(), 'tb_project_meta',true );
			$project_meta       = !empty($project_meta) ? $project_meta : array();
			$project_type       = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
			$userdata       	= get_userdata( $product_author_id );
			$registered_on     	= !empty($userdata->user_registered) ? $userdata->user_registered : '';
			$registered_date    = !empty( $registered_on ) ? date_i18n( get_option( 'date_format' ),  strtotime($registered_on)) : '';
			$avatar     = apply_filters(
				'taskbot_avatar_fallback',
				taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $linked_profile_id),
				array('width' => 100, 'height' => 100)
			);
			$post_status				= get_post_status( $product->get_id() );
			$publish_date				= get_post_meta( $product->get_id(), '_publish_datetime',true );
			$downloadable_doc 			= get_post_meta($project_id, '_downloadable_files', true);
			$selected_freelancers   	= !empty($product) ? get_post_meta( $product->get_id(), 'no_of_freelancers', true ) : '';
			$posted_project_count   	= taskbot_get_user_projects($product_author_id);
			$hired_project_count    	= taskbot_get_user_projects($product_author_id,'hired');
			$address        			= apply_filters( 'taskbot_user_address', $linked_profile_id );
			$project_location_types     = taskbot_project_location_type();
			$selected_location          = !empty($product) ? get_post_meta( $product->get_id(), '_project_location',true ) : '';
			$selected_location          = !empty($selected_location) ? $selected_location : '';
			$post_project_status		= get_post_meta( $product->get_id(), '_post_project_status',true );
			$project_details['posted_time']	= '';
			if(!empty($publish_date)){
				$publish_date		= !empty($publish_date) ? strtotime($publish_date) : 0;
				$offset 			= (float)get_option('gmt_offset') * intval(60) * intval(60);
				$publish_date       = $publish_date + $offset;
				if( !empty($publish_date) ){
					$project_details['posted_time']	= sprintf( _x( 'Posted %s ago', '%s = human-readable time difference', 'taskbot-api' ), human_time_diff( $publish_date, current_time( 'timestamp' ) ) );
				}
			}
			$downloadable_files	= 'no';
			if(!empty($downloadable_doc) ){
				$downloadable_files	= 'yes';
			}
			$type_text	= '';
			if(  !empty($project_type) && $project_type === 'fixed'){
				$type_text    = esc_html__('Fixed price project','taskbot-api');
			} else {
				$type_text =  apply_filters( 'taskbot_filter_project_type_text', $project_type );
			}
			
			$project_details['is_featured']	= 'no';
			if($product->get_featured()){
				$project_details['is_featured']	= 'yes';
			}
			
			$project_details['project_id']				= $project_id;
			$project_details['project_url']				= get_the_permalink($project_id);
			$project_details['type_text']				= $type_text;
			$project_details['author_id']				= intval($product_author_id);
			$project_details['profile_id']				= $linked_profile_id;
			$project_details['user_name']				= $user_name;
			$project_details['is_verified']				= $is_verified;
			$project_details['post_project_status']		= !empty($post_project_status) ? $post_project_status : '';
			$project_details['buyer_address']			= $address;
			$project_details['avatar']					= $avatar;
			$project_details['buyer_hired_project']		= $hired_project_count;
			$project_details['buyer_posted_project']	= $posted_project_count;
			$project_details['buyer_registered_date']	= $registered_date;
			$project_details['freelancers']				= $selected_freelancers;
			$project_details['selected_location']		= $selected_location;
			$project_details['location_text']			= !empty($selected_location) && !empty($project_location_types[$selected_location]) ? $project_location_types[$selected_location] : '';
			$project_details['title']					= $product->get_name();
			$project_details['description']				= !empty($product) ? $product->get_description() : "";
			$project_details['project_meta']			= $project_meta;
			$project_details['project_price']			= $project_price;
			$project_details['downloadable_files']		= $downloadable_files;
			$project_details['downloadable_docs']		= $downloadable_doc;
			$project_details['skills']					= taskbotTermsByPostID($project_id,'skills');
			$project_details['product_cat']				= taskbotTermsByPostID($project_id,'product_cat');
			$project_details['duration']				= taskbotTermsByPostID($project_id,'duration');
			$project_details['languages']				= taskbotTermsByPostID($project_id,'languages');
			$project_details['expertise_level']			= taskbotTermsByPostID($project_id,'expertise_level');
			if( !empty($type) && $type === 'proposals' ){
				$proposals_data	= array();
				$args = array(
					'post_type' 	    => 'proposals',
					'post_status'       => array('publish','hired','completed','cancelled','disputed','refunded'),
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
				$proposals  = get_posts( $args );
				if( !empty($proposals) ){
					foreach($proposals as $proposal){
						$proposals_data[]	= taskbotGetProposalBasic($proposal->ID,'seller_detail', $user_id);
					}
				}
				$project_details['proposals']	= $proposals_data;
			}
		}
		return $project_details;

	}
}

/**
 * Project term by post ID
 *
 */
if( !function_exists('taskbotTermsByPostID') ){
	function taskbotTermsByPostID( $post_id=0,$tax_name='category' ) {
		$term_array			= array();
		$post_terms 		= wp_get_post_terms( $post_id, $tax_name );
		if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
			$term_array = array();
			if( !empty($post_terms) ){
				foreach ( $post_terms as $term ) {
					if( isset($term->term_id) ){
						$new_term				= array();
						$new_term['term_id']	= $term->term_id;
						$new_term['name']		= $term->name;
						$new_term['slug']		= $term->slug;
						$term_array[] 	= $new_term;
					}
				}
			}
		}
		return $term_array;
	}
}

/**
 * Dispute details
 *
 */
if( !function_exists('taskbotDisputeDetails') ){
    function taskbotDisputeDetails( $dispute_id){
        global $taskbot_settings;
        $buyer_dispute_days	    = !empty($taskbot_settings['buyer_dispute_option'])	? intval($taskbot_settings['buyer_dispute_option']) : 5;
        $post_date             = !empty($dispute_id) ? get_post_field( 'post_date', $dispute_id ) : 0;
        $disbuted_time         = !empty($post_date) ? strtotime($post_date. ' + '.intval($buyer_dispute_days).' days') : 0;
        $current_time          = strtotime(current_time( 'mysql', 1 ));
        $post_author           = !empty($dispute_id) ? get_post_field( 'post_author', $dispute_id ) : 0;
        $dispute_status         = !empty($dispute_id) ? get_post_status( $dispute_id ) : '';
        $winning_party          = get_post_meta( $dispute_id, 'winning_party',true );
        $winning_party          = !empty($winning_party) ? intval($winning_party) : 0;
        $list                   = array();
        $list['buyer_dispute_days'] = $buyer_dispute_days;
        $list['disbuted_time']      = $disbuted_time;
        $list['current_time']       = $current_time;
        $list['post_author']        = $post_author;
        $list['winning_party']      = $winning_party;
        $list['dispute_status']     = $dispute_status;
        return $list;
    }
}

/**
 * Order tasks
 *
 */
if( !function_exists('taskbotOrderTasks') ){
    function taskbotOrderTasks( $user_id=0,$data=array(),$option_type=''){
        $wallet         = !empty($data['wallet']) ? esc_html($data['wallet']) : '';
        $product_id     = !empty($data['id']) ? intval($data['id']) : 0;
        $task           = !empty($data['product_task']) ? $data['product_task'] : '';
        $subtasks       = !empty($data['subtasks']) ? explode(',',$data['subtasks']) : array();
        $seller_id      = get_post_field( 'post_author', $product_id );
        $plans 	        = get_post_meta($product_id, 'taskbot_product_plans', TRUE);
        $plans	        = !empty($plans) ? $plans : array();
        $user_balance   = !empty($user_id) ? get_user_meta( $user_id, '_buyer_balance',true ) : '';
        $plan_price     = !empty($plans[$task]['price']) ? $plans[$task]['price'] : 0;
        $total_price    = $plan_price;
        if( !empty($subtasks) ){
            foreach($subtasks as $key => $subtask_id){
                $single_price   = get_post_meta( $subtask_id, '_regular_price',true );
                $single_price   = !empty($single_price) ? $single_price : 0;
                $total_price    = $total_price + $single_price;
            }
        }

        if ( class_exists('WooCommerce') ) {
            global $woocommerce;
            if( !empty($option_type) && $option_type === 'mobile' ){
                check_prerequisites($user_id);
            }
            $woocommerce->cart->empty_cart(); //empty cart before update cart
            $user_id        = $user_id;
            $service_fee    = taskbot_commission_fee($total_price);
            $admin_shares   = !empty($service_fee['admin_shares']) ? $service_fee['admin_shares'] : 0.0;
            $seller_shares  = !empty($service_fee['seller_shares']) ? $service_fee['seller_shares'] : $total_price;

            if( !empty($wallet) && !empty($user_balance) && $user_balance < $total_price ){
                $cart_meta['wallet_price']		    = $user_balance;
            }
            $cart_meta['task_id']		    = $product_id;
            $cart_meta['total_amount']		= $total_price;
            $cart_meta['task']		        = $task;
            $cart_meta['price']		        = $plan_price;
            $cart_meta['subtasks']		    = $subtasks;
            $cart_meta['buyer_id']		    = $user_id;
            $cart_meta['seller_id']		    = $seller_id;
            $cart_meta['admin_shares']		= $admin_shares;
            $cart_meta['seller_shares']		= $seller_shares;
            $cart_meta['payment_type']      = 'tasks';
            $cart_data = array(
                'product_id'        => $product_id,
                'cart_data'         => $cart_meta,
                'price'             => $plan_price,
                'payment_type'      => 'tasks',
                'admin_shares'      => $admin_shares,
                'seller_shares'     => $seller_shares,
                'buyer_id'          => $user_id,
                'seller_id'         => $seller_id,
            );
            $woocommerce->cart->empty_cart();
            $cart_item_data = apply_filters('taskbot_order_task_cart_data',$cart_data);
            WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);

            if( !empty($subtasks) ){
                foreach($subtasks as $subtasks_id){
                    WC()->cart->add_to_cart( $subtasks_id, 1 );
                }
            }

            if( !empty($wallet) && !empty($user_balance) && $user_balance >= $total_price ){
                $order_id               = taskbot_place_order($user_id,'task-wallet');
                $json['checkout_url']	= Taskbot_Profile_Menu::taskbot_profile_menu_link('tasks-orders', $user_id, true);
                $json['order_id']       = $order_id;
                
            } else {
                $linked_profile_id  = taskbot_get_linked_profile_id($user_id);
                if( !empty($linked_profile_id) && !empty($cart_data) ){
                    update_post_meta( $linked_profile_id, 'mobile_checkout_data',$cart_data );
                    $mobile_checkout    = taskbot_get_page_uri('mobile_checkout');
                    if(!empty($mobile_checkout) ){
                        $json['checkout_url']	= $mobile_checkout.'?post_id='.$linked_profile_id;
                    }
                }                
            }

            $json['type'] 		        = 'success';    
            if( !empty($option_type) && $option_type === 'mobile'){
                $order_id   = !empty($json['order_id']) ? intval($json['order_id']) : 0;
                if( !empty($json['order_id']) ){
                    $order_details  = !empty($json['order_id']) ? get_post_meta( $json['order_id'], 'cus_woo_product_data', true ) : array();
                    taskbot_update_tasks_data($json['order_id'],$order_details);
                    taskbot_complete_order($order_id);
                }
                return $json;
            } else{
                wp_send_json( $json );
            }
        }
    }
}

/**
 * Get profile
 *
 */
if( !function_exists('taskbotGetProfile') ){
    function taskbotGetProfile( $post_id=0, $user_id=0, $type=''){
        $list                           = array();
        $deactive_account	            = get_post_meta( $post_id, '_deactive_account', true );
        $deactive_account	            = !empty($deactive_account) ? $deactive_account : 0;
        $avatar                         = apply_filters('taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 315, 'height' => 300), $post_id),array('width' => 315, 'height' => 300));
        $is_online	                    = apply_filters('taskbot_is_user_online',$user_id);
        $tb_post_meta                   = get_post_meta( $post_id, 'tb_post_meta', true);
        $is_verified                    = get_post_meta( $post_id, '_is_verified', true );
        $identity_verified  	        = get_user_meta( $user_id, 'identity_verified', true);
        $address                        = apply_filters( 'taskbot_user_address', $post_id );

        $country		                = get_post_meta($post_id, 'country', true);
        $zipcode		                = get_post_meta($post_id, 'zipcode', true);

        $list['country']		        = !empty($country) ? $country : '';
        $list['zipcode']		        = !empty($zipcode) ? $zipcode : '';
        if( !empty($type) && $type === 'sellers' ){
            $success_rate           = 0;
            $profile_views          = get_post_meta( $post_id,'taskbot_profile_views',true );
            $review_users           = get_post_meta( $post_id, 'tb_review_users', true );
            $tb_hourly_rate         = get_post_meta( $post_id, 'tb_hourly_rate', true );
            $user_rating            = get_post_meta( $post_id, 'tb_total_rating', true );

            if(function_exists('taskbot_success_rate')){
                $success_rate       = taskbot_success_rate($user_id);
            }
            $list['success_rate']   = !empty($success_rate) ? esc_html($success_rate) : '';
            $list['review_users']   = !empty($review_users) ? intval($review_users) : 0;
            $list['user_rating']    = !empty($user_rating) ? $user_rating : 0;
            $list['hourly_rate']    = !empty($tb_hourly_rate) ? taskbot_price_format($tb_hourly_rate,'return') : 0;
            $list['hourlyprice']    = !empty($tb_hourly_rate) ? $tb_hourly_rate : 0;
           
            $list['user_link']      = get_the_permalink($post_id);
            $list['profile_views']  = !empty($profile_views) ? intval($profile_views) : 0;
            $eduction_array  = array();
            if( !empty($tb_post_meta['education']) ){
                foreach($tb_post_meta['education'] as $key => $value ){
                    $eduction                   = array();
                    $eduction['degree_title']	= !empty($value['title']) ? $value['title'] : '';
                    $eduction['institute']		= !empty($value['institute']) ? $value['institute'] : '';
                    $eduction['key']		    = !empty($key) ? $key : 0;
                    $enddate 		            = !empty($value['end_date'] ) ? $value['end_date'] : '';
                    $eduction['end_date_format']= !empty( $enddate ) ? date_i18n(get_option( 'date_format' ), strtotime(apply_filters('taskbot_date_format_fix',$enddate ))) : '';
                    $eduction['end_date'] 		= $enddate;
                    $eduction['start_date'] 	= !empty($value['start_date'] ) ? $value['start_date'] : '';
                    $eduction['description'] 	= !empty($value['description'] ) ? esc_html($value['description']) : '';
                    $eduction_array[]           = $eduction;
                }
            }
            $list['education']      = $eduction_array;
            $seller_type			= wp_get_object_terms($post_id, 'tb_seller_type');
            $english_level			= wp_get_object_terms($post_id, 'tb_english_level');
            $total_order_arg  = array(
                array(
                    'key'       => 'seller_id',
                    'value'     => $user_id,
                    'compare'   => '=',
                    'type'      => 'NUMERIC'
                ),
                array(
                    'key'       => 'payment_type',
                    'value'     => 'tasks',
                    'compare'   => '=',
                )
            );
            $total_order    = taskbot_get_post_count_by_meta('shop_order', array('wc-completed', 'wc-pending', 'wc-on-hold', 'wc-cancelled', 'wc-refunded', 'wc-processing'), $total_order_arg);
            $order_id 		= get_user_meta($user_id, 'package_order_id', true);
            $order_id		= !empty($user_id) ? intval($order_id) : 0;
            $country        = get_post_meta( $post_id, 'country', true );
            $list['country']= !empty($country) ? $country : '';
            if( !empty($order_id) ){
                $package_details					= array();
                $package_id							= get_post_meta($order_id, 'package_id', true);
                $product_instant					= !empty($package_id)	? get_post( $package_id ) : '';
                $package_details['title']			= !empty($product_instant) ? sanitize_text_field($product_instant->post_title) : '';
                $package_details['content']			= !empty($product_instant) ? sanitize_text_field($product_instant->post_content) : '';
                $package_details['image']			= !empty($package_id) ? get_the_post_thumbnail_url( $package_id, array(315,300) ) : '';
                $list['package']				    = $package_details;                
            }

            $list['first_name']		= !empty($tb_post_meta['first_name']) ? $tb_post_meta['first_name'] : '';
            $list['last_name']		= !empty($tb_post_meta['last_name']) ? $tb_post_meta['last_name'] : '';
            $list['total_order']    = !empty($total_order) ? intval($total_order) : 0;
            $list['seller_type']	= isset($seller_type[0]->term_id) ? $seller_type[0]->term_id : '';
            $list['english_level']	= isset($english_level[0]->term_id) ? $english_level[0]->term_id : '';
        }

        if( !empty($type) && $type === 'sellers'){
            $meta_array	= array(
                array(
                    'key'		=> 'seller_id',
                    'value'		=> $user_id,
                    'compare'	=> '=',
                    'type'		=> 'NUMERIC'
                ),
                array(
                    'key'		=> '_task_status',
                    'value'		=> 'completed',
                    'compare'	=> '=',
                ),
                array(
                    'key'		=> 'payment_type',
                    'value'		=> 'tasks',
                    'compare'	=> '=',
                )
            );
            $taskbot_order_completed  = taskbot_get_post_count_by_meta('shop_order',array('wc-completed'),$meta_array);
            $meta_array	= array(
                array(
                    'key'		=> 'seller_id',
                    'value'		=> $user_id,
                    'compare'	=> '=',
                    'type'		=> 'NUMERIC'
                ),
                array(
                    'key'		=> '_task_status',
                    'value'		=> 'hired',
                    'compare'	=> '=',
                ),
                array(
                    'key'		=> 'payment_type',
                    'value'		=> 'tasks',
                    'compare'	=> '=',
                )
            );
            $taskbot_order_hired    	= taskbot_get_post_count_by_meta('shop_order',array('wc-completed'),$meta_array);
            $taskbot_order_completed	= !empty($taskbot_order_completed) ? intval($taskbot_order_completed) : 0;
            $taskbot_order_hired		= !empty($taskbot_order_hired) ? intval($taskbot_order_hired) : 0;
            $list['hired_order']        = $taskbot_order_hired;
            $list['completed_order']    = $taskbot_order_completed;
        } else if( !empty($type) && $type === 'buyers'){
            $meta_array	= array(
                array(
                    'key'		=> 'buyer_id',
                    'value'		=> $user_id,
                    'compare'	=> '=',
                    'type'		=> 'NUMERIC'
                ),
                array(
                    'key'		=> '_task_status',
                    'value'		=> 'completed',
                    'compare'	=> '=',
                ),
                array(
                    'key'		=> 'payment_type',
                    'value'		=> 'tasks',
                    'compare'	=> '=',
                )
            );
            $taskbot_order_completed  = taskbot_get_post_count_by_meta('shop_order',array('wc-completed'),$meta_array);
            $meta_array	= array(
                array(
                    'key'		=> 'buyer_id',
                    'value'		=> $user_id,
                    'compare'	=> '=',
                    'type'		=> 'NUMERIC'
                ),
                array(
                    'key'		=> '_task_status',
                    'value'		=> 'hired',
                    'compare'	=> '=',
                ),
                array(
                    'key'		=> 'payment_type',
                    'value'		=> 'tasks',
                    'compare'	=> '=',
                )
            );
            $taskbot_order_hired    	= taskbot_get_post_count_by_meta('shop_order',array('wc-completed'),$meta_array);
            $taskbot_order_completed	= !empty($taskbot_order_completed) ? intval($taskbot_order_completed) : 0;
            $taskbot_order_hired		= !empty($taskbot_order_hired) ? intval($taskbot_order_hired) : 0;
            $list['hired_order']        = $taskbot_order_hired;
            $list['completed_order']    = $taskbot_order_completed;

        }

        $list['first_name']		    = !empty($tb_post_meta['first_name']) ? $tb_post_meta['first_name'] : '';
        $list['last_name']		    = !empty($tb_post_meta['last_name']) ? $tb_post_meta['last_name'] : '';
        $list['user_name']          = taskbot_get_username($post_id);
        $list['is_verified']        = !empty($is_verified) ? $is_verified : '';
        $list['tagline']            = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
        $list['address']            = !empty($address) ? esc_html($address) : '';
        $list['status']             = $is_online;
        $list['avatar']             = esc_url($avatar);
        $list['profile_id']         = $post_id;
        $list['identity_verified']  = !empty($identity_verified) ? $identity_verified : '';
        return $list;
    }
}

/**
 * Get user basic
 *
 */
if( !function_exists('taskbot_get_user_basic') ){
    function taskbot_get_user_basic( $post_id=0, $user_id=0){
        $list                           = array();
        $avatar                         = apply_filters('taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 315, 'height' => 300), $post_id),array('width' => 315, 'height' => 300));
        $identity_verified  	        = get_user_meta($user_id, 'identity_verified', true);
        $is_verified                    = get_post_meta( $post_id, '_is_verified', true );
        $deactive_account	            = get_post_meta( $post_id, '_deactive_account', true );
        $deactive_account	            = !empty($deactive_account) ? $deactive_account : 0;

        $list['user_name']              = taskbot_get_username($post_id); 
        $list['is_verified']            = !empty($is_verified) ? $is_verified : '';
        $list['avatar']                 = esc_url($avatar);
        $list['profile_id']             = $post_id;
        $list['deactive_account']       = $deactive_account;
        $list['user_id']                = $user_id;
        $list['identity_verified']      = !empty($identity_verified) ? $identity_verified : '';
        

        return $list;
    }
}

/**
 * Get task history
 *
 */
if (!function_exists('taskbot_get_chat_history')) {
    function taskbot_get_chat_history($value = array(), $type = 'parent', $user_id = 0)
    {
        $comment_data   = array();
        $comment_data['date']           = !empty($value->comment_date) ? $value->comment_date : '';
        $comment_data['author_id']      = !empty($value->user_id) ? $value->user_id : '';
        $comment_data['comments_id']    = !empty($value->comment_ID) ? $value->comment_ID : '';
        $comment_data['author']         = !empty($value->comment_author) ? $value->comment_author : '';
        $comment_data['message']        = !empty($value->comment_content) ? $value->comment_content : '';
        $message_files                  = get_comment_meta($value->comment_ID, 'message_files', true);
        $comment_data['message_type']   = get_comment_meta($value->comment_ID, '_message_type', true);

        $comment_data['date_formate']           = !empty($comment_data['date']) ? date_i18n('F j, Y', strtotime($comment_data['date'])) : '';
        $comment_data['author_user_type']       = apply_filters('taskbot_get_user_type', $comment_data['author_id']);
        $comment_data['author_profile_id']      = taskbot_get_linked_profile_id($comment_data['author_id'], '', $comment_data['author_user_type']);
        $comment_data['auther_url']             = !empty($comment_data['author_user_type']) && $comment_data['author_user_type'] === 'sellers' ? get_the_permalink($comment_data['author_profile_id']) : '#';
        $comment_data['author_name']            = taskbot_get_username($comment_data['author_profile_id']);
        $comment_data['avatar']                 = apply_filters('taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $comment_data['author_profile_id']), array('width' => 50, 'height' => 50));
        $file_list  = array();
        if( !empty($message_files) ){
            foreach($message_files as $message_file){
                $src        = TASKBOT_DIRECTORY_URI . 'public/images/doc.jpg';
                if (isset($message_file['ext']) && !empty($message_file['ext'])) {
                    if ($message_file['ext'] == 'pdf') {
                        $src = TASKBOT_DIRECTORY_URI . 'public/images/pdf.jpg';
                    } elseif ($message_file['ext'] == 'png') {
                        $src = TASKBOT_DIRECTORY_URI . 'public/images/png.jpg';
                    } elseif ($message_file['ext'] == 'ppt') {
                        $src = TASKBOT_DIRECTORY_URI . 'public/images/ppt.jpg';
                    } elseif ($message_file['ext'] == 'psd') {
                        $src = TASKBOT_DIRECTORY_URI . 'public/images/psd.jpg';
                    } elseif ($message_file['ext'] == 'php') {
                        $src = TASKBOT_DIRECTORY_URI . 'public/images/php.jpg';
                    }
                }
                $file_list[]    = $src;
            }
        }
        $comment_data['attachments']    = $file_list;
        return $comment_data;

    }
}

/**
 * Get seller details
 *
 */
 if( !function_exists('taskbot_seller_details') ){
    function taskbot_seller_details( $seller_id=0, $user_id=0,$type='' ){
        $list                   = array();
        $avatar                 = apply_filters('taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 315, 'height' => 300), $seller_id),array('width' => 315, 'height' => 300));
        $is_online	            = apply_filters('taskbot_is_user_online',$user_id);
        $user_rating            = get_post_meta( $seller_id, 'tb_total_rating', true );
        $tb_post_meta           = get_post_meta($seller_id, 'tb_post_meta', true);
        $review_users           = get_post_meta( $seller_id, 'tb_review_users', true );
        $tb_hourly_rate         = get_post_meta( $seller_id, 'tb_hourly_rate', true );
        $is_verified            = get_post_meta( $seller_id, '_is_verified', true );
        $identity_verified  	= get_user_meta($user_id, 'identity_verified', true);
        $profile_views          = get_post_meta( $seller_id,'taskbot_profile_views',true );
        $address                = apply_filters( 'taskbot_user_address', $seller_id );
        $success_rate           = 0;
        
        if(function_exists('taskbot_success_rate')){
            $success_rate       = taskbot_success_rate($user_id);
        }
        $eduction_array  = array();
        if( !empty($tb_post_meta['education']) ){
            foreach($tb_post_meta['education'] as $key => $value ){
                $eduction                   = array();
                $eduction['degree_title']	= !empty($value['title']) ? $value['title'] : '';
                $eduction['institute']		= !empty($value['institute']) ? $value['institute'] : '';
                $eduction['key']		    = !empty($key) ? $key : 0;
                $enddate 		            = !empty($value['end_date'] ) ? $value['end_date'] : '';
                $eduction['end_date_format']= !empty( $enddate ) ? date_i18n(get_option( 'date_format' ), strtotime(apply_filters('taskbot_date_format_fix',$enddate ))) : '';
                $eduction['end_date'] 		= $enddate;
                $eduction['start_date'] 	= !empty($value['start_date'] ) ? $value['start_date'] : '';
                $eduction['description'] 	= !empty($value['description'] ) ? esc_html($value['description']) : '';
                $eduction_array[]           = $eduction;
            }
        }
        if( !empty($type) && $type ='login' ){
            $seller_type			= wp_get_object_terms($seller_id, 'tb_seller_type');
            $english_level			= wp_get_object_terms($seller_id, 'tb_english_level');
            $total_order_arg  = array(
                array(
                    'key'       => 'seller_id',
                    'value'     => $user_id,
                    'compare'   => '=',
                    'type'      => 'NUMERIC'
                ),
                array(
                    'key'       => 'payment_type',
                    'value'     => 'tasks',
                    'compare'   => '=',
                )
            );
            $total_order    = taskbot_get_post_count_by_meta('shop_order', array('wc-completed', 'wc-pending', 'wc-on-hold', 'wc-cancelled', 'wc-refunded', 'wc-processing'), $total_order_arg);
            $order_id 		= get_user_meta($user_id, 'package_order_id', true);
            $order_id		= !empty($user_id) ? intval($order_id) : 0;
            $country        = get_post_meta( $seller_id, 'country', true );
            $list['country']= !empty($country) ? $country : '';
            if( !empty($order_id) ){
                $package_details					= array();
                $package_id							= get_post_meta($order_id, 'package_id', true);
                $product_instant					= !empty($package_id)	? get_post( $package_id ) : '';
                $package_details['title']			= !empty($product_instant) ? sanitize_text_field($product_instant->post_title) : '';
                $package_details['content']			= !empty($product_instant) ? sanitize_text_field($product_instant->post_content) : '';
                $package_details['image']			= !empty($package_id) ? get_the_post_thumbnail_url( $package_id, array(315,300) ) : '';
                $list['package']				    = $package_details;                
            }

            $list['first_name']		= !empty($tb_post_meta['first_name']) ? $tb_post_meta['first_name'] : '';
            $list['last_name']		= !empty($tb_post_meta['last_name']) ? $tb_post_meta['last_name'] : '';
            $list['total_order']    = !empty($total_order) ? intval($total_order) : 0;
            $list['seller_type']	= isset($seller_type[0]->term_id) ? $seller_type[0]->term_id : '';
            $list['english_level']	= isset($english_level[0]->term_id) ? $english_level[0]->term_id : '';
        }
        
        $list['seller_name']    = taskbot_get_username($seller_id); 
        $list['user_rating']    = !empty($user_rating) ? $user_rating : 0;
        $list['is_verified']    = !empty($is_verified) ? $is_verified : '';
        $list['review_users']   = !empty($review_users) ? intval($review_users) : 0;
        $list['tagline']        = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
        
        $list['hourly_rate']    = !empty($tb_hourly_rate) ? taskbot_price_format($tb_hourly_rate,'return') : 0;
        $list['hourlyprice']    = !empty($tb_hourly_rate) ? $tb_hourly_rate : 0;
        $list['profile_views']  = !empty($profile_views) ? intval($profile_views) : 0;
        $list['address']        = !empty($address) ? esc_html($address) : '';
        $list['success_rate']   = !empty($success_rate) ? esc_html($success_rate) : '';
        $list['status']         = $is_online;
        $list['avatar']         = esc_url($avatar);
        $list['education']      = $eduction_array;
        $list['profile_id']     = $seller_id;
        $list['user_id']        = $user_id;
        $list['user_link']      = get_the_permalink($seller_id);

        $list['identity_verified']    = !empty($identity_verified) ? $identity_verified : '';
        return $list;
    }
 }

/**
 * Get buyer details
 *
 */
 if( !function_exists('taskbot_buyer_details') ){
    function taskbot_buyer_details( $buyer_id=0, $user_id=0 ){
        $list                   = array();
        $avatar                 = apply_filters('taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 315, 'height' => 300), $buyer_id),array('width' => 315, 'height' => 300));
        $is_online	            = apply_filters('taskbot_is_user_online',$user_id);
        $tb_post_meta           = get_post_meta($buyer_id, 'tb_post_meta', true);
        $is_verified            = get_post_meta( $buyer_id, '_is_verified', true );
        $identity_verified  	= get_user_meta($user_id, 'identity_verified', true);
        
        $list['seller_name']    = taskbot_get_username($seller_id); 
        $list['is_verified']    = !empty($is_verified) ? $is_verified : '';
        $list['tagline']        = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
        $list['address']        = !empty($address) ? esc_html($address) : '';
        $list['status']         = $is_online;
        $list['avatar']         = esc_url($avatar);
        $list['profile_id']     = $buyer_id;
        $list['user_id']        = $user_id;
        
        $list['identity_verified']    = !empty($identity_verified) ? $identity_verified : '';
        return $list;
    }
    add_filter( 'taskbot_buyer_details', 'taskbot_buyer_details',10,2 );
 }

/**
 * Get task details
 *
 */
 if( !function_exists('taskbot_task_details') ){
     function taskbot_task_details($post_id,$request=array()){
        $list                   = array();
        $user_id                = get_post_field( 'post_author', $post_id );
        $seller_id              = !empty($user_id) ? taskbot_get_linked_profile_id($user_id, '','sellers') : 0;
        $avatar                 = apply_filters('taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 315, 'height' => 300), $seller_id),array('width' => 315, 'height' => 300));
        $user_rating            = get_post_meta( $seller_id, 'tb_total_rating', true );
        $review_users           = get_post_meta( $seller_id, 'tb_review_users', true );
        $is_online	            = apply_filters('taskbot_is_user_online',$user_id);
        $list['task_link']      = get_the_permalink($post_id);
        $list['seller_name']    = taskbot_get_username($seller_id);
        $list['user_rating']    = !empty($user_rating) ? $user_rating : 0;
        $list['review_users']   = !empty($review_users) ? intval($review_users) : 0;
        $list['status']         = $is_online;
        $list['avatar']         = esc_url($avatar);
        $list['profile_id']     = $seller_id;
        $list['user_id']        = $user_id;

        $product 		                = wc_get_product( $post_id );
        $taskbot_service_views          = get_post_meta( $post_id, 'taskbot_service_views', TRUE );

		if(function_exists('taskbot_api_task_item_status')){
			$list['post_status'] 	= taskbot_api_task_item_status( $post_id );
		}

        $meta_array = array(
            array(
                'key'       => 'task_product_id',
                'value'     => $post_id,
                'compare'   => '=',
                'type'      => 'NUMERIC'
            )
        );

        $product_sales             = taskbot_get_post_count_by_meta('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed'), $meta_array);
        $attachment_ids     = $product->get_gallery_image_ids();
        $product_video      = get_post_meta($product->get_id(), '_product_video', true);
        $featured           = $product->get_featured();
        $featured_image_id  = $product->get_image_id();
        $taskbot_total_price = $product->get_price();
        $gallery_images     = array();
        if (!empty($attachment_ids)) {
            foreach ($attachment_ids as $attachment_id) {
                $full_thumb_url = wp_get_attachment_image_src($attachment_id, 'full', true);
                $full_thumb_url = !empty($full_thumb_url[0]) ? $full_thumb_url[0] : '';
                if( !empty($full_thumb_url) ){
                    $gallery_images[]   = $full_thumb_url;
                }
            }
        }
        $categories 			= wp_get_post_terms( $post_id, 'product_cat');
        $categories_array       = $product_cat = array();
        if( !empty($categories) ){
            foreach($categories as $term){
                $categories_array[$term->slug]   = $term->name;
                $product_cat[]                   = $term->term_id;
            }
        }

        $tags 			= wp_get_post_terms( $post_id, 'product_tag');
        $tags_array     = $tags_arr = array();
        if( !empty($tags) ){
            foreach($tags as $tag){
                $tags_array[$tag->slug]   = $tag->name;
				$tags_arr[]   = array(
					'id' 		=>	$tag->term_id,
					'name' 		=>	$tag->name,
					'slug' 		=> $tag->slug
				);
            }
        }

        $plan_array	= array(
            'product_tabs' 			=> array('plan'),
            'product_plans_category'=> $product_cat
        );
        $acf_fields		        = taskbot_acf_groups($plan_array);
        $taskbot_plans_values 	= get_post_meta($post_id, 'taskbot_product_plans', TRUE);
        $taskbot_plans_values	= !empty($taskbot_plans_values) ? $taskbot_plans_values : array();
        $tb_custom_fields       = get_post_meta( $post_id, 'tb_custom_fields',true );
        $tb_custom_fields       = !empty($tb_custom_fields) ? $tb_custom_fields : array();
        $taskbot_subtask 		= get_post_meta($post_id, 'taskbot_product_subtasks', TRUE);
        $faqs_data              = get_post_meta($post_id, 'taskbot_service_faqs', true);

        $faqs                   = array();
        if( !empty($faqs_data) ){
            foreach($faqs_data as $faq_data){
                $faqs[] = $faq_data;
            }
        }
        $sub_tasks              = array();
        if(!empty($taskbot_subtask)){
            foreach($taskbot_subtask as $taskbot_subtask_id){
                $sub_task           = array();
                $price              = get_post_meta( $taskbot_subtask_id, '_regular_price', true);
                $sub_task['price']  = taskbot_price_format($price,'return');
                $sub_task['title']  = get_the_title( $taskbot_subtask_id );
                $sub_task['ID']     = $taskbot_subtask_id;
                $sub_task['content']= apply_filters( 'the_content', get_the_content(null, false, $taskbot_subtask_id)); 
                $sub_task['reg_price']  = $price;
                $sub_tasks[]            = $sub_task;
            }
        }

        $attributes             = array();
        if( !empty($taskbot_plans_values) ){
            foreach ($taskbot_plans_values as $key => $plans_value) {
                $taskbot_icon_key	            = 'task_plan_icon_'.$key;
                $plan_array                     = array();
                $plan_array['key']              = $key;
                $plan_array['title']            = !empty($plans_value['title']) ? $plans_value['title'] : '';
                $plan_array['description']      = !empty($plans_value['description']) ? $plans_value['description'] : '';
                $plan_array['featured_package'] = !empty($plans_value['featured_package']) ? $plans_value['featured_package'] : '';
                $plan_array['price']            = !empty($plans_value['price']) ? taskbot_price_format($plans_value['price'],'return') : 0;
                $plan_array['reg_price']        = !empty($plans_value['price']) ? $plans_value['price'] : 0;
                $delivery_time                  = !empty($plans_value['delivery_time']) ? $plans_value['delivery_time'] : '';
				$plan_array['delivery_time_id']	= !empty($delivery_time) ? intval($delivery_time) : '';
                $plan_array['delivery_title']   = !empty($delivery_time) ? get_term_by('id', $delivery_time, 'delivery_time')->name : '';
                $delivery_time_option           = 'delivery_time_' . $delivery_time;
                $days                           = 0;
                if (function_exists('get_field')) {
                    $days = get_field('days', $delivery_time_option);
                } 
                $plan_array['delivery_time']    = $days;
                $plan_array['task_plan_icon']   = !empty($taskbot_settings[$taskbot_icon_key]['url']) ? $taskbot_settings[$taskbot_icon_key]['url'] : '';
                
                $plan_fields                    = array();
                if( !empty($acf_fields) ){
                    foreach ($acf_fields as $acf_field) {
                        $plan_field                 = array();
                        $plan_value                 = !empty($acf_field['key']) && !empty($plans_value[$acf_field['key']]) ? $plans_value[$acf_field['key']] : '--';
                        $plan_field                 = $acf_field;
                        $plan_field['plan_value']   = $plan_value; 
                        $plan_fields[]  = $plan_field;
                    }
                }
                $plan_array['fields']           = $plan_fields;
                $attributes[]                   = $plan_array;
            }
        }
        $comment_page	        = !empty($request['comment_page']) ? intval($request['comment_page']) : 1;
        $per_page		        = 10;
        $offset 		        = ($comment_page * $per_page) - $per_page;
        $comment_args 			= array ( 'post_id' => $post_id,'offset'=> $offset,'number'=> $per_page);
        $comments 		        = get_comments( $comment_args );
        $task_commnets          = array();
        if( !empty($comments) ){
            $total_comments	= get_comments(array('post_id' => $post_id));
            $total_comments	= !empty($total_comments) ? count($total_comments) : 0;
            
            $commnets_pages                     = ceil($total_comments/$per_page);
            $task_commnets['totals_comments']   = !empty($total_comments) ? intval($total_comments) : 0;
            foreach($comments as $comment){
                $comment_array  = array();
                $buyer_id       = !empty($comment->user_id) ? intval($comment->user_id) : 0;
                $buyer_id       = !empty($buyer_id) ? intval($buyer_id) : 0;
                $link_id        = taskbot_get_linked_profile_id( $buyer_id,'','buyers' );
                $buyer_img      = apply_filters('taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 315, 'height' => 300), $link_id),array('width' => 315, 'height' => 300));
                
                $user_name      = !empty($link_id) ? taskbot_get_username($link_id) : '';
                $rating         = !empty($comment->comment_ID) ? get_comment_meta($comment->comment_ID, 'rating', true) : 0;
                $title         	= !empty($comment->comment_ID) ? get_comment_meta($comment->comment_ID, '_rating_title', true) : '';
                
                $comment_array['buyer_id']      = intval($buyer_id);
                $comment_array['buyer_img']     = esc_url($buyer_img);
                $comment_array['buyer_name']    = esc_html($user_name);
                $comment_array['content']       = esc_html($comment->comment_content);
                $comment_array['rating']        = esc_html($rating);
                $comment_array['title']         = esc_html($title);
                $comment_array['comment_date']  = sprintf( esc_html__( '%s ago', 'taskbot' ), human_time_diff(strtotime($comment->comment_date)) );;
                $task_commnets['list'][]        = $comment_array;
            }
        }

		/* attachments gallery */
		$gallery_attachments 	= get_post_meta($post_id, '_product_attachments', true);
		$list['galleries'] 		= !empty($gallery_attachments) ? $gallery_attachments : array();

		/* video */
		$video_attachment = get_post_meta($post_id, '_product_video', true);
		$list['videos'] = !empty($video_attachment) ? $video_attachment : array();

		/* is download allow */
		$download_allow = get_post_meta($post_id, '_downloadable', true);
		$list['download_allow']  = $download_allow;

		/* downloadable */
		$download_attachments = get_post_meta($post_id, '_downloadable_files', true);
		$list['downloads'] = !empty($download_attachments) ? $download_attachments : array();

		$country 						= get_post_meta($post_id, '_country', true);
		$zipcode 						= get_post_meta($post_id, 'zipcode', true);

		$list['is_featured']			= !empty($featured) ? $featured : false;
		$list['country']				= !empty($country) ? $country : '';
		$list['zipcode']				= !empty($zipcode) ? $zipcode : '';

        $list['faqs']                   = !empty($faqs) ? $faqs : array();
        $list['total_price_format']     = isset($taskbot_total_price) ? taskbot_price_format($taskbot_total_price,'return') : 0;
        $list['total_price']            = isset($taskbot_total_price) ? $taskbot_total_price : 0;

        $list['task_commnets']  = $task_commnets;
        $list['custom_fields']  = $tb_custom_fields;
        $list['task_id']        = $post_id;
        $list['sub_tasks']      = $sub_tasks;
        $list['attributes']     = $attributes;
        $list['task_name']      = $product->get_name();
        $list['average_rating'] = $product->get_average_rating();
        $list['rating_count']   = $product->get_rating_count();
        $list['task_content']   = $product->get_description();
        $list['task_status']   	= $product->get_status();

		/* task status */
		$task_status = false;
		if($product->get_status() == 'publish'){
			$task_status = true;
		}
		$list['task_status'] = $task_status;

        $list['product_sales']   = !empty($product_sales) ? intval($product_sales) : 0;
        $list['service_views']  = !empty($taskbot_service_views) ? intval($taskbot_service_views) : 0;
        $list['featured_image'] = !empty($featured_image_id) ? wp_get_attachment_url( $featured_image_id ) : '';
        $list['task_video']     = !empty($product_video) ? $product_video : '';
        $list['gallery']        = $gallery_images;
        $list['categories']     = $categories_array;
        $list['category_arr'] 	= $categories;
        $list['tags']           = $tags_array;
        $list['tags_arr']		= $tags_arr;
        $list['featured']       = $product->get_featured();
        return $list;
     }
 }

/**
 * Switch user
 *
*/
if( !function_exists('taskbotSwitchUser') ){
    function taskbotSwitchUser($user_id='',$option_type=''){
        global $taskbot_settings;
        if( !empty($user_id)){
            $user_type		        = apply_filters('taskbot_get_user_type', $user_id );
            $profie_id              = taskbot_get_linked_profile_id($user_id,'',$user_type);
            
            $new_type               = '';
            $linked_profile_id      = '';
            
            if( !empty($user_type) && $user_type == 'sellers' ){
                $new_type           = 'buyers';
                $linked_profile_id  = get_user_meta( $user_id, '_linked_profile_buyer', true );
                update_user_meta($user_id,'_user_type','buyers');
            } else {
                $new_type           = 'sellers';
                $linked_profile_id  = get_user_meta( $user_id, '_linked_profile', true );
                update_user_meta($user_id,'_user_type','sellers');
            }

            if( empty($linked_profile_id) ){
                $first_name = get_user_meta( $user_id, 'first_name', true );
                $last_name  = get_user_meta( $user_id, 'last_name', true );
                $first_name = !empty($first_name) ? $first_name : '';
                $last_name  = !empty($last_name) ? $last_name : '';
                $full_name  = $first_name.' '.$last_name;
				$full_name	= empty($full_name) ? $nickname : $full_name;
				
                $user_post  = array(
                    'post_title'    => wp_strip_all_tags( $full_name ),
                    'post_status'   => 'publish',
                    'post_author'   => $user_id,
                    'post_type'     => $new_type,
                );

                $post_id        = wp_insert_post( $user_post );
                $dir_latitude 	= !empty( $taskbot_settings['dir_latitude'] ) ? $taskbot_settings['dir_latitude'] : 0.0;
                $dir_longitude 	= !empty( $taskbot_settings['dir_longitude'] ) ? $taskbot_settings['dir_longitude'] : 0.0;
                //add extra fields as a null
                update_post_meta($post_id, '_address', '');
                update_post_meta($post_id, '_latitude', $dir_latitude);
                update_post_meta($post_id, '_longitude', $dir_longitude);
                update_post_meta($post_id, '_linked_profile', $user_id);
                update_post_meta($post_id, 'zipcode', '');
                update_post_meta($post_id, 'country', '');

                $is_verified  = get_user_meta($user_id, '_is_verified', true);
                $is_verified  = !empty($is_verified) ? $is_verified : '';

                if (!empty($is_verified) && $is_verified == 'yes' ){
                    update_post_meta($post_id, '_is_verified', 'yes');
                } else {
                    update_post_meta($post_id, '_is_verified', 'no');
                }

                if( !empty($new_type) && $new_type == 'sellers' ){
                    update_user_meta( $user_id, '_linked_profile', $post_id );
                    update_post_meta($post_id, 'tb_hourly_rate', '');
                } else {
                    update_user_meta( $user_id, '_linked_profile_buyer', $post_id );
                }

                $tb_post_meta               = array();
                $tb_post_meta['first_name'] = $first_name;
                $tb_post_meta['last_name']  = $last_name;
                update_post_meta($post_id,'tb_post_meta', $tb_post_meta);

            }

            $json['type']           = 'success';
            $json['message']        = esc_html__('Switch user', 'taskbot');
            $json['message_desc']   = esc_html__('You have successfully switch the user.', 'taskbot');
			
            if( !empty($option_type) && $option_type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }
    }
}

/**
 * Registration
 *
*/
if( !function_exists('taskbotRegistration') ){
    function taskbotRegistration($output=array(),$option_type=''){
        global $taskbot_settings;
        $user_name_option   = !empty($taskbot_settings['user_name_option']) ? $taskbot_settings['user_name_option'] : false;
		$shortname_option  =  !empty($taskbot_settings['shortname_option']) ? $taskbot_settings['shortname_option'] : '';
		
		if(!empty($_POST['redirect'] )){
            $redirect                       = !empty( $_POST['redirect'] ) ? esc_url( $_POST['redirect'] ) : '';
        }else{
            $redirect                       = !empty( $output['redirect'] ) ? esc_url( $output['redirect'] ) : '';
        }

        //Validation
        $validations = apply_filters('taskbot_filter_registration_validations',array(
            'first_name'              => esc_html__('First name is required', 'taskbot'),
            'last_name'               => esc_html__('Last name is required', 'taskbot'),
            'user_email'              => esc_html__('Email is required', 'taskbot'),
            'user_password'           => esc_html__('Password is required', 'taskbot'),
            'user_agree_terms'        => esc_html__('You should agree to terms and conditions.', 'taskbot'),
        ));

        if( !empty($user_name_option) ){
            $validations['user_name']   = esc_html__('User name is required', 'taskbot');
        }

        foreach ($validations as $key => $value) {

            if (empty($output['user_registration'][$key])) {
                $json['type']         = 'error';
                $json['message_desc']  = $value;
                if( !empty($option_type) && $option_type === 'mobile' ){
                    $json['message']   = $json['message_desc'];
                    return $json;
                } else {
                    wp_send_json($json);
                }
            }

            //Validate email address
            if ($key === 'user_email') {
                if (!is_email($output['user_registration']['user_email'])) {
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__('Please add a valid email address.', 'taskbot');
                   if( !empty($option_type) && $option_type === 'mobile' ){
                        $json['message']   = $json['message_desc'];
                        return $json;
                    } else {
                        wp_send_json($json);
                    }
                }

                $user_exists = email_exists($output['user_registration']['user_email']);
                if ($user_exists) {
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__('This email already registered', 'taskbot');
                   if( !empty($option_type) && $option_type === 'mobile' ){
                        $json['message']   = $json['message_desc'];
                        return $json;
                    } else {
                        wp_send_json($json);
                    }
                }
            }

            //Password
            if ($key === 'user_password') {
                if (strlen($output['user_registration'][$key]) < 6) {
                    $json['type']           = 'error';
                    $json['message_desc']   = esc_html__('Password length should be minimum 6', 'taskbot');
                    if( !empty($option_type) && $option_type === 'mobile' ){
                        $json['message']   = $json['message_desc'];
                        return $json;
                    } else {
                        wp_send_json($json);
                    }
                }
            }
        }


        //Get user data from session
        $first_name         = !empty($output['user_registration']['first_name']) ? sanitize_text_field($output['user_registration']['first_name']) : '';
        $last_name          = !empty($output['user_registration']['last_name']) ? sanitize_text_field($output['user_registration']['last_name']) : '';
        $email              = !empty($output['user_registration']['user_email']) ? is_email($output['user_registration']['user_email']) : '';
        $password           = !empty($output['user_registration']['user_password']) ? ($output['user_registration']['user_password']) : '';
        $user_type          = !empty($output['user_registration']['user_type']) ? sanitize_text_field($output['user_registration']['user_type']) : 'buyers';
        $user_agree_terms   = !empty($output['user_registration']['user_agree_terms']) ? esc_html($output['user_registration']['user_agree_terms']) : '';
        $user_name          = !empty($output['user_registration']['user_name']) ? sanitize_text_field($output['user_registration']['user_name']) : '';
		
		
        //Session data validation
        if (empty($first_name)
        || empty($last_name)
        || empty($email)
        || empty($user_type)
        ) {
            $json['type']           = 'error';
            $json['message_desc']    = esc_html__('All the fields are required added in first step', 'taskbot');
            if( !empty($option_type) && $option_type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }

        $user_name  = !empty($user_name_option) ? $user_name : $email;
        //User Registration
        $random_password  = $password;
        $full_name        = $first_name . ' ' . $last_name;
        $user_nicename    = sanitize_title($full_name);

        $userdata = array(
            'user_login'    => $user_name,
            'user_pass'     => $random_password,
            'user_email'    => $email,
            'user_nicename' => $user_nicename,
            'display_name'  => $full_name,
        );

        $user_identity = wp_insert_user($userdata);

        if (is_wp_error($user_identity)) {
            $json['type']           = "error";
            $json['message_desc']   = esc_html__("User already exists. Please try another one.", 'taskbot');

            if( !empty($option_type) && $option_type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }

        } else {
            global $wpdb;
            wp_update_user(array('ID' => esc_sql($user_identity), 'role' => 'subscriber', 'user_status' => 0));

            $wpdb->update(
                $wpdb->prefix . 'users', array('user_status' => 0), array('ID' => esc_sql($user_identity))
            );

			//child theme compatibility
			do_action('taskbot_registration_child_data',$output);

            //User Login
            $user_array                   = array();
            $user_array['user_login']     = $email;
            $user_array['user_password']  = $random_password;
            $status = wp_signon($user_array, false);

			$verify_new_user    = !empty($taskbot_settings['verify_new_user']) ? $taskbot_settings['verify_new_user'] : 'verify_by_link';
			
            if (!empty($verify_new_user) && $verify_new_user == 'verify_by_admin') {
                $json_message = esc_html__("Your account have been created. Please wait while your account is verified by the admin.", 'taskbot');
            } else {
                $json_message = esc_html__("Your account have been created. Please verify your account, an email have been sent your email address.", 'taskbot');
            }

			if (!empty( $redirect )) {
            	$dashboard            = $redirect;
			}else{
				$dashboard            = taskbot_auth_redirect_page_uri('login',$user_identity);
			}

            $json['type']         = 'success';
            $json['message']      = $json_message;
            $json['redirect']   	= wp_specialchars_decode($dashboard);
            
            if( !empty($option_type) && $option_type === 'mobile' ){
                $json['message_desc']   = $json_message;
                $json['user_id']        = !empty($user_identity) ? intval($user_identity) : 0;
                
                return $json;
            } else {
                wp_send_json($json);
            }
        }
    }
}
/**
 * Forget password
 *
*/
if( !function_exists('taskbotForgetPassword') ){
    function taskbotForgetPassword($user_email='',$option_type=''){
        global $taskbot_settings;
        if (empty($user_email)) {
            $json['type']           = "error";
            $json['loggedin']       = false;
            $json['message']        = esc_html__("Email address should not be empty or invalid.", 'taskbot');
            if( !empty($option_type) && $option_type === 'mobile' ){
                return $json;
            } else {
                wp_send_json($json);
            }
        }  else {
            $user_data = get_user_by('email', $user_email);

            if (empty($user_data) ) {
                    $json['type']           = "error";
                    $json['message']        = esc_html__("Oops", 'taskbot');
                    $json['message_desc']   = esc_html__("The email address does not exist", 'taskbot');
                    if( !empty($option_type) && $option_type === 'mobile' ){
                    $json['message']   = $json['message_desc'];
                    return $json;
                } else {
                    wp_send_json($json);
                }
            }
        
            $user_id          = $user_data->ID;
            $user_login       = $user_data->user_login;
            $user_email       = $user_data->user_email;
            $user_profile_id  = taskbot_get_linked_profile_id($user_id);
            $username 		  = taskbot_get_username($user_profile_id);
            $username         = !empty($username) ? $username : $user_data->display_name;
            
            //generate reset key
            $key  = wp_generate_password(20, false);
            wp_update_user( array( 'ID' => $user_id, 'user_activation_key' => $key ) );

            $forgot_page_url  	= !empty( $taskbot_settings['tpl_forgot_password'] ) ? get_permalink($taskbot_settings['tpl_forgot_password']) : '';
            $view_type  		= !empty($taskbot_settings['registration_view_type']) ? $taskbot_settings['registration_view_type'] : 'pages';
			if( !empty($view_type) && $view_type === 'popup' ){
				$forgot_page_url	= get_home_url();
			}
			$reset_link       	= esc_url(add_query_arg(array('action' => 'reset_pwd', 'key' => $key, 'login' => $user_email), $forgot_page_url));

            //Send email to user
            if (class_exists('Taskbot_Email_helper')) {

                $blogname                 = get_option('blogname');
                $emailData                = array();
                $emailData['name']        = $username;
                $emailData['email']       = $user_email;
                $emailData['reset_link']  = $reset_link;

                // Reset password email
                if (class_exists('TaskbotRegistrationStatuses')) {
                    $email_helper = new TaskbotRegistrationStatuses();
                    $email_helper->user_reset_password($emailData);
                }
            }

            $json['type']           = "success";
            $json['message']        = esc_html__("Woohoo!", 'taskbot');
            $json['message_desc']   = esc_html__("Reset password link has been sent, please check your email.", 'taskbot');
            if( !empty($option_type) && $option_type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }

        }
    }
}

/**
 * Update saved items
 *
*/
if( !function_exists('taskbotUpdateSavedItems') ){
    function taskbotUpdateSavedItems($user_id=0,$request=array(),$option_type=''){
        $user_type= apply_filters('taskbot_get_user_type', $user_id );
        $type     = !empty($request['type']) ? sanitize_text_field($request['type']) : '';
        $action   = !empty($request['option']) ? sanitize_text_field($request['option']) : '';
        $saved_id = !empty($request['post_id']) ? intval($request['post_id']) : 0;

        if( !empty($type) && $type == 'tasks'){
            $key    = '_saved_tasks';
        } else if(!empty($type) && $type == 'sellers'){
            $key    = '_saved_sellers';
        }else if(!empty($type) && $type == 'projects'){
            $key    = '_saved_projects';
        }

        
        $post_id         = taskbot_get_linked_profile_id($user_id,'',$user_type);
        $saved_items     = get_post_meta($post_id, $key, true);
        $saved_items     = !empty( $saved_items ) && is_array( $saved_items ) ? $saved_items : array();

        if (!empty($saved_id)) {

            if( !empty($action) && $action == 'saved' ){
                $saved_items[]  = $saved_id;
                $saved_items    = array_unique( $saved_items );
                $json_message   = esc_html__('Item saved', 'taskbot');
                $message_desc   = esc_html__('Successfully! added to your saved list', 'taskbot');
            } else {

                if (($key_change = array_search($saved_id, $saved_items)) !== false) {
                    unset($saved_items[$key_change]);
                }
            $json_message = esc_html__('Item removed', 'taskbot');
            $message_desc = esc_html__('Successfully! removed from your saved list', 'taskbot');
            }

            update_post_meta( $post_id, $key, $saved_items );
            $json['type'] 		    = 'success';
            $json['text'] 		    = esc_html__('Saved', 'taskbot');
            $json['message']      = $json_message;
            $json['message_desc'] = $message_desc;
            if( !empty($option_type) && $option_type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }
    }
}

/**
 * Taskbot fund request
 *
*/
if( !function_exists('taskbotWithdraqRequest') ){
    function taskbotWithdraqRequest($user_id=0,$request=array(),$type=''){
		global $taskbot_settings;
        $json['message']    = esc_html__('Withdraw Money','taskbot');
		
        // get the info from requested form
        $payment_method     = !empty($request['withdraw']['gateway']) ? esc_html($request['withdraw']['gateway']) : '';
        $requested_amount   = !empty($request['withdraw']['amount']) ? floatval($request['withdraw']['amount']) : 0;
        $user_id            = !empty($user_id) ? intval($user_id) : '';
        $linked_profile_id  = taskbot_get_linked_profile_id($user_id,'sellers');
        $linked_profile_id  = !empty($linked_profile_id) ? $linked_profile_id : $user_id;
        $min_withdraw       = !empty($taskbot_settings['min_amount']) ? $taskbot_settings['min_amount'] : 0;

        // verify requested amount is selected
        if ( empty($requested_amount) ) {
            $json['message']        = esc_html__('Hold right there!','taskbot');
            $json['type']           = 'error';

            $json['message_desc']   = sprintf(esc_html__("Minimum amount should be greater than %s to withdraw", 'taskbot'),$min_withdraw);
            if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                wp_send_json($json);
            } else {
                wp_send_json($json);
            }
        }

        if( !empty($min_withdraw) && $requested_amount < $min_withdraw ){
            $json['message']        = esc_html__('Hold right there!','taskbot');
            $json['type']           = 'error';
            $json['message_desc']   = sprintf(esc_html__("Minimum amount should be greater than %s to withdraw", 'taskbot'),$min_withdraw);
            if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                wp_send_json($json);
            } else {
                wp_send_json($json);
            }
        }

        // get available amount to verify requested amount
        // get amount which is available to be withdraw
        $current_balance    = taskbot_account_details($user_id,array('wc-completed'),'completed');
        $current_balance    = !empty($current_balance) ? $current_balance : 0;

        // get amount which is already withdrawn or withdraw requested
        $withdrawn_amount   = taskbot_account_withdraw_details($user_id,array('pending','publish'));
        $withdrawn_amount   = !empty($withdrawn_amount) ? $withdrawn_amount : 0;
        $account_balance    = $current_balance - $withdrawn_amount;
		$account_balance 	= number_format( $account_balance, 2); 

        // verify amount before further process
        if ( $requested_amount > $account_balance) {
            $json['type']         = 'error';
            $json['message_desc'] = esc_html__("We are sorry, you haven't enough amount to withdraw", 'taskbot');
             if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }

        // verify minimum amount
        if ( $requested_amount <= 0) {
            $json['type']         = 'error';
            $json['message_desc'] = esc_html__("We are sorry, you must select greater amount to process", 'taskbot');
             if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }

        // get user's selected payment method details
        $contents	= get_user_meta($user_id,'taskbot_payout_method',true);

        // get user's specific selected payment method details
        // if selected method is payoneer
        if( !empty($payment_method) && $payment_method === 'payoneer' ){

            if( !empty($contents) && array_key_exists($payment_method, $contents) ){
                $email		= !empty($contents['payoneer']['payoneer_email']) ? $contents['payoneer']['payoneer_email'] : "";
            }

            $insert_payouts		= serialize( array('payoneer_email' => $email) );
            //check if email is valid
            if( empty( $email ) ){
                $json['type'] 	      = "error";
                $json['message_desc'] = esc_html__("Please update the payout settings for the selected payment gateway in payout settings", 'taskbot');
                if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
            }
        } elseif ( !empty($payment_method) && $payment_method === 'paypal' ){
            if( !empty($contents) && array_key_exists($payment_method, $contents) ){
                $email		= !empty($contents['paypal']['paypal_email']) ? $contents['paypal']['paypal_email'] : "";
            }
            $insert_payouts		= serialize( array('paypal_email' => $email) );
            //check if email is valid
            if( empty( $email ) ){
                $json['type'] 	      = "error";
                $json['message_desc'] = esc_html__("Please update the payout settings for the selected payment gateway in payout settings", 'taskbot');
                if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
            }
        } elseif( !empty($payment_method) && $payment_method === 'bank' ){
            // if selected method is bank
            if( !empty($contents) && array_key_exists($payment_method, $contents) ){

                if( empty( $contents['bank']['bank_account_title'] ) || empty( $contents['bank']['bank_account_number'] ) || empty( $contents['bank']['bank_account_name'] ) || empty( $contents['bank']['bank_routing_number'] ) || empty( $contents['bank']['bank_iban'] ) ){
                    $json['type'] 	 = "error";
                    $json['message'] = esc_html__("One or more required fields are missing please update the payout settings for the selected payment gateway in payout settings", 'taskbot');
                    if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
                }

                $bank_details	= array();
                $bank_details['bank_account_title']		= $contents['bank']['bank_account_title'];
                $bank_details['bank_account_number']	= $contents['bank']['bank_account_number'];
                $bank_details['bank_account_name']		= $contents['bank']['bank_account_name'];
                $bank_details['bank_routing_number']	= $contents['bank']['bank_routing_number'];
                $bank_details['bank_iban']	          = $contents['bank']['bank_iban'];
                $bank_details['bank_bic_swift']	      = !empty($contents['bank']['bank_bic_swift']) ? $contents['bank']['bank_bic_swift'] : "";

                $bank_details                         = apply_filters('payout_bank_transfer_filter_details',$bank_details,$contents);
            }

            $insert_payouts		= serialize( $bank_details );
        } else{
            
            $payout_details	= array();
			$fields	= taskbot_get_payouts_lists($payment_method);
			if( !empty($fields[$payment_method]['fields'])) {
				foreach( $fields[$payment_method]['fields'] as $key => $field ){
					if(!empty($contents[$payment_method][$key])){
                        $payout_details[$key]		= $contents[$payment_method][$key];
                    }
				}
			}
			
			$insert_payouts		= serialize( $payout_details );
            
            //check if email is valid
            if(empty($payout_details)){
                $json['type'] 	 = "error";
                $json['message'] = esc_html__("Please update the payout settings for the selected payment gateway in payout settings", 'taskbot');
                if( !empty($type) && $type === 'mobile' ){
                    return $json;
                } else {
                    wp_send_json($json);
                }
            }
        }

        // prepare data to insert in withdraw post_type
        $unique_key       = taskbot_unique_increment(16);
        $account_details  = !empty($insert_payouts) ? $insert_payouts : array();
        $user_name        = !empty($user_id) ? taskbot_get_username($linked_profile_id) . '-' . $requested_amount : '';
        $withdraw_post    = array(
            'post_title'    => wp_strip_all_tags($user_name),
            'post_status'   => 'pending',
            'post_author'   => $user_id,
            'post_type'     => 'withdraw',
        );

        // record withdrawal request into withdraw post_type
        $withdrawal_post_id    = wp_insert_post($withdraw_post);
        $current_date          = current_time('mysql');
        // update relevant info in medata
        update_post_meta($withdrawal_post_id, '_withdraw_amount', $requested_amount);
        update_post_meta($withdrawal_post_id, '_payment_method', $payment_method);
        update_post_meta($withdrawal_post_id, '_timestamp', strtotime($current_date));
        update_post_meta($withdrawal_post_id, '_year', date('Y',strtotime($current_date)));
        update_post_meta($withdrawal_post_id, '_month', date('m',strtotime($current_date)));
        update_post_meta($withdrawal_post_id, '_account_details', $account_details);
        update_post_meta($withdrawal_post_id, '_unique_key', $unique_key);

        // send withdrawal email notification to admin
        if (class_exists('Taskbot_Email_helper')) {
            if (class_exists('WithDrawStatuses')) {
                $emailData                          = array();
                $post_id							= taskbot_get_linked_profile_id($user_id);
				$user_name                          = taskbot_get_username($post_id);
                $emailData['user_name']             = !empty($user_name) ? $user_name : '';
                $emailData['user_link']             = admin_url( 'post.php?post='.$post_id.'&action=edit');
                $emailData['amount']                = !empty($requested_amount) ? taskbot_price_format($requested_amount,'return') : '';
                $emailData['detail']                = admin_url( 'edit.php?post_type=withdraw&author='.$user_id);
                $email_helper = new WithDrawStatuses();
                $email_helper->withdraw_admin_email_request($emailData);
            }
        }


        do_action('taskbot_money_withdraw_activity', $withdrawal_post_id, $request);

        // everything gone well, lets send success response to actual request
        $json['type'] 	 		= "success";
        $json['message']        = esc_html__('Your withdrawal request has been submitted. We will process your withdrawal request', 'taskbot');
        if( !empty($type) && $type === 'mobile' ){
            return $json;
        } else {
            wp_send_json($json);
        }
     }
}

/**
 * update task dispute comments
 *
*/
if( !function_exists('taskbot_update_dispute_comments') ){
    function taskbot_update_dispute_comments($user_id=0,$request=array(),$type=''){
        global $taskbot_settings;
        $get_user_type	    = apply_filters('taskbot_get_user_type', $user_id );
        $dispute_id         = !empty($request['dispute_id'])?intval($request['dispute_id']):'';
        $parent_comment_id  = !empty($request['parent_comment_id'])?intval($request['parent_comment_id']):0;
        $dispute_comment    = !empty($request['dispute_comment'])?esc_textarea($request['dispute_comment']):'';
        $action_type        = !empty($request['action_type'])?esc_textarea($request['action_type']):'reply';
        $field  = array(
            'comment' 			=> $dispute_comment,
            'comment_parent' 	=> $parent_comment_id,
        );

        $comment_id = taskbot_wp_insert_comment($field, $dispute_id);

        if(empty($comment_id)){
            $json['type']           = 'error';
			$json['message']        = esc_html__('Oops!', 'taskbot');
			$json['message_desc']   = esc_html__('You are not allowed to reply dispute refund request', 'taskbot');
			if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }

        $json['type'] 			= "success";
		$json['message'] 		= esc_html__('Woohoo!', 'taskbot');
        $json['message_desc'] 	= esc_html__("Your reply has been posted", 'taskbot');

      	$seller_id	= get_post_meta( $dispute_id, '_seller_id', true );
        $buyer_id	= get_post_meta( $dispute_id, '_buyer_id', true );

		$dispute_order  = get_post_meta( $dispute_id, '_dispute_order', true );
		$dispute_order  = !empty($dispute_order) ? intval($dispute_order) : 0;
		/* email to seller and buyer on commentig */
		if ($get_user_type == 'buyers'){
			$sender_id          = $buyer_id;
			$receiver_id        = $seller_id;
			$receiver_id        = !empty($receiver_id) ? intval($receiver_id) : 0;
			$receiver_user_type = 'sellers';
		} else if ($get_user_type == 'sellers'){
			$sender_id          = $seller_id;
			$receiver_id        = $buyer_id;
			$receiver_id        = !empty($receiver_id) ? intval($receiver_id) : 0;
			$receiver_user_type = 'buyers';
		} else {
			$sender_id          = $seller_id;
			$receiver_id        = $buyer_id;
			$receiver_id        = !empty($receiver_id) ? intval($receiver_id) : 0;
			$receiver_user_type = 'buyers';
		}
		$receiver_linked_profile_id = taskbot_get_linked_profile_id($receiver_id, '', $receiver_user_type);
		$sender_type 				= $receiver_user_type=='sellers' ? 'buyers' : 'sellers';
		$sender_linked_profile_id 	= taskbot_get_linked_profile_id($sender_id, '', $sender_type);

		/* getting order detail */
		$order_id		= get_post_meta( $dispute_id, '_dispute_order', true );
		$order_id		= !empty($order_id) ? intval($order_id) :0;
		$order 		    = !empty($order_id) ? wc_get_order($order_id) : array();
		$order_price 	= !empty($order) ? $order->get_total() : 0;
		$order_amount 	= !empty($order_price) ? $order_price : 0;

        if($action_type == 'decline' && $get_user_type == 'sellers') {

			$task_id	= get_post_meta( $dispute_id, '_task_id', true );
			
			update_post_meta($order_id, '_fund_type', 'admin');
			
			$buyer      = get_user_by( 'id', $buyer_id );
			$buyer_name = $buyer->display_name;

			$seller         = get_user_by( 'id', $seller_id );
			$seller_name    = $seller->display_name;

			$product    = wc_get_product( $task_id );
			$task_name  = $product->get_title();

			$seller_info  = get_userdata($seller_id);
			$seller_email = $seller_info->user_email;

			$buyer_info  = get_userdata($buyer_id);
			$buyer_email = $buyer_info->user_email;

			$login_url   =  !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
			$task_link   =  get_permalink($task_id);

			

			if (class_exists('Taskbot_Email_helper')) {

				$blogname = get_option( 'blogname' );
				$emailData = array();
				$emailData['seller_name']       = $seller_name;
				$emailData['buyer_name']        = $buyer_name;
				$emailData['task_name']         = $task_name;
				$emailData['seller_email']      = $seller_email;
				$emailData['buyer_email']       = $buyer_email;
				$emailData['task_link']         = $task_link;
				$emailData['order_id'] 	        = $order_id;
				$emailData['order_amount']      = $order_amount;
				$emailData['login_url']         = $login_url;

				if($taskbot_settings['email_refund_declined_buyer'] == true){

					if (class_exists('TaskbotRefundsStatuses')) {
						$email_helper = new TaskbotRefundsStatuses();
						$email_helper->refund_declined_buyer_email($emailData); //refund declined by seller
						do_action('notification_message', $emailData );
					}
				}
			}

			$notifyData								= array();
			$notifyDetails							= array();
			$notifyDetails['task_id']       		= $task_id;
			$notifyDetails['post_link_id']  		= $task_id;
			$notifyDetails['dispute_comment']		= $dispute_comment;
			$notifyDetails['seller_order_amount']  	= $order_amount;

			$notifyDetails['order_id']      = $dispute_order;
			$notifyDetails['dispute_id']    = $dispute_id;
			$notifyDetails['seller_id']     = $sender_linked_profile_id;
			$notifyDetails['buyer_id']    	= $receiver_linked_profile_id;
			$notifyData['receiver_id']		= $receiver_id;
			$notifyData['type']			    = 'refund_decline';
			$notifyData['comment_id']		= $comment_id;
			$notifyData['linked_profile']	= $receiver_linked_profile_id;
			$notifyData['user_type']		= $receiver_user_type;
			$notifyData['post_data']		= $notifyDetails;
			do_action('taskbot_notification_message', $notifyData );
			$post_status    = 'declined';
			$json['message'] = esc_html__("You have been declined the refund request", 'taskbot');

        } elseif($action_type == 'refund' && $get_user_type == 'sellers'){
            $post_status    = 'refunded';

            $send_by  		= !empty($buyer_id) ? intval($buyer_id) : 0;
            $order_total	= get_post_meta( $dispute_order, '_order_total', true );
            $order_total  	= !empty($order_total) ? ($order_total) : 0;

            if ( class_exists('WooCommerce') ) {
                global $woocommerce;
                if( !empty($type) && $type === 'mobile' ){
                    check_prerequisites($user_id);
                }

                $order = wc_get_order($dispute_order);
                $order->set_status('refunded');
                $order->save();

				update_post_meta($dispute_order, '_task_status', 'cancelled');

                $woocommerce->cart->empty_cart();
                $wallet_amount              = $order_total;
                $product_id                 = taskbot_buyer_wallet_create();
                $user_id			        = $send_by;
                $cart_meta                  = array();

                $cart_meta['task_id']     	= $product_id;
                $cart_meta['wallet_id']     = $product_id;
                $cart_meta['product_name']  = get_the_title($product_id);
                $cart_meta['price']         = $wallet_amount;
                $cart_meta['payment_type']  = 'wallet';
                $cart_meta['order_type']    = 'refunded';

                $cart_data = array(
                    'wallet_id' 		=> $product_id,
                    'cart_data'     	=> $cart_meta,
                    'price'				=> $wallet_amount,
                    'payment_type'     	=> 'wallet'
                );

                $woocommerce->cart->empty_cart();
                $cart_item_data = apply_filters('taskbot_update_dispute_comment_cart_data',$cart_data);
                WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
                $new_order_id	= taskbot_place_order($user_id,'wallet',$dispute_id);

				update_post_meta($new_order_id, '_fund_type', 'admin');
				update_post_meta($new_order_id, '_task_dispute_order', $dispute_order);

                update_post_meta($dispute_id, 'dispute_status', 'resolved');
                update_post_meta($dispute_id, 'winning_party', $user_id);
				update_post_meta($dispute_id, 'resolved_by', 'sellers');

                /* getting data for email */
            	if (class_exists('Taskbot_Email_helper')) {
					$task_id	  = get_post_meta( $dispute_id, '_task_id', true );
					$product      = wc_get_product( $task_id );
					$task_name    = $product->get_title();

					$buyer        = get_user_by( 'id', $buyer_id );
					$buyer_name   = $buyer->display_name;
					$buyer_info   = get_userdata($buyer_id);
					$buyer_email  = $buyer_info->user_email;

					$seller       = get_user_by( 'id', $seller_id );
					$seller_name  = $seller->display_name;

					$emailData = array();
					$emailData['buyer_email']       = $buyer_email;
					$emailData['seller_name']       = $seller_name;
					$emailData['buyer_name']        = $buyer_name;
					$emailData['task_name']         = $task_name;
					$emailData['task_link']         = get_permalink($task_id);
					$emailData['order_id']          = $dispute_order;
					$emailData['order_amount']      = $order_total;
					$emailData['login_url']         = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();

					if($taskbot_settings['email_refund_approv_buyer'] == true){
						if (class_exists('TaskbotRefundsStatuses')) {
							$email_helper = new TaskbotRefundsStatuses();
							$email_helper->refund_approved_buyer_email($emailData); 
						}
					}

              	}

            } else {
                $json['type']           = 'error';
				$json['message'] 		= esc_html__('Uh!', 'taskbot');
                $json['message_desc']   = esc_html__('Please install WooCommerce plugin to process this order', 'taskbot');
                if( !empty($type) && $type === 'mobile' ){
                    $json['message']   = $json['message_desc'];
                    return $json;
                } else {
                    wp_send_json($json);
                }
                
            }
			$notifyData								= array();
			$notifyDetails							= array();
			$notifyDetails['task_id']       		= $task_id;
			$notifyDetails['post_link_id']  		= $task_id;
			$notifyDetails['dispute_comment']		= $dispute_comment;
			$notifyDetails['seller_order_amount']  	= $order_amount;

			$notifyDetails['order_id']      = $dispute_order;
			$notifyDetails['dispute_id']    = $dispute_id;
			$notifyDetails['seller_id']     = $sender_linked_profile_id;
			$notifyDetails['buyer_id']    	= $receiver_linked_profile_id;
			$notifyData['receiver_id']		= $receiver_id;
			$notifyData['type']			    = 'refund_approved';
			$notifyData['comment_id']		= $comment_id;
			$notifyData['linked_profile']	= $receiver_linked_profile_id;
			$notifyData['user_type']		= $receiver_user_type;
			$notifyData['post_data']		= $notifyDetails;
			do_action('taskbot_notification_message', $notifyData );
            $json['message_desc'] = esc_html__("You have approved the refund request", 'taskbot');

        } else {
			/* receiver link profile id */
			$receiver_name              = taskbot_get_username($receiver_linked_profile_id);
			$receiver_email 	        = get_userdata( $receiver_id )->user_email;
			$sender_name             	= taskbot_get_username($sender_linked_profile_id);

			$task_id	    = get_post_meta( $dispute_id, '_task_id', true );
			$product      	= wc_get_product( $task_id );
			$task_name    	= $product->get_title();

			$dispute_order  = get_post_meta( $dispute_id, '_dispute_order', true );
			$dispute_order  = !empty($dispute_order) ? intval($dispute_order) : 0;

			$order_total  = get_post_meta( $dispute_order, '_order_total', true );
			$order_total  = !empty($order_total) ? ($order_total) : 0;

			$emailData    					= array();
			$emailData['sender_name']         = $sender_name;
			$emailData['receiver_name']       = $receiver_name;
			$emailData['receiver_email']      = $receiver_email;
			$emailData['task_name']           = $task_name;
			$emailData['task_link']           = get_permalink($task_id);
			$emailData['order_id']            = $dispute_order;
			$emailData['order_amount']        = $order_total;
			$emailData['login_url']           = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
			$emailData['sender_comments']     = $dispute_comment;
			$emailData['notification_type']   = 'noty_order_activity_chat';
			$emailData['sender_id']           = $sender_id; //seller id
			$emailData['receiver_id']         = $receiver_id; //buyer id

			if (class_exists('Taskbot_Email_helper')) {

				if (class_exists('TaskbotRefundsStatuses')) {
					$email_helper = new TaskbotRefundsStatuses();

					if($get_user_type == 'sellers' && $taskbot_settings['email_refund_comment_seller'] == true ){
						$email_helper->refund_buyer_comments_email($emailData);
					} elseif($get_user_type == 'buyers'  && $taskbot_settings['email_refund_comment_buyer'] == true ){
						$email_helper->refund_seller_comments_email($emailData);
					}

				}
			}

			$dispute_status		= get_post_status($dispute_id);
			$post_status        = $dispute_status;
			if( !empty($action_type) && $action_type === 'reply' ){
				$notifyData								= array();
				$notifyDetails							= array();
				$notifyDetails['task_id']       		= $task_id;
				$notifyDetails['post_link_id']  		= $task_id;
				$notifyDetails['dispute_comment']		= $dispute_comment;
				$notifyDetails['seller_order_amount']  	= $order_amount;

				$notifyDetails['order_id']      = $dispute_order;
				$notifyDetails['dispute_id']    = $dispute_id;
				$notifyDetails['sender_id']     = $sender_linked_profile_id;
				$notifyDetails['receiver_id']   = $receiver_linked_profile_id;
				$notifyData['comment_id']		= $comment_id;
				$notifyData['receiver_id']		= $receiver_id;
				$notifyData['type']			    = 'refund_comments';
				$notifyData['linked_profile']	= $receiver_linked_profile_id;
				$notifyData['user_type']		= $receiver_user_type;
				$notifyData['post_data']		= $notifyDetails;
				if( !empty($get_user_type) && $get_user_type === 'administrator'){
					unset($notifyDetails['sender_id']);
					$buye_linked_profile_id 	= taskbot_get_linked_profile_id($buyer_id, '', 'buyers');
					$sellers_linked_profile_id 	= taskbot_get_linked_profile_id($seller_id, '', 'sellers');
					$notifyData['type']			    = 'admin_refund_comments';
					$notifyDetails['receiver_id']   = $buye_linked_profile_id;
					$notifyData['linked_profile']	= $buye_linked_profile_id;
					$notifyData['post_data']		= $notifyDetails;
					do_action('taskbot_notification_message', $notifyData );

					$notifyDetails['receiver_id']   = $sellers_linked_profile_id;
					$notifyData['linked_profile']	= $sellers_linked_profile_id;
					$notifyData['post_data']		= $notifyDetails;
					do_action('taskbot_notification_message', $notifyData );
					$admin_reply_email	= !empty( $taskbot_settings['email_refund_comment_admin'] ) ? $taskbot_settings['email_refund_comment_admin'] : ''; //email seller new refend
            		if(isset($admin_reply_email) && !empty($admin_reply_email )){

						if (class_exists('TaskbotRefundsStatuses')) {
							$email_helper = new TaskbotRefundsStatuses();
							$seller_details	= !empty($seller_id) ? get_userdata( $seller_id ) : array();
							$buyer_details	= !empty($buyer_id) ? get_userdata( $buyer_id ) : 0;
							$emailData    					 = array();
							$emailData['receiver_name']       = taskbot_get_username($buye_linked_profile_id);
							$emailData['receiver_email']      = !empty($buyer_details->user_email) ? $buyer_details->user_email : '';
							$emailData['task_name']           = $task_name;
							$emailData['task_link']           = get_permalink($task_id);
							$emailData['order_id']            = $dispute_order;
							$emailData['order_amount']        = $order_total;
							$emailData['login_url']           = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
							$emailData['sender_comments']     = $dispute_comment;
							$email_helper->refund_admin_comments_email($emailData);
							$emailData['receiver_name']       = taskbot_get_username($sellers_linked_profile_id);
							$emailData['receiver_email']      = !empty($seller_details->user_email) ? $seller_details->user_email : '';
							$email_helper->refund_admin_comments_email($emailData);
						}
					}
				} else {
					do_action('taskbot_notification_message', $notifyData );
				}
				
			}
			$json['message_desc'] = esc_html__("Your reply has been posted", 'taskbot');
        }

        $args   = array(
            'ID'            => $dispute_id,
            'post_status'   => $post_status,
        );
        wp_update_post($args);

        do_action('taskbot_refund_request_activity', $dispute_id);

		$json['message'] = esc_html__('Woohoo!', 'taskbot');

        if( !empty($type) && $type === 'mobile' ){
            $json['message']   = $json['message_desc'];
            return $json;
        } else {
            wp_send_json($json);
        }
        
    }
}

/**
 * update task history comment
 *
 */
if( !function_exists('taskbot_update_comments') ){
    function taskbot_update_comments($user_id=0,$request=array(),$type=''){
    global $taskbot_settings;
    $user_type         = apply_filters('taskbot_get_user_type', $user_id);
    $linked_profile_id = taskbot_get_linked_profile_id($user_id, '', $user_type);
    $user_name         = taskbot_get_username($linked_profile_id);
    $avatar            = apply_filters(
        'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $linked_profile_id), array('width' => 50, 'height' => 50)
    );
    $order_id 	    = !empty( $request['id'] ) ? intval($request['id']) : '';
    $temp_items     = !empty( $request['attachments']) ? ($request['attachments']) : array();
    $content 	    = !empty( $request['activity_detail'] ) ? esc_textarea($request['activity_detail']) : '';
    $message_type   = !empty( $request['message_type'] ) ? esc_html($request['message_type']) : '';

    //Upload files from temp folder to uploads
    $project_files = array();
    if( !empty( $temp_items ) && empty($type) ) {
        foreach ( $temp_items as $key => $file_temp_path ) {
            $project_files[] = taskbot_temp_upload_to_activity_dir($file_temp_path, $order_id,true);
        }
    } elseif( !empty($type) && $type === 'mobile' ) {
        $total_documents 		= !empty($request['document_size']) ? $request['document_size'] : 0;
        if( !empty( $_FILES ) && $total_documents != 0 ){
            require_once( ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once( ABSPATH . 'wp-includes/pluggable.php');
            
            for ($x = 1; $x <= $total_documents; $x++) {
                $document_files 	= $_FILES['documents_'.$x];
                $uploaded_image  	= wp_handle_upload($document_files, array('test_form' => false));
                $project_files[]    = taskbot_temp_upload_to_activity_dir($uploaded_image['url'], $order_id,true);
            }
        }
    }
    $userdata   = !empty($user_id)  ? get_userdata( $user_id ) : array();
    $user_email = !empty($userdata) ? $userdata->user_email : '';
    $time       = current_time('mysql');
    // prepare data array for insertion
    $data = array(
        'comment_post_ID' 		    => $order_id,
        'comment_author' 		    => $user_name,
        'comment_author_email' 	    => $user_email,
        'comment_author_url' 	    => 'http://',
        'comment_content' 		    => $content,
        'comment_type' 			    => 'activity_detail',
        'comment_parent' 		    => 0,
        'user_id' 				    => $user_id,
        'comment_date' 			    => $time,
        'comment_approved' 		    => 1,
    );

    // insert data
    $comment_id = wp_insert_comment(apply_filters('task_activity_data_filter', $data));

    if( !empty( $comment_id ) ) {

       

        // if chat contains attachments then add in meta
        if( !empty( $project_files )) {
            add_comment_meta($comment_id, 'message_files', $project_files);
        }

        // update meta data
        $seller_id  = 0;
        $buyers_id  = 0;
        if (!empty($user_type) && $user_type == 'sellers'){
            update_comment_meta($comment_id, '_message_type', $message_type);
            $buyers_id          = get_post_meta( $order_id, 'buyer_id', true);
            $receiver_id        = !empty($buyers_id) ? intval($buyers_id) : 0;
            $receiver_user_type = 'buyers';
            $sender_linked_profile_id = taskbot_get_linked_profile_id($user_id, '', 'sellers');
        } else if ( !empty($user_type) && $user_type == 'buyers'){
            $seller_id          = get_post_meta( $order_id, 'seller_id', true);
            $receiver_id        = !empty($seller_id) ? intval($seller_id) : 0;
            $receiver_user_type = 'sellers';
            $sender_linked_profile_id = taskbot_get_linked_profile_id($user_id, '', 'buyers');
        } 

        $receiver_linked_profile_id = taskbot_get_linked_profile_id($receiver_id, '', $receiver_user_type);
        $receiver_name              = taskbot_get_username($receiver_linked_profile_id);
        $receiver_email 	        = !empty($receiver_id) ? get_userdata( $receiver_id )->user_email : '';
        $task_id        = get_post_meta( $order_id, 'task_product_id', true);
        $task_id        = !empty($task_id) ? $task_id : 0;
        $task_title     = !empty($task_id) ? get_the_title($task_id) : '';
        $task_link      = !empty($task_id) ? get_permalink( $task_id ) : '';
        $order 		    = wc_get_order($order_id);
        $order_amount   = !empty($order) ? $order->get_total() : '';
        $order_amount   = !empty($order_amount) ? $order_amount : 0;
        $login_url      = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
        $activity_email = !empty($taskbot_settings['activity_email']) ? $taskbot_settings['activity_email'] : false;

        if ($activity_email) {
            /* prepare data and send email */
            $is_email_send = 'no';
            if (class_exists('Taskbot_Email_helper')) {
                if (class_exists('TaskbotTaskActivityNotify')) {
                    $email_helper = new TaskbotOrderStatuses();
                    $emailData    = array();
                    $emailData['sender_name']         = $user_name;
                    $emailData['receiver_name']       = $receiver_name;
                    $emailData['receiver_email']      = $receiver_email;
                    $emailData['task_name']           = $task_title;
                    $emailData['task_link']           = $task_link;
                    $emailData['order_id']            = $order_id;
                    $emailData['order_amount']        = $order_amount;
                    $emailData['login_url']           = $login_url;
                    $emailData['sender_comments']     = $content;
                    $emailData['notification_type']   = 'noty_order_activity_chat';
                    $emailData['sender_id']           = $seller_id; //seller id
                    $emailData['receiver_id']         = $buyers_id; //buyer id

                    // if message sender is buyer then use seller email template or vise versa
                    if (!empty($user_type) && $user_type == 'buyers'){
                        $email_helper->order_activities_seller_email($emailData);
                        $is_email_send = 'yes';
                    }else{
                        $email_helper->order_activities_buyer_email($emailData);
                        $is_email_send = 'yes';
                    }

                    // if message sender is seller and marked message as final delivery
                    if ($user_type == 'sellers' && !empty($message_type) && $message_type == 'final'){
                        // get buyer's order detail page link
                        $activity_page_link	= Taskbot_Profile_Menu::taskbot_profile_menu_link('tasks-orders', $receiver_id, true, 'detail',$order_id);
                        $query_string       = 'activity_id='.$comment_id;
                        // append query string
                        $activity_page_link .= (parse_url($activity_page_link, PHP_URL_QUERY) ? '&' : '?').$query_string;
                        $emailData['buyer_email']   = $receiver_email;
                        $emailData['buyer_name']    = $receiver_name;
                        $emailData['seller_name']   = $user_name;
                        $emailData['activity_link'] = $activity_page_link;
                        $email_helper->order_complete_request_buyer_email($emailData);
                        $is_email_send = 'yes';
                    }
                }
            }

            $notifyData						= array();
            $notifyDetails					= array();
            if ($user_type == 'sellers' && !empty($message_type) && $message_type == 'final'){
                $notifyDetails['task_id']     	= $task_id;
                $notifyDetails['seller_id']   	= $linked_profile_id;
                $notifyDetails['buyer_id']   	= $receiver_linked_profile_id;
                $notifyDetails['order_id']   	= $order_id;
                $notifyDetails['buyer_amount']  = $order_amount;
                $notifyData['receiver_id']		= $receiver_id;
                $notifyData['type']			    = 'buyer_order_request';
                $notifyData['linked_profile']	= $receiver_linked_profile_id;
                $notifyData['user_type']		= 'buyers';
                $notifyData['post_data']		= $notifyDetails;
                do_action('taskbot_notification_message', $notifyData );
            } else {
                $notifyDetails['task_id']     	= $task_id;
                $notifyDetails['sender_id']   	= $sender_linked_profile_id;
                $notifyDetails['receiver_id']   = $receiver_linked_profile_id;
                $notifyDetails['order_id']   	= $order_id;
                $notifyDetails['sender_comments']= $content;
                $notifyData['receiver_id']		= $receiver_id;
                $notifyData['type']			    = 'user_activity';
                $notifyData['linked_profile']	= $receiver_linked_profile_id;
                $notifyData['user_type']		= $receiver_user_type;
                $notifyData['post_data']		= $notifyDetails;
                do_action('taskbot_notification_message', $notifyData );
            }
            /* prepare data and send email end */
        }

        do_action('taskbot_comments_activity', $comment_id);

        // prepare success response
        $json['comment_id']			    = $comment_id;
        $json['user_id']			    = intval( $user_id );
        $json['type'] 				    = 'success';
        $json['message'] 			    = esc_html__('Your message has been sent.', 'taskbot');
        $json['content_message'] 	    = esc_html( wp_strip_all_tags( $content ) );
        $json['user_name'] 			    = $user_name;
        $json['date'] 				    = date_i18n(get_option('date_format'), strtotime($time));
        $json['img'] 				    = $avatar;
        $json['is_email_send'] 		    = $is_email_send;
        if( !empty($type) && $type === 'mobile' ){
            return $json;
        } else {
            wp_send_json($json);
        }
        
    }
    }
}

/**
 * create dispute for seller
 *
 */
if( !function_exists('taskbotSellerCreateDispute') ){
    function taskbotSellerCreateDispute($user_id=0,$request=array(),$type=''){
        global $taskbot_settings;
        $order_id           = !empty($request['order_id']) ? intval($request['order_id']):'';
        $task_id            = !empty($request['task_id']) ? intval($request['task_id']):'';
        $dispute_issue      = !empty($request['dispute_issue']) ? esc_html($request['dispute_issue']):'';
        $dispute_details    = !empty($request['dispute-details']) ? sanitize_textarea_field($request['dispute-details']):'';
        //Create dispute
        $username   	        = taskbot_get_username( $user_id );
        $linked_profile         = taskbot_get_linked_profile_id($user_id);
        $dispute_title      	= get_the_title($task_id).' #'. $order_id;
        $dispute_args = array(
            'posts_per_page'    => -1,
            'post_type'         => array( 'disputes'),
            'orderby'           => 'ID',
            'order'             => 'DESC',
            'post_status'       => 'any',
            'suppress_filters'  => false,
            'meta_query'    => array(
                'relation'  => 'AND',
                array(
                    'key'       => '_dispute_order',
                    'value'     => $order_id,
                    'compare'   => '='
                )
            )
        );
        
        $dispute_is = get_posts($dispute_args);
        if( !empty( $dispute_is ) ){
            $json['type']           = "error";
            $json['message']        = 'Oops!';
            $json['message_desc']   = esc_html__("Refund request is already created.", 'taskbot');
            if( !empty($type) && $type === 'mobile' ){
                $json['message']   = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }
        $dispute_post  = array(
            'post_title'    => wp_strip_all_tags( $dispute_title ),
            'post_status'   => 'disputed',
            'post_content'  => $dispute_details,
            'post_author'   => $user_id,
            'post_type'     => 'disputes',
        );
        $dispute_id = wp_insert_post( $dispute_post );
        $post_type      = get_post_type($order_id);
        update_post_meta( $dispute_id, '_dispute_type',$post_type );

        $buyer_id   = get_post_meta( $order_id, 'buyer_id',true );
        $buyer_id   = !empty($buyer_id) ? intval($buyer_id) : 0;
        $user_type  = apply_filters('taskbot_get_user_type', $user_id );
        update_post_meta( $dispute_id, '_send_type', $user_type);
        update_post_meta( $dispute_id, '_send_by', $user_id);
        update_post_meta( $dispute_id, '_seller_id', $user_id);
        update_post_meta( $dispute_id, '_buyer_id', $buyer_id);
        update_post_meta( $dispute_id, '_dispute_key', $dispute_issue);
        update_post_meta( $dispute_id, '_dispute_order', $order_id);
        update_post_meta( $dispute_id, '_task_id', $task_id);
        update_post_meta( $order_id, 'dispute', 'yes');
        update_post_meta( $order_id, 'dispute_id', $dispute_id);
        if (class_exists('Taskbot_Email_helper')) {
            $buyer      = get_user_by( 'id', $buyer_id );
            $buyer_name = $buyer->display_name;
            /* getting seller info */
            $seller         = get_user_by( 'id', $user_id );
            $seller_name    = $seller->display_name;
            /* getting product info */
            $product    = wc_get_product( $task_id );
            $task_name  = $product->get_title();
            /* getting task link */
            $task_link   =  get_permalink($task_id);
            /* getting dispute info */
            $order_total  = get_post_meta( $order_id, '_order_total', true );
            $order_total  = !empty($order_total) ? ($order_total) : 0;
            $emailData = array();
            $emailData['seller_name']       = $seller_name;
            $emailData['buyer_name']        = $buyer_name;
            $emailData['task_name']         = $task_name;
            $emailData['task_link']         = $task_link;
            $emailData['order_id']          = $order_id;
            $emailData['order_amount']      = $order_total;
            $status_seller_refund	= !empty( $taskbot_settings['email_admin_new_dispute'] ) ? $taskbot_settings['email_admin_new_dispute'] : '';
            if( !empty($status_seller_refund) ){
                if (class_exists('TaskbotDisputeStatuses')) {
                    $email_helper = new TaskbotDisputeStatuses();
                    $email_helper->dispute_received_admin_email($emailData); 
                }
            }
        }

        do_action('taskbot_after_submit_dispute', $dispute_id);       
        
        $json['type']           = "success";
        $json['message']        =  esc_html__('Woohoo!','taskbot');
        $json['message_desc']   = esc_html__("We have received your refund request, soon we will get back to you.", 'taskbot');
        if( !empty($type) && $type === 'mobile' ){
            $json['dispute_id'] = $dispute_id;
            $json['message']    = $json['message_desc'];
            return $json;
        } else {
            wp_send_json($json);
        }
    }
}

/**
 * create dispute for buyer
 *
 */
if( !function_exists('taskbotBuyerCreateDispute') ){
    function taskbotBuyerCreateDispute($user_id=0,$request=array(),$type=''){
        global $taskbot_settings;
        $order_id           = !empty($request['order_id']) ? intval($request['order_id']):'';
        $dispute_is         = get_post_meta( $order_id, 'dispute', true);
        $order_data         = get_post_meta( $order_id, 'cus_woo_product_data', true );
        $order_data         = !empty($order_data) ? $order_data : array();

        $seller_id          = !empty($order_data['seller_id']) ? intval($order_data['seller_id']) : 0;
        $buyer_id           = !empty($order_data['buyer_id']) ? intval($order_data['buyer_id']) : 0;
        $order_amount       = !empty($order_data['total_amount']) ? intval($order_data['total_amount']) : '' ;
        $task_id            = !empty($order_data['task_id']) ? intval($order_data['task_id']) : 0;

        $dispute_issue      = !empty($request['dispute_issue']) ? esc_html($request['dispute_issue']):'';
        $dispute_details    = !empty($request['dispute-details']) ? sanitize_textarea_field($request['dispute-details']):'';
        //Create dispute
        
        $linked_profile         = taskbot_get_linked_profile_id($user_id,'','buyers');
        $username   	        = taskbot_get_username( $linked_profile );
        $dispute_title      	= get_the_title($task_id).' #'. $order_id;
        $user_type              = apply_filters('taskbot_get_user_type', $user_id );
        $dispute_post  = array(
            'post_title'    => wp_strip_all_tags( $dispute_title ),
            'post_status'   => 'publish',
            'post_content'  => $dispute_details,
            'post_author'   => $user_id,
            'post_type'     => 'disputes',
        );
        $dispute_id     = wp_insert_post( $dispute_post );
        $post_type      = get_post_type($order_id);
        update_post_meta( $dispute_id, '_dispute_type',$post_type );
        update_post_meta( $dispute_id, '_sender_type', $user_type);
        update_post_meta( $dispute_id, '_send_by', $user_id);
        update_post_meta( $dispute_id, '_seller_id', $seller_id);
        update_post_meta( $dispute_id, '_buyer_id', $buyer_id);
        update_post_meta( $dispute_id, '_dispute_key', $dispute_issue);
        update_post_meta( $dispute_id, '_dispute_order', $order_id);
        update_post_meta( $dispute_id, '_task_id', $task_id);
        update_post_meta( $order_id, 'dispute', 'yes');
        update_post_meta( $order_id, 'dispute_id', $dispute_id);
        do_action( 'taskbot_after_dispute_creation', $dispute_id );
        $buyer          = get_user_by( 'id', $buyer_id );
        $buyer_name     = $buyer->first_name;
        $seller         = get_user_by( 'id', $seller_id );
        $seller_name    = $seller->first_name;
        $product        = wc_get_product( $task_id );
        $task_name      = $product->get_title();
        $seller_info    = get_userdata($seller_id);
        $seller_email   = $seller_info->user_email;
        $buyer_info     = get_userdata($buyer_id);
        $buyer_email    = $buyer_info->user_email;
        $login_url      = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
        $task_link      = get_permalink($task_id);

        if (class_exists('Taskbot_Email_helper')) {
            $blogname = get_option( 'blogname' );
            $emailData = array();
            $emailData['seller_name']       = $seller_name;
            $emailData['buyer_name']        = $buyer_name;
            $emailData['task_name']         = $task_name;
            $emailData['seller_email']      = $seller_email;
            $emailData['buyer_email']       = $buyer_email;
            $emailData['task_link']         = $task_link;
            $emailData['order_id'] 	        = $order_id;
            $emailData['order_amount']      = $order_amount;
            $emailData['buyer_comments']    = $dispute_details;
            $emailData['login_url']         = $login_url;
            //Welcome Email            
            $status_seller_refund	= !empty( $taskbot_settings['email_new_refund_seller'] ) ? $taskbot_settings['email_new_refund_seller'] : ''; //email seller new refend
            if(isset($status_seller_refund) && !empty($status_seller_refund )){
                if (class_exists('TaskbotRefundsStatuses')) {
                    $email_helper = new TaskbotRefundsStatuses();
                    $email_helper->refund_seller_email($emailData); //email to seller
                    $seller_profile_id              = taskbot_get_linked_profile_id($seller_id, '', 'sellers');
                    $notifyData						= array();
                    $notifyDetails					= array();
                    $notifyDetails['task_id']               = $task_id;
                    $notifyDetails['post_link_id']          = $task_id;
                    $notifyDetails['buyer_comments']        = $dispute_details;
                    $notifyDetails['seller_order_amount']   = $order_amount;
                    $notifyDetails['order_id']              = $order_id;
                    $notifyDetails['dispute_id']            = $dispute_id;
                    $notifyDetails['buyer_id']              = taskbot_get_linked_profile_id($buyer_id, '', 'buyers');
                    $notifyDetails['seller_id']             = $seller_profile_id;
                    $notifyData['receiver_id']		        = $seller_id;
                    $notifyData['type']			            = 'refund_request';
                    $notifyData['linked_profile']	        = $seller_profile_id;
                    $notifyData['user_type']		        = 'sellers';
                    $notifyData['post_data']		        = $notifyDetails;
                    do_action('taskbot_notification_message', $notifyData );
                }
            }
        }
        $json['type']           = "success";
        $json['message']        = esc_html__('Woohoo!','taskbot');
        $json['message_desc']   = esc_html__("We have received your refund request, soon we will get back to you.", 'taskbot');
        if( !empty($type) && $type === 'mobile'){
            $json['message']     = $json['message_desc'];
            return $json;
        } else {
            wp_send_json($json);
        }
    }
}

/**
 * Seller update dispute status
 *
 */
if( !function_exists('taskbotUpdateDisputeStatus') ){
    function taskbotUpdateDisputeStatus($dispute_id='',$dispute_status='',$type=''){
        global $taskbot_settings, $current_user;
        $args   = array(
            'ID'                => $dispute_id,
            'post_status'       => $dispute_status,
        );
        wp_update_post($args);

        $dispute_type   = get_post_meta($dispute_id,'_dispute_type',true);
        if( !empty($dispute_type) && $dispute_type === 'proposals'){

        $receiver_profile_id = 0;
        $project_id         = get_post_meta( $dispute_id, '_project_id',true );
        $get_user_type	    = apply_filters('taskbot_get_user_type', $current_user->ID );
        if( !empty($get_user_type) && $get_user_type === 'sellers' ){
            $seller_profile_id          = !empty($current_user->ID) ? taskbot_get_linked_profile_id($current_user->ID,'','sellers') : 0;
            $receiver_profile_id        = !empty($seller_profile_id) ? intval($seller_profile_id) : 0;
        } else if( !empty($get_user_type) && $get_user_type === 'buyers' ){
            $buyer_profile_id       = !empty($current_user->ID) ? taskbot_get_linked_profile_id($current_user->ID,'','buyers') : 0;
            $receiver_profile_id    = !empty($buyer_profile_id) ? intval($buyer_profile_id) : 0;
        }
        /* Email to admin on project dispute request by seller/buyer */
        if(class_exists('Taskbot_Email_helper')){
            $emailData                              = array();
            $emailData['user_name']                 = taskbot_get_username($receiver_profile_id);
            $emailData['project_title']             = get_the_title($project_id);
            $emailData['admin_dispute_link']        = Taskbot_Profile_Menu::taskbot_profile_admin_menu_link('project', taskbot_get_admin_user_id(), true, 'dispute', $dispute_id);
            if (class_exists('TaskbotProjectDisputes')) {
                $email_helper = new TaskbotProjectDisputes();
                $email_helper->dispute_project_request_admin_email($emailData);
            }
        }

        } else {
            /* Email to admin */
            $buyer_id   = get_post_meta( $dispute_id, '_send_by', true);
            $seller_id  = get_post_meta( $dispute_id, '_seller_id', true);
            
            /* getting buyer info */
            $buyer      = get_user_by( 'id', $buyer_id );
            $buyer_name = $buyer->display_name;
            /* getting seller info */
            $seller         = get_user_by( 'id', $seller_id );
            $seller_name    = $seller->display_name;
            
            /* getting dispute info */
            $dispute_order  = get_post_meta( $dispute_id, '_dispute_order', true );
            $dispute_order  = !empty($dispute_order) ? intval($dispute_order) : 0;
            $post_type      = get_post_type( $dispute_order );
            if( !empty($post_type) && $post_type === 'proposals' ){
                $order_total  = get_post_meta( $dispute_id, '_order_total', true );
                $order_total  = !empty($order_total) ? ($order_total) : 0;
            } else {
                $task_id    = get_post_meta( $dispute_id, '_task_id', true);
                /* getting product info */
                $product    = wc_get_product( $task_id );
                $task_name  = $product->get_title();
                /* getting task link */
                $task_link   =  get_permalink($task_id);
                $order_total  = get_post_meta( $dispute_order, '_total_amount', true );
                $order_total  = !empty($order_total) ? ($order_total) : 0;
            }
            if (class_exists('Taskbot_Email_helper')) {
                $login_url    = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
                $emailData = array();
                $emailData['seller_name']       = $seller_name;
                $emailData['buyer_name']        = $buyer_name;

                if( !empty($post_type) && $post_type === 'proposals' ){

                } else {
                    $emailData['task_name']         = $task_name;
                    $emailData['task_link']         = $task_link;
                    $emailData['order_id']          = $dispute_order;
                }
                
                $emailData['order_amount']      = $order_total;
                $emailData['login_url']         = $login_url;
                //Welcome Email
            
                $status_seller_refund	= !empty( $taskbot_settings['email_admin_new_dispute'] ) ? $taskbot_settings['email_admin_new_dispute'] : '';

                if( $status_seller_refund == true ){
                    if (class_exists('TaskbotDisputeStatuses')) {
                        $email_helper = new TaskbotDisputeStatuses();
                        $email_helper->dispute_received_admin_email($emailData); //email to seller
                        do_action('notification_message', $emailData );
                    }
                }
            }
        }
        $json['type']           = "success";
        $json['message']        = esc_html__('Woohoo!','taskbot');
        $json['message_desc']   = esc_html__("We have received your dispute, soon we will get back to you.", 'taskbot');
        if( !empty($type) && $type === 'mobile'){
            $json['message']     = $json['message_desc'];
            return $json;
        } else {
            wp_send_json($json);
        }
    }
}

/**
 * Task completed
 *
 */
if( !function_exists('taskbotTaskComplete') ){
    function taskbotTaskComplete($user_id=0,$request=array(),$type=''){
        global $taskbot_settings;
        $gmt_time		= current_time( 'mysql', 1 );
        $task_id        = !empty($request['task_id']) ? intval($request['task_id']) : 0;
        $order_id       = !empty($request['order_id']) ? intval($request['order_id']) : 0;
        $type           = !empty($request['type']) ? sanitize_text_field($request['type']) : '';
        $post_author    = get_post_meta( $order_id, 'buyer_id',true );
        if( !empty($task_id) && !empty($order_id) ){

            if( !empty($type) && $type == 'rating' ){
                $rating_details = !empty($request['rating_details']) ? sanitize_textarea_field($request['rating_details']) : '';
                $rating_title   = !empty($request['rating_title']) ? sanitize_text_field($request['rating_title']) : '';
                $rating         = !empty($request['rating']) ? sanitize_text_field($request['rating']) : '';            
                taskbot_complete_task_ratings($order_id,$task_id,$rating,$rating_title,$rating_details,$user_id);
            }
            update_post_meta( $order_id, '_task_status' , 'completed');
            update_post_meta( $order_id, '_task_completed_time', $gmt_time );
            /* getting task detail */
            $task_name    = get_the_title($task_id);
            $task_link    = get_permalink( $task_id );
            $login_url    = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : wp_login_url();
            /* getting buyer name */
            $buyer_profile_id   = taskbot_get_linked_profile_id($post_author,'','buyers');
            $buyer_name 		= taskbot_get_username($buyer_profile_id);
            /* getting seller name and email */
            $seller_id          = get_post_field( 'post_author', $task_id );
            $seller_profile_id  = taskbot_get_linked_profile_id($seller_id,'','sellers');
            $seller_name 		= taskbot_get_username($seller_profile_id);
            $seller_email 	    = get_userdata( $seller_id )->user_email;
            /* getting order detail */
            $order 		    = wc_get_order($order_id);
            $order_price = $order->get_total();
            $order_amount = !empty($order_price) ? $order_price : 0;

            if(class_exists('Taskbot_Email_helper')){

                if(class_exists('TaskbotOrderStatuses')){

                    if( $taskbot_settings['email_odr_cmpt_seller'] == true ){
                        $emailData                        = array();
                        $emailData['seller_email']        = $seller_email;
                        $emailData['seller_name']         = $seller_name;
                        $emailData['buyer_name']          = $buyer_name;
                        $emailData['task_name']           = $task_name;
                        $emailData['task_link']           = $task_link;
                        $emailData['order_id']            = $order_id;
                        $emailData['login_url']           = $login_url;
                        $emailData['order_amount']        = $order_amount;
                        $emailData['buyer_comments']      = $rating_details;
                        $emailData['buyer_rating']        = $rating;
                        $emailData['notification_type']   = 'noty_order_completed';
                        $emailData['sender_id']           = $seller_id; //seller id
                        $emailData['receiver_id']         = $post_author; //buyer id
                        $email_helper                     = new TaskbotOrderStatuses();
                        $email_helper->order_completed_seller_email($emailData);
                    }
                }
            }

            
            do_action('taskbot_complete_task_order_activity', $task_id, $order_id);

            $notifyData						= array();
            $notifyDetails					= array();
            $notifyDetails['task_id']       = $task_id;
            $notifyDetails['post_link_id']  = $task_id;
            $notifyDetails['buyer_comments']= $rating_details;
            $notifyDetails['buyer_rating']  = $rating;
            $notifyDetails['order_id']      = $order_id;
            $notifyDetails['buyer_id']      = taskbot_get_linked_profile_id($user_id, '', 'buyers');
            $notifyDetails['seller_id']     = $seller_profile_id;
            $notifyData['receiver_id']		= $seller_id;
            $notifyData['type']			    = 'order_completed';
            $notifyData['linked_profile']	= $seller_profile_id;
            $notifyData['user_type']		= 'sellers';
            $notifyData['post_data']		= $notifyDetails;
            do_action('taskbot_notification_message', $notifyData );

            
            $json['type']             = 'success';
            $json['message_desc']     = esc_html__('You have completed this task.', 'taskbot');
            if( !empty($type) && $type === 'mobile'){
                $json['message']     = $json['message_desc'];
                return $json;
            } else {
                wp_send_json($json);
            }
        }
    }
}

/**
 * Task cancelled
 *
 */
if( !function_exists('taskbotCancelledTask') ){
    function taskbotCancelledTask($user_id=0,$request=array(),$type=''){
        global $taskbot_settings;
        $task_id        = !empty($request['task_id']) ? intval($request['task_id']) : 0;
        $order_id       = !empty($request['order_id']) ? intval($request['order_id']) : 0;
        $details        = !empty($request['details']) ? sanitize_textarea_field($request['details']) : '';
        
        $gmt_time		 = current_time( 'mysql', 1 );
        update_post_meta( $order_id, '_task_status' , 'cancelled');
        update_post_meta( $order_id, '_task_cancellation_time', $gmt_time );
        update_post_meta( $order_id, '_task_cancellation_reason', $details );
        update_post_meta( $order_id, '_task_cancelled_by', $user_id );
        /* Send Email on task canceled */
        if(class_exists('Taskbot_Email_helper')){

            if(class_exists('TaskbotTaskStatuses')){
                if( $taskbot_settings['email_task_rej_seller'] == true ){
                    /* set data for email */
                    $task_name          = get_the_title($task_id);
                    $task_link          = get_permalink( $task_id );
                    /* getting seller name and email */
                    $seller_id          = get_post_field( 'post_author', $task_id );
                    $seller_profile_id  = taskbot_get_linked_profile_id($seller_id, '', 'sellers');
                    $seller_name 		= taskbot_get_username($seller_profile_id);
                    $seller_email 	    = get_userdata( $seller_id )->user_email;

                    $emailData = array();
                    $emailData['seller_email']        = $seller_email;
                    $emailData['seller_name']         = $seller_name;
                    $emailData['task_name']           = $task_name;
                    $emailData['task_link']           = $task_link;
                    $emailData['buyer_feedback']      = $details;
                    $email_helper = new TaskbotTaskStatuses();
                    $email_helper->reject_task_seller_email($emailData);
                }
            }

        }

        $notifyData						= array();
        $notifyDetails					= array();
        $notifyDetails['task_id']       = $task_id;
        $notifyDetails['post_link_id']  = $task_id;
        $notifyDetails['buyer_comments']= $details;
        $notifyDetails['order_id']      = $order_id;
        $notifyDetails['buyer_id']      = taskbot_get_linked_profile_id($user_id, '', 'buyers');
        $notifyDetails['seller_id']     = $seller_profile_id;
        $notifyData['receiver_id']		= $seller_id;
        $notifyData['type']			    = 'order_rejected';
        $notifyData['linked_profile']	= $seller_profile_id;
        $notifyData['user_type']		= 'sellers';
        $notifyData['post_data']		= $notifyDetails;
        do_action('taskbot_notification_message', $notifyData );
        do_action('taskbot_after_cancelled_task', $order_id );
        $json['type']           = 'success';
        $json['message_desc']    = esc_html__('You have successfully cancelled this task.', 'taskbot');
        wp_send_json($json);
    }
}

/**
 * Check any prerequisites for our REST request.
 */
function check_prerequisites($userId='') {
    if ( defined( 'WC_ABSPATH' ) ) {
        // WC 3.6+ - Cart and other frontend functions are not included for REST requests.
        
        include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
        include_once WC_ABSPATH . 'includes/wc-notice-functions.php';
        include_once WC_ABSPATH . 'includes/wc-template-hooks.php';
        include_once WC_ABSPATH . 'includes/wc-order-functions.php';
        include_once WC_ABSPATH . 'includes/wc-order-item-functions.php';
        include_once WC_ABSPATH . 'includes/class-wc-order.php';
    }

    if ( null === WC()->session ) {
        $session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );

        WC()->session = new $session_class();
        WC()->session->init();
    }
    if ( null === WC()->customer ) {
        WC()->customer = new WC_Customer( $userId, true );
    }
    if ( null === WC()->cart ) {
        WC()->cart = new WC_Cart();
        // We need to force a refresh of the cart contents from session here (cart contents are normally refreshed on wp_loaded, which has already happened by this point).
        WC()->cart->get_cart();
    }
}

/**
 * Task update status
 *
 */
if( !function_exists('taskbotUpdateStatus') ){
    function taskbotUpdateStatus($task_id=0){
        global $taskbot_settings;
        $service_status             = !empty($taskbot_settings['service_status']) ? $taskbot_settings['service_status'] : '';
        $resubmit_service_status    = !empty($taskbot_settings['resubmit_service_status']) ? $taskbot_settings['resubmit_service_status'] : 'no';

        $task_status                = get_post_meta( $task_id, '_post_task_status',true );
        $task_status                = !empty($task_status) ? $task_status : '';

        $post_status                = get_post_status($task_id);
        $post_status                = !empty($post_status) ? $post_status : '';

        if( !empty($service_status) && $service_status === 'pending' && !empty($resubmit_service_status) && $resubmit_service_status === 'yes'){
            if( empty($task_status) || $task_status != 'rejected'){
                update_post_meta( $task_id, '_post_task_status', 'pending' );
                if(!empty($post_status) && $post_status != 'draft'){
                    $service_post = array(
                        'ID'            => $task_id,
                        'post_status'   => $service_status,
                    );
                    wp_update_post( $service_post );
                }
            }
        } else if( !empty($service_status) && $service_status === 'publish' && !empty($resubmit_service_status) && $resubmit_service_status === 'no'){
            update_post_meta( $task_id, '_post_task_status', 'publish' );
        }

    }
}

/**
 * Buyer email
 * @return slug
 */
if (!function_exists('taskbot_buyer_email')) {
	function taskbot_buyer_email(){
		$buyer_email = array(

			/* Buyer Email on Account Approval Request */
				array(
					'id'      => 'divider_approvel_request_buyer_registration_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Account approval request', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_acc_approv_buyer',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to seller on registration.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'buyer_email_req_approvel_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Thank you for registration at {{sitename}}', 'taskbot'),
					'required'  => array('email_acc_approv_buyer','equals','1')
				),
				array(
					'id'      => 'divider_buyer_email_request_approvel_information',
					'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
								{{email}} — To display the user email.<br>
								{{password}} — To display the user password.<br>
								{{sitename}} — To display the sitename.<br>'
								, 'taskbot' ),
					array(
						'a'	=> array(
							'href'  => array(),
							'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_acc_approv_buyer','equals','1')
				),
				array(
					'id'      	=> 'buyer_email_req_approvel_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{name}},', 'taskbot'),
					'required'  => array('email_acc_approv_buyer','equals','1')
				),
				array(
					'id'        => 'buyer_email_request_approvel_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Thank you for the registration at "{{sitename}}" Your account will be approved  after the verification.', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_acc_approv_buyer','equals','1')
				),
		
			/* Buyer Email on Account approved */
				array(
					'id'      => 'divider_approved_buyer_account_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Account approval confirmation', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_approv_confirm_buyer',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to seller on account approvel.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      => 'buyer_mail_req_approved_subject',
					'type'    => 'text',
					'title'   => esc_html__( 'Subject', 'taskbot' ),
					'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' => esc_html__( 'Account approved','taskbot'),
					'required'  => array('email_approv_confirm_buyer','equals','1')
		
				),
				array(
					'id'      => 'divider_buyer_approved_information',
					'desc'    => wp_kses( __( '{{name}} — To display the user name.<br>
									{{email}} — To display the user email.<br>
									{{sitename}} — To display the sitename.<br>'
								, 'taskbot' ),
					array(
						'a'	=> array(
							'href'  => array(),
							'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
						) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_approv_confirm_buyer','equals','1')
				),
				array(
					'id'      => 'buyer_email_req_approved_greeting',
					'type'    => 'text',
					'title'   => esc_html__( 'Greeting', 'taskbot' ),
					'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
					'default' => esc_html__( 'Hello {{name}},','taskbot'),
					'required'  => array('email_approv_confirm_buyer','equals','1')
				),
				array(
					'id'        => 'approved_buyer_account_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Congratulations!<br/>Your account has been approved by the admin.', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_approv_confirm_buyer','equals','1')
				),
		
				/* Buer Email on Post project */
				array(
					'id'      => 'divider_post_project_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Post a project', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_post_project',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to buyer on post a project.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'post_project_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Project submission','taskbot' ),
					'required'  => array('email_post_project','equals','1')
		
				),
				array(
					'id'	=> 'divider_post_task_information',
					'desc'  => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
									{{project_title}} — To display the project name.<br>
									{{project_link}} — To display the project link.<br>'
								, 	'taskbot' ),
					array(
						'a'       => array(
							'href'  => array(),
							'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_post_project','equals','1')
				),
				array(
					'id'      	=> 'post_project_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array('email_post_project','equals','1')
		
				),
				array(
					'id'        => 'post_project_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Thank you for submitting the project, we will review and approve the project after the review.', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_post_project','equals','1')
				),
		
				/* Buyer Email on Project Approved */
				array(
					'id'      => 'divider_project_approved_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Project approved', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_project_approve',
					'type'     => 'switch',
					'title'    => esc_html__( 'Send email', 'taskbot' ),
					'subtitle' => esc_html__( 'Email to buyer on posted task approvel.', 'taskbot' ),
					'default'  => true,
				),
				array(
					'id'      	=> 'project_approved_buyer_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Project approved!','taskbot' ),
					'required'  => array('email_project_approve','equals','1')
				),
				array(
					'id'      => 'divider_project_approved_information',
					'desc'    => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
									{{project_title}} — To display the project name.<br>
									{{project_link}} — To display the project link.<br>'
								, 'taskbot' ),
					array(
						'a'       => array(
							'href'  => array(),
							'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_project_approve','equals','1')
				),
				array(
					'id'      	=> 'project_approved_project_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot'),
					'required'  => array('email_project_approve','equals','1')
		
				),
				array(
					'id'        => 'project_approved_project_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Woohoo! Your project {{project_title}} has been approved.<br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_project_approve','equals','1')
		
				),
		
			/* Buyer Email on Project Rejected */
				array(
					'id'      => 'divider_project_rejected_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Buyer project rejected', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_project_rej_buyer',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to buyer on project rejected.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'project_rejected_buyer_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Project rejection','taskbot'),
					'required'  => array('email_project_rej_buyer','equals','1')
				),
				array(
					'id'      => 'divider_project_rejected_information',
					'desc'    => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
								{{project_title}} — To display the project name.<br>
								{{project_link}} — To display the project link.<br>'
				, 'taskbot' ),
				array(
						'a'       => array(
							'href'  => array(),
							'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_project_rej_buyer','equals','1')
				),
				array(
					'id'      	=> 'project_rejected_buyer_greeting',
					'type'    	=> 'text',
					'title'   	=> 	esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> 	esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> 	esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => 	array('email_project_rej_buyer','equals','1')
				),
				array(
					'id'        => 'project_rejected_buyer_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Oho! Your project {{project_title}} has been rejected.<br/> Please click on the button below to view the project.<br/> {{project_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     =>  esc_html__( 'Email contents', 'taskbot' ),
					'required'  =>  array('email_project_rej_buyer','equals','1')
				),
		
			
			/* Buyer Email on Order */
				array(
					'id'      => 'divider_new_order_buyer_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'New order', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_new_order_buyer',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to seller on new order.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'new_order_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'New order','taskbot'),
					'required'  => array('email_new_order_buyer','equals','1')
				),
				array(
					'id'      => 'new_order_buyer_information',
					'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
								{{buyer_name}} — To display the buyer name.<br>
								{{task_name}} — To display the task name.<br>
								{{task_link}} — To display the task link.<br>
								{{order_id}} — To display the order id.<br>
								{{order_amount}} — To display the order amount.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_new_order_buyer','equals','1')
		
				),
				array(
					'id'      	=> 'new_order_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot'),
					'required'  => array('email_new_order_buyer','equals','1')
		
				),
				array(
					'id'        => 'new_order_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Thank you so much for ordering my task. I will get in touch with you shortly.', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_new_order_buyer','equals','1')
		
				),
		
			/* Buyer Email on Order Complete Request */
				array(
					'id'      => 'divider_order_complete_request_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Order complete request', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_order_complete_seller',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to seller on new order.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'order_complete_request_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Task completed request','taskbot'),
					'required'  => array('email_order_complete_seller','equals','1')
		
				),
				array(
					'id'      => 'divider_order_complete_request_information',
					'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
								{{buyer_name}} — To display the buyer name.<br>
								{{task_name}} — To display the task name.<br>
								{{task_link}} — To display the task link.<br>
								{{order_id}} — To display the order id.<br>
								{{login_url}} — To display the login url.<br>
								{{order_amount}} — To display the order amount.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
						) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_order_complete_seller','equals','1')
				),
				array(
					'id'      	=> 'order_complete_request_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot'),
					'required'  => array('email_order_complete_seller','equals','1')
				),
				array(
					'id'        => 'order_complete_request_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'The seller “{{seller_name}}” has sent you the final delivery for the order #{{order_id}}<br/> You can accept or decline this. Please login to the site and take a quick action<br/> {{login_url}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_order_complete_seller','equals','1')
				),
		
			/* Buyer Email on Order Activity */
				array(
					'id'      => 'divider_buyer_order_activity_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Order activity', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_ord_activity_buyer',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to buyer on order activity.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'order_activity_buyer_subject',
					'type'    	=> 'text',
					'default'	=> esc_html__( 'Order activity', 'taskbot' ),
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'required'  => array('email_ord_activity_buyer','equals','1')
				),
				array(
					'id'      => 	'divider_buyer_order_activity_information',
					'desc'    =>	wp_kses( __( '{{sender_name}} — To display the email sender name.<br>
										{{receiver_name}} — To display the email receiver name.<br>
										{{task_name}} — To display task name.<br>
										{{task_link}} — To display the task link.<br>
										{{order_id}} — To display the task id.<br>
										{{order_amount}} — To display the task/order amount.<br>
										{{login_url}} — To display the site login url.<br>
										{{sender_comments}} — To display the sender comments/message.<br>'
									, 'taskbot' ),
		
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_ord_activity_buyer','equals','1')
				),
				array(
					'id'      	=> 'order_activity_buyer_gretting',
					'type'    	=> 'text',
					'default' 	=> esc_html__( 'Hello {{receiver_name}}', 'taskbot' ),
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'required'  => array('email_ord_activity_buyer','equals','1')
				),
				array(
					'id'        => 'order_activity_buyer_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'You have received a note from the "{{sender_name}}" on the ongoing task "{{task_name}}" against the order #{{order_id}} <br/>{{sender_comments}} <br/>You can login to take a quick action.<br/>{{login_url}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_ord_activity_buyer','equals','1')
		
				),
		
			/* Buyer Email on Refund Approved */
				array(
					'id'      => 'divider_buyer_refund_approved_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Buyer refund approved', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_refund_approv_buyer',
					'type'     => 'switch',
					'title'    => esc_html__( 'Send email', 'taskbot' ),
					'subtitle' => esc_html__( 'Email to buyer on refund approve.', 'taskbot' ),
					'default'  => true,
				),
				array(
					'id'      	=> 'buyer_approved_refund_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Refund approved','taskbot'),
					'required'  => array('email_refund_approv_buyer','equals','1')
		
				),
				array(
					'id'      => 'divider_approved_buyer_refund_information',
					'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
								{{buyer_name}} — To display the buyer name.<br>
								{{task_name}} — To display the task name.<br>
								{{task_link}} — To display the task link.<br>
								{{order_id}} — To display the order id.<br>
								{{order_amount}} — To display the order amount.<br>
								{{login_url}} — To display the login url.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
						) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_refund_approv_buyer','equals','1')
				),
				array(
					'id'      	=> 'buyer_approved_refund_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot'),
					'required'  => array('email_refund_approv_buyer','equals','1')
				),
				array(
					'id'        => 'approved_buyer_refund_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Congratulations!<br/>Your refund request has been approved by the "{{seller_name}}" against the order #{{order_id}}.', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_refund_approv_buyer','equals','1')
				),
		
			/* Buyer Email on Refund Declined */
				array(
					'id'      => 'divider_order_buyer_refund_declined_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Buyer refund declined', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_refund_declined_buyer',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to buyer on refund request declined.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'buyer_declined_refund_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Refund declined','taskbot'),
					'required'  => array('email_refund_declined_buyer','equals','1')
				),
				array(
					'id'      => 'divider_buyer_declined_refund_information',
					'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
								{{buyer_name}} — To display the buyer name.<br>
								{{task_name}} — To display the task name.<br>
								{{task_link}} — To display the task link.<br>
								{{order_id}} — To display the order id.<br>
								{{order_amount}} — To display the order amount.<br>
								{{login_url}} — To display the login url.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
						) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array('email_refund_declined_buyer','equals','1')
				),
				array(
					'id'      	=> 'buyer_declined_refund_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot'),
					'required'  => array('email_refund_declined_buyer','equals','1')
		
				),
				array(
					'id'        => 'declined_buyer_refund_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Your refund request has been declined by the "{{seller_name}}" against the order #{{order_id}} <br/>If you think that this was a valid request then you can raise a dispute from the ongoing task page.<br/>{{login_url}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array('email_refund_declined_buyer','equals','1')
				),
		
			/* Buyer Email on Refund Comment */
				array(
					'id'      => 'divider_order_refund_buyer_comment_templates',
					'type'    => 'info',
					'title'   => esc_html__( 'Refund comment', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_refund_comment_buyer',
					'type'     => 'switch',
					'title'    => esc_html__('Send email', 'taskbot'),
					'subtitle' => esc_html__('Email to buyer on refund comment.', 'taskbot'),
					'default'  => true,
				),
				array(
					'id'      	=> 'refund_buyer_comment_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'A new comment on refund request','taskbot'),
					'required'  => array( 'email_refund_comment_buyer','equals','1')
				),
				array(
					'id'      => 'divider_declined_order_buyer_refund_information',
					'desc'    => wp_kses( __( '{{sender_name}} — To display the sender name.<br>
								{{receiver_name}} — To display the receiver name.<br>
								{{task_name}} — To display the task name.<br>
								{{task_link}} — To display the task link.<br>
								{{order_id}} — To display the order id.<br>
								{{order_amount}} — To display the order amount.<br>
								{{login_url}} — To display the login url.<br>
								{{sender_comments}} — To display the sender comment.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'email_refund_comment_buyer','equals','1')
				),
				array(
					'id'      	=> 'refund_buyer_comment_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{receiver_name}},','taskbot'),
					'required'  => array( 'email_refund_comment_buyer','equals','1')
				),
				array(
					'id'        => 'refund_buyer_comment_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'The “{{sender_name}}” has left some comments on the refund request against the order #{{order_id}}<br/> {{sender_comments}}<br/> {{login_url}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array( 'email_refund_comment_buyer','equals','1')
				),
		
			/* Buyer Email on Dispute Resolved */
				array(
					'id'      => 'divider_disputes_resolved_buyer_templates',
					'type'    => 'info',
					'title'   =>  esc_html__( 'Dispute resolved buyer', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_dispt_resolve_buyer',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email to buyer on refund comment.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'disputes_resolved_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Dispute resolved','taskbot'),
					'required'  => array( 'email_dispt_resolve_buyer','equals','1')
		
				),
				array(
					'id'      => 'divider_disputes_resolved_buyer_information',
					'desc'    => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
								{{task_name}} — To display the task name.<br>
								{{task_link}} — To display the task link.<br>
								{{order_id}} — To display the order id.<br>
								{{order_amount}} — To display the order amount.<br>
								{{login_url}} — To display the login url.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'email_dispt_resolve_buyer','equals','1')
				),
				array(
					'id'      	=> 'disputes_resolved_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array( 'email_dispt_resolve_buyer','equals','1')
		
				),
				array(
					'id'        => 'disputes_resolved_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Congratulations! We have gone through the dispute and resolved the dispute in your favor. The amount has been added to your wallet, you can try to hire someone else.', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents (dispute win)', 'taskbot' ),
					'required'  => array( 'email_dispt_resolve_buyer','equals','1')
				),
		
				/* Buyer Email on Dispute Canceled/resolve not in your favour */
				array(
					'id'      => 'divider_disputes_cancelled_buyer_templates',
					'type'    => 'info',
					'title'   =>  esc_html__( 'Dispute not in your favour', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_disputes_cancelled_buyer',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email to buyer on resolve dispute.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'disputes_cancelled_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Dispute not in your favour','taskbot'),
					'required'  => array( 'email_disputes_cancelled_buyer','equals','1')
		
				),
				array(
					'id'      => 'divider_disputes_cancelled_buyer_information',
					'desc'    => wp_kses( __( '{{buyer_name}} — To display the seller name.<br>
								{{task_name}} — To display the task name.<br>
								{{task_link}} — To display the task link.<br>
								{{order_id}} — To display the order id.<br>
								{{order_amount}} — To display the order amount.<br>
								{{login_url}} — To display the login url.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'email_disputes_cancelled_buyer','equals','1')
				),
				array(
					'id'      	=> 'disputes_cancelled_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array( 'email_disputes_cancelled_buyer','equals','1')
		
				),
				array(
					'id'        => 'disputes_cancelled_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Dispute resolve by admin but not in your favour.', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents (dispute resolved)', 'taskbot' ),
					'required'  => array( 'email_disputes_cancelled_buyer','equals','1')
				),
		
				/* Buyer Email on submit proposal */
				array(
					'id'      => 'divider_submit_proposal_buyer_templates',
					'type'    => 'info',
					'title'   =>  esc_html__( 'Submit proposal', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_submit_proposal_buyer',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email to buyer on submit proposal.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'submit_proposal_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Submit Proposal','taskbot'),
					'required'  => array( 'email_submit_proposal_buyer','equals','1')
				),
				array(
					'id'      => 'submit_proposal_buyer_information',
					'desc'    => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
								{{seller_name}} — To display the seller name.<br>
								{{project_title}} — To display the project title.<br>
								{{proposal_link}} — To display the proposal link.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'email_submit_proposal_buyer','equals','1')
				),
				array(
					'id'      	=> 'submit_proposal_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array( 'email_submit_proposal_buyer','equals','1')
				),
				array(
					'id'        => 'submit_proposal_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( '{{seller_name}} submit a new proposal on {{project_title}} Please click on the button below to view the proposal. {{proposal_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array( 'email_submit_proposal_buyer','equals','1')
				),
				/* Buyer Email on milestone approval request */
				array(
					'id'      => 'divider_req_milestone_approval_buyer_templates',
					'type'    => 'info',
					'title'   =>  esc_html__( 'Milestone approval request', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_req_milestone_approval_buyer',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email to buyer on milestone approval.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'req_milestone_approval_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Milestone approval request','taskbot'),
					'required'  => array( 'email_req_milestone_approval_buyer','equals','1')
				),
				array(
					'id'      => 'req_milestone_approval_buyer_information',
					'desc'    => wp_kses( __( '{{buyer_name}} — To display the buyer name.<br>
								{{seller_name}} — To display the seller name.<br>
								{{project_title}} — To display the project title.<br>
								{{milestone_title}} — To display the milestone title.<br>
								{{milestone_link}} — To display the milestone link.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'email_req_milestone_approval_buyer','equals','1')
				),
				array(
					'id'      	=> 'req_milestone_approval_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array( 'email_req_milestone_approval_buyer','equals','1')
				),
				array(
					'id'        => 'req_milestone_approval_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'A new milestone {{milestone_title}} of {{project_title}} approval received from {{seller_name}}<br/>Please click on the button below to view the milestone.<br/>{{milestone_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array( 'email_req_milestone_approval_buyer','equals','1')
				),
				/* Buyer Email on new project milestone */
				array(
					'id'      => 'divider_new_project_milestone_buyer_templates',
					'type'    => 'info',
					'title'   =>  esc_html__( 'New project milestone', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_new_project_milestone_buyer_switch',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email to buyer on new project milestone.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'new_project_milestone_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Project new milestone','taskbot'),
					'required'  => array( 'email_new_project_milestone_buyer_switch','equals','1')
				),
				array(
					'id'      => 'new_project_milestone_buyer_information',
					'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
								{{buyer_name}} — To display the buyer name.<br>
								{{project_title}} — To display the project title.<br>
								{{project_link}} — To display the project link.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'email_new_project_milestone_buyer_switch','equals','1')
				),
				array(
					'id'      	=> 'new_project_milestone_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array( 'email_new_project_milestone_buyer_switch','equals','1')
				),
				array(
					'id'        => 'new_project_milestone_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( '{{seller_name}} add new milestone for the project {{project_title}}<br/>Please click on the button below to view the project history.<br/>{{project_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array( 'email_new_project_milestone_buyer_switch','equals','1')
				),
		
				/* Buyer Email on project refund request decline by seller */
				array(
					'id'      => 'divider_refund_project_request_decline_buyer_templates',
					'type'    => 'info',
					'title'   =>  esc_html__('Project refund request decline', 'taskbot'),
					'style'   => 'info',
				),
				array(
					'id'       => 'refund_project_request_decline_buyer_switch',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email to buyer on refund request.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'refund_project_request_decline_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Project refund decline','taskbot'),
					'required'  => array( 'refund_project_request_decline_buyer_switch','equals','1')
				),
				array(
					'id'      => 'refund_project_request_decline_buyer_information',
					'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
								{{buyer_name}} — To display the buyer name.<br>
								{{dispute_link}} — To display the dispute link.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'refund_project_request_decline_buyer_switch','equals','1')
				),
				array(
					'id'      	=> 'refund_project_request_decline_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array( 'refund_project_request_decline_buyer_switch','equals','1')
				),
				array(
					'id'        => 'refund_project_request_decline_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Oho! A dispute has been declined by {{seller_name}}<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array( 'refund_project_request_decline_buyer_switch','equals','1')
				),
		
				/* Buyer Email on project refund request approve by seller */
				array(
					'id'      => 'divider_refund_project_request_approved_buyer_templates',
					'type'    => 'info',
					'title'   =>  esc_html__('Project refund request approved', 'taskbot'),
					'style'   => 'info',
				),
				array(
					'id'       => 'refund_project_request_approved_buyer_switch',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email to buyer on refund request approved.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'refund_project_request_approved_buyer_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Project refund approved','taskbot'),
					'required'  => array( 'refund_project_request_approved_buyer_switch','equals','1')
				),
				array(
					'id'      => 'refund_project_request_approved_buyer_information',
					'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
								{{buyer_name}} — To display the buyer name.<br>
								{{dispute_link}} — To display the dispute link.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'refund_project_request_approved_buyer_switch','equals','1')
				),
				array(
					'id'      	=> 'refund_project_request_approved_buyer_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{buyer_name}},','taskbot' ),
					'required'  => array( 'refund_project_request_approved_buyer_switch','equals','1')
				),
				array(
					'id'        => 'refund_project_request_approved_buyer_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'Woohoo! {{seller_name}} approved dispute refund request in your favour.<br/>Please click on the button below to view the dispute details.<br/>{{dispute_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__( 'Email contents', 'taskbot' ),
					'required'  => array( 'refund_project_request_approved_buyer_switch','equals','1')
				),
		
		
				/* Project activity email to receiver */
				array(
					'id'      => 'divider_project_activity_receiver_templates',
					'type'    => 'info',
					'title'   =>  esc_html__( 'Project activity', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'email_project_activity_receiver_switch',
					'type'     => 'switch',
					'title'    =>  esc_html__('Send email', 'taskbot'),
					'subtitle' =>  esc_html__('Email on project activity.', 'taskbot'),
					'default'  =>  true,
				),
				array(
					'id'      	=> 'project_activity_receiver_email_subject',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Subject', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
					'default' 	=> esc_html__( 'Project activity','taskbot'),
					'required'  => array( 'email_project_activity_receiver_switch','equals','1')
				),
				array(
					'id'      => 'project_activity_receiver_information',
					'desc'    => wp_kses( __( '{{sender_name}} — To display the sender name.<br>
								{{receiver_name}} — To display the receiver name.<br>
								{{project_title}} — To display the project title.<br>
								{{project_link}} — To display the project link.<br>'
								, 'taskbot' ),
					array(
							'a'       => array(
								'href'  => array(),
								'title' => array()
							),
							'br'      => array(),
							'em'      => array(),
							'strong'  => array(),
					) ),
					'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
					'type'      => 'info',
					'class'     => 'dc-center-content',
					'icon'      => 'el el-info-circle',
					'required'  => array( 'email_project_activity_receiver_switch','equals','1')
				),
				array(
					'id'      	=> 'project_activity_receiver_email_greeting',
					'type'    	=> 'text',
					'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
					'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
					'default' 	=> esc_html__( 'Hello {{receiver_name}},','taskbot' ),
					'required'  => array( 'email_project_activity_receiver_switch','equals','1')
				),
				array(
					'id'        => 'project_activity_receiver_mail_content',
					'type'      => 'textarea',
					'default'   => wp_kses( __( 'A new activity performed by {{sender_name}} on a {{project_title}} project<br/>Please click on the button below to view the activity.<br/>{{project_link}}', 'taskbot'),
					array(
						'a'	=> array(
						'href'  => array(),
						'title' => array()
						),
						'br'      => array(),
						'em'      => array(),
						'strong'  => array(),
					)),
					'title'     => esc_html__('Email contents', 'taskbot'),
					'required'  => array( 'email_project_activity_receiver_switch','equals','1')
				),
		
			);

		$buyer_email    = apply_filters( 'taskbot_filter_buyer_email_fields', $buyer_email );
		return	$buyer_email;

	}
}

/* Seller Email Template fields */
/**
 * Seller email
 * @return slug
 */
if (!function_exists('taskbot_seller_email')) {
	function taskbot_seller_email(){
		$seller_email = array(
            /* Seller Email on Post Task */
		array(
			'id'      => 'divider_post_task_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Post a task', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_post_task',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on post a task.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'post_task_seller_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Task submission','taskbot' ),
			'required'  => array('email_post_task','equals','1')

		),
		array(
			'id'	=> 'divider_post_task_information',
			'desc'  => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
							{{task_name}} — To display the task name.<br>
							{{task_link}} — To display the task link.<br>'
						, 	'taskbot' ),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_post_task','equals','1')
		),
		array(
			'id'      	=> 'post_task_seller_email_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{seller_name}},','taskbot' ),
			'required'  => array('email_post_task','equals','1')

		),
		array(
			'id'        => 'post_task_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Thank you for submitting the task, we will review and approve the task after the review.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_post_task','equals','1')
		),

    /* Seller Email on Task Approved */
		array(
			'id'      => 'divider_task_approved_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Task approved', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_task_approve',
			'type'     => 'switch',
			'title'    => esc_html__( 'Send email', 'taskbot' ),
			'subtitle' => esc_html__( 'Email to seller on posted task approvel.', 'taskbot' ),
			'default'  => true,
		),
		array(
			'id'      	=> 'task_approved_seller_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Task approved!','taskbot' ),
			'required'  => array('email_task_approve','equals','1')
		),
		array(
			'id'      => 'divider_task_approved_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
							{{task_name}} — To display the task name.<br>
						   	{{task_link}} — To display the task link.<br>'
						, 'taskbot' ),
			array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_task_approve','equals','1')
		),
		array(
			'id'      	=> 'task_approved_seller_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_task_approve','equals','1')

		),
		array(
			'id'        => 'task_approved_seller_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Your task “{{task_name}}” has been approved. You can view your task here {{task_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_task_approve','equals','1')

		),

    /* Seller Email on Task Rejected */
		array(
			'id'      => 'divider_task_rejected_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Seller task rejected', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_task_rej_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on posted task rejected.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'task_rejected_seller_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Task rejected','taskbot'),
			'required'  => array('email_task_rej_seller','equals','1')
		),
		array(
			'id'      => 'divider_task_rejected_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
						{{task_name}} — To display the task name.<br>
						{{task_link}} — To display the task link.<br>
					    {{admin_feedback}} — To display the admin feedback.<br>'
		, 'taskbot' ),
		array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_task_rej_seller','equals','1')
		),
		array(
			'id'      	=> 'task_rejected_seller_greeting',
			'type'    	=> 'text',
			'title'   	=> 	esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> 	esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> 	esc_html__( 'Hello {{seller_name}},','taskbot' ),
			'required'  => 	array('email_task_rej_seller','equals','1')

		),
		array(
			'id'        => 'task_rejected_seller_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Your task “{{task_name}}” has been rejected. Please make the required changes and submit it again.<br/>{{admin_feedback}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     =>  esc_html__( 'Email contents', 'taskbot' ),
			'required'  =>  array('email_task_rej_seller','equals','1')
		),

    /* Seller Email on New Order */
		array(
			'id'      => 'divider_new_order_seller_templates',
			'type'    => 'info',
			'title'   =>  esc_html__( 'New order', 'taskbot' ),
			'style'   => 'info',
		),

		array(
			'id'       => 'email_new_order_seller',
			'type'     => 'switch',
			'title'    =>  esc_html__( 'Send email', 'taskbot' ),
			'subtitle' =>  esc_html__( 'Email to seller on new order received.', 'taskbot' ),
			'default'  =>  true,
		),

		array(
			'id'      	=> 'new_order_seller_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'A new task order.','taskbot'),
			'required'  => array('email_new_order_seller','equals','1')

		),
		array(
			'id'      => 'divider_new_order_seller_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
						{{buyer_name}} — To display the buyer name.<br>
						{{task_name}} — To display the task name.<br>
 						{{task_link}} — To display the task link.<br>
 						{{order_id}} — To display the order id.<br>
 						{{order_amount}} — To display the order amount.<br>
 						{{signature}} — To display the email signature.<br>'
					, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_new_order_seller','equals','1')

		),
		array(
			'id'      	=> 'new_order_seller_email_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_new_order_seller','equals','1')

		),
		array(
			'id'        => 'new_order_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You have received a new order for the task “{{task_name}}”.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),

			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_new_order_seller','equals','1')

		),

    /* Seller Email on Order Complete request declined */
		array(
			'id'      => 'divider_order_complete_req_declined_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Order complete request declined', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_odr_cmpt_dec_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on order complete request rejection.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'order_complete_request_declined_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Task completed request declined','taskbot'),
			'required'  => array('email_odr_cmpt_dec_seller','equals','1')

		),
		array(
			'id'      => 'order_complete_buyer_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
						{{buyer_name}} — To display the buyer name.<br>
						{{task_name}} — To display the task name.<br>
 						{{task_link}} — To display the task link.<br>
 						{{order_id}} — To display the order id.<br>
 						{{order_amount}} — To display the order amount.<br>
 						{{buyer_comments}} — To display the buyer comment.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_odr_cmpt_dec_seller','equals','1')

		),
		array(
			'id'      => 'order_complete_request_declined_greeting',
			'type'    => 'text',
			'default' => esc_html__( 'Hello {{seller_name}},', 'taskbot' ),
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'required'  => array('email_odr_cmpt_dec_seller','equals','1')
		),
		array(
			'id'        => 'order_complete_request_declined_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'The buyer “{{buyer_name}}” has declined the final revision and has left some comments against the order #{{order_id}} <br/> "{{buyer_comments}}"', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' )
		),

    /* Seller Email on Order Completed */
		array(
			'id'      => 'divider_order_status_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Order completed', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_odr_cmpt_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on order complete.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      => 'order_completed_seller_subject',
			'type'    => 'text',
			'title'   => esc_html__( 'Subject', 'taskbot' ),
			'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' => esc_html__( 'Task completed','taskbot'),
			'required'  => array('email_odr_cmpt_seller','equals','1')
		),
		array(
			'id'      => 'divider_order_completed_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
						{{buyer_name}} — To display the buyer name.<br>
						{{task_name}} — To display the task name.<br>
 						{{task_link}} — To display the task link.<br>
 						{{order_id}} — To display the order id.<br>
 						{{order_amount}} — To display the order amount.<br>
						{{login_url}} — To display the login url.<br>
						{{buyer_comments}} — To display the buyer comments.<br>
						{{buyer_rating}} — To display the buyer rating.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_odr_cmpt_seller','equals','1')
		),
		array(
			'id'      	=> 'order_completed_seller_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_odr_cmpt_seller','equals','1')
		),
		array(
			'id'        => 'order_completed_seller_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Congratulations!
			The buyer “{{buyer_name}}” has closed the ongoing task with the order #{{order_id}} and has left some comments <br> "{{buyer_comments}}" <br/>Buyer rating: {{buyer_rating}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_odr_cmpt_seller','equals','1')
		),

    /* Seller Email on Order Activity */
		array(
			'id'      => 'divider_email_order_activity_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Seller order activity', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_odr_activity_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on order activity.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      => 'order_activity_seller_subject',
			'type'    => 'text',
			'default' => esc_html__( 'Order activity', 'taskbot' ),
			'title'   => esc_html__( 'Subject', 'taskbot' ),
			'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
			'required'  => array('email_odr_activity_seller','equals','1')
		),

		array(
			'id'      =>	'divider_email_order_activity_information',
			'desc'    =>  	wp_kses( __( '{{sender_name}} — To display the email sender name.<br>
                              	{{receiver_name}} — To display the email receiver name.<br>
                              	{{task_name}} — To display task name.<br>
                              	{{task_link}} — To display the task link.<br>
                              	{{order_id}} — To display the task id.<br>
                              	{{order_amount}} — To display the task/order amount.<br>
                              	{{login_url}} — To display the site login url.<br>
                              	{{sender_comments}} — To display the sender comments/message.<br>'
        					, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_odr_activity_seller','equals','1')
		),
		array(
			'id'      => 'order_activity_seller_gretting',
			'type'    => 'text',
			'default' => esc_html__( 'Hello {{receiver_name}}', 'taskbot' ),
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'required'  => array('email_odr_activity_seller','equals','1')
		),
		array(
			'id'        => 'order_activity_seller_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You have received a note from the {{sender_name}} on the ongoing task "{{task_name}}" against the order #{{order_id}}<br/>{{sender_comments}}<br/>You can login to take a quick action.<br/>{{login_url}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_odr_activity_seller','equals','1')
		),

    /* Seller Email on Refund request */
		array(
			'id'      => 'divider_order_seller_refund_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Seller refund', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_new_refund_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller refund request.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      => 'new_seller_refund_subject',
			'type'    => 'text',
			'title'   => esc_html__( 'Subject', 'taskbot' ),
			'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' => esc_html__( 'A new refund request received','taskbot'),
			'required'  => array('email_new_refund_seller','equals','1')

		),
		array(
			'id'      => 'divider_new_order_seller_refund_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
						{{buyer_name}} — To display the buyer name.<br>
						{{task_name}} — To display the task name.<br>
 						{{task_link}} — To display the task link.<br>
 						{{order_id}} — To display the order id.<br>
 						{{order_amount}} — To display the order amount.<br>
 						{{login_url}} — To display the login url.<br>
 						{{buyer_comments}} — To display the buyer comments.<br>'
		, 'taskbot' ),
		array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_new_refund_seller','equals','1')

		),
		array(
			'id'      	=> 'new_seller_refund_email_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_new_refund_seller','equals','1')

		),
		array(
			'id'        => 'new_seller_refund_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You have received a refund request from "{{buyer_name}}" against the order #{{order_id}}<br/>{{buyer_comments}}<br/>You can approve or decline the refund request.<br/>{{login_url}}.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_new_refund_seller','equals','1')

		),

    /* Seller Email on Refund Comment */
		array(
			'id'      => 'divider_order_refund_seller_comment_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Refund comment', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_refund_comment_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on refund comment .', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      => 'refund_seller_comment_subject',
			'type'    => 'text',
			'title'   => esc_html__( 'Subject', 'taskbot' ),
			'desc'    => esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' => esc_html__( 'A new comment on refund request','taskbot'),
			'required'  => array('email_refund_comment_seller','equals','1')

		),
		array(
			'id'      => 'divider_declined_order_seller_refund_information',
			'desc'    => wp_kses( __( '{{sender_name}} — To display the seller name.<br>
						{{receiver_name}} — To display the buyer name.<br>
						{{task_name}} — To display the task name.<br>
 						{{task_link}} — To display the task link.<br>
 						{{order_id}} — To display the order id.<br>
 						{{order_amount}} — To display the order amount.<br>
 						{{login_url}} — To display the login url.<br>
 						{{sender_comments}} — To display the sender comment.<br>'
		, 'taskbot' ),
		array(
				'a'       => array(
					'href'  => array(),
					'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_refund_comment_seller','equals','1')
		),
		array(
			'id'      => 'order_refund_seller_comment_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{receiver_name}},','taskbot'),
			'required'  => array('email_refund_comment_seller','equals','1')
		),
		array(
			'id'        => 'refund_seller_comment_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'The “{{sender_name}}” has left some comments on the refund request against the order #{{order_id}}<br/>{{sender_comments}}<br/>{{login_url}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_refund_comment_seller','equals','1')

		),

    /* Seller Email on Dispute Resolved */
		array(
			'id'      => 'divider_disputes_resolved_seller_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Dispute resolved seller', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_dispt_resolve_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on dispute resolve.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'disputes_resolved_seller_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Dispute resolved','taskbot'),
			'required'  => array('email_dispt_resolve_seller','equals','1'),
		),
		array(
			'id'    => 'divider_disputes_resolved_seller_information',
			'desc'  => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
 						{{task_name}} — To display the task name.<br>
						{{task_link}} — To display the task link.<br>
						{{order_id}} — To display the order id.<br>
						{{order_amount}} — To display the order amount.<br>
						{{login_url}} — To display the login url.<br>', 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_dispt_resolve_seller','equals','1')
		),
		array(
			'id'      	=> 'disputes_resolved_seller_email_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_dispt_resolve_seller','equals','1')
		),
		array(
			'id'        => 'disputes_resolved_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Congratulations!<br/>We have gone through the refund and dispute and resolved the dispute in your favor. We completed the task and the amount has been added to your wallet.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_dispt_resolve_seller','equals','1')

		),

		/* Buyer Email on Dispute Canceled */
		array(
			'id'      => 'divider_disputes_cancelled_seller_templates',
			'type'    => 'info',
			'title'   =>  esc_html__( 'Dispute resolved against you.', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_disputes_cancelled_seller',
			'type'     => 'switch',
			'title'    =>  esc_html__('Send email', 'taskbot'),
			'subtitle' =>  esc_html__('Email to seller on ceaceled/resolved dispute.', 'taskbot'),
			'default'  =>  true,
		),
		array(
			'id'      	=> 'disputes_cancelled_seller_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Dispute not in your favaour','taskbot'),
			'required'  => array( 'email_disputes_cancelled_seller','equals','1')

		),
		array(
			'id'      => 'divider_disputes_cancelled_seller_information',
			'desc'    => wp_kses( __( '{{seller_name}} — To display the seller name.<br>
 						{{task_name}} — To display the task name.<br>
						{{task_link}} — To display the task link.<br>
						{{order_id}} — To display the order id.<br>
						{{order_amount}} — To display the order amount.<br>
						{{login_url}} — To display the login url.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
			) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array( 'email_disputes_cancelled_seller','equals','1')
		),
		array(
			'id'      	=> 'disputes_cancelled_seller_email_greeting',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Greeting', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add text.', 'taskbot' ),
			'default' 	=> esc_html__( 'Hello {{seller_name}},','taskbot' ),
			'required'  => array( 'email_disputes_cancelled_seller','equals','1')

		),
		array(
			'id'        => 'disputes_cancelled_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Dispute resolve by admin but not in your favour.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents (dispute resolved)', 'taskbot' ),
			'required'  => array( 'email_disputes_cancelled_seller','equals','1')
		),

    /* Seller Email on Package */
		array(
			'id'      => 'divider_seller_packages_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Packages', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_package_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on purchase package.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'packages_seller_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Thank you for purchasing the package','taskbot'),
			'required'  => array('email_package_seller','equals','1')
		),
		array(
			'id'      => 'divider_seller_packages_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{order_id}} — To display the Order id.<br>
						{{order_amount}} — To display the Order amount.<br>
						{{package_name}} — To display the Package Name.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_package_seller','equals','1')
		),
		array(
			'id'      => 'packages_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
		),
		array(
			'id'        => 'package_seller_purchase_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Thank you for purchasing the package “{{package_name}}” You can now post a task and get orders.', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_package_seller','equals','1')
		),
		/* Seller Email on Project invitation */
		array(
			'id'      => 'divider_seller_project_invitation_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Project invitation', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_project_invitation_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on project invitation.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'project_invitation_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Project invitation','taskbot'),
			'required'  => array('email_project_invitation_seller','equals','1')
		),
		array(
			'id'      => 'divider_seller_project_invitation_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{buyer_name}} — To display the buyer name.<br>
						{{project_title}} — To display the project title.<br>
						{{project_link}} — To display the project link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_project_invitation_seller','equals','1')
		),
		array(
			'id'      => 'project_invitation_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_project_invitation_seller','equals','1')
		),
		array(
			'id'        => 'project_invitation_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You have received a project invitation from {{buyer_name}} Please click on the link below to view the project. {{project_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_project_invitation_seller','equals','1')
		),

		/* Seller Email on proposal decline */
		array(
			'id'      => 'divider_seller_proposal_decline_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Proposal decline', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_proposal_decline_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on proposal decline.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'proposal_decline_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Proposal decline','taskbot'),
			'required'  => array('email_proposal_decline_seller','equals','1')
		),
		array(
			'id'      => 'divider_seller_proposal_decline_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{buyer_name}} — To display the buyer name.<br>
						{{project_title}} — To display the project title.<br>
						{{proposal_link}} — To display the project link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_proposal_decline_seller','equals','1')
		),
		array(
			'id'      => 'proposal_decline_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_proposal_decline_seller','equals','1')
		),
		array(
			'id'        => 'proposal_decline_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Oho! your proposal on {{project_title}} has been rejected by {{buyer_name}}<br/>Please click on the button below to view the rejection reason.<br/>{{proposal_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_proposal_decline_seller','equals','1')
		),
		/* Seller Email on hired proposal */
		array(
			'id'      => 'divider_seller_proposal_hired_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Proposal hired', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_proposal_hired_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on hired proposal.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'proposal_hired_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Proposal hired','taskbot'),
			'required'  => array('email_proposal_hired_seller','equals','1')
		),
		array(
			'id'      => 'divider_seller_proposal_hired_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{buyer_name}} — To display the buyer name.<br>
						{{project_title}} — To display the project title.<br>
						{{project_link}} — To display the project link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_proposal_hired_seller','equals','1')
		),
		array(
			'id'      => 'proposal_hired_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_proposal_hired_seller','equals','1')
		),
		array(
			'id'        => 'proposal_hired_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Woohoo! {{buyer_name}} hired you for {{project_title}} project <br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_proposal_hired_seller','equals','1')
		),
		/* Seller Email on hire milestone */
		array(
			'id'      => 'divider_seller_milestone_hire_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Hire milestone', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_milestone_hire_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on hire milestone.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'milestone_hired_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Milestone hired','taskbot'),
			'required'  => array('email_milestone_hire_seller','equals','1')
		),
		array(
			'id'      => 'divider_seller_milestone_hired_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{buyer_name}} — To display the buyer name.<br>
						{{milestone_title}} — To display the milestone title.<br>
						{{project_title}} — To display the project title.<br>
						{{project_link}} — To display the project link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_milestone_hire_seller','equals','1')
		),
		array(
			'id'      => 'milestone_hire_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_milestone_hire_seller','equals','1')
		),
		array(
			'id'        => 'milestone_hire_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'Your milestone {{milestone_title}} of {{project_title}} has been approved <br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_milestone_hire_seller','equals','1')
		),
		/* Seller Email on milestone completed */
		array(
			'id'      => 'divider_seller_milestone_complete_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Milestone completed', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_milestone_complete_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on milestone complete.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'milestone_complete_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Milestone completed','taskbot'),
			'required'  => array('email_milestone_complete_seller','equals','1')
		),
		array(
			'id'      => 'divider_seller_milestone_complete_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{buyer_name}} — To display the buyer name.<br>
						{{milestone_title}} — To display the milestone title.<br>
						{{project_title}} — To display the project title.<br>
						{{project_link}} — To display the project link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_milestone_complete_seller','equals','1')
		),
		array(
			'id'      => 'milestone_complete_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_milestone_complete_seller','equals','1')
		),
		array(
			'id'        => 'milestone_complete_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You milestone {{milestone_title}} of {{project_title}} marked as completed by {{buyer_name}}<br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_milestone_complete_seller','equals','1')
		),
		/* Seller Email on milestone decline */
		array(
			'id'      => 'divider_seller_milestone_decline_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Milestone Decline', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'       => 'email_milestone_decline_seller',
			'type'     => 'switch',
			'title'    => esc_html__('Send email', 'taskbot'),
			'subtitle' => esc_html__('Email to seller on milestone decline.', 'taskbot'),
			'default'  => true,
		),
		array(
			'id'      	=> 'milestone_decline_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Milestone decline','taskbot'),
			'required'  => array('email_milestone_decline_seller','equals','1')
		),
		array(
			'id'      => 'divider_seller_milestone_decline_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{buyer_name}} — To display the buyer name.<br>
						{{milestone_title}} — To display the milestone title.<br>
						{{project_title}} — To display the project title.<br>
						{{project_link}} — To display the project link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
			'required'  => array('email_milestone_decline_seller','equals','1')
		),
		array(
			'id'      => 'milestone_decline_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
			'required'  => array('email_milestone_decline_seller','equals','1')
		),
		array(
			'id'        => 'milestone_decline_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses( __( 'You milestone {{milestone_title}} of {{project_title}} has been declined by {{buyer_name}}<br/>Please click on the button below to view the project.<br/>{{project_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
			'required'  => array('email_milestone_decline_seller','equals','1')
		),
		/* Seller Email on project refund request */
		array(
			'id'      => 'divider_seller_project_dispute_req_templates',
			'type'    => 'info',
			'title'   => esc_html__( 'Project dispute request', 'taskbot' ),
			'style'   => 'info',
		),
		array(
			'id'      	=> 'seller_project_dispute_req_email_subject',
			'type'    	=> 'text',
			'title'   	=> esc_html__( 'Subject', 'taskbot' ),
			'desc'    	=> esc_html__( 'Please add email subject.', 'taskbot' ),
			'default' 	=> esc_html__( 'Project refund request','taskbot'),
		),
		array(
			'id'      => 'divider_seller_project_dispute_req_information',
			'desc'    => wp_kses(__( '{{seller_name}} — To display the seller name.<br>
 						{{buyer_name}} — To display the buyer name.<br>
						{{project_title}} — To display the project title.<br>
						{{dispute_link}} — To display the dispute link.<br>'
						, 'taskbot' ),
			array(
					'a'       => array(
						'href'  => array(),
						'title' => array()
					),
					'br'      => array(),
					'em'      => array(),
					'strong'  => array(),
				) ),
			'title'     => esc_html__( 'Email setting variables', 'taskbot' ),
			'type'      => 'info',
			'class'     => 'dc-center-content',
			'icon'      => 'el el-info-circle',
		),
		array(
			'id'      => 'project_dispute_req_seller_email_greeting',
			'type'    => 'text',
			'title'   => esc_html__( 'Greeting', 'taskbot' ),
			'desc'    => esc_html__( 'Please add text.', 'taskbot' ),
			'default' => esc_html__( 'Hello {{seller_name}},','taskbot'),
		),
		array(
			'id'        => 'project_dispute_req_seller_mail_content',
			'type'      => 'textarea',
			'default'   => wp_kses(__( 'Project refund request received from {{buyer_name}} of {{project_title}} project <br/>Please click on the button below to view the refund request.<br/>{{dispute_link}}', 'taskbot'),
			array(
				'a'	=> array(
				'href'  => array(),
				'title' => array()
				),
				'br'      => array(),
				'em'      => array(),
				'strong'  => array(),
			)),
			'title'     => esc_html__( 'Email contents', 'taskbot' ),
		),
        );
        $seller_email	= apply_filters( 'taskbot_filter_seller_email_fields', $seller_email );
		return	$seller_email;
    }
}