    $('.update_location').on('click', function (e) {
  e.preventDefault();

  $('#autocomplete').val($(this).data("id"));
  
  $("#updateAddress").trigger('submit');

});   


            var placeSearch, autocomplete;

            function initAutocomplete() {
                var addressInput = document.getElementById('autocomplete');
                if (addressInput) {
                    autocomplete = new google.maps.places.Autocomplete(addressInput, {
                componentRestrictions: {country: 'us'}
                 });
                }     
            }

            // Bias the autocomplete object to the user's geographical location,
            // as supplied by the browser's 'navigator.geolocation' object.
            function geolocate() {
                if (navigator.geolocation) { 

                    navigator.geolocation.getCurrentPosition(function (position) {

                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,

                        };
                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        autocomplete.setBounds(circle.getBounds());
                    });

                }
            }
            //Find Stores

            $(document).ready(function() {
                // Address search on home page
                $("#findlocation").submit(function(e) {

                    e.preventDefault();

                            $("#findlocation :input").prop("disabled", true);
                            $('.loader').show();

                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'address': $('#autocomplete').val() + ', us'}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            parseAddress(results); 
                            searchStoresByAddress(address);
                        } else {
                            // if error
                              $('#errorlocation_message').css('display', 'block');
                              $("#findlocation :input").prop("disabled", false);
                               $('.loader').hide();
                        }
                    });
                });
                
    // On store page
    $("#updateAddress").submit(function(e) {

        e.preventDefault();
        $("#updateAddress :input").prop("disabled", true);
       
        $('.loader').show();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': $('#autocomplete').val() + ', us'}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                parseAddress(results);
                updateAddress(address);
            } else {
                // if error
                  $("#updateAddress :input").prop("disabled", false);
                  $('.findstoresbtn').css('display', 'block');
                   $('.loader').hide();
            }
        });
    }); 
});

function parseAddress(results) {
    address = {};

    address.latitude = results[0].geometry.location.lat();
    address.longitude = results[0].geometry.location.lng();
    addressComponents = results[0].address_components;
    address.street_address = results[0].formatted_address;
    
    for (i = 0; i < addressComponents.length; i++) {
        var types = addressComponents[i].types;
        
        if (types.includes("locality")) {
            address.cityname = addressComponents[i].long_name;
        }

        if (types.includes("administrative_area_level_1")) {
            address.statename = addressComponents[i].short_name;
        }

        if (types.includes("postal_code")) {
            address.zipcode = addressComponents[i].long_name;
            if (!($.isNumeric(address.zipcode))) {
                address.zipcode = null;
            }
        }

    }



if((address.streetAddress!='undefined')&&(address.streetAddress!=null))

    {
        return address; 
    } 
    else
    {
       

    }
}

function searchStoresByAddress(address) {   

     $("#findlocation :input").prop("disabled", true);
      $('.loader').show();
     var params = $.param(address);
     window.location = '/restaurants/search-initial?'+params; 
}

function updateAddress(address) {
     $("#findlocation :input").prop("disabled", true);
    
     $('.loader').show();
    
    $.ajax({
        type: 'get',
        url: "/restaurants/update-address",
        data: address,
        success: function(data) {
        window.location.reload();
        }       
    });
}


// on input change hide error message

$('#autocomplete').on("keyup", function() {
    $('#errorlocation_message').css('display', 'none');
    });


// Get current location

function initMap() {
    var centerCoordinates = new google.maps.LatLng(37.6, -95.665);
    var defaultOptions = { center: centerCoordinates, zoom: 4 }
}

function locate(){
   
    if ("geolocation" in navigator){
       
        $('.loader').show();
        navigator.geolocation.getCurrentPosition(function(position){ 
            var currentLatitude = position.coords.latitude;
            var currentLongitude = position.coords.longitude;

            var infoWindowHTML = "Latitude: " + currentLatitude + "<br>Longitude: " + currentLongitude;
            var currentLocation = { lat: currentLatitude, lng: currentLongitude };
            displayLocation(currentLatitude,currentLongitude);

            function displayLocation(currentLatitude,currentLongitude){

    var geocoder;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(currentLatitude, currentLongitude);

    geocoder.geocode(
        {'latLng': latlng}, 
        function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var add= results[0].formatted_address ;
                    var  value=add.split(",");

                    $('#autocomplete').val(add);
                 
                   
                    $('.loader').hide();
                }
                else  {
                    x.innerHTML = "address not found";
                  
                  $('.loader').hide();
                      }
            }
            else {
                x.innerHTML = "Geocoder failed due to: " + status;
                $('.loader').hide();
            }
        }
         );

        }
      });
    }

// Find Location

}