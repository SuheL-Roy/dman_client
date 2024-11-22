<?php

namespace App\Http\Controllers;

use App\Admin\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $data = Notice::orderBy('id', 'DESC')->get();
        return view('Admin.Home.notice', compact('data'));
    }

    public function edit(Request $request)
    {
        $data = Notice::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Notice::where('id',$request->id)->update([ 'message' => $request->message ]);
        return redirect()->back()->with('message','Notice Updated Successfully');
    }
}
