<div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex  flex-column flex-md-row font-size-lg">
                                <div class="d-flex flex-column mb-10 mb-md-0">


                                    <div class="d-flex mb-3">
                                        <span class="font-weight-bold">Name &amp; phone#&nbsp;</span>
                                        <span class=""> {{$order->riders->name}} / <a href="tel:{{$order->riders->mobile}}">{{$order->riders->mobile}}</a>
                                         </span>
                                    </div>


                                </div>
                                <div class="justify-content-between" style="margin-left: 50px;">
                                   
                                   @if($order->riders->riderProfile->first()->photo != null)
               
                                   <img id="yourphoto" src="https://riderapi.spoongate.com/storage/{{$order->riders->riderProfile->first()->photo}}" class="image-input image-input-outline" width="170" height="120">
                                   @else

                                   <img id="yourphoto" src="/adminfiles/assets/noimage.jpg" class="image-input image-input-outline" width="120" height="120">

                                   @endif
                                </div>
                                
                         @if(($order->order_status_id != 5) AND ($order->active == 1))
                                <div id="map" style="width: 500px; height: 350px;margin-left: 50px;">
                                  
                                </div>
                           @endif     
                             
                            </div>
                        </div>
                    </div>
@if($order->riders->location->first() != null)
<input  id="lat" value="{{$order->riders->location->first()->lat}}" hidden="">
<input  id="long" value="{{$order->riders->location->first()->long}}" hidden="">

@else

<input  id="lat" value="2.842719" hidden="">
<input  id="long" value="101.797027" hidden="">

@endif



@push('script')
   <script type="text/javascript">
    $( document ).ready(function() {

    var lat = $('#lat').val();
    var long = $('#long').val();  
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18,
        center: new google.maps.LatLng(lat, long),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker;

   
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, long),
            map: map
        });
    
  });
</script>  
@endpush               