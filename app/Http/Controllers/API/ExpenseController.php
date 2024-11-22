<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Expense;
use App\Admin\ExpenseType;

class ExpenseController extends Controller
{
    public function type()
    {
        $data = ExpenseType::all();
        return response()->json($data);
    }
    public function index()
    {
        $data = Expense::all();
        return response()->json($data);
    }

    public function type_store(Request $request)
    {
        $data = new ExpenseType();
        $data->name = $request->name;
        $data->status = '1';
        $data->shop = $request->shop;
        $data->user = $request->user;
        $data->save();
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $data = new Expense();
        $data->date = $request->date;
        $data->expense_type = $request->expense_type;
        $data->amount = $request->amount;
        $data->details = $request->details;
        $data->shop = $request->shop;
        $data->user = $request->user;
        $data->save();
        return response()->json($data);
    }

    public function type_edit(Request $request)
    {
        $data = ExpenseType::find($request->id);
        return response()->json($data);
    }
    public function edit(Request $request)
    {
        $data = Expense::find($request->id);
        return response()->json($data);
    }

    public function type_update(Request $request)
    {
        ExpenseType::where('id',$request->id)->update([ 'name' => $request->name ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }
    public function update(Request $request)
    {
        Expense::where('id',$request->id)
            ->update([
                    'date'          => $request->date,
                    'expense_type'  => $request->expense_type,
                    'amount'        => $request->amount,
                    'details'       => $request->details,
                ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }

    public function status(Request $request)
    {
        $data = ExpenseType::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';    
        }
        else{   
            $data->status = '1';    
        }
        $data->save();
        $msg = 'Status Changed Successfully';
        return response()->json($msg);
    }
}