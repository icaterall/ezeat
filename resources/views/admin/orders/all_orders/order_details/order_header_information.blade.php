<div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                          <div class="col-md-9">
                            <div class="d-flex  flex-column flex-md-row font-size-lg">

<!-- LEFT PART -->
<div class="d-flex flex-column mb-10 mb-md-0">
                                    <div class="font-weight-bolder font-size-lg mb-3">Order details</div>
                             <div class="d-flex mb-3">
                                        <span class="font-weight-bold">Restaurant:</span>
                                        <span class="font-weight-bold text-danger">&nbsp;{{$restaurant->name}}
                                      </span>
                                    </div>

                                     <div class="d-flex mb-3">
                                        <span class="font-weight-bold">Order Type:</span>
                                        <span class="font-weight-bold text-danger">&nbsp;{{ ($order->isdelivery =='1')?"Delivery":"Pickup" }}</span>
                                    </div>

                                    <div class="d-flex  mb-3">
                                        <span class="font-weight-bold">Order Date:</span>
                                        <span class="">&nbsp;{{date('h:i a, Y-m-d', strtotime($order->created_at))}}</span>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <span class="font-weight-bold">Name & phone#&nbsp;</span>
                                        <span class=""> {{$order->user->name}} / <a href="tel:{{$order->user->mobile }}">{{ $order->user->mobile }}</a>
                                        </span>
                                    </div>


@if($order->isdelivery == 1)

      <div class="d-flex mb-3">
           <span class="font-weight-bold">Delivery from&nbsp;</span>
          <a target="_blank" href="http://maps.google.com/?q=1200 {{$restaurant->address}}">
          <span class="font-weight-bold" style="color:green">&nbsp; {{$restaurant->address}}</span>
          </a>
      </div>
      <div class="d-flex mb-3">
        <span class="font-weight-bold">Delivery to&nbsp;</span>                                       
        <a target="_blank" href="http://maps.google.com/?q=1200 {{$order->deliveryAddress->address}}">
          <span class="font-weight-bold" style="color:red">&nbsp; {{$order->deliveryAddress->address}}</span>
        </a>
      </div>
  @endif

       <div class="d-flex mb-3">
          <span class="font-weight-bold">Payment Type&nbsp;</span>                                     
          @if($order->is_cash == 0)
           <span class="font-weight-bold" style="color:green"> Online Banking</span>
          @else
           <span class="font-weight-bold" style="color:red"> Cash</span>
          @endif
      </div>
</div>
 <!-- END LEFT PART -->

 <!-- RIRGHT PART -->

      <div class="d-flex flex-column text-md-right">
        <span class="font-size-lg font-weight-bolder mb-1">{{($order->isdelivery =='1')?"Delivery on":"Pickup on"}}</span>

        <span class="font-size-h1 font-weight-boldest text-danger mb-1">
            @if($order->order_type=='asap') ASAP 
             @else 
               {{$order->time}} / {{date('Y-m-d', strtotime($order->date))}} 
            @endif
        </span>
      </div>
   </div>
  </div>
</div>


  @if($order->order_type != 'asap')
        <p class="pre_order_font">PreOrder</p>
   
  @endif

@if($order->hint != null)
<div class="alert alert-success order_note_bg">
  <p class="ordrer_not_font">
    {{ ($order->isdelivery =='1')?"Rider":"Restaurant" }} Instruction: {{$order->hint}}</p>
</div>
@endif