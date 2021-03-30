(function($){
   "use strict"   
    var YOGA = {};
    var $window = $(window),
        $body = $('body');
     /*--------------------
    * owl Slider
    ----------------------*/
    YOGA.YogaSlider = function(){
      var yoga_slider = $('#yoga-slider');
        yoga_slider.owlCarousel({
            loop: true,
            margin:30,
            nav:false,
            dots:true,
            responsive: {
              0: {
                items: 1
              },
              768: {
                items: 2
              },
              991: {
                items: 3
              },
              1140: {
                items: 4
              }
            }
        });
    }
    YOGA.TestiSlider = function(){
      var testi_slider = $('#testi-main');
        testi_slider.owlCarousel({
            loop: true,
            margin:30,
            dots:true,
            responsive: {
              0: {
                items: 1
              },
              768: {
                items: 2
              },
              991: {
                items: 3
              },
              1140: {
                items: 3
              }
            }
        });
    }
    $(document).on("ready", function(){
    	YOGA.YogaSlider(),
      YOGA.TestiSlider();
       $(".owl-dots").removeClass("disabled");
   	});
})(jQuery);