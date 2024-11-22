<?php

namespace App\Http\Controllers;

use App\Admin\BusinessType;
use App\Admin\Category;
use App\Admin\CoverageArea;
use App\Admin\Order;
use App\Admin\Company;
use App\Admin\Employee;
use App\Admin\OrderConfirm;
use App\Admin\OrderProduct;
use App\Admin\OrderStatusHistory;
use App\Admin\PickUpTime;
use App\Admin\RiderPayment;
use App\Admin\Product;
use App\Admin\Agent;
use App\Admin\BranchDistrict;
use App\Admin\District;
use App\Admin\Shop;
use App\Admin\Merchant;
use App\Admin\MerchantPayment;
use App\Admin\MerchantPaymentAdjustment;
use App\Admin\MerchantPaymentDetail;
use App\Admin\MerchantPaymentInfo;
use App\Admin\MPayment;
use App\Admin\WeightPrice;
use App\Admin\Zone;
use App\DeliveryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\User;
use Carbon\Carbon;
use Response;
use DataTables;
use Route;
use URL;
use Redirect;
use DateTime;
use Exception;

use function GuzzleHttp\Promise\all;

class OrderController extends Controller
{
    public function index(Request $request)
    {


        $user = User::where('id', Auth::user()->id)->first();


        if (session('fromdate')) {
            $fromdate = session('fromdate');
            $todate = session('todate');
            session()->forget('fromdate');
            session()->forget('todate');
        } else {
            $todate =  date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }







        if ($user->role == 8) {
            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');



            if ($request->merchant_id) {


                if ($request->ajax()) {



                    $data = Order::where('orders.user_id', $request->merchant_id)->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                        ->join('merchants', 'orders.user_id', 'merchants.user_id')
                        ->join('users', 'orders.user_id', 'users.id')
                        //->select('orders.*')
                        ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                        ->whereDate('orders.created_at', '>=', $request->fromdate)
                        ->whereDate('orders.created_at', '<=', $request->todate)
                        ->orderBy('orders.id', 'DESC')
                        ->get();



                    return Datatables::of($data)
                        ->make(true);
                }
            } else {


                if ($request->ajax()) {



                    $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                        ->join('merchants', 'orders.user_id', 'merchants.user_id')
                        ->join('users', 'orders.user_id', 'users.id')
                        //->select('orders.*')
                        ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                        ->whereDate('orders.created_at', '>=', $request->fromdate)
                        ->whereDate('orders.created_at', '<=', $request->todate)
                        ->orderBy('orders.id', 'DESC')
                        ->get();



                    return Datatables::of($data)
                        ->make(true);
                }

                /* $data = Order::orderBy('order_confirms.id', 'DESC')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    // ->whereDate('orders.created_at', '>=', $request->fromdate)
                    // ->whereDate('orders.created_at', '<=', $request->todate)
                    ->get();

                    */
            }
        } else {

            if ($request->merchant_id) {







                if ($request->ajax()) {



                    $data = Order::where('orders.user_id', $request->merchant_id)->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                        ->join('merchants', 'orders.user_id', 'merchants.user_id')
                        ->join('users', 'orders.user_id', 'users.id')
                        //->select('orders.*')
                        ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                        ->whereDate('orders.created_at', '>=', $request->fromdate)
                        ->whereDate('orders.created_at', '<=', $request->todate)
                        ->orderBy('orders.id', 'DESC')
                        ->get();



                    return Datatables::of($data)
                        ->make(true);
                }
            } else {
                if ($request->ajax()) {



                    $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                        ->join('merchants', 'orders.user_id', 'merchants.user_id')
                        ->join('users', 'orders.user_id', 'users.id')
                        //->select('orders.*')
                        ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                        ->whereDate('orders.created_at', '>=', $request->fromdate)
                        ->whereDate('orders.created_at', '<=', $request->todate)
                        ->orderBy('orders.id', 'DESC')
                        ->get();



                    return Datatables::of($data)
                        ->make(true);
                }
            }


            $zone_id = '';
        }


        if (!isset($data)) {

            $data = [];
        }





        if (Auth::user()->role == 1 || Auth::user()->role == 4) {
            //return $data;
            $merchants = Merchant::join('users', 'merchants.user_id', 'users.id')
                ->where('users.role', 12)->select('merchants.*')->get();
            $merchant = $request->merchant;
            return view('Admin.Order.orderList', compact('data', 'merchants', 'merchant', 'fromdate', 'todate', 'zone_id'));
        } else if (Auth::user()->role == 8) {
            $merchants = Merchant::join('users', 'merchants.user_id', 'users.id')
                ->where('users.role', 12)->select('merchants.*')->get();
            $merchant = $request->merchant;

            return view('Admin.Order.hub_orderList', compact('data', 'merchants', 'merchant', 'fromdate', 'todate', 'zone_id'));
        }
    }


