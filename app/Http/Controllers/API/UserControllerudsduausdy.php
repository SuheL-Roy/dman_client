<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{   
    public function employee_index(Request $request)
    {
        $user = User::where('shop', $request->shop)
                    ->where('role', '!=', 'Admin')
                    ->get();
        $data = [];
        foreach ($user as $user)
        {
            $id = $user->id;
            $name = $user->name;
            $mobile = $user->mobile;
            $role = $user->role;
            $status = $user->status;
            $data[] = [   
                        'id' => $id,
                        'name' => $name,
                        'mobile' => $mobile,
                        'role' => $role,
                        'status' => $status,
                    ];
        }
        return response()->json($data);
    }

    public function employee_register(Request $request)
    {
        $data = new User();
        $data->name = $request->name;
        $data->mobile = $request->mobile;
        $data->role = $request->role;
        $data->status = 'Active';
        $data->password = Hash::make($request->password);
        $data->shop = $request->shop;
        $data->save();
        return response()->json($data);
    }

    public function employee_status(Request $request)
    {
        $data = User::find($request->id);
        if ($data->status == 'Active') {
            $data->status = 'Inactive';    
        }
        else{   
            $data->status = 'Active';    
        }
        $data->save();
        $msg = 'Status Changed Successfully';
        return response()->json($msg);
    }

    public function shop_register(Request $request)
    {
        // $request->validate([
        //     'name'      => 'required|string|max:255',
        //     'mobile'    => 'required|string|unique:users',
        //     'email'     => 'required|string|unique:users',
        //     'password'  => 'required|string|min:8',
        // ]);
        $user = new User;
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->business_name = $request->business_name;
        $user->area = $request->area;
        $user->b_type = $request->b_type;
        $user->save();
        $data = User::find($user->id);
        $data->shop = $user->id;
        $data->save();
        return response()->json($data);
    }

    public function admin_login(Request $request)
    {
        $request->validate([
                        'mobile' => 'required|string',
                        'password' => 'required|string',
                    ]);
        $mobile = $request->mobile;
        $password = $request->password;
        $user = User::where('mobile', $mobile)
                    ->where('role', 'Admin')
                    // ->where('password', $password)
                    ->get();
        $data = [];
        foreach ($user as $user)
        {
            $id             = $user->id;
            $name           = $user->name;
            $email          = $user->email;
            $mobile         = $user->mobile;
            $shop           = $user->shop;
            $business_name  = $user->business_name;
            $b_type         = $user->b_type;
            $status         = $user->status;
            $area           = $user->area;
            $data[] = [ 'id'            => $id,
                        'name'          => $name,
                        'email'         => $email,
                        'mobile'        => $mobile,
                        'status'        => $status,
                        'shop'          => $shop,
                        'business_name' => $business_name,
                        'b_type'        => $b_type,
                        'area'          => $area,
                    ];
        }
        return response()->json($data);
    }

    public function employee_login(Request $request)
    {
        $request->validate([
                        'mobile' => 'required|string',
                        'password' => 'required|string',
                    ]);
        $mobile = $request->mobile;
        $password = $request->password;
        $user = User::where('mobile', $mobile)->get();
        // $user = User::where('mobile', $mobile)
        //             ->where('password', $password)
        //             ->get();
        $data = [];
        foreach ($user as $user)
        {
            $id             = $user->id;
            $name           = $user->name;
            $email          = $user->email;
            $mobile         = $user->mobile;
            $role           = $user->role;
            $shop           = $user->shop;
            $status         = $user->status;
            $data[] = [ 'id'            => $id,
                        'name'          => $name,
                        'email'         => $email,
                        'mobile'        => $mobile,
                        'role'          => $role,
                        'status'        => $status,
                        'shop'          => $shop,
                    ];
        }
        return response()->json($data);
    }


}
