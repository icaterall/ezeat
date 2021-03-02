<script type="text/javascript">
	  
        CKEDITOR.replace('information');

            // Update Ajax request.


            $('#EditFormButton').click(function(e) {
              
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                  for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
                      }
    
                $.ajax({
                    url: $("#editform").attr('action'),
                    method: 'PUT',
                    data: $("#editform").serialize(),
                      
                    beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {

                        toastr.clear();
                      if(result.errors) {
                            $('.alert-danger').html('');
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('#visual_table').DataTable().ajax.reload();
                             Command: toastr ["success"] ("Updated successfully", "Update status",{ timeOut: 1000 });                    
                        
                        }
                    }
                });
            });

 //Upload logo

$('.logo_remove').click(function() {
     $('#logo_image').val($('#orginal_logo_image').val());
  });
$('.image_remove').click(function() {
     $('#image_image').val($('#orginal_image_image').val());
  });

$(document).ready(function(){

  var image_url="/uploads/upload_restaurant_logo";

  var btn_name = 'upload_logo_image';
  
  var image_file = $('#logo_image');

 $(document).on('change','#upload_logo_image', function(){ 
   uploadImage(image_url,btn_name,image_file);
   });
 });

//Upload image

$('.profile_remove').click(function() {
     $('#item_image').val($('#orginal_item_image').val());
  });

$(document).ready(function(){

  var image_url="/uploads/upload_restaurant_banner";

  var btn_name = 'upload_item_image';
  
  var image_file = $('#item_image');

 $(document).on('change','#upload_item_image', function(){ 
   uploadImage(image_url,btn_name,image_file);
   });
 });

 
</script>


    <script type="text/javascript">
        var placeSearch, autocomplete;
        var componentForm = {
            locality: 'long_name',
            postal_code: 'short_name',
                administrative_area_level_1: 'short_name',
   postal_code: 'short_name',

        };
        function initAutocomplete() {

            autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete')),
                {
                 componentRestrictions: {country: 'my'}
            });
            autocomplete.addListener('place_changed', fillInAddress);
            var geocoder = new google.maps.Geocoder();
            var address = "Malaysia";
        }

        function fillInAddress() {

            var place = autocomplete.getPlace();

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }

            $("#latitude").val(place.geometry.location.lat());

            $("#longitude").val(place.geometry.location.lng());

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

    </script>
