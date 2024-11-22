@extends('Master.main')
@section('title')
    Super Admin Dashboard
@endsection
@section('content')
    <br></br><br>


    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div style="margin-left: 20%;margin-right:20%; margin-bottom: 2%" class="row">

                <a href="{{ route('admin.panel.super.dashboard') }}" class="btn btn-info btn-block "
                    style="background: rgb(194, 194, 194);height: 2.8rem;  width: 50%;  border-radius: 40px 0px 0px 40px;border: none;
                        margin: 0px 15px;font-size: 20px; float:left; color: black">

                    <b> Today</b>
                </a>

                <a href="{{ route('admin.panel.super.dashboard.total') }}" class="btn btn-primary btn-block"
                    style="height: 2.8rem;background:  rgb(124, 16, 124);    border-radius: 0px 40px 40px 0px ;border: none;
                                margin: 0px -15px;font-size: 20px; width: 50%; float:right; color: rgb(255, 255, 255)">
                    <b><u>Total</u></b>
                </a>
            </div>
            <div class="row" style="margin-left: 40px; margin-right: 10px">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.filteringt') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $tOrderPlaced }} </span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>New order</b></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.filtering.pickupt') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tPickupDone }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Total pickup</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.filtering.pickup.onet') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $oneHourPickup }}
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>One hour pickup</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.filtering.pickup.regulart') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $regularPickup }}
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>Regular pickup</b></p>
                            </div>


                        </div>
                    </a>
                </div>



            </div>
        </div>
    </div>


    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 40px; margin-right: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.regular.deliveryt') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $regularDelivery }}
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>Regular delivery</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.regular.delivery.onet') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $urgentDelivery }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>One hour delivery</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.cancel.filteringt') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tOrdercancel }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Order cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.pickup.filteringt') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">
                                        {{ $tPickupcancel }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Pickup cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 40px; margin-right: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">0</span></h3>
                                <p style="color: white;font-size: 20px"><b>Delivery charge</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $tPickupAmount }}
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Amount</b></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.return.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $orderCancelAmount }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Cancel Amount</b></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.collected') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $tPaidAmount }}
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>Paid amount</b></p>
                            </div>


                        </div>
                    </a>
                </div>



            </div>
        </div>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 40px; margin-right: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">0</span></h3>
                                <p style="color: white;font-size: 20px"><b>Due amount</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">0</span></h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Return</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.return.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">0</span></h3>
                                <p style="color: white;font-size: 20px"><b>Hold & Reschedule</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.collected') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">0</span></h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Amount</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:#cc9916; position: relative;
                text-align:center; ">

                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>
                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_delivery_success_ratio }}%</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Successfully Delivery Ratio</b></p>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:#2ba151; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_delivery_unsuccess_ratio }}%</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Pandding Delivery Ratio</b></p>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:#bf3737; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">

                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_merchant_payment_processing }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Total Payment Processing</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:#b716cc; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_paid_amount }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Total Paid Amount</b></p>
                            </div>


                        </div>
                    </a>
                </div>


            </div>
        </div>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 40px; margin-right: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('pickup_request_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_pickup_request }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('payment_request_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_payment_request }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Payment Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>



            </div>
        </div>
    </div>

    <br></br><br><br></br><br>
@endsection
