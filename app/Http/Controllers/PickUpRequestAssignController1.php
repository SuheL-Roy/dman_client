<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\AgentPayment;
use App\Admin\AgentPaymentDetail;
use App\Admin\BypassReturn;
use App\Admin\Company;
use App\Admin\Merchant;
use App\Admin\Merchant_Payment_Details;
use App\Admin\MerchantAdvancePayment;
use App\Admin\MerchantPayment;
use App\Admin\MerchantPaymentAdjustment;
use App\Admin\MerchantPaymentDetail;
use App\Admin\MerchantPaymentInfo;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use App\Admin\PaymentInfo;
use App\Admin\PickUpRequestAssign;
use App\Admin\Rider;
use App\Admin\TransferToAgent;
use App\Helper\Helpers\Helpers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PickUpRequestAssignController extends Controller
{
    public function index()
    {
        \Cart::clear();
        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();
        $order = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
            ->where('orders.status', 'PickUp Request')
            ->get();
        return view('Admin.PickUpRequestAssign.requestAssign', compact('order', 'rider'));
    }



    public function add(Request $request, $id)
    {
        $orders = Order::where('tracking_id', $id)->first();
        // dd($id);
        \Cart::add(array(
            'id'         => $orders->tracking_id,
            'name'       => $orders->order_id,
            'price'      => '',
            'quantity'   => 1,
            'attributes' => array(
                'area'          => $orders->area,
                'collection'    => $orders->collection,
                'merchant_pay'  => $orders->merchant_pay,
                'pickup_date'   => $orders->pickup_date,
                'pickup_time'   => $orders->pickup_time
            )
        ));
        $msg = "PickUp Request Assigned To Rider";
        $request->session()->flash('message', $msg);
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->back()->with('message', 'PickUp Request Assign Removed ');
    }

    public function confirm()
    {
        $agent = Agent::where('user_id', Auth::user()->id)->first();
        $area = $agent->area;
        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        return view('Admin.PickUpRequestAssign.requestConfirm', compact('user'));
    }

    public function pickup()
    {

        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();
        $order = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
            ->where('orders.status', 'PickUp Request')
            ->get();
        return view('Admin.PickUpRequestAssign.pickup', compact('order', 'rider'));
    }


    public function pickUP_confirm(Request $request)
    {
        $tracking_id = $request->tracking_ids;
        $agent = Agent::where('user_id', Auth::user()->id)->first();
        $area = $agent->area;
        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        return view('Admin.PickUpRequestAssign.pickupConfirm', compact('user', 'tracking_id'));
    }


    public function request_pickup()
    {

        $agent = Agent::where('user_id', Auth::user()->id)->first();
        $area = $agent->area;
        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();

        $order = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'merchants.user_id', 'orders.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
            ->where('merchants.area', $area)
            ->where('orders.status', 'Order Placed')
            ->get();
        return view('Admin.PickUpRequestAssign.requestPickup', compact('user', 'order', 'rider'));
    }

    public function confirm_pickUP(Request $request)
    {
        // return $request->all();

        $tracking_id = $request->tracking_ids;

        if ($tracking_id) {

            foreach ($tracking_id as $id) {
                // dd($id);
                $data =  Order::where('tracking_id', $id)->first();
                // dd($data);
                $history = new OrderStatusHistory();
                $history->tracking_id  = $data->tracking_id;
                $history->user_id      = Auth::user()->id;
                $history->status       = 'Assigned Pickup Rider';
                $history->save();

                $order = Order::where('tracking_id', $data->tracking_id)->first();
                $order->status = 'Assigned Pickup Rider';
                $order->save();



                $data_exist = DB::table('pick_up_request_assigns')->where('tracking_id', $id)->first();

                if ($data_exist) {

                    DB::table('pick_up_request_assigns')->where('tracking_id', $id)->update(['user_id' => $request->rider]);
                } else {

                    $mdata = array(
                        'tracking_id'   => $data->tracking_id,
                        'user_id'       => $request->rider,
                    );

                    DB::table('pick_up_request_assigns')->insert($mdata);
                }
            }
        }
        return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
        //route('request.assign.pickUP.confirm')
    }
    public function pickup_invoice(Request $request)
    {
        // return  $request->all();

        if (empty($request->tracking_ids)) {
            \Toastr::warning('You haven\'t any complete order', 'Opps!!!', ["positionClass" => "toast-top-center", "progressBar" => true]);
            return redirect()->back();
        }

        $trackings = $request->tracking_ids;

        $invs = "APMT";
        $riderLastId = AgentPayment::all()->count() + 1;
        $auth_id = Auth::user()->id;
        $rand_number = rand(111, 999);
        $invoice = $invs . $auth_id . $riderLastId . $rand_number;

        $agentPayment = new AgentPayment();
        $agentPayment->invoice_id  = $invoice;
        $agentPayment->agent_id      =  Auth::user()->id;
        $agentPayment->status       = 0;
        $agentPayment->created_by       = Auth::user()->id;
        $agentPayment->save();


        foreach ($trackings as $tracking) {

            $order = Order::where('tracking_id', $tracking)->first();
            $status = '';
            if ($order->status == 'Partially Delivered Received from Branch') {
                $status = 'Return Confirm';
            } else if ($order->status == 'Delivered Amount Collected from Branch') {
                $status = 'Delivered Amount Send to Fulfillment';
            }


            //Save Data in Rider Payment Details Table
            $agentPaymentDetails = new AgentPaymentDetail();
            $agentPaymentDetails->invoice_id  = $invoice;
            $agentPaymentDetails->tracking_id     = $tracking;
            $agentPaymentDetails->order_status     = $status == 'Return Confirm' ? 'Partially Delivered Amount Send to Fulfillment' : $status;
            $agentPaymentDetails->save();

            if ($status != '') {

                $data = new OrderStatusHistory();
                $data->tracking_id  = $tracking;
                $data->user_id      = Auth::user()->id;
                $data->status       = $status;
                $data->save();

                $order_data = Order::where('tracking_id', $tracking)->first();
                $order_data->status = $status;
                $order_data->save();
            }
        }

        //Toast Message and reload
        \Toastr::success('Successfully create invoice.', 'Success!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
        return redirect()->back();
    }


    public function con_firm(Request $request)
    {
        foreach (\Cart::getContent() as $data) {
            $history = new OrderStatusHistory();
            $history->tracking_id  = $data->id;
            $history->user_id      = Auth::user()->id;
            $history->status       = 'PickUp Assigned';
            $history->save();

            $order = Order::where('tracking_id', $data->id)->first();
            $order->status = 'PickUp Assigned';
            $order->save();

            $mdata = array(
                'tracking_id'   => $data->id,
                'user_id'       => $request->rider,
            );
            $insert = DB::table('pick_up_request_assigns')->insert($mdata);
        }
        \Cart::clear();
        return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
    }

    public function edit(Request $request)
    {
        $data = Order::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        // PickUpRequestAssign::create([ 
        //                     'tracking_id'   => $request->category, 
        //                     'user_id'       => $request->rider 
        //                 ]);
        $data   = new PickUpRequestAssign();
        $data->tracking_id  = $request->tracking_id;
        $data->user_id      = $request->rider;
        $data->save();
        $order = Order::where('tracking_id', $request->tracking_id)->first();
        $order->status = 'PickUp Assigned';
        $order->save();
        return redirect()->back()->with('message', 'Pick Up Request Assigned Successfully');
    }

    // public function pickup(Request $request)
    // {
    //     $data = new OrderStatusHistory();
    //     $data->tracking_id  = $request->id;
    //     $data->user_id      = Auth::user()->id;
    //     $data->status       = 'PickUp Request';
    //     $data->save();

    //     $data = Order::where('tracking_id', $request->id)->first();
    //     $data->status = 'PickUp Request';
    //     $data->save();

    //     return redirect()->back()->with('message','Status Changed Successfully');
    // }


    public function list()
    {
        //Rider Pickup Assign List
        $rider = Rider::where('user_id', Auth::user()->id)->first();
        $area = $rider->area;
        $selectedMerchant = '';
        $merchants = Order::orderBy('orders.id', 'DESC')
            ->whereIn('orders.status', ['Assigned Pickup Rider'])
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('merchants.*')
            ->where('merchants.area', $area)
            ->get()->unique('user_id');


        $data = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.*', 'users.mobile', 'users.address')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get();

        $order = $data->unique('tracking_id');


        return view('Admin.PickUpRequestAssign.assignedRequest', compact('order', 'merchants', 'selectedMerchant'));
    }
    public function collect_list_load(Request $request)
    {
        // return $request;

        //Rider Pickup Assign List
        // $rider = Rider::where('user_id', Auth::user()->id)->first();
        // $area = $rider->area;
        $selectedMerchant = $request->user_id;
        $merchants = Order::orderBy('orders.id', 'DESC')
            ->whereIn('orders.status', ['Assigned Pickup Rider'])
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('merchants.*')
            // ->where('merchants.area', $area)
            ->get()->unique('user_id');

        $data = Order::orderBy('pick_up_request_assigns.id', 'DESC')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->select('pick_up_request_assigns.*', 'orders.*', 'merchants.*', 'users.mobile', 'users.address')
            ->where('pick_up_request_assigns.user_id', Auth::user()->id)
            ->where('orders.status', 'Assigned Pickup Rider')
            ->get();



        $order = $data->unique('tracking_id');


        return view('Admin.PickUpRequestAssign.assignedRequest', compact('order', 'merchants', 'selectedMerchant'));
    }

    public function collect(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Pickup Done';
        $data->save();


        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Pickup Done';
        $order->save();

        $company = Company::where('id', 1)->first();
        $data =  Order::where('tracking_id', $request->id)->join('merchants', 'orders.user_id', 'merchants.user_id',)->first();

        $text = "Dear Valued Customer,\n{$company->name} Received a parcel From \"{$data->business_name}\" Value - {$data->collection} TK and It will be delivered Soon.\nThanks \n{$company->website}/tracking_details?tracking_id={$request->id}";

        //send Message
        Helpers::sms_send($order->customer_phone, $text);

        return redirect()->route('request.assign.list')->with('message', 'Order Collect Successfully');
    }
    public function collectAll(Request $request)
    {

        $trackings = $request->tracking_ids;
        foreach ($trackings as $tracking) {
            $data = new OrderStatusHistory();
            $data->tracking_id  = $tracking;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Pickup Done';
            $data->save();


            $order = Order::where('tracking_id', $tracking)->first();
            $order->status = 'Pickup Done';
            $order->save();

            $riderInfo = User::where('id', $request->rider)->first();
            $company = Company::where('id', 1)->first();

            $data =  Order::where('tracking_id', $tracking)->join('merchants', 'orders.user_id', 'merchants.user_id',)->first();

            $text = "Dear Valued Customer,\n{$company->name} Received a parcel From \"{$data->business_name}\" Value - {$data->collection} TK and It will be delivered Soon.\nThanks \n{$company->website}/tracking_details?tracking_id={$tracking}";



            //send Message
            Helpers::sms_send($order->customer_phone, $text);
        }

        return redirect()->route('request.assign.list')->with('message', 'Order Collect Successfully');
    }

    public function cancel(Request $request)
    {

        if (Auth::user()->role == 8) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'PickUp Cancel';
            $data->save();

            $order = Order::where('tracking_id', $request->id)->first();
            $isExists = Merchant::where('zone_id', $agent->zone_id)->first();
            if ($isExists) {
                $order->status = 'PickUp Cancel';
                $order->save();
            } else {
                //  return redirect()->back()->with('message', 'You can not cancel this order');
                \Toastr::error('You can not cancel this order', 'Warning!!!', ["positionClass" => "toast-top-center", "progressBar" => true]);
                return redirect()->back();
            }
            // return redirect()->back()->with('message', 'Successfully Cancel Order');
            \Toastr::success('Successfully Cancel Order', 'Success!!!', ["positionClass" => "toast-top-center", "progressBar" => true]);
            return redirect()->back();
        } else {
            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'PickUp Cancel';
            $data->save();

            $order = Order::where('tracking_id', $request->id)->first();

            $order->status = 'PickUp Cancel';
            $order->save();
            // return redirect()->back()->with('message', 'Successfully Cancel Order');
            \Toastr::success('Successfully Cancel Order', 'Success!!!', ["positionClass" => "toast-top-center", "progressBar" => true]);
            return redirect()->back();
        }
        // //return $request->all();
        // $data = new OrderStatusHistory();
        // $data->tracking_id  = $request->id;
        // $data->user_id      = Auth::user()->id;
        // $data->status       = 'PickUp Cancel';
        // $data->save();

        // $order = Order::where('tracking_id', $request->id)->first();
        // $order->status = 'PickUp Cancel';
        // $order->save();
        // return redirect()->back()->with('message', 'Status Changed Successfully');
    }

    public function deleteOrderAdmin(Request $request)
    {
        // return $request->id;
        // return $request->all();
        // $data = new OrderStatusHistory();
        // $data->tracking_id  = $request->id;
        // $data->user_id      = Auth::user()->id;
        // $data->status       = 'PickUp Cancel';
        // $data->save();

        if ($request->id) {
            $order = Order::where('tracking_id', $request->id)->first();
            $order->delete();

            $orderconfirm = OrderConfirm::where('tracking_id', $request->id)->first();
            $orderconfirm->delete();



            \Toastr::success('Please Select first.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return back();
        }
        // $order->status = 'PickUp Cancel';
        // $order->save();
        // return redirect()->back()->with('message', 'Status Changed Successfully');
    }



    public function order_print($id)
    {

        $company = Company::orderBy('id', 'DESC')->get();
        $datas = Order::where('tracking_id', $id)
            ->join('users', 'orders.user_id', 'users.id')
            ->join('shops', 'orders.shop', 'shops.shop_name')
            ->select('orders.*', 'users.name as merchant', 'users.mobile as merchant_no', 'shops.pickup_address')
            ->first();
        return view('Admin.PaymentInfo.order_print', compact('company', 'datas'));
    }

    public function payment_collect()
    {
        $order = TransferToAgent::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Processing')
            ->join('orders', 'transfer_to_agents.tracking_id', 'orders.tracking_id')
            ->join('users', 'transfer_to_agents.agent_id', 'users.id')
            ->select(
                'orders.*',
                'users.name as agent',
                'users.mobile as phone',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $Total = $order->sum('collection');
        return view('Admin.PickUpRequestAssign.pay_collect_by_accounts', compact('order', 'Total'));
    }

    public function paymentCollect(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Payment Collect';
        $data->save();

        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Payment Collect';
        $order->save();
        return redirect()->back()->with('message', 'Payment Collected Successfully');
    }

    public function merchant_payment(Request $request)
    {

        $bypass = BypassReturn::
            // where('m_id', $request->merchant)->
            where('status', 0)->select('tracking_id')->get();
        $bypass_return = $bypass->pluck('tracking_id');


        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        //for Get Order Merchants Id
        $completeOrder = Order::orderBy('orders.id', 'DESC')
            ->whereIn('orders.status', ['Payment Processing', 'Return Payment Processing'])
            ->orWhereIn('orders.tracking_id', $bypass_return)
            // ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.user_id as user_id'
            )
            ->get()->unique('user_id');
        $totals_MID = $completeOrder->pluck('user_id');
        $merchants = Merchant::orderBy('merchants.id', 'DESC')->whereIn('user_id', $totals_MID)->get();




        $merchant = $request->merchant;

        // $user = User::where('role', 12)->get();

        // return  $complete = Order::orderBy('orders.id', 'DESC')
        if ($merchant) {
            $bypass = BypassReturn::where('m_id', $request->merchant)->where('status', 0)->select('tracking_id')->get();
            $bypassreturn = $bypass->pluck('tracking_id');

            //return $bypass_return;
            $complete = Order::orderBy('orders.id', 'DESC')
                ->where('orders.user_id', $merchant)
                // ->whereBetween('orders.updated_at', [$fromdate, $todate])
                ->whereDate('orders.created_at', '<=', $todate)
                ->whereDate('orders.created_at', '>=', $fromdate)

                ->whereIn('orders.status', ['Payment Processing', 'Return Payment Processing'])
                ->orWhereIn('orders.tracking_id', $bypassreturn)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('users', 'users.id', 'orders.user_id')

                ->select(
                    'orders.*',
                    'order_confirms.*',
                    'merchants.business_name as merchant',
                    'users.*',
                    'merchants.*'

                )
                ->get();


            $tcollect = $complete->sum('collect');
            $treturn  = $complete->sum('return_charge');
            $tcod = $complete->sum('cod');
            $tinsurance = $complete->sum('insurance');
            $tdelivery = $complete->sum('delivery');

            $tCol = $complete->sum('collection');
            $tMPay = $complete->sum('merchant_pay');
        } else {
            $complete = [];
            $tcollect = 0;
            $treturn  = 0;
            $tcod = 0;
            $tinsurance = 0;
            $tdelivery = 0;

            $tCol = 0;
            $tMPay = 0;
        }


        // $tcollect = $complete->sum('collect');
        // $treturn  = $complete->sum('return_charge');
        // $tcod = $complete->sum('cod');
        // $tinsurance = $complete->sum('insurance');
        // $tdelivery = $complete->sum('delivery');
        $tpay = $tcollect - ($treturn + $tcod + $tinsurance + $tdelivery);


        // $tCol = $complete->sum('collection');
        // $tMPay = $complete->sum('merchant_pay');

        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Confirm')
            ->where('orders.user_id', $merchant)
            ->orWhereIn('orders.tracking_id', $bypass_return)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.*',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view('Admin.PaymentInfo.merchant_payment', compact(
            'merchants',
            'merchant',
            'fromdate',
            'todate',
            'complete',
            'return',
            'tCol',
            'tMPay',
            'tRc',
            'tAmt',
            'tcollect',
            'treturn',
            'tcod',
            'tinsurance',
            'tdelivery',
            'tpay'
        ));
    }

    public function paymentComplete(Request $request)
    {
        // return $request;


        $invs = "MPMT";
        $riderLastId = MerchantPayment::all()->count() + 1;
        $auth_id = Auth::user()->id;
        $rand_number = rand(111, 999);
        $invoice_id = $invs . $auth_id . $riderLastId . $rand_number;

        $merchant = Merchant::where('user_id', $request->merchant)->first();
        //Advanced Payment Total
        $adv_payment_t = MerchantAdvancePayment::where('merchant_id', $merchant->id)->get()->sum('amount');
        //Adjusment Payment Total
        $adj_payment_t = MerchantPaymentAdjustment::where('m_id', $merchant->id)->get()->sum('p_amount');

        //Selected Orders List
        $bypass = BypassReturn::where('m_id', $request->merchant)->where('status', 0)->select('tracking_id')->get();
        $bypass_return = $bypass->pluck('tracking_id');

        $complete_orders = Order::orderBy('orders.id', 'DESC')
            ->whereIn('orders.status', ['Payment Processing', 'Return Payment Processing'])
            ->where('orders.user_id', $request->merchant)
            ->whereIn('orders.tracking_id', $request->tracking_ids)
            ->orWhereIn('orders.tracking_id', $bypass_return)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'users.id', 'orders.user_id')

            ->select(
                'orders.*',
                'order_confirms.*',
                'merchants.business_name as merchant',
                'users.mobile as m_phone'

            )
            ->get();

        //Merchant Payment Info
        $merchatPaymetInfo =  PaymentInfo::where('user_id', $request->merchant)->first();


        //Calculate 
        $tcollect = $complete_orders->sum('collect');
        $treturn  = $complete_orders->sum('return_charge');
        $treturn  = $complete_orders->sum('return_charge');
        $tcod = $complete_orders->sum('cod');
        $tinsurance = $complete_orders->sum('insurance');
        $tdelivery = $complete_orders->sum('delivery');
        $tpay = $tcollect - ($treturn + $tcod + $tinsurance + $tdelivery);

        // return $invoice;

        if ($request->tracking_ids) {
            $m_paid = 0; //Merchant Paid 
            $m_pay = 0; // Merchant Payment 
            $t_current_due = 0; // Merchant Advancev Payment 

            //check advaced payment getter then Adjustment Payment
            if ($adv_payment_t > $adj_payment_t) {
                $advancedPayT = $adv_payment_t - $adj_payment_t;
                if ($tpay <= 0) {


                    if ($advancedPayT > 0) {

                        $m_paid = 0;
                        $m_pay = $tpay - $advancedPayT;
                        $t_current_due = $advancedPayT;
                    } else {

                        $m_paid = 0;
                        $m_pay = $tpay;
                        $t_current_due = 0;
                    }
                } else {

                    if ($advancedPayT > $tpay) {

                        $m_paid = $tpay; //Merchant Paid equel Total Paid
                        $m_pay = $m_paid - $advancedPayT; //Merchatn pay equel 
                        $t_current_due = $advancedPayT;
                    } else {

                        $m_paid =  $advancedPayT;
                        $m_pay = $tpay - $advancedPayT;
                        $t_current_due = $advancedPayT;
                    }
                }
            } else {
                $m_paid = 0;
                $m_pay = $tpay;
                $t_current_due = 0;
            }

            //Payment Adjustment
            $pay_adjustment = new  MerchantPaymentAdjustment();
            $pay_adjustment->m_id = $merchant->id;
            $pay_adjustment->p_amount = $m_paid;
            $pay_adjustment->invoice_id = $invoice_id;
            $pay_adjustment->save();

            //Merchant Payment
            $m_payment_info = new  MerchantPayment();
            $m_payment_info->invoice_id = $invoice_id;
            $m_payment_info->m_id = $merchant->id;
            $m_payment_info->m_user_id = $merchant->user_id;
            $m_payment_info->t_payable = $m_pay;
            $m_payment_info->t_current_due = $t_current_due;
            $m_payment_info->status = 'Payment Processing';
            $m_payment_info->m_pay_id = $pay_adjustment->id;
            $m_payment_info->created_by = Auth::user()->id;
            $m_payment_info->updated_by = Auth::user()->id;
            $m_payment_info->save();

            //check merchant pay is Exits
            if ($merchatPaymetInfo) {
                if ($merchatPaymetInfo->p_type === 'Bank') {
                    //Merchant Payment
                    $m_payment_info = new  MerchantPaymentInfo();
                    $m_payment_info->invoice_id = $invoice_id;
                    $m_payment_info->p_type = $merchatPaymetInfo->p_type;
                    $m_payment_info->m_id = $merchant->id;
                    $m_payment_info->bank_name = $merchatPaymetInfo->bank_name;
                    $m_payment_info->branch_name = $merchatPaymetInfo->branch_name;
                    $m_payment_info->account_holder_name = $merchatPaymetInfo->account_holder_name;
                    $m_payment_info->account_type = $merchatPaymetInfo->account_type;
                    $m_payment_info->account_number = $merchatPaymetInfo->account_number;
                    $m_payment_info->routing_number = $merchatPaymetInfo->routing_number;
                    $m_payment_info->save();
                } else {
                    //Merchant Payment
                    $m_payment_info = new  MerchantPaymentInfo();
                    $m_payment_info->invoice_id = $invoice_id;
                    $m_payment_info->p_type = $merchatPaymetInfo->p_type;
                    $m_payment_info->m_id = $merchant->id;
                    $m_payment_info->mb_name = $merchatPaymetInfo->mb_name;
                    $m_payment_info->mb_type = $merchatPaymetInfo->mb_type;
                    $m_payment_info->mb_number = $merchatPaymetInfo->mb_number;
                    $m_payment_info->save();
                }
            }

            foreach ($complete_orders as $complete_order) {
                //Merchant Payment
                $m_payment_info = new  MerchantPaymentDetail();
                $m_payment_info->invoice_id = $invoice_id;
                $m_payment_info->tracking_id = $complete_order->tracking_id;
                $m_payment_info->order_status = $complete_order->status;
                $m_payment_info->save();


                if ($complete_order->status === 'Payment Processing') {
                    $status = 'Payment Processing Complete';
                } else {
                    $status = 'Return To Merchant ';
                }

                $data = new OrderStatusHistory();
                $data->tracking_id  = $complete_order->tracking_id;
                $data->user_id      = Auth::user()->id;
                $data->status       = $status;
                $data->save();

                $order = Order::where('tracking_id', $complete_order->tracking_id)->first();
                $order->status = $status;
                $order->save();
                //update Status
                $isExits = BypassReturn::where('tracking_id', $complete_order->tracking_id)->first();
                if ($isExits) {
                    BypassReturn::where('tracking_id', $complete_order->tracking_id)->update(['status' => 1]);
                }
            }

            //execute when No Selected Tracking Id
            $merchant = $merchant->id;
            $today = date('Y-m-d');
            $fromdate = $request->fromdate;
            if ($request->todate) {
                $todate = $request->todate;
            } else {
                $todate = $today;
            }

            \Toastr::success('Merchant Payment Successfully', 'Success!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        } else {
            //execute when No Selected Tracking Id
            $merchant = $merchant->id;
            $today = date('Y-m-d');
            $fromdate = $request->fromdate;
            if ($request->todate) {
                $todate = $request->todate;
            } else {
                $todate = $today;
            }

            \Toastr::warning('Please Select First', 'Error!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        }







        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $merchant = $request->merchant;
        $user = User::where('role', 12)->get();
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Collect')
            ->where('orders.user_id', $merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->first();
        $complete->status = 'Payment Complete';
        $complete->save();
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Confirm')
            ->where('orders.user_id', $merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->first();
        $return->status = 'Return Adjustment';
        $return->save();
        return redirect()->action(
            'PickUpRequestAssignController@paymentPrint',
            ['merchant' => $merchant, 'fromdate' => $fromdate, 'todate' => $todate]
        );
    }

    public function paymentPrint(Request $request)
    {
        $merchant = $request->merchant;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $company = Company::orderBy('id', 'DESC')->get();
        $data = User::find($merchant);
        $name = $data->name;
        $phone = $data->mobile;
        $complete = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Payment Complete')
            ->where('orders.user_id', $merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select(
                'orders.*',
                'order_confirms.merchant_pay',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tCol = $complete->sum('collection');
        $tMPay = $complete->sum('merchant_pay');
        $return = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return Adjustment')
            ->where('orders.user_id', $merchant)
            ->whereBetween('orders.updated_at', [$fromdate, $todate])
            ->leftJoin('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->select(
                'orders.*',
                'return_assigns.return_charge',
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m-%d') as date")
            )
            ->get();
        $tRc = $return->sum('return_charge');
        $tAmt = $tMPay - $tRc;
        return view('Admin.PaymentInfo.merchant_payment_print', compact(
            'name',
            'phone',
            'fromdate',
            'todate',
            'complete',
            'return',
            'tCol',
            'tMPay',
            'tRc',
            'tAmt',
            'company'
        ));
    }
}
