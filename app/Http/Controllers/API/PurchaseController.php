<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Purchase;
use App\Admin\PurchaseItem;
use App\Admin\Stock;
use DateTime;

class PurchaseController extends Controller
{
    public function purchase_no(Request $request)
    {
        $shop = $request->shop;
        $date = new DateTime("now");
        if ($last = Purchase::all()->last()){  
            $sl = $last->id; 
        } else { 
            $sl = 0; 
        }
        $pi = 'PO';
        $s = $sl + 1 ;
        $data = $shop . $date->format('Y') . $s ;
        $purchase_no[] = [  'purchase_no'   =>  $pi . $data   ];
        return response()->json($purchase_no);
    }

    public function purchase(Request $request)
    {
        $data               = new Purchase();
        $data->purchase_no  = $request->purchase_no;
        $data->supplier     = $request->supplier;
        $data->date         = $request->date;
        $data->totalQty     = $request->totalQty;
        $data->subTotal     = $request->subTotal;
        $data->discount     = $request->discount;
        $data->d_type       = $request->d_type;
        $data->payable      = $request->payable;
        $data->paid         = $request->paid;
        $data->return       = $request->return;
        $data->due          = $request->due;
        $data->p_type       = $request->p_type;
        $data->shop         = $request->shop;
        $data->user         = $request->user;
        $data->save();
        // $purchase_no[] = [  'purchase_no'   =>  $data->purchase_no   ];
        return response()->json($data);
    }

    public function purchase_item(Request $request)
    {
        $data               = new PurchaseItem();
        $data->name         = $request->name;
        $data->code         = $request->code;
        $data->qty          = $request->quantity;
        $data->cost         = $request->cost;
        $data->total        = $request->total;
        $data->purchase_no  = $request->purchase_no;
        $data->date         = $request->date;
        $data->shop         = $request->shop;
        $data->user         = $request->user;
        $data->save();
        return response()->json($data);
    }
    public function purchase_stock(Request $request)
    {
        $exist = Stock::where('code', $request->code)
                    ->where('shop', $request->shop)
                    ->first();
        if($exist == null){
            $sdata          = new Stock();
            $sdata->name    = $request->name;
            $sdata->code    = $request->code;
            $sdata->minimum = $request->stock;
            $sdata->quantity= $request->quantity;
            $sdata->unit    = $request->unit;
            $sdata->cost    = $request->cost;
            $sdata->price   = $request->price;
            $sdata->shop    = $request->shop;
            $sdata->user    = $request->user;
            $sdata->save();
        } else {
            $sdata = Stock::where('code', $request->code)
                        ->where('shop', $request->shop)
                        ->increment('quantity', $request->quantity);
        } return response()->json($sdata);
    }

    public function stock()
    {
        $data = Stock::all();
        return response()->json($data);
    }

    public function purchase_report()
    {
        $data = Purchase::all();
        return response()->json($data);
    }

    public function purchase_item_report()
    {
        $data = PurchaseItem::all();
        return response()->json($data);
    }
    
    public function purchase_date_wise(Request $request)
    {
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $data = $data = Purchase::whereBetween('date', [$fromdate, $todate])->get();
        return response()->json($data);
    }

}
