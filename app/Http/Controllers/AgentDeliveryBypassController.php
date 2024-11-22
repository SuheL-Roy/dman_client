<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\CoverageArea;
use App\Admin\DeliveryAssign;
use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentDeliveryBypassController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 8) {
            $riderid =  "";
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $riders = User::orderBy('users.name')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $user = User::orderBy('name', 'DESC')->where('id', 4)->get();

            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $orders =
                DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'orders.tracking_id', 'delivery_assigns.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->where('orders.status', 'Assigned To Delivery Rider')
                ->select('orders.tracking_id', 'merchants.business_name', 'users.name as rider', 'users.mobile', 'users.address', 'orders.customer_name', 'orders.customer_phone', 'orders.customer_address', 'orders.area', 'orders.type', 'orders.collection', 'orders.status', 'delivery_assigns.user_id')
                ->whereIn('orders.area', $my_array)
                ->get();


            return view('Backend.Bypass.Agent.Delivery.index', compact('orders', 'user', 'riders', 'riderid'));
        } elseif (auth()->user()->role == 18) {
            $riderid =  "";
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $riders = User::orderBy('users.name')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $user = User::orderBy('name', 'DESC')->where('id', 4)->get();

            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $orders =
                DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'orders.tracking_id', 'delivery_assigns.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->where('orders.status', 'Assigned To Delivery Rider')
                ->select('orders.tracking_id', 'merchants.business_name', 'users.name as rider', 'users.mobile', 'users.address', 'orders.customer_name', 'orders.customer_phone', 'orders.customer_address', 'orders.area', 'orders.type', 'orders.collection', 'orders.status', 'delivery_assigns.user_id')
                ->whereIn('orders.area', $my_array)
                ->get();


            return view('Backend.Bypass.Agent.Delivery.index', compact('orders', 'user', 'riders', 'riderid'));
        }
    }

    public function load(Request $request)
    {
        if (auth()->user()->role == 8) {
            $riderid =  $request->form_rider;
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $riders = User::orderBy('users.name')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $user = User::orderBy('id', 'DESC')->where('id', 4)->get();
            $orders =
                DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'orders.tracking_id', 'delivery_assigns.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->where('orders.status', 'Assigned To Delivery Rider')
                ->select('orders.tracking_id', 'merchants.business_name', 'users.mobile', 'users.address', 'orders.customer_name', 'orders.customer_phone', 'orders.customer_address', 'orders.area', 'orders.type', 'orders.collection', 'orders.status', 'delivery_assigns.user_id')
                ->whereIn('orders.area', $my_array)
                ->where('delivery_assigns.user_id', $riderid)
                ->get();
            return view('Backend.Bypass.Agent.Delivery.index', compact('orders', 'riders', 'user', 'riderid'));
        } elseif (auth()->user()->role == 18) {
            $riderid =  $request->form_rider;
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $riders = User::orderBy('users.name')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $user = User::orderBy('id', 'DESC')->where('id', 4)->get();
            $orders =
                DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'orders.tracking_id', 'delivery_assigns.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->where('orders.status', 'Assigned To Delivery Rider')
                ->select('orders.tracking_id', 'merchants.business_name', 'users.mobile', 'users.address', 'orders.customer_name', 'orders.customer_phone', 'orders.customer_address', 'orders.area', 'orders.type', 'orders.collection', 'orders.status', 'delivery_assigns.user_id')
                ->whereIn('orders.area', $my_array)
                ->where('delivery_assigns.user_id', $riderid)
                ->get();
            return view('Backend.Bypass.Agent.Delivery.index', compact('orders', 'riders', 'user', 'riderid'));
        }
    }
    public function bypass_order(Request $request)
    {
        // return $request->all();


        $tracking_ids = $request->tracking_ids;

        if (!$tracking_ids) {
            \Toastr::error('Please Select first.', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        if ($request->form_rider === $request->to_rider) {
            \Toastr::error('You Can\'n Bypass Same Rider', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }

        if ($tracking_ids) {
            foreach ($tracking_ids as $tracking_id) {

                // $history = OrderStatusHistory::where('tracking_id', $tracking_id)->first();
                // if ($history) {
                //     $history->user_id = $request->to_rider;
                //     $history->save();
                // }
                $data =  Order::where('tracking_id', $tracking_id)->first();
                // dd($data);
                $history = new OrderStatusHistory();
                $history->tracking_id  = $data->tracking_id;
                $history->user_id      =  $request->to_rider;
                $history->status       = 'Assigned delivery Rider';
                $history->save();

                $req = DeliveryAssign::where('tracking_id', $tracking_id)->first();
                if ($req) {
                    $req->user_id = $request->to_rider;
                    $req->save();
                }
            }
        }

        \Toastr::success('Successfully Bypass ', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }
}
