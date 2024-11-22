<?php

namespace App\Http\Controllers;

use App\Admin\Company;
use App\Admin\Complain;
use App\Admin\Problem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ComplainController extends Controller
{

    public function index()
    {
        $data = Complain::orderBy('id', 'DESC')
            ->leftJoin('users', 'complains.mobile', 'users.id')
            ->select('complains.*', 'users.mobile as phone')
            ->get();
        return view('Admin.Complain.complain', compact('data'));
    }


    public function create(Request $request)
    {

        $date = date('Y-m-d');
        // $time = date('G:i:s');
        $time = date('G:i');
        // $user = User::where('role', $request->id)->get();
        $user = User::orderBy('id', 'DESC')->where('role', '!=', '1')->get();
        $problem = Problem::orderBy('id', 'DESC')->get();
        return view('Admin.Complain.complain_create', compact('date', 'time', 'user', 'problem'));
    }


    public function find_user(Request $request)
    {
        $data = User::where('role', $request->id)->pluck("mobile", "id");
        return response()->json($data);
    }

    public function find_details(Request $request)
    {
        $data = User::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = [];
        $data = array(
            'name'          => $request->name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'role'          => 'Call Center',
            'date'          => $request->date,
            'time'          => $request->time,
            'call_duration' => $request->call_duration,
            'status'        => 'Submited',
            'priority'       => $request->priority,
            'comment'       => $request->comment,
        );
        $data2['problem'] = $request->problem;
        foreach ($data2 as $values) {

            $data['problem'] = implode(" , ", $values);
        }
        $insert = DB::table('complains')->insert([$data]);

        // $data = new Complain();
        // $data->name             = $request->name;
        // $data->mobile           = $request->mobile;
        // $data->email            = $request->email;
        // $data->role             = $request->role;
        // $data->date             = $request->date;
        // $data->time             = $request->time;
        // $data->call_duration    = $request->call_duration;
        // $data->problem          = $request->problem;
        // $data->comment          = $request->comment;
        // $data->status           = $request->status;
        // $data->save();
        return redirect()->back()->with('message', 'Ticket Submitted Successfully');
    }

    public function edit(Request $request)
    {
        $data = Complain::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {

        Complain::where('id', $request->id)->update(['status' => $request->status]);

        return redirect()->back()->with('message', 'Ticket Updated Successfully');
    }
    public function payment_request()
    {

        $datas = Complain::orderBy('id', 'DESC')->where('priority', 'Payment Request')->get();
        return view('Admin.Complain.payment_request', compact('datas'));
    }

    public function status(Request $request)
    {
        $data = Complain::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';
        } else {
            $data->status = '1';
        }
        $data->save();
        return redirect()->back()->with('status', 'Ticket Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = Complain::where('id', $request->id);
        $data->delete();
        return redirect()->back()->with('danger', 'Ticket Deleted Successfully');
    }

    public function report(Request $request)
    {
        $today = date('Y-m-d');

        if ($request->todate && $request->fromdate) {
            $todate = $request->todate;
            $fromdate = $request->fromdate;
        } else {
            $todate = $today;
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
        }
        $complain = Complain::orderBy('id', 'DESC')
            ->whereBetween('date', [$fromdate, $todate])
            ->get();
        return view('Admin.Complain.datewise_report', compact('complain', 'fromdate', 'todate'));
    }

    public function datewise_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $complain = Complain::orderBy('id', 'DESC')
            ->whereBetween('date', [$fromdate, $todate])
            ->get();
        return view('Admin.Complain.datewise_print', compact('company', 'complain', 'fromdate', 'todate'));
    }

    public function statuswise(Request $request)
    {
        if ($request->fromdate && $request->todate) {
            $fromdate = $request->fromdate;
            $todate = $request->todate;
        } else {
            $fromdate = date('Y-m-d', strtotime('now - 3day'));
            $todate = date('Y-m-d');
        }

        $status = $request->status;
        $complain = Complain::orderBy('id', 'DESC')
            ->where('status', $status)
            ->whereBetween('date', [$fromdate, $todate])
            ->get();
        return view(
            'Admin.Complain.statuswise_report',
            compact('status', 'complain', 'fromdate', 'todate')
        );
    }

    public function statuswise_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $today = date('Y-m-d');
        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $status = $request->status;
        $complain = Complain::orderBy('id', 'DESC')
            ->where('status', $status)
            ->whereBetween('date', [$fromdate, $todate])
            ->get();
        return view(
            'Admin.Complain.statuswise_print',
            compact('company', 'status', 'complain', 'fromdate', 'todate')
        );
    }


    public function complain()
    {

        if (Auth::user()->role == 12) {
            $data = Complain::orderBy('id', 'DESC')->orWhere('mobile', Auth::user()->mobile)->orWhere('email', Auth::user()->email)->get();
        } else {

            $data = Complain::orderBy('id', 'DESC')->get();
        }
        return view('Admin.Complain.complainView', compact('data'));
    }

    public function complain_create(Request $request)
    {
        $date = date('Y-m-d');
        $time = date('G:i');
        // $user = User::orderBy('id', 'DESC')->where('role', '!=', '1')->where('role', '!=', '12')->get();
        $user = User::where('id', Auth::user()->id)->first();
        $problem = Problem::orderBy('id', 'DESC')->get();
        return view('Admin.Complain.create', compact('date', 'time', 'user', 'problem'));
    }



    public function merchant_complain(Request $request)
    {

        $data = [];
        $data = array(
            'name'          => $request->name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'role'          => $request->role,
            'date'          => $request->date,
            'time'          => $request->time,
            'call_duration' => $request->call_duration,
            'status'        => 'Submited',
            'priority'      => $request->priority,
            'comment'       => $request->comment,
            // 'user_id'       => 1,
        );

        // dd($request->problem);
        $data2['problem'] = $request->problem;

        foreach ($data2 as $values) {

            $data['problem'] = implode(" , ", $values);
        }

        $insert = DB::table('complains')->insert([$data]);

        return redirect()->back()->with('message', 'Complain Submitted Successfully');
    }
}
