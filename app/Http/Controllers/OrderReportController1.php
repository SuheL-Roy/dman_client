<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\AgentPayment;
use App\Admin\AgentPaymentDetail;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\DeliveryAssign;
use App\Admin\Merchant;
use App\Admin\MerchantPayment;
use App\Admin\MPayment;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use App\Admin\PickUpRequestAssign;
use App\Admin\ReturnAssign;
use App\Admin\ReturnAssignDetail;
use App\Admin\Rider;
use App\Admin\RiderPayment;
use App\Admin\RiderPaymentDetail;
use App\Admin\Transfer;
use App\Admin\TransferToAgent;
use App\Admin\Zone;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use DateTime;

class OrderReportController extends Controller
{
    public function datewise(Request $request)
    {

        //  dd($request->all());
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        $orderStatus = '';
        $total_collection = 0;
        $total_collect = 0;


        if (Gate::allows('activeMerchant')) {
            // return "dfdfg";
            $orderStatus =  $request->status;
            // return $request->all();
            // $order = Order::orderBy('order_confirms.id', 'DESC')
            //     ->whereBetween('order_confirms.created_at', [$fromdate, $todate])
            //     ->where('orders.user_id', Auth::user()->id)
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->select(
            //         'order_confirms.*',
            //         'orders.order_id as orderid',
            //         'orders.status',
            //         'orders.customer_name as customer',
            //         'orders.customer_phone as phone',
            //         DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
            //     )
            //     ->where('status', $request->status)
            //     ->get();
            if ($request->status == 'Payment Due') {
                $order = Order::orderBy('orders.id', 'DESC')
                    ->where('orders.user_id', Auth::user()->id)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                    // ->whereIn('orders.status', ['Payment Processing', 'Payment Processing Complete'])
                    ->whereIn('orders.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Successfully Delivered', 'Delivered Amount Collected from Branch', 'Delivered Amount Send to Fulfillment'])
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->get();
                $total_collection = $order->sum('collection');
                $total_collect = $order->sum('collect');
            } elseif ($request->status == 'Payment Paid') {
                $order = Order::orderBy('orders.id', 'DESC')
                    ->where('orders.user_id', Auth::user()->id)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                    ->whereIn('orders.status', ['Payment Processing', 'Payment Processing Complete'])
                    // ->whereIn('orders.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Successfully Delivered', 'Delivered Amount Collected from Branch', 'Delivered Amount Send to Fulfillment'])
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->get();
                $total_collection = $order->sum('collection');
                $total_collect = $order->sum('collect');
            } else {
                $order = [];
            }



            // $order = Order::orderBy('orders.id', 'DESC')
            //     ->where('orders.user_id', Auth::user()->id)
            //     ->whereBetween('orders.updated_at', [$fromdate, $todate])
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->join('users', 'orders.user_id', 'users.id')
            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_area as shop_area', 'shops.pickup_address as pickup_address', 'shops.shop_address as shop_address', 'users.name as merchant')
            //     ->where('orders.status', $orderStatus)
            //     ->get();
        } elseif (Gate::allows('superAdmin')) {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereBetween('order_confirms.created_at', [$fromdate, $todate])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'order_confirms.*',
                    'orders.order_id as orderid',
                    'orders.status',
                    'orders.customer_name as customer',
                    'orders.customer_phone as phone',
                    DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('activeManager')) {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereBetween('order_confirms.created_at', [$fromdate, $todate])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'order_confirms.*',
                    'orders.order_id as orderid',
                    'orders.status',
                    'orders.customer_name as customer',
                    'orders.customer_phone as phone',
                    DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        return view('Admin.Report.Order.datewise', compact('order', 'total_collection', 'total_collect', 'fromdate', 'todate', 'orderStatus'));
    }

    public function date_wise(Request $request)
    {
        // return $request->all();
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $orderStatus =  $request->status;
        $total_collection = 0;
        $total_collect = 0;
        if (Gate::allows('activeMerchant')) {
            // $order = Order::orderBy('order_confirms.id', 'DESC')
            //     ->whereBetween('order_confirms.created_at', [$fromdate, $todate])
            //     ->where('orders.user_id', Auth::user()->id)
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->select(
            //         'order_confirms.*',
            //         'orders.order_id as orderid',
            //         'orders.customer_name as customer',
            //         'orders.customer_phone as phone',
            //         DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
            //     )
            //     ->get();

            $company = Company::orderBy('id', 'DESC')->get();
            // $order = Order::orderBy('orders.id', 'DESC')
            //     ->where('orders.user_id', Auth::user()->id)
            //     ->whereBetween('orders.updated_at', [$fromdate, $todate])
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->join('users', 'orders.user_id', 'users.id')
            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_area as shop_area', 'shops.pickup_address as pickup_address', 'shops.shop_address as shop_address', 'users.name as merchant')
            //     // ->where('orders.status', $orderStatus)
            //     ->whereIn('orders.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Successfully Delivered', 'Delivered Amount Collected from Branch', 'Delivered Amount Send to Fulfillment'])
            //     ->get();
            if ($request->status == 'Payment Due') {
                $order = Order::orderBy('orders.id', 'DESC')
                    ->where('orders.user_id', Auth::user()->id)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                    // ->whereIn('orders.status', ['Payment Processing', 'Payment Processing Complete'])
                    ->whereIn('orders.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Successfully Delivered', 'Delivered Amount Collected from Branch', 'Delivered Amount Send to Fulfillment'])
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->get();
                //return $order;    
                $total_collection = $order->sum('collection');
                $total_collect = $order->sum('collect');
            } elseif ($request->status == 'Payment Paid') {
                $order = Order::orderBy('orders.id', 'DESC')
                    ->where('orders.user_id', Auth::user()->id)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                    ->whereIn('orders.status', ['Payment Processing', 'Payment Processing Complete'])
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->get();
                //return $order;    
                $total_collection = $order->sum('collection');
                $total_collect = $order->sum('collect');
            }
        } elseif (Gate::allows('superAdmin')) {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereBetween('order_confirms.created_at', [$fromdate, $todate])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'order_confirms.*',
                    'orders.order_id as orderid',
                    'orders.customer_name as customer',
                    'orders.customer_phone as phone',
                    DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('activeManager')) {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereBetween('order_confirms.created_at', [$fromdate, $todate])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'order_confirms.*',
                    'orders.order_id as orderid',
                    'orders.customer_name as customer',
                    'orders.customer_phone as phone',
                    DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        return view('Admin.Report.Order.datewise_print', compact('total_collection', 'total_collect', 'order', 'fromdate', 'todate', 'company', 'orderStatus'));
    }

    public function statuswise(Request $request)
    {
        $today = date('Y-m-d');
        $status = $request->status;
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        if (Gate::allows('activeMerchant')) {
            $data = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.user_id', Auth::user()->id)
                ->where('orders.status', $status)
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('superAdmin')) {
            $data = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', $status)
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('activeManager')) {
            $data = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', $status)
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        return view('Admin.Report.Order.statuswise', compact('data', 'status', 'fromdate', 'todate'));
    }

    public function status_wise(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $status = $request->status;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if (Gate::allows('activeMerchant')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.user_id', Auth::user()->id)
                ->where('orders.status', $status)
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('superAdmin')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', $status)
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('activeManager')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', $status)
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        return view(
            'Admin.Report.Order.status_wise_print',
            compact('order', 'status', 'fromdate', 'todate', 'company')
        );
    }

    public function collected(Request $request)
    {

        if ($request->todate && $request->fromdate) {
            $todate = $request->todate;
            $fromdate = $request->fromdate;
        } else {
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }
        if (Auth::user()->role == 10) {
            $transfers = Transfer::with('sender', 'receiver')
                ->where('media_id', Auth::user()->id)
                ->where('status', 1)

                ->get();
        } else if (Auth::user()->role == 8) {

            $transfers = Transfer::with('sender', 'receiver')
                ->whereDate('created_at', '<=', $todate)
                ->whereDate('created_at', '>=', $fromdate)
                ->where('sender_id', Auth::user()->id)
                // ->orWhere('receiver_id', Auth::user()->id)
                ->get();
        } else {
            $transfers = Transfer::with('sender', 'receiver')->whereBetween('created_at', [$fromdate, $todate])->get();
        }







        return view('Admin.Report.Order.collected_order', compact('transfers', 'fromdate', 'todate'));
    }

    //asif
    public function confirm_collected(Request $request)
    {
        // return   $request->all();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }

        if ($request->status) {
            $orders = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                ->where('order_status_histories.status', $request->status)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->join('shops', 'orders.user_id', 'shops.user_id')
                ->join('merchants', 'merchants.user_id', 'shops.user_id')
                ->join('order_confirms', 'order_confirms.tracking_id', 'order_status_histories.tracking_id')
                ->select(
                    'shops.*',
                    'orders.*',
                    'order_confirms.*',
                    'merchants.business_name as business_name'
                )->get();

            $Qty = $orders->count();
            $total_collection = $orders->sum('collection');
        } else {
            $orders = [];
            $Qty = '';
            $total_collection = '';
        }

        return view('Admin.Report.Order.confirm_collected', compact('orders', 'fromdate', 'todate', 'Qty', 'total_collection'));
    }

    public function delivery_confirm(Request $request)
    {
        //Rider Pickup Assign List
        // return  $rider = Rider::where('user_id', Auth::user()->id)->first();
        // return  $rider = Merchant::where('user_id', Auth::user()->id)->first();
        // $area = $rider->area;
        $selectedMerchant = '';
        $merchants = Order::orderBy('orders.id', 'DESC')
            // ->whereIn('orders.status', 'Assigned Pickup Rider')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('merchants.*')
            // ->where('merchants.area', $area)
            ->get()->unique('user_id');
        $data = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.*', 'users.mobile', 'users.address')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->where('orders.status', 'Assigned Pickup Rider')
            // ->where('orders.status', 'Successfully Delivered')
            ->get();
        $order = $data->unique('tracking_id');
        return view('Admin.PickUpRequestAssign.assignedRequest', compact('order', 'merchants', 'selectedMerchant'));
    }
    public function delivery_rider(Request $request)
    {
        $orderStatus = $request->status;
        $rider = Rider::where('user_id', Auth::user()->id)->first();
        $rider_id = $rider->user_id;
        $area = $rider->area;
        $selectedMerchant = '';

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }

        $merchants = Order::orderBy('orders.id', 'DESC')
            ->whereIn('orders.status', ['Assigned Pickup Rider'])
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('merchants.*')
            ->where('merchants.area', $area)
            ->get()->unique('user_id');


        if ($orderStatus) {
            $data = OrderStatusHistory::where('order_status_histories.user_id', $rider_id)
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->where('order_status_histories.status', $request->status)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'order_status_histories.user_id', 'users.id')
                ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*', 'order_status_histories.*')
                ->get();
        } else {
            $data = OrderStatusHistory::where('order_status_histories.user_id', $rider_id)
                ->where('order_status_histories.status', 'Successfully Delivered')
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')

                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'order_status_histories.user_id', 'users.id')
                ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*', 'order_status_histories.*')
                ->get();
        }

        $order = $data->unique('tracking_id');


        return view('Admin.PickUpRequestAssign.assignedRequestRider', compact('order', 'merchants', 'selectedMerchant', 'fromdate', 'todate', 'orderStatus'));
    }

    public function pickup_cancel(Request $request)
    {
        $data = Order::orderBy('orders.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->join('shops', 'shops.shop_name', 'orders.shop')
            ->select(
                'orders.*',
                'pick_up_request_assigns.user_id',
                'users.name as merchant',
                'shops.shop_name as shop_name',
                'shops.shop_phone as shop_phone',
                'shops.pickup_address as pickup_address',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->where('orders.status', 'PickUp Cancel')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->get();
        return view('Admin.Report.Order.pickup_cancel', compact('data'));
    }

    public function pending(Request $request)
    {
        $data = Order::orderBy('orders.id', 'DESC')
            ->join('delivery_assigns', 'orders.tracking_id', 'delivery_assigns.tracking_id')
            ->join('shops', 'orders.shop', 'shops.shop_name')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select(
                'orders.*',
                'delivery_assigns.user_id',
                'shops.shop_name as shop_name',
                'shops.shop_phone as shop_phone',
                'shops.pickup_address as pickup_address',
                'merchants.business_name as business_name',
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date")
            )
            ->where('orders.status', 'Hold Order')
            ->where('delivery_assigns.user_id', Auth::user()->id)
            ->get();
        return view('Admin.Report.Order.pendingOrder', compact('data'));
    }

    public function delivered(Request $request)
    {
        $data = Order::orderBy('orders.id', 'DESC')
            ->join('delivery_assigns', 'orders.tracking_id', 'delivery_assigns.tracking_id')
            ->select(
                'orders.*',
                'delivery_assigns.user_id',
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date")
            )
            ->where('orders.status', 'Order Delivered')
            ->where('delivery_assigns.user_id', Auth::user()->id)
            ->get();
        return view('Admin.Report.Order.deliveredOrder', compact('data'));
    }

    public function confirm_delivery(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        // dd($today);
        $order = Order::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->join('users', 'orders.user_id', 'users.id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select(
                'orders.*',
                'pick_up_request_assigns.user_id',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->where('status', 'Order Delivered')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->get();
        $Qty = $order->count();
        $Total = $order->sum('collection');
        return view('Admin.Report.Order.confirm_delivery', compact('order', 'fromdate', 'todate', 'Qty', 'Total'));
    }



    public function rider_today_delivered_report(Request $request)
    {

        $data = OrderStatusHistory::join('orders', 'order_status_histories.tracking_id', 'orders.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->where('order_status_histories.user_id', Auth::user()->id)->where('order_status_histories.status', 'Successfully Delivered')
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

        $route = $request->route()->getName();


        return view('Admin.Report.Order.delivered', compact('data', 'route'));
    }


    public function rider_monthly_delivered_report(Request $request)
    {


        $date = new DateTime('now');
        $date->modify('first day of this month');
        $start_date = $date->format('Y-m-d');

        $date = new DateTime('now');
        $date->modify('last day of this month');
        $end_date = $date->format('Y-m-d');


        $data = OrderStatusHistory::join('orders', 'order_status_histories.tracking_id', 'orders.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->where('order_status_histories.user_id', Auth::user()->id)->where('order_status_histories.status', 'Successfully Delivered')
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

        $route = $request->route()->getName();


        return view('Admin.Report.Order.delivered', compact('data', 'route'));
    }

    public function merchantwise(Request $request)
    {


        //$request->all();
        $today = date('Y-m-d');
        $merchant = $request->merchant;
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $user = User::where('role', 12)->join('merchants', 'merchants.user_id', 'users.id')->get();
        $merchant = $request->merchant;
        $status = $request->status;


        if ($fromdate) {

            $order = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->whereDate('orders.created_at', '>=', $fromdate)
                ->whereDate('orders.created_at', '<=', $todate)
                ->where(function ($order) use ($merchant, $status) {

                    if ($merchant) {
                        $order->where('orders.user_id', $merchant);
                    }

                    if ($status) {
                        $order->where('orders.status', $status);
                    }
                })

                ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
                ->get();


            //$order = $data->unique('tracking_id');

            /*

        $order = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        ->join('merchants', 'orders.user_id', 'merchants.user_id')
        ->join('users', 'orders.user_id', 'users.id')            
    
      
    ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*') 
    ->get();

    */




            $Qty = $order->count();
        } else {
            $order = [];
            $Qty = 0;
        }


        return view(
            'Admin.Report.Order.merchantwise',
            compact('user', 'merchant', 'todate', 'fromdate', 'status', 'order', 'Qty')
        );
    }
    public function adminAgentHistory(Request $request)
    {
        // return "dflkjghderjkgh";
        // return   $request->all();
        $today = date('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        $user = User::where('role', 8)->get();
        $agent = $request->agent;
        $status = $request->status;



        if ($status) {



            $agentInfo = Agent::where('user_id', $agent)->first();
            $riderIds = Rider::where('zone_id', $agentInfo->zone_id)->get()->pluck('id');

            $order = Order::orderBy('orders.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->whereDate('orders.created_at', '>=', $fromdate)
                ->whereDate('orders.created_at', '<=', $todate)
                ->where('merchants.area', $agentInfo->area)
                ->where('orders.status', $status)
                ->select(
                    'users.*',
                    'order_confirms.*',
                    'orders.*',
                    'merchants.business_name as business_name'
                )
                ->get();

            $Qty = $order->count();
        } else {

            $order = [];
            $Qty = 0;

            $status = '';
        }


        /*
        if ($request->status && $agent) {
            $agentInfo = Agent::where('user_id', $agent)->first();
            $agentAreas = CoverageArea::where('zone_id', $agentInfo->zone_id)->get()->pluck('id');
            $riderIds = Rider::where('zone_id', $agentInfo->zone_id)->get()->pluck('id');

            if ($status == 'Order Placed' || $status == 'Pickup Done' || $status == 'PickUp Cancel') {
                // return "dfgd";
                $order = Order::orderBy('orders.id', 'DESC')
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select(
                        'users.*',
                        'order_confirms.*',
                        'orders.*',
                        'merchants.business_name as business_name'
                    )
                    ->where('merchants.area', $agentInfo->area)
                    ->where('orders.status', $status)
                    ->get()->unique('tracking_id');
            } else if ($status == 'Waiting for Pickup' || $status == 'Waiting for Return') {

                if ($status == 'Waiting for Pickup') {
                    $status = 'Order Placed';
                } else {
                    $status = 'Return Received By Destination Hub';
                }
                $order = Order::orderBy('orders.id', 'DESC')
                    //   ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select(
                        'users.*',
                        'order_confirms.*',
                        'orders.*',
                        'merchants.business_name as business_name'
                    )
                    ->where('merchants.area', $agentInfo->area)
                    ->where('orders.status', $status)
                    ->get();
            } else if ($status == 'Waiting for Delivery') {

                // if($status=='Waiting for Pickup'){
                //     $status ='Order Placed';
                // }else if($status=='Waiting for Delivery'){
                $status = 'Received By Destination Hub';
                $statusn = ['Received By Destination Hub', 'Order Bypass By Destination Hub'];
                // }else{
                //     $status ='Return Received By Destination Hub';
                // }
                $order = Order::orderBy('orders.id', 'DESC')
                    //   ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select(
                        'users.*',
                        'order_confirms.*',
                        'orders.*',
                        'merchants.business_name as business_name'
                    )
                    ->whereIn('orders.area_id', $agentAreas)
                    ->whereIn('orders.status', $statusn)
                    ->get();
            } else if ($status == 'Assigned Pickup Rider') {

                //return $agentInfo->area;

                $order = PickUpRequestAssign::orderBy('pick_up_request_assigns.id', 'DESC')
                    ->whereDate('pick_up_request_assigns.updated_at', '>=', $fromdate)
                    ->whereDate('pick_up_request_assigns.updated_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select(
                        'users.*',
                        'order_confirms.*',
                        'orders.*',
                        'merchants.business_name as business_name'
                    )
                    //->whereBetween('pick_up_request_assigns.updated_at', [$fromdate, $todate])
                    ->where('merchants.area', $agentInfo->area)
                    ->where('orders.status', $status)

                    ->get();
            } else if ($status = 'Assigned To Delivery Rider' || $status == 'Successfully Delivered' || $status == 'Partially Delivered') {

                $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('delivery_assigns.updated_at', '>=', $fromdate)
                    ->whereDate('delivery_assigns.updated_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'delivery_assigns.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select(
                        'users.*',
                        'order_confirms.*',
                        'orders.*',
                        'merchants.business_name as business_name'
                    )
                    ->whereIn('orders.area_id', $agentAreas)
                    ->where('orders.status', $status)
                    ->get();
            } else if ($status == 'Assigned Rider For Return') {

                $order = PickUpRequestAssign::orderBy('pick_up_request_assigns.id', 'DESC')
                    //   ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('pick_up_request_assigns.created_at', '>=', $fromdate)
                    ->whereDate('pick_up_request_assigns.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select(
                        'users.*',
                        'order_confirms.*',
                        'orders.*',
                        'merchants.business_name as business_name'
                    )
                    ->whereIn('orders.area_id', $agentAreas)
                    ->where('orders.status', $status)
                    ->get();
            }

            // $order = Order::orderBy('order_confirms.id', 'DESC')
            //     ->whereBetween('orders.created_at', [$fromdate, $todate])
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->select(
            //         'shops.*',
            //         'order_confirms.*',
            //         'orders.*',
            //         'merchants.business_name as business_name'
            //     )
            //    // ->where('orders.user_id', $agent)
            //     ->where('orders.status', $status)
            //     ->get();

            $Qty = $order->count();
        } else {
            $order = [];
            $Qty = 0;
            // $order = Order::orderBy('order_confirms.id', 'DESC')
            //     ->whereBetween('orders.created_at', [$fromdate, $todate])
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->select(
            //         'shops.*',
            //         'order_confirms.*',
            //         'orders.*',
            //         'merchants.business_name as business_name'

            //     )
            //     ->where('orders.user_id', $merchant)
            //     //->where('orders.status', $status)
            //     ->get();
            $status = '';
        }


        */




        return view(
            'Admin.Report.Order.agent_history',
            compact('user', 'agent', 'todate', 'fromdate', 'status', 'order', 'Qty')
        );
    }

    public function merchant_wise(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $data = User::find($request->merchant);
        $merchant = $data->name;
        $status = $request->status;
        $order = Order::orderBy('order_confirms.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->where('orders.user_id', $request->merchant)
            ->where('orders.status', $status)
            ->get();
        $Qty = $order->count();
        return view(
            'Admin.Report.Order.merchant_wise',
            compact('merchant', 'status', 'order', 'Qty', 'company')
        );
    }

    public function paymentComplete(Request $request)
    {
        if (Gate::allows('activeMerchant')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->where('orders.user_id', Auth::user()->id)
                ->where('orders.status', 'Payment Complete')
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        return view('Admin.Report.Order.paymentComplete', compact('order'));
    }

    public function payment_Complete(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        if (Gate::allows('activeMerchant')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->where('orders.user_id', Auth::user()->id)
                ->where('orders.status', 'Payment Complete')
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.merchant_pay',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        return view('Admin.Report.Order.paymentComplete_print', compact('order', 'company'));
    }

    public function pickuprequest(Request $request)
    {
        $today = date('Y-m-d');
        if (Gate::allows('activeMerchant')) {
            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('shops', 'orders.shop', 'shops.shop_name')
                ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_area as shop_area', 'shops.pickup_address as pickup_address', 'shops.shop_address as shop_address', 'users.name as merchant')
                ->where('orders.user_id', Auth::user()->id)
                ->whereDate("orders.created_at", '=', $today)
                ->get();
        } elseif (Gate::allows('superAdmin')) {
            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('shops', 'orders.shop', 'shops.shop_name')
                ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_area as shop_area', 'shops.pickup_address as pickup_address', 'shops.shop_address as shop_address', 'users.name as merchant')
                ->whereDate("orders.created_at", '=', $today)
                ->get();
        } elseif (Gate::allows('activeManager')) {
            // return Order::all();
            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('shops', 'orders.shop', 'shops.shop_name')
                ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_area as shop_area', 'shops.pickup_address as pickup_address', 'shops.shop_address as shop_address', 'users.name as merchant')
                ->whereDate("orders.created_at", '=', $today)
                ->get();
        }
        $Qty = $data->count();
        return view('Admin.Report.Order.pickuprequest', compact('data', 'Qty'));
    }

    public function pickup_request(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        if (Gate::allows('activeMerchant')) {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->where('order_confirms.created_at', $today)
                ->where('orders.status', 'PickUp Request')
                ->where('orders.user_id', Auth::user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'order_confirms.*',
                    'orders.order_id as orderid',
                    'orders.customer_name as customer',
                    DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('superAdmin')) {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->where('orders.status', 'PickUp Request')
                ->where('order_confirms.created_at', $today)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'order_confirms.*',
                    'orders.order_id as orderid',
                    'orders.customer_name as customer',
                    DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('activeManager')) {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->where('orders.status', 'PickUp Request')
                ->where('order_confirms.created_at', $today)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select(
                    'order_confirms.*',
                    'orders.order_id as orderid',
                    'orders.customer_name as customer',
                    DB::raw("DATE_FORMAT(order_confirms.created_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        $Qty = $order->count();
        return view('Admin.Report.Order.pickuprequest_print', compact('order', 'Qty', 'company'));
    }

    public function processing(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        if (Gate::allows('activeAgent')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Processing')
                ->where('transfer_to_agents.agent_id', Auth::user()->id)
                ->join('transfer_to_agents', 'orders.tracking_id', 'transfer_to_agents.tracking_id')
                ->select('orders.*', DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
                ->get();
        } elseif (Gate::allows('activeAccounts')) {
            $order = TransferToAgent::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Processing')
                ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
                ->join('users', 'transfer_to_agents.agent_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as agent',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.processing',
            compact('fromdate', 'todate', 'order', 'Total')
        );
    }

    public function pro_cessing(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        if (Gate::allows('activeAgent')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Processing')
                ->where('transfer_to_agents.agent_id', Auth::user()->id)
                ->join('transfer_to_agents', 'orders.tracking_id', 'transfer_to_agents.tracking_id')
                ->select('orders.*', DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
                ->get();
        } elseif (Gate::allows('activeAccounts')) {
            $order = TransferToAgent::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Processing')
                ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
                ->join('users', 'transfer_to_agents.agent_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as agent',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.processing_print',
            compact('fromdate', 'todate', 'order', 'company', 'Total')
        );
    }

    public function payCollect(Request $request)
    {

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        if (Gate::allows('activeAgent')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Collect')
                ->where('transfer_to_agents.agent_id', Auth::user()->id)
                ->join('transfer_to_agents', 'orders.tracking_id', 'transfer_to_agents.tracking_id')
                ->select('orders.*', DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
                ->get();
        } elseif (Gate::allows('activeAccounts')) {
            $order = TransferToAgent::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Collect')
                ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
                ->join('users', 'transfer_to_agents.agent_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as agent',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.pay_collect',
            compact('fromdate', 'todate', 'order', 'Total')
        );
    }

    public function pay_collect(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $company = Company::orderBy('id', 'DESC')->get();

        if (Gate::allows('activeAgent')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Collect')
                ->where('transfer_to_agents.agent_id', Auth::user()->id)
                ->join('transfer_to_agents', 'orders.tracking_id', 'transfer_to_agents.tracking_id')
                ->select('orders.*', DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
                ->get();
        } elseif (Gate::allows('activeAccounts')) {
            $order = TransferToAgent::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Collect')
                ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
                ->join('users', 'transfer_to_agents.agent_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as agent',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.pay_collect_print',
            compact('fromdate', 'todate', 'order', 'company', 'Total')
        );
    }

    public function riderwise(Request $request)
    {
        $user = User::where('role', 10)->get();
        $rider = $request->rider;
        $status = $request->status;
        $order = Order::orderBy('orders.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select(
                'orders.*',
                'pick_up_request_assigns.user_id',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->where('pick_up_request_assigns.user_id', $rider)
            ->where('orders.status', $status)
            ->get();
        $Qty = $order->count();
        return view(
            'Admin.Report.Order.riderStatusWise',
            compact('user', 'rider', 'status', 'order', 'Qty')
        );
    }

    public function rider_wise(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $data = User::find($request->rider);
        $rider = $data->name;
        $status = $request->status;
        $order = Order::orderBy('orders.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select(
                'orders.*',
                'pick_up_request_assigns.user_id',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->where('pick_up_request_assigns.user_id', $request->rider)
            ->where('orders.status', $status)
            ->get();
        $Qty = $order->count();
        return view(
            'Admin.Report.Order.riderStatusWise_print',
            compact('rider', 'status', 'order', 'Qty', 'company')
        );
    }

    public function rider_status_date(Request $request)
    {
        $id = Auth::user()->id;
        $today = date('Y-m-d');


        if ($request->todate && $request->fromdate) {
            $todate = $request->todate;
            $fromdate = $request->fromdate;
        } else {
            $todate = $today;
            $fromdate = $today;
        }

        if (Auth::user()->role == 8) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $user = User::where('users.role', 10)
                ->join('riders', 'riders.user_id', 'users.id')
                ->where('riders.area', $agent->area)->select('users.*')->get();
        } else {
            $user = User::where('role', 10)->get();
        }

        $rider = $request->rider ?? '';
        $status = $request->status ?? '';
        $filtering = '';

        if ($request->status) {
            $filtering = $request->status;
        }



        $order = OrderStatusHistory::where('order_status_histories.user_id', $rider)
            // ->whereBetween('order_status_histories.updated_at', [$fromdate, $todate])
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)



            ->where(function ($order) use ($status) {

                if ($status) {
                    $order->where('order_status_histories.status', $status);
                }
            })

            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'order_status_histories.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->leftJoin('users as merchants_users', 'merchants.user_id', 'merchants_users.id')
            ->select('merchants_users.mobile as merchants_phone', 'orders.tracking_id', 'users.name', 'merchants.business_name', 'orders.customer_name', 'orders.customer_phone', 'orders.customer_address', 'orders.delivery_note', 'order_status_histories.status', 'order_confirms.colection', 'order_confirms.collect')
            ->get();

        $Qty = $order->count();
        return view(
            'Admin.Report.Order.riderDateStatuswise',
            compact('fromdate', 'todate', 'user', 'rider', 'status', 'order', 'Qty', 'filtering')
        );
    }

    public function rider_status_date_print(Request $request)
    {
        // dd($request->all());
        // return $request->rider;
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = User::find($request->rider);
        $rider = $data->name;
        $status = $request->status;
        $orders = OrderStatusHistory::where('order_status_histories.user_id', $request->rider)
            ->where('order_status_histories.status', $status)
            // ->whereBetween('order_status_histories.updated_at', [$fromdate, $todate])
            ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
            ->whereDate('order_status_histories.updated_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'order_status_histories.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->leftJoin('users as merchants_users', 'merchants.user_id', 'merchants_users.id')
            ->select('merchants_users.mobile as merchant_phone', 'orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
            ->get();

        $Qty = $orders->count();
        return view(
            'Admin.Report.Order.riderDateStatuswise_print',
            compact('fromdate', 'todate', 'rider', 'status', 'orders', 'Qty', 'company')
        );
    }

    public function payComplete(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        if (Gate::allows('activeMerchant')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Complete')
                ->where('orders.user_id', Auth::user()->id)
                ->join('users', 'orders.user_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as merchant',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('activeAccounts')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Complete')
                ->join('users', 'orders.user_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as merchant',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.payComplete',
            compact('fromdate', 'todate', 'order', 'Total')
        );
    }

    public function pay_Complete(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        if (Gate::allows('activeMerchant')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Complete')
                ->where('orders.user_id', Auth::user()->id)
                ->join('users', 'orders.user_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as merchant',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        } elseif (Gate::allows('activeAccounts')) {
            $order = Order::orderBy('orders.id', 'DESC')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('orders.status', 'Payment Complete')
                ->join('users', 'orders.user_id', 'users.id')
                ->select(
                    'orders.*',
                    'users.name as merchant',
                    'users.mobile as phone',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->get();
        }
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.payComplete_print',
            compact('fromdate', 'todate', 'order', 'Total', 'company')
        );
    }

    public function agent_wise(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $user = User::where('role', 8)->get();
        $agent = $request->agent;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Processing')
            ->where('transfer_to_agents.agent_id', $agent)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.agent_wise_processing',
            compact('user', 'agent', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function agent_wise_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = User::find($request->agent);
        $agent = $data->name;
        $phone = $data->mobile;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Processing')
            ->where('transfer_to_agents.agent_id', $request->agent)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select('orders.*', DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.agent_wise_processing_print',
            compact('company', 'agent', 'phone', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function area_wise(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = CoverageArea::orderBy('id', 'DESC')->get();
        $area = $request->area;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Processing')
            ->where('orders.area', $area)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.area_wise_processing',
            compact('data', 'area', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function area_wise_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $area = $request->area;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Processing')
            ->where('orders.area', $area)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.area_wise_processing_print',
            compact('company', 'area', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function payCollectagent(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $user = User::where('role', 8)->get();
        $agent = $request->agent;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Collect')
            ->where('transfer_to_agents.agent_id', $agent)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.agent_wise_pay_collect',
            compact('user', 'agent', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function pay_collect_agent(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = User::find($request->agent);
        $agent = $data->name;
        $phone = $data->mobile;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Collect')
            ->where('transfer_to_agents.agent_id', $request->agent)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.agent_wise_pay_collect_print',
            compact('company', 'agent', 'phone', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function area_wiseCollect(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = CoverageArea::orderBy('id', 'DESC')->get();
        $area = $request->area;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Collect')
            ->where('orders.area', $area)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.area_wiseCollect',
            compact('data', 'area', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function area_collect_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $area = $request->area;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Collect')
            ->where('orders.area', $area)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.area_collect_print',
            compact('company', 'area', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function merchant_pay_complete(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $user = User::where('role', 12)->get();
        $merchant = $request->merchant;
        // $order = TransferToAgent::orderBy('orders.id', 'DESC')
        //         ->whereBetween('orders.updated_at', [$fromdate, $todate])
        //         ->where('orders.status', 'Payment Complete')
        //         ->where('orders.user_id', $merchant)
        //         ->join('orders','transfer_to_agents.tracking_id','orders.tracking_id')
        //         ->join('users','transfer_to_agents.agent_id','users.id')
        //         ->select('orders.*','users.name as agent','users.mobile as phone',
        //             DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
        //         ->get();
        // $Total = $order->sum('collection');
        $order = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', $merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $order->sum('collection');
        $tMPay = $order->sum('merchant_pay');
        return view(
            'Admin.Report.Order.merchant_wise_pay_complete',
            compact('user', 'merchant', 'fromdate', 'todate', 'order', 'tCol', 'tMPay')
        );
    }

    public function merchantpaycomplete(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = User::find($request->merchant);
        $merchant = $data->name;
        $phone = $data->mobile;
        // $order = TransferToAgent::orderBy('orders.id', 'DESC')
        //         ->whereBetween('orders.updated_at', [$fromdate, $todate])
        //         ->where('orders.status', 'Payment Complete')
        //         ->where('orders.user_id', $request->merchant)
        //         ->join('orders','transfer_to_agents.tracking_id','orders.tracking_id')
        //         ->join('users','transfer_to_agents.agent_id','users.id')
        //         ->select('orders.*','users.name as agent','users.mobile as phone',
        //             DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
        //         ->get();
        // $Total = $order->sum('collection');
        $order = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', $request->merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $order->sum('collection');
        $tMPay = $order->sum('merchant_pay');
        return view(
            'Admin.Report.Order.merchant_wise_pay_complete_print',
            compact('merchant', 'phone', 'fromdate', 'todate', 'order', 'tCol', 'tMPay', 'company')
        );
    }

    public function merchant_pay_collect(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $user = User::where('role', 12)->get();
        $merchant = $request->merchant;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Collect')
            ->where('orders.user_id', $merchant)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.merchant_wise_pay_collect',
            compact('user', 'merchant', 'fromdate', 'todate', 'order', 'Total')
        );
    }

    public function merchantpaycollect(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = User::find($request->merchant);
        $merchant = $data->name;
        $phone = $data->mobile;
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Collect')
            ->where('orders.user_id', $request->merchant)
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view(
            'Admin.Report.Order.merchant_wise_pay_collect_print',
            compact('merchant', 'phone', 'fromdate', 'todate', 'order', 'Total', 'company')
        );
    }

    public function return_datewise(Request $request)
    {
        // return "demo";
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 2day'));
        }
        if (Gate::allows('superAdmin')) {
            // return "aaaa";
            $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                // ->where('return_assigns.rider_id', Auth::user()->id)
                // ->where('return_assigns.status', 'Assigned Rider For Return')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } else if (Gate::allows('activeManager')) {

            return  $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                // ->where('return_assigns.rider_id', Auth::user()->id)
                ->where('return_assigns.status', 'Assigned Rider For Return')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } elseif (Gate::allows('activeRider')) {

            $payments_data = ReturnAssign::latest('return_assigns.id')
                ->with('creator', 'rider', 'updator', 'merchant')
                ->where('return_assigns.rider_id', Auth::user()->id)
                // ->where('return_assigns.status', 'Assigned Rider For Return')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } elseif (Gate::allows('activeMerchant')) {
            // return "fdjkg";
            $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                ->where('user_id', Auth::user()->id)
                ->where('return_assigns.status', 'Return Reach To Merchant')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } else if (Gate::allows('activeAgent')) {
            $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                // ->where('return_assigns.create_by', Auth::user()->id)
                // ->where('return_assigns.status', 'Return Reach To Merchant')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            //  return  $payments_data = ReturnAssign::->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        }
        // return view('Admin.Report.Order.return_datewise', compact('order', 'fromdate', 'todate'));
        return view('Admin.Report.Order.return_datewise', compact('payments_data', 'payments', 'fromdate', 'todate'));
    }

    public function urgent_order(Request $request)
    {
        $today = date('Y-m-d');
        $order = Order::orderBy('orders.id', 'DESC')
            ->where('orders.type', 1)
            ->where('orders.status', 'PickUp Request')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        return view('Admin.Report.Order.urgent_order', compact('order'));
    }

    public function status_pickup(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        $inside = $request->inside;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $order = Order::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.inside', 1)
            ->where('orders.status', 'PickUp Request')
            ->where('orders.inside', $inside)
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        return view('Admin.Report.Order.status_pickup', compact('order', 'fromdate', 'todate'));
    }

    public function merchant_payment(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $user = User::where('role', 12)->get();
        $merchant = $request->merchant;
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Collect')
            ->where('orders.user_id', $request->merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        // $tCol = $complete->sum('collection');
        // $tMPay = $complete->sum('merchant_pay');
        // $return = Order::orderBy('orders.id', 'DESC')
        //             ->where('orders.status', 'Return Confirm')
        //             ->where('orders.user_id', $merchant)
        //             ->whereBetween('orders.updated_at', [$fromdate, $todate])
        //             ->leftJoin('return_assigns','orders.tracking_id','return_assigns.tracking_id')
        //             ->select('orders.*','return_assigns.return_charge',
        //                 DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
        //                 ->get();
        // $tRc = $return->sum('return_charge');
        // $tAmt = $tMPay - $tRc ;
        return view('Admin.PaymentInfo.merchant_pay_report', compact(
            'name',
            'phone',
            'fromdate',
            'todate',
            'complete',
            'return',
            'tCol',
            'tMPay',
            'tRc',
            'tAmt',
            'company'
        ));
    }

    public function adjustment(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view(
            'Admin.Report.Payment.payment_adjustment',
            compact('fromdate', 'todate', 'complete', 'return', 'tCol', 'tMPay', 'tRc', 'tAmt')
        );
    }

    public function adjustment_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view(
            'Admin.Report.Payment.payment_adjustment_print',
            compact('company', 'fromdate', 'todate', 'complete', 'return', 'tCol', 'tMPay', 'tRc', 'tAmt')
        );
    }

    public function merchant_adjustment(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $merchant = $request->merchant;
        $user = User::where('role', 12)->get();
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', $merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->where('orders.user_id', $merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                'users.name as merchant',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view('Admin.Report.Payment.merchant_payment_adjustment', compact(
            'user',
            'merchant',
            'fromdate',
            'todate',
            'complete',
            'return',
            'tCol',
            'tMPay',
            'tRc',
            'tAmt'
        ));
    }

    public function merchant_adjustment_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $data = User::find($request->merchant);
        $merchant = $data->name;
        $phone = $data->mobile;
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', $request->merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->where('orders.user_id', $request->merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view('Admin.Report.Payment.merchant_payment_adjustment_print', compact(
            'company',
            'fromdate',
            'todate',
            'complete',
            'return',
            'tCol',
            'tMPay',
            'tRc',
            'tAmt',
            'merchant',
            'phone'
        ));
    }

    public function merchant_history(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->where('orders.user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view(
            'Admin.Report.Payment.merchant_history',
            compact('fromdate', 'todate', 'complete', 'return', 'tCol', 'tMPay', 'tRc', 'tAmt')
        );
    }

    public function merchant_history_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->where('orders.user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view(
            'Admin.Report.Payment.merchant_history_print',
            compact('company', 'fromdate', 'todate', 'complete', 'return', 'tCol', 'tMPay', 'tRc', 'tAmt')
        );
    }

    public function merchant_history2(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        /* 
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();

        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->where('orders.user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc; */
        $m_payments = MPayment::all();




        return view(
            'Admin.Report.Payment.merchant_history2',
            compact('fromdate', 'todate',  '$m_payments')
        );
    }


    public function merchantPayment(Request $request)
    {


        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        // $order = DB::table('orders')
        //         ->join('users','orders.user_id','=','users.id')
        //         ->leftJoin('order_confirms','orders.tracking_id','=','order_confirms.tracking_id')
        //         ->leftJoin('return_assigns','orders.tracking_id','=','return_assigns.tracking_id')
        //         ->where('orders.status', 'Payment Complete')
        //         ->orWhere('orders.status', 'Return Adjustment')
        //         ->whereBetween('orders.updated_at', [$fromdate, $todate])
        //         ->select('orders.user_id','users.name as merchant','orders.collection',
        //                 // DB::raw("SUM(order_confirms.merchant_pay) as tMp"),
        //                 // DB::raw("SUM(return_assigns.return_charge) as tRc"),
        //                 // DB::raw("SUM(orders.collection) as tC"),
        //                 'return_assigns.return_charge','order_confirms.merchant_pay')
        //         ->groupBy('orders.user_id','users.name','order_confirms.merchant_pay',
        //                 'return_assigns.return_charge','orders.collection')
        //         // ->select('orders.user_id','orders.status','orders.collection',
        //         //         'orders.updated_at','order_confirms.merchant_pay','users.name as merchant',
        //         //         'return_assigns.return_charge', 
        //         //         DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
        //                 // DB::raw("SUM(orders.collection) as tC"))
        //         ->get();
        // dd($order->groupBy('user_id'));
        // $order = DB::select("SELECT * FROM `orders` 
        //             WHERE orders.updated_at = ( SELECT SUM( payments.amount ) 
        //             FROM payments
        //             WHERE payments.purchase_id = purchases.id )");
        // $order = DB::table('orders')
        //             ->join('users','orders.user_id','users.id')
        //             ->leftJoin('order_confirms','orders.tracking_id','order_confirms.tracking_id')
        //             ->leftJoin('return_assigns','orders.tracking_id','return_assigns.tracking_id')
        //             // ->selectRaw('SUM(orders.collection) as coll', 'SUM(orders.merchant_pay) as pay',
        //             //             'SUM(orders.return_charge) as chrg', 
        //             //             'users.name as merchant', 
        //             //             'orders.status')
        //             ->select('orders.user_id','orders.status','orders.collection',
        //                 'orders.updated_at','order_confirms.merchant_pay','users.name as merchant',
        //                 'return_assigns.return_charge', 
        //                 DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"),
        //                 DB::raw("SUM(orders.collection) as tC"))
        //             ->whereBetween('orders.updated_at', [$fromdate, $todate])
        //             ->where('orders.status', 'Payment Complete')
        //             ->orWhere('orders.status', 'Return Adjustment')
        //             ->orderBy('orders.updated_at', 'DESC')
        //             // ->groupBy('orders.user_id')
        //             ->groupBy('orders.id','orders.user_id','orders.status','orders.collection',
        //                 'orders.updated_at','order_confirms.merchant_pay',
        //                 'return_assigns.return_charge','users.name as merchant')
        //             ->get();

        // $order = DB::table('orders')
        //         ->join('users','orders.user_id','=','users.id')
        //         ->leftJoin('order_confirms','orders.tracking_id','=','order_confirms.tracking_id')
        //         ->leftJoin('return_assigns','orders.tracking_id','=','return_assigns.tracking_id')
        //         ->where('orders.status', 'Payment Complete')
        //         ->orWhere('orders.status', 'Return Adjustment')
        //         ->whereBetween('orders.updated_at', [$fromdate, $todate])
        //         ->select('orders.user_id','users.name as merchant','orders.collection',
        //                 'return_assigns.return_charge','order_confirms.merchant_pay')
        //         ->groupBy('orders.user_id','users.name','order_confirms.merchant_pay',
        //                 'return_assigns.return_charge','orders.collection')
        //         ->get();
        // dd($order->groupBy('user_id'));

        $users = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.id', 'users.name', 'orders.updated_at')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', 'Payment Complete')
            ->orWhere('orders.status', 'Return Adjustment')
            ->groupBy('users.id', 'users.name', 'orders.updated_at')
            ->get();


        $order = new Collection();
        if (!$users->isEmpty()) {
            foreach ($users as $item) {
                $order->push((object)[
                    'merchant' => $item->name,
                    'collection' => $this->getTotalCollection($item->id),
                    'merchant_pay' => $this->getTotalMerchantPay($item->id),
                    'return_charge' => $this->getTotalReturnCharge($item->id),
                ]);
            }
        }
        // dd($order);

        $tCol = $order->sum('collection');
        $tMPay = $order->sum('merchant_pay');
        $tRc = $order->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view(
            'Admin.Report.Payment.merchant_payment',
            compact('fromdate', 'todate', 'order', 'tCol', 'tMPay', 'tRc', 'tAmt')
        );
    }

    public function getUserName($id)
    {
        $name = DB::table('orders')
            ->rightJoin('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.id', $id)
            ->select('users.name')
            ->first();

        if ($name != "" || $name != null) {
            return $name->name;
        } else {
            return "";
        }
    }

    public function getTotalCollection($user_id)
    {
        $data = DB::table('orders')
            ->where('orders.user_id', $user_id)
            ->select(DB::raw("SUM(orders.collection) as tC"))
            ->first();

        if ($data != "" || $data != null) {
            return $data->tC;
        } else {
            return 0;
        }
    }

    public function getTotalMerchantPay($user_id)
    {
        $data = DB::table('orders')
            ->rightJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->where('orders.user_id', $user_id)
            ->select(DB::raw("SUM(order_confirms.merchant_pay) as tMp"))
            ->first();

        if ($data != "" || $data != null) {
            return $data->tMp;
        } else {
            return 0;
        }
    }

    public function getTotalReturnCharge($user_id)
    {
        $data = DB::table('orders')
            ->rightJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->where('orders.user_id', $user_id)
            ->select(DB::raw("SUM(return_assigns.return_charge) as tRc"))
            ->first();

        if ($data != "" || $data != null) {
            return $data->tRc;
        } else {
            return 0;
        }
    }
    public function rider_payment_report(Request $request)
    {
        // return Auth::user()->role;

        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {

            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }

        if (Auth::user()->role == 8) {
            $payments_data = AgentPayment::where('agent_id', Auth::user()->id)->whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)->with('createby', 'rider', 'updateby')
                ->get();
        } else {
            $payments_data = AgentPayment::whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)->with('createby', 'rider', 'updateby')->get();
        }
        $payments = [];
        foreach ($payments_data as $payment) {

            $invoice_payment_details = AgentPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });

            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

            $payments[] = $payment;
        }


        return view(
            'Admin.Report.Payment.rider_payment_report',
            compact('payments', 'fromdate', 'todate',)
        );
    }
    public function agent_payment_report(Request $request)
    {

        $branches = Agent::all();
        $selected_branch = $request->agent_id ?? '';

        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {

            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }

        if ($selected_branch) {
            $payments_data = AgentPayment::where('agent_id', $selected_branch)->whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)->with('createby', 'agent', 'updateby')
                ->get();

            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = AgentPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } else {
            $payments = [];
        }


        return view(
            'Admin.Report.Payment.agent_payment_report',
            compact('payments', 'fromdate', 'todate', 'branches', 'selected_branch')
        );
    }

    /**
     * 
     */

    public function rider_info(Request $request)
    {

        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {

            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }
        $payments_data = ReturnAssign::where('create_by', Auth::user()->id)->latest('return_assigns.id')->whereDate('return_assigns.created_at', '>=', $fromdate)->whereDate('return_assigns.created_at', '<=', $todate)->with('creator', 'rider', 'updator', 'merchant')

            ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
            ->join('shops', 'shops.shop_name', 'return_assigns.shop')
            ->select('merchants.*', 'return_assigns.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.pickup_address as shop_address')
            ->get();
        // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
        //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        $payments = [];
        foreach ($payments_data as $payment) {

            $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });

            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

            $payments[] = $payment;
        }


        return view(
            'Backend.Return.index',
            compact('payments', 'fromdate', 'todate',)
        );
    }

    public function rider_info_show(ReturnAssign $returnassign)
    {
        //return ',gmnlksdjgfisdg';
        // return  $return =   $returnassign->invoice_id;

        $invid =  $returnassign->invoice_id;

        // $payments_data = ReturnAssignDetail::where('invoice_id',$invid)->
        // $payments_data = ReturnAssignDetail::where('invoice_id', $invid);
        // ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
        // ->join('shops', 'shops.shop_name', 'return_assigns.shop')
        // ->select('merchants.*', 'return_assigns.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.pickup_address as shop_address')

        $payments_data = ReturnAssignDetail::orderBy('return_assign_details.id', 'DESC')
            ->join('orders', 'return_assign_details.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('return_assign_details.*', 'orders.*', 'users.*', 'merchants.*', 'order_confirms.*',)
            ->where('return_assign_details.invoice_id',  $invid)
            ->get();


        return view('Backend.Return.show', compact('payments_data'));
    }
    public function rider_info_print(ReturnAssign $returnassign)
    {
        $invid =  $returnassign->invoice_id;

        // $payments_data = ReturnAssign::where('create_by', Auth::user()->id)->with('creator', 'rider', 'updator', 'merchant')
        //     ->where('invoice_id', $invid)
        //     ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
        //     ->join('shops', 'shops.shop_name', 'return_assigns.shop')
        //     ->select('merchants.*', 'return_assigns.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.pickup_address as shop_address')
        //     ->first();
        $payments_data = ReturnAssign::with('creator', 'rider', 'updator', 'merchant')
            ->where('invoice_id', $invid)
            ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
            ->join('users', 'users.id', 'return_assigns.merchant_id')
            ->select('merchants.*', 'users.*', 'return_assigns.*',)
            ->first();
        $company = Company::first();

        return view('Backend.Return.print', compact('payments_data', 'company', 'invid'));
    }


    public function merchantList()
    {

        $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
            ->where('return_assigns.merchant_id', Auth::user()->id)
            ->where('return_assigns.status', 'Return Reach To Merchant')
            ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
            ->join('shops', 'shops.shop_name', 'return_assigns.shop')
            ->select('merchants.*', 'return_assigns.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.pickup_address as shop_address')
            ->get();
        // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
        //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        $payments = [];
        foreach ($payments_data as $payment) {

            $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });

            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

            $payments[] = $payment;
        }

        return view('Backend.Merchant.return.index', compact('payments_data', 'payments'));
    }



    public function rider_payment_report_print(Request $request)
    {


        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {

            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }

        $company = Company::orderBy('id', 'DESC')->get();

        $payments_data = RiderPayment::whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        $payments = [];
        foreach ($payments_data as $payment) {

            $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });

            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

            $payments[] = $payment;
        }


        return view(
            'Admin.Report.Payment.rider_payment_report_print',
            compact('payments', 'fromdate', 'todate', 'company')
        );
    }

    public function rider_payment_show(RiderPayment $rider)
    {
        $invid = $rider->invoice_id;
        $rider = RiderPayment::join('users', 'rider_payments.rider_id', 'users.id')->where('rider_payments.invoice_id', $rider->invoice_id)->select('users.*')->first();

        $orders = RiderPaymentDetail::orderBy('rider_payment_details.id', 'DESC')
            ->join('orders', 'rider_payment_details.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('rider_payment_details.*', 'orders.*', 'merchants.*', 'order_confirms.*', 'users.*')
            ->where('rider_payment_details.invoice_id',  $invid)
            ->get();
        $total = $orders->sum('collect');

        return view('Admin.Report.Payment.rider_payment_show', compact('orders', 'rider', 'total'));
    }

    public function rider_transaction_show(AgentPayment $rider)
    {
        $invid = $rider->invoice_id;
        $rider = AgentPayment::join('users', 'agent_payments.agent_id', 'users.id')->where('agent_payments.invoice_id', $rider->invoice_id)->select('users.*')->first();

        $orders = AgentPaymentDetail::orderBy('agent_payment_details.id', 'DESC')
            ->join('orders', 'agent_payment_details.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('agent_payment_details.*', 'merchants.*', 'order_confirms.*', 'users.*', 'orders.*')

            ->where('agent_payment_details.invoice_id',  $invid)
            ->get();
        $total = $orders->sum('collect');

        return view('Admin.Report.Payment.agent_transaction_show', compact('orders', 'rider', 'total'));
    }
    public function rider_transaction_show_agent(Request $request)
    {
        // $invid = $rider->invoice_id;


        // // dd($invid);
        // $rider = RiderPayment::join('users', 'rider_payments.rider_id', 'users.id')->where('rider_payments.invoice_id', $rider->invoice_id)->select('users.*')->first();

        // $orders = RiderPaymentDetail::orderBy('rider_payment_details.id', 'DESC')
        //     ->join('orders', 'rider_payment_details.tracking_id', 'orders.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->select('rider_payment_details.*', 'orders.*', 'merchants.*', 'order_confirms.*',)
        //     ->where('rider_payment_details.invoice_id',  $invid)
        //     ->get();
        // $total = $orders->sum('collect');
        $invid = $request->invoice_id;


        $tracking_id = AgentPaymentDetail::orderBy('agent_payment_details.id', 'DESC')
            ->where('agent_payment_details.invoice_id', $invid)
            ->pluck('tracking_id')
            ->unique();
        $orders = Order::whereIn('orders.tracking_id', $tracking_id)
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'merchants.*', 'order_confirms.*')
            ->get();


        $total = $orders->sum('collect');



        return view('Admin.Report.Payment.agent_transaction_show_agent', compact('orders',  'total'));
    }






    public function rider_transaction_print(AgentPayment $rider)
    {
        $invid = $rider->invoice_id;
        $rider = AgentPayment::join('users', 'agent_payments.agent_id', 'users.id')->where('agent_payments.invoice_id', $rider->invoice_id)->select('users.*')->first();
        $company = Company::first();
        $orders = AgentPaymentDetail::orderBy('agent_payment_details.id', 'DESC')
            ->join('orders', 'agent_payment_details.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('agent_payment_details.*', 'orders.*', 'merchants.*', 'order_confirms.*',)

            ->where('agent_payment_details.invoice_id',  $invid)
            ->get();
        $total = $orders->sum('collect');

        return view('Admin.Report.Payment.agent_transaction_print', compact('orders', 'rider', 'total', 'company'));
    }
    public function rider_transaction_print_agent(RiderPayment $rider, Request $request)
    {
        // $invid = $rider->invoice_id;
        // $rider = RiderPayment::join('users', 'rider_payments.rider_id', 'users.id')->where('rider_payments.invoice_id', $rider->invoice_id)->select('users.*')->first();
        $company = Company::first();
        // $orders = RiderPaymentDetail::orderBy('rider_payment_details.id', 'DESC')
        //     ->join('orders', 'rider_payment_details.tracking_id', 'orders.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->select('rider_payment_details.*', 'orders.*', 'merchants.*', 'order_confirms.*',)

        //     ->where('rider_payment_details.invoice_id',  $invid)
        //     ->get();
        // $total = $orders->sum('collect');
        $invid = $request->invoice_id;


        $tracking_id = AgentPaymentDetail::orderBy('agent_payment_details.id', 'DESC')
            ->where('agent_payment_details.invoice_id', $invid)
            ->pluck('tracking_id')
            ->unique();
        $orders = Order::whereIn('orders.tracking_id', $tracking_id)
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'merchants.*', 'order_confirms.*')
            ->get();


        $total = $orders->sum('collect');

        return view('Admin.Report.Payment.agent_transaction_print_agent', compact('orders', 'total', 'invid', 'company'));
    }

    public function agent_transaction_report(Request $request)
    {
        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {

            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }
        if (Auth::user()->role == 10) {
            $payments_data = RiderPayment::orderBy('id', 'DESC')->where('rider_id', Auth::user()->id)
                ->whereDate('created_at', '>=', $fromdate)->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        } else if (Auth::user()->role == 8) {
            $payments_data = RiderPayment::orderBy('id', 'DESC')->where('created_by', Auth::user()->id)
                ->whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        } else {
            $payments_data = RiderPayment::orderBy('id', 'DESC')->whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        }

        $payments = [];
        foreach ($payments_data as $payment) {

            $invoice_payment_details = RiderPaymentDetail::orderBy('id', 'DESC')->where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });

            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

            $payments[] = $payment;
        }
        //  C:\xampp\htdocs\Courierlab_Agent_Wise\resources\views\Admin\Report\Payment\agent_transaction_history.blade.php

        return view(
            'Admin.Report.Payment.agent_transaction_history',
            compact('payments', 'fromdate', 'todate',)
        );
    }
    public function  agent_transaction_show(RiderPayment $rider)
    {
        return 'Under Constuction';
        // $invid = $rider->invoice_id;
        // $rider = RiderPayment::join('users', 'rider_payments.rider_id', 'users.id')->where('rider_payments.invoice_id', $rider->invoice_id)->select('users.*')->first();

        // $orders = RiderPaymentDetail::orderBy('rider_payment_details.id', 'DESC')
        //     ->join('orders', 'rider_payment_details.tracking_id', 'orders.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.trackingId')
        //     ->select('rider_payment_details.*', 'orders.*', 'merchants.*', 'order_confirms.*',)

        //     ->where('rider_payment_details.invoice_id',  $invid)
        //     ->get();
        // $total = $orders->sum('collect');

        // return view('Admin.Report.Payment.rider_payment_show', compact('orders', 'rider', 'total'));
    }

    public function daily_collection_report(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $merchant_payment_wise_id = MerchantPayment::where('status', 'Payment Received By Merchant')->distinct('m_user_id')->pluck('m_user_id');
        $merchants = Merchant::orderBy('merchants.id', 'DESC')->whereIn('user_id', $merchant_payment_wise_id)->get();
        $merchant = $request->merchant;

        if ($request->merchant) {

            $collection_report = MerchantPayment::where('m_payments.status', 'Payment Received By Merchant')
                ->where('m_payments.m_user_id', $merchant)
                ->whereBetween('m_payments.updated_at', [$fromdate, $todate])
                ->join('m_pay_details', 'm_payments.invoice_id', '=', 'm_pay_details.invoice_id')
                ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
                ->where('orders.status', 'Payment Completed')
                ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'users.id', 'orders.user_id')
                ->select(
                    'm_payments.*',
                    'orders.*',
                    'order_confirms.*',
                    'users.*',
                    'merchants.*',
                    'orders.created_at as order_create_date',
                    'm_payments.updated_at as payement_date'
                )
                ->get();

            $tcollect = $collection_report->sum('collect');
            $treturn  = $collection_report->sum('return_charge');
            $tcod = $collection_report->sum('cod');
            $tinsurance = $collection_report->sum('insurance');
            $tdelivery = $collection_report->sum('delivery');

            $tCol = $collection_report->sum('collection');
            $tMPay = $collection_report->sum('merchant_pay');
            $tpay = $tcollect - ($treturn + $tcod + $tinsurance + $tdelivery);



            return view('Admin.PaymentInfo.merchant_payment_report', compact('fromdate', 'todate', 'merchants', 'merchant', 'collection_report', 'tcollect', 'treturn', 'tcod', 'tinsurance', 'tdelivery', 'tCol', 'tMPay', 'tpay'));
        } else {

            $collection_report = MerchantPayment::where('m_payments.status', 'Payment Received By Merchant')
                ->whereBetween('m_payments.updated_at', [$fromdate, $todate])
                ->join('m_pay_details', 'm_payments.invoice_id', '=', 'm_pay_details.invoice_id')
                ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
                ->where('orders.status', 'Payment Completed')
                ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'users.id', 'orders.user_id')
                ->select(
                    'm_payments.*',
                    'orders.*',
                    'order_confirms.*',
                    'users.*',
                    'merchants.*',
                    'orders.created_at as order_create_date',
                    'm_payments.updated_at as payement_date'
                )
                ->get();

            $tcollect = $collection_report->sum('collect');
            $treturn  = $collection_report->sum('return_charge');
            $tcod1 = $collection_report->sum('cod');
            $tcod  = round($tcod1, 2);
            $tinsurance = $collection_report->sum('insurance');
            $tdelivery = $collection_report->sum('delivery');

            $tCol = $collection_report->sum('collection');
            $tMPay = $collection_report->sum('merchant_pay');
            $tpay = $tcollect - ($treturn + $tcod + $tinsurance + $tdelivery);



            return view('Admin.PaymentInfo.merchant_payment_report', compact('fromdate', 'todate', 'merchants', 'merchant', 'collection_report', 'tcollect', 'treturn', 'tcod', 'tinsurance', 'tdelivery', 'tCol', 'tMPay', 'tpay'));
        }
    }

    public function daily_collection_report_date_wise(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }


        $collection_report = MerchantPayment::where('m_payments.status', 'Payment Received By Merchant')
            ->whereBetween('m_payments.updated_at', [$fromdate, $todate])
            ->join('m_pay_details', 'm_payments.invoice_id', '=', 'm_pay_details.invoice_id')
            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            ->where('orders.status', 'Payment Completed')
            ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'users.id', 'orders.user_id')
            ->select(
                'm_payments.*',
                'orders.*',
                'order_confirms.*',
                'users.*',
                'merchants.*',
                'orders.created_at as order_create_date',
                'm_payments.updated_at as payement_date'
            )
            ->get();

        $tcollect = $collection_report->sum('collect');
        $treturn  = $collection_report->sum('return_charge');
        $tcod1 = $collection_report->sum('cod');
        $tcod  = round($tcod1, 2);
        $tinsurance = $collection_report->sum('insurance');
        $tdelivery = $collection_report->sum('delivery');

        $tCol = $collection_report->sum('collection');
        $tMPay = $collection_report->sum('merchant_pay');
        $tpay = $tcollect - ($treturn + $tcod + $tinsurance + $tdelivery);



        return view('Admin.PaymentInfo.merchant_payment_report_date_wise', compact('fromdate', 'todate', 'collection_report', 'tcollect', 'treturn', 'tcod', 'tinsurance', 'tdelivery', 'tCol', 'tMPay', 'tpay'));
    }

    public function daily_collection_report_print(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $merchant_payment_wise_id = MerchantPayment::where('status', 'Payment Received By Merchant')->distinct('m_user_id')->pluck('m_user_id');
        $merchants = Merchant::orderBy('merchants.id', 'DESC')->whereIn('user_id', $merchant_payment_wise_id)->get();

        $merchant_name = Merchant::orderBy('merchants.id', 'DESC')->where('user_id', $request->merchant)->first();
        $merchant = $request->merchant;

        if ($request->merchant) {

            $company = Company::first();
            $collection_report = MerchantPayment::where('m_payments.status', 'Payment Received By Merchant')
                ->where('m_payments.m_user_id', $merchant)
                ->whereBetween('m_payments.updated_at', [$fromdate, $todate])
                ->join('m_pay_details', 'm_payments.invoice_id', '=', 'm_pay_details.invoice_id')
                ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
                ->where('orders.status', 'Payment Completed')
                ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'users.id', 'orders.user_id')
                ->select(
                    'm_payments.*',
                    'orders.*',
                    'order_confirms.*',
                    'users.*',
                    'merchants.*',
                    'orders.created_at as order_create_date',
                    'm_payments.updated_at as payement_date'
                )
                ->get();

            $tcollect = $collection_report->sum('collect');
            $treturn  = $collection_report->sum('return_charge');
            $tcod = $collection_report->sum('cod');
            $tinsurance = $collection_report->sum('insurance');
            $tdelivery = $collection_report->sum('delivery');

            $tCol = $collection_report->sum('collection');
            $tMPay = $collection_report->sum('merchant_pay');
            $tpay = $tcollect - ($treturn + $tcod + $tinsurance + $tdelivery);



            return view('Backend.History.collection_report', compact('fromdate', 'todate', 'merchants', 'merchant', 'collection_report', 'tcollect', 'treturn', 'tcod', 'tinsurance', 'tdelivery', 'tCol', 'tMPay', 'tpay', 'company', 'merchant_name'));
        } else {
            $company = Company::first();
            $collection_report = MerchantPayment::where('m_payments.status', 'Payment Received By Merchant')
                ->whereBetween('m_payments.updated_at', [$fromdate, $todate])
                ->join('m_pay_details', 'm_payments.invoice_id', '=', 'm_pay_details.invoice_id')
                ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
                ->where('orders.status', 'Payment Completed')
                ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'users.id', 'orders.user_id')
                ->select(
                    'm_payments.*',
                    'orders.*',
                    'order_confirms.*',
                    'users.*',
                    'merchants.*',
                    'orders.created_at as order_create_date',
                    'm_payments.updated_at as payement_date'
                )
                ->get();

            $tcollect = $collection_report->sum('collect');
            $treturn  = $collection_report->sum('return_charge');
            $tcod1 = $collection_report->sum('cod');
            $tcod  = round($tcod1, 2);
            $tinsurance = $collection_report->sum('insurance');
            $tdelivery = $collection_report->sum('delivery');

            $tCol = $collection_report->sum('collection');
            $tMPay = $collection_report->sum('merchant_pay');
            $tpay = $tcollect - ($treturn + $tcod + $tinsurance + $tdelivery);



            return view('Backend.History.collection_report', compact('fromdate', 'todate', 'merchants', 'merchant', 'collection_report', 'tcollect', 'treturn', 'tcod', 'tinsurance', 'tdelivery', 'tCol', 'tMPay', 'tpay', 'company'));
        }
    }
}
