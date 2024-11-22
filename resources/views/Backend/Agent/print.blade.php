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

    <div class="container-1 mt-5" style="text-align: center; margin-top: 15px;">
        <img style="width:327px;height:126px;" src="{{ asset($company->logo) }}">
        <h4 class="mt-1">Address: {{ $company->address }} </h4>
        <h4>Mobile: {{ $company->mobile ?? 'NULL' }}</h4>

        {{-- <h4>Merchant Return Orders: ({{ $invid }})</h4> --}}
    </div>

    <h5 style="text-align: center; margin-top: 80px"><u> Hub Payment Collect Details</u></h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Tracking</th>
                <th>Merchant Name</th>
                <th>Merchant Phone</th>
                <th>Merchant Address</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Type</th>
                <th>Status</th>
                <th>Collection</th>
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
            <td colspan="9"></td>
            <td><b style="font-size: 20px">Total Collection</b></td>
            <td><b style="font-size: 20px">{{ $total }} ৳‎</b></td>
        </tfoot>
    </table>

</body>

</html>
