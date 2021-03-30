;(function($){
    "use strict";
    var $window = $(window);
function tab_hover(){
        var tab = $(".price-tab");
        // if($(window).width() > 450){
            if($(tab).length>0 ){
                tab.append('<li class="hover-bg"></li>');
                if($('.price-tab li a').hasClass('active-hover')){
                    var pLeft = $('.price-tab li a.active-hover').position().left,
                        pWidth = $('.price-tab li a.active-hover').css('width');
                    $('.hover-bg').css({
                        left : pLeft,
                        width: pWidth
                    }) 
                }
                $('.price-tab li a').on('click', function() {
                    $('.price-tab li a').removeClass('active-hover');
                    $(this).addClass('active-hover');
                    var pLeft = $('.price-tab li a.active-hover').position().left,
                        pWidth = $('.price-tab li a.active-hover').css('width');
                    $('.hover-bg').css({
                        left : pLeft,
                        width: pWidth
                    }) 
                })
            }
        // }
    }
    tab_hover();
    })(jQuery)
	
function setCookie(cname, cval) {
document.cookie = cname + "=" + cval + "; path=/";
 console.log(document.cookie);
}

function getCookie(cname) {
var name = cname + "=";
var decodedCookie = decodeURIComponent(document.cookie);
var ca = decodedCookie.split(';');
for(var i = 0; i <ca.length; i++) {
  var c = ca[i];
  while (c.charAt(0) == ' ') {
	c = c.substring(1);
  }
  if (c.indexOf(name) == 0) {
	return c.substring(name.length, c.length);
  }
}
return "";
}