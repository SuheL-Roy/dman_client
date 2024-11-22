@extends('Master.main')
@section('title')
    HUB Dashboard
@endsection
@section('content')
    <br></br><br>


    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 40px; margin-right: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('request.assign.request_pickup') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tPickupReq }}</span>

                                </h3>
                                <p style="color: white;font-size: 20px"><b>Pickup List</b></p>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('pickup_request_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_pick_request }}</span>

                                </h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round2)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tDeliveryReq }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.return.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round2)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tReturnReq }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Return Request</b></p>
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
                    <a href="{{ route('order.report.collected') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tPickupCancel }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Cancel</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tPickupDone }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Complete</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round2)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tDeliveryDone }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Complete</b></p>
                            </div>


                        </div>  
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.return.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tReturned }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Return Confirm</b></p>
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


                {{-- 
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-0 mg-tb-15">
                    <a href="{{ route('order.report.agent.transaction.report') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)   ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tRiderCollect }}
                                        TK</span></h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Request</b></p>
                            </div>


                        </div>
                    </a>

                </div> --}}
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.collected') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $tHoldRescheduled }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Rescheduled</b></p>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.agent.transaction.report') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round2)   ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tRiderCollect }}
                                        TK</span></h3>
                                <p style="color: white;font-size: 20px"><b>Rider Collect</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.collected') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $tPaymentProcessing }}
                                        TK</span></h3>
                                <p style="color: white;font-size: 20px"><b>Payment Processing</b></p>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-0 mg-tb-15">


                </div>

            </div>
        </div>
        <div style="height: 100px"></div>
    </div>
@endsection
