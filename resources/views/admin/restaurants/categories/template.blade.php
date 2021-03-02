@extends('admin.layouts.master') 

@section('title', 'Cuisines Management :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {

    // begin table

  var table = $('#visual_table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                pageLength: 10, 
                responsive: true,
             // Pagination settings
      dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
      <'row'<'col-sm-12'tr>>
      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,         
      "iDisplayLength": 10,
      "aLengthMenu": [[5, 10,50, 100, -1], [5, 10,50, 100, "All"]],
      buttons: [
        'print',
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
      ],
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route('admin.categories.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [

      {data: 'name', name: 'name', sClass: 'text-center'},
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
   



    });

});

// End Table


// Create 

      $('#CreateFormButton').click(function(e) {  

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
                       $('#visual_table').DataTable().ajax.reload();
                       $('#create-modal').hide();
                       $('.modal-backdrop').css('display','none');     
                       $('.alert-danger').hide();
                       $('.alert-success').show();    
                        Command: toastr ["success"] ("Added successfully", "Added status");
                        document.getElementById("createform").reset();
 

                      
                        }
                    
                    }
                });
            });


//  Edit
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
                             Command: toastr ["success"] ("Updated successfully", "Update status");                    
                        
                        }
                    }
                });
            });


// Delete form

 // For A Delete Record Popup
  $(document).ready(function() {
    // For A Delete Record Popup
    $('tbody').on('click', '.remove-record', function () {
      var url = $(this).attr('data-url');
      $(".remove-record-model").attr("action",url);
    });
    


//SHOW  Edit Form Modal 

    $('tbody').on('click', '.edit_btn', function (e) {
      e.preventDefault();
      var url = $(this).attr('data-url');
      $("#editform").attr("action",$(this).attr('data-id'));
       $('.alert-success').hide();  
       $('.alert-danger').html('');
       $('.alert-danger').hide();

                $.ajax({
                    url: url,
                    method: 'GET',
                  
                   beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                        toastr.clear();
                        console.log(result.showForm);
                        $('#showForm').html(result.showForm);    
          }
       });
    });



  });


            // Delete product Ajax request.
            $('#delete_record').click(function(e) {
                e.preventDefault();             
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: $(".remove-record-model").attr('action'),
                    method: 'DELETE',
                    beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                       toastr.clear(); 
                        $('#visual_table').DataTable().ajax.reload();
                        $('#delete-modal').hide();
                        $('.modal-backdrop').css('display','none');
                        Command: toastr ["error"] ("Deletion completed successfully", "Deletion status");
                    }
                });
            });

// ------------Show password
$(document).on('click','#show_password', function(){
    if( $('#password').prop('type') == 'password' )
                { 
                  $('#password').attr('type', 'text');
                  $('#eye').css('display','none');
                  $('#eyeslash').css('display','block');             
                 } 
                 else 
                 {$('#password').attr('type', 'password');
                   $('#eye').css('display','block');
                  $('#eyeslash').css('display','none');
                 }
          });

</script>


@endsection
