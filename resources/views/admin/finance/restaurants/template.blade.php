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
                pageLength: 15, 
                responsive: true,
                aaSorting: [[2, 'desc']],

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
        url: '{{ route('admin.restaurant_payouts.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [

      {data: 'restaurant', name: 'restaurant', sClass: 'text-center'},
      {data: 'total', name: 'total', sClass: 'text-center'},
      {data: 'orders', name: 'orders', sClass: 'text-center'},
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
    });
});


</script>

@endsection
