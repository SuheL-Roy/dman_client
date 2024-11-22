<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Responsive Timeline Design</title>
    <meta name="viewport" content="width=device-width,  user-scalable=no">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Amiri';
            font-size: 14px;
        }

        @media print {
            @page {
                size: auto;
            }
        }
    </style>
</head>


<body style="background-color:#f5f5f5;" onload="window.print();">

    <div class="container1" style="background-color:#f5f5f5;">
        <div class="row">
            <div>
                <div class="container-1 mt-5" style="text-align: center; margin-top: 15px;">
                    <img style="width:600px;height:126px;" src="{{ asset($company->logo) }}">
                    <h4 class="mt-1">Address: {{ $company->address }} </h4>
                    <h4>Mobile: {{ $company->mobile ?? 'NULL' }}</h4>


                </div>
                <div>

                    {{-- <h5 style="text-align: center; margin-top: 80px"><u> Agent Payment Collect Details</u></h5> --}}
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Tracking ID</th>
                                <th>Rider Name</th>
                                <th>Merchant Name</th>
                                <th>Merchant Phone</th>

                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Customer Address</th>
                                <th>Destination</th>

                                <th>Status</th>

                                <th>Collection</th>
                                <th>Collected</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ $order->tracking_id }}</td>
                                    <td>{{ $rider->name }}</td>
                                    <td>{{ $order->business_name }}</td>
                                    <td>{{ $order->shop }}</td>


                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_phone }}</td>
                                    <td>{{ $order->customer_address }}</td>
                                    <td>{{ $order->area }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->collection }}</td>
                                    <td>{{ $order->collect ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11" style="text-align:right; "><b>Total Collected Amount:</b>
                                    &nbsp;</td>
                                <td style="font-weight: 800"> &nbsp;&nbsp; {{ $total }}</td>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
