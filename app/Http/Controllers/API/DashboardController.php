<?php

namespace App\Http\Controllers\API;

use App\Admin\DeliveryAssign;
use App\Admin\MerchantPayment;
use App\Admin\MerchantPaymentDetail;
use App\Admin\MPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Order;
use App\User;
use App\Admin\PickUpRequestAssign;
use App\Admin\OrderStatusHistory;
use App\Admin\ReturnAssign;
use App\Admin\Transfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use DateTime;

class DashboardController extends Controller
{
    //  
    public function adminDashboard()
    {


        $today = date('Y-m-d');
        $pickupRequest = Order::orderBy('orders.updated_at', 'DESC')
            ->where('orders.status', 'PickUp Request', $today)
            ->count();
        $pickupCancel = Order::orderBy('updated_at', 'DESC', $today)
            ->where('status', 'PickUp Cancel')
            ->count();
        $paymentProcessing = Order::orderBy('updated_at', 'DESC', $today)
            ->where('status', 'Payment Processing')
            ->count();
        $paymentComplete = Order::orderBy('updated_at', 'DESC', $today)
            ->where('status', 'Payment Complete')
            ->count();

        $orderCollect = Order::orderBy('updated_at', 'DESC', $today)
            ->where('status', 'Order Collect')
            ->count();

        $orderDelivered = Order::orderBy('updated_at', 'DESC', $today)
            ->where('status', 'Order Delivered')
            ->count();


        return response()->json(array(
            'pickupRequest' => $pickupRequest,
            'orderCollect' => $orderCollect,
            'pickupCancel' => $pickupCancel,
            'paymentProcessing' => $paymentProcessing,
            'paymentComplete' => $paymentComplete,
            'orderDelivered' => $orderDelivered,
        ));
    }

