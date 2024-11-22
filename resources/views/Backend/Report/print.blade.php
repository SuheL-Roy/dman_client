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

    <div class="container-1 mt-1" style="text-align: center; margin-top: 0px;">
        {{--   <img style="width:327px;height:126px;" src="{{ asset($company->logo) }}"> --}}
        <h1 class="mt-1">{{ $company->name }} </h1>
        <h4 class="mt-1">{{ $company->address }} </h4>
        <h4>Mobile: {{ $company->mobile ?? 'NULL' }}</h4>

        <h4>Merchant Return Orders: ({{ $invid }})</h4>
        <h4>Merchant Name:{{ $returnasigns_name->business_name }} </h4>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Tracking</th>
                {{--    <th>Merchant Name</th>
                <th>Merchant Phone</th>
                <th>Merchant Address</th> --}}
                <th>Customer Name</th>
                <th>Customer Phone</th>
                {{-- <th>Customer Adderess</th>
                <th>Delivery Note</th> --}}
                <th>Return Reason</th>
                <th>Invoice Value</th>
                <th>Collected</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($returnasigns as $key => $rasign)
                <tr>
                    <td> {{ $key + 1 }} </td>
                    <td> {{ $rasign->tracking_id }} </td>
                    {{--   <td> {{ $rasign->business_name }} </td>
                    <td> {{ $rasign->mobile }} </td>
                    <td> {{ $rasign->address }} </td> --}}
                    <td> {{ $rasign->customer_name }} </td>
                    <td> {{ $rasign->customer_phone }} </td>
                    {{-- <td> {{ $rasign->customer_address }} </td>
                    <td> {{ $rasign->delivery_note }} </td> --}}
                    <td>{{ $rasign->reason_name }}</td>
                    <td> {{ $rasign->collection }} </td>
                    <td> {{ $rasign->collect }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
