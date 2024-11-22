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

    <div class="container-1 mt-20" style="text-align: center; margin-top: 15px;">
        <img style="width:327px;height:126px;" src="{{ asset($company->logo) }}">
        <h4 class="mt-1">Address: {{ $company->address }} </h4>
        <h4>Mobile: {{ $company->mobile ?? 'NULL' }}</h4>




        {{-- <h4> From: {{ $transfer->sender->address }} &nbsp; To: {{ $transfer->receiver->address }} </h4>
        <h4> Rider: {{ $transfer->media->name }} </h4> --}}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Tracking Id</th>
                <th>Rider Name</th>
                <th>Marchent Name</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Customer Address</th>
                <th>Status</th>
                <th>Invoice Value</th>
                <th>Collected Amount</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($order as $data)
                <tr>
                    {{-- <td></td> --}}
                    <td>{{ $i++ }}.</td>
                    <td>{{ $data->tracking_id }}</td>
                    <td>{{ $data->rider_name }}</td>
                    <td>{{ $data->business_name }}</td>
                    {{-- <td>{{ $data->shop }}</td> --}}


                    <td>{{ $data->customer_name }}</td>
                    <td>{{ $data->customer_phone }}</td>
                    <td>{{ $data->customer_address }}</td>
                    <td>{{ $data->delivery_note }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ $data->collection }}</td>
                    <td>{{ $data->collect ?? 0 }}</td>

                    {{-- <td class="datatable-ct">
                    <a href="{{ route('delivered.order.status',
                        ['id'=>$data->tracking_id])}}" 
                        class="btn btn-info btn-xs"
                        onclick="return confirm('Are You Sure ??')"
                        title="Reached In Destination Hub ??">
                        <i class="fa fa-check-circle"></i>
                    </a>
                </td> --}}
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="text-align:right; "><b>Total Collected Amount:</b>
                    &nbsp;</td>
                {{--  <td> &nbsp;&nbsp; {{ $tCol }}</td>  --}}
                <td style="font-weight: 800"> &nbsp;&nbsp; {{ $total }}</td>

            </tr>
        </tfoot>
    </table>

</body>

</html>
 