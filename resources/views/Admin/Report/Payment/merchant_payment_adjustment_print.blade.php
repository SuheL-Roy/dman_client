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
        <h4><u>Payment Adjustment Report Merchant Wise</u></h4>
        <h5>Merchant : {{ $merchant }} &nbsp;&nbsp; Phone : {{ $phone }}</h5>
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
                <th>Collection</th>
                <th>Merchant Pay</th>
                <th>Return Charge</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;?>
            @foreach ($complete as $data)
            <tr>
                <td>{{ $i++ }}.</td>
                <td>{{ $data->date }}</td>
                <td>{{ $data->tracking_id }}</td>
                <td>{{ $data->order_id }}</td>
                <td>{{ $data->collection }}</td>
                <td>{{ $data->merchant_pay }}</td>
                <td></td>
            </tr>
            @endforeach
            @foreach ($return as $data)
            <tr>
                <td>{{ $i++ }}.</td>
                <td>{{ $data->date }}</td>
                <td>{{ $data->tracking_id }}</td>
                <td>{{ $data->order_id }}</td>
                <td></td>
                <td></td>
                <td>{{ $data->return_charge }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">Total :</td>
                <td>{{ $tCol }}</td>
                <td>{{ $tMPay }}</td>
                <td>{{ $tRc }}</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:right;">Payable Amount :</td>
                <td>{{ $tAmt }}</td>
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