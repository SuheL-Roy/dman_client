<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\AgentPayment;
use App\Admin\Order;
use App\Admin\Zone;
use App\User;
use Illuminate\Http\Request;
use App\Admin\District;
use App\Admin\CoverageArea;
use App\Admin\MPayment;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use App\Admin\PickUpRequestAssign;
use App\Admin\Rider;
use App\Admin\RiderPayment;
use App\Admin\Slider;
use App\PickUpRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function index()
    {
        $data = User::orderBy('users.id', 'DESC')
            ->where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select(
                'agents.*',
                'users.name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(agents.created_at, '%y') as od")
            )
            ->get();
        return view('Admin.Home.agent_list', compact('data'));
    }




    public function edit(Request $request)
    {
        // return "kjgjdhgndf";

        $data = User::where('users.id', $request->id)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select(
                'agents.*',
                'users.name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(agents.created_at, '%y') as od")
            )
            ->first();



        $districts = District::orderBy('name', 'asc')->get();


        $areas = Zone::where('district_id', '=', $data->district_id)->get();


        return view('Admin.Home.agent_edit', compact('data', 'districts', 'areas'));
    }


    public function update(Request $request)
    {


        User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'mobile' => $request->mobile

            ]);

        $district = District::where('id', '=', $request->district_id)->first();

        $area = Zone::where('name', '=', $request->area)->first();

        Agent::where('user_id', $request->id)
            ->update([

                'district' => $district->name,
                'area' => $request->area,
                'district_id' => $request->district_id,
                'zone_id' => $area->id,
                'a_delivery_charge' => $request->a_delivery_charge,
                'a_pickup_charge' => $request->a_pickup_charge,
                'a_return_charge' => $request->a_return_charge,

            ]);

        return redirect()->route('agent.index')->with('message', 'Agent Info Updated Successfully');
    }





    public function status(Request $request)
    {
        $data = User::where('id', $request->id)->first();
        $agent =  Agent::where('user_id', $data->id)->first();
        if ($data->role == 8) {
            $data->role = 9;


            Zone::where('id', $agent->zone_id)->update(['status' => 1]);
        } elseif ($data->role == 9) {
            $data->role = 8;
            Zone::where('id', $agent->zone_id)->update(['status' => 0]);
        }
        $data->save();


        return redirect()->back()->with('message', 'Agent Status Changed Successfully');
    }

    public function dashboard(Request $request)
    {
        if (auth()->user()->role == 8) {


            //   dd(auth()->user()->id);
            // if ($request->todate) {
            //     $todate = $request->todate;
            //     $fromdate = $request->fromdate;
            //     $pRt = Order::where('status', 'PickUp Request')->count();


            //     $pCt = Order::where('status', 'Order Collect')
            //         ->count();
            //     $pCl = Order::where('status', 'PickUp Cancel')
            //         ->count();
            //     $dWt = Order::where('status', 'Waiting For Delivery')
            //         ->count();
            //     $dCt = Order::where('status', 'Order Delivered')
            //         ->count();
            //     $dPg = Order::where('status', 'Delivery Pending')
            //         ->count();
            //     $pPr = Order::where('status', 'Payment Processing')
            //         ->count();
            //     $pCt = Order::where('status', 'Payment Complete')
            //         ->count();
            //     $uPu = Order::where('status', 'PickUp Request')
            //         ->where('type', 'Urgent')
            //         ->count();

            //     $rPu = Order::where('status', 'PickUp Request')
            //         ->where('type', 'Regular')
            //         ->count();
            // } else {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d'); //where('orders.updated_at', $today) 

            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $riders = Rider::where('zone_id', $agent->zone_id)->get()->pluck('user_id');

            $areas = CoverageArea::where('zone_id', $agent->zone_id)->get()->pluck('area');




            $tPickupReq1 = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereIn('orders.area', $areas)->get();
            // ->unique('tracking_id')
            // ->count();

            $tPickupReq = OrderConfirm::latest('id')
                ->whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)
                ->count();

            $agent = Agent::where('user_id', auth()->user()->id)->value('zone_id');

            $total_pick_request = PickUpRequest::join('merchants', 'pick_up_requests.merchant_id', '=', 'merchants.user_id')
                ->where('merchants.zone_id', $agent)
                ->whereDate('pick_up_requests.created_at', Carbon::today())
                ->count();


            //return $total_pick_request;





            $tDeliveryReq = OrderStatusHistory::where('order_status_histories.status', 'Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();
            $tReturnReq = OrderStatusHistory::where('order_status_histories.status', 'Return Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();

            // PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            // ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            // ->whereDate('order_status_histories.created_at','>=',$fromdate)
            // ->whereDate('order_status_histories.created_at','<=',$todate)
            // ->where('order_status_histories.status', 'Order Placed')
            // ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            // ->count();

            $tPickupCancel = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['PickUp Cancel', 'Order Cancel by Branch'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();

            $tPickupDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->where('order_status_histories.status', 'Pickup Done')
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();

            $tDeliveryDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();

            $tReturned = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['Cancel Order', 'Return Confirm', 'Return Reach To Merchant'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->get()->unique('tracking_id')->count();

            $tHoldRescheduled = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['Reschedule Order', 'Hold Order', 'Rescheduled', 'Hold Order Received from Branch'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->get()->unique('tracking_id')->count();



            $tPaymentProcessing = AgentPayment::where('agent_payments.agent_id', Auth::user()->id)->join('agent_payment_details', 'agent_payment_details.invoice_id', 'agent_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'agent_payment_details.tracking_id')
                ->whereDate('agent_payments.created_at', '>=', $fromdate)
                ->whereDate('agent_payments.created_at', '<=', $todate)
                ->select('order_confirms.*')
                ->get()->sum('collect');
            $tRiderCollect = RiderPayment::where('rider_payments.rider_id', Auth::user()->id)->join('rider_payment_details', 'rider_payment_details.invoice_id', 'rider_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'rider_payment_details.tracking_id')
                ->whereDate('rider_payments.created_at', '>=', $fromdate)
                ->whereDate('rider_payments.created_at', '<=', $todate)
                ->select('order_confirms.*')
                ->get()->sum('collect');


            // }
            return view(
                'Admin.Home.agent_dashboard',
                compact('fromdate', 'todate', 'total_pick_request', 'tPickupReq', 'tDeliveryReq', 'tReturnReq', 'tPickupCancel', 'tPickupDone', 'tDeliveryDone', 'tReturned', 'tHoldRescheduled', 'tRiderCollect', 'tPaymentProcessing')
            );
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            // ->insert([
            //     'hub_id'          => Auth::user()->id,
            //     'hub_incharge_id' => $user->id,
            // ]);
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d'); //where('orders.updated_at', $today) 

            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $riders = Rider::where('zone_id', $agent->zone_id)->get()->pluck('user_id');

            $areas = CoverageArea::where('zone_id', $agent->zone_id)->get()->pluck('area');




            $tPickupReq1 = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereIn('orders.area', $areas)->get();
            // ->unique('tracking_id')
            // ->count();

            $tPickupReq = OrderConfirm::latest('id')
                ->whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)
                ->count();

            $agent = Agent::where('user_id', $demo->hub_id)->value('zone_id');

            $total_pick_request = PickUpRequest::join('merchants', 'pick_up_requests.merchant_id', '=', 'merchants.user_id')
                ->where('merchants.zone_id', $agent)
                ->whereDate('pick_up_requests.created_at', Carbon::today())
                ->count();


            //return $total_pick_request;





            $tDeliveryReq = OrderStatusHistory::where('order_status_histories.status', 'Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();
            $tReturnReq = OrderStatusHistory::where('order_status_histories.status', 'Return Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();

            // PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            // ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            // ->whereDate('order_status_histories.created_at','>=',$fromdate)
            // ->whereDate('order_status_histories.created_at','<=',$todate)
            // ->where('order_status_histories.status', 'Order Placed')
            // ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            // ->count();

            $tPickupCancel = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['PickUp Cancel', 'Order Cancel by Branch'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();

            $tPickupDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->where('order_status_histories.status', 'Pickup Done')
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();

            $tDeliveryDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();

            $tReturned = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['Cancel Order', 'Return Confirm', 'Return Reach To Merchant'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->get()->unique('tracking_id')->count();

            $tHoldRescheduled = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
                ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->whereIn('order_status_histories.status', ['Reschedule Order', 'Hold Order', 'Rescheduled', 'Hold Order Received from Branch'])
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->get()->unique('tracking_id')->count();



            $tPaymentProcessing = AgentPayment::where('agent_payments.agent_id',  $demo->hub_id)->join('agent_payment_details', 'agent_payment_details.invoice_id', 'agent_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'agent_payment_details.tracking_id')
                ->whereDate('agent_payments.created_at', '>=', $fromdate)
                ->whereDate('agent_payments.created_at', '<=', $todate)
                ->select('order_confirms.*')
                ->get()->sum('collect');
            $tRiderCollect = RiderPayment::where('rider_payments.rider_id',  $demo->hub_id)->join('rider_payment_details', 'rider_payment_details.invoice_id', 'rider_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'rider_payment_details.tracking_id')
                ->whereDate('rider_payments.created_at', '>=', $fromdate)
                ->whereDate('rider_payments.created_at', '<=', $todate)
                ->select('order_confirms.*')
                ->get()->sum('collect');


            // }
            return view(
                'Admin.Home.agent_dashboard',
                compact('fromdate', 'todate', 'total_pick_request', 'tPickupReq', 'tDeliveryReq', 'tReturnReq', 'tPickupCancel', 'tPickupDone', 'tDeliveryDone', 'tReturned', 'tHoldRescheduled', 'tRiderCollect', 'tPaymentProcessing')
            );
        }
    }

    public function dashboard_new(Request $request)
    {

        $today = date('Y-m-d');
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d');

        $agent = Agent::where('user_id', Auth::user()->id)->first();


        $riders = Rider::where('zone_id', $agent->zone_id)->get()->pluck('user_id');

        $areas = CoverageArea::where('zone_id', $agent->zone_id)->get()->pluck('area');




        $tPickupReq1 = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->whereIn('orders.area', $areas)->get();
        // ->unique('tracking_id')
        // ->count();

        // $tPickupReq = OrderConfirm::latest('id')
        //     ->whereDate('created_at', '>=', $fromdate)
        //     ->whereDate('created_at', '<=', $todate)
        //     ->count();
        $tPickupReq = Order::whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)->whereIn('orders.area', $areas)->count();
       

        $agent = Agent::where('user_id', auth()->user()->id)->value('zone_id');

        $total_pick_request = PickUpRequest::join('merchants', 'pick_up_requests.merchant_id', '=', 'merchants.user_id')
            ->where('merchants.zone_id', $agent)
            ->whereDate('pick_up_requests.created_at', Carbon::today())
            ->count();


        //return $total_pick_request;





        $tDeliveryReq = OrderStatusHistory::where('order_status_histories.status', 'Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();
        $tReturnReq = OrderStatusHistory::where('order_status_histories.status', 'Return Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();

        // PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
        // ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

        // ->whereDate('order_status_histories.created_at','>=',$fromdate)
        // ->whereDate('order_status_histories.created_at','<=',$todate)
        // ->where('order_status_histories.status', 'Order Placed')
        // ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        // ->count();

        $tPickupCancel = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['PickUp Cancel', 'Order Cancel by Branch'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();

        $tPickupDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->where('order_status_histories.status', 'Pickup Done')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();

        $tDeliveryDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();

        $tReturned = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['Cancel Order', 'Return Confirm', 'Return Reach To Merchant'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->get()->unique('tracking_id')->count();

        $tHoldRescheduled = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['Reschedule Order', 'Hold Order', 'Rescheduled', 'Hold Order Received from Branch'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->get()->unique('tracking_id')->count();



        $tPaymentProcessing = AgentPayment::where('agent_payments.agent_id', Auth::user()->id)->join('agent_payment_details', 'agent_payment_details.invoice_id', 'agent_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'agent_payment_details.tracking_id')
            ->whereDate('agent_payments.created_at', '>=', $fromdate)
            ->whereDate('agent_payments.created_at', '<=', $todate)
            ->select('order_confirms.*')
            ->get()->sum('collect');
        $tRiderCollect = RiderPayment::where('rider_payments.rider_id', Auth::user()->id)->join('rider_payment_details', 'rider_payment_details.invoice_id', 'rider_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'rider_payment_details.tracking_id')
            ->whereDate('rider_payments.created_at', '>=', $fromdate)
            ->whereDate('rider_payments.created_at', '<=', $todate)
            ->select('order_confirms.*')
            ->get()->sum('collect');

        return view('Admin.Home.agent_dashboard_new', compact('fromdate', 'todate', 'total_pick_request', 'tPickupReq', 'tDeliveryReq', 'tReturnReq', 'tPickupCancel', 'tPickupDone', 'tDeliveryDone', 'tReturned', 'tHoldRescheduled', 'tRiderCollect', 'tPaymentProcessing'));
    }

    public function incharge_dashboard(Request $request)
    {
        $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();

        // ->insert([
        //     'hub_id'          => Auth::user()->id,
        //     'hub_incharge_id' => $user->id,
        // ]);
        $today = date('Y-m-d');
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d'); //where('orders.updated_at', $today) 

        $agent = Agent::where('user_id', $demo->hub_id)->first();
        $riders = Rider::where('zone_id', $agent->zone_id)->get()->pluck('user_id');

        $areas = CoverageArea::where('zone_id', $agent->zone_id)->get()->pluck('area');




        $tPickupReq1 = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->whereIn('orders.area', $areas)->get();


        // ->unique('tracking_id')
        // ->count();

        $tPickupReq = OrderConfirm::latest('id')
            ->whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)
            ->count();


        $agent = Agent::where('user_id', $demo->hub_id)->value('zone_id');

        $total_pick_request = PickUpRequest::join('merchants', 'pick_up_requests.merchant_id', '=', 'merchants.user_id')
            ->where('merchants.zone_id', $agent)
            ->whereDate('pick_up_requests.created_at', Carbon::today())
            ->count();


        //return $total_pick_request;





        $tDeliveryReq = OrderStatusHistory::where('order_status_histories.status', 'Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();
        $tReturnReq = OrderStatusHistory::where('order_status_histories.status', 'Return Received By Destination Hub')->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')->count();

        // PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
        // ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

        // ->whereDate('order_status_histories.created_at','>=',$fromdate)
        // ->whereDate('order_status_histories.created_at','<=',$todate)
        // ->where('order_status_histories.status', 'Order Placed')
        // ->select('order_status_histories.*', 'pick_up_request_assigns.*')
        // ->count();

        $tPickupCancel = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['PickUp Cancel', 'Order Cancel by Branch'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();

        $tPickupDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->where('order_status_histories.status', 'Pickup Done')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();

        $tDeliveryDone = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();

        $tReturned = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['Cancel Order', 'Return Confirm', 'Return Reach To Merchant'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->get()->unique('tracking_id')->count();

        $tHoldRescheduled = PickUpRequestAssign::whereIn('pick_up_request_assigns.user_id', $riders)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->whereIn('order_status_histories.status', ['Reschedule Order', 'Hold Order', 'Rescheduled', 'Hold Order Received from Branch'])
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->get()->unique('tracking_id')->count();



        $tPaymentProcessing = AgentPayment::where('agent_payments.agent_id',  $demo->hub_id)->join('agent_payment_details', 'agent_payment_details.invoice_id', 'agent_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'agent_payment_details.tracking_id')
            ->whereDate('agent_payments.created_at', '>=', $fromdate)
            ->whereDate('agent_payments.created_at', '<=', $todate)
            ->select('order_confirms.*')
            ->get()->sum('collect');
        $tRiderCollect = RiderPayment::where('rider_payments.rider_id',  $demo->hub_id)->join('rider_payment_details', 'rider_payment_details.invoice_id', 'rider_payments.invoice_id')->join('order_confirms', 'order_confirms.tracking_id', 'rider_payment_details.tracking_id')
            ->whereDate('rider_payments.created_at', '>=', $fromdate)
            ->whereDate('rider_payments.created_at', '<=', $todate)
            ->select('order_confirms.*')
            ->get()->sum('collect');

        return view('Admin.Home.agent_incharge_dashboard', compact('fromdate', 'todate', 'total_pick_request', 'tPickupReq', 'tDeliveryReq', 'tReturnReq', 'tPickupCancel', 'tPickupDone', 'tDeliveryDone', 'tReturned', 'tHoldRescheduled', 'tRiderCollect', 'tPaymentProcessing'));
    }

    public function merchant_dashboard(Request $request)
    {
        $paymentProcessing = MPayment::where('m_user_id', Auth::user()->id)
            ->whereIn('status', ['Payment Processing', 'Payment Paid By Fulfillment'])->get()->sum('t_payable');

        $latestPayment = MPayment::where('m_user_id', Auth::user()->id)
            ->whereIn('status', ['Payment Received By Merchant'])
            ->orderBy('updated_at', 'desc') // Order by the update time in descending order
            ->first();
        $life_time_payment = MPayment::where('m_user_id', Auth::user()->id)
            ->whereIn('status', ['Payment Received By Merchant'])
            ->sum('t_payable');


        $total_sorting = Order::where('orders.user_id', Auth::user()->id)
            ->whereIn('orders.status', ['Received by Pickup Branch'])
            ->count();

        $total_delivery_hub = Order::where('orders.user_id', Auth::user()->id)
            ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
            ->count();
        $total_assign_for_delivery = Order::where('orders.user_id', Auth::user()->id)
            ->whereIn('orders.status', ['Assigned To Delivery Rider'])
            ->count();

        $total_on_hold = Order::where('orders.user_id', Auth::user()->id)
            ->whereIn('orders.status', ['Rescheduled', 'Order Cancel by Branch', 'Hold Order Received from Branch'])
            ->count();
        $total_transit = Order::where('orders.user_id', Auth::user()->id)
            ->whereIn(
                'orders.status',
                [
                    'Transfer Assign for Fulfillment',
                    'Transfer Reach To Fullfilment',
                    'Received By Fullfilment',
                    'Assigned Rider For Destination Hub',
                    'Transfer Reach To Branch',
                    'Received By Destination Hub',
                    'Assigned To Delivery Rider',
                    'Rescheduled',
                    'Return Payment Processing',
                    'Hold Order Received from Branch',
                    'Return Reach For Branch',
                    'Order Bypass By Destination Hub',
                    'Order Cancel by Branch',
                    'Order Cancel By Fullfilment'
                ]
            )
            ->count();

        $total_order = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->select('orders.*', 'order_confirms.*')
            ->get();


        $total_delivered_order = $total_order->count();
        $total_collect = $total_order->sum('collect');

        $orderTransit1 = Order::whereIn(
            'status',
            [
                'Assigned Pickup Rider',
                'Pickup Done',
                'Received by Pickup Branch',
                'Transfer Assign for Fulfillment',
                'Transfer Reach To Fullfilment',
                'Received By Fullfilment',
                'Assigned Rider For Destination Hub',
                'Transfer Reach To Branch',
                'Received By Destination Hub',
                'Assigned To Delivery Rider',
                'Rescheduled',
                'Return Payment Processing',
                'Hold Order Received from Branch',
                'Return Reach For Branch',
                'Order Bypass By Destination Hub',
                'Order Placed',
                'Order Cancel by Branch',
                'Order Cancel By Fullfilment'
            ]
        )->where('user_id', Auth::user()->id)->get();

        $totalorderTransit = $orderTransit1->count();

        $total_transit_amount = $orderTransit1->sum('collection');


        $total_return = Order::where('orders.user_id', Auth::user()->id)

            ->whereIn(
                'orders.status',
                [
                    'Return Confirm',
                    'Cancel Order',
                    'Return Reach To Merchant',
                    'Assigned Rider For Return',
                    'Return Received By Destination Hub',
                    'Return To Merchant'
                ]
            )
            ->count();


        $total_return_amount = Order::where('orders.user_id', Auth::user()->id)

            ->whereIn(
                'orders.status',
                [
                    'Return Confirm',
                    'Cancel Order',
                    'Return Reach To Merchant',
                    'Assigned Rider For Return',
                    'Return Received By Destination Hub',
                    'Return To Merchant'
                ]
            )
            ->sum('collection');


        $slider = Slider::orderBy('id', 'DESC')->get();

        $all_order = Order::where('orders.user_id', Auth::user()->id)
            ->get();

        $all_order_count = $all_order->count();
        $all_collection = $all_order->sum('collection');



        $total_success_delivery =  Order::where('orders.user_id', Auth::user()->id)->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered'])
            ->count();

        $total_unsuccessfully_delivery = Order::where('orders.user_id', Auth::user()->id)
            ->whereIn(
                'orders.status',
                [
                    'Assigned Pickup Rider',
                    'Pickup Done',
                    'Received by Pickup Branch',
                    'Transfer Assign for Fulfillment',
                    'Transfer Reach To Fullfilment',
                    'Received By Fullfilment',
                    'Assigned Rider For Destination Hub',
                    'Transfer Reach To Branch',
                    'Received By Destination Hub',
                    'Assigned To Delivery Rider',
                    'Rescheduled',
                    'Return Payment Processing',
                    'Hold Order Received from Branch',
                    'Return Reach For Branch',
                    'Order Bypass By Destination Hub',
                    'Order Placed',
                    'Order Cancel by Branch',
                    'Order Cancel By Fullfilment'
                ]
            )
            ->count();


        $total_return = Order::where('orders.user_id', Auth::user()->id)

            ->whereIn(
                'orders.status',
                [
                    'Return Confirm',
                    'Cancel Order',
                    'Return Reach To Merchant',
                    'Assigned Rider For Return',
                    'Return Received By Destination Hub',
                    'Return To Merchant'
                ]
            )
            ->count();
        $total_order_count = Order::where('orders.user_id', Auth::user()->id)
            ->count();


        $total_delivery_success_ratio = 0;
        $total_delivery_unsuccess_ratio = 0;
        $total_delivery_return_ratio = 0;

        /*Total UnSuccessfully delivery ratio*/
        // $total_unsuccessfully_delivery = $total_order_count - $total_success_delivery;
        if ($total_unsuccessfully_delivery > 0) {

            $unsuccessPercentage = ($total_unsuccessfully_delivery / $total_order_count) * 100;

            $total_delivery_unsuccess_ratio = number_format($unsuccessPercentage);
        }


        /*Total Successfully delivery ratio*/
        if ($total_success_delivery > 0) {
            $successPercentage = ($total_success_delivery / $total_order_count) * 100;

            $total_delivery_success_ratio = number_format($successPercentage);
        }



        /*Total return delivery ratio*/
        if ($total_return > 0) {
            $ReturnPercentage = ($total_return / $total_order_count) * 100;

            $total_delivery_return_ratio = number_format($ReturnPercentage);
        }


        return view('Admin.Home.merchants_dashboard', compact('total_transit_amount', 'total_return_amount', 'total_delivery_return_ratio', 'total_delivery_success_ratio', 'total_delivery_unsuccess_ratio', 'all_order_count', 'all_collection', 'slider', 'total_sorting', 'total_delivery_hub', 'total_assign_for_delivery', 'total_on_hold', 'total_transit', 'totalorderTransit', 'total_return', 'total_delivered_order', 'total_collect', 'paymentProcessing', 'latestPayment', 'life_time_payment'));
    }
}
