<style type="text/css">
  .icon_down{
    margin-top: 35px;
  }
</style>


   <div class="row">
                   <div class="col-xl-2">
                    <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Method</label>
                                    <input type="text" class="form-control form-control-solid" name="method" id="method" value="{{ (isset($data->method))? $data->method:'Online banking' }}" required="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                                </div>
                             
                             <div class="col-xl-2">
                                  <!--begin::Input-->
                                  <div class="form-group fv-plugins-icon-container">
                                    <label class="label_class">Amount</label>
                                    <input type="text" class="form-control form-control-solid" name="amount" id="amount" value="{{ (isset($data->amount))? $data->amount:'' }}" readonly="">
                                  <div class="fv-plugins-message-container"></div>
                                </div>
                                  <!--end::Input-->
                                </div>

                           <!--end: Code-->
                         <div class="col-xl-3">
                                  <!--begin::Input-->
                                    <label>Paid Date</label>
                        <div class="input-group date" id="kt_datetimepicker_1" data-target-input="nearest">
                            

                            <input type="text" class="form-control datetimepicker-input" name="paid_date" placeholder="Select date &amp; time" data-target="#kt_datetimepicker_1" value="{{ (isset($data->paid_date))? date('m/d/yy h:i A', strtotime($data->paid_date)):Carbon\Carbon::now()->format('m/d/yy h:i A') }}"/>


                            <div class="input-group-append" data-target="#kt_datetimepicker_1" data-toggle="datetimepicker">
                              <span class="input-group-text">
                                <i class="ki ki-calendar"></i>
                              </span>
                            </div>
                          </div>
                         <div class="fv-plugins-message-container"></div>
                           <!--end::Input-->
                        </div>
             <div class="col-lg-4">
                <label class="label_class">Payment note</label>  
                  <div class="card card-custom gutter-b example example-compact">
                  <textarea class="form-control" id="note" name="note">{{ (isset($data->note))? $data->note:'' }}</textarea>                    
                  </div>
              </div>
            <input type="text" name="rider_id"  value="{{$rider->id}}" hidden="">
            <input type="text" name="checkid" id="checkid" hidden="">

       </div>

      <div class="d-flex justify-content-between border-top mt-5 pt-10">
             <button type="button" class="CreateFormButton btn btn-success font-weight-bolder text-uppercase px-9 py-4">Submit</button>

        </div>
 @include('admin.finance.riders.orders.datatable') 

      <div class="d-flex justify-content-between border-top mt-5 pt-10">
             <button type="button" class="CreateFormButton btn btn-success font-weight-bolder text-uppercase px-9 py-4">Submit</button>

        </div>
                    <!--end::Sections-->

    {{ csrf_field() }}


<!-- End form -->
