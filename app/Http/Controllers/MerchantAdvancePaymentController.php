<?php

namespace App\Http\Controllers;

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
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MerchantAdvancePaymentController extends Controller
{
    public function merchant_advance_payment(Request $request)
    {
        $merchants = User::join('merchants', 'users.id', 'merchants.user_id')->select('users.*', 'merchants.*')->get();
        $merchant = $request->merchant;
        $advancePayments = MerchantAdvancePayment::orderBy('id', 'DESC')->get();
        return view('Admin.PaymentInfo.merchant_advance_pay_report', compact('merchant', 'merchants', 'advancePayments'));
    }

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

    public function merchent_pay_info(Request $request)
    {
        $today = date('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $merchants = Merchant::with('creator')->get();
        $payments = MerchantPayment::latest('id')->with(['creator', 'merchant'])
            ->get();
        $selectedMerchant = [];

        return view('Backend.Merchant.index', compact('merchants', 'fromdate', 'today', 'payments', 'selectedMerchant'));
    }
    public function merchent_pay_info_load(Request $request)
    {
        // return $request;
        
        $merchants = Merchant::all();
        $today = date('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $merchant = Merchant::where('user_id', $request->merchant)->first();
        $payments = MerchantPayment::latest('id')->whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)->where('m_id', $merchant->id)->with('createby')->get();
        $selectedMerchant = $merchant->user_id;

        return view('Backend.Merchant.index', compact('merchants', 'fromdate', 'today', 'payments', 'selectedMerchant'));
    }

    public function merchent_pay_info_show(MerchantPayment $merchantpay)
    {
        // return Merchant::all();

        $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)

            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            ->join('shops', 'orders.user_id',  'shops.user_id')
            ->join('merchants', 'orders.user_id',  'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
            ->select('m_pay_details.*', 'orders.*', 'shops.*', 'order_confirms.*', 'merchants.business_name as merchant')

            ->get();
        $merchantPayments = $merchantPayments->flatten()->unique('tracking_id');

        $paymentInfo =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();

        $adjInfo =  MerchantPaymentAdjustment::where('invoice_id', $merchantpay->invoice_id)->first();

        $tCollect = $merchantPayments->sum('collect');
        $tCod = $merchantPayments->sum('cod');
        $tInsurance = $merchantPayments->sum('insurance');
        $tDelivery = $merchantPayments->sum('delivery');
        $tReturnCharge = $merchantPayments->sum('return_charge');
        $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);



        return view('Backend.Merchant.show', compact(
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

    public function merchent_pay_info_print(MerchantPayment $merchantpay)
    {
        $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)
            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            ->join('shops', 'orders.user_id',  'shops.user_id')
            ->join('merchants', 'orders.user_id',  'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')

            ->select('m_pay_details.*', 'orders.*', 'shops.*', 'order_confirms.*', 'merchants.business_name as merchant')
            ->get();
        $merchantPayments = $merchantPayments->flatten()->unique('tracking_id');
        $company = Company::latest('id')->first();
        $paymentInfo =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();

        $adjInfo =  MerchantPaymentAdjustment::where('invoice_id', $merchantpay->invoice_id)->first();

        $tCollect = $merchantPayments->sum('collect');
        $tCod = $merchantPayments->sum('cod');
        $tInsurance = $merchantPayments->sum('insurance');
        $tDelivery = $merchantPayments->sum('delivery');
        $tReturnCharge = $merchantPayments->sum('return_charge');
        $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);



        $payment =  MerchantPaymentInfo::where('invoice_id', $merchantpay->invoice_id)->first();
        return view('Backend.Merchant.print', compact(
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
        ));
    }
}
