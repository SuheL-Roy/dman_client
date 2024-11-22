<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/bootstrap.min.css">

    <link href='https://fonts.googleapis.com/css?family=Amiri' rel='stylesheet'>
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

<body onload="window.print()">
    <br />
    <div style="margin-left:10px;width:450px;">
        <div style=" border: 1px solid black;width:450px;">
            <h1 style="text-align: center"> Delivery</h1>


            <p style="float:left;padding-left:10px;font-weight:bold;padding-top:10px;
      ">MERCHANT:</p>
            <p style="padding-left:100px;font-weight:bold;padding-top:10px;">{{ $merchant_name }}</p>
            <p style="padding-left:100px;">{{ $merchant_data->address }}</p>
            <p style="padding-left:100px;">{{ $merchant_data->mobile }}</p>


        </div>
        <div style="border-left: 1px solid black;border-right: 1px solid black;width:450px;height:120px;">


            <p style="float:left;padding-left:5px;font-weight:bold;padding-top:10px;">CUSTOMER:</p>
            <p style="padding-left:15px;float:left;padding-right:200px;font-weight:bold;padding-top:10px;">
                {{ $order_data->customer_name }}</p>
            <p style="font-weight:bold;padding-top:10px;">TK: {{ $order_data->collection }}</p>
            <p style="padding-left:100px;font-weight:bold;">{{ $order_data->customer_phone }}</p>
            <p style="padding-left:100px;">{{ $order_data->customer_address }}</p>
        </div>
        <div style=" border: 1px solid black;width:270px;float:left;">

            <p style="font-weight:bold;float:left;padding-left:5px;padding-top:5px;">Tracking ID: &nbsp</p>
            <p style="padding-top:5px;"> {{ $order_data->tracking_id }}</p>
        </div>
        <div style=" border: 1px solid black;width:450px;">

            <p style="float:left;font-weight:bold;padding-left:5px;padding-top:5px;">Area: &nbsp</p>
            <p style="padding-top:5px;">{{ $order_data->area }}</p>
        </div>
        <div
            style="border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;width:450px;height:50px;">
            <p style="float:left;font-weight:bold;padding-left:5px;padding-top:10px;">Remarks:&nbsp</p>
            <p style="padding-top:10px;">{{ $order_data->remarks }}</p>
        </div>

        <div
            style="border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;width:110px;height:125px;float:left;">
            <br />
            <p style="text-align:center;">{!! QrCode::size(90)->generate($order_data->tracking_id) !!}</p>

        </div>
        <div style=" border-right: 1px solid black;width:340px;height:85px;float:left;">
            <div style="padding-left:30px;padding-top:20px;">

                @php
                    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                @endphp

                <img
                    src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($order_data->tracking_id, $generatorPNG::TYPE_CODE_128)) }}">






            </div>

            <p style="text-align:center;  letter-spacing: 2px;
                "> {{ $order_data->tracking_id }}</p>

        </div>

        <div
            style=" border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;width:340px;height:40px;float:left;">
            <p style="font-weight:bold;padding-left:50px;padding-top:10px;float:left;">Created date:&nbsp</p>
            <p style="padding-top:10px;"> {{ $order_data->created_at->format('d-m-Y') }}</p>

        </div>






    </div>

</body>

</html>
