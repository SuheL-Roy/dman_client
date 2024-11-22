<?php

namespace App\Http\Controllers;

use App\Admin\BranchDistrict;
use App\Admin\CoverageArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin\Zone;
use App\Admin\District;
use session;
use response;

class CoverageAreaController extends Controller
{
    public function index()
    {
        $data = CoverageArea::orderBy('id', 'DESC')->get();
        $districts = DB::table('districts')->orderBy('name', 'asc')->get();
        $zones = Zone::orderBy('name', 'asc')->get();


        return view('Admin.CoverageArea.coverageArea', compact('data', 'districts', 'zones'));
    }

    public function store(Request $request)
    {
        $district =  District::where('id', $request->district)->first();
        $zone =  Zone::where('id', $request->zone)->first();
        $data               = new CoverageArea();
        $data->inside       = $request->inside;
        $data->city_track   = $request->city_track;
        $data->district     = $district->name;
        $data->zone_name    = $zone->name;
        $data->area         = $request->area;
        $data->district_id    = $district->id;
        $data->zone_id         = $zone->id;
        $data->post_code    = $request->post_code;
        $data->h_delivery   = $request->h_delivery;
        $data->oneRe        = $request->oneRe;
        $data->oneUr        = $request->oneUr;
        $data->plusRe       = $request->plusRe;
        $data->plusUr       = $request->plusUr;
        $data->cod          = $request->cod;
        $data->insurance    = $request->insurance;
        $data->save();


        session()->put('success', 'Coverage Area Added successfully');

        return redirect()->route('coverage.area.index');
    }

    public function edit(Request $request)
    {
        $data = CoverageArea::where('id', $request->id)->first();

        //zone data
        $districts = BranchDistrict::where('z_id', $data->zone_id)->get();
        $district_id =  $data->district_id;

        $zone_data = Zone::all();

        $zone_data_count = $zone_data->count();
        $districtCount = $districts->count();

        // return response()->json($data,$zone_data);


        //  return json_encode(array('data' => $data,''));


        return response()->json([$data, $zone_data, $zone_data_count, $districts, $districtCount, $district_id]);
    }

    public function update(Request $request)
    {
       
        //   session()->put('message', $request->all());  
        $district =  District::where('id', $request->district)->first();
        $zone =  Zone::where('id', $request->zone)->first();

        CoverageArea::where('id', $request->id)
            ->update([

                'inside'    => $request->inside,
                'city_track' => $request->insides,
                'district'  => $district->name,
                'zone_name' => $zone->name,
                'area'      => $request->area,
                'district_id' => $district->id,
                'zone_id'  => $zone->id,
                'status'  => 0,

            ]);


        session()->put('message', 'Coverage Area Updated successfully');
    }

    public function destroy(Request $request)
    {
        $data = CoverageArea::where('id', $request->id);
        $data->delete();


        session()->put('danger', 'Coverage Area Deleted successfully');
    }
}
