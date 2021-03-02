<style type="text/css">
  .icon_down{
    margin-top: 35px;
  }
</style>

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
    

<div class="d-flex justify-content-between border-top mt-5 pt-10">
    @if (\Request::is('*/edit'))
    <button type="button" id="EditFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Save Change</button>
       @else
       <button type="button" id="CreateFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Submit</button>
    @endif
 
@if (\Request::is('*/edit'))
 <a target="_blank" href="/restaurant/{{$data->id}}/{{$data->name}}">
<button type="button" id="view" class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4">View</button></a>
 @endif

  </div>

                                 <!--begin::Wizard Form-->
                              <div class="row">


                               <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Name</label>
                                    <input type="text" class="form-control form-control-solid" id="name" name="name" value="{{ (isset($data->name))? $data->name:'' }}">
                                  
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div>
                    <input id="locality" hidden="">
                    <input id="administrative_area_level_1" hidden="">
                    <input id="postal_code" hidden="">

                    <div class="col-xl-4">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Address</label>
                                    <input type="text" class="form-control form-control-solid" id="autocomplete" name="address" value="{{ (isset($data->address))? $data->address:'' }}" onClick="this.select();" onFocus="geolocate()">
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div>                              


                                <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Latitude</label>
                                    <input type="text" class="form-control form-control-solid" name="latitude" id="latitude" value="{{ (isset($data->latitude))? $data->latitude:'' }}" required="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                                </div>
                             
                             <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Longitude</label>
                                    <input type="text" class="form-control form-control-solid" name="longitude" id="longitude" value="{{ (isset($data->longitude))? $data->longitude:'' }}" required="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                                </div>
                            </div>

  

<div class="row">
    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Phone <span style="font-weight: 400">(optional)</span></label>
            <input type="text" class="form-control form-control-solid" name="phone" id="phone" value="{{ (isset($data->phone))? $data->phone:'' }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    @if (!\Request::is('new_restaurant/*'))
    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Mobile</label>
            <input type="text" class="form-control form-control-solid" name="mobile" id="mobile" value="{{ (isset($data->mobile))? $data->mobile:'' }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-3">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Email</label>
            <input type="text" class="form-control form-control-solid" name="email" id="email" value="{{ (isset($data->email))? $data->email:'' }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>
    @else

    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Mobile</label>
            <input type="text" class="form-control form-control-solid" name="mobile" id="mobile" value="{{ (isset($data->mobile))? $data->mobile:Auth::user()->mobile }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-3">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Email</label>
            <input type="text" class="form-control form-control-solid" name="email" id="email" value="{{ (isset($data->email))? $data->email:Auth::user()->email }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    @endif

    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Cooking Time</label>
            <input type="text" class="form-control form-control-solid" name="preparing_time" id="preparing_time" value="{{ (isset($data->preparing_time))? $data->preparing_time:20 }}" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Min order</label>
            <input type="text" class="form-control form-control-solid" name="min_order" id="min_order" value="{{ (isset($data->min_order))? $data->min_order:0 }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

</div>


<!-- --------------------Section 3--------------------- -->
<div class="row">
                      <div class="col-xl-3">
                        @livewire('constant.cuisine', ['model' => 'Cuisine', 'name'=>'cuisines[]','selectedValue'=> (isset($RestaurantCuisine))? $RestaurantCuisine:[]], key(5))
                      </div>
    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Account number<span style="font-weight: 400">(optional)</span></label>
            <input type="text" class="form-control form-control-solid" name="bank_account" id="bank_account" value="{{ (isset($data->bank_account))? $data->bank_account:'' }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-3">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Beneficiary Name<span style="font-weight: 400">(optional)</span></label>
            <input type="text" class="form-control form-control-solid" name="bank_owner" id="bank_owner" value="{{ (isset($data->bank_owner))? $data->bank_owner:'' }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>
    <div class="col-xl-3">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Bank name<span style="font-weight: 400">(optional)</span></label>
            <input type="text" class="form-control form-control-solid" name="bank_name" id="bank_name" value="{{ (isset($data->bank_name))? $data->bank_name:'' }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    @if (!\Request::is('new_restaurant/*'))
    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Active</label>

            <select class="form-control select2" id="option" name="active" data-select2-id="option" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->active)) 
                @if($key == $data->active)
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
    @endif

</div>

@can('editor_privilege')
<div class="row">
    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Food adjust %</label>
            <input type="text" class="form-control form-control-solid" name="admin_commission" value="{{ (isset($data->admin_commission))? $data->admin_commission:18 }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Delivery fee</label>
            <input type="text" class="form-control form-control-solid" name="delivery_fee" id="delivery_fee" value="{{ (isset($data->delivery_fee))? $data->delivery_fee:3.99 }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-1">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Range</label>
            <input type="text" class="form-control form-control-solid" name="delivery_range" id="delivery_range" value="{{ (isset($data->delivery_range))? $data->delivery_range:5 }}" required="" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-1">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Tax </label>
            <input type="text" class="form-control form-control-solid" name="default_tax" id="default_tax" value="{{ (isset($data->default_tax))? $data->default_tax:0 }}" />
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>

    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Free Delivery</label>

            <select class="form-control select2" id="option2" name="free_delivery" data-select2-id="option2" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->free_delivery)) 
                @if($key == $data->free_delivery)
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
        <!--end::Input-->
    </div>

    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Accept Cash</label>

            <select class="form-control select2" id="option3" name="accept_cash" data-select2-id="option3" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->accept_cash)) 
                @if($key == $data->accept_cash)
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
        <!--end::Input-->
    </div>

    <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Self Rider</label>

            <select class="form-control select2" id="option4" name="has_riders" data-select2-id="option4" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->has_riders)) 
                @if($key == $data->has_riders)
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
        <!--end::Input-->
    </div>


