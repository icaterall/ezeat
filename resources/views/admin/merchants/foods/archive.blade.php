@extends('admin.merchants.foods.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')



 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">


@include('admin.merchants.foods.datatable')
</div>

@include('admin.merchants.include.delete')

@endsection