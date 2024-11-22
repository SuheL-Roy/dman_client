<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $data = new Category();
        $data->name = $request->name;
        $data->status = '1';
        $data->shop = $request->shop;
        $data->save();
        return response()->json($data);
    }
    public function edit(Request $request)
    {
        $data = Category::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Category::where('id',$request->id)
            ->update([
                    'name'    => $request->name,
                ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }
    public function status(Request $request)
    {
        $data = Category::find($request->id);
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
        $data = Category::find($request->id);
        $data->delete();
        $msg = 'Delete Successfully';
        return response()->json($msg);
    }
}
