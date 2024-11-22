{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/bootstrap.min.css">

    <link href='https://fonts.googleapis.com/css?family=Amiri' rel='stylesheet'>
    <style>
        body {
            font-family: 'Amiri';
            font-size: 17px;
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

        @foreach ($company as $com)
            <div class="text" style="width:380px; text-align:center;">
                <b style="font-size:28px;">{{ $com->name }}</b>
             <br>Mobile No.: {{ $com->mobile }}
             

            </div>
        @endforeach

        <div style=" border: 1px solid black;width:390px;">


            <p style="float:left;padding-left:10px font-weight:bold;padding-top:10px;
      ">MERCHANT:</p>
            <p style="padding-left:100px;font-weight:bold;padding-top:10px;">{{ $merchant_name }}</p>
           
            <p style="padding-left:100px;">{{ $merchant_data->mobile ?? '' }}</p>


        </div>
        <div style="border-left: 1px solid black;border-right: 1px solid black;width:390px;height:120px;">


           
            <p style="float:left;padding-left:5px;font-weight:bold;padding-top:10px;">CUSTOMER:</p>
            <p style="padding-left:15px;float:left;padding-right:180px;font-weight:bold;padding-top:10px;">
                {{ $order_data->customer_name }}
            </p>


            <p style="padding-left:100px;font-weight:normal;">{{ $order_data->customer_phone }}</p>
            <p style="padding-left:0px;">{{ $order_data->customer_address }}</p>
            
        </div>
        <div
            style="border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;width:390px;height:50px;">
            <p style="float:left;font-weight:bold;padding-left:5px;padding-top:10px;">Area: &nbsp</p>
            <p style="padding-top:10px;">{{ $order_data->area ?? '' }} &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
           <b> HUB:</b> {{ $order_data->zone_info->zone_name ?? '' }}
            </p>
        </div>

        <div
            style="border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;width:390px;height:50px;">

            <p style="float:left;font-weight:bold;padding-left:5px;padding-top:10px;">Amount: &nbsp</p>
            <p style="padding-top:10px;">{{ $order_data->collection }} &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<b> Order ID:</b> &nbsp{{ $order_data->order_id }}</p>
        

        </div>
        <div
            style="border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;width:390px;height:50px;">
            <p style="float:left;font-weight:bold;padding-left:5px;padding-top:10px;">Remarks:&nbsp</p>
            <p style="padding-top:10px;">{{ $order_data->remarks }}</p>
        </div>

        <div
            style="border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;width:110px;height:125px;float:left;">
            <br />
            <p style="text-align:center;">{!! QrCode::size(90)->generate($order_data->tracking_id) !!}</p>

        </div>
        <div style=" border-right: 1px solid black;width:280px;height:85px;float:left;">
            <div style="padding-left:20px;padding-top:20px;">

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
            style=" border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;width:280px;height:40px;float:left;">
            <p style="font-weight:bold;padding-left:50px;padding-top:10px;float:left;">Created date:&nbsp</p>
            <p style="padding-top:10px;"> {{ $order_data->created_at->format('d-m-Y') }}</p>

        </div>
        <br>
        



    </div>

</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <link href="https://fonts.googleapis.com/css?family=Amiri" rel="stylesheet" />
    <style>
        body {
            font-family: "Amiri";
            font-size: 17px;
        }

        @media print {
            @page {
                size: auto;
            }
        }

        .receipt_wrapper_single {
            margin: 40px 0px;
        }

        .design_wrapper {
            height: 400px;
            width: 380px;
            /* overflow: hidden; */
        }

        .company_info {
            text-align: center;
            width: 380px;
        }

        .company_info h3 {
            font-weight: 600;
            margin-bottom: 0px;
        }

        .receipt_wrapper {
            border: 1px solid black;
        }

        .merchant_info p {
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .merchant_info p:first-child {
            font-weight: 600;
        }

        .merchant_info_wrapper {
            border: 1px solid black;
        }

        .customer_info_wrapper {
            border: 1px solid black;
            min-height: 120px;
        }

        p {
            margin: 0px;
        }

        .fw-600 {
            font-weight: 500;
        }

        .my-fw-bold {
            font-weight: 600;
        }

        .customer_address_wrapper {
            border: 1px solid black;
        }

        .customer_order_info_wrapper {
            border: 1px solid black;
        }

        .customer_order_info_wrapper .col-lg-6 {
            width: auto !important;
        }


        .remarks_wrapper {
            border: 1px solid black;
        }

        .qr_code_wrapper {
            border: 1px solid black;
        }

        .label {
            font-weight: 600;
        }

        .customer_address_wrapper .col-lg-6 {
            width: 50%;
        }

        .customer_order_info_wrapper .col-lg-6 {
            width: 50%;
        }

        .qr_code img {
            height: 100px;
            width: 100px;
        }

        .bar_code img {
            height: 50px;
            width: 250px;
            object-fit: contain;
        }

        .qr_code_wrapper .col-lg-6 {
            width: auto;
        }

        .bar_code_wrapper {
            height: 102px;
            width: 75% !important;
        }

        .bar_code {
            /* border: 1px solid black; */
            padding: 2px 10px;
            display: flex;
            justify-content: center;
        }

        .qr_code_wrapper .qr_code {
            border: 1px solid black;
        }

        .created_date {
            /* border: 1px solid black; */
            text-align: center;
            border-bottom: none;
        }
    </style>
</head>



<body onload="window.print()">

    <div class="container-fluid">
        <div class="receipt_wrapper_single">
            @foreach ($company as $com)
                <div class="company_info">
                    <h3>{{ $com->name }}</h3>
                    <p>Mobile No: {{ $com->mobile }}</p>
                </div>
            @endforeach
            <div class="design_wrapper">
                <div class="receipt_wrapper">
                    <div class="d-flex justify-content-start px-2 py-1 merchant_info_wrapper gap-3">
                        <div class="col-lg-6">
                            <p class="label">Merchant:</p>
                        </div>
                        <div class="col-lg-6 merchant_info">
                            <p>{{ $merchant_name }}</p>
                            <p>{{ $merchant_data->mobile ?? '' }}</p>
                        </div>
                    </div>
                    <div class="customer_info_wrapper">
                        <div class="d-flex justify-content-start gap-3 px-2">
                            <div class="col-lg-6">
                                <p class="label">Customer Name:</p>
                            </div>
                            <div class="col-lg-6">
                                <p class="my-fw-bold"> {{ $order_data->customer_name }}</p>

                            </div>
                        </div>
                        <div class="d-flex justify-content-start gap-3 px-2">
                            <div class="col-lg-6">
                                <p class="label">Customer Phone:</p>
                            </div>
                            <div class="col-lg-6">
                                <p>{{ $order_data->customer_phone }}</p>
                            </div>
                        </div>
                        <p class="px-2" style="line-height: 20px">
                            {{ $order_data->customer_address }}
                        </p>
                    </div>
                    <div class="customer_address_wrapper">
                        <div class="d-flex justify-content-between align-items-center px-2 py-1">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center gap-1">
                                    <p class="label">Area:</p>
                                    <p class="fw-600">{{ $order_data->area ?? '' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center gap-1">
                                    <p class="label">Hub:</p>
                                    <p class="fw-600">{{ $zone_name->name ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="customer_order_info_wrapper">
                        <div class="d-flex justify-content-between align-items-center px-2 py-1">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center justify-content-start gap-1">
                                    <p class="label">Amount:</p>
                                    <p class="fw-600">{{ $order_data->collection }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center gap-1">
                                    <p class="label">Order ID:</p>
                                    {{-- <p class="fw-600">{{ $order_data->order_id }}</p> --}}
                                    <p class="fw-600">Aliquam dicta,sdsfd 120020</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="remarks_wrapper">
                        <div class="d-flex justify-content-between align-items-center px-2 py-1">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center gap-1">
                                    <p class="label">Remarks:</p>
                                    <p class="fw-600">{{ $order_data->remarks }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qr_code_wrapper">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="col-lg-6 qr_code">

                                <p style="text-align:center;padding:5px;">{!! QrCode::size(90)->generate($order_data->tracking_id) !!}</p>
                            </div>
                            <div class="col-lg-6 bar_code_wrapper">
                                <div class="bar_code d-flex flex-column">
                                    @php
                                        $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                                    @endphp

                                    <img
                                        src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($order_data->tracking_id, $generatorPNG::TYPE_CODE_128)) }}">

                                    <p class="m-0 text-center fw-bold">{{ $order_data->tracking_id }}</p>
                                </div>
                                <p class="created_date">
                                    <span class="my-fw-bold">Created Date:
                                    </span>{{ $order_data->created_at->format('d-m-Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
