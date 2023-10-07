<?php
/**
 * Single task gallery
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global $product;
$attachment_ids     = $product->get_gallery_image_ids();
$product_video      = get_post_meta($product->get_id(), '_product_video', true);
$vid                = !empty($product_video) ? $product_video : '';
$featured           = $product->get_featured();
$width              = 856;
$height             = 400;
$min_width          = 100;
$min_height         = 100;
$thmnail_html       = '';

if (!empty($attachment_ids) || !empty($vid)) { ?>
    <div id="tb_splide" class="tb-sync splide">
        <div class="splide__track">
            <ul class="splide__list">
                <?php if (!empty($vid)) {
                    $vid_width  = 856;
                    $vid_height = 400;
                    $url        = parse_url($vid);
                    $image_url  = TASKBOT_DIRECTORY_URI . '/public/images/video.jpg';
                    $thmnail_html .= '<li class="splide__slide">
                              <figure class="tb-syncthumbnail__content">
                              <span class="tb-servicesvideo"></span>
                                <img src="' . esc_url($image_url) . '" alt="' . esc_attr('Task video', 'taskbot') . '">
                              </figure>
                            </li>'; ?>
                    <li class="splide__slide tb_tasb-video">
                        <figure class="tb-sync__content">
                            <a href="javascript:void(0);">
                                <?php if (!empty($url['host']) && ($url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com')) {
                                    $content_exp    = explode("/", $vid);
                                    $content_vimo   = array_pop($content_exp);
                                    ?>
                                    <figure class="tb-classimg tb-media-single">
                                        <iframe width="<?php echo esc_attr($vid_width) ?>" height="<?php echo esc_attr($vid_height) ?>" src="<?php echo esc_url("https://player.vimeo.com/video/" . $content_vimo) ?> "></iframe>
                                    </figure>
                                    <?php
                                } elseif (!empty($url['host']) && $url['host'] == 'soundcloud.com') {
                                    $video = wp_oembed_get($vid, array('height' => $vid_height));
                                    $search = array('webkitallowfullscreen', 'mozallowfullscreen', 'frameborder="0"');
                                    $source = str_replace($search, '', $video);
                                    ?>
                                    <figure class="tb-classimg tb-media-single">
                                        <?php echo do_shortcode($source); ?>
                                    </figure>
                                    <?php

                                } else if (!empty($url['host']) && $url['host'] == 'youtu.be') {
                                    $source = preg_replace(
                                        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                                        "<iframe width='" . esc_attr($vid_width) . "' height='" . esc_attr($vid_height) . "' src=\"//www.youtube.com/embed/$2\" frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
                                        $vid
                                    );
                                    ?>
                                    <figure class="tb-classimg tb-media-single">
                                        <?php echo do_shortcode($source); ?>
                                    </figure>
                                    <?php
                                } else {
                                    $content = str_replace(
                                        array('watch?v=', 'http://www.dailymotion.com/'),
                                        array('embed/', '//www.dailymotion.com/embed/'),
                                        $vid
                                    );
                                    ?>
                                    <figure class="tb-classimg tb-media-single">
                                        <iframe width="<?php echo esc_attr($vid_width) ?>"
                                                height="<?php echo esc_attr($vid_height) ?>"
                                                src="<?php echo esc_url($content); ?>" frameborder="0"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                    </figure>
                                    <?php
                                }?>
                            </a>
                        </figure>
                    </li>
                    <?php
                }

                if (!empty($attachment_ids)) {
                    foreach ($attachment_ids as $attachment_id) {
                        $image_link     = wp_get_attachment_url($attachment_id);
                        $thumb_url      = wp_get_attachment_image_src($attachment_id, array($width, $height), true);
                        $thumb_url      = !empty($thumb_url[0]) ? $thumb_url[0] : '';

                        $full_thumb_url = wp_get_attachment_image_src($attachment_id, 'full', true);
                        $full_thumb_url = !empty($full_thumb_url[0]) ? $full_thumb_url[0] : '';

                        $min_thumb_url  = wp_get_attachment_image_src($attachment_id, array($min_width, $min_height), true);
                        $min_thumb_url  = !empty($min_thumb_url[0]) ? $min_thumb_url[0] : '';
                        $image_name     = get_the_title($attachment_id);

                        if (!empty($thumb_url)) {
                            $thmnail_html .= '<li class="splide__slide">';
                                $thmnail_html .= '<figure class="tb-syncthumbnail__content">';
                                    $thmnail_html .= '<img src="' . esc_url($min_thumb_url) . '" alt="' . esc_attr($image_name) . '">';
                                $thmnail_html .= '</figure>';
                            $thmnail_html .= '</li>'; ?>
                            <li class="splide__slide">
                                <figure class="tb-sync__content">
                                    <a class="venobox" data-gall="gall" href="<?php echo esc_url($full_thumb_url); ?>">
                                        <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($image_name); ?>">
                                    </a>
                                </figure>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <?php if (!empty($thmnail_html)) { ?>
        <div id="tb_splidev2" class="tb-syncthumbnail splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php echo do_shortcode($thmnail_html); ?>
                </ul>
            </div>
        </div>
    <?php }
    $is_rtl			= taskbot_splide_rtl_check();
    $script = 'jQuery(document).ready(function () {
        var tb_splide = document.getElementById("tb_splide");
            if (tb_splide !== null) {
              var secondarySlider = new Splide( "#tb_splidev2", {
                rewind      : true,
                direction      : "'.esc_js($is_rtl).'",
                fixedWidth  : 80,
                fixedHeight : 80,
                isNavigation: true,
                gap         : 10,
                pagination  : false,
                arrows     : false,
                focus  : "center",
                updateOnMove: true
              } ).mount();

              var primarySlider = new Splide( "#tb_splide", {
                type       : "fade",
                pagination : false,
                cover      : true,
              } )
              primarySlider.sync( secondarySlider ).mount();
            }
            let venobox = document.querySelector(".venobox");
            if (venobox !== null) {
              jQuery(".venobox").venobox();
            }
      });';
    wp_add_inline_script('splide', $script, 'after');
}
