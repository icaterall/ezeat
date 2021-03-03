@extends('admin.merchants.layouts.master') 

@section('title', 'Orders Management :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')




<script type="text/javascript">
$(document).ready(function () {
 rider_status = $('#status').val();
find_rider = $('#find_rider').val();

    var timeLeft = 10;
    var timerId = setInterval(countdown, 1000);    
    function countdown() {
          if (timeLeft == 0) {
            clearTimeout(timerId);
             if((rider_status != 0) && (find_rider == 1)) //
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
