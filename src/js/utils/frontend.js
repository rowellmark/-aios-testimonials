(function ($) {
    var app = {
        mobile_width: 991,
        init: function () {
            this.pagination();
            AOS.init();
        },
        pagination: function(){
            $prev = $('.aios-testimonials-prev');
            $next = $('.aios-testimonials-next');

            $prev.parent().addClass('aios-testimonialsPrev');
            $next.parent().addClass('aios-testimonialsNext');

        }
    };

    $(document).ready(function () {
        app.init();
    });

    $(window).on('resize', function () {

    });

})(jQuery);