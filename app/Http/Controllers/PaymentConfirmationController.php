<?php

namespace App\Http\Controllers;

use App\Admin\Merchant;
use App\Admin\MerchantPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentConfirmationController extends Controller
{

    /**
     *
     * @param  Merchant
     * @param  MerchantPayment
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function index()
    {
       
        $merchantid = Auth::user()->id;
        $merchants = Merchant::latest('id')->get();
   // return Auth::user()->id;
       $payments = MerchantPayment::with('creator')->where('m_user_id',Auth::user()->id)->whereIn('status',['Payment Paid By Fulfillment','Payment Processing'])->get();
        $selectedMerchant = '';
        $fromdate = date('Y-m-d');
        $today = date('Y-m-d');
        $tpay =$payments->sum('t_payable');

        //return [$payments,$fromdate,$today];

        return view('Backend.Payment.index', compact('merchants', 'tpay', 'payments', 'merchants', 'selectedMerchant','fromdate','today'));
    }
}
