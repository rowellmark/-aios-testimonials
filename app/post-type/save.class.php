<?php

if ( !class_exists( 'aios_testimonials_post_type_save' ) ) {

  class aios_testimonials_post_type_save {

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
      add_action( 'save_post_aios-testimonials', array( $this, 'save_testimonials' ) );
    }

    /**
     * Save Metabox Value.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function save_testimonials( $post_id ){

      /** Pointless if $_POST is empty (this happens on bulk edit) **/
      if ( empty( $_POST ) )
        return $post_id;

      /** Verify taxonomies meta box nonce **/
      if ( !isset( $_POST[ 'aios_aios-testimonials_meta_boxes_nonce' ] ) || !wp_verify_nonce( $_POST[ 'aios_aios-testimonials_meta_boxes_nonce' ], 'aios-aios-testimonials-save-details' ) )
        return true;

      /** Verify quick edit nonce **/
      if ( isset( $_POST[ '_inline_edit' ] ) && ! wp_verify_nonce( $_POST[ '_inline_edit' ], 'inlineeditnonce' ) )
        return $post_id;

      /** Don't save on autosave **/
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

      /** Check the user's permissions. **/
      if ( !current_user_can( 'edit_page', $post_id ) )
        return true;

      /** Check post status **/
      if ( get_post_status( $post_id ) == 'trash'  )
        return true;

      /** Unhook this function to prevent infinite looping **/
      remove_action( 'save_post_aios-testimonials', 'save_testimonials' );

      if( isset ( $_POST['aios_testimonials_featured'] ) ) {
        update_post_meta( $post_id, 'aios_testimonials_featured', $_POST['aios_testimonials_featured'] );
      }else{
        update_post_meta( $post_id, 'aios_testimonials_featured', 'no' );
      }

      update_post_meta( $post_id, 'aios_testimonials_role', $_POST['aios_testimonials_role'] );
      update_post_meta( $post_id, 'aios_testimonials_image', $_POST['aios_testimonials_image'] );
      update_post_meta( $post_id, 'aios_testimonials_video_url', $_POST['aios_testimonials_video_url'] );
      update_post_meta( $post_id, 'aios_testimonials_video_type', $_POST['aios_testimonials_video_type'] );

      /**
       * Save list of agents
       *
       * @param testimonials_agents - This will be save in Customer review post meta
       * @param agent_testimonials - This will be save in agent post meta
       */
      if ( is_plugin_active( 'aios-agents/aios-agents.php' ) ) {
        
        $testimonials_agents 		= [];
        $testimonials_agents_arr 	= $_POST['testimonials_agents'];
        $testimonials_agents_count 	= count( $_POST[ 'testimonials_agents' ] );

        if ( $testimonials_agents_count > 0 ) {
          foreach ( $testimonials_agents_arr as $agent_id => $value ) {
            /** Only push value equal to 1 **/
            if ( $value == 1 ) array_push( $testimonials_agents, $agent_id );

            /** Save testimonials in agent **/
            $agent_testimonials = get_post_meta( $agent_id, 'agent_testimonials' );
            $agent_testimonials = !empty( $agent_testimonials ) ? $agent_testimonials[0] : array();

            /**
             * If value eqaul to 1 this will be save else remove from array
             * $post_id == testimonials ID
             * Also we need to check if is already added in array
             */
            if ( $value == 1 ) {
              if ( !in_array( $post_id, $agent_testimonials ) ) array_push( $agent_testimonials, $post_id );
            } else {
              if ( ( $key = array_search( $post_id, $agent_testimonials ) ) !== false ) unset( $agent_testimonials[$key] );
            }

            update_post_meta( $agent_id, 'agent_testimonials', $agent_testimonials );
          }

          /** Save agents in testimonials **/
          update_post_meta( $post_id, 'testimonials_agents', $testimonials_agents );
        }
      }

      /** rehook save_post **/
      add_action( 'save_post_aios-testimonials', 'save_testimonials' );
    }

  }

}
$aios_testimonials_post_type_save = new aios_testimonials_post_type_save();
