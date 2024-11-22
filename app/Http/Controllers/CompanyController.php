<?php

namespace App\Http\Controllers;

use App\Admin\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::orderBy('id', 'DESC')->get();
        return view('Admin.Company.company', compact('data'));
    }

    public function store(Request $request)
    {
        $data = new Company();
        $data->name = $request->name;
        $data->title = $request->title;
        $data->address = $request->address;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->website = $request->website;
        $data->terms_condition = $request->terms_condition;
        $data->logo = $request->logo;
        $data->icon = $request->icon;
        $data->save();
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $data = Company::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        // $this->validate($request, [ 'image' => 'required|image|' ]);
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoname = uniqid() . $logo->getClientOriginalName();
            $uploadPath = 'public/Company/Logo/';
            $logo->move($uploadPath, $logoname);
            $logoUrl = $uploadPath . $logoname;
        } else {
            $logoUrl = null;
        }
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconname = uniqid() . $icon->getClientOriginalName();
            $uploadPath = 'public/Company/Icon/';
            $icon->move($uploadPath, $iconname);
            $iconUrl = $uploadPath . $iconname;
        } else {
            $iconUrl = null;
        }
        Company::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'company_initial' => $request->company_initial,
                'title' => $request->title,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'website' => $request->website,
                'terms_condition'=>$request->terms_condition,
                'logo' => $logoUrl,
                'icon' => $iconUrl,
            ]);
        return redirect()->back()->with('message', 'Company Information Updated Successfully');
    }
}
