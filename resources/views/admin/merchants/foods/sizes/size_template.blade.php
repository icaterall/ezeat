@push('script')
<script type="text/javascript">
    // begin SIZE table
$(function () {
 
 var table = $('#size_table').DataTable({
searching: false, paging: false, info: false,
      ajax: {
        url: '{{ route('manager.sizes.index') }}',
            'data': {
                  food_id: '{{$data->id}}',
        },
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [

      {data: 'name', name: 'name', sClass: 'text-center'},
      {data: 'price', name: 'price', sClass: 'text-center'},
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
    });
});
    

    // For A Delete Record Popup
  $(document).ready(function() {
    $('tbody').on('click', '.remove-size-record', function () {
      var url = $(this).attr('data-url');
      $(".remove-size-model").attr("action",url);
    });
});

// Delete product Ajax request.
            $('#delete_size_record').click(function(e) {

                e.preventDefault();             
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(".remove-size-model").attr('action'),
                    method: 'DELETE',
                    beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                       toastr.clear(); 
                        $('#size_table').DataTable().ajax.reload();
                        $('#delete-size-modal').hide();
                        $('.modal-backdrop').css('display','none');
                        Command: toastr ["error"] ("Deletion completed successfully", "Deletion status");
                    }
                });
            });

//CREATE------------

   $('#CreateSizeFormButton').click(function(e) {      
       $('.alert-danger').hide();
       $('.alert-success').hide();
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                

                $.ajax({
                    url: $("#createSizeform").attr('action'),
                    method: 'post',
                    data: $("#createSizeform").serialize(),

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
                        } 

                  else { // if added success
                       $('.alert-danger').hide();
                       $('.alert-success').show(); 

                        Command: toastr ["success"] ("Added successfully", "Added status",{ timeOut: 900 });

                        $('#restaurant_price').val('');
                        $('#size_name').val('');
                        $('#size_table').DataTable().ajax.reload();
                       
                         
                        }
                    
                    }
                });
            });





//SHOW  Edit Form Modal 
 // For A Delete Record Popup

  $(document).ready(function() {

//SHOW  Edit Form Modal 
       var size_edit='';
    $('tbody').on('click', '.edit_size_btn', function (e) {
      e.preventDefault();
      var size_url = $(this).attr('data-url');
size_edit=$(this).attr('data-id');
      $("#editsizeform").attr("action",$(this).attr('data-id'));

       $('.alert-success').hide();  
       $('.alert-danger').html('');
       $('.alert-danger').hide();

                $.ajax({
                    url: size_url,
                    method: 'GET',
                  
                   beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                        toastr.clear();
                        $('#showSizeForm').html(result.showSizeForm);    
          }
       });
    });

//  Edit
           $('#EditSizeButton').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: size_edit,
                    method: 'PUT',
                    data: {
                      'name':$('#size_name').val(),
                      'restaurant_price':$('#restaurant_price').val(),
                      'food_id':$('#food_id').val(),
                    },
                      
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
                            $('#size_table').DataTable().ajax.reload();
                             Command: toastr ["success"] ("Updated successfully", "Update status");                    
                        
                        }
                    }
                });
            });

 });

//------------Extra table and Delete

    // begin SIZE table
$(function () {
 
 var table = $('#extra_table').DataTable({
searching: true, paging: false, info: false,
      ajax: {
        url: '{{ route('manager.extras.index') }}',
        type: "GET",
        dataType: "JSON",
                    'data': {
                  food_id: '{{$data->id}}',
        },
 
      },
       columns: [

      {data: 'name', name: 'name', sClass: 'text-center'},
      {data: 'price', name: 'price', sClass: 'text-center'},
      {data: 'group', name: 'group', sClass: 'text-center'},
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
    });
});
    

    // For A Delete Record Popup
  $(document).ready(function() {
    $('tbody').on('click', '.remove-extras-record', function () {
      var extra_delete_url = $(this).attr('data-url');
      $(".remove-extra-model").attr("action",extra_delete_url);
    });
});

// Delete product Ajax request.
            $('#delete_extra_record').click(function(e) {
                e.preventDefault();             
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(".remove-extra-model").attr('action'),
                    method: 'DELETE',
                    beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                       toastr.clear(); 
                        $('#extra_table').DataTable().ajax.reload();
                        $('#delete-extra-modal').hide();
                        $('.modal-backdrop').css('display','none');
                        Command: toastr ["error"] ("Deletion completed successfully", "Deletion status");
                    }
                });
            });



</script>

@endpush