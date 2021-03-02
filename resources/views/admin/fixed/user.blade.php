       @include('admin.include.contacts')  

<div class="topbar-item">
                                        <div class="btn btn-icon w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                            <div class="d-flex text-right pr-3">
                                                <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline mr-1">Hi,</span>
                                                <span class="text-white font-weight-bolder font-size-sm d-none d-md-inline">{{Auth::user()->name}}</span>
                                            </div>
                                            <span class="symbol symbol-35">
                                                <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-15">{{Auth::user()->name[0]}}</span>
                                            </span>
                                        </div>
                                    </div>

                                    