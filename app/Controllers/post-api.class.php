<?php
/**
 * Sample URL:
 * /wp-json/aios-testimonials/ - This will get all the testimonials
 * Accepted URL @param:
 * agent_id(int) - Post ID.
 * agent_testimonials_sortby(selected-only / unselected-only / selected-first / unselected-first / date-created / alphanumeric ) -  This will get/except testimonials under agent_id.
 * post_status(string / array) - use post status. Retrieves posts by Post Status, default value i'publish'.
 * posts_per_page(int) - number of post to show per page
 * paged(int) - Number of page. Show the posts that would normally show up just on page X.
 * order(ASC / DESC) - Designates the ascending or descending order of the 'orderby' parameter, default value DESC.
 * orderby(striing) - Sort retrieved posts by parameter.
 * slug - Get specific posts by slug
 * s - Search Query
 *
 * Sample URL to Get Agents testimonials
 * /wp-json/aios-testimonials/v1/s?agent_id=894&agent_testimonials_sortby=selected-only - This will get all the testimonials under Agent ID(894)
 * /wp-json/aios-testimonials/v1/s?agent_id=894&agent_testimonials_sortby=unselected-only - This will get all the testimonials except Agent ID(894)
 */

if ( !class_exists( 'aios_testimonials_rest_api' ) ) {

	class aios_testimonials_rest_api {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {
			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function add_actions() {
			add_action( 'rest_api_init', array( $this, 'custom_rest_api' ), 10 );
		}

		/**
		 * Register Rest Route
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function custom_rest_api() {
			register_rest_route( 
				'aios-testimonials/', 
				'posts/', 
				array(
					'methods' 	=> WP_REST_Server::READABLE,
					'callback' 	=> array( $this, 'get_all_testimonials' )
				)
			);

			register_rest_route( 
				'aios-testimonials',
				'posts/(?P<id>\d+)', 
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' )
				),
				array(
					'methods' 				=> WP_REST_Server::DELETABLE,
					'callback'            	=> array( $this, 'delete_item' ),
					'permission_callback' 	=> array( $this, 'delete_item_permissions_check' )
				)
			);
		}

		/**
		 * Check if a given request has access to get a specific item.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|boolean
		 */
		public function get_item_permissions_check( $request ) {
			return current_user_can( 'publish_pages' );
		}



		/**
		 * Check if a given request has access to delete a specific item.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|boolean
		 */
		public function delete_item_permissions_check( $request ) {
			return $this->get_item_permissions_check( $request );
		}

		/**
		 * Get a specific of items.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function get_item( $request ) {

			

			$posts 					= [];
			$post_id 				= $request->get_params( 'id' )['id'];

			$img 					= '';
			$author 				= empty( get_the_author($post_id) ) ? 'AgentImage' : get_the_author($post_id);
			$date_created 			= get_the_time( 'F d, Y', $post_id );
	
			$obj 					= new stdClass;
			$obj->id 				= $post_id;
			$obj->title 			= get_the_title( $post_id );
			$obj->author 			= $author;
			$obj->date_created 		= $date_created;
			$obj->url 				= get_the_permalink( $post_id );

			$posts[] 				= $obj;
			$posts 					= new WP_REST_Response($posts, 200);

			return $posts;
		}

		/**
		 * Delete one item from the collection.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function delete_item( WP_REST_Request $request ) {
			return new WP_REST_Response( Mapping::get( $request->get_param( 'id' ) )->delete() );
		}

		/**
		 * Call back for Register Rest Route
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function get_all_testimonials( $request ) {
		
			$aios_testimonials_options 	= new aios_testimonials_options();
			$aios_testimonials_settings 	= $aios_testimonials_options->options();
			if( !empty( $aios_testimonials_settings ) ) extract( $aios_testimonials_settings );

		

			$posts = [];

			$param 		= $request->get_params();
			$agent_id 	= empty( $param['agent_id'] ) ? '' : $param['agent_id'];

			/** Accepted Value: selected-only, unselected-only, selected-first, unselected-first, date-created, alphanumeric ***/

			$post_status 	= empty( $param['post_status'] ) 	? 'publish' : $param['post_status'];
			$postsPerPage 	= empty( $param['posts_per_page'] ) ?  $post_per_page : '';
			$paged 			= empty( $param['paged'] ) 			? 1 : $param['paged'];
			$order 			= empty( $param['order'] ) 			? $order : '';
			$orderby 		= empty( $param['orderby'] ) 		?  $order_by : '';
			$slug 			= empty( $param['slug'] ) 			? '' : $param['slug'];
			$search 		= empty( $param['search'] ) 		? '' : $param['search'];


			$args = array(
				'post_type' 		=> 'aios-testimonials',
				'post_status' 		=> $post_status,
				'posts_per_page' 	=> $postsPerPage,
				'paged' 			=> $paged,
				'order' 			=> $order,
				'orderby' 			=> $orderby,
				'name' 				=> $slug,
				's' 				=> $search
			);

		
			$query = new WP_Query( $args );
			

			/** Set max number of pages and total num of posts **/
			$max_pages = $query->max_num_pages;
			$total = $query->found_posts;

			/** Prepare data for output **/
			$controller = new WP_REST_Posts_Controller( 'post' );

			while ( $query->have_posts() ) {
				$query->the_post();

				$post_id 							= get_the_ID();
				$author 							= empty( get_the_author() ) ? 'AgentImage' : get_the_author();
				$date_created 						= get_the_time( 'F d, Y' );
				$content 							= get_the_time( 'F d, Y' );
				$featured                      		= get_post_meta( $post_id, 'aios_testimonials_featured', true );
				$position         					= get_post_meta( $post_id, 'aios_testimonials_position', true );
				$image          					= get_post_meta( $post_id, 'aios_testimonials_image', true );
				$featuredImage						= wp_get_attachment_image_src($image. 'thumbnail');

				$obj 						= new stdClass;
				$obj->id 					= $post_id;
				$obj->title 				= get_the_title();
				$obj->author 				= $author;
				$obj->date_created 			= $date_created;
				$obj->content 				= get_the_permalink();
				$obj->position 				= $position;
				$obj->image 				= $featuredImage[0];
				$obj->featured 				= $post_featured;

				$posts[] = $obj; 
			}

			/** Set headers and return response **/
			$posts = new WP_REST_Response($posts, 200);

			$posts->header( 'X-WP-Total', $total ); 
			$posts->header( 'X-WP-TotalPages', $max_pages );

			return $posts;
		}

	}

	$aios_testimonials_rest_api = new aios_testimonials_rest_api();
	
}