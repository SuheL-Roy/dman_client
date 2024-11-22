<?php

namespace App\Http\Controllers;

use App\Admin\BranchDistrict;
use App\Admin\BusinessType;
use App\Admin\Company;
use App\Admin\Employee;
use App\Admin\Merchant;
use App\Admin\Order;
use App\Admin\PaymentInfo;
use App\Admin\Profile;
use App\Admin\Zone;
use App\Admin\Shop;
use App\User;
use App\Admin\District;
use App\Admin\CoverageArea;
use App\Admin\MerchantAdvancePayment;
use App\Admin\MerchantPaymentAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helper\Helpers\Helpers;

class MerchantController extends Controller
{
    public function index()
    {
        $data = User::orderBy('users.id', 'DESC')
            ->where('role', 12)
            ->orwhere('role', 13)
            ->join('merchants', 'users.id', 'merchants.user_id')
            ->join('zones', 'merchants.zone_id', 'zones.id')
            ->select(
                'merchants.*',
                'users.name',
                'zones.name as branch_name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(merchants.created_at, '%y') as od")
            )
            ->get();




        return view('Admin.Home.merchant_list', compact('data'));
    }

    //Rider Preview
    public function preview(Request $request)
    {
        $id       = $request->id;
        $user     = User::where('id', $id)->first();
        $merchant = Merchant::where('user_id', $id)->first();

        $payment  = PaymentInfo::where('user_id', $id)->get();
        $image    = Profile::where('user_id', $id)->first();

        $shops = Shop::where('user_id', $id)->get();

        return view('Admin.Home.merchant_preview', compact('id', 'user', 'merchant', 'payment', 'image', 'shops'));
    }

    public function print(Request $request)
    {
        $user     = User::where('id', $request->id)->first();
        $merchant = Merchant::where('user_id', $request->id)->first();
        $payment  = PaymentInfo::where('user_id', $request->id)->get();
        $image    = Profile::where('user_id', $request->id)->first();
        //dd($image);
        return view('Admin.Home.print_preview', compact('user', 'merchant', 'payment', 'image'));
    }

    // public function edit(Request $request)
    // {
    //     $data = User::where('id', $request->id)->get();
    //     return response()->json($data);
    // }
    public function edit(Request $request)
    {
        // $id       = $request->id;
        // $merchant = Merchant::where('user_id', $id)->first();
        // return $merchant->district;

        // return CoverageArea::all();

        $id       = $request->id;
        $user     = User::where('id', $id)->first();
        $merchant = Merchant::where('user_id', $id)->first();


        $businesstype = BusinessType::all();
        $area = Zone::all();

        $districts = BranchDistrict::where('z_id', $merchant->zone_id)->get();

        $payment  = PaymentInfo::where('user_id', $id)->get();
        $image    = Profile::where('user_id', $id)->first();

        return view('Admin.Home.merchant_edit', compact('id', 'user', 'merchant', 'payment', 'image', 'districts', 'area', 'businesstype'));
    }
    // public function update(Request $request)
    // {
    //     // return "dfgmnkdfgf";
    //     // return $request;

    //     User::where('id', $request->id)
    //         ->update([
    //             'name' => $request->name,
    //             'role' => $request->role,
    //         ]);
    //     return redirect()->back()->with('message', 'Merchant Into Updated Successfully');
    // }

    public function update(Request $request)
    {


        $user_id =  Merchant::where('id', $request->id)->value('user_id');


        //nid front file upload
        if ($request->hasFile('nid_front')) {
            $nid_front = $request->file('nid_front');
            $nid_front_name = uniqid() . $nid_front->getClientOriginalName();
            $uploadPath = 'public/Merchant/Profile/NidF/';
            $nid_front->move($uploadPath, $nid_front_name);
            $nid_front_Url = $uploadPath . $nid_front_name;

            Profile::where('user_id', $user_id)
                ->update([
                    'nid_front' => $nid_front_Url
                ]);
        }


        //nid back file upload
        if ($request->hasFile('nid_back')) {
            $nid_back = $request->file('nid_back');
            $nid_back_name = uniqid() . $nid_back->getClientOriginalName();
            $uploadPath = 'public/Merchant/Profile/NidB/';
            $nid_back->move($uploadPath, $nid_back_name);
            $nid_back_Url = $uploadPath . $nid_back_name;

            Profile::where('user_id', $user_id)
                ->update([
                    'nid_back' => $nid_back_Url
                ]);
        }



        User::where('id', $user_id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,

            ]);

        $district = District::where('id', $request->district)->first();
        $zone = Zone::where('id', '=', $request->area)->first();

