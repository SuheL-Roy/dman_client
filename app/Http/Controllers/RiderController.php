<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\BranchDistrict;
use App\Admin\Company;
use App\Admin\Order;
use App\Admin\PickUpRequestAssign;
use App\User;
use App\Admin\Rider;
use App\Admin\Zone;
use App\Admin\District;
use App\Admin\CoverageArea;
use App\Admin\DeliveryAssign;
use App\Admin\ReturnAssign;
use App\Admin\Transfer;
use App\Admin\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use DateTime;


class RiderController extends Controller
{
    public function index()
    {
        if (Gate::allows('superAdmin')) {
            $data = User::orderBy('users.id', 'DESC')
                ->where('role', 10)
                ->orwhere('role', 11)
                ->join('riders', 'users.id', 'riders.user_id')
                ->select(
                    'riders.*',
                    'users.name',
                    'users.email',
                    'users.mobile',
                    'users.role',
                    'users.id as ID',
                    DB::raw("DATE_FORMAT(riders.created_at, '%y') as od")
                )
                ->get();
            return view('Admin.Home.rider_list', compact('data'));
        }
        if (Gate::allows('activeAgent')) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;
            $data = User::orderBy('id', 'DESC')
                ->where('role', 10)
                ->where('riders.area', $area)
                ->join('riders', 'users.id', 'riders.user_id')
                ->select(
                    'riders.*',
                    'users.name',
                    'users.email',
                    'users.mobile',
                    'users.role',
                    DB::raw("DATE_FORMAT(riders.created_at, '%y') as od")
                )
                ->get();
            return view('Admin.Home.rider_list', compact('data'));
        }

