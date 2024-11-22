@extends('Master.main')
@section('title')
    Manager Dashboard
@endsection
@section('content')
    <div class="text-center">
        <h1 class="">Today Report</h1>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 40px; margin-right: 10px">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.filtering') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
            text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
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
                    <a href="{{ route('order.report.filtering.pickup') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
            text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tPickupDone }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Today pickup</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.filtering.pickup.one') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
            text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
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
                    <a href="{{ route('order.report.filtering.pickup.regular') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round4)  ; position: relative;
            text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
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
                    <a href="{{ route('order.report.regular.delivery') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
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
                    <a href="{{ route('order.report.regular.delivery.one') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $urgentDelivery }}
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>One hour delivery</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.cancel.filtering') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $tOrdercancel }}
                                    </span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Order cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.pickup.filtering') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">
                                        {{ $pCl }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Pickup cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h1 class="">Total Report</h1>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $t_OrderPlaced }}
                                    </span>
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
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $t_PickupDone }}</span>
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $t_oneHourPickup }}
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $t_regularPickup }}
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $t_regularDelivery }}
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> {{ $t_urgentDelivery }}
                                    </span></h3>
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
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $t_tOrdercancel }}</span>
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
                                        {{ $t_Pickupcancel }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Pickup cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
