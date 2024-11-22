<?php

namespace App\Http\Controllers\Expense;

use App\Admin\Company;
use App\Expense;
use App\ExpenseType;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
       
        $expense_type = ExpenseType::get();
        return view('Admin.Expense.Expense', compact('expense_type'));
    }
    public function ExpenseType(Request $request)
    {

        $data = new ExpenseType();
        $data->name = $request->name;
        $data->user = Auth::user()->id;
        $data->save();
        return redirect()->back()->with('success', 'ExpenseType  Created Successfully');
    }

    public function list(Request $request)
    {
        if ($last = Expense::all()->last()) {
            $sl = $last->id;
        } else {
            $sl = 0;
        }


        $expense_type = ExpenseType::get();
        $agent = User::orderBy('users.id', 'DESC')
            ->where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select(
                'agents.*',
                'users.name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(agents.created_at, '%y') as od")
            )
            ->get();

        $list = Expense::get();

        //  return $list;
        return view('Admin.Expense.ExpenseList', compact('list', 'sl', 'agent', 'expense_type'));
    }

    public function Expense_List(Request $request)
    {
        $data = new Expense();
        $data->voucher_no = $request->voucher_no;
        $data->date = $request->date;
        $data->expense_type     = $request->Expense_type;
        $data->expense_for = $request->expense_for;
        $data->amount = $request->amount;
        $data->details = $request->details;
        $data->user = Auth::user()->id;
        $data->save();

        return redirect()->back()->with('success', 'Expense  Created Successfully');
    }

    public function edit(Request $request)
    {

        $data = ExpenseType::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = ExpenseType::find($request->id);
        $data->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'ExpenseType updated successfully');
    }

    public function expense_list_edit(Request $request)
    {
        $data = Expense::where('id', $request->id)->get();
        return response()->json($data);
    }


    public function destroy(Request $request)
    {
        $data = ExpenseType::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger', 'ExpenseType Deleted successfully');
    }


    public function expense_list_update(Request $request)
    {
        $data = Expense::find($request->id);
        $data->update([
            'date' => $request->date,
            'expense_type' => $request->Expense_type,
            'expense_for' => $request->expense_for,
            'amount' => $request->amount,
            'details' => $request->details,
        ]);

        return redirect()->back()->with('success', 'Expense Updated successfully');
    }

    public function expense_destroy(Request $request)
    {
        $data = Expense::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger', 'Expense deleted successfully');
    }

    public function report(Request $request)
    {
        // dd($request->all());


        $expense_type = ExpenseType::get();
        $agent = User::orderBy('users.id', 'DESC')
            ->where('role', 8)
            ->orwhere('role', 9)
            ->join('agents', 'users.id', 'agents.user_id')
            ->select(
                'agents.*',
                'users.name',
                'users.email',
                'users.mobile',
                'users.role',
                'users.id as ID',
                DB::raw("DATE_FORMAT(agents.created_at, '%y') as od")
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

        $expense_typed = $request->expense_type ?? '';
        $expense_fors = $request->expense_for ?? '';


        if ($fromdate && $todate) {
            $datas = Expense::whereBetween('date', [$fromdate, $todate])->get();
            return view('Admin.Expense.date_wise_report', compact('fromdate', 'todate', 'expense_typed', 'expense_fors', 'expense_type', 'agent', 'datas'));
        }

        if ($request->expense_type) {
            $datas = Expense::where('expense_type', $request->expense_type)->get();
            return view('Admin.Expense.date_wise_report', compact('fromdate', 'todate', 'expense_typed', 'expense_fors', 'expense_type', 'agent', 'datas'));
        }

        if ($request->expense_for) {
            $datas = Expense::where('expense_for', $request->expense_for)->get();
            return view('Admin.Expense.date_wise_report', compact('fromdate', 'todate', 'expense_typed', 'expense_fors', 'expense_type', 'agent', 'datas'));
        }

        if ($request->expense_type && $request->expense_for) {
            $datas = Expense::where('expense_type', $request->expense_type)->where('expense_for', $request->expense_for)->get();;
            return view('Admin.Expense.date_wise_report', compact('fromdate', 'todate', 'expense_typed', 'expense_fors', 'expense_type', 'agent', 'datas'));
        }

        if ($request->expense_type && $request->expense_for && $fromdate && $todate) {
            $datas = Expense::where('expense_type', $request->expense_type)->where('expense_for', $request->expense_for)->whereBetween('date', [$fromdate, $todate])->get();

            return view('Admin.Expense.date_wise_report', compact('fromdate', 'expense_type', 'expense_typed', 'expense_fors', 'agent', 'todate', 'datas'));
        }

        return view('Admin.Expense.date_wise_report', compact('fromdate', 'expense_type', 'expense_typed', 'expense_fors', 'agent', 'todate'));
    }

    public function Report_Print(Request $request){
       // dd($request->all());
        $company = Company::orderBy('id', 'DESC')->get();

        
        $d = new DateTime("now");
        $today = $d->format('Y-m-d');

        $fromdate = $request->fromdate;
        if ($request->todate) {
            $todate = $request->todate;
        } else {
            $todate = $today;
        }

        $expense_typed = $request->expense_type ?? '';
        $expense_fors = $request->expense_for ?? '';


        if ($fromdate && $todate) {
            $datas = Expense::whereBetween('date', [$fromdate, $todate])->get();
            return view('Admin.Expense.date_wise_print', compact('fromdate', 'company','todate', 'datas'));
        }

        if ($request->expense_type) {
            $datas = Expense::where('expense_type', $request->expense_type)->get();
            return view('Admin.Expense.date_wise_print', compact('fromdate','company', 'todate',  'datas'));
        }

        if ($request->expense_for) {
            $datas = Expense::where('expense_for', $request->expense_for)->get();
            return view('Admin.Expense.date_wise_print', compact('fromdate','company', 'todate',  'datas'));
        }

        if ($request->expense_type && $request->expense_for) {
            $datas = Expense::where('expense_type', $request->expense_type)->where('expense_for', $request->expense_for)->get();;
            return view('Admin.Expense.date_wise_print', compact('fromdate','company', 'todate',  'datas'));
        }

        if ($request->expense_type && $request->expense_for && $fromdate && $todate) {
            $datas = Expense::where('expense_type', $request->expense_type)->where('expense_for', $request->expense_for)->whereBetween('date', [$fromdate, $todate])->get();

            return view('Admin.Expense.date_wise_print', compact('fromdate','company', 'todate', 'datas'));
        }

        return view('Admin.Expense.date_wise_print',compact('company'));
    }
}