        if (Gate::allows('ActiveInCharge')) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            // ->insert([
            //     'hub_id'          => Auth::user()->id,
            //     'hub_incharge_id' => $user->id,
            // ]);
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;
            $data = User::orderBy('id', 'DESC')
                ->where('role', 10)
                ->where('riders.area', $area)
                ->join('riders', 'users.id', 'riders.user_id')
                ->select(
                    'riders.*',
                    'users.name',
                    'users.email',
                    'users.mobile',
                    'users.role',
                    DB::raw("DATE_FORMAT(riders.created_at, '%y') as od")
                )
                ->get();
            return view('Admin.Home.rider_list', compact('data'));
        }
    }

    public function status(Request $request)
    {
        $data = User::where('id', $request->id)->first();
        if ($data->role == 10) {
            $data->role = 11;
        } elseif ($data->role == 11) {
            $data->role = 10;
        }
        $data->save();
        return redirect()->back()->with('message', 'Rider Status Changed Successfully');
    }

    public function preview(Request $request)
    {
        // return "xdflkjhfxdhgxdfhbgnjkfghjkfzsdhgjfzsdg67fyt8uikft";
        $id       = $request->id;
        $user     = User::where('id', $id)->first();
        $rider = Rider::where('user_id', $id)->first();
        return view('Admin.Home.rider_preview', compact('id', 'user', 'rider'));
    }

    public function dashboard(Request $request)
    {
        $today = date('Y-m-d');

        // if ($request->todate) {
        //     $todate = $request->todate;
        //     $fromdate = $request->fromdate;
        //     $pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'PickUp Assigned')
        //         ->count();
        //     $collect = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Order Collect')
        //         ->count();
        //     $cancel = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'PickUp Cancel')
        //         ->count();
        //     $delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Waiting For Delivery')
        //         ->count();
        //     $delivered = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Order Delivered')
        //         ->count();
        //     $pending = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Delivery Pending')
        //         ->count();
        // } else {
        $today = date('Y-m-d');
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d');
        // $today_pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //     ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //     ->whereDate('order_status_histories.created_at', '>=', $fromdate)
        //     ->whereDate('order_status_histories.created_at', '<=', $todate)
        //     ->where('order_status_histories.status', 'Assigned Pickup Rider')
        //     ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //     ->count();


        $today_pickup1 = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.*', 'users.mobile', 'users.address')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get();
        $today_pickup = $today_pickup1->unique('tracking_id')->count();


        /* Total Pick Done */

        // $total_pickup_collect = OrderStatusHistory::join('orders', 'orders.tracking_id', '=', 'order_status_histories.tracking_id')
        //     ->where('orders.status', 'Pickup Done')
        //     ->where('order_status_histories.status', 'Pickup Done')
        //     ->where('order_status_histories.user_id', Auth::user()->id)
        //     ->select('order_status_histories.*')->get();






        $total_pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            // ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
            // ->whereDate('order_status_histories.created_at','>=',$fromdate)
            // ->whereDate('order_status_histories.created_at','<=',$todate)
            ->where('order_status_histories.status', 'Assigned Pickup Rider')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();



        $total_pickup_collect = Order::join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->select('orders.*', 'order_status_histories.*')
            ->where('order_status_histories.user_id', Auth::user()->id)
            ->where('orders.status', 'Pickup Done')
            ->where('order_status_histories.status', 'Pickup Done')
            ->count();

        $total_pickup_Collect_ratio = 0;

        if ($total_pickup_collect > 0) {
            $total_pickup_Collected   =  ($total_pickup_collect / $total_pickup) * 100;

            $total_pickup_Collect_ratio  =   number_format($total_pickup_Collected, 2);
        }


        $total_success_delivery = Order::join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->select('orders.*', 'order_status_histories.*')
            ->where('order_status_histories.user_id', Auth::user()->id)
            ->where('orders.status', 'Successfully Delivered')
            ->where('order_status_histories.status', 'Successfully Delivered')
            ->count();


        $total_unsuccess_delivery = Order::join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->select('orders.*', 'order_status_histories.*')
            ->where('order_status_histories.user_id', Auth::user()->id)
            ->whereIn('orders.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
            ->whereIn('order_status_histories.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
            ->count();


        $total_delivery_success_ratio = 0;


        /*Total Successfully delivery ratio*/

        if ($total_success_delivery > 0) {
            $successPercentage = ($total_success_delivery / $total_unsuccess_delivery) * 100;

            $total_delivery_success_ratio = number_format($successPercentage);
        }



        // return $total_pickup_collect;
        // $today_delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //     ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //     ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //     ->whereDate('order_status_histories.created_at', '>=', $fromdate)
        //     ->whereDate('order_status_histories.created_at', '<=', $todate)
        //     ->where('order_status_histories.status', 'Assigned To Delivery Rider')
        //     ->count();

        $today_delivery1 = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'users.*')
            ->where('orders.status', 'Assigned To Delivery Rider')
            ->where('delivery_assigns.user_id', Auth::user()->id)
            ->get();

        $today_delivery = $today_delivery1->unique('tracking_id')->count();




        $total_delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            // ->whereDate('order_status_histories.created_at','>=',$fromdate)
            // ->whereDate('order_status_histories.created_at','<=',$todate)
            ->where('order_status_histories.status', 'Assigned To Delivery Rider')
            ->count();



        $today_return = ReturnAssign::where('rider_id', Auth::user()->id)->where('status', 'Assigned Rider For Return')
            ->whereDate('return_assigns.created_at', '>=', $fromdate)
            ->whereDate('return_assigns.created_at', '<=', $todate)
            ->count();

        $total_return = ReturnAssign::where('rider_id', Auth::user()->id)
            //->where('status','Assigned Rider For Return')
            // ->whereDate('return_assigns.created_at','>=',$fromdate)
            // ->whereDate('return_assigns.created_at','<=',$todate)
            ->count();

        $today_transfer = Transfer::where('media_id', Auth::user()->id)->where('status', 0)
            ->whereDate('transfers.created_at', '>=', $fromdate)
            ->whereDate('transfers.created_at', '<=', $todate)
            ->count();
        $total_transfer = Transfer::where('media_id', Auth::user()->id)
            //->where('status',0)
            //  ->whereDate('transfers.created_at','>=',$fromdate)
            //  ->whereDate('transfers.created_at','<=',$todate)
            ->count();

        $today_delivered = OrderStatusHistory::where('user_id', Auth::user()->id)->where('status', 'Successfully Delivered')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->count();


        $date = new DateTime('now');
        $date->modify('first day of this month');
        $start_date = $date->format('Y-m-d');

        $date = new DateTime('now');
        $date->modify('last day of this month');
        $end_date = $date->format('Y-m-d');

        $monthly_delivered = OrderStatusHistory::where('user_id', Auth::user()->id)->where('status', 'Successfully Delivered')
            ->whereDate('order_status_histories.created_at', '>=', $start_date)
            ->whereDate('order_status_histories.created_at', '<=', $end_date)
            ->count();





        return view(
            'Admin.Home.rider_dashboard',
            compact('today_pickup', 'total_pickup', 'total_delivery_success_ratio', 'total_pickup_Collect_ratio', 'today_delivery', 'total_delivery', 'today_return', 'total_return', 'today_transfer', 'total_transfer', 'today_delivered', 'monthly_delivered')
        );
    }

    public function dashboard_new(Request $request)
    {
        $today = date('Y-m-d');

        // if ($request->todate) {
        //     $todate = $request->todate;
        //     $fromdate = $request->fromdate;
        //     $pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'PickUp Assigned')
        //         ->count();
        //     $collect = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Order Collect')
        //         ->count();
        //     $cancel = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'PickUp Cancel')
        //         ->count();
        //     $delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Waiting For Delivery')
        //         ->count();
        //     $delivered = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Order Delivered')
        //         ->count();
        //     $pending = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //         ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //         ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //         ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
        //         ->where('order_status_histories.status', 'Delivery Pending')
        //         ->count();
        // } else {
        $today = date('Y-m-d');
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d');
        // $today_pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //     ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //     ->whereDate('order_status_histories.created_at', '>=', $fromdate)
        //     ->whereDate('order_status_histories.created_at', '<=', $todate)
        //     ->where('order_status_histories.status', 'Assigned Pickup Rider')
        //     ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //     ->count();


        $today_pickup1 = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.*', 'users.mobile', 'users.address')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get();
        $today_pickup = $today_pickup1->unique('tracking_id')->count();


        /* Total Pick Done */

        // $total_pickup_collect = OrderStatusHistory::join('orders', 'orders.tracking_id', '=', 'order_status_histories.tracking_id')
        //     ->where('orders.status', 'Pickup Done')
        //     ->where('order_status_histories.status', 'Pickup Done')
        //     ->where('order_status_histories.user_id', Auth::user()->id)
        //     ->select('order_status_histories.*')->get();






        $total_pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            // ->whereBetween('order_status_histories.created_at', [$fromdate, $todate])
            // ->whereDate('order_status_histories.created_at','>=',$fromdate)
            // ->whereDate('order_status_histories.created_at','<=',$todate)
            ->where('order_status_histories.status', 'Assigned Pickup Rider')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();



        $total_pickup_collect = Order::join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->select('orders.*', 'order_status_histories.*')
            ->where('order_status_histories.user_id', Auth::user()->id)
            ->where('orders.status', 'Pickup Done')
            ->where('order_status_histories.status', 'Pickup Done')
            ->count();

        $total_pickup_Collect_ratio = 0;

        if ($total_pickup_collect > 0) {
            $total_pickup_Collected   =  ($total_pickup_collect / $total_pickup) * 100;

            $total_pickup_Collect_ratio  =   number_format($total_pickup_Collected, 2);
        }


        $total_success_delivery = Order::join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->select('orders.*', 'order_status_histories.*')
            ->where('order_status_histories.user_id', Auth::user()->id)
            ->where('orders.status', 'Successfully Delivered')
            ->where('order_status_histories.status', 'Successfully Delivered')
            ->count();


        $total_unsuccess_delivery = Order::join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->select('orders.*', 'order_status_histories.*')
            ->where('order_status_histories.user_id', Auth::user()->id)
            ->whereIn('orders.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
            ->whereIn('order_status_histories.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
            ->count();


        $total_delivery_success_ratio = 0;


        /*Total Successfully delivery ratio*/

        if ($total_success_delivery > 0) {
            $successPercentage = ($total_success_delivery / $total_unsuccess_delivery) * 100;

            $total_delivery_success_ratio = number_format($successPercentage);
        }



        // return $total_pickup_collect;
        // $today_delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
        //     ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
        //     ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        //     ->whereDate('order_status_histories.created_at', '>=', $fromdate)
        //     ->whereDate('order_status_histories.created_at', '<=', $todate)
        //     ->where('order_status_histories.status', 'Assigned To Delivery Rider')
        //     ->count();

        $today_delivery1 = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'users.*')
            ->where('orders.status', 'Assigned To Delivery Rider')
            ->where('delivery_assigns.user_id', Auth::user()->id)
            ->get();

        $today_delivery = $today_delivery1->unique('tracking_id')->count();




        $total_delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            // ->whereDate('order_status_histories.created_at','>=',$fromdate)
            // ->whereDate('order_status_histories.created_at','<=',$todate)
            ->where('order_status_histories.status', 'Assigned To Delivery Rider')
            ->count();



        $today_return = ReturnAssign::where('rider_id', Auth::user()->id)->where('status', 'Assigned Rider For Return')
            ->whereDate('return_assigns.created_at', '>=', $fromdate)
            ->whereDate('return_assigns.created_at', '<=', $todate)
            ->count();

        $total_return = ReturnAssign::where('rider_id', Auth::user()->id)
            //->where('status','Assigned Rider For Return')
            // ->whereDate('return_assigns.created_at','>=',$fromdate)
            // ->whereDate('return_assigns.created_at','<=',$todate)
            ->count();

        $today_transfer = Transfer::where('media_id', Auth::user()->id)->where('status', 0)
            ->whereDate('transfers.created_at', '>=', $fromdate)
            ->whereDate('transfers.created_at', '<=', $todate)
            ->count();
        $total_transfer = Transfer::where('media_id', Auth::user()->id)
            //->where('status',0)
            //  ->whereDate('transfers.created_at','>=',$fromdate)
            //  ->whereDate('transfers.created_at','<=',$todate)
            ->count();

        $today_delivered = OrderStatusHistory::where('user_id', Auth::user()->id)->where('status', 'Successfully Delivered')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->count();


        $date = new DateTime('now');
        $date->modify('first day of this month');
        $start_date = $date->format('Y-m-d');

        $date = new DateTime('now');
        $date->modify('last day of this month');
        $end_date = $date->format('Y-m-d');

        $monthly_delivered = OrderStatusHistory::where('user_id', Auth::user()->id)->where('status', 'Successfully Delivered')
            ->whereDate('order_status_histories.created_at', '>=', $start_date)
            ->whereDate('order_status_histories.created_at', '<=', $end_date)
            ->count();

        return view('Admin.Home.rider_dashboard_new', compact('today_pickup', 'total_pickup', 'total_delivery_success_ratio', 'total_pickup_Collect_ratio', 'today_delivery', 'total_delivery', 'today_return', 'total_return', 'today_transfer', 'total_transfer', 'today_delivered', 'monthly_delivered'));
    }

    public function edit(Request $request)
    {
        // return "kjgjdhgndf";

        // $data = User::where('users.id', $request->id)
        //     ->join('riders', 'users.id', 'riders.user_id')
        //     ->select(
        //         'riders.*',
        //         'users.name',
        //         'users.email',
        //         'users.mobile',
        //         'users.role',
        //         'users.id as ID',
        //         DB::raw("DATE_FORMAT(riders.created_at, '%y') as od")
        //     )
        //     ->first();
        // $district = District::all();
        // $area = CoverageArea::where('district', '=', $data->district)->get();


        // return view('Admin.Home.rider_edit', compact('data', 'district', 'area'));
        $data = User::where('users.id', $request->id)
            ->join('riders', 'users.id', 'riders.user_id')
            ->select(
                'riders.*',
                'users.name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(riders.created_at, '%y') as od")
            )
            ->first();



        $districts = BranchDistrict::where('z_id', $data->zone_id)->get();
        $areas = Zone::all();

        return view('Admin.Home.rider_edit', compact('data', 'districts', 'areas'));
    }


    public function print(Request $request)
    {
        $user     = User::where('id', $request->id)->first();
        $rider = Rider::where('user_id', $request->id)->first();
        $company = Company::all();
        return view('Admin.Home.rider_print_preview', compact('user', 'rider', 'company'));
    }







    public function update(Request $request)
    {


        // return  $request->all();
        User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
            ]);
        $district_name = District::where('id', $request->district)->value('name');
        $zone = Zone::where('id', $request->area)->first();
        Rider::where('user_id', $request->id)
            ->update([
                'district' => $request->district,
                'area' => $zone->name,
                'district_id' => $request->district,
                'zone_id' => $zone->id,
                'r_delivery_charge' => $request->r_delivery_charge,
                'r_pickup_charge' => $request->r_pickup_charge,
                'r_return_charge' => $request->r_return_charge,
            ]);
        $user_id =  Rider::where('user_id', $request->id)->value('user_id');
        if ($request->hasFile('user_voter_id_photo')) {
            $user_voter_id_photo = $request->file('user_voter_id_photo');
            $nid_front_name = uniqid() . $user_voter_id_photo->getClientOriginalName();
            $uploadPath = 'public/VoterID/UservoterID/';
            $user_voter_id_photo->move($uploadPath, $nid_front_name);
            $user_fathers_voter_id_photo_Url = $uploadPath . $nid_front_name;
            Rider::where('user_id', $user_id)
                ->update([
                    'user_voter_id_photo' => $nid_front_name
                ]);
        }
        if ($request->hasFile('user_fathers_voter_id_photo')) {
            $user_fathers_voter_id_photo = $request->file('user_fathers_voter_id_photo');
            $nid_front_name = uniqid() . $user_fathers_voter_id_photo->getClientOriginalName();
            $uploadPath = 'public/VoterID/FathersvoterID/';
            $user_fathers_voter_id_photo->move($uploadPath, $nid_front_name);
            $user_fathers_voter_id_photo_Url = $uploadPath . $nid_front_name;
            Rider::where('user_id', $user_id)
                ->update([
                    'user_fathers_voter_id_photo' =>  $nid_front_name
                ]);
        }
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $nid_back_name = uniqid() . $photo->getClientOriginalName();
            $uploadPath = 'public/photo/';
            $photo->move($uploadPath, $nid_back_name);
            $nid_back_Url = $uploadPath . $nid_back_name;
            User::where('id', $user_id)
                ->update([
                    'photo' => $nid_back_name
                ]);
        }
        return redirect()->route('rider.index')->with('message', 'Rider Info Updated Successfully');
    }
}
