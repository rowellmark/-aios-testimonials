<?php

/**
 * Plugin Name: AIOS Testimonials
 * Description: Display of client's testimonials
 * Version: 1.4.7
 * Author: Agent Image
 * Author URI: https://www.agentimage.com/
 * License: Proprietary
 */

namespace AIOS\Testimonials;

define('AIOS_TESTIMONIALS_URL', plugin_dir_url(__FILE__));
define('AIOS_TESTIMONIALS_DIR', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR);
define('AIOS_TESTIMONIALS_RESOURCES', AIOS_TESTIMONIALS_URL . 'resources/');
define('AIOS_TESTIMONIALS_VIEWS', AIOS_TESTIMONIALS_DIR . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('AIOS_TESTIMONIALS_NAME', 'AIOS Testimonials');
define('AIOS_TESTIMONIALS_SLUG', 'aios-testimonials_page_testimonials-settings');
define('AIOS_TESTIMONIALS_FORMS_DIR', AIOS_TESTIMONIALS_DIR . '/app/post-type/forms' . DIRECTORY_SEPARATOR);


require 'FileLoader.php';

$fileLoader = new FileLoader();

// Load Core
$fileLoader->load_files(['app/App']);
new App\App(__FILE__);

// Load Files
$fileLoader->load_directory('helpers');
$fileLoader->load_directory('config');
$fileLoader->load_directory('app/Controllers');
$fileLoader->load_directory('app/post-type');
