<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">



                                        <!--begin::Header Nav-->
                                        <ul class="menu-nav">     
                                        <li class="menu-item  @if (\Request::is('admin_gate'))menu-item-active @endif">                                          
                                                <a href="/admin_gate" class="menu-link">
                                                    <span class="menu-text">Dashboard</span>
                                                </a>
                                            </li>


                                            
<!-- Users and Roles -->
  @can('admin_privilege')

                                    <li class="menu-item menu-item-submenu menu-item-rel  

                                     @if (

                                    (\Request::is('*/users')) OR (\Request::is('*/users/*'))
                                    OR (\Request::is('*/roles')) OR (\Request::is('*/roles/*'))
                                    OR (\Request::is('*/permissions')) OR (\Request::is('*/permissions/*'))

                                        ) 

                                       menu-item-active @endif" data-menu-toggle="click" aria-haspopup="true">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <span class="menu-text">Users and Roles</span>
                                                    <span class="menu-desc"></span>
                                                    <i class="menu-arrow"></i>
                                                </a>

                           <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                                    <ul class="menu-subnav">


                                                         <li class="menu-item  @if ((\Request::is('*/users')) OR (\Request::is('*/users/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                                               <span class="svg-icon menu-icon">
                                                        
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                                            <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                            <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Users</span>
                                                            </a>
                                                        </li>

                                                        <!-- Roles -->


                                                         <li class="menu-item  @if ((\Request::is('*/roles')) OR (\Request::is('*/roles/*'))) menu-item-active @endif " aria-haspopup="true" >
                                                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                                               <span class="svg-icon menu-icon">
                                                                    <!--begin::Svg Icon | path:/adminfiles/assets/media/svg/icons/General/Thunder-move.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000"></path>
                                                                            <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Roles</span>
                                                            </a>
                                                        </li>


                              <!-- Permissions -->

                                          <li class="menu-item  @if ((\Request::is('*/permissions')) OR (\Request::is('*/permissions/*'))) menu-item-active @endif " aria-haspopup="true" >
                                                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                                               
                                                                <span class="svg-icon menu-icon">
                                                                    <!--begin::Svg Icon | path:/adminfiles/assets/media/svg/icons/Communication/Dial-numbers.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="4" y="10" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="10" y="4" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="10" y="10" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="16" y="4" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="16" y="10" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="4" y="16" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="10" y="16" width="4" height="4" rx="2" />
                                                                            <rect fill="#000000" x="16" y="16" width="4" height="4" rx="2" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Permissions</span>
                                                            </a>
                                                        </li>
                                                      
                                                    </ul>
                                                </div>
                                            </li>
@endcan
<!-- End Users and Roles -->


                                            
<!-- Restaurants Main Menu --------------------------------Restaurants -->
<!-- Restaurants Main Menu --------------------------------Restaurants -->
<!-- Restaurants Main Menu --------------------------------Restaurants -->

<!-- Restaurants Main Menu --------------------------------Restaurants -->
<!-- Restaurants Main Menu --------------------------------Restaurants -->

