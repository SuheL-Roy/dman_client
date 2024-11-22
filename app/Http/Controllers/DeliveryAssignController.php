<?php

namespace App\Http\Controllers;

use App\Admin\Agent;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\DeliveryAssign;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use App\Admin\Partial;
use App\Admin\PickUpRequestAssign;
use App\Admin\RiderPayment;
use App\Admin\RiderPaymentDetail;
use App\Admin\Transfer;
use App\Admin\TransferDetail;
use App\Admin\ReturnAssign;
use App\Admin\ReturnAssignDetail;
use App\Admin\Rider;
use App\Admin\Shop;
use App\Helper\Helpers\Helpers;
use App\Scan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Session as FacadesSession;


class DeliveryAssignController extends Controller
{

    public function edit(Request $request)
    {
        $data = Order::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data   = new DeliveryAssign();
        $data->tracking_id  = $request->tracking_id;
        $data->user_id      = $request->rider;
        $data->save();

        $order = Order::where('tracking_id', $request->tracking_id)->first();
        $order->status = 'Waiting For Delivery';
        $order->save();
        return redirect()->back()->with('message', 'Delivery Assigned Successfully');
    }

    public function list()
    {

        $order_data = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'users.*')
            ->where('orders.status', 'Assigned To Delivery Rider')
            ->where('delivery_assigns.user_id', Auth::user()->id)
            ->get();

        //  return $order_data->count();

        $return =  DB::table('delivery_category')->where('category_name', 'Return')->get();
        $reshedule = DB::table('delivery_category')->where('category_name', 'Reshedule')->get();
        $partial = DB::table('delivery_category')->where('category_name', 'Partial')->get();



        $order = $order_data->unique('tracking_id');

