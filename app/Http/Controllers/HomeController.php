<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\BusinessType;
use App\Admin\Collection;
use App\Admin\Complain;
use App\Admin\District;
use App\Admin\Merchant;
use App\Admin\MPayment;
use App\Admin\Order;
use App\Admin\Payment;
use App\Admin\PaymentInfo;
use App\Admin\Profile;
use App\Admin\Purchase;
use App\Admin\Sale;
use App\Admin\Shop;
use App\Admin\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;
use App\Admin\Scheduler;
use App\PaymentRequest;
use App\PickUpRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');


        // $this->middleware('inactiveShop');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {




        if (Gate::allows('superAdmin')) {


            return redirect()->route('admin.panel.super.dashboard.new');
            // return view('Admin.Home.dashboard');
        } elseif (Gate::allows('activeMerchant')) {

            //schedule


            $date = Carbon::now();

            $today = $date->format("Y-m-d");
            $c_time = $date->format("H:i");

            $data = Scheduler::where('status', 1)
                ->whereDate('f_date', '<=', $today)
                ->whereDate('t_date', '>=', $today)
                ->whereTime('s_time', '<=', $c_time)
                ->whereTime('e_time', '>=', $c_time)
                ->count();

            if ($data > 0) {

                Auth::logout();

                return redirect()->route('login')->with(['status' => "You can not login now! Please contact system admin"]);
            }



            //end schedule




            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $authid =  Auth::user()->id;

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






            $today_dalivery = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
                ->whereDate('order_status_histories.updated_at', '<=', $todate)
                ->count();

            $total_dalivery = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                // ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
                // ->whereDate('order_status_histories.updated_at', '<=', $todate)
                ->count();


            $today_return = Order::where('orders.user_id', Auth::user()->id)
                // ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
                ->whereDate('orders.updated_at', '>=', $fromdate)
                ->whereDate('orders.updated_at', '<=', $todate)
                ->count();



            $total_return = Order::where('orders.user_id', Auth::user()->id)
                //->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
                // ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
                // ->whereDate('order_status_histories.updated_at', '<=', $todate)
                ->count();

            //  return $total_return;





            $t_dalivery = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
                ->whereDate('order_status_histories.updated_at', '<=', $todate)
                ->count();



            $total_success_delivery =  Order::where('orders.user_id', Auth::user()->id)->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered'])
                ->count();
            $total_unsuccessfully_delivery = Order::where('orders.user_id', Auth::user()->id)->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
                ->count();


            $total_order_count = Order::where('orders.user_id', Auth::user()->id)->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->count();


            $total_delivery_success_ratio = 0;
            $total_delivery_unsuccess_ratio = 0;

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
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Return Confirm', 'Cancel Order'])
                ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
                ->whereDate('order_status_histories.updated_at', '<=', $todate)
                ->count();

            $to_return = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Return Confirm', 'Cancel Order'])
                // ->whereDate('order_status_histories.updated_at','>=',$fromdate)
                // ->whereDate('order_status_histories.updated_at','<=',$todate)
                ->count();



            $t_hold_reschedule = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', [
                    // 'Reschedule Order',
                    //'Hold Order',
                    'Hold Order Received from Branch',
                    'Rescheduled'
                ])
                ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
                ->whereDate('order_status_histories.updated_at', '<=', $todate)
                ->count();
            $to_hold_reschedule = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', [
                    // 'Reschedule Order',
                    // 'Hold Order',
                    'Hold Order Received from Branch',
                    'Rescheduled'
                ])
                // ->whereDate('order_status_histories.updated_at','>=',$fromdate)
                // ->whereDate('order_status_histories.updated_at','<=',$todate)
                ->count();

            $today_paymentProcessing = MPayment::where('m_user_id', Auth::user()->id)
                ->whereDate('m_payments.updated_at', '>=', $fromdate)
                ->whereDate('m_payments.updated_at', '<=', $todate)
                ->whereIn('status', ['Payment Processing', 'Payment Paid By Fulfillment'])->get()->sum('t_payable');

            $total_paymentProcessing = MPayment::where('m_user_id', Auth::user()->id)
                ->whereIn('status', ['Payment Processing', 'Payment Paid By Fulfillment'])->get()->sum('t_payable');



            $today_paymentComplete = MPayment::where('m_user_id', Auth::user()->id)->whereIn('status', ['Payment Received By Merchant'])
                ->whereDate('m_payments.updated_at', '>=', $fromdate)
                ->whereDate('m_payments.updated_at', '<=', $todate)
                ->get()->sum('t_payable');

            $total_paymentComplete = MPayment::where('m_user_id', Auth::user()->id)
                ->whereIn('status', ['Payment Received By Merchant'])
                ->get()->sum('t_payable');



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

            $orderTransit1 = Order::whereIn(
                'status',
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
                    'Return Payment Processing',
                    'Hold Order Received from Branch',
                    'Return Reach For Branch',
                    'Order Bypass By Destination Hub',
                    'Order Placed',
                    'Order Cancel by Branch',
                    'Order Cancel By Fullfilment'
                ]
            )->where('user_id', Auth::user()->id)->get();



            $orderTransit2 = Order::whereIn(
                'status',
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
                    'Return Payment Processing',
                    'Assigned To Delivery Rider',
                    'Return Reach For Branch',
                    'Order Bypass By Destination Hub',
                    'Order Placed',
                    'Order Cancel by Branch',
                    'Order Cancel By Fullfilment'
                ]
            )
                ->where('user_id', Auth::user()->id)
                ->whereDate('updated_at', '>=', $fromdate)
                ->whereDate('updated_at', '<=', $todate)
                ->get();





            // $today_transfer = Transfer::where('media_id', Auth::user()->id)->where('status', 0)
            // ->whereDate('transfers.created_at', '>=', $fromdate)
            // ->whereDate('transfers.created_at', '<=', $todate)
            // ->count();








            $totalorderTransit = $orderTransit1->count();

            $todayorderTransit = $orderTransit2->count();






            // return view(
            //     'Admin.Home.merchant_dashboard',
            //     compact(
            //         'today_order',
            //         'total_order',
            //         'total_delivery_success_ratio',
            //         'total_delivery_unsuccess_ratio',
            //         'today_dalivery',
            //         'total_dalivery',
            //         'today_return',
            //         'total_return',
            //         'today_paymentProcessing',
            //         'total_paymentProcessing',
            //         'today_paymentComplete',
            //         'total_paymentComplete',
            //         'today_dalivery_amount',
            //         'total_dalivery_amount',
            //         'totalorderTransit',
            //         'todayorderTransit'

            //     )
            // );
            return redirect()->route('merchant.panel.merchant_dashboard');
        } elseif (Gate::allows('inactiveMerchant')) {
            // return "dhkfgn";
            $authcheckinmerchant = Auth::user()->id;
            $merchant = Merchant::where('user_id', $authcheckinmerchant)->first();
            $merchants = Merchant::all();

            // $districts = District::all();
            $zones = Zone::where('status', 0)->get();
            return view('Admin.Inactive.merchant', compact('merchant', 'merchants', 'zones'));
        } elseif (Gate::allows('activeAgent')) {
            return redirect()->route('admin.panel.agent.dashboard.new');
        } elseif (Gate::allows('ActiveInCharge')) {
            // return redirect()->route('admin.panel.agent.dashboard');
            return redirect()->route('admin.panel.agent.incharge_dashboard');
        } elseif (Gate::allows('inactiveAgent')) {
            return view('Admin.Inactive.agent');
        } elseif (Gate::allows('activeRider')) {
            // return view('Admin.Home.rider_dashboard');
            // return redirect('rider/dashboard');
            return redirect()->route('rider.dashboard_new');
        } elseif (Gate::allows('inactiveRider')) {
            return view('Admin.Inactive.rider');
        } elseif (Gate::allows('activeAdmin')) {
            return view('Admin.Home.dashboard');
        } elseif (Gate::allows('inactiveAdmin')) {
            return view('Admin.Inactive.admin');
        } elseif (Gate::allows('activeManager')) {
            // return redirect()->route('admin.panel.manager.dashboard');
            return redirect()->route('admin.panel.manager.dashboards');
        } elseif (Gate::allows('inactiveManager')) {
            return view('Admin.Inactive.manager');
        } elseif (Gate::allows('activeAccounts')) {
            // return redirect()->route('accounts.dashboard');
            return redirect()->route('accounts.dashboards');
        } elseif (Gate::allows('inactiveAccounts')) {
            return view('Admin.Inactive.accounts');
        } elseif (Gate::allows('activeEmployee')) {

            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('shops', 'orders.shop', 'shops.shop_name')
                ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_area as shop_area', 'shops.pickup_address as pickup_address', 'shops.shop_address as shop_address', 'users.name as merchant')
                ->where('orders.user_id', Auth::user()->id)
                ->get();

            return view('Admin.Home.dashboard', compact('data'));
        } elseif (Gate::allows('inactiveEmployee')) {
            return view('Admin.Inactive.employee');
        } elseif (Gate::allows('activeCallCenter')) {
            // return redirect()->route('order.list.index');
            $data = Complain::orderBy('id', 'DESC')
                ->leftJoin('users', 'complains.mobile', 'users.id')
                ->select('complains.*', 'users.mobile as phone')
                ->get();
            return view('Admin.Home.dashboard', compact('data'));
            //return view('Admin.Inactive.callCenter');
        } elseif (Gate::allows('inactiveCallCenter')) {
            return view('Admin.Inactive.callCenter');
        } else {
            return view('Admin.Home.dashboard');
        }
    }

    public function profile()
    {
        // return "soihfgghbj";
        if (Gate::allows('superAdmin')) {
            return view('Admin.Home.dashboard');
        } elseif (Gate::allows('activeMerchant')) {
            // return "dfglkjhdfjk";
            $payment = PaymentInfo::where('user_id', Auth::user()->id)->get();
            $merchant = Merchant::with('user')->where('user_id', Auth::user()->id)->first();
            $profile = Profile::where('user_id', Auth::user()->id)->first();
            $business = BusinessType::orderBy('id', 'DESC')->where('status', 1)->get();
            $shops = Shop::where('user_id', Auth::user()->id)->get();
            $districts = DB::table('districts')->orderBy('name', 'asc')->get();
            return view('Admin.Merchant.profile', compact('merchant', 'districts', 'business', 'payment', 'shops', 'profile'));
        } elseif (Gate::allows('activeAgent')) {
            $agent = Agent::where('user_id', Auth::user()->id)->get();
            $districts = DB::table('districts')->orderBy('name', 'asc')->get();
            return view('Admin.Merchant.agentProfile', compact('agent', 'districts'));
        } else {
            return redirect('/home');
            // return view('Admin.Home.dashboard');
        }
    }

    public function profile_update(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->business_name = $request->business_name;
        $data->area = $request->area;
        $data->b_type = $request->business_type;
        $data->save();
        return redirect()->back()->with('status', ' Merchant Profile Updated Successfully !!');
    }

    public function merchant_profile_update(Request $request)
    {

        if ($request->nid_no) {
            $data = Profile::where('user_id', Auth::user()->id)->first();
            $data->nid_no = $request->nid_number;
            $data->save();
        }

        if ($request->hasFile('nid_font_side')) {
            $image = $request->file('nid_font_side');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Merchant/Profile/NidF/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
            Profile::where('user_id', Auth::user()->id)->update(['nid_front' => $imageUrl]);
        }

        if ($request->hasFile('nid_back_side')) {
            $image = $request->file('nid_back_side');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Merchant/Profile/NidB/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
            Profile::where('user_id', Auth::user()->id)->update(['nid_back' => $imageUrl]);
        }

        return redirect()->back()->with('status', 'Merchant Profile Updated Successfully');
    }
    public function image_update(Request $request)
    {
        if ($request->hasFile('nid_front')) {
            $image = $request->file('nid_front');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Merchant/Profile/NidF/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
            Profile::where('user_id', Auth::user()->id)->update(['nid_front' => $imageUrl]);
        } elseif ($request->hasFile('nid_back')) {
            $image = $request->file('nid_back');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Merchant/Profile/NidB/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
            Profile::where('user_id', Auth::user()->id)->update(['nid_back' => $imageUrl]);
        } elseif ($request->hasFile('bank_check')) {
            $image = $request->file('bank_check');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Merchant/Profile/BankC/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
            Profile::where('user_id', Auth::user()->id)->update(['bank_check' => $imageUrl]);
        }
        return redirect()->back()->with('status', 'Merchant Profile Updated Successfully');
    }

    public function pickup_request(Request $request)
    {
        $data = new PickUpRequest();
        $data->merchant_id = Auth::user()->id;
        $data->pickup_address = $request->pick_up_address;
        $data->note = $request->Note;
        $data->estimate_parcel = $request->estimated_parcel;
        $data->save();
        // \Toastr::success('Pickup Requested Add Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        // return redirect()->back();

        $notification = array(
            'message' => 'Pickup Requested Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function payment_request(Request $request)
    {
        $data = new PaymentRequest();
        $data->merchant_id = Auth::user()->id;
        $data->payment_method = $request->payment_method;
        $data->save();
        // \Toastr::success('Payment Requested Add Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        // return redirect()->back();
        $notification = array(
            'message' => 'Payment Requested Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function pickup_address(Request $request)
    {
        $data = User::where('id', Auth::user()->id)->get();
        return $data;
    }

    public function pickup_request_list(Request $request)
    {
        if (auth()->user()->role == 8) {
            $agent = Agent::where('user_id', auth()->user()->id)->value('zone_id');
            $pick_up_list = PickUpRequest::join('merchants', 'pick_up_requests.merchant_id', '=', 'merchants.user_id')
                ->where('merchants.zone_id', $agent)
                ->select('merchants.business_name', 'pick_up_requests.*')
                ->orderBy('id', 'DESC')
                ->get();
            return  view('Admin.pickup_request.pickup_request_list', compact('pick_up_list'));
        } else {
            $pick_up_list = PickUpRequest::join('merchants', 'pick_up_requests.merchant_id', '=', 'merchants.user_id')
                ->select('merchants.business_name', 'pick_up_requests.*')
                ->orderBy('id', 'DESC')
                ->get();
            return  view('Admin.pickup_request.pickup_request_list', compact('pick_up_list'));
        }
    }

    public function payment_request_list(Request $request)
    {
        $payment_list = PaymentRequest::join('merchants', 'payment_requests.merchant_id', '=', 'merchants.user_id')
            ->select('merchants.business_name', 'payment_requests.*')->get();

        return view('Admin.pickup_request.payment_request_list', compact('payment_list'));
    }

    public function pickup_destroy(Request $request)
    {
        $data = PickUpRequest::find($request->id);
        $data->delete();
        \Toastr::success('Pickup Requested remove Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }



    public function payment_destroy(Request $request)
    {

        $data = PaymentRequest::where('id', $request->id)->first();

        $data->update([
            'status' => 'Approve'
        ]);

        \Toastr::success('Payment Requested Accepted Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }

    public function payment_rejects(Request $request)
    {

        $data = PaymentRequest::where('id', $request->id)->first();

        $data->update([
            'status' => 'Reject'
        ]);

        \Toastr::success('Payment Requested Rejected Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }

    public function payment_reject(Request $request)
    {
        $data = PaymentRequest::where('id', $request->id)->get();
        return $data;
    }
}
