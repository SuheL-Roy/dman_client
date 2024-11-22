<?php

namespace App\Http\Controllers;

use App\Admin\BypassReturn;
use App\Admin\Order;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\String\b;

class BypassController extends Controller
{
    public function index()
    {
        $bypass = BypassReturn::latest('bypass_returns.id') ->join('orders', 'orders.tracking_id', 'bypass_returns.tracking_id')->where('orders.status', 'Order Cancel by Branch')->get();
        $bypass =$bypass->pluck('tracking_id');

        $bypasses = Order::latest('orders.id')
            ->join('order_confirms', 'order_confirms.tracking_id', 'orders.tracking_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('merchants', 'orders.user_id', 'merchants.user_id')
            ->orWhereIn('orders.tracking_id', $bypass)
            ->orWhereIn('orders.status', ['Order Cancel by Branch','Order Cancel By Fullfilment'])
            ->select('orders.*', 'order_confirms.*', 'merchants.*','users.*' )
            // ->select('orders.*', 'order_confirms.*')
            ->get()->unique('tracking_id');
        return view('Backend.Bypass.index', compact('bypasses'));
    }


    public function aprove($id)
    {

        $order = Order::where('tracking_id', $id)->first();
        
        if($order->status=='Order Cancel By Fullfilment'){

            // Return Payment Processing
            $order->status = 'Return Payment Processing';
            $order->save();
            //Reset Order Delivery and cod and ins
            $order_confirm = OrderConfirm::where('tracking_id', $id)->first();
            $order_confirm->cod = 0;
            $order_confirm->insurance = 0;
            // $order_confirm->delivery = 0;
            $order_confirm->save();

        }else{
            $tracking = BypassReturn::where('tracking_id', $id)->first();
            if($tracking){
                
                $data = new OrderStatusHistory();
                $data->tracking_id  = $id;
                $data->user_id      = Auth::user()->id;
                //$data->status       = 'In Collected Hub';
                $data->status       = 'Delivery  Cancel Approved by Fulfillment';
                $data->save();
    
                $tracking = BypassReturn::where('tracking_id', $id)->first();
                $order->status = 'Delivery  Cancel Approved by Fulfillment';
                $order->save();

                $order_confirm = OrderConfirm::where('tracking_id', $id)->first();
                $order_confirm->cod = 0;
                $order_confirm->insurance = 0;
                $order_confirm->delivery = 0;
                $order_confirm->save();

            }else{
                \Toastr::success('Something Went To Wrong', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                return redirect()->back();
            }

            

        }
        
        \Toastr::success('Cancel Approved By Fulfillment', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
        return redirect()->back();
    }

    public function reject($id)
    {
       
       
        $order = Order::where('tracking_id', $id)->first();
            
            if($order->status=='Order Cancel By Fullfilment'){
            // Order Cancel By Fullfilment
                $order->status = 'Received By Fullfilment';
                $order->save();

                \Toastr::success('Cancel Reject  By Fulfillment', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);


            }else{
                //Cancel From Branch
                $tracking = BypassReturn::where('tracking_id', $id)->first();
                if($tracking){
                
                    BypassReturn::where('tracking_id', $id)->delete();
                     
                    $order->status = 'Delivery Cancel Reject by Fulfillment';
                    $order->save();
    
                    \Toastr::success('Cancel Reject  By Fulfillment', 'Success!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                }else{
                    \Toastr::error('Something Went to wrong !', 'Error!!!', ["positionClass" => "toast-bottom-right", "progressBar" => true]);
                }
            }
       
       
        
        return redirect()->back();
    }
}
