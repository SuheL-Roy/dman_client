<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/bootstrap.min.css">
    <style type="text/css">
        @media print {
            @page {
                size: auto;
            }
        }
    </style>

</head>

<body onload="window.print();window.history.back()">
    <div style="text-align:center;">
        @foreach ($company as $data)
            <h2>{{ $data->name }}</h2>
            <h4>Address : {{ $data->address }} &nbsp; Mobile : {{ $data->mobile }}</h4>
        @endforeach
        <h4><u>Branch Wise Employee Attendance Report</u></h4>
        <h5> Date : {{ Carbon\Carbon::parse($todate)->format('d-m-Y') }}</h5>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>

                <th data-field="sl">SL.</th>
                <th style="text-align: center;"data-field="sl">Employee No</th>
                <th style="text-align: center;" data-field="rider" data-editable="false">Employee Name</th>
                <th style="text-align: center;" data-field="shop_name" data-editable="false">Designation</th>
                <th style="text-align: center;"data-field="customer_name" data-editable="false">Mobile</th>
                <th style="text-align: center;" data-field="customer_phone" data-editable="false">Branch</th>
                <th style="text-align: center;" data-field="customer_address" data-editable="false">Status</th>
                <th style="text-align: center;" data-field="note" data-editable="false">Intime</th>
                <th style="text-align: center;"data-field="status" data-editable="false">OutTime</th>

            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($branch_wise_attendance as $key => $item)
                <tr>

                    <td>{{ $key + 1 }}.</td>
                    <td style="text-align: center;"class="user-id">{{ $item->user_id }}</td>
                    <td style="text-align: center;" class="rider-name">{{ $item->name }}</td>
                    <td style="text-align: center;"class="mobile">{{ $item->type }}</td>
                    <td style="text-align: center;"class="mobile">{{ $item->mobile }}</td>
                    <td style="text-align: center;" class="area">{{ $item->area }}</td>
                    <td style="text-align: center;" class="area">{{ $item->status }}</td>

                    @if ($item->in_time == null)
                        <td style="text-align: center;">-----</td>
                    @else
                        <td style="text-align: center;" style="width: 150px;">
                            {{ \Carbon\Carbon::parse($item->in_time)->format('h:i A') }}</td>
                    @endif


                    @if ($item->out_time == null)
                        <td style="text-align: center;">-----</td>
                    @else
                        <td style="text-align: center;" style="width: 150px;">
                            {{ \Carbon\Carbon::parse($item->out_time)->format('h:i A') }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="navbar-fixed-bottom">
        <div style="float:left;">
            @foreach ($company as $data)
                Printed By : {{ $data->name }}
            @endforeach
        </div>
        <div style="float:right;">
            <?php echo 'Date & Time : ' . date('D, d M Y h:i:s a'); ?>
        </div>
    </div>
</body>

</html>
