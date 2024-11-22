<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin\Shop;

class ShopaddController extends Controller
{
//   public function __construct()
    // {
    //     $this->middleware('auth:api');

    // }
    public function shopadd(Request $request)
    {
      $data                   = new Shop();
      $data->user_id          = '12';
      $data->shop_name        = $request->shop_name;
      $data->shop_phone       = $request->shop_phone;
      $data->shop_area        = $request->shop_area;
      $data->shop_address     = $request->shop_address;
      $data->pickup_address   = $request->pickup_address;
      $data->save();
      return response()->json($data, 201);
    }
}
