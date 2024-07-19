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

<div class="ai-classic-testimonials-wrap">

    <div id="content">
        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php if (!empty(get_the_content())) : ?>
            <div class="aios-testimonials-content entry">
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?= get_the_post_thumbnail_url($pageId, 'full') ?>" alt="<?= get_the_title() ?>">
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
    <div class="ai-classic-testimonials-container">

        <?php $counter = 0; ?>
        <?php foreach ($reviews as $key => $review) : ?>

            <?php
            $id                   = $key;
            $popup_id             = 'ai-classic-testimonials-results-popup-' . $id . '';
            $reviewer             = $review->reviewer;
            $description          = $review->description;
            $reviewSummary        = $review->reviewSummary;
            $reviewDate           = $review->reviewDate;
            $reviewURL            = $review->reviewURL;
            $content_count  = $counter == 0 ? '350' : '244';
            $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');


            ?>
            <div class="ai-classic-testimonials" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">
                <a href="<?= $public_innerpage == 'yes' ? $reviewURL : '#' . $popup_id . '' ?>" class="<?= $public_innerpage == 'yes' ? '' : 'aios-content-popup' ?>">
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
                        <?= $counter == 0 ? '<div class="ai-classic-testimonials-big-icon">' . $imageType . '</div>' : '' ?>

                        <?php echo wpautop(mb_strimwidth(strip_tags($description), 0, $content_count, "...")) ?>

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
                        <div class="ai-classic-testimonials-big-icon"><?= $imageType ?></div>
                        <div>
                            <h3><?= $reviewer ?></h3>
                        </div>
                    </div>

                    <div class="aios-testimonials-hide">
                        <div class="ai-classic-testimonials-results-popup <?= $popup_id ?>" id="<?= $popup_id ?>">
                            <div class="ai-classic-testimonials-content">
                                <div class="ai-classic-testimonials-big-icon"><canvas class="tquote-icon" width="79" height="79"></canvas></div>
                                <?= wpautop(strip_tags($description)) ?>
                            </div>
                            <div class="ai-classic-testimonials-icon">
                                <div></div>
                                <div>
                                    <h3><?= $reviewer ?></h3>
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
        <?php do_action('aios_starter_theme_after_inner_page_content') ?>
    </div>
    <?php get_footer() ?>