<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin\Category;
use App\Admin\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        // return "sfjbsd";

        $categories = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $data = Product::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->join('categories', 'products.category', 'categories.id')
            ->select('products.*', 'categories.name as cat_name')
            ->get();
        return view('Admin.Merchant.product', compact('data', 'categories'));
    }

    public function store(Request $request)
    {
        $data               = new Product();
        $data->user_id      = Auth::user()->id;
        $data->title        = $request->title;
        $data->category     = $request->category;
        $data->unit_price   = $request->unit_price;
        $data->quantity     = $request->quantity;
        $data->weight       = $request->weight;
        $data->save();
        return redirect()->back()->with('message', 'Product Added Successfully');
    }

    public function edit(Request $request)
    {
        $data = Product::where('id', $request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        Product::where('id', $request->id)
            ->update([
                'title'         => $request->title,
                'category'      => $request->category,
                'unit_price'    => $request->unit_price,
                'quantity'      => $request->quantity,
                'weight'        => $request->weight,
            ]);
        return redirect()->back()->with('message', 'Product Updated Successfully');
    }

    public function status(Request $request)
    {
        $data = Product::find($request->id);
        if ($data->status == '1') {
            $data->status = '0';
        } else {
            $data->status = '1';
        }
        $data->save();
        return redirect()->back()->with('message', 'Product Status Changed Successfully');
    }

    public function destroy(Request $request)
    {
        $data = Product::find($request->id);
        $data->delete();
        return redirect()->back()->with('danger', 'Product Deleted Successfully');
    }
}
