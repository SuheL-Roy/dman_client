<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Helpers\Helpers;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{


    public function login()
    {

        //    $allSessions = Session::all();
        //  dd($allSessions);

        return view('otp.login');
    }

    public function otp_verification()
    {


        return view('otp.verification');
    }


    public function send(Request $request)
    {
        $validated = $request->validate([
            'mobile_no' => 'required',
        ]);


        $otpnumber = $request->mobile_no;

        $password = rand(1000, 9999);

        $message = "Your otp code is " . $password;


        $user = User::where('mobile', $request->mobile_no)->first();


        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
            // return redirect()->route('otp.send');
            $status = Helpers::sms_send($request->mobile_no, $message);
        } else {
            $user = new User();
            $user->mobile = $request->mobile_no;
            $user->role = 13;
            $user->password = Hash::make($password);
            $user->save();
            $status = Helpers::sms_send($request->mobile_no, $message);
        }

        if ($status) {
            return view('frontend_new.otp_code', compact('otpnumber'));
        } else {
            return response()->json(['status' => 'fail'], 422);
            return back();
        }
    }


    public function otp_submit(Request $request)
    {

        return view('frontend_new.otp_code');
    }


    public function otp_confirm1(Request $request)
    {
        // return $request;

        if (Auth::check(['mobile' => $request->mobile, 'otp_code' => $request->otp_code])) {

            $user = Auth::user();

            if (Auth::user()) {

                return "login";
            } else {

                return "not login";
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
    }






    public function otp_confirm(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required',
        ]);
        // return $request;

        // $userdata = User::where('mobile', $request->mobile)
        //     ->first();


        // Auth::attempt(
        //     [
        //         'mobile' => $request->mobile,
        //         'otp_code' => $request->otp_code
        //     ]
        // );



        if (Auth::attempt(
            [
                'mobile' => $request->mobile,
                'password' => $request->password
            ]
        )) {

            return redirect()->route('home');
        } else {
            // return redirect()->route('otp.confirm');
        }


        // $userdata = User::where('mobile', $request->mobile)->first();

        // if ($userdata->name == null) {

        //     return view('otp.user_info');
        // } else {

        //     if (Auth::attempt(['mobile' => $request->mobile, 'otp_code' => $request->otp_code])) {

        //         return redirect()->route('home');
        //     }
        // }










        // return $request->all();

        // return $userdata = User::where('mobile', $request->mobile)
        //     ->first();





        // if (Hash::check($request->otp_code, $userdata->otp_code)) {
        //     $oldDate = Carbon::parse($userdata->updated_at);
        //     $currentDate = Carbon::now();
        //     return "login";
        // } else {

        //     return "xvjndfjkbdfjkgn";

        //     return redirect()->route('otp.verification')->with('message', 'Wrong OTP code!');
        // }
    }



    public function user_info(Request $request)
    {

        $userdata = User::where('mobile', $request->mobile)->first();

        if ($userdata->name == null) {

            return view('otp.user_info');
        } else {

            if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])) {

                return redirect()->route('home');
            }
        }
    }





    public function login_phone(Request $request)
    {
        // return $request->mobile_no;
        $this->validate($request, [
            // 'name' => 'required|max:120',
            // 'email' => 'required|email|unique:users',
            //'phone' => 'required|numeric|size:11'
            // 'phone' => 'required|regex:/(01)[0-9]{9}/'
            'mobile_no' => 'required|size:11|regex:/(01)[0-9]{9}/'
        ]);


        $abcd = rand(1000, 9999);
        $params = [
            "api_token" => 'svlh35i7-krsvgcep-0mlubtyg-vzudoac7-ja2f8ydb',
            "sid" => 'SHEIKHSOHELRANA',
            "msisdn" => $request->mobile_no,
            "sms" => "Your Amvines Logistic One-Time PIN is $abcd. It will expire in 3 minutes.",
            "csms_id" => "2934fe343"
        ];
        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, 'https://smsplus.sslwireless.com/api/v3/send-sms');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);

        curl_close($ch);




        $user_ql = User::where('mobile', $request->mobile_no)->first();

        if ($user_ql) {
            // exists
            //  return $user;
            User::where('id', $user_ql->id)->update([
                'password' => bcrypt($abcd)
            ]);
            // User::where('id',$otpid)->update(['otp'=>1111]);
        } else {
            // return "not Exists";
            //     User::updateOrCreate([
            //     'mobile' => $request->mobile_no,
            //     'password' => bcrypt($abcd)

            // ]);

            // return $request;
            $user = new User();
            $user->mobile = $request->mobile_no;
            $user->role = 12;
            $user->is_verified = 0;
            $user->otp_created_time =  Carbon::now();
            $user->password = bcrypt($abcd);
            $user->save();


            $merchant = new Merchant();
            $merchant->user_id = $user->id;
            $merchant->save();

            $profile = new Profile();
            $profile->user_id      = $user->id;
            $profile->save();
            // return view('otp.verification');
            // return "hdfjkghdfbd";
        }

        Session::put('mobile_no', $request->mobile_no);

        Session::put('otp_code', $abcd);


        return view('otp.verification');
    }


    public function otp_verification_confirm(Request $request)
    {
        $userdata = User::where('mobile', $request->mobile)
            ->first();

        if (Hash::check($request->password, $userdata->password)) {

            $oldDate = Carbon::parse($userdata->updated_at);
            $currentDate = Carbon::now();
            $diff = $oldDate->diff($currentDate);

            if ($diff->i < 3) {


                if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])) {

                    return redirect()->route('home');
                }
            } else {

                return redirect()->route('otp.verification')->with('message', 'OTP code invalid!');
            }
        } else {


            return redirect()->route('otp.verification')->with('message', 'Wrong OTP code!');
        }
    }
}
