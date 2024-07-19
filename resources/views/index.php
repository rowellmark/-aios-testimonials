<?php
/**
 * Displays page and sub-pages and contents
 *
 * @since 1.0.0
 */

use AIOS\Testimonials\Config\Config;
use AIOS\Testimonials\Controllers\Options;

/** Get array of options **/
$aios_testimonials_settings 	= Options::options();
if( !empty( $aios_testimonials_settings ) ) extract( $aios_testimonials_settings );
?>

<div id="wpui-container-minimalist">
  <!-- BEGIN: Main Container -->
  <div id="wpui-container">
    <!-- BEGIN: Container -->
    <div class="wpui-container">
      <h4>AIOS Testimonial Settings</h4>
      <!-- BEGIN: Tabs -->
      <div class="wpui-tabs">
        <!-- BEGIN: Header -->
        <div class="wpui-tabs-header">
					<?php

					/** Create main tabs **/
					$tabs = Config::options_tabs();
					echo '<ul>';
					foreach ( $tabs as $tab ) {
						echo '<li><a data-id="' . $tab['url'] . '">' . $tab['title'] . '</a></li>';
					}
					echo '</ul>';
					?>
        </div>
        <!-- END: Header -->
        <!-- BEGIN: Body -->
        <div class="wpui-tabs-body">
          <!-- Loader -->
          <div class="wpui-tabs-body-loader"><i class="ai-font-loading-b"></i></div>
          <!-- Contents -->
					<?php


					foreach ( $tabs as $tab ) {



						echo '<div data-id="' . $tab['url'] . '" class="wpui-tabs-content ' . $tab['url'] . '">';

						echo '<div class="wpui-tabs-title">'. $tab['title'].'</div>';
						/** Check if child is an array to create a child sub pages else only main page will be created. **/
						if ( isset( $tab['child'] ) ) {
							/** Display Child Tab **/
							echo '<ul class="wpui-child-tabs">';
							foreach ( $tab['child'] as $tabChild) {

								echo '<li><a data-child-id="' . $tabChild['url'] . '">' . $tabChild['title'] . '</a></li>';
							}
							echo '</ul>';

							/** Display Child Content **/
							foreach ( $tab['child'] as $tabChild ) {
								echo '<div data-child-id="' . $tabChild['url'] . '" class="wpui-child-tabs-content ' . $tabChild['url'] . '">';
								echo '<div class="wpui-tabs-container">';
								if ( !empty( $tabChild['function'] ) ) {
									require_once(  'functions/' . $tabChild['function'] );
								} else {
									echo '<p>Error: Array[function] is empty.</p>';
								}
								echo '</div>';
								echo '</div>';
							}
						} else {
							echo '<div class="wpui-tabs-container">';
							if ( !empty( $tab['function'] ) ) {
								require_once( 'functions/' . $tab['function'] );
							} else {
								echo '<p>Error: Array[function] is empty.</p>';
							}
							echo '</div>';
						}
						echo '</div>';
					}
					?>
        </div>
        <!-- END: Body -->
      </div>
      <!-- END: Tabs -->
    </div>
    <!-- END: Container -->
  </div>
  <!-- END: Main Container -->

  <!-- BEGIN: Popup Message -->
  <div class="popup-message-wrapper">
    <div class="popup-message-content">
      <div class="popup-close ai-font-close-e"></div>
      <div class="popup-icon ai-font-lock-b"></div>
      <div class="popup-message">
        This theme is currently locked. Please contact your Project Manager or our Web Marketing Strategists for more information.
      </div>
    </div>
  </div>
  <!-- END: Popup Message -->
</div>
