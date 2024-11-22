<?php

namespace App\Http\Controllers;

use App\Admin\Company;
use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use App\Admin\CoverageArea;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin\Agent;
use App\Admin\BypassReturn;
use App\Admin\Rider;
use App\Admin\Transfer;
use App\Admin\TransferDetail;

class OrderStatusHistoryController extends Controller
{

    public function index()
    {
        $data = OrderStatusHistory::orderBy('order_status_histories.id', 'DESC')
            ->get();
        return view('Admin.Order.order_status_history', compact('data'));
    }

    public function order_status(Request $request)
    {
        $today = date('Y-m-d');
        $merchant = $request->merchant;
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $user = User::where('role', 12)->join('merchants', 'merchants.user_id', 'users.id')->get();
        $order = Order::orderBy('order_confirms.id', 'DESC')
            ->whereBetween('orders.created_at', [$fromdate, $todate])
            ->where('orders.user_id', $merchant)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
            ->get();
        $Qty = $order->count();
        return view(
            'Admin.Report.Order.merchant_order_status',
            compact('order', 'todate', 'fromdate', 'merchant', 'user', 'Qty')
        );
    }

    public function orderstatus(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $data = User::find($request->merchant);
        $merchant = $data->name;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $order = Order::orderBy('order_confirms.id', 'DESC')
            ->whereBetween('orders.created_at', [$fromdate, $todate])
            ->where('orders.user_id', $request->merchant)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
            ->get();
        $Qty = $order->count();
        return view(
            'Admin.Report.Order.merchant_order_status_print',
            compact('order', 'todate', 'fromdate', 'merchant', 'Qty', 'company')
        );
    }

    public function inCollectionHub()
    {
        $agent = Agent::where('user_id', Auth::user()->id)->first();
        $area = $agent->area;
        $riders = Rider::where('area', $area)->join('users', 'riders.user_id', 'users.id')->get();

        $data = Order::orderBy('order_confirms.id', 'DESC')
            // ->where('orders.pickup_date', $today)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->join('users', 'users.id', 'pick_up_request_assigns.user_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->where('orders.status', 'Pickup Done')
            ->where('merchants.area', $area)
            ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.name as rider_name')
            ->get();
        $selectedRider = '';

        return view('Admin.PickUpRequestAssign.orderCollection', compact('data', 'riders', 'selectedRider'));
    }
    public function inCollectionHubLoad(Request $request)
    {
        $agent = Agent::where('user_id', Auth::user()->id)->first();
        $area = $agent->area;
        $riders = Rider::where('area', $area)->join('users', 'riders.user_id', 'users.id')->get();

        $selectedRider = $request->rider_id;
        $data = Order::orderBy('order_confirms.id', 'DESC')
            // ->where('orders.pickup_date', $today)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
            ->join('users', 'users.id', 'pick_up_request_assigns.user_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->where('orders.status', 'Pickup Done')
            ->where('merchants.area', $area)
            ->where('pick_up_request_assigns.user_id', $selectedRider)
            ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.name as rider_name')
            ->get();


        return view('Admin.PickUpRequestAssign.orderCollection', compact('data', 'riders', 'selectedRider'));
    }

    public function collect(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        //$data->status       = 'In Collected Hub';
        $data->status       = 'Received by Pickup Branch';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Pickup Done') {
            $order->status = 'Received by Pickup Branch';
            $order->save();
        }
        return redirect()->back()->with('message', 'Order Collected In Branch Successfully');
    }
    public function collectAll(Request $request)
    {
        // $request->all();

        $tracking = $request->tracking_ids;
        if (!$tracking) {
            return redirect()->back()->with('message', 'No Order Select ');
        }
        foreach ($tracking as $tracking_id) {
            $data = new OrderStatusHistory();
            $data->tracking_id  = $tracking_id;
            $data->user_id      = Auth::user()->id;
            //$data->status       = 'In Collected Hub';
            $data->status       = 'Received by Pickup Branch';
            $data->save();
            $order = Order::where('tracking_id', $tracking_id)->first();
            if ($order->status == 'Pickup Done') {
                $order->status = 'Received by Pickup Branch';
                $order->save();
            }
        }

        return redirect()->back()->with('message', 'Order Collected In Branch Successfully');
    }
    public function cancel_by_branch(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        //$data->status       = 'In Collected Hub';
        $data->status       = 'Order Cancel by Branch';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Order Cancel by Branch';
        $order->save();
        $bypass = BypassReturn::where('tracking_id', $request->id)->first();
        if ($bypass) {

            BypassReturn::where('tracking_id', $request->id)
                ->update([
                    'status' => 'Order Cancel by Branch'
                ]);

            // $bypass->status = 'Order Cancel by Branch';
            // $bypass->save();
        } else {
            $data = new BypassReturn();
            $data->tracking_id  = $request->id;
            $data->m_id      = $order->user_id;
            $data->create_by       = Auth::user()->id;
            $data->save();
        }

        return redirect()->back()->with('message', 'Order Cancel In Branch Successfully');
    }

