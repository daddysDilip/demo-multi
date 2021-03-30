$(document).ready(function() {

  $('.to_cart_loader').hide();

  $('.pagination li:first-child span').html('<i class="fa fa-fast-backward"></i>');
  $('.pagination li:first-child a').html('<i class="fa fa-fast-backward"></i>');
  $('.pagination li:last-child span').html('<i class="fa fa-fast-forward"></i>');
  $('.pagination li:last-child a').html('<i class="fa fa-fast-forward"></i>');

  $('.shippingCheck').click(function(){

    $('.shipping-details-area').toggle();

    if($('.shipping-details-area').is(':hidden'))
    {

      $('.shipping-details-area').find('input').prop('required',false);

    }
    else
    {

      $('.shipping-details-area').find('input').prop('required',true);

    }

  });

  $(".product-review-owl-carousel").owlCarousel({
    
    items: 4,
    nav: true,
    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
    dots: false,
    loop: true,
    autoplay: true,
    smartSpeed: 800

  }); 


  $('.product-zoom').zoom({

    on:'click',
    magnify: 2,

    onZoomIn: function(){

      $(this).css('cursor', 'zoom-out');

    },

    onZoomOut: function(){

      $(this).css('cursor', 'zoom-in');

    }

  });
 
  $("#latest_product").owlCarousel({
      items: 4,
      autoplay: true,
      margin: 0,
      loop: true,
      nav: true,
      navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
      smartSpeed: 1000,
      responsive : {
        0 : {
          items: 1,
        },
        768 : {
          items: 3,
        },
        992 : {
          items: 4,
        },
        1200 : {
          items: 4
        }
      }
  });

  $("#featured_product").owlCarousel({
      items: 4,
      autoplay: true,
      margin: 0,
      loop: true,
      nav: true,
      navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
      smartSpeed: 1000,
      responsive : {
        0 : {
          items: 1,
        },
        768 : {
          items: 3,
        },
        992 : {
          items: 4,
        },
        1200 : {
          items: 4
        }
      }
  });

  $("#popular_product").owlCarousel({
      items: 4,
      autoplay: true,
      margin: 0,
      loop: true,
      nav: true,
      navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
      smartSpeed: 1000,
      responsive : {
        0 : {
          items: 1,
        },
        768 : {
          items: 3,
        },
        992 : {
          items: 4,
        },
        1200 : {
          items: 4
        }
      }
  });
  
  $("#searchbtn").click(function ()
  {
    //alert($("#searchdata").val());
    if($("#searchdata").val() != "")
    {
      window.location = mainurl+"/search/"+$("#searchdata").val();
    }
    else
    {
      window.location = mainurl+"/search/none";
    }

  });

  $("#searchdata").keypress(function(event) {

    if (event.which == 13) {

        event.preventDefault();

        if($("#searchdata").val() != "")
        {
          window.location = mainurl+"/search/"+$("#searchdata").val();
        }
        else
        {
          window.location = mainurl+"/search/none";
        }

    }

  });

  getCart();

  $('.quantity-cart-plus').on('click',function(){

    var id = parseInt($(this).attr('id').replace ( /[^\d.]/g, '' ));
    var prices = parseFloat($('#price'+id).html().replace ( /[^\d.]/g, '' ));
    var quan = parseInt($('#number'+id).html().replace ( /[^\d.]/g, '' ));
    var max = parseInt($(this).attr('max'));
        
    if(quan >= max)
    {
      $(this).val(max);
      $('.error'+id).text('The maximum quantity available for purchase is '+max+'.');
    }
    else
    {
      
      var total = quan + 1;
   
      $('#number'+id).text(total < 1 ? 1 : total );

      var ttl = prices*total;

      var subtotal = 0;
      var grand_total = 0;

      var shipinfo = $('input[name="shipinfo"]').val();
      var taxinfo = $('input[name="taxinfo"]').val();

      var po_shipcost = $('input[name="po_shipcost"]').val();
      var po_tax = $('input[name="po_tax"]').val();

      if(shipinfo  == 'Per Product') 
      { 
          var shipcost = $('input[name="shipping_cost'+id+'"]').val();
      } 
      else if(shipinfo  == 'Per Order') 
      {
          var shipcost = parseFloat(po_shipcost);
      }

      if(taxinfo  == 'Per Product')  
      { 
          var tax = $('input[name="tax_val'+id+'"]').val();
      } 
      else if(taxinfo  == 'Per Order') 
      {
          var tax = parseFloat(po_tax);
      }

      if(shipinfo  == 'Per Product' && taxinfo  == 'Per Product')
      {  
          var per_tax = (parseFloat(prices) + parseFloat(shipcost)) * (tax/100);
          var totaltax = (per_tax) * (total);  
          var totalshipcost = (total) * (shipcost);
          var display_subtotal= (ttl) + (totalshipcost) + (totaltax);
      }
      else if(shipinfo  == 'Per Product')
      {
          var totalshipcost = (total) * (shipcost);
          var display_subtotal = ttl + (totalshipcost); 
          var totaltax = (subtotal) * (tax/100); 
      }
      else if(taxinfo  == 'Per Product')
      {
          var totaltax = (ttl) * (tax/100);
          var display_subtotal = (ttl) + (totaltax); 
      }
      else
      {
          var display_subtotal = (prices)*(total); 
          var totaltax = (subtotal) * (tax/100);    
      }

      $('#cost'+id).val(prices.toFixed(2));
      $('#quantity'+id).val(total);
      $('#subtotal'+id).html(display_subtotal.toFixed(2));

      var sum = 0;

      $('.subtotal').each(function(){
          sum += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));  // Or this.innerHTML, this.innerText
      });

      $('#subtotal').html(sum.toFixed(2));

      if(shipinfo  == 'Per Product' && taxinfo  == 'Per Product')
      {
          var grand_total = sum;
      }
      else if(shipinfo  == 'Per Product')
      {
        var per_ordertax = (sum) * (tax/100);
        var grand_total = (per_ordertax) + (sum);
        $('#po_tax').html(per_ordertax.toFixed(2));
      }
      else if(taxinfo  == 'Per Product')
      {
        var grand_total = (shipcost) + (sum);
      }
      else
      {
        var finalsum = (shipcost) + (sum);
        var per_ordertax = finalsum * (tax/100);
        $('#po_tax').html(per_ordertax.toFixed(2));
        var grand_total = (shipcost) + (per_ordertax) + (sum);
      }

      var finaltotal = parseFloat(grand_total);

      $('#grandtotal').html(finaltotal.toFixed(2));

      if($("#citem"+id).length !== 0) {

        var formData = $("#citem"+id).serializeArray();

        $.ajax({
          type: "POST",
          url: mainurl+'/cartupdate',
          data:formData,
          success: function (data) 
          {
            getCart();
          },
          error: function (data) 
          {
            //console.log('Error:', data);
          }
        });
      }
    }
  });

  $('.quantity-cart-minus').on('click',function(){

    var id = parseInt($(this).attr('id').replace ( /[^\d.]/g, '' ));
    var prices = parseFloat($('#price'+id).html().replace ( /[^\d.]/g, '' ));
    var quan = parseInt($('#number'+id).html().replace ( /[^\d.]/g, '' ));

    $('.error'+id).text('');
    var total = quan - 1;

    if (total >= 1){

      $('#number'+id).text(total);

      var ttl = prices*total;
      var subtotal = 0;
      var grand_total = 0;

      var shipinfo = $('input[name="shipinfo"]').val();
      var taxinfo = $('input[name="taxinfo"]').val();

      var po_shipcost = $('input[name="po_shipcost"]').val();
      var po_tax = $('input[name="po_tax"]').val();

      if(shipinfo  == 'Per Product') 
      { 
        var shipcost = $('input[name="shipping_cost'+id+'"]').val();
      } 
      else if(shipinfo  == 'Per Order') 
      {
        var shipcost = parseFloat(po_shipcost);
      }
      if(taxinfo  == 'Per Product')  
      { 
        var tax = $('input[name="tax_val'+id+'"]').val();
      } 
      else if(taxinfo  == 'Per Order') 
      {
        var tax = parseFloat(po_tax);
      }
      if(shipinfo  == 'Per Product' && taxinfo  == 'Per Product')
      {  
        var per_tax = (parseFloat(prices) + parseFloat(shipcost)) * (tax/100);
        var totaltax = (per_tax) * (total);  
        var totalshipcost = (total) * (shipcost);
        var display_subtotal= (ttl) + (totalshipcost) + (totaltax);
      }
      else if(shipinfo  == 'Per Product')
      {
        var totalshipcost = (total) * (shipcost);
        var display_subtotal = ttl + (totalshipcost); 
        var totaltax = (subtotal) * (tax/100); 
      }
      else if(taxinfo  == 'Per Product')
      {
        var totaltax = (ttl) * (tax/100);
        var display_subtotal = (ttl) + (totaltax); 
      }
      else
      {
        var display_subtotal = (prices)*(total); 
        var totaltax = (subtotal) * (tax/100);    
      }

      $('#cost'+id).val(prices.toFixed(2));
      $('#quantity'+id).val(total);
      $('#subtotal'+id).html(display_subtotal.toFixed(2));

      var sum = 0;

      $('.subtotal').each(function(){
        sum += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));  // Or this.innerHTML, this.innerText
      });

      $('#subtotal').html(sum.toFixed(2));  

      if(shipinfo  == 'Per Product' && taxinfo  == 'Per Product')
      {
        var grand_total = sum;
      }
      else if(shipinfo  == 'Per Product')
      {
        var per_ordertax = (sum) * (tax/100);
        var grand_total = (per_ordertax) + (sum);
        $('#po_tax').html(per_ordertax.toFixed(2));
      }
      else if(taxinfo  == 'Per Product')
      {
        var grand_total = (shipcost) + (sum);
      }
      else
      {
        var per_ordertax = (shipcost + sum) * (tax/100);
        var grand_total = (shipcost) + (per_ordertax) + (sum) ;
        $('#po_tax').html(per_ordertax.toFixed(2));
      }

      var finaltotal = parseFloat(grand_total);

      $('#grandtotal').html(finaltotal.toFixed(2));

      if($("#citem"+id).length !== 0) {

        var formData = $("#citem"+id).serializeArray();

        $.ajax({
          type: "POST",
          url: mainurl+'/cartupdate',
          data:formData,
          success: function (data) 
          {
            getCart();
          },
          error: function (data) 
          {
            //console.log('Error:', data);
          }

        });
      }

    }

  });

  $("#ex2").slider({});

  $("#ex2").on("slide", function(slideRange) {
    var totals = slideRange.value;

    var value = totals.toString().split(',');

    $("#price-min").val(value[0]);

    $("#price-max").val(value[1]);

  });

  $('#ex2').on('change',function(slideRange){
    var totals = slideRange.value;
    var priceval = totals.newValue;
  
    var value = priceval.toString().split(',');

    $("#price-min").val(value[0]);

    $("#price-max").val(value[1]);
  });

});

 function productGallery(file){

  var image = $("#"+file).attr('src');
  $('#imageDiv').attr('src',image);
  $('.zoomImg').attr('src',image);

}

