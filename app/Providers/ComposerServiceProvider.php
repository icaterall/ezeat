<?php
namespace App\Providers;

use Illuminate\Support\{
    Facades\Config,
    ServiceProvider,
    Facades\View
};
use Facades\App\Models\{
    Cart,
    VariationExtra
};
use Facades\App\Helpers\Helper;
use Auth;
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //nav-----------------------------------------------------------------------------------------------------------
        View::composer(['admin.include.whatsapp','admin.include.contacts','footer.archive','restaurant.details','store-search.archive'], function ($view){
            return $view
                ->with('privacy', Helper::getKeyValue('privacy'))
                ->with('term_of_use', Helper::getKeyValue('term_of_use'))
                ->with('customer_faq', Helper::getKeyValue('customer_faq'))
                ->with('refund_policy', Helper::getKeyValue('refund_policy'))
                ->with('contact', Helper::getKeyValue('contact'))
                ->with('cs_email', Helper::getKeyValue('cs_email'))
                ->with('hq_phone', Helper::getKeyValue('hq_phone'))
                ->with('contact', Helper::getKeyValue('contact'))
                
                ->with('mobile_sms', Helper::getKeyValue('mobile_sms'));
        });



 

        //footer------------------------------------------------------------------------------------------------------
        View::composer(['cart.cart_badge','footer.archive','restaurant.details','store-search.archive','homepage.index'], function($view){
            if(Auth::check())
            {
                return $view
                            ->with('carts',Cart::GetFinal(Auth::user()->id));
            } else {


                return $view
                            ->with('carts', Cart::where('user_id',0)->get()); 
            }
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}