<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/bootstrap.min.css">
    <style type="text/css">
        @media print {
            @page {
                size: auto;
            }
        }
    </style>

</head>

<body onload="window.print();window.history.back()">
    <div style="text-align:center;">
        @foreach ($company as $data)
            <h2>{{ $data->name }}</h2>
            <h4>Address : {{ $data->address }} &nbsp; Mobile : {{ $data->mobile }}</h4>
        @endforeach
        <h4><u>Order History Report</u></h4>
        <h5> Status : {{ $orderStatus ?? 'NULL' }}</h5>
        <h5>From Date : {{ $fromdate }} &nbsp;&nbsp; To Date : {{ $todate }}</h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Tracking ID</th>
                {{-- <th>S. Name</th>
                <th>S. Address</th> --}}
                <th>Customer Name</th>
                <th>Customer Mobile</th>
                <th>Address</th>
                <th>Destination</th>
                <th>Invoice Value</th>
                <th>Collected Amount</th>
                <th>Remarks</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($order as $key => $data)
                <tr>
                    <td><b>{{ $key + 1 }}.</b></td>
                    <td>{{ $data->tracking_id }}
                    </td>
                    <td><b>{{ $data->customer_name }}</b></td>
                    <td><b>{{ $data->customer_phone }}</b></td>
                    <td><b>{{ $data->customer_address }}</b></td>
                    <td><b>{{ $data->area }}</b></td>
                    <td><b>{{ $data->collection }}</b></td>
                    <td><b>{{ $data->collect }}</b></td>
                    <td><b>({{ $data->delivery_date }} ){{ $data->delivery_note }}</b>
                    </td>
                    <td><b>{{ $data->status }}</b></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align:right; font-weight:bold;">Total :</td>
                <td style="font-weight:bold;">{{ $total_collection }}</td>
                <td style="font-weight:bold;">{{ $total_collect }}</td>
                <td></td>
               
            </tr>
        </tfoot>
    </table>
    <div class="navbar-fixed-bottom">
        <div style="float:left;">
            @foreach ($company as $data)
                Printed By : {{ $data->name }}
            @endforeach
        </div>
        <div style="float:right;">
            <?php echo 'Date & Time : ' . date('D, d M Y h:i:s a'); ?>
        </div>
    </div>
</body>

</html>
