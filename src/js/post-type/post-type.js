( function($) {
	$( document ).ready( function() {

		var $document 		= $( document ),
			$window 		= $( window ),
			$viewport 		= $( 'html, body' ),
			$html 			= $( 'html' ),
			$body 			= $( 'body' );

		function __construct() {
			$( '#aios-testimonials-details-meta-box' ).insertAfter( '#titlediv' );
			$.wpMediaUploader();
		}

		// Instantiate
		__construct();

	} );
} )( jQuery );