$(document).on("click", ".open_food_modal", function (e) {

    e.preventDefault();
    $(".menu-item-image").css("background-image", "url(" + "/csfiles/img/empty.jpg" + ")");
    $(".menu-item-image").removeClass("s-dialog--complex-hero");
    $("#special").val("");
    $(".hidespinner").css("display", "none");
    $("#quantity-select").find("option").remove().end();

    var foodID = $(this).data("id");
    hideitem = "#" + foodID;
    loadingtext = "." + foodID;
    $(".hidespinner").css("display", "none");
    $(".hidedetailspinner").css("display", "block");
    $.ajaxSetup({
             headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
       });

    $.ajax({
        url: "/restaurant/get_food_detail",
        type: "get",
        data: {
            foodID: foodID,
        },

        beforeSend: function () {
            $(hideitem).css("display", "none");
            $(loadingtext).css("display", "block");
            $("#cartloadingbtn").show();
            $("#activebtn").hide();
        },

        success: function (data) {                                


            $(hideitem).css("display", "block");
            $(loadingtext).css("display", "none");
            $("#cartloadingbtn").hide();
            $("#activebtn").show();
           
           if(data.login == 0)
           {
            alert('plz login');
           }

            if(is_location_exist == 0)
             {
                            $("#set_location_body").addClass("openDialog");
                            $(".is_address_accept").addClass("postal-index-form-overlay");
                            $(".menu__items-wrapper").addClass("postal-index-form-overlay--shown");
             }
            


            if(is_far == 1) // not acceptable
                {
                    $(".is_address_accept").addClass("postal-index-form-overlay");
                    $(".menu__items-wrapper").addClass("postal-index-form-overlay--shown");
                }
                

                // if Store is open and customer service is open
            
            else if ((data.is_open == true) && (data.isapp_open == true))
                {                        
                    $("#product_modal").addClass("openDialog");
                    $("#qty_increment").val(1);
                    $("#specialinstruction").val('');
                } 

                      // Store is close but you already schudled ur order
          
                else if ((data.is_open == false) && (data.isapp_open == true) && (pre_order==1))
                   {                        
                            $("#product_modal").addClass("openDialog");
                            $("#qty_increment").val(1);
                            $("#specialinstruction").val('');
                     } 
              

                      // Store is close but you must schudle ur order

                      else if ((data.is_open == false) && (data.isapp_open == true) && (pre_order == 0))
                    {   
                        $(".select_when_delivery").trigger("click");
                        $("#calende_message").show();
                        $("#calende_message").text('Restaurant is closed now .. Please schedule your order');           
                    } 

                    else
                    {
                      $("#store_close_body").addClass("openDialog");
                    }


                    if (data.food.image == null) {
                    $(".menu-item-image").css("background-image", "url(" + "/csfiles/img/empty.jpg" + ")");
                    $(".menu-item-image").removeClass("s-dialog--complex-hero");
                    
                    } 

                    else {
                    $(".menu-item-image").addClass("s-dialog--complex-hero");
                    $(".menu-item-image").css("background-image", "url(/uploads/productimages/" + data.food.image + ")");
                        }

                    $("#product_category").html(data.category.name);
                    $("#product_title").html(data.food.name);
                    $("#product_details").html(data.food.description);
                    $("#product_price").html("$ " + parseFloat(data.food.price).toFixed(2));


        },
    });
});


