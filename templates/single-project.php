<?php

/**
 *
 * The template used for displaying task detail
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $post, $thumbnail,$current_user;
do_action('taskbot_post_views', $post->ID,'taskbot_project_views');
get_header();
while (have_posts()) : the_post();
	$product 				= wc_get_product( $post->ID );
	$product_cat 			= wp_get_post_terms( $post->ID, 'product_cat', array( 'fields' => 'ids' ) );
	$post_status			= get_post_status( $post->ID );
	$post_author			= get_post_field( 'post_author', $post->ID );
	$allow_user				= true;
	$linked_profile			= "";

	$description    = !empty($product) ? $product->get_description() : "";
	$user_id    	= get_post_field( 'post_author', $product->get_id() );
	$user_id    	= !empty($user_id) ? intval($user_id) : 0;
	
	//check if proposal is submitted
	if( is_user_logged_in() ){
		$taskbot_user_proposal  = 0;
		$proposal_args = array(
			'post_type' 	    => 'proposals',
			'post_status'       => 'any',
			'posts_per_page'    => -1,
			'author'            => $current_user->ID,
			'meta_query'        => array(
				array(
					'key'       => 'project_id',
					'value'     => intval($post->ID),
					'compare'   => '=',
					'type'      => 'NUMERIC'
				)
			)
		);

		$proposals                  = get_posts( $proposal_args );
		$taskbot_user_proposal      = !empty($proposals) && is_array($proposals) ? count($proposals) : 0; 
		$proposal_edit_link = !empty($proposals) ? taskbot_get_page_uri('submit_proposal_page').'?id='.intval($proposals[0]->ID) : '';
	}

	if(!empty($post_status) && in_array($post_status,array('draft','rejected','pending','refunded','disputed','hired'))){
		if( !is_user_logged_in( ) ){
			$allow_user			= false;
		} else {
			if( is_user_logged_in() && (current_user_can('administrator') || $current_user->ID == $post_author) ){
				$allow_user		= true;
			} else {
				$allow_user		= false;
				if(!empty($taskbot_user_proposal)){
					$allow_user		= true;
				}
			}
		}
	}	

	$download_class	= '';
	$submint_class	= '';
	$page_url		= '';
	if( !is_user_logged_in( ) ){
		$download_class	= 'tb-login-seller';
		$submint_class	= 'tb-login-seller';
	} else {
		if( is_user_logged_in() && (current_user_can('administrator') || $current_user->ID == $post_author) ){
			$download_class	= 'tb_download_files';
			$submint_class	= 'tb-login-seller';
		} else {
			$user_type  		= apply_filters('taskbot_get_user_type', $current_user->ID );
			$linked_profile     = taskbot_get_linked_profile_id($current_user->ID, '', $user_type);
			
			if( !empty($user_type) && $user_type === 'sellers' ){
				$download_class	= 'tb_download_files';
				$submint_class	= 'tb-page-link';
				$page_url		= !empty($post->ID) ?taskbot_get_page_uri('submit_proposal_page').'?post_id='.intval($post->ID) : '';
			} else if( !empty($user_type) && $user_type === 'buyers' ){
				$download_class	= 'tb-authorization-required';
				$submint_class	= 'tb-redirect-url';
			}
		}
	}
		
	$profile_id 	= !empty($user_id) ? taskbot_get_linked_profile_id($user_id, '', 'buyers') : 0;
	$user_name  	= !empty($profile_id) ? taskbot_get_username($profile_id) : '';
	$product_data   = get_post_meta($product->get_id(), 'tb_project_meta', true);
	$downloadable  	= get_post_meta( $product->get_id(), '_downloadable',true );
	$vid_url		= !empty($product_data['video_url']) ? esc_url($product_data['video_url']) : '';
		
	?>
	<section class="tb-main overflow-hidden tb-main-bg">
		<div class="container">
			<?php
				if( empty($allow_user) ){
					do_action( 'taskbot_notification', esc_html__('Restricted access','taskbot'), esc_html__('Oops! you are not allowed to access this page','taskbot') );
				} else {?>
				<div class="row gy-4">
					<div class="col-lg-7 col-xl-8">
						<div class="tk-projectbox">
							<?php do_action( 'taskbot_featured_item', $product,'featured_project' );?>
							<div class="tk-project-box">
								<div class="tk-servicedetailtitle">
									<h3><?php echo esc_html($product->get_name());?></h3>
									<ul class="tk-blogviewdates">
										<?php do_action( 'taskbot_posted_date_html', $product );?>
										<?php do_action( 'taskbot_location_html', $product );?>
									</ul>
								</div>
							</div>
							<div class="tk-project-box">
								<?php if( !empty($vid_url) ){?>
									<div class="tk-project-holder">
										<?php
											$vid_width		= 780;
											$vid_height		= 402;
											$url 			= parse_url( $vid_url );
											$video_html		= '';
											if ($url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com') {
												$video_html	.= '<figure class="tk-projectdetail-img">';
												$content_exp  = explode("/" , $vid_url);
												$content_vimo = array_pop($content_exp);
												$video_html	.= '<iframe width="' . esc_attr( $vid_width ) . '" height="' . esc_attr( $vid_height ) . '" src="https://player.vimeo.com/video/' . $content_vimo . '" 
											></iframe>';
												$video_html	.= '</figure>';
											} else if($url['host'] == 'youtu.be') {
												$video_html	.= '<figure class="tk-projectdetail-img">';
												$video_html	.= preg_replace(
													"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
													"<iframe width='" . esc_attr( $vid_width ) ."' height='" . esc_attr( $vid_height ) . "' src=\"//www.youtube.com/embed/$2\" frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
													$vid_url
												);
												$video_html	.= '</figure>';
											} else if($url['host'] == 'dai.ly') {
												$path		= str_replace('/','',$url['path']);
												$content	= str_replace('dai.ly','dailymotion.com/embed/video/',$vid_url);
												$video_html	.= '<figure class="tk-projectdetail-img">';
													$video_html	.= '<iframe width="' . esc_attr( $vid_width ) . '" height="' . esc_attr( $vid_height ) . '" src="' . esc_url( $content ) . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
												$video_html	.= '</figure>';
											}else {
												$video_html	.= '<figure class="tk-projectdetail-img">';
												$content = str_replace(array (
													'watch?v=' ,
													'http://www.dailymotion.com/' ) , array (
													'embed/' ,
													'//www.dailymotion.com/embed/' ) , $vid_url);
												$content	= str_replace('.com/video/','.com/embed/video/',$content);
												$video_html	.= '<iframe width="' . esc_attr( $vid_width ) . '" height="' . esc_attr( $vid_height ) . '" src="' . esc_url( $content ) . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
												$video_html	.= '</figure>';
											}
											if( !empty($video_html) ){
												echo do_shortcode( $video_html );
											}
										?>
									</div>
								<?php } ?>
								<?php if( !empty($description) ){?>
									<div class="tk-project-holder tk-project-description">
										<div class="tk-project-title">
											<h4><?php esc_html_e('Job description','taskbot');?></h4>
										</div>
										<div class="tk-jobdescription">
											<?php echo do_shortcode(nl2br ($description) );?>
										</div>
									</div>
								<?php } ?>
								<?php do_action( 'taskbot_term_tags_html', $product->get_id(),'skills',esc_html__('Skills required','taskbot') );?>
								<?php if( !empty($downloadable) && $downloadable === 'yes' ){?>
									<div class="tk-project-holder">
										<div class="tk-betaversion-wrap">
											<div class="tk-betaversion-info">
												<h5><?php esc_html_e('Attachments available to download','taskbot');?></h5>
												<p><?php echo sprintf(esc_html__('Download project helping material provided by “%s”','taskbot'),$user_name);?></p>
											</div>
											<div class="tk-downloadbtn">
												<span class="tk-btn-solid-lefticon <?php echo esc_attr($download_class);?>" data-id="<?php echo intval($product->get_id());?>" data-order_id=""><?php esc_html_e('Download files','taskbot');?> <i class="icon-download"></i></span>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-xl-4">
                        <aside>
                            <div class="tk-projectbox">
                                <div class="tk-project-box tk-projectprice">
                                    <div class="tk-sidebar-title">
                                        <?php do_action( 'taskbot_project_type_tag', $product->get_id() );?>
                                        <?php do_action( 'taskbot_project_price_html', $product->get_id() );?>
										<?php do_action( 'taskbot_project_estimation_html', $product->get_id() );?>
                                    </div>
                                    <div class="tk-sidebarpkg__btn">
										<?php 
										if( is_user_logged_in() &&  intval($current_user->ID) === intval( $post_author ) ){
											//do nothing
										}else if( is_user_logged_in() && !empty($taskbot_user_proposal) ){?>
											<span><a href="<?php echo esc_url($proposal_edit_link);?>" class="tk-btn-solid-lg-lefticon tb-page-link"><?php esc_html_e('Edit proposal','taskbot');?></a></span>
										<?php 
										}else{
											if( !empty($post_status) && $post_status === 'publish') {?>
												<span class="tk-btn-solid-lg-lefticon <?php echo esc_attr($submint_class);?>" data-url="<?php echo esc_url($page_url);?>"><?php esc_html_e('Apply to this project','taskbot');?></span>
											<?php }
										} ?>
                                        <?php do_action( 'taskbot_project_saved_item', $product->get_id(), '','_saved_projects' );?>
                                    </div>
                                </div>
                                <div class="tk-project-box">
                                    <div class="tk-sidebar-title">
                                        <h5><?php esc_html_e('Project requirements','taskbot');?></h5>
                                    </div>
                                    <ul class="tk-project-requirement">
                                       <?php do_action( 'taskbot_total_hiring_freelancer_html', $product->get_id() );?>
									   <?php do_action( 'taskbot_texnomies_html', $product->get_id(),'expertise_level',esc_html__('Expertise','taskbot'),'icon-briefcase tk-darkred-icon' );?>
                                       <?php do_action( 'taskbot_texnomies_html', $product->get_id(),'languages',esc_html__('Languages','taskbot'),'icon-book-open tk-yellow-icon' );?>
                                       <?php do_action( 'taskbot_texnomies_html', $product->get_id(),'duration',esc_html__('Project duration','taskbot'),'icon-calendar tk-green-icon' );?>
									   <?php do_action( 'taskbot_after_project_requirements', $product->get_id());?>
                                    </ul>
                                </div>
                            </div>
							<?php do_action( 'taskbot_project_seller_basic', $product->get_id() );?>
                        </aside>
                    </div>
                </div>
				<?php taskbot_get_template('dashboard/post-project/related-projects.php',array('project_id' => $product->get_id()));?>
			<?php } ?>
		</div>
	</section>
<?php
endwhile;

$script = "TaskbotShowMore('.description-with-more');";
wp_add_inline_script( 'taskbot', $script, 'after' );

get_footer();

