<?php

namespace App\Http\Controllers;

use App\Admin\Company;
use App\Expense;
use App\Income;
use App\IncomeType;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $income_type_list = IncomeType::orderBy('id', 'DESC')->get();
        return view('Admin.Income.Income', compact('income_type_list'));
    }

    public function store(Request $request)
    {
        $data = new IncomeType();
        $data->type_name = $request->name;
        $data->status = '1';
        $data->create_by = Auth::user()->id;
        $data->save();
        return redirect()->back()->with('Success', 'Data Submit Successfully');
    }

    public function edit(Request $request)
    {
        $data = IncomeType::where('id', $request->id)->get();
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $data = IncomeType::find($request->id);
        $data->update([
            'type_name' => $request->name,
            'status' => '1',
            'create_by' => Auth::user()->id
        ]);
        return redirect()->back()->with('Success', 'Data update Successfully');
    }

    public function destroy(Request $request)
    {
        $data = IncomeType::find($request->id);
        $data->delete();
        return redirect()->back()->with('Success', 'Data Deleted Successfully');
    }
    public function list()
    {
        if ($last = Income::all()->last()) {
            $sl = $last->id;
        } else {
            $sl = 0;
        }

        $income_type = IncomeType::orderBy('id', 'DESC')->get();
        $income_list = Income::orderBy('id', 'DESC')->get();

        $merchant = User::orderBy('users.id', 'DESC')
            ->where('role', 12)
            ->join('merchants', 'users.id', 'merchants.user_id')
            ->select(
                'merchants.*',
                'users.name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(merchants.created_at, '%y') as od")
            )
            ->get();



        return view('Admin.Income.IncomeList', compact('income_list', 'income_type', 'sl', 'merchant'));
    }

    public function list_store(Request $request)
    {
        $data = new Income();
        $data->voucher_no = $request->voucher_no;
        $data->date = $request->date;
        $data->income_type     = $request->income_type;
        $data->income_for = $request->income_for;
        $data->amount = $request->amount;
        $data->details = $request->details;
        $data->status = '1';
        $data->create_by  = Auth::user()->id;
        $data->save();

        return redirect()->back()->with('success', 'income  Created Successfully');
    }
    public function list_destroy(Request $request)
    {
        $data = Income::find($request->id);
        $data->delete();
        return redirect()->back()->with('success', 'income  Deleted Successfully');
    }

    public function list_edit(Request $request)
    {
        $data = Income::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function list_update(Request $request)
    {
        $data = Income::find($request->id);
        $data->update([
            'date' => $request->date,
            'income_type' => $request->income_type,
            'income_for' => $request->income_for,
            'amount' => $request->amount,
            'details' => $request->details,
        ]);
        return redirect()->back()->with('success', 'income  Updated Successfully');
    }

    public function income_report(Request $request)
    {
        // dd($request->all());
        $income_types = IncomeType::get();
        $merchant = User::orderBy('users.id', 'DESC')
            ->where('role', 12)
            ->join('merchants', 'users.id', 'merchants.user_id')
            ->select(
                'merchants.*',
                'users.name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(merchants.created_at, '%y') as od")
            )
            ->get();

        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        $income_type = $request->income_type ?? '';
        $income_for = $request->income_for ?? '';

        if ($fromdate && $todate) {
            $datas = Income::whereBetween('date', [$fromdate, $todate])->get();
            return view('Admin.Income.income_date_wise_report', compact('fromdate', 'todate', 'income_types', 'income_for', 'income_type', 'merchant', 'datas'));
        }

        if ($request->income_type) {
            $datas = Income::where('income_type', $request->income_type)->get();
            return view('Admin.Income.income_date_wise_report', compact('fromdate', 'todate', 'income_types', 'income_for', 'income_type', 'merchant', 'datas'));
        }

        if ($request->income_for) {
            $datas = Income::where('income_for', $request->income_for)->get();
            return view('Admin.Income.income_date_wise_report', compact('fromdate', 'todate', 'income_types', 'income_for', 'income_type', 'merchant', 'datas'));
        }

        if ($request->income_type && $request->income_for) {
            $datas = Income::where('income_type', $request->income_type)->where('income_for', $request->income_for)->get();;
            return view('Admin.Income.income_date_wise_report', compact('fromdate', 'todate', 'income_types', 'income_for', 'income_type', 'merchant', 'datas'));
        }

        if ($request->income_type && $request->income_for && $fromdate && $todate) {
            $datas = Income::where('income_type', $request->expense_type)->where('income_for', $request->expense_for)->whereBetween('date', [$fromdate, $todate])->get();

            return view('Admin.Income.income_date_wise_report', compact('fromdate', 'todate', 'income_types', 'income_for', 'income_type', 'merchant', 'datas'));
        }


        return view('Admin.Income.income_date_wise_report', compact('income_types', 'merchant', 'income_type', 'income_for', 'fromdate', 'todate'));
    }
    public function income_report_print(Request $request)
    {
        $company = Company::orderBy('id', 'DESC')->get();
        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        $income_type = $request->income_type ?? '';
        $income_for = $request->income_for ?? '';

        if ($fromdate && $todate) {
            $datas = Income::whereBetween('date', [$fromdate, $todate])->get();

           // return $datas;
            return view('Admin.Income.income_date_wise_print', compact('fromdate', 'company', 'todate', 'income_for', 'income_type', 'datas'));
        }

        if ($request->income_type) {
            $datas = Income::where('income_type', $request->income_type)->get();
            return view('Admin.Income.income_date_wise_print', compact('fromdate', 'company', 'todate',  'income_for', 'income_type', 'datas'));
        }

        if ($request->income_for) {
            $datas = Income::where('income_for', $request->income_for)->get();
            return view('Admin.Income.income_date_wise_print', compact('fromdate', 'company', 'todate',  'income_for', 'income_type', 'datas'));
        }

        if ($request->income_type && $request->income_for) {
            $datas = Income::where('income_type', $request->income_type)->where('income_for', $request->income_for)->get();;
            return view('Admin.Income.income_date_wise_print', compact('fromdate', 'company', 'todate',  'income_for', 'income_type', 'datas'));
        }

        if ($request->income_type && $request->income_for && $fromdate && $todate) {
            $datas = Income::where('income_type', $request->expense_type)->where('income_for', $request->expense_for)->whereBetween('date', [$fromdate, $todate])->get();

            return view('Admin.Income.income_date_wise_print', compact('fromdate', 'company', 'todate',  'income_for', 'income_type', 'datas'));
        }

        return view('Admin.Income.income_date_wise_print', compact('company', 'merchant', 'income_type', 'income_for', 'fromdate', 'todate'));
    }

    public function view(Request $request){
        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }
        $income = Income::whereBetween('date', [$fromdate, $todate])->get();
        $expense = Expense::whereBetween('date', [$fromdate, $todate])->get();
        
       
        return view('Admin.Income.income_and_expense_date_wise_report',compact('fromdate','todate','income','expense'));
    }
}