        return view('Admin.PickUpRequestAssign.assignedDelivery', compact('order', 'return', 'reshedule', 'partial'));
    }


    public function return_request(Request $request)
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

        // $user = User::where('id', Auth::user()->id)->first();


        // $text = "Dear Valued Merchant,\n'Your return parcel id is ";



        // $company = Company::where('id', 1)->first();
        // $text = "Dear Valued Merchant,\nYour return parcel was carried by {$rider->assign->name}-{$rider->assign->mobile} from {$company->name}. \nYour security code is {$rand}. \nThanks\n{$company->website} or Tel:{$company->mobile}.";



        // Helpers::sms_send($merchantnumber, $text);




        Order::where('tracking_id', $requestid)->update(['return_code' => $rand]);

        \Toastr::success('Return  Code is Submited ! ', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }

    public function transfer_list()
    {
        $transfers = Transfer::with('sender', 'receiver')->where('media_id', Auth::user()->id)->where('status', 0)->get();
        return view('Admin.PickUpRequestAssign.assignedDeliveryTransfer', compact('transfers'));
    }
    public function hold_list()
    {
        // return "ok hold";
        $order_data = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('shops', 'orders.shop', 'shops.shop_name')
            ->select('delivery_assigns.*', 'orders.*', 'shops.*')
            ->whereIn('orders.status', ['Hold Order', 'Cancel Order', 'Reschedule Order'])
            ->where('delivery_assigns.user_id', Auth::user()->id)
            ->get();

        $order = $order_data->unique('tracking_id');

        return view('Admin.PickUpRequestAssign.assignedIncomplete', compact('order'));
    }

    public function transfer_list_confirm(Transfer $transfer, Request $request)
    {

        $trackingDetails = TransferDetail::where('invoice_id', $transfer->invoice_id)->get();
        $transfer = Transfer::where('invoice_id', $transfer->invoice_id)->first();


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
            /* foreach ($trackingDetails as $trackingdetail) {
                TransferDetail::where('invoice_id', $trackingdetail->invoice_id)->update(['updated_by' => Auth::user()->id]);
                Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Reach to Fullfilment']);
            } */
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
        return back();
    }
    public function transfer_list_confirm_show(Transfer $transfer, Request $request)
    {


        $trackingDetails = TransferDetail::where('transfer_details.invoice_id', $transfer->invoice_id)
            ->join('orders', 'transfer_details.tracking_id', 'orders.tracking_id')
            ->join('order_confirms', 'transfer_details.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('transfer_details.*', 'users.*', 'merchants.*', 'orders.*', 'order_confirms.*')
            ->get();

        $transfer = Transfer::with('sender', 'receiver', 'media')->where('invoice_id', $transfer->invoice_id)->first();

        return view('Backend.Transfer.show', compact('trackingDetails', 'transfer'));
    }
    public function transfer_list_confirm_print(Transfer $transfer, Request $request)
    {


        $trackingDetails = TransferDetail::where('transfer_details.invoice_id', $transfer->invoice_id)
            ->join('orders', 'transfer_details.tracking_id', 'orders.tracking_id')
            ->join('order_confirms', 'transfer_details.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('transfer_details.*', 'users.*', 'merchants.*', 'orders.*', 'order_confirms.*')
            ->get();

        $transfer = Transfer::with('sender', 'receiver', 'media')->where('invoice_id', $transfer->invoice_id)->first();
        $company = Company::first();

        return view('Backend.Transfer.print', compact('trackingDetails', 'transfer', 'company'));
    }

    public function delivered(Request $request)
    {



        if (!$request->security_code) {
            \Toastr::error('Security  Code is Empty ! ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        $order = Order::where('tracking_id', $request->tracking_id)->first();

        if (!$order) {
            \Toastr::error('Something Went to Wrong Please Try again later.', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        // if ($request->security_code != $order->security_code) {
        //     \Toastr::error('Security Code Does not Match .', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        //     return redirect()->back();
        // }

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

        \Toastr::success('Order Delivered Successfully', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }
    public function deliveredc(Request $request)
    {


        $order = Order::where('tracking_id', $request->tracking_id)->first();

        if (!$order) {
            \Toastr::error('Something Went to Wrong Please Try again later.', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        // if ($request->security_code != $order->security_code) {
        //     \Toastr::error('Security Code Does not Match .', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        //     return redirect()->back();
        // }

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

        \Toastr::success('Order Delivered Successfully', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }
    public function deliveredOption(Request $request)
    {
        // return $request;





        if ($request->type == 'Partial Delivery') {

            // if (!$request->security_code) {
            //     \Toastr::error('Security  Code is Empty ! ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            //     return redirect()->back();
            // }
            if (!$request->collection) {
                \Toastr::error('Collection is Empty ! ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }

            $order = Order::where('tracking_id', $request->tracking_id)->first();

            if (!$order) {
                \Toastr::error('Something Went to Wrong Please Try again later.', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }
            // if ($request->security_code != $order->security_code) {
            //     \Toastr::error('Security Code Does not Match .', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            //     return redirect()->back();
            // }
            if ($request->collection > $order->collection) {
                \Toastr::error('You Can\'n Collect More then Invoice Value', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }
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

            //  id	tracking_id	collection_amt	p_note	p_status	created_by	updated_by	created_at	updated_at	;


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

            return redirect()->back()->with('message', 'Partially Delivered Successfully');
        } else if ($request->type == 'exchange') {

            // if (!$request->security_code) {
            //     \Toastr::error('Security  Code is Empty ! ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            //     return redirect()->back();
            // }
            if (!$request->collection) {
                \Toastr::error('Collection is Empty ! ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }

            $order = Order::where('tracking_id', $request->tracking_id)->first();

            if (!$order) {
                \Toastr::error('Something Went to Wrong Please Try again later.', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }
            // if ($request->security_code != $order->security_code) {
            //     \Toastr::error('Security Code Does not Match .', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            //     return redirect()->back();
            // }   
            if ($request->collection > $order->collection) {
                \Toastr::error('You Can\'n Collect More then Invoice Value', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }
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

            //  id	tracking_id	collection_amt	p_note	p_status	created_by	updated_by	created_at	updated_at	;


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

            return redirect()->back()->with('message', 'Exchanged Delivered Successfully');
        } else if ($request->type == 'cancel') {




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
                $order->reason_name = $request->return_reason_name;
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
                $text = "Dear Valued Merchant,\nYour return parcel was carried by {$rider->assign->name}-{$rider->assign->mobile} from {$company->name}. \nYour security code is {$rand}. \nThanks\n{$company->website} or Tel:{$company->mobile}.";

                return redirect()->back()->with('message', 'Order Return Successfully');
            } else {
                \Toastr::warning('Youre Code are incorrect ', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
                return redirect()->back();
            }
        } else if ($request->type == 'schedule') {

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
            return redirect()->back()->with('message', 'Order Reschedule Successfully');
        } else if ($request->type == 'hold') {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Hold Order';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Hold Order';
            $order->delivery_note = $request->note;
            $order->save();
            return redirect()->back()->with('message', 'Order Hold Successfully');
        }
    }

    public function pending(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Delivery Pending';
        $data->save();

        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Delivery Pending';
        $order->save();
        return redirect()->back()->with('message', 'Status Changed Successfully');
    }

    public function index()
    {
        // \Cart::clear();

        //  $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();

        if (Auth::user()->role == 8) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $rider = User::orderBy('id', 'DESC')->where('id', 4)->get();
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('merchants.*', 'orders.*', 'order_confirms.*')
                ->whereIn('orders.area', $my_array)
                ->get();

            return view('Admin.PickUpRequestAssign.deliveryAssign', compact('order', 'rider', 'user'));
        } elseif (Auth::user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $rider = User::orderBy('id', 'DESC')->where('id', 4)->get();
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('merchants.*', 'orders.*', 'order_confirms.*')
                ->whereIn('orders.area', $my_array)
                ->get();

            return view('Admin.PickUpRequestAssign.deliveryAssign', compact('order', 'rider', 'user'));
        }
    }

    public function delivery_assign_by_scan(Request $request)
    {
        if (Auth::user()->role == 8) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $rider = User::orderBy('id', 'DESC')->where('id', 4)->get();
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('merchants.*', 'orders.*', 'order_confirms.*')
                ->whereIn('orders.area', $my_array)
                ->get();

            return view('Admin.PickUpRequestAssign.deliveryAssignbyScan', compact('order', 'rider', 'user'));
        } elseif (Auth::user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $rider = User::orderBy('id', 'DESC')->where('id', 4)->get();
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('merchants.*', 'orders.*', 'order_confirms.*')
                ->whereIn('orders.area', $my_array)
                ->get();

            return view('Admin.PickUpRequestAssign.deliveryAssignbyScan', compact('order', 'rider', 'user'));
        }
    }

    public function scan_search(Request $request)
    {

        // if (Auth::user()->role == 8) {
        //     $agent = Agent::where('user_id', Auth::user()->id)->first();
        //     $area = $agent->area;

        //     $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
        //     $my_array = $area_list->pluck('area');


        //     $order = Order::orderBy('order_confirms.id', 'DESC')
        //         ->where('orders.tracking_id', $request->name)
        //         ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
        //         ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //         ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //         ->select('merchants.*', 'orders.*', 'order_confirms.*')
        //         ->whereIn('orders.area', $my_array)
        //         ->get();




        //     // Session()->forget('key');
        //     $cart = FacadesSession::get('key');

        //     $cart[$order[0]->id] = array(
        //         "id" => $order[0]->id,
        //         "tracking_id" => $order[0]->tracking_id,
        //         "business_name" => $order[0]->business_name,
        //         "customer_name" => $order[0]->customer_name,
        //         "customer_phone" => $order[0]->customer_phone,
        //         "customer_address" => $order[0]->customer_address,
        //         "area" => $order[0]->area,
        //         "type" => $order[0]->type,
        //         "collection" => $order[0]->collection,
        //         "status" => $order[0]->status,
        //     );
        //     FacadesSession::put('key', $cart);
        // }
        // \Toastr::success('Successfully Order Created.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        try {
            if (Auth::user()->role == 8) {
                $agent = Agent::where('user_id', Auth::user()->id)->first();
                $area = $agent->area;

                $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
                $my_array = $area_list->pluck('area');

                $order = Order::orderBy('order_confirms.id', 'DESC')
                    ->where('orders.tracking_id', $request->name)
                    ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('merchants.*', 'orders.*', 'order_confirms.*')
                    ->whereIn('orders.area', $my_array)
                    ->get();

                $cart = FacadesSession::get('key');

                if (isset($cart[$order[0]->id])) {
                    \Toastr::success('Already Exits please Try Another one.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                } else {
                    $cart[$order[0]->id] = array(
                        "id" => $order[0]->id,
                        "tracking_id" => $order[0]->tracking_id,
                        "business_name" => $order[0]->business_name,
                        "customer_name" => $order[0]->customer_name,
                        "customer_phone" => $order[0]->customer_phone,
                        "customer_address" => $order[0]->customer_address,
                        "area" => $order[0]->area,
                        "type" => $order[0]->type,
                        "collection" => $order[0]->collection,
                        "status" => $order[0]->status,
                    );
                }
                FacadesSession::put('key', $cart);
                \Toastr::success('Delivery Assign Scan Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            }
        } catch (\Exception $e) {
            // Handle the exception here, such as logging it or displaying an error message
            \Toastr::error('Data Not Found. ', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        }
    }

    public function export_search(Request $request)
    {
        try {
            if (Auth::user()->role == 1 || Auth::user()->role == 8) {


                $order = Order::orderBy('order_confirms.id', 'DESC')
                    ->where('orders.tracking_id', $request->name)
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('merchants.*', 'orders.*', 'order_confirms.*')
                    ->get();

                $cart = FacadesSession::get('demo');

                if (isset($cart[$order[0]->id])) {
                    \Toastr::success('Already Exits please Try Another one.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                } else {
                    $cart[$order[0]->id] = array(
                        "id" => $order[0]->id,
                        "tracking_id" => $order[0]->tracking_id,
                        "business_name" => $order[0]->business_name,
                        "customer_name" => $order[0]->customer_name,
                        "customer_phone" => $order[0]->customer_phone,
                        "customer_address" => $order[0]->customer_address,
                        "area" => $order[0]->area,
                        "type" => $order[0]->type,
                        "collection" => $order[0]->collection,
                        "collect" => $order[0]->collect,
                        "status" => $order[0]->status,
                    );
                }
                FacadesSession::put('demo', $cart);
                \Toastr::success('Order Added Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            }
        } catch (\Exception $e) {
            // Handle the exception here, such as logging it or displaying an error message
            \Toastr::error('Data Not Found. ', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        }
    }
    public function scan_remove(Request $request)
    {
        foreach ($request->tracking_ids as $id) {

            $cart = FacadesSession::get('demo');

            $trackingIdToRemove = $id;

            foreach ($cart as $orderId => $orderDetails) {

                if ($orderDetails['tracking_id'] === $trackingIdToRemove) {

                    unset($cart[$orderId]);
                }
            }


            FacadesSession::put('demo', $cart);
        }

        \Toastr::error('Ordered Removed Successfully .', 'remove!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        return redirect()->back();
    }

    public function  order_export(Request $request)
    {
        return view('Admin.PickUpRequestAssign.order_export');
    }


    public function agentReturnList(Request $request)
    {
        // return "sfgjhdfjkghdfj";
        if (auth()->user()->role == 8) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
          
            $area = $agent->area;

            // $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            // $my_array = $area_list->pluck('area');
            $orderlist = Order::orderBy('orders.id', 'DESC')
                ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('merchants', 'merchants.user_id', 'orders.user_id')
                ->select('orders.*', 'merchants.business_name as business_name')
                ->where('merchants.area', $area)
                ->get()->unique('user_id');
            $merchants = $orderlist;

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            // $rider = User::orderBy('id', 'DESC')->where('id', 4)->get();
            // $order = Order::orderBy('order_confirms.id', 'DESC')
            //     ->where('orders.status', 'Return Received By Destination Hub')
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->join('merchants', 'merchants.user_id', 'shops.user_id')
            //     ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_address as shop_address', 'shops.shop_area as shop_area', 'merchants.business_name as business_name')
            //     ->where('shops.shop_area', $area)
            //     ->get();
            $order = [];
            $selectedMerchant = '';
            return view('Admin.PickUpRequestAssign.returnAssignToRider', compact('order',  'user', 'merchants', 'selectedMerchant'));
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;

            // $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            // $my_array = $area_list->pluck('area');
            $orderlist = Order::orderBy('orders.id', 'DESC')
                ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('merchants', 'merchants.user_id', 'orders.user_id')
                ->select('orders.*', 'merchants.business_name as business_name')
                ->where('merchants.area', $area)
                ->get()->unique('user_id');
            $merchants = $orderlist;

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            // $rider = User::orderBy('id', 'DESC')->where('id', 4)->get();
            // $order = Order::orderBy('order_confirms.id', 'DESC')
            //     ->where('orders.status', 'Return Received By Destination Hub')
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->join('merchants', 'merchants.user_id', 'shops.user_id')
            //     ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_address as shop_address', 'shops.shop_area as shop_area', 'merchants.business_name as business_name')
            //     ->where('shops.shop_area', $area)
            //     ->get();
            $order = [];
            $selectedMerchant = '';
            return view('Admin.PickUpRequestAssign.returnAssignToRider', compact('order',  'user', 'merchants', 'selectedMerchant'));
        }
    }
    public function agentReturnListScan(Request $request)
    {
        // $agent = Agent::where('user_id', Auth::user()->id)->first();
        // $area = $agent->area;

        // // $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
        // // $my_array = $area_list->pluck('area');
        // $orderlist = Order::orderBy('orders.id', 'DESC')
        //     ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
        //     ->join('merchants', 'merchants.user_id', 'orders.user_id')
        //     ->select('orders.*', 'merchants.business_name as business_name')
        //     ->where('merchants.area', $area)
        //     ->get()->unique('user_id');
        // $merchants = $orderlist;

        // $user = User::orderBy('id', 'DESC')
        //     ->join('riders', 'users.id', 'riders.user_id')
        //     ->select('riders.area', 'users.*')
        //     ->where('riders.area', $area)
        //     ->where('users.role', 10)
        //     ->get();

        // // $rider = User::orderBy('id', 'DESC')->where('id', 4)->get();
        // // $order = Order::orderBy('order_confirms.id', 'DESC')
        // //     ->where('orders.status', 'Return Received By Destination Hub')
        // //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        // //     ->join('shops', 'orders.shop', 'shops.shop_name')
        // //     ->join('merchants', 'merchants.user_id', 'shops.user_id')
        // //     ->select('orders.*', 'order_confirms.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_address as shop_address', 'shops.shop_area as shop_area', 'merchants.business_name as business_name')
        // //     ->where('shops.shop_area', $area)
        // //     ->get();
        // $order = [];
        // $selectedMerchant = '';
        // if (!$request->merchant) {
        //     \Toastr::warning('Please! Select Merchant ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        //     return redirect()->back();
        // }

        $selectedMerchant = $request->merchant;

        $agent = Agent::where('user_id', Auth::user()->id)->first();
        $area = $agent->area;
        $orderlist = Scan::orderBy('scans.id', 'DESC')
            ->whereIn('scans.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
            ->join('merchants', 'merchants.user_id', 'scans.user_id')
            ->select('scans.*', 'merchants.business_name as business_name')
            ->where('merchants.area', $area)
            ->get()->unique('user_id');
        $merchants = $orderlist;

        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();


        if ($selectedMerchant) {
            $order = Scan::orderBy('order_confirms.id', 'DESC')
                ->whereIn('scans.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'scans.user_id')
                ->join('merchants', 'merchants.user_id', 'scans.user_id')
                ->select('scans.*', 'order_confirms.*', 'merchants.*', 'users.*')
                ->where('merchants.area', $area)
                ->where('merchants.user_id', $selectedMerchant)
                ->get()->unique('tracking_id');
        } else {
            $order = Scan::orderBy('order_confirms.id', 'DESC')
                ->whereIn('scans.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'scans.user_id')
                ->join('merchants', 'merchants.user_id', 'scans.user_id')
                ->select('scans.*', 'order_confirms.*', 'merchants.*', 'users.*')
                // ->where('merchants.area', $area)
                // ->where('merchants.user_id', $selectedMerchant)
                ->get()->unique('tracking_id');
        }
        return view('Admin.PickUpRequestAssign.returnAssignToRiderScan', compact('order',  'user', 'merchants', 'selectedMerchant'));
    }
    public function agentReturnListScanStore(Request $request)
    {
        $order = Order::where('orders.tracking_id', $request->name)
            ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
            ->join('merchants', 'merchants.user_id', 'orders.user_id')
            ->select('orders.*', 'merchants.business_name as bus_name')
            ->first();

        if ($order == []) {
            \Toastr::error('Order not found or does not meet criteria.', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }

        if ($order) {
            // Check if the tracking ID already exists in the scans table
            $existingScan = DB::table('scans')->where('tracking_id', $order->tracking_id)->first();

            if (!$existingScan) {
                // Insert into scans table only if the tracking ID does not exist
                DB::table('scans')->insert([
                    'tracking_id' => $order->tracking_id,
                    'user_id' => $order->user_id,
                    'business_name' => $order->bus_name,
                    'customer_name' => $order->customer_name,
                    'customer_phone' => $order->customer_phone,
                    'customer_address' => $order->customer_address,
                    'area' => $order->area,
                    'inside' => $order->inside,
                    'type' => $order->type,
                    'status' => $order->status,
                ]);
                \Toastr::success('Return Assign Confirmed Scan Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            } else {
                // Show Toastr error message and redirect back
                \Toastr::error('This Item already exists.Please Try Another One', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }
        } else {
            // Show Toastr error message and redirect back
            \Toastr::error('Order not found or does not meet criteria.', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
    }
    public function agentReturnLoad(Request $request)
    {
        // return $request->all();
        if (auth()->user()->role == 8) {
            if (!$request->merchant) {
                \Toastr::warning('Please! Select Merchant ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }

            $selectedMerchant = $request->merchant;

            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;
            $orderlist = Order::orderBy('orders.id', 'DESC')
                ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('merchants', 'merchants.user_id', 'orders.user_id')
                ->select('orders.*', 'merchants.business_name as business_name')
                ->where('merchants.area', $area)
                ->get()->unique('user_id');
            $merchants = $orderlist;

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();


            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'orders.user_id')
                ->join('merchants', 'merchants.user_id', 'orders.user_id')
                ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
                ->where('merchants.area', $area)
                ->where('merchants.user_id', $selectedMerchant)
                ->get()->unique('tracking_id');
            return view('Admin.PickUpRequestAssign.returnAssignToRider', compact('order', 'user', 'merchants', 'selectedMerchant'));
        } elseif (auth()->user()->role == 18) {
            if (!$request->merchant) {
                \Toastr::warning('Please! Select Merchant ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }

            $selectedMerchant = $request->merchant;

            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();

            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;
            $orderlist = Order::orderBy('orders.id', 'DESC')
                ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('merchants', 'merchants.user_id', 'orders.user_id')
                ->select('orders.*', 'merchants.business_name as business_name')
                ->where('merchants.area', $area)
                ->get()->unique('user_id');
            $merchants = $orderlist;

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();


            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereIn('orders.status', ['Return Received By Destination Hub', 'Delivery  Cancel Approved by Fulfillment'])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'orders.user_id')
                ->join('merchants', 'merchants.user_id', 'orders.user_id')
                ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
                ->where('merchants.area', $area)
                ->where('merchants.user_id', $selectedMerchant)
                ->get()->unique('tracking_id');
            return view('Admin.PickUpRequestAssign.returnAssignToRider', compact('order', 'user', 'merchants', 'selectedMerchant'));
        }
    }

    /**
     * Undocumented function
     *
     * @param Agent|null $agent
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function agentReturnStore(Request $request)
    {
        //   return   $request->all();
        // $validated = $request->validate([
        //     'rider' => 'required',
        //     'merchnt' => 'required',
        // ]);

        $id_data = ReturnAssign::latest('id')->take(1)->value('id');

        if ($id_data) {

            $latest_id = $id_data;
        } else {

            $latest_id = 0;
        }
        $invoice_id = 'RTM' . rand(1111, 9999) . $latest_id;
        //Get Shop Info by Shop Name
        // $shop = Shop::where('shop_name', $request->shop_name)->first();

        if ($request->tracking_ids) {

            //id	invoice_id	merchant_id	shop	rider_id	status	security_code	create_by	update_by	created_at	updated_at	
            $user = User::where('users.id', $request->merchant)->join('merchants', 'merchants.user_id', 'users.id',)->first();
            $rand = rand(1111, 9999);
            $history = new ReturnAssign();
            $history->invoice_id  = $invoice_id;
            $history->merchant_id      = $request->merchant;
            $history->rider_id       = $request->rider;
            $history->shop       = $request->merchant;
            $history->status       = 'Assigned Rider For Return';
            $history->security_code       = $rand;
            $history->create_by       = Auth::user()->id;
            $history->update_by       = null;
            $history->save();

            foreach ($request->tracking_ids as $id) {

                $history = new OrderStatusHistory();
                $history->tracking_id  = $id;
                $history->user_id      = $request->rider;
                $history->status       = 'Assigned Rider For Return';
                $history->save();

                //
                $return = new ReturnAssignDetail();
                $return->tracking_id  = $id;
                $return->invoice_id      = $invoice_id;
                $return->save();

                $order = Order::where('tracking_id', $id)->first();
                $order->status = 'Assigned Rider For Return';
                $order->save();
            }
            //send Sms 
            $rider = User::where('id', $request->rider)->first();

            // $text = "প্রিয় গ্রাহক , আপনার রিটার্ন নিয়ে ZIPPY DELIVERY থেকে ডেলিভারি ম্যান:{$rider->name} মোবাইল:{$rider->mobile} বের হয়েছে। আপনার সিকিউরিটি কোডটি হচ্ছে:{$rand} www.zippy.com.bd অথবা টেলিফোন:09606669556 ।";
            $company = Company::where('id', 1)->first();
            $text = "Dear Valued Merchant,\nYour return parcel was carried by {$rider->name}-{$rider->mobile} from {$company->name}. \nYour security code is {$rand}. \nThanks\n{$company->website}or Tel:{$company->mobile} .";

            Helpers::sms_send($user->mobile, $text);



            $aktaidlagbe = ReturnAssign::latest('id')->take(1)->value('id');
            //Toast Message and reload
            \Toastr::success('Successfully Return Assign Confirmed.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            //return redirect()->route('admin.move.return.assign.print', $aktaidlagbe);
            return redirect()->back();
        } else {
            //Toast Message and reload
            \Toastr::warning('Something Went to wrong. Please ! try again.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }






        // return redirect()->back()->with('message', 'Delivery Assign Confirmed.');
        //Toast Message and reload
        // \Toastr::success('Successfully Delivery Assign Confirmed.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        // return redirect()->back();
    }

    public function agentReturnStoreScan(Request $request)
    {
        $id_data = ReturnAssign::latest('id')->take(1)->value('id');

        if ($id_data) {

            $latest_id = $id_data;
        } else {

            $latest_id = 0;
        }
        $invoice_id = 'RTM' . rand(1111, 9999) . $latest_id;
        //Get Shop Info by Shop Name
        // $shop = Shop::where('shop_name', $request->shop_name)->first();

        if ($request->tracking_ids) {

            //id	invoice_id	merchant_id	shop	rider_id	status	security_code	create_by	update_by	created_at	updated_at	
            $user = User::where('users.id', $request->merchant)->join('merchants', 'merchants.user_id', 'users.id',)->first();
            $rand = rand(1111, 9999);
            $history = new ReturnAssign();
            $history->invoice_id  = $invoice_id;
            $history->merchant_id      = $request->merchant;
            $history->rider_id       = $request->rider;
            $history->shop       = $request->merchant;
            $history->status       = 'Assigned Rider For Return';
            $history->security_code       = $rand;
            $history->create_by       = Auth::user()->id;
            $history->update_by       = null;
            $history->save();

            foreach ($request->tracking_ids as $id) {

                $history = new OrderStatusHistory();
                $history->tracking_id  = $id;
                $history->user_id      = $request->rider;
                $history->status       = 'Assigned Rider For Return';
                $history->save();

                //
                $return = new ReturnAssignDetail();
                $return->tracking_id  = $id;
                $return->invoice_id      = $invoice_id;
                $return->save();

                $order = Order::where('tracking_id', $id)->first();
                $order->status = 'Assigned Rider For Return';
                $order->save();
            }

            foreach ($request->tracking_ids as $id) {
                Scan::where('tracking_id', $id)->delete();
            }
            //send Sms 
            $rider = User::where('id', $request->rider)->first();

            // $text = "প্রিয় গ্রাহক , আপনার রিটার্ন নিয়ে ZIPPY DELIVERY থেকে ডেলিভারি ম্যান:{$rider->name} মোবাইল:{$rider->mobile} বের হয়েছে। আপনার সিকিউরিটি কোডটি হচ্ছে:{$rand} www.zippy.com.bd অথবা টেলিফোন:09606669556 ।";
            $company = Company::where('id', 1)->first();
            $text = "Dear Valued Merchant,\nYour return parcel was carried by {$rider->name}-{$rider->mobile} from {$company->name}. \nYour security code is {$rand}. \nThanks\n{$company->website}or Tel:{$company->mobile} .";

            Helpers::sms_send($user->mobile, $text);



            $aktaidlagbe = ReturnAssign::latest('id')->take(1)->value('id');
            //Toast Message and reload
            \Toastr::success('Successfully Return Assign Confirmed.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            //return redirect()->route('admin.move.return.assign.print', $aktaidlagbe);
            return redirect()->back();
        } else {
            //Toast Message and reload
            \Toastr::warning('Something Went to wrong. Please ! try again.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
    }

    /**
     * Undocumented function
     *
     * @param ReturnAssign $returnasign
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function agentReturnPrint(ReturnAssign $returnasign)
    {
        $invid = $returnasign->invoice_id;

        $returnasigns_name = ReturnAssignDetail::where('invoice_id', $invid)
            ->join('orders', 'return_assign_details.tracking_id', 'orders.tracking_id')
            ->join('order_confirms', 'return_assign_details.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('merchants.*', 'users.*', 'orders.*', 'return_assign_details.*', 'order_confirms.*')
            ->first();

        $returnasigns = ReturnAssignDetail::where('invoice_id', $invid)
            ->join('orders', 'return_assign_details.tracking_id', 'orders.tracking_id')
            ->join('order_confirms', 'return_assign_details.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('merchants.*', 'users.*', 'orders.*', 'return_assign_details.*', 'order_confirms.*')
            ->get();

        $company = Company::first();
        return view('Backend.Report.print', compact('invid', 'returnasigns_name', 'returnasigns', 'company'));
    }

    public function add(Request $request, $id)
    {
        $orders = Order::where('tracking_id', $id)->first();
        \Cart::add(array(
            'id'         => $orders->tracking_id,
            'name'       => $orders->order_id,
            'price'      => '',
            'quantity'   => 1,
            'attributes' => array(
                'customer_name'  => $orders->customer_name,
                'customer_mobile'  => $orders->customer_mobile,
                'customer_address'  => $orders->customer_address,
                'area'          => $orders->area,
                'collection'    => $orders->collection,
                'merchant_pay'  => $orders->merchant_pay,
                'pickup_date'   => $orders->pickup_date,
                'pickup_time'   => $orders->pickup_time
            )
        ));
        $msg = "Delivery Assigned To Rider";
        $request->session()->flash('message', $msg);
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->back()->with('message', 'Order Delivery Removed ');
    }

    public function confirm()
    {
        $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
        $agent = Agent::where('user_id', $demo->hub_id)->first();
        $area = $agent->area;
        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        return view('Admin.PickUpRequestAssign.deliveryConfirm', compact('user'));
    }

    public function con_firm(Request $request)
    {
        // return $request;

        foreach ($request->tracking_ids as $id) {

            $history = new OrderStatusHistory();
            $history->tracking_id  = $id;
            $history->user_id      = $request->rider;
            $history->status       = 'Assigned To Delivery Rider';
            $history->save();

            $rand = rand(1111, 9999);
            $order = Order::where('tracking_id', $id)->first();
            $order->status = 'Assigned To Delivery Rider';
            $order->security_code = $rand;
            $order->save();

            $data = DeliveryAssign::where('tracking_id', $id)->first();

            if ($data) {
                $deliver_assign = DeliveryAssign::where('tracking_id', $id)->first();
                $deliver_assign->user_id = $request->rider;
                $deliver_assign->save();
            } else {

                $mdata = array(
                    'tracking_id'   => $id,
                    'user_id'       => $request->rider,
                );
                $insert = DB::table('delivery_assigns')->insert($mdata);
            }
            // $company = Company::where('id', 1)->first();

            // //Send Sms To Customer
            // $data =  Order::where('tracking_id', $id)->join('merchants', 'orders.user_id', 'merchants.user_id',)->first();
            // $riderInfo = User::where('id', $request->rider)->first();
            // // $text = "Dear Valued Customer,\nYour Parcel form {$data->business_name} is on the way to Delivery with {$riderInfo->name} - {$riderInfo->mobile}. Please share this code: {$rand} with Rider for confirmation while receiving the parcel. For Track: {$company->website}/tracking_details?tracking_id={$id} \nThanks\n{$company->name}";
            // $text = "Dear Valued Customer,\nYour Parcel form {$data->business_name} is on the way to Delivery with {$riderInfo->name} - {$riderInfo->mobile}. For Track: {$company->website}/tracking_details?tracking_id={$id} \nThanks\n{$company->name}";

            // Helpers::sms_send($order->customer_phone, $text);
        }

        \Toastr::success('Delivery Assign Confirmed.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        return redirect()->back();
    }

    public function confirm_scan(Request $request)
    {
        // return $request;

        foreach ($request->tracking_ids as $id) {

            $history = new OrderStatusHistory();
            $history->tracking_id  = $id;
            $history->user_id      = $request->rider;
            $history->status       = 'Assigned To Delivery Rider';
            $history->save();

            $rand = rand(1111, 9999);
            $order = Order::where('tracking_id', $id)->first();
            $order->status = 'Assigned To Delivery Rider';
            $order->security_code = $rand;
            $order->save();

            $data = DeliveryAssign::where('tracking_id', $id)->first();

            if ($data) {
                $deliver_assign = DeliveryAssign::where('tracking_id', $id)->first();
                $deliver_assign->user_id = $request->rider;
                $deliver_assign->save();
            } else {

                $mdata = array(
                    'tracking_id'   => $id,
                    'user_id'       => $request->rider,
                );
                $insert = DB::table('delivery_assigns')->insert($mdata);
            }
            // $company = Company::where('id', 1)->first();

            // //Send Sms To Customer
            // $data =  Order::where('tracking_id', $id)->join('merchants', 'orders.user_id', 'merchants.user_id',)->first();
            // $riderInfo = User::where('id', $request->rider)->first();
            // // $text = "Dear Valued Customer,\nYour Parcel form {$data->business_name} is on the way to Delivery with {$riderInfo->name} - {$riderInfo->mobile}. Please share this code: {$rand} with Rider for confirmation while receiving the parcel. For Track: {$company->website}/tracking_details?tracking_id={$id} \nThanks\n{$company->name}";
            // $text = "Dear Valued Customer,\nYour Parcel form {$data->business_name} is on the way to Delivery with {$riderInfo->name} - {$riderInfo->mobile}. For Track: {$company->website}/tracking_details?tracking_id={$id} \nThanks\n{$company->name}";

            // Helpers::sms_send($order->customer_phone, $text);


            $cart = FacadesSession::get('key');


            $trackingIdToRemove = $id;

            foreach ($cart as $orderId => $orderDetails) {

                if ($orderDetails['tracking_id'] === $trackingIdToRemove) {

                    unset($cart[$orderId]);
                }
            }


            FacadesSession::put('key', $cart);
        }

        \Toastr::success('Delivery Assign Confirmed.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        return redirect()->back();
    }

    /**
     *
     * @return \Illuminate\Http\Response
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function delivered_order()
    {
        // asifmane 
        if (auth()->user()->role == 8) {
            $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                ->where('users.id', Auth::user()->id)->first();
            $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
            $my_array = $area_l->pluck('area');
            $riders = User::orderBy('id', 'DESC')->where('role', 10)->get();

            $order = Order::orderBy('orders.id', 'DESC')

                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('orders.status', ['Delivered Amount Collected from Branch', 'Partially Delivered Received from Branch'])
                ->whereIn('orders.area', $my_array)
                ->get();
            $total = $order->sum('collect');

            return view('Admin.PickUpRequestAssign.deliveredOrder', compact('order', 'riders', 'total'));
        } elseif (auth()->user()->role == 18) {
            $demo =  DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                ->where('users.id', $demo->hub_id)->first();
            $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
            $my_array = $area_l->pluck('area');
            $riders = User::orderBy('id', 'DESC')->where('role', 10)->get();

            $order = Order::orderBy('orders.id', 'DESC')

                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('orders.status', ['Delivered Amount Collected from Branch', 'Partially Delivered Received from Branch'])
                ->whereIn('orders.area', $my_array)
                ->get();
            $total = $order->sum('collect');

            return view('Admin.PickUpRequestAssign.deliveredOrder', compact('order', 'riders', 'total'));
        }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function rider_payment()
    {
        // return "skghdfg";
        // return $request->all();
        // return "list";

        if (auth()->user()->role == 8) {
            $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                ->where('users.id', Auth::user()->id)->first();
            $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

            $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
            $my_array = $area_l->pluck('area');

            // $order = Order::orderBy('orders.id', 'DESC')

            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->join('merchants', 'shops.user_id', 'merchants.user_id')
            //     ->select('orders.*', 'shops.shop_phone as shop_phone', 'shops.pickup_address as pickup_address', 'merchants.*')
            //     ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
            //     ->where('orders.area', $user->area)
            //     ->get();

            $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                ->join('users', 'users.id', 'riders.user_id')
                ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'order_confirms.*', 'users.name as rider_name')
                ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
                // ->where('delivery_assigns.user_id', Auth::user()->id)->distinct('orders.tracking_id')
                ->whereIn('orders.area', $my_array)
                ->get();
            $total = $order->sum('collect');
            $rider_id = '';


            //return [$order,$user];
            // return $order;


            return view('Admin.PickUpRequestAssign.rider-payment', compact('order', 'riders', 'total', 'rider_id'));
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                ->where('users.id', $demo->hub_id)->first();
            $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

            $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
            $my_array = $area_l->pluck('area');

            // $order = Order::orderBy('orders.id', 'DESC')

            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->join('merchants', 'shops.user_id', 'merchants.user_id')
            //     ->select('orders.*', 'shops.shop_phone as shop_phone', 'shops.pickup_address as pickup_address', 'merchants.*')
            //     ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
            //     ->where('orders.area', $user->area)
            //     ->get();

            $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                ->join('users', 'users.id', 'riders.user_id')
                ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'order_confirms.*', 'users.name as rider_name')
                ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
                // ->where('delivery_assigns.user_id', Auth::user()->id)->distinct('orders.tracking_id')
                ->whereIn('orders.area', $my_array)
                ->get();
            $total = $order->sum('collect');
            $rider_id = '';


            //return [$order,$user];
            // return $order;


            return view('Admin.PickUpRequestAssign.rider-payment', compact('order', 'riders', 'total', 'rider_id'));
        }
    }

    public function rider_payment_print(Request $request)
    {

        //dd($request->all());
        //  $rider_id = $request->rider;
        if (!$request->rider_id) {
            // return redirect()->route('delivered.order.rider.payment')->with('message', 'Can not Collect');
            return redirect()->back()->with('message', 'please select rider');
        }

        if (auth()->user()->role == 8) {
            if ($request->rider_id) {

                $company = Company::first();
                $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                    ->where('users.id', Auth::user()->id)->first();

                $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
                $my_array = $area_l->pluck('area');

                $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

                $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                    ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                    ->join('users', 'users.id', 'riders.user_id')
                    ->select('delivery_assigns.user_id as rider_id', 'orders.*', 'merchants.business_name as business_name', 'order_confirms.*', 'users.name as rider_name')
                    ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
                    ->where('delivery_assigns.user_id',  $request->rider_id)
                    ->whereIn('orders.area', $my_array)
                    ->get();
                $total = $order->sum('collect');
                $rider_id = $request->rider;
                return view('Admin.PickUpRequestAssign.rider-payment-print', compact('order', 'company', 'riders', 'total', 'rider_id'));
            } else {
                $company = Company::first();

                $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                    ->where('users.id', Auth::user()->id)->first();
                $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

                $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
                $my_array = $area_l->pluck('area');

                // $order = Order::orderBy('orders.id', 'DESC')

                //     ->join('shops', 'orders.shop', 'shops.shop_name')
                //     ->join('merchants', 'shops.user_id', 'merchants.user_id')
                //     ->select('orders.*', 'shops.shop_phone as shop_phone', 'shops.pickup_address as pickup_address', 'merchants.*')
                //     ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
                //     ->where('orders.area', $user->area)
                //     ->get();

                $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                    ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                    ->join('users', 'users.id', 'riders.user_id')
                    ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'order_confirms.*', 'users.name as rider_name')
                    ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
                    // ->where('delivery_assigns.user_id', Auth::user()->id)->distinct('orders.tracking_id')
                    ->whereIn('orders.area', $my_array)
                    ->get();
                $total = $order->sum('collect');
                $rider_id = '';

                return view('Admin.PickUpRequestAssign.rider-payment-print', compact('order', 'company', 'riders', 'total', 'rider_id'));
            }
        } elseif (auth()->user()->role == 18) {
            if ($request->rider_id) {

                $company = Company::first();
                $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
                $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                    ->where('users.id', $demo->hub_id)->first();

                $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
                $my_array = $area_l->pluck('area');

                $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

                $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                    ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                    ->join('users', 'users.id', 'riders.user_id')
                    ->select('delivery_assigns.user_id as rider_id', 'orders.*', 'merchants.business_name as business_name', 'order_confirms.*', 'users.name as rider_name')
                    ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
                    ->where('delivery_assigns.user_id',  $request->rider_id)
                    ->whereIn('orders.area', $my_array)
                    ->get();
                $total = $order->sum('collect');
                $rider_id = $request->rider;
                return view('Admin.PickUpRequestAssign.rider-payment-print', compact('order', 'company', 'riders', 'total', 'rider_id'));
            } else {
                $company = Company::first();
                $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
                $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                    ->where('users.id', $demo->hub_id)->first();
                $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

                $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
                $my_array = $area_l->pluck('area');

                // $order = Order::orderBy('orders.id', 'DESC')

                //     ->join('shops', 'orders.shop', 'shops.shop_name')
                //     ->join('merchants', 'shops.user_id', 'merchants.user_id')
                //     ->select('orders.*', 'shops.shop_phone as shop_phone', 'shops.pickup_address as pickup_address', 'merchants.*')
                //     ->whereIn('orders.status', ['Successfully Delivered', 'Partially Delivered'])
                //     ->where('orders.area', $user->area)
                //     ->get();

                $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                    ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                    ->join('users', 'users.id', 'riders.user_id')
                    ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'order_confirms.*', 'users.name as rider_name')
                    ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
                    // ->where('delivery_assigns.user_id', Auth::user()->id)->distinct('orders.tracking_id')
                    ->whereIn('orders.area', $my_array)
                    ->get();
                $total = $order->sum('collect');
                $rider_id = '';

                return view('Admin.PickUpRequestAssign.rider-payment-print', compact('order', 'company', 'riders', 'total', 'rider_id'));
            }
        }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function rider_payment_load(Request $request)
    {
        // return $request->all();
        // return "list";

        //dd($request->all());

        if (auth()->user()->role == 8) {

            $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                ->where('users.id', Auth::user()->id)->first();

            $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
            $my_array = $area_l->pluck('area');

            $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();



            $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                ->join('users', 'users.id', 'riders.user_id')
                ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Exchange Delivered', 'Partially Delivered'])
                ->where('delivery_assigns.user_id', $request->rider)
                ->select('delivery_assigns.user_id as rider_id', 'orders.*', 'merchants.business_name as business_name', 'order_confirms.*', 'users.name as rider_name')
                ->whereIn('orders.area', $my_array)
                ->get();

            //  return $order;


            $total = $order->sum('collect');
            $rider_id = $request->rider;

            return view('Admin.PickUpRequestAssign.rider-payment', compact('order', 'riders', 'total', 'rider_id'));
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
                ->where('users.id', $demo->hub_id)->first();

            $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
            $my_array = $area_l->pluck('area');

            $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

            $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
                ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
                ->join('users', 'users.id', 'riders.user_id')
                ->select('delivery_assigns.user_id as rider_id', 'orders.*', 'merchants.business_name as business_name', 'order_confirms.*', 'users.name as rider_name')
                ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Exchange Delivered', 'Reschedule Order', 'Partially Delivered'])
                ->where('delivery_assigns.user_id', $request->rider)
                ->whereIn('orders.area', $my_array)
                ->get();
            $total = $order->sum('collect');
            $rider_id = $request->rider;

            return view('Admin.PickUpRequestAssign.rider-payment', compact('order', 'riders', 'total', 'rider_id'));
        }
    }


    /**
     *
     * @return \Illuminate\Http\Response
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function rider_payment_store(Request $request)

    {
        // dd($request->all());
        // return redirect()->route('delivered.order.rider.payment')->with('message', 'Can not Collect');
        if (!$request->rider_id || $request->orders === '[]') {
            // return redirect()->route('delivered.order.rider.payment')->with('message', 'Can not Collect');
            return redirect()->back()->with('message', 'Can not Collect');
        }

        $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
            ->where('users.id', Auth::user()->id)->first();
        $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
        $my_array = $area_l->pluck('area');
        // return $my_array;





        // $orders = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
        //     ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
        //     ->where('delivery_assigns.user_id', $request->rider_id)
        //     ->whereIn('orders.area', $my_array)
        //     ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
        //     ->join('users', 'users.id', 'riders.user_id')
        //     ->select('orders.*')
        //     ->get();

        // return $orders;

        $orders = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
            ->join('users', 'users.id', 'riders.user_id')
            ->select('delivery_assigns.user_id as rider_id', 'orders.*', 'merchants.business_name as business_name', 'order_confirms.*', 'users.name as rider_name')
            ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Exchange Delivered', 'Reschedule Order', 'Partially Delivered'])
            ->where('delivery_assigns.user_id', $request->rider_id)
            ->whereIn('orders.area', $my_array)
            ->get();



        // $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
        // ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
        // ->join('merchants', 'orders.user_id', 'merchants.user_id')
        // ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        // ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
        // ->join('users', 'users.id', 'riders.user_id')
        // ->select('delivery_assigns.user_id as rider_id', 'orders.*', 'merchants.business_name as business_name', 'order_confirms.*', 'users.name as rider_name')
        // ->whereIn('orders.status', ['Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
        // ->where('delivery_assigns.user_id', $request->rider)
        // ->whereIn('orders.area', $my_array)
        // ->get();

        //Create new Invoice number 
        $invs = "RPMT";
        $riderLastId = RiderPayment::all()->count() + 1;
        $auth_id = Auth::user()->id;
        $rand_number = rand(111, 999);
        $invoice = $invs . $auth_id . $riderLastId . $rand_number;
        if ($orders) {


            //Save Data From Rider Payment Table
            $data = new RiderPayment();
            $data->invoice_id  = $invoice;
            $data->rider_id      = $request->rider_id;
            $data->status       = 1;
            $data->created_by       = Auth::user()->id;
            $data->save();
            foreach ($orders as $order) {

                //'Successfully Delivered', 'Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
                $status = '';
                if ($order->status === 'Successfully Delivered') {
                    $status = 'Delivered Amount Collected from Branch';
                } else if ($order->status === 'Partially Delivered') {
                    $status = 'Partially Delivered Received from Branch';
                } else if ($order->status === 'Hold Order') {
                    $status = 'Hold Order Received from Branch';
                } else if ($order->status === 'Reschedule Order') {
                    $status = 'Rescheduled';
                } else if ($order->status === 'Cancel Order') {
                    $status = 'Return Confirm';
                } elseif ($order->status === 'Exchange Delivered') {
                    $status = 'Exchange Delivered Received from Branch';
                }
                // return $status;

                if ($status != '') {

                    $data = new OrderStatusHistory();
                    $data->tracking_id  = $order->tracking_id;
                    $data->user_id      = Auth::user()->id;
                    $data->status       = $status;
                    $data->save();

                    $order_data = Order::where('tracking_id', $order->tracking_id)->first();
                    $order_data->status = $status;
                    $order_data->save();

                    if ($status === 'Return Confirm') {

                        $order_confirm = OrderConfirm::where('tracking_id', $order->tracking_id)->first();
                        $order_confirm->cod = 0;
                        $order_confirm->insurance = 0;
                        $order_confirm->save();
                    }

                    if ($status === 'Exchange Delivered Received from Branch') {

                        $order_confirm = OrderConfirm::where('tracking_id', $order->tracking_id)->first();
                        $order_confirm->cod = 0;
                        $order_confirm->insurance = 0;
                        $order_confirm->save();
                    }
                }
                //Save Data in Rider Payment Details Table
                $data = new RiderPaymentDetail();
                $data->invoice_id  = $invoice;
                $data->tracking_id      = $order->tracking_id;
                $data->save();
            }
        }

        // return 'sdjlkfguasjoikasgjoi;[pasg';

        return redirect()->back()->with('message', 'Successfully Collected');
    }




    /**
     *
     * @return \Illuminate\Http\Response
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function order_delivered(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Payment Processing';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Order Delivered') {
            $order->status = 'Payment Processing';
            $order->save();
        }
        return redirect()->back()->with('message', 'Order Delivered Successfully Payment In Processing');
    }


    /**
     *
     * @return \Illuminate\Http\Response
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function pending_delivery(Request $request)
    {
        // return "djfgdfjhg";
        $status = $request->status == null ? ['Hold Order Received from Branch'] : [$request->status];

        $agent = Agent::where('user_id', Auth::user()->id)->first();

        $order_data = Order::orderBy('orders.id', 'DESC')
            ->join('shops', 'shops.shop_name', 'orders.shop')
            ->join('merchants', 'merchants.user_id', 'orders.user_id')
            ->select('orders.*', 'shops.shop_name as shop_name', 'shops.shop_phone as shop_phone', 'shops.shop_address as shop_address', 'shops.pickup_address as pickup_address', 'merchants.business_name as business_name')
            ->where('orders.area', $agent->area)
            ->whereIn('orders.status', $status)
            ->get();

        $order = $order_data->unique('tracking_id');

        return view('Admin.PickUpRequestAssign.pendingDelivery', compact('order', 'status'));
    }


    /**
     *
     * @return \Illuminate\Http\Response
     * @author Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function delivery_pending(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Waiting For Delivery';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Delivery Pending') {
            $order->status = 'Waiting For Delivery';
            $order->save();
        }
        return redirect()->back()->with('message', 'Delivery Returned To Hub & Waiting For Assign Delivery');
    }

    public function headoffice(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Return To Head Office';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Delivery Pending') {
            $order->status = 'Return To Head Office';
            $order->save();
        }
        return redirect()->back()->with('message', 'Onder Returned To Head Office');
    }

    public function head_office()
    {
        $order = Order::orderBy('id', 'DESC')
            ->where('status', 'Return To Head Office')
            ->get();
        return view('Admin.PickUpRequestAssign.returnHeadOffice', compact('order'));
    }

    public function collection(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Collection From Agent';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Return To Head Office') {
            $order->status = 'Collection From Agent';
            $order->save();
        }
        return redirect()->back()->with('message', 'Return Order Collection From Agent');
    }

    public function merchant()
    {
        \Cart::clear();
        $order = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Collection From Agent')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'users.name as merchant', 'users.mobile', 'order_confirms.*')
            ->get();
        return view('Admin.PickUpRequestAssign.returnMerchant', compact('order'));
    }

    public function rider_add(Request $request, $id)
    {
        $orders = Order::where('orders.tracking_id', $id)
            ->join('users', 'orders.user_id', 'users.id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'users.name as merchant', 'users.mobile', 'order_confirms.*')
            ->first();
        \Cart::add(array(
            'id'         => $orders->tracking_id,
            'name'       => $orders->order_id,
            'price'      => '',
            'quantity'   => 1,
            'attributes' => array(
                'area'          => $orders->area,
                'delivery'      => $orders->delivery,
                'insurance'     => $orders->insurance,
                'return'        => $orders->delivery / 2 + $orders->delivery + $orders->insurance,
                'collection'    => $orders->collection,
                'merchant'      => $orders->merchant,
                'mobile'        => $orders->mobile,
            )
        ));
        $msg = "Order Return Assigned To Rider";
        $request->session()->flash('message', $msg);
    }

    public function rider_confirm(Request $request)
    {
        // $agent = Agent::where('user_id', Auth::user()->id)->first();
        // $area = $agent->area;
        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            // ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        return view('Admin.PickUpRequestAssign.returnConfirm', compact('user'));
    }

    public function rider_remove(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->back()->with('message', 'Order Return Removed ');
    }

    public function rider_save(Request $request)
    {
        // $data = new OrderStatusHistory();
        // $data->tracking_id  = $request->id;
        // $data->user_id      = Auth::user()->id;
        // $data->status       = 'Return To Merchant';
        // $data->save();
        // $order = Order::where('tracking_id', $request->id)->first();
        // if ($order->status == 'Collection From Agent') 
        // {
        //     $order->status = 'Return To Merchant';    
        //     $order->save();
        // }
        foreach (\Cart::getContent() as $data) {
            $history = new OrderStatusHistory();
            $history->tracking_id  = $data->id;
            $history->user_id      = Auth::user()->id;
            $history->status       = 'Return To Merchant';
            $history->save();

            $order = Order::where('tracking_id', $data->id)->first();
            $order->status = 'Return To Merchant';
            $order->save();

            $mdata = array(
                'tracking_id'   => $data->id,
                'return_charge' => $data->attributes->return,
                'user_id'       => $request->rider,
            );
            $insert = DB::table('return_assigns')->insert($mdata);
        }
        \Cart::clear();
        // return redirect()->back()->with('message','Order Return Rider Assigned Confirmed.');
        return redirect()->route('order.return.print');
    }

    public function return_print()
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $order = Order::orderBy('orders.id', 'DESC')
            ->where('orders.status', 'Return To Merchant')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('return_assigns', 'orders.tracking_id', 'return_assigns.tracking_id')
            ->select('orders.*', 'users.name as merchant', 'users.mobile', 'return_assigns.*')
            ->get();
        // $data = User::find($order->merchant);
        // $merchant = $data->name;
        // $phone = $data->mobile;
        $Total = $order->sum('collection');
        $Return = $order->sum('return_charge');
        return view(
            'Admin.Report.OrderReturn.return_Invoice',
            compact('company', 'order', 'Total', 'Return')
        );
    }

    // public function return_listdd()
    // {
    //     $order = Order::orderBy('orders.id', 'DESC')
    //                 ->join('users','orders.user_id','users.id')
    //                 ->join('return_assigns','orders.tracking_id','return_assigns.tracking_id')
    //                 ->select('orders.*','return_assigns.user_id','users.name as merchant','users.mobile')
    //                 ->where('orders.status', 'Return To Merchant')
    //                 ->where('return_assigns.user_id', Auth::user()->id)
    //                 ->get();
    //     return view('Admin.PickUpRequestAssign.returnList', compact('order'));
    // }



    /**
     * return_list function
     *
     * @param Order $order
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */

    public function return_list()
    {
        $payments_data = ReturnAssign::latest('return_assigns.id')->with('creator', 'rider', 'updator', 'merchant')
            ->where('return_assigns.rider_id', Auth::user()->id)
            ->where('return_assigns.status', 'Assigned Rider For Return')
            ->join('merchants', 'merchants.user_id', 'return_assigns.merchant_id')
            ->join('users', 'users.id', 'return_assigns.merchant_id')
            ->select('merchants.*', 'users.*', 'return_assigns.*')
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

        return view('Admin.PickUpRequestAssign.returnList', compact('payments_data', 'payments'));
    }


    public function admin_return_merchant(Request $request)
    {


        // $validated = $request->validate([
        //     'security_code' => 'required|max:4|min:4',
        //     'invoice_id' => 'required',
        // ]);
        //return $request->all();

        if (!$request->invoice_id) {
            //Toast Message and reload
            \Toastr::error('Something went to wrong .try again!', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        } else if (!$request->security_code) {
            \Toastr::error('Enter 4 digits security code.', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        } else if (strlen($request->security_code) != 4) {

            \Toastr::error('Needs 4 digits security code.', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        }
        $returnAsign = ReturnAssign::where('invoice_id', $request->invoice_id)->first();

        //Call when return are null
        if (!$returnAsign) {
            \Toastr::error('Something went to wrong .try again!', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
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

            \Toastr::success('Return Products Reach to Merchant', 'Success!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        } else {

            \Toastr::error('Security Code are not valid ', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        }
    }
    public function admin_return_confirm(ReturnAssign $orderinv)
    {
        //return $orderinv->invoice_id;

        $returnAsign = ReturnAssign::where('invoice_id', $orderinv->invoice_id)->first();

        //Call when return are null
        if (!$returnAsign) {
            \Toastr::error('Something went to wrong .try again!', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
            return redirect()->back();
        }
        // return $returnAsign->security_code;



        ReturnAssign::where('invoice_id', $orderinv->invoice_id)
            ->update([
                'status' => 'Return Recived By Merchant'
            ]);
        $returnDetails =     ReturnAssignDetail::where('invoice_id', $orderinv->invoice_id)->get();

        foreach ($returnDetails as $returnDetail) {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $returnDetail->tracking_id;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Return Recived By Merchant';
            $data->save();



            Order::where('tracking_id', $returnDetail->tracking_id)
                ->update([
                    'status' => 'Return Recived By Merchant'
                ]);
        }

        \Toastr::success('Return Received Successfully !', 'Success!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
        return redirect()->back();
    }

    public function merchant_confirm(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Return Confirm';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Return Confirm';
        $order->save();
        return redirect()->back()->with('message', 'Order Return To Merchant Confirm');
    }


    public function branch(Request $request)
    {

        $sel_hub = Session::get('sel_hub');

        if ($request->hub != '' || $sel_hub != '') {


            if ($request->hub == '') {

                $hub = $sel_hub;

                session()->forget('sel_hub');
            } else {

                $hub = $request->hub;
            }

            $agent = Agent::where('user_id', $hub)->first();
            $area = $agent->area;

            $area_list = CoverageArea::where('zone_name', $area)->select('area')->get()->unique('area');
            $my_array = $area_list->pluck('area');

            $user = User::orderBy('id', 'DESC')
                ->join('riders', 'users.id', 'riders.user_id')
                ->select('riders.area', 'users.*')
                ->where('riders.area', $area)
                ->where('users.role', 10)
                ->get();

            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->whereIn('orders.status', ['Received By Destination Hub', 'Order Bypass By Destination Hub'])
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('merchants.*', 'orders.*', 'order_confirms.*')
                ->whereIn('orders.area', $my_array)
                ->get();
        } else {

            $hub = '';
            $order = [];
            $user = [];
        }
        $hub_list = User::where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select(
                'users.name',
                'users.id as uid'
            )->get();





        return view('Admin.PickUpRequestAssign.deliveryAssign_branch', compact('hub', 'hub_list', 'user', 'order'));
    }

    public function branch_con_firm(Request $request)
    {


        Session::put('sel_hub', $request->sel_hub);

        foreach ($request->tracking_ids as $id) {


            $history = new OrderStatusHistory();
            $history->tracking_id  = $id;
            $history->user_id      = $request->rider;
            $history->status       = 'Assigned To Delivery Rider';
            $history->save();

            $rand = rand(1111, 9999);
            $order = Order::where('tracking_id', $id)->first();
            $order->status = 'Assigned To Delivery Rider';
            $order->security_code = $rand;
            $order->save();

            $data = DeliveryAssign::where('tracking_id', $id)->first();

            if ($data) {
                $deliver_assign = DeliveryAssign::where('tracking_id', $id)->first();
                $deliver_assign->user_id = $request->rider;
                $deliver_assign->save();
            } else {

                $mdata = array(
                    'tracking_id'   => $id,
                    'user_id'       => $request->rider,
                );
                $insert = DB::table('delivery_assigns')->insert($mdata);
            }
            $company = Company::where('id', 1)->first();

            //Send Sms To Customer
            $data =  Order::where('tracking_id', $id)->join('merchants', 'orders.user_id', 'merchants.user_id',)->first();
            $riderInfo = User::where('id', $request->rider)->first();
            // $text = "Dear Valued Customer,\nYour Parcel form {$data->business_name} is on the way to Delivery with {$riderInfo->name} - {$riderInfo->mobile}. Please share this code: {$rand} with Rider for confirmation while receiving the parcel. For Track: {$company->website}/tracking_details?tracking_id={$id} \nThanks\n{$company->name}";
            $text = "Dear Valued Customer,\nYour Parcel form {$data->business_name} is on the way to Delivery with {$riderInfo->name} - {$riderInfo->mobile}. For Track: {$company->website}/tracking_details?tracking_id={$id} \nThanks\n{$company->name}";

            Helpers::sms_send($order->customer_phone, $text);
        }



        return redirect()->back()->with('message', 'Delivery Assign Confirmed.');
    }


    public function hold_reschedule(Request $request)
    {

        //  return Auth::user()->id;
        // $user =  User::orderBy('users.id', 'DESC')->join('agents', 'users.id', 'agents.user_id')
        //     ->where('users.id', Auth::user()->id)->first();
        // // return $user;   
        // $riders = User::orderBy('id', 'DESC')->join('riders', 'users.id', 'riders.user_id')->select('users.name as name', 'riders.*')->where('role', 10)->where('area', $user->area)->get();

        // $area_l = CoverageArea::where('zone_name', $user->area)->select('area')->get();
        // $my_array = $area_l->pluck('area');


        $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
            ->join('users', 'users.id', 'riders.user_id')
            ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'order_confirms.*', 'users.name as rider_name')
            ->whereIn('orders.status', ['Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
            // ->where('delivery_assigns.user_id', Auth::user()->id)->distinct('orders.tracking_id')
            //->whereIn('orders.area', $my_array)
            ->where('delivery_assigns.user_id', Auth::user()->id)
            ->get();

        $total = $order->sum('collect');

        // $order_data = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
        //     ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'users.*')
        //     ->where('orders.status', 'Assigned To Delivery Rider')
        //     ->where('delivery_assigns.user_id', Auth::user()->id)
        //     ->get();

        //return $order_data->count();
        $rider_id = '';


        return view('Admin.PickUpRequestAssign.hold_and_reschedule', compact('order', 'rider_id', 'total'));
    }
}
