<?php

use AIOS\Testimonials\Controllers\Options;

get_header();

$testimonials_settings         = Options::options();
if (!empty($testimonials_settings)) extract($testimonials_settings);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$aioscm_used_custom_title   = get_post_meta(get_queried_object()->ID, 'aioscm_used_custom_title', true);
$aioscm_main_title          = get_post_meta(get_queried_object()->ID, 'aioscm_main_title', true);
$aioscm_sub_title           = get_post_meta(get_queried_object()->ID, 'aioscm_sub_title', true);

$url = 'http://www.zillow.com/webservice/ProReviews.htm?zws-id='.$zillow_api.'&screenname='.$screen_name.'&count=10&returncompletecontent=true&returnTeamMemberReviews=true';
$result = file_get_contents($url);
$xml = simplexml_load_string($result);

$data  = json_encode($xml);

$finalData = json_decode($data);

$reviews = $finalData->response->result->proReviews->review;
$aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );

?>
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
        
    <?php endforeach ?>
<?php
get_footer();
?>