<div class="row">
  <div class="form-group col-xl-10">
    <label  class="label_class">{{$text}}</label>

           <button type="button" class="btn btn-primary btn-sm float_right" data-toggle="modal" data-target="#modal-{{$name}}"> <i class="fa fa-plus icon-sm "></i>
        </button>



      <select class="form-control form-control-lg  select{{$name}} " name="{{$name}}" id="{{$name}}" required='required' >
        @if(is_null($newId))
          <option value="" selected="" >Select {{$text}}</option>
        @endif
        @foreach($menu as $key => $value)
          <option @if(!is_null($selectedValue) && is_null($newId) && ($selectedValue == $key) ) selected="" @endif value="{{$key}}">{{$value}}</option>
        @endforeach
        @if(!is_null($newId))
          <option value="{{$newId}}" selected="" >{{$newName}}</option>
        @endif
      </select>
  </div>
  

<div class="modal fade show" id="modal-{{$name}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="padding-right: 16px; display: none;">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create {{$text}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                     
                                      @livewire('constant.create', ['model' => $modelName])

                                  </div>
                                 
                                </div>
                              </div>
                            </div>




</div>

@push('script')
 
<script type="text/javascript">
  var initSelect2 = '.select{{$name}}';
  $(initSelect2).select2({width:'100%'});



 document.addEventListener("livewire:load", function(event) {
    window.livewire.hook('afterDomUpdate', (component) => {


         if(component.events.length > 0){
          console.log(component)

      var initSelect2 = '.select'+@this.get('name');
          var listName  ='objectAdded_'+@this.get('modelName');
          if(component.events[0] == listName){
          $(initSelect2).select2({width:'100%'});
          $('#modal-{{$name}}').modal('toggle');
          }
         }
    });
});
 

 
</script>
@endpush
