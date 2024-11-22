<?php

namespace App\Http\Controllers\API;

use App\Admin\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\BusinessType;
use App\Admin\Category;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\Merchant;
use App\Admin\MerchantPayment;
use App\Admin\MerchantPaymentAdjustment;
use App\Admin\MerchantPaymentDetail;
use App\Admin\MerchantPaymentInfo;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderProduct;
use App\Admin\OrderStatusHistory;
use App\Admin\PickUpTime;
use App\Admin\Product;
use App\Admin\ReturnAssign;
use App\Admin\ReturnAssignDetail;
use App\Admin\RiderPayment;
use App\Admin\RiderPaymentDetail;
use App\Admin\Shop;
use App\Admin\Transfer;
use App\Admin\TransferDetail;
use App\Admin\WeightPrice;
use App\Admin\AutoAssign;
use App\Admin\MPayment;
use App\Admin\Partial;
use App\Admin\PaymentInfo;
use App\Admin\PickUpRequestAssign;
use App\Admin\Slider;
use App\Helper\Helpers\Helpers;
use App\PaymentRequest;
use App\PickUpRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class OrderinforController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    public function business_type_list(Request $request)
    {
        $data = BusinessType::orderBy('id', 'DESC')->get();
        return response()->json([
            'Business_type_list' => $data,
        ]);
    }
    public function orderstore(Request $request)
    {

        if ($last = Order::all()->last()) {
            $sl = $last->id;
        } else {
            $sl = 0;
        }
        //assign
        $company = Company::first();
        $h = $company->company_initial;

        $id = Auth::user()->id;
        $s = $sl + 1;

        $track = $h . $id . $s;
        //return  $request->all();
        $ar = CoverageArea::where('zone_id', $request->hub_id)->where('area', $request->area)->first();
        $m_discount = $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        $imp = $request->imp;

        $data                   = new Order();
        $data->user_id          = Auth::user()->id;
        $data->tracking_id      = $track;
        $data->customer_name    = $request->customer_name;
        $data->customer_email   = $request->customer_email;
        $data->customer_phone   = $request->customer_phone;
        $data->customer_address = $request->customer_address;
        // $data->shop             = $request->shop;
        $data->area             = $request->area;
        // $data->shop_id          = Shop::where('shop_name',$request->shop)->first()->id;
        $data->area_id          = CoverageArea::where('area', $request->area)->first()->id;
        $data->pickup_date      = $request->pickup_date;
        $data->pickup_time      = $request->pickup_time;
        $data->remarks          = $request->remarks;
        $data->category         = $request->category;
        $data->selling_price    = $request->selling_price;
        $data->order_id         = $request->order_id;
        $data->weight           = $request->weight;
        $data->collection       = $request->collection;
        $data->inside           = $ar->inside;
        $data->city_track       = $ar->city_track;
        $data->hub_id           = $request->hub_id;
        $data->district         = $ar->district;
        $data->type             = $imp;
        $data->status           = 'Order Placed';
        $data->isPartial        = $request->isPartial ?? 0;
        $data->save();

        // return   $sPrice = WeightPrice::all();

        $sPrice = WeightPrice::where('title', $request->weight)->first();


        $collection = $request->collection;
        //Merchant 
        // $m_discount = $merchant->m_discount;
        // $ur_discount = $merchant->ur_discount;


        // if ($ar->inside === 0) {
        //     //outside-Dhaka

        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->out_Re  - $m_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->out_Ur  - $ur_discount;
        //     }
        //     $return = $sPrice->out_ReC;
        // } elseif ($ar->inside === 1) {
        //     //Inside Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->ind_Re - $m_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->ind_Ur - $ur_discount;
        //     }
        //     $return = $sPrice->ind_ReC;
        // } else {
        //     //Sub Dhaka
        //     if ($imp == 'Regular') {
        //         $delivery = $sPrice->sub_Re - $m_discount;
        //     } elseif ($imp == 'Urgent') {

        //         $delivery = $sPrice->sub_Ur - $ur_discount;
        //     }
        //     $return = $sPrice->sub_ReC;
        // }


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



        if ($ar->inside === 0) {
            //outside-Dhaka

            if ($imp == 'Regular') {
                $delivery = $sPrice->out_Re  - $outside_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->out_Ur  - $express_outside_discount;
            }
            $return = $sPrice->out_ReC - $return_outside_discount;
        } elseif ($ar->inside === 1) {
            //Inside Dhaka
            if ($imp == 'Regular') {
                $delivery = $sPrice->ind_Re - $m_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->ind_Ur - $ur_discount;
            }
            $return = $sPrice->ind_ReC - $return_inside_discount;
        } else {
            //Sub Dhaka
            if ($imp == 'Regular') {
                $delivery = $sPrice->sub_Re - $sub_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->sub_Ur - $express_sub_discount;
            }
            $return = $sPrice->sub_ReC - $return_sub_discount;
        }




        if ($ar->city_track === 5) {
            //outside-city

            if ($imp == 'Regular') {
                $delivery = $sPrice->out_city_Re  - $outside_city_regular_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->out_City_Ur  - $outside_city_express_discount;
            }
        } elseif ($ar->city_track === 3) {
            //Inside city
            if ($imp == 'Regular') {
                $delivery = $sPrice->ind_city_Re - $inside_city_regular_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->ind_city_Ur -  $inside_city_express_discount;
            }
        } elseif ($ar->city_track === 4) {
            //Sub city
            if ($imp == 'Regular') {
                $delivery = $sPrice->sub_city_Re - $subcity_city_regular_discount;
            } elseif ($imp == 'Urgent') {

                $delivery = $sPrice->sub_city_Ur - $subcity_city_express_discount;
            }
        }





        /*cod calculation*/
        if ($ar->inside === 0) {
            //outside-dhaka
            $m_cod = (($collection) * $merchant->m_outside_dhaka_cod) / 100;
            $co = $sPrice->outside_dhaka_cod;
            $cod = (($collection) * $co) / 100;
            $fCod = $cod - $m_cod;
        } elseif ($ar->inside === 1) {
            //inside-dhaka
            $m_cod = (($collection) * $merchant->m_cod) / 100;
            $co = $sPrice->cod;
            $cod = (($collection) * $co) / 100;
            $fCod = $cod - $m_cod;
        } else {
            //sub-dhaka
            $m_cod = (($collection) * $merchant->m_sub_dhaka_cod) / 100;
            $co = $sPrice->sub_dhaka_cod;
            $cod = (($collection) * $co) / 100;
            $fCod = $cod - $m_cod;
        }



        if ($ar->city_track === 5) {
            //outside-dhaka
            $m_cod = (($collection) * $merchant->m_outside_city_cod) / 100;
            $co = $sPrice->outside_city_cod;
            $cod = (($collection) * $co) / 100;
            $fCod = $cod - $m_cod;
        } elseif ($ar->city_track === 3) {
            //inside-dhaka
            $m_cod = (($collection) * $merchant->m_inside_city_cod) / 100;
            $co = $sPrice->inside_city_cod;
            $cod = (($collection) * $co) / 100;
            $fCod = $cod - $m_cod;
        } elseif ($ar->city_track === 4) {
            //sub-dhaka
            $m_cod = (($collection) * $merchant->m_sub_city_cod) / 100;
            $co = $sPrice->sub_city_cod;
            $cod = (($collection) * $co) / 100;
            $fCod = $cod - $m_cod;
        }


        //order create
        $m_cod = (($collection - $delivery) * $merchant->m_cod) / 100;
        $m_insurance =  (($collection - $delivery) * $merchant->m_insurance) / 100;

        $co = $sPrice->cod;
        $ins = $sPrice->insurance;


        $cod = (($collection - $delivery) * $co) / 100;
        $insurance = (($collection - $delivery) * $ins) / 100;
        //final
        //  $fCod = $cod - $m_cod;
        $fInsurance = $insurance - $m_insurance;

        $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));
        if ($home = 1) {
            $h = 'Yes';
        } elseif ($home = 0) {
            $h = 'No';
        }
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




        return response()->json(array(
            'status' => true,
            'message' => 'Order Create Successfully',
            'data' => $data,

        ));
    }

    public function confirmorder(Request $request)
    {

        $data               = new OrderConfirm();
        $data->tracking_id   = $request->tracking_id;
        $data->colection    = $request->colection;
        $data->delivery     = $request->delivery;
        $data->insurance    = $request->insurance;
        $data->cod          = $request->cod;
        $data->merchant_pay = $request->merchant_pay;
        $data->save();
        return response()->json($data);
    }
    public function showorder(Request $request)
    {

        $today = date('Y-m-d');
        if ($last = Order::all()->last()) {
            $sl = $last->id;
        } else {
            $sl = 0;
        }
        $h = 'HD';
        // $id = Auth::user()->id;
        $s = $sl + 1;
        $dat = date('ymd');
        $track = $h .  $dat . $s;

        $category = Category::orderBy('id', 'DESC')->get();
        $pickup = PickUpTime::orderBy('id', 'DESC')->get();
        $area = CoverageArea::orderBy('id', 'DESC')->get();
        $weights = WeightPrice::orderBy('id', 'DESC')->get();

        // return response()->json(200);
        return response()->json(array(
            'track' => $track,
            'category' => $category,
            'pickup' => $pickup,
            'area' => $area,
            'weights' => $weights,
        ));
    }

    function preview()
    {

        //  $lest_id = Order::all()->last()->id;
        $lest_id = Order::latest()->first();
        $ar = CoverageArea::where('area', $lest_id->area)->first();

        $imp = $lest_id->type;
        $collection = $lest_id->collection;
        $oneRe = $ar->oneRe;
        $oneUr = $ar->oneUr;
        $plusRe = $ar->plusRe;
        $plusUr = $ar->plusUr;
        $co = $ar->cod;
        $ins = $ar->insurance;
        $home = $ar->h_delivery;
        $w = $lest_id->weight;
        $delivery = '0';
        if ($imp == 'Regular') {
            if ($w == 1) {
                $delivery = $oneRe * 1;
            } elseif ($w > 1) {
                $t = 1;
                $tw = ($w - $t);
                $delivery = $oneRe + ($plusRe * $tw);
            }
        } elseif ($imp == 'Urgent') {
            if ($w == 1) {
                $delivery = $oneUr * 1;
            } elseif ($w > 1) {
                $t = 1;
                $tw = ($w - $t);
                $delivery = $oneUr + ($plusUr * $tw);
            }
        }
        $cod = ($collection * $co) / 100;
        $insurance = ($collection * $ins) / 100;
        $m_pay = $collection - ($delivery + $cod + $insurance);

        if ($home = 1) {
            $h = 'Yes';
        } elseif ($home = 0) {
            $h = 'No';
        }

        // return response()->json($ar);
        return response()->json(array(
            'lest_id' => $lest_id,
            'ar' => $ar,
            'oneRe' => $oneRe,
            'oneUr' => $oneUr,
            'plusUr' => $plusUr,
            'plusUr' => $plusUr,
            'imp' => $imp,
            'delivery' => $delivery,
            'cod' => $cod,
            'h' => $h,
            'insurance' => $insurance,
            'm_pay' => $m_pay,
        ));
    }


    public function statuswise(Request $request)
    {
        $today = date('Y-m-d');
        $status = $request->status;
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }


        $data = Order::orderBy('orders.id', 'DESC')
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->where('orders.status', $status)
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();

        return response()->json(array(
            'data' => $data,
            'today' => $today,
            'status' => $status,
            'fromdate' => $fromdate,
        ));
    }
    public function confirmorder_datewise(Request $request)
    {
        // return "Asif";
        $today = date('Y-m-d');
        if ($request->todate || $request->fromdate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $todate = $today;
            $fromdate = $today;
        }
        $status = $request->status;

        if ($status) {
            //    return $data = 
            //     OrderStatusHistory::orderBy('orders.id', 'DESC')
            //     ->join('orders','orders.tracking_id','order_status_histories.tracking_id')
            //     -> whereDate('orders.created_at', '>=', $fromdate)
            //     ->whereDate('orders.created_at', '<=', $todate)
            //    // ->where('orders.user_id', Auth::user()->id)
            //     ->where('orders.status', $status)
            //     ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->leftJoin('merchants', 'orders.user_id', 'merchants.user_id')
            //     ->leftJoin('users', 'users.id', 'merchants.user_id')
            //     ->select('merchants.*','users.*','orders.*','order_confirms.*')
            //     ->get();

            if ($status == 'Payment Completed') {
                $data = Order::orderBy('orders.id', 'DESC')
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->leftJoin('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                    ->where('orders.status', $status)
                    ->where('orders.user_id', Auth::user()->id)
                    ->get()->unique('tracking_id');
            } else if ($status == 'PickUp Cancel') {

                $data = Order::orderBy('orders.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('orders.created_at', '>=', $fromdate)
                    ->whereDate('orders.created_at', '<=', $todate)
                    //  ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                    ->where('orders.status', $status)
                    ->where('orders.user_id', Auth::user()->id)
                    ->get()->unique('tracking_id');
            } else  if ($status == 'Pickup Done') {
                $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                    ->whereDate('order_status_histories.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                    ->where('orders.status', $status)
                    ->where('orders.user_id', Auth::user()->id)
                    ->get()->unique('tracking_id');
            } else  if ($status == 'Successfully Delivered') {
                $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                    ->whereDate('order_status_histories.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                    ->where('orders.status', $status)
                    ->where('orders.user_id', Auth::user()->id)
                    ->get()->unique('tracking_id');
            } else  if ($status == 'Partially Delivered') {
                $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                    ->whereDate('order_status_histories.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('shops', 'orders.shop', 'shops.shop_name')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                    ->where('orders.status', $status)
                    ->where('orders.user_id', Auth::user()->id)
                    ->get()->unique('tracking_id');
            } else  if ($status == 'Payment Processing') {
                $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                    ->whereDate('order_status_histories.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')

                    ->where('orders.user_id', Auth::user()->id)
                    ->whereIn('orders.status', ['Payment Processing', 'Payment Processing Complete'])
                    ->get()->unique('tracking_id');
            } else  if ($status == 'Return Confirm') {
                $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                    ->whereDate('order_status_histories.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')

                    ->where('orders.user_id', Auth::user()->id)
                    ->where('orders.status', 'Return Reach To Merchant')

                    ->get()->unique('tracking_id');
            } else if ($status == 'Order Placed') {
                //   return  Auth::user()->id;
                $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                    ->whereDate('order_status_histories.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                    ->where('order_status_histories.status', $status)
                    ->where('orders.user_id', Auth::user()->id)
                    ->get()->unique('tracking_id');
            } else {
                $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
                    // ->whereBetween('orders.created_at', [$fromdate, $todate])
                    ->whereDate('order_status_histories.created_at', '>=', $fromdate)
                    ->whereDate('order_status_histories.created_at', '<=', $todate)
                    ->join('orders', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->leftJoin('users', 'users.id', 'merchants.user_id')
                    ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                    ->where('orders.status', $status)
                    ->where('orders.user_id', Auth::user()->id)
                    ->get()->unique('tracking_id');
            }
        } else {
            $data = Order::orderBy('orders.id', 'DESC')
                //  ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->whereDate('orders.created_at', '>=', $fromdate)
                ->whereDate('orders.created_at', '<=', $todate)
                ->where('orders.user_id', Auth::user()->id)
                ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->leftJoin('merchants', 'orders.user_id', 'merchants.user_id')
                ->leftJoin('users', 'users.id', 'merchants.user_id')
                ->select('merchants.*', 'users.*', 'orders.*', 'order_confirms.*')
                ->get();
        }





        return response()->json(array(
            'data' => $data,
            'today' => $today,
            'fromdate' => $fromdate,
            'status' => $status
        ));
    }
    public function return_history_datewise(Request $request)
    {

        // return auth()->user()->id;
        // return $request->all();
        // return "dgfkj";

        // return $request;

        // $today = date('Y-m-d');
        // $fromdate = $request->fromdate;
        // if ($request->todate) {
        //     $todate = $request->todate;
        // } else {
        //     $todate = $today;
        //     $fromdate = date('Y-m-d', strtotime('now - 2day'));
        // }

        // $fromdate = $request->fromdate;
        // $todate = $request->todate;
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } elseif ($fromdate) {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 2day'));
        }


        if (Gate::allows('superAdmin')) {
            // return "aaaa";
            $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                // ->where('return_assigns.rider_id', Auth::user()->id)
                // ->where('return_assigns.status', 'Assigned Rider For Return')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } else if (Gate::allows('activeManager')) {

            return  $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                // ->where('return_assigns.rider_id', Auth::user()->id)
                ->where('return_assigns.status', 'Assigned Rider For Return')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } elseif (Gate::allows('activeRider')) {

            $payments_data = ReturnAssign::latest('return_assigns.id')
                ->with('creator', 'rider', 'updator', 'merchant')
                ->where('return_assigns.rider_id', Auth::user()->id)
                // ->where('return_assigns.status', 'Assigned Rider For Return')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } elseif (Gate::allows('activeMerchant')) {
            // return $todate = $request->todate;
            $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                ->where('user_id', Auth::user()->id)
                ->where('return_assigns.status', 'Return Reach To Merchant')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            // return  $payments_data = ReturnAssign::whereDate('created_at', '>=', $fromdate)
            //     ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        } else if (Gate::allows('activeAgent')) {
            $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
                // ->where('return_assigns.create_by', Auth::user()->id)
                // ->where('return_assigns.status', 'Return Reach To Merchant')
                ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
                ->join('users', 'users.id', 'return_assigns.merchant_id')
                ->select('merchants.*', 'users.*', 'return_assigns.*')
                ->whereDate('return_assigns.created_at', '>=', $fromdate)
                ->whereDate('return_assigns.created_at', '<=', $todate)
                ->get();
            //  return  $payments_data = ReturnAssign::->with('create', 'rider', 'updateUser')->get();
            $payments = [];
            foreach ($payments_data as $payment) {

                $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

                $array = $invoice_payment_details->map(function ($item) {
                    return collect($item)->values();
                });

                $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

                $payments[] = $payment;
            }
        }


        return response()->json(array(
            'data' => $payments,
            'today' => $todate,
            'fromdate' => $fromdate,
        ));
    }

    public function return_history_details(Request $request)
    {




        //return 


        // $payments_data = ReturnAssignDetail::where('invoice_id',$invid)->
        // $payments_data = ReturnAssignDetail::where('invoice_id', $invid);
        // ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
        // ->join('shops', 'shops.shop_name', 'return_assigns.shop')
        // ->select('merchants.*', 'return_assigns.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.pickup_address as shop_address')

        $payments_data = ReturnAssignDetail::orderBy('return_assign_details.id', 'DESC')
            ->join('orders', 'return_assign_details.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('return_assign_details.*', 'orders.*', 'users.*', 'merchants.*', 'order_confirms.*',)
            ->where('return_assign_details.invoice_id',  $request->invoice_id)
            ->get();


        return response()->json(array(
            'data' =>  $payments_data,

        ));
    }



    public function asifmanq(Request $request)
    {
        return $request->all();
    }


    public function rider_Collect_report(Request $request)
    {
        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {

            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }
        if (Auth::user()->role == 10) {
            $payments_data = RiderPayment::where('rider_id', Auth::user()->id)
                ->whereDate('created_at', '>=', $fromdate)->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        } else if (Auth::user()->role == 8) {
            $payments_data = RiderPayment::where('created_by', Auth::user()->id)
                ->whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        } else {
            $payments_data = RiderPayment::whereDate('created_at', '>=', $fromdate)
                ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        }

        $payments = [];
        foreach ($payments_data as $payment) {

            $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();

            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });

            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');

            $payments[] = $payment;
        }
        //  C:\xampp\htdocs\Courierlab_Agent_Wise\resources\views\Admin\Report\Payment\agent_transaction_history.blade.php
        return response()->json(array(
            'data' => $payments,
            'today' => $todate,
            'fromdate' => $fromdate,

        ));
    }


    public function rider_return(Request $request)
    {
        $requestid = $request->tracking_id;

        $company = Company::where('id', 1)->first();
        $rand = rand(1111, 9999);

        $moblile = Order::where('tracking_id', $request->tracking_id)->with('user')->first();

        $merchantnumber = $moblile->user->mobile;

        $rider = OrderStatusHistory::where('status', 'Assigned To Delivery Rider')
            ->where('tracking_id', $request->tracking_id)
            ->with('assign')
            ->first();

        $user = User::where('id', Auth::user()->id)->first();



        $company = Company::where('id', 1)->first();
        // $text = "Dear Valued Merchant,\nYour return parcel was carried by {$rider->assign->name}-{$rider->assign->mobile} from {$company->name}. \nYour security code is {$rand}. \nThanks\n{$company->website} or Tel:{$company->mobile}.";


        $text = "Dear Valued Merchant,\nYour return parcel was carried by  . \nYour security code is {$rand}.";
        // $test = "dkjhgdfg";



        Helpers::sms_send($merchantnumber, $text);




        Order::where('tracking_id', $requestid)->update(['return_code' => $rand]);

        return response()->json(array(
            'text' => $text,
        ));
    }


    public function rider_return_confirm(Request $request)
    {
        // return $request;

        $order =  Order::where('tracking_id', $request->tracking_id)->first();

        if ($order->return_code == $request->security_code) {
            $moblile = Order::where('tracking_id', $request->tracking_id)->with('user')->first();

            $merchantnumber = $moblile->user->mobile;

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Cancel Order';
            $data->save();


            $rand = rand(1111, 9999);

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Cancel Order';
            $order->delivery_note = $request->note;
            $order->return_code = $rand;
            $order->save();
            // Helpers::sms_send($order->customer_phone, 'অর্ডার ক্যান্সেল করা হলো');

            $company = Company::where('id', 1)->first();

            $rider = OrderStatusHistory::where('status', 'Assigned To Delivery Rider')
                ->where('tracking_id', $request->tracking_id)
                ->with('assign')
                ->first();

            $user = User::where('id', Auth::user()->id)->first();


            $text = "Dear Valued Merchant,\n'Your return parcel id is ";



            $company = Company::where('id', 1)->first();
            $text = "Dear Valued Merchant,\nYour return parcel was carried by ";

            return response()->json(array(
                'text' => $text,
            ));
            // } else {
            //     return response()->json([]);
        }
    }





    public function merchant_Collect_report(Request $request)
    {
        // return "dfgfdg";

        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {

            $fromdate = date('Y-m-d', strtotime('now - 4day'));
            $todate = date('Y-m-d');
        }

        $payments = MerchantPayment::where('m_user_id', Auth::user()->id)->
            // whereDate('updated_at', '>=', $fromdate)
            // ->whereDate('updated_at', '<=', $todate)->
            with('creator')->get();



        return response()->json(array(
            'data' => $payments,
            'today' => $todate,
            'fromdate' => $fromdate,
        ));
    }


    public function merchant_payment_history_details_report(Request $request)
    {

        $merchantPayments = MerchantPaymentDetail::where('invoice_id', $request->invoice_id)

            ->join('orders', 'm_pay_details.tracking_id', '=', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id',  'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id',  'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as merchant')
            ->get();

        $merchantPayments = $merchantPayments->unique('tracking_id');

        $paymentInfo =  MerchantPaymentInfo::where('invoice_id', $request->invoice_id)->first();

        $adjInfo =  MerchantPaymentAdjustment::where('invoice_id', $request->invoice_id)->first();

        $tCollect = $merchantPayments->sum('collect');
        $tCod = $merchantPayments->sum('cod');
        $tInsurance = $merchantPayments->sum('insurance');
        $tDelivery = $merchantPayments->sum('delivery');
        $tReturnCharge = $merchantPayments->sum('return_charge');

        $tPayable = $tCollect - ($tCod + $tInsurance + $tDelivery + $tReturnCharge);


        $merchantPay =  MerchantPayment::where('invoice_id', $request->invoice_id)->first();






        return response()->json(array(

            'merchantPay' => $merchantPay,
            'adjInfo' => $adjInfo,
            'paymentInfo' => $paymentInfo,
            'orders' => $merchantPayments,
            'tCollect' => $tCollect,
            'tCod' => $tCod,
            'tInsurance' => $tInsurance,
            'tDelivery' => $tDelivery,
            'tReturnCharge' => $tReturnCharge,
            'tPayable' => $tPayable,
            'status' => true,
            'message' => 'Merchant Payment Details',

        ));
    }
    public function rider_return_merchant(Request $request)
    {

        if (!$request->invoice_id) {

            return response()->json([
                'status' => false,
                'msg' => 'Something went to wrong .try again!'
            ], 404);
        } else if (!$request->security_code) {
            return response()->json([
                'status' => false,
                'msg' => 'Enter 4 digits security code.'
            ], 404);
        } else if (strlen($request->security_code) != 4) {

            return response()->json([
                'status' => false,
                'msg' => 'Needs 4 digits security code.'
            ], 404);
        }
        $returnAsign = ReturnAssign::where('invoice_id', $request->invoice_id)->first();

        //Call when return are null
        if (!$returnAsign) {

            return response()->json([
                'status' => false,
                'msg' => 'Something went to wrong .try again!'
            ], 404);
        }
        // return $returnAsign->security_code;

        if ($returnAsign->security_code == $request->security_code) {

            ReturnAssign::where('invoice_id', $request->invoice_id)
                ->update([
                    'status' => 'Return Reach To Merchant'
                ]);
            $returnDetails =     ReturnAssignDetail::where('invoice_id', $request->invoice_id)->get();

            foreach ($returnDetails as $returnDetail) {

                $data = new OrderStatusHistory();
                $data->tracking_id  = $returnDetail->tracking_id;
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Return Reach To Merchant';
                $data->save();



                Order::where('tracking_id', $returnDetail->tracking_id)
                    ->update([
                        'status' => 'Return Reach To Merchant'
                    ]);
            }
            return response()->json([
                'status' => true,
                'msg' => 'Return Products Reach to Merchant'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Security Code are not valid '
            ], 404);
        }
    }
    public function rider_return_details(Request $request)
    {
        //return $orderinv->invoice_id;



        $returnDetails =     ReturnAssignDetail::where('invoice_id', $request->invoice_id)
            ->join('orders', 'Orders.tracking_id', 'return_assign_details.tracking_id')
            ->join('order_confirms', 'Orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->get();



        return response()->json(

            [
                'status' => false,
                'orders' => $returnDetails,
                'msg' => 'Return Delivery Details List'
            ],
            200
        );
    }
    public function rider_transfer_to(Request $request)
    {



        if ($request->invoice_id) {

            $trackingDetails = TransferDetail::where('invoice_id', $request->invoice_id)->get();
            $transfer = Transfer::where('invoice_id', $request->invoice_id)->first();


            if ($transfer->type == 'delivery') {
                # code...
                if ($transfer->sender_id == 1) {

                    foreach ($trackingDetails as $trackingdetail) {
                        TransferDetail::where('invoice_id', $trackingdetail->invoice_id)->update(['updated_by' => Auth::user()->id]);
                        Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Reach to Branch']);

                        $history = new OrderStatusHistory();
                        $history->tracking_id  = $trackingdetail->tracking_id;
                        $history->user_id      = Auth::user()->id;
                        $history->status       = 'Transfer Reach To Branch';
                        $history->save();
                    }
                } else {

                    foreach ($trackingDetails as $trackingdetail) {
                        TransferDetail::where('invoice_id', $trackingdetail->invoice_id)->update(['updated_by' => Auth::user()->id]);
                        Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Reach to Fullfilment']);

                        $history = new OrderStatusHistory();
                        $history->tracking_id  = $trackingdetail->tracking_id;
                        $history->user_id      = Auth::user()->id;
                        $history->status       = 'Transfer Reach To Fullfilment';
                        $history->save();
                    }
                }
            } else if ($transfer->type == 'return') {
                # code...
                if ($transfer->sender_id == 1) {

                    foreach ($trackingDetails as $trackingdetail) {
                        TransferDetail::where('invoice_id', $trackingdetail->invoice_id)->update(['updated_by' => Auth::user()->id]);
                        Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Return Reach For Branch']);

                        $history = new OrderStatusHistory();
                        $history->tracking_id  = $trackingdetail->tracking_id;
                        $history->user_id      = Auth::user()->id;
                        $history->status       = 'Transfer Reach To Branch';
                        $history->save();
                    }
                } else {

                    foreach ($trackingDetails as $trackingdetail) {
                        TransferDetail::where('invoice_id', $trackingdetail->invoice_id)->update(['updated_by' => Auth::user()->id]);
                        Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Return Reach For Fullfilment']);

                        $history = new OrderStatusHistory();
                        $history->tracking_id  = $trackingdetail->tracking_id;
                        $history->user_id      = Auth::user()->id;
                        $history->status       = 'Transfer Reach To Fullfilment';
                        $history->save();
                    }
                }
            }


            Transfer::where('invoice_id',  $transfer->invoice_id)->update(['status' => 1]);

            return response()->json([
                'status' => true,
                'msg' => 'Rider Transfer Completed'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something Went To Wrong'
            ], 404);
        }
    }
    public function rider_transfer_details(Request $request)
    {
        $trackingDetails = TransferDetail::where('transfer_details.invoice_id', $request->invoice_id)
            ->join('orders', 'transfer_details.tracking_id', 'orders.tracking_id')
            ->join('order_confirms', 'transfer_details.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->get();

        return response()->json(

            [
                'status' => false,
                'orders' => $trackingDetails,
                'msg' => 'Return Delivery Details List'
            ],
            200
        );
    }


    public function deliveredc(Request $request)
    {

        $order = Order::where('tracking_id', $request->tracking_id)->first();

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->tracking_id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Successfully Delivered';
        $data->save();


        $order->status = 'Successfully Delivered';
        $order->save();

        $confirm = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
        $confirm->collect = $order->collection;
        $confirm->return_charge = 0;
        $confirm->save();

        return response()->json($data);
    }



    public function list_auto(Request $request)
    {

        $merchant_list = AutoAssign
            ::join('riders', 'auto_assigns.rider_id', 'riders.id')
            ->join('users', 'riders.user_id', 'users.id')
            ->where('users.id', auth('api')->user()->id)
            ->select('auto_assigns.merchant_id')
            ->get()->unique('merchant_id');

        foreach ($merchant_list as $value) {

            $merchant_id[] = $value->merchant_id;
        }


        $merchants = User
            ::join('merchants', 'users.id', 'merchants.user_id')
            ->whereIn('merchants.id', $merchant_list)
            ->select('merchants.id as id', 'merchants.business_name as merchantname')
            ->get();


        if ($request->merchant_id) {

            $selectedMerchant = $request->merchant_id;

            $data = AutoAssign::orderBy('orders.id', 'DESC')
                ->join('merchants', 'auto_assigns.merchant_id', 'merchants.id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->join('orders', 'users.id', 'orders.user_id')
                ->where('auto_assigns.merchant_id', $selectedMerchant)
                ->where('orders.status', 'Order Placed')
                ->select('orders.*', 'merchants.*', 'users.mobile', 'users.address', 'users.id as merchant_id')
                ->get();
        } else {

            $selectedMerchant = '';

            $data = AutoAssign::orderBy('orders.id', 'DESC')
                ->join('merchants', 'auto_assigns.merchant_id', 'merchants.id')
                ->join('users', 'merchants.user_id', 'users.id')
                ->join('orders', 'users.id', 'orders.user_id')
                ->whereIn('auto_assigns.merchant_id', $merchant_list)
                ->where('orders.status', 'Order Placed')
                ->select('orders.*', 'merchants.*', 'users.mobile', 'users.address', 'users.id as merchant_id')
                ->get();
        }




        return response()->json([

            'data' => $data,
            'merchants' => $merchants

        ]);
    }


    public function collect_auto(Request $request)
    {



        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = auth('api')->user()->id;
        $data->status       = 'Pickup Done';
        $data->save();


        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Pickup Done';
        $order->save();

        $data = new PickUpRequestAssign();
        $data->tracking_id  = $request->id;
        $data->user_id      = auth('api')->user()->id;
        $data->save();




        $company = Company::where('id', 1)->first();
        $data =  Order::where('tracking_id', $request->id)->join('merchants', 'orders.user_id', 'merchants.user_id')->first();

        $text = "Dear Valued Customer,\n{$company->name} Received a parcel From \"{$data->business_name}\" Value - {$data->collection} TK and It will be delivered Soon.\nThanks \n{$company->website}/tracking_details?tracking_id={$request->id}";

        //send Message
        Helpers::sms_send($order->customer_phone, $text);

        $msg = 'Order Collect Successfully';

        return response()->json($msg);
    }

    public function collectAll_auto(Request $request)
    {




        $trackings = $request->tracking_ids;

        foreach ($trackings as $tracking) {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $tracking;
            $data->user_id      = auth('api')->user()->id;
            $data->status       = 'Pickup Done';
            $data->save();


            $order = Order::where('tracking_id', $tracking)->first();
            $order->status = 'Pickup Done';
            $order->save();

            $data = new PickUpRequestAssign();
            $data->tracking_id  = $tracking;
            $data->user_id      = auth('api')->user()->id;
            $data->save();

            $riderInfo = User::where('id', auth('api')->user()->id)->first();
            $company = Company::where('id', 1)->first();

            $data =  Order::where('tracking_id', $tracking)->join('merchants', 'orders.user_id', 'merchants.user_id')->first();

            $text = "Dear Valued Customer,\n{$company->name} Received a parcel From \"{$data->business_name}\" Value - {$data->collection} TK and It will be delivered Soon.\nThanks \n{$company->website}/tracking_details?tracking_id={$tracking}";



            //send Message
            Helpers::sms_send($order->customer_phone, $text);
        }

        $msg = 'All order Collect Successfully';

        return response()->json($msg);
    }

    public function order_view(Request $request)
    {
        // dd($request->all());
        $data = Order::with('user')->where('orders.tracking_id', $request->tracking_id)
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


        return response()->json([
            'data' => $data,
            'order_history' => $history,
            'order_status' => $order_statuses,
            'company' => $company
        ]);
    }

    public function order_live_tracking(Request $request)
    {
        $data = Order::with('user')->where('orders.tracking_id', $request->tracking_id)
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


        return response()->json([
            'data' => $data,
            'order_history' => $history,
            'order_status' => $order_statuses,
            'company' => $company
        ]);
    }

    public function confirm_orders_list(Request $request)
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


            return response()->json([
                'confirmed_order_list' => $data,
                'fromdate' => $fromdate,
                'todate' => $todate,
            ]);
        } else {



            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->where('orders.user_id', $userId)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->select('orders.*', 'orders.created_at as order_create_date', 'orders.updated_at as order_updated_date', 'order_confirms.*', 'merchants.*', 'users.*')
                //->select('orders.*', 'order_confirms.*')
                // ->whereBetween('orders.updated_at', [$fromdate, $todate])
                // ->whereDate('orders.created_at', '>=', $fromdate)
                // ->whereDate('orders.created_at', '<=', $todate)
                ->get();


            $zone_id = '';

            return response()->json([
                'confirmed_order_list' => $data,
                'fromdate' => $fromdate,
                'todate' => $todate,
            ]);
        }
    }

    public function search_orders_list(Request $request)
    {

        if ($request->tracking_id) {
            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->where('orders.tracking_id', $request->tracking_id)
                ->where('orders.user_id', auth()->user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->select('orders.*', 'orders.created_at as order_create_date', 'orders.updated_at as order_updated_date', 'order_confirms.*', 'merchants.*', 'users.*')
                ->get();
            return response()->json($data);
        } elseif ($request->customer_name) {
            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->where('orders.customer_name', $request->customer_name)
                ->where('orders.user_id', auth()->user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->select('orders.*', 'orders.created_at as order_create_date', 'orders.updated_at as order_updated_date', 'order_confirms.*', 'merchants.*', 'users.*')
                ->get();
            return response()->json($data);
        } elseif ($request->customer_phone) {
            $data = Order::orderBy('order_confirms.id', 'DESC')
                ->where('orders.customer_phone', $request->customer_phone)
                ->where('orders.user_id', auth()->user()->id)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->select('orders.*', 'orders.created_at as order_create_date', 'orders.updated_at as order_updated_date', 'order_confirms.*', 'merchants.*', 'users.*')
                ->get();
            return response()->json($data);
        }
    }

    public function last_invoice(Request $request)
    {
        $latestPayment = MPayment::where('m_user_id', Auth::user()->id)
            ->whereIn('status', ['Payment Received By Merchant'])
            ->orderBy('updated_at', 'desc') // Order by the update time in descending order
            ->first();

        return response()->json(['latest_invoice_payment' => $latestPayment]);
    }

    public function payment_info_add(Request $request)
    {
        if (PaymentInfo::where('user_id', Auth::user()->id)->exists()) {
            return response()->json(['message' => 'Payment Info Already Created']);
        } else {
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

            return response()->json(['message' => 'Payment Info add Successfully', 'Payment_info' => $paymentInfo]);
        }
    }

    public function merchant_info(Request $request)
    {
        $data = User::where('id', Auth::user()->id)->value('address');
        return ['merchant_info' => $data];
    }

    public function pickup_request(Request $request)
    {
        $data = new PickUpRequest();
        $data->merchant_id = Auth::user()->id;
        $data->pickup_address = $request->pick_up_address;
        $data->note = $request->Note;
        $data->estimate_parcel = $request->estimated_parcel;
        $data->save();
        return [
            'message' => 'Pickup request add Successfully',
            'data' => $data
        ];
    }

    public function payment_request(Request $request)
    {
        $data = new PaymentRequest();
        $data->merchant_id = Auth::user()->id;
        $data->payment_method = $request->payment_method;
        $data->save();
        return [
            'message' => 'Payment request add Successfully',
            'data' => $data
        ];
    }

    public function parcel_store(Request $request)
    {
        //   return $request->all();

        $rules = [
            'merchant_id'     => 'required',
            'district_id'     => 'required',
            'area_id'         => 'required',
            'delivery_type'   => 'required',
            'weight'          => 'required',
            'customer_name'   => 'required',
            'customer_phone'  => 'required',
            'customer_address' => 'required',
        ];

        // Validation messages
        $messages = [
            'merchant_id.required'     => 'Merchant ID is required.',
            'district_id.required'     => 'District ID is required.',
            'area_id.required'         => 'Area ID is required.',
            'delivery_type.required'   => 'Delivery Type  is required.',
            'weight.required'          => 'Weight Name is required.',
            'customer_name.required'   => 'Customer Name is required.',
            'customer_phone.required'  => 'Customer Phone is required.',
            'customer_address.required' => 'Customer Address is required.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (Merchant::where('user_id', $request->input('merchant_id'))->exists() && CoverageArea::where('id', $request->input('area_id'))->exists() && CoverageArea::where('id', $request->input('area_id'))->exists() &&  WeightPrice::where('title', $request->input('weight'))->exists()) {



            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }


            $company = Company::first();
            $h = $company->company_initial;

            $id = $request->input('merchant_id');
            $s = $sl + 1;
            $dat = date('y');
            $track = $h . $id . $dat . $s;

            $ar = CoverageArea::where('district_id', $request->input('district_id'))->first();


            $area_name = CoverageArea::where('id', $request->input('area_id'))->first()->area;

            $m_discount = $merchant = Merchant::where('user_id', $request->input('merchant_id'))->first();

            $imp = $request->input('delivery_type');

            $data                   = new Order();
            $data->user_id          = $request->input('merchant_id');
            $data->tracking_id      = $track;
            $data->customer_name    = $request->input('customer_name');
            $data->customer_email   = $request->customer_email;
            $data->customer_phone   = $request->input('customer_phone');
            $data->customer_address = $request->input('customer_address');
            $data->area_id          = $request->input('area_id');
            $data->area             = $area_name;
            $data->pickup_date      = $request->pickup_date;
            $data->pickup_time      = $request->pickup_time;
            $data->remarks          = $request->remarks;
            $data->category         = $request->category_name;
            $data->selling_price    = $request->selling_price;
            $data->order_id         = $request->order_id;
            $data->weight           = $request->input('weight');
            $data->collection       = $request->collection;
            $data->inside           = $ar->inside;
            $data->district         = $ar->district;
            $data->type             = $imp;
            $data->status           = 'Order Placed';
            $data->save();



            $sPrice = WeightPrice::where('title', $request->input('weight'))->first();


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

            //order create
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
            $data->user_id      = $request->input('merchant_id');
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


            return response()->json(array(
                'status' => true,
                'message' => 'Order Create Successfully',
                'data' => $data,

            ));
        } else {
            return response()->json(array(
                'status' => false,
                'message' => 'Creadentails Does Not Match'
            ), 500);
        }
    }


    public function datewise_create_order_list(Request $request)
    {
        try {
            if ($request->fromdate && $request->todate) {
                $data = Order::where('orders.user_id', Auth::user()->id)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->select('order_confirms.*', 'merchants.*', 'users.*', 'orders.*')
                    ->whereDate('orders.created_at', '>=', $request->fromdate)
                    ->whereDate('orders.created_at', '<=', $request->todate)
                    ->orderBy('orders.id', 'DESC')
                    ->get();

                return response()->json(['create_order_list' => $data]);
            } else {
                return response()->json(['create_order_list' => 'Not Found']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function datewise_delivery_order_list(Request $request)
    {
        try {
            if ($request->fromdate && $request->todate) {

                $data = Order::where('orders.user_id', Auth::user()->id)
                    ->join('order_status_histories', 'orders.tracking_id', 'order_status_histories.tracking_id')
                    ->join('order_confirms', 'order_status_histories.tracking_id', 'order_confirms.tracking_id')
                    ->whereIn('order_status_histories.status', ['Successfully Delivered', 'Partially Delivered'])
                    ->whereDate('order_status_histories.updated_at', '>=', $request->fromdate)
                    ->whereDate('order_status_histories.updated_at', '<=', $request->todate)
                    ->get();

                return response()->json(['delivery_order_list' => $data]);
            } else {
                return response()->json(['delivery_order_list' => 'Not Found']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function datewise_return_order_list(Request $request)
    {
        try {
            if ($request->fromdate && $request->todate) {

                $data = Order::where('orders.user_id', Auth::user()->id)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->whereIn('orders.status', ['Return Confirm', 'Cancel Order', 'Return Reach To Merchant', 'Assigned Rider For Return', 'Return Received By Destination Hub', 'Return To Merchant'])
                    ->whereDate('orders.updated_at', '>=', $request->fromdate)
                    ->whereDate('orders.updated_at', '<=', $request->todate)
                    ->select('orders.*')
                    ->get();


                return response()->json(['return_order_list' => $data]);
            } else {
                return response()->json(['return_order_list' => 'Not Found']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function datewise_transit_order_list(Request $request)
    {
        try {
            if ($request->fromdate && $request->todate) {

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



                return response()->json(['transit_order_list' => $data]);
            } else {
                return response()->json(['transit_order_list' => 'Not Found']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reason_category(Request $request)
    {
        try {
            $return_reason = Db::table('delivery_category')->where('category_name', 'Return')->get();
            $reshedule_reason = Db::table('delivery_category')->where('category_name', 'Reshedule')->get();
            $exchange_reason = Db::table('delivery_category')->where('category_name', 'Exchange')->get();
            $partial_reason = Db::table('delivery_category')->where('category_name', 'Partial')->get();

            return response()->json([
                'return_reason_name' => $return_reason,
                'reshedule_reason_name' => $reshedule_reason,
                'exchange_reason_name' => $exchange_reason,
                'partial_reason_name' => $partial_reason,
            ]);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => 'An error occurred while fetching data from the database.'], 500);
        }
    }

    public function return_order_store(Request $request)
    {

        if (Order::where('tracking_id', $request->tracking_id)->exists()) {

            $order =  Order::where('tracking_id', $request->tracking_id)->first();

            if ($order->return_code == $request->return_code) {
                $moblile = Order::where('tracking_id', $request->tracking_id)->with('user')->first();

                $merchantnumber = $moblile->user->mobile;

                $data = new OrderStatusHistory();
                $data->tracking_id  = $request->tracking_id;
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Cancel Order';
                $data->save();


                $rand = rand(1111, 9999);

                $order = Order::where('tracking_id', $request->tracking_id)->first();
                $order->status = 'Cancel Order';
                $order->reason_name = $request->return_reason_name;
                $order->delivery_note = $request->note;
                $order->return_code = $rand;
                $order->save();


                return response()->json([
                    'message' => 'Order Return Successfully'
                ]);
            } else {

                return response()->json(['message' => 'Return code Incorrect']);
            }
        } else {
            return response()->json(['message' => 'Tracking id Not Found']);
        }
    }

    public function reschedule_order_store(Request $request)
    {
        if (Order::where('tracking_id', $request->tracking_id)->exists()) {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Reschedule Order';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Reschedule Order';
            $order->delivery_date = $request->date;
            $order->reason_name = $request->reshedule_reason_name;
            $order->delivery_note = $request->note;
            $order->save();

            return response()->json([
                'message' => 'Order Reschedule Successfully'
            ]);
        } else {
            return response()->json(['message' => 'Tracking id Not Found']);
        }
    }
    public function partial_order_store(Request $request)
    {

        if (Order::where('tracking_id', $request->tracking_id)->exists()) {
            $order = Order::where('tracking_id', $request->tracking_id)->first();

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Partially Delivered';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Partially Delivered';
            $order->reason_name = $request->partial_reason_name;
            $order->delivery_note = $request->note;
            $order->save();

            $confirmOrder = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
            $collect = $request->collection - ($confirmOrder->delivery + $confirmOrder->insurance + $confirmOrder->cod); // new calculate m_pay
            $confirmOrder->collect = $request->collection;
            $confirmOrder->merchant_pay = $collect;
            $confirmOrder->save();


            $partial = new Partial();
            $partial->tracking_id = $request->tracking_id;
            $partial->total_quantity = $request->total_quantity;
            $partial->delivery_quantity     = $request->delivery_quantity;
            $partial->return_quantity = $request->return_quantity;
            $partial->collection_amt = $request->collection;
            $partial->p_note = $request->note;
            $partial->p_status = 0;
            $partial->created_by = Auth::user()->id;
            $partial->updated_by = null;
            $partial->save();
            return response()->json([
                'message' => 'Partially Delivered Successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Tracking Id Not Found'
            ]);
        }
    }
    public function exchange_order_store(Request $request)
    {
        if (Order::where('tracking_id', $request->tracking_id)->exists()) {
            $order = Order::where('tracking_id', $request->tracking_id)->first();

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Exchange Delivered';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Exchange Delivered';
            $order->reason_name = $request->partial_reason_name;
            $order->delivery_note = $request->note;
            $order->save();

            $confirmOrder = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
            $collect = $request->collection - ($confirmOrder->delivery + $confirmOrder->insurance + $confirmOrder->cod); // new calculate m_pay
            $confirmOrder->collect = $request->collection;
            $confirmOrder->merchant_pay = $collect;
            $confirmOrder->save();


            $partial = new Partial();
            $partial->tracking_id = $request->tracking_id;
            $partial->total_quantity = $request->total_quantity;
            $partial->delivery_quantity     = $request->delivery_quantity;
            $partial->return_quantity = $request->return_quantity;
            $partial->collection_amt = $request->collection;
            $partial->p_note = $request->note;
            $partial->p_status = 0;
            $partial->created_by = Auth::user()->id;
            $partial->updated_by = null;
            $partial->save();
            return response()->json([
                'message' => 'Exchanged Delivered Successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Tracking Id Not Found'
            ]);
        }
    }
    public function return_request(Request $request)
    {

        try {
            $requestid = $request->tracking_id;

            if (Order::where('tracking_id', $requestid)->exists()) {
                $company = Company::where('id', 1)->first();
                $rand = rand(1111, 9999);

                $moblile = Order::where('tracking_id', $request->tracking_id)->with('user')->first();

                $merchantnumber = $moblile->user->mobile;

                $rider = OrderStatusHistory::where('status', 'Assigned To Delivery Rider')
                    ->where('tracking_id', $request->tracking_id)
                    ->with('assign')
                    ->first();



                Order::where('tracking_id', $requestid)->update(['return_code' => $rand]);

                return response()->json([
                    'message' => 'Return request Successfully',
                ]);
            } else {
                return response()->json([
                    'message' => 'Tracking Id Not Found',
                ]);
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function slider_store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Slider/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
        } else {
            $imageUrl = null;
        }
        $data               = new Slider();
        $data->image        = $imageUrl;
        $data->title        = $request->title;
        $data->title2       = $request->title2;
        $data->description  = $request->description;
        $data->save();

        return response()->json(['message' => 'Slider Add Successfully', 'data' => $data]);
    }

    public function slider_list(Request $request)
    {
        $slider = Slider::orderBy('id', 'DESC')->get();
        return response()->json($slider);
    }

    public function hub_wise_area(Request $request)
    {
        $data = CoverageArea::where('zone_id', $request->zone_id)->orderBy('area', 'asc')->get();
        return response()->json([
            'area_list' => $data,
        ]);
    }

    public function callback(Request $request)
    {
        // Validate the token
        $token = $request->query('token');
        if ($token !== 'pFmP6Qqm6LdLCQcQWdIAhHvELNzCeDP6k548w5rJZUDILGHJIggM-KCi5nVtUlFQ') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Define custom validation messages
        $messages = [
            'status.required' => 'Status is required.',
            'invoice_number.required' => 'Invoice number is required.',
        ];

        // Validate the payload
        $validated = $request->validate([

            'status' => 'required|string',
            'invoice_number' => 'required|string',
        ], $messages);

        // Extract payload data

        $status = $validated['status'];
        $invoiceNumber = $validated['invoice_number'];


        // Find the order
        $order = Order::where('tracking_id', $invoiceNumber)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update the order status based on RedX status
        switch ($status) {
            case 'ready-for-delivery':
                $order->update(['status' => 'Redx Order Received']);

                $data = new OrderStatusHistory();
                $data->tracking_id  = $invoiceNumber;
                $data->status       = 'Redx Order Received';
                $data->save();

                break;
            case 'delivery-in-progress':
                $order->update(['status' => 'Redx Delivery Assign']);

                $data = new OrderStatusHistory();
                $data->tracking_id  = $invoiceNumber;
                $data->status       = 'Redx Delivery Assign';
                $data->save();

                break;
            case 'delivered':
                $order->update(['status' => 'Redx Successfully Delivered']);

                $data = new OrderStatusHistory();
                $data->tracking_id  = $invoiceNumber;
                $data->status       = 'Redx Successfully Delivered';
                $data->save();
                break;
            case 'agent-hold':
                $order->update(['status' => 'Redx Order Hold']);

                $data = new OrderStatusHistory();
                $data->tracking_id  = $invoiceNumber;
                $data->status       = 'Redx Order Hold';
                $data->save();

                break;
            case 'agent-returning':
            case 'returned':
                $order->update(['status' => 'Redx Order Return']);

                $data = new OrderStatusHistory();
                $data->tracking_id  = $invoiceNumber;
                $data->status       = 'Redx Order Return';
                $data->save();

                break;
            case 'agent-area-change':
                $order->update(['status' => 'Redx Agent Area Change']);

                $data = new OrderStatusHistory();
                $data->tracking_id  = $invoiceNumber;
                $data->status       = 'Redx Agent Area Change';
                $data->save();

                break;
            case 'delivery-payment-collected':
                $order->update(['status' => 'Redx Delivery Payment Collected']);

                $data = new OrderStatusHistory();
                $data->tracking_id  = $invoiceNumber;
                $data->status       = 'Redx Delivery Payment Collected';
                $data->save();

                break;
            default:
                Log::warning('Unknown status received from RedX', ['status' => $status]);
                return response()->json(['error' => 'Unknown status'], 400);
        }

        // Respond to RedX
        return response()->json(['message' => 'Status Update Successfully']);
    }
}
