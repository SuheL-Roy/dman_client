<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use App\Admin\PickUpRequestAssign;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentPickupBypassController extends Controller
{
    public function index()
    {
        //return 'smdfa';
        if (auth()->user()->role == 8) {
            $form_rider = '';
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;
            $riders = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();



            $orders = [];

            return view('Backend.Bypass.Agent.Pickup.index', compact('riders', 'orders', 'form_rider'));
        } elseif (auth()->user()->role == 18) {
            $form_rider = '';
            $demo =  DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;
            $riders = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();



            $orders = [];

            return view('Backend.Bypass.Agent.Pickup.index', compact('riders', 'orders', 'form_rider'));
        }
    }
    public function load(Request $request)
    {
        if (auth()->user()->role == 8) {
            $form_rider =  $request->form_rider;
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;
            $riders = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();



            $orders = PickUpRequestAssign::orderBy('pick_up_request_assigns.id', 'DESC')
                ->join('orders', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('order_confirms.*', 'users.*', 'merchants.*', 'orders.*')
                ->where('merchants.area', $area)
                ->where('pick_up_request_assigns.user_id', $form_rider)
                ->where('orders.status', 'Assigned Pickup Rider')
                ->get()->unique('tracking_id');

            return view('Backend.Bypass.Agent.Pickup.index', compact('riders', 'orders', 'form_rider'));
        } elseif (auth()->user()->role == 18) {
            $form_rider =  $request->form_rider;
            $demo =  DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;
            $riders = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();



            $orders = PickUpRequestAssign::orderBy('pick_up_request_assigns.id', 'DESC')
                ->join('orders', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('order_confirms.*', 'users.*', 'merchants.*', 'orders.*')
                ->where('merchants.area', $area)
                ->where('pick_up_request_assigns.user_id', $form_rider)
                ->where('orders.status', 'Assigned Pickup Rider')
                ->get()->unique('tracking_id');

            return view('Backend.Bypass.Agent.Pickup.index', compact('riders', 'orders', 'form_rider'));
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
                $history->status       = 'Assigned Pickup Rider';
                $history->save();


                $req = PickUpRequestAssign::where('tracking_id', $tracking_id)->first();

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
