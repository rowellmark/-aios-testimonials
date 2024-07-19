<?php

namespace AIOS\Testimonials\Controllers;

class AdminController
{

	/**
	 * Admin constructor.
	 */
	public function __construct()
	{
		add_action('admin_menu', [$this, 'page']);
		add_action('admin_enqueue_scripts', [$this, 'assets']);
	}

	/**
	 * Enqueue Assets to specific page
	 */
	public function assets()
	{
    $cdnUrl = cdnDomainSwitcher();

		if (! wp_script_is('aios-wpuikit-script') && ! wp_style_is('aios-wpuikit-style')) {
			wp_enqueue_style('aios-wpuikit-style', "$cdnUrl/wpuikit/v1/wpuikit.min.css");
			wp_enqueue_script('aios-wpuikit-script', "$cdnUrl/wpuikit/v1/wpuikit.min.js");
		}

		// Alpha Color Picker
		wp_register_script('wp-color-picker-alpha', "$cdnUrl/libraries/js/wp-color-picker-alpha.min.js", ['wp-color-picker']);
		wp_enqueue_script('wp-color-picker-alpha');

		if (strpos(get_current_screen()->id, AIOS_TESTIMONIALS_SLUG) !== false) {
			wp_enqueue_media();
			wp_enqueue_style(AIOS_TESTIMONIALS_SLUG, AIOS_TESTIMONIALS_RESOURCES . 'css/app.min.css', [], time());
			wp_enqueue_script(AIOS_TESTIMONIALS_SLUG, AIOS_TESTIMONIALS_RESOURCES . 'js/app.min.js', [], time(), true);
			wp_localize_script(AIOS_TESTIMONIALS_SLUG, 'data', [
				'nonce' => wp_create_nonce('wp_rest'),
				'baseUrl' => get_home_url(),
				'ajax_url' => admin_url('admin-ajax.php')
			]);
		}
	}

	/**
	 * Register admin page
	 */
	public function page()
	{
		add_submenu_page(
			'edit.php?post_type=aios-testimonials',
			'Settings',
			'Settings',
			'manage_options',
			'testimonials-settings',
			[$this, 'render']
		);
	}

	/**
	 * Render Page
	 */
	public function render()
	{
		include_once AIOS_TESTIMONIALS_VIEWS . 'index.php';

	}
}

new AdminController();
