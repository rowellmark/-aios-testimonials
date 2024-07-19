<?php
	/** Note: **/
	/** prefix for option name **/
	$template_name = 'testimonials-templates-default';
?>
test options for template default
<div class="form-group">
	<label for="text">Input</label>
	<input type="text" class="aios-color-picker" data-alpha="true" name="<?=$template_name?>-header-color" data-default-color="#444444" value="<?php echo get_option( $template_name . '-header-color' ) !== false ? get_option( $template_name . '-header-color' ) : '#444444'; ?>">
</div>

<div class="form-group">
	<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
</div>