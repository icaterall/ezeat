@extends('admin.restaurants.cuisines.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')

@include('admin.restaurants.cuisines.create')

 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">


@include('admin.restaurants.cuisines.datatable')
@include('admin.restaurants.cuisines.edit')
</div>

@include('admin.include.delete')

@endsection