    public function merchantdashboard(Request $request)
    {

        $today = date('Y-m-d');
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d');




        $today_order = Order::where('orders.user_id', Auth::user()->id)
            // ->where('orders.status', 'Order Placed')
            ->whereDate('orders.created_at', '<=', $todate)
            ->whereDate('orders.created_at', '>=', $fromdate)

            ->count();

        $total_order = Order::where('orders.user_id', Auth::user()->id)
            // ->where('orders.status', 'Order Placed')
            // ->whereDate('orders.created_at', '>=', $fromdate)
            // ->whereDate('orders.created_at', '<=', $todate)
            ->count();

        $orderTransit1 = Order::whereIn(
            'status',
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
        )->where('user_id', Auth::user()->id)->get();



        $orderTransit2 = Order::whereIn(
            'status',
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
            ->where('user_id', Auth::user()->id)
            ->whereDate('updated_at', '>=', $fromdate)
            ->whereDate('updated_at', '<=', $todate)
            ->get();

        $totalorderTransit = $orderTransit1->count();

        $todayorderTransit = $orderTransit2->count();


        $today_dalivery_amount = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
            ->whereDate('order_status_histories.updated_at', '<=', $todate)
            ->get()->sum('collection');

        $total_dalivery_amount = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->get()->sum('collection');

        /*delivery ration*/

        $total_success_delivery =  Order::where('orders.user_id', Auth::user()->id)
            ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered', 'Delivered Amount Collected from Branch', 'Delivered Amount Send to Fulfillment', 'Payment Processing', 'Payment Processing Complete', 'Payment Completed'])
            ->count();


        $total_unsuccessfully_delivery = Order::where('orders.user_id', Auth::user()->id)
            ->whereIn(
                'orders.status',
                [
                    'Order Placed',
                    'Assigned Pickup Rider',
                    'Pickup Done',
                    'Received by Pickup Branch',
                    'Transfer Assign for Fulfillment',
                    'Transfer Reach To Fullfilment',
                    'Received By Fullfilment',
                    'Transfer Assign for Branch',
                    'Assigned Rider For Destination Hub',
                    'Transfer Reach To Branch',
                    'Received By Destination Hub',
                    'Assigned To Delivery Rider',
                    'Rescheduled',
                    'Return Payment Processing',
                    'Hold Order Received from Branch',
                    'Return Reach For Branch',
                    'Order Bypass By Destination Hub',
                    'PickUp Cancel',

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
                    'Return To Merchant',
                    'Order Cancel by Branch',
                    'Order Cancel By Fullfilment',
                    'Exchange Delivered Received from Branch'

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


        $t_dalivery = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
            ->whereDate('order_status_histories.updated_at', '<=', $todate)
            ->count();

        $to_dalivery = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            // ->whereDate('order_status_histories.updated_at','>=',$fromdate)
            // ->whereDate('order_status_histories.updated_at','<=',$todate)
            ->count();
        $t_cancel = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['PickUp Cancel'])
            ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
            ->whereDate('order_status_histories.updated_at', '<=', $todate)
            ->count();
        $to_cancel = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['PickUp Cancel'])
            // ->whereDate('order_status_histories.updated_at','>=',$fromdate)
            // ->whereDate('order_status_histories.updated_at','<=',$todate)
            ->count();


        $t_return = Order::where('orders.user_id', Auth::user()->id)
            //->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
            ->whereDate('orders.updated_at', '>=', $fromdate)
            ->whereDate('orders.updated_at', '<=', $todate)
            ->count();

        $to_return = Order::where('orders.user_id', Auth::user()->id)
            //->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
            // ->whereDate('order_status_histories.updated_at','>=',$fromdate)
            // ->whereDate('order_status_histories.updated_at','<=',$todate)
            ->count();



        $t_hold_reschedule = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', [
                // 'Reschedule Order',
                //'Hold Order',
                'Hold Order Received from Branch', 'Rescheduled'
            ])
            ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
            ->whereDate('order_status_histories.updated_at', '<=', $todate)
            ->count();
        $to_hold_reschedule = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', [
                // 'Reschedule Order',
                // 'Hold Order',
                'Hold Order Received from Branch', 'Rescheduled'
            ])
            // ->whereDate('order_status_histories.updated_at','>=',$fromdate)
            // ->whereDate('order_status_histories.updated_at','<=',$todate)
            ->count();


        $paymentProcessing = MPayment::where('m_user_id', Auth::user()->id)
            ->whereIn('status', ['Payment Processing', 'Payment Paid By Fulfillment'])->get()->sum('t_payable');
        $paymentComplete = MPayment::where('m_user_id', Auth::user()->id)
            ->whereIn('status', ['Payment Received By Merchant'])->get()->sum('t_payable');

        return response()->json(array(
            'status' => true,
            'message' => 'Merchant Dashboard',
            'data' => array(
                'today_order' => $today_order,
                'total_order' => $total_order,
                'todayorderTransit' => $todayorderTransit,
                'totalorderTransit' => $totalorderTransit,
                'today_dalivery_amount' => $today_dalivery_amount,
                'total_dalivery_amount' => $total_dalivery_amount,
                'total_delivery_unsuccess_ratio' => $total_delivery_unsuccess_ratio,
                'total_delivery_success_ratio' => $total_delivery_success_ratio,
                'total_delivery_return_ratio' => $total_delivery_return_ratio,
                't_dalivery' => $t_dalivery,
                'to_dalivery' => $to_dalivery,
                't_cancel' => $t_cancel,
                'to_cancel' => $to_cancel,
                't_return' => $t_return,
                'to_return' => $to_return,
                't_hold_reschedule' => $t_hold_reschedule,
                'to_hold_reschedule' => $to_hold_reschedule,
                'paymentProcessing' => $paymentProcessing,
                'paymentComplete' => $paymentComplete,
                '$total_success_order' => $total_success_delivery,
                'total_unsuccess_order' => $total_unsuccessfully_delivery,
                'total_return_order' => $total_return,
            )
        ));
    }

    public function merchantdashboard_list(Request $request)
    {
        $total_order = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
            ->orderBy('orders.id', 'DESC')
            ->get();

        $total_delivery_order = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->join('order_confirms', 'order_status_histories.tracking_id', 'order_confirms.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])

            // ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
            // ->whereDate('order_status_histories.updated_at', '<=', $todate)
            ->get();

        $return_order_list = Order::where('orders.user_id', Auth::user()->id)
            //->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
            // ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
            // ->whereDate('order_status_histories.updated_at', '<=', $todate)
            ->get();


        $transit_order_list = Order::where('orders.user_id', Auth::user()->id)->join('merchants', 'orders.user_id', 'merchants.user_id')->whereIn(
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
                'Hold Order Received from Branch'
            ]
        )->get();


        $total_delivery_amount_list = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->get();


        $total_collection_delivery_amount = $total_delivery_amount_list->sum('collection');

        $total_collect_delivery_amount = $total_delivery_amount_list->sum('collect');


        $total_paymentProcessing_list = MPayment::where('m_user_id', Auth::user()->id)
            ->join('users', 'm_payments.created_by', 'users.id')
            ->whereIn('status', ['Payment Processing', 'Payment Paid By Fulfillment'])->select('m_payments.*', 'users.name as users_name')->get();

        $total_payable_payment_processing = $total_paymentProcessing_list->sum('t_payable');


        $total_paymentComplete_list = MPayment::where('m_user_id', Auth::user()->id)
            ->join('users', 'm_payments.created_by', 'users.id')
            ->whereIn('status', ['Payment Received By Merchant'])
            ->select('m_payments.*', 'users.name as users_name')->get();

        $total_payable_payment_complete = $total_paymentComplete_list->sum('t_payable');

        return response()->json([
            'total_order' => $total_order,
            'total_delivery_order' => $total_delivery_order,
            'return_order_list' => $return_order_list,
            'transit_order_list' => $transit_order_list,
            'total_delivery_amount_list' => $total_delivery_amount_list,
            'total_collection_delivery_amount' => $total_collection_delivery_amount,
            'total_collect_delivery_amount' => $total_collect_delivery_amount,
            'total_paymentProcessing_list' => $total_paymentProcessing_list,
            'total_payable_payment_processing' => $total_payable_payment_processing,
            'total_paid_amount_list' => $total_paymentComplete_list,
            'total_payable_paid_amount' => $total_payable_payment_complete
        ]);
    }

    public function invoice_wise_payment(Request $request)
    {


        // if ($request->invoice_id) {
        //     $merchantpay = MerchantPayment::where('m_user_id', Auth::user()->id)->where('invoice_id', $request->invoice_id)->first();


        //     $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)
        //         ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
        //         ->join('users', 'orders.user_id',  'users.id')
        //         ->join('merchants', 'orders.user_id',  'merchants.user_id')
        //         ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
        //         ->select('m_pay_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'merchants.business_name as merchant')
        //         ->get()->unique('tracking_id');




        //     $tCollection = $merchantPayments->sum('colection');
        //     $tCollect = $merchantPayments->sum('collect');
        //     $tCod = $merchantPayments->sum('cod');
        //     $tInsurance = $merchantPayments->sum('insurance');
        //     $tDelivery = $merchantPayments->sum('delivery');
        //     $tReturnCharge = $merchantPayments->sum('return_charge');
        //     $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);

        //     return response()->json([
        //         'merchant_Payments' => $merchantPayments,
        //         'total_collection' => $tCollection,
        //         'total_collect' => $tCollect,
        //         'total_cod' => $tCod,
        //         'total_delivery' => $tDelivery,
        //         'total_Return_charge' => $tReturnCharge,
        //         'total_payable' => $tPayable,

        //     ]);
        // } else {

        //     return response()->json([
        //         'message' => 'Credentials Does not Match',
        //     ]);
        // }
        try {
            if ($request->invoice_id) {
                $merchantpay = MerchantPayment::where('m_user_id', Auth::user()->id)->where('invoice_id', $request->invoice_id)->first();
        
                $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)
                    ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
                    ->join('users', 'orders.user_id',  'users.id')
                    ->join('merchants', 'orders.user_id',  'merchants.user_id')
                    ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
                    ->select('m_pay_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'merchants.business_name as merchant')
                    ->get()->unique('tracking_id');
        
                $tCollection = $merchantPayments->sum('colection');
                $tCollect = $merchantPayments->sum('collect');
                $tCod = $merchantPayments->sum('cod');
                $tInsurance = $merchantPayments->sum('insurance');
                $tDelivery = $merchantPayments->sum('delivery');
                $tReturnCharge = $merchantPayments->sum('return_charge');
                $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);
        
                return response()->json([
                    'merchant_Payments' => $merchantPayments,
                    'total_collection' => $tCollection,
                    'total_collect' => $tCollect,
                    'total_cod' => $tCod,
                    'total_delivery' => $tDelivery,
                    'total_Return_charge' => $tReturnCharge,
                    'total_payable' => $tPayable,
                ]);
            } else {
                return response()->json([
                    'message' => 'Credentials Do not Match',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function pickupdashboard(Request $request)
    {
        // return "dgdfgdf";

        $user_id = auth('api')->user()->id;
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d');
        // $today_pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id',$user_id)
        //     ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

        //     ->whereDate('order_status_histories.created_at','>=',$fromdate)
        //     ->whereDate('order_status_histories.created_at','<=',$todate)
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














        $total_pickup = PickUpRequestAssign::where('pick_up_request_assigns.user_id', $user_id)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->where('order_status_histories.status', 'Assigned Pickup Rider')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();
        // $today_delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', $user_id)
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





        $total_delivery = PickUpRequestAssign::where('pick_up_request_assigns.user_id', $user_id)
            ->join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')

            ->where('order_status_histories.status', 'Assigned To Delivery Rider')
            ->count();

        $today_return = ReturnAssign::where('rider_id', $user_id)->where('status', 'Assigned Rider For Return')
            ->whereDate('return_assigns.created_at', '>=', $fromdate)
            ->whereDate('return_assigns.created_at', '<=', $todate)
            ->count();

        $total_return = ReturnAssign::where('rider_id', $user_id)
            ->count();

        $today_transfer = Transfer::where('media_id', $user_id)->where('status', 0)
            ->whereDate('transfers.created_at', '>=', $fromdate)
            ->whereDate('transfers.created_at', '<=', $todate)
            ->count();
        $total_transfer = Transfer::where('media_id', $user_id)
            ->count();




        $today_delivered = OrderStatusHistory::where('user_id', $user_id)->where('status', 'Successfully Delivered')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->count();


        $date = new DateTime('now');
        $date->modify('first day of this month');
        $start_date = $date->format('Y-m-d');

        $date = new DateTime('now');
        $date->modify('last day of this month');
        $end_date = $date->format('Y-m-d');

        $monthly_delivered = OrderStatusHistory::where('user_id', $user_id)->where('status', 'Successfully Delivered')
            ->whereDate('order_status_histories.created_at', '>=', $start_date)
            ->whereDate('order_status_histories.created_at', '<=', $end_date)
            ->count();



        return response()->json([

            'today_pickup' => $today_pickup,
            'total_pickup' => $total_pickup,
            'today_delivery' => $today_delivery,
            'total_delivery' => $total_delivery,
            'today_return' => $today_return,
            'total_return' => $total_return,
            'today_transfer' => $today_transfer,
            'total_transfer' => $total_transfer,
            'today_delivered' => $today_delivered,
            'monthly_delivered' => $monthly_delivered

        ]);
    }
}
