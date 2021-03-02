<div class="outerWrapper clearfix">
    <div class="innerWrapper clearfix">
        <div class="u-hidden" id="static-page-validation">
           
        </div>
        <div class="s-container s-container-" id="eBCaoLXGMIoOFa5nYJNlE">
            <div class="s-row" style="margin-top: 70px;">
                <div class="s-panel s-col-xs-12">
                    

                    @if (\Request::is('about_us'))

                        @if($about != "")
                        <div class="s-panel-heading"><h1>About Us</h1>
                        </div>
                    <div class="s-panel-body">

                            {!! $about !!}

                        </div>

                         @endif


                        <div class="s-panel-body">
                            @include('fixedpages.include.contacts')
                            <br>
                            <br>
                          </div>  


                    @elseif (\Request::is('refund_policy'))

                        @if($refund_policy!= "")
                        <div class="s-panel-heading"><h1>Refund policy</h1>
                        </div>
                    <div class="s-panel-body">

                            {!! $refund_policy !!}

                        </div>

                         @endif


                        <div class="s-panel-body">
                            @include('fixedpages.include.contacts')
                            <br>
                            <br>
                          </div>  


                    @elseif (\Request::is('contact_us'))

                        @if($contact!="")
                        
                         <div class="s-panel-heading"><h1>Contact Us</h1>
                        </div>
                         <div class="s-panel-body">
                          {!! $contact !!}
                        </div>
                         @endif



                        <div class="s-panel-body">
                            @include('fixedpages.include.contacts')
                            <br>
                            <br>
                          </div>  


                    @elseif(\Request::is('term_of_use'))

                        @if($term_of_use!= "")

                         <div class="s-panel-heading"><h1>Terms of Use</h1>
                        </div>
                         <div class="s-panel-body">
                          {!! $term_of_use !!}
                        </div>
                        

                            
                        @endif
                        <div class="s-panel-body">
                            @include('fixedpages.include.contacts')
                            <br>
                            <br>
                          </div>  


                    @elseif(\Request::is('privacy_policy'))

                        @if($privacy!= "")
                          <div class="s-panel-heading"><h1>Privacy Policy</h1>
                        </div>
                         <div class="s-panel-body">
                          {!! $privacy !!}
                        </div>

                        @endif
                        <div class="s-panel-body">
                            @include('fixedpages.include.contacts')
                            <br>
                            <br>
                          </div>  

                    @elseif(\Request::is('faq'))

                        @if($customer_faq!= "")
                          <div class="s-panel-heading"><h1>FAQ</h1>
                        </div>
                         <div class="s-panel-body">
                           {!! $customer_faq!!}
                        </div>

                           
                        @endif
                        <div class="s-panel-body">
                            @include('fixedpages.include.contacts')
                            <br>
                            <br>
                          </div> 
                    @endif






                
                </div>
            </div>
        </div>
        <dashi-imf-placement class="ng-isolate-scope"><div></div></dashi-imf-placement>
    </div>
</div>

