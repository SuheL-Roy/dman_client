<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\Admin\Sale;
use App\Admin\SaleItem;
use App\Admin\Stock;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function sale_no(Request $request)
    {
        $shop = $request->shop;
        $date = new DateTime("now");
        if ($last = Sale::all()->last()){  
            $sl = $last->id; 
        } else { 
            $sl = 0; 
        }
        $si = 'INV';
        $s = $sl + 1 ;
        $data = $shop . $date->format('Y') . $s ;
        $sale_no[] = [  'sale_no'   =>  $si . $data   ];
        return response()->json($sale_no);
    }
    public function sale(Request $request)
    {
        $data               = new Sale();
        $data->sale_no  = $request->sale_no;
        $data->customer = $request->customer;
        $data->delivery = $request->delivery;
        $data->date     = $request->date;
        $data->totalQty = $request->totalQty;
        $data->subTotal = $request->subTotal;
        $data->discount = $request->discount;
        $data->d_type   = $request->d_type;
        $data->payable  = $request->payable;
        $data->paid     = $request->paid;
        $data->return   = $request->return;
        $data->due      = $request->due;
        $data->p_type   = $request->p_type;
        $data->shop     = $request->shop;
        $data->user     = $request->user;
        $data->save();
        return response()->json($data);
    }

    public function sale_item(Request $request)
    {
        $data           = new SaleItem();
        $data->name     = $request->name;
        $data->code     = $request->code;
        $data->qty      = $request->qty;
        $data->price    = $request->price;
        $data->total    = $request->total;
        $data->sale_no  = $request->sale_no;
        $data->date     = $request->date;
        $data->shop     = $request->shop;
        $data->user     = $request->user;
        $data->save();
        $update = DB::table('stocks')
                    ->where('code', $request->code)
                    ->decrement('quantity', $request->qty);
        return response()->json($data);
    }

    public function sale_report()
    {
        $data = Sale::all();
        return response()->json($data);
    }

    public function sale_item_report()
    {
        $data = SaleItem::all();
        return response()->json($data);
    }

    public function sale_date_wise(Request $request)
    {
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $data = $data = Sale::whereBetween('date', [$fromdate, $todate])->get();
        return response()->json($data);
    }

}
