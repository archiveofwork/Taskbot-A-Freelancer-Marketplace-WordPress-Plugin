<?php
/**
 * Dispute detail
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/admin_dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $post;

$reference		= !empty($_GET['ref'] ) ? $_GET['ref'] : '';
$mode			= !empty($_GET['mode']) ? $_GET['mode'] : '';
$user_identity	= intval($current_user->ID);
$dispute_id		= !empty($_GET['id']) ? $_GET['id'] : '';
$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
$dispute_post	= get_post($dispute_id);
$buyer_id		= get_post_meta($dispute_id, '_send_by', true);
$seller_id		= get_post_meta($dispute_id, '_seller_id', true);
$task_id		= get_post_meta($dispute_id, '_task_id', true);
$order_id		= get_post_meta($dispute_id, '_dispute_order', true);
$_dispute_key	= get_post_meta($dispute_id, '_dispute_key', true);
$_dispute_key	= get_post_meta($dispute_id, '_dispute_key', true);

$dispute_resolve_status	= get_post_meta($dispute_id, 'dispute_status', true);
$seller_id			= get_post_meta( $order_id, 'seller_id', true);
$buyer_id			= get_post_meta( $order_id, 'buyer_id', true);
$seller_id			= !empty($seller_id) ? $seller_id : 0;
$buyer_id			= !empty($buyer_id) ? $buyer_id : 0;

$winning_user		= get_post_meta($dispute_id, 'winning_party', true);
$seller_profile_id	= taskbot_get_linked_profile_id($seller_id);
$buyer_profile_id	= taskbot_get_linked_profile_id($buyer_id);
$buyer_name			= taskbot_get_username($buyer_profile_id);
$seller_name		= taskbot_get_username($seller_profile_id);
$final_date			= esc_html(date_i18n( get_option( 'date_format' ),  strtotime($dispute_post->post_date. ' + 5 days')));

$buyer_avatar	= apply_filters(
	'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $buyer_profile_id), array('width' => 100, 'height' => 100)
);
$seller_avatar	= apply_filters(
	'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $seller_profile_id), array('width' => 100, 'height' => 100)
);

$reply_name		= $buyer_name;
$sender_id		= $buyer_id;
$receiver_id	= $seller_id;

if($user_type == 'sellers'){
	$reply_name		= $seller_name;
	$sender_id		= $seller_id;
	$receiver_id	= $buyer_id;
}

?>
<div class="col-xl-4">
	<div class="tb-dbholder">
		<div class="tb-dbbox tb-dbboxtitle">
			<h5><?php esc_html_e('Dispute resolution', 'taskbot');?></h5>
		</div>
		<div class="tb-dbbox">
			<?php if($dispute_resolve_status == 'resolved'){?>
				<ul class="tb-payoutmethod">
					<li class="tb-radiobox">
						<div class="tb-radiodispute">
							<div class="tb-radiolist payoutlists">
								<span class="tb-wininginfomain">
									<img src="<?php echo esc_url($buyer_avatar);?>" alt="<?php echo esc_attr($buyer_name);?>">
									<span class="tb-wininginfo">
										<em><?php esc_html_e('Buyer', 'taskbot');?></em>
										<i><?php echo esc_html($buyer_name);?></i>
									</span>
								</span>
								<?php if($winning_user == $buyer_id){?>
									<figure>
										<img src="<?php echo esc_url(TASKBOT_DIRECTORY_URI . 'admin-dashboard/images/disputes/resolved/img-1.png'); ?>" alt="<?php esc_attr_e('Winner', 'taskbot');?>">
									</figure>
								<?php }?>

							</div>
						</div>
					</li>
					<li class="tb-radiobox">
						<div class="tb-radiodispute">
							<div class="tb-radiolist payoutlists">
								<span class="tb-wininginfomain">
									<img src="<?php echo esc_url($seller_avatar);?>" alt="<?php echo esc_attr($seller_name);?>">
									<span class="tb-wininginfo">
										<em><?php esc_html_e('Seller', 'taskbot');?></em>
										<i><?php echo esc_html($seller_name);?></i>
									</span>
								</span>

								<?php if($winning_user == $seller_id){?>
									<figure>
										<img src="<?php echo esc_url(TASKBOT_DIRECTORY_URI . 'admin-dashboard/images/disputes/resolved/img-1.png'); ?>" alt="<?php esc_attr_e('winner', 'taskbot');?>">
									</figure>
								<?php }?>
							</div>
						</div>
					</li>
					<li class="tb-radiobox tb-resolved">
						<div class="tb-radiodispute">
							<div class="tb-radiolist payoutlists">
								<span class="tb-wininginfomain">
									<span class="tb-wininginfo tb-greencheck">
										<span class="icon-check"></span>
										<i><?php esc_html_e('This dispute has been resolved', 'taskbot');?></i>
									</span>
								</span>
							</div>
						</div>
					</li>
				</ul>
			<?php } else {?>
				<div class="tb-disputeradiotitle">
					<h6 class="tb-titleinput"><?php esc_html_e('Choose wining party', 'taskbot');?>:</h6>
				</div>
				<form class="tb-themeform tb-loginform" id="admin-dispute-resolve-form">
					<ul class="tb-payoutmethod tb-payoutmethodvtwo">
						<li class="tb-radiobox">
							<input type="radio" id="a-option" value="<?php echo intval($buyer_id);?>" name="user_id">
							<div class="tb-radiodispute">
								<div class="tb-radio">
									<label for="a-option" class="tb-radiolist payoutlists">
										<span class="tb-wininginfomain">
											<img src="<?php echo esc_url($buyer_avatar);?>" alt="<?php esc_attr($buyer_name);?>">
											<span class="tb-wininginfo">
												<em><?php esc_html_e('Buyer', 'taskbot');?></em>
												<i><?php echo esc_html($buyer_name);?></i>
											</span>
										</span>
									</label>
								</div>
							</div>
						</li>
						<li class="tb-radiobox">
							<input type="radio" id="ab-option" name="user_id" value="<?php echo intval($seller_id);?>" checked="checked">
							<div class="tb-radiodispute">
								<div class="tb-radio">
									<label for="ab-option" class="tb-radiolist payoutlists">
										<span class="tb-wininginfomain">
											<img src="<?php echo esc_url($seller_avatar);?>" alt="<?php esc_attr($seller_name);?>">
											<span class="tb-wininginfo">
												<em><?php esc_html_e('Seller', 'taskbot');?>:</em>
												<i><?php echo esc_html($seller_name);?></i>
											</span>
										</span>
									</label>
								</div>
							</div>
						</li>
					</ul>
					<fieldset>
						<div class="form-group-wrap">
							<div class="form-group form-vertical">
								<label class="tb-titleinput"><?php esc_html_e('Add dispute feedback', 'taskbot');?>:</label>
								<textarea class="form-control" id="dispute_feedback" name="dispute-detail" placeholder="<?php esc_attr_e('Enter Details', 'taskbot');?>"></textarea>
							</div>
							<div class="form-group form-vertical">
								<label class="tb-titleinput"><?php esc_html_e('Upload photo (optional)', 'taskbot');?>:</label>
								<div class="tb-uploadarea" id="taskbot-upload-attachment">
									<ul class="tb-uploadbar tb-bars taskbot-fileprocessing taskbot-infouploading" id="taskbot-fileprocessing"></ul>
									<div class="tb-uploadbox taskbot-dragdroparea" id="taskbot-droparea" >
										<em>
											<?php esc_html_e('You can upload jpg,jpeg,gif,png,zip,rar,mp3 mp4 and pdf only. Maks sure your file does not exceed 3mb.', 'taskbot');?>
											<label for="file2">
												<span id="taskbot-attachment-btn-clicked">
													<input id="file2" type="file" name="file">
													<?php esc_html_e('Click here to upload', 'taskbot');?>
												</span>
											</label>
										</em>
									</div>
								</div>
							</div>
							<div class="form-group tb-dbtnarea tb-dbtnarea-row">
								<a href="javascript:void(0);" class="tb-btn resolve-dispute-btn"  data-task_order_id="<?php echo esc_attr($order_id); ?>" data-buyer-id="<?php echo esc_attr($buyer_id); ?>" data-seller-id="<?php echo esc_attr($seller_id); ?>" data-dispute-id="<?php echo esc_attr($dispute_id); ?>" data-task-id="<?php echo esc_attr($task_id); ?>"><?php esc_html_e('Submit', 'taskbot');?><span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
								<em><?php esc_html_e('Click “Submit” to add dispute feedback', 'taskbot');?></em>
							</div>
						</div>
					</fieldset>
				</form>
			<?php }?>
		</div>
	</div>
</div>
<script type="text/template" id="tmpl-load-chat-media-attachments">
	<li id="thumb-{{data.id}}" class="taskbot-list tb-uploading">
		<div class="tb-filedesciption">
			<span>{{data.name}}</span>
			<input type="hidden" class="attachment_url" name="attachments[{{data.attachment_id}}]" value="{{data.url}}">
			<em class="tb-remove"><a href="javascript:void(0)" class="taskbot-remove-attachment tb-remove-attachment"><?php esc_html_e('remove', 'taskbot');?></a></em>
		</div>
		<div class="progress">
			<div class="progress-bar uploadprogressbar" style="width:0%"></div>
		</div>
	</li>
</script>
<div class="col-xl-5 tb-disputedetailorder">
	<div class="tb-disputearea tb-disputesummery">
		<div class="tb-disputemain">
			<div class="tb-tabbitem__list">
				<div class="tb-deatlswithimg">
					<div class="tb-disputedisc">
						<div class="tb-bordertags">
							<span class="tb-tag-bordered"><?php echo esc_html(taskbot_dispute_status($dispute_id));?></span>
						</div>
						<span><?php echo esc_html(date_i18n( get_option( 'date_format' ),  strtotime($dispute_post->post_date)));?></span>
						<h5><a target="_blank" href="<?php echo esc_url(get_the_permalink( $task_id ));?>"><?php echo esc_html(get_the_title($task_id));?></a></h5>
					</div>
				</div>
			</div>
		</div>
		<div class="tb-extrasarticles">
			<div class="tb-db-extrasarticles">
				<div class="tb-articletitle">
					<h4><?php echo esc_html($_dispute_key);?></h4>
				</div>
				<div class="tb-articlediscription">
					<?php echo wpautop(nl2br($dispute_post->post_content));?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="tb-disputearea-wrapper">
		<div class="tb-dbholder">
			<div class="tb-dbbox tb-dbboxtitle">
				<h5><?php esc_html_e('Dispute conversation', 'taskbot');?></h5>
			</div>
			<div class="tb-dbbox">
				<ul class="tb-conversation">
					<?php
					$args = array(
						'post_id' => $dispute_id,
						'hierarchical' => true,
						'order'     => 'ASC',
					);
					$comments = get_comments( $args );
					foreach ($comments as $key => $comment) {

						if(!empty($comment->comment_parent)){
							continue;
						}

						$date			= !empty( $comment->comment_date ) ? $comment->comment_date : '';
						$author_id		= !empty( $comment->user_id ) ? $comment->user_id : '';
						$comments_id	= !empty( $comment->comment_ID ) ? $comment->comment_ID : '';
						$date			= !empty( $date ) ? date_i18n('F j, Y', strtotime($date)) : '';
						$author			= !empty( $comment->comment_author ) ? $comment->comment_autho : '';
						$message		= $comment->comment_content;
						$user 			= get_userdata( $author_id );
						
						if(empty($user)){	
							continue;
						}
						$user_roles 	= $user->roles;

						if (!empty($user_roles) && is_array($user_roles) && in_array( 'administrator', $user_roles, true ) ) {
							$author_name       		= $user->display_name;
							$avatar					= get_avatar_url( $user->ID, ['size' => '80']  );
							$comment_author_type	= esc_html__('Administrator', 'taskbot');
						} else {
							$comment_user_type	= apply_filters('taskbot_get_user_type', $author_id);
							$linked_profile_id		= taskbot_get_linked_profile_id($author_id, '', $comment_user_type);
							
							if($comment_user_type == 'sellers'){
								$comment_author_type	= esc_html__('Seller', 'taskbot');
							} elseif($comment_user_type == 'buyers'){
								$comment_author_type	= esc_html__('Buyer', 'taskbot');	
							} else {
								$comment_author_type	= esc_html__('Administrator', 'taskbot');
							}
							$author_name       		= taskbot_get_username($linked_profile_id);
							$avatar	= apply_filters(
								'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $linked_profile_id), array('width' => 100, 'height' => 100)
							);
						}

						$message_files	= get_comment_meta( $comment->comment_ID, 'message_files', true);
						$child_comments	= get_comments(array('parent' => $comments_id, 'hierarchical' => true, 'order' => 'ASC'));
						?>
						<li>
							<div class="tb-conversation__content" id="comment-<?php echo intval($comment->comment_ID);?>">
								<div class="tb-conversation__header">
									<?php if(!empty($avatar)){?>
										<img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($author_name);?>">
									<?php }?>
									<div class="tb-conversation__title">
										<?php if(!empty($comment_author_type)){?>
											<span><?php echo esc_html(ucfirst($comment_author_type));?></span>
										<?php }?>
										<?php if(!empty($author_name)){?>
											<h5><?php echo esc_html($author_name);?></h5>
										<?php }?>
									</div>
									<?php if(!in_array($dispute_resolve_status, array('resolved', 'refunded'))){ ?>
										<a href="javascript:void(0);" class="tb-btn taskbot-comment-reply" data-comment_id="<?php echo intval($comments_id);?>"><?php esc_html_e('Reply', 'taskbot');?><span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
									<?php }?>
								</div>
								<?php if(!empty($message)){?>
									<div class="tb-conversation__detail">
										<?php echo wpautop(nl2br($message));?>
									</div>
								<?php }?>
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
							<?php if(!empty($child_comments)){?>
								<?php foreach ($child_comments as $key => $comment) {
									$child_comment_author_id	= !empty( $comment->user_id ) ? $comment->user_id : '';
									$comment_author_type      	= apply_filters('taskbot_get_user_type', $child_comment_author_id);
									$linked_profile_id 			= taskbot_get_linked_profile_id($child_comment_author_id, '', $comment_author_type);
									$author_name       			= taskbot_get_username($linked_profile_id);
									$child_comment_message		= $comment->comment_content;

									$user		= get_userdata( $child_comment_author_id );
									if(empty($user)){	
										continue;
									}
									$user_roles	= $user->roles;

									if (!empty($user_roles) && is_array($user_roles) && in_array( 'administrator', $user_roles, true ) ) {
										$author_name	= $user->display_name;
										$avatar			= get_avatar_url( $user->ID, ['size' => '80'] );
										$comment_author_type	= esc_html__('Administrator', 'taskbot');
									} else {
										$comment_user_type	= apply_filters('taskbot_get_user_type', $child_comment_author_id);
										$linked_profile_id	= taskbot_get_linked_profile_id($author_id, '', $comment_user_type);
										if($comment_user_type == 'sellers'){
											$comment_author_type	= esc_html__('Seller', 'taskbot');
										} elseif($comment_user_type == 'buyers'){
											$comment_author_type	= esc_html__('Buyer', 'taskbot');	
										} else {
											$comment_author_type	= esc_html__('Administrator', 'taskbot');
										}
										$author_name       		= taskbot_get_username($linked_profile_id);
										$avatar	= apply_filters(
											'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $linked_profile_id), array('width' => 100, 'height' => 100)
										);
									}

									$message_files	= get_comment_meta( $comment->comment_ID, 'message_files', true);
									?>
									<div class="tb-conversation__content" id="comment-<?php echo intval($comment->comment_ID);?>">
										<div class="tb-conversation__header">
											<?php if(!empty($avatar)){?>
												<figure><img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($author_name);?>"></figure>
											<?php }?>
											<div class="tb-conversation__title">
												<?php if(!empty($comment_author_type)){?>
													<span><?php echo esc_html(ucfirst($comment_author_type));?></span>
												<?php }?>
												<?php if(!empty($author_name)){?>
													<h5><?php echo esc_html($author_name);?></h5>
												<?php }?>
											</div>
										</div>
										<?php if (!empty($child_comment_message)){ ?>
										<div class="tb-conversation__detail">
											<?php echo wpautop(nl2br($child_comment_message));?>
										</div>
										<?php }?>
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
														<a href="<?php echo esc_url( $file_url ); ?>" class="tb-download-attachment" data-id="<?php echo esc_attr( $comments_id ); ?>" ><img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $file_uname ); ?>"></a>
													</li>

													<?php } ?>
												</ul>

												<a href="javascript:void(0);" class="tb-download-attachment" data-id="<?php echo esc_attr( $comments_id ); ?>" ><?php esc_html_e('Download file(s)', 'taskbot');?></a>
											</div>
										<?php } ?>

									</div>
								<?php }?>
							<?php }?>
						</li>
					<?php }?>

				</ul>
				<?php if($dispute_resolve_status !== 'resolved'){?>
					<form class="tb-themeform tb-refundform_form" id="dispute-reply-form">
						<input type="hidden" name="dispute_id" id="dispute_id" value="<?php echo intval($dispute_id);?>" >
						<input type="hidden" name="sender_id" id="sender_id" value="<?php echo intval($sender_id);?>" >
						<input type="hidden" name="parent_comment_id" id="parent_comment_id" value="0" >
						<input type="hidden" name="action_type" id="action_type" value="reply" >
						<div class="tb-disputereply">
							<h5><?php esc_html_e('Dispute Reply', 'taskbot');?>:</h5>
							<textarea class="form-control" id="dispute_comment" name="dispute_comment" placeholder="<?php esc_attr_e('Enter dispute reply', 'taskbot');?>"></textarea>
						</div>
						<div class="tb-disputebtn">
							<a href="javascript:void(0);" id="dispute-reply-btn" class="tb-btn"><?php esc_html_e('Submit', 'taskbot'); ?><span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
							<em><?php esc_html_e('Click “Submit” to add dispute reply', 'taskbot');?></em>
						</div>
					</form>
				<?php }?>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-3 tb-task-admin-history">
	<?php do_action('taskbot_order_budget_details', $order_id, $user_type);?>
	<?php taskbot_get_template_part('dashboard/dashboard', 'tasks-activity-history');?>
</div>