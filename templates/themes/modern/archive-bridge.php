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

<!-- BEGIN: Wrapper -->
<div class="ai-modern-testimonials">

    <div id="content">

        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <!-- BEGIN: Heading -->
        <div class="ai-modern-testimonials-heading">
            <?php
                $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                if (!is_custom_field_banner(get_queried_object()) || $aios_metaboxes_banner_title_layout != 'Inside Banner' || $aios_metaboxes_banner_title_layout[1] != 1) {
                    $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                    $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                    $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                    $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                    echo '<h1 class="entry-title"><span>' . $aioscm_title . '</span></h1>';
                }
            ?>
        </div>
        <!-- END: Heading -->

        <?php if(!empty(get_the_content())) : ?>
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
                
        <div class="clear"></div>
    </div>
  <!-- BEGIN: Results -->
  <div class="ai-modern-testimonials-results">


  
        <?php 
        
            $counter = 0;
            $reviews = $data['value'];

            foreach ($reviews as $key => $review) :

            $id                   = $key;
            $popup_id             = 'aios-testimonials-popup-' . $id . '';
            $screenName = $review['ReviewerScreenName'];
            $fullName = $review['ReviewerFullName'];
            $name = !empty($fullName) ? $fullName : $screenName;
            $description = $review['Description'];
            $content_count  = $counter == 0 ? '350' : '244';


            $imageType =    '<div class="ai-modern-testimonials-results-content-quote-svg"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 298.667 298.667" xml:space="preserve"><g><polygon points="0,170.667 64,170.667 21.333,256 85.333,256 128,170.667 128,42.667 0,42.667"/><polygon points="170.667,42.667 170.667,170.667 234.667,170.667 192,256 256,256 298.667,170.667 298.667,42.667 "/></g></svg></div>';
        ?>

          <!-- BEGIN: Item -->
          <div class="ai-modern-testimonials-results-item">
            <!-- BEGIN: Content -->
            <div class="ai-modern-testimonials-results-wrapper">
                <article class="ai-modern-testimonials-results-content">
                    <h2 class="ai-modern-testimonials-results-content-name"><?= $name ?></h2>

                    <div class="ai-modern-testimonials-results-content-quote">
                    <?= $imageType ?>
                    </div>

                    <div class="ai-modern-testimonials-content-text">
                        <?php echo wpautop(mb_strimwidth(strip_tags($description), 0, $content_count, "...") )?>
                    </div>

                    <a href="#<?= $popup_id ?>" class="ai-modern-testimonials-results-readmore aios-content-popup">Read More+</a>

                    <div class="aios-testimonials-hide">
                        <div class="ai-modern-testimonials-results-popup <?= $popup_id ?>" id="<?= $popup_id ?>">
                             <div class="ai-modern-testimonials-results-popup-content">
                                <h2 class="ai-modern-testimonials-results-content-name"><?= $name ?></h2>
                                

                                <div class="ai-modern-testimonials-results-content-quote">
                                <?= $imageType ?>
                                </div>
                                <?= wpautop(strip_tags($description))?>
                             </div>
                        </div>
                    </div><!-- popup -->

                </article>
            </div>
            <!-- END: Content -->
            </div>
            <!-- END: Item -->

        <?php $counter++; ?>
        <?php endforeach ?>
  </div>
  <!-- END: Results -->

</div>
<?php do_action('aios_starter_theme_after_inner_page_content') ?>
<!-- END: Wrapper -->
<?php get_footer() ?>