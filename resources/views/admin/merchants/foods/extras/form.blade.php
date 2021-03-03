                   <div class="row">
                                <div class="col-xl-6">
                        @livewire('constant.menu', ['model' => 'ExtraGroup', 'name'=>'extra_group_id', 'text'=>'Extra Group', 'selectedValue'=> (isset($data->extra_group_id))? $data->extra_group_id:''], key(5))
                                  </div>
                              
                               @if(count($sizes) > 0) 
                        
                              @endif
              

                         <div class="col-xl-3">
                          <div class="form-group">
                            <label>Required to select a choice or choices?</label>
                            <div class="radio-inline">
                              <label class="radio">
                              <input type="radio" name="selection_type" value="r">
                              <span></span>One Choice</label>
                              <label class="radio">
                              <input type="radio" checked="checked" name="selection_type" value="c">
                              <span></span>Multi Choices</label>
                            </div>
                          </div>
                       </div>
                     </div>
                                        <span id="result"></span>
           
                    <div class="row" id="vary_sizes">

                  <table id="dynamicTable" class="table table-bordered">  
                    
               <input type="hidden" name="food_id" value="{{$food->id}}"> 
             @if (\Request::is('*/create_vary_price_extra/*'))

                @if(count($sizes) > 0)
                

                <input type="hidden" id="is_vary_price" value="1"> 

                    <tr>
                      <th style="font-size: 14px">Name</th>
                      @foreach($sizes as $key => $size)
                        <th style="font-size: 14px">{{$size->name}}</th>
                      @endforeach
                  </tr>

                  <tr>
                    @include('admin.merchants.foods.extras.vary_price_sizes')
<div class="row">
  <button type="button" id="add_more" class="btn btn-primary btn-sm float_right"> 
    <i class="fa fa-plus icon-sm "></i>Add another
 </button>
</div>                     
                    </tr>

                   @endif
             @else
                <input type="hidden" id="is_vary_price" value="0"> 

                            <tr>
                <th  style="font-size: 14px">Name</th>
                <th  style="font-size: 14px">Upcharge</th>
            </tr>
            <tr> 
              @include('admin.merchants.foods.extras.not_vary_price_sizes')
              <div class="row">
                <button type="button" id="add_more" class="btn btn-primary btn-sm float_right"> 
                  <i class="fa fa-plus icon-sm "></i>Add another
               </button>
              </div>

            </tr>

            @endif
                


                </table> 
 
                    </div>

                  <!-- Section 2 -->

          
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                      

                          @if (\Request::is('*/edit'))
                                <button type="button" id="EditFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Save Change</button>
                          @else
                          <button type="button" id="CreateFormButton" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Submit</button>
                          @endif      


                            </div>
                          <!--end::Wizard Form-->

    {{ csrf_field() }}



<!-- End form -->
