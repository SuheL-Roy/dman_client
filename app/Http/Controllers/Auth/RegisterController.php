<?php

namespace App\Http\Controllers\Auth;

use App\Admin\Agent;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\District;
use App\Admin\Merchant;
use App\Admin\PaymentInfo;
use App\Admin\Profile;
use App\Admin\Rider;
use App\Admin\ShopPayment;
use App\Admin\Zone;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helpers\Helpers;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile'        => ['required', 'digits:11'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
        // dd($data);

        // return "dfjghdfg";
        // return User::create([
        //     'business_name' => $data['business_name'],
        //     'name'          => $data['name'],
        //     'email'         => $data['email'],
        //     'mobile'        => $data['mobile'],
        //     'area'          => $data['area'],
        //     'type'          => $data['b_type'],
        //     'password'      => Hash::make($data['password']),
        // ]);

        if ($data['role'] == 13) {
            $name           = $data['name'];
            $email          = $data['email'];
            $mobile         = $data['mobile'];
            $password       = $data['password'];
            $business_name  = $data['business_name'];
            $district       = $data['district'];
            $area           = $data['area'];
            $address        = $data['address'];
            $b_type         = $data['b_type'];
            // $bank_name      = $data['bank_name'];
            // $branch_name    = $data['branch_name'];
            // $account_holder = $data['account_holder_name'];
            // $account_type   = $data['account_type'];
            // $account_number = $data['account_number'];
            // $routing_number = $data['routing_number'];
            // $bkash_account  = $data['bkash_account'];
            // $bkash_number   = $data['bkash_number'];
            $user = User::create([
                'name'      => $name,
                'email'     => $email,
                'mobile'    => $mobile,
                'address'   => $address,
                'role'      => 13,
                'password'  => Hash::make($password),
            ]);
            $areas = CoverageArea::where('id', $area)->first();
            $districtdata =  District::where('id', $district)->first();

            $data = new Merchant();
            $data->user_id          = $user->id;
            $data->business_name    = $business_name;
            // $data->district         = $district;
            // $data->area             = $area;
            $data->district = $districtdata->name;
            $data->area     = $areas->zone_name;
            $data->district_id = $district;
            $data->zone_id = $areas->zone_id;
            $data->m_cod            = 0;
            $data->m_discount       = 0;
            $data->m_insurance      = 0;
            $data->created_by      = $user->id;
            $data->b_type           = $b_type;

            $data->save();

            $data = new Profile();
            $data->user_id      = $user->id;
            $data->nid_front    = null;
            $data->nid_back     = null;
            $data->bank_check   = null;
            $data->save();

            $company = Company::where('id', 1)->first();

            $smsText = "{$company->name} পক্ষ থেকে আপনাকে ধন্যবাদ! আপনার মার্চেন্ট অ্যাকাউন্ট নিবন্ধন সফল হয়েছে. দয়া করে অপেক্ষা করুন। আমরা ২৪ ঘণ্টার মধ্যে ম্যানুয়ালি আপনার অ্যাকাউন্টটি চেক করে অ্যাক্টিভেট করে দেওয়া হবে। {$company->name} , {$company->mobile}";
            Helpers::sms_send($mobile, $smsText);

            // $data = new PaymentInfo();
            // $data->user_id              = $user->id;
            // $data->bank_name            = $bank_name;
            // $data->branch_name          = $branch_name;
            // $data->account_holder_name  = $account_holder;
            // $data->account_type         = $account_type;
            // $data->account_number       = $account_number;
            // $data->routing_number       = $routing_number;
            // $data->bkash_account        = $bkash_account;
            // $data->bkash_number         = $bkash_number;
            // $data->save();
        } elseif ($data['role'] == 9) {
            $name       = $data['name'];
            $email      = $data['email'];
            $mobile     = $data['mobile'];
            $password   = $data['password'];
            $district   = $data['district'];
            $area       = $data['area'];

            $user = User::create([
                'name'      => $name,
                'email'     => $email,
                'mobile'    => $mobile,
                'role'      => 9,
                'password'  => Hash::make($password),
            ]);
            $zone = Zone::where('id', $area)->first();
            $districtdata =  District::where('id', $district)->first();
            $data = new Agent();
            $data->user_id  = $user->id;
            $data->district = $districtdata->name;
            $data->area     = $zone->name;
            $data->district_id = $district;
            $data->zone_id = $area;
            $data->save();
        } elseif ($data['role'] == 11) {
            $name       = $data['name'];
            $email      = $data['email'];
            $mobile     = $data['mobile'];
            $password   = $data['password'];
            $district   = $data['district'];
            $area       = $data['area'];

            $user = User::create([
                'name'      => $name,
                'email'     => $email,
                'mobile'    => $mobile,
                'role'      => 11,
                'password'  => Hash::make($password),
            ]);
            $zone = Zone::where('id', $area)->first();
            $districtdata =  District::where('id', $district)->first();
            $data = new Rider();
            $data->user_id  = $user->id;
            $data->district = $districtdata->name;
            $data->area     = $zone->name;
            $data->district_id = $district;
            $data->zone_id = $area;
            $data->save();
        }
        // $merchant = Merchant::create([
        //     'user_id'       => $user->id,
        //     'business_name' => $data['business_name'],
        //     'district'      => $data['district'],
        //     'area'          => $data['area'],
        //     'b_type'        => $data['b_type'],
        // ]);

        // $profile = Profile::create([
        //     'user_id'       => $user->id,
        //     'nid_front'     => null,
        //     'nid_back'      => null,
        //     'bank_check'    => null,
        // ]);

        // $payment = PaymentInfo::create([
        //     'user_id'               => $user->id,
        //     'bank_name'             => $data['bank_name'],
        //     'branch_name'           => $data['branch_name'],
        //     'account_holder_name'   => $data['account_holder_name'],
        //     'account_type'          => $data['account_type'],
        //     'account_number'        => $data['account_number'],
        //     'routing_number'        => $data['routing_number'],
        //     'bkash_account'         => $data['bkash_account'],
        //     'bkash_number'          => $data['bkash_number'],
        // ]);

        return $user;

        // return redirect()->back()->with('success','reg created successfully');
    }
}
