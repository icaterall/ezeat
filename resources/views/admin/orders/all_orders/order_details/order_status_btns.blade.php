
@if($order->active == 1)

<div class="row justify-content-center py-8 px-8 py-md-10 px-md-0 bgi-size-cover bgi-no-repeat" style="background-image: url(/adminfiles/assets/media/btn_back.jpg);">
                                            <div class="col-md-9">
                                                <div class="d-flex justify-content-between">

 @if($order->order_status_id == 1) 
<button type="button"  data-url= "{{ route('admin.updateOrder',[$order->id,$order->secret,'confirm'])}}"  class="update_order_status btn btn-success mr-2">Accept</button>
@endif

@if(($order->order_status_id == 2) AND ($order->order_type == 'preorder') ) 
<button type="button"  data-url= "{{ route('admin.updateOrder',[$order->id,$order->secret,'cooking'])}}"  class="update_order_status btn btn-success mr-2">Click if preparing food now </button>

@elseif($order->order_status_id == 2) 
<button type="button"  data-url= "{{ route('admin.updateOrder',[$order->id,$order->secret,'ready'])}}"  class="update_order_status btn btn-success mr-2">Food is Ready?</button>

@endif


@if($order->isdelivery == 0)
    <button type="button" data-url= "{{ route('admin.updateOrder',[$order->id,$order->secret,'delivered'])}}"  class="update_order_status btn btn-success mr-2">Delivered to the customer</button>
@endif  

@if($order->isdelivery == 1 AND $order->order_status_id == 3 AND $order->driver_id != null) 
    <button type="button" data-url= "{{ route('admin.updateOrder',[$order->id,$order->secret,'delivered'])}}"  class="update_order_status btn btn-success mr-2">Pickup by the rider</button>
@endif  


   @if(($order->order_status_id != 4) AND ($order->order_status_id != 3) AND ($order->order_status_id != 5))
  <a class="decline-record btn btn-icon btn-light btn-hover-primary btn-sm">
  <button type="button" data-toggle="modal" class=" btn btn-danger mr-2" data-target="#decline-modal" id="decline-record">Decline</button>
  </a>
  @endif

                                                 
                                                </div>
                                            </div>
                                        </div> 


@endif