function getCart() {

  $.get(mainurl+'/cartupdate', function(response){

    var total = 0;
    var str = '';
    var str1 = '';
    var totalqty = 0;

    $("#cart .cart-list").html('');

    $.each(response, function(i, cart){

      $.each(cart, function (index, data) {

        var pr_price = (parseFloat(data.cost))*(data.quantity);

        if(ship_info == 'Per Product')
        {
          if(data.shipping_cost != 0)
          {
            str = '<div class="quantity shipping_cost">'+ShippingCostlang+': '+data.shipping_cost+'</div>' ;
          } 

          var shipcost = data.shipping_cost;
          var totalcost = Number(data.shipping_cost) + Number(data.cost);
        }
        else if(ship_info  == 'Per Order') 
        {
          str = '';
          var shipcost = poshipcost;
          var totalcost = Number(data.cost);
        }

        if(tax_info == 'Per Product')
        {

          if(data.tax != 0)
          {
            var totaltax = totalcost * (data.tax/100);
            str1 = '<div class="quantity tax">'+Taxlang+'('+data.tax+'%): '+totaltax.toFixed(1)+'</div>' ;
          }
          else
          {
              str1 = '';
          }
          var tax = data.tax;

        }
        else if(tax_info  == 'Per Order') 
        {
          str1 = '';
          var tax = potax;
        }

        //var pr_price = (parseFloat(data.cost))*(data.quantity);

        if(ship_info == 'Per Product'  && tax_info == 'Per Product')
        {
          var per_tax = (parseFloat(data.cost) + parseFloat(shipcost)) * (tax/100);
          var totaltax = (per_tax) * (data.quantity);
          var totalshipcost = data.quantity * parseFloat(shipcost);
          total = parseFloat(total) + pr_price + totalshipcost + totaltax;
        }
        else if(ship_info == 'Per Product')
        {
          var totalshipcost = data.quantity * parseFloat(shipcost);
          total = parseFloat(total) + pr_price + totalshipcost ;

        }
        else if(tax_info == 'Per Product')
        {
          var totaltax = pr_price * (tax/100);
          total = parseFloat(total) + pr_price + totaltax ;
        }
        else
        {
          total = parseFloat(total) + pr_price ;
        }
        totalqty = parseFloat(totalqty) + parseFloat(data.quantity);

        var title = data.title.toLowerCase();
        title = title.split(' ').join('-');
        url = mainurl+'/product/'+data.product+'/'+title;

        if(data.productimage != '')
        {
          imgurl = mainurl+'/assets/images/products/'+data.productimage;
        }
        else
        {
          imgurl = mainurl+'/assets/images/placeholder.jpg';
        }
        
        $("#goCart").append('<div class="cart-item"><a href="'+url+'"><div class="img-prod-item"><img src="'+imgurl+'" class="img-fluid mx-auto"></div><div class="item-description"><h2 class="title">'+data.title+'</h2><ul class="add-info"><li>'+str+'</li><li>'+str1+'</li></ul><div class="qty">'+data.quantity+' X</div><div class="price"> &nbsp;'+currency+Number(data.cost).toFixed(2)+'</div></div></a><div class="delete"><a href="javascript:;" onclick=" getDelete('+data.product+')"><i class="far fa-trash-alt"></i></a></div></div>');

        $('.cartbox-total .total-price').html(currency+total.toFixed(2));

        $('#cartQty').html(totalqty);

        $('#emptycart').html('');

      })

    })

  });

}

