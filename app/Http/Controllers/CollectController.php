<?php

namespace App\Http\Controllers;

use App\Admin\AgentPayment;
use App\Admin\AgentPaymentDetail;
use App\Admin\Company;
use App\Admin\Merchant;
use App\Admin\MerchantPayment;
use App\Admin\MerchantPaymentDetail;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use App\Admin\Rider;
use App\Admin\Transfer;
use App\Admin\TransferDetail;
use App\AgentPaymentHistory;
use App\AgentPaymentHistoryDetails;
use App\Attendance;
use App\RiderAttendence;
use App\RiderPaymentHistory;
use App\RiderPaymentHistoryDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DateTime;
use Illuminate\Support\Facades\DB;

class CollectController extends Controller
{
    public function agent_collect(Request $request)
    {
        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }
        $payments_data = AgentPayment::whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)->with('agent', 'createby', 'updateby')->where('status', 0)->get();


        $payments = [];
        foreach ($payments_data as $payment) {
            // return $payment;
            $invoice_payment_details = AgentPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();
            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });
            $payment['t_collect'] = OrderConfirm::whereIn('tracking_id', $array)->sum('collect');
            $payments[] = $payment;
        }


        return view('Backend.Agent.index', compact('fromdate', 'todate', 'payments'));
    }


    public function rider_payment_report(Request $request)
    {
        // return "djghdfhgbdf";
        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $fromdate = date('Y-m-d', strtotime('now - 14day'));
            $todate = date('Y-m-d');
        }
        $payments_data = RiderPayment::whereDate('created_at', '>=', $fromdate)
            ->whereDate('created_at', '<=', $todate)->with('create', 'rider', 'updateUser')->get();
        $payments = [];
        foreach ($payments_data as $payment) {
            $invoice_payment_details = RiderPaymentDetail::where('invoice_id',  $payment->invoice_id)->select('tracking_id')->get();
            $array = $invoice_payment_details->map(function ($item) {
                return collect($item)->values();
            });
            $payment['t_collect'] = OrderConfirm::whereIn('trackingId', $array)->sum('collect');
            $payments[] = $payment;
        }
        return view(
            'Admin.Report.Payment.rider_payment_report',
            compact('payments', 'fromdate', 'todate',)
        );
    }


    public function agent_collect_show(AgentPayment $agent)
    {
        $paymentDetails = AgentPaymentDetail::where('invoice_id', $agent->invoice_id)
            ->join('orders', 'orders.tracking_id', 'agent_payment_details.tracking_id')
            ->join('order_confirms', 'order_confirms.tracking_id', 'agent_payment_details.tracking_id')
            ->join('merchants', 'merchants.user_id', 'orders.user_id')
            ->join('users', 'users.id', 'orders.user_id')
            ->select('agent_payment_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'merchants.business_name as merchant_name')
            ->get();
        $total = $paymentDetails->sum('collect');

        $agent = AgentPayment::where('invoice_id', $agent->invoice_id)->with('agent', 'createby', 'updateby')->where('status', 0)->first();

        $company = Company::first();

        return view('Backend.Agent.show', compact('agent', 'paymentDetails', 'company', 'total'));
    }
    public function agent_collect_print(AgentPayment $agent)
    {
        $paymentDetails = AgentPaymentDetail::where('invoice_id', $agent->invoice_id)
            ->join('orders', 'orders.tracking_id', 'agent_payment_details.tracking_id')
            ->join('order_confirms', 'order_confirms.tracking_id', 'agent_payment_details.tracking_id')
            ->join('merchants', 'merchants.user_id', 'orders.user_id')
            ->join('users', 'users.id', 'orders.user_id')
            ->select('agent_payment_details.*', 'orders.*', 'users.*', 'order_confirms.*', 'merchants.business_name as merchant_name')
            ->get();
        $total = $paymentDetails->sum('collect');

        $agent = AgentPayment::where('invoice_id', $agent->invoice_id)->with('agent', 'createby', 'updateby')->where('status', 0)->first();

        $company = Company::first();

        return view('Backend.Agent.print', compact('agent', 'paymentDetails', 'company', 'total'));
    }


    public function agent_payment_collec(AgentPayment $agent)
    {
        $details = AgentPaymentDetail::where('invoice_id', $agent->invoice_id)->get();

        if ($details) {
            foreach ($details as $detail) {

                if ($detail->order_status == 'Delivered Amount Send to Fulfillment') {

                    Order::where('tracking_id', $detail->tracking_id)->update(['status' => 'Payment Processing']);

                    $data = new OrderStatusHistory();
                    $data->tracking_id  = $detail->tracking_id;
                    $data->user_id      = Auth::user()->id;
                    $data->status       = 'Payment Processing';
                    $data->save();

                    $data = new AgentPaymentDetail();
                    $data->order_status       = 'Delivered';
                    $data->invoice_id = $agent->invoice_id;
                    $data->tracking_id  = $detail->tracking_id;
                    $data->save();
                } else {

                    Order::where('tracking_id', $detail->tracking_id)->update(['status' => 'Return Payment Processing']);

                    $data = new OrderStatusHistory();
                    $data->tracking_id  = $detail->tracking_id;
                    $data->user_id      = Auth::user()->id;
                    $data->status       = 'Return Payment Processing';
                    $data->save();

                    $data = new AgentPaymentDetail();
                    $data->order_status       = 'Partial';
                    $data->invoice_id = $agent->invoice_id;
                    $data->tracking_id  = $detail->tracking_id;
                    $data->save();
                }
            }

            AgentPayment::where('invoice_id', $agent->invoice_id)->update(['status' => 1]);

            \Toastr::success('Successfully collected from agent.', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }




        return AgentPayment::where('invoice_id', $agent->invoice_id)->get();
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
                }
            } else {
                foreach ($trackingDetails as $trackingdetail) {
                    TransferDetail::where('invoice_id', $trackingdetail->invoice_id)->update(['updated_by' => Auth::user()->id]);
                    Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Reach to Fullfilment']);
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
                    Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Reach to Branch']);
                }
            } else {
                foreach ($trackingDetails as $trackingdetail) {
                    TransferDetail::where('invoice_id', $trackingdetail->invoice_id)->update(['updated_by' => Auth::user()->id]);
                    Order::where('tracking_id', $trackingdetail->tracking_id)->update(['status' => 'Return Reach For Fullfilment']);
                }
            }
        }
        Transfer::where('invoice_id',  $transfer->invoice_id)->update(['status' => 1]);
        return back();
    }





    public function merchant_payment_collect()
    {
        $merchant_payments = MerchantPayment::where('m_payments.status', "Payment Processing")
            ->join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')
            ->select('users.*', 'm_payments.*', 'merchants.business_name as business_name')->get();


       

       
        return view('Backend.Merchant.Payment.index', compact('merchant_payments'));
    }


    public function merchant_payment_show(MerchantPayment $paymentinfo, Request $request)
    {
        $invoice = $request->id;
        return   $merchant_payments =   MerchantPayment::join('merchants', 'merchants.id', 'm_payments.m_id')->join('users', 'm_payments.m_user_id', 'users.id')->select('m_payments.*', 'users.*', 'merchants.business_name as business_name')
            ->where('invoice_id', $invoice)
            ->first();


        return view('Backend.Merchant.Payment.show', compact('merchant_payment'));
    }
    public function merchant_payment_conform(MerchantPayment $paymentinfo, Request $request)
    {
     
        // try {
            $invoice = $request->id;

            $orders =   MerchantPaymentDetail::where('invoice_id', $invoice)->get();

            foreach ($orders as $order) {
                $data =   Order::where('tracking_id', $order->tracking_id)->first();


                if ($data->status == "Payment Processing Complete") {
                    $data->update(['status' => 'Payment Completed']);

                    $orderstatushistory = new OrderStatusHistory();
                    $orderstatushistory->tracking_id  = $order->tracking_id;
                    $orderstatushistory->user_id      = Auth::user()->id;
                    $orderstatushistory->status       = 'Payment Completed';
                    $orderstatushistory->save();
                }
            }
            $merchant_payment =   MerchantPayment::where('invoice_id', $invoice)->first();

            $merchant_payment->update(['status' => 'Payment Received By Merchant']);

            \Toastr::success('Merchant Payment Successfully', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            
            return redirect()->back();
            
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }

    public function rider_payment_collect(Request $request)
    {
        $data = RiderPaymentHistory::where('rider_payment_histories.status', 1)
            ->join('users', 'users.id', 'rider_payment_histories.rider_id')
            ->select('users.*', 'rider_payment_histories.*')->get();
        return view('Backend.Merchant.Payment.rider_payment_processing', compact('data'));
    }
    public function  branch_payment_collect(Request $request)
    {
        $data = AgentPaymentHistory::where('agent_payment_histories.status', 1)
            ->join('agents', 'agents.user_id', 'agent_payment_histories.agent_id')
            ->join('users', 'users.id', 'agents.user_id')
            ->select('agent_payment_histories.*', 'agents.area', 'users.name')
            ->get();

        return view('Backend.Merchant.Payment.branch_payment_processing', compact('data'));
    }

    public function rider_payment_collect_history(Request $request)
    {
        $company = Company::latest('id')->first();

        $data = RiderPaymentHistory::where('rider_payment_histories.invoice_id', $request->invoice_id)
            ->join('users', 'users.id', 'rider_payment_histories.rider_id')
            ->select('users.*', 'rider_payment_histories.*')
            ->first();



        $details = RiderPaymentHistoryDetails::where('rider_payment_history_details.invoice_id', $request->invoice_id)
            ->join('users', 'users.id', 'rider_payment_history_details.rider_id')
            ->join('riders', 'riders.user_id', 'rider_payment_history_details.rider_id')
            ->select('users.name', 'users.mobile', 'users.address', 'riders.*', 'rider_payment_history_details.*')->get();

        $delivery_charge = RiderPaymentHistoryDetails::where('rider_payment_history_details.invoice_id', $request->invoice_id)
            ->where('rider_payment_history_details.status', 'Successfully Delivered')
            ->join('users', 'users.id', 'rider_payment_history_details.rider_id')
            ->join('riders', 'riders.user_id', 'rider_payment_history_details.rider_id')
            ->select('users.name', 'users.mobile', 'users.address', 'riders.*', 'rider_payment_history_details.*')->get();

        $total_delivery_charge = $delivery_charge->sum('r_delivery_charge');


        $pickup_charge = RiderPaymentHistoryDetails::where('rider_payment_history_details.invoice_id', $request->invoice_id)
            ->where('rider_payment_history_details.status', 'Pickup Done')
            ->join('users', 'users.id', 'rider_payment_history_details.rider_id')
            ->join('riders', 'riders.user_id', 'rider_payment_history_details.rider_id')
            ->select('users.name', 'users.mobile', 'users.address', 'riders.*', 'rider_payment_history_details.*')->get();

        $total_pickup_charge = $pickup_charge->sum('r_pickup_charge');

        $total_return_charge = $details->sum('r_return_charge');





        return view('Backend.History.rider_payment_history_print', compact('data', 'total_delivery_charge', 'total_pickup_charge', 'total_return_charge', 'details', 'company'));
    }


    public function branch_payment_collect_history(Request $request)
    {
        $company = Company::latest('id')->first();

        $details = AgentPaymentHistory::where('agent_payment_histories.invoice_id', $request->invoice_id)
            ->join('agents', 'agents.user_id', 'agent_payment_histories.agent_id')
            ->join('users', 'users.id', 'agents.user_id')
            ->select('agent_payment_histories.*', 'agents.area', 'users.name')
            ->first();

        $data = AgentPaymentHistoryDetails::where('agent_payment_history_details.invoice_id', $request->invoice_id)
            ->join('agents', 'agents.user_id', 'agent_payment_history_details.agent_id')
            ->join('users', 'users.id', 'agents.user_id')
            ->select('users.name', 'users.mobile', 'users.address', 'agents.area', 'agents.a_pickup_charge', 'agents.a_delivery_charge', 'agents.a_return_charge', 'agent_payment_history_details.*')
            ->get();
        // return $data;     

        $delivery_charge = AgentPaymentHistoryDetails::where('agent_payment_history_details.invoice_id', $request->invoice_id)
            ->where('agent_payment_history_details.status', 'Successfully Delivered')
            ->join('agents', 'agents.user_id', 'agent_payment_history_details.agent_id')
            ->join('users', 'users.id', 'agents.user_id')
            ->select('agents.area', 'agents.a_pickup_charge', 'agents.a_delivery_charge', 'agents.a_return_charge', 'agent_payment_history_details.*')
            ->get();
        $total_delivery_charge = $delivery_charge->sum('a_delivery_charge');


        $pickup_charge = AgentPaymentHistoryDetails::where('agent_payment_history_details.invoice_id', $request->invoice_id)
            ->where('agent_payment_history_details.status', 'Pickup Done')
            ->join('agents', 'agents.user_id', 'agent_payment_history_details.agent_id')
            ->join('users', 'users.id', 'agents.user_id')
            ->select('agents.area', 'agents.a_pickup_charge', 'agents.a_delivery_charge', 'agents.a_return_charge', 'agent_payment_history_details.*')
            ->get();
        $total_pickup_charge = $pickup_charge->sum('a_pickup_charge');

        $total_return_charge = $data->sum('a_return_charge');

        return view('Backend.History.branch_payment_history_print', compact('data', 'total_delivery_charge', 'total_pickup_charge', 'total_return_charge', 'details', 'company'));
    }

    /*rider attendance*/
    public function rider_attendance(Request $request)
    {
        $agent = $request->agent ?? '';
        $user = User::where('role', 8)->get();

        $datas = Rider::where('riders.area', $request->agent)
            ->join('users', 'users.id', 'riders.user_id')
            ->select('users.name', 'users.mobile', 'riders.user_id', 'riders.area')
            ->get();

        //return $datas;
        return  view('Backend.Rider.attendance', compact('user', 'datas', 'agent'));
    }

    public function rider_attendance_temp_store(Request $request)
    {



        $count = (count($request->all_data)) / 7;
        //dd($count);

        $j = 0;

        for ($i = 0; $i < $count; $i++) {

            $array_data[$i]['user-id'] = $request->all_data[$j++];
            $array_data[$i]['rider-name'] = $request->all_data[$j++];
            $array_data[$i]['mobile'] = $request->all_data[$j++];
            $array_data[$i]['area'] = $request->all_data[$j++];
            $array_data[$i]['status'] = $request->all_data[$j++];
            $array_data[$i]['intime'] = $request->all_data[$j++];
            $array_data[$i]['outtime'] = $request->all_data[$j++];
        }

        Session::put('all_data', $array_data);
    }

    public function rider_all_attendance_store(Request $request)
    {


        $count = (count($request->all_data)) / 7;
        //dd($count);

        $j = 0;

        for ($i = 0; $i < $count; $i++) {

            $data = new Attendance();
            $data->user_id = $request->all_data[$j++];
            $data->name = $request->all_data[$j++];
            $data->mobile = $request->all_data[$j++];
            $data->area = $request->all_data[$j++];
            $data->status = $request->all_data[$j++];
            $data->in_time = $request->all_data[$j++];
            $data->out_time  = $request->all_data[$j++];
            $data->type = "Rider";
            $data->create_by = Auth::user()->id;
            $data->save();
        }
        //  return redirect()->back();
    }


    public function employee_attendance(Request $request)
    {

        $user = User::orderBy('id', 'DESC')
            ->whereIn('role', ['2', '4', '6', '16'])
            // ->orwhere('role', 2)
            // ->orWhere('role', '!=', 4)
            // ->orwhere('role', 6)
            // ->orwhere('role', 16)
            ->get();


        return view('Backend.Rider.Employe_attendance', compact('user'));
    }

    public function rider_confirm_attendance(Request $request)
    {
        return view('Backend.Rider.all_attendance');
    }

    public function employee_all_attendance_store(Request $request)
    {


        $count = (count($request->all_data)) / 7;
        //dd($count);

        $j = 0;

        for ($i = 0; $i < $count; $i++) {

            $data = new Attendance();
            $data->user_id = $request->all_data[$j++];
            $data->name = $request->all_data[$j++];
            $data->mobile = $request->all_data[$j++];
            $data->type = $request->all_data[$j++];
            $data->status = $request->all_data[$j++];
            $data->in_time = $request->all_data[$j++];
            $data->out_time  = $request->all_data[$j++];
            $data->area = "HeadOffice";
            $data->create_by = Auth::user()->id;
            $data->save();
        }
    }


    public function daily_attendance(Request $request)
    {
        //  dd($request->all());

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');


        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        $employee = $request->employee;
        $todate = $request->todate;

        if ($employee && $todate) {

            $Employee = Attendance::select('name')->distinct()->get();

            $todate = $request->todate;
            $employee = $request->employee;
            $data2 = Attendance::orderBy('id', 'DESC')->where('name', $employee)->whereDate('created_at', $request->todate)->get();

            return view('Backend.Rider.daily_attendance', compact('data2', 'employee', 'Employee', 'todate'));
        } else {
            $Employee = Attendance::select('name')->distinct()->get();
            $todate = $request->todate;
            $data2 = Attendance::orderBy('id', 'DESC')->whereDate('created_at', $request->todate)->get();
            return view('Backend.Rider.daily_attendance', compact('data2', 'employee', 'Employee', 'todate'));
        }
    }

    public function daily_attendance_print(Request $request)
    {


        $d = new DateTime("now");
        $today = $d->format('Y-m-d');


        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        $employee = $request->employee;
        $todate = $request->todate;

        if ($employee && $todate) {
            $company = Company::orderBy('id', 'DESC')->get();
            $todate = $request->todate;
            $employee = $request->employee;
            $print_data = Attendance::orderBy('id', 'DESC')->where('name', $employee)->whereDate('created_at', $request->todate)->get();

            return view('Backend.Rider.daily_employee_attendance_print', compact('todate', 'employee', 'company', 'print_data'));
        } else {
            $company = Company::orderBy('id', 'DESC')->get();
            $todate = $request->todate;
            $print_data = Attendance::orderBy('id', 'DESC')->whereDate('created_at', $request->todate)->get();
            return view('Backend.Rider.daily_employee_attendance_print', compact('todate', 'company', 'print_data'));
        }
    }


    public function date_wise_attendance(Request $request)
    {

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        $branch = $request->branch;
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $employee = $request->employee;

        if ($branch && $todate && $fromdate && $employee) {
            if ($request->todate) {
                $todate = $request->todate;
            } else {
                $todate = $today;
            }

            $Branch = Attendance::select('area')->distinct()->get();

            $branch = $request->branch;
            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $employee = $request->employee;

            $branch_wise_attendance = Attendance::orderBy('id', 'DESC')->where('area', $branch)->where('name', $employee)->whereBetween(DB::raw('DATE(created_at)'), [$fromdate, $todate])->get();




            return view('Backend.Rider.datewise_attendance', compact('todate', 'branch_wise_attendance', 'fromdate', 'employee', 'branch', 'Branch'));
        } else {

            if ($request->todate) {
                $todate = $request->todate;
            } else {
                $todate = $today;
            }

            $Branch = Attendance::select('area')->distinct()->get();


            $todate = $request->todate;
            $fromdate = $request->fromdate;


            $branch_wise_attendance = Attendance::orderBy('id', 'DESC')->whereBetween(DB::raw('DATE(created_at)'), [$fromdate, $todate])->get();




            return view('Backend.Rider.datewise_attendance', compact('todate', 'branch_wise_attendance', 'fromdate', 'employee', 'branch', 'Branch'));
        }
    }

    public function date_wise_attendance_print(Request $request)
    {

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        $branch = $request->branch;
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $employee = $request->employee;

        if ($branch && $todate && $fromdate && $employee) {
            if ($request->todate) {
                $todate = $request->todate;
            } else {
                $todate = $today;
            }

            $company = Company::orderBy('id', 'DESC')->get();

            $branch = $request->branch;
            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $employee = $request->employee;

            $branch_wise_attendance = Attendance::orderBy('id', 'DESC')->where('area', $branch)->where('name', $employee)->whereBetween(DB::raw('DATE(created_at)'), [$fromdate, $todate])->get();




            return view('Backend.Rider.branch_wise_employee_attendance_print', compact('todate', 'branch_wise_attendance', 'fromdate', 'employee', 'branch', 'company'));
        } else {

            if ($request->todate) {
                $todate = $request->todate;
            } else {
                $todate = $today;
            }

            $company = Company::orderBy('id', 'DESC')->get();


            $todate = $request->todate;
            $fromdate = $request->fromdate;


            $branch_wise_attendance = Attendance::orderBy('id', 'DESC')->whereBetween(DB::raw('DATE(created_at)'), [$fromdate, $todate])->get();




            return view('Backend.Rider.branch_wise_employee_attendance_print', compact('todate', 'branch_wise_attendance', 'fromdate', 'employee', 'branch', 'company'));
        }
    }

    public function branch_wise_employee(Request $request)
    {
        $data = Attendance::where('area', $request->id)->get();

        $option = "";
        foreach ($data as $key => $value) {
            $user_id = $value->name;
            $name = $value->name;
            $option .= "<option" . ($key == 0 ? ' selected ' : '') . " value='$user_id' >$name</option>";
        }
        return $option;
    }

    public function monthly_attendance(Request $request)
    {
        //  dd($request->all());
        // $today = today();





        $Employee = Attendance::select('name', 'type')->distinct()->get();





        $todate = $request->todate;
        $employee = $request->employee;
        $startDate = Carbon::now()->format('m');


        $monthly_attendance = Attendance::select('name', 'type')->where('name', $request->employee)->whereMonth('created_at', '=', Carbon::parse($request->todate)->format('m'))->distinct()->get();



        return view('Backend.Rider.monthly_attendance', compact('Employee', 'monthly_attendance', 'todate', 'employee'));
    }


    public function monthly_attendance_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $Employee = Attendance::select('name', 'type')->distinct()->get();
        $todate = $request->todate;
        $employee = $request->employee;
        $startDate = Carbon::now()->format('m');
        $monthly_attendance = Attendance::select('name', 'type')->where('name', $request->employee)->whereMonth('created_at', '=', Carbon::parse($request->todate)->format('m'))->distinct()->get();
        return view('Backend.Rider.monthly_employee_attendance_print', compact('company', 'todate', 'monthly_attendance', 'Employee', 'employee'));
    }

    public function monthly_attendance_all_employee(Request $request)
    {

      //  dd($request->all());
        $Employee = Attendance::select('name', 'type')->distinct()->get();


        $todate = $request->todate;
        $employee = $request->employee;
        $startDate = Carbon::now()->format('m');
        if (isset($todate)) {
            $monthly_attendance = Attendance::select('name', 'type')->whereMonth('created_at', '=', Carbon::parse($request->todate)->format('m'))->distinct()->get();
            return view('Backend.Rider.all_employee_monthly_attendance', compact('Employee', 'todate', 'employee', 'monthly_attendance'));
        }



        return view('Backend.Rider.all_employee_monthly_attendance', compact('Employee', 'todate'));
    }

    public function monthly_attendance_all_employee_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $todate = $request->todate;
        $employee = $request->employee;
        $startDate = Carbon::now()->format('m');
        if (isset($todate)) {
            $monthly_attendance_all = Attendance::select('name', 'type')->whereMonth('created_at', '=', Carbon::parse($request->todate)->format('m'))->distinct()->get();
            return view('Backend.Rider.monthly_all_employee_attendance_print', compact('company', 'todate', 'monthly_attendance_all'));
        }

        return view('Backend.Rider.monthly_all_employee_attendance_print', compact('todate', 'company'));
    }

    public function branch_wise_monthly_attendance(Request $request)
    {

        $Branch = Attendance::select('area')->distinct()->get();
        $todate = $request->todate;
        $branch = $request->branch;

        $startDate = Carbon::now()->format('m');

        $branch_wise_monthly_attendance = Attendance::select('name', 'area')->where('area', $branch)->whereMonth('created_at', '=', Carbon::parse($request->todate)->format('m'))->distinct()->get();



        return view('Backend.Rider.Branch_wise_monthly_attendance', compact('Branch', 'todate', 'branch', 'branch_wise_monthly_attendance'));
    }

    public function branch_wise_monthly_attendance_print(Request $request){

       
        $company = Company::orderBy('id', 'DESC')->get();
        $todate = $request->todate;
        $branch = $request->branch;

        $startDate = Carbon::now()->format('m');

        $branch_wise_monthly_attendance = Attendance::select('name', 'area')->where('area', $branch)->whereMonth('created_at', '=', Carbon::parse($request->todate)->format('m'))->distinct()->get();
         
        
        return view('Backend.Rider.branch_wise_monthly_employee_attendance_print',compact('company','todate','branch','branch_wise_monthly_attendance'));
    }

    public function employee_wise_monthly_attendance_summary(Request $request){
        return 'test';
    }
}
