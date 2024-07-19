<?php
/**
 * Default Config
 *
 * @return void
 */

namespace AIOS\Testimonials\Config;


class Config{

	/**
	 * Option Tabs.
	 *
	 * @since 2.8.8
	 *
	 * @access public
	 * @return array
	 */
	public static function options_tabs($tabs = []) {
		$tabs = [
			'' => [
				'url' 		=> 'aios-testimonials-themes',
				'title' 	=> 'Themes',
				'function'	=> 'themes/themes.php'
			],
			'advanced' => [
				'url' 		=> 'Options',
				'title' 	=> 'Options',
				'function'	=> 'options/settings.php'
			],
			'boilerplate' => [
				'url' 		=> 'boilerplate',
				'title' 	=> 'Boilerplate',
				'function'	=> 'boilerplate/boilerplate.php'
			],
			'documentation' => [
				'url' 		=> 'documentation',
				'title' 	=> 'documentation',
				'function'	=> 'documentation/documentation.php'
			]
		];

		return array_filter( $tabs );
	}

	/**
	 * Theme Locations Paths.
	 *
	 * @param $theme_path
	 * @return array
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public static function template_location( $theme_path ) {
		$folder = [
			[
				'path' =>AIOS_TESTIMONIALS_DIR . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $theme_path . DIRECTORY_SEPARATOR, /** This resides in the plugin **/
				'url' => AIOS_TESTIMONIALS_URL . 'templates/' . $theme_path . '/',
				'location_name' => 'core'
			],
			[
				'path' => realpath( get_stylesheet_directory() ) . DIRECTORY_SEPARATOR . 'aios-testimonials' . DIRECTORY_SEPARATOR, /** This resides in the current theme or child theme. Gets deleted when theme is deleted.  **/
				'url' => get_stylesheet_directory_uri() . '/aios-testimonials/',
				'location_name' => 'active-theme'
			],
			[
				'path' => realpath( WP_CONTENT_DIR ) . DIRECTORY_SEPARATOR . 'aios-testimonials' . DIRECTORY_SEPARATOR, /** This resides in the wp-content folder to prevent deleting when upgrading themes. Recommended location. **/
				'url' => WP_CONTENT_URL . '/aios-testimonials/' . $theme_path . '/',
				'location_name' => 'wp-content'
			]
		];

		return array_filter( $folder );
	}

	/**
	 * List of Themes
	 *
	 * @param $page_theme
	 * @return array
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public static function get_template_location($page_theme) {
		$lists = [];
		$inactiveLists = [];
		$template_locations = self::template_location($page_theme);
		$templates = [];
		$current_template = get_option( 'testimonials-themes', 'default-core');
		$filteredTemplates = get_transient('aios-filtered-templates');
		$filteredTemplates = $filteredTemplates === 'Unauthorized' ? [] : $filteredTemplates;
		$filteredTemplates = $filteredTemplates ? $filteredTemplates['testimonials'][$page_theme] : [];

		/** BEGIN: Check if Template Locations is Array **/
		if ( is_array( $template_locations ) ) {
			foreach ( $template_locations as $template_location ) {
				/** BEGIN: Check if Template Locations is DIR **/
				if( is_dir( $template_location['path'] ) ) {
					/** BEGIN: Scan DIR **/
					if( $all_files = scandir( $template_location['path'] ) ){
						/** Remove DIR **/
						$files = array_diff( $all_files, array( '.', '..' ) );
						/** BEGIN: Check if each DIR **/
							foreach ( $files as $file) {
								$template_path = $template_location['path'] . $file;
								$template_file = $template_location['path'] . $file . DIRECTORY_SEPARATOR . 'options.php';
								$template_functions = $template_location['path'] . $file . DIRECTORY_SEPARATOR . 'functions.php';
								$template_screenshot = $template_location['url'] . $file . '/screenshot.jpg';
								$template_screenshot_dir = $template_location['path'] . $file . DIRECTORY_SEPARATOR . 'screenshot.jpg';

								/** BEGIN: Check if is directory and a file exists and duplicate folder **/
								if ( is_dir( $template_path ) && @file_exists( $template_functions ) && !in_array( $file, $templates) ) {
									array_push( $templates, $file );

									$fname = $file . '-' . $template_location['location_name'];
									$is_active = ( $current_template == $fname ? 'active-template' : '' );
									$template_shortpath = str_replace( realpath( WP_CONTENT_DIR ) . DIRECTORY_SEPARATOR, '', $template_path );
									$template_screenshot = @file_exists( $template_screenshot_dir ) ? $template_screenshot : AIOS_TESTIMONIALS_URL_ASSETS_IMG . '/screenshot.jpg';
									$filterName = ucwords(str_replace('-', ' ', $file));
									$isAvailable = strpos($template_path, 'plugins') !== false ? ($filteredTemplates[$file]['available'] ?? false) : true;

									$templateData = [
										'template_name' => strpos($template_path, 'plugins') !== false ? ($filteredTemplates[$file]['name'] ?? $filterName) : $filterName,
										'template_fullname' => $fname,
										'template_path' => $template_path,
										'template_file' => $template_file,
										'template_functions' => $template_functions,
										'template_screenshot' => $template_screenshot,
										'is_active' => $is_active,
										'location_name' => $template_location['location_name'],
										'product_type' => strpos($template_path, 'plugins') !== false ? ($filteredTemplates[$file]['type'] ?? 'agent-pro') : 'agent-pro',
										'available' => strpos($template_path, 'plugins') !== false ? ($filteredTemplates[$file]['available'] ?? false) : true
									];

									if ($isAvailable) {
										$lists[$fname] = $templateData;
									} else {
										$inactiveLists[$fname] = $templateData;
									}
								}
								/** END: to Check if is directory and a file exists **/
							}
						/** END: Check if each DIR **/
					}
					/** END: Scan DIR **/
				}
				/** END: heck if Template Locations is DIR **/
			}
		}
		/** END: Check if Template Locations is Array **/

		return array_filter(array_merge($lists, $inactiveLists));
	}
}
