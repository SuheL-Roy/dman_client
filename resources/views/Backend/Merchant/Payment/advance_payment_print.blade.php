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




        {{-- <h4> From: {{ $transfer->sender->address }} &nbsp; To: {{ $transfer->receiver->address }} </h4>
        <h4> Rider: {{ $transfer->media->name }} </h4> --}}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Business Name</th>
                <th>M. Name</th>
                <th>M. Phone</th>
                <th>M. Address</th>
                <th>M. Area</th>
                <th>Paid Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $key => $paymentinfo)
                <tr>
                    <td>{{ $key + 1 }}.</td>
                    <td>{{ $paymentinfo->business_name }}.</td>
                    <td>{{ $paymentinfo->name }}</td>
                    <td>{{ $paymentinfo->mobile }}</td>
                    <td>{{ $paymentinfo->address }}</td>
                    <td>{{ $paymentinfo->area }}</td>
                    <td>{{ $paymentinfo->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
