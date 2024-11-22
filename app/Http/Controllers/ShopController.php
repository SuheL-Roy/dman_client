<?php

namespace App\Http\Controllers;

use App\Admin\Shop;
use App\Admin\CoverageArea;
use App\Admin\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        // return "sdfjbsd";
        $coverage_area = Zone::latest('id')->get();
        $data = Shop::orderBy('id', 'DESC')->where('user_id', Auth::user()->id)->get();
        return view('Admin.Merchant.shop', compact('data', 'coverage_area'));
    }

    public function store(Request $request)
    {
       
          $zone = Zone::where('name',$request->shop_area)->first();
        
        $data                   = new Shop();
        $data->user_id          = Auth::user()->id;
        $data->shop_name        = $request->shop_name;
        $data->shop_phone       = $request->shop_phone;
        $data->shop_area        = $request->shop_area;
        $data->zone_id        = $zone->id;
        $data->shop_address     = $request->shop_address;
        $data->pickup_address   = $request->pickup_address;
        $data->shop_link   = $request->shop_link;

        $data->save();
        \Toastr::success('Shop Added Successfully', 'Insert', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $data = Shop::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
      
            $zone = Zone::where('name',$request->shop_area)->first();
          
        Shop::where('id', $request->id)->update([
            'shop_name'         => $request->shop_name,
            'shop_phone'        => $request->shop_phone,
            'shop_area'         => $request->shop_area,
            'zone_id'         =>  $zone->id,
            'shop_address'      => $request->shop_address,
            'pickup_address'    => $request->pickup_address,
            'shop_link'         => $request->shop_link,
        ]);
        return redirect()->back()->with('message', 'Shop Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = Shop::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';
        } else {
            $data->status = '1';
        }
        $data->save();
        return redirect()->back()->with('status', 'Shop Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = Shop::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger', 'Shop Deleted Successfully');
    }
}
