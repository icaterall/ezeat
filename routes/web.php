<?php


Route::get('/', 'HomeController@index')->name('home');

/*Fixed Pages*/

Route::get('about_us', 'HomeController@Fixedpage')->name('aboutus');

Route::get('refund_policy', 'HomeController@Fixedpage')->name('refundpolicy');

Route::get('contact_us', 'HomeController@Fixedpage')->name('contact_us');

Route::get('eat_food', 'HomeController@Fixedpage')->name('eat_food');

Route::get('term_of_use', 'HomeController@Fixedpage')->name('workwithus');

Route::get('terms_of_service', 'HomeController@Fixedpage')->name('termsofservice');

Route::get('faq', 'HomeController@Fixedpage')->name('faq');

Route::get('privacy_policy', 'HomeController@Fixedpage')->name('privacy_policy');

/*End Fixed pages*/


/*Routing*/
// Registration Routes...
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
Route::get('customer_register', 'Auth\RegisterController@showRegistrationForm')->name('user.register');
Route::get('customer_login', 'Auth\RegisterController@showLoginForm')->name('user.login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logoutUser')->name('logout');
Route::get('ajax-form-register', 'Auth\RegisterController@store');
Route::post('register', 'Auth\RegisterController@register')->name('register');

// Password Reset
Route::get('emailpassword/reset', 'HomeController@showLinkRequestForm')->name('emailpassword.request');
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');
//  sending sms
Route::post('send-sms','SmsController@store');
Route::post('verify-user','SmsController@verifyContact');


//Activate after Login
Route::group(['middleware' => ['auth:web']], function () {
Route::resource('activate_customer', 'ActivateCustomerController');
Route::get('verify_account', 'ActivateCustomerController@ViewSMSverify')->name('smsverify');
Route::post('Post_verify', 'CustomerController@SMSverify')->name('PostVerify');

});

// Search and use filters in Homepage
Route::group(['prefix' => 'restaurants'], function () {
Route::get('search-initial', 'RestaurantsSearchController@initialSearch');
Route::get('search', 'RestaurantsSearchController@paginateSearch')->name('restaurantsSearch');
Route::get('update-address', 'RestaurantsSearchController@updateAddress');
Route::get('search-by-filters-ajax', 'RestaurantsSearchController@ajaxFilter');
});



// Restaurant Menu
Route::group(['prefix' => 'restaurant'], function () {
Route::get('{RestaurantID}/{restaurant_name}', 'RestaurantMenuController@getRestaurantMenu')->where('slashData','(.*)')->name('RestaurantMenu');
Route::get('pre_order', 'RestaurantMenuController@preOrder');
Route::get('open_hours', 'RestaurantMenuController@openHours');
Route::get('get_food_detail', 'CartController@getFoodDetail')->name('getFoodDetail');
Route::get('get_extra_variations', 'CartController@getExtraVariations')->name('getExtraVariations');
Route::get('get_food_price', 'CartController@getFoodPrice')->name('getFoodPrice');
Route::get('add_to_cart', 'CartController@addFoodToCart')->name('addFoodToCart');
Route::get('store_current_url', 'CartController@storeURL')->name('storeURL');
Route::get('add-to-cart', 'CartController@addToCart')->name('addToCart');
Route::resource('carts', 'CartController');
Route::get('delivery-pickup', 'RestaurantsSearchController@DeliveryPickup')->name('DeliveryPickup');
Route::get('validate_cart', 'CartController@ValidateCart')->name('ValidateCart');
});

//----------------Post Checkout --------------
Route::post('checkout/kiple_check_payment_status', 'CheckoutController@PaymentStatus')->name('PaymentStatus');

Route::post('checkout_app/kiple_check_payment_status', 'CheckoutController@AppPaymentStatus')->name('AppPaymentStatus');

//----------- View ---- FOR APP
Route::get('kiple_checkout/app_online_banking/{user_id}', 'CheckoutController@appCheckout');


Route::get('checkout/pay_order_app/{user_id}/{payment_code}', 'CheckoutController@AppOnlinePay')->name('checkout.AppOnlinePay');

// ------------App
Route::post('checkout/check_App_payment_status', 'CheckoutController@AppPaymentStatus')->name('AppPaymentStatus');

//--Notification URL
Route::post('checkout_check/update_after_payment', 'CheckoutController@NotificationURL')->name('NotificationURL');

// app success or failed
Route::get('checkout/payment/success/{order_id}','CheckoutController@successPayment')->name('checkout.success');
Route::get('checkout/payment/failed','CheckoutController@successPayment')->name('checkout.failed');


// --------------- Checkout ------------
Route::group(['middleware' => ['auth:web'],'prefix' => 'checkout'], function () {

Route::resource('customer_address', 'DeliveryAddressController');
Route::get('update_delivery_address','DeliveryAddressController@updateAddress')->name('updateAddress');
Route::get('update_order_instruction','DeliveryAddressController@updateInstruction')->name('updateInstruction');
Route::resource('checkout_payment/checkout_review', 'CheckoutController');
Route::get('applypromo', 'Admin\CouponController@applypromo')->name('applypromo');
Route::get('removepromo', 'Admin\CouponController@removepromo')->name('removepromo');
Route::get('checkout_tips', 'CheckoutController@tips')->name('checkout_tips');
Route::get('pay_order_online/{payment_code}', 'CheckoutController@OnlinePay')->name('checkout.OnlinePay');


Route::get('pay_order_cash/pay_cash', 'CheckoutController@CashPay')->name('checkout.CashPay');
});

