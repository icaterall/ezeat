@include('admin.finance.restaurants.orders.template')

<div  id="kt_content">
@if(count($total_orders)>0)
           <div class="portlet-body">
                            
                            <table class="visual_table table table-striped table-bordered table-hover dt-responsive" width="100%"
                                   id="sample_1">
                                <thead>
                      <tr>
                         <th><label class="checkbox checkbox-single">
                        <input type="checkbox" value="all" class="group-checkable"/>
                        <span></span>
                    </label></th>


                       <th>Order ID</th>
                       <th>Client</th>
                       <th>Total</th>
                        <th>Order Status</th>
                        <th>Method</th>
                        <th>Active</th>
                        <th>Updated at</th>
                      </tr>
                                </thead>
                                <tbody>

                                @foreach ($total_orders as $data)
                                    <tr id="{{$data->id}}">

                                      <td> <label class="checkbox checkbox-single">
                            <input type="checkbox" value="{{$data->id}}" class="checkable" name="checkable"/>
                            <span></span>
                        </label>
                      </td>
                                        <td>{{$data->id}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->restaurant_total}}</td>
                                        <td>{{$data->orderStatus->status}}</td>
                                        <td>{{ ($data->is_cash == 1)?"Cash":"Online Payment" }}</td>
                                        <td>{{ ($data->active == 1)?"Yes":"No" }}</td>
                                        <td> {{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</td>

                                    </tr>
                              @endforeach
                                </tbody>
                            </table>
                            {{ csrf_field() }}
                        </div>

                        @endif
</div>


