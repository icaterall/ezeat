<?php
/**
 * File name: OrderAPIController.php
 * Last modified: 2020.06.11 at 16:10:52
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

namespace App\Http\Controllers\API;

use Facades\App\Helpers\Helper;
use App\Criteria\Orders\OrdersOfStatusesCriteria;
use App\Criteria\Orders\OrdersOfUserCriteria;
use App\Events\OrderChangedEvent;
use App\Http\Controllers\Controller;
use Facades\App\Models\Order;
use App\Notifications\AssignedOrder;
use App\Notifications\NewOrder;
use App\Notifications\StatusChangedOrder;
use App\Repositories\CartRepository;
use App\Repositories\FoodOrderRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Support\Carbon;
use Facades\App\Models\OrderOffer;
use Facades\App\Services\Payment\SaveOrderToCart;
use App\Jobs\sendNewOrderEmail;
use Facades\App\Services\Emails\OrderStatusEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Stripe\Token;
use App\Jobs\RiderNotify;
use App\Jobs\NotifyToRider;
use Facades\App\Helpers\GetRider;
/**
 * Class OrderController
 * @package App\Http\Controllers\API
 */
class OrderAPIController extends Controller
{
    /** @var  OrderRepository */
    private $orderRepository;
    /** @var  FoodOrderRepository */
    private $foodOrderRepository;
    /** @var  CartRepository */
    private $cartRepository;
    /** @var  UserRepository */
    private $userRepository;
    /** @var  PaymentRepository */
    private $paymentRepository;
    /** @var  NotificationRepository */
    private $notificationRepository;

    /**
     * OrderAPIController constructor.
     * @param OrderRepository $orderRepo
     * @param FoodOrderRepository $foodOrderRepository
     * @param CartRepository $cartRepo
     * @param PaymentRepository $paymentRepo
     * @param NotificationRepository $notificationRepo
     * @param UserRepository $userRepository
     */
    public function __construct(OrderRepository $orderRepo, FoodOrderRepository $foodOrderRepository, CartRepository $cartRepo, PaymentRepository $paymentRepo, NotificationRepository $notificationRepo, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepo;
        $this->foodOrderRepository = $foodOrderRepository;
        $this->cartRepository = $cartRepo;
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepo;
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Order.
     * GET|HEAD /orders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $this->orderRepository->pushCriteria(new RequestCriteria($request));
            $this->orderRepository->pushCriteria(new LimitOffsetCriteria($request));
            $this->orderRepository->pushCriteria(new OrdersOfStatusesCriteria($request));
            $this->orderRepository->pushCriteria(new OrdersOfUserCriteria(auth()->id()));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $orders = $this->orderRepository->all();

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
    }

    /**
     * Display the specified Order.
     * GET|HEAD /orders/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var Order $order */
        if (!empty($this->orderRepository)) {
            try {
                $this->orderRepository->pushCriteria(new RequestCriteria($request));
                $this->orderRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }
            $order = $this->orderRepository->findWithoutFail($id);
        }

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        return $this->sendResponse($order->toArray(), 'Order retrieved successfully');


    }





    /**
     * Store a newly created Order in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
   
   // cash 

    public function store(Request $request)
    {
  
        $input = $request->all();

        try {

               if($input['delivery_address_id'] == 0)
                $input['delivery_address_id'] = null;
                $order_id = SaveOrderToCart::SaveToOrders(auth()->id(),$input['delivery_address_id']);
                
                $order = Order::find($order_id);
                Notification::send($order->foodOrders[0]->food->restaurant->users, new NewOrder($order));
                 dispatch(new sendNewOrderEmail($order_id))->delay(now()->addSeconds(3));

               if($request->order_mode == 1)
                $this->SaveToRider($order_id);
                 
                SaveOrderToCart::Destroy_cart(auth()->id());
                $order = Order::find($order_id);
                
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order->toArray(), __('lang.saved_successfully', ['operator' => __('lang.order')]));
        
    }



//-------------------- Save to Rider----------------
public function SaveToRider($order_id)
{
        $order_json = Helper::GetOrderInArray($order_id);
        $order = Order::find($order_id);
        $restaurant = $order->foods->first()->restaurant;
        $order_info = ['data' =>$order_json];
        $json = json_encode($order_info,true);     
      
      if(($order->isdelivery == 1) AND ($restaurant->has_riders == 0))   
       {
        OrderOffer::create([
            'order_number' => $order_id,
            'status' => 'pending',
            'status_note' => 'Pending',
            'data' => $json,
        ]);
      }

  }
    /**
     * Update the specified Order in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
   
   ///-------------Update Status  */
    public function update($id, Request $request)
    {

        $oldOrder = $this->orderRepository->findWithoutFail($id);
        if (empty($oldOrder)) {
            return $this->sendError('Order not found');
        }
        
            $input = $request->all();

            try {

                $order = $this->orderRepository->update($input, $id);
                Helper::updateStatus($oldOrder,$request->order_status_id);  
               
                Notification::send([$order->user], new StatusChangedOrder($order));
                
                   $uuids = Order::getRider($oldOrder);
                   
                      if($uuids)
                       {
                       
                         $now = now()->addSeconds(3);
                         foreach ($uuids as $key => $uuid) {

                             dispatch(new NotifyToRider($oldOrder,$uuid))->delay($now);
                            $now = $now->addSeconds(45);
                               }
                        }  

            }catch (ValidatorException $e) {
                return $this->sendError($e->getMessage());
            }

            return $this->sendResponse($order->toArray(), __('lang.saved_successfully', ['operator' => __('lang.order')]));
        
    }

}