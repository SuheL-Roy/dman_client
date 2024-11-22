<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/bootstrap.min.css">
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
        <h4><u>Payment Collected Report</u></h4>
        <h5>From Date : {{ $fromdate }} &nbsp;&nbsp; To Date : {{ $todate }}</h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Date</th>
                <th>Tracking ID</th>
                <th>Order ID</th>
                @can('activeAccounts')
                <th>Agent</th>
                <th>Phone</th>
                @endcan
                <th>Customer</th>
                <th>Mobile</th>
                <th>Area</th>
                <th>Collection</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;?>
            @foreach ($order as $data)
            <tr>
                <td>{{ $i++ }}.</td>
                <td>{{ $data->date }}</td>
                <td>{{ $data->tracking_id }}</td>
                <td>{{ $data->order_id }}</td>
                @can('activeAccounts')
                <td>{{ $data->agent }}</td>
                <td>{{ $data->phone }}</td>
                @endcan
                <td>{{ $data->customer_name }}</td>
                <td>{{ $data->customer_phone }}</td>
                <td>{{ $data->area }}</td>
                <td>{{ $data->collection }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                @can('activeAccounts')
                <td></td>
                <td></td>
                @endcan
                <td colspan="7" style="text-align:right;">Total Order :</td>
                <td>{{ $Total }}</td>
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
            <?php echo "Date & Time : " . date("D, d M Y h:i:s a"); ?>
        </div>
    </div>
</body>
</html>