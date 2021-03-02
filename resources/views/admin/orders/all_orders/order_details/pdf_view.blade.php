<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <style type="text/css">        
        @page {
            margin: 0px;
        }
        
        body {
            margin: 0px;
            
        }
        
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        
        a {
            color: #fff;
            text-decoration: none;
        }
        
        table {
            font-size: x-small;
        }
        
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        
        .invoice table {
            margin: 0px;
        }
        
        .information {
            background-color: #FFF;
        }
        
        .information .logo {
            margin: 5px;
        }
        
        .information table {
            padding: 5px;
        }

        
        .tableborders {
            border-collapse: collapse;
        }
        
        .hasborders {
            border: 1px solid black;
            padding: 5px;
        }
        
        .floatLeft {
            width: 50%;
            float: left;
        }
        
        .floatRight {
            width: 50%;
            float: right;
        }
        
        .align-left {
            text-align: left !important;    
        }
        
        .align-right {
            text-align: right;
        }
        .bold {
            font-weight: 700;
        }
        .regular{
            font-weight:400;
        }
    </style>

</head>

<body>

    <br>
    <br>


    @php 
        $getdate =str_replace(",","-",$order->created_at); 
        $created_at = date("D d M, Y", strtotime($getdate)); 
        $restaurant = $order->foods->first()->restaurant;
    @endphp

    <!-- Top Section -->

    <div style="margin-top: -20px;margin-right: 40px;margin-left: 40px;">
        <table width="100%">

            <tr>

                <!-- Store information -->
                <th class="align-left">
                    <span class="bold">{{$restaurant->name}}</span>
                    <div class="regular">{{$restaurant->mobile}}</div>

                    <!-- Order information -->
                    <br>
                    <div class="regular">Order: <span class="bold">#{{$order->id}}</span> </div>
                    <div class="regular">Received: <span class="bold">{{date('D d M, Y, g:i A', strtotime($order->created_at))}}</span></div>
                </th>
                <th style="text-align: right;">
                    <img width=140 height=32 src="{{asset('csfiles/img/logo.png')}}">
                </th>

            </tr>
        </table>
    </div>
    <br>
    <br>
    

    <!-- Two Boxes -->
    <div style="margin-top: -20px;margin-left: 40px;">

        <div class="floatLeft">

<!-- Order Status -->
   <table class="align-left" style="width: 350px">
                <tr>
                    <th class="hasborders bold">
                   <!-- Order Status -->


   <p style="margin-left: 20px;">
        <span class="bold">Status:</span>
        <span class="regular"> 
             {{$order->order_status_note}}
        </span> 
     </p> 
 </th>
</tr>

              
            </table>

            <table class="align-left" style="width: 350px">
                <tr>
                    <th class="hasborders bold">
                       Order type: {{ ($order->isdelivery =='1')?"Delivery":"Pickup" }}
                    </th>
                </tr>
            </table>

            <!-- items -->
            <br>
            <!--  -  Quantities -->

            <div style="border: 1px solid black;padding: 5px;margin-top: 0px;margin-right: 0px;margin-left: 0px;width: 335px">
                <div class="invoice">
                    <table width="100%">

                        <tr>
                            <th style=" border-bottom: solid 1px;">Qty</th>
                            <th style=" border-bottom: solid 1px;">Decription</th>
                            <th style=" border-bottom: solid 1px;">Price</th>
                        </tr>

    @foreach($order->foodOrders as $foods)
        <tr>
            <td style=" border-bottom: dotted 1px;">
                <span style=" border: solid 1px; padding:2px"> 
                {{ $foods->quantity }}</span>
            </td>

            <td style="border-bottom: dotted 1px;">
                <span style="font-weight: 700;color:green">{{ $foods->food->name }}</span> 
            
             @if($foods->food_size != null)
                <p>
                    <span style="font-weight: 700">Size:</span>
                 {{$foods->food_size}}
                </p>
            @endif 

            
             @foreach($foods->extraOrder->groupBy('extra_group_id') as $extra_group)        
                 <div style="font-size:10px;padding-left:15px">         
                          <span style="font-weight: 700;">
                            {{$extra_group->first()->extraGroup->name}}: 
                           </span> 

                                <?php $count = 0; ?>
                                   @php 
                                    $count = 0; 
                                    $arr = []; 
                                        foreach($extra_group as $key => $extra) 
                                            { 
                                   
                                    $arr[] = $extra->extras->name;
                                                $count++; 
                                     } 
                                $get_extra_name = implode(' ,' ,$arr);
                            @endphp 
                        </div>
                <div>{{ $get_extra_name}}</div>    
            @endforeach 
 

				@if(!empty($foods->food_instruction))
					<div role="listitem" class="item">
						<span class="bold"> Special instructions: </span>
						<span class="regular">{{$foods->food_instruction}}</span>
					</div>
				@endif
				</td>

				<td valign="top" style=" border-bottom: dotted 1px;">
                    MYR {{number_format($foods->price,2)}}
				</td>
		   </div>
		</tr>

    @endforeach

                </table>

                    <div style="font-size: 12px; text-align: right; margin-right: 40px;">
                    <p>Subtotal:&nbsp;&nbsp;<span class="bold">MYR {{number_format($order->subtotal,2)}}</span></p>
                    
                @if($order->isdelivery  == 1)
                    <p>Delivery Fee:&nbsp;&nbsp;<span class="regular">MYR {{number_format($order->delivery_fee,2)}}</span></p>
                @endif

                
                @if($order->tax > 0)
                    <p>Service tax:&nbsp;&nbsp;
                        <span class="bold">MYR {{ number_format($order->tax,2)}}</span>
                    </p>
                @endif

                @if($order->service_charge > 0)
                    <p>Service charge:&nbsp;&nbsp;
                        <span class="bold">MYR {{number_format($order->service_charge,2)}}</span>
                    </p>
                @endif

                @if($order->discount!=0)
                    <p>Discount :&nbsp;&nbsp;
                        <span class="bold">MYR -{{number_format($order->discount,2)}}</span>
                    </p>
                @endif


                @if($order->tips > 0)
                    <p> Tips:&nbsp;&nbsp;<span class="bold">MYR {{number_format($order->tips,2)}}</span> </p>
                @endif

            </div>
            <div style="border-top: solid 1px;font-size: 12px;text-align: right; margin-right: 40px;">
                <p>Total amount:&nbsp;&nbsp;<span class="bold">MYR {{number_format($order->total,2)}}</span> 
                </p>
            </div>


            </div>
        </div>

        <!--  -->

    </div>

    <div class="floatRight align-left">
        <table style="width: 350px;">
            <thead>
                <tr>
                    <th class="hasborders align-left" class="bold">
                   {{ ($order->isdelivery =='1')?"Delivery to":"Pickup by" }}
					<span class="regular"> {{$order->user->name}}</span>

					@if($order->isdelivery == 'delivery')
						<p  class="bold">Mobile number: <span class="regular">{{$order->user->mobile}}</span></p>
						
             @if($order->deliveryAddresss->uite_floor!=null)
                        <p  class="bold">Suite/Floor: <span class="regular">{{$order->deliveryAddresss->uite_floor}}</span></p>
            @endif
						<p  class="bold">Address: <span class="regular">{{$order->deliveryAddress->address}}</span></p>
					@endif
                       </th>
				  </tr>
				   <tr>
					
						@if($order->hint != null)
							<th class="hasborders" class="bold">Order instruction:<span class="regular">{{$order->hint}}</span>
							</th>
                        @endif 
                   

                </tr>
            </thead>
        </table>
    </div>

    </div>

</body>

</html>