<!DOCTYPE HTML>
<html>

<head>
  <style type="text/css">

  .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(/assets/img/loading.svg) 50% 50% no-repeat rgb(46 45 44 / 71%);
}
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="#">
    <meta name="description" content="#">
    <title>@yield('title')</title>
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="#">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="#">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="#">
    <link rel="apple-touch-icon-precomposed" href="#">
    <link rel="shortcut icon" href="/assets/img/favicon.png">
       

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="/assets/css/font-awesome.css" rel="stylesheet">
    <!-- Flaticons -->
    <link href="/assets/css/font/flaticon.css" rel="stylesheet">
    <!-- Swiper Slider -->
    <link href="/assets/css/swiper.min.css" rel="stylesheet">
    <!-- Range Slider -->
    <link href="/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
    <!-- magnific popup -->
    <link href="/assets/css/magnific-popup.css" rel="stylesheet">
    <!-- Nice Select -->
    <link href="/assets/css/nice-select.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <!-- Custom Responsive -->
    <link href="/assets/css/responsive.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- place -->

  
</head>


<body class="sidefix">
         @include('header.header') 
         <div class="main-sec"></div>  
         @yield('content')
         @include('footer.archive') 

<div class="loader"></div>
    <!-- modal boxes -->
    <div class="modal fade" id="address-box">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   
                </div>
                <div class="modal-body">
                    <div class="">
                        <input type="text" class="form-control" placeholder="Enter a new address">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Place all Scripts Here -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Popper -->
    <script src="/assets/js/popper.min.js"></script>
    <!-- Bootstrap -->
    <script src="/assets/js/bootstrap.min.js"></script>
    <!-- Range Slider -->
    <script src="/assets/js/ion.rangeSlider.min.js"></script>
    <!-- Swiper Slider -->
    <script src="/assets/js/swiper.min.js"></script>
    <!-- Nice Select -->
    <script src="/assets/js/jquery.nice-select.min.js"></script>
    <!-- magnific popup -->
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googlekey.ApiKey')}}&libraries=places&callback=initAutocomplete" async defer></script>
    <script src="/assets/js/googleaddress.js"></script>
    <!-- sticky sidebar -->
    <script src="/assets/js/sticksy.js"></script>
    <!-- Munch Box Js -->
    <script src="/assets/js/quickmunch.js"></script>
<script src="/assets/js/jquery.disable-autofill.js"></script>

    
    <!-- /Place all Scripts Here -->

    <script type="text/javascript">
            $('.loader').show();

            // show the icon when the page is unloaded
            $(window).on('beforeunload', function(event) {
              $('.loader').show();
            });

            // hide the icon when the page is fully loaded
            $(window).on('load', function(event) {
              $('.loader').hide();
            });
    </script>


<script type="text/javascript">

  $('input[autofill="off"]').disableAutofill();

</script>

        @yield('scripts')
        @stack('script')
        <!--end::Global Theme Bundle-->
    </body>
    </html>

           

