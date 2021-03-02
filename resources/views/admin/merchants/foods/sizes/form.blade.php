     
                              <div class="row">
                              	<div class="col-xl-8">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Size name</label>
                                    
                                    <input type="text" class="form-control form-control-solid" name="name" id="size_name" value="{{ (isset($size->name))? $size->name:'' }}">
                                    
                                     <div class="fv-plugins-message-container"></div>
                                </div>
                              </div>

                                <div class="col-xl-4">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Price</label>
                                    
                                    <input type="text" class="form-control form-control-solid" name="restaurant_price" id="restaurant_price" value="{{ (isset($size->restaurant_price))? $size->restaurant_price:'' }}">
                                    
                                    @if (Route::current()->getName() == ('manager.sizes.edit'))
                                      <input type="hidden" name="food_id" id="food_id" value=" {{ (isset($size->food_id))? $size->food_id:'' }}">
                                      @else

                                      <input type="hidden" name="food_id" id="food_id" value=" {{ $data->id}}">

                                      @endif


                                     <div class="fv-plugins-message-container"></div>
                                </div>
                              </div>
                          </div>



    {{ csrf_field() }}



<!-- End form -->
