<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin\WeightPrice;
use Auth;

class WeightPriceController extends Controller
{

  public function index()
  {

    $weight_prices = WeightPrice::orderBy('id', 'DESC')->get();

    return view('Admin.Weight_price.list', compact('weight_prices'));
  }
  public function add()
  {

    return view('Admin.Weight_price.add');
  }
  public function store(Request $request)
  {

    //dd($request->all());

    $weightprice = new WeightPrice();
    $weightprice->title = $request->title;
    $weightprice->ind_Re = $request->ind_Re;
    $weightprice->ind_Ur = $request->ind_Ur;
    $weightprice->out_Re = $request->out_Re;
    $weightprice->out_Ur = $request->out_Ur;
    $weightprice->sub_Re = $request->sub_Re;
    $weightprice->sub_Ur = $request->sub_Ur;
    $weightprice->ind_ReC = $request->ind_ReC;
    $weightprice->out_ReC = $request->out_ReC;
    $weightprice->sub_ReC = $request->sub_ReC;
    $weightprice->insurance = $request->insurance;
    $weightprice->cod = $request->cod;
    $weightprice->sub_dhaka_cod = $request->sub_dhaka_cod;
    $weightprice->outside_dhaka_cod = $request->outside_dhaka_cod;
    $weightprice->ind_city_Re = $request->ind_city_Re;
    $weightprice->out_city_Re = $request->out_city_Re;
    $weightprice->sub_city_Re = $request->sub_city_Re;
    $weightprice->ind_city_Ur = $request->ind_city_Ur;
    $weightprice->out_City_Ur = $request->out_City_Ur;
    $weightprice->sub_city_Ur = $request->sub_city_Ur;

    $weightprice->inside_city_cod = $request->inside_city_cod;
    $weightprice->outside_city_cod = $request->outside_city_cod;
    $weightprice->sub_city_cod = $request->sub_city_cod;

    $weightprice->create_by = Auth::user()->id;
    $weightprice->save();

    return redirect()->route('weight_price.index')->with(['message' => 'Weight & Price added successfully']);
  }
  public function edit(Request $request)
  {

    $weightprice = WeightPrice::where('id', $request->id)->first();

    return view('Admin.Weight_price.edit', ['weightprice' => $weightprice]);
  }
  public function update(Request $request)
  {

    $weightprice = WeightPrice::find($request->id);
    $weightprice->title = $request->title;
    $weightprice->ind_Re = $request->ind_Re;
    $weightprice->ind_Ur = $request->ind_Ur;
    $weightprice->out_Re = $request->out_Re;
    $weightprice->out_Ur = $request->out_Ur;
    $weightprice->sub_Re = $request->sub_Re;
    $weightprice->sub_Ur = $request->sub_Ur;
    $weightprice->ind_ReC = $request->ind_ReC;
    $weightprice->out_ReC = $request->out_ReC;
    $weightprice->sub_ReC = $request->sub_ReC;
    $weightprice->insurance = $request->insurance;
    $weightprice->cod = $request->cod;
    $weightprice->sub_dhaka_cod = $request->sub_dhaka_cod;
    $weightprice->outside_dhaka_cod = $request->outside_dhaka_cod;
    $weightprice->ind_city_Re = $request->ind_city_Re;
    $weightprice->out_city_Re = $request->out_city_Re;
    $weightprice->sub_city_Re = $request->sub_city_Re;
    $weightprice->ind_city_Ur = $request->ind_city_Ur;
    $weightprice->out_City_Ur = $request->out_City_Ur;
    $weightprice->sub_city_Ur = $request->sub_city_Ur;


    $weightprice->inside_city_cod = $request->inside_city_cod;
    $weightprice->outside_city_cod = $request->outside_city_cod;
    $weightprice->sub_city_cod = $request->sub_city_cod;

    $weightprice->save();

    return redirect()->route('weight_price.index')->with(['message' => 'Weight & Price updated successfully']);
  }

  public function destroy(Request $request)
  {
    $data = WeightPrice::find($request->id);
    $data->delete();
    return redirect()->back()->with(['message' => 'Weight & Price Deleted successfully']);
  }
}
