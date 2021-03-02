        
   function uploadImage(image_url,btn_name,image_file){
    var name = document.getElementById(btn_name).files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
          if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
          {
           alert("Invalid image file");
          }
              var oFReader = new FileReader();
              oFReader.readAsDataURL(document.getElementById(btn_name).files[0]);
              var f = document.getElementById(btn_name).files[0];
              var fsize = f.size||f.fileSize;
          if(fsize > 600000)
          {
           alert("Image file size can't be more than 500 KB");
          }
   
    else
    {
     form_data.append("file", document.getElementById(btn_name).files[0]);

             $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
     $.ajax({
      url:image_url,
      method:"POST",
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend:function(){
        $('#loading').show();

      },   
      success:function(data)
      {
        image_file.val(data.name);
        $('#loading').hide();
      }
     });
    }
  };


