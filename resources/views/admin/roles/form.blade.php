     
                              <div class="col-xl-12">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label>Role name</label>
                                    
                                    <input type="text" class="form-control form-control-solid" name="name" value="{{ (isset($roles->name))? $roles->name:'' }}">
                                    
                                     <div class="fv-plugins-message-container"></div>
                                </div>
                              </div>

                            <input type="text" name="guard_name" value="web" hidden="">
                            <input type="text" name="default" value="0" hidden="">

                            <div class="col-xl-12">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                          <label>Permissions</label>
                                            <select class="form-control selectpicker"  name="permission[]" id="permission" multiple="multiple">
                                                            
                           @if(isset($permissions))
                                @if(count($permissions) > 0)                    
                                  @foreach($permissions as $key=>$val)        
                                    @if(isset($permissionRole))           
                                        @if(count($permissionRole) > 0)
                                             <?php $found = 0; ?>
                                                @foreach($permissionRole as $permissionkey=>$permissionkey)
                                                   @if($permissionkey == $key)
                                                     <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                                      <?php $found++; break; ?>
                                                   @endif
                                                @endforeach
                                              @if($found == 0)
                                               <option value="{{ $key }}">{{ $val }}</option>
                                              @endif
                                          @else <!-- if count $permissionRole == 0 -->
                                          <option value="{{ $key }}">{{ $val }}</option>
                                        @endif
                                    @else <!-- if Not isset $permissionRole-->   
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

    {{ csrf_field() }}



<!-- End form -->
