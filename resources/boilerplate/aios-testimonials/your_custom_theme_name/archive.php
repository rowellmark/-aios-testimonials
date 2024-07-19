<?php

use AIOS\Testimonials\Controllers\Options;

get_header();

$testimonials_settings         = Options::options();
if (!empty($testimonials_settings)) extract($testimonials_settings);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$aioscm_used_custom_title   = get_post_meta(get_queried_object()->ID, 'aioscm_used_custom_title', true);
$aioscm_main_title          = get_post_meta(get_queried_object()->ID, 'aioscm_main_title', true);
$aioscm_sub_title           = get_post_meta(get_queried_object()->ID, 'aioscm_sub_title', true);


$args = array(
    'post_type'         => 'aios-testimonials',
    'posts_per_page'     => $post_per_page,
    'paged'             => $paged,
    'order'             => $order,
    'orderby'             => $order_by,
    'ignore_custom_sort' => true
);
$testimonials = new WP_Query($args);
$aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );

?>

    <?php if ($testimonials->have_posts()) : ?>

        <?php $counter = 0; ?>
        <!-- the loop -->
        <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>

            <?php
                $post_id        = get_the_ID();
                $popup_id       = 'aios-testimonials-popup-' . $post_id . '';
                $content_count  = $counter == 0 ? '350' : '244';
                $aios_testimonials_video_type         = get_post_meta( $post_id, 'aios_testimonials_video_type', true );
                $aios_testimonials_video_url            = get_post_meta( $post_id, 'aios_testimonials_video_url', true );
                $aios_testimonials_role         = get_post_meta( $post_id, 'aios_testimonials_role', true );


                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

                $imageContainer = '';
                $hideContent = '';
                $hasImage = '';
            ?>
            <?php $counter++; ?>
        <?php endwhile; ?>
        <!-- end of the loop -->

        
        <?php
            $big = 999999999; // need an unlikely integer
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $testimonials->max_num_pages,
                'prev_text'    => __('<a href="#" class="aios-testimonials-prev"><i class="ai-font-arrow-b-p"></i></a>'),
                'next_text'    => __('<a href="#" class="aios-testimonials-next"><i class="ai-font-arrow-b-n"></i></a>'),
                'type' => 'list'
            ));
        ?>



        <?php wp_reset_postdata(); ?>

    <?php else : ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
<?php
get_footer();
?>