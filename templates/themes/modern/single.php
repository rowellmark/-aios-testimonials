<?php get_header();

    use AIOS\Testimonials\Controllers\Options;
    $testimonials_settings 		= Options::options();
    if( !empty( $testimonials_settings ) ) extract( $testimonials_settings );

    $post_id    = get_the_ID();
    $role  = get_post_meta( $post_id, 'aios_testimonials_role', true );
?>

<div id="<?php echo ai_starter_theme_get_content_id('content-sidebar') ?>">
	<article id="content" class="hfeed">

		<?php do_action('aios_starter_theme_before_inner_page_content') ?>

		<?php if(have_posts()) : ?>

            <?php while(have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php
                        $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );

                        if ( ! is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                            $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                            $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                            $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();

                            echo '<h1 class="entry-title">' . $aioscm_title . '</h1>';
                        }else{

                            echo '<h1 class="entry-title">'. get_the_title() .'</h1>';

                        }
                    ?>
                    <h3><?= $role ?></h3>
                    <div class="ai-testimonials-single-rating-star">
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                    </div>
                    <?php do_action('aios_starter_theme_before_entry_content') ?>

                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </div>
                    <?php endif ?>

                    <div class="entry entry-content">
                        <?php the_content(); ?>
                    </div>

                    <?php do_action('aios_starter_theme_after_entry_content') ?>

                </div>

            <?php endwhile; ?>

            <div class="back-to-link">
                <a href="<?= get_permalink($main_page) ?>" class="global-link-hover">Back To Testimonials</a>
            </div>

            <div class="navigation">
                <?php wp_link_pages(); ?>
            </div>

        <?php endif; ?>


		<?php do_action('aios_starter_theme_after_inner_page_content') ?>

    </article><!-- end #content -->

    <?php get_sidebar(); ?>
</div><!-- end #content-sidebar -->

<?php get_footer(); ?>