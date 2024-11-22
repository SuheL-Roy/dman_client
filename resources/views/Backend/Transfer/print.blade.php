<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style type="text/css">
        @media print {
            @page {
                size: auto;
            }
        }
    </style>

</head>

<body onload="window.print();">
    <br>

    <div class="container-1 mt-5" style="text-align: center; margin-top: 15px;">
        <img style="width:327px;height:126px;" src="{{ asset($company->logo) }}">
        <h4 class="mt-1">Address: {{ $company->address }} </h4>
        <h4>Mobile: {{ $company->mobile ?? 'NULL' }}</h4>




        <h4> From: {{ $transfer->sender->address }} &nbsp; To: {{ $transfer->receiver->address }} </h4>
        <h4> Rider: {{ $transfer->media->name }} </h4>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th data-field="sl">SL.</th>
                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                <th data-field="s_name" data-editable="false">Merchnat Name</th>
                <th data-field="s_phone" data-editable="false">Merchnat Phone</th>
                <th data-field="s_address" data-editable="false">Merchnat Address</th>
                <th data-field="c_name" data-editable="false">Customer Name</th>
                <th data-field="c_phone" data-editable="false">Customer Phone</th>
                <th data-field="c_address" data-editable="false">Customer Address</th>
                <th data-field="type" data-editable="false">Delivery Type</th>
                <th data-field="partial" data-editable="false">Partial</th>
                <th data-field="collection" data-editable="false">Collection</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trackingDetails as $key => $tracking)
                <tr>
                    <td>{{ $key + 1 }}.</td>
                    <td> {{ $tracking->tracking_id }} </td>
                    <td> {{ $tracking->business_name }} </td>
                    <td> {{ $tracking->mobile }} </td>
                    <td> {{ $tracking->address }} </td>
                    <td> {{ $tracking->customer_name }} </td>
                    <td> {{ $tracking->customer_phone }} </td>
                    <td> {{ $tracking->customer_address }} </td>
                    <td> {{ $tracking->type == 'Urgent' ? 'One Hour' : 'Regular' }} </td>
                    <td> {{ $tracking->isPartial == 0 ? 'Not Avaiable' : 'Avaiable' }} </td>
                    <td> {{ $tracking->colection }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
