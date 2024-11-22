@extends('Master.main')
@section('title')
    Merchant Dashboard
@endsection
@section('content')
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="{{ route('shop.merchant.dashboard') }}" method="get">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $t_dalivery }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Complete</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $t_cancel }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>PickUp Cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $t_return }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Return</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $t_hold_reschedule }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Hold & reschedule</b></p>
                            </div>


                        </div>
                    </a>
                </div>



            </div>
        </div>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $to_dalivery }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Complete</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $to_cancel }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>PickUp Cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $to_return }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Return</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $to_hold_reschedule }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Hold & reschedule</b></p>
                            </div>


                        </div>
                    </a>
                </div>



            </div>
        </div>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 10px">



                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-0 mg-tb-15">


                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('merchent.pay.information.index') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $paymentProcessing }}
                                        TK</span></h3>
                                <p style="color: white;font-size: 20px"><b>Payment Processing</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('merchent.pay.information.index') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $paymentComplete }}
                                        TK</span></h3>
                                <p style="color: white;font-size: 20px"><b>Payment Received</b></p>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-0 mg-tb-15">


                </div>

            </div>
        </div>
    </div>

    <br><br><br><br>
@endsection