        Merchant::where('id', $request->id)
            ->update([
                'business_name' => $request->business_name,
                'b_type' => $request->b_type,
                'district' => $district->name,
                'm_discount' => $request->m_discount,
                'ur_discount' => $request->ur_discount,
                'm_cod' => $request->m_cod,
                'm_sub_dhaka_cod' => $request->m_sub_dhaka_cod,
                'm_outside_dhaka_cod' => $request->m_outside_dhaka_cod,
                'm_insurance' => $request->m_insurance,
                'm_return_discount' => $request->m_return_discount,
                'area' => $zone->name,
                'district_id' => $district->id,
                'sub_dhaka_regular' => $request->sub_dhaka_regular,
                'sub_dhaka_express' => $request->sub_dhaka_express,
                'outside_dhaka_regular' => $request->outside_dhaka_regular,
                'outside_dhaka_express' => $request->outside_dhaka_express,
                'return_inside_dhaka_discount' => $request->return_inside_dhaka_discount,
                'return_outside_dhaka_discount' => $request->return_outside_dhaka_discount,
                'return_sub_dhaka_discount' => $request->return_sub_dhaka_discount,

                'm_ind_city_Re' => $request->m_ind_city_Re,
                'm_out_city_Re' => $request->m_out_city_Re,
                'm_sub_city_Re' => $request->m_sub_city_Re,
                'm_ind_city_Ur' => $request->m_ind_city_Ur,
                'm_out_City_Ur' => $request->m_out_City_Ur,
                'm_sub_city_Ur' => $request->m_sub_city_Ur,


                'm_inside_city_cod' => $request->m_inside_city_cod,
                'm_outside_city_cod' => $request->m_outside_city_cod,
                'm_sub_city_cod' => $request->m_sub_city_cod,

                'm_insurance' => $request->m_insurance,
                'zone_id' => $zone->id

            ]);
        return redirect()->route('shop.merchant.index')->with('message', 'Merchant Info Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = User::where('id', $request->id)->first();
        if ($data->role == 12) {
            $data->role = 13;
        } elseif ($data->role == 13) {
            $data->role = 12;
        }
        $data->save();

        $company = Company::where('id', 1)->first();
        $smsText = "Welcome to {$company->name}. Stay with us. If you have any queries, please contact - {$company->mobile}. Thank you.";
        Helpers::sms_send($data->mobile, $smsText);
        return redirect()->back()->with('message', 'Merchant Status Changed Successfully');
    }
    // public function emp_status(Request $request)
    // {
    //     $employee = Employee::where('merchant_id', $request->id)->first();
    //     if ($data->status == 1) {
    //         $data->status = 0;    
    //         $employee->status = 0;    
    //     }
    //     else {   
    //         $data->status = 1;  
    //         $employee->status = 1;
    //     }
    //     $data->save();
    //     return redirect()->back()->with('message','Merchant Status Changed Successfully');
    // }

