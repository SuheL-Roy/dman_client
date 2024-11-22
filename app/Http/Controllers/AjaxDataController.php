<?php

namespace App\Http\Controllers;

use App\Admin\BranchDistrict;
use App\Admin\CoverageArea;
use Illuminate\Http\Request;
use App\Admin\Zone;
use App\Admin\District;
use App\Admin\Shop;
use App\Admin\Merchant;
use App\Admin\Rider;
use App\Admin\Agent;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;

class AjaxDataController extends Controller
{



    public function fetch_subcategory_value(Request $request)
    {
        $data = Merchant::where('user_id', auth()->user()->id)->first();

        $options = CoverageArea::whereIn('zone_id', [$data->zone_id, 10])->where('district_id', $request->id)->orderBy('area', 'asc')->get();
        return response()->json(['options' => $options]);



        // $options = SubCategory::where('category_id', $request->id)->get();
        // return response()->json(['options' => $options]);
    }

    public function fetch_subcategory_value_edit(Request $request)
    {
        $options = CoverageArea::where('district_id', $request->id)->orderBy('area', 'asc')->get();
        return response()->json(['options' => $options]);
    }

    public function fetch_subcategory_value_new(Request $request)
    {
        $data = Merchant::where('user_id', $request->merchant_id)->first();

        $options = CoverageArea::whereIn('zone_id', [$data->zone_id, 10])->where('district_id', $request->id)->orderBy('area', 'asc')->get();
        return response()->json(['options' => $options]);
    }

    public function merchant_wise_district(Request $request)
    {

        $data = Merchant::where('user_id', $request->id)->first();

        $options = BranchDistrict::whereIn('z_id', [$data->zone_id, 10])->orderBy('d_name', 'asc')->get();
        return $options;
    }


    public function area_data_merchant(Request $request)
    {
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();

        $data = CoverageArea::where('zone_id', $merchant->zone_id)->where('district', '=', $request->zone)->get();

        return json_encode(array('data' => $data));
    }
    public function area_data(Request $request)
    {


        $data = CoverageArea::where('zone_name', '=', $request->zone)->get();


        return json_encode(array('data' => $data));
    }




    public function area_data_data(Request $request)
    {
        $data = CoverageArea::where('district', '=', $request->district)->get();
        return json_encode(array('data' => $data));
    }

    public function zone_data(Request $request)
    {

        $data = Zone::where('status', 1)->where('district_id', $request->district)->get();

        return json_encode(array('data' => $data));
    }
    public function singleZone(Request $request)
    {

        $data = CoverageArea::where('area', $request->area)->first();

        return json_encode($data);
    }
    public function drict_data(Request $request)
    {
        $data = BranchDistrict::where('z_id', $request->zone_id)->get();

        return json_encode(array('data' => $data));
    }



    public function drict_data1(Request $request)
    {

        $singel = Zone::where('id', $request->zone_id)->first();
        $data = District::where('zone_id', $singel->id)->get();

        return json_encode(array('data' => $data));
    }

    public function shop_data(Request $request)
    {

        $data = Shop::orderBy('id', 'DESC')
            ->where('user_id', $request->user_id)
            ->where('status', 1)
            ->get();
        //  $data = Zone::where('status',1)->where('district_id',$request->district)->get();   

        return json_encode(array('data' => $data));
    }


    public function rider_hub_data(Request $request)
    {

        $agent = Agent::where('user_id', $request->sel_hub)->first();
        $area = $agent->area;

        $data = User::orderBy('users.name', 'ASC')
            ->join('riders', 'users.id', 'riders.user_id')
            ->select('riders.area', 'users.*')
            ->where('riders.area', $area)
            ->where('users.role', 10)
            ->get();

        return json_encode(array('data' => $data));
    }

    public function merchant_rider(Request $request)
    {


        $hub = Merchant::where('id', '=', $request->id)->value('area');

        $data = Rider::where('riders.area', $hub)
            ->join('users', 'riders.user_id', 'users.id')
            ->select('riders.id', 'users.name')
            ->get();



        return json_encode(array('data' => $data, 'hub' => $hub));
    }

    public function coverage_data(Request $request)
    {

        $data = CoverageArea::where('district_id', $request->zone_id)->where('status', 0)->orderBy('area', 'asc')->get();

        $option = "<option value='' >Select Area</option>";
        foreach ($data as $key => $value) {
            $id = $value->id;
            $area_name = $value->area;

            $option .= "<option value='$id' >$area_name</option>";
        }
        return $option;
    }
}
