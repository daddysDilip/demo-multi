/*========================================================================
EXCLUSIVE ON Themextra
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Template Name   : Ecommerce
Author          : vibhuti gohil
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Copyright (c) 2018 - vibhuti gohil
========================================================================*/


(function($){
   "use strict" 

  
  
    var ECOMM = {};
	 var $window = $(window),
		$body = $('body');
    /*--------------------
    * owl Slider
    ----------------------*/
    ECOMM.ProjectSlider = function(){
      var project_slider = $('.product-slider');
        project_slider.owlCarousel({
            loop: true,
            margin: 10,
            autoplay:true,
            animateOut: 'fadeOut',
    		animateIn: 'fadeIn',
            nav:true,
            smartSpeed:450,
            responsive: {
              0: {
                items: 1
              },
              500:{
                items: 2
              },
              768: {
                items: 3
              },
              992: {
                items: 4
              },
              1199: {
                items: 4
              },
              1200: {
                items: 5
              }
            }
        });
    }
    /*--------------------
    * owl Slider
    ----------------------*/
    ECOMM.BlogSlider = function(){
      var blog_slider = $('#blog-slider-single');
        blog_slider.owlCarousel({
            loop: true,
            margin: 15,
            autoplay:true,
            nav:true,
            smartSpeed:1000,
            responsive: {
              0: {
                items: 1
              },
              768: {
                items: 2
              },
              991: {
                items: 2
              },
              1140: {
                items: 3
              }
            }
        });
    }
    $(document).on("ready", function(){
    	ECOMM.ProjectSlider(),
    	ECOMM.BlogSlider();
    });
	$window.on('load', function() {
       /*========   PRE LOADER ===========*/
         $(".preloader").fadeOut(1000);
    });
})(jQuery);