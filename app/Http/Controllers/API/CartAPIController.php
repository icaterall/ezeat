<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\CreateCartRequest;
use Facades\App\Helpers\Helper;
use App\Http\Requests\CreateFavoriteRequest;
use Facades\App\Models\Cart;
use App\Models\Coupon;
use App\Models\Variation;
use App\Models\VariationExtra;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Criteria\Carts\CartsOfUserCriteria;
use Flash;
use Prettus\Validator\Exceptions\ValidatorException;
use Carbon\Carbon;

/**
 * Class CartController
 * @package App\Http\Controllers\API
 */

class CartAPIController extends Controller
{
    /** @var  CartRepository */
    private $cartRepository;

    public function __construct(CartRepository $cartRepo)
    {
        $this->cartRepository = $cartRepo;
    }

    /**
     * Display a listing of the Cart.
     * GET|HEAD /carts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->cartRepository->pushCriteria(new RequestCriteria($request));
            $this->cartRepository->pushCriteria(new LimitOffsetCriteria($request));

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $carts = $this->cartRepository->all();

        return $this->sendResponse($carts->toArray(), 'Carts retrieved successfully');
    }

    /**
     * Display a listing of the Cart.
     * GET|HEAD /carts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(Request $request)
    {
        try{
            $this->cartRepository->pushCriteria(new RequestCriteria($request));
            $this->cartRepository->pushCriteria(new LimitOffsetCriteria($request));
            
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $count = $this->cartRepository->count();

        return $this->sendResponse($count, 'Count retrieved successfully');
    }



   /**
     * Display a listing of the Cart.
     * GET|HEAD /carts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotal(Request $request)
    {

        try{
            $this->cartRepository->pushCriteria(new CartsOfUserCriteria(auth()->id()));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $order_type = 0;
       if($request->order_mode != 1) 
        $order_type = 0;
        else $order_type = 1;

    
     $cart = Cart::where('user_id',auth()->id())->update(['isdelivery' => $order_type]);
    
     $data = Cart::appCart(auth()->id());

    
        return $this->sendResponse($data, 'Cart total retrieved successfully');
    }


    /**
     * Display the specified Cart.
     * GET|HEAD /carts/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Cart $cart */
        if (!empty($this->cartRepository)) {
            $cart = $this->cartRepository->findWithoutFail($id);
        }

        if (empty($cart)) {
            return $this->sendError('Cart not found');
        }

        return $this->sendResponse($cart->toArray(), 'Cart retrieved successfully');
    }
    /**
     * Store a newly created Cart in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

       if($input['variation_id'] == 0)
        $input['variation_id'] = null;
        $cart = Cart::where('user_id',auth()->id())->first();
        if($cart != null)
         $coupon_id = null;



      if($input['date'] == 0)
      {   
        $mytime = Carbon::now();
        $order_time  = date("h:i a", strtotime($mytime));
        $order_date  = date("Y-m-d ", strtotime($mytime));
        $order_type = 'asap'; 
      } else 
      {
        $order_time  = $input['time'];
        $order_date =  $input['date'];
        $order_type = 'preorder'; 
      }



        try {
            if(isset($input['reset']) && $input['reset'] == '1'){
                // delete all items in the cart of current user
                $this->cartRepository->deleteWhere(['user_id'=> $input['user_id']]);
            }
           

            $cart = $this->cartRepository->create($input);
          
            if($request->order_mode == 1)
             Cart::where('user_id',$cart->user_id)->update([
                'isdelivery'=> 1,
                'time'=> $order_time,
                'date'=> $order_date,
                'order_type'=> $order_type

            ]);

             else 
                Cart::where('user_id',$cart->user_id)->update([
                'isdelivery'=> 0,
                'time'=> $order_time,
                'date'=> $order_date,
                'order_type'=> $order_type
               ]);


            if($request->variation_id != null)
            $this->updateVariation($input,$cart);
           

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($cart->toArray(), __('lang.saved_successfully',['operator' => __('lang.cart')]));
    }

    /**
     * Update the specified Cart in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateVariation($input,$cart)
    {
                 

                    if($input['variation_id'] != null)
                        
            {
                $cart->variations()->attach($input['variation_id']);
               

                if($input['extras'] != null)
                {

                    $extraVariationIds = [];
                   foreach ($input['extras'] as $key => $extra) {

                    $get_variation = VariationExtra::where('extra_id',$extra)->where('variation_id',$input['variation_id'])->first();
                    
                    if($get_variation != null)
                    {
                       $extraVariationIds[] = $get_variation->id;
                    }
                   }

                   if(!empty($extraVariationIds))
                   {
                    $cart->extra_variations()->attach($extraVariationIds);
                   }
                }


            }

    }
    public function update($id, Request $request)
    {


        $cart = $this->cartRepository->findWithoutFail($id);

        if (empty($cart)) {
            return $this->sendError('Cart not found');
        }
        

        $input = $request->all();
       if($input['variation_id'] == 0)
        $input['variation_id'] = null;



    if($input['time'] == 'now')
      {   
        $mytime = Carbon::now();
        $order_time  = date("h:i a", strtotime($mytime));
        $order_date  = date("Y-m-d ", strtotime($mytime));
        $order_type = 'asap'; 
      } else 
      {
        $order_time  = $input['time'];
        $order_date =  $input['date'];
        $order_type = 'preorder'; 
      }

        try {
//            $input['extras'] = isset($input['extras']) ? $input['extras'] : [];
            $cart = $this->cartRepository->update($input, $id);
            
            if($request->order_mode == 1)
             $cart->update([
                'isdelivery'=> 1,
                'time'=> $order_time,
                'date'=> $order_date,
                'order_type'=> $order_type
            ]);

             else 
               $cart->update([
                'isdelivery'=> 0,
                'time'=> $order_time,
                'date'=> $order_date,
                'order_type'=> $order_type
               ]);


            if($request->variation_id != null)
            $this->updateVariation($input,$cart);

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($cart->toArray(), __('lang.saved_successfully',['operator' => __('lang.cart')]));
    }

    /**
     * Remove the specified Favorite from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cart = $this->cartRepository->findWithoutFail($id);

        if (empty($cart)) {
            return $this->sendError('Cart not found');

        }

        $cart = $this->cartRepository->delete($id);

        return $this->sendResponse($cart, __('lang.deleted_successfully',['operator' => __('lang.cart')]));

    }

}
