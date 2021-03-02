     
                              <div class="row">
                                <div class="col-xl-10">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Extra name</label>
                                    
                                    <input type="text" class="form-control form-control-solid" name="name" id="extra_name" value="{{ (isset($extra->name))? $extra->name:'' }}">
                                    
                                     <div class="fv-plugins-message-container"></div>
                                </div>
                              </div>
                          </div>
                       <div class="row">
                                  <!--begin::Input-->
                              @foreach($sizes as $key => $size)  
                            <div class="col-xl-3">
                                <div class="form-group fv-plugins-icon-container">            
                                  <label>{{$size->variation->name}}</label>
                              <td><input type="text" class="form-control form-control-solid price_input"  name="restaurant_price[{{$size->id}}]" value="{{ (isset($size->restaurant_price))? $size->restaurant_price:'' }}"></td> 
                                     <div class="fv-plugins-message-container"></div>
                                </div>
                              </div>
                              @endforeach
                               </div>
                             
                          <input type="hidden" name="food_id" id="food_id" value=" {{ $extra->food_id}}"> 
                          <input type="hidden" name="is_size" id="is_size" value="1"> 

                          </div>



    {{ csrf_field() }}



<!-- End form -->
