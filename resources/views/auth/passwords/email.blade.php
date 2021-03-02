@extends('layouts.master') 
@section('title') Reset Password - Delivery Menu from SpoonGate 
@endsection 
@section('content')

<style type="text/css">
        .successmesaage{
        font-size: 14px;
          font-weight: 700;
          text-align: center;
          color: red;
         
      }
</style>
<ghs-login>
    <div class="u-inset-4" style="    margin-top: 80px;">
             @if ($message = Session::get('success'))
        <div class="alert alert-success">
          <p class="successmesaage">{{ $message }}</p>
        </div>
    @endif
        <div class="login-container u-section-6 u-background u-rounded u-dimension-1">
            <ghs-authentication-wizard at-authentication-wizard="true" class="u-block">
                <div class="wizardStep-container">
                    <div data-template-key="signIn" class="wizardStep u-stack-y-6">
                        <ghs-step-sign-in>
                            <h3 class="u-text-left u-stack-y-6">
                                <span>Reset Password!</span>
                            </h3>
                            
                                @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            Reset Password Error
                                            <br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                            <ghs-sign-in class="u-stack-y-3">
                               <form class="f1" role="form" method="POST" action="{{ url('password/email') }}">
                                    {{ csrf_field() }}

                                    <div class="s-row">
                                        <div class="s-col-md-12">
                                            <ghs-input class="u-block s-form-group s-col-xs-12">
                                                <label>Email</label>                                                
                                        
                                                 <input type="email" class="s-form-control" name="email"
                                                       value="{{ old('email') }}">
                                            </ghs-input>
                                        </div>
                                    </div>

                                    <div class="s-row u-stack-y-3">
                                        <div class="s-col-xs-12">
                                            <ghs-sign-in-btn>
                                                <button type="submit" class="s-btn s-btn-primary s-btn--block s-btn-img s-btn-img--left s-btn-primary--signIn"><span class="s-btn-copy">Reset Password</span></button>
                                            </ghs-sign-in-btn>
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

@endsection 
@section('script') 
@endsection
