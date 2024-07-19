<?php
/**
 * All option value are extracted in render.php
 * Adding optins just make sure you the ff option name: tabs, tab, tabChild
 *
 * This will get all the templates for details page
 *
 * @since 1.0.0
 * @return void
 */

use AIOS\Testimonials\Config\Config;

$template_locations = Config::get_template_location( 'themes' );

?>
<div class="wpui-row wpui-templates">
	<?php foreach ($template_locations as $template) : ?>
    <div class="wpui-col-md-6 my-3">
      <div class="wpui-template <?=$template['is_active']?> <?=($template['available'] ? '' : 'wpui-template-lock')?>">
        <div class="wpui-template-canvas">
          <canvas width="500" height="300" style="background-image: url( <?=$template['template_screenshot']?> );"></canvas>
					<?=($template['available'] ? '' : '<div class="wpui-template-banner-lock ai-font-lock-b"></div>')?>
        </div>
        <div class="wpui-details">
          <span><?=$template['template_name']?></span>
					<?php if ($template['available'] === false) : ?>
            <a href="" class="wpui-template-activator wpui-template-disabled" data-disabled="true">LOCKED</a>
					<?php elseif ($template['is_active'] === 'active-template') : ?>
            <a href="" class="wpui-template-activator wpui-template-activated">Active</a>
					<?php else: ?>
            <a href="" class="wpui-template-activator" data-theme-name="testimonials-themes" data-theme-value="<?=$template['template_fullname']?>">Activate</a>
					<?php endif; ?>
        </div>
      </div>
    </div>
	<?php endforeach; ?>
</div>
