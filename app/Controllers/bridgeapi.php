<?php 
if ( !class_exists( 'aios_testimonials_bridge_api' ) ) {

	class aios_testimonials_bridge_api {


        function __construct() {
            add_action( 'wp_ajax_bridgeapi', array( $this, 'bridgeapi' ) );
            add_action( 'wp_ajax_nopriv_bridgeapi', array( $this, 'bridgeapi' ) );

            add_action( 'wp_ajax_bridgePurge', array( $this, 'bridgePurge' ) );
            add_action( 'wp_ajax_nopriv_bridgePurge', array( $this, 'bridgePurge' ) );
        }
        public function bridgePurge(){


            delete_transient('aios_testimonials_bridge_reviews');
 
        }
        public function bridgeapi(){

            $screenName = $_POST['screenname'];
            $api = $_POST['api'];
            $source = $_POST['source'];
            // Get options
            $aios_testimonials_settings = get_option('aios_testimonials_settings');

            if (!empty($aios_testimonials_settings)) {
                extract($aios_testimonials_settings);

                // Build API URL
                $url = 'https://api.bridgedataoutput.com/api/v2/OData/reviews/Reviewees?access_token=' . $api . '&$filter=RevieweeScreenName%20eq%20\'' . $screenName . '\'';

                // Fetch data from the API using wp_remote_get
                $response = wp_remote_get($url);

                // Check if the request was successful
                if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                    // Decode JSON response
                    $data = json_decode(wp_remote_retrieve_body($response), true);

                    $aios_testimonials_settings['testimonials_source'] = $source;
                    $aios_testimonials_settings['bridge_api_reviewee_key'] = $data['value'][0]['RevieweeKey'];
                    $aios_testimonials_settings['bridgeAPI_screen_name'] = $screenName;
                    $aios_testimonials_settings['bridge_api'] = $api;
                    update_option('aios_testimonials_settings', $aios_testimonials_settings);

                    // Send JSON response
                    header('Content-Type: application/json');
                    echo json_encode($data);

                    delete_transient('aios_testimonials_bridge_reviews');

                } else {
                    // Handle errors
                    header('Content-Type: application/json');
                    echo json_encode(array('error' => 'Failed to fetch data from the API'));
                }        
            }
            wp_die();
        }

      
    }
    

 
    
    $aios_testimonials_bridge_api = new aios_testimonials_bridge_api();
}



