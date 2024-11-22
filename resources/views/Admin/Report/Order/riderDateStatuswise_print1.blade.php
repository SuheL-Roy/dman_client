
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
        <h4><u>Rider & Status Wise Report</u></h4>
        <h5>Rider : {{ $rider }} &nbsp;&nbsp; Status : {{ $status }}</h5>
        <h5>From Date : {{ $fromdate }} &nbsp;&nbsp; To Date : {{ $todate }}</h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th data-field="state" data-checkbox="true"></th>
                <th data-field="sl">SL.</th>
                <th data-field="sl">Tracking ID</th>
                {{-- <th data-field="rider" data-editable="false">Rider Name</th> --}}
                <th data-field="merchant_name" data-editable="false">Merchant Name</th>
                <th data-field="shop_name" data-editable="false">Merchant Phone</th>
                <th data-field="customer_name" data-editable="false">Customer Name</th>
                <th data-field="customer_phone" data-editable="false">Customer Phone</th>
                <th data-field="customer_address" data-editable="false">Customer Address</th>
                <th data-field="note" data-editable="false">Note</th>
                {{-- <th data-field="status" data-editable="false">Status</th> --}}
                <th data-field="invoice" data-editable="false">Invoice Value</th>
                <th data-field="camount" data-editable="false">Collected</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;?>
            @foreach ($orders as $key => $order)
            <tr>
                <td></td>
                <td>{{ $key + 1 }}.</td>
                <td>{{ $order->tracking_id }}</td>
                {{-- <td>{{$order->name}}</td> --}}
                <td>{{ $order->business_name }}</td>
                <td>{{ $order->merchant_phone }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_phone }}</td>
                <td>{{ $order->customer_address }}</td>
                <td>{{ $order->delivery_note ?? 'NULL' }}</td>
                {{-- <td>{{ $order->status }}</td> --}}
                <td>{{ $order->collection ?? '' }}</td>
                <td>{{ $order->collect }}</td>
            </tr>
            @endforeach
        </tbody>
        {{--  <tfoot>
            <tr>
                <td></td>
                <td colspan="6" style="text-align:right;">Total Order :</td>
                <td>{{ $Qty }}</td>
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