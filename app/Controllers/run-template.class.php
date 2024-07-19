<?php
/**
 * Common methods to create input, select, and textarea
 *
 * @return void
 */

namespace AIOS\Testimonials\Controllers;

use AIOS\Testimonials\Config\Config;


class aios_testimonials_run_template
{

	public function __construct()
	{
		$pattern = '/(-core|-active-theme|-wp-content)/';

		$testimonials_theme = Config::get_template_location( 'themes' );
		$current_template = get_option( 'testimonials-themes', 'default-core' );

		if (isset($testimonials_theme[$current_template]['is_active']) && $testimonials_theme[$current_template]['is_active'] == 'active-template') {
			require_once( $testimonials_theme[ $current_template ][ 'template_functions' ] );
		}
	}
}

$aios_testimonials_run_template = new aios_testimonials_run_template();