<!-- Restaurants Main Menu --------------------------------Restaurants -->


                                    <li class="menu-item menu-item-submenu menu-item-rel  

                                     @if (
                                (\Request::is('*/restaurants')) OR (\Request::is('*/restaurants/*'))
                                OR (\Request::is('*/cuisines')) OR (\Request::is('*/cuisines/*'))
                                OR (\Request::is('*/categories')) OR (\Request::is('*/categories/*'))
                                OR (\Request::is('*/restaurants')) OR (\Request::is('*/restaurants/*'))
                                OR (\Request::is('*/coupons')) OR(\Request::is('*/coupons/*'))   
                                        ) 

                                       menu-item-active @endif" data-menu-toggle="click" aria-haspopup="true">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <span class="menu-text">Restaurants</span>
                                                    <span class="menu-desc"></span>
                                                    <i class="menu-arrow"></i>
                                                </a>

                           <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                                    <ul class="menu-subnav">
 <!-- Category -->
                                                         <li class="menu-item  @if ((\Request::is('*/restaurants')) OR (\Request::is('*/restaurants/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.restaurants.index') }}" class="menu-link">
                                                              <span class="svg-icon menu-icon">
                                                                   <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo12\dist/../src/media/svg/icons\Cooking\KnifeAndFork1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M6,3 L6.45024814,7.5024814 C6.47849172,7.78491722 6.71615552,8 7,8 C7.28384448,8 7.52150828,7.78491722 7.54975186,7.5024814 L8,3 L9,3 L9.45024814,7.5024814 C9.47849172,7.78491722 9.71615552,8 10,8 C10.2838445,8 10.5215083,7.78491722 10.5497519,7.5024814 L11,3 L12,3 L12,7.5 C12,9.43299662 10.4329966,11 8.5,11 C6.56700338,11 5,9.43299662 5,7.5 L5,3 L6,3 Z" fill="#000000"/>
        <path d="M8.5,13 L8.5,13 C9.06103732,13 9.52434927,13.4382868 9.55547002,13.9984604 L9.91679497,20.5023095 C9.96026576,21.2847837 9.36118509,21.9543445 8.57871083,21.9978153 C8.55249915,21.9992715 8.5262521,22 8.5,22 L8.5,22 C7.71631915,22 7.0810203,21.3647011 7.0810203,20.5810203 C7.0810203,20.5547682 7.08174882,20.5285212 7.08320503,20.5023095 L7.44452998,13.9984604 C7.47565073,13.4382868 7.93896268,13 8.5,13 Z" fill="#000000" opacity="0.3"/>
        <path d="M17.5,15 L17.5,15 C18.0634495,15 18.5311029,15.4354411 18.571247,15.9974587 L18.8931294,20.503812 C18.9480869,21.2732161 18.3689134,21.9414932 17.5995092,21.9964506 C17.5663922,21.9988161 17.5332014,22 17.5,22 L17.5,22 C16.7286356,22 16.1033212,21.3746856 16.1033212,20.6033212 C16.1033212,20.5701198 16.1045051,20.536929 16.1068706,20.503812 L16.428753,15.9974587 C16.4688971,15.4354411 16.9365505,15 17.5,15 Z" fill="#000000" opacity="0.3"/>
        <path d="M19,3 L19,13 L15,13 L15,7 C15,4.790861 16.790861,3 19,3 Z" fill="#000000"/>
    </g>
</svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Restaurants</span>
                                                            </a>
                                                        </li>    



 <!-- Category -->
                                                         <li class="menu-item  @if ((\Request::is('*/coupons')) OR (\Request::is('*/coupons/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.coupons.index') }}" class="menu-link">
                                                              <span class="svg-icon menu-icon">
                                                                    <!--begin::Svg Icon | path:/adminfiles/assets/media/svg/icons/Communication/Chat-check.svg-->
                                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo12\dist/../src/media/svg/icons\Shopping\Gift.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M4,6 L20,6 C20.5522847,6 21,6.44771525 21,7 L21,8 C21,8.55228475 20.5522847,9 20,9 L4,9 C3.44771525,9 3,8.55228475 3,8 L3,7 C3,6.44771525 3.44771525,6 4,6 Z M5,11 L10,11 C10.5522847,11 11,11.4477153 11,12 L11,19 C11,19.5522847 10.5522847,20 10,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,12 C4,11.4477153 4.44771525,11 5,11 Z M14,11 L19,11 C19.5522847,11 20,11.4477153 20,12 L20,19 C20,19.5522847 19.5522847,20 19,20 L14,20 C13.4477153,20 13,19.5522847 13,19 L13,12 C13,11.4477153 13.4477153,11 14,11 Z" fill="#000000"/>
                                                                <path d="M14.4452998,2.16794971 C14.9048285,1.86159725 15.5256978,1.98577112 15.8320503,2.4452998 C16.1384028,2.90482849 16.0142289,3.52569784 15.5547002,3.83205029 L12,6.20185043 L8.4452998,3.83205029 C7.98577112,3.52569784 7.86159725,2.90482849 8.16794971,2.4452998 C8.47430216,1.98577112 9.09517151,1.86159725 9.5547002,2.16794971 L12,3.79814957 L14.4452998,2.16794971 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                            </g>
                                                        </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Coupons</span>
                                                            </a>
                                                        </li>    



                                                    <!-- Cuisine -->

                                                         <li class="menu-item  @if ((\Request::is('*/cuisines')) OR (\Request::is('*/cuisines/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.cuisines.index') }}" class="menu-link">
                                                               <span class="svg-icon menu-icon">
                                                                    <!--begin::Svg Icon | path:/adminfiles/assets/media/svg/icons/Shopping/Box2.svg-->
                                                                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12.5,19 C8.91014913,19 6,16.0898509 6,12.5 C6,8.91014913 8.91014913,6 12.5,6 C16.0898509,6 19,8.91014913 19,12.5 C19,16.0898509 16.0898509,19 12.5,19 Z M12.5,16.4 C14.6539105,16.4 16.4,14.6539105 16.4,12.5 C16.4,10.3460895 14.6539105,8.6 12.5,8.6 C10.3460895,8.6 8.6,10.3460895 8.6,12.5 C8.6,14.6539105 10.3460895,16.4 12.5,16.4 Z M12.5,15.1 C11.0640597,15.1 9.9,13.9359403 9.9,12.5 C9.9,11.0640597 11.0640597,9.9 12.5,9.9 C13.9359403,9.9 15.1,11.0640597 15.1,12.5 C15.1,13.9359403 13.9359403,15.1 12.5,15.1 Z" fill="#000000" opacity="0.3"/>
        <path d="M22,13.5 L22,13.5 C22.2864451,13.5 22.5288541,13.7115967 22.5675566,13.9954151 L23.0979976,17.8853161 C23.1712756,18.4226878 22.7950533,18.9177172 22.2576815,18.9909952 C22.2137086,18.9969915 22.1693798,19 22.125,19 L22.125,19 C21.5576012,19 21.0976335,18.5400324 21.0976335,17.9726335 C21.0976335,17.9415812 21.0990414,17.9105449 21.1018527,17.8796201 L21.4547321,13.9979466 C21.4803698,13.7159323 21.7168228,13.5 22,13.5 Z" fill="#000000" opacity="0.3"/>
        <path d="M24,5 L24,12 L21,12 L21,8 C21,6.34314575 22.3431458,5 24,5 Z" fill="#000000" transform="translate(22.500000, 8.500000) scale(-1, 1) translate(-22.500000, -8.500000) "/>
        <path d="M0.714285714,5 L1.03696911,8.32873399 C1.05651593,8.5303749 1.22598532,8.68421053 1.42857143,8.68421053 C1.63115754,8.68421053 1.80062692,8.5303749 1.82017375,8.32873399 L2.14285714,5 L2.85714286,5 L3.17982625,8.32873399 C3.19937308,8.5303749 3.36884246,8.68421053 3.57142857,8.68421053 C3.77401468,8.68421053 3.94348407,8.5303749 3.96303089,8.32873399 L4.28571429,5 L5,5 L5,8.39473684 C5,9.77544872 3.88071187,10.8947368 2.5,10.8947368 C1.11928813,10.8947368 -7.19089982e-16,9.77544872 -8.8817842e-16,8.39473684 L0,5 L0.714285714,5 Z" fill="#000000"/>
        <path d="M2.5,12.3684211 L2.5,12.3684211 C2.90055463,12.3684211 3.23115721,12.6816982 3.25269782,13.0816732 L3.51381042,17.9301218 C3.54396441,18.4900338 3.11451066,18.9683769 2.55459863,18.9985309 C2.53641556,18.9995101 2.51820943,19 2.5,19 L2.5,19 C1.93927659,19 1.48472045,18.5454439 1.48472045,17.9847204 C1.48472045,17.966511 1.48521034,17.9483049 1.48618958,17.9301218 L1.74730218,13.0816732 C1.76884279,12.6816982 2.09944537,12.3684211 2.5,12.3684211 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Cuisine</span>
                                                            </a>
                                                        </li>
                                                        <!-- Category -->
                                                         <li class="menu-item  @if ((\Request::is('*/categories')) OR (\Request::is('*/categories/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.categories.index') }}" class="menu-link">
                                                               <span class="svg-icon menu-icon">
                                                                    <!--begin::Svg Icon | path:/adminfiles/assets/media/svg/icons/Communication/Clipboard-list.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"></path>
                                                                            <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
                                                                            <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"></rect>
                                                                            <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"></rect>
                                                                            <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"></rect>
                                                                            <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"></rect>
                                                                            <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"></rect>
                                                                            <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"></rect>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Categories</span>
                                                            </a>
                                                        </li>    

                                                    </ul>
                                                </div>
                                            </li>

<!-- End Restaurants -->



                                            
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
        <li class="menu-item 
                           @if (
                          
                             (\Request::is('*/orders')) OR (\Request::is('*/orders/*'))
                            ) menu-item-active @endif">
            <a href="{{ route('admin.orders.index') }}" class="menu-link">
               
                <span class="menu-text">&nbsp;Orders</span>
                <span class="menu-desc"></span>
            </a>
        </li>


<!-- End Orders -->
                                              
<!-- RIDERS ---------------------------------------------------------------- -->
<!-- RIDERS--------------------------------------------------------------------------- -->
<!-- RIDERS--------------------------------------------------------------------------- -->
<!-- RIDERS--------------------------------------------------------------------------- -->
<!-- RIDERS--------------------------------------------------------------------------- -->
<!-- RIDERS--------------------------------------------------------------------------- -->
        <li class="menu-item 
                           @if (
                          
                             (\Request::is('*/riders')) OR (\Request::is('*/riders/*'))
                            ) menu-item-active @endif">
            <a href="{{ route('admin.riders.index') }}" class="menu-link">
               
                <span class="menu-text">&nbsp;Riders</span>
                <span class="menu-desc"></span>
            </a>
        </li>               

