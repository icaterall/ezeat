@extends('admin.layouts.master') 

@section('title', 'Rider Managment::Customer Service ')

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
                pageLength: 50, 
                responsive: true,
                aaSorting: [[5, 'desc']],

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
        url: '{{ route('admin.riders.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },

           columns: [
            {data: 'id',name: 'id',visible: false},
            {data: 'name', name: 'name', sClass: 'text-center' },
            {data: 'mobile', name: 'mobile', sClass: 'text-center' },
            {data: 'approved', name: 'approved', sClass: 'text-center' },
            {data: 'active', name: 'active', sClass: 'text-center' },
              {data: 'last_update', name: 'last_update',orderable: true },

            {'name':'updated.timestamp','data': { '_': 'updated.display','sort': 'updated'},visible: false},

            {data: 'last_location', name: 'last_location' },

            {data: 'action',name: 'action',orderable: false,serachable: false,sClass: 'text-center'},
         ],

      columnDefs: [

        {
          width: '75px',
          targets: 3,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Yes', 'state': 'success'},
              0: {'title': 'No', 'state': 'danger'},
            };
            if (typeof status[data] === 'undefined') {
              return data;
            }
            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },

        {
          width: '75px',
          targets: 4,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Yes', 'state': 'success'},
              0: {'title': 'No', 'state': 'danger'},
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
                           
                             Command: toastr ["success"] ("Updated successfully", "Update status");                    
                        
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