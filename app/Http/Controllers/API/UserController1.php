<?php

namespace App\Http\Controllers\Api;

use App\Admin\CoverageArea;
use App\Admin\District;
use App\Admin\Employee;
use App\Admin\Merchant;
use App\Admin\PaymentInfo;
use App\Admin\Profile;
use App\Admin\Rider;
use App\Admin\Shop;
use App\Helper\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request)
    {
        // return $request;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();


            $success['token'] =  $token = auth()->user()->createToken('adminToken')->accessToken;

            if (Auth::user()->role == 12 || Auth::user()->role == 10 || Auth::user()->role == 14) {

                return response()->json([

                    'token' => $success,
                    'user' => $user,
                    'success' => true
                ]);
            } else {

                return response()->json([

                    'token' => $success,
                    'user' => $user,
                    'message' => 'inactive account'
                ]);
            }
        } else {



            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
    }

    public function register_merchant(Request $request)
    {

        $email = User::where('email', $request->email)->first();
        if ($email) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists.',
            ], 401);
        }
        $mobile = User::where('mobile', $request->mobile)->first();
        if ($mobile) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile already exists.',
            ], 401);
        }
        DB::beginTransaction();

        try {
            $data = new User();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->mobile = $request->mobile;
            $data->address = $request->address;
            $data->role = 13;
            $data->password = Hash::make($request->password);
            $data->save();

            $areas = CoverageArea::where('id', $request->area)->first();
            $districtdata =  District::where('id', $request->district)->first();

            $merchant = new Merchant();
            $merchant->user_id = $data->id;
            $merchant->district = $districtdata->name;
            $merchant->area = $areas->zone_name;
            $merchant->zone_id = $areas->zone_id;
            $merchant->district_id = $request->district;
            $merchant->business_name = $request->business_name;
            $merchant->m_cod            = 0;
            $merchant->m_discount       = 0;
            $merchant->m_insurance      = 0;
            $merchant->save();


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e,
            ], 401);
        }

        //Login Attempt
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = User::join('merchants', 'users.id', 'merchants.user_id')->where('users.id', Auth::user()->id)->first();
            $success['token'] =  $token = auth()->user()->createToken('adminToken')->accessToken;



            if (Auth::user()->role == 12) {

                return response()->json([
                    'success' => true,
                    'token' => $success,
                    'user' => $user,
                    'message' => 'Active account'
                ], 200);
            } else {


                return response()->json([
                    'success' => true,
                    'token' => $success,
                    'user' => $user,
                    'message' => 'inactive account'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email or password invalid',
            ], 401);
        }
    }

    public function admin(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['status' => 'true', 'message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }


    public function merchant_info(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user) {
            $user = User::join('merchants', 'users.id', 'merchants.user_id')->where('users.id', Auth::user()->id)->first();
            $payment = PaymentInfo::where('user_id', Auth::user()->id)->first();
            return response()->json([
                'user' => $user,
                'payment' => $payment,
                'valid' => 'valid User ',
                'status' => true,
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid User ',
                'status' => false,
            ]);
        }
    }

    public function employee_index(Request $request)
    {
        $user = User::where('shop', $request->shop)
            ->where('role', '!=', 'Admin')
            ->get();
        $data = [];
        foreach ($user as $user) {
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


    public function employees()
    {

        $data =  Employee::join('users', 'users.id', 'employees.user_id')
            ->where('employees.merchant_id', Auth::user()->id)
            ->get();

        return response()->json([
            'employees' => $data,
            'message' => 'Employees List',
            'status' => true,
        ]);
    }
    public function employee_register(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->role = 14;
        $user->password = Hash::make($request->password);
        $user->save();

        $data = new Employee();
        $data->user_id = $user->id;
        $data->shop_id = $request->shop_id;
        $data->merchant_id = Auth::user()->id;
        $data->save();
        return response()->json([
            'message' => 'Successfully Created A Employee',
            'status' => true,
        ]);
    }
    public function employee_status(Request $request)
    {
        $data = User::find($request->id);

        if ($data->role == 14) {
            $data->role = 15;
            $msg = 'Successfully Deactivate Employee';
        } else {
            $data->role = 14;
            $msg = 'Successfully Activate Employee';
        }
        $data->save();
        return response()->json([
            'message' => $msg,
            'status' => true,
        ]);
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
        foreach ($user as $user) {
            $id             = $user->id;
            $name           = $user->name;
            $email          = $user->email;
            $mobile         = $user->mobile;
            $shop           = $user->shop;
            $business_name  = $user->business_name;
            $b_type         = $user->b_type;
            $status         = $user->status;
            $area           = $user->area;
            $data[] = [
                'id'            => $id,
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
        foreach ($user as $user) {
            $id             = $user->id;
            $name           = $user->name;
            $email          = $user->email;
            $mobile         = $user->mobile;
            $role           = $user->role;
            $shop           = $user->shop;
            $status         = $user->status;
            $data[] = [
                'id'            => $id,
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
    public function showuser()
    {
        $data =  User::all();
        return response()->json($data);
    }

    public function info_update(Request $request)
    {

        User::where('id', Auth::user()->id)
            ->update([

                'name'    => $request->name,
                'address'  => $request->address

            ]);


        Merchant::where('user_id', Auth::user()->id)
            ->update([

                'business_name'    => $request->business_name,
                'area'    => $request->area,
                'zone_id'    => $request->zone_id,

            ]);


        return Response::json([

            'status' => true,
            'message' => 'Profile Successfully Updated',

        ], 200);
    }
    public function merchant_update(Request $request)
    {

        User::where('id', Auth::user()->id)
            ->update([

                'name'    => $request->name,
                'address'  => $request->address,
                'mobile'  => $request->mobile,
                'email'  => $request->email,

            ]);


        Merchant::where('user_id', Auth::user()->id)
            ->update([

                'business_name'    => $request->business_name,
                'area'    => $request->area,
                'zone_id'    => $request->zone_id,
                'b_type'    => $request->b_type,

            ]);


        return Response::json([

            'status' => true,
            'message' => 'Profile Successfully Updated',

        ], 200);
    }

    /**
     *
     * @param  PaymentInfo
     * @return \Illuminate\Http\Response
     * @author Risad Hossain
     * @return void
     */

    public function user_bank_update(Request $request)
    {

        $isExists =  PaymentInfo::where('user_id', Auth::user()->id)->first();
        if ($isExists) {

            if ($request->acType == 'bank') {
                PaymentInfo::where('user_id', Auth::user()->id)
                    ->delete();

                $paymentInfo = new PaymentInfo();
                $paymentInfo->user_id = $isExists->user_id;
                $paymentInfo->p_type = $request->acType;
                $paymentInfo->bank_name    = $request->bank_name;
                $paymentInfo->branch_name    = $request->branch_name;
                $paymentInfo->account_holder_name    = $request->account_holder_name;
                $paymentInfo->account_type    = $request->account_type;
                $paymentInfo->account_number    = $request->account_number;
                $paymentInfo->routing_number    = $request->routing_number;
                $paymentInfo->save();
            } else {
                PaymentInfo::where('user_id', Auth::user()->id)
                    ->delete();
                $paymentInfo = new PaymentInfo();
                $paymentInfo->user_id = $isExists->user_id;
                $paymentInfo->p_type = $request->acType;
                $paymentInfo->mb_name    = $request->mb_name;
                $paymentInfo->mb_type   = $request->mb_type;
                $paymentInfo->mb_number    = $request->mb_number;
                $paymentInfo->save();
            }
        } else {


            if ($request->acType == 'bank') {
                $paymentInfo = new PaymentInfo();
                $paymentInfo->user_id = Auth::user()->id;
                $paymentInfo->p_type = $request->acType;
                $paymentInfo->bank_name    = $request->bank_name;
                $paymentInfo->branch_name    = $request->branch_name;
                $paymentInfo->account_holder_name    = $request->account_holder_name;
                $paymentInfo->account_type    = $request->account_type;
                $paymentInfo->account_number    = $request->account_number;
                $paymentInfo->routing_number    = $request->routing_number;
                $paymentInfo->save();
            } else {

                $paymentInfo = new PaymentInfo();
                $paymentInfo->user_id = Auth::user()->id;
                $paymentInfo->p_type = $request->acType;
                $paymentInfo->mb_name    = $request->mb_name;
                $paymentInfo->mb_type   = $request->mb_type;
                $paymentInfo->mb_number    = $request->mb_number;
                $paymentInfo->save();
            }
        }
        return Response::json([

            'status' => 'true',
            'paymentInfo' => $paymentInfo,

        ], 200);
    }

    public function logout(Request $request)
    {


        $token = $request->user()->token();
        $token->revoke();
        $response = ['status' => 'true', 'message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    //Reset Code by Mobile Number
    public function resetOtpCodeSend(Request $request)
    {


        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {


            $otp_code = rand(1000, 9999);



            $text = "Your Logistics One-Time PIN is $otp_code. It will expire in 3 minutes";



            $response =    Helpers::sms_send($request->mobile, $text);


            $result = json_decode($response, true);

            // if($result['status_code']==200){

            return response()->json([
                'status' => true,
                'otp' => $otp_code,
                'user_id' => $user->id,
                'message' => 'Code send successfully'
            ], 200);



            // }else{

            //      return response()->json([
            //            'status' => false,
            //            'message' => 'Code did not send successfully'
            //          ],201);

            // }

        } else {

            return response()->json([
                'status' => false,
                'message' => 'Mobile Number Does not Match'
            ], 201);
        }
    }


    public function otp_login(Request $request)
    {

        $user = User::where('mobile', $request->mobile)->join('merchants', 'users.id', 'merchants.user_id')
            ->first();
        $otp_code = rand(1000, 9999);
        $hashed_code = Hash::make($otp_code);
        $isRegistered = false;

        if ($user) {

            User::where('id', $user->user_id)
                ->update([
                    'otp_code'    => $hashed_code,
                    'password'    => $hashed_code,
                    'otp_created_time' =>  Carbon::now()
                ]);

            if (!$user->name || !$user->address || !$user->business_name || !$user->area || !$user->zone_id) {
                $isRegistered = true;
            }
        } else {

            $user = new User;
            $user->mobile = $request->mobile;
            $user->otp_code = $hashed_code;
            $user->password = $hashed_code;
            $user->otp_created_time =  Carbon::now();
            $user->role = $request->role;
            $user->save();
            $isRegistered = true;

            $merchant = new Merchant();
            $merchant->user_id = $user->id;
            $merchant->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();
        }
        $text = "Your One-Time PIN is $otp_code. It will expire in 3 minutes";
        Helpers::sms_send($request->mobile, $text);




        return Response::json([
            'status' => true,
            'otp_code' => $otp_code,
            'isRegistered' => $isRegistered,

        ], 200);
    }





    public function otp_verification(Request $request)
    {

        //   return $request;
        $user = User::where('mobile', $request->mobile)->first();

        $mobile = $request->mobile;
        $password = $request->otp_code;


        $oldDate = Carbon::parse($user->otp_created_time);

        $currentDate = Carbon::now();

        $diff = $oldDate->diff($currentDate);


        //  if ($diff->i < 3) {
        // try{
        //     Auth::attempt(
        //         [
        //             'mobile' => $request->mobile,
        //             'password' => $request->otp_code
        //         ]
        //         );
        // }catch(Exception $e){
        //     return $e;
        // }


        if (Auth::attempt(['mobile' => $mobile, 'password' => $password])) {

            $user = User::join('merchants', 'users.id', 'merchants.user_id')->where('merchants.user_id', Auth::user()->id)->first();



            $success['token'] =  $token = auth()->user()->createToken('adminToken')->accessToken;



            return response()->json([
                'message' => 'Successfully Login ',

                'token' => $success,
                'user' => $user,
                'status' => true
            ]);
        } else {

            return response()->json([
                'status' => false,
                'message' => 'Invalid login',
            ], 401);
        }
        //  } else {

        //      return Response::json([
        //          'status' => false,
        //          'message' => 'time exceed',
        //      ], 401);
        //  }
    }


    public function changePassword(Request $request)
    {

        if ((Hash::check(request('old_password'), Auth::user()->password)) == true) {

            User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->new_password)]);
            return response()->json([

                'status' => true,
                'message' => 'Password Changed Successfully'
            ], 200);
        } else {
            return response()->json([

                'status' => false,
                'message' => 'old password does not match !'
            ], 401);
        }
    }

    public function userInfo(Request $request)
    {

        // return "sd,jfgh";

        if (Auth::guard('api')->check()) {

            $user_id =  Auth::user()->id;

            $data = User::where('id', $user_id)->first();
            $rider = Rider::where('user_id', $user_id)->first();

            return response()->json([
                'user' => $data,
                'rider' => $rider,
            ]);
        }
    }
    public function resetPass(Request $request)
    {



        $password = User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);

        $msg = 'Password Changed Successfully';

        $data = [

            'status' => true,
            'password' => $request->password,
            'msg' => $msg
        ];
        return response()->json($data);
    }


    public function deleteID()
    {
        if (Auth::user()->role == 12) {
            $userId =  Auth::user()->id;
            $record = User::where('id', $userId);

            if ($record) {
                $record->delete();
                return response()->json(['message' => 'Record deleted successfully.']);
            } else {
                return response()->json(['message' => 'Record not found.']);
            }
        } else {
            return response()->json(['message' => 'Record not found.']);
        }
    }

    public function otp_send(Request $request)
    {


        $mobile_no = User::where('mobile', $request->mobile)->value('mobile');

        if ($mobile_no) {

            $mobile_no = User::where('mobile', $request->mobile)->value('mobile');
            $id = User::where('mobile', $request->mobile)->value('id');

            $abcd = rand(1000, 9999);


            User::where('id', $id)->update([
                'one_time_otp' => $abcd
            ]);

            $smsText = "Your Forget Password  One-Time OTP is " . $abcd;
            Helpers::otp_send($request->mobile, $smsText);

            return response()
                ->json(['status' => 'success', 'message' => 'Otp send Successfully']);
        } else {
            return response()
                ->json(['status' => 'error', 'message' => 'Your Phone Number does not Match']);
        }
    }

    public function forget_password(Request $request)
    {

        $user_id = User::where('one_time_otp', $request->otp_code)->value('id');

        if ($user_id) {

            $user = User::whereId($user_id)->first();

            User::where('id', $user->id)
            ->update(['password' => Hash::make($request->password)]);

            return response()
                ->json(['status' => 'success', 'message' => 'Password Update Successfully']);
        } else {
            return response()
                ->json(['status' => 'error', 'message' => 'Your Otp code is not Correct']);
        }
    }
}
