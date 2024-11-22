<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\BranchDistrict;
use App\Admin\BusinessType;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\District;
use App\Admin\MerchantPayment;
use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use App\Admin\PickUpRequestAssign;
use App\Admin\Rider;
use App\Admin\Slider;
use App\Admin\Zone;
use App\Admin\DeliveryAssign;
use App\PaymentRequest;
use App\PickUpRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helper\Helpers\Helpers;

class AdminPanelController extends Controller
{
    public function login()
    {
        return view('Admin.AdminPanel.login');
    }

    public function change_password()
    {
        return view('Admin.AdminPanel.change_password');
    }

    public function login_new()
    {
        return view('auth.old_login');
    }

    public function new_register()
    {
        return view('Admin.AdminPanel.new_merchant_register');
    }




    public function changepass_word(Request $request)
    {
        // $authpassword = Auth::user()->password;
        // $old_password = Hash::make($request->old_password);
        // $request->request->add(['old_password'      => $old_password]);
        // $request->request->add(['database_password' => $authpassword]);
        // $request->validate([
        // 'old_password'  => 'required|string|min:6|same:database_password',
        // 'old_password'  => 'required|string|min:6',
        // ]);

        $old_password = Hash::make($request->old_password);
        // $authpassword = User::where('id', Auth::user()->id)->first();
        if (Auth::user()->password === $old_password) {
            return view('Admin.AdminPanel.change_password');
        } else {
            // $request->validate()->errors()->add('old_password', 'Old Password doesnot match !');
            return view('Admin.AdminPanel.change_password');
            // return redirect()->back()->with('message','Old Password doesnot match !');
        }
    }

    public function parcel_tracking()
    {
        // return view('auth.perchel_tracking');
        return view('auth.new_perchel_tracking');
    }
    public function live_tracking_parcel(Request $request)
    {
        $tracking_id = $request->tracking_number;
        $data = Order::with('user')->where('orders.tracking_id', $request->tracking_number)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as merchant')
            ->first();


        $history = DB::table('order_status_histories')->join('users', 'users.id', '=', 'order_status_histories.user_id')->where('order_status_histories.tracking_id', $request->tracking_number)
            ->select('order_status_histories.status as status', 'order_status_histories.created_at as date', 'users.name as name', 'users.mobile as mobile')->get();

        $order_statuses = OrderStatusHistory::where('tracking_id', $request->tracking_number)->latest('id')->get();



        $new_array = array();
        foreach ($order_statuses as $key => $value) {

            if (!isset($new_array[$value['status']])) {
                $new_array[$value['status']] = $value;
            }
        }

        $order_statuses  = $new_array = array_values($new_array);



        $company = Company::first();

        return view('Admin.Order.public_order_view_details', compact('tracking_id', 'data', 'history', 'order_statuses', 'company'));
    }

