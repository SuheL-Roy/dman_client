<?php

namespace App\Http\Controllers;

use App\Admin\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentInfoController extends Controller
{
    public function payment_info()
    {
        // return "hdfghjdfg";
        // $payment = PaymentInfo::where('user_id', Auth::user()->id)->get();
        // return view('Admin.PaymentInfo.payment_info', compact('payment'));

        if (auth()->user()->role == 1) {

            $data = PaymentInfo::orderBy('payment_infos.id', 'DESC')
                ->join('users', 'payment_infos.user_id', '=', 'users.id')
                //->where('payment_infos.user_id', Auth::user()->id)
                ->select('payment_infos.id as id', 'users.name as name', 'payment_infos.bank_name as bankname', 'payment_infos.branch_name as branchname', 'payment_infos.account_holder_name as accountholdername', 'payment_infos.account_type as accounttype', 'payment_infos.account_number as accountno', 'payment_infos.routing_number as routingnumber', 'payment_infos.mb_name as mb_name', 'payment_infos.mb_type as mb_type', 'payment_infos.mb_number as mb_number', 'payment_infos.p_type as p_type')
                ->get();
     

            return view('Admin.PaymentInfo.merchant_payment_info', compact('data'));
        } elseif (auth()->user()->role == 12) {
            $data = PaymentInfo::orderBy('payment_infos.id', 'DESC')
                ->join('users', 'payment_infos.user_id', '=', 'users.id')
                ->where('payment_infos.user_id', Auth::user()->id)
                ->select('payment_infos.id as id', 'users.name as name', 'payment_infos.bank_name as bankname', 'payment_infos.branch_name as branchname', 'payment_infos.account_holder_name as accountholdername', 'payment_infos.account_type as accounttype', 'payment_infos.account_number as accountno', 'payment_infos.routing_number as routingnumber', 'payment_infos.mb_name as mb_name', 'payment_infos.mb_type as mb_type', 'payment_infos.mb_number as mb_number', 'payment_infos.p_type as p_type')
                ->get();


            return view('Admin.PaymentInfo.merchant_payment_info', compact('data'));
        }elseif (auth()->user()->role == 6) {
            $data = PaymentInfo::orderBy('payment_infos.id', 'DESC')
                ->join('users', 'payment_infos.user_id', '=', 'users.id')
                ->where('payment_infos.user_id', Auth::user()->id)
                ->select('payment_infos.id as id', 'users.name as name', 'payment_infos.bank_name as bankname', 'payment_infos.branch_name as branchname', 'payment_infos.account_holder_name as accountholdername', 'payment_infos.account_type as accounttype', 'payment_infos.account_number as accountno', 'payment_infos.routing_number as routingnumber', 'payment_infos.mb_name as mb_name', 'payment_infos.mb_type as mb_type', 'payment_infos.mb_number as mb_number', 'payment_infos.p_type as p_type')
                ->get();


            return view('Admin.PaymentInfo.merchant_payment_info', compact('data'));
        }
    }



    public function payment_info_edit(Request $request)
    {
        $data = PaymentInfo::Where('payment_infos.id', $request->id)
            ->join('users', 'users.id', '=', 'payment_infos.user_id')
            ->select('payment_infos.id as id', 'users.name as name', 'payment_infos.bank_name as bankname', 'payment_infos.branch_name as branchname', 'payment_infos.account_holder_name as accountholdername', 'payment_infos.account_type as accounttype', 'payment_infos.account_number as accountno', 'payment_infos.routing_number as routingnumber', 'payment_infos.mb_name as mb_name', 'payment_infos.mb_type as mb_type', 'payment_infos.mb_number as mb_number', 'payment_infos.p_type as p_type')
            ->first();
        $form_select = $data->p_type;

        return view('Admin.PaymentInfo.update_info', compact('data', 'form_select'));
    }
    public function payment_info_update(Request $request)
    {
        $merchant = PaymentInfo::where('id', $request->id)->first();
        if ($request->p_type == 'Bank') {
            PaymentInfo::where('id', $request->id)
                ->delete();

            $paymentInfo = new PaymentInfo();
            $paymentInfo->user_id = $merchant->user_id;
            $paymentInfo->p_type = $request->p_type;
            $paymentInfo->bank_name    = $request->bank_name;
            $paymentInfo->branch_name    = $request->branch_name;
            $paymentInfo->account_holder_name    = $request->account_holder_name;
            $paymentInfo->account_type    = $request->account_type;
            $paymentInfo->account_number    = $request->account_number;
            $paymentInfo->routing_number    = $request->routing_number;
            $paymentInfo->save();
        } else {
            PaymentInfo::where('id', $request->id)
                ->delete();
            $paymentInfo = new PaymentInfo();
            $paymentInfo->user_id = $merchant->user_id;
            $paymentInfo->p_type = $request->p_type;
            $paymentInfo->mb_name    = $request->p_type;
            $paymentInfo->mb_type   = $request->mb_type;
            $paymentInfo->mb_number    = $request->mb_number;
            $paymentInfo->save();
        }

        return redirect()->route('accounts.merchant.paymentinfo')->with('message', 'Payment Information Updated Successfully');
    }

    public function payment_update(Request $request)
    {
        if ($request->bkash_number) {
            $this->validate($request, ['bkash_number' => 'required|digits:11|']);
            PaymentInfo::where('user_id', Auth::user()->id)
                ->update(['bkash_number' => $request->bkash_number]);
        } else {
            PaymentInfo::where('user_id', Auth::user()->id)
                ->update([
                    'bank_name'             => $request->bank_name,
                    'branch_name'           => $request->branch_name,
                    'account_holder_name'   => $request->account_holder_name,
                    'account_type'          => $request->account_type,
                    'account_number'        => $request->account_number,
                    'routing_number'        => $request->routing_number
                ]);
        }
        return redirect()->back()->with('status', ' Merchant Payment Info Updated Successfully');
    }

    public function add_info()
    {

        return view('Admin.PaymentInfo.add_info');
    }
    public function paymentInfoSave(Request $request)
    {
        // return "dfkgjkhed";
        // $data   = new PaymentInfo();
        // $data->user_id              = Auth::user()->id;
        // $data->bank_name            = $request->bank_name;
        // $data->branch_name          = $request->branch_name;
        // $data->account_holder_name  = $request->account_holder_name;
        // $data->account_type         = $request->account_type;
        // $data->account_number       = $request->account_number;
        // $data->routing_number       = $request->routing_number;
        // $data->bkash_account        = $request->bkash_account;
        // $data->bkash_number         = $request->bkash_number;
        // $data->save();
        if ($request->p_type == 'Bank') {
            $paymentInfo = new PaymentInfo();
            $paymentInfo->user_id = Auth::user()->id;
            $paymentInfo->p_type = $request->p_type;
            $paymentInfo->bank_name    = $request->bank_name;
            $paymentInfo->branch_name    = $request->branch_name;
            $paymentInfo->account_holder_name    = $request->account_holder_name;
            $paymentInfo->account_type    = $request->account_type;
            $paymentInfo->account_number    = $request->account_number;
            $paymentInfo->routing_number    = $request->routing_number;
            $paymentInfo->save();
        } else {
            $paymentInfo = new PaymentInfo();
            $paymentInfo->user_id = Auth::user()->id;
            $paymentInfo->p_type = $request->p_type;
            $paymentInfo->mb_name    = $request->p_type;
            $paymentInfo->mb_type   = $request->mb_type;
            $paymentInfo->mb_number    = $request->mb_number;
            $paymentInfo->save();
        }
        return redirect('merchant/info')->with('status', ' Merchant Payment Info Updated Successfully');
    }

    // public function paymentInfoSave(Request $request)
    // {
    //     $data   = new PaymentInfo();
    //     $data->user_id              = Auth::user()->id;
    //     $data->bank_name            = $request->bank_name;
    //     $data->branch_name          = $request->branch_name;
    //     $data->account_holder_name  = $request->account_holder_name;
    //     $data->account_type         = $request->account_type;
    //     $data->account_number       = $request->account_number;
    //     $data->routing_number       = $request->routing_number;
    //     $data->bkash_account        = $request->bkash_account;
    //     $data->bkash_number         = $request->bkash_number;
    //     $data->save();
    //     // if($request->bkash_account)
    //     // {
    //     //     PaymentInfo::create([ 
    //     //                         'bkash_account' => $request->bkash_account, 
    //     //                         'bkash_number'  => $request->bkash_number 
    //     //                     ]);
    //     // } else {
    //     //         PaymentInfo::create([ 
    //     //                     'bank_name'             => $request->bank_name,
    //     //                     'branch_name'           => $request->branch_name,
    //     //                     'account_holder_name'   => $request->account_holder_name,
    //     //                     'account_type'          => $request->account_type,
    //     //                     'account_number'        => $request->account_number,
    //     //                     'routing_number'        => $request->routing_number
    //     //                 ]);
    //     // }
    //     return redirect('merchant/info')->with('status',' Merchant Payment Info Updated Successfully');
    // }



}
