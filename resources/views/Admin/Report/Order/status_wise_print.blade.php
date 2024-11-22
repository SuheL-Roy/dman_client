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
        <h4><u>Status Wise Order Report</u></h4>
        <h5>Status : {{ $status }}</h5>
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
                <th>Customer</th>
                <th>Mobile</th>
                <th>Collection</th>
                <th>Merchant Pay</th>
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
                <td>{{ $data->customer_name }}</td>
                <td>{{ $data->customer_phone }}</td>
                <td>{{ $data->collection }}</td>
                <td>{{ $data->merchant_pay }}</td>
            </tr>
            @endforeach
        </tbody>
        {{--  <tfoot>
            <tr>
                <td colspan="6" style="text-align:right;">Total : &nbsp;</td>
                <td> &nbsp; {{ $Paid }}</td>
                <td> &nbsp; {{ $Due }}</td>
                <td></td>
            </tr>
        </tfoot>  --}}
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