<!-- BEGIN: Row -->
<?php
	$wp_agents_output = '';
	$wp_agents = new WP_Query( array(
		'post_type' 	=> 'aios-agents',
		'showposts' 	=> -1
	) );

	$agents_count = count($wp_agents->posts);

	

?>
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-12 <?= $agents_count > 16 ? 'agents-scrollable' : '' ?>">
		<?php
		
			if ( $wp_agents->have_posts() ) {
				$wp_agents_output .= '<ul class="testimonials-agents">';
				while ( $wp_agents->have_posts() ) {
					$wp_agents->the_post();
					$agent_id 			= get_the_ID();
					$agent_details 		= get_post_meta( $agent_id, '_agent_details' );
					$agent_details 		= !empty( $agent_details ) ? $agent_details[0] : array();
					extract( $agent_details );

					/** $post_id(Customer Review ID) - declare on aios-cutomer-reviews-details.php **/
					$agentimage_output 	= !empty( $agentimage_id ) ? wp_get_attachment_image_url( $agentimage_id, 'large' ) : '';
					$testimonials_agents = get_post_meta( $post_id, 'testimonials_agents' );
					$testimonials_agents = !empty( $testimonials_agents ) ? $testimonials_agents[0] : array();
					$is_checked = in_array( $agent_id, $testimonials_agents ) ? 'checked="checked"' : '';

					/** Hidden field - this will be submitted if checkbox is empty **/
					$wp_agents_output .= '<li>';
						$wp_agents_output .= '<input type="hidden" name="testimonials_agents[' . $agent_id . ']" value="0" ' . $is_checked . '>';
						$wp_agents_output .= '<label>';
							$wp_agents_output .= '<canvas width="75" height="75" style="background-image: url(' . $agentimage_output . ');"></canvas>';
							$wp_agents_output .= '<div class="agentname">';
								$wp_agents_output .= get_the_title();
								$wp_agents_output .= '<input type="checkbox" name="testimonials_agents[' . $agent_id . ']" value="1" ' . $is_checked . '>';
							$wp_agents_output .= '</div>';
						$wp_agents_output .= '</label>';
					$wp_agents_output .= '</li>';
				}
				$wp_agents_output .= '<ul>';
			} else {
				$wp_agents_output .= '<p>No Agents to Display.</p>';
			}

			echo $wp_agents_output;
		?>
	</div>
</div>
<!-- END: Row -->