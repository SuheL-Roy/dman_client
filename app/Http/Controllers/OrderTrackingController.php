<?php

namespace App\Http\Controllers;

use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function order_tracking(Request $request)
    {
        // return $request->order;

        $order_tracking = $request->order;
        $tracking_data = Order::where('tracking_id', $order_tracking)
            ->join('merchants', 'merchants.user_id', 'orders.user_id')
            ->select('orders.*',  'merchants.business_name as merchant_name')
            ->first();
        $order_statuses = OrderStatusHistory::with('user')->where('tracking_id', $order_tracking)->latest('id')->get();
        $new_array = array();
        foreach ($order_statuses as $key => $value) {
            if (!isset($new_array[$value['status']])) {
                $new_array[$value['status']] = $value;
            }
        }
        $order_statuses   = $new_array = array_values($new_array);
        // return "sjkfghdejgi";
        return redirect()->route('frontend.order.tracking.id', $request->order);

        return view('frontend_new.tracking', compact('tracking_data', 'order_statuses'));
    }

    public function order_tracking_id($id)
    {
        // return $id;


        $order_detail = Order::where('orders.tracking_id', $id)->join('shops', 'orders.shop', 'shops.shop_name')->select('orders.*', 'shops.shop_name as shop_name', 'shops.shop_address as shop_address')->first();

        $order_statuses = OrderStatusHistory::with('user')->where('tracking_id', $id)->latest('id')->get();
        $new_array = array();
        foreach ($order_statuses as $key => $value) {
            if (!isset($new_array[$value['status']])) {
                $new_array[$value['status']] = $value;
            }
        }
        $order_statuses   = $new_array = array_values($new_array);

        if ($order_statuses === []) {
            return view('frontend_new.null_tracking', compact('order_statuses'));
        } else {
            return view('frontend_new.tracking', compact('order_statuses', 'order_detail'));
        }
    }
}
