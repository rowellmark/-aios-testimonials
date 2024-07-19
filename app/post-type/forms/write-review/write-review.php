<?php
    $post_featured                      = get_post_meta( $post_id, 'aios_testimonials_featured', true );
    $aios_testimonials_role         = get_post_meta( $post_id, 'aios_testimonials_role', true );
    $aios_testimonials_image            = get_post_meta( $post_id, 'aios_testimonials_image', true );
    $aios_testimonials_video_type         = get_post_meta( $post_id, 'aios_testimonials_video_type', true );
    $aios_testimonials_video_url            = get_post_meta( $post_id, 'aios_testimonials_video_url', true );


?>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Link Type</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
            <label for="aios_testimonials_video_type"></label>
            <select name="aios_testimonials_video_type" id="aios_testimonials_video_type">
                <option value="">...</option>
                <option value="mp4" <?= $aios_testimonials_video_type == 'mp4' ? 'selected' : '' ?>>MP4(Media Library, Vimeo)</option>
                <option value="url" <?= $aios_testimonials_video_type == 'url' ? 'selected' : '' ?>>URL(Youtube, Vimeo)</option>
            </select>
        </div>
    </div>
</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Video</span></p>
	</div>
	<div class="wpui-col-md-9">
        
        <div class="if-html-video">
            <div class="form-group">
                <label for="aios_testimonials_video_url">URL</label>
                <input type="text" name="aios_testimonials_video_url" id="aios_testimonials_video_url" value="<?=$aios_testimonials_video_url ?>" placeholder="https://">
            </div>
        </div>
                    
    </div>
</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Content</span></p>
	</div>
	<div class="wpui-col-md-9">
		<?php
			$post      = get_post( $post_id, OBJECT, 'edit' );
			$content   = $post->post_content;
			$editor_id = 'content';
				
			wp_editor( $content, $editor_id );
		?>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Role</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
            <label for="aios_testimonials_role"></label>
            <input type="text" name="aios_testimonials_role" id="aios_testimonials_role" value="<?=$aios_testimonials_role ?>"></div>
        </div>
</div>

<div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Set as Featured</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <div class="form-checkbox-group form-toggle-switch">
                <div class="form-checkbox">
                    <label>
                        <input type="checkbox" value="yes" name="aios_testimonials_featured" class="hidden" <?= $post_featured == "yes" ? 'checked' : '' ?>>
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Client Avatar</span></p>
	</div>
	<div class="wpui-col-md-9">

        <div class="form-group aios_media_uploader">
            <label for="aios_testimonials_logo"></label>

            <div class="aios_media_uploader_image_holder">

                <?php 
                    $showClose = '';
                    if($aios_testimonials_image != ''){
                        echo '<img src="'.wp_get_attachment_url($aios_testimonials_image).'">';

                        $showClose .='aios-testimonials-close-show';
                    }else{
                        echo '<canvas width="450" height="250"></canvas>';
                    }
                ?>
                
                <a href="#" class="aios_testimonials_close <?=$showClose?>">x</a>
            </div>

            <input type="hidden" class="aios_testimonials_image" name="aios_testimonials_image" value="<?= $aios_testimonials_image  ?>">
            <a href="#" class="aios_media_uploader_button">Upload Image</a>
        </div>

    </div>
</div>

