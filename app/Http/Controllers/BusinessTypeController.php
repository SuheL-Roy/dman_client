<?php

namespace App\Http\Controllers;

use App\Admin\BusinessType;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    public function index()
    {
        $data = BusinessType::orderBy('id', 'DESC')->get();
        return view('Admin.BusinessType.businessType', compact('data'));
    }

    public function store(Request $request)
    {
        $data = new BusinessType();
        $data->b_type = $request->b_type;
        $data->save();
        return redirect()->back()->with('message','Business Type Added Successfully');
    }

    public function edit(Request $request)
    {
        $data = BusinessType::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        BusinessType::where('id',$request->id)->update([ 'b_type' => $request->b_type ]);
        return redirect()->back()->with('message','Business Type Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = BusinessType::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';    
        }
        else{   
            $data->status = '1';    
        }
        $data->save();
        return redirect()->back()->with('status','Business Type Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = BusinessType::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger','Business Type Deleted Successfully');
    }
}
