@extends('admin.roles.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')

@include('admin.roles.create')

 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">


@include('admin.roles.datatable')
</div>

@include('admin.include.delete')

@endsection