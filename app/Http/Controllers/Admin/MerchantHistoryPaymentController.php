<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\Merchant;
use App\Admin\Order;
use App\Admin\TransferToAgent;
use App\Admin\MerchantAdvancePayment;
use App\Admin\MerchantPayment;
use App\Admin\MerchantPaymentAdjustment;
use App\Admin\MerchantPaymentDetail;
use App\Admin\MerchantPaymentInfo;
use App\Admin\OrderStatusHistory;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;


class MerchantHistoryPaymentController extends Controller
{

    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function merchant_advance_payment(Request $request)
    {
        $merchants = User::join('merchants', 'users.id', 'merchants.user_id')->select('users.*', 'merchants.*')->get();
        $merchant = $request->merchant;
        $advancePayments = MerchantAdvancePayment::orderBy('id', 'DESC')->get();
        return view('Admin.PaymentInfo.merchant_advance_pay_report', compact('merchant', 'merchants', 'advancePayments'));
    }



    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function getMerchant()
    {
        $merchantInfo = DB::table('users')
            ->join('merchants', 'merchants.user_id', 'users.id')
            ->select('users.*', 'merchants.*')
            ->where('merchants.id', request()->merchant)
            ->first();
        return response()->json([
            'merchantInfo' => $merchantInfo
        ]);
    }



    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function saveAdvancePayment(Request $request)
    {
        // return $request;
        $authid =   Auth::user()->id;
        $request->validate([
            'amount'     => 'required',
        ]);
        $data = new MerchantAdvancePayment();
        $data->user_id = $authid;
        $data->merchant_id = $request->merchant_id;
        $data->business = $request->business;
        $data->area = $request->area;
        $data->phone = $request->phone;
        $data->amount = $request->amount;
        $data->comment = $request->comment;
        $data->save();


        return redirect()->back()->with('success', 'Payment Done Successfully');
    }


    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function merchent_pay_info(Request $request)
    {
        // return "sjkbfjhkrg";
        $orderStatus = $request->status;
        $merchantid = Auth::user()->id;
        $today = date('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }
        $merchants = Merchant::latest('id')->get();

        if ($orderStatus) {
            $status  = $orderStatus == 'Payment Processing' ? ['Payment Processing', 'Payment Paid By Fulfillment'] : ['Payment Received By Merchant'];
            if (Auth::user()->role == 12) {
                $payments = MerchantPayment::where('m_user_id', $merchantid)->whereDate('updated_at', '>=', $fromdate)
                    ->whereDate('updated_at', '<=', $todate)->whereIn('status', $status)->with('creator')->get();
            } else {

                $payments = MerchantPayment::whereDate('updated_at', '>=', $fromdate)
                    ->whereDate('updated_at', '<=', $todate)->whereIn('status', $status)->with('creator')->get();
            }
        } else {
            $payments = [];
        }

        $user = User::where('role', 12)->join('merchants', 'merchants.user_id', 'users.id')->get();



        return view('Backend.History.index', compact('user', 'merchants', 'fromdate', 'today', 'payments', 'orderStatus'));
    }



    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function merchent_pay_info_load(Request $request)
    {


        $orderStatus = $request->status;

        $validated = $request->validate([
            'fromdate' => 'required',
            'todate' => 'required'
        ]);
        $merchantid = $request->merchant;

        $merchant = Merchant::where('user_id', $merchantid)->value('business_name');





        $merchants = [];
        $today = date('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        //$merchant = Merchant::where('user_id', $request->merchant)->first();
        if ($orderStatus) {
            $status  = $orderStatus == 'Payment Processing' ? ['Payment Processing', 'Payment Paid By Fulfillment'] : ['Payment Received By Merchant'];
            if (Auth::user()->role == 12) {
                $payments = MerchantPayment::orderBy('id', 'DESC')
                    ->where('m_payments.m_user_id', Auth::user()->id)
                    ->whereDate('updated_at', '>=', $fromdate)
                    ->whereDate('updated_at', '<=', $todate)->whereIn('status', $status)->with('creator')->get();
            } else {
                if ($merchantid) {



                    $payments = MerchantPayment::orderBy('m_payments.id', 'DESC')
                        //->join('merchants', 'merchants.user_id', 'm_payments.m_user_id')
                        ->where('m_payments.m_user_id', $merchantid)
                        ->whereDate('m_payments.updated_at', '>=', $fromdate)
                        ->whereDate('m_payments.updated_at', '<=', $todate)
                        ->join('merchants', 'merchants.user_id', 'm_payments.m_user_id')
                        ->join('users', 'm_payments.created_by', 'users.id')
                        ->whereIn('m_payments.status', $status)->select('m_payments.*', 'merchants.business_name', 'users.name')->get();

                    // return $payments;  
                } else {

                    // $payments = MerchantPayment::orderBy('m_payments.id', 'DESC')->join('merchants', 'merchants.user_id', 'm_payments.m_user_id')->whereDate('m_payments.updated_at', '>=', $fromdate)
                    //     ->whereDate('m_payments.updated_at', '<=', $todate)->whereIn('m_payments.status', $status)->with('creator')->get();

                    $payments = MerchantPayment::orderBy('m_payments.id', 'DESC')
                        //->join('merchants', 'merchants.user_id', 'm_payments.m_user_id')
                        // ->where('m_payments.m_user_id', $merchantid)
                        ->whereDate('m_payments.updated_at', '>=', $fromdate)
                        ->whereDate('m_payments.updated_at', '<=', $todate)
                        ->join('merchants', 'merchants.user_id', 'm_payments.m_user_id')
                        ->join('users', 'm_payments.created_by', 'users.id')
                        ->whereIn('m_payments.status', $status)->select('m_payments.*', 'merchants.business_name', 'users.name')->get();
                }
            }
        } else {


            $payments = [];
        }

        $user = User::where('role', 12)->join('merchants', 'merchants.user_id', 'users.id')->get();


        return view('Backend.History.index', compact('user', 'merchants', 'fromdate', 'today', 'payments', 'orderStatus'));
    }



    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function merchent_pay_info_show(Request $request)
    {



        return $merchantpay = MerchantPayment::where('invoice_id', $request->invoice_id)->first();

        return $merchantpay->invoice_id;

        return $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)

            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            //->join('users', 'orders.user_id',  'users.id')
            //->join('merchants', 'orders.user_id',  'merchants.user_id')
            //->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
            //->select('m_pay_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'merchants.business_name as merchant')
            ->get();



        $merchantPayments = $merchantPayments->unique('tracking_id');

        $paymentInfo =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();

        $adjInfo =  MerchantPaymentAdjustment::where('invoice_id', $merchantpay->invoice_id)->first();

        $tCollect = $merchantPayments->sum('collect');
        $tCod = $merchantPayments->sum('cod');
        $tInsurance = $merchantPayments->sum('insurance');
        $tDelivery = $merchantPayments->sum('delivery');
        $tReturnCharge = $merchantPayments->sum('return_charge');
        $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);



        return view('Backend.History.show', compact(
            'merchantPayments',
            'paymentInfo',
            'tCollect',
            'tCod',
            'tInsurance',
            'tDelivery',
            'tReturnCharge',
            'tPayable',
            'adjInfo',
        ));
    }




    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function merchent_pay_info_print(Request $request)
    {

        $invoice_ids = $request->invoice_id;


        $merchant_name = MerchantPayment::where('m_payments.invoice_id', $invoice_ids)
            ->join('merchants', 'merchants.id', 'm_payments.m_id')
            ->join('users', 'm_payments.m_user_id', 'users.id')
            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->first();




        $merchantpay = MerchantPayment::where('invoice_id', $request->invoice_id)->first();





        $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)
            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            ->join('users', 'orders.user_id',  'users.id')
            ->join('merchants', 'orders.user_id',  'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
            ->join('order_status_histories', 'order_confirms.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Transfer Order Delivered', 'Redx Cancel Order', 'Redex Order Delivered', 'Transfer Cancel Order', 'Cancel Order', 'Partially Delivered', 'Exchange Delivered', 'Reschedule Order'])
            ->select('m_pay_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'order_status_histories.status as reason_status', 'merchants.business_name as merchant')
            ->get()->unique('tracking_id');








        $company = Company::latest('id')->first();

        $paymentInfo =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();

        //  return $paymentInfo;


        $adjInfo =  MerchantPaymentAdjustment::where('invoice_id', $merchantpay->invoice_id)->first();


        $tCollection = $merchantPayments->sum('colection');
        $tCollect = $merchantPayments->sum('collect');
        $tCod = $merchantPayments->sum('cod');
        $tInsurance = $merchantPayments->sum('insurance');
        $tDelivery = $merchantPayments->sum('delivery');
        $tReturnCharge = $merchantPayments->sum('return_charge');
        $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);




