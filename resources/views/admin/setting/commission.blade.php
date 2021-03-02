@extends('admin.setting.template')

@section('local_content')

    @section('css')

    @endsection

@section('content')
 

 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            
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
                      <h3 class="card-label"> Update restaurant commission</h3>
                    </div>
                  </div>

<!-- Show repsonse messages -->
         @include('admin.include.response_notification')
<!-- end response messages -->

<!-- Body -->
<div class="card-body">

<form  action="{{ route('admin.update_commission') }}" id="createform" method="POST" class="form-horizontal">

                 <!--end::Subheader-->
    @if ($message = Session::get('success'))
    <div class="alert alert-warning">
        <p style="text-align: center;
                color: black;
                font-weight: 800;" >
            {{$message}}
        </p>
    </div>
    @endif
    

<!-- --------------------Section 3--------------------- -->
<div class="row">
    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Commission percent</label>
            <input type="text" class="form-control form-control-solid" name="commission" id="commission" value="" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

 <div class="col-xl-2"> <label class="label_class">&nbsp;</label>
<div class="">

       <button type="button" id="UpdateCommissionButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Update</button>

  </div>
</div>


</div>

{{ csrf_field() }}

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
