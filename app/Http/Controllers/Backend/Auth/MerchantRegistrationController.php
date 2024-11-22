<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Admin\BusinessType;
use App\Admin\District;
use App\Admin\Merchant;
use App\Admin\Shop;
use App\Admin\Slider;
use App\Admin\Zone;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MerchantRegistrationController extends Controller
{
    public function registration()
    {
        $business = BusinessType::orderBy('id', 'DESC')->where('status', 1)->get();
        $districts = DB::table('districts')->orderBy('name', 'asc')->get();
        $slider = Slider::orderBy('id', 'DESC')->where('status', 1)->get();
        $zones = Zone::orderBy('id', 'DESC')->where('status', 1)->get();

        
        
        return view('auth.register', compact('districts', 'business', 'slider', 'zones'));
    }


    public function mobileOTPcode()
    {

        $business = BusinessType::orderBy('id', 'DESC')->where('status', 1)->get();
        $districts = DB::table('districts')->orderBy('name', 'asc')->get();
        $slider = Slider::orderBy('id', 'DESC')->where('status', 1)->get();
        $zones = Zone::orderBy('id', 'DESC')->where('status', 0)->get();

        return view('auth.mobile_otp', compact('districts', 'business', 'slider', 'zones'));
    }

    public function mobileOTPcodeForget()
    {

        $business = BusinessType::orderBy('id', 'DESC')->where('status', 1)->get();
        $districts = DB::table('districts')->orderBy('name', 'asc')->get();
        $slider = Slider::orderBy('id', 'DESC')->where('status', 1)->get();
        $zones = Zone::orderBy('id', 'DESC')->where('status', 0)->get();

        return view('auth.mobile_otp_forget', compact('districts', 'business', 'slider', 'zones'));
    }




    public function registration_store(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function inactive_user_info(Request $request)
    {

        $userinormation = Auth::user();

        $userId = Auth::user()->id;
        $dist = District::where('id', $request->district)->first();
        Merchant::create([
            'user_id' => $userId,
            'area' => $request->area,
            'business_name' => $request->business_name,
            'district' => $dist->name,
            'district_id' => $dist->id,
            'zone_id' => $dist->zone_id,
            'created_by' => $userId
        ]);


        Shop::create([
            'user_id' => $userId,
            'shop_name' => $request->business_name,
            'shop_area' => $request->area,
            'shop_phone' => $userinormation->mobile,
            'shop_address' => $request->address,
            'pickup_address' => $request->address,
        ]);

        $userinfo = User::find($userId);
        $userinfo->name = $request->name;
        $userinfo->address = $request->address;
        $userinfo->save();

        return back();  
    }
}