        $payment =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();


        return view('Backend.History.print', compact(
            'merchantPayments',
            'payment',
            'company',
            'paymentInfo',
            'tCollect',
            'tCod',
            'tInsurance',
            'tDelivery',
            'tReturnCharge',
            'tPayable',
            'adjInfo',
            'invoice_ids',
            'merchant_name',
            'tCollection',
            'merchantpay'
        ));
    }

    public function export_details_print(Request $request)
    {
        $invoice_ids = $request->invoice_id;


        $merchant_name = MerchantPayment::where('m_payments.invoice_id', $invoice_ids)
            ->join('merchants', 'merchants.id', 'm_payments.m_id')
            ->join('users', 'm_payments.m_user_id', 'users.id')
            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->first();



        $merchantpay = MerchantPayment::where('invoice_id', $request->invoice_id)->first();





        $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)
            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            ->join('users', 'orders.user_id',  'users.id')
            ->join('merchants', 'orders.user_id',  'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
            ->join('order_status_histories', 'order_confirms.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Transfer Order Delivered', 'Redx Cancel Order', 'Redex Order Delivered', 'Transfer Cancel Order', 'Cancel Order', 'Partially Delivered', 'Exchange Delivered', 'Reschedule Order'])
            ->select('m_pay_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'order_status_histories.status as reason_status', 'merchants.business_name as merchant')
            ->get()->unique('tracking_id');



        // return $merchantPayments;




        $company = Company::latest('id')->first();

        $paymentInfo =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();

        //  return $paymentInfo;


        $adjInfo =  MerchantPaymentAdjustment::where('invoice_id', $merchantpay->invoice_id)->first();


        $tCollection = $merchantPayments->sum('colection');
        $tCollect = $merchantPayments->sum('collect');
        $tCod = $merchantPayments->sum('cod');
        $tInsurance = $merchantPayments->sum('insurance');
        $tDelivery = $merchantPayments->sum('delivery');
        $tReturnCharge = $merchantPayments->sum('return_charge');
        $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);




        $payment =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();


        return view('Backend.Merchant.Payment.Deatils_Print_export', compact(
            'merchantPayments',
            'payment',
            'company',
            'paymentInfo',
            'tCollect',
            'tCod',
            'tInsurance',
            'tDelivery',
            'tReturnCharge',
            'tPayable',
            'adjInfo',
            'invoice_ids',
            'merchant_name',
            'tCollection',
            'merchantpay'
        ));
    }



    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function merchent_pay_info_confirm(MerchantPayment $merchantpay)
    {
        $merchantpay->update([
            'status' => 'Payment Received By Merchant'
        ]);
        \Toastr::success('Successfully Payment Confirmed.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return back();
    }
}
