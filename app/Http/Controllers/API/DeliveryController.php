<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin\Agent;
use App\Admin\Company;
use App\Admin\DeliveryAssign;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use App\Admin\Partial;
use App\Admin\PickUpRequestAssign;
use App\Helper\Helpers\Helpers;
use App\User;


class DeliveryController extends Controller
{
    //   public function __construct()
    // {
    //   $this->middleware('auth:api');

    // }

    public function deliveryAssign()
    {
        $user_id = auth('api')->user()->id;
        $order_data = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'users.*')
            ->where('orders.status', 'Assigned To Delivery Rider')
            ->where('delivery_assigns.user_id', $user_id)
            ->get();

        $order = $order_data->unique('tracking_id');

        return response()->json($order);
    }

    public function hold_and_reschedule(Request $request)
    {
        
        $order = DeliveryAssign::orderBy('delivery_assigns.id', 'DESC')
            ->join('orders', 'delivery_assigns.tracking_id', 'orders.tracking_id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->join('order_confirms', 'orders.tracking_id', 'order_confirms.tracking_id')
            ->join('riders', 'delivery_assigns.user_id', 'riders.user_id')
            ->join('users', 'users.id', 'riders.user_id')
            ->select('delivery_assigns.*', 'orders.*', 'merchants.*', 'order_confirms.*', 'users.name as rider_name')
            ->whereIn('orders.status', ['Hold Order', 'Cancel Order', 'Reschedule Order', 'Partially Delivered'])
            // ->where('delivery_assigns.user_id', Auth::user()->id)->distinct('orders.tracking_id')
            //->whereIn('orders.area', $my_array)
            ->where('delivery_assigns.user_id', auth()->user()->id)
            ->get();

        $total = $order->sum('collect');

        return response()->json([
            'order' => $order,
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        $data = new DeliveryAssign();
        $data->name = $request->name;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->status = '1';
        $data->shop = $request->shop;
        $data->save();
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = DeliveryAssign::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        DeliveryAssign::where('id', $request->id)
            ->update([
                'name'    => $request->name,
                'mobile'  => $request->mobile,
                'address' => $request->address,
            ]);
        $msg = 'Updated Successfully';
        return response()->json($msg);
    }

    public function status(Request $request)
    {
        $data = DeliveryAssign::find($request->id);
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
        $data = DeliveryAssign::find($request->id);
        $data->delete();
        $msg = 'Delete Successfully';
        return response()->json($msg);
    }

    public function delivered(Request $request)
    {
        //  return $request->all();
        $order = Order::where('tracking_id', $request->tracking_id)->first();

        if (!$order) {

            return response()->json([
                'msg' => 'Something Went to Wrong Please Try again later.',
                'status' => false,
            ]);
        }

        $user_id = auth('api')->user()->id;
        try {
            $signature_image_file  = $request->file('signature_image');
            $signature_image_file_name = date('mdYHis') . uniqid() . '.' . $signature_image_file->extension();
            $signature_image_file->move(public_path('order_photo/signature_image'), $signature_image_file_name);


            $confirm_image_file  = $request->file('confirm_image');
            $confirm_image_file_name = date('mdYHis') . uniqid() . '.' . $confirm_image_file->extension();
            $confirm_image_file->move(public_path('order_photo/confirm_image'), $confirm_image_file_name);

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id  = $user_id;
            $data->status       = 'Successfully Delivered';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Successfully Delivered';
            $order->signature_image = $signature_image_file_name;
            $order->confirm_image = $confirm_image_file_name;
            $order->save();

            $confirm = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
            $confirm->collect = $order->collection;
            $confirm->return_charge = 0;
            $confirm->save();

            return response()->json([
                'status' => 'true',
                'msg' => 'order delivered successfully'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'false',
                'msg' => 'Something went wrong,please try again'
            ], 404);
        }
    }
    public function deliveredOption(Request $request)
    {

        $user_id = auth('api')->user()->id;
        if ($request->type == 'cancel') {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = $user_id;
            $data->status       = 'Cancel Order';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Cancel Order';
            $order->delivery_note = $request->note;
            $order->save();

            return response()->json([
                'status' => true,
                'msg' => 'Order Cancel Successfully'
            ], 200);
        } else if ($request->type == 'schedule') {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = $user_id;
            $data->status       = 'Reschedule Order';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Reschedule Order';
            $order->delivery_date = $request->date;
            $order->delivery_note = $request->note;
            $order->save();

            return response()->json([
                'status' => true,
                'msg' => 'Order Reschedule Successfully'
            ], 200);
        } else if ($request->type == 'hold') {

            $data = new OrderStatusHistory();
            $data->tracking_id  = $request->tracking_id;
            $data->user_id      = $user_id;
            $data->status       = 'Hold Order';
            $data->save();

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->status = 'Hold Order';
            $order->delivery_note = $request->note;
            $order->save();
            return response()->json([
                'status' => true,
                'msg' => 'Order Hold Successfully'
            ], 200);
        }
    }
    public function partialDelivery(Request $request)
    {



        //return $request->all();
        if (!$request->security_code) {

            return response()->json([
                'status' => false,
                'msg' => 'Security  Code is Empty ! '
            ], 404);
        }
        if (!$request->collection) {


            return response()->json([
                'status' => false,
                'msg' => 'Collection is Empty ! '
            ], 404);
        }

        $order = Order::where('tracking_id', $request->tracking_id)->first();

        if (!$order) {


            return response()->json([
                'status' => false,
                'msg' => 'Something Went to Wrong Please Try again later.'
            ], 404);
        }
        if ($request->security_code != $order->security_code) {


            return response()->json([
                'status' => false,
                'msg' => 'Security Code Does not Match .'
            ], 404);
        }
        if ($request->collection > $order->collection) {


            return response()->json([
                'status' => false,
                'msg' => 'You Can\'n Collect More then Invoice Value'
            ], 404);
        }
        $user_id = auth('api')->user()->id;
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->tracking_id;
        $data->user_id      = $user_id;
        $data->status       = 'Partially Delivered';
        $data->save();

        $order = Order::where('tracking_id', $request->tracking_id)->first();
        $order->status = 'Partially Delivered';
        $order->delivery_note = $request->note;
        $order->save();

        $confirmOrder = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
        $collect = $request->collection - ($confirmOrder->delivery + $confirmOrder->insurance + $confirmOrder->cod); // new calculate m_pay
        $confirmOrder->collect = $request->collection;
        $confirmOrder->merchant_pay = $collect;
        $confirmOrder->save();

        //  id	tracking_id	collection_amt	p_note	p_status	created_by	updated_by	created_at	updated_at	;


        $partial = new Partial();
        $partial->tracking_id = $request->tracking_id;
        $partial->collection_amt = $request->collection;
        $partial->p_note = $request->note;
        $partial->p_status = 0;
        $partial->created_by = $user_id;
        $partial->updated_by = null;
        $partial->save();


        return response()->json([
            'status' => true,
            'msg' => 'Partially Delivered Successfully'
        ], 200);
    }
    public function pending(Request $request)
    {
        $data = new OrderStatusHistory();
        $data->tracking_id  = $request->tracking_id;
        // $data->user_id      = Auth::user()->id;
        $data->status       = 'Delivery Pending';
        $data->save();

        $order = Order::where('tracking_id', $request->tracking_id)->first();
        $order->status = 'Delivery Pending';
        $order->save();


        return response()->json([
            'data' => $data,
            'order' => $order,
        ]);
    }


    // public function code_check(Request $request)
    // {

    //      $order_data = Order::where('tracking_id', $request->tracking_id)->first();

    //     if($order_data){
    //         if($order_data->security_code==$request->code){

    //             return response()->json([
    //                   'status' => true,
    //                   'message' => 'customer code verified',
    //                 ],200);
    //          }
    //          else
    //          {

    //              return response()->json([
    //                   'status' => false,
    //                   'message' => 'customer code not verified',
    //                 ],404);
    //          }

    //     }else{ return response()->json([
    //         'status' => false,
    //         'message' => 'Order Not Found',
    //       ],404);}

    // }



    public function code_check(Request $request)
    {

        $order_data = Order::where('tracking_id', $request->tracking_id)->first();

        if ($order_data) {
            if ($order_data->security_code == $request->code) {
                $user_id = auth('api')->user()->id;
                $data = new OrderStatusHistory();
                $data->tracking_id  = $request->tracking_id;
                $data->user_id  = $user_id;
                $data->status       = 'Successfully Delivered';
                $data->save();

                $order = Order::where('tracking_id', $request->tracking_id)->first();
                $order->status = 'Successfully Delivered';

                $order->save();

                $confirm = OrderConfirm::where('tracking_id', $request->tracking_id)->first();
                $confirm->collect = $order->collection;
                $confirm->return_charge = 0;
                $confirm->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Delivered Order',
                ], 200);
            } else {

                return response()->json([
                    'status' => false,
                    'message' => 'customer code not verified',
                ], 404);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Order Not Found',
            ], 404);
        }
    }

    public function code_resend(Request $request)
    {


        $order_data = Order::where('tracking_id', $request->tracking_id)->first();

        $customer_name = $order_data->customer_name;

        $customer_phone = $order_data->customer_phone;

        $user = User::where('id', $request->rider_id)->first();

        $rider_name = $user->name;

        $rider_phone_no =  $user->mobile;

        $otp_code = rand(1000, 9999);



        $text = "প্রিয় গ্রাহক ,$customer_name আপনার নামে একটা পার্সেল বুকিং করা হয়েছে। আপনার পার্সেল নিয়ে আমাদের ডেলিভারি ম্যান:( $rider_name, মোবা: $rider_phone_no) বের হয়েছে। আপনার সিকিউরিটি কোড:$otp_code যা ডেলিভারি ম্যান আপনার কাছে চাইবে। বিস্তারিত: www.logistic.amvines.com অথবা মোবা: 09613824466 ।";
        $response =  Helpers::sms_send($customer_phone, $text);

        $result = json_decode($response, true);

        if ($result['status_code'] == 200) {

            $order = Order::where('tracking_id', $request->tracking_id)->first();
            $order->security_code = $otp_code;
            $order->save();

            return response()->json([
                'status' => true,
                'message' => 'Code send successfully'
            ], 200);
        } else {

            return response()->json([
                'status' => false,
                'message' => 'Code did not send successfully'
            ], 201);
        }
    }
}
