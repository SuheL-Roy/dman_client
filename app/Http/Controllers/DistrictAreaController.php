<?php

namespace App\Http\Controllers;

use App\Admin\CoverageArea;
use App\Admin\District;
use App\Admin\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistrictAreaController extends Controller
{
    public function index()
    {
        $data = CoverageArea::orderBy('id', 'DESC')->get();
        $districts = DB::table('districts')->orderBy('districts.name', 'asc')->leftJoin('zones', 'districts.zone_id', 'zones.id')
            ->select('districts.*', 'zones.name as zone_name')
            ->get();
        $zones = Zone::orderBy('name', 'asc')->get();


        return view('Admin.CoverageArea.districtlist', compact('data', 'districts', 'zones'));
    }
    public function edit(Request $request)
    {

        //zone data
        $districts = District::all();
        $zones = Zone::all();
        $district = District::where('id', $request->id)->first();

        $zone_data_count = $zones->count();
        $districtCount = $districts->count();

        return response()->json([$zones, $districts, $district, $zone_data_count, $districtCount]);
    }

    public function update(Request $request)
    {

        District::where('id', $request->id)
            ->update([

                'inside'    => $request->inside
            ]);

        session()->put('message', 'Branch  Updated successfully');
    }
    
}
