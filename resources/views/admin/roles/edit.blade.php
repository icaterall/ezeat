@extends('admin.roles.template')

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
                <a href="{{ route('admin.roles.index') }}" class="btn btn-light-primary font-weight-bolder btn-sm">All Roles</a>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold">Edit role</span>
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
                      <h3 class="card-label">Edit user information</h3>
                    </div>
                  </div>

<!-- Show repsonse messages -->
         @include('admin.include.response_notification')
<!-- end response messages -->

<!-- Body -->
<div class="card-body">
                 
    <form  action="{{ route('admin.roles.update', $roles->id) }}" id="editform" method="POST" class="form-horizontal">
                 @include('admin.roles.form')


<button id="EditFormButton" type="button" class="btn btn-success font-weight-bold">Save changes</button>

                         
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
