@extends('admin.merchants.layouts.master') 

@section('title', 'Restaurant Management :: Spoongate')

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
                pageLength: 5, 
                responsive: true,
                 aaSorting: [[5, 'desc']],
             // Pagination settings
      dom: `<'row'>
      <'row'<'col-sm-12'tr>>
      `,         
      "iDisplayLength": 5,
      "aLengthMenu": [[5, 10,50, 100, -1], [5, 10,50, 100, "All"]],
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route('manager.orders.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [
      {data: 'id', name: 'id', sClass: 'text-center'},
      {data: 'client', name: 'client', sClass: 'text-center'},
      {data: 'total', name: 'total', sClass: 'text-center'},
      {data: 'order_status_id', name: 'order_status_id', sClass: 'text-center'},
      {data: 'active', name: 'active', sClass: 'text-center'},
      {name: 'created_at.timestamp', 'data': { '_': 'created_at.display', 'sort': 'created_at' } },
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
   
      columnDefs: [

        {
          width: '75px',
          targets: 3,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Order Received', 'state': 'danger'},
              2: {'title': 'Preparing', 'state': 'warning'},
              3: {'title': 'Ready', 'state': 'success'},
              4: {'title': 'On the Way', 'state': 'warning'},
              5: {'title': 'Delivered', 'state': 'warning'},
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
              1: {'title': 'Active', 'state': 'success'},
              0: {'title': 'Canceled', 'state': 'warning'},
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
</script>


@endsection