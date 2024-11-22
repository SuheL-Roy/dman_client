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
        <h4><u>Merchant & Status Wise Order Report</u></h4>
        <h5>Merchant : {{ $merchant }} &nbsp;&nbsp; Status : {{ $status }}</h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Tracking ID</th>
                <th>S.Name</th>
                <th>S. Address</th>
                <th>C. Name</th>
                <th>C. Mobile</th>
                <th>Destination</th>
                <th>C. Address</th>
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
                    <td>{{ $key + 1 }}.</td>
                    <td>{{ $data->tracking_id }}</td>
                    <td>{{ $data->shop }}</td>
                    <td>{{ $data->shop_address }}</td>
                    <td>{{ $data->customer_name }}</td>
                    <td>{{ $data->customer_phone }}</td>
                    <td>{{ $data->customer_phone }}</td>
                    <td>{{ $data->customer_address }}</td>
                    <td>{{ $data->collection }}</td>
                    <td>{{ $data->collect }}</td>
                    <td>{{ $data->remarks ?? 'Null' }}</td>
                    <td>{{ $data->status }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td colspan="10">Total Order :</td>
                <td>{{ $Qty }}</td>
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
