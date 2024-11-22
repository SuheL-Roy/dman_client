
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Order Details</title>
        <meta name="viewport" content="width=device-width,  user-scalable=no">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Poppins&family=Roboto:wght@400;500&display=swap');

        body {
            line-height: 1.3em;
            min-width: 1440px;
            text-align: center;
        }

        .history-tl-container {
            font-family: "Roboto"xfdd, sans-serif;
            width: 50%;
            margin: auto;
            display: block;
            position: relative;
            backgroud: #f5f5f5;
        }

        .history-tl-container ul.tl {
            margin: 20px 0;
            padding: 0;
            display: inline-block;

        }

        .history-tl-container ul.tl li {
            list-style: none;
            margin: auto;
            margin-left: 200px;
            min-height: 50px;
            /*background: rgba(255,255,0,0.1);*/
            border-left: 1px dashed #aa0879;

            padding: 0 0 50px 30px;
            position: relative;
        }

        .history-tl-container ul.tl li:last-child {
            border-left: 0;
        }

        .history-tl-container ul.tl li::before {
            position: absolute;
            left: -11px;
            top: -5px;
            content: " ";
            border: 2px solid rgba(255, 255, 255, 0.74);
            border-radius: 500%;
            background: #b30699;
            height: 30px;
            width: 30px;
            transition: all 500ms ease-in-out;

        }

        .history-tl-container ul.tl li:hover::before {
            border-color: #8d0454;
            transition: all 1000ms ease-in-out;
        }

        ul.tl li .item-title {
            width: 220px;
            text-align: start;
            font-size: 1.3rem;
        }

        ul.tl li .item-detail {
            color: rgba(0, 0, 0, 0.5);
            font-size: .9rem;
            text-align: start;
        }

        ul.tl li .timestamp {
            color: #000000;
            position: absolute;
            width: 100px;
            left: -60%;
            text-align: right;
            font-size: 17px;
            background: #ffe2ff;
            padding: 5px;
        }


        .container-1 h1 {
            text-align: center;
            color: purple;
        }

        .container-1 a img {
            margin-top: 5px;

        }

        .container-2 {
            border: 2px solid #f5ae70;
            height: 80px;

            padding: 5px;
        }

        .container-2 p {
            text-align: left;
            margin-top: 5%;
            color: black;
        }

        .container-2 .p1 {
            text-align: right;
            margin-top: 1%;
            color: #8D8D8D;
        }

        .container-3 {
            margin-top: -3%;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        td {
            text-align: left;
        }

        th {
            text-align: left;
        }

        td img {
            width: 160px;
            height: 160px;
        }

        .text h2 {
            color: purple;
        }
    </style>

    <body style="background-color:#f5f5f5;">

        <div class="container" style="background-color:#f5f5f5;">
            <div class="row">
                <div class="col-8 offset-1">
                    <div class="container-1 mt-5">
                        <img style="width:450px;height:180px;" src="{{ asset($company->logo) }}">

                        <h4 class="mt-1">Address: {{ $company->address }}</h4>
                        <h4>Mobile: {{ $company->mobile }}</h4>
                        <h5 class="mt-5"><u> Order Details ({{ $tracking_id }})</u></h5>

                        <a href="{{ route('order.invoice.view', ['id' => $tracking_id]) }}"> <i
                                class="fa fa-print"></i>
                        </a>




                        <h5></h5>

                    </div>
                    <div class="container">
                        <table class="table table-bordered mt-5">
                            <tbody>


                                <tr>
                                    {{-- <th class="">Shop Name</th>
                                    <td>{{ $data->shop }}</td> --}}
                                    <th class="text-left">Merchant Name</th>
                                    <td class="text-left"> {{ $data->merchant }} </td>
                                    <th class="">Customer Phone</th>
                                    <td>{{ $data->customer_phone }}</td>
                                </tr>

                                <tr>
                                    {{-- <th class="">Shop Phone</th>
                                    <td>{{ $data->shop_info->shop_phone??"" }}</td> --}}
                                    <th class="">Customer Address</th>
                                    <td>{{ $data->customer_address }}</td>
                                    <th class="text-left">Customer Name</th>
                                    <td class="text-left">{{ $data->customer_name }}</td>
                                </tr>
                                {{-- <tr>
                                    <th class="">Shop address</th>
                                    <td>{{ $data->shop_info->shop_address??"" }}</td> 
                                    <th class="">Pickup Time</th>
                                    <td>{{ $data->pickup_time }}</td>
                                </tr> --}}

                               
                                <tr>
                                    <th class="">Order Type</th>
                                    <td>{{ $data->type == 'Urgent' ? 'One Hour' : 'Regular' }}</td>
                                    <th class="">Weight</th>
                                    <td>{{ $data->weight }}</td>
                                 

                                </tr>
                                <tr>
                                    {{-- <th class="">Product Type</th>
                                    <td>{{ $data->product }}</td> --}}

                                    <th class="">Collection</th>
                                    <td>{{ $data->collection }}Tk</td>
                                    <th class="">Delivery Charge</th>
                                    <td>{{ $data->delivery }}Tk</td>

                                </tr>
                                {{-- <tr>
                                   
                                    <th class="">Partial Delivery</th>
                                    <td>{{ $data->isPartial ? 'Available' : 'Not Available' }}</td>
                                </tr> --}}
                                <tr>
                                    {{--  <th>Signature Image</th> --}}
                                    {{--   @if ($data->signature_image != null)
                        <td><img src="/public/order_photo/signature_image/{{ $data->signature_image  }}"></td>
                        @else
                        <td><img src="https://apksos.com/storage/images/com/risad/creativesoftware/amvines/com.risad.creativesoftware.amvines_1.png">
                        @endif
                        <th class="">Confirm Image</th>
                        @if ($data->confirm_image != null)
                        <td><img src="/public/order_photo/confirm_image/{{ $data->confirm_image  }}"></td>
                        @else
                        <td><img src="https://apksos.com/storage/images/com/risad/creativesoftware/amvines/com.risad.creativesoftware.amvines_1.png">
                        @endif --}}
                                </tr>


                            </tbody>
                        </table>
                    </div>


                    <div class="text">
                        <h2>Order Tracking</h2>
                    </div>

                    <div class="history-tl-container">
                        <ul class="tl">
                            @foreach ($order_statuses as $order_status)
                                <li class="tl-item" ng-repeat="item in retailer_history">
                                    <div class="timestamp">
                                        {{ $order_status->created_at->format('d-m-Y') }} <br>
                                        {{ $order_status->created_at->format('h:i') }}
                                    </div>
                                    <div class="item-title"> {{ $order_status->status }} </div>
                                    @if ($order_status->user)
                                        <div class="item-detail"> {{ $order_status->user->name }} @if ($order_status->user->role == 10)
                                                {{-- ({{ $order_status->user->mobile }}) --}}
                                            @endif
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </body>

    </html>

