
<div class="modal fade show" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="padding-right: 16px; display: none;">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                      @include('admin.include.response_notification')
                  

                  <form  action="{{ route('admin.cuisines.store') }}" id="createform" method="POST" class="form-horizontal">

                         @include('admin.restaurants.cuisines.form')

                </form>

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                    
                   
                           <button type="button"  id="CreateFormButton" class="btn btn-success font-weight-bold">Submit</button>
                          

                                  </div>
                                </div>
                              </div>
                            </div>















<!-- End Modal -->
