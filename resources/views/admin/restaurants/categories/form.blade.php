     
                              <div class="col-xl-12">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Category name</label>
                                    
                                    <input type="text" class="form-control form-control-solid" name="name" value="{{ (isset($data->name))? $data->name:'' }}">
                                    
                                     <div class="fv-plugins-message-container"></div>
                                </div>
                              </div>



    {{ csrf_field() }}



<!-- End form -->
