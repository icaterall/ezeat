<!--begin::Card-->
                <div class="card card-custom">
                  <div class="card-header py-3">
                    <div class="card-title">
                      <span class="card-icon">
                        <i class="fa fa-bars text-primary"></i>
                      </span>
                   @if (Route::current()->getName() == ('manager.index'))
                      <h3 class="card-label">Latest Orders</h3>
                      
                  @else
                  <h3 class="card-label">All Orders</h3>
              @endif
                    </div>
                    <div class="card-toolbar">
                     
                      <!--begin::Button-->

                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="visual_table">
                      <thead>
                      <tr>
                       <th>Order ID</th>
                       <th>Client</th>
                       <th>Total</th>
                        <th>Order Status</th>
                        <th>Active</th>
                        <th>Updated at</th>
                        <th class="text-center">Action</th>
                      </tr>
                          </thead>
                     
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card card-custom card-custom gutter-t">
                  
                 
                </div>
                <!--end::Card-->