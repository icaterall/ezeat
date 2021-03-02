@if (Auth::check())
    <div id="kt_quick_user_setting" class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
            
 @include('admin.include.response_notification')

            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0">User Setting</h3>
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_setting_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->
            <!--begin::Content-->

                                        <!--begin::Card-->
                                            <!--begin::Header-->
                                            <div class="card-header py-3">
                                               
                                                <div class="card-toolbar">
                                                    <button type="reset" id="updateprofile" class="btn btn-success mr-2">Save Changes</button>
                                                    
                                                </div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Form-->
            <form  action="{{ route('customer_dashboard.update', Auth::user()->id) }}" id="updateuserform" method="POST" class="form-horizontal">

                                                <!--begin::Body-->
                                                   
                                                <div class="form-group row">
                                                       
                                                       <div class="col-xl-12"><label>Name</label>
                                                        <input name="name" class="form-control form-control-lg form-control-solid" type="text" value="{{Auth::user()->name}}">
                                                        </div>
                                                    
                
                                                    <div class="col-xl-12">
                                                        <label>Personal Mobile</label>
                                                        <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-phone"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" name="mobile" class="form-control form-control-lg form-control-solid" placeholder="Phone" value="{{Auth::user()->mobile}}">
                                                            </div>
                                                          
                                                        </div>
                        
                                                          <div class="col-xl-12">
                                                        <label>Email</label>
                                                        
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-at"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" name="email" class="form-control form-control-lg form-control-solid" value="{{Auth::user()->email}}" placeholder="Email">
                                                            </div>
                                                        </div>

                                                 <div class="col-xl-12">
                                                        <label>Password</label>
                                                        

                                    <div class="input-group input-group-lg input-group-solid">
                                                                <div id="show_password" class="input-group-prepend cursor">
                                                                 
                                  <span class="input-group-text">
                                    <i class="fa fa-eye" id="eye"></i> 
                                  <i class="fa fa-eye-slash" id="eyeslash" style="display: none"></i>
                              </span>

                               
                                                                </div>
                                                                <input type="password" id="password" name="password"  class="form-control form-control-lg form-control-solid">
                                                            </div>


                                                   
                                                    </div>
                                                </div>
                                                <!--end::Body-->
                                            </form>
                                            <!--end::Form-->
                                    
                                  
            <!--end::Content-->
        </div>

        @endif