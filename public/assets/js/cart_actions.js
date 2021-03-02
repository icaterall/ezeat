   $(document).ready(function() {

//------------------------ No scrolling 
$( '.current_cart' ).on( 'mousewheel DOMMouseScroll', function ( e ) {

    var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;

    this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
    e.preventDefault();
});


//---------------------------------------Delete from Cart


    $(document).on('click', '.remove_cart_item', function(e) {
        e.preventDefault();
        var food_name = $(this).data('food_name');
        var id = $(this).data('id');    
        $('.food_name').text(food_name);
        $('.confirmItemRemove').attr("data-id",id); 
        $('.FoodDeleteBlackBox').removeClass('cart_hidden'); //Show Black message
    });



//------------- If NO -----------------
$(document).on('click', '.cancelItemRemove', function(e) {
        e.preventDefault();

      $('.FoodDeleteBlackBox').addClass('cart_hidden'); //Hide Black message

    });


//------------- If YES -----------------

    $(document).on('click', '.confirmItemRemove', function(e) {

        e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
             headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
         });
        $.ajax({
            
            url: "/restaurant/carts/" + id,
            method: 'DELETE',

            beforeSend: function() {
            },

            success: function(data) {
          $("#cart_content").html(data.cart_content); 
          $("#cart_badge").html(data.cart_badge);     
             
            }
        });
    });


//------------- Proceed To checkout -----------------

    $(document).on('click', '.validate_cart', function(e) {
        e.preventDefault(); 
        $.ajax({
            type: 'get',
            url: "/restaurant/validate_cart",
            data: {
                '_token': $('input[name=_token]').val()
            },

            beforeSend: function() {
            $('.validate_cart_loading').show();
            $('.validate_cart').hide();
            },

            success: function(data) {              
              $('.validate_cart').show();
              $('.validate_cart_loading').hide();
                if(data.validate == false)
                {
                  $("#minimum_order_body").addClass("openDialog"); 
                }
                else
                {
                  $("#minimum_order_body").removeClass("openDialog"); 
                   window.location = data.url;

                }
            }
        });
    });




});