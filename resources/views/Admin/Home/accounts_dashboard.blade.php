@extends('Master.main')
@section('title')
    Accounts Dashboard
@endsection
@section('content')
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 40px; margin-right: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
            text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> 0 </span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Invoice Processing</b></p>
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
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">0</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Processing Amount</b></p>
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
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> 0
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Charge</b></p>
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
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"> 0
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b>Paid Amount</b></p>
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> 0 </span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Invoice Processing</b></p>
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
                                <h3><span class="counter" style="color: white; font-size: 30px">0</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b> Processing Amount </b></p>
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> 0
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b> Delivery Charge </b></p>
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
                                <h3><span class="counter" style="color: white; font-size: 30px"> 0
                                    </span></h3>
                                <p style="color: white;font-size: 20px"><b> Paid Amount </b></p>
                            </div>


                        </div>
                    </a>
                </div>



            </div>
        </div>
    </div>
@endsection
