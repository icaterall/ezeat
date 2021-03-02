  
<div class="row">
   <div class="form-group col-10">
      <label>{{$text}}:</label>
      <div class="input-group">
         <div class="input-group-prepend">
            <span class="input-group-text">
            <i class="flaticon-list"></i>
            </span>
         </div>
         <input type="text" readonly="" class="form-control" required='required' @if(!is_null($newId)) value="{{$newName}}"  @endif>
         <input type="hidden" readonly="" class="form-control" name="{{$name}}" required='required' @if(!is_null($newId)) value="{{$newId}}"  @endif>
      </div>
   </div>
   <div class="form-group col-1">
      <label>&nbsp;</label>
      <x-modal name="{{$name}}">
         <x-slot name="trigger">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-{{$name}}"> <i class="fa fa-plus icon-sm "></i>
            </button>
         </x-slot>
         <x-slot name="dialogue">
            @livewire('constant.create', ['model' => $modelName])
         </x-slot>
         <x-slot name="modal_name">
            Add New Item
         </x-slot>
      </x-modal>
   </div>
</div>
@push('script')
 
<script type="text/javascript">
 
 document.addEventListener("livewire:load", function(event) {
    window.livewire.hook('afterDomUpdate', (component) => {

         if(component.events.length > 0){
         	var listName  ='objectAdded_'+@this.get('modelName');
         	if(component.events[0] == listName){
    			$('#modal-{{$name}}').modal('toggle');
         	}
         }
    });
});
 

 
</script>
@endpush
