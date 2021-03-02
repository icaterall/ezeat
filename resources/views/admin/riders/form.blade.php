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
                                    <label class="label_class">Mobile</label>
                                    <input type="text" class="form-control form-control-solid" id="mobile" name="mobile" value="{{ (isset($data->mobile))? $data->mobile:'' }}" required="">
                                  
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div>
      
                      <div class="col-xl-2">
                        <!--begin::Input-->
                             <div class="form-group fv-plugins-icon-container">
                                <label class="label_class">Stages</label>
                                <select class="form-control select2" id="restaurant" name="stage" data-select2-id="restaurant" tabindex="-1" aria-hidden="true">
                                   @if(count($stages) > 0) 
                                              @foreach($stages as $key=>$val)
                                                @if(isset($profile->stage)) 
                                                  @if($val->stage == $profile->stage)
                                                  <option value="{{ $val->stage }}" selected="selected">{{ $val->stage }} = {{ $val->amount }} MYR</option>
                                                  @else
                                                  <option value="{{ $val->stage }}">{{ $val->stage }} = {{ $val->amount }} MYR</option>
                                                  @endif 
                                                @else
                                                <option value="{{ $val->stage }}">{{ $val->stage }} = {{ $val->amount }} MYR</option>
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
            <label class="label_class">Is Approved </label>

            <select class="form-control select2" id="option3" name="is_approved" data-select2-id="option3" tabindex="-1" aria-hidden="true">
                <option class="bs-title-option"></option>
                @if(count($status) > 0) 
                @foreach($status as $key=>$val) 
                @if(isset($data->is_approved)) 
                @if($key == $data->is_approved)
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
                       <div class="col-xl-2">
                                
                                <button type="button" id="EditFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Save Change</button>
                    

                    </div>
                  <!-- Section 2 -->

   <div class="row"> 
                          <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Bank Name</label>
                                    <input type="text" class="form-control form-control-solid" id="bank_name" name="bank_name" value="{{ (isset($profile->bank_name))? $profile->bank_name:'' }}" disabled>
                                  
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div>

                    <div class="col-xl-3">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Account Number</label>
                                    <input type="text" class="form-control form-control-solid" id="account_number" name="account_number" value="{{ (isset($profile->account_number))? $profile->account_number:'' }}" disabled>
                                  
                                  <div class="fv-plugins-message-container">
                                    
                                  </div>
                                </div>
                                  <!--end::Input-->
                                </div> 
                        </div>        


             <div class="row">                                
          <!------------------------------- Photo ------------------------>
             
                   <div class="col-xl-2">
                         <label class="label_class">Rider photo </label>                            
                 
                    <span id="loading" style="display: none;">                   
                      <img src="/adminfiles/assets/media/loading.svg" style="width: 50px">
                    </span>



                          <div class="image-input image-input-outline" id="kt_image_1">
                              <div id="view_image" class="image-input-wrapper" style="height: 290px;
    width: 350px;background-image: url(
                             @if(isset($data)) 
                                   @if( $profile->photo == null)
                                     /uploads/noimage.png
                                   @else
                                     https://riderapi.spoongate.com/storage/{{$profile->photo}}
                                   @endif
                              @else 
                                 /uploads/noimage.png
                              @endif

                               );">
                            </div>
                          </div>
                          
                      </div>
 
            
       
            <div class="col-xl-2"  style="width: 500px; height: 350px;margin-left: 250px;">
                <label class="label_class">Rider Location </label>  
<div id="map" style="width: 500px; height: 350px;">
</div>
</div>


                    </div> 


@if($data->location->first() != null)
<input  id="lat" value="{{$data->location->first()->lat}}" hidden="">
<input  id="long" value="{{$data->location->first()->long}}" hidden="">

@else

<input  id="lat" value="2.842719" hidden="">
<input  id="long" value="101.797027" hidden="">

@endif



@push('script')
   <script type="text/javascript">
    $( document ).ready(function() {

    var lat = $('#lat').val();
    var long = $('#long').val();  
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18,
        center: new google.maps.LatLng(lat, long),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker;

   
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, long),
            map: map
        });
    
  });
</script>  
@endpush   
                    <!--end::Sections-->
                      
    {{ csrf_field() }}


<!-- End form -->