function getDelete(id) {
  $.get(mainurl+'/cartdelete/'+id, function(response){
          
    $('#emptycart').html(EmptyCartlang);
    $('#cartempty').html('<td><h3>'+EmptyCartlang+'</h3></td>');
    $('#item'+id).remove();

    var total = 0;
    var totalqty = 0;
    var finaltotal = 0;
    var url = '';
    var str = '';
    var str1 = '';
    var rowCount = $('.table-cart tbody tr').length;

    $("#goCart").html('');
    if(rowCount == 0)
    {
      $('#emptycart').html(EmptyCartlang);
      $('.my-cart-wrap .row').html('<div class="col-md-12"><h4>'+EmptyCartlang+'</h4><a href="'+mainurl+'" class="btn shopping-btn">'+ContinueShopping+'</a></div>');
      $('.cartbox-total .total-price').html(currency+'0.00');
      $('#cartQty').html(0);
    }

    $.each(response, function(i, cart){
      $.each(cart, function (index, data) {

        var pr_price = (parseFloat(data.cost))*(data.quantity);
        if(ship_info == 'Per Product')
        {
            if(data.shipping_cost != 0)
            {
              str = '<div class="quantity shipping_cost">'+ShippingCostlang+': '+data.shipping_cost+'</div>' ;
            } 

            var shipcost = data.shipping_cost;
            var totalcost = Number(shipcost) + Number(data.cost);
        }

        else if(ship_info  == 'Per Order') 
        {
            str = '';
            var shipcost = poshipcost;
            var totalcost = Number(data.cost);
        }
        if(tax_info == 'Per Product')
        {
            if(data.tax != 0)
            {
                var totaltax = totalcost * (data.tax/100);
                str1 = '<div class="quantity tax">'+Taxlang+'('+data.tax+'%): '+totaltax.toFixed(1)+'</div>' ;
            }
            else
            {
                str1 = '';
            }
            var tax = data.tax;
        }
        else if(tax_info  == 'Per Order') 
        {
            str1 = '';
            var tax = potax;
        }

        //var pr_price = (parseFloat(data.cost))*(data.quantity);

        if(ship_info == 'Per Product'  && tax_info == 'Per Product')
        {
          var per_tax = (parseFloat(data.cost) + parseFloat(shipcost)) * (tax/100);
          var totaltax = (per_tax) * (data.quantity);
          var totalshipcost = data.quantity * parseFloat(shipcost);
          total = parseFloat(total) + pr_price + totalshipcost + totaltax;
          finaltotal = total;
        }
        else if(ship_info == 'Per Product')
        {
          var totalshipcost = data.quantity * parseFloat(shipcost);
          total = parseFloat(total) + pr_price + totalshipcost ;
          var totaltax = (total) * (tax/100);
          finaltotal = parseFloat(total) + totaltax;
        }
        else if(tax_info == 'Per Product')
        {
          var totaltax = pr_price * (tax/100);
          total = parseFloat(total) + pr_price + totaltax ;
          finaltotal = parseFloat(total) + parseFloat(shipcost);
        }
        else
        {
          total = parseFloat(total) + pr_price ;
          totaltax = (total + parseFloat(shipcost)) * (tax/100);
          finaltotal = parseFloat(total) + parseFloat(shipcost) + totaltax;
        }

        totalqty = parseFloat(totalqty) + parseFloat(data.quantity);
        
        var title = data.title.toLowerCase();
        title = title.split(' ').join('-');
        url = mainurl+'/product/'+data.product+'/'+title;

        if(data.productimage != '')
        {
          imgurl = mainurl+'/assets/images/products/'+data.productimage;
        }
        else
        {
          imgurl = mainurl+'/assets/images/placeholder.jpg';
        }

        $("#goCart").append('<div class="cart-item"><a href="'+url+'"><div class="img-prod-item"><img src="'+imgurl+'" class="img-fluid mx-auto"></div><div class="item-description"><h2 class="title">'+data.title+'</h2><ul class="add-info"><li>'+str+'</li><li>'+str1+'</li></ul><div class="qty">'+data.quantity+' X</div><div class="price"> &nbsp;'+currency+Number(data.cost).toFixed(2)+'</div></div></a><div class="delete"><a href="javascript:;" onclick=" getDelete('+data.product+')"><i class="far fa-trash-alt"></i></a></div></div>');

        $('.cartbox-total .total-price').html(currency+total.toFixed(2));
        $('#cartQty').html(totalqty);
        $('#po_tax').html(totaltax);
        $('#subtotal').html(total.toFixed(2));
        $('#grandtotal').html(finaltotal.toFixed(2));
        $('#emptycart').html('');
    });

    });  
  });
}

