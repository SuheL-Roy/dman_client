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
    {{--  <body onload="window.print();window.history.back()">  --}}
    <body onload="window.print();" style="width: 10%">
        <div style="text-align:center;">
            @foreach ($company as $data)
                <b style="font-size: 12px;">{{ $data->name }}</b><br>
                <p style="font-size: 8px;">{{ $data->address }} </p>
                <b style="font-size: 10px; margin: 0px; line-height: 0">{{ $data->mobile }}</b>
            @endforeach
        </div>
        <br>
        <p style="font-size: 8px; margin: 0 0 2px;"><b>Merchant:</b> {{ $datas->merchant }} </p>
        <p style="font-size: 8px; margin: 0 0 2px;"><b>Phone:</b> {{ $datas->merchant_no }} </p>
        <p style="font-size: 8px; margin: 0 0 2px;"><b>Customer:</b> {{ $datas->customer_name }} </p>
        <p style="font-size: 8px; margin: 0 0 2px;"><b>Phone:</b> {{ $datas->customer_phone }} </p>
        
        <br>
            
        <ul style="padding-inline-start: 15px;">
            <li style="font-size: 8px;"><b>Tracking ID:</b>{{ $datas->tracking_id }}</li>
            <li style="font-size: 8px;"><b>Date:</b>{{ $datas->pickup_date }}</li>
            <li style="font-size: 8px;"><b>Weight:</b>{{ $datas->weight }}</li>
            <li style="font-size: 8px;"><b>Collection:</b>{{ $datas->collection }}Tk.</li>
        </ul>
            
        <br><br><br>
        <div>
            <div style="float:left;">
                @foreach ($company as $data)
                    <p style="font-size: 8px; margin: 0 0 2px;"><b>Printed By :</b> Delivery Rx</p> 
                @endforeach

                <p style="font-size: 8px; margin: 0 0 2px;"><?php echo "<b>Date & Time :</b>" . date("D, d M Y h:i:s a"); ?></p>
                
            </div>
        </div>
    </body>
</html>