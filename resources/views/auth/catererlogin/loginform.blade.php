<body id="body">

<div class="main-body-container">
    <div style="margin-left:auto; margin-right:auto; max-width: 940px;">
        <div id="">
            <div id="ajax-feedback"></div>
            <div id="caterer-portal-signin">
                <section class="info">
                    <h2>Grow your catering business</h2>
                    <ul class="reasons">
                        <li>
                            <h3>Take catering orders directly on your website.</h3>
                            <p>SpoonGate makes it simple to capture more catering orders through your own website, with
                                an online ordering page that’s unique to your catering menu and brand, at a lower cost
                                per order.</p>
                            <a data-click-tracking-name="#">Learn more about SpoonGate Ordering</a>

                            <div class="icon-container">
                                <img alt="" src="{{asset('caterer/images/totop.svg')}}">
                            </div>
                        </li>
                        <li>
                            <h3>Boost your search ranking.</h3>
                            <p>Get more visibility and more orders through the SpoonGate marketplace with Rewards and our
                                Preferred Caterer Program.</p>
                            <a target="_blank" href="#">Learn how to boost your marketplace ranking</a>

                            <div class="icon-container">
                                <img alt="" src="{{asset('caterer/images/shopping-bag.svg')}}">
                            </div>
                        </li>
                    </ul>
                </section>

                <section class="signin">
                    <div class="dialog">
                        <h1>
                            Sign in to SpoonGate Manage
                        </h1>


                        <form class="f1" method="POST" action="{{ route('login.caterer') }}">
                            {{ csrf_field() }}

                            <div>
                                <label class="control-label" for="contact_username">Username</label>
                                <input id="username" type="text"
                                       class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                       name="username" value="{{ old('username') }}" required autofocus>
                            </div>

                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
       <strong>{{ $errors->first('username') }}</strong>
       </span>

                            @endif


                            <div>
                                <!--         <label class="control-label" for="password">
                                          Password

                                          <a class="pull-right" href="/caterer_portal/contacts/forgot_password">I've Forgotten My Password</a>
                              </label>    -->

                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required></div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
   <strong>{{ $errors->first('password') }}</strong>
        </span>
                            @endif


                            <input type="submit" name="commit" value="Sign in to SpoonGate Manage"
                                   class="btn submit-button" data-disable-with="Sign in to SpoonGate Manage">
                        </form>

                    </div>
                </section>
            </div>

        </div>

    </div>


</div>


</body>