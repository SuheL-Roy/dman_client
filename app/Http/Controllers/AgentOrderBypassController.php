<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\CoverageArea;
use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentOrderBypassController extends Controller
{
    public function index(Request $request)
    {
        # code...
        //  return Auth::user();
        if (auth()->user()->role == 8) {
            $area =  Agent::where('user_id', Auth::user()->id)->first()->area;
            $area_l = CoverageArea::where('zone_name', $area)->select('area')->get();
            $my_array = $area_l->pluck('area');


            $orders_data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('coverage_areas', 'orders.area', 'coverage_areas.area')
                //  ->join('shops', 'orders.shop', 'shops.shop_name')
                ->select('orders.*', 'order_confirms.*', 'users.name as merchant', 'merchants.business_name as business_name', 'coverage_areas.zone_name as destination')
                // ->where('orders.status', 'Received By Pickup Branch')
                ->whereIn('orders.status', ['Received By Pickup Branch', 'Delivery Cancel Reject by Fulfillment'])
                ->whereIn('orders.area', $my_array)
                ->get();


            $orders = $orders_data->unique('tracking_id');
            return view('Backend.Bypass.Agent.Order.index', compact('orders'));
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $area =  Agent::where('user_id', $demo->hub_id)->first()->area;
            $area_l = CoverageArea::where('zone_name', $area)->select('area')->get();
            $my_array = $area_l->pluck('area');


            $orders_data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('coverage_areas', 'orders.area', 'coverage_areas.area')
                //  ->join('shops', 'orders.shop', 'shops.shop_name')
                ->select('orders.*', 'order_confirms.*', 'users.name as merchant', 'merchants.business_name as business_name', 'coverage_areas.zone_name as destination')
                // ->where('orders.status', 'Received By Pickup Branch')
                ->whereIn('orders.status', ['Received By Pickup Branch', 'Delivery Cancel Reject by Fulfillment'])
                ->whereIn('orders.area', $my_array)
                ->get();


            $orders = $orders_data->unique('tracking_id');
            return view('Backend.Bypass.Agent.Order.index', compact('orders'));
        }
    }
    public function confirm(Request $request)
    {
        //dd($request->all());
        $tracking =  $request->tracking_ids;


        foreach ($tracking as  $tracking_id) {
            $data = new OrderStatusHistory();
            $data->tracking_id  = $tracking_id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Order Bypass By Destination Hub';
            $data->save();
            $order = Order::where('tracking_id', $tracking_id)->first();
            $order->status = 'Order Bypass By Destination Hub';
            $order->save();
        }
        \Toastr::success('Successfully order bypass.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }


    public function aprove(Request $request)
    {
        return "ok sdfgdrthdryt";
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Received By Destination Hub';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();

        $order->status = 'Received By Destination Hub';
        $order->save();

        return redirect()->back()->with('message', 'Order Received By Destination Hub Successfully');
    }


    public function bypass_order()
    {
        # code...
        return "bypass";
    }
}
