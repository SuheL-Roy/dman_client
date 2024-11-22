<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Product;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        return response()->json($data);
    }
    
    public function store(Request $request)
    {
        $data           = new Product();
        $data->name     = $request->name;
        $data->code     = $request->code;
        $data->category = $request->category;
        $data->unit     = $request->unit;
        $data->stock    = $request->stock;
        $data->price    = $request->price;
        $data->status   = '1';
        $data->shop     = $request->shop;
        $data->save();
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = Product::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Product::where('id',$request->id)
            ->update([
                    'name'      => $request->name,
                    'code'      => $request->name,
                    'category'  => $request->category,
                    'unit'      => $request->unit,
                    'price'     => $request->price,
                    'stock'     => $request->stock,
                ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }

    public function status(Request $request)
    {
        $data = Product::find($request->id);
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
        $data = Product::find($request->id);
        $data->delete();
        $msg = 'Delete Successfully';
        return response()->json($msg);
    }
    
}
