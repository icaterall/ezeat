  <style type="text/css">
      .pl-8, .px-8 {
    padding-left: 0rem !important;
}
  </style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Subheader-->
                        <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
                            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap mr-2">
                                    <!--begin::Page Title-->
                                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                                    <!--end::Page Title-->
                                    <!--begin::Action-->
                                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                                
                                    <!--end::Action-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Toolbar-->
                                <div class="d-flex align-items-center flex-wrap">
                                    <!--begin::Actions-->
               
                                    <!--end::Actions-->
                                    <!--begin::Daterange-->
                                    <a href="#" class="btn btn-bg-white font-weight-bold mr-3 my-2 my-lg-0" id="kt_dashboard_daterangepicker" data-toggle="tooltip" title="Select dashboard daterange" data-placement="left">
                                        <span class="text-muted font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title">Today</span>
                                        <span class="text-primary font-weight-bolder" id="kt_dashboard_daterangepicker_date"></span>
                                    </a>
                                    <!--end::Daterange-->
                                  
                                </div>
                                <!--end::Toolbar-->
                            </div>
                        </div>
                        <!--end::Subheader-->
                        <!--begin::Entry-->
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class="container">
                                <!--begin::Dashboard-->
                              
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-lg-6 col-xxl-4">
                                        <!--begin::Mixed Widget 4-->
                                        <div class="card card-custom bg-radial-gradient-danger gutter-b card-stretch">
                                            <!--begin::Header-->
                                            <div class="card-header border-0 py-5">
                                                <h3 class="card-title font-weight-bolder text-white">Sales Progress</h3>
                                               
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body d-flex flex-column p-0">
                                                <!--begin::Chart-->
                                               
                                                <!--end::Chart-->
                                                <!--begin::Stats-->
                                                <div class="card-spacer bg-white card-rounded flex-grow-1">
                                                    <!--begin::Row-->
                                                    <div class="row m-0">
                                                        <div class="col px-8 py-6 mr-8">
                                                            <div class="font-size-sm text-muted font-weight-bold">Sales</div>
                                                            <div class="font-size-h4 font-weight-bolder">MYR {{$payment_summary['restaurant_payment']}}</div>
                                                        </div>
                                                        <div class="col px-8 py-6">
                                                            <div class="font-size-sm text-muted font-weight-bold">Earning</div>
                                                            <div class="font-size-h4 font-weight-bolder">MYR {{$payment_summary['restaurant_payment_pending']}}</div>
                                                        </div>
                                                    </div>
                                                    <!--end::Row-->
                                                   
                                                    <!--end::Row-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Mixed Widget 4-->
                                    </div>
                                    
                                    <div class="col-lg-6 col-xxl-8">
                                        <!--begin::Advance Table Widget 1-->
                                        <div class="card card-custom card-stretch gutter-b">
                                            <!--begin::Header-->
                                            @include('admin.merchants.orders.datatable')
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body py-0">
                                                <!--begin::Table-->
                                                
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Advance Table Widget 1-->
                                    </div>
                                </div>
                                <!--end::Row-->
                                
                                <!--end::Dashboard-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Entry-->
                    </div>