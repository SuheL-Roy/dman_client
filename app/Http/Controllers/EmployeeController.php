<?php

namespace App\Http\Controllers;

use App\Admin\Employee;
use App\Admin\Shop;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    public function index()
    {
     
        $shop = Shop::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->get();
         $employee = Employee::orderBy('employees.id', 'DESC')
            ->join('users', 'employees.user_id', 'users.id')
            ->join('shops', 'employees.shop_id', 'shops.id')
            ->select(
                'users.*',
                'employees.id as emp',
                'employees.shop_id',
                'employees.status',
                'shops.shop_name',
                DB::raw("DATE_FORMAT(employees.created_at, '%y') as od")
            )
            ->where('employees.merchant_id', Auth::user()->id)
            ->where('users.role', 14)
            ->get();
        return view('Admin.Employee.employee', compact('employee', 'shop'));
    }

    public function store(Request $request)
    {
        // return $request;

        $request->validate([
            'email'     => 'required|email|string|max:255|unique:users',
            'password'  => 'required|string|confirmed|min:6',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->role = 14;
        $user->password = Hash::make($request->password);
        $user->save();

        $data = new Employee();
        $data->user_id = $user->id;
        $data->shop_id = $request->shop;
        $data->merchant_id = Auth::user()->id;
        $data->save();
        return redirect()->back()->with('message', 'Employee Registration Successfully Completed');
    }

    public function edit(Request $request)
    {
        $data = User::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'role' => $request->role,
            ]);
        return redirect()->back()->with('message', 'Employee Into Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = Employee::find($request->id);
        if ($data->status == 1) {
            $data->status = 0;
        } else {
            $data->status = 1;
        }
        $data->save();
        return redirect()->back()->with('message', 'Employee Status Changed Successfully');
    }
}
