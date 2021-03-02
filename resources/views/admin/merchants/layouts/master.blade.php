<html lang="en">
<head>
<title>@yield('title')</title>
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
 
<!-- Favicon Icon -->
        <link rel="canonical" href="https://keenthemes.com/metronic" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->
        <link href="/adminfiles/assets/css/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
        <link href="/adminfiles/assets/css/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="/adminfiles/assets/css/prismjs.bundle.css" rel="stylesheet" type="text/css" />
        <link href="/adminfiles/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <link href="/adminfiles/assets/css/datatables.bundle.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="/csfiles/img/favicon.png" />


        {{-- Includable CSS --}}
        @livewireStyles
        @yield('styles')
</head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">

        <!--begin::Main-->
        <!--begin::Header Mobile-->
@include('merchants.fixed.mobile_header')
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    

                    <!--begin::Header-->
                    <div id="kt_header" class="header flex-column header-fixed">
                        <!--begin::Top-->
                        <div class="header-top">
                            <!--begin::Container-->
                            <div class="container">
                                <!--begin::Left-->
                                <div class="d-none d-lg-flex align-items-center mr-3">
                                    <!--begin::Logo-->
                                    <a href="/" class="mr-10">
                                        <img alt="Logo" src="/adminfiles/assets/media/logo.png" class="max-h-45px" />
                                    </a>
                                </div>

@include('admin.include.whatsapp')
                       



                                <!--end::Left-->
                                <!--begin::Topbar-->
                                <div class="topbar">
                                    <!--begin::Tablet & Mobile Search-->
                                   
                                    
                                    
                                    <!--end::Quick panel-->
                                    <!--begin::Chat-->
                                
                                    <!--end::Chat-->
                                    <!--begin::User-->
                                    @include('merchants.fixed.user')
                                    <!--end::User-->
                                </div>
                                <!--end::Topbar-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Top-->
                        <!--begin::Bottom-->
                        @if (!\Request::is('new_restaurant/*'))
                        <div class="header-bottom">
                            <!--begin::Container-->
                            <div class="container">
                                <!--begin::Header Menu Wrapper-->
                                <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                                    <!--begin::Header Menu-->
                                    @include('merchants.fixed.header_menu')
                                    <!--end::Header Menu-->
                                </div>
                                <!--end::Header Menu Wrapper-->
                                <!--begin::Desktop Search-->
                                <div class="d-none d-lg-flex align-items-center">
                                    <div class="quick-search quick-search-inline ml-4 w-250px" id="kt_quick_search_inline">
                                        <!--begin::Form-->
                                      <!-- include Search -->
                                        <!--end::Form-->
                                        <!--begin::Search Toggle-->
                                        <div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,0px"></div>
                                        <!--end::Search Toggle-->
                                        <!--begin::Dropdown-->
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg dropdown-menu-anim-up">
                                            <div class="quick-search-wrapper scroll" data-scroll="true" data-height="350" data-mobile-height="200"></div>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                </div>
                                <!--end::Desktop Search-->
                            </div>
                            <!--end::Container-->
                        </div>
                        @endif
                        <!--end::Bottom-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Content-->
                


                @yield('content')
      <!--end::Content-->
                    <!--begin::Footer-->
                    @include('merchants.fixed.footer')
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>

@include('merchants.fixed.user_panel')
@include('merchants.fixed.user_setting_panel')       
        <!--begin::Chat Panel-->
        
        <!--end::Chat Panel-->


    
    
        <!--end::Demo Panel-->
        <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
        <!--begin::Global Config(global config for global JS scripts)-->
        <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
        <!--end::Global Config-->
        <!--begin::Global Theme Bundle(used by all pages)-->

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js"> </script>
<script src="{{ asset('adminfiles/assets/js/plugins.bundle.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/prismjs.bundle.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/widgets.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/datatables.bundle.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/buttons.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/column-visibility.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/select2.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/bootstrap-daterangepicker.min.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/image-input.js') }}"></script>
<script src="{{ asset('adminfiles/assets/js/functional.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="{{ asset('adminfiles/assets/js/bootstrap-timepicker.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googlekey.ApiKey')}}&libraries=places&callback=initAutocomplete" async defer></script>


{{-- Includable JS --}}
        @livewireScripts
        @yield('scripts')
        @stack('script')
        <!--end::Global Theme Bundle-->
    </body>
           


<script type="text/javascript">
    // ------------Show password

  $(document).ready(function() {
    // For A Delete Record Popup
     $("#password").attr('readonly', true);

     $('#password').click(function(e) {
     $("#password").attr('readonly', false);
     });


$(document).on('click','#show_password', function(){
    if( $('#password').prop('type') == 'password' )
                { 
                  $('#password').attr('type', 'text');
                  $('#eye').css('display','none');
                  $('#eyeslash').css('display','block');             
                 } 
                 else 
                 {$('#password').attr('type', 'password');
                   $('#eye').css('display','block');
                  $('#eyeslash').css('display','none');
                 }
          });
});

</script>


<!-- Update user profile -->
<script type="text/javascript">
    
        $('#updateprofile').on('click', function () {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                    url: $("#updateuserform").attr('action'),
                    method: 'PUT',
                    data: $("#updateuserform").serialize(),

                beforeSend: function () {
                    Command: toastr["info"]("Uploading Data ...", "Sending Request");
                },
                success: function (result) {
               toastr.clear();
                  if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $(".user_name").text(result.fname+' '+result.lname );
                     Command: toastr ["success"] ("Updated successfully", "Update status",{ timeOut: 1000 });                    
                    
                    }


                }
            });


        });

</script>



