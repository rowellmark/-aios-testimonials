( function($) {
	$( document ).ready( function() {

		var $document 		= $( document ),
			$window 		= $( window ),
			$viewport 		= $( 'html, body' ),
			$html 			= $( 'html' ),
			$body 			= $( 'body' );
		/**
		 * Construct.
		 */
		function __construct() {
			aios_color_picker();
			zillow_show();
			bridgeAPICondition();
			permastructure();
		}

		/**
		 * Set color picker.
		 */
		function aios_color_picker() {
			var $inputPicker = $( '.aios-color-picker' );

			$inputPicker.each( function() {
				$( this ).wpColorPicker();
			} );
		}



		function zillow_show(){

			$target = $('.testiSource');
			
			$zillowDOM = $('.zillow-show');
			$postTypeDom = $('.post-type-show');
			$bridgeAPIDOM = $('.bridgeAPI-show');


			if($target.val() == 'zillow'){
				$zillowDOM.fadeIn();
				$postTypeDom.fadeOut();
				$bridgeAPIDOM.fadeOut();
			} else if($target.val() == 'BridgeAPI'){
				$bridgeAPIDOM.fadeIn();
				$zillowDOM.fadeOut();
				$postTypeDom.fadeOut();
			} else {
				$zillowDOM.fadeOut();
				$postTypeDom.fadeIn();
				$bridgeAPIDOM.fadeOut();
			}

			$target.on('change', function(){
				$dataSource = $(this).val();

				if($dataSource == 'zillow'){
					$zillowDOM.fadeIn();
					$postTypeDom.fadeOut();
					$bridgeAPIDOM.fadeOut();
				} else if ($target.val() == 'BridgeAPI') {
					$bridgeAPIDOM.fadeIn();
					$zillowDOM.fadeOut();
					$postTypeDom.fadeOut();

				} else{
					$zillowDOM.fadeOut();
					$postTypeDom.fadeIn();
					$bridgeAPIDOM.fadeOut();
				}
			});
		}


		function bridgeAPICondition() {

			$testiSource = $('.testiSource');
			$connectButton = $('.connectBridgeApi');
			$purgeButton = $('.bridgeAPICache'); 
			$screenName = $('#bridgeAPI_screen_name');
			$reviewweeKey = $('#bridge_api_reviewee_key');
			$api = $('#bridge_api');
			$apiStatus = $('.bridgeapi-status');



			$purgeButton.on('click', function () { 

				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: data.ajax_url,
					data: {
						action: 'bridgePurge',
					},
					success: function (response) {
						let timerInterval;
						Swal.fire({
							title: "Purge Success",
							html: "",
							timer: 2000,
							timerProgressBar: true,
							showCancelButton: false,
							showConfirmButton: false, 
							didOpen: () => {
								Swal.showLoading();
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);

							}
						}).then((result) => {
	
						});

					}
				});

			});


			$connectButton.on('click', function () {
				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: data.ajax_url,
					data: {
						action: 'bridgeapi',
						screenname: $screenName.val(),
						source: $testiSource.val(),
						api: $api.val()
					},
					success: function (response) {
		
						if (response.value[0]) {
							$reviewweeKey.val(response.value[0]['RevieweeKey']);
							$apiStatus.html('<p class="success">Bridge API is Connected</p>')

						} else {
							$apiStatus.html('<p class="failed">Error fetching <b>Bridge API</b> data please make sure Access Token is correct or <b>Screen Name</b> and <b>Full Name</b> is correct</p>')
						}
						
						let timerInterval;
						Swal.fire({
							title: "Connecting to Bridge API",
							html: "",
							timer: 2000,
							timerProgressBar: true,
							showCancelButton: false,
							showConfirmButton: false,
							didOpen: () => {
								Swal.showLoading();
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
								
							}
						}).then((result) => {
							location.reload();
		
						});

					}
				});
			});

			


		}
		/**
		 * Slug for Testimonials - On keypress remove replace special character to -
		 */
		function permastructure() {
			var $inputPermastructure = $( '.testimonials-permastructure' );

			$inputPermastructure.on( 'keyup', function() {
				var $this 	= $( this ),
					$val 	= slugify( $this.val() );

				$this.val( $val );
			} );

			/// enable permastructure
			$checkBox = $('input[name="aios_testimonials_settings[enable_permalinks]"]');

			// on page load
			if ( $checkBox.is(':checked') ){
				$inputPermastructure.removeAttr('disabled');
			}else{
				$inputPermastructure.prop('disabled', true);
			}
			// on click
			$checkBox.on('click', function () {
				if ( $(this).is(':checked') ){
					$inputPermastructure.removeAttr('disabled');
				}else{
					$inputPermastructure.prop('disabled', true);
				}
			});
			
		}
			function slugify(string) {
				const a = 'àáäâãèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;';
				const b = 'aaaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------';
				const p = new RegExp(a.split('').join('|'), 'g');

				return string.toString().toLowerCase()
					.replace(/\s+/g, '-') /** Replace spaces with **/
					.replace(p, c => b.charAt(a.indexOf(c))) /** Replace special characters **/
					.replace(/&/g, '-and-') /** Replace & with ‘and’ **/
					.replace(/[^\w\-]+/g, '-') /** Remove all non-word characters **/
					.replace(/\-\-+/g, '-') /** Replace multiple — with single - **/
					.replace(/^-+/, ''); /** Trim — from start of text .replace(/-+$/, '') Trim — from end of text **/
			}

		/**
		 * Instantiate
		 */
		__construct();

	} );
} )( jQuery );