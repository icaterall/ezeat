

 $('#changeaddress').on('click', function (e) {
  e.preventDefault();

  $("#delivery_modal").hide();
  $("#datemodal").hide();
  $("#change_address").slideToggle("fast");
});

$('#cancel_changeaddress').on('click', function (e) {
  e.preventDefault();
  $("#change_address").slideToggle("fast");
});

$('#autocomplete').keyup(function () {
  if ($(this).val().length > 1) {
    $("#homesearchbtn").attr('disabled', false);
  } else
    $('#homesearchbtn').attr('disabled', 'disabled');
});








//Open When Calender Modal
 $('.startOrderForm--selectionForm').on('click', function () {
  
  $('#timetab').removeClass("s-btn--selected");
  $('#datetab').addClass("s-btn--selected");
  $("#dateContent").css('display', 'block');
  $("#timeContent").css('display', 'none');
  
  $('#calenderbody').addClass("openDialog");

   });

//Close Calender Modal Btn
$('.s-link').on('click', function () {
$('#calenderbody').removeClass("openDialog");
$('#store_close_body').removeClass("openDialog");
$('#far_distance_body').removeClass("openDialog");
        });


//Show user login menu, flip the small arrow
