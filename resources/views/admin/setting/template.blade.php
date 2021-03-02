@extends('admin.layouts.master') 

@section('title', 'Update Commission :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')

<script type="text/javascript">
  

// End Table


 // For A Delete Record Popup
  $(document).ready(function() {


//------------------Update Commission ------------

      $('#UpdateCommissionButton').click(function(e) { 

       $('.alert-danger').hide();
       $('.alert-success').hide();
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.update_commission') }}",
                    method: 'post',
                    data: {
                      'commission':$("#commission").val() 
                    },

                     beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ,please wait...", "Sending Request");
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
                       $('#commission').val('');
                         $('.alert-success').show(); 
                        Command: toastr ["success"] ("Commission updated successfully", "Update status");
                         }
                    }
                });
            });
        });


</script>

@endsection
