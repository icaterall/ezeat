     
                              <div class="row">
                                <div class="col-xl-8">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Extra name</label>
                                    
                                    <input type="text" class="form-control form-control-solid" name="name" id="extra_name" value="{{ (isset($extra->name))? $extra->name:'' }}">
                                    
                                     <div class="fv-plugins-message-container"></div>
                                </div>
                              </div>

                                <div class="col-xl-4">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Price</label>
                                    
                                    <input type="text" class="form-control form-control-solid" name="restaurant_price" id="restaurant_price" value="{{ (isset($extra->restaurant_price))? $extra->restaurant_price:'' }}">
                                       <input type="hidden" name="food_id" id="food_id" value=" {{ $extra->food_id}}">  
                                     <div class="fv-plugins-message-container"></div>
                                    <input type="hidden" name="is_size" id="is_size" value="0"> 

                                </div>
                              </div>
                          </div>



    {{ csrf_field() }}



<!-- End form -->
