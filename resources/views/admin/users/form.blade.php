         

                          <!--begin::Wizard Form-->
                              <div class="row">
                                <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Name</label>
                                    <input type="text" class="form-control form-control-solid" name="name" value="{{ (isset($data->name))? $data->name:'' }}" required="">
                                  
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div>
                                <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Email</label>
                                    <input type="text" class="form-control form-control-solid" name="email" value="{{ (isset($data->email))? $data->email:'' }}" required="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                                </div> 

                                <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile" value="{{ (isset($data->mobile))? $data->mobile:'' }}" required="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                               </div>

                                <div class="col-xl-3">

                            <label>Password                                      
                              
                              @if (\Request::is('*/edit'))
                              <span style="font-weight: 700;color:green">Change Password is optional</span>@endif</label>

                            <div class="input-group">
                              <input type="password" id="password" name="password" class="form-control form-control-solid" >
                              <div class="input-group-append">
                                <button class="btn btn-primary" id="show_password" type="button">
                                  
                                  <i class="fa fa-eye" id="eye"></i> 
                                  <i class="fa fa-eye-slash" id="eyeslash" style="display: none"></i>

                                </button>
                              </div>
                            </div>
                          </div>
                              </div>

                  <!-- Section 2 -->
                      <div class="row">    
                            <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                          <label>Privileges  (optional)</label>
                                            <select class="form-control selectpicker"  name="roles[]" id="roles" multiple="multiple">
                                                            
                         @if(isset($roles))
                             @if(count($roles) > 0)                    
                              @foreach($roles as $key=>$val)        
                                  @if(isset($userRole))           
                                      @if(count($userRole) > 0)
                                           <?php $found = 0; ?>
                                              @foreach($userRole as $roleKey=>$roleKey)
                                                 @if($roleKey == $key)
                                                   <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                    <?php $found++; break; ?>
                                                 @endif
                                              @endforeach
                                            @if($found == 0)
                                             <option value="{{ $key }}">{{ $val }}</option>
                                            @endif
                                        @else <!-- if count $userRestaurant == 0 -->
                                        <option value="{{ $key }}">{{ $val }}</option>
                                      @endif
                                  @else <!-- if Not isset $userRestaurant-->   
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endif 
                              @endforeach
                              @endif
                          @endif
                                            </select>
                                      <div class="fv-plugins-message-container"></div>
                                  </div>
                                  <!--end::Input-->
                               </div>
              

                     <div class="col-xl-6">
                       <label>Restaurants (optional)</label>
                       <div>
                        <select class="form-control select2 " autocomplete="off"  id="restaurants" name="restaurants[]" multiple="multiple">
                @if(isset($restaurants))
                   @if(count($restaurants) > 0)                    
                    @foreach($restaurants as $key=>$val)        
                        @if(isset($userRestaurant))           
                            @if(count($userRestaurant) > 0)
                                 <?php $found = 0; ?>
                                    @foreach($userRestaurant as $restaurantkey=>$restaurantkey)
                                       @if($restaurantkey == $key)
                                         <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                          <?php $found++; break; ?>
                                       @endif
                                    @endforeach
                                  @if($found == 0)
                                   <option value="{{ $key }}">{{ $val }}</option>
                                  @endif
                              @else <!-- if count $userRestaurant == 0 -->
                              <option value="{{ $key }}">{{ $val }}</option>
                            @endif
                        @else <!-- if Not isset $userRestaurant-->   
                      <option value="{{ $key }}">{{ $val }}</option>
                      @endif 
                    @endforeach
                    @endif
                @endif
                            </select>
                          </div>
                            <div class="fv-plugins-message-container"></div>
                         </div>

              <div class="col-xl-3">
                                   <label>Active?</label>
                                    <div class="dropdown bootstrap-select form-control dropup">
                                        <select name="status" class="form-control selectpicker" required="">
                                            <option class="bs-title-option" value=""></option>
                                            @if(count($status) > 0) 
                                              @foreach($status as $key=>$val)
                                                @if(isset($data->status)) 
                                                  @if($key == $data->status)
                                                  <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                  @else
                                                  <option value="{{ $key }}">{{ $val }}</option>
                                                  @endif 
                                                @else
                                                <option value="{{ $key }}">{{ $val }}</option>
                                                @endif
                                              @endforeach
                                             @endif
                                        </select>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                             </div>

                        </div>
          
                           <!--end::Sections-->
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                      

                          @if (\Request::is('*/edit'))
                                <button type="button" id="EditFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Save Change</button>
                          @else
                          <button type="button" id="CreateFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Submit</button>
                          @endif      


                            </div>
                          <!--end::Wizard Form-->

    {{ csrf_field() }}



<!-- End form -->
