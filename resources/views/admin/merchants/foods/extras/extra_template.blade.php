@extends('merchants.layouts.master') 

@section('title', 'Foods Management :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')



<script type="text/javascript">

//CREATE------------

      $('#CreateExtraFormButton').click(function(e) {      
       $('.alert-danger').hide();
       $('.alert-success').hide();
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $("#createform").attr('action'),
                    method: 'post',
                    data: $("#createform").serialize(),

                     beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                     
                     toastr.clear();
                        
                        if(result.errors) {
                             $('.alert-danger').html('');
                            
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                 $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                               
                            });
                        } 

                  else { // if added success
                       $('.alert-danger').hide();
                       $('.alert-success').show();    
                        Command: toastr ["success"] ("Added successfully", "Added status",{ timeOut: 900 });
                        $('#visual_table').DataTable().ajax.reload();
                        document.getElementById("createform").reset();
                        $("#client").empty();
                        $("#restaurant").select2('val', 'All');
                        $("#roles").selectpicker("refresh");
                      
                        }
                    
                    }
                });
            });






//----------------- multiple-------------

 $(document).ready(function () {

     if($('#is_vary_price').val()==1)
       checkVarySize(1);
        else
       checkVarySize(0);

        


 function checkVarySize(checker)
   {  
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
              $.ajax({
                    url: '{{ route('manager.VaryPriceCheck') }}',
                    method: "get",
                    data: {
                      'checker':checker,
                      'food_id':'{{$food->id}}'
                    },
                    type: 'json',
                    success: function (data) {
            $("#add_more").click(function(){
             
             $("#dynamicTable").append('<tr class="dynamic-added">'+data.showVariation+'<td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
              });
   
              $(document).on('click', '.remove-tr', function(){  
                   $(this).parents('tr').remove();
              }); 

        }
      });
   }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });


            $('#CreateFormButton').click(function () {

                $.ajax({
                    url: $("#createform").attr('action'),
                    method: 'post',
                    data: $("#createform").serialize(),
                 
                 beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function (result) {
                        toastr.clear();
                      if(result.error) {
                            $('.alert-danger').html('');
                            $.each(result.error, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                          });
                        } 

                        else {                    

                            i = 1;
                            $('.dynamic-added').remove();
                            $('#createform')[0].reset();
                             $('.alert-danger').hide();
                             $('.alert-success').show();
                             $('#select2-extra_group_id-container').html("Select Extra Group");

                              Command: toastr ["success"] ("Added successfully", "Added status",{ timeOut: 900 });
                        }
                    }
                });
            });

});

//-----------

</script>



@endsection