@extends('Master.main')
@section('title')
    Rider Dashboard
@endsection
@section('content')
    {{-- <div class="dashtwo-order-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="{{ route('rider.dashboard') }}" method="get">
                    @csrf
                        <div class="col-lg-2">
                        </div>
                        <button class="col-lg-2 btn btn-success btn-sm" type="submit" 
                            style="float:right; font-weight:bold; font-size:14px;">Load
                        </button>
                        <div class="col-lg-4 form-inline">
                            <label>From Date : </label> &nbsp;
                            <input type="date" class="form-control" name="fromdate" 
                                placeholder="From Date" value="{{ $fromdate }}" required/>
                        </div>
                        <div class="col-lg-4 form-inline">
                            <label>To Date : </label> &nbsp;
                            <input type="date" class="form-control" name="todate" 
                                placeholder="To Date" value="{{ $todate }}" required/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="dashtwo-order-area mt-4">
        <div class="container-fluid">
            <div class="row" style="margin-left: 10px">


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round1) ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $today_pickup }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('delivery.assign.list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $today_delivery }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.return.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $today_return }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Return Request</b></p>
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
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $today_transfer }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Transfer Request</b></p>
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
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round1) ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $total_pickup }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Pickup Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.delivery.confirm') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_delivery }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Delivery Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.return.datewise') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $total_return }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Return Request</b></p>
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
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_transfer }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Transfer Request</b></p>
                            </div>


                        </div>
                    </a>
                </div>


                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $total_pickup_Collect_ratio }}%</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>PickUp Collect Ratio</b></p>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $total_delivery_success_ratio }}%</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Success Delivery Ratio</b></p>
                            </div>


                        </div>
                    </a>
                </div>


                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.rider.today.delivered') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Today</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px">{{ $today_delivered }}</span>
                                </h3>
                                <p style="color: white;font-size: 20px"><b>Delivery</b></p>
                            </div>


                        </div>
                    </a>
                </div>


                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.report.rider.monthly.delivered') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div style="text-align: left">
                                <p style="color: white; text-align: left"><b>Month</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter"
                                        style="color: white; font-size: 30px">{{ $monthly_delivered }}</span></h3>
                                <p style="color: white;font-size: 20px"><b>Delivery</b></p>
                            </div>


                        </div>
                    </a>
                </div>



            </div>
        </div>
    </div>
    </div>
    {{-- <div class="dashtwo-order-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('request.assign.list') }}">
                    <div class="income-dashone-total reso-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">0 </span></h3>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p style="color: blue;">PickUp Request</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('order.report.collected') }}">
                    <div class="income-dashone-total reso-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter"> 0</span></h3>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p style="color: green;">PickUp Collect</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('order.report.pickup_cancel') }}">
                    <div class="income-dashone-total reso-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter"> 0</span></h3>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p style="color: red;">PickUp Cancel</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('delivery.assign.list') }}">
                    <div class="income-dashone-total reso-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter"> 0</span></h3>
                                </div>
                            </div>
                            <div class="income-range">
                                <p style="color: blue;">Delivery Request</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('order.report.delivered') }}">
                    <div class="income-dashone-total reso-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">0 </span></h3>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p style="color: green;">Delivery Complete</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('order.report.pending') }}">
                    <div class="income-dashone-total reso-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">0 </span></h3>
                                </div>
                            </div>
                            <div class="income-range visitor-cl">
                                <p style="color: orange;">Delivery Pending</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="income-order-visit-user-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">

                {{--  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="income-dashone-total reso-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter"> 0%</span></h3>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p style="color: green;">PickUp Collect Percentage</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>  --}}
                {{--  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="income-dashone-total res-mg-b-30">
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">0 %</span></h3>
                                </div>
                            </div>
                            <div class="income-range low-value-cl">
                                <p style="color: blue;">Order Delivery Percentage</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>  --}}

            </div>
        </div>
    </div>
@endsection
