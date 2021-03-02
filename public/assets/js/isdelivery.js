
//Change to Takeout, Vice Versa

$('.order-type').on("click", function(e) {

    e.preventDefault();
var status = $(this).data('order_type');
  if (!$(this).hasClass("s-btn--selected")) { //only if its not selected
    
    $(this).html('Wait ..');
    $("#loading_list").css('display', 'block');
    $("#showcontent").css('display', 'none');

    $("#isdelivery :input").prop("disabled", true);

 //Send Ajax
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
                  });

        $.ajax({
            method: 'get',
            url: '/restaurant/delivery-pickup',
            data: {'status':status},


 success: function (data) {

                window.location.reload();
            }
        });
        }
     });

