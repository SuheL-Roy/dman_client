<?php

namespace App\Http\Controllers\Api;

use App\Admin\CoverageArea;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = new Supplier();
        $data->name = $request->name;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->balance = $request->balance;
        $data->status = '1';
        $data->shop = $request->shop;
        $data->save();
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = Supplier::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Supplier::where('id', $request->id)
            ->update([
                'name'    => $request->name,
                'mobile'  => $request->mobile,
                'address' => $request->address,
                'balance' => $request->balance,
            ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }

    public function status(Request $request)
    {
        $data = Supplier::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';
        } else {
            $data->status = '1';
        }
        $data->save();
        $msg = 'Status Changed Successfully';
        return response()->json($msg);
    }

    public function delete(Request $request)
    {
        $data = Supplier::find($request->id);
        $data->delete();
        $msg = 'Delete Successfully';
        return response()->json($msg);
    }


    public function coverageArealist()
    {
        $data = CoverageArea::orderBy('coverage_areas.id', 'DESC')->join('zones', 'zones.id', 'coverage_areas.zone_id')->where('coverage_areas.status', 0)->select('coverage_areas.*')->get();
        return response()->json(
            array(
                'Status' => true,
                'message' => 'Coverage Area List',
                'data' => $data,
            )
        );
    }
}
