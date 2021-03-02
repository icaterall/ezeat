
//-------------------Get By sizes ------------
    $(document).ready(function() {
 
    food_id = $('#food_id').val();
    var variation_id = $('input[name=variation]:checked').val();
     var extraIds = null;
     var extraVariationIds = null;
     var quantity = 1;
//----------- Get Variation price
     if(variation_id)
     { 
        variation(variation_id);
     }
});


//----------- Get Variation price

     variation_id = $('input[name=variation]:checked').val();
     extraIds = [];
     extraVariationIds = [];
     quantity = 1;
     total_price = $('#food-cart-price').text();

    $('input[type=radio][name=variation]').change(function() {
    variation_id = this.value;
    extraIds = [];
     extraVariationIds = [];
    $('.extra_choice input').prop('checked', false); // Unchecks it
    variation(variation_id);
    });
//------------ Get Extra price--------
    $('.extra_choice input').on('click', function(e){
     extraIds = [];
    $.each($("input[name='extra_choice']:checked"), function () {
    extraIds.push($(this).val());
      });
    getFoodPrice(variation_id,extraVariationIds,extraIds);
    });               

 //------------ Get Extra Variation price--------   

    $(document).on('click', '.extra_variation_choice input', function(e){
     extraVariationIds = [];
    $.each($("input[name='extra_variation_choice']:checked"), function () {
        extraVariationIds.push($(this).val());
      });   
        getFoodPrice(variation_id,extraVariationIds,extraIds);
    });  


  function variation(variation_id)
{
     $.ajaxSetup({
             headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
       });
    $.ajax({
        url: '/restaurant/get_extra_variations',
        type: "get",
        data: {
            'variation_id': variation_id
        },
        beforeSend: function () {
        },
        success: function (data) {

        total_price = parseFloat(data.this_variation.price).toFixed(2);   
        total_qty_price = parseFloat(total_price * $('#qty_increment').val()).toFixed(2);   

        $("#variation_extras").html(data.variation_details);
        $('.food-price').html(total_qty_price);
        }
    });
   }
 
  function getFoodPrice(variation_id,extraVariationIds,extraIds)
{
     $.ajaxSetup({
             headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
       });
    $.ajax({
        url: '/restaurant/get_food_price',
        type: "get",
        data: {
            'variation_id': variation_id,
            'extraIds': extraIds,
            'extraVariationIds': extraVariationIds,
            'food_id': food_id
        },
        beforeSend: function () {
        },
        success: function (data) {
         total_price = parseFloat(data.total_price).toFixed(2);
         total_qty_price = parseFloat(total_price * $('#qty_increment').val() ).toFixed(2);
        $('.food-price').html(total_qty_price);
       
        }
    });
   }

//----------Price increament
 $(document).on('change', '#qty_increment', function(e){ 
    if(total_price == 0)
    {
       total_price =  $('#food-price').text();
    }
    total_qty_price = parseFloat(total_price * $('#qty_increment').val() ).toFixed(2);
    
   $('.food-price').html(total_qty_price);
   quantity = $('#qty_increment').val();
 
 });

  //--------------------------------Show Menu / Hide if out Cart frame---------

        /*ADD TO CART */

$(".add-to-cart").click(function() {
 

var instruction = $.trim($("#instruction").val());
var isEdit = $(this).data("is_edit");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'get',
                 url: '/restaurant/add_to_cart',
                data: {
                    'instruction': instruction,
                    'variation_id': variation_id,
                    'extraIds': extraIds,
                    'extraVariationIds': extraVariationIds,
                    'food_id': food_id,
                    'quantity': quantity,
                    'isEdit':isEdit
                },

                beforeSend: function () {
                    $('.loader').show();
                },

                success: function (data) {


               $("#cart_content").html(data.cart_content);
               $("#cart_badge").html(data.cart_badge);
               $("#food_modal").modal('hide'); 
               $("#cart_modal").modal('show');
               $('.loader').hide();



                }
            });
          });
