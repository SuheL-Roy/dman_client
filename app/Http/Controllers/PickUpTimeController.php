<?php

namespace App\Http\Controllers;

use App\Admin\PickUpTime;
use Illuminate\Http\Request;

class PickUpTimeController extends Controller
{
    public function index()
    {
        $data = PickUpTime::orderBy('id', 'DESC')->get();
        return view('Admin.PickUpTime.pickUpTime', compact('data'));
    }

    public function store(Request $request)
    {
        $data           = new PickUpTime();
        $data->pick_up  = $request->pick_up;
        $data->save();
        return redirect()->back()->with('message','PickUp Time Added Successfully');
    }

    public function edit(Request $request)
    {
        $data = PickUpTime::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        PickUpTime::where('id',$request->id)->update([ 'pick_up' => $request->pick_up ]);
        return redirect()->back()->with('message','PickUp Time Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = PickUpTime::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';    
        }
        else{   
            $data->status = '1';    
        }
        $data->save();
        return redirect()->back()->with('status','PickUp Time Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = PickUpTime::where('id', $request->id);
        $data->delete();
        return redirect()->back()->with('danger','PickUp Time Deleted Successfully');
    }
}
