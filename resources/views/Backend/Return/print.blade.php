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

         <h4>Merchant Return Orders: ({{ $invid }})</h4> 
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Merchant Name</th>
                <th>Merchant Phone</th>
                <th>Merchant Address</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Customer Adderess</th>
                <th>Rider Name</th>
                <th>Create By</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> {{ $payments_data->created_at->format('d-m-Y') }} </td>
                <td> {{ $payments_data->invoice_id }} </td>
                <td> {{ $payments_data->business_name }} </td>
                <td> {{ $payments_data->mobile }} </td>
                <td> {{ $payments_data->address }} </td>
                <td> {{ $payments_data->customer_name }} </td>
                <td> {{ $payments_data->customer_phone }} </td>
                <td> {{ $payments_data->customer_address }} </td>
                <td> {{ $payments_data->rider->name }} </td>
                <td> {{ $payments_data->creator->name }} </td>
                <td> {{ $payments_data->status }} </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
