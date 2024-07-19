<?php

if ( !class_exists( 'aios_testimonials_posts_columns' ) ) {

	class aios_testimonials_posts_columns {

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
		 * @access protected
		 */
		protected function add_actions() {

			add_filter( 'manage_edit-aios-testimonials_columns', array( $this, 'testimonials_view_columns' ),10, 1 );
	 		add_action( 'manage_aios-testimonials_posts_custom_column' , array( $this, 'testimonials_view_custom_columns' ), 10, 2 );
		}

        /**
		 * Add the custom columns to the aios-testimonials.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */

		function testimonials_view_columns( $gallery_columns ) {
			$new_columns['cb'] = $gallery_columns['cb'];
			$new_columns['title'] = 'Full Name';
			$new_columns['is_featured'] = 'Set as Featured';
			$new_columns['author'] = 'Created By';
			$new_columns['date'] = 'Date';

			return $new_columns;
		}

		/**
		 * Add the custom columns to the aios-testimonials.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		function testimonials_view_custom_columns( $gallery_columns, $post_id ) {

			switch( $gallery_columns ) {
				case 'is_featured':
					$featured = get_post_meta( $post_id,'aios_testimonials_featured', true );
					echo  $featured == 'yes' ? 'Yes' : 'No' ;
					break;
                default:
                    echo '';
			}


		}

	}

	$aios_testimonials_posts_columns = new aios_testimonials_posts_columns();

}