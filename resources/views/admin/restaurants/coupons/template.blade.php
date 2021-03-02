@extends('admin.layouts.master') 

@section('title', 'Coupons Management :: Spoongate')

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
                 aaSorting: [[8, 'desc']],
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
        url: '{{ route('admin.coupons.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [

      {data: 'code', name: 'code', sClass: 'text-center'},
      {data: 'discount', name: 'discount', sClass: 'text-center'},
      {data: 'single_use', name: 'single_use', sClass: 'text-center'},
      {data: 'minimum_order', name: 'minimum_order', sClass: 'text-center'},
      {data: 'restaurant', name: 'restaurant', sClass: 'text-center'},
      {data: 'user', name: 'user', sClass: 'text-center'},
      {data: 'expires', name: 'expires', sClass: 'text-center'},
      {data: 'enabled', name: 'enabled', sClass: 'text-center'},
      {name: 'created_at.timestamp', 'data': { '_': 'created_at.display', 'sort': 'created_at' } },

      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
   

      columnDefs: [
        
        {
          width: '75px',
          targets: 2,
          render: function(data, type, full, meta) {
            var status = {
              0: {'title': 'Multiple Use', 'state': 'success'},
              1: {'title': 'Single Use', 'state': 'warning'},
            };
            if (typeof status[data] === 'undefined') {
              return data;
            }
            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },


        {
          width: '100px',
          targets: 4,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'All restaurants', 'state': 'success'},

            };
            if (typeof status[data] === 'undefined') {
               return '<span class="label label-danger label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-danger">' + data + '</span>';
            }
            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },
             
               {
          width: '75px',
          targets: 5,
          render: function(data, type, full, meta) {
            var status = {

              1: {'title': 'All clients', 'state': 'success'},
            };
            if (typeof status[data] === 'undefined') {
              return data;
            }
            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },


        {
          width: '80px',
          targets: 6,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Forever', 'state': 'success'},
            };
            if (typeof status[data] === 'undefined') {

                return '<span class="label label-danger label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-danger">' + data + '</span>';
            }

            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },


        {
          width: '75px',
          targets: 7,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Active', 'state': 'success'},
              0: {'title': 'Disabled', 'state': 'warning'},
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
    $('tbody').on('click', '.remove-record', function () {
      var url = $(this).attr('data-url');
      $(".remove-record-model").attr("action",url);
  
      $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
    });
 

 $('#empty_client').click(function() {

 $("#client").select2('val', 'All');

  });
$('#empty_restaurant').click(function() {
$("#restaurant").select2('val', 'All');

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
</script>


@endsection
