<?php

    use AIOS\Testimonials\Controllers\Options;

    get_header();

    $testimonials_settings 		= Options::options();
    if( !empty( $testimonials_settings ) ) extract( $testimonials_settings );

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $aioscm_used_custom_title   = get_post_meta( get_queried_object()->ID, 'aioscm_used_custom_title', true );
    $aioscm_main_title          = get_post_meta( get_queried_object()->ID, 'aioscm_main_title', true );
    $aioscm_sub_title           = get_post_meta( get_queried_object()->ID, 'aioscm_sub_title', true );


    $args = array(
        'post_type' 		=> 'aios-testimonials',
        'posts_per_page' 	=> $post_per_page,
        'paged' 			=> $paged,
        'order' 			=> $order,
        'orderby' 			=> $order_by,
        'ignore_custom_sort' => true

    );
    $testimonials = new WP_Query( $args );

    $pageId = get_the_ID();
?>

<div class="ai-classic-testimonials-wrap">

        <div id="content">
            <?php do_action('aios_starter_theme_before_inner_page_content') ?>



            <?php if ( !empty(get_the_content()) ) : ?>

            <div class="aios-testimonials-content entry">
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

            <?php endif; ?>


        </div>
        <div class="ai-classic-testimonials-container">
        <?php if ( $testimonials->have_posts() ) : ?>

            <?php $counter = 0 ; ?>
            <!-- the loop -->
            <?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

                <?php
                    $post_id        = get_the_ID();
                    $popup_id       = 'ai-classic-testimonials-results-popup-'.$post_id.'';
                    $content_count  = $counter == 0 ? '350' : '244';
                    $aios_testimonials_role         = get_post_meta( $post_id, 'aios_testimonials_role', true );
                    $aios_testimonials_image            = get_post_meta( $post_id, 'aios_testimonials_image', true );
                    $aios_testimonials_video_type         = get_post_meta( $post_id, 'aios_testimonials_video_type', true );
                    $aios_testimonials_video_url            = get_post_meta( $post_id, 'aios_testimonials_video_url', true );
    
                    $imageType =    $aios_testimonials_image != '' ? '<canvas width="86" height="86" style="background-image: url('.wp_get_attachment_url($aios_testimonials_image).')"></canvas>' : '<canvas class="tquote-icon" width="79" height="79"></canvas>';
                    $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );

                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

                    $imageContainer = '';
                    $hideContent = '';
                    $hasImage = '';
                ?>

                <div class="ai-classic-testimonials" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">
                    <a href="<?= $public_innerpage == 'yes' ? get_the_permalink() : '#'.$popup_id.'' ?>" class="<?=$public_innerpage == 'yes' ? '' : 'aios-content-popup' ?>">
                        <?php
                            if ($counter == 0) {
                                $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                                if (!is_custom_field_banner(get_queried_object()) || $aios_metaboxes_banner_title_layout != 'Inside Banner' || $aios_metaboxes_banner_title_layout[1] != 1) {
                                    $aioscm_used_custom_title   = get_post_meta($pageId, 'aioscm_used_custom_title', true);
                                    $aioscm_main_title          = get_post_meta($pageId, 'aioscm_main_title', true);
                                    $aioscm_sub_title           = get_post_meta($pageId, 'aioscm_sub_title', true);
                                    $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title($pageId);
                                    echo '<h1 class="entry-title"><span>' . $aioscm_title . '</span></h1>';
                                }
                            }
                        ?>
                        <?php if(!empty($featured_image) && !empty($aios_testimonials_video_url ) || !empty($featured_image) && empty($aios_testimonials_video_url )) : ?>
                        <?php 
                            $imageContainer = ' <div class="aios-testimonials-image">'.get_the_post_thumbnail($post_id, 'full').'</div>';
                            $hideContent = 'hide-content';

                            $hasImage = 'has-image';
                        ?>
                        <?php endif; ?>


                        <div class="ai-classic-testimonials-content <?= $hasImage ?>">
                        

                        <?= $imageContainer; ?>
                       
                        
                        <div class="aios-classic-testimonials-content-in <?= $hideContent ?>">
                        <?= $counter == 0 ? '<div class="ai-classic-testimonials-big-icon">'.$imageType.'</div>' : '' ?>
                        <?php if ( has_excerpt( $post_id ) ) : ?>
                            <?php wpautop(the_excerpt()); ?>
                        <?php else: ?>
                            <?php echo wpautop(mb_strimwidth(strip_tags(get_the_content()), 0, $content_count, "..."))?>
                        <?php endif ?>
                        </div>
                        </div>
                        <div class="ai-classic-testimonials-rating">
                            <span>READ MORE</span>
                            <div class="ai-classic-rating-star">
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                                <i class="ai-font-star-fill"></i>
                            </div>
                        </div>
                        <div class="ai-classic-testimonials-icon">
                            <div><?= $imageType ?></div>
                            <div>
                                <h3><?php the_title(); ?></h3>
                                <em><?=$aios_testimonials_role?></em>
                            </div>
                        </div>

                        <div class="aios-testimonials-hide">
                            <div class="ai-classic-testimonials-results-popup <?=$popup_id?>" id="<?=$popup_id?>">
                            
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
                                <div class="ai-classic-testimonials-content">
                                   <div class="ai-classic-testimonials-big-icon"><?=$imageType?></div>
                                    <?= wpautop(strip_tags(get_the_content()))?>
                                </div>
                                 <div class="ai-classic-testimonials-icon">
                                    <div></div>
                                    <div>
                                        <h3><?php the_title(); ?></h3>
                                        <em><?=$aios_testimonials_role?></em>
                                    </div>
                                </div>
                            </div>

                        </div><!-- end of popup -->

                    </a>
                </div><!-- end of testimonials -->

            <?php $counter++; ?>
        <?php endwhile; ?>

         <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>

        </div><!-- end of testimonials classic -->
        <div class="ai-classic-testimonials-pagination">
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
<?php get_footer()?>
