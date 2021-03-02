
        @if (Auth::guest())
        
                    @if ((Route::current()->getName() != ('user.register')) AND (Route::current()->getName() != ('user.login')))
                    <a
                        href="{{ route('user.login') }}"
                        at-nav-sign-in="true"
                        class="s-btn s-btn--small s-btn-secondary mainNav-transition s-btn-secondary u-stack-x-3"
                        type="button"
                        tabindex="0"
                        style="padding-top: 8px; padding-bottom: 8px;"
                    >
                        <span>Sign in</span>
                    </a>
                    @endif
              

@else
<div class="user-details p-relative">
                                <a href="#" class="text-light-white fw-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-stroke-container" width="24" height="24" viewBox="0 0 24 24">
                                    <g fill="none" fill-rule="evenodd">
                                        <circle cx="12" cy="12" r="12" fill="#841C7D" fill-rule="nonzero"></circle>
                                        <path fill="#FFF" fill-rule="nonzero" d="M13.1818252 12.6666667C15.366281 12.6666667 17.1649879 14.3335701 17.3176726 16.4681904L17.3252836 16.6080555 17.3333337 17.0416667C17.3333337 17.1848516 17.2285728 17.3039382 17.0904223 17.3286342L17.0371901 17.3333333 6.96281056 17.3333333C6.81742783 17.3333333 6.69651331 17.2301562 6.67143827 17.0940941L6.666667 17.0416667 6.666667 16.75C6.666667 14.5418198 8.44636147 12.7430258 10.670143 12.6690344L10.8126768 12.6666667 13.1818252 12.6666667zM12.0000003 6C13.6568546 6 15.0000003 7.34314575 15.0000003 9 15.0000003 10.6568543 13.6568546 12 12.0000003 12 10.3431461 12 9.00000033 10.6568543 9.00000033 9 9.00000033 7.34314575 10.3431461 6 12.0000003 6z"></path>
                                    </g>
                                </svg> <span>Hi, {{ substr(strip_tags(Auth::user()->name), 0, 6) }}..</span>
                                </a>
                                <div class="user-dropdown">
                                    <ul>
                                        <li>
                                            <a href="{{route('customer.customer_orders')}}">
                                                <div class="icon"><i class="flaticon-rewind"></i>
                                                </div> <span class="details">My Orders</span>
                                            </a>
                                        </li>
                                         <li>
                                            <a href="{{route('customer_dashboard.index')}}">
                                                <div class="icon"><i class="flaticon-user"></i>
                                                </div> <span class="details">Account</span>
                                            </a>
                                        </li>
                                        

                                        @hasrole('admin')
                                        <li>
                                            <a href="{{ route('admin.dashboard') }}">
                                                <div class="icon"><i class="flaticon-breadbox"></i>
                                                </div> <span class="details">General Admin</span>
                                            </a>
                                        </li> 
                                        @endhasrole  
                                        @hasrole('manager')
                                        <li>
                                            <a href="{{ route('manager.index') }}">
                                                <div class="icon"><i class="flaticon-takeaway"></i>
                                                </div> <span class="details">Restaurant Dashboard </span>
                                            </a>
                                        </li>
                                        @endhasrole



                                        
                      @if (Session::has('switch_user_original'))
                                        <li>
                                            <a href="/admin_gate/switch-user-end">
                                                <div class="icon"><i class="flaticon-board-games-with-roles"></i>
                                                </div> <span class="details">Login as Admin</span>
                                            </a>
                                        </li>
                        @endif                


                                    </ul>
                                    <div class="user-footer"> <span class="text-light-black">Not {{ substr(strip_tags(Auth::user()->name), 0, 10) }}..?</span> <a href="{{url('/logout')}}">Sign Out</a>
                                    </div>
                                </div>
                            </div>
@endif



