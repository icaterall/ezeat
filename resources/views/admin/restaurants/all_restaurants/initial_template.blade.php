@extends('admin.layouts.master') 

@section('title', 'Restaurants Management :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {

    // begin table

  var table = $('#initial_datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                pageLength: 5, 
                responsive: true,
                aaSorting: [[4, 'desc']],

             // Pagination settings
      dom: `<'row'>
      <'row'<'col-sm-12'tr>>
      `,         
      "iDisplayLength": 10,
      "aLengthMenu": [[5, 10,50, 100, -1], [5, 10,50, 100, "All"]],

      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route('admin.restaurants.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [
      {data: 'logo', name: 'logo', sClass: 'text-center'},
      {data: 'name', name: 'name', sClass: 'text-center'},
      {data: 'mobile', name: 'mobile', sClass: 'text-center'}, 
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

    </script>

@endsection
