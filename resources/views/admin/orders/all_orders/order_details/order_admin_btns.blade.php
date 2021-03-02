                                     <!-- begin: Invoice header-->
                                      <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0 bgi-size-cover bgi-no-repeat" style="background-image: url(/adminfiles/assets/media/btn_back.jpg);">
                                            <div class="col-md-9">
                                                <div class="d-flex justify-content-between">
   



   @if(($order->order_status_id != 4) AND ($order->order_status_id != 5))
  <a class="decline-record btn btn-icon btn-light btn-hover-primary btn-sm">
  <button type="button" data-toggle="modal" class=" btn btn-danger mr-2" data-target="#decline-modal" id="decline-record">Decline</button>
  </a>
  @endif

   </div>
 </div>
</div> 
