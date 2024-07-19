<?php

/** 
*
* AIOS Testimonials
*
*/

use AIOS\Testimonials\Controllers\Options;

if ( ! class_exists( 'agentpro_testimonials_shortcodes' ) ) {
    class agentpro_testimonials_shortcodes {

        private $testimonials_settings;

        function __construct() {
            $this->testimonials_settings = Options::options();
            add_shortcode( 'aios_testimonials', [ $this, 'aios_testimonials_post_type' ] );
            add_shortcode( 'aios_testimonials_zillow', [ $this, 'aios_testimonials_zillow' ] );
        }
        
        /**
         * Returns the latest/featured testimonials
         */
        public function aios_testimonials_post_type( $atts, $content = null ) {

            $atts = shortcode_atts( [
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'order' => 'DESC',
                'orderby' => 'post_date',
                'excerpt_limit' => '',
                'exceprt_more_text' => '...',
                'is_featured' => false,
                'show_attributes' => false,
                'show_featured' => 'no',
                'show_posts_by_slug' => '',
                'show_posts_by_id' => '',
                'agents_id' => '',

            ], $atts );
            
            // for shortcode attributes helper
            if ( $atts[ 'show_attributes' ] ) {
                echo '<pre>';
                var_dump( $atts );
                echo '</pre>';
                
                return;
                exit;
            }
            
            extract( $atts ); // create variables using the above array keys

            $meta_query = array(
                'relation' => 'AND'
            );

            $show_posts_by_slug = explode(',', $atts['show_posts_by_slug']);
            $show_posts_by_id   = explode(',', $atts['show_posts_by_id']);

            if ($show_featured == 'yes'){
                $meta_query[] = array(
                    'key' => 'aios_testimonials_featured',
                    'value' => 'yes',
                    'compare' => '='
                );
            }


            $post_name_in = ['post_name__in' =>  $show_posts_by_slug];
            $post_id_in = ['post__in' => $show_posts_by_id];

            $agents_testimonials = '';
            if(!empty($agents_id)){
                /// sync to agents module
                $args = [
                    'post_type' => 'aios-agents',
                    'post__in'  => explode(',', $agents_id),
                ];

                $agents = new WP_Query( $args );

                foreach($agents as $agent){
                    $agent_id = $agent->ID;

                    $testimonials_ids  = get_post_meta( $agent_id, 'agent_testimonials', true );

                    if(!empty($testimonials_ids)){

                        $agents_testimonials = ['post__in' => $testimonials_ids];
                    }
                }
            }

            $args = [
                'post_type' => 'aios-testimonials',
                'post_status' => $post_status,
                'posts_per_page' => $posts_per_page,
                'order' => $order,
                'orderby' => $orderby,
                'meta_query' => $meta_query,
            ];

            
            if(!empty($agents_id)){
                $args = array_merge($args, $agents_testimonials);
            }

            if($atts['show_posts_by_id'] != ''){
                $args = array_merge($args, $post_id_in);
            }

            if($atts['show_posts_by_slug'] != ''){
                $args = array_merge($args, $post_name_in);
            }

            $testimonials_post = new WP_Query( $args );
            
            if ( $testimonials_post->have_posts() ) {
                while ( $testimonials_post->have_posts() ) {
                    $testimonials_post->the_post();
                    
                    /** 
                    * 
                    * Shortcode Guide
                    * 
                    * {{testimonial_id}} => returns ID
                    * {{testimonial_title}} => returns name
                    * {{testimonial_content}} => returns content
                    * {{testimonial_excerpt}} => returns excerpt
                    * {{testimonial_permalink}} => returns permalink
                    * {{testimonial_rate_value}} => returns the rating value
                    * {{testimonial_rate_loop}}{{/testimonial_rate_loop}} => returns a for loop using the rating value of the testimonial
                    * 
                    **/
                    
                    $testimonial_id             = get_the_ID();
                    $testimonial_title          = get_the_title();
                    $testimonial_content        = get_the_content();
                    $testimonial_excerpt        = get_the_content();
                    $testimonial_permalink      = get_the_permalink();
                    $testimonial_role           = get_post_meta( $testimonial_id, 'aios_testimonials_role', true );
                    $testimonials_video_url     = get_post_meta( $testimonial_id, 'aios_testimonials_video_url', true );
                    

                    $testimonial_featured_image = wp_get_attachment_url(get_post_meta( $testimonial_id, 'aios_testimonials_image', true ));
                    if ( $excerpt_limit ) {
                        $excerpt_length = strlen( $testimonial_excerpt );
                        
                        $excerpt_more_length = strlen( $exceprt_more_text );
                        if ( $excerpt_length > $excerpt_limit + $excerpt_more_length ) {
                            $testimonial_excerpt = substr( $testimonial_excerpt, 0, $excerpt_limit );
                            $testimonial_excerpt .= $exceprt_more_text;
                        }
                    }
                    
                    $duplicatedContent = $content;
                    
                    $replacement_values = [
                        'testimonial_id',
                        'testimonial_title',
                        'testimonial_content',
                        'testimonial_excerpt',
                        'testimonial_permalink',
                        'testimonial_role',
                        'testimonial_featured_image',
                        'testimonials_video_url'
                    ];
                    
                    foreach ( $replacement_values as $replacement_value ) {
                        $duplicatedContent = str_replace( '{{' . $replacement_value . '}}', ${ $replacement_value }, $duplicatedContent );
                    }

                    
                    $newContent .= $duplicatedContent;
                }
                wp_reset_postdata();
                
                $response = do_shortcode( $newContent );
            }
            else {
                $response = $no_results_text;
            }
            
            return $response;
        }



         /**
         * Returns the Zillow Reviews
         */
        public function aios_testimonials_zillow( $atts, $content = null ) {

             extract($this->testimonials_settings);

            $atts = shortcode_atts( [
                'count'   => '10',
                'excerpt'   => '100'
            ], $atts );
        
            extract( $atts ); // create variables using the above array keys

         

            $x = 0;
            $count = 10; // max count 10
            $star = '';

            $url = 'http://www.zillow.com/webservice/ProReviews.htm?zws-id='.$zillow_api.'&screenname='.$screen_name.'&count=10&returncompletecontent=true&returnTeamMemberReviews=true';
            $result = file_get_contents($url);
            $xml = simplexml_load_string($result);

            $data  = json_encode($xml);

            $finalData = json_decode($data);

            $reviews = $finalData->response->result->proReviews->review;


            foreach($reviews as $key=>$review){
                /** 
                * 
                * Shortcode Guide
                * 
                * {{testimonial_id}} => returns ID
                * {{testimonial_title}} => returns name
                * {{testimonial_content}} => returns content
                * {{testimonial_excerpt}} => returns excerpt
                * {{testimonial_permalink}} => returns permalink
                * {{testimonial_rate_value}} => returns the rating value
                * {{testimonial_rate_loop}}{{/testimonial_rate_loop}} => returns a for loop using the rating value of the testimonial
                * 
                **/
                    
                $id                    = $key;
                $reviewer             = $review->reviewer;
                $description          = $review->description;
                $reviewSummary        = $review->reviewSummary;
                $reviewDate           = $review->reviewDate;
                $reviewURL            = $review->reviewURL;
                $description_excerpt  = strlen($review->description) > $excerpt ? substr($review->description,0,$excerpt)."..." : $review->description;

                $duplicatedContent = $content;
                
                $replacement_values = [
                    'id',
                    'reviewer',
                    'description',
                    'reviewSummary',
                    'reviewDate',
                    'reviewURL',
                    'description_excerpt'
                    
                ];
                
                foreach ( $replacement_values as $replacement_value ) {
                    $duplicatedContent = str_replace( '{{' . $replacement_value . '}}', ${ $replacement_value }, $duplicatedContent );
                }

                
                $newContent .= $duplicatedContent;

                $response = do_shortcode( $newContent );
            
              
            }

            return $response;
        }

        



    }
    $agentpro_testimonials_shortcodes = new agentpro_testimonials_shortcodes();
}