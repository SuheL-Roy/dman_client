<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        $data = Collection::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = new Collection();
        $data->date = $request->date;
        $data->customer = $request->customer;
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
        $data = Collection::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Collection::where('id',$request->id)
            ->update([
                    'date'          => $request->date,
                    'customer'      => $request->customer,
                    'due'           => $request->due,
                    'amount'        => $request->amount,
                    'details'       => $request->details,
                ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }
}
