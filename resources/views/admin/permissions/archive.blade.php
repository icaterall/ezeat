@extends('admin.permissions.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')

@include('admin.permissions.create')

 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">


@include('admin.permissions.datatable')
@include('admin.permissions.edit')
</div>

@include('admin.include.delete')

@endsection