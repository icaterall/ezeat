@extends('merchants.restaurant.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')
 


 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                   <i class="fa fa-outdent text-primary"></i>
                </span>
                <a href="{{ route('manager.index') }}" class="btn btn-light-primary font-weight-bolder btn-sm">Dashboard </a>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold">Edit {{$data->name}}</span>
            </div>
        </div>
    </div>
    
            
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <div class="card-title">
                      <span class="card-icon">
                        <i class="fa fa-edit text-primary"></i>
                      </span>
                      <h3 class="card-label">Edit Restaurant information</h3>
                    </div>
                  </div>

<!-- Show repsonse messages -->
         @include('admin.include.response_notification')
<!-- end response messages -->

<!-- Body -->
<div class="card-body">
          
@if (\Request::is('new_restaurant/*'))

    <form  action="{{ route('merchant.new_restaurant.update', $data->id) }}" id="editform" method="POST" class="form-horizontal">
@else
<form  action="{{ route('admin.restaurants.update', $data->id) }}" id="editform" method="POST" class="form-horizontal">
@endif

      
                 @include('admin.restaurants.all_restaurants.form')

    </form>    
                   
                  
                  </div>
<!-- End body -->

                </div>
                <!--end::Card-->
                
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>

<!-- Form -->
@endsection
