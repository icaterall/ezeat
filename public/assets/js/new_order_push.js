
window.onload = function() {
  var context = new AudioContext();
}


      // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('order-submitted');
    var myAudio = new Audio('/csfiles/new_order.mp3');
    store_id = $('#store_id').val();

      function soundalert(){
        myAudio.addEventListener('ended', function() {
            this.currentTime = 0;
            this.play();
        }, false);
        myAudio.play();
    }

    function stopalert(){
        myAudio.pause();
    }



      // Bind a function to a Event (the full Laravel class)
      channel.bind('App\\Events\\OrderSubmitted', function(data) {
    

    if(store_id==data.store_id)
    {

    $('.datatable').DataTable().ajax.reload();
    $("#order_link").attr("href", '/mobile_restaurant_order_details/'+data.store_id+'/'+data.order_number+'/'+data.secret);
    $("#order_modal").addClass("openDialog");
 $("#order_sound").get(0).play();
 soundalert();
   

    $('<iframe>')                      // Creates the element
    .attr('src','/csfiles/new_order.mp3') 
    .attr('allow',"autoplay")
    .css('display','none')
    .appendTo('#iframe_div');

         } 
   });


$(document).ready(function () {

$('.close_modal').on('click', function (e) {
  e.preventDefault();
  $("#order_sound").get(0).pause();
   stopalert();
  $('#order_modal').removeClass("openDialog");
        });
   });