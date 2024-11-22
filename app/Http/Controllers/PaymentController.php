<?php

namespace App\Http\Controllers;

use App\Admin\PaymentInfo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function merchant_payment_info(Request $request)
    {
        $data = PaymentInfo::orderBy('payment_infos.id', 'DESC')
            ->join('users', 'payment_infos.user_id', '=', 'users.id')
            ->select('payment_infos.id as id', 'users.name as name', 'payment_infos.bank_name as bankname', 'payment_infos.branch_name as branchname', 'payment_infos.account_holder_name as accountholdername', 'payment_infos.account_type as accounttype', 'payment_infos.account_number as accountno', 'payment_infos.routing_number as routingnumber', 'payment_infos.mb_name as mb_name', 'payment_infos.mb_type as mb_type', 'payment_infos.mb_number as mb_number', 'payment_infos.p_type as p_type')
            ->get();
        return view('Admin.PaymentInfo.merchant_payment_info', compact('data'));
    }
    public function merchant_payment_info_edit(Request $request)
    {
        $data = PaymentInfo::Where('payment_infos.id', $request->id)
            ->join('users', 'users.id', '=', 'payment_infos.user_id')
            ->select('payment_infos.id as id', 'users.name as name', 'payment_infos.bank_name as bankname', 'payment_infos.branch_name as branchname', 'payment_infos.account_holder_name as accountholdername', 'payment_infos.account_type as accounttype', 'payment_infos.account_number as accountno', 'payment_infos.routing_number as routingnumber', 'payment_infos.mb_name as mb_name', 'payment_infos.mb_type as mb_type', 'payment_infos.mb_number as mb_number', 'payment_infos.p_type as p_type')
            ->first();
        $form_select = $data->p_type;
        return view('Admin.PaymentInfo.update_info', compact('data', 'form_select'));
    }
    public function merchant_payment_info_update(Request $request)
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
}
