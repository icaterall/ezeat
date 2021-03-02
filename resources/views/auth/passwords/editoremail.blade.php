@extends('auth.template')

@section('local_content')


<div uk-height-viewport="offset-top: true; offset-bottom: true" class="uk-flex uk-flex-middle">


<div class="uk-width-2-3@m uk-width-1-2@s uk-margin-auto  border-radius-6 ">


<div class="uk-child-width-1-2@m uk-background-grey uk-grid-collapse" uk-grid>


          <div class="uk-text-middle uk-margin-auto-vertical uk-text-center uk-padding-small uk-animation-scale-up">


          <p> <i class="fas fa-user-lock uk-text-white" style="font-size:60px"></i> </p>

          <h1 class="uk-text-white uk-margin-small"> SpoonGate </h1>
    

           <h5 class="uk-margin-small uk-text-muted uk-text-bold uk-text-wrap">SpoonGate makes it simple to capture more catering orders through your own website. </h5>
             </div>
 

<div class="uk-card-default uk-padding uk-card-small">
<h2 class="uk-text-bold"> Reset Password </h2>
<p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom"> Reset Editor Password</p>                       

<!--Login tab tab -->

<form method="POST" action="{{ url('cspassword/email') }}">
   @csrf

@if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
@endif

<div class="form-group">

<div class="col-sm-12">
      <label>Email address </label>
       <span class="required"> * </span>
  <div class="uk-inline uk-margin-small-bottom">     
<span class="uk-form-icon"><i class="far fa-user icon-medium"></i></span> 
<input class="uk-input uk-form-width-large form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="name@example.com" type="email" id="email" name="email" value="{{ old('email') }}">

 @if ($errors->has('email'))
<span style="color: red">{{ $errors->first('email') }}</span>
@endif 
</div>
</div>

</div>





<div class="col-sm-12">
</div>


  

<div class="uk-margin uk-text-small"> 
                                   

 <span class="uk-text-small">&nbsp;</span>


 </div>


<div class="uk-flex-middle" uk-grid>

<div class="uk-width-expand@m">     
  
  <input class="uk-button uk-button-success" type="submit" class="button" value="Reset Password">  
  
  </div>



    </form>

  </div>  
    </div>
</div>
</div>

    



@endsection