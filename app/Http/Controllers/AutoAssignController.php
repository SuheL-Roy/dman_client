<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin\AutoAssign;
use App\Admin\Merchant;
use Session;


class AutoAssignController extends Controller
{
    public function index()
    {
        $merchantdata = Merchant::join('users', 'merchants.user_id', 'users.id')
       ->select('users.name','merchants.id','merchants.business_name as business_name')      
        ->get();

         $data = AutoAssign::join('merchants', 'auto_assigns.merchant_id', 'merchants.id')
        ->join('riders', 'auto_assigns.rider_id','riders.id')   
        ->select('riders.user_id as riderid','merchants.user_id as merchantid','merchants.business_name as business_name','merchants.area as hub','auto_assigns.id as id')
     ->orderBy('auto_assigns.id', 'DESC')
     ->get();


        return view('Auto_assign.index', compact('data','merchantdata'));
    }

    public function store(Request $request)
    {

        $data = new AutoAssign();
        $data->merchant_id = $request->merchant_id;
        $data->rider_id = $request->rider_id;
        $data->save();

           

        return redirect()->back()->with('message','Auto Assign Added Successfully');
    }

    public function edit(Request $request)
    {
        $data = AutoAssign::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    { 

        AutoAssign::where('id',$request->id)->update([ 
            
            'merchant_id' => $request->e_merchant,
            'rider_id' => $request->e_rider              
    
    
    
    ]);

    


    Session::put('message', 'AutoAssign Updated Successfully');

         }

  

    public function destroy(Request $request)
    {
        $data = AutoAssign::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger','AutoAssign Deleted Successfully');
    }

}
