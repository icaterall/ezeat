
<div class="modal fade show" id="edit-extras-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="padding-right: 16px; display: none;">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Extra</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                      @include('admin.include.response_notification')
                  
           <form  action="" id="editextraform" method="POST" class="form-horizontal">
                    <div id="showExtraForm">

                       
                     </div>    
                </form>

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                    
                   
                           <button id="EditExtraButton" type="button" class="btn btn-success font-weight-bold">Save changes</button>

                          

                                  </div>
                                </div>
                              </div>
                            </div>

@push('script')

<script type="text/javascript">


  
    $(document).ready(function() {

//SHOW  Edit Form Modal 

    $('tbody').on('click', '.edit_extra_btn', function (e) {
      e.preventDefault();
      var extra_url = $(this).attr('data-url');
        var extra_post_edit = $(this).attr('data-id');
      $("#editextraform").attr("action",$(this).attr('data-id'));

       $('.alert-success').hide();  
       $('.alert-danger').html('');
       $('.alert-danger').hide();

                $.ajax({
                    url: extra_url,
                    method: 'GET',
                  
                   beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                        toastr.clear();
                        console.log(result.showExtraForm);
                        $('#showExtraForm').html(result.showExtraForm);
                        $("#editextraform").attr("action",extra_post_edit);

          }
       });
    });





//  Edit
           $('#EditExtraButton').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $("#editextraform").attr('action'),
                    method: 'PUT',
                    data:$("#editextraform").serialize(),
                      
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
                            $('#extra_table').DataTable().ajax.reload();
                             Command: toastr ["success"] ("Updated successfully", "Update status");                    
                        
                        }
                    }
                });
            });

 });

</script>
@endpush













<!-- End Modal -->
