<?php

use AIOS\Testimonials\Controllers\Options;

class aiosTestimonialsBreadcrumbsController
{


    /**
     * Breadcrumbs Contructor
     */
    public function __construct()
    {

        add_filter( 'wpseo_breadcrumb_links', [$this, 'yoast_permalinks']);
    }

    /*
    * Breadcrumbs Permalinks Controller 
    * Version 1.4.7
    */
    function yoast_permalinks( $links ) 
    {

        global $post;

        $testimonials_settings 		= Options::options();
        if( !empty( $testimonials_settings ) ) extract( $testimonials_settings );

        // return if the heirachy option was disable
        if($breadcrumbs_heirarchy == 'true'){
            $post_id = $post->ID;
            if ( get_post_type() == 'aios-testimonials') {
                if(!empty($main_page)){
                    $breadcrumb[] = array(
                        'url' =>  get_permalink($main_page),
                        'text' =>  get_the_title($main_page),
                    );
                }
                array_splice( $links, 1, -2, $breadcrumb );
            }
           
        }
        return $links;
    }
}

new aiosTestimonialsBreadcrumbsController();
