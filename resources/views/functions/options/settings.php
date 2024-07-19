<div class="wpui-row">
	<div class="wpui-col-md-6">
		<div class="form-group">
			<label for="text"></label>

		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Main Page</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<?php
				$main_page_args = array(
					'depth'					=> 0,
					'child_of'				=> 0,
					'selected'				=> $main_page,
					'echo'					=> 1,
					'name'					=> 'aios_testimonials_settings[main_page]',
					'show_option_none'		=> '--',
					'option_none_value'		=> null,
				);
				wp_dropdown_pages( $main_page_args );
			?>
        </div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Permalink</span>
            <em>Permalink should be unique and not an existing page within the website to avoid any conflicts with the testimonials pagination.</em>
        </p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_testimonials_settings[permastructure]" placeholder="testimonials" value="<?= $permastructure ?>" placeholder="9" disabled class="testimonials-permastructure">
        </div>
        <div class="form-group">
			<label>
				<input type="checkbox" value="yes" name="aios_testimonials_settings[enable_permalinks]" class="hidden"  <?= $enable_permalinks == "yes" ? 'checked' : '' ?>>  Do you want to change permalink?
			</label>
        </div>

	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Activate Breadcrumbs Hierarchy</span></p>
	</div>
	<div class="wpui-col-md-2">
		<div class="form-checkbox-group form-toggle-switch communities-breadcrumb-heirarchy">
			<div class="form-checkbox">
				<label>
					<input type="checkbox" value="true" name="aios_testimonials_settings[breadcrumbs_heirarchy]" <?php checked($breadcrumbs_heirarchy, 'true', true); ?>> 
				</label>
			</div>
		</div>
	</div>
</div>

<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Order By</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="aios_testimonials_settings[order_by]">
				<option value="title" <?= $order_by == 'title' ? 'selected' : '' ?>>Title</option>
				<option value="name" <?= $order_by == 'name' ? 'selected' : '' ?>>Name</option>
				<option value="date" <?= $order_by == 'date' ? 'selected' : '' ?>>Date</option>
				<option value="menu_order" <?= $order_by == 'menu_order' ? 'selected' : '' ?>>Menu Order</option>
				<option value="rand" <?= $order_by == 'rand' ? 'selected' : '' ?>>Random</option>
			</select>
        </div>
	</div>
</div>


<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Testimonials Source</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="aios_testimonials_settings[testimonials_source]" class="testiSource">
				<option value="uploaded-testimonials" <?= $testimonials_source == 'uploaded-testimonials' ? 'selected' : '' ?>>Uploaded Testimonials</option>
				<option value="BridgeAPI" <?= $testimonials_source == 'BridgeAPI' ? 'selected' : '' ?>>Bridge API</option>
				<option value="zillow" <?= $testimonials_source == 'zillow' ? 'selected' : '' ?>>Zillow</option>
			</select>
        </div>
	</div>
</div>


<div class="wpui-row wpui-row-box bridgeAPI-show bridgeapi">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Bridge API</span>
            <em>Documentation and Server Token <a href="https://www.zillowgroup.com/developers/api/agents/agent-reviews/" target="_blank">here</a></em>
        </p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">

			<div class="bridgeAPI-field">
				<span class="wpui-settings-title">Server Token</span>
				<div class="form-group">
					<input type="text" id="bridge_api" name="aios_testimonials_settings[bridge_api]" placeholder="" value="<?= $bridge_api ?>" placeholder="">
					<input type="hidden" id="bridge_api_reviewee_key" name="aios_testimonials_settings[bridge_api_reviewee_key]" placeholder="" value="<?= $bridge_api_reviewee_key?>" placeholder="">
				</div>
			</div>
			<div class="bridgeAPI-field">
				<span class="wpui-settings-title">Client's Screen Name</span>
				<div class="form-group">
					<input type="text" id="bridgeAPI_screen_name" name="aios_testimonials_settings[bridgeAPI_screen_name]" placeholder="" value="<?= $bridgeAPI_screen_name ?>" placeholder="">
				</div>
			</div>

			<div class="bridgeAPI-field">
				<span class="wpui-settings-title">Client's Full Name (Optional)</span>
				<div class="form-group">
					<input type="text" name="aios_testimonials_settings[client_fullname]" placeholder="" value="<?= $client_fullname ?>" placeholder="">
				</div>
			</div>


			<div class="bridgeAPI-field bridgeAPI-button">
				<button class="connectBridgeApi">Connect to Bridge API</button>
			</div>

			<?php 
				$bridgeTransient = get_transient('aios_testimonials_bridge_reviews');

				if (!empty($bridgeTransient)) : 
			?>
			<div class="bridgeAPI-field bridgeAPI-button">
				<button class="bridgeAPICache">Purge Cache</button>
			</div>
			<?php endif ?>
			<div class="bridgeapi-status">
				<?php 
					if(!empty($bridgeAPI_screen_name)){
						echo '<p class="success">Bridge API is Connected</p>';
					}else{
						echo '<p class="failed">Error fetching <b>Bridge API</b> data please make sure Access Token is correct or <b>Screen Name</b> and <b>Full Name</b> is correct</p>';
					}
				?>
			</div>
        </div>
	</div>
</div>






<div class="wpui-row wpui-row-box zillow-show">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Zillow ID</span>
            <em>You Can Generate API key Here <a href="https://www.zillow.com/howto/api/ReviewsAPI.htm" target="_blank">Zillow Documentation</a></em>
        </p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_testimonials_settings[zillow_api]" placeholder="" value="<?= $zillow_api ?>" placeholder="">
        </div>
	</div>
</div>


<div class="wpui-row wpui-row-box zillow-show">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Client's Screen Name</span>
        </p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios_testimonials_settings[screen_name]" placeholder="" value="<?= $screen_name ?>" placeholder="">
        </div>
	</div>
</div>


<div class="wpui-row wpui-row-box post-type-show">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Order</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="aios_testimonials_settings[order]">
				<option value="DESC" <?= $order == 'DESC' ? 'selected' : '' ?>>Descending</option>
				<option value="ASC" <?= $order == 'ASC' ? 'selected' : '' ?>>Ascending</option>
			</select>
        </div>
	</div>
</div>

<div class="wpui-row wpui-row-box post-type-show">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Post Per Page</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="number" name="aios_testimonials_settings[post_per_page]" value="<?= $post_per_page ?>" placeholder="9">
        </div>
	</div>
</div>

<div class="wpui-row wpui-row-box aios-center-checkbox">
	<div class="wpui-col-md-3">
		<p class="mt-0">
			<span class="wpui-settings-title">Colors</span>
		</p>
	</div>
	<div class="wpui-col-md-9">
			<label>Primary Color</label>
			<input type="text" name="aios_testimonials_settings[primary_color]" class="aios-color-picker" value="<?= $primary_color ?>">
	</div>
</div>

<div class="wpui-row wpui-row-box aios-center-checkbox">
	<div class="wpui-col-md-3">
		<p class="mt-0">
			<span class="wpui-settings-title">Public Innerpage</span>
			This will remove the popup and make the inner page per testimonials public.
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label>
				<input type="checkbox" value="yes" name="aios_testimonials_settings[public_innerpage]" class="hidden"  <?= $public_innerpage == "yes" ? 'checked' : '' ?>>
			</label>
        </div>
	</div>
</div>

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
        <div class="form-group">
            <input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
        </div>
	</div>
</div>


