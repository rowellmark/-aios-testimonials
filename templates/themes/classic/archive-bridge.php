<?php

    use AIOS\Testimonials\Controllers\Options;

    get_header();

    $testimonials_settings 		= Options::options();
    if( !empty( $testimonials_settings ) ) extract( $testimonials_settings );

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // Attempt to get data from transient
    $data = get_transient('aios_testimonials_bridge_reviews');

    // Check if transient is not available
    if (false === $data) {
        // Your existing code to make the API request
        $url = 'https://api.bridgedataoutput.com/api/v2/OData/reviews/Reviews?access_token=' . $bridge_api . '&$filter=RevieweeKey%20eq%20\'' . $bridge_api_reviewee_key . '\'%20and%20Rating%20gt%204';

        // Fetch data from the API
        $response = file_get_contents($url);

        // Decode JSON response
        $data = json_decode($response, true);

        // Save data to transient with a 3-hour expiration
        set_transient('aios_testimonials_bridge_reviews', $data, 3 * HOUR_IN_SECONDS);
    }

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
        <?php endif;?>
    </div>
    <div class="ai-classic-testimonials-container">

            <?php 
       
                $counter = 0;
                $reviews = $data['value'];

                foreach ($reviews as $key => $review) :

                $id                   = $key;
                $popup_id             = 'ai-classic-testimonials-results-popup-' . $id . '';
                $screenName = $review['ReviewerScreenName'];
                $fullName = $review['ReviewerFullName'];
                $name = !empty($fullName) ? $fullName : $screenName;
                $description = $review['Description'];
                $content_count  = $counter == 0 ? '350' : '244';

           ?>

    
            <div class="ai-classic-testimonials" data-aos="fade-up"  data-aos-duration="500" data-aos-once="true">
                <a href="#<?= $popup_id ?>" class="aios-content-popup">
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
                    <div class="ai-classic-testimonials-content">
                    <?= $counter == 0 ? '<div class="ai-classic-testimonials-big-icon">'.$imageType.'</div>' : '' ?>
                
                    <?php echo wpautop(mb_strimwidth(strip_tags($description), 0, $content_count, "...") )?>
                
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
                        <div class="ai-classic-testimonials-big-icon"><?=$imageType?></div>
                        <div>
                            <h3><?= $name ?></h3>
                        </div>
                    </div>

                    <div class="aios-testimonials-hide">
                        <div class="ai-classic-testimonials-results-popup <?=$popup_id?>" id="<?=$popup_id?>">
                            <div class="ai-classic-testimonials-content">
                                <div class="ai-classic-testimonials-big-icon"><canvas class="tquote-icon" width="79" height="79"></canvas></div>
                                <?= wpautop(strip_tags($description))?>
                            </div>
                                <div class="ai-classic-testimonials-icon">
                                <div></div>
                                <div>
                                    <h3><?= $name ?></h3>
                                </div>
                            </div>
                        </div>

                    </div><!-- end of popup -->

                </a>
            </div><!-- end of testimonials -->
            <?php $counter++; ?>
        <?php endforeach ?>

        <div class="ai-classic-testimonials-pagination">
        </div>
    </div>
    <?php do_action('aios_starter_theme_after_inner_page_content') ?>
</div>
<?php get_footer()?>
