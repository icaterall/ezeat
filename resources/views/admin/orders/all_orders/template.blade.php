@extends('admin.layouts.master') 

@section('title', 'Orders Management :: Spoongate')

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
                 aaSorting: [[10, 'desc']],
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
        url: '{{ route('admin.orders.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [
      {data: 'id', name: 'id', sClass: 'text-center'},
      {data: 'restaurant', name: 'restaurant', sClass: 'text-center'},
      {data: 'client', name: 'client', sClass: 'text-center'},
      {data: 'total', name: 'total', sClass: 'text-center'},
      {data: 'restaurant_total', name: 'restaurant_total', sClass: 'text-center'},
      {data: 'order_status_id', name: 'order_status_id', sClass: 'text-center'},
      {data: 'active', name: 'active', sClass: 'text-center'},
      {data: 'is_cash', name: 'is_cash', sClass: 'text-center'},
      {data: 'active', name: 'active', sClass: 'text-center'},
      {data: 'is_app', name: 'is_app', sClass: 'text-center'},
      {name: 'created_at.timestamp', 'data': { '_': 'created_at.display', 'sort': 'created_at' } },
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
   
      columnDefs: [
        
        {
          width: '75px',
          targets: 5,
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
          targets: 8,
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
        {
          width: '75px',
          targets: 9,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Yes', 'state': 'success'},
              0: {'title': 'No', 'state': 'warning'},
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
          targets: 6,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Paid', 'state': 'success'},
              0: {'title': 'Pending', 'state': 'warning'},
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
          targets: 7,
          render: function(data, type, full, meta) {
            var status = {
              0: {'title': 'Online', 'state': 'success'},
              1: {'title': 'Cash', 'state': 'warning'},
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
@include('admin.orders.all_orders.template_functions')

@endsection