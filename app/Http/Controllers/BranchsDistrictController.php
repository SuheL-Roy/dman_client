<?php

namespace App\Http\Controllers;

use App\Admin\BranchDistrict;
use App\Admin\CoverageArea;
use App\Admin\District;
use App\Admin\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchsDistrictController extends Controller
{
    public function index(Request $request)
    {
        if ($request->zone) {


            $selectedZone = $request->zone;

            $district_branchs = BranchDistrict::where('z_id', $selectedZone)->get();
            $zones = Zone::orderBy('name', 'asc')->where('status', 0)->get();
        } else {


            $district_branchs = [];
            $zones = Zone::orderBy('name', 'asc')->where('status', 0)->get();
            $selectedZone = '';
        }
        $districts = District::all();



        return view('Admin.BranchDistrict.index', compact('districts', 'zones', 'selectedZone', 'district_branchs'));
    }
    public function store(Request $request)
    {

        $dist = District::orderBy('name', 'asc')->where('id', $request->dist)->first();
        $zone = Zone::orderBy('name', 'asc')->where('id', $request->zone)->first();
        if ($dist && $zone) {
            // return    $dist->inside??0;;
            $data = new BranchDistrict();
            $data->d_name  = $dist->name;
            $data->z_name      = $zone->name;
            $data->d_id       = $dist->id;
            $data->z_id = $zone->id;
            $data->inside = $dist->inside ?? 0;
            $data->save();

            // $covarageAras= CoverageArea::where('status',1)->where('district_id',$data->d_id)->get();
            // foreach($covarageAras as $area){

            //     CoverageArea::where('id',$area->id)
            //     ->update([
            //         'inside'    => $dist->inside,
            //         'district'  => $dist->name,
            //         'zone_name' => $zone->name,
            //         'district_id' => $dist->id,
            //         'zone_id'  => $zone->id,
            //         'status'    => 0
            //     ]);




            \Toastr::success('Successfully Added ', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        } else {
            \Toastr::success('Something went to wrong  ', 'Warning!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
            return redirect()->back();
        }
    }
    public function edit(Request $request)
    {

        //zone data
        $districts = District::all();

        $zones = Zone::all();
        $district = BranchDistrict::where('id', $request->id)->first();




        $zone_data_count = $zones->count();
        $districtCount = $districts->count();

        return response()->json([$zones, $districts, $district, $zone_data_count, $districtCount]);
    }

    public function update(Request $request)
    {


        $dist = District::orderBy('name', 'asc')->where('id', $request->dist)->first();
        $zone = Zone::orderBy('name', 'asc')->where('id', $request->zone)->first();

        $b_dist = BranchDistrict::where('id', $request->id)->first();
        $covarageAras = CoverageArea::where('zone_id', $b_dist->z_id)->where('district_id', $b_dist->d_id)->get();
        foreach ($covarageAras as $area) {

            CoverageArea::where('id', $area->id)
                ->update([
                    'inside'    => $dist->inside,
                    'district'  => $dist->name,
                    'zone_name' => $zone->name,
                    'district_id' => $dist->id,
                    'zone_id'  => $zone->id,
                    'status'    => 0
                ]);
        }

        BranchDistrict::where('id', $request->id)
            ->update([

                'd_name'    => $dist->name,
                'z_name'    => $zone->name,
                'd_id'    => $dist->id,
                'z_id'    => $zone->id,
                'inside'    => $dist->inside ?? 0
            ]);




        session()->put('message', 'Branch  Updated successfully');
    }
    public function destroy(Request $request)
    {

        $dist = BranchDistrict::where('id', $request->id)->first();
        $covarageAra = CoverageArea::where('zone_id', $dist->z_id)->where('district_id', $dist->d_id)->get();

        foreach ($covarageAra as $area) {

            CoverageArea::where('id', $area->id)
                ->update([
                    'status'    => 1
                ]);
        }
        $data = BranchDistrict::where('id', $request->id);
        $data->delete();


        session()->put('danger', 'Remove this Branch');
    }
}
