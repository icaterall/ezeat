@extends('admin.layouts.master') 

@section('title', 'Restaurant Payment :: Spoongate')

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
        url: '{{ route('admin.paymentRiderHistoryArchive') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [

      {data: 'driver', name: 'driver', sClass: 'text-center'},
      {data: 'method', name: 'method', sClass: 'text-center'}, 
      {data: 'amount', name: 'amount', sClass: 'text-center'}, 
      {name: 'paid_date.timestamp', 'data': { '_': 'paid_date.display', 'sort': 'paid_date' } },
      {data: 'note', name: 'note', sClass: 'text-center'},
      {name: 'updated_at.timestamp', 'data': { '_': 'updated_at.display', 'sort': 'updated_at' } },
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
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