    public function order_list_new(Request $request)
    {

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $threeDaysAgo = Carbon::now()->subDays(3);
        $currentDate = Carbon::now();
        $merchants = Merchant::join('users', 'merchants.user_id', 'users.id')
            ->where('users.role', 12)->select('merchants.*')->get();


        // $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     //->select('orders.*')
        //     ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
        //     // ->whereDate('orders.created_at', '>=', $request->fromdate)
        //     // ->whereDate('orders.created_at', '<=', $request->todate)
        //     ->get();

        // //  return $data;

        if (Auth::user()->role == 12) {
            $merchants = Merchant::join('users', 'merchants.user_id', 'users.id')
                ->where('users.role', 12)->select('merchants.*')->get();
            $merchant = $request->merchant;

            if ($request->fromdate &&  $request->todate) {
                $data =  DB::table('orders')->where('orders.user_id', Auth::user()->id)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->orderBy('orders.id', 'DESC')
                    ->get();

                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            } else {
                $data =  DB::table('orders')->where('orders.user_id', Auth::user()->id)
                    ->whereDate('orders.created_at', '>=', $threeDaysAgo)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->orderBy('orders.id', 'DESC')
                    ->get();



                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            }
        } elseif (Auth::user()->role == 8) {
            $merchants = Merchant::join('users', 'merchants.user_id', 'users.id')
                ->where('users.role', 12)->select('merchants.*')->get();
            $merchant = $request->merchant;

            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            if ($merchant) {
                $data = DB::table('orders')->where('orders.user_id', $merchant)->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->whereIn('orders.area', $my_array)
                    ->join('users', 'orders.user_id', 'users.id')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    // ->join('order_status_histories', function ($join) {
                    //     $join->on('orders.tracking_id', '=', 'order_status_histories.tracking_id')
                    //         ->whereRaw('order_status_histories.created_at = (SELECT MAX(created_at) FROM order_status_histories WHERE order_status_histories.tracking_id = orders.tracking_id)');
                    // })
                    // ->join('users as status_user', 'order_status_histories.user_id', 'status_user.id')
                    // ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile', 'status_user.name as status_change_user', 'order_status_histories.status as last_status')
                    ->orderBy('orders.id', 'DESC')
                    ->get();

                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            } elseif ($request->fromdate &&  $request->todate) {
                $data = DB::table('orders')->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->whereIn('orders.area', $my_array)
                    ->join('users', 'orders.user_id', 'users.id')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    // ->join('order_status_histories', function ($join) {
                    //     $join->on('orders.tracking_id', '=', 'order_status_histories.tracking_id')
                    //         ->whereRaw('order_status_histories.created_at = (SELECT MAX(created_at) FROM order_status_histories WHERE order_status_histories.tracking_id = orders.tracking_id)');
                    // })
                    // ->join('users as status_user', 'order_status_histories.user_id', 'status_user.id')
                    // ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile', 'status_user.name as status_change_user', 'order_status_histories.status as last_status')
                    ->orderBy('orders.id', 'DESC')
                    ->get();

                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            } else {


                $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->whereDate('orders.created_at', '>=', $threeDaysAgo)
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    // ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->join('order_status_histories', function ($join) {
                        $join->on('orders.tracking_id', '=', 'order_status_histories.tracking_id')
                            ->whereRaw('order_status_histories.created_at = (SELECT MAX(created_at) FROM order_status_histories WHERE order_status_histories.tracking_id = orders.tracking_id)');
                    })
                    ->join('users as status_user', 'order_status_histories.user_id', 'status_user.id')
                    ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile', 'status_user.name as status_change_user', 'order_status_histories.status as last_status')
                    ->orderBy('orders.id', 'DESC')
                    ->get();

                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            }
        } else {
            $merchants = Merchant::join('users', 'merchants.user_id', 'users.id')
                ->where('users.role', 12)->select('merchants.*')->get();
            $merchant = $request->merchant;

            if ($merchant) {
                $data = Order::where('orders.user_id', $merchant)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)
                    // ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    // ->join('order_status_histories', function ($join) {
                    //     $join->on('orders.tracking_id', '=', 'order_status_histories.tracking_id')
                    //         ->whereRaw('order_status_histories.created_at = (SELECT MAX(created_at) FROM order_status_histories WHERE order_status_histories.tracking_id = orders.tracking_id)');
                    // })
                    // ->join('users as status_user', 'order_status_histories.user_id', 'status_user.id')
                    // ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile', 'status_user.name as status_change_user', 'order_status_histories.status as last_status')
                    ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile')
                    ->orderBy('orders.id', 'DESC')
                    ->get();
                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            } elseif ($request->fromdate &&  $request->todate) {

                $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)
                    // ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    // ->join('order_status_histories', function ($join) {
                    //     $join->on('orders.tracking_id', '=', 'order_status_histories.tracking_id')
                    //         ->whereRaw('order_status_histories.created_at = (SELECT MAX(created_at) FROM order_status_histories WHERE order_status_histories.tracking_id = orders.tracking_id)');
                    // })
                    // ->join('users as status_user', 'order_status_histories.user_id', 'status_user.id')
                    // ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile', 'status_user.name as status_change_user', 'order_status_histories.status as last_status')
                    ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile')
                    ->orderBy('orders.id', 'DESC')
                    ->get();

                // $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
                //     ->join('users', 'orders.user_id', 'users.id')
                //     ->whereDate('orders.created_at', '>=', $request->fromdate)
                //     ->whereDate('orders.created_at', '<=', $request->todate)
                //     ->leftJoin('order_status_histories', function ($join) {
                //         $join->on('orders.tracking_id', '=', 'order_status_histories.tracking_id')
                //             ->whereRaw('order_status_histories.id = (SELECT MAX(id) FROM order_status_histories WHERE order_status_histories.tracking_id = orders.tracking_id)');
                //     })
                //     ->leftJoin('users as status_user', 'order_status_histories.user_id', 'status_user.id')
                //     ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile', 'status_user.name as status_change_user', 'order_status_histories.status as last_status')
                //     ->orderBy('orders.id', 'DESC')
                //     ->get();



                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            } else {

                $data = Order::whereDate('orders.created_at', '>=', $threeDaysAgo)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    // ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    // ->join('order_status_histories', function ($join) {
                    //     $join->on('orders.tracking_id', '=', 'order_status_histories.tracking_id')
                    //         ->whereRaw('order_status_histories.created_at = (SELECT MAX(created_at) FROM order_status_histories WHERE order_status_histories.tracking_id = orders.tracking_id)');
                    // })
                    // ->join('users as status_user', 'order_status_histories.user_id', 'status_user.id')
                    ->select('order_confirms.*', 'merchants.*', 'orders.*', 'users.name', 'users.mobile')
                    ->orderBy('orders.id', 'DESC')
                    ->get();


                return view('Admin.Order.orderListnew', compact('data', 'merchant', 'fromdate', 'todate', 'merchants'));
            }
        }
    }


    public function create_order_list(Request $request)
    {

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        if ($request->fromdate && $request->todate) {

            $fromdate = $request->fromdate;
            $data = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                ->whereDate('orders.created_at', '>=', $request->fromdate)
                ->whereDate('orders.created_at', '<=', $request->todate)
                ->orderBy('orders.id', 'DESC')
                ->get();
               

            return view('Admin.Order.create_order_list', compact('data', 'fromdate', 'today'));
        } else {
            $data = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                ->orderBy('orders.id', 'DESC')
                ->take(5)->get();


            return view('Admin.Order.create_order_list', compact('data', 'today'));
        }
    }

    public function order_list_get(Request $request)
    {
        $data = Order::where('orders.id', $request->id)
            ->join('merchants', 'orders.user_id', '=', 'merchants.user_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'merchants.business_name as merchant_business_name', 'users.name as user_name', 'users.mobile as user_phone')
            ->get();

        return response()->json($data);
    }

    public function success_order_list(Request $request)
    {

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');



        // $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     //->select('orders.*')
        //     ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
        //     // ->whereDate('orders.created_at', '>=', $request->fromdate)
        //     // ->whereDate('orders.created_at', '<=', $request->todate)
        //     ->get();

        // //  return $data;



        // $data = Order::where('orders.user_id', Auth::user()->id)
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     //->select('orders.*')
        //     ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
        //     ->orderBy('orders.id', 'DESC')
        //     ->get();

        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $data = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->join('order_confirms', 'order_status_histories.tracking_id', 'order_confirms.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                ->whereDate('order_status_histories.updated_at', '>=', $request->fromdate)
                ->whereDate('order_status_histories.updated_at', '<=', $request->todate)
                ->get();

            return view('Admin.Order.success_order_list', compact('data', 'fromdate', 'today'));
        } else {
            $data = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                ->join('order_confirms', 'order_status_histories.tracking_id', 'order_confirms.tracking_id')
                ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                // ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
                // ->whereDate('order_status_histories.updated_at', '<=', $todate)
                ->get();

            return view('Admin.Order.success_order_list', compact('data', 'today'));
        }
    }


    public function return_order_list(Request $request)
    {

        // dd($request->all());

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');



        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;

            $data = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
                ->whereDate('orders.updated_at', '>=', $request->fromdate)
                ->whereDate('orders.updated_at', '<=', $request->todate)
                ->select('orders.*')
                ->get();



            return view('Admin.Order.return_order_list', compact('data', 'fromdate', 'today'));
        } else {
            $data = Order::where('orders.user_id', Auth::user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
                ->select('orders.*')
                ->get();

            return view('Admin.Order.return_order_list', compact('data', 'today'));
        }
    }

    public function transit_order_list(Request $request)
    {

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');



        // $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     //->select('orders.*')
        //     ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
        //     // ->whereDate('orders.created_at', '>=', $request->fromdate)
        //     // ->whereDate('orders.created_at', '<=', $request->todate)
        //     ->get();

        // //  return $data;



        // $data = Order::where('orders.user_id', Auth::user()->id)
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     //->select('orders.*')
        //     ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
        //     ->orderBy('orders.id', 'DESC')
        //     ->get();

        // $data = Order::where('orders.user_id', Auth::user()->id)
        //     ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
        //     ->join('order_confirms', 'order_status_histories.tracking_id', 'order_confirms.tracking_id')
        //     ->whereIn('order_status_histories.status', ['Return Confirm', 'Cancel Order'])
        //     // ->whereDate('order_status_histories.updated_at', '>=', $fromdate)
        //     // ->whereDate('order_status_histories.updated_at', '<=', $todate)
        //     ->get();

        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;

            $data = Order::where('orders.user_id', Auth::user()->id)->join('merchants', 'orders.user_id', 'merchants.user_id')->whereIn(
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
            )->whereBetween(DB::raw('DATE(orders.updated_at)'), [$request->fromdate, $request->todate])->select('orders.*')->get();


            return view('Admin.Order.transit_order_list', compact('data', 'fromdate', 'today'));
        } else {
            $data = Order::where('orders.user_id', Auth::user()->id)->join('merchants', 'orders.user_id', 'merchants.user_id')->whereIn(
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
            )->select('orders.*')->get();


            return view('Admin.Order.transit_order_list', compact('data', 'today'));
        }
    }

    public function delivery_amount_list(Request $request)
    {

        $total_dalivery_amount = Order::where('orders.user_id', Auth::user()->id)
            ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
            ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
            ->get();


        $total_collection = $total_dalivery_amount->sum('collection');

        $total_collect = $total_dalivery_amount->sum('collect');

        return view('Admin.Order.total_delivery_amount', compact('total_collection', 'total_collect', 'total_dalivery_amount'));
    }


    public function payment_processing_list(Request $request)
    {

        $total_paymentProcessing = MPayment::where('m_user_id', Auth::user()->id)
            ->join('users', 'm_payments.created_by', 'users.id')
            ->whereIn('status', ['Payment Processing', 'Payment Paid By Fulfillment'])->select('m_payments.*', 'users.name as users_name')->get();



        $total_payable = $total_paymentProcessing->sum('t_payable');

        return view('Admin.Order.total_payment_processing', compact('total_paymentProcessing', 'total_payable'));
    }


    public function paid_amount_list(Request $request)
    {

        $total_paymentComplete = MPayment::where('m_user_id', Auth::user()->id)
            ->join('users', 'm_payments.created_by', 'users.id')
            ->whereIn('status', ['Payment Received By Merchant'])
            ->select('m_payments.*', 'users.name as users_name')->get();

        $total_payable = $total_paymentComplete->sum('t_payable');




        return view('Admin.Order.total_paid_amount', compact('total_paymentComplete', 'total_payable'));
    }

    public function payment_print_all(Request $request)
    {
        $invoice_ids = $request->invoice_id;
        $merchant_name = MerchantPayment::where('m_payments.invoice_id', $invoice_ids)
            ->join('merchants', 'merchants.id', 'm_payments.m_id')
            ->join('users', 'm_payments.m_user_id', 'users.id')
            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->first();

        $merchantpay = MerchantPayment::where('m_user_id', Auth::user()->id)->where('invoice_id', $request->invoice_id)->first();


        $merchantPayments = MerchantPaymentDetail::where('invoice_id', $merchantpay->invoice_id)
            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            ->join('users', 'orders.user_id',  'users.id')
            ->join('merchants', 'orders.user_id',  'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
            ->select('m_pay_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'merchants.business_name as merchant')
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


        return view('Admin.Order.payment_print_list', compact('merchantPayments', 'tCollection', 'tCollect', 'tCod', 'tDelivery', 'tReturnCharge', 'tPayable'));
    }


    public function order_activities(Request $remarks)
    {
        $d = new DateTime("now");
        $today = $d->format('Y-m-d');


        $startDate = Carbon::now()->format('d');
        $endDate = Carbon::now()->subDays(3)->toDateString(); // Current date

        $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            //->select('orders.*')
            ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')

            ->whereBetween(DB::raw('DATE(orders.created_at)'), [$startDate, $endDate])
            ->get();

        // return $data->count();


        return view('Admin.Order.order_activities', compact('data', 'today'));
    }

    public function order_list_date_wise(Request $request)
    {

        // dd($request->all());   

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        // $fromdate = $request->form_date;
        // if ($request->todate) {
        //     $todate = $request->to_date;
        // } else {
        //     $todate = $today;
        // }

        $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            //->select('orders.*')
            ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
            ->whereDate('orders.created_at', '>=', $request->fromdate)
            ->whereDate('orders.created_at', '<=', $request->todate)
            ->get();



        return view('Admin.Order.orderListnew', compact('data', 'today'));
    }



    public function order_activities_date_wise(Request $request)
    {
        // dd($request->all());   



        $d = new DateTime("now");
        $today = $d->format('Y-m-d');


        $startDate = Carbon::now()->format('d');
        $endDate = Carbon::now()->subDays(3)->toDateString(); // Current date

        $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
            ->whereDate('orders.created_at', '>=', $request->fromdate)
            ->whereDate('orders.created_at', '<=', $request->todate)
            ->whereBetween(DB::raw('DATE(orders.created_at)'), [$startDate, $endDate])
            ->get();




        return view('Admin.Order.order_activities', compact('data', 'today'));
    }


    public function status_change_index(Request $request)
    {

        if (session('fromdate')) {
            $fromdate = session('fromdate');
            $todate = session('todate');
            session()->forget('fromdate');
            session()->forget('todate');
        } else {
            $todate =  date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($request->fromdate || $request->todate) {

            if ($request->ajax()) {

                $data = Order::join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    //->select('orders.*')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->where('orders.status', 'Successfully Delivered')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)
                    ->get();

                return Datatables::of($data)
                    ->make(true);
            }
        }

        if (!isset($data)) {

            $data = [];
        }



        return view('Admin.Order.orderList_status', compact('data', 'fromdate', 'todate'));
    }


    public function change_status(Request $request)
    {

        Order::where('tracking_id', $request->id)
            ->update([
                'status'    => 'Assigned To Delivery Rider',

            ]);




        OrderConfirm::where('tracking_id', $request->id)
            ->update([
                'collect'    => 0,

            ]);


        $data = new OrderStatusHistory;
        $data->tracking_id = $request->id;
        $data->user_id = Auth::user()->id;
        $data->status = "Assigned To Delivery Rider";
        $data->save();

        \Toastr::success('Status Updated Successfully!', 'Status Updated', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        $fromdate = $request->fromdate;
        $todate = $request->todate;

        return redirect()->back()->with(['fromdate' => $fromdate, 'todate' => $todate]);
    }

    public function indexFiltering(Request $request)
    {

        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        // asifqs 
        // $data = Order::orderBy('order_confirms.id', 'DESC')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->select('orders.*', 'order_confirms.*', 'merchants.*',)
        //     ->whereDate('orders.created_at', $today)
        //     ->where('orders.status', "Order Placed")
        //     ->get();

        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
            ->whereDate('orders.created_at', $today)
            ->get();







        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate'));
    }
    public function indexFilteringT(Request $request)
    {

        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            // ->join('shops', 'orders.shop', 'shops.shop_name')
            ->select('orders.*', 'order_confirms.*')
            // ->whereDate('orders.created_at', $today)
            ->where('orders.status', "Order Placed")
            ->get();


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate'));
    }


    public function indexFilteringPickup(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            // ->join('shops', 'orders.shop', 'shops.shop_name')
            ->select('orders.*', 'order_confirms.*')
            ->whereDate('orders.created_at', $today)
            ->where('orders.status', "Pickup Done")
            ->get();


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate', 'todate'));
    }
    public function indexFilteringPickupT(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            // ->join('shops', 'orders.shop', 'shops.shop_name')
            ->select('orders.*', 'order_confirms.*')
            //->select('orders.*', 'order_confirms.*')
            // ->whereBetween('orders.updated_at', [$fromdate, $todate])
            // ->whereDate('orders.created_at', $today)
            ->where('orders.status', "Pickup Done")
            ->get();


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate'));
    }
    public function indexFilteringPickupOneHour(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($user->role == 8) {
            // agent role

            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');


            $data = Order::orderBy('orders.id', 'DESC')
                //->where('orders.area', $agent->area)
                ->orWhere('shops.shop_area', $agent->area)
                ->orWhereIn('orders.area', $my_array)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->get();
        } else {

            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                //->select('orders.*', 'order_confirms.*')
                // ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->whereDate('orders.created_at', $today)
                ->where('orders.status', "Pickup Done")
                ->where('orders.type', 'Urgent')
                ->get();
        }


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate', 'todate'));
    }
    public function indexFilteringPickupOneHourT(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            //->select('orders.*', 'order_confirms.*')
            // ->whereBetween('orders.updated_at', [$fromdate, $todate])
            // ->whereDate('orders.created_at', $today)
            ->where('orders.status', "Pickup Done")
            ->where('orders.type', 'Urgent')
            ->get();


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate'));
    }
    public function indexFilteringPickupRegular(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($user->role == 8) {
            // agent role

            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');


            $data = Order::orderBy('orders.id', 'DESC')
                //->where('orders.area', $agent->area)
                ->orWhere('shops.shop_area', $agent->area)
                ->orWhereIn('orders.area', $my_array)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->get();
        } else {

            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                //->select('orders.*', 'order_confirms.*')
                // ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->whereDate('orders.created_at', $today)
                ->where('orders.status', "Pickup Done")
                ->where('orders.type', 'Regular')
                ->get();
        }


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate', 'todate'));
    }
    public function indexFilteringPickupRegularT(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->where('orders.status', "Pickup Done")
            ->where('orders.type', 'Regular')
            ->get();


        return view('Admin.Order.FilteringOrderList', compact('data'));
    }
    public function regularFilteringDelivery(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($user->role == 8) {
            // agent role

            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');


            $data = Order::orderBy('orders.id', 'DESC')
                //->where('orders.area', $agent->area)
                ->orWhere('shops.shop_area', $agent->area)
                ->orWhereIn('orders.area', $my_array)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->get();
        } else {

            return     $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                // ->join('shops', 'orders.shop', 'shops.shop_name')
                ->select('orders.*', 'order_confirms.*')
                //->select('orders.*', 'order_confirms.*')
                // ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->whereDate('orders.created_at', $today)
                ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
                ->where('orders.type', 'Regular')
                ->get();
        }


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate', 'todate'));
    }
    public function regularFilteringDeliveryT(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            // ->join('shops', 'orders.shop', 'shops.shop_name')
            ->select('orders.*', 'order_confirms.*')
            ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
            ->where('orders.type', 'Regular')
            ->get();

        return view('Admin.Order.FilteringOrderList', compact('data'));
    }
    public function regularFilteringDeliveryOne(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($user->role == 8) {
            // agent role

            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');


            $data = Order::orderBy('orders.id', 'DESC')
                //->where('orders.area', $agent->area)
                ->orWhere('shops.shop_area', $agent->area)
                ->orWhereIn('orders.area', $my_array)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->get();
        } else {

            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereDate('orders.created_at', $today)
                ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
                ->where('orders.type', 'Urgent')
                ->get();
        }


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate', 'todate'));
    }
    public function regularFilteringDeliveryOneT(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
            ->where('orders.type', 'Urgent')
            ->get();


        return view('Admin.Order.FilteringOrderList', compact('data'));
    }
    public function orderCancelFiltering(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($user->role == 8) {
            // agent role

            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');


            $data = Order::orderBy('orders.id', 'DESC')
                //->where('orders.area', $agent->area)
                ->orWhere('shops.shop_area', $agent->area)
                ->orWhereIn('orders.area', $my_array)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->get();
        } else {

            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereDate('orders.created_at', $today)
                // ->where('orders.status', "Order Cancel")
                ->where('orders.status', 'Order Cancel')
                ->get();
        }


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate', 'todate'));
    }
    public function orderCancelFilteringT(Request $request)
    {
        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->where('orders.status', 'Order Cancel')
            ->get();
        return view('Admin.Order.FilteringOrderList', compact('data'));
    }
    public function orderPickupFiltering(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($user->role == 8) {
            // agent role

            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');


            $data = Order::orderBy('orders.id', 'DESC')
                //->where('orders.area', $agent->area)
                ->orWhere('shops.shop_area', $agent->area)
                ->orWhereIn('orders.area', $my_array)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->get();
        } else {

            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*')
                ->whereDate('orders.created_at', $today)
                // ->where('orders.status', "Order Cancel")
                ->where('orders.status', 'PickUp Cancel')
                ->get();
        }


        return view('Admin.Order.FilteringOrderList', compact('data', 'fromdate', 'todate'));
    }
    public function orderPickupFilteringT(Request $request)
    {
        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->where('orders.status', 'PickUp Cancel')
            ->get();

        return view('Admin.Order.FilteringOrderList', compact('data'));
    }


    public function confirm_edit(Request $request)
    {

        // dd($request->all());

        $districts = District::all();

        $order = Order::where('tracking_id', $request->id)->first();

        $order_confirm = OrderConfirm::where('tracking_id', $request->id)->first();

        $area_data = CoverageArea::where('district', $order->district)->get();

        $area = CoverageArea::where('district', $order->district)->get();

        $weights = WeightPrice::orderBy('id', 'DESC')->get();

        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();


        $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();


        $fromdate = $request->fromdate;
        $todate = $request->todate;


        if (Auth::user()->role == 1) {
            return view('Admin.Order.confirm_edit', compact('fromdate', 'todate', 'districts', 'area_data', 'order', 'order_confirm', 'weights', 'category', 'pickup'));
        } elseif (Auth::user()->role == 12) {
            return view('Admin.Order.merchant_confirm_edit', compact('area', 'order', 'weights', 'category', 'pickup'));
        }
    }

    public function confirm_edit_new(Request $request)
    {

        // dd($request->all());

        $districts = District::all();

        $order = Order::where('tracking_id', $request->id)->first();

        $order_confirm = OrderConfirm::where('tracking_id', $request->id)->first();

        $area_data = CoverageArea::where('district', $order->district)->get();

        $area = CoverageArea::where('district', $order->district)->get();

        $weights = WeightPrice::orderBy('id', 'DESC')->get();

        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();


        $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();


        $fromdate = $request->fromdate;
        $todate = $request->todate;


        if (Auth::user()->role == 1) {
            return view('Admin.Order.confirm_edit_new', compact('fromdate', 'todate', 'districts', 'area_data', 'order', 'order_confirm', 'weights', 'category', 'pickup'));
        } elseif (Auth::user()->role == 12) {
            return view('Admin.Order.merchant_confirm_edit', compact('area', 'order', 'weights', 'category', 'pickup'));
        }
    }


    public function print(Request $request)
    {


        $merchant_name = Order::where('tracking_id', $request->id)
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->value('merchants.business_name');

        $merchant_data = Order::where('tracking_id', $request->id)
            ->join('users', 'users.id', 'orders.user_id')
            ->first();



        $order_data = Order::where('tracking_id', $request->id)->first();




        return view('Admin.Order.print_preview', compact('merchant_name', 'order_data', 'merchant_data'));
    }

    public function confirm_store(Request $request)
    {


        $order_data = Order::Where('tracking_id', $request->tracking_id)->first();

        if ($order_data->area != $request->area || $order_data->type != $request->imp || $order_data->weight != $request->weight || $request->collection != $order_data->collection) {

            $ar = CoverageArea::where('area', $request->area)->first();
            $merchant = Merchant::where('user_id', $order_data->user_id)->first();

            $sPrice = WeightPrice::where('title', $request->weight)->first();




            $imp = $request->imp == 'Express' ? 'Urgent' : $request->imp;
            $collection = $request->collection;
            //Merchant 
            $m_discount = $merchant->m_discount;
            $ur_discount = $merchant->ur_discount;



            if ($ar->inside === 0) {
                //outside-Dhaka

                if ($imp == 'Regular') {
                    $delivery = $sPrice->out_Re  - $m_discount;
                } elseif ($imp == 'Urgent') {

                    $delivery = $sPrice->out_Ur  - $ur_discount;
                }
                $return = $sPrice->out_ReC;
            } elseif ($ar->inside === 1) {
                //Inside Dhaka
                if ($imp == 'Regular') {
                    $delivery = $sPrice->ind_Re - $m_discount;
                } elseif ($imp == 'Urgent') {

                    $delivery = $sPrice->ind_Ur - $ur_discount;
                }
                $return = $sPrice->ind_ReC;
            } else {
                //Sub Dhaka
                if ($imp == 'Regular') {


                    $delivery = $sPrice->sub_Re - $m_discount;
                } elseif ($imp == 'Urgent') {

                    $delivery = $sPrice->sub_Ur - $ur_discount;
                }
                $return = $sPrice->sub_ReC;
            }

            //dur 
            $m_cod = (($collection - $delivery) * $merchant->m_cod) / 100;
            $m_insurance =  (($collection - $delivery) * $merchant->m_insurance) / 100;

            $co = $sPrice->cod;
            $ins = $sPrice->insurance;


            $cod = (($collection - $delivery) * $co) / 100;
            $insurance = (($collection - $delivery) * $ins) / 100;
            //final
            $fCod = $cod - $m_cod;
            $fInsurance = $insurance - $m_insurance;

            $m_pay = $collection - ($delivery + ceil($fCod) + ceil($fInsurance));


            $order_confirm = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
            $order_confirm->colection = $request->collection;
            $order_confirm->delivery = $delivery;
            $order_confirm->insurance = ceil($fInsurance);
            $order_confirm->cod = ceil($fCod);
            $order_confirm->merchant_pay = ceil($m_pay);
            $order_confirm->return_charge = $return;
            $order_confirm->save();
        } else {

            $order_confirm = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
            $order_confirm->colection = $request->collection;
            $order_confirm->save();
        }

        $order = Order::Where('tracking_id', $request->tracking_id)->first();
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->customer_email = $request->customer_email;
        $order->customer_address = $request->customer_address;
        $order->collection = $request->collection;
        $order->weight = $request->weight;
        $order->isPartial = $request->is_partial == '' ? 0 : 1;
        $order->remarks = $request->remarks;
        $order->area = $request->area;
        // $order->shop_id = $request->area;
        $order->area_id = CoverageArea::where('area', $request->area)->first()->id;
        $order->category = $request->category;
        $order->product = $request->product;
        $order->order_id = $request->order_id;
        $order->type = $request->imp;
        $order->pickup_date = $request->pickup_date;
        $order->pickup_time = $request->pickup_time;
        $order->status = $request->status;
        $order->security_code = $request->security_code;
        $order->save();
        \Toastr::success('Return Products Reach to Merchant', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->route('order.list.index');
    }

    public function order_view(Request $request)
    {

        $data = Order::with('user')->where('orders.tracking_id', $request->id)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as merchant')
            ->first();


        $history = DB::table('order_status_histories')->join('users', 'users.id', '=', 'order_status_histories.user_id')->where('order_status_histories.tracking_id', $data->tracking_id)
            ->select('order_status_histories.status as status', 'order_status_histories.created_at as date', 'users.name as name', 'users.mobile as mobile')->get();

        $order_statuses = OrderStatusHistory::where('tracking_id', $data->tracking_id)->latest('id')->get();

        $new_array = array();
        foreach ($order_statuses as $key => $value) {

            if (!isset($new_array[$value['status']])) {
                $new_array[$value['status']] = $value;
            }
        }

        $order_statuses  = $new_array = array_values($new_array);


        $company = Company::first();



        return view('Admin.Order.order_view', compact('data', 'history', 'order_statuses', 'company'));
    }



    public function invoice_view(Request $request)
    {


        $data = Order::with('user')->where('orders.tracking_id', $request->id)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as merchant')
            ->first();

        $history = DB::table('order_status_histories')->join('users', 'users.id', '=', 'order_status_histories.user_id')->where('order_status_histories.tracking_id', $data->tracking_id)->select('order_status_histories.status as status', 'order_status_histories.created_at as date', 'users.name as name', 'users.mobile as mobile')->get();



        $order_statuses = OrderStatusHistory::where('tracking_id', $data->tracking_id)->latest('id')->get();

        $new_array = array();
        foreach ($order_statuses as $key => $value) {

            if (!isset($new_array[$value['status']])) {
                $new_array[$value['status']] = $value;
            }
        }

        $order_statuses   = $new_array = array_values($new_array);

        $company = Company::first();


        return view('Admin.Order.invoice_view', compact('data', 'history', 'order_statuses', 'company'));
    }


    public function create(Request $request)
    {



        if (Auth::user()->role == 12 || Auth::user()->role == 14) {
            // return "aaa";
            $today = date('Y-m-d');
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }

            //rised
            $company = Company::first();
            $h = $company->company_initial;

            $id = Auth::user()->id;
            $s = $sl + 1;
            $track = $h . $id . $s;

            $weights = WeightPrice::all();

            $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
            $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
            // $districts = District::all();
            $area = CoverageArea::orderBy('id', 'DESC')->get();

            $districts = District::orderBy('name', 'asc')->get();
            $zones = CoverageArea::orderBy('id', 'DESC')->get();


            $shop = Shop::orderBy('id', 'DESC')
                ->where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->get();



            return view(
                'Admin.Order.orderCreate',
                compact('today', 'track', 'category', 'pickup', 'area', 'shop', 'weights', 'districts', 'zones')
            );
        } else if (Auth::user()->role == 1 || Auth::user()->role == 4 || Auth::user()->role == 8 || Auth::user()->role == 18) {
            // return "xvdnhfjg";
            $today = date('Y-m-d');
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }

            //rised
            $company = Company::first();
            $h = $company->company_initial;

            $id = Auth::user()->id;
            $s = $sl + 1;
            $track = $h . $id . $s;

            $weights = WeightPrice::all();

            $districts = District::orderBy('name', 'asc')->get();
            $zones = CoverageArea::orderBy('id', 'DESC')->get();

            $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
            $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
            $area = CoverageArea::orderBy('id', 'DESC')->get();
            $shop = [];


            // $shop = Shop::orderBy('id', 'DESC')
            //     ->where('user_id', 580)
            //     ->where('status', 1)
            //     ->get();

            $merchants = User::where('role', 12)->join('merchants', 'merchants.user_id', 'users.id')->select('merchants.*')->get();
            return view(
                'Admin.Order.adminOrderCreate',
                compact('today', 'track', 'category', 'pickup', 'area', 'shop', 'weights', 'merchants', 'districts', 'zones')
            );
        }
    }


    public function backup_create(Request $request)
    {
        if (Auth::user()->role == 12 || Auth::user()->role == 14) {
            // return "aaa";
            $today = date('Y-m-d');
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }

            //rised
            $company = Company::first();
            $h = $company->company_initial;

            $id = Auth::user()->id;
            $s = $sl + 1;
            $dat = date('y');
            $track = $h . $id . $dat . $s;

            $weights = WeightPrice::all();

            $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
            $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
            // $districts = District::all();
            $area = CoverageArea::orderBy('id', 'DESC')->get();
            $hub = Zone::orderBy('name', 'DESc')->get();

            $data = Merchant::where('user_id', auth()->user()->id)->first();

            // $districts = District::orderBy('name', 'asc')->get();
            $districts = BranchDistrict::whereIn('z_id',[$data->zone_id,10])->orderBy('d_name', 'asc')->get();
            $zones = CoverageArea::orderBy('id', 'DESC')->get();


            $shop = Shop::orderBy('id', 'DESC')
                ->where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->get();



            return view(
                'Admin.Order.orderCreatebackup',
                compact('today', 'track', 'company', 'hub', 'category', 'pickup', 'area', 'shop', 'weights', 'districts', 'zones')
            );
        } else if (Auth::user()->role == 1 || Auth::user()->role == 4 || Auth::user()->role == 8 || Auth::user()->role == 18) {
            // return "xvdnhfjg";
            $today = date('Y-m-d');
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }

            //rised
            $company = Company::first();
            $h = $company->company_initial;

            $id = Auth::user()->id;
            $s = $sl + 1;
            $dat = date('ymd');
            $track = $h . $id . $dat . $s;

            $weights = WeightPrice::all();

            $districts = District::orderBy('name', 'asc')->get();
            $hub = Zone::orderBy('name', 'DESc')->get();

            $zones = CoverageArea::orderBy('id', 'DESC')->get();

            $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
            $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
            $area = CoverageArea::orderBy('id', 'DESC')->get();
            $shop = [];


            // $shop = Shop::orderBy('id', 'DESC')
            //     ->where('user_id', 580)
            //     ->where('status', 1)
            //     ->get();

            $merchants = User::where('role', 12)->join('merchants', 'merchants.user_id', 'users.id')->select('merchants.*')->get();
            return view(
                'Admin.Order.adminOrderCreatebackup',
                compact('today', 'company', 'track', 'category', 'hub', 'pickup', 'area', 'shop', 'weights', 'merchants', 'districts', 'zones')
            );
        }
    }



    public function store(Request $request)
    {


        // $validated = $request->validate([
        //     'customer_name' => 'required',
        //     'category' => 'required',
        // ]);
        // return $request->all();

        // return $request->is_partial;

        if ($request->is_partial == 1) {
            $is_partial_value = 1;
        } else {
            $is_partial_value = 0;
        }

        if ($request->is_exchange == 1) {
            $is_exchange = 1;
        } else {
            $is_exchange = 0;
        }

        $validated = $request->validate([
            'tracking_id' => 'required|unique:orders,tracking_id',
        ]);

        $validator = Validator::make($request->all(), [
            'customer_phone' => 'required|digits:11',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


      
        // if (auth()->user()->role == 14) {
        //     $employee = Employee::where('user_id', Auth::user()->id)->first();

        //     $m_discount = $merchant = Merchant::where('user_id', $employee->merchant_id)->first();
        //     $user_id = $employee->merchant_id;
        // } else {
        $m_discount = $merchant = Merchant::where('user_id', Auth::user()->id)->first();

        $ar = CoverageArea::whereIn('zone_id', [$merchant->zone_id,10])->where('area', $request->area)->first();

        $user_id          = $m_discount->user_id;
        // }



        $data                   = new Order();
        $data->user_id          = $user_id;
        $data->tracking_id      = $request->tracking_id;
        $data->order_id         = $request->order_id;
        $data->customer_name    = $request->customer_name;
        $data->customer_email   = $request->customer_email;
        $data->customer_phone   = $request->input('customer_phone');
        $data->other_number     = $request->other_number;
        $data->customer_address = $request->customer_address;

        // if (auth()->user()->role == 14) {

        //     $shop_id = Employee::where('user_id', Auth::user()->id)->value('shop_id');

        //     $shop_name = Shop::where('id', $shop_id)
        //         ->first();

        //     $data->shop =  $shop_name->shop_name;
        //     $data->shop_id = $shop_name->id;
        // } else {
        //     $data->shop             = $request->shop;
        //     $data->shop_id             = Shop::where('shop_name', $request->shop)->first()->id;
        // }

        $data->area             = $request->area;
        $data->area_id          = CoverageArea::where('area', $request->area)->first()->id;
        $data->pickup_date      = $request->pickup_date;
        $data->pickup_time      = $request->pickup_time;
        $data->remarks          = $request->remarks;
        $data->category         = $request->product_type;
        $data->product          = $request->product;
        $data->weight           = $request->weight;
        $data->selling_price    = $request->selling_price ?? 0;
        $data->collection       = $request->collection;
        $data->inside           = $ar->inside;
        $data->city_track       = $ar->city_track;
        $data->hub_id           = $request->hub_id;
        $data->district         = $ar->district;
        $data->type             = $request->imp;
        $data->isPartial        = $is_partial_value;
        $data->is_exchange      = $is_exchange;
        $data->status           = 'Order Placed';
        $data->save();

        $sPrice = WeightPrice::where('title', $request->weight)->first();


        $imp = $request->imp;
        $collection = $request->collection;
        //Merchant 
        $m_discount = $merchant->m_discount;
        $ur_discount = $merchant->ur_discount;

        $outside_discount = $merchant->outside_dhaka_regular;
        $sub_discount = $merchant->sub_dhaka_regular;

        $express_outside_discount = $merchant->outside_dhaka_express;
        $express_sub_discount = $merchant->sub_dhaka_express;

        $return_inside_discount = $merchant->return_inside_dhaka_discount;
        $return_outside_discount = $merchant->return_outside_dhaka_discount;
        $return_sub_discount = $merchant->return_sub_dhaka_discount;


        /* city calculation */

        $inside_city_regular_discount = $merchant->m_ind_city_Re;
        $outside_city_regular_discount = $merchant->m_out_city_Re;
        $subcity_city_regular_discount = $merchant->m_sub_city_Re;

        $inside_city_express_discount = $merchant->m_ind_city_Ur;
        $outside_city_express_discount = $merchant->m_out_City_Ur;
        $subcity_city_express_discount = $merchant->m_sub_city_Ur;


        // if ($ar->inside === 0) {
        //     //outside-Dhaka

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_Re  - $outside_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_Ur  - $express_outside_discount;
        //     }
        //     $return = $sPrice->out_ReC - $return_outside_discount;
        // } elseif ($ar->inside === 1) {
        //     //Inside Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_Re - $m_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_Ur - $ur_discount;
        //     }
        //     $return = $sPrice->ind_ReC - $return_inside_discount;
        // } else {
        //     //Sub Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->sub_Re - $sub_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_Ur - $express_sub_discount;
        //     }
        //     $return = $sPrice->sub_ReC - $return_sub_discount;
        // }

        // if (isset($ar->inside)) {
        //     switch ($ar->inside) {
        //         case 0: // Outside Dhaka
        //             if ($imp === 'Regular') {
        //                 $delivery = $sPrice->out_Re - $outside_discount;
        //             } elseif ($imp === 'Urgent') {
        //                 $delivery = $sPrice->out_Ur - $express_outside_discount;
        //             }
        //             $return = $sPrice->out_ReC - $return_outside_discount;
        //             break;
        
        //         case 1: // Inside Dhaka
        //             if ($imp === 'Regular') {
        //                 $delivery = $sPrice->ind_Re - $m_discount;
        //             } elseif ($imp === 'Urgent') {
        //                 $delivery = $sPrice->ind_Ur - $ur_discount;
        //             }
        //             $return = $sPrice->ind_ReC - $return_inside_discount;
        //             break;
        
        //         case 2: // Sub Dhaka
        //             if ($imp === 'Regular') {
        //                 $delivery = $sPrice->sub_Re - $sub_discount;
        //             } elseif ($imp === 'Urgent') {
        //                 $delivery = $sPrice->sub_Ur - $express_sub_discount;
        //             }
        //             $return = $sPrice->sub_ReC - $return_sub_discount;
        //             break;
        
        //         default:
        //             throw new Exception("Invalid area value: {$ar->inside}");
        //     }
        // } else {
        //     throw new Exception("Area value is not set.");
        // }
        



        

        // if ($ar->city_track === 5) {
        //     //outside-city

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_city_Re  - $outside_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_City_Ur  - $outside_city_express_discount;
        //     }
        // } elseif ($ar->city_track === 3) {
        //     //Inside city
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_city_Ur -  $inside_city_express_discount;
        //     }
        // } elseif ($ar->city_track === 4) {
        //     //Sub city
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
        //     }
        // }




        /*cod calculation*/
        // if ($ar->inside === 0) {
        //     //outside-dhaka
        //     $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
        //     $co = $sPrice->outside_dhaka_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->inside === 1) {
        //     //inside-dhaka
        //     $m_cod = (($collection) * $merchant->m_cod) / 100;
        //     $co = $sPrice->cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } else {
        //     //sub-dhaka
        //     $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
        //     $co = $sPrice->sub_dhaka_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }
        // if (isset($ar->inside)) {
        //     switch ($ar->inside) {
        //         case 0: // Outside Dhaka
        //             $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
        //             $co = $sPrice->outside_dhaka_cod;
        //             $cod = (($collection) * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
        
        //         case 1: // Inside Dhaka
        //             $m_cod = (($collection) * $merchant->m_cod) / 100;
        //             $co = $sPrice->cod;
        //             $cod = (($collection) * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
        
        //         case 2: // Sub Dhaka
        //             $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
        //             $co = $sPrice->sub_dhaka_cod;
        //             $cod = (($collection) * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
        
        //         default:
        //             throw new Exception("Invalid area value: {$ar->inside}");
        //     }
        // } else {
        //     throw new Exception("Area value is not set.");
        // }
        


        // /*cod city calculation*/
        // if ($ar->city_track === 5) {
        //     //outside-dhaka
        //     $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
        //     $co = $sPrice->outside_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 3) {
        //     //inside-dhaka
        //     $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
        //     $co = $sPrice->inside_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 4) {
        //     //sub-dhaka
        //     $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
        //     $co = $sPrice->sub_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }
        if (isset($ar->inside)) {
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->out_Re - $outside_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->out_Ur - $express_outside_discount;
                    }

                    $return = $sPrice->out_ReC - $return_outside_discount;
                    break;
        
                case 1: // Inside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->ind_Re - $m_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->ind_Ur - $ur_discount;
                    }

                    $return = $sPrice->ind_ReC - $return_inside_discount;
                    break;
        
                case 2: // Sub Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->sub_Re - $sub_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->sub_Ur - $express_sub_discount;
                    }
                    $return = $sPrice->sub_ReC - $return_sub_discount;
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            switch ($ar->city_track) {
                case 5: // Outside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->out_city_Re - $outside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->out_City_Ur - $outside_city_express_discount;
                    }
                    $return = $sPrice->out_ReC - $return_outside_discount;
                    break;
        
                case 3: // Inside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->ind_city_Ur - $inside_city_express_discount;
                    }
                    $return = $sPrice->ind_ReC - $return_inside_discount;
                    break;
        
                case 4: // Sub City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
                    }
                    $return = $sPrice->sub_ReC - $return_sub_discount;
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either area or city track value must be set.");
        }

        if (isset($ar->inside)) {
            // Process based on `inside` value
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
                    $co = $sPrice->outside_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 1: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_cod) / 100;
                    $co = $sPrice->cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 2: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
                    $co = $sPrice->sub_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            // Process based on `city_track` value
            switch ($ar->city_track) {
                case 5: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
                    $co = $sPrice->outside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 3: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
                    $co = $sPrice->inside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 4: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
                    $co = $sPrice->sub_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either 'inside' or 'city_track' value must be set.");
        }
        //cod
        // $m_cod = (($collection - $delivery) * $merchant->m_cod) / 100;
        $sub_dhaka_m_cod = (($collection - $delivery) * $merchant->m_sub_dhaka_cod) / 100;
        $outside_dhaka_m_cod = (($collection - $delivery) * $merchant->m_outside_dhaka_cod) / 100;

        $m_insurance =  (($collection - $delivery) * $merchant->m_insurance) / 100;

        // $co = $sPrice->cod;
        $sub_dhaka_co = $sPrice->sub_dhaka_cod;
        $outside_dhaka_co = $sPrice->outside_dhaka_cod;

        $ins = $sPrice->insurance;


        // $cod = (($collection - $delivery) * $co) / 100;
        $sub_dhaka_cod = (($collection - $delivery) * $sub_dhaka_co) / 100;
        $outside_dhaka_cod = (($collection - $delivery) * $outside_dhaka_co) / 100;

        $insurance = (($collection - $delivery) * $ins) / 100;
        //final
        //$fCod = $cod - $m_cod;
        $sub_dhaka_fCod = $sub_dhaka_cod - $sub_dhaka_m_cod;
        $outside_dhaka_fCod = $outside_dhaka_cod - $outside_dhaka_m_cod;


        //start again

        $fInsurance = $insurance - $m_insurance;

        $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));
        // $cod = ($collection * $co) / 100;
        // $insurance = ($collection * $ins) / 100;
        // //final
        // $fCod = $cod - $m_cod;
        // $fInsurance = $insurance - $m_insurance;
        // $m_pay = $collection - ($delivery + $fCod - +$fInsurance);
        if ($home = 1) {
            $h = 'Yes';
        } elseif ($home = 0) {
            $h = 'No';
        }
        $track      = $data->tracking_id;
        $order      = $data->order_id;
        // $shop       = $data->shop;
        $area       = $data->area;
        $c_name     = $data->customer_name;
        $c_email    = $data->customer_email;
        $c_phone    = $data->customer_phone;
        $address    = $data->customer_address;
        $p_date     = $data->pickup_date;
        $p_time     = $data->pickup_time;
        $product    = $data->product;
        $category   = $data->category;
        $weight     = $data->weight;
        $is_partial = $data->isPartial;
        $msg        = "Order Placed for Confirmation";

        Session::put('track',       $track);
        Session::put('order',       $order);
        // Session::put('shop',        $shop);
        Session::put('area',        $area);
        Session::put('c_name',      $c_name);
        Session::put('c_email',     $c_email);
        Session::put('c_phone',     $c_phone);
        Session::put('address',     $address);
        Session::put('home',        $h);
        Session::put('p_date',      $p_date);
        Session::put('p_time',      $p_time);
        Session::put('product',     $product);
        Session::put('category',    $category);
        Session::put('weight',      $weight);
        Session::put('collection',  $collection);
        Session::put('delivery',    $delivery);
        Session::put('co',          $co);
        Session::put('ins',         $ins);
        Session::put('cod',         ceil($fCod));
        Session::put('insurance',   ceil($fInsurance));
        Session::put('m_pay',       ceil($m_pay));
        Session::put('m_pay',       ceil($m_pay));
        Session::put('imp',         $imp);
        Session::put('is_partial',  $is_partial);


        // $request->session()->flash('message', $msg);
        $data               = new OrderStatusHistory();
        $data->tracking_id  = $track;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Order Placed';
        $data->save();

        $data               = new OrderConfirm();
        $data->tracking_id   = $track;
        $data->colection    = $collection;
        $data->delivery     = $delivery;
        $data->insurance    = $fInsurance;
        $data->cod          = $fCod;
        $data->return_charge = $return;
        $data->merchant_pay = $m_pay;
        $data->save();

        $msg        = "Order Placed Successfully";

        //Toast Message and reload
        // \Toastr::success('Successfully Order Created.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        // return redirect()->route('order.index');
        \Toastr::success('Successfully Order Created.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        return redirect()->back()->with('success', 'Successfully Order Created');

        if ($request->sumbit == 1) {
            return redirect()->back();
        } elseif ($request->preview == 2) {
            return redirect()->route('order.preview');
        }
    }

    public function charge_calculation(Request $request)
    {



        if ($request->merchant_id) {
            $m_discount = $merchant = Merchant::where('user_id', $request->merchant_id)->first();
        } else {
            $m_discount = $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        }

        $ar = CoverageArea::whereIn('zone_id', [$merchant->zone_id,10])->where('area', $request->area)->first();


       // return $ar;
        $user_id    = $m_discount->user_id;



        $sPrice = WeightPrice::where('title', $request->weight)->first();

        $imp = $request->imp;
        $collection = $request->collection;

        // return ['area' => $ar, 'weight' => $sPrice, 'imp' => $imp];


        $m_discount = $merchant->m_discount;
        $ur_discount = $merchant->ur_discount;

        $outside_discount = $merchant->outside_dhaka_regular;
        $sub_discount = $merchant->sub_dhaka_regular;

        $express_outside_discount = $merchant->outside_dhaka_express;
        $express_sub_discount = $merchant->sub_dhaka_express;


        /* city calculation */

        $inside_city_regular_discount = $merchant->m_ind_city_Re;
        $outside_city_regular_discount = $merchant->m_out_city_Re;
        $subcity_city_regular_discount = $merchant->m_sub_city_Re;

        $inside_city_express_discount = $merchant->m_ind_city_Ur;
        $outside_city_express_discount = $merchant->m_out_City_Ur;
        $subcity_city_express_discount = $merchant->m_sub_city_Ur;


        // $delivery = 0;
        // if ($ar->inside === 0) {
        //     //outside-Dhaka

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_Re  - $outside_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_Ur  - $express_outside_discount;
        //     }
        // } elseif ($ar->inside === 1) {
        //     //Inside Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_Re - $m_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_Ur - $ur_discount;
        //     }
        // } elseif ($ar->inside === 2) {
        //     //Sub Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->sub_Re - $sub_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_Ur - $express_sub_discount;
        //     }
        // }


        // if ($ar->city_track === 5) {
        //     //outside-city

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_city_Re  - $outside_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_City_Ur  - $outside_city_express_discount;
        //     }
        // } elseif ($ar->city_track === 3) {
        //     //Inside city
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_city_Ur -  $inside_city_express_discount;
        //     }
        // } elseif ($ar->city_track === 4) {
        //     //Sub city
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
        //     }
        // }



        /*cod calculation*/
        // if ($ar->inside === 0) {
        //     //outside-dhaka
        //     $m_cod = (($collection - $delivery) * $merchant->m_outside_dhaka_cod) / 100;
        //     $co = $sPrice->outside_dhaka_cod;
        //     $cod = (($collection - $delivery) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->inside === 1) {
        //     //inside-dhaka
        //     $m_cod = (($collection - $delivery) * $merchant->m_cod) / 100;
        //     $co = $sPrice->cod;
        //     $cod = (($collection - $delivery) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->inside === 2) {
        //     //sub-dhaka
        //     $m_cod = (($collection - $delivery) * $merchant->m_sub_dhaka_cod) / 100;
        //     $co = $sPrice->sub_dhaka_cod;
        //     $cod = (($collection - $delivery) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }



        if (isset($ar->inside)) {
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->out_Re - $outside_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->out_Ur - $express_outside_discount;
                    }
                    break;
        
                case 1: // Inside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->ind_Re - $m_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->ind_Ur - $ur_discount;
                    }
                    break;
        
                case 2: // Sub Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->sub_Re - $sub_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->sub_Ur - $express_sub_discount;
                    }
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            switch ($ar->city_track) {
                case 5: // Outside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->out_city_Re - $outside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->out_City_Ur - $outside_city_express_discount;
                    }
                    break;
        
                case 3: // Inside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->ind_city_Ur - $inside_city_express_discount;
                    }
                    break;
        
                case 4: // Sub City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
                    }
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either area or city track value must be set.");
        }
        

        // if ($ar->inside === 0) {
        //     //outside-dhaka
        //     $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
        //     $co = $sPrice->outside_dhaka_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->inside === 1) {
        //     //inside-dhaka
        //     $m_cod = (($collection) * $merchant->m_cod) / 100;
        //     $co = $sPrice->cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->inside === 2) {
        //     //sub-dhaka
        //     $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
        //     $co = $sPrice->sub_dhaka_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }


        // /*cod city calculation*/
        // if ($ar->city_track === 5) {
        //     //outside-dhaka
        //     $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
        //     $co = $sPrice->outside_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 3) {
        //     //inside-dhaka
        //     $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
        //     $co = $sPrice->inside_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 4) {
        //     //sub-dhaka
        //     $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
        //     $co = $sPrice->sub_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }

        if (isset($ar->inside)) {
            // Process based on `inside` value
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
                    $co = $sPrice->outside_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 1: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_cod) / 100;
                    $co = $sPrice->cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 2: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
                    $co = $sPrice->sub_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            // Process based on `city_track` value
            switch ($ar->city_track) {
                case 5: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
                    $co = $sPrice->outside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 3: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
                    $co = $sPrice->inside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 4: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
                    $co = $sPrice->sub_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either 'inside' or 'city_track' value must be set.");
        }
        




        //cod
        // $m_cod = (($collection - $delivery) * $merchant->m_cod) / 100;
        $sub_dhaka_m_cod = (($collection - $delivery) * $merchant->m_sub_dhaka_cod) / 100;
        $outside_dhaka_m_cod = (($collection - $delivery) * $merchant->m_outside_dhaka_cod) / 100;

        $m_insurance =  (($collection - $delivery) * $merchant->m_insurance) / 100;

        // $co = $sPrice->cod;
        $sub_dhaka_co = $sPrice->sub_dhaka_cod;
        $outside_dhaka_co = $sPrice->outside_dhaka_cod;

        $ins = $sPrice->insurance;




        $sub_dhaka_cod = (($collection - $delivery) * $sub_dhaka_co) / 100;
        $outside_dhaka_cod = (($collection - $delivery) * $outside_dhaka_co) / 100;

        $insurance = (($collection - $delivery) * $ins) / 100;

        $sub_dhaka_fCod = $sub_dhaka_cod - $sub_dhaka_m_cod;
        $outside_dhaka_fCod = $outside_dhaka_cod - $outside_dhaka_m_cod;


        // //start again

        $fInsurance = $insurance - $m_insurance;

        $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));



        return ['delivery_charge' => $delivery, 'cod' => $fCod, 'total_pay' => $m_pay];
    }
    public function charge_calculation_setup(Request $request)
    {
        $ar = CoverageArea::where('area', $request->area)->first();
        $sPrice = WeightPrice::where('title', $request->weight)->first();

        return [
            'area' => $ar,
            'weight' => $sPrice
        ];
    }
    public function adminStore(Request $request)
    {

        // return $request;
        // return $dat = date('ymm');


        $validator = Validator::make($request->all(), [
            'customer_phone' => 'required|digits:11',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($last = Order::all()->last()) {
            $sl = $last->id;
        } else {
            $sl = 0;
        }
        //rised
        $company = Company::first();
        $h = $company->company_initial;

        $id = Auth::user()->id;
        $s = $sl + 1;
        $dat = date('y');
        $rand_code = rand(11, 99);
        $track = $h . $id . $dat . $s . $rand_code;

        // zd

        // 5802
        // 2110
        // 725

        //return  $request->all();
       
        $m_discount = $merchant = Merchant::where('user_id', $request->user_id)->first();
        $ar = CoverageArea::whereIn('zone_id', [$merchant->zone_id,10])->where('area', $request->area)->first();
        $imp = $request->imp;

        $data                   = new Order();
        $data->user_id          = $request->user_id;
        $data->tracking_id      = $track;
        $data->order_id         = $request->order_id;
        $data->customer_name    = $request->customer_name;
        $data->customer_email   = $request->customer_email;
        $data->customer_phone   = $request->input('customer_phone');
        $data->customer_address = $request->customer_address;
        // $data->shop             = $request->shop;
        $data->area             = $request->area;
        // $data->shop_id          = Shop::where('shop_name', $request->shop)->first()->id;
        $data->area_id          = CoverageArea::where('area', $request->area)->first()->id;
        $data->pickup_date      = $request->pickup_date;
        $data->pickup_time      = $request->pickup_time;
        $data->remarks          = $request->remarks;
        $data->category         = $request->category;
        $data->product          = $request->product;
        $data->weight           = $request->weight;
        $data->selling_price    = $request->selling_price;
        $data->collection       = $request->collection;
        $data->inside           = $ar->inside;
        $data->city_track       = $ar->city_track;
        $data->hub_id           = $request->hub_id;
        $data->district         = $ar->district;
        $data->type             = $imp;
        $data->status           = 'Order Placed';
        $data->isPartial        = $request->is_partial == '1' ? 1 : 0;
        $data->is_exchange      = $request->is_exchange == '1' ? 1 : 0;
        $data->save();

        $sPrice = WeightPrice::where('title', $request->weight)->first();


        $collection = $request->collection;
        //Merchant 
        $m_discount = $merchant->m_discount;
        $ur_discount = $merchant->ur_discount;

        $outside_discount = $merchant->outside_dhaka_regular;
        $sub_discount = $merchant->sub_dhaka_regular;

        $express_outside_discount = $merchant->outside_dhaka_express;
        $express_sub_discount = $merchant->sub_dhaka_express;

        $return_inside_discount = $merchant->return_inside_dhaka_discount;
        $return_outside_discount = $merchant->return_outside_dhaka_discount;
        $return_sub_discount = $merchant->return_sub_dhaka_discount;

        /* city calculation */

        $inside_city_regular_discount = $merchant->m_ind_city_Re;
        $outside_city_regular_discount = $merchant->m_out_city_Re;
        $subcity_city_regular_discount = $merchant->m_sub_city_Re;

        $inside_city_express_discount = $merchant->m_ind_city_Ur;
        $outside_city_express_discount = $merchant->m_out_City_Ur;
        $subcity_city_express_discount = $merchant->m_sub_city_Ur;



        // if ($ar->inside === 0) {
        //     //outside-Dhaka

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_Re  - $outside_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_Ur  - $express_outside_discount;
        //     }
        //     $return = $sPrice->out_ReC - $return_outside_discount;
        // } elseif ($ar->inside === 1) {
        //     //Inside Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_Re - $m_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_Ur - $ur_discount;
        //     }
        //     $return = $sPrice->ind_ReC - $return_inside_discount;
        // } else {
        //     //Sub Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->sub_Re - $sub_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_Ur - $express_sub_discount;
        //     }
        //     $return = $sPrice->sub_ReC - $return_sub_discount;
        // }




        // if ($ar->city_track === 5) {
        //     //outside-city

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_city_Re  - $outside_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_City_Ur  - $outside_city_express_discount;
        //     }
        // } elseif ($ar->city_track === 3) {
        //     //Inside city
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_city_Ur -  $inside_city_express_discount;
        //     }
        // } elseif ($ar->city_track === 4) {
        //     //Sub city
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
        //     }
        // }





        // /*cod calculation*/
        // if ($ar->inside === 0) {
        //     //outside-dhaka
        //     $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
        //     $co = $sPrice->outside_dhaka_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->inside === 1) {
        //     //inside-dhaka
        //     $m_cod = (($collection) * $merchant->m_cod) / 100;
        //     $co = $sPrice->cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } else {
        //     //sub-dhaka
        //     $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
        //     $co = $sPrice->sub_dhaka_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }



        /*cod city calculation*/
        // if ($ar->city_track === 5) {
        //     //outside-dhaka
        //     $m_cod = (($collection - $delivery) * $merchant->m_outside_dhaka_cod) / 100;
        //     $co = $sPrice->outside_dhaka_cod;
        //     $cod = (($collection - $delivery) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 3) {
        //     //inside-dhaka
        //     $m_cod = (($collection - $delivery) * $merchant->m_cod) / 100;
        //     $co = $sPrice->cod;
        //     $cod = (($collection - $delivery) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 4) {
        //     //sub-dhaka
        //     $m_cod = (($collection - $delivery) * $merchant->m_sub_dhaka_cod) / 100;
        //     $co = $sPrice->sub_dhaka_cod;
        //     $cod = (($collection - $delivery) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }

        // if ($ar->city_track === 5) {
        //     //outside-dhaka
        //     $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
        //     $co = $sPrice->outside_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 3) {
        //     //inside-dhaka
        //     $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
        //     $co = $sPrice->inside_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // } elseif ($ar->city_track === 4) {
        //     //sub-dhaka
        //     $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
        //     $co = $sPrice->sub_city_cod;
        //     $cod = (($collection) * $co) / 100;
        //     $fCod = $cod - $m_cod;
        // }

        if (isset($ar->inside)) {
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->out_Re - $outside_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->out_Ur - $express_outside_discount;
                    }

                    $return = $sPrice->out_ReC - $return_outside_discount;
                    break;
        
                case 1: // Inside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->ind_Re - $m_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->ind_Ur - $ur_discount;
                    }

                    $return = $sPrice->ind_ReC - $return_inside_discount;
                    break;
        
                case 2: // Sub Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->sub_Re - $sub_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->sub_Ur - $express_sub_discount;
                    }
                    $return = $sPrice->sub_ReC - $return_sub_discount;
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            switch ($ar->city_track) {
                case 5: // Outside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->out_city_Re - $outside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->out_City_Ur - $outside_city_express_discount;
                    }
                    $return = $sPrice->out_ReC - $return_outside_discount;
                    break;
        
                case 3: // Inside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->ind_city_Ur - $inside_city_express_discount;
                    }
                    $return = $sPrice->ind_ReC - $return_inside_discount;
                    break;
        
                case 4: // Sub City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
                    }
                    $return = $sPrice->sub_ReC - $return_sub_discount;
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either area or city track value must be set.");
        }

        if (isset($ar->inside)) {
            // Process based on `inside` value
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
                    $co = $sPrice->outside_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 1: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_cod) / 100;
                    $co = $sPrice->cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 2: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
                    $co = $sPrice->sub_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            // Process based on `city_track` value
            switch ($ar->city_track) {
                case 5: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
                    $co = $sPrice->outside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 3: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
                    $co = $sPrice->inside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 4: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
                    $co = $sPrice->sub_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either 'inside' or 'city_track' value must be set.");
        }

        /*Insurance Calculation*/

        $m_insurance =  (($collection - $delivery) * $merchant->m_insurance) / 100;
        $ins = $sPrice->insurance;
        $insurance = (($collection - $delivery) * $ins) / 100;

        $fInsurance = $insurance - $m_insurance;

        $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));

        if ($home = 1) {
            $h = 'Yes';
        } elseif ($home = 0) {
            $h = 'No';
        }


        $data               = new OrderStatusHistory();
        $data->tracking_id  = $track;
        $data->user_id      = $request->user_id;
        $data->status       = 'Order Placed';
        $data->save();

        $data               = new OrderConfirm();
        $data->tracking_id   = $track;
        $data->colection    = $collection;
        $data->delivery     = $delivery;
        $data->insurance    = $fInsurance;
        $data->cod          = $fCod;
        $data->return_charge = $return;
        $data->merchant_pay = $m_pay;
        $data->save();

        $msg        = "Order Placed Successfully";

        //Toast Message and reload
        // return redirect()->route('order.index')->with('message', 'Successfully Order Created.', 'Success!!!');
        \Toastr::success('Successfully Order Created.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }

    public function preview(Request $request)
    {
        $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
        $area = CoverageArea::orderBy('id', 'DESC')->get();
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        //  $order = Order::orderBy('id', 'DESC')->first();

        $order = Order::orderBy('orders.id', 'DESC')
            //->where('orders.area', $agent->area)
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')

            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->first();




        return view('Admin.Order.orderPreview', compact('order', 'category', 'area', 'pickup'));
    }

    public function edit(Request $request)
    {

        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
        $area = CoverageArea::orderBy('id', 'DESC')->get();
        $weights = WeightPrice::orderBy('id', 'DESC')->get();
        $shop = Shop::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->get();
        $data = Order::where('tracking_id', $request->id)->get();
        return view('Admin.Order.orderEdit', compact('category', 'pickup', 'area', 'shop', 'data', 'weights'));
    }

    public function draft_edit(Request $request)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
        $area = CoverageArea::orderBy('id', 'DESC')->get();
        $weights = WeightPrice::orderBy('id', 'DESC')->get();
        $shop = Shop::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->get();
        $order = Order::where('tracking_id', $request->id)->get();
        return view('Admin.Order.draft_edit', compact('category', 'pickup', 'area', 'shop', 'order', 'weights'));
    }

    public function update(Request $request)
    {


        $user_id = Order::where('tracking_id', $request->tracking_id)->value('user_id');

        $are = CoverageArea::where('area', $request->area)->first();
        $m_discount = $merchant = Merchant::where('user_id', $user_id)->first();

        if ($request->is_partial == "on") {
            $is_partial = 1;
        } else {
            $is_partial = 0;
        }

        if ($request->is_exchange == "on") {
            $is_exchange = 1;
        } else {
            $is_exchange = 0;
        }


        // OrderConfirm::where('tracking_id', $request->tracking_id)
        //     ->update([
        //         'collect'          => $request->collect

        //     ]);




        Order::where('tracking_id', $request->tracking_id)
            ->update([
                'order_id'          => $request->order_id,
                'customer_name'     => $request->customer_name,
                'customer_email'    => $request->customer_email,
                'customer_phone'    => $request->customer_phone,
                'customer_address'  => $request->customer_address,
                // 'shop'              => $request->shop,
                'area'              => $request->area,
                // 'shop_id'              => Shop::where('shop_name', $request->shop)->first()->id,
                'area_id'              => CoverageArea::where('area', $request->area)->first()->id,
                'pickup_date'       => $request->pickup_date,
                'pickup_time'       => $request->pickup_time,
                'remarks'           => $request->remarks,
                'category'          => $request->category,
                'product'           => $request->product,
                'weight'            => $request->weight,
                'selling_price'     => $request->selling_price,
                'collection'        => $request->collection,
                'inside'            => $are->inside,

                'district'          => $are->district,
                'type'              => $request->imp,
                'isPartial'         => $is_partial,
                'is_exchange'       => $is_exchange,
                'security_code'     => $request->security_code,
                'return_code'       => $request->return_code

            ]);
        $ar = CoverageArea::where('area', $request->area)->first();
        $sPrice = WeightPrice::where('title', $request->weight)->first();


        $imp = $request->imp;
        $collection = $request->collection;
        //Merchant 
        $m_discount = $merchant->m_discount;
        $ur_discount = $merchant->ur_discount;

        $outside_discount = $merchant->outside_dhaka_regular;
        $sub_discount = $merchant->sub_dhaka_regular;

        $express_outside_discount = $merchant->outside_dhaka_express;
        $express_sub_discount = $merchant->sub_dhaka_express;

        $m_cod = ($collection * $merchant->m_cod) / 100;
        $m_insurance =  ($collection * $merchant->m_insurance) / 100;
        // $oneRe = $ar->oneRe;
        // $plusRe = $ar->plusRe;
        // $oneUr = $ar->oneUr;
        // $plusUr = $ar->plusUr;
        $co = $sPrice->cod;
        $ins = $sPrice->insurance;

        // $home = $ar->h_delivery;
        // $w = $request->weight;
        
        $return_inside_discount = $merchant->return_inside_dhaka_discount;
        $return_outside_discount = $merchant->return_outside_dhaka_discount;
        $return_sub_discount = $merchant->return_sub_dhaka_discount;

        /* city calculation */

        $inside_city_regular_discount = $merchant->m_ind_city_Re;
        $outside_city_regular_discount = $merchant->m_out_city_Re;
        $subcity_city_regular_discount = $merchant->m_sub_city_Re;

        $inside_city_express_discount = $merchant->m_ind_city_Ur;
        $outside_city_express_discount = $merchant->m_out_City_Ur;
        $subcity_city_express_discount = $merchant->m_sub_city_Ur;


        // if ($ar->inside === 0) {
        //     //outside-Dhaka

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_Re  - $outside_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_Ur  - $express_outside_discount;
        //     }
        // } elseif ($ar->inside === 1) {
        //     //Inside Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_Re - $m_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_Ur - $ur_discount;
        //     }
        // } else {
        //     //Sub Dhaka
        //     if ($imp == 'Regular') {


        //         $delivery = $sPrice->sub_Re - $sub_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_Ur - $express_sub_discount;
        //     }
        // }

        // if (isset($ar->inside)) {
        //     switch ($ar->inside) {
        //         case 0: // Outside Dhaka
        //             if ($imp === 'Regular') {
        //                 $delivery = $sPrice->out_Re - $outside_discount;
        //             } elseif ($imp === 'Urgent') {
        //                 $delivery = $sPrice->out_Ur - $express_outside_discount;
        //             }
                  
        //             break;
        
        //         case 1: // Inside Dhaka
        //             if ($imp === 'Regular') {
        //                 $delivery = $sPrice->ind_Re - $m_discount;
        //             } elseif ($imp === 'Urgent') {
        //                 $delivery = $sPrice->ind_Ur - $ur_discount;
        //             }
                
        //             break;
        
        //         case 2: // Sub Dhaka
        //             if ($imp === 'Regular') {
        //                 $delivery = $sPrice->sub_Re - $sub_discount;
        //             } elseif ($imp === 'Urgent') {
        //                 $delivery = $sPrice->sub_Ur - $express_sub_discount;
        //             }
                  
        //             break;
        
        //         default:
        //             throw new Exception("Invalid area value: {$ar->inside}");
        //     }
        // } else {
        //     throw new Exception("Area value is not set.");
        // }
        

        // $imp = $request->imp;
        // $collection = $request->collection;
        // $w = $request->weight;
        // $ar = CoverageArea::where('area', $request->area)->first();
        // $co =  ($collection * $ar->cod) / 100;
        // $ins =  ($collection * $ar->insurance) / 100;
        // $home = $ar->h_delivery;

        //dur 

        // if (isset($ar->inside)) {
        //     switch ($ar->inside) {
        //         case 0: // Outside Dhaka
        //             $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
        //             $co = $sPrice->outside_dhaka_cod;
        //             $cod = (($collection) * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
        
        //         case 1: // Inside Dhaka
        //             $m_cod = (($collection) * $merchant->m_cod) / 100;
        //             $co = $sPrice->cod;
        //             $cod = (($collection) * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
        
        //         case 2: // Sub Dhaka
        //             $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
        //             $co = $sPrice->sub_dhaka_cod;
        //             $cod = (($collection) * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
        
        //         default:
        //             throw new Exception("Invalid area value: {$ar->inside}");
        //     }
        // } else {
        //     throw new Exception("Area value is not set.");
        // }

        if (isset($ar->inside)) {
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->out_Re - $outside_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->out_Ur - $express_outside_discount;
                    }

                    $return = $sPrice->out_ReC - $return_outside_discount;
                    break;
        
                case 1: // Inside Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->ind_Re - $m_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->ind_Ur - $ur_discount;
                    }

                    $return = $sPrice->ind_ReC - $return_inside_discount;
                    break;
        
                case 2: // Sub Dhaka
                    if ($imp === 'Regular') {
                        $delivery = $sPrice->sub_Re - $sub_discount;
                    } elseif ($imp === 'Urgent') {
                        $delivery = $sPrice->sub_Ur - $express_sub_discount;
                    }
                    $return = $sPrice->sub_ReC - $return_sub_discount;
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            switch ($ar->city_track) {
                case 5: // Outside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->out_city_Re - $outside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->out_City_Ur - $outside_city_express_discount;
                    }
                    $return = $sPrice->out_ReC - $return_outside_discount;
                    break;
        
                case 3: // Inside City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->ind_city_Ur - $inside_city_express_discount;
                    }
                    $return = $sPrice->ind_ReC - $return_inside_discount;
                    break;
        
                case 4: // Sub City
                    if ($imp == 'Regular') {
                        $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
                    } elseif ($imp == 'Urgent') {
                        $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
                    }
                    $return = $sPrice->sub_ReC - $return_sub_discount;
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either area or city track value must be set.");
        }

        if (isset($ar->inside)) {
            // Process based on `inside` value
            switch ($ar->inside) {
                case 0: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
                    $co = $sPrice->outside_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 1: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_cod) / 100;
                    $co = $sPrice->cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 2: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
                    $co = $sPrice->sub_dhaka_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid area value: {$ar->inside}");
            }
        } elseif (isset($ar->city_track)) {
            // Process based on `city_track` value
            switch ($ar->city_track) {
                case 5: // Outside Dhaka
                    $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
                    $co = $sPrice->outside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 3: // Inside Dhaka
                    $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
                    $co = $sPrice->inside_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                case 4: // Sub Dhaka
                    $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
                    $co = $sPrice->sub_city_cod;
                    $cod = (($collection) * $co) / 100;
                    $fCod = $cod - $m_cod;
                    break;
        
                default:
                    throw new Exception("Invalid city track value: {$ar->city_track}");
            }
        } else {
            throw new Exception("Either 'inside' or 'city_track' value must be set.");
        }
        

        $m_cod = (($collection - $delivery) * $merchant->m_cod) / 100;
        $m_insurance =  (($collection - $delivery) * $merchant->m_insurance) / 100;

        $co = $sPrice->cod;
        $ins = $sPrice->insurance;


        $cod = (($collection - $delivery) * $co) / 100;
        $insurance = (($collection - $delivery) * $ins) / 100;
        //final
        // $fCod = $cod - $m_cod;
        $fInsurance = $insurance - $m_insurance;

        $m_pay = $collection - ($delivery + ceil($fCod) - +ceil($fInsurance));


        if ($home = 1) {
            $h = 'Yes';
        } elseif ($home = 0) {
            $h = 'No';
        }
        $track      = $request->tracking_id;
        $order      = $request->order_id;

        $shop       = $request->shop;
        $area       = $request->area;

        $c_name     = $request->customer_name;
        $c_email    = $request->customer_email;
        $c_phone    = $request->customer_phone;
        $address    = $request->customer_address;
        $remarks    = $request->remarks;
        $p_date     = $request->pickup_date;
        $p_time     = $request->pickup_time;
        $product    = $request->product;
        $category   = $request->category;
        $weight     = $request->weight;
        $is_partial  = $request->is_partial == 1 ? 1 : 0;
        $msg        = "Order updated Successfully!";

        OrderConfirm::where('tracking_id', $request->tracking_id)
            ->update([
                'collect'          => $request->collect,
                'delivery'         => $delivery,
                'insurance'        => $fInsurance,
                'cod'              => $fCod,
                'colection'        => $request->collection,
                'merchant_pay'     => $m_pay

            ]);



        Session::put('track',       $track);
        Session::put('order',       $order);
        Session::put('shop',        $shop);
        Session::put('area',        $area);
        Session::put('c_name',      $c_name);
        Session::put('c_email',     $c_email);
        Session::put('c_phone',     $c_phone);
        Session::put('address',     $address);
        Session::put('remarks',     $remarks);
        Session::put('home',        $h);
        Session::put('p_date',      $p_date);
        Session::put('p_time',      $p_time);
        Session::put('product',     $product);
        Session::put('category',    $category);
        Session::put('weight',      $weight);
        Session::put('collection',  $collection);
        Session::put('delivery',    $delivery);
        Session::put('co',          $cod);
        Session::put('ins',         $ins);
        Session::put('cod',         ceil($fCod));
        Session::put('insurance',   ceil($fInsurance));
        Session::put('m_pay',      ceil($m_pay));
        Session::put('imp',         $imp);
        Session::put('is_partial',  $is_partial);
        $request->session()->flash('message', $msg);

        //  return \Toastr::success('Order Updated Successfully!', 'Order Updated', ["positionClass" => "toast-top-center"]);

        //return redirect()->back();

        \Toastr::success('Order Updated Successfully!', 'Order Updated', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        $fromdate = $request->fromdate;
        $todate = $request->todate;

        return redirect()->route('order.list.order_list_new')->with(['fromdate' => $fromdate, 'todate' => $todate]);
    }

    public function confirm(Request $request)
    {

        // $validated = $request->validate([
        //     'tracking_id' => 'required|unique:orders,tracking_id'
        // ]);

        // OrderStatusHistory::create([
        //             'tracking_id'   => $request->tracking_id,
        //             'user_id'       => Auth::user()->id,
        //             'status'        => 'PickUp Request'
        //         ]);
        //risad
        if (auth()->user()->role == 14) {
            $employee = Employee::where('user_id', Auth::user()->id)->first();

            $merchant = Merchant::where('user_id', $employee->merchant_id)->first();
        } else {
            $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        }
        // $merchant =Merchant::where('user_id',Auth::user()->id)->first();
        $single_order = Order::where('tracking_id', $request->tracking_id)->join('coverage_areas', 'coverage_areas.area', 'orders.area')
            ->select('coverage_areas.*', 'orders.*')
            ->first();
        $prices = WeightPrice::where('title', $single_order->weight)->first();


        if ($prices) {
            if ($single_order->inside == 0) {
                //outSide Dhaka
                if ($prices->out_ReC != 0) {
                    $return_charge = $prices->out_ReC - $merchant->m_return_discount;
                } else {
                    $return_charge = 0;
                }
            } else if ($single_order->inside == 1) {
                //inside Dhaka
                if ($prices->ind_ReC != 0) {
                    $return_charge = $prices->ind_ReC - $merchant->m_return_discount;
                } else {
                    $return_charge = 0;
                }
            } else {
                //Sub-Dhaka
                if ($prices->sub_ReC != 0) {
                    $return_charge = $prices->sub_ReC - $merchant->m_return_discount;
                } else {
                    $return_charge = 0;
                }
            }
        } else {
            $return_charge = 0;
        }



        $data               = new OrderStatusHistory();
        $data->tracking_id  = $request->tracking_id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Order Placed';
        $data->save();

        $data               = new OrderConfirm();
        $data->tracking_id   = $request->tracking_id;
        $data->colection    = $request->collection;
        $data->delivery     = $request->delivery;
        $data->insurance    = $request->insurance;
        $data->cod          = $request->cod;
        $data->return_charge = $return_charge;
        $data->merchant_pay = $request->merchant_pay;
        $data->save();

        $order = Order::where('tracking_id', $request->tracking_id)->first();
        $order->status = 'Order Placed';
        $order->save();

        $request->session()->flush();
        Session::flash('message', 'Order Confirmed Successfully');
    }

    public function list(Request $request)
    {



        $user = User::where('id', Auth::user()->id)->first();


        $userId =  $user->id;

        $today = date('Y-m-d');
        $fromdate = $request->fromdate;

        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 7day'));
        }

        if ($user->role == 14) {
            // agent role



            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');


            $data = Order::orderBy('orders.id', 'DESC')
                //->where('orders.area', $agent->area)
                ->where('orders.user_id', $userId)
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->orWhere('merchants.area', $agent->area)
                ->orWhereIn('orders.area', $my_array)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
                ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->get();
        } else {



            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->where('orders.user_id', $userId)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
                //->select('orders.*', 'order_confirms.*')
                // ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->whereDate('orders.created_at', '>=', $fromdate)
                ->whereDate('orders.created_at', '<=', $todate)
                ->get();
            $zone_id = '';
        }

        return view('Admin.Order.merchant_orderList', compact('data', 'fromdate', 'todate', 'zone_id'));

        // return view('Admin.Order.orderList', compact('data', 'fromdate', 'todate', 'zone_id'));




    }

    public function return_list()
    {
        if (auth()->user()->role == 8) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;
            $area_l = CoverageArea::where('zone_name', $area)->select('area')->get();
            $my_array = $area_l->pluck('area');

            $data = Order::orderBy('orders.delivery_date', 'ASC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')

                ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('orders.area', $my_array)
                ->whereIn('orders.status', ['Rescheduled', 'Hold Order Received from Branch'])
                ->get();

            $delivery_category = Db::table('delivery_category')->where('category_name', 'Return')->get();

            return view('Admin.Order.return_orderList', compact('data', 'delivery_category'));
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;
            $area_l = CoverageArea::where('zone_name', $area)->select('area')->get();
            $my_array = $area_l->pluck('area');

            $data = Order::orderBy('orders.delivery_date', 'ASC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')

                ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('orders.area', $my_array)
                ->whereIn('orders.status', ['Rescheduled', 'Hold Order Received from Branch'])
                ->get();



            return view('Admin.Order.return_orderList', compact('data'));
        }
    }

    public function return_list2(Request $request)
    {

        // dd($request->all());


        $trackings = $request->tracking_ids;
        foreach ($trackings as $tracking) {

            $data = Order::where('tracking_id', $tracking)->first();
            $data->status = 'Received By Destination Hub';
            $data->save();

            $data = new OrderStatusHistory();
            $data->tracking_id  = $tracking;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Received By Destination Hub';
            $data->save();
        }
        return redirect()->back()->with('message', 'Order Move to delivery assign Successfully');
    }

    // public function draft(Request $request)
    // {
    //     $request->session()->flush();
    //     // $data = Order::orderBy('created_at', 'DESC')
    //     //         ->where('user_id', Auth::user()->id)
    //     //         ->leftJoin('order_confirms', function ($join) {
    //     //             $join->on('orders.tracking_id', 'order_confirms.tracking_id')
    //     //                 ->where('orders.tracking_id', '!=', 'order_confirms.tracking_id');
    //     //         })
    //     //         // ->join('order_confirms','orders.tracking_id','order_confirms.tracking_id')
    //     //         ->select('orders.*')
    //     //         ->get();
    // return view('Admin.Order.orderDraft', compact('data'));
    // }

    public function draft(Request $request)
    {
        $request->session()->flush();



        if (Auth::user()->role == 14) {
            $emp = Employee::where('user_id', Auth::user()->id)->first();
            $user_id = $emp->merchant_id;
        } else {
            $user_id = Auth::user()->id;
        }
        $data = Order::orderBy('orders.id', 'DESC')
            ->where('user_id', $user_id)
            ->where('status', '=', NULL)
            ->get();
        return view('Admin.Order.orderDraft', compact('data'));
    }

    public function return_to_delivery_assign(Request $request)
    {

        $data = Order::where('tracking_id', $request->id)->first();
        $data->status = 'Received By Destination Hub';
        $data->save();

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Received By Destination Hub';
        $data->save();


        return redirect()->back()->with('message', 'Order Move to delivery assign Successfully');
    }

    public function delivery_update(Request $request)
    {
        //return $request;
        if ($request->type == 'cancel') {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Return Confirm';
            $data->save();

            $order_data = Order::where('tracking_id', $request->tracking_id)->first();
            $order_data->status = 'Return Confirm';
            $order_data->reason_name = $request->return_reason_name;
            $order_data->save();



            $order_confirm = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
            $order_confirm->cod = 0;
            $order_confirm->insurance = 0;
            $order_confirm->save();
        } else {
            $data = Order::where('tracking_id', $request->tracking_id)->first();
            $data->delivery_note = $request->note;
            $data->delivery_date = $request->date;
            $data->save();
        }


        return redirect()->back()->with('message', 'Order Delivery Rescheduled Successfully');
    }

    public function weight_wise_charge(Request $request)
    {
        return 'hi';
    }

    public function delivery_category(Request $request)
    {
        $delivery_category =  DB::table('delivery_category')->get();

        return view('Admin.Expense.Delivery_category', compact('delivery_category'));
    }

    public function delivery_category_store(Request $request)
    {
        $currentDateTime = Carbon::now();
        DB::table('delivery_category')->insert([
            'category_name' => $request->reason_category,
            'comment' => $request->reason_name,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);
        return redirect()->back()->with('success', 'Reason category created successfully');
    }

    public function reason_category_destroy(Request $request)
    {
        DB::table('delivery_category')->where('id', $request->id)->delete();
        return redirect()->back()->with('danger', 'Reason category destroy  successfully');
    }
}
