(function ($, w, d, h, b) {
	$(document).ready(function () {

		/**
		 * Construct.
		 */
		function __construct() {
            video();
        }
        
        function video() {

			const players = Array.from(document.querySelectorAll('.aios-testimonials-video-players')).map(p => new Plyr(p, {
				clickToPlay: true,
			}));
            
        }

        

		/**
		 * Instantiate
		 */
		__construct();
	});
})(jQuery, window, document, 'html', 'body');