<?php

namespace App\Http\Controllers;

use App\Admin\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function index()
    {
        $data = Slider::orderBy('id', 'DESC')->get();
        return view('Admin.Slider.slider', compact('data'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Slider/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
        } else {
            $imageUrl = null;
        }
        $data               = new Slider();
        $data->image        = $imageUrl;
        $data->title        = $request->title;
        $data->title2       = $request->title2;
        $data->description  = $request->description;
        $data->save();
        return redirect()->back()->with('message', 'Slider Added Successfully');
    }

    public function edit(Request $request)
    {
        $data = Slider::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = uniqid() . $image->getClientOriginalName();
            $uploadPath = 'public/Slider/';
            $image->move($uploadPath, $imagename);
            $imageUrl = $uploadPath . $imagename;
        } else {
            $logo = Slider::where('id', $request->id)->first();
            $imageUrl = $logo->image;
        }
        Slider::where('id', $request->id)
            ->update([
                'image'         => $imageUrl,
                'title'         => $request->title,
                'title2'        => $request->title2,
                'description'   => $request->description,
            ]);
        return redirect()->back()->with('message', 'Slider Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = Slider::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';
        } else {
            $data->status = '1';
        }
        $data->save();
        return redirect()->back()->with('status', 'Slider Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = Slider::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger', 'Slider Deleted Successfully');
    }
}
