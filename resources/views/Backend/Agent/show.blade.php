@extends('Master.main')
@section('title')
    Merchant Payment History Report Date Wise
@endsection
@section('content')
    <div class="container" style="background-color:#f5f5f5;">

        <div class="row">
            <div class="col-12 offset-1">
                <div class="container-1 mt-5" style="text-align: center; margin-top: 15px;">
                    <img style="width:327px;height:126px;" src="{{ asset($company->logo) }}">
                    <h4 class="mt-1">Address: {{ $company->address }} </h4>
                    <h4>Mobile: {{ $company->mobile ?? 'NULL' }}</h4>
                    <h5 class="mt-5">Hub: {{ $agent->agent->name }},Mobile: {{ $agent->agent->mobile }}</h5>
                    <h5 class="mt-1">Address: {{ $agent->agent->address }}</h5>
                    <div style="text-align: right">
                        <a class="btn btn-sm btn-primary" href="{{ route('agent.collect.print', $agent->id) }}"
                            target="_blank" class=""><span style="font-size: 16px">print</span></a>
                    </div>

                </div>
                <div>

                    <h5 style="text-align: center; margin-top: 80px"><u> Hub Payment Collect Details</u></h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Date</th>
                                <th scope="col">Tracking</th>
                                <th scope="col">Merchant Name</th>
                                <th scope="col">Merchant Phone</th>
                                <th scope="col">Merchant Address</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Phone</th>
                                <th scope="col">Status</th>
                                <th scope="col">Collection</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentDetails as $key => $payment)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $payment->tracking_id }}</td>
                                    <td>{{ $payment->merchant_name }}</td>
                                    <td>{{ $payment->mobile }}</td>
                                    <td>{{ $payment->address }}</td>
                                    <td>{{ $payment->customer_name }}</td>
                                    <td>{{ $payment->customer_phone }}</td>
                                    <td>{{ $payment->type == 'Urgent' ? 'One Hour' : 'Regular' }}</td>
                                    <td>{{ $payment->order_status }}</td>
                                    <td>{{ $payment->collect }} ৳‎</td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b style="font-size: 20px">Total Collection</b></td>
                            <td><b style="font-size: 20px">{{ $total }} ৳‎</b></td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
