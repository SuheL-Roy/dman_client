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

    <div class="container-1 mt-5" style="text-align: center; margin-top: 20px;">
        <img style="width:327px;height:126px;" src="{{ asset($company->logo) }}">
        <h4 class="mt-1">Address: {{ $company->address }} </h4>
        <h4>Mobile: {{ $company->mobile ?? 'NULL' }}</h4>
        <h5>Branch Name: {{ $details->area ?? 'NULL' }}</h5>
        <h5> Date: {{ Carbon\Carbon::parse($details->form_date)->format('d-m-Y') }} -
            {{ Carbon\Carbon::parse($details->todate)->format('d-m-Y') }}</h5>
        <h5>Branch Invoice: {{ $details->invoice_id ?? 'NULL' }}</h5>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Create Date</th>
                <th>Tracking ID</th>
                {{-- <th> Name</th> --}}
                <th> PickUp Comission</th>
                <th> Delivery Comission</th>
                <th> PickUp Comission</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $payment)
                <tr>
                    <td> {{ $key + 1 }} </td>
                    <td> {{ $payment->created_at->format('d-m-Y') }} </td>
                    <td> {{ $payment->tracking_id }} </td>
                    {{-- <td> {{ $payment->business_name }} </td> --}}

                    @if ($payment->status == 'Pickup Done')
                        <td> {{ $payment->a_pickup_charge }}</td>
                    @else
                        <td>0</td>
                    @endif
                    @if ($payment->status == 'Successfully Delivered')
                        <td> {{ $payment->a_delivery_charge }}</td>
                    @else
                        <td>0</td>
                    @endif

                    <td> {{ $payment->a_return_charge }} </td>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:right;">Total: &nbsp;</td>



                <td> &nbsp;&nbsp; {{ $total_pickup_charge }}</td>
                <td> &nbsp;&nbsp; {{ $total_delivery_charge }}</td>
                <td> &nbsp;&nbsp; {{ $total_return_charge }}</td>



            </tr>
            <tr>
                <td colspan="5" style="text-align:right;">SubTotal: &nbsp;</td>


                <td> &nbsp;{{ $total_pickup_charge + $total_delivery_charge + $total_return_charge }}</td>





            </tr>
        </tfoot>
    </table>



</body>

</html>
