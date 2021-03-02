@extends('admin.restaurants.categories.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')

@include('admin.restaurants.categories.create')

 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">


@include('admin.restaurants.categories.datatable')
@include('admin.restaurants.categories.edit')
</div>

@include('admin.include.delete')

@endsection