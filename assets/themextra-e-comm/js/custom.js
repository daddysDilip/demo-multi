(function($){
   "use strict"   
    var YOGA = {};
    var $window = $(window),
        $body = $('body');
     /*--------------------
    * owl Slider
    ----------------------*/
    YOGA.TestiSlider = function(){
      var testi_slider = $('.blog-wrap');
        testi_slider.owlCarousel({
            loop: true,
            margin: 30,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            nav:false,
            dots:true,
            smartSpeed:450,
            responsive: {
              0: {
                items: 1
              },
              768: {
                items: 1
              },
              991: {
                items: 2
              },
              1140: {
                items:3
              }
            }
        });
    }
    $(document).on("ready", function(){
      YOGA.TestiSlider()
    });
})(jQuery);