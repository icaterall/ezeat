
<div class="modal fade show" id="edit-size-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="padding-right: 16px; display: none;">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Size</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                      @include('admin.include.response_notification')
                  
           <form  action="" id="editsizeform" method="POST" class="form-horizontal">
                    <div id="showSizeForm">

                       
                     </div>    
                </form>

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                    
                   
                           <button id="EditSizeButton" type="button" class="btn btn-success font-weight-bold">Save changes</button>

                          

                                  </div>
                                </div>
                              </div>
                            </div>

@push('script')

<script type="text/javascript">


  
    $(document).ready(function() {

//SHOW  Edit Form Modal 

    $('tbody').on('click', '.edit_size_btn', function (e) {
      e.preventDefault();
      var size_url = $(this).attr('data-url');
        var size_post_edit = $(this).attr('data-id');
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
                        $("#editsizeform").attr("action",size_post_edit);

          }
       });
    });

 });

</script>
@endpush













<!-- End Modal -->
