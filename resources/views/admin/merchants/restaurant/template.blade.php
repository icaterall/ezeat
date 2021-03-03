@extends('admin.merchants.layouts.master') 

@section('title', 'Restaurant Management :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')
@include('admin.restaurants.all_restaurants.datatable_js')


@endsection
