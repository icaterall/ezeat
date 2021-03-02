@extends('admin.layouts.master') 

@section('title', 'Users Management :: Spoongate')

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
        url: '{{ route('admin.users.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [

      {data: 'name', name: 'name', sClass: 'text-center'},
      {data: 'mobile', name: 'mobile', sClass: 'text-center'},
      {data: 'email', name: 'email', sClass: 'text-center'}, 
      {data: 'status', name: 'status', sClass: 'text-center'},
      {data: 'permission', name: 'permission', sClass: 'text-center', searchable: true},
      {name: 'created_at.timestamp', 'data': { '_': 'created_at.display', 'sort': 'created_at' } },

      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
   

      columnDefs: [

        {
          width: '75px',
          targets: 3,
          render: function(data, type, full, meta) {
            var status = {
              0: {'title': 'Inactive', 'state': 'danger'},
              1: {'title': 'Active', 'state': 'success'},
            };
            if (typeof status[data] === 'undefined') {
              return data;
            }
            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },
         ],
    });
});

// End Table


// Create User 

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
                    url: '{{ route('admin.users.store') }}',
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
                        $("#roles").selectpicker("refresh");
                      
                        }
                    
                    }
                });
            });

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

 // For A Delete Record Popup
  $(document).ready(function() {
    // For A Delete Record Popup
     $("#password").attr('readonly', true);

     $('#password').click(function(e) {
     $("#password").attr('readonly', false);
     });

    $('tbody').on('click', '.remove-record', function () {
      var url = $(this).attr('data-url');
      $(".remove-record-model").attr("action",url);
      $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
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
