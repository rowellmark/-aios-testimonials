<?php

use AIOS\Testimonials\Controllers\Options;

get_header();

$testimonials_settings         = Options::options();
if (!empty($testimonials_settings)) extract($testimonials_settings);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


$url = 'http://www.zillow.com/webservice/ProReviews.htm?zws-id=' . $zillow_api . '&screenname=' . $screen_name . '&count=10&returncompletecontent=true&returnTeamMemberReviews=true';
$result = file_get_contents($url);
$xml = simplexml_load_string($result);

$data  = json_encode($xml);

$finalData = json_decode($data);

$reviews = $finalData->response->result->proReviews->review;


?>

<section id="aios-testimonials" class="aios-testimonials-page">
    <div id="content">
        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php
            $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
            if (!is_custom_field_banner(get_queried_object()) || $aios_metaboxes_banner_title_layout != 'Inside Banner' || $aios_metaboxes_banner_title_layout[1] != 1) {
                $aioscm_used_custom_title   = get_post_meta(get_the_ID(), 'aioscm_used_custom_title', true);
                $aioscm_main_title          = get_post_meta(get_the_ID(), 'aioscm_main_title', true);
                $aioscm_sub_title           = get_post_meta(get_the_ID(), 'aioscm_sub_title', true);
                $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                echo '<h1 class="archive-title">' . $aioscm_title . '</h1>';
            }
        ?>


        <?php if (!empty(get_the_content())) : ?>

            <div class="aios-testimonials-content entry">
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>" alt="<?= get_the_title() ?>">
                <?php else : ?>
                    <?php if (!empty($default_photo)) : ?>
                        <img src="<?= $default_photo ?>" alt="<?= get_the_title() ?>">
                    <?php endif ?>
                <?php endif; ?>

                <?= wpautop(the_content()); ?>

                <div class="clear"></div>
            </div>

        <?php endif; ?>
    </div>

    <div class="aios-testimonials">


        <?php $counter = 0; ?>
        <?php foreach ($reviews as $key => $review) : ?>

            <?php
            $id                   = $key;
            $popup_id             = 'aios-testimonials-popup-' . $id . '';
            $reviewer             = $review->reviewer;
            $description          = $review->description;
            $reviewSummary        = $review->reviewSummary;
            $reviewDate           = $review->reviewDate;
            $reviewURL            = $review->reviewURL;
            $content_count  = $counter == 0 ? '350' : '244';
            ?>
            <div class="aios-testimonials-lists" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">
                <a href="<?= $public_innerpage == 'yes' ? $reviewURL : '#' . $popup_id . '' ?>" class="<?= $public_innerpage == 'yes' ? '' : 'aios-content-popup' ?>">
                    <div class="star_rating_display">
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                    </div>
                    <div class="aios-testimonials-content">
                        <?php echo wpautop(mb_strimwidth(strip_tags($description), 0, $content_count, "...")) ?>
                    </div>
                    <h3><?= $reviewer ?></h3>
                </a>
                <div class="aios-testimonials-popup <?= $popup_id ?>" id="<?= $popup_id ?>">
                    <div class="star_rating_display">
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                        <i class="ai-font-star-fill"></i>
                    </div>
                    <div class="aios-testimonials-popup-content">
                        <?= wpautop(strip_tags($description)) ?>
                    </div>
                    <h2><?= $reviewer ?></h2>
                </div><!-- end of popup -->

            </div><!-- end of testimonials lists -->

            <?php $counter++; ?>
        <?php endforeach ?>


    </div><!-- end aios-testimonials -->
    <?php do_action('aios_starter_theme_after_inner_page_content') ?>
</section><!-- end #content -->
<?php
get_footer();
?>