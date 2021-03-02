@extends('admin.finance.riders.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')



 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">



@include('admin.finance.riders.datatable')
</div>

@include('admin.include.delete')

@endsection