<?php
namespace AIOS\Testimonials\PostType\Create;
use AIOS\Testimonials\Controllers\Options;

if ( !class_exists( 'aios_testimonials_post_type_create' ) ) {

	class aios_testimonials_post_type_create {

	  private $post_type = 'aios-testimonials';

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return void
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
		 * @return void
		 */
		protected function add_actions() {
			/** Global Action with Filter **/
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_uiux' ) );
			add_action( 'init', array( $this, 'custom_post_type' ) );
			add_action( 'enter_title_here', array( $this, 'title_placeholder' ) );
			add_filter( 'wpseo_metabox_prio', array( $this, 'move_yoast_meta_box' ) );

			/** Only run on aios-testimonials post type **/
			add_filter( 'aios-default-metaboxes', array( $this, 'default_metaboxes' ) );
			add_filter( $this->post_type . '-default-tab', array( $this, 'default_tab' ) );
			add_filter( 'aios_add_custom_metabox_after_content_' . $this->post_type, array( $this, 'default_content' ) );
			add_filter( $this->post_type . '-additional-tabs', array( $this, 'additional_tabs' ) );
      		add_filter( $this->post_type . '-additional-content', array( $this, 'additional_content' ) );
		}

		/**
		 * Enqueue Assets
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return void
		 */
		public function admin_uiux() {
			$admin_page_id = get_current_screen()->id;

			if ( strpos($admin_page_id, $this->post_type) !== false ) {

				/** Enqueue Media Uploader **/
				wp_enqueue_media();
				wp_enqueue_script( 'aios-media-uploader-script', AIOS_TESTIMONIALS_RESOURCES . '/js/media-uploader.min.js' );
				wp_enqueue_style( 'aios-media-uploader-style', AIOS_TESTIMONIALS_RESOURCES . '/css/media-uploader.min.css' );


				wp_enqueue_style( $this->post_type . '-post-type-style', AIOS_TESTIMONIALS_RESOURCES . '/css/post-type.min.css' );
				wp_enqueue_script( $this->post_type . '-post-type-script', AIOS_TESTIMONIALS_RESOURCES . '/js/post-type.min.js' );
			}
		}

		/**
		 * Register Post Type.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return void
		 */
		public function custom_post_type() {
			/** Get array of Settings **/
			$testimonials_settings 		= Options::options();
			if( !empty( $testimonials_settings ) ) extract( $testimonials_settings );

			$labels = array(
				'name'                  => 'AIOS Testimonials',
				'singular_name'         => 'Testimonial',
				'add_new'               => 'Add New Review',
				'add_new_item'          => 'Add New Review',
				'edit_item'             => 'Edit Testimonials',
				'new_item'              => 'New Testimonials',
				'view_item'             => 'View Testimonials',
				'search_items'          => 'Search Testimonials',
				'not_found'             =>  'Nothing Found',
				'not_found_in_trash'    => 'Nothing found in the Trash',
				'parent_item_colon'     => ''
			);

			$supports = array(
				'title',
				'thumbnail',
				'revisions'
			);

			$args = array(
				'labels'                => $labels,
				'supports'              => $supports,
				'public'                => true,
				'publicly_queryable'    => $public_innerpage == 'yes' ? true: false,
				'show_ui'               => true,
				'query_var'             => true,
				'menu_icon'             => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJmaWxsOiM4Mjg3OGMiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGc+DQoJCTxnPg0KCQkJPHBhdGggZD0iTTI1NS45OTcsMTU5LjQxOGMzNi40NzMsMCw2Ni4xNDUtMjkuNjczLDY2LjE0NS02Ni4xNDVzLTI5LjY3My02Ni4xNDUtNjYuMTQ1LTY2LjE0NQ0KCQkJCWMtMzYuNDczLDAtNjYuMTQ1LDI5LjY3My02Ni4xNDUsNjYuMTQ1UzIxOS41MjQsMTU5LjQxOCwyNTUuOTk3LDE1OS40MTh6Ii8+DQoJCQk8cGF0aCBkPSJNMTQ5LjMyNywzMTguNzM2aDIxMy4zNDFjOC44MTgsMCwxNS45NjctNy4xNDksMTUuOTY3LTE1Ljk2N2MwLTY3LjYyMy01NS4wMTUtMTIyLjYzNy0xMjIuNjM3LTEyMi42MzcNCgkJCQlTMTMzLjM2LDIzNS4xNDYsMTMzLjM2LDMwMi43NjlDMTMzLjM2LDMxMS41ODcsMTQwLjUwOSwzMTguNzM2LDE0OS4zMjcsMzE4LjczNnoiLz4NCgkJCTxwYXRoIGQ9Ik0zMjAuNDM4LDM4MC4wMjVsLTM0LjYzMi01LjAzM2wtMTUuNDg4LTMxLjM4MWMtNS44NDgtMTEuODUxLTIyLjc5MS0xMS44NDMtMjguNjM2LDBsLTE1LjQ4OCwzMS4zODFsLTM0LjYzMiw1LjAzMw0KCQkJCWMtMTMuMDc3LDEuOS0xOC4zMDYsMTguMDE2LTguODQ5LDI3LjIzNGwyNS4wNTksMjQuNDI3bC01LjkxNiwzNC40OTJjLTIuMjM0LDEzLjAyNSwxMS40NzcsMjIuOTc3LDIzLjE2NywxNi44MzJsMzAuOTc2LTE2LjI4NA0KCQkJCWwzMC45NzYsMTYuMjg0YzExLjU5NSw2LjA5NiwyNS40MTgtMy43MSwyMy4xNjctMTYuODMybC01LjkxNi0zNC40OTJsMjUuMDU5LTI0LjQyNw0KCQkJCUMzMzguNzQ5LDM5OC4wMzQsMzMzLjUwNywzODEuOTI0LDMyMC40MzgsMzgwLjAyNXoiLz4NCgkJCTxwYXRoIGQ9Ik0xNDIuNTUsMzgwLjAyNWwtMzQuNjMyLTUuMDMzTDkyLjQzLDM0My42MTFjLTUuODQ4LTExLjg0OS0yMi43OTEtMTEuODQzLTI4LjYzNiwwbC0xNS40ODcsMzEuMzgxbC0zNC42MzIsNS4wMzMNCgkJCQljLTEzLjA3NywxLjktMTguMzA1LDE4LjAxNi04Ljg0OSwyNy4yMzRsMjUuMDU5LDI0LjQyN2wtNS45MTYsMzQuNDkyYy0yLjIzNCwxMy4wMjUsMTEuNDc3LDIyLjk3NywyMy4xNjcsMTYuODMybDMwLjk3Ni0xNi4yODUNCgkJCQlsMzAuOTc2LDE2LjI4NWMxMS41OTUsNi4wOTYsMjUuNDE4LTMuNzEsMjMuMTY3LTE2LjgzMmwtNS45MTYtMzQuNDkybDI1LjA2LTI0LjQyNw0KCQkJCUMxNjAuODYyLDM5OC4wMzQsMTU1LjYxOSwzODEuOTI0LDE0Mi41NSwzODAuMDI1eiIvPg0KCQkJPHBhdGggZD0iTTQ5OC4zMjQsMzgwLjAyNWwtMzQuNjMyLTUuMDMzbC0xNS40ODctMzEuMzgxYy00Ljc5Ny05LjcyMS0xNS4zODQtOC45MDEtMTQuMzE4LTguOTAxDQoJCQkJYy02LjA3NywwLTExLjYyOCwzLjQ1MS0xNC4zMTgsOC45MDFsLTE1LjQ4OCwzMS4zODFsLTM0LjYzMiw1LjAzM2MtMTMuMDc3LDEuOS0xOC4zMDUsMTguMDE2LTguODQ5LDI3LjIzNGwyNS4wNjEsMjQuNDI3DQoJCQkJbC01LjkxNiwzNC40OTJjLTIuMjM0LDEzLjAyNSwxMS40NzYsMjIuOTc3LDIzLjE2NywxNi44MzJsMzAuOTc2LTE2LjI4NWwzMC45NzYsMTYuMjg1YzExLjU5NSw2LjA5NiwyNS40MTgtMy43MSwyMy4xNjctMTYuODMyDQoJCQkJbC01LjkxNi0zNC40OTJsMjUuMDYtMjQuNDI3QzUxNi42MzUsMzk4LjAzNiw1MTEuMzk1LDM4MS45MjQsNDk4LjMyNCwzODAuMDI1eiIvPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=',
				'rewrite'               => array(
					'slug' => $permastructure
				),
				'capability_type'       => 'post',
				'hierarchical'          => false,
				'menu_position'         => 23,
				'has_archive'           => false // editable content - archive-{cpt-name}.php
			);

			register_post_type( $this->post_type, $args );

			/** Flush Permalinks **/
			if ( get_option( 'testimonials_slug' ) !== $permastructure ) {
				update_option( 'testimonials_slug', $permastructure );
				flush_rewrite_rules();
			}
		}

		/**
		 * Replace Title Placeholder.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return string
		 */
		public function title_placeholder( $title ) {
			$admin_page_post_type = get_current_screen()->post_type;

			if ( $admin_page_post_type == $this->post_type ) {
				$title = 'Name';
      }

			return $title;
		}

		/**
		 * Move Yoas Meta Box below.
		 *
		 * @return string
		 *@since 1.0.0
		 *
		 * @access public
		 */
		public function move_yoast_meta_box() {
			return 'low';
		}

		/**
		 * aios-testimonials tabs
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function meta_box_tabs( $add_meta_box_tabs = array() ) {

			/** Run plugin functions for is_plugin_active incase theirs priority issues **/
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

      $tabs = [];

			if ( is_plugin_active( 'aios-agents/aios-agents.php' ) ) {
				$tab_agents = array(
					'agents' => array(
						'url' 		=> 'agents',
						'title' 	=> 'Select Agents',
						'function'	=> AIOS_TESTIMONIALS_FORMS_DIR . 'agents/agents.php'
					)
				);

				$tabs = array_merge( $tabs, $tab_agents );
			}

			$add_meta_box_tabs = apply_filters( 'testimonials_add_meta_box_tabs', $add_meta_box_tabs );
			$tabs = array_merge_recursive( array_filter( $tabs ), array_filter( $add_meta_box_tabs ) );

			return $tabs;
		}

    /**
     * Add testimonials to custom metabox if not added
     * This will display the metaboxes tab
     *
     * @param $post_types
     * @return mixed
     */
    public function default_metaboxes($post_types) {
      if (! isset($post_types['aios-testimonials'])) {
        $post_types['aios-testimonials'] = [];
      }

      return $post_types;
    }

    /**
     * Change the default title of "Details"
     *
     * @return string
     */
		public function default_tab()
    {
      return 'Write a Review';
    }

    /**
     * Add custom fields to the "Details" tab
     */
    public function default_content()
    {
      $post_id = get_the_ID();
      include_once AIOS_TESTIMONIALS_FORMS_DIR . 'write-review/write-review.php';
	
    }

    /**
     * Add new tabs
     *
     * @return string
     */
		public function additional_tabs()
    {
      $tabs = $this->meta_box_tabs();


      if (! is_null($tabs)) {
        foreach ($this->meta_box_tabs() as $key => $tab) {
          return '<li><a data-id="' . $this->post_type . '-' . $tab['url'] . '">' . $tab['title'] . '</a></li>';
        }
      }

	
      return '';
    }

    /**
     * Add new content to the tabs
     */
		public function additional_content()
    {
      $post_id = get_the_ID();
      $tabs = $this->meta_box_tabs();
      if (! is_null($tabs)) {
        foreach ($this->meta_box_tabs() as $key => $tab) {
          echo '<div data-id="' . $this->post_type . '-' . $tab['url'] . '" class="wpui-tabs-content"><div class="wpui-tabs-container">';
            include_once $tab['function'];
          echo '</div></div>';
        }
      }
    }

	}

}
$aios_testimonials_post_type_create = new aios_testimonials_post_type_create();
