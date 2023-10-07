<?php
/**
 * Set sellers orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_sellers')) {

    function taskbot_migration_sellers() {
		$title_array			= array(
			'Brand strategy and digital marketing',
			'Sports and e-sports marketing scripting',
			'Direct inward dialing',
			'Generic services',
			'Wavelength service',
			'Customer premises equipment',
			'Managed network service',
			'Outbound long distance service',
			'Redesign Shopify Dropshipping Store',
			'Automation To Drop Shipping For Website',
			'Manage Shopify E-commerce Store',
			'REST APi in react for for website'
		);
		$arg_freelancers    = array(
            'fields'            => 'ids',
            'post_type'         => array('sellers'),
			'post__in'			=> array(445,441,407,423,391,385),
            'post_status'       => 'any',
            'numberposts'       => -1
        );
		$freelancers    	= get_posts($arg_freelancers);
		foreach ($freelancers as $seller_id) {
			$tb_post_meta     			= get_post_meta($seller_id, 'tb_post_meta', true);
			$tb_post_meta['tagline']   = $title_array[array_rand($title_array)];
			update_post_meta($seller_id, 'tb_post_meta', $tb_post_meta);
		}
	}
}
/**
 * Set buyer orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_user_location')) {

    function taskbot_user_location() {
		$thum_array	= array();

		$arg_user    = array(
            'fields'            => 'ids',
            'post_type'         => array('buyers','sellers'),
            'post_status'       => 'any',
            'numberposts'       => -1,
        );
        $users    	= get_posts($arg_user);
		$countries	= array();
		if (class_exists('WooCommerce')) {
			$countries_obj   = new WC_Countries();
			$countries      = $countries_obj->get_allowed_countries('countries');
		}
		if( !empty($users) ){
            foreach($users as $profile_id){
				$country	= get_post_meta( $profile_id, 'country', true );
				if( empty($country) && !empty($countries)){
					update_post_meta( $profile_id, 'country', array_rand($countries));
				}
			}
		}
	}
}
/**
 * Remove task and product videos
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_update_product')) {
	function taskbot_update_product(){
		$tasks = get_posts(array(
			'post_type' 	=> 'product',
			'numberposts' 	=> -1,
			'post_status' 	=> 'any',
			//'post__in' 		=> array(1248,1236,202,186,1256,1270,1286,1282,207,190,175,1240,1223,183,192,1260,198,1290,197,1265,1230,201,1226,1244,1274,1278,760,1252,1178,718),
			'tax_query' 	=> array(
				array(
					'taxonomy' 	=> 'product_type',
					'field' 	=> 'slug', 
					'terms' 	=> 'tasks',
					'operator' 	=> 'IN'
				)
			)
		));
		$project_contetns	= '
		<p>Nulla nisl sagittis, sed ulputate consequat pharetra. Leo mollis amet, duis elite musta nibhae quisque uate phaslus necerat scelerse. Sed turpis ullamcorper sed sit a vel pharetra porttitor odio non elit diam cursues Siet non, est curatur odion netus idsit enim consectur hendret mi, eget purus odio pellentes suspende. Sit nunc arcu vestibuum etarcu. Cursus fringilla commodo id aliquam commodo nisle suspendisse aemetneta auctor nonate volutpat ante est tempus enim ipsam voluptatem quiaptas sit aspernatur aut odit aute fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia dolor sit amet consectetur, adipisci velit, sed quia non numquam eiustam eidi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
		<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
		<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem antium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.</p>
		<ul>
			<li>Cupiditate non provident, similique sunt in culpame magni dolores eos qui ratione</li>
			<li>Quiofficia deserunt mollitia animi id est laborum etalorum voluptatem sequite</li>
			<li>Et harum quidem rerum facilis expedita porero quisquam est, qui dolorem ipsum quia</li>
			<li>Nam libero tempore cum soluta dolor sit amet consectetur adipisci velitem</li>
		</ul>
		<p>Nemo enim ipsam voluptatem quiaptas sit aspernatur aut odit aut fugit, sed quia consequuntur magniores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia doluor sit amet consectetur, adipisci velit, sed quia non numquam eiustam modi tempora incidunt ut labore etolore magnam aliquam quaerat voluptatem.</p>
		<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
		<p>Nemo enim ipsam voluptatem quiaptas sit aspernatur aut odit aut fugit, sed quia consequuntur magniores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia doluor sit amet consectetur, adipisci velit, sed quia non numquam eiustam modi tempora incidunt ut labore etolore magnam aliquam quaerat voluptatem.</p>
		<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
		';
		$task_contetns	= '
		<p>Nulla nisl sagittis, sed ulputate consequat pharetra. Leo mollis amet, duis elite musta nibhae quisque uate phaslus necerat scelerse. Sed turpis ullamcorper sed sit a vel pharetra porttitor odio non elit diam cursues Siet non, est curatur odion netus idsit enim consectur hendret mi, eget purus odio pellentes suspende. Sit nunc arcu vestibuum etarcu. Cursus fringilla commodo id aliquam commodo nisle suspendisse aemetneta auctor nonate volutpat ante est tempus enim ipsam voluptatem quiaptas sit aspernatur aut odit aute fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia dolor sit amet consectetur, adipisci velit, sed quia non numquam eiustam eidi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
		<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
		<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem antium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.</p>
		<ul>
			<li>Cupiditate non provident, similique sunt in culpame magni dolores eos qui ratione</li>
			<li>Quiofficia deserunt mollitia animi id est laborum etalorum voluptatem sequite</li>
			<li>Et harum quidem rerum facilis expedita porero quisquam est, qui dolorem ipsum quia</li>
			<li>Nam libero tempore cum soluta dolor sit amet consectetur adipisci velitem</li>
		</ul>
		<h3>What more can expect</h3>
		<p>Nemo enim ipsam voluptatem quiaptas sit aspernatur aut odit aut fugit, sed quia consequuntur magniores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia doluor sit amet consectetur, adipisci velit, sed quia non numquam eiustam modi tempora incidunt ut labore etolore magnam aliquam quaerat voluptatem.</p>
		<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
		<p>Nemo enim ipsam voluptatem quiaptas sit aspernatur aut odit aut fugit, sed quia consequuntur magniores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia doluor sit amet consectetur, adipisci velit, sed quia non numquam eiustam modi tempora incidunt ut labore etolore magnam aliquam quaerat voluptatem.</p>
		<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
		';
		foreach($tasks as $task ){
			$task_id		= $task->ID;
			delete_post_meta($task_id,'_product_video');
			$task_data = array(
				'ID'           => $task_id,
				'post_content' => $task_contetns
			);
			wp_update_post( $task_data );
		}

		$projects = get_posts(array(
			'post_type' 	=> 'product',
			'numberposts' 	=> -1,
			'post_status' 	=> 'any',
			//'post__in' 		=> array(1248,1236,202,186,1256,1270,1286,1282,207,190,175,1240,1223,183,192,1260,198,1290,197,1265,1230,201,1226,1244,1274,1278,760,1252,1178,718),
			'tax_query' 	=> array(
				array(
					'taxonomy' 	=> 'product_type',
					'field' 	=> 'slug', 
					'terms' 	=> 'projects'
				)
			)
		));
		foreach($projects as $project ){
			$project_id			= $project->ID;
			$project_meta		= get_post_meta( $project_id, 'tb_project_meta', true);
			if( !empty($project_meta['video_url']) ){
				unset($project_meta['video_url']);
			}
			update_post_meta( $project_id, 'tb_project_meta', $project_meta);
			$project_data = array(
				'ID'           => $project_id,
				'post_content' => $project_contetns
			);
			wp_update_post( $project_data );

		}

	}
}
/**
 * Set profile image
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_profile_image')) {

    function taskbot_migration_profile_image() {
		$thum_array	= array();

		for ($x = 1; $x <= 3; $x++) {
			$thum_array[$x]	= $x;
		}

		$arg_freelancers    = array(
            'fields'            => 'ids',
            'post_type'         => array('sellers'),
            'post_status'       => 'any',
            'numberposts'       => -1
        );
        $freelancers    = get_posts($arg_freelancers);
        
        if( !empty($freelancers) ){
            foreach($freelancers as $freelancer){
				$post_author	= get_post_field( 'post_author', $freelancer );
				$buyer_id		= get_user_meta( $post_author, '_linked_profile_buyer', true );
				$thum_id		= array_rand($thum_array,1);
				if( !empty($freelancer) ){
					set_post_thumbnail($freelancer,$thum_id);
				}
				if( !empty($buyer_id) ){
					set_post_thumbnail($buyer_id,$thum_id);
				}
				unset($thum_array[$thum_id]);
			}
		}
	}
}

/**
 * Set seller orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_seller_packages')) {

    function taskbot_migration_seller_packages() {
		global $woocommerce, $taskbot_settings;
		$arg_freelancers    = array(
            'fields'            => 'ids',
            'post_type'         => array('sellers'),
            'post_status'       => 'any',
            'numberposts'       => -1
        );
        $freelancers    	= get_posts($arg_freelancers);
		$args3 = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'skills',
		);
		$skills_terms 	= get_terms( $args3 );
		$skills_term	= array();
		foreach ( $skills_terms as $skill ) {
			$skills_term[$skill->term_id]	= !empty($skill->term_id) ? $skill->term_id : 0;
		}

		$args4 = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'languages',
		);
		$languages_terms 	= get_terms( $args4 );
		$languages_term	= array();
		foreach ( $languages_terms as $lang ) {
			$languages_term[$lang->term_id]	= !empty($lang->term_id) ? $lang->term_id : 0;
		}

        if( !empty($freelancers) ){
            foreach($freelancers as $freelancer){
				// $post_author	= get_post_field( 'post_author', $freelancer );
				// $post_author	= !empty($post_author) ? intval($post_author) : 0;

				// $order_details	= get_post_meta( 1406, 'cus_woo_product_data', true );
				// $order_details	= !empty($order_details) ? $order_details : array();

				// taskbot_update_packages_data(1406,$order_details,$post_author);
				$skilllevel			= array_rand($skills_term,7);
				wp_set_object_terms( $freelancer, $skilllevel, 'skills' );

				$languagelevel			= array_rand($languages_term,3);
				wp_set_object_terms( $freelancer, $languagelevel, 'languages' );
			}
		}
	}
}
/**
 * Set seller orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_update_billing_details')) {

    function taskbot_update_billing_details($user_id) {
		$user = get_user_by( 'ID', $user_id );
		$country	= array(
			'35801' => 'US',
			'99501' => 'US',
			'90001' => 'US',
			'19901' => 'US',
			'20001' => 'US',
			'32501' => 'US',
			'33124' => 'US',
			'32801' => 'US',
			'35801' => 'US',
			'99501' => 'US',
			'90001' => 'US',
			'19901' => 'US',
			'20001' => 'US',
			'32501' => 'US',
			'33124' => 'US',
			'32801' => 'US',
			'62701' => 'US',
			'46201' => 'US'
		);
		
		$country_key	= array_rand($country,1);
		$phone_numbers	= array('626-271-3749','315-407-2909','412-858-7393');
		$phone_key		= array_rand($phone_numbers);
		$cities_array	= array('Springhampton','Southley','Hallborough City','East Passburg','Backwich');
		$cities_key		= array_rand($cities_array);
		$address_array	= array('xyz Heritage Drive Homestead, FL 33030','29 Andover Street Oxon Hill, MD 20745','765 Fairview Ave. Tampa, FL 33604');
		$address_key	= array_rand($address_array);
		$list = array(
            'billing_first_name'    => $user->first_name,
            'billing_last_name'    	=> $user->last_name,
            'billing_company'    	=> 'AmentoTech',
            'billing_address_1'    	=> $address_array[$address_key],
            'billing_country'   	=> 'US',
            'billing_city'    		=> $cities_array[$cities_key],
            'billing_postcode'    	=> $country_key,
            'billing_phone'    		=> $phone_numbers[$phone_key],
			'billing_email'    		=> $user->user_email,
        );
		foreach ($list as $meta_key => $meta_value ) {
            update_user_meta( $user_id,$meta_key, sanitize_text_field( $meta_value ) );
        }
	}
}
/**
 * Set seller orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_update_seller_packages')) {

    function taskbot_update_seller_packages($post_author) {
		global $woocommerce;
		$woocommerce->cart->empty_cart();
		$wallet_amount				= rand(5000,9500);
		$product_id                 = taskbot_buyer_wallet_create();
		$user_id                    = $post_author;
		$cart_meta                  = array();
		$cart_meta['wallet_id']     = $product_id;
		$cart_meta['product_name']  = get_the_title($product_id);
		$cart_meta['price']         = $wallet_amount;
		$cart_meta['payment_type']  = 'wallet';
		$cart_data  = array(
			'wallet_id' 	=> $product_id,
			'cart_data' 	=> $cart_meta,
			'price'     	=> $wallet_amount,
			'payment_type'  => 'wallet'
		);
		$woocommerce->cart->empty_cart();
		$cart_item_data = apply_filters('taskbot_update_package_cart_data',$cart_data);
		WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
		taskbot_place_order($post_author,'buyer-wallet');
	}
}

/**
 * Set buyer orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_subtasks')) {

    function taskbot_migration_subtasks($user_id) {
		
		$subtask_title_array	= array(
			'Brand strategy and digital marketing'	=> 'Excepteur sint occaecat cupidatat non proident, sunt in culpa quite officia',
			'Migration coding facility'				=> 'Adipisicing eliate adoems teme atpoir likuie norie acima amtetams.',
			'Wireless Internet'						=> 'Sed ut perspiciatis unde omnis iste natus errorem',
			'Sports and e-sports marketing scripting'	=> 'Fugiat nulla pariatur excepteur sint occaecat cupidatat non proident',
			'Direct inward dialing'						=> 'Laboris nisi ut aliquip ex ea commodo consequat',
			'Generic services'							=> 'Dolore eu fugiat nulla pariatur occaecat cupidatat non proident',
			'Wavelength service'						=> 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum',
			'Customer premises equipment' 				=> 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum',
			'Managed network service' 					=> 'Consectetur adipisicing elit sed do eiusmod tempore',
			'Outbound long distance service'			=> 'Fugiat nulla pariatur excepteur sint occaecat cupidatat non proident'
		);	
		foreach($subtask_title_array as $key => $val ){
			$subtask_price			= rand(9,168);
			$taskbot_post_data = array(
				'post_title'    => wp_strip_all_tags($key),
				'post_content'  => $val,
				'post_status'   => 'publish',
				'post_type'     => 'product',
				'post_author'   => $user_id,
				'meta_input'    => array(
					'_regular_price'    => $subtask_price,
					'_price'            => $subtask_price,
				),
			);
			$subtask_id = wp_insert_post( $taskbot_post_data );
			update_post_meta($subtask_id, '_regular_price', $subtask_price);
			update_post_meta( $subtask_id, '_price', $subtask_price );
			wp_set_object_terms( $subtask_id, 'subtasks', 'product_type', false );
			update_post_meta( $subtask_id, '_virtual', 'yes' );
		}
		
	}
}
/**
 * Set buyer orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_tasks')) {

    function taskbot_migration_tasks($user_id,$post_id) {
		$old_post_post_id	= 1290;
		$post_contetns		= 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi id est laborum et dolorum fuga rerum faciliste.

		Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam etmiaut officiis debitis auit rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint etemolestiae nocusandae Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aeut perferendis doloribus asperiores repellate.
		
		<h3>What more can expect</h3>
		Fugiat nulla pariatur excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque udantium totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt plicabon Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magniolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qolorem ipsum quia dolor sit amet ectetur.
		
		<ul class="tk-mainlistv2">
			<li> Consectetur adipisicing elit sed do eiusmod tempore</li>
			<li> Incididunt ut labore et dolore magna aliqua</li>
			<li> Ut enim ad minim veniam quis nostrud exercitation ullamco</li>
			<li> Laboris nisi ut aliquip ex ea commodo consequat</li>
			<li> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum</li>
			<li> Dolore eu fugiat nulla pariatur occaecat cupidatat non proident</li>
		</ul>
		
		Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Ut enim ad minim veniam, quistane nostrued exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit inate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa quite officia deserunt mollit anim id est laborum. Sed ut perspiciatis.';//get_post_field('post_content',$old_post_post_id );
		$post_array	= array(
			'post_author'	=> $user_id,
			'post_contetns'	=> $post_contetns,
			'ID'			=> $post_id
		);
		wp_update_post($post_array);
		if($old_post_post_id != $post_id ){
		
			$taskbot_product_plans	= get_post_meta( $old_post_post_id, 'taskbot_product_plans',true );
			$product_plans			= !empty($taskbot_product_plans) ? $taskbot_product_plans : array();

			if(!empty($taskbot_product_plans) && is_array($taskbot_product_plans) ){
				$counter	= 1;
				foreach($taskbot_product_plans as $key => $taskbot_product_plan ){
					if( !empty($counter)){
						if( $counter == 1  ){
							$price	= rand ( 20 , 60 );
							update_post_meta( $post_id, '_min_price', floatval($price) );
							update_post_meta( $post_id, '_regular_price', floatval($price) );
							update_post_meta( $post_id, '_price', floatval($price) );
							$product_plans[$key]['price']	= $price;
						} else if( $counter == 2  ){
							$product_plans[$key]['price']	= rand ( 65 , 150 );
						} else if( $counter == 3  ){
							$price	=  rand ( 200 , 300 );
							$product_plans[$key]['price']	= $price;
							update_post_meta( $post_id, '_max_price', floatval($price) );
						} 
						$counter++;
					}
				}
			}
			update_post_meta( $post_id, 'taskbot_product_plans', $product_plans);
			
			$subtasks = get_posts(array(
				'author'        =>  $user_id,
				'post_type' 	=> 'product',
				'numberposts' 	=> 5,
				'fields'        => 'ids',
				'orderby' 		=> 'rand',
				'tax_query' 	=> array(
					array(
						'taxonomy' 	=> 'product_type',
						'field' 	=> 'slug', 
						'terms' 	=> 'subtasks'
					)
				)
			));
			$video_array	= array(
				'https://www.youtube.com/watch?v=8OCo08d3VJA',
				'https://www.youtube.com/watch?v=EgeOgt6nqcU',
				'https://www.youtube.com/watch?v=mPWo_r3FAic',
				'https://www.youtube.com/watch?v=nc5Lj90BzSQ',
				'https://www.youtube.com/watch?v=D0a0aNqTehM',
			);
			$video_k 	= array_rand($video_array);
			$videos 	= $video_array[$video_k];
			update_post_meta( $post_id, '_product_video',$videos );
			update_post_meta( $post_id, 'taskbot_product_subtasks',$subtasks );
			$taskbot_service_faqs	= get_post_meta( $old_post_post_id, 'taskbot_service_faqs',true );
			update_post_meta( $post_id, 'taskbot_service_faqs',$taskbot_service_faqs );

			$categories     	= get_the_terms($old_post_post_id, 'product_tag');
			$tb_product_tags	= array();
			if( !empty($categories) ){
				foreach ($categories as $category) {
					$tb_product_tags[]  = $category->slug;
				}
				wp_set_object_terms($post_id, $tb_product_tags, 'product_tag');
			}
		}

	}
}
/**
 * Set buyer orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_task_completed')) {

    function taskbot_migration_task_completed($order_id) {
			$user_id	= get_post_meta( $order_id, 'buyer_id', true );
			$gmt_time	= current_time( 'mysql', 1 );
			$task_id	= get_post_meta( $order_id, 'task_product_id', true );
			$task_id	= !empty($task_id) ? $task_id : 0;
			$rating		= rand(4,5);
			$rating_titles		= array(
				0 => 'Really a magician, He knows everything on his skills',
				1 => 'Really appreciate her work she is fast indeed',
				3 => 'Its been a great pleasure working with you',
				4 => 'Amazing skills, She knows everything on her skills'
			);
			$rating_k		= rand(0,4);
			$rating_title	= !empty($rating_titles[$rating_k]) ? $rating_titles[$rating_k] : 'Really appreciate her work she is fast indeed';
			$rating_details	= 'Dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris neim utnae aliquip ex ea commodo consequat. Duis aute iruretate dolor in reprehenderit in voluptate veliten essemae cillum dolore ut aliquip ex ea commodo consequat.';
			taskbot_complete_task_ratings($order_id,$task_id,$rating,$rating_title,$rating_details,$user_id);
			update_post_meta( $order_id, '_task_status' , 'completed');
			update_post_meta( $order_id, '_task_completed_time', $gmt_time );
		
		

	}
}

/**
 * Update task rating
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_task_ratings')) {

    function taskbot_migration_task_ratings() {
		$comments_headings	= array("
		Excellent services for fast delivery",
		"It is a very excellent site in providing miniature services and helps the customer",
		"The site runs smoothly and has many optional features",
		"Extremely professional staff.",
		"I provided him with what I needed and he gave proficient suggestions",
		"Very good and I liked it very much,,Yes it is safe and you do need a bank account",
		"Not much satisfied but overall they're amazing in service",
		"Everything as expected; my go to site for SSL certificates",
		"Easy order, fast renewal, good price - perfect as usual",
		"Very straightforward, easy to use interface",
		"Service is fine, pricing is good",
		"Always easy to get what I need in a timely manner",
		"Very good support team, prompt replies and detailed answers",
		"Long time customer; for the few times I had to contact support",
		"The questions were always quickly answeredgreat customer experience"
	);
	
		$tasks = get_posts(array(
			'post_type' 	=> 'product',
			'numberposts' 	=> -1,
			'post__in' 		=> array(1248,1236,202,186,1256,1270,1286,1282,207,190,175,1240,1223,183,192,1260,198,1290,197,1265,1230,201,1226,1244,1274,1278,760,1252,1178,718),
			'tax_query' 	=> array(
				array(
					'taxonomy' 	=> 'product_type',
					'field' 	=> 'slug', 
					'terms' 	=> 'tasks'
				)
			)
		));
		
		foreach($tasks as $task ){
			$task_id		= $task->ID;
			taskbot_product_rating($task_id);
		}
	}
}

/**
 * Set buyer orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_task_hired')) {

    function taskbot_migration_task_hired($user_id) {
		global $woocommerce;
		taskbot_update_seller_packages($user_id);
		$num_of_post	= 1;
		$tasks = get_posts(array(
			'post_type' 	=> 'product',
			'numberposts' 	=> $num_of_post,
			'post__in' 		=> array(1286),
			'orderby' 		=> 'rand',
			'tax_query' 	=> array(
				array(
					'taxonomy' 	=> 'product_type',
					'field' 	=> 'slug', 
					'terms' 	=> 'tasks'
				)
			)
		));
		if( !empty($tasks) ){
			foreach($tasks as $task ){
				$product_id				= $task->ID;
				$seller_id      		= get_post_field( 'post_author', $product_id );
				$taskbot_subtask        = get_post_meta($product_id, 'taskbot_product_subtasks', TRUE);
				$taskbot_subtask        = !empty($taskbot_subtask) ? $taskbot_subtask : array();
				$taskbot_plans_values   = get_post_meta($product_id, 'taskbot_product_plans', TRUE);
				$taskbot_plans_values   = !empty($taskbot_plans_values) ? $taskbot_plans_values : array();
				$task					= array_rand($taskbot_plans_values);
				$plans	        		= !empty($taskbot_plans_values) ? $taskbot_plans_values : array();
				$taskbot_subtask        = get_post_meta($product_id, 'taskbot_product_subtasks', TRUE);
				$taskbot_subtask        = !empty($taskbot_subtask) ? $taskbot_subtask : array();
				$count_sub_task			= !empty($taskbot_subtask) && is_array($taskbot_subtask) ? count($taskbot_subtask) : 0;
				$subtasks				= array();
				if( !empty($count_sub_task) && $count_sub_task > 2 ){
					$index_1	= rand(0,$count_sub_task);
					$index_2	= rand(0,$count_sub_task);
					$subtasks[]	= !empty($taskbot_subtask[$index_1]) ? $taskbot_subtask[$index_1] : 0;
					$subtasks[]	= !empty($taskbot_subtask[$index_2]) ? $taskbot_subtask[$index_2] : 0;
				}

				$user_balance   = !empty($user_id) ? get_user_meta( $user_id, '_buyer_balance',true ) : '';
				$plan_price     = !empty($plans[$task]['price']) ? $plans[$task]['price'] : 0;
				$total_price    = $plan_price;

				foreach($subtasks as $key => $subtask_id){
					$single_price   = get_post_meta( $subtask_id, '_regular_price',true );
					$single_price   = !empty($single_price) ? $single_price : 0;
					$total_price    = $total_price + $single_price;
				}

				if ( class_exists('WooCommerce') ) {
					$woocommerce->cart->empty_cart(); 
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
					$cart_item_data = $cart_data;
					WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);

					if( !empty($subtasks) ){
						foreach($subtasks as $subtasks_id){
							WC()->cart->add_to_cart( $subtasks_id, 1 );
						}
					}
					if(!empty($user_balance) && $user_balance >= $total_price ){
						$order_id	= taskbot_place_order($user_id,'task-wallet');
						if( !empty($order_id) ){
							taskbot_payment_complete($order_id);
							update_post_meta( $order_id, 'seller_id', $seller_id );
							update_post_meta( $order_id, 'buyer_id', $user_id );
							$subtask_post = array(
								'post_author'   => $user_id,
								'ID'			=> $order_id
							);
							wp_update_post( $subtask_post );
						}
					}
				}
			}
		}
	}
}

if (!function_exists('taskbot_migration_post_images')) {

    function taskbot_migration_post_images() {
		$arg_posts    = array(
            'fields'            => 'ids',
            'post_type'         => array('post'),
            'post_status'       => 'any',
            'numberposts'       => -1
        );
		$all_posts    = get_posts($arg_posts);
		if( !empty($all_posts) ){
			$counter_start	= 3574;
            foreach($all_posts as $post_id){
				set_post_thumbnail( $post_id,  $counter_start );
				$counter_start	= $counter_start+1;
			}
		}
	}
}
/**
 * Set sellers orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_sellers')) {

    function taskbot_migration_sellers() {
		$arg_freelancers    = array(
            'fields'            => 'ids',
            'post_type'         => array('sellers'),
            'post_status'       => 'any',
            'numberposts'       => -1
        );
		$args3 = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'skills',
		);
		$skills_terms 	= get_terms( $args3 );
		$skills_term	= array();
		foreach ( $skills_terms as $skill ) {
			$skills_term[$skill->term_id]	= !empty($skill->term_id) ? $skill->term_id : 0;
		}
        $freelancers    = get_posts($arg_freelancers);
        if( !empty($freelancers) ){
            foreach($freelancers as $profile_id){	
				$country	= array(
					'35801' => 'US',
					'99501' => 'US',
					'90001' => 'US',
					'19901' => 'US',
					'20001' => 'US',
					'32501' => 'US',
					'33124' => 'US',
					'32801' => 'US',
					'35801' => 'US',
					'99501' => 'US',
					'90001' => 'US',
					'19901' => 'US',
					'20001' => 'US',
					'32501' => 'US',
					'33124' => 'US',
					'32801' => 'US',
					'62701' => 'US',
					'46201' => 'US'
				);
				
				$country_key	= array_rand($country,1);
				$response   = taskbot_process_geocode_info($country_key,'US');
				if( !empty($response) ) {
					update_post_meta($profile_id,'location', $response );
					update_post_meta($profile_id,'_longitude',$response['lng']);
					update_post_meta($profile_id,'_latitude',$response['lat']);
					update_post_meta( $profile_id, 'country', 'US' );
        			update_post_meta( $profile_id, 'zipcode', $country_key );
					
					$skilllevel			= array_rand($skills_term,7);
					wp_set_object_terms( $project_id, $skilllevel, 'skills' );
				}
			}
		}
	}
}
/**
 * Set buyer orders
 *
 * @return
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 */
if (!function_exists('taskbot_migration_buyer')) {

    function taskbot_migration_buyer() {
		$thum_array	= array();

		$arg_buyers    = array(
            'fields'            => 'ids',
            'post_type'         => array('buyers'),
            'post_status'       => 'any',
            'numberposts'       => -1,
			'meta_key' 			=> '_task_orders',
        );
        $buyers    = get_posts($arg_buyers);
        
        if( !empty($buyers) ){
            foreach($buyers as $buyer){
				$post_author	= get_post_field( 'post_author', $buyer );
				$task_orders	= get_post_meta( $buyer, '_task_orders', true );
				if( !empty($task_orders)){

					$task_orders	= !empty($task_orders) ? explode(',',$task_orders) : array();
					foreach($task_orders as $task_order){
						$subtask_post = array(
							'post_author'   => $post_author,
							'ID'			=> $task_order
						);
						wp_update_post( $subtask_post );
						$order_status	= get_post_meta( $task_order, '_task_status',true );
						$product_data	= get_post_meta( $task_order, 'cus_woo_product_data',true );
						$order_status	= !empty($order_status) ? $order_status : '';
						$task_id		= get_post_meta( $task_order, 'task_product_id', true );
						$task_id		= !empty($task_id) ? intval($task_id) : 0;
						$seller_id		= get_post_field( 'post_author', $task_id );
						$seller_id		= !empty($seller_id) ? intval($seller_id) : 0;
						$linked_profile = taskbot_get_linked_profile_id($post_author, '', 'buyers');						
						$product_data['seller_id']	= $seller_id;
						$product_data['buyer_id']	= $post_author;
						update_post_meta( $task_order, 'cus_woo_product_data', $product_data );
						update_post_meta( $task_order, 'seller_id', $seller_id );
						update_post_meta( $task_order, 'buyer_id', $post_author );
						
						if( !empty($order_status) && $order_status === 'completed'){
							$user_details		= get_userdata($post_author);
							$rating_id			= get_post_meta( $task_order, '_rating_id', true );
							$rating_id			= !empty($rating_id) ? intval($rating_id) : 0;
    						$user_profiel_name  = taskbot_get_username($linked_profile);
							$comment_data		= array(
								'comment_ID'		   => $rating_id,
								'comment_author'       => $user_profiel_name,
								'comment_author_email' => $user_details->user_email,
								'user_id'              => $post_author,
							);
							wp_update_comment( $comment_data );							
						} else if( !empty($order_status) && $order_status === 'cancelled'){
							update_post_meta( $task_order, '_task_cancelled_by', $post_author );
						} 
					}
					delete_post_meta($buyer,'_task_orders');
				}
			}
		}
	}
}
/**
 * @init            User migration profile data
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_migration_profile_data')) {

    function taskbot_migration_profile_data() {
		
		$seller_types	= array();
		$english_level	= array();
		$country_array	= array(
			//Australia
				'2601' => 'AU',
				'2602' => 'AU',
				'2914' => 'AU',
				'2617' => 'AU',
				'2905' => 'AU',
				'2612' => 'AU',
				'2913' => 'AU',
				'2606' => 'AU',
				'2608' => 'AU',
				'2611' => 'AU',
			//United kingdom
				'CT3' => 'GB',
				'LE14' => 'GB',
				'BA8' => 'GB',
				'WR10' => 'GB',
				'MK77' => 'GB',
				'NW8' => 'GB',
				'CB22' => 'GB',
				'EX22' => 'GB',
				'B27' => 'GB',
				'CT18' => 'GB',
				'CT3' => 'GB',
				'LE14' => 'GB',
				'BA8' => 'GB',
				'WR10' => 'GB',
				'MK77' => 'GB',
				'NW8' => 'GB',
				'CB22' => 'GB',
				'EX22' => 'GB',
				'B27' => 'GB',
				'CT18' => 'GB',
			//united state	
				'35801' => 'US',
				'99501' => 'US',
				'90001' => 'US',
				'19901' => 'US',
				'20001' => 'US',
				'32501' => 'US',
				'33124' => 'US',
				'32801' => 'US',
				'35801' => 'US',
				'99501' => 'US',
				'90001' => 'US',
				'19901' => 'US',
				'20001' => 'US',
				'32501' => 'US',
				'33124' => 'US',
				'32801' => 'US',
				'62701' => 'US',
				'46201' => 'US',
			
			);
		$args = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'tb_seller_type',
		);
		$terms = get_terms( $args );
		foreach ( $terms as $type ) {
			$seller_types[$type->term_id]	= !empty($type->term_id) ? $type->term_id : 0;
		}
		
		$args2 = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'tb_english_level',
		);
		$english_terms = get_terms( $args2 );
		foreach ( $english_terms as $type ) {
			$english_level[$type->term_id]	= !empty($type->term_id) ? $type->term_id : 0;
		}
		

		$arg_freelancers    = array(
            'fields'            => 'ids',
            'post_type'         => array('sellers'),
            'post_status'       => 'any',
            'numberposts'       => -1
        );
        $freelancers    = get_posts($arg_freelancers);
        $tb_post_data	= get_post_meta( 373, 'tb_post_meta',true );
		$education		= !empty($tb_post_data['education']) ? $tb_post_data['education'] : array();
        if( !empty($freelancers) ){
            foreach($freelancers as $profile_id){
				$user_id		= get_post_field( 'post_author', $profile_id );
				$tb_post_meta	= get_post_meta( $profile_id, 'tb_post_meta',true );
				$tb_post_meta	= !empty($tb_post_meta) ? $tb_post_meta : array();
				$tb_post_meta['education']  = $education;
    			update_post_meta( $profile_id, 'tb_post_meta', $tb_post_meta );
				$level			= array_rand($english_level,1);
				$seller			= array_rand($seller_types,1);
				$hourly_rate	= rand(5,100);
				$zipcode		= array_rand($country_array,1);
				$country		= !empty($zipcode) && !empty($country_array[$zipcode]) ? $country_array[$zipcode] : 'US';
				update_post_meta( $user_id, 'first_name', $tb_post_meta['first_name'] );
        		update_post_meta( $user_id, 'last_name', $tb_post_meta['last_name'] );

				wp_set_object_terms( $profile_id, intval( $level ), 'tb_english_level' );
				wp_set_object_terms( $profile_id, intval( $seller ), 'tb_seller_type' );
				update_post_meta( $profile_id, 'tb_hourly_rate', $hourly_rate );

			}
		}
	}
}

/**
 * @init            User project migration 
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_migration_projects')) {

    function taskbot_migration_projects() {
		$taskbot_args 	= array(
            'post_type'         => 'product',
            'post_status'       => array('publish'),
            'numberposts'       => -1,
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
		$projects	= get_posts($taskbot_args);
		if( !empty($projects) ){
			foreach($projects as $project){
				$project_id		= $project->ID;
				$project_meta	= get_post_meta( $project_id, 'tb_project_meta',true);
				$profile_id		= !empty($project_meta['profile_id']) ? intval($project_meta['profile_id']) : 0;
				$user_id		= get_post_field( 'post_author',$profile_id);
				// update project
				$project_arg 		= array(
					'ID' 			=> $project_id,
					'post_author' 	=> $user_id,
				);
				wp_update_post( $project_arg );
				
				// update order
				$order_arg	= array(
					'posts_per_page'    => -1,
					'post_type'         => array( 'shop_order'),
					'orderby'           => 'ID',
					'order'             => 'DESC',
					'post_status'       => 'any',
					'suppress_filters'  => false,
					'meta_query'    	=> array( 'relation' => 'AND', array( 'key' => 'project_id','value' => $project_id,'compare' => '=')
					)
				);
				$orders		= get_posts($order_arg);
				if (!empty($orders)) {
					foreach ($orders as $order) {
						$order_id		= $order->ID;
						$project_arg 	= array( 'ID' => $order_id, 'post_author' => $user_id);
						wp_update_post( $project_arg );

						update_post_meta( $order_id, 'buyer_id',$user_id );
						update_post_meta( $order_id, '_customer_user',$user_id );

						$cus_woo_product_data	= get_post_meta( $order_id, 'cus_woo_product_data',true );
						$cus_woo_product_data	= !empty($cus_woo_product_data) ? $cus_woo_product_data : array();
						$cus_woo_product_data['buyer_id']	= $user_id;
						update_post_meta( $order_id, 'cus_woo_product_data',$cus_woo_product_data );
					}
				}

				// update proposal
				$proposal_arg	= array(
					'posts_per_page'    => -1,
					'post_type'         => array( 'proposals'),
					'orderby'           => 'ID',
					'order'             => 'DESC',
					'post_status'       => 'any',
					'suppress_filters'  => false,
					'meta_query'    	=> array( 'relation' => 'AND', array( 'key' => 'project_id','value' => $project_id,'compare' => '=')
					)
				);
				$proposals		= get_posts($proposal_arg);
				if( !empty($proposals) ){
					foreach($proposals as $proposal){
						update_post_meta( $proposal->ID, 'buyer_id',$user_id );
						// update dispute
						$dispute_id	= get_post_meta( $proposal->ID, 'dispute_id',true );
						$dispute_id	= !empty($dispute_id) ? intval($dispute_id) : 0;
						$sender_type= get_post_meta( $dispute_id, '_sender_type',true );
						if( !empty($sender_type) && $sender_type === 'buyers' ){
							$dispute_arg 	= array(
								'ID' 			=> $dispute_id,
								'post_author' 	=> $user_id,
							);
							wp_update_post( $dispute_arg );
							update_post_meta( $dispute_id, '_send_by',$user_id );
							update_post_meta( $dispute_id, '_buyer_id',$user_id );
							$resolved_by	= get_post_meta( $proposal->ID, 'resolved_by',true );
							if( !empty($resolved_by) && $resolved_by === 'buyers' ){
								update_post_meta( $dispute_id, 'winning_party',$user_id );
							}
						}
					}
				}
			}
		}
	}
}

/**
 * @init            User proposal migration 
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_migration_proposals')) {

    function taskbot_migration_proposals() {
		$taskbot_args 	= array(
            'post_type'         => 'proposals',
            'post_status'       => 'any',
            'numberposts'       => -1,
            'orderby'           => 'date',
            'order'             => 'DESC'
        );
		$proposals	= get_posts($taskbot_args);
		if( !empty($proposals) ){
			foreach($proposals as $proposal){
				$proposal_id	= $proposal->ID;
				$proposal_meta	= get_post_meta( $proposal_id, 'proposal_meta',true);
				$profile_id		= !empty($proposal_meta['profile_id']) ? intval($proposal_meta['profile_id']) : 0;
				$user_id		= get_post_field( 'post_author',$profile_id);
				$project_id		= get_post_meta( $proposal_id, 'project_id',true);
				$project_id		= !empty($project_id) ? intval($project_id) : 0;
				// update proposal
				$proposal_arg 		= array(
					'ID' 			=> $proposal_id,
					'post_author' 	=> $user_id,
				);
				wp_update_post( $proposal_arg );
				$buyer_id	= get_post_field( 'post_author', $project_id );
				// update comments
				$args 			= array ( 
					'post_id' 		=> $proposal_id
				);
				$comments 		= get_comments( $args );
				if( !empty($comments) ){
					foreach($comments as $comment ){
						$commentarr = array();
						$user_type	= get_comment_meta( $comment->comment_ID, 'user_type', true );
						if( !empty($user_type) && $user_type === 'sellers' ){
							update_comment_meta($comment->comment_ID, 'seller_id', $user_id);
							$commentarr['comment_ID'] 			= $comment->comment_ID;
							$commentarr['user_id'] 				= $user_id;
							wp_update_comment( $commentarr );
						} else if( !empty($user_type) && $user_type === 'buyers' ){
							update_comment_meta($comment->comment_ID, 'buyer_id', $buyer_id);
							$commentarr['comment_ID'] 			= $comment->comment_ID;
							$commentarr['user_id'] 				= $buyer_id;
							wp_update_comment( $commentarr );
						}
					}
				}
				// update order
				$order_arg	= array(
					'posts_per_page'    => -1,
					'post_type'         => array( 'shop_order'),
					'orderby'           => 'ID',
					'order'             => 'DESC',
					'post_status'       => 'any',
					'suppress_filters'  => false,
					'meta_query'    	=> array( 'relation' => 'AND', array( 'key' => 'proposal_id','value' => $proposal_id,'compare' => '=')
					)
				);
				$orders		= get_posts($order_arg);
				if (!empty($orders)) {
					foreach ($orders as $order) {
						$order_id		= $order->ID;

						update_post_meta( $order_id, 'seller_id',$user_id );
						//update_post_meta( $order_id, '_customer_user',$user_id );

						$cus_woo_product_data	= get_post_meta( $order_id, 'cus_woo_product_data',true );
						$cus_woo_product_data	= !empty($cus_woo_product_data) ? $cus_woo_product_data : array();
						$cus_woo_product_data['seller_id']	= $user_id;
						update_post_meta( $order_id, 'cus_woo_product_data',$cus_woo_product_data );
					}
				}

				// update dispute
				$dispute_id	= get_post_meta( $proposal_id, 'dispute_id',true );
				$dispute_id	= !empty($dispute_id) ? intval($dispute_id) : 0;
				$sender_type= get_post_meta( $dispute_id, '_sender_type',true );
				if( !empty($sender_type) && $sender_type === 'sellers' ){
					$dispute_arg 	= array(
						'ID' 			=> $dispute_id,
						'post_author' 	=> $user_id,
					);
					wp_update_post( $dispute_arg );
					update_post_meta( $dispute_id, '_send_by',$user_id );
				}
				update_post_meta( $dispute_id, '_seller_id',$user_id );
				$resolved_by	= get_post_meta( $proposal_id, 'resolved_by',true );
				if( !empty($resolved_by) && $resolved_by === 'sellers' ){
					update_post_meta( $dispute_id, 'winning_party',$user_id );
				}
				$post_status	= get_post_status( $proposal_id );
				if( !empty($post_status) && $post_status === 'hired' ){
					update_post_meta( $proposal_id, '_hired_status',1 );
					update_post_meta( $project_id, '_order_status',1 );
				}
			}
		}
	}
}
/**
 * @init            User migration profile data
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_migration_duplicate_projects')) {

    function taskbot_migration_duplicate_projects() {
		$employer_ids			= array(476,386);
		$title_array			= array(
			'Brand strategy and digital marketing',
			'Migration coding facility',
			'Wireless Internet',
			'Sports and e-sports marketing scripting',
			'Direct inward dialing',
			'Generic services',
			'Wavelength service',
			'Customer premises equipment',
			'Managed network service',
			'Outbound long distance service',
			'Redesign Shopify Dropshipping Store',
			'Automation To Drop Shipping For Website',
			'Manage Shopify E-commerce Store',
			'REST APi in react for for website',
			'7 Figure Shopify Website Shopify Store',
			'Excel And Google Sheets',
			'Audiobook For Acx',
			'Test Applications Or Websites For Usability',
			'Website development',
			'Article And Do Content Writting',
			'upgrade, Secure WordPress Website',
			'Convert PSD to HTML for WordPress theme',
			'Master Your Audiobook For Acx'
		);
		$args2 = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'languages',
		);
		$english_terms 	= get_terms( $args2 );
		$english_level	= array();
		foreach ( $english_terms as $type ) {
			$english_level[$type->term_id]	= !empty($type->term_id) ? $type->term_id : 0;
		}
		
		$args3 = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'skills',
		);
		$skills_terms 	= get_terms( $args3 );
		$skills_term	= array();
		foreach ( $skills_terms as $skill ) {
			$skills_term[$skill->term_id]	= !empty($skill->term_id) ? $skill->term_id : 0;
		}

		$args4 = array(
			'hide_empty'	=> false,
			'taxonomy' 		=> 'expertise_level',
		);
		$expertise_terms 	= get_terms( $args4 );
		$expertise_level	= array();
		foreach ( $expertise_terms as $expelevel ) {
			$expertise_level[$expelevel->term_id]	= !empty($expelevel->term_id) ? $expelevel->term_id : 0;
		}
		$counter	= 0;
		$gmt_time	= current_time( 'mysql', 1 );
		if( !empty($employer_ids) ){
			foreach($employer_ids as $profile_id){
				$user_id   = get_post_field( 'post_author',$profile_id);
				$proj_counter	= 0;
				for ($i=0; $i < 1 ; $i++) {
					$project_id	= taskbotDuplicateProject(2678,$user_id,'migration');
					if( !empty($project_id) ){
						$project_title					= !empty($title_array[$counter]) ? $title_array[$counter] : '';
						$counter++;
						$proj_counter++;
						$tb_post_data					= array();
						$tb_post_data['ID']         	= $project_id;
						$tb_post_data['post_status'] 	= 'publish';
						$tb_post_data['post_name']  	= sanitize_title($project_title);
						$tb_post_data['post_title']  	= wp_strip_all_tags($project_title);
						wp_update_post( $tb_post_data );

						$min_price		= rand(100,200);
						$max_price		= rand(200,300);
						update_post_meta( $project_id, '_order_status',false );
						update_post_meta( $project_id, 'min_price',$min_price );
						update_post_meta( $project_id, 'max_price',$max_price );
						$product_data   			= get_post_meta($project_id, 'tb_project_meta', true);
						$product_data   			= !empty($product_data) ? $product_data : array();
						$product_data['min_price']  = $min_price;
						$product_data['max_price']  = $max_price;
						$product_data['profile_id']	= $profile_id;
						$product_data['name']   	= wp_strip_all_tags($project_title);
						if( !empty($proj_counter) && $proj_counter === 1 ){
							$product_data['is_milestone']  = 'no';
							taskbotProjectFeatured($user_id,array('id' => $project_id,'value' => 'yes'),'migration');
						}
						update_post_meta( $project_id, 'no_of_freelancers',rand(1,5) );
						update_post_meta( $project_id, '_publish_datetime',$gmt_time );
						update_post_meta( $project_id, 'tb_project_meta',$product_data );
						$location		= !empty($counter) && $counter %2 == 0 ? 'remote' : 'partially_remote';
						update_post_meta( $project_id, '_project_location',$location );
						update_post_meta( $project_id, '_post_project_status','publish' );
						
						$level			= array_rand($english_level,2);
						wp_set_object_terms( $project_id, $level, 'languages' );
						$expertise			= array_rand($expertise_level,1);
						wp_set_object_terms( $project_id, intval($expertise), 'expertise_level' );
						$skilllevel			= array_rand($skills_term,10);
						wp_set_object_terms( $project_id, $skilllevel, 'skills' );
						
					}
				}
			}
		}
	}
}
/**
 * @init            User migration profile data
 * @package         Amentotech
 * @subpackage      taskbot/includes
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('taskbot_migration_proposal_submation')) {

    function taskbot_migration_proposal_submation() {
		//$seller_ids		= array(373,181,377,379,449);
		$seller_ids		= array(181,377,379,449);
		$taskbot_args 	= array(
            'post_type'         => 'product',
            'post_status'       => array('publish'),
            'numberposts'       => -1,
            'orderby'           => 'date',
            'order'             => 'DESC',
			'include'			=> array(2859),
            'tax_query'         => array(
                array(
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'projects',
                ),
            ),
        );

		$title_array			= array(
			'Brand strategy and digital marketing',
			'Migration coding facility',
			'Wireless Internet',
			'Sports and e-sports marketing scripting',
			'Direct inward dialing',
			'Generic services',
			'Wavelength service',
			'Customer premises equipment',
			'Managed network service',
			'Outbound long distance service',
			'Redesign Shopify Dropshipping Store',
			'Automation To Drop Shipping For Website',
			'Manage Shopify E-commerce Store',
			'REST APi in react for for website',
			'7 Figure Shopify Website Shopify Store',
			'Excel And Google Sheets',
			'Audiobook For Acx',
			'Test Applications Or Websites For Usability',
			'Website development',
			'Article And Do Content Writting',
			'upgrade, Secure WordPress Website',
			'Convert PSD to HTML for WordPress theme',
			'Master Your Audiobook For Acx'
		);
        $task_listings  = get_posts($taskbot_args);
		foreach($seller_ids as $profile_id){
			$user_id   = get_post_field( 'post_author',$profile_id);
			if( !empty($task_listings) ){
				foreach($task_listings as $project){
					$project_id		= $project->ID;
					$project_meta	= get_post_meta( $project_id, 'tb_project_meta',true);
					$min_price		= !empty($project_meta['min_price']) ? $project_meta['min_price'] : 0;
					$max_price		= !empty($project_meta['max_price']) ? $project_meta['max_price'] : 0;
					$proposal_price	= rand($min_price,$max_price);
					$proposal_data	= array();
					$proposal_data['price']			= $proposal_price;
					$proposal_data['profile_id']	= $profile_id;
					$proposal_data['description']	= 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
					if( !empty($project_meta['is_milestone']) && $project_meta['is_milestone'] === 'yes' ){
						$proposal_data['proposal_type']		= 'milestone';
						$milestone	= array();
						$remaning_price	= $proposal_price;
						for ($i=0; $i < 4; $i++) { 
							$remaning_price	= intval($remaning_price/2);
							$milestone[taskbot_unique_increment(5)] = array(
								'price'	=> $remaning_price,
								'title'	=> $title_array[rand(0,21)],
								'detail' => ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
								'status' => ''
							);
						}
						$proposal_data['milestone']		= $milestone;
					}
					taskbotSubmitProposal($user_id,$project_id,'publish',$proposal_data,0,'migration');
				}
			}
		}
	}
}