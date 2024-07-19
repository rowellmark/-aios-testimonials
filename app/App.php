<?php

namespace AIOS\Testimonials\App;

class App
{
  /**
   * App constructor.
   *
   * @param $file
   */
  public function __construct($file)
  {
	  if (is_admin()) {
		  add_action('admin_notices', [$this, 'required_plugin']);
	  }

    // Plugin install and uninstall process
    register_activation_hook($file, [$this, 'install']);
    register_deactivation_hook($file, [$this, 'uninstall']);
  }

	public function required_plugin()
	{
		if (! get_transient('aios-filtered-templates')) {
			echo "<div class=\"notice notice-error is-dismissible\">
        <p><strong>AIOS Testimonials</strong>: Please make sure to register this site on the <a href=\"https://dashboard.agentimage.com/\" target=\"_blank\">dashboard.agentimage.com</a>, and install the Social Media Wall plugin. The website must be authenticated by the Social Media Wall plugin to authorize the themes.</p>
			</div>";
		}
	}

  /**
   * Plugin Installation.
   *
   * @since 1.0.0
   */
  public function install()
  {
      //  dont activate the plugin if modules is exists.
       if (class_exists('agentpro_testimonial_post_type')) {
          die('<p style="font-family: arial; font-size: 14px;">You have Testimonials Modules Included. This will cause conflict please make sure you remove it and migrate the data.</p>');
       }

        $aios_testimonials = get_option( 'aios_testimonials_settings' );
        if ( empty( $aios_testimonials ) ) {
            $default = array(
                'permastructure' 	=> 'testimonial',
            );
            update_option( 'aios_testimonials', $default );

            /** This will check if default value change this will trigger flush_rewrite_rules() **/
            update_option( 'testimonials_slug', 'testimonial' );
        }
  }

  /**
   * Plugin Uninstalling.
   *
   * @since 1.0.0
   */
  public function uninstall()
  {
    // Uninstall Process
  }
}
