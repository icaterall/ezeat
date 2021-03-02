         

                          <!--begin::Wizard Form-->
                              <div class="row">
                                <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Code</label>
                                    <input type="text" class="form-control form-control-solid" name="code" value="{{ (isset($data->code))? $data->code:'' }}" required="">
                                  
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div>
                                <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Discount</label>
                                    <input type="text" class="form-control form-control-solid" name="discount" value="{{ (isset($data->discount))? $data->discount:'' }}" required="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                                </div> 

                                <div class="col-xl-2">
                                   <label>Discount Type</label>
                                    <div class="dropdown bootstrap-select form-control dropup">
                                        <select name="discount_type" class="form-control selectpicker" required="">
                                            <option class="bs-title-option"></option>
                                            @if(count($discountType) > 0) 
                                              @foreach($discountType as $key=>$val)
                                                @if(isset($data->discount_type)) 
                                                  @if($key == $data->discount_type)
                                                  <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                  @else
                                                  <option value="{{ $key }}">{{ $val }}</option>
                                                  @endif 
                        @elseif($val == 'Percent')
                        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                        @else
                       
                                                <option value="{{ $key }}">{{ $val }}</option>
                                                @endif
                                              @endforeach
                                             @endif
                                        </select>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                             </div>
                                
                                <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Min order (optional)</label>
                                    <input type="text" class="form-control form-control-solid" name="minimum_order" value="{{ (isset($data->minimum_order))? $data->minimum_order:'0' }}" required="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                                </div> 

                                <div class="col-xl-4">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Description</label>
                                    <input type="text" class="form-control form-control-solid" name="description" value="{{ (isset($data->description))? $data->description:'' }}">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                               </div>

                         
                              </div>

                  <!-- Section 2 -->



                      <div class="row">    
                          <div class="col-xl-2">
                                   <label>Time of use</label>
                                    <div class="dropdown bootstrap-select form-control dropup">
                                        <select name="single_use" class="form-control selectpicker" required="">
                                            <option class="bs-title-option"></option>
                                            @if(count($singleuse) > 0) 
                                              @foreach($singleuse as $key=>$val)
                                                @if(isset($data->single_use)) 
                                                  @if($key == $data->single_use)
                                                  <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                  @else
                                                  <option value="{{ $key }}">{{ $val }}</option>
                                                  @endif 
                        @elseif($val == 'Multiple use')
                        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                        @else
                                                <option value="{{ $key }}">{{ $val }}</option>
                                                @endif
                                              @endforeach
                                             @endif
                                        </select>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                             </div>
                         <!--end: Code-->
                         <div class="col-xl-3">
                                  <!--begin::Input-->
                                    <label>Expires at</label>
                        <div class="input-group date" id="kt_datetimepicker_1" data-target-input="nearest">
                            

                            <input type="text" class="form-control datetimepicker-input" name="expires_at" placeholder="Select date &amp; time" data-target="#kt_datetimepicker_1" value="{{ (isset($data->expires_at))? date('m/d/yy h:i A', strtotime($data->expires_at)):'' }}"/>


                            <div class="input-group-append" data-target="#kt_datetimepicker_1" data-toggle="datetimepicker">
                              <span class="input-group-text">
                                <i class="ki ki-calendar"></i>
                              </span>
                            </div>
                          </div>
                         <div class="fv-plugins-message-container"></div>
                           <!--end::Input-->
                        </div>

                           <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                          <label>Client  (optional) <i class="icon-x far fa-trash-alt text-primary" id="empty_client" style="cursor: pointer;"></i></label>
                                            
                          <select class="form-control select2" id="client" name="user_id" data-select2-id="client" aria-hidden="true">
                            <option class="bs-title-option"></option>
                                     @if(count($users) > 0) 
                                              @foreach($users as $key=>$val)
                                                @if(isset($data->user_id)) 
                                                  @if($key == $data->user_id)
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
                     <!--end::Input-->
                   </div>
              
                      <div class="col-xl-3">
                        <!--begin::Input-->
                             <div class="form-group fv-plugins-icon-container">
                                <label>Restaurant  (optional) <i class="icon-x far fa-trash-alt text-primary" id="empty_restaurant" style="cursor: pointer;"></i></label>
                                <select class="form-control select2" id="restaurant" name="restaurant_id" data-select2-id="restaurant" tabindex="-1" aria-hidden="true">
                            <option></option>
                                   @if(count($restaurants) > 0) 
                                              @foreach($restaurants as $key=>$val)
                                                @if(isset($data->restaurant_id)) 
                                                  @if($key == $data->restaurant_id)
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
                                  <!--end::Input-->
                               </div>




              <div class="col-xl-2">
                                   <label>Active?</label>
                                    <div class="dropdown bootstrap-select form-control dropup">
                                        <select name="enabled" class="form-control selectpicker" required="">
                                            <option class="bs-title-option" value=""></option>
                                            @if(count($status) > 0) 
                                              @foreach($status as $key=>$val)
                                                @if(isset($data->enabled)) 
                                                  @if($key == $data->enabled)
                                                  <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                  @else
                                                  <option value="{{ $key }}">{{ $val }}</option>
                                                  @endif 
                                                @elseif($val == 'Yes')
                        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
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