$(".to-cart").click(function(){

  var formData = $(this).parents('form:first').serializeArray();

  $(this).find('.to_cart_loader').show();
  $(this).css('pointer-events', 'none');
  $(this).css('cursor', 'default');

  $.ajax({
    type: "POST",
    url: mainurl+'/cartupdate',
    data:formData,
    success: function (data) {
      $(this).find('.to_cart_loader').hide();
      getCart();

      $('.addcart_sec_'+data.product).load(' .addcart_sec_'+data.product);
      $('.list_addcart_sec_'+data.product).load(' .addcart_sec_'+data.product);
      $('.latestpr_sec_'+data.product).load(' .latestpr_sec_'+data.product);
      $('.featurepr_sec_'+data.product).load(' .featurepr_sec_'+data.product);
      $('.popupr_sec_'+data.product).load(' .popupr_sec_'+data.product);
      $('.signle_addcart_'+data.product).load(' .signle_addcart_'+data.product);
      $('.related_addcart_'+data.product).load(' .related_addcart_'+data.product);

      $.notify(AddCartMsglang, "success");

    },

    error: function (data) {
      //console.log('Error:', data);
    }
  });

});

//Start Review Scripts Start

var slice = [].slice;

(function($, window) {

    var Starrr;

    window.Starrr = Starrr = (function() {

      Starrr.prototype.defaults = {

        rating: void 0,
        max: 5,
        readOnly: false,
        emptyClass: 'fa fa-star-o',
        fullClass: 'fa fa-star',
        change: function(e, value) {}

      };

      function Starrr($el, options) {

        this.options = $.extend({}, this.defaults, options);
        this.$el = $el;
        this.createStars();
        this.syncRating();

        if (this.options.readOnly) 
        {
          return;
        }

        this.$el.on('mouseover.starrr', 'a', (function(_this) 
        {

          return function(e) 
          {
            return _this.syncRating(_this.getStars().index(e.currentTarget) + 1);
          };

        })(this));

        this.$el.on('mouseout.starrr', (function(_this) {

            return function() 
            {
              return _this.syncRating();
            };

        })(this));

        this.$el.on('click.starrr', 'a', (function(_this) {

            return function(e) 
            {
              return _this.setRating(_this.getStars().index(e.currentTarget) + 1);
            };

        })(this));

        this.$el.on('starrr:change', this.options.change);

      }

      Starrr.prototype.getStars = function() {

        return this.$el.find('a');

      };



      Starrr.prototype.createStars = function() {

          var j, ref, results;

          results = [];

          for (j = 1, ref = this.options.max; 1 <= ref ? j <= ref : j >= ref; 1 <= ref ? j++ : j--) {

              results.push(this.$el.append("<a href='javascript:;' />"));

          }

          return results;

      };

      Starrr.prototype.setRating = function(rating) {

        if (this.options.rating === rating) {

          rating = void 0;

        }

        this.options.rating = rating;
        this.syncRating();
        return this.$el.trigger('starrr:change', rating);

      };

      Starrr.prototype.getRating = function() {

        return this.options.rating;

      };

      Starrr.prototype.syncRating = function(rating) {

        var $stars, i, j, ref, results;

        rating || (rating = this.options.rating);

        $stars = this.getStars();

        results = [];

        for (i = j = 1, ref = this.options.max; 1 <= ref ? j <= ref : j >= ref; i = 1 <= ref ? ++j : --j) {

            results.push($stars.eq(i - 1).removeClass(rating >= i ? this.options.emptyClass : this.options.fullClass).addClass(rating >= i ? this.options.fullClass : this.options.emptyClass));

        }

        return results;

      };

      return Starrr;

  })();

  return $.fn.extend({

    starrr: function() {

      var args, option;

      option = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];

      return this.each(function() {

        var data;

        data = $(this).data('starrr');

        if (!data) {

          $(this).data('starrr', (data = new Starrr($(this), option)));

        }

        if (typeof option === 'string') {

          return data[option].apply(data, args);

        }

      });

    }

  });

})(window.jQuery, window);


$(document).ready(function(){

    $('#languageSwitcher').change(function(){
        var locale = $(this).val();
        var _token = $("input[name=_token]").val();
        //console.log(locale);

        $.ajax({  

            url: mainurl+"/language",  

            data: {locale:locale, _token:_token},  

            type: "POST",  

            success: function (data) {
                //console.log(data);
            },
            error: function (data) {

            },
            beforeSend: function () {

            },
            complete: function (data) {
                window.location.reload(true);
            },

        }); 

    });

});

