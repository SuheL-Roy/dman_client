<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Amvines logistic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Poppins&family=Roboto:wght@400;500&display=swap');

    body {
        line-height: 1.3em;
        min-width: 920px;
        text-align: center;
    }

    .history-tl-container {
        font-family: "Roboto", sans-serif;
        width: 50%;
        margin: auto;
        display: block;
        position: relative;
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
        border-left: 1px dashed #86D6FF;
        padding: 0 0 50px 30px;
        position: relative;
    }

    .history-tl-container ul.tl li:last-child {
        border-left: 0;
    }

    .history-tl-container ul.tl li::before {
        position: absolute;
        left: -18px;
        top: -5px;
        content: " ";
        border: 8px solid rgba(255, 255, 255, 0.74);
        border-radius: 500%;
        background: #258CC7;
        height: 20px;
        width: 20px;
        transition: all 500ms ease-in-out;

    }

    .history-tl-container ul.tl li:hover::before {
        border-color: #258CC7;
        transition: all 1000ms ease-in-out;
    }

    ul.tl li .item-title {
        width: 350px;
        font-size: 20px;
    }

    ul.tl li .item-detail {
        color: rgba(0, 0, 0, 0.5);
        font-size: 16px;
    }

    ul.tl li .timestamp {
        color: #414040;
        position: absolute;
        width: 120px;
        left: -50%;
        text-align: right;
        font-size: 20px;
    }


    .container h1 {
        text-align: center;
        color: purple;
    }

    .container-2 {
        background: rgb(227, 252, 255);
        /* border-top: 2px solid #120800; */
        border: 1px solid #fd7777;
        height: 150px;
        margin-right: 25%;
        margin-left: 25%;
        padding: 21px;

    }

    .container-3 {
        border-bottom: 2px solid #ffffff;
        border-left: 2px solid #ffffff;
        border-right: 2px solid #ffffff;
        height: 80px;
        margin-right: 35%;
        margin-left: 35%;
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
        text-align: right !important;
    }

    .right {
        float: right;
        text-align: left !important;
        background: red;

    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 40%;
        margin-left: auto;
        margin-right: auto;
    }


    th {
        border: 1px solid rgb(250, 218, 202);
        text-align: left;
        padding: 8px;

    }

    td {
        border: 1px solid rgb(250, 218, 202);
        text-align: left;
        padding: 8px;

    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<body>

    <div class="container" style="padding-top: 50px">
        <h1>Order Tracking with Status( <u>{{ $order_detail->tracking_id }}</u> )</h1>
        {{-- <h3 class="text">Trcking ID: {{ $order_detail->tracking_id }}</h3> --}}
        <h3><u>Booking Date: {{ $order_detail->created_at->format('d-m-Y') }}</u></h3>
    </div>

    {{-- @if (isset($tracking_data))
        <div class="container-2">
            <div class="left">
                <p class="text">Trcking ID: {{ $tracking_data->tracking_id }} </p>
                <p>Delivery Address: {{ $tracking_data->customer_address }}</p>
            </div>

            <div class="right">
                <p>Order created time: {{ $tracking_data->created_at->format('d-m-Y') }}</p>
                <p>Customer Address: {{ $tracking_data->customer_address }}</p>
            </div>
        </div>
        <div class="container-2">
            <div class="left">
                <p class="text">Merchant Name: {{ $tracking_data->merchant_name }} </p>
                <p>Shop Name: {{ $tracking_data->shop }}</p>
            </div>

            <div class="right">
                <p>Product Title: {{ $tracking_data->customer_name }}</p>
                <p>Customer Address: {{ $tracking_data->customer_address }}</p>
            </div>
        </div> --}}
    {{-- <div class="container-2">
            <div class="left">
                <p class="text">Merchant Name: {{ $tracking_data->merchant_name }} </p>
                <p>Shop Name: {{ $tracking_data->shop }}</p>
            </div>

            <div class="right">
                <p>Customer Name: {{ $tracking_data->customer_name }}</p>
                <p>Customer Address: {{ $tracking_data->customer_address }}</p>
            </div>
        </div> --}}
    {{-- @else --}}
    <!--<div style="padding:5px;">-->
    <!--<h6 class="" style="text-align:center;"><b>Trackind Data not found!</b></h6>-->


    <!--</div>-->
    <table>

        <tr>
            <th>Customer Name</th>
            <td>{{ $order_detail->customer_name }}</td>

        </tr>
        <tr>
            <th>Customer Phone</th>
            <td>{{ $order_detail->customer_phone }}</td>

        </tr>
        <tr>
            <th>Shop Name</th>
            <td>{{ $order_detail->shop_name }}</td>

        </tr>
        <tr>
            <th>Shop Address</th>
            <td>{{ $order_detail->shop_address }}</td>

        </tr>
        <tr>
            <th>Product weight</th>
            <td>{{ $order_detail->weight }}</td>

        </tr>
        <tr>
            <th>Product</th>
            <td>{{ $order_detail->product }}</td>

        </tr>
        <tr>
            <th>Invoice Value</th>
            <td>{{ $order_detail->collection }}</td>

        </tr>
    </table>


    {{-- @endif --}}
    <h1><u style="margin-left: -200px"> Current Status </u></h1>

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
                                ({{ $order_status->user->mobile }})
                            @endif
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

</body>

</html>
