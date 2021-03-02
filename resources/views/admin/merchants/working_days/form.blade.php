        
              <div id="kt_repeater_1">
                        


                        <div class="form-group row">
                         
                          <div data-repeater-list="" class="col-lg-10">

                            <div data-repeater-item="" class="form-group row align-items-center">
                          


                             <div class="col-md-3">
                                <label>Day</label>
                                <div class="d-md-none mb-2"></div>
                              </div>
                              <div class="col-md-3">
                                <label>Open at</label>
                                <div class="d-md-none mb-2"></div>
                              </div>
                              <div class="col-md-3">
                                <label>Close at</label>
                                <div class="d-md-none mb-2"></div>
                              </div>
                              <div class="col-md-2">
                                <label>Available</label>
                                <div class="radio-inline">
                                  
                                </div>
                              </div>


             @foreach($data as $key => $value)

                             <div class="col-md-3">
                                <label></label>
                                <input type="text" class="form-control form-control-solid" value="{{$value->day_name}}" readonly="">

                                <input name="day_id[{{$value->day_id}}]" value="{{$value->day_id}}" hidden="">


                                <div class="d-md-none mb-2"></div>
                              </div>
                              <div class="col-md-3">
                                <label></label>
                                <input class="form-control" name="open_time[{{$value->day_id}}]" id="kt_timepicker_1" readonly="readonly" type="text" value="{{$value->open_time}}">

                                <div class="d-md-none mb-2"></div>
                              </div>
                              <div class="col-md-3">
                                <label></label>
                                <input class="form-control" id="kt_timepicker_1" name="close_time[{{$value->day_id}}]" readonly="readonly" type="text" value="{{$value->close_time}}">
                                <div class="d-md-none mb-2"></div>
                              </div>
                              <div class="col-md-2">
                                <label></label>
                                <div class="radio-inline">
                                  <label class="checkbox checkbox-success">
                                  <input type="checkbox" name="available[{{$value->day_id}}]" {{  ($value->available == 1 ? ' checked' : '') }}>
                                  <span></span></label>
                                </div>
                              </div>

                   @endforeach



                            </div>
                         
                          </div>
                        </div>
                        
                      </div>

                    <!--end::Sections-->
                        <div class="d-flex justify-content-between border-top mt-5 pt-10">                                
                                <button type="button" id="EditFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Save Change</button>

                        </div>
    {{ csrf_field() }}


<!-- End form -->
