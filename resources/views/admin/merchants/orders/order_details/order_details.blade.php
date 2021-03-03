@extends('admin.merchants.orders.order_details.template')
@section('local_content')
    @section('css')


@endsection

@section('content')
 
    <style type="text/css">
  .pre_order_background{
background-color: #a32ca3;border-color: #a32ca3;color: #ffffff;
  }
  .pre_order_font{
  text-align: center;color: black;font-weight: 800;font-size: 20px;
  }
  .order_note_bg{
    background-color: #1AC835;
border-color: #20650D;
}

  .order_note_font{
 text-align: center;
    color: black;
    font-weight: 800;
}

.order_size{
font-weight: 700; padding: 2px;
}
.order_extra{
color: #777; padding-left: 15px;
}
.extra_title{
font-weight: 700; color: green;
}

.special_inst{
font-style: oblique; color: #cc1347;
}
</style>
 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                   <i class="fa fa-outdent text-primary"></i>
                </span>
                 @can('admin_privilege')
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light-primary font-weight-bolder btn-sm">All Orders</a>
                @endcan
                 @can('manager_privilege')
                <a href="{{ route('manager.orders.index') }}" class="btn btn-light-primary font-weight-bolder btn-sm">All Orders</a>
                @endcan
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold">Edit Order</span>
            </div>
        </div>
    </div>
    
            


    @php
    $restaurant = $order->foods->first()->restaurant;
    @endphp
    @include('admin.orders.all_orders.order_details.whtsapp_message_modal')
    @include('admin.orders.all_orders.order_details.decline_modal')


            
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                  <div class="card-header">
                    <div class="card-title">
                      <span class="card-icon">
                        <i class="fa fa-edit text-primary"></i>
                      </span>
                      <h3 class="card-label">Edit order information</h3>
                    </div>
                  </div>

<!-- Show repsonse messages -->
         @include('admin.include.response_notification')
<!-- end response messages -->

<!-- Body -->
<div class="card-body">
                 
    <form  action="{{ route('admin.orders.update', $order->id) }}" id="editform" method="POST" class="form-horizontal">
                 
<!-- ًWhatsApp -->
<div id="update_status">
@include('admin.orders.all_orders.order_details.order_notification')
</div>

 <div class="d-flex flex-column-fluid">
                            <div class="container">

                                <div class="card card-custom overflow-hidden">
                                    <div class="card-body p-0">
                                        <!-- begin: Invoice-->
  @can('manager_privilege')
   @include('admin.orders.all_orders.order_details.order_status_btns')
  @endcan  

@if(Auth::guest())
   @include('admin.orders.all_orders.order_details.order_status_btns')
@endif


@include('admin.orders.all_orders.order_details.order_header_information')


@if($order->driver_id != null)
<input type="text" id="find_rider" value="1" hidden="">
    <div>
        <h2>Rider details</h2>
    @include('admin.orders.all_orders.order_details.rider_details')
 </div>
@endif



@include('admin.orders.all_orders.order_details.order_items_restaurant')
</div>
</div>
</div>
</div>

    </form>    
                   
                  
                  </div>
<!-- End body -->

                </div>
                <!--end::Card-->
                
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>

      <input type="text" id="rider_search" value="{{$rider_serach}}" hidden="">           

@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function () {



rider_search = $('#rider_search').val();

    var timeLeft = 15;
    var timerId = setInterval(countdown, 1000);    
    function countdown() {
          if (timeLeft == 0) {
            clearTimeout(timerId);
             if(rider_search == 1) //
                   { 
                    window.location.reload();                     
                   }

          } else {
            timeLeft--;
          }
}

});


     $('#sendwsp').on('click', function () {
        $(this).closest('.row').find('.inputQty');

        var url = window.location.href; 
        
        message=$('#whatsappmessage').val()+' '+url;

         window.open('whatsapp://send?text='+message);
        });


//-------- Timer

</script>



@endsection


