 <!-- Delete Model -->
 <form action="" method="POST" class="remove-extra-model">
        {{method_field('DELETE')}}
        @csrf

       <div id="delete-extra-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
           <div class="modal-dialog" >
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="custom-width-modalLabel"> {{ __('config.modal.delete.title') }}</h4>
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                   </div>
                   <div class="modal-body">
                       <h4>{{ __('config.modal.delete.message') }}</h4>
                   </div>
                  
                   <div class="modal-footer">
                       
                       <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{ __('config.cancel') }}</button>

                       <button type="button" id="delete_extra_record" class="btn btn-danger waves-effect waves-light">{{ __('config.delete') }}</button>
                   
                   </div>
               </div>
           </div>
       </div>
   </form>

