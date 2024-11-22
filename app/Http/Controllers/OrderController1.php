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
use App\Admin\District;
use App\Admin\Shop;
use App\Admin\Merchant;
use App\Admin\WeightPrice;
use App\Admin\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\User;
use Response;

class OrderController extends Controller
{
    public function index(Request $request)
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
            $agent = Agent::where('user_id', $user->id)->first();
            $zone_id = $agent->zone_id;
            $area_list = CoverageArea::where('zone_id', $zone_id)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');



            if ($request->fromdate || $request->todate) {
                $data = Order::orderBy('order_confirms.id', 'DESC')

                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)

                    ->get();
            } else {
                $data = Order::orderBy('order_confirms.id', 'DESC')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->get();
            }
        } else {
            // return $request;

            // if($request->fromdate){

            // }

            if ($request->fromdate || $request->todate) {
                $data = Order::orderBy('order_confirms.id', 'DESC')

                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)

                    ->get();
            } else {
                $data = Order::orderBy('order_confirms.id', 'DESC')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->get();
            }


            $zone_id = '';
        }


        return view('Admin.Order.orderList', compact('data', 'fromdate', 'todate', 'zone_id'));
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

        $area = CoverageArea::orderBy('id', 'DESC')->get();

        $order = Order::where('tracking_id', $request->id)->first();
        $weights = WeightPrice::orderBy('id', 'DESC')->get();

        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();


        $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();


        if (Auth::user()->role == 1) {
            return view('Admin.Order.confirm_edit', compact('area', 'order', 'weights', 'category', 'pickup'));
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

        // return $request->all();
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
            $dat = date('y');
            $track = $h . $id . $dat . $s;

            $weights = WeightPrice::all();

            $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
            $pickup = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
            // $districts = District::all();
            $area = CoverageArea::orderBy('id', 'DESC')->get();

            $districts = District::all();
            $zones = CoverageArea::orderBy('id', 'DESC')->get();


            $shop = Shop::orderBy('id', 'DESC')
                ->where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->get();

            return view(
                'Admin.Order.orderCreate',
                compact('today', 'track', 'category', 'pickup', 'area', 'shop', 'weights', 'districts', 'zones')
            );
        } else if (Auth::user()->role == 1 || Auth::user()->role == 4 || Auth::user()->role == 8) {
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

            $districts = District::all();
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




    public function store(Request $request)
    {



        //return $request->tracking_id;

        $validated = $request->validate([
            'customer_name' => 'required',
            'category' => 'required',
        ]);
        // return $request->all();

        // return $request->is_partial;

        if ($request->is_partial == 1) {
            $is_partial_value = 1;
        } else {
            $is_partial_value = 0;
        }

        $validated = $request->validate([
            'tracking_id' => 'required|unique:orders,tracking_id'
        ]);

        $ar = CoverageArea::where('area', $request->area)->first();
        // if (auth()->user()->role == 14) {
        //     $employee = Employee::where('user_id', Auth::user()->id)->first();

        //     $m_discount = $merchant = Merchant::where('user_id', $employee->merchant_id)->first();
        //     $user_id = $employee->merchant_id;
        // } else {
        $m_discount = $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        $user_id          = $m_discount->user_id;
        // }



        $data                   = new Order();
        $data->user_id          = $user_id;
        $data->tracking_id      = $request->tracking_id;
        $data->order_id         = $request->order_id;
        $data->customer_name    = $request->customer_name;
        $data->customer_email   = $request->customer_email;
        $data->customer_phone   = $request->customer_phone;
        $data->other_number   = $request->other_number;
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
        $data->category         = $request->category;
        $data->product          = $request->product;
        $data->weight           = $request->weight;
        $data->selling_price       = $request->selling_price ?? 0;
        $data->collection       = $request->collection;
        $data->inside           = $ar->inside;
        $data->district         = $ar->district;
        $data->type             = $request->imp;
        $data->isPartial        = $is_partial_value;
        $data->status       = 'Order Placed';
        $data->save();

        $sPrice = WeightPrice::where('title', $request->weight)->first();


        $imp = $request->imp;
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

        if ($request->sumbit == 1) {
            return redirect()->back();
        } elseif ($request->preview == 2) {
            return redirect()->route('order.preview');
        }
    }

    public function adminStore(Request $request)
    {
        // return $dat = date('ymm');

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
        $ar = CoverageArea::where('area', $request->area)->first();
        $m_discount = $merchant = Merchant::where('user_id', $request->user_id)->first();
        $imp = $request->imp;

        $data                   = new Order();
        $data->user_id          = $request->user_id;
        $data->tracking_id      = $track;
        $data->order_id         = $request->order_id;
        $data->customer_name    = $request->customer_name;
        $data->customer_email   = $request->customer_email;
        $data->customer_phone   = $request->customer_phone;
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
        $data->collection       = $request->collection;
        $data->inside           = $ar->inside;
        $data->district         = $ar->district;
        $data->type             = $imp;
        $data->status           = 'Order Placed';
        $data->isPartial        = $request->is_partial ?? 0;
        $data->save();

        $sPrice = WeightPrice::where('title', $request->weight)->first();


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


        $are = CoverageArea::where('area', $request->area)->first();
        $m_discount = $merchant = Merchant::where('user_id', Auth::user()->id)->first();


        Order::where('tracking_id', $request->tracking_id)
            ->update([
                'order_id'          => $request->order_id,
                'customer_name'     => $request->customer_name,
                'customer_email'    => $request->customer_email,
                'customer_phone'    => $request->customer_phone,
                'customer_address'  => $request->customer_address,
                'shop'              => $request->shop,
                'area'              => $request->area,
                'shop_id'              => Shop::where('shop_name', $request->shop)->first()->id,
                'area_id'              => CoverageArea::where('area', $request->area)->first()->id,
                'pickup_date'       => $request->pickup_date,
                'pickup_time'       => $request->pickup_time,
                'remarks'           => $request->remarks,
                'category'          => $request->category,
                'product'           => $request->product,
                'weight'            => $request->weight,
                'collection'        => $request->collection,
                'inside'            => $are->inside,
                'district'          => $are->district,
                'type'              => $request->imp,
                'isPartial'         => $request->is_partial

            ]);
        $ar = CoverageArea::where('area', $request->area)->first();
        $sPrice = WeightPrice::where('title', $request->weight)->first();


        $imp = $request->imp;
        $collection = $request->collection;
        //Merchant 
        $m_discount = $merchant->m_discount;
        $ur_discount = $merchant->ur_discount;
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



        if ($ar->inside === 0) {
            //outside-Dhaka

            if ($imp == 'Regular') {
                $delivery = $sPrice->out_Re  - $m_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->out_Ur  - $ur_discount;
            }
        } elseif ($ar->inside === 1) {
            //Inside Dhaka
            if ($imp == 'Regular') {
                $delivery = $sPrice->ind_Re - $m_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->ind_Ur - $ur_discount;
            }
        } else {
            //Sub Dhaka
            if ($imp == 'Regular') {


                $delivery = $sPrice->sub_Re - $m_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->sub_Ur - $ur_discount;
            }
        }

        // $imp = $request->imp;
        // $collection = $request->collection;
        // $w = $request->weight;
        // $ar = CoverageArea::where('area', $request->area)->first();
        // $co =  ($collection * $ar->cod) / 100;
        // $ins =  ($collection * $ar->insurance) / 100;
        // $home = $ar->h_delivery;

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
        $msg        = "Order Placed for Confirmation";


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
        return \Toastr::success('Messages in here', 'Title', ["positionClass" => "toast-top-center"]);
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

        return view('Admin.Order.orderList', compact('data', 'fromdate', 'todate', 'zone_id'));

        // return view('Admin.Order.orderList', compact('data', 'fromdate', 'todate', 'zone_id'));




    }

    public function return_list()
    {

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

        return view('Admin.Order.return_orderList', compact('data'));
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
}