    public function cancel(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Pickup Cancel';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Pickup Done') {
            $order->status = 'Pickup Cancel';
            $order->save();
        }
        return redirect()->back()->with('message', 'Order Cancelled  In Branch Successfully');
    }


    public function collect_print(Request $request)
    {


        $company = Company::all();


        $merchant_name = Order::where('tracking_id', $request->id)
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->value('merchants.business_name');

        $merchant_data = Order::where('tracking_id', $request->id)
            ->join('users', 'users.id', 'orders.user_id')
            ->first();



        $order_data = Order::where('tracking_id', $request->id)->first();


        return view('Admin.Order.collect_print', compact('merchant_name', 'order_data', 'merchant_data', 'company'));
    }


    /**
     * Order
     * @param Request $request
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function hub_collection()
    {

        $today = date('Y-m-d');
        $data = Order::orderBy('order_confirms.id', 'DESC')
            // ->where('orders.pickup_date', $today)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')

            ->whereIn('orders.status', ['Reach to Fullfilment', 'Return Reach For Fullfilment'])
            ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
            ->get();
        return view('Admin.PickUpRequestAssign.orderCollection_hub', compact('data'));
    }


    /**
     * Order
     * @param Request $request
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function hub_collection_store(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        //$data->status       = 'In Collected Hub';
        $data->status       = 'Received By Fullfilment';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Reach to Fullfilment') {
            $order->status = 'Received By Fullfilment';
            $order->save();
        }
        return redirect()->back()->with('message', 'Order Collected In Fullfilment Successfully');
    }
    /**
     * Order
     * @param Request $request
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function hub_all_collection_store(Request $request)
    {
        // return "Dgdfg";

        $tracking = $request->tracking_ids;
        foreach ($tracking as $tracking_id) {

            $order = Order::where('tracking_id', $tracking_id)->first();
            if ($order->status == 'Return Reach For Fullfilment') {
                $order->status = 'Return Payment Processing';
                $order->save();
            }
            if ($order->status == 'Reach to Fullfilment') {
                $order->status = 'Received By Fullfilment';
                $order->save();
            }

            $data = new OrderStatusHistory();
            $data->tracking_id  = $tracking_id;
            $data->user_id      = Auth::user()->id;

            if ($order->status == 'Return Reach For Fullfilment') {
                $data->status       = 'Return Received By Fullfilment';
                $data->save();
            }
            if ($order->status == 'Reach to Fullfilment') {
                $data->status    = 'Received By Fullfilment';
                $data->save();
            }
        }

        return redirect()->back()->with('message', 'Order Collected In Fullfilment Successfully');
    }
    /**
     * Order
     * @param Request $request
     * Author: Risad
     * @return void
     */
    public function hub_collection_cancel(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        //$data->status       = 'In Collected Hub';
        $data->status       = 'Order Cancel By Fullfilment';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Reach to Fullfilment') {
            $order->status = 'Order Cancel By Fullfilment';
            $order->save();
        }

        \Toastr::success('Order Cancel By Fullfilment', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }

    /**
     * Order
     * @param Request $request
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function hub_collection_store_return(Request $request)
    {
        // return "ok";
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        //$data->status       = 'In Collected Hub';
        $data->status       = 'Return Received By Fullfilment';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();
        if ($order->status == 'Return Reach For Fullfilment') {
            $order->status = 'Return Payment Processing';
            $order->save();
        }
        return redirect()->back()->with('message', 'Return Collected In Fullfilment Successfully');
    }

    public function transfer(Request $request)
    {
        // return $request->all();

        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            // ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();


        // $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();
        // $array = $invoice_payment_details->map(function ($item) {
        //     return collect($item)->values();
        // });

        //Return To Merchant


        $areas = Order::orderBy('area', 'DESC')->where('status', 'Received By Fullfilment')->select('area')->get()->unique('area');

        $my_array = $areas->pluck('area');
        $area_list = CoverageArea::whereIn('area', $my_array)->get()->unique('zone_name');



        if ($request->area) {

            $area_l = CoverageArea::where('zone_name', $request->area)->select('area')->get();
            $my_array = $area_l->pluck('area');


            $order_data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('orders.status', ['Received By Fullfilment'])
                ->whereIn('orders.area', $my_array)
                ->get();


            $order = $order_data->unique('tracking_id');

            $area = $request->area;
        } else {

            // $order = Order::orderBy('order_confirms.id', 'DESC')
            //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            //     ->join('users', 'orders.user_id', 'users.id')
            //     ->join('shops', 'orders.shop', 'shops.shop_name')
            //     ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
            //     ->where('orders.status', 'Received By Fullfilment')
            //     ->get();
            $order = [];
            $type = '';
            $area = '';
        }


        return view('Admin.PickUpRequestAssign.orderTransfer',  compact('user', 'order', 'rider', 'area_list', 'area'));
    }
    /**
     * Order
     * @param Request $request
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function returnToHub(Request $request)
    {
        // return $request->all();

        // if ($request->area || $request->rider) {
        //     \Toastr::warning('Area Or Rider not selected.', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
        //     return redirect()->back();
        // }

        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            // ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();

        $areas = Order::orderBy('orders.area', 'DESC')->join('merchants', 'merchants.user_id', 'orders.user_id')->where('orders.status', 'Return To Merchant')->select('merchants.area')->get()->unique('area');

        $my_array = $areas->pluck('area');
        $area_list = CoverageArea::whereIn('zone_name', $my_array)->get()->unique('zone_name');


        if ($request->area) {


            $order_data = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
                ->where('orders.status', 'Return To Merchant')
                ->where('merchants.area', $request->area)
                ->get();


            $order = $order_data->unique('tracking_id');

            $area = $request->area;
        } else {
            $order = [];

            $area = '';
        }

        return view('Admin.PickUpRequestAssign.return_to_hub',  compact('user', 'order', 'rider', 'area_list', 'area'));
    }

    /**
     * Order
     * @param Request $request
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function returnToStore(Request $request)
    {
        // return $request->all();
        if (!$request->area) {
            \Toastr::warning('You did not load any data !', 'Warning !!', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }
        //check data 
        if (!$request->tracking_ids) {
            \Toastr::warning('You did not select any data !', 'Warning !!', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }

        // return "ok";
        $agent_id = Agent::where('area', $request->area)->value('user_id');

        $tracking_id = $request->tracking_ids;

        if ($request->rider) {

            $id_data = Transfer::orderBy('id', 'desc')->take(1)->value('id');

            if ($id_data) {

                $latest_id = $id_data;
            } else {

                $latest_id = 0;
            }


            $invoice_id = 'TRRH' . mt_rand(1111, 9999) . $latest_id;

            $transfers = new Transfer();
            $transfers->invoice_id  = $invoice_id;
            $transfers->sender_id  = 1;
            $transfers->receiver_id  = $agent_id;
            $transfers->media_id  = $request->rider;
            $transfers->type  = 'return';
            $transfers->status  = 0;
            $transfers->save();

            if ($tracking_id) {

                foreach ($tracking_id as $id) {
                    $transferdetails = new TransferDetail();
                    $transferdetails->invoice_id  = $invoice_id;
                    $transferdetails->tracking_id  = $id;
                    $transferdetails->created_by      = Auth::user()->id;
                    $transferdetails->updated_by  = Auth::user()->id;
                    $transferdetails->save();

                    $history = new OrderStatusHistory();
                    $history->tracking_id  = $id;
                    $history->user_id      = Auth::user()->id;
                    $history->status       = 'Transfer Assign for Branch';
                    $history->save();

                    $data_exist = DB::table('orders')->where('tracking_id', $id)->first();

                    if ($data_exist) {

                        DB::table('orders')->where('tracking_id', $id)->update(['status' => 'Return Assigned Rider For Destination Hub']);
                    }
                }
            }
        }



        return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
    }

    public function transferArea()
    {
        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->where('orders.status', 'In Collected Hub')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->get();
        $areas = CoverageArea::orderBy('id', 'DESC')->get();
        return view('Admin.PickUpRequestAssign.orderTransferArea', compact('data', 'areas'));
    }

    public function transfer_to_head_office(Request $request)
    {
        // return $request;

        $agent = Agent::where('user_id', Auth::user()->id)->first();
        $area = $agent->area;
        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();
        $area_l = CoverageArea::where('zone_name', $area)->select('area')->get();
        $my_array = $area_l->pluck('area');

        if ($request->status == 'For Return') {

            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
                ->where('orders.status', 'Return Confirm')
                ->whereIn('orders.area', $my_array)
                ->get();
        } else {
            $order = Order::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
                ->whereIn('orders.status', ['Received By Pickup Branch', 'Delivery Cancel Reject by Fulfillment'])
                ->where('merchants.area', $area)
                ->get();
        }


        $status = $request->status == '' ? 'For Delivery' : $request->status;




        return view('Admin.Order.transfer_head_office', compact('user', 'order', 'rider', 'status'));
    }

    public function transfer_to_head_office_store(Request $request)
    {

        // return  $request;
        $tracking_id = $request->tracking_ids;
        if (!$tracking_id) {
            return redirect()->back()->with('message', 'Select Item');
        }

        if ($request->rider) {

            $id_data = Transfer::orderBy('id', 'desc')->take(1)->value('id');

            if ($id_data) {

                $latest_id = $id_data;
            } else {

                $latest_id = 0;
            }

            if ($request->type === 'For Return') {

                $invoice_id = 'TRR' . mt_rand(1111, 9999) . $latest_id;

                $transfers = new Transfer();
                $transfers->invoice_id  = $invoice_id;
                $transfers->sender_id  = Auth::user()->id;
                $transfers->receiver_id  = 1;
                $transfers->media_id  = $request->rider;
                $transfers->type  = 'return';
                $transfers->status  = 0;
                $transfers->save();

                if ($tracking_id) {

                    foreach ($tracking_id as $id) {


                        $transferdetails = new TransferDetail();
                        $transferdetails->invoice_id  = $invoice_id;
                        $transferdetails->tracking_id  = $id;
                        $transferdetails->created_by      = Auth::user()->id;
                        $transferdetails->updated_by  = Auth::user()->id;
                        $transferdetails->save();

                        $history = new OrderStatusHistory();
                        $history->tracking_id  = $id;
                        $history->user_id      = Auth::user()->id;
                        $history->status       = 'Transfer Assign for Fulfillment';
                        $history->save();

                        // $history = new OrderStatusHistory();
                        // $history->tracking_id  = $id;
                        // $history->user_id      = Auth::user()->id;
                        // $history->status       = 'Transfer Assign For Fullfilment';
                        // $history->save();

                        $data_exist = DB::table('orders')->where('tracking_id', $id)->first();

                        if ($data_exist) {

                            DB::table('orders')->where('tracking_id', $id)->update(['status' => 'Return Assign Rider For Fullfilment']);
                        }
                    }
                }
            } else {

                $invoice_id = 'TRD' . mt_rand(1111, 9999) . $latest_id;

                $transfers = new Transfer();
                $transfers->invoice_id  = $invoice_id;
                $transfers->sender_id  = Auth::user()->id;
                $transfers->receiver_id  = 1;
                $transfers->media_id  = $request->rider;
                $transfers->type  = 'delivery';
                $transfers->status  = 0;
                $transfers->save();

                if ($tracking_id) {

                    foreach ($tracking_id as $id) {


                        $transferdetails = new TransferDetail();
                        $transferdetails->invoice_id  = $invoice_id;
                        $transferdetails->tracking_id  = $id;
                        $transferdetails->created_by      = Auth::user()->id;
                        $transferdetails->updated_by  = Auth::user()->id;
                        $transferdetails->save();

                        $history = new OrderStatusHistory();
                        $history->tracking_id  = $id;
                        $history->user_id      = Auth::user()->id;
                        $history->status       = 'Transfer Assign for Fulfillment';
                        $history->save();

                        $data_exist = DB::table('orders')->where('tracking_id', $id)->first();

                        if ($data_exist) {

                            DB::table('orders')->where('tracking_id', $id)->update(['status' => 'Assigned Rider For Fullfilment']);
                        }
                    }
                }
            }
        }



        return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
    }


    public function transfer_to_agent_store(Request $request)
    {

        if (!$request->area) {

            \Toastr::warning('You did not load any data !', 'Warning !!', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }
        //check data 
        if (!$request->tracking_ids) {

            \Toastr::warning('You did not select any data !', 'Warning !!', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }

        $agent_id = Agent::where('area', $request->area)->value('user_id');
        if (!$agent_id) {
            \Toastr::warning('You\'r Selected Area Agent Not Found !', 'Warning !!', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }

        $tracking_id = $request->tracking_ids;

        if ($request->rider) {

            $id_data = Transfer::orderBy('id', 'desc')->take(1)->value('id');

            if ($id_data) {

                $latest_id = $id_data;
            } else {

                $latest_id = 0;
            }
            //  $invoice_id = 'TRD' . mt_rand(1111, 9999) . $latest_id;

            $invoice_id = 'TRDH' . mt_rand(1111, 9999) . $latest_id;

            $transfers = new Transfer();
            $transfers->invoice_id  = $invoice_id;
            $transfers->sender_id  = 1;
            $transfers->receiver_id  = $agent_id;
            $transfers->media_id  = $request->rider;
            $transfers->type  = 'delivery';
            $transfers->status  = 0;
            $transfers->save();

            if ($tracking_id) {

                foreach ($tracking_id as $id) {


                    $transferdetails = new TransferDetail();
                    $transferdetails->invoice_id  = $invoice_id;
                    $transferdetails->tracking_id  = $id;
                    $transferdetails->created_by      = Auth::user()->id;
                    $transferdetails->updated_by  = Auth::user()->id;
                    $transferdetails->save();

                    $history = new OrderStatusHistory();
                    $history->tracking_id  = $id;
                    $history->user_id      = Auth::user()->id;
                    $history->status       = 'Transfer Assign for Branch';
                    $history->save();

                    $data_exist = DB::table('orders')->where('tracking_id', $id)->first();

                    if ($data_exist) {

                        DB::table('orders')->where('tracking_id', $id)->update(['status' => 'Assigned Rider For Destination Hub']);
                    }
                }
            }
        }



        //return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
        \Toastr::success('Transfer Request Assign Confirmed.', 'Success !!', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }

    public function getOrder()
    {
        $data = Order::where('orders.area', request()->area)
            ->where('orders.status', 'In Collected Hub')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->select('orders.*', 'order_confirms.*')
            ->get();
        $orders_html = (string)view(
            'Admin.components.order',
            [
                'data' => $data,
            ]
        );
        return response()->json([
            'orders_html' => $orders_html

        ]);
    }

    public function transfer_add(Request $request, $id)
    {
        $orders = Order::where('tracking_id', $id)->first();
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
        $msg = "Order Added For Transfer";
        $request->session()->flash('message', $msg);
        // return redirect()->back()->with('message', $msg);
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->back()->with('message', 'Order Transfer Removed ');
    }

    public function confirm()
    {
        $user = User::where('role', 8)->get();
        return view('Admin.PickUpRequestAssign.transferConfirm', compact('user'));
    }

    public function con_firm(Request $request)
    {

        foreach (\Cart::getContent() as $data) {
            $history = new OrderStatusHistory();
            $history->tracking_id  = $data->id;
            $history->user_id      = Auth::user()->id;
            $history->status       = 'In Transit';
            $history->save();

            $order = Order::where('tracking_id', $data->id)->first();
            $order->status = 'In Transit';
            $order->save();

            $mdata = array(
                'tracking_id'   => $data->id,
                'agent_id'      => $request->agent,
            );
            $insert = DB::table('transfer_to_agents')->insert($mdata);
        }
        \Cart::clear();
        return redirect()->back()->with('message', 'Transfer Confirmation');
    }

    public function inDestinationHub()
    {
        // return "aa";
        $agent_area = Agent::where('user_id', Auth::user()->id)->value('area');
        //     $area_l = CoverageArea::where('zone_name', $agent_area)->select('zone_name')->get()->unique('zone_name');
        //  return   $my_array = $area_l->pluck('zone_name');
        $area_list = CoverageArea::where('zone_name', $agent_area)->select('area')->get()->unique('area');
        $my_ariaList = $area_list->pluck('area');

        $today = date('Y-m-d');

        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->whereIn('orders.status', ["Return Reach For Branch", 'Reach To Branch'])
            ->join('merchants', 'merchants.user_id', 'orders.user_id')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            // ->whereIn('orders.area', $my_ariaList)
            // ->where('merchants.area', $agent_area)
            ->select('orders.*', 'users.*', 'merchants.*', 'order_confirms.*')
            ->get();
        //return view('Admin.PickUpRequestAssign.orderDestination', compact('data'));
        return view('Admin.PickUpRequestAssign.orderDestination', compact('data'));
    }

    public function destiny(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Received By Destination Hub';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();

        $order->status = 'Received By Destination Hub';
        $order->save();

        return redirect()->back()->with('message', 'Order Received By Destination Hub Successfully');
    }
    public function moveToReturnAssign(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Return Received By Destination Hub';
        $data->save();
        $order = Order::where('tracking_id', $request->id)->first();

        $order->status = 'Return Received By Destination Hub';
        $order->save();

        return redirect()->back()->with('message', 'Order Received By Destination Hub Successfully');
    }
    public function move_to_reschedule(Request $request)
    {

        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Rescheduled';
        $data->save();

        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Rescheduled';
        $order->save();

        return redirect()->back()->with('message', 'Order Move to rescheduled Successfully');
    }


    public function move_to_return(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Return Confirm';
        $data->save();

        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Return Confirm';
        $order->save();

        return redirect()->back()->with('message', 'Order Move to Return Head Office Successfully');
    }


    public function move_to_delivery_assign(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = 'Received By Destination Hub';
        $data->save();

        $order = Order::where('tracking_id', $request->id)->first();
        $order->status = 'Received By Destination Hub';
        $order->save();

        return redirect()->back()->with('message', 'Order Received By Destination Hub Successfully');
    }
}
