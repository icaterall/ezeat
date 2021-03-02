<div class="row">
                       <div class="col-xl-12">
                        <label class="label_class">Cuisine<span style="font-weight: 400">(optional)</span></label>    <button type="button" class="btn btn-primary btn-sm float_right" data-toggle="modal" data-target="#modal-cuisine"> <i class="fa fa-plus icon-sm "></i>
        </button>

                       <div>
                        <select class="form-control select2" id="cuisines" name="cuisines[]" multiple="multiple">
                @if(isset($cuisines))
                   @if(count($cuisines) > 0)                    
                    @foreach($cuisines as $key=>$val)        
                        @if(isset($selectedValue))           
                            @if(count($selectedValue) > 0)
                                 <?php $found = 0; ?>
                                    @foreach($selectedValue as $restaurantkey=>$restaurantkey)
                                       @if($restaurantkey == $key)
                                         <option value="{{ $key }}" selected="selected">{{ $val }}</option>
                                          <?php $found++; break; ?>
                                       @endif
                                    @endforeach
                                  @if($found == 0)
                                   <option value="{{ $key }}">{{ $val }}</option>
                                  @endif
                              @else <!-- if count $userRestaurant == 0 -->
                              <option value="{{ $key }}">{{ $val }}</option>
                            @endif
                        @else <!-- if Not isset $userRestaurant-->   
                      <option value="{{ $key }}">{{ $val }}</option>
                      @endif 
                    @endforeach
                    @endif
                @endif
                            </select>
                          </div>
                            <div class="fv-plugins-message-container"></div>
</div>



<div class="modal fade show" id="modal-cuisine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="padding-right: 16px; display: none;">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Cuisine</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                     
                                      @livewire('constant.create_cuisine', ['model' => $modelName])

                                  </div>
                                 
                                </div>
                              </div>
                            </div>




</div>

@push('script')
 
<script type="text/javascript">

        // multi select
        $('#cuisines, #cuisines').select2();

 document.addEventListener("livewire:load", function(event) {
    window.livewire.hook('afterDomUpdate', (component) => {


         if(component.events.length > 0){
          console.log(component)

          var initSelect2 = '.select2';
          var listName  ='objectAdded_'+@this.get('modelName');
          if(component.events[0] == listName){
           $('#cuisines, #cuisines').select2();
          $('#modal-cuisine').modal('toggle');
          }
         }
    });
});
 

 
</script>
@endpush
