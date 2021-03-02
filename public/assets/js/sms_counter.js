$(document).ready(function () {
 if ($('#mobile').val().length > 3) {
            $("#verifybtn").attr('disabled', false);
             $("#get_code").attr('disabled', false);
        } 


var timeLeft = 30;
    var elem = document.getElementById('timer_down');
    
    var timerId = setInterval(countdown, 1000);
    
    function countdown() {
      if (timeLeft == 0) {
        clearTimeout(timerId);
        $('#hide_counter').hide();
    $('#show_send_code_btn').css('display','block');
      } else {
        elem.innerHTML ='Get another code in 00:'+ timeLeft;
        timeLeft--;
      }

 }

});
