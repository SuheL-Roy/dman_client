<?php

namespace App\Http\Controllers\API;

use App\Admin\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Order;
use App\Admin\Shop;
use App\Admin\OrderStatusHistory;
use App\Helper\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use DateTime;


class PickuprequestController extends Controller
{
    //   public function __construct()
    //     {
    //         $this->middleware('auth:api');

    //     }

    public function pickupreq()
    {
        // return "ok";

        $user_id = auth('api')->user()->id;

        $data = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.business_name as merchant', 'users.mobile', 'users.address')
            ->where('pick_up_request_assigns.user_id', $user_id)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get();

        $order = $data->unique('tracking_id');


        return response()->json($order);
    }



    public function pickupreq1()
    {
        $user_id = auth('api')->user()->id;

        $data = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('shops', 'shops.shop_name', 'orders.shop')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.business_name as merchant', 'shops.*')
            ->where('pick_up_request_assigns.user_id', $user_id)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get();

        $order = $data->unique('tracking_id');


        return response()->json($order);
    }









    public function Collect(Request $request)
    {
        $user_id = auth('api')->user()->id;

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->tracking_id;
        $data->user_id      = $user_id;
        $data->status       = 'Pickup Done';
        $data->save();


        $order = Order::where('tracking_id', $request->tracking_id)->first();
        $order->status = 'Pickup Done';
        $order->save();

        // $company = Company::where('id', 1)->first();
        // $data =  Order::where('tracking_id', $request->tracking_id)->join('merchants', 'orders.user_id', 'merchants.user_id',)->first();

        // $text = "Dear Valued Customer,\n{$company->name} Received a parcel From \"{$data->business_name}\" Value - {$data->collection} TK and It will be delivered Soon.\nThanks \n{$company->website}/tracking_details?tracking_id={$request->tracking_id}";

        // //send Message
        // Helpers::sms_send($order->customer_phone, $text);

        return response()->json([
            'status' => true,
            'data' => 'Successfully Collect Order',
        ]);
    }

    public function cancel(Request $request)
    {

        $user_id = auth('api')->user()->id;

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->tracking_id;
        $data->user_id      = $user_id;
        $data->status       = 'PickUp Cancel';
        $data->save();


        $order = Order::where('tracking_id', $request->tracking_id)->first();
        $order->status = 'PickUp Cancel';
        $order->save();



        return response()->json([
            'status' => true,
            'data' => 'Successfully Cancel Pickup',
        ]);
    }


    public function rider_today_delivered_data()
    {
        // return "ok";

        $user_id = auth('api')->user()->id;

        $data = OrderStatusHistory::
        join('orders', 'order_status_histories.tracking_id', 'orders.tracking_id') 
        ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')     
        ->where('order_status_histories.user_id',$user_id)->where('order_status_histories.status', 'Successfully Delivered')
        ->whereDate('order_status_histories.created_at', '>=', date('Y-m-d'))
        ->whereDate('order_status_histories.created_at', '<=', date('Y-m-d'))
        ->select(
            'orders.tracking_id',
            'orders.customer_name',
            'orders.customer_phone',
            'orders.customer_address',
            'order_confirms.collect'
         
           
        )
        ->get();

        return response()->json([
            'Status' => true,
            'message' => "Success",
            'data' => $data
        ]);


    }


    public function rider_monthly_delivered_data()
    {
        // return "ok";

        $user_id = auth('api')->user()->id;

        $date = new DateTime('now');
        $date->modify('first day of this month');
        $start_date = $date->format('Y-m-d');

        $date = new DateTime('now');
        $date->modify('last day of this month');
        $end_date= $date->format('Y-m-d');       


        $data = OrderStatusHistory::
        join('orders', 'order_status_histories.tracking_id', 'orders.tracking_id')      
        ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')  
        ->where('order_status_histories.user_id', $user_id)->where('order_status_histories.status', 'Successfully Delivered')
        ->whereDate('order_status_histories.created_at', '>=', $start_date)
        ->whereDate('order_status_histories.created_at', '<=', $end_date)
        ->select(
            'orders.tracking_id',
            'orders.customer_name',
            'orders.customer_phone',
            'orders.customer_address',
            'order_confirms.collect'
           
        )
        ->get();


        return response()->json([
            'Status' => true,
            'message' => "Success",
            'data' => $data
        ]);
    }



}
