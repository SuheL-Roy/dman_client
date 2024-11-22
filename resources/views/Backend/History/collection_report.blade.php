<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style type="text/css">
        @media print {
            @page {
                size: auto;
            }
        }
    </style>

</head>

<body onload="window.print();">
    <br>

    {{--  <div class="container-1 mt-5" style="text-align: center; margin-top: 15px;">
        <img style="width:327px;height:126px;" src="{{ asset($company->logo) }}"> --}}

    <h1 style="text-align: center; margin-top: 15px;"class="mt-1">{{ $company->name }} </h1>
    <h4 style="text-align: center; margin-top: 15px;" class="mt-1">Address: {{ $company->address }} </h4>
    <h4 style="text-align: center; margin-top: 15px;">Mobile: {{ $company->mobile ?? 'NULL' }}</h4>
    {{-- <h4 style="text-align: center; margin-top: 15px;">Merchant invoice: {{ $invoice_ids ?? 'NULL' }}</h4> --}}
    @if (isset($merchant_name->business_name))
        <h4 style="text-align: center; margin-top: 15px;">Merchant name: {{ $merchant_name->business_name ?? 'NULL' }}
        </h4>
    @endif

    <h4 style="text-align: center; margin-top: 15px;">Date: {{ $fromdate ?? 'NULL' }} - {{ $todate ?? 'NULL' }}</h4>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>

                <th>Order Date</th>
                <th>Payment Date</th>
                <th>Tracking ID</th>
                <th>Name</th>
                <th>Phone</th>
                {{--  <th>Customer Address</th> --}}

                <th>Collect</th>
                <th>Delivery</th>
                <th>COD</th>
                {{--    <th>INS</th> --}}
                <th>Return</th>
                <th>Payable</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection_report as $key => $payment)
                <tr>

                    <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->order_create_date)->format('d-m-Y') }}
                    </td>
                    <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->payement_date)->format('d-m-Y') }}
                    </td>
                    <td> {{ $payment->tracking_id }} </td>
                    <td> {{ Str::limit($payment->customer_name, 11) }} </td>
                    <td> {{ $payment->customer_phone }} </td>
                    {{--  <td> {{ $payment->customer_address }} </td> --}}

                    <td> {{ $payment->collect }}</td>
                    <td> {{ $payment->delivery }}</td>
                    <td> {{ $payment->cod }} </td>
                    {{--   <td> {{ $payment->insurance }} </td> --}}
                    <td> {{ $payment->return_charge }}</td>
                    <td> {{ $payment->collect - ($payment->delivery + $payment->cod + $payment->insurance + $payment->return_charge) }}
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>


            <tr>
                <td colspan="4" style="text-align:right;">Total :
                </td>

                <td>
                    {{ $tcollect }}
                </td>
                <td>
                    {{ $tdelivery }}
                </td>
                <td>
                    {{ $tcod }}
                </td>
                <td>{{ $treturn }}</td>


            </tr>


        </tfoot>
    </table>

    {{-- <div class="row">
        <div style="margin-top: 20px">



            <div id="textbox">
                <div class="alignleft">
                    <div class="col-lg-6">
                        @if ($paymentInfo)
                            <h4 style="text-align: center; margin: 20px">Payment Method Info
                            </h4>
                            @if ($paymentInfo->p_type === 'Bank')
                                <div class="row "style="border: 1px solid black; margin-left:10px; padding: 10px;">

                                    <div class="col-lg-5 text-right">
                                        <b>
                                            <p>Bank Name : {{ $paymentInfo->bank_name }} </p>
                                            <p>Branch Name : {{ $paymentInfo->branch_name }} </p>
                                            <p>Account Holder Name : {{ $paymentInfo->account_holder_name }} </p>
                                            <p>Account Type : {{ $paymentInfo->account_type }} </p>
                                            <p>Account Number : {{ $paymentInfo->account_number }} </p>
                                            <p>Routing Number : {{ $paymentInfo->routing_number }} </p>
                                        </b>
                                    </div>

                                </div>
                            @else
                                <div class="row" style="border: 1px solid black; margin-left:10px; padding: 10px;">

                                    <div class="col-lg-5 text-right">
                                        <b>
                                            <p>Mobile Bank Name</p>
                                            <p>Mobile Bank Type</p>
                                            <p>Mobile Bank Number</p>
                                        </b>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <p>:</p>
                                        <p>:</p>
                                        <p>:</p>
                                    </div>
                                    <div class="col-lg-5 text-left">
                                        <p>{{ $paymentInfo->mb_name }}</p>
                                        <p>{{ $paymentInfo->mb_type }}</p>
                                        <p>{{ $paymentInfo->mb_number }}</p>
                                    </div>

                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="alignright">
                   
                    <h4 style="text-align: center; margin: 20px">Payment Adjustment Info
                    </h4>
                    <div class="row" style="border: 1px solid black; margin-right:10px; padding: 10px;">


                        <div class="col-lg-5 text-right">
                            <b>
                                <p> Merchant payable : {{ $tPayable }} ৳ </p>
                                <p>Previous Advanced : {{ $adjInfo->p_amount }} ৳ </p>
                                <hr style="margin-left:1px ">
                                <p>Total Merchant Pay : {{ $tPayable - $adjInfo->p_amount }} ৳ </p>

                            </b>
                        </div>

                      
                    </div>
                </div>
            </div>
        </div>


        <style>
            .alignleft {
                float: left;
            }

            .alignright {
                float: right;
            }
        </style>

    </div> --}}

</body>

</html>
