@extends('merchants.layouts.master') 

@section('title', 'Foods Management :: Spoongate')

    @section('css')

    @endsection

  @section('content')
@yield('local_content')
  
@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {

    // begin table

  var table = $('#visual_table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                pageLength: 10, 
                responsive: true,
                aaSorting: [[6, 'desc']],

             // Pagination settings
      dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
      <'row'<'col-sm-12'tr>>
      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,         
      "iDisplayLength": 10,
      "aLengthMenu": [[5, 10,50, 100, -1], [5, 10,50, 100, "All"]],
      buttons: [
        'print',
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
      ],
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route('manager.foods.index') }}',
        type: "GET",
        dataType: "JSON",
 
      },
       columns: [

      {data: 'name', name: 'name', sClass: 'text-center'},
      {data: 'category', name: 'category', sClass: 'text-center'}, 
      {data: 'restaurant', name: 'restaurant', sClass: 'text-center'}, 
      {data: 'restaurant_price', name: 'restaurant_price', sClass: 'text-center'},
      {data: 'featured', name: 'featured', sClass: 'text-center'},
      {data: 'deliverable', name: 'deliverable', sClass: 'text-center'},
      {name: 'updated_at.timestamp', 'data': { '_': 'updated_at.display', 'sort': 'updated_at' } },
      {data: 'action', name: 'action', sClass: 'text-center',orderable: false, searchable: false},
      ],
   

      columnDefs: [

        {
          width: '75px',
          targets: 4,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Yes', 'state': 'success'},
              0: {'title': 'No', 'state': 'danger'},
            };
            if (typeof status[data] === 'undefined') {
              return data;
            }
            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },

        {
          width: '75px',
          targets: 5,
          render: function(data, type, full, meta) {
            var status = {
              1: {'title': 'Yes', 'state': 'success'},
              0: {'title': 'No', 'state': 'danger'},
            };
            if (typeof status[data] === 'undefined') {
              return data;
            }
            return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
              '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
          },
        },

         ],
    });
});

// End Table
        CKEDITOR.replace('description');
        
      $('#CreateFormButton').click(function(e) {      
       $('.alert-danger').hide();
       $('.alert-success').hide();
                e.preventDefault();
                
                  for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
                      }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $("#createform").attr('action'),
                    method: 'post',
                    data: $("#createform").serialize(),

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
                        $('#visual_table').DataTable().ajax.reload();
                        $('#price').val('');
                        $('#name').val('');
                        $('#item_image').val('');
                        
                        setTimeout(function() { 
                          
                          window.location = result.url;

                        }, 100);
                        $('#view_image').css("background-image", "url(/uploads/noimage.png)");
                        CKEDITOR.instances.ckeditor1.setData('');

                         
                        }
                    
                    }
                });
            });

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

 // For A Delete Record Popup
  $(document).ready(function() {


    // For A Delete Record Popup
    $('tbody').on('click', '.remove-record', function () {
      var url = $(this).attr('data-url');
      $(".remove-record-model").attr("action",url);
  
      $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
    });
 
  });

          

            // Delete product Ajax request.
            $('#delete_record').click(function(e) {
                e.preventDefault();             
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(".remove-record-model").attr('action'),
                    method: 'DELETE',
                    beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                       toastr.clear(); 
                        $('#visual_table').DataTable().ajax.reload();
                        $('#delete-modal').hide();
                        $('.modal-backdrop').css('display','none');
                        Command: toastr ["error"] ("Deletion completed successfully", "Deletion status");
                    }
                });
            });


//Upload image

$('.profile_remove').click(function() {
     $('#item_image').val($('#orginal_item_image').val());
  });

$(document).ready(function(){

  var image_url="/uploads/upload_food_image";

  var btn_name = 'upload_item_image';
  
  var image_file = $('#item_image');

 $(document).on('change','#upload_item_image', function(){ 
   uploadImage(image_url,btn_name,image_file);
   });
 });


//------------------Category ------------

// Create 

      $('#CreateCategoryFormButton').click(function(e) { 
       $('.alert-danger').hide();
       $('.alert-success').hide();
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.categories.store') }}",
                    method: 'post',
                    data: {
                      'name':$("#category_name").val() 
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
                        } 

                  else { // if added success
                       $('#create-category-modal').hide();
                       $('.modal-backdrop').css('display','none');     
                       $('.alert-danger').hide();
                       $('.alert-success').show();    
                        Command: toastr ["success"] ("Added successfully", "Added status");
                         }
                    
                    }
                });
            });

$("#foodpanda").keyup(function(){   

var foodpanda = parseFloat($("#foodpanda").val());
  $(".foodpanda").text((foodpanda - (foodpanda * 0.30)).toFixed(2));
   $("#price").val((foodpanda - (foodpanda * 0.30)).toFixed(2));
});

</script>


@endsection
