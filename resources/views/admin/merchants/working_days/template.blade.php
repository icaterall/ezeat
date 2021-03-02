@extends('merchants.layouts.master') 

@section('title', 'Working Days Management :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')
<script type="text/javascript">
   
            // Update Ajax request.
            $('#EditFormButton').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: $("#editform").attr('action'),
                    method: 'PUT',
                    data: $("#editform").serialize(),
                      
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
                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('#visual_table').DataTable().ajax.reload();
                             Command: toastr ["success"] ("Updated successfully", "Update status",{ timeOut: 1000 });                    
                        
                        }
                    }
                });
            });


</script>


@endsection
