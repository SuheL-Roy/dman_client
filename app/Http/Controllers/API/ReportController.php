<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\ReturnAssign;
use App\Admin\Rider;
use App\Admin\RiderPaymentDetail;
use App\Admin\Transfer;
use App\Admin\TransferToAgent;
use App\User;

class ReportController extends Controller
{
    //   public function __construct()
    //     {
    //         $this->middleware('auth:api');

    //     }

    public function rider_print($id)
    {

        $company = Company::orderBy('id', 'DESC')->get();
        $datas = Order::find($id);
        $order = Order::find($id)->user()->first();


        return response()->json([
            'company' => $company,
            'datas' => $datas,
            'order' => $order,
        ]);
    }


    public function reportmerchant(Request $request)
    {
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $status = $request->status;
        $data = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', $status)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->get();

        //   return response()->json($data);
        return response()->json(array(
            'status' => $status,
            'fromdate' => $fromdate,
            'todate' => $todate,
            'data' => $data,
        ));
    }

    //     public function reportmerchant(Request $request)
    //   {
    //     $today = date('Y-m-d');
    //     $status = $request->status;
    //     $fromdate = $request->fromdate;
    //     if ($request->todate){
    //         $todate = $request->todate;
    //     } else {
    //         $todate = $today;
    //     }

    //         $data = Order::orderBy('orders.id', 'DESC')
    //                 // ->whereBetween('orders.updated_at', [$fromdate, $todate])
    //                 // ->where('orders.user_id')
    //                 ->where('orders.status', $status)
    //                 // ->leftJoin('order_confirms','orders.tracking_id','order_confirms.tracking_id')
    //                 // ->select('orders.*','order_confirms.merchant_pay',
    //                 //     DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date"))
    //                 ->get();

    //       return response()->json(array(
    //             'today' => $today,
    //             'status' => $status,
    //             'fromdate' => $fromdate,
    //             'todate' => $todate,
    //             'data' => $data,
    //         ));
    //   }

    public function customertrack(Request $request)
    {
        if ($request->id == !null) {
            $data = Order::where('tracking_id', $request->id)->first();
            if ($data == null) {
                $msg = "Please Enter A Valid Tracking ID And Try Again.";
            } else {
                $status = $data->status;
                $customer = $data->customer_name;
                $msg = "Tracking ID : " . $request->id . " , Customer Name : " . $customer .  " , Order Status : " . $status;
            }
        } else {
            $msg = "Please Enter A Valid Tracking ID And Try Again.";
        }
        //   $request->session()->flash('message', $msg);

        //   return response()->json(array(
        //           'data' => $data,
        //         //   'status' => $status,
        //         //   'customer' => $customer,
        //           'msg' => $msg,
        //       ));
        return response()->json($msg);
    }

