<?php 
 require TASKBOT_DIRECTORY . 'libraries/PhpSpreadsheet/vendor/autoload.php';
 use PhpOffice\PhpSpreadsheet\Spreadsheet;
 use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * @Import Users
 * @return{}
 */     

if ( !class_exists('TaskbotImportUser') ) {    
    class TaskbotImportUser {        
        function __construct(){
            // Constructor Code here..
   		}
		
		/*
		 * @import users
		 */
		public function taskbot_import_user(){
		
			global $wpdb, $wpdb_data_table;
	
			// User data fields list used to differentiate with user meta
			$userdata_fields       = array(
				'ID', 
				'username', 
				'user_pass',
				'user_email', 
				'user_url', 
				'user_nicename',
				'display_name', 
				'user_registered', 
				'first_name',
				'last_name', 
				'nickname', 
				'description',
				'rich_editing', 
				'comment_shortcuts', 
				'admin_color',
				'use_ssl', 
				'show_admin_bar_front', 
				'show_admin_bar_admin',
				'role'
			);

			$wp_user_table		= $wpdb->prefix.'users';
			$wp_usermeta_table	= $wpdb->prefix.'usermeta';

			if ( isset( $_FILES['users_csv']['tmp_name'] ) ) {
				$file = $_FILES['users_csv']['tmp_name'];
				$name = !empty( $_FILES['users_csv']['name'] ) ? $_FILES['users_csv']['name'] : '';
				
				$filetype	= '';
				if( !empty( $name ) ){
					$filetype = pathinfo($name, PATHINFO_EXTENSION);
				}
				
				$import_type	= 'upload';
				
			} else{
				$file 			= TASKBOT_DIRECTORY.'/import-users/users.xlsx';
				$filetype		= 'xlsx';
				$import_type	= 'dummy';
			}
			
			try {
				//Load the excel(.xls/.xlsx) file
				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
			} catch (Exception $e) {
				die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
			}
			
			$worksheet = $spreadsheet->getActiveSheet();
			// Get the highest row and column numbers referenced in the worksheet
			$total_rows 	= $worksheet->getHighestRow(); // e.g. 10
			$highest_column = $worksheet->getHighestColumn();
			$first 			= true;
			$rkey 			= 0;
			$tag_line_array	= array("information techonology the clear choice","I Feel Like information techonology Tonight","I want more, I want information techonology","information techonology, the real thing","information techonology - a safe place in an unsafe world!","information techonology Prevents That Sinking Feeling","Doing It Right Before Your information techonology","Endless possibilities with information techonology","I'd sleep with information techonology","Did Somebody Say information techonology?","Truly information techonology","I trust information techonology","information techonology is what the world was waiting for","A Taste For information techonology","Feel it - information techonology!","information techonology Just Feels Right","Because I'm Worth Wed desgin.Wed desgin. We build smiles","Wed desgin. The power on your side","The age of Wed desgin.A Wed desgin A Day Helps You Work, Rest and Play","Wed desgin the time is now.Hope It's Wed desgin, It's Wed desgin, We Hope It's Wed desgin...","Wed desgin beat","Wed desgin, the secret of women","Lucky Wed desgin","Wed desgin for everyone","Once Wed desgin, always Wed desgin","Wed desgin is your friend","The Wed desgin That Likes To Say Yes","Wed desgin for all","Wed desgin takes good care of you");
			for($row =1; $row <= $total_rows; $row++) {
	
				// If the first line is empty, abort
				// If another line is empty, just skip it
				if ( empty( $row ) ) {
					if ( $first )
						break;
					else
						continue;
				}
				$data	= array();
				// If we are on the first line, the columns are the headers
				if ( $first ) {
					$line = $spreadsheet->getActiveSheet()
									->rangeToArray(
										'A' . $row . ':' . $highest_column . $row,     // The worksheet range that we want to retrieve
										NULL,        // Value that should be returned for empty cells
										TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
										FALSE,       // Should values be formatted (the equivalent of getFormattedValue() for each cell)
										FALSE        // Should the array be indexed by cell row and cell column
									);
					$headers 	= !empty( $line[0] ) ? $line[0] : array();
					$first 		= false;
					continue;
				} else{
					$data = $spreadsheet->getActiveSheet()
									->rangeToArray(
										'A' . $row . ':' . $highest_column . $row,     // The worksheet range that we want to retrieve
										NULL,        // Value that should be returned for empty cells
										TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
										FALSE,       // Should values be formatted (the equivalent of getFormattedValue() for each cell)
										FALSE        // Should the array be indexed by cell row and cell column
									);
				}
				// Separate user data from meta
				$userdata = $usermeta = array();
				
				if( !empty($data[0]) ){
					foreach ( $data[0] as $ckey => $column ) {
						$column_name = trim( $headers[$ckey] );
						$column = trim( $column );

						if ( in_array( $column_name, $userdata_fields ) ) {
							$userdata[$column_name] = $column;
						} else {
							$usermeta[$column_name] = $column;
						}
					}
					// If no user data, bailout!
					if ( empty( $userdata ) )
						continue;

					$user = $user_id = false;

					if ( ! $user ) {

						if ( isset( $userdata['username'] ) )
							$user = get_user_by( 'login', $userdata['username'] );
		
						if ( ! $user && isset( $userdata['user_email'] ) )
							$user = get_user_by( 'email', $userdata['user_email'] );
					}
					
					$update = false;
					if ( $user ) {
						$userdata['ID'] = $user->ID;
						$update = true;
					}
		
					// If creating a new user and no password was set, let auto-generate one!
					if ( ! $update && $update == false  && empty( $userdata['user_pass'] ) ) {
						$userdata['user_pass'] = wp_generate_password( 12, false );
					}
					
					if (isset($update) && $update == true) {
						$user_id = wp_update_user( $userdata );
						
						$new_user 	= new WP_User( $user_id );
						$new_user->set_role( 'subscriber' );
						
						$display_name	= $userdata['first_name'].' '.$userdata['last_name'];
						
					} else {
						global $taskbot_settings;
						$display_name		= $userdata['first_name'].' '.$userdata['last_name'];	
						$db_user_id 		= !empty( $usermeta['user_id'] ) ? $usermeta['user_id'] : '';
						$db_username 		= !empty( $userdata['username'] ) ? $userdata['username'] : '';
						$db_user_pass 		= !empty( $userdata['user_pass'] ) ? $userdata['user_pass'] : '123456';
						$profile_sellers 	= !empty( $usermeta['_linked_profile'] ) ? $usermeta['_linked_profile'] : '';
						$wallet_order_id 	= !empty( $usermeta['wallet_order_id'] ) ? $usermeta['wallet_order_id'] : 0;
						$task_orders 		= !empty( $usermeta['task_orders'] ) ? $usermeta['task_orders'] : array();
						$buyers_id 			= !empty( $usermeta['_linked_profile_buyer'] ) ? $usermeta['_linked_profile_buyer'] : '';
						$tasks 				= !empty( $usermeta['tasks'] ) ? $usermeta['tasks'] : array();
						$db_user_email 		= !empty( $userdata['user_email'] ) ? $userdata['user_email'] : '';
						$db_user_url 		= !empty( $userdata['user_url'] ) ? $userdata['user_url'] : '';
						$db_nicename 		= !empty( $userdata['user_nicename'] ) ? sanitize_title( $userdata['user_nicename'] ) : $db_username;
						$display_name 		= !empty( $userdata['display_name'] ) ? $userdata['display_name'] : $display_name;
						$login_type			= !empty($usermeta['login_type']) ? $usermeta['login_type'] : 'sellers';
						if(empty($db_user_email)){
							continue;
						}
						
						$sql = "INSERT INTO $wp_user_table (user_login, 
															user_pass, 
															user_email, 
															user_registered,
															user_status, 
															display_name, 
															user_nicename, 
															user_url
															) VALUES ('".$db_username."',
															'".md5($db_user_pass)."',
															'".$db_user_email."',
															'".date('Y-m-d H:i:s')."',
															0,
															'".$display_name."',
															'".$db_nicename."',
															'".$db_user_url."'
														)";
						
						
						$wpdb->query($sql);
						$lastid 	= $wpdb->insert_id;
						$new_user 	= new WP_User( $lastid );
						$new_user->set_role( 'subscriber' );

						$user_id 		=	$lastid;
						$tb_post_meta	= array();
						// Include again meta fields
						$tag_lin_key					= array_rand($tag_line_array,1);
						$tb_post_meta['tagline']	    = !empty($tag_line_array[$tag_lin_key]) ? $tag_line_array[$tag_lin_key] : '';
						$tb_post_meta['first_name']	    = !empty( $userdata['first_name'] ) ? $userdata['first_name'] : '';
						$tb_post_meta['last_name']	    = !empty( $userdata['last_name'] ) ? $userdata['last_name'] : '';

						update_user_meta( $user_id, '_user_type', $login_type ); //update user type
						update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
						update_user_meta( $user_id, 'full_name', $display_name );
						update_user_meta( $user_id, 'first_name', $userdata['first_name'] );
						update_user_meta( $user_id, 'last_name', $userdata['last_name'] );
						update_user_meta( $user_id, 'rich_editing', 'true' );
						update_user_meta( $user_id, 'nickname', $display_name );
						update_user_meta( $user_id, '_is_verified', 'yes' );
						update_user_meta($user_id, 'login_type', $login_type);
						update_user_meta($user_id, 'identity_verified', 1);

						if( !empty($import_type) && $import_type === 'dummy'){
							$user_post = array(
								'post_author'   => $user_id,
								'ID'			=> $profile_sellers
							);
							wp_update_post( $user_post );

							update_user_meta($user_id, '_linked_profile', $profile_sellers);
							update_post_meta($profile_sellers, '_linked_profile', $user_id);
							update_post_meta($profile_sellers, '_is_verified', 'yes');
							$buyersuser_post = array(
								'post_author'   => $user_id,
								'ID'			=> $buyers_id
							);

							wp_update_post( $buyersuser_post );
							update_user_meta($user_id, '_linked_profile_buyer', $buyers_id);
							update_post_meta($buyers_id, '_linked_profile', $user_id);
							update_post_meta($buyers_id, '_is_verified', 'yes');
							update_post_meta( $buyers_id, 'is_avatar', 0 );
							
							taskbot_update_billing_details($user_id);
							if( !empty($task_orders) ){
								update_post_meta($buyers_id, '_task_orders', $task_orders);
							}
							
							if( !empty($tasks) ){
								taskbot_migration_subtasks($user_id);
								$task_ids	= explode(',',$tasks);
								if( !empty($task_ids) ){
									foreach($task_ids as $task_id){
										taskbot_migration_tasks($user_id,$task_id);
									}
								}
							}
							// if( !empty($projects) ){
							// 	if( !empty($projects) ){
							// 		foreach($projects as $project_id){
							// 			taskbot_migration_projects($user_id,$project_id);
							// 		}
							// 	}
							// }
						} else if( !empty($import_type) && $import_type === 'upload'){
							$user_post = array(
								'post_title'    => wp_strip_all_tags($display_name),
								'post_status'   => 'publish',
								'post_author'   => $user_id,
								'post_type'     => 'sellers',
							);
				
							$profile_sellers = wp_insert_post($user_post);
							$buyer_post = array(
								'post_title'    => wp_strip_all_tags($display_name),
								'post_status'   => 'publish',
								'post_author'   => $user_id,
								'post_type'     => 'buyers',
							);
				
							$buyers_id = wp_insert_post($buyer_post);
							update_user_meta($user_id, '_linked_profile_buyer', $buyers_id);
							update_post_meta($buyers_id, '_linked_profile', $user_id);
							update_post_meta($buyers_id, '_is_verified', 'yes');
							update_post_meta( $buyers_id, 'is_avatar', 0 );

							update_user_meta($user_id, '_linked_profile', $profile_sellers);
							update_post_meta($profile_sellers, '_linked_profile', $user_id);
							update_post_meta($profile_sellers, '_is_verified', 'yes');
							update_post_meta( $profile_sellers, 'is_avatar', 0 );

							$dir_latitude     = !empty($taskbot_settings['dir_latitude']) ? $taskbot_settings['dir_latitude'] : 0.0;
							$dir_longitude    = !empty($taskbot_settings['dir_longitude']) ? $taskbot_settings['dir_longitude'] : 0.0;
							
							//add extra fields as a null
							update_post_meta($buyers_id, '_address', '');
							update_post_meta($buyers_id, '_latitude', $dir_latitude);
							update_post_meta($buyers_id, '_longitude', $dir_longitude);
							update_post_meta($buyers_id, 'zipcode', '');
							update_post_meta($buyers_id, 'country', '');

							update_post_meta($profile_sellers, '_address', '');
							update_post_meta($profile_sellers, '_latitude', $dir_latitude);
							update_post_meta($profile_sellers, '_longitude', $dir_longitude);
							update_post_meta($profile_sellers, 'zipcode', '');
							update_post_meta($profile_sellers, 'country', '');


							update_user_meta($user_id, '_notification_email', $db_user_email);
							
							update_post_meta($buyers_id, 'tb_post_meta', $tb_post_meta);
							update_post_meta($profile_sellers, 'tb_post_meta', $tb_post_meta);

						}

					}
	
					$rkey++;
				}
			}
			
			
		}
	}
}