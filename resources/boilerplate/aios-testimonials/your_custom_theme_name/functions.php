<?php

/**
 * Default Config
 *
 * @return void
 */

use AIOS\Testimonials\Controllers\Options;

if (!class_exists('aios_testimonials_details_page_template_default')) {

	class aios_testimonials_details_page_template_default
	{

		private $template_url;
		private $template_dir;
		private $testimonials_settings;

		/*
		* Construct
		*
		* @access public
		* @return void
		*/
		public function __construct()
		{
			$this->testimonials_settings = Options::options();
			$this->active_template_url = get_stylesheet_directory_uri() . '/aios-testimonials/your_custom_theme_name';
			$this->active_template_dir = get_stylesheet_directory() . '/aios-testimonials/your_custom_theme_name';


			$this->add_actions();
		}

		/*
		* Actions
		*
		* @access public
		* @return void
		*/
		public function add_actions()
		{
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 20);
			add_filter('template_include', array($this, 'custom_archive'), 20);
			add_filter('template_include', array($this, 'custom_single'), 20);
		}

		/*
		* Enqueue Scripts
		*
		* @access public
		* @return void
		*/
		public function enqueue_scripts()
		{
			extract($this->testimonials_settings);
			/// run archive styles and scripts
			if ($main_page == get_the_ID() && get_the_ID() != 0) {
				wp_enqueue_style('aios-testimonails-default-style', $this->active_template_url . '/css/archive.css');
				wp_enqueue_script('aios-testimonials-frontend', AIOS_TESTIMONIALS_RESOURCES . '/js/frontend.min.js');
				wp_enqueue_script('aios-testimonials-scripts', $this->active_template_url . '/js/script.js');

				$option = get_option('aios-enqueue-cdn');

				if($option['videoPlyr'] != '1'){
					$cdnUrl = cdnDomainSwitcher();

					wp_enqueue_style('aios-video-plyr-css', "$cdnUrl/libraries/css/plyr.min.css");
					wp_enqueue_script('aios-video-plyr-js', "$cdnUrl/libraries/js/plyr.js");
				}

				if (!empty($primary_color)) {
					echo '<style>
					:root {
						--aios-testimonials-primary: ' . $primary_color . ';
					}
					</style>';
				}
			}
			// run single styles and scripts
			if (is_single() && get_post_type(get_the_ID()) == 'aios-testimonials') {
				wp_enqueue_style('aios-testimonails-default-style', $this->active_template_url . '/css/single.css');
			}
		}

		/*
		* Run Template
		*
		* @access public
		* @return void
		*/
		public function custom_archive($template)
		{
			extract($this->testimonials_settings);
			if (!empty($aios_testimonials_settings)) extract($aios_testimonials_settings);
			if ($main_page == get_the_ID() && get_the_ID() != 0) {
				if ($testimonials_source != 'zillow') {
					$template = $this->active_template_dir . '/archive.php';
				} else {
					$template = $this->active_template_dir . '/archive-zillow.php';
				}
			}
			return $template;
		}
		/*
		* Run Single Template
		*
		* @access public
		* @return void
		*/

		public function custom_single($template)
		{
			if (is_single() && get_post_type(get_the_ID()) == 'aios-testimonials') {
				remove_filter('the_content', 'wpautop');
				$template = $this->active_template_dir . '/single.php';
			}
			return $template;
		}
	}
}

$aios_testimonials_details_page_template_default = new aios_testimonials_details_page_template_default();
