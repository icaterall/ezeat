
 <!-- Delete Model -->
 <form action="" method="POST" class="remove-record-model">

        @csrf

       <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
           <div class="modal-dialog" >
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="custom-width-modalLabel">Are you sure?</h4>
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                   </div>
                   <div class="modal-body">
                       <h4>If you click on Confirm, you cannot undo this action</h4>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Cancel</button>
                       <button type="button" id="delete_record" class="btn btn-danger waves-effect waves-light">Confirm</button>
                   </div>
               </div>
           </div>
       </div>
   </form>


