<?php

namespace App\Http\Controllers;

use App\Admin\CoverageArea;
use App\Admin\Order;
use App\Admin\OrderStatusHistory;
use App\Admin\Slider;
use App\Admin\WeightPrice;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{


    public function superhome()
    {
        # code...
        return view('auth.login');
        $district = CoverageArea::all()->unique('district');
        $weights = WeightPrice::all();
        return view('Superend.index', compact('district', 'weights'));
        // return view('Superend.index', compact('district', 'weights'));
    }

    public function tracking_details(Request $request)
    {
        $tracking_data = Order::where('tracking_id', $request->tracking_id)->first();

        $order_statuses = OrderStatusHistory::where('tracking_id', $request->tracking_id)->latest('id')->get();

        $new_array = array();
        foreach ($order_statuses as $key => $value) {

            if (!isset($new_array[$value['status']])) {
                $new_array[$value['status']] = $value;
            }
        }

        $order_statuses   = $new_array = array_values($new_array);
        return view('Superend.tracking_details', compact('tracking_data', 'order_statuses'));
    }

    public function frontend()
    {
        // return "sgsdrl";
        return view('auth.login');
        return view('frontend_new.index');
        return
            "sdkjfsjdfhs";
        $slider = Slider::orderBy('id', 'DESC')->where('status', 1)->get();
        return view('FrontEnd.welcome', compact('slider'));
    }

    public function track(Request $request)
    {
        if ($request->id == !null) {
            $data = Order::where('tracking_id', $request->id)->first();
            if ($data == null) {
                $msg = "Please Enter A Valid Tracking ID And Try Again.";
            } else {
                $status = $data->status;
                $customer = $data->customer_name;
                $msg = "Tracking ID : " . $request->id . " , Customer Name : " . $customer .  " , Order Status : " . $status;
            }
            // } elseif ($request->id == !null) {  
            //     $data = Order::where('tracking_id', $request->id)->first();
            //     $status = $data->status;

            //     $msg = "Please Enter A Valid Tracking ID And Try Again."; 
        } else {
            $msg = "Please Enter A Valid Tracking ID And Try Again.";
        }
        $request->session()->flash('message', $msg);
        // return redirect()->back();
        return redirect('/#about_top');
    }
}
