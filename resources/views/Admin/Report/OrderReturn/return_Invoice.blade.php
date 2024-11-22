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
<body onload="window.print();">
{{--  <body onload="window.print();window.history.back()">  --}}
    <div style="text-align:center;">
        @foreach ($company as $data)
            <h2>{{ $data->name }}</h2>
            <h4>Address : {{ $data->address }} &nbsp; Mobile : {{ $data->mobile }}</h4>
        @endforeach
        <h4><u>Order Return To Merchant Confirmation Report</u></h4>
        <h5>Merchant : @foreach ($order as $data){{ $data->merchant }}@break @endforeach
            &nbsp;&nbsp; 
            Phone : @foreach ($order as $data){{ $data->mobile }}@break @endforeach
        </h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Tracking ID</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Mobile</th>
                <th>Area</th>
                <th>Collection</th>
                <th>Return Charge</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;?>
            @foreach ($order as $data)
            <tr>
                <td>{{ $i++ }}.</td>
                <td>{{ $data->tracking_id }}</td>
                <td>{{ $data->order_id }}</td>
                <td>{{ $data->customer_name }}</td>
                <td>{{ $data->customer_phone }}</td>
                <td>{{ $data->area }}</td>
                <td>{{ $data->collection }}</td>
                <td>{{ $data->return_charge }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align:right;">Total : </td>
                {{-- <td>{{ $Total }}</td> --}}
                <td>{{ $Return }}</td>
            </tr>
        </tfoot>
    </table>
    <br><br><br>
    <div class="container">
        <div style="float:left; border-top:1px dashed black; padding-left:5px; padding-right:5px;">
            Authorized Sign
        </div>
        <div style="float:right; border-top:1px dashed black; padding-left:5px; padding-right:5px;">
            Merchant Sign
        </div>
    </div>
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