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
use App\Admin\District;
use App\Admin\OrderConfirm;
use App\Admin\Rider;
use App\Admin\Transfer;
use App\Admin\TransferDetail;
use App\Admin\Zone;
use App\Scan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session as FacadesSession;
use function GuzzleHttp\Promise\all;

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
        if (auth()->user()->role == 8) {
            $agent = Agent::where('user_id', Auth::user()->id)->first();
            $area = $agent->area;
            $riders = Rider::where('area', $area)->join('users', 'riders.user_id', 'users.id')->get();

            $data = Order::orderBy('order_confirms.id', 'DESC')
                // ->where('orders.pickup_date', $today)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
                ->join('users', 'users.id', 'pick_up_request_assigns.user_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('agents', 'merchants.zone_id', 'agents.zone_id')
                // ->where('merchants.area', $area)
                ->where('agents.area', $area)
                ->where('orders.status', 'Pickup Done')
                ->select('orders.*', 'order_confirms.*', 'agents.*', 'merchants.*', 'users.name as rider_name')
                ->get();

            $selectedRider = '';

            return view('Admin.PickUpRequestAssign.orderCollection', compact('data', 'riders', 'selectedRider'));
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
            $area = $agent->area;
            $riders = Rider::where('area', $area)->join('users', 'riders.user_id', 'users.id')->get();

            $data = Order::orderBy('order_confirms.id', 'DESC')
                // ->where('orders.pickup_date', $today)
                ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                ->join('pick_up_request_assigns', 'orders.tracking_id', 'pick_up_request_assigns.tracking_id')
                ->join('users', 'users.id', 'pick_up_request_assigns.user_id')
                ->join('merchants', 'orders.user_id', 'merchants.user_id')
                ->join('agents', 'merchants.zone_id', 'agents.zone_id')
                // ->where('merchants.area', $area)
                ->where('agents.area', $area)
                ->where('orders.status', 'Pickup Done')
                ->select('orders.*', 'order_confirms.*', 'agents.*', 'merchants.*', 'users.name as rider_name')
                ->get();

            $selectedRider = '';

            return view('Admin.PickUpRequestAssign.orderCollection', compact('data', 'riders', 'selectedRider'));
        }
    }
    public function inCollectionHubLoad(Request $request)
    {
        if (auth()->user()->role == 8) {
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
        } elseif (auth()->user()->role == 18) {
            $demo =  DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
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

        $zone_name = Zone::where('id', $order_data->hub_id)->first();
       


        return view('Admin.Order.collect_print', compact('merchant_name','zone_name', 'order_data', 'merchant_data', 'company'));
    }

    public function latest_collect_print(Request $request)
    {
        $data = Order::latest()->value('tracking_id');

        $company = Company::all();


        $merchant_name = Order::where('tracking_id', $data)
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->value('merchants.business_name');

        $merchant_data = Order::where('tracking_id', $data)
            ->join('users', 'users.id', 'orders.user_id')
            ->first();



        $order_data = Order::where('tracking_id', $data)->first();


        return view('Admin.Order.collect_print', compact('merchant_name', 'order_data', 'merchant_data', 'company'));
    }

    public function collect_print_generate(Request $request)
    {

        $company = Company::all();


        // $merchant_name = Order::whereIn('tracking_id', $request->tracking_ids)
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->value('merchants.business_name');
        $order_data = Order::whereIn('tracking_id', $request->tracking_ids)
            ->join('users', 'users.id', 'orders.user_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'users.mobile', 'merchants.business_name')->get();


        //return $order_data;


        // $merchant_data = Order::whe1reIn('tracking_id', $request->tracking_ids)
        //     ->join('users', 'users.id', 'orders.user_id')
        //     ->get();



        // $order_data = Order::whereIn('tracking_id', $request->tracking_ids)->get();


        // return [
        //     'm_name' => $merchant_names,
        //     'm_data' => $merchant_data,
        //     'o_data' => $order_data
        // ];

        return view('Admin.Order.all_collect_print', compact('company', 'order_data'));
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


    public function hub_collection_scan()
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

        return view('Admin.PickUpRequestAssign.orderCollection_hub_scan', compact('data'));
    }

    public function removes(Request $request)
    {
        Scan::where('tracking_id', $request->id)->delete();
        \Toastr::success('hub Scan Remove Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }
    public function  hub_collection_scan_store(Request $request)
    {
        // $order = Order::orderBy('order_confirms.id', 'DESC')
        //     ->where('orders.tracking_id',  $request->name)
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')

        //     ->whereIn('orders.status', ['Reach to Fullfilment', 'Return Reach For Fullfilment'])
        //     ->select('orders.*', 'order_confirms.*', 'merchants.*', 'users.*')
        //     ->first();
        try {
            if (Auth::user()->role == 1) {

                $order = Order::where('orders.tracking_id',  $request->name)
                    ->whereIn('orders.status', ['Reach to Fullfilment', 'Return Reach For Fullfilment'])
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('orders.*', 'order_confirms.merchant_pay as m_payment', 'merchants.area as areas', 'merchants.business_name as bus_name')
                    ->get();

                $cart = FacadesSession::get('hub');

                if (isset($cart[$order[0]->id])) {
                    \Toastr::success('Already Exits please Try Another one.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                } else {
                    $cart[$order[0]->id] = array(
                        "id" => $order[0]->id,
                        "tracking_id" => $order[0]->tracking_id,
                        "business_name" => $order[0]->bus_name,
                        "customer_name" => $order[0]->customer_name,
                        "customer_phone" => $order[0]->customer_phone,
                        "customer_address" => $order[0]->customer_address,
                        "area" => $order[0]->areas,
                        "collection" => $order[0]->collection,
                        "merchant_pay" => $order[0]->m_payment,
                        "status" => $order[0]->status,
                    );
                }
                FacadesSession::put('hub', $cart);
                \Toastr::success('Parcel Fulfillment Scan Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            }
        } catch (\Exception $e) {
            // Handle the exception here, such as logging it or displaying an error message
            \Toastr::error('Data Not Found. ', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        }
    }

    public function hub_collection_scan_remove(Request $request)
    {
        $cart =  FacadesSession::get('hub', []);


        $idToRemove = $request->id;

        if (isset($cart[$idToRemove])) {

            unset($cart[$idToRemove]);


            FacadesSession::put('hub', $cart);

            \Toastr::success('Parcel Fulfillment Scan Remove.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        } else {
            \Toastr::error('Parcel Fulfillment Scan Remove.', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
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

        // $tracking = $request->tracking_ids;
        // foreach ($tracking as $tracking_id) {

        //     $order = Order::where('tracking_id', $tracking_id)->first();
        //     if ($order->status == 'Return Reach For Fullfilment') {
        //         $order->status = 'Return Payment Processing';
        //         $order->save();
        //     }
        //     if ($order->status == 'Reach to Fullfilment') {
        //         $order->status = 'Received By Fullfilment';
        //         $order->save();
        //     }

        //     $data = new OrderStatusHistory();
        //     $data->tracking_id  = $tracking_id;
        //     $data->user_id      = Auth::user()->id;

        //     if ($order->status == 'Return Reach For Fullfilment') {
        //         $data->status       = 'Return Received By Fullfilment';
        //         $data->save();
        //     }
        //     if ($order->status == 'Reach to Fullfilment') {
        //         $data->status    = 'Received By Fullfilment';
        //         $data->save();
        //     }
        // }
        $tracking = $request->tracking_ids;
        foreach ($tracking as $tracking_id) {

            $order = Order::where('tracking_id', $tracking_id)->first();
            $originalStatus = $order->status; // Save the original status before modifying it

            if ($order->status == 'Return Reach For Fullfilment') {
                $order->status = 'Return Payment Processing';
                $order->save();
            }
            if ($order->status == 'Reach to Fullfilment') {
                $order->status = 'Received By Fullfilment';
                $order->save();
            }

            $data = new OrderStatusHistory();
            $data->tracking_id = $tracking_id;
            $data->user_id = Auth::user()->id;

            // Use the original status to determine the new status for OrderStatusHistory
            if ($originalStatus == 'Return Reach For Fullfilment') {
                $data->status = 'Return Received By Fullfilment';
                $data->save();
            }
            if ($originalStatus == 'Reach to Fullfilment') {
                $data->status = 'Received By Fullfilment';
                $data->save();
            }
        }

        foreach ($request->tracking_ids as $id) {

            $cart = FacadesSession::get('hub');

            $trackingIdToRemove = $id;

            foreach ($cart as $orderId => $orderDetails) {

                if ($orderDetails['tracking_id'] === $trackingIdToRemove) {

                    unset($cart[$orderId]);
                }
            }


            FacadesSession::put('hub', $cart);
        }

        // return redirect()->back()->with('message', 'Order Collected In Fullfilment Successfully');
        \Toastr::success('Order Collected In Fullfilment.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        return redirect()->back();
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
    public function transfer_hub_cancel(Request $request)
    {
        Scan::where('tracking_id', $request->id)->delete();
        \Toastr::success('Scan Remove Successfully', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
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
        //dd($request->all());
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

            // return $order;

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

    public function transfer_scan(Request $request)
    {

        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            // ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();





        $areas = Order::orderBy('area', 'DESC')->where('status', 'Received By Fullfilment')->select('area')->get()->unique('area');

        $my_array = $areas->pluck('area');
        $area_list = CoverageArea::whereIn('area', $my_array)->get()->unique('zone_name');



        if ($request->area) {

            $area_l = CoverageArea::where('zone_name', $request->area)->select('area')->get();

            $my_array = $area_l->pluck('area');




            $order_data = Scan::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'users.id')
                ->join('merchants', 'scans.user_id', 'merchants.user_id')
                ->select('scans.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('scans.status', ['Received By Fullfilment'])
                ->whereIn('scans.area', $my_array)
                ->get();


            $order = $order_data->unique('tracking_id');


            $area = $request->area;
        } else {

            $order = Scan::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'users.id')
                ->join('merchants', 'scans.user_id', 'merchants.user_id')
                ->select('scans.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('scans.status', ['Received By Fullfilment'])
                ->get();
            //return $order;
            $area = $request->area;
        }





        return view('Admin.PickUpRequestAssign.orderTransferScan',  compact('user', 'order', 'rider', 'area_list', 'area'));
    }

    public function transfer_scan_store(Request $request)
    {


        $order = Order::where('orders.tracking_id', $request->name)
            ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('merchants', 'orders.user_id', '=', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as bus_name', 'merchants.area as areas')
            ->whereIn('orders.status', ['Received By Fullfilment'])
            ->whereIn('orders.inside', ['0', '1', '2'])
            ->first();

        $hub = CoverageArea::where('area', $order->area)->first();

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
                    'hub' => $hub->zone_name,
                    'area' => $order->area,
                    'inside' => $order->inside,
                    'type' => $order->type,
                    'status' => $order->status,
                ]);
                \Toastr::success('Transfer HeadOffice Scan Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
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

    public function transfer_to_third_party(Request $request)
    {


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

        $district = District::orderBy('name', 'DESC')->get();


        try {
            //Parcel Jet
            $apiToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI5Mzc0MTIiLCJpYXQiOjE3MTUyNTMxNDEsImlzcyI6IkZqbWRvRzZibjRuQXpJSDdvQTE3WGNGZ0NQNUhzTjVVIiwic2hvcF9pZCI6OTM3NDEyLCJ1c2VyX2lkIjoyNjc3NjkxfQ.A5APno4oTBoXOEMwDYibXOfLh0WQ2Nu3kFrYnuOVicA';

            $response = Http::withHeaders([
                'API-ACCESS-TOKEN' => 'Bearer ' . $apiToken,
            ])->get('https://openapi.redx.com.bd/v1.0.0-beta/areas');


            if ($response->successful()) {

                $data_area_list = $response->json();
                $data_area_list2 = isset($data_area_list['areas']) ? $data_area_list['areas'] : [];


                return view('Admin.PickUpRequestAssign.orderTransfer_thirdparty',  compact('district', 'data_area_list2', 'user', 'order', 'rider', 'area_list', 'area'));
            } else {

                return response()->json(['error' => 'API request failed'], $response->status());
            }
        } catch (\Exception $e) {

            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }



        return view('Admin.PickUpRequestAssign.orderTransfer_thirdparty',  compact('district', 'user', 'order', 'rider', 'area_list', 'area'));
    }

    public function get_area(Request $request)
    {

        try {
            //Parcel Jet
            $apiToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI5Mzc0MTIiLCJpYXQiOjE3MTUyNTMxNDEsImlzcyI6IkZqbWRvRzZibjRuQXpJSDdvQTE3WGNGZ0NQNUhzTjVVIiwic2hvcF9pZCI6OTM3NDEyLCJ1c2VyX2lkIjoyNjc3NjkxfQ.A5APno4oTBoXOEMwDYibXOfLh0WQ2Nu3kFrYnuOVicA';

            $response = Http::withHeaders([
                'API-ACCESS-TOKEN' => 'Bearer ' . $apiToken,
            ])->get('https://openapi.redx.com.bd/v1.0.0-beta/areas', [
                'district_name' => $request->district_name,
            ]);


            if ($response->successful()) {

                $data = $response->json();

                return $data;
            } else {

                return response()->json(['error' => 'API request failed'], $response->status());
            }
        } catch (\Exception $e) {

            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }




    public function transfer_to_third_pathao(Request $request)
    {
        $user = User::orderBy('id', 'DESC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            // ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();
        $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();



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


            $order = [];
            $type = '';
            $area = '';
        }

        $district = District::orderBy('name', 'DESC')->get();


        $base_url = config('app.base_url');
        $access_token = $this->generateToken();

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/city-list");

        $responseBody = $response->json();

        $city_list = $responseBody['data']['data'];

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/stores");

        $responseBody = $response->json();

        $store_list = $responseBody['data']['data'];



        return view('Admin.PickUpRequestAssign.orderTransfer_pathao', compact('district', 'city_list', 'user', 'order', 'rider', 'store_list', 'area_list', 'area'));
    }


    public  function generateToken()
    {
        try {
            $accessToken = $this->pathaoAuthorize();
            $accessToken = $accessToken->token_type . ' ' . $accessToken->access_token;
            return $accessToken;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public  function getToken()
    {
        $existance = Storage::disk('local')->exists('pathao_token.json');
        if ($existance) {
            $bearerToken = Storage::get('pathao_token.json');
            $bearerToken = json_decode($bearerToken);
            $bearerToken = $bearerToken[0];
            return ['Authorization' => $bearerToken];
        } else {
            $pathaoAuthorize = $this->pathaoAuthorize();
            $accessToken = [$pathaoAuthorize->token_type . ' ' . $pathaoAuthorize->access_token];
            Storage::disk('local')->put('pathao_token.json', json_encode($accessToken));
            return ['Authorization' => $accessToken];
        }
    }


    public  function pathaoAuthorize()
    {
        $requestBody = [
            'client_id' => config('app.client_id'),
            'client_secret' => config('app.client_secret'),
            'username' => config('app.client_email'),
            'password' => config('app.password'),
            'grant_type' => config('app.grant_type'),
        ];

        try {
            $base_url = config('app.base_url');
            $response = Http::post("$base_url/aladdin/api/v1/issue-token", $requestBody, [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            return json_decode($response->body());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function pathao_get_zone(Request $request)
    {
        $base_url = config('app.base_url');
        $access_token = $this->generateToken();
        $city_id = $request->city_id;

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/cities/$city_id/zone-list");

        $responseBody = $response->json();

        return $responseBody;
    }

    public function pathao_get_area(Request $request)
    {
        $base_url = config('app.base_url');
        $access_token = $this->generateToken();
        // $zone_id = 89;
        $zone_id = $request->zone_id;

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/zones/$zone_id/area-list");

        $responseBody = $response->json();

        return $responseBody;
    }

    public function pathao_get_store_list(Request $request)
    {
        $base_url = config('app.base_url');
        $access_token = $this->generateToken();


        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get("$base_url/aladdin/api/v1/stores");

        $responseBody = $response->json();

        $store_list = $responseBody['data']['data'];
        return $store_list;
    }
    public function transfer_to_pathao_store(Request $request)
    {
        $base_url = config('app.base_url');
        $access_token = $this->generateToken();

        $orders = [];
        $cityes = array_values(array_filter($request->district));
        $zones = array_values(array_filter($request->zone));
        $areas = array_values(array_filter($request->areas));

        $weights = array_values(array_filter($request->weight));
        $tracking_ids = $request->tracking_ids;

        for ($i = 0; $i < count($tracking_ids); $i++) {

            $order = Order::where('tracking_id', $tracking_ids[$i])->first();
            $order_confirmed = OrderConfirm::where('tracking_id', $tracking_ids[$i])->first();

            $orders[] = [
                'store_id' => $request->stores_id,
                'merchant_order_id' => $tracking_ids[$i],
                'recipient_name' => $order->customer_name,
                'recipient_phone' => $order->customer_phone,
                'recipient_address' => $order->customer_address,
                'recipient_city' => $cityes[$i],
                'recipient_zone' => $zones[$i],
                'recipient_area' => $areas[$i],
                'delivery_type' => '48',
                'item_type' => '2',
                'special_instruction' => '',
                'item_quantity' => '1',
                'item_weight' =>  $weights[$i],
                'amount_to_collect' => $order_confirmed->colection,
                'item_description' => '',
            ];
            $history = new OrderStatusHistory();
            $history->tracking_id  = $tracking_ids[$i];
            $history->user_id      = Auth::user()->id;
            $history->status       = 'Transfered to Outside Hub';
            $history->save();

            DB::table('orders')->where('tracking_id', $tracking_ids[$i])->update(['status' => 'Transfered to Outside Hub']);
        }


        // $storeData = [
        //     'store_id' => '172746',
        //     'merchant_order_id' => 'PJC10975380',
        //     'recipient_name' => 'Devid',
        //     'recipient_phone' => '01852211054',
        //     'recipient_address' => 'Dhaka Dhaka Dhaka DhakaDhaka',
        //     'recipient_city' => '3',
        //     'recipient_zone' => '89',
        //     'recipient_area' => '1266',
        //     'delivery_type' => '48',
        //     'item_type' => '2',
        //     'special_instruction' => '',
        //     'item_quantity' => '1',
        //     'item_weight' => '5',
        //     'amount_to_collect' => '200',
        //     'item_description' => '2',
        // ]; 

        // $response = Http::withHeaders([
        //     'Authorization' =>  $access_token,
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json',
        // ])->post("$base_url/aladdin/api/v1/orders/bulk",  ['orders' => $orders]);


        // $responseBody = $response->json();


        //  return $responseBody;

        try {
            $response = Http::withHeaders([
                'Authorization' =>  $access_token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("$base_url/aladdin/api/v1/orders/bulk", ['orders' => $orders]);

            if ($response->successful()) {

                // $responseBody = $response->json();
                \Toastr::success('Pathao Transfer .', 'Success !!', ["positionClass" => "toast-top-center"]);
                return redirect()->back();
            } else {

                return response()->json(['error' => 'Failed to submit bulk orders'], $response->status());
            }
        } catch (RequestException $e) {

            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }
    public function pathao_transfer_list(Request $request)
    {
        $order_data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
            ->whereIn('orders.status', ['Transfered to Outside Hub', 'Transfer Order Redx', 'Redx Order Received', 'Redx Delivery Assign', 'Redx Successfully Delivered', 'Redx Order Hold', 'Redx Order Return', 'Redx Agent Area Change', 'Redx Delivery Payment Collected'])
            ->get();

        return view('Admin.PickUpRequestAssign.pathao_transfer_list', compact('order_data'));
    }

    public function third_party_status_change(Request $request)
    {
        $data           = Order::where('tracking_id', $request->id)->first();
        $data->status   = $request->status;
        $data->save();

        $data               = new OrderStatusHistory();
        $data->tracking_id  = $request->id;
        $data->user_id      = Auth::user()->id;
        $data->status       = $request->status;
        $data->save();

        \Toastr::success('Status Changed Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);

        // return redirect()->back();
    }


    public function third_party_delivery_cancel_list(Request $request)
    {
        $order_data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
            ->whereIn('orders.status', ['Transfer Order Delivered', 'Transfer Cancel Order', 'Redex Order Delivered', 'Redx Cancel Order'])
            ->get();

        return view('Admin.PickUpRequestAssign.thirdparty_delivery_cancel_list', compact('order_data'));
    }

    public function redx_transfer_list(Request $request)
    {
        $order_data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
            ->whereIn('orders.status', ['Transfer Order Redx'])
            ->get();

        return view('Admin.PickUpRequestAssign.redx_transfer_list', compact('order_data'));
    }


    /**
     * Order
     * @param Request $request
     * Author: Muhammad Asif Ul Islam <aseasifislam@gmail.com>
     * @return void
     */
    public function returnToHub(Request $request)
    {
        // $request->all();

        // if ($request->area || $request->rider) {
        //     \Toastr::warning('Area Or Rider not selected.', 'Warning!!!', ["positionClass" => "toast-bottom-center", "progressBar" => true]);
        //     return redirect()->back();
        // }

        // $user = User::orderBy('id', 'DESC')
        //     ->join('riders', 'users.id', 'riders.user_id')
        //     ->select('riders.area', 'users.*')
        //     // ->where('riders.area', $area)
        //     ->where('users.role', 10)
        //     ->get();

        // $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();

        // $areas = Order::orderBy('orders.area', 'DESC')->join('merchants', 'merchants.user_id', 'orders.user_id')->where('orders.status', 'Return To Merchant')->select('merchants.area')->get()->unique('area');



        // $my_array = $areas->pluck('area');

        // $area_list = CoverageArea::whereIn('zone_name', $my_array)->get()->unique('zone_name');



        // if ($request->area) {


        //     $order_data = Order::orderBy('order_confirms.id', 'DESC')
        //         ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //         ->join('users', 'orders.user_id', 'users.id')
        //         ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //         ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
        //         ->where('orders.status', 'Return To Merchant')
        //         ->where('merchants.area', $request->area)
        //         ->get();


        //     $order = $order_data->unique('tracking_id');

        //     $area = $request->area;
        // } else {
        //     $order = [];

        //     $area = '';
        // }

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


        $areas = Order::orderBy('area', 'DESC')->where('status', 'Return To Merchant')->select('area')->get()->unique('area');

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
                ->whereIn('orders.status', ['Return To Merchant'])
                ->whereIn('orders.area', $my_array)
                ->get();


            $order = $order_data->unique('tracking_id');

            // return $order;

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
        return view('Admin.PickUpRequestAssign.return_to_hub',  compact('user', 'order', 'rider', 'area_list', 'area'));
    }

    public function returnToHubScan(Request $request)
    {
        //     $user = User::orderBy('id', 'DESC')
        //         ->join('riders', 'users.id', 'riders.user_id')
        //         ->select('riders.area', 'users.*')
        //         // ->where('riders.area', $area)
        //         ->where('users.role', 10)
        //         ->get();
        //     $rider = User::orderBy('id', 'DESC')->where('role', 10)->get();

        //     $areas = Order::orderBy('orders.area', 'DESC')->join('merchants', 'merchants.user_id', 'orders.user_id')->where('orders.status', 'Return To Merchant')->select('merchants.area')->get()->unique('area');

        //    // return $areas;

        //     $my_array = $areas->pluck('area');
        //     $area_list = CoverageArea::whereIn('zone_name', $my_array)->get()->unique('zone_name');



        //     if ($request->area) {


        //         $order_data = Order::orderBy('order_confirms.id', 'DESC')
        //             ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //             ->join('users', 'orders.user_id', 'users.id')
        //             ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //             ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
        //             ->where('orders.status', 'Return To Merchant')
        //             ->where('merchants.area', $request->area)
        //             ->get();


        //         $order = $order_data->unique('tracking_id');

        //         $area = $request->area;
        //     } else {
        //         $order = [];

        //         $area = '';
        //     }

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


        $areas = Order::orderBy('area', 'DESC')->where('status', 'Return To Merchant')->select('area')->get()->unique('area');

        $my_array = $areas->pluck('area');
        $area_list = CoverageArea::whereIn('area', $my_array)->get()->unique('zone_name');



        if ($request->area) {

            $area_l = CoverageArea::where('zone_name', $request->area)->select('area')->get();

            $my_array = $area_l->pluck('area');




            $order_data = Scan::orderBy('order_confirms.id', 'DESC')
                ->join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'users.id')
                ->join('merchants', 'scans.user_id', 'merchants.user_id')
                ->select('scans.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('scans.status', ['Return To Merchant'])
                ->whereIn('scans.area', $my_array)
                ->get();


            $order = $order_data->unique('tracking_id');

            // return $order;

            $area = $request->area;
        } else {
            $order = Scan::join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'users.id')
                ->join('merchants', 'scans.user_id', 'merchants.user_id')
                ->select('scans.*', 'order_confirms.*', 'users.*', 'merchants.*')
                ->whereIn('scans.status', ['Return To Merchant'])
                ->get();
            //return $order;
            $area = $request->area;
        }
        return view('Admin.PickUpRequestAssign.return_to_hub_scan',  compact('user', 'order', 'rider', 'area_list', 'area'));
    }

    public function returnToHubScanStore(Request $request)
    {
        $order = Order::where('orders.tracking_id', $request->name)
            ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('merchants', 'orders.user_id', '=', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as bus_name', 'merchants.area as areas')
            ->whereIn('orders.status', ['Return To Merchant'])
            ->whereIn('orders.inside', ['0', '1', '2'])
            ->first();
        if ($order == []) {
            \Toastr::error('Order not found or does not meet criteria.', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        $hub = CoverageArea::where('area', $order->area)->first();

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
                    'hub' => $hub->zone_name,
                    'area' => $order->area,
                    'inside' => $order->inside,
                    'type' => $order->type,
                    'status' => $order->status,
                ]);
                \Toastr::success('Return Transfer to Hub Scan Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
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

                    // Scan::where('tracking_id', $request->id)->delete();
                }
            }
        }



        return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
    }
    public function returnToStoreScan(Request $request)
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

                    // Scan::where('tracking_id', $request->id)->delete();
                }

                foreach ($tracking_id as $id) {
                    Scan::where('tracking_id', $id)->delete();
                }
            }
        }


        \Toastr::success('PickUp Request Assign Confirmed.', 'Success !!', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
        // return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
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
        if (auth()->user()->role == 8) {
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
                    ->whereIn('orders.status', ['Return Confirm', 'Partially Delivered Received from Branch', 'Exchange Delivered Received from Branch'])
                    ->whereIn('orders.area', $my_array)
                    ->get();
            } else {
                $order = Order::orderBy('order_confirms.id', 'DESC')
                    ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
                    ->join('users', 'orders.user_id', 'users.id')
                    ->join('merchants', 'orders.user_id', 'merchants.user_id')
                    ->select('orders.*', 'order_confirms.*', 'users.name as merchant')
                    ->whereIn('orders.status', ['Received By Pickup Branch', 'Partially Delivered Received from Branch', 'Delivery Cancel Reject by Fulfillment'])
                    ->where('merchants.area', $area)
                    ->get();
            }


            $status = $request->status == '' ? 'For Delivery' : $request->status;




            return view('Admin.Order.transfer_head_office', compact('user', 'order', 'rider', 'status'));
        } elseif (auth()->user()->role == 18) {
            $demo = DB::table('hub_employees')->where('hub_incharge_id', auth()->user()->id)->first();
            $agent = Agent::where('user_id', $demo->hub_id)->first();
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
    }


    public function transfer_to_head_office_scan(Request $request)
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
        $area_l = CoverageArea::where('zone_name', $area)->select('area')->get();
        $my_array = $area_l->pluck('area');

        if ($request->status == 'For Return') {

            $order = Scan::join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'users.id')
                ->join('merchants', 'scans.user_id', 'merchants.user_id')
                ->select('scans.*', 'order_confirms.*', 'users.name as merchant')
                ->whereIn('scans.status', ['Return Confirm', 'Partially Delivered Received from Branch', 'Exchange Delivered Received from Branch'])
                ->whereIn('scans.area', $my_array)
                ->get();
        } else {
            $order = Scan::join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
                ->join('users', 'scans.user_id', 'users.id')
                ->join('merchants', 'scans.user_id', 'merchants.user_id')
                ->select('scans.*', 'order_confirms.*', 'users.name as merchant')
                ->whereIn('scans.status', ['Received By Pickup Branch', 'Partially Delivered Received from Branch', 'Delivery Cancel Reject by Fulfillment'])
                ->where('merchants.area', $area)
                ->get();
        }


        $status = $request->status == '' ? 'For Delivery' : $request->status;




        return view('Admin.Order.transfer_head_office_scan', compact('user', 'order', 'rider', 'status'));
    }

    public function transfer_to_head_office_scan_store(Request $request)
    {
        $order = Order::where('orders.tracking_id', $request->name)
            ->join('order_confirms', 'orders.tracking_id', '=', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('merchants', 'orders.user_id', '=', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as bus_name', 'merchants.area as areas')
            ->whereIn('orders.status', ['Received By Pickup Branch', 'Partially Delivered Received from Branch', 'Delivery Cancel Reject by Fulfillment', 'Return Confirm', 'Partially Delivered Received from Branch', 'Exchange Delivered Received from Branch'])
            ->first();
        if ($order == []) {
            \Toastr::error('Order not found or does not meet criteria.', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
        $hub = CoverageArea::where('area', $order->area)->first();

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
                    'hub' => $hub->zone_name,
                    'area' => $order->area,
                    'inside' => $order->inside,
                    'type' => $order->type,
                    'status' => $order->status,
                ]);
                \Toastr::success('Return Transfer to Hub Scan Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
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

    public function transfer_to_head_office_store_scan(Request $request)
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

            foreach ($tracking_id as $id) {
                Scan::where('tracking_id', $id)->delete();
            }
        }


        \Toastr::success('PickUp Request Assign Confirmed', '!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
        // return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
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
            //  $invoice_id = 'TRD' . mt_rand(1111, 9999) . $latest_id; area

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

        // foreach ($request->tracking_ids as $id) {

        //     $cart = FacadesSession::get('transfer');

        //     $trackingIdToRemove = $id;

        //     foreach ($cart as $orderId => $orderDetails) {

        //         if ($orderDetails['tracking_id'] === $trackingIdToRemove) {

        //             unset($cart[$orderId]);
        //         }
        //     }


        //     FacadesSession::put('transfer', $cart);
        // }


        //return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
        \Toastr::success('Transfer Request Assign Confirmed.', 'Success !!', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }

    public function transfer_to_agent_store_scan(Request $request)
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
            //  $invoice_id = 'TRD' . mt_rand(1111, 9999) . $latest_id; area

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

        foreach ($tracking_id as $id) {
            Scan::where('tracking_id', $id)->delete();
        }

        // foreach ($request->tracking_ids as $id) {

        //     $cart = FacadesSession::get('transfer');

        //     $trackingIdToRemove = $id;

        //     foreach ($cart as $orderId => $orderDetails) {

        //         if ($orderDetails['tracking_id'] === $trackingIdToRemove) {

        //             unset($cart[$orderId]);
        //         }
        //     }


        //     FacadesSession::put('transfer', $cart);
        // }


        //return redirect()->back()->with('message', 'PickUp Request Assign Confirmed.');
        \Toastr::success('Transfer Request Assign Confirmed.', 'Success !!', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }

    public function session_search(Request $request)
    {
        // dd($request->all());
        $cart = FacadesSession::get('transfer', []);

        // Ensure $cart is an array
        if (!is_array($cart)) {
            $cart = [];
        }

        $trackingIdToSearch = $request->area;
        $searchResult = null;

        // Store the search query in the session
        FacadesSession::put('transfer', $trackingIdToSearch);

        // Iterate over the cart items
        foreach ($cart as $key => $item) {
            // Ensure the item is an array and has the 'area' key
            if (is_array($item) && isset($item['area']) && $item['area'] == $trackingIdToSearch) {
                $searchResult = $item;
                break;
            }
        }

        // Update the session with the search result
        FacadesSession::put('transfer', $searchResult);

        // Provide feedback based on whether the item was found
        if ($searchResult) {
            \Toastr::success('Tracking ID found.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        } else {
            \Toastr::error('Tracking ID not found.', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        }

        // Redirect back to the previous page
        return redirect()->back();
    }

    public function transfer_to_redx_store(Request $request)
    {


        $areas = array_values(array_filter($request->areas));
        $weights = array_values(array_filter($request->weight));

        $tracking_ids = $request->tracking_ids;


        //Parcel Jet
        $apiToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI5Mzc0MTIiLCJpYXQiOjE3MTUyNTMxNDEsImlzcyI6IkZqbWRvRzZibjRuQXpJSDdvQTE3WGNGZ0NQNUhzTjVVIiwic2hvcF9pZCI6OTM3NDEyLCJ1c2VyX2lkIjoyNjc3NjkxfQ.A5APno4oTBoXOEMwDYibXOfLh0WQ2Nu3kFrYnuOVicA';

        for ($i = 0; $i < count($tracking_ids); $i++) {
            $order = Order::where('tracking_id', $tracking_ids[$i])->first();
            $order_confirmed = OrderConfirm::where('tracking_id', $tracking_ids[$i])->first();

            $response = Http::withHeaders([
                'API-ACCESS-TOKEN' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json', // Adjust as per API requirements
            ])->post('https://openapi.redx.com.bd/v1.0.0-beta/parcel', [
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'delivery_area' => "Mir",
                'delivery_area_id' => $areas[$i],
                "customer_address" => $order->customer_address,
                'merchant_invoice_id' => $tracking_ids[$i],
                'cash_collection_amount' =>  $order_confirmed->colection,
                'parcel_weight' => $weights[$i],
                'value' => 1000,
            ]);

            $history = new OrderStatusHistory();
            $history->tracking_id  = $tracking_ids[$i];
            $history->user_id      = Auth::user()->id;
            $history->status       = 'Transfer Order Redx';
            $history->save();

            DB::table('orders')->where('tracking_id', $tracking_ids[$i])->update(['status' => 'Transfer Order Redx']);

            // Handle the response for each request as needed
            if ($response->successful()) {
                // return $response->json();
            } else {

                return 'request failed';
                // Error handling for the current data item
                // You might want to log or store the error status for each item
            }
        }
        // return response()->json(['message' => 'Data submitted to API in a loop']);

        if ($response->successful()) {
            \Toastr::success('Redx Transfer .', 'Success !!', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        } else {
            return 'request failed';
        }
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


        // $areas = Order::orderBy('area', 'DESC')->where('status', 'Received By Fullfilment')->select('area')->get()->unique('area');

        // $my_array = $areas->pluck('area');
        // $area_list = CoverageArea::whereIn('area', $my_array)->get()->unique('zone_name');



        // $area_l = CoverageArea::where('zone_name', $agent_area)->select('zone_name')->get()->unique('zone_name');

        // $my_array = $area_l->pluck('area');



        $agent_area = Agent::where('user_id', Auth::user()->id)->value('area');
        $area_l = CoverageArea::where('zone_name', $agent_area)->select('zone_name')->get()->unique('zone_name');
        $my_array = $area_l->pluck('zone_name')->toArray();

        $my_string = implode(',', $my_array);

        $area_list = CoverageArea::where('zone_name', $agent_area)->select('area')->get()->unique('area');
        $my_ariaList = $area_list->pluck('area');





        $data = Order::orderBy('order_confirms.id', 'DESC')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
            ->whereIn('orders.status', ['Reach To Branch', 'Return Reach For Branch'])
            ->whereIn('orders.area', $my_ariaList)
            ->get();


        // $order = $order_data->unique('tracking_id');


































        // return "aa";
        // $agent_area = Agent::where('user_id', Auth::user()->id)->value('area');
        // $area_l = CoverageArea::where('zone_name', $agent_area)->select('zone_name')->get()->unique('zone_name');
        // $my_array = $area_l->pluck('zone_name')->toArray();

        // $my_string = implode(',', $my_array);

        // $area_list = CoverageArea::where('zone_name', $agent_area)->select('area')->get()->unique('area');
        // $my_ariaList = $area_list->pluck('area');

        // $today = date('Y-m-d');


        // $order_data = Order::orderBy('order_confirms.id', 'DESC')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
        //     ->whereIn('orders.status', ['Reach To Branch'])
        //     // ->whereIn('orders.area', $my_array)
        //     ->get();








        // $data = Order::orderBy('order_confirms.id', 'DESC')
        //     // ->where('orders.status', 'Reach To Branch')
        //     ->whereIn('orders.status', ["Return Reach For Branch", 'Reach To Branch'])
        //     ->join('merchants', 'merchants.user_id', 'orders.user_id')
        //     ->join('users', 'users.id', 'orders.user_id')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     // ->whereIn('orders.area', $my_ariaList)
        //     // ->where('orders.area', $agent_area)
        //     // ->where('orders.area', 'Dhanmondi')
        //     ->select('orders.*', 'users.*', 'merchants.*', 'order_confirms.*')
        //     ->get();


        return view('Admin.PickUpRequestAssign.orderDestination', compact('data', 'my_string'));
    }

    public function inDestinationHubScan(Request $request)
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


        // $areas = Order::orderBy('area', 'DESC')->where('status', 'Received By Fullfilment')->select('area')->get()->unique('area');

        // $my_array = $areas->pluck('area');
        // $area_list = CoverageArea::whereIn('area', $my_array)->get()->unique('zone_name');



        // $area_l = CoverageArea::where('zone_name', $agent_area)->select('zone_name')->get()->unique('zone_name');

        // $my_array = $area_l->pluck('area');



        $agent_area = Agent::where('user_id', Auth::user()->id)->value('area');
        $area_l = CoverageArea::where('zone_name', $agent_area)->select('zone_name')->get()->unique('zone_name');
        $my_array = $area_l->pluck('zone_name')->toArray();

        $my_string = implode(',', $my_array);

        $area_list = CoverageArea::where('zone_name', $agent_area)->select('area')->get()->unique('area');
        $my_ariaList = $area_list->pluck('area');





        $data = Scan::join('order_confirms', 'scans.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'scans.user_id', 'users.id')
            ->join('merchants', 'scans.user_id', 'merchants.user_id')
            ->select('scans.*', 'order_confirms.*', 'users.*', 'merchants.*')
            ->whereIn('scans.status', ['Reach To Branch', 'Return Reach For Branch'])
            ->whereIn('scans.area', $my_ariaList)
            ->get();


        // $order = $order_data->unique('tracking_id');


































        // return "aa";
        // $agent_area = Agent::where('user_id', Auth::user()->id)->value('area');
        // $area_l = CoverageArea::where('zone_name', $agent_area)->select('zone_name')->get()->unique('zone_name');
        // $my_array = $area_l->pluck('zone_name')->toArray();

        // $my_string = implode(',', $my_array);

        // $area_list = CoverageArea::where('zone_name', $agent_area)->select('area')->get()->unique('area');
        // $my_ariaList = $area_list->pluck('area');

        // $today = date('Y-m-d');


        // $order_data = Order::orderBy('order_confirms.id', 'DESC')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     ->join('users', 'orders.user_id', 'users.id')
        //     ->join('merchants', 'orders.user_id', 'merchants.user_id')
        //     ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.*')
        //     ->whereIn('orders.status', ['Reach To Branch'])
        //     // ->whereIn('orders.area', $my_array)
        //     ->get();








        // $data = Order::orderBy('order_confirms.id', 'DESC')
        //     // ->where('orders.status', 'Reach To Branch')
        //     ->whereIn('orders.status', ["Return Reach For Branch", 'Reach To Branch'])
        //     ->join('merchants', 'merchants.user_id', 'orders.user_id')
        //     ->join('users', 'users.id', 'orders.user_id')
        //     ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
        //     // ->whereIn('orders.area', $my_ariaList)
        //     // ->where('orders.area', $agent_area)
        //     // ->where('orders.area', 'Dhanmondi')
        //     ->select('orders.*', 'users.*', 'merchants.*', 'order_confirms.*')
        //     ->get();


        return view('Admin.PickUpRequestAssign.orderDestinationScan', compact('data', 'my_string'));
    }

    public function inDestinationHubScanStore(Request $request)
    {
        $order = Order::where('orders.tracking_id', $request->name)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'users.*', 'merchants.business_name as bus_name')
            ->whereIn('orders.status', ['Reach To Branch', 'Return Reach For Branch'])
            ->first();

        $hub = CoverageArea::where('area', $order->area)->first();

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
                    'hub' => $hub->zone_name,
                    'area' => $order->area,
                    'inside' => $order->inside,
                    'type' => $order->type,
                    'status' => $order->status,
                ]);
                \Toastr::success('Destination Hub Scan Successfully.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
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

    public function inDestinationHub_collect_all(Request $request)
    {



        $trackings = $request->tracking_ids;
        foreach ($trackings as $tracking) {

            $status = Order::where('tracking_id', $tracking)->value('status');


            if ($status == 'Reach to Branch') {

                $data = new OrderStatusHistory();
                $data->tracking_id  = $tracking;
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Received By Destination Hub';
                $data->save();
                $order = Order::where('tracking_id', $tracking)->first();

                $order->status = 'Received By Destination Hub';
                $order->save();
            } else if ($status = 'Return Reach For Branch') {

                $data = new OrderStatusHistory();
                $data->tracking_id  = $tracking;
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Return Received By Destination Hub';
                $data->save();
                $order = Order::where('tracking_id', $tracking)->first();

                $order->status = 'Return Received By Destination Hub';
                $order->save();
            }
        }

        return redirect()->back()->with('message', 'Order Received By Destination Hub Successfully');
    }

    public function inDestinationHub_collect_all_scan(Request $request)
    {
        $trackings = $request->tracking_ids;
        foreach ($trackings as $tracking) {

            $status = Order::where('tracking_id', $tracking)->value('status');


            if ($status == 'Reach to Branch') {

                $data = new OrderStatusHistory();
                $data->tracking_id  = $tracking;
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Received By Destination Hub';
                $data->save();
                $order = Order::where('tracking_id', $tracking)->first();

                $order->status = 'Received By Destination Hub';
                $order->save();
            } else if ($status = 'Return Reach For Branch') {

                $data = new OrderStatusHistory();
                $data->tracking_id  = $tracking;
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Return Received By Destination Hub';
                $data->save();
                $order = Order::where('tracking_id', $tracking)->first();

                $order->status = 'Return Received By Destination Hub';
                $order->save();
            }
        }

        foreach ($trackings as $tracking) {
            Scan::where('tracking_id', $tracking)->delete();
        }
        \Toastr::success('Order Received By Destination Hub Successfully.', 'Success !!', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
        // return redirect()->back()->with('message', 'Order Received By Destination Hub Successfully');
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

    public function third_party_payment(Request $request)
    {



        for ($i = 0; $i < count($request->tracking_ids); $i++) {
            $order = Order::where('tracking_id', $request->tracking_ids[$i])->first();
            if ($order->status == 'Transfer Cancel Order') {
                $order->update([
                    'status' => 'Return Payment Processing'
                ]);
                $data = new OrderStatusHistory();
                $data->tracking_id  = $request->tracking_ids[$i];
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Return Payment Processing';
                $data->save();
            } elseif ($order->status == 'Transfer Order Delivered') {
                $order->update([
                    'status' => 'Payment Processing'
                ]);
                $data = new OrderStatusHistory();
                $data->tracking_id  =  $request->tracking_ids[$i];
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Payment Processing';
                $data->save();
            } elseif ($order->status == 'Redx Cancel Order') {
                $order->update([
                    'status' => 'Return Payment Processing'
                ]);
                $data = new OrderStatusHistory();
                $data->tracking_id  =  $request->tracking_ids[$i];
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Return Payment Processing';
                $data->save();
            } elseif ($order->status == 'Redex Order Delivered') {
                $order->update([
                    'status' => 'Payment Processing'
                ]);
                $data = new OrderStatusHistory();
                $data->tracking_id  =  $request->tracking_ids[$i];
                $data->user_id      = Auth::user()->id;
                $data->status       = 'Payment Processing';
                $data->save();
            }
        }

        return redirect()->back()->with('message', 'Payment Confirmed');
    }

    public function callback(Request $request)
    {
        // $invoiceNumber = $request->input('invoice_number');
        // $order = Order::where('tracking_id', $invoiceNumber)->first();
        // $status = $request->input('status');
        // if ($status == 'ready-for-delivery') {
        //     $order->update([
        //         'status' => 'Redx Order Delivered',
        //     ]);
        // } elseif ($status == 'delivery-in-progress') {
        //     $order->update([
        //         'status' => 'Redx Pathao Order Delivered',
        //     ]);
        // } elseif ($status == 'delivered') {
        //     $order->update([
        //         'status' => 'Redx Pathao Order Delivered',
        //     ]);
        // } elseif ($status == 'agent-hold') {
        //     $order->update([
        //         'status' => 'Redx Cancel Order',
        //     ]);
        // } elseif ($status == 'agent-returning') {
        //     $order->update([
        //         'status' => 'Redx Cancel Order',
        //     ]);
        // } elseif ($status == 'returned') {
        //     $order->update([
        //         'status' => 'Redx Cancel Order',
        //     ]);
        // } elseif ($status == 'delivered') {
        //     $order->update([
        //         'status' => 'Redx Cancel Order',
        //     ]);
        // }
        // return response()->json(['message' => 'Update received']);

        $invoiceNumber = $request->input('invoice_number');
        $status = $request->input('status');

        // Find the order
        $order = Order::where('tracking_id', $invoiceNumber)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update the order status based on RedX status
        switch ($status) {
            case 'ready-for-delivery':
                $order->update(['status' => 'Redx Order Delivered']);
                break;
            case 'delivery-in-progress':
            case 'delivered':
                $order->update(['status' => 'Redx Pathao Order Delivered']);
                break;
            case 'agent-hold':
            case 'agent-returning':
            case 'returned':
                $order->update(['status' => 'Redx Cancel Order']);
                break;
            default:
                Log::warning('Unknown status received from RedX', ['status' => $status]);
                return response()->json(['error' => 'Unknown status'], 400);
        }

        // Respond to RedX
        return redirect()->back();
    }
}