    public function changePassword(Request $request)
    {
        return view('Admin.AdminPanel.change_password');
    }
    public function change_pass_word(Request $request)
    {
        // $authpassword = Auth::user()->password;
        // $old_password = Hash::make($request->old_password);

        // $request->request->add(['database_password' => $authpassword]);
        // $request->request->add(['old_password'      => $old_password]);

        // if (Hash::check($request->old_password, $authpassword)) {
        //     // The passwords match...
        // }

        $request->validate([
            // 'old_password'  => 'required|string|min:6|same:database_password',
            // 'old_password'  => 'required|string|min:6',
            'password'      => 'required|string|confirmed|min:6',
        ]);

        // $authpassword = Auth::user()->password;
        // $old_password = $request->entered_old_password;
        // $password = $request->password;

        // if ($authpassword == $old_password)
        // {
        User::where('id', Auth::user()->id)
            ->update(['password' => Hash::make($request->password)]);
        return redirect()->action('AdminPanelController@logout');
        // }
        // else {
        // $validator->errors()->add('old_password', 'Old Password doesnot match !');
        // return redirect()->back();
        // }
        // return redirect()->back();
        // return redirect()->route('admin.panel.logout');
        // return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }
    protected function loggedOut(Request $request)
    {
        //
    }
    protected function guard()
    {
        return Auth::guard();
    }

    public function agent_register()
    {
        $districts = DB::table('districts')->orderBy('name', 'asc')->get();
        $zones = Zone::orderBy('id', 'DESC')->where('status', 1)->get();
        return view('Admin.AdminPanel.agent_register', compact('districts', 'zones'));
    }

    public function rider_register()
    {
        $districts = DB::table('districts')->orderBy('name', 'asc')->get();
        $zones = Zone::orderBy('id', 'DESC')->where('status', 0)->get();
        return view('Admin.AdminPanel.rider_register', compact('districts', 'zones'));
    }

    public function agent_regis_ter(Request $request)
    {

        $request->validate([
            'email'     => 'required|email|string|max:255|unique:users',
            'password'  => 'required|string|confirmed|min:6',
            'mobile'        => ['required', 'digits:11'],
        ]);

        // $zone= Zone::where('id',$request->area)->first();
        // $district =  District::where('id',$request->district)->first();

        $zone = new Zone();
        $zone->name = $request->name;
        $zone->status = 0;
        $zone->ceate_by = Auth::user()->id;
        $zone->district_id = 0;
        $zone->save();

        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->address = $request->address ?? '';
        $user->role = 9;
        $user->password = Hash::make($request->password);
        $user->save();

        $data = new Agent();
        $data->user_id = $user->id;
        // $data->district_id = $request->district;
        $data->district_id = 0;
        $data->zone_id = $zone->id;
        $data->area = $zone->name;
        // $data->district = $district->name;
        $data->district = '';
        $data->save();
        // return redirect('agent.index')->with('message', 'Agent Registration Successfully Completed');
        return redirect()->route('agent.index')->with('message', 'Branch Registration Successfully Completed');
    }

    public function rider_regis_ter(Request $request)
    {
        $request->validate([
            'email'     => 'required|email|string|max:255|unique:users',
            'password'  => 'required|string|confirmed|min:6',
        ]);

        $zone = Zone::where('id', $request->area)->first();
        $district =  District::where('id', $request->district)->first();
        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->role = 11;
        $user->password = Hash::make($request->password);
        $user->save();

        $data = new Rider();
        $data->user_id = $user->id;
        $data->district_id = $request->district;
        $data->zone_id = $zone->id;
        $data->area = $zone->name;
        $data->district = $district->name;
        $data->save();
        //  return redirect()->back()->with('message', 'Rider Registration Successfully Completed');
        return redirect()->route('rider.index')->with('message', 'Rider Registration Successfully Completed');
    }

    public function registration()
    {
        if (auth()->user()->role == 1) {
            $user = User::orderBy('id', 'DESC')
                // ->where('role','!=', 1)
                ->where('role', 2)
                ->orwhere('role', 3)
                ->orwhere('role', 4)
                ->orwhere('role', 5)
                ->orwhere('role', 6)
                ->orwhere('role', 7)
                ->orwhere('role', 16)
                ->orwhere('role', 17)
                // ->orwhere('role', 18)
                ->get();
            return view('Admin.AdminPanel.registration', compact('user'));
        } elseif (auth()->user()->role == 8) {
            $user = User::orderBy('id', 'DESC')
                // ->where('role','!=', 1)
                ->orwhere('role', 18)
                ->get();
            return view('Admin.AdminPanel.registration', compact('user'));
        }
    }

    public function edit_exclusive(Request $request)
    {
        // return $request->id;

        $data = User::orderBy('id', 'DESC')
            ->where('id', $request->id)
            ->first();




        return view('Admin.Home.exclusive_edit', compact('data'));
    }

    public function updateEx(Request $request)
    {
        // return  $request->id;

        User::where('id', $request->id)
            ->update([
                'name'        => $request->name,
                'email'       => $request->email,
                'mobile'      => $request->mobile,
                'role'        => $request->role
            ]);
        return redirect()->route('admin.panel.register')->with('message', 'Exclusive Updated Successfully');
    }


    public function regis_tration(Request $request)
    {
        if (Auth::user()->role == 1) {
            $request->validate([
                'email'     => 'required|email|string|max:255|unique:users',
                'password'  => 'required|string|confirmed|min:6',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->with('message', 'Registration Successfully Completed');
        } elseif (Auth::user()->role == 8) {

            $request->validate([
                'email'     => 'required|email|string|max:255|unique:users',
                'password'  => 'required|string|confirmed|min:6',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();
            DB::table('hub_employees')
                ->insert([
                    'hub_id'          => Auth::user()->id,
                    'hub_incharge_id' => $user->id,
                ]);
            return redirect()->back()->with('message', 'Registration Successfully Completed');
        }
    }

    public function admin()
    {
        $admin = User::orderBy('id', 'DESC')->where('role', 2)->get();
        return view('Admin.User.admin', compact('admin'));
    }

    public function manager()
    {
        $manager = User::orderBy('id', 'DESC')->where('role', 4)->get();
        return view('Admin.User.manager', compact('manager'));
    }

    public function accounts()
    {
        $accounts = User::orderBy('id', 'DESC')->where('role', 6)->get();
        return view('Admin.User.accounts', compact('accounts'));
    }

    public function callCenter()
    {
        $callCenter = User::orderBy('id', 'DESC')->where('role', 14)->get();
        return view('Admin.User.callCenter', compact('callCenter'));
    }

    public function manager_dashboard1(Request $request)
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
        return view(
            'Admin.Home.manager_dashboard',
            compact('fromdate', 'todate', 'pRt', 'pCt', 'pCl', 'dWt', 'dCt', 'dPg', 'pPr', 'pCt', 'uPu', 'rPu')
        );
    }
    public function manager_dashboard2(Request $request)
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
        return view(
            'Admin.Home.manager_dashboard',
            compact('fromdate', 'todate', 'pRt', 'pCt', 'pCl', 'dWt', 'dCt', 'dPg', 'pPr', 'pCt', 'uPu', 'rPu')
        );
    }

    public function manager_dashboard(Request $request)
    {
        // return "asif";
        if ($request->todate) {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $tPickupReq = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                // ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')
                ->count();

            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $pRt = Order::where('status', 'PickUp Request')->count(); //whereBetween('orders.updated_at', [$fromdate, $todate])


            $pCt = Order::where('status', 'Order Collect')
                ->count();
            $pCl = Order::where('status', 'PickUp Cancel')
                ->count();
            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();
        } else {

            // return "cglfjglk";
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $today_pickup_rquest = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->get()->unique('tracking_id')->count();


            $tPickupCancel = PickUpRequestAssign::join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->where('order_status_histories.status', 'PickUp Cancel')
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();


            // today 

            $tOrderPlaced = Order::where('status', 'Order Placed')
                ->whereDate('created_at', $today)
                ->count();

            $tPickupDone = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->count();

            $tPickupAmount = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->sum('collection');

            $oneHourPickup = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->where('type', 'Urgent')
                ->count();

            $regularPickup = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->where('type', 'Regular')
                ->count();
            // Successfully Delivered and Partially Delivered and Regular
            $regularDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->whereDate('created_at', $today)
                ->where('type', 'Regular')
                ->count();

            $urgentDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->whereDate('created_at', $today)
                ->where('type', 'Urgent')
                ->count();

            $tOrdercancel = Order::where('status', 'Order Cancel')
                ->whereDate('created_at', $today)
                ->count();

            $orderCancelAmount = Order::where('status', 'Order Cancel')
                ->whereDate('created_at', $today)
                ->sum('collection');


            $tPaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
                ->whereDate('created_at', $today)
                ->sum('t_payable');



            // total 
            $t_OrderPlaced = Order::where('status', 'Order Placed')
                ->count();

            $t_PickupDone = Order::where('status', 'Pickup Done')
                ->count();

            $t_oneHourPickup = Order::where('status', 'Pickup Done')
                ->where('type', 'Urgent')
                ->count();

            $t_regularPickup = Order::where('status', 'Pickup Done')
                ->where('type', 'Regular')
                ->count();
            // Successfully Delivered and Partially Delivered and Regular
            $t_regularDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->where('type', 'Regular')
                ->count();

            $t_urgentDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->where('type', 'Urgent')
                ->count();

            $t_tOrdercancel = Order::where('status', 'Order Cancel')
                ->count();

            $t_Pickupcancel = Order::where('status', 'PickUp Cancel')
                ->count();

            $t_PickupAmount = Order::where('status', 'Pickup Done')
                ->sum('collection');
            $t_orderCancelAmount = Order::where('status', 'Order Cancel')
                ->sum('collection');
            $t_PaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
                ->sum('t_payable');




            $pRt = Order::where('status', 'PickUp Request')
                ->count();
            $pCt = Order::where('status', 'Order Collect')
                ->count();
            $pCl = Order::where('status', 'PickUp Cancel')
                ->whereDate('created_at', $today)
                ->count();
            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();






            // where('orders.updated_at', $today)

        }
        return view(
            'Admin.Home.manager_dashboard',
            compact(
                'fromdate',
                'todate',
                'pRt',
                'pCt',
                'pCl',
                'dWt',
                'dCt',
                'dPg',
                'pPr',
                'pCt',
                'uPu',
                'rPu',
                'today_pickup_rquest',
                'tPickupCancel',
                'tOrderPlaced',
                'tPickupDone',
                'oneHourPickup',
                'regularPickup',
                'regularDelivery',
                'urgentDelivery',
                'tOrdercancel',
                'tPickupAmount',
                'orderCancelAmount',
                'tPaidAmount',
                't_OrderPlaced',
                't_PickupDone',
                't_oneHourPickup',
                't_regularPickup',
                't_regularDelivery',
                't_urgentDelivery',
                't_tOrdercancel',
                't_Pickupcancel'

            )
        );
    }

    public function manager_dashboards(Request $request)
    {
        if ($request->todate) {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $tPickupReq = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                // ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')
                ->count();

            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $pRt = Order::where('status', 'PickUp Request')->count(); //whereBetween('orders.updated_at', [$fromdate, $todate])


            $pCt = Order::where('status', 'Order Collect')
                ->count();
            $pCl = Order::where('status', 'PickUp Cancel')
                ->count();
            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();
        } else {

            // return "cglfjglk";
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $today_pickup_rquest = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->get()->unique('tracking_id')->count();


            $tPickupCancel = PickUpRequestAssign::join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->where('order_status_histories.status', 'PickUp Cancel')
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();


            // today 

            $tOrderPlaced = Order::where('status', 'Order Placed')
                ->whereDate('created_at', $today)
                ->count();

            $tPickupDone = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->count();

            $tPickupAmount = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->sum('collection');

            $oneHourPickup = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->where('type', 'Urgent')
                ->count();

            $regularPickup = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->where('type', 'Regular')
                ->count();
            // Successfully Delivered and Partially Delivered and Regular
            $regularDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->whereDate('created_at', $today)
                ->where('type', 'Regular')
                ->count();

            $urgentDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->whereDate('created_at', $today)
                ->where('type', 'Urgent')
                ->count();

            $tOrdercancel = Order::where('status', 'Order Cancel')
                ->whereDate('created_at', $today)
                ->count();

            $orderCancelAmount = Order::where('status', 'Order Cancel')
                ->whereDate('created_at', $today)
                ->sum('collection');


            $tPaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
                ->whereDate('created_at', $today)
                ->sum('t_payable');



            // total 
            $t_OrderPlaced = Order::where('status', 'Order Placed')
                ->count();

            $t_PickupDone = Order::where('status', 'Pickup Done')
                ->count();

            $t_oneHourPickup = Order::where('status', 'Pickup Done')
                ->where('type', 'Urgent')
                ->count();

            $t_regularPickup = Order::where('status', 'Pickup Done')
                ->where('type', 'Regular')
                ->count();
            // Successfully Delivered and Partially Delivered and Regular
            $t_regularDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->where('type', 'Regular')
                ->count();

            $t_urgentDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
                ->where('type', 'Urgent')
                ->count();

            $t_tOrdercancel = Order::where('status', 'Order Cancel')
                ->count();

            $t_Pickupcancel = Order::where('status', 'PickUp Cancel')
                ->count();

            $t_PickupAmount = Order::where('status', 'Pickup Done')
                ->sum('collection');
            $t_orderCancelAmount = Order::where('status', 'Order Cancel')
                ->sum('collection');
            $t_PaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
                ->sum('t_payable');




            $pRt = Order::where('status', 'PickUp Request')
                ->count();
            $pCt = Order::where('status', 'Order Collect')
                ->count();
            $pCl = Order::where('status', 'PickUp Cancel')
                ->whereDate('created_at', $today)
                ->count();
            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();






            // where('orders.updated_at', $today)

        }
        return  view('Admin.Home.manager_dashboards', compact(
            'fromdate',
            'todate',
            'pRt',
            'pCt',
            'pCl',
            'dWt',
            'dCt',
            'dPg',
            'pPr',
            'pCt',
            'uPu',
            'rPu',
            'today_pickup_rquest',
            'tPickupCancel',
            'tOrderPlaced',
            'tPickupDone',
            'oneHourPickup',
            'regularPickup',
            'regularDelivery',
            'urgentDelivery',
            'tOrdercancel',
            'tPickupAmount',
            'orderCancelAmount',
            'tPaidAmount',
            't_OrderPlaced',
            't_PickupDone',
            't_oneHourPickup',
            't_regularPickup',
            't_regularDelivery',
            't_urgentDelivery',
            't_tOrdercancel',
            't_Pickupcancel'

        ));
    }





























    public function accounts_dashboard(Request $request)
    {
        if ($request->todate) {
            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $delivered = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Order Delivered')
                ->count();
            $processing = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Processing')
                ->count();
            $collect = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Collect')
                ->count();
            $complete = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Complete')
                ->where('type', 1)
                ->count();
        } else {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');
            $delivered = Order::where('orders.updated_at', $today)
                ->where('status', 'Order Delivered')
                ->count();
            $processing = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Processing')
                ->count();
            $collect = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Collect')
                ->count();
            $complete = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Complete')
                ->count();
        }
        return view(
            'Admin.Home.accounts_dashboard',
            compact('fromdate', 'todate', 'delivered', 'processing', 'collect', 'complete')
        );
    }

    public function accounts_dashboards(Request $request)
    {
        if ($request->todate) {
            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $delivered = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Order Delivered')
                ->count();
            $processing = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Processing')
                ->count();
            $collect = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Collect')
                ->count();
            $complete = Order::whereBetween('orders.updated_at', [$fromdate, $todate])
                ->where('status', 'Payment Complete')
                ->where('type', 1)
                ->count();
        } else {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');
            $delivered = Order::where('orders.updated_at', $today)
                ->where('status', 'Order Delivered')
                ->count();
            $processing = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Processing')
                ->count();
            $collect = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Collect')
                ->count();
            $complete = Order::where('orders.updated_at', $today)
                ->where('status', 'Payment Complete')
                ->count();

            $tprocessing = Order::where('status', 'Payment Processing')
                ->count();
            $tcollect = Order::where('status', 'Payment Collect')
                ->count();
            $tcomplete = Order::where('status', 'Payment Complete')
                ->count();
        }
        return view(
            'Admin.Home.account_dashboard_new',
            compact('tprocessing', 'tcollect', 'tcomplete', 'fromdate', 'todate', 'delivered', 'processing', 'collect', 'complete')
        );
    }

    public function super_dashboard(Request $request)
    {
        // return "asif";
        if ($request->todate) {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            return  $tPickupReq = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                // ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->whereIn('orders.area', $areas)->get()->unique('tracking_id')
                ->count();

            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $pRt = Order::where('status', 'PickUp Request')->count(); //whereBetween('orders.updated_at', [$fromdate, $todate])


            $pCt = Order::where('status', 'Order Collect')
                ->count();
            $pCl = Order::where('status', 'PickUp Cancel')
                ->count();
            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();
        } else {

            // return "cglfjglk";
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $today_pickup_rquest = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->get()->unique('tracking_id')->count();


            $tPickupCancel = PickUpRequestAssign::join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->where('order_status_histories.status', 'PickUp Cancel')
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();




            $tOrderPlaced = OrderStatusHistory::where('status', 'Order Placed')
                ->whereDate('created_at', $today)
                ->count();

            $tPickupDone = OrderStatusHistory::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->count();


            //     ->sum('collection');

            $tPickupAmount = Order::where('status', 'Pickup Done')
                ->whereDate('created_at', $today)
                ->sum('collection');

            // $oneHourPickup = Order::where('status', 'Pickup Done')
            //     ->whereDate('created_at', $today)
            //     ->where('type', 'Urgent')
            //     ->count();


            $oneHourPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', $today)
                ->where('type', 'Urgent')
                ->count();


            $regularPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', $today)
                ->where('type', 'Regular')
                ->count();



            // Successfully Delivered and Partially Delivered and Regular
            // $regularDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
            //     ->whereDate('created_at', $today)
            //     ->where('type', 'Regular')
            //     ->count();

            // $urgentDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
            //     ->whereDate('created_at', $today)
            //     ->where('type', 'Urgent')
            //     ->count();


            $regularDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', $today)
                ->where('orders.type', 'Regular')
                ->count();

            $urgentDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', $today)
                ->where('orders.type', 'Urgent')
                ->count();

            // $tOrdercancel = Order::where('status', 'Order Cancel')
            //     ->whereDate('created_at', $today)
            //     ->count();


            $tOrdercancel = OrderStatusHistory::whereIn('order_status_histories.status', ['Return Confirm', 'Return Reach For Fullfilment', 'Return Payment Processing'])
                ->whereDate('created_at', $today)
                ->count();

            // $tPickupcancel = OrderStatusHistory::where('status', 'PickUp Cancel')
            //     ->count();

            $orderCancelAmount = Order::where('status', 'Order Cancel')
                ->whereDate('created_at', $today)
                ->sum('collection');


            $tPaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
                ->whereDate('created_at', $today)
                ->sum('t_payable');

            $tPaidAmount = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->where('orders.status', 'Payment Completed')
                ->whereDate('order_confirms.created_at', $today)
                ->sum('collect');

            $pRt = Order::where('status', 'PickUp Request')
                ->count();
            $pCt = Order::where('status', 'Order Collect')
                ->count();
            $pCl = Order::whereIn('status', ['PickUp Cancel', 'Order Cancel by Branch'])
                ->whereDate('created_at', $today)
                ->count();
            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();

            $total_success_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered'])
                ->whereDate('order_status_histories.updated_at', '=', $today)
                ->count();
            $total_unsuccessfully_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
                ->whereDate('order_status_histories.updated_at', '=', $today)
                ->count();






            $total_order_count = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.updated_at', '=', $today)
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

            $merchant_payments = MerchantPayment::where('m_payments.status', "Payment Processing")
                ->whereDate('m_payments.updated_at', '=', $today)
                ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')

                ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();

            $total_merchant_payment_processing =   $merchant_payments->sum('t_payable');


            $paid_amount = MerchantPayment::whereIn('m_payments.status', ['Payment Received By Merchant', 'Payment Paid By Fulfillment'])
                ->whereDate('m_payments.updated_at', '=', $today)
                ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')

                ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();


            $total_paid_amount =   $paid_amount->sum('t_payable');


            $today_pickup_request = PickUpRequest::whereDate('created_at', Carbon::today())->count();


            $today_payment_request = PaymentRequest::whereDate('created_at', Carbon::today())->count();
        }
        return view(
            'Admin.Home.super_admin_dashboard',
            compact(
                'fromdate',
                'todate',
                'pRt',
                'pCt',
                'pCl',
                'dWt',
                'dCt',
                'dPg',
                'pPr',
                'pCt',
                'uPu',
                'rPu',
                'total_delivery_success_ratio',
                'total_merchant_payment_processing',
                'total_delivery_unsuccess_ratio',
                'total_paid_amount',
                'today_pickup_rquest',
                'tPickupCancel',
                'tOrderPlaced',
                'tPickupDone',
                'oneHourPickup',
                'regularPickup',
                'regularDelivery',
                'urgentDelivery',
                'tOrdercancel',
                'tPickupAmount',
                'orderCancelAmount',
                'tPaidAmount',
                'today_pickup_request',
                'today_payment_request'

            )
        );
    }
    public function super_dashboard_total(Request $request)
    {
        // return  "asif";
        if ($request->todate) {
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $tPickupReq = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->get()->unique('tracking_id')->count();

            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $pRt = Order::where('status', 'PickUp Request')->count(); //whereBetween('orders.updated_at', [$fromdate, $todate])


            $pCt = Order::where('status', 'Order Collect')
                ->count();
            $pCl = Order::where('status', 'PickUp Cancel')
                ->count();
            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();
        } else {

            // return "cglfjglk";
            $today = date('Y-m-d');
            $todate = date('Y-m-d');
            $fromdate = date('Y-m-d');

            $today_pickup_rquest = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->get()->unique('tracking_id')->count();


            $tPickupCancel = PickUpRequestAssign::join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
                ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                ->whereDate('order_status_histories.created_at', '<=', $todate)
                ->where('order_status_histories.status', 'PickUp Cancel')
                ->select('order_status_histories.*', 'pick_up_request_assigns.*')
                ->count();




            // $tOrderPlaced = Order::where('status', 'Order Placed')
            //     ->count();

            $tOrderPlaced = OrderStatusHistory::where('status', 'Order Placed')->count();

            $tPickupDone = OrderStatusHistory::where('status', 'Pickup Done')
                ->count();

            // $oneHourPickup = Order::where('status', 'Pickup Done')
            //     ->where('type', 'Urgent')
            //     ->count();

            $oneHourPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->where('type', 'Urgent')
                ->count();

            $regularPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
                ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->where('type', 'Regular')
                ->count();

            // Successfully Delivered and Partially Delivered and Regular
            // $regularDelivery = Order::whereIn('status', ['Successfully Delivered', 'Partially Delivered'])
            //     ->where('type', 'Regular')
            //     ->count();
            $regularDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->where('orders.type', 'Regular')
                ->count();

            $urgentDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->where('orders.type', 'Urgent')
                ->count();

            $tOrdercancel =  OrderStatusHistory::whereIn('order_status_histories.status', ['Return Confirm', 'Return Reach For Fullfilment', 'Return Payment Processing'])
                ->count();


            $tPickupcancel = OrderStatusHistory::whereIn('status', ['PickUp Cancel', 'Order Cancel by Branch'])
                ->count();


            $orderCancelAmount = Order::where('status', 'Order Cancel')
                ->sum('collection');
            // $tPaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
            //     ->sum('t_payable');

            $tPaidAmount = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')->where('orders.status', 'Payment Completed')->sum('collect');
            // colection


            $tCancelAmount = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')->where('orders.status', 'Order Cancel')->sum('collection');


            $tPickupAmount = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')->where('orders.status', 'Pickup Done')
                ->sum('colection');


            $td = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')->where('orders.status', 'Payment Completed')
                ->sum('delivery');
            $ti = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')->where('orders.status', 'Payment Completed')
                ->sum('insurance');
            $tc = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')->where('orders.status', 'Payment Completed')
                ->sum('cod');

            $tDeliveryCharge = $td + $ti + $tc;
            // ->get();

            //    return  $tDeliveryChargeTest = Order::join('order_confirms','orders.tracking_id','order_confirms.tracking_id')->where('orders.status','Pickup Done')
            //     ->get();
            //asiftest
            //  ->sum('delivery');

            // return    $tPaidAmount = Order::join('order_confirms','orders.tracking_id','order_confirms.tracking_id')->where('orders.status','Payment Completed');



            $pRt = Order::where('status', 'PickUp Request')
                ->count();
            $pCt = Order::where('status', 'Order Collect')
                ->count();

            $dWt = Order::where('status', 'Waiting For Delivery')
                ->count();
            $dCt = Order::where('status', 'Order Delivered')
                ->count();
            $dPg = Order::where('status', 'Delivery Pending')
                ->count();
            $pPr = Order::where('status', 'Payment Processing')
                ->count();
            $pCt = Order::where('status', 'Payment Complete')
                ->count();

            $uPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Urgent')
                ->count();

            $rPu = Order::where('status', 'PickUp Request')
                ->where('type', 'Regular')
                ->count();

            $total_success_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered'])
                ->count();
            $total_unsuccessfully_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->whereIn('order_status_histories.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
                ->count();



            $total_order_count = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->count();


            $total_delivery_success_ratio = 0;
            $total_delivery_unsuccess_ratio = 0;

            /*Total UnSuccessfully delivery ratio*/
            //$total_unsuccessfully_delivery = $total_order_count - $total_success_delivery;
            if ($total_unsuccessfully_delivery > 0) {

                $unsuccessPercentage = ($total_unsuccessfully_delivery / $total_order_count) * 100;

                $total_delivery_unsuccess_ratio = number_format($unsuccessPercentage);
            }


            /*Total Successfully delivery ratio*/
            if ($total_success_delivery > 0) {
                $successPercentage = ($total_success_delivery / $total_order_count) * 100;

                $total_delivery_success_ratio = number_format($successPercentage);
            }

            $merchant_payments = MerchantPayment::where('m_payments.status', "Payment Processing")
                ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')
                ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();

            $total_merchant_payment_processing =   $merchant_payments->sum('t_payable');


            $paid_amount = MerchantPayment::whereIn('m_payments.status', ['Payment Received By Merchant', 'Payment Paid By Fulfillment'])
                ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')
                ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();


            $total_paid_amount =   $paid_amount->sum('t_payable');



            $total_pickup_request = PickUpRequest::count();
            $total_payment_request = PaymentRequest::count();
            // where('orders.updated_at', $today)

        }
        return view(
            'Admin.Home.super_admin_dashboard_total',
            compact(
                'fromdate',
                'total_pickup_request',
                'total_payment_request',
                'total_delivery_success_ratio',
                'total_delivery_unsuccess_ratio',
                'total_merchant_payment_processing',
                'total_paid_amount',
                'todate',
                'pRt',
                'pCt',
                'dWt',
                'dCt',
                'dPg',
                'pPr',
                'pCt',
                'uPu',
                'rPu',
                'today_pickup_rquest',
                'tPickupCancel',
                'tOrderPlaced',
                'tPickupDone',
                'oneHourPickup',
                'regularPickup',
                'regularDelivery',
                'urgentDelivery',
                'tOrdercancel',
                'tPickupcancel',
                'tPickupAmount',
                'orderCancelAmount',
                'tPaidAmount',
                'tCancelAmount',
                'tDeliveryCharge',
                'td'

            )
        );
    }

    public function super_dashboard_new(Request $request)
    {

        $today = date('Y-m-d');
        $todate = date('Y-m-d');
        $fromdate = date('Y-m-d');

        $today_pickup_rquest = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->get()->unique('tracking_id')->count();

        $total_pickup_rquest = OrderStatusHistory::where('order_status_histories.status', 'Order Placed')
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')->get()->unique('tracking_id')->count();


        $todayPickupCancel = PickUpRequestAssign::join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', '>=', $fromdate)
            ->whereDate('order_status_histories.created_at', '<=', $todate)
            ->where('order_status_histories.status', 'PickUp Cancel')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();
        $totalPickupCancel = PickUpRequestAssign::join('order_status_histories', 'pick_up_request_assigns.tracking_id', 'order_status_histories.tracking_id')

            ->where('order_status_histories.status', 'PickUp Cancel')
            ->select('order_status_histories.*', 'pick_up_request_assigns.*')
            ->count();




        $todayOrderPlaced = OrderStatusHistory::where('status', 'Order Placed')
            ->whereDate('created_at', $today)
            ->count();

        $totalOrderPlaced = OrderStatusHistory::where('status', 'Order Placed')
            ->count();


        $todayPickupDone = OrderStatusHistory::where('status', 'Pickup Done')
            ->whereDate('created_at', $today)
            ->count();

        $totalPickupDone = OrderStatusHistory::where('status', 'Pickup Done')
            ->count();



        $todayPickupAmount = Order::where('status', 'Pickup Done')
            ->whereDate('created_at', $today)
            ->sum('collection');

        $totalPickupAmount = Order::where('status', 'Pickup Done')
            ->sum('collection');


        $todayOneHourPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', $today)
            ->where('type', 'Urgent')
            ->count();

        $totalOneHourPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->where('type', 'Urgent')
            ->count();


        $TodayRegularPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', $today)
            ->where('type', 'Regular')
            ->count();

        $TotalRegularPickup = OrderStatusHistory::where('order_status_histories.status', 'Pickup Done')
            ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->where('type', 'Regular')
            ->count();





        $TodayRegularDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', $today)
            ->where('orders.type', 'Regular')
            ->count();

        $TotalRegularDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->where('orders.type', 'Regular')
            ->count();

        $TodayUrgentDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.created_at', $today)
            ->where('orders.type', 'Urgent')
            ->count();
        $TotalUrgentDelivery = OrderStatusHistory::whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->where('orders.type', 'Urgent')
            ->count();


        $todayOrdercancel = OrderStatusHistory::whereIn('order_status_histories.status', ['Return Confirm', 'Return Reach For Fullfilment', 'Return Payment Processing'])
            ->whereDate('created_at', $today)
            ->count();
        $totalOrdercancel = OrderStatusHistory::whereIn('order_status_histories.status', ['Return Confirm', 'Return Reach For Fullfilment', 'Return Payment Processing'])
            ->count();


        $todayOrderCancelAmount = Order::where('status', 'Order Cancel')
            ->whereDate('created_at', $today)
            ->sum('collection');

        $totalOrderCancelAmount = Order::where('status', 'Order Cancel')
            ->sum('collection');


        $todayPaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
            ->whereDate('created_at', $today)
            ->sum('t_payable');

        $totalPaidAmount = MerchantPayment::whereIn('status', ['Payment Paid By Fulfillment', 'Payment Processing'])
            ->sum('t_payable');

        $todayPaid = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->where('orders.status', 'Payment Completed')
            ->whereDate('order_confirms.created_at', $today)
            ->sum('collect');
        $totalPaid = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->where('orders.status', 'Payment Completed')
            ->sum('collect');


        $pRt = Order::where('status', 'PickUp Request')
            ->count();
        $pCt = Order::where('status', 'Order Collect')
            ->count();
        $totalPCl = Order::whereIn('status', ['PickUp Cancel', 'Order Cancel by Branch'])
            ->whereDate('created_at', $today)
            ->count();
        $dWt = Order::where('status', 'Waiting For Delivery')
            ->count();
        $dCt = Order::where('status', 'Order Delivered')
            ->count();
        $dPg = Order::where('status', 'Delivery Pending')
            ->count();
        $pPr = Order::where('status', 'Payment Processing')
            ->count();
        $pCt = Order::where('status', 'Payment Complete')
            ->count();

        $uPu = Order::where('status', 'PickUp Request')
            ->where('type', 'Urgent')
            ->count();

        $rPu = Order::where('status', 'PickUp Request')
            ->where('type', 'Regular')
            ->count();

        $total_success_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered'])
            ->whereDate('order_status_histories.updated_at', '=', $today)
            ->count();
        $total_unsuccessfully_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
            ->whereDate('order_status_histories.updated_at', '=', $today)
            ->count();






        $total_order_count = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereDate('order_status_histories.updated_at', '=', $today)
            ->count();


        $todays_total_delivery_success_ratio = 0;
        $todays_total_delivery_unsuccess_ratio = 0;


        if ($total_unsuccessfully_delivery > 0) {

            $unsuccessPercentage = ($total_unsuccessfully_delivery / $total_order_count) * 100;

            $todays_total_delivery_unsuccess_ratio = number_format($unsuccessPercentage);
        }


        /*Total Successfully delivery ratio*/
        if ($total_success_delivery > 0) {
            $successPercentage = ($total_success_delivery / $total_order_count) * 100;

            $todays_total_delivery_success_ratio = number_format($successPercentage);
        }


        $merchant_payments = MerchantPayment::where('m_payments.status', "Payment Processing")
            ->whereDate('m_payments.updated_at', '=', $today)
            ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')

            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();

        $today_total_merchant_payment_processing =   $merchant_payments->sum('t_payable');


        $merchant_payments1 = MerchantPayment::where('m_payments.status', "Payment Processing")
            ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')

            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();

        $total_merchant_payment_processing =   $merchant_payments1->sum('t_payable');


        $paid_amount = MerchantPayment::whereIn('m_payments.status', ['Payment Received By Merchant', 'Payment Paid By Fulfillment'])
            ->whereDate('m_payments.updated_at', '=', $today)
            ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')

            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();


        $today_total_paid_amount =   $paid_amount->sum('t_payable');


        $paid_amount1 = MerchantPayment::whereIn('m_payments.status', ['Payment Received By Merchant', 'Payment Paid By Fulfillment'])

            ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')

            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();


        $total_paid_amount =   $paid_amount1->sum('t_payable');





        $today_pickup_request = PickUpRequest::whereDate('created_at', Carbon::today())->count();

        $total_pickup_request = PickUpRequest::count();


        $today_payment_request = PaymentRequest::whereDate('created_at', Carbon::today())->count();

        $total_payment_request = PaymentRequest::count();

        $TodayPCl = Order::whereIn('status', ['PickUp Cancel', 'Order Cancel by Branch'])
            ->whereDate('created_at', $today)
            ->count();
        $TotalPCl = Order::whereIn('status', ['PickUp Cancel', 'Order Cancel by Branch'])
            ->count();


        $total_success_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered'])
            ->count();
        $total_unsuccessfully_delivery = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Order Placed', 'Assigned Pickup Rider', 'Pickup Done', 'Received by Pickup Branch', 'Order Bypass By Destination Hub', 'Assigned To Delivery Rider', 'Assigned delivery Rider', 'Hold Order', 'Hold Order Received from Branch', 'Received By Destination Hub', 'Delivered Amount Collected from Branch'])
            ->count();


        $total_order_count = Order::join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->count();



        $total_delivery_success_ratio = 0;
        $total_delivery_unsuccess_ratio = 0;

        /*Total UnSuccessfully delivery ratio*/
        //$total_unsuccessfully_delivery = $total_order_count - $total_success_delivery;
        if ($total_unsuccessfully_delivery > 0) {

            $unsuccessPercentage = ($total_unsuccessfully_delivery / $total_order_count) * 100;

            $total_delivery_unsuccess_ratio = number_format($unsuccessPercentage);
        }
        /*Total Successfully delivery ratio*/
        if ($total_success_delivery > 0) {
            $successPercentage = ($total_success_delivery / $total_order_count) * 100;

            $total_delivery_success_ratio = number_format($successPercentage);
        }


        return view('Admin.Home.super_admin_dashboard_new', compact('todayPaid', 'totalPaid', 'total_delivery_unsuccess_ratio', 'total_delivery_success_ratio', 'today_total_paid_amount', 'total_pickup_rquest', 'totalPickupCancel', 'totalOrderPlaced', 'totalPickupDone', 'totalPickupAmount', 'totalOneHourPickup', 'TotalRegularPickup', 'TotalRegularDelivery', 'TotalUrgentDelivery', 'totalOrdercancel', 'totalOrderCancelAmount', 'totalPaidAmount', 'total_merchant_payment_processing', 'total_paid_amount', 'total_pickup_request', 'total_payment_request', 'TotalPCl', 'todays_total_delivery_success_ratio', 'today_total_merchant_payment_processing', 'todays_total_delivery_unsuccess_ratio', 'TodayPCl', 'today_pickup_rquest', 'todayPickupCancel', 'todayOrderPlaced', 'todayPickupDone', 'todayPickupAmount', 'todayOneHourPickup', 'TodayRegularPickup', 'TodayRegularDelivery', 'TodayUrgentDelivery', 'todayOrdercancel', 'todayOrderCancelAmount', 'todayPaidAmount', 'today_total_paid_amount', 'today_pickup_request', 'today_payment_request'));
    }
    public function rider_transfer_pickup()
    {

        $from_rider = '';

        $riders = User::orderBy('users.name', 'ASC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('users.*')
            ->where('users.role', 10)
            ->get();

        $hub_list = User::where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select(
                'users.name',
                'users.id as uid'
            )->get();



        $orders = [];

        return view('Admin.Rider.Transfer.Pickup.index', compact('from_rider', 'riders', 'hub_list', 'orders'));
    }



    public function rider_transfer_pickup_load(Request $request)
    {

        $from_rider =  $request->from_rider;

        $rider = Rider::where('user_id', $from_rider)->first();
        $area = $rider->area;
        $riders = User::orderBy('users.name', 'ASC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('users.*')
            ->where('users.role', 10)
            ->get();


        $hub_list = User::where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select('users.name', 'users.id as uid')->get();




        $orders = PickUpRequestAssign::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('orders', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('order_confirms.*', 'users.*', 'merchants.*', 'orders.*')
            ->where('merchants.area', $area)
            ->where('pick_up_request_assigns.user_id', $from_rider)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get()->unique('tracking_id');

        return view('Admin.Rider.Transfer.Pickup.index', compact('riders', 'hub_list', 'orders', 'from_rider'));
    }


    public function rider_transfer_pickup_bypass_order(Request $request)
    {
        //return $request->all();
        $tracking_ids = $request->tracking_ids;

        if (!$tracking_ids) {
            \Toastr::error('Please Select first.', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        if ($request->form_rider === $request->to_rider) {
            \Toastr::error('You Can\'n Bypass Same Rider', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }

        foreach ($tracking_ids as $tracking_id) {

            $history = OrderStatusHistory::where('tracking_id', $tracking_id)->first();
            if ($history) {
                $history->user_id = $request->to_rider;
                $history->save();
            }

            $req = PickUpRequestAssign::where('tracking_id', $tracking_id)->first();
            if ($req) {
                $req->user_id = $request->to_rider;
                $req->save();
            }
        }



        \Toastr::success('Successfully Bypass ', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }



    public function rider_transfer_delivery()
    {
        $from_rider =  "";


        $riders = User::orderBy('users.name', 'ASC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('users.*')
            ->where('users.role', 10)
            ->get();

        $hub_list = User::where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select(
                'users.name',
                'users.id as uid'
            )->get();

        $orders = [];
        return view('Admin.Rider.Transfer.Delivery.index', compact('from_rider', 'hub_list', 'orders', 'riders'));
    }
    public function rider_transfer_delivery_load(Request $request)
    {
        $from_rider =  $request->from_rider;
        $rider = Rider::where('user_id', $from_rider)->first();
        $area = $rider->area;

        $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
        $my_array = $area_list->pluck('area');

        $riders = User::orderBy('users.name', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('users.*')
            ->where('users.role', 10)
            ->get();

        $hub_list = User::where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select('users.name', 'users.id as uid')->get();



        $orders = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'orders.tracking_id', 'delivery_assigns.tracking_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->where('orders.status', 'Assigned To Delivery Rider')
            ->select('orders.*', 'order_confirms.*')
            ->whereIn('area', $my_array)
            ->where('delivery_assigns.user_id', $from_rider)
            ->get();
        return view('Admin.Rider.Transfer.Delivery.index', compact('orders', 'riders', 'from_rider', 'hub_list'));
    }
    public function rider_transfer_delivery_bypass_order(Request $request)
    {

        $tracking_ids = $request->tracking_ids;

        if (!$tracking_ids) {
            \Toastr::error('Please Select first.', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        if ($request->form_rider === $request->to_rider) {
            \Toastr::error('You Can\'n Bypass Same Rider', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }

        foreach ($tracking_ids as $tracking_id) {

            $history = OrderStatusHistory::where('tracking_id', $tracking_id)->first();
            if ($history) {
                $history->user_id = $request->to_rider;
                $history->save();
            }

            $req = DeliveryAssign::where('tracking_id', $tracking_id)->first();
            if ($req) {
                $req->user_id = $request->to_rider;
                $req->save();
            }
        }

        \Toastr::success('Successfully Bypass ', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }












    public function merchant_register()
    {
        $business = BusinessType::orderBy('id', 'DESC')->where('status', 1)->get();
        $districts = DB::table('districts')->orderBy('name', 'asc')->get();
        $slider = Slider::orderBy('id', 'DESC')->where('status', 1)->get();
        $area = CoverageArea::orderBy('id', 'DESC')->get();



        return view('Admin.AdminPanel.new_merchant_register', compact('districts', 'business', 'slider', 'area'));
    }


    public function forget_password_otp(Request $request)
    {
        return view('auth.otp_send');
    }

    public function forget_password_store(Request $request)
    {

        $request->validate([
            'mobile' => 'required|digits:11',
        ], [
            'mobile.required' => 'The mobile number is required.',
            'mobile.digits' => 'The mobile number must be exactly 11 digits.',
        ]);

        try {
            // Check if the mobile number exists in the User table
            $user = User::where('mobile', $request->input('mobile'))->first();

            if ($user) {
                // Generate a random 4-digit OTP
                $id = User::where('mobile', $request->input('mobile'))->value('id');
                $otp = rand(1000, 9999);

                // Update the user's record with the OTP
                User::where('id', $id)->update([
                    'one_time_otp' => $otp
                ]);

                // Prepare the SMS text
                $smsText = "Your Forget Password One-Time OTP is " . $otp;

                // Send the OTP via SMS
                Helpers::otp_send($request->input('mobile'), $smsText);

                // Flash success message
                return redirect()->route('forget_password_reset');
            } else {
                // Flash error message
                return redirect()->back()->with('message', 'Your phone number does not match');
            }
        } catch (\Exception $e) {
            // Flash error message
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again later.');
        }
    }

    public function forget_password_reset(Request $request)
    {

        return view('auth.otp_with_pasword_reset');
    }

    public function forget_password_reset_store(Request $request)
    {
        $user_id = User::where('one_time_otp', $request->otp)->value('id');

        if ($user_id) {

            $user = User::whereId($user_id)->first();

            User::where('id', $user->id)
                ->update(['password' => Hash::make($request->password)]);
           // return redirect()->back()->with('message', 'Password Update Successfully');
           return redirect()->route('login');
        } else {
            return redirect()->back()->with('message', 'Your Otp code is not Correct');
        }
    }
}
