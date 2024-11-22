<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Admin\Company;
use App\Admin\Complain;
use App\Admin\Problem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "bcnvbjdfgn";

        // return   $data = Problem::orderBy('id', 'DESC')->where('status', 1)->get();
        // return response()->json($data);


        $data = Problem::orderBy('id', 'DESC')->get();
        return view('Admin.Problem.problem', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function complain()
    {
        $data = Complain::orderBy('id', 'DESC')->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complainCreate(Request $request)
    {
        $date = date('Y-m-d');
        $time = date('G:i');
        $user = User::orderBy('id', 'DESC')->where('role', '!=', '1')->get();
        $problem = Problem::orderBy('id', 'DESC')->get();

        return response()->json(array(
            'date' => $date,
            'time' => $time,
            'user' => $user,
            'problem' => $problem
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $data = array(
            'name'          => $request->name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'role'          => $request->role,
            'date'          => $request->date,
            'time'          => $request->time,
            'call_duration' => $request->call_duration,
            'status'        => 'Submited',
            'priority'       => $request->priority,
            'comment'       => $request->comment,

        );
        $data['problem'] = $request->problem;
        // return($request->problem);
        // foreach ($data2 as $values) {
        //     // return($values);
        //     $data['problem'] = implode(" , ", $values);
        // }
        $insert = DB::table('complains')->insert([$data]);

        $message = "Complain Submitted Successfully";
        return response()->json(
            $message
        );
    }


    public function merchant_complain_create($id)
    {
        $date = date('Y-m-d');
        $time = date('G:i');

        $user = User::where('id', $id)->first();
        $problem = Problem::orderBy('id', 'DESC')->get();
        return response()->json(array(
            'date' => $date,
            'time' => $time,
            'user' => $user,
            'problem' => $problem
        ));
    }
/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function problems()
    {
        $data = Problem::orderBy('id', 'DESC')->get();
        return response()->json(array(
            'data' => $data,
            'message' => 'Problems List',
            'status' => true
        ));
    }

    public function merchant_complains()
    {

        $data = Complain::orderBy('id', 'DESC')
            ->orWhere('email', Auth::user()->email)
            ->orWhere('mobile', Auth::user()->mobile)
            ->get();
        return response()->json(array(
            'data' => $data,
            'message' => 'Complains List',
            'status' => true
        ));
    }

    public function merchant_complain_store(Request $request)
    {

        $data = [];
        $data = array(
            'name'          => $request->name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'role'          => 'activeMerchant',
            'date'          => date('y-m-d'),
            'time'          => date('Y-m-d H:i:s'),
            'call_duration' => 0,
            'status'        => 'Submited',
            'priority'      => $request->priority,
            'comment'       => $request->comment,
            'problem'       => $request->problem,
            
        );
    



        $insert = DB::table('complains')->insert([$data]);
        $message = "Complain Submitted Successfully";

        
        return response()->json(array(
            'message' => $message,
            'status' => true
        ));
    }
}
