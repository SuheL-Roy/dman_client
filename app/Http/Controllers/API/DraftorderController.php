<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\BusinessType;
use App\Admin\Category;
use App\Admin\CoverageArea;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderProduct;
use App\Admin\OrderStatusHistory;
use App\Admin\PickUpTime;
use App\Admin\Product;
use App\Admin\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DraftorderController extends Controller
{
//   public function __construct()
    // {
    //   $this->middleware('auth:api');

    // }

    public function draftorder()
      {
        
        $data = Order::orderBy('id', 'DESC')->get();

        return response()->json($data);
      }

    public function draftshow($id)
      {
          $data = Category::orderBy('id', 'DESC')->where('status', 1)->get();
          $data = PickUpTime::orderBy('id', 'DESC')->where('status', 1)->get();
          $data = CoverageArea::orderBy('id', 'DESC')->get();
          $data = Shop::orderBy('id', 'DESC')
                    // ->where('user_id', Auth::user()->id)
                    ->where('status', 1)
                    ->get();
        $data = Order::find($id);
        return response()->json($data);
      }

      public function draftupdete(StoreUserRequest  $request, $id)
      {
        // $are = CoverageArea::where('area', $request->area)->first();
        // $article = Order::findOrFail($id);
        // return response()->json($article, 200);
        // $article->update($request->all());

        $article = Order::findOrFail($request->id)->update([
                    'order_id'          => $request->order_id,
                    'customer_name'     => $request->customer_name,
                    'customer_email'    => $request->customer_email,
                    'customer_phone'    => $request->customer_phone,
                    'customer_address'  => $request->customer_address,
                    'shop'              => $request->shop,
                    'area'              => $request->area,
                    'pickup_date'       => $request->pickup_date,
                    'pickup_time'       => $request->pickup_time,
                    'remarks'           => $request->remarks,
                    'category'          => $request->category,
                    'product'           => $request->product,
                    'weight'            => $request->weight,
                    'collection'        => $request->collection,
                    // 'inside'            => $are->inside,
                    // 'district'          => $are->district,
                    'type'              => $request->imp,
                ]);
                
              return response()->json($article, 200);
                
        //
        // $imp = $request->imp;
        // $collection = $request->collection;
        // if ($imp == 'Regular') {
        //     $ar = CoverageArea::where('area', $request->area)->first();
        //     $chrg = $ar->oneRe;
        //     $co = $ar->cod;
        //     $ins = $ar->insurance;
        //     $home = $ar->h_delivery;
        // } elseif ($imp == 'Urgent') {
        //     $ar = CoverageArea::where('area', $request->area)->first();
        //     $chrg = $ar->oneUr;
        //     $co = $ar->cod;
        //     $ins = $ar->insurance;
        //     $home = $ar->h_delivery;
        // }
        // $w = $request->weight;
        // $delivery = $chrg * $w;
        // $cod = ($collection * $co) / 100;
        // $insurance = ($collection * $ins) / 100;
        // $m_pay = $collection - ($delivery + $cod + $insurance);
        //
        // if ($home = 1) {
        //     $h = 'Yes';
        // } elseif ($home = 0) {
        //     $h = 'No';
        // }
        // $track      = $request->tracking_id;
        // $order      = $request->order_id;
        // $shop       = $request->shop;
        // $area       = $request->area;
        // $c_name     = $request->customer_name;
        // $c_email    = $request->customer_email;
        // $c_phone    = $request->customer_phone;
        // $address    = $request->customer_address;
        // $p_date     = $request->pickup_date;
        // $p_time     = $request->pickup_time;
        // $product    = $request->product;
        // $category   = $request->category;
        // $weight     = $request->weight;
        // $msg        = "Order Placed for Confirmation";

      }
}
