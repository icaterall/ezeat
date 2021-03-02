
<!-- begin: Invoice footer-->
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
      <div class="col-md-9">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="pl-0 font-weight-bold text-muted text-uppercase">Description</th>
                <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Price</th>
              </tr>
            </thead>
                  <tbody>
                  
                  @foreach($order->foodOrders as $foods)
                    <tr class="font-weight-boldest font-size-lg">
                       <td class="pl-0 pt-7">
                            {{ $foods->food->name }} 

                               @ MYR {{number_format($foods->food_price_restaurant,2)}}
                                
                                    @if($foods->food_size != null)
                                     <div class="font-weight-bold">
                                       <span class="label label-lg label-light-danger order_size">&nbsp;Size</span>&nbsp;<span style="color:#7305c6">{{$foods->food_size}}</span>
                                      </div>
                                    @endif 


                    @foreach($foods->extraOrder->groupBy('extra_group_id') as $extra_group)
                    <div class="font-weight-bold order_extra">
                        <span class="extra_title">{{$extra_group->first()->extraGroup->name}}: </span>
                              <?php $count = 0; ?>
                                   @php 
                                    $count = 0; 
                                    $arr = []; 
                                        foreach($extra_group as $key => $extra) 
                                            { 
                                        if($extra->restaurant_price != 0)      
                                        
                                        {$arr[] = $extra->extras->name.'-- MYR '.number_format($extra->restaurant_price,2);
                                      }else 

                                        $arr[] = $extra->extras->name;
                                         $count++; 
                                                
                                            } 
                                            $get_extra_name = implode(' ,' ,$arr);
                                         @endphp
                                    {{ $get_extra_name}}
                                  </div>
                                @endforeach 
                      


                         @if(!empty($foods->food_instruction))
                          <div class="font-weight-bold"><span class="special_inst"> Special instructions: </span>{{$foods->food_instruction}}</div>
                        @endif
                      </td>
                              <td class="text-danger pr-0 pt-5 text-center">
                                {{ $foods->quantity }}</td>

                                <td class="text-danger pr-0 pt-7 text-right">MYR {{number_format($foods->restaurant_price,2)}}</td>
                              </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice body-->
                    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between flex-column flex-md-row font-size-lg">
                                <div class="d-flex flex-column mb-10 mb-md-0">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="mr-15 font-weight-bold">Subtotal</span>
                                        <span class="text-right">MYR {{number_format($order->restaurant_subtotal,2)}}</span>
                                    </div>

                                    @if($order->delivery_fee_restaurant > 0)
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="mr-15 font-weight-bold">Delivery Fee</span>
                                        <span class="text-right">MYR {{number_format($order->delivery_fee_restaurant,2)}}</span>
                                    </div>
                                    @endif

    
                            
                                @if($order->tax > 0)
                                    <div class="d-flex justify-content-between">
                                        <span class="mr-15 font-weight-bold">{{ number_format($restaurant->default_tax,2)}} % Sales Tax</span>

                                        <span class="text-right">MYR {{ number_format($order->restaurant_tax,2)}}</span>
                                      </div>
                                @endif

                                @if($order->discount!=0)
                                <div class="d-flex justify-content-between">

                                @if($discount == 1)
                                
                                <span class="mr-15 font-weight-bold special_inst"  style="color: green">Discount</span>
                                    <span class="text-right" style="color: green">MYR -{{number_format($order->discount_restaurant,2)}}</span>
                               
                                @endif
                              </div>
                            @endif

                                @if($order->isdelivery == 0) 
                                    @if($order->tips>0)
                                    <div class="d-flex justify-content-between">
                                        <span class="mr-15 font-weight-bold">Tips</span>
                                        <span class="text-right">MYR {{number_format($order->tips,2)}}</span>
                                    </div>
                                    @endif
                                @endif

                                </div>

                                <div class="d-flex flex-column text-md-right">
                                    <span class="font-size-lg font-weight-bolder mb-1">TOTAL AMOUNT</span>

                                    <span class="font-size-h2 font-weight-boldest text-danger mb-1">MYR {{number_format($order->restaurant_total,2)}}</span></div>
                            </div>
                        </div>
                    </div>

                                      <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                                            <div class="col-md-9">
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-light-primary font-weight-bold" >
<a href="{{route('downloadPDF', ['order_id'=>($order->id),'date'=>now()])}}" style="color: #511717;">Download PDF</a>
                                                        


                                                    </button>
                                                    <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Order</button>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- end: Invoice action-->