<!-- End Rider -->
                                            
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
<!-- Orders--------------------------------------------------------------------------- -->
        


<li class="menu-item menu-item-submenu menu-item-rel  

                                     @if (
                                (\Request::is('*/restaurant_payouts')) OR (\Request::is('*/restaurant_payouts/*'))
                                OR (\Request::is('*/rider_payouts')) OR (\Request::is('*/rider_payouts/*'))
                                                                     )menu-item-active @endif" data-menu-toggle="click" aria-haspopup="true">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <span class="menu-text">Finance</span>
                                                    <span class="menu-desc"></span>
                                                    <i class="menu-arrow"></i>
                                                </a>

                           <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                                    <ul class="menu-subnav">

 <!-- Restaurant payment -->
                                                         <li class="menu-item  @if ((\Request::is('*/restaurant_payouts')) OR (\Request::is('*/restaurant_payouts/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.restaurant_payouts.index') }}" class="menu-link">
    <span class="svg-icon menu-icon">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Thunder-move.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000"></path>
                                                                            <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
  <span class="menu-text">Restaurants Pending Payments</span>
    </a>
 </li>

 <!-- Restaurant payment -->
                                                         <li class="menu-item  @if ((\Request::is('*/restaurant_payouts_history')) OR (\Request::is('*/restaurant_payouts_history/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.paymentHistoryArchive') }}" class="menu-link">
        <span class="svg-icon menu-icon">
             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"></path>
        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
        <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"></rect>
         <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"></rect>
            </g>
           </svg>
           </span>
  <span class="menu-text">Restaurant Payment History</span>
    </a>
 </li>

 <!-- Rider payout -->
                                                         <li class="menu-item  @if ((\Request::is('*/rider_payouts')) OR (\Request::is('*/rider_payouts/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.rider_payouts.index') }}" class="menu-link">
 <span class="svg-icon menu-icon">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Thunder-move.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000"></path>
                                                                            <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span class="menu-text">Drivers Pending Payments</span>
                                                            </a>
                                                        </li>

 <!-- Riders payment -->
                                                         <li class="menu-item  @if ((\Request::is('*/rider_payouts_history')) OR (\Request::is('*/rider_payouts_history/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.paymentRiderHistoryArchive') }}" class="menu-link">
        <span class="svg-icon menu-icon">
             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"></path>
        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
        <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"></rect>
         <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"></rect>
            </g>
           </svg>
           </span>
  <span class="menu-text">Riders Payment History</span>
    </a>
 </li>

                                                    </ul>
                                                </div>
                                            </li>


<!-- End Rider -->
                                            
<!-- Setting--------------------------------------------------------------------------- -->
        


<li class="menu-item menu-item-submenu menu-item-rel  

                                     @if (
                                (\Request::is('*/setting')) OR (\Request::is('*/setting/*'))
                                OR (\Request::is('*/show_commission')) OR (\Request::is('*/show_commission/*'))
                                                                     )menu-item-active @endif" data-menu-toggle="click" aria-haspopup="true">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <span class="menu-text">Setting</span>
                                                    <span class="menu-desc"></span>
                                                    <i class="menu-arrow"></i>
                                                </a>

                           <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                                    <ul class="menu-subnav">

 <!-- Restaurant payment -->
                                                         <li class="menu-item  @if ((\Request::is('*/show_commission')) OR (\Request::is('*/show_commission/*'))) menu-item-active @endif" aria-haspopup="true">
                                                            <a href="{{ route('admin.show_commission') }}" class="menu-link">
    <span class="svg-icon menu-icon">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
     <rect x="0" y="0" width="24" height="24"></rect>
      <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000"></path>
   <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
  <span class="menu-text"> Update Restaurant Commission</span>
    </a>
 </li>

 <!-- Restaurant payment -->
   
   <li class="menu-item  @if ((\Request::is('*/restaurant_payouts_history')) OR (\Request::is('*/restaurant_payouts_history/*'))) menu-item-active @endif" aria-haspopup="true">
      <a href="{{ route('admin.paymentHistoryArchive') }}" class="menu-link">
        <span class="svg-icon menu-icon">
             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"></path>
        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
        <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"></rect>
         <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"></rect>
        <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"></rect>
            </g>
           </svg>
           </span>
  <span class="menu-text"> General Setting</span>
    </a>
 </li>

                                                    </ul>
                                                </div>
                                            </li>


<!-- End Rider -->

<!-- END ALL -->

                                        </ul>
                                        <!--end::Header Nav-->
                                    </div>