<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $data = Payment::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = new Payment();
        $data->date = $request->date;
        $data->supplier = $request->supplier;
        $data->due = $request->due;
        $data->amount = $request->amount;
        $data->details = $request->details;
        $data->shop = $request->shop;
        $data->user = $request->user;
        $data->save();
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = Payment::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Payment::where('id',$request->id)
            ->update([
                    'date'          => $request->date,
                    'supplier'      => $request->supplier,
                    'due'           => $request->due,
                    'amount'        => $request->amount,
                    'details'       => $request->details,
                ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }

}
