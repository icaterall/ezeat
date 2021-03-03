@extends('layouts.master')
@section('title', 'Order Food Online Near You | ' . __('config.app.url') )
@section('content')

    <section class="banner-1 p-relative">
        <img src="/assets/img/banner-5.jpg" class="img-fluid full-width" alt="Banner">
        <div class="transform-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="content-wrapper bg-white padding-20">
                            <div class="content-box padding-tb-10">
                                <h2 class="text-light-black fw-700">Download EZEAT App</h2>
                           

                    <div class="hero-section hero-banner-wrapper full">
                        <div
                            class="b-lazy hero-section-image b-loaded" style="background-image: url('/csfiles/img/back.jpg');"
                        ></div>

                        <div class="hero-section-content">
                            <div class="hero-section__tracking-card fix-margin-collapse">
                                <div id="tracking-card-react-root"></div>
                            </div>


                           
                          
                     <div class="row">
                        <div class="col-xl-5">
                            <a target="_blank" href="{{ __('config.app.googleplay_url')}}">
                                <img src="/assets/img/playstore.png" class="img-fluid">
                            </a>
                        </div>         
                 
                    <div class="col-xl-5">
                        <a target="_blank" href="{{ __('config.app.appstore_url')}}">
                                <img src="/assets/img/appstore.png" class="img-fluid" alt="app logo">
                            </a>
                        
                    </div>
                </div>

                                
                            </div>
                        </div>
                    </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay overlay-bg"></div>
    </section>

    <!-- Explore collection -->
 <section class="section-padding how-it-works bg-light-theme">
        <div class="container">
            <div class="section-header-style-2">
                <h6 class="text-light-green sub-title">Our Process</h6>
                <h3 class="text-light-black header-title">How Does It Work</h3>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="how-it-works-box arrow-1">
                        <div class="how-it-works-box-inner"> <span class="icon-box">
                <img src="assets/img/001-search.png" alt="icon">
                <span class="number-box">01</span>
                            </span>
                            <h6>Search</h6>
                            <p>Find your favorite restaurant</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="how-it-works-box arrow-2">
                        <div class="how-it-works-box-inner"> <span class="icon-box">
                <img src="assets/img/004-shopping-bag.png" alt="icon">
                <span class="number-box">02</span>
                            </span>
                            <h6>Select</h6>
                            <p>Add your favorite food to the cart</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="how-it-works-box arrow-1">
                        <div class="how-it-works-box-inner"> <span class="icon-box">
                <img src="assets/img/002-stopwatch.png" alt="icon">
                <span class="number-box">03</span>
                            </span>
                            <h6>Order</h6>
                            <p>Select when to receive your order</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="how-it-works-box">
                        <div class="how-it-works-box-inner"> <span class="icon-box">
                <img src="assets/img/003-placeholder.png" alt="icon">
                <span class="number-box">04</span>
                            </span>
                            <h6>Enjoy</h6>
                            <p>Wonderful! Your food is on its way to you</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

@endsection