    public function pickreport(Request $request)
    {
        if ($request->todate) {
            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $pRt = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'PickUp Request')
                ->count();
            $pCt = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Order Collect')
                ->count();
            $pCl = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'PickUp Cancel')
                ->count();
            $dWt = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Order Delivered')
                ->count();
            $dPg = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Processing')
                ->count();
            $pCt = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Complete')
                ->count();
            $uPu = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'PickUp Request')
                ->where('type', 1)
                ->count();
            $rPu = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'PickUp Request')
                ->where('type', 0)
                ->count();
        } else {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');
            $pRt = Order::where('orders.updated_at', $today)
                ->where('status', 'PickUp Request')
                ->count();
            $pCt = Order::where('orders.updated_at', $today)
                ->where('status', 'Order Collect')
                ->count();
            $pCl = Order::where('orders.updated_at', $today)
                ->where('status', 'PickUp Cancel')
                ->count();
            $dWt = Order::where('orders.updated_at', $today)
                ->where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('orders.updated_at', $today)
                ->where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('orders.updated_at', $today)
                ->where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Complete')
                ->count();
            $uPu = Order::where('orders.updated_at', $today)
                ->where('status', 'PickUp Request')
                ->where('type', 1)
                ->count();
            $rPu = Order::where('orders.updated_at', $today)
                ->where('status', 'PickUp Request')
                ->where('type', 0)
                ->count();
        }

        return response()->json(array(
            'todate' => $todate,
            'fromdate' => $fromdate,
            'pRt' => $pRt,
            'pCt' => $pCt,
            'pCl' => $pCl,
            'dWt' => $dWt,
            'dCt' => $dCt,
            'dPg' => $dPg,
            'pPr' => $pPr,
            'pCt' => $pCt,
            'uPu' => $uPu,
            'rPu' => $rPu,
        ));
    }


    public function collect_order(Request $request)
    {


        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }


        $user_id = auth('api')->user()->id;

        if (isset($fromdate)) {


            $order  = Order::orderBy('orders.id', 'DESC')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->select(
                    'orders.*',
                    'order_status_histories.user_id',
                    'users.name as merchant',
                    DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
                )
                ->whereDate('orders.updated_at', '>=', $fromdate)
                ->whereDate('orders.updated_at', '<=', $todate)
                ->where('order_status_histories.status', 'Order Collect')
                ->where('order_status_histories.user_id', $user_id)->get();

            $Qty = $order->count();
            $Total = $order->sum('collection');
        } else {

            $order = [];
            $Qty = null;
            $Total = null;
        }

        $data = [
            'order' => $order,
            'Qty' => $Qty,
            'Total' => $Total,
        ];

        return response()->json($data);
    }




    public function order_report_status(Request $request)
    {
        $today = date('Y-m-d');
        if ($request->todate && $request->fromdate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = $today;
        }
        $user_id = auth('api')->user()->id;
        if ($request->status) {
            $order  = Order::orderBy('orders.id', 'DESC')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->select(
                    'orders.*',
                    'order_confirms.*',
                    'merchants.business_name as merchant'
                )
                ->whereDate('orders.updated_at', '>=', $fromdate)
                ->whereDate('orders.updated_at', '<=', $todate)
                ->where('order_status_histories.status', $request->status)
                ->where('order_status_histories.user_id', $user_id)->get();

            $Qty = $order->count();
            $Total = $order->sum('collection');
        } else {
            $order  = Order::orderBy('orders.id', 'DESC')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->select('orders.*', 'order_confirms.*', 'merchants.business_name as merchant')
                ->whereDate('orders.updated_at', '>=', $fromdate)
                ->whereDate('orders.updated_at', '<=', $todate)
                // ->where('order_status_histories.status', $request->status)
                ->where('order_status_histories.user_id', $user_id)->get();

            $Qty = $order->count();
            $Total = $order->sum('collection');
        }
        $data = [
            'order' => $order,
            'Qty' => $Qty,
            'Total' => $Total,
        ];

        return response()->json($data);
    }





    public function return_list(Request $request)
    {

        $user_id = auth('api')->user()->id;

        $returns_data = ReturnAssign::latest('return_assigns.id')
            ->where('return_assigns.rider_id', $user_id)
            ->where('return_assigns.status', 'Assigned Rider For Return')
            ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
            ->join('users', 'users.id', 'return_assigns.merchant_id')
            ->select('return_assigns.*', 'users.address as address', 'users.mobile as mobile', 'merchants.business_name as business_name')
            ->get();

        $returns = [];
        foreach ($returns_data as $return) {

            $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $return->invoice_id)->select('tracking_id')->get();

            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });

            $return['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

            $returns[] = $return;
        }


        return response()->json(


            [
                'data' => $returns,
                'status' => false,
                'message' => 'Return Order List',
            ]
        );
    }
    public function transfer_list(Request $request)
    {


        $user_id = auth('api')->user()->id;
        $transfers = Transfer::with('sender', 'receiver')->where('media_id', $user_id)->where('status', 0)->get();


        return response()->json(


            [
                'data' => $transfers,
                'status' => false,
                'message' => 'Transfer List Data',
            ]
        );
    }

    public function delivery_confirm(Request $request)
    {
        //Rider Pickup Assign List
        $rider = Rider::where('user_id', Auth::user()->id)->first();
        $area = $rider->area;
        $selectedMerchant = '';
        $merchants = Order::orderBy('orders.id', 'DESC')
            ->whereIn('orders.status', ['Assigned Pickup Rider'])
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('merchants.*')
            ->where('merchants.area', $area)
            ->get()->unique('user_id');


        $data = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.*', 'users.mobile', 'users.address')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get();

        $order = $data->unique('tracking_id');


        return view('Admin.PickUpRequestAssign.assignedRequest', compact('order', 'merchants', 'selectedMerchant'));
    }


    public function transfer_orderReport(Request $request)
    {
        $today = date('Y-m-d');
        if ($request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $fromdate = $today;
            $todate = $today;
        }

        $user_id = auth('api')->user()->id;
        $transfers = Transfer::with('sender', 'receiver')->where('media_id', $user_id)->where('status', 1)->whereBetween('created_at', [$fromdate, $todate])->get();

        return response()->json(


            [
                'data' => $transfers,
                'status' => false,
                'message' => 'Transfer List Data',
            ]
        );
    }

    public function return_datewise(Request $request)
    {
        // return $request;
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        if ($fromdate) {

            $user_id = auth('api')->user()->id;

            $returns_data = ReturnAssign::latest('return_assigns.id')
                ->where('return_assigns.rider_id', $user_id)
                // ->where('return_assigns.status', 'Assigned Rider For Return')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('return_assigns.*', 'users.address as address', 'users.mobile as mobile', 'merchants.business_name as business_name')
                ->whereDate('return_assigns.updated_at', '>=', $fromdate)
                ->whereDate('return_assigns.updated_at', '<=', $todate)
                ->get();

            $returns = [];
            foreach ($returns_data as $return) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $return->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $return['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $returns[] = $return;
            }


            return response()->json(


                [
                    'data' => $returns,
                    'status' => true,
                    'message' => 'Return Order List',
                ]
            );
        } else {
            return response()->json(

                [
                    'data' => [],
                    'status' => false,
                    'message' => 'Return Order List',
                ]
            );
        }
    }
}
