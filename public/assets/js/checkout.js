//Saved Card Payment BTN

$('.payment_tab').on("click", function(e) {
  if (!$(this).hasClass("s-btn--selected"))
  {
    
    payby=$(this).data('id')
    e.preventDefault();

 //Send Ajax
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
                  });

        $.ajax({
            method: 'get',
            url: '/payment_tabs/',
            data: {'payby':payby,},

            beforeSend: function () {
                                      },
 success: function (data) {

                $('#update_order_status').html(data.update_order_status);
     

                ordertype='d';
            }
        });
}
//----------------------End Ajax-------------------

    });



//------------- Exist Payment 

$(document).ready(function() {
existingPaymentId=$('input[name=paymentMethods]:checked').val();
});

$(function () {

    $('input[type=radio][name=paymentMethods]').change(function() {
      existingPaymentId=this.value;
      });


    $('#savedc_checkout-submit').on("click", function () {

        submitExistingPayment();
    });
});

function submitExistingPayment() {
    // We check and then reset existingPaymentId to prevent duplicate charges
    if (existingPaymentId) {

        let url = '/Exist_payment/charge/'+existingPaymentId;
        existingPaymentId = '';
        window.location.href = url;
    }
}


//--------------New Payment

$(function() {
    var $form  = $(".require-validation");
  
$('#cc_checkout-submit').click(function(e) {
 $("#cc_checkout-submit").prop("disabled", true); 

    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('cart_hidden');
        

 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('cart_hidden');

        e.preventDefault();

      }
    });
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
   
  });
  
  function stripeResponseHandler(status, response) {
       
        if (response.error) {
            $('.error')
                .removeClass('cart_hidden')
                .find('.alert')
                .text(response.error.message);
                $("#cc_checkout-submit").prop("disabled", false);


              } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
              

            $form.get(0).submit();
        }
    }
  
});

//---------No enter btn to use here
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});


//----------------if empty field show messages --------------

$(document).ready(function() {
  var storeinfo = {!! json_encode($storeinfo) !!};


/*Empty  delivery address inputs */
$('.requiredfiled').keyup(function() {
  $(this).toggleClass('s-form-control--invalid', $(this).val() == "");
  $(this).next('.error_required').toggleClass('cart_hidden', $(this).val() != "");
});

//----------On click continue to payment Button

$('#updateaddress').click(function() {
  var isFilled = $('.requiredfiled').filter(function () { 
    return $.trim($(this).val()).length == 0 
  }).length === 0;
  
  if(isFilled){
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                       });

              $.ajax({
                url: '/order/update_deliveryaddress',
                method: 'GET',
                data: $("#gatherForm").serialize(),

                 beforeSend: function( xhr )
                {
                $("#gatherForm :input").prop("disabled", true);
                $("#paymentloadingbtn").show();
                $("#updateaddress").hide();
                },

                success: function(result) {
                $("#gatherForm :input").prop("disabled", false);
                $("#paymentloadingbtn").hide();
                $("#updateaddress").show();
                window.location = result;

                }
            });
  } 

  
//if some reuquired fields are empty
  else {
  
    $('.requiredfiled').each(function() {
      $(this).toggleClass('s-form-control--invalid', $(this).val() == "");
      $(this).next('.error_required').toggleClass('cart_hidden', $(this).val() != "");
    });
  
  }
});
});