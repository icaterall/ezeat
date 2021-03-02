@extends('layouts.master') 
@section('title') Sign Up - Delivery Menu from {{ __('config.app.name')}} 
@endsection 
@section('content')


  <div class="inner-wrapper">
    <div class="container-fluid no-padding">
      <div class="row no-gutters overflow-auto">
        <div class="col-md-6">
          <div class="main-banner">
            <img src="/assets/img/banner-1.jpg" class="img-fluid full-width main-img" alt="banner">
        
          </div>
        </div>
    


        <div class="col-md-6">
          <div class="section-2 user-page main-padding">
            <div class="login-sec">
              <div class="login-box">
                   <form class="f1" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
                  <h4 class="text-light-black fw-600">Create your account</h4>
                  <div class="row">
                    
                    <div class="col-12">
                      <div class="form-group">
                        <label class="text-light-white fs-14">Name</label>
                        <input type="text" name="name" class="form-control form-control-submit" placeholder="Your Name" required>
                         @if ($errors->has('name'))
                        <span class="help-block">
                            <strong style="color: red;">{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label class="text-light-white fs-14">Mobile</label>
                        <input type="text" name="mobile" class="form-control form-control-submit" placeholder="Your Mobile" required>
                         @if ($errors->has('mobile'))
                        <span class="help-block">
                            <strong style="color: red;">{{ $errors->first('mobile') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label class="text-light-white fs-14">Email</label>
                        <input type="email" name="email" class="form-control form-control-submit" placeholder="Email I'd" required>
                          @if ($errors->has('email'))
                        <span class="help-block">
                            <strong style="color: red;">{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="form-group">
                        <label class="text-light-white fs-14">Password (8 character minimum)</label>
                        <input type="password" id="password-field" name="password" class="form-control form-control-submit" value="password" placeholder="Password" required>
                           @if ($errors->has('password'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        <div data-name="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></div>
                      </div>
                     
                      <div class="form-group">
                        <button type="submit" class="btn-second btn-submit full-width">Create your account</button>
                      </div>
                      <div class="form-group text-center"> <span>or</span>
                      </div>
                    
                      

                    
                    </div>
                  </div>
                </form>  

                <div class="form-group">
                        <a href="{{url('/redirect')}}">
                        <button type="submit" class="btn-second btn-facebook full-width">
                          <img src="/assets/img/facebook-logo.svg" alt="btn logo">Continue with Facebook</button>
                      </a>
                </div>

                    <div class="form-group text-center">
                        <p class="text-light-black mb-0">Have an account? <a href="{{ route('user.login') }}">Sign in</a>
                        </p>
                      </div> <span class="text-light-black fs-12 terms">By creating your Quickmunch account, you agree to the <a href="#"> Terms of Use </a> and <a href="#"> Privacy Policy.</a></span>
              </div>
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
                @endsection 
                @section('scripts') 
                @endsection
