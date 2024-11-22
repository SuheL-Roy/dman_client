<?php

namespace App\Http\Controllers;

use App\Admin\AgentPayment;
use App\Admin\AgentPaymentDetail;
use App\Admin\OrderConfirm;
use Illuminate\Http\Request;

class RiderCollectController extends Controller
{
    public function rider_collect(Request $request)
    {
        // return "sd,mfhsdjkf";
        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }


        return   $payments_data = AgentPayment::whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)->with('agent', 'create', 'updateby')->where('status', 0)->get();


        $payments = [];
        foreach ($payments_data as $payment) {
            // return $payment;
            $invoice_payment_details = AgentPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();
            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });
            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');
            $payments[] = $payment;
        }
        // return $payments;


        return view('Backend.Rider.index', compact('fromdate', 'todate', 'payments'));
    }


    public function rider_payment_report(Request $request)
    {
        // return "djghdfhgbdf";
        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }
        $payments_data = RiderPayment::whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        $payments = [];
        foreach ($payments_data as $payment) {
            $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();
            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });
            $payment['t_collect'] = OrderConfirm::whereIn('trackingId', $array)->sum('collect');
            $payments[] = $payment;
        }
        return view(
            'Admin.Report.Payment.rider_payment_report',
            compact('payments', 'fromdate', 'todate',)
        );
    }


    public function rider_collect_show(AgentPayment $agent)
    {
        // return $agent->invoice_id;
        return view('Backend.Agent.show', compact('agent'));
    }


    public function agent_payment_collec(AgentPayment $agent)
    {
        $details = AgentPaymentDetail::where('invoice_id', $agent->invoice_id)->get();

        if ($details) {
            foreach ($details as $detail) {

                if ($detail->order_status == 'Delivered Amount Send to Fulfillment') {

                    Order::where('tracking_id', $detail->tracking_id)->update(['status' => 'Payment Processing']);

                    $data = new OrderStatusHistory();
                    $data->tracking_id  = $detail->tracking_id;
                    $data->user_id      = Auth::user()->id;
                    $data->status       = 'Payment Processing';
                    $data->save();
                } else {

                    Order::where('tracking_id', $detail->tracking_id)->update(['status' => 'Return Payment Processing']);

                    $data = new OrderStatusHistory();
                    $data->tracking_id  = $detail->tracking_id;
                    $data->user_id      = Auth::user()->id;
                    $data->status       = 'Return Payment Processing';
                    $data->save();
                }
            }

            AgentPayment::where('invoice_id', $agent->invoice_id)->update(['status' => 1]);

            \Toastr::success('Successfully collected from agent.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }




        return AgentPayment::where('invoice_id', $agent->invoice_id)->get();
    }
}
