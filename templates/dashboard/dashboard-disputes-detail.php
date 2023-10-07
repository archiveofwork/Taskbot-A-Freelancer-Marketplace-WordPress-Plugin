<?php
/**
 * Dispute listings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $post,$taskbot_settings;

$reference 		 = !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$dispute_id 	 = !empty($_GET['id']) ? intval($_GET['id']) : '';
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );
$dispute_post	= get_post($dispute_id);

$buyer_id		= get_post_meta($dispute_id, '_send_by', true);
$seller_id		= get_post_meta($dispute_id, '_seller_id', true);
$task_id		= get_post_meta($dispute_id, '_task_id', true);
$order_id		= get_post_meta($dispute_id, '_dispute_order', true);


$_dispute_key	= get_post_meta($dispute_id, '_dispute_key', true);
$dispute_resolve_status		= get_post_meta($dispute_id, 'dispute_status', true);
$winning_user				= get_post_meta($dispute_id, 'winning_party', true);
$dispute_author_id			= $dispute_post->post_author;
$dispute_author_user_type	= apply_filters('taskbot_get_user_type', $dispute_author_id );
$order_url         			= Taskbot_Profile_Menu::taskbot_profile_menu_link('tasks-orders', $user_identity, true, 'detail',$order_id);

if($dispute_author_user_type == 'sellers'){
	$dispute_author_user_type	= esc_html__('Seller', 'taskbot');
} elseif($dispute_author_user_type == 'buyers'){
	$dispute_author_user_type	= esc_html__('Buyer', 'taskbot');	
} else {
	$dispute_author_user_type	= esc_html__('Administrator', 'taskbot');
}

$seller_profile_id	= taskbot_get_linked_profile_id($seller_id);
$buyer_profile_id	= taskbot_get_linked_profile_id($buyer_id);
$buyer_name			= taskbot_get_username($buyer_profile_id);
$seller_name		= taskbot_get_username($seller_profile_id);
$buyer_dispute_days	= !empty($taskbot_settings['buyer_dispute_option'])	? intval($taskbot_settings['buyer_dispute_option']) : 5;
$final_date			= esc_html(date_i18n( get_option( 'date_format' ),  strtotime($dispute_post->post_date. ' + '.intval($buyer_dispute_days).' days')));
$buyer_avatar		= apply_filters(
	'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $buyer_profile_id), array('width' => 100, 'height' => 100)
);
$reply_name		= $seller_name;
$sender_id		= $buyer_id;
$receiver_id	= $seller_id;

if($user_type == 'sellers'){
	$reply_name		= $buyer_name;
	$sender_id		= $seller_id;
	$receiver_id	= $buyer_id;
}?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-lg-8 col-md-12">
			<div class="tb-refunddetailswrap">
				<?php if(get_post_status($dispute_id) == 'publish' && $user_type == 'sellers'){?>
					<div class="tb-orderrequest">
						<div class="tb-ordertitle">
							<h5><?php esc_html_e('Respond to refund request', 'taskbot');?></h5>
							<p><?php echo wp_sprintf(esc_html__('Take action before “%s” otherwise dispute will be launched automatically', 'taskbot'), $final_date);?></p>
						</div>
					</div>
				<?php }?>
				<div class="tb-disputemain">
					<div class="tb-tabbitem__list">
						<div class="tb-deatlswithimg">
							<div class="tb-disputedisc">
								<div class="tb-bordertags">
									<span class="tb-tag-bordered tb-dispute-<?php echo esc_html(get_post_status($dispute_id));?>"><?php echo esc_html(taskbot_dispute_status($dispute_id));?></span>
								</div>
								<span><?php echo esc_html(date_i18n( get_option( 'date_format' ),  strtotime($dispute_post->post_date)));?></span>
								<h5><a href="<?php echo esc_url($order_url);?>" target="_blank"><?php echo esc_html(get_the_title($task_id));?></a></h5>
							</div>
						</div>
					</div>
				</div>
				<?php
				$args = array(
					'post_id' 			=> $dispute_id,
					'hierarchical' 		=> true,
					'order'     		=> 'ASC',
				);
				$comments = get_comments( $args );
				?>
				<div class="tb-refunddetail">
					<div class="tb-refunddetail_info">
						<?php if(!empty($buyer_avatar)){?>
							<figure>
								<img src="<?php echo esc_url( $buyer_avatar ); ?>" alt="<?php echo esc_attr( $buyer_name ); ?>">
							</figure>
						<?php }?>
						
						<div class="tb-extrasarticles">
							<div class="tb-taskinfo">
								<?php if(!empty($dispute_author_user_type)){?>
									<span><?php echo esc_html(ucfirst($dispute_author_user_type));?></span>
								<?php }?>	
								<?php if(!empty($buyer_name)){?>
									<h6><?php echo esc_html($buyer_name);?></h6>
								<?php }?>
							</div>
							<?php if(!empty($_dispute_key)){?>
								<div class="tb-articletitle"> 
									<h4><?php echo esc_html($_dispute_key);?></h4>
								</div>	
							<?php }?>	
							<?php if(!empty($_dispute_key)){?>					
								<div class="tb-articlediscription">
									<?php echo wpautop(nl2br($dispute_post->post_content));?>
								</div>
							<?php }?>			
						</div>
					</div>
					<?php foreach ($comments as $key => $value) {
						if(!empty($value->comment_parent)){
							continue;
						}
						$date			= !empty( $value->comment_date ) ? $value->comment_date : '';
						$author_id 		= !empty( $value->user_id ) ? $value->user_id : '';
						$comments_id	= !empty( $value->comment_ID ) ? $value->comment_ID : '';
						
						$date		= !empty( $date ) ? date_i18n('F j, Y', strtotime($date)) : '';
						$author		= !empty( $value->comment_author ) ? $value->comment_author : '';
						$message	= $value->comment_content;
						$user		= get_userdata( $author_id );	
						if(empty($user)){	
							continue;
						}				
						$user_roles = $user->roles;

						if (!empty($user_roles) && is_array($user_roles) && in_array( 'administrator', $user_roles, true ) ) {
							$author_name       = $user->display_name;
							$avatar	= get_avatar_url( $user->ID, ['size' => '80']  );
							$comment_author_type = esc_html__('Administrator', 'taskbot');
						} else {
							$comment_user_type = apply_filters('taskbot_get_user_type', $author_id);
							$linked_profile_id = taskbot_get_linked_profile_id($author_id, '', $comment_user_type);	
							if($comment_user_type == 'sellers'){
								$comment_author_type	= esc_html__('Seller', 'taskbot');
							} elseif($comment_user_type == 'buyers'){
								$comment_author_type	= esc_html__('Buyer', 'taskbot');	
							} else {
								$comment_author_type	= esc_html__('Administrator', 'taskbot');
							}
							$author_name = taskbot_get_username($linked_profile_id);
							$avatar = apply_filters(
								'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $linked_profile_id), array('width' => 100, 'height' => 100)
							);
						}

						$message_files      = get_comment_meta( $value->comment_ID, 'message_files', true);
						$child_comments		= get_comments(array('parent' => $comments_id, 'hierarchical' => true, 'order' => 'ASC'));
						
						?>
						<div class="tb-refunddetail_info" id="comment-<?php echo intval($value->comment_ID);?>">
							<?php if(!empty($avatar)){?>
								<figure>
									<img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>"> 
								</figure>
							<?php }?>
							<div class="tb-extrasarticles">
								<div class="tb-taskinfo">
									<?php if(!empty($avatar)){?>
										<span><?php echo esc_html(ucfirst($comment_author_type));?></span>
									<?php }?>
									<?php if(!empty($author_name)){?>
										<h6><?php echo esc_html($author_name);?></h6>
									<?php }?>
								</div>
								<?php if(!empty($message)){?>
									<div class="tb-articlediscription">
										<?php echo wpautop(nl2br($message));?>
									</div>
								<?php }?>
								 <!-- message attachments -->
								 <?php if (!empty($message_files)){ ?>
									<div class="tb-documentlist">
										<ul class="tb-doclist">
											<?php foreach ($message_files as $message_file) {
											$src =  TASKBOT_DIRECTORY_URI . 'public/images/doc.jpg';
											$file_url   = $message_file['url'];
											$file_uname = $message_file['name'];

											if (isset($message_file['ext']) && !empty($message_file['ext'])){
												if ($message_file['ext'] == 'pdf'){
													$src =  TASKBOT_DIRECTORY_URI . 'public/images/pdf.jpg';
												}elseif ($message_file['ext'] == 'png'){
													$src =  TASKBOT_DIRECTORY_URI . 'public/images/png.jpg';
												}elseif ($message_file['ext'] == 'ppt'){
													$src =  TASKBOT_DIRECTORY_URI . 'public/images/ppt.jpg';
												}elseif ($message_file['ext'] == 'psd'){
													$src =  TASKBOT_DIRECTORY_URI . 'public/images/psd.jpg';
												}elseif ($message_file['ext'] == 'php'){
													$src =  TASKBOT_DIRECTORY_URI . 'public/images/php.jpg';
												}
											}?>
											<li>
												<a href="<?php echo esc_url( $file_url ); ?>" class="tb-download-attachment" data-id="<?php echo esc_attr( $comment->comment_ID ); ?>" ><img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $file_uname ); ?>"></a>
											</li>
											<?php } ?>
										</ul>
										<a href="javascript:void(0);" class="tb-download-attachment" data-id="<?php echo esc_attr( $comments_id ); ?>" >Download file(s)</a>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php if(!empty($child_comments)){
								
								 foreach ($child_comments as $key => $comment) {
									$child_comment_author_id	= !empty( $comment->user_id ) ? $comment->user_id : '';  
									$comment_author_type      	= apply_filters('taskbot_get_user_type', $child_comment_author_id);
									$linked_profile_id 			= taskbot_get_linked_profile_id($child_comment_author_id, '', $comment_author_type);
									$author_name       			= taskbot_get_username($linked_profile_id);	
									$child_comment_message		= $comment->comment_content;

									$user = get_userdata( $child_comment_author_id );
									if(empty($user)){	
										continue;
									}
									$user_roles = $user->roles;
									
									if (!empty($user_roles) && is_array($user_roles) && in_array( 'administrator', $user_roles, true ) ) {
										$author_name       = $user->display_name;
										$avatar	= get_avatar_url( $user->ID, ['size' => '80']  );
										$comment_author_type         = esc_html__('Administrator', 'taskbot');
									} else {
										$comment_user_type         = apply_filters('taskbot_get_user_type', $child_comment_author_id);
										$linked_profile_id	= taskbot_get_linked_profile_id($author_id, '', $comment_user_type);
										$author_name       = taskbot_get_username($linked_profile_id);
										
										if($comment_user_type == 'sellers'){
											$comment_author_type	= esc_html__('Seller', 'taskbot');
										} elseif($comment_user_type == 'buyers'){
											$comment_author_type	= esc_html__('Buyer', 'taskbot');	
										} else {
											$comment_author_type	= esc_html__('Administrator', 'taskbot');
										}
										$avatar            = apply_filters(
											'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $linked_profile_id), array('width' => 100, 'height' => 100)
										);
									}

									$message_files     = get_comment_meta( $comment->comment_ID, 'message_files', true);
															
									?>
									<div class="tb-refunddetail_info reply-comment" id="comment-<?php echo intval($comment->comment_ID);?>">
										<?php if(!empty($avatar)){?>
											<figure>
												<span>
													<img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>">
												</span>
											</figure>
										<?php }?>
										<div class="tb-extrasarticles">
											<div class="tb-taskinfo">
												<?php if(!empty($comment_author_type)){?>
													<span><?php echo esc_html(ucfirst($comment_author_type));?></span>
												<?php }?>
												<?php if(!empty($author_name)){?>
													<h6><?php echo esc_html($author_name);?></h6>
												<?php }?>
											</div>
											<?php if (!empty($child_comment_message)){ ?>
												<div class="tb-articlediscription">
													<?php echo wpautop(nl2br($child_comment_message));?>
												</div>
											<?php }?>
											<!-- message attachments -->
											<?php if (!empty($message_files)){ ?>
												<div class="tb-documentlist">
													<ul class="tb-doclist">
														<?php foreach ($message_files as $message_file) {

															$src =  TASKBOT_DIRECTORY_URI . 'public/images/doc.jpg';
															$file_url   = $message_file['url'];
															$file_uname = $message_file['name'];

															if (isset($message_file['ext']) && !empty($message_file['ext'])){
																if ($message_file['ext'] == 'pdf'){
																	$src =  TASKBOT_DIRECTORY_URI . 'public/images/pdf.jpg';
																}elseif ($message_file['ext'] == 'png'){
																	$src =  TASKBOT_DIRECTORY_URI . 'public/images/png.jpg';
																}elseif ($message_file['ext'] == 'ppt'){
																	$src =  TASKBOT_DIRECTORY_URI . 'public/images/ppt.jpg';
																}elseif ($message_file['ext'] == 'psd'){
																	$src =  TASKBOT_DIRECTORY_URI . 'public/images/psd.jpg';
																}elseif ($message_file['ext'] == 'php'){
																	$src =  TASKBOT_DIRECTORY_URI . 'public/images/php.jpg';
																}
															}
														?>
														<li>
															<a href="<?php echo esc_url( $file_url ); ?>" class="tb-download-attachment" data-id="<?php echo esc_attr( $comment->comment_ID ); ?>" ><img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $file_uname ); ?>"></a>
														</li>
														<?php } ?>
													</ul>
													<a href="javascript:void(0);" class="tb-download-attachment" data-id="<?php echo esc_attr( $comments_id ); ?>" >Download file(s)</a>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php }?>
							<?php }?>
					<?php }?>					
				</div>
				<?php 
				$user_type_seller	= '';
				if(!in_array(get_post_status($dispute_id), array('resolved', 'refunded', 'disputed', 'declined', 'cancelled'))){?>
					<div class="tb-refunddetailttabs">
						<?php if($user_type == 'sellers' && (!in_array(get_post_status($dispute_id), array('resolved', 'disputed', 'refunded', 'cancelled')))){
							$user_type_seller	= 'style="display: none;"';
							?>
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li>
									<a class="nav-link tb-replytabbtn dispute-action active tb-btn" data-action="reply" data-submit_title="<?php esc_html_e('Post reply', 'taskbot');?>" href="javascript:void(0);"><?php esc_html_e('Reply to refund', 'taskbot');?></a>
								</li>
								<li>
									<a class="nav-link tb-allowtabbtn dispute-action tb-btn" data-action="refund" data-submit_title="<?php esc_html_e('Process Refund', 'taskbot');?>" href="javascript:void(0);"><?php esc_html_e('Allow refund', 'taskbot');?></a>
								</li>
								<li>
									<a class="nav-link tb-declinetabbtn dispute-action tb-btn" data-action="decline" data-submit_title="<?php esc_html_e('Decline refund', 'taskbot');?>" href="javascript:void(0);"><?php esc_html_e('Decline refund', 'taskbot');?></a>
								</li>
							</ul>
						<?php }?>
						<div class="tab-content">
							<div class="tab-pane fade active show" id="reply" role="tabpanel" aria-labelledby="reply-tab">
								<div class="tb-refundform" <?php echo do_shortcode($user_type_seller);?>>                                            
									<div class="tb-refundform_title">
										<h2><?php esc_html_e('Add a reply', 'taskbot');?></h2>
									</div>
									<form class="tb-themeform tb-refundform_form" id="dispute-reply-form">
										<input type="hidden" name="dispute_id" id="dispute_id" value="<?php echo intval($dispute_id);?>" >
										<input type="hidden" name="sender_id" id="sender_id" value="<?php echo intval($sender_id);?>" >
										<input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo intval($receiver_id);?>" >
										<input type="hidden" name="action_type" id="action_type" value="reply" >
										<fieldset>
											<div class="form-group">
												<textarea class="form-control" id="dispute_comment" name="dispute_comment" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>"></textarea>
											</div>
											<div class="form-group tb-form-btn">
												<a href="javascript:void(0);" id="dispute-reply-btn" class="tb-btn tb-replytabbtn"><?php esc_html_e('Post reply', 'taskbot');?></a>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
					</div>
				<?php }?>
				
			</div>
		</div>
		<div class="col-sm-12 col-lg-4 col-md-12">
			<aside>
				<?php 
					do_action('taskbot_order_budget_details', $order_id, $user_type);
				?>	
			</aside>		
		</div>
	</div>
</div>
