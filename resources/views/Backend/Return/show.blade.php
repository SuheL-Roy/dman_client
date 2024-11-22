@extends('Master.main')
@section('title')
    Merchant Payment
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <h1>Return Asign Show</h1>
                        <div class="text-center">
                            {{-- <a target="_blank" href="{{ route('order.report.admin.rider.return.print', $payments_data->id) }}"
                                class="btn btn-info btn-xs">
                                <i class="fa fa-print"></i>
                            </a> --}}
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Tracking</th>
                                            <th>Merchant Name</th>
                                            <th>Merchant Phone</th>
                                            <th>Weight</th>
                                            <th>Category</th>
                                            <th>Delivery Note</th>
                                            <th>Delivery Date</th>
                                            <th>Invoice Value</th>
                                            <th>Collected Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments_data as $payment)
                                            <tr>
                                                <td> {{ $payment->created_at->format('d-m-Y') }} </td>
                                                <td> {{ $payment->tracking_id }} </td>
                                                <td> {{ $payment->business_name }} </td>
                                                <td> {{ $payment->mobile }} </td>
                                                <td> {{ $payment->weight }} </td>
                                                <td> {{ $payment->category }} </td>
                                                <td> {{ $payment->delivery_note }} </td>
                                                <td> {{ $payment->delivery_date }} </td>
                                                <td> {{ $payment->collection }} </td>
                                                <td> {{ $payment->collect }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