// --------------- Customer ------------
Route::group(['middleware' => ['auth:web'],'prefix' => 'customer'], function () {
Route::get('order-placed/{restaurant_id}/{order_id}', 'CustomerController@placedOrder')->name('placedOrder');

Route::resource('customer_dashboard', 'CustomerController');
Route::get('customer_orders', 'CustomerController@OrdersArchive')->name('customer.customer_orders');
Route::get('get_order_status', 'CustomerController@getOrderStatus')->name('getOrderStatus');

});



//-------------------------------------------- DashBoard -----------
//----------------------------------------------------
//-------------------------------------------

//download pdf
Route::get('print_order_pdf/download-pdf/{order_id}/{date}','Admin\OrderController@downloadPDF')->name('downloadPDF');
// show pdf
Route::get('print-pdf/{order_id}','Admin\OrderController@printmePDF')->name('printmePDF');

    

//------- Upload images
  Route::post('uploads/upload_food_image', 'Manager\FoodController@uploadFoodImage')->name('uploadFoodImage');
  Route::post('uploads/upload_restaurant_logo', 'Admin\RestaurantController@uploadRestaurantLogo')->name('uploadRestaurantLogo');
  Route::post('uploads/upload_restaurant_banner', 'Admin\RestaurantController@uploadRestaurantBanner')->name('uploadRestaurantBanner');


// -------- View and update order without login

Route::namespace('Admin')->name('admin.')->group(function () {
  Route::post('update_order/{order_id}/{secret}/{status}', 'OrderController@updateOrder')->name('updateOrder');
Route::get('order_details/{order_id}/{secret}','OrderController@viewOrder')->name('viewOrder');
});




// Admin dashboard
Route::middleware('auth')->group(function () {

// ----------------------------- Let Merchant add ----------------
Route::namespace('Admin')->name('merchant.')->group(function () {
   Route::resource('new_restaurant','NewRestaurantController');
});



    Route::namespace('Admin')->prefix('admin_gate')->name('admin.')->group(function () {
    Route::get('switch-user-end', 'SwitchUserController@switchUserEnd');
     Route::get('/990667/update_order_payment', 'DashboardController@updatePayment');

     
      // ---- Only Finance
    Route::group(['middleware' => ['role:admin|finance']], function () {
    
  Route::resource('restaurant_payouts','RestaurantPaymentController');
  Route::get('restaurant_payouts_history','RestaurantPaymentController@paymentHistoryArchive')->name('paymentHistoryArchive');
  Route::get('pay_to_restaurant/{restaurant_id}','RestaurantPaymentController@PayToRestaurant')->name('PayToRestaurant'); 
  Route::get('get_orders_for_payment','RestaurantPaymentController@PayOrders')->name('PayOrders');
  Route::get('get_ajax_payment','RestaurantPaymentController@getAjaxPayment')->name('getAjaxPayment');      
//----------------- Rider
 Route::resource('rider_payouts','RiderPaymentController');  
  Route::get('rider_payouts_history','RiderPaymentController@paymentHistoryArchive')->name('paymentRiderHistoryArchive');
  Route::get('pay_to_rider/{rider_id}','RiderPaymentController@PayToRider')->name('PayToRider'); 
  Route::get('get_orders_for_rider_payment','RiderPaymentController@PayOrders')->name('PayRiderOrders');
  Route::get('get_ajax_rider_payment','RiderPaymentController@getAjaxPayment')->name('getAjaxRiderPayment');
 });

  Route::group(['middleware' => ['role:admin|driver']], function () {
  Route::resource('riders', 'RiderController');  
 });

      // ---- Only Admin
     Route::group(['middleware' => ['role:admin']], function () {
     Route::get('/', 'DashboardController@index')->name('dashboard');
     Route::resource('users','UserController');
     Route::resource('permissions', 'PermissionController');
     Route::resource('roles','RoleController');
      });

    // --------- Only Customer Service
    Route::group(['middleware' => ['role:admin|cservice']], function () {
    Route::resource('orders','OrderController'); 
   });
    // --------- Only Editor
    Route::group(['middleware' => ['role:admin|editor']], function () { 
    Route::resource('coupons','CouponController');
    Route::get('restaurants_users','UserController@restaurantUser')->name('restaurantUsers');
    Route::get('switch-user/{id}', 'SwitchUserController@switchUserStart');
  
 Route::get('show_commission', 'GeneralSettingController@show_commission')->name('show_commission');
 Route::post('update_commission', 'GeneralSettingController@update_commission')->name('update_commission');

   });


// ------- Manager and Editor
    Route::group(['middleware' => ['role:admin|manager|editor']], function () {
    Route::resource('restaurants','RestaurantController');
    Route::resource('cuisines','CuisineController');
    Route::resource('categories','CategoryController');
          });	    
       
     });
     
//--------Restaurant manager dashboard

    Route::group(['middleware' => ['role:admin|manager']], function () {  

    Route::namespace('Manager')->prefix('manager_gate')->name('manager.')->group(function () {


    Route::resource('/', 'DashboardController');


    Route::resource('foods', 'FoodController');
    Route::resource('sizes','VariationController');
    Route::resource('extras','ExtraController');
    Route::resource('working_days','WorkingDaysController');
    Route::resource('orders','OrderController');
    Route::post('extras/store_price_size_extra','ExtraController@storeExtraSize')->name('storeExtraSize');
    Route::get('extras/create_vary_price_extra/{food_id}','ExtraController@createNewExtra')->name('createNewVaryExtra');

    Route::get('extras/create_none_vary_size_extra/{food_id}','ExtraController@createNewExtra')->name('createNewExtra');
 
  Route::get('check_vary_price','ExtraController@VaryPriceCheck')->name('VaryPriceCheck');

//----------order functions
      });
   });



 });

