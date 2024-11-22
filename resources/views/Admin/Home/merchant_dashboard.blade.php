@extends('Master.main')
@section('title')
    Merchant Dashboard
@endsection
@section('content')
    <style>
        .alignleft {
            float: left;
        }

        .alignright {
            float: right;
        }
    </style>
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
    <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pickup_request') }}" method="POST">
                    @csrf
                    <div class="modal-close-area modal-close-df">
                        <a class="close" data-dismiss="modal" href="#">
                            <i class="fa fa-close"></i></a>
                    </div>
                    <div class="modal-header header-color-modal bg-color-1">
                        <h4 class="modal-title">PickUp Request</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        PickUp Address <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="pick_up_address" class="form-control pick-up"
                                        placeholder="Pick up Address" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        Note <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="Note" class="form-control" placeholder="note" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        Estimated Parcel (Optional) <span class="table-project-n"></span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="estimated_parcel" class="form-control"
                                        placeholder="Estimated Percel" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning btn-sm" type="button"data-dismiss="modal">Close</button>
                        <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                        <button class="btn btn-success btn-sm" type="submit">Send Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="PrimaryModalalert12" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('payment_request') }}" method="POST">
                    @csrf
                    <div class="modal-close-area modal-close-df">
                        <a class="close" data-dismiss="modal" href="#">
                            <i class="fa fa-close"></i></a>
                    </div>
                    <div class="modal-header header-color-modal bg-color-1">
                        <h4 class="modal-title"> Payment Request</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        Current Payment method <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <select name="payment_method" class="form-control" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Bkash">Bkash</option>
                                        <option value="Rocket">Rocket</option>
                                        <option value="Nagad">Nagad</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning btn-sm" type="button"data-dismiss="modal">Close</button>
                        <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                        <button class="btn btn-success btn-sm" type="submit">Send Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="dashtwo-order-area ">
        <div class="container-fluid">
            <div class="row" style="margin-left: 10px">


                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('merchent.pay.information.index') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                    text-align:center; ">

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"></span></h3>
                                <a href="{{ route('order.backup_create') }}">
                                    <p style="color: white;font-size: 30px"><b>Create Order</b></p>
                                </a>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round2)  ; position: relative;
                    text-align:center; ">

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"></span></h3>

                                <a href="#" value="{{ auth()->user()->id }}" class="ediT" data-toggle="modal"
                                    data-target="#PrimaryModalalert">
                                    <p style="color: white;font-size: 30px"><b>PickUp Request</b></p>
                                </a>


                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('merchent.pay.information.index') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round1)  ; position: relative;
                    text-align:center; ">

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"></span></h3>
                                <a href="" data-toggle="modal" data-target="#PrimaryModalalert12">
                                    <p style="color: white;font-size: 30px"><b>Payment Request</b></p>
                                </a>

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
                    <a href="{{ route('order.create_order_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                    text-align:center; ">
                            <div id="textbox">
                                <p class="alignleft" style="color: white; text-align: left"><b>Today</b></p>
                                <p class="alignright" style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter" style="color: white; font-size: 30px;"> {{ $today_order }}
                                    </span>
                                    -
                                    <span class="counter" style="color: white; font-size: 30px"> {{ $total_order }}
                                    </span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Order</b></h3>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.success_order_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div id="textbox">
                                <p class="alignleft" style="color: white; text-align: left"><b>Today</b></p>
                                <p class="alignright" style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter"
                                        style="color: white; font-size: 30px;">{{ $today_dalivery }}</span>
                                    -
                                    <span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_dalivery }}</span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Delivery</b></h3>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.return_order_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div id="textbox">
                                <p class="alignleft" style="color: white; text-align: left"><b>Today</b></p>
                                <p class="alignright" style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter"
                                        style="color: white; font-size: 30px;">{{ $today_return }}</span>
                                    -
                                    <span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_return }}</span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Return</b></h3>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.transit_order_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round4)  ; position: relative;
                    text-align:center; ">
                            <div id="textbox">
                                <p class="alignleft" style="color: white; text-align: left"><b>Today</b></p>
                                <p class="alignright" style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter"
                                        style="color: white; font-size: 30px;">{{ $todayorderTransit }}</span>
                                    <span style="color: #fff">-</span>
                                    <span class="counter"
                                        style="color: white; font-size: 30px">{{ $totalorderTransit }}</span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Transit</b></h3>
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


                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.delivery_amount_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:  var(--round1); position: relative;
                    text-align:center; ">
                            <div id="textbox">
                                <p class="alignleft" style="color: white; text-align: left"><b>Today</b></p>
                                <p class="alignright" style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter" style="color: white; font-size: 30px;">
                                        {{ $today_dalivery_amount }} </span>
                                    -
                                    <span class="counter" style="color: white; font-size: 30px">
                                        {{ $total_dalivery_amount }}
                                    </span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Delivery Amount</b></h3>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.payment_processing_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round2)  ; position: relative;
                    text-align:center; ">
                            <div id="textbox">
                                <p class="alignleft" style="color: white; text-align: left"><b>Today</b></p>
                                <p class="alignright" style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter"
                                        style="color: white; font-size: 30px;">{{ $today_paymentProcessing }}</span>
                                    -
                                    <span class="counter" style="color: white; font-size: 30px">
                                        {{ $total_paymentProcessing }} </span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Payment Processing</b></h3>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 mg-tb-15">
                    <a href="{{ route('order.paid_amount_list') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:var(--round3)  ; position: relative;
                    text-align:center; ">
                            <div id="textbox">
                                <p class="alignleft" style="color: white; text-align: left"><b>Today</b></p>
                                <p class="alignright" style="color: white; text-align: left"><b>Total</b></p>
                            </div>

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter"
                                        style="color: white; font-size: 30px;">{{ $today_paymentComplete }}</span>
                                    -
                                    <span class="counter"
                                        style="color: white; font-size: 30px">{{ $total_paymentComplete }}</span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Paid Amount</b></h3>
                            </div>


                        </div>
                    </a>
                </div>
                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:#22bb33; position: relative;
                    text-align:center; ">

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter"
                                        style="color: white; font-size: 30px;">{{ $total_delivery_success_ratio }}%</span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Total Successfully Delivery Ratio</b></h3>
                            </div>


                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 mg-tb-15">
                    <a href="">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background:#bf3737; position: relative;
                    text-align:center; ">

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3>
                                    <br>
                                    <span class="counter"
                                        style="color: white; font-size: 30px;">{{ $total_delivery_unsuccess_ratio }}%</span>
                                </h3>
                                <h3 style="color: white;font-size: 20px"><b>Total Unsuccessfully Delivery Ratio</b></h3>
                            </div>


                        </div>
                    </a>
                </div> --}}
                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 mg-tb-15">
                    <a href="{{ route('merchent.pay.information.index') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                    text-align:center; ">

                          

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                                <h3><span class="counter" style="color: white; font-size: 30px"></span></h3>
                                <a href="{{ route('order.create') }}">
                                    <p style="color: white;font-size: 30px"><b>Create Order</b></p>
                                </a>
                            </div>


                        </div>
                    </a>
                </div> --}}



            </div>
        </div>
    </div>
    <div class="dashtwo-order-area ">
        {{-- <div class="container-fluid">
            <div class="row" style="margin-left: 10px">



                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-0 mg-tb-15">


                </div>

                <div class="col-lg-8 col-md-3 col-sm-3 col-xs-6 mg-tb-15">
                    <a href="{{ route('merchent.pay.information.index') }}">
                        <div
                            style=" border-radius: 10px; padding: 20px;  background: var(--round3)  ; position: relative;
                    text-align:center; ">

                           

                            <div style="text-align: center;width: 100%;height: 100%; margin: 0 auto; ">
                               
                                <a href="{{ route('order.create') }}">
                                    <p style="color: white;font-size: 20px"><b>Create Order</b></p>
                                </a>
                            </div>


                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-md-1 col-sm-1 col-xs-0 mg-tb-15">


                </div>

            </div>
        </div> --}}
    </div>

    <br><br><br><br>



    <script>
        $(document).ready(function() {

            $('.ediT').on('click', function() {

                $.ajax({
                    type: "GET",
                    url: "{{ route('pickup_address') }}",
                    success: function(data) {
                        $('.pick-up').val(data[0]['address']);

                    }
                });

            });
        });
    </script>
@endsection
