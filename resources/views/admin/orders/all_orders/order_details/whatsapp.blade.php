       @if ($order->active == 1)
                 <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                <div class="d-flex align-items-center flex-wrap mr-1">
                                    <div class="d-flex align-items-baseline mr-5">
                                        <h5 class="text-dark font-weight-bold my-2 mr-5">Order #<span id="order_id">{{$order->id}}</span></h5>
                                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                            <li>
                                                <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#kt_datatable_modal" style="background-color: #0e8f23;border-color: #147e21;"> <i class="icofont-whatsapp fa-2x footer-icon"></i> Whatsapp Order</button>
                                            </li>
                                        </ul>
                                        <!--end::Breadcrumb-->
                                    </div>
                                    <!--end::Page Heading-->
                                </div>
                            </div>
                        </div>
@endif

                        <!--end:: ًWhatsApp-->