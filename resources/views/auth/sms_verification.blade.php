@extends('layouts.master') 
@section('title') Activate your account - Delivery Menu from SpoonGate 
@endsection 
@section('content')

<ghs-login>
    <div class="u-inset-4" style="margin-top: 80px;">
 
 @if ($message = Session::get('success'))
        <div class="alert session_alert alert-success">
          <p class="successmesaage">{{ $message }}</p>
        </div>
    @endif


        <div class="login-container u-section-6 u-background u-rounded u-dimension-1">
            <ghs-authentication-wizard at-authentication-wizard="true" class="u-block">
                <div class="wizardStep-container">

                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>




                <div data-template-key="signIn" class="wizardStep u-stack-y-6">
                        <ghs-step-sign-in>
                            
                            <h4 class="modal__h4 text-center">
                                Verify
                            </h4>

                            <ghs-sign-in class="u-stack-y-3">
                                <form id="submit_sms_code_form" action="/" >
                                    {{ csrf_field() }}

                                    <div class="row">




    <div class="input-box js-input-box contact-information-mobile-number-wrap">
        
        <input id="mobile" name="mobile" autocomplete="off" value="@if(strlen(Auth::user()->mobile)<6)@else {{ Auth::user()->mobile}} @endif" />
        <span class="hidden sms-error-message modal-error-message input-message error error_phone"></span>

        <label for="contact-information-mobile-number">Mobile Number</label>
    </div>


@if(strlen(Auth::user()->mobile) > 6)

                                         <label class="modal-verify-sms__form__label">
        <span class="modal-verify-sms__form__wrapper">
            <div class="input-box js-input-box">
                <input type="text" id="activation_code" name="activation_code" autocomplete="off" />
                <span class="hidden sms-error-message modal-error-message input-message error error_code"></span>
                <label for="verification-code-input">Please enter your code</label>
            </div>
        </span>
    </label>

    @endif
                                    </div>

@if(strlen(Auth::user()->mobile) > 6)
<div id="hide_counter" class="s-col-md-12">
    <p style=" text-align: center;">Didn't receive it?</p>

    <p style="color: #e62434;
    font-weight: 700; text-align: center;  touch-action: manipulation;"><span id="timer_down">
    </span>
    </p>
</div>
   @endif  

@if(strlen(Auth::user()->mobile) > 6)
                                    <div class="s-row u-stack-y-3">
                                        <div class="s-col-xs-12">
                                            <ghs-sign-in-btn>
                                                <button data-thisbtn="verifycode" id="verifybtn" type="button" class="get_code s-btn s-btn-primary s-btn--block s-btn-img s-btn-img--left s-btn-primary--signIn"><span class="s-btn-copy">Verify</span>
                                                </button>
                                            </ghs-sign-in-btn>
                                        </div>
                                    </div>
@endif


<div class="s-row u-stack-y-3">
     <div  class="s-col-xs-12" id="show_send_code_btn" @if(strlen(Auth::user()->mobile) > 6) style="display: none" @endif> 


<button id="get_code" type="button" data-thisbtn="getcode" class="get_code s-btn btn btn-success s-btn--block s-btn-img s-btn-img--left s-btn-primary--signIn">Get Activation Code
</button>
    </div>
</div>


                                </form>
                            </ghs-sign-in>
                        </ghs-step-sign-in>
                    </div>
                </div>
            </ghs-authentication-wizard>
        </div>
    </div>
</ghs-login>

<input hidden="" id="first_time" @if(strlen(Auth::user()->mobile) < 6) value="1" @endif>



@endsection 
@section('scripts') 

 <script src="/csfiles/js/sms_setting.js"></script>

@if(strlen(Auth::user()->mobile) > 6)

<script src="/csfiles/js/sms_counter.js"></script>

@endif


@endsection
