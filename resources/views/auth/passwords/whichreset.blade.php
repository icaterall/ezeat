
<!-- model -->                     
<div id="ResetModal" uk-modal> 
<div class="uk-modal-dialog"> 
<button class="uk-modal-close-default uk-padding-small" type="button" uk-close></button>                             
 <div class="uk-modal-header"> 
  <h4> Reset Password </h4> 
   </div>                             
<div class="modal-body uk-text-center"> 
        <h4>Select Account</h4>                         
     </div>         

 <div class="uk-modal-footer uk-text-center"> 
  <a href="{{ route('editorpassword.request') }}" class="uk-button uk-button-success"> Editor </a> 

    <a href="{{ route('cspassword.request') }}" class="uk-button uk-button-success"> Customer Service </a> 

</div>

      <div class="uk-modal-footer uk-text-right"> 
       <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button> </div>                             
                 </div>                         
                    </div> 
<!-- End Modal -->  
