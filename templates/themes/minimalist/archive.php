<?php

    use AIOS\Testimonials\Controllers\Options;

    get_header();

    $testimonials_settings 		= Options::options();
    if( !empty( $testimonials_settings ) ) extract( $testimonials_settings );

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;


    $args = array(
        'post_type' 		=> 'aios-testimonials',
        'posts_per_page' 	=> $post_per_page,
        'paged' 			=> $paged,
        'order' 			=> $order,
        'orderby' 			=> $order_by,
        'ignore_custom_sort' => true

    );
    $testimonials = new WP_Query( $args );
?>

<div id="ai-minimalist-testimonials-wrap">

        <div id="content">
            <?php do_action('aios_starter_theme_before_inner_page_content') ?>


            <?php
                $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                if (!is_custom_field_banner(get_queried_object()) || $aios_metaboxes_banner_title_layout != 'Inside Banner' || $aios_metaboxes_banner_title_layout[1] != 1) {
                    $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                    $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                    $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                    $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                    echo '<h1 class="archive-title" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">' . $aioscm_title . '</h1>';
                }
            ?>


            <?php if(!empty(get_the_content())) : ?>

            <div class="aios-testimonials-content entry" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">
                <?php if ( has_post_thumbnail() ) : ?>                                    
                    <img src="<?= get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?>" alt="<?= get_the_title() ?>">
                    <?php else : ?>
                    <?php if (!empty($default_photo) ) : ?>
                    <img src="<?= $default_photo ?>" alt="<?= get_the_title()?>">
                    <?php endif ?>
                <?php endif; ?>

                <?= wpautop(the_content()); ?>
                
                <div class="clear"></div>
            </div>

            <?php endif;?>


        </div>
       

        <div class="ai-minimalist-testimonials-lists">

                <?php if ( $testimonials->have_posts() ) : ?>
                    <?php $counter = 0 ; ?>
                    <!-- the loop -->
                    <?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

                    <?php
                        $post_id        = get_the_ID();
                        $popup_id       = 'ai-minimalist-testimonials-results-popup-' . $post_id . '';
                        $popup_id       = sanitize_text_field($popup_id);
                        $content_count  = $counter == 0 ? '400' : '244';
                        $aios_testimonials_role         = get_post_meta( $post_id, 'aios_testimonials_role', true );
                        $aios_testimonials_image            = get_post_meta( $post_id, 'aios_testimonials_image', true );
                        $aios_testimonials_video_type         = get_post_meta( $post_id, 'aios_testimonials_video_type', true );
                        $aios_testimonials_video_url            = get_post_meta( $post_id, 'aios_testimonials_video_url', true );

                        $imageType =    $aios_testimonials_image != '' ? '<canvas width="90" height="90" style="background-image: url('.wp_get_attachment_url($aios_testimonials_image)    .')"></canvas>' : '<svg 
                                 xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="25px" height="22px">
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                                 d="M6.476,12.298 L9.374,0.022 L5.282,0.022 L1.702,11.786 C1.247,13.037 0.948,13.989 0.807,14.642 C0.664,15.296 0.594,15.963 0.594,16.645 C0.594,17.953 1.005,19.047 1.830,19.927 C2.653,20.809 3.748,21.248 5.112,21.248 C6.361,21.248 7.414,20.822 8.266,19.970 C9.119,19.117 9.545,18.009 9.545,16.645 C9.545,15.566 9.274,14.642 8.735,13.875 C8.194,13.107 7.442,12.583 6.476,12.298 L6.476,12.298 ZM20.968,12.298 L23.866,0.022 L19.774,0.022 L16.194,11.786 C15.738,13.037 15.440,13.989 15.299,14.642 C15.156,15.296 15.086,15.963 15.086,16.645 C15.086,17.953 15.497,19.047 16.322,19.927 C17.145,20.809 18.240,21.248 19.604,21.248 C20.853,21.248 21.906,20.822 22.758,19.970 C23.611,19.117 24.037,18.009 24.037,16.645 C24.037,15.566 23.766,14.642 23.227,13.875 C22.686,13.107 21.933,12.583 20.968,12.298 L20.968,12.298 Z"/> </svg>';
                    
                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

                    $imageContainer = '';
                    $hideContent = '';
                    $hasImage = '';


                    ?>
                    <?php if(!empty($featured_image) && !empty($aios_testimonials_video_url ) || !empty($featured_image) && empty($aios_testimonials_video_url )) : ?>
                        <?php 
                            $imageContainer = ' <div class="aios-testimonials-image">'.get_the_post_thumbnail($post_id, 'full').'</div>';
                            $hideContent = 'hide-content';

                            $hasImage = 'has-image';
                        ?>
                    <?php endif; ?> 


                    <div class="ai-minimalist-testimonials-list <?= $hasImage ?>"  data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">
                        <a href="<?=$public_innerpage == 'yes' ? get_the_permalink() : '#'.$popup_id.'' ?>" class="<?=$public_innerpage == 'yes' ? '' : 'aios-content-popup' ?>">
                            
                            

                            <?= $imageContainer; ?>
                        
                            <div class="ai-minimalis-testimonials-cont <?= $hideContent ?>">
                                <?php if ( has_excerpt( $post_id ) ) : ?>
                                    <?php wpautop(the_excerpt()); ?>
                                <?php else: ?>
                                    <?php echo wpautop(mb_strimwidth(strip_tags(get_the_content()), 0, $content_count, "..."))?>
                                <?php endif ?>
                            </div>
                            <h3><?= the_title() ?></h3>
                           <h4><?= $aios_testimonials_role ?></h4>
                            <div class="ai-minimalist-testimonials-rating">
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                            </div>
                            <div class="ai-classic-testimonials-image-holder">
                                <div>
                                   <?= $imageType ?>
                                </div>
                            </div>
                            <div class="ai-minimalist-testimonials-hover">
                                <div>
                                    <em class="ai-font-magnifying-glass-b"></em>
                                    <span>read more</span>
                                </div>
                            </div>
                        </a>
                        <div class="aios-testimonials-hide">
                            <div class="ai-minimalist-testimonials-results-popup <?=$post_id?>" id="<?=$popup_id?>">
                                
                                  
                                <?php if(empty($aios_testimonials_video_url)) : ?>
                                    <?php if(!empty($featured_image)) : ?>
                                        <?php echo $imageContainer ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (!empty($aios_testimonials_video_type)) : ?>
                                
                                <!-- video area -->
                                <?php if(!empty($aios_testimonials_video_url)) : ?>
                                    <?php if ($aios_testimonials_video_type == 'url') : ?>
                                        <div class="aios-testimonials-video">
                                            <canvas width="1600" height="800"></canvas>
                                            <iframe
                                                src="<?= parseVideos($aios_testimonials_video_url) ?>"
                                                allowfullscreen
                                                allowtransparency
                                            ></iframe>
                                        </div>
                                    <?php elseif ($aios_testimonials_video_type == 'mp4') : ?>
                                        <div class="aios-testimonials-video">
                                            <video class="aios-testimonials-video-players" controls data-poster="<?= $featured_image[0]?>">
                                                <source src="<?= $aios_testimonials_video_url ?>" type="video/mp4" />
                                            </video>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>                            
                                <!-- video area -->
                            <?php endif; ?> 

                            <?= wpautop(strip_tags(get_the_content())) ?>
                                <h3><?= the_title() ?></h3>
                                 <h4><?= $aios_testimonials_role ?></h4>
                                 <div class="ai-minimalist-testimonials-rating">
                                    <i class="ai-font-star-fill"></i>
                                    <i class="ai-font-star-fill"></i>
                                    <i class="ai-font-star-fill"></i>
                                    <i class="ai-font-star-fill"></i>
                                    <i class="ai-font-star-fill"></i>
                                </div>
                                <div class="ai-classic-testimonials-image-holder">
                                    <div>
                                       <?= $imageType ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- popup -->
                    </div>
                    <!-- END: Item -->
                    <?php $counter++; ?>
                    <?php endwhile; ?>
                    <!-- end of the loop -->

                <?php wp_reset_postdata(); ?>

                <?php else : ?>
                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                <?php endif; ?>

        </div><!-- end of minimalist lists -->

        <div class="ai-minimalist-testimonials-pagination">
            <?php
             $big = 999999999; // need an unlikely integer
             echo paginate_links( array(
                 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                 'format' => '?paged=%#%',
                 'current' => max( 1, get_query_var('paged') ),
                 'total' => $testimonials->max_num_pages,
                 'prev_text'    => __(' <a href="#" class="ai-modern-testimonials-results-arrow aios-testimonials-prev"><i class="ai-font-arrow-b-p"></i></a>'),
                 'next_text'    => __(' <a href="#" class="ai-modern-testimonials-results-arrow aios-testimonials-next"><i class="ai-font-arrow-b-n"></i></a>'),
                 'type' => 'list'
             ) );
            ?>
        </div>
        <?php do_action('aios_starter_theme_after_inner_page_content') ?>
</div>

<?php get_footer() ?>