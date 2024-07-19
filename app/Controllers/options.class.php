<?php
/**
 * Testimonials Settings
 *
 * @return void
 */

namespace AIOS\Testimonials\Controllers;

class Options {

	/**
	 * Prevent undefined varible when saving empty data
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @return array
	 */
	public static function options(){
		$aios_testimonials_settings = get_option( 'aios_testimonials_settings' );
		if( !empty( $aios_testimonials_settings ) ) extract( $aios_testimonials_settings );
		
		return array(
			'permastructure' 			=> ( isset( $permastructure ) ? $permastructure : 'testimonial' ),
			'main_page' 				=> ( isset( $main_page ) ? $main_page : '' ),
			'testimonials_source' 		=> ( isset( $testimonials_source ) ? $testimonials_source : '' ),
			'order_by' 					=> ( isset( $order_by ) ? $order_by : 'DESC' ),
			'order' 					=> ( isset( $order ) ? $order : '' ),
			'post_per_page' 			=> ( isset( $post_per_page ) ? $post_per_page : '9' ),
			'public_innerpage' 			=> ( isset( $public_innerpage ) ? $public_innerpage : '' ),
			'enable_permalinks' 		=> ( isset( $enable_permalinks ) ? $enable_permalinks : '' ),
			'zillow_api' 				=> ( isset( $zillow_api ) ? $zillow_api : '' ),
			'screen_name' 				=> ( isset( $screen_name ) ? $screen_name : '' ),
			'bridge_api' 				=> ( isset( $bridge_api ) ? $bridge_api : '' ),
			'bridgeAPI_screen_name' 	=> ( isset( $bridgeAPI_screen_name ) ? $bridgeAPI_screen_name : '' ),
			'bridge_api_reviewee_key' 	=> ( isset( $bridge_api_reviewee_key ) ? $bridge_api_reviewee_key : '' ),
			'client_fullname' 			=> ( isset( $client_fullname ) ? $client_fullname : '' ),
			'primary_color' 			=> ( isset( $primary_color ) ? $primary_color : '#bfb183' ),
			'breadcrumbs_heirarchy' 	=> ( isset( $breadcrumbs_heirarchy ) ? $breadcrumbs_heirarchy : '' ),
		);
	}
}