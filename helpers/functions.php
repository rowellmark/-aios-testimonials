<?php

/**
 * CDN Domain Switcher
 *
 * @param $string
 * @return mixed
 */
if (! function_exists('cdnDomainSwitcher')) {
  function cdnDomainSwitcher() {
    return in_array(
      get_option('aios_custom_login_screen', 'default'),
      ['default', 'reduxlabs']
    ) ? "https://cdn.vs12.com" : "https://resources.agentimage.com";
  }
}
