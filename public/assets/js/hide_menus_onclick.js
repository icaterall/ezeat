
//--------------------------------Show Menu / Hide if out Cart frame---------


window.addEventListener('click', function(e){   

  if (

    !(document.getElementById('user-menu-btn').contains(e.target)) 
    &&($(".user_menu").css('display') == 'block'))

  {
          $('.user_menu').addClass("user_hidden");

  } 

  //  floatingCart is the cart icon
  // current_cart is the cart box
 
 // if you are clicking on cart icon and cart container is hidden then show it
  


  if (

    (document.getElementById('floatingCart').contains(e.target)) 
    &&($(".current_cart").css('display') == 'none'))

  {
     $(".current_cart").css('display', 'block');
          $('.user_menu').addClass("user_hidden");
$(".filtersComponent").hide();
  } 



else if ((document.getElementById('floatingCart').contains(e.target)) 
  &&($(".current_cart").css('display') == 'block'))

  {

     $(".current_cart").css('display', 'none');      



  } 


else if ((document.getElementById('mobileCartArrow').contains(e.target)) &&($(".current_cart").css('display') == 'block'))

  {
     $(".current_cart").css('display', 'none');
           $(".change_location").removeClass("open");
            $('.address-suggestions').css('display','none');


  } 


else if ((document.getElementById('product_modal').contains(e.target)) &&($(".current_cart").css('display') == 'block'))

  {
     $(".current_cart").css('display', 'block');
     $('.user_menu').addClass("user_hidden");


  } 



else if (document.getElementById('cartdisplay').contains(e.target))
{
   $(".current_cart").css('display', 'block'); 
   $('.user_menu').addClass("user_hidden");
   
}

  else{
    $(".current_cart").css('display', 'none'); 
  }

});

