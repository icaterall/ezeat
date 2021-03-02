
$(document).ready(function () {

   $('#mobile').keyup(function () {
   $('.error_phone').addClass('hidden');
   $('.error_code').addClass('hidden');
    });
 });

      // Get New Code.
            $('.get_code').click(function(e) { 
              thisbtn=$(this).data("thisbtn");
                id=0;
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                 if(thisbtn == 'getcode')
              {
                $('#activation_code').val(null);
              } 
              if(thisbtn=='verifycode')
              {
                if($('#activation_code').val().length < 3)
                {
                   $('.error_code').html('Please enter the correct code');
                   $('.error_code').removeClass('hidden');
                }
              }

              if((thisbtn=='getcode') || ((thisbtn=='verifycode') && ($('#activation_code').val().length > 3) ))
                
              {


                $.ajax({
                    url: 'activate_customer/'+id,
                    method: 'PUT',
                    data: $("#submit_sms_code_form").serialize(),
                      
                    beforeSend: function( xhr )
                    {
                  
                      $('.session_alert').addClass('hidden');
               $("#submit_sms_code_form :button").prop("disabled", true);
               $("#submit_sms_code_form :input").prop("disabled", true);
                    },

                    success: function(result) {

               $("#submit_sms_code_form :button").prop("disabled", false);
               $("#submit_sms_code_form :input").prop("disabled", false);

                      if(result.errors) {
                            $('.error_phone').html('');
                            $.each(result.errors, function(key, value) {
                                $('.error_phone').removeClass('hidden');
                                $('.error_phone').append('<div style=font-size:14px>'+value+'</div><br>');
                            });
                        } 
                  
                       
                      else if(result.message) 

                       {
                            $('.error_code').html(result.message);
                            $('.error_code').removeClass('hidden');

                        } 

                        else {

                            $('.error_phone').addClass('hidden');
                            
                            $('.alert-success').show();
                        
                            
                            if($('#first_time').val() == 1)
                              {
                              $('.alert-success').show();
                              $('.alert-success').html('The activation code has been sent successfully.');                               
                               location.reload();
                              } 

                               else if((thisbtn=='getcode') && ($('#first_time').val()!=1))
                                {
                                
                                $('.alert-success').show();
                                $('.alert-success').html('The activation code has been sent successfully.'); 
                                location.reload();
                                }

                              else if(thisbtn=='verifycode') 

                              {
                                 $('.alert-success').show();
                                $('.alert-success').html('Verified successfully.'); 

                               window.location = result;
                              }

                        }
                    }
                });
             }
        });