    public function dashboard(Request $request)
    {
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $pickupRequest = Order::where('orders.user_id', Auth::user()->id)
            ->whereBetween('orders.pickup_date', [$fromdate, $todate])
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->count();
        $orderCollect = Order::where('user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('status', 'Order Collect')
            ->count();
        $pickupCancel = Order::where('user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('status', 'PickUp Cancel')
            ->count();

        $waitingDelivery = Order::where('user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('status', 'Waiting For Delivery')
            ->count();
        $orderDelivered = Order::where('user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('status', 'Order Delivered')
            ->count();
        $deliveryPending = Order::where('user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('status', 'Delivery Pending')
            ->count();

        $paymentProcessing = Order::where('user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('status', 'Payment Processing')
            ->count();
        $paymentComplete = Order::where('user_id', Auth::user()->id)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('status', 'Payment Complete')
            ->count();
        return view(
            'Admin.Home.merchant_dashboard',
            compact(
                'fromdate',
                'todate',
                'pickupRequest',
                'orderCollect',
                'pickupCancel',
                'waitingDelivery',
                'orderDelivered',
                'deliveryPending',
                'paymentProcessing',
                'paymentComplete'
            )
        );
    }


    public function payment_adjustment(Request $request)
    {
        $orderStatus = [];
        if ($request->fromdate && $request->todate) {
            $today = $request->todate;
            $fromdate = $request->fromdate;
        } else {

            $today = date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }
        $selectedMerchant = '';
        $merchants = Merchant::all();

        if ($request->business_name) {
            $selectedMerchant = $request->business_name;
            $payments = MerchantPaymentAdjustment::
                // whereBetween('m_pay_adjustments.created_at', [$fromdate, $today])->
                join('merchants', 'merchants.id', 'm_pay_adjustments.m_id')->join('users', 'merchants.user_id', 'users.id')

                ->where('business_name', $selectedMerchant)
                ->whereDate('m_pay_adjustments.created_at', '>=', $fromdate)
                ->whereDate('m_pay_adjustments.created_at', '<=', $today)
                ->get();
        } else {

            $payments = MerchantPaymentAdjustment::join('merchants', 'merchants.id', 'm_pay_adjustments.m_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->get();
        }

        return view('Backend.Merchant.Payment.payment_adjustment', compact('payments', 'orderStatus', 'fromdate', 'today', 'merchants', 'selectedMerchant'));
    }
    public function payment_adjustment_print(Request $request)
    {
        $company = Company::first();
        $orderStatus = [];
        if ($request->fromdate && $request->todate) {
            $today = $request->today;
            $fromdate = $request->fromdate;
        } else {

            $today = date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }
        $selectedMerchant = '';
        $merchants = Merchant::all();

        if ($request->business_name) {
            // return $fromdate;
            $selectedMerchant = $request->business_name;
            $payments = MerchantPaymentAdjustment::
                // whereBetween('m_pay_adjustments.created_at', [$fromdate, $today])->
                join('merchants', 'merchants.id', 'm_pay_adjustments.m_id')->join('users', 'merchants.user_id', 'users.id')

                ->where('business_name', $selectedMerchant)
                // ->whereDate('m_pay_adjustments.created_at', '>=', $fromdate)
                // ->whereDate('m_pay_adjustments.created_at', '<=', $today)
                ->get();
        } else {

            $payments = MerchantPaymentAdjustment::join('merchants', 'merchants.id', 'm_pay_adjustments.m_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->get();
        }

        return view('Backend.Merchant.Payment.payment_adjustment_print', compact('payments', 'orderStatus', 'fromdate', 'today', 'merchants', 'selectedMerchant', 'company'));
    }


    public function advance_payment(Request $request)
    {
        $orderStatus = [];
        if ($request->fromdate && $request->todate) {
            $today = $request->todate;
            $fromdate = $request->fromdate;
        } else {
            $today = date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }
        $selectedMerchant = '';
        $merchants = Merchant::all();

        if ($request->business_name) {
            $selectedMerchant = $request->business_name;
            $payments = MerchantAdvancePayment::join('merchants', 'merchants.id', 'merchant_advance_payments.merchant_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->where('business_name', $selectedMerchant)
                ->whereDate('merchant_advance_payments.created_at', '>=', $fromdate)
                ->whereDate('merchant_advance_payments.created_at', '<=', $today)
                ->get();
        } else {
            $payments = [];
        }

        return view('Backend.Merchant.Payment.advance_payment', compact('payments', 'orderStatus', 'fromdate', 'today', 'merchants', 'selectedMerchant'));
    }


    public function advance_payment_print(Request $request)
    {
        $company = Company::first();

        $orderStatus = [];
        if ($request->fromdate && $request->today) {
            $today = $request->today;
            $fromdate = $request->fromdate;
        } else {
            $today = date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }
        $selectedMerchant =   $request->merchant;
        $merchants = Merchant::all();
        if ($request->merchant) {
            $selectedMerchant = $request->merchant;
            $payments = MerchantAdvancePayment::join('merchants', 'merchants.id', 'merchant_advance_payments.merchant_id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->where('business_name', $selectedMerchant)
                ->whereDate('merchant_advance_payments.created_at', '>=', $fromdate)
                ->whereDate('merchant_advance_payments.created_at', '<=', $today)
                ->get();
        } else {
            $payments = [];
        }

        //return[$today,$fromdate];
        return view('Backend.Merchant.Payment.advance_payment_print', compact('company', 'payments', 'orderStatus', 'fromdate', 'today', 'merchants', 'selectedMerchant'));
    }

    public function schedule()
    {
        return view('Backend.Merchant.Payment.advance_payment_print', compact('company', 'payments', 'orderStatus', 'fromdate', 'today', 'merchants', 'selectedMerchant'));
    }

    public function password_manage()
    {
        $users = User::where('role', '!=', 1)->get();
        return view('Admin.Expense.Password_Manage.Password_manage', compact('users'));
    }

    public function get_id(Request $request)
    {
        $data = User::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update_password(Request $request)
    {
        //  dd($request->all());
        User::where('id', $request->id)
            ->update(['password' => Hash::make($request->password)]);
        \Toastr::success('Merchant password change .', 'Success !!', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }
}
