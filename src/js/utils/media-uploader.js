/**
 * 
 * wpMediaUploader
 * Created by Rowell Blanca
 * 
 */
( function( $) {
    $.wpMediaUploader = function( options ) {
        
        var settings = $.extend({
            
            target : '.aios_media_uploader', // The class wrapping the textbox
            uploaderTitle : 'Select or upload image', // The title of the media upload popup
            uploaderButton : 'Set image', // the text of the button in the media upload popup
            multiple : false, // Allow the user to select multiple images
            buttonClass : '.aios_media_uploader_button', // the class of the upload button
            modal : false, // is the upload button within a bootstrap modal ?

            
        }, options );
        
                
        $('body').on('click', settings.buttonClass, function(e) {
            
            e.preventDefault();
            var selector = $(this).parent( settings.target );
            var custom_uploader = wp.media({
                title: settings.uploaderTitle,
                multiple: settings.multiple
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();

                $('.aios_media_uploader_image_holder canvas').remove();
                $('.aios_media_uploader_image_holder img').remove();

                selector.find( '.aios_media_uploader_image_holder').append('<img src="'+attachment.url+'">')

                selector.find( 'input' ).val(attachment.id);

                $('.aios_testimonials_close').addClass('aios-testimonials-close-show');
              
                if( settings.modal ) {
                    $('.modal').css( 'overflowY', 'auto');
                }

                $('.aios_media_uploader_button').text('Replace Image');
            })
            .open();
        });


        // remove photos
        $('.aios_testimonials_close').on('click', function(e){

            e.preventDefault();
            
            var $imageHolder = $('.aios_media_uploader_image_holder');

            $(this).removeClass('aios-testimonials-close-show');

            $('.aios_testimonials_image').attr('value', '');
            $imageHolder.find('img').remove();
            $imageHolder.append('<canvas width="450" height="250"></canvas>');

            $('.aios_media_uploader_button').text('Upload Image');
            

            
        });
        
        
    }
})(jQuery);
