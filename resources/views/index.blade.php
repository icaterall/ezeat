@extends('layouts.master')
@section('title', 'Order Food Online Near You')
@section('content')
<!-- saved from url=(0018)https://carryfy.co/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/default.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/carousel.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="/assets/css/font-awesome.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font.css">  
    <link rel="stylesheet" href="/assets/css/CARRYFY.css">  
 <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <!-- place -->

    <link rel="shortcut icon" type="image/png" href="/assets/img/favicon.png">
    <title>Carryfy</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top top-navigation">
      <div class="container">
        <a class="navbar-brand mr-auto" href="/index">
          <img class="mr-logo" src="/assets/img/listo-logo.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mr-navbars" aria-controls="mr-navbars" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mr-navbars">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/index">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/about">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/forbusiness">For Business</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact">Get in Touch</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto right-nav">
            <li class="nav-item">
              <a class="mr-btn btn btn-gradient white-border btn-radius-50 btn-md px-3 mr-font-medium" href="/signup">Become a courier 📦</a>
            </li>
            <!--<li class="nav-item d-flex justify-content-center">
              <div class="btn-group">
                <button class="dropdown-toggle lan-box mr-font-medium" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  عربى <span><img class="lang-img" src="images/saudi-arabian-flag.svg"></span>
                </button>
                <ul class="dropdown-menu lan-box-drop">
                  <li class="dropdown-item">English<span><img class="lang-img" src="images/english.svg"></span></li>
                  <li class="dropdown-item">عربى<span><img class="lang-img" src="images/saudi-arabian-flag.svg"></span></li>
                </ul>
              </div>
            </li>-->
          </ul>
        </div>
      </div>
    </nav>
  
    <main>
      <section class="mr-hero hero">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-8">
              <h1 class="display-2 text-white mr-hero-h1">Anything from anywhere in your city</h1>
              <div class="row download-link">
                <div class="col-12">
                  <a href="#" target="_blank"><img class="img-fluid" src="/assets/img/hero-appstore.png"></a>
                  <a href="#" target="_blank">
                    <img class="img-fluid" src="/assets/img/hero-playstore.png">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
        
      <!-- What is CARRYFY-->
      <section class="section-padding-bottom"> 
        <div class="container">
          <div class="row">
            <div class="col-12 ">
              <h2 class="display-3 text-center section-title mr-font-medium"> What is CARRYFY?</h2>
              <p class="text-center">CARRYFY is one of the largest delivery platform in the region. CARRYFY's unique on-demand experience earned it the highest user ratings amongst all the other large delivery platforms both in Apple’s App Store and Google's Play store. CARRYFY provides a true order anything from anywhere experience, only possible by our huge fleet of registered on-demand couriers anything from anywhere with a huge fleet of registered couriers.</p>
            </div>
            <div class="col-12 d-flex justify-content-center mb-4">
              <a class="btn btn-mr-gradient btn-md mr-font-medium mb-3 mr-home-btn" href="https://carryfy.co/about">Know more about us</a>
            </div>
          </div>

        </div>
      </section>

      <!-- CTA -->
      <section class="section-padding-bottom"> 
        <div class="container-fluid">
          <div class="row">
            <div class="cta-wrapper d-flex align-items-center">
              <div class="container cta-inner">
                <div class="col-12 ">
                  <h2 class="display-3 text-center text-white mr-font-medium"> Reach Millions of Customers</h2>
                  <p class="text-white text-center"><span class="mr-font-medium">CARRYFYfor Business</span> provides your business an access to a huge user base, whether you want to transform to on-demand eCommerce, or simply looking for an additional channel, CARRYFYis always there to help!</p>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <a class="btn btn-mr-gradient btn-md mr-font-medium mr-home-btn" href="https://carryfy.co/forbusiness">Learn more</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- How did we do it -->
      <section class="">
        <div class="container">
          <div class="row">
            <div class="col-12 ">
              <h2 class="display-3 text-center section-title mr-font-medium"> How Do We Do It</h2>
              <p class="text-center col-12 col-md-10 col-lg-8 mx-auto">By building an intuitive product that mimics and facilitates generic service fulfillment, so the simple answer was to provide users with three things.</p>
            </div>
          </div>
          <div class="row text-center mt-4">
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <img class="img-fluid" src="/assets/img/free-chat.png">
              </div>
              <h4>Personalized Delivery Experience</h4>
              <p>Control your delivery experiences in real-time through an open chat with your courier</p>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <img class="img-fluid" src="/assets/img/flexible-bidding.png">
              </div>
              <h4>Flexible Bidding System</h4>
              <p>Service prices are determined beforehand through our bidding system, giving customers the freedom to choose from multiple service providers</p>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <img class="img-fluid" src="/assets/img/place.png">
              </div>
              <h4>Integrated Map Solution</h4>
              <p>Pick anywhere on the map for your delivery order, and track your order in real-time</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Horizontal Border -->
      <section class="container">
        <hr>
      </section>

      <!-- Testimonials -->
      
    </main>
    
    <!-- Footer  -->
    <footer class="pt-5">
      <section class="footer-wrap">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-6 col-lg-4">
              <h6 class="mt-3 mb-3 footer-col-heading">Site Menu</h6>
              <ul class="list-unstyled footer-menu">
                <li><a href="/index" class="">Home</a></li>
                <li><a href="/about" class="">About us</a></li>
                <li><a href="/forbusiness" class="">For Business</a></li>
                <li><a href="/contact" class="">Get in Touch</a></li>
              </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
              <h6 class="mt-3 mb-3 footer-col-heading">Contacts</h6>
              <address class="text-white">
                <p class="address float-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i>kuala lumbur, Malaysia</p>
                <p class="email float-icon"><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:inquiries@carryfy.co" target="_blank">inquiries@carryfy.co</a></p>
              </address>
            </div>


            <div class="col-12 col-sm-6 col-lg-4">
              <h6 class="mt-3 mb-3 footer-col-heading">Follow us</h6>
              <div class="social-media">
               <a target="_blank" href="{{ __('config.app.fb_url')}}"><i class="fab fa-facebook-f"></i></a>
                            <a  target="_blank" href="{{ __('config.app.twitter_url')}}"><i class="fab fa-twitter"></i></a>
                           <a  target="_blank" href="{{ __('config.app.insta_url')}}"><i class="fab fa-instagram"></i></a>
                           <a  target="_blank" href="{{ __('config.app.youtube_url')}}"><i class="fab fa-youtube"></i></a>
                            
              </div>
              <div class="download-link">
                <a href="" target="_blank"><img class="" src="/assets/img/footer-appstore.png"></a>
                <a href="" target="_blank"><img class="" src="/assets/img/footer-playstore.png"></a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Horizontal Border -->
        <div class="container">
          <hr>
        </div>

        <!-- Footer bottom -->
        <div class="container pb-3">
          <div class="row align-items-center">
            <div class="col-12 col-lg-5 col-sm-6">
              <p class="mb-0 copyright">© 2021 CARRYFY Inc.</p>
            </div>
            <div class="footer-bottom-menu col-12 col-lg-7 col-sm-6">
              <ul class="list-unstyled text-center text-lg-right mb-0">
                <li class="list-inline-item"><a href="/privacy_policy" target="_blank">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="/terms" target="_blank">Terms of Use</a></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
    </footer>

  <script src="/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js.download"></script>

    <script src="/assets/js/owl.carousel.js.download"></script>
    
    <script src="/assets/js/mr-custom.js.download"></script>

</body></html>