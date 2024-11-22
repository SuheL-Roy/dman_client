<?php

namespace App\Http\Controllers\API;

use App\Admin\BranchDistrict;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Shop;
use App\Admin\CoverageArea;
use App\Admin\Category;
use App\Admin\Company;
use App\Admin\PickUpTime;
use App\Admin\WeightPrice;
use App\Admin\District;
use App\Admin\Merchant;
use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use App\Admin\Zone;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShopController extends Controller
{
    public function store(Request $request)
    {

        $shop = new  Shop();
        $shop->user_id = Auth::user()->id;
        $shop->shop_name = $request->shop_name;
        $shop->shop_phone  = $request->shop_phone;
        $shop->shop_area = $request->shop_area;
        $shop->zone_id = $request->zone_id;
        $shop->shop_address = $request->address;
        $shop->pickup_address = $request->address;
        $shop->shop_link = $request->link ?? '#';
        $shop->save();

        return response()->json(
            array(
                'Status' => true,
                'message' => 'Successfully Created shop',
                'data' => $shop,
            )
        );
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
    public function shop_status(Request $request)
    {

        if ($request->status == 1) {
            Shop::where('id', $request->id)
                ->update([
                    'status' => 0,
                ]);
            $msg = 'Successfully Deactivate Shop';
        } else {
            Shop::where('id', $request->id)
                ->update([
                    'status' => 1,
                ]);
            $msg = 'Successfully Activate Shop';
        }
        return response()->json([
            'message' => $msg,
            'status' => true,
        ]);
    }
    public function edit(Request $request)
    {

        $shop =   Shop::where('id', $request->id)
            ->update([
                'user_id' => Auth::user()->id,
                'shop_name' => $request->shop_name,
                'shop_phone' => $request->shop_phone,
                'shop_area' => $request->shop_area,
                'zone_id' => $request->zone_id,
                'shop_address' => $request->address,
                'pickup_address' => $request->address,
                'shop_link' => $request->link ?? '#',
            ]);


        return response()->json(
            array(
                'Status' => true,
                'message' => 'Successfully updated shop',
                'data' => $shop,
            )
        );
    }
    public function showshoplist()
    {


        $data = Shop::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)

            ->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'Shops List',
                'data' => $data,
            )
        );
    }
    public function coverageArealist()
    {
        // $data = CoverageArea::get();
        $data = CoverageArea::orderBy('coverage_areas.id', 'DESC')->join('zones', 'zones.id', 'coverage_areas.zone_id')->where('coverage_areas.status', 0)->select('coverage_areas.*')->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'Coverage Area List',
                'data' => $data,
            )
        );
    }
    public function zoneList()
    {
        // $data = CoverageArea::get();
        $data = Zone::orderBy('id', 'DESC')->where('status', 0)->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'Branch List',
                'data' => $data,
            )
        );
    }
    public function dist_wise_areaList(Request $request)
    {
        // $data = CoverageArea::get();
        $data = CoverageArea::orderBy('area', 'asc')->where('status', 0)->where('district_id', $request->id)->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'Coverage List',
                'data' => $data,
            )
        );
        
    }
    public function dist_wise_area(Request $request){
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        $data =  CoverageArea::whereIn('zone_id', [$merchant->zone_id,10])->where('district_id', $request->id)->orderBy('area', 'asc')->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'Coverage List',
                'data' => $data,
            )
        );
    }
    public function  orderDatas()
    {
        $weights =  WeightPrice::all();
        $times = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
        $type = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $dist  = District::all();
        return response()->json(array(
            'Status' => true,
            'message' => 'All List',
            'weights' => $weights,
            'dists' => $dist,
            'times' => $times,
            'type' => $type,
        ));
    }
    public function  gee(Request $request)
    {
        $data = Order::with('user')->where('orders.tracking_id', $request->tracking_id)
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->select('orders.*', 'order_confirms.*', 'merchants.business_name as merchant')
            ->first();

        $history = DB::table('order_status_histories')->join('users', 'users.id', '=', 'order_status_histories.user_id')->where('order_status_histories.tracking_id', $data->tracking_id)
            ->select('order_status_histories.status as status', 'order_status_histories.created_at as date', 'users.name as name', 'users.mobile as mobile')->get();

        $order_statuses = OrderStatusHistory::where('tracking_id', $data->tracking_id)->latest('id')->get();

        $new_array = array();
        foreach ($order_statuses as $key => $value) {

            if (!isset($new_array[$value['status']])) {
                $new_array[$value['status']] = $value;
            }
        }

        $order_statuses  = $new_array = array_values($new_array);


        $company = Company::first();


        return response()->json([
            'data' => $data,
            'order_history' => $history,
            'order_status' => $order_statuses,
            'company' => $company
        ]);
    }
    public function distList()
    {
        // $data = CoverageArea::get();
        $data = District::orderBy('name','asc')->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'District List',
                'data' => $data,
            )
        );
    }

    public function hub_wise_dist_list(Request $request){
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        $data = BranchDistrict::whereIn('z_id',[$merchant->zone_id,10])->orderBy('d_name','asc')->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'District List',
                'data' => $data,
            )
        );
    }

    public function pickUpTime()
    {

        $data = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();

        return response()->json(array(
            'Status' => true,
            'message' => 'Pickup Time List',
            'data' => $data,
        ));
    }
    public function weights()
    {

        $data = WeightPrice::all();

        return response()->json(array(
            'Status' => true,
            'message' => 'Weights List',
            'data' => $data,
        ));
    }
    // public function  orderDatas()
    // {
    //     $shops = Shop::orderBy('id', 'DESC')
    //         ->where('user_id', Auth::user()->id)->get();
    //     $areas = CoverageArea::orderBy('id', 'DESC')->join('zones', 'zones.id', 'coverage_areas.zone_id')->where('status', 0)->select('coverage_areas.*')->get();
    //     $times = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
    //     $type = Category::orderBy('id', 'DESC')->where('status', 1)->get();
    //     return response()->json(array(
    //         'Status' => true,
    //         'message' => 'All List',
    //         'shops' => $shops,
    //         'areas' => $areas,
    //         'times' => $times,
    //         'type' => $type,
    //     ));
    // }

    public function category()
    {
        $data = Category::orderBy('id', 'DESC')->where('status', 1)->get();

        return response()->json(array(
            'Status' => true,
            'message' => 'Category List',
            'data' => $data,
        ));
    }

    public function CoverageAreaLists()
    {
        $data = CoverageArea::orderBy('coverage_areas.area', 'asc')->join('zones', 'zones.id', 'coverage_areas.zone_id')->where('coverage_areas.status', 0)->select('coverage_areas.*')->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'Coverage Area List',
                'data' => $data,
            )
        );
    }
}
