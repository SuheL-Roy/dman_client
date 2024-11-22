<?php

namespace App\Http\Controllers;

use App\Admin\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public function index()
    {
        $data = Problem::orderBy('id', 'DESC')->get();
        return view('Admin.Problem.problem', compact('data'));
    }

    public function store(Request $request)
    {
        $data           = new Problem();
        $data->category = $request->category;
        $data->title    = $request->title;
        $data->save();
        return redirect()->back()->with('message','Problem Added Successfully');
    }

    public function edit(Request $request)
    {
        $data = Problem::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Problem::where('id',$request->id)
                    ->update([ 
                        'category'  => $request->category, 
                        'title'     => $request->title 
                        ]);
        return redirect()->back()->with('message','Problem Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = Problem::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';    
        }
        else{   
            $data->status = '1';    
        }
        $data->save();
        return redirect()->back()->with('status','Problem Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = Problem::where('id', $request->id);
        $data->delete();
        return redirect()->back()->with('danger','Problem Deleted Successfully');
    }
}
