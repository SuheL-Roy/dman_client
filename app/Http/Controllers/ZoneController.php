<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin\Zone;
use App\Admin\District;
use Illuminate\Support\Facades\Auth;

class ZoneController extends Controller
{
        public function index(){

        $zones = Zone::orderBy('id','DESC')->get();
        $districts = District::orderBy('name','ASC')->get();
    
        return view('Admin.zone.list',compact('zones','districts'));
    
       }      
       public function store(Request $request)
       {

        $zone = new Zone();
        $zone->district_id = $request->district;
        $zone->name = $request->name; 
        $zone->ceate_by = Auth::user()->id;       
        $zone->save();

        return redirect()->route( 'zone.index' )->with( [ 'success' => 'Zone added successfully' ] );
    
       } 
       public function edit(Request $request)
       {

        $data = Zone::where('id', $request->id)->get();
        return response()->json($data);

       }   
       public function update(Request $request)
       {

        $zone = Zone::find($request->id);
        $zone->district_id = $request->district;
        $zone->name = $request->name;     
        $zone->save();

        return redirect()->route( 'zone.index' )->with( [ 'message' => 'Zone updated successfully' ] );     

    
       }

       public function status(Request $request)
       {

        $zone = Zone::find($request->id);
        $zone->status = $request->status;     
        $zone->save();

        return redirect()->route( 'zone.index' );

    
       }
}
