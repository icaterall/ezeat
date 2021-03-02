@extends('merchants.foods.extras.extra_template')

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
                <a href="{{route('manager.foods.edit',$food->id)}}" class="btn btn-light-primary font-weight-bolder btn-sm">All Food Extras</a>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold">New extra for food: {{$food->name}} </span>
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
                        <i class="fa fa-user-plus text-primary"></i>
                      </span>
                      <h3 class="card-label">Extra information</h3>
                    </div>
                  </div>

<!-- Show repsonse messages -->
         @include('admin.include.response_notification')
<!-- end response messages -->

<!-- Body -->
<div class="card-body">
                 
                @if (\Request::is('*/create_vary_price_extra/*'))

                @if(count($sizes) > 0) 

        <form  action="{{ route('manager.storeExtraSize') }}" id="createform" method="POST" class="form-horizontal">
                @endif
                 @else
        <form  action="{{ route('manager.extras.store') }}" id="createform" method="POST" class="form-horizontal">
                @endif

                 @include('merchants.foods.extras.form')

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
