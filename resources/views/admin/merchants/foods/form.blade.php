<style type="text/css">
  .icon_down{
    margin-top: 35px;
  }
</style>
                          <!--begin::Wizard Form-->
                              <div class="row">
                               <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Name</label>
                                    <input type="text" class="form-control form-control-solid" id="name" name="name" value="{{ (isset($data->name))? $data->name:'' }}" required="">
                                  
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div>
     
      
                      <div class="col-xl-3">
                        <!--begin::Input-->
                             <div class="form-group fv-plugins-icon-container">
                                <label class="label_class">Restaurant</label>
                                <select class="form-control select2" id="restaurant" name="restaurant_id" data-select2-id="restaurant" tabindex="-1" aria-hidden="true">
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
                                 
                      <div class="col-xl-3">
                        @livewire('constant.menu', ['model' => 'Category', 'name'=>'category_id', 'text'=>'Food Category ', 'selectedValue'=> (isset($data->category_id))? $data->category_id:''], key(5))
                      </div>

                                
                    <div class="col-xl-2">
                                  <!--begin::Input-->
                   <div class="form-group fv-plugins-icon-container">
                      <label class="label_class">Price</label>
                         <input type="text" class="form-control form-control-solid" name="restaurant_price" id="price" value="{{ (isset($data->restaurant_price))? $data->restaurant_price:'' }}" required="">
                         <div class="fv-plugins-message-container"></div>
                      </div>
                                  <!--end::Input-->
                  </div>   
                           

                   <div class="col-xl-1">
                                  <!--begin::Input-->
                   <div class="form-group fv-plugins-icon-container">
                      <label class="label_class foodpanda" style="color:green"></label>
                         <input type="text" class="form-control form-control-solid" id="foodpanda" value="">
                         <div class="fv-plugins-message-container"></div>
                      </div>
                                  <!--end::Input-->
                  </div>  


                            </div>

                  <!-- Section 2 -->

                      <div class="row"> 

                      <div class="col-xl-2">
                                   <label class="label_class">Featured</label>
                                    <div class="dropdown bootstrap-select form-control dropup">
                                        <select name="featured" class="form-control selectpicker" required="">
                                            <option class="bs-title-option"></option>
                                            @if(count($status) > 0) 
                                              @foreach($status as $key=>$val)
                                                @if(isset($data->featured)) 
                                                  @if($key == $data->featured)
                                                  <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                  @else
                                                  <option value="{{ $key }}">{{ $val }}</option>
                                                  @endif 
                                                @else
                                                
                    @if($val == 'No')
                        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                        @else
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endif
                                                
                                                @endif
                                              @endforeach
                                             @endif
                                        </select>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                             </div>

                       <div class="col-xl-3">
                                  <!--begin::Input-->
                         <div class="form-group fv-plugins-icon-container">
                          <label class="label_class">When is this item available?</label>                 
                          <select class="form-control select2" id="option2" name="times" data-select2-id="option2" tabindex="-1" aria-hidden="true">
                            <option class="bs-title-option"></option>
                @if(isset($times))
                   @if(count($times) > 0)                    
                    @foreach($times as $key=>$val)        
                        @if(isset($foodTime))           
                            @if(count($foodTime) > 0)
                                 <?php $found = 0; ?>
                                    @foreach($foodTime as $timekey=>$timekey)
                                       @if($timekey == $key)
                                         <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                          <?php $found++; break; ?>
                                       @endif
                                    @endforeach
                                  @if($found == 0)
                                   <option value="{{ $key }}">{{ $val }}</option>
                                  @endif
                              @else <!-- if count $foodTime == 0 -->
                              <option value="{{ $key }}">{{ $val }}</option>
                            @endif
                        @else <!-- if Not isset $foodTime-->   
                      
                    @if($val == 'Any Time')
                        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                        @else
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endif
                      
                      @endif 
                    @endforeach
                    @endif
                @endif
                       </select>
                       <div class="fv-plugins-message-container"></div>
                     </div>
                     <!--end::Input-->
                   </div>


                       <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                          <label class="label_class">Deliverable</label>
                                            
                          <select class="form-control select2" id="option" name="deliverable" data-select2-id="option" tabindex="-1" aria-hidden="true">
                            <option class="bs-title-option"></option>
                                     @if(count($status) > 0) 
                                              @foreach($status as $key=>$val)
                                                @if(isset($data->deliverable)) 
                                                  @if($key == $data->deliverable)
                                                  <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                  @else
                                                  <option value="{{ $key }}">{{ $val }}</option>
                                                  @endif 
                                                @else
                    @if($val == 'Yes')
                        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                        @else
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endif
                                                @endif
                                              @endforeach
                                    @endif
                       </select>
                       <div class="fv-plugins-message-container"></div>
                     </div>
                     <!--end::Input-->
                   </div>

<!-- ------------------------ -->
             

             
             <div class="col-lg-8">
              <label class="label_class">Food description</label>  
               <div class="card card-custom gutter-b example example-compact">
                       
                  <textarea class="form-control" id="descriptionr" name="description">
                    {{ (isset($data->description))? $data->description:'' }}
                  </textarea>

                    
                  </div>
              </div>

                 
          <!------------------------------- Photo ------------------------>
             
                   <div class="col-xl-4">
                         <label class="label_class">Food picture <span style="color: red"> Note! picture over 300 KB will not be uploaded</span> </label>                            
                 
                    <span id="loading" style="display: none;">                   
                      <img src="/adminfiles/assets/media/loading.svg" style="width: 50px">
                    </span>



                          <div class="image-input image-input-outline" id="kt_image_1">
                              <div id="view_image" class="image-input-wrapper" style="height: 290px;
    width: 350px;background-image: url(
                             @if(isset($data)) 
                                   @if( $data->image == null)
                                     /uploads/noimage.png
                                   @else
                                     /uploads/productimages/{{$data->image}}
                                   @endif
                              @else 
                                 /uploads/noimage.png
                              @endif

                               );">
                            </div>
                 

                
                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                              <i class="fa fa-pen icon-sm text-muted"></i>
                              <input type="file" id="upload_item_image" name="profile_avatar" accept=".png, .jpg, .jpeg">
                              <input type="hidden" name="profile_avatar_remove" value="0">
                              <input type="hidden" id="item_image" name="image" >
                              <input type="hidden" id="orginal_item_image" value="{{ (isset($data->image))? $data->image:'' }}" >
                            </label>
                            <span class="profile_remove btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
                              <i class="ki ki-bold-close icon-xs text-muted"></i>
                            </span>
                          </div>
                          <span class="form-text text-muted">Allowed file types: png, jpg. - 400×300 pixels</span>
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
    {{ csrf_field() }}


 @if (\Request::is('*/edit'))
                       @include('merchants.foods.sizes.archive') 
                       @include('merchants.foods.extras.archive')                       
@endif

