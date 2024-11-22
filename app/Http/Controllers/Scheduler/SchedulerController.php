<?php

namespace App\Http\Controllers\Scheduler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin\Scheduler;
use Session;



class SchedulerController extends Controller
{
    
    public function index()
    {
        $data = Scheduler::orderBy('id', 'DESC')->get();
        return view('Scheduler.index', compact('data'));
    }

    public function store(Request $request)
    {


        $data = new Scheduler();
        $data->s_time = $request->s_time;
        $data->e_time = $request->e_time;
        $data->f_date = $request->f_date;
        $data->t_date = $request->t_date; 
        $data->status = 1;
        $data->save();

           

        return redirect()->back()->with('message','Schedule Added Successfully');
    }

    public function edit(Request $request)
    {
        $data = Scheduler::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    { 

        Scheduler::where('id',$request->id)->update([ 
            
            's_time' => $request->s_time,
            'e_time' => $request->e_time,
            'f_date' => $request->f_date,
            't_date' => $request->t_date,
    
    
    
    
    ]);


    Session::put('message', 'Schedule Updated Successfully');

         }

    public function status(Request $request)
    {
        $data = Scheduler::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';    
        }
        else{   
            $data->status = '1';    
        }
        $data->save();
        return redirect()->back()->with('success','Schedule Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = Scheduler::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger','Schedule Deleted Successfully');
    }

}
