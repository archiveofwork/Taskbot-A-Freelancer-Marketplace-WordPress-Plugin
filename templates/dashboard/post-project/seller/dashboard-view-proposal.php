<?php
    $proposal_id	= !empty($args['id']) ? intval($args['id']) : 3767;
    $project_id     = get_post_meta( $proposal_id, 'project_id', true );    
    $project_id     = !empty($project_id) ? intval($project_id) : 0;
    $product            = wc_get_product($project_id);
    $product_author_id  = get_post_field ('post_author', $project_id);
    $linked_profile_id  = taskbot_get_linked_profile_id($product_author_id, '','buyers');
    $user_name          = taskbot_get_username($linked_profile_id);
?>
<div id="fixed-project" class="tk-projectdetail-sidebar mCustomScrollbar">
    <div class="tk-project-wrapper-two">
        <div class="tk-project-box tk-employerproject">
            <div class="tk-employerproject-title">
                <?php do_action( 'taskbot_seller_proposal_status_tag', $proposal_id );?>
                <?php do_action( 'taskbot_project_type_tag', $project_id );?>
                <div class="tk-verified-info">
                    <?php echo esc_html($user_name);?><?php do_action( 'taskbot_verification_tag_html', $linked_profile_id ); ?>
                    <?php if( !empty($product->get_name()) ){?>
                        <h5><?php echo esc_html($product->get_name());?></h5>
                    <?php } ?>
                </div>
                <ul class="tk-template-view"> 
                    <?php do_action( 'taskbot_posted_date_html', $product );?>
                    <?php do_action( 'taskbot_location_html', $product );?>
                    <?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','tb-icon-briefcase' );?>
                    <?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
                </ul>
            </div>
            <a href="javascript:void(0)" class="tk-sidebar-close"><i class="tb-icon-x"></i></a>
        </div>
    </div>
</div>