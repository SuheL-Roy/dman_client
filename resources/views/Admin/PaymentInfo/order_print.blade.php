<!DOCTYPE html>
<html lang="en">
    <head>
        
        <style type="text/css">
            #invoice-POS {
                 padding: 2mm;
                 margin: 0 auto;
                 width: 44mm;
                 background: #fff;
            }
            #invoice-POS ::selection {
                 background: #f31544;
                 color: #fff;
            }
             #invoice-POS ::moz-selection {
                 background: #f31544;
                 color: #fff;
            }
             #invoice-POS h1 {
                 font-size: 1.5em;
                 color: #222;
            }
             #invoice-POS h2 {
                 font-size: 0.9em;
            }
             #invoice-POS h3 {
                 font-size: 1.2em;
                 font-weight: 300;
                 line-height: 2em;
            }
             #invoice-POS p {
                 font-size: 0.7em;
                 color: #666;
                 line-height: .8em;
            }
             #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
                /* Targets all id with 'col-' */
                 border-bottom: 1px solid #eee;
            }
            #invoice-POS #top {
                 min-height: 20px;
            }
            #invoice-POS #mid {
                 min-height: 80px;
            }
            #invoice-POS #bot {
                 min-height: 50px;
            }
            #invoice-POS .info {
                 display: block;
                 margin-left: 0;
            }
            #invoice-POS .title {
                 float: right;
            }
            #invoice-POS .title p {
                 text-align: right;
            }
            #invoice-POS table {
                 width: 100%;
                 border-collapse: collapse;
            }
            #invoice-POS .tabletitle {
                 font-size: 0.5em;
                 background: #eee;
            }
            #invoice-POS .service {
                 border-bottom: 1px solid #eee;
            }
            #invoice-POS .item {
                 width: 24mm;
            }
            #invoice-POS .itemtext {
                 font-size: 0.5em;
            }
            #invoice-POS #legalcopy {
                 margin-top: 5mm;
            }
        </style>
    </head>
    {{--  <body onload="window.print();window.history.back()">  --}}
    <body onload="window.print();" style="width: 10%">
        <div id="invoice-POS">
            <center id="top">
                <div class="info"> 
                    @foreach ($company as $data)
                        <h2>{{ $data->name }}</h2><br>
                        <p>{{ $data->address }} </p>
                        <p>{{ $data->mobile }}</p>
                    @endforeach
                </div><!--End Info-->
            </center><!--End InvoiceTop-->
            <div id="mid">
                <div class="info">
                    <h2>Info</h2> 
                    <p>Merchant: {{ $datas->merchant }} </p>
                    <p>Phone: {{ $datas->merchant_no }} </p>
                    <p>Customer: {{ $datas->customer_name }} </p>
                    <p>Phone: {{ $datas->customer_phone }} </p>
                    <p>Date: {{ $datas->pickup_date }}</p> 
                </div>
            </div><!--End Invoice Mid-->
            <div id="bot">
                <div id="table">
                    <table>
                        <tr class="tabletitle">
                            <td class="item"><h2>Tracking ID</h2></td>
                            <td class="Hours"><h2>Weight</h2></td>
                            <td class="Rate"><h2>Collection</h2></td>
                        </tr>
                        <tr class="service">
                            <td class="tableitem"><p class="itemtext">{{ $datas->tracking_id }}</p></td>
                            <td class="tableitem"><p class="itemtext">{{ $datas->weight }}</p></td>
                            <td class="tableitem"><p class="itemtext">{{ $datas->collection }}Tk.</p></td>
                        </tr>
                    </table>
                </div><!--End Table-->
                <div id="legalcopy">
                    @foreach ($company as $data)
                        <p><b>Printed By :</b> Delivery Rx</p> 
                    @endforeach
                    <p><?php echo "<b>Date & Time :</b>" . date("D, d M Y h:i:s a"); ?></p>
                </div>
            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->
    </body>
</html>


