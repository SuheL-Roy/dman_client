<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Customer;
use App\Admin\Order;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::all();
        return response()->json($data);
    }
    
    public function customertrack(Request $request)
        {
           if ($data = $request->get('data')) {
            $search = Order::where('status', 'like', "%{$data}%")
                ->orWhere('tracking_id', 'like', "%{$data}%")
                ->get();
                return response()->json([
                  'data' => $search,
                ],200);

                }
                 else {
                  return response()->json([
                    "message" => "Tracking Not Found"
                  ], 404);
                }
        }

    public function store(Request $request)
    {
        $data = new Customer();
        $data->name = $request->name;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->balance = $request->balance;
        $data->status = '1';
        $data->shop = $request->shop;
        $data->save();
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = Customer::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Customer::where('id',$request->id)
            ->update([
                    'name'    => $request->name,
                    'mobile'  => $request->mobile,
                    'address' => $request->address,
                    'balance' => $request->balance,
                ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }

    public function status(Request $request)
    {
        $data = Customer::find($request->id);
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

    public function delete(Request $request)
    {
        $data = Customer::find($request->id);
        $data->delete();
        $msg = 'Delete Successfully';
        return response()->json($msg);
    }
}