</div>


<div class="row">

    <div class="col-xl-3">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Available fo Delivery</label>

            <select class="form-control select2" id="option5" name="available_for_delivery" data-select2-id="option5" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->available_for_delivery)) 
                @if($key == $data->available_for_delivery)
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
        <!--end::Input-->
    </div>



    <div class="col-xl-3">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Available fo Pickup</label>

            <select class="form-control select2" id="option6" name="available_for_pickup" data-select2-id="option6" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->available_for_pickup)) 
                @if($key == $data->available_for_pickup)
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


    <div class="col-xl-3">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Featured</label>

            <select class="form-control select2" id="option7" name="featured" data-select2-id="option7" tabindex="-1" aria-hidden="true">
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
        <!--end::Input-->
    </div>

        <div class="col-xl-2">
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label class="label_class">Food Truck?</label>

            <select class="form-control select2" id="client" name="food_truck" data-select2-id="client" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->food_truck)) 
                @if($key == $data->food_truck)
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
        <!--end::Input-->
    </div>
</div>

@endcan
<div class="row">
          
          <!------------------------------- Photo ------------------------>
                    <!-- Restaurant Logo -->    

<!--                         <div class="col-xl-3">
                          <label class="label_class">Restaurant Logo <span style="font-weight: 400">(optional)</span></label>
                          <div class="form-group fv-plugins-icon-container">
                         <span id="loading" style="display: none;">                   
                      <img src="/adminfiles/assets/media/loading.svg" style="width: 50px">
                    </span>
                <div class="image-input image-input-outline" id="kt_image_1">
                      <div id="view_logo" class="image-input-wrapper" style="height: 200px;
    width: 250px;background-image: url(
                             @if(isset($data)) 
                                   @if( $data->logo == null)
                                     /uploads/noimage.png
                                   @else
                                     /uploads/storelogo/{{$data->logo}}
                                   @endif
                              @else 
                                 /uploads/noimage.png
                              @endif

                               );">
                            </div>
                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                              <i class="fa fa-pen icon-sm text-muted"></i>
                              <input type="file" id="upload_logo_image" name="profile_avatar" accept=".png, .jpg, .jpeg">
                              <input type="hidden" name="profile_avatar_remove" value="0">
                             
                              <input type="hidden" id="orginal_logo_image" value="{{ (isset($data->logo))? $data->logo:'' }}" >

                              <input type="hidden" class="form-control form-control-solid"  id="logo_image" name="logo" >
                            </label>
                            <span class="logo_remove btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
                              <i class="ki ki-bold-close icon-xs text-muted"></i>
                            </span>
                          </div>
                          <span class="form-text text-muted">Allowed file types: png, jpg.</span>
                      <div class="fv-plugins-message-container"></div>
                      </div>
                    </div>

 -->

            <!-- Restaurant banner --> 
                   <div class="col-xl-6">                         
                    <label class="label_class"> Restaurant Banner </label>

                        <div class="form-group fv-plugins-icon-container"> 
                    <span id="loading" style="display: none;">                   
                      <img src="/adminfiles/assets/media/loading.svg" style="width: 50px">
                    </span>



                          <div class="image-input image-input-outline" id="kt_image_2">
                              <div id="view_image" class="image-input-wrapper" style="height: 190px;
    width: 350px;background-image: url(
                             @if(isset($data)) 
                                   @if( $data->banner == null)
                                     /uploads/noimage.png
                                   @else
                                     /uploads/storeimage/{{$data->banner}}
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
                              <input type="hidden" id="item_image" name="banner" >
                              <input type="hidden" id="orginal_item_image" value="{{ (isset($data->banner))? $data->banner:'' }}" >
                            </label>
                            <span class="profile_remove btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
                              <i class="ki ki-bold-close icon-xs text-muted"></i>
                            </span>
                          </div>
                          <span class="form-text text-muted">Allowed file types: png, jpg.</span>
                      </div>
                    </div>
                  
<!--              <div class="col-lg-8">
              <label class="label_class">Restaurant information</label>  
               <div class="card card-custom gutter-b example example-compact">
                       
                  <textarea class="form-control" id="information" name="information">
                    {{ (isset($data->information))? $data->information:'' }}
                  </textarea>

                    
                  </div>
              </div> -->

                  </div>






                    <!--end::Sections-->

    {{ csrf_field() }}


<!-- End form -->
